<?php
declare(strict_types=1);
ob_start(); // buffer all output to ensure JSON responses even on warnings

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
ini_set('display_errors','0');
ini_set('html_errors','0');

// Always respond with JSON (avoid HTML xdebug pages / mysqli exceptions)
if(function_exists('mysqli_report')){
  mysqli_report(MYSQLI_REPORT_OFF);
}

function respond(array $data, int $code = 200): void {
  while(ob_get_level()>0){ @ob_end_clean(); }
  http_response_code($code);
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
  exit;
}

register_shutdown_function(function(){
  $e = error_get_last();
  if(!$e) return;
  $fatal = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR];
  if(!in_array($e['type'], $fatal, true)) return;

  while(ob_get_level()>0){ @ob_end_clean(); }
  if(!headers_sent()){
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
  }
  http_response_code(500);
  echo json_encode([
    'ok'=>false,
    'error'=>'Sunucu hatası (fatal).',
    'debug'=>[
      'type'=>$e['type'],
      'message'=>$e['message'],
      'file'=>basename((string)$e['file']),
      'line'=>$e['line']
    ]
  ], JSON_UNESCAPED_UNICODE);
});

set_error_handler(function($severity, $message, $file, $line){
  $serious = [E_USER_ERROR, E_RECOVERABLE_ERROR];
  if(in_array($severity, $serious, true)){
    respond(['ok'=>false,'error'=>'Sunucu hatası (PHP).','debug'=>[
      'type'=>$severity,'message'=>$message,'file'=>basename($file),'line'=>$line
    ]], 500);
  }
  return true;
});

set_exception_handler(function($e){
  respond(['ok'=>false,'error'=>'Sunucu hatası (PHP).','debug'=>[
    'type'=>get_class($e),'message'=>$e->getMessage(),'file'=>basename($e->getFile()),'line'=>$e->getLine()
  ]], 500);
});

// mbstring eklentisi bazı hostinglerde kapalı olabilir; fatal hatayı önlemek için güvenli yedekler.
if(!function_exists("mb_strlen")){ function mb_strlen($string, $encoding = null){ return strlen((string)$string); } }
if(!function_exists("mb_substr")){ function mb_substr($string, $start, $length = null, $encoding = null){ return $length === null ? substr((string)$string, (int)$start) : substr((string)$string, (int)$start, (int)$length); } }
if(!function_exists("mb_strtolower")){ function mb_strtolower($string, $encoding = null){ return strtolower((string)$string); } }

// PHP 7.x hosting uyumluluğu: PHP 8 string yardımcıları yoksa güvenli yedekleri kullan.
if(!function_exists('str_contains')){ function str_contains($haystack, $needle){ return $needle === '' || strpos((string)$haystack, (string)$needle) !== false; } }
if(!function_exists('str_starts_with')){ function str_starts_with($haystack, $needle){ return $needle === '' || strncmp((string)$haystack, (string)$needle, strlen((string)$needle)) === 0; } }
if(!function_exists('str_ends_with')){ function str_ends_with($haystack, $needle){ $needle=(string)$needle; if($needle==='') return true; $haystack=(string)$haystack; return substr($haystack, -strlen($needle)) === $needle; } }

function load_env(string $path): array {
  if(!file_exists($path)) return [];
  $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  $out = [];
  foreach($lines as $line){
    $line = trim($line);
    if($line === '' || (isset($line[0]) && ($line[0]==='#' || $line[0]===';'))) continue;
    $pos = strpos($line,'=');
    if($pos === false) continue;
    $k = trim(substr($line,0,$pos));
    $v = trim(substr($line,$pos+1));
    $out[$k] = $v;
  }
  return $out;
}

$ENV = load_env(__DIR__ . '/../.env');
$db_host = $ENV['DB_HOST'] ?? '127.0.0.1';
$db_port = (int)($ENV['DB_PORT'] ?? '3306');
$db_name = $ENV['DB_NAME'] ?? 'yearbook_db';
$db_user = $ENV['DB_USER'] ?? 'root';
$db_pass = $ENV['DB_PASS'] ?? '';
$token_ttl_days = (int)($ENV['TOKEN_TTL_DAYS'] ?? '3650');

$mysqli = @new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
if($mysqli->connect_errno){
  respond(['ok'=>false,'error'=>'Veritabanına bağlanılamadı. .env ve DB import kontrol et.','debug'=>[
    'errno'=>$mysqli->connect_errno,'message'=>$mysqli->connect_error
  ]], 500);
}
$mysqli->set_charset('utf8mb4');
ensure_tables($mysqli);

