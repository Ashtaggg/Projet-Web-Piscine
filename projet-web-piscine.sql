-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 31 mai 2023 à 12:49
-- Version du serveur : 8.0.27
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet-web-piscine`
--

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `IDmessage` int NOT NULL AUTO_INCREMENT,
  `Envoyeur` varchar(255) NOT NULL COMMENT 'ID de l''utilisateur',
  `Recepteur` varchar(255) NOT NULL COMMENT 'ID de l''utilisateur ou du post',
  `Date` datetime NOT NULL,
  `Contenu` text NOT NULL,
  `Data` varchar(255) NOT NULL,
  `Statut` int NOT NULL COMMENT 'Si le message a été vu par le recepteur',
  PRIMARY KEY (`IDmessage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `IDpost` int NOT NULL AUTO_INCREMENT,
  `Envoyeur` varchar(255) NOT NULL COMMENT 'ID de l''utilisateur',
  `Type` varchar(255) NOT NULL,
  `Date` datetime NOT NULL,
  `Data` varchar(255) NOT NULL,
  `Legende` text NOT NULL,
  `Commentaires` text NOT NULL COMMENT 'Liste des ID Messages',
  `Like` int NOT NULL,
  PRIMARY KEY (`IDpost`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`IDpost`, `Envoyeur`, `Type`, `Date`, `Data`, `Legende`, `Commentaires`, `Like`) VALUES
(1, '1', 'photo', '2023-05-29 18:45:38', 'images/Cars.jpg', 'Je suis rapide !', '', 0),
(2, '2', 'photo', '2023-05-29 19:29:40', 'images/bob.jpg', 'Je suis une éponge !', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `IDutilisateur` int NOT NULL AUTO_INCREMENT,
  `Type` int NOT NULL COMMENT '(1) Admin ou (2) prof ou (3) élève ou (4) ancien élève',
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `DateNaissance` date NOT NULL,
  `Adresse` varchar(255) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `PhotoProfil` varchar(255) NOT NULL,
  `AnneeEtude` int NOT NULL,
  `Amis` text NOT NULL,
  `Messages` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'ID des messages',
  `Posts` text NOT NULL COMMENT 'ID des posts',
  `Emplois` text NOT NULL,
  PRIMARY KEY (`IDutilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IDutilisateur`, `Type`, `Nom`, `Prenom`, `DateNaissance`, `Adresse`, `Mail`, `PhotoProfil`, `AnneeEtude`, `Amis`, `Messages`, `Posts`, `Emplois`) VALUES
(1, 1, 'RAYNAL', 'Alexis', '2003-10-01', 'Saint-Mandé', 'alexis.raynal@edu.ece.fr', 'images/pp.jpg', 2, '2\r\n3\r\n4', '', '1\r\n', ''),
(2, 1, 'GRAS', 'Mathis', '2003-06-14', 'Dans les champs', 'mathis.gras@edu.ece.fr', 'images/pp.jpg', 2, '1\r\n3\r\n4', '', '2', ''),
(3, 1, 'BOURSE', 'Camille', '2004-06-09', 'Saint-Cloud', 'camille.bourse@edu.ece.fr', 'images/pp.jpg', 2, '1\r\n2\r\n4', '', '', ''),
(4, 1, 'GRASSIN', 'Laureline', '2003-11-17', 'Avec Emma', 'laureline.grassin@edu.ece.fr', 'images/pp.jpg', 2, '1\r\n2\r\n3\r\n', '', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
