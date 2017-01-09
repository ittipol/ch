-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2017 at 02:53 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ch`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `place_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `district_id` int(11) NOT NULL,
  `sub_district_id` int(11) NOT NULL,
  `description` text,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `model`, `model_id`, `place_name`, `address`, `district_id`, `sub_district_id`, `description`, `lat`, `lng`, `created_at`, `updated_at`) VALUES
(1, 'Entity', 35, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:26:10', '2017-01-09 18:26:10'),
(2, 'Entity', 36, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:29:16', '2017-01-09 18:29:16'),
(3, 'Entity', 37, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:30:40', '2017-01-09 18:30:40'),
(4, 'Entity', 38, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:30:59', '2017-01-09 18:30:59'),
(5, 'Entity', 39, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:34:28', '2017-01-09 18:34:28'),
(6, 'Entity', 40, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:34:49', '2017-01-09 18:34:49'),
(7, 'Entity', 41, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:35:19', '2017-01-09 18:35:19'),
(8, 'Entity', 42, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:35:50', '2017-01-09 18:35:50'),
(9, 'Entity', 43, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:36:07', '2017-01-09 18:36:07'),
(10, 'Entity', 44, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:37:05', '2017-01-09 18:37:05'),
(11, 'Entity', 45, NULL, '', 1, 1, NULL, '', '', '2017-01-09 18:37:57', '2017-01-09 18:37:57'),
(12, 'Entity', 46, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:12:23', '2017-01-09 19:12:23'),
(13, 'Entity', 47, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:12:31', '2017-01-09 19:12:31'),
(14, 'Entity', 48, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:12:56', '2017-01-09 19:12:56'),
(15, 'Entity', 49, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:13:03', '2017-01-09 19:13:03'),
(16, 'Entity', 50, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:17:18', '2017-01-09 19:17:18'),
(17, 'Entity', 51, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:17:25', '2017-01-09 19:17:25'),
(18, 'Entity', 52, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:18:38', '2017-01-09 19:18:38'),
(19, 'Entity', 53, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:19:12', '2017-01-09 19:19:12'),
(20, 'Entity', 54, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:19:35', '2017-01-09 19:19:35'),
(21, 'Entity', 55, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:21:42', '2017-01-09 19:21:42'),
(22, 'Entity', 56, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:27:48', '2017-01-09 19:27:48'),
(23, 'Entity', 57, NULL, '', 1, 1, NULL, '', '', '2017-01-09 19:30:46', '2017-01-09 19:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `business_entities`
--

CREATE TABLE `business_entities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_entities`
--

INSERT INTO `business_entities` (`id`, `name`, `description`) VALUES
(1, 'บุคคลธรรมดา', NULL),
(2, 'ห้างหุ้นส่วน', NULL),
(3, 'บริษัทเอกชนจำกัด', NULL),
(4, 'บริษัทมหาชนจำกัด', NULL),
(5, 'สหกรณ์', NULL),
(6, 'รัฐวิสาหกิจ', NULL),
(7, 'หน่วยงานของรัฐ', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `name_en`, `description`, `created_at`, `updated_at`) VALUES
(1, 'เมืองชลบุรี', NULL, NULL, '2016-11-26 07:34:14', '2016-11-26 07:34:14'),
(2, 'เกาะสีชัง', NULL, NULL, '2016-11-26 07:34:14', '2016-11-26 07:34:14'),
(3, 'บ่อทอง', NULL, NULL, '2016-11-26 07:34:55', '2016-11-26 07:34:55'),
(4, 'บางละมุง', NULL, NULL, '2016-11-26 07:34:55', '2016-11-26 07:34:55'),
(5, 'บ้านบึง', NULL, NULL, '2016-11-26 07:35:19', '2016-11-26 07:35:19'),
(6, 'พานทอง', NULL, NULL, '2016-11-26 07:35:19', '2016-11-26 07:35:19'),
(7, 'พนัสนิคม', NULL, NULL, '2016-11-26 07:35:53', '2016-11-26 07:35:53'),
(8, 'ศรีราชา', NULL, NULL, '2016-11-26 07:35:53', '2016-11-26 07:35:53'),
(9, 'สัตหีบ', NULL, NULL, '2016-11-26 07:36:09', '2016-11-26 07:36:09'),
(10, 'หนองใหญ่', NULL, NULL, '2016-11-26 07:36:09', '2016-11-26 07:36:09'),
(11, 'เกาะจันทร์', NULL, NULL, '2016-11-26 07:36:26', '2016-11-26 07:36:26'),
(12, 'เมืองพัทยา', NULL, NULL, '2016-11-26 07:41:01', '2016-11-26 07:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `entities`
--

CREATE TABLE `entities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entities`
--

INSERT INTO `entities` (`id`, `name`, `entity_type_id`, `created_by`, `created_at`) VALUES
(1, '', 1, 1, '2017-01-09 17:43:20'),
(2, '', 1, 1, '2017-01-09 17:43:52'),
(3, '', 1, 1, '2017-01-09 17:44:38'),
(4, '', 1, 1, '2017-01-09 17:45:04'),
(5, '', 1, 1, '2017-01-09 17:45:15'),
(6, '', 1, 1, '2017-01-09 17:45:24'),
(7, '', 1, 1, '2017-01-09 17:49:48'),
(8, '', 1, 1, '2017-01-09 17:50:00'),
(9, '', 1, 1, '2017-01-09 17:53:57'),
(10, '', 1, 1, '2017-01-09 17:54:19'),
(11, '', 1, 1, '2017-01-09 17:54:30'),
(12, '', 1, 1, '2017-01-09 17:55:25'),
(13, '', 1, 1, '2017-01-09 17:55:41'),
(14, '', 1, 1, '2017-01-09 17:55:54'),
(15, '', 1, 1, '2017-01-09 17:56:06'),
(16, '', 1, 1, '2017-01-09 17:58:45'),
(17, '', 1, 1, '2017-01-09 17:58:53'),
(18, '', 1, 1, '2017-01-09 17:59:16'),
(19, '', 1, 1, '2017-01-09 17:59:24'),
(20, '', 1, 1, '2017-01-09 17:59:30'),
(21, '', 1, 1, '2017-01-09 17:59:38'),
(22, '', 1, 1, '2017-01-09 17:59:52'),
(23, '', 1, 1, '2017-01-09 17:59:59'),
(24, 'aaa', 1, 1, '2017-01-09 18:07:06'),
(25, 'aaa', 1, 1, '2017-01-09 18:07:36'),
(26, 'aaa', 1, 1, '2017-01-09 18:18:42'),
(27, 'aaa', 1, 1, '2017-01-09 18:19:07'),
(28, 'aaa', 1, 1, '2017-01-09 18:19:37'),
(29, 'aaa', 1, 1, '2017-01-09 18:19:48'),
(30, 'aaa', 1, 1, '2017-01-09 18:19:59'),
(31, 'aaa', 1, 1, '2017-01-09 18:22:22'),
(32, 'aaa', 1, 1, '2017-01-09 18:22:32'),
(33, 'aaa', 1, 1, '2017-01-09 18:23:08'),
(34, 'aaa', 1, 1, '2017-01-09 18:23:37'),
(35, 'aaa', 1, 1, '2017-01-09 18:26:10'),
(36, 'aaa', 1, 1, '2017-01-09 18:29:16'),
(37, 'aaa', 1, 1, '2017-01-09 18:30:39'),
(38, 'aaa', 1, 1, '2017-01-09 18:30:59'),
(39, 'aaa', 1, 1, '2017-01-09 18:34:28'),
(40, 'aaa', 1, 1, '2017-01-09 18:34:48'),
(41, 'aaa', 1, 1, '2017-01-09 18:35:19'),
(42, 'aaa', 1, 1, '2017-01-09 18:35:50'),
(43, 'aaa', 1, 1, '2017-01-09 18:36:07'),
(44, 'aaa', 1, 1, '2017-01-09 18:37:05'),
(45, 'aaaa', 1, 1, '2017-01-09 18:37:57'),
(46, 'www', 1, 1, '2017-01-09 19:12:23'),
(47, 'www', 1, 1, '2017-01-09 19:12:31'),
(48, 'www', 1, 1, '2017-01-09 19:12:56'),
(49, 'www', 1, 1, '2017-01-09 19:13:03'),
(50, 'www', 1, 1, '2017-01-09 19:17:18'),
(51, 'www', 1, 1, '2017-01-09 19:17:25'),
(52, 'www', 1, 1, '2017-01-09 19:18:38'),
(53, 'www', 1, 1, '2017-01-09 19:19:12'),
(54, 'www', 1, 1, '2017-01-09 19:19:35'),
(55, 'www', 1, 1, '2017-01-09 19:21:42'),
(56, 'www', 1, 1, '2017-01-09 19:27:48'),
(57, 'www', 1, 1, '2017-01-09 19:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `entity_types`
--

CREATE TABLE `entity_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entity_types`
--

INSERT INTO `entity_types` (`id`, `name`, `alias`) VALUES
(1, 'บริษัท, องค์กร, ร้านค้า', 'business'),
(2, 'สถานที่', 'place'),
(3, 'ร้านค้าออนไลน์', 'online-shop');

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `user_id`, `profile_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2016-12-08 12:57:33', '2016-12-08 12:57:33'),
(2, 2, 2, '2016-12-08 23:35:18', '2016-12-08 23:35:18'),
(3, 3, 3, '2016-12-08 23:35:38', '2016-12-08 23:35:38'),
(4, 4, 4, '2016-12-08 23:35:56', '2016-12-08 23:35:56'),
(5, 5, 5, '2016-12-08 23:40:18', '2016-12-08 23:40:18'),
(6, 6, 6, '2016-12-08 23:41:28', '2016-12-08 23:41:28'),
(7, 7, 7, '2016-12-08 23:42:07', '2016-12-08 23:42:07'),
(8, 8, 8, '2016-12-08 23:42:33', '2016-12-08 23:42:33');

-- --------------------------------------------------------

--
-- Table structure for table `person_to_entities`
--

CREATE TABLE `person_to_entities` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person_to_entities`
--

INSERT INTO `person_to_entities` (`id`, `entity_id`, `person_id`, `role_id`, `created_at`) VALUES
(1, 57, 1, 1, '2017-01-09 19:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `sku` int(255) DEFAULT NULL,
  `quantity` int(5) DEFAULT NULL,
  `stock_status_id` int(11) DEFAULT NULL,
  `price` decimal(15,4) NOT NULL,
  `weight` decimal(15,8) DEFAULT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `length` decimal(15,8) DEFAULT NULL,
  `length_id` int(11) DEFAULT NULL,
  `width` decimal(15,8) DEFAULT NULL,
  `height` decimal(15,8) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `birth_date` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `gender`, `birth_date`, `created_at`, `updated_at`) VALUES
(1, 'Fname Lname', 'm', '2500-01-01', '2016-12-08 12:57:33', '2016-12-24 19:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `adding_permission` tinyint(1) NOT NULL,
  `editing_permission` tinyint(1) NOT NULL,
  `deleting_permission` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `alias`, `adding_permission`, `editing_permission`, `deleting_permission`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 1, 1, 1, '2016-12-06 10:44:05', '2016-12-31 17:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `slugs`
--

CREATE TABLE `slugs` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slugs`
--

INSERT INTO `slugs` (`id`, `model`, `model_id`, `name`, `created_at`) VALUES
(1, 'Entity', 26, 'aaa-26', '2017-01-09 18:18:42'),
(2, 'Entity', 27, 'aaa-27', '2017-01-09 18:19:07'),
(3, 'Entity', 28, 'aaa-28', '2017-01-09 18:19:37'),
(4, 'Entity', 29, 'aaa-29', '2017-01-09 18:19:48'),
(5, 'Entity', 30, 'aaa-30', '2017-01-09 18:19:59'),
(6, 'Entity', 31, 'aaa-31', '2017-01-09 18:22:22'),
(7, 'Entity', 32, 'aaa-32', '2017-01-09 18:22:32'),
(8, 'Entity', 33, 'aaa-33', '2017-01-09 18:23:08'),
(9, 'Entity', 34, 'aaa-34', '2017-01-09 18:23:37'),
(10, 'Entity', 35, 'aaa-35', '2017-01-09 18:26:10'),
(11, 'Entity', 36, 'aaa-36', '2017-01-09 18:29:16'),
(12, 'Entity', 37, 'aaa-37', '2017-01-09 18:30:39'),
(13, 'Entity', 38, 'aaa-38', '2017-01-09 18:30:59'),
(14, 'Entity', 39, 'aaa-39', '2017-01-09 18:34:28'),
(15, 'Entity', 40, 'aaa-40', '2017-01-09 18:34:48'),
(16, 'Entity', 41, 'aaa-41', '2017-01-09 18:35:19'),
(17, 'Entity', 42, 'aaa-42', '2017-01-09 18:35:50'),
(18, 'Entity', 43, 'aaa-43', '2017-01-09 18:36:07'),
(19, 'Entity', 44, 'aaa-44', '2017-01-09 18:37:05'),
(20, 'Entity', 45, 'aaaa-45', '2017-01-09 18:37:57'),
(21, 'Entity', 46, 'www-46', '2017-01-09 19:12:23'),
(22, 'Entity', 47, 'www-47', '2017-01-09 19:12:31'),
(23, 'Entity', 48, 'www-48', '2017-01-09 19:12:56'),
(24, 'Entity', 49, 'www-49', '2017-01-09 19:13:03'),
(25, 'Entity', 50, 'www-50', '2017-01-09 19:17:18'),
(26, 'Entity', 51, 'www-51', '2017-01-09 19:17:25'),
(27, 'Entity', 52, 'www-52', '2017-01-09 19:18:38'),
(28, 'Entity', 53, 'www-53', '2017-01-09 19:19:12'),
(29, 'Entity', 54, 'www-54', '2017-01-09 19:19:35'),
(30, 'Entity', 55, 'www-55', '2017-01-09 19:21:42'),
(31, 'Entity', 56, 'www-56', '2017-01-09 19:27:48'),
(32, 'Entity', 57, 'www-57', '2017-01-09 19:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `sub_districts`
--

CREATE TABLE `sub_districts` (
  `id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `description` text,
  `zip_code` varchar(5) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_districts`
--

INSERT INTO `sub_districts` (`id`, `district_id`, `name`, `name_en`, `description`, `zip_code`, `created_at`, `updated_at`) VALUES
(1, 1, 'เสม็ด', NULL, NULL, NULL, '2016-11-26 07:43:37', '2016-11-26 07:43:37'),
(2, 1, 'เหมือง', NULL, NULL, NULL, '2016-11-26 07:43:37', '2016-11-26 07:43:37'),
(3, 1, 'แสนสุข', NULL, NULL, NULL, '2016-11-26 07:44:21', '2016-11-26 07:44:21'),
(4, 1, 'คลองตำหรุ', NULL, NULL, NULL, '2016-11-26 07:44:21', '2016-11-26 07:44:21'),
(5, 1, 'ดอนหัวฬ่อ', NULL, NULL, NULL, '2016-11-26 07:44:53', '2016-11-26 07:44:53'),
(6, 1, 'นาป่า', NULL, NULL, NULL, '2016-11-26 07:44:53', '2016-11-26 07:44:53'),
(7, 1, 'บางทราย', NULL, NULL, NULL, '2016-11-26 07:45:45', '2016-11-26 07:45:45'),
(8, 1, 'บางปลาสร้อย', NULL, NULL, NULL, '2016-11-26 07:45:45', '2016-11-26 07:45:45'),
(9, 1, 'บ้านโขด', NULL, NULL, NULL, '2016-11-26 07:46:18', '2016-11-26 07:46:18'),
(10, 1, 'บ้านปึก', NULL, NULL, NULL, '2016-11-26 07:46:18', '2016-11-26 07:46:18'),
(11, 1, 'บ้านสวน', NULL, NULL, NULL, '2016-11-26 07:46:59', '2016-11-26 07:46:59'),
(12, 1, 'มะขามหย่ง', NULL, NULL, NULL, '2016-11-26 07:46:59', '2016-11-26 07:46:59'),
(13, 1, 'สำนักบก', NULL, NULL, NULL, '2016-11-26 07:47:33', '2016-11-26 07:47:33'),
(14, 1, 'หนองไม้แดง', NULL, NULL, NULL, '2016-11-26 07:47:33', '2016-11-26 07:47:33'),
(15, 1, 'หนองข้างคอก', NULL, NULL, NULL, '2016-11-26 07:48:06', '2016-11-26 07:48:06'),
(16, 1, 'หนองรี', NULL, NULL, NULL, '2016-11-26 07:48:06', '2016-11-26 07:48:06'),
(17, 1, 'ห้วยกะปิ', NULL, NULL, NULL, '2016-11-26 07:48:27', '2016-11-26 07:48:27'),
(18, 1, 'อ่างศิลา', NULL, NULL, NULL, '2016-11-26 07:48:27', '2016-11-26 07:48:27'),
(19, 2, 'ท่าเทววงษ์', NULL, NULL, NULL, '2016-11-26 07:49:01', '2016-11-26 07:49:01'),
(20, 3, 'เกษตรสุวรรณ', NULL, NULL, NULL, '2016-11-26 07:49:38', '2016-11-26 07:49:38'),
(21, 3, 'ธาตุทอง', NULL, NULL, NULL, '2016-11-26 07:49:38', '2016-11-26 07:49:38'),
(22, 3, 'บ่อกวางทอง', NULL, NULL, NULL, '2016-11-26 07:49:57', '2016-11-26 07:49:57'),
(23, 3, 'บ่อทอง', NULL, NULL, NULL, '2016-11-26 07:49:57', '2016-11-26 07:49:57'),
(24, 3, 'พลวงทอง', NULL, NULL, NULL, '2016-11-26 07:50:28', '2016-11-26 07:50:28'),
(25, 3, 'วัดสุวรรณ', NULL, NULL, NULL, '2016-11-26 07:50:28', '2016-11-26 07:50:28'),
(26, 4, 'เขาไม้แก้ว', NULL, NULL, NULL, '2016-11-26 07:51:42', '2016-11-26 07:51:42'),
(27, 4, 'โป่ง', NULL, NULL, NULL, '2016-11-26 07:51:42', '2016-11-26 07:51:42'),
(28, 4, 'ตะเคียนเตี้ย', NULL, NULL, NULL, '2016-11-26 07:52:12', '2016-11-26 07:52:12'),
(29, 4, 'นาเกลือ', NULL, NULL, NULL, '2016-11-26 07:52:12', '2016-11-26 07:52:12'),
(30, 4, 'บางละมุง', NULL, NULL, NULL, '2016-11-26 07:52:38', '2016-11-26 07:52:38'),
(31, 4, 'หนองปรือ', NULL, NULL, NULL, '2016-11-26 07:52:38', '2016-11-26 07:52:38'),
(32, 4, 'หนองปลาไหล', NULL, NULL, NULL, '2016-11-26 07:53:24', '2016-11-26 07:53:24'),
(33, 4, 'ห้วยใหญ่', NULL, NULL, NULL, '2016-11-26 07:53:24', '2016-11-26 07:53:24'),
(34, 5, 'คลองกิ่ว', NULL, NULL, NULL, '2016-11-26 07:54:07', '2016-11-26 07:54:07'),
(35, 5, 'บ้านบึง', NULL, NULL, NULL, '2016-11-26 07:54:07', '2016-11-26 07:54:07'),
(36, 5, 'มาบไผ่', NULL, NULL, NULL, '2016-11-26 07:55:20', '2016-11-26 07:55:20'),
(37, 5, 'หนองไผ่แก้ว', NULL, NULL, NULL, '2016-11-26 07:55:20', '2016-11-26 07:55:20'),
(38, 5, 'หนองชาก', NULL, NULL, NULL, '2016-11-26 07:55:52', '2016-11-26 07:55:52'),
(39, 5, 'หนองซ้ำซาก', NULL, NULL, NULL, '2016-11-26 07:55:52', '2016-11-26 07:55:52'),
(40, 5, 'หนองบอนแดง', NULL, NULL, NULL, '2016-11-26 07:56:25', '2016-11-26 07:56:25'),
(41, 5, 'หนองอิรุณ', NULL, NULL, NULL, '2016-11-26 07:56:25', '2016-11-26 07:56:25'),
(42, 6, 'เกาะลอย', NULL, NULL, NULL, '2016-11-26 07:57:40', '2016-11-26 07:57:40'),
(43, 6, 'โคกขี้หนอน', NULL, NULL, NULL, '2016-11-26 07:57:40', '2016-11-26 07:57:40'),
(44, 6, 'บางนาง', NULL, NULL, NULL, '2016-11-26 07:58:15', '2016-11-26 07:58:15'),
(45, 6, 'บางหัก', NULL, NULL, NULL, '2016-11-26 07:58:15', '2016-11-26 07:58:15'),
(46, 6, 'บ้านเก่า', NULL, NULL, NULL, '2016-11-26 07:58:42', '2016-11-26 07:58:42'),
(47, 6, 'พานทอง', NULL, NULL, NULL, '2016-11-26 07:58:42', '2016-11-26 07:58:42'),
(48, 6, 'มาบโป่ง', NULL, NULL, NULL, '2016-11-26 07:59:20', '2016-11-26 07:59:20'),
(49, 6, 'หนองกะขะ', NULL, NULL, NULL, '2016-11-26 07:59:20', '2016-11-26 07:59:20'),
(50, 6, 'หนองตำลึง', NULL, NULL, NULL, '2016-11-26 07:59:56', '2016-11-26 07:59:56'),
(51, 6, 'หนองหงษ์', NULL, NULL, NULL, '2016-11-26 07:59:56', '2016-11-26 07:59:56'),
(52, 6, 'หน้าประดู่', NULL, NULL, NULL, '2016-11-26 08:00:08', '2016-11-26 08:00:08'),
(53, 7, 'โคกเพลาะ', NULL, NULL, NULL, '2016-11-26 08:00:53', '2016-11-26 08:00:53'),
(54, 7, 'ไร่หลักทอง', NULL, NULL, NULL, '2016-11-26 08:00:53', '2016-11-26 08:00:53'),
(55, 7, 'กุฎโง้ง', NULL, NULL, NULL, '2016-11-26 08:01:20', '2016-11-26 08:01:20'),
(56, 7, 'ท่าข้าม', NULL, NULL, NULL, '2016-11-26 08:01:20', '2016-11-26 08:01:20'),
(57, 7, 'ทุ่งขวาง', NULL, NULL, NULL, '2016-11-26 08:02:30', '2016-11-26 08:02:30'),
(58, 7, 'นาเริก', NULL, NULL, NULL, '2016-11-26 08:02:30', '2016-11-26 08:02:30'),
(59, 7, 'นามะตูม', NULL, NULL, NULL, '2016-11-26 08:03:37', '2016-11-26 08:03:37'),
(60, 7, 'นาวังหิน', NULL, NULL, NULL, '2016-11-26 08:03:37', '2016-11-26 08:03:37'),
(61, 7, 'บ้านเซิด', NULL, NULL, NULL, '2016-11-26 08:04:32', '2016-11-26 08:04:32'),
(62, 7, 'บ้านช้าง', NULL, NULL, NULL, '2016-11-26 08:04:32', '2016-11-26 08:04:32'),
(63, 7, 'พนัสนิคม', NULL, NULL, NULL, '2016-11-26 08:05:23', '2016-11-26 08:05:23'),
(64, 7, 'วัดโบสถ์', NULL, NULL, NULL, '2016-11-26 08:05:23', '2016-11-26 08:05:23'),
(65, 7, 'วัดหลวง', NULL, NULL, NULL, '2016-11-26 08:06:35', '2016-11-26 08:06:35'),
(66, 7, 'สระสี่เหลี่ยม', NULL, NULL, NULL, '2016-11-26 08:06:35', '2016-11-26 08:06:35'),
(67, 7, 'หนองเหียง', NULL, NULL, NULL, '2016-11-26 08:07:08', '2016-11-26 08:07:08'),
(68, 7, 'หนองขยาด', NULL, NULL, NULL, '2016-11-26 08:07:08', '2016-11-26 08:07:08'),
(69, 7, 'หนองปรือ', NULL, NULL, NULL, '2016-11-26 08:07:49', '2016-11-26 08:07:49'),
(70, 7, 'หน้าพระธาตุ', NULL, NULL, NULL, '2016-11-26 08:07:49', '2016-11-26 08:07:49'),
(71, 7, 'หมอนนาง', NULL, NULL, NULL, '2016-11-26 08:08:12', '2016-11-26 08:08:12'),
(72, 7, 'หัวถนน', NULL, NULL, NULL, '2016-11-26 08:08:12', '2016-11-26 08:08:12'),
(73, 8, 'เขาคันทรง', NULL, NULL, NULL, '2016-11-26 08:09:44', '2016-11-26 08:09:44'),
(74, 8, 'ทุ่งสุขลา', NULL, NULL, NULL, '2016-11-26 08:09:44', '2016-11-26 08:09:44'),
(75, 8, 'บ่อวิน', NULL, NULL, NULL, '2016-11-26 08:10:15', '2016-11-26 08:10:15'),
(76, 8, 'บางพระ', NULL, NULL, NULL, '2016-11-26 08:10:15', '2016-11-26 08:10:15'),
(77, 8, 'บึง', NULL, NULL, NULL, '2016-11-26 08:10:38', '2016-11-26 08:10:38'),
(78, 8, 'ศรีราชา', NULL, NULL, NULL, '2016-11-26 08:10:38', '2016-11-26 08:10:38'),
(79, 8, 'สุรศักดิ์', NULL, NULL, NULL, '2016-11-26 08:11:05', '2016-11-26 08:11:05'),
(80, 8, 'หนองขาม', NULL, NULL, NULL, '2016-11-26 08:11:05', '2016-11-26 08:11:05'),
(81, 9, 'แสมสาร', NULL, NULL, NULL, '2016-11-26 08:11:49', '2016-11-26 08:11:49'),
(82, 9, 'นาจอมเทียน', NULL, NULL, NULL, '2016-11-26 08:11:49', '2016-11-26 08:11:49'),
(83, 9, 'บางเสร่', NULL, NULL, NULL, '2016-11-26 08:12:16', '2016-11-26 08:12:16'),
(84, 9, 'พลูตาหลวง', NULL, NULL, NULL, '2016-11-26 08:12:16', '2016-11-26 08:12:16'),
(85, 9, 'สัตหีบ', NULL, NULL, NULL, '2016-11-26 08:12:29', '2016-11-26 08:12:29'),
(86, 10, 'เขาซก', NULL, NULL, NULL, '2016-11-26 08:13:37', '2016-11-26 08:13:37'),
(87, 10, 'คลองพลู', NULL, NULL, NULL, '2016-11-26 08:13:37', '2016-11-26 08:13:37'),
(88, 10, 'หนองเสือช้าง', NULL, NULL, NULL, '2016-11-26 08:13:58', '2016-11-26 08:13:58'),
(89, 10, 'หนองใหญ่', NULL, NULL, NULL, '2016-11-26 08:13:58', '2016-11-26 08:13:58'),
(90, 10, 'ห้างสูง', NULL, NULL, NULL, '2016-11-26 08:14:09', '2016-11-26 08:14:09'),
(91, 11, 'เกาะจันทร์', NULL, NULL, NULL, '2016-11-26 08:14:57', '2016-11-26 08:14:57'),
(92, 11, 'ท่าบุญมี', NULL, NULL, NULL, '2016-11-26 08:14:57', '2016-11-26 08:14:57'),
(93, 12, 'พัทยาเหนือ', NULL, NULL, NULL, '2016-12-04 13:17:12', '2016-12-04 13:17:12'),
(94, 12, 'พัทยากลาง', NULL, NULL, NULL, '2016-12-04 13:17:12', '2016-12-04 13:17:12'),
(95, 12, 'พัทยาใต้', NULL, NULL, NULL, '2016-12-04 13:17:24', '2016-12-04 13:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `receive_email` tinyint(1) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `api_token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `receive_email`, `remember_token`, `api_token`, `created_at`, `updated_at`) VALUES
(1, '1', '$2y$10$JzjB5lnDBSuvrCk5BeGdYOKlkrilHaRILTNaLuo6k9o0PcfKWZRc6', NULL, 'uEAC1nVhFgWbrOKOvANezu8sEp85r6sFppzyA4y6BPHAyu8qskchnQUwT937', '', '2016-12-08 12:57:33', '2017-01-09 19:06:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_entities`
--
ALTER TABLE `business_entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entities`
--
ALTER TABLE `entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entity_types`
--
ALTER TABLE `entity_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person_to_entities`
--
ALTER TABLE `person_to_entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slugs`
--
ALTER TABLE `slugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_districts`
--
ALTER TABLE `sub_districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `business_entities`
--
ALTER TABLE `business_entities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `entities`
--
ALTER TABLE `entities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `entity_types`
--
ALTER TABLE `entity_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `person_to_entities`
--
ALTER TABLE `person_to_entities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `slugs`
--
ALTER TABLE `slugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `sub_districts`
--
ALTER TABLE `sub_districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
