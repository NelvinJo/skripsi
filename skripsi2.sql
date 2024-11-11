-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 04:13 PM
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
-- Database: `skripsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` char(4) NOT NULL,
  `NamaDepan` varchar(40) NOT NULL,
  `NamaBelakang` varchar(40) NOT NULL,
  `NoHP` varchar(15) NOT NULL,
  `Email` varchar(225) NOT NULL,
  `Password` varchar(225) NOT NULL,
  `Role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `NamaDepan`, `NamaBelakang`, `NoHP`, `Email`, `Password`, `Role`) VALUES
('A001', 'Nelvin', 'Jonathan', '081807000519', 'nelvin@yahoo.com', 'd56b699830e77ba53855679cb1d252da', 'staff'),
('A002', 'Hoho', '', '0', 'hoho@yahoo.com', 'd56b699830e77ba53855679cb1d252da', 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `barangkeluar`
--

CREATE TABLE `barangkeluar` (
  `BKID` char(4) NOT NULL,
  `NamaPelanggan` varchar(225) NOT NULL,
  `TanggalKeluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `BMID` char(4) NOT NULL,
  `SupplierID` char(4) NOT NULL,
  `TanggalMasuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangtersedia`
--

CREATE TABLE `barangtersedia` (
  `BarangID` char(4) NOT NULL,
  `KategoriID` char(4) NOT NULL,
  `NamaBarang` varchar(40) NOT NULL,
  `SatuanBarang` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daftarproduk`
--

CREATE TABLE `daftarproduk` (
  `produkID` char(4) NOT NULL,
  `produkNAMA` varchar(30) NOT NULL,
  `produkJENIS` varchar(225) NOT NULL,
  `produkDESK` varchar(225) NOT NULL,
  `produkSTOK` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daftarproduk`
--

INSERT INTO `daftarproduk` (`produkID`, `produkNAMA`, `produkJENIS`, `produkDESK`, `produkSTOK`) VALUES
('P001', 'XDDWJDAb', 'FLKEJFKLFAb', ' WDDWKJDab', 211);

-- --------------------------------------------------------

--
-- Table structure for table `detailbarangkeluar`
--

CREATE TABLE `detailbarangkeluar` (
  `DetailKeluarID` char(4) NOT NULL,
  `BarangID` char(4) NOT NULL,
  `BKID` char(4) NOT NULL,
  `JumlahKeluar` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailbarangmasuk`
--

CREATE TABLE `detailbarangmasuk` (
  `DetailMasukID` char(4) NOT NULL,
  `BarangID` char(4) NOT NULL,
  `BMID` char(4) NOT NULL,
  `JumlahMasuk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailstockopname`
--

CREATE TABLE `detailstockopname` (
  `DetailOpnameID` char(4) NOT NULL,
  `BarangID` char(4) NOT NULL,
  `OpnameID` char(4) NOT NULL,
  `Perbedaan` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `KategoriID` char(4) NOT NULL,
  `NamaKategori` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`KategoriID`, `NamaKategori`) VALUES
('K001', 'JAM'),
('K002', 'JAM');

-- --------------------------------------------------------

--
-- Table structure for table `produkmasuk`
--

CREATE TABLE `produkmasuk` (
  `pmID` char(4) NOT NULL,
  `pmNAMA` varchar(30) NOT NULL,
  `pmJENIS` varchar(225) NOT NULL,
  `pmJUMLAH` int(4) NOT NULL,
  `pmTANGGAL` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produkterjual`
--

CREATE TABLE `produkterjual` (
  `ptID` char(4) NOT NULL,
  `ptNAMA` varchar(30) NOT NULL,
  `ptJENIS` varchar(255) NOT NULL,
  `ptHARGA` char(10) NOT NULL,
  `ptJUMLAH` int(4) NOT NULL,
  `ptTANGGAL` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkterjual`
--

INSERT INTO `produkterjual` (`ptID`, `ptNAMA`, `ptJENIS`, `ptHARGA`, `ptJUMLAH`, `ptTANGGAL`) VALUES
('PT01', 'MSLJDNIabc', 'FLKEJFKLFAabc', '10012', 12112, '2024-10-17');

-- --------------------------------------------------------

--
-- Table structure for table `rop`
--

CREATE TABLE `rop` (
  `ROPID` int(4) NOT NULL,
  `BarangID` char(4) NOT NULL,
  `JumlahPermintaan` int(50) NOT NULL,
  `LeadTime` int(50) NOT NULL,
  `SafetyStock` int(50) NOT NULL,
  `Hasil` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spesifikasibarang`
--

CREATE TABLE `spesifikasibarang` (
  `SpesifikasiID` char(4) NOT NULL,
  `BarangID` char(4) NOT NULL,
  `TipeID` char(4) NOT NULL,
  `WarnaID` char(4) NOT NULL,
  `JumlahStokBarang` int(4) NOT NULL,
  `HargaBarang` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stockopname`
--

CREATE TABLE `stockopname` (
  `OpnameID` char(4) NOT NULL,
  `TanggalOpname` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subkategori`
--

CREATE TABLE `subkategori` (
  `SubID` char(4) NOT NULL,
  `KategoriID` char(4) NOT NULL,
  `NamaSubKategori` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subkategori`
--

INSERT INTO `subkategori` (`SubID`, `KategoriID`, `NamaSubKategori`) VALUES
('PT01', '', 'JAM TANGAN'),
('SK01', '', 'JAM TANGAN');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` char(4) NOT NULL,
  `NamaSupplier` varchar(40) NOT NULL,
  `NoTelp` varchar(15) NOT NULL,
  `Alamat` varchar(225) NOT NULL,
  `Kota` varchar(20) NOT NULL,
  `Provinsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipe`
--

CREATE TABLE `tipe` (
  `TipeID` char(4) NOT NULL,
  `NamaTipe` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipe`
--

INSERT INTO `tipe` (`TipeID`, `NamaTipe`) VALUES
('T001', 'RANTAI');

-- --------------------------------------------------------

--
-- Table structure for table `warna`
--

CREATE TABLE `warna` (
  `WarnaID` char(4) NOT NULL,
  `NamaWarna` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warna`
--

INSERT INTO `warna` (`WarnaID`, `NamaWarna`) VALUES
('W001', 'HIJAU'),
('W002', 'Kuning');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `barangkeluar`
--
ALTER TABLE `barangkeluar`
  ADD PRIMARY KEY (`BKID`);

--
-- Indexes for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`BMID`);

--
-- Indexes for table `barangtersedia`
--
ALTER TABLE `barangtersedia`
  ADD PRIMARY KEY (`BarangID`);

--
-- Indexes for table `daftarproduk`
--
ALTER TABLE `daftarproduk`
  ADD PRIMARY KEY (`produkID`);

--
-- Indexes for table `detailbarangkeluar`
--
ALTER TABLE `detailbarangkeluar`
  ADD PRIMARY KEY (`DetailKeluarID`);

--
-- Indexes for table `detailbarangmasuk`
--
ALTER TABLE `detailbarangmasuk`
  ADD PRIMARY KEY (`DetailMasukID`);

--
-- Indexes for table `detailstockopname`
--
ALTER TABLE `detailstockopname`
  ADD PRIMARY KEY (`DetailOpnameID`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`KategoriID`);

--
-- Indexes for table `produkmasuk`
--
ALTER TABLE `produkmasuk`
  ADD PRIMARY KEY (`pmID`);

--
-- Indexes for table `produkterjual`
--
ALTER TABLE `produkterjual`
  ADD PRIMARY KEY (`ptID`);

--
-- Indexes for table `rop`
--
ALTER TABLE `rop`
  ADD PRIMARY KEY (`ROPID`);

--
-- Indexes for table `spesifikasibarang`
--
ALTER TABLE `spesifikasibarang`
  ADD PRIMARY KEY (`SpesifikasiID`);

--
-- Indexes for table `stockopname`
--
ALTER TABLE `stockopname`
  ADD PRIMARY KEY (`OpnameID`);

--
-- Indexes for table `subkategori`
--
ALTER TABLE `subkategori`
  ADD PRIMARY KEY (`SubID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Indexes for table `tipe`
--
ALTER TABLE `tipe`
  ADD PRIMARY KEY (`TipeID`);

--
-- Indexes for table `warna`
--
ALTER TABLE `warna`
  ADD PRIMARY KEY (`WarnaID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
