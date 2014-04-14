-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2014 at 05:39 PM
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
('Electronics'),
('Fashion'),
('Fruits'),
('Furniture'),
('Household'),
('Toys');

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `user`, `title`, `summary`, `description`, `photo`, `cond`, `price`, `date_listed`) VALUES
(1, 'john', 'Iphone 5s', 'Still rather new. Includes case.', 'Bought late last year.', '0.48137500 1396374490.jpg', 'Used but still good.', 599.99, '2014-03-08 14:16:06'),
(2, 'john', 'Samsung Galaxy S5', 'Won in contest! Get this before anyone else!', 'Unopened. Comes with full accessories pack like charger and cable.', '0.98114500 1396374468.jpg', 'New', 1000, '2014-03-08 14:18:35'),
(3, 'mary', 'D24 durian', 'Best in Malaysia and Singapore', 'One crate of durians. ', '0.49534400 1396374437.jpg', 'Uneaten', 20, '2014-03-08 14:20:03'),
(4, 'john', 'Ikea table', 'Glass table. 1 inch thick.', 'Comes in flat pack. Takes about 1 hour to assemble.', '0.51554500 1396374423.jpg', 'New', 100.4, '2014-03-08 14:22:01'),
(5, 'bomberman', 'Barbie doll', 'Design & Dress Studio', 'Bought for daugther but realised that she is scared of dolls!', '0.44801200 1397489096.jpg', 'New, unopened', 20, '2014-03-10 18:21:20'),
(6, 'bomberman', 'Barbie doll', 'Barbie Glam Pool & Doll', 'Bought for daugther but realised that she is scared of dolls!', '0.90783900 1397489110.jpg', 'New, unopened', 20, '2014-03-10 18:26:00'),
(7, 'john', 'Apple iPod Nano', 'Apple iPod Nano 6th Generation', '90 DAY AppleCare Warranty Included + Free USB Cable + Delivery', '0.06595300 1397488938.jpg', 'New!', 80, '2014-03-27 15:02:32'),
(8, 'mary', 'Thai Honey Pineapples', 'Fresh from thailand', 'Reduce blood clotting, Improve blood circulation - Free Delivery', '0.07746700 1397489454.jpg', 'Fresh', 2.5, '2014-04-01 10:02:32'),
(9, 'mary', 'Assorted Fruit Hamper', 'perfect for any occasion!', 'apples, pear, mango, dragonfruit. Contact me for fruit selections.', '0.76722400 1397489519.jpg', 'Fresh', 20, '2014-04-01 10:13:32'),
(10, 'john', 'Momex Piggy Bluetooth Speaker', 'pink and blue available!', 'shipping of $1 applies', '0.07775400 1397488952.jpg', 'New', 49, '2014-04-02 19:01:10'),
(11, 'john', 'Samsung Galaxy Note 3 Extra Battery Charging Kit ', '3200mAh battery included!', '100 sets available + Free delievery for orders of  more than 5', '0.52540900 1397488963.jpg', 'New', 50, '2014-04-02 20:10:20'),
(12, 'john', 'Pocket Photo Bluetooth Printer', '(Pink) Brand New + 3 Year Warranty', 'Only 20 sets available + Free delievery ', '0.52072400 1397488986.jpg', 'New', 450, '2014-04-02 20:22:18'),
(13, 'bomberman', 'Monopoly SG Version with Merlion Token', 'For ages 8 and above', '10 sets available ', '0.58250600 1397489122.jpg', 'NEW', 46.9, '2014-04-06 09:18:20'),
(14, 'bomberman', 'rubiks 4x4', 'For ages 8 and above', '100 sets - half price ', '0.99010200 1397489132.jpg', 'NEW', 11.1, '2014-04-06 09:22:00'),
(15, 'bomberman', 'Hot Wheels - super Loop Launcher', 'For ages 4 and above', '5 sets only!', '0.82812200 1397489150.jpg', 'NEW', 29.95, '2014-04-06 10:03:01'),
(16, 'john', 'HP Deskjet 3070 B6611 Series', '3-in one wireless print, scan, photocopy', 'Printer Catridges & software included!', '0.67224900 1397489030.jpg', 'NEW', 150, '2014-04-08 20:31:10'),
(17, 'kacak', 'Swiss Quartz Watch', 'Movado Olympian Mens Two Tone Swiss Quartz Watch', 'Payment by Bank transfer only', '0.92219600 1397489361.jpg', '-', 495, '2014-04-12 12:13:14'),
(18, 'kacak', 'Stone Pendant', 'Vintage Sterling Silver Citrine Color Cz Stone Pendant', 'Payment by Bank transfer only', '0.24278600 1397489372.jpg', '-', 10, '2014-04-12 12:33:14'),
(19, 'john', 'iRulu Tablet PC 7', 'Multi-Color iRulu Tablet PC 7 Dual Camera Android 4.2 1.2Ghz Bundle Keyboard', 'Grade A+ Quality! Google Play APP!! NO.1 Tablet Seller!, 5 colours for selection - see image', '0.12219000 1397489047.jpg', 'NEW', 50, '2014-04-11 10:20:30'),
(20, 'john', 'Kinston Micro Pen Drive', 'Kingston - 64GB USB 2.0 64G DataTraveler DTMK Micro Flash Pen Drive DTMCK/64GB', 'More than 10 available', '0.46589600 1397489059.jpg', 'NEW', 40, '2014-04-11 10:38:10');

