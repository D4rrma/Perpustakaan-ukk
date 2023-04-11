-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2023 at 07:36 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buku_kita`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertKategori` (`namaKategori` VARCHAR(50))   BEGIN INSERT INTO kategori VALUES (null, namaKategori); END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `penerbit` varchar(50) DEFAULT NULL,
  `pengarang` varchar(50) DEFAULT NULL,
  `tahun` varchar(4) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penerbit`, `pengarang`, `tahun`, `kategori_id`, `harga`, `foto`, `deskripsi`) VALUES
(12, 'Dilan 1 (shabrinabachtiar)', 'Dari Mizan', 'Pidi Baiq', '2014', 71, 90000, 'dilan-1-(shabrinabachtiar)-min.jpg', 'asdasdwdhbewdesadeddddd\r\nddddddsaaaaaaaaaaaaaasda\\\r\nnsdwdhbewdesadedddddd\r\ndddddsaaaaaaaaaaaaaasda\r\nsdwdhbewdesadeddddddddd\r\n'),
(28, 'Sihir Perempuan', 'Gramedia Pustaka Utama', 'Intan Paramaditha', '2023', 73, 67, '1.jpg', NULL),
(29, '5 Cm', 'Gramedia Widiasarana Indonesia', 'Donny Dhirgantoro', '2019', 73, 68, '5cm.jpg', NULL),
(30, 'Midnight Prince', 'Elex Media Komputindo', 'Titi Sanaria', '2022', 71, 60, 'midnight_prince_Page_1.jpg', NULL),
(31, 'Psikologi Eksperimen: Teori dan Implementasi', 'Adipura', 'Nuraeni, S.Psi', '2021', 74, 78, 'Psikologi_Eksperimen_TeoriImplementasi.jpg', NULL),
(32, 'Metode Pengasuhan Anak', 'Madani', 'DR. MOHAMMAD MAHPUR, M.SI. DKK', '2021', 74, 85, '3.jpeg', NULL),
(33, 'Nikel Indonesia Menuju Transisi Energi', 'Gramedia Pustaka Utama', ' Prof. Dr. Ir. Irwandy Arif, M.Sc', ' 202', 76, 205, '4.jpg', NULL),
(34, 'Shadows of Forgotten Ancestors', 'Kepustakaan Populer Gramedia', 'Carl Sagan', '2023', 76, 160, '5_1.jpg', NULL),
(35, '7 Materi Pemrograman Web Modern', 'Elex Media Komputindo', 'Rohi Abdulloh', '2023', 75, 150, '6.jpg', NULL),
(36, 'Machine Learning Tingkat Dasar dan Lanjut Edisi-2', 'Penerbit Informatika', 'Dr. Suyanto, S.T., M.Sc.', '2023', 75, 170, '7.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(71, 'Romansa'),
(73, 'Sastra'),
(74, 'Psikologi'),
(75, 'Komputer-Teknologi'),
(76, 'Sains');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('user','admin') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tlp` varchar(13) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `level`, `foto`, `tlp`, `alamat`) VALUES
(2, 'Farhan Kebab', 'user', 'c4ca4238a0b923820dcc509a6f75849b', 'user', 'Screenshot (2)_3.png', '02883621551', 'bangli'),
(7, 'hexa', '1', 'c81e728d9d4c2f636f067f89cc14862c', 'admin', '4.jpg', '1', '1'),
(15, 'JOKO', '2w', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
