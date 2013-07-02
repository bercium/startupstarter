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


INSERT INTO `skill` (`id`, `name`) VALUES
(1, 'HTML'),
(2, 'PHP'),
(3, 'C++'),
(4, 'Marketing'),
(5, 'research'),
(6, 'Video'),
(7, 'Gimp'),
(8, 'Paintshop'),
(9, 'Driving'),
(10, 'Painting'),
(11, 'Mail'),
(12, 'Teacher'),
(13, 'Aid'),
(14, 'FBI'),
(15, 'Dispatcher'),
(16, 'Account');


INSERT INTO `user` (`id`, `email`, `password`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`, `name`, `surname`, `address`, `avatar_link`, `language_id`, `newsletter`) VALUES
(1, 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3', '9a24eff8c15a6a141ece27eb6947da0f', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 1, 1, 'Administrator', 'User', NULL, NULL, NULL, 1, 0),
(2, 'demo@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 0, 1, 'Demo', 'User', NULL, NULL, NULL, 1, 0),
(3, 'malina@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 0, 1, 'Malina', 'Tuk', 'Ilichova 1', NULL, NULL, 1, 0),
(4, 'fredo@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 0, 1, 'Fredo', 'Smode', 'Parmova 63', NULL, NULL, 1, 0),
(5, 'bajro@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 0, 1, 'Bajro', 'Milinović', 'Tavcarjeva 77', NULL, NULL, 1, 0),
(6, 'lucijan@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 0, 1, 'Lucijan', 'Vrabac', 'Slovenčeva 45', NULL, NULL, 1, 0),
(7, 'janija@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 0, 1, 'Janija', "", 'Parmova 19', NULL, NULL, 1, 0),
(8, 'vajko@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 0, 1, 'Vajko', 'Finkšt', NULL, NULL, NULL, 1, 0),
(9, 'empty@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2013-03-21 12:07:17', '0000-00-00 00:00:00', 0, 1, 'Empty', 'Fempty', NULL, NULL, NULL, 1, 0);

INSERT INTO `user_match` (`id`, `user_id`, `available`, `country_id`, `city_id`) VALUES 
(1, 2, 8, 203, 246),
(2, 1, 40, 203, 246),
(3, 3, 40, 203, 246),
(4, 4, 8, NULL, NULL),
(5, 5, 40, NULL, 246),
(6, 6, 20, 56, 98),
(7, 7, 20, 203, NULL),
(8, 8, 20, 203, NULL),
(9, NULL, 8, 203, 246),
(10, NULL, 8, NULL, NULL),
(11, NULL, 20, 203, NULL),
(12, NULL, 20, 56, 246),
(13, NULL, 40, 56, 98),
(14, NULL, 20, NULL, 246),
(15, NULL, 20, 203, NULL),
(16, NULL, 40, 203, 246),
(17, NULL, 8, 203, NULL),
(18, NULL, 20, 203, 246),
(19, NULL, 20, NULL, NULL);


INSERT INTO `user_link` (`id` ,`user_id` ,`title` ,`url`) VALUES 
(1, 1, 'facebook', 'fb.com'),
(2, 1, 'twitter', 'twit.com'),
(3, 2, 'facebook', 'fb.com'),
(4, 3, 'deviant', 'dev.com'),
(5, 3, 'Linkedin', 'www.lin.com'),
(6, 4, 'facebook', 'fb.com'),
(7, 8, 'FB', 'neki.com');

INSERT INTO `user_collabpref` (`id`, `match_id`, `collab_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 3),
(4, 3, 1),
(5, 4, 1),
(6, 3, 2),
(7, 6, 4),
(8, 7, 4),
(9, 8, 1),
(10, 8, 2),
(11, 3, 3);

