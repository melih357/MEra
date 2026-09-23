<?php
declare(strict_types=1);
require __DIR__ . '/config.php';


function ensure_feature_schema(mysqli $mysqli): void {
  @${"mysqli"}->query("ALTER TABLE gossip_posts ADD COLUMN category VARCHAR(40) NOT NULL DEFAULT 'general'");
  static $done = false;
  if($done) return;
  $done = true;

  $queries = [
    "CREATE TABLE IF NOT EXISTS follows (id INT AUTO_INCREMENT PRIMARY KEY, follower_id INT NOT NULL, following_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_follow (follower_id, following_id), KEY idx_following (following_id), CONSTRAINT fk_follows_follower FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_follows_following FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS follow_requests (id INT AUTO_INCREMENT PRIMARY KEY, from_user_id INT NOT NULL, to_user_id INT NOT NULL, status VARCHAR(20) NOT NULL DEFAULT 'pending', created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, responded_at TIMESTAMP NULL DEFAULT NULL, KEY idx_to_status (to_user_id, status), KEY idx_from_status (from_user_id, status), CONSTRAINT fk_followreq_from FOREIGN KEY (from_user_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_followreq_to FOREIGN KEY (to_user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS photo_posts (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, image_url VARCHAR(255) NOT NULL, caption TEXT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_pp_user (user_id), CONSTRAINT fk_pp_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS photo_post_likes (id INT AUTO_INCREMENT PRIMARY KEY, post_id INT NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_post_like (post_id, user_id), KEY idx_ppl_user (user_id), CONSTRAINT fk_ppl_post FOREIGN KEY (post_id) REFERENCES photo_posts(id) ON DELETE CASCADE, CONSTRAINT fk_ppl_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS photo_post_comments (id INT AUTO_INCREMENT PRIMARY KEY, post_id INT NOT NULL, user_id INT NOT NULL, body TEXT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, deleted_at TIMESTAMP NULL DEFAULT NULL, KEY idx_ppc_post (post_id), KEY idx_ppc_user (user_id), CONSTRAINT fk_ppc_post FOREIGN KEY (post_id) REFERENCES photo_posts(id) ON DELETE CASCADE, CONSTRAINT fk_ppc_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_conversations (id INT AUTO_INCREMENT PRIMARY KEY, user1_id INT NOT NULL, user2_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_pair (user1_id, user2_id), KEY idx_dm_u2 (user2_id), CONSTRAINT fk_dmc_u1 FOREIGN KEY (user1_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_dmc_u2 FOREIGN KEY (user2_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_messages (id INT AUTO_INCREMENT PRIMARY KEY, conversation_id INT NOT NULL, sender_id INT NOT NULL, body TEXT NULL, photo_url VARCHAR(255) NULL, audio_url VARCHAR(512) NULL DEFAULT NULL, reply_to_id INT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, deleted_at TIMESTAMP NULL DEFAULT NULL, deleted_by_admin INT NULL DEFAULT NULL, KEY idx_dmm_conv (conversation_id, id), KEY idx_dmm_sender (sender_id), CONSTRAINT fk_dmm_conv FOREIGN KEY (conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE, CONSTRAINT fk_dmm_sender FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_reactions (id INT AUTO_INCREMENT PRIMARY KEY, message_id INT NOT NULL, user_id INT NOT NULL, emoji VARCHAR(16) NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_dm_reaction (message_id, user_id, emoji), CONSTRAINT fk_dmr_msg FOREIGN KEY (message_id) REFERENCES dm_messages(id) ON DELETE CASCADE, CONSTRAINT fk_dmr_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_reads (id INT AUTO_INCREMENT PRIMARY KEY, conversation_id INT NOT NULL, user_id INT NOT NULL, last_seen_message_id INT NOT NULL DEFAULT 0, seen_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY uniq_dm_read (conversation_id, user_id), CONSTRAINT fk_dmr2_conv FOREIGN KEY (conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE, CONSTRAINT fk_dmr2_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_typing (id INT AUTO_INCREMENT PRIMARY KEY, conversation_id INT NOT NULL, user_id INT NOT NULL, is_typing TINYINT(1) NOT NULL DEFAULT 0, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY uniq_dm_typing (conversation_id, user_id), CONSTRAINT fk_dmt_conv FOREIGN KEY (conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE, CONSTRAINT fk_dmt_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_mutes (id INT AUTO_INCREMENT PRIMARY KEY, conversation_id INT NOT NULL, user_id INT NOT NULL, is_muted TINYINT(1) NOT NULL DEFAULT 1, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY uniq_dm_mute (conversation_id, user_id), KEY idx_dmmute_user (user_id, is_muted), CONSTRAINT fk_dmmute_conv FOREIGN KEY (conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE, CONSTRAINT fk_dmmute_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_call_signals (id INT AUTO_INCREMENT PRIMARY KEY, conversation_id INT NOT NULL, call_id VARCHAR(80) NOT NULL, sender_id INT NOT NULL, type VARCHAR(32) NOT NULL, payload MEDIUMTEXT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_dm_call_fetch (conversation_id, call_id, id), KEY idx_dm_call_sender (sender_id), CONSTRAINT fk_dmcall_conv FOREIGN KEY (conversation_id) REFERENCES dm_conversations(id) ON DELETE CASCADE, CONSTRAINT fk_dmcall_sender FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_groups (id INT AUTO_INCREMENT PRIMARY KEY, owner_id INT NOT NULL, title VARCHAR(120) NOT NULL, description VARCHAR(280) NULL DEFAULT NULL, spotify_link VARCHAR(255) NULL DEFAULT NULL, photo_url VARCHAR(255) NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_dmg_owner (owner_id), CONSTRAINT fk_dmg_owner FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_group_members (id INT AUTO_INCREMENT PRIMARY KEY, group_id INT NOT NULL, user_id INT NOT NULL, role VARCHAR(20) NOT NULL DEFAULT 'member', joined_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_dm_group_member (group_id, user_id), KEY idx_dmgm_user (user_id), CONSTRAINT fk_dmgm_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE, CONSTRAINT fk_dmgm_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_group_messages (id INT AUTO_INCREMENT PRIMARY KEY, group_id INT NOT NULL, sender_id INT NOT NULL, body TEXT NULL, photo_url VARCHAR(255) NULL DEFAULT NULL, audio_url VARCHAR(512) NULL DEFAULT NULL, reply_to_id INT NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, edited_at TIMESTAMP NULL DEFAULT NULL, deleted_at TIMESTAMP NULL DEFAULT NULL, KEY idx_dmgmsg_group (group_id, id), KEY idx_dmgmsg_sender (sender_id), CONSTRAINT fk_dmgmsg_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE, CONSTRAINT fk_dmgmsg_sender FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_group_reads (id INT AUTO_INCREMENT PRIMARY KEY, group_id INT NOT NULL, user_id INT NOT NULL, last_seen_message_id INT NOT NULL DEFAULT 0, seen_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY uniq_dm_group_read (group_id, user_id), CONSTRAINT fk_dmgr_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE, CONSTRAINT fk_dmgr_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_group_typing (id INT AUTO_INCREMENT PRIMARY KEY, group_id INT NOT NULL, user_id INT NOT NULL, expires_at TIMESTAMP NULL DEFAULT NULL, UNIQUE KEY uniq_dm_group_typing (group_id, user_id), CONSTRAINT fk_dmgty_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE, CONSTRAINT fk_dmgty_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS quick_match_requests (id INT AUTO_INCREMENT PRIMARY KEY, from_user_id INT NOT NULL, to_user_id INT NOT NULL, status VARCHAR(20) NOT NULL DEFAULT 'pending', created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, responded_at TIMESTAMP NULL DEFAULT NULL, KEY idx_qm_pair (from_user_id, to_user_id, status), CONSTRAINT fk_qm_from FOREIGN KEY (from_user_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_qm_to FOREIGN KEY (to_user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS meetups (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, category VARCHAR(20) NOT NULL, title VARCHAR(190) NOT NULL, city VARCHAR(120) NOT NULL, province VARCHAR(120) NULL DEFAULT NULL, district VARCHAR(120) NULL DEFAULT NULL, notes TEXT NULL, meeting_at DATETIME NOT NULL, slots_needed INT NULL DEFAULT NULL, gender_pref VARCHAR(20) NOT NULL DEFAULT 'any', desired_age INT NULL DEFAULT NULL, duration_value INT NULL DEFAULT NULL, duration_unit VARCHAR(10) NOT NULL DEFAULT 'days', expires_at DATETIME NULL DEFAULT NULL, meetup_photo_url VARCHAR(255) NULL DEFAULT NULL, status VARCHAR(20) NOT NULL DEFAULT 'open', created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_meetups_cat_city (category, city), KEY idx_meetups_province (province), KEY idx_meetups_user (user_id), KEY idx_meetups_exp (expires_at), CONSTRAINT fk_meetups_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS meetup_saves (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, meetup_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_meetup_save (user_id, meetup_id), KEY idx_meetupsave_meetup (meetup_id), CONSTRAINT fk_meetupsave_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_meetupsave_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS meetup_requests (id INT AUTO_INCREMENT PRIMARY KEY, meetup_id INT NOT NULL, requester_id INT NOT NULL, note VARCHAR(255) NULL DEFAULT NULL, status VARCHAR(20) NOT NULL DEFAULT 'pending', created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, responded_at TIMESTAMP NULL DEFAULT NULL, UNIQUE KEY uniq_meetup_request (meetup_id, requester_id), KEY idx_meetupreq_meetup (meetup_id, status), KEY idx_meetupreq_requester (requester_id, status), CONSTRAINT fk_meetupreq_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE, CONSTRAINT fk_meetupreq_requester FOREIGN KEY (requester_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS meetup_questions (id INT AUTO_INCREMENT PRIMARY KEY, meetup_id INT NOT NULL, asker_id INT NOT NULL, question_body TEXT NOT NULL, answer_body TEXT NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, answered_at TIMESTAMP NULL DEFAULT NULL, KEY idx_meetq_meetup (meetup_id), KEY idx_meetq_asker (asker_id), CONSTRAINT fk_meetq_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE, CONSTRAINT fk_meetq_asker FOREIGN KEY (asker_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS meetup_reviews (id INT AUTO_INCREMENT PRIMARY KEY, meetup_id INT NOT NULL, reviewer_id INT NOT NULL, host_user_id INT NOT NULL, rating TINYINT NOT NULL, comment TEXT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_meetup_review (meetup_id, reviewer_id), KEY idx_meetr_meetup (meetup_id), KEY idx_meetr_host (host_user_id), CONSTRAINT fk_meetr_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE, CONSTRAINT fk_meetr_reviewer FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_meetr_host FOREIGN KEY (host_user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS time_capsules (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, title VARCHAR(160) NOT NULL, body TEXT NOT NULL, open_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL DEFAULT 'locked', created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_capsule_user (user_id), KEY idx_capsule_open (open_at), CONSTRAINT fk_capsule_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS orbit_rooms (id INT AUTO_INCREMENT PRIMARY KEY, slug VARCHAR(60) NOT NULL UNIQUE, title VARCHAR(120) NOT NULL, description VARCHAR(255) NULL DEFAULT NULL, sort_order INT NOT NULL DEFAULT 0, auto_city TINYINT(1) NOT NULL DEFAULT 0, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS orbit_room_members (id INT AUTO_INCREMENT PRIMARY KEY, room_id INT NOT NULL, user_id INT NOT NULL, role VARCHAR(20) NOT NULL DEFAULT 'member', joined_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_orbit_room_member (room_id, user_id), KEY idx_orbit_member_user (user_id), CONSTRAINT fk_orbit_member_room FOREIGN KEY (room_id) REFERENCES orbit_rooms(id) ON DELETE CASCADE, CONSTRAINT fk_orbit_member_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS orbit_room_posts (id INT AUTO_INCREMENT PRIMARY KEY, room_id INT NOT NULL, user_id INT NOT NULL, body TEXT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_orbit_post_room (room_id, id), CONSTRAINT fk_orbit_post_room FOREIGN KEY (room_id) REFERENCES orbit_rooms(id) ON DELETE CASCADE, CONSTRAINT fk_orbit_post_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS memory_wall_posts (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, category VARCHAR(30) NOT NULL, title VARCHAR(160) NOT NULL, body TEXT NOT NULL, image_url VARCHAR(255) NULL DEFAULT NULL, school VARCHAR(191) NULL DEFAULT NULL, grad_year INT NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_wall_school_year (school, grad_year), CONSTRAINT fk_wall_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS memory_wall_reacts (id INT AUTO_INCREMENT PRIMARY KEY, post_id INT NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_wall_react (post_id, user_id), CONSTRAINT fk_wall_react_post FOREIGN KEY (post_id) REFERENCES memory_wall_posts(id) ON DELETE CASCADE, CONSTRAINT fk_wall_react_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS private_notes (id INT AUTO_INCREMENT PRIMARY KEY, to_user_id INT NOT NULL, from_user_id INT NOT NULL, note_body VARCHAR(280) NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_note_to (to_user_id), CONSTRAINT fk_note_to FOREIGN KEY (to_user_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_note_from FOREIGN KEY (from_user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS year_playlist_tracks (id INT AUTO_INCREMENT PRIMARY KEY, school VARCHAR(191) NOT NULL, grad_year INT NOT NULL, user_id INT NOT NULL, platform VARCHAR(20) NOT NULL, track_url VARCHAR(255) NOT NULL, note_body VARCHAR(190) NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_year_playlist (school, grad_year), CONSTRAINT fk_year_playlist_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS yearbook_quotes (id INT AUTO_INCREMENT PRIMARY KEY, school VARCHAR(191) NOT NULL, grad_year INT NOT NULL, user_id INT NOT NULL, quote_type VARCHAR(20) NOT NULL DEFAULT 'period', quote_body VARCHAR(255) NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_yearbook_quote (school, grad_year, quote_type), CONSTRAINT fk_yearbook_quote_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_group_polls (id INT AUTO_INCREMENT PRIMARY KEY, group_id INT NOT NULL, user_id INT NOT NULL, question VARCHAR(200) NOT NULL, status VARCHAR(20) NOT NULL DEFAULT 'open', created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, CONSTRAINT fk_dmgpoll_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE, CONSTRAINT fk_dmgpoll_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_group_poll_options (id INT AUTO_INCREMENT PRIMARY KEY, poll_id INT NOT NULL, option_text VARCHAR(120) NOT NULL, CONSTRAINT fk_dmgpollopt_poll FOREIGN KEY (poll_id) REFERENCES dm_group_polls(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_group_poll_votes (id INT AUTO_INCREMENT PRIMARY KEY, poll_id INT NOT NULL, option_id INT NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_dmgpoll_vote (poll_id, user_id), CONSTRAINT fk_dmgpollvote_poll FOREIGN KEY (poll_id) REFERENCES dm_group_polls(id) ON DELETE CASCADE, CONSTRAINT fk_dmgpollvote_option FOREIGN KEY (option_id) REFERENCES dm_group_poll_options(id) ON DELETE CASCADE, CONSTRAINT fk_dmgpollvote_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
    "CREATE TABLE IF NOT EXISTS dm_group_events (id INT AUTO_INCREMENT PRIMARY KEY, group_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(160) NOT NULL, event_at DATETIME NOT NULL, location VARCHAR(190) NULL DEFAULT NULL, note_body VARCHAR(255) NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, CONSTRAINT fk_dmgevent_group FOREIGN KEY (group_id) REFERENCES dm_groups(id) ON DELETE CASCADE, CONSTRAINT fk_dmgevent_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
  ];
  foreach($queries as $sql){
    @$mysqli->query($sql);
  }

  @${"mysqli"}->query("ALTER TABLE photo_posts ADD COLUMN pinned TINYINT(1) NOT NULL DEFAULT 0");
  @${"mysqli"}->query("ALTER TABLE photo_posts ADD COLUMN display_order INT NOT NULL DEFAULT 0");
  @${"mysqli"}->query("ALTER TABLE dm_typing ADD COLUMN expires_at TIMESTAMP NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE farewells ADD COLUMN photo_url VARCHAR(255) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN cover_photo_url VARCHAR(255) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN verified_badge TINYINT(1) NOT NULL DEFAULT 0");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN admin_until DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN city VARCHAR(120) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN current_stage VARCHAR(30) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN class_label VARCHAR(40) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN is_banned TINYINT(1) NOT NULL DEFAULT 0");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN mute_until DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN admin_password_interval_months INT NOT NULL DEFAULT 3");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN admin_password_changed_at DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN admin_call_allowed TINYINT(1) NOT NULL DEFAULT 1");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN admin_dm_muted_all TINYINT(1) NOT NULL DEFAULT 0");
  @${"mysqli"}->query("ALTER TABLE dm_groups ADD COLUMN cover_url VARCHAR(255) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN slots_needed INT NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'open'");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN province VARCHAR(120) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN district VARCHAR(120) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN gender_pref VARCHAR(20) NOT NULL DEFAULT 'any'");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN desired_age INT NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN meetup_photo_url VARCHAR(255) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN duration_value INT NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN duration_unit VARCHAR(10) NOT NULL DEFAULT 'days'");
  @${"mysqli"}->query("ALTER TABLE meetups ADD COLUMN expires_at DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS meetup_saves (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, meetup_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_meetup_save (user_id, meetup_id), KEY idx_meetupsave_meetup (meetup_id), CONSTRAINT fk_meetupsave_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_meetupsave_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS meetup_requests (id INT AUTO_INCREMENT PRIMARY KEY, meetup_id INT NOT NULL, requester_id INT NOT NULL, note VARCHAR(255) NULL DEFAULT NULL, status VARCHAR(20) NOT NULL DEFAULT 'pending', created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, responded_at TIMESTAMP NULL DEFAULT NULL, UNIQUE KEY uniq_meetup_request (meetup_id, requester_id), KEY idx_meetupreq_meetup (meetup_id, status), KEY idx_meetupreq_requester (requester_id, status), CONSTRAINT fk_meetupreq_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE, CONSTRAINT fk_meetupreq_requester FOREIGN KEY (requester_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS meetup_questions (id INT AUTO_INCREMENT PRIMARY KEY, meetup_id INT NOT NULL, asker_id INT NOT NULL, question_body TEXT NOT NULL, answer_body TEXT NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, answered_at TIMESTAMP NULL DEFAULT NULL, KEY idx_meetq_meetup (meetup_id), KEY idx_meetq_asker (asker_id), CONSTRAINT fk_meetq_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE, CONSTRAINT fk_meetq_asker FOREIGN KEY (asker_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS meetup_reviews (id INT AUTO_INCREMENT PRIMARY KEY, meetup_id INT NOT NULL, reviewer_id INT NOT NULL, host_user_id INT NOT NULL, rating TINYINT NOT NULL, comment TEXT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_meetup_review (meetup_id, reviewer_id), KEY idx_meetr_meetup (meetup_id), KEY idx_meetr_host (host_user_id), CONSTRAINT fk_meetr_meetup FOREIGN KEY (meetup_id) REFERENCES meetups(id) ON DELETE CASCADE, CONSTRAINT fk_meetr_reviewer FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_meetr_host FOREIGN KEY (host_user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS scene_posts (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, entry_type VARCHAR(24) NOT NULL DEFAULT 'scene', media_kind VARCHAR(24) NULL DEFAULT NULL, media_title VARCHAR(160) NOT NULL, character_name VARCHAR(120) NULL DEFAULT NULL, title VARCHAR(180) NOT NULL, body TEXT NOT NULL, soundtrack_platform VARCHAR(40) NULL DEFAULT NULL, soundtrack_url VARCHAR(255) NULL DEFAULT NULL, theme_label VARCHAR(120) NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_scene_user (user_id), KEY idx_scene_type (entry_type), KEY idx_scene_created (created_at), CONSTRAINT fk_scene_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS scene_reactions (id INT AUTO_INCREMENT PRIMARY KEY, post_id INT NOT NULL, user_id INT NOT NULL, reaction VARCHAR(24) NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_scene_reaction (post_id, user_id), KEY idx_scene_react_post (post_id), CONSTRAINT fk_scene_react_post FOREIGN KEY (post_id) REFERENCES scene_posts(id) ON DELETE CASCADE, CONSTRAINT fk_scene_react_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS style_posts (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, post_type VARCHAR(20) NOT NULL DEFAULT 'outfit', category VARCHAR(40) NOT NULL DEFAULT 'sneaker', title VARCHAR(180) NOT NULL, body TEXT NOT NULL, brand_name VARCHAR(120) NULL DEFAULT NULL, price_now DECIMAL(10,2) NULL DEFAULT NULL, price_before DECIMAL(10,2) NULL DEFAULT NULL, product_url VARCHAR(255) NULL DEFAULT NULL, image_url VARCHAR(255) NULL DEFAULT NULL, tags_text VARCHAR(255) NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_style_user (user_id), KEY idx_style_type (post_type), KEY idx_style_cat (category), KEY idx_style_created (created_at), CONSTRAINT fk_style_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS style_post_items (id INT AUTO_INCREMENT PRIMARY KEY, post_id INT NOT NULL, item_name VARCHAR(160) NULL DEFAULT NULL, store_name VARCHAR(120) NULL DEFAULT NULL, price_now DECIMAL(10,2) NULL DEFAULT NULL, product_url VARCHAR(255) NULL DEFAULT NULL, display_order INT NOT NULL DEFAULT 0, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_styleitem_post (post_id, display_order), CONSTRAINT fk_styleitem_post FOREIGN KEY (post_id) REFERENCES style_posts(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS style_post_likes (id INT AUTO_INCREMENT PRIMARY KEY, post_id INT NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_style_like (post_id, user_id), KEY idx_stylelike_user (user_id), CONSTRAINT fk_stylelike_post FOREIGN KEY (post_id) REFERENCES style_posts(id) ON DELETE CASCADE, CONSTRAINT fk_stylelike_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS blast_scores (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, best_score INT NOT NULL DEFAULT 0, last_score INT NOT NULL DEFAULT 0, plays INT NOT NULL DEFAULT 0, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY uniq_blast_user (user_id), KEY idx_blast_best (best_score), CONSTRAINT fk_blast_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS m2_scores (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, best_score INT NOT NULL DEFAULT 0, last_score INT NOT NULL DEFAULT 0, plays INT NOT NULL DEFAULT 0, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY uniq_m2_user (user_id), KEY idx_m2_best (best_score), CONSTRAINT fk_m2_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS style_post_saves (id INT AUTO_INCREMENT PRIMARY KEY, post_id INT NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_style_save (post_id, user_id), KEY idx_stylesave_user (user_id), CONSTRAINT fk_stylesave_post FOREIGN KEY (post_id) REFERENCES style_posts(id) ON DELETE CASCADE, CONSTRAINT fk_stylesave_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS reports (id INT AUTO_INCREMENT PRIMARY KEY, reporter_id INT NOT NULL, target_type VARCHAR(40) NOT NULL, target_id INT NOT NULL, reported_user_id INT NULL DEFAULT NULL, reason TEXT NOT NULL, status VARCHAR(20) NOT NULL DEFAULT 'open', handled_by INT NULL DEFAULT NULL, handled_at DATETIME NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_reports_status (status, created_at), KEY idx_reports_reporter (reporter_id), KEY idx_reports_reported_user (reported_user_id), CONSTRAINT fk_reports_reporter FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_reports_reported FOREIGN KEY (reported_user_id) REFERENCES users(id) ON DELETE SET NULL, CONSTRAINT fk_reports_handler FOREIGN KEY (handled_by) REFERENCES users(id) ON DELETE SET NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("ALTER TABLE reports ADD COLUMN reported_user_id INT NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE reports ADD COLUMN handled_at DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE reports ADD COLUMN updated_at DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE reports ADD COLUMN resolution_note TEXT NULL");
  @${"mysqli"}->query("ALTER TABLE reports ADD COLUMN reminder1_at DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE reports ADD COLUMN reminder2_at DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS app_notifications (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, type VARCHAR(40) NOT NULL DEFAULT 'info', title VARCHAR(190) NOT NULL, body TEXT NOT NULL, link_url VARCHAR(255) NULL DEFAULT NULL, is_read TINYINT(1) NOT NULL DEFAULT 0, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_appnotif_user (user_id,is_read,created_at), CONSTRAINT fk_appnotif_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS badge_requests (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, message TEXT NOT NULL, status VARCHAR(20) NOT NULL DEFAULT 'pending', admin_note TEXT NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, decided_at DATETIME NULL DEFAULT NULL, decided_by INT NULL DEFAULT NULL, KEY idx_badgereq_user (user_id, status, created_at), KEY idx_badgereq_status (status, created_at), CONSTRAINT fk_badgereq_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_badgereq_admin FOREIGN KEY (decided_by) REFERENCES users(id) ON DELETE SET NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS badword_logs (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, context VARCHAR(80) NULL DEFAULT NULL, target_id INT NULL DEFAULT NULL, original_text TEXT NOT NULL, censored_text TEXT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_badword_user (user_id, created_at), KEY idx_badword_created (created_at), CONSTRAINT fk_badword_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS user_blocks (id INT AUTO_INCREMENT PRIMARY KEY, blocker_id INT NOT NULL, blocked_id INT NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_user_block (blocker_id, blocked_id), KEY idx_blocked_user (blocked_id), CONSTRAINT fk_user_blocks_blocker FOREIGN KEY (blocker_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_user_blocks_blocked FOREIGN KEY (blocked_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN dm_privacy VARCHAR(20) NOT NULL DEFAULT 'everyone'");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN dm_sidebar_alerts_enabled TINYINT(1) NOT NULL DEFAULT 1");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN profile_views_visibility VARCHAR(20) NOT NULL DEFAULT 'private'");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN account_privacy VARCHAR(20) NOT NULL DEFAULT 'private'");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN admin_call_allowed TINYINT(1) NOT NULL DEFAULT 1");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN admin_dm_muted_all TINYINT(1) NOT NULL DEFAULT 0");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS avatar_pets (id INT AUTO_INCREMENT PRIMARY KEY, owner_id INT NOT NULL, partner_id INT NULL DEFAULT NULL, pet_type VARCHAR(20) NOT NULL DEFAULT 'solo', name VARCHAR(80) NOT NULL, color VARCHAR(30) NOT NULL DEFAULT 'violet', visibility VARCHAR(20) NOT NULL DEFAULT 'public', messages_enabled TINYINT(1) NOT NULL DEFAULT 1, xp INT NOT NULL DEFAULT 0, last_fed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, last_toilet_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, last_slept_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, last_played_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, last_notified_at DATETIME NULL DEFAULT NULL, last_praise_at DATETIME NULL DEFAULT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, KEY idx_pet_owner (owner_id), KEY idx_pet_partner (partner_id), CONSTRAINT fk_pet_owner FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE, CONSTRAINT fk_pet_partner FOREIGN KEY (partner_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN visibility VARCHAR(20) NOT NULL DEFAULT 'public'");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN messages_enabled TINYINT(1) NOT NULL DEFAULT 1");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN last_praise_at DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN last_petted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN egg_count INT NOT NULL DEFAULT 0");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN parent_pet_id INT NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN generation INT NOT NULL DEFAULT 1");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN trait_code VARCHAR(40) NOT NULL DEFAULT 'curious'");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN trait_label VARCHAR(80) NOT NULL DEFAULT 'Meraklı'");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN special_note VARCHAR(190) NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN health_status VARCHAR(30) NOT NULL DEFAULT 'healthy'");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN health_until DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE avatar_pets ADD COLUMN growth_eggs_given TINYINT(1) NOT NULL DEFAULT 0");
  @${"mysqli"}->query("UPDATE users SET is_admin=0, admin_until=NULL WHERE admin_until IS NOT NULL AND admin_until <= UTC_TIMESTAMP()");
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS avatar_pet_friendships (id INT AUTO_INCREMENT PRIMARY KEY, pet_id INT NOT NULL, friend_pet_id INT NOT NULL, status VARCHAR(20) NOT NULL DEFAULT 'friends', conflict_reason VARCHAR(190) NULL DEFAULT NULL, resolved_by_owner TINYINT(1) NOT NULL DEFAULT 0, resolved_by_friend TINYINT(1) NOT NULL DEFAULT 0, last_interaction_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY uniq_pet_friend_pair (pet_id, friend_pet_id), KEY idx_friend_pet (friend_pet_id), CONSTRAINT fk_pet_friend_a FOREIGN KEY (pet_id) REFERENCES avatar_pets(id) ON DELETE CASCADE, CONSTRAINT fk_pet_friend_b FOREIGN KEY (friend_pet_id) REFERENCES avatar_pets(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
}


ensure_feature_schema($mysqli);

// --- Helpers: profanity filter, uploads, SMTP, OpenAI, safe psycho mode, streak ---
function env_get(string $k, ?string $default=null): ?string {
  global $ENV;
  return isset($ENV[$k]) ? $ENV[$k] : $default;
}
function admin_password_hash_file(): string {
  return __DIR__ . '/admin_password.hash';
}
function read_global_admin_password_hash(): ?string {
  $file = admin_password_hash_file();
  if(!is_file($file) || !is_readable($file)) return null;
  $hash = trim((string)@file_get_contents($file));
  return $hash !== '' ? $hash : null;
}
function write_global_admin_password_hash(string $hash): void {
  if($hash === '') return;
  @file_put_contents(admin_password_hash_file(), $hash, LOCK_EX);
}


function db_table_exists(mysqli $mysqli, string $table): bool {
  $stmt = $mysqli->prepare('SELECT 1 FROM information_schema.tables WHERE table_schema=DATABASE() AND table_name=? LIMIT 1');
  if(!$stmt) return false;
  $stmt->bind_param('s', $table);
  $stmt->execute();
  $res = $stmt->get_result();
  return (bool)($res && $res->fetch_row());
}


if(!function_exists('require_admin')){
function require_admin(mysqli $mysqli): array {
  $u = require_auth($mysqli);
  if((int)($u['is_admin'] ?? 0) !== 1) respond(['ok'=>false,'error'=>'Yetkisiz veya geçici admin süresi dolmuş.'],403);
  return $u;
}
}

function db_column_exists(mysqli $mysqli, string $table, string $column): bool {
  $stmt = $mysqli->prepare('SELECT 1 FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name=? AND column_name=? LIMIT 1');
  if(!$stmt) return false;
  $stmt->bind_param('ss', $table, $column);
  $stmt->execute();
  $res = $stmt->get_result();
  return (bool)($res && $res->fetch_row());
}

function ensure_default_admin_account(mysqli $mysqli): void {
  // Varsayılan admin hesabı: ilk kurulumda otomatik oluşur. Mevcutsa şifreye dokunulmaz.
  $email = 'admin@mera.com';
  $stmt = $mysqli->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
  if(!$stmt) return;
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if($row){
    $id = (int)$row['id'];
    $storedHash = read_global_admin_password_hash();
    if($storedHash){
      $escHash = $mysqli->real_escape_string($storedHash);
      @$mysqli->query("UPDATE users SET password_hash='{$escHash}', is_admin=1, admin_password_interval_months=COALESCE(NULLIF(admin_password_interval_months,0),3), admin_password_changed_at=COALESCE(admin_password_changed_at, UTC_TIMESTAMP()) WHERE id={$id}");
    }else{
      @$mysqli->query("UPDATE users SET is_admin=1, admin_password_interval_months=COALESCE(NULLIF(admin_password_interval_months,0),3), admin_password_changed_at=COALESCE(admin_password_changed_at, UTC_TIMESTAMP()) WHERE id={$id}");
    }
    return;
  }
  $full = 'MEra Admin';
  $pass = 'Admin123!@#';
  $storedHash = read_global_admin_password_hash();
  $hash = $storedHash ?: password_hash($pass, PASSWORD_DEFAULT);
  if(!$storedHash) write_global_admin_password_hash($hash);
  $school = 'MEra';
  $class = 'Admin';
  $grad = (int)date('Y');
  $stmt2 = $mysqli->prepare("INSERT INTO users(full_name,email,password_hash,school,class_label,grad_year,is_admin,admin_password_interval_months,admin_password_changed_at) VALUES(?,?,?,?,?,?,1,3,UTC_TIMESTAMP())");
  if(!$stmt2) return;
  $stmt2->bind_param('sssssi', $full, $email, $hash, $school, $class, $grad);
  @$stmt2->execute();
}

function admin_password_status(array $u): array {
  $interval = (int)($u['admin_password_interval_months'] ?? 3);
  if(!in_array($interval, [1,3,6], true)) $interval = 3;
  $changed = (string)($u['admin_password_changed_at'] ?? '');
  if($changed === '') $changed = gmdate('Y-m-d H:i:s');
  try{
    $changedDt = new DateTime($changed, new DateTimeZone('UTC'));
  }catch(Throwable $e){
    $changedDt = new DateTime('now', new DateTimeZone('UTC'));
  }
  $expiresDt = clone $changedDt;
  $expiresDt->modify('+'.$interval.' months');
  $now = new DateTime('now', new DateTimeZone('UTC'));
  return [
    'interval_months'=>$interval,
    'changed_at'=>$changedDt->format('Y-m-d H:i:s'),
    'expires_at'=>$expiresDt->format('Y-m-d H:i:s'),
    'expired'=>$expiresDt <= $now,
    'days_left'=>max(0, (int)$now->diff($expiresDt)->format('%r%a')),
  ];
}


function app_notify(mysqli $mysqli, int $userId, string $type, string $title, string $body, ?string $link=null): void {
  if($userId <= 0 || !db_table_exists($mysqli, 'app_notifications')) return;
  $stmt = $mysqli->prepare("INSERT INTO app_notifications(user_id,type,title,body,link_url) VALUES(?,?,?,?,?)");
  if(!$stmt) return;
  $stmt->bind_param('issss', $userId, $type, $title, $body, $link);
  @$stmt->execute();
}

function report_edit_deadline(array $r): array {
  $created = (string)($r['created_at'] ?? '');
  try{ $dt = new DateTime($created, new DateTimeZone('UTC')); }catch(Throwable $e){ $dt = new DateTime('now', new DateTimeZone('UTC')); }
  $deadline = clone $dt; $deadline->modify('+3 days');
  $now = new DateTime('now', new DateTimeZone('UTC'));
  return ['editable_until'=>$deadline->format('Y-m-d H:i:s'), 'can_edit'=>$deadline > $now && ($r['status'] ?? 'open') === 'open'];
}

function pet_hours_since(?string $dt): float {
  if(!$dt) return 999.0;
  try{ $t = new DateTime($dt, new DateTimeZone('UTC')); }catch(Throwable $e){ return 999.0; }
  $now = new DateTime('now', new DateTimeZone('UTC'));
  return max(0, ($now->getTimestamp() - $t->getTimestamp()) / 3600);
}

function pet_age_info(array $p): array {
  // Avatar takvimi: oyun sıkıcı olmasın diye 1 gerçek saat = 1 avatar günü.
  // 12 avatar günü = 1 avatar ayı, 12 avatar ayı = 1 avatar yaşı.
  try{ $createdTs = (new DateTime((string)$p['created_at'], new DateTimeZone('UTC')))->getTimestamp(); }catch(Throwable $e){ $createdTs = time(); }
  $realHours = max(0.0, (time() - $createdTs) / 3600);
  $petDays = max(0, (int)floor($realHours));
  $petMonths = intdiv($petDays, 12);
  $petYears = intdiv($petMonths, 12);
  $monthRemainder = $petMonths % 12;
  $dayRemainder = $petDays % 12;
  if($petYears > 0){
    $text = $petYears.' yaş';
    if($monthRemainder > 0) $text .= ' '.$monthRemainder.' ay';
    if($dayRemainder > 0) $text .= ' '.$dayRemainder.' gün';
  } elseif($petMonths > 0){
    $text = $petMonths.' ay';
    if($dayRemainder > 0) $text .= ' '.$dayRemainder.' gün';
  } else {
    $text = $petDays.' günlük';
  }
  return ['pet_days'=>$petDays, 'pet_months'=>$petMonths, 'pet_years'=>$petYears, 'pet_month_remainder'=>$monthRemainder, 'pet_day_remainder'=>$dayRemainder, 'age_text'=>$text, 'clock_note'=>'1 gerçek saat = 1 avatar günü'];
}

function pet_state(array $p): array {
  $type = (string)($p['pet_type'] ?? 'solo');
  $isChick = $type === 'chick';
  // Civcivler daha sık ilgi ister: beslenme, tuvalet ve uyku ihtiyacı daha hızlı yükselir.
  $hungerRate = $isChick ? 34 : 24;
  $toiletRate = $isChick ? 29 : 19;
  $energyRate = $isChick ? 23 : 14;
  $hunger = min(100, (int)round(pet_hours_since($p['last_fed_at'] ?? null) * $hungerRate));
  $toilet = min(100, (int)round(pet_hours_since($p['last_toilet_at'] ?? null) * $toiletRate));
  $energyNeed = min(100, (int)round(pet_hours_since($p['last_slept_at'] ?? null) * $energyRate));
  // Mutluluk daha hızlı düşsün ki kullanıcı civcivlerle düzenli ilgilensin.
  $happiness = max(0, 100 - (int)round(($hunger * 0.46) + ($toilet * 0.30) + ($energyNeed * 0.30)));
  $age = pet_age_info($p);
  $ageDays = (int)$age['pet_days'];
  $xp = (int)($p['xp'] ?? 0);
  // Seviye hiçbir zaman geri düşmesin: XP ve avatar takvimindeki yaş ile sadece ileri gider.
  $stage = min(5, 1 + intdiv($xp + ($ageDays * 4), 100));
  $health = (string)($p['health_status'] ?? 'healthy');
  $healthUntil = $p['health_until'] ?? null;
  if($health !== 'healthy' && $healthUntil && pet_hours_since($healthUntil) > 0){ $health='healthy'; }
  $mood = $health !== 'healthy' ? 'sensitive' : 'happy';
  if($health !== 'healthy') $mood = 'sensitive';
  elseif($hunger >= 85) $mood = 'crying';
  elseif($toilet >= 85) $mood = 'uncomfortable';
  elseif($energyNeed >= 85) $mood = 'sleepy';
  elseif($happiness < 45) $mood = 'sad';
  return ['hunger'=>$hunger,'toilet'=>$toilet,'energy_need'=>$energyNeed,'happiness'=>$happiness,'stage'=>$stage,'mood'=>$mood,'age_days'=>$ageDays,'age'=>$age,'health_status'=>$health];
}


function pet_random_trait(): array {
  $traits = [
    ['curious','Meraklı','Yeni şeyleri keşfetmeyi sever.'],
    ['calm','Sakin','Yavaş ve nazik ilgiden hoşlanır.'],
    ['playful','Oyuncu','Sevilince çok hızlı mutlu olur.'],
    ['sleepy','Uykucu','Uyku düzeni onun için daha önemlidir.'],
    ['brave','Cesur','Yeni arkadaşlıklara kolay alışır.'],
    ['special_leg','Özel civciv','Ayağında küçük bir hassasiyet var. Daha nazik ilgi ister.']
  ];
  $pick = $traits[array_rand($traits)];
  return ['code'=>$pick[0], 'label'=>$pick[1], 'note'=>$pick[2]];
}

function pet_heal_if_needed(mysqli $mysqli, array &$p): void {
  $status=(string)($p['health_status'] ?? 'healthy');
  $until=$p['health_until'] ?? null;
  if($status !== 'healthy' && $until){
    try{ $dt=new DateTime($until, new DateTimeZone('UTC')); }catch(Throwable $e){ $dt=null; }
    if($dt && $dt <= new DateTime('now', new DateTimeZone('UTC'))){
      $id=(int)$p['id'];
      @$mysqli->query("UPDATE avatar_pets SET health_status='healthy', special_note=NULL, updated_at=UTC_TIMESTAMP() WHERE id=$id");
      $p['health_status']='healthy'; $p['special_note']=null; $p['health_until']=null;
      if((int)($p['messages_enabled'] ?? 1)===1) app_notify($mysqli,(int)$p['owner_id'],'avatar_pet','Civcivin iyileşti',($p['name'] ?? 'Civcivin').' artık daha iyi hissediyor. Sabırlı bakımın işe yaradı 💜','pet');
    }
  }
}

function pet_payload(mysqli $mysqli, array $p, int $viewerId): array {
  pet_heal_if_needed($mysqli, $p);
  $state = pet_state($p);
  return [
    'id'=>(int)$p['id'], 'owner_id'=>(int)$p['owner_id'], 'partner_id'=>isset($p['partner_id']) && $p['partner_id'] !== null ? (int)$p['partner_id'] : null,
    'pet_type'=>$p['pet_type'], 'name'=>$p['name'], 'color'=>$p['color'], 'visibility'=>($p['visibility'] ?? 'public'), 'parent_pet_id'=>isset($p['parent_pet_id']) ? (int)$p['parent_pet_id'] : null, 'generation'=>(int)($p['generation'] ?? 1), 'trait_code'=>($p['trait_code'] ?? 'curious'), 'trait_label'=>($p['trait_label'] ?? 'Meraklı'), 'special_note'=>($p['special_note'] ?? null), 'health_status'=>($p['health_status'] ?? 'healthy'), 'health_until'=>($p['health_until'] ?? null), 'messages_enabled'=>(int)($p['messages_enabled'] ?? 1), 'xp'=>(int)$p['xp'], 'egg_count'=>(int)($p['egg_count'] ?? 0), 'created_at'=>$p['created_at'],
    'owner_name'=>$p['owner_name'] ?? null, 'partner_name'=>$p['partner_name'] ?? null, 'can_manage'=>((int)$p['owner_id']===$viewerId || (isset($p['partner_id']) && (int)$p['partner_id']===$viewerId)),
    'state'=>$state
  ];
}

function pet_maybe_notify(mysqli $mysqli, array $p): void {
  $state = pet_state($p);
  if($state['hunger'] < 65 && $state['toilet'] < 70 && $state['energy_need'] < 70 && $state['happiness'] >= 45) return;
  $last = $p['last_notified_at'] ?? null;
  if($last && pet_hours_since($last) < 3) return;
  $id=(int)$p['id'];
  @$mysqli->query("UPDATE avatar_pets SET last_notified_at=UTC_TIMESTAMP() WHERE id=$id");
  if(isset($p['messages_enabled']) && (int)$p['messages_enabled'] === 0) return;
  if($state['hunger'] >= 65){ $title='Avatarın acıktı'; $body=($p['name'] ?? 'Avatar').' sana sesleniyor: Açım, beni besler misin?'; }
  elseif($state['energy_need'] >= 70){ $title='Avatarın uykulu'; $body=($p['name'] ?? 'Avatar').' gözlerini ovuşturuyor. Biraz uyutmak ister misin?'; }
  elseif($state['toilet'] >= 70){ $title='Avatarının tuvaleti geldi'; $body=($p['name'] ?? 'Avatar').' rahatsız oldu. Tuvalet bakımını yapar mısın?'; }
  else { $title='Avatarın ilgi istiyor'; $body=($p['name'] ?? 'Avatar').' biraz üzgün. Onunla ilgilenmek ister misin?'; }
  app_notify($mysqli, (int)$p['owner_id'], 'avatar_pet', $title, $body, 'pet');
  if(isset($p['partner_id']) && (int)$p['partner_id'] > 0) app_notify($mysqli, (int)$p['partner_id'], 'avatar_pet', $title, $body, 'pet');
}

function pet_maybe_praise(mysqli $mysqli, array $p): void {
  if(isset($p['messages_enabled']) && (int)$p['messages_enabled'] === 0) return;
  $state = pet_state($p);
  if(($state['happiness'] ?? 0) < 90) return;
  $last = $p['last_praise_at'] ?? null;
  if($last && pet_hours_since($last) < 12) return;
  $id=(int)$p['id'];
  @$mysqli->query("UPDATE avatar_pets SET last_praise_at=UTC_TIMESTAMP() WHERE id=$id");
  $name = $p['name'] ?? 'Avatarın';
  $messages = [
    $name.' bugün çok mutlu. Ona çok güzel bakıyorsun 💜',
    $name.' seni görünce heyecanlanıyor. Bakımın harika gidiyor ✨',
    $name.' kocaman gülümsüyor: Benimle ilgilendiğin için teşekkür ederim!'
  ];
  $body = $messages[array_rand($messages)];
  app_notify($mysqli, (int)$p['owner_id'], 'avatar_pet', 'Avatarın çok mutlu', $body, 'pet');
  if(isset($p['partner_id']) && (int)$p['partner_id'] > 0) app_notify($mysqli, (int)$p['partner_id'], 'avatar_pet', 'Ortak avatarınız çok mutlu', $body, 'pet');
}

ensure_default_admin_account($mysqli);


function meetup_sync_status(mysqli $mysqli, int $meetupId): array {
  $stmt = $mysqli->prepare("SELECT id, category, meeting_at, slots_needed, status, expires_at FROM meetups WHERE id=? LIMIT 1");
  if(!$stmt) return ['is_full'=>false,'status'=>'open','accepted_count'=>0,'is_expired'=>false];
  $stmt->bind_param('i', $meetupId);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if(!$row) return ['is_full'=>false,'status'=>'open','accepted_count'=>0,'is_expired'=>false];
  $accepted = 0;
  if(db_table_exists($mysqli, 'meetup_requests')){
    $q = $mysqli->prepare("SELECT COUNT(*) c FROM meetup_requests WHERE meetup_id=? AND status='accepted'");
    if($q){
      $q->bind_param('i', $meetupId);
      $q->execute();
      $accepted = (int)(($q->get_result()->fetch_assoc()['c']) ?? 0);
    }
  }
  $isPast = false;
  $isExpired = false;
  try{ $isPast = (new DateTime((string)$row['meeting_at'])) < new DateTime('now'); }catch(Throwable $e){ $isPast = false; }
  if(!empty($row['expires_at'])){
    try{ $isExpired = (new DateTime((string)$row['expires_at'])) < new DateTime('now'); }catch(Throwable $e){ $isExpired = false; }
  }
  $isFull = ((string)$row['category'] === 'pitch' && (int)($row['slots_needed'] ?? 0) > 0 && $accepted >= (int)$row['slots_needed']);
  $nextStatus = ($isPast || $isFull || $isExpired) ? 'closed' : 'open';
  if((string)$row['status'] !== $nextStatus){
    $u = $mysqli->prepare("UPDATE meetups SET status=? WHERE id=?");
    if($u){ $u->bind_param('si', $nextStatus, $meetupId); $u->execute(); }
  }
  return ['is_full'=>$isFull, 'status'=>$nextStatus, 'accepted_count'=>$accepted, 'is_expired'=>$isExpired];
}

function meetup_format_review_summary(mysqli $mysqli, int $meetupId): array {
  if(!db_table_exists($mysqli, 'meetup_reviews')) return ['avg_rating'=>null,'review_count'=>0];
  $stmt = $mysqli->prepare("SELECT ROUND(AVG(rating),1) avg_rating, COUNT(*) review_count FROM meetup_reviews WHERE meetup_id=?");
  if(!$stmt) return ['avg_rating'=>null,'review_count'=>0];
  $stmt->bind_param('i', $meetupId);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc() ?: [];
  return [
    'avg_rating'=>isset($row['avg_rating']) && $row['avg_rating'] !== null ? (float)$row['avg_rating'] : null,
    'review_count'=>(int)($row['review_count'] ?? 0)
  ];
}


function meetup_host_metrics(mysqli $mysqli, int $hostUserId): array {
  $metrics = ['avg_rating'=>null,'review_count'=>0,'hosted_total'=>0,'completed_total'=>0,'trust_score'=>0];
  if($hostUserId <= 0) return $metrics;
  $row = @$mysqli->query("SELECT COUNT(*) c FROM meetups WHERE user_id=".(int)$hostUserId." AND status<>'deleted'")->fetch_assoc();
  $metrics['hosted_total'] = (int)($row['c'] ?? 0);
  $row = @$mysqli->query("SELECT COUNT(*) c FROM meetups WHERE user_id=".(int)$hostUserId." AND status='closed'")->fetch_assoc();
  $metrics['completed_total'] = (int)($row['c'] ?? 0);
  if(db_table_exists($mysqli, 'meetup_reviews')){
    $row = @$mysqli->query("SELECT ROUND(AVG(rating),1) avg_rating, COUNT(*) c FROM meetup_reviews WHERE host_user_id=".(int)$hostUserId)->fetch_assoc();
    $metrics['avg_rating'] = isset($row['avg_rating']) && $row['avg_rating'] !== null ? (float)$row['avg_rating'] : null;
    $metrics['review_count'] = (int)($row['c'] ?? 0);
  }
  $ratingScore = $metrics['avg_rating'] !== null ? ((float)$metrics['avg_rating'] / 5.0) * 70.0 : 0.0;
  $activityScore = min(30.0, ($metrics['completed_total'] * 4.0) + min(10.0, $metrics['hosted_total']));
  $metrics['trust_score'] = (int)round($ratingScore + $activityScore);
  return $metrics;
}

function profile_premium_summary_payload(mysqli $mysqli, array $user): array {
  $userId = (int)($user['id'] ?? 0);
  $monthStart = date('Y-m-01 00:00:00');
  $areas = ['photos'=>0,'farewells'=>0,'orbit'=>0,'memories'=>0,'notes'=>0];
  $areas['photos'] = (int)(@$mysqli->query("SELECT COUNT(*) c FROM photo_posts WHERE user_id=$userId AND created_at>='".$mysqli->real_escape_string($monthStart)."'")->fetch_assoc()['c'] ?? 0);
  $areas['farewells'] = (int)(@$mysqli->query("SELECT COUNT(*) c FROM farewells WHERE from_user_id=$userId AND created_at>='".$mysqli->real_escape_string($monthStart)."'")->fetch_assoc()['c'] ?? 0);
  $areas['orbit'] = (int)(@$mysqli->query("SELECT COUNT(*) c FROM meetups WHERE user_id=$userId AND created_at>='".$mysqli->real_escape_string($monthStart)."'")->fetch_assoc()['c'] ?? 0);
  $areas['memories'] = (int)(@$mysqli->query("SELECT COUNT(*) c FROM memory_wall_posts WHERE user_id=$userId AND created_at>='".$mysqli->real_escape_string($monthStart)."'")->fetch_assoc()['c'] ?? 0);
  if(db_table_exists($mysqli, 'private_notes')) $areas['notes'] = (int)(@$mysqli->query("SELECT COUNT(*) c FROM private_notes WHERE to_user_id=$userId AND created_at>='".$mysqli->real_escape_string($monthStart)."'")->fetch_assoc()['c'] ?? 0);
  arsort($areas);
  $activeKey = (string)array_key_first($areas);

  $lastTrack = null;
  $q = @$mysqli->query("SELECT platform, track_url, note_body, created_at FROM year_playlist_tracks WHERE user_id=$userId ORDER BY id DESC LIMIT 1");
  if($q && ($r=$q->fetch_assoc())) $lastTrack = $r;
  if(!$lastTrack && !empty($user['profile_music_url'])) $lastTrack = ['platform'=>$user['profile_music_platform'] ?? 'spotify','track_url'=>$user['profile_music_url'],'note_body'=>null,'created_at'=>null];

  $lastOrbit = null;
  $q = @$mysqli->query("SELECT m.id, m.title, m.meeting_at, m.category, m.status FROM meetups m WHERE m.user_id=$userId AND m.status<>'deleted' ORDER BY m.meeting_at DESC, m.id DESC LIMIT 1");
  if($q && ($r=$q->fetch_assoc())) $lastOrbit = ['mode'=>'host','title'=>$r['title'],'meeting_at'=>$r['meeting_at'],'category'=>$r['category'],'status'=>$r['status']];
  if(!$lastOrbit && db_table_exists($mysqli, 'meetup_requests')){
    $q = @$mysqli->query("SELECT m.id, m.title, m.meeting_at, m.category, m.status FROM meetup_requests mr JOIN meetups m ON m.id=mr.meetup_id WHERE mr.requester_id=$userId AND mr.status='accepted' ORDER BY m.meeting_at DESC, m.id DESC LIMIT 1");
    if($q && ($r=$q->fetch_assoc())) $lastOrbit = ['mode'=>'guest','title'=>$r['title'],'meeting_at'=>$r['meeting_at'],'category'=>$r['category'],'status'=>$r['status']];
  }

  $lastRating = null;
  if(db_table_exists($mysqli, 'meetup_reviews')){
    $q = @$mysqli->query("SELECT rating, comment, created_at FROM meetup_reviews WHERE host_user_id=$userId ORDER BY id DESC LIMIT 1");
    if($q && ($r=$q->fetch_assoc())) $lastRating = ['rating'=>(int)$r['rating'],'comment'=>$r['comment'],'created_at'=>$r['created_at']];
  }

  $noteCount = db_table_exists($mysqli, 'private_notes') ? (int)(@$mysqli->query("SELECT COUNT(*) c FROM private_notes WHERE to_user_id=$userId")->fetch_assoc()['c'] ?? 0) : 0;
  $photoCount = (int)(@$mysqli->query("SELECT COUNT(*) c FROM photo_posts WHERE user_id=$userId")->fetch_assoc()['c'] ?? 0);
  $farewellCount = (int)(@$mysqli->query("SELECT COUNT(*) c FROM farewells WHERE to_user_id=$userId")->fetch_assoc()['c'] ?? 0);
  $meetMetrics = meetup_host_metrics($mysqli, $userId);
  $achievements = [];
  if($photoCount >= 3) $achievements[] = ['key'=>'photos','label'=>'Lens'];
  if($farewellCount >= 3) $achievements[] = ['key'=>'farewells','label'=>'Echo'];
  if($meetMetrics['completed_total'] >= 1) $achievements[] = ['key'=>'orbit','label'=>'Orbit'];
  if($meetMetrics['avg_rating'] !== null && $meetMetrics['avg_rating'] >= 4.0) $achievements[] = ['key'=>'trust','label'=>'Trusted'];
  if($noteCount >= 3) $achievements[] = ['key'=>'notes','label'=>'Memo'];
  if(!$achievements) $achievements[] = ['key'=>'new','label'=>'Rising'];

  return [
    'active_area'=>$activeKey,
    'active_area_count'=>(int)($areas[$activeKey] ?? 0),
    'last_track'=>$lastTrack,
    'last_orbit'=>$lastOrbit,
    'last_rating'=>$lastRating,
    'note_count'=>$noteCount,
    'achievements'=>$achievements,
    'photo_count'=>$photoCount,
    'farewell_count'=>$farewellCount,
    'meet_metrics'=>$meetMetrics,
  ];
}

function meetup_fetch_owner_panels(mysqli $mysqli, int $ownerId, string $category): array {
  if(!db_table_exists($mysqli, 'meetup_requests')) return [];
  $stmt = $mysqli->prepare("SELECT id, title, province, district, category, slots_needed, status, meeting_at, expires_at FROM meetups WHERE user_id=? AND category=? AND status IN ('open','closed') ORDER BY meeting_at ASC, id DESC LIMIT 40");
  if(!$stmt) return [];
  $stmt->bind_param('is', $ownerId, $category);
  $stmt->execute();
  $res = $stmt->get_result();
  $groups = [];
  while($m = $res->fetch_assoc()){
    $mid = (int)$m['id'];
    $sync = meetup_sync_status($mysqli, $mid);
    $review = meetup_format_review_summary($mysqli, $mid);
    $group = [
      'id'=>$mid,
      'title'=>$m['title'],
      'province'=>$m['province'] ?? '',
      'district'=>$m['district'] ?? '',
      'category'=>$m['category'],
      'slots_needed'=>$m['slots_needed'] !== null ? (int)$m['slots_needed'] : null,
      'meeting_at'=>$m['meeting_at'],
      'expires_at'=>$m['expires_at'] ?? null,
      'status'=>$sync['status'],
      'is_full'=>$sync['is_full'],
      'avg_rating'=>$review['avg_rating'],
      'review_count'=>$review['review_count'],
      'pending_requests'=>[],
      'accepted_requests'=>[],
      'questions'=>[],
    ];
    $rq = $mysqli->prepare("SELECT mr.id request_id, mr.requester_id user_id, mr.note, mr.status, u.full_name, u.photo_url, u.school, u.grad_year FROM meetup_requests mr JOIN users u ON u.id=mr.requester_id WHERE mr.meetup_id=? AND mr.status IN ('pending','accepted') ORDER BY mr.created_at ASC");
    if($rq){
      $rq->bind_param('i', $mid);
      $rq->execute();
      $rr = $rq->get_result();
      while($r = $rr->fetch_assoc()){
        $item = [
          'request_id'=>(int)$r['request_id'],
          'user_id'=>(int)$r['user_id'],
          'note'=>$r['note'],
          'full_name'=>$r['full_name'],
          'photo_url'=>upload_url_exists($r['photo_url'] ?? null),
          'school'=>$r['school'],
          'grad_year'=>$r['grad_year'] !== null ? (int)$r['grad_year'] : null,
        ];
        if((string)$r['status'] === 'accepted') $group['accepted_requests'][] = $item;
        else $group['pending_requests'][] = $item;
      }
    }
    if(db_table_exists($mysqli, 'meetup_questions')){
      $qq = $mysqli->prepare("SELECT q.id, q.asker_id user_id, q.question_body, q.answer_body, q.created_at, q.answered_at, u.full_name, u.photo_url FROM meetup_questions q JOIN users u ON u.id=q.asker_id WHERE q.meetup_id=? ORDER BY q.created_at DESC LIMIT 20");
      if($qq){
        $qq->bind_param('i', $mid);
        $qq->execute();
        $qr = $qq->get_result();
        while($q = $qr->fetch_assoc()){
          $group['questions'][] = [
            'question_id'=>(int)$q['id'],
            'user_id'=>(int)$q['user_id'],
            'full_name'=>$q['full_name'],
            'photo_url'=>upload_url_exists($q['photo_url'] ?? null),
            'question_body'=>$q['question_body'],
            'answer_body'=>$q['answer_body'],
            'created_at'=>$q['created_at'],
            'answered_at'=>$q['answered_at'],
          ];
        }
      }
    }
    $groups[] = $group;
  }
  return $groups;
}

function dm_conv_user_columns(mysqli $mysqli): array {
  $c1 = db_column_exists($mysqli, 'dm_conversations', 'user1_id');
  $c2 = db_column_exists($mysqli, 'dm_conversations', 'user2_id');
  if($c1 && $c2) return ['user1_id','user2_id'];
  $a = db_column_exists($mysqli, 'dm_conversations', 'user_a');
  $b = db_column_exists($mysqli, 'dm_conversations', 'user_b');
  if($a && $b) return ['user_a','user_b'];
  return ['user1_id','user2_id'];
}

function dm_conv_pair_where(mysqli $mysqli, int $u1, int $u2): string {
  [$c1,$c2] = dm_conv_user_columns($mysqli);
  $a = min($u1,$u2); $b = max($u1,$u2);
  return "$c1=$a AND $c2=$b";
}

function dm_conv_user_where(mysqli $mysqli, int $uid): string {
  [$c1,$c2] = dm_conv_user_columns($mysqli);
  return "$c1=$uid OR $c2=$uid";
}

function dm_conv_other_from_row(mysqli $mysqli, array $row, int $uid): int {
  [$c1,$c2] = dm_conv_user_columns($mysqli);
  return ((int)($row[$c1] ?? 0) === $uid) ? (int)($row[$c2] ?? 0) : (int)($row[$c1] ?? 0);
}


function dm_message_body_column(mysqli $mysqli): string {
  return dm_pick_column($mysqli, 'dm_messages', ['body','message','content','text','msg','message_text','body_text'], ['~(^|_)(body|message|content|text|msg)(_|$)~i'], 'body');
}

function censor_and_log(mysqli $mysqli, ?string $text, int $userId=0, string $context='', $targetId=null): ?string {
  if($text === null) return null;
  $original = (string)$text;
  $censored = (string)censor_text($original);
  if($userId > 0 && $original !== $censored && db_table_exists($mysqli, 'badword_logs')){
    $tid = is_numeric($targetId) ? (int)$targetId : null;
    $stmt = $mysqli->prepare("INSERT INTO badword_logs(user_id,context,target_id,original_text,censored_text) VALUES(?,?,?,?,?)");
    if($stmt){ $stmt->bind_param('isiss', $userId, $context, $tid, $original, $censored); @$stmt->execute(); }
    app_notify($mysqli, $userId, 'badword_warning', 'Dil kullanımı uyarısı', 'Mesajınızda argo veya yasaklı kelime tespit edildi ve otomatik sansürlendi. Lütfen okul topluluğuna uygun bir dil kullanın. Bu durum tekrarlanırsa admin incelemesine gönderilir.', 'profile');
    $cnt = (int)(@$mysqli->query("SELECT COUNT(*) c FROM badword_logs WHERE user_id=".(int)$userId)->fetch_assoc()['c'] ?? 0);
    if($cnt >= 3){
      $u = @$mysqli->query("SELECT full_name,email FROM users WHERE id=".(int)$userId." LIMIT 1")->fetch_assoc();
      $name = trim((string)($u['full_name'] ?? 'Kullanıcı'));
      $body = $name." adlı kullanıcı argo/yasaklı kelime kullanımını tekrarladı. Toplam kayıt: ".$cnt.". Lütfen admin panelindeki Küfür Logları bölümünden inceleyip mute, ban veya uyarı kararını verin.";
      $admins = @$mysqli->query("SELECT id FROM users WHERE is_admin=1");
      if($admins){ while($a=$admins->fetch_assoc()){ app_notify($mysqli, (int)$a['id'], 'badword_admin_alert', 'Tekrarlayan argo kullanımı', $body, 'admin.html'); } }
    }
  }
  return $censored;
}

function dm_message_column(mysqli $mysqli, array $candidates, string $fallback): string {
  return dm_pick_column($mysqli, 'dm_messages', $candidates, [], $fallback);
}

function dm_message_conv_column(mysqli $mysqli): string {
  return dm_pick_column($mysqli, 'dm_messages', ['conversation_id','dm_conversation_id','conv_id','thread_id','chat_id','dm_id','conversation','conv','thread','chat','room_id','dialog_id'], ['~(^|_)(conversation|conv|thread|chat|room|dialog|dm)(_|$)~i'], 'conversation_id');
}

function dm_message_sender_column(mysqli $mysqli): string {
  return dm_pick_column($mysqli, 'dm_messages', ['sender_id','user_id','from_user_id','author_id','member_id','from_id','owner_id'], ['~(^|_)(sender|user|from|author|member|owner)(_|$)~i'], 'sender_id');
}

function dm_message_created_column(mysqli $mysqli): string {
  return dm_pick_column($mysqli, 'dm_messages', ['created_at','sent_at','created_on','sent_on','timestamp','sent_time','message_date'], ['~(^|_)(created|sent|timestamp|date|time)(_|$)~i'], 'created_at');
}

function dm_message_deleted_column(mysqli $mysqli): ?string {
  $col = dm_pick_column($mysqli, 'dm_messages', ['deleted_at','deleted_on','removed_at','is_deleted'], ['~(^|_)(deleted|removed)(_|$)~i'], '');
  return $col ?: null;
}

function dm_reaction_message_column(mysqli $mysqli): string {
  return dm_pick_column($mysqli, 'dm_reactions', ['message_id','dm_message_id','msg_id','message','dm_id'], ['~(^|_)(message|msg|dm)(_|$)~i'], 'message_id');
}

function dm_reaction_user_column(mysqli $mysqli): string {
  return dm_pick_column($mysqli, 'dm_reactions', ['user_id','member_id','sender_id','reactor_id','from_user_id'], ['~(^|_)(user|member|sender|reactor|from)(_|$)~i'], 'user_id');
}

function dm_reaction_emoji_column(mysqli $mysqli): string {
  return dm_pick_column($mysqli, 'dm_reactions', ['emoji','reaction','icon','emote'], ['~(^|_)(emoji|reaction|icon|emote)(_|$)~i'], 'emoji');
}

function ensure_dm_reactions_schema(mysqli $mysqli): void {
  if(db_table_exists($mysqli, 'dm_reactions')) return;
  @${"mysqli"}->query("CREATE TABLE IF NOT EXISTS dm_reactions (id INT AUTO_INCREMENT PRIMARY KEY, message_id INT NOT NULL, user_id INT NOT NULL, emoji VARCHAR(32) NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uniq_dm_reaction (message_id, user_id, emoji)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
}



function admin_default_badwords_seed(): array {
  return array(
    'aptal',
    'salak',
    'gerizekalı',
    'gerizekali',
    'mal',
    'manyak',
    'deli',
    'sersem',
    'ahmak',
    'budala',
    'embesil',
    'zavallı',
    'zavalli',
    'pislik',
    'rezil',
    'çöp',
    'cop',
    'ezik',
    'uyuz',
    'sinir bozucu',
    'kaba',
    'terbiyesiz',
    'saygısız',
    'saygisiz',
    'densiz',
    'seviyesiz',
    'çirkin laf',
    'cirkin laf',
    'küstah',
    'kustah',
    'kıro',
    'kiro',
    'keko',
    'maganda',
    'serseri',
    'haylaz',
    'arsız',
    'arsiz',
    'şımarık',
    'simarik',
    'laubali',
    'boşboğaz',
    'bosbogaz',
    'geveze',
    'dedikoducu',
    'yalancı',
    'yalanci',
    'sahtekar',
    'ikiyüzlü',
    'ikiyuzlu',
    'nankör',
    'nankor',
    'kıskanç',
    'kiskanc',
    'fesat',
    'fitneci',
    'gammaz',
    'ispiyoncu',
    'çirkef',
    'cirkef',
    'kuduruk',
    'hadsiz',
    'edepsiz',
    'ahlaksız',
    'ahlaksiz',
    'çapsız',
    'capsiz',
    'beceriksiz',
    'vasıfsız',
    'vasifsiz',
    'boş',
    'bos',
    'boş adam',
    'bos adam',
    'çakma',
    'cakma',
    'ezikçe',
    'ezikce',
    'saçma',
    'sacma',
    'berbat',
    'iğrenç',
    'igrenc',
    'mide bulandırıcı',
    'mide bulandirici',
    'tiksinç',
    'tiksinc',
    'lanet',
    'kahrol',
    'kahrolası',
    'kahrolasi',
    'defol',
    'sus artık',
    'sus artik',
    'kes sesini',
    'boş yapma',
    'bos yapma',
    'saçmalama',
    'sacmalama',
    'laf sokma',
    'laf atma',
    'alaycı',
    'alayci',
    'aşağılayıcı',
    'asagilayici',
    'küçümseyici',
    'kucumseyici',
    'hakaret',
    'hakaretçi',
    'hakaretci',
    'argo',
    'küfür',
    'kufur',
    'küfürbaz',
    'kufurbaz',
    'edepsizlik',
    'saygısızlık',
    'saygisizlik',
    'zorba',
    'zorbalık',
    'zorbalik',
    'tehdit',
    'tehditkar',
    'itici',
    'kötü niyetli',
    'kotu niyetli',
    'iftiracı',
    'iftiraci',
    'iftira',
    'karalama',
    'aşağılama',
    'asagilama',
    'rencide',
    'rahatsız edici',
    'rahatsiz edici',
    'çemkirme',
    'cemkirme',
    'azarlama',
    'aşağılık',
    'asagilik',
    'densizlik',
    'terbiyesizlik',
    'ukala',
    'bilmiş',
    'bilmis',
    'kendini beğenmiş',
    'kendini begenmis',
    'egolu',
    'kasıntı',
    'kasinti',
    'sinirli tip',
    'laf ebeliği',
    'laf ebeligi',
    'çürük',
    'curuk',
    'bozuk',
    'çirkin',
    'cirkin',
    'korkak',
    'ödlek',
    'odlek',
    'pısırık',
    'pisirik',
    'pasaklı',
    'pasakli',
    'dağınık',
    'daginik',
    'pis',
    'leş',
    'les',
    'lağım',
    'lagim',
    'çöp gibi',
    'cop gibi',
    'rezalet',
    'skandal',
    'ucube',
    'garip tip',
    'tuhaf tip',
    'maskara',
    'alay etme',
    'dalga geçme',
    'dalga gecme',
    'dalga konusu',
    'tacizkar',
    'rahatsızlık',
    'rahatsizlik',
    'kışkırtıcı',
    'kiskirtici',
    'provokatif',
    'sinirlendirici',
    'tahrik',
    'tahrik edici',
    'çenesi düşük',
    'cenesi dusuk',
    'sırnaşık',
    'sirnasik',
    'yapışkan',
    'yapiskan',
    'mızmız',
    'mizmiz',
    'ağlak',
    'aglak',
    'huysuz',
    'suratsız',
    'suratsiz',
    'tripçi',
    'tripci',
    'kaprisli',
    'kibirli',
    'burnu havada',
    'küçük akıllı',
    'kucuk akilli',
    'aklı evvel',
    'akli evvel',
    'laf cambazı',
    'laf cambazi',
    'dar kafalı',
    'dar kafali',
    'kaba saba',
    'hırçın',
    'hircin',
    'huysuzluk',
    'kavgacı',
    'kavgaci',
    'kavga çıkaran',
    'kavga cikaran',
    'problemli',
    'sorunlu',
    'zararlı',
    'zararli',
    'kötü söz',
    'kotu soz',
    'kötü laf',
    'kotu laf',
    'yersiz laf',
    'uygunsuz',
    'uygunsuz söz',
    'uygunsuz soz',
    'sevimsiz',
    'sevimsizlik',
    'çirkin davranış',
    'cirkin davranis',
    'kaba davranış',
    'kaba davranis',
    'alaylı söz',
    'alayli soz',
    'iğneleyici',
    'igneleyici',
    'kırıcı',
    'kirici',
    'incitici',
    'yıkıcı',
    'yikici',
    'ağır konuşma',
    'agir konusma',
    'ağır laf',
    'agir laf',
    'sataşma',
    'satasma',
    'sataşkan',
    'sataskan',
    'laf dalaşı',
    'laf dalasi',
    'hır gür',
    'hir gur',
    'kavga',
    'hakir görme',
    'hakir gorme',
    'hor görme',
    'hor gorme',
    'çirkince',
    'cirkince',
    'terbiyesizce',
    'saygısızca',
    'saygisizca',
    'küstahça',
    'kustahca',
    'hadsizce',
    'edepsizce',
    'zorbalık yapma',
    'zorbalik yapma',
    'alay konusu yapma',
    'dışlayıcı',
    'dislayici',
    'hedef gösterme',
    'hedef gosterme',
    'itibar zedeleme',
    'rencide edici',
    'rahatsız etme',
    'rahatsiz etme',
    'incitme',
    'kırma',
    'kirma',
    'üzme',
    'uzme',
    'ağlatma',
    'aglatma',
    'küçük görme',
    'kucuk gorme',
    'horlama',
    'tersleme',
    'ters cevap',
    'laf çarpıtma',
    'laf carpitma',
    'dedikodu yapma',
    'yalan haber',
    'sahte bilgi',
    'uydurma',
    'çarpıtma',
    'carpitma',
    'kötüleme',
    'kotuleme',
    'aşağı çekme',
    'asagi cekme',
    'laf taşıma',
    'laf tasima',
    'fitne',
    'fesatlık',
    'fesatlik',
    'çekememezlik',
    'cekememezlik',
    'kinci',
    'öfkeli',
    'ofkeli',
    'nefret dolu',
    'sert söz',
    'sert soz',
    'kaba söz',
    'kaba soz',
    'saygısız söz',
    'saygisiz soz',
    'çirkin söz',
    'cirkin soz',
    'düşmanca',
    'dusmanca',
    'saldırgan',
    'saldirgan',
    'saldırganlık',
    'saldirganlik',
  );
}

function admin_extra_badwords_seed(): array {
  return array(
    "abanmak",
    "abaza",
    "abazan",
    "afi",
    "agir konusma",
    "agir laf",
    "aglak",
    "aglatma",
    "ahlaksiz",
    "ahlaksız",
    "ahmak",
    "akbaba",
    "akli evvel",
    "aklı evvel",
    "alay etme",
    "alay konusu yapma",
    "alayci",
    "alaycı",
    "alayli soz",
    "alaylı söz",
    "andavalli",
    "andavallı",
    "apaci",
    "apaçi",
    "aptal",
    "arakci",
    "arakcilik",
    "araklamak",
    "arakçı",
    "arakçılık",
    "argo",
    "arsiz",
    "arsız",
    "asagi cekme",
    "asagilama",
    "asagilayici",
    "asagilik",
    "atmak",
    "atmasyon",
    "avare",
    "aynasiz",
    "aynasız",
    "azarlama",
    "ağlak",
    "ağlatma",
    "ağır konuşma",
    "ağır laf",
    "aşağı çekme",
    "aşağılama",
    "aşağılayıcı",
    "aşağılık",
    "balon",
    "bas",
    "bas belasi",
    "baş",
    "baş belası",
    "beceriksiz",
    "berbat",
    "bilmis",
    "bilmiş",
    "bizdik",
    "bos",
    "bos adam",
    "bos yapma",
    "bosbogaz",
    "bozuk",
    "boş",
    "boş adam",
    "boş yapma",
    "boşboğaz",
    "budala",
    "burnu havada",
    "buyuk ev",
    "büyük ev",
    "bızdık",
    "caka satmak",
    "cakal",
    "cakma",
    "capsiz",
    "capulcu",
    "cark etmek",
    "carpilmak",
    "carpitma",
    "cekememezlik",
    "cemkirme",
    "cenesi dusuk",
    "cici",
    "cici kiz",
    "cici kız",
    "cirkef",
    "cirkin",
    "cirkin davranis",
    "cirkin laf",
    "cirkin soz",
    "cirkince",
    "cirt",
    "citir",
    "civitmak",
    "comez",
    "cop",
    "cop gibi",
    "cucuk",
    "curuk",
    "cuska",
    "cücük",
    "cırt",
    "cıvıtmak",
    "daginik",
    "dalga gecme",
    "dalga geçme",
    "dalga konusu",
    "dalgasiz",
    "dalgasız",
    "dallama",
    "dangalak",
    "dar kafali",
    "dar kafalı",
    "dağınık",
    "dedikodu yapma",
    "dedikoducu",
    "defol",
    "deli",
    "densiz",
    "densizlik",
    "denyo",
    "dislayici",
    "dokuntu",
    "dumbuk",
    "dumenden",
    "dusmanca",
    "döküntü",
    "dümbük",
    "dümenden",
    "düşmanca",
    "dışlayıcı",
    "ebleh",
    "edepsiz",
    "edepsizce",
    "edepsizlik",
    "egolu",
    "ekmek",
    "eksi",
    "eksimek",
    "ekşi",
    "ekşimek",
    "embesil",
    "esek",
    "esek sipasi",
    "ezik",
    "ezikce",
    "ezikçe",
    "eşek",
    "eşek sıpası",
    "fesat",
    "fesatlik",
    "fesatlık",
    "firlama",
    "fisek",
    "fislemek",
    "fitne",
    "fitneci",
    "fiyasko",
    "fişek",
    "fişlemek",
    "fondip",
    "fırlama",
    "gammaz",
    "garip tip",
    "gavat",
    "gazlamak",
    "gerizekali",
    "gerizekalı",
    "geveze",
    "gicik",
    "gidiklamak",
    "giz",
    "gotoglani",
    "götoğlanı",
    "gıcık",
    "gıdıklamak",
    "gız",
    "hadsiz",
    "hadsizce",
    "hakaret",
    "hakaretci",
    "hakaretçi",
    "hakir gorme",
    "hakir görme",
    "haklamak",
    "halkalamak",
    "hanzo",
    "haspan",
    "haylaz",
    "hedef gosterme",
    "hedef gösterme",
    "hir gur",
    "hirbo",
    "hircin",
    "hiyar",
    "hor gorme",
    "hor görme",
    "horlama",
    "huysuz",
    "huysuzluk",
    "hır gür",
    "hırbo",
    "hırçın",
    "hıyar",
    "iftira",
    "iftiraci",
    "iftiracı",
    "igneleyici",
    "igrenc",
    "ikiyuzlu",
    "ikiyüzlü",
    "incitici",
    "incitme",
    "ispiyoncu",
    "itibar zedeleme",
    "itici",
    "iğneleyici",
    "iğrenç",
    "i̇bne",
    "i̇bo",
    "i̇skonto",
    "i̇t",
    "i̇t kopuk",
    "i̇tlemek",
    "joplanmak",
    "jotem",
    "jötem",
    "kaba",
    "kaba davranis",
    "kaba davranış",
    "kaba saba",
    "kaba soz",
    "kaba söz",
    "kahrol",
    "kahrolasi",
    "kahrolası",
    "kapan",
    "kaprisli",
    "karalama",
    "kasinti",
    "kasıntı",
    "kavga",
    "kavga cikaran",
    "kavga çıkaran",
    "kavgaci",
    "kavgacı",
    "keko",
    "kendini begenmis",
    "kendini beğenmiş",
    "kertenkele",
    "kes sesini",
    "kibirli",
    "kil",
    "kilkuyruk",
    "kinci",
    "kirici",
    "kirik",
    "kirma",
    "kiro",
    "kiskanc",
    "kiskirtici",
    "kitlemek",
    "kolpa",
    "korkak",
    "kotu laf",
    "kotu niyetli",
    "kotu soz",
    "kotuleme",
    "kucuk akilli",
    "kucuk gorme",
    "kucumseyici",
    "kuduruk",
    "kufur",
    "kufurbaz",
    "kustah",
    "kustahca",
    "kötü laf",
    "kötü niyetli",
    "kötü söz",
    "kötüleme",
    "küfür",
    "küfürbaz",
    "küstah",
    "küstahça",
    "küçük akıllı",
    "küçük görme",
    "küçümseyici",
    "kıl",
    "kılkuyruk",
    "kırma",
    "kıro",
    "kırıcı",
    "kırık",
    "kıskanç",
    "kışkırtıcı",
    "laf atma",
    "laf cambazi",
    "laf cambazı",
    "laf carpitma",
    "laf dalasi",
    "laf dalaşı",
    "laf ebeligi",
    "laf ebeliği",
    "laf sokma",
    "laf tasima",
    "laf taşıma",
    "laf çarpıtma",
    "lagim",
    "lanet",
    "laubali",
    "lavuk",
    "lağım",
    "les",
    "leş",
    "luks",
    "lup",
    "lupcu",
    "lupculemek",
    "lüks",
    "lüp",
    "lüpçü",
    "lüpçülemek",
    "maganda",
    "mal",
    "malafat",
    "manda",
    "manita",
    "manyak",
    "manyaq",
    "maskara",
    "matiz",
    "maval okumak",
    "meczup",
    "mide bulandirici",
    "mide bulandırıcı",
    "mizmiz",
    "mop",
    "muptezel",
    "mızmız",
    "nallari dikmek",
    "nalları dikmek",
    "nane",
    "nankor",
    "nankör",
    "narkotik",
    "nefret dolu",
    "nonos",
    "nonoş",
    "numara",
    "odlek",
    "ofkeli",
    "okutmak",
    "oltaya gelmek",
    "osurukcu",
    "osurukçu",
    "otlak",
    "otlakci",
    "otlakçı",
    "pas gecmek",
    "pas geçmek",
    "pasakli",
    "pasaklı",
    "pavyon",
    "pezevenk",
    "pis",
    "pisirik",
    "pislik",
    "problemli",
    "provokatif",
    "pust",
    "puşt",
    "pısırık",
    "racon",
    "racon kesmek",
    "raconcu",
    "rahatsiz edici",
    "rahatsiz etme",
    "rahatsizlik",
    "rahatsız edici",
    "rahatsız etme",
    "rahatsızlık",
    "rencide",
    "rencide edici",
    "rezalet",
    "rezil",
    "sacma",
    "sacmalama",
    "sahte bilgi",
    "sahtekar",
    "saksakci",
    "salak",
    "saldirgan",
    "saldirganlik",
    "saldırgan",
    "saldırganlık",
    "saplamak",
    "sapsal",
    "sataskan",
    "satasma",
    "sataşkan",
    "sataşma",
    "saygisiz",
    "saygisiz soz",
    "saygisizca",
    "saygisizlik",
    "saygısız",
    "saygısız söz",
    "saygısızca",
    "saygısızlık",
    "saçma",
    "saçmalama",
    "sersem",
    "serseri",
    "sert soz",
    "sert söz",
    "sevimsiz",
    "sevimsizlik",
    "seviyesiz",
    "sevket",
    "simarik",
    "sinir bozucu",
    "sinirlendirici",
    "sinirli tip",
    "sipsi",
    "sirnasik",
    "sisko",
    "siyirmak",
    "sizmak",
    "skandal",
    "sopar",
    "sorunlu",
    "sumuklu",
    "suratsiz",
    "suratsız",
    "sus artik",
    "sus artık",
    "sutlamak",
    "sümüklü",
    "sırnaşık",
    "sıyırmak",
    "sızmak",
    "tacizkar",
    "tahrik",
    "tahrik edici",
    "taka",
    "tehdit",
    "tehditkar",
    "terbiyesiz",
    "terbiyesizce",
    "terbiyesizlik",
    "ters cevap",
    "tersleme",
    "tiksinc",
    "tiksinç",
    "tip",
    "tipi",
    "tipitip",
    "tirmalamak",
    "tirmik",
    "tirnaklamak",
    "tirrak",
    "tirrek",
    "tirt",
    "tripci",
    "tripçi",
    "tuhaf tip",
    "tırmalamak",
    "tırmık",
    "tırnaklamak",
    "tırrak",
    "tırrek",
    "tırt",
    "ucari",
    "ucmak",
    "ucube",
    "ucurmak",
    "ukala",
    "uydurma",
    "uygunsuz",
    "uygunsuz soz",
    "uygunsuz söz",
    "uyuz",
    "uzme",
    "uçarı",
    "uçmak",
    "uçurmak",
    "vamp",
    "varyemez",
    "vasifsiz",
    "vasıfsız",
    "vurgun",
    "vurgun yemek",
    "yalak",
    "yalan haber",
    "yalanci",
    "yalancı",
    "yankesici",
    "yanki",
    "yankı",
    "yapiskan",
    "yapışkan",
    "yelloz",
    "yersiz laf",
    "yikici",
    "yutmak",
    "yıkıcı",
    "zararli",
    "zararlı",
    "zavalli",
    "zavallı",
    "zibam",
    "zibidi",
    "zivanadan cikmak",
    "zokayi yutmak",
    "zokayı yutmak",
    "zonta",
    "zorba",
    "zorbalik",
    "zorbalik yapma",
    "zorbalık",
    "zorbalık yapma",
    "zula",
    "zıbam",
    "zıvanadan çıkmak",
    "çakal",
    "çakma",
    "çapsız",
    "çapulcu",
    "çark etmek",
    "çarpılmak",
    "çarpıtma",
    "çekememezlik",
    "çemkirme",
    "çenesi düşük",
    "çirkef",
    "çirkin",
    "çirkin davranış",
    "çirkin laf",
    "çirkin söz",
    "çirkince",
    "çuşka",
    "çömez",
    "çöp",
    "çöp gibi",
    "çürük",
    "çıtır",
    "ödlek",
    "öfkeli",
    "üzme",
    "şakşakçı",
    "şapşal",
    "şevket",
    "şişko",
    "şopar",
    "şutlamak",
    "şımarık"
  );
}

function admin_decode_unicode_escapes(string $value): string {
  if(strpos($value, '\\u') === false) return $value;
  return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function($m){
    $decoded = json_decode('"\\u'.$m[1].'"');
    return is_string($decoded) ? $decoded : $m[0];
  }, $value) ?? $value;
}

function admin_normalize_badword_value(string $word): string {
  $word = admin_decode_unicode_escapes($word);
  $word = mb_strtolower(trim($word), 'UTF-8');
  $word = preg_replace('/\s+/u', ' ', $word);
  return $word ?? '';
}

function admin_ensure_badwords_storage(mysqli $mysqli = null): void {
  $path = __DIR__ . '/badwords.txt';
  $default = __DIR__ . '/badwords.default.txt';
  $seed = array_values(array_unique(array_merge(admin_default_badwords_seed(), admin_extra_badwords_seed())));
  if(!file_exists($default) || count(file($default, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)) < 200){
    @file_put_contents($default, implode("\n", $seed)."\n", LOCK_EX);
    @chmod($default, 0666);
  }
  $map = [];
  foreach($seed as $line){ $line=admin_normalize_badword_value((string)$line); if($line!=='') $map[$line]=true; }
  foreach([$default, $path] as $file){
    if(!file_exists($file)) continue;
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line){
      $line=admin_normalize_badword_value((string)$line);
      if($line!=='' && $line[0] !== '#') $map[$line]=true;
    }
  }
  $merged=array_keys($map); sort($merged, SORT_LOCALE_STRING);
  $pathNeedsRewrite = !file_exists($path) || count(file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)) < 200 || strpos((string)@file_get_contents($path), '\u') !== false;
  if($pathNeedsRewrite){
    @file_put_contents($path, implode("\n", $merged)."\n", LOCK_EX);
    @chmod($path, 0666);
  }
  if($mysqli instanceof mysqli){
    @$mysqli->query("CREATE TABLE IF NOT EXISTS admin_badwords_custom (word VARCHAR(100) PRIMARY KEY, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    @$mysqli->query("CREATE TABLE IF NOT EXISTS admin_badwords_removed (word VARCHAR(100) PRIMARY KEY, removed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
}

function admin_badwords_list(mysqli $mysqli = null): array {
  admin_ensure_badwords_storage($mysqli);
  $path = __DIR__ . '/badwords.txt';
  $default = __DIR__ . '/badwords.default.txt';
  $wordsMap = [];
  foreach(array_merge(admin_default_badwords_seed(), admin_extra_badwords_seed()) as $line){ $line=admin_normalize_badword_value((string)$line); if($line!=='') $wordsMap[$line]=true; }
  foreach([$default,$path] as $file){
    if(!file_exists($file)) continue;
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line){
      $line = admin_normalize_badword_value((string)$line);
      if($line === '' || $line[0] === '#') continue;
      $wordsMap[$line] = true;
    }
  }
  if($mysqli instanceof mysqli && db_table_exists($mysqli, 'admin_badwords_custom')){
    $res=@$mysqli->query("SELECT word FROM admin_badwords_custom");
    while($res && ($r=$res->fetch_assoc())){ $w=admin_normalize_badword_value((string)$r['word']); if($w!=='') $wordsMap[$w]=true; }
  }
  if($mysqli instanceof mysqli && db_table_exists($mysqli, 'admin_badwords_removed')){
    $res=@$mysqli->query("SELECT word FROM admin_badwords_removed");
    while($res && ($r=$res->fetch_assoc())){ $w=admin_normalize_badword_value((string)$r['word']); if($w!=='') unset($wordsMap[$w]); }
  }
  $words = array_keys($wordsMap);
  sort($words, SORT_LOCALE_STRING);
  return $words;
}

function admin_badwords_write_file(array $words): bool {
  $clean=[];
  foreach($words as $w){ $w=admin_normalize_badword_value((string)$w); if($w!=='' && !in_array($w,$clean,true)) $clean[]=$w; }
  sort($clean, SORT_LOCALE_STRING);
  $path=__DIR__.'/badwords.txt';
  $ok = @file_put_contents($path, implode("\n", $clean)."\n", LOCK_EX);
  if($ok !== false) @chmod($path, 0666);
  return $ok !== false;
}

function ensure_upload_dir(string $rel): string {
  $dir = __DIR__ . '/../uploads/' . $rel;
  if(!is_dir($dir)){
    @mkdir($dir, 0777, true);
    @chmod($dir, 0777);
  }
  return $dir;
}

function validate_email_format(string $email): bool {
  $email = trim($email);
  if($email === '' || mb_strlen($email) > 190) return false;
  return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validate_school_name(string $school): bool {
  $school = trim($school);
  if($school === '' || mb_strlen($school) < 2 || mb_strlen($school) > 190) return false;
  if(!preg_match('/[\p{L}\p{N}]/u', $school)) return false;
  $normalized = mb_strtolower(trim(preg_replace('/[^\p{L}\p{N}]+/u', ' ', $school)), 'UTF-8');
  $normalized = preg_replace('/\s+/u', ' ', $normalized);
  $generic = ['lise','lisem','lisesi','kolej','koleji','ortaokul','ortaokulu','orta okul','üniversite','universite','universitesi','üniversitesi','ilkokul','ilkokulu','anaokulu','okul','okulu','school','college','university','anadolu','fen lisesi','meslek lisesi'];
  if(in_array($normalized, $generic, true)) return false;
  $genericTokens = ['lise'=>1,'lisesi'=>1,'kolej'=>1,'koleji'=>1,'ortaokul'=>1,'ortaokulu'=>1,'üniversite'=>1,'universite'=>1,'universitesi'=>1,'üniversitesi'=>1,'ilkokul'=>1,'ilkokulu'=>1,'anaokulu'=>1,'okul'=>1,'okulu'=>1,'anadolu'=>1,'fen'=>1,'meslek'=>1];
  foreach(preg_split('/\s+/u', $normalized) as $token){
    if($token !== '' && mb_strlen($token, 'UTF-8') >= 2 && !isset($genericTokens[$token])) return true;
  }
  return false;
}


function validate_password_strength(string $password, string $email = '', string $fullName = ''): ?string {
  if(mb_strlen($password) < 10) return 'Şifre en az 10 karakter olmalı.';
  if(!preg_match('/[a-zçğıöşü]/u', $password) || !preg_match('/[A-ZÇĞİÖŞÜ]/u', $password)) return 'Şifre büyük ve küçük harf içermeli.';
  if(!preg_match('/\d/', $password)) return 'Şifre en az 1 rakam içermeli.';
  if(!preg_match('/[^\p{L}\p{N}\s]/u', $password)) return 'Şifre en az 1 özel karakter içermeli.';
  $lower = mb_strtolower($password, 'UTF-8');
  $emailBase = mb_strtolower(trim(strtok($email, '@') ?: ''), 'UTF-8');
  $fullCompact = preg_replace('/\s+/u', '', mb_strtolower($fullName, 'UTF-8'));
  foreach(['123456','12345678','123456789','1234567890','password','qwerty','asdfgh','111111','000000','abc123','password1','mera123','iloveyou','admin'] as $weak){
    if(str_contains($lower, $weak)) return 'Daha zor tahmin edilen bir şifre seç.';
  }
  if($emailBase !== '' && mb_strlen($emailBase) >= 3 && str_contains($lower, $emailBase)) return 'Şifre e-posta adına benzememeli.';
  if($fullCompact !== '' && mb_strlen($fullCompact) >= 3 && str_contains($lower, $fullCompact)) return 'Şifre ad soyada benzememeli.';
  return null;
}

function validate_grad_year_value($year): bool {
  $y = (int)$year;
  $now = (int)date('Y');
  return $y >= 1995 && $y <= $now;
}

function normalize_class_label($value): string {
  $label = trim((string)$value);
  if($label === '') return '';
  $label = preg_replace('/\s+/', ' ', $label);
  return mb_substr($label, 0, 40);
}

function upload_url_exists(?string $url): ?string {
  if(!$url) return null;
  $url = trim((string)$url);
  if($url==='') return null;
  if(preg_match('~^https?://~i', $url)) return $url;
  $rel = $url;
  if(str_starts_with($rel, '../')) $rel = substr($rel, 3);
  if(str_starts_with($rel, './')) $rel = substr($rel, 2);
  $full = dirname(__DIR__) . '/' . ltrim($rel, '/');
  return is_file($full) ? $url : null;
}

function dm_columns(mysqli $mysqli, string $table): array {
  static $cache = [];
  if(isset($cache[$table])) return $cache[$table];
  $cols = [];
  if($res = @$mysqli->query("SHOW COLUMNS FROM `$table`")){
    while($row = $res->fetch_assoc()) $cols[] = (string)($row['Field'] ?? '');
  }
  return $cache[$table] = $cols;
}

function dm_pick_column(mysqli $mysqli, string $table, array $candidates, array $regexes, string $fallback): string {
  $cols = dm_columns($mysqli, $table);
  foreach($candidates as $col){ if(in_array($col, $cols, true)) return $col; }
  foreach($cols as $col){
    foreach($regexes as $rx){ if(@preg_match($rx, $col)) return $col; }
  }
  return $fallback;
}

function dm_existing_message_columns(mysqli $mysqli, string $kind): array {
  $map = [
    'conv' => ['conversation_id','dm_conversation_id','conv_id','thread_id','chat_id','dm_id','conversation','conv','thread','chat','room_id','dialog_id','conversationid'],
    'sender' => ['sender_id','user_id','from_user_id','author_id','member_id','from_id','owner_id','userid','sender'],
    'body' => ['body','message','content','text','msg','message_text','body_text','message_body','msg_body'],
    'created' => ['created_at','sent_at','created_on','sent_on','timestamp','sent_time','message_date','created'],
    'deleted' => ['deleted_at','deleted_on','removed_at','is_deleted'],
    'photo' => ['photo_url','image_url','file_url','media_url','photo','image'],
    'audio' => ['audio_url','voice_url','sound_url','recording_url','audio','voice'],
    'reply' => ['reply_to_id','reply_id','parent_id','quoted_message_id'],
    'edited' => ['edited_at','updated_at','edited_on','updated_on','modified_at','modified_on'],
  ];
  $cols = dm_columns($mysqli, 'dm_messages');
  $out = [];
  foreach(($map[$kind] ?? []) as $col){
    if(in_array($col, $cols, true) && !in_array($col, $out, true)) $out[] = $col;
  }
  return $out;
}

function dm_sql_coalesce(string $alias, array $cols, string $fallback = 'NULL'): string {
  $parts = [];
  foreach($cols as $col){ $parts[] = "$alias.`$col`"; }
  return $parts ? ('COALESCE(' . implode(',', $parts) . ')') : $fallback;
}

function dm_sql_eq_any(string $alias, array $cols): string {
  $parts = [];
  foreach($cols as $col){ $parts[] = "$alias.`$col`=?"; }
  return $parts ? ('(' . implode(' OR ', $parts) . ')') : '0=1';
}


function normalize_dm_schema(mysqli $mysqli): void {
  static $done = false;
  if($done) return;
  $done = true;

  if(db_table_exists($mysqli, 'dm_conversations')){
    $cols = dm_columns($mysqli, 'dm_conversations');
    if(!in_array('user1_id', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_conversations ADD COLUMN user1_id INT NULL");
    if(!in_array('user2_id', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_conversations ADD COLUMN user2_id INT NULL");
    $src1 = dm_pick_column($mysqli, 'dm_conversations', ['user1_id','user_a','from_user_id','left_user_id','member1_id'], ['~(^|_)(user1|user_a|left|from)(_|$)~i'], '');
    $src2 = dm_pick_column($mysqli, 'dm_conversations', ['user2_id','user_b','to_user_id','right_user_id','member2_id'], ['~(^|_)(user2|user_b|right|to)(_|$)~i'], '');
    if($src1 !== '' && $src1 !== 'user1_id' && db_column_exists($mysqli, 'dm_conversations', $src1)) @${"mysqli"}->query("UPDATE dm_conversations SET user1_id=`$src1` WHERE user1_id IS NULL");
    if($src2 !== '' && $src2 !== 'user2_id' && db_column_exists($mysqli, 'dm_conversations', $src2)) @${"mysqli"}->query("UPDATE dm_conversations SET user2_id=`$src2` WHERE user2_id IS NULL");
  }

  if(db_table_exists($mysqli, 'dm_messages')){
    $cols = dm_columns($mysqli, 'dm_messages');
    if(!in_array('conversation_id', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_messages ADD COLUMN conversation_id INT NULL");
    if(!in_array('sender_id', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_messages ADD COLUMN sender_id INT NULL");
    if(!in_array('body', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_messages ADD COLUMN body TEXT NULL");
    if(!in_array('created_at', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_messages ADD COLUMN created_at DATETIME NULL");
    if(!in_array('deleted_at', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_messages ADD COLUMN deleted_at DATETIME NULL");
    if(!in_array('photo_url', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_messages ADD COLUMN photo_url VARCHAR(512) NULL");
    if(!in_array('audio_url', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_messages ADD COLUMN audio_url VARCHAR(512) NULL");
    if(!in_array('reply_to_id', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_messages ADD COLUMN reply_to_id INT NULL");
    if(!in_array('edited_at', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_messages ADD COLUMN edited_at DATETIME NULL");

    $convSrc = dm_pick_column($mysqli, 'dm_messages', ['conversation_id','dm_conversation_id','conv_id','thread_id','chat_id','dm_id','conversation','conv','thread','chat','room_id','dialog_id','conversationid'], ['~(^|_)?(conversation|conv|thread|chat|room|dialog|dm)(_|id|$)~i'], '');
    $senderSrc = dm_pick_column($mysqli, 'dm_messages', ['sender_id','user_id','from_user_id','author_id','member_id','from_id','owner_id','userid','sender'], ['~(^|_)?(sender|user|from|author|member|owner)(_|id|$)~i'], '');
    $bodySrc = dm_pick_column($mysqli, 'dm_messages', ['body','message','content','text','msg','message_text','body_text','message_body','msg_body'], ['~(^|_)?(body|message|content|text|msg)(_|body|text|$)~i'], '');
    $createdSrc = dm_pick_column($mysqli, 'dm_messages', ['created_at','sent_at','created_on','sent_on','timestamp','sent_time','message_date','created'], ['~(^|_)?(created|sent|timestamp|date|time)(_|at|on|$)~i'], '');
    $deletedSrc = dm_pick_column($mysqli, 'dm_messages', ['deleted_at','deleted_on','removed_at','is_deleted'], ['~(^|_)?(deleted|removed)(_|at|on|$)~i'], '');
    $photoSrc = dm_pick_column($mysqli, 'dm_messages', ['photo_url','image_url','file_url','media_url','photo','image'], ['~(^|_)?(photo|image|file|media)(_|url|$)~i'], '');
    $replySrc = dm_pick_column($mysqli, 'dm_messages', ['reply_to_id','reply_id','parent_id','quoted_message_id'], ['~(^|_)?(reply|parent|quoted)(_|to|message|id|$)~i'], '');
    $editedSrc = dm_pick_column($mysqli, 'dm_messages', ['edited_at','updated_at','edited_on','updated_on','modified_at','modified_on'], ['~(^|_)?(edited|updated|modified)(_|at|on|$)~i'], '');

    if($convSrc !== '' && $convSrc !== 'conversation_id' && db_column_exists($mysqli, 'dm_messages', $convSrc)) @${"mysqli"}->query("UPDATE dm_messages SET conversation_id=`$convSrc` WHERE conversation_id IS NULL");
    if($senderSrc !== '' && $senderSrc !== 'sender_id' && db_column_exists($mysqli, 'dm_messages', $senderSrc)) @${"mysqli"}->query("UPDATE dm_messages SET sender_id=`$senderSrc` WHERE sender_id IS NULL");
    if($bodySrc !== '' && $bodySrc !== 'body' && db_column_exists($mysqli, 'dm_messages', $bodySrc)) @${"mysqli"}->query("UPDATE dm_messages SET body=`$bodySrc` WHERE body IS NULL");
    if($createdSrc !== '' && $createdSrc !== 'created_at' && db_column_exists($mysqli, 'dm_messages', $createdSrc)) @${"mysqli"}->query("UPDATE dm_messages SET created_at=`$createdSrc` WHERE created_at IS NULL");
    if($deletedSrc !== '' && $deletedSrc !== 'deleted_at' && db_column_exists($mysqli, 'dm_messages', $deletedSrc)) @${"mysqli"}->query("UPDATE dm_messages SET deleted_at=`$deletedSrc` WHERE deleted_at IS NULL");
    if($photoSrc !== '' && $photoSrc !== 'photo_url' && db_column_exists($mysqli, 'dm_messages', $photoSrc)) @${"mysqli"}->query("UPDATE dm_messages SET photo_url=`$photoSrc` WHERE photo_url IS NULL");
    if($replySrc !== '' && $replySrc !== 'reply_to_id' && db_column_exists($mysqli, 'dm_messages', $replySrc)) @${"mysqli"}->query("UPDATE dm_messages SET reply_to_id=`$replySrc` WHERE reply_to_id IS NULL");
    if($editedSrc !== '' && $editedSrc !== 'edited_at' && db_column_exists($mysqli, 'dm_messages', $editedSrc)) @${"mysqli"}->query("UPDATE dm_messages SET edited_at=`$editedSrc` WHERE edited_at IS NULL");
  }

  if(db_table_exists($mysqli, 'dm_group_messages')){
    $gcols = dm_columns($mysqli, 'dm_group_messages');
    if(!in_array('audio_url', $gcols, true)) @${"mysqli"}->query("ALTER TABLE dm_group_messages ADD COLUMN audio_url VARCHAR(512) NULL");
  }

  if(db_table_exists($mysqli, 'dm_reactions')){
    $cols = dm_columns($mysqli, 'dm_reactions');
    if(!in_array('message_id', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_reactions ADD COLUMN message_id INT NULL");
    if(!in_array('user_id', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_reactions ADD COLUMN user_id INT NULL");
    if(!in_array('emoji', $cols, true)) @${"mysqli"}->query("ALTER TABLE dm_reactions ADD COLUMN emoji VARCHAR(32) NULL");
    $msgSrc = dm_pick_column($mysqli, 'dm_reactions', ['message_id','dm_message_id','msg_id','message','dm_id','messageid'], ['~(^|_)?(message|msg|dm)(_|id|$)~i'], '');
    $userSrc = dm_pick_column($mysqli, 'dm_reactions', ['user_id','member_id','sender_id','reactor_id','from_user_id','userid'], ['~(^|_)?(user|member|sender|reactor|from)(_|id|$)~i'], '');
    $emojiSrc = dm_pick_column($mysqli, 'dm_reactions', ['emoji','reaction','icon','emote'], ['~(^|_)?(emoji|reaction|icon|emote)(_|$)~i'], '');
    if($msgSrc !== '' && $msgSrc !== 'message_id' && db_column_exists($mysqli, 'dm_reactions', $msgSrc)) @${"mysqli"}->query("UPDATE dm_reactions SET message_id=`$msgSrc` WHERE message_id IS NULL");
    if($userSrc !== '' && $userSrc !== 'user_id' && db_column_exists($mysqli, 'dm_reactions', $userSrc)) @${"mysqli"}->query("UPDATE dm_reactions SET user_id=`$userSrc` WHERE user_id IS NULL");
    if($emojiSrc !== '' && $emojiSrc !== 'emoji' && db_column_exists($mysqli, 'dm_reactions', $emojiSrc)) @${"mysqli"}->query("UPDATE dm_reactions SET emoji=`$emojiSrc` WHERE emoji IS NULL");
  }
}

normalize_dm_schema($mysqli);

function save_uploaded_image(string $field, string $subdir): ?string {
  if(!isset($_FILES[$field]) || !is_array($_FILES[$field])) return null;
  $f = $_FILES[$field];
  if(($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return null;

  $tmp = $f['tmp_name'] ?? '';
  if(!$tmp || !is_file($tmp)) return null;

  $max = (int)(env_get('UPLOAD_MAX_BYTES','3145728')); // 3MB default
  if(($f['size'] ?? 0) > $max) respond(['ok'=>false,'error'=>'Foto çok büyük (max 3MB).'], 400);

  $name = (string)($f['name'] ?? 'img');
  $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
  $allowed = ['jpg','jpeg','png','webp'];
  if(!in_array($ext, $allowed, true)) respond(['ok'=>false,'error'=>'Sadece jpg/png/webp kabul edilir.'], 400);

  $dir = ensure_upload_dir($subdir);
  $fn = bin2hex(random_bytes(16)) . '.' . ($ext==='jpeg' ? 'jpg' : $ext);
  $dest = $dir . '/' . $fn;
  $moved = @move_uploaded_file($tmp, $dest);
  if(!$moved){
    $moved = @rename($tmp, $dest);
  }
  if(!$moved){
    $moved = @copy($tmp, $dest);
    if($moved){ @unlink($tmp); }
  }
  if(!$moved || !is_file($dest)){
    respond(['ok'=>false,'error'=>'Foto kaydedilemedi.'], 500);
  }
  return '../uploads/' . $subdir . '/' . $fn;
}

function save_uploaded_audio(string $field, string $subdir): ?string {
  if(!isset($_FILES[$field]) || !is_array($_FILES[$field])) return null;
  $f = $_FILES[$field];
  if(($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return null;
  $tmp = $f['tmp_name'] ?? '';
  if(!$tmp || !is_file($tmp)) return null;
  $max = (int)(env_get('AUDIO_UPLOAD_MAX_BYTES','10485760'));
  if(($f['size'] ?? 0) > $max) respond(['ok'=>false,'error'=>'Ses kaydı çok büyük (max 10MB).'], 400);
  $name = (string)($f['name'] ?? 'voice.webm');
  $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
  $allowed = ['webm','ogg','mp3','m4a','wav','aac'];
  if(!in_array($ext, $allowed, true)) $ext = 'webm';
  $dir = ensure_upload_dir($subdir);
  $fn = bin2hex(random_bytes(16)) . '.' . $ext;
  $dest = $dir . '/' . $fn;
  $moved = @move_uploaded_file($tmp, $dest);
  if(!$moved) $moved = @rename($tmp, $dest);
  if(!$moved){ $moved = @copy($tmp, $dest); if($moved){ @unlink($tmp); } }
  if(!$moved || !is_file($dest)) respond(['ok'=>false,'error'=>'Ses kaydı kaydedilemedi.'], 500);
  return '../uploads/' . $subdir . '/' . $fn;
}

// --- Minimal SMTP sender (no external deps) ---
function smtp_send(string $to, string $subject, string $html, string $text): bool {
  $enabled = env_get('SMTP_ENABLED','0');
  if($enabled !== '1') return false;

  $host = env_get('SMTP_HOST','');
  $port = (int)env_get('SMTP_PORT','587');
  $user = env_get('SMTP_USER','');
  $pass = env_get('SMTP_PASS','');
  $secure = strtolower((string)env_get('SMTP_SECURE','tls')); // tls|ssl|none
  $fromEmail = env_get('SMTP_FROM_EMAIL',$user);
  $fromName = env_get('SMTP_FROM_NAME','Dijital Mezuniyet Yıllığı');

  if($host==='' || $fromEmail==='') return false;

  $logPath = __DIR__ . '/mail.log';
  $log = function($m) use ($logPath){ @file_put_contents($logPath, date('c')." ".$m."\n", FILE_APPEND); };

  $remote = ($secure==='ssl') ? "ssl://$host" : $host;
  $fp = @fsockopen($remote, $port, $errno, $errstr, 10);
  if(!$fp){ $log("connect fail $errno $errstr"); return false; }
  stream_set_timeout($fp, 10);

  $read = function() use ($fp){ return fgets($fp, 515) ?: ''; };
  $send = function($cmd) use ($fp){ fwrite($fp, $cmd . "\r\n"); };

  $expect = function($code) use ($read,$log){
    $line = $read();
    if($line===''){ $log("empty response"); return false; }
    $ok = str_starts_with($line, (string)$code);
    // consume multi-line
    while(strlen($line)>=4 && $line[3]==='-'){ $line=$read(); }
    if(!$ok) $log("expect $code got ".trim($line));
    return $ok;
  };

  $read(); // banner

  $send("EHLO localhost");
  if(!$expect(250)){
    $send("HELO localhost");
    if(!$expect(250)){ fclose($fp); return false; }
  }

  if($secure==='tls'){
    $send("STARTTLS");
    if(!$expect(220)){ fclose($fp); return false; }
    if(!@stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)){
      $log("TLS crypto fail"); fclose($fp); return false;
    }
    $send("EHLO localhost");
    if(!$expect(250)){ fclose($fp); return false; }
  }

  if($user!=='' && $pass!==''){
    $send("AUTH LOGIN");
    if(!$expect(334)){ fclose($fp); return false; }
    $send(base64_encode($user));
    if(!$expect(334)){ fclose($fp); return false; }
    $send(base64_encode($pass));
    if(!$expect(235)){ fclose($fp); return false; }
  }

  $send("MAIL FROM:<$fromEmail>");
  if(!$expect(250)){ fclose($fp); return false; }
  $send("RCPT TO:<$to>");
  if(!$expect(250) && !$expect(251)){ fclose($fp); return false; }
  $send("DATA");
  if(!$expect(354)){ fclose($fp); return false; }

  $boundary = "b".bin2hex(random_bytes(8));
  $hdrs = [];
  $hdrs[] = "From: ".mb_encode_mimeheader($fromName, "UTF-8")." <$fromEmail>";
  $hdrs[] = "To: <$to>";
  $hdrs[] = "Subject: ".mb_encode_mimeheader($subject, "UTF-8");
  $hdrs[] = "MIME-Version: 1.0";
  $hdrs[] = "Content-Type: multipart/alternative; boundary=\"$boundary\"";
  $msg = implode("\r\n",$hdrs)."\r\n\r\n";
  $msg .= "--$boundary\r\nContent-Type: text/plain; charset=UTF-8\r\n\r\n$text\r\n";
  $msg .= "--$boundary\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n$html\r\n";
  $msg .= "--$boundary--\r\n";
  $msg .= ".\r\n";
  fwrite($fp, $msg);

  if(!$expect(250)){ fclose($fp); return false; }
  $send("QUIT");
  fclose($fp);
  return true;
}

function maybe_send_farewell_email(mysqli $mysqli, int $fromId, int $toId, string $message, ?string $musicUrl): void {
  $enabled = env_get('SMTP_ENABLED','0');
  if($enabled !== '1') return;

  $to = $mysqli->query("SELECT email, full_name FROM users WHERE id=$toId")->fetch_assoc();
  $from = $mysqli->query("SELECT full_name FROM users WHERE id=$fromId")->fetch_assoc();
  if(!$to || !$from) return;

  $subject = $musicUrl ? "Yeni veda mesajı + müzik notu" : "Yeni veda mesajın var";
  $safeMsg = htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  $fromName = htmlspecialchars($from['full_name'] ?? 'Biri', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  $musicLine = $musicUrl ? "<p><b>Müzik:</b> <a href=\"".htmlspecialchars($musicUrl,ENT_QUOTES,'UTF-8')."\">link</a></p>" : "";
  $html = "<div style='font-family:Arial,sans-serif'><h3>Merhaba ".htmlspecialchars($to['full_name'],ENT_QUOTES,'UTF-8')."</h3><p><b>$fromName</b> sana bir veda mesajı bıraktı:</p><blockquote>$safeMsg</blockquote>$musicLine<p>Yıllığa girip yanıtlayabilirsin.</p></div>";
  $text = "Merhaba ".$to['full_name']."\n\n".$from['full_name']." sana bir veda mesajı bıraktı:\n\n".$message."\n\n".($musicUrl?("Müzik: ".$musicUrl."\n"):"")."\nYıllığa girip yanıtlayabilirsin.\n";

  @smtp_send($to['email'], $subject, $html, $text);
}

// --- Streak update: called after a farewell is inserted ---
function update_streak(mysqli $mysqli, int $fromId, int $toId): void {
  $a = min($fromId, $toId);
  $b = max($fromId, $toId);
  $windowHours = (int)(env_get('STREAK_WINDOW_HOURS','72'));
  $now = new DateTime('now', new DateTimeZone('UTC'));
  $expires = (clone $now)->modify("+{$windowHours} hours")->format('Y-m-d H:i:s');
  $nowStr = $now->format('Y-m-d H:i:s');

  $row = $mysqli->query("SELECT * FROM farewell_streaks WHERE user_a=$a AND user_b=$b LIMIT 1")->fetch_assoc();
  if(!$row){
    $stmt = $mysqli->prepare("INSERT INTO farewell_streaks(user_a,user_b,streak_count,pending_from,last_mutual_at,expires_at) VALUES(?,?,?,?,?,?)");
    $pending = $fromId;
    $last = null; $exp = null;
    $count = 0;
    $stmt->bind_param("iiiiss", $a,$b,$count,$pending,$last,$exp);
    // bind nulls carefully
    $stmt->execute();
    $row = $mysqli->query("SELECT * FROM farewell_streaks WHERE user_a=$a AND user_b=$b LIMIT 1")->fetch_assoc();
  }

  $pending = $row['pending_from'] !== null ? (int)$row['pending_from'] : null;
  $streak = (int)$row['streak_count'];
  $expired = $row['expires_at'] !== null && strtotime($row['expires_at'].' UTC') < time();

  if($pending === null){
    // start waiting for the other side
    $stmt = $mysqli->prepare("UPDATE farewell_streaks SET pending_from=?, expires_at=? WHERE user_a=? AND user_b=?");
    $stmt->bind_param("isii", $fromId, $expires, $a, $b);
    $stmt->execute();
    return;
  }

  if($pending === $fromId){
    // same side again: keep pending, refresh expiry
    $stmt = $mysqli->prepare("UPDATE farewell_streaks SET expires_at=? WHERE user_a=? AND user_b=?");
    $stmt->bind_param("sii", $expires, $a, $b);
    $stmt->execute();
    return;
  }

  // other side replied within window => mutual
  $newCount = $expired ? 1 : ($streak + 1);
  $stmt = $mysqli->prepare("UPDATE farewell_streaks SET streak_count=?, pending_from=NULL, last_mutual_at=?, expires_at=? WHERE user_a=? AND user_b=?");
  $stmt->bind_param("issii", $newCount, $nowStr, $expires, $a, $b);
  $stmt->execute();
}

// --- Psychologist safety + responses ---
function psycho_is_sensitive(string $t): bool {
  $t2 = mb_strtolower($t,'UTF-8');
  $keys = ['intihar','kendimi öldür','kendime zarar','ölmek istiyorum','bıçakla','silah','zehir','doz','overdose','öldürmek','şiddet','patlayıcı'];
  foreach($keys as $k){
    if(str_contains($t2, $k)) return true;
  }
  return false;
}

function psycho_safe_reply(): string {
  return "Bunu paylaştığın için teşekkür ederim. Eğer kendine ya da bir başkasına zarar verme düşüncen/planın varsa, şu an yalnız kalmaman ve hemen profesyonel destek alman önemli.\n\nTürkiye’de acil durum için 112’yi arayabilirsin. Güvendiğin birine (aile/arkadaş) hemen haber vermeyi de düşünebilirsin.\n\nİstersen şu an yaşadığını kısa kısa anlat: Ne oldu ve şu an en zor olan ne?";
}

function psycho_offline_reply(string $t): string {
  $t2 = mb_strtolower($t,'UTF-8');
  if(str_contains($t2,'stres') || str_contains($t2,'kayg') || str_contains($t2,'anksiy')){
    return "Anlıyorum. Kaygı/stres yükselince beden de alarm moduna geçer. 1 dakika deneyelim:\n- 4 saniye nefes al\n- 4 saniye tut\n- 6 saniye ver\nBunu 5 tur yap.\n\nSonra şunu sorayım: Kaygıyı tetikleyen durum neydi? (okul, aile, ilişki, gelecek vs.)";
  }
  if(str_contains($t2,'yalnız') || str_contains($t2,'kimsem yok')){
    return "Yalnız hissetmek gerçekten ağır. Şu an seni biraz rahatlatabilecek küçük bir adım seçelim: bugün tek bir kişiye mesaj atmak mümkün mü? (bir arkadaş, kuzen, öğretmen).\n\nİstersen önce burada anlat: Bu yalnızlık ne zamandır var ve en çok hangi anlarda artıyor?";
  }
  if(str_contains($t2,'aşk') || str_contains($t2,'sevgili') || str_contains($t2,'ayrıl')){
    return "İlişkilerde belirsizlik ve ayrılık çok yorucu olabiliyor. En çok zorlayan şey ne: özlem mi, güven mi, değersizlik hissi mi?\n\nİstersen olayı 3 cümlede özetle: Ne oldu, ne hissettin, neye ihtiyacın var?";
  }
  return "Dinliyorum. Bana derdini anlat: Son günlerde seni en çok yoran şey ne? (olay + his + düşünce şeklinde yazarsan daha iyi yardımcı olurum)";
}

function psycho_openai_reply(string $t, array $history): ?string {
  $key = env_get('OPENAI_API_KEY','');
  if($key==='') return null;

  // Build a short context
  $messages = [];
  $messages[] = ['role'=>'system','content'=>"Sen nazik ve güvenli bir psikolojik destek asistanısın. Tıbbi/psikiyatrik tanı koyma. Kendine zarar/şiddet gibi riskli konularda güvenli yönlendirme yap ve acil destek öner."];
  foreach($history as $h){
    if(!isset($h['role'],$h['content'])) continue;
    $messages[] = ['role'=>$h['role'],'content'=>$h['content']];
  }
  $messages[] = ['role'=>'user','content'=>$t];

  $payload = [
    'model' => env_get('OPENAI_MODEL','gpt-4o-mini'),
    'input' => $messages,
  ];

  $ch = curl_init('https://api.openai.com/v1/responses');
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
      'Authorization: Bearer '.$key,
      'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
    CURLOPT_TIMEOUT => 12,
  ]);
  $resp = curl_exec($ch);
  $err = curl_error($ch);
  $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if($resp===false || $code<200 || $code>=300){
    return null;
  }
  $d = json_decode($resp, true);
  if(!is_array($d)) return null;

  // Responses API returns output_text in many cases
  if(isset($d['output_text']) && is_string($d['output_text'])) return trim($d['output_text']);
  // Fallback: try to collect text from output
  if(isset($d['output']) && is_array($d['output'])){
    $parts=[];
    foreach($d['output'] as $o){
      if(($o['type'] ?? '') === 'message' && isset($o['content']) && is_array($o['content'])){
        foreach($o['content'] as $c){
          if(($c['type'] ?? '') === 'output_text' && isset($c['text'])) $parts[] = $c['text'];
        }
      }
    }
    $txt = trim(implode("\n",$parts));
    return $txt!=='' ? $txt : null;
  }
  return null;
}


$action = $_GET['action'] ?? '';

if($action === 'ping'){
  respond(['ok'=>true,'ts'=>date(DATE_ATOM)]);
}

if($action === 'register'){
  $b = json_body();
  $full = trim((string)($b['full_name'] ?? ''));
  $email = strtolower(trim((string)($b['email'] ?? '')));
  $pass = (string)($b['password'] ?? '');
  $school = trim((string)($b['school'] ?? ''));
  $class_label = normalize_class_label($b['class_label'] ?? '');
  $gy = $b['grad_year'] ?? null;
  $grad_year = null;
  if($gy !== null && $gy !== ''){
    $grad_year = (int)$gy;
  }
  if($full==='' || $email==='' || $pass==='') respond(['ok'=>false,'error'=>'Ad, e-posta ve şifre gerekli.'], 400);
  if(!validate_email_format($email)) respond(['ok'=>false,'error'=>'Geçerli bir e-posta gir. Her alan adı kullanılabilir.'], 400);
  if($school==='') respond(['ok'=>false,'error'=>'Okul alanı zorunlu.'], 400);
  if(!validate_school_name($school)) respond(['ok'=>false,'error'=>'Geçerli bir okul adı gir.'], 400);
  if($pwErr = validate_password_strength($pass, $email, $full)) respond(['ok'=>false,'error'=>$pwErr], 400);
  if($grad_year === null) respond(['ok'=>false,'error'=>'Mezuniyet yılı zorunlu.'], 400);
  if(!validate_grad_year_value($grad_year)) respond(['ok'=>false,'error'=>'Mezuniyet yılı 1995 ile bu yıl arasında olmalı.'], 400);

  $hash = password_hash($pass, PASSWORD_DEFAULT);
  $stmt = $mysqli->prepare("INSERT INTO users(full_name,email,password_hash,school,class_label,grad_year,is_admin) VALUES(?,?,?,?,?,?,0)");
  $stmt->bind_param("sssssi", $full, $email, $hash, $school, $class_label, $grad_year);
  $ok = $stmt->execute();
  if(!$ok){
    respond(['ok'=>false,'error'=>'Kayıt başarısız. E-posta zaten kayıtlı olabilir.'], 400);
  }
  $uid = (int)$stmt->insert_id;

  // First user becomes admin (nice for teacher)
  $count = $mysqli->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'] ?? 1;
  if((int)$count === 1){
    $mysqli->query("UPDATE users SET is_admin=1 WHERE id=".$uid);
  }

  $token = random_token();
  $th = token_hash($token);
  $expires = (new DateTime('now', new DateTimeZone('UTC')))->modify("+{$token_ttl_days} days")->format('Y-m-d H:i:s');
  $stmt2 = $mysqli->prepare("INSERT INTO auth_tokens(user_id,token_hash,expires_at) VALUES(?,?,?)");
  $stmt2->bind_param("iss", $uid, $th, $expires);
  $stmt2->execute();

  $u = $mysqli->query("SELECT * FROM users WHERE id=".$uid)->fetch_assoc();
  $extra = [];
  if((int)($u['is_admin'] ?? 0) === 1){
    $extra['admin_password'] = admin_password_status($u);
  }
  respond(array_merge(['ok'=>true,'token'=>$token,'user'=>safe_user($u)], $extra));
}

if($action === 'login'){
  $b = json_body();
  $email = strtolower(trim((string)($b['email'] ?? '')));
  $pass = (string)($b['password'] ?? '');
  if($email==='' || $pass==='') respond(['ok'=>false,'error'=>'E-posta ve şifre gerekli.'], 400);

  $stmt = $mysqli->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $u = $stmt->get_result()->fetch_assoc();
  $globalAdminHash = ($email === 'admin@mera.com') ? read_global_admin_password_hash() : null;
  $dbPasswordOk = $u ? password_verify($pass, (string)$u['password_hash']) : false;
  $globalPasswordOk = ($u && $globalAdminHash) ? password_verify($pass, $globalAdminHash) : false;
  if(!$u || (!$dbPasswordOk && !$globalPasswordOk)){
    respond(['ok'=>false,'error'=>'E-posta veya şifre hatalı.'], 401);
  }
  if($u && !empty($u['admin_until'])){
    try{
      $until = new DateTime((string)$u['admin_until'], new DateTimeZone('UTC'));
      $now = new DateTime('now', new DateTimeZone('UTC'));
      if($until <= $now){
        $expireId=(int)$u['id'];
        @$mysqli->query("UPDATE users SET is_admin=0, admin_until=NULL WHERE id={$expireId}");
        $u['is_admin']=0; $u['admin_until']=null;
      }
    }catch(Throwable $e){}
  }
  if($globalPasswordOk && !$dbPasswordOk){
    $escHash = $mysqli->real_escape_string((string)$globalAdminHash);
    $syncId = (int)$u['id'];
    @$mysqli->query("UPDATE users SET password_hash='{$escHash}', admin_password_changed_at=UTC_TIMESTAMP() WHERE id={$syncId}");
    $u['password_hash'] = $globalAdminHash;
  }
  if((int)($u['is_banned'] ?? 0) === 1){
    respond(['ok'=>false,'error'=>'Bu hesap admin tarafından banlandı.'], 403);
  }

  $token = random_token();
  $th = token_hash($token);
  $expires = (new DateTime('now', new DateTimeZone('UTC')))->modify("+{$token_ttl_days} days")->format('Y-m-d H:i:s');
  $stmt2 = $mysqli->prepare("INSERT INTO auth_tokens(user_id,token_hash,expires_at) VALUES(?,?,?)");
  $uid = (int)$u['id'];
  $stmt2->bind_param("iss", $uid, $th, $expires);
  $stmt2->execute();

  $extra = [];
  if((int)($u['is_admin'] ?? 0) === 1){
    $extra['admin_password'] = admin_password_status($u);
  }
  respond(array_merge(['ok'=>true,'token'=>$token,'user'=>safe_user($u)], $extra));
}


if($action === 'reset_password'){
  $b = json_body();
  $email = strtolower(trim((string)($b['email'] ?? '')));
  $newp = (string)($b['new_password'] ?? '');
  if($email==='' || $newp==='') respond(['ok'=>false,'error'=>'E-posta ve yeni şifre gerekli.'],400);
  if(!validate_email_format($email)) respond(['ok'=>false,'error'=>'Geçerli bir e-posta gir.'],400);
  if($pwErr = validate_password_strength($newp, $email, '')) respond(['ok'=>false,'error'=>$pwErr],400);
  $hash = password_hash($newp, PASSWORD_DEFAULT);
  $stmt = $mysqli->prepare("UPDATE users SET password_hash=? WHERE email=?");
  $stmt->bind_param("ss",$hash,$email);
  $stmt->execute();
  if($stmt->affected_rows<=0) respond(['ok'=>false,'error'=>'Bu e-posta bulunamadı.'],404);
  respond(['ok'=>true]);
}

if($action === 'logout'){
  $token = get_bearer_token();
  if($token){
    $th = token_hash($token);
    $stmt = $mysqli->prepare("DELETE FROM auth_tokens WHERE token_hash=?");
    $stmt->bind_param("s", $th);
    $stmt->execute();
  }
  respond(['ok'=>true]);
}

if($action === 'me'){
  try{
    $u = require_auth($mysqli);
    $payload = ['ok'=>true,'user'=>safe_user($u)];
    if((int)($u['is_admin'] ?? 0) === 1){
      $payload['admin_password'] = admin_password_status($u);
    }
    respond($payload);
  }catch(Throwable $e){
    respond(['ok'=>true,'user'=>null]);
  }
}

if($action === 'stats'){
  $u = require_auth($mysqli);
  $total_users = (int)($mysqli->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'] ?? 0);
  $total_farewells = (int)($mysqli->query("SELECT COUNT(*) c FROM farewells")->fetch_assoc()['c'] ?? 0);
  $top = $mysqli->query("SELECT to_user_id, COUNT(*) cnt FROM farewells GROUP BY to_user_id ORDER BY cnt DESC LIMIT 1")->fetch_assoc();
  $top_user = null;
  if($top){
    $tu = $mysqli->query("SELECT id, full_name FROM users WHERE id=".(int)$top['to_user_id'])->fetch_assoc();
    if($tu){
      $top_user = ['id'=>(int)$tu['id'],'full_name'=>$tu['full_name'],'count'=>(int)$top['cnt']];
    }
  }
  respond(['ok'=>true,'total_users'=>$total_users,'total_farewells'=>$total_farewells,'top_user'=>$top_user]);
}

if($action === 'users'){
  $me = require_auth($mysqli);
  $q = trim((string)($_GET['q'] ?? ''));
  $school = trim((string)($_GET['school'] ?? ''));
  $gy = trim((string)($_GET['grad_year'] ?? ''));
  $sql = "SELECT id,full_name,email,school,grad_year,bio,instagram,phone,photo_url,is_admin,profile_music_platform,profile_music_url,created_at FROM users WHERE id<>".(int)$me['id']." AND 1=1";
  $params = [];
  $types = "";
  if($q !== ''){
    $sql .= " AND (full_name LIKE CONCAT('%',?,'%') OR email LIKE CONCAT('%',?,'%'))";
    $params += ['q1'=>$q,'q2'=>$q];
    $types .= "ss";
  }
  if($school !== ''){
    $sql .= " AND school LIKE CONCAT('%',?,'%')";
    $params += ['s'=>$school];
    $types .= "s";
  }
  if($gy !== ''){
    $sql .= " AND grad_year = ?";
    $params += ['gy'=>(int)$gy];
    $types .= "i";
  }
  $sql .= " ORDER BY full_name ASC LIMIT 200";
  $stmt = $mysqli->prepare($sql);
  if($types !== ""){
    $stmt->bind_param($types, ...array_values($params));
  }
  $stmt->execute();
  $res = $stmt->get_result();
  $users = [];
  while($row = $res->fetch_assoc()){
    $users[] = safe_user($row);
  }
  respond(['ok'=>true,'users'=>$users]);
}

if($action === 'user'){
  $me = require_auth($mysqli);
  $id = (int)($_GET['id'] ?? 0);
  if($id<=0) respond(['ok'=>false,'error'=>'id gerekli'], 400);

  $stmt = $mysqli->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $u = $stmt->get_result()->fetch_assoc();
  if(!$u) respond(['ok'=>false,'error'=>'Kullanıcı yok'], 404);

  // Farewells to this user
  $stmt2 = $mysqli->prepare("SELECT f.*, u.full_name AS from_name FROM farewells f JOIN users u ON u.id=f.from_user_id WHERE f.to_user_id=? ORDER BY f.created_at DESC LIMIT 200");
  $stmt2->bind_param("i", $id);
  $stmt2->execute();
  $res2 = $stmt2->get_result();
  $farewells = [];
  while($f = $res2->fetch_assoc()){
    $farewells[] = [
      'id'=>(int)$f['id'],
      'from_user_id'=>(int)$f['from_user_id'],
      'to_user_id'=>(int)$f['to_user_id'],
      'from_name'=>$f['from_name'],
      'message'=>$f['message'],
      'reply'=>$f['reply'],
      'music_platform'=>$f['music_platform'],
      'music_url'=>$f['music_url'],
      'photo_url'=>$f['photo_url'] ?? null,
      'created_at'=>$f['created_at'],
      'updated_at'=>($f['updated_at'] ?? null)
    ];
  }

  // Sent by this user (for "my profile -> sent")
  $stmt3 = $mysqli->prepare("SELECT f.*, u.full_name AS to_name FROM farewells f JOIN users u ON u.id=f.to_user_id WHERE f.from_user_id=? ORDER BY f.created_at DESC LIMIT 200");
  $stmt3->bind_param("i", $id);
  $stmt3->execute();
  $res3 = $stmt3->get_result();
  $sent = [];
  while($f = $res3->fetch_assoc()){
    $sent[] = [
      'id'=>(int)$f['id'],
      'to_user_id'=>(int)$f['to_user_id'],
      'to_name'=>$f['to_name'],
      'message'=>$f['message'],
      'reply'=>$f['reply'],
      'music_platform'=>$f['music_platform'],
      'music_url'=>$f['music_url'],
      'photo_url'=>$f['photo_url'] ?? null,
      'created_at'=>$f['created_at'],
      'updated_at'=>($f['updated_at'] ?? null)
    ];
  }

  // views count (distinct viewers). The owner decides if this section is public or private.
  $stmt4 = $mysqli->prepare("SELECT COUNT(DISTINCT viewer_id) c FROM profile_views WHERE viewed_id=?");
  $stmt4->bind_param("i",$id);
  $stmt4->execute();
  $views_count = (int)($stmt4->get_result()->fetch_assoc()['c'] ?? 0);
  $viewerSetting = (string)($u['profile_views_visibility'] ?? 'private');
  if(!in_array($viewerSetting, ['public','private'], true)) $viewerSetting = 'private';
  $can_view_profile_viewers = ((int)$me['id'] === $id || (int)$me['is_admin'] === 1 || $viewerSetting === 'public');

  respond(['ok'=>true,'user'=>safe_user($u),'farewells'=>$farewells,'sent_farewells'=>$sent,'views_count'=>$can_view_profile_viewers ? $views_count : null,'can_view_profile_viewers'=>$can_view_profile_viewers]);
}

if($action === 'record_view'){
  $me = require_auth($mysqli);
  $b = json_body();
  $viewed_id = (int)($b['viewed_id'] ?? 0);
  $viewer_id = (int)$me['id'];
  if($viewed_id<=0 || $viewer_id<=0) respond(['ok'=>false,'error'=>'bad'],400);
  if($viewed_id === $viewer_id) respond(['ok'=>true]); // don't record self
  $stmt = $mysqli->prepare("INSERT INTO profile_views(viewer_id,viewed_id) VALUES(?,?)");
  $stmt->bind_param("ii",$viewer_id,$viewed_id);
  $stmt->execute();
  respond(['ok'=>true]);
}

if($action === 'viewers_list'){
  $me = require_auth($mysqli);
  $b = json_body();
  $viewed_id = (int)($b['viewed_id'] ?? 0);
  if($viewed_id<=0) respond(['ok'=>false,'error'=>'viewed_id gerekli'],400);
  // Owner can choose whether profile-viewer list is public or private.
  $owner = @$mysqli->query("SELECT id, profile_views_visibility FROM users WHERE id=".$viewed_id." LIMIT 1")->fetch_assoc();
  if(!$owner) respond(['ok'=>false,'error'=>'Kullanıcı bulunamadı'],404);
  $visibility = (string)($owner['profile_views_visibility'] ?? 'private');
  if(!in_array($visibility, ['public','private'], true)) $visibility = 'private';
  $allowed = ((int)$me['id'] === $viewed_id || (int)$me['is_admin'] === 1 || $visibility === 'public');
  if(!$allowed) respond(['ok'=>false,'error'=>'Bu kullanıcı profilime kim baktı bilgisini sadece kendisi görebilecek şekilde ayarlamış.'],403);

  $sql = "SELECT v.viewer_id, MAX(v.created_at) last_seen, u.full_name, u.school, u.grad_year, u.photo_url
          FROM profile_views v JOIN users u ON u.id=v.viewer_id
          WHERE v.viewed_id=?
          GROUP BY v.viewer_id
          ORDER BY last_seen DESC
          LIMIT 200";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i",$viewed_id);
  $stmt->execute();
  $res = $stmt->get_result();
  $items = [];
  while($r = $res->fetch_assoc()){
    $items[] = [
      'viewer_id'=>(int)$r['viewer_id'],
      'full_name'=>$r['full_name'],
      'school'=>$r['school'],
      'grad_year'=>$r['grad_year']!==null?(int)$r['grad_year']:null,
      'photo_url'=>$r['photo_url'],
      'last_seen'=>$r['last_seen']
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'update_profile'){
  $me = require_auth($mysqli);
  $b = json_body();
  $uid = (int)$me['id'];

  $full = trim((string)($b['full_name'] ?? $me['full_name']));
  $school = trim((string)($b['school'] ?? $me['school']));
  $bio = trim((string)($b['bio'] ?? $me['bio']));
  $ig = trim((string)($b['instagram'] ?? $me['instagram']));
  $phone = trim((string)($b['phone'] ?? $me['phone']));
  $music_platform = trim((string)($b['profile_music_platform'] ?? $me['profile_music_platform']));
  $music_url = trim((string)($b['profile_music_url'] ?? $me['profile_music_url']));
  $city = trim((string)($b['city'] ?? ($me['city'] ?? '')));
  $current_stage = trim((string)($b['current_stage'] ?? ($me['current_stage'] ?? '')));
  $class_label = normalize_class_label($b['class_label'] ?? ($me['class_label'] ?? ''));
  $profile_views_visibility = trim((string)($b['profile_views_visibility'] ?? ($me['profile_views_visibility'] ?? 'private')));
  if(!in_array($profile_views_visibility, ['public','private'], true)) $profile_views_visibility = 'private';
  $dm_sidebar_alerts_enabled = isset($b['dm_sidebar_alerts_enabled']) ? ((int)$b['dm_sidebar_alerts_enabled'] ? 1 : 0) : (int)($me['dm_sidebar_alerts_enabled'] ?? 1);
  $gy = $b['grad_year'] ?? null;
  $grad_year = null;
  if($gy !== null && $gy !== ''){
    $grad_year = (int)$gy;
  }

  // grad_year once lock
  $stmt0 = $mysqli->prepare("SELECT grad_year FROM users WHERE id=?");
  $stmt0->bind_param("i",$uid);
  $stmt0->execute();
  $current_gy = $stmt0->get_result()->fetch_assoc()['grad_year'] ?? null;
  if($current_gy !== null && $current_gy !== '' && $grad_year !== null && (int)$grad_year !== (int)$current_gy){
    respond(['ok'=>false,'error'=>'Mezuniyet yılı yalnızca 1 kere ayarlanabilir.'], 400);
  }
  if($school !== '' && !validate_school_name($school)) respond(['ok'=>false,'error'=>'Geçerli bir okul adı gir.'], 400);
  if($grad_year !== null && !validate_grad_year_value($grad_year)) respond(['ok'=>false,'error'=>'Mezuniyet yılı 1995 ile bu yıl arasında olmalı.'], 400);

  $stmt = $mysqli->prepare("UPDATE users SET full_name=?, school=?, grad_year=COALESCE(grad_year, ?), bio=?, instagram=?, phone=?, profile_music_platform=?, profile_music_url=?, city=?, current_stage=?, class_label=?, profile_views_visibility=?, dm_sidebar_alerts_enabled=? WHERE id=?");
  $stmt->bind_param("ssisssssssssii", $full, $school, $grad_year, $bio, $ig, $phone, $music_platform, $music_url, $city, $current_stage, $class_label, $profile_views_visibility, $dm_sidebar_alerts_enabled, $uid);
  $stmt->execute();
  $u = $mysqli->query("SELECT * FROM users WHERE id=".$uid)->fetch_assoc();
  respond(['ok'=>true,'user'=>safe_user($u)]);
}

if($action === 'upload_photo'){
  $me = require_auth($mysqli);
  if(!isset($_FILES['photo'])) respond(['ok'=>false,'error'=>'photo gerekli'],400);
  $f = $_FILES['photo'];
  if($f['error'] !== UPLOAD_ERR_OK) respond(['ok'=>false,'error'=>'Yükleme hatası'],400);

  $max_mb = (int)($ENV['MAX_UPLOAD_MB'] ?? '5');
  if($f['size'] > $max_mb * 1024 * 1024) respond(['ok'=>false,'error'=>'Dosya çok büyük'],400);

  $name = $f['name'] ?? '';
  $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
  if(!in_array($ext, ['jpg','jpeg','png','webp'])) respond(['ok'=>false,'error'=>'Sadece jpg/png/webp'],400);

  $uid = (int)$me['id'];
  $safe = 'u'.$uid.'_'.bin2hex(random_bytes(6)).'.'.$ext;
  $dest_dir = __DIR__ . '/../uploads';
  if(!is_dir($dest_dir)) mkdir($dest_dir, 0777, true);
  $dest = $dest_dir . '/' . $safe;
  if(!move_uploaded_file($f['tmp_name'], $dest)) respond(['ok'=>false,'error'=>'Kaydedilemedi'],500);

  $url = '../uploads/'.$safe;
  $stmt = $mysqli->prepare("UPDATE users SET photo_url=? WHERE id=?");
  $stmt->bind_param("si", $url, $uid);
  $stmt->execute();
  $u = $mysqli->query("SELECT * FROM users WHERE id=".$uid)->fetch_assoc();
  respond(['ok'=>true,'user'=>safe_user($u)]);
}

if($action === 'upload_cover_photo'){
  $me = require_auth($mysqli);
  if(!isset($_FILES['photo'])) respond(['ok'=>false,'error'=>'photo gerekli'],400);
  $url = save_uploaded_image('photo', 'covers');
  if(!$url) respond(['ok'=>false,'error'=>'Kapak fotoğrafı gerekli'],400);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("UPDATE users SET cover_photo_url=? WHERE id=?");
  $stmt->bind_param("si", $url, $uid);
  $stmt->execute();
  $u = $mysqli->query("SELECT * FROM users WHERE id=".$uid)->fetch_assoc();
  respond(['ok'=>true,'user'=>safe_user($u)]);
}

if($action === 'photo_post_create'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $caption = trim((string)($_POST['caption'] ?? ''));
  $caption = (string)censor_text($caption);
  $imageUrl = save_uploaded_image('photo', 'posts');
  if(!$imageUrl) respond(['ok'=>false,'error'=>'Fotoğraf gerekli'],400);
  if(!db_table_exists($mysqli, 'photo_posts')) respond(['ok'=>false,'error'=>'photo_posts tablosu bulunamadı. database.sql veya migration.sql çalıştır.'],500);
  $stmt = $mysqli->prepare("INSERT INTO photo_posts(user_id,image_url,caption) VALUES(?,?,?)");
  if(!$stmt) respond(['ok'=>false,'error'=>'Fotoğraf kaydı hazırlanamadı'],500);
  $stmt->bind_param("iss",$uid,$imageUrl,$caption);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Fotoğraf kaydedilemedi: '.$stmt->error],500);
  $newId = (int)$stmt->insert_id;
  $row = $mysqli->query("SELECT * FROM photo_posts WHERE id=".$newId." LIMIT 1")->fetch_assoc();
  respond(['ok'=>true,'id'=>$newId,'image_url'=>$imageUrl,'item'=>$row]);
}

if($action === 'photo_posts'){
  $me = require_auth($mysqli);
  $viewerId = (int)$me['id'];
  $userId = (int)($_GET['user_id'] ?? 0);
  if($userId<=0) respond(['ok'=>false,'error'=>'user_id gerekli'],400);
  $stmt = $mysqli->prepare("SELECT p.*, u.full_name, u.photo_url FROM photo_posts p JOIN users u ON u.id=p.user_id WHERE p.user_id=? ORDER BY p.pinned DESC, p.display_order ASC, p.id DESC LIMIT 300");
  if(!$stmt) respond(['ok'=>false,'error'=>'Fotoğraflar alınamadı'],500);
  $stmt->bind_param("i",$userId);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Fotoğraflar alınamadı: '.$stmt->error],500);
  $res = $stmt->get_result();
  $items=[];
  while($m=$res->fetch_assoc()){
    $mid=(int)$m['id'];
    $likes = 0;
    $comments = 0;
    $likedByMe = false;
    if(db_table_exists($mysqli, 'photo_post_likes')){
      $likes = (int)($mysqli->query("SELECT COUNT(*) c FROM photo_post_likes WHERE post_id=$mid")->fetch_assoc()['c'] ?? 0);
      $likedByMe = (bool)($mysqli->query("SELECT 1 c FROM photo_post_likes WHERE post_id=$mid AND user_id=$viewerId LIMIT 1")->fetch_assoc()['c'] ?? false);
    }
    if(db_table_exists($mysqli, 'photo_post_comments')){
      $comments = (int)($mysqli->query("SELECT COUNT(*) c FROM photo_post_comments WHERE post_id=$mid AND deleted_at IS NULL")->fetch_assoc()['c'] ?? 0);
    }

    $commentItems = [];
    if(db_table_exists($mysqli, 'photo_post_comments')){
      $cres = $mysqli->query("SELECT c.*, u.full_name, u.photo_url FROM photo_post_comments c JOIN users u ON u.id=c.user_id WHERE c.post_id=$mid AND c.deleted_at IS NULL ORDER BY c.created_at ASC LIMIT 100");
      while($c = $cres ? $cres->fetch_assoc() : null){
        $commentItems[] = [
          'id'=>(int)$c['id'],
          'user_id'=>(int)$c['user_id'],
          'full_name'=>$c['full_name'],
          'photo_url'=>$c['photo_url'] ?? null,
          'body'=>$c['body'],
          'created_at'=>$c['created_at']
        ];
      }
    }

    $items[]=[
      'id'=>$mid,
      'user_id'=>(int)$m['user_id'],
      'full_name'=>$m['full_name'],
      'user_photo_url'=>$m['photo_url'] ?? null,
      'image_url'=>upload_url_exists($m['image_url']) ?: $m['image_url'],
      'caption'=>$m['caption'],
      'pinned'=>(int)($m['pinned'] ?? 0),
      'display_order'=>(int)($m['display_order'] ?? 0),
      'created_at'=>$m['created_at'],
      'likes_count'=>$likes,
      'comments_count'=>$comments,
      'liked_by_me'=>$likedByMe,
      'my_liked'=>$likedByMe,
      'comments'=>$commentItems
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'photo_post_update'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  if($id<=0) respond(['ok'=>false,'error'=>'id gerekli'],400);
  $row = $mysqli->query("SELECT * FROM photo_posts WHERE id=$id LIMIT 1")->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Fotoğraf bulunamadı'],404);
  if((int)$row['user_id'] !== $uid) respond(['ok'=>false,'error'=>'Yetki yok'],403);
  $caption = trim((string)($b['caption'] ?? (string)$row['caption']));
  $pinned = isset($b['pinned']) ? ((int)$b['pinned']===1 ? 1 : 0) : (int)($row['pinned'] ?? 0);
  $displayOrder = isset($b['display_order']) ? max(0,(int)$b['display_order']) : (int)($row['display_order'] ?? 0);
  $stmt = $mysqli->prepare("UPDATE photo_posts SET caption=?, pinned=?, display_order=? WHERE id=?");
  $stmt->bind_param("siii", $caption, $pinned, $displayOrder, $id);
  $stmt->execute();
  respond(['ok'=>true]);
}

if($action === 'photo_post_reorder'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $ids = $b['ids'] ?? null;
  if(!is_array($ids) || !$ids) respond(['ok'=>false,'error'=>'ids gerekli'],400);
  $order = 1;
  foreach($ids as $pid){
    $pid = (int)$pid;
    if($pid<=0) continue;
    $stmt = $mysqli->prepare("UPDATE photo_posts SET display_order=? WHERE id=? AND user_id=?");
    $stmt->bind_param("iii", $order, $pid, $uid);
    $stmt->execute();
    $order++;
  }
  respond(['ok'=>true]);
}

if($action === 'photo_post_like_toggle'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $b = json_body();
  $postId = (int)($b['post_id'] ?? 0);
  if($postId<=0) respond(['ok'=>false,'error'=>'post_id gerekli'],400);
  $post = $mysqli->query("SELECT id FROM photo_posts WHERE id=$postId LIMIT 1")->fetch_assoc();
  if(!$post) respond(['ok'=>false,'error'=>'Gönderi yok'],404);
  $row = $mysqli->query("SELECT id FROM photo_post_likes WHERE post_id=$postId AND user_id=$uid LIMIT 1")->fetch_assoc();
  if($row){
    $rid=(int)$row['id'];
    $mysqli->query("DELETE FROM photo_post_likes WHERE id=$rid");
    $liked = false;
  }else{
    $stmt = $mysqli->prepare("INSERT INTO photo_post_likes(post_id,user_id) VALUES(?,?)");
    $stmt->bind_param("ii",$postId,$uid);
    $stmt->execute();
    $liked = true;
  }
  $likes = (int)($mysqli->query("SELECT COUNT(*) c FROM photo_post_likes WHERE post_id=$postId")->fetch_assoc()['c'] ?? 0);
  respond(['ok'=>true,'liked'=>$liked,'likes_count'=>$likes]);
}

if($action === 'photo_post_comment_create'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $b = json_body();
  $postId = (int)($b['post_id'] ?? 0);
  $body = trim((string)($b['body'] ?? ''));
  if($postId<=0) respond(['ok'=>false,'error'=>'post_id gerekli'],400);
  if($body==='') respond(['ok'=>false,'error'=>'Yorum yaz.'],400);
  $post = $mysqli->query("SELECT id FROM photo_posts WHERE id=$postId LIMIT 1")->fetch_assoc();
  if(!$post) respond(['ok'=>false,'error'=>'Gönderi yok'],404);
  if($body!=='') $body = (string)censor_and_log($mysqli, $body, (int)$me['id'], 'dm_send', $cid);
  $body = (string)censor_text($body);
  $stmt = $mysqli->prepare("INSERT INTO photo_post_comments(post_id,user_id,body) VALUES(?,?,?)");
  $stmt->bind_param("iis",$postId,$uid,$body);
  $stmt->execute();
  respond(['ok'=>true,'id'=>(int)$stmt->insert_id]);
}

if($action === 'photo_post_comment_delete'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $b = json_body();
  $id = (int)($b['comment_id'] ?? 0);
  if($id<=0) respond(['ok'=>false,'error'=>'comment_id gerekli'],400);
  $row = $mysqli->query("SELECT * FROM photo_post_comments WHERE id=$id LIMIT 1")->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Yorum yok'],404);
  if((int)$row['user_id']!==$uid && (int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetki yok'],403);
  $mysqli->query("UPDATE photo_post_comments SET deleted_at=NOW(), body='' WHERE id=$id");
  respond(['ok'=>true]);
}

if($action === 'photo_post_delete'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  if($id<=0) respond(['ok'=>false,'error'=>'id gerekli'],400);
  $row = $mysqli->query("SELECT * FROM photo_posts WHERE id=$id LIMIT 1")->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Gönderi yok'],404);
  if((int)$row['user_id']!==$uid && (int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetki yok'],403);
  $stmt = $mysqli->prepare("DELETE FROM photo_posts WHERE id=?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  respond(['ok'=>true]);
}

if($action === 'add_farewell'){
  $me = require_auth($mysqli);

  // Support both JSON and multipart/form-data (for photo)
  $to = 0; $msg = ''; $mp = ''; $mu = '';
  if(isset($_SERVER['CONTENT_TYPE']) && str_contains(strtolower($_SERVER['CONTENT_TYPE']), 'multipart/form-data')){
    $to = (int)($_POST['to_user_id'] ?? 0);
    $msg = trim((string)($_POST['message'] ?? ''));
    $mp = trim((string)($_POST['music_platform'] ?? ''));
    $mu = trim((string)($_POST['music_url'] ?? ''));
  }else{
    $b = json_body();
    $to = (int)($b['to_user_id'] ?? 0);
    $msg = trim((string)($b['message'] ?? ''));
    $mp = trim((string)($b['music_platform'] ?? ''));
    $mu = trim((string)($b['music_url'] ?? ''));
  }

  if($to<=0 || $msg==='') respond(['ok'=>false,'error'=>'Kullanıcı ve mesaj gerekli'],400);
  $from = (int)$me['id'];
  if($from === $to) respond(['ok'=>false,'error'=>'Kendine mesaj atamazsın'],400);

  $msg = (string)censor_text($msg);
  $photoUrl = save_uploaded_image('photo', 'farewells'); // optional

  $usePhotoColumn = db_column_exists($mysqli, 'farewells', 'photo_url');
  if($usePhotoColumn){
    $stmt = $mysqli->prepare("INSERT INTO farewells(from_user_id,to_user_id,message,music_platform,music_url,photo_url) VALUES(?,?,?,?,?,?)");
    if(!$stmt) respond(['ok'=>false,'error'=>'Veda mesajı hazırlanamadı'],500);
    $stmt->bind_param("iissss", $from, $to, $msg, $mp, $mu, $photoUrl);
  }else{
    $stmt = $mysqli->prepare("INSERT INTO farewells(from_user_id,to_user_id,message,music_platform,music_url) VALUES(?,?,?,?,?)");
    if(!$stmt) respond(['ok'=>false,'error'=>'Veda mesajı hazırlanamadı'],500);
    $stmt->bind_param("iisss", $from, $to, $msg, $mp, $mu);
  }
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Veda mesajı kaydedilemedi: '.$stmt->error],500);
  $fid = (int)$stmt->insert_id;

  // Streak + Email notification (best effort, do not fail request)
  @update_streak($mysqli, $from, $to);
  @maybe_send_farewell_email($mysqli, $from, $to, $msg, $mu!=='' ? $mu : null);

  respond(['ok'=>true,'id'=>$fid]);
}

if($action === 'received_farewells'){
  $me = require_auth($mysqli);
  $sort = ($_GET['sort'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
  $uid = (int)$me['id'];
  $sql = "SELECT f.*, u.full_name AS from_name
          FROM farewells f JOIN users u ON u.id=f.from_user_id
          WHERE f.to_user_id=?
          ORDER BY f.created_at $sort
          LIMIT 200";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i",$uid);
  $stmt->execute();
  $res = $stmt->get_result();
  $items = [];
  while($f = $res->fetch_assoc()){
    // reactions counts
    $stmt2 = $mysqli->prepare("SELECT emoji, COUNT(*) c FROM farewell_reactions WHERE farewell_id=? GROUP BY emoji");
    $fid = (int)$f['id'];
    $stmt2->bind_param("i",$fid);
    $stmt2->execute();
    $r2 = $stmt2->get_result();
    $reactions = [];
    while($rr = $r2->fetch_assoc()){
      $reactions[$rr['emoji']] = (int)$rr['c'];
    }
    $stmt3 = $mysqli->prepare("SELECT emoji FROM farewell_reactions WHERE farewell_id=? AND user_id=?");
    $stmt3->bind_param("ii",$fid,$uid);
    $stmt3->execute();
    $r3 = $stmt3->get_result();
    $my = [];
    while($m = $r3->fetch_assoc()) $my[] = $m['emoji'];

    $items[] = [
      'id'=>$fid,
      'from_user_id'=>(int)$f['from_user_id'],
      'from_name'=>$f['from_name'],
      'message'=>$f['message'],
      'reply'=>$f['reply'],
      'music_platform'=>$f['music_platform'],
      'music_url'=>$f['music_url'],
      'photo_url'=>$f['photo_url'] ?? null,
      'created_at'=>$f['created_at'],
      'reactions'=>$reactions,
      'my_reactions'=>$my
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'react_farewell'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  $emoji = trim((string)($b['emoji'] ?? ''));
  if($id<=0 || $emoji==='') respond(['ok'=>false,'error'=>'id/emoji gerekli'],400);
  $uid = (int)$me['id'];

  // toggle
  $stmt = $mysqli->prepare("SELECT id FROM farewell_reactions WHERE farewell_id=? AND user_id=? AND emoji=? LIMIT 1");
  $stmt->bind_param("iis",$id,$uid,$emoji);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if($row){
    $rid = (int)$row['id'];
    $mysqli->query("DELETE FROM farewell_reactions WHERE id=".$rid);
  }else{
    $stmt2 = $mysqli->prepare("INSERT INTO farewell_reactions(farewell_id,user_id,emoji) VALUES(?,?,?)");
    $stmt2->bind_param("iis",$id,$uid,$emoji);
    $stmt2->execute();
  }
  respond(['ok'=>true]);
}

if($action === 'reply_farewell'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  $reply = trim((string)($b['reply'] ?? ''));
  $reply = (string)censor_and_log($mysqli, $reply, (int)$me['id'], 'farewell_reply', $id);
  $reply = (string)censor_text($reply);
  if($id<=0 || $reply==='') respond(['ok'=>false,'error'=>'id/reply gerekli'],400);
  $uid = (int)$me['id'];

  // only recipient can reply
  $stmt = $mysqli->prepare("SELECT to_user_id FROM farewells WHERE id=?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Mesaj yok'],404);
  if((int)$row['to_user_id'] !== $uid && (int)$me['is_admin'] !== 1) respond(['ok'=>false,'error'=>'Yetki yok'],403);

  $stmt2 = $mysqli->prepare("UPDATE farewells SET reply=?, updated_at=NOW() WHERE id=?");
  $stmt2->bind_param("si",$reply,$id);
  $stmt2->execute();
  respond(['ok'=>true]);
}

if($action === 'update_farewell'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  $msg = trim((string)($b['message'] ?? ''));
  $msg = (string)censor_text($msg);
  $msg = (string)censor_text($msg);
  if($id<=0 || $msg==='') respond(['ok'=>false,'error'=>'id/message gerekli'],400);
  $uid = (int)$me['id'];

  $stmt = $mysqli->prepare("SELECT from_user_id FROM farewells WHERE id=?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Mesaj yok'],404);
  if((int)$row['from_user_id'] !== $uid && (int)$me['is_admin'] !== 1) respond(['ok'=>false,'error'=>'Yetki yok'],403);

  $stmt2 = $mysqli->prepare("UPDATE farewells SET message=?, updated_at=NOW() WHERE id=?");
  $stmt2->bind_param("si",$msg,$id);
  $stmt2->execute();
  respond(['ok'=>true]);
}

if($action === 'delete_farewell'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  if($id<=0) respond(['ok'=>false,'error'=>'id gerekli'],400);
  $uid = (int)$me['id'];

  $stmt = $mysqli->prepare("SELECT from_user_id FROM farewells WHERE id=?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Mesaj yok'],404);
  if((int)$row['from_user_id'] !== $uid && (int)$me['is_admin'] !== 1) respond(['ok'=>false,'error'=>'Yetki yok'],403);

  $mysqli->query("DELETE FROM farewells WHERE id=".$id);
  respond(['ok'=>true]);
}

// Legacy feed & post (chat only)
if($action === 'legacy_feed'){
  $me = require_auth($mysqli);
  $sql = "SELECT m.*, u.full_name, u.grad_year FROM legacy_messages m JOIN users u ON u.id=m.user_id ORDER BY m.created_at DESC LIMIT 200";
  $res = $mysqli->query($sql);
  $items=[];
  while($r=$res->fetch_assoc()){
    $items[]=[
      'id'=>(int)$r['id'],
      'user_id'=>(int)$r['user_id'],
      'from_name'=>$r['full_name'],
      'from_year'=>$r['grad_year']!==null?(int)$r['grad_year']:null,
      'message'=>$r['message'],
      'reply_to'=>$r['reply_to']!==null?(int)$r['reply_to']:null,
      'created_at'=>$r['created_at'],
      'updated_at'=>$r['updated_at'] ?? null,
      'handled_at'=>$r['handled_at'] ?? null,
      'resolution_note'=>$r['resolution_note'] ?? null,
      'reported_report_count'=>(int)($r['reported_report_count'] ?? 0),
    ];
  }
  respond(['ok'=>true,'messages'=>$items]);
}

if($action === 'legacy_post'){
  $me = require_auth($mysqli);
  if(!empty($me['mute_until']) && strtotime((string)$me['mute_until']) > time()) respond(['ok'=>false,'error'=>'Hesabın geçici olarak susturuldu.'],403);
  $b = json_body();
  $msg = trim((string)($b['message'] ?? ''));
  $msg = (string)censor_and_log($mysqli, $msg, (int)$me['id'], 'legacy_post', null);
  $msg = (string)censor_text($msg);
  $msg = (string)censor_text($msg);
  $reply_to = $b['reply_to'] ?? null;
  $rt = null;
  if($reply_to !== null && $reply_to !== '') $rt = (int)$reply_to;
  if($msg==='') respond(['ok'=>false,'error'=>'Mesaj yaz.'],400);
  $uid=(int)$me['id'];
  $stmt=$mysqli->prepare("INSERT INTO legacy_messages(user_id,message,reply_to) VALUES(?,?,?)");
  $stmt->bind_param("isi",$uid,$msg,$rt);
  $stmt->execute();
  respond(['ok'=>true]);
}


if($action === 'legacy_update'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  $msg = trim((string)($b['message'] ?? ''));
  if($id<=0) respond(['ok'=>false,'error'=>'id gerekli'],400);
  $msg = (string)censor_and_log($mysqli, $msg, (int)$me['id'], 'legacy_update', null);
  $msg = (string)censor_text($msg);
  if($msg==='') respond(['ok'=>false,'error'=>'Mesaj yaz.'],400);
  $stmt=$mysqli->prepare("SELECT user_id FROM legacy_messages WHERE id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'Sorgu hazırlanamadı: '.$mysqli->error],500);
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $row=$stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Bulunamadı'],404);
  $owner=(int)$row['user_id'];
  if($owner !== (int)$me['id'] && (int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $stmt2=$mysqli->prepare("UPDATE legacy_messages SET message=? WHERE id=? LIMIT 1");
  if(!$stmt2) respond(['ok'=>false,'error'=>'Güncelleme hazırlanamadı: '.$mysqli->error],500);
  $stmt2->bind_param("si",$msg,$id);
  $stmt2->execute();
  respond(['ok'=>true]);
}

// Polls
if($action === 'poll_list'){
  $me = require_auth($mysqli);
  $sql = "SELECT p.*, u.full_name FROM polls p JOIN users u ON u.id=p.user_id ORDER BY p.created_at DESC LIMIT 50";
  $res = $mysqli->query($sql);
  $polls=[];
  while($p = $res->fetch_assoc()){
    $pid=(int)$p['id'];
    $optsRes = $mysqli->query("SELECT id, option_text FROM poll_options WHERE poll_id=$pid ORDER BY id ASC");
    $opts=[];
    while($o=$optsRes->fetch_assoc()){
      $oid=(int)$o['id'];
      $cnt = (int)($mysqli->query("SELECT COUNT(*) c FROM poll_votes WHERE option_id=$oid")->fetch_assoc()['c'] ?? 0);
      $opts[]=['id'=>$oid,'text'=>$o['option_text'],'votes'=>$cnt];
    }
    $myVote = null;
    $uid=(int)$me['id'];
    $mv = $mysqli->query("SELECT option_id FROM poll_votes WHERE poll_id=$pid AND user_id=$uid LIMIT 1")->fetch_assoc();
    if($mv) $myVote=(int)$mv['option_id'];
    $polls[]=[
      'id'=>$pid,
      'question'=>$p['question'],
      'from_name'=>$p['full_name'],
      'user_id'=>(int)$p['user_id'],
      'is_owner'=>((int)$p['user_id']===(int)$me['id']) || ((int)$me['is_admin']===1),
      'created_at'=>$p['created_at'],
      'options'=>$opts,
      'my_vote'=>$myVote
    ];
  }
  respond(['ok'=>true,'polls'=>$polls]);
}

if($action === 'poll_create'){
  $me = require_auth($mysqli);
  $b = json_body();
  $q = trim((string)($b['question'] ?? ''));
  $q = (string)censor_text($q);
  $options = $b['options'] ?? [];
  if($q==='') respond(['ok'=>false,'error'=>'Soru gerekli'],400);
  if(!is_array($options) || count($options)<2) respond(['ok'=>false,'error'=>'En az 2 seçenek gerekli'],400);
  $uid=(int)$me['id'];
  $stmt=$mysqli->prepare("INSERT INTO polls(user_id,question) VALUES(?,?)");
  $stmt->bind_param("is",$uid,$q);
  $stmt->execute();
  $pid=(int)$stmt->insert_id;
  $stmt2=$mysqli->prepare("INSERT INTO poll_options(poll_id,option_text) VALUES(?,?)");
  foreach($options as $opt){
    $t = trim((string)$opt);
    $t = (string)censor_text($t);
    if($t==='') continue;
    $stmt2->bind_param("is",$pid,$t);
    $stmt2->execute();
  }
  respond(['ok'=>true,'id'=>$pid]);
}


if($action === 'poll_update'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  $q = trim((string)($b['question'] ?? ''));
  $q = (string)censor_text($q);
  $options = $b['options'] ?? [];
  if($id<=0) respond(['ok'=>false,'error'=>'id gerekli'],400);
  if($q==='') respond(['ok'=>false,'error'=>'Soru gerekli'],400);
  if(!is_array($options) || count(array_filter($options, fn($x)=>trim((string)$x)!==''))<2) respond(['ok'=>false,'error'=>'En az 2 seçenek gerekli'],400);

  $stmt=$mysqli->prepare("SELECT user_id FROM polls WHERE id=? LIMIT 1");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $row=$stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Bulunamadı'],404);
  $owner=(int)$row['user_id'];
  if($owner !== (int)$me['id'] && (int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);

  $mysqli->begin_transaction();
  try{
    $stmt=$mysqli->prepare("UPDATE polls SET question=? WHERE id=?");
    $stmt->bind_param("si",$q,$id);
    $stmt->execute();
    $mysqli->query("DELETE FROM poll_votes WHERE poll_id=".(int)$id);
    $mysqli->query("DELETE FROM poll_options WHERE poll_id=".(int)$id);
    $stmt2=$mysqli->prepare("INSERT INTO poll_options(poll_id,option_text) VALUES(?,?)");
    foreach($options as $opt){
      $t = trim((string)$opt);
      $t = (string)censor_text($t);
      if($t==='') continue;
      $stmt2->bind_param("is",$id,$t);
      $stmt2->execute();
    }
    $mysqli->commit();
    respond(['ok'=>true]);
  }catch(Throwable $e){
    $mysqli->rollback();
    respond(['ok'=>false,'error'=>'Anket güncellenemedi: '.$e->getMessage()],500);
  }
}

if($action === 'poll_vote'){
  $me = require_auth($mysqli);
  $b = json_body();
  $poll_id=(int)($b['poll_id'] ?? 0);
  $option_id=(int)($b['option_id'] ?? 0);
  if($poll_id<=0 || $option_id<=0) respond(['ok'=>false,'error'=>'Eksik'],400);
  $uid=(int)$me['id'];

  // ensure option belongs to poll
  $row = $mysqli->query("SELECT id FROM poll_options WHERE id=$option_id AND poll_id=$poll_id")->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Seçenek geçersiz'],400);

  // upsert vote
  $stmt=$mysqli->prepare("INSERT INTO poll_votes(poll_id,option_id,user_id) VALUES(?,?,?) ON DUPLICATE KEY UPDATE option_id=VALUES(option_id), created_at=NOW()");
  $stmt->bind_param("iii",$poll_id,$option_id,$uid);
  $stmt->execute();
  respond(['ok'=>true]);
}



// --- Psikoloğum ---
if($action === 'psy_history'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $res = $mysqli->query("SELECT role, content, created_at FROM psych_messages WHERE user_id=$uid ORDER BY id DESC LIMIT 40");
  $rows = [];
  while($r = $res->fetch_assoc()){
    $rows[] = ['role'=>$r['role'],'content'=>$r['content'],'created_at'=>$r['created_at']];
  }
  $rows = array_reverse($rows);
  respond(['ok'=>true,'messages'=>$rows]);
}

if($action === 'psy_send'){
  $me = require_auth($mysqli);
  $b = json_body();
  $text = trim((string)($b['text'] ?? ''));
  if($text==='') respond(['ok'=>false,'error'=>'Mesaj yaz.'],400);
  $text = (string)censor_text($text);
  $uid = (int)$me['id'];

  // store user message
  $stmt = $mysqli->prepare("INSERT INTO psych_messages(user_id,role,content) VALUES(?,?,?)");
  $role='user';
  $stmt->bind_param("iss",$uid,$role,$text);
  $stmt->execute();

  if(psycho_is_sensitive($text)){
    $reply = psycho_safe_reply();
  }else{
    // build short history
    $histRes = $mysqli->query("SELECT role, content FROM psych_messages WHERE user_id=$uid ORDER BY id DESC LIMIT 10");
    $hist = [];
    while($h=$histRes->fetch_assoc()){
      $hist[]=['role'=>$h['role'],'content'=>$h['content']];
    }
    $hist = array_reverse($hist);
    $reply = psycho_openai_reply($text, $hist);
    if(!$reply) $reply = psycho_offline_reply($text);
  }
  $reply = (string)censor_text($reply);

  $stmt2 = $mysqli->prepare("INSERT INTO psych_messages(user_id,role,content) VALUES(?,?,?)");
  $role2='assistant';
  $stmt2->bind_param("iss",$uid,$role2,$reply);
  $stmt2->execute();

  respond(['ok'=>true,'reply'=>$reply]);
}

// --- Streak endpoints ---
if($action === 'streak_with'){
  $me = require_auth($mysqli);
  $other = (int)($_GET['user_id'] ?? 0);
  if($other<=0) respond(['ok'=>false,'error'=>'user_id gerekli'],400);
  $uid=(int)$me['id'];
  $a=min($uid,$other); $b=max($uid,$other);
  $row = $mysqli->query("SELECT * FROM farewell_streaks WHERE user_a=$a AND user_b=$b LIMIT 1")->fetch_assoc();
  if(!$row){
    respond(['ok'=>true,'streak'=>['count'=>0,'active'=>false,'expires_at'=>null,'last_mutual_at'=>null]]);
  }
  $expires = $row['expires_at'] ?? null;
  $active = $expires ? (strtotime($expires.' UTC') > time()) : false;
  respond(['ok'=>true,'streak'=>[
    'count'=>(int)$row['streak_count'],
    'active'=>$active,
    'expires_at'=>$expires,
    'last_mutual_at'=>$row['last_mutual_at'] ?? null
  ]]);
}

if($action === 'my_streaks'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $res = $mysqli->query("SELECT * FROM farewell_streaks WHERE (user_a=$uid OR user_b=$uid) AND streak_count>0 ORDER BY last_mutual_at DESC LIMIT 50");
  $items=[];
  while($r=$res->fetch_assoc()){
    $other = ((int)$r['user_a'] === $uid) ? (int)$r['user_b'] : (int)$r['user_a'];
    $u = $mysqli->query("SELECT id,full_name,school,photo_url FROM users WHERE id=$other")->fetch_assoc();
    if(!$u) continue;
    $expires = $r['expires_at'] ?? null;
    $active = $expires ? (strtotime($expires.' UTC') > time()) : false;
    $items[]=[
      'with'=>safe_user($u),
      'count'=>(int)$r['streak_count'],
      'active'=>$active,
      'expires_at'=>$expires,
      'last_mutual_at'=>$r['last_mutual_at'] ?? null
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

// --- Quick Match (Hızlı Tanış) + DM gate ---
if($action === 'quick_match_send'){
  $me = require_auth($mysqli);
  $b = json_body();
  $to = (int)($b['to_user_id'] ?? 0);
  $from = (int)$me['id'];
  if($to<=0) respond(['ok'=>false,'error'=>'to_user_id gerekli'],400);
  if($to===$from) respond(['ok'=>false,'error'=>'Kendine istek atamazsın'],400);

  // lock check
  $row = $mysqli->query("SELECT reject_count, locked_until FROM quick_match_stats WHERE user_id=$from")->fetch_assoc();
  if($row && $row['locked_until'] && strtotime($row['locked_until'].' UTC') > time()){
    respond(['ok'=>false,'error'=>'Hızlı Tanış kilitli (çok fazla reddedildin).'],403);
  }

  // already accepted?
  $a=min($from,$to); $bb=max($from,$to);
  $conv = $mysqli->query("SELECT id FROM dm_conversations WHERE ".dm_conv_pair_where($mysqli,$a,$bb)." LIMIT 1")->fetch_assoc();
  if($conv) respond(['ok'=>true,'status'=>'accepted','conversation_id'=>(int)$conv['id']]);

  // create request (best effort unique)
  $stmt = $mysqli->prepare("INSERT INTO quick_match_requests(from_user_id,to_user_id,status) VALUES(?,?,'pending')");
  $stmt->bind_param("ii",$from,$to);
  $ok = @$stmt->execute();
  if(!$ok){
    // maybe pending already
    respond(['ok'=>true,'status'=>'pending']);
  }
  respond(['ok'=>true,'status'=>'pending','request_id'=>(int)$stmt->insert_id]);
}

if($action === 'quick_match_inbox'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $res = $mysqli->query("SELECT r.*, u.full_name,u.school,u.photo_url FROM quick_match_requests r JOIN users u ON u.id=r.from_user_id WHERE r.to_user_id=$uid AND r.status='pending' ORDER BY r.created_at DESC LIMIT 50");
  $items=[];
  while($r=$res->fetch_assoc()){
    $items[]=[
      'request_id'=>(int)$r['id'],
      'from'=>safe_user(['id'=>$r['from_user_id'],'full_name'=>$r['full_name'],'email'=>'','school'=>$r['school'],'grad_year'=>null,'bio'=>null,'instagram'=>null,'phone'=>null,'photo_url'=>$r['photo_url'],'is_admin'=>0,'profile_music_platform'=>null,'profile_music_url'=>null,'created_at'=>$r['created_at']]),
      'created_at'=>$r['created_at']
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'quick_match_respond'){
  $me = require_auth($mysqli);
  $b = json_body();
  $rid = (int)($b['request_id'] ?? 0);
  $decision = (string)($b['decision'] ?? '');
  if($rid<=0 || ($decision!=='accept' && $decision!=='reject')) respond(['ok'=>false,'error'=>'Eksik'],400);
  $uid=(int)$me['id'];

  $req = $mysqli->query("SELECT * FROM quick_match_requests WHERE id=$rid AND to_user_id=$uid LIMIT 1")->fetch_assoc();
  if(!$req) respond(['ok'=>false,'error'=>'İstek yok'],404);
  if($req['status']!=='pending') respond(['ok'=>true,'status'=>$req['status']]);

  if($decision==='reject'){
    $mysqli->query("UPDATE quick_match_requests SET status='rejected', responded_at=NOW() WHERE id=$rid");
    $from = (int)$req['from_user_id'];
    // increment reject count for sender
    $mysqli->query("INSERT INTO quick_match_stats(user_id,reject_count,locked_until) VALUES($from,1,NULL) ON DUPLICATE KEY UPDATE reject_count=reject_count+1, updated_at=NOW()");
    $st = $mysqli->query("SELECT reject_count FROM quick_match_stats WHERE user_id=$from")->fetch_assoc();
    $rc = (int)($st['reject_count'] ?? 0);
    if($rc >= 5){
      $lockHours = 24*365; // 1 year
      $mysqli->query("UPDATE quick_match_stats SET locked_until=DATE_ADD(UTC_TIMESTAMP(), INTERVAL $lockHours HOUR) WHERE user_id=$from");
    }
    respond(['ok'=>true,'status'=>'rejected','reject_count'=>$rc]);
  }

  // accept => create/open conversation
  $from = (int)$req['from_user_id'];
  $a=min($from,$uid); $bb=max($from,$uid);
  $stmt = $mysqli->prepare("INSERT INTO dm_conversations(".implode(',', dm_conv_user_columns($mysqli)).") VALUES(?,?)");
  $stmt->bind_param("ii",$a,$bb);
  @$stmt->execute();
  $conv = $mysqli->query("SELECT id FROM dm_conversations WHERE ".dm_conv_pair_where($mysqli,$a,$bb)." LIMIT 1")->fetch_assoc();
  $cid = (int)($conv['id'] ?? 0);

  $mysqli->query("UPDATE quick_match_requests SET status='accepted', responded_at=NOW() WHERE id=$rid");
  respond(['ok'=>true,'status'=>'accepted','conversation_id'=>$cid]);
}



// --- Follow system (required for DM access) ---

if($action === 'meetup_create'){
  $me = require_auth($mysqli);
  $b = json_body();
  if(!is_array($b)) $b = [];
  if(!empty($_POST)) $b = array_merge($b, $_POST);
  $category = trim((string)($b['category'] ?? 'coffee'));
  if(!in_array($category, ['coffee','pitch'], true)) respond(['ok'=>false,'error'=>'Geçersiz kategori.'], 400);
  $title = trim((string)($b['title'] ?? ''));
  $province = trim((string)($b['province'] ?? $b['city'] ?? ''));
  $district = trim((string)($b['district'] ?? ''));
  $notes = trim((string)($b['notes'] ?? ''));
  $meetingAtRaw = trim((string)($b['meeting_at'] ?? ''));
  $genderPref = trim((string)($b['gender_pref'] ?? 'any'));
  $slotsNeeded = isset($b['slots_needed']) && $b['slots_needed'] !== '' ? (int)$b['slots_needed'] : null;
  $desiredAge = isset($b['desired_age']) && $b['desired_age'] !== '' ? (int)$b['desired_age'] : null;
  $durationValue = isset($b['duration_value']) && $b['duration_value'] !== '' ? (int)$b['duration_value'] : null;
  $durationUnit = trim((string)($b['duration_unit'] ?? 'days'));
  if($title === '' || $province === '' || $meetingAtRaw === '') respond(['ok'=>false,'error'=>'Başlık, il ve tarih zorunlu.'], 400);
  if(!in_array($genderPref, ['any','female','male','mixed'], true)) $genderPref = 'any';
  if($desiredAge !== null && ($desiredAge < 10 || $desiredAge > 99)) respond(['ok'=>false,'error'=>'Ortalama yaş 10 ile 99 arasında olmalı.'], 400);
  if(!in_array($durationUnit, ['hours','days'], true)) $durationUnit = 'days';
  if($durationValue === null || $durationValue < 1 || $durationValue > 30) respond(['ok'=>false,'error'=>'İlan süresi 1 ile 30 arasında olmalı.'], 400);
  try{
    $meetingAt = (new DateTime($meetingAtRaw))->format('Y-m-d H:i:s');
  }catch(Throwable $e){
    respond(['ok'=>false,'error'=>'Geçerli bir tarih seç.'], 400);
  }
  $expiresAtObj = new DateTime('now');
  $expiresAtObj->modify('+' . $durationValue . ' ' . ($durationUnit === 'hours' ? 'hours' : 'days'));
  $expiresAt = $expiresAtObj->format('Y-m-d H:i:s');
  if($category === 'pitch' && ($slotsNeeded === null || $slotsNeeded < 1 || $slotsNeeded > 30)){
    respond(['ok'=>false,'error'=>'Halı saha için gereken kişi sayısı 1 ile 30 arasında olmalı.'], 400);
  }
  $legacyCity = $district !== '' ? $district : $province;
  $meetupPhotoUrl = save_uploaded_image('photo', 'meetups');
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("INSERT INTO meetups(user_id,category,title,city,province,district,notes,meeting_at,slots_needed,gender_pref,desired_age,duration_value,duration_unit,expires_at,meetup_photo_url,status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, 'open')");
  if(!$stmt) respond(['ok'=>false,'error'=>'İlan oluşturulamadı.'],500);
  $stmt->bind_param('isssssssisisiss', $uid, $category, $title, $legacyCity, $province, $district, $notes, $meetingAt, $slotsNeeded, $genderPref, $desiredAge, $durationValue, $durationUnit, $expiresAt, $meetupPhotoUrl);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'İlan kaydedilemedi: '.$stmt->error],500);
  respond(['ok'=>true,'id'=>(int)$stmt->insert_id]);
}

if($action === 'meetup_update'){
  $me = require_auth($mysqli);
  $b = json_body();
  if(!is_array($b)) $b = [];
  if(!empty($_POST)) $b = array_merge($b, $_POST);
  $id = (int)($b['id'] ?? 0);
  if($id <= 0) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],400);
  $stmt = $mysqli->prepare("SELECT * FROM meetups WHERE id=? AND user_id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],500);
  $uid = (int)$me['id'];
  $stmt->bind_param('ii', $id, $uid);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],404);
  $category = trim((string)($b['category'] ?? $row['category'] ?? 'coffee'));
  if(!in_array($category, ['coffee','pitch'], true)) respond(['ok'=>false,'error'=>'Geçersiz kategori.'], 400);
  $title = trim((string)($b['title'] ?? $row['title'] ?? ''));
  $province = trim((string)($b['province'] ?? $row['province'] ?? $row['city'] ?? ''));
  $district = trim((string)($b['district'] ?? $row['district'] ?? ''));
  $notes = trim((string)($b['notes'] ?? $row['notes'] ?? ''));
  $meetingAtRaw = trim((string)($b['meeting_at'] ?? $row['meeting_at'] ?? ''));
  $genderPref = trim((string)($b['gender_pref'] ?? $row['gender_pref'] ?? 'any'));
  $slotsNeeded = isset($b['slots_needed']) && $b['slots_needed'] !== '' ? (int)$b['slots_needed'] : (($row['slots_needed'] !== null) ? (int)$row['slots_needed'] : null);
  $desiredAge = isset($b['desired_age']) && $b['desired_age'] !== '' ? (int)$b['desired_age'] : (($row['desired_age'] !== null) ? (int)$row['desired_age'] : null);
  $durationValue = isset($b['duration_value']) && $b['duration_value'] !== '' ? (int)$b['duration_value'] : (($row['duration_value'] !== null) ? (int)$row['duration_value'] : null);
  $durationUnit = trim((string)($b['duration_unit'] ?? $row['duration_unit'] ?? 'days'));
  if($title === '' || $province === '' || $meetingAtRaw === '') respond(['ok'=>false,'error'=>'Başlık, il ve tarih zorunlu.'], 400);
  if(!in_array($genderPref, ['any','female','male','mixed'], true)) $genderPref = 'any';
  if($desiredAge !== null && ($desiredAge < 10 || $desiredAge > 99)) respond(['ok'=>false,'error'=>'Ortalama yaş 10 ile 99 arasında olmalı.'], 400);
  if(!in_array($durationUnit, ['hours','days'], true)) $durationUnit = 'days';
  if($durationValue === null || $durationValue < 1 || $durationValue > 30) respond(['ok'=>false,'error'=>'İlan süresi 1 ile 30 arasında olmalı.'], 400);
  try{ $meetingAt = (new DateTime($meetingAtRaw))->format('Y-m-d H:i:s'); }
  catch(Throwable $e){ respond(['ok'=>false,'error'=>'Geçerli bir tarih seç.'], 400); }
  $expiresAtObj = new DateTime('now');
  $expiresAtObj->modify('+' . $durationValue . ' ' . ($durationUnit === 'hours' ? 'hours' : 'days'));
  $expiresAt = $expiresAtObj->format('Y-m-d H:i:s');
  if($category === 'pitch' && ($slotsNeeded === null || $slotsNeeded < 1 || $slotsNeeded > 30)) respond(['ok'=>false,'error'=>'Halı saha için gereken kişi sayısı 1 ile 30 arasında olmalı.'], 400);
  if($category !== 'pitch') $slotsNeeded = null;
  $legacyCity = $district !== '' ? $district : $province;
  $meetupPhotoUrl = save_uploaded_image('photo', 'meetups');
  if($meetupPhotoUrl === null) $meetupPhotoUrl = $row['meetup_photo_url'] ?? null;
  $up = $mysqli->prepare("UPDATE meetups SET category=?, title=?, city=?, province=?, district=?, notes=?, meeting_at=?, slots_needed=?, gender_pref=?, desired_age=?, duration_value=?, duration_unit=?, expires_at=?, meetup_photo_url=?, status='open' WHERE id=? AND user_id=?");
  if(!$up) respond(['ok'=>false,'error'=>'İlan güncellenemedi.'],500);
  $up->bind_param('sssssssisisissii', $category, $title, $legacyCity, $province, $district, $notes, $meetingAt, $slotsNeeded, $genderPref, $desiredAge, $durationValue, $durationUnit, $expiresAt, $meetupPhotoUrl, $id, $uid);
  if(!$up->execute()) respond(['ok'=>false,'error'=>'İlan güncellenemedi: '.$up->error],500);
  respond(['ok'=>true]);
}

if($action === 'meetups_list'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $category = trim((string)($_GET['category'] ?? 'coffee'));
  if(!in_array($category, ['coffee','pitch'], true)) $category = 'coffee';
  $province = trim((string)($_GET['province'] ?? $_GET['city'] ?? ''));
  $mode = trim((string)($_GET['mode'] ?? 'open'));
  $reqJoin = db_table_exists($mysqli, 'meetup_requests');
  $questionsEnabled = db_table_exists($mysqli, 'meetup_questions');
  $reviewsEnabled = db_table_exists($mysqli, 'meetup_reviews');
  $requestStatusSelect = $reqJoin ? ", COALESCE(mrself.status, '') AS my_request_status" : ", '' AS my_request_status";
  $pendingSelect = $reqJoin ? ", (SELECT COUNT(*) FROM meetup_requests r1 WHERE r1.meetup_id=m.id AND r1.status='pending') AS pending_count, (SELECT COUNT(*) FROM meetup_requests r2 WHERE r2.meetup_id=m.id AND r2.status='accepted') AS accepted_count" : ", 0 AS pending_count, 0 AS accepted_count";
  $questionSelect = $questionsEnabled ? ", (SELECT COUNT(*) FROM meetup_questions q1 WHERE q1.meetup_id=m.id) AS question_count" : ", 0 AS question_count";
  $reviewSelect = $reviewsEnabled ? ", (SELECT ROUND(AVG(rating),1) FROM meetup_reviews rv WHERE rv.meetup_id=m.id) AS avg_rating, (SELECT COUNT(*) FROM meetup_reviews rv2 WHERE rv2.meetup_id=m.id) AS review_count, (SELECT COUNT(*) FROM meetup_reviews rv3 WHERE rv3.meetup_id=m.id AND rv3.reviewer_id=?) AS my_reviewed" : ", NULL AS avg_rating, 0 AS review_count, 0 AS my_reviewed";
  $acceptedMineSelect = $reqJoin ? ", (SELECT COUNT(*) FROM meetup_requests r4 WHERE r4.meetup_id=m.id AND r4.requester_id=? AND r4.status='accepted') AS am_i_accepted" : ", 0 AS am_i_accepted";
  $requestJoin = $reqJoin ? " LEFT JOIN meetup_requests mrself ON mrself.meetup_id=m.id AND mrself.requester_id=?" : "";
  if($mode === 'saved'){
    $sql = "SELECT m.*, u.full_name, u.photo_url, 1 AS is_saved{$requestStatusSelect}{$pendingSelect}{$questionSelect}{$reviewSelect}{$acceptedMineSelect} FROM meetups m JOIN users u ON u.id=m.user_id JOIN meetup_saves ms ON ms.meetup_id=m.id AND ms.user_id=?{$requestJoin} WHERE m.status IN ('open','closed') AND m.category=?";
    if($province !== '') $sql .= " AND (COALESCE(NULLIF(m.province,''), m.city) LIKE ? OR m.city LIKE ? OR m.district LIKE ?)";
    $sql .= " ORDER BY (m.status='closed'), m.meeting_at ASC, m.id DESC LIMIT 200";
    $stmt = $mysqli->prepare($sql);
    if(!$stmt) respond(['ok'=>false,'error'=>'İlanlar alınamadı.'],500);
    $types = '';
    $params = [];
    if($reviewsEnabled){ $types .= 'i'; $params[] = $uid; }
    if($reqJoin){ $types .= 'i'; $params[] = $uid; }
    if($reqJoin){ $types .= 'i'; $params[] = $uid; }
    $types .= 'i'; $params[] = $uid;
    $types .= 's'; $params[] = $category;
    if($province !== ''){ $like='%'.$province.'%'; $types .= 'sss'; $params[] = $like; $params[] = $like; $params[] = $like; }
    $stmt->bind_param($types, ...$params);
  } else {
    $sql = "SELECT m.*, u.full_name, u.photo_url, CASE WHEN ms.user_id IS NULL THEN 0 ELSE 1 END AS is_saved{$requestStatusSelect}{$pendingSelect}{$questionSelect}{$reviewSelect}{$acceptedMineSelect} FROM meetups m JOIN users u ON u.id=m.user_id LEFT JOIN meetup_saves ms ON ms.meetup_id=m.id AND ms.user_id=?{$requestJoin} WHERE m.status IN ('open','closed') AND m.category=?";
    if($province !== '') $sql .= " AND (COALESCE(NULLIF(m.province,''), m.city) LIKE ? OR m.city LIKE ? OR m.district LIKE ?)";
    $sql .= " ORDER BY (m.status='closed'), m.meeting_at ASC, m.id DESC LIMIT 200";
    $stmt = $mysqli->prepare($sql);
    if(!$stmt) respond(['ok'=>false,'error'=>'İlanlar alınamadı.'],500);
    $types = 'i'; $params = [$uid];
    if($reviewsEnabled){ $types .= 'i'; $params[] = $uid; }
    if($reqJoin){ $types .= 'i'; $params[] = $uid; }
    if($reqJoin){ $types .= 'i'; $params[] = $uid; }
    $types .= 's'; $params[] = $category;
    if($province !== ''){ $like='%'.$province.'%'; $types .= 'sss'; $params[] = $like; $params[] = $like; $params[] = $like; }
    $stmt->bind_param($types, ...$params);
  }
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'İlanlar alınamadı: '.$stmt->error],500);
  $res = $stmt->get_result();
  $items = [];
  while($r = $res->fetch_assoc()){
    $sync = meetup_sync_status($mysqli, (int)$r['id']);
    $acceptedCount = $reqJoin ? (int)($r['accepted_count'] ?? 0) : (int)($sync['accepted_count'] ?? 0);
    if($acceptedCount !== (int)($sync['accepted_count'] ?? $acceptedCount)) $acceptedCount = (int)$sync['accepted_count'];
    $pendingCount = $reqJoin ? (int)($r['pending_count'] ?? 0) : 0;
    $canReview = false;
    if($reviewsEnabled && (int)($r['am_i_accepted'] ?? 0) > 0 && (int)($r['my_reviewed'] ?? 0) === 0){
      $canReview = (($sync['status'] ?? 'open') === 'closed');
    }
    $items[] = [
      'id'=>(int)$r['id'],
      'user_id'=>(int)$r['user_id'],
      'category'=>$r['category'],
      'title'=>$r['title'],
      'province'=>($r['province'] ?? '') !== '' ? $r['province'] : $r['city'],
      'district'=>$r['district'] ?? '',
      'city'=>$r['city'],
      'notes'=>$r['notes'],
      'meeting_at'=>$r['meeting_at'],
      'slots_needed'=>$r['slots_needed'] !== null ? (int)$r['slots_needed'] : null,
      'gender_pref'=>$r['gender_pref'] ?? 'any',
      'desired_age'=>$r['desired_age'] !== null ? (int)$r['desired_age'] : null,
      'duration_value'=>$r['duration_value'] !== null ? (int)$r['duration_value'] : null,
      'duration_unit'=>$r['duration_unit'] ?? 'days',
      'expires_at'=>$r['expires_at'] ?? null,
      'created_at'=>$r['created_at'],
      'full_name'=>$r['full_name'],
      'photo_url'=>$r['photo_url'],
      'meetup_photo_url'=>upload_url_exists($r['meetup_photo_url'] ?? null),
      'is_saved'=>((int)($r['is_saved'] ?? 0) === 1),
      'is_mine'=>((int)$r['user_id'] === $uid),
      'my_request_status'=>$r['my_request_status'] !== '' ? $r['my_request_status'] : null,
      'pending_count'=>$pendingCount,
      'accepted_count'=>$acceptedCount,
      'status'=>$sync['status'],
      'is_full'=>(bool)($sync['is_full'] ?? false),
      'is_expired'=>(bool)($sync['is_expired'] ?? false),
      'question_count'=>(int)($r['question_count'] ?? 0),
      'avg_rating'=>isset($r['avg_rating']) && $r['avg_rating'] !== null ? (float)$r['avg_rating'] : null,
      'review_count'=>(int)($r['review_count'] ?? 0),
      'my_reviewed'=>((int)($r['my_reviewed'] ?? 0) > 0),
      'can_review'=>$canReview,
    ];
    $hostMetrics = meetup_host_metrics($mysqli, (int)$r['user_id']);
    $items[count($items)-1]['host_avg_rating'] = $hostMetrics['avg_rating'];
    $items[count($items)-1]['host_review_count'] = $hostMetrics['review_count'];
    $items[count($items)-1]['hosted_total'] = $hostMetrics['hosted_total'];
    $items[count($items)-1]['completed_total'] = $hostMetrics['completed_total'];
    $items[count($items)-1]['trust_score'] = $hostMetrics['trust_score'];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'meetup_save_toggle'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  if($id <= 0) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],400);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("SELECT id, user_id, status FROM meetups WHERE id=? AND status<>'deleted' LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],500);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],404);
  if((int)$row['user_id'] === $uid) respond(['ok'=>false,'error'=>'Kendi ilanını kaydetmene gerek yok.'],400);

  $check = $mysqli->prepare("SELECT id FROM meetup_saves WHERE user_id=? AND meetup_id=? LIMIT 1");
  if(!$check) respond(['ok'=>false,'error'=>'Kayıt işlemi başarısız.'],500);
  $check->bind_param('ii', $uid, $id);
  $check->execute();
  $existing = $check->get_result()->fetch_assoc();
  if($existing){
    $del = $mysqli->prepare("DELETE FROM meetup_saves WHERE user_id=? AND meetup_id=?");
    if(!$del) respond(['ok'=>false,'error'=>'Kayıt kaldırılamadı.'],500);
    $del->bind_param('ii', $uid, $id);
    $del->execute();
    respond(['ok'=>true,'saved'=>false]);
  }
  $ins = $mysqli->prepare("INSERT INTO meetup_saves(user_id, meetup_id) VALUES(?,?)");
  if(!$ins) respond(['ok'=>false,'error'=>'Kayıt işlemi başarısız.'],500);
  $ins->bind_param('ii', $uid, $id);
  if(!$ins->execute()) respond(['ok'=>false,'error'=>'Kayıt işlemi başarısız.'],500);
  respond(['ok'=>true,'saved'=>true]);
}

if($action === 'meetup_delete'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  if($id <= 0) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],400);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("UPDATE meetups SET status='deleted' WHERE id=? AND user_id=?");
  if(!$stmt) respond(['ok'=>false,'error'=>'İlan silinemedi.'],500);
  $stmt->bind_param('ii', $id, $uid);
  $stmt->execute();
  if($stmt->affected_rows <= 0) respond(['ok'=>false,'error'=>'İlan silinemedi.'],400);
  respond(['ok'=>true]);
}

if($action === 'meetup_request_create'){
  $me = require_auth($mysqli);
  if(!db_table_exists($mysqli, 'meetup_requests')) respond(['ok'=>false,'error'=>'İstek sistemi hazır değil.'],500);
  $b = json_body();
  $meetupId = (int)($b['meetup_id'] ?? 0);
  $note = trim((string)($b['note'] ?? ''));
  if($meetupId <= 0) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],400);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("SELECT id, user_id, category, slots_needed, status, meeting_at FROM meetups WHERE id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],500);
  $stmt->bind_param('i', $meetupId);
  $stmt->execute();
  $meet = $stmt->get_result()->fetch_assoc();
  if(!$meet) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],404);
  if((int)$meet['user_id'] === $uid) respond(['ok'=>false,'error'=>'Kendi ilanına katılma isteği gönderemezsin.'],400);
  $sync = meetup_sync_status($mysqli, $meetupId);
  if(($sync['status'] ?? 'open') !== 'open') respond(['ok'=>false,'error'=>'Bu ilan artık kapandı.'],400);
  $check = $mysqli->prepare("SELECT id, status FROM meetup_requests WHERE meetup_id=? AND requester_id=? LIMIT 1");
  if(!$check) respond(['ok'=>false,'error'=>'İstek gönderilemedi.'],500);
  $check->bind_param('ii', $meetupId, $uid);
  $check->execute();
  $existing = $check->get_result()->fetch_assoc();
  if($existing){
    $status = (string)($existing['status'] ?? '');
    if($status === 'pending') respond(['ok'=>false,'error'=>'Zaten bekleyen bir isteğin var.'],400);
    if($status === 'accepted') respond(['ok'=>false,'error'=>'Bu ilan için zaten seçildin.'],400);
    $up = $mysqli->prepare("UPDATE meetup_requests SET note=?, status='pending', responded_at=NULL, created_at=CURRENT_TIMESTAMP WHERE id=?");
    if(!$up) respond(['ok'=>false,'error'=>'İstek güncellenemedi.'],500);
    $rid = (int)$existing['id'];
    $up->bind_param('si', $note, $rid);
    if(!$up->execute()) respond(['ok'=>false,'error'=>'İstek güncellenemedi.'],500);
    respond(['ok'=>true,'request_id'=>$rid]);
  }
  $ins = $mysqli->prepare("INSERT INTO meetup_requests(meetup_id, requester_id, note, status) VALUES(?,?,?,'pending')");
  if(!$ins) respond(['ok'=>false,'error'=>'İstek gönderilemedi.'],500);
  $ins->bind_param('iis', $meetupId, $uid, $note);
  if(!$ins->execute()) respond(['ok'=>false,'error'=>'İstek gönderilemedi.'],500);
  respond(['ok'=>true,'request_id'=>(int)$ins->insert_id]);
}

if($action === 'meetup_request_cancel'){
  $me = require_auth($mysqli);
  if(!db_table_exists($mysqli, 'meetup_requests')) respond(['ok'=>false,'error'=>'İstek sistemi hazır değil.'],500);
  $b = json_body();
  $meetupId = (int)($b['meetup_id'] ?? 0);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("UPDATE meetup_requests SET status='cancelled', responded_at=NOW() WHERE meetup_id=? AND requester_id=? AND status='pending'");
  if(!$stmt) respond(['ok'=>false,'error'=>'İstek geri çekilemedi.'],500);
  $stmt->bind_param('ii', $meetupId, $uid);
  $stmt->execute();
  if($stmt->affected_rows <= 0) respond(['ok'=>false,'error'=>'Bekleyen istek bulunamadı.'],400);
  respond(['ok'=>true]);
}

if($action === 'meetup_request_respond'){
  $me = require_auth($mysqli);
  if(!db_table_exists($mysqli, 'meetup_requests')) respond(['ok'=>false,'error'=>'İstek sistemi hazır değil.'],500);
  $b = json_body();
  $requestId = (int)($b['request_id'] ?? 0);
  $decision = trim((string)($b['decision'] ?? ''));
  if($requestId <= 0 || !in_array($decision, ['accept','reject'], true)) respond(['ok'=>false,'error'=>'Geçersiz istek.'],400);
  $ownerId = (int)$me['id'];
  $stmt = $mysqli->prepare("SELECT mr.id, mr.meetup_id, mr.status, m.user_id owner_id, m.category, m.slots_needed FROM meetup_requests mr JOIN meetups m ON m.id=mr.meetup_id WHERE mr.id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'İstek bulunamadı.'],500);
  $stmt->bind_param('i', $requestId);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'İstek bulunamadı.'],404);
  if((int)$row['owner_id'] !== $ownerId) respond(['ok'=>false,'error'=>'Bu ilana ait seçim yetkin yok.'],403);
  if((string)$row['status'] !== 'pending') respond(['ok'=>false,'error'=>'Bu istek zaten sonuçlandı.'],400);
  if($decision === 'accept'){
    $sync = meetup_sync_status($mysqli, (int)$row['meetup_id']);
    if(($sync['status'] ?? 'open') !== 'open') respond(['ok'=>false,'error'=>'İlan kapandığı için seçim yapılamıyor.'],400);
    $up = $mysqli->prepare("UPDATE meetup_requests SET status='accepted', responded_at=NOW() WHERE id=?");
    if(!$up) respond(['ok'=>false,'error'=>'İstek kabul edilemedi.'],500);
    $up->bind_param('i', $requestId);
    if(!$up->execute()) respond(['ok'=>false,'error'=>'İstek kabul edilemedi.'],500);
    $syncAfter = meetup_sync_status($mysqli, (int)$row['meetup_id']);
    respond(['ok'=>true, 'accepted'=>true, 'full'=>(bool)($syncAfter['is_full'] ?? false)]);
  }
  $up = $mysqli->prepare("UPDATE meetup_requests SET status='rejected', responded_at=NOW() WHERE id=?");
  if(!$up) respond(['ok'=>false,'error'=>'İstek reddedilemedi.'],500);
  $up->bind_param('i', $requestId);
  if(!$up->execute()) respond(['ok'=>false,'error'=>'İstek reddedilemedi.'],500);
  respond(['ok'=>true, 'accepted'=>false]);
}

if($action === 'meetup_question_create'){
  $me = require_auth($mysqli);
  if(!db_table_exists($mysqli, 'meetup_questions')) respond(['ok'=>false,'error'=>'Soru sistemi hazır değil.'],500);
  $b = json_body();
  $meetupId = (int)($b['meetup_id'] ?? 0);
  $question = trim((string)($b['question_body'] ?? ''));
  if($meetupId <= 0 || $question === '') respond(['ok'=>false,'error'=>'Soru boş olamaz.'],400);
  $stmt = $mysqli->prepare("SELECT id, user_id, status FROM meetups WHERE id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],500);
  $stmt->bind_param('i', $meetupId);
  $stmt->execute();
  $meet = $stmt->get_result()->fetch_assoc();
  if(!$meet) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],404);
  if((int)$meet['user_id'] === (int)$me['id']) respond(['ok'=>false,'error'=>'Kendi ilanına soru sormana gerek yok.'],400);
  $ins = $mysqli->prepare("INSERT INTO meetup_questions(meetup_id, asker_id, question_body) VALUES(?,?,?)");
  if(!$ins) respond(['ok'=>false,'error'=>'Soru gönderilemedi.'],500);
  $uid = (int)$me['id'];
  $ins->bind_param('iis', $meetupId, $uid, $question);
  if(!$ins->execute()) respond(['ok'=>false,'error'=>'Soru gönderilemedi.'],500);
  respond(['ok'=>true]);
}

if($action === 'meetup_question_answer'){
  $me = require_auth($mysqli);
  if(!db_table_exists($mysqli, 'meetup_questions')) respond(['ok'=>false,'error'=>'Soru sistemi hazır değil.'],500);
  $b = json_body();
  $questionId = (int)($b['question_id'] ?? 0);
  $answer = trim((string)($b['answer_body'] ?? ''));
  if($questionId <= 0 || $answer === '') respond(['ok'=>false,'error'=>'Cevap boş olamaz.'],400);
  $stmt = $mysqli->prepare("SELECT q.id, m.user_id owner_id FROM meetup_questions q JOIN meetups m ON m.id=q.meetup_id WHERE q.id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'Soru bulunamadı.'],500);
  $stmt->bind_param('i', $questionId);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Soru bulunamadı.'],404);
  if((int)$row['owner_id'] !== (int)$me['id']) respond(['ok'=>false,'error'=>'Bu soruyu cevaplama yetkin yok.'],403);
  $up = $mysqli->prepare("UPDATE meetup_questions SET answer_body=?, answered_at=NOW() WHERE id=?");
  if(!$up) respond(['ok'=>false,'error'=>'Cevap kaydedilemedi.'],500);
  $up->bind_param('si', $answer, $questionId);
  if(!$up->execute()) respond(['ok'=>false,'error'=>'Cevap kaydedilemedi.'],500);
  respond(['ok'=>true]);
}

if($action === 'meetup_review_create'){
  $me = require_auth($mysqli);
  if(!db_table_exists($mysqli, 'meetup_reviews')) respond(['ok'=>false,'error'=>'Puan sistemi hazır değil.'],500);
  $b = json_body();
  $meetupId = (int)($b['meetup_id'] ?? 0);
  $rating = (int)($b['rating'] ?? 0);
  $comment = trim((string)($b['comment'] ?? ''));
  if($meetupId <= 0 || $rating < 1 || $rating > 5) respond(['ok'=>false,'error'=>'Geçerli bir puan seç.'],400);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("SELECT m.id, m.user_id, m.status FROM meetups m WHERE m.id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],500);
  $stmt->bind_param('i', $meetupId);
  $stmt->execute();
  $meet = $stmt->get_result()->fetch_assoc();
  if(!$meet) respond(['ok'=>false,'error'=>'İlan bulunamadı.'],404);
  if((int)$meet['user_id'] === $uid) respond(['ok'=>false,'error'=>'Kendi ilanını puanlayamazsın.'],400);
  $sync = meetup_sync_status($mysqli, $meetupId);
  if(($sync['status'] ?? 'open') !== 'closed') respond(['ok'=>false,'error'=>'Puan vermek için etkinlik tamamlanmalı.'],400);
  $acc = $mysqli->prepare("SELECT id FROM meetup_requests WHERE meetup_id=? AND requester_id=? AND status='accepted' LIMIT 1");
  if(!$acc) respond(['ok'=>false,'error'=>'Puan verilemedi.'],500);
  $acc->bind_param('ii', $meetupId, $uid);
  $acc->execute();
  if(!$acc->get_result()->fetch_assoc()) respond(['ok'=>false,'error'=>'Sadece kabul edilen katılımcılar puan verebilir.'],403);
  $ins = $mysqli->prepare("INSERT INTO meetup_reviews(meetup_id, reviewer_id, host_user_id, rating, comment) VALUES(?,?,?,?,?) ON DUPLICATE KEY UPDATE rating=VALUES(rating), comment=VALUES(comment)");
  if(!$ins) respond(['ok'=>false,'error'=>'Puan kaydedilemedi.'],500);
  $hostId = (int)$meet['user_id'];
  $ins->bind_param('iiiis', $meetupId, $uid, $hostId, $rating, $comment);
  if(!$ins->execute()) respond(['ok'=>false,'error'=>'Puan kaydedilemedi.'],500);
  respond(['ok'=>true]);
}

if($action === 'meetup_owner_panels'){
  $me = require_auth($mysqli);
  $category = trim((string)($_GET['category'] ?? 'coffee'));
  if(!in_array($category, ['coffee','pitch'], true)) $category = 'coffee';
  $groups = meetup_fetch_owner_panels($mysqli, (int)$me['id'], $category);
  respond(['ok'=>true, 'groups'=>$groups]);
}

function follow_request_between(mysqli $mysqli, int $from, int $to): ?array {
  $stmt = $mysqli->prepare("SELECT * FROM follow_requests WHERE from_user_id=? AND to_user_id=? AND status='pending' ORDER BY id DESC LIMIT 1");
  $stmt->bind_param("ii",$from,$to);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  return $row ?: null;
}

if($action === 'follow_requests_inbox'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $res = @$mysqli->query("SELECT r.*, u.full_name,u.school,u.grad_year,u.photo_url FROM follow_requests r JOIN users u ON u.id=r.from_user_id WHERE r.to_user_id=$uid AND r.status='pending' ORDER BY r.created_at DESC LIMIT 100");
  $items=[];
  if($res){
    while($r=$res->fetch_assoc()){
      $items[] = [
        'request_id'=>(int)$r['id'],
        'from_user'=>[
          'id'=>(int)$r['from_user_id'],
          'full_name'=>$r['full_name'],
          'school'=>$r['school'],
          'grad_year'=>$r['grad_year']!==null?(int)$r['grad_year']:null,
          'photo_url'=>$r['photo_url'],
        ],
        'created_at'=>$r['created_at'],
      ];
    }
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'follow_requests_sent'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $res = @$mysqli->query("SELECT r.*, u.full_name,u.school,u.grad_year,u.photo_url FROM follow_requests r JOIN users u ON u.id=r.to_user_id WHERE r.from_user_id=$uid AND r.status='pending' ORDER BY r.created_at DESC LIMIT 100");
  $items=[];
  if($res){
    while($r=$res->fetch_assoc()){
      $items[] = [
        'request_id'=>(int)$r['id'],
        'to_user'=>[
          'id'=>(int)$r['to_user_id'],
          'full_name'=>$r['full_name'],
          'school'=>$r['school'],
          'grad_year'=>$r['grad_year']!==null?(int)$r['grad_year']:null,
          'photo_url'=>$r['photo_url'],
        ],
        'created_at'=>$r['created_at'],
      ];
    }
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'follow_request_respond'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $b = json_body();
  $rid = (int)($b['request_id'] ?? 0);
  $decision = (string)($b['decision'] ?? ''); // accept|reject
  if($rid<=0) respond(['ok'=>false,'error'=>'request_id gerekli'],400);
  if($decision!=='accept' && $decision!=='reject') respond(['ok'=>false,'error'=>'decision geçersiz'],400);
  $req = $mysqli->query("SELECT * FROM follow_requests WHERE id=$rid AND to_user_id=$uid AND status='pending' LIMIT 1")->fetch_assoc();
  if(!$req) respond(['ok'=>false,'error'=>'İstek yok'],404);
  $from = (int)$req['from_user_id'];
  $newStatus = $decision==='accept' ? 'accepted' : 'rejected';
  $stmt = $mysqli->prepare("UPDATE follow_requests SET status=?, responded_at=NOW() WHERE id=?");
  $stmt->bind_param("si",$newStatus,$rid);
  $stmt->execute();
  if($decision==='accept'){
    $stmt2 = $mysqli->prepare("INSERT IGNORE INTO follows(follower_id,following_id) VALUES(?,?)");
    $stmt2->bind_param("ii",$from,$uid);
    $stmt2->execute();
  }
  $following = is_following($mysqli,$uid,$from);
  $followedBy = is_following($mysqli,$from,$uid);
  respond(['ok'=>true,'status'=>$newStatus,'following'=>$following,'followed_by'=>$followedBy,'mutual'=>($following && $followedBy)]);
}

function is_following(mysqli $mysqli, int $a, int $b): bool {
  $stmt = $mysqli->prepare("SELECT 1 FROM follows WHERE follower_id=? AND following_id=? LIMIT 1");
  $stmt->bind_param("ii",$a,$b);
  $stmt->execute();
  $r = $stmt->get_result();
  return (bool)($r && $r->fetch_row());
}

if($action === 'follow_status'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $other = (int)($_GET['user_id'] ?? 0);
  if($other<=0) respond(['ok'=>false,'error'=>'user_id gerekli'],400);
  if($other===$uid) respond(['ok'=>true,'following'=>false,'followed_by'=>false,'mutual'=>false,'request_sent'=>false,'request_received'=>false]);
  $following = is_following($mysqli,$uid,$other);
  $followedBy = is_following($mysqli,$other,$uid);
  $reqSent = follow_request_between($mysqli,$uid,$other);
  $reqReceived = follow_request_between($mysqli,$other,$uid);
  $privacyRow = @$mysqli->query("SELECT account_privacy,is_admin FROM users WHERE id=$other LIMIT 1")->fetch_assoc();
  $accountPrivacy = (string)($privacyRow['account_privacy'] ?? 'private');
  respond(['ok'=>true,'following'=>$following,'followed_by'=>$followedBy,'mutual'=>($following && $followedBy),'request_sent'=>(bool)$reqSent,'request_received'=>(bool)$reqReceived,'request_id'=>$reqReceived ? (int)$reqReceived['id'] : null,'account_privacy'=>$accountPrivacy,'open_account'=>$accountPrivacy==='public']);
}

if($action === 'follow_toggle'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $b = json_body();
  $other = (int)($b['user_id'] ?? 0);
  if($other<=0) respond(['ok'=>false,'error'=>'user_id gerekli'],400);
  if($other===$uid) respond(['ok'=>false,'error'=>'Kendini takip edemezsin'],400);

  $following = is_following($mysqli,$uid,$other);
  $reqSent = follow_request_between($mysqli,$uid,$other);

  if($following){
    $stmt = $mysqli->prepare("DELETE FROM follows WHERE follower_id=? AND following_id=?");
    $stmt->bind_param("ii",$uid,$other);
    $stmt->execute();
    $following=false;
    $status='unfollowed';
  }else if($reqSent){
    $stmt = $mysqli->prepare("UPDATE follow_requests SET status='cancelled', responded_at=NOW() WHERE id=?");
    $rid=(int)$reqSent['id'];
    $stmt->bind_param("i",$rid);
    $stmt->execute();
    $status='cancelled';
  }else{
    $target = @$mysqli->query("SELECT account_privacy,is_admin FROM users WHERE id=$other LIMIT 1")->fetch_assoc();
    if(!$target) respond(['ok'=>false,'error'=>'Kullanıcı bulunamadı.'],404);
    $targetPrivacy = (string)($target['account_privacy'] ?? 'private');
    if($targetPrivacy === 'public'){
      $stmt = $mysqli->prepare("INSERT IGNORE INTO follows(follower_id,following_id) VALUES(?,?)");
      $stmt->bind_param("ii",$uid,$other);
      $stmt->execute();
      $following=true;
      $status='followed';
      @$mysqli->query("UPDATE follow_requests SET status='accepted', responded_at=NOW() WHERE from_user_id=$uid AND to_user_id=$other AND status='pending'");
    }else{
      $stmt = $mysqli->prepare("INSERT INTO follow_requests(from_user_id,to_user_id,status) VALUES(?,?,'pending')");
      $stmt->bind_param("ii",$uid,$other);
      $stmt->execute();
      $status='requested';
    }
  }
  $followedBy = is_following($mysqli,$other,$uid);
  $mutual = $following && $followedBy;
  respond(['ok'=>true,'status'=>$status,'following'=>$following,'followed_by'=>$followedBy,'mutual'=>$mutual,'request_sent'=>($status==='requested')]);
}

// Follow counts + lists (followers / following)
function follow_counts(mysqli $mysqli, int $userId): array {
  $followers = (int)($mysqli->query("SELECT COUNT(*) c FROM follows WHERE following_id=$userId")->fetch_assoc()['c'] ?? 0);
  $following = (int)($mysqli->query("SELECT COUNT(*) c FROM follows WHERE follower_id=$userId")->fetch_assoc()['c'] ?? 0);
  return ['followers'=>$followers,'following'=>$following];
}

function dm_unread_count(mysqli $mysqli, int $uid): int {
  $count = 0;
  if(db_table_exists($mysqli, 'dm_conversations') && db_table_exists($mysqli, 'dm_messages')){
    $convCol = dm_message_conv_column($mysqli);
    $senderCol = dm_message_sender_column($mysqli);
    $deletedCol = dm_message_deleted_column($mysqli);
    $deletedWhere = $deletedCol ? " AND m.`$deletedCol` IS NULL" : '';
    [$c1,$c2] = dm_conv_user_columns($mysqli);
    $rows = @$mysqli->query("SELECT c.id,
        COALESCE((SELECT COUNT(*) FROM dm_messages m WHERE m.`$convCol`=c.id AND m.`$senderCol`<>$uid".$deletedWhere." AND m.id > COALESCE((SELECT last_seen_message_id FROM dm_reads r WHERE r.conversation_id=c.id AND r.user_id=$uid LIMIT 1),0)),0) AS unread_count
      FROM dm_conversations c
      WHERE c.`$c1`=$uid OR c.`$c2`=$uid");
    while($rows && ($row=$rows->fetch_assoc())){
      $count += (int)($row['unread_count'] ?? 0);
    }
  }
  if(db_table_exists($mysqli, 'dm_group_members') && db_table_exists($mysqli, 'dm_group_messages')){
    $rows = @$mysqli->query("SELECT gm.group_id, COALESCE((SELECT COUNT(*) FROM dm_group_messages m WHERE m.group_id=gm.group_id AND m.sender_id<>$uid AND m.deleted_at IS NULL AND m.id > COALESCE((SELECT last_seen_message_id FROM dm_group_reads r WHERE r.group_id=gm.group_id AND r.user_id=$uid LIMIT 1),0)),0) AS unread_count FROM dm_group_members gm WHERE gm.user_id=$uid");
    while($rows && ($row=$rows->fetch_assoc())){
      $count += (int)($row['unread_count'] ?? 0);
    }
  }
  return $count;
}

function follow_request_inbox_count(mysqli $mysqli, int $uid): int {
  if(!db_table_exists($mysqli, 'follow_requests')) return 0;
  $res = @$mysqli->query("SELECT COUNT(*) c FROM follow_requests WHERE to_user_id=$uid AND status='pending'");
  $row = $res ? $res->fetch_assoc() : null;
  return (int)($row['c'] ?? 0);
}

function safe_is_following(mysqli $mysqli, int $a, int $b): bool {
  if(!db_table_exists($mysqli, 'follows')) return false;
  $stmt = @$mysqli->prepare("SELECT 1 FROM follows WHERE follower_id=? AND following_id=? LIMIT 1");
  if(!$stmt) return false;
  @$stmt->bind_param("ii",$a,$b);
  @$stmt->execute();
  $res = @$stmt->get_result();
  return (bool)($res && $res->fetch_row());
}

if($action === 'profile_badges'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  respond([
    'ok'=>true,
    'follow_requests'=>follow_request_inbox_count($mysqli,$uid),
    'dm_unread'=>dm_unread_count($mysqli,$uid)
  ]);
}

if($action === 'follow_counts'){
  $me = require_auth($mysqli);
  $userId = (int)($_GET['user_id'] ?? (int)$me['id']);
  if($userId<=0) respond(['ok'=>false,'error'=>'user_id gerekli'],400);
  $c = follow_counts($mysqli, $userId);
  respond(['ok'=>true] + $c);
}

if($action === 'follow_list'){
  $me = require_auth($mysqli);
  $viewerId = (int)$me['id'];
  $userId = (int)($_GET['user_id'] ?? $viewerId);
  $type = ($_GET['type'] ?? 'followers'); // followers|following
  if($userId<=0) respond(['ok'=>false,'error'=>'user_id gerekli'],400);
  if($type !== 'followers' && $type !== 'following') respond(['ok'=>false,'error'=>'type geçersiz'],400);

  $limit = 200;
  if($type === 'followers'){
    $sql = "SELECT u.* FROM follows f JOIN users u ON u.id=f.follower_id WHERE f.following_id=? ORDER BY f.created_at DESC LIMIT $limit";
  }else{
    $sql = "SELECT u.* FROM follows f JOIN users u ON u.id=f.following_id WHERE f.follower_id=? ORDER BY f.created_at DESC LIMIT $limit";
  }
  $stmt = $mysqli->prepare($sql);
  if(!$stmt) respond(['ok'=>false,'error'=>'Takip listesi açılamadı'],500);
  $stmt->bind_param("i", $userId);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Takip listesi alınamadı: '.$stmt->error],500);
  $res = $stmt->get_result();
  $items = [];
  while($u = $res->fetch_assoc()){
    $otherId = (int)$u['id'];
    $following = is_following($mysqli, $viewerId, $otherId);
    $followedBy = is_following($mysqli, $otherId, $viewerId);
    $requestSent = (bool)follow_request_between($mysqli, $viewerId, $otherId);
    $canFollowBack = ($type === 'followers') && ($viewerId !== $otherId) && !$following;
    $items[] = array_merge(safe_user($u), [
      'following'=>$following,
      'followed_by'=>$followedBy,
      'mutual'=>($following && $followedBy),
      'request_sent'=>$requestSent,
      'can_follow_back'=>$canFollowBack
    ]);
  }
  respond(['ok'=>true,'items'=>$items]);
}

// Open (or create) DM with a user, only if mutual follow OR accepted quick-match exists.
if($action === 'dm_open_with'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $other = (int)($_GET['user_id'] ?? 0);
  if($other<=0) respond(['ok'=>false,'error'=>'user_id gerekli'],400);
  if($other===$uid) respond(['ok'=>false,'error'=>'Kendinle sohbet açamazsın'],400);

  ensure_feature_schema($mysqli);

  $uRes = @$mysqli->query("SELECT id, dm_privacy, is_admin, account_privacy FROM users WHERE id=$other LIMIT 1");
  $otherUser = $uRes ? $uRes->fetch_assoc() : null;
  if(!$otherUser) respond(['ok'=>false,'error'=>'Kullanıcı bulunamadı'],404);
  $adminBypassBlock = ((int)($me['is_admin'] ?? 0) === 1);
  $blockRes = @$mysqli->query("SELECT 1 FROM user_blocks WHERE (blocker_id=$uid AND blocked_id=$other) OR (blocker_id=$other AND blocked_id=$uid) LIMIT 1");
  if(!$adminBypassBlock && $blockRes && $blockRes->fetch_row()) respond(['ok'=>false,'error'=>'Bu kullanıcıyla mesajlaşma engel nedeniyle kapalı.'],403);

  $a=min($uid,$other); $bb=max($uid,$other);

  if(db_table_exists($mysqli, 'dm_conversations')){
    $existingRes = @$mysqli->query("SELECT id FROM dm_conversations WHERE ".dm_conv_pair_where($mysqli,$a,$bb)." LIMIT 1");
    $existing = $existingRes ? $existingRes->fetch_assoc() : null;
    if($existing && (int)($existing['id'] ?? 0) > 0){
      respond(['ok'=>true,'conversation_id'=>(int)$existing['id']]);
    }
  }

  $mutual = safe_is_following($mysqli,$uid,$other) && safe_is_following($mysqli,$other,$uid);
  $quickMatchAccepted = false;

  if(!$mutual && db_table_exists($mysqli, 'quick_match_requests')){
    $qmRes = @$mysqli->query("SELECT 1 FROM quick_match_requests
      WHERE ((from_user_id=$uid AND to_user_id=$other) OR (from_user_id=$other AND to_user_id=$uid))
      AND status='accepted' LIMIT 1");
    $quickMatchAccepted = (bool)($qmRes && $qmRes->fetch_row());
  }

  $targetPrivacy = (string)($otherUser['dm_privacy'] ?? 'everyone');
  $targetAccountPrivacy = (string)($otherUser['account_privacy'] ?? 'private');
  $adminBypass = ((int)($me['is_admin'] ?? 0) === 1) || ((int)($otherUser['is_admin'] ?? 0) === 1);
  $privacyAllows = $adminBypass || ($targetPrivacy === 'everyone') || ($targetAccountPrivacy === 'public') || $mutual || $quickMatchAccepted;
  if(!$privacyAllows){
    respond(['ok'=>false,'error'=>'Bu kullanıcı sadece karşılıklı takip ettiği kişilerden mesaj alıyor.'],403);
  }

  if(!db_table_exists($mysqli, 'dm_conversations')){
    respond(['ok'=>false,'error'=>'DM tablosu bulunamadı.'],500);
  }

  [$dmC1,$dmC2] = dm_conv_user_columns($mysqli);
  $insertSql = "INSERT IGNORE INTO dm_conversations($dmC1,$dmC2) VALUES($a,$bb)";
  $ins = @$mysqli->query($insertSql);
  if($ins === false){
    $err = $mysqli->error ?: 'Bilinmeyen veritabanı hatası';
    respond(['ok'=>false,'error'=>'DM oluşturulamadı','debug'=>['message'=>$err]],500);
  }

  $cRes = @$mysqli->query("SELECT id FROM dm_conversations WHERE ".dm_conv_pair_where($mysqli,$a,$bb)." LIMIT 1");
  $c = $cRes ? $cRes->fetch_assoc() : null;
  $cid = (int)($c['id'] ?? 0);
  if($cid<=0){
    respond(['ok'=>false,'error'=>'DM konuşması bulunamadı'],500);
  }
  respond(['ok'=>true,'conversation_id'=>$cid]);
}


if($action === 'dm_mute_set'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $cid = (int)($b['conversation_id'] ?? 0);
  $muted = (int)($b['is_muted'] ?? 0) ? 1 : 0;
  if($cid <= 0) respond(['ok'=>false,'error'=>'conversation_id gerekli'], 400);
  require_dm_participant($mysqli, $cid, $uid);
  if(!db_table_exists($mysqli, 'dm_mutes')){
    @$mysqli->query("CREATE TABLE IF NOT EXISTS dm_mutes (id INT AUTO_INCREMENT PRIMARY KEY, conversation_id INT NOT NULL, user_id INT NOT NULL, is_muted TINYINT(1) NOT NULL DEFAULT 1, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY uniq_dm_mute (conversation_id, user_id), KEY idx_dmmute_user (user_id, is_muted)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  }
  $stmt = @$mysqli->prepare("INSERT INTO dm_mutes(conversation_id,user_id,is_muted) VALUES(?,?,?) ON DUPLICATE KEY UPDATE is_muted=VALUES(is_muted), updated_at=CURRENT_TIMESTAMP");
  if(!$stmt) respond(['ok'=>false,'error'=>'Sessize alma ayarı kaydedilemedi','debug'=>['message'=>$mysqli->error]], 500);
  $stmt->bind_param('iii', $cid, $uid, $muted);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Sessize alma ayarı kaydedilemedi','debug'=>['message'=>$stmt->error]], 500);
  respond(['ok'=>true,'is_muted'=>$muted]);
}

if($action === 'dm_group_candidates'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  respond(['ok'=>true, 'items'=>dm_group_candidate_users($mysqli, $uid)]);
}

if($action === 'dm_group_create'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $isMultipart = isset($_SERVER['CONTENT_TYPE']) && str_contains(strtolower($_SERVER['CONTENT_TYPE']), 'multipart/form-data');
  $b = $isMultipart ? $_POST : json_body();
  $title = trim((string)($b['title'] ?? ''));
  $description = trim((string)($b['description'] ?? ''));
  $spotifyLink = trim((string)($b['spotify_link'] ?? ''));
  $rawMemberIds = $b['member_ids'] ?? [];
  if(is_string($rawMemberIds)){
    $decoded = json_decode($rawMemberIds, true);
    $rawMemberIds = is_array($decoded) ? $decoded : [];
  }
  if(!is_array($rawMemberIds)) $rawMemberIds = [];
  $memberIds = [];
  foreach($rawMemberIds as $id){
    $id = (int)$id;
    if($id > 0 && $id !== $uid) $memberIds[$id] = $id;
  }
  $memberIds = array_values($memberIds);
  if($title === '') respond(['ok'=>false,'error'=>'Grup adı gerekli'], 400);
  if(mb_strlen($title, 'UTF-8') > 120) respond(['ok'=>false,'error'=>'Grup adı çok uzun'], 400);
  if(count($memberIds) < 2) respond(['ok'=>false,'error'=>'Grup için senden başka en az 2 kişi seçmelisin.'], 400);
  $allowed = [];
  foreach(dm_group_candidate_users($mysqli, $uid) as $u){ $allowed[(int)$u['id']] = true; }
  foreach($memberIds as $otherId){
    if(empty($allowed[$otherId])) respond(['ok'=>false,'error'=>'Sadece karşılıklı takip ettiğin kişileri ekleyebilirsin.'], 403);
  }
  $photoUrl = $isMultipart ? save_uploaded_image('group_photo', 'dm_groups') : null;
  @$mysqli->begin_transaction();
  try{
    $stmt = $mysqli->prepare("INSERT INTO dm_groups(owner_id,title,description,spotify_link,photo_url) VALUES(?,?,?,?,?)");
    if(!$stmt) throw new Exception($mysqli->error ?: 'Grup oluşturulamadı');
    $stmt->bind_param('issss', $uid, $title, $description, $spotifyLink, $photoUrl);
    if(!$stmt->execute()) throw new Exception($stmt->error ?: 'Grup oluşturulamadı');
    $groupId = (int)$stmt->insert_id;
    $memStmt = $mysqli->prepare("INSERT INTO dm_group_members(group_id,user_id,role) VALUES(?,?,?)");
    if(!$memStmt) throw new Exception($mysqli->error ?: 'Üyeler eklenemedi');
    $ownerRole = 'owner';
    $memStmt->bind_param('iis', $groupId, $uid, $ownerRole);
    if(!$memStmt->execute()) throw new Exception($memStmt->error ?: 'Kurucu eklenemedi');
    foreach($memberIds as $otherId){
      $role = 'member';
      $memStmt->bind_param('iis', $groupId, $otherId, $role);
      if(!$memStmt->execute()) throw new Exception($memStmt->error ?: 'Üye eklenemedi');
    }
    @$mysqli->commit();
  }catch(Throwable $e){
    @$mysqli->rollback();
    respond(['ok'=>false,'error'=>'Grup oluşturulamadı','debug'=>['message'=>$e->getMessage()]], 500);
  }
  respond(['ok'=>true,'group_id'=>$groupId]);
}



function dm_conversation_muted_by(mysqli $mysqli, int $conversationId, int $userId): bool {
  if($conversationId <= 0 || $userId <= 0 || !db_table_exists($mysqli, 'dm_mutes')) return false;
  $stmt = @$mysqli->prepare("SELECT is_muted FROM dm_mutes WHERE conversation_id=? AND user_id=? LIMIT 1");
  if(!$stmt) return false;
  $stmt->bind_param('ii', $conversationId, $userId);
  if(!$stmt->execute()) return false;
  $row = $stmt->get_result()->fetch_assoc();
  return $row ? ((int)($row['is_muted'] ?? 0) === 1) : false;
}

function dm_should_notify_user(mysqli $mysqli, int $conversationId, int $recipientId): bool {
  if($conversationId <= 0 || $recipientId <= 0) return false;
  if(dm_conversation_muted_by($mysqli, $conversationId, $recipientId)) return false;
  $res = @$mysqli->query("SELECT is_admin, email, admin_dm_muted_all FROM users WHERE id=".(int)$recipientId." LIMIT 1");
  $u = $res ? $res->fetch_assoc() : null;
  if($u){
    $isAdmin = ((int)($u['is_admin'] ?? 0) === 1) || (strtolower((string)($u['email'] ?? '')) === 'admin@mera.com');
    if($isAdmin && (int)($u['admin_dm_muted_all'] ?? 0) === 1) return false;
  }
  return true;
}

function dm_call_target_status(mysqli $mysqli, array $conv, int $senderId): array {
  $otherId = dm_conv_other_from_row($mysqli, $conv, $senderId);
  $res = @$mysqli->query("SELECT id,is_admin,email,full_name,admin_call_allowed FROM users WHERE id=".(int)$otherId." LIMIT 1");
  $u = $res ? $res->fetch_assoc() : null;
  if(!$u) return ['ok'=>false,'error'=>'Aranacak kullanıcı bulunamadı.'];
  $isAdmin = ((int)($u['is_admin'] ?? 0) === 1) || (strtolower((string)($u['email'] ?? '')) === 'admin@mera.com');
  $allowed = (int)($u['admin_call_allowed'] ?? 1) === 1;
  return ['ok'=>true,'user'=>$u,'is_admin'=>$isAdmin,'allowed'=>$allowed];
}

if($action === 'dm_call_signal'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $cid = (int)($b['conversation_id'] ?? 0);
  $callId = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', (string)($b['call_id'] ?? ''));
  $type = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string)($b['type'] ?? ''));
  $payload = (string)($b['payload'] ?? '');
  if($cid <= 0 || $callId === '' || $type === '') respond(['ok'=>false,'error'=>'Arama sinyali eksik.'], 400);
  $conv = require_dm_participant($mysqli, $cid, $uid);
  if($type === 'offer'){
    $targetStatus = dm_call_target_status($mysqli, $conv, $uid);
    if(empty($targetStatus['ok'])) respond(['ok'=>false,'error'=>$targetStatus['error'] ?? 'Aranacak kullanıcı bulunamadı.'], 404);
    if(!empty($targetStatus['is_admin']) && empty($targetStatus['allowed'])) respond(['ok'=>false,'error'=>'Admin şu anda aranamaz olarak ayarlı.'], 403);
  }
  if(strlen($payload) > 200000) respond(['ok'=>false,'error'=>'Arama sinyali çok büyük.'], 400);
  $stmt = $mysqli->prepare("INSERT INTO dm_call_signals(conversation_id,call_id,sender_id,type,payload) VALUES(?,?,?,?,?)");
  if(!$stmt) respond(['ok'=>false,'error'=>'Arama sinyali kaydedilemedi','debug'=>['message'=>$mysqli->error]], 500);
  $stmt->bind_param('isiss', $cid, $callId, $uid, $type, $payload);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Arama sinyali gönderilemedi','debug'=>['message'=>$stmt->error]], 500);
  respond(['ok'=>true,'id'=>(int)$stmt->insert_id]);
}

if($action === 'dm_call_fetch'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $cid = (int)($_GET['conversation_id'] ?? 0);
  $callId = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', (string)($_GET['call_id'] ?? ''));
  $after = (int)($_GET['after_id'] ?? 0);
  if($cid <= 0) respond(['ok'=>false,'error'=>'conversation_id gerekli'], 400);
  require_dm_participant($mysqli, $cid, $uid);
  $params = [$cid, $uid, $after];
  $types = 'iii';
  $where = "s.conversation_id=? AND s.sender_id<>? AND s.id>?";
  if($callId !== ''){
    $where .= " AND s.call_id=?";
    $types .= 's';
    $params[] = $callId;
  }else{
    // Eski veya zaten cevaplanmış/reddedilmiş arama tekliflerini tekrar göstermeyelim.
    // Aksi halde kullanıcı aramayı kabul/ret etse bile aynı offer sonraki poll veya sayfa yenilemede tekrar düşüyordu.
    $where .= " AND (s.type <> 'offer' OR (s.created_at >= (NOW() - INTERVAL 90 SECOND) AND NOT EXISTS (SELECT 1 FROM dm_call_signals sx WHERE sx.conversation_id=s.conversation_id AND sx.call_id=s.call_id AND sx.id>s.id AND sx.type IN ('answer','decline','hangup'))))";
  }
  $sql = "SELECT s.id, s.call_id, s.sender_id, s.type, s.payload, s.created_at FROM dm_call_signals s WHERE $where ORDER BY s.id ASC LIMIT 80";
  $stmt = $mysqli->prepare($sql);
  if(!$stmt) respond(['ok'=>false,'error'=>'Arama sinyalleri alınamadı','debug'=>['message'=>$mysqli->error]], 500);
  $stmt->bind_param($types, ...$params);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Arama sinyalleri alınamadı','debug'=>['message'=>$stmt->error]], 500);
  $res = $stmt->get_result();
  $items = [];
  while($r = $res->fetch_assoc()){
    $items[] = [
      'id'=>(int)$r['id'],
      'call_id'=>$r['call_id'],
      'sender_id'=>(int)$r['sender_id'],
      'type'=>$r['type'],
      'payload'=>$r['payload'],
      'created_at'=>$r['created_at']
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'dm_group_messages'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $groupId = (int)($_GET['group_id'] ?? 0);
  $after = (int)($_GET['after_id'] ?? 0);
  if($groupId <= 0) respond(['ok'=>false,'error'=>'group_id gerekli'], 400);
  $membership = require_dm_group_member($mysqli, $groupId, $uid);
  $stmt = $mysqli->prepare("SELECT m.id, m.sender_id, m.body, m.photo_url, m.audio_url, m.reply_to_id, m.deleted_at, m.edited_at, m.created_at, u.full_name, u.photo_url AS sender_photo_url FROM dm_group_messages m JOIN users u ON u.id=m.sender_id WHERE m.group_id=? AND m.id>? AND m.deleted_at IS NULL ORDER BY m.id ASC LIMIT 250");
  if(!$stmt) respond(['ok'=>false,'error'=>'Grup mesajları alınamadı','debug'=>['message'=>$mysqli->error]], 500);
  $stmt->bind_param('ii', $groupId, $after);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Grup mesajları alınamadı','debug'=>['message'=>$stmt->error]], 500);
  $res = $stmt->get_result();
  $items = [];
  while($m = $res->fetch_assoc()){
    $items[] = [
      'id'=>(int)$m['id'],
      'sender_id'=>(int)$m['sender_id'],
      'sender_name'=>$m['full_name'],
      'sender_photo'=>$m['sender_photo_url'],
      'body'=>$m['body'],
      'photo_url'=>upload_url_exists($m['photo_url'] ?? null),
      'audio_url'=>upload_url_exists($m['audio_url'] ?? null),
      'reply_to_id'=>$m['reply_to_id'] !== null ? (int)$m['reply_to_id'] : null,
      'deleted_at'=>$m['deleted_at'],
      'edited_at'=>$m['edited_at'],
      'created_at'=>$m['created_at']
    ];
  }
  $group = [
    'id'=>$groupId,
    'title'=>$membership['title'] ?? 'Grup',
    'description'=>$membership['description'] ?? null,
    'spotify_link'=>$membership['spotify_link'] ?? null,
    'photo_url'=>upload_url_exists($membership['group_photo_url'] ?? null),
    'member_count'=>dm_group_member_count($mysqli, $groupId),
    'members_preview'=>dm_group_members_preview($mysqli, $groupId, 5)
  ];
  respond(['ok'=>true, 'items'=>$items, 'group'=>$group]);
}

if($action === 'dm_group_send'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $isMultipart = isset($_SERVER['CONTENT_TYPE']) && str_contains(strtolower($_SERVER['CONTENT_TYPE']), 'multipart/form-data');
  if($isMultipart){
    $groupId = (int)($_POST['group_id'] ?? 0);
    $body = trim((string)($_POST['body'] ?? ''));
    $replyTo = isset($_POST['reply_to_id']) && $_POST['reply_to_id'] !== '' ? (int)$_POST['reply_to_id'] : null;
  }else{
    $b = json_body();
    $groupId = (int)($b['group_id'] ?? 0);
    $body = trim((string)($b['body'] ?? ''));
    $replyTo = isset($b['reply_to_id']) && $b['reply_to_id'] !== '' ? (int)$b['reply_to_id'] : null;
  }
  if($groupId <= 0) respond(['ok'=>false,'error'=>'group_id gerekli'], 400);
  require_dm_group_member($mysqli, $groupId, $uid);
  if($body !== '') $body = (string)censor_text((string)censor_and_log($mysqli, $body, $uid, 'dm_group_send', $groupId));
  $photoUrl = $isMultipart ? save_uploaded_image('photo', 'dm_groups') : null;
  $audioUrl = $isMultipart ? save_uploaded_audio('audio', 'dm_audio') : null;
  if($body === '' && !$photoUrl && !$audioUrl) respond(['ok'=>false,'error'=>'Mesaj veya foto gerekli'], 400);
  $stmt = $mysqli->prepare("INSERT INTO dm_group_messages(group_id,sender_id,body,photo_url,audio_url,reply_to_id) VALUES(?,?,?,?,?,?)");
  if(!$stmt) respond(['ok'=>false,'error'=>'Grup mesajı gönderilemedi','debug'=>['message'=>$mysqli->error]], 500);
  $stmt->bind_param('iisssi', $groupId, $uid, $body, $photoUrl, $audioUrl, $replyTo);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Grup mesajı gönderilemedi','debug'=>['message'=>$stmt->error]], 500);
  $newGroupMsgId = (int)$stmt->insert_id;
  $preview = $body !== '' ? mb_substr($body, 0, 120, 'UTF-8') : ($audioUrl ? 'Sesli mesaj gönderdi.' : 'Fotoğraf gönderdi.');
  $members = @$mysqli->query("SELECT user_id FROM dm_group_members WHERE group_id=$groupId AND user_id<>$uid LIMIT 200");
  while($members && ($mr=$members->fetch_assoc())) app_notify($mysqli, (int)$mr['user_id'], 'dm_group_message', 'Yeni grup mesajı', ($me['full_name'] ?? 'Bir kullanıcı').' gruba mesaj gönderdi: '.$preview, 'dm');
  respond(['ok'=>true, 'id'=>$newGroupMsgId]);
}

if($action === 'dm_group_mark_seen'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $groupId = (int)($b['group_id'] ?? 0);
  $last = (int)($b['last_seen_message_id'] ?? 0);
  if($groupId <= 0) respond(['ok'=>false,'error'=>'group_id gerekli'], 400);
  require_dm_group_member($mysqli, $groupId, $uid);
  $stmt = $mysqli->prepare("INSERT INTO dm_group_reads(group_id,user_id,last_seen_message_id) VALUES(?,?,?) ON DUPLICATE KEY UPDATE last_seen_message_id=GREATEST(last_seen_message_id, VALUES(last_seen_message_id))");
  if($stmt){ $stmt->bind_param('iii', $groupId, $uid, $last); $stmt->execute(); }
  respond(['ok'=>true]);
}

if($action === 'dm_group_typing_set'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $groupId = (int)($b['group_id'] ?? 0);
  $typing = (int)($b['is_typing'] ?? 0);
  if($groupId <= 0) respond(['ok'=>false,'error'=>'group_id gerekli'], 400);
  require_dm_group_member($mysqli, $groupId, $uid);
  if($typing === 1){
    $stmt = $mysqli->prepare("INSERT INTO dm_group_typing(group_id,user_id,expires_at) VALUES(?,?,DATE_ADD(NOW(), INTERVAL 6 SECOND)) ON DUPLICATE KEY UPDATE expires_at=DATE_ADD(NOW(), INTERVAL 6 SECOND)");
    if($stmt){ $stmt->bind_param('ii', $groupId, $uid); $stmt->execute(); }
  }else{
    $stmt = $mysqli->prepare("DELETE FROM dm_group_typing WHERE group_id=? AND user_id=?");
    if($stmt){ $stmt->bind_param('ii', $groupId, $uid); $stmt->execute(); }
  }
  respond(['ok'=>true]);
}

if($action === 'dm_group_typing_get'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $groupId = (int)($_GET['group_id'] ?? 0);
  if($groupId <= 0) respond(['ok'=>false,'error'=>'group_id gerekli'], 400);
  require_dm_group_member($mysqli, $groupId, $uid);
  respond(['ok'=>true, 'typing_users'=>dm_group_typing_users($mysqli, $groupId, $uid)]);
}

if($action === 'dm_group_edit'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $mid = (int)($b['message_id'] ?? 0);
  $body = trim((string)($b['body'] ?? ''));
  if($mid <= 0) respond(['ok'=>false,'error'=>'message_id gerekli'], 400);
  if($body === '') respond(['ok'=>false,'error'=>'Mesaj boş olamaz'], 400);
  $res = @$mysqli->query("SELECT group_id, sender_id, deleted_at FROM dm_group_messages WHERE id=$mid LIMIT 1");
  $row = $res ? $res->fetch_assoc() : null;
  if(!$row) respond(['ok'=>false,'error'=>'Mesaj yok'], 404);
  require_dm_group_member($mysqli, (int)$row['group_id'], $uid);
  if((int)$row['sender_id'] !== $uid) respond(['ok'=>false,'error'=>'Sadece kendi mesajını düzenleyebilirsin'], 403);
  if(!empty($row['deleted_at'])) respond(['ok'=>false,'error'=>'Silinmiş mesaj düzenlenemez'], 400);
  $body = (string)censor_text((string)censor_and_log($mysqli, $body, $uid, 'dm_group_edit', (int)$row['group_id']));
  $stmt = $mysqli->prepare("UPDATE dm_group_messages SET body=?, edited_at=NOW() WHERE id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'Mesaj düzenlenemedi','debug'=>['message'=>$mysqli->error]], 500);
  $stmt->bind_param('si', $body, $mid);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Mesaj düzenlenemedi','debug'=>['message'=>$stmt->error]], 500);
  respond(['ok'=>true]);
}

if($action === 'dm_group_delete'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $mid = (int)($b['message_id'] ?? 0);
  if($mid <= 0) respond(['ok'=>false,'error'=>'message_id gerekli'], 400);
  $res = @$mysqli->query("SELECT group_id, sender_id FROM dm_group_messages WHERE id=$mid LIMIT 1");
  $row = $res ? $res->fetch_assoc() : null;
  if(!$row) respond(['ok'=>false,'error'=>'Mesaj yok'], 404);
  require_dm_group_member($mysqli, (int)$row['group_id'], $uid);
  if((int)$row['sender_id'] !== $uid && (int)($me['is_admin'] ?? 0) !== 1) respond(['ok'=>false,'error'=>'Sadece kendi mesajını silebilirsin'], 403);
  @$mysqli->query("UPDATE dm_group_messages SET deleted_at=NOW(), body=NULL, photo_url=NULL WHERE id=$mid");
  respond(['ok'=>true]);
}

// --- DM helpers: seen / typing / search ---
function dm_other_user_id(mysqli $mysqli, array $conv, int $uid): int {
  return dm_conv_other_from_row($mysqli, $conv, $uid);
}

function dm_get_reads(mysqli $mysqli, int $cid, int $uid): array {
  $stmt = @$mysqli->prepare("SELECT last_seen_message_id, seen_at FROM dm_reads WHERE conversation_id=? AND user_id=? LIMIT 1");
  if(!$stmt) return ['last_seen_message_id'=>0,'seen_at'=>null];
  $stmt->bind_param("ii",$cid,$uid);
  if(!$stmt->execute()) return ['last_seen_message_id'=>0,'seen_at'=>null];
  $row = $stmt->get_result()->fetch_assoc();
  return $row ? ['last_seen_message_id'=>(int)$row['last_seen_message_id'],'seen_at'=>$row['seen_at']] : ['last_seen_message_id'=>0,'seen_at'=>null];
}

if($action === 'dm_mark_seen'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $b = json_body();
  $cid = (int)($b['conversation_id'] ?? 0);
  $last = (int)($b['last_seen_message_id'] ?? 0);
  if($cid<=0) respond(['ok'=>false,'error'=>'conversation_id gerekli'],400);
  require_dm_participant($mysqli,$cid,$uid);

  $stmt = $mysqli->prepare("INSERT INTO dm_reads(conversation_id,user_id,last_seen_message_id) VALUES(?,?,?) 
    ON DUPLICATE KEY UPDATE last_seen_message_id=GREATEST(last_seen_message_id, VALUES(last_seen_message_id))");
  $stmt->bind_param("iii",$cid,$uid,$last);
  $stmt->execute();
  respond(['ok'=>true]);
}

if($action === 'dm_read_status'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $cid = (int)($_GET['conversation_id'] ?? 0);
  if($cid<=0) respond(['ok'=>false,'error'=>'conversation_id gerekli'],400);
  $conv = require_dm_participant($mysqli,$cid,$uid);
  $otherId = dm_other_user_id($mysqli,$conv,$uid);
  $meRead = db_table_exists($mysqli, 'dm_reads') ? dm_get_reads($mysqli,$cid,$uid) : ['last_seen_message_id'=>0,'seen_at'=>null];
  $otherRead = db_table_exists($mysqli, 'dm_reads') ? dm_get_reads($mysqli,$cid,$otherId) : ['last_seen_message_id'=>0,'seen_at'=>null];
  $uRes = @$mysqli->query("SELECT ".user_select_fields($mysqli, 'u')." FROM users u WHERE u.id=$otherId LIMIT 1");
  $otherUser = $uRes ? $uRes->fetch_assoc() : ['id'=>$otherId,'full_name'=>''];
  $otherUser = safe_user(array_merge($otherUser, dm_user_presence($mysqli, $otherId))) + dm_user_presence($mysqli, $otherId);
  respond(['ok'=>true,'me'=>$meRead,'other'=>$otherRead,'other_user_id'=>$otherId,'other_user'=>$otherUser]);
}

if($action === 'dm_typing_set'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $b = json_body();
  $cid = (int)($b['conversation_id'] ?? 0);
  $typing = (int)($b['is_typing'] ?? 0);
  if($cid<=0) respond(['ok'=>false,'error'=>'conversation_id gerekli'],400);
  require_dm_participant($mysqli,$cid,$uid);

  if(!db_table_exists($mysqli, 'dm_typing')) respond(['ok'=>true]);
  if($typing===1){
    if(db_column_exists($mysqli, 'dm_typing', 'expires_at')){
      $stmt = $mysqli->prepare("INSERT INTO dm_typing(conversation_id,user_id,expires_at) VALUES(?,?,DATE_ADD(NOW(), INTERVAL 6 SECOND))
        ON DUPLICATE KEY UPDATE expires_at=DATE_ADD(NOW(), INTERVAL 6 SECOND)");
      $stmt->bind_param("ii",$cid,$uid);
      $stmt->execute();
    }else{
      $stmt = $mysqli->prepare("INSERT INTO dm_typing(conversation_id,user_id,is_typing) VALUES(?,?,1)
        ON DUPLICATE KEY UPDATE is_typing=1, updated_at=CURRENT_TIMESTAMP");
      $stmt->bind_param("ii",$cid,$uid);
      $stmt->execute();
    }
  }else{
    if(db_column_exists($mysqli, 'dm_typing', 'expires_at')){
      $stmt = $mysqli->prepare("DELETE FROM dm_typing WHERE conversation_id=? AND user_id=?");
      $stmt->bind_param("ii",$cid,$uid);
      $stmt->execute();
    }else{
      $stmt = $mysqli->prepare("UPDATE dm_typing SET is_typing=0 WHERE conversation_id=? AND user_id=?");
      $stmt->bind_param("ii",$cid,$uid);
      $stmt->execute();
    }
  }
  respond(['ok'=>true]);
}

if($action === 'dm_typing_get'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $cid = (int)($_GET['conversation_id'] ?? 0);
  if($cid<=0) respond(['ok'=>false,'error'=>'conversation_id gerekli'],400);
  $conv = require_dm_participant($mysqli,$cid,$uid);
  $otherId = dm_other_user_id($mysqli,$conv,$uid);
  $isTyping = false;
  if(db_table_exists($mysqli, 'dm_typing') && db_column_exists($mysqli, 'dm_typing', 'expires_at')){
    $rowRes = @$mysqli->query("SELECT 1 FROM dm_typing WHERE conversation_id=$cid AND user_id=$otherId AND expires_at>NOW() LIMIT 1");
    $row = $rowRes ? $rowRes->fetch_row() : null;
    $isTyping = (bool)$row;
  }
  $uRes = @$mysqli->query("SELECT ".user_select_fields($mysqli, 'u')." FROM users u WHERE u.id=$otherId LIMIT 1");
  $otherUser = $uRes ? $uRes->fetch_assoc() : ['id'=>$otherId,'full_name'=>''];
  $otherUser = safe_user(array_merge($otherUser, dm_user_presence($mysqli, $otherId))) + dm_user_presence($mysqli, $otherId);
  respond(['ok'=>true,'other_user_id'=>$otherId,'is_typing'=> $isTyping,'other_user'=>$otherUser]);
}

if($action === 'dm_search'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $cid = (int)($_GET['conversation_id'] ?? 0);
  $q = trim((string)($_GET['q'] ?? ''));
  if($cid<=0) respond(['ok'=>false,'error'=>'conversation_id gerekli'],400);
  if($q==='') respond(['ok'=>true,'items'=>[]]);
  require_dm_participant($mysqli,$cid,$uid);

  $bodyCol = dm_message_body_column($mysqli); $convCol = dm_message_conv_column($mysqli); $senderCol = dm_message_sender_column($mysqli); $createdCol = dm_message_created_column($mysqli); $deletedCol = dm_message_deleted_column($mysqli);
  $deletedWhere = $deletedCol ? (" AND m.`$deletedCol` IS NULL") : '';
  $stmt = $mysqli->prepare("SELECT m.id, m.`$senderCol` AS sender_id, m.`$bodyCol` AS body, m.`$createdCol` AS created_at FROM dm_messages m
    WHERE m.`$convCol`=?".$deletedWhere." AND m.`$bodyCol` IS NOT NULL AND m.`$bodyCol` LIKE CONCAT('%',?,'%')
    ORDER BY m.id DESC LIMIT 50");
  $stmt->bind_param("is",$cid,$q);
  $stmt->execute();
  $res=$stmt->get_result();
  $items=[];
  while($r=$res->fetch_assoc()){
    $items[]=[
      'id'=>(int)$r['id'],
      'sender_id'=>(int)$r['sender_id'],
      'body'=>$r['body'],
      'created_at'=>$r['created_at']
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

function require_dm_participant(mysqli $mysqli, int $conversationId, int $uid): array {
  $res = @$mysqli->query("SELECT * FROM dm_conversations WHERE id=$conversationId LIMIT 1");
  $row = $res ? $res->fetch_assoc() : null;
  if(!$row) respond(['ok'=>false,'error'=>'Sohbet yok'],404);
  [$dmC1,$dmC2] = dm_conv_user_columns($mysqli);
  if((int)($row[$dmC1] ?? 0)!==$uid && (int)($row[$dmC2] ?? 0)!==$uid) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  return $row;
}

function user_select_fields(mysqli $mysqli, string $alias = 'u'): string {
  $fields = [
    "$alias.id",
    "$alias.full_name",
    "$alias.school",
    "$alias.photo_url"
  ];
  if(db_column_exists($mysqli, 'users', 'cover_photo_url')) $fields[] = "$alias.cover_photo_url";
  if(db_column_exists($mysqli, 'users', 'verified_badge')) $fields[] = "$alias.verified_badge";
  if(db_column_exists($mysqli, 'users', 'admin_call_allowed')) $fields[] = "$alias.admin_call_allowed";
  return implode(',', $fields);
}

function dm_user_presence(mysqli $mysqli, int $userId): array {
  if(!db_table_exists($mysqli, 'online_users')) return ['online'=>false,'last_seen'=>null];
  $stmt = $mysqli->prepare("SELECT last_seen, (last_seen >= (NOW() - INTERVAL 2 MINUTE)) AS is_online FROM online_users WHERE user_id=? LIMIT 1");
  if(!$stmt) return ['online'=>false,'last_seen'=>null];
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if(!$row) return ['online'=>false,'last_seen'=>null];
  return ['online'=>(bool)$row['is_online'], 'last_seen'=>$row['last_seen'] ?? null];
}

function dm_group_member_row(mysqli $mysqli, int $groupId, int $uid): ?array {
  if(!db_table_exists($mysqli, 'dm_group_members')) return null;
  $stmt = @$mysqli->prepare("SELECT gm.*, g.title, g.description, g.spotify_link, g.photo_url AS group_photo_url, g.owner_id, g.created_at FROM dm_group_members gm JOIN dm_groups g ON g.id=gm.group_id WHERE gm.group_id=? AND gm.user_id=? LIMIT 1");
  if(!$stmt) return null;
  $stmt->bind_param('ii', $groupId, $uid);
  if(!$stmt->execute()) return null;
  $row = $stmt->get_result()->fetch_assoc();
  return $row ?: null;
}

function require_dm_group_member(mysqli $mysqli, int $groupId, int $uid): array {
  $row = dm_group_member_row($mysqli, $groupId, $uid);
  if(!$row) respond(['ok'=>false,'error'=>'Grup bulunamadı veya yetkin yok'], 404);
  return $row;
}

function dm_group_member_count(mysqli $mysqli, int $groupId): int {
  if(!db_table_exists($mysqli, 'dm_group_members')) return 0;
  $res = @$mysqli->query("SELECT COUNT(*) c FROM dm_group_members WHERE group_id=$groupId");
  $row = $res ? $res->fetch_assoc() : null;
  return (int)($row['c'] ?? 0);
}

function dm_group_members_preview(mysqli $mysqli, int $groupId, int $limit = 4): array {
  if(!db_table_exists($mysqli, 'dm_group_members')) return [];
  $limit = max(1, min(8, $limit));
  $sql = "SELECT u.id, u.full_name, u.photo_url FROM dm_group_members gm JOIN users u ON u.id=gm.user_id WHERE gm.group_id=$groupId ORDER BY FIELD(gm.role,'owner','admin','member'), u.full_name ASC LIMIT $limit";
  $res = @$mysqli->query($sql);
  $items = [];
  while($res && ($row = $res->fetch_assoc())){
    $safe = safe_user($row);
    $safe['photo_url'] = upload_url_exists($row['photo_url'] ?? null);
    $items[] = $safe;
  }
  return $items;
}

function dm_group_candidate_users(mysqli $mysqli, int $uid): array {
  if(!db_table_exists($mysqli, 'follows')) return [];
  $fields = user_select_fields($mysqli, 'u');
  $sql = "SELECT $fields FROM users u WHERE u.id<>$uid AND EXISTS(SELECT 1 FROM follows f WHERE f.follower_id=$uid AND f.following_id=u.id) AND EXISTS(SELECT 1 FROM follows f2 WHERE f2.follower_id=u.id AND f2.following_id=$uid) ORDER BY u.full_name ASC LIMIT 300";
  $res = @$mysqli->query($sql);
  $items = [];
  while($res && ($u = $res->fetch_assoc())){
    $u = array_merge($u, dm_user_presence($mysqli, (int)$u['id']));
    $items[] = safe_user($u) + ['online'=>(bool)($u['online'] ?? false), 'last_seen'=>$u['last_seen'] ?? null];
  }
  return $items;
}

function dm_group_typing_users(mysqli $mysqli, int $groupId, int $uid): array {
  if(!db_table_exists($mysqli, 'dm_group_typing')) return [];
  $sql = "SELECT u.id, u.full_name FROM dm_group_typing t JOIN users u ON u.id=t.user_id WHERE t.group_id=$groupId AND t.user_id<>$uid AND t.expires_at>NOW() ORDER BY u.full_name ASC LIMIT 5";
  $res = @$mysqli->query($sql);
  $items = [];
  while($res && ($row = $res->fetch_assoc())){
    $items[] = ['id'=>(int)$row['id'], 'full_name'=>$row['full_name'] ?? ''];
  }
  return $items;
}

if($action === 'dm_list'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $items = [];
  $seenUsers = [];
  $userFields = user_select_fields($mysqli, 'u');

  if(db_table_exists($mysqli, 'dm_conversations')){
    $res = @$mysqli->query("SELECT * FROM dm_conversations WHERE ".dm_conv_user_where($mysqli,$uid)." ORDER BY id DESC LIMIT 200");
    if($res){
      while($c=$res->fetch_assoc()){
        $cid = (int)$c['id'];
        $other = dm_conv_other_from_row($mysqli, $c, $uid);
        $uRes = @$mysqli->query("SELECT $userFields FROM users u WHERE u.id=$other LIMIT 1");
        $u = $uRes ? $uRes->fetch_assoc() : null;
        if(!$u) continue;
        $u = array_merge($u, dm_user_presence($mysqli, $other));
        $bodyCol = dm_message_body_column($mysqli); $convCol = dm_message_conv_column($mysqli); $senderCol = dm_message_sender_column($mysqli); $createdCol = dm_message_created_column($mysqli); $deletedCol = dm_message_deleted_column($mysqli);
        $photoSel = db_column_exists($mysqli, 'dm_messages', 'photo_url') ? 'photo_url' : 'NULL AS photo_url';
        $deletedWhere = $deletedCol ? " AND `$deletedCol` IS NULL" : '';
        $lastRes = @$mysqli->query("SELECT id,`$bodyCol` AS body,$photoSel,`$createdCol` AS created_at,`$senderCol` AS sender_id FROM dm_messages WHERE `$convCol`=$cid".$deletedWhere." ORDER BY id DESC LIMIT 1");
        $last = $lastRes ? $lastRes->fetch_assoc() : null;
        $seenId = 0;
        if(db_table_exists($mysqli, 'dm_reads')){
          $seenRes = @$mysqli->query("SELECT last_seen_message_id FROM dm_reads WHERE conversation_id=$cid AND user_id=$uid LIMIT 1");
          $seenRow = $seenRes ? $seenRes->fetch_assoc() : null;
          $seenId = (int)($seenRow['last_seen_message_id'] ?? 0);
        }
        $convCol = dm_message_conv_column($mysqli); $senderCol = dm_message_sender_column($mysqli); $deletedCol = dm_message_deleted_column($mysqli);
        $deletedWhere = $deletedCol ? " AND `$deletedCol` IS NULL" : '';
        $unreadRes = @$mysqli->query("SELECT COUNT(*) AS c FROM dm_messages WHERE `$convCol`=$cid AND `$senderCol`<>$uid".$deletedWhere." AND id>$seenId");
        $unreadRow = $unreadRes ? $unreadRes->fetch_assoc() : null;
        $unreadCount = (int)($unreadRow['c'] ?? 0);
        $sortAt = $last['created_at'] ?? $c['created_at'];
        $items[] = [
          'thread_kind'=>'direct',
          'conversation_id'=>$cid,
          'with'=>safe_user($u) + ['online'=>(bool)($u['online'] ?? false),'last_seen'=>$u['last_seen'] ?? null],
          'last_message'=>$last ? (((string)($last['body'] ?? '')) !== '' ? $last['body'] : (($last['photo_url'] ?? null)?'[foto]':'')) : null,
          'last_at'=>$sortAt,
          'unread'=> $unreadCount > 0,
          'unread_count'=>$unreadCount,
          'is_muted'=>dm_conversation_muted_by($mysqli, $cid, $uid)
        ];
        $seenUsers[$other] = true;
      }
    }
  }

  if(db_table_exists($mysqli, 'follows')){
    $sql = "SELECT $userFields,
      (
        SELECT GREATEST(COALESCE(MAX(f.created_at),'1970-01-01 00:00:00'), COALESCE(MAX(f2.created_at),'1970-01-01 00:00:00'))
        FROM follows f
        JOIN follows f2 ON f2.follower_id=u.id AND f2.following_id=$uid
        WHERE f.follower_id=$uid AND f.following_id=u.id
      ) AS sort_at
      FROM users u
      WHERE u.id<>$uid
        AND EXISTS(SELECT 1 FROM follows f WHERE f.follower_id=$uid AND f.following_id=u.id)
        AND EXISTS(SELECT 1 FROM follows f2 WHERE f2.follower_id=u.id AND f2.following_id=$uid)
      ORDER BY sort_at DESC, u.full_name ASC
      LIMIT 200";
    $res2 = @$mysqli->query($sql);
    while($res2 && ($u=$res2->fetch_assoc())){
      $other = (int)$u['id'];
      if(isset($seenUsers[$other])) continue;
      $a = min($uid,$other); $bb = max($uid,$other);
      $conv = null;
      if(db_table_exists($mysqli, 'dm_conversations')){
        $convRes = @$mysqli->query("SELECT id, created_at FROM dm_conversations WHERE ".dm_conv_pair_where($mysqli,$a,$bb)." LIMIT 1");
        $conv = $convRes ? $convRes->fetch_assoc() : null;
      }
      $u = array_merge($u, dm_user_presence($mysqli, $other));
      $items[] = [
        'thread_kind'=>'direct',
        'conversation_id'=>$conv ? (int)$conv['id'] : 0,
        'with'=>safe_user($u) + ['online'=>(bool)($u['online'] ?? false),'last_seen'=>$u['last_seen'] ?? null],
        'last_message'=>null,
        'last_at'=>$u['sort_at'] ?? null,
        'unread'=>false,
        'unread_count'=>0,
        'is_muted'=>($conv ? dm_conversation_muted_by($mysqli, (int)$conv['id'], $uid) : false)
      ];
    }
  }

  if(db_table_exists($mysqli, 'dm_groups') && db_table_exists($mysqli, 'dm_group_members')){
    $gres = @$mysqli->query("SELECT g.*, gm.role FROM dm_group_members gm JOIN dm_groups g ON g.id=gm.group_id WHERE gm.user_id=$uid ORDER BY g.id DESC LIMIT 200");
    while($gres && ($g = $gres->fetch_assoc())){
      $gid = (int)$g['id'];
      $lastRes = @$mysqli->query("SELECT id, body, photo_url, created_at, sender_id FROM dm_group_messages WHERE group_id=$gid AND deleted_at IS NULL ORDER BY id DESC LIMIT 1");
      $last = $lastRes ? $lastRes->fetch_assoc() : null;
      $seenRes = @$mysqli->query("SELECT last_seen_message_id FROM dm_group_reads WHERE group_id=$gid AND user_id=$uid LIMIT 1");
      $seenRow = $seenRes ? $seenRes->fetch_assoc() : null;
      $seenId = (int)($seenRow['last_seen_message_id'] ?? 0);
      $unreadRes = @$mysqli->query("SELECT COUNT(*) c FROM dm_group_messages WHERE group_id=$gid AND sender_id<>$uid AND deleted_at IS NULL AND id>$seenId");
      $unreadRow = $unreadRes ? $unreadRes->fetch_assoc() : null;
      $unreadCount = (int)($unreadRow['c'] ?? 0);
      $preview = dm_group_members_preview($mysqli, $gid, 4);
      $items[] = [
        'thread_kind'=>'group',
        'conversation_id'=>$gid,
        'group_id'=>$gid,
        'title'=>$g['title'],
        'with'=>['id'=>$gid, 'full_name'=>$g['title'], 'photo_url'=>upload_url_exists($g['photo_url'] ?? null)],
        'group'=>[
          'id'=>$gid,
          'title'=>$g['title'],
          'description'=>$g['description'] ?? null,
          'spotify_link'=>$g['spotify_link'] ?? null,
          'photo_url'=>upload_url_exists($g['photo_url'] ?? null),
          'member_count'=>dm_group_member_count($mysqli, $gid),
          'members_preview'=>$preview,
          'role'=>$g['role'] ?? 'member'
        ],
        'last_message'=>$last ? (((string)($last['body'] ?? '')) !== '' ? $last['body'] : (($last['photo_url'] ?? null)?'[foto]':'')) : null,
        'last_at'=>$last['created_at'] ?? $g['created_at'],
        'unread'=>$unreadCount > 0,
        'unread_count'=>$unreadCount,
        'is_muted'=>false
      ];
    }
  }

  usort($items, function($a,$b){
    return strcmp((string)($b['last_at'] ?? ''), (string)($a['last_at'] ?? ''));
  });
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'dm_messages'){
  $me = require_auth($mysqli);
  $cid = (int)($_GET['conversation_id'] ?? 0);
  $after = (int)($_GET['after_id'] ?? 0);
  if($cid<=0) respond(['ok'=>false,'error'=>'conversation_id gerekli'],400);
  $uid=(int)$me['id'];
  require_dm_participant($mysqli,$cid,$uid);

  $bodyCols = dm_existing_message_columns($mysqli, 'body');
  $convCols = dm_existing_message_columns($mysqli, 'conv');
  $senderCols = dm_existing_message_columns($mysqli, 'sender');
  $createdCols = dm_existing_message_columns($mysqli, 'created');
  $deletedCols = dm_existing_message_columns($mysqli, 'deleted');
  $photoCols = dm_existing_message_columns($mysqli, 'photo');
  $audioCols = dm_existing_message_columns($mysqli, 'audio');
  $replyCols = dm_existing_message_columns($mysqli, 'reply');
  $editedCols = dm_existing_message_columns($mysqli, 'edited');

  $senderExpr = dm_sql_coalesce('m', $senderCols, '0');
  $bodyExpr = dm_sql_coalesce('m', $bodyCols, 'NULL');
  $photoExpr = dm_sql_coalesce('m', $photoCols, 'NULL');
  $audioExpr = dm_sql_coalesce('m', $audioCols, 'NULL');
  $replyExpr = dm_sql_coalesce('m', $replyCols, 'NULL');
  $createdExpr = dm_sql_coalesce('m', $createdCols, 'm.id');
  $deletedExpr = dm_sql_coalesce('m', $deletedCols, 'NULL');

  $select = [
    'm.id',
    $senderExpr . ' AS sender_id',
    $bodyExpr . ' AS body',
    $photoExpr . ' AS message_photo_url',
    $audioExpr . ' AS message_audio_url',
    $replyExpr . ' AS reply_to_id',
    $deletedExpr . ' AS deleted_at',
    dm_sql_coalesce('m', $editedCols, 'NULL') . ' AS edited_at',
    $createdExpr . ' AS created_at',
    'u.full_name',
    'u.photo_url AS sender_photo_url'
  ];

  $deletedWhere = $deletedCols ? (" AND " . dm_sql_coalesce('m', $deletedCols, 'NULL') . " IS NULL") : '';
  $convWhere = dm_sql_eq_any('m', $convCols);
  $sql = "SELECT " . implode(',', $select) . " FROM dm_messages m JOIN users u ON u.id=" . $senderExpr . " WHERE $convWhere AND m.id>?".$deletedWhere." ORDER BY m.id ASC LIMIT 200";
  $stmt = $mysqli->prepare($sql);
  if(!$stmt) respond(['ok'=>false,'error'=>'DM mesajları alınamadı','debug'=>['message'=>$mysqli->error]],500);
  $types = str_repeat('i', count($convCols)) . 'i';
  $params = array_fill(0, count($convCols), $cid);
  $params[] = $after;
  $stmt->bind_param($types, ...$params);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'DM mesajları alınamadı','debug'=>['message'=>$stmt->error]],500);
  $res = $stmt->get_result();
  $reactMsgCol = db_table_exists($mysqli, 'dm_reactions') ? dm_reaction_message_column($mysqli) : 'message_id';
  $reactUserCol = db_table_exists($mysqli, 'dm_reactions') ? dm_reaction_user_column($mysqli) : 'user_id';
  $reactEmojiCol = db_table_exists($mysqli, 'dm_reactions') ? dm_reaction_emoji_column($mysqli) : 'emoji';
  $items=[];
  while($m=$res->fetch_assoc()){
    $mid=(int)$m['id'];
    $reactions=[];
    $my=[];
    if(db_table_exists($mysqli, 'dm_reactions')){
      $rres = @$mysqli->query("SELECT `$reactEmojiCol` AS emoji, COUNT(*) c FROM dm_reactions WHERE `$reactMsgCol`=$mid GROUP BY `$reactEmojiCol`");
      while($rres && ($rr=$rres->fetch_assoc())) $reactions[$rr['emoji']] = (int)$rr['c'];
      $myRes = @$mysqli->query("SELECT `$reactEmojiCol` AS emoji FROM dm_reactions WHERE `$reactMsgCol`=$mid AND `$reactUserCol`=$uid");
      while($myRes && ($x=$myRes->fetch_assoc())) $my[]=$x['emoji'];
    }

    $items[]=[
      'id'=>$mid,
      'sender_id'=>(int)$m['sender_id'],
      'sender_name'=>$m['full_name'],
      'sender_photo'=>$m['sender_photo_url'],
      'body'=>$m['body'],
      'photo_url'=>upload_url_exists($m['message_photo_url']),
      'audio_url'=>upload_url_exists($m['message_audio_url'] ?? null),
      'reply_to_id'=>$m['reply_to_id'] !== null ? (int)$m['reply_to_id'] : null,
      'deleted_at'=>$m['deleted_at'],
      'created_at'=>$m['created_at'],
      'reactions'=>$reactions,
      'my_reactions'=>$my
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'dm_send'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];

  $cid = 0; $body = ''; $replyTo = null;
  $isMultipart = isset($_SERVER['CONTENT_TYPE']) && str_contains(strtolower($_SERVER['CONTENT_TYPE']),'multipart/form-data');
  if($isMultipart){
    $cid = (int)($_POST['conversation_id'] ?? 0);
    $body = trim((string)($_POST['body'] ?? ''));
    $rt = $_POST['reply_to_id'] ?? null;
    if($rt !== null && $rt !== '') $replyTo = (int)$rt;
  }else{
    $b = json_body();
    $cid = (int)($b['conversation_id'] ?? 0);
    $body = trim((string)($b['body'] ?? ''));
    if($body!=='') $body = (string)censor_and_log($mysqli, $body, (int)$me['id'], 'dm_send', $cid);
    $rt = $b['reply_to_id'] ?? null;
    if($rt !== null && $rt !== '') $replyTo = (int)$rt;
  }
  if($cid<=0) respond(['ok'=>false,'error'=>'conversation_id gerekli'],400);
  require_dm_participant($mysqli,$cid,$uid);
  [$dmCheckC1,$dmCheckC2] = dm_conv_user_columns($mysqli);
  $convCheckRes = @$mysqli->query("SELECT `$dmCheckC1` AS u1, `$dmCheckC2` AS u2 FROM dm_conversations WHERE id=$cid LIMIT 1");
  $convCheck = $convCheckRes ? $convCheckRes->fetch_assoc() : null;
  if($convCheck){
    $otherInDm = ((int)$convCheck['u1'] === $uid) ? (int)$convCheck['u2'] : (int)$convCheck['u1'];
    $otherAdminRow = @$mysqli->query("SELECT is_admin FROM users WHERE id=$otherInDm LIMIT 1")->fetch_assoc();
    $adminBypassSend = ((int)($me['is_admin'] ?? 0) === 1) || ((int)($otherAdminRow['is_admin'] ?? 0) === 1);
    $blockRes = @$mysqli->query("SELECT 1 FROM user_blocks WHERE (blocker_id=$uid AND blocked_id=$otherInDm) OR (blocker_id=$otherInDm AND blocked_id=$uid) LIMIT 1");
    if(!$adminBypassSend && $blockRes && $blockRes->fetch_row()) respond(['ok'=>false,'error'=>'Bu kullanıcıyla mesajlaşma engel nedeniyle kapalı.'],403);
  }

  if($body!=='') $body = (string)censor_and_log($mysqli, $body, (int)$me['id'], 'dm_send', $cid);
  $body = (string)censor_text($body);
  $photoUrl = save_uploaded_image('photo','dm');
  $audioUrl = save_uploaded_audio('audio','dm_audio');
  if($body==='' && !$photoUrl && !$audioUrl) respond(['ok'=>false,'error'=>'Mesaj veya foto gerekli'],400);

  $convCols = dm_existing_message_columns($mysqli, 'conv');
  $senderCols = dm_existing_message_columns($mysqli, 'sender');
  $bodyCols = dm_existing_message_columns($mysqli, 'body');
  $photoCols = dm_existing_message_columns($mysqli, 'photo');
  $audioCols = dm_existing_message_columns($mysqli, 'audio');
  $replyCols = dm_existing_message_columns($mysqli, 'reply');
  $msgCols = [];
  $msgVals = [];
  $msgTypes = '';
  $msgParams = [];
  foreach($convCols as $col){ $msgCols[]="`$col`"; $msgVals[]='?'; $msgTypes.='i'; $msgParams[]=$cid; }
  foreach($senderCols as $col){ $msgCols[]="`$col`"; $msgVals[]='?'; $msgTypes.='i'; $msgParams[]=$uid; }
  foreach($bodyCols as $col){ $msgCols[]="`$col`"; $msgVals[]='?'; $msgTypes.='s'; $msgParams[]=$body; }
  foreach($photoCols as $col){ $msgCols[]="`$col`"; $msgVals[]='?'; $msgTypes.='s'; $msgParams[]=$photoUrl; }
  foreach($audioCols as $col){ $msgCols[]="`$col`"; $msgVals[]='?'; $msgTypes.='s'; $msgParams[]=$audioUrl; }
  foreach($replyCols as $col){ $msgCols[]="`$col`"; $msgVals[]='?'; $msgTypes.='i'; $msgParams[]=$replyTo; }
  $sql = "INSERT INTO dm_messages(".implode(',', $msgCols).") VALUES(".implode(',', $msgVals).")";
  $stmt = $mysqli->prepare($sql);
  if(!$stmt) respond(['ok'=>false,'error'=>'DM gönderilemedi','debug'=>['message'=>$mysqli->error]],500);
  $stmt->bind_param($msgTypes, ...$msgParams);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'DM gönderilemedi','debug'=>['message'=>$stmt->error]],500);
  $newId = (int)$stmt->insert_id;

  $item = null;
  if($newId > 0){
    $senderExpr2 = dm_sql_coalesce('m', dm_existing_message_columns($mysqli, 'sender'), '0');
    $bodyExpr2 = dm_sql_coalesce('m', dm_existing_message_columns($mysqli, 'body'), 'NULL');
    $photoExpr2 = dm_sql_coalesce('m', dm_existing_message_columns($mysqli, 'photo'), 'NULL');
    $audioExpr2 = dm_sql_coalesce('m', dm_existing_message_columns($mysqli, 'audio'), 'NULL');
    $replyExpr2 = dm_sql_coalesce('m', dm_existing_message_columns($mysqli, 'reply'), 'NULL');
    $createdExpr2 = dm_sql_coalesce('m', dm_existing_message_columns($mysqli, 'created'), 'm.id');
    $deletedExpr2 = dm_sql_coalesce('m', dm_existing_message_columns($mysqli, 'deleted'), 'NULL');
    $select2 = [
      'm.id',
      $senderExpr2 . ' AS sender_id',
      $bodyExpr2 . ' AS body',
      $photoExpr2 . ' AS message_photo_url',
      $audioExpr2 . ' AS message_audio_url',
      $replyExpr2 . ' AS reply_to_id',
      $deletedExpr2 . ' AS deleted_at',
      $createdExpr2 . ' AS created_at',
      'u.full_name',
      'u.photo_url AS sender_photo_url'
    ];
    $sql2 = "SELECT " . implode(',', $select2) . " FROM dm_messages m JOIN users u ON u.id=" . $senderExpr2 . " WHERE m.id=? LIMIT 1";
    $stmt2 = @$mysqli->prepare($sql2);
    if($stmt2){
      $stmt2->bind_param('i', $newId);
      if($stmt2->execute()){
        $m = $stmt2->get_result()->fetch_assoc();
        if($m){
          $item = [
            'id'=>(int)$m['id'],
            'sender_id'=>(int)$m['sender_id'],
            'sender_name'=>$m['full_name'],
            'sender_photo'=>$m['sender_photo_url'],
            'body'=>$m['body'],
            'photo_url'=>upload_url_exists($m['message_photo_url']),
            'audio_url'=>upload_url_exists($m['message_audio_url'] ?? null),
            'reply_to_id'=>$m['reply_to_id'] !== null ? (int)$m['reply_to_id'] : null,
            'deleted_at'=>$m['deleted_at'],
            'created_at'=>$m['created_at'],
            'reactions'=>new stdClass(),
            'my_reactions'=>[]
          ];
        }
      }
    }
  }
  if(isset($otherInDm) && (int)$otherInDm > 0 && dm_should_notify_user($mysqli, $cid, (int)$otherInDm)){
    $preview = $body !== '' ? mb_substr($body, 0, 120, 'UTF-8') : ($audioUrl ? 'Sesli mesaj gönderdi.' : 'Fotoğraf gönderdi.');
    app_notify($mysqli, (int)$otherInDm, 'dm_message', 'Yeni mesaj', ($me['full_name'] ?? 'Bir kullanıcı').' sana mesaj gönderdi: '.$preview, 'dm');
  }
  respond(['ok'=>true,'id'=>$newId,'item'=>$item]);
}

if($action === 'dm_react'){
  $me = require_auth($mysqli);
  $b = json_body();
  $mid = (int)($b['message_id'] ?? 0);
  $emoji = trim((string)($b['emoji'] ?? ''));
  if($mid<=0 || $emoji==='') respond(['ok'=>false,'error'=>'Eksik'],400);
  $uid=(int)$me['id'];
  $convCol = dm_message_conv_column($mysqli);
  $msgStmt = @$mysqli->prepare("SELECT `$convCol` AS conversation_id FROM dm_messages WHERE id=? LIMIT 1");
  if(!$msgStmt) respond(['ok'=>false,'error'=>'Tepki eklenemedi','debug'=>['message'=>$mysqli->error]],500);
  $msgStmt->bind_param("i", $mid);
  if(!$msgStmt->execute()) respond(['ok'=>false,'error'=>'Tepki eklenemedi','debug'=>['message'=>$msgStmt->error]],500);
  $m = $msgStmt->get_result()->fetch_assoc();
  if(!$m) respond(['ok'=>false,'error'=>'Mesaj yok'],404);
  require_dm_participant($mysqli,(int)$m['conversation_id'],$uid);

  ensure_dm_reactions_schema($mysqli);
  if(!db_table_exists($mysqli, 'dm_reactions')) respond(['ok'=>false,'error'=>'Tepki tablosu oluşturulamadı'],500);

  $reactMsgCol = dm_reaction_message_column($mysqli);
  $reactUserCol = dm_reaction_user_column($mysqli);
  $reactEmojiCol = dm_reaction_emoji_column($mysqli);
  $stmt = @$mysqli->prepare("SELECT id FROM dm_reactions WHERE `$reactMsgCol`=? AND `$reactUserCol`=? AND `$reactEmojiCol`=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'Tepki eklenemedi','debug'=>['message'=>$mysqli->error]],500);
  $stmt->bind_param("iis",$mid,$uid,$emoji);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Tepki eklenemedi','debug'=>['message'=>$stmt->error]],500);
  $row = $stmt->get_result()->fetch_assoc();
  if($row){
    $rid=(int)$row['id'];
    @$mysqli->query("DELETE FROM dm_reactions WHERE id=$rid");
    respond(['ok'=>true,'status'=>'removed']);
  }else{
    $stmt2 = @$mysqli->prepare("INSERT INTO dm_reactions(`$reactMsgCol`,`$reactUserCol`,`$reactEmojiCol`) VALUES(?,?,?)");
    if(!$stmt2) respond(['ok'=>false,'error'=>'Tepki eklenemedi','debug'=>['message'=>$mysqli->error]],500);
    $stmt2->bind_param("iis",$mid,$uid,$emoji);
    if(!$stmt2->execute()) respond(['ok'=>false,'error'=>'Tepki eklenemedi','debug'=>['message'=>$stmt2->error]],500);
    respond(['ok'=>true,'status'=>'added']);
  }
}

if($action === 'dm_edit'){
  $me = require_auth($mysqli);
  $b = json_body();
  $mid = (int)($b['message_id'] ?? 0);
  $body = trim((string)($b['body'] ?? ''));
  if($mid<=0) respond(['ok'=>false,'error'=>'message_id gerekli'],400);
  if($body==='') respond(['ok'=>false,'error'=>'Mesaj boş olamaz'],400);
  $uid=(int)$me['id'];
  $convCol = dm_message_conv_column($mysqli); $senderCol = dm_message_sender_column($mysqli); $bodyCol = dm_message_body_column($mysqli); $deletedCol = dm_message_deleted_column($mysqli);
  $mres = @$mysqli->query("SELECT `$convCol` AS conversation_id,`$senderCol` AS sender_id" . ($deletedCol ? ",`$deletedCol` AS deleted_at" : ",NULL AS deleted_at") . " FROM dm_messages WHERE id=$mid LIMIT 1");
  $m = $mres ? $mres->fetch_assoc() : null;
  if(!$m) respond(['ok'=>false,'error'=>'Mesaj yok'],404);
  require_dm_participant($mysqli,(int)$m['conversation_id'],$uid);
  if((int)$m['sender_id']!==$uid) respond(['ok'=>false,'error'=>'Sadece kendi mesajını düzenleyebilirsin'],403);
  if(!empty($m['deleted_at'])) respond(['ok'=>false,'error'=>'Silinmiş mesaj düzenlenemez'],400);

  $body = (string)censor_and_log($mysqli, $body, (int)$me['id'], 'dm_edit', (int)$m['conversation_id']);
  $body = (string)censor_text($body);
  $sets = ["`$bodyCol`=?"];
  if(in_array('edited_at', dm_columns($mysqli, 'dm_messages'), true)) $sets[] = "`edited_at`=NOW()";
  else {
    foreach(dm_existing_message_columns($mysqli, 'edited') as $ec){ if($ec !== 'edited_at') $sets[] = "`$ec`=NOW()"; }
  }
  $stmt = @$mysqli->prepare("UPDATE dm_messages SET ".implode(',', $sets)." WHERE id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'Mesaj düzenlenemedi','debug'=>['message'=>$mysqli->error]],500);
  $stmt->bind_param('si', $body, $mid);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Mesaj düzenlenemedi','debug'=>['message'=>$stmt->error]],500);
  respond(['ok'=>true]);
}

if($action === 'dm_delete'){
  $me = require_auth($mysqli);
  $b = json_body();
  $mid = (int)($b['message_id'] ?? 0);
  if($mid<=0) respond(['ok'=>false,'error'=>'message_id gerekli'],400);
  $uid=(int)$me['id'];
  $convCol = dm_message_conv_column($mysqli); $senderCol = dm_message_sender_column($mysqli);
  $m = $mysqli->query("SELECT `$convCol` AS conversation_id,`$senderCol` AS sender_id FROM dm_messages WHERE id=$mid LIMIT 1")->fetch_assoc();
  if(!$m) respond(['ok'=>false,'error'=>'Mesaj yok'],404);
  require_dm_participant($mysqli,(int)$m['conversation_id'],$uid);
  $isAdmin = ((int)$me['is_admin']===1);
  if((int)$m['sender_id']!==$uid && !$isAdmin) respond(['ok'=>false,'error'=>'Sadece kendi mesajını silebilirsin'],403);

  $bodyCol = dm_message_body_column($mysqli); $deletedCol = dm_message_deleted_column($mysqli);
  $set = [];
  if($deletedCol) $set[] = "`$deletedCol`=NOW()";
  $set[] = "`$bodyCol`=NULL";
  if(db_column_exists($mysqli, 'dm_messages', 'photo_url')) $set[] = "photo_url=NULL";
  $mysqli->query("UPDATE dm_messages SET ".implode(',', $set)." WHERE id=$mid");
  respond(['ok'=>true]);
}

// --- Dedikodu ---
function can_view_gossip(array $viewer, array $post): bool {
  if(($post['visibility'] ?? 'global') === 'global') return true;
  $vs = trim((string)($viewer['school'] ?? ''));
  $ps = trim((string)($post['school'] ?? ''));
  return $vs !== '' && $ps !== '' && mb_strtolower($vs,'UTF-8') === mb_strtolower($ps,'UTF-8');
}

if($action === 'gossip_post'){
  $me = require_auth($mysqli);
  if(!empty($me['mute_until']) && strtotime((string)$me['mute_until']) > time()) respond(['ok'=>false,'error'=>'Hesabın geçici olarak susturuldu.'],403);
  $b = json_body();
  $content = trim((string)($b['content'] ?? ''));
  $content = (string)censor_and_log($mysqli, $content, (int)$me['id'], 'gossip_post', null);
  $vis = (string)($b['visibility'] ?? 'global');
  $category = (string)($b['category'] ?? 'general');
  if(!in_array($category, ['general','teacher','school','confession','memory','question'], true)) $category='general';
  if($content==='') respond(['ok'=>false,'error'=>'İçerik yaz.'],400);
  if($vis!=='global' && $vis!=='school') $vis='global';

  $uid=(int)$me['id'];
  $school = $me['school'] ?? null;
  if($vis==='school' && trim((string)$school)==='') respond(['ok'=>false,'error'=>'Okul bilgin yok; önce profilini güncelle.'],400);

  $stmt = $mysqli->prepare("INSERT INTO gossip_posts(user_id,school,visibility,content,category) VALUES(?,?,?,?,?)");
  $stmt->bind_param("issss",$uid,$school,$vis,$content,$category);
  $stmt->execute();
  respond(['ok'=>true,'id'=>(int)$stmt->insert_id]);
}

if($action === 'gossip_list'){
  $me = require_auth($mysqli);
  $mode = (string)($_GET['mode'] ?? 'all');
  $sort = (string)($_GET['sort'] ?? 'new');
  $category = (string)($_GET['category'] ?? 'all'); // all|global|school
  $uid=(int)$me['id'];

  $whereCat = ($category !== 'all' && in_array($category,['general','teacher','school','confession','memory','question'],true)) ? " WHERE p.category='".$mysqli->real_escape_string($category)."'" : "";
  $order = $sort==='popular' ? "ORDER BY ((SELECT COUNT(*) FROM gossip_reactions r WHERE r.target_type='post' AND r.target_id=p.id)*2 + (SELECT COUNT(*) FROM gossip_comments c WHERE c.post_id=p.id)) DESC, p.id DESC" : "ORDER BY p.created_at DESC";
  $sql = "SELECT p.*, u.full_name, u.photo_url FROM gossip_posts p JOIN users u ON u.id=p.user_id $whereCat $order LIMIT 100";
  $res = $mysqli->query($sql);
  $items=[];
  while($p=$res->fetch_assoc()){
    if($mode==='global' && $p['visibility']!=='global') continue;
    if($mode==='school' && $p['visibility']!=='school') continue;
    if(!can_view_gossip($me,$p)) continue;

    $pid=(int)$p['id'];
    $rres = $mysqli->query("SELECT emoji, COUNT(*) c FROM gossip_reactions WHERE target_type='post' AND target_id=$pid GROUP BY emoji");
    $reactions=[];
    while($rr=$rres->fetch_assoc()) $reactions[$rr['emoji']] = (int)$rr['c'];
    $myRes = $mysqli->query("SELECT emoji FROM gossip_reactions WHERE target_type='post' AND target_id=$pid AND user_id=$uid");
    $my=[];
    while($x=$myRes->fetch_assoc()) $my[]=$x['emoji'];

    $cc = (int)($mysqli->query("SELECT COUNT(*) c FROM gossip_comments WHERE post_id=$pid")->fetch_assoc()['c'] ?? 0);

    $items[]=[
      'id'=>$pid,
      'user'=>[
        'id'=>(int)$p['user_id'],
        'full_name'=>$p['full_name'],
        'photo_url'=>$p['photo_url']
      ],
      'visibility'=>$p['visibility'],
      'school'=>$p['school'],
      'content'=>$p['content'],
      'category'=>$p['category'] ?? 'general',
      'created_at'=>$p['created_at'],
      'comment_count'=>$cc,
      'reactions'=>$reactions,
      'my_reactions'=>$my
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'gossip_comment'){
  $me = require_auth($mysqli);
  if(!empty($me['mute_until']) && strtotime((string)$me['mute_until']) > time()) respond(['ok'=>false,'error'=>'Hesabın geçici olarak susturuldu.'],403);
  $b = json_body();
  $postId = (int)($b['post_id'] ?? 0);
  $content = trim((string)($b['content'] ?? ''));
  $content = (string)censor_and_log($mysqli, $content, (int)$me['id'], 'gossip_post', null);
  if($postId<=0 || $content==='') respond(['ok'=>false,'error'=>'Eksik'],400);
  $content = (string)censor_text($content);

  $p = $mysqli->query("SELECT * FROM gossip_posts WHERE id=$postId LIMIT 1")->fetch_assoc();
  if(!$p) respond(['ok'=>false,'error'=>'Gönderi yok'],404);
  if(!can_view_gossip($me,$p)) respond(['ok'=>false,'error'=>'Yetkisiz'],403);

  $uid=(int)$me['id'];
  $stmt = $mysqli->prepare("INSERT INTO gossip_comments(post_id,user_id,content) VALUES(?,?,?)");
  $stmt->bind_param("iis",$postId,$uid,$content);
  $stmt->execute();
  respond(['ok'=>true,'id'=>(int)$stmt->insert_id]);
}

if($action === 'gossip_comments'){
  $me = require_auth($mysqli);
  $postId = (int)($_GET['post_id'] ?? 0);
  if($postId<=0) respond(['ok'=>false,'error'=>'post_id gerekli'],400);

  $p = $mysqli->query("SELECT * FROM gossip_posts WHERE id=$postId LIMIT 1")->fetch_assoc();
  if(!$p) respond(['ok'=>false,'error'=>'Gönderi yok'],404);
  if(!can_view_gossip($me,$p)) respond(['ok'=>false,'error'=>'Yetkisiz'],403);

  $uid=(int)$me['id'];
  $res = $mysqli->query("SELECT c.*, u.full_name, u.photo_url FROM gossip_comments c JOIN users u ON u.id=c.user_id WHERE c.post_id=$postId ORDER BY c.created_at ASC LIMIT 200");
  $items=[];
  while($c=$res->fetch_assoc()){
    $cid=(int)$c['id'];
    $rres = $mysqli->query("SELECT emoji, COUNT(*) c FROM gossip_reactions WHERE target_type='comment' AND target_id=$cid GROUP BY emoji");
    $reactions=[];
    while($rr=$rres->fetch_assoc()) $reactions[$rr['emoji']] = (int)$rr['c'];
    $myRes = $mysqli->query("SELECT emoji FROM gossip_reactions WHERE target_type='comment' AND target_id=$cid AND user_id=$uid");
    $my=[];
    while($x=$myRes->fetch_assoc()) $my[]=$x['emoji'];

    $items[]=[
      'id'=>$cid,
      'user'=>['id'=>(int)$c['user_id'],'full_name'=>$c['full_name'],'photo_url'=>$c['photo_url']],
      'content'=>$c['content'],
      'created_at'=>$c['created_at'],
      'reactions'=>$reactions,
      'my_reactions'=>$my
    ];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'gossip_react'){
  $me = require_auth($mysqli);
  $b = json_body();
  $type = (string)($b['target_type'] ?? '');
  $id = (int)($b['target_id'] ?? 0);
  $emoji = trim((string)($b['emoji'] ?? ''));
  if(($type!=='post' && $type!=='comment') || $id<=0 || $emoji==='') respond(['ok'=>false,'error'=>'Eksik'],400);

  // visibility check by resolving to post
  if($type==='post'){
    $p = $mysqli->query("SELECT * FROM gossip_posts WHERE id=$id LIMIT 1")->fetch_assoc();
    if(!$p) respond(['ok'=>false,'error'=>'Yok'],404);
    if(!can_view_gossip($me,$p)) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  }else{
    $c = $mysqli->query("SELECT c.post_id,p.visibility,p.school FROM gossip_comments c JOIN gossip_posts p ON p.id=c.post_id WHERE c.id=$id LIMIT 1")->fetch_assoc();
    if(!$c) respond(['ok'=>false,'error'=>'Yok'],404);
    $p=['visibility'=>$c['visibility'],'school'=>$c['school']];
    if(!can_view_gossip($me,$p)) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  }

  $uid=(int)$me['id'];
  $stmt = $mysqli->prepare("SELECT id FROM gossip_reactions WHERE target_type=? AND target_id=? AND user_id=? AND emoji=? LIMIT 1");
  $stmt->bind_param("siis",$type,$id,$uid,$emoji);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if($row){
    $rid=(int)$row['id'];
    $mysqli->query("DELETE FROM gossip_reactions WHERE id=$rid");
    respond(['ok'=>true,'status'=>'removed']);
  }else{
    $stmt2 = $mysqli->prepare("INSERT INTO gossip_reactions(target_type,target_id,user_id,emoji) VALUES(?,?,?,?)");
    $stmt2->bind_param("siis",$type,$id,$uid,$emoji);
    $stmt2->execute();
    respond(['ok'=>true,'status'=>'added']);
  }
}



if($action === 'report_create'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $b=json_body();
  $target_type=trim((string)($b['target_type'] ?? 'user'));
  $target_id=(int)($b['target_id'] ?? 0);
  $reported_user_id = (int)($b['reported_user_id'] ?? 0);
  $reason=trim((string)($b['reason'] ?? ''));
  if($target_id<=0) respond(['ok'=>false,'error'=>'Şikayet edilecek kayıt seçilmedi.'],400);
  if($reason==='') respond(['ok'=>false,'error'=>'Şikayet sebebi gerekli.'],400);
  if(mb_strlen($reason,'UTF-8') > 1200) respond(['ok'=>false,'error'=>'Şikayet sebebi en fazla 1200 karakter olabilir.'],400);
  if($target_type === 'user') $reported_user_id = $target_id;
  if($reported_user_id === (int)$me['id']) respond(['ok'=>false,'error'=>'Kendini şikayet edemezsin.'],400);
  if($reported_user_id > 0){
    $u = @$mysqli->query("SELECT id,is_admin,email,full_name FROM users WHERE id=$reported_user_id LIMIT 1")->fetch_assoc();
    if(!$u) respond(['ok'=>false,'error'=>'Şikayet edilen kullanıcı bulunamadı.'],404);
    if((int)($u['is_admin'] ?? 0) === 1 || strtolower((string)($u['email'] ?? '')) === 'admin@mera.com') respond(['ok'=>false,'error'=>'Admin hesabı şikayet edilemez.'],403);
  }else{
    $reported_user_id = null;
  }
  $reason = (string)censor_and_log($mysqli, $reason, $uid, 'report_create', $target_id);
  if(db_column_exists($mysqli,'reports','reported_user_id')){
    $stmt = $mysqli->prepare("INSERT INTO reports(reporter_id,target_type,target_id,reported_user_id,reason) VALUES(?,?,?,?,?)");
    $stmt->bind_param("isiis",$uid,$target_type,$target_id,$reported_user_id,$reason);
  }else{
    $stmt = $mysqli->prepare("INSERT INTO reports(reporter_id,target_type,target_id,reason) VALUES(?,?,?,?)");
    $stmt->bind_param("isis",$uid,$target_type,$target_id,$reason);
  }
  if(!$stmt || !$stmt->execute()) respond(['ok'=>false,'error'=>'Şikayet kaydedilemedi.'],500);
  $id=(int)$stmt->insert_id;
  $r=$mysqli->query("SELECT * FROM reports WHERE id=$id LIMIT 1")->fetch_assoc();
  respond(['ok'=>true,'message'=>'Şikayet edildi. 3 gün içinde düzenleyebilir veya silebilirsin.','report'=>['id'=>$id,'status'=>'open'] + report_edit_deadline($r ?: ['created_at'=>gmdate('Y-m-d H:i:s'),'status'=>'open'])]);
}

if($action === 'my_reports'){
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $res=$mysqli->query("SELECT r.*, ru.full_name AS reported_name FROM reports r LEFT JOIN users ru ON ru.id=r.reported_user_id WHERE r.reporter_id=$uid AND r.status<>'deleted' ORDER BY r.id DESC LIMIT 80");
  $items=[];
  while($res && ($r=$res->fetch_assoc())){
    $meta=report_edit_deadline($r);
    $items[]=[
      'id'=>(int)$r['id'],'target_type'=>$r['target_type'],'target_id'=>(int)$r['target_id'],'reported_user_id'=>$r['reported_user_id']!==null?(int)$r['reported_user_id']:null,'reported_name'=>$r['reported_name'] ?? null,
      'reason'=>$r['reason'],'status'=>$r['status'],'created_at'=>$r['created_at'],'updated_at'=>$r['updated_at'] ?? null,'handled_at'=>$r['handled_at'] ?? null,'resolution_note'=>$r['resolution_note'] ?? null,
      'editable_until'=>$meta['editable_until'],'can_edit'=>$meta['can_edit']
    ];
  }
  respond(['ok'=>true,'reports'=>$items]);
}

if($action === 'report_update'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id']??0); $reason=trim((string)($b['reason']??''));
  if($id<=0) respond(['ok'=>false,'error'=>'Şikayet seçilmedi.'],400);
  if($reason==='') respond(['ok'=>false,'error'=>'Yeni şikayet sebebi boş olamaz.'],400);
  if(mb_strlen($reason,'UTF-8') > 1200) respond(['ok'=>false,'error'=>'Şikayet sebebi en fazla 1200 karakter olabilir.'],400);
  $stmt=$mysqli->prepare("SELECT * FROM reports WHERE id=? AND reporter_id=? LIMIT 1");
  $stmt->bind_param('ii',$id,$uid); $stmt->execute(); $r=$stmt->get_result()->fetch_assoc();
  if(!$r) respond(['ok'=>false,'error'=>'Şikayet bulunamadı.'],404);
  $meta=report_edit_deadline($r);
  if(!$meta['can_edit']) respond(['ok'=>false,'error'=>'Bu şikayeti düzenleme süresi dolmuş veya rapor kapatılmış.'],403);
  $reason=(string)censor_and_log($mysqli,$reason,$uid,'report_update',$id);
  $stmt=$mysqli->prepare("UPDATE reports SET reason=?, updated_at=UTC_TIMESTAMP() WHERE id=? AND reporter_id=?");
  $stmt->bind_param('sii',$reason,$id,$uid); $stmt->execute();
  respond(['ok'=>true,'message'=>'Şikayet güncellendi.']);
}

if($action === 'report_delete'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id']??0);
  if($id<=0) respond(['ok'=>false,'error'=>'Şikayet seçilmedi.'],400);
  $stmt=$mysqli->prepare("SELECT * FROM reports WHERE id=? AND reporter_id=? LIMIT 1");
  $stmt->bind_param('ii',$id,$uid); $stmt->execute(); $r=$stmt->get_result()->fetch_assoc();
  if(!$r) respond(['ok'=>false,'error'=>'Şikayet bulunamadı.'],404);
  $meta=report_edit_deadline($r);
  if(!$meta['can_edit']) respond(['ok'=>false,'error'=>'Bu şikayeti silme süresi dolmuş veya rapor kapatılmış.'],403);
  $stmt=$mysqli->prepare("UPDATE reports SET status='deleted', updated_at=UTC_TIMESTAMP() WHERE id=? AND reporter_id=?");
  $stmt->bind_param('ii',$id,$uid); $stmt->execute();
  respond(['ok'=>true,'message'=>'Şikayet silindi.']);
}

if($action === 'report_reminders'){
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $items=[];
  $res=$mysqli->query("SELECT * FROM reports WHERE reporter_id=$uid AND status='open' AND created_at <= DATE_SUB(UTC_TIMESTAMP(), INTERVAL 2 DAY) AND created_at > DATE_SUB(UTC_TIMESTAMP(), INTERVAL 3 DAY) ORDER BY id DESC LIMIT 20");
  while($res && ($r=$res->fetch_assoc())){
    $rid=(int)$r['id']; $stage=0;
    if(empty($r['reminder1_at'])) $stage=1;
    elseif(empty($r['reminder2_at']) && strtotime((string)$r['created_at']) <= time() - 60*60*60) $stage=2;
    if($stage>0){
      $col=$stage===1?'reminder1_at':'reminder2_at';
      @$mysqli->query("UPDATE reports SET $col=UTC_TIMESTAMP() WHERE id=$rid");
      $meta=report_edit_deadline($r);
      $items[]=['id'=>$rid,'stage'=>$stage,'reason'=>$r['reason'],'editable_until'=>$meta['editable_until'],'message'=>'Bu şikayeti oluşturmuştunuz. Son gün içindesiniz; bir değişiklik yapmak ister misiniz?'];
    }
  }
  respond(['ok'=>true,'reminders'=>$items]);
}

if($action === 'my_notifications'){
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $res=$mysqli->query("SELECT id,type,title,body,link_url,is_read,created_at FROM app_notifications WHERE user_id=$uid ORDER BY id DESC LIMIT 30");
  $items=[]; while($res && ($r=$res->fetch_assoc())) $items[]=['id'=>(int)$r['id'],'type'=>$r['type'],'title'=>$r['title'],'body'=>$r['body'],'link_url'=>$r['link_url'],'is_read'=>(int)$r['is_read'],'created_at'=>$r['created_at']];
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'notifications_read'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id']??0);
  if($id>0) $mysqli->query("UPDATE app_notifications SET is_read=1 WHERE id=$id AND user_id=$uid");
  else $mysqli->query("UPDATE app_notifications SET is_read=1 WHERE user_id=$uid");
  respond(['ok'=>true]);
}


if($action === 'block_toggle'){
  $me = require_auth($mysqli);
  $b = json_body();
  $other = (int)($b['user_id'] ?? 0);
  $block = isset($b['block']) ? ((int)$b['block']===1) : true;
  $uid = (int)$me['id'];
  if($other<=0 || $other===$uid) respond(['ok'=>false,'error'=>'Geçerli bir kullanıcı seç.'],400);
  $u = @$mysqli->query("SELECT id,is_admin,email,full_name FROM users WHERE id=$other LIMIT 1")->fetch_assoc();
  if(!$u) respond(['ok'=>false,'error'=>'Kullanıcı bulunamadı.'],404);
  if((int)($u['is_admin'] ?? 0) === 1 || strtolower((string)($u['email'] ?? '')) === 'admin@mera.com') respond(['ok'=>false,'error'=>'Admin hesabı engellenemez.'],403);
  if($block){
    $stmt=$mysqli->prepare("INSERT IGNORE INTO user_blocks(blocker_id,blocked_id) VALUES(?,?)");
    $stmt->bind_param('ii',$uid,$other); $stmt->execute();
    respond(['ok'=>true,'blocked'=>true]);
  }
  $stmt=$mysqli->prepare("DELETE FROM user_blocks WHERE blocker_id=? AND blocked_id=?");
  $stmt->bind_param('ii',$uid,$other); $stmt->execute();
  respond(['ok'=>true,'blocked'=>false]);
}

if($action === 'profile_views_visibility_update'){
  $me = require_auth($mysqli);
  $b = json_body();
  $visibility = trim((string)($b['profile_views_visibility'] ?? 'private'));
  if(!in_array($visibility, ['public','private'], true)) $visibility = 'private';
  $uid=(int)$me['id'];
  $stmt = $mysqli->prepare("UPDATE users SET profile_views_visibility=? WHERE id=?");
  $stmt->bind_param('si',$visibility,$uid);
  $stmt->execute();
  $u = $mysqli->query("SELECT * FROM users WHERE id=".$uid)->fetch_assoc();
  respond(['ok'=>true,'user'=>safe_user($u ?: $me)]);
}

if($action === 'my_blocks'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $res=@$mysqli->query("SELECT u.id,u.full_name,u.school,u.grad_year,u.photo_url,b.created_at FROM user_blocks b JOIN users u ON u.id=b.blocked_id WHERE b.blocker_id=$uid ORDER BY b.created_at DESC LIMIT 200");
  $items=[];
  while($res && ($r=$res->fetch_assoc())) $items[] = safe_user($r) + ['blocked_at'=>$r['created_at'] ?? null];
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'account_privacy_update'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN account_privacy VARCHAR(20) NOT NULL DEFAULT 'private'");
  $b = json_body();
  $privacy = (string)($b['account_privacy'] ?? 'private');
  if(!in_array($privacy, ['public','private'], true)) $privacy = 'private';
  $stmt = $mysqli->prepare("UPDATE users SET account_privacy=? WHERE id=?");
  $stmt->bind_param('si',$privacy,$uid);
  $stmt->execute();
  $u = $mysqli->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
  respond(['ok'=>true,'user'=>safe_user($u ?: $me)]);
}

if($action === 'dm_privacy_update'){
  $me = require_auth($mysqli);
  $b = json_body();
  $privacy = (string)($b['dm_privacy'] ?? 'everyone');
  if(!in_array($privacy, ['everyone','mutual'], true)) respond(['ok'=>false,'error'=>'Mesaj ayarı geçersiz.'],400);
  $dm_sidebar_alerts_enabled = isset($b['dm_sidebar_alerts_enabled']) ? ((int)$b['dm_sidebar_alerts_enabled'] ? 1 : 0) : (int)($me['dm_sidebar_alerts_enabled'] ?? 1);
  $admin_call_allowed = isset($b['admin_call_allowed']) ? ((int)$b['admin_call_allowed'] ? 1 : 0) : (int)($me['admin_call_allowed'] ?? 1);
  $uid=(int)$me['id'];
  if((int)($me['is_admin'] ?? 0) === 1){
    $stmt=$mysqli->prepare("UPDATE users SET dm_privacy=?, dm_sidebar_alerts_enabled=?, admin_call_allowed=? WHERE id=?");
    $stmt->bind_param('siii',$privacy,$dm_sidebar_alerts_enabled,$admin_call_allowed,$uid);
  }else{
    $stmt=$mysqli->prepare("UPDATE users SET dm_privacy=?, dm_sidebar_alerts_enabled=? WHERE id=?");
    $stmt->bind_param('sii',$privacy,$dm_sidebar_alerts_enabled,$uid);
  }
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Mesaj ayarı kaydedilemedi.'],500);
  $u=$mysqli->query("SELECT * FROM users WHERE id=$uid LIMIT 1")->fetch_assoc();
  respond(['ok'=>true,'user'=>safe_user($u ?: $me)]);
}

if($action === 'pet_partner_candidates'){
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $res=$mysqli->query("SELECT u.id,u.full_name,u.school,u.grad_year,u.photo_url FROM follows f JOIN users u ON u.id=f.following_id WHERE f.follower_id=$uid ORDER BY u.full_name ASC LIMIT 200");
  $items=[]; while($res && ($r=$res->fetch_assoc())) $items[] = safe_user($r);
  respond(['ok'=>true,'users'=>$items]);
}

if($action === 'pet_list'){
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $sql="SELECT p.*, ou.full_name owner_name, pu.full_name partner_name FROM avatar_pets p JOIN users ou ON ou.id=p.owner_id LEFT JOIN users pu ON pu.id=p.partner_id WHERE p.owner_id=$uid OR p.partner_id=$uid ORDER BY p.updated_at DESC, p.id DESC";
  $res=$mysqli->query($sql);
  $items=[];
  while($res && ($r=$res->fetch_assoc())){
    pet_maybe_notify($mysqli, $r);
    pet_maybe_praise($mysqli, $r);
    $items[] = pet_payload($mysqli, $r, $uid);
  }
  respond(['ok'=>true,'pets'=>$items]);
}

if($action === 'pet_create'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $name=trim((string)($b['name'] ?? ''));
  $type=(string)($b['pet_type'] ?? 'solo');
  $partner=(int)($b['partner_id'] ?? 0);
  $color=(string)($b['color'] ?? 'violet');
  if($name==='') respond(['ok'=>false,'error'=>'Avatar adı gerekli.'],400);
  if(mb_strlen($name,'UTF-8') > 40) respond(['ok'=>false,'error'=>'Avatar adı en fazla 40 karakter olabilir.'],400);
  if(!in_array($type,['solo','shared'],true)) respond(['ok'=>false,'error'=>'Avatar türü geçersiz.'],400);
  if(!in_array($color,['violet','blue','green','rose','amber'],true)) $color='violet';
  if($type==='solo') $partner=0;
  if($type==='solo'){
    $exists=@$mysqli->query("SELECT id FROM avatar_pets WHERE owner_id=$uid AND pet_type='solo' ORDER BY id ASC LIMIT 1");
    if($exists && ($ex=$exists->fetch_assoc())) respond(['ok'=>false,'error'=>'Kendi avatarın zaten var. Bir kullanıcı yalnızca 1 kendi avatarına sahip olabilir.','existing_id'=>(int)$ex['id']],400);
  }
  if($type==='shared'){
    if($partner<=0 || $partner===$uid) respond(['ok'=>false,'error'=>'Ortak avatar için takip ettiğin bir kişiyi seç.'],400);
    $ok=@$mysqli->query("SELECT 1 FROM follows WHERE follower_id=$uid AND following_id=$partner LIMIT 1");
    if(!$ok || !$ok->fetch_row()) respond(['ok'=>false,'error'=>'Ortak avatar yalnızca takip ettiğin kişilerle oluşturulabilir.'],403);
  }
  $name=(string)censor_and_log($mysqli,$name,$uid,'avatar_name',0);
  if($type==='shared'){
    $stmt=$mysqli->prepare("INSERT INTO avatar_pets(owner_id,partner_id,pet_type,name,color,visibility,messages_enabled,xp,last_fed_at,last_toilet_at,last_slept_at,last_played_at) VALUES(?,?,?,?,?,'public',1,0,UTC_TIMESTAMP(),UTC_TIMESTAMP(),UTC_TIMESTAMP(),UTC_TIMESTAMP())");
    $stmt->bind_param('iisss',$uid,$partner,$type,$name,$color);
  }else{
    $stmt=$mysqli->prepare("INSERT INTO avatar_pets(owner_id,partner_id,pet_type,name,color,visibility,messages_enabled,xp,last_fed_at,last_toilet_at,last_slept_at,last_played_at) VALUES(?,NULL,?,?,?,'public',1,0,UTC_TIMESTAMP(),UTC_TIMESTAMP(),UTC_TIMESTAMP(),UTC_TIMESTAMP())");
    $stmt->bind_param('isss',$uid,$type,$name,$color);
  }
  if(!$stmt || !$stmt->execute()) respond(['ok'=>false,'error'=>'Avatar oluşturulamadı.'],500);
  $id=(int)$mysqli->insert_id;
  if($type==='shared' && $partner>0) app_notify($mysqli,$partner,'avatar_pet','Ortak avatar oluşturuldu',$me['full_name'].' seninle ortak bir avatar oluşturdu: '.$name,'pet');
  respond(['ok'=>true,'id'=>$id,'message'=>'Avatar oluşturuldu.']);
}

if($action === 'pet_action'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id'] ?? 0); $act=(string)($b['care_action'] ?? '');
  if($id<=0) respond(['ok'=>false,'error'=>'Avatar seçilmedi.'],400);
  if(!in_array($act,['feed','toilet','sleep','play','pet'],true)) respond(['ok'=>false,'error'=>'Bakım işlemi geçersiz.'],400);
  $stmt=$mysqli->prepare("SELECT * FROM avatar_pets WHERE id=? AND (owner_id=? OR partner_id=?) LIMIT 1");
  $stmt->bind_param('iii',$id,$uid,$uid); $stmt->execute(); $p=$stmt->get_result()->fetch_assoc();
  if(!$p) respond(['ok'=>false,'error'=>'Avatar bulunamadı.'],404);
  $col = $act==='feed' ? 'last_fed_at' : ($act==='toilet' ? 'last_toilet_at' : ($act==='sleep' ? 'last_slept_at' : ($act==='pet' ? 'last_petted_at' : 'last_played_at')));
  $xpAdd = ($act==='play' || $act==='pet') ? 18 : 10;
  if(($p['health_status'] ?? 'healthy') !== 'healthy') $xpAdd = max(6, $xpAdd-4);
  $beforeState = pet_state($p);
  $beforeStage = (int)($beforeState['stage'] ?? 1);
  $afterProbe = $p;
  $afterProbe['xp'] = (int)($p['xp'] ?? 0) + $xpAdd;
  $afterState = pet_state($afterProbe);
  $afterStage = (int)($afterState['stage'] ?? $beforeStage);
  $growthEggs = 0;
  if($beforeStage < 3 && $afterStage >= 3 && (int)($p['growth_eggs_given'] ?? 0) === 0){
    $growthEggs = mt_rand(1,5);
  } elseif($beforeStage >= 3 && (int)($p['growth_eggs_given'] ?? 0) === 0){
    $growthEggs = mt_rand(1,5);
  }
  $eggSql = $growthEggs > 0 ? ", egg_count=egg_count+$growthEggs, growth_eggs_given=1" : "";
  $mysqli->query("UPDATE avatar_pets SET `$col`=UTC_TIMESTAMP(), xp=xp+$xpAdd $eggSql, updated_at=UTC_TIMESTAMP() WHERE id=$id");
  if($growthEggs > 0 && (int)($p['messages_enabled'] ?? 1)===1){
    app_notify($mysqli,(int)$p['owner_id'],'avatar_pet','Tavuğun yumurta verdi',($p['name'] ?? 'Tavuğun').' büyüdü ve '.$growthEggs.' yumurta verdi. Yumurtaları severek çatlatabilirsin 🥚','pet');
  }
  $res=$mysqli->query("SELECT p.*, ou.full_name owner_name, pu.full_name partner_name FROM avatar_pets p JOIN users ou ON ou.id=p.owner_id LEFT JOIN users pu ON pu.id=p.partner_id WHERE p.id=$id LIMIT 1");
  $fresh=$res ? $res->fetch_assoc() : null;
  respond(['ok'=>true,'pet'=>$fresh ? pet_payload($mysqli,$fresh,$uid) : null,'message'=>'Avatar bakımı yapıldı.']);
}


if($action === 'pet_hatch_egg'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id'] ?? 0);
  $strokes=max(0,(int)($b['strokes'] ?? 0));
  if($id<=0) respond(['ok'=>false,'error'=>'Yumurta kontrolü için avatar seçilmedi.'],400);
  if($strokes < 3) respond(['ok'=>false,'error'=>'Yumurtayı çatlatmak için biraz daha sevmen gerekiyor.'],400);
  $stmt=$mysqli->prepare("SELECT * FROM avatar_pets WHERE id=? AND owner_id=? LIMIT 1");
  $stmt->bind_param('ii',$id,$uid); $stmt->execute(); $parent=$stmt->get_result()->fetch_assoc();
  if(!$parent) respond(['ok'=>false,'error'=>'Avatar bulunamadı.'],404);
  if((int)($parent['egg_count'] ?? 0) <= 0) respond(['ok'=>false,'error'=>'Kontrol edilecek yumurta yok.'],400);
  $mysqli->query("UPDATE avatar_pets SET egg_count=egg_count-1, updated_at=UTC_TIMESTAMP() WHERE id=$id AND egg_count>0");
  $count = (mt_rand(1,100) <= 25) ? 2 : 1;
  $colors=['violet','blue','green','rose','amber'];
  $created=[];
  for($i=0;$i<$count;$i++){
    $trait=pet_random_trait();
    $isSpecial = ($trait['code']==='special_leg') || mt_rand(1,100)<=18;
    if($isSpecial && $trait['code']!=='special_leg') $trait=['code'=>'special_care','label'=>'Özel civciv','note'=>'Bugün biraz hassas. Daha yavaş, sevgi dolu bakım ister.'];
    $health=$isSpecial ? 'sensitive' : 'healthy';
    $until=$isSpecial ? gmdate('Y-m-d H:i:s', time()+mt_rand(2,5)*86400) : null;
    $name='Civciv '.gmdate('dHi').($count>1?'-'.($i+1):'');
    $color=$colors[array_rand($colors)];
    $gen=max(2,(int)($parent['generation'] ?? 1)+1);
    $note=$isSpecial ? $trait['note'] : null;
    $vis=(string)($parent['visibility'] ?? 'public'); $msg=(int)($parent['messages_enabled'] ?? 1);
    $stmt2=$mysqli->prepare("INSERT INTO avatar_pets(owner_id,parent_pet_id,partner_id,pet_type,name,color,visibility,messages_enabled,xp,generation,trait_code,trait_label,special_note,health_status,health_until,last_fed_at,last_toilet_at,last_slept_at,last_played_at,last_petted_at) VALUES(?,?,NULL,'chick',?,?,?,?,0,?,?,?,?,?,?,UTC_TIMESTAMP(),UTC_TIMESTAMP(),UTC_TIMESTAMP(),UTC_TIMESTAMP(),UTC_TIMESTAMP())");
    $stmt2->bind_param('iisssiisssss',$uid,$id,$name,$color,$vis,$msg,$gen,$trait['code'],$trait['label'],$note,$health,$until);
    if($stmt2 && $stmt2->execute()){
      $newId=(int)$mysqli->insert_id;
      $res=$mysqli->query("SELECT p.*, ou.full_name owner_name, pu.full_name partner_name FROM avatar_pets p JOIN users ou ON ou.id=p.owner_id LEFT JOIN users pu ON pu.id=p.partner_id WHERE p.id=$newId LIMIT 1");
      if($res && ($row=$res->fetch_assoc())) $created[]=pet_payload($mysqli,$row,$uid);
    }
  }
  if(count($created)>0){
    $body=count($created)>1 ? 'Yumurtadan iki yeni civciv çıktı! Civcivler arasında geçiş yapıp hepsine ayrı ayrı bakabilirsin.' : 'Yumurtadan yeni bir civciv çıktı! Ona isim verebilir ve yavaş yavaş büyütebilirsin.';
    app_notify($mysqli,$uid,'avatar_pet','Yeni civciv çıktı',$body,'pet');
    foreach($created as $c){
      if(($c['health_status'] ?? 'healthy') !== 'healthy') app_notify($mysqli,$uid,'avatar_pet','Özel civciv bakımı',($c['name'] ?? 'Bu civciv').' hassas doğdu. Lütfen daha nazik davran; birkaç gün içinde iyileşebilir.','pet');
    }
  }
  respond(['ok'=>true,'chicks'=>$created,'message'=>count($created).' civciv çıktı.']);
}

if($action === 'pet_adoption_candidates'){
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $items=[];
  $sql="SELECT u.id,u.full_name,u.school FROM follows f JOIN users u ON u.id=f.following_id WHERE f.follower_id=$uid AND u.id<>$uid ORDER BY u.full_name ASC LIMIT 80";
  $res=$mysqli->query($sql);
  while($res && ($r=$res->fetch_assoc())) $items[]=$r;
  respond(['ok'=>true,'users'=>$items]);
}

if($action === 'pet_adopt'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id'] ?? 0); $to=(int)($b['to_user_id'] ?? 0); $mode=(string)($b['mode'] ?? 'friend');
  if(!in_array($mode, ['friend','farm'], true)) $mode='friend';
  if($id<=0) respond(['ok'=>false,'error'=>'Sahiplendirilecek avatar seçilmedi.'],400);
  if($mode==='friend' && ($to<=0 || $to===$uid)) respond(['ok'=>false,'error'=>'Sahiplendirilecek kişi seçilmedi.'],400);
  if($mode==='friend'){
    $ok=$mysqli->query("SELECT 1 FROM follows WHERE follower_id=$uid AND following_id=$to LIMIT 1");
    if(!$ok || !$ok->fetch_row()) respond(['ok'=>false,'error'=>'Civcivi sadece takip ettiğin bir kullanıcıya sahiplendirebilirsin.'],403);
    $targetUser=@$mysqli->query("SELECT id,is_admin FROM users WHERE id=$to LIMIT 1")->fetch_assoc();
    if(!$targetUser) respond(['ok'=>false,'error'=>'Sahiplendirilecek kullanıcı bulunamadı.'],404);
  }
  $stmt=$mysqli->prepare("SELECT id,name,pet_type,owner_id FROM avatar_pets WHERE id=? AND owner_id=? LIMIT 1");
  $stmt->bind_param('ii',$id,$uid); $stmt->execute(); $pet=$stmt->get_result()->fetch_assoc();
  if(!$pet) respond(['ok'=>false,'error'=>'Civciv bulunamadı.'],404);
  if($mode==='farm'){
    $stmtDel=$mysqli->prepare("DELETE FROM avatar_pets WHERE id=? AND owner_id=?");
    $stmtDel->bind_param('ii',$id,$uid);
    if(!$stmtDel || !$stmtDel->execute()) respond(['ok'=>false,'error'=>'Tavuk çiftliğine sahiplendirme tamamlanamadı.'],500);
    app_notify($mysqli,$uid,'avatar_pet','Tavuk çiftliğine sahiplendirildi',($pet['name'] ?? 'Avatar').' tavuk çiftliğine gönderildi ve hesabından silindi. 💜','pet');
    respond(['ok'=>true,'message'=>'Tavuk çiftliğine sahiplendirildi ve hesabından silindi.']);
  }
  $stmt2=$mysqli->prepare("UPDATE avatar_pets SET owner_id=?, partner_id=NULL, visibility='public', updated_at=UTC_TIMESTAMP() WHERE id=? AND owner_id=?");
  $stmt2->bind_param('iii',$to,$id,$uid);
  if(!$stmt2 || !$stmt2->execute()) respond(['ok'=>false,'error'=>'Sahiplendirme tamamlanamadı.'],500);
  app_notify($mysqli,$to,'avatar_pet','Yeni avatar sahiplendin',($me['full_name'] ?? 'Bir arkadaşın').' sana '.($pet['name'] ?? 'bir civciv').' adlı civcivi sahiplendirdi. Ona sevgiyle bakabilirsin 🐣','pet');
  app_notify($mysqli,$uid,'avatar_pet','Avatar sahiplendirildi',($pet['name'] ?? 'Civciv').' yeni yuvasına gönderildi. Ona güzel bir yuva buldun 💜','pet');
  respond(['ok'=>true,'message'=>'Avatar sahiplendirildi.']);
}

if($action === 'pet_settings'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id'] ?? 0);
  $visibility=(string)($b['visibility'] ?? 'public');
  $messages_enabled=isset($b['messages_enabled']) ? (int)$b['messages_enabled'] : 1;
  if($id<=0) respond(['ok'=>false,'error'=>'Avatar seçilmedi.'],400);
  if(!in_array($visibility,['public','private'],true)) $visibility='public';
  $messages_enabled=$messages_enabled ? 1 : 0;
  $stmt=$mysqli->prepare("UPDATE avatar_pets SET visibility=?, messages_enabled=?, updated_at=UTC_TIMESTAMP() WHERE id=? AND (owner_id=? OR partner_id=?)");
  $stmt->bind_param('siiii',$visibility,$messages_enabled,$id,$uid,$uid); $stmt->execute();
  respond(['ok'=>true,'message'=>'Avatar ayarları güncellendi.']);
}

if($action === 'pet_public_list'){
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $userId=(int)($_GET['user_id'] ?? 0);
  if($userId<=0) respond(['ok'=>false,'error'=>'Kullanıcı seçilmedi.'],400);
  $sql="SELECT p.*, ou.full_name owner_name, pu.full_name partner_name FROM avatar_pets p JOIN users ou ON ou.id=p.owner_id LEFT JOIN users pu ON pu.id=p.partner_id WHERE (p.owner_id=$userId OR p.partner_id=$userId) AND (p.visibility='public' OR p.owner_id=$uid OR p.partner_id=$uid) ORDER BY p.updated_at DESC, p.id DESC LIMIT 6";
  $res=$mysqli->query($sql); $items=[];
  while($res && ($r=$res->fetch_assoc())) $items[] = pet_payload($mysqli,$r,$uid);
  respond(['ok'=>true,'pets'=>$items]);
}

if($action === 'pet_rename'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id'] ?? 0); $name=trim((string)($b['name'] ?? ''));
  if($id<=0 || $name==='') respond(['ok'=>false,'error'=>'Avatar ve yeni ad gerekli.'],400);
  if(mb_strlen($name,'UTF-8') > 40) respond(['ok'=>false,'error'=>'Avatar adı en fazla 40 karakter olabilir.'],400);
  $name=(string)censor_and_log($mysqli,$name,$uid,'avatar_rename',$id);
  $stmt=$mysqli->prepare("UPDATE avatar_pets SET name=?, updated_at=UTC_TIMESTAMP() WHERE id=? AND (owner_id=? OR partner_id=?)");
  $stmt->bind_param('siii',$name,$id,$uid,$uid); $stmt->execute();
  respond(['ok'=>true,'message'=>'Avatar adı güncellendi.']);
}

if($action === 'pet_delete'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id'] ?? 0);
  if($id<=0) respond(['ok'=>false,'error'=>'Avatar seçilmedi.'],400);
  $stmt=$mysqli->prepare("DELETE FROM avatar_pets WHERE id=? AND owner_id=?");
  $stmt->bind_param('ii',$id,$uid); $stmt->execute();
  respond(['ok'=>true,'message'=>'Avatar listenden kaldırıldı.']);
}


if($action === 'pet_friend_candidates'){
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $ownRes=$mysqli->query("SELECT id FROM avatar_pets WHERE owner_id=$uid AND pet_type='solo' ORDER BY id ASC LIMIT 1");
  $own=$ownRes ? $ownRes->fetch_assoc() : null;
  if(!$own) respond(['ok'=>true,'users'=>[],'message'=>'Önce kendi avatarını oluştur.']);
  $ownPet=(int)$own['id'];
  $sql="SELECT u.id user_id,u.full_name,u.school,p.id pet_id,p.name pet_name,p.color,p.xp,p.egg_count,p.last_fed_at,p.last_toilet_at,p.last_slept_at,p.last_played_at,p.last_petted_at,p.created_at
        FROM follows f JOIN users u ON u.id=f.following_id JOIN avatar_pets p ON p.owner_id=u.id AND p.pet_type='solo'
        WHERE f.follower_id=$uid AND NOT EXISTS(SELECT 1 FROM avatar_pet_friendships af WHERE (af.pet_id=$ownPet AND af.friend_pet_id=p.id) OR (af.pet_id=p.id AND af.friend_pet_id=$ownPet))
        ORDER BY u.full_name ASC LIMIT 100";
  $res=$mysqli->query($sql); $items=[];
  while($res && ($r=$res->fetch_assoc())){ $r['state']=pet_state($r); $items[]=$r; }
  respond(['ok'=>true,'users'=>$items]);
}

function pet_friendship_payload(mysqli $mysqli, array $r, int $uid): array {
  $a = ['id'=>(int)$r['pet_id'],'name'=>$r['pet_name'],'color'=>$r['pet_color'],'xp'=>(int)$r['pet_xp'],'egg_count'=>(int)$r['pet_egg_count'],'last_fed_at'=>$r['pet_last_fed_at'],'last_toilet_at'=>$r['pet_last_toilet_at'],'last_slept_at'=>$r['pet_last_slept_at'],'last_played_at'=>$r['pet_last_played_at'],'last_petted_at'=>$r['pet_last_petted_at'],'created_at'=>$r['pet_created_at'],'owner_id'=>(int)$r['pet_owner_id'],'owner_name'=>$r['pet_owner_name']];
  $b = ['id'=>(int)$r['friend_pet_id'],'name'=>$r['friend_pet_name'],'color'=>$r['friend_pet_color'],'xp'=>(int)$r['friend_pet_xp'],'egg_count'=>(int)$r['friend_pet_egg_count'],'last_fed_at'=>$r['friend_last_fed_at'],'last_toilet_at'=>$r['friend_last_toilet_at'],'last_slept_at'=>$r['friend_last_slept_at'],'last_played_at'=>$r['friend_last_played_at'],'last_petted_at'=>$r['friend_last_petted_at'],'created_at'=>$r['friend_created_at'],'owner_id'=>(int)$r['friend_owner_id'],'owner_name'=>$r['friend_owner_name']];
  return ['id'=>(int)$r['id'],'status'=>$r['status'],'conflict_reason'=>$r['conflict_reason'],'resolved_by_owner'=>(int)$r['resolved_by_owner'],'resolved_by_friend'=>(int)$r['resolved_by_friend'],'last_interaction_at'=>$r['last_interaction_at'],'pet_a'=>$a + ['state'=>pet_state($a)],'pet_b'=>$b + ['state'=>pet_state($b)],'viewer_side'=>((int)$r['pet_owner_id']===$uid?'owner':'friend')];
}

if($action === 'pet_friendships_list'){
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $sql="SELECT af.*, p.owner_id pet_owner_id, u1.full_name pet_owner_name, p.name pet_name, p.color pet_color, p.xp pet_xp, p.egg_count pet_egg_count, p.last_fed_at pet_last_fed_at, p.last_toilet_at pet_last_toilet_at, p.last_slept_at pet_last_slept_at, p.last_played_at pet_last_played_at, p.last_petted_at pet_last_petted_at, p.created_at pet_created_at,
        fp.owner_id friend_owner_id, u2.full_name friend_owner_name, fp.name friend_pet_name, fp.color friend_pet_color, fp.xp friend_pet_xp, fp.egg_count friend_pet_egg_count, fp.last_fed_at friend_last_fed_at, fp.last_toilet_at friend_last_toilet_at, fp.last_slept_at friend_last_slept_at, fp.last_played_at friend_last_played_at, fp.last_petted_at friend_last_petted_at, fp.created_at friend_created_at
        FROM avatar_pet_friendships af
        JOIN avatar_pets p ON p.id=af.pet_id JOIN avatar_pets fp ON fp.id=af.friend_pet_id
        JOIN users u1 ON u1.id=p.owner_id JOIN users u2 ON u2.id=fp.owner_id
        WHERE p.owner_id=$uid OR fp.owner_id=$uid ORDER BY af.updated_at DESC";
  $res=$mysqli->query($sql); $items=[];
  while($res && ($r=$res->fetch_assoc())){
    if($r['status']==='friends'){
      $last=strtotime($r['last_interaction_at'].' UTC');
      if($last && time()-$last > 86400 && (((int)$r['id'] + (int)gmdate('G')) % 5 === 0)){
        $id=(int)$r['id'];
        @$mysqli->query("UPDATE avatar_pet_friendships SET status='conflict', conflict_reason='Oyuncak paylaşımı yüzünden küçük bir tartışma çıktı.', resolved_by_owner=0, resolved_by_friend=0, updated_at=UTC_TIMESTAMP() WHERE id=$id");
        $r['status']='conflict'; $r['conflict_reason']='Oyuncak paylaşımı yüzünden küçük bir tartışma çıktı.'; $r['resolved_by_owner']=0; $r['resolved_by_friend']=0;
      }
    }
    $items[]=pet_friendship_payload($mysqli,$r,$uid);
  }
  respond(['ok'=>true,'friendships'=>$items]);
}

if($action === 'pet_make_friend'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $friendPet=(int)($b['friend_pet_id'] ?? 0);
  $ownRes=$mysqli->query("SELECT id,name FROM avatar_pets WHERE owner_id=$uid AND pet_type='solo' ORDER BY id ASC LIMIT 1");
  $own=$ownRes ? $ownRes->fetch_assoc() : null;
  if(!$own) respond(['ok'=>false,'error'=>'Önce kendi avatarını oluştur.'],400);
  $ownPet=(int)$own['id'];
  if($friendPet<=0 || $friendPet===$ownPet) respond(['ok'=>false,'error'=>'Arkadaş yapılacak avatar seçilmedi.'],400);
  $check=$mysqli->query("SELECT p.id,p.owner_id,p.name,u.full_name FROM avatar_pets p JOIN users u ON u.id=p.owner_id JOIN follows f ON f.following_id=p.owner_id AND f.follower_id=$uid WHERE p.id=$friendPet AND p.pet_type='solo' LIMIT 1");
  $fp=$check ? $check->fetch_assoc() : null;
  if(!$fp) respond(['ok'=>false,'error'=>'Sadece takip ettiğin kişinin avatarıyla arkadaşlık kurabilirsin.'],403);
  $a=min($ownPet,$friendPet); $c=max($ownPet,$friendPet);
  $stmt=$mysqli->prepare("INSERT IGNORE INTO avatar_pet_friendships(pet_id,friend_pet_id,status,last_interaction_at) VALUES(?,?,'friends',UTC_TIMESTAMP())");
  $stmt->bind_param('ii',$a,$c); $stmt->execute();
  app_notify($mysqli,(int)$fp['owner_id'],'avatar_pet','Avatar arkadaşlığı',($own['name'] ?? 'Avatarın').' ile '.($fp['name'] ?? 'avatarın').' artık arkadaş oldu.','pet');
  respond(['ok'=>true,'message'=>'Avatarlar arkadaş oldu.']);
}

if($action === 'pet_resolve_conflict'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body();
  $id=(int)($b['id'] ?? 0);
  $sql="SELECT af.*, p.owner_id owner_a, fp.owner_id owner_b, p.name name_a, fp.name name_b FROM avatar_pet_friendships af JOIN avatar_pets p ON p.id=af.pet_id JOIN avatar_pets fp ON fp.id=af.friend_pet_id WHERE af.id=$id LIMIT 1";
  $res=$mysqli->query($sql); $r=$res ? $res->fetch_assoc() : null;
  if(!$r || ((int)$r['owner_a']!==$uid && (int)$r['owner_b']!==$uid)) respond(['ok'=>false,'error'=>'Arkadaşlık bulunamadı.'],404);
  if($r['status']!=='conflict') respond(['ok'=>true,'message'=>'Şu an çözülmesi gereken kavga yok.']);
  $field=((int)$r['owner_a']===$uid) ? 'resolved_by_owner' : 'resolved_by_friend';
  $mysqli->query("UPDATE avatar_pet_friendships SET $field=1, updated_at=UTC_TIMESTAMP() WHERE id=$id");
  $fresh=$mysqli->query("SELECT resolved_by_owner,resolved_by_friend FROM avatar_pet_friendships WHERE id=$id")->fetch_assoc();
  if((int)$fresh['resolved_by_owner']===1 && (int)$fresh['resolved_by_friend']===1){
    $mysqli->query("UPDATE avatar_pet_friendships SET status='friends', conflict_reason=NULL, resolved_by_owner=0, resolved_by_friend=0, last_interaction_at=UTC_TIMESTAMP(), updated_at=UTC_TIMESTAMP() WHERE id=$id");
    $mysqli->query("UPDATE avatar_pets SET xp=xp+25, updated_at=UTC_TIMESTAMP() WHERE id IN (".(int)$r['pet_id'].",".(int)$r['friend_pet_id'].")");
    app_notify($mysqli,(int)$r['owner_a'],'avatar_pet','Kavga çözüldü',($r['name_a'] ?? 'Avatarın').' ve '.($r['name_b'] ?? 'arkadaşı').' barıştı.','pet');
    app_notify($mysqli,(int)$r['owner_b'],'avatar_pet','Kavga çözüldü',($r['name_a'] ?? 'Avatarın').' ve '.($r['name_b'] ?? 'arkadaşı').' barıştı.','pet');
    respond(['ok'=>true,'resolved'=>true,'message'=>'İki taraf da ilgilendi, avatarlar barıştı.']);
  }
  respond(['ok'=>true,'resolved'=>false,'message'=>'Sen çözüm adımını attın. Diğer arkadaşın da onaylayınca kavga kapanacak.']);
}


if($action === 'badge_request_status'){
  ensure_feature_schema($mysqli);
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  $res=$mysqli->query("SELECT id,message,status,admin_note,created_at,decided_at FROM badge_requests WHERE user_id=$uid ORDER BY id DESC LIMIT 1");
  $r=$res ? $res->fetch_assoc() : null;
  $canRequest=true; $retryAt=null; $waitDays=0;
  if($r){
    if((string)$r['status']==='pending') $canRequest=false;
    if((string)$r['status']==='rejected'){
      $retryTs=strtotime((string)$r['decided_at'].' UTC') + 3*24*60*60;
      if($retryTs > time()){
        $canRequest=false; $retryAt=gmdate('Y-m-d H:i:s',$retryTs); $waitDays=max(1,(int)ceil(($retryTs-time())/86400));
      }
    }
  }
  respond(['ok'=>true,'verified_badge'=>(int)($me['verified_badge'] ?? 0),'can_request'=>$canRequest,'retry_at'=>$retryAt,'wait_days'=>$waitDays,'request'=>$r ? ['id'=>(int)$r['id'],'message'=>$r['message'],'status'=>$r['status'],'admin_note'=>$r['admin_note'],'created_at'=>$r['created_at'],'decided_at'=>$r['decided_at']] : null]);
}

if($action === 'badge_request_create'){
  ensure_feature_schema($mysqli);
  $me=require_auth($mysqli); $uid=(int)$me['id'];
  if((int)($me['verified_badge'] ?? 0)===1) respond(['ok'=>false,'error'=>'Hesabında zaten rozet var.'],400);
  $b=json_body(); $message=trim((string)($b['message'] ?? ''));
  if($message==='') respond(['ok'=>false,'error'=>'Rozet talebi açıklaması boş olamaz.'],400);
  if(mb_strlen($message,'UTF-8')<20) respond(['ok'=>false,'error'=>'Lütfen hesabını en az 20 karakterle anlat.'],400);
  if(mb_strlen($message,'UTF-8')>1200) respond(['ok'=>false,'error'=>'Rozet talebi en fazla 1200 karakter olabilir.'],400);
  $pending=$mysqli->query("SELECT id FROM badge_requests WHERE user_id=$uid AND status='pending' LIMIT 1");
  if($pending && $pending->fetch_row()) respond(['ok'=>false,'error'=>'Zaten bekleyen bir rozet talebin var.'],400);
  $rej=$mysqli->query("SELECT decided_at FROM badge_requests WHERE user_id=$uid AND status='rejected' ORDER BY id DESC LIMIT 1");
  $last=$rej ? $rej->fetch_assoc() : null;
  if($last && !empty($last['decided_at'])){
    $retryTs=strtotime((string)$last['decided_at'].' UTC') + 3*24*60*60;
    if($retryTs > time()) respond(['ok'=>false,'error'=>'Rozet talebin onaylanmadı. 3 gün sonra tekrar deneyebilirsin.'],403);
  }
  $message=(string)censor_and_log($mysqli,$message,$uid,'badge_request',0);
  $stmt=$mysqli->prepare("INSERT INTO badge_requests(user_id,message,status) VALUES(?,?,'pending')");
  if(!$stmt) respond(['ok'=>false,'error'=>'Rozet talebi oluşturulamadı.'],500);
  $stmt->bind_param('is',$uid,$message);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Rozet talebi gönderilemedi.'],500);
  $admins=$mysqli->query("SELECT id FROM users WHERE is_admin=1");
  while($admins && ($a=$admins->fetch_assoc())) app_notify($mysqli,(int)$a['id'],'badge_request','Yeni rozet talebi',(string)$me['full_name'].' rozet talebi gönderdi.','admin.html');
  respond(['ok'=>true,'message'=>'Rozet talebin admine gönderildi.']);
}

if($action === 'admin_badge_requests'){
  ensure_feature_schema($mysqli);
  require_admin($mysqli);
  $status=trim((string)($_GET['status'] ?? 'pending'));
  if(!in_array($status,['pending','approved','rejected','all'],true)) $status='pending';
  $where=$status==='all'?'1=1':"br.status='".$mysqli->real_escape_string($status)."'";
  $res=$mysqli->query("SELECT br.*, u.full_name,u.email,u.school,u.grad_year,u.photo_url,u.verified_badge FROM badge_requests br JOIN users u ON u.id=br.user_id WHERE $where ORDER BY br.id DESC LIMIT 200");
  $items=[];
  while($res && ($r=$res->fetch_assoc())) $items[]=['id'=>(int)$r['id'],'user_id'=>(int)$r['user_id'],'full_name'=>$r['full_name'],'email'=>$r['email'],'school'=>$r['school'],'grad_year'=>$r['grad_year']!==null?(int)$r['grad_year']:null,'photo_url'=>$r['photo_url'],'verified_badge'=>(int)$r['verified_badge'],'message'=>$r['message'],'status'=>$r['status'],'admin_note'=>$r['admin_note'],'created_at'=>$r['created_at'],'decided_at'=>$r['decided_at']];
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'admin_badge_request_decide'){
  ensure_feature_schema($mysqli);
  $me=require_admin($mysqli); $adminId=(int)$me['id'];
  $b=json_body(); $id=(int)($b['id'] ?? 0); $decision=trim((string)($b['decision'] ?? '')); $note=trim((string)($b['note'] ?? ''));
  if($id<=0) respond(['ok'=>false,'error'=>'Rozet talebi seçilmedi.'],400);
  if(!in_array($decision,['approved','rejected'],true)) respond(['ok'=>false,'error'=>'Karar geçersiz.'],400);
  $req=$mysqli->query("SELECT br.*, u.full_name FROM badge_requests br JOIN users u ON u.id=br.user_id WHERE br.id=$id LIMIT 1")->fetch_assoc();
  if(!$req) respond(['ok'=>false,'error'=>'Rozet talebi bulunamadı.'],404);
  if((string)$req['status']!=='pending') respond(['ok'=>false,'error'=>'Bu talep zaten sonuçlandırılmış.'],400);
  $userId=(int)$req['user_id'];
  $statusSql=$mysqli->real_escape_string($decision); $noteSql=$mysqli->real_escape_string($note);
  $ok=$mysqli->query("UPDATE badge_requests SET status='$statusSql', admin_note=".($note===''?'NULL':"'$noteSql'").", decided_at=UTC_TIMESTAMP(), decided_by=$adminId WHERE id=$id");
  if(!$ok) respond(['ok'=>false,'error'=>'Talep güncellenemedi: '.$mysqli->error],500);
  if($decision==='approved'){
    $mysqli->query("UPDATE users SET verified_badge=1 WHERE id=$userId");
    app_notify($mysqli,$userId,'badge_request','Rozetin onaylandı','Admin rozet talebini onayladı. Profilinde doğrulanmış rozet görünecek.','index.html?fromAdmin=1');
  }else{
    app_notify($mysqli,$userId,'badge_request','Rozet talebin onaylanmadı','Rozet talebin onaylanmadı. 3 gün sonra tekrar başvuru yapabilirsin.'.($note!==''?' Not: '.$note:''),'index.html?fromAdmin=1');
  }
  respond(['ok'=>true]);
}

if($action === 'admin_dashboard'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $count = function(string $table) use ($mysqli): int {
    if(!db_table_exists($mysqli, $table)) return 0;
    $r = @$mysqli->query("SELECT COUNT(*) c FROM `$table`");
    return (int)($r ? ($r->fetch_assoc()['c'] ?? 0) : 0);
  };
  $openReports = 0;
  if(db_table_exists($mysqli,'reports')){
    $r=@$mysqli->query("SELECT COUNT(*) c FROM reports WHERE status='open'");
    $openReports=(int)($r ? ($r->fetch_assoc()['c'] ?? 0) : 0);
  }
  $banned = db_column_exists($mysqli,'users','is_banned') ? (int)(@$mysqli->query("SELECT COUNT(*) c FROM users WHERE is_banned=1")->fetch_assoc()['c'] ?? 0) : 0;
  $muted = db_column_exists($mysqli,'users','mute_until') ? (int)(@$mysqli->query("SELECT COUNT(*) c FROM users WHERE mute_until IS NOT NULL AND mute_until > UTC_TIMESTAMP()")->fetch_assoc()['c'] ?? 0) : 0;
  respond(['ok'=>true,'stats'=>[
    'users'=>$count('users'),
    'farewells'=>$count('farewells'),
    'legacy_messages'=>$count('legacy_messages'),
    'dm_messages'=>$count('dm_messages'),
    'meetups'=>$count('meetups'),
    'reports_open'=>$openReports,
    'notifications'=>db_table_exists($mysqli,'app_notifications') ? (int)(@$mysqli->query("SELECT COUNT(*) c FROM app_notifications")->fetch_assoc()['c'] ?? 0) : 0,
    'banned'=>$banned,
    'muted'=>$muted,
  ], 'admin_password'=>admin_password_status($me)]);
}

if($action === 'admin_security'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  respond(['ok'=>true,'admin_password'=>admin_password_status($me),'email'=>$me['email'],'admin_call_allowed'=>(int)($me['admin_call_allowed'] ?? 1),'admin_dm_muted_all'=>(int)($me['admin_dm_muted_all'] ?? 0)]);
}

if($action === 'admin_update_security'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $b = json_body();
  $current = (string)($b['current_password'] ?? '');
  $newp = (string)($b['new_password'] ?? '');
  $interval = (int)($b['interval_months'] ?? 3);
  $adminCallAllowed = isset($b['admin_call_allowed']) ? ((int)$b['admin_call_allowed'] ? 1 : 0) : (int)($me['admin_call_allowed'] ?? 1);
  $adminDmMutedAll = isset($b['admin_dm_muted_all']) ? ((int)$b['admin_dm_muted_all'] ? 1 : 0) : (int)($me['admin_dm_muted_all'] ?? 0);
  if(!in_array($interval, [1,3,6], true)) respond(['ok'=>false,'error'=>'Şifre değiştirme süresi 1, 3 veya 6 ay olmalı.'],400);
  if($current === '') respond(['ok'=>false,'error'=>'Mevcut şifre gerekli.'],400);
  $globalAdminHash = read_global_admin_password_hash();
  $currentOk = password_verify($current, (string)$me['password_hash']) || ($globalAdminHash && password_verify($current, $globalAdminHash));
  if(!$currentOk) respond(['ok'=>false,'error'=>'Mevcut şifre hatalı.'],401);
  $uid = (int)$me['id'];
  if($newp !== ''){
    if($pwErr = validate_password_strength($newp, (string)$me['email'], (string)$me['full_name'])) respond(['ok'=>false,'error'=>$pwErr],400);
    $hash = password_hash($newp, PASSWORD_DEFAULT);
    write_global_admin_password_hash($hash);
    $stmt = $mysqli->prepare("UPDATE users SET password_hash=?, admin_password_interval_months=?, admin_password_changed_at=UTC_TIMESTAMP(), admin_call_allowed=?, admin_dm_muted_all=? WHERE id=? OR email='admin@mera.com'");
    $stmt->bind_param('siiii', $hash, $interval, $adminCallAllowed, $adminDmMutedAll, $uid);
  }else{
    $stmt = $mysqli->prepare("UPDATE users SET admin_password_interval_months=?, admin_call_allowed=?, admin_dm_muted_all=? WHERE id=?");
    $stmt->bind_param('iiii', $interval, $adminCallAllowed, $adminDmMutedAll, $uid);
  }
  if(!$stmt || !$stmt->execute()) respond(['ok'=>false,'error'=>'Güvenlik ayarı güncellenemedi.'],500);
  $fresh = $mysqli->query("SELECT * FROM users WHERE id={$uid} LIMIT 1")->fetch_assoc();
  respond(['ok'=>true,'admin_password'=>admin_password_status($fresh ?: $me),'admin_call_allowed'=>(int)(($fresh['admin_call_allowed'] ?? $adminCallAllowed) ?? 1),'admin_dm_muted_all'=>(int)(($fresh['admin_dm_muted_all'] ?? $adminDmMutedAll) ?? 0)]);
}

if($action === 'admin_update_self_name'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $b = json_body();
  $name = trim((string)($b['full_name'] ?? ''));
  if($name==='') respond(['ok'=>false,'error'=>'Admin görünen adı boş olamaz.'],400);
  if(mb_strlen($name,'UTF-8')>80) respond(['ok'=>false,'error'=>'Admin görünen adı çok uzun.'],400);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("UPDATE users SET full_name=? WHERE id=?");
  $stmt->bind_param('si',$name,$uid);
  $stmt->execute();
  $u = $mysqli->query("SELECT * FROM users WHERE id=$uid LIMIT 1")->fetch_assoc();
  respond(['ok'=>true,'user'=>safe_user($u ?: $me)]);
}

if($action === 'admin_users'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $q = trim((string)($_GET['q'] ?? ''));
  $limit = max(1, min(200, (int)($_GET['limit'] ?? 80)));
  $where = '1=1';
  if($q !== ''){
    $esc = $mysqli->real_escape_string($q);
    $where .= " AND (full_name LIKE '%{$esc}%' OR email LIKE '%{$esc}%' OR school LIKE '%{$esc}%')";
  }
  $fields = "id,full_name,email,school,class_label,grad_year,is_admin,admin_until,created_at";
  if(db_column_exists($mysqli,'users','is_banned')) $fields .= ",is_banned"; else $fields .= ",0 AS is_banned";
  if(db_column_exists($mysqli,'users','mute_until')) $fields .= ",mute_until"; else $fields .= ",NULL AS mute_until";
  if(db_column_exists($mysqli,'users','verified_badge')) $fields .= ",verified_badge"; else $fields .= ",0 AS verified_badge";
  $res = $mysqli->query("SELECT {$fields} FROM users WHERE {$where} ORDER BY id DESC LIMIT {$limit}");
  $items=[];
  while($res && ($r=$res->fetch_assoc())){
    $items[]=[
      'id'=>(int)$r['id'],'full_name'=>$r['full_name'],'email'=>$r['email'],'school'=>$r['school'],'class_label'=>$r['class_label'],'grad_year'=>$r['grad_year']!==null?(int)$r['grad_year']:null,
      'is_admin'=>(int)$r['is_admin'],'admin_until'=>$r['admin_until'] ?? null,'is_banned'=>(int)($r['is_banned'] ?? 0),'mute_until'=>$r['mute_until'] ?? null,'verified_badge'=>(int)($r['verified_badge'] ?? 0),'created_at'=>$r['created_at']
    ];
  }
  respond(['ok'=>true,'users'=>$items]);
}

if($action === 'admin_user_update'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN is_banned TINYINT(1) NOT NULL DEFAULT 0");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN mute_until DATETIME NULL DEFAULT NULL");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN verified_badge TINYINT(1) NOT NULL DEFAULT 0");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN admin_until DATETIME NULL DEFAULT NULL");
  $b = json_body();
  $user_id = (int)($b['user_id'] ?? 0);
  if($user_id <= 0) respond(['ok'=>false,'error'=>'Kullanıcı seçilmedi.'],400);
  if($user_id === (int)$me['id'] && isset($b['is_banned']) && (int)$b['is_banned']===1) respond(['ok'=>false,'error'=>'Kendi admin hesabını banlayamazsın.'],400);
  $target = @$mysqli->query("SELECT id,is_admin FROM users WHERE id={$user_id} LIMIT 1")->fetch_assoc();
  if(!$target) respond(['ok'=>false,'error'=>'Kullanıcı bulunamadı.'],404);
  $sets=[];
  if(isset($b['full_name'])){
    $newName=trim((string)$b['full_name']);
    if($newName==='') respond(['ok'=>false,'error'=>'Kullanıcı adı boş olamaz.'],400);
    if(mb_strlen($newName,'UTF-8')>80) respond(['ok'=>false,'error'=>'Kullanıcı adı çok uzun.'],400);
    $sets[] = "full_name='".$mysqli->real_escape_string($newName)."'";
  }
  if(isset($b['is_banned'])) $sets[] = 'is_banned=' . ((int)$b['is_banned']===1 ? '1':'0');
  if(isset($b['is_admin'])){
    $sets[] = 'is_admin=' . ((int)$b['is_admin']===1 ? '1':'0');
    $sets[] = 'admin_until=NULL';
  }
  if(isset($b['temp_admin_minutes'])){
    $mins = max(1, min(525600, (int)$b['temp_admin_minutes']));
    if($user_id === (int)$me['id']) respond(['ok'=>false,'error'=>'Kendi hesabına geçici admin süresi veremezsin.'],400);
    $sets[] = 'is_admin=1';
    $sets[] = "admin_until=DATE_ADD(UTC_TIMESTAMP(), INTERVAL {$mins} MINUTE)";
  }
  if(isset($b['verified_badge'])) $sets[] = 'verified_badge=' . ((int)$b['verified_badge']===1 ? '1':'0');
  if(isset($b['mute_minutes'])){
    $mins = max(0, min(525600, (int)$b['mute_minutes']));
    if($mins > 0) $sets[] = "mute_until=DATE_ADD(UTC_TIMESTAMP(), INTERVAL {$mins} MINUTE)";
    else $sets[] = "mute_until=NULL";
  }
  if(!$sets) respond(['ok'=>false,'error'=>'Güncellenecek işlem yok.'],400);
  $ok = $mysqli->query("UPDATE users SET ".implode(',', $sets)." WHERE id={$user_id}");
  if(!$ok) respond(['ok'=>false,'error'=>'Kullanıcı güncellenemedi: '.$mysqli->error],500);
  if(isset($b['is_banned']) && (int)$b['is_banned']===1){ @${"mysqli"}->query("DELETE FROM auth_tokens WHERE user_id={$user_id}"); }
  respond(['ok'=>true]);
}

if($action === 'admin_badwords_get'){
  require_admin($mysqli);
  admin_ensure_badwords_storage($mysqli);
  $words = admin_badwords_list($mysqli);
  respond(['ok'=>true,'words'=>$words,'count'=>count($words)]);
}

if($action === 'admin_badwords_add'){
  require_admin($mysqli);
  admin_ensure_badwords_storage($mysqli);
  $b=json_body();
  $word=admin_normalize_badword_value((string)($b['word'] ?? ''));
  if($word==='') respond(['ok'=>false,'error'=>'Kelime gerekli.'],400);
  if(mb_strlen($word,'UTF-8')>60) respond(['ok'=>false,'error'=>'Kelime çok uzun.'],400);
  if($stmt=$mysqli->prepare("INSERT IGNORE INTO admin_badwords_custom(word) VALUES(?)")){ $stmt->bind_param('s',$word); @$stmt->execute(); }
  if($stmt=$mysqli->prepare("DELETE FROM admin_badwords_removed WHERE word=?")){ $stmt->bind_param('s',$word); @$stmt->execute(); }
  $words=admin_badwords_list($mysqli);
  if(!in_array($word,$words,true)) $words[]=$word;
  sort($words, SORT_LOCALE_STRING);
  admin_badwords_write_file($words);
  respond(['ok'=>true,'words'=>$words,'count'=>count($words),'message'=>'Kelime listeye eklendi.']);
}

if($action === 'admin_badwords_delete'){
  require_admin($mysqli);
  admin_ensure_badwords_storage($mysqli);
  $b=json_body();
  $word=admin_normalize_badword_value((string)($b['word'] ?? ''));
  if($word==='') respond(['ok'=>false,'error'=>'Kelime gerekli.'],400);
  if($stmt=$mysqli->prepare("INSERT IGNORE INTO admin_badwords_removed(word) VALUES(?)")){ $stmt->bind_param('s',$word); @$stmt->execute(); }
  if($stmt=$mysqli->prepare("DELETE FROM admin_badwords_custom WHERE word=?")){ $stmt->bind_param('s',$word); @$stmt->execute(); }
  $words=array_values(array_filter(admin_badwords_list($mysqli), fn($w)=>$w!==$word));
  admin_badwords_write_file($words);
  respond(['ok'=>true,'words'=>$words,'count'=>count($words),'message'=>'Kelime listeden kaldırıldı.']);
}

if($action === 'admin_badword_logs'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $res = $mysqli->query("SELECT l.*, u.full_name FROM badword_logs l JOIN users u ON u.id=l.user_id ORDER BY l.id DESC LIMIT 200");
  $items=[];
  while($r=$res->fetch_assoc()){
    $items[]=[
      'id'=>(int)$r['id'],
      'user_id'=>(int)$r['user_id'],
      'full_name'=>$r['full_name'],
      'context'=>$r['context'],
      'target_id'=>$r['target_id']!==null?(int)$r['target_id']:null,
      'original_text'=>$r['original_text'],
      'censored_text'=>$r['censored_text'],
      'created_at'=>$r['created_at'],
    ];
  }
  respond(['ok'=>true,'logs'=>$items]);
}


if($action === 'admin_content'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $type = trim((string)($_GET['type'] ?? 'gossip'));
  $limit = max(1, min(200, (int)($_GET['limit'] ?? 80)));
  $items=[];
  if($type === 'legacy'){
    $res = $mysqli->query("SELECT m.id,m.user_id,m.message,m.reply_to,m.created_at,u.full_name,u.school,u.grad_year FROM legacy_messages m JOIN users u ON u.id=m.user_id ORDER BY m.id DESC LIMIT {$limit}");
    while($res && ($r=$res->fetch_assoc())) $items[]=['type'=>'legacy','id'=>(int)$r['id'],'user_id'=>(int)$r['user_id'],'author'=>$r['full_name'],'school'=>$r['school'],'grad_year'=>$r['grad_year']!==null?(int)$r['grad_year']:null,'title'=>'Eski Toprak Mesajı','body'=>$r['message'],'meta'=>$r['reply_to'] ? 'Yanıt: #'.$r['reply_to'] : 'Genel sohbet','created_at'=>$r['created_at']];
  } elseif($type === 'polls'){
    $res = $mysqli->query("SELECT p.id,p.user_id,p.question,p.created_at,u.full_name,u.school,u.grad_year FROM polls p JOIN users u ON u.id=p.user_id ORDER BY p.id DESC LIMIT {$limit}");
    while($res && ($r=$res->fetch_assoc())){
      $pid=(int)$r['id']; $opts=[];
      $or=$mysqli->query("SELECT o.id,o.option_text,COUNT(v.id) votes FROM poll_options o LEFT JOIN poll_votes v ON v.option_id=o.id WHERE o.poll_id=$pid GROUP BY o.id,o.option_text ORDER BY o.id ASC");
      while($or && ($o=$or->fetch_assoc())) $opts[]=$o['option_text'].' ('.(int)$o['votes'].')';
      $items[]=['type'=>'poll','id'=>$pid,'user_id'=>(int)$r['user_id'],'author'=>$r['full_name'],'school'=>$r['school'],'grad_year'=>$r['grad_year']!==null?(int)$r['grad_year']:null,'title'=>$r['question'],'body'=>implode(' • ', $opts),'meta'=>'Anket','created_at'=>$r['created_at']];
    }
  } else {
    $res = $mysqli->query("SELECT p.id,p.user_id,p.content,p.visibility,p.category,p.school,p.created_at,u.full_name,u.grad_year FROM gossip_posts p JOIN users u ON u.id=p.user_id ORDER BY p.id DESC LIMIT {$limit}");
    while($res && ($r=$res->fetch_assoc())) $items[]=['type'=>'gossip','id'=>(int)$r['id'],'user_id'=>(int)$r['user_id'],'author'=>$r['full_name'],'school'=>$r['school'],'grad_year'=>$r['grad_year']!==null?(int)$r['grad_year']:null,'title'=>'Dedikodu • '.($r['visibility']==='school'?'Okul':'Genel').' • '.$r['category'],'body'=>$r['content'],'meta'=>$r['visibility']==='school'?'Sadece okul':'Genel','created_at'=>$r['created_at']];
  }
  respond(['ok'=>true,'items'=>$items,'type'=>$type]);
}

if($action === 'admin_reports'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $status = trim((string)($_GET['status'] ?? 'open'));
  $stmt = $mysqli->prepare("SELECT r.*, u.full_name AS reporter_name, ru.full_name AS reported_name, (SELECT COUNT(*) FROM reports rr WHERE rr.reported_user_id=r.reported_user_id AND rr.status IN ('open','closed')) AS reported_report_count FROM reports r JOIN users u ON u.id=r.reporter_id LEFT JOIN users ru ON ru.id=r.reported_user_id WHERE r.status=? ORDER BY r.id DESC LIMIT 200");
  $stmt->bind_param("s",$status);
  $stmt->execute();
  $res=$stmt->get_result();
  $items=[];
  while($r=$res->fetch_assoc()){
    $items[]=[
      'id'=>(int)$r['id'],
      'reporter_id'=>(int)$r['reporter_id'],
      'reporter_name'=>$r['reporter_name'],
      'target_type'=>$r['target_type'],
      'target_id'=>(int)$r['target_id'],
      'reported_user_id'=>isset($r['reported_user_id']) && $r['reported_user_id'] !== null ? (int)$r['reported_user_id'] : null,
      'reported_name'=>$r['reported_name'] ?? null,
      'reason'=>$r['reason'],
      'status'=>$r['status'],
      'created_at'=>$r['created_at'],
      'updated_at'=>$r['updated_at'] ?? null,
      'handled_at'=>$r['handled_at'] ?? null,
      'resolution_note'=>$r['resolution_note'] ?? null,
      'reported_report_count'=>(int)($r['reported_report_count'] ?? 0),
    ];
  }
  respond(['ok'=>true,'reports'=>$items]);
}

if($action === 'admin_report_close'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $b=json_body();
  $id=(int)($b['id']??0);
  $note=trim((string)($b['resolution_note'] ?? 'Problem çözüldü.'));
  if($id<=0) respond(['ok'=>false,'error'=>'id gerekli'],400);
  if($note==='') $note='Problem çözüldü.';
  $stmt=$mysqli->prepare("SELECT * FROM reports WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$id); $stmt->execute(); $r=$stmt->get_result()->fetch_assoc();
  if(!$r) respond(['ok'=>false,'error'=>'Rapor bulunamadı.'],404);
  $uid=(int)$me['id'];
  $stmt=$mysqli->prepare("UPDATE reports SET status='closed', handled_by=?, handled_at=UTC_TIMESTAMP(), resolution_note=? WHERE id=?");
  $stmt->bind_param("isi",$uid,$note,$id);
  $stmt->execute();
  $reporter=(int)$r['reporter_id'];
  app_notify($mysqli,$reporter,'report_resolved','Şikayetiniz çözüldü','Şikayet ettiğiniz konu düzeltilmiştir. Admin notu: '.$note,'profile');
  $reported = isset($r['reported_user_id']) && $r['reported_user_id'] !== null ? (int)$r['reported_user_id'] : 0;
  if($reported>0 && $reported!==$reporter){
    $cnt=(int)(@$mysqli->query("SELECT COUNT(*) c FROM reports WHERE reported_user_id=$reported AND status IN ('open','closed')")->fetch_assoc()['c'] ?? 1);
    $body='Hakkınızda yapılan bir şikayet incelendi ve problem çözüldü. Lütfen okul topluluğuna uygun davranın. Aynı sorun tekrar ederse hesabınız banlanabilir veya birkaç gün uygulamayı kullanamayabilirsiniz.';
    if($cnt>=3) $body.=' Bu konu birkaç kez tekrarlandığı için sonraki ihlallerde hesabınız kalıcı olarak uygulamayı kullanamayabilir.';
    app_notify($mysqli,$reported,'report_warning','Davranış uyarısı',$body,'profile');
  }
  respond(['ok'=>true]);
}



if($action === 'admin_notify_user'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $b=json_body();
  $user_id=(int)($b['user_id'] ?? 0);
  $title=trim((string)($b['title'] ?? 'Admin mesajı'));
  $body=trim((string)($b['body'] ?? ''));
  if($user_id<=0) respond(['ok'=>false,'error'=>'Kullanıcı seçilmedi.'],400);
  if($body==='') respond(['ok'=>false,'error'=>'Mesaj metni gerekli.'],400);
  if(mb_strlen($title,'UTF-8')>190) $title=mb_substr($title,0,190,'UTF-8');
  $u=@$mysqli->query("SELECT id FROM users WHERE id=$user_id LIMIT 1")->fetch_assoc();
  if(!$u) respond(['ok'=>false,'error'=>'Kullanıcı bulunamadı.'],404);
  app_notify($mysqli,$user_id,'admin_message',$title,$body,'profile');
  respond(['ok'=>true,'message'=>'Mesaj kullanıcıya gönderildi.']);
}

if($action === 'admin_delete'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $b=json_body();
  $type=trim((string)($b['target_type']??''));
  $id=(int)($b['target_id']??0);
  if($type===''||$id<=0) respond(['ok'=>false,'error'=>'target_type,target_id gerekli'],400);

  if($type==='farewell'){
    $mysqli->query("DELETE FROM farewells WHERE id=$id");
  }elseif($type==='legacy'){
    $mysqli->query("DELETE FROM legacy_messages WHERE id=$id");
  }elseif($type==='gossip_post'){
    $mysqli->query("DELETE FROM gossip_posts WHERE id=$id");
  }elseif($type==='gossip_comment'){
    $mysqli->query("DELETE FROM gossip_comments WHERE id=$id");
  }elseif($type==='dm_message'){
    // soft-delete
    $uid=(int)$me['id'];
    $stmt=$mysqli->prepare("UPDATE dm_messages SET deleted_at=NOW(), deleted_by_admin=? WHERE id=?");
    $stmt->bind_param("ii",$uid,$id);
    @$stmt->execute();
  }else{
    respond(['ok'=>false,'error'=>'Bilinmeyen target_type'],400);
  }
  respond(['ok'=>true]);
}

if($action === 'admin_sanction'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN is_banned TINYINT(1) NOT NULL DEFAULT 0");
  @${"mysqli"}->query("ALTER TABLE users ADD COLUMN mute_until DATETIME NULL DEFAULT NULL");
  $b=json_body();
  $user_id=(int)($b['user_id']??0);
  $ban=(int)($b['ban']??0);
  $mute_minutes=(int)($b['mute_minutes']??0);
  if($user_id<=0) respond(['ok'=>false,'error'=>'user_id gerekli'],400);
  if($user_id === (int)$me['id'] && $ban===1) respond(['ok'=>false,'error'=>'Kendi admin hesabını banlayamazsın.'],400);
  $mute_until = null;
  if($mute_minutes>0){
    $mute_minutes = min(525600, $mute_minutes);
    $mute_until = (new DateTime('now', new DateTimeZone('UTC')))->modify("+{$mute_minutes} minutes")->format('Y-m-d H:i:s');
  }
  $stmt=$mysqli->prepare("UPDATE users SET is_banned=?, mute_until=? WHERE id=?");
  if(!$stmt) respond(['ok'=>false,'error'=>'Ceza sorgusu hazırlanamadı: '.$mysqli->error],500);
  $stmt->bind_param("isi",$ban,$mute_until,$user_id);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Ceza uygulanamadı: '.$stmt->error],500);
  if($ban===1){ @${"mysqli"}->query("DELETE FROM auth_tokens WHERE user_id={$user_id}"); }
  respond(['ok'=>true]);
}

if($action === 'admin_reset_quickmatch_lock'){
  $me = require_auth($mysqli);
  if((int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $b=json_body();
  $user_id=(int)($b['user_id']??0);
  if($user_id<=0) respond(['ok'=>false,'error'=>'user_id gerekli'],400);
  // if schema has reject_count/locked_until in quick_match_stats, clear it
  @$mysqli->query("UPDATE quick_match_stats SET reject_count=0, locked_until=NULL WHERE user_id=$user_id");
  respond(['ok'=>true]);
}



if($action === 'online_ping'){
  $me = require_auth($mysqli);
  $uid=(int)$me['id'];
  $stmt=$mysqli->prepare("INSERT INTO online_users(user_id,last_seen) VALUES(?,NOW()) ON DUPLICATE KEY UPDATE last_seen=NOW()");
  $stmt->bind_param("i",$uid);
  $stmt->execute();
  respond(['ok'=>true]);
}

if($action === 'online_list'){
  $me = require_auth($mysqli);
  $res = $mysqli->query("SELECT u.id,u.full_name,u.school,u.grad_year,u.photo_url FROM online_users o JOIN users u ON u.id=o.user_id WHERE o.last_seen >= (NOW() - INTERVAL 2 MINUTE) ORDER BY o.last_seen DESC LIMIT 50");
  $items=[];
  while($r=$res->fetch_assoc()){
    $items[] = safe_user($r);
  }
  respond(['ok'=>true,'users'=>$items]);
}

if($action === 'gossip_trending'){
  $me = require_auth($mysqli);
  $mode = trim((string)($_GET['mode'] ?? 'all')); // all|school
  $uid=(int)$me['id'];
  $mySchool = $me['school'] ?? null;

  $where = "1=1";
  $params=[]; $types="";
  if($mode === 'school'){
    if(!$mySchool) respond(['ok'=>false,'error'=>'Profilinde okul yok.'],400);
    $where = "(p.visibility='school' AND p.school=?)";
    $types="s"; $params=[$mySchool];
  }else{
    // can see global + own school posts
    if($mySchool){
      $where = "(p.visibility='global' OR (p.visibility='school' AND p.school=?))";
      $types="s"; $params=[$mySchool];
    }else{
      $where = "(p.visibility='global')";
    }
  }

  $sql = "SELECT p.*, u.full_name, u.photo_url,
    (SELECT COUNT(*) FROM gossip_reactions r WHERE r.target_type='post' AND r.target_id=p.id) AS react_count
    FROM gossip_posts p JOIN users u ON u.id=p.user_id
    WHERE $where
    ORDER BY react_count DESC, p.id DESC
    LIMIT 20";
  $stmt=$mysqli->prepare($sql);
  if($types){
    $stmt->bind_param($types, ...$params);
  }
  $stmt->execute();
  $res=$stmt->get_result();
  $items=[];
  while($r=$res->fetch_assoc()){
    $items[]=[
      'id'=>(int)$r['id'],
      'user'=>safe_user(['id'=>$r['user_id'],'full_name'=>$r['full_name'],'school'=>$r['school'],'grad_year'=>$r['grad_year'],'photo_url'=>$r['photo_url']]),
      'visibility'=>$r['visibility'],
      'content'=>$r['content'],
      'created_at'=>$r['created_at'],
      'react_count'=>(int)$r['react_count'],
    ];
  }
  respond(['ok'=>true,'posts'=>$items]);
}

if($action === 'legacy_delete'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  if($id<=0) respond(['ok'=>false,'error'=>'id gerekli'],400);
  $stmt=$mysqli->prepare("SELECT user_id FROM legacy_messages WHERE id=?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $row=$stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Bulunamadı'],404);
  $owner=(int)$row['user_id'];
  if($owner !== (int)$me['id'] && (int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $mysqli->query("DELETE FROM legacy_messages WHERE id=$id");
  respond(['ok'=>true]);
}

if($action === 'poll_delete'){
  $me = require_auth($mysqli);
  $b = json_body();
  $id = (int)($b['id'] ?? 0);
  if($id<=0) respond(['ok'=>false,'error'=>'id gerekli'],400);
  $stmt=$mysqli->prepare("SELECT user_id FROM polls WHERE id=? LIMIT 1");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $row=$stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Bulunamadı'],404);
  $owner=(int)$row['user_id'];
  if($owner !== (int)$me['id'] && (int)$me['is_admin']!==1) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $stmt=$mysqli->prepare("DELETE FROM polls WHERE id=?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  respond(['ok'=>true]);
}


function nova_seed_rooms(mysqli $mysqli): void {
  if(!db_table_exists($mysqli, 'orbit_rooms')) return;
  $seed = [
    ['software','Yazılım','Kod, proje, araçlar ve teknik yardım',10,0],
    ['prep','Üniversite Hazırlık','Sınav, bölüm ve tercih konuşmaları',20,0],
    ['internship','Staj / İş','Staj, iş, ekip ve fırsat paylaşımları',30,0],
    ['gaming','Oyun','Oyun buluşmaları ve takım kurma',40,0],
    ['sports','Spor','Halı saha, yürüyüş ve spor planları',50,0],
    ['music','Müzik','Şarkı, konser ve dönem playlist sohbeti',60,0],
    ['same-city','Aynı Şehirdekiler','Aynı şehirde olan mezunların odası',70,1],
  ];
  $stmt = $mysqli->prepare("INSERT IGNORE INTO orbit_rooms(slug,title,description,sort_order,auto_city) VALUES(?,?,?,?,?)");
  if(!$stmt) return;
  foreach($seed as $r){
    [$slug,$title,$desc,$sort,$auto] = $r;
    $stmt->bind_param('sssii', $slug,$title,$desc,$sort,$auto);
    $stmt->execute();
  }
}

function nova_stage_label(?string $stage): string {
  switch((string)$stage){
    case 'university': return 'Üniversiteye geçti';
    case 'internship': return 'Staj arıyor';
    case 'work': return 'İşte';
    case 'circle': return 'Aynı çevrede';
    default: return 'Belirtilmedi';
  }
}

function nova_room_join(mysqli $mysqli, int $roomId, int $uid): void {
  if(!db_table_exists($mysqli, 'orbit_room_members')) return;
  $stmt = $mysqli->prepare("INSERT IGNORE INTO orbit_room_members(room_id,user_id,role) VALUES(?,?,'member')");
  if($stmt){ $stmt->bind_param('ii', $roomId, $uid); $stmt->execute(); }
}

function nova_room_payload(mysqli $mysqli, array $room, int $uid): array {
  $rid = (int)$room['id'];
  if((int)($room['auto_city'] ?? 0) === 1 && !empty($room['city'])){
    $q = $mysqli->prepare("SELECT u.id, u.full_name, u.photo_url FROM users u WHERE u.city=? ORDER BY u.full_name ASC LIMIT 12");
    if($q){
      $city = (string)$room['city'];
      $q->bind_param('s', $city);
      $q->execute();
      $res = $q->get_result();
      while($u = $res->fetch_assoc()){
        nova_room_join($mysqli, $rid, (int)$u['id']);
      }
    }
  }
  $memberCount = 0; $joined = false;
  if(db_table_exists($mysqli, 'orbit_room_members')){
    $memberCount = (int)(@$mysqli->query("SELECT COUNT(*) c FROM orbit_room_members WHERE room_id=$rid")->fetch_assoc()['c'] ?? 0);
    $joined = (int)(@$mysqli->query("SELECT COUNT(*) c FROM orbit_room_members WHERE room_id=$rid AND user_id=$uid")->fetch_assoc()['c'] ?? 0) > 0;
  }
  return [
    'id'=>$rid,
    'slug'=>$room['slug'],
    'title'=>$room['title'],
    'description'=>$room['description'],
    'member_count'=>$memberCount,
    'joined'=>$joined,
    'auto_city'=>(int)($room['auto_city'] ?? 0) === 1,
    'city'=>$room['city'] ?? null,
  ];
}

function dm_group_extras_payload(mysqli $mysqli, int $groupId, int $uid): array {
  $member = require_dm_group_member($mysqli, $groupId, $uid);
  $role = $member['role'] ?? 'member';
  $album = [];
  if(db_table_exists($mysqli, 'dm_group_messages')){
    $res = @$mysqli->query("SELECT id, photo_url, created_at FROM dm_group_messages WHERE group_id=$groupId AND photo_url IS NOT NULL AND deleted_at IS NULL ORDER BY id DESC LIMIT 18");
    while($res && ($r = $res->fetch_assoc())){
      $album[] = ['id'=>(int)$r['id'], 'photo_url'=>upload_url_exists($r['photo_url'] ?? null), 'created_at'=>$r['created_at']];
    }
  }
  $polls = [];
  if(db_table_exists($mysqli, 'dm_group_polls')){
    $res = @$mysqli->query("SELECT p.id, p.question, p.status, p.created_at, u.full_name FROM dm_group_polls p JOIN users u ON u.id=p.user_id WHERE p.group_id=$groupId ORDER BY p.id DESC LIMIT 6");
    while($res && ($p = $res->fetch_assoc())){
      $pid = (int)$p['id'];
      $options = [];
      $ores = @$mysqli->query("SELECT o.id, o.option_text, (SELECT COUNT(*) FROM dm_group_poll_votes v WHERE v.option_id=o.id) AS vote_count, (SELECT COUNT(*) FROM dm_group_poll_votes v2 WHERE v2.poll_id=$pid AND v2.user_id=$uid AND v2.option_id=o.id) AS voted_me FROM dm_group_poll_options o WHERE o.poll_id=$pid ORDER BY o.id ASC");
      while($ores && ($o = $ores->fetch_assoc())){
        $options[] = ['id'=>(int)$o['id'],'text'=>$o['option_text'],'vote_count'=>(int)$o['vote_count'],'voted_me'=>(int)$o['voted_me']>0];
      }
      $polls[] = ['id'=>$pid,'question'=>$p['question'],'status'=>$p['status'],'created_at'=>$p['created_at'],'owner_name'=>$p['full_name'],'options'=>$options];
    }
  }
  $events = [];
  if(db_table_exists($mysqli, 'dm_group_events')){
    $res = @$mysqli->query("SELECT e.*, u.full_name FROM dm_group_events e JOIN users u ON u.id=e.user_id WHERE e.group_id=$groupId ORDER BY e.event_at ASC, e.id DESC LIMIT 5");
    while($res && ($e = $res->fetch_assoc())){
      $events[] = ['id'=>(int)$e['id'],'title'=>$e['title'],'event_at'=>$e['event_at'],'location'=>$e['location'],'note_body'=>$e['note_body'],'owner_name'=>$e['full_name']];
    }
  }
  $members = [];
  if(db_table_exists($mysqli, 'dm_group_members')){
    $res = @$mysqli->query("SELECT gm.user_id, gm.role, u.full_name, u.photo_url FROM dm_group_members gm JOIN users u ON u.id=gm.user_id WHERE gm.group_id=$groupId ORDER BY FIELD(gm.role,'owner','admin','member'), u.full_name ASC LIMIT 24");
    while($res && ($m = $res->fetch_assoc())){
      $members[] = ['id'=>(int)$m['user_id'],'role'=>$m['role'],'full_name'=>$m['full_name'],'photo_url'=>upload_url_exists($m['photo_url'] ?? null)];
    }
  }
  return ['role'=>$role,'album'=>$album,'polls'=>$polls,'events'=>$events,'members'=>$members];
}

if($action === 'time_capsule_create'){
  $me = require_auth($mysqli); $b = json_body(); $uid = (int)$me['id'];
  $title = trim((string)($b['title'] ?? '')); $body = trim((string)($b['body'] ?? '')); $openAt = str_replace('T',' ', trim((string)($b['open_at'] ?? '')));
  if($title==='' || $body==='' || $openAt==='') respond(['ok'=>false,'error'=>'Başlık, not ve tarih gerekli.'],400);
  $stmt = $mysqli->prepare("INSERT INTO time_capsules(user_id,title,body,open_at,status) VALUES(?,?,?,?, 'locked')");
  $stmt->bind_param('isss',$uid,$title,$body,$openAt); $stmt->execute();
  respond(['ok'=>true,'id'=>(int)$stmt->insert_id]);
}

if($action === 'time_capsules_list'){
  $me = require_auth($mysqli); $uid = (int)$me['id'];
  $res = @$mysqli->query("SELECT id,title,body,open_at,created_at, CASE WHEN open_at<=NOW() THEN 1 ELSE 0 END AS can_open FROM time_capsules WHERE user_id=$uid ORDER BY open_at ASC, id DESC LIMIT 100");
  $items=[];
  while($res && ($r=$res->fetch_assoc())){
    $items[] = ['id'=>(int)$r['id'],'title'=>$r['title'],'body'=>(int)$r['can_open']===1 ? $r['body'] : null,'preview'=>(int)$r['can_open']===1 ? mb_substr((string)$r['body'],0,160) : 'Açılma tarihini bekliyor.','open_at'=>$r['open_at'],'created_at'=>$r['created_at'],'can_open'=>(int)$r['can_open']===1];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'time_capsule_open'){
  $me = require_auth($mysqli); $uid = (int)$me['id']; $id=(int)($_GET['id'] ?? 0);
  $stmt = $mysqli->prepare("SELECT id,title,body,open_at FROM time_capsules WHERE id=? AND user_id=? LIMIT 1");
  $stmt->bind_param('ii',$id,$uid); $stmt->execute(); $row=$stmt->get_result()->fetch_assoc();
  if(!$row) respond(['ok'=>false,'error'=>'Kapsül bulunamadı.'],404);
  if(strtotime((string)$row['open_at']) > time()) respond(['ok'=>false,'error'=>'Bu kapsül henüz açılamaz.'],400);
  respond(['ok'=>true,'item'=>$row]);
}

if($action === 'nova_map'){
  $me = require_auth($mysqli);
  $school = trim((string)($_GET['school'] ?? ''));
  $grad = trim((string)($_GET['grad_year'] ?? ''));
  $city = trim((string)($_GET['city'] ?? ''));
  $stage = trim((string)($_GET['stage'] ?? ''));
  $where = ['u.id<>'.(int)$me['id']];
  if($school!=='') $where[] = "u.school='".$mysqli->real_escape_string($school)."'";
  if($grad!=='') $where[] = "u.grad_year=".(int)$grad;
  if($city!=='') $where[] = "u.city='".$mysqli->real_escape_string($city)."'";
  if($stage!=='') $where[] = "u.current_stage='".$mysqli->real_escape_string($stage)."'";
  $sql = "SELECT u.*, (SELECT COUNT(*) FROM follows f WHERE f.following_id=u.id) AS follower_count FROM users u WHERE ".implode(' AND ', $where)." ORDER BY u.full_name ASC LIMIT 120";
  $res = @$mysqli->query($sql);
  $items=[]; $summary=['total'=>0,'cities'=>0,'university'=>0,'internship'=>0,'work'=>0,'circle'=>0]; $cities=[];
  while($res && ($u=$res->fetch_assoc())){
    if((int)$u['id'] === (int)$me['id']) continue;
    $safe = safe_user($u);
    $safe['city'] = $u['city'] ?? null;
    $safe['current_stage'] = $u['current_stage'] ?? null;
    $safe['follower_count'] = (int)($u['follower_count'] ?? 0);
    $items[] = $safe;
    $summary['total']++;
    if(!empty($u['city'])) $cities[(string)$u['city']] = true;
    $st=(string)($u['current_stage'] ?? ''); if(isset($summary[$st])) $summary[$st]++;
  }
  $summary['cities'] = count($cities);
  respond(['ok'=>true,'items'=>$items,'summary'=>$summary]);
}

if($action === 'nova_rooms_list'){
  $me = require_auth($mysqli); nova_seed_rooms($mysqli); $uid=(int)$me['id'];
  $city = trim((string)($me['city'] ?? ''));
  $res = @$mysqli->query("SELECT * FROM orbit_rooms ORDER BY sort_order ASC, id ASC");
  $rooms=[];
  while($res && ($r=$res->fetch_assoc())){
    if((int)$r['auto_city']===1 && $city==='') continue;
    $r['city'] = $city;
    $rooms[] = nova_room_payload($mysqli, $r, $uid);
  }
  $roomId = (int)($_GET['room_id'] ?? ($rooms[0]['id'] ?? 0));
  $posts=[];
  if($roomId>0){
    nova_room_join($mysqli, $roomId, $uid);
    $stmt = $mysqli->prepare("SELECT p.id, p.body, p.created_at, u.full_name, u.photo_url FROM orbit_room_posts p JOIN users u ON u.id=p.user_id WHERE p.room_id=? ORDER BY p.id DESC LIMIT 40");
    if($stmt){ $stmt->bind_param('i',$roomId); $stmt->execute(); $rs=$stmt->get_result();
      while($rs && ($r=$rs->fetch_assoc())) $posts[] = ['id'=>(int)$r['id'],'body'=>$r['body'],'created_at'=>$r['created_at'],'user'=>safe_user(['id'=>0,'full_name'=>$r['full_name'],'photo_url'=>$r['photo_url']])];
    }
  }
  respond(['ok'=>true,'rooms'=>$rooms,'active_room_id'=>$roomId,'posts'=>$posts]);
}

if($action === 'nova_room_post'){
  $me = require_auth($mysqli); $b = json_body(); $uid=(int)$me['id']; $roomId=(int)($b['room_id'] ?? 0); $body=trim((string)($b['body'] ?? ''));
  if($roomId<=0 || $body==='') respond(['ok'=>false,'error'=>'Oda ve mesaj gerekli.'],400);
  nova_room_join($mysqli, $roomId, $uid);
  $stmt = $mysqli->prepare("INSERT INTO orbit_room_posts(room_id,user_id,body) VALUES(?,?,?)");
  $stmt->bind_param('iis',$roomId,$uid,$body); $stmt->execute();
  respond(['ok'=>true]);
}

if($action === 'nova_room_create_group'){
  $me = require_auth($mysqli); $b = json_body(); $uid=(int)$me['id']; $roomId=(int)($b['room_id'] ?? 0);
  $stmt = $mysqli->prepare("SELECT * FROM orbit_rooms WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$roomId); $stmt->execute(); $room=$stmt->get_result()->fetch_assoc();
  if(!$room) respond(['ok'=>false,'error'=>'Oda bulunamadı.'],404);
  $memberIds=[];
  $q = @$mysqli->query("SELECT user_id FROM orbit_room_members WHERE room_id=$roomId ORDER BY joined_at ASC LIMIT 8");
  while($q && ($r=$q->fetch_assoc())) $memberIds[] = (int)$r['user_id'];
  if(!in_array($uid, $memberIds, true)) array_unshift($memberIds, $uid);
  $memberIds = array_values(array_unique(array_filter($memberIds)));
  if(count($memberIds) < 3) respond(['ok'=>false,'error'=>'Grup kurmak için odada en az 3 kişi olmalı.'],400);
  $title = 'Oda: '.($room['title'] ?? 'Grup');
  $desc = 'MEra Nova odasından oluşturuldu.';
  $spotify = null; $photo = null;
  $stmt = $mysqli->prepare("INSERT INTO dm_groups(owner_id,title,description,spotify_link,photo_url) VALUES(?,?,?,?,?)");
  $stmt->bind_param('issss',$uid,$title,$desc,$spotify,$photo); $stmt->execute(); $gid=(int)$stmt->insert_id;
  $mem = $mysqli->prepare("INSERT IGNORE INTO dm_group_members(group_id,user_id,role) VALUES(?,?,?)");
  foreach($memberIds as $i=>$memberId){ $role = $memberId===$uid ? 'owner' : 'member'; $mem->bind_param('iis',$gid,$memberId,$role); $mem->execute(); }
  respond(['ok'=>true,'group_id'=>$gid]);
}

if($action === 'memory_wall_create'){
  $me = require_auth($mysqli); $uid=(int)$me['id'];
  $isMultipart = isset($_SERVER['CONTENT_TYPE']) && str_contains(strtolower($_SERVER['CONTENT_TYPE']), 'multipart/form-data');
  if($isMultipart){ $category=trim((string)($_POST['category'] ?? 'memory')); $title=trim((string)($_POST['title'] ?? '')); $body=trim((string)($_POST['body'] ?? '')); }
  else { $b=json_body(); $category=trim((string)($b['category'] ?? 'memory')); $title=trim((string)($b['title'] ?? '')); $body=trim((string)($b['body'] ?? '')); }
  if($title==='' || $body==='') respond(['ok'=>false,'error'=>'Başlık ve anı gerekli.'],400);
  $image = $isMultipart ? save_uploaded_image('photo','memory_wall') : null;
  $school = $me['school'] ?? null; $grad = $me['grad_year'] ?? null;
  $stmt = $mysqli->prepare("INSERT INTO memory_wall_posts(user_id,category,title,body,image_url,school,grad_year) VALUES(?,?,?,?,?,?,?)");
  $stmt->bind_param('isssssi',$uid,$category,$title,$body,$image,$school,$grad); $stmt->execute();
  respond(['ok'=>true]);
}

if($action === 'memory_wall_list'){
  $me = require_auth($mysqli); $school = trim((string)($_GET['school'] ?? ($me['school'] ?? ''))); $grad=(int)($_GET['grad_year'] ?? ($me['grad_year'] ?? 0));
  $where = '1=1';
  if($school!=='') $where .= " AND p.school='".$mysqli->real_escape_string($school)."'";
  if($grad>0) $where .= " AND p.grad_year=$grad";
  $sql = "SELECT p.*, u.full_name, u.photo_url, (SELECT COUNT(*) FROM memory_wall_reacts r WHERE r.post_id=p.id) AS remember_count, (SELECT COUNT(*) FROM memory_wall_reacts r2 WHERE r2.post_id=p.id AND r2.user_id=".(int)$me['id'].") AS reacted_me FROM memory_wall_posts p JOIN users u ON u.id=p.user_id WHERE $where ORDER BY remember_count DESC, p.id DESC LIMIT 50";
  $res = @$mysqli->query($sql); $items=[];
  while($res && ($r=$res->fetch_assoc())){
    $items[] = ['id'=>(int)$r['id'],'category'=>$r['category'],'title'=>$r['title'],'body'=>$r['body'],'image_url'=>upload_url_exists($r['image_url'] ?? null),'created_at'=>$r['created_at'],'remember_count'=>(int)$r['remember_count'],'reacted_me'=>(int)$r['reacted_me']>0,'user'=>safe_user(['id'=>$r['user_id'],'full_name'=>$r['full_name'],'school'=>$r['school'],'grad_year'=>$r['grad_year'],'photo_url'=>$r['photo_url']])];
  }
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'memory_wall_react'){
  $me = require_auth($mysqli); $b=json_body(); $uid=(int)$me['id']; $postId=(int)($b['post_id'] ?? 0);
  if($postId<=0) respond(['ok'=>false,'error'=>'post_id gerekli'],400);
  $stmt = $mysqli->prepare("SELECT id FROM memory_wall_reacts WHERE post_id=? AND user_id=? LIMIT 1");
  $stmt->bind_param('ii',$postId,$uid); $stmt->execute(); $row=$stmt->get_result()->fetch_assoc();
  if($row){ $del=$mysqli->prepare("DELETE FROM memory_wall_reacts WHERE id=?"); $rid=(int)$row['id']; $del->bind_param('i',$rid); $del->execute(); respond(['ok'=>true,'saved'=>false]); }
  $ins = $mysqli->prepare("INSERT INTO memory_wall_reacts(post_id,user_id) VALUES(?,?)"); $ins->bind_param('ii',$postId,$uid); $ins->execute(); respond(['ok'=>true,'saved'=>true]);
}

if($action === 'yearbook_summary'){
  $me = require_auth($mysqli); $school = trim((string)($_GET['school'] ?? ($me['school'] ?? ''))); $grad=(int)($_GET['grad_year'] ?? ($me['grad_year'] ?? 0));
  if($school==='' || $grad<=0) respond(['ok'=>false,'error'=>'Okul ve mezuniyet yılı gerekli.'],400);
  $summary = ['school'=>$school,'grad_year'=>$grad,'students'=>0,'classmates'=>0,'top_farewell'=>null,'top_photos'=>null,'top_talker'=>null,'theme_song'=>null];
  $summary['students'] = (int)(@$mysqli->query("SELECT COUNT(*) c FROM users WHERE school='".$mysqli->real_escape_string($school)."' AND grad_year=$grad")->fetch_assoc()['c'] ?? 0);
  $myClass = trim((string)($me['class_label'] ?? ''));
  if($myClass !== '') $summary['classmates'] = (int)(@$mysqli->query("SELECT COUNT(*) c FROM users WHERE school='".$mysqli->real_escape_string($school)."' AND grad_year=$grad AND class_label='".$mysqli->real_escape_string($myClass)."' AND id<>".(int)$me['id'])->fetch_assoc()['c'] ?? 0);
  $q1 = @$mysqli->query("SELECT u.id,u.full_name,COUNT(f.id) c FROM users u LEFT JOIN farewells f ON f.to_user_id=u.id WHERE u.school='".$mysqli->real_escape_string($school)."' AND u.grad_year=$grad GROUP BY u.id ORDER BY c DESC,u.full_name ASC LIMIT 1");
  if($q1 && ($r=$q1->fetch_assoc())) $summary['top_farewell'] = ['id'=>(int)$r['id'],'full_name'=>$r['full_name'],'count'=>(int)$r['c']];
  $q2 = @$mysqli->query("SELECT u.id,u.full_name,COUNT(p.id) c FROM users u LEFT JOIN photo_posts p ON p.user_id=u.id WHERE u.school='".$mysqli->real_escape_string($school)."' AND u.grad_year=$grad GROUP BY u.id ORDER BY c DESC,u.full_name ASC LIMIT 1");
  if($q2 && ($r=$q2->fetch_assoc())) $summary['top_photos'] = ['id'=>(int)$r['id'],'full_name'=>$r['full_name'],'count'=>(int)$r['c']];
  if(db_table_exists($mysqli, 'dm_messages')){
    $q3 = @$mysqli->query("SELECT u.id,u.full_name,COUNT(m.id) c FROM users u LEFT JOIN dm_messages m ON m.sender_id=u.id AND m.deleted_at IS NULL WHERE u.school='".$mysqli->real_escape_string($school)."' AND u.grad_year=$grad GROUP BY u.id ORDER BY c DESC,u.full_name ASC LIMIT 1");
    if($q3 && ($r=$q3->fetch_assoc())) $summary['top_talker'] = ['id'=>(int)$r['id'],'full_name'=>$r['full_name'],'count'=>(int)$r['c']];
  }
  $classmates=[]; $schoolmates=[];
  $res=@$mysqli->query("SELECT * FROM users WHERE school='".$mysqli->real_escape_string($school)."' AND grad_year=$grad ORDER BY full_name ASC LIMIT 120");
  while($res && ($u=$res->fetch_assoc())){
    if((int)$u['id'] === (int)$me['id']) continue;
    $safe = safe_user($u);
    $uClass = trim((string)($u['class_label'] ?? ''));
    $safe['same_class'] = ($myClass !== '' && $uClass !== '' && mb_strtolower($uClass) === mb_strtolower($myClass));
    $safe['relation_label'] = $safe['same_class'] ? 'Aynı sınıftasınız' : 'Aynı okuldan';
    if($safe['same_class']) $classmates[] = $safe; else $schoolmates[] = $safe;
  }
  $playlist=[]; $pl=@$mysqli->query("SELECT y.*, u.full_name FROM year_playlist_tracks y JOIN users u ON u.id=y.user_id WHERE y.school='".$mysqli->real_escape_string($school)."' AND y.grad_year=$grad ORDER BY y.id DESC LIMIT 30");
  while($pl && ($r=$pl->fetch_assoc())) $playlist[] = ['platform'=>$r['platform'],'track_url'=>$r['track_url'],'note_body'=>$r['note_body'],'user_name'=>$r['full_name']];
  if($playlist) $summary['theme_song'] = ['platform'=>$playlist[0]['platform'] ?? '', 'track_url'=>$playlist[0]['track_url'] ?? '', 'user_name'=>$playlist[0]['user_name'] ?? ''];
  $presence=[]; $pres=@$mysqli->query("SELECT city, COUNT(*) c FROM users WHERE school='".$mysqli->real_escape_string($school)."' AND grad_year=$grad AND city IS NOT NULL AND city<>'' GROUP BY city ORDER BY c DESC, city ASC LIMIT 20");
  while($pres && ($r=$pres->fetch_assoc())) $presence[] = ['city'=>$r['city'],'count'=>(int)$r['c']];
  $matches=[]; $selfCats=[]; $mine=@$mysqli->query("SELECT DISTINCT category FROM memory_wall_posts WHERE user_id=".(int)$me['id']); while($mine && ($r=$mine->fetch_assoc())) $selfCats[] = $r['category'];
  if($selfCats){
    $cats = "'".implode("','", array_map(fn($x)=>$mysqli->real_escape_string((string)$x), $selfCats))."'";
    $mx=@$mysqli->query("SELECT u.*, COUNT(DISTINCT p.category) match_count FROM users u JOIN memory_wall_posts p ON p.user_id=u.id AND p.category IN ($cats) WHERE u.school='".$mysqli->real_escape_string($school)."' AND u.grad_year=$grad AND u.id<>".(int)$me['id']." GROUP BY u.id ORDER BY match_count DESC, u.full_name ASC LIMIT 12");
    while($mx && ($u=$mx->fetch_assoc())){ $safe=safe_user($u); $safe['match_count']=(int)$u['match_count']; $matches[]=$safe; }
  }
  $quotes=[];
  if(db_table_exists($mysqli, 'yearbook_quotes')){
    $qq=@$mysqli->query("SELECT q.*, u.full_name FROM yearbook_quotes q JOIN users u ON u.id=q.user_id WHERE q.school='".$mysqli->real_escape_string($school)."' AND q.grad_year=$grad ORDER BY q.id DESC LIMIT 10");
    while($qq && ($r=$qq->fetch_assoc())) $quotes[] = ['quote_type'=>$r['quote_type'],'quote_body'=>$r['quote_body'],'user_name'=>$r['full_name'],'created_at'=>$r['created_at']];
  }
  respond(['ok'=>true,'summary'=>$summary,'classmates'=>$classmates,'schoolmates'=>$schoolmates,'playlist'=>$playlist,'presence'=>$presence,'matches'=>$matches,'quotes'=>$quotes]);
}

if($action === 'yearbook_playlist_add'){

  $me = require_auth($mysqli); $b=json_body(); $school=trim((string)($b['school'] ?? ($me['school'] ?? ''))); $grad=(int)($b['grad_year'] ?? ($me['grad_year'] ?? 0));
  $platform=trim((string)($b['platform'] ?? 'spotify')); $track=trim((string)($b['track_url'] ?? '')); $note=trim((string)($b['note_body'] ?? '')); $uid=(int)$me['id'];
  if($school==='' || $grad<=0 || $track==='') respond(['ok'=>false,'error'=>'Okul, yıl ve şarkı linki gerekli.'],400);
  $stmt = $mysqli->prepare("INSERT INTO year_playlist_tracks(school,grad_year,user_id,platform,track_url,note_body) VALUES(?,?,?,?,?,?)");
  $stmt->bind_param('siisss',$school,$grad,$uid,$platform,$track,$note); $stmt->execute(); respond(['ok'=>true]);
}


if($action === 'yearbook_quote_add'){
  $me = require_auth($mysqli); $b=json_body();
  $school=trim((string)($b['school'] ?? ($me['school'] ?? ''))); $grad=(int)($b['grad_year'] ?? ($me['grad_year'] ?? 0));
  $type=trim((string)($b['quote_type'] ?? 'period')); if(!in_array($type,['period','teacher'],true)) $type='period';
  $body=trim((string)($b['quote_body'] ?? ''));
  if($school==='' || $grad<=0 || $body==='') respond(['ok'=>false,'error'=>'Okul, yıl ve söz gerekli.'],400);
  $uid=(int)$me['id'];
  $stmt = $mysqli->prepare("INSERT INTO yearbook_quotes(school,grad_year,user_id,quote_type,quote_body) VALUES(?,?,?,?,?)");
  if(!$stmt) respond(['ok'=>false,'error'=>'Söz kaydedilemedi.'],500);
  $stmt->bind_param('siiss',$school,$grad,$uid,$type,$body);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Söz kaydedilemedi.'],500);
  respond(['ok'=>true]);
}

if($action === 'profile_premium_summary'){
  $me = require_auth($mysqli);
  $userId = (int)($_GET['user_id'] ?? $me['id']);
  $stmt = $mysqli->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
  if(!$stmt) respond(['ok'=>false,'error'=>'Kullanıcı bulunamadı.'],500);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();
  if(!$user) respond(['ok'=>false,'error'=>'Kullanıcı bulunamadı.'],404);
  respond(['ok'=>true,'summary'=>profile_premium_summary_payload($mysqli, $user)]);
}

if($action === 'meetup_history_list'){
  $me = require_auth($mysqli); $uid=(int)$me['id'];
  if(!db_table_exists($mysqli, 'meetup_requests')) respond(['ok'=>true,'items'=>[]]);
  $stmt = $mysqli->prepare("SELECT m.id, m.title, m.category, m.meeting_at, m.status, u.full_name host_name, u.photo_url host_photo FROM meetup_requests mr JOIN meetups m ON m.id=mr.meetup_id JOIN users u ON u.id=m.user_id WHERE mr.requester_id=? AND mr.status='accepted' ORDER BY m.meeting_at DESC, m.id DESC LIMIT 20");
  if(!$stmt) respond(['ok'=>false,'error'=>'Geçmiş alınamadı.'],500);
  $stmt->bind_param('i', $uid);
  $stmt->execute();
  $res = $stmt->get_result(); $items=[];
  while($r=$res->fetch_assoc()) $items[] = ['id'=>(int)$r['id'],'title'=>$r['title'],'category'=>$r['category'],'meeting_at'=>$r['meeting_at'],'status'=>$r['status'],'host_name'=>$r['host_name'],'host_photo'=>$r['host_photo']];
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'profile_note_add'){
  $me = require_auth($mysqli); $b=json_body(); $uid=(int)$me['id']; $to=(int)($b['to_user_id'] ?? 0); $note=trim((string)($b['note_body'] ?? ''));
  if($to<=0 || $note==='') respond(['ok'=>false,'error'=>'Not boş olamaz.'],400);
  $stmt = $mysqli->prepare("INSERT INTO private_notes(to_user_id,from_user_id,note_body) VALUES(?,?,?)");
  $stmt->bind_param('iis',$to,$uid,$note); $stmt->execute(); respond(['ok'=>true]);
}

if($action === 'profile_notes_list'){
  $me = require_auth($mysqli); $uid=(int)$me['id']; $to=(int)($_GET['to_user_id'] ?? $uid); $mode = trim((string)($_GET['mode'] ?? 'received'));
  $sql = $mode==='received'
    ? "SELECT n.*, u.full_name, u.photo_url FROM private_notes n JOIN users u ON u.id=n.from_user_id WHERE n.to_user_id=$to ORDER BY n.id DESC LIMIT 20"
    : "SELECT n.*, u.full_name, u.photo_url FROM private_notes n JOIN users u ON u.id=n.to_user_id WHERE n.from_user_id=$uid ORDER BY n.id DESC LIMIT 20";
  $res=@$mysqli->query($sql); $items=[]; while($res && ($r=$res->fetch_assoc())) $items[]=['id'=>(int)$r['id'],'note_body'=>$r['note_body'],'created_at'=>$r['created_at'],'user'=>safe_user(['id'=>0,'full_name'=>$r['full_name'],'photo_url'=>$r['photo_url']])];
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'city_presence_list'){
  $me = require_auth($mysqli); $school = trim((string)($_GET['school'] ?? ($me['school'] ?? ''))); $grad=(int)($_GET['grad_year'] ?? ($me['grad_year'] ?? 0));
  $where = [];
  if($school!=='') $where[] = "school='".$mysqli->real_escape_string($school)."'";
  if($grad>0) $where[] = "grad_year=$grad";
  $where[] = "city IS NOT NULL AND city<>''";
  $sql = "SELECT city, COUNT(*) c FROM users".(count($where)?(' WHERE '.implode(' AND ',$where)):'')." GROUP BY city ORDER BY c DESC, city ASC LIMIT 20";
  $res=@$mysqli->query($sql); $items=[]; while($res && ($r=$res->fetch_assoc())) $items[]=['city'=>$r['city'],'count'=>(int)$r['c']];
  respond(['ok'=>true,'items'=>$items]);
}

if($action === 'dm_group_extras'){
  $me = require_auth($mysqli); $uid=(int)$me['id']; $gid=(int)($_GET['group_id'] ?? 0); if($gid<=0) respond(['ok'=>false,'error'=>'group_id gerekli'],400);
  respond(['ok'=>true,'extras'=>dm_group_extras_payload($mysqli,$gid,$uid)]);
}

if($action === 'dm_group_poll_create'){
  $me = require_auth($mysqli); $uid=(int)$me['id']; $b=json_body(); $gid=(int)($b['group_id'] ?? 0); $question=trim((string)($b['question'] ?? '')); $options=$b['options'] ?? [];
  $member=require_dm_group_member($mysqli,$gid,$uid); if($gid<=0 || $question==='' || !is_array($options)) respond(['ok'=>false,'error'=>'Soru ve seçenekler gerekli.'],400);
  $role = (string)($member['role'] ?? 'member'); if(!in_array($role,['owner','admin','member'],true)) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $opts = array_values(array_filter(array_map(fn($x)=>trim((string)$x), $options), fn($x)=>$x!=='')); if(count($opts)<2) respond(['ok'=>false,'error'=>'En az 2 seçenek gerekli.'],400);
  $stmt = $mysqli->prepare("INSERT INTO dm_group_polls(group_id,user_id,question) VALUES(?,?,?)"); $stmt->bind_param('iis',$gid,$uid,$question); $stmt->execute(); $pid=(int)$stmt->insert_id;
  $ins = $mysqli->prepare("INSERT INTO dm_group_poll_options(poll_id,option_text) VALUES(?,?)"); foreach($opts as $opt){ $ins->bind_param('is',$pid,$opt); $ins->execute(); }
  respond(['ok'=>true,'poll_id'=>$pid]);
}

if($action === 'dm_group_poll_vote'){
  $me = require_auth($mysqli); $uid=(int)$me['id']; $b=json_body(); $gid=(int)($b['group_id'] ?? 0); $optionId=(int)($b['option_id'] ?? 0); if($gid<=0||$optionId<=0) respond(['ok'=>false,'error'=>'Seçim gerekli.'],400);
  require_dm_group_member($mysqli,$gid,$uid);
  $stmt = $mysqli->prepare("SELECT o.poll_id FROM dm_group_poll_options o JOIN dm_group_polls p ON p.id=o.poll_id WHERE o.id=? AND p.group_id=? LIMIT 1"); $stmt->bind_param('ii',$optionId,$gid); $stmt->execute(); $row=$stmt->get_result()->fetch_assoc(); if(!$row) respond(['ok'=>false,'error'=>'Seçenek bulunamadı.'],404);
  $pid=(int)$row['poll_id'];
  $del = $mysqli->prepare("DELETE FROM dm_group_poll_votes WHERE poll_id=? AND user_id=?"); $del->bind_param('ii',$pid,$uid); $del->execute();
  $ins = $mysqli->prepare("INSERT INTO dm_group_poll_votes(poll_id,option_id,user_id) VALUES(?,?,?)"); $ins->bind_param('iii',$pid,$optionId,$uid); $ins->execute(); respond(['ok'=>true]);
}

if($action === 'dm_group_event_create'){
  $me = require_auth($mysqli); $uid=(int)$me['id']; $b=json_body(); $gid=(int)($b['group_id'] ?? 0); $title=trim((string)($b['title'] ?? '')); $eventAt=str_replace('T',' ', trim((string)($b['event_at'] ?? ''))); $location=trim((string)($b['location'] ?? '')); $note=trim((string)($b['note_body'] ?? ''));
  $member=require_dm_group_member($mysqli,$gid,$uid); if($gid<=0||$title===''||$eventAt==='') respond(['ok'=>false,'error'=>'Başlık ve tarih gerekli.'],400);
  $role=(string)($member['role'] ?? 'member'); if(!in_array($role,['owner','admin','member'],true)) respond(['ok'=>false,'error'=>'Yetkisiz'],403);
  $stmt=$mysqli->prepare("INSERT INTO dm_group_events(group_id,user_id,title,event_at,location,note_body) VALUES(?,?,?,?,?,?)"); $stmt->bind_param('iissss',$gid,$uid,$title,$eventAt,$location,$note); $stmt->execute(); respond(['ok'=>true]);
}

if($action === 'dm_group_set_role'){
  $me=require_auth($mysqli); $uid=(int)$me['id']; $b=json_body(); $gid=(int)($b['group_id'] ?? 0); $target=(int)($b['user_id'] ?? 0); $role=trim((string)($b['role'] ?? 'member'));
  $member=require_dm_group_member($mysqli,$gid,$uid); if(($member['role'] ?? '') !== 'owner') respond(['ok'=>false,'error'=>'Sadece kurucu rol değiştirebilir.'],403);
  if(!in_array($role,['admin','member'],true)) respond(['ok'=>false,'error'=>'Geçersiz rol.'],400);
  $stmt=$mysqli->prepare("UPDATE dm_group_members SET role=? WHERE group_id=? AND user_id=?"); $stmt->bind_param('sii',$role,$gid,$target); $stmt->execute(); respond(['ok'=>true]);
}



function style_tag_list(string $raw): array {
  $raw = trim($raw);
  if($raw==='') return [];
  $parts = preg_split('/[\s,]+/', $raw) ?: [];
  $out = [];
  foreach($parts as $part){
    $tag = trim((string)$part);
    if($tag==='') continue;
    $tag = ltrim($tag, "#");
    if($tag==='') continue;
    $out[] = mb_substr($tag, 0, 24);
  }
  return array_values(array_unique($out));
}

function style_post_items_payload(mysqli $mysqli, array $postIds): array {
  $postIds = array_values(array_unique(array_map('intval', $postIds)));
  if(!$postIds) return [];
  $map = [];
  $in = implode(',', $postIds);
  $res = @$mysqli->query("SELECT * FROM style_post_items WHERE post_id IN ({$in}) ORDER BY display_order ASC, id ASC");
  if(!$res) return $map;
  while($r = $res->fetch_assoc()){
    $pid = (int)($r['post_id'] ?? 0);
    if(!isset($map[$pid])) $map[$pid] = [];
    $map[$pid][] = [
      'id'=>(int)($r['id'] ?? 0),
      'item_name'=>$r['item_name'] ?? '',
      'store_name'=>$r['store_name'] ?? '',
      'price_now'=>$r['price_now'] !== null ? (float)$r['price_now'] : null,
      'product_url'=>$r['product_url'] ?? '',
      'display_order'=>(int)($r['display_order'] ?? 0),
    ];
  }
  return $map;
}

function style_post_reaction_map(mysqli $mysqli, string $table, array $postIds, int $viewerId=0): array {
  $postIds = array_values(array_unique(array_map('intval', $postIds)));
  $out = ['count'=>[], 'mine'=>[]];
  if(!$postIds) return $out;
  $in = implode(',', $postIds);
  $res = @$mysqli->query("SELECT post_id, COUNT(*) AS c FROM {$table} WHERE post_id IN ({$in}) GROUP BY post_id");
  if($res){
    while($r = $res->fetch_assoc()) $out['count'][(int)$r['post_id']] = (int)$r['c'];
  }
  if($viewerId > 0){
    $stmt = $mysqli->prepare("SELECT post_id FROM {$table} WHERE user_id=? AND post_id IN ({$in})");
    if($stmt){
      $stmt->bind_param('i', $viewerId);
      $stmt->execute();
      $rr = $stmt->get_result();
      while($row = $rr->fetch_assoc()) $out['mine'][(int)$row['post_id']] = true;
    }
  }
  return $out;
}

function style_feed_payload(mysqli $mysqli, int $viewerId=0, int $limit=60): array {
  $limit = max(1, min($limit, 120));
  $sql = "SELECT p.*, u.full_name, u.photo_url AS user_photo_url, u.school FROM style_posts p JOIN users u ON u.id=p.user_id ORDER BY p.created_at DESC, p.id DESC LIMIT {$limit}";
  $res = @$mysqli->query($sql);
  if(!$res) return [];
  $rows = [];
  $postIds = [];
  while($r = $res->fetch_assoc()){
    $rows[] = $r;
    $postIds[] = (int)$r['id'];
  }
  $itemsMap = style_post_items_payload($mysqli, $postIds);
  $likesMap = style_post_reaction_map($mysqli, 'style_post_likes', $postIds, $viewerId);
  $savesMap = style_post_reaction_map($mysqli, 'style_post_saves', $postIds, $viewerId);
  $items = [];
  foreach($rows as $r){
    $pid = (int)$r['id'];
    $items[] = [
      'id'=>$pid,
      'user_id'=>(int)$r['user_id'],
      'post_type'=>$r['post_type'] ?? 'outfit',
      'category'=>$r['category'] ?? 'sneaker',
      'title'=>$r['title'] ?? '',
      'body'=>$r['body'] ?? '',
      'brand_name'=>$r['brand_name'] ?? '',
      'price_now'=>$r['price_now'] !== null ? (float)$r['price_now'] : null,
      'price_before'=>$r['price_before'] !== null ? (float)$r['price_before'] : null,
      'product_url'=>$r['product_url'] ?? '',
      'image_url'=>upload_url_exists($r['image_url'] ?? null),
      'tags'=>style_tag_list((string)($r['tags_text'] ?? '')),
      'created_at'=>$r['created_at'] ?? null,
      'full_name'=>$r['full_name'] ?? '',
      'school'=>$r['school'] ?? '',
      'user_photo_url'=>$r['user_photo_url'] ?? null,
      'items'=>$itemsMap[$pid] ?? [],
      'like_count'=>(int)($likesMap['count'][$pid] ?? 0),
      'save_count'=>(int)($savesMap['count'][$pid] ?? 0),
      'viewer_liked'=>!empty($likesMap['mine'][$pid]),
      'viewer_saved'=>!empty($savesMap['mine'][$pid]),
    ];
  }
  return $items;
}

function style_summary_payload(mysqli $mysqli, int $viewerId=0): array {
  $recent = style_feed_payload($mysqli, $viewerId, 40);
  $tags = [];
  $outfits = [];
  $deals = [];
  foreach($recent as $item){
    foreach(($item['tags'] ?? []) as $tag){
      $tags[$tag] = ($tags[$tag] ?? 0) + 1;
    }
    if(($item['post_type'] ?? '') === 'deal') $deals[] = $item; else $outfits[] = $item;
  }
  arsort($tags);
  return [
    'hero_title'=>'MEra Style',
    'hero_body'=>'Kombin paylaş, ürün öner, indirim yakalayınca hızlıca haber ver.',
    'outfit_count'=>count($outfits),
    'deal_count'=>count($deals),
    'trending_tags'=>array_slice(array_keys($tags), 0, 6),
    'latest_outfits'=>array_slice($outfits, 0, 3),
    'latest_deals'=>array_slice($deals, 0, 3),
  ];
}

if($action === 'style_post_create'){
  $me = require_login($mysqli);
  $isMultipart = isset($_SERVER['CONTENT_TYPE']) && stripos((string)$_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false;
  $b = $isMultipart ? $_POST : json_body();
  $postType = trim((string)($b['post_type'] ?? 'outfit'));
  if(!in_array($postType, ['outfit','deal'], true)) $postType = 'outfit';
  $category = trim((string)($b['category'] ?? 'sneaker'));
  $title = trim((string)($b['title'] ?? ''));
  $body = trim((string)($b['body'] ?? ''));
  $brandName = trim((string)($b['brand_name'] ?? ''));
  $priceNow = trim((string)($b['price_now'] ?? ''));
  $priceBefore = trim((string)($b['price_before'] ?? ''));
  $productUrl = trim((string)($b['product_url'] ?? ''));
  $tagsText = trim((string)($b['tags'] ?? ''));
  $itemsJson = trim((string)($b['items_json'] ?? '[]'));
  $imageUrl = $isMultipart ? save_uploaded_image('photo', 'style') : null;
  if($title === '') respond(['ok'=>false,'error'=>'Başlık gerekli'], 400);
  if($body === '' && !$imageUrl) respond(['ok'=>false,'error'=>'Açıklama veya fotoğraf gerekli'], 400);
  $priceNowDb = is_numeric($priceNow) ? (float)$priceNow : null;
  $priceBeforeDb = is_numeric($priceBefore) ? (float)$priceBefore : null;
  if($postType === 'deal'){
    if($productUrl === '') respond(['ok'=>false,'error'=>'İndirim için ürün linki gerekli'], 400);
    if($priceNowDb === null || $priceBeforeDb === null || !($priceBeforeDb > $priceNowDb && $priceNowDb > 0)) respond(['ok'=>false,'error'=>'İndirim için eski fiyat, yeni fiyattan yüksek olmalı'], 400);
  }
  $stmt = $mysqli->prepare("INSERT INTO style_posts(user_id,post_type,category,title,body,brand_name,price_now,price_before,product_url,image_url,tags_text) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
  if(!$stmt) respond(['ok'=>false,'error'=>'style_posts hazırlanamıyor'],500);
  $uid = (int)$me['id'];
  $stmt->bind_param('isssssddsss', $uid, $postType, $category, $title, $body, $brandName, $priceNowDb, $priceBeforeDb, $productUrl, $imageUrl, $tagsText);
  $stmt->execute();
  $postId = (int)$stmt->insert_id;
  $itemsRaw = json_decode($itemsJson, true);
  if(is_array($itemsRaw) && $postId > 0){
    $ins = $mysqli->prepare("INSERT INTO style_post_items(post_id,item_name,store_name,price_now,product_url,display_order) VALUES(?,?,?,?,?,?)");
    if($ins){
      $order = 0;
      foreach($itemsRaw as $it){
        $name = trim((string)($it['name'] ?? ''));
        $store = trim((string)($it['store'] ?? ''));
        $priceVal = trim((string)($it['price'] ?? ''));
        $link = trim((string)($it['link'] ?? ''));
        if($name==='' && $store==='' && $priceVal==='' && $link==='') continue;
        $order++;
        $priceDb = is_numeric($priceVal) ? (float)$priceVal : null;
        $ins->bind_param('issdsi', $postId, $name, $store, $priceDb, $link, $order);
        $ins->execute();
      }
    }
  }
  respond(['ok'=>true,'id'=>$postId]);
}

if($action === 'style_toggle_like'){
  $me = require_login($mysqli);
  $b = json_body();
  $postId = (int)($b['post_id'] ?? 0);
  if($postId <= 0) respond(['ok'=>false,'error'=>'Geçersiz gönderi'],400);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("SELECT id FROM style_post_likes WHERE post_id=? AND user_id=? LIMIT 1");
  $stmt->bind_param('ii', $postId, $uid);
  $stmt->execute();
  $liked = false;
  if($stmt->get_result()->fetch_assoc()){
    $del = $mysqli->prepare("DELETE FROM style_post_likes WHERE post_id=? AND user_id=?");
    $del->bind_param('ii', $postId, $uid);
    $del->execute();
  } else {
    $ins = $mysqli->prepare("INSERT INTO style_post_likes(post_id,user_id) VALUES(?,?)");
    $ins->bind_param('ii', $postId, $uid);
    $ins->execute();
    $liked = true;
  }
  $res = $mysqli->query("SELECT COUNT(*) c FROM style_post_likes WHERE post_id={$postId}");
  $count = $res ? (int)($res->fetch_assoc()['c'] ?? 0) : 0;
  respond(['ok'=>true,'liked'=>$liked,'count'=>$count]);
}

if($action === 'style_toggle_save'){
  $me = require_login($mysqli);
  $b = json_body();
  $postId = (int)($b['post_id'] ?? 0);
  if($postId <= 0) respond(['ok'=>false,'error'=>'Geçersiz gönderi'],400);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("SELECT id FROM style_post_saves WHERE post_id=? AND user_id=? LIMIT 1");
  $stmt->bind_param('ii', $postId, $uid);
  $stmt->execute();
  $saved = false;
  if($stmt->get_result()->fetch_assoc()){
    $del = $mysqli->prepare("DELETE FROM style_post_saves WHERE post_id=? AND user_id=?");
    $del->bind_param('ii', $postId, $uid);
    $del->execute();
  } else {
    $ins = $mysqli->prepare("INSERT INTO style_post_saves(post_id,user_id) VALUES(?,?)");
    $ins->bind_param('ii', $postId, $uid);
    $ins->execute();
    $saved = true;
  }
  $res = $mysqli->query("SELECT COUNT(*) c FROM style_post_saves WHERE post_id={$postId}");
  $count = $res ? (int)($res->fetch_assoc()['c'] ?? 0) : 0;
  respond(['ok'=>true,'saved'=>$saved,'count'=>$count]);
}

if($action === 'style_feed'){
  $me = require_login($mysqli);
  $limit = max(1, min((int)($_GET['limit'] ?? 60), 120));
  respond(['ok'=>true,'items'=>style_feed_payload($mysqli, (int)$me['id'], $limit)]);
}

if($action === 'style_summary'){
  $me = require_login($mysqli);
  respond(['ok'=>true,'summary'=>style_summary_payload($mysqli, (int)$me['id'])]);
}


function scene_weekly_theme(): array {
  $themes = [
    ['title'=>'Vedaya en çok yakışan sahne','subtitle'=>'Ayrılık, teşekkür ve kapanış hissi taşıyan anlar'],
    ['title'=>'Yeniden başlama hissi','subtitle'=>'Yeni sayfa açtıran sahne, karakter veya soundtrack'],
    ['title'=>'Bu dönemin repliği','subtitle'=>'Sınıfı veya yılı tek cümlede anlatan söz'],
    ['title'=>"Gece yürüyüşü soundtrack'i",'subtitle'=>'Sessiz ama güçlü his bırakan şarkılar'],
    ['title'=>'Beni anlatan karakter','subtitle'=>'Ruh halini en iyi taşıyan karakter kartı'],
    ['title'=>'Final sahnesi etkisi','subtitle'=>'Bitse de akılda kalan kapanış anları']
  ];
  $week = (int)date('W');
  return $themes[$week % count($themes)];
}

function scene_feed_payload(mysqli $mysqli, int $viewerId, int $limit=40): array {
  $limit = max(1, min(80, $limit));
  $sql = "SELECT p.*, u.full_name, u.photo_url, u.school FROM scene_posts p JOIN users u ON u.id=p.user_id ORDER BY p.created_at DESC, p.id DESC LIMIT {$limit}";
  $res = @$mysqli->query($sql);
  $items = [];
  if(!$res) return $items;
  while($r = $res->fetch_assoc()){
    $pid = (int)$r['id'];
    $reactRows = [];
    $byReaction = @$mysqli->query("SELECT reaction, COUNT(*) c FROM scene_reactions WHERE post_id={$pid} GROUP BY reaction ORDER BY c DESC, reaction ASC");
    if($byReaction){ while($x = $byReaction->fetch_assoc()){ $reactRows[] = ['reaction'=>$x['reaction'],'count'=>(int)$x['c']]; } }
    $myReaction = null;
    if($viewerId > 0){
      $mine = @$mysqli->query("SELECT reaction FROM scene_reactions WHERE post_id={$pid} AND user_id={$viewerId} LIMIT 1");
      if($mine && ($mx = $mine->fetch_assoc())) $myReaction = (string)$mx['reaction'];
    }
    $items[] = [
      'id'=>$pid,
      'user_id'=>(int)$r['user_id'],
      'full_name'=>$r['full_name'],
      'photo_url'=>upload_url_exists($r['photo_url'] ?? null),
      'school'=>$r['school'] ?? '',
      'entry_type'=>$r['entry_type'] ?? 'scene',
      'media_kind'=>$r['media_kind'] ?? '',
      'media_title'=>$r['media_title'] ?? '',
      'character_name'=>$r['character_name'] ?? '',
      'title'=>$r['title'] ?? '',
      'body'=>$r['body'] ?? '',
      'soundtrack_platform'=>$r['soundtrack_platform'] ?? '',
      'soundtrack_url'=>$r['soundtrack_url'] ?? '',
      'theme_label'=>$r['theme_label'] ?? '',
      'created_at'=>$r['created_at'] ?? '',
      'reactions'=>$reactRows,
      'my_reaction'=>$myReaction,
    ];
  }
  return $items;
}

if($action === 'scene_post_create'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $entryType = trim((string)($b['entry_type'] ?? 'scene'));
  $mediaKind = trim((string)($b['media_kind'] ?? 'film'));
  $mediaTitle = trim((string)($b['media_title'] ?? ''));
  $characterName = trim((string)($b['character_name'] ?? ''));
  $title = trim((string)($b['title'] ?? ''));
  $body = trim((string)($b['body'] ?? ''));
  $soundtrackPlatform = trim((string)($b['soundtrack_platform'] ?? ''));
  $soundtrackUrl = trim((string)($b['soundtrack_url'] ?? ''));
  $theme = trim((string)($b['theme_label'] ?? scene_weekly_theme()['title']));
  if(!in_array($entryType, ['scene','quote','soundtrack','character'], true)) $entryType = 'scene';
  if(!in_array($mediaKind, ['film','series','playlist'], true)) $mediaKind = 'film';
  if($mediaTitle === '' || $title === '' || $body === '') respond(['ok'=>false,'error'=>'Yapım adı, başlık ve metin gerekli.'],400);
  $stmt = $mysqli->prepare("INSERT INTO scene_posts(user_id, entry_type, media_kind, media_title, character_name, title, body, soundtrack_platform, soundtrack_url, theme_label) VALUES(?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param('isssssssss', $uid, $entryType, $mediaKind, $mediaTitle, $characterName, $title, $body, $soundtrackPlatform, $soundtrackUrl, $theme);
  $stmt->execute();
  respond(['ok'=>true,'post_id'=>(int)$stmt->insert_id]);
}

if($action === 'scene_feed'){
  $me = require_auth($mysqli);
  $limit = (int)($_GET['limit'] ?? 40);
  respond(['ok'=>true,'items'=>scene_feed_payload($mysqli, (int)$me['id'], $limit)]);
}

if($action === 'scene_react_toggle'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $b = json_body();
  $postId = (int)($b['post_id'] ?? 0);
  $reaction = trim((string)($b['reaction'] ?? '🔥'));
  if($postId <= 0) respond(['ok'=>false,'error'=>'Gönderi bulunamadı.'],400);
  $post = @$mysqli->query("SELECT id FROM scene_posts WHERE id={$postId} LIMIT 1")->fetch_assoc();
  if(!$post) respond(['ok'=>false,'error'=>'Scene gönderisi bulunamadı.'],404);
  $existing = @$mysqli->query("SELECT id, reaction FROM scene_reactions WHERE post_id={$postId} AND user_id={$uid} LIMIT 1")->fetch_assoc();
  if($existing && (string)$existing['reaction'] === $reaction){
    @$mysqli->query("DELETE FROM scene_reactions WHERE id=".(int)$existing['id']);
    respond(['ok'=>true,'active'=>false]);
  }
  if($existing){
    $up = $mysqli->prepare("UPDATE scene_reactions SET reaction=? WHERE id=?");
    $rid = (int)$existing['id'];
    $up->bind_param('si', $reaction, $rid);
    $up->execute();
  }else{
    $ins = $mysqli->prepare("INSERT INTO scene_reactions(post_id, user_id, reaction) VALUES(?,?,?)");
    $ins->bind_param('iis', $postId, $uid, $reaction);
    $ins->execute();
  }
  respond(['ok'=>true,'active'=>true]);
}

if($action === 'scene_summary'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $theme = scene_weekly_theme();
  $recent = scene_feed_payload($mysqli, $uid, 24);
  $topMedia = [];
  $topCharacters = [];
  foreach($recent as $item){
    $media = trim((string)($item['media_title'] ?? ''));
    if($media !== '') $topMedia[$media] = ($topMedia[$media] ?? 0) + 1;
    $char = trim((string)($item['character_name'] ?? ''));
    if($char !== '') $topCharacters[$char] = ($topCharacters[$char] ?? 0) + 1;
  }
  arsort($topMedia); arsort($topCharacters);
  $topMediaList = []; foreach(array_slice($topMedia, 0, 5, true) as $name=>$count){ $topMediaList[] = ['name'=>$name,'count'=>$count]; }
  $topCharacterList = []; foreach(array_slice($topCharacters, 0, 5, true) as $name=>$count){ $topCharacterList[] = ['name'=>$name,'count'=>$count]; }
  $topReaction = null;
  $row = @$mysqli->query("SELECT reaction, COUNT(*) c FROM scene_reactions GROUP BY reaction ORDER BY c DESC, reaction ASC LIMIT 1");
  if($row && ($rr = $row->fetch_assoc())) $topReaction = ['reaction'=>$rr['reaction'],'count'=>(int)$rr['c']];
  respond(['ok'=>true,'summary'=>[
    'theme'=>$theme,
    'top_media'=>$topMediaList,
    'top_characters'=>$topCharacterList,
    'top_reaction'=>$topReaction,
    'recent_items'=>array_slice($recent, 0, 8),
  ]]);
}



if($action === 'blast_score_submit' || $action === 'm2_score_submit'){
  $me = require_auth($mysqli);
  $b = json_body();
  $score = max(0, min(9999999, (int)($b['score'] ?? 0)));
  $game = ($action === 'm2_score_submit' || (($b['game'] ?? '') === 'm2')) ? 'm2' : 'blast';
  $scoreTable = $game === 'm2' ? 'm2_scores' : 'blast_scores';
  if($score <= 0) respond(['ok'=>false,'error'=>'Puan gerekli.'],400);
  $uid = (int)$me['id'];
  $stmt = $mysqli->prepare("INSERT INTO {$scoreTable}(user_id,best_score,last_score,plays) VALUES(?,?,?,1) ON DUPLICATE KEY UPDATE best_score=GREATEST(best_score, VALUES(best_score)), last_score=VALUES(last_score), plays=plays+1");
  if(!$stmt) respond(['ok'=>false,'error'=>'Skor hazırlanamadı.'],500);
  $stmt->bind_param('iii',$uid,$score,$score);
  if(!$stmt->execute()) respond(['ok'=>false,'error'=>'Skor kaydedilemedi: '.$stmt->error],500);
  respond(['ok'=>true]);
}

if($action === 'blast_leaderboard' || $action === 'm2_leaderboard'){
  $me = require_auth($mysqli);
  $uid = (int)$me['id'];
  $scope = ($_GET['scope'] ?? 'school') === 'global' ? 'global' : 'school';
  $game = ($action === 'm2_leaderboard' || (($_GET['game'] ?? '') === 'm2')) ? 'm2' : 'blast';
  $scoreTable = $game === 'm2' ? 'm2_scores' : 'blast_scores';
  $school = (string)($me['school'] ?? '');
  $items = [];
  if($scope === 'school'){
    $stmt = $mysqli->prepare("SELECT u.id,u.full_name,u.school,b.best_score,b.plays FROM {$scoreTable} b JOIN users u ON u.id=b.user_id WHERE COALESCE(u.school,'')=COALESCE(?, '') ORDER BY b.best_score DESC, b.updated_at ASC LIMIT 50");
    $stmt->bind_param('s',$school);
  }else{
    $stmt = $mysqli->prepare("SELECT u.id,u.full_name,u.school,b.best_score,b.plays FROM {$scoreTable} b JOIN users u ON u.id=b.user_id ORDER BY b.best_score DESC, b.updated_at ASC LIMIT 50");
  }
  if(!$stmt) respond(['ok'=>false,'error'=>'Sıralama hazırlanamadı.'],500);
  $stmt->execute(); $res=$stmt->get_result();
  while($res && ($r=$res->fetch_assoc())){
    $items[] = ['user_id'=>(int)$r['id'], 'full_name'=>$r['full_name'], 'school'=>$r['school'], 'best_score'=>(int)$r['best_score'], 'plays'=>(int)$r['plays'], 'is_me'=>((int)$r['id']===$uid)];
  }
  $myScore = 0; $myRank = null;
  $mine = @$mysqli->query("SELECT best_score FROM {$scoreTable} WHERE user_id={$uid} LIMIT 1");
  if($mine && ($mr=$mine->fetch_assoc())) $myScore=(int)$mr['best_score'];
  if($myScore>0){
    if($scope === 'school'){
      $stmtRank = $mysqli->prepare("SELECT COUNT(*)+1 r FROM {$scoreTable} b JOIN users u ON u.id=b.user_id WHERE COALESCE(u.school,'')=COALESCE(?, '') AND b.best_score > ?");
      $stmtRank->bind_param('si',$school,$myScore);
      $stmtRank->execute(); $rr=$stmtRank->get_result()->fetch_assoc(); $myRank=(int)$rr['r'];
    }else{
      $rr = $mysqli->query("SELECT COUNT(*)+1 r FROM {$scoreTable} WHERE best_score > {$myScore}")->fetch_assoc(); $myRank=(int)$rr['r'];
    }
  }
  respond(['ok'=>true,'scope'=>$scope,'items'=>$items,'my_rank'=>$myRank,'my_score'=>$myScore]);
}

// default
respond(['ok'=>false,'error'=>'Bilinmeyen işlem'], 404);
