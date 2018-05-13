CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` smallint(3) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE  `location` ADD  `count` INT( 11 ) UNSIGNED NOT NULL ;

ALTER TABLE  `location` CHANGE  `country_id`  `country_id` SMALLINT( 3 ) UNSIGNED NULL DEFAULT NULL ;
ALTER TABLE  `location` CHANGE  `city_id`  `city_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL ;