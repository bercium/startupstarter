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
-- Struktura tabele `available`
--

CREATE TABLE IF NOT EXISTS `available` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;

--
-- Dumping data for table `available`
--

INSERT INTO `available` (`id`, `name`) VALUES
(40, 'Full time'),
(20, 'Part time'),
(8, 'Weekends');


--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=501 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(1, 'Amsterdam'),
(2, 'Athinai'),
(3, 'Barcelona'),
(4, 'Barnaul'),
(5, 'Beograd'),
(6, 'Berlin'),
(7, 'Birmingham'),
(8, 'Bremen'),
(9, 'Bucaresti'),
(10, 'Budapest'),
(11, 'Chelyabinsk'),
(12, 'Dnepropetrovsk'),
(13, 'Donetsk'),
(14, 'Dortmund'),
(15, 'Duisburg'),
(16, 'Düsseldorf'),
(17, 'Ekaterinoburg'),
(18, 'Essen'),
(19, 'Frankfurt am Main'),
(20, 'Genova'),
(21, 'Glasgow'),
(22, 'Hamburg'),
(23, 'Hannover'),
(24, 'Helsinki'),
(25, 'Irkutsk'),
(26, 'Izhevsk'),
(27, 'Kazan'),
(28, 'Kemerovo'),
(29, 'Khabarovsk'),
(30, 'Kharkov'),
(31, 'Kiev'),
(32, 'Kishinev'),
(33, 'Kobenhavn'),
(34, 'Köln'),
(35, 'Kraków'),
(36, 'Krasnodar'),
(37, 'Krasnoyarsk'),
(38, 'Kryvy Rig'),
(39, 'Leeds'),
(40, 'Lipetsk'),
(41, 'Lisboa'),
(42, 'Lódz'),
(43, 'London'),
(44, 'Lvov'),
(45, 'Madrif'),
(46, 'Málaga'),
(47, 'Marseille'),
(48, 'Milano'),
(49, 'Minsk'),
(50, 'Moskva'),
(51, 'München'),
(52, 'Mykolaiv'),
(53, 'Naberezhnye Tchelny'),
(54, 'Napoli'),
(55, 'Nizhny Novgorod'),
(56, 'Novokuznetsk'),
(57, 'Novosibirsk'),
(58, 'Odessa'),
(59, 'Omsk'),
(60, 'Orenburg'),
(61, 'Oslo'),
(62, 'Palermo'),
(63, 'Paris'),
(64, 'Penza'),
(65, 'Perm'),
(66, 'Poznan'),
(67, 'Praha'),
(68, 'Riga'),
(69, 'Roma'),
(70, 'Rostov-na-Donu'),
(71, 'Rotterdam'),
(72, 'Ryazan'),
(73, 'Salonika'),
(74, 'Samara'),
(75, 'Sarajevo'),
(76, 'Saratov'),
(77, 'Sevilla'),
(78, 'Sheffield'),
(79, 'Sofia'),
(80, 'St Petersburg'),
(81, 'Stockholm'),
(82, 'Stuttgart'),
(83, 'Tolyatti'),
(84, 'Torino'),
(85, 'Tula'),
(86, 'Tyumen'),
(87, 'Ufa'),
(88, 'Ulyanovsk'),
(89, 'Valencia'),
(90, 'Vilnius'),
(91, 'Vladivostok'),
(92, 'Volgograd'),
(93, 'Voronezh'),
(94, 'Warszawa'),
(95, 'Wien'),
(96, 'Wroclaw'),
(97, 'Yaroslave'),
(98, 'Zagreb'),
(99, 'Zaporozhye'),
(100, 'Zaragoza'),
(101, 'Antwerpen'),
(102, 'Arkhangelsk'),
(103, 'Astrakhan'),
(104, 'Bari'),
(105, 'Belgorod'),
(106, 'Bielefeld'),
(107, 'Bilbao'),
(108, 'Bochum'),
(109, 'Bologna'),
(110, 'Bradford'),
(111, 'Brasov'),
(112, 'Bratislava'),
(113, 'Bristol'),
(114, 'Brno'),
(115, 'Bryansk'),
(116, 'Bydgoszcz'),
(117, 'Cardiff'),
(118, 'Catania'),
(119, 'Cheboksary'),
(120, 'Cherepovets'),
(121, 'Cherkassy'),
(122, 'Chernigov'),
(123, 'Chita'),
(124, 'Cluj-Napoca'),
(125, 'Constanta'),
(126, 'Córdoba'),
(127, 'Coventry'),
(128, 'Craiova'),
(129, 'Dresden'),
(130, 'Dublin'),
(131, 'Dudley'),
(132, 'East Riding of Yorkshire'),
(133, 'Edinburgh'),
(134, 'Fife'),
(135, 'Firenze'),
(136, 'Galati'),
(137, 'Gdansk'),
(138, 'Gomel'),
(139, 'Gorlovka'),
(140, 'Göteborg'),
(141, 'Iasi'),
(142, 'Ivanovo'),
(143, 'Kaliningrad'),
(144, 'Kaluga'),
(145, 'Katowice'),
(146, 'Kaunas'),
(147, 'Kherson'),
(148, 'Kirklees'),
(149, 'Kirov'),
(150, 'Kurgan'),
(151, 'Kursk'),
(152, 'Las Palmas'),
(153, 'Leipzig'),
(154, 'Liverpool'),
(155, 'Lublin'),
(156, 'Lugansk'),
(157, 'Lyon'),
(158, 'Magnitogorsk'),
(159, 'Makeyevka'),
(160, 'Makhachkala'),
(161, 'Manchester'),
(162, 'Mannheim'),
(163, 'Mariupol'),
(164, 'Mogilev'),
(165, 'Murcia'),
(166, 'Murmansk'),
(167, 'Nice'),
(168, 'Nizhny Tagil'),
(169, 'North Lanarkshire'),
(170, 'Nürnberg'),
(171, 'Orel'),
(172, 'Ostrava'),
(173, 'Poltava'),
(174, 's-Gravenhage'),
(175, 'Saransk'),
(176, 'Sevastopol'),
(177, 'Simferopol'),
(178, 'Skoplje'),
(179, 'Smolensk'),
(180, 'Sochi'),
(181, 'South Lanarkshire'),
(182, 'Stavropol'),
(183, 'Szczecin'),
(184, 'Tallinn'),
(185, 'Tambov'),
(186, 'Timisoara'),
(187, 'Tomsk'),
(188, 'Toulouse'),
(189, 'Tver'),
(190, 'Ulan-Ude'),
(191, 'Valladolid'),
(192, 'Vinnutsya'),
(193, 'Vitebsk'),
(194, 'Vladikavkaz'),
(195, 'Vladimir'),
(196, 'Wakefield'),
(197, 'Wigan'),
(198, 'Wirral'),
(199, 'Wuppertal'),
(200, 'Zürich'),
(201, 'Aachen'),
(202, 'Aberdeenshire'),
(203, 'Alicante'),
(204, 'Angarsk'),
(205, 'Århus'),
(206, 'Augsburg'),
(207, 'Belfast'),
(208, 'Bergen'),
(209, 'Bialystok'),
(210, 'Bolton'),
(211, 'Bonn'),
(212, 'Braila'),
(213, 'Bratsk'),
(214, 'Braunschweig'),
(215, 'Brest'),
(216, 'Chemnitz'),
(217, 'Chernovtsy'),
(218, 'Czestochowa'),
(219, 'Derby'),
(220, 'Dneprodzerzhinsk'),
(221, 'Doncaster'),
(222, 'Dzerzhinsk'),
(223, 'Gdynia'),
(224, 'Gelsenkirchen'),
(225, 'Gent'),
(226, 'Gijón'),
(227, 'Granada'),
(228, 'Graz'),
(229, 'Grodno'),
(230, 'Halle'),
(231, 'Hospitalet de Llobregat'),
(232, 'Ioshkap-Ola'),
(233, 'Ivano-Frankovsk'),
(234, 'Karlsruhe'),
(235, 'Khmelnitsky'),
(236, 'Kiel'),
(237, 'Kingston-upon-Hull'),
(238, 'Kirovograd'),
(239, 'Komsomolsk-na-Amure'),
(240, 'Kosice'),
(241, 'Kostroma'),
(242, 'Krefeld'),
(243, 'Krementchug'),
(244, 'La Coruña'),
(245, 'Leicester'),
(246, 'Ljubljana'),
(247, 'Magdeburg'),
(248, 'Malmö'),
(249, 'Messina'),
(250, 'Mönchengladbach'),
(251, 'Münster'),
(252, 'Naltchik'),
(253, 'Nantes'),
(254, 'Newcastle-upon-Tyne'),
(255, 'Nis'),
(256, 'Nizhenvartovsk'),
(257, 'Nottingham'),
(258, 'Novi Sad'),
(259, 'Orsk'),
(260, 'Palma de Mallorca'),
(261, 'Petrozavodsk'),
(262, 'Ploiesti'),
(263, 'Plymouth'),
(264, 'Porto'),
(265, 'Prokopyevsk'),
(266, 'Radom'),
(267, 'Rhondda with Cynon & Taff'),
(268, 'Rotherham'),
(269, 'Rovno'),
(270, 'Rybinsk'),
(271, 'Salford'),
(272, 'Sandwell'),
(273, 'Sefton'),
(274, 'Severodvinsk'),
(275, 'Sosnowiec'),
(276, 'South Gloucestershire'),
(277, 'Sterlitamak'),
(278, 'Stockport'),
(279, 'Stoke-on-Trent'),
(280, 'Strasbourg'),
(281, 'Sumy'),
(282, 'Sunderland'),
(283, 'Surgut'),
(284, 'Swansea'),
(285, 'Syktivkar'),
(286, 'Taganrog'),
(287, 'Ternopol'),
(288, 'Tirana'),
(289, 'Utrecht'),
(290, 'Varna'),
(291, 'Velikiy Novgorod'),
(292, 'Venezia'),
(293, 'Verona'),
(294, 'Vigo'),
(295, 'Vologda'),
(296, 'Volzhsky'),
(297, 'Walsall'),
(298, 'Wiesbaden'),
(299, 'Wolverhampton'),
(300, 'Zhitomir'),
(301, 'Aberdeen'),
(302, 'Arad'),
(303, 'Bacau'),
(304, 'Badalona'),
(305, 'Balakovo'),
(306, 'Banja Luka'),
(307, 'Barnsley'),
(308, 'Belaya Tserkov'),
(309, 'Berezniki'),
(310, 'Bielsko-Biala'),
(311, 'Biisk'),
(312, 'Blagoveshchensk'),
(313, 'Bobruisk'),
(314, 'Bordeaux'),
(315, 'Bourgas'),
(316, 'Brescia'),
(317, 'Bury'),
(318, 'Bytom'),
(319, 'Calderdale'),
(320, 'Charleroi'),
(321, 'Debrecen'),
(322, 'Eindhoven'),
(323, 'Elche'),
(324, 'Engels'),
(325, 'Erfurt'),
(326, 'Espoo'),
(327, 'Freiburg im Breisgau'),
(328, 'Gateshead'),
(329, 'Gliwice'),
(330, 'Hagen'),
(331, 'Hamm'),
(332, 'Highland'),
(333, 'Jérez de la Frontera'),
(334, 'Kamensk-Uralsky'),
(335, 'Kassel'),
(336, 'Kielce'),
(337, 'Klaipeda'),
(338, 'Kragujevac'),
(339, 'Kramatorsk'),
(340, 'Le Havre'),
(341, 'Liège'),
(342, 'Linz'),
(343, 'Lübeck'),
(344, 'Luton'),
(345, 'Lutsk'),
(346, 'Mainz'),
(347, 'Milton Keynes'),
(348, 'Montpellier'),
(349, 'Móstoles'),
(350, 'Nizhnekamsk'),
(351, 'North Somerset'),
(352, 'North Tyneside'),
(353, 'Northampton'),
(354, 'Novocherkassk'),
(355, 'Novorossiysk'),
(356, 'Oberhausen'),
(357, 'Odense'),
(358, 'Oldham'),
(359, 'Oradea'),
(360, 'Oviedo'),
(361, 'Padova'),
(362, 'Petropavlovsk-Kamchatsky'),
(363, 'Piraiévs'),
(364, 'Pitesti'),
(365, 'Podolsk'),
(366, 'Portsmouth'),
(367, 'Pskov'),
(368, 'Reggio di Calabria'),
(369, 'Reims'),
(370, 'Rennes'),
(371, 'Rochdale'),
(372, 'Rostock'),
(373, 'Saarbrücken'),
(374, 'Sabadell'),
(375, 'Saint-Étienne'),
(376, 'Santa Cruz de Tenerife'),
(377, 'Santander'),
(378, 'Shakhty'),
(379, 'Solihull'),
(380, 'Southampton'),
(381, 'Split'),
(382, 'St Helens'),
(383, 'Starsy Oskol'),
(384, 'Stockton-on-Tees'),
(385, 'Syzran'),
(386, 'Tameside'),
(387, 'Tampere'),
(388, 'Taranto'),
(389, 'Tilburg'),
(390, 'Torun'),
(391, 'Trafford'),
(392, 'Trieste'),
(393, 'Uppsala'),
(394, 'Vitoria-Gasteiz'),
(395, 'Volgodonsk'),
(396, 'Warrington'),
(397, 'Yakutsk'),
(398, 'Zabrze'),
(399, 'Zelenograd'),
(400, 'Zlatoust'),
(401, 'Abakan'),
(402, 'Ålborg'),
(403, 'Alcalá de Henares'),
(404, 'Almería'),
(405, 'Apeldoorn'),
(406, 'Armavir'),
(407, 'Aylesbury Vale'),
(408, 'Baia Mare'),
(409, 'Bâle'),
(410, 'Baranovichi'),
(411, 'Basildon'),
(412, 'Bath & NE Somerset'),
(413, 'Beltsy'),
(414, 'Blackpool'),
(415, 'Borisov'),
(416, 'Bournemouth'),
(417, 'Breda'),
(418, 'Brighton'),
(419, 'Burgos'),
(420, 'Caerphilly'),
(421, 'Cagliari'),
(422, 'Carmarthenshire'),
(423, 'Cartagena'),
(424, 'Charnwood'),
(425, 'Chelmsford'),
(426, 'Colchester'),
(427, 'Dundee'),
(428, 'Enschede'),
(429, 'Foggia'),
(430, 'Fuenlabrada'),
(431, 'Genève'),
(432, 'Grenoble'),
(433, 'Groningen'),
(434, 'Herne'),
(435, 'Huntingdonshire'),
(436, 'Kertch'),
(437, 'Knowsley'),
(438, 'Kolomna'),
(439, 'Kovrov'),
(440, 'Leganés'),
(441, 'Leskovac'),
(442, 'Leverkusen'),
(443, 'Lille'),
(444, 'Livorno'),
(445, 'Lüdwigshafen'),
(446, 'Lyubertsy'),
(447, 'Macclesfield'),
(448, 'Maikop'),
(449, 'Melitopol'),
(450, 'Miass'),
(451, 'Miskolc'),
(452, 'Modena'),
(453, 'Mülheim/Ruhr'),
(454, 'Mytishchi'),
(455, 'Nakhodka'),
(456, 'NE Lincolnshire'),
(457, 'Neuss'),
(458, 'New Forest'),
(459, 'Nijmegen'),
(460, 'Nikopol'),
(461, 'Norilsk'),
(462, 'North Lincolnshire'),
(463, 'Oldenburg'),
(464, 'Olsztyn'),
(465, 'Osnabrück'),
(466, 'Pamplona'),
(467, 'Parma'),
(468, 'Patrai'),
(469, 'Pécs'),
(470, 'Perugia'),
(471, 'Peterborough'),
(472, 'Plzen'),
(473, 'Podgorica'),
(474, 'Prato'),
(475, 'Renfrewshire'),
(476, 'Rijeka'),
(477, 'Roussé'),
(478, 'Rubtsovsk'),
(479, 'Ruda Slaska'),
(480, 'Rzeszów'),
(481, 'Salamanca'),
(482, 'Salavat'),
(483, 'San Sebastián'),
(484, 'Sibiu'),
(485, 'Solingen'),
(486, 'South Somerset'),
(487, 'South Tyneside'),
(488, 'Southend-on-Sea'),
(489, 'Szeged'),
(490, 'Tarrasa'),
(491, 'Thamesdown'),
(492, 'Tirgu-Mures'),
(493, 'Toulon'),
(494, 'Turku'),
(495, 'Ussuriisk'),
(496, 'Uzno-Sakhalinsk'),
(497, 'Vantaa'),
(498, 'West Lothian'),
(499, 'Wycombe'),
(500, 'York');


--
-- Struktura tabele `collabpref`
--

CREATE TABLE IF NOT EXISTS `collabpref` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;

--
-- Dumping data for table `collabpref`
--

INSERT INTO `collabpref` (`id`, `name`) VALUES
(1, 'Paid work'),
(2, 'Sweat equity'),
(3, 'Equal investors'),
(4, 'Sole investor');


--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=250 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `country_code`) VALUES
(1, 'Afghanistan', 'af'),
(2, 'Aland Islands', 'ax'),
(3, 'Albania', 'al'),
(4, 'Algeria', 'dz'),
(5, 'American Samoa', 'as'),
(6, 'Andorra', 'ad'),
(7, 'Angola', 'ao'),
(8, 'Anguilla', 'ai'),
(9, 'Antarctica', 'aq'),
(10, 'Antigua and Barbuda', 'ag'),
(11, 'Argentina', 'ar'),
(12, 'Armenia', 'am'),
(13, 'Aruba', 'aw'),
(14, 'Australia', 'au'),
(15, 'Austria', 'at'),
(16, 'Azerbaijan', 'az'),
(17, 'Bahamas', 'bs'),
(18, 'Bahrain', 'bh'),
(19, 'Bangladesh', 'bd'),
(20, 'Barbados', 'bb'),
(21, 'Belarus', 'by'),
(22, 'Belgium', 'be'),
(23, 'Belize', 'bz'),
(24, 'Benin', 'bj'),
(25, 'Bermuda', 'bm'),
(26, 'Bhutan', 'bt'),
(27, 'Bolivia, Plurinational State of', 'bo'),
(28, 'Bonaire, Sint Eustatius and Saba', 'bq'),
(29, 'Bosnia and Herzegovina', 'ba'),
(30, 'Botswana', 'bw'),
(31, 'Bouvet Island', 'bv'),
(32, 'Brazil', 'br'),
(33, 'British Indian Ocean Territory', 'io'),
(34, 'Brunei Darussalam', 'bn'),
(35, 'Bulgaria', 'bg'),
(36, 'Burkina Faso', 'bf'),
(37, 'Burundi', 'bi'),
(38, 'Cambodia', 'kh'),
(39, 'Cameroon', 'cm'),
(40, 'Canada', 'ca'),
(41, 'Cape Verde', 'cv'),
(42, 'Cayman Islands', 'ky'),
(43, 'Central African Republic', 'cf'),
(44, 'Chad', 'td'),
(45, 'Chile', 'cl'),
(46, 'China', 'cn'),
(47, 'Christmas Island', 'cx'),
(48, 'Cocos (Keeling) Islands', 'cc'),
(49, 'Colombia', 'co'),
(50, 'Comoros', 'km'),
(51, 'Congo', 'cg'),
(52, 'Congo, The Democratic Republic o', 'cd'),
(53, 'Cook Islands', 'ck'),
(54, 'Costa Rica', 'cr'),
(55, 'Cote d''Ivoire', 'ci'),
(56, 'Croatia', 'hr'),
(57, 'Cuba', 'cu'),
(58, 'Curacao', 'cw'),
(59, 'Cyprus', 'cy'),
(60, 'Czech Republic', 'cz'),
(61, 'Denmark', 'dk'),
(62, 'Djibouti', 'dj'),
(63, 'Dominica', 'dm'),
(64, 'Dominican Republic', 'do'),
(65, 'Ecuador', 'ec'),
(66, 'Egypt', 'eg'),
(67, 'El Salvador', 'sv'),
(68, 'Equatorial Guinea', 'gq'),
(69, 'Eritrea', 'er'),
(70, 'Estonia', 'ee'),
(71, 'Ethiopia', 'et'),
(72, 'Falkland Islands (Malvinas)', 'fk'),
(73, 'Faroe Islands', 'fo'),
(74, 'Fiji', 'fj'),
(75, 'Finland', 'fi'),
(76, 'France', 'fr'),
(77, 'French Guiana', 'gf'),
(78, 'French Polynesia', 'pf'),
(79, 'French Southern Territories', 'tf'),
(80, 'Gabon', 'ga'),
(81, 'Gambia', 'gm'),
(82, 'Georgia', 'ge'),
(83, 'Germany', 'de'),
(84, 'Ghana', 'gh'),
(85, 'Gibraltar', 'gi'),
(86, 'Greece', 'gr'),
(87, 'Greenland', 'gl'),
(88, 'Grenada', 'gd'),
(89, 'Guadeloupe', 'gp'),
(90, 'Guam', 'gu'),
(91, 'Guatemala', 'gt'),
(92, 'Guernsey', 'gg'),
(93, 'Guinea', 'gn'),
(94, 'Guinea-Bissau', 'gw'),
(95, 'Guyana', 'gy'),
(96, 'Haiti', 'ht'),
(97, 'Heard Island and McDonald Island', 'hm'),
(98, 'Holy See (Vatican City State)', 'va'),
(99, 'Honduras', 'hn'),
(100, 'Hong Kong', 'hk'),
(101, 'Hungary', 'hu'),
(102, 'Iceland', 'is'),
(103, 'India', 'in'),
(104, 'Indonesia', 'id'),
(105, 'Iran, Islamic Republic of', 'ir'),
(106, 'Iraq', 'iq'),
(107, 'Ireland', 'ie'),
(108, 'Isle of Man', 'im'),
(109, 'Israel', 'il'),
(110, 'Italy', 'it'),
(111, 'Jamaica', 'jm'),
(112, 'Japan', 'jp'),
(113, 'Jersey', 'je'),
(114, 'Jordan', 'jo'),
(115, 'Kazakhstan', 'kz'),
(116, 'Kenya', 'ke'),
(117, 'Kiribati', 'ki'),
(118, 'Korea, Democratic People''s Repub', 'kp'),
(119, 'Korea, Republic of', 'kr'),
(120, 'Kuwait', 'kw'),
(121, 'Kyrgyzstan', 'kg'),
(122, 'Lao People''s Democratic Republic', 'la'),
(123, 'Latvia', 'lv'),
(124, 'Lebanon', 'lb'),
(125, 'Lesotho', 'ls'),
(126, 'Liberia', 'lr'),
(127, 'Libyan Arab Jamahiriya', 'ly'),
(128, 'Liechtenstein', 'li'),
(129, 'Lithuania', 'lt'),
(130, 'Luxembourg', 'lu'),
(131, 'Macao', 'mo'),
(132, 'Macedonia, The former Yugoslav R', 'mk'),
(133, 'Madagascar', 'mg'),
(134, 'Malawi', 'mw'),
(135, 'Malaysia', 'my'),
(136, 'Maldives', 'mv'),
(137, 'Mali', 'ml'),
(138, 'Malta', 'mt'),
(139, 'Marshall Islands', 'mh'),
(140, 'Martinique', 'mq'),
(141, 'Mauritania', 'mr'),
(142, 'Mauritius', 'mu'),
(143, 'Mayotte', 'yt'),
(144, 'Mexico', 'mx'),
(145, 'Micronesia, Federated States of', 'fm'),
(146, 'Moldova, Republic of', 'md'),
(147, 'Monaco', 'mc'),
(148, 'Mongolia', 'mn'),
(149, 'Montenegro', 'me'),
(150, 'Montserrat', 'ms'),
(151, 'Morocco', 'ma'),
(152, 'Mozambique', 'mz'),
(153, 'Myanmar', 'mm'),
(154, 'Namibia', 'na'),
(155, 'Nauru', 'nr'),
(156, 'Nepal', 'np'),
(157, 'Netherlands', 'nl'),
(158, 'New Caledonia', 'nc'),
(159, 'New Zealand', 'nz'),
(160, 'Nicaragua', 'ni'),
(161, 'Niger', 'ne'),
(162, 'Nigeria', 'ng'),
(163, 'Niue', 'nu'),
(164, 'Norfolk Island', 'nf'),
(165, 'Northern Mariana Islands', 'mp'),
(166, 'Norway', 'no'),
(167, 'Oman', 'om'),
(168, 'Pakistan', 'pk'),
(169, 'Palau', 'pw'),
(170, 'Palestinian Territory, Occupied', 'ps'),
(171, 'Panama', 'pa'),
(172, 'Papua New Guinea', 'pg'),
(173, 'Paraguay', 'py'),
(174, 'Peru', 'pe'),
(175, 'Philippines', 'ph'),
(176, 'Pitcairn', 'pn'),
(177, 'Poland', 'pl'),
(178, 'Portugal', 'pt'),
(179, 'Puerto Rico', 'pr'),
(180, 'Qatar', 'qa'),
(181, 'Reunion', 're'),
(182, 'Romania', 'ro'),
(183, 'Russian Federation', 'ru'),
(184, 'Rwanda', 'rw'),
(185, 'Saint Barthelemy', 'bl'),
(186, 'Saint Helena, Ascension and Tris', 'sh'),
(187, 'Saint Kitts and Nevis', 'kn'),
(188, 'Saint Lucia', 'lc'),
(189, 'Saint Martin (French Part)', 'mf'),
(190, 'Saint Pierre and Miquelon', 'pm'),
(191, 'Saint Vincent and The Grenadines', 'vc'),
(192, 'Samoa', 'ws'),
(193, 'San Marino', 'sm'),
(194, 'Sao Tome and Principe', 'st'),
(195, 'Saudi Arabia', 'sa'),
(196, 'Senegal', 'sn'),
(197, 'Serbia', 'rs'),
(198, 'Seychelles', 'sc'),
(199, 'Sierra Leone', 'sl'),
(200, 'Singapore', 'sg'),
(201, 'Sint Maarten (Dutch Part)', 'sx'),
(202, 'Slovakia', 'sk'),
(203, 'Slovenia', 'si'),
(204, 'Solomon Islands', 'sb'),
(205, 'Somalia', 'so'),
(206, 'South Africa', 'za'),
(207, 'South Georgia and The South Sand', 'gs'),
(208, 'South Sudan', 'ss'),
(209, 'Spain', 'es'),
(210, 'Sri Lanka', 'lk'),
(211, 'Sudan', 'sd'),
(212, 'Suriname', 'sr'),
(213, 'Svalbard and Jan Mayen', 'sj'),
(214, 'Swaziland', 'sz'),
(215, 'Sweden', 'se'),
(216, 'Switzerland', 'ch'),
(217, 'Syrian Arab Republic', 'sy'),
(218, 'Taiwan, Province of China', 'tw'),
(219, 'Tajikistan', 'tj'),
(220, 'Tanzania, United Republic of', 'tz'),
(221, 'Thailand', 'th'),
(222, 'Timor-Leste', 'tl'),
(223, 'Togo', 'tg'),
(224, 'Tokelau', 'tk'),
(225, 'Tonga', 'to'),
(226, 'Trinidad and Tobago', 'tt'),
(227, 'Tunisia', 'tn'),
(228, 'Turkey', 'tr'),
(229, 'Turkmenistan', 'tm'),
(230, 'Turks and Caicos Islands', 'tc'),
(231, 'Tuvalu', 'tv'),
(232, 'Uganda', 'ug'),
(233, 'Ukraine', 'ua'),
(234, 'United Arab Emirates', 'ae'),
(235, 'United Kingdom', 'gb'),
(236, 'United States', 'us'),
(237, 'United States Minor Outlying Isl', 'um'),
(238, 'Uruguay', 'uy'),
(239, 'Uzbekistan', 'uz'),
(240, 'Vanuatu', 'vu'),
(241, 'Venezuela, Bolivarian Republic o', 've'),
(242, 'Viet Nam', 'vn'),
(243, 'Virgin Islands, British', 'vg'),
(244, 'Virgin Islands, U.S.', 'vi'),
(245, 'Wallis and Futuna', 'wf'),
(246, 'Western Sahara', 'eh'),
(247, 'Yemen', 'ye'),
(248, 'Zambia', 'zm'),
(249, 'Zimbabwe', 'zw');


