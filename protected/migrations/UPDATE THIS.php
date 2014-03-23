RENAME TABLE  `skillset` TO  `industry` ;

ALTER TABLE  `skill` ADD UNIQUE (
`name`
);

ALTER TABLE  `skill` ADD  `count` INT( 6 ) NOT NULL ;

UPDATE  `translation` SET  `table` =  'industry' WHERE  `translation`.`table` LIKE "%skillset%";

CREATE TABLE IF NOT EXISTS `user_industry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `industry_id` smallint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  `user_industry` CHANGE  `match_id`  `match_id` INT( 11 ) UNSIGNED NOT NULL ;

ALTER TABLE  `user_industry` CHANGE  `industry_id`  `industry_id` SMALLINT( 3 ) UNSIGNED NOT NULL ;

ALTER TABLE  `user_industry` ADD INDEX (  `match_id` ) ;

ALTER TABLE  `user_industry` ADD INDEX (  `industry_id` ) ;

ALTER TABLE  `user_industry` ADD FOREIGN KEY (  `match_id` ) REFERENCES  `user_match` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `user_industry` ADD FOREIGN KEY (  `industry_id` ) REFERENCES  `industry` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `user_skill` CHANGE  `skillset_id`  `skillset_id` SMALLINT( 2 ) UNSIGNED NULL DEFAULT NULL ;

ALTER TABLE  `industry` ADD  `count` INT( 11 ) UNSIGNED NULL ;

ALTER TABLE  `user` ADD  `personal_achievement` VARCHAR( 140 ) NULL DEFAULT NULL AFTER  `bio` ;

CREATE TABLE IF NOT EXISTS `qr_login` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `scan_at` timestamp NULL DEFAULT NULL,
        `user_id` int(10) unsigned DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
      
ALTER TABLE `qr_login` ADD CONSTRAINT `qr_login_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user` ADD `qrcode` VARCHAR( 128 ) NULL DEFAULT NULL AFTER `activkey`;

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `all_day` tinyint(1) NOT NULL,
  `content` varchar(1500) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `source` varchar(128) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `event` CHANGE `content` `content` VARCHAR( 1500 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;

ALTER TABLE `mail_log` DROP FOREIGN KEY `mail_log_ibfk_1` ;