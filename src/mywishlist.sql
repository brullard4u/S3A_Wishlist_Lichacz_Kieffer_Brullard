-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 16 jan. 2021 à 21:26
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.10

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

CREATE TABLE `cagnotte` (
  `cagnotte_id` int(11) NOT NULL,
  `nom_participant` varchar(50) DEFAULT NULL,
  `id_item` int(11) DEFAULT NULL,
  `montant` decimal(7,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(5) NOT NULL,
  `no` int(5) NOT NULL,
  `message` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `no`, `message`) VALUES
(18, 1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `liste_id` int(11) NOT NULL,
  `nom` text CHARACTER SET utf8 NOT NULL,
  `descr` text CHARACTER SET utf8 DEFAULT NULL,
  `img` text CHARACTER SET utf8 DEFAULT NULL,
  `url` text CHARACTER SET utf8 DEFAULT NULL,
  `tarif` decimal(7,2) DEFAULT NULL,
  `acquereur` varchar(100) DEFAULT NULL,
  `message` varchar(250) DEFAULT NULL,
  `id_cagnotte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(25, 1, 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 'boitedenuit.jpg', '', '32.00', 'lkjhg', ';,kjnhbgfrde', NULL),
(26, 1, 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 'laser.jpg', '', '15.00', '', NULL, NULL),
(27, 1, 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.', 'fort.jpg', '', '25.00', '', NULL, NULL),
(29, 5, 'verre ', 'sdfghy', NULL, 'https://www.amazon.fr/Avalita-Verres-Transparent-lint%C3%A9rieur-Mariage/dp/B07ZGX4PT9/ref=asc_df_B07ZGX4PT9/?tag=googshopfr-21&linkCode=df0&hvadid=483573789050&hvpos=&hvnetw=g&hvrand=11757540551725404920&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=9055641&hvtargid=pla-1059194405744&psc=1', '38.00', NULL, NULL, NULL),
(33, 6, ';l,kjihbml;k,', 'ml;k', NULL, 'kjkhiyug\r\n', '5.00', NULL, NULL, NULL),
(35, 6, 'birkin', 'sac hermes', NULL, 'https://www.hermes.com/fr/fr/product/accessoire-curiosite-kelly-laque-H071667FD03/?gclid=EAIaIQobChMI6rDdoueg7gIVDt5RCh3lgwKSEAYYASABEgKedvD_BwE', '295.00', NULL, NULL, NULL),
(36, 6, 'botte', 'louis vuitton', NULL, 'https://fr.louisvuitton.com/fra-fr/produits/botte-haute-podium-a-plateforme-nvprod2130136v#1A7U7D', '1630.00', NULL, NULL, NULL),
(37, 6, 'chunky boots', 'naked wolfe', NULL, 'https://nakedwolfe.com/collections/ankle-boots/products/spice-black-shine', '290.00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

CREATE TABLE `liste` (
  `no` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `titre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `privacy` varchar(50) NOT NULL DEFAULT 'private'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liste`
--

INSERT INTO `liste` (`no`, `user_id`, `titre`, `description`, `expiration`, `token`, `privacy`) VALUES
(1, 1, 'Pour fêter le bac !', 'Pour un week-end à Nancy qui nous fera oublier les épreuves. ', '2018-06-27', 'nosecure1', 'public'),
(2, 2, 'Liste de mariage d\'Alice et Bob', 'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)', '2018-06-30', 'nosecure2', 'public'),
(3, 3, 'C\'est l\'anniversaire de Charlie', 'Pour lui préparer une fête dont il se souviendra :)', '2017-12-12', 'nosecure3', 'private'),
(4, 2, 'liste_test', 'ceci est un test', '2021-01-24', '81f2ba9', 'private'),
(6, 9, 'test', 'wdfguglfyktdkufyli', '2021-01-28', 'a11d68b', 'public');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `user_id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`user_id`, `nom`, `password`) VALUES
(2, 'Baptiste', '$2y$12$01bhxUjeUrhQ4DHVSMboteoFdq1/jBSYjUxsy6Nd85UhRRUvVzs9.'),
(7, 'Alphonse', '$2y$12$nqcO3dYlLACg1/cirp//u.XimD6WrnYGz3dXyT9ZVY/4tAkG4QjdW'),
(9, 'lichacz', '$2y$12$3j3WcsYu3A/IbxKbTKFVz.6zGPAyjWEN1rqsT/llwRelLPxx.ddhq');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cagnotte`
--
ALTER TABLE `cagnotte`
  ADD PRIMARY KEY (`cagnotte_id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `liste`
--
ALTER TABLE `liste`
  ADD PRIMARY KEY (`no`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cagnotte`
--
ALTER TABLE `cagnotte`
  MODIFY `cagnotte_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `liste`
--
ALTER TABLE `liste`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
