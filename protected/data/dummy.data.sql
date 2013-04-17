-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 17. apr 2013 ob 11.54
-- Različica strežnika: 5.5.27
-- Različica PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

INSERT INTO `collabpref` (`id`, `name`) VALUES
(1, 'Monetary'),
(2, 'Sweat equity'),
(3, 'Flexible');

INSERT INTO `idea_status` (`id`, `name`) VALUES
(1, 'Idea'),
(2, 'Prototype');

INSERT INTO `skill` (`id`, `name`) VALUES
(1, 'HTML'),
(2, 'PHP');

INSERT INTO `membertype` (`id`, `name`) VALUES
(1, 'Owner'),
(2, 'Member'),
(3, 'Candidate');

INSERT INTO `user` (`id`, `email`, `password`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`, `name`, `surname`, `address`, `avatar_link`, `language_id`, `newsletter`) VALUES
(1, 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3', '9a24eff8c15a6a141ece27eb6947da0f', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 1, 1, 'Administrator', 'User', NULL, NULL, NULL, 1),
(2, 'demo@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 0, 1, 'Demo', 'User', NULL, NULL, NULL, 1);

INSERT INTO `user_match` (`id`, `user_id`, `available`, `country_id`, `city_id`) VALUES 
(1, 2, 1, 1, 1),
(2, 1, 1, 1, 1),
(3, NULL, 1, 1, 1),
(8, NULL, 1, 1, 1),
(10, NULL, 2, 1, 1),
(12, NULL, 2, 1, 1);

INSERT INTO `user_collabpref` (`id`, `match_id`, `collab_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(7, 2, 1);

INSERT INTO `user_skill` (`id`, `match_id`, `skillset_id`, `skill_id`) VALUES
(1, 1, 1, 1),
(3, 2, 1, 1),
(6, 2, 1, 2);

INSERT INTO `idea` (`id`, `time_registered`, `time_updated`, `status_id`, `website`, `video_link`, `deleted`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'cofinder.com', NULL, 0),
(11, '2013-04-12 14:45:17', '0000-00-00 00:00:00', 1, NULL, NULL, 0);

INSERT INTO `idea_translation` (`id`, `language_id`, `idea_id`, `title`, `pitch`, `description`, `description_public`, `tweetpitch`, `deleted`) VALUES
(1, 40, 1, 'Great idea', 'Hoho', 'Hihi', 1, 'tweet', 0),
(7, 145, 1, 'Velika ideja', 'sdfsfs', '', 0, '', 0),
(14, 145, 11, 'To je nova ideja', 'To je pitch nove ideje', '', 0, '', 1),
(15, 40, 11, 'This is a new idea', 'Pitch of it', '', 1, '', 0);

INSERT INTO `idea_member` (`id`, `idea_id`, `match_id`, `type_id`) VALUES
(1, 1, 3, 1),
(2, 1, 1, 1),
(7, 1, 8, 3),
(9, 1, 2, 1),
(14, 11, 1, 1),
(16, 11, 10, 3),
(17, 11, 12, 3);

UPDATE `idea_translation` SET language_id = 40 WHERE language_id = 1;
UPDATE `idea_translation` SET language_id = 145 WHERE language_id = 2;