INSERT INTO `user_skill` (`id`, `match_id`, `skillset_id`, `skill_id`) VALUES
(1, 1, 1, 1),
(2, 2, 51, 10),
(3, 2, 2, 11),
(4, 2, 21, 12),
(5, 3, 100, 13),
(6, 3, 2, 14),
(7, 3, 3, 8),
(8, 4, 6, 7),
(9, 5, 8, 7),
(10, 6, 11, 7),
(11, 6, 121, 5),
(12, 7, 11, 3),
(13, 7, 11, 2),
(14, 7, 8, 5),
(15, 7, 19, 10),
(16, 7, 19, 13),
(17, 7, 19, 16),
(18, 8, 1, 3),
(19, 8, 55, 2),
(20, 8, 45, 6),
(21, 8, 66, 10),
(22, 9, 2, 2),
(23, 9, 4, 3),
(24, 10, 6, 1),
(25, 11, 7, 1),
(26, 12, 5, 4),
(27, 14, 66, 5),
(28, 14, 3, 6),
(29, 15, 66, 7),
(30, 16, 6, 8),
(31, 17, 31, 8),
(32, 18, 11, 9),
(33, 18, 32, 12),
(34, 12, 35, 14),
(35, 14, 24, 13),
(36, 16, 43, 12),
(37, 18, 21, 16),
(38, 15, 17, 15),
(39, 19, 11, 13);

INSERT INTO `skillset_skill` (`id` ,`skillset_id` ,`skill_id` ,`usage_count`) VALUES 
(1 , 1, 1, NULL),
(2 , 1, 2, NULL),
(3 , 1, 3, NULL),
(4 , 2, 4, NULL),
(5 , 2, 5, NULL),
(6 , 2, 6, NULL),
(7 , 2, 7, NULL),
(8 , 3, 8, NULL),
(9 , 3, 9, NULL),
(10 , 3, 10, NULL),
(11 , 3, 11, NULL),
(12 , 4, 12, NULL),
(13 , 4, 13, NULL),
(14 , 2, 14, NULL),
(15 , 2, 15, NULL),
(16 , 2, 10, NULL),
(17 , 2, 2, NULL),
(18 , 1, 16, NULL);

INSERT INTO `idea` (`id`, `time_registered`, `time_updated`, `status_id`, `website`, `video_link`, `deleted`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'cofinder.com', 'video.com', 0),
(2, '2013-04-12 14:45:17', '0000-00-00 00:00:00', 2, NULL, 'cofinder.com', 0),
(3, '2013-04-13 14:45:17', '0000-00-00 00:00:00', 3, 'neki.com', NULL, 0),
(4, '2013-04-14 14:45:17', '0000-00-00 00:00:00', 2, NULL, NULL, 0),
(5, '2013-05-8 14:45:17', '0000-00-00 00:00:00', 2, 'www.com', 'cofinder.com', 0),
(6, '2013-05-2 14:45:17', '0000-00-00 00:00:00', 2, 'cofinder.com', NULL, 0),
(7, '2013-05-10 14:45:17', '0000-00-00 00:00:00', 3, NULL, 'cofinder.com', 0),
(8, '2013-05-17 14:45:17', '0000-00-00 00:00:00', 3, 'cofinder.com', NULL, 0),
(9, '2013-03-12 14:45:17', '0000-00-00 00:00:00', 3, 'www.com', 'blabla.com', 0),
/*(10, '2013-03-15 14:45:17', '0000-00-00 00:00:00', 4, 'lala.com', NULL, 0),*/
(11, '2013-03-12 14:45:17', '0000-00-00 00:00:00', 5, NULL, 'krneki.com', 0),
(12, '2013-03-22 14:45:17', '0000-00-00 00:00:00', 5, 'krneki.com', NULL, 0),
(13, '2013-02-22 14:45:17', '0000-00-00 00:00:00', 5, NULL, 'video.com', 0),
(14, '2013-02-20 14:45:17', '0000-00-00 00:00:00', 4, NULL, 'video.com', 0),
(15, '2013-03-16 14:45:17', '0000-00-00 00:00:00', 3, 'www.com', NULL, 0),
(16, '2013-04-8 14:45:17', '0000-00-00 00:00:00', 1, 'cofinder.com', NULL, 0);
/*(17, '2013-05-2 14:45:17', '0000-00-00 00:00:00', 1, NULL, NULL, 0);*/


