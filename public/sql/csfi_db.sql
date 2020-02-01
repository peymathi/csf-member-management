-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2019 at 05:27 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

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

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'Andrew', 'Hodges', 'dooleytucker@gmail.com', '$2y$10$QGB/ncjN7Vz9Bw3wuX.I.e5EPSiFva3uTt/Wxng.7A4wbJanFEMlW');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

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

CREATE TABLE `life_groups` (
  `LifeGroupID` int(11) NOT NULL,
  `LifeGroupName` varchar(256) NOT NULL,
  `LifeGroupDay` varchar(9) NOT NULL,
  `LifeGroupTime` time NOT NULL,
  `LifeGroupLocation` varchar(256) NOT NULL,
  `LifeGroupActive` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `life_groups`
--

INSERT INTO `life_groups` (`LifeGroupID`, `LifeGroupName`, `LifeGroupDay`, `LifeGroupTime`, `LifeGroupLocation`, `LifeGroupActive`) VALUES
(1, 'test', 'Sunday', '09:10:00', 'avon', 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `MemberID` int(11) NOT NULL,
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
  `GroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`MemberID`, `FirstName`, `LastName`, `EmailAddress`, `HomeAddress`, `PhoneNumber`, `Major`, `PhotoPath`, `PrayerRequest`, `OptEmail`, `OptText`, `GroupID`) VALUES
(2, 'Tucker', 'Dooley', 'tucker.dooley1234@gmail.com', '635 green ridge dr.', '3173662930', NULL, '', 'food', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `member_life_group_junction`
--

CREATE TABLE `member_life_group_junction` (
  `MemberLifeGroupID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LifeGroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member_nights_of_worship_junction`
--

CREATE TABLE `member_nights_of_worship_junction` (
  `MemberNightID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `NightID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nights_of_worship`
--

CREATE TABLE `nights_of_worship` (
  `NightID` int(11) NOT NULL,
  `NightDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`MemberLifeGroupID`),
  ADD KEY `LifeGroupID` (`LifeGroupID`),
  ADD KEY `MemberID` (`MemberID`) USING BTREE;

--
-- Indexes for table `member_nights_of_worship_junction`
--
ALTER TABLE `member_nights_of_worship_junction`
  ADD PRIMARY KEY (`MemberNightID`),
  ADD KEY `MemberID` (`MemberID`),
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `life_groups`
--
ALTER TABLE `life_groups`
  MODIFY `LifeGroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `member_life_group_junction`
--
ALTER TABLE `member_life_group_junction`
  MODIFY `MemberLifeGroupID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_nights_of_worship_junction`
--
ALTER TABLE `member_nights_of_worship_junction`
  MODIFY `MemberNightID` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `member_nights_of_worship_junction`
--
ALTER TABLE `member_nights_of_worship_junction`
  ADD CONSTRAINT `member_nights_of_worship_junction_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `members` (`MemberID`),
  ADD CONSTRAINT `member_nights_of_worship_junction_ibfk_2` FOREIGN KEY (`NightID`) REFERENCES `nights_of_worship` (`NightID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
