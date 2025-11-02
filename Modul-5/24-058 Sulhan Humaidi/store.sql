-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2025 at 03:54 PM
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
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(10) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`) VALUES
(2, 'BRG002', 'Mouse Optik B', 150000, 50),
(4, 'BRG004', 'Monitor LED 24 inch', 2500000, 20),
(5, 'BRG005', 'Beras Super 5kg', 65000, 100),
(6, 'BRG006', 'Minyak Goreng 2L', 30000, 200),
(7, 'BRG007', 'Meja Kayu Jati', 1500000, 10),
(8, 'BRG008', 'Kursi Kantor', 750000, 25),
(9, 'BRG009', 'Smartphone X', 4500000, 30),
(10, 'BRG010', 'Kipas Angin', 300000, 40);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('PLG001', 'Andi Budiman', 'L', '08121111001', 'Jl. Apel No. 1 Jakarta'),
('PLG002', 'Siti Aminah', 'P', '08121111002', 'Jl. Mangga No. 2 Bandung'),
('PLG003', 'Budi Santoso', 'L', '08121111003', 'Jl. Jeruk No. 3 Surabaya'),
('PLG004', 'Dewi Lestari', 'P', '08121111004', 'Jl. Anggur No. 4 Semarang'),
('PLG005', 'Eko Prasetyo', 'L', '08121111005', 'Jl. Nanas No. 5 Yogyakarta'),
('PLG006', 'Fitri Handayani', 'P', '08121111006', 'Jl. Rambutan No. 6 Medan'),
('PLG007', 'Guntur Wibowo', 'L', '08121111007', 'Jl. Sawo No. 7 Makassar'),
('PLG008', 'Hesti Wulandari', 'P', '08121111008', 'Jl. Durian No. 8 Padang'),
('PLG009', 'Indra Setiawan', 'L', '08121111009', 'Jl. Manggis No. 9 Bali'),
('PLG010', 'Joko Susilo', 'L', '08121111010', 'Jl. Kiwi No. 10 Palembang');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `waktu_bayar` datetime DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') DEFAULT NULL,
  `transaksi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2025-10-01 10:30:00', 12150000, 'TRANSFER', 1),
(2, '2025-10-02 11:00:00', 1600000, 'EDC', 2),
(3, '2025-10-03 14:15:00', 125000, 'TUNAI', 3),
(4, '2025-10-04 16:00:00', 2500000, 'TRANSFER', 4),
(5, '2025-10-05 09:30:00', 3000000, 'EDC', 5),
(6, '2025-10-06 13:00:00', 300000, 'TUNAI', 6),
(7, '2025-10-07 17:45:00', 4500000, 'EDC', 7),
(8, '2025-10-08 11:20:00', 300000, 'TUNAI', 8),
(9, '2025-10-09 10:10:00', 17000000, 'TRANSFER', 9),
(10, '2025-10-10 15:00:00', 325000, 'TUNAI', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(17, 'jhasd jwhg', '1212', 'jhasgdja1'),
(18, 'qkugqg ', '273614986439', 'askjqejfl 1'),
(19, 'camaba', '89273981', 'mantap123'),
(20, 'semangat bang', '08374982', 'telang indah gang 1'),
(21, 'orang tampan', '892634846', 'giogio12'),
(22, 'sun gokong', '093274983749', 'wukong kece 123'),
(23, 'namaku bento', '87213687263', 'jakarta usyara 1'),
(24, 'Makasih orang Baik', '1782638713', 'siappppp32'),
(25, 'Stop Halu', '7813582583', 'titik temu 2'),
(26, 'Semangat Bang', '89213982', 'Gang Pop ice nomor 1');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `waktu_transaksi` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `pelanggan_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2025-10-01', 'Pembelian laptop dan mouse', 12150000, 'PLG001'),
(2, '2025-10-02', 'Beli 2 keyboard', 1600000, 'PLG002'),
(3, '2025-10-03', 'Pembelian sembako', 125000, 'PLG003'),
(4, '2025-10-04', 'Beli monitor', 2500000, 'PLG004'),
(5, '2025-10-05', 'Beli meja dan 2 kursi', 3000000, 'PLG005'),
(6, '2025-10-06', 'Beli 10 minyak goreng', 300000, 'PLG006'),
(7, '2025-10-07', 'Beli smartphone', 4500000, 'PLG007'),
(8, '2025-10-08', 'Beli kipas angin', 300000, 'PLG008'),
(9, '2025-10-09', 'Beli 1 laptop dan 2 monitor', 17000000, 'PLG009'),
(10, '2025-10-10', 'Beli beras 5 karung', 325000, 'PLG010');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 12000000, 1),
(1, 2, 150000, 1),
(2, 3, 800000, 2),
(3, 5, 65000, 1),
(3, 6, 30000, 2),
(4, 4, 2500000, 1),
(5, 7, 1500000, 1),
(5, 8, 750000, 2),
(6, 6, 30000, 10),
(7, 9, 4500000, 1),
(8, 10, 300000, 1),
(9, 1, 12000000, 1),
(9, 4, 2500000, 2),
(10, 5, 65000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` tinyint(2) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'Kantor Pusat', '08100000001', 1),
(2, 'kasir1', 'c7911af3adbd12a035b289556d96470a', 'Budi Kasir', 'Jl. Kasir No. 1', '08100000002', 2),
(3, 'kasir2', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 'Siti Kasir', 'Jl. Kasir No. 2', '08100000003', 2),
(4, 'gudang', 'f2291e0131b4049d51d14303b3b4d49d', 'Eko Gudang', 'Area Pergudangan', '08100000004', 3),
(5, 'manager', '1d0258c2440a8d19e716292b231e3190', 'Dewi Manajer', 'Ruang Manajer', '08100000005', 1),
(6, 'staff1', '698d51a19d8a121ce581499d7b701668', 'Fitri Staff', 'Meja Staff 1', '08100000006', 2),
(7, 'staff2', 'c9f0f895fb98ab9159f51fd0297e236d', 'Guntur Staff', 'Meja Staff 2', '08100000007', 2),
(8, 'operator', '01cfcd4f6b8770febfb40cb906715822', 'Hesti Operator', 'Ruang Operator', '08100000008', 3),
(9, 'keuangan', 'bda96eac67b3f94f995666f1f46f4f28', 'Indra Keuangan', 'Ruang Finance', '08100000009', 1),
(10, 'ceo', '63eefbd45d89e02c1ef4c9c15e4b83d0', 'Joko CEO', 'Ruang Direksi', '08100000010', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
