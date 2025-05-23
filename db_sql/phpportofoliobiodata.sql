-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Waktu pembuatan: 21 Bulan Mei 2025 pada 12.36
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
-- Database: `phpportofoliobiodata`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `makanan`
--

CREATE TABLE `makanan` (
  `idportofolio` int(11) NOT NULL,
  `namaportofolio` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tahunmulai` year(4) NOT NULL,
  `tahunakhir` year(4) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `makanan`
--

INSERT INTO `makanan` (`idportofolio`, `namaportofolio`, `deskripsi`, `tahunmulai`, `tahunakhir`, `foto`) VALUES
(1, 'Nasi Goreng', 'Nasi goreng with chicken and vegetables', '2021', '2014', 'nasi-goreng.jpg'),
(9, 'Ini judul Pertama', 'Ini deskripsi Peratam', '2020', '2014', 'pembersih_bulu.jpg'),
(11, 'Ini Judul Portofolio', 'Ini judul deskripsi portofolio', '2024', '2015', 'wadah minum.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `idpekerjaan` int(11) NOT NULL,
  `namapekerjaan` varchar(255) NOT NULL,
  `deskripsipekerjaan` varchar(255) NOT NULL,
  `fotopekerjaan` varchar(255) NOT NULL,
  `tahunmulai` year(4) NOT NULL,
  `tahunakhir` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pekerjaan`
--

INSERT INTO `pekerjaan` (`idpekerjaan`, `namapekerjaan`, `deskripsipekerjaan`, `fotopekerjaan`, `tahunmulai`, `tahunakhir`) VALUES
(2, 'PT Kampung Baru', 'Mencakup job desc banyak sekali dan problem solve', 'susu.jpg', '2010', '2021'),
(3, 'Ini Pekerjaan', 'Ini Pekerjaan', 'Kucing Scottish Fold.jpg', '2019', '2012'),
(4, 'Ini pekerjaan peratama', 'ini deskripsi pekerjaan', 'cemilan.jpg', '2013', '2015');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendidikan`
--

CREATE TABLE `pendidikan` (
  `idpendidikan` int(11) NOT NULL,
  `namapendidikan` varchar(255) NOT NULL,
  `deskripsipendidikan` varchar(255) NOT NULL,
  `fotopendidikan` varchar(255) NOT NULL,
  `tahunmulai` year(4) NOT NULL,
  `tahunakhir` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendidikan`
--

INSERT INTO `pendidikan` (`idpendidikan`, `namapendidikan`, `deskripsipendidikan`, `fotopendidikan`, `tahunmulai`, `tahunakhir`) VALUES
(4, 'Sd Negeri 01 Jawa', 'Saya bersekolah dasar negeri jawa', 'shampo.jpg', '2010', '2016'),
(5, 'Sd Negeri 10 Jawa', 'Ini deskripsi pendidikan', 'shampo.jpg', '2014', '2015'),
(6, 'ini pendidikan', 'ini pendidikan deskripsi', 'susu.jpg', '2013', '2010');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `makanan`
--
ALTER TABLE `makanan`
  ADD PRIMARY KEY (`idportofolio`);

--
-- Indeks untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`idpekerjaan`);

--
-- Indeks untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`idpendidikan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `makanan`
--
ALTER TABLE `makanan`
  MODIFY `idportofolio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `idpekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `idpendidikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
