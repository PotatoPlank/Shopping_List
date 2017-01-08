-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2017 at 06:52 PM
-- Server version: 5.6.34
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `currentlist`
--

CREATE TABLE IF NOT EXISTS `currentlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qty` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `aisle` text NOT NULL,
  `product_group` text NOT NULL,
  `add_by` text NOT NULL,
  `time_add` time NOT NULL,
  `date_add` date NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `denylist`
--

CREATE TABLE IF NOT EXISTS `denylist` (
  `id` int(11) NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `list_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf32 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `list_cart`
--

CREATE TABLE IF NOT EXISTS `list_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qty` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `aisle` text NOT NULL,
  `product_group` text NOT NULL,
  `add_by` text NOT NULL,
  `time_add` time NOT NULL,
  `date_add` date NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `list_details`
--

CREATE TABLE IF NOT EXISTS `list_details` (
  `row_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `aisle` text NOT NULL,
  `product_group` text NOT NULL,
  `add_by` text NOT NULL,
  `time_add` time NOT NULL,
  `date_add` date NOT NULL,
  PRIMARY KEY (`row_id`),
  UNIQUE KEY `row_id` (`row_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `usergroup` int(2) NOT NULL,
  `email` varchar(60) NOT NULL,
  `name` text,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
