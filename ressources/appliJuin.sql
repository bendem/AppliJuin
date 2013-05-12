-- phpMyAdmin SQL Dump
-- version 4.0.0-rc1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 05 Mai 2013 à 21:27
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `demartbe`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `dateCommande` date NOT NULL,
  `numUnite` int(11) NOT NULL,
  `numDepot` int(11) NOT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `composition`
--

DROP TABLE IF EXISTS `composition`;
CREATE TABLE IF NOT EXISTS `composition` (
  `numResultat` int(11) NOT NULL,
  `numIngredient` int(11) NOT NULL,
  `quantite` int(10) unsigned NOT NULL,
  PRIMARY KEY (`numResultat`,`numIngredient`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `depot`
--

DROP TABLE IF EXISTS `depot`;
CREATE TABLE IF NOT EXISTS `depot` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `cp` int(4) NOT NULL,
  `capaciteStockage` int(11) NOT NULL,
  `responsable` varchar(2) DEFAULT NULL COMMENT 'XA, GT, LP, RS, TT',
  `matiereDangereuse` tinyint(1) NOT NULL,
  PRIMARY KEY (`num`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `fabrique`
--

DROP TABLE IF EXISTS `fabrique`;
CREATE TABLE IF NOT EXISTS `fabrique` (
  `numUnite` int(10) unsigned NOT NULL,
  `numProduit` int(10) unsigned NOT NULL,
  `quantiteCoursFabrication` int(10) unsigned NOT NULL,
  `capaciteMax` int(10) unsigned NOT NULL,
  `capaciteMin` int(10) unsigned NOT NULL,
  PRIMARY KEY (`numUnite`,`numProduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

DROP TABLE IF EXISTS `ligne_commande`;
CREATE TABLE IF NOT EXISTS `ligne_commande` (
  `numCommande` int(11) NOT NULL,
  `numProduit` int(11) NOT NULL,
  `quantite` float NOT NULL,
  PRIMARY KEY (`numCommande`,`numProduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `num` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `uniteMesure` varchar(10) NOT NULL,
  `prix` float NOT NULL,
  `type` varchar(20) NOT NULL COMMENT 'fini, semi-fini, matière première',
  `categorie` tinyint(1) NOT NULL COMMENT 'matière dangereuse',
  PRIMARY KEY (`num`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `numDepot` int(11) NOT NULL,
  `numProduit` int(11) NOT NULL,
  `quantite` float NOT NULL,
  PRIMARY KEY (`numDepot`,`numProduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `unite_fabrication`
--

DROP TABLE IF EXISTS `unite_fabrication`;
CREATE TABLE IF NOT EXISTS `unite_fabrication` (
  `num` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `capaciteMax` int(10) unsigned NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `cp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `pwd` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
