SET NAMES utf8;

CREATE TABLE `categories` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `slug` varchar(160) NOT NULL,
  `title` varchar(160) NOT NULL,
  `description` varchar(160) NOT NULL,
  `ordering` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `discussions` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `category` int(6) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `created_by` int(6) NOT NULL,
  `created` datetime NOT NULL,
  `lastpost_by` int(6) NOT NULL,
  `lastpost` datetime NOT NULL,
  `replies` int(6) NOT NULL,
  `views` int(6) NOT NULL,
  `votes` int(6) NOT NULL,
  `title` varchar(160) NOT NULL,
  `description` varchar(160) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forum` (`category`),
  KEY `created_by` (`created_by`),
  KEY `lastpost_by` (`lastpost_by`),
  KEY `votes` (`votes`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `post_reports` (
  `user` int(6) NOT NULL,
  `post` int(6) NOT NULL,
  KEY `user` (`user`),
  KEY `post` (`post`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `posts` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `discussion` int(6) NOT NULL,
  `user` int(6) NOT NULL,
  `date` datetime NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic` (`discussion`),
  KEY `user` (`user`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `sessions` (
  `id` char(32) NOT NULL,
  `date` datetime NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `settings` (
  `key` varchar(160) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `user_discussions` (
  `user` int(6) NOT NULL,
  `discussion` int(6) NOT NULL,
  `viewed` datetime NOT NULL,
  KEY `discussion` (`discussion`),
  KEY `user` (`user`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `user_votes` (
  `user` int(6) NOT NULL,
  `discussion` int(6) NOT NULL,
  KEY `user` (`user`),
  KEY `discussion` (`discussion`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `role` enum('user','moderator','administrator') NOT NULL,
  `registered` datetime NOT NULL,
  `posts` int(6) NOT NULL,
  `name` varchar(160) NOT NULL,
  `email` varchar(160) NOT NULL,
  `username` varchar(160) NOT NULL,
  `password` varchar(180) NOT NULL,
  `token` text NOT NULL,
  `secret` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO `categories` (`slug`, `title`, `description`, `ordering`) VALUES
('general',  'General',  'General discussions',  1);

INSERT INTO `discussions` (`category`, `slug`, `created_by`, `created`, `lastpost_by`, `lastpost`, `replies`, `views`, `votes`, `title`, `description`) VALUES
(1,  'hello-world',  1,  NOW(),  1,  NOW(),  1,  0, 0,  'Hello World', 'This is the first discussion.');

INSERT INTO `posts` (`discussion`, `user`, `date`, `body`) VALUES
(1,  1,  NOW(),  '<p>This is the first post.</p>');

INSERT INTO `settings` (`key`, `value`) VALUES
('date_format', 'H:i jS M, Y'),
('site_name', 'Roar Discussion Forum'),
('theme', 'default'),
('twitter_consumer_key',  'hIXAQwhHKJbBC1LWZK9oLw'),
('twitter_consumer_secret', 'GT6f4RDpdqSiGUCs5J5rGXSyUiB4C62NPB1Z4RFU');

INSERT INTO `users` (`role`, `registered`, `posts`, `name`, `email`, `username`, `password`, `token`, `secret`) VALUES
('administrator',  NOW(),  1, 'admin', '', 'admin', '$2a$10$KhJR.9d8QqLStRAiqF1SBu8TvHT1rkyvqnAbdGESCqxHPjN3w2WJa', '', '');