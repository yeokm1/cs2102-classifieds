-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2014 at 09:03 AM
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

--
-- Triggers `user`
--
DROP TRIGGER IF EXISTS `username_no_space`;
DELIMITER //
CREATE TRIGGER `username_no_space` BEFORE INSERT ON `user`
 FOR EACH ROW IF new.username NOT REGEXP '^[[:alnum:]]+$' THEN 
  SIGNAL SQLSTATE '12345' 
    SET MESSAGE_TEXT = 'check constraint on username with no space failed'; 
END IF
//
DELIMITER ;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
