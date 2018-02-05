CREATE TABLE user (
  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `last_update` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id),
  KEY idx_actor_last_name (last_name)
) engine=innodb DEFAULT charset=utf8;

CREATE TABLE IF NOT EXISTS `developer` (
  `id` INT(10) UNSIGNED NOT NULL,
  `email` VARCHAR(64) COLLATE latin1_general_ci NOT NULL,
  `password` VARCHAR(32) COLLATE latin1_general_ci NOT NULL,
  `nick` VARCHAR(16) COLLATE latin1_general_ci DEFAULT NULL,
  `status` ENUM('enabled', 'disabled') COLLATE latin1_general_ci DEFAULT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_email_password` (`email`,`password`),
  CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE IF NOT EXISTS `log` (
  `id` INT(10) UNSIGNED NOT NULL,
  `message` VARCHAR(64) COLLATE latin1_general_ci NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

