-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 24, 2016 at 03:48 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adev_sc_spk_ahp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ahp_alternatif`
--

CREATE TABLE IF NOT EXISTS `ahp_alternatif` (
  `id_alternatif` int(11) NOT NULL AUTO_INCREMENT,
  `id_seleksi` int(11) NOT NULL,
  `nama_alternatif` varchar(50) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `tgl_daftar` date NOT NULL,
  PRIMARY KEY (`id_alternatif`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ahp_alternatif`
--

INSERT INTO `ahp_alternatif` (`id_alternatif`, `id_seleksi`, `nama_alternatif`, `catatan`, `tgl_daftar`) VALUES
(1, 1, 'Bagus Susanto', '-', '2015-04-24'),
(2, 1, 'Siti Zumrotul', '-', '2015-04-25'),
(3, 1, 'Iskandar', '-', '2015-04-28'),
(5, 1, 'Arif Prawiro', '-', '2015-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `ahp_kriteria`
--

CREATE TABLE IF NOT EXISTS `ahp_kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `kriteria` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ahp_kriteria`
--

INSERT INTO `ahp_kriteria` (`id_kriteria`, `kriteria`, `keterangan`) VALUES
(1, 'Kejujuran', '-'),
(2, 'Daya tahan kerja', '-'),
(3, 'Ketelitian', '-'),
(4, 'Inisiatif', '-'),
(5, 'Kreatifitas', '-'),
(6, 'Logika Berpikir', '-');

-- --------------------------------------------------------

--
-- Table structure for table `ahp_kriteria_seleksi`
--

CREATE TABLE IF NOT EXISTS `ahp_kriteria_seleksi` (
  `id_kriteria_seleksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(11) NOT NULL,
  `id_seleksi` int(11) NOT NULL,
  PRIMARY KEY (`id_kriteria_seleksi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ahp_kriteria_seleksi`
--

INSERT INTO `ahp_kriteria_seleksi` (`id_kriteria_seleksi`, `id_kriteria`, `id_seleksi`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ahp_nilai_eigen`
--

CREATE TABLE IF NOT EXISTS `ahp_nilai_eigen` (
  `id_nilai_eigen` int(11) NOT NULL AUTO_INCREMENT,
  `tipe` int(11) NOT NULL,
  `id_node_0` int(11) NOT NULL,
  `id_node` int(11) NOT NULL,
  `nilai` double NOT NULL,
  PRIMARY KEY (`id_nilai_eigen`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `ahp_nilai_eigen`
--

INSERT INTO `ahp_nilai_eigen` (`id_nilai_eigen`, `tipe`, `id_node_0`, `id_node`, `nilai`) VALUES
(1, 2, 0, 1, 0.13580428343586),
(2, 2, 0, 2, 0.23102415128731),
(3, 2, 0, 3, 0.066932102984734),
(4, 2, 0, 4, 0.56623946229209),
(5, 1, 1, 1, 0.17431163081068),
(6, 1, 1, 2, 0.29310378110188),
(7, 1, 1, 3, 0.04351778834701),
(8, 1, 1, 5, 0.48906679974042),
(9, 1, 2, 1, 0.51096508017573),
(10, 1, 2, 2, 0.035382959968009),
(11, 1, 2, 3, 0.17340180724394),
(12, 1, 2, 5, 0.28025015261233),
(13, 1, 3, 1, 0.21199073451576),
(14, 1, 3, 2, 0.047820736919736),
(15, 1, 3, 3, 0.42151841484433),
(16, 1, 3, 5, 0.31867011372017),
(17, 1, 4, 1, 0.050668059777103),
(18, 1, 4, 2, 0.39723277608916),
(19, 1, 4, 3, 0.19236638804458),
(20, 1, 4, 5, 0.35973277608916);

-- --------------------------------------------------------

--
-- Table structure for table `ahp_nilai_hasil`
--

CREATE TABLE IF NOT EXISTS `ahp_nilai_hasil` (
  `id_nilai_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `nilai` double NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id_nilai_hasil`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ahp_nilai_hasil`
--

INSERT INTO `ahp_nilai_hasil` (`id_nilai_hasil`, `id_alternatif`, `nilai`, `rank`) VALUES
(1, 1, 0.18459678069982, 3),
(2, 2, 0.27610868328736, 2),
(3, 3, 0.18310846149515, 4),
(4, 5, 0.35618607451766, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ahp_nilai_pasangan`
--

CREATE TABLE IF NOT EXISTS `ahp_nilai_pasangan` (
  `id_nilai_pasangan` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipe` int(1) NOT NULL COMMENT '1 untuk kriteria dan 2 untuk alternatif',
  `id_node_0` int(11) NOT NULL COMMENT 'kriteria=0, untuk alterantif=id_alternatif',
  `id_node_1` int(11) NOT NULL COMMENT 'id_kriteria_seleksi atau id_alternatif',
  `id_node_2` int(11) NOT NULL COMMENT 'id_kriteria_seleksi atau id_alternatif',
  `nilai_1` double NOT NULL,
  `nilai_2` double NOT NULL,
  PRIMARY KEY (`id_nilai_pasangan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `ahp_nilai_pasangan`
--

INSERT INTO `ahp_nilai_pasangan` (`id_nilai_pasangan`, `tipe`, `id_node_0`, `id_node_1`, `id_node_2`, `nilai_1`, `nilai_2`) VALUES
(1, 2, 0, 1, 2, 0.5, 2),
(2, 2, 0, 1, 3, 3, 0.33333333333333),
(3, 2, 0, 1, 4, 0.2, 5),
(4, 2, 0, 2, 3, 5, 0.2),
(5, 2, 0, 2, 4, 0.25, 4),
(6, 2, 0, 3, 4, 0.2, 5),
(7, 1, 1, 1, 2, 0.5, 2),
(8, 1, 1, 1, 3, 5, 0.2),
(9, 1, 1, 1, 5, 0.33333333333333, 3),
(10, 1, 1, 2, 3, 7, 0.14285714285714),
(11, 1, 1, 2, 5, 0.5, 2),
(12, 1, 1, 3, 5, 0.11111111111111, 9),
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
(30, 1, 4, 3, 5, 0.5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ahp_nilai_random_index`
--

CREATE TABLE IF NOT EXISTS `ahp_nilai_random_index` (
  `id_nilai_random_index` int(11) NOT NULL AUTO_INCREMENT,
  `matrix` int(11) NOT NULL,
  `nilai` double NOT NULL,
  PRIMARY KEY (`id_nilai_random_index`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `ahp_nilai_random_index`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `ahp_pengguna`
--

CREATE TABLE IF NOT EXISTS `ahp_pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `tipe` int(1) NOT NULL,
  PRIMARY KEY (`id_pengguna`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ahp_pengguna`
--

INSERT INTO `ahp_pengguna` (`id_pengguna`, `nama`, `no_telp`, `username`, `password`, `tipe`) VALUES
(1, 'Admin Sistem', '081904013089', 'admin', 'fcea920f7412b5da7be0cf42b8c93759', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ahp_seleksi`
--

CREATE TABLE IF NOT EXISTS `ahp_seleksi` (
  `id_seleksi` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `seleksi` varchar(50) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_seleksi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ahp_seleksi`
--

INSERT INTO `ahp_seleksi` (`id_seleksi`, `tahun`, `seleksi`, `catatan`) VALUES
(1, 2015, 'Seleksi Bagian Marketing', 'Penyeleksian Bagian Marketing Cabang Baru');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