--
-- Dumping data for table `tagged`
--

INSERT INTO `tagged` (`item_id`, `cat_name`) VALUES
(1, 'Electronics'),
(2, 'Electronics'),
(7, 'Electronics'),
(10, 'Electronics'),
(11, 'Electronics'),
(12, 'Electronics'),
(16, 'Electronics'),
(19, 'Electronics'),
(20, 'Electronics'),
(17, 'Fashion'),
(18, 'Fashion'),
(3, 'Fruits'),
(8, 'Fruits'),
(9, 'Fruits'),
(4, 'Furniture'),
(4, 'Household'),
(5, 'Toys'),
(6, 'Toys'),
(13, 'Toys'),
(14, 'Toys'),
(15, 'Toys');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `username`, `password`, `photo`, `gender`, `phone`, `join_date`, `role`) VALUES
('admin@admin.com', 'admin', 'admin', NULL, 'female', '91285697', '2014-03-15 14:13:55', 'admin'),
('bomberman@live.com', 'bomberman', 'bomberman', '0.65417100 1397489186.jpg', 'male', '92644154', '2014-03-10 11:17:22', 'user'),
('david@david.com', 'david', 'david', NULL, 'male', '91546759', '2014-03-15 14:42:18', 'user'),
('user1@email1.com', 'john', 'john', '0.17411900 1396377493.jpg', 'male', '89394427', '2014-03-08 14:10:29', 'user'),
('kaaka@geehail.com', 'kacak', 'kacak', '0.75141900 1397489435.jpg', 'male', '94341212', '2014-05-01 14:12:44', 'user'),
('mary@mary.com', 'mary', 'mary', NULL, 'female', '65782910', '2014-03-08 14:12:22', 'user'),
('peter@email2.com', 'peter', 'peter', NULL, 'male', '62930610', '2014-03-08 14:11:44', 'user');

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
(3, 'mary', '2014-04-14 23:32:10'),
(4, 'admin', '2014-04-02 01:46:55'),
(4, 'kacak', '2014-04-14 23:29:53'),
(4, 'mary', '2014-03-08 14:11:44'),
(5, 'bomberman', '2014-04-14 23:24:48'),
(6, 'bomberman', '2014-04-14 23:25:03'),
(7, 'john', '2014-04-04 23:22:01'),
(8, 'mary', '2014-04-01 23:30:46'),
(9, 'kacak', '2014-04-03 23:29:50'),
(9, 'mary', '2014-04-02 23:31:51'),
(10, 'john', '2014-04-12 23:22:24'),
(10, 'kacak', '2014-04-01 23:29:48'),
(11, 'john', '2014-04-02 23:22:36'),
(11, 'mary', '2014-04-01 23:32:08'),
(12, 'john', '2014-03-29 23:22:52'),
(13, 'bomberman', '2014-03-18 23:32:42'),
(13, 'kacak', '2014-04-10 23:29:46'),
(13, 'mary', '2014-04-12 23:32:21'),
(14, 'bomberman', '2014-04-01 23:25:27'),
(15, 'bomberman', '2014-04-01 23:25:43'),
(16, 'john', '2014-04-14 23:23:09'),
(17, 'kacak', '2014-04-14 23:29:07'),
(17, 'mary', '2014-04-14 23:32:18'),
(18, 'kacak', '2014-04-14 23:29:24'),
(18, 'mary', '2014-04-14 23:32:16'),
(19, 'john', '2014-04-14 23:23:56'),
(19, 'kacak', '2014-04-14 23:29:44'),
(20, 'john', '2014-04-14 23:24:11'),
(20, 'mary', '2014-04-14 23:32:05');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
