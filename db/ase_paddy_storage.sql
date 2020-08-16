-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 16, 2020 at 11:48 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ase_paddy_storage`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(1) NOT NULL,
  `app_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fax_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Rs',
  `active_season_id` int(1) DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `app_name`, `address`, `phone_number`, `fax_number`, `email_address`, `currency_symbol`, `active_season_id`, `modified_at`, `modified_by`) VALUES
(1, 'Paddy Storage Coorporation', 'Colombo', '0123456789', '0123456789', 'info@psc.com', 'Rs', 1, '2020-08-16 03:28:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
  `bank_account_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `bank_and_branch` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `collection_center_id`, `bank_account_no`, `bank_account_name`, `bank_and_branch`, `created_by`, `created_at`, `modified_by`, `modified_at`, `status`) VALUES
(1, 8, '8763243', 'khsdh', 'jhsdf', 1, '2020-08-12 07:05:25', 1, '2020-08-12 13:35:25', 0),
(2, 6, '47652723', 'khsdh', 'jhsdf', 1, '2020-08-12 07:07:45', 1, '2020-08-12 13:37:45', 0),
(3, 5, '73458345', 'khsdh', 'jhsdf', 1, '2020-08-12 07:08:12', 1, '2020-08-16 02:44:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `collection_centers`
--

CREATE TABLE `collection_centers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` text COLLATE utf8_unicode_ci NOT NULL,
  `capacity` decimal(11,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `collection_centers`
--

INSERT INTO `collection_centers` (`id`, `name`, `city`, `address`, `phone_number`, `capacity`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(2, 'Colombo', 'Colombo', 'Colombo', '01234567', '10000.00', '2020-08-05 09:05:48', 1, '2020-08-11 02:24:23', 1, 1),
(3, 'Gampaha', 'Gampaha', 'Gampaha', '071234566', '10000.00', '2020-08-11 08:45:40', 2, '2020-08-11 15:15:40', 2, 1),
(4, 'Polonnaruwa', 'Polonnaruwa', 'Polonnaruwa', '0123456789', '250000.00', '2020-08-11 09:59:16', 2, '2020-08-11 16:29:16', 2, 1),
(5, 'Anuradhapuraya', 'Anuradhapuraya', 'Anuradhapuraya', '0123456789', '20000.00', '2020-08-11 09:59:37', 2, '2020-08-11 16:29:37', 2, 1),
(6, 'Ampara', 'Ampara', 'Ampara', '0123456789', '20000.00', '2020-08-11 09:59:49', 2, '2020-08-11 16:29:49', 2, 1),
(7, 'Jaffna', 'Jaffna', 'Jaffna', '0123456789', '15000.00', '2020-08-11 10:00:06', 2, '2020-08-11 16:30:06', 2, 1),
(8, 'Batticaloa', 'Batticaloa', 'Batticaloa', '0123456789', '10000.00', '2020-08-11 10:00:47', 2, '2020-08-13 07:08:57', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `collection_center_cash_book`
--

CREATE TABLE `collection_center_cash_book` (
  `id` int(11) NOT NULL,
  `bank_account_id` int(11) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `received_date` datetime DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `collection_center_cash_book`
--

INSERT INTO `collection_center_cash_book` (`id`, `bank_account_id`, `amount`, `received_date`, `notes`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 2, '100000.00', NULL, '', '2020-08-12 12:48:48', 1, '2020-08-11 19:18:48', 1, 1),
(2, 3, '1000.00', NULL, '', '2020-08-12 07:41:46', 1, '2020-08-13 07:17:47', 1, 1),
(3, 3, '1000000.00', NULL, '', '2020-08-16 08:15:01', 1, '2020-08-16 02:46:20', 1, 0),
(6, 1, '1000000.00', NULL, '', '2020-08-16 08:17:01', 1, '2020-08-16 14:47:01', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `collection_center_stocks`
--

CREATE TABLE `collection_center_stocks` (
  `collection_center_id` int(11) NOT NULL,
  `paddy_category_id` int(11) NOT NULL,
  `available_stock` decimal(11,4) NOT NULL DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `collection_center_stocks`
--

INSERT INTO `collection_center_stocks` (`collection_center_id`, `paddy_category_id`, `available_stock`) VALUES
(6, 8, '300.0000'),
(6, 3, '200.0000'),
(6, 5, '500.0000'),
(6, 11, '400.0000'),
(6, 10, '600.0000'),
(6, 4, '500.0000'),
(5, 5, '100.0000');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `address`, `company_name`, `email_address`, `phone_number`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 'Customer 01a', 'kjhsdkjh', 'jhdh', 'sa@dsd.sdf', '0719889833', '2020-08-12 10:53:27', 1, '2020-08-12 05:27:29', 1, 4),
(2, 'Cargills Food City', 'Colombo', 'Cargills Food City', 'sales@cargills.com', '0718872343', '2020-08-12 10:57:43', 1, '2020-08-16 02:52:52', 1, 1),
(3, 'Lanka Sathosa', 'Colombo', 'Lanka Sathosa', 'sales@sathosa.lk', '0711233444', '2020-08-16 08:23:15', 1, '2020-08-16 14:53:15', 1, 1),
(4, 'Keels Super', 'Colombo', 'John Keels', 'sales@keels.com', '0712334234', '2020-08-16 08:23:36', 1, '2020-08-16 14:53:36', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `farmers`
--

CREATE TABLE `farmers` (
  `id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nic_no` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `land_size` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `farmers`
--

INSERT INTO `farmers` (`id`, `collection_center_id`, `name`, `nic_no`, `address`, `phone_number`, `land_size`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(2, 5, 'Farmer Anuradhapura 01', '1234567890v', 'address', '0712345677', '5 Acre', '2020-08-05 10:50:31', 1, '2020-08-05 05:20:31', 1, 1),
(3, 6, 'Lalith Perera', '654587994v', '12th mile post, new town, Amapara', '0713473773', '10 Acre', '2020-08-11 10:01:31', 2, '2020-08-16 02:24:50', 3, 1),
(4, 8, 'Farmer Batticaloa', '1234567890v', 'address', '0716656565', '20 Acre', '2020-08-11 10:02:19', 2, '2020-08-11 16:32:19', 2, 1),
(5, 6, 'Gunasiri Banda', '534872347v', '1/2, Colombo road, Ampara', '0737787287', '50 Acre', '2020-08-11 10:27:51', 3, '2020-08-16 02:24:03', 3, 1),
(6, 6, 'Abesekara', '765645337v', 'D/5 Ampara', '0713769881', '20 Acre', '2020-08-16 07:55:27', 3, '2020-08-16 14:25:27', 3, 1),
(7, 6, 'Sepala ekanayake', '827899889v', 'near police station, Ampara', '0713344222', '30 Acre', '2020-08-16 07:56:44', 3, '2020-08-16 14:26:44', 3, 1),
(8, 6, 'Kalpani Mendis', '868788998v', 'Addrss of Ampara', '0712323432', '50 Acre', '2020-08-16 07:58:02', 3, '2020-08-16 14:28:02', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paddy_buying_allocations`
--

CREATE TABLE `paddy_buying_allocations` (
  `id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
  `max_amount` decimal(11,3) NOT NULL,
  `min_amount` decimal(11,3) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paddy_categories`
--

CREATE TABLE `paddy_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `available_stock` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paddy_categories`
--

INSERT INTO `paddy_categories` (`id`, `name`, `description`, `available_stock`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 'Suwandel', '', '0.0000', '2020-08-09 19:18:36', 1, '2020-08-09 13:48:46', 1, 1),
(2, 'Kalu Heenati', '', '0.0000', '2020-08-09 07:28:56', 2, '2020-08-16 02:30:02', 1, 1),
(3, 'Kuruluthuda', '', '200.0000', '2020-08-16 08:01:18', 1, '2020-08-16 06:00:27', 1, 1),
(4, 'Ran Kahawanu', '', '500.0000', '2020-08-16 08:01:53', 1, '2020-08-16 04:20:01', 1, 1),
(5, 'Basmathi', '', '500.0000', '2020-08-16 08:02:15', 1, '2020-08-16 04:18:05', 1, 1),
(6, 'Sudu Heenati', '', '0.0000', '2020-08-16 08:02:28', 1, '2020-08-16 14:32:28', 1, 1),
(7, 'Suduru samba', '', '0.0000', '2020-08-16 08:03:08', 1, '2020-08-16 14:33:08', 1, 1),
(8, 'Dik Wee', '', '300.0000', '2020-08-16 08:03:40', 1, '2020-08-16 04:13:41', 1, 1),
(9, 'Rath suwandel', '', '0.0000', '2020-08-16 08:03:50', 1, '2020-08-16 14:33:50', 1, 1),
(10, 'Pachchaperumal', '', '600.0000', '2020-08-16 08:03:57', 1, '2020-08-16 06:00:27', 1, 1),
(11, 'Pokkali', '', '400.0000', '2020-08-16 08:04:03', 1, '2020-08-16 04:18:53', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paddy_expections`
--

CREATE TABLE `paddy_expections` (
  `id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` date NOT NULL,
  `amount` decimal(11,3) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paddy_prices`
--

CREATE TABLE `paddy_prices` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `paddy_category_id` int(11) NOT NULL,
  `buying_price` decimal(11,2) NOT NULL,
  `selling_price` decimal(11,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paddy_prices`
--

INSERT INTO `paddy_prices` (`id`, `date`, `paddy_category_id`, `buying_price`, `selling_price`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, '2020-08-31', 2, '10.00', '12.00', '2020-08-09 08:00:05', 2, '2020-08-09 14:30:05', 2, 1),
(2, '2020-08-13', 1, '32.00', '40.00', '2020-08-09 08:00:43', 2, '2020-08-13 07:14:44', 1, 1),
(3, '2020-08-10', 2, '10.00', '12.00', '2020-08-10 07:46:05', 2, '2020-08-10 14:16:05', 2, 1),
(4, '2020-08-11', 2, '10.00', '12.00', '2020-08-10 07:46:23', 2, '2020-08-10 14:16:23', 2, 1),
(5, '2020-08-12', 2, '10.00', '12.00', '2020-08-10 07:46:28', 2, '2020-08-10 14:16:28', 2, 1),
(6, '2020-08-13', 2, '10.00', '12.00', '2020-08-10 07:46:32', 2, '2020-08-10 14:16:32', 2, 1),
(7, '2020-08-14', 2, '10.00', '12.00', '2020-08-10 07:46:35', 2, '2020-08-10 14:16:35', 2, 1),
(8, '2020-08-15', 2, '10.00', '12.00', '2020-08-10 07:46:38', 2, '2020-08-10 14:16:38', 2, 1),
(9, '2020-08-16', 2, '10.00', '12.00', '2020-08-10 07:46:43', 2, '2020-08-10 14:16:43', 2, 1),
(10, '2020-08-17', 2, '10.00', '12.00', '2020-08-10 07:46:47', 2, '2020-08-10 14:16:47', 2, 1),
(11, '2020-08-18', 2, '10.00', '12.00', '2020-08-10 07:46:53', 2, '2020-08-10 14:16:53', 2, 1),
(12, '2020-08-19', 2, '10.00', '12.00', '2020-08-10 07:47:17', 2, '2020-08-10 14:17:17', 2, 1),
(13, '2020-08-20', 2, '10.00', '12.00', '2020-08-10 07:47:20', 2, '2020-08-10 14:17:20', 2, 1),
(14, '2020-08-21', 2, '10.00', '12.00', '2020-08-10 07:47:24', 2, '2020-08-10 14:17:24', 2, 1),
(15, '2020-08-22', 2, '10.00', '12.00', '2020-08-10 07:47:27', 2, '2020-08-10 14:17:27', 2, 1),
(16, '2020-08-23', 2, '10.00', '12.00', '2020-08-10 07:47:31', 2, '2020-08-10 14:17:31', 2, 1),
(17, '2020-08-24', 2, '10.00', '12.00', '2020-08-10 07:47:34', 2, '2020-08-10 14:17:34', 2, 1),
(18, '2020-08-25', 2, '10.00', '12.00', '2020-08-10 07:47:38', 2, '2020-08-10 14:17:38', 2, 1),
(19, '2020-08-26', 2, '10.00', '12.00', '2020-08-10 07:47:41', 2, '2020-08-10 14:17:41', 2, 1),
(20, '2020-08-27', 2, '10.00', '12.00', '2020-08-10 07:47:44', 2, '2020-08-10 14:17:44', 2, 1),
(21, '2020-08-28', 2, '10.00', '12.00', '2020-08-10 07:47:47', 2, '2020-08-10 14:17:47', 2, 1),
(22, '2020-08-29', 2, '10.00', '12.00', '2020-08-10 07:47:50', 2, '2020-08-10 14:17:50', 2, 1),
(23, '2020-08-30', 2, '10.00', '12.00', '2020-08-10 07:47:53', 2, '2020-08-10 14:17:53', 2, 1),
(24, '2020-08-05', 2, '10.00', '12.00', '2020-08-10 08:14:42', 2, '2020-08-10 14:44:42', 2, 1),
(25, '2020-08-09', 2, '10.00', '12.00', '2020-08-10 08:15:54', 2, '2020-08-10 14:45:54', 2, 1),
(26, '2020-08-08', 2, '10.00', '12.00', '2020-08-10 08:16:02', 2, '2020-08-10 14:46:02', 2, 1),
(27, '2020-08-02', 2, '10.00', '12.00', '2020-08-10 08:16:09', 2, '2020-08-10 14:46:09', 2, 1),
(28, '2020-08-03', 2, '10.00', '12.00', '2020-08-10 08:16:14', 2, '2020-08-10 14:46:14', 2, 1),
(29, '2020-08-06', 2, '10.00', '12.00', '2020-08-10 08:16:22', 2, '2020-08-10 14:46:22', 2, 1),
(30, '2020-08-07', 2, '10.00', '12.00', '2020-08-10 08:16:26', 2, '2020-08-10 14:46:26', 2, 1),
(31, '2020-07-31', 1, '34.00', '45.00', '2020-08-10 08:16:31', 2, '2020-08-10 14:46:31', 2, 1),
(32, '2020-08-16', 1, '20.00', '22.00', '2020-08-10 08:16:45', 2, '2020-08-16 02:39:15', 1, 1),
(33, '2020-08-01', 11, '34.00', '40.00', '2020-08-16 08:07:20', 1, '2020-08-16 14:37:20', 1, 1),
(34, '2020-08-01', 10, '30.00', '36.00', '2020-08-16 08:07:40', 1, '2020-08-16 14:37:40', 1, 1),
(35, '2020-08-01', 8, '30.00', '40.00', '2020-08-16 08:07:48', 1, '2020-08-16 14:37:48', 1, 1),
(36, '2020-08-01', 7, '39.00', '48.00', '2020-08-16 08:08:00', 1, '2020-08-16 14:38:00', 1, 1),
(37, '2020-08-01', 5, '50.00', '57.00', '2020-08-16 08:08:12', 1, '2020-08-16 14:38:12', 1, 1),
(38, '2020-08-01', 4, '36.50', '43.00', '2020-08-16 08:08:24', 1, '2020-08-16 14:38:24', 1, 1),
(39, '2020-08-01', 3, '35.00', '40.00', '2020-08-16 08:08:44', 1, '2020-08-16 14:38:44', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paddy_seasons`
--

CREATE TABLE `paddy_seasons` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `period` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_allowed_amount` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paddy_seasons`
--

INSERT INTO `paddy_seasons` (`id`, `name`, `description`, `period`, `max_allowed_amount`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 'Yala', NULL, 'May To August', '500.0000', '2020-08-13 00:30:40', 0, '2020-08-13 07:06:48', 1, 0),
(2, 'Maha', NULL, 'September To March', '500.0000', '2020-08-13 00:30:40', 0, '2020-08-13 07:06:48', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pay_orders`
--

CREATE TABLE `pay_orders` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `farmer_user_id` int(11) NOT NULL,
  `paid_amount` decimal(11,2) NOT NULL,
  `paid_date` datetime NOT NULL,
  `pay_notes` text COLLATE utf8_unicode_ci,
  `issued_from_bank` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pay_orders`
--

INSERT INTO `pay_orders` (`id`, `purchase_id`, `farmer_user_id`, `paid_amount`, `paid_date`, `pay_notes`, `issued_from_bank`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 1, 7, '16000.00', '2020-08-16 09:43:41', '', 0, '2020-08-16 09:43:41', 3, '2020-08-16 16:13:41', 3, 0),
(2, 2, 3, '25000.00', '2020-08-16 09:48:05', '', 0, '2020-08-16 09:48:05', 3, '2020-08-16 16:18:05', 3, 0),
(3, 3, 8, '16600.00', '2020-08-16 09:48:53', '', 0, '2020-08-16 09:48:53', 3, '2020-08-16 16:18:53', 3, 0),
(4, 4, 5, '15000.00', '2020-08-16 09:49:25', '', 0, '2020-08-16 09:49:25', 3, '2020-08-16 16:19:25', 3, 0),
(5, 5, 6, '18250.00', '2020-08-01 00:00:00', '', 0, '2020-08-16 09:50:01', 3, '2020-08-16 05:47:16', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `collection-centers-index` int(1) NOT NULL,
  `collection-centers-add` int(1) NOT NULL,
  `collection-centers-edit` int(1) NOT NULL,
  `collection-centers-delete` int(1) NOT NULL,
  `farmers-index` int(1) NOT NULL,
  `farmers-add` int(1) NOT NULL,
  `farmers-edit` int(1) NOT NULL,
  `farmers-delete` int(1) NOT NULL,
  `purchases-index` int(1) NOT NULL,
  `purchases-add` int(1) NOT NULL,
  `purchases-edit` int(1) NOT NULL,
  `purchases-delete` int(1) NOT NULL,
  `sales-index` int(1) NOT NULL,
  `sales-add` int(1) NOT NULL,
  `sales-edit` int(1) NOT NULL,
  `sales-delete` int(1) NOT NULL,
  `transfers-index` int(1) NOT NULL,
  `transfers-add` int(1) NOT NULL,
  `transfers-edit` int(1) NOT NULL,
  `transfers-delete` int(1) NOT NULL,
  `vehicles-index` int(1) NOT NULL,
  `vehicles-add` int(1) NOT NULL,
  `vehicles-edit` int(1) NOT NULL,
  `vehicles-delete` int(1) NOT NULL,
  `users-index` int(1) NOT NULL,
  `users-add` int(1) NOT NULL,
  `users-edit` int(1) NOT NULL,
  `users-delete` int(1) NOT NULL,
  `collection-centers-get_collection_centers` int(1) NOT NULL,
  `users-get_users` int(1) NOT NULL,
  `vehicles-get_vehicles` int(1) NOT NULL,
  `farmers-get_farmers` int(1) NOT NULL,
  `sales-get_sales` int(1) NOT NULL,
  `purchases-get_purchases` int(1) NOT NULL,
  `transfers-get_transfers` int(1) NOT NULL,
  `settings-index` int(1) NOT NULL,
  `settings-prices` int(1) NOT NULL DEFAULT '1',
  `settings-save_price` int(1) NOT NULL DEFAULT '1',
  `settings-get_daily_prices` int(1) NOT NULL DEFAULT '1',
  `settings-paddy_categories` int(1) NOT NULL DEFAULT '1',
  `settings-get_paddy_categories` int(1) NOT NULL DEFAULT '1',
  `settings-paddy_seasons` int(1) NOT NULL DEFAULT '1',
  `settings-get_paddy_seasons` int(1) NOT NULL DEFAULT '1',
  `settings-delete_paddy_seasons` int(1) NOT NULL DEFAULT '1',
  `settings-delete_paddy_categories` int(1) NOT NULL DEFAULT '1',
  `settings-vehicle_types` int(1) NOT NULL DEFAULT '1',
  `settings-get_vehicle_types` int(1) NOT NULL DEFAULT '1',
  `settings-delete_vehicle_type` int(1) NOT NULL DEFAULT '1',
  `settings-get_paddy_rate` int(1) NOT NULL DEFAULT '1',
  `purchases-daily_prices` int(1) NOT NULL DEFAULT '1',
  `purchases-pay` int(1) NOT NULL DEFAULT '0',
  `settings-money_allocation` int(1) NOT NULL DEFAULT '0',
  `settings-get_money_allocations` int(1) NOT NULL DEFAULT '0',
  `settings-delete_money_allocation` int(1) NOT NULL DEFAULT '0',
  `settings-bank_accounts` int(1) NOT NULL DEFAULT '0',
  `settings-get_bank_accounts` int(1) NOT NULL DEFAULT '0',
  `settings-delete_bank_account` int(1) NOT NULL DEFAULT '0',
  `reports-paddy_collection` int(1) NOT NULL DEFAULT '0',
  `reports-cash_book` int(1) NOT NULL DEFAULT '0',
  `customers-index` int(1) NOT NULL DEFAULT '0',
  `customers-add` int(1) NOT NULL DEFAULT '0',
  `customers-edit` int(1) NOT NULL DEFAULT '0',
  `customers-delete` int(1) NOT NULL DEFAULT '0',
  `customers-get_customers` int(1) NOT NULL DEFAULT '0',
  `settings-buying_limitation` int(1) NOT NULL DEFAULT '0',
  `purchases-check_max_limits` int(1) NOT NULL DEFAULT '0',
  `reports-stocks` int(1) NOT NULL DEFAULT '0',
  `transfers-issue_orders` int(1) NOT NULL DEFAULT '0',
  `transfers-collection_orders` int(1) NOT NULL DEFAULT '0',
  `transfers-issue` int(1) NOT NULL DEFAULT '0',
  `transfers-collect` int(1) NOT NULL DEFAULT '0',
  `collection-centers-view` int(1) NOT NULL DEFAULT '0',
  `farmers-view` int(1) NOT NULL DEFAULT '0',
  `sales-view` int(1) NOT NULL DEFAULT '0',
  `purchases-view` int(1) NOT NULL DEFAULT '0',
  `transfers-view` int(1) NOT NULL DEFAULT '0',
  `customers-view` int(1) NOT NULL DEFAULT '0',
  `sales-collection_orders` int(1) NOT NULL DEFAULT '0',
  `sales-issue` int(1) NOT NULL DEFAULT '0',
  `sales-check_max_limits` int(1) NOT NULL DEFAULT '0',
  `auth-profile` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `role_id`, `collection-centers-index`, `collection-centers-add`, `collection-centers-edit`, `collection-centers-delete`, `farmers-index`, `farmers-add`, `farmers-edit`, `farmers-delete`, `purchases-index`, `purchases-add`, `purchases-edit`, `purchases-delete`, `sales-index`, `sales-add`, `sales-edit`, `sales-delete`, `transfers-index`, `transfers-add`, `transfers-edit`, `transfers-delete`, `vehicles-index`, `vehicles-add`, `vehicles-edit`, `vehicles-delete`, `users-index`, `users-add`, `users-edit`, `users-delete`, `collection-centers-get_collection_centers`, `users-get_users`, `vehicles-get_vehicles`, `farmers-get_farmers`, `sales-get_sales`, `purchases-get_purchases`, `transfers-get_transfers`, `settings-index`, `settings-prices`, `settings-save_price`, `settings-get_daily_prices`, `settings-paddy_categories`, `settings-get_paddy_categories`, `settings-paddy_seasons`, `settings-get_paddy_seasons`, `settings-delete_paddy_seasons`, `settings-delete_paddy_categories`, `settings-vehicle_types`, `settings-get_vehicle_types`, `settings-delete_vehicle_type`, `settings-get_paddy_rate`, `purchases-daily_prices`, `purchases-pay`, `settings-money_allocation`, `settings-get_money_allocations`, `settings-delete_money_allocation`, `settings-bank_accounts`, `settings-get_bank_accounts`, `settings-delete_bank_account`, `reports-paddy_collection`, `reports-cash_book`, `customers-index`, `customers-add`, `customers-edit`, `customers-delete`, `customers-get_customers`, `settings-buying_limitation`, `purchases-check_max_limits`, `reports-stocks`, `transfers-issue_orders`, `transfers-collection_orders`, `transfers-issue`, `transfers-collect`, `collection-centers-view`, `farmers-view`, `sales-view`, `purchases-view`, `transfers-view`, `customers-view`, `sales-collection_orders`, `sales-issue`, `sales-check_max_limits`, `auth-profile`) VALUES
(1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1),
(2, 2, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1),
(3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0, 0, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 1, 0, 0, 0, 1, 1),
(4, 4, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0, 0, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 0, 1),
(5, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(6, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
  `collection_date` date NOT NULL,
  `total_amount` decimal(11,2) NOT NULL DEFAULT '0.00',
  `total_qty` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `purchase_notes` text COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `farmer_id`, `collection_center_id`, `collection_date`, `total_amount`, `total_qty`, `purchase_notes`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 7, 6, '2020-08-01', '16000.00', '500.0000', '', '2020-08-16 09:43:41', 3, '2020-08-16 16:13:41', 3, 1),
(2, 3, 6, '2020-08-01', '25000.00', '500.0000', 'test note', '2020-08-16 09:48:05', 3, '2020-08-16 16:18:05', 3, 1),
(3, 8, 6, '2020-08-01', '16600.00', '500.0000', 'this is a test note', '2020-08-16 09:48:53', 3, '2020-08-16 16:18:53', 3, 1),
(4, 5, 6, '2020-08-01', '15000.00', '500.0000', '', '2020-08-16 09:49:25', 3, '2020-08-16 16:19:25', 3, 1),
(5, 6, 6, '2020-08-01', '18250.00', '500.0000', '', '2020-08-16 09:50:01', 3, '2020-08-16 16:20:01', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `paddy_category_id` int(11) NOT NULL,
  `collected_amount` decimal(11,3) NOT NULL,
  `collected_rate` decimal(11,2) NOT NULL,
  `num_packs` int(11) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8_unicode_ci,
  `block_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `paddy_category_id`, `collected_amount`, `collected_rate`, `num_packs`, `notes`, `block_no`, `status`) VALUES
(1, 1, 8, '300.000', '30.00', 10, '', 'A1', 1),
(2, 1, 3, '200.000', '35.00', 25, '', 'B1', 1),
(3, 2, 5, '500.000', '50.00', 230, '', 'A1', 1),
(4, 3, 11, '400.000', '34.00', 100, '', 'F4', 1),
(5, 3, 10, '100.000', '30.00', 40, '', 'A2', 1),
(6, 4, 10, '500.000', '30.00', 15, '', 'A4', 1),
(7, 5, 4, '500.000', '36.50', 16, '', 'F5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
  `issue_date` datetime NOT NULL,
  `total_amount` decimal(11,2) NOT NULL DEFAULT '0.00',
  `total_qty` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `sale_notes` text COLLATE utf8_unicode_ci NOT NULL,
  `sale_status_id` int(2) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `collection_center_id`, `issue_date`, `total_amount`, `total_qty`, `sale_notes`, `sale_status_id`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 4, 6, '2020-08-01 00:00:00', '15200.00', '400.0000', '', 2, '2020-08-16 11:27:26', 1, '2020-08-16 06:00:27', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `paddy_category_id` int(11) NOT NULL,
  `sold_amount` decimal(11,4) NOT NULL,
  `sold_rate` decimal(11,2) NOT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `paddy_category_id`, `sold_amount`, `sold_rate`, `notes`, `status`) VALUES
(1, 1, 3, '200.0000', '40.00', '', 1),
(2, 1, 10, '200.0000', '36.00', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(11) NOT NULL,
  `from_center_id` int(11) NOT NULL,
  `to_center_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `transfer_status_id` int(1) NOT NULL DEFAULT '1',
  `transfer_notes` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `from_center_id`, `to_center_id`, `vehicle_id`, `transfer_date`, `transfer_status_id`, `transfer_notes`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 6, 5, 3, '2020-08-03', 1, '', '2020-08-16 11:36:14', 1, '2020-08-16 18:06:14', 1, 1),
(2, 6, 5, 3, '2020-08-03', 2, '', '2020-08-16 11:37:40', 1, '2020-08-16 06:08:58', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_items`
--

CREATE TABLE `transfer_items` (
  `id` int(11) NOT NULL,
  `transfer_id` int(11) NOT NULL,
  `paddy_category_id` int(11) NOT NULL,
  `transfer_amount` decimal(11,4) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transfer_items`
--

INSERT INTO `transfer_items` (`id`, `transfer_id`, `paddy_category_id`, `transfer_amount`, `status`) VALUES
(1, 2, 5, '100.0000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `collection_center_id`, `name`, `email`, `password`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 1, 0, 'Sanoj Hettige', 'sanojhettige@gmail.com', '5aadb45520dcd8726b2822a7a78bb53d794f557199d5d4abdedd2c55a4bd6ca73607605c558de3db80c8e86c3196484566163ed1327e82e8b6757d1932113cb8', '2020-08-02 15:10:38', 1, '2020-08-16 05:42:24', 3, 1),
(2, 2, 2, 'Test', 'test@jadf.sdfdf', '5aadb45520dcd8726b2822a7a78bb53d794f557199d5d4abdedd2c55a4bd6ca73607605c558de3db80c8e86c3196484566163ed1327e82e8b6757d1932113cb8', '2020-08-06 07:46:28', 1, '2020-08-16 05:42:31', 3, 1),
(3, 4, 6, 'Collection Officer', 'co@psc.com', '5aadb45520dcd8726b2822a7a78bb53d794f557199d5d4abdedd2c55a4bd6ca73607605c558de3db80c8e86c3196484566163ed1327e82e8b6757d1932113cb8', '2020-08-11 10:03:30', 2, '2020-08-16 05:42:38', 3, 1),
(4, 3, 6, 'Finance Officer', 'fo@psc.com', '5aadb45520dcd8726b2822a7a78bb53d794f557199d5d4abdedd2c55a4bd6ca73607605c558de3db80c8e86c3196484566163ed1327e82e8b6757d1932113cb8', '2020-08-11 10:03:49', 2, '2020-08-16 05:42:46', 3, 1),
(5, 2, 6, 'Manager', 'ma@psc.com', '5aadb45520dcd8726b2822a7a78bb53d794f557199d5d4abdedd2c55a4bd6ca73607605c558de3db80c8e86c3196484566163ed1327e82e8b6757d1932113cb8', '2020-08-11 10:04:02', 2, '2020-08-16 05:42:51', 3, 1),
(6, 5, 6, 'Storekeeper', 'stkp@psc.com', '5aadb45520dcd8726b2822a7a78bb53d794f557199d5d4abdedd2c55a4bd6ca73607605c558de3db80c8e86c3196484566163ed1327e82e8b6757d1932113cb8', '2020-08-11 10:04:26', 2, '2020-08-16 05:43:00', 3, 1),
(7, 4, 5, 'Anuradhapura Collection Officer', 'co1@psc.com', '5aadb45520dcd8726b2822a7a78bb53d794f557199d5d4abdedd2c55a4bd6ca73607605c558de3db80c8e86c3196484566163ed1327e82e8b6757d1932113cb8', '2020-08-14 10:17:26', 1, '2020-08-16 05:43:07', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Center Manager'),
(6, 'Clerk'),
(4, 'Collection Officer'),
(7, 'Farmer'),
(3, 'Finance Officer'),
(5, 'Storekeeper');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `registration_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `vehicle_type` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `registration_number`, `vehicle_type`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(2, 'LP-4774', 2, '2020-08-09 10:43:36', 2, '2020-08-09 17:13:36', 2, 1),
(3, 'LH-9838', 2, '2020-08-11 10:02:35', 2, '2020-08-11 16:32:35', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE `vehicle_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `name`, `description`) VALUES
(2, 'Lorry', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_centers`
--
ALTER TABLE `collection_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_center_cash_book`
--
ALTER TABLE `collection_center_cash_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_center_id` (`bank_account_id`);

--
-- Indexes for table `collection_center_stocks`
--
ALTER TABLE `collection_center_stocks`
  ADD KEY `collection_center_id` (`collection_center_id`),
  ADD KEY `paddy_category_id` (`paddy_category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `farmers`
--
ALTER TABLE `farmers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_center_id` (`collection_center_id`);

--
-- Indexes for table `paddy_buying_allocations`
--
ALTER TABLE `paddy_buying_allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_center_id` (`collection_center_id`);

--
-- Indexes for table `paddy_categories`
--
ALTER TABLE `paddy_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paddy_expections`
--
ALTER TABLE `paddy_expections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_center_id` (`collection_center_id`);

--
-- Indexes for table `paddy_prices`
--
ALTER TABLE `paddy_prices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `paddy_category_id` (`paddy_category_id`);

--
-- Indexes for table `paddy_seasons`
--
ALTER TABLE `paddy_seasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_orders`
--
ALTER TABLE `pay_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `farmer_user_id` (`farmer_user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farmer_id` (`farmer_id`),
  ADD KEY `collection_center_id` (`collection_center_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `paddy_category_id` (`paddy_category_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_center_id` (`collection_center_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `paddy_category_id` (`paddy_category_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_center_id` (`from_center_id`),
  ADD KEY `to_center_id` (`to_center_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `transfer_items`
--
ALTER TABLE `transfer_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_id` (`transfer_id`),
  ADD KEY `paddy_category_id` (`paddy_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `collection_center_id` (`collection_center_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registration_number` (`registration_number`),
  ADD KEY `vehicle_type` (`vehicle_type`);

--
-- Indexes for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `collection_centers`
--
ALTER TABLE `collection_centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `collection_center_cash_book`
--
ALTER TABLE `collection_center_cash_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `farmers`
--
ALTER TABLE `farmers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `paddy_buying_allocations`
--
ALTER TABLE `paddy_buying_allocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paddy_categories`
--
ALTER TABLE `paddy_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `paddy_expections`
--
ALTER TABLE `paddy_expections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paddy_prices`
--
ALTER TABLE `paddy_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `paddy_seasons`
--
ALTER TABLE `paddy_seasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pay_orders`
--
ALTER TABLE `pay_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfer_items`
--
ALTER TABLE `transfer_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collection_center_stocks`
--
ALTER TABLE `collection_center_stocks`
  ADD CONSTRAINT `collection_center_stocks_ibfk_1` FOREIGN KEY (`collection_center_id`) REFERENCES `collection_centers` (`id`),
  ADD CONSTRAINT `collection_center_stocks_ibfk_2` FOREIGN KEY (`paddy_category_id`) REFERENCES `paddy_categories` (`id`);

--
-- Constraints for table `farmers`
--
ALTER TABLE `farmers`
  ADD CONSTRAINT `farmers_ibfk_1` FOREIGN KEY (`collection_center_id`) REFERENCES `collection_centers` (`id`);

--
-- Constraints for table `paddy_buying_allocations`
--
ALTER TABLE `paddy_buying_allocations`
  ADD CONSTRAINT `paddy_buying_allocations_ibfk_1` FOREIGN KEY (`collection_center_id`) REFERENCES `collection_centers` (`id`);

--
-- Constraints for table `paddy_expections`
--
ALTER TABLE `paddy_expections`
  ADD CONSTRAINT `paddy_expections_ibfk_1` FOREIGN KEY (`collection_center_id`) REFERENCES `collection_centers` (`id`);

--
-- Constraints for table `paddy_prices`
--
ALTER TABLE `paddy_prices`
  ADD CONSTRAINT `paddy_prices_ibfk_1` FOREIGN KEY (`paddy_category_id`) REFERENCES `paddy_categories` (`id`);

--
-- Constraints for table `pay_orders`
--
ALTER TABLE `pay_orders`
  ADD CONSTRAINT `pay_orders_ibfk_1` FOREIGN KEY (`farmer_user_id`) REFERENCES `farmers` (`id`),
  ADD CONSTRAINT `pay_orders_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`collection_center_id`) REFERENCES `collection_centers` (`id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`);

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `purchase_items_ibfk_2` FOREIGN KEY (`paddy_category_id`) REFERENCES `paddy_categories` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`collection_center_id`) REFERENCES `collection_centers` (`id`);

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`paddy_category_id`) REFERENCES `paddy_categories` (`id`);

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_ibfk_1` FOREIGN KEY (`from_center_id`) REFERENCES `collection_centers` (`id`),
  ADD CONSTRAINT `transfers_ibfk_2` FOREIGN KEY (`to_center_id`) REFERENCES `collection_centers` (`id`),
  ADD CONSTRAINT `transfers_ibfk_3` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `transfer_items`
--
ALTER TABLE `transfer_items`
  ADD CONSTRAINT `transfer_items_ibfk_1` FOREIGN KEY (`transfer_id`) REFERENCES `transfers` (`id`),
  ADD CONSTRAINT `transfer_items_ibfk_2` FOREIGN KEY (`paddy_category_id`) REFERENCES `paddy_categories` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`vehicle_type`) REFERENCES `vehicle_types` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
