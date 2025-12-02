--
-- Base de données: `musique`
--

CREATE DATABASE IF NOT EXISTS `musique` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `musique`;

-- --------------------------------------------------------

--
-- Structure de la table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_cd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `artiste` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `annee_sortie` year(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `albums`
--

INSERT INTO `albums` (`id`, `nom_cd`, `artiste`, `annee_sortie`) VALUES
(1, 'You Want It Darker', 'Léonard Cohen', 2016);
INSERT INTO `albums` (`id`, `nom_cd`, `artiste`, `annee_sortie`) VALUES
(2, 'Together Through Life', 'Bob Dylan', 2009);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motdepasse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifiant` (`identifiant`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `identifiant`, `motdepasse`) VALUES
(1, 'Administrateur', '83CCutv8');