
CREATE TABLE IF NOT EXISTS `db_query` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `model` mediumtext NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `idea_translation` CHANGE `description_public` `description_public` TINYINT( 1 ) NOT NULL DEFAULT '1';

CREATE TABLE IF NOT EXISTS `event_cofinder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) unsigned NOT NULL,
  `price_person` smallint(3) unsigned NOT NULL,
  `price_idea` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

#ALTER TABLE `event_cofinder`
#  ADD CONSTRAINT `event_cofinder_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `event_signup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idea_id` int(11) unsigned NOT NULL,
  `payment` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  `event_signup` ADD  `survey` TEXT NOT NULL ;

#ALTER TABLE `event_signup`
#  ADD CONSTRAINT `event_signup_ibfk_3` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
#  ADD CONSTRAINT `event_signup_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
#  ADD CONSTRAINT `event_signup_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE  `event_signup` CHANGE  `idea_id`  `idea_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ;


#ALTER TABLE  `event_signup` CHANGE  `referrer_id`  `referrer_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ;

#ALTER TABLE  `event_signup` ADD FOREIGN KEY (  `referrer_id` ) REFERENCES  `user` (
#`id`
#) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `event_signup` ADD  `canceled` TINYINT UNSIGNED NULL DEFAULT  '0';
#TAG

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


CREATE TABLE IF NOT EXISTS `tag_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `added_by` int(11) unsigned NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revoked_by` int(11) unsigned DEFAULT NULL,
  `revoked_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`,`user_id`,`added_by`,`revoked_by`),
  KEY `user_id` (`user_id`),
  KEY `added_by` (`added_by`),
  KEY `revoked_by` (`revoked_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `tag_event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) unsigned NOT NULL,
  `event_id` int(11) unsigned NOT NULL,
  `added_by` int(11) unsigned NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revoked_by` int(11) unsigned DEFAULT NULL,
  `revoked_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `event_id` (`event_id`),
  KEY `added_by` (`added_by`),
  KEY `revoked_by` (`revoked_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `tag_idea` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) unsigned NOT NULL,
  `idea_id` int(11) unsigned NOT NULL,
  `added_by` int(11) unsigned NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revoked_by` int(11) unsigned DEFAULT NULL,
  `revoked_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `added_by` (`added_by`),
  KEY `tag_id` (`tag_id`,`idea_id`,`revoked_by`),
  KEY `idea_id` (`idea_id`),
  KEY `revoked_by` (`revoked_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


CREATE TABLE IF NOT EXISTS `tag_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `added_by` int(11) unsigned NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revoked_by` int(11) unsigned DEFAULT NULL,
  `revoked_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`,`user_id`,`added_by`,`revoked_by`),
  KEY `user_id` (`user_id`),
  KEY `added_by` (`added_by`),
  KEY `revoked_by` (`revoked_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


ALTER TABLE `tag_admin`
  ADD CONSTRAINT `tag_admin_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_admin_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_admin_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_admin_ibfk_4` FOREIGN KEY (`revoked_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tag_event`
  ADD CONSTRAINT `tag_event_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_event_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_event_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_event_ibfk_4` FOREIGN KEY (`revoked_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tag_idea`
  ADD CONSTRAINT `tag_idea_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_idea_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_idea_ibfk_3` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_idea_ibfk_4` FOREIGN KEY (`revoked_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tag_user`
  ADD CONSTRAINT `tag_user_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_user_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_user_ibfk_4` FOREIGN KEY (`revoked_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;