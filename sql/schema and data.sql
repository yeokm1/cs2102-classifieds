-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2014 at 09:21 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `classifieds`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`name`) VALUES
('Fruits'),
('Furniture'),
('Household'),
('Mobile Devices');

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
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `user`, `title`, `summary`, `description`, `photo`, `cond`, `price`, `date_listed`) VALUES
(1, 'john', 'Iphone 5s', 'Still rather new. Includes case.', 'Bought late last year.', NULL, 'Use but still good.', 599.99, '2014-03-08 14:16:06'),
(2, 'john', 'Samsung Galaxy S5', 'Won in contest! Get this before anyone else!', 'Unopened. Comes with full accessories pack like charger and cable.', NULL, 'New', 1000, '2014-03-08 14:18:35'),
(3, 'mary', 'D24 durian', 'Best in Malaysia and Singapore', 'One crate of durians. ', NULL, 'Uneaten', 20, '2014-03-08 14:20:03'),
(4, 'john', 'Ikea table', 'Glass table. 1 inch thick.', 'Comes in flat pack. Takes about 1 hour to assemble.', NULL, 'New', 100.4, '2014-03-08 14:22:01');

-- --------------------------------------------------------

--
-- Table structure for table `tagged`
--

CREATE TABLE IF NOT EXISTS `tagged` (
  `item_id` int(11) NOT NULL,
  `cat_name` varchar(32) NOT NULL,
  PRIMARY KEY (`item_id`,`cat_name`),
  KEY `cat_name` (`cat_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tagged`
--

INSERT INTO `tagged` (`item_id`, `cat_name`) VALUES
(3, 'Fruits'),
(4, 'Furniture'),
(4, 'Household'),
(1, 'Mobile Devices'),
(2, 'Mobile Devices');

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

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `username`, `password`, `photo`, `gender`, `phone`, `join_date`, `role`) VALUES
('admin@admin.com', 'admin', 'admin', NULL, 'female', '1234567', '2014-03-15 14:13:55', 'admin'),
('david@david.com', 'david', 'david', NULL, 'male', '1245203', '2014-03-15 14:42:18', 'user'),
('user1@email1.com', 'john', 'john', NULL, 'male', '75319024', '2014-03-08 14:10:29', 'user'),
('mary@mary.com', 'mary', 'mary', NULL, 'female', '1902446', '2014-03-08 14:12:22', 'user'),
('peter@email2.com', 'peter', 'peter', NULL, 'male', '864202', '2014-03-08 14:11:44', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE IF NOT EXISTS `views` (
  `item_id` int(11) NOT NULL,
  `user_id` varchar(32) NOT NULL,
  `view_date` datetime NOT NULL,
  PRIMARY KEY (`item_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`item_id`, `user_id`, `view_date`) VALUES
(2, 'david', '2014-03-08 14:11:44'),
(2, 'john', '2014-03-08 14:11:44'),
(4, 'mary', '2014-03-08 14:11:44');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tagged`
--
ALTER TABLE `tagged`
  ADD CONSTRAINT `tagged_ibfk_1` FOREIGN KEY (`cat_name`) REFERENCES `category` (`name`),
  ADD CONSTRAINT `tagged_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `views_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
