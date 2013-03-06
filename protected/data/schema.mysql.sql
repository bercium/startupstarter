-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 04. mar 2013 ob 16.18
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
CREATE DATABASE `slocoworking` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `slocoworking`;

-- --------------------------------------------------------

--
-- Struktura tabele `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `collabprefs`
--

CREATE TABLE IF NOT EXISTS `collabprefs` (
  `ID` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `ID` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `ideas`
--

CREATE TABLE IF NOT EXISTS `ideas` (
  `ID` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `time_registered` int(11) unsigned NOT NULL,
  `time_updated` int(11) unsigned NOT NULL,
  `status_id` smallint(2) unsigned NOT NULL,
  `progress` smallint(3) unsigned NOT NULL,
  `website` varchar(128) NOT NULL,
  `video_link` varchar(128) NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELACIJE ZA TABELO `ideas`:
--   `status_id`
--       `ideas_statuses` -> `ID`
--

-- --------------------------------------------------------

--
-- Struktura tabele `ideas_members`
--

CREATE TABLE IF NOT EXISTS `ideas_members` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idea_id` int(9) unsigned NOT NULL,
  `user_id` int(8) unsigned NOT NULL,
  `type` tinyint(2) unsigned NOT NULL COMMENT '3 types for now: 1 = member, 2 = owner, 3 = candidate profile',
  `deleted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idea_id` (`idea_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELACIJE ZA TABELO `ideas_members`:
--   `idea_id`
--       `ideas` -> `ID`
--   `user_id`
--       `users` -> `ID`
--

-- --------------------------------------------------------

--
-- Struktura tabele `ideas_statuses`
--

CREATE TABLE IF NOT EXISTS `ideas_statuses` (
  `ID` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `ideas_translations`
--

CREATE TABLE IF NOT EXISTS `ideas_translations` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_code` varchar(2) NOT NULL,
  `idea_id` int(8) unsigned NOT NULL,
  `pitch` text NOT NULL,
  `description` text NOT NULL,
  `description_public` tinyint(1) NOT NULL,
  `tweetpitch` varchar(140) NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idea_id` (`idea_id`),
  KEY `language_code` (`language_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELACIJE ZA TABELO `ideas_translations`:
--   `idea_id`
--       `ideas` -> `ID`
--   `language_code`
--       `languages` -> `language_code`
--

-- --------------------------------------------------------

--
-- Struktura tabele `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `ID` smallint(2) NOT NULL AUTO_INCREMENT,
  `language_code` varchar(2) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `language_code` (`language_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `ID` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(11) unsigned NOT NULL,
  `user_id` int(8) unsigned NOT NULL,
  `request` varchar(64) NOT NULL COMMENT 'Type of request',
  `table` varchar(64) NOT NULL COMMENT 'Which table was affected? (optional)',
  `row_id` int(10) unsigned NOT NULL COMMENT 'Which row was affected? (optional)',
  PRIMARY KEY (`ID`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELACIJE ZA TABELO `logs`:
--   `user_id`
--       `users` -> `ID`
--

-- --------------------------------------------------------

--
-- Struktura tabele `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `ID` mediumint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `skillsets`
--

CREATE TABLE IF NOT EXISTS `skillsets` (
  `ID` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `skillsets_skills`
--

CREATE TABLE IF NOT EXISTS `skillsets_skills` (
  `ID` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `skillset_id` smallint(2) unsigned NOT NULL,
  `skill_id` mediumint(3) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `skillset_id` (`skillset_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELACIJE ZA TABELO `skillsets_skills`:
--   `skill_id`
--       `skills` -> `ID`
--   `skillset_id`
--       `skillsets` -> `ID`
--

-- --------------------------------------------------------

--
-- Struktura tabele `translations`
--

CREATE TABLE IF NOT EXISTS `translations` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `language_code` varchar(2) NOT NULL,
  `table` varchar(64) NOT NULL COMMENT 'Table containing the message to be translated',
  `row_id` int(10) unsigned NOT NULL COMMENT 'The exact message to be translated (row of the table)',
  `translation` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `language_code` (`language_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELACIJE ZA TABELO `translations`:
--   `language_code`
--       `languages` -> `language_code`
--

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `VIRTUAL` tinyint(1) unsigned NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `surname` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `md5_pass` varchar(32) DEFAULT NULL,
  `time_registered` int(11) unsigned NOT NULL,
  `time_updated` int(11) unsigned NOT NULL,
  `avatar_link` varchar(128) DEFAULT NULL,
  `progress` smallint(3) unsigned DEFAULT NULL COMMENT 'Percentage of profile completeness',
  `time_per_week` int(3) unsigned DEFAULT NULL,
  `newsletter` tinyint(1) unsigned DEFAULT NULL,
  `language_code` varchar(2) DEFAULT NULL,
  `country_id` smallint(3) unsigned DEFAULT NULL,
  `city_id` int(10) unsigned DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `language_code` (`language_code`),
  KEY `country_id` (`country_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- RELACIJE ZA TABELO `users`:
--   `city_id`
--       `cities` -> `ID`
--   `country_id`
--       `countries` -> `ID`
--   `language_code`
--       `languages` -> `language_code`
--

-- --------------------------------------------------------

--
-- Struktura tabele `users_collabprefs`
--

CREATE TABLE IF NOT EXISTS `users_collabprefs` (
  `ID` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) unsigned NOT NULL,
  `collab_id` smallint(2) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `user_id` (`user_id`),
  KEY `collab_id` (`collab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELACIJE ZA TABELO `users_collabprefs`:
--   `collab_id`
--       `collabprefs` -> `ID`
--   `user_id`
--       `users` -> `ID`
--

-- --------------------------------------------------------

--
-- Struktura tabele `users_links`
--

CREATE TABLE IF NOT EXISTS `users_links` (
  `ID` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) unsigned NOT NULL,
  `link_id` int(9) unsigned NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `link_id` (`link_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELACIJE ZA TABELO `users_links`:
--   `link_id`
--       `links` -> `ID`
--   `user_id`
--       `users` -> `ID`
--

-- --------------------------------------------------------

--
-- Struktura tabele `users_skills`
--

CREATE TABLE IF NOT EXISTS `users_skills` (
  `ID` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) unsigned NOT NULL,
  `skillset_id` smallint(2) unsigned NOT NULL,
  `skill_id` mediumint(3) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `user_id` (`user_id`),
  KEY `skillset_id` (`skillset_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELACIJE ZA TABELO `users_skills`:
--   `skill_id`
--       `skills` -> `ID`
--   `skillset_id`
--       `skillsets` -> `ID`
--   `user_id`
--       `users` -> `ID`
--

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `ideas`
--
ALTER TABLE `ideas`
  ADD CONSTRAINT `ideas_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `ideas_statuses` (`ID`);

--
-- Omejitve za tabelo `ideas_members`
--
ALTER TABLE `ideas_members`
  ADD CONSTRAINT `ideas_members_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `ideas_members_ibfk_3` FOREIGN KEY (`idea_id`) REFERENCES `ideas` (`ID`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `ideas_translations`
--
ALTER TABLE `ideas_translations`
  ADD CONSTRAINT `ideas_translations_ibfk_2` FOREIGN KEY (`language_code`) REFERENCES `languages` (`language_code`),
  ADD CONSTRAINT `ideas_translations_ibfk_1` FOREIGN KEY (`idea_id`) REFERENCES `ideas` (`ID`);

--
-- Omejitve za tabelo `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`);

--
-- Omejitve za tabelo `skillsets_skills`
--
ALTER TABLE `skillsets_skills`
  ADD CONSTRAINT `skillsets_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `skillsets_skills_ibfk_1` FOREIGN KEY (`skillset_id`) REFERENCES `skillsets` (`ID`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `translations`
--
ALTER TABLE `translations`
  ADD CONSTRAINT `translations_ibfk_1` FOREIGN KEY (`language_code`) REFERENCES `languages` (`language_code`);

--
-- Omejitve za tabelo `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`country_id`) REFERENCES `countries` (`ID`),
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`language_code`) REFERENCES `languages` (`language_code`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `cities` (`ID`);

--
-- Omejitve za tabelo `users_collabprefs`
--
ALTER TABLE `users_collabprefs`
  ADD CONSTRAINT `users_collabprefs_ibfk_2` FOREIGN KEY (`collab_id`) REFERENCES `collabprefs` (`ID`),
  ADD CONSTRAINT `users_collabprefs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `users_links`
--
ALTER TABLE `users_links`
  ADD CONSTRAINT `users_links_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_links_ibfk_1` FOREIGN KEY (`link_id`) REFERENCES `links` (`ID`);

--
-- Omejitve za tabelo `users_skills`
--
ALTER TABLE `users_skills`
  ADD CONSTRAINT `users_skills_ibfk_3` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`ID`),
  ADD CONSTRAINT `users_skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_skills_ibfk_2` FOREIGN KEY (`skillset_id`) REFERENCES `skillsets` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
