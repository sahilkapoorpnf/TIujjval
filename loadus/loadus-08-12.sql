-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 08, 2020 at 08:56 PM
-- Server version: 5.7.32-0ubuntu0.18.04.1
-- PHP Version: 7.4.13

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
(1, 1, 1, 'group -1', 'Group Owner Name - Vikram Sharma\r\nEmail - vikrams@sourcesoftsolutions.com', '16070665883019.png', 0, 1, 1, NULL, 0, 0, '2020-12-04 07:23:08', '2020-12-04 07:23:08', NULL),
(2, 1, 2, 'flower -1', 'Flower owner name - Vikram Sharma\r\nvikrams@sourcesoftsolutions.com', '16070955472799.png', 1, 1, 0, NULL, 0, 0, '2020-12-04 15:25:47', '2020-12-08 12:52:14', NULL),
(3, 1, 2, 'flower -2', 'Created by Vikram Sharma', '16073498162552.png', 0, 1, 1, NULL, 0, 0, '2020-12-07 14:03:36', '2020-12-07 14:03:36', NULL),
(6, 2, 2, 'flower -1', 'Flower owner name - Vikram Sharma\r\nvikrams@sourcesoftsolutions.com', '16070955472799.png', 1, 1, 1, NULL, 0, 0, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(7, 3, 2, 'flower -1', 'Flower owner name - Vikram Sharma\r\nvikrams@sourcesoftsolutions.com', '16070955472799.png', 1, 1, 1, NULL, 0, 0, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL);

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
(39, 1, 3, 3, 0, 1, 0, '2020-12-07 13:47:04', '2020-12-07 13:47:04', NULL),
(42, 1, 2, 1, 0, 1, 0, '2020-12-07 13:54:02', '2020-12-07 13:54:02', NULL),
(43, 2, 2, 1, 2, 1, 1, '2020-12-07 14:26:56', '2020-12-08 12:52:14', NULL),
(44, 2, 3, 1, 2, 1, 1, '2020-12-07 14:41:30', '2020-12-08 11:07:16', NULL),
(45, 2, 4, 1, 3, 1, 1, '2020-12-08 11:55:12', '2020-12-08 11:55:12', NULL),
(46, 2, 5, 1, 3, 1, 1, '2020-12-08 11:55:49', '2020-12-08 11:55:49', NULL),
(47, 2, 6, 1, 3, 1, 1, '2020-12-08 11:55:56', '2020-12-08 11:55:56', NULL),
(48, 2, 7, 1, 3, 1, 1, '2020-12-08 11:56:03', '2020-12-08 11:56:03', NULL),
(49, 2, 8, 1, 4, 1, 1, '2020-12-08 11:57:57', '2020-12-08 11:57:57', NULL),
(50, 2, 9, 1, 4, 1, 1, '2020-12-08 11:58:04', '2020-12-08 11:58:04', NULL),
(51, 2, 10, 1, 4, 1, 1, '2020-12-08 11:57:57', '2020-12-08 11:57:57', NULL),
(52, 2, 11, 1, 4, 1, 1, '2020-12-08 11:58:04', '2020-12-08 11:58:04', NULL),
(53, 2, 12, 1, 4, 1, 1, '2020-12-08 11:57:57', '2020-12-08 11:57:57', NULL),
(54, 2, 13, 1, 4, 1, 1, '2020-12-08 11:58:04', '2020-12-08 11:58:04', NULL),
(55, 2, 14, 1, 4, 1, 1, '2020-12-08 11:57:57', '2020-12-08 11:57:57', NULL),
(56, 2, 15, 1, 4, 1, 1, '2020-12-08 11:58:04', '2020-12-08 11:58:04', NULL),
(81, 6, 4, 2, 2, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(82, 6, 6, 2, 2, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(83, 6, 8, 2, 3, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(84, 6, 10, 2, 3, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(85, 6, 12, 2, 3, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(86, 6, 14, 2, 3, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(87, 7, 5, 3, 2, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(88, 7, 7, 3, 2, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(89, 7, 9, 3, 3, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(90, 7, 11, 3, 3, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(91, 7, 13, 3, 3, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL),
(92, 7, 15, 3, 3, 1, 1, '2020-12-08 12:52:14', '2020-12-08 12:52:14', NULL);

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
(1, 2, 1, 11),
(2, 2, 2, 22),
(3, 2, 3, 33),
(4, 3, 1, 33),
(5, 3, 2, 44),
(6, 3, 3, 55);

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
(10, '2020_07_30_123712_create_admin_table', 3),
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
(1, 'Plan 1', 1, 100, '', '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-03 09:29:30', '2020-12-03 09:29:30', NULL);

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
(2, 'Can I do two jobs at same time?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '1', '2020-01-22 13:38:53', '2020-01-22 07:38:53', NULL),
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
(1, 'English', 'en', '2019-10-30 10:58:37', 1, '2019-10-30 09:39:12', '0'),
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
(1, '[{\"text\":\"Dashboard\",\"href\":\"Dashboard\",\"icon\":\"fas fa-tachometer-alt\",\"target\":\"_self\",\"title\":\"My Home\"},{\"text\":\"Menu Management\",\"href\":\"Menu\",\"icon\":\"fas fa-chart-bar\",\"target\":\"_self\",\"title\":\"Menu\"},{\"text\":\"User Management\",\"href\":\"User\",\"icon\":\"fas fa-user\",\"target\":\"_self\",\"title\":\"User\",\"children\":[{\"text\":\"Role\",\"href\":\"Role\",\"icon\":\"fas fa-address-book\",\"target\":\"_self\",\"title\":\"Role\"},{\"text\":\"Permissions\",\"href\":\"Right\",\"icon\":\"fas fa-dharmachakra\",\"target\":\"_self\",\"title\":\"Rights\"},{\"text\":\"User\",\"href\":\"user\",\"icon\":\"fas fa-map-marker\",\"target\":\"_self\",\"title\":\"User\"}]},{\"text\":\"Cms Management\",\"href\":\"\",\"icon\":\"fab fa-page4\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"Language\",\"href\":\"language\",\"icon\":\"fas fa-language\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Message\",\"icon\":\"\",\"href\":\"message\",\"target\":\"_self\",\"title\":\"\"}]},{\"text\":\"Module\",\"href\":\"module\",\"icon\":\"fab fa-500px\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Masters\",\"href\":\"#\",\"icon\":\"fas fa-database\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"Country\",\"href\":\"country\",\"icon\":\"far fa-address-book\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"State\",\"href\":\"State\",\"icon\":\"fab fa-accusoft\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"City\",\"href\":\"City\",\"icon\":\"fab fa-accusoft\",\"target\":\"_self\",\"title\":\"\"}]},{\"text\":\"Applicant\",\"href\":\"applicant\",\"icon\":\"fas fa-user-graduate\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Travidocs Forms Builder Tool\",\"href\":\"\",\"icon\":\"fab fa-wpforms\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"First Step\",\"href\":\"formbuilder\",\"icon\":\"fab fa-wpforms\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Second Step\",\"href\":\"formbuildertwo\",\"icon\":\"\",\"target\":\"_self\",\"title\":\"\"}]},{\"text\":\"Application\",\"href\":\"application\",\"icon\":\"far fa-address-book\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Setting\",\"href\":\"\",\"icon\":\"fas fa-baseball-ball\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Report\",\"href\":\"\",\"icon\":\"fas fa-align-center\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"Customer Report\",\"href\":\"applicant\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Revenue Report\",\"href\":\"Revenue\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Staff Report\",\"href\":\"Staff\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"}]},{\"text\":\"Uselog\",\"href\":\"Uselog\",\"icon\":\"fas fa-user-friends\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Main Website Settings\",\"href\":\"\",\"icon\":\"fas fa-home\",\"target\":\"_self\",\"title\":\"\",\"children\":[{\"text\":\"Home Page\",\"href\":\"Setting\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Slider\",\"href\":\"Slider\",\"icon\":\"fas fa-align-justify\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Social Media\",\"href\":\"Social\",\"icon\":\"fab fa-medium\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Feedback\",\"href\":\"Feedback\",\"icon\":\"fas fa-stroopwafel\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Pages\",\"href\":\"page\",\"icon\":\"far fa-address-book\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Front Menu\",\"href\":\"Frontmenu\",\"icon\":\"far fa-address-book\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Application Status\",\"href\":\"applicationstatus\",\"icon\":\"fas fa-air-freshener\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Price\",\"href\":\"Price\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Mail Template\",\"href\":\"Mailtemplate\",\"icon\":\"fas fa-adjust\",\"target\":\"_self\",\"title\":\"\"}]}]', '2019-08-11 23:48:00', 1, '2020-08-10 21:02:37', NULL, '0'),
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
(4, 'email', 'info@loadus.com', NULL, '2020-05-28 12:02:34', NULL, '2020-08-24 06:12:36', '0'),
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
(1, 1, 1, 'vikrams@sourcesoftsolutions.com', 1, 100, 1, 1, 'ch_1HuJzZCj4XZipiorbeix9c5E', '2020-12-03 10:15:14', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-03 10:15:14', '2020-12-03 10:15:14', NULL),
(2, 3, 1, 'loadus2@yopmail.com', 1, 100, 1, 1, 'ch_1HuZ7gCj4XZipiorgezSX6Zs', '2020-12-04 02:24:36', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 02:24:36', '2020-12-04 02:24:36', NULL),
(3, 2, 1, 'loadus1@yopmail.com', 1, 100, 1, 1, 'ch_1HubDTCj4XZipiornWxEftIi', '2020-12-04 04:38:44', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 04:38:44', '2020-12-04 04:38:44', NULL),
(4, 4, 1, 'loadus3@yopmail.com', 1, 100, 1, 1, 'ch_1HuZ7gCj4XZipiorgezSX6Zs', '2020-12-04 02:24:36', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 02:24:36', '2020-12-04 02:24:36', NULL),
(5, 5, 1, 'loadus4@yopmail.com', 1, 100, 1, 1, 'ch_1HubDTCj4XZipiornWxEftIi', '2020-12-04 04:38:44', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 04:38:44', '2020-12-04 04:38:44', NULL),
(6, 6, 1, 'loadus5@yopmail.com', 1, 100, 1, 1, 'ch_1HuZ7gCj4XZipiorgezSX6Zs', '2020-12-04 02:24:36', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 02:24:36', '2020-12-04 02:24:36', NULL),
(7, 7, 1, 'loadus6@yopmail.com', 1, 100, 1, 1, 'ch_1HubDTCj4XZipiornWxEftIi', '2020-12-04 04:38:44', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 04:38:44', '2020-12-04 04:38:44', NULL),
(8, 8, 1, 'loadus7@yopmail.com', 1, 100, 1, 1, 'ch_1HuZ7gCj4XZipiorgezSX6Zs', '2020-12-04 02:24:36', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 02:24:36', '2020-12-04 02:24:36', NULL),
(9, 9, 1, 'loadus8@yopmail.com', 1, 100, 1, 1, 'ch_1HubDTCj4XZipiornWxEftIi', '2020-12-04 04:38:44', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 04:38:44', '2020-12-04 04:38:44', NULL),
(10, 10, 1, 'loadus9@yopmail.com', 1, 100, 1, 1, 'ch_1HuZ7gCj4XZipiorgezSX6Zs', '2020-12-04 02:24:36', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 02:24:36', '2020-12-04 02:24:36', NULL),
(11, 11, 1, 'loadus10@yopmail.com', 1, 100, 1, 1, 'ch_1HubDTCj4XZipiornWxEftIi', '2020-12-04 04:38:44', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 04:38:44', '2020-12-04 04:38:44', NULL),
(12, 12, 1, 'loadus11@yopmail.com', 1, 100, 1, 1, 'ch_1HuZ7gCj4XZipiorgezSX6Zs', '2020-12-04 02:24:36', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 02:24:36', '2020-12-04 02:24:36', NULL),
(13, 13, 1, 'loadus12@yopmail.com', 1, 100, 1, 1, 'ch_1HubDTCj4XZipiornWxEftIi', '2020-12-04 04:38:44', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 04:38:44', '2020-12-04 04:38:44', NULL),
(14, 14, 1, 'loadus13@yopmail.com', 1, 100, 1, 1, 'ch_1HuZ7gCj4XZipiorgezSX6Zs', '2020-12-04 02:24:36', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 02:24:36', '2020-12-04 02:24:36', NULL),
(15, 15, 1, 'loadus14@yopmail.com', 1, 100, 1, 1, 'ch_1HubDTCj4XZipiornWxEftIi', '2020-12-04 04:38:44', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 04:38:44', '2020-12-04 04:38:44', NULL),
(16, 16, 1, 'loadus15@yopmail.com', 1, 100, 1, 1, 'ch_1HubDTCj4XZipiornWxEftIi', '2020-12-04 04:38:44', 2, '<p>Join and get benifits of loadus in just $100/month</p>', 1, '2020-12-04 04:38:44', '2020-12-04 04:38:44', NULL);

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
(1, 'Vikram', 'Sharma', 'vikrams@sourcesoftsolutions.com', '2', 1, '785489653', '16070066088989.jpeg', '$2y$10$NJaxfvfcJBpNc4cyi/cx4Ois4smEtSQK7ODkz9XOPCho.iY7mSY2S', NULL, '1607013777', '2020-12-03 09:12:57', '2020-12-03 09:13:28', NULL),
(2, 'Account-1', NULL, 'loadus1@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$efFWzRum0/StTJ4zyiwcTu0FIa.WKhwhJloJ0k4G9Hdnve86HU8lO', NULL, '1607073886', '2020-12-04 01:54:46', NULL, NULL),
(3, 'Account-2', NULL, 'loadus2@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(4, 'Account-3\r\n', NULL, 'loadus3@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(5, 'Account-4\r\n', NULL, 'loadus4@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(6, 'Account-5', NULL, 'loadus5@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$efFWzRum0/StTJ4zyiwcTu0FIa.WKhwhJloJ0k4G9Hdnve86HU8lO', NULL, '1607073886', '2020-12-04 01:54:46', NULL, NULL),
(7, 'Account-6', NULL, 'loadus6@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(8, 'Account-7\r\n', NULL, 'loadus7@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(9, 'Account-8\r\n', NULL, 'loadus8@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(10, 'Account-9\r\n', NULL, 'loadus9@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(11, 'Account-10\r\n', NULL, 'loadus10@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(12, 'Account-11', NULL, 'loadus11@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$efFWzRum0/StTJ4zyiwcTu0FIa.WKhwhJloJ0k4G9Hdnve86HU8lO', NULL, '1607073886', '2020-12-04 01:54:46', NULL, NULL),
(13, 'Account-12', NULL, 'loadus12@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(14, 'Account-13\r\n', NULL, 'loadus13@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(15, 'Account-14\r\n', NULL, 'loadus14@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL),
(16, 'Account-15\r\n', NULL, 'loadus15@yopmail.com', '2', 1, '1234567890', NULL, '$2y$10$SnbvE1oJ5lyyVU.c3nFUse4qDTJLDEZzfflcsqc6iHhtt2fuYKBJy', NULL, '1607073967', '2020-12-04 01:56:07', NULL, NULL);

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
-- Indexes for table `tbl_mail_template`
--
ALTER TABLE `tbl_mail_template`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `group_flowers_members`
--
ALTER TABLE `group_flowers_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `group_flowers_tiers`
--
ALTER TABLE `group_flowers_tiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `group_flower_invitations`
--
ALTER TABLE `group_flower_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_mail_template`
--
ALTER TABLE `tbl_mail_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