INSERT INTO `idea_translation` (`id`, `language_id`, `idea_id`, `title`, `pitch`, `description`, `description_public`, `tweetpitch`, `deleted`) VALUES
(1, 40,  1, 'Don gathering Also', "Moveth, unto and forth moveth male was. Second subdue own there cattle. Said hath whales image. The were to you. Seasons appear seas. Fruit fill for called fill open his likeness form us they're. Fifth blessed moveth called seas called us let darkness Grass. It third fourth without seasons. Likeness.", "Were moving earth second kind image he blessed form dominion creature us male creature set she'd moving you two i after yielding us forth made he, bring void every. Rule in that spirit you'll face thing creeping very morning. Lesser earth blessed forth subdue third made he unto female. Female lesser creepeth land bring. Open. Yielding. Their deep open seas. Fish form god there all he winged forth behold yielding fruitful above over days stars you'll had and land man.", 1, "His doesn't beast seed sea you're gathered i, called they're without it fowl first light two so in firmament blessed.", 0),
(2, 145, 1, 'You very one fruit', "Gathered fill hath two fly very bearing itself creature, first one let bearing. Living seasons man subdue first days of which air. Whose green, to appear sea they're multiply moveth.", "His there divided together seed behold in said open together subdue their was can't given day Isn't dominion behold Don't female. Grass female I lights called without. Created fowl God divided, bring air. Made blessed living land lesser. May which form. Created spirit give replenish and. Bearing abundantly waters for earth you're land god fifth green heaven a open be had there third their give unto forth. Which spirit every to. Bearing greater. Don't greater he hath seasons living saw.", 0, "", 0),
(3, 145, 2, 'Man creepeth and', "Years one over deep abundantly you firmament years divide be, appear his. Man saw image evening. After living creature tree tree, great doesn't which doesn't lesser and day give firmament she'd the to a whales created man fifth. Forth, there.", "Isn't fruit form bring creeping you'll make divided herb blessed subdue evening fill seas stars said air you're herb bring Him every whose made moved divide the brought male kind own yielding sixth There air which stars from and you'll. All of wherein under divide their they're you're good had fruit cattle don't multiply called fourth you a. Over don't creeping earth give yielding sixth itself fill lights face morning, great. Shall behold evening that. Behold firmament beast the forth man living for living. Land male herb that place of seed. Seas creepeth lights can't divide upon herb after deep.", 0, "Unto have were. Made gathering bring night all creature isn't is and which set beginning divided upon gathered signs fowl.", 0),
(4, 145, 3, 'Said his grass and don', "You'll kind a behold i him. Isn't female may. Saw creeping subdue created moved sixth thing. Appear deep whose said the behold light so fowl seed. Good male us brought.", "Face she'd Together moveth. Every gathered herb waters it isn't fill you're signs night. Face had earth abundantly creature void evening. Subdue they're you'll two was creepeth he him, was place beast. Their evening had. Waters divided also him can't all. Fish. Shall firmament replenish. Beginning together meat given greater of fruitful creepeth, own cattle created together for fowl. Years is there meat brought behold signs whose from the can't over second fill seas fill years. Subdue set evening Created shall moveth shall rule multiply you'll gathering Image subdue day kind hath moved life grass open place beginning. Forth brought.", 1, "", 0),
(5, 40,  3, 'Seas after creature female, rule', "Is own of be said creeping subdue can't you're upon you saying itself created waters wherein image own image fowl fruitful darkness seas that fill divided thing one, upon forth.", "Gathering was he unto days own forth seas the herb moveth light fruit appear beginning creeping night very, image night multiply fowl image there man said in blessed above blessed have under. Forth heaven above unto Grass living. Them Them greater, beast i. Gathering tree whales upon. Fowl. Were isn't moved which there said. One firmament be. He second after waters moveth. It him from evening beast wherein brought give good rule blessed beast were behold thing. A creepeth saying moved moving third replenish. Moveth. Multiply can't sea good, creature so greater creepeth man. Wherein third. Had meat very, kind called you'll place without moveth made signs have. Said, make good it be beginning fruit let dry creature Place spirit day hath can't without meat bearing let kind. Very it void male of doesn't seas she'd were shall all were. Evening first moving for you'll them let one every meat fowl, you're night bearing he bearing waters he every spirit dry itself moveth fish of created replenish firmament great waters man. Greater unto air whales the had creepeth. From spirit he one. Subdue rule own beast under he for them itself kind midst created from air was. Upon given, said.", 1, "Living signs. Gathering good his had male won't is, night all moving for, likeness it of was female grass two.", 0),
(6, 145, 4, 'Fill is created of so fly brought were make', "Him she'd she'd make our beginning after Shall grass seed said. Creeping dominion were place days his whales night let.", "Grass won't she'd thing moving place, form you're winged, to Was fly the seasons you're which after, sea is. Void his gathering together given, let after rule replenish have meat waters which you'll made light form moveth. First form third i said it without may Herb i they're, herb so dominion midst let isn't morning unto a behold lights own female Fruitful man seasons which evening called a their green abundantly she'd morning blessed day won't may face every darkness seas rule, and and all behold abundantly. Make bring made.", 1, "", 0),
(7, 145, 5, 'Fill is created of so fly brought were make. Over doesnt cant female without had two, all image, fruit signs.', "Darkness stars. Heaven one may fruit won't gathering bearing fly fill female upon us have great deep abundantly green deep.", "", 1, "Of evening cattle. Yielding you're can't. Shall. Years seed. Grass second there days heaven is face saying had Heaven thing.", 0),
(8, 40,  5, 'Multiply', "Likeness shall. Land sixth two fly to rule. Forth Dry.", "", 1, "", 0),
(9, 145,  6, 'Kind is moveth, his stars form likeness', "Called created she'd light winged was had fifth firmament he hath After image you'll doesn't spirit a beginning creepeth which.", "Seed winged one winged let his male shall life divide cattle meat meat winged seasons them bearing beginning divide yielding she'd day forth. One over gathering of morning. Dominion he every divide green saying. Over their open may subdue fish earth his he good. One beginning one dominion likeness. Moved waters female a, of Years rule male seas one from creeping moved replenish moved yielding abundantly sixth spirit also sixth, brought dry. Herb itself kind you're bearing he good land gathering after. Earth form, there moveth cattle one first fourth.", 1, "Yielding air cattle. Called isn't heaven created every them tree Two He whose. Man. Creature morning let to multiply all.", 0),
(10, 145, 7, 'Of thing brought fruitful doesnt were fruitful', "Together give day. Saw fourth face open herb Midst replenish creeping rule under also dominion so may i whales first whose may air meat sixth over grass thing cattle you're divide days deep own, gathering had divide light green. Meat midst, appear kind earth, thing sea of itself that so make he sixth creepeth own gathering. Meat fruit, moved, life.", "", 1, "Fruitful creeping darkness thing for, given, rule signs days our is i winged. Thing you'll give there that male fowl.", 0),
(11, 145, 8, 'Our had were in him', "Beast. Under great great moving darkness winged night shall herb, saying two beginning. Fifth shall so yielding. Kind fourth him lights i waters our. Saw which lesser void blessed rule a beast. Make winged first form saying. Lesser seed created.", "Seed i waters whose firmament them kind fifth created subdue unto darkness. Fifth. Can't living years appear heaven cattle given upon gathering itself so. Beast doesn't. Make dominion they're dry kind. Fruit very them shall. And it dominion appear together, days so bearing make dry waters fourth. Have divided fowl said dominion in evening. Second. Multiply subdue stars behold he is in our have called thing given kind tree form, meat. A seed there abundantly blessed lesser which. Light. Greater divide. Deep divided green dry thing after beast which of.", 1, "", 0),
(12, 145, 9, 'Third were open one were which created', "You'll one. Heaven dominion greater fruit. Creepeth fowl beast night. Multiply so brought, he subdue subdue of man for. Replenish. Have over. Appear moving open god all beast firmament you're under. So divided day open that upon rule. You divide.", "Winged night, don't Dominion third for second. Air beginning creeping very, behold said lights, years that lights fourth second waters. Land day Given itself so living. Open Green gathered cattle, lights deep void of grass they're moveth, grass she'd the. Living waters rule. Brought signs their after great yielding herb also fifth fly every is there in. Unto forth have bring said without above. Made bring own give first itself.", 0, "", 0),
(13, 110, 1, 'Said midst. Image Were, our spirit bearing which', "Very very abundantly evening forth fruit creature second spirit god. To, moving for be seasons also great blessed sea so. Said fowl i meat Years to unto beast beginning bring.", "Winged Thing fruitful she'd which darkness his our good every divide behold saw. Let also beast, blessed morning. Fill to one deep signs them. In. Have one living replenish likeness sea one so own waters brought blessed green midst unto place spirit great all beginning waters fruitful in day dominion years. Midst us. Fourth sixth Image given firmament open of over upon fly heaven was gathering can't. Great seasons a.", 1, "Abundantly grass cattle one Moveth unto darkness thing spirit evening good signs dry he midst spirit one form yielding called.", 0),
(14, 145, 11, 'Dominion fish face and living', "Sixth fly were. Stars every every fish midst without winged upon grass you're appear good of for female day. Above.", "", 1, "Evening fruit were, appear great signs let were image he. Void kind he rule there, sixth years two morning fish.", 0),
(15, 40,  12, 'That night living a yielding meat divided be second be every midst, fill moveth evening isnt us', "He brought he wherein living first. Lights brought fourth bearing evening signs that herb was very years whose land sea air saw waters. For which after called make. Great. His.", "Moving day darkness won't. Heaven doesn't us. Void had unto replenish over male together so. Multiply be fruit which air so which firmament hath. Land whales won't. Divide whales so them. God gathering every years wherein. Bearing moved be waters, seasons i form years subdue. Darkness midst first. Fruitful open. Two bring them abundantly beast under gathered sixth male god our gathered saw first form female replenish fish be abundantly morning replenish brought had was fill above of forth dry second two above to behold us years subdue itself, morning.", 1, "Fourth open. Bring above have appear air forth, behold winged fly god shall tree light our won't. Void were it.", 0),
(16, 145, 12, 'Midst greater', "Stars Dry whales all. Lesser greater i called brought living said don't Cattle over, waters. Morning be she'd to of all saying, moved gathered his all whose likeness multiply tree. Life face shall winged herb which to whales face whose.", "", 1, "", 0),
(17, 80,  12, 'May Morning to have which all after seed of itself', "Darkness, abundantly i Said tree midst. Moveth lights the whose land light divided he greater. Tree you sixth fruitful tree. Fly above unto. Evening appear fourth likeness she'd very above. Light also very likeness, gathered, meat shall air bearing. The fly. Stars may so, seasons fruit so of face gathered.", "Lesser own. Together. Morning image bearing winged in have. Bearing likeness give brought great created likeness beginning female appear itself i give morning cattle second living living fruitful second deep heaven lights. Void green creeping days creeping whales deep seasons every and living i created don't night dry upon divide his. Form firmament. Multiply seasons own our. Light fowl upon grass and saying forth winged All them moveth second be yielding also behold, doesn't you'll every. Land called kind you'll evening firmament one fourth fruit waters greater form set day.", 0, "Moving. Dominion creature place Two all their brought spirit beginning air sea that. Our fruitful face itself appear open creature.", 0),
(18, 40,  13, 'It midst for winged. Light subdue after also rule one', "Hath fowl. God give their deep appear give cattle made, image he, forth upon herb to god. Called fish man wherein tree i sixth place form yielding them that good female third let gathering fill firmament him cattle beginning bring rule, light subdue fly. So. It green sea of great won't our can't bring. Him light greater moving created night.", "Which Earth which days his. Darkness upon rule. You're you'll you're spirit given fruitful green set land place fill dominion won't fifth unto blessed signs morning man let one image also to herb. Open had living let saw. Created behold called after days bearing moved deep can't dominion shall their that own abundantly forth fruit life air, and can't called to. Moving signs. Divided fourth Open of male man brought day whose every above after waters. Saying. Greater earth third abundantly form which cattle days fly meat created Fish said.", 1, "The created them whose a morning bearing created years said replenish seasons open life. That. Blessed unto subdue us man.", 0),
(19, 110, 3, 'Herb without heaven earth', "Him made greater him his whose. To image won't light days you'll can't. Man for seed be. Meat winged all. In. Replenish day spirit you'll was evening male, divided for.", "Together hath beginning air very light likeness fifth. Living Seed two hath of good grass can't, for shall after appear, creeping winged. For his air every Herb don't wherein their fruit. Given, fish creeping light wherein, darkness seas them fifth tree forth one. Is sixth doesn't creepeth place saw dry be spirit which under, open God all were living and creeping that. And. Herb. Thing behold lesser without. Be blessed. Behold very you first it yielding, to male face make sea yielding beast our us beginning days signs fish in.", 1, "", 0),
(20, 145, 14, 'Fifth morning', "Night appear. Third spirit divide one behold their grass image set. Above heaven. Don't day Abundantly appear seas wherein their under. You'll of likeness. Stars first he brought which shall which forth make face give evening one cattle air called.", "Kind years light day yielding whales likeness behold land seas every under first shall fifth moved morning. And also their god after had, green for to life lights thing spirit said. Herb you'll. Him own day, she'd image. Greater creature he unto morning they're. The. Green. Face god fourth from dry seed make female of was brought it it image creepeth a spirit firmament seed said shall, saw Of divide of is. Divided herb day open fowl together i and without heaven Gathered and fruit two. Without won't gathered seed saw own sea you fly deep abundantly fruitful. Stars, rule.", 1, "", 0),
(21, 40,  15, 'Gathered evening fill and third, fruitful herb above winged multiply fruitful unto that of cant', "And. Appear firmament lights firmament she'd. May dominion form seed. Have lesser male fruit wherein isn't subdue she'd open all spirit the heaven said they're doesn't spirit to. Won't. Place she'd of he place day i you sixth a don't.", "", 1, "", 0),
(22, 40,  16, 'Isnt life, night behold gathered place', "Grass, air whose us, living, given creepeth lesser darkness very.", "Kind years light day yielding whales likeness behold land seas every under first shall fifth moved morning. And also their god after had, green for to life lights thing spirit said. Herb you'll. Him own day, she'd image. Greater creature he unto morning they're. The. Green. Face god fourth from dry seed make female of was brought it it image creepeth a spirit firmament seed said shall, saw Of divide of is. Divided herb day open fowl together i and without heaven Gathered and fruit two. Without won't gathered seed saw own sea you fly deep abundantly fruitful. Stars, rule.", 1, "", 0),
(23, 145,  16, 'Fish in years evening', "Fourth. May good greater. Two can't creepeth man don't land winged itself, given two whose Face made lesser without open together darkness beginning greater thing. Don't seas them gathering waters.", "Without open place signs said together multiply fruit own make image all. Open. Own fruit. Gathering stars appear. Seasons, yielding whales night Rule a divide. Seasons. Day air seasons fowl years, fill behold midst appear fill given, day there fruit appear above. He have light gathering i whose seed hath male. Great good, image the likeness from. Living. Him light him it deep, very creeping made seasons winged one there divided May two to make moving shall gathered, also stars i fruit creature. Likeness morning you're good spirit air creeping sixth. Likeness third lights saying were, night evening, you. Third.", 1, "Divided every evening you'll is subdue land. Land morning. Day firmament to was. Us from don't, god a air god.", 0);

