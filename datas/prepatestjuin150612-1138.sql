-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 12 Juin 2015 à 11:38
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `prepatestjuin`
--
CREATE DATABASE IF NOT EXISTS `prepatestjuin` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `prepatestjuin`;

-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

CREATE TABLE IF NOT EXISTS `droit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lenom` varchar(45) DEFAULT NULL,
  `ladesc` varchar(255) DEFAULT NULL,
  `laperm` smallint(5) unsigned DEFAULT '2' COMMENT 'par défaut \nadmin:0\nmoderateur: 1\npar defaut : 2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `droit`
--

INSERT INTO `droit` (`id`, `lenom`, `ladesc`, `laperm`) VALUES
(1, 'Administrateur', 'Administrateur du site - Tout les droits', 0),
(2, 'Modérateur', 'Modérateur du site - Vous pouvez désactiver un utilis', 1),
(3, 'Utilisateur', 'Utilisateur du site', 2);

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lenom` char(25) DEFAULT NULL COMMENT 'le nom de la photo: \ndate+7chiffres aléotoires + ''.'' + extention = 25 char',
  `letype` char(3) DEFAULT NULL COMMENT 'extention 3 char\njpeg => jpg',
  `lepoids` int(10) unsigned DEFAULT NULL,
  `lahauteur` smallint(5) unsigned DEFAULT NULL,
  `lalargeur` smallint(5) unsigned DEFAULT NULL,
  `letitre` varchar(60) DEFAULT NULL,
  `ladesc` varchar(255) DEFAULT NULL,
  `utilisateur_id` int(10) unsigned NOT NULL COMMENT 'fk',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lenom_UNIQUE` (`lenom`),
  KEY `fk_photo_utilisateur1_idx` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lelogin` varchar(45) DEFAULT NULL,
  `lemdp` varchar(45) DEFAULT NULL,
  `lemail` varchar(150) DEFAULT NULL,
  `lenom` varchar(160) DEFAULT NULL,
  `lactif` tinyint(1) DEFAULT '0' COMMENT 'compte activé ou pas, 0 pas activé par défaut',
  `ladate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `laclef` varchar(32) DEFAULT NULL COMMENT 'Sécuriter suppl',
  `droit_id` int(10) unsigned NOT NULL COMMENT 'fk',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lelogin_UNIQUE` (`lelogin`),
  KEY `fk_utilisateur_droit_idx` (`droit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `lelogin`, `lemdp`, `lemail`, `lenom`, `lactif`, `ladate`, `laclef`, `droit_id`) VALUES
(1, 'Admin', 'admin', 'webdeveloperinani@gmail.com', 'Zazöû Nani', 1, '2015-06-12 09:32:50', '21232f297a57a5a743894a0e4a801fc3', 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `fk_photo_utilisateur1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `fk_utilisateur_droit` FOREIGN KEY (`droit_id`) REFERENCES `droit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