--
-- Struktura tabele `idea_status`
--

CREATE TABLE IF NOT EXISTS `idea_status` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;

--
-- Dumping data for table `idea_status`
--

INSERT INTO `idea_status` (`id`, `name`) VALUES
(1, 'Idea'),
(2, 'Business plan'),
(3, 'Prototype'),
(4, 'Paying customers'),
(5, 'Growth');


--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `language_code` varchar(2) NOT NULL,
  `name` varchar(32) NOT NULL,
  `native_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=183 ;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `language_code`, `name`, `native_name`) VALUES
(1, 'ab', 'Abkhaz', 'аҧсуа'),
(2, 'aa', 'Afar', 'Afaraf'),
(3, 'af', 'Afrikaans', 'Afrikaans'),
(4, 'ak', 'Akan', 'Akan'),
(5, 'sq', 'Albanian', 'Shqip'),
(6, 'am', 'Amharic', 'አማርኛ'),
(7, 'ar', 'Arabic', 'العربية'),
(8, 'an', 'Aragonese', 'Aragonés'),
(9, 'hy', 'Armenian', 'Հայերեն'),
(10, 'as', 'Assamese', 'অসমীয়া'),
(11, 'av', 'Avaric', 'авар мацӀ, магӀарул мацӀ'),
(12, 'ae', 'Avestan', 'avesta'),
(13, 'ay', 'Aymara', 'aymar aru'),
(14, 'az', 'Azerbaijani', 'azərbaycan dili'),
(15, 'bm', 'Bambara', 'bamanankan'),
(16, 'ba', 'Bashkir', 'башҡорт теле'),
(17, 'eu', 'Basque', 'euskara, euskera'),
(18, 'be', 'Belarusian', 'Беларуская'),
(19, 'bn', 'Bengali', 'বাংলা'),
(20, 'bh', 'Bihari', 'भोजपुरी'),
(21, 'bi', 'Bislama', 'Bislama'),
(22, 'bs', 'Bosnian', 'bosanski jezik'),
(23, 'br', 'Breton', 'brezhoneg'),
(24, 'bg', 'Bulgarian', 'български език'),
(25, 'my', 'Burmese', 'ဗမာစာ'),
(26, 'ca', 'Catalan', 'Català'),
(27, 'ch', 'Chamorro', 'Chamoru'),
(28, 'ce', 'Chechen', 'нохчийн мотт'),
(29, 'ny', 'Chichewa', 'chiCheŵa, chinyanja'),
(30, 'zh', 'Chinese', '中文 (Zhōngwén), 汉语, 漢語'),
(31, 'cv', 'Chuvash', 'чӑваш чӗлхи'),
(32, 'kw', 'Cornish', 'Kernewek'),
(33, 'co', 'Corsican', 'corsu, lingua corsa'),
(34, 'cr', 'Cree', 'ᓀᐦᐃᔭᐍᐏᐣ'),
(35, 'hr', 'Croatian', 'hrvatski'),
(36, 'cs', 'Czech', 'česky, čeština'),
(37, 'da', 'Danish', 'dansk'),
(38, 'dv', 'Divehi', 'ދިވެހި'),
(39, 'nl', 'Dutch', 'Nederlands, Vlaams'),
(40, 'en', 'English', 'English'),
(41, 'eo', 'Esperanto', 'Esperanto'),
(42, 'et', 'Estonian', 'eesti, eesti keel'),
(43, 'ee', 'Ewe', 'Eʋegbe'),
(44, 'fo', 'Faroese', 'føroyskt'),
(45, 'fj', 'Fijian', 'vosa Vakaviti'),
(46, 'fi', 'Finnish', 'suomi, suomen kieli'),
(47, 'fr', 'French', 'français, langue française'),
(48, 'ff', 'Fula', 'Fulfulde, Pulaar, Pular'),
(49, 'gl', 'Galician', 'Galego'),
(50, 'ka', 'Georgian', 'ქართული'),
(51, 'de', 'German', 'Deutsch'),
(52, 'el', 'Greek', 'Ελληνικά'),
(53, 'gn', 'Guaraní', 'Avañeẽ'),
(54, 'gu', 'Gujarati', 'ગુજરાતી'),
(55, 'ht', 'Haitian', 'Kreyòl ayisyen'),
(56, 'ha', 'Hausa', 'Hausa, هَوُسَ'),
(57, 'he', 'Hebrew (modern)', 'עברית'),
(58, 'hz', 'Herero', 'Otjiherero'),
(59, 'hi', 'Hindi', 'हिन्दी, हिंदी'),
(60, 'ho', 'Hiri Motu', 'Hiri Motu'),
(61, 'hu', 'Hungarian', 'Magyar'),
(62, 'ia', 'Interlingua', 'Interlingua'),
(63, 'id', 'Indonesian', 'Bahasa Indonesia'),
(64, 'ie', 'Interlingue', 'Interlingue'),
(65, 'ga', 'Irish', 'Gaeilge'),
(66, 'ig', 'Igbo', 'Asụsụ Igbo'),
(67, 'ik', 'Inupiaq', 'Iñupiaq, Iñupiatun'),
(68, 'io', 'Ido', 'Ido'),
(69, 'is', 'Icelandic', 'Íslenska'),
(70, 'it', 'Italian', 'Italiano'),
(71, 'iu', 'Inuktitut', 'ᐃᓄᒃᑎᑐᑦ'),
(72, 'ja', 'Japanese', '日本語 (にほんご／にっぽんご)'),
(73, 'jv', 'Javanese', 'basa Jawa'),
(74, 'kl', 'Kalaallisut', 'kalaallisut, kalaallit oqaasii'),
(75, 'kn', 'Kannada', 'ಕನ್ನಡ'),
(76, 'kr', 'Kanuri', 'Kanuri'),
(77, 'ks', 'Kashmiri', 'कश्मीरी, كشميري‎'),
(78, 'kk', 'Kazakh', 'Қазақ тілі'),
(79, 'km', 'Khmer', 'ភាសាខ្មែរ'),
(80, 'ki', 'Kikuyu', 'Gĩkũyũ'),
(81, 'rw', 'Kinyarwanda', 'Ikinyarwanda'),
(82, 'ky', 'Kirghiz', 'кыргыз тили'),
(83, 'kv', 'Komi', 'коми кыв'),
(84, 'kg', 'Kongo', 'KiKongo'),
(85, 'ko', 'Korean', '한국어 (韓國語), 조선말 (朝鮮語)'),
(86, 'ku', 'Kurdish', 'Kurdî, كوردی‎'),
(87, 'kj', 'Kwanyama', 'Kuanyama'),
(88, 'la', 'Latin', 'latine, lingua latina'),
(89, 'lb', 'Luxembourgish', 'Lëtzebuergesch'),
(90, 'lg', 'Luganda', 'Luganda'),
(91, 'li', 'Limburgish', 'Limburgs'),
(92, 'ln', 'Lingala', 'Lingála'),
(93, 'lo', 'Lao', 'ພາສາລາວ'),
(94, 'lt', 'Lithuanian', 'lietuvių kalba'),
(95, 'lu', 'Luba-Katanga', 'Luba-Katanga'),
(96, 'lv', 'Latvian', 'latviešu valoda'),
(97, 'gv', 'Manx', 'Gaelg, Gailck'),
(98, 'mk', 'Macedonian', 'македонски јазик'),
(99, 'mg', 'Malagasy', 'Malagasy fiteny'),
(100, 'ms', 'Malay', 'bahasa Melayu, بهاس ملايو‎'),
(101, 'ml', 'Malayalam', 'മലയാളം'),
(102, 'mt', 'Maltese', 'Malti'),
(103, 'mi', 'Māori', 'te reo Māori'),
(104, 'mr', 'Marathi (Marāṭhī)', 'मराठी'),
(105, 'mh', 'Marshallese', 'Kajin M̧ajeļ'),
(106, 'mn', 'Mongolian', 'монгол'),
(107, 'na', 'Nauru', 'Ekakairũ Naoero'),
(108, 'nv', 'Navajo', 'Diné bizaad, Dinékʼehǰí'),
(109, 'nb', 'Norwegian Bokmål', 'Norsk bokmål'),
(110, 'nd', 'North Ndebele', 'isiNdebele'),
(111, 'ne', 'Nepali', 'नेपाली'),
(112, 'ng', 'Ndonga', 'Owambo'),
(113, 'nn', 'Norwegian Nynorsk', 'Norsk nynorsk'),
(114, 'no', 'Norwegian', 'Norsk'),
(115, 'ii', 'Nuosu', 'ꆈꌠ꒿ Nuosuhxop'),
(116, 'nr', 'South Ndebele', 'isiNdebele'),
(117, 'oc', 'Occitan', 'Occitan'),
(118, 'oj', 'Ojibwe', 'ᐊᓂᔑᓈᐯᒧᐎᓐ'),
(119, 'cu', 'Old Church Slavonic', 'ѩзыкъ словѣньскъ'),
(120, 'om', 'Oromo', 'Afaan Oromoo'),
(121, 'or', 'Oriya', 'ଓଡ଼ିଆ'),
(122, 'os', 'Ossetian', 'ирон æвзаг'),
(123, 'pa', 'Panjabi', 'ਪੰਜਾਬੀ, پنجابی‎'),
(124, 'pi', 'Pāli', 'पाऴि'),
(125, 'fa', 'Persian', 'فارسی'),
(126, 'pl', 'Polish', 'polski'),
(127, 'ps', 'Pashto', 'پښتو'),
(128, 'pt', 'Portuguese', 'Português'),
(129, 'qu', 'Quechua', 'Runa Simi, Kichwa'),
(130, 'rm', 'Romansh', 'rumantsch grischun'),
(131, 'rn', 'Kirundi', 'kiRundi'),
(132, 'ro', 'Romanian', 'română'),
(133, 'ru', 'Russian', 'русский язык'),
(134, 'sa', 'Sanskrit (Saṁskṛta)', 'संस्कृतम्'),
(135, 'sc', 'Sardinian', 'sardu'),
(136, 'sd', 'Sindhi', 'सिन्धी, سنڌي، سندھی‎'),
(137, 'se', 'Northern Sami', 'Davvisámegiella'),
(138, 'sm', 'Samoan', 'gagana faa Samoa'),
(139, 'sg', 'Sango', 'yângâ tî sängö'),
(140, 'sr', 'Serbian', 'српски језик'),
(141, 'gd', 'Scottish Gaelic', 'Gàidhlig'),
(142, 'sn', 'Shona', 'chiShona'),
(143, 'si', 'Sinhala', 'සිංහල'),
(144, 'sk', 'Slovak', 'slovenčina'),
(145, 'sl', 'Slovene', 'slovenščina'),
(146, 'so', 'Somali', 'Soomaaliga, af Soomaali'),
(147, 'st', 'Southern Sotho', 'Sesotho'),
(148, 'es', 'Spanish', 'español, castellano'),
(149, 'su', 'Sundanese', 'Basa Sunda'),
(150, 'sw', 'Swahili', 'Kiswahili'),
(151, 'ss', 'Swati', 'SiSwati'),
(152, 'sv', 'Swedish', 'svenska'),
(153, 'ta', 'Tamil', 'தமிழ்'),
(154, 'te', 'Telugu', 'తెలుగు'),
(155, 'tg', 'Tajik', 'тоҷикӣ, toğikī, تاجیکی‎'),
(156, 'th', 'Thai', 'ไทย'),
(157, 'ti', 'Tigrinya', 'ትግርኛ'),
(158, 'bo', 'Tibetan Standard', 'བོད་ཡིག'),
(159, 'tk', 'Turkmen', 'Türkmen, Түркмен'),
(160, 'tl', 'Tagalog', 'Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔'),
(161, 'tn', 'Tswana', 'Setswana'),
(162, 'to', 'Tonga (Tonga Islands)', 'faka Tonga'),
(163, 'tr', 'Turkish', 'Türkçe'),
(164, 'ts', 'Tsonga', 'Xitsonga'),
(165, 'tt', 'Tatar', 'татарча, tatarça, تاتارچا‎'),
(166, 'tw', 'Twi', 'Twi'),
(167, 'ty', 'Tahitian', 'Reo Tahiti'),
(168, 'ug', 'Uighur', 'Uyƣurqə, ئۇيغۇرچە‎'),
(169, 'uk', 'Ukrainian', 'українська'),
(170, 'ur', 'Urdu', 'اردو'),
(171, 'uz', 'Uzbek', 'zbek, Ўзбек, أۇزبېك‎'),
(172, 've', 'Venda', 'Tshivenḓa'),
(173, 'vi', 'Vietnamese', 'Tiếng Việt'),
(174, 'vo', 'Volapük', 'Volapük'),
(175, 'wa', 'Walloon', 'Walon'),
(176, 'cy', 'Welsh', 'Cymraeg'),
(177, 'wo', 'Wolof', 'Wollof'),
(178, 'fy', 'Western Frisian', 'Frysk'),
(179, 'xh', 'Xhosa', 'isiXhosa'),
(180, 'yi', 'Yiddish', 'ייִדיש'),
(181, 'yo', 'Yoruba', 'Yorùbá'),
(182, 'za', 'Zhuang', 'Saɯ cueŋƅ, Saw cuengh');


--
-- Struktura tabele `membertype`
--

CREATE TABLE IF NOT EXISTS `membertype` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `membertype`
--

INSERT INTO `membertype` (`id`, `name`) VALUES
(1, 'Owner'),
(2, 'Member'),
(3, 'Candidate');


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
