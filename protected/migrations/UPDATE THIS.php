ALTER TABLE `message` ADD `time_viewed` TIMESTAMP NULL ;
ALTER TABLE `message` CHANGE `time_sent` `time_sent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
    
CREATE TABLE IF NOT EXISTS `mail_log` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `tracking_code` int(11) unsigned NOT NULL,
        `type` varchar(100) DEFAULT NULL,
        `user_to_id` int(10) unsigned NOT NULL,
        `time_send` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `time_open` timestamp NULL DEFAULT NULL,
        `extra_id` int(10) unsigned DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `user_to_id` (`user_to_id`),
        KEY `tracking_code` (`tracking_code`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    
ALTER TABLE `mail_log` ADD CONSTRAINT `mail_log_ibfk_1` FOREIGN KEY (`user_to_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
    
 CREATE TABLE IF NOT EXISTS `mail_click_log` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `mail_tracking_code` int(10) unsigned NOT NULL,
          `link` varchar(255) NOT NULL,
          `time_clicked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `button_name` varchar(200) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `mail_id` (`mail_tracking_code`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
     
  ALTER TABLE `mail_click_log` ADD CONSTRAINT `mail_click_log_ibfk_1` FOREIGN KEY (`mail_tracking_code`) REFERENCES `mail_log` (`tracking_code`) ON DELETE CASCADE ON UPDATE CASCADE;


