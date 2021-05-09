-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 04 fév. 2019 à 18:01
-- Version du serveur :  5.7.24
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cours`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `insertionDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificationDate` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `insertionDate`, `modificationDate`) VALUES
(1, 'admin', '5c428d8875d2948607f3e3fe134d71b4', '2017-01-24 16:21:18', '09-02-2017 11:33:39 PM');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `chapitre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `departement` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `professeur` int(11) NOT NULL,
  `fichiers` varchar(255) DEFAULT NULL,
  `dateInsertion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModification` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `code`, `nom`, `chapitre`, `departement`, `session`, `professeur`, `fichiers`, `dateInsertion`, `dateModification`) VALUES
(8, '5d43', 'interaction homme machine', 'Chapitre 3', 9, 1, 4, 'a77b6b731b6641fa503dde51bdc52e37.pdf', '2019-01-19 19:18:53', NULL),
(10, '123', 'visualisation ', 'tous les chapitres ', 9, 1, 4, 'dcef842eb442ecf1c519749ad0a7df6c.pdf', '2019-01-23 19:27:52', NULL),
(12, '235', 'theorie de l\'information ', 'deuxieme chapitre ', 9, 1, 4, '93323d1aa8ce926f82d4c44b4b4672d9.pdf', '2019-01-23 19:31:56', NULL),
(13, 'z12', 'Data Warhousing', 'tous ', 9, 1, 4, '6a65ec4c5f71422605d9df190ac86cf1.pdf', '2019-01-23 19:34:43', NULL),
(14, 'sb12', 'IHM ', 'chapitre 1', 9, 1, 4, '46900ed6b6b4fcff7acc99daa842f8e4.pdf', '2019-02-04 17:44:35', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

DROP TABLE IF EXISTS `departements`;
CREATE TABLE IF NOT EXISTS `departements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departement` varchar(255) NOT NULL,
  `dateInsertion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `departements`
--

INSERT INTO `departements` (`id`, `departement`, `dateInsertion`) VALUES
(9, 'Data science', '2019-01-21 16:50:57'),
(10, 'Base de données et développement ', '2019-01-21 16:51:20'),
(11, 'Systemes et Réseaux ', '2019-01-21 16:51:37'),
(12, 'Internet des objets ', '2019-01-21 16:53:02'),
(13, 'Mathématiques ', '2019-01-21 16:55:37'),
(14, 'Infographie', '2019-01-22 18:04:22');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `cne` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `session` varchar(255) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `professeur` varchar(255) NOT NULL,
  `cgpa` decimal(10,2) DEFAULT NULL,
  `dateInsertion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModification` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cne`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`cne`, `photo`, `password`, `nom`, `pincode`, `session`, `departement`, `professeur`, `cgpa`, `dateInsertion`, `dateModification`) VALUES
('100', NULL, 'f925916e2754e5e03f75dd58a5733251', 'hakim', '447387', '2', '2', '4', NULL, '2019-01-19 15:06:09', '2019-01-19 18:16:52'),
('10806121', '96f3cb2d666378a2be3f2813f9d5ce61.jpg', '4a7d1ed414474e4033ac29ccb8653d9b', 'NiMO', '715948', '2', '1', '1', '7.20', '2017-02-11 19:38:32', '2019-01-19 18:43:56'),
('123456789', NULL, '5c428d8875d2948607f3e3fe134d71b4', 'Hakim Nasaoui ', '976763', '1', '9', '4', NULL, '2019-02-04 17:32:52', NULL),
('272501857', NULL, '4a7d1ed414474e4033ac29ccb8653d9b', 'Sbaiti abdelkhaleq', '171328', '2', '9', '4', NULL, '2019-01-23 18:43:24', NULL),
('2725018577', NULL, '7e16036a55664f22e6511e460ee09d4f', 'HANKAR', '659313', '1', '9', '3', NULL, '2019-01-23 18:29:54', NULL),
('457869', NULL, '6ecd10ce61b0fe549fe94849c0e11ea2', 'hasan ', '311706', '1', '9', '3', NULL, '2019-01-23 18:36:31', NULL),
('999999', NULL, '4a7d1ed414474e4033ac29ccb8653d9b', 'Mostafa Hankar', '336151', '6', '8', '7', NULL, '2019-01-19 18:17:36', '2019-01-21 15:26:43');

-- --------------------------------------------------------

--
-- Structure de la table `professeurs`
--

DROP TABLE IF EXISTS `professeurs`;
CREATE TABLE IF NOT EXISTS `professeurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `professeur` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dateInsertion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModification` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `professeurs`
--

INSERT INTO `professeurs` (`id`, `professeur`, `dateInsertion`, `dateModification`) VALUES
(3, 'Madani ', '2017-02-09 18:47:14', ''),
(4, 'Riffi ', '2017-02-09 18:47:59', ''),
(5, 'Benhssine', '2017-02-09 18:48:04', ''),
(6, 'Elkafi', '2019-01-19 19:16:49', NULL),
(8, 'Azouaoui', '2019-01-22 19:22:56', NULL),
(9, 'Belqziz', '2019-01-22 19:22:56', NULL),
(10, 'Silkane ', '2019-01-22 19:23:27', NULL),
(11, 'Moutouakil', '2019-01-22 19:23:27', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(255) NOT NULL,
  `dateInsertion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `session`, `dateInsertion`) VALUES
(1, 'Automne', '2017-02-09 18:16:51'),
(2, 'Printemps', '2017-02-09 18:27:41');

-- --------------------------------------------------------

--
-- Structure de la table `userlog`
--

DROP TABLE IF EXISTS `userlog`;
CREATE TABLE IF NOT EXISTS `userlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cne` varchar(255) NOT NULL,
  `userip` binary(16) NOT NULL,
  `dateLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateLogout` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `userlog`
--

INSERT INTO `userlog` (`id`, `cne`, `userip`, `dateLogin`, `dateLogout`, `status`) VALUES
(1, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:05:58', '2019-01-19 19:15:38', 1),
(2, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:07:18', '2019-01-19 19:15:38', 1),
(3, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:08:46', '2019-01-19 19:15:38', 1),
(4, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:26:15', '2019-01-19 19:15:38', 1),
(5, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:27:11', '2019-01-19 19:15:38', 1),
(6, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:28:19', '2019-01-19 19:15:38', 1),
(7, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:29:30', '2019-01-19 19:15:38', 1),
(8, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:30:39', '2019-01-19 19:15:38', 1),
(9, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:32:12', '2019-01-19 19:15:38', 1),
(10, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-11 20:51:50', '2019-01-19 19:15:38', 1),
(11, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-12 05:41:24', '2019-01-19 19:15:38', 1),
(12, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-12 06:20:05', '2019-01-19 19:15:38', 1),
(13, '10806121', 0x3a3a3100000000000000000000000000, '2017-02-12 06:20:23', '2019-01-19 19:15:38', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
