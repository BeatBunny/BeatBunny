-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 21-Jan-2020 às 15:36
-- Versão do servidor: 5.7.24
-- versão do PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beatbunnyproject_test`
--

CREATE DATABASE IF NOT EXISTS beatbunnyproject_test;
USE beatbunnyproject_test;
-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE latin1_bin NOT NULL,
  `email` varchar(45) COLLATE latin1_bin NOT NULL,
  `password` varchar(64) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `albums`
--

DROP TABLE IF EXISTS `albums`;
CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE latin1_bin NOT NULL,
  `launchdate` date NOT NULL,
  `review` int(2) UNSIGNED DEFAULT NULL,
  `albumcover` varchar(200) COLLATE latin1_bin DEFAULT NULL,
  `genres_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_albums_genres1_idx` (`genres_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1577397448),
('admin', '36', 1578482095),
('client', '27', 1578165411),
('client', '31', 1577656722),
('client', '32', 1577657402),
('client', '33', 1577657596),
('client', '34', 1577657689),
('client', '37', 1578579292),
('client', '38', 1578750632),
('client', '39', 1578750720),
('client', '40', 1578751084),
('client', '41', 1578751176),
('client', '44', 1578758463),
('client', '45', 1578775924),
('producer', '2', 1577397448),
('producer', '28', 1577404568),
('producer', '29', 1577411732),
('producer', '3', 1577397448),
('producer', '30', 1577482390);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('accessAll', 2, 'Acess All pages (frontend) ', NULL, NULL, 1577397448, 1577397448),
('accessIsAdmin', 2, 'Acess ALL', NULL, NULL, 1577397448, 1577397448),
('accessPlaylists', 2, 'Acess Playlist', NULL, NULL, 1577397448, 1577397448),
('admin', 1, NULL, NULL, NULL, 1577397448, 1577397448),
('client', 1, NULL, NULL, NULL, 1577397448, 1577397448),
('producer', 1, NULL, NULL, NULL, 1577397448, 1577397448);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('producer', 'accessAll'),
('admin', 'accessIsAdmin'),
('client', 'accessPlaylists');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `iva`
--

DROP TABLE IF EXISTS `iva`;
CREATE TABLE IF NOT EXISTS `iva` (
  `id` int(11) NOT NULL,
  `tax` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `leitura_sensores`
--

DROP TABLE IF EXISTS `leitura_sensores`;
CREATE TABLE IF NOT EXISTS `leitura_sensores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temperatura` float NOT NULL,
  `humidade` float NOT NULL,
  `luminosidade` float NOT NULL,
  `descricao` varchar(254) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE latin1_bin NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `musics`
--

DROP TABLE IF EXISTS `musics`;
CREATE TABLE IF NOT EXISTS `musics` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(64) COLLATE latin1_bin NOT NULL,
  `launchdate` date NOT NULL,
  `rating` decimal(10,0) UNSIGNED ZEROFILL DEFAULT NULL,
  `lyrics` longtext COLLATE latin1_bin,
  `pvp` float DEFAULT NULL,
  `musiccover` varchar(100) COLLATE latin1_bin DEFAULT NULL,
  `musicpath` varchar(100) COLLATE latin1_bin DEFAULT NULL,
  `genres_id` int(10) UNSIGNED DEFAULT NULL,
  `albums_id` int(10) UNSIGNED DEFAULT NULL,
  `iva_id` int(11) DEFAULT NULL,
  `profile_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`,`profile_id`),
  KEY `fk_musics_genres1_idx` (`genres_id`),
  KEY `fk_musics_albums1_idx` (`albums_id`),
  KEY `fk_musics_iva1_idx` (`iva_id`),
  KEY `fk_musics_profile1_idx` (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `playlists`
--

DROP TABLE IF EXISTS `playlists`;
CREATE TABLE IF NOT EXISTS `playlists` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE latin1_bin NOT NULL,
  `ispublica` enum('S','N') COLLATE latin1_bin DEFAULT 'N',
  `creationdate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `playlists_has_musics`
--

DROP TABLE IF EXISTS `playlists_has_musics`;
CREATE TABLE IF NOT EXISTS `playlists_has_musics` (
  `playlists_id` int(10) UNSIGNED NOT NULL,
  `musics_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`playlists_id`,`musics_id`),
  KEY `fk_playlists_has_musics_musics1_idx` (`musics_id`),
  KEY `fk_playlists_has_musics_playlists1_idx` (`playlists_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `saldo` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(45) COLLATE latin1_bin NOT NULL,
  `nif` int(11) DEFAULT NULL,
  `isprodutor` enum('N','S') COLLATE latin1_bin NOT NULL,
  `profileimage` varchar(100) COLLATE latin1_bin DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_profile_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `profile_has_albums`
--

DROP TABLE IF EXISTS `profile_has_albums`;
CREATE TABLE IF NOT EXISTS `profile_has_albums` (
  `albums_id` int(10) UNSIGNED NOT NULL,
  `profile_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`albums_id`,`profile_id`),
  KEY `fk_profile_has_albums_albums1_idx` (`albums_id`),
  KEY `fk_profile_has_albums_profile1_idx` (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `profile_has_playlists`
--

DROP TABLE IF EXISTS `profile_has_playlists`;
CREATE TABLE IF NOT EXISTS `profile_has_playlists` (
  `profile_id` int(10) UNSIGNED NOT NULL,
  `playlists_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`profile_id`,`playlists_id`),
  KEY `fk_profile_has_playlists_playlists1_idx` (`playlists_id`),
  KEY `fk_profile_has_playlists_profile1_idx` (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

DROP TABLE IF EXISTS `venda`;
CREATE TABLE IF NOT EXISTS `venda` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valorTotal` float DEFAULT NULL,
  `musics_id` int(10) UNSIGNED NOT NULL,
  `profile_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`,`musics_id`,`profile_id`),
  KEY `fk_venda_musics1_idx` (`musics_id`),
  KEY `fk_venda_profile1_idx` (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `venda`
--

INSERT INTO `venda` (`id`, `data`, `valorTotal`, `musics_id`, `profile_id`) VALUES
(1, '2020-01-11 00:00:00', 32, 21, 36);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `fk_albums_genres1` FOREIGN KEY (`genres_id`) REFERENCES `genres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `musics`
--
ALTER TABLE `musics`
  ADD CONSTRAINT `fk_musics_albums1` FOREIGN KEY (`albums_id`) REFERENCES `albums` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_musics_genres1` FOREIGN KEY (`genres_id`) REFERENCES `genres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_musics_iva1` FOREIGN KEY (`iva_id`) REFERENCES `iva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_musics_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `playlists_has_musics`
--
ALTER TABLE `playlists_has_musics`
  ADD CONSTRAINT `fk_playlists_has_musics_musics1` FOREIGN KEY (`musics_id`) REFERENCES `musics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_playlists_has_musics_playlists1` FOREIGN KEY (`playlists_id`) REFERENCES `playlists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_profile_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `profile_has_albums`
--
ALTER TABLE `profile_has_albums`
  ADD CONSTRAINT `fk_profile_has_albums_albums1` FOREIGN KEY (`albums_id`) REFERENCES `albums` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_profile_has_albums_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `profile_has_playlists`
--
ALTER TABLE `profile_has_playlists`
  ADD CONSTRAINT `fk_profile_has_playlists_playlists1` FOREIGN KEY (`playlists_id`) REFERENCES `playlists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_profile_has_playlists_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
