-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 20, 2019 at 09:50 AM
-- Server version: 5.6.46-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopikana`
--
DROP DATABASE IF EXISTS `shopikana`;
CREATE DATABASE IF NOT EXISTS `shopikana` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `shopikana`;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'which user cart',
  `product_id` bigint(20) UNSIGNED NOT NULL COMMENT 'which product on cart',
  `quantity` bigint(20) NOT NULL DEFAULT '1' COMMENT 'How many product added in to cart',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(8, 10, 11, 1, '2019-12-20 11:40:43', '2019-12-20 11:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'to show or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Surat', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00'),
(2, 1, 'Vapi', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00'),
(3, 2, 'Gandhinagar', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'to show or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'India', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00'),
(2, 'USA', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_categories`
--

CREATE TABLE `main_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'category name',
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'for unique validation',
  `image` text COLLATE utf8mb4_unicode_ci COMMENT 'Image for category',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'about category',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`id`, `name`, `code`, `image`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'T-Shirt', 'T_SHIRT', '/uploaded/images/categories/ic_tshirt', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(2, 'Mug', 'MUG', '/uploaded/images/categories/ic_cup', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(3, 'Water bottle', 'WATER_BOTTLE', '/uploaded/images/categories/ic_bottle', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(4, 'Test Category', 'TEST', 'This is the test categry', NULL, 0, '2019-12-01 18:30:00', '2019-12-01 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(10, '2019_11_27_160353_create_user_delevery_addresses_table', 2),
(11, '2019_11_30_173452_create_countries_table', 3),
(12, '2019_11_30_173526_create_states_table', 4),
(13, '2019_11_30_173558_create_cities_table', 5),
(14, '2019_12_02_160909_create_main_categories_table', 6),
(15, '2019_12_02_165508_create_products_table', 7),
(16, '2019_12_04_151403_create_carts_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount` bigint(20) NOT NULL,
  `valid_from` timestamp NULL DEFAULT NULL,
  `valid_to` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'user wise order details',
  `customer_name` text,
  `address_detail` text,
  `product_details` text,
  `total_amount` varchar(20) NOT NULL,
  `order_date` timestamp NULL DEFAULT NULL,
  `expected_date` timestamp NULL DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL COMMENT 'use  constants here,',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `address_detail`, `product_details`, `total_amount`, `order_date`, `expected_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 10, 'nail', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, Surat\",\"alternate_mobile\":\"9726253099\",\"pincode\":\"395010\",\"line1\":\"harekrishna socientry, me.borda farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', '[{\"quantity\":\"1\",\"id\":\"5\",\"category_id\":\"1\",\"price\":\"125.00\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"size\":\"asjkdhajk\",\"size_number\":\"asjkdaskjdh\",\"description\":\"ajsdjkahsdjhajkshd\",\"name\":\"Vikas Lead Up to date\",\"is_active\":true}]', '175', '2019-12-17 16:23:42', '2019-12-24 16:23:42', 'PENDING', '2019-12-17 16:23:42', '2019-12-17 16:23:42'),
(2, 10, 'nail', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, Surat\",\"alternate_mobile\":\"9726253099\",\"pincode\":\"395010\",\"line1\":\"harekrishna socientry, me.borda farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', '[{\"quantity\":\"4\",\"id\":\"6\",\"category_id\":\"1\",\"price\":\"125.00\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"size\":\"asjkdhajk\",\"size_number\":\"asjkdaskjdh\",\"description\":\"ajsdjkahsdjhajkshd\",\"name\":\"Vikas Lead Up to date\",\"is_active\":\"\"}]', '292', '2019-12-19 13:56:19', '2019-12-26 13:56:19', 'PENDING', '2019-12-19 13:56:19', '2019-12-19 13:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `order_rate_reviews`
--

CREATE TABLE `order_rate_reviews` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `review` text,
  `rate` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_rate_reviews`
--

