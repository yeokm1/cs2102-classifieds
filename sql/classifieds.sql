-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2014 at 06:15 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `classifieds`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(256) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `photo` varchar(32) DEFAULT NULL,
  `gender` varchar(16) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(16) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(32) NOT NULL,
  `title` text NOT NULL,
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(32) DEFAULT NULL,
  `cond` varchar(64) NOT NULL,
  `price` double NOT NULL,
  `date_listed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  FOREIGN KEY (`user`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tagged`
--

CREATE TABLE IF NOT EXISTS `tagged` (
  `item_id` int(11) NOT NULL,
  `cat_name` varchar(32) NOT NULL,
  PRIMARY KEY (`item_id`,`cat_name`),
  KEY `cat_name` (`cat_name`),
  FOREIGN KEY (`cat_name`) REFERENCES `category` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE IF NOT EXISTS `views` (
  `item_id` int(11) NOT NULL,
  `user_id` varchar(32) NOT NULL,
  `view_date` datetime NOT NULL, 
  PRIMARY KEY (`item_id`,`user_id`),
  FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Trigger to disallow space in username

DELIMITER ;
CREATE TRIGGER `username_no_space` 
BEFORE INSERT ON `user` FOR EACH ROW 
IF new.username NOT REGEXP '^[[:alnum:]]+$' THEN 
  SIGNAL SQLSTATE '12345' 
    SET MESSAGE_TEXT = 'No spaces allowed in username'; 
END IF


DELIMITER ;
CREATE TRIGGER `positive_price` 
BEFORE INSERT ON `item` FOR EACH ROW 
IF new.price < 0 THEN 
  SIGNAL SQLSTATE '12345' 
    SET MESSAGE_TEXT = 'Item price cannot be negative'; 
END IF

