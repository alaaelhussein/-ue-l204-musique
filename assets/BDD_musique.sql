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

CREATE DATABASE IF NOT EXISTS `musique` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `musique`;

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

-- --------------------------------------------------------
-- Administrateur  : Test1234!
-- Utilisateur1..19: Test1234!
-- --------------------------------------------------------

INSERT INTO `utilisateurs` (`id`, `identifiant`, `motdepasse`, `role`) VALUES
(1, 'Administrateur', '$2y$10$qVhEZnwsfxc6/E5ttT/CseBs8ID0Lhr8WMrjCKQ69FBYVU9KbJZo.', 'admin'),
(2, 'Utilisateur1', '$2y$10$Vtvh.Y4NJSK58f3dHcDqFe9ZzlTEG5uxOLMMQ2mFvwG9fHODoZAuC', 'user'),
(3, 'Utilisateur2', '$2y$10$Pqn1sNYHmcijk2igyRMxUuMYJk.iBL6GRbFKLTK6zLqEzjfURFmjW', 'user'),
(4, 'Utilisateur3', '$2y$10$FjxB6DX6svHfVJJhjcWJM.QNJmhWzd.8Q9JBiM0YG2sOd/.V49wpu', 'user'),
(5, 'Utilisateur4', '$2y$10$2skgvxeyXKwUKBQISOoRp.B6uBFACKozrgExfXj1bwiFnCQABT5Te', 'user'),
(6, 'Utilisateur5', '$2y$10$e2/oh9LfUyEhlB7DKUJpkOqqbU5UFE6mVQiGmA4.2Bt3tDk4I3DUi', 'user'),
(7, 'Utilisateur6', '$2y$10$zxClo0xHnYiga6LUU4KhgeGQi5gvA3IP.PSIFXtsDePrh7d3KitRy', 'user'),
(8, 'Utilisateur7', '$2y$10$33ROuT/x43Sck..GMF20nun0tSbJN80rKmIIJC3IEGfqZtSyAXeh.', 'user'),
(9, 'Utilisateur8', '$2y$10$giCRjajpmqSqgKJ3E9pwK.tz7KwNRb2lpKYKNof7ZnVba7Pa6FZNO', 'user'),
(10, 'Utilisateur9', '$2y$10$6ivKS7gl7jYvNh6t/vN6duQYLyidG1X0l3P3.XXTAXUUPpPilXVi2', 'user'),
(11, 'Utilisateur10', '$2y$10$drOccr55FfU1hZjWPhBhz.lvoX4.UibB3/Vbquvm5erO91nKKkEky', 'user'),
(12, 'Utilisateur11', '$2y$10$TdLcoy6s9lbwNj8wS8ZZBO7brlYIkRwokIwVesJrAzWQGvZt2YJHS', 'user'),
(13, 'Utilisateur12', '$2y$10$ku.2OBdXmqSCGwOSkIfrF.Z2Ci8zrsIm3rp3PCTV1DUXvInrXPOrC', 'user'),
(14, 'Utilisateur13', '$2y$10$rkIKQ3sT7Esm2aPMjwe70OTOZLtgtcxI.nlPZyxiru//EZGrwdhIW', 'user'),
(15, 'Utilisateur14', '$2y$10$SsFtCB9jVxqr1LS1ofnewu9nP/bJVeJXZofDZGllF9jnl.CDgLx8W', 'user'),
(16, 'Utilisateur15', '$2y$10$pbOL7xy4MJBwVAsQXx8E2exDHlTHXaieY32oKVyajsY/8ZNEXdjgm', 'user'),
(17, 'Utilisateur16', '$2y$10$nH0cSpsQhzooCz2CpM1hUeYYRIImL7QXUXG6lKCNbj91g8EYUDnsm', 'user'),
(18, 'Utilisateur17', '$2y$10$QbmaWGI8pxkfMlpUgWlK7eiji25Nt7SeFsIM.GAsZzBjyXL6G1wUm', 'user'),
(19, 'Utilisateur18', '$2y$10$urUDFAKpBn52CH4rxV/jIebuzz98xam3aOTVH4W3hfkMs09m6tqiO', 'user'),
(20, 'Utilisateur19', '$2y$10$/r/5/cytiMlzCQ533Nw7Ce/35FtnyQjrsl66Vw.5DQo5Jg/Yklvrq', 'user');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;