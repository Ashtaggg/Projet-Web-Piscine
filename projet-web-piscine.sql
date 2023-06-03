-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 03 juin 2023 à 16:48
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

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
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `IDcommentaire` int NOT NULL,
  `Envoyeur` int NOT NULL COMMENT 'IDutilisateur',
  `IDpost` int NOT NULL,
  `Date` datetime NOT NULL,
  `Contenu` text NOT NULL,
  PRIMARY KEY (`IDcommentaire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`IDcommentaire`, `Envoyeur`, `IDpost`, `Date`, `Contenu`) VALUES
(1, 1, 2, '2023-06-02 08:43:48', 'TEST'),
(2, 2, 2, '2023-06-02 09:18:47', 'Ca marche !!!'),
(3, 3, 2, '2023-06-02 09:32:01', 'Je suis aigrie !!!');

-- --------------------------------------------------------

--
-- Structure de la table `emplois`
--

DROP TABLE IF EXISTS `emplois`;
CREATE TABLE IF NOT EXISTS `emplois` (
  `IDemplois` int NOT NULL,
  `IDutilisateur` int NOT NULL,
  `NomEntreprise` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `DateDebut` date NOT NULL,
  `DateFin` date NOT NULL,
  `Lieu` varchar(255) NOT NULL,
  `Poste` varchar(255) NOT NULL,
  `Salaire` int NOT NULL,
  PRIMARY KEY (`IDemplois`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `emplois`
--

INSERT INTO `emplois` (`IDemplois`, `IDutilisateur`, `NomEntreprise`, `Type`, `DateDebut`, `DateFin`, `Lieu`, `Poste`, `Salaire`) VALUES
(1, 0, 'Carrefour', 'Stage', '2023-06-14', '2023-07-14', '1 AV du Général Sarrail, 75016 Paris', 'Mise en rayon/drive', 0),
(2, 0, 'Thalès', 'CDD', '2023-07-01', '2023-08-31', '6 r Verrerie, 92190 Meudon', 'Ingénieur développement logiciel', 2000),
(3, 0, 'Lycée Hoche', 'CDD', '2023-09-04', '2024-06-18', '73 av St Cloud, 78000 Versailles', 'Professeur d\'italien', 1850),
(4, 0, 'Nasa', 'CDI', '2023-09-01', '0000-00-00', '300 Hidden Figures Way, Washington', 'PDG', 12000),
(5, 0, 'Roland Garros', 'Stage', '2023-04-10', '2023-06-20', 'Roland Garros', 'Logistique', 700);

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `IDformation` int NOT NULL,
  `IDutilisateur` int NOT NULL,
  `NomEcole` varchar(255) NOT NULL,
  `Diplome` varchar(255) NOT NULL,
  `DateDebut` date NOT NULL,
  `DateFin` date NOT NULL,
  `Lieu` varchar(255) NOT NULL,
  `Domaine` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`IDformation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`IDformation`, `IDutilisateur`, `NomEcole`, `Diplome`, `DateDebut`, `DateFin`, `Lieu`, `Domaine`, `Description`) VALUES
(1, 3, 'Blanche de Castille', 'Baccalauréat', '2018-09-03', '2021-06-16', 'Le Chesnay', 'Section générale', 'J\'ai eu mon bac !');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`IDmessage`, `Envoyeur`, `Recepteur`, `Date`, `Contenu`, `Data`, `Statut`) VALUES
(1, '1', '2', '2023-06-02 13:55:40', 'T\'es bo', '', 1),
(2, '2', '1', '2023-06-02 13:56:05', 'petite taille', '', 1);

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
  `Commentaires` int NOT NULL,
  `Aime` int NOT NULL,
  PRIMARY KEY (`IDpost`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`IDpost`, `Envoyeur`, `Type`, `Date`, `Data`, `Legende`, `Commentaires`, `Aime`) VALUES
