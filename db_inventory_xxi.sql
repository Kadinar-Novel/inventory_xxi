-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table db_inventory_xxi.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `idBarang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(8) DEFAULT NULL,
  `nama_barang` varchar(50) DEFAULT NULL,
  `stock_barang` int(11) DEFAULT NULL,
  PRIMARY KEY (`idBarang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_inventory_xxi.barang: ~2 rows (approximately)
DELETE FROM `barang`;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` (`idBarang`, `kode_barang`, `nama_barang`, `stock_barang`) VALUES
	(1, 'BR0001', 'Lampu', 8),
	(2, 'BR0002', 'Kabel Lan', 9),
	(3, 'BR0003', 'Lensa Pojector', 10);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.keluar_barang
CREATE TABLE IF NOT EXISTS `keluar_barang` (
  `idKeluarBarang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_keluar_barang` char(15) NOT NULL,
  `idPegawai_mengajukan` int(11) NOT NULL,
  `nama_pegawai` varchar(50) NOT NULL,
  `pegawai_approve` varchar(50) NOT NULL,
  `approve_manager` char(2) NOT NULL DEFAULT '0',
  `tanggal_keluar_barang` date NOT NULL,
  PRIMARY KEY (`idKeluarBarang`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_inventory_xxi.keluar_barang: ~0 rows (approximately)
DELETE FROM `keluar_barang`;
/*!40000 ALTER TABLE `keluar_barang` DISABLE KEYS */;
INSERT INTO `keluar_barang` (`idKeluarBarang`, `kode_keluar_barang`, `idPegawai_mengajukan`, `nama_pegawai`, `pegawai_approve`, `approve_manager`, `tanggal_keluar_barang`) VALUES
	(1, 'XXIKB-0001', 1, 'Budi', 'Surahman', '1', '2020-08-08');
/*!40000 ALTER TABLE `keluar_barang` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.keluar_barang_detail
CREATE TABLE IF NOT EXISTS `keluar_barang_detail` (
  `idDetailKeluarBarang` int(11) NOT NULL AUTO_INCREMENT,
  `idKeluarBarang` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`idDetailKeluarBarang`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_inventory_xxi.keluar_barang_detail: ~2 rows (approximately)
DELETE FROM `keluar_barang_detail`;
/*!40000 ALTER TABLE `keluar_barang_detail` DISABLE KEYS */;
INSERT INTO `keluar_barang_detail` (`idDetailKeluarBarang`, `idKeluarBarang`, `idBarang`, `qty`) VALUES
	(1, 1, 1, 2),
	(2, 1, 2, 1);
/*!40000 ALTER TABLE `keluar_barang_detail` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.mahasiswa
CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_inventory_xxi.mahasiswa: ~0 rows (approximately)
DELETE FROM `mahasiswa`;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(50) NOT NULL,
  `posisi` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table db_inventory_xxi.menu: ~0 rows (approximately)
DELETE FROM `menu`;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id_menu`, `nama_menu`, `posisi`) VALUES
	(1, 'Master', 1),
	(2, 'Transaksi', 2);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.modul
