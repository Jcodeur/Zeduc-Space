-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 25 oct. 2024 à 00:36
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
-- Base de données : `zeduc_space`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id_administrateur` int(11) NOT NULL,
  `email` text NOT NULL,
  `mot_de_passe` text NOT NULL,
  `nom_administrateur` text NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_administrateur`, `email`, `mot_de_passe`, `nom_administrateur`, `role`) VALUES
(1, 'saitama@gmail.com', 'fgh$$¨MANC09ghutghjihyvtgfdftd(-è_ygh', 'saitama', 'admin'),
(2, 'gojo@gmail.com', 'fgh$$¨MANC09ghutghjihyvtgfdftd(-è_ygh', 'gojo', 'gerant');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_utilisateur` int(11) NOT NULL,
  `montant_total` int(11) NOT NULL,
  `nombre_de_point_accumuler` int(11) NOT NULL,
  `date_de_commande` text NOT NULL,
  `id_plat` int(11) NOT NULL,
  `id_commande` text NOT NULL,
  `nombre_de_plat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

CREATE TABLE `employes` (
  `id_employe` int(11) NOT NULL,
  `email` text NOT NULL,
  `mot_de_passe` text NOT NULL,
  `nom_employe` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`id_employe`, `email`, `mot_de_passe`, `nom_employe`) VALUES
(1, 'maxime@gmail.com', 'fgh$$¨MANC09ghutghjihyvtgfdftd(-è_ygh', 'maxime'),
(2, 'josue@gmail.com', 'fgh$$¨MANC09ghutghjihyvtgfdftd(-è_ygh', 'josue'),
(4, 'phillipe@gmail.com', 'fgh$$¨MANC09ghutghjihyvtgfdftd(-è_ygh', 'phillipe'),
(7, 'victor@gmail.com', 'fgh$$¨MANC09ghutghjihyvtgfdftd(-è_ygh', 'victor');

-- --------------------------------------------------------

--
-- Structure de la table `est_parrainer`
--

CREATE TABLE `est_parrainer` (
  `id_parrain` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parrainage`
--

CREATE TABLE `parrainage` (
  `id_parrain` int(11) NOT NULL,
  `id_filleuil` int(11) NOT NULL,
  `date_de_parrainage` text NOT NULL,
  `etat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

CREATE TABLE `plats` (
  `id_plat` int(11) NOT NULL,
  `nom_du_plat` text NOT NULL,
  `prix` int(11) NOT NULL,
  `photo_du_plat` text NOT NULL,
  `description` text DEFAULT NULL,
  `visible` text NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `plats`
--

INSERT INTO `plats` (`id_plat`, `nom_du_plat`, `prix`, `photo_du_plat`, `description`, `visible`) VALUES
(1, 'ndolè', 1000, 'partie etudiante/img/gallery/01.jpg', 'un plat mythique qui fait frisonnés les papilles gustatives de tout africain qui se respecte', 'true'),
(2, 'eru', 1000, 'partie etudiante/img/gallery/02.jpg', 'un plat qui se mange seulement avec les meilleurs pour garder tout son impact gustatif', 'true'),
(3, 'koki', 1000, 'partie etudiante/img/gallery/03.jpg', 'tout l état camerounais le reconnait comme le meilleur plat de la région de l ouest cameroun', 'true'),
(4, 'poulet dg', 1500, 'partie etudiante/img/gallery/04.jpg', 'se mange principalement avec du plantain mur le complément par excellence de tout camerounais', 'true'),
(5, 'poisson braisé', 1500, 'partie etudiante/img/gallery/05.jpg', 'avant que se plat ne soit servit sur la table les adèptes le consomment d abord a travers son odeur avoutante', 'true'),
(6, 'okok sucre/sale', 1000, 'partie etudiante/img/gallery/06.jpg', 'un plat qui a plusieurs variantes mais qui cause de nombreux débat à cause de sa version sucrée et salée', 'true'),
(7, 'porc braisé', 1500, 'partie etudiante/img/gallery/07.jpg', 'de quoi réveiller un palais qui ne demandais que réconfort et qui l a trouvé Dieu merci au zeduc space', 'true'),
(8, 'steak de boeuf', 1500, 'partie etudiante/img/gallery/08.jpg', 'un plat qu on ne voit qu a la télé mais qui se retrouve dans le zeduc space', 'true');

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id_utilisateur` int(11) NOT NULL,
  `type` text NOT NULL,
  `titre` text NOT NULL,
  `commentaire` text NOT NULL,
  `etat_de_la_reclamation` text NOT NULL DEFAULT 'non_lu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `nom_d_utilisateur` text NOT NULL,
  `email` text NOT NULL,
  `numero_de_telephone` int(11) NOT NULL,
  `id_parrain` int(11) NOT NULL,
  `statut` text NOT NULL,
  `mot_de_passe` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom_d_utilisateur`, `email`, `numero_de_telephone`, `id_parrain`, `statut`, `mot_de_passe`) VALUES
(1, 'jcodeur', 'jcodeur@gmail.com', 659156460, 1, 'deconnecte', 'egjopenfghvvkjgbd8-è_à)jure3DCGT7ncfnpoifjnc'),
(2, 'felix', 'felix@gmail.com', 677383231, 1, 'deconnecte', 'azerezZEDFmtfgfbdndnnshfnhdcnkfnfnxh+09'),
(3, 'codeur', 'codeur@gmail.com', 698765421, 2, 'deconnecte', 'fgh$$¨MANC09ghutghjihyvtgfdftd(-è_ygh'),
(4, 'aimaster', 'aimaster@gmail.com', 663636363, 3, 'deconnecte', 'yguh:shgfghjh-è_xucjwfrBqqdgxf.s'),
(5, 'naruto', 'naruto@gmail.com', 681234567, 12, 'deconnecte', 'fgh$$¨MANC09ghutghjihyvtgfdftd(-è_ygh');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id_administrateur`);

--
-- Index pour la table `employes`
--
ALTER TABLE `employes`
  ADD PRIMARY KEY (`id_employe`);

--
-- Index pour la table `plats`
--
ALTER TABLE `plats`
  ADD PRIMARY KEY (`id_plat`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id_administrateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `employes`
--
ALTER TABLE `employes`
  MODIFY `id_employe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `plats`
--
ALTER TABLE `plats`
  MODIFY `id_plat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