function json_body(): array {
  $raw = file_get_contents('php://input');
  if(!$raw) return [];
  $d = json_decode($raw, true);
  return is_array($d) ? $d : [];
}


if(!function_exists('badwords_list')){
// --- Bad words filter (server-side) + logging ---
function badwords_list(): array {
  static $cache = null;
  if($cache !== null) return $cache;
  $path = __DIR__ . '/badwords.txt';
  if(!file_exists($path)) return $cache = [];
  $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  $words = [];
  foreach($lines as $line){
    $line = trim($line);
    if($line === '' || (isset($line[0]) && $line[0] === '#')) continue;
    $words[] = mb_strtolower($line, 'UTF-8');
  }
  usort($words, fn($a,$b)=> mb_strlen($b,'UTF-8') <=> mb_strlen($a,'UTF-8'));
  return $cache = $words;
}

function censor_word(string $w): string {
  $len = mb_strlen($w, 'UTF-8');
  if($len <= 2) return str_repeat('*', $len);
  $first = mb_substr($w, 0, 1, 'UTF-8');
  $last  = mb_substr($w, $len-1, 1, 'UTF-8');
  return $first . str_repeat('*', max(0,$len-2)) . $last;
}

function censor_text(?string $text): ?string {
  if($text === null) return null;
  $bad = badwords_list();
  if(!$bad) return $text;

  $out = (string)$text;
  foreach($bad as $bw){
    $quoted = preg_quote($bw, '/');
    $pattern = '/(?<![\p{L}\p{N}])(' . $quoted . ')(?![\p{L}\p{N}])/iu';
    $out = preg_replace_callback($pattern, fn($m)=>censor_word($m[1]), $out);
  }
  return $out;
}

function config_censor_and_log_unused(mysqli $mysqli, ?string $text, int $user_id, string $context, ?int $target_id = null): ?string {
  $before = $text;
  $after = censor_text($text);
  if($before !== null && $after !== null && $before !== $after){
    // store truncated originals for safety
    $orig = mb_substr($before, 0, 2000, 'UTF-8');
    $cens = mb_substr($after, 0, 2000, 'UTF-8');
    $stmt = $mysqli->prepare("INSERT INTO badword_logs(user_id,context,target_id,original_text,censored_text) VALUES(?,?,?,?,?)");
    $stmt->bind_param("isiss", $user_id, $context, $target_id, $orig, $cens);
    @$stmt->execute();
  }
  return $after;
}
}

function auth_header(): ?string {
  $h = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;
  if(!$h && function_exists('apache_request_headers')){
    $headers = apache_request_headers();
    if(isset($headers['Authorization'])) $h = $headers['Authorization'];
  }
  return $h ? trim($h) : null;
}

function get_bearer_token(): ?string {
  $h = auth_header();
  if(!$h) return null;
  if(preg_match('/Bearer\s+(.+)/i', $h, $m)) return trim($m[1]);
  return null;
}

function random_token(): string {
  return bin2hex(random_bytes(32)); // 64 chars
}

function token_hash(string $token): string {
  return hash('sha256', $token);
}

function safe_user(array $u): array {
  return [
    'id'=>(int)($u['id'] ?? 0),
    'full_name'=>$u['full_name'] ?? '',
    'email'=>$u['email'] ?? '',
    'school'=>$u['school'] ?? null,
    'grad_year'=>isset($u['grad_year']) && $u['grad_year'] !== null && $u['grad_year'] !== '' ? (int)$u['grad_year'] : null,
    'bio'=>$u['bio'] ?? null,
    'instagram'=>$u['instagram'] ?? null,
    'phone'=>$u['phone'] ?? null,
    'photo_url'=>$u['photo_url'] ?? null,
    'is_admin'=>(int)($u['is_admin'] ?? 0),
    'admin_until'=>$u['admin_until'] ?? null,
    'profile_music_platform'=>$u['profile_music_platform'] ?? null,
    'profile_music_url'=>$u['profile_music_url'] ?? null,
    'created_at'=>$u['created_at'] ?? null,
    'cover_photo_url'=>$u['cover_photo_url'] ?? null,
    'verified_badge'=>(int)($u['verified_badge'] ?? 0),
    'city'=>$u['city'] ?? null,
    'current_stage'=>$u['current_stage'] ?? null,
    'class_label'=>$u['class_label'] ?? null,
    'dm_privacy'=>$u['dm_privacy'] ?? 'everyone',
    'dm_sidebar_alerts_enabled'=>(int)($u['dm_sidebar_alerts_enabled'] ?? 1),
    'admin_call_allowed'=>(int)($u['admin_call_allowed'] ?? 1),
    'admin_dm_muted_all'=>(int)($u['admin_dm_muted_all'] ?? 0),
    'profile_views_visibility'=>$u['profile_views_visibility'] ?? 'private',
    'account_privacy'=>$u['account_privacy'] ?? 'private',
  ];
}

