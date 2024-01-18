-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 05, 2020 at 12:40 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nightingale`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `catID` int(11) NOT NULL AUTO_INCREMENT,
  `catName` varchar(100) NOT NULL,
  `descr` text,
  PRIMARY KEY (`catID`),
  UNIQUE KEY `category` (`catName`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catID`, `catName`, `descr`) VALUES
(1, 'Tablets', 'drug medicinal fills'),
(2, 'Capsules', 'filled powdered medicin'),
(3, 'Ampules', 'injectible drugs'),
(5, 'dggg', 'xzc sffs');

-- --------------------------------------------------------

--
-- Table structure for table `dispense`
--

DROP TABLE IF EXISTS `dispense`;
CREATE TABLE IF NOT EXISTS `dispense` (
  `patient` varchar(25) NOT NULL,
  `drug` varchar(25) NOT NULL,
  `prescrRef` int(11) NOT NULL,
  `qtyGiven` double NOT NULL,
  `dateofDisp` date NOT NULL,
  PRIMARY KEY (`patient`,`drug`,`prescrRef`,`dateofDisp`),
  KEY `drug` (`drug`),
  KEY `patient` (`patient`),
  KEY `prescrRef` (`prescrRef`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `drug`
--

DROP TABLE IF EXISTS `drug`;
CREATE TABLE IF NOT EXISTS `drug` (
  `drugID` varchar(25) NOT NULL,
  `drugName` varchar(100) NOT NULL,
  `drugCategory` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`drugID`),
  KEY `drugcategory` (`drugCategory`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drug`
--

INSERT INTO `drug` (`drugID`, `drugName`, `drugCategory`, `description`) VALUES
('1265568368', 'ibromefen', 2, 'pain soothing'),
('1814942043', 'Magnessium', 1, 'Stomachache relaxing tablex'),
('695520185', 'Quinine', 3, '750 ml b.p X 6 czp');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id` varchar(25) NOT NULL,
  `patientname` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `dob` date DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `patientname`, `gender`, `dob`, `mobile`, `address`) VALUES
('1938612713', 'kangabali robert', 'Male', '1978-06-16', '0750674534', 'kanyamakerre'),
('530711728', 'kabago mary', 'Female', '1990-12-03', '0774548902', 'rwengajju'),
('92420691', 'kabapalya Gorret', 'Female', '1976-04-23', '756298653', 'mukunyu, Kyenjojo');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

DROP TABLE IF EXISTS `pharmacy`;
CREATE TABLE IF NOT EXISTS `pharmacy` (
  `drug` varchar(25) NOT NULL,
  `stockqty` double NOT NULL,
  `stockedDate` date NOT NULL,
  `expiryDate` date NOT NULL,
  PRIMARY KEY (`drug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pharmacy`
--

INSERT INTO `pharmacy` (`drug`, `stockqty`, `stockedDate`, `expiryDate`) VALUES
('1265568368', 5, '2020-12-01', '2020-12-17'),
('1814942043', 30, '2020-12-01', '2020-12-23'),
('695520185', 0, '2020-12-01', '2020-12-23');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

DROP TABLE IF EXISTS `prescription`;
CREATE TABLE IF NOT EXISTS `prescription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient` varchar(25) NOT NULL,
  `dateofpres` date NOT NULL,
  `prescription` text NOT NULL,
  `patientsMedicalHist` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `patient`, `dateofpres`, `prescription`, `patientsMedicalHist`) VALUES
(1, '92420691', '2020-11-27', 'Magnesium', 'stomachache'),
(2, '1938612713', '2020-12-05', 'amoxyl 7/7, kamadol bp', 'inflamatory stomachache, evening fever, dry cough');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `descr` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userrole` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`, `descr`) VALUES
(1, 'Admin', 'Overall system user'),
(2, 'Doctor', 'prescribes to patients drugs'),
(3, 'Receptionist', 'Registers patients in the system'),
(4, 'Pharmacist', 'Dispenses drugs to patients');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female') CHARACTER SET utf8 NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `userrole` int(11) NOT NULL,
  `isActive` enum('1','0','') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `userrole` (`userrole`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `names`, `email`, `password`, `gender`, `mobile`, `image`, `userrole`, `isActive`) VALUES
(1, 'Murungi pius', 'murungipius@gmail.com', '$2y$10$iTJXEXHhd6homPByqDSH7uZcZOH/r.wXOGXvDkEwgkz18FzVFcrly', 'male', '785400404', NULL, 1, '1'),
(2, 'Kamanzi Micheal', 'kmicheal23@gmail.com', '$2y$10$QMvQ4MDNq7r7jWiW5v.UHutRFcwb3NRhZFTeXs8y7riPJqU3KPyFG', 'male', '750897623', NULL, 2, '1'),
(3, 'asiimwe shiidi', 'asiimweshiidi@gmail.com', '$2y$10$KPnyNE5PUZ6EhZhid31AlOs1B1GD9IYRiEwRXUaYxMUluEQjZdgpy', 'male', '0704202020', NULL, 3, '1'),
(4, 'ronald mutegeki', 'ronaldmutegeki@gmail.com', '$2y$10$dpwwR9Ix91Yzp0.AAkI/oesx/g/xZFovQo1p5wYk5jahKIoM0hgse', 'male', '0785000000', NULL, 4, '1'),
(5, 'pauleta mwiru', 'paulmwiru@gmail.com', '$2y$10$wcLThexXEiTSHQbnuJUZ.OxOMSwkXoCrtF8FTiYKYayT8apcHIEJe', 'male', '0753627382', NULL, 4, '1'),
(6, 'nakyanzi patra', 'nakyanzipatra@gmail.com', '$2y$10$h.WOOPvcNM7gAnWEdpA8xu8eF0TYCejwI/o93Sc0NPwo6lKPEn03O', 'male', '783897654', NULL, 2, '1'),
(7, 'gashumba frank', 'gashumbafrank@nightingale.com', '$2y$10$5KCEIzzrvphFPLI/DYti2O4RDgcasMlvudmklqEzcGBtYS3gs9kXe', 'male', '750657382', NULL, 3, '1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dispense`
--
ALTER TABLE `dispense`
  ADD CONSTRAINT `drug` FOREIGN KEY (`drug`) REFERENCES `drug` (`drugID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patient` FOREIGN KEY (`patient`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prescription` FOREIGN KEY (`prescrRef`) REFERENCES `prescription` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drug`
--
ALTER TABLE `drug`
  ADD CONSTRAINT `drugcategory` FOREIGN KEY (`drugCategory`) REFERENCES `category` (`catID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `userrole` FOREIGN KEY (`userrole`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
