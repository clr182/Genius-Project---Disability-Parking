-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2018 at 03:36 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gocar`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `user_ip` varchar(15) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comment_reports`
--

CREATE TABLE `comment_reports` (
  `crid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `user_ip` varchar(15) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `rid` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `pid` int(11) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spots`
--

CREATE TABLE `spots` (
  `pid` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spots`
--

INSERT INTO `spots` (`pid`, `address`, `latitude`, `longitude`, `image`, `time_created`) VALUES
(7, '11 Runebergsgatan, Jakobstad, Ostrobothnia.', 63.674919, 22.705948, 'images/1523605977.PNG', '2018-04-13 07:50:49'),
(9, '13 Isokatu, Jokobstad, Ostrobothnia.', 63.675720, 22.703964, 'images/1523606437.PNG', '2018-04-13 08:00:36'),
(10, '15 Isokatu, Jakostad, Ostrobothnia', 63.675961, 22.704563, 'images/1523606564.PNG', '2018-04-13 08:02:44'),
(11, '4 Visasmaki 68600 Pietarsaari', 63.676277, 22.702240, 'images/1523606749.PNG', '2018-04-13 08:05:48'),
(12, '14 Otto Malminkatu 68600 Pietarsaari', 63.674908, 22.701565, 'images/1523606923.PNG', '2018-04-13 08:08:43'),
(13, 'Raatihuoneenkatu 11 68600 Pietarsaari', 63.674702, 22.701752, 'images/1523607030.PNG', '2018-04-13 08:10:30'),
(14, 'RÃ¥dhusgatan 6, 68600 Jakobstad', 63.674301, 22.701069, 'images/1523607197.PNG', '2018-04-13 08:13:17'),
(15, 'Yogaways, RÃ¥dhusgatan 3, Jakobstad', 63.674747, 22.705366, 'images/1523607341.PNG', '2018-04-13 08:15:41'),
(16, 'Runeberginkatu 12 68600 Pietarsaari', 63.674965, 22.705521, 'images/1523607608.PNG', '2018-04-13 08:20:07'),
(17, 'Kauppiaankatu 19 68600 Pietarsaari', 63.674076, 22.699066, 'images/1523607741.PNG', '2018-04-13 08:22:20'),
(18, 'Raatihuoneenkatu 12 68600 Pietarsaari', 63.674400, 22.698074, 'images/1523608064.PNG', '2018-04-13 08:27:44'),
(19, 'Raatihuoneenkatu 10 68600 Pietarsaari', 63.674370, 22.696644, 'images/1523608197.PNG', '2018-04-13 08:29:56'),
(20, '13- 15 Storgatan, 68600 Jakobstad', 63.675571, 22.701853, 'images/1523608363.PNG', '2018-04-13 08:32:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `comment_reports`
--
ALTER TABLE `comment_reports`
  ADD PRIMARY KEY (`crid`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `spots`
--
ALTER TABLE `spots`
  ADD PRIMARY KEY (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_reports`
--
ALTER TABLE `comment_reports`
  MODIFY `crid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spots`
--
ALTER TABLE `spots`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `spots` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment_reports`
--
ALTER TABLE `comment_reports`
  ADD CONSTRAINT `comment_reports_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `comments` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `spots` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