CREATE TABLE IF NOT EXISTS `modul` (
  `id_modul` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `nama_modul` varchar(150) NOT NULL,
  `link_menu` text NOT NULL,
  `link_folder` text NOT NULL,
  `posisi` int(11) NOT NULL,
  `icon_menu` varchar(150) NOT NULL,
  PRIMARY KEY (`id_modul`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_inventory_xxi.modul: ~4 rows (approximately)
DELETE FROM `modul`;
/*!40000 ALTER TABLE `modul` DISABLE KEYS */;
INSERT INTO `modul` (`id_modul`, `id_menu`, `nama_modul`, `link_menu`, `link_folder`, `posisi`, `icon_menu`) VALUES
	(1, 1, 'Pegawai', 'index.php?page=pegawai', 'pages/pegawai/pegawai.php', 1, 'fa fa-group'),
	(2, 1, 'Barang', 'index.php?page=barang', 'pages/barang/barang.php', 2, 'fa fa-download'),
	(3, 2, 'Barang Keluar', 'index.php?page=keluar_barang', 'pages/keluar_barang/keluar_barang.php', 1, 'fa fa-cart-arrow-down'),
	(4, 2, 'Pemesanan', 'index.php?page=pemesanan', 'pages/pemesanan/pemesanan.php', 2, 'fa fa-caret-square-o-right'),
	(5, 2, 'Penerimaan', 'index.php?page=penerimaan', 'pages/penerimaan/penerimaan.php', 3, 'fa fa-calendar-plus-o');
/*!40000 ALTER TABLE `modul` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.pegawai
CREATE TABLE IF NOT EXISTS `pegawai` (
  `idPegawai` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pegawai` varchar(7) DEFAULT NULL,
  `nama_pegawai` varchar(25) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `jabatan` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idPegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_inventory_xxi.pegawai: ~2 rows (approximately)
DELETE FROM `pegawai`;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` (`idPegawai`, `kode_pegawai`, `nama_pegawai`, `alamat`, `telepon`, `jabatan`) VALUES
	(1, 'KP00001', 'Budi', 'Bekasi', '08123456789', 'Admin'),
	(2, 'KP00002', 'Rahma', 'Narogong', '01234567890', 'Bagian Umum'),
	(3, 'KP00003', 'Surahman', 'Rawalumbu', '0987654321', 'Manager');
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.pemesanan
CREATE TABLE IF NOT EXISTS `pemesanan` (
  `idPemesanan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pemesanan` char(15) NOT NULL,
  `idPegawai_mengajukan` int(11) NOT NULL,
  `idPegawai_approve` int(11) NOT NULL,
  `approve_manager` int(11) NOT NULL DEFAULT 0,
  `tanggal_pemesanan` date NOT NULL,
  PRIMARY KEY (`idPemesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_inventory_xxi.pemesanan: ~0 rows (approximately)
DELETE FROM `pemesanan`;
/*!40000 ALTER TABLE `pemesanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pemesanan` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.pemesanan_detail
CREATE TABLE IF NOT EXISTS `pemesanan_detail` (
  `idDetailPemesanan` int(11) NOT NULL AUTO_INCREMENT,
  `idPemesanan` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`idDetailPemesanan`),
  KEY `FK_pemesanan_detail_pemesanan` (`idPemesanan`),
  CONSTRAINT `FK_pemesanan_detail_pemesanan` FOREIGN KEY (`idPemesanan`) REFERENCES `pemesanan` (`idPemesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_inventory_xxi.pemesanan_detail: ~0 rows (approximately)
DELETE FROM `pemesanan_detail`;
/*!40000 ALTER TABLE `pemesanan_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `pemesanan_detail` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.penerimaan
CREATE TABLE IF NOT EXISTS `penerimaan` (
  `idPemesanan` int(11) NOT NULL AUTO_INCREMENT,
  `idPegawai_mengajukan` int(11) NOT NULL,
  `idPegawai_approve` int(11) NOT NULL,
  `tanggal_pemesanan` date NOT NULL,
  PRIMARY KEY (`idPemesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_inventory_xxi.penerimaan: ~0 rows (approximately)
DELETE FROM `penerimaan`;
/*!40000 ALTER TABLE `penerimaan` DISABLE KEYS */;
/*!40000 ALTER TABLE `penerimaan` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.penerimaan_detail
CREATE TABLE IF NOT EXISTS `penerimaan_detail` (
  `idDetailPemesanan` int(11) NOT NULL AUTO_INCREMENT,
  `idPemesanan` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`idDetailPemesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_inventory_xxi.penerimaan_detail: ~0 rows (approximately)
DELETE FROM `penerimaan_detail`;
/*!40000 ALTER TABLE `penerimaan_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `penerimaan_detail` ENABLE KEYS */;

-- Dumping structure for table db_inventory_xxi.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `idPegawai` int(11) NOT NULL,
  `nama_lengkap` varchar(45) NOT NULL,
  `usernm` varchar(20) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL,
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table db_inventory_xxi.user: ~2 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `idPegawai`, `nama_lengkap`, `usernm`, `passwd`, `level`, `last_login`) VALUES
	(1, 1, 'Budi', 'budi123', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', '2020-10-13 05:19:06'),
	(3, 2, 'Rahma', 'rahma123', 'e10adc3949ba59abbe56e057f20f883e', 'Bagian Umum', '2020-11-14 05:08:46'),
	(4, 3, 'Surahman', 'surahman', 'e10adc3949ba59abbe56e057f20f883e', 'Manager', '2020-10-13 05:17:07');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
