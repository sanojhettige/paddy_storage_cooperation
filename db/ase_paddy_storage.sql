-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 12, 2020 at 03:25 PM
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
(8, 'Batticaloa', 'Batticaloa', 'Batticaloa', '0123456789', '10000.00', '2020-08-11 10:00:47', 2, '2020-08-11 16:30:47', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `collection_center_cash_book`
--

CREATE TABLE `collection_center_cash_book` (
  `id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
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

INSERT INTO `collection_center_cash_book` (`id`, `collection_center_id`, `amount`, `received_date`, `notes`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 5, '100000.00', NULL, '', '2020-08-12 12:48:48', 1, '2020-08-11 19:18:48', 1, 1);

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
(2, 2, '100000.0000'),
(3, 2, '0.0000'),
(6, 2, '105000.0000');

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
(3, 6, 'Farmer Ampara 01', '78754758757v', 'address', '0713473773', '10 Acre', '2020-08-11 10:01:31', 2, '2020-08-11 16:31:31', 2, 1),
(4, 8, 'Farmer Batticaloa', '1234567890v', 'address', '0716656565', '20 Acre', '2020-08-11 10:02:19', 2, '2020-08-11 16:32:19', 2, 1),
(5, 6, 'Farmer New 123', '834872347v', 'khsdh', '0737787287', '50 Acre', '2020-08-11 10:27:51', 3, '2020-08-11 16:57:51', 3, 1);

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
(2, 'Kalu Heenati', '', '105000.0000', '2020-08-09 07:28:56', 2, '2020-08-11 04:59:42', 2, 1);

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
(2, '2020-08-04', 1, '32.00', '40.00', '2020-08-09 08:00:43', 2, '2020-08-09 14:30:43', 2, 1),
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
(31, '2020-08-01', 2, '10.00', '12.00', '2020-08-10 08:16:31', 2, '2020-08-10 14:46:31', 2, 1),
(32, '2020-08-01', 1, '20.00', '22.00', '2020-08-10 08:16:45', 2, '2020-08-10 14:46:45', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paddy_seasons`
--

CREATE TABLE `paddy_seasons` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `period` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paddy_seasons`
--

INSERT INTO `paddy_seasons` (`id`, `name`, `description`, `period`) VALUES
(1, 'Yala', NULL, 'May To August'),
(2, 'Maha', NULL, 'September To March');

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
(1, 2, 5, '50000.00', '2020-08-11 00:00:00', 'hjsgdfsdfsdfsdf', 0, '2020-08-11 11:23:36', 4, '2020-08-11 06:29:07', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
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
  `settings-delete_money_allocation` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`role_id`, `collection-centers-index`, `collection-centers-add`, `collection-centers-edit`, `collection-centers-delete`, `farmers-index`, `farmers-add`, `farmers-edit`, `farmers-delete`, `purchases-index`, `purchases-add`, `purchases-edit`, `purchases-delete`, `sales-index`, `sales-add`, `sales-edit`, `sales-delete`, `transfers-index`, `transfers-add`, `transfers-edit`, `transfers-delete`, `vehicles-index`, `vehicles-add`, `vehicles-edit`, `vehicles-delete`, `users-index`, `users-add`, `users-edit`, `users-delete`, `collection-centers-get_collection_centers`, `users-get_users`, `vehicles-get_vehicles`, `farmers-get_farmers`, `sales-get_sales`, `purchases-get_purchases`, `transfers-get_transfers`, `settings-index`, `settings-prices`, `settings-save_price`, `settings-get_daily_prices`, `settings-paddy_categories`, `settings-get_paddy_categories`, `settings-paddy_seasons`, `settings-get_paddy_seasons`, `settings-delete_paddy_seasons`, `settings-delete_paddy_categories`, `settings-vehicle_types`, `settings-get_vehicle_types`, `settings-delete_vehicle_type`, `settings-get_paddy_rate`, `purchases-daily_prices`, `purchases-pay`, `settings-money_allocation`, `settings-get_money_allocations`, `settings-delete_money_allocation`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1),
(2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1),
(3, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0, 0, 1, 0, 1, 1, 1, 0, 0, 0),
(4, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0, 0, 1, 0, 1, 1, 0, 0, 0, 0),
(5, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0),
(6, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
  `collection_date` datetime NOT NULL,
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

INSERT INTO `purchases` (`id`, `farmer_id`, `collection_center_id`, `collection_date`, `purchase_notes`, `created_at`, `created_by`, `modified_at`, `modified_by`, `status`) VALUES
(1, 2, 2, '2020-08-11 00:00:00', '', '2020-08-11 08:50:51', 2, '2020-08-11 15:20:51', 2, 1),
(2, 5, 6, '2020-08-11 00:00:00', '', '2020-08-11 10:29:42', 3, '2020-08-11 16:59:42', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `paddy_category_id` int(11) NOT NULL,
  `collected_amount` decimal(11,4) NOT NULL,
  `collected_rate` decimal(11,2) NOT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `paddy_category_id`, `collected_amount`, `collected_rate`, `notes`, `status`) VALUES
(1, 1, 2, '100000.0000', '10.00', '', 1),
(2, 2, 2, '5000.0000', '10.00', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `collection_center_id` int(11) NOT NULL,
  `issue_date` datetime NOT NULL,
  `sale_notes` text COLLATE utf8_unicode_ci NOT NULL,
  `sale_status_id` int(2) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 2, 3, NULL, '2020-08-11', 2, '', '2020-08-11 08:51:09', 2, '2020-08-11 15:21:09', 2, 1),
(2, 3, 2, 2, '2020-08-11', 2, '', '2020-08-11 08:51:36', 2, '2020-08-11 03:35:48', 2, 1);

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
(1, 1, 2, '50000.0000', 1),
(5, 2, 2, '50000.0000', 1);

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
(1, 1, 0, 'Sanoj Hettige', 'sanojhettige@gmail.com', '123', '2020-08-02 15:10:38', 1, '2020-08-02 09:40:38', 1, 1),
(2, 2, 2, 'Test', 'test@jadf.sdfdf', '12345', '2020-08-06 07:46:28', 1, '2020-08-06 14:16:28', 1, 1),
(3, 4, 6, 'Collection Officer', 'co@psc.com', '123', '2020-08-11 10:03:30', 2, '2020-08-11 16:33:30', 2, 1),
(4, 3, 6, 'Finance Officer', 'fo@psc.com', '123', '2020-08-11 10:03:49', 2, '2020-08-11 16:33:49', 2, 1),
(5, 2, 6, 'Manager', 'ma@psc.com', '123', '2020-08-11 10:04:02', 2, '2020-08-11 16:34:02', 2, 1),
(6, 5, 6, 'Storekeeper', 'stkp@psc.com', '123', '2020-08-11 10:04:26', 2, '2020-08-11 16:34:26', 2, 1);

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
(6, 'Clerk'),
(4, 'Collection Officer'),
(7, 'Farmer'),
(3, 'Finance Officer'),
(2, 'Manager'),
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
-- Indexes for table `collection_centers`
--
ALTER TABLE `collection_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_center_cash_book`
--
ALTER TABLE `collection_center_cash_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_center_id` (`collection_center_id`);

--
-- Indexes for table `collection_center_stocks`
--
ALTER TABLE `collection_center_stocks`
  ADD KEY `collection_center_id` (`collection_center_id`),
  ADD KEY `paddy_category_id` (`paddy_category_id`);

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
  ADD KEY `role_id` (`role_id`);

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
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `collection_center_id` (`collection_center_id`);

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
-- AUTO_INCREMENT for table `collection_centers`
--
ALTER TABLE `collection_centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `collection_center_cash_book`
--
ALTER TABLE `collection_center_cash_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `farmers`
--
ALTER TABLE `farmers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paddy_buying_allocations`
--
ALTER TABLE `paddy_buying_allocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paddy_categories`
--
ALTER TABLE `paddy_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `paddy_expections`
--
ALTER TABLE `paddy_expections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paddy_prices`
--
ALTER TABLE `paddy_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `paddy_seasons`
--
ALTER TABLE `paddy_seasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pay_orders`
--
ALTER TABLE `pay_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfer_items`
--
ALTER TABLE `transfer_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `collection_center_cash_book`
--
ALTER TABLE `collection_center_cash_book`
  ADD CONSTRAINT `collection_center_cash_book_ibfk_1` FOREIGN KEY (`collection_center_id`) REFERENCES `collection_centers` (`id`);

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
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`);

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
