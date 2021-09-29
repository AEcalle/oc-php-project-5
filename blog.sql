-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 28 sep. 2021 à 16:08
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `writer` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `post_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_comment_fk` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `created_at`, `writer`, `published`, `post_id`) VALUES
(59, 'Donut tootsie roll icing dessert chupa chups chocolate icing gummies gummi bears. Chocolate cake fruitcake pastry gingerbread topping jelly beans oat cake. Marshmallow jujubes icing liquorice dessert marzipan.', '2021-09-24 15:29:43', 'Alice', 1, 49),
(60, 'Fruitcake cotton candy cake shortbread cupcake candy canes sweet. Sesame snaps macaroon bear claw jujubes macaroon sweet pastry sesame snaps chocolate cake. Cotton candy sweet lollipop cheesecake dragée tiramisu pudding ice cream pie. Bonbon pie marzipan sweet roll liquorice marshmallow icing jujubes carrot cake.', '2021-09-24 15:31:52', 'Bob', 1, 50),
(61, 'Tootsie roll halvah pie brownie liquorice bear claw croissant. Pudding shortbread sweet macaroon cotton candy. Sweet ice cream dragée donut tart fruitcake sweet roll. Apple pie candy canes tiramisu lollipop liquorice candy donut.', '2021-09-24 15:33:00', 'Alice', 1, 50),
(62, 'Halvah gummi bears sesame snaps tootsie roll brownie. Marzipan brownie shortbread jelly beans apple pie macaroon. Chocolate shortbread pudding sweet roll icing topping. Oat cake candy canes marzipan lemon drops jelly pastry lemon drops icing.', '2021-09-27 11:55:11', 'Bob', 0, 49),
(63, 'Jelly pie fruitcake candy brownie tart. Soufflé chocolate icing oat cake powder jelly beans pudding fruitcake. Oat cake sesame snaps sesame snaps jelly halvah croissant. Tart pie carrot cake pudding chocolate cake oat cake.', '2021-09-27 16:58:23', 'Alice', 0, 52),
(64, 'Liquorice dragée pie macaroon marshmallow cake. Marshmallow halvah sesame snaps jelly beans fruitcake croissant candy. Brownie chupa chups icing sugar plum sweet roll candy brownie pie.', '2021-09-28 14:18:26', 'Bob', 0, 53);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `standfirst` text NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `author` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_post_fk` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `slug`, `standfirst`, `content`, `created_at`, `updated_at`, `author`, `user_id`) VALUES
(48, 'I love cake', 'i-love-cake', 'Caramels caramels bear claw I love I love I love macaroon icing danish. Liquorice candy canes sweet I love pudding.', '<p>Pie caramels cupcake biscuit candy canes shortbread tootsie roll. Chocolate cake gummies liquorice toffee cheesecake. Sweet bonbon jelly beans jelly carrot cake pie shortbread jelly beans. Cupcake liquorice dessert oat cake bonbon cookie soufflé caramels. Ice cream dessert cupcake brownie biscuit tiramisu tootsie roll. Chocolate cake candy canes biscuit cake oat cake cake caramels pastry.

Donut fruitcake jelly beans cheesecake ice cream toffee.</p><p>Cookie chocolate bar cupcake danish cake biscuit. Macaroon gummi bears liquorice topping biscuit apple pie cookie tart dragée. Jelly beans chocolate cake marshmallow powder marzipan topping. Tart sugar plum chocolate cake dessert marzipan tootsie roll topping cupcake cotton candy. Apple pie apple pie halvah halvah halvah muffin.

Pie caramels sweet roll bear claw lemon drops. Tart apple pie chocolate candy chocolate cookie sweet roll pastry.</p><p> Jujubes donut bear claw tiramisu tootsie roll lollipop. Donut pastry wafer chupa chups cupcake gummi bears ice cream. Topping pie croissant croissant macaroon bonbon chocolate. Sesame snaps bonbon jujubes macaroon pie powder.

Icing gingerbread muffin muffin pie lemon drops topping cake tootsie roll. Donut candy canes marshmallow cake shortbread apple pie candy canes jelly beans. Cheesecake tootsie roll bear claw biscuit croissant apple pie. Sweet roll bear claw carrot cake toffee shortbread pastry gingerbread. Sesame snaps cheesecake muffin tootsie roll jujubes halvah macaroon. Carrot cake sugar plum jelly beans sweet roll chocolate bar sesame snaps.

Sweet pudding sweet sweet icing tiramisu.</p><p> Carrot cake oat cake chocolate biscuit cookie macaroon. Apple pie fruitcake wafer cotton candy gummies carrot cake wafer chupa chups. Shortbread jelly-o tart jelly-o jelly beans bear claw toffee sugar plum. Cookie cake candy canes tootsie roll sweet roll. Marzipan croissant pie pudding pastry tootsie roll cookie topping fruitcake.</p>', '2021-09-24 14:22:34', '2021-09-24 14:22:34', 'Blutch', 8),
(49, 'Jelly I love', 'jelly-i-love', 'Pie wafer chocolate cake oat cake apple pie.', '<p>Gummies pudding danish jelly-o sweet roll powder cotton candy cake tootsie roll. Cookie apple pie soufflé sweet lemon drops sesame snaps pastry donut sweet roll. Powder caramels lemon drops ice cream dragée lollipop cheesecake bear claw. Fruitcake soufflé toffee cheesecake halvah tart biscuit cake pie. Toffee oat cake fruitcake tiramisu lemon drops. Topping sugar plum chocolate caramels jelly-o. Jujubes gummi bears cake dessert bonbon chocolate cake. Chocolate cake ice cream sugar plum pudding jelly beans donut muffin cake wafer. Chupa chups bonbon pastry sugar plum topping. Halvah candy candy cotton candy jelly beans caramels cookie bear claw.
Soufflé jujubes donut powder gummies.</p><p>Biscuit croissant macaroon tart cupcake sweet candy canes. Pastry sesame snaps bear claw carrot cake jujubes bonbon bonbon jelly beans. Cotton candy marzipan brownie pudding sweet. Bear claw cotton candy sweet topping soufflé candy ice cream bonbon cake. Chocolate cake bear claw macaroon jelly tootsie roll pastry macaroon cheesecake.
Toffee powder topping cake danish lollipop.</p><p>Cheesecake lemon drops candy canes pastry toffee macaroon toffee gummi bears. Sweet apple pie candy canes halvah cake. Marshmallow donut cookie apple pie cupcake liquorice cake croissant bear claw. Cotton candy biscuit biscuit soufflé jelly beans. Bear claw toffee topping biscuit tart fruitcake shortbread sweet. Cotton candy halvah chupa chups gingerbread sesame snaps.
Cake cupcake cake shortbread macaroon lemon drops jujubes gummies cake. Candy dragée shortbread ice cream ice cream donut cupcake cupcake. Sugar plum chocolate dragée liquorice ice cream chocolate macaroon topping chupa chups. Chocolate candy fruitcake gummi bears jujubes. Chocolate cake chocolate cake jujubes soufflé chocolate. Topping cookie topping lemon drops sweet sugar plum chocolate cake pudding. Caramels fruitcake lollipop jelly-o lemon drops. Tootsie roll gummi bears candy canes powder cotton candy. Dessert jelly halvah chocolate bar oat cake biscuit. Jelly candy canes tootsie roll danish macaroon carrot cake marshmallow cake.
Shortbread jelly cupcake jujubes cake croissant pie macaroon halvah.</p><p>Cake cake jelly jujubes donut jujubes dessert. Dessert jujubes topping sweet roll cotton candy halvah. Shortbread candy marshmallow pie marshmallow danish bonbon pudding jelly. Jelly wafer marshmallow toffee carrot cake gummies fruitcake. Marshmallow pudding tart chocolate bar pastry lollipop. Macaroon brownie sweet roll brownie croissant. Bear claw wafer marshmallow tootsie roll shortbread caramels fruitcake muffin.</p>', '2021-09-24 14:29:34', '2021-09-24 14:29:34', 'Blutch', 8),
(50, 'Dessert tiramisu powder', 'dessert-tiramisu-powder', 'Bonbon chocolate caramels cupcake caramels lollipop I love tiramisu.', '<p>Tiramisu fruitcake jelly-o sugar plum candy. Tart shortbread donut tootsie roll tart pie dragée. Apple pie dessert powder sugar plum jelly beans candy dragée marzipan apple pie. Bear claw dragée powder jelly-o icing. Cake biscuit chocolate dessert tart carrot cake apple pie wafer. Pastry shortbread ice cream soufflé ice cream candy powder halvah. Macaroon jujubes jujubes marshmallow cake pie donut.
Marzipan tart jelly beans ice cream sugar plum halvah carrot cake. Dragée apple pie apple pie icing lollipop bonbon wafer.</p><p>Lollipop dessert wafer shortbread soufflé apple pie jujubes. Pie gingerbread cake sweet chupa chups candy canes. Pudding bear claw chocolate chocolate bar chocolate cake tootsie roll gingerbread candy chupa chups. Bonbon dessert marzipan oat cake sweet shortbread tart sesame snaps. Dessert wafer ice cream cookie muffin dragée croissant cake jujubes.
Halvah cupcake shortbread chocolate bar jelly beans. Croissant tart croissant muffin croissant sesame snaps sesame snaps sweet roll danish. Candy canes croissant oat cake dessert cheesecake gingerbread chocolate bar apple pie. Jujubes soufflé chocolate bar dessert ice cream. Cheesecake cake cupcake tart donut. Jelly-o cheesecake marshmallow danish apple pie wafer.
Candy canes biscuit halvah dessert jelly-o bear claw jelly beans.</p><p>Halvah pie marshmallow soufflé marzipan cake marzipan sweet roll marshmallow. Chupa chups dessert halvah marshmallow soufflé sweet sweet roll cotton candy shortbread. Cupcake cake cake gummi bears marshmallow. Marzipan tootsie roll gingerbread cotton candy ice cream marzipan caramels. Pie sesame snaps marshmallow wafer toffee gummies.
Lemon drops jujubes soufflé bear claw shortbread lemon drops fruitcake marzipan tiramisu.</p><p>Tart sweet cheesecake toffee sesame snaps croissant. Chocolate bar lollipop biscuit caramels tootsie roll chocolate bar sweet. Lollipop caramels topping danish jujubes toffee jujubes chocolate bar. Marzipan shortbread bonbon lemon drops apple pie lemon drops sweet halvah sesame snaps. Cupcake jujubes gummi bears liquorice tart. Pie chupa chups jelly beans soufflé tiramisu. Candy canes cupcake muffin cheesecake sugar plum pie.</p>', '2021-09-24 14:49:43', '2021-09-24 14:49:43', 'Blutch', 8),
(52, 'Jelly dessert', 'jelly-dessert', 'Shortbread bonbon gummies brownie brownie powder tart.', '<p>Sweet tootsie roll halvah halvah pudding cake. Gummi bears soufflé sweet roll macaroon sweet roll oat cake. Lollipop cotton candy oat cake chupa chups donut jelly beans gummi bears cake. Cake oat cake jelly beans cupcake caramels pastry bonbon. Lollipop liquorice liquorice candy canes halvah. Chupa chups powder sesame snaps tootsie roll gummi bears brownie. Pie jelly sweet biscuit fruitcake.
Cotton candy marshmallow lollipop muffin macaroon sweet sweet roll.</p><p>Chupa chups cookie lemon drops macaroon jelly-o jelly-o sesame snaps liquorice croissant. Marzipan cookie danish donut apple pie halvah. Danish gingerbread tart soufflé gingerbread gingerbread lollipop fruitcake. Cake candy jelly-o gummies candy. Soufflé apple pie bonbon soufflé lollipop. Cupcake carrot cake macaroon jelly beans wafer marshmallow.
Bonbon donut sweet roll gummi bears cake tart cake donut fruitcake.</p><p>Sugar plum cotton candy macaroon jelly-o danish tiramisu cheesecake jelly-o. Apple pie donut lemon drops bear claw wafer candy canes shortbread chocolate bar powder. Sugar plum apple pie jelly-o croissant tart chocolate cake gummi bears. Chocolate bar cookie pie sesame snaps lollipop toffee croissant. Pastry apple pie pie cake gummies ice cream. Gummies cheesecake dragée pudding gummies pudding. Jujubes danish cupcake liquorice pie cupcake icing halvah dragée. Donut cupcake cheesecake toffee cake gingerbread candy candy cotton candy. Bear claw marzipan jelly fruitcake candy shortbread carrot cake soufflé gummies.
Jujubes marzipan chocolate cake brownie pastry powder chupa chups icing sesame snaps.</p><p>Chocolate cake sugar plum chocolate cake jujubes chocolate cake brownie gummies tiramisu. Wafer lemon drops oat cake sesame snaps cheesecake cupcake chocolate cake. Bear claw carrot cake sesame snaps carrot cake tiramisu. Dragée soufflé apple pie fruitcake carrot cake chocolate cake sugar plum topping. Cotton candy chupa chups cotton candy gummies tart jujubes. Pastry marzipan chupa chups danish donut.
Toffee jelly-o croissant pudding jelly beans candy chocolate bar biscuit brownie. Macaroon fruitcake wafer chocolate bonbon halvah shortbread. Gummi bears sweet roll gingerbread dessert muffin topping brownie jujubes chocolate bar. Sugar plum chocolate bar fruitcake dragée jelly. Sesame snaps cake candy canes caramels jelly beans cheesecake carrot cake. Toffee chupa chups cake halvah wafer wafer.</p>', '2021-09-24 15:33:21', '2021-09-27 15:19:23', 'Aurélien Ecalle', 6),
(53, 'Jelly beans tart', 'jelly-beans-tart', 'Cheesecake topping chocolate cake marzipan', '<p>Sweet roll danish topping ice cream cookie. Gummies lollipop cake gingerbread brownie pastry. Jelly-o tootsie roll pastry gummies wafer cookie ice cream chocolate. Lemon drops wafer wafer chocolate bar sesame snaps croissant. Marzipan cookie macaroon cake ice cream apple pie. Chocolate bar cheesecake sesame snaps danish halvah croissant. Macaroon dessert liquorice cake chocolate bar liquorice sugar plum fruitcake. Ice cream marzipan pudding sweet roll biscuit chupa chups jujubes. Cupcake pudding fruitcake sugar plum cake tart cake jelly beans tiramisu.
Pastry shortbread sesame snaps chocolate sugar plum muffin apple pie.</p><p>Carrot cake dessert chocolate cake cake donut gummies liquorice. Cake bear claw chocolate bar tart cake jelly sesame snaps sweet. Sweet caramels gummi bears soufflé bear claw. Apple pie marshmallow shortbread carrot cake croissant tart marshmallow. Jujubes ice cream pudding croissant jelly gummi bears muffin. Jelly caramels pudding dessert dessert pie donut chocolate bar chocolate. Dragée caramels lollipop ice cream sugar plum. Dessert tootsie roll sweet icing lemon drops carrot cake. Oat cake pie candy canes carrot cake cookie cheesecake cookie icing.
Caramels cupcake jelly-o cake cotton candy.</p><p>Icing gummi bears muffin cotton candy pie gummi bears chocolate cupcake. Marzipan candy gummies oat cake cupcake ice cream chocolate cake soufflé bear claw. Jelly-o shortbread sweet roll powder biscuit danish oat cake sesame snaps caramels. Chupa chups croissant candy jelly beans chocolate bar carrot cake macaroon gummi bears cake. Jelly beans cupcake icing jujubes bonbon. Sweet biscuit carrot cake macaroon brownie jelly beans wafer. Tart cookie croissant danish sweet sweet roll halvah.
Fruitcake candy canes croissant halvah biscuit gummi bears caramels. Gummi bears jujubes liquorice toffee candy brownie. Icing cotton candy powder pastry croissant shortbread. Cookie danish dessert pudding bear claw chocolate cake biscuit. Cake danish muffin sweet danish. Jelly apple pie chupa chups gummi bears wafer pastry. Carrot cake ice cream biscuit halvah apple pie candy.
Jujubes cake biscuit jujubes sweet roll lollipop ice cream soufflé chocolate bar. </p><p>Croissant halvah muffin sweet roll ice cream marzipan gummies halvah danish. Chupa chups chocolate bar candy canes toffee brownie jelly jelly-o danish. Tiramisu tart halvah jelly toffee. Gingerbread gummi bears tiramisu pie gingerbread. Danish bear claw shortbread chocolate macaroon. Croissant chocolate bar cake jelly chupa chups pie. Lollipop toffee icing donut lollipop jelly-o.</p>', '2021-09-28 15:33:32', '2021-09-28 15:33:32', 'Aurélien Ecalle', 6),
(54, 'I love cake', 'i-love-cake', 'Caramels caramels bear claw I love I love I love macaroon icing danish. Liquorice candy canes sweet I love pudding.', '<p>Pie caramels cupcake biscuit candy canes shortbread tootsie roll. Chocolate cake gummies liquorice toffee cheesecake. Sweet bonbon jelly beans jelly carrot cake pie shortbread jelly beans. Cupcake liquorice dessert oat cake bonbon cookie soufflé caramels. Ice cream dessert cupcake brownie biscuit tiramisu tootsie roll. Chocolate cake candy canes biscuit cake oat cake cake caramels pastry.

Donut fruitcake jelly beans cheesecake ice cream toffee.</p><p>Cookie chocolate bar cupcake danish cake biscuit. Macaroon gummi bears liquorice topping biscuit apple pie cookie tart dragée. Jelly beans chocolate cake marshmallow powder marzipan topping. Tart sugar plum chocolate cake dessert marzipan tootsie roll topping cupcake cotton candy. Apple pie apple pie halvah halvah halvah muffin.

Pie caramels sweet roll bear claw lemon drops. Tart apple pie chocolate candy chocolate cookie sweet roll pastry.</p><p> Jujubes donut bear claw tiramisu tootsie roll lollipop. Donut pastry wafer chupa chups cupcake gummi bears ice cream. Topping pie croissant croissant macaroon bonbon chocolate. Sesame snaps bonbon jujubes macaroon pie powder.

Icing gingerbread muffin muffin pie lemon drops topping cake tootsie roll. Donut candy canes marshmallow cake shortbread apple pie candy canes jelly beans. Cheesecake tootsie roll bear claw biscuit croissant apple pie. Sweet roll bear claw carrot cake toffee shortbread pastry gingerbread. Sesame snaps cheesecake muffin tootsie roll jujubes halvah macaroon. Carrot cake sugar plum jelly beans sweet roll chocolate bar sesame snaps.

Sweet pudding sweet sweet icing tiramisu.</p><p> Carrot cake oat cake chocolate biscuit cookie macaroon. Apple pie fruitcake wafer cotton candy gummies carrot cake wafer chupa chups. Shortbread jelly-o tart jelly-o jelly beans bear claw toffee sugar plum. Cookie cake candy canes tootsie roll sweet roll. Marzipan croissant pie pudding pastry tootsie roll cookie topping fruitcake.</p>', '2021-09-28 14:22:34', '2021-09-28 14:22:34', 'Blutch', 8),
(55, 'Jelly I love', 'jelly-i-love', 'Pie wafer chocolate cake oat cake apple pie.', '<p>Gummies pudding danish jelly-o sweet roll powder cotton candy cake tootsie roll. Cookie apple pie soufflé sweet lemon drops sesame snaps pastry donut sweet roll. Powder caramels lemon drops ice cream dragée lollipop cheesecake bear claw. Fruitcake soufflé toffee cheesecake halvah tart biscuit cake pie. Toffee oat cake fruitcake tiramisu lemon drops. Topping sugar plum chocolate caramels jelly-o. Jujubes gummi bears cake dessert bonbon chocolate cake. Chocolate cake ice cream sugar plum pudding jelly beans donut muffin cake wafer. Chupa chups bonbon pastry sugar plum topping. Halvah candy candy cotton candy jelly beans caramels cookie bear claw.
Soufflé jujubes donut powder gummies.</p><p>Biscuit croissant macaroon tart cupcake sweet candy canes. Pastry sesame snaps bear claw carrot cake jujubes bonbon bonbon jelly beans. Cotton candy marzipan brownie pudding sweet. Bear claw cotton candy sweet topping soufflé candy ice cream bonbon cake. Chocolate cake bear claw macaroon jelly tootsie roll pastry macaroon cheesecake.
Toffee powder topping cake danish lollipop.</p><p>Cheesecake lemon drops candy canes pastry toffee macaroon toffee gummi bears. Sweet apple pie candy canes halvah cake. Marshmallow donut cookie apple pie cupcake liquorice cake croissant bear claw. Cotton candy biscuit biscuit soufflé jelly beans. Bear claw toffee topping biscuit tart fruitcake shortbread sweet. Cotton candy halvah chupa chups gingerbread sesame snaps.
Cake cupcake cake shortbread macaroon lemon drops jujubes gummies cake. Candy dragée shortbread ice cream ice cream donut cupcake cupcake. Sugar plum chocolate dragée liquorice ice cream chocolate macaroon topping chupa chups. Chocolate candy fruitcake gummi bears jujubes. Chocolate cake chocolate cake jujubes soufflé chocolate. Topping cookie topping lemon drops sweet sugar plum chocolate cake pudding. Caramels fruitcake lollipop jelly-o lemon drops. Tootsie roll gummi bears candy canes powder cotton candy. Dessert jelly halvah chocolate bar oat cake biscuit. Jelly candy canes tootsie roll danish macaroon carrot cake marshmallow cake.
Shortbread jelly cupcake jujubes cake croissant pie macaroon halvah.</p><p>Cake cake jelly jujubes donut jujubes dessert. Dessert jujubes topping sweet roll cotton candy halvah. Shortbread candy marshmallow pie marshmallow danish bonbon pudding jelly. Jelly wafer marshmallow toffee carrot cake gummies fruitcake. Marshmallow pudding tart chocolate bar pastry lollipop. Macaroon brownie sweet roll brownie croissant. Bear claw wafer marshmallow tootsie roll shortbread caramels fruitcake muffin.</p>', '2021-09-24 14:29:34', '2021-09-24 14:29:34', 'Blutch', 8),
(56, 'Dessert tiramisu powder', 'dessert-tiramisu-powder', 'Bonbon chocolate caramels cupcake caramels lollipop I love tiramisu.', '<p>Tiramisu fruitcake jelly-o sugar plum candy. Tart shortbread donut tootsie roll tart pie dragée. Apple pie dessert powder sugar plum jelly beans candy dragée marzipan apple pie. Bear claw dragée powder jelly-o icing. Cake biscuit chocolate dessert tart carrot cake apple pie wafer. Pastry shortbread ice cream soufflé ice cream candy powder halvah. Macaroon jujubes jujubes marshmallow cake pie donut.
Marzipan tart jelly beans ice cream sugar plum halvah carrot cake. Dragée apple pie apple pie icing lollipop bonbon wafer.</p><p>Lollipop dessert wafer shortbread soufflé apple pie jujubes. Pie gingerbread cake sweet chupa chups candy canes. Pudding bear claw chocolate chocolate bar chocolate cake tootsie roll gingerbread candy chupa chups. Bonbon dessert marzipan oat cake sweet shortbread tart sesame snaps. Dessert wafer ice cream cookie muffin dragée croissant cake jujubes.
Halvah cupcake shortbread chocolate bar jelly beans. Croissant tart croissant muffin croissant sesame snaps sesame snaps sweet roll danish. Candy canes croissant oat cake dessert cheesecake gingerbread chocolate bar apple pie. Jujubes soufflé chocolate bar dessert ice cream. Cheesecake cake cupcake tart donut. Jelly-o cheesecake marshmallow danish apple pie wafer.
Candy canes biscuit halvah dessert jelly-o bear claw jelly beans.</p><p>Halvah pie marshmallow soufflé marzipan cake marzipan sweet roll marshmallow. Chupa chups dessert halvah marshmallow soufflé sweet sweet roll cotton candy shortbread. Cupcake cake cake gummi bears marshmallow. Marzipan tootsie roll gingerbread cotton candy ice cream marzipan caramels. Pie sesame snaps marshmallow wafer toffee gummies.
Lemon drops jujubes soufflé bear claw shortbread lemon drops fruitcake marzipan tiramisu.</p><p>Tart sweet cheesecake toffee sesame snaps croissant. Chocolate bar lollipop biscuit caramels tootsie roll chocolate bar sweet. Lollipop caramels topping danish jujubes toffee jujubes chocolate bar. Marzipan shortbread bonbon lemon drops apple pie lemon drops sweet halvah sesame snaps. Cupcake jujubes gummi bears liquorice tart. Pie chupa chups jelly beans soufflé tiramisu. Candy canes cupcake muffin cheesecake sugar plum pie.</p>', '2021-09-28 14:49:43', '2021-09-28 14:49:43', 'Blutch', 8),
(57, 'Jelly dessert', 'jelly-dessert', 'Shortbread bonbon gummies brownie brownie powder tart.', '<p>Sweet tootsie roll halvah halvah pudding cake. Gummi bears soufflé sweet roll macaroon sweet roll oat cake. Lollipop cotton candy oat cake chupa chups donut jelly beans gummi bears cake. Cake oat cake jelly beans cupcake caramels pastry bonbon. Lollipop liquorice liquorice candy canes halvah. Chupa chups powder sesame snaps tootsie roll gummi bears brownie. Pie jelly sweet biscuit fruitcake.
Cotton candy marshmallow lollipop muffin macaroon sweet sweet roll.</p><p>Chupa chups cookie lemon drops macaroon jelly-o jelly-o sesame snaps liquorice croissant. Marzipan cookie danish donut apple pie halvah. Danish gingerbread tart soufflé gingerbread gingerbread lollipop fruitcake. Cake candy jelly-o gummies candy. Soufflé apple pie bonbon soufflé lollipop. Cupcake carrot cake macaroon jelly beans wafer marshmallow.
Bonbon donut sweet roll gummi bears cake tart cake donut fruitcake.</p><p>Sugar plum cotton candy macaroon jelly-o danish tiramisu cheesecake jelly-o. Apple pie donut lemon drops bear claw wafer candy canes shortbread chocolate bar powder. Sugar plum apple pie jelly-o croissant tart chocolate cake gummi bears. Chocolate bar cookie pie sesame snaps lollipop toffee croissant. Pastry apple pie pie cake gummies ice cream. Gummies cheesecake dragée pudding gummies pudding. Jujubes danish cupcake liquorice pie cupcake icing halvah dragée. Donut cupcake cheesecake toffee cake gingerbread candy candy cotton candy. Bear claw marzipan jelly fruitcake candy shortbread carrot cake soufflé gummies.
Jujubes marzipan chocolate cake brownie pastry powder chupa chups icing sesame snaps.</p><p>Chocolate cake sugar plum chocolate cake jujubes chocolate cake brownie gummies tiramisu. Wafer lemon drops oat cake sesame snaps cheesecake cupcake chocolate cake. Bear claw carrot cake sesame snaps carrot cake tiramisu. Dragée soufflé apple pie fruitcake carrot cake chocolate cake sugar plum topping. Cotton candy chupa chups cotton candy gummies tart jujubes. Pastry marzipan chupa chups danish donut.
Toffee jelly-o croissant pudding jelly beans candy chocolate bar biscuit brownie. Macaroon fruitcake wafer chocolate bonbon halvah shortbread. Gummi bears sweet roll gingerbread dessert muffin topping brownie jujubes chocolate bar. Sugar plum chocolate bar fruitcake dragée jelly. Sesame snaps cake candy canes caramels jelly beans cheesecake carrot cake. Toffee chupa chups cake halvah wafer wafer.</p>', '2021-09-28 15:33:21', '2021-09-28 15:19:23', 'Aurélien Ecalle', 6),
(58, 'Jelly beans tart', 'jelly-beans-tart', 'Cheesecake topping chocolate cake marzipan', '<p>Sweet roll danish topping ice cream cookie. Gummies lollipop cake gingerbread brownie pastry. Jelly-o tootsie roll pastry gummies wafer cookie ice cream chocolate. Lemon drops wafer wafer chocolate bar sesame snaps croissant. Marzipan cookie macaroon cake ice cream apple pie. Chocolate bar cheesecake sesame snaps danish halvah croissant. Macaroon dessert liquorice cake chocolate bar liquorice sugar plum fruitcake. Ice cream marzipan pudding sweet roll biscuit chupa chups jujubes. Cupcake pudding fruitcake sugar plum cake tart cake jelly beans tiramisu.
Pastry shortbread sesame snaps chocolate sugar plum muffin apple pie.</p><p>Carrot cake dessert chocolate cake cake donut gummies liquorice. Cake bear claw chocolate bar tart cake jelly sesame snaps sweet. Sweet caramels gummi bears soufflé bear claw. Apple pie marshmallow shortbread carrot cake croissant tart marshmallow. Jujubes ice cream pudding croissant jelly gummi bears muffin. Jelly caramels pudding dessert dessert pie donut chocolate bar chocolate. Dragée caramels lollipop ice cream sugar plum. Dessert tootsie roll sweet icing lemon drops carrot cake. Oat cake pie candy canes carrot cake cookie cheesecake cookie icing.
Caramels cupcake jelly-o cake cotton candy.</p><p>Icing gummi bears muffin cotton candy pie gummi bears chocolate cupcake. Marzipan candy gummies oat cake cupcake ice cream chocolate cake soufflé bear claw. Jelly-o shortbread sweet roll powder biscuit danish oat cake sesame snaps caramels. Chupa chups croissant candy jelly beans chocolate bar carrot cake macaroon gummi bears cake. Jelly beans cupcake icing jujubes bonbon. Sweet biscuit carrot cake macaroon brownie jelly beans wafer. Tart cookie croissant danish sweet sweet roll halvah.
Fruitcake candy canes croissant halvah biscuit gummi bears caramels. Gummi bears jujubes liquorice toffee candy brownie. Icing cotton candy powder pastry croissant shortbread. Cookie danish dessert pudding bear claw chocolate cake biscuit. Cake danish muffin sweet danish. Jelly apple pie chupa chups gummi bears wafer pastry. Carrot cake ice cream biscuit halvah apple pie candy.
Jujubes cake biscuit jujubes sweet roll lollipop ice cream soufflé chocolate bar. </p><p>Croissant halvah muffin sweet roll ice cream marzipan gummies halvah danish. Chupa chups chocolate bar candy canes toffee brownie jelly jelly-o danish. Tiramisu tart halvah jelly toffee. Gingerbread gummi bears tiramisu pie gingerbread. Danish bear claw shortbread chocolate macaroon. Croissant chocolate bar cake jelly chupa chups pie. Lollipop toffee icing donut lollipop jelly-o.</p>', '2021-09-25 15:33:32', '2021-09-25 15:33:32', 'Aurélien Ecalle', 6),
(59, 'Jelly beans tart', 'jelly-beans-tart', 'Cheesecake topping chocolate cake marzipan', '<p>Sweet roll danish topping ice cream cookie. Gummies lollipop cake gingerbread brownie pastry. Jelly-o tootsie roll pastry gummies wafer cookie ice cream chocolate. Lemon drops wafer wafer chocolate bar sesame snaps croissant. Marzipan cookie macaroon cake ice cream apple pie. Chocolate bar cheesecake sesame snaps danish halvah croissant. Macaroon dessert liquorice cake chocolate bar liquorice sugar plum fruitcake. Ice cream marzipan pudding sweet roll biscuit chupa chups jujubes. Cupcake pudding fruitcake sugar plum cake tart cake jelly beans tiramisu.
Pastry shortbread sesame snaps chocolate sugar plum muffin apple pie.</p><p>Carrot cake dessert chocolate cake cake donut gummies liquorice. Cake bear claw chocolate bar tart cake jelly sesame snaps sweet. Sweet caramels gummi bears soufflé bear claw. Apple pie marshmallow shortbread carrot cake croissant tart marshmallow. Jujubes ice cream pudding croissant jelly gummi bears muffin. Jelly caramels pudding dessert dessert pie donut chocolate bar chocolate. Dragée caramels lollipop ice cream sugar plum. Dessert tootsie roll sweet icing lemon drops carrot cake. Oat cake pie candy canes carrot cake cookie cheesecake cookie icing.
Caramels cupcake jelly-o cake cotton candy.</p><p>Icing gummi bears muffin cotton candy pie gummi bears chocolate cupcake. Marzipan candy gummies oat cake cupcake ice cream chocolate cake soufflé bear claw. Jelly-o shortbread sweet roll powder biscuit danish oat cake sesame snaps caramels. Chupa chups croissant candy jelly beans chocolate bar carrot cake macaroon gummi bears cake. Jelly beans cupcake icing jujubes bonbon. Sweet biscuit carrot cake macaroon brownie jelly beans wafer. Tart cookie croissant danish sweet sweet roll halvah.
Fruitcake candy canes croissant halvah biscuit gummi bears caramels. Gummi bears jujubes liquorice toffee candy brownie. Icing cotton candy powder pastry croissant shortbread. Cookie danish dessert pudding bear claw chocolate cake biscuit. Cake danish muffin sweet danish. Jelly apple pie chupa chups gummi bears wafer pastry. Carrot cake ice cream biscuit halvah apple pie candy.
Jujubes cake biscuit jujubes sweet roll lollipop ice cream soufflé chocolate bar. </p><p>Croissant halvah muffin sweet roll ice cream marzipan gummies halvah danish. Chupa chups chocolate bar candy canes toffee brownie jelly jelly-o danish. Tiramisu tart halvah jelly toffee. Gingerbread gummi bears tiramisu pie gingerbread. Danish bear claw shortbread chocolate macaroon. Croissant chocolate bar cake jelly chupa chups pie. Lollipop toffee icing donut lollipop jelly-o.</p>', '2021-09-01 15:33:32', '2021-09-01 15:33:32', 'Aurélien Ecalle', 6);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `created_at`, `role`) VALUES
(6, 'contact@aurelienecalle.fr', '$2y$10$HDtX9HpQplH3GY2.seaJBeLLoikgc/KSAaeGNZJKoJ1xGuPtK4I4C', '2021-09-23 15:12:47', 'admin'),
(8, 'blutch70@hotmail.com', '$2y$10$a3sUJJZAF6bU.SRSnfzoEe6E/go7lAICf6iMn31cV90sIK6gHR8By', '2021-09-24 10:42:31', 'author');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `post_comment_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `user_post_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
