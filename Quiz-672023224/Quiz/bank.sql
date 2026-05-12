-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Bulan Mei 2026 pada 10.13
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_01_000001_create_users_table', 1),
(2, '2024_01_01_000002_create_tabungan_table', 1),
(3, '2024_01_01_000003_create_pinjaman_table', 1),
(4, '2024_01_01_000004_create_pembayaran_pinjaman_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran_pinjaman`
--

CREATE TABLE `pembayaran_pinjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pinjaman_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_bayar` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayaran_pinjaman`
--

INSERT INTO `pembayaran_pinjaman` (`id`, `pinjaman_id`, `user_id`, `jumlah_bayar`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100000.00, '2026-05-11 23:25:43', '2026-05-11 23:25:43'),
(2, 2, 1, 2000000.00, '2026-05-12 00:48:30', '2026-05-12 00:48:30'),
(3, 2, 1, 8000000.00, '2026-05-12 00:55:36', '2026-05-12 00:55:36'),
(4, 4, 1, 10000000.00, '2026-05-12 00:59:51', '2026-05-12 00:59:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_pinjaman` decimal(15,2) NOT NULL,
  `sisa_pinjaman` decimal(15,2) NOT NULL,
  `status` enum('active','lunas') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `user_id`, `jumlah_pinjaman`, `sisa_pinjaman`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 100000.00, 0.00, 'lunas', '2026-05-11 23:25:25', '2026-05-11 23:25:43'),
(2, 1, 10000000.00, 0.00, 'lunas', '2026-05-12 00:48:19', '2026-05-12 00:55:36'),
(3, 1, 500000000.00, 500000000.00, 'active', '2026-05-12 00:55:25', '2026-05-12 00:55:25'),
(4, 1, 10000000.00, 0.00, 'lunas', '2026-05-12 00:59:41', '2026-05-12 00:59:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabungan`
--

CREATE TABLE `tabungan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `tipe` enum('setor','tarik') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tabungan`
--

INSERT INTO `tabungan` (`id`, `user_id`, `jumlah`, `tipe`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 250000.00, 'setor', 'Setoran tabungan', '2026-05-11 23:25:11', '2026-05-11 23:25:11'),
(2, 1, 40000.00, 'tarik', 'Penarikan tabungan', '2026-05-11 23:25:51', '2026-05-11 23:25:51'),
(3, 1, 200000.00, 'setor', 'Setoran tabungan', '2026-05-12 00:21:23', '2026-05-12 00:21:23'),
(4, 1, 30000.00, 'tarik', 'Penarikan tabungan', '2026-05-12 00:21:30', '2026-05-12 00:21:30'),
(5, 1, 100000000.00, 'setor', 'Setoran tabungan', '2026-05-12 00:43:41', '2026-05-12 00:43:41'),
(6, 1, 300000.00, 'tarik', 'Penarikan tabungan', '2026-05-12 00:43:49', '2026-05-12 00:43:49'),
(7, 1, 70000000.00, 'tarik', 'Penarikan tabungan', '2026-05-12 00:55:14', '2026-05-12 00:55:14'),
(8, 1, 3000000.00, 'tarik', 'Penarikan tabungan', '2026-05-12 00:59:14', '2026-05-12 00:59:14'),
(9, 1, 3000000.00, 'setor', 'Setoran tabungan', '2026-05-12 00:59:25', '2026-05-12 00:59:25'),
(10, 1, 500000000.00, 'tarik', 'Penarikan tabungan', '2026-05-12 00:59:32', '2026-05-12 00:59:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `saldo` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `username`, `password`, `saldo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad Kresna Hari Mufti', 'Kresna', '$2y$12$31KySHYLS0DBmML2Y0Z/FO2X93Hvt0oMMgIXt9brheWOD3lJe61h.', 30080000.00, NULL, '2026-05-11 23:24:57', '2026-05-12 00:59:51');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran_pinjaman`
--
ALTER TABLE `pembayaran_pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_pinjaman_pinjaman_id_foreign` (`pinjaman_id`),
  ADD KEY `pembayaran_pinjaman_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinjaman_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tabungan_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pembayaran_pinjaman`
--
ALTER TABLE `pembayaran_pinjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembayaran_pinjaman`
--
ALTER TABLE `pembayaran_pinjaman`
  ADD CONSTRAINT `pembayaran_pinjaman_pinjaman_id_foreign` FOREIGN KEY (`pinjaman_id`) REFERENCES `pinjaman` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_pinjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `pinjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  ADD CONSTRAINT `tabungan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
