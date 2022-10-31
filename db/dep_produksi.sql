-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2022 at 01:19 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dep_produksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_barang`
--

CREATE TABLE `m_barang` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_barang`
--

INSERT INTO `m_barang` (`id`, `kode`, `nama`, `harga`) VALUES
(1, 'A001', 'Barang A', '200000'),
(2, 'C025', 'Barang B', '350000'),
(3, 'A102', 'Barang C', '125000'),
(4, 'A301', 'Barang D', '300000'),
(5, 'B221', 'Barang E', '300000');

-- --------------------------------------------------------

--
-- Table structure for table `m_customer`
--

CREATE TABLE `m_customer` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_customer`
--

INSERT INTO `m_customer` (`id`, `kode`, `name`, `telp`) VALUES
(1, 'C-001', 'Cust A', '081312345678'),
(2, 'C-002', 'Cust B', '081323456789'),
(3, 'C-003', 'Cust C', '08134567890'),
(4, 'C-004', 'Cust D', '08135678901');

-- --------------------------------------------------------

--
-- Table structure for table `t_sales`
--

CREATE TABLE `t_sales` (
  `id` int(11) NOT NULL,
  `kode` varchar(15) NOT NULL,
  `tgl` datetime NOT NULL,
  `cust_id` int(11) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `diskon` decimal(10,0) NOT NULL,
  `ongkir` decimal(10,0) NOT NULL,
  `total_bayar` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_sales`
--

INSERT INTO `t_sales` (`id`, `kode`, `tgl`, `cust_id`, `subtotal`, `diskon`, `ongkir`, `total_bayar`) VALUES
(80, 'sales-635fb924e', '2022-10-31 00:00:00', 2, '650000', '10000', '20000', '660000');

-- --------------------------------------------------------

--
-- Table structure for table `t_sales_det`
--

CREATE TABLE `t_sales_det` (
  `sales_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga_bandrol` decimal(10,0) NOT NULL,
  `qty` int(11) NOT NULL,
  `diskon_pct` decimal(10,0) NOT NULL,
  `diskon_nilai` decimal(10,0) NOT NULL,
  `harga_diskon` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_sales_det`
--

INSERT INTO `t_sales_det` (`sales_id`, `barang_id`, `harga_bandrol`, `qty`, `diskon_pct`, `diskon_nilai`, `harga_diskon`, `total`) VALUES
(80, 2, '350000', 2, '10', '12500', '112500', '225000'),
(80, 3, '125000', 4, '15', '18750', '106250', '425000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_barang`
--
ALTER TABLE `m_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_customer`
--
ALTER TABLE `m_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_sales`
--
ALTER TABLE `t_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_sales_det`
--
ALTER TABLE `t_sales_det`
  ADD KEY `barang_id` (`barang_id`),
  ADD KEY `sales_id` (`sales_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_barang`
--
ALTER TABLE `m_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_customer`
--
ALTER TABLE `m_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_sales`
--
ALTER TABLE `t_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_sales_det`
--
ALTER TABLE `t_sales_det`
  ADD CONSTRAINT `t_sales_det_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `m_barang` (`id`),
  ADD CONSTRAINT `t_sales_det_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `t_sales` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
