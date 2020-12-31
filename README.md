# youtube-to-cms

Migration :

```sql
-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 30 déc. 2020 à 23:52
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `channel-storage`
--

-- --------------------------------------------------------

--
-- Structure de la table `website_cms`
--

CREATE TABLE `website_cms` (
  `id` int(11) NOT NULL,
  `base_url` text NOT NULL,
  `token` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `website_cms_youtube_channel`
--

CREATE TABLE `website_cms_youtube_channel` (
  `id` int(11) NOT NULL,
  `website_id` int(11) NOT NULL,
  `youtube_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `website_post`
--

CREATE TABLE `website_post` (
  `id` int(11) NOT NULL,
  `website_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
ALTER TABLE `website_post` ADD `post_id` INT NOT NULL AFTER `website_id`;
-- --------------------------------------------------------

--
-- Structure de la table `website_post_youtube_video`
--

CREATE TABLE `website_post_youtube_video` (
  `id` int(11) NOT NULL,
  `website_id` int(11) NOT NULL,
  `youtube_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `website_cms`
--
ALTER TABLE `website_cms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `website_cms_youtube_channel`
--
ALTER TABLE `website_cms_youtube_channel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `website_post`
--
ALTER TABLE `website_post`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `website_post_youtube_video`
--
ALTER TABLE `website_post_youtube_video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `website_cms`
--
ALTER TABLE `website_cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `website_cms_youtube_channel`
--
ALTER TABLE `website_cms_youtube_channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `website_post`
--
ALTER TABLE `website_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `website_post_youtube_video`
--
ALTER TABLE `website_post_youtube_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

```
