-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2019 at 10:18 PM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hapus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'c93ccd78b2076528346216b3b2f701e6');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `Nip` varchar(150) DEFAULT NULL,
  `Nama` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Telephone` varchar(50) DEFAULT NULL,
  `Cabang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Nip`, `Nama`, `Email`, `Telephone`, `Cabang`) VALUES
('12345678', 'Fajar Subhan', 'fajarsubhan9b@gmail.com', '087887190963', 'Jakarta'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('Nip', 'Nama', 'Email', 'No Telephone', 'Cabang'),
('23131312', 'Harsana Dika', 'harsana@gmail.com', '087887190972', 'Kalimantan');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
