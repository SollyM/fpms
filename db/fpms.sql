-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2018 at 07:43 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `luckymogen_fpms`
--
CREATE DATABASE IF NOT EXISTS `luckymogen_fpms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `luckymogen_fpms`;

-- --------------------------------------------------------

--
-- Table structure for table `lnkpersonpolicies`
--

DROP TABLE IF EXISTS `lnkpersonpolicies`;
CREATE TABLE IF NOT EXISTS `lnkpersonpolicies` (
  `PersonPolicyId` int(11) NOT NULL,
  `PolicyId` int(11) NOT NULL,
  `PersonId` int(11) NOT NULL,
  `PersonTypeId` int(11) NOT NULL,
  `RelationshipId` int(11) NOT NULL,
  `DateAdded` date DEFAULT NULL,
  `DateRemoved` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `lnkpersonpolicies`:
--   `PersonId`
--       `tblpersons` -> `PersonId`
--

--
-- Dumping data for table `lnkpersonpolicies`
--

INSERT INTO `lnkpersonpolicies` (`PersonPolicyId`, `PolicyId`, `PersonId`, `PersonTypeId`, `RelationshipId`, `DateAdded`, `DateRemoved`) VALUES
(1, 1, 1, 1, 1, '2017-11-15', NULL),
(2, 1, 2, 2, 1, '2017-11-15', NULL),
(5, 2, 12, 1, 0, '2017-11-24', NULL),
(6, 4, 13, 1, 0, '2017-11-24', NULL),
(7, 5, 14, 1, 0, '2017-11-28', NULL),
(8, 1, 15, 3, 0, '2017-12-07', NULL),
(9, 6, 16, 1, 0, '2017-12-11', NULL),
(10, 7, 17, 1, 0, '2017-12-11', NULL),
(11, 7, 18, 3, 0, '2017-12-11', NULL),
(13, 7, 20, 4, 0, '2017-12-11', NULL),
(14, 7, 21, 4, 0, '2017-12-11', NULL),
(15, 8, 22, 1, 0, '2017-12-11', NULL),
(16, 8, 23, 2, 0, '2017-12-11', NULL),
(17, 8, 24, 3, 0, '2017-12-11', NULL),
(18, 9, 25, 1, 0, '2017-12-11', NULL),
(19, 10, 26, 1, 0, '2017-12-11', NULL),
(20, 11, 27, 1, 0, '2017-12-11', NULL),
(21, 11, 28, 2, 0, '2017-12-11', NULL),
(22, 12, 29, 1, 0, '2017-12-11', NULL),
(23, 12, 30, 2, 0, '2017-12-11', NULL),
(24, 13, 31, 1, 0, '2017-12-14', NULL),
(25, 7, 32, 3, 0, '2017-12-17', NULL),
(26, 14, 33, 1, 1, '2018-01-10', NULL),
(29, 14, 36, 2, 1, '2018-01-11', NULL),
(30, 14, 37, 3, 3, '2018-01-11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `refactions`
--

DROP TABLE IF EXISTS `refactions`;
CREATE TABLE IF NOT EXISTS `refactions` (
  `ActionId` int(11) NOT NULL,
  `ActionName` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `refactions`:
--

--
-- Dumping data for table `refactions`
--

INSERT INTO `refactions` (`ActionId`, `ActionName`) VALUES
(1, 'Create'),
(3, 'Delete'),
(5, 'Remove'),
(4, 'Undelete'),
(2, 'Update');

-- --------------------------------------------------------

--
-- Table structure for table `refpersontypes`
--

DROP TABLE IF EXISTS `refpersontypes`;
CREATE TABLE IF NOT EXISTS `refpersontypes` (
  `PersonTypeId` int(11) NOT NULL,
  `PersonType` varchar(255) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'0',
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `refpersontypes`:
--

--
-- Dumping data for table `refpersontypes`
--

INSERT INTO `refpersontypes` (`PersonTypeId`, `PersonType`, `IsActive`, `CreatedBy`, `CreatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(1, 'Policy Holder', b'0', NULL, NULL, NULL, NULL),
(2, 'Spouse', b'0', NULL, NULL, NULL, NULL),
(3, 'Dependant', b'1', NULL, NULL, NULL, NULL),
(4, 'Additional Dependant', b'1', NULL, NULL, NULL, NULL),
(6, 'Test 1', b'0', 270045, '2018-01-07 21:13:04', 270045, '2018-01-11 14:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `refrelationships`
--

DROP TABLE IF EXISTS `refrelationships`;
CREATE TABLE IF NOT EXISTS `refrelationships` (
  `RelationshipId` int(11) NOT NULL,
  `Relationship` varchar(100) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'0',
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `refrelationships`:
--

--
-- Dumping data for table `refrelationships`
--

INSERT INTO `refrelationships` (`RelationshipId`, `Relationship`, `IsActive`, `CreatedBy`, `CreatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(1, 'Spouse', b'1', 270045, '2018-01-07 22:15:09', NULL, NULL),
(3, 'Child', b'1', 270045, '2018-01-07 22:27:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `refroles`
--

DROP TABLE IF EXISTS `refroles`;
CREATE TABLE IF NOT EXISTS `refroles` (
  `RoleId` int(11) NOT NULL,
  `RoleName` varchar(255) NOT NULL,
  `Priority` int(11) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'0',
  `ActiveFrom` datetime DEFAULT NULL,
  `ActiveTo` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `refroles`:
--

--
-- Dumping data for table `refroles`
--

INSERT INTO `refroles` (`RoleId`, `RoleName`, `Priority`, `IsActive`, `ActiveFrom`, `ActiveTo`, `CreatedBy`, `CreatedDate`, `ModifiedBy`, `ModifiedDate`, `DeletedBy`, `DeletedDate`) VALUES
(1, 'Unallocated User', 1, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Branch User', 1000, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Branch Admin', 1100, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 270045, '2018-01-16 11:55:13'),
(13, 'Company User', 2000, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Company Admin', 2100, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'Super Admin', 9000, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 'Developer', 9999, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 'Lucky User', 8000, b'1', NULL, NULL, 270045, '2018-01-16 17:02:32', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reftitles`
--

DROP TABLE IF EXISTS `reftitles`;
CREATE TABLE IF NOT EXISTS `reftitles` (
  `TitleId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `reftitles`:
--

--
-- Dumping data for table `reftitles`
--

INSERT INTO `reftitles` (`TitleId`, `Title`, `IsActive`, `CreatedBy`, `CreatedDate`, `DeletedBy`, `DeletedDate`) VALUES
(1, 'Mr', b'1', NULL, NULL, NULL, NULL),
(2, 'Miss (Unmarried)', b'1', NULL, NULL, NULL, NULL),
(3, 'Mrs (Married)', b'1', NULL, NULL, NULL, NULL),
(4, 'Doctor', b'1', NULL, NULL, NULL, NULL),
(5, 'Pastor/Reverend/Father', b'1', NULL, NULL, NULL, NULL),
(6, 'Professor', b'1', NULL, NULL, NULL, NULL),
(9, 'Test', b'0', NULL, NULL, 270045, '2018-01-10 23:22:17'),
(10, 'Test 2', b'0', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoices`
--

DROP TABLE IF EXISTS `tblinvoices`;
CREATE TABLE IF NOT EXISTS `tblinvoices` (
  `InvoiceId` int(11) NOT NULL,
  `PolicyId` int(11) NOT NULL,
  `InvoiceNumber` varchar(255) NOT NULL,
  `InvoiceDate` date NOT NULL,
  `TotalAmount` double(10,2) NOT NULL,
  `RaisedBy` int(11) NOT NULL,
  `RaisedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `tblinvoices`:
--   `PolicyId`
--       `tblpolicies` -> `PolicyId`
--   `RaisedBy`
--       `tblusers` -> `id`
--

--
-- Dumping data for table `tblinvoices`
--

INSERT INTO `tblinvoices` (`InvoiceId`, `PolicyId`, `InvoiceNumber`, `InvoiceDate`, `TotalAmount`, `RaisedBy`, `RaisedDate`, `DeletedBy`, `DeletedDate`) VALUES
(1, 1, '1234567890', '2017-12-01', 150.00, 270045, '2017-12-07 07:21:48', NULL, NULL),
(3, 5, '1223434', '2017-12-01', 98.00, 270045, '2017-12-09 16:46:32', NULL, NULL),
(4, 6, 'INV5256', '2017-12-01', 185.00, 270045, '2017-12-11 14:59:40', NULL, NULL),
(5, 7, 'INV52542/3', '2018-01-01', 130.00, 270045, '2017-12-11 15:44:46', NULL, NULL),
(6, 11, 'INV15151', '2017-12-01', 185.50, 270045, '2017-12-11 19:32:40', NULL, NULL),
(8, 12, 'INV534543', '2018-02-01', 126.00, 270045, '2017-12-11 19:47:55', NULL, NULL),
(9, 12, 'INV534544', '2018-03-01', 126.00, 270045, '2017-12-11 19:48:18', NULL, NULL),
(10, 12, 'INV534545', '2018-04-01', 126.00, 270045, '2017-12-11 19:49:31', NULL, NULL),
(11, 12, 'INV534546', '2018-05-01', 126.00, 270045, '2017-12-11 19:50:59', NULL, NULL),
(12, 12, 'INV534547', '2018-06-01', 126.00, 270045, '2017-12-11 19:51:18', NULL, NULL),
(13, 12, 'INV534548', '2018-07-01', 126.00, 270045, '2017-12-11 19:53:50', NULL, NULL),
(14, 12, 'INV534549', '2018-08-01', 126.00, 270045, '2017-12-11 19:53:50', NULL, NULL),
(15, 12, 'INV534550', '2018-09-01', 126.00, 270045, '2017-12-11 19:53:50', NULL, NULL),
(16, 12, 'INV534551', '2018-10-01', 126.00, 270045, '2017-12-11 19:53:50', NULL, NULL),
(17, 12, 'INV534552', '2018-11-01', 126.00, 270045, '2017-12-11 19:55:00', NULL, NULL),
(18, 2, 'INV52542/1/2', '2017-12-01', 185.00, 270045, '2017-12-12 00:13:49', NULL, NULL),
(19, 13, 'INV6546', '2017-12-01', 380.00, 270045, '2017-12-14 11:06:12', NULL, NULL),
(21, 9, 'INV867896', '2018-01-01', 126.00, 270045, '2018-01-04 23:41:06', NULL, NULL),
(22, 7, 'INV66965', '2018-01-01', 126.00, 270045, '2018-01-08 12:12:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbllog`
--

DROP TABLE IF EXISTS `tbllog`;
CREATE TABLE IF NOT EXISTS `tbllog` (
  `LogId` int(11) NOT NULL,
  `TableName` varchar(100) NOT NULL,
  `TableId` int(11) NOT NULL,
  `ActionId` int(11) NOT NULL,
  `ActionBy` int(11) NOT NULL,
  `ActionDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=293 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `tbllog`:
--

--
-- Dumping data for table `tbllog`
--

INSERT INTO `tbllog` (`LogId`, `TableName`, `TableId`, `ActionId`, `ActionBy`, `ActionDate`) VALUES
(5, 'tblPolicyPlans', 9, 1, 270045, '2018-01-04 11:01:35'),
(6, 'tblPolicyPlans', 9, 3, 270045, '2018-01-04 11:01:59'),
(7, 'tblpolicyplans', 9, 4, 270045, '2018-01-04 13:01:19'),
(8, 'tblpolicyplans', 9, 4, 270045, '2018-01-04 13:01:59'),
(9, 'tblPolicyPlans', 9, 2, 0, '2018-01-04 15:01:31'),
(10, 'tblPolicyPlans', 9, 2, 0, '2018-01-04 15:01:14'),
(11, 'tblpolicyplans', 9, 3, 270045, '2018-01-04 15:01:50'),
(12, 'tblpolicyplans', 9, 4, 270045, '2018-01-04 15:01:59'),
(13, 'tblpolicyplans', 9, 3, 270045, '2018-01-04 15:01:18'),
(14, 'tblpolicyplans', 9, 4, 270045, '2018-01-04 15:01:02'),
(15, 'tblpolicyplans', 9, 3, 270045, '2018-01-04 15:01:09'),
(16, 'tblpolicyplans', 9, 4, 270045, '2018-01-04 15:01:19'),
(17, 'tblPolicyPlans', 9, 2, 270045, '2018-01-04 15:01:32'),
(18, 'tblInvoice', 20, 2, 270045, '2018-01-04 20:01:10'),
(19, 'tblInvoice', 20, 2, 270045, '2018-01-04 20:01:43'),
(20, 'tblInvoice', 20, 2, 270045, '2018-01-04 20:01:55'),
(21, 'tblInvoice', 18, 2, 270045, '2018-01-04 20:01:13'),
(22, 'tblInvoice', 18, 2, 270045, '2018-01-04 20:01:03'),
(23, 'tblInvoices', 21, 1, 270045, '2018-01-04 20:01:06'),
(24, 'tblInvoice', 21, 2, 270045, '2018-01-04 22:01:07'),
(25, 'tblpolicyplans', 9, 3, 270045, '2018-01-06 17:01:10'),
(26, 'refRoles', 91, 1, 270045, '2018-01-07 10:01:40'),
(27, 'refRoles', 91, 1, 270045, '2018-01-07 10:01:54'),
(28, 'refRoles', 91, 1, 270045, '2018-01-07 10:01:02'),
(29, 'refRoles', 94, 1, 270045, '2018-01-07 13:01:52'),
(30, 'refRoles', 94, 3, 270045, '2018-01-07 13:01:39'),
(31, 'refRoles', 94, 3, 270045, '2018-01-07 13:01:16'),
(32, 'refRoles', 92, 3, 270045, '2018-01-07 13:01:28'),
(33, 'refRoles', 91, 3, 270045, '2018-01-07 13:01:39'),
(34, 'refRoles', 94, 5, 270045, '2018-01-07 14:01:08'),
(35, 'refRoles', 92, 4, 270045, '2018-01-07 14:01:35'),
(36, 'refRoles', 92, 3, 270045, '2018-01-07 14:01:41'),
(37, 'refRoles', 92, 5, 270045, '2018-01-07 14:01:45'),
(38, 'refRoles', 91, 5, 270045, '2018-01-07 14:01:48'),
(39, 'refRoles', 7, 2, 270045, '2018-01-07 14:01:08'),
(40, 'refTitles', 4, 2, 270045, '2018-01-07 15:01:26'),
(41, 'refTitles', 11, 1, 270045, '2018-01-07 16:01:17'),
(42, 'refTitles', 11, 2, 270045, '2018-01-07 16:01:25'),
(43, 'refTitles', 11, 2, 270045, '2018-01-07 16:01:09'),
(44, 'refTitles', 11, 2, 270045, '2018-01-07 16:01:16'),
(45, 'refTitles', 11, 3, 270045, '2018-01-07 16:01:23'),
(46, 'refTitles', 10, 3, 270045, '2018-01-07 16:01:22'),
(47, 'refTitles', 9, 3, 270045, '2018-01-07 16:01:28'),
(48, 'refTitles', 11, 4, 270045, '2018-01-07 17:01:37'),
(49, 'refTitles', 10, 4, 270045, '2018-01-07 17:01:43'),
(50, 'refTitles', 9, 4, 270045, '2018-01-07 17:01:47'),
(51, 'refTitles', 11, 2, 270045, '2018-01-07 17:01:53'),
(52, 'refTitles', 11, 3, 270045, '2018-01-07 17:01:17'),
(53, 'refTitles', 11, 5, 270045, '2018-01-07 17:01:03'),
(54, 'refTitles', 10, 3, 270045, '2018-01-07 17:01:56'),
(55, 'refPersonTypes', 5, 2, 270045, '2018-01-07 17:01:55'),
(56, 'refPersonTypes', 5, 2, 270045, '2018-01-07 17:01:06'),
(57, 'refPersonTypes', 5, 3, 270045, '2018-01-07 17:01:06'),
(58, 'refPersonTypes', 5, 4, 270045, '2018-01-07 17:01:50'),
(59, 'refPersonTypes', 5, 2, 270045, '2018-01-07 18:01:12'),
(60, 'refPersonTypes', 6, 1, 270045, '2018-01-07 18:01:04'),
(61, 'refPersonTypes', 5, 3, 270045, '2018-01-07 18:01:39'),
(62, 'refPersonTypes', 5, 5, 270045, '2018-01-07 18:01:52'),
(63, 'refRoles', 95, 1, 270045, '2018-01-07 18:01:14'),
(64, 'refRoles', 95, 3, 270045, '2018-01-07 18:01:29'),
(65, 'refRoles', 95, 5, 270045, '2018-01-07 18:01:32'),
(66, 'tblpolicyplans', 8, 4, 270045, '2018-01-07 18:01:24'),
(67, 'tblpolicyplans', 9, 4, 270045, '2018-01-07 18:01:50'),
(68, 'tblpolicyplans', 9, 3, 270045, '2018-01-07 18:01:54'),
(69, 'tblpolicyplans', 9, 4, 270045, '2018-01-07 18:01:34'),
(70, 'tblPolicyPlans', 9, 2, 270045, '2018-01-07 18:01:50'),
(71, 'tblPolicyPlans', 9, 2, 270045, '2018-01-07 18:01:48'),
(72, 'tblPolicyPlans', 10, 1, 270045, '2018-01-07 18:01:37'),
(73, 'tblPolicyPlans', 10, 2, 270045, '2018-01-07 18:01:04'),
(74, 'refRoles', 1, 2, 270045, '2018-01-07 18:01:59'),
(75, 'refTitles', 10, 2, 270045, '2018-01-07 18:01:13'),
(76, 'refTitles', 10, 4, 270045, '2018-01-07 18:01:42'),
(77, 'refTitles', 10, 2, 270045, '2018-01-07 18:01:52'),
(78, 'refPersonTypes', 6, 2, 270045, '2018-01-07 18:01:23'),
(79, 'tblpolicyplans', 10, 3, 270045, '2018-01-07 18:01:46'),
(80, 'tblpolicyplans', 10, 5, 270045, '2018-01-07 18:01:33'),
(81, 'refRelationships', 1, 1, 270045, '2018-01-07 19:01:09'),
(82, 'refRelationships', 2, 1, 270045, '2018-01-07 19:01:56'),
(83, 'refRelationships', 2, 2, 270045, '2018-01-07 19:01:04'),
(84, 'refRelationships', 2, 2, 270045, '2018-01-07 19:01:36'),
(85, 'refRelationships', 2, 3, 270045, '2018-01-07 19:01:54'),
(86, 'refRelationships', 2, 4, 270045, '2018-01-07 19:01:04'),
(87, 'refRelationships', 2, 3, 270045, '2018-01-07 19:01:30'),
(88, 'refRelationships', 2, 5, 270045, '2018-01-07 19:01:35'),
(89, 'refRelationships', 3, 1, 270045, '2018-01-07 19:01:44'),
(90, 'tblInvoices', 18, 2, 270045, '2018-01-08 09:01:22'),
(91, 'tblInvoices', 22, 1, 270045, '2018-01-08 09:01:51'),
(92, 'tblInvoices', 18, 3, 270045, '2018-01-08 09:01:19'),
(93, 'tblInvoices', 20, 3, 270045, '2018-01-08 10:01:47'),
(94, 'tblInvoices', 18, 4, 270045, '2018-01-08 12:01:44'),
(95, 'tblInvoices', 20, 5, 270045, '2018-01-08 12:01:59'),
(96, 'tblInvoices', 18, 3, 270045, '2018-01-08 12:01:44'),
(97, 'tblInvoices', 18, 4, 270045, '2018-01-08 12:01:02'),
(98, 'tblpayments', 18, 1, 270045, '2018-01-09 07:01:41'),
(99, 'tblpayments', 18, 2, 270045, '2018-01-09 07:01:05'),
(100, 'tblpayments', 18, 3, 270045, '2018-01-09 08:01:05'),
(101, 'tblpayments', 18, 4, 270045, '2018-01-09 09:01:42'),
(102, 'tblpayments', 18, 3, 270045, '2018-01-09 09:01:40'),
(103, 'tblpayments', 18, 4, 270045, '2018-01-09 09:01:54'),
(104, 'tblpayments', 18, 3, 270045, '2018-01-09 09:01:13'),
(105, 'tblpayments', 18, 5, 270045, '2018-01-09 09:01:18'),
(106, 'tblpolicyplans', 9, 3, 270045, '2018-01-10 09:01:20'),
(107, 'tblpolicies', 14, 1, 270045, '2018-01-10 09:01:39'),
(131, 'tblpolicies', 14, 1, 270045, '2018-01-10 17:01:09'),
(132, 'lnkPersonPolicies', 26, 1, 270045, '2018-01-10 17:01:09'),
(133, 'tblpolicies', 14, 1, 270045, '2018-01-10 17:01:31'),
(134, 'tblPersons', 33, 2, 0, '2018-01-10 17:01:31'),
(135, 'tblpolicies', 14, 1, 270045, '2018-01-10 20:01:36'),
(136, 'tblPersons', 33, 2, 0, '2018-01-10 20:01:36'),
(137, 'tblpolicies', 14, 1, 270045, '2018-01-10 20:01:22'),
(138, 'tblPersons', 33, 2, 0, '2018-01-10 20:01:22'),
(139, 'tblpolicies', 14, 1, 270045, '2018-01-10 20:01:03'),
(140, 'tblPersons', 33, 2, 0, '2018-01-10 20:01:03'),
(141, 'tblpolicies', 14, 1, 270045, '2018-01-10 20:01:33'),
(142, 'tblPersons', 33, 2, 0, '2018-01-10 20:01:33'),
(143, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-10 20:01:33'),
(144, 'tblpolicies', 14, 1, 270045, '2018-01-10 20:01:32'),
(145, 'tblPersons', 34, 1, 270045, '2018-01-10 20:01:33'),
(146, 'lnkPersonPolicies', 27, 1, 270045, '2018-01-10 20:01:33'),
(147, 'refTitles', 9, 3, 270045, '2018-01-10 20:01:17'),
(148, 'tblpolicies', 14, 1, 270045, '2018-01-10 20:01:00'),
(149, 'tblPersons', 33, 2, 0, '2018-01-10 20:01:00'),
(150, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-10 20:01:00'),
(151, 'tblpolicies', 14, 1, 270045, '2018-01-11 06:01:20'),
(152, 'tblPersons', 35, 1, 270045, '2018-01-11 06:01:20'),
(153, 'lnkPersonPolicies', 28, 1, 270045, '2018-01-11 06:01:21'),
(154, 'tblpolicies', 14, 1, 270045, '2018-01-11 07:01:32'),
(155, 'tblPersons', 33, 2, 270045, '2018-01-11 07:01:32'),
(156, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-11 07:01:33'),
(157, 'tblPersons', 36, 1, 270045, '2018-01-11 07:01:33'),
(158, 'lnkPersonPolicies', 29, 1, 270045, '2018-01-11 07:01:33'),
(159, 'tblpolicies', 14, 1, 270045, '2018-01-11 10:01:31'),
(160, 'tblPersons', 33, 2, 270045, '2018-01-11 10:01:31'),
(161, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-11 10:01:31'),
(162, 'tblPersons', 36, 2, 270045, '2018-01-11 10:01:31'),
(163, 'lnkPersonPolicies', 29, 2, 270045, '2018-01-11 10:01:31'),
(164, 'refPersonTypes', 6, 3, 270045, '2018-01-11 11:01:40'),
(165, 'tblpolicies', 14, 1, 270045, '2018-01-11 13:01:01'),
(166, 'tblPersons', 33, 2, 270045, '2018-01-11 13:01:01'),
(167, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-11 13:01:01'),
(168, 'tblpolicies', 14, 1, 270045, '2018-01-11 13:01:45'),
(169, 'tblPersons', 33, 2, 270045, '2018-01-11 13:01:46'),
(170, 'tblpolicies', 14, 1, 270045, '2018-01-11 13:01:21'),
(171, 'tblPersons', 33, 2, 270045, '2018-01-11 13:01:21'),
(172, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-11 13:01:21'),
(173, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:39'),
(174, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:22'),
(175, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:24'),
(176, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:36'),
(177, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:43'),
(178, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:16'),
(179, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:26'),
(180, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:48'),
(181, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:49'),
(182, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:56'),
(183, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:36'),
(184, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:08'),
(185, 'tblpolicies', 14, 1, 270045, '2018-01-15 07:01:52'),
(186, 'tblpolicies', 14, 1, 270045, '2018-01-15 08:01:15'),
(187, 'tblpolicies', 14, 1, 270045, '2018-01-15 08:01:24'),
(188, 'tblpolicies', 14, 1, 270045, '2018-01-15 08:01:53'),
(189, 'tblPersons', 33, 2, 270045, '2018-01-15 08:01:53'),
(190, 'tblpolicies', 14, 1, 270045, '2018-01-15 08:01:32'),
(191, 'tblPersons', 33, 2, 270045, '2018-01-15 08:01:32'),
(192, 'tblpolicies', 14, 1, 270045, '2018-01-15 10:01:18'),
(193, 'tblPersons', 33, 2, 270045, '2018-01-15 10:01:19'),
(194, 'lnkPersonPolicies', 32, 1, 270045, '2018-01-15 10:01:19'),
(195, 'tblpolicies', 14, 1, 270045, '2018-01-15 10:01:45'),
(196, 'tblPersons', 33, 2, 270045, '2018-01-15 10:01:45'),
(197, 'tblpolicies', 14, 1, 270045, '2018-01-15 10:01:26'),
(198, 'tblPersons', 33, 2, 270045, '2018-01-15 10:01:26'),
(199, 'tblpolicies', 14, 1, 270045, '2018-01-15 10:01:36'),
(200, 'tblPersons', 33, 2, 270045, '2018-01-15 10:01:36'),
(201, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:40'),
(202, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:40'),
(203, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:03'),
(204, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:03'),
(205, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:55'),
(206, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:55'),
(207, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:40'),
(208, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:40'),
(209, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:03'),
(210, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:03'),
(211, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:13'),
(212, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:13'),
(213, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:19'),
(214, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:57'),
(215, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:04'),
(216, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:04'),
(217, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:18'),
(218, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:18'),
(219, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:32'),
(220, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:33'),
(221, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:49'),
(222, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:49'),
(223, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:03'),
(224, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:03'),
(225, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:14'),
(226, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:14'),
(227, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:16'),
(228, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:16'),
(229, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:23'),
(230, 'tblPersons', 36, 2, 270045, '2018-01-15 11:01:23'),
(231, 'lnkPersonPolicies', 29, 2, 270045, '2018-01-15 11:01:23'),
(232, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:20'),
(233, 'tblPersons', 36, 2, 270045, '2018-01-15 11:01:20'),
(234, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:32'),
(235, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:32'),
(236, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:50'),
(237, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:50'),
(238, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:35'),
(239, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:35'),
(240, 'tblpolicies', 14, 1, 270045, '2018-01-15 11:01:12'),
(241, 'tblPersons', 33, 2, 270045, '2018-01-15 11:01:12'),
(242, 'tblpolicies', 14, 1, 270045, '2018-01-15 15:01:58'),
(243, 'tblpolicies', 14, 1, 270045, '2018-01-15 15:01:51'),
(244, 'tblpolicies', 14, 1, 270045, '2018-01-15 15:01:31'),
(245, 'tblpolicies', 14, 1, 270045, '2018-01-15 15:01:41'),
(246, 'tblpolicies', 14, 1, 270045, '2018-01-15 15:01:57'),
(247, 'tblPersons', 33, 2, 270045, '2018-01-15 15:01:57'),
(248, 'tblpolicies', 14, 1, 270045, '2018-01-15 15:01:26'),
(249, 'tblPersons', 33, 2, 270045, '2018-01-15 15:01:26'),
(250, 'tblpolicies', 14, 1, 270045, '2018-01-15 15:01:54'),
(251, 'tblPersons', 33, 2, 270045, '2018-01-15 15:01:54'),
(252, 'tblpolicies', 14, 1, 270045, '2018-01-15 16:01:00'),
(253, 'tblPersons', 33, 2, 270045, '2018-01-15 16:01:00'),
(254, 'lnkPersonPolicies', 32, 2, 270045, '2018-01-15 16:01:00'),
(255, 'tblpolicies', 14, 1, 270045, '2018-01-15 16:01:02'),
(256, 'tblPersons', 33, 2, 270045, '2018-01-15 16:01:02'),
(257, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-15 16:01:02'),
(258, 'tblPersons', 36, 2, 270045, '2018-01-15 16:01:02'),
(259, 'lnkPersonPolicies', 29, 2, 270045, '2018-01-15 16:01:02'),
(260, 'tblpolicies', 14, 1, 270045, '2018-01-15 16:01:24'),
(261, 'tblPersons', 33, 2, 270045, '2018-01-15 16:01:24'),
(262, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-15 16:01:24'),
(263, 'tblPersons', 36, 2, 270045, '2018-01-15 16:01:24'),
(264, 'lnkPersonPolicies', 29, 2, 270045, '2018-01-15 16:01:24'),
(265, 'tblpolicies', 14, 1, 270045, '2018-01-15 16:01:08'),
(266, 'tblPersons', 33, 2, 270045, '2018-01-15 16:01:08'),
(267, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-15 16:01:08'),
(268, 'tblPersons', 36, 2, 270045, '2018-01-15 16:01:09'),
(269, 'lnkPersonPolicies', 29, 2, 270045, '2018-01-15 16:01:09'),
(270, 'tblpolicies', 14, 1, 270045, '2018-01-15 16:01:25'),
(271, 'tblPersons', 33, 2, 270045, '2018-01-15 16:01:25'),
(272, 'lnkPersonPolicies', 26, 2, 270045, '2018-01-15 16:01:25'),
(273, 'tblPersons', 36, 2, 270045, '2018-01-15 16:01:25'),
(274, 'lnkPersonPolicies', 29, 2, 270045, '2018-01-15 16:01:25'),
(275, 'tblPolicyPlans', 8, 2, 270045, '2018-01-15 17:01:30'),
(276, 'tblPolicyPlans', 8, 2, 270045, '2018-01-15 17:01:23'),
(277, 'tblPolicyPlans', 8, 2, 270045, '2018-01-15 17:01:38'),
(278, 'refRoles', 7, 3, 270045, '2018-01-16 08:01:13'),
(279, 'tblpolicyplans', 9, 4, 270045, '2018-01-16 08:01:37'),
(280, 'tblpolicies', 1, 1, 270045, '2018-01-16 08:01:51'),
(281, 'tblPersons', 1, 2, 270045, '2018-01-16 08:01:52'),
(282, 'lnkPersonPolicies', 1, 2, 270045, '2018-01-16 08:01:52'),
(283, 'tblPersons', 2, 2, 270045, '2018-01-16 08:01:52'),
(284, 'lnkPersonPolicies', 2, 2, 270045, '2018-01-16 08:01:52'),
(285, 'tblPolicyPlans', 9, 2, 270045, '2018-01-16 08:01:15'),
(286, 'tblpolicies', 1, 1, 270045, '2018-01-16 08:01:56'),
(287, 'tblPersons', 1, 2, 270045, '2018-01-16 08:01:56'),
(288, 'lnkPersonPolicies', 1, 2, 270045, '2018-01-16 08:01:57'),
(289, 'tblPersons', 2, 2, 270045, '2018-01-16 08:01:57'),
(290, 'lnkPersonPolicies', 2, 2, 270045, '2018-01-16 08:01:57'),
(291, 'refRoles', 1, 2, 270045, '2018-01-16 14:01:09'),
(292, 'refRoles', 91, 1, 270045, '2018-01-16 14:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `tblloginattempts`
--

DROP TABLE IF EXISTS `tblloginattempts`;
CREATE TABLE IF NOT EXISTS `tblloginattempts` (
  `LoginAttemptId` int(11) NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  `Attempts` int(11) NOT NULL,
  `LastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Username` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `tblloginattempts`:
--

--
-- Dumping data for table `tblloginattempts`
--

INSERT INTO `tblloginattempts` (`LoginAttemptId`, `IPAddress`, `Attempts`, `LastLogin`, `Username`) VALUES
(1, '::1', 1, '2017-11-24 17:13:55', 'solly@motsoane.com'),
(2, '::1', 3, '2017-11-24 16:57:12', ''),
(4, '::1', 1, '2017-11-25 07:48:13', 'sollym'),
(5, '::1', 2, '2017-11-25 07:46:45', 'Solly<'),
(6, '::1', 2, '2017-11-25 07:48:58', 'Sollyj'),
(7, '::1', 1, '2017-12-11 17:27:53', 'Lala'),
(8, '::1', 1, '2017-12-13 09:56:30', 'Valencia'),
(9, '::1', 1, '2017-12-13 10:22:35', 'Mokoena'),
(10, '::1', 2, '2018-01-04 06:19:07', 'Ward27'),
(11, '::1', 2, '2018-01-16 13:56:51', 'Neo');

-- --------------------------------------------------------

--
-- Table structure for table `tblpayments`
--

DROP TABLE IF EXISTS `tblpayments`;
CREATE TABLE IF NOT EXISTS `tblpayments` (
  `PaymentId` int(11) NOT NULL,
  `PolicyId` int(11) NOT NULL,
  `ReceiptNo` varchar(100) DEFAULT NULL,
  `PaymentForDate` date NOT NULL,
  `Amount` double(10,2) NOT NULL,
  `CapturedByUserId` int(11) NOT NULL,
  `CapturedDate` datetime NOT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `tblpayments`:
--   `CapturedByUserId`
--       `tblusers` -> `id`
--   `PolicyId`
--       `tblpolicies` -> `PolicyId`
--

--
-- Dumping data for table `tblpayments`
--

INSERT INTO `tblpayments` (`PaymentId`, `PolicyId`, `ReceiptNo`, `PaymentForDate`, `Amount`, `CapturedByUserId`, `CapturedDate`, `DeletedBy`, `DeletedDate`) VALUES
(1, 1, NULL, '2017-12-01', 155.00, 270045, '2017-12-07 09:15:34', NULL, NULL),
(2, 6, NULL, '2017-12-01', 1850.00, 270045, '2017-12-11 14:59:56', NULL, NULL),
(6, 12, NULL, '2018-02-01', 126.00, 270045, '2017-12-11 22:37:18', NULL, NULL),
(7, 12, NULL, '2018-03-01', 126.00, 309095, '2017-12-12 00:05:08', NULL, NULL),
(8, 12, NULL, '2018-04-01', 126.00, 309095, '2017-12-12 00:05:37', NULL, NULL),
(9, 12, NULL, '2018-05-01', 126.00, 309095, '2017-12-12 00:10:08', NULL, NULL),
(10, 12, NULL, '2018-06-01', 126.00, 270045, '2017-12-12 00:11:10', NULL, NULL),
(11, 12, NULL, '2018-07-01', 126.00, 270045, '2017-12-12 00:11:24', NULL, NULL),
(12, 12, NULL, '2018-08-01', 126.00, 270045, '2017-12-12 00:12:11', NULL, NULL),
(13, 2, NULL, '2017-12-01', 185.50, 270045, '2017-12-12 00:14:02', NULL, NULL),
(14, 2, NULL, '2018-01-01', 185.50, 270045, '2017-12-12 00:14:40', NULL, NULL),
(15, 13, NULL, '2017-12-14', 190.00, 270045, '2017-12-14 11:07:23', NULL, NULL),
(16, 7, NULL, '2018-01-01', 130.00, 270045, '2017-12-17 15:25:01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpersons`
--

DROP TABLE IF EXISTS `tblpersons`;
CREATE TABLE IF NOT EXISTS `tblpersons` (
  `PersonId` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MiddleNames` varchar(500) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `TitleId` int(11) NOT NULL,
  `IDNumber` varchar(25) DEFAULT NULL,
  `DateOfBirth` date NOT NULL,
  `HomePhone` varchar(25) DEFAULT NULL,
  `WorkPhone` varchar(25) DEFAULT NULL,
  `MobilePhone` varchar(25) DEFAULT NULL,
  `HomeEmail` varchar(255) DEFAULT NULL,
  `WorkEmail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `tblpersons`:
--

--
-- Dumping data for table `tblpersons`
--

INSERT INTO `tblpersons` (`PersonId`, `FirstName`, `MiddleNames`, `LastName`, `TitleId`, `IDNumber`, `DateOfBirth`, `HomePhone`, `WorkPhone`, `MobilePhone`, `HomeEmail`, `WorkEmail`) VALUES
(1, 'Solly', 'Tylo', 'Motsoane', 6, '12345', '1980-12-04', '0610814057', '', '0765207876', 'solly@motsoane.com', 'info@luckyconnect.co.za'),
(2, 'Valencia', 'Roselyn', 'Mabika', 3, '', '1991-02-19', '0610814057', '', '', '', ''),
(12, 'James', '', 'Moreri', 1, '', '1985-03-12', '0824562565', '', '', 'james.moreri@test.com', ''),
(13, 'Donny', '', 'McMillian', 4, '', '1975-11-30', '', '', '', '', ''),
(14, 'Demo', '', 'Client', 2, '', '1994-03-15', '012-345-6789', '', '082-749-1356', 'demo@client.co.za', 'info@democlient.com'),
(15, 'Li', 'Neo', 'Motsoane', 2, NULL, '2004-08-08', '', '', '', '', ''),
(16, 'James', '', 'Naiker', 1, '', '1974-01-12', '012-424-5212', '011-522-2352', '082-563-5232', 'james.n@motsoane.com', 'james.naiker@luckyconnect.co.za'),
(17, 'Busisiwe', '', 'Diale', 2, '9505102374081', '1995-05-10', '012-526-5632', '', '078-636-5120', '', 'busi.diale@generations.co.za'),
(18, 'Lesedi', '', 'Diale', 2, '0012292596081', '2000-12-29', '011-717-4210', '', '078-965-5474', '', ''),
(20, 'Flo', '', 'Diale', 3, '5606154200084', '1956-06-15', '011-717-4210', '', '', '', 'flo.diale@generations.co.za'),
(21, 'Cosmo', '', 'Diale', 1, '9101276852082', '1991-01-27', '011-717-4210', '', '071-152-5320', 'cosmo@gadaffi.net', 'cosmo.diale@generations.co.za'),
(22, 'Mazwi', '', 'Moroka', 1, '8008085740085', '1980-08-08', '011-717-9910', '011-456-1000', '060-741-5252', 'mazwi@moroka.us', 'mazwi.moroka@ezweni.co.za'),
(23, 'Sphesihle', '', 'Mabaso', 3, '8702024210083', '1987-02-02', '011-717-9910', '', '061-428-3548', 'sphesihle@moroka.us', ''),
(24, 'Rorisang', '', 'Moroka', 2, '1707170452086', '2017-07-17', '', '', '', '', ''),
(25, 'Smanga', '', 'Moroka', 1, '8203156102088', '1982-03-15', '011-412-2120', '011-522-2352', '072-441-1002', 'smanga@moroka.us', 'smanga.moroka@vote.org'),
(26, 'Getrude', '', 'Diale', 2, '8409210485088', '1984-09-21', '010-125-5320', '011-717-1000', '076-521-1068', 'gettydiale84@samail.co.za', 'gettyd@skhafthini.biz'),
(27, 'Chamaine', '', 'Mentjies', 3, '6401293520080', '1964-01-29', '013-526-5654', '', '079-154-6853', 'mentjies@home.co.za', ''),
(28, 'Piet', '', 'Mentjies', 1, '6011107201082', '1960-11-10', '013-526-5654', '', '081-562-5652', 'mentjies@home.co.za', ''),
(29, 'Hilda', '', 'var der Merwe', 3, '4207041350084', '1942-07-04', '021-587-9625', '', '071-522-6542', '', ''),
(30, 'Willem', 'Pietrus', 'van der Merwe', 4, '4005265344083', '1940-05-26', '021-587-9625', '', '063-432-0505', '', ''),
(31, 'Peter', '', 'Mahlangu', 5, '9504165808082', '1995-04-16', '', '', '082-294-3159', '', 'peter@luckyconnect.co.za'),
(32, 'Fiona', '', 'Diale', 2, '1305140962082', '2013-05-14', '011-535-2012', '', '063-521-4740', '', ''),
(33, 'Bianca', 'June', 'Devu', 3, '6710193215083', '1967-10-19', '021-563-1565', '021-533-1000', '060-456-7482', 'bjdevu@mymail.com', 'bianca.devu@working.net'),
(36, 'James', 'Donald', 'Devu', 1, '6009097052082', '1960-09-09', '021-587-9625', '021-533-1000', '060-741-9680', 'j.devu@mymail.com', 'james.devu@working.net'),
(37, 'Amanda', '', 'Devu', 2, '8105214115081', '1981-05-21', '', '', '060-555-1289', 'amandad@mails.co.za', 'amanda.devu@working.net');

-- --------------------------------------------------------

--
-- Table structure for table `tblpolicies`
--

DROP TABLE IF EXISTS `tblpolicies`;
CREATE TABLE IF NOT EXISTS `tblpolicies` (
  `PolicyId` int(11) NOT NULL,
  `PolicyNumber` varchar(255) NOT NULL,
  `ManualPolicyNumber` varchar(255) DEFAULT NULL,
  `PolicyPlanId` int(11) NOT NULL,
  `PolicyPremium` double(10,2) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `AgentName` varchar(500) DEFAULT NULL,
  `AgentCode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `tblpolicies`:
--

--
-- Dumping data for table `tblpolicies`
--

INSERT INTO `tblpolicies` (`PolicyId`, `PolicyNumber`, `ManualPolicyNumber`, `PolicyPlanId`, `PolicyPremium`, `StartDate`, `EndDate`, `AgentName`, `AgentCode`) VALUES
(1, 'DK2017/1244/01', '1234567890', 0, 123.00, '2017-11-22', '2019-12-31', 'Solly M', 'SM00001'),
(2, 'DK/2161/01', '', 3, 185.50, NULL, NULL, 'Solly M', 'SM00001'),
(4, 'DK/8904/01', '', 2, 126.00, '2018-01-01', NULL, 'Solly M', 'SM00001'),
(5, 'DK2017/5116/01', '', 1, 98.00, '2017-12-01', NULL, '', ''),
(6, 'DK2017/2163/01', '', 3, 185.50, '2017-12-01', NULL, 'Solly Motsoane', 'SM001'),
(7, 'DK2017/9043/01', '141414', 2, 126.00, '2018-01-01', NULL, 'Valencia M', 'VM002'),
(8, 'DK2017/2060/01', '', 1, 100.00, '2018-01-01', '2019-12-31', 'Valencia M', 'VM0002'),
(9, 'DK2017/4533/01', '', 2, 126.00, '2017-12-11', NULL, 'Solly M', 'SM0001'),
(10, 'DK2017/6462/01', '', 1, 75.00, '2018-01-01', NULL, 'Solly M', 'SM001'),
(11, 'DK2017/1071/01', '', 3, 185.50, '2017-12-11', NULL, 'Vally M', 'VM0002'),
(12, 'DK2017/2142/01', '', 2, 126.00, '2018-02-01', NULL, '', ''),
(13, 'DK2017/8281/01', '', 3, 190.00, '2017-12-14', NULL, 'Solly M', 'SM01'),
(14, 'DK2018/1552/01', '', 8, 59.00, '2018-02-01', NULL, 'Solly M', 'SM00001');

-- --------------------------------------------------------

--
-- Table structure for table `tblpolicyplans`
--

DROP TABLE IF EXISTS `tblpolicyplans`;
CREATE TABLE IF NOT EXISTS `tblpolicyplans` (
  `PolicyPlanId` int(11) NOT NULL,
  `PlanName` varchar(255) NOT NULL,
  `DefaultPremium` double(10,2) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'0',
  `ActiveFrom` datetime DEFAULT NULL,
  `ActiveTo` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `DeletedBy` int(11) DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `tblpolicyplans`:
--

--
-- Dumping data for table `tblpolicyplans`
--

INSERT INTO `tblpolicyplans` (`PolicyPlanId`, `PlanName`, `DefaultPremium`, `IsActive`, `ActiveFrom`, `ActiveTo`, `CreatedBy`, `CreatedDate`, `ModifiedBy`, `ModifiedDate`, `DeletedBy`, `DeletedDate`) VALUES
(1, 'Silver', 98.00, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Gold', 126.00, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Platinum', 190.00, b'1', NULL, NULL, NULL, NULL, 270045, '2018-01-04 13:29:25', NULL, NULL),
(8, 'Bronze', 59.00, b'1', NULL, '2018-01-15 18:00:00', NULL, NULL, 270045, '2018-01-15 20:01:37', NULL, NULL),
(9, 'Test 10', 123.00, b'0', '2018-01-01 00:00:00', '2018-01-15 15:00:00', 270045, '2018-01-04 14:14:35', 270045, '2018-01-16 11:57:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

DROP TABLE IF EXISTS `tblusers`;
CREATE TABLE IF NOT EXISTS `tblusers` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `JobTitle` varchar(255) NOT NULL,
  `RoleId` int(11) NOT NULL DEFAULT '1',
  `DateEngaged` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `verified` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB AUTO_INCREMENT=309096 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `tblusers`:
--

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `username`, `password`, `FirstName`, `LastName`, `JobTitle`, `RoleId`, `DateEngaged`, `email`, `verified`) VALUES
(197245, 'Valencia', '$2y$10$BeasjRLNlo3xNGGhYjA42OzSpOe6IN8f0EwzFar1I1zj4Rzf/zytW', 'Valencia', 'Mabika', 'Client Liaison Officer', 78, '2017-12-13', 'valenciam@mogen.co.za', b'1'),
(208645, 'Mokoena', '$2y$10$QF68I/t2GfD28p1we.CB/OnpbbWso7dOYZNk6EI5x5HVY/tlwbcWS', 'Joe', 'Mokoena', 'Office Manager', 23, '2017-12-11', 'joe@luckyconnect.co.za', b'1'),
(254105, 'Neo', '$2y$10$8P2xLCkqsbnYkAq7JpOTMuzm5ve8xws7y3Gv2NRPY0ZqVmTI8VHWC', 'Neo', 'Mampa', 'Developer', 90, '2017-11-01', 'neomampa@ymail.com', b'1'),
(270045, 'SollyM', '$2y$10$kU6744mNZ3EVRCoJBPGf/uJtmKHj82lfuOG.PMseeF6/Dg6PY0/TG', 'Solly', 'Motsoane', 'Snr Systems Engineer', 90, '2017-11-01', 'solly@mogen.co.za', b'1'),
(309095, 'Lala', '$2y$10$6DqKhDk/ovVmjTPbLoCewOODMGRD6OwBgOJJqb0ld3200AYIGUKCW', 'Lala', 'Lucky', 'Administrator', 91, '2017-12-11', 'lala@luckyconnect.co.za', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lnkpersonpolicies`
--
ALTER TABLE `lnkpersonpolicies`
  ADD PRIMARY KEY (`PersonPolicyId`), ADD UNIQUE KEY `UI_PersonPolicy` (`PolicyId`,`PersonId`), ADD KEY `PersonId` (`PersonId`);

--
-- Indexes for table `refactions`
--
ALTER TABLE `refactions`
  ADD PRIMARY KEY (`ActionId`), ADD UNIQUE KEY `UI_ActionName` (`ActionName`);

--
-- Indexes for table `refpersontypes`
--
ALTER TABLE `refpersontypes`
  ADD PRIMARY KEY (`PersonTypeId`), ADD UNIQUE KEY `UI_PersonType` (`PersonType`);

--
-- Indexes for table `refrelationships`
--
ALTER TABLE `refrelationships`
  ADD PRIMARY KEY (`RelationshipId`);

--
-- Indexes for table `refroles`
--
ALTER TABLE `refroles`
  ADD PRIMARY KEY (`RoleId`), ADD UNIQUE KEY `UI_RoleName` (`RoleName`);

--
-- Indexes for table `reftitles`
--
ALTER TABLE `reftitles`
  ADD PRIMARY KEY (`TitleId`), ADD UNIQUE KEY `UI_Title` (`Title`);

--
-- Indexes for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  ADD PRIMARY KEY (`InvoiceId`), ADD KEY `PolicyId_INDEX` (`PolicyId`);

--
-- Indexes for table `tbllog`
--
ALTER TABLE `tbllog`
  ADD PRIMARY KEY (`LogId`);

--
-- Indexes for table `tblloginattempts`
--
ALTER TABLE `tblloginattempts`
  ADD PRIMARY KEY (`LoginAttemptId`);

--
-- Indexes for table `tblpayments`
--
ALTER TABLE `tblpayments`
  ADD PRIMARY KEY (`PaymentId`), ADD UNIQUE KEY `Policy_Payment_Date` (`PolicyId`,`PaymentForDate`);

--
-- Indexes for table `tblpersons`
--
ALTER TABLE `tblpersons`
  ADD PRIMARY KEY (`PersonId`);

--
-- Indexes for table `tblpolicies`
--
ALTER TABLE `tblpolicies`
  ADD PRIMARY KEY (`PolicyId`), ADD UNIQUE KEY `UI_PolicyNumber` (`PolicyNumber`);

--
-- Indexes for table `tblpolicyplans`
--
ALTER TABLE `tblpolicyplans`
  ADD PRIMARY KEY (`PolicyPlanId`), ADD UNIQUE KEY `UI_PlanName` (`PlanName`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lnkpersonpolicies`
--
ALTER TABLE `lnkpersonpolicies`
  MODIFY `PersonPolicyId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `refactions`
--
ALTER TABLE `refactions`
  MODIFY `ActionId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `refpersontypes`
--
ALTER TABLE `refpersontypes`
  MODIFY `PersonTypeId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `refrelationships`
--
ALTER TABLE `refrelationships`
  MODIFY `RelationshipId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `refroles`
--
ALTER TABLE `refroles`
  MODIFY `RoleId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `reftitles`
--
ALTER TABLE `reftitles`
  MODIFY `TitleId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  MODIFY `InvoiceId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tbllog`
--
ALTER TABLE `tbllog`
  MODIFY `LogId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=293;
--
-- AUTO_INCREMENT for table `tblloginattempts`
--
ALTER TABLE `tblloginattempts`
  MODIFY `LoginAttemptId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tblpayments`
--
ALTER TABLE `tblpayments`
  MODIFY `PaymentId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tblpersons`
--
ALTER TABLE `tblpersons`
  MODIFY `PersonId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `tblpolicies`
--
ALTER TABLE `tblpolicies`
  MODIFY `PolicyId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `tblpolicyplans`
--
ALTER TABLE `tblpolicyplans`
  MODIFY `PolicyPlanId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=309096;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `lnkpersonpolicies`
--
ALTER TABLE `lnkpersonpolicies`
ADD CONSTRAINT `lnkpersonpolicies_ibfk_1` FOREIGN KEY (`PersonId`) REFERENCES `tblpersons` (`PersonId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
