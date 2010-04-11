-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2010 at 04:39 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE IF NOT EXISTS `card` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(10) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `expdate` varchar(7) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cardtype` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`cid`, `number`, `name`, `expdate`, `user_id`, `cardtype`) VALUES
(1, 123489, 'Nikhil', '04/2012', 1, 'Debit'),
(2, 12345, 'renu', '04/2012', 2, 'Debit'),
(3, 123456, 'bhani', '04/2012', 4, 'Debit'),
(4, 1234567, 'manish', '04/2012', 3, 'Debit');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(200) DEFAULT NULL,
  `rate` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item`, `rate`) VALUES
(1, 'Bathroom 1', 5),
(2, 'Bathroom 2', 10),
(12, 'Dinner', 14),
(9, 'Call INDIA', 20),
(7, 'Call USA', 10),
(10, 'Lunch', 8),
(13, 'Breakfast', 5);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(10) DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `dr` float DEFAULT NULL,
  `cr` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `number`, `body`, `date`, `dr`, `cr`) VALUES
(1, 123489, 'Paid By Bank', '2010-04-02', 1000, NULL),
(2, 12345, 'Paid By Bank', '2010-04-02', 500, NULL),
(3, 123456, 'Paid By Bank', '2010-04-02', 500, NULL),
(4, 1234567, 'Paid By Bank', '2010-04-02', 800, NULL),
(5, 123489, 'Paid By Bank', '2010-04-11', 1000, NULL),
(6, 12345, 'Paid By Bank', '2010-04-11', 1000, NULL),
(7, 123456, 'Paid By Bank', '2010-04-11', 1000, NULL),
(8, 1234567, 'Paid By Bank', '2010-04-11', 1000, NULL),
(9, 12345, 'Paid By Bank', '2010-04-11', 500, NULL),
(10, 123456, 'Paid By Bank', '2010-04-11', 500, NULL),
(11, 1234567, 'Paid By Bank', '2010-04-11', 200, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(16) DEFAULT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'member',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'Nikhil', '123489', 'admin'),
(2, 'Renu', '123', 'member'),
(3, 'Manish', 'password', 'member'),
(4, 'Bhani', '1234', 'member');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
