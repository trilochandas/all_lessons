-- Adminer 4.2.0 MySQL dump

SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `xaver`;

DROP TABLE IF EXISTS `adverts`;
CREATE TABLE `adverts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `private` tinyint(2) NOT NULL,
  `seller_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `allow_mails` tinyint(1) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `city` varchar(30) NOT NULL,
  `metro` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` mediumint(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `citys`;
CREATE TABLE `citys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(50) NOT NULL,
  `city_index` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `citys` (`id`, `city`, `city_index`) VALUES
(1,	'Маяпур',	'108'),
(2,	'Пури',	'16000'),
(3,	'Вриндаван',	'64');

DROP TABLE IF EXISTS `select_meta`;
CREATE TABLE `select_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `label` varchar(20) NOT NULL,
  `options` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `select_meta` (`id`, `name`, `label`, `options`) VALUES
(1,	'city',	'Город',	'{\"\":\"Выберите город\",\"64\":\"Маяпур\", \"16108\":\"Пури\", \"108\":\"Вриндаван\"}'),
(2,	'metro',	'Метро',	'[\"Выберите станцию\",\"Deli-Aeropor\", \"Jabo\", \"Haribo\"]');

DROP TABLE IF EXISTS `undergrounds`;
CREATE TABLE `undergrounds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `underground` varchar(10) NOT NULL,
  `underground_index` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2015-03-10 13:10:35
