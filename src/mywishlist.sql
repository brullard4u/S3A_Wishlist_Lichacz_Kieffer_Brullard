-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 29 déc. 2020 à 13:27
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
  `tarif` decimal(5,2) DEFAULT NULL,
  `acquereur` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `liste_id`, `nom`, `descr`, `img`, `url`, `tarif`, `acquereur`) VALUES
(1, 2, 'Champagne', 'Bouteille de champagne + flutes + jeux à gratter', 'champagne.jpg', '', '20.00', ''),
(2, 2, 'Musique', 'Partitions de piano à 4 mains', 'musique.jpg', '', '25.00', ''),
(3, 2, 'Exposition', 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel', 'poirelregarder.jpg', '', '14.00', ''),
(4, 3, 'Goûter', 'Goûter au FIFNL', 'gouter.jpg', '', '20.00', ''),
(5, 3, 'Projection', 'Projection courts-métrages au FIFNL', 'film.jpg', '', '10.00', ''),
(6, 2, 'Bouquet', 'Bouquet de roses et Mots de Marion Renaud', 'rose.jpg', '', '16.00', ''),
(7, 2, 'Diner Stanislas', 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)', 'bonroi.jpg', '', '60.00', ''),
(8, 3, 'Origami', 'Baguettes magiques en Origami en buvant un thé', 'origami.jpg', '', '12.00', ''),
(9, 3, 'Livres', 'Livre bricolage avec petits-enfants + Roman', 'bricolage.jpg', '', '24.00', ''),
(10, 2, 'Diner  Grand Rue ', 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)', 'grandrue.jpg', '', '59.00', ''),
(11, 0, 'Visite guidée', 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas', 'place.jpg', '', '11.00', ''),
(12, 2, 'Bijoux', 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil', 'bijoux.jpg', '', '29.00', ''),
(19, 0, 'Jeu contacts', 'Jeu pour échange de contacts', 'contact.png', '', '5.00', ''),
(22, 0, 'Concert', 'Un concert à Nancy', 'concert.jpg', '', '17.00', ''),
(23, 1, 'Appart Hotel', 'Appart’hôtel Coeur de Ville, en plein centre-ville', 'apparthotel.jpg', '', '56.00', ''),
(24, 2, 'Hôtel d\'Haussonville', 'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas', 'hotel_haussonville_logo.jpg', '', '169.00', ''),
(25, 1, 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 'boitedenuit.jpg', '', '32.00', ''),
(26, 1, 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 'laser.jpg', '', '15.00', ''),
(27, 1, 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.', 'fort.jpg', '', '25.00', '');

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
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liste`
--

INSERT INTO `liste` (`no`, `user_id`, `titre`, `description`, `expiration`, `token`) VALUES
(1, 1, 'Pour fêter le bac !', 'Pour un week-end à Nancy qui nous fera oublier les épreuves. ', '2018-06-27', 'nosecure1'),
(2, 2, 'Liste de mariage d\'Alice et Bob', 'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)', '2018-06-30', 'nosecure2'),
(3, 3, 'C\'est l\'anniversaire de Charlie', 'Pour lui préparer une fête dont il se souviendra :)', '2017-12-12', 'nosecure3');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
