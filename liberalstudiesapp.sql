-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 04, 2013 at 04:49 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `liberalstudiesapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `advisors`
--

CREATE TABLE IF NOT EXISTS `advisors` (
  `AdvisorID` int(11) NOT NULL AUTO_INCREMENT,
  `Last Name` text NOT NULL,
  `First Name` text NOT NULL,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  PRIMARY KEY (`AdvisorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `advisors`
--

INSERT INTO `advisors` (`AdvisorID`, `Last Name`, `First Name`, `Username`, `Password`) VALUES
(1, 'Droniak', 'Jonathan', 'advisor', 'testing');

-- --------------------------------------------------------

--
-- Table structure for table `approvedmajors`
--

CREATE TABLE IF NOT EXISTS `approvedmajors` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` int(11) NOT NULL,
  `MajorName` text NOT NULL,
  `Minor1` text NOT NULL,
  `Minor2` text NOT NULL,
  `Minor3` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `approvedminors`
--

CREATE TABLE IF NOT EXISTS `approvedminors` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` int(11) NOT NULL,
  `Comments` text,
  `MinorName` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `sessiondata` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `Name` text NOT NULL,
  `MinorID` int(10) DEFAULT NULL,
  `ApprovedID` int(11) NOT NULL,
  `RejectedID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`Name`, `MinorID`, `ApprovedID`, `RejectedID`) VALUES
('abcde', 1, 0, NULL),
('abcde', 1, 0, NULL),
('abcde', 1, 0, NULL),
('abcde', 1, 0, NULL),
('abcde', 1, 0, NULL),
('abcde', 1, 0, NULL),
('abcde', 2, 0, NULL),
('abcde', 2, 0, NULL),
('abcde', 2, 0, NULL),
('abcde', 2, 0, NULL),
('abcde', 2, 0, NULL),
('abcde', 2, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currentusers`
--

CREATE TABLE IF NOT EXISTS `currentusers` (
  `StudentID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  `ApprovalLimitReached` tinyint(1) NOT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores all current users and their passwords' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `currentusers`
--

INSERT INTO `currentusers` (`StudentID`, `Username`, `Password`, `ApprovalLimitReached`) VALUES
(1, 'test', 'tester', 1),
(2, 'tester', 'testing', 1);

-- --------------------------------------------------------

--
-- Table structure for table `majorrequests`
--

CREATE TABLE IF NOT EXISTS `majorrequests` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` int(10) NOT NULL,
  `Minor1` text NOT NULL,
  `Minor2` text NOT NULL,
  `Minor3` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `minorrequests`
--

CREATE TABLE IF NOT EXISTS `minorrequests` (
  `StudentID` int(11) NOT NULL,
  `MinorID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`MinorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `minorrequests`
--

INSERT INTO `minorrequests` (`StudentID`, `MinorID`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `minors`
--

CREATE TABLE IF NOT EXISTS `minors` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `minors`
--

INSERT INTO `minors` (`ID`, `Name`) VALUES
(1, 'Accounting'),
(2, 'African Studies'),
(3, 'Anthropology'),
(4, 'Art History'),
(5, 'Asian Studies'),
(6, 'Biology'),
(7, 'Business Administration'),
(8, 'Central, East European, and Eurasian Studies'),
(9, 'Chemistry'),
(10, 'Communication'),
(11, 'Computer Science'),
(12, 'Criminal Justice'),
(13, 'Earth Science'),
(14, 'Economics'),
(15, 'English: Literature'),
(16, 'English: Creative Writing'),
(17, 'English: Professional Writing'),
(18, 'Environmental Studies'),
(19, 'Ethnic Studies'),
(20, 'Exercise Science'),
(21, 'Film Studies'),
(22, 'Forensic Science'),
(23, 'Geography'),
(24, 'German Studies'),
(25, 'History'),
(26, 'Instructional Technology'),
(27, 'Journalism'),
(28, 'Judaic Studies'),
(29, 'Latin American and Caribbean Studies'),
(30, 'Library Information Service'),
(31, 'Linguistics'),
(32, 'Management'),
(33, 'Management of Information Systems'),
(34, 'Marine Studies'),
(35, 'Marketing'),
(36, 'Mathematics'),
(37, 'Media Studies'),
(38, 'Music'),
(39, 'Philosophy'),
(40, 'Physics'),
(41, 'Political Science'),
(42, 'Psychology'),
(43, 'Public Health'),
(44, 'Public Health: Health and Society'),
(45, 'Public Health: Health Services Administration'),
(46, 'Public Health: Nutrition'),
(47, 'Public Health: Wellness'),
(48, 'Real Estate'),
(49, 'Religious Studies'),
(50, 'School Health Education'),
(51, 'Sociology'),
(52, 'Studio Art'),
(53, 'Theatre'),
(54, 'Urban Studies'),
(55, 'Women'),
(56, 'World Languages and Literatures');

-- --------------------------------------------------------

--
-- Table structure for table `prospects`
--

CREATE TABLE IF NOT EXISTS `prospects` (
  `Key` int(11) NOT NULL AUTO_INCREMENT,
  `Email` text NOT NULL,
  `Phone Number` text NOT NULL,
  PRIMARY KEY (`Key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores a list of all prospective students' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rejectedmajors`
--

CREATE TABLE IF NOT EXISTS `rejectedmajors` (
  `ID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `Minor1` text NOT NULL,
  `Minor2` text NOT NULL,
  `Minor3` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rejectedminors`
--

CREATE TABLE IF NOT EXISTS `rejectedminors` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` int(11) NOT NULL,
  `Comments` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `Name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