(1, '1', 'photo', '2023-05-29 18:45:38', 'images/Cars.jpg', 'Je suis rapide !', 0, 1),
(2, '2', 'photo', '2023-05-29 19:29:40', 'images/bob.jpg', 'Je suis une éponge !', 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `postulant`
--

DROP TABLE IF EXISTS `postulant`;
CREATE TABLE IF NOT EXISTS `postulant` (
  `IDpostulant` int NOT NULL AUTO_INCREMENT,
  `IDutilisateur` int NOT NULL,
  `IDemplois` int NOT NULL,
  PRIMARY KEY (`IDpostulant`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `IDprojet` int NOT NULL,
  `IDutilisateur` int NOT NULL,
  `NomEcole` varchar(255) NOT NULL,
  `NomProjet` varchar(255) NOT NULL,
  `Lieu` varchar(255) NOT NULL,
  `DateDebut` date NOT NULL,
  `DateFin` date NOT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`IDprojet`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`IDprojet`, `IDutilisateur`, `NomEcole`, `NomProjet`, `Lieu`, `DateDebut`, `DateFin`, `Description`) VALUES
(1, 3, 'Ece Paris/Lyon', 'Projet piscine web dynamique', 'France', '2023-05-29', '2023-06-04', 'Création d\'un LinkedIn (ECEIn)'),
(2, 3, 'Omnes Education', 'ECE makers', 'San Francisco', '2023-06-14', '2023-06-23', '');

-- --------------------------------------------------------

--
-- Structure de la table `relation`
--

DROP TABLE IF EXISTS `relation`;
CREATE TABLE IF NOT EXISTS `relation` (
  `IDrelation` int NOT NULL AUTO_INCREMENT,
  `Ami1` int NOT NULL,
  `Ami2` int NOT NULL,
  `statut` int NOT NULL,
  PRIMARY KEY (`IDrelation`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `relation`
--

INSERT INTO `relation` (`IDrelation`, `Ami1`, `Ami2`, `statut`) VALUES
(1, 4, 3, 2),
(2, 3, 4, 2),
(3, 4, 1, 2),
(4, 1, 2, 2),
(5, 2, 1, 2),
(7, 2, 3, 1);

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
  `MotDePasse` varchar(255) NOT NULL,
  `PhotoProfil` varchar(255) NOT NULL,
  `AnneeEtude` int NOT NULL,
  `Amis` text NOT NULL,
  `Messages` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'ID des messages',
  `Posts` text NOT NULL COMMENT 'ID des posts',
  `Emplois` text NOT NULL,
  `Descript` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Humeur` varchar(255) NOT NULL,
  PRIMARY KEY (`IDutilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IDutilisateur`, `Type`, `Nom`, `Prenom`, `DateNaissance`, `Adresse`, `Mail`, `MotDePasse`, `PhotoProfil`, `AnneeEtude`, `Amis`, `Messages`, `Posts`, `Emplois`, `Descript`, `Humeur`) VALUES
(1, 1, 'RAYNAL', 'Alexis', '2003-10-01', 'Saint-Mandé', 'alexis.raynal@edu.ece.fr', '', 'images/pp.jpg', 2, '2\r\n3\r\n4', '', '1\r\n', '', '', ''),
(2, 1, 'GRAS', 'Mathis', '2003-06-14', 'Dans les champs', 'mathis.gras@edu.ece.fr', '1234', 'images/pp.jpg', 2, '1\r\n3\r\n4', '', '2', '', '', ''),
(3, 1, 'BOURSE', 'Camille', '2004-06-09', 'Saint-Cloud', 'camille.bourse@edu.ece.fr', '1234', 'images/Like.png', 2, '1\r\n2\r\n4', '', '', '', '', ''),
(4, 1, 'Cars', 'Flash', '2003-11-17', 'Paris', 'laureline.grassin@edu.ece.fr', '1234', 'images/cars.jpg', 2, '1\r\n2\r\n3\r\n', '', '', '', 'J\'ai envie de rentrer chez moi', 'Motivé');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
