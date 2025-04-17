-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2025 at 04:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vivant`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `contact_name` varchar(50) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `country_code` varchar(10) NOT NULL DEFAULT '91',
  `contact_mobile` varchar(50) DEFAULT NULL,
  `gst_no` varchar(30) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `company_name`, `address`, `contact_name`, `contact_email`, `country_code`, `contact_mobile`, `gst_no`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'ABC Company', 'park street, chennai', 'Kumar', 'naveen@yopmail.com', '91', '9876543210', NULL, 'active', '2025-02-09 05:55:11', '2025-02-10 10:14:24', NULL, 1, NULL, NULL),
(2, 'XYZ Company', '123, Trichy', 'Karan', 'kumar@yopmail.com', '91', '9876543210', NULL, 'active', '2025-02-09 02:08:35', '2025-02-10 10:14:42', NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dc_masters`
--

CREATE TABLE `dc_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `starting_number` varchar(20) DEFAULT NULL,
  `numbering_type` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dc_masters`
--

INSERT INTO `dc_masters` (`id`, `from`, `to`, `starting_number`, `numbering_type`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'CHY', 'CHN', '1', 'CHY - CHN', 'active', '2025-03-28 21:35:28', '2025-03-28 21:37:59', NULL, 1, 1, NULL),
(2, 'CHY', 'FBD', '10', 'CHY - FBD', 'active', '2025-03-28 21:37:00', '2025-03-28 21:37:00', NULL, 1, NULL, NULL),
(3, 'CHY', 'MUM', '100', 'CHY - MUM', 'active', '2025-03-28 21:37:24', '2025-03-28 21:37:24', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2017_08_24_000000_create_settings_table', 1),
(5, '2024_12_25_062419_create_customers_table', 1),
(6, '2024_12_25_062621_create_packings_table', 1),
(7, '2024_12_25_062659_create_packing_details_table', 1),
(8, '2024_12_29_052344_add_role_to_users_table', 1),
(9, '2025_03_29_022103_create_dc_masters_table', 2),
(10, '2025_03_29_141630_add_column_dc_master_id_to_packings_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `packings`
--

CREATE TABLE `packings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `dc_master_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pl_no` varchar(50) DEFAULT NULL,
  `vehicle_no` varchar(20) DEFAULT NULL,
  `billing_date` date DEFAULT NULL,
  `status` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packings`
--

INSERT INTO `packings` (`id`, `user_id`, `customer_id`, `dc_master_id`, `pl_no`, `vehicle_no`, `billing_date`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(3, 2, 1, 1, '24-25/CHY/CHN/DC/1', 'TN28AS1231', '2025-03-29', 'approved', '2025-03-29 08:41:37', '2025-03-29 14:33:39', NULL, 2, 2, NULL),
(4, 2, 1, 3, '24-25/CHY/MUM/DC/100', 'TN28ABCD', '2025-03-29', 'pending', '2025-03-29 09:53:48', '2025-03-29 15:26:39', NULL, 2, NULL, NULL),
(5, 2, 2, 2, '24-25/CHY/FBD/DC/10', 'TN28AV1221', '2025-03-29', 'pending', '2025-03-29 09:56:22', '2025-03-29 09:56:22', NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `packing_details`
--

CREATE TABLE `packing_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `packing_id` bigint(20) UNSIGNED NOT NULL,
  `section_no` varchar(50) DEFAULT NULL,
  `cut_length` varchar(50) DEFAULT NULL,
  `alloy` varchar(50) DEFAULT NULL,
  `lot_no` varchar(50) DEFAULT NULL,
  `surface` varchar(50) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `pcs` varchar(10) DEFAULT NULL,
  `pack_date` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packing_details`
--

INSERT INTO `packing_details` (`id`, `packing_id`, `section_no`, `cut_length`, `alloy`, `lot_no`, `surface`, `weight`, `pcs`, `pack_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(15, 3, '5001', '6 Mtr', '6063-T6', 'PM001', 'Mill/Anodized', 62.00, '12', '05-02-2025', '2025-03-29 08:41:37', '2025-03-29 08:41:37', NULL),
(16, 3, '5001', '6 Mtr', '6063-T6', 'PM001', 'Mill/Anodized', 62.00, '12', '05-02-2025', '2025-03-29 08:41:37', '2025-03-29 08:41:37', NULL),
(17, 3, '5001', '6 Mtr', '6063-T6', 'PM001', 'Mill/Anodized', 62.00, '12', '05-02-2025', '2025-03-29 08:42:19', '2025-03-29 08:42:19', NULL),
(18, 4, '5001', '6 Mtr', '6063-T6', 'PM001', 'Mill/Anodized', 62.00, '12', '05-02-2025', '2025-03-29 09:53:48', '2025-03-29 09:53:48', NULL),
(19, 4, '5001', '6 Mtr', '6063-T6', 'PM001', 'Mill/Anodized', 62.00, '12', '05-02-2025', '2025-03-29 09:53:48', '2025-03-29 09:53:48', NULL),
(20, 5, '5001', '6 Mtr', '6063-T6', 'PM001', 'Mill/Anodized', 62.00, '12', '05-02-2025', '2025-03-29 09:56:22', '2025-03-29 09:56:22', NULL),
(21, 5, '5001', '6 Mtr', '6063-T6', 'PM001', 'Mill/Anodized', 62.00, '12', '05-02-2025', '2025-03-29 09:56:22', '2025-03-29 09:56:22', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `packing_list_view`
-- (See below for the actual view)
--
CREATE TABLE `packing_list_view` (
`packing_list_no` varchar(50)
,`packing_list_date` date
,`location_from` varchar(50)
,`location_to` varchar(50)
,`numbering_type` varchar(50)
,`customer_company_name` varchar(50)
,`vehicle_number` varchar(20)
,`section_no` varchar(50)
,`lot_no` varchar(50)
,`cut_length` varchar(50)
,`alloy_temper` varchar(50)
,`surface_finish` varchar(50)
,`weight` decimal(10,2)
,`pcs` varchar(10)
,`packed_date` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('user@yopmail.com', '$2y$12$CZBFSfrwRlpgXlil9nndNObjF8UJ8iVqHRfGPXcv.gte/tox6riyW', '2025-02-09 01:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Yc3EgBQZUriUIwqOrhXAQa6MxBDdedr7DLM0pA5b', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNmRleDVZT2M0bFRUellLbWVVRFk5WGQybjdURktHbzVOWFhONEFNYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXBvcnQvbGlzdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQzMjYwNjczO319', 1743262004);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'pl_start_no', '100'),
(2, 'country_code', '91'),
(3, 'country', 'India'),
(4, 'currency', 'Rs'),
(5, 'currency_code', 'IND'),
(6, 'currency_symbol', '₹'),
(7, 'site_name', 'VIVANT'),
(8, 'site_logo', 'logos/VkHCcSXouQOWyMFQVolPf8NTMo93TxsD4DfPg5Q5.png'),
(9, 'report_email', 'naveen@yopmail.com'),
(10, 'email_driver', 'smtp'),
(11, 'email_host', 'smtp.gmail.com'),
(12, 'email_port', '465'),
(13, 'email_encryption', 'ssl'),
(14, 'email_username', 'info@dreamstechnologies.com'),
(15, 'email_password', 'Orange@99');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `country_code` varchar(10) NOT NULL DEFAULT '91',
  `mobile` varchar(30) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `location` varchar(10) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `first_name`, `last_name`, `country_code`, `mobile`, `email`, `email_verified_at`, `location`, `address`, `profile_image`, `password`, `remember_token`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'Admin', 'User', '91', '9876543210', 'admin@yopmail.com', NULL, 'CBE', '<p>123, Test Address\r\n</p><p>Naveen kumar</p>', 'profile_images/P1TgWmEAGA0QF4CQ9zpKrr7oCjMvzcMuNpiZnCxe.jpg', '$2y$12$E0AhLT9jNzGBwFY.sonLvuulM.6kh4Tonilp4/jOkRVNefdR2UApS', NULL, 'active', '2025-01-18 20:48:44', '2025-03-24 08:02:42', NULL),
(2, 'user', 'Billing', 'User', '91', '9876543211', 'user@yopmail.com', NULL, 'CHY', '123, Test Address', NULL, '$2y$12$Fws2baQoebWaWCkj47XUs.8LhuE/035kTrGQDDagI/UaB1LQxwe0i', NULL, 'active', '2025-01-18 20:48:44', '2025-01-18 20:48:44', NULL);

-- --------------------------------------------------------

--
-- Structure for view `packing_list_view`
--
DROP TABLE IF EXISTS `packing_list_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `packing_list_view`  AS SELECT `p`.`pl_no` AS `packing_list_no`, `p`.`billing_date` AS `packing_list_date`, `dm`.`from` AS `location_from`, `dm`.`to` AS `location_to`, `dm`.`numbering_type` AS `numbering_type`, `c`.`company_name` AS `customer_company_name`, `p`.`vehicle_no` AS `vehicle_number`, `pd`.`section_no` AS `section_no`, `pd`.`lot_no` AS `lot_no`, `pd`.`cut_length` AS `cut_length`, `pd`.`alloy` AS `alloy_temper`, `pd`.`surface` AS `surface_finish`, `pd`.`weight` AS `weight`, `pd`.`pcs` AS `pcs`, `pd`.`pack_date` AS `packed_date` FROM (((`packings` `p` join `packing_details` `pd` on(`p`.`id` = `pd`.`packing_id`)) join `dc_masters` `dm` on(`p`.`dc_master_id` = `dm`.`id`)) join `customers` `c` on(`p`.`customer_id` = `c`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_created_by_foreign` (`created_by`),
  ADD KEY `customers_updated_by_foreign` (`updated_by`),
  ADD KEY `customers_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `dc_masters`
--
ALTER TABLE `dc_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dc_masters_created_by_foreign` (`created_by`),
  ADD KEY `dc_masters_updated_by_foreign` (`updated_by`),
  ADD KEY `dc_masters_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packings`
--
ALTER TABLE `packings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packings_user_id_foreign` (`user_id`),
  ADD KEY `packings_customer_id_foreign` (`customer_id`),
  ADD KEY `packings_created_by_foreign` (`created_by`),
  ADD KEY `packings_updated_by_foreign` (`updated_by`),
  ADD KEY `packings_deleted_by_foreign` (`deleted_by`),
  ADD KEY `packings_dc_master_id_foreign` (`dc_master_id`);

--
-- Indexes for table `packing_details`
--
ALTER TABLE `packing_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packing_details_packing_id_foreign` (`packing_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_key_index` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dc_masters`
--
ALTER TABLE `dc_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `packings`
--
ALTER TABLE `packings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `packing_details`
--
ALTER TABLE `packing_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `dc_masters`
--
ALTER TABLE `dc_masters`
  ADD CONSTRAINT `dc_masters_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `dc_masters_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `dc_masters_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `packings`
--
ALTER TABLE `packings`
  ADD CONSTRAINT `packings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `packings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `packings_dc_master_id_foreign` FOREIGN KEY (`dc_master_id`) REFERENCES `dc_masters` (`id`),
  ADD CONSTRAINT `packings_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `packings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `packings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `packing_details`
--
ALTER TABLE `packing_details`
  ADD CONSTRAINT `packing_details_packing_id_foreign` FOREIGN KEY (`packing_id`) REFERENCES `packings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
