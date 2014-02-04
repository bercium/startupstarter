CREATE TABLE IF NOT EXISTS `user_tag` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(10) unsigned NOT NULL,
      `tag` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;
ALTER TABLE `user_tag` ADD `applied_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

CREATE TABLE IF NOT EXISTS `notification` (
                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                    `user_id` int(10) unsigned NOT NULL,
                    `type` int(11) NOT NULL,
                    `notify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `viewed` tinyint(1) NOT NULL DEFAULT '0',
                    PRIMARY KEY (`id`),
                    KEY `user_id` (`user_id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `notification` ADD FOREIGN KEY ( `user_id` ) REFERENCES `user` (`id` ) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `user_tag` ADD `content` VARCHAR( 255 ) NULL ;