INSERT INTO `order_rate_reviews` (`id`, `order_id`, `product_id`, `user_id`, `review`, `rate`, `created_at`, `updated_at`) VALUES
(1, 11, 6, 4, 'This Product was not much good!', 4, '2019-12-17 17:02:41', '2019-12-17 17:02:41'),
(2, 11, 6, 4, 'This Product was too good!', 2, '2019-12-17 17:03:15', '2019-12-17 17:03:15'),
(3, 11, 11, 4, NULL, 3, '2019-12-18 14:47:55', '2019-12-18 14:47:55'),
(4, 11, 11, 4, NULL, 3, '2019-12-18 15:01:26', '2019-12-18 15:01:26'),
(5, 1, 5, 10, 'Good product', 3, '2019-12-18 15:02:25', '2019-12-18 15:02:25'),
(6, 1, 5, 10, 'Nice', 5, '2019-12-18 15:16:52', '2019-12-18 15:16:52'),
(7, 1, 5, 10, 'Great product', 5, '2019-12-18 15:17:29', '2019-12-18 15:17:29'),
(8, 11, 11, 4, 'This Product was not much good!', 4, '2019-12-17 17:02:41', '2019-12-17 17:02:41'),
(9, 11, 11, 4, 'This Product was too good!', 2, '2019-12-17 17:03:15', '2019-12-17 17:03:15'),
(10, 11, 11, 4, NULL, 3, '2019-12-18 14:47:55', '2019-12-18 14:47:55'),
(11, 11, 11, 4, NULL, 3, '2019-12-18 15:01:26', '2019-12-18 15:01:26'),
(12, 1, 5, 10, 'Good product', 3, '2019-12-18 15:02:25', '2019-12-18 15:02:25'),
(13, 1, 5, 10, 'Nice', 5, '2019-12-18 15:16:52', '2019-12-18 15:16:52'),
(14, 1, 5, 10, 'Great product', 5, '2019-12-18 15:17:29', '2019-12-18 15:17:29'),
(15, 11, 11, 4, 'This Product was not much good!', 4, '2019-12-17 17:02:41', '2019-12-17 17:02:41'),
(16, 11, 11, 4, 'This Product was too good!', 2, '2019-12-17 17:03:15', '2019-12-17 17:03:15'),
(17, 11, 11, 4, NULL, 3, '2019-12-18 14:47:55', '2019-12-18 14:47:55'),
(18, 11, 11, 4, NULL, 3, '2019-12-18 15:01:26', '2019-12-18 15:01:26'),
(19, 1, 5, 10, 'Good product', 3, '2019-12-18 15:02:25', '2019-12-18 15:02:25'),
(20, 1, 5, 10, 'Nice', 5, '2019-12-18 15:16:52', '2019-12-18 15:16:52'),
(21, 1, 5, 10, 'Great product', 5, '2019-12-18 15:17:29', '2019-12-18 15:17:29'),
(22, 11, 11, 4, 'This Product was not much good!', 4, '2019-12-17 17:02:41', '2019-12-17 17:02:41'),
(23, 11, 11, 4, 'This Product was too good!', 2, '2019-12-17 17:03:15', '2019-12-17 17:03:15'),
(24, 11, 11, 4, NULL, 3, '2019-12-18 14:47:55', '2019-12-18 14:47:55'),
(25, 11, 11, 4, NULL, 3, '2019-12-18 15:01:26', '2019-12-18 15:01:26'),
(26, 1, 5, 10, 'Good product', 3, '2019-12-18 15:02:25', '2019-12-18 15:02:25'),
(27, 1, 5, 10, 'Nice', 5, '2019-12-18 15:16:52', '2019-12-18 15:16:52'),
(28, 1, 5, 10, 'Great product', 5, '2019-12-18 15:17:29', '2019-12-18 15:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Product Name',
  `image` text COLLATE utf8mb4_unicode_ci,
  `price` double(8,2) NOT NULL,
  `size` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Multiple Sizes.',
  `color` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'color',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'product is active or not.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `image`, `price`, `size`, `color`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 3, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(3, 3, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(4, 2, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(5, 3, 'Vikas Lead Up to date', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-11 17:31:43'),
