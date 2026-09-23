-- MEra Orbit ek alanlar

CREATE TABLE IF NOT EXISTS meetups (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  category VARCHAR(20) NOT NULL,
  title VARCHAR(190) NOT NULL,
  city VARCHAR(120) NOT NULL,
  province VARCHAR(120) NULL DEFAULT NULL,
  district VARCHAR(120) NULL DEFAULT NULL,
  notes TEXT NULL,
  meeting_at DATETIME NOT NULL,
  slots_needed INT NULL DEFAULT NULL,
  gender_pref VARCHAR(20) NOT NULL DEFAULT 'any',
  desired_age INT NULL DEFAULT NULL,
  duration_value INT NULL DEFAULT NULL,
  duration_unit VARCHAR(10) NOT NULL DEFAULT 'days',
  expires_at DATETIME NULL DEFAULT NULL,
  meetup_photo_url VARCHAR(255) NULL DEFAULT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'open',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_meetups_cat_city (category, city),
  KEY idx_meetups_province (province),
  KEY idx_meetups_user (user_id),
  KEY idx_meetups_exp (expires_at),
  CONSTRAINT fk_meetups_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE meetups ADD COLUMN province VARCHAR(120) NULL DEFAULT NULL;
ALTER TABLE meetups ADD COLUMN district VARCHAR(120) NULL DEFAULT NULL;
ALTER TABLE meetups ADD COLUMN gender_pref VARCHAR(20) NOT NULL DEFAULT 'any';
ALTER TABLE meetups ADD COLUMN desired_age INT NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS meetup_saves (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  meetup_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_meetup_save (user_id, meetup_id),
  KEY idx_meetupsave_meetup (meetup_id),
  CONSTRAINT fk_meetupsave_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_meetupsave_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE meetups ADD COLUMN meetup_photo_url VARCHAR(255) NULL DEFAULT NULL;


CREATE TABLE IF NOT EXISTS meetup_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  meetup_id INT NOT NULL,
  requester_id INT NOT NULL,
  note VARCHAR(255) NULL DEFAULT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  responded_at TIMESTAMP NULL DEFAULT NULL,
  UNIQUE KEY uniq_meetup_request (meetup_id, requester_id),
  KEY idx_meetupreq_meetup (meetup_id, status),
  KEY idx_meetupreq_requester (requester_id, status),
  CONSTRAINT fk_meetupreq_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE,
  CONSTRAINT fk_meetupreq_requester FOREIGN KEY (requester_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE meetups ADD COLUMN duration_value INT NULL DEFAULT NULL;
ALTER TABLE meetups ADD COLUMN duration_unit VARCHAR(10) NOT NULL DEFAULT 'days';
ALTER TABLE meetups ADD COLUMN expires_at DATETIME NULL DEFAULT NULL;

-- Group DM (Phase 1)
CREATE TABLE IF NOT EXISTS dm_groups (
  id INT AUTO_INCREMENT PRIMARY KEY,
  owner_id INT NOT NULL,
  title VARCHAR(120) NOT NULL,
  description VARCHAR(280) NULL DEFAULT NULL,
  spotify_link VARCHAR(255) NULL DEFAULT NULL,
  photo_url VARCHAR(255) NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_dmg_owner (owner_id),
  CONSTRAINT fk_dmg_owner FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS dm_group_members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  group_id INT NOT NULL,
  user_id INT NOT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'member',
  joined_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_dm_group_member (group_id, user_id),
  KEY idx_dmgm_user (user_id),
  CONSTRAINT fk_dmgm_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE,
  CONSTRAINT fk_dmgm_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS dm_group_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  group_id INT NOT NULL,
  sender_id INT NOT NULL,
  body TEXT NULL,
  photo_url VARCHAR(255) NULL DEFAULT NULL,
  reply_to_id INT NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  edited_at TIMESTAMP NULL DEFAULT NULL,
  deleted_at TIMESTAMP NULL DEFAULT NULL,
  KEY idx_dmgmsg_group (group_id, id),
  KEY idx_dmgmsg_sender (sender_id),
  CONSTRAINT fk_dmgmsg_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE,
  CONSTRAINT fk_dmgmsg_sender FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS dm_group_reads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  group_id INT NOT NULL,
  user_id INT NOT NULL,
  last_seen_message_id INT NOT NULL DEFAULT 0,
  seen_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_dm_group_read (group_id, user_id),
  CONSTRAINT fk_dmgr_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE,
  CONSTRAINT fk_dmgr_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS dm_group_typing (
  id INT AUTO_INCREMENT PRIMARY KEY,
  group_id INT NOT NULL,
  user_id INT NOT NULL,
  expires_at TIMESTAMP NULL DEFAULT NULL,
  UNIQUE KEY uniq_dm_group_typing (group_id, user_id),
  CONSTRAINT fk_dmgty_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE,
  CONSTRAINT fk_dmgty_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- MEra Nova + premium groups
ALTER TABLE users ADD COLUMN city VARCHAR(120) NULL DEFAULT NULL;
ALTER TABLE users ADD COLUMN current_stage VARCHAR(30) NULL DEFAULT NULL;
ALTER TABLE users ADD COLUMN class_label VARCHAR(40) NULL DEFAULT NULL;
ALTER TABLE dm_groups ADD COLUMN cover_url VARCHAR(255) NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS time_capsules (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(160) NOT NULL,
  body TEXT NOT NULL,
  open_at DATETIME NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'locked',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_capsule_user (user_id),
  KEY idx_capsule_open (open_at),
  CONSTRAINT fk_capsule_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS orbit_rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(60) NOT NULL UNIQUE,
  title VARCHAR(120) NOT NULL,
  description VARCHAR(255) NULL DEFAULT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  auto_city TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS orbit_room_members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room_id INT NOT NULL,
  user_id INT NOT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'member',
  joined_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_orbit_room_member (room_id, user_id),
  KEY idx_orbit_member_user (user_id),
  CONSTRAINT fk_orbit_member_room FOREIGN KEY (room_id) REFERENCES orbit_rooms(id) ON DELETE CASCADE,
  CONSTRAINT fk_orbit_member_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS orbit_room_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room_id INT NOT NULL,
  user_id INT NOT NULL,
  body TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_orbit_post_room (room_id, id),
  CONSTRAINT fk_orbit_post_room FOREIGN KEY (room_id) REFERENCES orbit_rooms(id) ON DELETE CASCADE,
  CONSTRAINT fk_orbit_post_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS memory_wall_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  category VARCHAR(30) NOT NULL,
  title VARCHAR(160) NOT NULL,
  body TEXT NOT NULL,
  image_url VARCHAR(255) NULL DEFAULT NULL,
  school VARCHAR(191) NULL DEFAULT NULL,
  grad_year INT NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_wall_school_year (school, grad_year),
  CONSTRAINT fk_wall_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS memory_wall_reacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_wall_react (post_id, user_id),
  CONSTRAINT fk_wall_react_post FOREIGN KEY (post_id) REFERENCES memory_wall_posts(id) ON DELETE CASCADE,
  CONSTRAINT fk_wall_react_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS private_notes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  to_user_id INT NOT NULL,
  from_user_id INT NOT NULL,
  note_body VARCHAR(280) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_note_to (to_user_id),
  CONSTRAINT fk_note_to FOREIGN KEY (to_user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_note_from FOREIGN KEY (from_user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS year_playlist_tracks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  school VARCHAR(191) NOT NULL,
  grad_year INT NOT NULL,
  user_id INT NOT NULL,
  platform VARCHAR(20) NOT NULL,
  track_url VARCHAR(255) NOT NULL,
  note_body VARCHAR(190) NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_year_playlist (school, grad_year),
  CONSTRAINT fk_year_playlist_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS dm_group_polls (
  id INT AUTO_INCREMENT PRIMARY KEY,
  group_id INT NOT NULL,
  user_id INT NOT NULL,
  question VARCHAR(200) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'open',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_dmgpoll_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE,
  CONSTRAINT fk_dmgpoll_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS dm_group_poll_options (
  id INT AUTO_INCREMENT PRIMARY KEY,
  poll_id INT NOT NULL,
  option_text VARCHAR(120) NOT NULL,
  CONSTRAINT fk_dmgpollopt_poll FOREIGN KEY (poll_id) REFERENCES dm_group_polls(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS dm_group_poll_votes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  poll_id INT NOT NULL,
  option_id INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_dmgpoll_vote (poll_id, user_id),
  CONSTRAINT fk_dmgpollvote_poll FOREIGN KEY (poll_id) REFERENCES dm_group_polls(id) ON DELETE CASCADE,
  CONSTRAINT fk_dmgpollvote_option FOREIGN KEY (option_id) REFERENCES dm_group_poll_options(id) ON DELETE CASCADE,
  CONSTRAINT fk_dmgpollvote_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS dm_group_events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  group_id INT NOT NULL,
  user_id INT NOT NULL,
  title VARCHAR(160) NOT NULL,
  event_at DATETIME NOT NULL,
  location VARCHAR(190) NULL DEFAULT NULL,
  note_body VARCHAR(255) NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_dmgevent_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE,
  CONSTRAINT fk_dmgevent_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS yearbook_quotes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  school VARCHAR(191) NOT NULL,
  grad_year INT NOT NULL,
  user_id INT NOT NULL,
  quote_type VARCHAR(20) NOT NULL DEFAULT 'period',
  quote_body VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_yearbook_quote (school, grad_year, quote_type),
  CONSTRAINT fk_yearbook_quote_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- MEra Scene
CREATE TABLE IF NOT EXISTS scene_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  entry_type VARCHAR(24) NOT NULL DEFAULT 'scene',
  media_kind VARCHAR(24) NULL DEFAULT NULL,
  media_title VARCHAR(160) NOT NULL,
  character_name VARCHAR(120) NULL DEFAULT NULL,
  title VARCHAR(180) NOT NULL,
  body TEXT NOT NULL,
  soundtrack_platform VARCHAR(40) NULL DEFAULT NULL,
  soundtrack_url VARCHAR(255) NULL DEFAULT NULL,
  theme_label VARCHAR(120) NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_scene_user (user_id),
  KEY idx_scene_type (entry_type),
  KEY idx_scene_created (created_at),
  CONSTRAINT fk_scene_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS scene_reactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  reaction VARCHAR(24) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_scene_reaction (post_id, user_id),
  KEY idx_scene_react_post (post_id),
  CONSTRAINT fk_scene_react_post FOREIGN KEY (post_id) REFERENCES scene_posts(id) ON DELETE CASCADE,
  CONSTRAINT fk_scene_react_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS style_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  post_type VARCHAR(20) NOT NULL DEFAULT 'outfit',
  category VARCHAR(40) NOT NULL DEFAULT 'sneaker',
  title VARCHAR(180) NOT NULL,
  body TEXT NOT NULL,
  brand_name VARCHAR(120) NULL DEFAULT NULL,
  price_now DECIMAL(10,2) NULL DEFAULT NULL,
  price_before DECIMAL(10,2) NULL DEFAULT NULL,
  product_url VARCHAR(255) NULL DEFAULT NULL,
  image_url VARCHAR(255) NULL DEFAULT NULL,
  tags_text VARCHAR(255) NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_style_user (user_id),
  KEY idx_style_type (post_type),
  KEY idx_style_cat (category),
  KEY idx_style_created (created_at),
  CONSTRAINT fk_style_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS style_post_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  item_name VARCHAR(160) NULL DEFAULT NULL,
  store_name VARCHAR(120) NULL DEFAULT NULL,
  price_now DECIMAL(10,2) NULL DEFAULT NULL,
  product_url VARCHAR(255) NULL DEFAULT NULL,
  display_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_styleitem_post (post_id, display_order),
  CONSTRAINT fk_styleitem_post FOREIGN KEY (post_id) REFERENCES style_posts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS style_post_likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_style_like (post_id, user_id),
  KEY idx_stylelike_user (user_id),
  CONSTRAINT fk_stylelike_post FOREIGN KEY (post_id) REFERENCES style_posts(id) ON DELETE CASCADE,
  CONSTRAINT fk_stylelike_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS style_post_saves (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_style_save (post_id, user_id),
  KEY idx_stylesave_user (user_id),
  CONSTRAINT fk_stylesave_post FOREIGN KEY (post_id) REFERENCES style_posts(id) ON DELETE CASCADE,
  CONSTRAINT fk_stylesave_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS blast_scores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  best_score INT NOT NULL DEFAULT 0,
  last_score INT NOT NULL DEFAULT 0,
  plays INT NOT NULL DEFAULT 0,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_blast_user (user_id),
  KEY idx_blast_best (best_score),
  CONSTRAINT fk_blast_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS m2_scores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  best_score INT NOT NULL DEFAULT 0,
  last_score INT NOT NULL DEFAULT 0,
  plays INT NOT NULL DEFAULT 0,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_m2_user (user_id),
  KEY idx_m2_best (best_score),
  CONSTRAINT fk_m2_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin panel şifre periyodu alanları
ALTER TABLE users ADD COLUMN IF NOT EXISTS admin_password_interval_months INT NOT NULL DEFAULT 3;
ALTER TABLE users ADD COLUMN IF NOT EXISTS admin_password_changed_at DATETIME NULL DEFAULT NULL;

-- Admin panel: şikayet, engelleme ve mesaj gizlilik ayarı
CREATE TABLE IF NOT EXISTS reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reporter_id INT NOT NULL,
  target_type VARCHAR(40) NOT NULL,
  target_id INT NOT NULL,
  reported_user_id INT NULL DEFAULT NULL,
  reason TEXT NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'open',
  handled_by INT NULL DEFAULT NULL,
  handled_at DATETIME NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_reports_status (status, created_at),
  KEY idx_reports_reporter (reporter_id),
  KEY idx_reports_reported_user (reported_user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS user_blocks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  blocker_id INT NOT NULL,
  blocked_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_user_block (blocker_id, blocked_id),
  KEY idx_blocked_user (blocked_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE users ADD COLUMN dm_privacy VARCHAR(20) NOT NULL DEFAULT 'everyone';
ALTER TABLE users ADD COLUMN dm_sidebar_alerts_enabled TINYINT(1) NOT NULL DEFAULT 1;

-- V3: şikayet düzenleme/silme, hatırlatma ve uygulama içi bildirimler
ALTER TABLE reports ADD COLUMN updated_at DATETIME NULL DEFAULT NULL;
ALTER TABLE reports ADD COLUMN resolution_note TEXT NULL;
ALTER TABLE reports ADD COLUMN reminder1_at DATETIME NULL DEFAULT NULL;
ALTER TABLE reports ADD COLUMN reminder2_at DATETIME NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS app_notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  type VARCHAR(40) NOT NULL DEFAULT 'info',
  title VARCHAR(190) NOT NULL,
  body TEXT NOT NULL,
  link_url VARCHAR(255) NULL DEFAULT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_appnotif_user (user_id, is_read, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- V6: avatar görünürlük, mesaj kapatma ve güzel bakım mesajları
CREATE TABLE IF NOT EXISTS avatar_pets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  owner_id INT NOT NULL,
  partner_id INT NULL DEFAULT NULL,
  pet_type VARCHAR(20) NOT NULL DEFAULT 'solo',
  name VARCHAR(80) NOT NULL,
  color VARCHAR(30) NOT NULL DEFAULT 'violet',
  visibility VARCHAR(20) NOT NULL DEFAULT 'public',
  messages_enabled TINYINT(1) NOT NULL DEFAULT 1,
  xp INT NOT NULL DEFAULT 0,
  last_fed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_toilet_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_slept_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_played_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_notified_at DATETIME NULL DEFAULT NULL,
  last_praise_at DATETIME NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_pet_owner (owner_id),
  KEY idx_pet_partner (partner_id),
  KEY idx_pet_visibility (visibility)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE avatar_pets ADD COLUMN visibility VARCHAR(20) NOT NULL DEFAULT 'public';
ALTER TABLE avatar_pets ADD COLUMN messages_enabled TINYINT(1) NOT NULL DEFAULT 1;
ALTER TABLE avatar_pets ADD COLUMN last_praise_at DATETIME NULL DEFAULT NULL;

-- V7: tek kişilik ana avatar, arkadaşlık/kavga çözme, sevme ve yumurta sistemi
ALTER TABLE avatar_pets ADD COLUMN last_petted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE avatar_pets ADD COLUMN egg_count INT NOT NULL DEFAULT 0;

CREATE TABLE IF NOT EXISTS avatar_pet_friendships (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pet_id INT NOT NULL,
  friend_pet_id INT NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'friends',
  conflict_reason VARCHAR(190) NULL DEFAULT NULL,
  resolved_by_owner TINYINT(1) NOT NULL DEFAULT 0,
  resolved_by_friend TINYINT(1) NOT NULL DEFAULT 0,
  last_interaction_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_pet_friend_pair (pet_id, friend_pet_id),
  KEY idx_friend_pet (friend_pet_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- v8 avatar çiftliği / yumurta ve özel civciv alanları
ALTER TABLE avatar_pets ADD COLUMN parent_pet_id INT NULL DEFAULT NULL;
ALTER TABLE avatar_pets ADD COLUMN generation INT NOT NULL DEFAULT 1;
ALTER TABLE avatar_pets ADD COLUMN trait_code VARCHAR(40) NOT NULL DEFAULT 'curious';
ALTER TABLE avatar_pets ADD COLUMN trait_label VARCHAR(80) NOT NULL DEFAULT 'Meraklı';
ALTER TABLE avatar_pets ADD COLUMN special_note VARCHAR(190) NULL DEFAULT NULL;
ALTER TABLE avatar_pets ADD COLUMN health_status VARCHAR(30) NOT NULL DEFAULT 'healthy';
ALTER TABLE avatar_pets ADD COLUMN health_until DATETIME NULL DEFAULT NULL;

-- v14 profile viewer privacy
ALTER TABLE users ADD COLUMN profile_views_visibility VARCHAR(20) NOT NULL DEFAULT 'private';


CREATE TABLE IF NOT EXISTS admin_badwords_custom (
  word VARCHAR(100) PRIMARY KEY,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS admin_badwords_removed (
  word VARCHAR(100) PRIMARY KEY,
  removed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE users ADD COLUMN account_privacy VARCHAR(20) NOT NULL DEFAULT 'private';


-- DM voice messages and WebRTC call signaling
ALTER TABLE dm_messages ADD COLUMN audio_url VARCHAR(512) NULL DEFAULT NULL;
ALTER TABLE dm_group_messages ADD COLUMN audio_url VARCHAR(512) NULL DEFAULT NULL;
CREATE TABLE IF NOT EXISTS dm_call_signals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  conversation_id INT NOT NULL,
  call_id VARCHAR(80) NOT NULL,
  sender_id INT NOT NULL,
  type VARCHAR(32) NOT NULL,
  payload MEDIUMTEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_dm_call_fetch (conversation_id, call_id, id),
  KEY idx_dm_call_sender (sender_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Admin arama izni: 1=aranabilir, 0=aranamaz
ALTER TABLE users ADD COLUMN admin_call_allowed TINYINT(1) NOT NULL DEFAULT 1;


-- DM sessize alma ayarları
ALTER TABLE users ADD COLUMN admin_dm_muted_all TINYINT(1) NOT NULL DEFAULT 0;
CREATE TABLE IF NOT EXISTS dm_mutes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  conversation_id INT NOT NULL,
  user_id INT NOT NULL,
  is_muted TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_dm_mute (conversation_id, user_id),
  KEY idx_dmmute_user (user_id, is_muted)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
