-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2013 at 04:12 PM
-- Server version: 5.5.12
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- Dumping data for table `translation`
--

INSERT INTO `translation` (`id`, `language_id`, `table`, `row_id`, `translation`) VALUES
(1, 145, 'collabpref', 1, 'Plačano delo'),
(2, 145, 'collabpref', 2, 'Delovni vložek'),
(3, 145, 'collabpref', 3, 'Enakovreden investitor'),
(4, 145, 'collabpref', 4, 'Investitor'),
(5, 145, 'membertype', 1, 'Lastnik'),
(6, 145, 'membertype', 2, 'Član'),
(7, 145, 'membertype', 3, 'Kandidat'),
(8, 145, 'idea_status', 1, 'Ideja'),
(9, 145, 'idea_status', 2, 'Poslovni načrt'),
(10, 145, 'idea_status', 3, 'Prototip'),
(11, 145, 'idea_status', 4, 'Stranke ki plačujejo'),
(12, 145, 'idea_status', 5, 'Rast'),
(13, 145, 'available', 8, 'Vikendi'),
(14, 145, 'available', 20, 'Polovični delovni čas'),
(15, 145, 'available', 40, 'Polni delovni čas');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
