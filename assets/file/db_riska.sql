-- MySQL dump 10.13  Distrib 5.7.43, for osx10.17 (x86_64)
--
-- Host: localhost    Database: db_riska
-- ------------------------------------------------------
-- Server version	5.7.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `app_barangs`
--

DROP TABLE IF EXISTS `app_barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_barangs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(100) NOT NULL,
  `customer` varchar(100) NOT NULL,
  `qty` varchar(100) NOT NULL,
  `tgl_planning` date DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT CURRENT_TIMESTAMP,
  `tgl_keluar` date DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `qty_ok` bigint(20) DEFAULT '0',
  `qty_reject` bigint(20) DEFAULT '0',
  `jumlah_sample` bigint(20) DEFAULT NULL,
  `jumlah_produksi` bigint(20) DEFAULT NULL,
  `kode_planning` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_barangs`
--

LOCK TABLES `app_barangs` WRITE;
/*!40000 ALTER TABLE `app_barangs` DISABLE KEYS */;
INSERT INTO `app_barangs` VALUES (1,'KW770','santi 1234','10005','2023-08-04','2023-07-28 23:48:20','0000-00-00','ok 30','pending',10,5,30,NULL,'KP7792'),(2,'KW771','santo','100','2023-08-02','2023-07-26 23:48:20',NULL,NULL,'sudah-diterima',NULL,NULL,NULL,NULL,'KP7793'),(4,'KW773','909234','109123','2023-07-30','2023-07-28 21:50:19',NULL,'koment apa aja','selesai',10,10,NULL,10,'KP7794'),(5,'KW771','coki','100','2023-07-31','2023-07-31 21:25:32','2023-07-31','ok semua','selesai',10,12,20,10,'KP7791'),(6,'KW772','lolo','50','2023-07-31','2023-07-31 21:48:53',NULL,NULL,'sudah-diterima',0,0,NULL,NULL,'KP7792'),(7,'KW770','test','100','2023-08-03','2023-08-03 16:03:22',NULL,'okk','release-produksi',0,0,100,NULL,'KP7793'),(8,'KW771','test 1234','100','2023-08-04','2023-08-04 20:43:57','2023-08-04',NULL,'sudah-diterima',12,10,NULL,NULL,'KP7794'),(9,'KW771','okee','100','2023-08-04','2023-08-04 20:44:08','2023-08-04','okee semua ya','selesai',100,5,100,100,'KP7795'),(10,'KW773','twetew','123','2023-08-04','2023-08-04 21:05:07',NULL,NULL,'pending',0,0,NULL,NULL,'KP7796');
/*!40000 ALTER TABLE `app_barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_master_barang`
--

DROP TABLE IF EXISTS `app_master_barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_master_barang` (
  `kode_barang` varchar(100) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_master_barang`
--

LOCK TABLES `app_master_barang` WRITE;
/*!40000 ALTER TABLE `app_master_barang` DISABLE KEYS */;
INSERT INTO `app_master_barang` VALUES ('KW770','barang test today','2023-07-26 23:37:19'),('KW771','barang 2','2023-07-27 23:37:19'),('KW772','barang abc 1231','2023-07-28 22:05:59'),('KW773','barang dec 2323','2023-07-28 22:06:07'),('KW774','barang today','2023-08-06 11:29:49');
/*!40000 ALTER TABLE `app_master_barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_users`
--

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;
INSERT INTO `app_users` VALUES (1,'admin','admin 1','admin@gmail.com','202cb962ac59075b964b07152d234b70'),(2,'ppic','PPIC','ppic@gmail.com','202cb962ac59075b964b07152d234b70'),(3,'qc','QC','qc@gmail.com','202cb962ac59075b964b07152d234b70'),(5,'gudang','Gudang','gudang@gmail.com','202cb962ac59075b964b07152d234b70'),(6,'produksi','Produksi','produksi@gmail.com','202cb962ac59075b964b07152d234b70');
/*!40000 ALTER TABLE `app_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-06 11:50:30
