CREATE TABLE `action_log` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `user_id` int(10) unsigned DEFAULT NULL,
 `ipaddress` varchar(50) NOT NULL,
 `logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `controller` varchar(255) NOT NULL DEFAULT '',
 `action` varchar(255) NOT NULL DEFAULT '',
 `details` text,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8