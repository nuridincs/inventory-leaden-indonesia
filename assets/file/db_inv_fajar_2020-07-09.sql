# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.27)
# Database: db_inv_fajar
# Generation Time: 2020-07-09 14:20:32 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table app_barang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_barang`;

CREATE TABLE `app_barang` (
  `part_name` char(20) NOT NULL DEFAULT '',
  `part_number` char(20) NOT NULL,
  `minimum_stok` int(11) DEFAULT NULL,
  `bom` varchar(20) DEFAULT NULL,
  `kebutuhan_bahan` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`part_name`),
  KEY `part_number` (`part_number`,`part_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_barang` WRITE;
/*!40000 ALTER TABLE `app_barang` DISABLE KEYS */;

INSERT INTO `app_barang` (`part_name`, `part_number`, `minimum_stok`, `bom`, `kebutuhan_bahan`, `created_at`)
VALUES
	('bearing','4637175',29,'1',80,'2020-06-15 21:20:27'),
	('boots','2058775',70,'1',14,'2020-06-15 21:20:27'),
	('bracket','YA00029295',151,'1',14,'2020-07-02 21:04:29'),
	('clip','46515357',20,'2',16,'2020-06-20 10:44:47'),
	('harnes','4630572',10,'3',18,'2020-06-20 22:33:27'),
	('harness','YA00029285',123,'1',33,'2020-07-02 20:59:42'),
	('hose','4612743',10,'4',20,'2020-06-15 21:20:27'),
	('pocket','YA00030888',100,'5',22,'2020-06-20 12:58:39'),
	('screw','452613',151,'1',14,'2020-07-02 21:03:46');

/*!40000 ALTER TABLE `app_barang` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_barang_keluar
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_barang_keluar`;

CREATE TABLE `app_barang_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_number` char(20) DEFAULT NULL,
  `jumlah_barang_keluar` int(11) DEFAULT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kode barang keluar` (`part_number`),
  CONSTRAINT `ppp` FOREIGN KEY (`part_number`) REFERENCES `app_barang` (`part_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_barang_keluar` WRITE;
/*!40000 ALTER TABLE `app_barang_keluar` DISABLE KEYS */;

INSERT INTO `app_barang_keluar` (`id`, `part_number`, `jumlah_barang_keluar`, `tanggal_keluar`)
VALUES
	(1,'4637175',50,'2020-06-20'),
	(2,'2058775',2,'2020-07-06'),
	(3,'46515357',4,'2020-07-06'),
	(4,'4630572',2,'2020-07-06'),
	(5,'2058775',2,'2020-07-07'),
	(6,'46515357',4,'2020-07-07'),
	(7,'4630572',2,'2020-07-07');

/*!40000 ALTER TABLE `app_barang_keluar` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_barang_masuk
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_barang_masuk`;

CREATE TABLE `app_barang_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_number` char(20) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `status_permintaan` varchar(20) DEFAULT 'pending',
  `jumlah_barang` int(11) DEFAULT NULL,
  `status_barang` int(11) DEFAULT '2' COMMENT '1=tersedia, 2= pending, 0 = tidak tersedia, 3 = sedang proses',
  `keterangan` varchar(50) DEFAULT NULL,
  `tanggal_masuk` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kode barang` (`part_number`),
  KEY `cabang barang keluar` (`id_type`),
  CONSTRAINT `oo` FOREIGN KEY (`part_number`) REFERENCES `app_barang` (`part_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_barang_masuk` WRITE;
/*!40000 ALTER TABLE `app_barang_masuk` DISABLE KEYS */;

INSERT INTO `app_barang_masuk` (`id`, `part_number`, `id_type`, `status_permintaan`, `jumlah_barang`, `status_barang`, `keterangan`, `tanggal_masuk`)
VALUES
	(1,'4637175',200,'tersedia',5010,1,NULL,'2020-06-20 00:00:00'),
	(2,'2058775',200,'tersedia',4891,1,'test','2020-06-20 00:00:00'),
	(4,'46515357',200,'tersedia',4,1,NULL,'2020-06-20 00:00:00'),
	(5,'4630572',200,'pending',2111,2,NULL,'2020-06-20 00:00:00'),
	(7,'4612743',100,'sedang_diproses',100,3,NULL,'2020-07-04 22:04:31'),
	(8,'YA00030888',100,'tersedia',100,1,NULL,'2020-07-04 22:04:43'),
	(9,'452613',100,'tersedia',100,1,NULL,'2020-07-04 22:04:59');

/*!40000 ALTER TABLE `app_barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_role`;

CREATE TABLE `app_role` (
  `id_users_role` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_users_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_role` WRITE;
/*!40000 ALTER TABLE `app_role` DISABLE KEYS */;

INSERT INTO `app_role` (`id_users_role`, `kategori`)
VALUES
	(1,'admin'),
	(2,'leader'),
	(3,'manager');

/*!40000 ALTER TABLE `app_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_type`;

CREATE TABLE `app_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_type` WRITE;
/*!40000 ALTER TABLE `app_type` DISABLE KEYS */;

INSERT INTO `app_type` (`id`, `jenis_type`)
VALUES
	(1,'200'),
	(2,'100');

/*!40000 ALTER TABLE `app_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_users`;

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;

INSERT INTO `app_users` (`id`, `role`, `nama`, `email`, `password`)
VALUES
	(1,'admin','admin 1','admin@gmail.com','202cb962ac59075b964b07152d234b70'),
	(2,'leader','leader 1','leader@gmail.com','202cb962ac59075b964b07152d234b70'),
	(3,'manager','manager','manager@gmail.com','202cb962ac59075b964b07152d234b70'),
	(5,'admin','admin test','admin.test@gmail.com','202cb962ac59075b964b07152d234b70');

/*!40000 ALTER TABLE `app_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
