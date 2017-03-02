-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2017 at 04:41 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buynsell`
--
CREATE DATABASE IF NOT EXISTS `buynsell` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `buynsell`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `addItem`$$
CREATE PROCEDURE `addItem` (IN `creator_id` INT, IN `title` VARCHAR(128), IN `description` VARCHAR(4096))  READS SQL DATA
BEGIN
	INSERT INTO `items` (`id`, `creator_id`, `title`, `description`, `created_date`, `expiry_date`) VALUES (NULL, `creator_id`, `title`, `description` , NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY) );
	call getItem(LAST_INSERT_ID());
END$$

DROP PROCEDURE IF EXISTS `addUser`$$
CREATE PROCEDURE `addUser` (IN `email` VARCHAR(128), IN `first_name` VARCHAR(128), IN `last_name` VARCHAR(128), IN `password` CHAR(128))  READS SQL DATA
BEGIN
	INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`) VALUES (NULL, `email`, `first_name`, `last_name`, `password`);
	call getUser(LAST_INSERT_ID(),'');

END$$

DROP PROCEDURE IF EXISTS `getAvailableAds`$$
CREATE PROCEDURE `getAvailableAds` ()  READS SQL DATA
BEGIN
	
	select t.`id`,t.`creator_id`,t.`title`,t.`description`,t.`created_date`,t.`expiry_date` 
		from items t 
		where date(t.`expiry_date`) >= curdate() 
			and t.`id` not in (select si.`item_id` from solditems si)
			order by t.`created_date` desc;


END$$

DROP PROCEDURE IF EXISTS `getItem`$$
CREATE PROCEDURE `getItem` (IN `id` INT)  READS SQL DATA
BEGIN
	if id='' then set id=null;end if;
	
	select t.`id`,t.`creator_id`,t.`title`,t.`description`,t.`created_date`,t.`expiry_date` 
		from items t 
		where   (id is null or t.id = id);

END$$

DROP PROCEDURE IF EXISTS `getUser`$$
CREATE PROCEDURE `getUser` (IN `id` INT, IN `email` VARCHAR(128))  READS SQL DATA
BEGIN
	if id='' then set id=null;end if;
	if email='' then set email=null;end if;
	
	select u.id, u.email, u.`first_name`, u.`last_name`, u.password  
   from users u  
   where   (id is null or u.id = id)
  and (email is null or (LOWER(u.email) = LOWER(email)));

END$$

DROP PROCEDURE IF EXISTS `markItemAsSold`$$
CREATE PROCEDURE `markItemAsSold` (IN `item_id` INT, IN `user_id` INT)  READS SQL DATA
BEGIN
	INSERT INTO `solditems` (`id`, `item_id`, `user_id`, `sold_time`) VALUES (NULL, `item_id`, `user_id`, NOW());
	select 1 as "result";
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `creator_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_title_creator` (`title`,`creator_id`),
  KEY `fk_items_users` (`creator_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `solditems`
--

DROP TABLE IF EXISTS `solditems`;
CREATE TABLE IF NOT EXISTS `solditems` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `sold_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_items` (`item_id`,`user_id`),
  UNIQUE KEY `fk_sold_item` (`item_id`),
  KEY `fk_item_buyer` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `password` char(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_users` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `solditems`
--
ALTER TABLE `solditems`
  ADD CONSTRAINT `fk_item_buyer` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sold_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
