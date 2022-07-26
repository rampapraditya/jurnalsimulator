-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2022 at 01:24 AM
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
('D00013', 'HARFASBAN', 'R00004'),
('D00015', 'PIT', 'R00003'),
('D00016', 'TFG', 'R00003'),
('D00018', 'PERS', 'R00005'),
('D00019', 'MATBEK', 'R00005');

-- --------------------------------------------------------

--
-- Table structure for table `harwat_harsis`
--

DROP TABLE IF EXISTS `harwat_harsis`;
CREATE TABLE IF NOT EXISTS `harwat_harsis` (
  `idharwat_harsis` varchar(6) NOT NULL,
  `idsakit_harsis` varchar(6) NOT NULL,
  `tanggal` date NOT NULL,
  `kegiatan` varchar(150) DEFAULT NULL,
  `pelaksanaan` varchar(150) DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `ver` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`idharwat_harsis`),
  KEY `FK_harwat_harsis_users` (`idusers`),
  KEY `FK_harwat_harsis_sakit` (`idsakit_harsis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `harwat_harsis`
--

INSERT INTO `harwat_harsis` (`idharwat_harsis`, `idsakit_harsis`, `tanggal`, `kegiatan`, `pelaksanaan`, `keterangan`, `idusers`, `ver`) VALUES
('H00001', 'H00001', '2022-12-06', 'Pembongkaran rumah Trackball', 'Harsis', 'Normal', 'U00092', 1);

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
-- Table structure for table `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE IF NOT EXISTS `jabatan` (
  `idjabatan` varchar(6) NOT NULL,
  `nama_jabatan` varchar(45) NOT NULL,
  PRIMARY KEY (`idjabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`idjabatan`, `nama_jabatan`) VALUES
('J00001', 'Danpuslatlekdalsen'),
('J00002', 'Wadan Puslatlekdalsen'),
('J00003', 'Kaset '),
('J00004', 'Arsiparis Mahir'),
('J00005', 'Ur Tu'),
('J00006', 'Caraka'),
('J00007', 'Ur Lam'),
('J00008', 'Bama'),
('J00009', 'Baprov'),
('J00010', 'Pengemudi'),
('J00011', 'Kaur Progar'),
('J00012', 'Paur Ren'),
('J00013', 'Ur Gar'),
('J00014', 'Ur Yartap'),
('J00015', 'Ur Coklit'),
('J00016', 'Kadep Renlat'),
('J00017', 'Kadiv Renopslat'),
('J00018', 'Ur Renopslat'),
('J00019', 'Ur Binlat'),
('J00020', 'Ur Kom'),
('J00021', 'Ur Data'),
('J00022', 'Kadiv Evalat'),
('J00023', 'Ur Evalat'),
('J00024', 'Ur Min Data Evalat'),
('J00025', 'Kadiv Skenlat'),
('J00026', 'Ur Skenlat'),
('J00027', 'Ur Prod Skenlat'),
('J00028', 'Ur. Arsip Skenlat'),
('J00029', 'Kadep Opslat'),
('J00030', 'Kadiv Astt'),
('J00031', 'Kadiv Pau Astt'),
('J00032', 'Pa Pep Pernika Astt'),
('J00033', 'Pa Pep Anti Udara'),
('J00034', 'Kadiv Pak Astt'),
('J00035', 'Pa Pep Akpa Astt'),
('J00036', 'Pa. Pep Aks/Rju Astt'),
('J00037', 'Kadiv Controller Astt'),
('J00038', 'Pa. Controler 1'),
('J00039', 'Pa. Controler 2'),
('J00040', 'Padiv Cubicle ASTT'),
('J00041', 'Ur  Cibicle 1'),
('J00042', 'Ur Cubicle 2'),
('J00043', 'Ur Cubicle 3'),
('J00044', 'Ur Cubicle 4'),
('J00045', 'Ur Cubicle 5'),
('J00046', 'Ur Cubicle 6'),
('J00047', 'Ur Cubicle 7'),
('J00048', 'Ur Cubicle 8'),
('J00049', 'Ur Cubicle 9'),
('J00050', 'Ur Cubicle 10'),
('J00051', 'Padiv Server'),
('J00052', 'Ur Server 1'),
('J00053', 'Ur Server 2'),
('J00054', 'Ur Controler 1'),
('J00055', 'Ur Controler 2'),
('J00056', 'Kadiv CTT'),
('J00057', 'Kadiv PIT'),
('J00058', 'Pa Sen/Art'),
('J00059', 'Ur WCC 1'),
('J00060', 'Ur WCC 2'),
('J00061', 'Ur TDC 1'),
('J00062', 'Ur TDC 2'),
('J00063', 'Ur MOC'),
('J00064', 'Pa Sen / Sba'),
('J00065', 'Ur Sonar'),
('J00066', 'Ur Simulator Sonar'),
('J00067', 'Ur MPO '),
('J00068', 'Padiv Navkom'),
('J00069', 'Ur Nav'),
('J00070', 'Ur Pit / Dir'),
('J00071', 'Ur Pernav 1'),
('J00072', 'Ur Pernav 2'),
('J00073', 'Ur Navtrainer 1'),
('J00074', 'Ur Navtrainer 2'),
('J00075', 'Ur Navtrainer 3'),
('J00076', 'Ur Kom 1'),
('J00077', 'Ur Kom 2'),
('J00078', 'Kadiv Tfg'),
('J00079', 'Padiv Proglat'),
('J00080', 'Padiv Dallat'),
('J00081', 'Ur Kontroler 1'),
('J00082', 'Ur Kontroler 2'),
('J00083', 'Ur Komputer 1'),
('J00084', 'Ur Komputer 2'),
('J00085', 'Ur Komputer 3'),
('J00086', 'Ur Komputer 4'),
('J00087', 'Ur Komputer 5'),
('J00088', 'Ur Komputer 6'),
('J00089', 'Ur Komputer 7'),
('J00090', 'Ur Komputer 8'),
('J00091', 'Ur Komputer 9'),
('J00092', 'Kadiv Scc'),
('J00093', 'Padiv Lat Scc'),
('J00094', 'Ur Lat Nbcd'),
('J00095', 'Ur Lat Irpcs'),
('J00096', 'Ur Lat Pendorong'),
('J00097', 'Ur Lat Auxiliary'),
('J00098', 'Kadep Uji Puanpur'),
('J00099', 'Kadiv Pau '),
('J00100', 'Kadiv Pak/Pernika'),
('J00101', 'Kadep Dukopslat'),
('J00102', 'Kadiv Pskt'),
('J00103', 'Padiv Bangsis Pskt'),
('J00104', 'Paur Program '),
('J00105', 'Ur Programer 1'),
('J00106', 'Ur Programer 2'),
('J00107', 'Ur.Komputer Pskt'),
('J00108', 'Ur. Lahta Pskt'),
('J00109', 'Kadiv Harsis'),
('J00110', 'Padiv Har Ctt'),
('J00111', 'Ur Har Sensor '),
('J00112', 'Ur Har DA – 05'),
('J00113', 'Ur Har WM-28'),
('J00114', 'Ur Har PHS-32'),
('J00115', 'Padiv Har Scc'),
('J00116', 'Ur Har Panel Scc'),
('J00117', 'Ur Har IRPCS'),
('J00118', 'Ur Harsim Turbin '),
('J00119', 'Ur Har Panel Dg Listrik'),
('J00120', 'Ur Har Lab Mekanik'),
('J00121', 'Padiv Har Astt'),
('J00122', 'Ur Piras'),
('J00123', 'Ur Pinak'),
('J00124', 'Padiv Har Pskt'),
('J00125', 'Ur Har Komputer'),
('J00126', 'Padiv Har Tfg'),
('J00127', 'Ur Piras Tfg'),
('J00128', 'Ur Pinak Tfg'),
('J00129', 'Ur Projektor/Sound Systm'),
('J00130', 'Kadiv Harfasban'),
('J00131', 'Padiv Pendingin'),
('J00132', 'Ur Ac Sentral Fth,Nla1'),
('J00133', 'Ur Ac Sentral Fth,Nla2'),
('J00134', 'Ur Ac Spilit Fth,Mlh1'),
('J00135', 'Ur Ac Spilit Fth,Mlh2'),
('J00136', 'Ur Har 1'),
('J00137', 'Ur Har 2'),
('J00138', 'Paur Catu Daya'),
('J00139', 'Ur Converter'),
('J00140', 'Ur Panel Pokok '),
('J00141', 'Paur Listrik'),
('J00142', 'Ur Jarged'),
('J00143', 'Ur Ups'),
('J00144', 'Ur Dg 1'),
('J00145', 'Ur Dg 2'),
('J00146', 'Ur Logca'),
('J00147', 'Ur Distribusi'),
('J00148', 'Kadep Minlog'),
('J00149', 'Kadiv Pers'),
('J00150', 'Kaur Minpers'),
('J00151', 'Ur Darkarmil /Sip'),
('J00152', 'Ur Datamil/Sip'),
('J00153', 'Ur Watpers'),
('J00154', 'Ur Yanpers'),
('J00155', 'Ur. Jasrek'),
('J00156', 'Kadiv Matbek'),
('J00157', 'Ur Administrasi'),
('J00158', 'Ur Verifikasi'),
('J00159', 'Ur Mat'),
('J00160', 'Ur Bek'),
('J00161', 'Ur. Matfasbek'),
('J00162', 'Ur Beklogca'),
('J00163', 'Paur Alins/Alongins'),
('J00164', 'Paur Bek Alins/Alongins'),
('J00165', 'Ur Min Alins'),
('J00166', 'Ur Kom');

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
  `ver` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`idop_simulator`),
  KEY `FK_osl_users` (`idusers`),
  KEY `FK_osl_suratmasuk` (`idsuratmasuk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latihan';

--
-- Dumping data for table `osl`
--

INSERT INTO `osl` (`idop_simulator`, `tanggal`, `kegiatan`, `waktu_on`, `waktu_off`, `kondisi`, `keterangan`, `foto`, `idusers`, `idsuratmasuk`, `ver`) VALUES
('L00001', '2022-11-24', 'Latihan tim anjungan', '08:00', '10:00', 'NORMAL', '', '1669259489_0f2df0122e630c090283.jpg', 'U00001', 'S00001', 1),
('L00002', '2022-11-04', 'Lattek siswa Pusdiklapa', '08:00', '16:00', 'SAKIT', '', '1669259791_e594beb2a71d381073f9.jpg', 'U00001', 'S00001', 0);

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
  `ver` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`idop_simulator`),
  KEY `FK_operasional_simulator_pemanasan_users` (`idusers`),
  KEY `FK_osp_sim` (`idsimulator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='pemanasan';

--
-- Dumping data for table `osp`
--

INSERT INTO `osp` (`idop_simulator`, `tanggal`, `kegiatan`, `waktu_on`, `waktu_off`, `kondisi`, `keterangan`, `foto`, `idusers`, `idsimulator`, `ver`) VALUES
('P00001', '2022-11-07', 'Pemanasan rutin senin', '08:00', '10:00', 'SAKIT', 'Trackball rusak tidak bisa digerakkan kursornya', '1669261538_b0015e4e477854f8714a.jpg', 'U00001', 'S00003', 1);

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
('R00002', 'DEPRENLAT'),
('R00003', 'DEPOPSLAT'),
('R00004', 'DEPDUKOPSLAT'),
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
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `tanggal` date NOT NULL,
  `kd_rujukan` varchar(45) NOT NULL,
  `ver` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`idsakit`),
  KEY `FK_sakit_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sakit`
--

INSERT INTO `sakit` (`idsakit`, `simulator`, `model`, `idusers`, `tanggal`, `kd_rujukan`, `ver`) VALUES
('S00001', 'S00001', 'Latihan', 'U00025', '2022-11-07', 'L00003', 1),
('S00002', 'S00009', 'Sakit', 'U00091', '2022-12-04', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sakit_detil`
--

DROP TABLE IF EXISTS `sakit_detil`;
CREATE TABLE IF NOT EXISTS `sakit_detil` (
  `idsakit_detil` varchar(6) NOT NULL,
  `idsakit` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `nama_barang` varchar(45) NOT NULL,
  `gejala` varchar(100) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `foto` varchar(150) NOT NULL,
  PRIMARY KEY (`idsakit_detil`),
  KEY `FK_sakit_detil_key` (`idsakit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sakit_detil`
--

INSERT INTO `sakit_detil` (`idsakit_detil`, `idsakit`, `nama_barang`, `gejala`, `kegiatan`, `keterangan`, `foto`) VALUES
('D00001', 'S00001', 'Trackball', 'Error tidak bisa digerakkan kursornya', 'Pembersihan trackball dan rumah trackball', 'Masih belum bisa digunakan', '1669261744_5800bf7e280b6fb8c82c.jpg'),
('D00002', 'S00001', 'ashh', 'simulator sakit tidak bisa digerakkan karna kondisi power tidak memadai', 'pembersihan simulator dari mopnitor, cpu dan kabel kabel yang ada di simultor', '', ''),
('D00003', 'S00002', 'layar monitor', 'sakit blue screen', 'install ulang', 'ahdgd', '');

-- --------------------------------------------------------

--
-- Table structure for table `sakit_harsis`
--

DROP TABLE IF EXISTS `sakit_harsis`;
CREATE TABLE IF NOT EXISTS `sakit_harsis` (
  `idsakit_harsis` varchar(6) NOT NULL,
  `tanggal` date NOT NULL,
  `idsakit` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `kerusakan` varchar(150) NOT NULL,
  `tindakan` varchar(150) NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `ver` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`idsakit_harsis`),
  KEY `FK_sakit_harsis_users` (`idusers`),
  KEY `FK_sakit_harsis_sakit` (`idsakit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sakit_harsis`
--

INSERT INTO `sakit_harsis` (`idsakit_harsis`, `tanggal`, `idsakit`, `kerusakan`, `tindakan`, `keterangan`, `foto`, `idusers`, `ver`) VALUES
('H00001', '2022-12-06', 'S00001', 'Trackball error tidak bisa digerakkan', 'Pembersihan Trackball', 'Kondisi masih belum bisa digerakkan', '', 'U00092', 1);

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
('S00001', 'ASTT', 'PULAU SUMATRA', '2004'),
('S00002', 'TTT', 'PULAU SUMATRA', '2011'),
('S00003', 'ATNP', 'PULAU SUMATRA', '2013'),
('S00004', 'VCT', 'PULAU SUMATRA', '2013'),
('S00005', 'IPMS', 'PULAU SUMATRA', '2013'),
('S00007', 'NOPR', 'PULAU KALIMANTAN', '2016'),
('S00008', 'PIT', 'YOS SUDARSO', '1978'),
('S00009', 'DPMS', 'YOS SUDARSO', '2010'),
('S00010', 'TCMS', 'YOS SUDARSO', '2013'),
('S00011', 'NFS', 'YOS SUDARSO', '2011'),
('S00012', 'BRIDGE SIMULATOR', 'PULAU KALIMANTAN', '1998'),
('S00013', 'EPPKM', 'PULAU KALIMANTAN', '2017'),
('S00014', 'SEMENTARA', '-', '2022'),
('S00015', 'SCC', 'PULAU SUMATRA', '1983');

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
  `ver` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`idsuratmasuk`),
  KEY `FK_suratmasuk_users` (`idusers`),
  KEY `FK_suratmasuk_simulator` (`idsimulator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suratmasuk`
--

INSERT INTO `suratmasuk` (`idsuratmasuk`, `idusers`, `idsimulator`, `tanggal`, `nosurat`, `dari`, `perihal`, `keterangan`, `mode`, `ver`) VALUES
('S00001', 'U00001', 'S00012', '2022-11-01', 'B/352/XI/2022', 'Dankodiklatal', 'Kegiatan Latihan tim anjungan puslatlekdalsen tanggal 5-10 Novemb', '', 'Alat', 1),
('S00002', 'U00001', 'S00001', '2022-11-02', 'B/239/XI/2022', 'Danpusdiklapa', 'Dukungan personel dan lattek ASTT tanggal 4-5 November 2022', '', 'Alat', 1),
('S00003', 'U00016', 'S00008', '2022-12-01', 'B/011/XII/2022', 'Dankodikopsla', 'Lattek siswa Dikmata pengenalan alat PIT tanggal 3 Desember 2022', '-', 'Alat', 1);

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
  `iddivisi` varchar(6) DEFAULT NULL,
  `idjabatan` varchar(6) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `fcm` varchar(150) NOT NULL,
  PRIMARY KEY (`idusers`),
  KEY `FK_users_role` (`idrole`),
  KEY `FK_users_korps` (`idkorps`),
  KEY `FK_users_pangkat` (`idpangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idusers`, `nrp`, `pass`, `nama`, `idrole`, `idkorps`, `idpangkat`, `foto`, `iddivisi`, `idjabatan`, `email`, `fcm`) VALUES
('U00001', 'ADMIN', 'aGtq', 'ADMIN', 'R00001', 'K00000', 'P00001', '1661131013_30bcbb4acbeb046fd4c1.png', '-', '-', 'muflikhunn1@gmail.com', ''),
('U00003', '13826/P', 'aGtq', 'Irwan Shobirin', 'R00008', 'K00001', 'P00006', '', NULL, 'J00001', '', ''),
('U00004', '13813/P', 'aGtq', 'Nurrozi, S.Kel', 'R00009', 'K00001', 'P00007', '', NULL, 'J00002', '', ''),
('U00005', '196612242001122', 'aGtq', 'Sundari', 'R00007', 'K00040', 'P00030', '', '-', 'J00004', '', ''),
('U00006', '85631', 'aGtq', 'Mujito', 'R00007', 'K00027', 'P00015', '', NULL, 'J00005', '', ''),
('U00007', '20666/P', 'aGtq', 'Triana Indah Wati', 'R00010', 'K00007', 'P00009', '', NULL, 'J00011', '', ''),
('U00008', '104971', 'aGtq', 'Adhi Gatti Libeli', 'R00010', 'K00028', 'P00015', '', NULL, 'J00013', '', ''),
('U00009', '94900', 'aGtq', 'Moch. Arifin', 'R00010', 'K00028', 'P00016', '', NULL, 'J00014', '', ''),
('U00010', '16571/P', 'aGtq', 'Frejohn Da Costa', 'R00002', 'K00001', 'P00008', 'U000101665303183220.png', '-', 'J00016', '', ''),
('U00011', '17134/P', 'aGtq', 'Provid Ariantoko, M.Tr.Opsla', 'R00002', 'K00001', 'P00008', '', 'D00001', 'J00017', '', ''),
('U00012', '71716', 'aGtq', 'Henny Rohmawati', 'R00002', 'K00023', 'P00012', '', 'D00001', 'J00018', '', ''),
('U00013', '112983', 'aGtq', 'Hendra Fujianto', 'R00002', 'K00011', 'P00017', '', 'D00001', 'J00020', '', ''),
('U00014', '83743', 'aGtq', 'Muliyadi', 'R00002', 'K00011', 'P00012', '', 'D00001', 'J00021', '', ''),
('U00015', '16039/P', 'aGtq', 'Putut Dwi Susanto', 'R00002', 'K00001', 'P00009', '', 'D00002', 'J00022', '', ''),
('U00016', '70505', 'aGtq', 'Saring', 'R00002', 'K00018', 'P00013', '', 'D00002', 'J00023', '', ''),
('U00017', '196802231992021', 'aGtq', 'Warseno', 'R00002', 'K00040', 'P00032', '', 'D00002', 'J00024', '', ''),
('U00018', '19150/P', 'aGtq', 'Steven Reginald L', 'R00002', 'K00001', 'P00008', '', 'D00003', 'J00025', '', ''),
('U00019', '85230', 'aGtq', 'Kaspuri', 'R00002', 'K00019', 'P00015', '', 'D00003', 'J00027', '', ''),
('U00020', '85227', 'aGtq', 'Triswanto', 'R00002', 'K00018', 'P00015', '', 'D00003', 'J00028', '', ''),
('U00021', '14361/P', 'aGtq', 'Sunu Turwasana', 'R00003', 'K00001', 'P00007', '', NULL, 'J00029', '', ''),
('U00022', '18661/P', 'aGtq', 'Salus Yustian Harin Prawidana', 'R00003', 'K00001', 'P00008', '', 'D00005', 'J00031', '', ''),
('U00023', '16805/P', 'aGtq', 'Urbani', 'R00003', 'K00001', 'P00008', '', 'D00005', 'J00034', '', ''),
('U00024', '19941/P', 'aGtq', 'Haruman Ari Alfaizal, S.,ST.,Han', 'R00003', 'K00001', 'P00009', '', 'D00005', 'J00035', '', ''),
('U00025', '73042', 'aGtq', 'Tukis Huriyanto', 'R00003', 'K00010', 'P00014', '', 'D00005', 'J00041', '', ''),
('U00026', '108118', 'aGtq', 'Arif Wahyudianto', 'R00003', 'K00013', 'P00014', '', 'D00005', 'J00042', '', ''),
('U00027', '67390', 'aGtq', 'Luky S Mulyono', 'R00003', 'K00010', 'P00013', '', 'D00005', 'J00045', '', ''),
('U00028', '83669', 'aGtq', 'Dennis Setiawan', 'R00003', 'K00009', 'P00012', '', 'D00005', 'J00046', '', ''),
('U00029', '89030', 'aGtq', 'Roni Setiyono', 'R00003', 'K00019', 'P00012', '', 'D00005', 'J00047', '', ''),
('U00030', '21288/P', 'aGtq', 'Roni Iskandar', 'R00003', 'K00001', 'P00010', '', 'D00005', 'J00051', '', ''),
('U00031', '86655', 'aGtq', 'Heri Santoso', 'R00003', 'K00037', 'P00012', '', 'D00005', 'J00052', '', ''),
('U00032', '115031', 'aGtq', '\'Yuli Asmoro Setiyawan', 'R00003', 'K00037', 'P00015', '', 'D00005', 'J00053', '', ''),
('U00033', '84392', 'aGtq', 'Albert Wilem Wanma', 'R00003', 'K00010', 'P00016', '', 'D00005', 'J00055', '', ''),
('U00034', '19978/P', 'aGtq', 'Dimas Wahyu Bramasta S, S.T.Han', 'R00003', 'K00001', 'P00009', '', 'D00015', 'J00058', '', ''),
('U00035', '80854', 'aGtq', 'Tri Sumardiyono', 'R00003', 'K00037', 'P00016', '', 'D00015', 'J00061', '', ''),
('U00036', '107531', 'aGtq', 'Ahmad Rifa\'i', 'R00003', 'K00043', 'P00019', '', 'D00015', 'J00062', '', ''),
('U00037', '79476', 'aGtq', 'Mansyur', 'R00003', 'K00018', 'P00012', '', 'D00015', 'J00063', '', ''),
('U00038', '21187', 'aGtq', 'Achmad Shokeh', 'R00003', 'K00001', 'P00010', '', 'D00015', 'J00064', '', ''),
('U00039', '70528', 'aGtq', 'M.  Makudi', 'R00003', 'K00019', 'P00013', '', 'D00015', 'J00065', '', ''),
('U00040', '75171', 'aGtq', 'Harsito', 'R00003', 'K00010', 'P00014', '', 'D00015', 'J00067', '', ''),
('U00041', '83758', 'aGtq', 'Veri Hari Nartaya', 'R00003', 'K00011', 'P00012', '', 'D00015', 'J00070', '', ''),
('U00042', '77444', 'aGtq', 'Malikin', 'R00003', 'K00010', 'P00014', '', 'D00015', 'J00071', '', ''),
('U00043', '84403', 'aGtq', 'Ahmad Sujito', 'R00003', 'K00010', 'P00018', '', 'D00015', 'J00072', '', ''),
('U00044', '88234', 'aGtq', 'Totok Sugiarto', 'R00003', 'K00037', 'P00018', '', 'D00016', 'J00085', '', ''),
('U00045', '84439', 'aGtq', 'Sri Budiono', 'R00003', 'K00018', 'P00016', '', 'D00016', 'J00086', '', ''),
('U00046', '85215', 'aGtq', 'Supriaji', 'R00003', 'K00018', 'P00015', '', 'D00016', 'J00087', '', ''),
('U00047', '76837', 'aGtq', 'Agus Sutono', 'R00003', 'K00019', 'P00014', '', 'D00016', 'J00091', '', ''),
('U00048', '17915/P', 'aGtq', 'Bambang Setiawan', 'R00003', 'K00002', 'P00008', '', 'D00008', 'J00092', '', ''),
('U00049', '82151', 'aGtq', 'Achmat Fauzi', 'R00003', 'K00029', 'P00012', '', 'D00008', 'J00096', '', ''),
('U00050', '80759', 'aGtq', 'Hadi Suwito', 'R00003', 'K00030', 'P00015', '', 'D00008', 'J00097', '', ''),
('U00051', '14900/P', 'aGtq', 'Mulyono, S.E.', 'R00006', 'K00001', 'P00007', '', NULL, 'J00098', '', ''),
('U00052', '17444/P', 'aGtq', 'Muan Sumantoyo', 'R00004', 'K00003', 'P00008', '', 'D00011', 'J00102', '', ''),
('U00053', '20561/P', 'aGtq', 'Nurdin. S.Psi', 'R00004', 'K00003', 'P00010', '', 'D00011', 'J00104', '', ''),
('U00054', '85470', 'aGtq', 'Mukhamad Furkon', 'R00004', 'K00029', 'P00015', '', 'D00011', 'J00105', '', ''),
('U00055', '96733', 'aGtq', 'Deni Dispitasasi', 'R00004', 'K00027', 'P00013', '', 'D00011', 'J00106', '', ''),
('U00056', '77503', 'aGtq', 'Hariyono', 'R00004', 'K00010', 'P00015', '', 'D00011', 'J00108', '', ''),
('U00057', '82266', 'aGtq', 'Warsono', 'R00004', 'K00037', 'P00012', '', 'D00012', 'J00111', '', ''),
('U00058', '80853', 'aGtq', 'Suharinta', 'R00004', 'K00013', 'P00015', '', 'D00012', 'J00112', '', ''),
('U00059', '115014', 'aGtq', 'Mohammad Zaenal Arifin', 'R00004', 'K00013', 'P00015', '', 'D00012', 'J00113', '', ''),
('U00060', '80832', 'aGtq', 'Gatot', 'R00004', 'K00013', 'P00015', '', 'D00012', 'J00114', '', ''),
('U00061', '196508221992021', 'aGtq', 'Muh. Yunus', 'R00004', 'K00040', 'P00030', '', 'D00012', 'J00116', '', ''),
('U00062', '197209241992011', 'aGtq', 'Soenoe Hudarianto,ST', 'R00004', 'K00040', 'P00028', '', 'D00012', 'J00117', '', ''),
('U00063', '72195', 'aGtq', 'Yusmanto', 'R00004', 'K00029', 'P00015', '', 'D00012', 'J00118', '', ''),
('U00064', '196911011998031', 'aGtq', 'Misdi', 'R00004', 'K00040', 'P00032', '', 'D00012', 'J00119', '', ''),
('U00065', '196709201989031', 'aGtq', 'Pardi', 'R00004', 'K00040', 'P00033', '', 'D00012', 'J00120', '', ''),
('U00066', '75261', 'aGtq', 'Kuntoro', 'R00004', 'K00018', 'P00014', '', 'D00012', 'J00125', '', ''),
('U00067', '85161', 'aGtq', 'Nur Astiyan', 'R00004', 'K00009', 'P00016', '', 'D00012', 'J00122', '', ''),
('U00068', '89635', 'aGtq', 'Arif Sukariyanto', 'R00004', 'K00009', 'P00016', '', 'D00012', 'J00123', '', ''),
('U00069', '81671', 'aGtq', 'Yans Satya Jaya', 'R00004', 'K00022', 'P00015', '', 'D00012', 'J00129', '', ''),
('U00070', '15268/P', 'aGtq', 'Sarismanto, S. Pd', 'R00004', 'K00003', 'P00008', '', 'D00013', 'J00130', '', ''),
('U00071', '196601121992011', 'aGtq', 'Aminin', 'R00004', 'K00040', 'P00032', '', 'D00013', 'J00134', '', ''),
('U00072', '21632/P', 'aGtq', 'Murjoko', 'R00004', 'K00002', 'P00010', '', 'D00013', 'J00138', '', ''),
('U00073', '77662', 'aGtq', 'Agung Buntarso', 'R00004', 'K00029', 'P00016', '', 'D00013', 'J00139', '', ''),
('U00074', '85548', 'aGtq', 'Edy Purwanto', 'R00004', 'K00030', 'P00018', '', 'D00013', 'J00140', '', ''),
('U00075', '78921', 'aGtq', 'Toto  Suseno', 'R00004', 'K00029', 'P00015', '', 'D00013', 'J00142', '', ''),
('U00076', '196810031993031', 'aGtq', 'Sugiyatno', 'R00004', 'K00040', 'P00033', '', 'D00013', 'J00143', '', ''),
('U00077', '81618', 'aGtq', 'Sutrisno', 'R00004', 'K00030', 'P00015', '', 'D00013', 'J00144', '', ''),
('U00078', '89169', 'aGtq', 'Wahyudi', 'R00004', 'K00029', 'P00012', '', 'D00013', 'J00145', '', ''),
('U00079', '104971', 'aGtq', 'Pujiyana', 'R00004', 'K00043', 'P00014', '', 'D00013', 'J00146', '', ''),
('U00080', '15856/P', 'aGtq', 'Akhmad Nur, S.E.', 'R00005', 'K00003', 'P00008', '', 'D00018', 'J00149', '', ''),
('U00081', '80453', 'aGtq', 'Winarto', 'R00005', 'K00011', 'P00015', '', 'D00018', 'J00152', '', ''),
('U00082', '17929/P', 'aGtq', 'Puji Wahono', 'R00005', 'K00002', 'P00008', '', 'D00019', 'J00156', '', ''),
('U00083', '196910161992021', 'aGtq', 'Siswadi', 'R00005', 'K00040', 'P00030', '', 'D00019', 'J00157', '', ''),
('U00084', '98563', 'aGtq', 'Agung Kurniawan,Amd', 'R00005', 'K00037', 'P00013', '', 'D00019', 'J00158', '', ''),
('U00085', '66785', 'aGtq', 'Ibrahim', 'R00005', 'K00028', 'P00012', '', 'D00019', 'J00159', '', ''),
('U00086', '79949', 'aGtq', 'Khoirul Ibad', 'R00005', 'K00028', 'P00012', '', 'D00019', 'J00160', '', ''),
('U00087', '80746', 'aGtq', 'Yudi Ariyanto', 'R00005', 'K00029', 'P00015', '', 'D00019', 'J00162', '', ''),
('U00088', '81532', 'aGtq', 'Jaimun', 'R00002', 'K00011', 'P00017', '', 'D00003', 'J00166', '', ''),
('U00089', '117271', 'aGtq', 'Muflikhun Najib', 'R00003', 'K00019', 'P00015', '', 'D00005', 'J00066', 'muflikhunn1@gmail.com', ''),
('U00090', '111', 'aGtq', '111', 'R00002', 'K00014', 'P00018', '', '-', '-', '123', 'fOB5DjTz3F0:APA91bGMdIITwR0x88_sCIXJ2ohFX3RLr0TLJpaZnWcTppTSYDW_B_jF-jDRvsFA8ZwSlh1wqg_vg4u0SvM62kr_tYAak-Crc_5twWWyT_SfP39Cb1oLoVXpLyXPH_ibIWSSEyG5EA'),
('U00091', '222', 'aGtq', '222', 'R00003', 'K00016', 'P00013', '', '-', '-', '123', ''),
('U00092', '333', 'aGtq', '333', 'R00004', 'K00015', 'P00018', '', '-', '-', '123', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `divisi`
--
ALTER TABLE `divisi`
  ADD CONSTRAINT `FK_divisi_department` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `harwat_harsis`
--
ALTER TABLE `harwat_harsis`
  ADD CONSTRAINT `FK_harwat_harsis_sakit` FOREIGN KEY (`idsakit_harsis`) REFERENCES `sakit_harsis` (`idsakit_harsis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_harwat_harsis_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `sakit_detil`
--
ALTER TABLE `sakit_detil`
  ADD CONSTRAINT `FK_sakit_detil_key` FOREIGN KEY (`idsakit`) REFERENCES `sakit` (`idsakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sakit_harsis`
--
ALTER TABLE `sakit_harsis`
  ADD CONSTRAINT `FK_sakit_harsis_sakit` FOREIGN KEY (`idsakit`) REFERENCES `sakit` (`idsakit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_sakit_harsis_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

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
