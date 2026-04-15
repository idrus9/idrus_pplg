-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 15 Apr 2026 pada 06.53
-- Versi Server: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_system`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL,
  `total_order` int(11) DEFAULT '0',
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `nama_pelanggan`, `email`, `nomor_hp`, `total_order`, `join_date`) VALUES
(1, 'Ahmad Zaki', 'zaki@example.com', '08123456789', 5, '2026-04-14 06:13:51'),
(2, 'Riana Putri', 'riana@example.com', '08571234567', 2, '2026-04-14 06:13:51'),
(3, 'agus', 'asfgys@gmail.com', '0985536', 0, '2026-04-14 06:23:08'),
(4, 'Denian', 'kwontwol11@gmail.com', '08*******56', 0, '2026-04-15 00:46:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mod_items`
--

CREATE TABLE `mod_items` (
  `id` int(11) NOT NULL,
  `nama_mod` varchar(100) NOT NULL,
  `game_target` varchar(100) NOT NULL,
  `versi` varchar(20) NOT NULL,
  `deskripsi` text,
  `harga` int(11) NOT NULL,
  `status` enum('Tersedia','Update','Nonaktif') DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mod_items`
--

INSERT INTO `mod_items` (`id`, `nama_mod`, `game_target`, `versi`, `deskripsi`, `harga`, `status`) VALUES
(2, 'Fast Car Script', 'Cyberpunk 2077', 'v1.0', 'Script untuk mempercepat mobil', 25000, 'Tersedia'),
(4, 'no mod', 'war thunder mobile', '2.2026', NULL, 0, 'Tersedia'),
(5, 'no mod', 'truck simulator big rigs', '8.6', NULL, 0, 'Tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mod_sales`
--

CREATE TABLE `mod_sales` (
  `id` int(11) NOT NULL,
  `nama_pembeli` varchar(100) NOT NULL,
  `nama_game` varchar(100) NOT NULL,
  `jenis_mod` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal_beli` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mod_sales`
--

INSERT INTO `mod_sales` (`id`, `nama_pembeli`, `nama_game`, `jenis_mod`, `harga`, `tanggal_beli`) VALUES
(1, 'Budi Santoso', 'GTA V', 'Graphic Ultra HD', 50000, '2026-04-14 03:55:16'),
(4, 'dafi haikal', 'ff', 'tidak pakai mod', 0, '2026-04-14 04:11:05'),
(5, 'agus', 'gta v', 'tidak pakai mod', 0, '2026-04-14 04:15:00'),
(6, 'dsa', 'gta 4', 'tidak pakai mod', 60000, '2026-04-14 05:44:07'),
(7, 'agus', 'war thunder mobile', 'tidak pakai mod', 0, '2026-04-14 23:59:49'),
(8, 'agus', 'war thunder mobile', 'tidak pakai mod', 0, '2026-04-15 00:10:46'),
(9, 'dika', 'war thunder mobile', 'tidak pakai mod', 0, '2026-04-15 00:11:11'),
(10, 'denian', 'GTA VII ULTRA HD', 'tidak pakai mod', 99999999, '2026-04-15 00:44:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'e0f7a4d0ef9b84b83b693bbf3feb8e6e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_items`
--
ALTER TABLE `mod_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_sales`
--
ALTER TABLE `mod_sales`
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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mod_items`
--
ALTER TABLE `mod_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mod_sales`
--
ALTER TABLE `mod_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
