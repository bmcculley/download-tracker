# Create tracking and user database
# Add first user as admin, and password 'abc123'

CREATE TABLE IF NOT EXISTS `download_tracking` (
  `entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_id` int(11) DEFAULT NULL,
  `ip_address` varchar(15) NOT NULL,
  `file` text,
  `referer` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`entry_id`),
  KEY `visitor_id` (`visitor_id`,`timestamp`)
);

CREATE TABLE IF NOT EXISTS `counter` (
  `file` varchar(20) NOT NULL,
  `date` varchar(10) NOT NULL,
  `count` int(11) NOT NULL
);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `access_level` tinyint(4) NOT NULL default '0',
  `active` enum('y','n','b') NOT NULL default 'n',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`username`),
  UNIQUE KEY `mail` (`email`)
);

INSERT INTO `users` VALUES (NULL, 'admin', '24f9dc05c05e04ef6097fb842a635141', 'email@example.com', 10, 'y');