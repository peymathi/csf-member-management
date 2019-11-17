-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2019 at 08:37 PM
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
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `GroupID` int(11) NOT NULL,
  `GroupName` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`GroupID`, `GroupName`) VALUES
(1, 'Freshman'),
(2, 'Sophomore'),
(3, 'Junior'),
(4, 'Senior'),
(5, 'Graduate'),
(6, 'Alumni'),
(7, 'Staff'),
(8, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `life_groups`
--

DROP TABLE IF EXISTS `life_groups`;
CREATE TABLE `life_groups` (
  `LifeGroupID` int(11) NOT NULL,
  `LifeGroupName` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `MemberID` int(11) NOT NULL,
  `FirstName` varchar(256) NOT NULL,
  `LastName` varchar(256) NOT NULL,
  `EmailAddress` varchar(256) DEFAULT NULL,
  `HomeAddress` varchar(512) DEFAULT NULL,
  `PhoneNumber` varchar(64) NOT NULL,
  `PhotoPath` varchar(256) DEFAULT NULL,
  `PrayerRequest` varchar(512) DEFAULT NULL,
  `OptEmail` tinyint(1) NOT NULL,
  `OptText` tinyint(1) NOT NULL,
  `GroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member_life_group_junction`
--

DROP TABLE IF EXISTS `member_life_group_junction`;
CREATE TABLE `member_life_group_junction` (
  `MemberID` int(11) NOT NULL,
  `LifeGroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member_night_junction`
--

DROP TABLE IF EXISTS `member_night_junction`;
CREATE TABLE `member_night_junction` (
  `MemberID` int(11) NOT NULL,
  `NightID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nights_of_worship`
--

DROP TABLE IF EXISTS `nights_of_worship`;
CREATE TABLE `nights_of_worship` (
  `NightID` int(11) NOT NULL,
  `NightDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `life_groups`
--
ALTER TABLE `life_groups`
  ADD PRIMARY KEY (`LifeGroupID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`MemberID`),
  ADD UNIQUE KEY `PhoneNumber` (`PhoneNumber`),
  ADD KEY `GroupID` (`GroupID`);

--
-- Indexes for table `member_life_group_junction`
--
ALTER TABLE `member_life_group_junction`
  ADD PRIMARY KEY (`MemberID`,`LifeGroupID`),
  ADD KEY `LifeGroupID` (`LifeGroupID`);

--
-- Indexes for table `member_night_junction`
--
ALTER TABLE `member_night_junction`
  ADD PRIMARY KEY (`MemberID`,`NightID`),
  ADD KEY `NightID` (`NightID`);

--
-- Indexes for table `nights_of_worship`
--
ALTER TABLE `nights_of_worship`
  ADD PRIMARY KEY (`NightID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `life_groups`
--
ALTER TABLE `life_groups`
  MODIFY `LifeGroupID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nights_of_worship`
--
ALTER TABLE `nights_of_worship`
  MODIFY `NightID` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `member_night_junction`
--
ALTER TABLE `member_night_junction`
  ADD CONSTRAINT `member_night_junction_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `members` (`MemberID`),
  ADD CONSTRAINT `member_night_junction_ibfk_2` FOREIGN KEY (`NightID`) REFERENCES `nights_of_worship` (`NightID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
