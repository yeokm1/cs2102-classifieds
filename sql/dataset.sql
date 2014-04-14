-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2014 at 08:08 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `classifieds`
--

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`name`) VALUES
('Fruits'),
('Furniture'),
('Household'),
('Mobile Devices');

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `user`, `title`, `summary`, `description`, `photo`, `cond`, `price`, `date_listed`) VALUES
(1, 'john', 'Iphone 5s', 'Still rather new. Includes case.', 'Bought late last year.', '0.48137500 1396374490.jpg', 'Used but still good.', 599.99, '2014-03-08 14:16:06'),
(2, 'john', 'Samsung Galaxy S5', 'Won in contest! Get this before anyone else!', 'Unopened. Comes with full accessories pack like charger and cable.', '0.98114500 1396374468.jpg', 'New', 1000, '2014-03-08 14:18:35'),
(3, 'mary', 'D24 durian', 'Best in Malaysia and Singapore', 'One crate of durians. ', '0.49534400 1396374437.jpg', 'Uneaten', 20, '2014-03-08 14:20:03'),
(4, 'john', 'Ikea table', 'Glass table. 1 inch thick.', 'Comes in flat pack. Takes about 1 hour to assemble.', '0.51554500 1396374423.jpg', 'New', 100.4, '2014-03-08 14:22:01');

--
-- Dumping data for table `tagged`
--

INSERT INTO `tagged` (`item_id`, `cat_name`) VALUES
(3, 'Fruits'),
(4, 'Furniture'),
(4, 'Household'),
(1, 'Mobile Devices'),
(2, 'Mobile Devices');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `username`, `password`, `photo`, `gender`, `phone`, `join_date`, `role`) VALUES
('admin@admin.com', 'admin', 'admin', NULL, 'female', '1234567', '2014-03-15 14:13:55', 'admin'),
('david@david.com', 'david', 'david', NULL, 'male', '1245203', '2014-03-15 14:42:18', 'user'),
('user1@email1.com', 'john', 'john', '0.17411900 1396377493.jpg', 'male', '75319024', '2014-03-08 14:10:29', 'user'),
('mary@mary.com', 'mary', 'mary', NULL, 'female', '1902446', '2014-03-08 14:12:22', 'user'),
('peter@email2.com', 'peter', 'peter', NULL, 'male', '864202', '2014-03-08 14:11:44', 'user');

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`item_id`, `user_id`, `view_date`) VALUES
(1, 'admin', '2014-04-02 01:48:03'),
(1, 'john', '2014-04-02 02:33:08'),
(2, 'admin', '2014-04-02 01:47:25'),
(2, 'david', '2014-03-06 14:11:44'),
(2, 'john', '2014-04-04 01:50:57'),
(3, 'admin', '2014-04-02 01:47:10'),
(3, 'david', '2014-03-07 14:11:44'),
(4, 'admin', '2014-04-02 01:46:55'),
(4, 'mary', '2014-03-08 14:11:44');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
