-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 17. apr 2013 ob 19.00
-- Različica strežnika: 5.5.27
-- Različica PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Zbirka podatkov: `slocoworking`
--

-- --------------------------------------------------------



--
-- Struktura tabele `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=501 ;

--
-- Struktura tabele `collabpref`
--

CREATE TABLE IF NOT EXISTS `collabpref` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Struktura tabele `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `language_code` varchar(2) NOT NULL,
  `name` varchar(32) NOT NULL,
  `native_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=183 ;

-- --------------------------------------------------------

--
-- Struktura tabele `membertype`
--

CREATE TABLE IF NOT EXISTS `membertype` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struktura tabele `skill`
--

CREATE TABLE IF NOT EXISTS `skill` (
  `id` mediumint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktura tabele `skillset`
--

CREATE TABLE IF NOT EXISTS `skillset` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=148 ;

-- --------------------------------------------------------

--
-- Struktura tabele `skillset_skill`
--

CREATE TABLE IF NOT EXISTS `skillset_skill` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `skillset_id` smallint(2) unsigned NOT NULL,
  `skill_id` mediumint(3) unsigned NOT NULL,
  `usage_count` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `skillset_id` (`skillset_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Struktura tabele `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=250 ;

-- --------------------------------------------------------


--
-- Struktura tabele `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabele `translation`
--

CREATE TABLE IF NOT EXISTS `translation` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` smallint(2) unsigned NOT NULL,
  `table` varchar(64) NOT NULL COMMENT 'Table containing the message to be translated',
  `row_id` int(10) unsigned NOT NULL COMMENT 'The exact message to be translated (row of the table)',
  `translation` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Struktura tabele `idea_status`
--

CREATE TABLE IF NOT EXISTS `idea_status` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktura tabele `idea`
--

CREATE TABLE IF NOT EXISTS `idea` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status_id` smallint(2) unsigned NOT NULL,
  `website` varchar(128) DEFAULT NULL,
  `video_link` varchar(128) DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Struktura tabele `idea_translation`
--

CREATE TABLE IF NOT EXISTS `idea_translation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` smallint(2) unsigned NOT NULL,
  `idea_id` int(8) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `pitch` text NOT NULL,
  `description` text,
  `description_public` tinyint(1) NOT NULL,
  `tweetpitch` varchar(140) DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idea_id` (`idea_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Struktura tabele `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `surname` varchar(128) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `avatar_link` varchar(128) DEFAULT NULL,
  `language_id` smallint(2) unsigned DEFAULT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Struktura tabele `user_link`
--

CREATE TABLE IF NOT EXISTS `user_link` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabele `user_match`
--

CREATE TABLE IF NOT EXISTS `user_match` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `country_id` smallint(3) unsigned DEFAULT NULL,
  `city_id` int(10) unsigned DEFAULT NULL,
  `available` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  KEY `country_id` (`country_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Extra data for users or virtual (searchable) users' AUTO_INCREMENT=13 ;

--
-- Struktura tabele `user_collabpref`
--

CREATE TABLE IF NOT EXISTS `user_collabpref` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(8) unsigned NOT NULL,
  `collab_id` smallint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `collab_id` (`collab_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------
--
-- Struktura tabele `user_skill`
--

CREATE TABLE IF NOT EXISTS `user_skill` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(8) unsigned NOT NULL,
  `skillset_id` smallint(2) unsigned NOT NULL,
  `skill_id` mediumint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `skillset_id` (`skillset_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Struktura tabele `audit_trail`
--

CREATE TABLE IF NOT EXISTS `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_value` text,
  `new_value` text,
  `action` varchar(20) NOT NULL,
  `model` varchar(255) NOT NULL,
  `field` varchar(100) NOT NULL,
  `stamp` datetime NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `model_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_audit_trail_user_id` (`user_id`),
  KEY `idx_audit_trail_model_id` (`model_id`),
  KEY `idx_audit_trail_model` (`model`),
  KEY `idx_audit_trail_field` (`field`),
  KEY `idx_audit_trail_action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabele `click_idea`
--

CREATE TABLE IF NOT EXISTS `click_idea` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned DEFAULT NULL,
  `idea_click_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idea_click_id` (`idea_click_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `click_user`
--

CREATE TABLE IF NOT EXISTS `click_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned DEFAULT NULL,
  `user_click_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_click_id` (`user_click_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `idea_member`
--

CREATE TABLE IF NOT EXISTS `idea_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idea_id` int(9) unsigned NOT NULL,
  `match_id` int(8) unsigned NOT NULL,
  `type_id` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idea_id` (`idea_id`),
  KEY `match_id` (`match_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------


--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `click_idea`
--
ALTER TABLE `click_idea`
  ADD CONSTRAINT `click_idea_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `click_idea_ibfk_5` FOREIGN KEY (`idea_click_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `click_user`
--
ALTER TABLE `click_user`
  ADD CONSTRAINT `click_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `click_user_ibfk_2` FOREIGN KEY (`user_click_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `idea`
--
ALTER TABLE `idea`
  ADD CONSTRAINT `idea_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `idea_status` (`id`);

--
-- Omejitve za tabelo `idea_member`
--
ALTER TABLE `idea_member`
  ADD CONSTRAINT `idea_member_ibfk_3` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `idea_member_ibfk_5` FOREIGN KEY (`match_id`) REFERENCES `user_match` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `idea_member_ibfk_6` FOREIGN KEY (`type_id`) REFERENCES `membertype` (`id`);

--
-- Omejitve za tabelo `idea_translation`
--
ALTER TABLE `idea_translation`
  ADD CONSTRAINT `idea_translation_ibfk_1` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`),
  ADD CONSTRAINT `idea_translation_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Omejitve za tabelo `skillset_skill`
--
ALTER TABLE `skillset_skill`
  ADD CONSTRAINT `skillset_skill_ibfk_1` FOREIGN KEY (`skillset_id`) REFERENCES `skillset` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `skillset_skill_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `translation`
--
ALTER TABLE `translation`
  ADD CONSTRAINT `translation_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Omejitve za tabelo `user_collabpref`
--
ALTER TABLE `user_collabpref`
  ADD CONSTRAINT `user_collabpref_ibfk_2` FOREIGN KEY (`collab_id`) REFERENCES `collabpref` (`id`),
  ADD CONSTRAINT `user_collabpref_ibfk_3` FOREIGN KEY (`match_id`) REFERENCES `user_match` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `user_link`
--
ALTER TABLE `user_link`
  ADD CONSTRAINT `user_link_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `user_match`
--
ALTER TABLE `user_match`
  ADD CONSTRAINT `user_match_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `user_match_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `user_match_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `user_skill`
--
ALTER TABLE `user_skill`
  ADD CONSTRAINT `user_skill_ibfk_2` FOREIGN KEY (`skillset_id`) REFERENCES `skillset` (`id`),
  ADD CONSTRAINT `user_skill_ibfk_3` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`),
  ADD CONSTRAINT `user_skill_ibfk_4` FOREIGN KEY (`match_id`) REFERENCES `user_match` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
