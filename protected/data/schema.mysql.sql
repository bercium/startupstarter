-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2014 at 03:01 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.6-1ubuntu1.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `slocoworking`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
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

-- --------------------------------------------------------

--
-- Table structure for table `available`
--

CREATE TABLE IF NOT EXISTS `available` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `click_idea`
--

CREATE TABLE IF NOT EXISTS `click_idea` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned DEFAULT NULL,
  `idea_click_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idea_click_id` (`idea_click_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `click_user`
--

CREATE TABLE IF NOT EXISTS `click_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned DEFAULT NULL,
  `user_click_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_click_id` (`user_click_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `collabpref`
--

CREATE TABLE IF NOT EXISTS `collabpref` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `idea`
--

CREATE TABLE IF NOT EXISTS `idea` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status_id` smallint(2) unsigned NOT NULL,
  `website` varchar(128) DEFAULT NULL,
  `video_link` varchar(128) DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vanityURL` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `idea_gallery`
--

CREATE TABLE IF NOT EXISTS `idea_gallery` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `idea_id` int(11) unsigned NOT NULL,
  `url` varchar(128) NOT NULL,
  `cover` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idea_id` (`idea_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `idea_link`
--

CREATE TABLE IF NOT EXISTS `idea_link` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `idea_id` int(11) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idea_id` (`idea_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `idea_member`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `idea_status`
--

CREATE TABLE IF NOT EXISTS `idea_status` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `idea_translation`
--

CREATE TABLE IF NOT EXISTS `idea_translation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` smallint(2) unsigned NOT NULL,
  `idea_id` int(8) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `pitch` text NOT NULL,
  `description` text,
  `description_public` tinyint(1) NOT NULL,
  `keywords` text,
  `tweetpitch` varchar(140) DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idea_id` (`idea_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invite`
--

CREATE TABLE IF NOT EXISTS `invite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) unsigned DEFAULT NULL,
  `key` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `idea_id` int(11) unsigned DEFAULT NULL,
  `receiver_id` int(11) unsigned DEFAULT NULL,
  `time_invited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` varchar(126) DEFAULT NULL,
  `registered` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `idea_id` (`idea_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(2) unsigned NOT NULL DEFAULT '1',
  `table` varchar(64) NOT NULL,
  `row_id` int(10) unsigned NOT NULL,
  `keyword` varchar(32) NOT NULL,
  `language_id` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `language_code` varchar(2) NOT NULL,
  `name` varchar(32) NOT NULL,
  `native_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `membertype`
--

CREATE TABLE IF NOT EXISTS `membertype` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from_id` int(11) NOT NULL,
  `user_to_id` int(11) DEFAULT NULL,
  `idea_to_id` int(11) DEFAULT NULL,
  `time_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE IF NOT EXISTS `skill` (
  `id` mediumint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skillset`
--

CREATE TABLE IF NOT EXISTS `skillset` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skillset_skill`
--

CREATE TABLE IF NOT EXISTS `skillset_skill` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `skillset_id` smallint(2) unsigned NOT NULL,
  `skill_id` mediumint(3) unsigned NOT NULL,
  `usage_count` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `skillset_id` (`skillset_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `translation`
--

CREATE TABLE IF NOT EXISTS `translation` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` smallint(2) unsigned NOT NULL,
  `table` varchar(64) NOT NULL COMMENT 'Table containing the message to be translated',
  `row_id` int(10) unsigned NOT NULL COMMENT 'The exact message to be translated (row of the table)',
  `translation` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
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
  `invitations` int(11) NOT NULL DEFAULT '0',
  `bio` text,
  `vanityURL` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_collabpref`
--

CREATE TABLE IF NOT EXISTS `user_collabpref` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(8) unsigned NOT NULL,
  `collab_id` smallint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `collab_id` (`collab_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_link`
--

CREATE TABLE IF NOT EXISTS `user_link` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_match`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Extra data for users or virtual (searchable) users' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_skill`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_stat`
--

CREATE TABLE IF NOT EXISTS `user_stat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `completeness` int(11) NOT NULL DEFAULT '0',
  `invites_send` int(11) NOT NULL DEFAULT '0',
  `invites_registered` int(11) NOT NULL DEFAULT '0',
  `reputation` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `click_idea`
--
ALTER TABLE `click_idea`
  ADD CONSTRAINT `click_idea_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `click_idea_ibfk_5` FOREIGN KEY (`idea_click_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `click_user`
--
ALTER TABLE `click_user`
  ADD CONSTRAINT `click_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `click_user_ibfk_2` FOREIGN KEY (`user_click_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `idea`
--
ALTER TABLE `idea`
  ADD CONSTRAINT `idea_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `idea_status` (`id`);

--
-- Constraints for table `idea_gallery`
--
ALTER TABLE `idea_gallery`
  ADD CONSTRAINT `idea_gallery_ibfk_1` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `idea_link`
--
ALTER TABLE `idea_link`
  ADD CONSTRAINT `idea_link_ibfk_1` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `idea_member`
--
ALTER TABLE `idea_member`
  ADD CONSTRAINT `idea_member_ibfk_3` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `idea_member_ibfk_5` FOREIGN KEY (`match_id`) REFERENCES `user_match` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `idea_member_ibfk_6` FOREIGN KEY (`type_id`) REFERENCES `membertype` (`id`);

--
-- Constraints for table `idea_translation`
--
ALTER TABLE `idea_translation`
  ADD CONSTRAINT `idea_translation_ibfk_1` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`),
  ADD CONSTRAINT `idea_translation_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Constraints for table `invite`
--
ALTER TABLE `invite`
  ADD CONSTRAINT `invite_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invite_ibfk_2` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invite_ibfk_3` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skillset_skill`
--
ALTER TABLE `skillset_skill`
  ADD CONSTRAINT `skillset_skill_ibfk_1` FOREIGN KEY (`skillset_id`) REFERENCES `skillset` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `skillset_skill_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `translation`
--
ALTER TABLE `translation`
  ADD CONSTRAINT `translation_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Constraints for table `user_collabpref`
--
ALTER TABLE `user_collabpref`
  ADD CONSTRAINT `user_collabpref_ibfk_2` FOREIGN KEY (`collab_id`) REFERENCES `collabpref` (`id`),
  ADD CONSTRAINT `user_collabpref_ibfk_3` FOREIGN KEY (`match_id`) REFERENCES `user_match` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_link`
--
ALTER TABLE `user_link`
  ADD CONSTRAINT `user_link_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_match`
--
ALTER TABLE `user_match`
  ADD CONSTRAINT `user_match_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `user_match_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `user_match_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_skill`
--
ALTER TABLE `user_skill`
  ADD CONSTRAINT `user_skill_ibfk_2` FOREIGN KEY (`skillset_id`) REFERENCES `skillset` (`id`),
  ADD CONSTRAINT `user_skill_ibfk_3` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`),
  ADD CONSTRAINT `user_skill_ibfk_4` FOREIGN KEY (`match_id`) REFERENCES `user_match` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_stat`
--
ALTER TABLE `user_stat`
  ADD CONSTRAINT `user_stat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
