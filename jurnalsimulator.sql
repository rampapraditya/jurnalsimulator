-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 27, 2022 at 01:19 AM
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
('K00001', 'Puslatlekdalsen', 'Gladi Jalasena Yudha', 1984, 'Kolonel Laut (P) Irwan Sobirin', 'Morokrembangan, Kec. Krembangan, Kota SBY, Jawa Timur', '60178', '(031) 3284846', '-', 'https://kodiklatal.tnial.mil.id/', NULL, '1663068624_17ee45680c19480fb051.png', '-7.2238417', '112.7142937');

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

--
-- Dumping data for table `osl`
--

INSERT INTO `osl` (`idop_simulator`, `tanggal`, `kegiatan`, `waktu_on`, `waktu_off`, `kondisi`, `keterangan`, `foto`, `idusers`, `idsuratmasuk`) VALUES
('L00001', '2022-09-13', 'Pembelajaran siswa diktukpa elektronika', '18:51', '18:51', 'SAKIT', 'baik', '', 'U00001', 'S00001');

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
  `idsimulator` varchar(6) NOT NULL,
  PRIMARY KEY (`idop_simulator`),
  KEY `FK_operasional_simulator_pemanasan_users` (`idusers`),
  KEY `FK_osp_sim` (`idsimulator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='pemanasan';

--
-- Dumping data for table `osp`
--

INSERT INTO `osp` (`idop_simulator`, `tanggal`, `kegiatan`, `waktu_on`, `waktu_off`, `kondisi`, `keterangan`, `foto`, `idusers`, `idsimulator`) VALUES
('P00001', '2022-09-13', 'Pemanasan rutin hari senin', '08:00', '09:00', 'NORMAL', 'Simulator kondisi baik', '1663073807_5878aa1a7704cf27cf10.jpg', 'U00001', 'S00001'),
('P00002', '2022-09-12', 'Pemanasan rutin hari kamis', '20:28', '20:28', 'SAKIT', '', '', 'U00001', 'S00001');

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
('P00002', 'Laksamana TNI', 'MILITER'),
('P00003', 'Laksamana Madya TNI', 'MILITER'),
('P00004', 'Laksamana Muda TNI', 'MILITER'),
('P00005', 'Laksamana Pertama TNI', 'MILITER'),
('P00006', 'Kolonel', 'MILITER'),
('P00007', 'Letkol', 'MILITER'),
('P00008', 'Mayor', 'MILITER'),
('P00009', 'Kapten', 'MILITER'),
('P00010', 'Lettu', 'MILITER'),
('P00011', 'Letda', 'MILITER'),
('P00012', 'Peltu', 'MILITER'),
('P00013', 'Pelda', 'MILITER'),
('P00014', 'Serma', 'MILITER'),
('P00015', 'Serka', 'MILITER'),
('P00016', 'Sertu', 'MILITER'),
('P00017', 'Serda', 'MILITER'),
('P00018', 'Kopka', 'MILITER'),
('P00019', 'Koptu', 'MILITER'),
('P00020', 'Kopda', 'MILITER'),
('P00021', 'Klk', 'MILITER'),
('P00022', 'Kls', 'MILITER'),
('P00023', 'Kld', 'MILITER'),
('P00024', 'Pembina Utama Gol. IV/e', 'ASN'),
('P00025', 'Pembina Utama Muda Gol. IV/c', 'ASN'),
('P00026', 'Pembina Tk I Gol. IV/b', 'ASN'),
('P00027', 'Pembina Gol. IV/a', 'ASN'),
('P00028', 'Penata Tk I Gol. III/d', 'ASN'),
('P00029', 'Penata Gol. III/c', 'ASN'),
('P00030', 'Penda Tk I Gol. III/b', 'ASN'),
('P00031', 'Penda Gol. III/a', 'ASN'),
('P00032', 'Pengatur Tk I Gol. II/d', 'ASN'),
('P00033', 'Pengatur Gol. II/c', 'ASN'),
('P00034', 'Pengda Tk I Gol. II/b', 'ASN'),
('P00035', 'Pengda Gol. II/a', 'ASN'),
('P00036', 'Juru Tk I Gol. I/d', 'ASN'),
('P00037', 'Juru Gol. I/c', 'ASN'),
('P00038', 'Juru Muda Tk I Gol. I/b', 'ASN'),
('P00039', 'Juru Muda Gol. I/a', 'ASN');

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
('R00007', 'SET'),
('R00008', 'KOMANDAN'),
('R00009', 'WADAN'),
('R00010', 'PROGAR');

-- --------------------------------------------------------

--
-- Table structure for table `sakit`
--

DROP TABLE IF EXISTS `sakit`;
CREATE TABLE IF NOT EXISTS `sakit` (
  `idsakit` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `simulator` varchar(45) NOT NULL,
  `model` varchar(45) NOT NULL,
  `nama_barang` varchar(45) NOT NULL,
  `gejala` varchar(100) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `tanggal` date NOT NULL,
  `kd_rujukan` varchar(45) NOT NULL,
  PRIMARY KEY (`idsakit`),
  KEY `FK_sakit_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sakit`
--

INSERT INTO `sakit` (`idsakit`, `simulator`, `model`, `nama_barang`, `gejala`, `kegiatan`, `keterangan`, `foto`, `idusers`, `tanggal`, `kd_rujukan`) VALUES
('S00001', 'S00001', 'Pemanasan', 'tgl 13', '-', '-', '-', '1663140568_de10531bee014f4edc95.png', 'U00001', '2022-09-14', 'P00002');

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
('S00001', 'ASTT', '-', '0'),
('S00002', 'TTT', '-', '0'),
('S00003', 'ANTP', '-', '0'),
('S00004', 'VCT', '-', '0'),
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
('U00003', '13826/P', 'aGtq', 'Irwan Shobirin', 'R00008', 'K00001', 'P00006', ''),
('U00004', '13813/P', 'aGtq', 'Nurrozi, S.Kel', 'R00009', 'K00001', 'P00007', ''),
('U00005', '196612242001122', 'aGtq', 'Sundari', 'R00007', 'K00040', 'P00030', ''),
('U00006', '85631', 'aGtq', 'Mujito', 'R00007', 'K00027', 'P00015', ''),
('U00007', '20666/P', 'aGtq', 'Triana Indah Wati', 'R00010', 'K00007', 'P00009', ''),
('U00008', '104971', 'aGtq', 'Adhi Gatti Libeli', 'R00010', 'K00028', 'P00015', ''),
('U00009', '94900', 'aGtq', 'Moch. Arifin', 'R00010', 'K00028', 'P00016', ''),
('U00010', '16571/P', 'aGtq', 'Frejohn Da Costa', 'R00002', 'K00001', 'P00008', ''),
('U00011', '17134/P', 'aGtq', 'Provid Ariantoko, M.Tr.Opsla', 'R00002', 'K00001', 'P00008', ''),
('U00012', '71716', 'aGtq', 'Henny Rohmawati', 'R00002', 'K00023', 'P00012', ''),
('U00013', '112983', 'aGtq', 'Hendra Fujianto', 'R00002', 'K00011', 'P00017', ''),
('U00014', '83743', 'aGtq', 'Muliyadi', 'R00002', 'K00011', 'P00012', ''),
('U00015', '16039/P', 'aGtq', 'Putut Dwi Susanto', 'R00002', 'K00001', 'P00009', ''),
('U00016', '70505', 'aGtq', 'Saring', 'R00002', 'K00018', 'P00013', ''),
('U00017', '196802231992021', 'aGtq', 'Warseno', 'R00002', 'K00040', 'P00032', ''),
('U00018', '19150/P', 'aGtq', 'Steven Reginald L', 'R00002', 'K00001', 'P00008', ''),
('U00019', '85230', 'aGtq', 'Kaspuri', 'R00002', 'K00019', 'P00015', ''),
('U00020', '85227', 'aGtq', 'Triswanto', 'R00002', 'K00018', 'P00015', ''),
('U00021', '14361/P', 'aGtq', 'Sunu Turwasana', 'R00003', 'K00001', 'P00007', ''),
('U00022', '18661/P', 'aGtq', 'Salus Yustian Harin Prawidana', 'R00003', 'K00001', 'P00008', ''),
('U00023', '16805/P', 'aGtq', 'Urbani', 'R00003', 'K00001', 'P00008', ''),
('U00024', '19941/P', 'aGtq', 'Haruman Ari Alfaizal, S.,ST.,Han', 'R00003', 'K00001', 'P00009', ''),
('U00025', '73042', 'aGtq', 'Tukis Huriyanto', 'R00003', 'K00010', 'P00014', ''),
('U00026', '108118', 'aGtq', 'Arif Wahyudianto', 'R00003', 'K00013', 'P00014', ''),
('U00027', '67390', 'aGtq', 'Luky S Mulyono', 'R00003', 'K00010', 'P00013', ''),
('U00028', '83669', 'aGtq', 'Dennis Setiawan', 'R00003', 'K00009', 'P00012', ''),
('U00029', '89030', 'aGtq', 'Roni Setiyono', 'R00003', 'K00019', 'P00012', ''),
('U00030', '21288/P', 'aGtq', 'Roni Iskandar', 'R00003', 'K00001', 'P00010', ''),
('U00031', '86655', 'aGtq', 'Heri Santoso', 'R00003', 'K00037', 'P00012', ''),
('U00032', '115031', 'aGtq', '\'Yuli Asmoro Setiyawan', 'R00003', 'K00037', 'P00015', ''),
('U00033', '84392', 'aGtq', 'Albert Wilem Wanma', 'R00003', 'K00010', 'P00016', ''),
('U00034', '19978/P', 'aGtq', 'Dimas Wahyu Bramasta S, S.T.Han', 'R00003', 'K00001', 'P00009', ''),
('U00035', '80854', 'aGtq', 'Tri Sumardiyono', 'R00003', 'K00037', 'P00016', ''),
('U00036', '107531', 'aGtq', 'Ahmad Rifa\'i', 'R00003', 'K00043', 'P00019', ''),
('U00037', '79476', 'aGtq', 'Mansyur', 'R00003', 'K00018', 'P00012', ''),
('U00038', '21187', 'aGtq', 'Achmad Shokeh', 'R00003', 'K00001', 'P00010', ''),
('U00039', '70528', 'aGtq', 'M.  Makudi', 'R00003', 'K00019', 'P00013', ''),
('U00040', '75171', 'aGtq', 'Harsito', 'R00003', 'K00010', 'P00014', ''),
('U00041', '83758', 'aGtq', 'Veri Hari Nartaya', 'R00003', 'K00011', 'P00012', ''),
('U00042', '77444', 'aGtq', 'Malikin', 'R00003', 'K00010', 'P00014', ''),
('U00043', '84403', 'aGtq', 'Ahmad Sujito', 'R00003', 'K00010', 'P00018', ''),
('U00044', '88234', 'aGtq', 'Totok Sugiarto', 'R00003', 'K00037', 'P00018', ''),
('U00045', '84439', 'aGtq', 'Sri Budiono', 'R00003', 'K00018', 'P00016', ''),
('U00046', '85215', 'aGtq', 'Supriaji', 'R00003', 'K00018', 'P00015', ''),
('U00047', '76837', 'aGtq', 'Agus Sutono', 'R00003', 'K00019', 'P00014', ''),
('U00048', '17915/P', 'aGtq', 'Bambang Setiawan', 'R00003', 'K00002', 'P00008', ''),
('U00049', '82151', 'aGtq', 'Achmat Fauzi', 'R00003', 'K00029', 'P00012', ''),
('U00050', '80759', 'aGtq', 'Hadi Suwito', 'R00003', 'K00030', 'P00015', ''),
('U00051', '14900/P', 'aGtq', 'Mulyono, S.E.', 'R00006', 'K00001', 'P00007', ''),
('U00052', '17444/P', 'aGtq', 'Muan Sumantoyo', 'R00004', 'K00003', 'P00008', ''),
('U00053', '20561/P', 'aGtq', 'Nurdin. S.Psi', 'R00004', 'K00003', 'P00010', ''),
('U00054', '85470', 'aGtq', 'Mukhamad Furkon', 'R00004', 'K00029', 'P00015', ''),
('U00055', '96733', 'aGtq', 'Deni Dispitasasi', 'R00004', 'K00027', 'P00013', ''),
('U00056', '77503', 'aGtq', 'Hariyono', 'R00004', 'K00010', 'P00015', ''),
('U00057', '82266', 'aGtq', 'Warsono', 'R00004', 'K00037', 'P00012', ''),
('U00058', '80853', 'aGtq', 'Suharinta', 'R00004', 'K00013', 'P00015', ''),
('U00059', '115014', 'aGtq', 'Mohammad Zaenal Arifin', 'R00004', 'K00013', 'P00015', ''),
('U00060', '80832', 'aGtq', 'Gatot', 'R00004', 'K00013', 'P00015', ''),
('U00061', '196508221992021', 'aGtq', 'Muh. Yunus', 'R00004', 'K00040', 'P00030', ''),
('U00062', '197209241992011', 'aGtq', 'Soenoe Hudarianto,ST', 'R00004', 'K00040', 'P00028', ''),
('U00063', '72195', 'aGtq', 'Yusmanto', 'R00004', 'K00029', 'P00015', ''),
('U00064', '196911011998031', 'aGtq', 'Misdi', 'R00004', 'K00040', 'P00032', ''),
('U00065', '196709201989031', 'aGtq', 'Pardi', 'R00004', 'K00040', 'P00033', ''),
('U00066', '75261', 'aGtq', 'Kuntoro', 'R00004', 'K00018', 'P00014', ''),
('U00067', '85161', 'aGtq', 'Nur Astiyan', 'R00004', 'K00009', 'P00016', ''),
('U00068', '89635', 'aGtq', 'Arif Sukariyanto', 'R00004', 'K00009', 'P00016', ''),
('U00069', '81671', 'aGtq', 'Yans Satya Jaya', 'R00004', 'K00022', 'P00015', ''),
('U00070', '15268/P', 'aGtq', 'Sarismanto, S. Pd', 'R00004', 'K00003', 'P00008', ''),
('U00071', '196601121992011', 'aGtq', 'Aminin', 'R00004', 'K00040', 'P00032', ''),
('U00072', '21632/P', 'aGtq', 'Murjoko', 'R00004', 'K00002', 'P00010', ''),
('U00073', '77662', 'aGtq', 'Agung Buntarso', 'R00004', 'K00029', 'P00016', ''),
('U00074', '85548', 'aGtq', 'Edy Purwanto', 'R00004', 'K00030', 'P00018', ''),
('U00075', '78921', 'aGtq', 'Toto  Suseno', 'R00004', 'K00029', 'P00015', ''),
('U00076', '196810031993031', 'aGtq', 'Sugiyatno', 'R00004', 'K00040', 'P00033', ''),
('U00077', '81618', 'aGtq', 'Sutrisno', 'R00004', 'K00030', 'P00015', ''),
('U00078', '89169', 'aGtq', 'Wahyudi', 'R00004', 'K00029', 'P00012', ''),
('U00079', '104971', 'aGtq', 'Pujiyana', 'R00004', 'K00043', 'P00014', ''),
('U00080', '15856/P', 'aGtq', 'Akhmad Nur, S.E.', 'R00005', 'K00003', 'P00008', ''),
('U00081', '80453', 'aGtq', 'Winarto', 'R00005', 'K00011', 'P00015', ''),
('U00082', '17929/P', 'aGtq', 'Puji Wahono', 'R00005', 'K00002', 'P00008', ''),
('U00083', '196910161992021', 'aGtq', 'Siswadi', 'R00005', 'K00040', 'P00030', ''),
('U00084', '98563', 'aGtq', 'Agung Kurniawan,Amd', 'R00005', 'K00037', 'P00013', ''),
('U00085', '66785', 'aGtq', 'Ibrahim', 'R00005', 'K00028', 'P00012', ''),
('U00086', '79949', 'aGtq', 'Khoirul Ibad', 'R00005', 'K00028', 'P00012', ''),
('U00087', '80746', 'aGtq', 'Yudi Ariyanto', 'R00005', 'K00029', 'P00015', ''),
('U00088', '81532', 'aGtq', 'Jaimun', 'R00002', 'K00011', 'P00017', '');

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
  ADD CONSTRAINT `FK_operasional_simulator_pemanasan_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_osp_sim` FOREIGN KEY (`idsimulator`) REFERENCES `simulator` (`idsimulator`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sakit`
--
ALTER TABLE `sakit`
  ADD CONSTRAINT `FK_sakit_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

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
