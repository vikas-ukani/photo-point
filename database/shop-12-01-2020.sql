-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2020 at 03:02 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

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

DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'which user cart',
  `product_id` bigint(20) UNSIGNED NOT NULL COMMENT 'which product on cart',
  `quantity` bigint(20) NOT NULL DEFAULT 1 COMMENT 'How many product added in to cart',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(2, 5, 2, 5, '2019-12-04 16:30:31', '2019-12-04 16:52:00'),
(6, 4, 26, 1, '2019-12-13 17:07:11', '2019-12-13 17:07:11'),
(7, 10, 30, 2, '2019-12-13 17:07:49', '2019-12-13 17:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'to show or not',
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
-- Table structure for table `common_product_attributes`
--

DROP TABLE IF EXISTS `common_product_attributes`;
CREATE TABLE `common_product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_ids` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'multiple category id wise details',
  `parent_id` bigint(20) DEFAULT NULL COMMENT 'parent of this table id ',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'name of this attributes',
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'code for check unique',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'check is active to show or not',
  `sequence` bigint(20) NOT NULL DEFAULT 0 COMMENT 'to set sequence wise',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `common_product_attributes`
--

INSERT INTO `common_product_attributes` (`id`, `subcategory_ids`, `parent_id`, `name`, `code`, `is_active`, `sequence`, `created_at`, `updated_at`) VALUES
(1, '8', NULL, 'Size', 'SIZE', 1, 1, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(2, '8', 1, '100mm', NULL, 1, 1, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(3, '6', 1, '10', NULL, 1, 1, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(4, '8', 1, '200mm', NULL, 1, 1, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(5, '8', NULL, 'Color', 'COLOR', 1, 2, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(6, '8', 5, 'Red', NULL, 1, 3, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(7, '8', 5, 'Blue', NULL, 1, 3, '2020-01-06 18:30:00', '2020-01-06 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `complain_category_id` bigint(20) DEFAULT NULL,
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `images` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `subject`, `description`, `complain_category_id`, `order_id`, `user_id`, `images`, `updated_at`, `created_at`) VALUES
(1, 'Test Subject  Updated', 'description Updated.', 1, 1, 4, '/uploaded/images/complaints/5dfdece3983b5-f7b23a8b-5786-4ba0-9ddd-a181ac43d36a-a2e8ad10-4de3-48a9-b13d-8db5a30e4c07-compressed-40,/uploaded/images/complaints/5dfdece398b85-bbjslj4', '2019-12-21 09:58:59', '2019-12-20 17:57:49'),
(3, 'First Live Complaint.', 'First Complaint.', 1, 1, 4, '/uploaded/images/complaints/5dff7361313c4-f7b23a8b-5786-4ba0-9ddd-a181ac43d36a-a2e8ad10-4de3-48a9-b13d-8db5a30e4c07-compressed-40,/uploaded/images/complaints/5dff73613274c-bbjslj4', '2019-12-22 13:45:05', '2019-12-22 13:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_categories`
--

DROP TABLE IF EXISTS `complaint_categories`;
CREATE TABLE `complaint_categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL,
  `sequence` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaint_categories`
--

INSERT INTO `complaint_categories` (`id`, `name`, `code`, `sequence`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Updated Complaint Categories', 'COMPLAINT_CATEGORIES_UPDATE', 2, 1, '2019-12-21 11:34:24', '2019-12-21 12:26:41'),
(3, 'Order not placed after checkout', 'ORDER_NOT_PLACED_AFTER_CHECKOUT', NULL, 1, '2019-12-22 08:14:27', '2019-12-22 08:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'to show or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- Error reading data for table shopikana.countries: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `shopikana`.`countries`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_products`
--

DROP TABLE IF EXISTS `favorite_products`;
CREATE TABLE `favorite_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'user favorite wise id',
  `product_id` bigint(20) NOT NULL COMMENT 'favorite product id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorite_products`
--

INSERT INTO `favorite_products` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 4, 4, NULL, NULL),
(2, 4, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feature_products`
--

DROP TABLE IF EXISTS `feature_products`;
CREATE TABLE `feature_products` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feature_products`
--

INSERT INTO `feature_products` (`id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL),
(3, 52, '2019-12-29 08:57:38', '2019-12-29 08:57:38'),
(6, 6, '2019-12-29 11:10:58', '2019-12-29 11:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `main_categories`
--

DROP TABLE IF EXISTS `main_categories`;
CREATE TABLE `main_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL COMMENT 'Check Parent Id',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'category name',
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'for unique validation',
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Image for category',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'about category',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`id`, `parent_id`, `name`, `code`, `image`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 0, 'Electronics', 'ELECTRONICS', '/uploaded/images/categories/ic_tshirt', 'ELECTRONICS Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(2, 0, 'Men\'s Clothing', 'MENS_CLOTHING', '/uploaded/images/categories/ic_cup', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(3, 0, 'Womens Clothing', 'WOMENS_CLOTHING', '/uploaded/images/categories/ic_bottle', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(4, 1, 'Mobile Phones', 'MOBILE_PHONES', '', 'Mobile category from electronics', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(5, 0, 'Clothing Accessories & Jewelry', 'CLOTHING_ACCESSORIES_&_JEWELRY', '/uploaded/images/categories/', 'CLOTHING_ACCESSORIES_&_JEWELRY', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(6, 5, 'Shoes Accessories', 'SHOES_ACCESSORIES', '/uploaded/images/categories/', 'SHOES_ACCESSORIES', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(7, 5, 'Watches & Accessories', 'WATCHES_ACCESSORIES', '/uploaded/images/categories/', 'WATCHES_ACCESSORIES', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(8, 7, 'Men\'s Electronic Watches', 'Men\'s Electronic Watches', '/uploaded/images/categories/', 'Men\'s Electronic Watches', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(9, 7, 'Women\'s Electronic Watches', 'Women\'s Electronic Watches', '/uploaded/images/categories/', 'Women\'s Electronic Watches', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(10, 7, 'Couple\'s Mechanical Watches', 'Couple\'s Mechanical Watches', '/uploaded/images/categories/', 'Couple\'s Mechanical Watches', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(11, 7, 'Other Watches', 'Other Watches', '/uploaded/images/categories/', 'Other Watches', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
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
(16, '2019_12_04_151403_create_carts_table', 8),
(17, '2019_12_30_140104_create_favorite_products_table', 9),
(18, '2020_01_05_082154_create_product_attributes_details_table', 10),
(19, '2020_01_04_110630_create_common_product_attributes_table', 11),
(20, '2020_01_12_071523_create_product_stock_inventories_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- Error reading data for table shopikana.oauth_access_tokens: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `shopikana`.`oauth_access_tokens`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
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

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
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

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
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

DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` bigint(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount` bigint(20) NOT NULL,
  `valid_from` timestamp NULL DEFAULT NULL,
  `valid_to` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL COMMENT 'Offer Descriptions',
  `category_id` bigint(20) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `name`, `code`, `discount`, `valid_from`, `valid_to`, `description`, `category_id`, `is_active`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Offer 1', 'OFFER_1', 1, '2019-12-19 17:59:27', '2020-01-19 17:59:27', NULL, 1, 1, NULL, '2019-12-20 15:28:02', '2019-12-20 15:28:02'),
(2, 'Offer 10% off on every mugs', 'MUG_10', 10, '2019-12-19 17:59:27', '2020-01-19 17:59:27', NULL, 2, 1, NULL, '2019-12-20 15:28:58', '2019-12-20 15:28:58'),
(3, 'Test Offer 1', 'TEST_1', 1, '2019-12-19 17:59:27', '2020-01-19 17:59:27', NULL, 2, 1, '/uploaded/images/offers/5dff4ea12a210-78173092-2693931594002076-4139927746937618432-n', '2019-12-22 11:08:17', '2019-12-22 11:48:11'),
(4, 'Test Offer 1', 'TEST_11', 1, '2019-12-19 17:59:27', '2020-01-19 17:59:27', 'The Test Descriptions', 2, 1, '/uploaded/images/offers/5dff52033a210-78173092-2693931594002076-4139927746937618432-n', '2019-12-22 11:22:43', '2019-12-22 11:22:43'),
(5, 'admin', 'ADMIN123', 12, '2019-12-22 06:34:18', '2019-12-23 06:34:21', 'admin Description Description Description Description Description Description Description Description Description Description ', 3, 1, '/uploaded/images/offers/5dff6b32c386b-shutterstock-217775473', '2019-12-22 13:10:10', '2019-12-22 13:10:10'),
(6, 'admin updated', 'ADMIN1234', 12, '2019-12-22 06:34:18', '2019-12-23 06:34:21', 'admin Description Description Description Description Description Description Description Description Description Description ', 3, 1, '/uploaded/images/offers/5dff6b718b079-indian-12-places', '2019-12-22 13:10:20', '2019-12-22 13:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'user wise order details',
  `customer_name` text DEFAULT NULL,
  `address_detail` text DEFAULT NULL,
  `product_details` text DEFAULT NULL,
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
(1, 10, 'Test Order', '{\"line1\":\"Updated Line 1\",\"line2\":\"Upted Line 2\",\"pincode\":\"395010\",\"country_id\":\"2\",\"state_id\":\"2\",\"city_id\":\"2\",\"mobile\":\"9876543210\",\"alternate_mobile\":\"12456789987\"}', '[{\"id\":11,\"category_id\":\"2\",\"name\":\"test\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"price\":\"242.00\",\"size\":\"4242\",\"size_number\":\"242424\",\"description\":\"242424\",\"is_active\":true}]', '', NULL, NULL, 'PENDING', '2019-12-16 16:07:18', '2019-12-16 16:07:18'),
(2, 6, 'Approved Order', '{\"line1\":\"Updated Line 1\",\"line2\":\"Upted Line 2\",\"pincode\":\"395010\",\"country_id\":\"2\",\"state_id\":\"2\",\"city_id\":\"2\",\"mobile\":\"9876543210\",\"alternate_mobile\":\"12456789987\"}', '[{\"id\":11,\"category_id\":\"2\",\"name\":\"test\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"price\":\"242.00\",\"size\":\"4242\",\"size_number\":\"242424\",\"description\":\"242424\",\"is_active\":true}]', '', '2019-12-16 16:37:20', '2019-12-23 16:37:20', 'COMPLETED', '2019-12-16 16:22:42', '2019-12-16 16:22:42'),
(3, 4, 'First Order', '{\"line1\":\"Updated Line 1\",\"line2\":\"Upted Line 2\",\"pincode\":\"395010\",\"country_id\":\"2\",\"state_id\":\"2\",\"city_id\":\"2\",\"mobile\":\"9876543210\",\"alternate_mobile\":\"12456789987\"}', '[{\"id\":11,\"category_id\":\"2\",\"name\":\"test\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"price\":\"242.00\",\"size\":\"4242\",\"size_number\":\"242424\",\"description\":\"242424\",\"is_active\":true}]', '', NULL, NULL, 'PENDING', '2019-12-16 16:24:12', '2019-12-16 16:24:12'),
(4, 4, 'Rejected Order', '{\"line1\":\"Updated Line 1\",\"line2\":\"Upted Line 2\",\"pincode\":\"395010\",\"country_id\":\"2\",\"state_id\":\"2\",\"city_id\":\"2\",\"mobile\":\"9876543210\",\"alternate_mobile\":\"12456789987\"}', '[{\"id\":11,\"category_id\":\"2\",\"name\":\"test\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"price\":\"242.00\",\"size\":\"4242\",\"size_number\":\"242424\",\"description\":\"242424\",\"is_active\":true}]', '', '2019-12-16 16:37:20', '2019-12-23 16:37:20', 'CANCELED', '2019-12-16 16:37:20', '2019-12-16 16:37:20'),
(5, 4, 'Just Order', '{\"line1\":\"Updated Line 1\",\"line2\":\"Upted Line 2\",\"pincode\":\"395010\",\"country_id\":\"2\",\"state_id\":\"2\",\"city_id\":\"2\",\"mobile\":\"9876543210\",\"alternate_mobile\":\"12456789987\"}', '[{\"id\":11,\"category_id\":\"2\",\"name\":\"test\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"price\":\"242.00\",\"size\":\"4242\",\"size_number\":\"242424\",\"description\":\"242424\",\"is_active\":true}]', '', '2019-12-16 16:37:54', '2019-12-23 16:37:54', 'RUNNING', '2019-12-16 16:37:54', '2019-12-16 16:37:54'),
(6, 7, 'Vikas Ukani', '{\"line1\":\"Punagam \",\"line2\":\"Address 1\",\"pincode\":\"395010\",\"country_id\":\"2\",\"state_id\":\"2\",\"city_id\":\"2\",\"mobile\":\"9876543210\",\"alternate_mobile\":\"12456789987\"}', '[{\"id\":11,\"category_id\":\"2\",\"name\":\"Cup WOW\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"price\":\"242.00\",\"size\":\"4242\",\"size_number\":\"242424\",\"description\":\"242424\",\"is_active\":true}]', '', '2019-12-16 16:42:07', '2019-12-23 16:42:07', 'INCOMPLETE', '2019-12-16 16:42:07', '2019-12-16 16:42:07'),
(7, 1, 'Anil Order', '{\"line1\":\"Punagam \",\"line2\":\"Address 1\",\"pincode\":\"395010\",\"country_id\":\"2\",\"state_id\":\"2\",\"city_id\":\"2\",\"mobile\":\"9876543210\",\"alternate_mobile\":\"12456789987\"}', '[{\"id\":11,\"category_id\":\"2\",\"name\":\"Cup WOW\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"price\":\"242.00\",\"size\":\"4242\",\"size_number\":\"242424\",\"description\":\"242424\",\"is_active\":true}]', '', '2019-12-16 17:12:15', '2019-12-23 17:12:15', 'PENDING', '2019-12-16 17:12:15', '2019-12-16 17:12:15'),
(8, 4, 'nail', '{\"line1\":\"harekrishna socientry, me.borda farm\",\"pincode\":\"395010\",\"state_id\":\"1\",\"line2\":\"punagam, Surat\",\"country_id\":\"1\",\"alternate_mobile\":\"9726253099\",\"mobile\":\"8866569630\",\"city_id\":\"1\"}', '[{\"name\":\"Vikas Lead Up to date\",\"description\":\"ajsdjkahsdjhajkshd\",\"size_number\":\"asjkdaskjdh\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"id\":\"15\",\"category_id\":\"1\",\"size\":\"asjkdhajk\",\"is_active\":true,\"price\":\"125.00\"},{\"name\":\"test\",\"description\":\"242424\",\"size_number\":\"242424\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"id\":\"13\",\"category_id\":\"1\",\"size\":\"4242\",\"is_active\":true,\"price\":\"242.00\"}]', '', '2019-12-16 17:21:19', '2019-12-23 17:21:19', 'PENDING', '2019-12-16 17:21:19', '2019-12-16 17:21:19'),
(9, 4, 'nail', '{\"line1\":\"harekrishna socientry, me.borda farm\",\"pincode\":\"395010\",\"state_id\":\"1\",\"line2\":\"punagam, Surat\",\"country_id\":\"1\",\"alternate_mobile\":\"9726253099\",\"mobile\":\"8866569630\",\"city_id\":\"1\"}', '[{\"name\":\"Vikas Lead Up to date\",\"description\":\"ajsdjkahsdjhajkshd\",\"size_number\":\"asjkdaskjdh\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"id\":\"15\",\"category_id\":\"1\",\"size\":\"asjkdhajk\",\"is_active\":true,\"price\":\"125.00\"},{\"name\":\"test\",\"description\":\"242424\",\"size_number\":\"242424\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"id\":\"13\",\"category_id\":\"1\",\"size\":\"4242\",\"is_active\":true,\"price\":\"242.00\"}]', '', '2019-12-16 17:22:22', '2019-12-23 17:22:22', 'PENDING', '2019-12-16 17:22:22', '2019-12-16 17:22:22'),
(10, 4, 'nail', '{\"line1\":\"harekrishna socientry, me.borda farm\",\"pincode\":\"395010\",\"state_id\":\"1\",\"line2\":\"punagam, Surat\",\"country_id\":\"1\",\"alternate_mobile\":\"9726253099\",\"mobile\":\"8866569630\",\"city_id\":\"1\"}', '[{\"name\":\"Vikas Lead Up to date\",\"description\":\"ajsdjkahsdjhajkshd\",\"size_number\":\"asjkdaskjdh\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"id\":\"15\",\"category_id\":\"1\",\"size\":\"asjkdhajk\",\"is_active\":true,\"price\":\"125.00\"},{\"name\":\"test\",\"description\":\"242424\",\"size_number\":\"242424\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"id\":\"13\",\"category_id\":\"1\",\"size\":\"4242\",\"is_active\":true,\"price\":\"242.00\"}]', '', '2019-12-16 17:36:41', '2019-12-23 17:36:41', 'PENDING', '2019-12-16 17:36:41', '2019-12-16 17:36:41'),
(11, 4, 'anail', '{\"line1\":\"harekrishna socientry, me.borda farm\",\"pincode\":\"395010\",\"state_id\":\"1\",\"line2\":\"punagam, Surat\",\"country_id\":\"1\",\"alternate_mobile\":\"9726253099\",\"mobile\":\"8866569630\",\"city_id\":\"1\"}', '[{\"name\":\"Vikas Lead Up to date\",\"description\":\"ajsdjkahsdjhajkshd\",\"size_number\":\"asjkdaskjdh\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"id\":\"15\",\"category_id\":\"1\",\"size\":\"asjkdhajk\",\"is_active\":true,\"price\":\"125.00\"},{\"name\":\"test\",\"description\":\"242424\",\"size_number\":\"242424\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/categories\\/ic_tshirt\",\"id\":\"13\",\"category_id\":\"1\",\"size\":\"4242\",\"is_active\":true,\"price\":\"242.00\"}]', '367', '2019-12-17 15:12:15', '2019-12-24 15:12:15', 'PENDING', '2019-12-17 15:12:15', '2019-12-17 15:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_rate_reviews`
--

DROP TABLE IF EXISTS `order_rate_reviews`;
CREATE TABLE `order_rate_reviews` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_rate_reviews`
--

INSERT INTO `order_rate_reviews` (`id`, `order_id`, `product_id`, `user_id`, `review`, `rate`, `created_at`, `updated_at`) VALUES
(1, 11, 11, 4, 'This Product was not much good!', 4, '2019-12-17 17:02:41', '2019-12-17 17:02:41'),
(2, 11, 134, 4, 'This Product was too good!', 2, '2019-12-17 17:03:15', '2019-12-17 17:03:15'),
(3, 11, 11, 4, NULL, 2, '2019-12-18 14:47:55', '2019-12-18 14:47:55'),
(4, 11, 11, 4, 'This Product was not much good!', 4, '2019-12-17 17:02:41', '2019-12-17 17:02:41'),
(5, 11, 11, 4, 'This Product was too good!', 2, '2019-12-17 17:03:15', '2019-12-17 17:03:15'),
(6, 11, 11, 4, NULL, 2, '2019-12-18 14:47:55', '2019-12-18 14:47:55'),
(7, 11, 2, 4, 'This Product was not much good!', 4, '2019-12-17 17:02:41', '2019-12-17 17:02:41'),
(8, 11, 11, 4, 'This Product was too good!', 2, '2019-12-17 17:03:15', '2019-12-17 17:03:15'),
(9, 11, 11, 4, NULL, 2, '2019-12-18 14:47:55', '2019-12-18 14:47:55'),
(10, 11, 11, 4, 'This Product was not much good!', 4, '2019-12-17 17:02:41', '2019-12-17 17:02:41'),
(11, 11, 11, 4, 'This Product was too good!', 2, '2019-12-17 17:03:15', '2019-12-17 17:03:15'),
(12, 11, 11, 4, NULL, 2, '2019-12-18 14:47:55', '2019-12-18 14:47:55');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Product Name',
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `size` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Multiple Sizes.',
  `color` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'color',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'product is active or not.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `image`, `price`, `size`, `color`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 3, 'Clear Bottle', '/uploaded/images/categories/ic_tshirt', 2500.00, 'S', '1600', 'First Bottle', 1, '2019-12-08 12:51:49', '2019-12-08 16:17:20'),
(3, 3, 'Vikas Lead', '/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:56:32', '2019-12-08 16:14:53'),
(4, 2, 'Vikas Lead Up to', '/uploaded/images/categories/ic_tshirt,/uploaded/images/categories/ic_tshirt,/uploaded/images/categories/ic_tshirt', 125.00, 'asjkdhajk', 'asjkdaskjdh', 'ajsdjkahsdjhajkshd', 1, '2019-12-08 12:57:02', '2019-12-30 13:24:15'),
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
(52, 2, 'te', '/uploaded/images/products/5e04d1000561e-vrushik', 123.00, 'M', 't', 'et', 1, '2019-12-26 15:25:32', '2019-12-26 15:25:52'),
(53, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(54, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(55, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(56, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(57, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(58, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(59, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(60, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(61, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(62, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(63, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(64, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(65, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(66, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(67, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(68, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(69, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(70, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(71, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(72, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(73, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(74, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(75, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(76, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(77, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(78, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(79, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(80, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(81, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(82, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(83, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(84, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(85, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(86, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(87, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(88, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(89, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(90, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(91, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(92, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(93, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(94, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(95, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(96, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(97, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(98, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(99, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(100, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(101, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(102, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(103, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(104, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(105, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(106, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(107, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(108, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(109, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(110, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(111, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(112, 1, 'test', '/uploaded/images/categories/ic_tshirt', 242.00, '4242', '242424', '242424', 1, '2019-12-08 16:20:19', '2019-12-11 17:03:39'),
(113, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:25:47', '2020-01-05 13:25:47'),
(114, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:32:41', '2020-01-05 13:32:41'),
(115, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:33:25', '2020-01-05 13:33:25'),
(116, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:35:15', '2020-01-05 13:35:15'),
(117, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:41:00', '2020-01-05 13:41:00'),
(119, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:42:33', '2020-01-05 13:42:33'),
(121, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:44:47', '2020-01-05 13:44:47'),
(123, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:45:24', '2020-01-05 13:45:24'),
(124, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:45:25', '2020-01-05 13:45:25'),
(125, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:53:38', '2020-01-05 13:53:38'),
(126, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:57:59', '2020-01-05 13:57:59'),
(127, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 13:59:20', '2020-01-05 13:59:20'),
(128, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 14:02:25', '2020-01-05 14:02:25'),
(129, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 14:02:49', '2020-01-05 14:02:49'),
(130, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 14:04:27', '2020-01-05 14:04:27'),
(131, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-05 14:04:36', '2020-01-05 14:04:36'),
(132, 1, '4 Image Product T-Shirt', NULL, 5000.00, NULL, NULL, NULL, 0, '2020-01-12 12:28:41', '2020-01-12 12:28:41'),
(134, 8, 'Stock Product', NULL, 5000.00, NULL, NULL, '<h5>Description</h5>', 1, '2020-01-12 13:05:52', '2020-01-12 13:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes_details`
--

DROP TABLE IF EXISTS `product_attributes_details`;
CREATE TABLE `product_attributes_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL COMMENT 'Product Filter Ids',
  `common_product_attribute_id` bigint(20) NOT NULL COMMENT 'common attribute id',
  `value` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'common attribute id value',
  `values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'multiple common attribute id values.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes_details`
--

INSERT INTO `product_attributes_details` (`id`, `product_id`, `common_product_attribute_id`, `value`, `values`, `created_at`, `updated_at`) VALUES
(1, 128, 1, NULL, '2,3,4', '2020-01-05 14:02:26', '2020-01-05 14:02:26'),
(2, 128, 2, NULL, '5,6', '2020-01-05 14:02:26', '2020-01-05 14:02:26'),
(3, 128, 3, NULL, '8,9', '2020-01-05 14:02:26', '2020-01-05 14:02:26'),
(4, 129, 1, NULL, '2,3,4', '2020-01-05 14:02:49', '2020-01-05 14:02:49'),
(5, 129, 2, NULL, '5,6', '2020-01-05 14:02:50', '2020-01-05 14:02:50'),
(6, 129, 3, NULL, '8,9', '2020-01-05 14:02:50', '2020-01-05 14:02:50'),
(7, 130, 1, NULL, '2,3,4', '2020-01-05 14:04:27', '2020-01-05 14:04:27'),
(8, 130, 2, NULL, '5,6', '2020-01-05 14:04:28', '2020-01-05 14:04:28'),
(9, 130, 3, NULL, '8,9', '2020-01-05 14:04:28', '2020-01-05 14:04:28'),
(10, 131, 1, NULL, '2,3,4', '2020-01-05 14:04:37', '2020-01-05 14:04:37'),
(11, 131, 2, NULL, '5,6', '2020-01-05 14:04:37', '2020-01-05 14:04:37'),
(12, 131, 3, NULL, '8,9', '2020-01-05 14:04:37', '2020-01-05 14:04:37'),
(13, 132, 1, NULL, '2,3,4', '2020-01-12 12:28:41', '2020-01-12 12:28:41'),
(14, 132, 2, NULL, '5,6', '2020-01-12 12:28:41', '2020-01-12 12:28:41'),
(15, 132, 3, NULL, '8,9', '2020-01-12 12:28:41', '2020-01-12 12:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_inventories`
--

DROP TABLE IF EXISTS `product_stock_inventories`;
CREATE TABLE `product_stock_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Product Stock Manager',
  `common_product_attribute_size_id` bigint(20) UNSIGNED NOT NULL COMMENT 'common product size attributes',
  `common_product_attribute_color_id` bigint(20) UNSIGNED NOT NULL COMMENT 'common product color attributes',
  `sale_price` int(11) NOT NULL COMMENT 'selling price',
  `mrp_price` int(11) NOT NULL COMMENT 'MRP price',
  `stock_available` int(11) NOT NULL COMMENT 'number of items available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_stock_inventories`
--

INSERT INTO `product_stock_inventories` (`id`, `product_id`, `common_product_attribute_size_id`, `common_product_attribute_color_id`, `sale_price`, `mrp_price`, `stock_available`, `created_at`, `updated_at`) VALUES
(1, 134, 2, 7, 1000, 1100, 55, '2020-01-12 13:05:52', '2020-01-12 13:05:52'),
(2, 134, 3, 8, 2000, 2200, 5000, '2020-01-12 13:05:52', '2020-01-12 13:05:52'),
(3, 134, 5, 18, 5000, 5500, 15000, '2020-01-12 13:05:52', '2020-01-12 13:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `shoppers`
--

DROP TABLE IF EXISTS `shoppers`;
CREATE TABLE `shoppers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User photo',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'is approved or not',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shoppers`
--

INSERT INTO `shoppers` (`id`, `first_name`, `last_name`, `email`, `photo`, `email_verified_at`, `password`, `mobile`, `is_active`, `is_approved`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Shopper', 'Test', 'shopper@gmail.com', '/uploaded/images/users/5dfa5c1bc31a7-78587562-426551851581600-4898895523802513408-n', NULL, '$2y$12$cjN2QRBES7BMo3pc/IglE.BvXTCT9D7yd20cHmIxMLyhsKL3/rRK.', '1234567890', 1, 1, NULL, '2019-12-24 14:40:00', '2019-12-27 15:53:09'),
(4, 'V', 'Test', 'shopper1@gmail.com', NULL, NULL, '$2y$10$DDTxcarE6XxTDGtvLv8Pe.N/on9FaPn1G/HvDJ9D/wRk0ot4PyK7O', '2234567890', 1, 1, NULL, '2019-12-27 15:30:32', '2019-12-27 15:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'to show or not',
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

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` int(11) NOT NULL DEFAULT 0 COMMENT '0 = User, 1 = admin',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User photo',
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
(4, 'vikas', 'ukani', 0, 'vikas123@mailinator.com', '/uploaded/images/users/5dfa5c1bc31a7-78587562-426551851581600-4898895523802513408-n', NULL, '$2y$10$EEtu82/motJ4cfFPSvHUHOUw2mnqsjCFBBi3ixo1NAourlol2K1VK', '9876543210', NULL, '2019-11-24 07:37:14', '2019-12-20 17:36:39'),
(6, 'test', '123', 0, 'test123@gmail.com', NULL, NULL, '$2y$10$8zzqoJ2f2Miyb56Xz73eU.jD0nBLYMf9Gln2Un61C4t2HSh0MJofS', '9090909090', NULL, '2019-11-28 17:59:05', '2019-11-28 17:59:05'),
(7, 'admin', NULL, 1, 'admin@gmail.com', NULL, NULL, '$2y$12$Xq8doEnL2NRjwHQM5wcUbuHjGIrz5WvFpTJad4pscqTxHsfNa5aRa', '9876543210', NULL, '2019-12-07 18:30:00', '2019-12-07 18:30:00'),
(10, 'Anil', 'Dhameliya', 0, 'anil@gmail.com', NULL, NULL, '$2y$10$sRf0B/tWr4K6eS3MGc2GFOeuko4bEUx9YkyPVGWpmBKL4WfVXfQGq', '8866569630', NULL, '2019-12-11 17:28:07', '2019-12-11 17:28:07'),
(11, 'Anil', 'dhameliya', 0, 'anil11@gmail.com', NULL, NULL, '$2y$10$MzIiOrfCSmH89z0E2YW1KuULXOQRImY5FeYZXryqeWXX3qixJfU62', '8866569630', NULL, '2019-12-20 17:13:49', '2019-12-20 17:13:49'),
(12, 'Anil', 'dhameliya', 0, 'anil111@gmail.com', NULL, NULL, '$2y$10$9rt2IzEYikTD9QaRXTVj5uvddViHjmeXOEnSouh23X4QQCKIfEjNS', '8866569630', NULL, '2019-12-23 14:45:22', '2019-12-23 14:45:22'),
(13, 'Anil', 'dhameliya', 0, 'anil1111@gmail.com', NULL, NULL, '$2y$10$xoTOXFtE5/fsWlN9ZfDi1.1/qb7LN3fQP/RL8jrTKETd19SkHSGZ6', '8866569630', NULL, '2019-12-23 14:45:29', '2019-12-23 14:45:29'),
(14, 'Anil', 'dhameliya', 0, 'anil11111@gmail.com', NULL, NULL, '$2y$10$b42etUV9nT5jl6cLzMb25eGMgNJAK5gArMvfH45DEAixzM2duBK/i', '8866569630', NULL, '2019-12-23 14:45:59', '2019-12-23 14:45:59'),
(15, 'Anil', 'dhameliya', 0, 'anil111111@gmail.com', NULL, NULL, '$2y$10$2PXqM9CVmluqnV16KBHK0uG4yrvm0maob6tHrf6f1oTq0FVGFgIsK', '8866569630', NULL, '2019-12-23 14:46:23', '2019-12-23 14:46:23'),
(16, 'Anil', 'dhameliya', 0, 'anil1111111@gmail.com', NULL, NULL, '$2y$10$LIHvetZUQUHJvr0JC0Pp5e8IvFwaLr.3CKZzAjmo8AN1t2zLKfY/6', '8866569630', NULL, '2019-12-23 14:47:01', '2019-12-23 14:47:01'),
(17, 'Anil', 'dhameliya', 0, 'anil11111111@gmail.com', NULL, NULL, '$2y$10$mwvk228TPpUoqEoTWWcAG.u2yV4EqVet5FSxmTSN5SpnWuxfr1wj.', '8866569630', NULL, '2019-12-23 14:48:59', '2019-12-23 14:48:59'),
(18, 'Anil', 'dhameliya', 0, 'anil111111111@gmail.com', NULL, NULL, '$2y$10$j8usv35EnhSw6ao7DsJCdOv8FpxD4okJ/GYoCJ4OIOlQPOoHK18yy', '8866569630', NULL, '2019-12-23 14:49:52', '2019-12-23 14:49:52'),
(19, 'Anil', 'dhameliya', 0, 'anil11111111111111111@gmail.com', NULL, NULL, '$2y$10$uDsO/IP/D8n/s3ESWp5zMuhv7ZUyPWpV6sV1gtxT03FfIqxKpGJ5a', '8866569630111', NULL, '2019-12-23 15:09:12', '2019-12-23 15:09:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_delevery_addresses`
--

DROP TABLE IF EXISTS `user_delevery_addresses`;
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
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'default delevery address',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_delevery_addresses`
--

INSERT INTO `user_delevery_addresses` (`id`, `user_id`, `name`, `mobile`, `alternate_mobile`, `pincode`, `line1`, `line2`, `country_id`, `state_id`, `city_id`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 4, 'Vikas Updated Address', '9876543210', '12456789987', 395010, 'Updated Line 1', 'Upted Line 2', 2, 2, 2, 1, '2019-11-30 16:33:30', '2019-12-14 17:43:19'),
(2, 6, 'Test Address Second', '9876543210', '12456789987', 395010, NULL, NULL, NULL, NULL, NULL, 0, '2019-11-30 16:45:53', '2019-11-30 17:22:43'),
(3, 4, 'Saragam So', '9876543210', '12456789987', 395010, NULL, NULL, NULL, NULL, NULL, 0, '2019-11-30 16:45:53', '2019-12-14 17:43:19'),
(4, 4, 'Anil u Address', '9876543210', '12456789987', 395010, 'Santiniketan soc', 'Near Dangigev Soc', 1, 1, 1, 0, '2019-11-30 17:24:21', '2019-12-14 17:43:19'),
(5, 4, 'Anil u Address', '9876543210', '12456789987', 395010, 'Santiniketan soc', 'Near Dangigev Soc', 1, 1, 1, 0, '2019-12-19 15:17:21', '2019-12-19 15:17:21');

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
-- Indexes for table `common_product_attributes`
--
ALTER TABLE `common_product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `common_product_attributes_subcategory_ids_index` (`subcategory_ids`(768)),
  ADD KEY `common_product_attributes_parent_id_index` (`parent_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaint_categories`
--
ALTER TABLE `complaint_categories`
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
-- Indexes for table `favorite_products`
--
ALTER TABLE `favorite_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feature_products`
--
ALTER TABLE `feature_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

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
-- Indexes for table `product_attributes_details`
--
ALTER TABLE `product_attributes_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stock_inventories`
--
ALTER TABLE `product_stock_inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_stock_inventories_product_id_foreign` (`product_id`);

--
-- Indexes for table `shoppers`
--
ALTER TABLE `shoppers`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `common_product_attributes`
--
ALTER TABLE `common_product_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `complaint_categories`
--
ALTER TABLE `complaint_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `favorite_products`
--
ALTER TABLE `favorite_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feature_products`
--
ALTER TABLE `feature_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_rate_reviews`
--
ALTER TABLE `order_rate_reviews`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `product_attributes_details`
--
ALTER TABLE `product_attributes_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_stock_inventories`
--
ALTER TABLE `product_stock_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shoppers`
--
ALTER TABLE `shoppers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_delevery_addresses`
--
ALTER TABLE `user_delevery_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_stock_inventories`
--
ALTER TABLE `product_stock_inventories`
  ADD CONSTRAINT `product_stock_inventories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
