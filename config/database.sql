-- MySQL dump 10.15  Distrib 10.0.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: white
-- ------------------------------------------------------
-- Server version	10.0.34-MariaDB-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(180) DEFAULT NULL,
  `id_content_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (2,'Live',2);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `background` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `id_category` varchar(255) DEFAULT NULL,
  `id_content_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` VALUES (17,'BBC Arabia','https://scm.bz/wp-content/uploads/2018/03/arabic_1024x576.png','https://scm.bz/wp-content/uploads/2018/03/arabic_1024x576.png','http://bbcwshdlive01-lh.akamaihd.net/i/atv_1@61433/master.m3u8','2',2),(18,'alfasad','https://scm.bz/en/jobs/bbc-arabic-offers-program-for-journalists-with-disabilities-mena.html','https://scm.bz/en/jobs/bbc-arabic-offers-program-for-journalists-with-disabilities-mena.html','http://bbcwshdlive01-lh.akamaihd.net/i/atv_1@61433/master.m3u8','2',2),(19,'Cubavision','http://www.cubadebate.cu/opinion/2013/12/21/cambiar-por-solo-cambiar-video/','http://www.cubadebate.cu/opinion/2013/12/21/cambiar-por-solo-cambiar-video/','http://38.99.146.36:7777/Beladi_HD.m3u8','2',2),(20,'arabian','https://e7kky.com/article/21796/%D9%85%D9%87%D8%B1%D8%AC%D8%A7%D9%86-BBC-%D9%84%D9%84%D8%A3%D9%81%D9%84%D8%A7%D9%85-%D8%A7%D9%84%D9%88%D8%AB%D8%A7%D8%A6%D9%82%D9%8A%D8%A9-%D9%8A%D9%81%D8%AA%D8%AD-%D8%A8%D8%A7%D8%A8-%D8%A7%D9%84%D8%AA%D9%82%D8%AF%D9%8A%D9%','https://e7kky.com/article/21796/%D9%85%D9%87%D8%B1%D8%AC%D8%A7%D9%86-BBC-%D9%84%D9%84%D8%A3%D9%81%D9%84%D8%A7%D9%85-%D8%A7%D9%84%D9%88%D8%AB%D8%A7%D8%A6%D9%82%D9%8A%D8%A9-%D9%8A%D9%81%D8%AA%D8%AD-%D8%A8%D8%A7%D8%A8-%D8%A7%D9%84%D8%AA%D9%82%D8%AF%D9%8A%D9%','http://stream2.1malaysiaiptv.com:1935/mylive/smil:bernama2_all.smil/media.m3u8','2',2),(21,'Rusobia','data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISEhUSEBIVFRUVFRgVFRUVFRUXFRUVFRUWFxUVFRUYHSggGBolHRcVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGhAQGy0lIB0tKy0vLS0yListLi0vLS8tLS0tLS0vLS0tLS0tLS0uLS8tLS0tLS0tLS0tLS0tLS0tLf/AABEIAKUBMQMBIgACEQEDEQH/','data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISEhUSEBIVFRUVFRgVFRUVFRUXFRUVFRUWFxUVFRUYHSggGBolHRcVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGhAQGy0lIB0tKy0vLS0yListLi0vLS8tLS0tLS0vLS0tLS0tLS0uLS8tLS0tLS0tLS0tLS0tLS0tLf/AABEIAKUBMQMBIgACEQEDEQH/','http://ios.cdn.bg:2006/fls/bonair.stream/playlist.m3u8','2',2),(22,'BookTv','https://cdnmundo1.img.sputniknews.com/images/106715/88/1067158880.jpg','https://cdnmundo1.img.sputniknews.com/images/106715/88/1067158880.jpg','http://cspan2-lh.akamaihd.net/i/cspan2_1@304728/index_1000_av-p.m3u8?sd=10&rebase=on','2',2);
/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_type`
--

DROP TABLE IF EXISTS `content_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type` varchar(55) DEFAULT NULL,
  `api` text NOT NULL,
  `pin` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_type`
--

LOCK TABLES `content_type` WRITE;
/*!40000 ALTER TABLE `content_type` DISABLE KEYS */;
INSERT INTO `content_type` VALUES (2,'Live','live',0);
/*!40000 ALTER TABLE `content_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_system`
--

DROP TABLE IF EXISTS `users_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) DEFAULT NULL,
  `password` varchar(105) DEFAULT NULL,
  `last_connection_date` datetime DEFAULT NULL,
  `last_ip_connection` varchar(35) DEFAULT NULL,
  `logging_date` datetime DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `cookie` varchar(180) DEFAULT NULL,
  `avatar` varchar(180) DEFAULT NULL,
  `deleted` varchar(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_system`
--

LOCK TABLES `users_system` WRITE;
/*!40000 ALTER TABLE `users_system` DISABLE KEYS */;
INSERT INTO `users_system` VALUES (27,'admin','31c11d8ee710d9f569d03b0f39ee871c0599bb752254ff4cc4873a35f07fe244','2018-06-07 18:04:48','127.0.0.1','2018-04-26 01:25:29',1,NULL,NULL,'0');
/*!40000 ALTER TABLE `users_system` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-08 21:38:41