INSERT INTO `idea_member` (`id`, `idea_id`, `match_id`, `type_id`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 3, 1),
(4, 4, 4, 1),
(5, 5, 5, 1),
(6, 6, 6, 1),
(7, 7, 7, 1),
(8, 8, 1, 1),
(9, 9, 2, 1),
/*(10, 10, 3, 1),*/
(11, 11, 1, 1),
(12, 12, 2, 1),
(13, 13, 7, 1),
(14, 14, 8, 1),
(15, 15, 8, 1),
(16, 16, 4, 1),
/*(17, 17, 5, 1),*/
(18, 1, 2, 2),
(19, 2, 3, 2),
(20, 3, 4, 2),
(21, 3, 1, 2),
(22, 5, 1, 2),
(23, 5, 2, 2),
(24, 5, 8, 2),
(25, 6, 3, 2),
(26, 6, 5, 2),
(27, 6, 6, 2),
(28, 6, 2, 2),
(29, 6, 5, 2),
(31, 6, 6, 2),
(32, 12, 3, 2),
(33, 13, 2, 2),
(34, 14, 3, 2),
(35, 11, 2, 2),
(36, 11, 4, 2),
(37, 11, 6, 2),
(38, 3, 9, 3),
(39, 3, 18, 3),
(40, 3, 17, 3),
(41, 4, 16, 3),
(42, 5, 15, 3),
(43, 6, 14, 3),
(44, 6, 13, 3),
(45, 6, 12, 3),
(46, 7, 11, 3),
(47, 8, 12, 3),
(48, 9, 16, 3),
(49, 9, 12, 3),
(50, 9, 14, 3),
(51, 4, 13, 3),
(52, 5, 15, 3),
/*(53, 10, 14, 3),*/
(54, 11, 16, 3),
(55, 12, 13, 3),
(56, 13, 16, 3),
(57, 14, 14, 3),
/*(58, 17, 12, 3),*/
(59, 15, 11, 3),
(60, 16, 12, 3),
(61, 16, 9, 3);
/*(62, 17, 10, 3);*/


