-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 29, 2017 at 08:58 PM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 5.6.30-7+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tbxpos`
--
-- DROP DATABASE `pos_production`;
CREATE DATABASE IF NOT EXISTS `pos_production` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pos_production`;

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

DROP TABLE IF EXISTS `keys`;
CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `token`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, '3acf5c7b740d6e2538f3a7b88cf069b3', 1, 0, 0, NULL, '2017-02-05 00:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `md_bom`
--

DROP TABLE IF EXISTS `md_bom`;
CREATE TABLE `md_bom` (
  `BoMID` int(11) NOT NULL,
  `BoMBarCode` varchar(15) NOT NULL,
  `BoMName` varchar(30) NOT NULL,
  `BoMCost` decimal(18,2) NOT NULL,
  `BoMSRP` decimal(18,2) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_branches`
--

DROP TABLE IF EXISTS `md_branches`;
CREATE TABLE `md_branches` (
  `BranchID` int(11) NOT NULL,
  `BranchCode` varchar(15) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `BranchEmail` varchar(50) NOT NULL,
  `Type` int(11) NOT NULL DEFAULT '1',
  `Category` int(11) NOT NULL DEFAULT '1',
  `Groups` int(11) NOT NULL DEFAULT '1',
  `Channel` int(11) NOT NULL,
  `City` int(11) NOT NULL,
  `Address` varchar(150) NOT NULL,
  `BranchSize` decimal(18,2) NOT NULL DEFAULT '0.00',
  `Expiry` date NOT NULL,
  `Manager` int(11) NOT NULL,
  `IsTaxInclude` tinyint(1) NOT NULL DEFAULT '1',
  `SalesTax` int(11) NOT NULL DEFAULT '12',
  `DefaultReturnPolicy` int(11) NOT NULL DEFAULT '7',
  `IsBackdateAllowed` tinyint(1) NOT NULL DEFAULT '0',
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `Avatar` varchar(20) NOT NULL DEFAULT 'tbx.png',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_branches`
--

INSERT INTO `md_branches` (`BranchID`, `BranchCode`, `Description`, `BranchEmail`, `Type`, `Category`, `Groups`, `Channel`, `City`, `Address`, `BranchSize`, `Expiry`, `Manager`, `IsTaxInclude`, `SalesTax`, `DefaultReturnPolicy`, `IsBackdateAllowed`, `IsActive`, `Avatar`, `CreateDate`, `UpdateDate`) VALUES
(1, 'MAIN', 'HEAD OFFICE', '1', 2, 1, 2, 2, 768, 'BLDG. 2291 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-03-27 23:15:30'),
(2, '4M04', 'ALPHALAND SOUTHGATE', '2', 2, 1, 4, 2, 768, '3F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-03-27 23:14:35'),
(3, '4M14', 'GATEWAY CUBAO', '3', 2, 2, 4, 2, 1059, 'No. 00106K Level 1 Gateway Mall Araneta Ave. Cubao', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-03-27 23:14:28'),
(4, '4M15', 'HARRISON PLAZA', '4', 2, 2, 4, 2, 805, '2ND FLOOR EAST PATIO HARIZON PLAZA MABINI ST. CORNER ADRIATICO ST. BARANGAY 720 ZONE 078 MALATE MANILA', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(5, '4M13', 'RIVERBANKS CENTER', '5', 2, 1, 5, 2, 828, 'Besides Chowking', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(6, '4M18', 'ROBINSONS OTIS', '6', 2, 2, 3, 2, 805, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(7, '4L12', 'SM CITY NOVALICHES', '7', 2, 2, 5, 2, 1059, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(8, '4L03', 'SM CITY PAMPANGA', '8', 2, 2, 4, 1, 1118, 'L102A-B Cyberzone SM City Pampanga San Jose City of San Fernando', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(9, '4L01', 'SM CITY STA MESA', '9', 2, 2, 4, 2, 1059, '3F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(10, '4L02', 'SM CITY STA ROSA', '10', 2, 2, 4, 7, 1182, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 1, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-03-28 07:21:02'),
(11, '4M17', 'STA LUCIA EAST', '11', 2, 2, 4, 2, 275, 'LG', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(12, '4L04', 'STARMALL SJDM', '12', 2, 2, 4, 1, 1132, 'GF', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(13, '4L11', 'STARMALL SHAW', '13', 2, 2, 5, 2, 799, 'GF', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(14, '4M11', 'TUTUBAN CENTER MALL', '14', 2, 1, 5, 2, 805, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(15, '4M16', 'VICTORY MALL - CALOOCAN', '15', 2, 2, 5, 2, 294, '3F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(16, '4M19', 'VICTORY MALL - PASAY', '16', 2, 2, 5, 2, 991, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(17, 'SMPL', 'TRAINING STORE', '17', 2, 2, 5, 2, 768, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(18, '4L13', 'SM CITY MUNTINLUPA', '18', 2, 2, 3, 2, 886, '2F SM Supercenter', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(19, '4M20', 'ROBINSONS DASMARINAS', '19', 2, 2, 3, 7, 384, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(20, 'EXHIBIT01', 'SM CITY OLONGAPO', '20', 2, 2, 1, 6, 926, '3F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(21, '4L14', 'SM CITY BALIWAG', '21', 2, 2, 1, 1, 130, 'GF', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(22, '4L16', 'NORTHSTAR MALL ILAGAN', '22', 2, 2, 1, 6, 531, 'GF', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(23, '4M21', 'ROBINSONS FORUM', '23', 2, 1, 3, 2, 799, 'UG level Robinsons Forum Boni cor. Pioneer  sts. Mandaluyong City', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(24, '4L17', 'MAGIC MALL URDANETA', '24', 2, 2, 1, 6, 1386, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-03-27 23:15:55'),
(25, '4L18', 'NEPO MALL DAGUPAN', '25', 2, 2, 1, 6, 373, '3F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(26, '4L19', 'STERN MALL CANDON', '26', 2, 2, 1, 6, 307, 'GF', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(27, 'MAIN2', 'HEAD OFFICE 2', '27', 2, 2, 2, 2, 768, 'BLDG. 2291 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(28, 'BLTZ01', 'CHANNEL SALES', '28', 2, 2, 2, 2, 768, 'BLDG. 2291 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(29, '4M22', 'SAVEMORE TANAY', '29', 2, 1, 3, 2, 1311, 'GF', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(30, '4L20', 'ROBINSONS LAOAG', '30', 2, 2, 1, 6, 646, 'GF', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(31, 'OS01', 'STORE 0', '31', 1, 1, 2, 2, 768, 'BLDG. 2291 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(32, '4L21', 'XENTRO MALL SANTIAGO', '32', 2, 2, 1, 6, 1185, 'GF', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(33, '4L22', 'MALL OF THE VALLEY', '33', 2, 2, 1, 6, 1371, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(34, '4M23', 'PACIFIC MALL LUCENA', '34', 2, 1, 1, 7, 712, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(35, '4M24', 'PAVILLION MALL', '35', 2, 2, 1, 7, 200, '2F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(36, '4L23', 'SM CITY TARLAC', '36', 2, 2, 1, 1, 1325, 'SM TARLAC MACARTHUR HIGHWAY BRGY. SAN ROQUE', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(37, '4L24', 'XENTRO MALL CALAPAN', '37', 2, 1, 1, 7, 282, 'SECOND floor CS 6 AREA', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(38, 'TS01', 'TECHBOX MEGA SALE', '38', 2, 2, 2, 2, 768, 'BLDG. 2299 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(39, '4M27', 'BAGUIO CENTERMALL', '39', 2, 1, 1, 1, 104, '3rd FLOOR ABANAO SQUARE ', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-03-27 23:15:01'),
(40, '4M28', 'E MALL NAGA ', '40', 2, 2, 1, 7, 893, '2ND FLOOR  KIOSK 7 ', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(41, '4M29', 'GAISANO MALL SAN JOSE', '41', 2, 1, 1, 7, 1129, 'GROUND FLOOR ', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-03-27 23:15:10'),
(42, '4N01', 'NOKIA - STERN MALL COMPLEX', '42', 2, 2, 1, 6, 307, 'GROUND FLOOR ', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(43, '4N02', 'NOKIA - ROBINSON LAOAG', '43', 2, 2, 1, 6, 1148, 'GROUND FLOOR ', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(44, '4L25', 'SM LIGHT MALL', '44', 1, 2, 4, 2, 799, 'SM LITE EDSA cor. Madison St. BRGY. Barangka Ilaya', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(45, 'TS02', 'NOKIA CLEARANCE SALE', '45', 2, 2, 2, 2, 768, 'BLDG. 2299 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(46, '4L26', 'LEE PLAZA MALL DIPOLOG', '46', 2, 2, 1, 9, 420, '2ND FLOOR LEE PLAZA MALL. DIPOLOG CITY', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(47, '4L27', 'WALTERMART GAPAN', '47', 2, 2, 1, 1, 463, '2nd Floor', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(48, 'LEN01', 'LENOVO WAREHOUSE', '48', 2, 2, 2, 2, 768, 'BLDG. 2299 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(49, '4L29', 'SM CITY SAN MATEO', '49', 1, 2, 4, 2, 1145, '2ND FLOOR', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(50, 'TS03', 'TECHBOX MEGA SALE 2', '50', 2, 2, 2, 2, 768, 'BLDG. 2299 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(51, '4L28', 'ROBINSONS BUTUAN', '51', 1, 2, 1, 4, 254, '3RD FLOOR', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(52, 'TS04', 'LAZADA', '52', 2, 2, 2, 2, 768, 'BLDG. 2299 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(53, '4L30', 'GAISANO SURIGAO', '53', 2, 2, 1, 4, 1266, '2nd floor Gaisano Capital Surigao', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(54, '4M31', 'TEQUBE ARCADIA', '54', 1, 1, 4, 7, 1182, 'Greenfields Corporate Ctr. Paseo Sta Rosa Laguna', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(55, '4M16-2', 'VICTORY MALL CALOOCAN', '55', 2, 1, 5, 2, 294, '3F', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(56, '4L31', 'SM SEASIDE CEBU', '56', 1, 2, 1, 8, 343, '3F Cyberzone', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(57, 'TS05', 'TECHBOX - LAZADA ONLINE', '57', 2, 2, 2, 2, 768, 'BLDG. 2299 DON CHINO ROCES AVE. EXT.', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(58, '5Z0L4A', 'ISETTAN CINERAMA COMPLEX', '58', 2, 2, 2, 3, 805, '3rd Flr  Isetann Cinerama Complex CM Recto Ave Brgy 308 zone 30 Quiapo Manila', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(59, '5Z0L70', 'ROBINSONS PLACE LAS PINAS', '59', 1, 2, 2, 3, 654, '2F Robinsons Place Las Pinas', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(60, '5Z0W62', 'AYALA HARBOR POINT SUBIC', '60', 1, 1, 2, 6, 926, '2F Space 2074', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-03-27 23:14:46'),
(61, '8KC015', 'KC12- RIVERBANKS', '62', 2, 1, 2, 2, 828, 'Riverbanks Mall Bonifacio Ave Barangka Marikina ', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(62, '8KC003', 'STARMALL ALABANG', '63', 2, 1, 2, 2, 886, '3F Metropolis Alabang South Superhighway', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(63, '8KC007', '168 MALL', '64', 2, 1, 2, 3, 805, '168 Shopping Mall Binondo Manila', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(64, '8KC012', 'KC513- PUREGOLD TANZA CAVITE', '66', 1, 1, 2, 2, 341, 'Puregold Daang Amaya', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(65, '5Z0W8', 'SM CITY FAIRVIEW', '69', 1, 1, 2, 3, 1059, '3F SM CITY FAIRVIEW CYBERZONE 32 QUIRINO HIGHWAY COR. REGALADO AVENUE', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(66, '5WE404', 'MARKET MARKET', '71', 2, 1, 2, 3, 1292, '4F Market Market Shopping Mall', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(67, '5Z0L69', 'ROBINSONS ANTIPOLO', '72', 1, 2, 2, 2, 63, 'GF Robinons Place Sumulong Highway cor Circumferencial RD ', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(68, '5Z0W65', 'SM BF PARANAQUE', '74', 1, 1, 2, 2, 987, '3F SM City BF Dr A Santos Ave Bgy BF Homes Paranaque City', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(69, '7KP005', 'SM CITY SAN LAZARO', '75', 1, 1, 2, 3, 805, '3F SM San Lazaro Felix Huertas A.H Lacson St. Sta Cruz Manila', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(70, '7KP007', 'SM CITY DASMARINAS', '76', 1, 1, 2, 2, 341, '2F SM City Dasmarinas', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(71, '7KP004', 'SM CITY SOUTHMALL', '77', 1, 1, 2, 2, 654, '2F West Wing Cyberzone Area Alabang-Zapote', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(72, 'MAIN3', 'OPEN COMMUNICATIONS - WAREHOUSE', '78', 1, 1, 2, 3, 992, 'Ugong Pasig City', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(73, '5Z0W45', 'SM CITY BICUTAN', '80', 1, 1, 2, 2, 987, '2F SM Bicutan Dona Soledad Avenue Paranaque', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(74, '5Z0W47', 'SM CITY SUCAT', '81', 1, 1, 2, 2, 987, '3F SM Supercenter Sucat Dr. A. Santos Ave. San Dionisio', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(75, '5Z0W63', 'GLORIETTA', '82', 1, 1, 2, 3, 768, '3F 3-048 Clorietta 2', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-03-27 23:15:15'),
(76, '5Z0WC29', 'SM CITY NORTH EDSA', '83', 1, 1, 2, 3, 1059, '4F SM City North Edsa', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(77, '5Z0W67', 'ROBINSONS TOWN MALL MALABON', '85', 1, 1, 2, 2, 772, '2F Robinson Town Mall ', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(78, '5Z0W64', 'ROBINSONS ROXAS', '86', 1, 1, 2, 8, 1081, '3F Robinson Place Sumapang Matanda Mac Arthur Highway Malolos city Bulacan', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(79, '7KP011', 'ROBINSONS MALOLOS', '87', 1, 1, 2, 5, 787, '3F Robinson Place Sumapang Matanda Mac Arthur Highway Malolos city Bulacan', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(80, '5Z0W16', 'SM CITY CEBU ', '88', 1, 1, 2, 8, 343, '2F SM City Cebu Bldg. C. North Reclamation Area Cebu City', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(81, '5Z0W25', 'SM CITY ILOILO', '89', 1, 1, 2, 8, 534, '3F SM City Iloilo Benigno Aquino Avenue Mandurriao', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(82, '5Z0W61', 'SM CITY CALAMBA ', '90', 1, 1, 2, 7, 279, '2F Cyberzone Area', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(83, '7KP016', 'SM CENTER LAS PINAS', '91', 1, 1, 2, 2, 654, 'GF SM Center Las Pinas Alabang Zapote Rd Pamplona Dos Las Pinas City', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(84, '5Z0WC30', 'WC30 - SM SOUTH MALL', '92', 1, 1, 2, 2, 654, '2F West Wing Cyberzone Area Alabang-Zapote', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(85, '5Z0WC15', 'SM CITY BACOOR', '93', 1, 1, 2, 2, 341, '3F SM Bacoor', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29'),
(86, '5Z0WC59', 'SM MEGAMALL', '94', 1, 1, 2, 3, 799, '4F. SM Megamall Bldg. B. Julia Vargas', '0.00', '2017-03-31', 1, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:08:29', '2017-02-28 13:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `md_branchesz`
--

DROP TABLE IF EXISTS `md_branchesz`;
CREATE TABLE `md_branchesz` (
  `BranchID` int(11) NOT NULL,
  `BranchCode` varchar(15) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `BranchEmail` varchar(50) NOT NULL,
  `Type` int(11) NOT NULL DEFAULT '1',
  `Category` int(11) NOT NULL DEFAULT '1',
  `Groups` int(11) NOT NULL DEFAULT '1',
  `Channel` int(11) NOT NULL,
  `City` int(11) NOT NULL,
  `Address` varchar(150) NOT NULL,
  `BranchSize` decimal(18,2) NOT NULL,
  `Expiry` date NOT NULL,
  `Manager` int(11) NOT NULL,
  `IsTaxInclude` tinyint(1) NOT NULL DEFAULT '1',
  `SalesTax` int(11) NOT NULL DEFAULT '12',
  `DefaultReturnPolicy` int(11) NOT NULL DEFAULT '7',
  `IsBackdateAllowed` tinyint(1) NOT NULL DEFAULT '0',
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `Avatar` varchar(20) NOT NULL DEFAULT 'tbx.png',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_branchesz`
--

INSERT INTO `md_branchesz` (`BranchID`, `BranchCode`, `Description`, `BranchEmail`, `Type`, `Category`, `Groups`, `Channel`, `City`, `Address`, `BranchSize`, `Expiry`, `Manager`, `IsTaxInclude`, `SalesTax`, `DefaultReturnPolicy`, `IsBackdateAllowed`, `IsActive`, `Avatar`, `CreateDate`, `UpdateDate`) VALUES
(2, 'MAIN', 'Head Office', 'ho@tbx.ph', 1, 1, 1, 2, 992, 'Pasig City', '10.00', '2018-03-23', 2, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:26:40'),
(3, 'MAIN2', 'Head Office Warehouse', 'ho@tbx.ph', 1, 1, 1, 2, 992, 'Pasig City', '10.00', '2018-05-23', 12, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:36:51'),
(4, 'main4', 'main store 4', 'mm@mm', 2, 2, 4, 3, 6, 'jsdf', '0.00', '2017-03-23', 13, 1, 12, 7, 0, 1, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 23:39:08'),
(5, '1234', 'sdfsdf', 'sdf@sdf', 2, 2, 2, 3, 7, 'sdfsdf', '0.00', '2017-03-23', 6, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:20:54'),
(6, '2esdf', 'sdfsd3sd', 'df3s@sdf', 2, 2, 3, 3, 7, 'sdfsd', '0.00', '2017-03-23', 12, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:20:54'),
(7, 'sdf', 'sdf3sd', 'd@sd', 2, 2, 4, 1, 8, 'sdf', '0.00', '2017-03-23', 7, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:20:54'),
(8, '4M14', 'SM Pasig', 'dd@ff', 2, 2, 3, 3, 8, 'df3s', '0.00', '2017-03-23', 5, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:20:54'),
(9, '4M05', 'SM Harizon Mall', 'df@dd', 2, 2, 4, 3, 7, 'sd3wdsf', '0.00', '2017-03-23', 8, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:20:54'),
(10, '4M04', 'Alphaland South Gate Mall', 'testing@email.com', 2, 2, 3, 1, 768, 'Alphaland Mall Makati City', '11.00', '2017-03-31', 2, 1, 12, 10, 1, 1, 'tbx.png', '2017-02-28 13:06:57', '2017-03-25 09:45:19'),
(11, 'sdk33', 'sdfk', 'sdd@kd', 2, 2, 2, 2, 4, 'dks', '0.00', '2017-03-23', 6, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:20:54'),
(12, 'rejz', 'reggie store', 'rej@gmail.com', 2, 1, 2, 2, 768, 'Pasong Tamo', '0.00', '2017-03-23', 2, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:20:54'),
(13, 'test4', 'lsdkrjje', 'sdfk@lsd', 2, 2, 3, 3, 6, 'sdfk', '0.00', '2017-03-23', 13, 1, 12, 7, 0, 0, 'tbx.png', '2017-02-28 13:06:57', '2017-03-23 14:36:29'),
(14, '392l', 'testing 101', 'testing@tbx.ph', 1, 1, 3, 1, 7, 'Anywhere', '12.00', '2018-03-31', 11, 1, 12, 7, 0, 1, 'tbx.png', '2017-03-23 14:49:16', '2017-03-23 14:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `md_campaign`
--

DROP TABLE IF EXISTS `md_campaign`;
CREATE TABLE `md_campaign` (
  `CampaignID` int(11) NOT NULL,
  `CampaignName` varchar(50) NOT NULL,
  `DateFrom` date NOT NULL,
  `DateTo` date NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_customer`
--

DROP TABLE IF EXISTS `md_customer`;
CREATE TABLE `md_customer` (
  `CustID` int(11) NOT NULL,
  `CardNo` varchar(20) NOT NULL,
  `Branch` int(11) NOT NULL,
  `CustFirstName` varchar(50) DEFAULT NULL,
  `CustLastName` varchar(50) DEFAULT NULL,
  `CustEmail` varchar(50) DEFAULT NULL,
  `ContactNo` varchar(30) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `CustCity` int(11) DEFAULT NULL,
  `CustProvince` int(11) DEFAULT NULL,
  `CustPoints` decimal(18,2) NOT NULL,
  `CustCredits` decimal(18,2) NOT NULL,
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IsActive` tinyint(1) NOT NULL DEFAULT '0',
  `Avatar` varchar(30) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_customer`
--

INSERT INTO `md_customer` (`CustID`, `CardNo`, `Branch`, `CustFirstName`, `CustLastName`, `CustEmail`, `ContactNo`, `Address`, `CustCity`, `CustProvince`, `CustPoints`, `CustCredits`, `CreateDate`, `UpdateDate`, `IsActive`, `Avatar`) VALUES
(1, '000000000000', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', '2017-03-29 12:21:12', '2017-03-29 12:21:12', 0, 'reggie.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `md_inventory`
--

DROP TABLE IF EXISTS `md_inventory`;
CREATE TABLE `md_inventory` (
  `InvID` int(11) NOT NULL,
  `Branch` int(11) NOT NULL,
  `Product` int(11) NOT NULL,
  `Warehouse` int(11) NOT NULL,
  `InStocks` int(11) NOT NULL,
  `Committed` int(11) NOT NULL DEFAULT '0',
  `Available` int(11) GENERATED ALWAYS AS ((`InStocks` - `Committed`)) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_inventory_serials`
--

DROP TABLE IF EXISTS `md_inventory_serials`;
CREATE TABLE `md_inventory_serials` (
  `InvSerID` bigint(20) NOT NULL,
  `Product` int(11) NOT NULL,
  `Warehouse` int(11) NOT NULL,
  `Branch` int(11) NOT NULL,
  `IsSold` tinyint(1) NOT NULL DEFAULT '0',
  `Serial` varchar(20) NOT NULL,
  `InDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_items`
--

DROP TABLE IF EXISTS `md_items`;
CREATE TABLE `md_items` (
  `PID` int(11) NOT NULL,
  `BarCode` varchar(15) NOT NULL,
  `ProductDesc` varchar(50) NOT NULL,
  `SKU` varchar(50) NOT NULL,
  `ItemType` int(11) NOT NULL,
  `Brand` int(11) NOT NULL,
  `Category` int(11) NOT NULL,
  `LifeCycle` int(11) NOT NULL,
  `Family` int(11) NOT NULL,
  `IsSerialized` tinyint(1) NOT NULL DEFAULT '0',
  `OrderLevel` int(11) NOT NULL DEFAULT '100',
  `StdCost` decimal(18,2) NOT NULL DEFAULT '0.01',
  `PriceList` int(11) NOT NULL DEFAULT '0',
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_items`
--

INSERT INTO `md_items` (`PID`, `BarCode`, `ProductDesc`, `SKU`, `Brand`, `Category`, `LifeCycle`, `Family`, `IsSerialized`, `OrderLevel`, `StdCost`, `PriceList`, `IsActive`, `CreateDate`, `UpdateDate`) VALUES
(1, '00000000', 'Sample Item', 'Sample', 1, 1, 1, 1, 0, 100, '0.01', 0, 1, '2017-03-29 12:22:58', '2017-03-29 12:22:58');

-- --------------------------------------------------------

--
-- Table structure for table `md_supplier`
--

DROP TABLE IF EXISTS `md_supplier`;
CREATE TABLE `md_supplier` (
  `SuppID` int(11) NOT NULL,
  `CoyName` varchar(50) NOT NULL,
  `ContactPerson` varchar(50) NOT NULL,
  `ContactNo` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `ShipTo` varchar(100) NOT NULL,
  `BillTo` varchar(100) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_supplier`
--

INSERT INTO `md_supplier` (`SuppID`, `CoyName`, `ContactPerson`, `ContactNo`, `Email`, `ShipTo`, `BillTo`, `IsActive`, `CreateDate`, `UpdateDate`) VALUES
(1, 'Sample Supplier', 'No Contact', '000000000', 'NoEmail', 'Unknown', 'Unknown', 1, '2017-03-29 12:24:26', '2017-03-29 12:24:26');

-- --------------------------------------------------------

--
-- Table structure for table `md_user`
--

DROP TABLE IF EXISTS `md_user`;
CREATE TABLE `md_user` (
  `UID` int(11) NOT NULL,
  `DisplayName` varchar(100) NOT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `ContactNo` varchar(12) NOT NULL,
  `Password` varchar(32) NOT NULL DEFAULT 'd8578edf8458ce06fbc5bb76a58c5ca4',
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `Roles` int(2) NOT NULL,
  `Avatar` varchar(32) NOT NULL DEFAULT 'default.png',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `md_user`
--

INSERT INTO `md_user` (`UID`, `DisplayName`, `LastName`, `FirstName`, `Email`, `ContactNo`, `Password`, `IsActive`, `Roles`, `Avatar`, `CreateDate`, `LastLogin`) VALUES
(1, 'Manager', 'Techbox', 'Admin', 'manager', '09173160737', 'd8578edf8458ce06fbc5bb76a58c5ca4', 1, 1, 'tbx.png', '2017-03-29 12:17:27', '2017-03-29 12:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `md_warehouses`
--

DROP TABLE IF EXISTS `md_warehouses`;
CREATE TABLE `md_warehouses` (
  `WhsCode` int(11) NOT NULL,
  `WhsName` varchar(30) NOT NULL,
  `FreeWhs` tinyint(1) NOT NULL DEFAULT '1',
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_warehouses`
--

INSERT INTO `md_warehouses` (`WhsCode`, `WhsName`, `FreeWhs`, `IsActive`, `CreateDate`, `UpdateDate`) VALUES
(1, 'Good Stocks', 1, 1, '2017-03-29 12:25:13', '2017-03-29 12:25:13');

-- --------------------------------------------------------

--
-- Table structure for table `ref_branch_category`
--

DROP TABLE IF EXISTS `ref_branch_category`;
CREATE TABLE `ref_branch_category` (
  `CatID` int(11) NOT NULL,
  `Category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_branch_category`
--

INSERT INTO `ref_branch_category` (`CatID`, `Category`) VALUES
(1, 'Multibrand'),
(2, 'Single Brand');

-- --------------------------------------------------------

--
-- Table structure for table `ref_branch_channel`
--

DROP TABLE IF EXISTS `ref_branch_channel`;
CREATE TABLE `ref_branch_channel` (
  `ChannelID` int(11) NOT NULL,
  `Channel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_branch_channel`
--

INSERT INTO `ref_branch_channel` (`ChannelID`, `Channel`) VALUES
(1, 'CENTRAL LUZON'),
(2, 'GMA'),
(3, 'METRO MANILA'),
(4, 'MINDANAO'),
(5, 'NORTH EDSA'),
(6, 'NORTH LUZON'),
(7, 'SOUTH LUZON'),
(8, 'VISAYAS'),
(9, 'WESTERN MINDANAO');

-- --------------------------------------------------------

--
-- Table structure for table `ref_branch_city`
--

DROP TABLE IF EXISTS `ref_branch_city`;
CREATE TABLE `ref_branch_city` (
  `CityID` int(11) NOT NULL,
  `City` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_branch_city`
--

INSERT INTO `ref_branch_city` (`CityID`, `City`) VALUES
(1, 'ABORLAN'),
(2, 'ABRA DE ILOG'),
(3, 'ABUCAY'),
(4, 'ABULUG'),
(5, 'ABUYOG'),
(6, 'ADAMS'),
(7, 'AGDANGAN'),
(8, 'AGLIPAY'),
(9, 'AGNO'),
(10, 'AGONCILLO'),
(11, 'AGOO'),
(12, 'AGUILAR'),
(13, 'AGUINALDO'),
(14, 'AGUTAYA'),
(15, 'AJUY'),
(16, 'AKBAR'),
(17, 'AL-BARKA'),
(18, 'ALABAT'),
(19, 'ALABEL'),
(20, 'ALAMADA'),
(21, 'ALAMINOS'),
(22, 'ALANGALANG'),
(23, 'ALBUERA'),
(24, 'ALBURQUERQUE'),
(25, 'ALCALA'),
(26, 'ALCANTARA'),
(27, 'ALCOY'),
(28, 'ALEGRIA'),
(29, 'ALEOSAN'),
(30, 'ALFONSO'),
(31, 'ALFONSO CASTAÃ‘EDA'),
(32, 'ALFONSO LISTAÂ (POTIA)'),
(33, 'ALIAGA'),
(34, 'ALICIA'),
(35, 'ALILEM'),
(36, 'ALIMODIAN'),
(37, 'ALITAGTAG'),
(38, 'ALLACAPAN'),
(39, 'ALLEN'),
(40, 'ALMAGRO'),
(41, 'ALMERIA'),
(42, 'ALOGUINSAN'),
(43, 'ALORAN'),
(44, 'ALTAVAS'),
(45, 'ALUBIJID'),
(46, 'AMADEO'),
(47, 'AMAI MANABILANGÂ (BUMBARAN)'),
(48, 'AMBAGUIO'),
(49, 'AMLANÂ (AYUQUITAN)'),
(50, 'AMPATUAN'),
(51, 'AMULUNG'),
(52, 'ANAHAWAN'),
(53, 'ANAO'),
(54, 'ANDA'),
(55, 'ANGADANAN'),
(56, 'ANGAT'),
(57, 'ANGELES'),
(58, 'ANGONO'),
(59, 'ANILAO'),
(60, 'ANINI-Y'),
(61, 'ANTEQUERA'),
(62, 'ANTIPAS'),
(63, 'ANTIPOLO'),
(64, 'APALIT'),
(65, 'APARRI'),
(66, 'ARACELI'),
(67, 'ARAKAN'),
(68, 'ARAYAT'),
(69, 'ARGAO'),
(70, 'ARINGAY'),
(71, 'ARITAO'),
(72, 'AROROY'),
(73, 'ARTECHE'),
(74, 'ASINGAN'),
(75, 'ASIPULO'),
(76, 'ASTURIAS'),
(77, 'ASUNCIONÂ (SAUG)'),
(78, 'ATIMONAN'),
(79, 'ATOK'),
(80, 'AURORA'),
(81, 'AYUNGON'),
(82, 'BAAO'),
(83, 'BABATNGON'),
(84, 'BACACAY'),
(85, 'BACARRA'),
(86, 'BACLAYON'),
(87, 'BACNOTAN'),
(88, 'BACO'),
(89, 'BACOLOD'),
(90, 'BACOLOD-KALAWIÂ (BACOLOD-GRANDE)'),
(91, 'BACOLOR'),
(92, 'BACONG'),
(93, 'BACOOR'),
(94, 'BACUAG'),
(95, 'BADIAN'),
(96, 'BADIANGAN'),
(97, 'BADOC'),
(98, 'BAGABAG'),
(99, 'BAGAC'),
(100, 'BAGAMANOC'),
(101, 'BAGANGA'),
(102, 'BAGGAO'),
(103, 'BAGO'),
(104, 'BAGUIO'),
(105, 'BAGULIN'),
(106, 'BAGUMBAYAN'),
(107, 'BAIS'),
(108, 'BAKUN'),
(109, 'BALABAC'),
(110, 'BALABAGAN'),
(111, 'BALAGTASÂ (BIGAA)'),
(112, 'BALAMBAN'),
(113, 'BALANGA'),
(114, 'BALANGIGA'),
(115, 'BALANGKAYAN'),
(116, 'BALAOAN'),
(117, 'BALASAN'),
(118, 'BALATAN'),
(119, 'BALAYAN'),
(120, 'BALBALAN'),
(121, 'BALENO'),
(122, 'BALER'),
(123, 'BALETE'),
(124, 'BALIANGAO'),
(125, 'BALIGUIAN'),
(126, 'BALILIHAN'),
(127, 'BALINDONGÂ (WATU)'),
(128, 'BALINGASAG'),
(129, 'BALINGOAN'),
(130, 'BALIUAG'),
(131, 'BALLESTEROS'),
(132, 'BALOI'),
(133, 'BALUD'),
(134, 'BALUNGAO'),
(135, 'BAMBAN'),
(136, 'BAMBANG'),
(137, 'BANATE'),
(138, 'BANAUE'),
(139, 'BANAYBANAY'),
(140, 'BANAYOYO'),
(141, 'BANGA'),
(142, 'BANGAR'),
(143, 'BANGUED'),
(144, 'BANGUI'),
(145, 'BANGUINGUIÂ (TONGKIL)'),
(146, 'BANI'),
(147, 'BANISILAN'),
(148, 'BANNAÂ (ESPIRITU)'),
(149, 'BANSALAN'),
(150, 'BANSUD'),
(151, 'BANTAY'),
(152, 'BANTAYAN'),
(153, 'BANTONÂ (JONES)'),
(154, 'BARAS'),
(155, 'BARBAZA'),
(156, 'BARCELONA'),
(157, 'BARILI'),
(158, 'BARIRA'),
(159, 'BARLIG'),
(160, 'BAROBO'),
(161, 'BAROTAC NUEVO'),
(162, 'BAROTAC VIEJO'),
(163, 'BAROY'),
(164, 'BARUGO'),
(165, 'BASAY'),
(166, 'BASCO'),
(167, 'BASEY'),
(168, 'BASILISAÂ (RIZAL)'),
(169, 'BASISTA'),
(170, 'BASUD'),
(171, 'BATAC'),
(172, 'BATAD'),
(173, 'BATAN'),
(174, 'BATANGAS CITY'),
(175, 'BATARAZA'),
(176, 'BATO'),
(177, 'BATUAN'),
(178, 'BAUAN'),
(179, 'BAUANG'),
(180, 'BAUKO'),
(181, 'BAUNGON'),
(182, 'BAUTISTA'),
(183, 'BAY'),
(184, 'BAYABAS'),
(185, 'BAYAMBANG'),
(186, 'BAYANG'),
(187, 'BAYAWANÂ (TULONG)'),
(188, 'BAYBAY'),
(189, 'BAYOG'),
(190, 'BAYOMBONG'),
(191, 'BAYUGAN'),
(192, 'BELISON'),
(193, 'BENITO SOLIVEN'),
(194, 'BESAO'),
(200, 'BIÃ‘AN'),
(195, 'BIEN UNIDO'),
(196, 'BILAR'),
(197, 'BILIRAN'),
(198, 'BINALBAGAN'),
(199, 'BINALONAN'),
(201, 'BINANGONAN'),
(202, 'BINDOYÂ (PAYABON)'),
(203, 'BINGAWAN'),
(204, 'BINIDAYAN'),
(205, 'BINMALEY'),
(206, 'BINUANGAN'),
(207, 'BIRI'),
(208, 'BISLIG'),
(209, 'BOAC'),
(210, 'BOBON'),
(211, 'BOCAUE'),
(212, 'BOGO'),
(213, 'BOKOD'),
(214, 'BOLINAO'),
(215, 'BOLINEY'),
(216, 'BOLJOON'),
(217, 'BOMBON'),
(218, 'BONGABON'),
(219, 'BONGABONG'),
(220, 'BONGAO'),
(221, 'BONIFACIO'),
(222, 'BONTOC'),
(223, 'BORBON'),
(224, 'BORONGAN'),
(225, 'BOSTON'),
(226, 'BOTOLAN'),
(227, 'BRAULIO E. DUJALI'),
(228, 'BROOKE\'S POINT'),
(229, 'BUADIPOSO-BUNTONG'),
(230, 'BUBONG'),
(231, 'BUCAY'),
(232, 'BUCLOC'),
(233, 'BUENAVISTA'),
(234, 'BUGALLON'),
(235, 'BUGASONG'),
(236, 'BUGUEY'),
(237, 'BUGUIAS'),
(238, 'BUHI'),
(239, 'BULA'),
(240, 'BULAKAN'),
(241, 'BULALACAOÂ (SAN PEDRO)'),
(242, 'BULAN'),
(243, 'BULDON'),
(244, 'BULUAN'),
(245, 'BULUSAN'),
(246, 'BUNAWAN'),
(247, 'BURAUEN'),
(248, 'BURDEOS'),
(249, 'BURGOS'),
(250, 'BURUANGA'),
(251, 'BUSTOS'),
(252, 'BUSUANGA'),
(253, 'BUTIG'),
(254, 'BUTUAN'),
(255, 'BUUG'),
(256, 'CABA'),
(257, 'CABADBARAN'),
(258, 'CABAGAN'),
(259, 'CABANATUAN'),
(260, 'CABANGAN'),
(261, 'CABANGLASAN'),
(262, 'CABARROGUIS'),
(263, 'CABATUAN'),
(264, 'CABIAO'),
(265, 'CABUCGAYAN'),
(266, 'CABUGAO'),
(267, 'CABUSAO'),
(268, 'CABUYAO'),
(269, 'CADIZ'),
(270, 'CAGAYAN DE ORO'),
(271, 'CAGAYANCILLO'),
(272, 'CAGDIANAO'),
(273, 'CAGWAIT'),
(274, 'CAIBIRAN'),
(275, 'CAINTA'),
(276, 'CAJIDIOCAN'),
(277, 'CALABANGA'),
(278, 'CALACA'),
(279, 'CALAMBA'),
(280, 'CALANASANÂ (BAYAG)'),
(281, 'CALANOGAS'),
(282, 'CALAPAN'),
(283, 'CALAPE'),
(284, 'CALASIAO'),
(285, 'CALATAGAN'),
(286, 'CALATRAVA'),
(287, 'CALAUAG'),
(288, 'CALAUAN'),
(289, 'CALAYAN'),
(290, 'CALBAYOG'),
(291, 'CALBIGA'),
(292, 'CALINOG'),
(293, 'CALINTAAN'),
(294, 'CALOOCAN'),
(295, 'CALUBIAN'),
(296, 'CALUMPIT'),
(297, 'CALUYA'),
(298, 'CAMALANIUGAN'),
(299, 'CAMALIG'),
(300, 'CAMALIGAN'),
(301, 'CAMILING'),
(302, 'CAN-AVID'),
(303, 'CANAMAN'),
(304, 'CANDABA'),
(305, 'CANDELARIA'),
(306, 'CANDIJAY'),
(307, 'CANDON'),
(308, 'CANDONI'),
(309, 'CANLAON'),
(310, 'CANTILAN'),
(311, 'CAOAYAN'),
(312, 'CAPALONGA'),
(313, 'CAPAS'),
(314, 'CAPOOCAN'),
(315, 'CAPUL'),
(316, 'CARAGA'),
(317, 'CARAMOAN'),
(318, 'CARAMORAN'),
(319, 'CARASI'),
(320, 'CARCAR'),
(321, 'CARDONA'),
(322, 'CARIGARA'),
(323, 'CARLES'),
(324, 'CARMEN'),
(325, 'CARMONA'),
(326, 'CARRANGLAN'),
(327, 'CARRASCAL'),
(328, 'CASIGURAN'),
(329, 'CASTILLA'),
(330, 'CASTILLEJOS'),
(331, 'CATAINGAN'),
(332, 'CATANAUAN'),
(333, 'CATARMAN'),
(334, 'CATBALOGAN'),
(335, 'CATEEL'),
(336, 'CATIGBIAN'),
(337, 'CATMON'),
(338, 'CATUBIG'),
(339, 'CAUAYAN'),
(340, 'CAVINTI'),
(341, 'CAVITE CITY'),
(342, 'CAWAYAN'),
(343, 'CEBU CITY'),
(344, 'CERVANTES'),
(345, 'CLARIN'),
(346, 'CLAVER'),
(347, 'CLAVERIA'),
(348, 'COLUMBIO'),
(349, 'COMPOSTELA'),
(350, 'CONCEPCION'),
(351, 'CONNER'),
(352, 'CONSOLACION'),
(353, 'CORCUERA'),
(354, 'CORDON'),
(355, 'CORDOVA'),
(356, 'CORELLA'),
(357, 'CORON'),
(358, 'CORTES'),
(359, 'COTABATO CITY'),
(360, 'CUARTERO'),
(361, 'CUENCA'),
(362, 'CULABA'),
(363, 'CULASI'),
(364, 'CULION'),
(365, 'CURRIMAO'),
(366, 'CUYAPO'),
(367, 'CUYO'),
(368, 'DAANBANTAYAN'),
(369, 'DAET'),
(370, 'DAGAMI'),
(371, 'DAGOHOY'),
(372, 'DAGUIOMAN'),
(373, 'DAGUPAN'),
(374, 'DALAGUETE'),
(375, 'DAMULOG'),
(376, 'DANAO'),
(377, 'DANGCAGAN'),
(378, 'DANGLAS'),
(379, 'DAO'),
(380, 'DAPA'),
(381, 'DAPITAN'),
(382, 'DARAGAÂ (LOCSIN)'),
(383, 'DARAM'),
(384, 'DASMARIÃ‘AS'),
(385, 'DASOL'),
(386, 'DATU ABDULLAH SANGKI'),
(387, 'DATU ANGGAL MIDTIMBANG'),
(388, 'DATU BLAH T. SINSUAT'),
(389, 'DATU HOFFER AMPATUAN'),
(390, 'DATU MONTAWALÂ (PAGAGAWAN)'),
(391, 'DATU ODIN SINSUATÂ (DINAIG)'),
(392, 'DATU PAGLAS'),
(393, 'DATU PIANGÂ (DULAWAN)'),
(394, 'DATU SALIBO'),
(395, 'DATU SAUDI-AMPATUAN'),
(396, 'DATU UNSAY'),
(397, 'DAUIN'),
(398, 'DAUIS'),
(399, 'DAVAO CITY'),
(400, 'DEL CARMEN'),
(401, 'DEL GALLEGO'),
(402, 'DELFIN ALBANOÂ (MAGSAYSAY)'),
(403, 'DIADI'),
(404, 'DIFFUN'),
(405, 'DIGOS'),
(406, 'DILASAG'),
(407, 'DIMASALANG'),
(408, 'DIMATALING'),
(409, 'DIMIAO'),
(410, 'DINAGAT'),
(411, 'DINALUNGAN'),
(412, 'DINALUPIHAN'),
(413, 'DINAPIGUE'),
(414, 'DINAS'),
(415, 'DINGALAN'),
(416, 'DINGLE'),
(417, 'DINGRAS'),
(418, 'DIPACULAO'),
(419, 'DIPLAHAN'),
(420, 'DIPOLOG'),
(421, 'DITSAAN-RAMAIN'),
(422, 'DIVILACAN'),
(427, 'DOÃ‘A REMEDIOS TRINIDAD'),
(423, 'DOLORES'),
(424, 'DON CARLOS'),
(425, 'DON MARCELINO'),
(426, 'DON VICTORIANO CHIONGBIANÂ (DON MARIANO MARCOS)'),
(428, 'DONSOL'),
(429, 'DUEÃ‘AS'),
(430, 'DUERO'),
(431, 'DULAG'),
(432, 'DUMAGUETE'),
(433, 'DUMALAG'),
(434, 'DUMALINAO'),
(435, 'DUMALNEG'),
(436, 'DUMANGAS'),
(437, 'DUMANJUG'),
(438, 'DUMARAN'),
(439, 'DUMARAO'),
(440, 'DUMINGAG'),
(441, 'DUPAX DEL NORTE'),
(442, 'DUPAX DEL SUR'),
(443, 'ECHAGUE'),
(444, 'EL NIDOÂ (BACUIT)'),
(445, 'EL SALVADOR'),
(446, 'ENRILE'),
(447, 'ENRIQUE B. MAGALONAÂ (SARAVIA)'),
(448, 'ENRIQUE VILLANUEVA'),
(449, 'ESCALANTE'),
(450, 'ESPERANZA'),
(451, 'ESTANCIA'),
(452, 'FAMY'),
(453, 'FERROL'),
(454, 'FLORA'),
(455, 'FLORIDABLANCA'),
(456, 'GABALDONÂ (BITULOK & SABANI)'),
(457, 'GAINZA'),
(458, 'GALIMUYOD'),
(459, 'GAMAY'),
(460, 'GAMU'),
(461, 'GANASSI'),
(462, 'GANDARA'),
(463, 'GAPAN'),
(464, 'GARCHITORENA'),
(465, 'GARCIA HERNANDEZ'),
(466, 'GASAN'),
(467, 'GATTARAN'),
(468, 'GENERAL EMILIO AGUINALDO'),
(469, 'GENERAL LUNA'),
(470, 'GENERAL MACARTHUR'),
(471, 'GENERAL MAMERTO NATIVIDAD'),
(472, 'GENERAL MARIANO ALVAREZ'),
(473, 'GENERAL NAKAR'),
(474, 'GENERAL SALIPADA K. PENDATUN'),
(475, 'GENERAL SANTOSÂ (DADIANGAS)'),
(476, 'GENERAL TINIOÂ (PAPAYA)'),
(477, 'GENERAL TRIAS'),
(478, 'GERONA'),
(479, 'GETAFE'),
(480, 'GIGAQUIT'),
(481, 'GIGMOTO'),
(482, 'GINATILAN'),
(483, 'GINGOOG'),
(484, 'GIPORLOS'),
(485, 'GITAGUM'),
(486, 'GLAN'),
(487, 'GLORIA'),
(488, 'GOA'),
(489, 'GODOD'),
(490, 'GONZAGA'),
(491, 'GOVERNOR GENEROSO'),
(492, 'GREGORIO DEL PILARÂ (CONCEPCION)'),
(493, 'GUAGUA'),
(494, 'GUBAT'),
(495, 'GUIGUINTO'),
(496, 'GUIHULNGAN'),
(497, 'GUIMBA'),
(498, 'GUIMBAL'),
(499, 'GUINAYANGAN'),
(500, 'GUINDULMAN'),
(501, 'GUINDULUNGAN'),
(502, 'GUINOBATAN'),
(503, 'GUINSILIBAN'),
(504, 'GUIPOS'),
(505, 'GUIUAN'),
(506, 'GUMACA'),
(507, 'GUTALAC'),
(508, 'HADJI MOHAMMAD AJUL'),
(509, 'HADJI MUHTAMAD'),
(510, 'HADJI PANGLIMA TAHILÂ (MARUNGGAS)'),
(511, 'HAGONOY'),
(512, 'HAMTIC'),
(513, 'HERMOSA'),
(514, 'HERNANI'),
(515, 'HILONGOS'),
(516, 'HIMAMAYLAN'),
(517, 'HINABANGAN'),
(518, 'HINATUAN'),
(519, 'HINDANG'),
(520, 'HINGYON'),
(521, 'HINIGARAN'),
(522, 'HINOBA-ANÂ (ASIA)'),
(523, 'HINUNANGAN'),
(524, 'HINUNDAYAN'),
(525, 'HUNGDUAN'),
(526, 'IBA'),
(527, 'IBAAN'),
(528, 'IBAJAY'),
(529, 'IGBARAS'),
(530, 'IGUIG'),
(531, 'ILAGAN'),
(532, 'ILIGAN'),
(533, 'ILOG'),
(534, 'ILOILO CITY'),
(535, 'IMELDA'),
(536, 'IMPASUGONG'),
(537, 'IMUS'),
(538, 'INABANGA'),
(539, 'INDANAN'),
(540, 'INDANG'),
(541, 'INFANTA'),
(542, 'INITAO'),
(543, 'INOPACAN'),
(544, 'IPIL'),
(545, 'IRIGA'),
(546, 'IROSIN'),
(547, 'ISABEL'),
(548, 'ISABELA'),
(549, 'ISABELA CITY'),
(550, 'ISULAN'),
(551, 'ITBAYAT'),
(552, 'ITOGON'),
(553, 'IVANA'),
(554, 'IVISAN'),
(555, 'JABONGA'),
(556, 'JAEN'),
(557, 'JAGNA'),
(558, 'JALAJALA'),
(559, 'JAMINDAN'),
(560, 'JANIUAY'),
(561, 'JARO'),
(562, 'JASAAN'),
(563, 'JAVIERÂ (BUGHO)'),
(564, 'JIABONG'),
(565, 'JIMALALUD'),
(566, 'JIMENEZ'),
(567, 'JIPAPAD'),
(568, 'JOLO'),
(569, 'JOMALIG'),
(570, 'JONES'),
(571, 'JORDAN'),
(572, 'JOSE ABAD SANTOSÂ (TRINIDAD)'),
(573, 'JOSE DALMANÂ (PONOT)'),
(574, 'JOSE PANGANIBAN'),
(575, 'JOSEFINA'),
(576, 'JOVELLAR'),
(577, 'JUBAN'),
(578, 'JULITA'),
(579, 'KABACAN'),
(580, 'KABANKALAN'),
(581, 'KABASALAN'),
(582, 'KABAYAN'),
(583, 'KABUGAO'),
(584, 'KABUNTALANÂ (TUMBAO)'),
(585, 'KADINGILAN'),
(586, 'KALAMANSIG'),
(587, 'KALAWIT'),
(588, 'KALAYAAN'),
(589, 'KALIBO'),
(590, 'KALILANGAN'),
(591, 'KALINGALAN CALUANG'),
(592, 'KANANGA'),
(593, 'KAPAI'),
(594, 'KAPALONG'),
(595, 'KAPANGAN'),
(596, 'KAPATAGAN'),
(597, 'KASIBU'),
(598, 'KATIPUNAN'),
(599, 'KAUSWAGAN'),
(600, 'KAWAYAN'),
(601, 'KAWIT'),
(602, 'KAYAPA'),
(603, 'KIAMBA'),
(604, 'KIANGAN'),
(605, 'KIBAWE'),
(606, 'KIBLAWAN'),
(607, 'KIBUNGAN'),
(608, 'KIDAPAWAN'),
(609, 'KINOGUITAN'),
(610, 'KITAOTAO'),
(611, 'KITCHARAO'),
(612, 'KOLAMBUGAN'),
(613, 'KORONADAL'),
(614, 'KUMALARANG'),
(615, 'LA CARLOTA'),
(616, 'LA CASTELLANA'),
(617, 'LA LIBERTAD'),
(618, 'LA PAZ'),
(619, 'LA TRINIDAD'),
(620, 'LAAKÂ (SAN VICENTE)'),
(621, 'LABANGAN'),
(622, 'LABASON'),
(623, 'LABO'),
(624, 'LABRADOR'),
(625, 'LACUB'),
(626, 'LAGANGILANG'),
(627, 'LAGAWE'),
(628, 'LAGAYAN'),
(629, 'LAGONGLONG'),
(630, 'LAGONOY'),
(631, 'LAGUINDINGAN'),
(632, 'LAKE SEBU'),
(633, 'LAKEWOOD'),
(634, 'LAL-LO'),
(635, 'LALA'),
(636, 'LAMBAYONGÂ (MARIANO MARCOS)'),
(637, 'LAMBUNAO'),
(638, 'LAMITAN'),
(639, 'LAMUT'),
(640, 'LANGIDEN'),
(641, 'LANGUYAN'),
(642, 'LANTAPAN'),
(643, 'LANTAWAN'),
(644, 'LANUZA'),
(645, 'LAOAC'),
(646, 'LAOAG'),
(647, 'LAOANG'),
(648, 'LAPINIG'),
(649, 'LAPU-LAPUÂ (OPON)'),
(650, 'LAPUYAN'),
(651, 'LARENA'),
(652, 'LAS NAVAS'),
(653, 'LAS NIEVES'),
(654, 'LAS PIÃ‘AS'),
(655, 'LASAM'),
(656, 'LAUA-AN'),
(657, 'LAUR'),
(658, 'LAUREL'),
(659, 'LAVEZARES'),
(660, 'LAWAAN'),
(661, 'LAZI'),
(662, 'LEBAK'),
(663, 'LEGANES'),
(664, 'LEGAZPI'),
(665, 'LEMERY'),
(666, 'LEON'),
(667, 'LEON B. POSTIGOÂ (BACUNGAN)'),
(668, 'LEYTE'),
(669, 'LEZO'),
(670, 'LIAN'),
(671, 'LIANGA'),
(672, 'LIBACAO'),
(673, 'LIBAGON'),
(674, 'LIBERTAD'),
(675, 'LIBJOÂ (ALBOR)'),
(676, 'LIBMANAN'),
(677, 'LIBON'),
(678, 'LIBONA'),
(679, 'LIBUNGAN'),
(680, 'LICAB'),
(681, 'LICUAN-BAAYÂ (LICUAN)'),
(682, 'LIDLIDDA'),
(683, 'LIGAO'),
(684, 'LILA'),
(685, 'LILIW'),
(686, 'LILOAN'),
(687, 'LILOY'),
(688, 'LIMASAWA'),
(689, 'LIMAY'),
(690, 'LINAMON'),
(691, 'LINAPACAN'),
(692, 'LINGAYEN'),
(693, 'LINGIG'),
(694, 'LIPA'),
(695, 'LLANERA'),
(696, 'LLORENTE'),
(697, 'LOAY'),
(698, 'LOBO'),
(699, 'LOBOC'),
(700, 'LOOC'),
(701, 'LOON'),
(702, 'LOPE DE VEGA'),
(703, 'LOPEZ'),
(704, 'LOPEZ JAENA'),
(705, 'LORETO'),
(706, 'LOS BAÃ‘OS'),
(707, 'LUBA'),
(708, 'LUBANG'),
(709, 'LUBAO'),
(710, 'LUBUAGAN'),
(711, 'LUCBAN'),
(712, 'LUCENA'),
(713, 'LUGAIT'),
(714, 'LUGUS'),
(715, 'LUISIANA'),
(716, 'LUMBA-BAYABAOÂ (MAGUING)'),
(717, 'LUMBACA-UNAYAN'),
(718, 'LUMBAN'),
(719, 'LUMBATAN'),
(720, 'LUMBAYANAGUE'),
(721, 'LUNA'),
(722, 'LUPAO'),
(723, 'LUPI'),
(724, 'LUPON'),
(725, 'LUTAYAN'),
(726, 'LUUK'),
(727, 'M LANG'),
(728, 'MAASIM'),
(729, 'MAASIN'),
(730, 'MAAYON'),
(731, 'MABALACAT'),
(732, 'MABINAY'),
(733, 'MABINI'),
(734, 'MABINIÂ (DOÃ‘A ALICIA)'),
(735, 'MABITAC'),
(736, 'MABUHAY'),
(737, 'MACABEBE'),
(738, 'MACALELON'),
(739, 'MACARTHUR'),
(740, 'MACO'),
(741, 'MACONACON'),
(742, 'MACROHON'),
(743, 'MADALAG'),
(744, 'MADALUM'),
(745, 'MADAMBA'),
(746, 'MADDELA'),
(747, 'MADRID'),
(748, 'MADRIDEJOS'),
(749, 'MAGALANG'),
(750, 'MAGALLANES'),
(751, 'MAGARAO'),
(752, 'MAGDALENA'),
(753, 'MAGDIWANG'),
(754, 'MAGPET'),
(755, 'MAGSAYSAY'),
(756, 'MAGSAYSAYÂ (LINUGOS)'),
(757, 'MAGSINGAL'),
(758, 'MAGUING'),
(759, 'MAHAPLAG'),
(760, 'MAHATAO'),
(761, 'MAHAYAG'),
(762, 'MAHINOG'),
(763, 'MAIGO'),
(764, 'MAIMBUNG'),
(765, 'MAINIT'),
(766, 'MAITUM'),
(767, 'MAJAYJAY'),
(768, 'MAKATI'),
(769, 'MAKATO'),
(770, 'MAKILALA'),
(771, 'MALABANG'),
(772, 'MALABON'),
(773, 'MALABUYOC'),
(774, 'MALALAG'),
(775, 'MALANGAS'),
(776, 'MALAPATAN'),
(777, 'MALASIQUI'),
(778, 'MALAY'),
(779, 'MALAYBALAY'),
(780, 'MALIBCONG'),
(781, 'MALILIPOT'),
(782, 'MALIMONO'),
(783, 'MALINAO'),
(784, 'MALITA'),
(785, 'MALITBOG'),
(786, 'MALLIG'),
(787, 'MALOLOS'),
(788, 'MALUNGON'),
(789, 'MALUSO'),
(790, 'MALVAR'),
(791, 'MAMASAPANO'),
(792, 'MAMBAJAO'),
(793, 'MAMBURAO'),
(794, 'MAMBUSAO'),
(795, 'MANABO'),
(796, 'MANAOAG'),
(797, 'MANAPLA'),
(798, 'MANAY'),
(799, 'MANDALUYONG'),
(800, 'MANDAON'),
(801, 'MANDAUE'),
(802, 'MANGALDAN'),
(803, 'MANGATAREM'),
(804, 'MANGUDADATU'),
(805, 'MANILA'),
(806, 'MANITO'),
(807, 'MANJUYOD'),
(808, 'MANKAYAN'),
(809, 'MANOLO FORTICH'),
(810, 'MANSALAY'),
(811, 'MANTICAO'),
(812, 'MANUKAN'),
(813, 'MAPANAS'),
(814, 'MAPANDAN'),
(815, 'MAPUNÂ (CAGAYAN DE TAWI-TAWI)'),
(816, 'MARABUT'),
(817, 'MARAGONDON'),
(818, 'MARAGUSANÂ (SAN MARIANO)'),
(819, 'MARAMAG'),
(820, 'MARANTAO'),
(821, 'MARAWI'),
(822, 'MARCOS'),
(823, 'MARGOSATUBIG'),
(824, 'MARIA'),
(825, 'MARIA AURORA'),
(826, 'MARIBOJOC'),
(827, 'MARIHATAG'),
(828, 'MARIKINA'),
(829, 'MARILAO'),
(830, 'MARIPIPI'),
(831, 'MARIVELES'),
(832, 'MAROGONG'),
(833, 'MASANTOL'),
(834, 'MASBATE CITY'),
(835, 'MASINLOC'),
(836, 'MASIU'),
(837, 'MASLOG'),
(838, 'MATAASNAKAHOY'),
(839, 'MATAG-OB'),
(840, 'MATALAM'),
(841, 'MATALOM'),
(842, 'MATANAO'),
(843, 'MATANOG'),
(844, 'MATI'),
(845, 'MATNOG'),
(846, 'MATUGUINAO'),
(847, 'MATUNGAO'),
(848, 'MAUBAN'),
(849, 'MAWAB'),
(850, 'MAYANTOC'),
(851, 'MAYDOLONG'),
(852, 'MAYORGA'),
(853, 'MAYOYAO'),
(854, 'MEDELLIN'),
(855, 'MEDINA'),
(856, 'MENDEZÂ (MENDEZ-NUÃ‘EZ)'),
(857, 'MERCEDES'),
(858, 'MERIDA'),
(859, 'MEXICO'),
(860, 'MEYCAUAYAN'),
(861, 'MIAGAO'),
(862, 'MIDSALIP'),
(863, 'MIDSAYAP'),
(864, 'MILAGROS'),
(865, 'MILAOR'),
(866, 'MINA'),
(867, 'MINALABAC'),
(868, 'MINALIN'),
(869, 'MINGLANILLA'),
(870, 'MOALBOAL'),
(871, 'MOBO'),
(872, 'MOGPOG'),
(873, 'MOISES PADILLAÂ (MAGALLON)'),
(874, 'MOLAVE'),
(875, 'MONCADA'),
(876, 'MONDRAGON'),
(877, 'MONKAYO'),
(878, 'MONREAL'),
(879, 'MONTEVISTA'),
(880, 'MORONG'),
(881, 'MOTIONG'),
(885, 'MUÃ‘OZ'),
(882, 'MULANAY'),
(883, 'MULONDO'),
(884, 'MUNAI'),
(886, 'MUNTINLUPA'),
(887, 'MURCIA'),
(888, 'MUTIA'),
(889, 'NAAWAN'),
(890, 'NABAS'),
(891, 'NABUA'),
(892, 'NABUNTURAN'),
(893, 'NAGA'),
(894, 'NAGBUKEL'),
(895, 'NAGCARLAN'),
(896, 'NAGTIPUNAN'),
(897, 'NAGUILIAN'),
(898, 'NAIC'),
(899, 'NAMPICUAN'),
(900, 'NARRA'),
(901, 'NARVACAN'),
(902, 'NASIPIT'),
(903, 'NASUGBU'),
(904, 'NATIVIDAD'),
(905, 'NATONIN'),
(906, 'NAUJAN'),
(907, 'NAVAL'),
(908, 'NAVOTAS'),
(909, 'NEW BATAAN'),
(910, 'NEW CORELLA'),
(911, 'NEW LUCENA'),
(912, 'NEW WASHINGTON'),
(913, 'NORALA'),
(914, 'NORTHERN KABUNTALAN'),
(915, 'NORZAGARAY'),
(916, 'NOVELETA'),
(917, 'NUEVA ERA'),
(918, 'NUEVA VALENCIA'),
(919, 'NUMANCIA'),
(920, 'NUNUNGAN'),
(921, 'OAS'),
(922, 'OBANDO'),
(923, 'OCAMPO'),
(924, 'ODIONGAN'),
(925, 'OLD PANAMAO'),
(926, 'OLONGAPO'),
(927, 'OLUTANGA'),
(928, 'OMAR'),
(929, 'OPOL'),
(930, 'ORANI'),
(931, 'ORAS'),
(932, 'ORION'),
(933, 'ORMOC'),
(934, 'OROQUIETA'),
(935, 'OSLOB'),
(936, 'OTON'),
(937, 'OZAMIZ'),
(938, 'PADADA'),
(939, 'PADRE BURGOS'),
(940, 'PADRE GARCIA'),
(941, 'PAETE'),
(942, 'PAGADIAN'),
(943, 'PAGALUNGAN'),
(944, 'PAGAYAWANÂ (TATARIKAN)'),
(945, 'PAGBILAO'),
(946, 'PAGLAT'),
(947, 'PAGSANGHAN'),
(948, 'PAGSANJAN'),
(949, 'PAGUDPUD'),
(950, 'PAKIL'),
(951, 'PALANAN'),
(952, 'PALANAS'),
(953, 'PALAPAG'),
(954, 'PALAUIG'),
(955, 'PALAYAN'),
(956, 'PALIMBANG'),
(957, 'PALO'),
(958, 'PALOMPON'),
(959, 'PALUAN'),
(960, 'PAMBUJAN'),
(961, 'PAMPLONA'),
(962, 'PANABO'),
(963, 'PANAON'),
(964, 'PANAY'),
(965, 'PANDAG'),
(966, 'PANDAMI'),
(967, 'PANDAN'),
(968, 'PANDI'),
(969, 'PANGANIBANÂ (PAYO)'),
(970, 'PANGANTUCAN'),
(971, 'PANGIL'),
(972, 'PANGLAO'),
(973, 'PANGLIMA ESTINOÂ (NEW PANAMAO)'),
(974, 'PANGLIMA SUGALAÂ (BALIMBING)'),
(975, 'PANGUTARAN'),
(976, 'PANIQUI'),
(977, 'PANITAN'),
(978, 'PANTABANGAN'),
(979, 'PANTAO RAGAT'),
(980, 'PANTAR'),
(981, 'PANTUKAN'),
(982, 'PANUKULAN'),
(983, 'PAOAY'),
(984, 'PAOMBONG'),
(987, 'PARAÃ‘AQUE'),
(985, 'PARACALE'),
(986, 'PARACELIS'),
(988, 'PARANASÂ (WRIGHT)'),
(989, 'PARANG'),
(990, 'PASACAO'),
(991, 'PASAY'),
(992, 'PASIG'),
(993, 'PASIL'),
(994, 'PASSI'),
(995, 'PASTRANA'),
(996, 'PASUQUIN'),
(997, 'PATA'),
(998, 'PATEROS'),
(999, 'PATIKUL'),
(1000, 'PATNANUNGAN'),
(1001, 'PATNONGON'),
(1002, 'PAVIA'),
(1003, 'PAYAO'),
(1004, 'PEÃ‘ABLANCA'),
(1005, 'PEÃ‘ARANDA'),
(1006, 'PEÃ‘ARRUBIA'),
(1007, 'PEREZ'),
(1008, 'PIAGAPO'),
(1009, 'PIAT'),
(1022, 'PIÃ‘ANÂ (NEW PIÃ‘AN)'),
(1010, 'PICONGÂ (SULTAN GUMANDER)'),
(1011, 'PIDDIG'),
(1012, 'PIDIGAN'),
(1013, 'PIGCAWAYAN'),
(1014, 'PIKIT'),
(1015, 'PILA'),
(1016, 'PILAR'),
(1017, 'PILI'),
(1018, 'PILILLA'),
(1019, 'PINABACDAO'),
(1020, 'PINAMALAYAN'),
(1021, 'PINAMUNGAJAN'),
(1023, 'PINILI'),
(1024, 'PINTUYAN'),
(1025, 'PINUKPUK'),
(1026, 'PIO DURAN'),
(1027, 'PIO V. CORPUZÂ (LIMBUHAN)'),
(1028, 'PITOGO'),
(1029, 'PLACER'),
(1030, 'PLARIDEL'),
(1031, 'POLA'),
(1032, 'POLANCO'),
(1033, 'POLANGUI'),
(1034, 'POLILLO'),
(1035, 'POLOMOLOK'),
(1036, 'PONTEVEDRA'),
(1037, 'POONA BAYABAOÂ (GATA)'),
(1038, 'POONA PIAGAPO'),
(1039, 'PORAC'),
(1040, 'PORO'),
(1041, 'POTOTAN'),
(1042, 'POZORRUBIO'),
(1043, 'PRESENTACIONÂ (PARUBCAN)'),
(1044, 'PRESIDENT CARLOS P. GARCIAÂ (PITOGO)'),
(1045, 'PRESIDENT MANUEL A. ROXAS'),
(1046, 'PRESIDENT QUIRINO'),
(1047, 'PRESIDENT ROXAS'),
(1048, 'PRIETO DIAZ'),
(1049, 'PROSPERIDAD'),
(1050, 'PUALAS'),
(1051, 'PUDTOL'),
(1052, 'PUERTO GALERA'),
(1053, 'PUERTO PRINCESA'),
(1054, 'PUGO'),
(1055, 'PULILAN'),
(1056, 'PULUPANDAN'),
(1057, 'PURA'),
(1058, 'QUEZON'),
(1059, 'QUEZON CITY'),
(1060, 'QUINAPONDAN'),
(1061, 'QUIRINO'),
(1062, 'QUIRINOÂ (ANGKAKI)'),
(1063, 'RAGAY'),
(1064, 'RAJAH BUAYAN'),
(1065, 'RAMON'),
(1066, 'RAMON MAGSAYSAYÂ (LIARGO)'),
(1067, 'RAMOS'),
(1068, 'RAPU-RAPU'),
(1069, 'REAL'),
(1070, 'REINA MERCEDES'),
(1071, 'REMEDIOS T. ROMUALDEZ'),
(1072, 'RIZAL'),
(1073, 'RIZALÂ (LIWAN)'),
(1074, 'RIZALÂ (MARCOS)'),
(1075, 'RODRIGUEZÂ (MONTALBAN)'),
(1076, 'ROMBLON'),
(1077, 'RONDA'),
(1078, 'ROSALES'),
(1079, 'ROSARIO'),
(1080, 'ROSELLER LIM'),
(1081, 'ROXAS'),
(1082, 'ROXAS CITY'),
(1083, 'SABANGAN'),
(1084, 'SABLAN'),
(1085, 'SABLAYAN'),
(1086, 'SABTANG'),
(1087, 'SADANGA'),
(1088, 'SAGADA'),
(1089, 'SAGAY'),
(1091, 'SAGÃ‘AY'),
(1090, 'SAGBAYANÂ (BORJA)'),
(1092, 'SAGUDAY'),
(1093, 'SAGUIARAN'),
(1094, 'SAINT BERNARD'),
(1095, 'SALAY'),
(1096, 'SALCEDO'),
(1097, 'SALCEDOÂ (BAUGEN)'),
(1098, 'SALLAPADAN'),
(1099, 'SALUG'),
(1100, 'SALVADOR'),
(1101, 'SALVADOR BENEDICTO'),
(1102, 'SAMAL'),
(1103, 'SAMBOAN'),
(1104, 'SAMPALOC'),
(1105, 'SAN AGUSTIN'),
(1106, 'SAN ANDRES'),
(1107, 'SAN ANDRESÂ (CALOLBON)'),
(1108, 'SAN ANTONIO'),
(1109, 'SAN BENITO'),
(1110, 'SAN CARLOS'),
(1111, 'SAN CLEMENTE'),
(1112, 'SAN DIONISIO'),
(1113, 'SAN EMILIO'),
(1114, 'SAN ENRIQUE'),
(1115, 'SAN ESTEBAN'),
(1116, 'SAN FABIAN'),
(1117, 'SAN FELIPE'),
(1118, 'SAN FERNANDO'),
(1119, 'SAN FRANCISCO'),
(1120, 'SAN FRANCISCOÂ (ANAO-AON)'),
(1121, 'SAN FRANCISCOÂ (AURORA)'),
(1122, 'SAN GABRIEL'),
(1123, 'SAN GUILLERMO'),
(1124, 'SAN ILDEFONSO'),
(1125, 'SAN ISIDRO'),
(1126, 'SAN JACINTO'),
(1127, 'SAN JOAQUIN'),
(1128, 'SAN JORGE'),
(1129, 'SAN JOSE'),
(1130, 'SAN JOSE DE BUAN'),
(1131, 'SAN JOSE DE BUENAVISTA'),
(1132, 'SAN JOSE DEL MONTE'),
(1133, 'SAN JUAN'),
(1134, 'SAN JUANÂ (CABALIAN)'),
(1135, 'SAN JUANÂ (LAPOG)'),
(1136, 'SAN JULIAN'),
(1137, 'SAN LEONARDO'),
(1138, 'SAN LORENZO'),
(1139, 'SAN LORENZO RUIZÂ (IMELDA)'),
(1140, 'SAN LUIS'),
(1141, 'SAN MANUEL'),
(1142, 'SAN MANUELÂ (CALLANG)'),
(1143, 'SAN MARCELINO'),
(1144, 'SAN MARIANO'),
(1145, 'SAN MATEO'),
(1146, 'SAN MIGUEL'),
(1147, 'SAN NARCISO'),
(1148, 'SAN NICOLAS'),
(1149, 'SAN PABLO'),
(1150, 'SAN PASCUAL'),
(1151, 'SAN PEDRO'),
(1152, 'SAN POLICARPO'),
(1153, 'SAN QUINTIN'),
(1154, 'SAN RAFAEL'),
(1155, 'SAN REMIGIO'),
(1156, 'SAN RICARDO'),
(1157, 'SAN ROQUE'),
(1158, 'SAN SEBASTIAN'),
(1159, 'SAN SIMON'),
(1160, 'SAN TEODORO'),
(1161, 'SAN VICENTE'),
(1162, 'SANCHEZ-MIRA'),
(1163, 'SANTA'),
(1164, 'SANTA ANA'),
(1165, 'SANTA BARBARA'),
(1166, 'SANTA CATALINA'),
(1167, 'SANTA CRUZ'),
(1168, 'SANTA ELENA'),
(1169, 'SANTA FE'),
(1170, 'SANTA FEÂ (IMUGAN)'),
(1171, 'SANTA IGNACIA'),
(1172, 'SANTA JOSEFA'),
(1173, 'SANTA LUCIA'),
(1174, 'SANTA MAGDALENA'),
(1175, 'SANTA MARCELA'),
(1176, 'SANTA MARGARITA'),
(1177, 'SANTA MARIA'),
(1178, 'SANTA MARIAÂ (IMELDA)'),
(1179, 'SANTA MONICAÂ (SAPAO)'),
(1180, 'SANTA PRAXEDES'),
(1181, 'SANTA RITA'),
(1182, 'SANTA ROSA'),
(1183, 'SANTA TERESITA'),
(1184, 'SANTANDER'),
(1185, 'SANTIAGO'),
(1186, 'SANTO DOMINGO'),
(1187, 'SANTO DOMINGOÂ (LIBOG)'),
(1188, 'SANTO NIÃ‘O'),
(1189, 'SANTO NIÃ‘OÂ (FAIRE)'),
(1190, 'SANTO TOMAS'),
(1191, 'SANTOL'),
(1192, 'SAPA-SAPA'),
(1193, 'SAPAD'),
(1194, 'SAPANG DALAGA'),
(1195, 'SAPIAN'),
(1196, 'SARA'),
(1197, 'SARANGANI'),
(1198, 'SARIAYA'),
(1199, 'SARRAT'),
(1200, 'SASMUANÂ (SEXMOAN)'),
(1201, 'SEBASTE'),
(1202, 'SENATOR NINOY AQUINO'),
(1203, 'SERGIO OSMEÃ‘A SR.'),
(1204, 'SEVILLA'),
(1205, 'SHARIFF AGUAKÂ (MAGANOY)'),
(1206, 'SHARIFF SAYDONA MUSTAPHA'),
(1207, 'SIASI'),
(1208, 'SIATON'),
(1209, 'SIAY'),
(1210, 'SIAYAN'),
(1211, 'SIBAGAT'),
(1212, 'SIBALOM'),
(1213, 'SIBONGA'),
(1214, 'SIBUCO'),
(1215, 'SIBULAN'),
(1216, 'SIBUNAG'),
(1217, 'SIBUTAD'),
(1218, 'SIBUTU'),
(1219, 'SIERRA BULLONES'),
(1220, 'SIGAY'),
(1221, 'SIGMA'),
(1222, 'SIKATUNA'),
(1223, 'SILAGO'),
(1224, 'SILANG'),
(1225, 'SILAY'),
(1226, 'SILVINO LOBOS'),
(1227, 'SIMUNUL'),
(1228, 'SINACABAN'),
(1229, 'SINAIT'),
(1230, 'SINDANGAN'),
(1231, 'SINILOAN'),
(1232, 'SIOCON'),
(1233, 'SIPALAY'),
(1234, 'SIPOCOT'),
(1235, 'SIQUIJOR'),
(1236, 'SIRAWAI'),
(1237, 'SIRUMA'),
(1238, 'SISON'),
(1239, 'SITANGKAI'),
(1240, 'SOCORRO'),
(1241, 'SOFRONIO ESPAÃ‘OLA'),
(1242, 'SOGOD'),
(1243, 'SOLANA'),
(1244, 'SOLANO'),
(1245, 'SOLSONA'),
(1246, 'SOMINOTÂ (DON MARIANO MARCOS)'),
(1247, 'SORSOGON CITY'),
(1248, 'SOUTH UBIAN'),
(1249, 'SOUTH UPI'),
(1250, 'SUAL'),
(1251, 'SUBIC'),
(1252, 'SUDIPEN'),
(1253, 'SUGBONGCOGON'),
(1254, 'SUGPON'),
(1255, 'SULAT'),
(1256, 'SULOP'),
(1257, 'SULTAN DUMALONDONG'),
(1258, 'SULTAN KUDARATÂ (NULING)'),
(1259, 'SULTAN MASTURA'),
(1260, 'SULTAN NAGA DIMAPOROÂ (KAROMATAN)'),
(1261, 'SULTAN SA BARONGISÂ (LAMBAYONG)'),
(1262, 'SULTAN SUMAGKAÂ (TALITAY)'),
(1263, 'SUMILAO'),
(1264, 'SUMISIP'),
(1265, 'SURALLAH'),
(1266, 'SURIGAO CITY'),
(1267, 'SUYO'),
(1268, 'T\'BOLI'),
(1269, 'TAAL'),
(1270, 'TABACO'),
(1271, 'TABANGO'),
(1272, 'TABINA'),
(1273, 'TABOGON'),
(1274, 'TABONTABON'),
(1275, 'TABUAN-LASA'),
(1276, 'TABUELAN'),
(1277, 'TABUK'),
(1278, 'TACLOBAN'),
(1279, 'TACURONG'),
(1280, 'TADIAN'),
(1281, 'TAFT'),
(1282, 'TAGANA-AN'),
(1283, 'TAGAPUL-AN'),
(1284, 'TAGAYTAY'),
(1285, 'TAGBILARAN'),
(1286, 'TAGBINA'),
(1287, 'TAGKAWAYAN'),
(1288, 'TAGO'),
(1289, 'TAGOLOAN'),
(1290, 'TAGOLOAN II'),
(1291, 'TAGUDIN'),
(1292, 'TAGUIG'),
(1293, 'TAGUM'),
(1294, 'TALACOGON'),
(1295, 'TALAINGOD'),
(1296, 'TALAKAG'),
(1297, 'TALALORA'),
(1298, 'TALAVERA'),
(1299, 'TALAYAN'),
(1300, 'TALIBON'),
(1301, 'TALIPAO'),
(1302, 'TALISAY'),
(1303, 'TALISAYAN'),
(1304, 'TALUGTUG'),
(1305, 'TALUSAN'),
(1306, 'TAMBULIG'),
(1307, 'TAMPAKAN'),
(1308, 'TAMPARAN'),
(1309, 'TAMPILISAN'),
(1310, 'TANAUAN'),
(1311, 'TANAY'),
(1312, 'TANDAG'),
(1313, 'TANDUBAS'),
(1314, 'TANGALAN'),
(1315, 'TANGCAL'),
(1316, 'TANGUB'),
(1317, 'TANJAY'),
(1318, 'TANTANGAN'),
(1319, 'TANUDAN'),
(1320, 'TANZA'),
(1321, 'TAPAZ'),
(1322, 'TAPUL'),
(1323, 'TARAKA'),
(1324, 'TARANGNAN'),
(1325, 'TARLAC CITY'),
(1326, 'TARRAGONA'),
(1327, 'TAYABAS'),
(1328, 'TAYASAN'),
(1329, 'TAYSAN'),
(1330, 'TAYTAY'),
(1331, 'TAYUG'),
(1332, 'TAYUM'),
(1333, 'TERESA'),
(1334, 'TERNATE'),
(1335, 'TIAONG'),
(1336, 'TIBIAO'),
(1337, 'TIGAON'),
(1338, 'TIGBAO'),
(1339, 'TIGBAUAN'),
(1340, 'TINAMBAC'),
(1341, 'TINEG'),
(1342, 'TINGLAYAN'),
(1343, 'TINGLOY'),
(1344, 'TINOC'),
(1345, 'TIPO-TIPO'),
(1346, 'TITAY'),
(1347, 'TIWI'),
(1348, 'TOBIAS FORNIERÂ (DAO)'),
(1349, 'TOBOSO'),
(1350, 'TOLEDO'),
(1351, 'TOLOSA'),
(1352, 'TOMAS OPPUS'),
(1353, 'TORRIJOS'),
(1354, 'TRECE MARTIRES'),
(1355, 'TRENTO'),
(1356, 'TRINIDAD'),
(1357, 'TUAO'),
(1358, 'TUBA'),
(1359, 'TUBAJON'),
(1360, 'TUBAO'),
(1361, 'TUBARAN'),
(1362, 'TUBAY'),
(1363, 'TUBIGON'),
(1364, 'TUBLAY'),
(1365, 'TUBO'),
(1366, 'TUBOD'),
(1367, 'TUBUNGAN'),
(1368, 'TUBURAN'),
(1369, 'TUDELA'),
(1370, 'TUGAYA'),
(1371, 'TUGUEGARAO'),
(1372, 'TUKURAN'),
(1373, 'TULUNAN'),
(1374, 'TUMAUINI'),
(1375, 'TUNGA'),
(1376, 'TUNGAWAN'),
(1377, 'TUPI'),
(1378, 'TURTLE ISLANDSÂ (TAGANAK)'),
(1379, 'TUY'),
(1380, 'UBAY'),
(1381, 'UMINGAN'),
(1382, 'UNGKAYA PUKAN'),
(1383, 'UNISAN'),
(1384, 'UPI'),
(1385, 'URBIZTONDO'),
(1386, 'URDANETA'),
(1387, 'USON'),
(1388, 'UYUGAN'),
(1389, 'VALDERRAMA'),
(1390, 'VALENCIA'),
(1391, 'VALENCIAÂ (LUZURRIAGA)'),
(1392, 'VALENZUELA'),
(1393, 'VALLADOLID'),
(1394, 'VALLEHERMOSO'),
(1395, 'VERUELA'),
(1396, 'VICTORIA'),
(1397, 'VICTORIAS'),
(1398, 'VIGA'),
(1399, 'VIGAN'),
(1400, 'VILLABA'),
(1401, 'VILLANUEVA'),
(1402, 'VILLAREAL'),
(1403, 'VILLASIS'),
(1404, 'VILLAVERDEÂ (IBUNG)'),
(1405, 'VILLAVICIOSA'),
(1406, 'VINCENZO A. SAGUN'),
(1407, 'VINTAR'),
(1408, 'VINZONS'),
(1409, 'VIRAC'),
(1410, 'WAO'),
(1411, 'ZAMBOANGA CITY'),
(1412, 'ZAMBOANGUITA'),
(1413, 'ZARAGOZA'),
(1414, 'ZARRAGA'),
(1415, 'ZUMARRAGA');

-- --------------------------------------------------------

--
-- Table structure for table `ref_branch_group`
--

DROP TABLE IF EXISTS `ref_branch_group`;
CREATE TABLE `ref_branch_group` (
  `GroupID` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_branch_group`
--

INSERT INTO `ref_branch_group` (`GroupID`, `Description`) VALUES
(2, 'CHANNEL'),
(3, 'FEATURE'),
(4, 'FLAGSHIP A'),
(5, 'FLAGSHIP B'),
(1, 'PROVINCIAL');

-- --------------------------------------------------------

--
-- Table structure for table `ref_branch_target`
--

DROP TABLE IF EXISTS `ref_branch_target`;
CREATE TABLE `ref_branch_target` (
  `TargetID` int(11) NOT NULL,
  `BranchID` int(11) NOT NULL,
  `Month` varchar(10) NOT NULL,
  `Target` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_branch_type`
--

DROP TABLE IF EXISTS `ref_branch_type`;
CREATE TABLE `ref_branch_type` (
  `TypeID` int(11) NOT NULL,
  `TypeDesc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_branch_type`
--

INSERT INTO `ref_branch_type` (`TypeID`, `TypeDesc`) VALUES
(1, 'Inline'),
(2, 'Kiosk');

-- --------------------------------------------------------

--
-- Table structure for table `ref_installment`
--

DROP TABLE IF EXISTS `ref_installment`;
CREATE TABLE `ref_installment` (
  `InsId` int(11) NOT NULL,
  `InstDesc` varchar(30) NOT NULL,
  `InstValue` int(11) DEFAULT '0',
  `IsActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_installment`
--

INSERT INTO `ref_installment` (`InsId`, `InstDesc`, `InstValue`, `IsActive`) VALUES
(1, 'Straight Payment', 0, 1),
(2, '3 mos. installment', 3, 1),
(3, '6 mos. installment', 6, 1),
(4, '12 mos. installment', 12, 1),
(5, '18 mos. installment', 18, 0),
(6, '24 Mos. Installment', 24, 0),
(7, '36 mos. installment', 36, 0),
(8, '48 MOS. INSTALLMENT', 48, 0),
(9, '5 YEARS INSTALLMENT', 60, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ref_item_brand`
--

DROP TABLE IF EXISTS `ref_item_brand`;
CREATE TABLE `ref_item_brand` (
  `BrandID` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_item_category`
--

DROP TABLE IF EXISTS `ref_item_category`;
CREATE TABLE `ref_item_category` (
  `P_CatID` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `ref_item_cycle`
--

DROP TABLE IF EXISTS `ref_item_cycle`;
CREATE TABLE `ref_item_cycle` (
  `P_CycleID` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_item_family`
--

DROP TABLE IF EXISTS `ref_item_family`;
CREATE TABLE `ref_item_family` (
  `FamID` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_item_type`
--
DROP TABLE IF EXISTS `ref_item_type`;
CREATE TABLE `ref_item_type` (
  `TypeID` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_payment_type`
--

DROP TABLE IF EXISTS `ref_payment_type`;
CREATE TABLE `ref_payment_type` (
  `PaymentId` int(11) NOT NULL,
  `PaymentName` varchar(20) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Payment Reference Table';

--
-- Dumping data for table `ref_payment_type`
--

INSERT INTO `ref_payment_type` (`PaymentId`, `PaymentName`, `IsActive`) VALUES
(1, 'Cash', 1),
(2, 'Credit', 1),
(3, 'Debit', 1),
(4, 'Gift Card', 0),
(5, 'Home Credit', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ref_points`
--

DROP TABLE IF EXISTS `ref_points`;
CREATE TABLE `ref_points` (
  `PointID` int(11) NOT NULL,
  `Amount` decimal(18,2) NOT NULL,
  `Percent` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_province`
--

DROP TABLE IF EXISTS `ref_province`;
CREATE TABLE `ref_province` (
  `ProvinceID` int(11) NOT NULL,
  `Province` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_province`
--

INSERT INTO `ref_province` (`ProvinceID`, `Province`) VALUES
(1, 'Abra'),
(2, 'Agusandel Norte'),
(3, 'Agusandel Sur'),
(4, 'Aklan'),
(5, 'Albay'),
(6, 'Antique'),
(7, 'Apayao'),
(8, 'Aurora'),
(9, 'Basilan'),
(10, 'Bataan'),
(11, 'Batanes'),
(12, 'Batangas'),
(13, 'Benguet'),
(14, 'Biliran'),
(15, 'Bohol'),
(16, 'Bukidnon'),
(17, 'Bulacan'),
(18, 'Cagayan'),
(19, 'CamarinesNorte'),
(20, 'CamarinesSur'),
(21, 'Camiguin'),
(22, 'Capiz'),
(23, 'Catanduanes'),
(24, 'Cavite'),
(25, 'Cebu'),
(26, 'Compostela Valley'),
(27, 'Cotabato'),
(28, 'Davaodel Norte'),
(29, 'Davaodel Sur'),
(30, 'DavaoOccidental'),
(31, 'DavaoOriental'),
(32, 'Dinagat Islands'),
(33, 'Eastern Samar'),
(34, 'Guimaras'),
(35, 'Ifugao'),
(36, 'IlocosNorte'),
(37, 'IlocosSur'),
(38, 'Iloilo'),
(39, 'Isabela'),
(40, 'Kalinga'),
(41, 'La Union'),
(42, 'Laguna'),
(43, 'Lanaodel Norte'),
(44, 'Lanaodel Sur'),
(45, 'Leyte'),
(46, 'Maguindanao'),
(47, 'Marinduque'),
(48, 'Masbate'),
(82, 'Metro Manila'),
(49, 'MisamisOccidental'),
(50, 'MisamisOriental'),
(51, 'MountainProvince'),
(52, 'NegrosOccidental'),
(53, 'NegrosOriental'),
(54, 'Northern Samar'),
(55, 'Nueva Ecija'),
(56, 'Nueva Vizcaya'),
(57, 'OccidentalMindoro'),
(58, 'OrientalMindoro'),
(59, 'Palawan'),
(60, 'Pampanga'),
(61, 'Pangasinan'),
(62, 'Quezon'),
(63, 'Quirino'),
(64, 'Rizal'),
(65, 'Romblon'),
(66, 'Samar'),
(67, 'Sarangani'),
(68, 'Siquijor'),
(69, 'Sorsogon'),
(70, 'South Cotabato'),
(71, 'Southern Leyte'),
(72, 'Sultan Kudarat'),
(73, 'Sulu'),
(74, 'Surigaodel Norte'),
(75, 'Surigaodel Sur'),
(76, 'Tarlac'),
(77, 'Tawi-Tawi'),
(78, 'Zambales'),
(79, 'Zamboangadel Norte'),
(80, 'Zamboangadel Sur'),
(81, 'ZamboangaSibugay');

-- --------------------------------------------------------

--
-- Table structure for table `ref_terminal`
--

DROP TABLE IF EXISTS `ref_terminal`;
CREATE TABLE `ref_terminal` (
  `BankID` int(11) NOT NULL,
  `BankName` varchar(30) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_user_branch`
--

DROP TABLE IF EXISTS `ref_user_branch`;
CREATE TABLE `ref_user_branch` (
  `UserBranchID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BranchID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_user_target`
--

DROP TABLE IF EXISTS `ref_user_target`;
CREATE TABLE `ref_user_target` (
  `UsrTargetID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Target` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stp_bom_item`
--

DROP TABLE IF EXISTS `stp_bom_item`;
CREATE TABLE `stp_bom_item` (
  `BoMSID` int(11) NOT NULL,
  `BoMID` int(11) NOT NULL,
  `PID` int(11) NOT NULL,
  `WhsCode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stp_campaign_branch`
--

DROP TABLE IF EXISTS `stp_campaign_branch`;
CREATE TABLE `stp_campaign_branch` (
  `CpBrnID` int(11) NOT NULL,
  `CampaignID` int(11) NOT NULL,
  `BranchID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stp_campaign_item`
--

DROP TABLE IF EXISTS `stp_campaign_item`;
CREATE TABLE `stp_campaign_item` (
  `CpItemID` int(11) NOT NULL,
  `CampaignID` int(11) NOT NULL,
  `PID` int(11) NOT NULL,
  `SRP` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stp_config`
--

DROP TABLE IF EXISTS `stp_config`;
CREATE TABLE `stp_config` (
  `Id` int(11) NOT NULL,
  `CompanyName` varchar(50) NOT NULL DEFAULT 'Rej Quadrant',
  `CompanyAddress` varchar(100) NOT NULL,
  `Website` varchar(50) DEFAULT NULL,
  `IsTaxInclude` tinyint(1) NOT NULL DEFAULT '1',
  `IsPurchaseTaxable` tinyint(1) NOT NULL DEFAULT '1',
  `SalesTax` int(2) NOT NULL DEFAULT '12',
  `InputTax` int(2) NOT NULL DEFAULT '12',
  `UsedComputation` tinyint(1) NOT NULL DEFAULT '1',
  `DefPayment` int(11) NOT NULL DEFAULT '1',
  `DefaultReturnPolicy` int(11) NOT NULL DEFAULT '7',
  `ReceiptMessage` varchar(150) NOT NULL DEFAULT '7 Days return policy',
  `Avatar` varchar(30) NOT NULL DEFAULT 'tbx.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stp_config`
--

INSERT INTO `stp_config` (`Id`, `CompanyName`, `CompanyAddress`, `Website`, `IsTaxInclude`, `IsPurchaseTaxable`, `SalesTax`, `InputTax`, `UsedComputation`, `DefPayment`, `DefaultReturnPolicy`, `ReceiptMessage`, `Avatar`) VALUES
(1, 'Techbox International, Inc.', '2nd Floor Tao Techonology Building P.E Antonio cor. Legazpi Sts. Brgy. Ugong, Pasig City 1604', 'www.techboxhub.com.ph', 1, 1, 12, 12, 1, 1, 7, '7 Days return policy', 'tbx.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stp_item_pricedetails`
--

DROP TABLE IF EXISTS `stp_item_pricedetails`;
CREATE TABLE `stp_item_pricedetails` (
  `PDID` int(11) NOT NULL,
  `PLID` int(11) NOT NULL COMMENT 'Link to Pricelist',
  `PID` int(11) NOT NULL COMMENT 'Link to Items',
  `Price` decimal(18,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stp_item_pricelist`
--

DROP TABLE IF EXISTS `stp_item_pricelist`;
CREATE TABLE `stp_item_pricelist` (
  `PLID` int(11) NOT NULL,
  `Description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_pullout`
--

DROP TABLE IF EXISTS `trx_pullout`;
CREATE TABLE `trx_pullout` (
  `PullID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `RefNo` varchar(20) NOT NULL,
  `TransDate` date NOT NULL,
  `Branch` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '1',
  `Comments` varchar(100) DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `Approver` int(11) DEFAULT NULL,
  `Confirmed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_pullout_row`
--

DROP TABLE IF EXISTS `trx_pullout_row`;
CREATE TABLE `trx_pullout_row` (
  `PullRowID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Warehouse` int(11) NOT NULL,
  `Cost` decimal(18,2) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `Serial` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_purchase`
--

DROP TABLE IF EXISTS `trx_purchase`;
CREATE TABLE `trx_purchase` (
  `PurID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `PONumber` varchar(20) NOT NULL,
  `TransDate` date NOT NULL,
  `DeliveryDate` date NOT NULL,
  `ShipToBranch` int(11) NOT NULL,
  `Supplier` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `GTotal` decimal(18,2) NOT NULL,
  `Status` int(11) NOT NULL,
  `ReceivedQty` int(11) NOT NULL DEFAULT '0',
  `Comments` varchar(100) DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_purchase_detail`
--

DROP TABLE IF EXISTS `trx_purchase_detail`;
CREATE TABLE `trx_purchase_detail` (
  `PurRowID` int(11) NOT NULL,
  `Serial` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_purchase_row`
--

DROP TABLE IF EXISTS `trx_purchase_row`;
CREATE TABLE `trx_purchase_row` (
  `PurRowID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Warehouse` int(11) NOT NULL,
  `Cost` decimal(18,2) NOT NULL,
  `InputVat` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `GTotal` decimal(18,2) NOT NULL,
  `ReceivedQty` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_receiving`
--

DROP TABLE IF EXISTS `trx_receiving`;
CREATE TABLE `trx_receiving` (
  `RcvID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `InvoiceNo` varchar(20) NOT NULL,
  `TransDate` date NOT NULL,
  `Branch` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `GTotal` decimal(18,2) NOT NULL,
  `Comments` varchar(100) DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_receiving_detail`
--

DROP TABLE IF EXISTS `trx_receiving_detail`;
CREATE TABLE `trx_receiving_detail` (
  `RcvRowID` int(11) NOT NULL,
  `Serial` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_receiving_row`
--

DROP TABLE IF EXISTS `trx_receiving_row`;
CREATE TABLE `trx_receiving_row` (
  `RcvRowID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Warehouse` int(11) NOT NULL,
  `Cost` decimal(18,2) NOT NULL,
  `InputVat` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `GTotal` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_return`
--

DROP TABLE IF EXISTS `trx_return`;
CREATE TABLE `trx_return` (
  `SalesID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `RefNo` varchar(20) NOT NULL,
  `TransDate` date NOT NULL,
  `Branch` int(11) NOT NULL,
  `IsMember` int(11) NOT NULL DEFAULT '0',
  `Quantity` int(11) NOT NULL,
  `Discount` decimal(18,2) NOT NULL,
  `SalesTax` decimal(18,2) NOT NULL,
  `TotalBefSub` decimal(18,2) NOT NULL,
  `TotalAfSub` decimal(18,2) NOT NULL,
  `TotalAfVat` decimal(18,2) NOT NULL,
  `NetTotal` decimal(18,2) NOT NULL,
  `AmountDue` decimal(18,2) NOT NULL,
  `Payment` decimal(18,2) NOT NULL,
  `ShortOver` decimal(18,2) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '1',
  `Comments` varchar(100) DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `ReplacedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_return_row`
--

DROP TABLE IF EXISTS `trx_return_row`;
CREATE TABLE `trx_return_row` (
  `SalesRowID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Warehouse` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Discount` decimal(18,2) NOT NULL,
  `DiscValue` decimal(18,2) NOT NULL,
  `Subsidy` decimal(18,2) NOT NULL,
  `OutputTax` int(11) NOT NULL,
  `TaxAmount` decimal(18,2) NOT NULL,
  `Cost` decimal(18,2) NOT NULL,
  `Price` decimal(18,2) NOT NULL,
  `PriceAfSub` decimal(18,2) NOT NULL,
  `PriceAfVat` decimal(18,2) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `TotalAfSub` decimal(18,2) NOT NULL,
  `TotalAfVat` decimal(18,2) NOT NULL,
  `GTotal` decimal(18,2) NOT NULL,
  `Serial` varchar(20) DEFAULT NULL,
  `Campaign` varchar(50) NOT NULL DEFAULT 'Normal'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_sales`
--

DROP TABLE IF EXISTS `trx_sales`;
CREATE TABLE `trx_sales` (
  `SalesID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `RefNo` varchar(20) NOT NULL,
  `TransDate` date NOT NULL,
  `Branch` int(11) NOT NULL,
  `IsMember` int(11) NOT NULL DEFAULT '0',
  `Quantity` int(11) NOT NULL,
  `Discount` decimal(18,2) NOT NULL,
  `SalesTax` decimal(18,2) NOT NULL,
  `TotalBefSub` decimal(18,2) NOT NULL,
  `TotalAfSub` decimal(18,2) NOT NULL,
  `TotalAfVat` decimal(18,2) NOT NULL,
  `NetTotal` decimal(18,2) NOT NULL,
  `AmountDue` decimal(18,2) NOT NULL,
  `Payment` decimal(18,2) NOT NULL,
  `ShortOver` decimal(18,2) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '1',
  `Comments` varchar(100) DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `ReplacedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_sales_customer`
--

DROP TABLE IF EXISTS `trx_sales_customer`;
CREATE TABLE `trx_sales_customer` (
  `SalesCustID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `CardNo` varchar(20) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `ContactNo` int(12) NOT NULL,
  `Address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_sales_payments`
--

DROP TABLE IF EXISTS `trx_sales_payments`;
CREATE TABLE `trx_sales_payments` (
  `SalesPayID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `Branch` int(11) NOT NULL,
  `PaymentType` int(20) NOT NULL,
  `RefNumber` varchar(20) DEFAULT NULL,
  `Terminal` int(11) NOT NULL,
  `IssuingBank` int(11) NOT NULL,
  `Installment` int(11) NOT NULL,
  `Amount` decimal(18,2) NOT NULL,
  `IsDeposited` tinyint(1) NOT NULL DEFAULT '0',
  `TransDate` date NOT NULL,
  `DepositSlip` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_sales_row`
--

DROP TABLE IF EXISTS `trx_sales_row`;
CREATE TABLE `trx_sales_row` (
  `SalesRowID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Warehouse` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Discount` decimal(18,2) NOT NULL,
  `DiscValue` decimal(18,2) NOT NULL,
  `Subsidy` decimal(18,2) NOT NULL,
  `OutputTax` int(11) NOT NULL,
  `TaxAmount` decimal(18,2) NOT NULL,
  `Cost` decimal(18,2) NOT NULL,
  `Price` decimal(18,2) NOT NULL,
  `PriceAfSub` decimal(18,2) NOT NULL,
  `PriceAfVat` decimal(18,2) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `TotalAfSub` decimal(18,2) NOT NULL,
  `TotalAfVat` decimal(18,2) NOT NULL,
  `GTotal` decimal(18,2) NOT NULL,
  `Serial` varchar(20) DEFAULT NULL,
  `Campaign` varchar(50) NOT NULL DEFAULT 'Normal'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_stocks_movement`
--

DROP TABLE IF EXISTS `trx_stocks_movement`;
CREATE TABLE `trx_stocks_movement` (
  `SmrID` bigint(20) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `Date` date NOT NULL,
  `RefNo` varchar(20) NOT NULL,
  `Module` varchar(20) DEFAULT NULL,
  `TransType` varchar(20) DEFAULT NULL,
  `Product` int(11) NOT NULL,
  `Warehouse` int(11) NOT NULL,
  `Branch` int(11) NOT NULL,
  `Serial` varchar(20) DEFAULT NULL,
  `MoveIn` int(11) NOT NULL,
  `MoveOut` int(11) NOT NULL,
  `SumInOut` int(11) GENERATED ALWAYS AS ((`MoveIn` - `MoveOut`)) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_transfer`
--

DROP TABLE IF EXISTS `trx_transfer`;
CREATE TABLE `trx_transfer` (
  `TrfID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `TransferNo` varchar(20) NOT NULL,
  `TransDate` date NOT NULL,
  `Branch` int(11) NOT NULL,
  `InvFrom` int(11) NOT NULL,
  `InvTo` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `TransferType` tinyint(1) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '1',
  `Comments` varchar(100) DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `Approver` int(11) DEFAULT NULL,
  `Receiver` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_transfer_row`
--

DROP TABLE IF EXISTS `trx_transfer_row`;
CREATE TABLE `trx_transfer_row` (
  `TrfRowID` int(11) NOT NULL,
  `TransID` bigint(20) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Warehouse` int(11) NOT NULL,
  `Cost` decimal(18,2) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` decimal(18,2) NOT NULL,
  `Serial` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trx_sales_postpaid`
--

DROP TABLE IF EXISTS `trx_sales_postpaid`;
CREATE TABLE `trx_sales_postpaid` (
  `PostpaidID` int(11) NOT NULL,
  `RefNo` varchar(20) NOT NULL,
  `TransDate` date NOT NULL,
  `Branch` int(11) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `MiddleName` varchar(20) NOT NULL,
  `ContactNo` varchar(12) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `IccID` varchar(30) NOT NULL,
  `SimNo` varchar(12) NOT NULL,
  `DepositSlip` varchar(20) DEFAULT NULL,
  `DepositAmount` decimal(18,2) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT '1',
  `Comments` varchar(100) DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreateDate` date NOT NULL,
  `ActivationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_branch_series`
--

DROP TABLE IF EXISTS `ref_branch_series`;
CREATE TABLE `ref_branch_series` (
  `SeriesID` int(11) NOT NULL,
  `Branch` int(11) NOT NULL,
  `Start` int(11) NOT NULL,
  `End` int(11) NOT NULL,
  `Current` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ------------------------------------------------------

--
-- Stand-in structure for view `view_branches`
--
DROP VIEW IF EXISTS `view_branches`;
CREATE VIEW view_branches AS
SELECT t0.*
, t1.Category as 'CategoryDesc'
, t2.Channel as 'ChannelDesc'
, t3.City as 'CityDesc'
, t4.Description as 'GroupDesc'
, t5.TypeDesc
, t6.Start
, t6.Current
, t6.End
, (SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = t0.Manager) as 'AreaManager'
FROM md_branches t0
INNER JOIN ref_branch_category t1 ON t0.Category = t1.CatID
INNER JOIN ref_branch_channel t2 ON t0.Channel = t2.ChannelID
INNER JOIN ref_branch_city t3 ON t0.City = t3.CityID
INNER JOIN ref_branch_group t4 ON t0.Groups = t4.GroupID
INNER JOIN ref_branch_type t5 ON t0.Type = t5.TypeID
LEFT JOIN ref_branch_series t6 ON t0.BranchID = t6.Branch;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_campaign`
--
DROP VIEW IF EXISTS `view_campaign`;
CREATE VIEW view_campaign AS
SELECT t0.*,
t1.BranchID,
t3.Description as 'BranchName',
t2.PID,
t4.ProductDesc,
t2.SRP
FROM md_campaign t0
LEFT JOIN stp_campaign_branch t1 ON t0.CampaignID = t1.CampaignID
LEFT JOIN stp_campaign_item t2 ON t0.CampaignID = t2.CampaignID
LEFT JOIN md_branches t3 ON t1.BranchID = t3.BranchID
LEFT JOIN md_items t4 ON t2.PID = t4.PID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_customer`
--
DROP VIEW IF EXISTS `view_customer`;
CREATE VIEW view_customer AS
SELECT t0.*
, t1.BranchCode
, t1.Description as BranchDesc
, t1.CategoryDesc
, t1.ChannelDesc
, t1.CityDesc
, t1.GroupDesc
, t1.TypeDesc
, t2.City as Cust_City
, t3.Province as Cust_Provice
FROM md_customer t0
LEFT JOIN view_branches t1 ON t0.Branch = t1.BranchID
LEFT JOIN ref_branch_city t2 ON t0.CustCity = t2.CityID
LEFT JOIN ref_province t3 ON t0.CustProvince = t3.ProvinceID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_frontliners`
--
DROP VIEW IF EXISTS `view_frontliners`;
CREATE VIEW view_frontliners AS
select t0.*
, t1.UsrTargetID
, t1.Target
, t2.BranchID
, t2.UserBranchID
, t3.Description
from md_user t0 
INNER JOIN ref_user_target t1 on t0.UID = t1.UserID
LEFT JOIN ref_user_branch t2 on t0.UID = t2.UserID
LEFT JOIN md_branches t3 on t2.BranchID = t3.BranchID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_items`
--
DROP VIEW IF EXISTS `view_items`;
CREATE VIEW view_items AS
SELECT t0.* 
,t1.Description as 'BrandDesc'
,t2.Description as 'CategoryDesc'
,t3.Description as 'CycleDesc'
,t4.Description as 'PriceListDesc'
,t7.Description as FamilyDesc
,t8.Description as TypeDesc
,t5.PDID
,IFNULL(t5.Price,0) as 'CurrentPrice'
,IFNULL((SELECT SUM(I0.Available) FROM md_inventory I0 WHERE I0.Product=t0.PID),0) as 'Inventory'
FROM md_items t0
LEFT JOIN ref_item_brand t1 ON t0.Brand = t1.BrandID
LEFT JOIN ref_item_category t2 ON t0.Category = t2.P_CatID
LEFT JOIN ref_item_cycle t3 ON t0.LifeCycle = t3.P_CycleID
LEFT JOIN ref_item_family t7 ON t0.Family = t7.FamID
LEFT JOIN ref_item_type t8 ON t0.ItemType = t8.TypeID
LEFT JOIN stp_item_pricelist t4 ON t0.PriceList = t4.PLID
LEFT JOIN stp_item_pricedetails t5 ON (t0.PID = t5.PID AND t0.PriceList = t5.PLID);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_inventory`
--
DROP VIEW IF EXISTS `view_inventory`;
CREATE VIEW view_inventory AS
SELECT t0.*
,t1.*
,t2.BarCode
,t2.ProductDesc
,t2.SKU
,t2.Brand
,t2.Category as 'ItemCategory'
,t2.LifeCycle
,t2.IsSerialized
,t2.OrderLevel
,t2.StdCost
,t2.PriceList
,t2.PriceListDesc
,t2.IsActive as 'IsItemActive'
,t2.TypeDesc as ItemTypeDesc
,t2.BrandDesc
,t2.CategoryDesc as 'ItemCategoryDesc'
,t2.CycleDesc
,t2.FamilyDesc
,t2.PDID
,t2.CurrentPrice
,t3.WhsName
,(t2.StdCost*(1+(t1.SalesTax/100))) as 'CostVatInc'
,(t2.CurrentPrice*(1+(t1.SalesTax/100))) as 'PriceVatInc'
,t0.InStocks*(t2.StdCost*(1+(t1.SalesTax/100))) as 'TotalCostVatInc'
,t0.InStocks*(t2.CurrentPrice*(1+(t1.SalesTax/100))) as 'TotalPriceVatInc'

FROM md_inventory t0 
INNER JOIN view_branches t1 ON t0.Branch = t1.BranchID
INNER JOIN view_items t2 ON t0.Product = t2.PID
INNER JOIN md_warehouses t3 ON t0.Warehouse = t3.WhsCode;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_inventory_serials`
--
DROP VIEW IF EXISTS `view_inventory_serials`;
CREATE VIEW view_inventory_serials AS
select `t0`.`InvSerID` AS `InvSerID`
,`t0`.`Product` AS `Product`
,`t0`.`Warehouse` AS `Warehouse`
,`t0`.`Branch` AS `Branch`
,`t0`.`IsSold` AS `IsSold`
,`t0`.`Serial` AS `Serial`
,`t0`.`InDate` AS `InDate`
,`t1`.`BranchID` AS `BranchID`
,`t1`.`BranchCode` AS `BranchCode`
,`t1`.`Description` AS `Description`
,`t1`.`BranchEmail` AS `BranchEmail`
,`t1`.`Type` AS `Type`
,`t1`.`Category` AS `Category`
,`t1`.`Groups` AS `Groups`
,`t1`.`Channel` AS `Channel`
,`t1`.`City` AS `City`
,`t1`.`Address` AS `Address`
,`t1`.`Manager` AS `Manager`
,`t1`.`IsTaxInclude` AS `IsTaxInclude`
,`t1`.`SalesTax` AS `SalesTax`
,`t1`.`DefaultReturnPolicy` AS `DefaultReturnPolicy`
,`t1`.`IsBackdateAllowed` AS `IsBackdateAllowed`
,`t1`.`IsActive` AS `IsActive`
,`t1`.`Avatar` AS `Avatar`
,`t1`.`CreateDate` AS `CreateDate`
,`t1`.`UpdateDate` AS `UpdateDate`
,`t1`.`CategoryDesc` AS `CategoryDesc`
,`t1`.`ChannelDesc` AS `ChannelDesc`
,`t1`.`CityDesc` AS `CityDesc`
,`t1`.`GroupDesc` AS `GroupDesc`
,`t1`.`TypeDesc` AS `TypeDesc`
,`t2`.`BarCode` AS `BarCode`
,`t2`.`ProductDesc` AS `ProductDesc`
,`t2`.`SKU` AS `SKU`
,`t2`.`ItemType`
,`t2`.`Brand` AS `Brand`
,`t2`.`Category` AS `ItemCategory`
,`t2`.`LifeCycle` AS `LifeCycle`
,`t2`.`Family` AS `Family`
,`t2`.`IsSerialized` AS `IsSerialized`
,`t2`.`OrderLevel` AS `OrderLevel`
,`t2`.`StdCost` AS `StdCost`
,`t2`.`PriceList` AS `PriceList`
,`t2`.`PriceListDesc` AS `PriceListDesc`
,`t2`.`IsActive` AS `IsItemActive`
,`t2`.`TypeDesc` AS `ItemTypeDesc`
,`t2`.`BrandDesc` AS `BrandDesc`
,`t2`.`CategoryDesc` AS `ItemCategoryDesc`
,`t2`.`CycleDesc` AS `CycleDesc`
,`t2`.`FamilyDesc` AS `FamilyDesc`
,`t2`.`PDID` AS `PDID`
,`t2`.`CurrentPrice` AS `CurrentPrice`
,`t3`.`WhsName` AS `WhsName` 

from `md_inventory_serials` `t0` 
inner join `view_branches` `t1` on `t0`.`Branch` = `t1`.`BranchID`
inner join `view_items` `t2` on `t0`.`Product` = `t2`.`PID`
inner join `md_warehouses` `t3` on `t0`.`Warehouse` = `t3`.`WhsCode`;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_pullout`
--
DROP VIEW IF EXISTS `view_pullout`;
CREATE VIEW view_pullout AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.BranchEmail
,T1.Address
,T1.CategoryDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.IsTaxInclude
,T1.Avatar
,T2.DisplayName
,(SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = T0.Approver) as 'ApprovedBy'
,(SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = T0.Confirmed) as 'ConfirmedBy'
FROM trx_pullout T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_pullout_row`
--
DROP VIEW IF EXISTS `view_pullout_row`;
CREATE VIEW view_pullout_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.IsSerialized
, T2.WhsName
FROM trx_pullout_row T0
INNER JOIN md_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_purchase`
--
DROP VIEW IF EXISTS `view_purchase`;
CREATE VIEW view_purchase AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.BranchEmail
,T1.Address
,T1.CategoryDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.IsTaxInclude
,T1.Avatar
,T2.CoyName
,T2.ContactPerson
,T2.Email AS 'SupplierEmail'
,T2.BillTo
,T3.DisplayName
FROM trx_purchase T0 
INNER JOIN view_branches T1 ON T0.ShipToBranch = T1.BranchID
INNER JOIN md_supplier T2 ON T0.Supplier = T2.SuppID
INNER JOIN md_user T3 ON T0.CreatedBy = T3.UID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_purchase_row`
--
DROP VIEW IF EXISTS `view_purchase_row`;
CREATE VIEW view_purchase_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.IsSerialized
, T2.WhsName
FROM trx_purchase_row T0
INNER JOIN md_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_receiving`
--
DROP VIEW IF EXISTS `view_receiving`;
CREATE VIEW view_receiving AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.BranchEmail
,T1.Address
,T1.CategoryDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.IsTaxInclude
,T1.Avatar
,T2.DisplayName
FROM trx_receiving T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_receiving_row`
--
DROP VIEW IF EXISTS `view_receiving_row`;
CREATE VIEW view_receiving_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.IsSerialized
, T2.WhsName
FROM trx_receiving_row T0
INNER JOIN md_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_return`
--
DROP VIEW IF EXISTS `view_return`;
CREATE VIEW view_return AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.CategoryDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.Address
,T2.DisplayName
FROM trx_return T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_return_row`
--
DROP VIEW IF EXISTS `view_return_row`;
CREATE VIEW view_return_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.TypeDesc
, T1.BrandDesc
, T1.CategoryDesc
, T1.CycleDesc
, T1.FamilyDesc
, T1.IsSerialized
, T2.WhsName
FROM trx_return_row T0
INNER JOIN view_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sales`
--
DROP VIEW IF EXISTS `view_sales`;
CREATE VIEW view_sales AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.CategoryDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.Address
,T2.DisplayName
FROM trx_sales T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sales_customer`
--
DROP VIEW IF EXISTS `view_sales_customer`;
CREATE VIEW view_sales_customer AS
SELECT T0.*
, T1.CustPoints
, T1.CustCredits
FROM trx_sales_customer T0
LEFT JOIN md_customer T1 ON T0.CardNo = T1.CardNo;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sales_payments`
--
DROP VIEW IF EXISTS `view_sales_payments`;
CREATE VIEW view_sales_payments AS
SELECT T0.*
, (Select I0.RefNo From trx_sales I0 Where I0.TransID = T0.TransID) as InvoiceRef
,`T1`.`PaymentName` AS `PaymentName`
, (Select I0.BankName FROM ref_terminal I0 Where I0.BankID = T0.Terminal) as BankName
, (Select I0.BankName FROM ref_terminal I0 Where I0.BankID = T0.IssuingBank) as IssuingBankName
,`T3`.`InstDesc` AS `InstDesc` 
,`T4`.BranchCode
,`T4`.Description AS BranchDesc
FROM trx_sales_payments T0
INNER JOIN view_branches T4 ON T0.Branch = T4.BranchID
INNER JOIN ref_payment_type T1 ON T0.PaymentType = T1.PaymentId
LEFT JOIN ref_installment T3 ON T0.Installment = T3.InsId;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sales_row`
--
DROP VIEW IF EXISTS `view_sales_row`;
CREATE VIEW view_sales_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.TypeDesc
, T1.BrandDesc
, T1.CategoryDesc
, T1.CycleDesc
, T1.FamilyDesc
, T1.IsSerialized
, T2.WhsName
FROM trx_sales_row T0
INNER JOIN view_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_smr`
--
DROP VIEW IF EXISTS `view_smr`;
CREATE VIEW view_smr AS
SELECT T0.*
,T1.BranchCode
,T1.Description as BranchDesc
,T1.CategoryDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.TypeDesc
,T1.GroupDesc
,T2.BarCode
,T2.ProductDesc
,T2.SKU
,T2.BrandDesc
,T2.CategoryDesc as ItemCategory
,T2.CycleDesc
,T2.FamilyDesc
,T2.TypeDesc as ItemTypeDesc
,T2.StdCost
,T2.CurrentPrice
,T3.WhsName
FROM trx_stocks_movement T0
INNER JOIN view_branches T1 ON T0.Branch=T1.BranchID
INNER JOIN view_items T2 ON T0.Product=T2.PID
INNER JOIN md_warehouses T3 ON T0.Warehouse=T3.WhsCode;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_transfer`
--
DROP VIEW IF EXISTS `view_transfer`;
CREATE VIEW view_transfer AS
SELECT T0.*
,IF(T0.TransferType=0,(SELECT I0.Description FROM md_branches I0 WHERE I0.BranchID=T0.InvFrom),(SELECT I0.WhsName FROM md_warehouses I0 WHERE I0.WhsCode=T0.InvFrom)) as TransferFrom
,IF(T0.TransferType=0,(SELECT I0.Description FROM md_branches I0 WHERE I0.BranchID=T0.InvTo),(SELECT I0.WhsName FROM md_warehouses I0 WHERE I0.WhsCode=T0.InvTo)) as TransferTo
,IF(T0.TransferType=0,'Store Transfer','Warehouse Transfer') as TransType
,T1.BranchCode
,T1.Description
,T1.BranchEmail
,T1.Address
,T1.CategoryDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.IsTaxInclude
,T1.Avatar
,T2.DisplayName
,(SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = T0.Approver) as 'ApprovedBy'
,(SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = T0.Receiver) as 'ReceivedBy'
FROM trx_transfer T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_transfer_row`
--
DROP VIEW IF EXISTS `view_transfer_row`;
CREATE VIEW view_transfer_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.IsSerialized
, T2.WhsName
FROM trx_transfer_row T0
INNER JOIN md_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sales_postpaid`
--
DROP VIEW IF EXISTS `view_sales_postpaid`;
CREATE VIEW view_sales_postpaid AS
SELECT t0.* 
, t1.BranchCode
, t1.Description as BranchDesc
, t1.CategoryDesc
, t1.ChannelDesc
, t1.CityDesc
, t1.GroupDesc
, t1.TypeDesc
, IF(t0.Status=0,"For Activation",IF(t0.Status=1,"Activated","Cancelled")) as StatusDesc
, (SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = t0.CreatedBy) as SoldBy
FROM trx_sales_postpaid t0
INNER JOIN view_branches t1 ON t0.Branch = t1.BranchID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `report_cash_register`
--
DROP VIEW IF EXISTS `report_cash_register`;
CREATE VIEW report_cash_register AS
SELECT T0.TransDate
, T0.Branch
, T0.BranchCode
, T0.BranchDesc
, T0.IsDeposited
, T0.DepositSlip
, T0.PaymentType
, T0.PaymentName
, SUM(T0.Amount) as 'Amount'
FROM view_sales_payments T0
GROUP BY T0.TransDate
, T0.Branch
, T0.BranchCode
, T0.BranchDesc
, T0.IsDeposited
, T0.DepositSlip
, T0.PaymentType
, T0.PaymentName
HAVING (SUM(T0.Amount)!=0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `report_return`
--
DROP VIEW IF EXISTS `report_return`;
CREATE VIEW report_return AS
SELECT T0.TransID
, T0.RefNo
, WEEK(T0.TransDate) as 'Week'
, YEAR(T0.TransDate) as 'Year'
, MONTH(T0.TransDate) as 'Month'
, DAY(T0.TransDate) as 'Day'
, T0.TransDate
, T0.Branch
, T0.BranchCode
, T0.Description as 'BranchDesc'
, T0.CategoryDesc
, T0.ChannelDesc
, T0.CityDesc
, T0.GroupDesc
, T0.TypeDesc
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.TypeDesc as ItemTypeDesc
, T1.BrandDesc
, T1.CategoryDesc as ItemCategory
, T1.CycleDesc
, T1.FamilyDesc
, T1.WhsName
, T1.Quantity
, T1.Cost
, T1.Price
, T1.Subsidy
, T1.PriceAfSub
, T1.OutputTax
, T1.TaxAmount
, T1.PriceAfVat
, T1.Discount
, T1.DiscValue
, T1.Total
, T1.TotalAfSub
, T1.TotalAfVat
, T1.GTotal as TotalAfDiscount
, T1.Serial
, T1.Campaign
, T2.FullName as CustomerName
, T2.ContactNo as CustomerContactNo
, T2.Email as CustomerEmail
, T2.Address as CustomerAddress
, T0.DisplayName as 'FrontLiner'
, T0.NetTotal
, IFNULL((SELECT SUM(I0.Amount) FROM view_sales_payments I0 WHERE I0.TransID = T0.TransID and I0.PaymentType = 1),0) as CashPayment
, IFNULL((SELECT SUM(I0.Amount) FROM view_sales_payments I0 WHERE I0.TransID = T0.TransID and I0.PaymentType != 1),0) as CardPayment
FROM view_return T0
INNER JOIN view_return_row T1 ON T0.TransID = T1.TransID
INNER JOIN view_sales_customer T2 ON T0.TransID = T2.TransID;
-- --------------------------------------------------------

--
-- Stand-in structure for view `report_sales`
--
DROP VIEW IF EXISTS `report_sales`;
CREATE VIEW report_sales AS
SELECT T0.TransID
, T0.RefNo
, WEEK(T0.TransDate) as 'Week'
, YEAR(T0.TransDate) as 'Year'
, MONTH(T0.TransDate) as 'Month'
, DAY(T0.TransDate) as 'Day'
, T0.TransDate
, T0.Branch
, T0.BranchCode
, T0.Description as 'BranchDesc'
, T0.CategoryDesc
, T0.ChannelDesc
, T0.CityDesc
, T0.GroupDesc
, T0.TypeDesc
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.TypeDesc as ItemTypeDesc
, T1.BrandDesc
, T1.CategoryDesc as ItemCategory
, T1.CycleDesc
, T1.FamilyDesc
, T1.WhsName
, T1.Quantity
, T1.Cost
, T1.Price
, T1.Subsidy
, T1.PriceAfSub
, T1.OutputTax
, T1.TaxAmount
, T1.PriceAfVat
, T1.Discount
, T1.DiscValue
, T1.Total
, T1.TotalAfSub
, T1.TotalAfVat
, T1.GTotal as TotalAfDiscount
, T1.Serial
, T1.Campaign
, T2.FullName as CustomerName
, T2.ContactNo as CustomerContactNo
, T2.Email as CustomerEmail
, T2.Address as CustomerAddress
, T0.DisplayName as 'Cashier'
, T0.NetTotal
, IFNULL((SELECT SUM(I0.Amount) FROM view_sales_payments I0 WHERE I0.TransID = T0.TransID and I0.PaymentType = 1),0) as CashPayment
, IFNULL((SELECT SUM(I0.Amount) FROM view_sales_payments I0 WHERE I0.TransID = T0.TransID and I0.PaymentType != 1),0) as CardPayment
FROM view_sales T0
INNER JOIN view_sales_row T1 ON T0.TransID = T1.TransID
INNER JOIN view_sales_customer T2 ON T0.TransID = T2.TransID;

-- --------------------------------------------------------

--
-- Stand-in structure for view `report_sales_detailed`
--
DROP VIEW IF EXISTS `report_sales_detailed`;
CREATE VIEW report_sales_detailed AS
SELECT *,
IF(a.PriceAfVat < 1000, "<1000",
IF(a.PriceAfVat>1000 and a.PriceAfVat<=2499, "1,000 - 2,499",
IF(a.PriceAfVat>2499 and a.PriceAfVat<=4999, "2,499 - 4,999",
IF(a.PriceAfVat>4999 and a.PriceAfVat<=7499, "5,000 - 7,499",
IF(a.PriceAfVat>7499 and a.PriceAfVat<=9999, "7,500 - 9,999",
IF(a.PriceAfVat>9999 and a.PriceAfVat<=14999, "10,000 - 14,999",
IF(a.PriceAfVat>14999 and a.PriceAfVat<=19999, "15,000 - 19,999",
IF(a.PriceAfVat>19999 and a.PriceAfVat<=24999, "20,000 - 24,999",
"25,000 and Above")))))))) as PriceBand
, (a.TotalAfDiscount * (a.CashPayment/a.NetTotal)) as Cash_Payment
, (a.TotalAfDiscount * (a.CardPayment/a.NetTotal)) as NonCash_Payment
FROM (SELECT *,'invoice' as Module FROM `report_sales` UNION ALL
SELECT *,'return' FROM `report_return`) AS a;

-- --------------------------------------------------------

--
-- Stand-in structure for view `report_sales_summary`
--
DROP VIEW IF EXISTS `report_sales_summary`;
CREATE VIEW report_sales_summary AS
SELECT * 
FROM (SELECT *,'invoice' as Module FROM `view_sales` UNION ALL
SELECT *,'return' FROM `view_return`) AS a;

-- --------------------------------------------------------

--
-- Stand-in structure for procedure `report_smr`
--
CREATE PROCEDURE Report_SRM(IN `DateFrom` DATE, IN `DateTo` DATE)
(SELECT a.Branch, a.Product, a.Warehouse, a.BranchCode, a.BranchDesc, a.CategoryDesc, a.ChannelDesc
, a.CityDesc, a.TypeDesc, a.GroupDesc, a.BarCode, a.ProductDesc, a.SKU
, a.BrandDesc, a.ItemCategory, a.CycleDesc, a.FamilyDesc, a.ItemTypeDesc, a.WhsName
, SUM(a.Beginning) as 'Beginning', SUM(a.GRPO) as 'GRPO'
, SUM(a.Receiving) as 'Receiving', SUM(a.TransferIn) as 'TransferIn'
, SUM(a.TransferOut) as 'TransferOut', SUM(a.Sales) as 'Sales', SUM(a.Postpaid) as 'Postpaid'
, SUM(a.SalesReturn) as 'SalesReturn', SUM(a.PullOut) as 'PullOut', SUM(a.Ending) as 'Ending'
FROM (
SELECT t0.Branch, t0.Product, t0.Warehouse, t0.BranchCode, t0.BranchDesc, t0.CategoryDesc
, t0.ChannelDesc, t0.CityDesc, t0.TypeDesc, t0.GroupDesc, t0.BarCode, t0.ProductDesc, t0.SKU
, t0.BrandDesc, t0.ItemCategory, t0.CycleDesc, t0.FamilyDesc, t0.ItemTypeDesc, t0.WhsName
, SumInOut as 'Beginning', 0 as 'GRPO', 0 as 'Sales', 0 as 'Postpaid', 0 as 'SalesReturn'
, 0 as 'Receiving', 0 as 'TransferIn', 0 as 'TransferOut', 0 as 'PullOut', SumInOut as 'Ending'
FROM view_smr t0 WHERE t0.Date < DateFrom
UNION ALL
SELECT t0.Branch, t0.Product, t0.Warehouse, t0.BranchCode, t0.BranchDesc, t0.CategoryDesc
, t0.ChannelDesc, t0.CityDesc, t0.TypeDesc, t0.GroupDesc, t0.BarCode, t0.ProductDesc, t0.SKU
, t0.BrandDesc, t0.ItemCategory, t0.CycleDesc, t0.FamilyDesc, t0.ItemTypeDesc, t0.WhsName
, 0 as 'Beginning'
, IF(t0.Module='/purchase',SumInOut,0) as 'GRPO'
, IF(t0.Module='/sales' and t0.TransType='/invoice',SumInOut,0) as 'Sales'
, IF(t0.Module='/sales' and t0.TransType='/postpaid',SumInOut,0) as 'Postpaid'
, IF(t0.Module='/sales' and t0.TransType='/return',SumInOut,0) as 'Returns'
, IF(t0.Module='/stocks' and t0.TransType='/receiving',SumInOut,0) as 'Receiving'
, IF(t0.Module='/stocks' and t0.TransType='/transfer',MoveIn,0) as 'TransferIn'
, IF(t0.Module='/stocks' and t0.TransType='/transfer',MoveOut*-1,0) as 'TransferOut'
, IF(t0.Module='/stocks' and t0.TransType='/pullout',SumInOut,0) as 'PullOut'
, SumInOut as 'Ending'
FROM view_smr t0 WHERE t0.Date BETWEEN DateFrom and DateTo) as a
GROUP BY a.Branch
, a.Product, a.Warehouse, a.BranchCode, a.BranchDesc, a.CategoryDesc, a.ChannelDesc
, a.CityDesc, a.TypeDesc, a.GroupDesc, a.BarCode, a.ProductDesc, a.SKU
, a.BrandDesc, a.ItemCategory, a.CycleDesc, a.FamilyDesc, a.ItemTypeDesc, a.WhsName);

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_bom`
--
ALTER TABLE `md_bom`
  ADD PRIMARY KEY (`BoMID`);

--
-- Indexes for table `md_branches`
--
ALTER TABLE `md_branches`
  ADD PRIMARY KEY (`BranchID`),
  ADD UNIQUE KEY `BranchUnique` (`Description`),
  ADD UNIQUE KEY `UniqueCode` (`BranchCode`),
  ADD KEY `BranchIndex` (`Type`,`Category`,`Groups`,`Channel`,`City`,`Manager`);

--
-- Indexes for table `md_branchesz`
--
ALTER TABLE `md_branchesz`
  ADD PRIMARY KEY (`BranchID`),
  ADD UNIQUE KEY `BranchUnique` (`Description`),
  ADD UNIQUE KEY `UniqueCode` (`BranchCode`),
  ADD KEY `BranchIndex` (`Type`,`Category`,`Groups`,`Channel`,`City`,`Manager`);

--
-- Indexes for table `md_campaign`
--
ALTER TABLE `md_campaign`
  ADD PRIMARY KEY (`CampaignID`),
  ADD UNIQUE KEY `CampaignName` (`CampaignName`);

--
-- Indexes for table `md_customer`
--
ALTER TABLE `md_customer`
  ADD PRIMARY KEY (`CustID`),
  ADD UNIQUE KEY `CustEmail` (`CustEmail`),
  ADD UNIQUE KEY `FullName` (`CustFirstName`,`CustLastName`);

--
-- Indexes for table `md_inventory`
--
ALTER TABLE `md_inventory`
  ADD PRIMARY KEY (`InvID`),
  ADD UNIQUE KEY `UniqueFields` (`Branch`,`Product`,`Warehouse`);

--
-- Indexes for table `md_inventory_serials`
--
ALTER TABLE `md_inventory_serials`
  ADD PRIMARY KEY (`InvSerID`),
  ADD UNIQUE KEY `UniqueSerial` (`Serial`);

--
-- Indexes for table `md_items`
--
ALTER TABLE `md_items`
  ADD PRIMARY KEY (`PID`),
  ADD UNIQUE KEY `BarCode` (`BarCode`),
  ADD UNIQUE KEY `ProductDesc` (`ProductDesc`);

--
-- Indexes for table `md_supplier`
--
ALTER TABLE `md_supplier`
  ADD PRIMARY KEY (`SuppID`),
  ADD UNIQUE KEY `CoyName` (`CoyName`);

--
-- Indexes for table `md_user`
--
ALTER TABLE `md_user`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `EmailUnique` (`Email`);

--
-- Indexes for table `md_warehouses`
--
ALTER TABLE `md_warehouses`
  ADD PRIMARY KEY (`WhsCode`),
  ADD UNIQUE KEY `WhsName` (`WhsName`);

--
-- Indexes for table `ref_branch_category`
--
ALTER TABLE `ref_branch_category`
  ADD PRIMARY KEY (`CatID`);

--
-- Indexes for table `ref_branch_channel`
--
ALTER TABLE `ref_branch_channel`
  ADD PRIMARY KEY (`ChannelID`),
  ADD UNIQUE KEY `Channel` (`Channel`);

--
-- Indexes for table `ref_branch_city`
--
ALTER TABLE `ref_branch_city`
  ADD PRIMARY KEY (`CityID`),
  ADD UNIQUE KEY `City` (`City`);

--
-- Indexes for table `ref_branch_group`
--
ALTER TABLE `ref_branch_group`
  ADD PRIMARY KEY (`GroupID`),
  ADD UNIQUE KEY `Description` (`Description`);

--
-- Indexes for table `ref_branch_target`
--
ALTER TABLE `ref_branch_target`
  ADD PRIMARY KEY (`TargetID`),
  ADD UNIQUE KEY `UniqueFields` (`BranchID`,`Month`);

--
-- Indexes for table `ref_branch_type`
--
ALTER TABLE `ref_branch_type`
  ADD PRIMARY KEY (`TypeID`);

--
-- Indexes for table `ref_installment`
--
ALTER TABLE `ref_installment`
  ADD PRIMARY KEY (`InsId`),
  ADD UNIQUE KEY `InstallID` (`InstDesc`);

--
-- Indexes for table `ref_item_brand`
--
ALTER TABLE `ref_item_brand`
  ADD PRIMARY KEY (`BrandID`),
  ADD UNIQUE KEY `Description` (`Description`);

--
-- Indexes for table `ref_item_category`
--
ALTER TABLE `ref_item_category`
  ADD PRIMARY KEY (`P_CatID`),
  ADD UNIQUE KEY `Description` (`Description`);

--
-- Indexes for table `ref_item_cycle`
--
ALTER TABLE `ref_item_cycle`
  ADD PRIMARY KEY (`P_CycleID`),
  ADD UNIQUE KEY `Description` (`Description`);

--
-- Indexes for table `ref_item_family`
--
ALTER TABLE `ref_item_family`
  ADD PRIMARY KEY (`FamID`),
  ADD UNIQUE KEY `Description` (`Description`);
--
-- Indexes for table `ref_item_type`
--
ALTER TABLE `ref_item_type`
  ADD PRIMARY KEY (`TypeID`),
  ADD UNIQUE KEY `Description` (`Description`);
--
-- Indexes for table `ref_payment_type`
--
ALTER TABLE `ref_payment_type`
  ADD PRIMARY KEY (`PaymentId`),
  ADD UNIQUE KEY `UniquePayment` (`PaymentName`);

--
-- Indexes for table `ref_points`
--
ALTER TABLE `ref_points`
  ADD PRIMARY KEY (`PointID`);

--
-- Indexes for table `ref_province`
--
ALTER TABLE `ref_province`
  ADD PRIMARY KEY (`ProvinceID`),
  ADD UNIQUE KEY `City` (`Province`);

--
-- Indexes for table `ref_terminal`
--
ALTER TABLE `ref_terminal`
  ADD PRIMARY KEY (`BankID`),
  ADD UNIQUE KEY `BankName` (`BankName`);

--
-- Indexes for table `ref_user_branch`
--
ALTER TABLE `ref_user_branch`
  ADD PRIMARY KEY (`UserBranchID`),
  ADD UNIQUE KEY `UniqueFields` (`UserID`,`BranchID`);

--
-- Indexes for table `ref_user_target`
--
ALTER TABLE `ref_user_target`
  ADD PRIMARY KEY (`UsrTargetID`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexes for table `stp_bom_item`
--
ALTER TABLE `stp_bom_item`
  ADD PRIMARY KEY (`BoMSID`),
  ADD UNIQUE KEY `UniqueFields` (`BoMID`,`PID`,`WhsCode`);

--
-- Indexes for table `stp_campaign_branch`
--
ALTER TABLE `stp_campaign_branch`
  ADD PRIMARY KEY (`CpBrnID`),
  ADD UNIQUE KEY `UniqueFields` (`CampaignID`,`BranchID`);

--
-- Indexes for table `stp_campaign_item`
--
ALTER TABLE `stp_campaign_item`
  ADD PRIMARY KEY (`CpItemID`),
  ADD UNIQUE KEY `UniqueFields` (`CampaignID`,`PID`);

--
-- Indexes for table `stp_config`
--
ALTER TABLE `stp_config`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `stp_item_pricedetails`
--
ALTER TABLE `stp_item_pricedetails`
  ADD PRIMARY KEY (`PDID`),
  ADD UNIQUE KEY `IndexFields` (`PLID`,`PID`),
  ADD UNIQUE KEY `UniqueFields` (`PLID`,`PID`),
  ADD KEY `PID` (`PID`);

--
-- Indexes for table `stp_item_pricelist`
--
ALTER TABLE `stp_item_pricelist`
  ADD PRIMARY KEY (`PLID`);

--
-- Indexes for table `trx_pullout`
--
ALTER TABLE `trx_pullout`
  ADD PRIMARY KEY (`PullID`,`TransID`),
  ADD UNIQUE KEY `TransID` (`TransID`);

--
-- Indexes for table `trx_pullout_row`
--
ALTER TABLE `trx_pullout_row`
  ADD PRIMARY KEY (`PullRowID`);

--
-- Indexes for table `trx_purchase`
--
ALTER TABLE `trx_purchase`
  ADD PRIMARY KEY (`PurID`,`TransID`),
  ADD UNIQUE KEY `TransID` (`TransID`);

--
-- Indexes for table `trx_purchase_row`
--
ALTER TABLE `trx_purchase_row`
  ADD PRIMARY KEY (`PurRowID`);

--
-- Indexes for table `trx_receiving`
--
ALTER TABLE `trx_receiving`
  ADD PRIMARY KEY (`RcvID`,`TransID`),
  ADD UNIQUE KEY `TransID` (`TransID`);

--
-- Indexes for table `trx_receiving_row`
--
ALTER TABLE `trx_receiving_row`
  ADD PRIMARY KEY (`RcvRowID`);

--
-- Indexes for table `trx_return`
--
ALTER TABLE `trx_return`
  ADD PRIMARY KEY (`SalesID`,`TransID`),
  ADD UNIQUE KEY `TransID` (`TransID`);

--
-- Indexes for table `trx_return_row`
--
ALTER TABLE `trx_return_row`
  ADD PRIMARY KEY (`SalesRowID`);

--
-- Indexes for table `trx_sales`
--
ALTER TABLE `trx_sales`
  ADD PRIMARY KEY (`SalesID`,`TransID`),
  ADD UNIQUE KEY `TransID` (`TransID`);

--
-- Indexes for table `trx_sales_customer`
--
ALTER TABLE `trx_sales_customer`
  ADD PRIMARY KEY (`SalesCustID`);

--
-- Indexes for table `trx_sales_payments`
--
ALTER TABLE `trx_sales_payments`
  ADD PRIMARY KEY (`SalesPayID`);

--
-- Indexes for table `trx_sales_row`
--
ALTER TABLE `trx_sales_row`
  ADD PRIMARY KEY (`SalesRowID`);

--
-- Indexes for table `trx_stocks_movement`
--
ALTER TABLE `trx_stocks_movement`
  ADD PRIMARY KEY (`SmrID`);

--
-- Indexes for table `trx_transfer`
--
ALTER TABLE `trx_transfer`
  ADD PRIMARY KEY (`TrfID`,`TransID`),
  ADD UNIQUE KEY `TransID` (`TransID`);

--
-- Indexes for table `trx_transfer_row`
--
ALTER TABLE `trx_transfer_row`
  ADD PRIMARY KEY (`TrfRowID`);

--
-- Indexes for table `trx_sales_postpaid`
--
ALTER TABLE `trx_sales_postpaid`
  ADD PRIMARY KEY (`PostpaidID`);

--
-- Indexes for table `ref_branch_series`
--
ALTER TABLE `ref_branch_series`
  ADD PRIMARY KEY (`SeriesID`),
  ADD UNIQUE KEY `Branch` (`Branch`);


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `md_bom`
--
ALTER TABLE `md_bom`
  MODIFY `BoMID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `md_branches`
--
ALTER TABLE `md_branches`
  MODIFY `BranchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `md_branchesz`
--
ALTER TABLE `md_branchesz`
  MODIFY `BranchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `md_campaign`
--
ALTER TABLE `md_campaign`
  MODIFY `CampaignID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `md_customer`
--
ALTER TABLE `md_customer`
  MODIFY `CustID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `md_inventory`
--
ALTER TABLE `md_inventory`
  MODIFY `InvID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `md_inventory_serials`
--
ALTER TABLE `md_inventory_serials`
  MODIFY `InvSerID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `md_items`
--
ALTER TABLE `md_items`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `md_supplier`
--
ALTER TABLE `md_supplier`
  MODIFY `SuppID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `md_user`
--
ALTER TABLE `md_user`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `md_warehouses`
--
ALTER TABLE `md_warehouses`
  MODIFY `WhsCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ref_branch_category`
--
ALTER TABLE `ref_branch_category`
  MODIFY `CatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ref_branch_channel`
--
ALTER TABLE `ref_branch_channel`
  MODIFY `ChannelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `ref_branch_city`
--
ALTER TABLE `ref_branch_city`
  MODIFY `CityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1416;
--
-- AUTO_INCREMENT for table `ref_branch_group`
--
ALTER TABLE `ref_branch_group`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ref_branch_target`
--
ALTER TABLE `ref_branch_target`
  MODIFY `TargetID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_branch_type`
--
ALTER TABLE `ref_branch_type`
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ref_installment`
--
ALTER TABLE `ref_installment`
  MODIFY `InsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `ref_item_brand`
--
ALTER TABLE `ref_item_brand`
  MODIFY `BrandID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_item_category`
--
ALTER TABLE `ref_item_category`
  MODIFY `P_CatID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_item_cycle`
--
ALTER TABLE `ref_item_cycle`
  MODIFY `P_CycleID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_item_family`
--
ALTER TABLE `ref_item_family`
  MODIFY `FamID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_item_type`
--
ALTER TABLE `ref_item_type`
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_payment_type`
--
ALTER TABLE `ref_payment_type`
  MODIFY `PaymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ref_points`
--
ALTER TABLE `ref_points`
  MODIFY `PointID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_province`
--
ALTER TABLE `ref_province`
  MODIFY `ProvinceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `ref_terminal`
--
ALTER TABLE `ref_terminal`
  MODIFY `BankID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_user_branch`
--
ALTER TABLE `ref_user_branch`
  MODIFY `UserBranchID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_user_target`
--
ALTER TABLE `ref_user_target`
  MODIFY `UsrTargetID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stp_bom_item`
--
ALTER TABLE `stp_bom_item`
  MODIFY `BoMSID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stp_campaign_branch`
--
ALTER TABLE `stp_campaign_branch`
  MODIFY `CpBrnID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stp_campaign_item`
--
ALTER TABLE `stp_campaign_item`
  MODIFY `CpItemID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stp_config`
--
ALTER TABLE `stp_config`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stp_item_pricedetails`
--
ALTER TABLE `stp_item_pricedetails`
  MODIFY `PDID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stp_item_pricelist`
--
ALTER TABLE `stp_item_pricelist`
  MODIFY `PLID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_pullout`
--
ALTER TABLE `trx_pullout`
  MODIFY `PullID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_pullout_row`
--
ALTER TABLE `trx_pullout_row`
  MODIFY `PullRowID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_purchase`
--
ALTER TABLE `trx_purchase`
  MODIFY `PurID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_purchase_row`
--
ALTER TABLE `trx_purchase_row`
  MODIFY `PurRowID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_receiving`
--
ALTER TABLE `trx_receiving`
  MODIFY `RcvID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_receiving_row`
--
ALTER TABLE `trx_receiving_row`
  MODIFY `RcvRowID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_return`
--
ALTER TABLE `trx_return`
  MODIFY `SalesID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_return_row`
--
ALTER TABLE `trx_return_row`
  MODIFY `SalesRowID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_sales`
--
ALTER TABLE `trx_sales`
  MODIFY `SalesID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_sales_customer`
--
ALTER TABLE `trx_sales_customer`
  MODIFY `SalesCustID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_sales_payments`
--
ALTER TABLE `trx_sales_payments`
  MODIFY `SalesPayID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_sales_row`
--
ALTER TABLE `trx_sales_row`
  MODIFY `SalesRowID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_stocks_movement`
--
ALTER TABLE `trx_stocks_movement`
  MODIFY `SmrID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_transfer`
--
ALTER TABLE `trx_transfer`
  MODIFY `TrfID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_transfer_row`
--
ALTER TABLE `trx_transfer_row`
  MODIFY `TrfRowID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trx_sales_postpaid`
--
ALTER TABLE `trx_sales_postpaid`
  MODIFY `PostpaidID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ref_branch_series`
--
ALTER TABLE `ref_branch_series`
  MODIFY `SeriesID` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
