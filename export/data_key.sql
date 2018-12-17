-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: 10.209.2.67
-- Generation Time: Nov 20, 2018 at 04:16 AM
-- Server version: 5.5.52
-- PHP Version: 5.3.10-1ubuntu3.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `159065-turakarna2`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_key`
--

CREATE TABLE IF NOT EXISTS `data_key` (
  `data_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `data_key` int(11) NOT NULL,
  `data_sort` int(11) DEFAULT NULL,
  `data_descr` char(10) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `text` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `data_key`
--

INSERT INTO `data_key` (`data_id`, `owner`, `data_key`, `data_sort`, `data_descr`, `user`, `text`) VALUES
(1, 1, 1, 4, 'TFL', NULL, NULL),
(2, 1, 2, 1, 'Tel', NULL, NULL),
(3, 1, 3, 2, 'Mobil', NULL, NULL),
(4, 1, 4, 3, 'Adress', NULL, NULL),
(5, 2, 5, 1, 'Tel', NULL, NULL),
(6, 2, 6, 2, 'Regnr', NULL, NULL),
(7, 2, 7, 3, 'Typ', NULL, NULL),
(8, 2, 8, 4, 'Försäkring', NULL, NULL),
(9, 0, 2, 1, 'Car', NULL, NULL),
(10, 0, 1, 2, 'User', NULL, NULL),
(11, 0, 100, 100, 'Shematider', NULL, 'a:7:{i:0;a:4:{s:11:"pass0_start";s:5:"03:00";s:10:"pass0_stop";s:5:"15:00";s:11:"pass1_start";s:5:"15:00";s:10:"pass1_stop";s:5:"03:00";}i:1;a:4:{s:11:"pass0_start";s:5:"03:00";s:10:"pass0_stop";s:5:"15:00";s:11:"pass1_start";s:5:"15:00";s:10:"pass1_stop";s:5:"03:00";}i:2;a:4:{s:11:"pass0_start";s:5:"03:00";s:10:"pass0_stop";s:5:"15:00";s:11:"pass1_start";s:5:"15:00";s:10:"pass1_stop";s:5:"03:00";}i:3;a:4:{s:11:"pass0_start";s:5:"03:00";s:10:"pass0_stop";s:5:"15:00";s:11:"pass1_start";s:5:"15:00";s:10:"pass1_stop";s:5:"03:00";}i:4;a:4:{s:11:"pass0_start";s:5:"03:00";s:10:"pass0_stop";s:5:"15:00";s:11:"pass1_start";s:5:"15:00";s:10:"pass1_stop";s:5:"03:00";}i:5;a:4:{s:11:"pass0_start";s:5:"03:00";s:10:"pass0_stop";s:5:"15:00";s:11:"pass1_start";s:5:"15:00";s:10:"pass1_stop";s:5:"03:00";}i:6;a:4:{s:11:"pass0_start";s:5:"03:00";s:10:"pass0_stop";s:5:"15:00";s:11:"pass1_start";s:5:"15:00";s:10:"pass1_stop";s:5:"03:00";}}'),
(12, 0, 3, 3, 'Roll', NULL, NULL),
(13, 3, 1, 0, 'Admin', NULL, NULL),
(14, 3, 10, 1, 'Ordinarie', NULL, NULL),
(15, 3, 20, 20, 'Extra', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
