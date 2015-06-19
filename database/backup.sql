-- MySQL dump 10.13  Distrib 5.6.19, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.6.19-1~exp1ubuntu2

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
-- Table structure for table `cases`
--

DROP TABLE IF EXISTS `cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clinical_data` text COLLATE utf8_unicode_ci,
  `category_id` int(10) unsigned DEFAULT NULL,
  `virtual_slide_provider_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cases_category_id_foreign` (`category_id`),
  KEY `cases_virtual_slide_provider_id_foreign` (`virtual_slide_provider_id`),
  CONSTRAINT `cases_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cases_virtual_slide_provider_id_foreign` FOREIGN KEY (`virtual_slide_provider_id`) REFERENCES `virtual_slide_providers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cases`
--

LOCK TABLES `cases` WRITE;
/*!40000 ALTER TABLE `cases` DISABLE KEYS */;
INSERT INTO `cases` VALUES (1,'61/F. Multiple bilateral small rubbery nodules.',6,1,'2015-06-11 10:10:46','2015-06-11 10:10:46'),(2,'',6,2,'2015-06-11 10:13:14','2015-06-11 10:19:58'),(3,'60/F.',9,2,'2015-06-11 10:30:47','2015-06-11 10:30:47'),(4,'55/F',11,1,'2015-06-11 10:41:02','2015-06-11 10:41:02'),(5,'27/F',11,1,'2015-06-11 10:42:10','2015-06-11 10:42:10'),(6,'21/F',11,1,'2015-06-11 10:44:37','2015-06-11 10:44:37'),(7,'',11,1,'2015-06-11 10:45:55','2015-06-11 10:45:55'),(8,'47/F',11,1,'2015-06-11 10:46:59','2015-06-11 10:46:59'),(9,'37/F',11,1,'2015-06-11 10:47:47','2015-06-11 10:47:47'),(10,'18/F',11,1,'2015-06-11 10:49:02','2015-06-11 10:49:02'),(11,'13/F',11,1,'2015-06-11 10:51:10','2015-06-11 10:51:10'),(12,'13/F',11,1,'2015-06-11 10:53:34','2015-06-11 10:53:34'),(13,'35/F',11,2,'2015-06-11 10:55:44','2015-06-11 10:55:44'),(14,'39/F',11,2,'2015-06-11 10:56:16','2015-06-11 10:56:16'),(15,'',11,2,'2015-06-11 10:56:43','2015-06-11 10:56:43'),(16,'',11,2,'2015-06-11 10:57:47','2015-06-11 10:57:47'),(17,'37/F',14,1,'2015-06-11 11:00:41','2015-06-11 11:00:41'),(18,'',14,1,'2015-06-11 11:01:36','2015-06-11 11:01:36'),(19,'36/F',14,1,'2015-06-11 11:02:16','2015-06-11 11:02:16'),(20,'32/F',14,1,'2015-06-11 11:02:58','2015-06-11 11:02:58'),(21,'33/F',14,1,'2015-06-11 11:03:56','2015-06-11 11:03:56'),(22,'',14,1,'2015-06-11 11:04:58','2015-06-11 11:04:58'),(23,'50/F',14,1,'2015-06-11 11:05:35','2015-06-11 11:05:35'),(24,'',14,2,'2015-06-11 11:40:17','2015-06-11 11:40:17'),(25,'65/F',14,2,'2015-06-11 11:40:45','2015-06-11 11:40:45');
/*!40000 ALTER TABLE `cases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_category_parent_id_unique` (`category`,`parent_id`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Histopathology',NULL,'2015-06-11 15:35:50','2015-06-11 15:35:50'),(2,'Hematopathology',NULL,'2015-06-11 15:36:13','2015-06-11 15:36:13'),(3,'Cytopathology',NULL,'2015-06-11 15:36:33','2015-06-11 15:36:33'),(4,'Breast',1,'2015-06-11 10:04:38','2015-06-11 10:04:38'),(5,'Inflammatory and Related Lesions',4,'2015-06-11 10:05:13','2015-06-11 10:05:13'),(6,'Mammary duct ectasia',5,'2015-06-11 10:05:34','2015-06-11 10:05:34'),(7,'Fat necrosis',5,'2015-06-11 10:05:45','2015-06-11 10:05:45'),(8,'Breast',3,'2015-06-11 10:27:55','2015-06-11 10:27:55'),(9,'Fat necrosis',8,'2015-06-11 10:28:21','2015-06-11 10:28:21'),(10,'Benign Proliferative Breast Disease',4,'2015-06-11 10:31:40','2015-06-11 10:31:40'),(11,'Fibroadenoma',10,'2015-06-11 10:35:34','2015-06-11 10:35:34'),(12,'Adenoma',10,'2015-06-11 10:35:58','2015-06-11 10:35:58'),(13,'Intraductal Papilloma',10,'2015-06-11 10:37:31','2015-06-11 10:37:31'),(14,'Nipple adenoma',10,'2015-06-11 10:37:58','2015-06-11 10:37:58');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_05_04_194729_create_cases_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'User'),(2,'Mod'),(3,'Admin');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(10) unsigned NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Vikram','dr.vikramraj87@gmail.com','$2y$10$VlY/GMZb.xbXqpcWxQr3PeNafZ7iGC3zoobl.4uJwcDOEb4bAkJ1K',3,NULL,'2015-06-11 09:59:32','2015-06-11 09:59:32'),(2,'Kirthika Vikram','kirthiviswanath@gmail.com','$2y$10$/jMriY.m4hNIOWr70Y8Kfuie7ZC5CiFUuuOmf.K1jJIJ5mrIW2J4u',2,NULL,'2015-06-17 14:38:27','2015-06-17 14:38:27'),(3,'Marion Walker','Runolfsdottir.Hosea@Ruecker.net','$2y$10$6yI0mT7iLOVveIQAN8FJKuRUkqGtwKa/1Or6pJC/GD46APlTjRn3a',1,NULL,'2015-06-17 14:40:53','2015-06-17 14:40:53'),(4,'Dr. Rowland Gutmann Jr.','Wiegand.Hortense@Conroy.org','$2y$10$8iekmLIUGuD//6uA68UmcOnioPiLrA.NtA.qOvhNgtMGejzNfEEga',1,NULL,'2015-06-17 14:44:36','2015-06-17 14:44:36'),(5,'Theresa Bartell PhD','sWisozk@hotmail.com','$2y$10$sKG.x1fff4WlrQWhIT97NOmM4IdHQH3L.zac31iAm47tZLU1TH98.',1,NULL,'2015-06-17 14:45:03','2015-06-17 14:45:03'),(6,'Dr. Verna Schaden','Zane.Carroll@hotmail.com','$2y$10$uKUuyGls9ziLZCawHL1mve5gimiOoc37ZJYuib4tMq.EceYHsho0a',1,NULL,'2015-06-17 14:45:03','2015-06-17 14:45:03'),(7,'Ibrahim Grant','wTurcotte@Harber.com','$2y$10$rk5.W/aIIvP2hPDqDW98Deud7.6RD2j05oBGSqEx./jswjUnd2rPS',1,NULL,'2015-06-17 14:45:03','2015-06-17 14:45:03'),(8,'Rosina Gerhold','Athena28@Lehner.com','$2y$10$SDu81shrB3E7IP3HAjzjWOBWSY90gKisUO6yLzwwQFReNhlJD8cNy',1,NULL,'2015-06-17 14:45:03','2015-06-17 14:45:03'),(9,'Delores Veum','Janiya.Koelpin@Green.biz','$2y$10$WzQKSDVXKloVL8rAUNZVtuMgHjoU/g3pSDaEGi7ssXPjB7LV520JS',1,NULL,'2015-06-17 14:45:03','2015-06-17 14:45:03'),(10,'Dr. Samara Price','Zechariah18@gmail.com','$2y$10$OyIrL1P3UbUo8k6PtdhVvOpOaSfQaeBaqcUIS1VFDSg7clChUx9P6',1,NULL,'2015-06-17 14:45:03','2015-06-17 14:45:03'),(11,'Ernestina Feil','Erwin32@yahoo.com','$2y$10$ljmFwSXmArPg8V9tGLBRkObCDAB75EIvOcDz.5EPKZyLOtu/qZYXi',1,NULL,'2015-06-17 14:45:03','2015-06-17 14:45:03'),(12,'Anahi Renner','Corkery.Berniece@hotmail.com','$2y$10$LHZmMi3pWKV.yzR61dhW6uSlay4S5hSSCKeM2yW05fnGAlDw7Ywn6',1,NULL,'2015-06-17 14:45:03','2015-06-17 14:45:03'),(13,'Noble Kihn','sFadel@gmail.com','$2y$10$KYLvaDeZMhOrVYxdMkbfHeRCos771PhfiNV7O2/E0olTfcjzF2tme',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(14,'Mr. Cyrus Renner','Kautzer.Benton@Padberg.biz','$2y$10$BM3Io6N989e4PQHaas6pDOKohiwRWoKNACeX6Qjw6iWRcSa7p0j0a',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(15,'Dr. Adeline Cormier','Doyle08@gmail.com','$2y$10$sE/lU9DNT3j/inI0bqPikuzPYnvzkzvCyjh6DYIknb/YP5gLanrHq',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(16,'Mrs. Golda Bogan DDS','pJaskolski@hotmail.com','$2y$10$q6bPqjlMYda90FHIDjmiguFIFtqUgJqeqeaX/4iQQb9QCm/8hpwcS',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(17,'Loyal Schmidt','Dibbert.Donnell@Terry.net','$2y$10$enBwCgSueqBVOwMck4Y/f.VHMCmRkyMwqtYGhLzbqFIgZqQn.nzRK',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(18,'Jerry Kunze Jr.','Keyshawn69@Hamill.com','$2y$10$/zcR612JcGJW4y13sOEiAuUlV88.JkW4w2Be6XMAGHmfTZ.xxI.Ve',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(19,'Colin Feil','Luther64@hotmail.com','$2y$10$xHWT7AfLDMyzeGaBgqg1VuOxw..Qdxcj4yKWpJ.xHjn5PiiBbahJS',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(20,'Domenic Orn II','Alaina.Oberbrunner@gmail.com','$2y$10$nlvJmxyiXCRuGa2Xgaer6.pd7jTtXRrp8AZZB5.iItSKqWOS/RMoq',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(21,'Zoe Koepp','Christopher19@hotmail.com','$2y$10$XGsKYfQA5JcHhUbNpNy0T.uy1EHvKG5G94SRyoYxLUWX524GmSxG.',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(22,'Titus Fritsch II','Delpha08@Ratke.org','$2y$10$ezOvGRBlq6Bekf/hQf/nqOtiCzWAMiiahJlVtF0C656rtEBaSA1Vm',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(23,'Ms. Tia Rippin','Gleichner.Anika@gmail.com','$2y$10$Em5q.qggv15pn9hMCYvlTuwKZ.6oHGuJjin30iAhm8hyED./InFA6',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04'),(24,'Cyrus Bruen','Gerhold.Amy@yahoo.com','$2y$10$VAZsguhspqKk6veaET8w4uMJmRTIZAAVfFvNvFOsXz.LJoLtHd9T2',1,NULL,'2015-06-17 14:45:04','2015-06-17 14:45:04');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `virtual_slide_providers`
--

DROP TABLE IF EXISTS `virtual_slide_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `virtual_slide_providers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `virtual_slide_providers`
--

LOCK TABLES `virtual_slide_providers` WRITE;
/*!40000 ALTER TABLE `virtual_slide_providers` DISABLE KEYS */;
INSERT INTO `virtual_slide_providers` VALUES (1,'Rosai Collection','http://www.rosaicollection.net/','2015-06-11 15:21:17','2015-06-11 15:21:17'),(2,'University of Leeds','http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','2015-06-11 15:22:26','2015-06-11 15:22:26'),(3,'University of Michigan','https://www.pathology.med.umich.edu/slides/index.php','2015-06-11 15:31:15','2015-06-11 15:31:15');
/*!40000 ALTER TABLE `virtual_slide_providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `virtual_slides`
--

DROP TABLE IF EXISTS `virtual_slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `virtual_slides` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stain` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci,
  `case_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `virtual_slides_url_unique` (`url`),
  KEY `virtual_slides_case_id_foreign` (`case_id`),
  CONSTRAINT `virtual_slides_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `virtual_slides`
--

LOCK TABLES `virtual_slides` WRITE;
/*!40000 ALTER TABLE `virtual_slides` DISABLE KEYS */;
INSERT INTO `virtual_slides` VALUES (1,'http://rosai.secondslide.com/sem235/sem235-case9.svs','HE','',1,'2015-06-11 10:10:46','2015-06-11 10:10:46'),(5,'http://129.11.191.7/Research_4/slide_Library/General_Teaching_Collection/126611.svs','HE','',2,'2015-06-11 10:19:58','2015-06-11 10:19:58'),(6,'http://129.11.191.7/Research_4/slide_Library/General_Teaching_Collection/126614.svs','HE','',2,'2015-06-11 10:19:58','2015-06-11 10:19:58'),(7,'http://129.11.191.7/Research_4/Teaching/Education/Postgraduate/Black_Box/11-Nov-10/127814.svs','PAP','Coded as C2',3,'2015-06-11 10:30:47','2015-06-11 10:30:47'),(8,'http://rosai.secondslide.com/sem23/sem23-case2.svs','HE','',4,'2015-06-11 10:41:02','2015-06-11 10:41:02'),(9,'http://rosai.secondslide.com/sem87/sem87-case2.svs','HE','',5,'2015-06-11 10:42:10','2015-06-11 10:42:10'),(10,'http://rosai.secondslide.com/sem114/sem114-case12.svs','HE','',6,'2015-06-11 10:44:37','2015-06-11 10:44:37'),(11,'http://rosai.secondslide.com/sem175/sem175-case9.svs','HE','',7,'2015-06-11 10:45:55','2015-06-11 10:45:55'),(12,'http://rosai.secondslide.com/sem264/sem264-case10.svs','HE','',8,'2015-06-11 10:46:59','2015-06-11 10:46:59'),(13,'http://rosai.secondslide.com/sem342/sem342-case14.svs','HE','',9,'2015-06-11 10:47:47','2015-06-11 10:47:47'),(14,'http://rosai.secondslide.com/sem538/sem538-case4.svs','HE','',10,'2015-06-11 10:49:02','2015-06-11 10:49:02'),(15,'http://rosai.secondslide.com/sem558/sem558-case11.svs','HE','',11,'2015-06-11 10:51:10','2015-06-11 10:51:10'),(16,'http://rosai.secondslide.com/sem582/sem582-case11.svs','HE','',12,'2015-06-11 10:53:34','2015-06-11 10:53:34'),(17,'http://129.11.191.7/Research_4/Teaching/EQA/General_Histopathology/Histo_EQA_CircAA_Set6/226018.svs','HE','',13,'2015-06-11 10:55:44','2015-06-11 10:55:44'),(18,'http://129.11.191.7/Research_4/Teaching/EQA/East_Midlands/Circulation_E/134115.svs','HE','',14,'2015-06-11 10:56:16','2015-06-11 10:56:16'),(19,'http://129.11.191.7/Research_4/slide_Library/General_Teaching_Collection/126585.svs','HE','',15,'2015-06-11 10:56:43','2015-06-11 10:56:43'),(20,'http://129.11.191.7/Research_4/slide_Library/General_Teaching_Collection/126561.svs','HE','',16,'2015-06-11 10:57:47','2015-06-11 10:57:47'),(21,'http://rosai.secondslide.com/sem40/sem40-case24.svs','HE','',17,'2015-06-11 11:00:41','2015-06-11 11:00:41'),(22,'http://rosai.secondslide.com/sem175/sem175-case11.svs','HE','',18,'2015-06-11 11:01:36','2015-06-11 11:01:36'),(23,'http://rosai.secondslide.com/sem235/sem235-case5.svs','HE','',19,'2015-06-11 11:02:16','2015-06-11 11:02:16'),(24,'http://rosai.secondslide.com/sem235/sem235-case12.svs','HE','',20,'2015-06-11 11:02:58','2015-06-11 11:02:58'),(25,'http://rosai.secondslide.com/sem251/sem251-case8.svs','HE','',21,'2015-06-11 11:03:56','2015-06-11 11:03:56'),(26,'http://rosai.secondslide.com/sem320/sem320-case4.svs','HE','',22,'2015-06-11 11:04:58','2015-06-11 11:04:58'),(27,'http://rosai.secondslide.com/sem353/sem353-case10.svs','HE','',23,'2015-06-11 11:05:35','2015-06-11 11:05:35'),(28,'http://129.11.191.7/Research_4/Slide_Library/R_Bishop_Collection/Card_index_Set/Breast/33540.svs','HE','',24,'2015-06-11 11:40:17','2015-06-11 11:40:17'),(29,'http://129.11.191.7/Research_4/Teaching/EQA/NW/Circ_V/51286.svs','HE','',25,'2015-06-11 11:40:45','2015-06-11 11:40:45');
/*!40000 ALTER TABLE `virtual_slides` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-17 14:45:28
