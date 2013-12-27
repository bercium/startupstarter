
ALTER TABLE  `user_link` CHANGE  `user_id`  `user_id` INT( 11 ) UNSIGNED NOT NULL;
ALTER TABLE  `user` ADD  `bio` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

CREATE TABLE IF NOT EXISTS `idea_link` (
						  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						  `idea_id` int(11) unsigned NOT NULL,
						  `title` varchar(128) NOT NULL,
						  `url` varchar(128) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idea_id` (`idea_id`)
						) ENGINE=MyIsam DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
            

CREATE TABLE IF NOT EXISTS `idea_gallery` (
		  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
		  `idea_id` int(11) unsigned NOT NULL,
		  `url` varchar(128) NOT NULL,
		  `front` tinyint(1) NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `idea_id` (`idea_id`)
		) ENGINE=MyIsam DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `invite` DROP INDEX `id_sender` , ADD INDEX `sender_id` ( `sender_id` );
ALTER TABLE `invite` DROP INDEX `id_idea` , ADD INDEX `idea_id` ( `idea_id` );
ALTER TABLE `invite` DROP INDEX `id_receiver` , ADD INDEX `receiver_id` ( `receiver_id` );

ALTER TABLE `user` CHANGE `bio` `bio` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `idea_gallery` CHANGE `front` `front` TINYINT( 1 ) NOT NULL DEFAULT '0';

ALTER TABLE `user` ADD `vanityURL` VARCHAR( 128 ) NULL;
ALTER TABLE `idea` ADD `vanityURL` VARCHAR( 128 ) NULL;
CREATE TABLE IF NOT EXISTS `message` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_from_id` int(11) unsigned NOT NULL,
          `user_to_id` int(11) unsigned DEFAULT NULL,
          `idea_to_id` int(11) unsigned DEFAULT NULL,
          `time_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `message` text NOT NULL,
          PRIMARY KEY (`id`),
          KEY `user_from_id` (`user_from_id`),
          KEY `user_to_id` (`user_to_id`),
          KEY `idea_to_id` (`idea_to_id`)
        ) ENGINE=MyIsam  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  `idea_gallery` CHANGE  `front`  `cover` TINYINT( 1 ) NULL DEFAULT NULL;

ALTER TABLE `invite` CHANGE `sender_id` `sender_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `invite` ADD `code` VARCHAR( 126 ) NULL;
ALTER TABLE `invite` ADD `registered` BOOLEAN NOT NULL DEFAULT '0';


CREATE TABLE IF NOT EXISTS `user_stat` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` int(10) unsigned NOT NULL,
        `completeness` int(11) NOT NULL DEFAULT '0',
        `invites_send` int(11) NOT NULL DEFAULT '0',
        `invites_registered` int(11) NOT NULL DEFAULT '0',
        `reputation` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`)
      ) ENGINE=MyIsam DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `user_stat` ADD UNIQUE (`user_id`);



