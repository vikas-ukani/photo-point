-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2020 at 03:33 PM
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

CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'which user cart',
  `product_id` bigint(20) UNSIGNED NOT NULL COMMENT 'which product on cart',
  `product_stock_id` bigint(20) DEFAULT NULL COMMENT 'product_stock details id',
  `quantity` bigint(20) NOT NULL DEFAULT 1 COMMENT 'How many product added in to cart',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `product_stock_id`, `quantity`, `created_at`, `updated_at`) VALUES
(17, 4, 5, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'to show or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `common_product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subcategory_ids` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'multiple category id wise details',
  `parent_id` bigint(20) DEFAULT NULL COMMENT 'parent of this table id ',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'name of this attributes',
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'code for check unique',
  `hex_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'color code hexa',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'check is active to show or not',
  `sequence` bigint(20) NOT NULL DEFAULT 0 COMMENT 'to set sequence wise',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `common_product_attributes_subcategory_ids_index` (`subcategory_ids`(768)),
  KEY `common_product_attributes_parent_id_index` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `common_product_attributes`
--

INSERT INTO `common_product_attributes` (`id`, `subcategory_ids`, `parent_id`, `name`, `code`, `hex_code`, `is_active`, `sequence`, `created_at`, `updated_at`) VALUES
(1, '8', NULL, 'Size', 'SIZE', NULL, 1, 1, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(2, '8', 1, '100mm', NULL, NULL, 1, 1, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(3, '6', 1, '10', NULL, NULL, 1, 1, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(4, '8', 1, '200mm', NULL, NULL, 1, 1, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(5, '8', NULL, 'Color', 'COLOR', NULL, 1, 2, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(6, '8', 5, 'Red', NULL, 'ff0000', 1, 3, '2020-01-06 18:30:00', '2020-01-06 18:30:00'),
(7, '8', 5, 'Blue', NULL, '0000ff', 1, 3, '2020-01-06 18:30:00', '2020-01-06 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE IF NOT EXISTS `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `complain_category_id` bigint(20) DEFAULT NULL,
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `images` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `complaint_categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL,
  `sequence` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'to show or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_products`
--

CREATE TABLE IF NOT EXISTS `favorite_products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL COMMENT 'user favorite wise id',
  `product_id` bigint(20) NOT NULL COMMENT 'favorite product id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `feature_products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `main_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL COMMENT 'Check Parent Id',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'category name',
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'for unique validation',
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Image for category',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'about category',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `main_categories_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`id`, `parent_id`, `name`, `code`, `image`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 0, 'Electronics', 'ELECTRONICS', '/uploaded/images/categories/ic_tshirt', 'ELECTRONICS Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(2, 0, 'Men\'s Clothing', 'MENS_CLOTHING', '/uploaded/images/categories/ic_cup', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(3, 0, 'Womens Clothing', 'WOMENS_CLOTHING', '/uploaded/images/categories/ic_bottle', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(4, 1, 'Mobile Phones', 'MOBILE_PHONES', '', 'Mobile category from electronics', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(5, 0, 'Clothing Accessories & Jewelry', 'CLOTHING_ACCESSORIES_&_JEWELRY', '/uploaded/images/categories/ic_tshirt', 'CLOTHING_ACCESSORIES_&_JEWELRY', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(6, 5, 'Shoes Accessories', 'SHOES_ACCESSORIES', '/uploaded/images/categories/ic_tshirt', 'SHOES_ACCESSORIES', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(7, 5, 'Watches & Accessories', 'WATCHES_ACCESSORIES', '/uploaded/images/categories/ic_tshirt', 'WATCHES_ACCESSORIES', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(8, 7, 'Men\'s Electronic Watches', 'Men\'s Electronic Watches', '/uploaded/images/categories/ic_tshirt', 'Men\'s Electronic Watches', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(9, 7, 'Women\'s Electronic Watches', 'Women\'s Electronic Watches', '/uploaded/images/categories/ic_tshirt', 'Women\'s Electronic Watches', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(10, 7, 'Couple\'s Mechanical Watches', 'Couple\'s Mechanical Watches', '/uploaded/images/categories/ic_tshirt', 'Couple\'s Mechanical Watches', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(11, 7, 'Other Watches', 'Other Watches', '/uploaded/images/categories/ic_tshirt', 'Other Watches', 1, '2020-01-05 18:30:00', '2020-01-05 18:30:00'),
(12, 3, 'Dress', 'Dress', '/uploaded/images/categories/dress', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(13, 3, 'Skirts', 'Skirts', '/uploaded/images/categories/dress', 'Lorem Ipsum is dummy text ', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(14, 3, 'Blouses', 'Blouses', '/uploaded/images/categories/dress', 'Lorem Ipsum is dummy text ', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(15, 3, 'Womens T-Shirts', 'Womens T-Shirts', '/uploaded/images/categories/dress', 'Lorem Ipsum is dummy text ', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(16, 3, 'Women\'s Sweaters', 'Women\'s Sweaters', '/uploaded/images/categories/dress', 'Lorem Ipsum is dummy text ', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(17, 3, 'Women\'s Suits', 'Women\'s Suits', '/uploaded/images/categories/dress', 'Lorem Ipsum is dummy text ', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(18, 3, 'Women\'s Jackets', 'Women\'s Jackets', '/uploaded/images/categories/dress', 'Lorem Ipsum is dummy text ', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(19, 3, 'Women\'s Jeans', 'Women\'s Jeans', '/uploaded/images/categories/dress', 'Lorem Ipsum is dummy text ', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(20, 3, 'Women\'s Leggings', 'Women\'s Leggings', '/uploaded/images/categories/dress', 'Lorem Ipsum is dummy text ', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(21, 3, 'Ethnic Wear', 'Ethnic Wear', '/uploaded/images/categories/dress', 'Lorem Ipsum is dummy text ', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(22, 2, 'T-shirts', 'T-shirts', '/uploaded/images/categories/tshirt', 'Lorem Ipsum text.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(23, 2, 'Shirts', 'Shirts', '/uploaded/images/categories/tshirt', 'Lorem Ipsum text.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(24, 2, 'Advertising Shirts', 'Advertising Shirts', '/uploaded/images/categories/tshirt', 'Lorem Ipsum text.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(25, 2, 'Casual Couple Clothing', 'Casual Couple Clothing', '/uploaded/images/categories/tshirt', 'Lorem Ipsum text.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(26, 2, ' Casual Suit', 'Casual Suit', '/uploaded/images/categories/tshirt', 'Lorem Ipsum text.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(27, 2, ' Jackets', 'Jackets', '/uploaded/images/categories/tshirt', 'Lorem Ipsum text.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00'),
(28, 2, ' Leather Jackets', 'Leather Jackets', '/uploaded/images/categories/tshirt', 'Lorem Ipsum text.', 1, '2019-12-01 18:30:00', '2019-12-01 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `updated_at` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL COMMENT 'user wise order details',
  `product_id` bigint(20) DEFAULT NULL COMMENT 'product details id',
  `product_details` text DEFAULT NULL COMMENT 'set product image name and price',
  `address_detail` text DEFAULT NULL,
  `delevery_address_id` bigint(20) DEFAULT NULL COMMENT 'customer delevery address id',
  `customer_name` text DEFAULT NULL,
  `total_amount` varchar(20) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  `order_date` timestamp NULL DEFAULT NULL,
  `expected_date` timestamp NULL DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL COMMENT 'use  constants here,',
  `transaction_id` varchar(100) DEFAULT NULL COMMENT 'transaction id from order',
  `transaction_type` varchar(100) DEFAULT NULL COMMENT 'transaction TYPE from order',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `product_details`, `address_detail`, `delevery_address_id`, `customer_name`, `total_amount`, `quantity`, `order_date`, `expected_date`, `status`, `transaction_id`, `transaction_type`, `created_at`, `updated_at`) VALUES
(1, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PENDING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(2, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PACKAGING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(3, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PENDING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(4, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PICK_UP', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(5, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PENDING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(6, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PENDING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(7, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'DISPATCH', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(8, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PENDING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(9, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'DELIVERED', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(10, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PENDING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(11, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'CANCELLED\r\n', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(12, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PENDING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(13, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PENDING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(14, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'CANCELLED', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24'),
(15, 10, NULL, '{\"quantity\":\"1\",\"stock_inventory_id\":\"4\",\"id\":\"22\",\"sale_price\":\"1\",\"image\":\"http:\\/\\/comedyclassroom.com\\/uploaded\\/images\\/products\\/5e21c1cdd0405\",\"size\":\"100mm\",\"color_code\":\"0000ff\",\"color_name\":\"Blue\",\"name\":\"Step 2: Product Information.\"}', '{\"mobile\":\"8866569630\",\"city_id\":\"1\",\"line2\":\"punagam, surat\",\"alternate_mobile\":\"9925423766\",\"pincode\":\"395010\",\"line1\":\"A15, harekrishna soci., me. birds farm\",\"country_id\":\"1\",\"state_id\":\"1\"}', NULL, NULL, '1', '1', '2020-01-28 14:39:24', '2020-02-04 14:39:24', 'PENDING', 'pay_E9vq3CHFdP4lss', 'RAZOR', '2020-01-28 14:39:24', '2020-01-28 14:39:24');

-- --------------------------------------------------------

--
-- Table structure for table `order_rate_reviews`
--

CREATE TABLE IF NOT EXISTS `order_rate_reviews` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `main_category_id` bigint(20) DEFAULT NULL COMMENT 'Main category details',
  `sub_category_id` bigint(20) DEFAULT NULL COMMENT 'Main category details',
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL COMMENT 'User wise product',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Product Name',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'product is active or not.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `main_category_id`, `sub_category_id`, `category_id`, `user_id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 5, 7, 8, NULL, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:38:13', '2020-01-17 14:38:13'),
(2, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(3, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(4, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(5, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(6, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(7, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(8, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(9, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(10, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(11, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(12, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(13, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(14, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(15, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(16, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47'),
(17, 5, 7, 8, 7, 'Step 2: Product Information.', '\"<h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><h5>Description<\\/h5><p><br><\\/p>\"', 1, '2020-01-17 14:52:36', '2020-01-20 15:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes_details`
--

CREATE TABLE IF NOT EXISTS `product_attributes_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL COMMENT 'Product Filter Ids',
  `common_product_attribute_id` bigint(20) NOT NULL COMMENT 'common attribute id',
  `value` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'common attribute id value',
  `values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'multiple common attribute id values.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_inventories`
--

CREATE TABLE IF NOT EXISTS `product_stock_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Product Stock Manager',
  `common_product_attribute_size_id` bigint(20) UNSIGNED NOT NULL COMMENT 'common product size attributes',
  `common_product_attribute_color_id` bigint(20) UNSIGNED NOT NULL COMMENT 'common product color attributes',
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stock wise images',
  `sale_price` int(11) NOT NULL COMMENT 'selling price',
  `mrp_price` int(11) NOT NULL COMMENT 'MRP price',
  `stock_available` int(11) NOT NULL COMMENT 'number of items available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_stock_inventories_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_stock_inventories`
--

INSERT INTO `product_stock_inventories` (`id`, `product_id`, `common_product_attribute_size_id`, `common_product_attribute_color_id`, `images`, `sale_price`, `mrp_price`, `stock_available`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 6, '/uploaded/images/products/5e21c1c5daa36,/uploaded/images/products/5e21ca27dad1e-makhi1', 1, 2, 3, '2020-01-17 14:38:13', '2020-01-17 14:38:13'),
(2, 2, 2, 7, '/uploaded/images/products/5e21c1cdd0405,/uploaded/images/products/5e21c1c5daa36', 1, 12, 123, '2020-01-17 14:38:13', '2020-01-17 14:38:13'),
(4, 3, 2, 7, '/uploaded/images/products/5e21c1cdd0405', 1, 12, 123, '2020-01-20 13:35:05', '2020-01-20 13:35:05'),
(5, 4, 2, 6, 'http://localhost:1001/uploaded/images/products/5e21c1c5daa36,/uploaded/images/products/5e21c1c5daa36', 1, 2, 3, '2020-01-20 13:40:20', '2020-01-20 14:55:46'),
(6, 5, 4, 7, 'http://localhost:1001/uploaded/images/products/5e25bf87dbbd5,http://localhost:1001/uploaded/images/products/5e25bf87dbbd5,/uploaded/images/products/5e25bf87dbbd5', 20, 200, 2000, '2020-01-20 14:57:37', '2020-01-20 15:09:28'),
(7, 6, 4, 6, 'http://localhost:1001/uploaded/images/products/5e25bf8eb736d,http://localhost:1001/uploaded/images/products/5e25bf8eb736d,http://localhost:1001/uploaded/images/products/5e25bf8eb736d,/uploaded/images/products/5e25bf8eb736d', 30, 300, 3000, '2020-01-20 14:57:37', '2020-01-20 15:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `shoppers`
--

CREATE TABLE IF NOT EXISTS `shoppers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` bigint(20) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'to show or not',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `user_delevery_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_delevery_addresses`
--

INSERT INTO `user_delevery_addresses` (`id`, `user_id`, `name`, `mobile`, `alternate_mobile`, `pincode`, `line1`, `line2`, `country_id`, `state_id`, `city_id`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 4, 'Vikas Updated Address', '9876543210', '12456789987', 395010, 'Updated Line 1', 'Upted Line 2', 2, 2, 2, 1, '2019-11-30 16:33:30', '2019-12-14 17:43:19'),
(2, 6, 'Test Address Second', '9876543210', '12456789987', 395010, NULL, NULL, NULL, NULL, NULL, 0, '2019-11-30 16:45:53', '2019-11-30 17:22:43'),
(3, 4, 'Saragam So', '9876543210', '12456789987', 395010, NULL, NULL, NULL, NULL, NULL, 0, '2019-11-30 16:45:53', '2019-12-14 17:43:19'),
(4, 4, 'Anil Address', '9876543210', '12456789987', 395010, 'Santiniketan soc', 'Near Dangigev Soc', 1, 1, 1, 0, '2019-11-30 17:24:21', '2019-12-14 17:43:19'),
(5, 4, 'Anil Address', '9876543210', '12456789987', 395010, 'Santiniketan soc', 'Near Dangigev Soc', 1, 1, 1, 0, '2019-12-19 15:17:21', '2019-12-19 15:17:21');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
