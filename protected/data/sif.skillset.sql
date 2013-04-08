-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2013 at 07:01 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.6-1ubuntu1.2

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
-- Table structure for table `skillset`
--

CREATE TABLE IF NOT EXISTS `skillset` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=148 ;

--
-- Dumping data for table `skillset`
--

INSERT INTO `skillset` (`id`, `name`) VALUES
(1, 'Accounting'),
(2, 'Airlines/Aviation'),
(3, 'Alternative Dispute Resolution'),
(4, 'Alternative Medicine'),
(5, 'Animation'),
(6, 'Apparel & Fashion'),
(7, 'Architecture & Planning'),
(8, 'Arts and Crafts'),
(9, 'Automotive'),
(10, 'Aviation & Aerospace'),
(11, 'Banking'),
(12, 'Biotechnology'),
(13, 'Broadcast Media'),
(14, 'Building Materials'),
(15, 'Business Supplies and Equipment'),
(16, 'Capital Markets'),
(17, 'Chemicals'),
(18, 'Civic & Social Organization'),
(19, 'Civil Engineering'),
(20, 'Commercial Real Estate'),
(21, 'Computer & Network Security'),
(22, 'Computer Games'),
(23, 'Computer Hardware'),
(24, 'Computer Networking'),
(25, 'Computer Software'),
(26, 'Construction'),
(27, 'Consumer Electronics'),
(28, 'Consumer Goods'),
(29, 'Consumer Services'),
(30, 'Cosmetics'),
(31, 'Dairy'),
(32, 'Defense & Space'),
(33, 'Design'),
(34, 'Education Management'),
(35, 'E-Learning'),
(36, 'Electrical/Electronic Manufacturing'),
(37, 'Entertainment'),
(38, 'Environmental Services'),
(39, 'Events Services'),
(40, 'Executive Office'),
(41, 'Facilities Services'),
(42, 'Farming'),
(43, 'Financial Services'),
(44, 'Fine Art'),
(45, 'Fishery'),
(46, 'Food & Beverages'),
(47, 'Food Production'),
(48, 'Fund-Raising'),
(49, 'Furniture'),
(50, 'Gambling & Casinos'),
(51, 'Glass, Ceramics & Concrete'),
(52, 'Government Administration'),
(53, 'Government Relations'),
(54, 'Graphic Design'),
(55, 'Health, Wellness and Fitness'),
(56, 'Higher Education'),
(57, 'Hospital & Health Care'),
(58, 'Hospitality'),
(59, 'Human Resources'),
(60, 'Import and Export'),
(61, 'Individual & Family Services'),
(62, 'Industrial Automation'),
(63, 'Information Services'),
(64, 'Information Technology and Services'),
(65, 'Insurance'),
(66, 'International Affairs'),
(67, 'International Trade and Development'),
(68, 'Internet'),
(69, 'Investment Banking'),
(70, 'Investment Management'),
(71, 'Judiciary'),
(72, 'Law Enforcement'),
(73, 'Law Practice'),
(74, 'Legal Services'),
(75, 'Legislative Office'),
(76, 'Leisure, Travel & Tourism'),
(77, 'Libraries'),
(78, 'Logistics and Supply Chain'),
(79, 'Luxury Goods & Jewelry'),
(80, 'Machinery'),
(81, 'Management Consulting'),
(82, 'Maritime'),
(83, 'Marketing and Advertising'),
(84, 'Market Research'),
(85, 'Mechanical or Industrial Engineering'),
(86, 'Media Production'),
(87, 'Medical Devices'),
(88, 'Medical Practice'),
(89, 'Mental Health Care'),
(90, 'Military'),
(91, 'Mining & Metals'),
(92, 'Motion Pictures and Film'),
(93, 'Museums and Institutions'),
(94, 'Music'),
(95, 'Nanotechnology'),
(96, 'Newspapers'),
(97, 'Nonprofit Organization Management'),
(98, 'Oil & Energy'),
(99, 'Online Media'),
(100, 'Outsourcing/Offshoring'),
(101, 'Package/Freight Delivery'),
(102, 'Packaging and Containers'),
(103, 'Paper & Forest Products'),
(104, 'Performing Arts'),
(105, 'Pharmaceuticals'),
(106, 'Philanthropy'),
(107, 'Photography'),
(108, 'Plastics'),
(109, 'Political Organization'),
(110, 'Primary/Secondary Education'),
(111, 'Printing'),
(112, 'Professional Training & Coaching'),
(113, 'Program Development'),
(114, 'Public Policy'),
(115, 'Public Relations and Communications'),
(116, 'Public Safety'),
(117, 'Publishing'),
(118, 'Railroad Manufacture'),
(119, 'Ranching'),
(120, 'Real Estate'),
(121, 'Recreational Facilities and Services'),
(122, 'Religious Institutions'),
(123, 'Renewables & Environment'),
(124, 'Research'),
(125, 'Restaurants'),
(126, 'Retail'),
(127, 'Security and Investigations'),
(128, 'Semiconductors'),
(129, 'Shipbuilding'),
(130, 'Sporting Goods'),
(131, 'Sports'),
(132, 'Staffing and Recruiting'),
(133, 'Supermarkets'),
(134, 'Telecommunications'),
(135, 'Textiles'),
(136, 'Think Tanks'),
(137, 'Tobacco'),
(138, 'Translation and Localization'),
(139, 'Transportation/Trucking/Railroad'),
(140, 'Utilities'),
(141, 'Venture Capital & Private Equity'),
(142, 'Veterinary'),
(143, 'Warehousing'),
(144, 'Wholesale'),
(145, 'Wine and Spirits'),
(146, 'Wireless'),
(147, 'Writing and Editing');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
