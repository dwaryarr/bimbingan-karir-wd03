-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2025 at 02:32 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poliklinik-bkwd03`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_periksas`
--

CREATE TABLE `detail_periksas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_periksa` bigint UNSIGNED NOT NULL,
  `id_obat` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_periksas`
--

CREATE TABLE `jadwal_periksas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_dokter` bigint UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_periksas`
--

INSERT INTO `jadwal_periksas` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Selasa', '08:00:00', '12:00:00', 1, '2025-05-27 22:58:17', '2025-05-31 14:45:27'),
(2, 1, 'Rabu', '08:00:00', '12:00:00', 0, '2025-05-27 22:58:17', '2025-05-31 14:45:27'),
(3, 2, 'Rabu', '08:00:00', '12:00:00', 1, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(4, 2, 'Rabu', '13:00:00', '16:00:00', 0, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(5, 2, 'Kamis', '08:00:00', '12:00:00', 0, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(6, 2, 'Kamis', '13:00:00', '16:00:00', 0, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(7, 3, 'Kamis', '08:00:00', '12:00:00', 1, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(8, 3, 'Jumat', '08:00:00', '12:00:00', 0, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(9, 4, 'Jumat', '08:00:00', '12:00:00', 1, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(10, 4, 'Jumat', '13:00:00', '16:00:00', 0, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(11, 4, 'Sabtu', '08:00:00', '12:00:00', 0, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(12, 4, 'Sabtu', '13:00:00', '16:00:00', 0, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(13, 5, 'Senin', '08:00:00', '12:00:00', 1, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(14, 5, 'Selasa', '08:00:00', '12:00:00', 0, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(15, 1, 'Kamis', '08:00:00', '12:00:00', 0, '2025-05-31 14:35:35', '2025-05-31 14:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `janji_periksas`
--

CREATE TABLE `janji_periksas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pasien` bigint UNSIGNED NOT NULL,
  `id_jadwal_periksa` bigint UNSIGNED NOT NULL,
  `keluhan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_antrian` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_27_173407_create_obats_table', 1),
(5, '2025_05_27_173430_create_jadwal_periksas_table', 1),
(6, '2025_05_27_173453_create_janji_periksas_table', 1),
(7, '2025_05_27_173503_create_periksas_table', 1),
(8, '2025_05_27_173513_create_detail_periksas_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `obats`
--

CREATE TABLE `obats` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_obat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kemasan` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `obats`
--

INSERT INTO `obats` (`id`, `nama_obat`, `kemasan`, `harga`, `created_at`, `updated_at`) VALUES
(2, 'Amoxicillin', 'Kapsul 500mg', 12000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(3, 'Cetirizine', 'Tablet 10mg', 8000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(4, 'Omeprazole', 'Kapsul 20mg', 15000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(5, 'Ibuprofen', 'Tablet 400mg', 7000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(6, 'Loratadine', 'Tablet 10mg', 9000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(7, 'Metformin', 'Tablet 500mg', 10000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(8, 'Simvastatin', 'Tablet 20mg', 25000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(9, 'Aspirin', 'Tablet 80mg', 6000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(10, 'Dexamethasone', 'Tablet 0.5mg', 18000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(11, 'Furosemide', 'Tablet 40mg', 11000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(12, 'Metronidazole', 'Tablet 500mg', 13000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(13, 'Ranitidine', 'Tablet 150mg', 14000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(14, 'Salbutamol', 'Inhaler 100mcg', 45000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(15, 'Ciprofloxacin', 'Tablet 500mg', 20000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(16, 'Diazepam', 'Tablet 5mg', 22000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(17, 'Losartan', 'Tablet 50mg', 30000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(18, 'Amlodipine', 'Tablet 5mg', 17000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(19, 'Vitamin C', 'Tablet 500mg', 5000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(20, 'Vitamin B Complex', 'Kapsul', 12000, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(21, 'Paracetamol', 'Tablet 500 mg', 10000, '2025-05-31 14:48:04', '2025-05-31 14:48:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `periksas`
--

CREATE TABLE `periksas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_janji_periksa` bigint UNSIGNED NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya_periksa` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2WsNuXSCqQZ79JL0gR4Myv38ArjWfNUDxrMSZnO9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQTFYMDk5bVhIaW9sdTdDNHhKeHplc0xhR1EyOHFsalNrNVJyaHJGRyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kb2t0ZXIvb2JhdC9jcmVhdGUiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1748728104);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('pasien','dokter') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rm` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `alamat`, `no_ktp`, `no_hp`, `no_rm`, `poli`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Budi Santoso, Sp.PD', 'budi.santoso@klinik.com', '$2y$12$9Dx/vhfEoHee8FZmA2Lehee4UrAbj67AOm13KrUFBh4RZWmCacYOm', 'dokter', 'Jl. Pahlawan No. 123, Jakarta Selatan', '3175062505800001', '081234567890', NULL, 'Penyakit Dalam', NULL, NULL, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(2, 'Dr. Siti Rahayu, Sp.A', 'siti.rahayu@klinik.com', '$2y$12$4rQD4CHBtOB7Nrb6ruasTur5gldc8yzwi8PtCv0q8r4g3nUI/RQgS', 'dokter', 'Jl. Anggrek No. 45, Jakarta Pusat', '3175064610790002', '081234567891', NULL, 'Anak', NULL, NULL, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(3, 'Dr. Ahmad Wijaya, Sp.OG', 'ahmad.wijaya@klinik.com', '$2y$12$oEZda2DH501TunlB.V94OekffNYdoc0NzC5bIsEzrqsek69t.J2kG', 'dokter', 'Jl. Melati No. 78, Jakarta Barat', '3175061505780003', '081234567892', NULL, 'Kebidanan dan Kandungan', NULL, NULL, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(4, 'Dr. Rina Putri, Sp.M', 'rina.putri@klinik.com', '$2y$12$TfgUxXIvrPWxLUchQ2qBfOi.e1gbbX4Ier8RefwYrvcfsKq8w4pyO', 'dokter', 'Jl. Dahlia No. 32, Jakarta Timur', '3175062708850004', '081234567893', NULL, 'Mata', NULL, NULL, '2025-05-27 22:58:17', '2025-05-27 22:58:17'),
(5, 'Dr. Doni Pratama, Sp.THT', 'doni.pratama@klinik.com', '$2y$12$.M8tsVQR24Sy/OTQeFZ3Fee3Fz2vzRselXaIb8TEaV0v4b63A2a.6', 'dokter', 'Jl. Kenanga No. 56, Jakarta Utara', '3175061002820005', '081234567894', NULL, 'THT', NULL, NULL, '2025-05-27 22:58:17', '2025-05-27 22:58:17');

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
-- Indexes for table `detail_periksas`
--
ALTER TABLE `detail_periksas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_periksas_id_periksa_foreign` (`id_periksa`),
  ADD KEY `detail_periksas_id_obat_foreign` (`id_obat`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal_periksas`
--
ALTER TABLE `jadwal_periksas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_periksas_id_dokter_foreign` (`id_dokter`);

--
-- Indexes for table `janji_periksas`
--
ALTER TABLE `janji_periksas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `janji_periksas_id_pasien_foreign` (`id_pasien`),
  ADD KEY `janji_periksas_id_jadwal_periksa_foreign` (`id_jadwal_periksa`);

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
-- Indexes for table `obats`
--
ALTER TABLE `obats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `periksas`
--
ALTER TABLE `periksas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periksas_id_janji_periksa_foreign` (`id_janji_periksa`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `detail_periksas`
--
ALTER TABLE `detail_periksas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_periksas`
--
ALTER TABLE `jadwal_periksas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `janji_periksas`
--
ALTER TABLE `janji_periksas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `obats`
--
ALTER TABLE `obats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `periksas`
--
ALTER TABLE `periksas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_periksas`
--
ALTER TABLE `detail_periksas`
  ADD CONSTRAINT `detail_periksas_id_obat_foreign` FOREIGN KEY (`id_obat`) REFERENCES `obats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_periksas_id_periksa_foreign` FOREIGN KEY (`id_periksa`) REFERENCES `periksas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_periksas`
--
ALTER TABLE `jadwal_periksas`
  ADD CONSTRAINT `jadwal_periksas_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `janji_periksas`
--
ALTER TABLE `janji_periksas`
  ADD CONSTRAINT `janji_periksas_id_jadwal_periksa_foreign` FOREIGN KEY (`id_jadwal_periksa`) REFERENCES `jadwal_periksas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `janji_periksas_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `periksas`
--
ALTER TABLE `periksas`
  ADD CONSTRAINT `periksas_id_janji_periksa_foreign` FOREIGN KEY (`id_janji_periksa`) REFERENCES `janji_periksas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