(6, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(7, 3, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(8, 3, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(9, 2, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(10, 3, 'Vikas Lead Up to date', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-11 17:31:43'),
(11, 2, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(12, 1, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(13, 3, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(14, 2, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(15, 2, 'Vikas Lead Up to date', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-11 17:31:43'),
(16, 2, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(17, 3, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(18, 3, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(19, 1, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(20, 3, 'Vikas Lead Up to date', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-11 17:31:43'),
(21, 2, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(22, 1, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(23, 3, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(24, 2, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(25, 3, 'Vikas Lead Up to date', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-11 17:31:43'),
(26, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(27, 3, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(28, 1, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(29, 2, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(30, 1, 'Vikas Lead Up to date', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-11 17:31:43'),
(31, 2, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(32, 3, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(33, 1, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(34, 2, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(35, 1, 'Vikas Lead Up to date', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-11 17:31:43'),
(36, 2, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(37, 3, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(38, 3, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(39, 2, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(40, 3, 'Vikas Lead Up to date', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-11 17:31:43'),
(41, 2, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(42, 3, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(43, 3, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(44, 1, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(45, 3, 'Vikas Lead Up to date', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-11 17:31:43'),
(46, 2, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(47, 1, 'Test 1', '/uploaded/images/products/5dfcf45e30747-79406102-2530773683820769-5121035359815204864-o,/uploaded/images/products/5dfcf45e31ad0-74450535-2606915029370400-2229721336731664384-n', 20.00, 'M', 'RED', NULL, 1, '2019-12-20 16:18:38', '2019-12-20 16:18:38'),
(48, 1, 'Test 1', '/uploaded/images/products/5dfcf8bde286d-79406102-2530773683820769-5121035359815204864-o,/uploaded/images/products/5dfcf8bde3056-74450535-2606915029370400-2229721336731664384-n', 20.00, 'M', 'RED', NULL, 1, '2019-12-20 16:37:17', '2019-12-20 16:37:17'),
(49, 1, '4 Image Product T-Shirt', '/uploaded/images/products/5dfcf9629995a-9917890-134014611381066-7047524364702449664-n,/uploaded/images/products/5dfcf9629a07e-70814269-2549135971814973-8422720275237306368-o,/uploaded/images/products/5dfcf9629a649-73105660-2613161468745756-7551225596462759936-n,/uploaded/images/products/5dfcf9629ab96-73357379-2610585509003352-8222699430604701696-n', 5000.00, 'M', 'Brown', NULL, 1, '2019-12-20 16:40:02', '2019-12-20 16:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `products_copy`
--

CREATE TABLE `products_copy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Product Name',
  `image` text COLLATE utf8mb4_unicode_ci,
  `price` double(8,2) NOT NULL,
  `size` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Multiple Sizes.',
  `size_number` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'numeric size number.',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'product is active or not.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_copy`
--

INSERT INTO `products_copy` (`id`, `category_id`, `name`, `image`, `price`, `size`, `size_number`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 3, 'Clear Bottle', '/uploaded/images/products/5ded221066dd5-download-3', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(3, 3, 'Vikas Lead', '/uploaded/images/products/5ded217dda7ca-download', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(4, 2, 'Vikas Lead Up to', '/uploaded/images/products/5ded1dd698fc2-new-doc-2017-11-27', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-08 16:10:19'),
(5, 3, 'Vikas Lead Up to date', '/uploaded/images/products/5ded1e14f34ea-img-0619', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:58:25', '2019-12-08 16:09:52'),
(6, 2, 'test', '/uploaded/images/products/5ded22d28554c-download', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-08 16:20:34');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'to show or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gujarat', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00'),
(2, 1, 'Ahemedabad', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00'),
(3, 1, 'Pune', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00'),
(4, 1, 'Maharastra', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00'),
(5, 1, 'Delhi', 1, '2019-11-29 18:30:00', '2019-11-29 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` int(11) NOT NULL DEFAULT '0' COMMENT '0 = User, 1 = admin',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci COMMENT 'User photo',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_type`, `email`, `photo`, `email_verified_at`, `password`, `mobile`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'vikas', 'ukani', 0, 'vikas123@mailinator.com', '/uploaded/images/users/5dfa5e2fa74cf-78587562-426551851581600-4898895523802513408-n', NULL, '$2y$10$SoDaGWTDQkhFpykSDL6gCu6vbbJeb6ZaTbh.GJQIQTOPnZzLPccMi', '9876543210', NULL, '2019-11-24 07:37:14', '2019-12-18 17:13:19'),
(6, 'test', '123', 0, 'test123@gmail.com', NULL, NULL, '$2y$10$8zzqoJ2f2Miyb56Xz73eU.jD0nBLYMf9Gln2Un61C4t2HSh0MJofS', '9090909090', NULL, '2019-11-28 17:59:05', '2019-11-28 17:59:05'),
(7, 'admin', NULL, 1, 'admin@gmail.com', NULL, NULL, '$2y$12$Xq8doEnL2NRjwHQM5wcUbuHjGIrz5WvFpTJad4pscqTxHsfNa5aRa', '9876543210', NULL, '2019-12-07 18:30:00', '2019-12-07 18:30:00'),
(10, 'Anil', 'Dhameliya', 0, 'anil@gmail.com', '/uploaded/images/users/5dfa63480d42a-o4z0r', NULL, '$2y$10$sRf0B/tWr4K6eS3MGc2GFOeuko4bEUx9YkyPVGWpmBKL4WfVXfQGq', '8866569630', NULL, '2019-12-11 17:28:07', '2019-12-18 17:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_delevery_addresses`
--

CREATE TABLE `user_delevery_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL COMMENT 'User address id',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User Delevery name',
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User mobile',
  `alternate_mobile` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Alter mobile ',
  `pincode` int(11) DEFAULT NULL,
  `line1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'address line 1',
  `line2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'address line 2',
  `country_id` bigint(20) DEFAULT NULL COMMENT 'Country id',
  `state_id` bigint(20) DEFAULT NULL,
  `city_id` bigint(20) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'default delevery address',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_delevery_addresses`
--

INSERT INTO `user_delevery_addresses` (`id`, `user_id`, `name`, `mobile`, `alternate_mobile`, `pincode`, `line1`, `line2`, `country_id`, `state_id`, `city_id`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 4, 'Vikas Updated Address', '9876543210', '12456789987', 395010, 'Updated Line 1', 'Upted Line 2', 2, 2, 2, 1, '2019-11-30 16:33:30', '2019-12-14 17:43:38'),
(2, 6, 'Test Address Second', '9876543210', '12456789987', 395010, NULL, NULL, NULL, NULL, NULL, 0, '2019-11-30 16:45:53', '2019-11-30 17:22:43'),
(3, 4, 'Saragam So', '9876543210', '12456789987', 395010, NULL, NULL, NULL, NULL, NULL, 0, '2019-11-30 16:45:53', '2019-12-14 17:43:38'),
(4, 4, 'Anil u Address', '9876543210', '12456789987', 395010, 'Santiniketan soc', 'Near Dangigev Soc', 1, 1, 1, 0, '2019-11-30 17:24:21', '2019-12-14 17:43:38'),
(6, 10, 'nail', '8866569630', '9726253099', 395010, 'harekrishna socientry, me.borda farm', 'punagam, Surat', 1, 1, 1, 1, '2019-12-15 09:20:26', '2019-12-20 16:34:30'),
(8, 10, 'Hardik', '9726253099', '8866569630', 395010, 'vfdsgfd', '6+6', 1, 1, 1, 0, '2019-12-15 09:43:42', '2019-12-20 16:34:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_categories`
--
ALTER TABLE `main_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `main_categories_code_unique` (`code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_rate_reviews`
--
ALTER TABLE `order_rate_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `products_copy`
--
ALTER TABLE `products_copy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_delevery_addresses`
--
ALTER TABLE `user_delevery_addresses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_rate_reviews`
--
ALTER TABLE `order_rate_reviews`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `products_copy`
--
ALTER TABLE `products_copy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_delevery_addresses`
--
ALTER TABLE `user_delevery_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
