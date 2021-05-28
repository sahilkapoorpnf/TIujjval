-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2020 at 03:25 PM
-- Server version: 5.7.32
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loadus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userimage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `userimage`, `api_key`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Vikram', 'adminLoadus@yopmail.com', '$2y$10$GFHL1t0WccdbnXyJ4xK7Uep7BaRs8xlP7pvBa9xTyIdlbnGiBythO', 'public/uploads/admin/profile/5f44ef0747a2ddownload.jpeg', NULL, NULL, 1, NULL, '2020-08-25 05:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `group_flowers`
--

CREATE TABLE `group_flowers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '1 - Group; 2 - Flower',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `privacy` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Public, 0:Private',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active; 0- Inactive',
  `password` varchar(50) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: featured, o;not featured',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: Deleted, 0: not deleted',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_flowers`
--

INSERT INTO `group_flowers` (`id`, `user_id`, `type`, `name`, `description`, `image`, `parent_id`, `privacy`, `status`, `password`, `is_featured`, `is_deleted`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 20, 1, 'group-1', '<p>xyz</p>', '', 0, 1, 1, NULL, 0, 0, '2020-08-18 15:57:54', '2020-08-28 11:35:42', NULL),
(2, 18, 2, 'Flower 3', '<p>Test Flower 3</p>', '', 0, 1, 1, NULL, 0, 0, '2020-08-18 15:57:54', '2020-09-15 07:41:24', NULL),
(7, 16, 1, 'vikram', '<p>asdasd</p>', '', 0, 0, 1, '123456', 1, 0, '2020-08-26 11:14:36', '2020-08-31 08:05:48', NULL),
(8, 12, 2, 'vikram', '<p>Test Flower 2</p>', '15995509022790.jpeg', 0, 1, 1, NULL, 0, 0, '2020-09-08 07:41:42', '2020-09-15 06:41:36', NULL),
(10, 16, 2, 'Flower group', '<p>Test group flower</p>', '15995706133554.jpeg', 7, 1, 1, NULL, 0, 0, '2020-09-08 13:10:13', '2020-09-08 13:10:13', NULL),
(11, 16, 2, 'vikki', '<p>test flower</p>', '16001514692815.jpeg', 21, 1, 1, NULL, 0, 0, '2020-09-09 11:37:08', '2020-09-29 06:57:47', NULL),
(21, 14, 1, 'new group', 'New Group Des', '16018966964903.png', 0, 1, 1, NULL, 0, 0, '2020-09-29 06:57:47', '2020-10-05 11:18:16', NULL),
(26, 14, 2, 'dsfsdfsdf', 'kkljkl', '16025935236368.png', 7, 1, 1, NULL, 0, 0, '2020-10-13 12:52:03', '2020-10-13 12:52:03', NULL),
(27, 14, 2, 'demo', 'kkljkl', '16025935918145.png', 0, 0, 1, '232ds23', 0, 0, '2020-10-13 12:53:11', '2020-11-11 13:55:24', NULL),
(28, 14, 2, 'test  flower 1', 'test  flower 1', '16025939962101.png', 29, 1, 1, NULL, 0, 0, '2020-10-13 12:59:56', '2020-11-11 13:50:27', NULL),
(29, 14, 1, 'demo group', 'demo description', '16051026279562.png', 0, 0, 1, '123456', 0, 0, '2020-11-11 13:50:27', '2020-11-11 13:51:51', NULL),
(30, 23, 1, 'dfdfdgf', 'dfgdfgf', '16055281284465.jpg', 0, 1, 1, NULL, 0, 0, '2020-11-16 12:02:08', '2020-11-16 12:02:08', NULL),
(31, 23, 1, 'loadus test group', 'test description44', '16055282638397.jpg', 0, 1, 1, NULL, 0, 0, '2020-11-16 12:04:23', '2020-11-16 12:04:23', NULL),
(32, 14, 1, 'john', '<p>john</p>', '16068199635708.png', 0, 1, 1, NULL, 0, 0, '2020-12-01 10:52:43', '2020-12-01 10:52:43', NULL),
(33, 14, 2, 'john', 'john', '16068201366295.png', 32, 1, 1, NULL, 0, 0, '2020-12-01 10:55:36', '2020-12-01 10:55:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_flowers_members`
--

CREATE TABLE `group_flowers_members` (
  `id` int(11) NOT NULL,
  `group_flower_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL COMMENT 'id in users table',
  `sent_by` int(11) NOT NULL,
  `position_id` int(11) NOT NULL DEFAULT '0' COMMENT 'id in positions table and 0 as group member',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1- Active; 0- Inactive',
  `is_accepted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1: invitation accepted; 0: not accept',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_flowers_members`
--

INSERT INTO `group_flowers_members` (`id`, `group_flower_id`, `member_id`, `sent_by`, `position_id`, `status`, `is_accepted`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 1, 12, 20, 0, 1, 1, '2020-09-08 07:49:43', '2020-09-29 10:21:05', NULL),
(16, 10, 12, 16, 2, 1, 0, '2020-09-08 13:10:13', '2020-09-08 13:10:13', NULL),
(19, 10, 16, 16, 3, 1, 0, '2020-09-08 13:10:14', '2020-09-08 13:10:14', NULL),
(20, 10, 17, 16, 3, 1, 0, '2020-09-08 13:10:14', '2020-09-08 13:10:14', NULL),
(21, 10, 18, 16, 3, 1, 0, '2020-09-08 13:10:14', '2020-09-08 13:10:14', NULL),
(22, 10, 20, 16, 4, 1, 0, '2020-09-08 13:10:14', '2020-09-08 13:10:14', NULL),
(67, 11, 12, 16, 2, 1, 0, '2020-09-15 06:31:10', '2020-09-15 06:31:10', NULL),
(68, 11, 17, 16, 2, 1, 0, '2020-09-15 06:31:10', '2020-09-15 06:31:10', NULL),
(71, 11, 18, 16, 3, 1, 0, '2020-09-15 06:31:10', '2020-09-15 06:31:10', NULL),
(72, 11, 20, 16, 3, 1, 0, '2020-09-15 06:31:10', '2020-09-15 06:31:10', NULL),
(73, 11, 21, 16, 4, 1, 0, '2020-09-15 06:31:10', '2020-09-15 06:31:10', NULL),
(74, 8, 12, 12, 2, 1, 0, '2020-09-15 06:41:36', '2020-09-15 06:41:36', NULL),
(75, 8, 14, 12, 2, 1, 0, '2020-09-15 06:41:36', '2020-09-15 06:41:36', NULL),
(76, 8, 16, 12, 3, 1, 0, '2020-09-15 06:41:36', '2020-09-15 06:41:36', NULL),
(77, 8, 17, 12, 3, 1, 0, '2020-09-15 06:41:36', '2020-09-15 06:41:36', NULL),
(78, 8, 18, 12, 3, 1, 0, '2020-09-15 06:41:36', '2020-09-15 06:41:36', NULL),
(79, 8, 22, 12, 3, 1, 0, '2020-09-15 06:41:36', '2020-09-15 06:41:36', NULL),
(96, 2, 12, 18, 2, 1, 0, '2020-09-15 08:00:17', '2020-09-15 08:00:17', NULL),
(97, 2, 14, 18, 2, 1, 0, '2020-09-15 08:00:17', '2020-09-15 08:00:17', NULL),
(98, 2, 16, 18, 3, 1, 0, '2020-09-15 08:00:17', '2020-09-15 08:00:17', NULL),
(99, 2, 17, 18, 3, 1, 0, '2020-09-15 08:00:17', '2020-09-15 08:00:17', NULL),
(100, 2, 18, 18, 3, 1, 0, '2020-09-15 08:00:17', '2020-09-15 08:00:17', NULL),
(106, 21, 21, 14, 0, 1, 0, '2020-09-29 06:57:47', '2020-09-29 06:57:47', NULL),
(107, 26, 22, 14, 3, 1, 0, '2020-09-29 06:57:48', '2020-09-29 06:57:48', NULL),
(108, 29, 12, 14, 0, 1, 0, '2020-11-11 13:50:27', '2020-11-11 13:50:27', NULL),
(109, 29, 16, 14, 0, 1, 0, '2020-11-11 13:50:27', '2020-11-11 13:50:27', NULL),
(110, 29, 17, 14, 0, 1, 0, '2020-11-11 13:50:28', '2020-11-11 13:50:28', NULL),
(111, 29, 18, 14, 0, 1, 0, '2020-11-11 13:50:28', '2020-11-11 13:50:28', NULL),
(112, 30, 14, 23, 0, 1, 0, '2020-11-16 12:02:08', '2020-11-16 12:02:08', NULL),
(113, 31, 12, 23, 0, 1, 0, '2020-11-16 12:04:23', '2020-11-16 12:04:23', NULL),
(114, 31, 16, 23, 0, 1, 0, '2020-11-16 12:04:24', '2020-11-16 12:04:24', NULL),
(131, 11, 16, 14, 3, 1, 0, '2020-12-01 10:42:23', '2020-12-01 10:42:23', NULL),
(132, 32, 16, 0, 0, 1, 0, '2020-12-01 10:53:31', '2020-12-01 10:53:31', NULL),
(134, 32, 23, 0, 0, 1, 0, '2020-12-01 11:00:09', '2020-12-01 11:00:09', NULL),
(142, 33, 23, 14, 2, 1, 0, '2020-12-02 13:50:54', '2020-12-02 13:50:54', NULL),
(143, 33, 16, 14, 3, 1, 1, '2020-12-02 15:04:31', '2020-12-02 15:04:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_flowers_tiers`
--

CREATE TABLE `group_flowers_tiers` (
  `id` int(11) NOT NULL,
  `group_flower_id` int(11) NOT NULL,
  `tier` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_flowers_tiers`
--

INSERT INTO `group_flowers_tiers` (`id`, `group_flower_id`, `tier`, `price`) VALUES
(1, 8, 1, 20),
(2, 8, 2, 25),
(3, 8, 3, 30),
(4, 9, 1, 12),
(5, 9, 2, 15),
(6, 9, 3, 20),
(7, 10, 1, 15),
(8, 10, 2, 14),
(9, 10, 3, 20),
(10, 11, 1, 11),
(11, 11, 2, 21),
(12, 11, 3, 30),
(13, 2, 1, 50),
(14, 2, 2, 75),
(15, 2, 3, 100),
(19, 26, 1, 45),
(20, 26, 2, 44),
(21, 26, 3, 48),
(22, 27, 1, 45),
(23, 27, 2, 44),
(24, 27, 3, 48),
(25, 28, 1, 230),
(26, 28, 2, 150),
(27, 28, 3, 50),
(28, 33, 1, 12),
(29, 33, 2, 22),
(30, 33, 3, 23);

-- --------------------------------------------------------

--
-- Table structure for table `group_flower_invitations`
--

CREATE TABLE `group_flower_invitations` (
  `id` int(11) NOT NULL,
  `group_flowers_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invited_by` int(11) NOT NULL,
  `group_flower_type` int(11) NOT NULL DEFAULT '1' COMMENT '1: group, 2: flower',
  `position_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `thread_id` varchar(255) NOT NULL,
  `group_flower_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `reciver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_view` int(11) NOT NULL DEFAULT '0' COMMENT '0-notview,1-view	',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `thread_id`, `group_flower_id`, `sender_id`, `reciver_id`, `message`, `is_view`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, '659428761', 2, 14, 18, 'Hi... This is Vikram.', 0, '2020-09-24 13:33:44', '2020-09-24 13:33:44', NULL),
(10, '659428762', 2, 14, 20, 'Hi..', 0, '2020-09-24 13:43:21', '2020-09-24 13:43:21', NULL),
(11, '659428761', 2, 18, 14, 'gfhfgh', 0, '2020-09-24 13:44:51', '2020-09-24 13:44:51', NULL),
(12, '659428761', 2, 14, 18, 'gfhfgh', 0, '2020-09-24 13:44:56', '2020-09-24 13:44:56', NULL),
(13, '659428762', 2, 20, 14, 'Hi..', 0, '2020-09-24 13:45:26', '2020-09-24 13:45:26', NULL),
(14, '659428761', 2, 14, 18, 'hi..', 0, '2020-09-24 13:45:38', '2020-09-24 13:45:38', NULL),
(15, '659428761', 2, 18, 14, 'ghjghj', 0, '2020-09-24 14:43:31', '2020-09-24 14:43:31', NULL),
(16, '659428761', 2, 14, 18, 'dfgdfgdfg', 0, '2020-09-24 14:43:57', '2020-09-24 14:43:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_07_06_133417_create_positions_table', 1),
(5, '2020_07_06_133439_create_groups_table', 1),
(6, '2020_07_07_071104_create_user_groups_table', 1),
(7, '2020_07_07_071123_create_user_positions_table', 1),
(8, '2020_07_07_122743_create_subsplans_table', 1),
(9, '2020_07_30_121926_create_admin_table', 2),
(10, '2020_07_30_123712_create_admin_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL,
  `send_by` bigint(20) NOT NULL,
  `send_to` bigint(20) NOT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `group_flower_id` int(20) DEFAULT NULL,
  `object_id` bigint(20) DEFAULT NULL COMMENT 'ID of desired table',
  `object_type` varchar(15) DEFAULT NULL,
  `description` text,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_positions` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `total_positions`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Water', 1, 'Water Postion : Centre User', '2020-08-26 12:11:57', NULL),
(2, 'Earth', 2, 'Earth Postion : earth', '2020-08-26 12:11:57', NULL),
(3, 'Air', 4, 'Air Postion : Air', '2020-08-26 12:11:57', NULL),
(4, 'Fire', 8, 'Fire Postion : Fire', '2020-08-26 12:11:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `subscription_name` varchar(250) NOT NULL,
  `subscription_type` tinyint(1) NOT NULL COMMENT '1=monthly,2=yearly',
  `subscription_rate` int(11) NOT NULL DEFAULT '0',
  `subscription_image` text,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active,0=inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `subscription_name`, `subscription_type`, `subscription_rate`, `subscription_image`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'test 22', 2, 2000, NULL, '<p>test description</p>', 0, '2020-11-12 07:49:57', '2020-11-12 08:38:38', NULL),
(3, 'test 2', 1, 100, NULL, '<p>test description monthly</p>', 0, '2020-11-12 08:41:34', '2020-11-12 08:41:34', NULL),
(5, 'test 4', 2, 400, 'public/uploads/subscription/5fb238bb5fa79offer.jpg', '<p>test description 4</p>', 1, '2020-11-16 03:00:51', '2020-11-16 03:00:51', NULL),
(6, 'test 55', 1, 200, 'public/uploads/subscription/5fb38b133fa49offer.jpg', '<p><span class=\"bold\">test 1</span></p>\r\n<p><span class=\"bold\">test 2</span></p>\r\n<p><span class=\"bold\">test 3</span></p>', 0, '2020-11-17 03:04:27', '2020-11-17 03:04:27', NULL),
(8, 'test 88', 1, 300, '', '<p>test 88 description&nbsp;</p>', 1, '2020-11-17 08:12:47', '2020-11-17 08:12:47', NULL),
(9, 'hhj', 2, 656, '', '<p>ghjgfhjfghj</p>', 1, '2020-11-17 08:41:54', '2020-11-17 08:41:54', NULL),
(10, 'test 99', 2, 3000, '', '<p>test desc 99999</p>', 1, '2020-11-18 07:49:31', '2020-11-18 07:49:31', NULL),
(11, 'test 76', 1, 350, '', '<p>Description&nbsp;Description&nbsp;Description</p>', 1, '2020-11-18 08:30:05', '2020-11-18 08:30:05', NULL),
(12, 'test 79', 2, 3500, '', '<p>gfdfgdfgd</p>', 1, '2020-11-19 02:37:27', '2020-11-19 02:37:27', NULL),
(13, 'test 87', 1, 3400, 'public/uploads/subscription/5fb659cb80581offer.jpg', '<p>dffdgdsgsd</p>', 1, '2020-11-19 06:10:59', '2020-11-19 06:10:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subsplans`
--

CREATE TABLE `subsplans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`id`, `question`, `answer`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'How can I change my department / divisions?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '1', '2020-01-22 13:38:53', '2020-01-22 07:38:53', NULL),
(2, 'Can I do two jobs at same time?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '1', '2020-01-22 13:38:53', '2020-01-22 07:38:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE `tbl_language` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '"0=>Active","1=>In-Active"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`id`, `title`, `slug`, `created_at`, `created_by`, `updated_at`, `status`) VALUES
(1, 'English', 'en', '2019-10-30 10:58:37', 1, '2019-10-30 09:39:12', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mail_template`
--

CREATE TABLE `tbl_mail_template` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '"0=>Active","1=>In-Active"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_mail_template`
--

INSERT INTO `tbl_mail_template` (`id`, `title`, `description`, `created_at`, `created_by`, `updated_at`, `status`) VALUES
(1, 'User Register', '<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<!-- HIDDEN PREHEADER TEXT -->\r\n<div style=\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: \'Lato\', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\">We\'re thrilled to have you here! Get ready to dive into your new account.</div>\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><!-- LOGO -->\r\n<tbody>\r\n<tr>\r\n<td align=\"center\" bgcolor=\"#FFA73B\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 40px 10px 40px 10px;\" align=\"center\" valign=\"top\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#FFA73B\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 20px;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\">\r\n<h1 style=\"font-size: 30px; font-weight: 400; margin: 2;\">Welcome!</h1>\r\n<span style=\"font-size: 22px;\">[\'name\']</span><img style=\"display: block; border: 0px;\" src=\"https://img.icons8.com/clouds/100/000000/handshake.png\" width=\"125\" height=\"120\" /></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">We\'re excited to have you get started. First, you need to confirm your account.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Activation Code: [\'verification_code\']</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">This code valid for 60 minutes.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">If you did not request email verification code no further action is required.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Thanks,<br />Travidocs Visa Consultants Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 30px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"center\" bgcolor=\"#FFECD1\"><!--                                <h2 style=\"font-size: 20px; font-weight: 400; color: #111111; margin: 0;\">Need more help?</h2>\r\n                                <p style=\"margin: 0;\"><a href=\"#\" target=\"_blank\" style=\"color: #FFA73B;\">We’re here to help you out</a></p>--></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 0px 30px 30px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;\" align=\"left\" bgcolor=\"#f4f4f4\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '2020-07-10 07:40:02', 1, '2020-07-10 12:58:22', '0'),
(3, 'Resend Code', '<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<!-- HIDDEN PREHEADER TEXT -->\r\n<div style=\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: \'Lato\', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\">We\'re thrilled to have you here! Get ready to dive into your new account.</div>\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><!-- LOGO -->\r\n<tbody>\r\n<tr>\r\n<td align=\"center\" bgcolor=\"#FFA73B\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 40px 10px 40px 10px;\" align=\"center\" valign=\"top\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#FFA73B\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 20px;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\">\r\n<h1 style=\"font-size: 30px; font-weight: 400; margin: 2;\">Welcome!</h1>\r\n<span style=\"font-size: 22px;\">[\'name\']</span><img style=\"display: block; border: 0px;\" src=\"https://img.icons8.com/clouds/100/000000/handshake.png\" width=\"125\" height=\"120\" /></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">We\'re excited to have you get started. First, you need to confirm your account. Your new activation code.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Activation Code: [\'verification_code\']</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">This code valid for 60 minutes.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">If you did not request email verification code no further action is required.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Thanks,<br />Travidocs Visa Consultants Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 30px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"center\" bgcolor=\"#FFECD1\">\r\n<p style=\"margin: 0;\">&nbsp;</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 0px 30px 30px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;\" align=\"left\" bgcolor=\"#f4f4f4\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '2020-07-10 10:06:21', NULL, '2020-07-10 12:55:19', '0'),
(4, 'Forgot Password', '<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<!-- HIDDEN PREHEADER TEXT -->\r\n<div style=\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: \'Lato\', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\">We\'re thrilled to have you here! Get ready to dive into your new account.</div>\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><!-- LOGO -->\r\n<tbody>\r\n<tr>\r\n<td align=\"center\" bgcolor=\"#FFA73B\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 40px 10px 40px 10px;\" align=\"center\" valign=\"top\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#FFA73B\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 20px;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\">\r\n<h1 style=\"font-size: 30px; font-weight: 400; margin: 2;\">Welcome!</h1>\r\n<span style=\"font-size: 22px;\">[\'name\']</span><img style=\"display: block; border: 0px;\" src=\"https://img.icons8.com/clouds/100/000000/handshake.png\" width=\"125\" height=\"120\" /></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">You are receiving this email because we received a password reset request for your account.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td align=\"left\" bgcolor=\"#ffffff\">\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 20px 30px 60px 30px;\" align=\"center\" bgcolor=\"#ffffff\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"border-radius: 3px;\" align=\"center\" bgcolor=\"#FFA73B\"><a style=\"font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FFA73B; display: inline-block;\" href=\"[\'link\']\" target=\"_blank\" rel=\"noopener\">Reset Password</a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">If you&rsquo;re having trouble clicking the \"Reset Password\" button, copy and paste the URL below into your web browser:</p>\r\n<p><a href=\"[\'link\']\">[\'link\']</a></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">This password reset link will expire in 60 minutes.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">If you did not request a password reset, no further action is required.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Thanks,<br />Team Loadus</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 30px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"center\" bgcolor=\"#FFECD1\"><!--                                <h2 style=\"font-size: 20px; font-weight: 400; color: #111111; margin: 0;\">Need more help?</h2>\r\n                                <p style=\"margin: 0;\"><a href=\"#\" target=\"_blank\" style=\"color: #FFA73B;\">We’re here to help you out</a></p>--></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 0px 30px 30px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;\" align=\"left\" bgcolor=\"#f4f4f4\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', '2020-07-10 10:50:50', NULL, '2020-08-24 07:12:37', '0'),
(5, 'Contact Us', '<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<!-- HIDDEN PREHEADER TEXT -->\r\n<div style=\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: \'Lato\', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\">We\'re thrilled to have you here! Get ready to dive into your new account.</div>\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><!-- LOGO -->\r\n<tbody>\r\n<tr>\r\n<td align=\"center\" bgcolor=\"#FFA73B\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 40px 10px 40px 10px;\" align=\"center\" valign=\"top\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#FFA73B\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 20px;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\">\r\n<h1 style=\"font-size: 30px; font-weight: 400; margin: 2;\">Hi,</h1>\r\n<span style=\"font-size: 22px;\">Admin</span><img style=\"display: block; border: 0px;\" src=\"https://img.icons8.com/clouds/100/000000/handshake.png\" width=\"125\" height=\"120\" /></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">User have submitted the contact us form with details below:-</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 0px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Name :[\'name\']</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 0px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Email : [\'email\']</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 0px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Phone : [\'phone\']</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Message : [\'messages\']</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"left\" bgcolor=\"#ffffff\">\r\n<p style=\"margin: 0;\">Thanks,<br />LOADUS Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 30px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\" align=\"center\" bgcolor=\"#FFECD1\"><!--                                <h2 style=\"font-size: 20px; font-weight: 400; color: #111111; margin: 0;\">Need more help?</h2>\r\n                                <p style=\"margin: 0;\"><a href=\"#\" target=\"_blank\" style=\"color: #FFA73B;\">We’re here to help you out</a></p>--></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"padding: 0px 10px 0px 10px;\" align=\"center\" bgcolor=\"#f4f4f4\">\r\n<table style=\"max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 0px 30px 30px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;\" align=\"left\" bgcolor=\"#f4f4f4\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '2020-07-10 10:53:24', NULL, '2020-08-18 02:09:56', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id` int(11) NOT NULL,
  `data` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_on` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '''0=>Active'',''1=>In-Active'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `data`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(1, '[{\"text\":\"Dashboard\",\"href\":\"Dashboard\",\"icon\":\"fas fa-tachometer-alt\",\"target\":\"_self\",\"title\":\"My Home\"},{\"text\":\"Menu Management\",\"href\":\"Menu\",\"icon\":\"fas fa-chart-bar\",\"target\":\"_self\",\"title\":\"Menu\"},{\"text\":\"User Management\",\"href\":\"User\",\"icon\":\"fas fa-user\",\"target\":\"_self\",\"title\":\"User\",\"children\":[{\"text\":\"Role\",\"href\":\"Role\",\"icon\":\"fas fa-address-book\",\"target\":\"_self\",\"title\":\"Role\"},{\"text\":\"Permissions\",\"href\":\"Right\",\"icon\":\"fas fa-dharmachakra\",\"target\":\"_self\",\"title\":\"Rights\"},{\"text\":\"User\",\"href\":\"user\",\"icon\":\"fas fa-map-marker\",\"target\":\"_self\",\"title\":\"User\"}]},{\"text\":\"Cms Management\",\"href\":\"\",\"icon\":\"fab fa-page4\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"Language\",\"href\":\"language\",\"icon\":\"fas fa-language\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Message\",\"icon\":\"\",\"href\":\"message\",\"target\":\"_self\",\"title\":\"\"}]},{\"text\":\"Module\",\"href\":\"module\",\"icon\":\"fab fa-500px\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Masters\",\"href\":\"#\",\"icon\":\"fas fa-database\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"Country\",\"href\":\"country\",\"icon\":\"far fa-address-book\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"State\",\"href\":\"State\",\"icon\":\"fab fa-accusoft\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"City\",\"href\":\"City\",\"icon\":\"fab fa-accusoft\",\"target\":\"_self\",\"title\":\"\"}]},{\"text\":\"Applicant\",\"href\":\"applicant\",\"icon\":\"fas fa-user-graduate\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Travidocs Forms Builder Tool\",\"href\":\"\",\"icon\":\"fab fa-wpforms\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"First Step\",\"href\":\"formbuilder\",\"icon\":\"fab fa-wpforms\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Second Step\",\"href\":\"formbuildertwo\",\"icon\":\"\",\"target\":\"_self\",\"title\":\"\"}]},{\"text\":\"Application\",\"href\":\"application\",\"icon\":\"far fa-address-book\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Setting\",\"href\":\"\",\"icon\":\"fas fa-baseball-ball\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Report\",\"href\":\"\",\"icon\":\"fas fa-align-center\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"Customer Report\",\"href\":\"applicant\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Revenue Report\",\"href\":\"Revenue\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Staff Report\",\"href\":\"Staff\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"}]},{\"text\":\"Uselog\",\"href\":\"Uselog\",\"icon\":\"fas fa-user-friends\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Main Website Settings\",\"href\":\"\",\"icon\":\"fas fa-home\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"Home Page\",\"href\":\"Setting\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Slider\",\"href\":\"Slider\",\"icon\":\"fas fa-align-justify\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Social Media\",\"href\":\"Social\",\"icon\":\"fab fa-medium\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Feedback\",\"href\":\"Feedback\",\"icon\":\"fas fa-stroopwafel\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Pages\",\"href\":\"page\",\"icon\":\"far fa-address-book\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Front Menu\",\"href\":\"Frontmenu\",\"icon\":\"far fa-address-book\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Application Status\",\"href\":\"applicationstatus\",\"icon\":\"fas fa-air-freshener\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Price\",\"href\":\"Price\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Mail Template\",\"href\":\"Mailtemplate\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"}]}]', '2019-08-11 23:48:00', 1, '2020-08-10 21:02:37', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

CREATE TABLE `tbl_pages` (
  `id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT '1',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `featured_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '"0=>Active","1=>In-Active"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pages`
--

INSERT INTO `tbl_pages` (`id`, `language_id`, `title`, `description`, `featured_img`, `slug`, `meta_title`, `meta_description`, `meta_key`, `created_at`, `created_by`, `updated_at`, `status`) VALUES
(1, 1, 'About Us', '<div class=\"col-md-5\">\r\n<div class=\"img1\">About Us</div>\r\n</div>', NULL, 'about-us', 'dfghy', 'yrtyrtr', '546fghfhfg', '2019-10-30 13:06:40', 1, '2020-08-25 11:29:14', '1'),
(2, 1, 'Contact Us', '<p>Contact Us</p>', 'uploads/5e49332e9e6525dfb91f304d37index.jpeg', 'contact-us', 'blog', 'blog', 'blog', '2019-10-31 02:17:03', 1, '2020-08-25 11:29:19', '1'),
(3, 1, 'How To Apply', '<div class=\"col-md-5\">\r\n<div class=\"img1\"><img class=\"img-fluid\" src=\"uploads/5efd527259a0capply-img.jpg\" width=\"431\" height=\"439\" /><span class=\"bold\"><img src=\"uploads/5efd53dd1c7fcsend2.png\" width=\"119\" height=\"73\" /></span></div>\r\n</div>\r\n<div class=\"col-md-7 pl-md-5 pt-4 pt-md-0 my-auto\">\r\n<h1>Guidelines on <span class=\"bold\">How to Apply Visa</span></h1>\r\n<p>There anyone who loves or pursues nor desires to obtain pain of itself, bet it is pain, but because occasionally can packages as their default.There anyone who loves or pursues nor desires to obtain pain of itself, bet it is pain, but because occasionally can packages as their default.</p>\r\n<p>There anyone who loves or pursues nor desires to obtain pain of itself, bet it is pain, but because occasionally can packages as their default.There anyone who loves or pursues nor desires to obtain pain of itself, bet it is pain, but because occasionally can packages as their default.</p>\r\n</div>\r\n<!-- Our Team -->\r\n<section class=\"ourTeam followSteps\">\r\n<div class=\"container\">\r\n<h2>Follow the <span class=\"bold\">Steps</span></h2>\r\n<div id=\"acc\" class=\"accordion\">\r\n<div class=\"card\">\r\n<div id=\"headingOne\" class=\"card-head\">\r\n<h4 class=\"mb-0\" data-toggle=\"collapse\" data-target=\"#cl1\" aria-expanded=\"true\" aria-controls=\"cl1\">1. Figure out which Schengen visa type you need ?</h4>\r\n</div>\r\n<div id=\"cl1\" class=\"collapse show\" aria-labelledby=\"headingOne\" data-parent=\"#acc\">\r\n<div class=\"card-body\">\r\n<p>Depending on the purpose under which you need to enter the Schengen Area, you can apply for one of the following Schengen visa types:</p>\r\n<ul>\r\n<li>Transit visa</li>\r\n<li>Tourism visa</li>\r\n<li>Visa for Visiting Family or Friends</li>\r\n<li>Business visa</li>\r\n<li>Visa for Culture and Sport activities</li>\r\n<li>Visa for Official Visits</li>\r\n<li>Study visa</li>\r\n<li>Visa for Medical Reasons</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"card\">\r\n<div id=\"headingTwo\" class=\"card-head\">\r\n<h4 class=\"mb-0 collapsed\" data-toggle=\"collapse\" data-target=\"#cl2\" aria-expanded=\"false\" aria-controls=\"cl2\">2. Find out where you need to apply</h4>\r\n</div>\r\n<div id=\"cl2\" class=\"collapse\" aria-labelledby=\"headingTwo\" data-parent=\"#acc\">\r\n<div class=\"card-body\">\r\n<p>Depending on the purpose under which you need to enter the Schengen Area, you can apply for one of the following Schengen visa types:</p>\r\n<ul>\r\n<li>Transit visa</li>\r\n<li>Tourism visa</li>\r\n<li>Visa for Visiting Family or Friends</li>\r\n<li>Business visa</li>\r\n<li>Visa for Culture and Sport activities</li>\r\n<li>Visa for Official Visits</li>\r\n<li>Study visa</li>\r\n<li>Visa for Medical Reasons</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"card\">\r\n<div id=\"headingThree\" class=\"card-head\">\r\n<h4 class=\"mb-0 collapsed\" data-toggle=\"collapse\" data-target=\"#cl3\" aria-expanded=\"false\" aria-controls=\"cl3\">3. Find the most suitable time to apply</h4>\r\n</div>\r\n<div id=\"cl3\" class=\"collapse\" aria-labelledby=\"headingThree\" data-parent=\"#acc\">\r\n<div class=\"card-body\">\r\n<p>Depending on the purpose under which you need to enter the Schengen Area, you can apply for one of the following Schengen visa types:</p>\r\n<ul>\r\n<li>Transit visa</li>\r\n<li>Tourism visa</li>\r\n<li>Visa for Visiting Family or Friends</li>\r\n<li>Business visa</li>\r\n<li>Visa for Culture and Sport activities</li>\r\n<li>Visa for Official Visits</li>\r\n<li>Study visa</li>\r\n<li>Visa for Medical Reasons</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"card\">\r\n<div id=\"headingFour\" class=\"card-head\">\r\n<h4 class=\"mb-0 collapsed\" data-toggle=\"collapse\" data-target=\"#cl4\" aria-expanded=\"false\" aria-controls=\"cl4\">4. Book an appointment</h4>\r\n</div>\r\n<div id=\"cl4\" class=\"collapse\" aria-labelledby=\"headingFour\" data-parent=\"#acc\">\r\n<div class=\"card-body\">\r\n<p>Depending on the purpose under which you need to enter the Schengen Area, you can apply for one of the following Schengen visa types:</p>\r\n<ul>\r\n<li>Transit visa</li>\r\n<li>Tourism visa</li>\r\n<li>Visa for Visiting Family or Friends</li>\r\n<li>Business visa</li>\r\n<li>Visa for Culture and Sport activities</li>\r\n<li>Visa for Official Visits</li>\r\n<li>Study visa</li>\r\n<li>Visa for Medical Reasons</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"card\">\r\n<div id=\"headingFive\" class=\"card-head\">\r\n<h4 class=\"mb-0 collapsed\" data-toggle=\"collapse\" data-target=\"#cl5\" aria-expanded=\"false\" aria-controls=\"cl5\">5. Fill out the visa application form</h4>\r\n</div>\r\n<div id=\"cl5\" class=\"collapse\" aria-labelledby=\"headingFive\" data-parent=\"#acc\">\r\n<div class=\"card-body\">\r\n<p>Depending on the purpose under which you need to enter the Schengen Area, you can apply for one of the following Schengen visa types:</p>\r\n<ul>\r\n<li>Transit visa</li>\r\n<li>Tourism visa</li>\r\n<li>Visa for Visiting Family or Friends</li>\r\n<li>Business visa</li>\r\n<li>Visa for Culture and Sport activities</li>\r\n<li>Visa for Official Visits</li>\r\n<li>Study visa</li>\r\n<li>Visa for Medical Reasons</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"card\">\r\n<div id=\"headingSix\" class=\"card-head\">\r\n<h4 class=\"mb-0 collapsed\" data-toggle=\"collapse\" data-target=\"#cl6\" aria-expanded=\"false\" aria-controls=\"cl6\">6. Gather the required documents</h4>\r\n</div>\r\n<div id=\"cl6\" class=\"collapse\" aria-labelledby=\"headingSix\" data-parent=\"#acc\">\r\n<div class=\"card-body\">\r\n<p>Depending on the purpose under which you need to enter the Schengen Area, you can apply for one of the following Schengen visa types:</p>\r\n<ul>\r\n<li>Transit visa</li>\r\n<li>Tourism visa</li>\r\n<li>Visa for Visiting Family or Friends</li>\r\n<li>Business visa</li>\r\n<li>Visa for Culture and Sport activities</li>\r\n<li>Visa for Official Visits</li>\r\n<li>Study visa</li>\r\n<li>Visa for Medical Reasons</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"card\">\r\n<div id=\"headingSeven\" class=\"card-head\">\r\n<h4 class=\"mb-0 collapsed\" data-toggle=\"collapse\" data-target=\"#cl7\" aria-expanded=\"false\" aria-controls=\"cl7\">7. Attend the visa interview</h4>\r\n</div>\r\n<div id=\"cl7\" class=\"collapse\" aria-labelledby=\"headingSeven\" data-parent=\"#acc\">\r\n<div class=\"card-body\">\r\n<p>Depending on the purpose under which you need to enter the Schengen Area, you can apply for one of the following Schengen visa types:</p>\r\n<ul>\r\n<li>Transit visa</li>\r\n<li>Tourism visa</li>\r\n<li>Visa for Visiting Family or Friends</li>\r\n<li>Business visa</li>\r\n<li>Visa for Culture and Sport activities</li>\r\n<li>Visa for Official Visits</li>\r\n<li>Study visa</li>\r\n<li>Visa for Medical Reasons</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"card\">\r\n<div id=\"headingEight\" class=\"card-head\">\r\n<h4 class=\"mb-0 collapsed\" data-toggle=\"collapse\" data-target=\"#cl8\" aria-expanded=\"false\" aria-controls=\"cl8\">8. Pay the visa fee</h4>\r\n</div>\r\n<div id=\"cl8\" class=\"collapse\" aria-labelledby=\"headingEight\" data-parent=\"#acc\">\r\n<div class=\"card-body\">\r\n<p>Depending on the purpose under which you need to enter the Schengen Area, you can apply for one of the following Schengen visa types:</p>\r\n<ul>\r\n<li>Transit visa</li>\r\n<li>Tourism visa</li>\r\n<li>Visa for Visiting Family or Friends</li>\r\n<li>Business visa</li>\r\n<li>Visa for Culture and Sport activities</li>\r\n<li>Visa for Official Visits</li>\r\n<li>Study visa</li>\r\n<li>Visa for Medical Reasons</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"card\">\r\n<div id=\"headingNine\" class=\"card-head\">\r\n<h4 class=\"mb-0 collapsed\" data-toggle=\"collapse\" data-target=\"#cl9\" aria-expanded=\"false\" aria-controls=\"cl9\">9. Wait for an answer on your application</h4>\r\n</div>\r\n<div id=\"cl9\" class=\"collapse\" aria-labelledby=\"headingNine\" data-parent=\"#acc\">\r\n<div class=\"card-body\">\r\n<p>Depending on the purpose under which you need to enter the Schengen Area, you can apply for one of the following Schengen visa types:</p>\r\n<ul>\r\n<li>Transit visa</li>\r\n<li>Tourism visa</li>\r\n<li>Visa for Visiting Family or Friends</li>\r\n<li>Business visa</li>\r\n<li>Visa for Culture and Sport activities</li>\r\n<li>Visa for Official Visits</li>\r\n<li>Study visa</li>\r\n<li>Visa for Medical Reasons</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>', NULL, 'how-to-apply', 'fsdf', 'dfsdf', 'fdsf', '2020-02-16 07:02:13', 3, '2020-08-25 11:29:23', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '"0=>Active","1=>In-Active"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `title`, `description`, `image`, `created_at`, `created_by`, `updated_at`, `status`) VALUES
(1, 'Address', '824 Bel Meadow Drive, California, USA', 'uploads/5ed098b982258notepad.png', '2020-05-28 12:02:34', NULL, '2020-08-24 06:12:59', '0'),
(2, 'Contact - 1', '+91 5892-326-245', '', '2020-05-28 12:02:34', NULL, '2020-08-24 06:12:50', '0'),
(3, 'Contact - 2', '+91 5892-326-245', '', '2020-05-28 12:02:34', NULL, '2020-08-24 06:12:46', '0'),
(4, 'email', 'info@loadus.com', NULL, '2020-05-28 12:02:34', NULL, '2020-08-24 06:12:36', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social_media`
--

CREATE TABLE `tbl_social_media` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `link` varchar(200) CHARACTER SET latin1 NOT NULL,
  `icon` varchar(30) CHARACTER SET latin1 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` varchar(255) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_social_media`
--

INSERT INTO `tbl_social_media` (`id`, `name`, `link`, `icon`, `created_at`, `created_by`, `update_at`, `updated_by`, `status`, `deleted_at`) VALUES
(1, 'Facebook', '#', 'fa fa-facebook', '2020-06-04 11:13:13', 1, '2020-08-24 10:13:43', 1, 1, NULL),
(2, 'Twitter', '#', 'fa fa-twitter', '2020-06-04 11:24:32', 1, '2020-08-24 10:13:39', 1, 1, NULL),
(3, 'linkedin', '#', 'fa fa-linkedin', '2020-06-04 11:29:01', 1, '2020-08-24 10:14:44', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_subscriptions`
--

CREATE TABLE `tbl_user_subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT 'id from users table',
  `subscription_id` int(11) NOT NULL DEFAULT '0' COMMENT 'id from subscriptions table',
  `user_email` varchar(250) DEFAULT NULL,
  `subscription_type` tinyint(1) NOT NULL COMMENT '1=monthly,2=yearly',
  `subscription_rate` int(11) NOT NULL,
  `payment_mode` tinyint(1) DEFAULT NULL COMMENT '1=online, 2=cash',
  `payment_status` tinyint(1) DEFAULT NULL COMMENT '0=failed, 1= success',
  `transaction_id` varchar(250) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `payment_by` tinyint(1) DEFAULT NULL COMMENT '1=admin,2=user',
  `description` text,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=active, 0=inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_subscriptions`
--

INSERT INTO `tbl_user_subscriptions` (`id`, `user_id`, `subscription_id`, `user_email`, `subscription_type`, `subscription_rate`, `payment_mode`, `payment_status`, `transaction_id`, `payment_date`, `payment_by`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 12, 3, 'vikrams@sourcesoftsolutions3.com', 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-11-17 04:02:28', NULL, NULL),
(7, 23, 13, 'vipin.singh@sourcesoftsolutions.com', 1, 3400, 1, 1, 'ch_1HpaJaCj4XZipiorfbKvnE4v', '2020-11-20 19:10:18', 2, '<p>dffdgdsgsd</p>', 1, '2020-11-20 19:10:18', '2020-11-20 19:10:18', NULL),
(8, 16, 13, 'vikrams@sourcesoftsolutions231.com', 1, 3400, 1, 1, 'ch_1HpaJaCj4XZipiorfbKvnE4v', '2020-11-20 19:10:18', 2, '<p>dffdgdsgsd</p>', 1, '2020-11-20 19:10:18', '2020-11-20 19:10:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0 : Not Deleted; 1: Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_type`, `status`, `phone`, `user_image`, `password`, `remember_token`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 'vikram', NULL, 'vikrams@sourcesoftsolutions1.com', '2', 0, NULL, NULL, '$2y$10$GFHL1t0WccdbnXyJ4xK7Uep7BaRs8xlP7pvBa9xTyIdlbnGiBythO', NULL, '1596704376', NULL, '2020-08-13 05:37:30', '2020-08-13 11:07:30'),
(11, 'vikram', NULL, 'vikrams@sourcesoftsolutions2.com', '2', 0, NULL, NULL, '$2y$10$GFHL1t0WccdbnXyJ4xK7Uep7BaRs8xlP7pvBa9xTyIdlbnGiBythO', NULL, '1596704376', NULL, '2020-08-13 05:37:39', '2020-08-13 11:07:39'),
(12, 'vikram', NULL, 'vikrams@sourcesoftsolutions3.com', '2', 1, NULL, NULL, '$2y$10$GFHL1t0WccdbnXyJ4xK7Uep7BaRs8xlP7pvBa9xTyIdlbnGiBythO', NULL, '1596704376', NULL, '2020-08-18 01:28:59', NULL),
(13, 'vikram', NULL, 'naveenc@sourcesoftsolutions.com', '2', 0, '1234567890', '', '$2y$10$YjSP6l0CatKohY3S486Pp.81PYI2Ig4nIquWjf4r5moF.8tXJLyuK', NULL, NULL, '2020-08-06 09:05:08', '2020-08-13 05:38:03', '2020-08-13 11:08:03'),
(14, 'jonathan', 'Sharma', 'vikrams@sourcesoftsolutions.com', '2', 1, '8956895689', '16014678322745.jpeg', '$2y$10$GFHL1t0WccdbnXyJ4xK7Uep7BaRs8xlP7pvBa9xTyIdlbnGiBythO', 'b6a59ea1efa958d97b1826c3211803cf3129355403e33f01e259fcd351fd7c3e', '1597150692', NULL, '2020-12-01 11:46:10', NULL),
(16, 'vikram112', 'sharma', 'vikrams@sourcesoftsolutions231.com', '2', 1, '1234567890', '15972290797541.jpeg', '$2y$10$r5l3meEp2ylM67jYOrQl9.Ib3GpJvFiIAxtbe6z/cVPbfatd/RwvC', NULL, '1597236203', NULL, '2020-08-12 05:14:39', NULL),
(17, 'vikk', NULL, 'vikrams1@sourcesoftsolutions.com', '2', 1, '1212121212', '', '$2y$10$xIPFsnEI/Ed/VH3EZz42ge7yxdUrU7spwH84YteIJvnuPIxfIFSDG', NULL, NULL, '2020-08-14 05:00:42', '2020-08-14 05:00:42', NULL),
(18, 'gfdgdfg', NULL, 'naveenk@sourcesoftsolutions.com', '2', 1, '4534534534', '15974062417766.jpg', '$2y$10$bnN3V2ktJsGzyexjnnw3N.nrmX/16wnvF8w/sH08GbYZDb7MQQrFG', NULL, NULL, '2020-08-14 05:04:03', '2020-08-18 08:10:30', NULL),
(20, 'sdfsdf', NULL, '3434@sourcesoftsolutions.com', '2', 1, '3434234234', '', '$2y$10$b2Yyle9FH5AzrWz.izkLXuMozz9Gfk6GLSEfPqFj6HmSo1O4MqLEe', NULL, NULL, '2020-08-14 05:16:56', '2020-08-18 08:12:39', NULL),
(21, 'vikram12', 'sh', 'vikram12@yopmail.com', '2', 1, NULL, NULL, '$2y$10$bqunBs1iwzuezfSItp7s9OPpOzEg.tBXGvO6TlabPQp4rwKQ1V9ny', 'ddafbecbe36a0400c57c6ec941c9c631de649c7c3aeabdeb427c917b4e8c2a1a', '1598276704', NULL, '2020-08-25 02:50:03', NULL),
(22, 'vikram13', 'sh', 'vikram13@yopmail.com', '2', 1, '1234567890', '15982706837059.jpeg', '$2y$10$bowMvcU0y2Sy4bnndO3oOeuwizoL/FkSZX9i3AhFua0m.8lhFNkl2', NULL, '1598276914', NULL, '2020-08-24 06:34:43', NULL),
(23, 'Vipin', 'Singh', 'vipin.singh@sourcesoftsolutions.com', '2', 1, '9625323873', NULL, '$2y$10$CIl3eXWN/G0EyeGnUyqpTe.FA/8zxjJlvF.cirVaGmPEQ3whjVIE.', NULL, '1605173179', NULL, '2020-11-23 16:20:23', NULL),
(35, 'Vipin', 'Singh', 'vipin121@yopmail.com', '2', 0, '9625323873', NULL, '$2y$10$mnEqsUU2Z5KcXOJlwUN7p.rVW/hfp6TAfzy9WX3cmma5ejHVhYfH.', NULL, '1606139795', '2020-11-23 16:56:35', NULL, NULL),
(36, 'Vipin', 'Singh', 'vipin12235@yopmail.com', '2', 0, '9625323873', NULL, '$2y$10$s874/XvKlMcbo8Dov2ty8.3UzTMgV/PQcxvmeBKR2uVjCIkUEubW.', NULL, '1606140690', '2020-11-23 17:11:30', '2020-11-23 17:16:30', NULL),
(37, 'Vipin', 'Singh', 'vipin2212@yopmail.com', '2', 0, '9625323873', NULL, '$2y$10$V2dyUpKdORg.lgmgie1Fo.J3C7.q6eQrXSD1U/9bfLClgkD9Q5.Wi', NULL, '1606142116', '2020-11-23 17:35:16', '2020-11-23 17:41:14', NULL),
(38, 'Vipin', 'Singh', 'vipin43445@yopmail.com', '2', 1, '9625323873', NULL, '$2y$10$0mVBYcs8eOdO0cQOo3N4y./vLh/q3LaLZJwcxMqh6PK2EByZ0wbn.', 'rhuenf2S8GqpxvGJJLwPA9IYDcIsvwlJQ4JtsQC0pwD9bYf2R6zzrOtcMHuj', '1606143071', '2020-11-23 17:43:43', '2020-11-23 18:10:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_positions`
--

CREATE TABLE `user_positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `position_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `group_flowers`
--
ALTER TABLE `group_flowers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_flowers_members`
--
ALTER TABLE `group_flowers_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_flowers_tiers`
--
ALTER TABLE `group_flowers_tiers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_flower_invitations`
--
ALTER TABLE `group_flower_invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `send_by` (`send_by`),
  ADD KEY `send_to` (`send_to`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `mission_id` (`group_flower_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_social_media`
--
ALTER TABLE `tbl_social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_subscriptions`
--
ALTER TABLE `tbl_user_subscriptions`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `group_flowers`
--
ALTER TABLE `group_flowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `group_flowers_members`
--
ALTER TABLE `group_flowers_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `group_flowers_tiers`
--
ALTER TABLE `group_flowers_tiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `group_flower_invitations`
--
ALTER TABLE `group_flower_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_social_media`
--
ALTER TABLE `tbl_social_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user_subscriptions`
--
ALTER TABLE `tbl_user_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
