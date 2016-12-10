-- Generation time: Wed, 09 Dec 2015 18:00:03 +0100
-- Host: localhost
-- DB name: testssit_1
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `name` varchar(63) NOT NULL,
  `email` varchar(127) NOT NULL,
  `email_template` text,
  `url` varchar(127) NOT NULL,
  `category` enum('Business Index','Art and Amusement','Automobileindustry','Beauty and Fitness','Books and Literature','Companies and Industry','Computers and Electronics','Financial Services','Food and Drinks','Games','Healthcare','Hobbies','House and Garden','Internet and Telecom','Vacant and Education','Law and Government','News','Online Community','People and Society','Pets and Animals','Property','Reference','Science','Shopping','Sport','Traveling','Other') NOT NULL,
  `title` varchar(127) DEFAULT NULL,
  `description` text,
  `active` int(1) NOT NULL DEFAULT '1',
  `owner` varchar(127) DEFAULT NULL,
  `bot_enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_campaigns_customers1_idx` (`customer_id`),
  CONSTRAINT `fk_campaigns_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(63) NOT NULL,
  `address` varchar(127) NOT NULL,
  `addressnumber` varchar(15) NOT NULL,
  `postalcode` varchar(7) NOT NULL,
  `city` varchar(63) NOT NULL,
  `country` varchar(63) NOT NULL,
  `taxnumber` varchar(127) DEFAULT NULL,
  `kvknumber` varchar(15) DEFAULT NULL,
  `phonenumber` varchar(31) DEFAULT NULL,
  `email` varchar(127) NOT NULL,
  `website` varchar(127) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submissions_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `new_status` enum('not_submitted','rejected','accepted','submitted','failed') NOT NULL,
  `comment` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_history_users1_idx` (`users_id`),
  KEY `fk_history_submissions1_idx` (`submissions_id`),
  CONSTRAINT `fk_history_submissions1` FOREIGN KEY (`submissions_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_history_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `linksites`;
CREATE TABLE `linksites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `name` varchar(63) NOT NULL,
  `type` enum('Startpage','Blog','Search Engine','App','Social Media','Other') NOT NULL,
  `category` enum('Art and Amusement','Automobileindustry','Beauty and Fitness','Books and Literature','Companies and Industry','Computers and Electronics','Financial Services','Food and Drinks','Games','Healthcare','Hobbies','House and Garden','Internet and Telecom','Vacant and Education','Law and Government','News','Online Community','People and Society','Pets and Animals','Property','Reference','Science','Shopping','Sport','Traveling','Other') NOT NULL,
  `rating` int(1) DEFAULT '0',
  `comment` text,
  `url` varchar(127) NOT NULL,
  `submit_page` varchar(255) DEFAULT NULL,
  `costs` tinyint(1) NOT NULL DEFAULT '0',
  `costs_amount` decimal(5,2) DEFAULT NULL,
  `backlink` tinyint(1) NOT NULL DEFAULT '0',
  `owner` varchar(63) DEFAULT NULL,
  `owner_email` varchar(127) DEFAULT NULL,
  `rip_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_linksites_customers1_idx` (`customer_id`),
  CONSTRAINT `fk_linksites_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `submissions`;
CREATE TABLE `submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaigns_id` int(11) NOT NULL,
  `linksites_id` int(11) NOT NULL,
  `status` enum('Not Submitted','Rejected','Accepted','Submitted','Failed') NOT NULL DEFAULT 'Not Submitted',
  `comment` text NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `bot_status` tinyint(1) DEFAULT NULL,
  `bot_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_submissions_campaigns1_idx` (`campaigns_id`),
  KEY `fk_submissions_linksites1_idx` (`linksites_id`),
  CONSTRAINT `fk_submissions_campaigns1` FOREIGN KEY (`campaigns_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_submissions_linksites1` FOREIGN KEY (`linksites_id`) REFERENCES `linksites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL,
  `email` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(63) NOT NULL,
  `lastname` varchar(63) NOT NULL,
  `superuser` int(11) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_users_customers_idx` (`customers_id`),
  CONSTRAINT `fk_users_customers` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `users` VALUES ('999','1','robin@domain.com','8ee60a2e00c90d7e00d5069188dc115b','Robin','De Robot','1','1'); 


