-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for kuis
CREATE DATABASE IF NOT EXISTS `kuis` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `kuis`;

-- Dumping structure for table kuis.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.cache: ~0 rows (approximately)

-- Dumping structure for table kuis.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.cache_locks: ~0 rows (approximately)

-- Dumping structure for table kuis.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table kuis.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.jobs: ~0 rows (approximately)

-- Dumping structure for table kuis.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.job_batches: ~0 rows (approximately)

-- Dumping structure for table kuis.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.migrations: ~1 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_05_12_053600_add_fields_to_users_table', 1),
	(5, '2026_05_12_053630_create_pinjaman_table', 1),
	(6, '2026_05_12_053656_create_transaksi_table', 1);

-- Dumping structure for table kuis.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table kuis.pinjaman
CREATE TABLE IF NOT EXISTS `pinjaman` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `sisa` decimal(15,2) NOT NULL,
  `status` enum('active','lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pinjaman_user_id_foreign` (`user_id`),
  CONSTRAINT `pinjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.pinjaman: ~3 rows (approximately)
INSERT INTO `pinjaman` (`id`, `user_id`, `jumlah`, `sisa`, `status`, `tanggal`, `created_at`, `updated_at`) VALUES
	(1, 1, 1000000.00, 0.00, 'lunas', '2026-05-12', '2026-05-11 22:42:29', '2026-05-11 22:44:31'),
	(3, 1, 10000.00, 0.00, 'lunas', '2026-05-12', '2026-05-11 22:45:50', '2026-05-11 22:46:03'),
	(4, 1, 12000.00, 0.00, 'lunas', '2026-05-12', '2026-05-11 23:25:00', '2026-05-11 23:25:14'),
	(5, 1, 15000000.00, 13500000.00, 'active', '2026-05-12', '2026-05-12 00:03:36', '2026-05-12 00:03:46');

-- Dumping structure for table kuis.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('vSLHvU5Jp2oE9NYbIT4N2tgBYKmSe2wsyHTdC3IS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJLdG01YzVNcVMxQXdyZHFMbUxPMUFCa2twTmZvNXRXRjdESDVGVHNMIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1778570060),
	('xovkO52RuTNPtOpTDMtYtEtNqPqs2QEEpyVdAaZb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.119.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'eyJfdG9rZW4iOiIzYmZPYVg2RkhXa0M5RXMzTWlURTRiQlRtMEw1ODlCU1RPYmhITUc2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsb2dpbiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1778564458);

-- Dumping structure for table kuis.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `pinjaman_id` bigint unsigned DEFAULT NULL,
  `jenis` enum('tabung','ambil','pinjam','bayar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_user_id_foreign` (`user_id`),
  KEY `transaksi_pinjaman_id_foreign` (`pinjaman_id`),
  CONSTRAINT `transaksi_pinjaman_id_foreign` FOREIGN KEY (`pinjaman_id`) REFERENCES `pinjaman` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transaksi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.transaksi: ~10 rows (approximately)
INSERT INTO `transaksi` (`id`, `user_id`, `pinjaman_id`, `jenis`, `jumlah`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'pinjam', 1000000.00, 'Pinjam uang', '2026-05-11 22:42:29', '2026-05-11 22:42:29'),
	(2, 1, NULL, 'ambil', 500000.00, 'Ambil uang', '2026-05-11 22:42:42', '2026-05-11 22:42:42'),
	(3, 1, 1, 'bayar', 500000.00, 'Bayar pinjaman #1', '2026-05-11 22:42:54', '2026-05-11 22:42:54'),
	(4, 1, NULL, 'tabung', 10000000.00, 'Tabung uang', '2026-05-11 22:44:04', '2026-05-11 22:44:04'),
	(5, 1, 1, 'bayar', 500000.00, 'Bayar pinjaman #1', '2026-05-11 22:44:31', '2026-05-11 22:44:31'),
	(6, 1, NULL, 'ambil', 1000000.00, 'Ambil uang', '2026-05-11 22:44:47', '2026-05-11 22:44:47'),
	(7, 1, NULL, 'pinjam', 100000000000.00, 'Pinjam uang', '2026-05-11 22:45:00', '2026-05-11 22:45:00'),
	(8, 1, NULL, 'bayar', 99999999998.00, 'Bayar pinjaman #2', '2026-05-11 22:45:15', '2026-05-11 22:45:15'),
	(9, 1, 3, 'pinjam', 10000.00, 'Pinjam uang', '2026-05-11 22:45:50', '2026-05-11 22:45:50'),
	(10, 1, 3, 'bayar', 10000.00, 'Bayar pinjaman #3', '2026-05-11 22:46:03', '2026-05-11 22:46:03'),
	(11, 1, 4, 'pinjam', 12000.00, 'Pinjam uang', '2026-05-11 23:25:00', '2026-05-11 23:25:00'),
	(12, 1, 4, 'bayar', 12000.00, 'Bayar pinjaman #4', '2026-05-11 23:25:14', '2026-05-11 23:25:14'),
	(13, 1, 5, 'pinjam', 15000000.00, 'Pinjam uang', '2026-05-12 00:03:36', '2026-05-12 00:03:36'),
	(14, 1, 5, 'bayar', 1500000.00, 'Bayar pinjaman #5', '2026-05-12 00:03:46', '2026-05-12 00:03:46'),
	(15, 1, NULL, 'ambil', 2000000.00, 'Ambil uang', '2026-05-12 00:03:56', '2026-05-12 00:03:56'),
	(16, 1, NULL, 'ambil', 1000002.00, 'Ambil uang', '2026-05-12 00:04:07', '2026-05-12 00:04:07');

-- Dumping structure for table kuis.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo` decimal(15,2) NOT NULL DEFAULT '0.00',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kuis.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `username`, `saldo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Kamdi Togar', 'kamit', 19000000.00, 'kamit@koperasi.com', NULL, '$2y$12$/KcXkxjR7fWvmc60sxC6Cej83UzQjLiTCW1.H0EtdstN.n0v070fa', NULL, '2026-05-11 22:41:55', '2026-05-12 00:04:07');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