function require_auth(mysqli $mysqli): array {
  $token = get_bearer_token();
  if(!$token) respond(['ok'=>false,'error'=>'Giriş gerekli.'], 401);
  $th = token_hash($token);
  $stmt = $mysqli->prepare("SELECT u.* FROM auth_tokens t JOIN users u ON u.id=t.user_id WHERE t.token_hash=? AND t.expires_at > NOW() LIMIT 1");
  $stmt->bind_param("s", $th);
  $stmt->execute();
  $res = $stmt->get_result();
  $row = $res ? $res->fetch_assoc() : null;
  if(!$row) respond(['ok'=>false,'error'=>'Token yok/geçersiz.'], 401);
  if((int)($row['is_banned'] ?? 0) === 1) respond(['ok'=>false,'error'=>'Bu hesap admin tarafından banlandı.'], 403);
  return $row;
}

function require_login(mysqli $mysqli): array {
  return require_auth($mysqli);
}

function ensure_tables(mysqli $mysqli): void {
  // Idempotent schema bootstrap/migration so the project works even if DB import was partial/old.
  $dbRes = $mysqli->query('SELECT DATABASE() AS d');
  $dbName = $dbRes ? ($dbRes->fetch_assoc()['d'] ?? '') : '';
  if(!$dbName){
    respond(['ok'=>false,'error'=>'Veritabanı seçili değil. DB_NAME kontrol et.'], 500);
  }

  $tableExists = function(string $t) use ($mysqli, $dbName): bool {
    $stmt = $mysqli->prepare('SELECT 1 FROM information_schema.tables WHERE table_schema=? AND table_name=? LIMIT 1');
    $stmt->bind_param('ss', $dbName, $t);
    $stmt->execute();
    $r = $stmt->get_result();
    return (bool)($r && $r->fetch_row());
  };
  $colExists = function(string $t, string $c) use ($mysqli, $dbName): bool {
    $stmt = $mysqli->prepare('SELECT 1 FROM information_schema.columns WHERE table_schema=? AND table_name=? AND column_name=? LIMIT 1');
    $stmt->bind_param('sss', $dbName, $t, $c);
    $stmt->execute();
    $r = $stmt->get_result();
    return (bool)($r && $r->fetch_row());
  };
  $q = function(string $sql) use ($mysqli): void {
    $ok = @$mysqli->query($sql);
    if($ok === false){
      respond(['ok'=>false,'error'=>'DB şema kurulumu başarısız.','debug'=>['sql'=>$sql,'db_error'=>$mysqli->error]], 500);
    }
  };

  if(!$tableExists('users')){
    $q("CREATE TABLE users (\n      id INT AUTO_INCREMENT PRIMARY KEY,\n      full_name VARCHAR(120) NOT NULL,\n      email VARCHAR(190) NOT NULL UNIQUE,\n      password_hash VARCHAR(255) NOT NULL,\n      school VARCHAR(190) NULL,\n      grad_year INT NULL,\n      bio TEXT NULL,\n      instagram VARCHAR(190) NULL,\n      phone VARCHAR(64) NULL,\n      photo_url VARCHAR(255) NULL,\n      is_admin TINYINT(1) NOT NULL DEFAULT 0,\n      profile_music_platform VARCHAR(16) NULL,\n      profile_music_url VARCHAR(255) NULL,\n      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('auth_tokens')){
    $q("CREATE TABLE auth_tokens (\n      id INT AUTO_INCREMENT PRIMARY KEY,\n      user_id INT NOT NULL,\n      token_hash CHAR(64) NOT NULL UNIQUE,\n      expires_at DATETIME NOT NULL,\n      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,\n      INDEX(user_id),\n      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('farewells')){
    $q("CREATE TABLE farewells (
      id INT AUTO_INCREMENT PRIMARY KEY,
      from_user_id INT NOT NULL,
      to_user_id INT NOT NULL,
      message TEXT NOT NULL,
      reply TEXT NULL,
      music_platform VARCHAR(16) NULL,
      music_url VARCHAR(512) NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP NULL DEFAULT NULL,
      INDEX(to_user_id),
      INDEX(from_user_id),
      FOREIGN KEY(from_user_id) REFERENCES users(id) ON DELETE CASCADE,
      FOREIGN KEY(to_user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('farewell_reactions')){
    $q("CREATE TABLE farewell_reactions (\n      id INT AUTO_INCREMENT PRIMARY KEY,\n      farewell_id INT NOT NULL,\n      user_id INT NOT NULL,\n      emoji VARCHAR(16) NOT NULL,\n      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,\n      UNIQUE KEY uniq_react (farewell_id,user_id,emoji),\n      FOREIGN KEY(farewell_id) REFERENCES farewells(id) ON DELETE CASCADE,\n      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('profile_views')){
    $q("CREATE TABLE profile_views (
      id INT AUTO_INCREMENT PRIMARY KEY,
      viewer_id INT NOT NULL,
      viewed_id INT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_view (viewed_id,viewer_id),
      INDEX(viewed_id),
      INDEX(viewer_id),
      FOREIGN KEY(viewer_id) REFERENCES users(id) ON DELETE CASCADE,
      FOREIGN KEY(viewed_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('legacy_messages')){
    $q("CREATE TABLE legacy_messages (\n      id INT AUTO_INCREMENT PRIMARY KEY,\n      user_id INT NOT NULL,\n      message TEXT NOT NULL,\n      reply_to INT NULL,\n      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,\n      INDEX(created_at),\n      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('legacy_polls')){
    $q("CREATE TABLE legacy_polls (\n      id INT AUTO_INCREMENT PRIMARY KEY,\n      user_id INT NOT NULL,\n      question VARCHAR(255) NOT NULL,\n      option_a VARCHAR(120) NOT NULL,\n      option_b VARCHAR(120) NOT NULL,\n      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,\n      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('legacy_poll_votes')){
    $q("CREATE TABLE legacy_poll_votes (\n      id INT AUTO_INCREMENT PRIMARY KEY,\n      poll_id INT NOT NULL,\n      user_id INT NOT NULL,\n      choice CHAR(1) NOT NULL,\n      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,\n      UNIQUE KEY uniq_vote (poll_id,user_id),\n      FOREIGN KEY(poll_id) REFERENCES legacy_polls(id) ON DELETE CASCADE,\n      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  $needUserCols = [
    'bio' => 'ALTER TABLE users ADD COLUMN bio TEXT NULL',
    'instagram' => 'ALTER TABLE users ADD COLUMN instagram VARCHAR(190) NULL',
    'phone' => 'ALTER TABLE users ADD COLUMN phone VARCHAR(64) NULL',
    'photo_url' => 'ALTER TABLE users ADD COLUMN photo_url VARCHAR(255) NULL',
    'is_admin' => 'ALTER TABLE users ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0',
    'admin_call_allowed' => 'ALTER TABLE users ADD COLUMN admin_call_allowed TINYINT(1) NOT NULL DEFAULT 1',
    'profile_music_platform' => 'ALTER TABLE users ADD COLUMN profile_music_platform VARCHAR(16) NULL',
    'profile_music_url' => 'ALTER TABLE users ADD COLUMN profile_music_url VARCHAR(255) NULL',
    'created_at' => 'ALTER TABLE users ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
  ];
  foreach($needUserCols as $col=>$sql){
    if(!$colExists('users',$col)) $q($sql);
  }

  $needFarewellCols = [
    'reply' => 'ALTER TABLE farewells ADD COLUMN reply TEXT NULL',
    'music_platform' => 'ALTER TABLE farewells ADD COLUMN music_platform VARCHAR(16) NULL',
    'music_url' => 'ALTER TABLE farewells ADD COLUMN music_url VARCHAR(512) NULL',
    'updated_at' => 'ALTER TABLE farewells ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL',
  ];
  if($tableExists('farewells')){
    foreach($needFarewellCols as $col=>$sql){
      if(!$colExists('farewells',$col)) $q($sql);
    }
  }


  if($tableExists('profile_views')){
    $needPvCols = [
      'viewer_id' => 'ALTER TABLE profile_views ADD COLUMN viewer_id INT NOT NULL',
      'viewed_id' => 'ALTER TABLE profile_views ADD COLUMN viewed_id INT NOT NULL',
      'created_at' => 'ALTER TABLE profile_views ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    ];
    foreach($needPvCols as $col=>$sql){
      if(!$colExists('profile_views',$col)) $q($sql);
    }
    // Backward-compat: if old column names exist, copy into new ones once
    if($colExists('profile_views','profile_user_id') && $colExists('profile_views','viewer_user_id')){
      // Only copy if new columns are empty-ish (best-effort)
      @$mysqli->query('UPDATE profile_views SET viewed_id = COALESCE(viewed_id, profile_user_id), viewer_id = COALESCE(viewer_id, viewer_user_id)');
    }
  }

  // --- New features schema (Psikoloğum, Streak, DM, Dedikodu, Polls compatibility) ---
  if(!$tableExists('psych_messages')){
    $q("CREATE TABLE psych_messages (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      role VARCHAR(16) NOT NULL, -- 'user' | 'assistant'
      content TEXT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX(user_id),
      INDEX(created_at),
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  if(!$tableExists('farewell_streaks')){
    $q("CREATE TABLE farewell_streaks (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_a INT NOT NULL,
      user_b INT NOT NULL,
      streak_count INT NOT NULL DEFAULT 0,
      pending_from INT NULL,
      last_mutual_at DATETIME NULL,
      expires_at DATETIME NULL,
      UNIQUE KEY uniq_pair (user_a,user_b),
      INDEX(user_a),
      INDEX(user_b),
      FOREIGN KEY(user_a) REFERENCES users(id) ON DELETE CASCADE,
      FOREIGN KEY(user_b) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  if(!$tableExists('quick_match_stats')){
    $q("CREATE TABLE quick_match_stats (
      user_id INT PRIMARY KEY,
      reject_count INT NOT NULL DEFAULT 0,
      locked_until DATETIME NULL,
      updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  if(!$tableExists('quick_match_requests')){
    $q("CREATE TABLE quick_match_requests (
      id INT AUTO_INCREMENT PRIMARY KEY,
      from_user_id INT NOT NULL,
      to_user_id INT NOT NULL,
      status VARCHAR(16) NOT NULL DEFAULT 'pending', -- pending|accepted|rejected
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      responded_at DATETIME NULL,
      UNIQUE KEY uniq_pending (from_user_id,to_user_id,status),
      INDEX(to_user_id),
      INDEX(from_user_id),
      FOREIGN KEY(from_user_id) REFERENCES users(id) ON DELETE CASCADE,
      FOREIGN KEY(to_user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  if(!$tableExists('dm_conversations')){
    $q("CREATE TABLE dm_conversations (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user1_id INT NOT NULL,
      user2_id INT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_pair (user1_id,user2_id),
      INDEX(user1_id),
      INDEX(user2_id),
      FOREIGN KEY(user1_id) REFERENCES users(id) ON DELETE CASCADE,
      FOREIGN KEY(user2_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  if(!$tableExists('dm_messages')){
    $q("CREATE TABLE dm_messages (
      id INT AUTO_INCREMENT PRIMARY KEY,
      conversation_id INT NOT NULL,
      sender_id INT NOT NULL,
      body TEXT NULL,
      photo_url VARCHAR(512) NULL,
      reply_to_id INT NULL,
      deleted_at DATETIME NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX(conversation_id),
      INDEX(created_at),
      FOREIGN KEY(conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE,
      FOREIGN KEY(sender_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  if(!$tableExists('dm_reactions')){
    $q("CREATE TABLE dm_reactions (
      id INT AUTO_INCREMENT PRIMARY KEY,
      message_id INT NOT NULL,
      user_id INT NOT NULL,
      emoji VARCHAR(16) NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_react (message_id,user_id,emoji),
      FOREIGN KEY(message_id) REFERENCES dm_messages(id) ON DELETE CASCADE,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  

// --- Follows (for DM gate / social graph) ---
if(!$tableExists('follows')){
  $q("CREATE TABLE follows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    follower_id INT NOT NULL,
    following_id INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_follow (follower_id, following_id),
    INDEX(follower_id),
    INDEX(following_id),
    FOREIGN KEY(follower_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(following_id) REFERENCES users(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  // --- Moderation/Admin tables ---
  if(!$tableExists('badword_logs')){
    $q("CREATE TABLE badword_logs (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      context VARCHAR(64) NOT NULL,
      target_id INT NULL,
      original_text TEXT NOT NULL,
      censored_text TEXT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX(user_id),
      INDEX(context),
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('reports')){
    $q("CREATE TABLE reports (
      id INT AUTO_INCREMENT PRIMARY KEY,
      reporter_id INT NOT NULL,
      target_type VARCHAR(32) NOT NULL,
      target_id INT NOT NULL,
      reason VARCHAR(255) NULL,
      status VARCHAR(16) NOT NULL DEFAULT 'open',
      handled_by INT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX(target_type,target_id),
      INDEX(reporter_id),
      FOREIGN KEY(reporter_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  // user sanctions
  if(!$colExists('users','is_banned')){
    $q("ALTER TABLE users ADD COLUMN is_banned TINYINT(1) NOT NULL DEFAULT 0");
  }
  if(!$colExists('users','mute_until')){
    $q("ALTER TABLE users ADD COLUMN mute_until DATETIME NULL DEFAULT NULL");
  }

    // DM admin delete support
  if($tableExists('dm_messages') && !$colExists('dm_messages','deleted_by_admin')){
    $q("ALTER TABLE dm_messages ADD COLUMN deleted_by_admin INT NULL DEFAULT NULL");
  }


  // --- Online users ---
  if(!$tableExists('online_users')){
    $q("CREATE TABLE online_users (
      user_id INT PRIMARY KEY,
      last_seen TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  // --- DM tables (if not present) ---
  if(!$tableExists('dm_conversations')){
    $q("CREATE TABLE dm_conversations (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_a INT NOT NULL,
      user_b INT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_pair (LEAST(user_a,user_b), GREATEST(user_a,user_b)),
      INDEX(user_a),
      INDEX(user_b),
      FOREIGN KEY(user_a) REFERENCES users(id) ON DELETE CASCADE,
      FOREIGN KEY(user_b) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('dm_messages')){
    $q("CREATE TABLE dm_messages (
      id INT AUTO_INCREMENT PRIMARY KEY,
      conversation_id INT NOT NULL,
      sender_id INT NOT NULL,
      body TEXT NULL,
      photo_url VARCHAR(512) NULL,
      reply_to_id INT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      deleted_at TIMESTAMP NULL DEFAULT NULL,
      deleted_by_admin INT NULL DEFAULT NULL,
      INDEX(conversation_id),
      INDEX(sender_id),
      FOREIGN KEY(conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE,
      FOREIGN KEY(sender_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('dm_reactions')){
    $q("CREATE TABLE dm_reactions (
      id INT AUTO_INCREMENT PRIMARY KEY,
      message_id INT NOT NULL,
      user_id INT NOT NULL,
      emoji VARCHAR(16) NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_dm_react (message_id,user_id,emoji),
      INDEX(message_id),
      FOREIGN KEY(message_id) REFERENCES dm_messages(id) ON DELETE CASCADE,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('dm_reads')){
    $q("CREATE TABLE dm_reads (
      id INT AUTO_INCREMENT PRIMARY KEY,
      conversation_id INT NOT NULL,
      user_id INT NOT NULL,
      last_seen_message_id INT NOT NULL DEFAULT 0,
      updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_read (conversation_id,user_id),
      INDEX(conversation_id),
      FOREIGN KEY(conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('dm_typing')){
    $q("CREATE TABLE dm_typing (
      id INT AUTO_INCREMENT PRIMARY KEY,
      conversation_id INT NOT NULL,
      user_id INT NOT NULL,
      expires_at DATETIME NOT NULL,
      UNIQUE KEY uniq_typing (conversation_id,user_id),
      INDEX(conversation_id),
      FOREIGN KEY(conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  // Gossip (Dedikodu)
  if(!$tableExists('gossip_posts')){
    $q("CREATE TABLE gossip_posts (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      visibility VARCHAR(16) NOT NULL DEFAULT 'global',
      school VARCHAR(190) NULL,
      content TEXT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX(user_id),
      INDEX(visibility),
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('gossip_comments')){
    $q("CREATE TABLE gossip_comments (
      id INT AUTO_INCREMENT PRIMARY KEY,
      post_id INT NOT NULL,
      user_id INT NOT NULL,
      content TEXT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX(post_id),
      FOREIGN KEY(post_id) REFERENCES gossip_posts(id) ON DELETE CASCADE,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('gossip_reactions')){
    $q("CREATE TABLE gossip_reactions (
      id INT AUTO_INCREMENT PRIMARY KEY,
      target_type VARCHAR(16) NOT NULL,
      target_id INT NOT NULL,
      user_id INT NOT NULL,
      emoji VARCHAR(16) NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_gossip_react (target_type,target_id,user_id,emoji),
      INDEX(target_type,target_id),
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

}


// --- DM read receipts (seen) ---
if(!$tableExists('dm_reads')){
  $q("CREATE TABLE dm_reads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conversation_id INT NOT NULL,
    user_id INT NOT NULL,
    last_seen_message_id INT NOT NULL DEFAULT 0,
    seen_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_read (conversation_id, user_id),
    INDEX(conversation_id),
    INDEX(user_id),
    FOREIGN KEY(conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
}

// --- DM typing indicator (polling-friendly) ---
if(!$tableExists('dm_typing')){
  $q("CREATE TABLE dm_typing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conversation_id INT NOT NULL,
    user_id INT NOT NULL,
    expires_at DATETIME NOT NULL,
    UNIQUE KEY uniq_typing (conversation_id, user_id),
    INDEX(conversation_id),
    INDEX(user_id),
    FOREIGN KEY(conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
}

if(!$tableExists('gossip_posts')){
    $q("CREATE TABLE gossip_posts (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      school VARCHAR(190) NULL,
      visibility VARCHAR(16) NOT NULL DEFAULT 'global', -- global|school
      content TEXT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX(created_at),
      INDEX(visibility),
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  if(!$tableExists('gossip_comments')){
    $q("CREATE TABLE gossip_comments (
      id INT AUTO_INCREMENT PRIMARY KEY,
      post_id INT NOT NULL,
      user_id INT NOT NULL,
      content TEXT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX(post_id),
      FOREIGN KEY(post_id) REFERENCES gossip_posts(id) ON DELETE CASCADE,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  if(!$tableExists('gossip_reactions')){
    $q("CREATE TABLE gossip_reactions (
      id INT AUTO_INCREMENT PRIMARY KEY,
      target_type VARCHAR(16) NOT NULL, -- post|comment
      target_id INT NOT NULL,
      user_id INT NOT NULL,
      emoji VARCHAR(16) NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_react (target_type,target_id,user_id,emoji),
      INDEX(target_type,target_id),
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  // Polls tables used by frontend (compat)
  if(!$tableExists('polls')){
    $q("CREATE TABLE polls (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      question VARCHAR(255) NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('poll_options')){
    $q("CREATE TABLE poll_options (
      id INT AUTO_INCREMENT PRIMARY KEY,
      poll_id INT NOT NULL,
      option_text VARCHAR(255) NOT NULL,
      FOREIGN KEY(poll_id) REFERENCES polls(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  if(!$tableExists('poll_votes')){
    $q("CREATE TABLE poll_votes (
      id INT AUTO_INCREMENT PRIMARY KEY,
      poll_id INT NOT NULL,
      option_id INT NOT NULL,
      user_id INT NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY uniq_vote (poll_id,user_id),
      FOREIGN KEY(poll_id) REFERENCES polls(id) ON DELETE CASCADE,
      FOREIGN KEY(option_id) REFERENCES poll_options(id) ON DELETE CASCADE,
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }


  if(!$tableExists('follow_requests')){
    $q("CREATE TABLE follow_requests (
      id INT AUTO_INCREMENT PRIMARY KEY,
      from_user_id INT NOT NULL,
      to_user_id INT NOT NULL,
      status VARCHAR(16) NOT NULL DEFAULT 'pending',
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      responded_at DATETIME NULL,
      UNIQUE KEY uniq_follow_req_pending (from_user_id,to_user_id,status),
      INDEX(to_user_id,status),
      FOREIGN KEY(from_user_id) REFERENCES users(id) ON DELETE CASCADE,
      FOREIGN KEY(to_user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  if(!$tableExists('photo_posts')){
    $q("CREATE TABLE photo_posts (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      image_url VARCHAR(512) NOT NULL,
      caption TEXT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX(user_id, created_at),
      FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }

  // New column for farewell photo (optional)
  if($tableExists('farewells') && !$colExists('farewells','photo_url')){
    $q("ALTER TABLE farewells ADD COLUMN photo_url VARCHAR(512) NULL AFTER music_url");
  }


}
