-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2014 at 04:57 AM
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
-- Truncate table before insert `category`
--

TRUNCATE TABLE `category`;
--
-- Dumping data for table `category`
--

INSERT INTO `category` (`name`) VALUES
('Fruits'),
('Furniture'),
('Mobile Devices'),
('Property');

--
-- Truncate table before insert `item`
--

TRUNCATE TABLE `item`;
--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `title`, `summary`, `description`, `photo`, `cond`, `price`, `date_listed`) VALUES
(1, 'Selling a iPhone 5', 'iPhone 5', 'A BRAND NEW iPhone 5 from our favorite fruit company, Excellent condition (naturally =3=)\r\n\r\nGet this lovely black smartphone today! Cheapest in SG!', NULL, 'Brand new (mint)', 600, '2014-03-08 11:51:01'),
(2, 'WTS > Wooden Chair', 'A wooden chair', 'A really solid 3 legged chair made from high quality oak. TERMITE PROOF!\r\n\r\nRave reviews from our customers:\r\n\r\n"I sit on it and dun wanna get up!"\r\n\r\n"It''s a chair you fall for but can''t fall off"\r\n\r\n"It''s a chair"\r\n\r\nStock available in our warehouse,\r\nwill ship on demand\r\n\r\nBuy some for your home today!', NULL, 'Brand new', 150, '2014-03-08 11:53:50');

--
-- Truncate table before insert `posts`
--

TRUNCATE TABLE `posts`;
--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`user`, `item`) VALUES
('apple', 1),
('rambutan', 2);

--
-- Truncate table before insert `tagged`
--

TRUNCATE TABLE `tagged`;
--
-- Dumping data for table `tagged`
--

INSERT INTO `tagged` (`item_id`, `cat_name`) VALUES
(1, 'Mobile Devices'),
(2, 'Furniture');

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `username`, `password`, `photo`, `gender`, `phone`, `join_date`, `role`) VALUES
('admin@admin.com', 'admin', 'password', NULL, 'M', '4436584', '2014-03-08 11:46:38', 'admin'),
('apple@gmail.com', 'apple', 'apple', NULL, 'F', '77552211', '2014-03-08 11:41:45', 'user'),
('banana@gmail.com', 'banana', 'banana', NULL, 'M', '99125', '2014-03-08 11:41:18', 'user'),
('rambutan@gmail.com', 'rambutan', 'rambutan', NULL, 'M', '+65-5437783', '2014-03-08 11:42:24', 'user');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
