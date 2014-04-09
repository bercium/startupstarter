
CREATE TABLE IF NOT EXISTS `db_query` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `model` mediumtext NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `idea_translation` CHANGE `description_public` `description_public` TINYINT( 1 ) NOT NULL DEFAULT '1'