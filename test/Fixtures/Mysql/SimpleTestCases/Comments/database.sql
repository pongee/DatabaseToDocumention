CREATE TABLE user (
  id INT(10) UNSIGNED NOT NULL COMMENT 'The id',
  email VARCHAR(64) COLLATE latin1_general_ci NOT NULL COMMENT 'The email',
  password VARCHAR(32) COLLATE latin1_general_ci NOT NULL COMMENT 'The password',
  nick VARCHAR(16) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'The nick',
  status ENUM('enabled', 'disabled') COLLATE latin1_general_ci DEFAULT NULL COMMENT 'The status flag',
  admin BIT NULL COMMENT 'The admin flag',
  geom GEOMETRY NOT NULL COMMENT 'The geom',
  created_at DATETIME NULL COMMENT 'The created at',
  updated_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'The updated at',
  PRIMARY KEY (id),
  INDEX i_password (password),
  INDEX ih_password (password) USING HASH,
  INDEX ib_password (password) USING BTREE,
  FULLTEXT KEY if_email_password (email,password),
  UNIQUE KEY iu_email_password (nick),
  UNIQUE KEY iuh_email_password (nick) USING HASH,
  UNIQUE KEY iub_email_password (nick) USING BTREE
) engine=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
