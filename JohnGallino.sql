-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 04, 2019 at 01:25 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `johngallinodatabase`
--

-- create user to query product database -- 
-- GRANT SELECT, INSERT, DELETE, UPDATE ON heroku_2e5b70d76dac53f.*
-- TO b43a4cf801c624
-- IDENTIFIED BY 'ccb11452';

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `clientid` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `cum_nights` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`clientid`, `fname`, `lname`, `email`, `phone`, `cum_nights`) VALUES
(1, 'Tom', 'Jones', 'tomjones@gmail.com', '5556418891', 13),
(2, 'Travis', 'Hoffman', 'thoff55@yahoo.com', '3336451817', 3),
(3, 'Bernardine', 'Dohrn', 'bdohrn45@aol.com', '7023559391', 20),
(4, 'Maryanne', 'Pozzo', 'maryanne.pozzo@optonline.net', '3264417758', 6),
(5, 'Felipe', 'Gonzalez', 'felipethedog@gmail.com', '8652247865', 5),
(6, 'Heather', 'Myers', 'hemwhy@gmail.com', '4216874599', 12),
(7, 'Steve', 'Borden', 'stingersplash@yahoo.com', '6768812291', 18),
(8, 'Dominic', 'Ferrera', 'thedomferry@netscape.net', '4218889965', 3),
(10, 'BLOCK', 'BLOCK', 'BLOCK', 'BLOCK', 9999),
(13, 'John', 'Gallino', 'john@northwestphotovideo.com', '2016479161', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `resID` int(11) NOT NULL,
  `guest` int(11) NOT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `roomNum` tinyint(4) DEFAULT 7,
  `nights` int(11) GENERATED ALWAYS AS (to_days(`checkout`) - to_days(`checkin`)) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`resID`, `guest`, `checkin`, `checkout`, `roomNum`) VALUES
(1, 6, '2019-11-01', '2019-11-03', 7),
(2, 9, '2019-11-15', '2019-11-24', 9),
(3, 4, '2019-11-03', '2019-11-14', 7),
(4, 5, '2019-11-04', '2019-11-08', 2),
(5, 7, '2019-11-01', '2019-11-10', 3),
(6, 2, '2019-11-01', '2019-11-09', 5),
(7, 8, '2019-11-08', '2019-11-11', 12),
(8, 10, '2019-10-13', '2019-10-31', 7),
(9, 10, '2019-10-27', '2019-11-01', 9),
(11, 10, '2019-10-20', '2019-11-01', 15),
(19, 13, '2019-11-02', '2019-11-03', 4);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `roomNum` int(11) NOT NULL,
  `roomType` text NOT NULL,
  `beds` int(11) NOT NULL,
  `sleeps` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `photo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomNum`, `roomType`, `beds`, `sleeps`, `rate`, `photo`) VALUES
(1, 'Family Suite', 4, 5, 420, '/assets/photos/family4.jpg'),
(2, 'Family Suite', 3, 4, 365, '/assets/photos/family3.jpg'),
(3, 'Double Twin', 2, 2, 165, '/assets/photos/twins1.jpg'),
(4, 'Family Suite', 3, 4, 365, '/assets/photos/family1.jpg'),
(5, 'Family Suite', 3, 4, 365, '/assets/photos/family2.jpg'),
(6, 'Honeymoon Suite', 1, 2, 300, '/assets/photos/honeymoon1.jpg'),
(7, 'Honeymoon Suite', 1, 2, 300, '/assets/photos/honeymoon2.jpg'),
(8, 'Single Twin', 1, 1, 135, '/assets/photos/single.jpg'),
(9, 'Single Twin', 1, 1, 135, '/assets/photos/single.jpg'),
(10, 'Single Queen', 1, 2, 165, '/assets/photos/queen1.jpg'),
(11, 'Single Queen', 1, 2, 165, '/assets/photos/queen1.jpg'),
(12, 'Double Twin', 2, 2, 165, '/assets/photos/twins1.jpg'),
(14, 'Double Queen', 2, 4, 225, '/assets/photos/queens1.jpg'),
(15, 'Double Twin', 2, 2, 165, '/assets/photos/twins1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD UNIQUE KEY `clientid` (`clientid`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD UNIQUE KEY `resID` (`resID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomNum`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `clientid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `resID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