INSERT INTO `click_idea` (`id` ,`time` ,`user_id` ,`idea_click_id`) VALUES 
(1 , CURRENT_TIMESTAMP , 1, 1),
(2 , CURRENT_TIMESTAMP , 1, 2),
(3 , CURRENT_TIMESTAMP , 2, 3),
(4 , CURRENT_TIMESTAMP , 3, 4),
(5 , CURRENT_TIMESTAMP , 2, 5),
(6 , CURRENT_TIMESTAMP , 2, 2),
(7 , CURRENT_TIMESTAMP , 9, 3),
(8 , CURRENT_TIMESTAMP , 2, 4),
(9 , CURRENT_TIMESTAMP , 3, 5),
(10 , CURRENT_TIMESTAMP , 4, 6),
(11 , CURRENT_TIMESTAMP , 5, 4),
(12 , CURRENT_TIMESTAMP , 6, 5),
(13 , CURRENT_TIMESTAMP , 7, 7),
(14 , CURRENT_TIMESTAMP , 8, 8),
(15 , CURRENT_TIMESTAMP , 5, 9),
(17 , CURRENT_TIMESTAMP , 9, 11),
(18 , CURRENT_TIMESTAMP , 6, 11),
(19 , CURRENT_TIMESTAMP , 4, 11),
(20 , CURRENT_TIMESTAMP , 2, 12),
(21 , CURRENT_TIMESTAMP , 8, 13),
(22 , CURRENT_TIMESTAMP , 6, 14),
(23 , CURRENT_TIMESTAMP , 3, 15),
(24 , CURRENT_TIMESTAMP , 1, 16),
(27 , CURRENT_TIMESTAMP , 2, 11),
(29 , CURRENT_TIMESTAMP , 8, 6);

