-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 17 jan. 2021 à 17:20
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mywishlist`
--

-- --------------------------------------------------------

--
-- Structure de la table `cagnotte`
--

DROP TABLE IF EXISTS `cagnotte`;
CREATE TABLE IF NOT EXISTS `cagnotte` (
  `cagnotte_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) DEFAULT NULL,
  PRIMARY KEY (`cagnotte_id`),
  UNIQUE KEY `id_item` (`id_item`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cagnotte`
--

INSERT INTO `cagnotte` (`cagnotte_id`, `id_item`) VALUES
(22, 35),
(23, 36);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(5) NOT NULL AUTO_INCREMENT,
  `no` int(5) NOT NULL,
  `message` varchar(100) NOT NULL,
  PRIMARY KEY (`id_commentaire`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `no`, `message`) VALUES
(18, 1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `liste_id` int(11) NOT NULL,
  `nom` text CHARACTER SET utf8 NOT NULL,
  `descr` text CHARACTER SET utf8,
  `img` text CHARACTER SET utf8,
  `url` text CHARACTER SET utf8,
  `tarif` decimal(7,2) DEFAULT NULL,
  `acquereur` varchar(100) DEFAULT NULL,
  `message` varchar(250) DEFAULT NULL,
  `id_cagnotte` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `liste_id`, `nom`, `descr`, `img`, `url`, `tarif`, `acquereur`, `message`, `id_cagnotte`) VALUES
(1, 2, 'Champagne', 'Bouteille de champagne + flutes + jeux à gratter', 'champagne.jpg', '', '20.00', '', NULL, NULL),
(2, 2, 'Musique', 'Partitions de piano à 4 mains', 'musique.jpg', '', '25.00', 'Baptiste', 'Félicitations', NULL),
(3, 2, 'Exposition', 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel', 'poirelregarder.jpg', '', '14.00', 'Charlie', 'Cadeau', NULL),
(4, 3, 'Goûter', 'Goûter au FIFNL', 'gouter.jpg', '', '20.00', '', NULL, NULL),
(5, 3, 'Projection', 'Projection courts-métrages au FIFNL', 'film.jpg', '', '10.00', '', NULL, NULL),
(6, 2, 'Bouquet', 'Bouquet de roses et Mots de Marion Renaud', 'rose.jpg', '', '16.00', '', NULL, NULL),
(7, 2, 'Diner Stanislas', 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)', 'bonroi.jpg', '', '60.00', '', NULL, NULL),
(8, 3, 'Origami', 'Baguettes magiques en Origami en buvant un thé', 'origami.jpg', '', '12.00', '', NULL, NULL),
(9, 3, 'Livres', 'Livre bricolage avec petits-enfants + Roman', 'bricolage.jpg', '', '24.00', '', NULL, NULL),
(10, 2, 'Diner  Grand Rue ', 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)', 'grandrue.jpg', '', '59.00', '', NULL, NULL),
(11, 0, 'Visite guidée', 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas', 'place.jpg', '', '11.00', '', NULL, NULL),
(12, 2, 'Bijoux', 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil', 'bijoux.jpg', '', '29.00', '', NULL, NULL),
(19, 0, 'Jeu contacts', 'Jeu pour échange de contacts', 'contact.png', '', '5.00', '', NULL, NULL),
(22, 0, 'Concert', 'Un concert à Nancy', 'concert.jpg', '', '17.00', '', NULL, NULL),
(23, 1, 'Appart Hotel', 'Appart’hôtel Coeur de Ville, en plein centre-ville', 'apparthotel.jpg', '', '56.00', '', NULL, NULL),
(24, 2, 'Hôtel d\'Haussonville', 'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas', 'hotel_haussonville_logo.jpg', '', '169.00', '', NULL, NULL),
(25, 1, 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 'boitedenuit.jpg', '', '32.00', 'sarah', 'Enjoy', NULL),
(26, 1, 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 'laser.jpg', '', '15.00', '', NULL, NULL),
(27, 1, 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.', 'fort.jpg', '', '25.00', '', NULL, NULL),
(29, 5, 'verre ', 'Verres transparents', NULL, 'https://www.amazon.fr/Avalita-Verres-Transparent-lint%C3%A9rieur-Mariage/dp/B07ZGX4PT9/ref=asc_df_B07ZGX4PT9/?tag=googshopfr-21&linkCode=df0&hvadid=483573789050&hvpos=&hvnetw=g&hvrand=11757540551725404920&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=9055641&hvtargid=pla-1059194405744&psc=1', '38.00', NULL, NULL, NULL),
(33, 6, 'DVD', 'DVD de qualité supérieure', NULL, NULL, '5.00', NULL, NULL, NULL),
(35, 6, 'birkin', 'sac hermes', NULL, 'https://www.hermes.com/fr/fr/product/accessoire-curiosite-kelly-laque-H071667FD03/?gclid=EAIaIQobChMI6rDdoueg7gIVDt5RCh3lgwKSEAYYASABEgKedvD_BwE', '295.00', NULL, NULL, '22'),
(36, 6, 'botte', 'louis vuitton', NULL, 'https://fr.louisvuitton.com/fra-fr/produits/botte-haute-podium-a-plateforme-nvprod2130136v#1A7U7D', '1630.00', NULL, NULL, '23'),
(37, 6, 'chunky boots', 'naked wolfe', NULL, 'https://nakedwolfe.com/collections/ankle-boots/products/spice-black-shine', '290.00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `joindre`
--

DROP TABLE IF EXISTS `joindre`;
CREATE TABLE IF NOT EXISTS `joindre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `liste_id` int(11) DEFAULT NULL,
  `createur` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `joindre`
--

INSERT INTO `joindre` (`id`, `user_id`, `liste_id`, `createur`) VALUES
(5, 9, 18, '1'),
(15, 9, 1, NULL),
(16, 9, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

DROP TABLE IF EXISTS `liste`;
CREATE TABLE IF NOT EXISTS `liste` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `titre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `expiration` date DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `privacy` varchar(50) NOT NULL DEFAULT 'private',
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liste`
--

INSERT INTO `liste` (`no`, `user_id`, `titre`, `description`, `expiration`, `token`, `privacy`) VALUES
(1, 1, 'Pour fêter le bac !', 'Pour un week-end à Nancy qui nous fera oublier les épreuves. ', '2018-06-27', 'nosecure1', 'public'),
(2, 2, 'Liste de mariage d\'Alice et Bob', 'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)', '2018-06-30', 'nosecure2', 'public'),
(3, 3, 'C\'est l\'anniversaire de Charlie', 'Pour lui préparer une fête dont il se souviendra :)', '2017-12-12', 'nosecure3', 'public'),
(4, 2, 'liste_test', 'ceci est un test', '2021-01-24', '81f2ba9', 'private'),
(6, 9, 'test', 'Liste de test', '2021-01-28', 'a11d68b', 'public');

-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

DROP TABLE IF EXISTS `participation`;
CREATE TABLE IF NOT EXISTS `participation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cagnotte` int(11) NOT NULL,
  `nom_participant` varchar(50) NOT NULL,
  `montant` decimal(7,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `participation`
--

INSERT INTO `participation` (`id`, `id_cagnotte`, `nom_participant`, `montant`) VALUES
(1, 23, 'martin', '0.00'),
(2, 23, 'martin', '160.00'),
(3, 23, 'sacha', '1470.00');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`user_id`, `nom`, `password`) VALUES
(2, 'Baptiste', '$2y$12$01bhxUjeUrhQ4DHVSMboteoFdq1/jBSYjUxsy6Nd85UhRRUvVzs9.'),
(7, 'Alphonse', '$2y$12$nqcO3dYlLACg1/cirp//u.XimD6WrnYGz3dXyT9ZVY/4tAkG4QjdW'),
(9, 'lichacz', '$2y$12$3j3WcsYu3A/IbxKbTKFVz.6zGPAyjWEN1rqsT/llwRelLPxx.ddhq');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
