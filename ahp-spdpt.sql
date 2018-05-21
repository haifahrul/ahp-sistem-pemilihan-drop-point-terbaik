-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.21-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for aal-ahp
CREATE DATABASE IF NOT EXISTS `aal-ahp` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `aal-ahp`;

-- Dumping structure for table aal-ahp.ahp_alternatif
CREATE TABLE IF NOT EXISTS `ahp_alternatif` (
  `id_alternatif` int(11) NOT NULL AUTO_INCREMENT,
  `id_seleksi` int(11) NOT NULL,
  `nama_alternatif` varchar(50) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `tgl_daftar` date NOT NULL,
  PRIMARY KEY (`id_alternatif`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table aal-ahp.ahp_alternatif: 6 rows
/*!40000 ALTER TABLE `ahp_alternatif` DISABLE KEYS */;
INSERT INTO `ahp_alternatif` (`id_alternatif`, `id_seleksi`, `nama_alternatif`, `catatan`, `tgl_daftar`) VALUES
	(1, 1, 'Bagus Susanto', '-', '2015-04-24'),
	(2, 1, 'Siti Zumrotul', '-', '2015-04-25'),
	(3, 1, 'Iskandar', '-', '2015-04-28'),
	(5, 1, 'Arif Prawiro', '-', '2015-04-28'),
	(6, 3, 'Fahrul2', 'keterangan', '2018-05-21'),
	(7, 3, 'ee', '2', '2018-05-21');
/*!40000 ALTER TABLE `ahp_alternatif` ENABLE KEYS */;

-- Dumping structure for table aal-ahp.ahp_kriteria
CREATE TABLE IF NOT EXISTS `ahp_kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `kriteria` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table aal-ahp.ahp_kriteria: 6 rows
/*!40000 ALTER TABLE `ahp_kriteria` DISABLE KEYS */;
INSERT INTO `ahp_kriteria` (`id_kriteria`, `kriteria`, `keterangan`) VALUES
	(1, 'Kejujuran', '-'),
	(2, 'Daya tahan kerja', '-'),
	(3, 'Ketelitian', '-'),
	(4, 'Inisiatif', '-'),
	(5, 'Kreatifitas', '-'),
	(6, 'Logika Berpikir', '-');
/*!40000 ALTER TABLE `ahp_kriteria` ENABLE KEYS */;

-- Dumping structure for table aal-ahp.ahp_kriteria_seleksi
CREATE TABLE IF NOT EXISTS `ahp_kriteria_seleksi` (
  `id_kriteria_seleksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(11) NOT NULL,
  `id_seleksi` int(11) NOT NULL,
  PRIMARY KEY (`id_kriteria_seleksi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table aal-ahp.ahp_kriteria_seleksi: 5 rows
/*!40000 ALTER TABLE `ahp_kriteria_seleksi` DISABLE KEYS */;
INSERT INTO `ahp_kriteria_seleksi` (`id_kriteria_seleksi`, `id_kriteria`, `id_seleksi`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 3, 1),
	(56, 1, 3),
	(55, 2, 3);
/*!40000 ALTER TABLE `ahp_kriteria_seleksi` ENABLE KEYS */;

-- Dumping structure for table aal-ahp.ahp_nilai_eigen
CREATE TABLE IF NOT EXISTS `ahp_nilai_eigen` (
  `id_nilai_eigen` int(11) NOT NULL AUTO_INCREMENT,
  `tipe` int(11) NOT NULL,
  `id_node_0` int(11) NOT NULL,
  `id_node` int(11) NOT NULL,
  `nilai` double NOT NULL,
  PRIMARY KEY (`id_nilai_eigen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table aal-ahp.ahp_nilai_eigen: 24 rows
/*!40000 ALTER TABLE `ahp_nilai_eigen` DISABLE KEYS */;
INSERT INTO `ahp_nilai_eigen` (`id_nilai_eigen`, `tipe`, `id_node_0`, `id_node`, `nilai`) VALUES
	(1, 2, 0, 1, 0.5492063492063493),
	(2, 2, 0, 2, 0.33121693121693124),
	(3, 2, 0, 3, 0.11957671957671957),
	(4, 2, 0, 4, 0.550252085313061),
	(5, 1, 1, 1, 0.20809707533845467),
	(6, 1, 1, 2, 0.2522529194942988),
	(7, 1, 1, 3, 0.04388542491990768),
	(8, 1, 1, 5, 0.49576458024733894),
	(9, 1, 2, 1, 0.5109650801757283),
	(10, 1, 2, 2, 0.03538295996800888),
	(11, 1, 2, 3, 0.1734018072439369),
	(12, 1, 2, 5, 0.28025015261232594),
	(13, 1, 3, 1, 0.21199073451576222),
	(14, 1, 3, 2, 0.04782073691973632),
	(15, 1, 3, 3, 0.4215184148443323),
	(16, 1, 3, 5, 0.3186701137201692),
	(17, 1, 4, 1, 0.05066805977710252),
	(18, 1, 4, 2, 0.39723277608915897),
	(19, 1, 4, 3, 0.1923663880445795),
	(20, 1, 4, 5, 0.359732776089159),
	(21, 2, 0, 55, 0.5),
	(22, 2, 0, 56, 0.5),
	(23, 1, 1, 6, 0.5),
	(24, 1, 1, 7, 0.5);
/*!40000 ALTER TABLE `ahp_nilai_eigen` ENABLE KEYS */;

-- Dumping structure for table aal-ahp.ahp_nilai_hasil
CREATE TABLE IF NOT EXISTS `ahp_nilai_hasil` (
  `id_nilai_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `nilai` double NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id_nilai_hasil`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table aal-ahp.ahp_nilai_hasil: 4 rows
/*!40000 ALTER TABLE `ahp_nilai_hasil` DISABLE KEYS */;
INSERT INTO `ahp_nilai_hasil` (`id_nilai_hasil`, `id_alternatif`, `nilai`, `rank`) VALUES
	(1, 1, 0.3088776774560234, 2),
	(2, 2, 0.1559765872586858, 3),
	(3, 3, 0.1319395577547025, 4),
	(4, 5, 0.4032061775305884, 1);
/*!40000 ALTER TABLE `ahp_nilai_hasil` ENABLE KEYS */;

-- Dumping structure for table aal-ahp.ahp_nilai_pasangan
CREATE TABLE IF NOT EXISTS `ahp_nilai_pasangan` (
  `id_nilai_pasangan` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipe` int(1) NOT NULL COMMENT '1 untuk kriteria dan 2 untuk alternatif',
  `id_node_0` int(11) NOT NULL COMMENT 'kriteria=0, untuk alterantif=id_alternatif',
  `id_node_1` int(11) NOT NULL COMMENT 'id_kriteria_seleksi atau id_alternatif',
  `id_node_2` int(11) NOT NULL COMMENT 'id_kriteria_seleksi atau id_alternatif',
  `nilai_1` double NOT NULL,
  `nilai_2` double NOT NULL,
  PRIMARY KEY (`id_nilai_pasangan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table aal-ahp.ahp_nilai_pasangan: 33 rows
/*!40000 ALTER TABLE `ahp_nilai_pasangan` DISABLE KEYS */;
INSERT INTO `ahp_nilai_pasangan` (`id_nilai_pasangan`, `tipe`, `id_node_0`, `id_node_1`, `id_node_2`, `nilai_1`, `nilai_2`) VALUES
	(1, 2, 0, 1, 2, 3, 0.3333333333333333),
	(2, 2, 0, 1, 3, 3, 0.3333333333333333),
	(3, 2, 0, 1, 4, 0.2, 5),
	(4, 2, 0, 2, 3, 5, 0.2),
	(5, 2, 0, 2, 4, 0.25, 4),
	(6, 2, 0, 3, 4, 0.2, 5),
	(7, 1, 1, 1, 2, 1, 1),
	(8, 1, 1, 1, 3, 5, 0.2),
	(9, 1, 1, 1, 5, 0.3333333333333333, 3),
	(10, 1, 1, 2, 3, 7, 0.14285714285714285),
	(11, 1, 1, 2, 5, 0.5, 2),
	(12, 1, 1, 3, 5, 0.1111111111111111, 9),
	(13, 1, 2, 1, 2, 9, 0.11111111111111),
	(14, 1, 2, 1, 3, 5, 0.2),
	(15, 1, 2, 1, 5, 2, 0.5),
	(16, 1, 2, 2, 3, 0.11111111111111, 9),
	(17, 1, 2, 2, 5, 0.11111111111111, 9),
	(18, 1, 2, 3, 5, 0.5, 2),
	(19, 1, 3, 1, 2, 6, 0.16666666666667),
	(20, 1, 3, 1, 3, 0.5, 2),
	(21, 1, 3, 1, 5, 0.5, 2),
	(22, 1, 3, 2, 3, 0.16666666666667, 6),
	(23, 1, 3, 2, 5, 0.125, 8),
	(24, 1, 3, 3, 5, 2, 0.5),
	(25, 1, 4, 1, 2, 0.11111111111111, 9),
	(26, 1, 4, 1, 3, 0.25, 4),
	(27, 1, 4, 1, 5, 0.16666666666667, 6),
	(28, 1, 4, 2, 3, 2, 0.5),
	(29, 1, 4, 2, 5, 1, 1),
	(30, 1, 4, 3, 5, 0.5, 2),
	(31, 2, 0, 55, 56, 1, 1),
	(32, 1, 55, 6, 7, 1, 1),
	(33, 1, 56, 6, 7, 1, 1);
/*!40000 ALTER TABLE `ahp_nilai_pasangan` ENABLE KEYS */;

-- Dumping structure for table aal-ahp.ahp_nilai_random_index
CREATE TABLE IF NOT EXISTS `ahp_nilai_random_index` (
  `id_nilai_random_index` int(11) NOT NULL AUTO_INCREMENT,
  `matrix` int(11) NOT NULL,
  `nilai` double NOT NULL,
  PRIMARY KEY (`id_nilai_random_index`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table aal-ahp.ahp_nilai_random_index: 15 rows
/*!40000 ALTER TABLE `ahp_nilai_random_index` DISABLE KEYS */;
INSERT INTO `ahp_nilai_random_index` (`id_nilai_random_index`, `matrix`, `nilai`) VALUES
	(1, 1, 0),
	(2, 2, 0),
	(3, 3, 0.58),
	(4, 4, 0.9),
	(5, 5, 1.12),
	(6, 6, 1.24),
	(7, 7, 1.32),
	(8, 8, 1.41),
	(9, 9, 1.45),
	(10, 10, 1.49),
	(11, 11, 1.51),
	(12, 12, 1.48),
	(13, 13, 1.56),
	(14, 14, 1.57),
	(15, 15, 1.59);
/*!40000 ALTER TABLE `ahp_nilai_random_index` ENABLE KEYS */;

-- Dumping structure for table aal-ahp.ahp_pengguna
CREATE TABLE IF NOT EXISTS `ahp_pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `tipe` int(1) NOT NULL,
  PRIMARY KEY (`id_pengguna`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table aal-ahp.ahp_pengguna: 1 rows
/*!40000 ALTER TABLE `ahp_pengguna` DISABLE KEYS */;
INSERT INTO `ahp_pengguna` (`id_pengguna`, `nama`, `no_telp`, `username`, `password`, `tipe`) VALUES
	(1, 'Admin Sistem', '081904013089', 'admin', '21232f297a57a5a743894a0e4a801fc3', 2);
/*!40000 ALTER TABLE `ahp_pengguna` ENABLE KEYS */;

-- Dumping structure for table aal-ahp.ahp_seleksi
CREATE TABLE IF NOT EXISTS `ahp_seleksi` (
  `id_seleksi` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `seleksi` varchar(50) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_seleksi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table aal-ahp.ahp_seleksi: 2 rows
/*!40000 ALTER TABLE `ahp_seleksi` DISABLE KEYS */;
INSERT INTO `ahp_seleksi` (`id_seleksi`, `tahun`, `seleksi`, `catatan`) VALUES
	(1, 2016, 'Seleksi Bagian Marketing', 'Penyeleksian Bagian Marketing Cabang Baru'),
	(3, 2015, 'asd', 'asd');
/*!40000 ALTER TABLE `ahp_seleksi` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