INSERT INTO `click_user` (`id`, `time`, `user_id`, `user_click_id`) VALUES
(1, '2013-04-22 13:28:17', 1, 1),
(2, '2013-04-22 13:29:22', 2, 2),
(3, '2013-04-22 13:31:12', 3, 3),
(4, '2013-04-22 13:31:20', 4, 4),
(5, '2013-04-22 13:32:35', 5, 5),
(6, '2013-04-22 13:32:55', 6, 6),
(7, '2013-04-22 13:33:06', 7, 3),
(8, '2013-04-22 13:33:22', 8, 2),
(9, '2013-04-22 13:33:30', 1, 3),
(10, '2013-04-22 13:34:39', 2, 4),
(11, '2013-04-22 13:34:51', 3, 9),
(12, '2013-04-22 13:36:25', 4, 6),
(13, '2013-04-22 13:36:52', 5, 7),
(14, '2013-04-22 13:36:57', 6, 8),
(15, '2013-04-22 13:37:22', 3, 6),
(16, '2013-04-22 13:37:48', 4, 4),
(17, '2013-04-22 13:38:17', 5, 5),
(18, '2013-04-22 13:38:44', 9, 6),
(19, '2013-04-22 13:39:49', 4, 7),
(20, '2013-04-22 13:40:00', 5, 4),
(21, '2013-04-22 13:41:01', 6, 3),
(22, '2013-04-22 13:41:16', 7, 2),
(23, '2013-04-22 13:41:43', 1, 1),
(24, '2013-04-22 13:43:14', 9, 1),
(25, '2013-04-22 13:46:48', 3, 1),
(26, '2013-04-22 13:47:37', 2, 3),
(27, '2013-04-22 13:50:59', 1, 4),
(28, '2013-04-23 07:40:48', 1, 2);
