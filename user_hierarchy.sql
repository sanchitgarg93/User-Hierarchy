-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2017 at 06:05 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `user_hierarchy`
--

-- --------------------------------------------------------

--
-- Table structure for table `bas_user`
--

CREATE TABLE IF NOT EXISTS `bas_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bas_user`
--

INSERT INTO `bas_user` (`user_id`, `user_name`, `email`, `password`, `role`, `date_created`) VALUES
(1, 'A', 'a@gmail.com', '123', NULL, '2016-12-25 19:08:11'),
(2, 'B', 'b@gmail.com', '123', NULL, '2016-12-25 19:08:11'),
(3, 'C', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(4, 'D', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(5, 'E', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(6, 'F', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(7, 'G', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(8, 'H', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(9, 'Ivy', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(10, 'J', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(11, 'K', 'k@gmail.com', '123', NULL, '2016-12-25 19:08:11'),
(12, 'L', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(15, 'Vu', NULL, NULL, NULL, '2016-12-25 19:08:11'),
(16, 'admin', 'admin@gmail.com', 'admin', 'admin', '2016-12-25 19:40:14');

-- --------------------------------------------------------

--
-- Table structure for table `reporting`
--

CREATE TABLE IF NOT EXISTS `reporting` (
  `reporting_id` int(11) NOT NULL,
  `superior_id` int(11) DEFAULT NULL,
  `subordinate_id` int(11) DEFAULT NULL,
  `distance` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reporting`
--

INSERT INTO `reporting` (`reporting_id`, `superior_id`, `subordinate_id`, `distance`) VALUES
(29, 1, 1, 0),
(30, 2, 2, 0),
(31, 3, 3, 0),
(32, 4, 4, 0),
(33, 5, 5, 0),
(34, 6, 6, 0),
(35, 7, 7, 0),
(36, 8, 8, 0),
(37, 9, 9, 0),
(38, 10, 10, 0),
(39, 1, 2, 1),
(41, 2, 4, 1),
(42, 2, 5, 1),
(45, 3, 10, 1),
(46, 6, 7, 1),
(47, 6, 8, 1),
(48, 1, 4, 2),
(49, 1, 5, 2),
(50, 1, 6, 1),
(51, 2, 7, 1),
(52, 2, 8, 1),
(53, 1, 7, 2),
(54, 1, 8, 2),
(55, 1, 9, 2),
(56, 1, 10, 2),
(92, 11, 11, 0),
(93, 12, 12, 0),
(96, 11, 1, 1),
(97, 11, 2, 1),
(98, 11, 3, 2),
(99, 11, 4, 3),
(100, 11, 5, 3),
(101, 11, 6, 2),
(102, 11, 7, 3),
(103, 11, 8, 3),
(104, 11, 9, 3),
(105, 11, 10, 3),
(111, 1, 3, 1),
(113, 3, 9, 1),
(115, 1, 12, 2),
(116, 11, 12, 3),
(117, 3, 12, 1),
(120, 15, 15, 0),
(122, 1, 15, 2),
(123, 11, 15, 3),
(124, 3, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `picture` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_provider`, `oauth_uid`, `fname`, `lname`, `email`, `gender`, `locale`, `picture`, `created`, `modified`) VALUES
(1, 'facebook', '1447993088551020', 'Sanchit', 'Garg', 'sanchitgarg2012@gmail.com', 'male', 'en_US', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p50x50/12670204_1251562034860794_620767328904884887_n.jpg?oh=a3daa31a236be7d4adcc360877cebe64&oe=58E855FB', '2016-10-07 21:56:20', '2017-01-01 17:58:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bas_user`
--
ALTER TABLE `bas_user`
  ADD PRIMARY KEY (`user_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reporting`
--
ALTER TABLE `reporting`
  ADD PRIMARY KEY (`reporting_id`), ADD KEY `superior_id` (`superior_id`), ADD KEY `subordinate_id` (`subordinate_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bas_user`
--
ALTER TABLE `bas_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `reporting`
--
ALTER TABLE `reporting`
  MODIFY `reporting_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `reporting`
--
ALTER TABLE `reporting`
ADD CONSTRAINT `reporting_ibfk_1` FOREIGN KEY (`superior_id`) REFERENCES `bas_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `reporting_ibfk_2` FOREIGN KEY (`subordinate_id`) REFERENCES `bas_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
