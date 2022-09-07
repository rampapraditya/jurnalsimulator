-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 07, 2022 at 02:05 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jurnalsimulator`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

DROP TABLE IF EXISTS `divisi`;
CREATE TABLE IF NOT EXISTS `divisi` (
  `iddivisi` varchar(6) NOT NULL,
  `nama_divisi` varchar(45) NOT NULL,
  `idrole` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`iddivisi`),
  KEY `FK_divisi_department` (`idrole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`iddivisi`, `nama_divisi`, `idrole`) VALUES
('D00001', 'RENOPSLAT', 'R00002'),
('D00002', 'EVALAT', 'R00002'),
('D00003', 'SKENLAT', 'R00002'),
('D00005', 'ASTT', 'R00003'),
('D00006', 'CTT', 'R00003'),
('D00007', 'TFG', 'R00003'),
('D00008', 'SCC', 'R00003'),
('D00009', 'PAU', 'R00006'),
('D00010', 'PAK / PERNIKA', 'R00006'),
('D00011', 'PSKT', 'R00004'),
('D00012', 'HARSIS', 'R00004'),
('D00013', 'HARFASBAN', 'R00004');

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

DROP TABLE IF EXISTS `identitas`;
CREATE TABLE IF NOT EXISTS `identitas` (
  `kode` varchar(6) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `instansi` varchar(255) CHARACTER SET latin1 NOT NULL,
  `slogan` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `tahun` float DEFAULT NULL,
  `pimpinan` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `kdpos` varchar(7) CHARACTER SET latin1 DEFAULT NULL,
  `tlp` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `fax` varchar(35) CHARACTER SET latin1 DEFAULT NULL,
  `website` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `logo` longtext CHARACTER SET latin1,
  `lat` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `lon` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `identitas`
--

INSERT INTO `identitas` (`kode`, `instansi`, `slogan`, `tahun`, `pimpinan`, `alamat`, `kdpos`, `tlp`, `fax`, `website`, `email`, `logo`, `lat`, `lon`) VALUES
('K00001', 'Puslatlekdalsen', 'Gladi Jalasena Yudha', 1984, 'Kolonel Laut (P) Irwan Sobirin', 'Morokrembangan, Kec. Krembangan, Kota SBY, Jawa Timur', '60178', '(031) 3284846', '-', 'https://kodiklatal.tnial.mil.id/', NULL, '1661258277_43f4376b76ebdf8d9332.jpg', '-7.2238417', '112.7142937');

-- --------------------------------------------------------

--
-- Table structure for table `korps`
--

DROP TABLE IF EXISTS `korps`;
CREATE TABLE IF NOT EXISTS `korps` (
  `idkorps` varchar(6) NOT NULL,
  `nama_korps` varchar(45) NOT NULL,
  PRIMARY KEY (`idkorps`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korps`
--

INSERT INTO `korps` (`idkorps`, `nama_korps`) VALUES
('K00000', 'ADMINISTRATOR'),
('K00001', 'Laut (P)'),
('K00002', 'Laut (T)'),
('K00003', 'Laut (E)'),
('K00004', 'Laut (S)'),
('K00005', 'Laut (PM)'),
('K00006', 'Laut (K)'),
('K00007', 'Laut (KH)'),
('K00008', 'Marinir'),
('K00009', 'Bah'),
('K00010', 'Nav'),
('K00011', 'Kom'),
('K00012', 'Tlg'),
('K00013', 'Ekl'),
('K00014', 'Eko'),
('K00015', 'Mer'),
('K00016', 'Amo'),
('K00017', 'Rdl'),
('K00018', 'SAA'),
('K00019', 'SBA'),
('K00020', 'TRB'),
('K00021', 'Esa'),
('K00022', 'ETK'),
('K00023', 'PDK'),
('K00024', 'Jas'),
('K00025', 'Mus'),
('K00026', 'TTG'),
('K00027', 'Ttu'),
('K00028', 'Keu'),
('K00029', 'Mes'),
('K00030', 'Lis'),
('K00031', 'TKU'),
('K00032', 'MPU'),
('K00033', 'LPU'),
('K00034', 'Ang'),
('K00036', 'POM'),
('K00037', 'EDE'),
('K00038', 'Lek'),
('K00039', 'Pas'),
('K00040', 'PNS'),
('K00042', 'Tek'),
('K00043', 'Bek'),
('K00044', 'Adm');

-- --------------------------------------------------------

--
-- Table structure for table `osl`
--

DROP TABLE IF EXISTS `osl`;
CREATE TABLE IF NOT EXISTS `osl` (
  `idop_simulator` varchar(6) NOT NULL,
  `tanggal` date NOT NULL,
  `kegiatan` varchar(65) NOT NULL,
  `waktu_on` varchar(10) NOT NULL,
  `waktu_off` varchar(10) NOT NULL,
  `kondisi` varchar(45) NOT NULL COMMENT 'normal, sakit',
  `keterangan` text NOT NULL,
  `foto` varchar(150) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `idsuratmasuk` varchar(6) NOT NULL,
  PRIMARY KEY (`idop_simulator`),
  KEY `FK_osl_users` (`idusers`),
  KEY `FK_osl_suratmasuk` (`idsuratmasuk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latihan';

-- --------------------------------------------------------

--
-- Table structure for table `osp`
--

DROP TABLE IF EXISTS `osp`;
CREATE TABLE IF NOT EXISTS `osp` (
  `idop_simulator` varchar(6) NOT NULL,
  `tanggal` date NOT NULL,
  `kegiatan` varchar(65) NOT NULL,
  `waktu_on` varchar(10) NOT NULL,
  `waktu_off` varchar(10) NOT NULL,
  `kondisi` varchar(45) NOT NULL COMMENT 'normal, sakit',
  `keterangan` text NOT NULL,
  `foto` varchar(150) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`idop_simulator`),
  KEY `FK_operasional_simulator_pemanasan_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='pemanasan';

-- --------------------------------------------------------

--
-- Table structure for table `pangkat`
--

DROP TABLE IF EXISTS `pangkat`;
CREATE TABLE IF NOT EXISTS `pangkat` (
  `idpangkat` varchar(6) NOT NULL,
  `nama_pangkat` varchar(45) NOT NULL,
  `mode` varchar(45) NOT NULL,
  PRIMARY KEY (`idpangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pangkat`
--

INSERT INTO `pangkat` (`idpangkat`, `nama_pangkat`, `mode`) VALUES
('P00001', 'ADMINISTRATOR', 'MILITER'),
('P00005', 'Laksma TNI', 'MILITER'),
('P00010', 'Kolonel', 'MILITER'),
('P00011', 'Letkol', 'MILITER'),
('P00012', 'Mayor', 'MILITER'),
('P00013', 'Kapten', 'MILITER'),
('P00014', 'Lettu', 'MILITER'),
('P00016', 'Peltu', 'MILITER'),
('P00017', 'Pelda', 'MILITER'),
('P00018', 'Serma', 'MILITER'),
('P00019', 'Serka', 'MILITER'),
('P00020', 'Sertu', 'MILITER'),
('P00034', 'Serda', 'MILITER');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `idrole` varchar(6) NOT NULL,
  `nama_role` varchar(45) NOT NULL,
  PRIMARY KEY (`idrole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`idrole`, `nama_role`) VALUES
('R00001', 'ADMINISTRATOR'),
('R00002', 'RENLAT'),
('R00003', 'OPSLAT'),
('R00004', 'DUKOPSLAT'),
('R00005', 'MINLOG'),
('R00006', 'UJI PUANPUR'),
('R00007', 'SET');

-- --------------------------------------------------------

--
-- Table structure for table `simulator`
--

DROP TABLE IF EXISTS `simulator`;
CREATE TABLE IF NOT EXISTS `simulator` (
  `idsimulator` varchar(6) NOT NULL,
  `nama_simulator` varchar(45) NOT NULL,
  `letak` varchar(150) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  PRIMARY KEY (`idsimulator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simulator`
--

INSERT INTO `simulator` (`idsimulator`, `nama_simulator`, `letak`, `tahun`) VALUES
('S00001', 'ASTT', 'PULAU SUMATRA', '1998'),
('S00002', 'TTT', 'PULAU KALIMANTAN', '1987'),
('S00003', 'ANTP', 'PULAU JAWA', '1986'),
('S00004', 'VCT', 'PULAU SUMATRA', '1988'),
('S00005', 'IPMS', 'PULAU JAWA', '1999'),
('S00006', 'IPRCS', 'PULAU DANA', '1986'),
('S00007', 'NOPR', 'PULAU MIANGAS', '1988'),
('S00008', 'PIT', 'PULAU SUMATRA', '1978'),
('S00009', 'DPMS', 'PULAU JAWA', '1988'),
('S00010', 'TCMS', 'PULAU KALIMANTAN', '1998'),
('S00011', 'NFS', 'PULAU SUMATRA', '1999'),
('S00012', 'BRIDGE SIMULATOR', 'PULAU KALIMANTAN', '1998'),
('S00013', 'EPPKM', 'PULAU SUMATRA', '1998'),
('S00014', 'SEMENTARA', '-', '2022');

-- --------------------------------------------------------

--
-- Table structure for table `suratmasuk`
--

DROP TABLE IF EXISTS `suratmasuk`;
CREATE TABLE IF NOT EXISTS `suratmasuk` (
  `idsuratmasuk` varchar(6) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `idsimulator` varchar(6) NOT NULL,
  `tanggal` date NOT NULL,
  `nosurat` varchar(45) NOT NULL,
  `dari` varchar(65) NOT NULL,
  `perihal` varchar(65) NOT NULL,
  `keterangan` text,
  `mode` varchar(45) NOT NULL,
  PRIMARY KEY (`idsuratmasuk`),
  KEY `FK_suratmasuk_users` (`idusers`),
  KEY `FK_suratmasuk_simulator` (`idsimulator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suratmasuk`
--

INSERT INTO `suratmasuk` (`idsuratmasuk`, `idusers`, `idsimulator`, `tanggal`, `nosurat`, `dari`, `perihal`, `keterangan`, `mode`) VALUES
('S00001', 'U00001', 'S00011', '2022-09-06', 'se/43/2022', 'Danpuslatdiksarmil', 'LDD NFS 2022', '', 'Alat'),
('S00002', 'U00001', 'S00014', '2022-09-06', 'SE/345/2022', 'Danpusdiklek ', 'Latihan dikmaba angkatan 36', '-', 'Alat'),
('S00004', 'U00001', '', '2022-09-06', 'SE/1265/2022', 'Danpuslatdiksarmil', 'Dukungan instruktur ', '', 'Non Alat');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idusers` varchar(20) NOT NULL,
  `nrp` varchar(15) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `idrole` varchar(6) NOT NULL,
  `idkorps` varchar(6) NOT NULL,
  `idpangkat` varchar(6) NOT NULL,
  `foto` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idusers`),
  KEY `FK_users_role` (`idrole`),
  KEY `FK_users_korps` (`idkorps`),
  KEY `FK_users_pangkat` (`idpangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idusers`, `nrp`, `pass`, `nama`, `idrole`, `idkorps`, `idpangkat`, `foto`) VALUES
('U00001', 'ADMIN', 'aGtq', 'ADMIN', 'R00001', 'K00000', 'P00001', '1661131013_30bcbb4acbeb046fd4c1.png'),
('U00002', '96786', 'aGtq', 'Denis', 'R00007', 'K00018', 'P00016', ''),
('U00003', '98465', 'aGtq', 'Tukis Hariyanto', 'R00003', 'K00018', 'P00018', ''),
('U00004', '118386', 'aGtq', 'Gun Navyadi', 'R00002', 'K00021', 'P00020', ''),
('U00005', '119191', 'aGtq', 'Eric Juanto Rupang', 'R00006', 'K00009', 'P00020', ''),
('U00006', ' 119213', 'aGtq', 'Saeful Akbar', 'R00005', 'K00018', 'P00020', ''),
('U00007', '117543', 'aGtq', 'Mohammad Rizki', 'R00004', 'K00015', 'P00019', ''),
('U00008', '113234', 'aGtq', 'Dwi Sutarko', 'R00002', 'K00016', 'P00019', ''),
('U00009', '17276/P', 'aGtq', 'Rinto', 'R00002', 'K00002', 'P00013', ''),
('U00010', '16725/P', 'aGtq', 'DIKA', 'R00003', 'K00001', 'P00014', ''),
('U00011', '16098/P', 'aGtq', 'VALLY', 'R00004', 'K00002', 'P00013', ''),
('U00012', '18609/P', 'aGtq', 'KUKUH', 'R00005', 'K00004', 'P00014', ''),
('U00013', '16528/P', 'aGtq', 'GIRDA', 'R00006', 'K00007', 'P00014', ''),
('U00014', '14309/P', 'aGtq', 'NURDIYANTO', 'R00007', 'K00001', 'P00013', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `divisi`
--
ALTER TABLE `divisi`
  ADD CONSTRAINT `FK_divisi_department` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `osl`
--
ALTER TABLE `osl`
  ADD CONSTRAINT `FK_osl_suratmasuk` FOREIGN KEY (`idsuratmasuk`) REFERENCES `suratmasuk` (`idsuratmasuk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_osl_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `osp`
--
ALTER TABLE `osp`
  ADD CONSTRAINT `FK_operasional_simulator_pemanasan_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suratmasuk`
--
ALTER TABLE `suratmasuk`
  ADD CONSTRAINT `FK_suratmasuk_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_korps` FOREIGN KEY (`idkorps`) REFERENCES `korps` (`idkorps`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_pangkat` FOREIGN KEY (`idpangkat`) REFERENCES `pangkat` (`idpangkat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_role` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
