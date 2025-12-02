-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 02 déc. 2025 à 15:22
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `musique`
--

-- --------------------------------------------------------

--
-- Structure de la table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `nom_cd` varchar(255) NOT NULL,
  `artiste` varchar(255) NOT NULL,
  `annee_sortie` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `albums`
--

INSERT INTO `albums` (`id`, `nom_cd`, `artiste`, `annee_sortie`) VALUES
(1, 'You Want It Darker', 'Léonard Cohen', '2016'),
(2, 'Together Through Life', 'Bob Dylan', '2009'),
(3, 'Random Access Memories', 'Daft Punk', '2013'),
(4, 'Thriller', 'Michael Jackson', '1982'),
(5, 'Back in Black', 'AC/DC', '1980'),
(6, '21', 'Adele', '2011'),
(7, 'Nevermind', 'Nirvana', '1991'),
(8, 'The Dark Side of the Moon', 'Pink Floyd', '1973'),
(9, 'Abbey Road', 'The Beatles', '1969'),
(10, 'Hotel California', 'Eagles', '1976'),
(11, 'Rumours', 'Fleetwood Mac', '1977'),
(12, 'OK Computer', 'Radiohead', '1997'),
(13, 'Born to Run', 'Bruce Springsteen', '1975'),
(14, 'American Idiot', 'Green Day', '2004'),
(15, 'The Wall', 'Pink Floyd', '1979'),
(16, 'Bad', 'Michael Jackson', '1987'),
(17, '1989', 'Taylor Swift', '2014'),
(18, 'Hybrid Theory', 'Linkin Park', '2000'),
(19, 'Californication', 'Red Hot Chili Peppers', '1999'),
(20, 'Homework', 'Daft Punk', '1997'),
(21, 'Fearless', 'Taylor Swift', '2008'),
(22, 'In the Lonely Hour', 'Sam Smith', '2014'),
(23, 'Divide', 'Ed Sheeran', '2017'),
(24, 'X', 'Ed Sheeran', '2014'),
(25, 'Folklore', 'Taylor Swift', '2020'),
(26, 'Justice', 'Justin Bieber', '2021'),
(27, 'Future Nostalgia', 'Dua Lipa', '2020'),
(28, 'Unorthodox Jukebox', 'Bruno Mars', '2012'),
(29, 'Night Visions', 'Imagine Dragons', '2012'),
(30, 'AM', 'Arctic Monkeys', '2013'),
(31, 'Bad Habits', 'Billy Talent', '2012'),
(32, 'A Head Full of Dreams', 'Coldplay', '2015'),
(33, 'D’Eux', 'Céline Dion', '1995'),
(34, 'Chansons pour les pieds', 'Jean-Jacques Goldman', '2001'),
(35, 'Savoir aimer', 'Florent Pagny', '1997'),
(36, 'Rue de la Paix', 'Zazie', '2001'),
(37, 'Zen', 'Zazie', '1995'),
(38, 'Le Chemin', 'Kyo', '2003'),
(39, 'NRJ Music Awards 2010', 'Mylène Farmer', '2010'),
(40, 'Racine carrée', 'Stromae', '2013'),
(41, 'Le chant des sirènes', 'Orelsan', '2011'),
(42, 'Les Enfoirés en coeur', 'Les Enfoirés', '2019');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `identifiant` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `identifiant`, `motdepasse`, `role`) VALUES
(1, 'Administrateur', '$2y$10$Cx7yCWYxC7Po9sp.efMqceG1OWg/zbFzziXMqRC2tzD4O19A7FmHu', 'admin'),
(2, 'Utilisateur1', '$2y$10$h4XCcwr6jNpDEYQUilqTfOgvUNv01eVbrY.cnNVyoct3RIEdYR51e', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifiant` (`identifiant`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
