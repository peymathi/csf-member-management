-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2019 at 01:39 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csfi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `GroupID` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(256) NOT NULL,
  PRIMARY KEY (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `life_groups`
--

CREATE TABLE IF NOT EXISTS `life_groups` (
  `LifeGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `LifeGroupName` varchar(256) NOT NULL,
  `LifeGroupDay` varchar(9) NOT NULL,
  `LifeGroupTime` time NOT NULL,
  `LifeGroupLocation` varchar(256) NOT NULL,
  `LifeGroupActive` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`LifeGroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `MemberID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(256) NOT NULL,
  `LastName` varchar(256) NOT NULL,
  `EmailAddress` varchar(256) DEFAULT NULL,
  `HomeAddress` varchar(512) DEFAULT NULL,
  `PhoneNumber` varchar(64) NOT NULL,
  `Major` varchar(255) DEFAULT 'NULL',
  `PhotoPath` varchar(256) DEFAULT NULL,
  `PrayerRequest` varchar(512) DEFAULT NULL,
  `OptEmail` tinyint(1) NOT NULL,
  `OptText` tinyint(1) NOT NULL,
  `GroupID` int(11) NOT NULL,
  PRIMARY KEY (`MemberID`),
  UNIQUE KEY `PhoneNumber` (`PhoneNumber`),
  KEY `GroupID` (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member_life_group_junction`
--

CREATE TABLE IF NOT EXISTS `member_life_group_junction` (
  `MemberLifeGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL,
  `LifeGroupID` int(11) NOT NULL,
  PRIMARY KEY (`MemberLifeGroupID`),
  KEY `LifeGroupID` (`LifeGroupID`),
  KEY `MemberID` (`MemberID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member_nights_of_worship_junction`
--

CREATE TABLE IF NOT EXISTS `member_nights_of_worship_junction` (
  `MemberNightID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL,
  `NightID` int(11) NOT NULL,
  PRIMARY KEY (`MemberNightID`),
  KEY `MemberID` (`MemberID`),
  KEY `NightID` (`NightID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nights_of_worship`
--

CREATE TABLE IF NOT EXISTS `nights_of_worship` (
  `NightID` int(11) NOT NULL AUTO_INCREMENT,
  `NightDate` date NOT NULL,
  PRIMARY KEY (`NightID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`GroupID`) REFERENCES `groups` (`GroupID`);

--
-- Constraints for table `member_life_group_junction`
--
ALTER TABLE `member_life_group_junction`
  ADD CONSTRAINT `member_life_group_junction_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `members` (`MemberID`),
  ADD CONSTRAINT `member_life_group_junction_ibfk_2` FOREIGN KEY (`LifeGroupID`) REFERENCES `life_groups` (`LifeGroupID`);

--
-- Constraints for table `member_nights_of_worship_junction`
--
ALTER TABLE `member_nights_of_worship_junction`
  ADD CONSTRAINT `member_nights_of_worship_junction_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `members` (`MemberID`),
  ADD CONSTRAINT `member_nights_of_worship_junction_ibfk_2` FOREIGN KEY (`NightID`) REFERENCES `nights_of_worship` (`NightID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
