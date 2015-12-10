-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: iblis
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Table structure for table `facilities`
--

DROP TABLE IF EXISTS `facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facilities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
INSERT INTO `facilities` VALUES (1,'Bwaila Hospital','2015-11-06 07:51:09','2015-11-06 07:51:09'),(2,'Kawale Health Center','2015-11-06 07:51:23','2015-11-06 07:51:23'),(3,'Dowa District Hospital','2015-11-06 07:51:38','2015-11-06 07:51:38'),(4,'Lighthouse','2015-11-06 07:51:56','2015-11-06 07:51:56');
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wards`
--

DROP TABLE IF EXISTS `wards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wards`
--

LOCK TABLES `wards` WRITE;
/*!40000 ALTER TABLE `wards` DISABLE KEYS */;
INSERT INTO `wards` VALUES (1,'Ward 7A','2015-11-03 11:36:20','2015-11-03 11:36:20'),(2,'Ward 7B','2015-11-03 12:32:37','2015-11-03 12:32:37'),(3,'Ward 4A','2015-11-03 12:32:47','2015-11-03 12:32:47'),(4,'OPD 2','2015-11-04 10:00:57','2015-11-04 10:00:57'),(5,'Facilities','2015-11-04 10:09:30','2015-11-04 10:09:30'),(6,'OPD 1','2015-11-05 19:58:10','2015-11-05 19:58:10'),(7,'Ward 1A','2015-11-06 07:50:05','2015-11-06 07:50:05');
/*!40000 ALTER TABLE `wards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visit_types`
--

DROP TABLE IF EXISTS `visit_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visit_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit_types`
--

LOCK TABLES `visit_types` WRITE;
/*!40000 ALTER TABLE `visit_types` DISABLE KEYS */;
INSERT INTO `visit_types` VALUES (2,'In Patient','2015-11-03 11:05:21','2015-11-03 11:05:21'),(13,'Out Patient','2015-11-03 14:22:16','2015-11-03 14:22:16'),(15,'Referral','2015-11-04 10:01:45','2015-11-04 10:01:45');
/*!40000 ALTER TABLE `visit_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visittype_wards`
--

DROP TABLE IF EXISTS `visittype_wards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visittype_wards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `visit_type_id` int(10) unsigned NOT NULL,
  `ward_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visittype_wards_visit_type_id_foreign` (`visit_type_id`),
  KEY `visittype_wards_ward_id_foreign` (`ward_id`),
  CONSTRAINT `visittype_wards_visit_type_id_foreign` FOREIGN KEY (`visit_type_id`) REFERENCES `visit_types` (`id`),
  CONSTRAINT `visittype_wards_ward_id_foreign` FOREIGN KEY (`ward_id`) REFERENCES `wards` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visittype_wards`
--

LOCK TABLES `visittype_wards` WRITE;
/*!40000 ALTER TABLE `visittype_wards` DISABLE KEYS */;
INSERT INTO `visittype_wards` VALUES (23,2,3),(24,2,1),(25,2,2),(48,13,6),(49,13,4),(50,15,5);
/*!40000 ALTER TABLE `visittype_wards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_types`
--

DROP TABLE IF EXISTS `test_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `test_category_id` int(10) unsigned NOT NULL,
  `targetTAT` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orderable_test` int(11) DEFAULT NULL,
  `prevalence_threshold` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accredited` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `test_types_test_category_id_foreign` (`test_category_id`),
  CONSTRAINT `test_types_test_category_id_foreign` FOREIGN KEY (`test_category_id`) REFERENCES `test_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_types`
--

LOCK TABLES `test_types` WRITE;
/*!40000 ALTER TABLE `test_types` DISABLE KEYS */;
INSERT INTO `test_types` VALUES (1,'Microscopic Exam','',2,'20 min',1,'',NULL,NULL,'2015-11-03 13:49:09','2015-12-10 07:51:34'),(2,'Gene-Xpert','',2,'30 min',1,'',NULL,NULL,'2015-11-04 08:59:00','2015-11-12 17:29:59'),(3,'Gram Stain','',2,'30 min',1,'',NULL,NULL,'2015-11-05 12:29:16','2015-11-06 07:44:14'),(4,'Culture & Sensitivity','',2,'7 days',1,'',NULL,NULL,'2015-11-06 05:24:20','2015-12-09 14:52:03'),(5,'Cell Count','',2,'30 min',1,'',NULL,NULL,'2015-11-06 07:30:59','2015-11-12 21:09:08'),(6,'India Ink','',2,'30 min',1,'',NULL,NULL,'2015-11-06 07:32:32','2015-11-06 07:44:21'),(7,'Differential','',2,'30 min',1,'',NULL,NULL,'2015-11-06 07:43:01','2015-11-06 07:44:05'),(8,'ZN Stain','',2,'30 min',1,'',NULL,NULL,'2015-11-12 21:43:18','2015-11-12 21:43:18'),(9,'Wet prep','',2,'30 min',1,'',NULL,NULL,'2015-11-12 21:45:55','2015-11-12 21:45:55'),(10,'Macroscopic Exam','',2,'30 min',1,'',NULL,NULL,'2015-11-12 21:54:38','2015-11-12 21:55:29'),(11,'Urine Macroscopy','',1,'30 min',1,'',NULL,NULL,'2015-12-10 07:59:44','2015-12-10 07:59:44'),(12,'Urine Microscopy','',1,'30 min',1,'',NULL,NULL,'2015-12-10 08:06:20','2015-12-10 08:06:20'),(13,'Urine Chemistries','',1,'30 min',1,'',NULL,NULL,'2015-12-10 08:59:57','2015-12-10 08:59:57'),(14,'Stool Analysis','',1,'30 min',1,'',NULL,NULL,'2015-12-10 09:17:47','2015-12-10 09:17:47'),(15,'Malaria Screening','',1,'30 min',1,'',NULL,NULL,'2015-12-10 09:32:24','2015-12-10 09:32:24'),(16,'Blood Parasites Screen','',1,'',1,'',NULL,NULL,'2015-12-10 09:33:58','2015-12-10 09:33:58'),(17,'Semen Analysis','',1,'30 min',1,'',NULL,NULL,'2015-12-10 09:41:45','2015-12-10 09:41:45'),(18,'HVS analysis','',1,'',1,'',NULL,NULL,'2015-12-10 09:48:54','2015-12-10 09:48:54');
/*!40000 ALTER TABLE `test_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_statuses`
--

DROP TABLE IF EXISTS `test_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_statuses` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `test_phase_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `test_statuses_test_phase_id_foreign` (`test_phase_id`),
  CONSTRAINT `test_statuses_test_phase_id_foreign` FOREIGN KEY (`test_phase_id`) REFERENCES `test_phases` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_statuses`
--

LOCK TABLES `test_statuses` WRITE;
/*!40000 ALTER TABLE `test_statuses` DISABLE KEYS */;
INSERT INTO `test_statuses` VALUES (1,'not-received',1),(2,'pending',1),(3,'started',2),(4,'completed',3),(5,'verified',3);
/*!40000 ALTER TABLE `test_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testtype_specimentypes`
--

DROP TABLE IF EXISTS `testtype_specimentypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testtype_specimentypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_type_id` int(10) unsigned NOT NULL,
  `specimen_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `testtype_specimentypes_test_type_id_specimen_type_id_unique` (`test_type_id`,`specimen_type_id`),
  KEY `testtype_specimentypes_specimen_type_id_foreign` (`specimen_type_id`),
  CONSTRAINT `testtype_specimentypes_specimen_type_id_foreign` FOREIGN KEY (`specimen_type_id`) REFERENCES `specimen_types` (`id`),
  CONSTRAINT `testtype_specimentypes_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_specimentypes`
--

LOCK TABLES `testtype_specimentypes` WRITE;
/*!40000 ALTER TABLE `testtype_specimentypes` DISABLE KEYS */;
INSERT INTO `testtype_specimentypes` VALUES (182,1,1),(174,2,1),(173,2,2),(172,2,3),(107,3,1),(101,3,2),(99,3,3),(105,3,4),(98,3,5),(103,3,6),(104,3,7),(102,3,8),(100,3,9),(106,3,10),(108,3,11),(109,3,12),(181,4,1),(177,4,2),(176,4,3),(180,4,4),(175,4,5),(178,4,6),(179,4,7),(135,5,2),(138,5,4),(134,5,5),(136,5,6),(137,5,7),(80,6,2),(165,7,1),(161,7,2),(164,7,4),(160,7,5),(162,7,6),(163,7,7),(139,8,2),(140,9,2),(159,10,1),(155,10,2),(158,10,4),(154,10,5),(156,10,6),(157,10,7),(183,11,12),(193,12,12),(194,13,12),(188,14,11),(189,15,3),(190,16,3),(195,17,3),(196,18,8);
/*!40000 ALTER TABLE `testtype_specimentypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testtype_measures`
--

DROP TABLE IF EXISTS `testtype_measures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testtype_measures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_type_id` int(10) unsigned NOT NULL,
  `measure_id` int(10) unsigned NOT NULL,
  `ordering` tinyint(4) DEFAULT NULL,
  `nesting` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `testtype_measures_test_type_id_measure_id_unique` (`test_type_id`,`measure_id`),
  KEY `testtype_measures_measure_id_foreign` (`measure_id`),
  CONSTRAINT `testtype_measures_measure_id_foreign` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`),
  CONSTRAINT `testtype_measures_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_measures`
--

LOCK TABLES `testtype_measures` WRITE;
/*!40000 ALTER TABLE `testtype_measures` DISABLE KEYS */;
INSERT INTO `testtype_measures` VALUES (32,6,63,NULL,NULL),(38,3,67,NULL,NULL),(39,3,68,NULL,NULL),(40,3,59,NULL,NULL),(47,5,61,NULL,NULL),(48,5,62,NULL,NULL),(49,8,69,NULL,NULL),(50,9,70,NULL,NULL),(51,9,71,NULL,NULL),(54,10,72,NULL,NULL),(55,7,73,NULL,NULL),(56,7,65,NULL,NULL),(57,7,66,NULL,NULL),(61,2,58,NULL,NULL),(62,4,60,NULL,NULL),(63,1,52,NULL,NULL),(64,11,74,NULL,NULL),(65,11,75,NULL,NULL),(103,14,93,NULL,NULL),(104,14,94,NULL,NULL),(105,14,95,NULL,NULL),(106,15,96,NULL,NULL),(107,15,97,NULL,NULL),(108,15,98,NULL,NULL),(109,16,99,NULL,NULL),(122,12,76,NULL,NULL),(123,12,77,NULL,NULL),(124,12,78,NULL,NULL),(125,12,79,NULL,NULL),(126,12,80,NULL,NULL),(127,12,81,NULL,NULL),(128,12,82,NULL,NULL),(129,13,83,NULL,NULL),(130,13,84,NULL,NULL),(131,13,85,NULL,NULL),(132,13,86,NULL,NULL),(133,13,87,NULL,NULL),(134,13,88,NULL,NULL),(135,13,89,NULL,NULL),(136,13,90,NULL,NULL),(137,13,91,NULL,NULL),(138,13,92,NULL,NULL),(139,17,100,NULL,NULL),(140,17,101,NULL,NULL),(141,17,102,NULL,NULL),(142,17,103,NULL,NULL),(143,17,104,NULL,NULL),(144,17,105,NULL,NULL),(145,17,106,NULL,NULL),(146,18,107,NULL,NULL),(147,18,108,NULL,NULL),(148,18,109,NULL,NULL),(149,18,110,NULL,NULL),(150,18,111,NULL,NULL);
/*!40000 ALTER TABLE `testtype_measures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testtype_organisms`
--

DROP TABLE IF EXISTS `testtype_organisms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testtype_organisms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_type_id` int(10) unsigned NOT NULL,
  `organism_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `testtype_organisms_test_type_id_organism_id_unique` (`test_type_id`,`organism_id`),
  KEY `testtype_organisms_organism_id_foreign` (`organism_id`),
  CONSTRAINT `testtype_organisms_organism_id_foreign` FOREIGN KEY (`organism_id`) REFERENCES `organisms` (`id`),
  CONSTRAINT `testtype_organisms_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_organisms`
--

LOCK TABLES `testtype_organisms` WRITE;
/*!40000 ALTER TABLE `testtype_organisms` DISABLE KEYS */;
INSERT INTO `testtype_organisms` VALUES (51,4,1,NULL,'2015-12-09 14:52:03','2015-12-09 14:52:03'),(52,4,5,NULL,'2015-12-09 14:52:03','2015-12-09 14:52:03'),(53,4,4,NULL,'2015-12-09 14:52:03','2015-12-09 14:52:03'),(54,4,2,NULL,'2015-12-09 14:52:03','2015-12-09 14:52:03'),(55,4,3,NULL,'2015-12-09 14:52:03','2015-12-09 14:52:03');
/*!40000 ALTER TABLE `testtype_organisms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_categories`
--

DROP TABLE IF EXISTS `test_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `test_categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_categories`
--

LOCK TABLES `test_categories` WRITE;
/*!40000 ALTER TABLE `test_categories` DISABLE KEYS */;
INSERT INTO `test_categories` VALUES (1,'Parasitology','',NULL,'2015-11-03 11:05:20','2015-11-17 17:29:56'),(2,'Microbiology','',NULL,'2015-11-03 11:05:20','2015-11-17 17:29:41'),(3,'Haematology','',NULL,'2015-11-03 11:05:20','2015-11-17 17:30:35'),(4,'Serology','',NULL,'2015-11-03 11:05:20','2015-11-17 17:30:56'),(5,'Blood Bank','',NULL,'2015-11-03 11:05:20','2015-11-17 17:30:08'),(6,'Lab Reception','',NULL,'2015-11-04 09:34:28','2015-11-17 17:30:45'),(7,'Biochemistry','',NULL,'2015-11-04 09:37:13','2015-11-17 17:29:22'),(8,'Flow Cytometry','',NULL,'2015-11-04 09:37:25','2015-11-17 17:30:25');
/*!40000 ALTER TABLE `test_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_types`
--

DROP TABLE IF EXISTS `specimen_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specimen_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_types`
--

LOCK TABLES `specimen_types` WRITE;
/*!40000 ALTER TABLE `specimen_types` DISABLE KEYS */;
INSERT INTO `specimen_types` VALUES (1,'Sputum','',NULL,'2015-11-03 13:48:09','2015-11-03 13:48:09'),(2,'CSF','',NULL,'2015-11-04 08:34:37','2015-11-04 08:34:37'),(3,'Blood','',NULL,'2015-11-04 08:34:49','2015-11-04 08:34:49'),(4,'Pleural Fluid','',NULL,'2015-11-04 09:42:58','2015-11-04 09:42:58'),(5,'Ascitic Fluid','',NULL,'2015-11-04 09:43:07','2015-11-04 09:43:07'),(6,'Pericardial Fluid','',NULL,'2015-11-04 09:43:16','2015-11-04 09:43:16'),(7,'Peritoneal Fluid','',NULL,'2015-11-04 09:43:32','2015-11-04 09:43:32'),(8,'HVS','',NULL,'2015-11-04 09:43:53','2015-11-04 09:43:53'),(9,'Cervical Swab','',NULL,'2015-11-04 09:44:01','2015-11-04 09:44:01'),(10,'Pus','',NULL,'2015-11-04 09:44:08','2015-11-04 09:44:08'),(11,'Stool','',NULL,'2015-11-04 09:44:21','2015-11-04 09:44:21'),(12,'Urine','',NULL,'2015-11-04 09:44:32','2015-11-04 09:44:32'),(13,'Other','',NULL,'2015-11-04 09:44:46','2015-11-04 09:44:46');
/*!40000 ALTER TABLE `specimen_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_statuses`
--

DROP TABLE IF EXISTS `specimen_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specimen_statuses` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_statuses`
--

LOCK TABLES `specimen_statuses` WRITE;
/*!40000 ALTER TABLE `specimen_statuses` DISABLE KEYS */;
INSERT INTO `specimen_statuses` VALUES (1,'specimen-not-collected'),(2,'specimen-accepted'),(3,'specimen-rejected');
/*!40000 ALTER TABLE `specimen_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Superadmin',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21'),(2,'Technologist',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21'),(3,'Receptionist',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organisms`
--

DROP TABLE IF EXISTS `organisms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organisms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `organisms_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisms`
--

LOCK TABLES `organisms` WRITE;
/*!40000 ALTER TABLE `organisms` DISABLE KEYS */;
INSERT INTO `organisms` VALUES (1,'Haemophilus influenza',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(2,'Staphylococci',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(3,'Streptococcus pneumoniae',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(4,'Pseudomonas aeruginosa',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(5,'Neisseria meningitides',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(6,'Enterococci','',NULL,'2015-11-23 13:02:18','2015-11-23 13:02:18'),(7,'ß-hemolytic streptococci','',NULL,'2015-11-23 13:05:35','2015-11-23 13:05:35'),(8,'S.pneumoniae','',NULL,'2015-11-23 13:07:22','2015-11-23 13:07:22'),(9,'S. aureus','',NULL,'2015-11-23 13:09:52','2015-11-23 13:09:52'),(10,'Salmonellae','',NULL,'2015-11-23 13:10:13','2015-11-23 13:10:13'),(11,'Pseudomonas','',NULL,'2015-11-23 13:13:44','2015-11-23 13:13:44'),(12,'Enterobacteriaceae','',NULL,'2015-11-23 13:16:29','2015-11-23 13:16:29'),(13,'Other non-fastidious growth bacteria','',NULL,'2015-11-23 13:22:58','2015-11-23 13:22:58');
/*!40000 ALTER TABLE `organisms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organism_drugs`
--

DROP TABLE IF EXISTS `organism_drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organism_drugs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organism_id` int(10) unsigned NOT NULL,
  `drug_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `organism_drugs_organism_id_drug_id_unique` (`organism_id`,`drug_id`),
  KEY `organism_drugs_drug_id_foreign` (`drug_id`),
  CONSTRAINT `organism_drugs_drug_id_foreign` FOREIGN KEY (`drug_id`) REFERENCES `drugs` (`id`),
  CONSTRAINT `organism_drugs_organism_id_foreign` FOREIGN KEY (`organism_id`) REFERENCES `organisms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organism_drugs`
--

LOCK TABLES `organism_drugs` WRITE;
/*!40000 ALTER TABLE `organism_drugs` DISABLE KEYS */;
INSERT INTO `organism_drugs` VALUES (1,1,1,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,2,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,1,17,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,1,4,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,1,5,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,1,7,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,1,13,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,2,2,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,2,4,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(10,2,5,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,2,7,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,2,8,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,2,9,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,2,10,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,2,11,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(16,2,12,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(17,3,4,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(18,3,7,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(19,3,8,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(20,3,9,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(21,3,12,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(22,3,13,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(23,4,15,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(24,4,5,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(25,4,10,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(26,4,14,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(27,4,16,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(28,5,3,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(29,5,4,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(30,5,5,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(31,5,7,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(32,5,17,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(33,5,18,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(34,6,2,NULL,'2015-11-23 13:02:18','2015-11-23 13:02:18'),(35,6,4,NULL,'2015-11-23 13:02:18','2015-11-23 13:02:18'),(36,6,9,NULL,'2015-11-23 13:02:18','2015-11-23 13:02:18'),(37,6,6,NULL,'2015-11-23 13:02:18','2015-11-23 13:02:18'),(38,6,19,NULL,'2015-11-23 13:02:18','2015-11-23 13:02:18'),(39,7,2,NULL,'2015-11-23 13:05:35','2015-11-23 13:05:35'),(40,7,4,NULL,'2015-11-23 13:05:35','2015-11-23 13:05:35'),(41,7,8,NULL,'2015-11-23 13:05:35','2015-11-23 13:05:35'),(42,7,9,NULL,'2015-11-23 13:05:35','2015-11-23 13:05:35'),(43,7,11,NULL,'2015-11-23 13:05:35','2015-11-23 13:05:35'),(44,7,6,NULL,'2015-11-23 13:05:35','2015-11-23 13:05:35'),(45,8,17,NULL,'2015-11-23 13:07:22','2015-11-23 13:07:22'),(46,8,4,NULL,'2015-11-23 13:07:22','2015-11-23 13:07:22'),(47,8,9,NULL,'2015-11-23 13:07:22','2015-11-23 13:07:22'),(48,8,12,NULL,'2015-11-23 13:07:22','2015-11-23 13:07:22'),(49,8,6,NULL,'2015-11-23 13:07:22','2015-11-23 13:07:22'),(50,8,7,NULL,'2015-11-23 13:07:22','2015-11-23 13:07:22'),(52,9,2,NULL,'2015-11-23 13:11:24','2015-11-23 13:11:24'),(53,9,20,NULL,'2015-11-23 13:11:24','2015-11-23 13:11:24'),(54,9,4,NULL,'2015-11-23 13:11:24','2015-11-23 13:11:24'),(55,9,5,NULL,'2015-11-23 13:11:24','2015-11-23 13:11:24'),(56,9,8,NULL,'2015-11-23 13:11:24','2015-11-23 13:11:24'),(57,9,9,NULL,'2015-11-23 13:11:24','2015-11-23 13:11:24'),(58,9,11,NULL,'2015-11-23 13:11:24','2015-11-23 13:11:24'),(59,10,22,NULL,'2015-11-23 13:12:47','2015-11-23 13:12:47'),(60,10,15,NULL,'2015-11-23 13:12:47','2015-11-23 13:12:47'),(61,10,16,NULL,'2015-11-23 13:12:47','2015-11-23 13:12:47'),(62,11,14,NULL,'2015-11-23 13:13:44','2015-11-23 13:13:44'),(63,11,5,NULL,'2015-11-23 13:13:44','2015-11-23 13:13:44'),(64,11,10,NULL,'2015-11-23 13:13:44','2015-11-23 13:13:44'),(65,11,15,NULL,'2015-11-23 13:13:44','2015-11-23 13:13:44'),(66,11,16,NULL,'2015-11-23 13:13:44','2015-11-23 13:13:44'),(79,12,24,NULL,'2015-11-23 13:21:45','2015-11-23 13:21:45'),(80,12,1,NULL,'2015-11-23 13:21:45','2015-11-23 13:21:45'),(81,12,2,NULL,'2015-11-23 13:21:45','2015-11-23 13:21:45'),(82,12,26,NULL,'2015-11-23 13:21:45','2015-11-23 13:21:45'),(83,12,18,NULL,'2015-11-23 13:21:45','2015-11-23 13:21:45'),(84,12,17,NULL,'2015-11-23 13:21:45','2015-11-23 13:21:45'),(85,12,25,NULL,'2015-11-23 13:21:45','2015-11-23 13:21:45'),(86,12,4,NULL,'2015-11-23 13:21:45','2015-11-23 13:21:45'),(87,13,5,NULL,'2015-11-23 13:22:58','2015-11-23 13:22:58'),(88,13,10,NULL,'2015-11-23 13:22:58','2015-11-23 13:22:58'),(89,13,13,NULL,'2015-11-23 13:22:58','2015-11-23 13:22:58'),(90,13,7,NULL,'2015-11-23 13:22:58','2015-11-23 13:22:58');
/*!40000 ALTER TABLE `organism_drugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measures`
--

DROP TABLE IF EXISTS `measures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `measure_type_id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `measures_measure_type_id_foreign` (`measure_type_id`),
  CONSTRAINT `measures_measure_type_id_foreign` FOREIGN KEY (`measure_type_id`) REFERENCES `measure_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measures`
--

LOCK TABLES `measures` WRITE;
/*!40000 ALTER TABLE `measures` DISABLE KEYS */;
INSERT INTO `measures` VALUES (1,2,'BS for mps','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(2,2,'Grams stain','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(3,2,'SERUM AMYLASE','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(4,2,'calcium','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(5,2,'SGOT','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(6,2,'Indirect COOMBS test','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(7,2,'Direct COOMBS test','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(8,2,'Du test','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(9,1,'URIC ACID','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(10,4,'CSF for biochemistry','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(11,4,'PSA','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(12,1,'Total','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(13,1,'Alkaline Phosphate','u/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(14,1,'Direct','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(15,1,'Total Proteins','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(16,4,'LFTS','NULL',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(17,1,'Chloride','mmol/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(18,1,'Potassium','mmol/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(19,1,'Sodium','mmol/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(20,4,'Electrolytes','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(21,1,'Creatinine','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(22,1,'Urea','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(23,4,'RFTS','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(24,4,'TFT','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(25,4,'GXM','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(26,2,'Blood Grouping','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(27,1,'HB','g/dL',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(28,4,'Urine microscopy','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(29,4,'Pus cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(30,4,'S. haematobium','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(31,4,'T. vaginalis','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(32,4,'Yeast cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(33,4,'Red blood cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(34,4,'Bacteria','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(35,4,'Spermatozoa','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(36,4,'Epithelial cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(37,4,'ph','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(38,4,'Urine chemistry','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(39,4,'Glucose','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(40,4,'Ketones','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(41,4,'Proteins','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(42,4,'Blood','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(43,4,'Bilirubin','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(44,4,'Urobilinogen Phenlpyruvic acid','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(45,4,'pH','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(46,1,'WBC','x10³/µL',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(47,1,'Lym','L',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(48,1,'Mon','*',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(49,1,'Neu','*',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(50,1,'Eos','',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21',NULL),(51,1,'Baso','',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21',NULL),(52,4,'tb','','','2015-11-03 13:49:09','2015-11-03 13:49:09',NULL),(53,4,'Sample Location (Swab)','','','2015-11-04 08:59:00','2015-11-04 08:59:00',NULL),(54,4,'Sample Appearance (Fluids)','','','2015-11-04 08:59:00','2015-11-04 08:59:00',NULL),(55,2,'Culture','','','2015-11-04 08:59:00','2015-11-04 08:59:00',NULL),(56,2,'Gram Stain','','','2015-11-04 08:59:01','2015-11-04 08:59:01',NULL),(57,2,'Gram Stain Morphology','','','2015-11-04 08:59:01','2015-11-04 08:59:01',NULL),(58,2,'GeneXpert','','','2015-11-04 08:59:01','2015-12-02 14:26:42',NULL),(59,2,'gram','','','2015-11-05 12:29:16','2015-11-06 07:37:36',NULL),(60,2,'culture','','','2015-11-06 05:24:20','2015-11-06 05:24:20',NULL),(61,1,'wbc','cells/cu.mm','','2015-11-06 07:30:59','2015-11-12 19:49:08',NULL),(62,1,'rbc','cells/cu.mm','','2015-11-06 07:30:59','2015-11-12 19:49:08',NULL),(63,2,'india ink','','','2015-11-06 07:32:32','2015-11-06 07:32:32',NULL),(64,2,'gram morphology','','','2015-11-06 07:37:36','2015-11-06 07:37:36',NULL),(65,1,'polymorphs','%','','2015-11-06 07:43:01','2015-11-06 07:43:01',NULL),(66,1,'lymphocytes','%','','2015-11-06 07:43:01','2015-11-06 07:43:01',NULL),(67,2,'Clue cells','','','2015-11-12 17:50:25','2015-11-12 17:50:25',NULL),(68,4,'Other Organism Seen','','','2015-11-12 17:50:25','2015-11-12 17:50:25',NULL),(69,2,'zn','','','2015-11-12 21:43:18','2015-11-12 21:43:18',NULL),(70,2,'wet prep','','','2015-11-12 21:45:55','2015-11-12 21:45:55',NULL),(71,4,'Other Organism Seen','','','2015-11-12 21:45:55','2015-11-12 21:45:55',NULL),(72,2,'macro exam','','','2015-11-12 21:54:38','2015-11-12 21:54:38',NULL),(73,2,'diff remarks','','','2015-11-12 22:01:00','2015-11-12 22:01:00',NULL),(74,2,'Colour','','','2015-12-10 07:59:44','2015-12-10 07:59:44',NULL),(75,2,'Appearance','','','2015-12-10 07:59:44','2015-12-10 07:59:44',NULL),(76,1,'WBC','cmm','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL),(77,1,'RBC','cmm','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL),(78,2,'Epithelial Cells','','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL),(79,4,'Casts','','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL),(80,4,'Crystals','','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL),(81,4,'Parasites','','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL),(82,2,'Yeast Cells','','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL),(83,2,'Blood','RBC/ul','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(84,1,'Urobilinogen','mg/dl','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(85,2,'Bilirubin','','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(86,2,'Protein','','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(87,1,'Protein','mg/dl','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(88,2,'Nitrate','','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(89,2,'Ketones','','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(90,1,'Glucose','mg/dl','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(91,1,'Specific Gravity','','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(92,1,'Leucocytes','WBC/ul','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL),(93,4,'Macroscopy','','','2015-12-10 09:17:47','2015-12-10 09:17:47',NULL),(94,2,'Consistency','','','2015-12-10 09:17:47','2015-12-10 09:17:47',NULL),(95,4,'Microscopy','','','2015-12-10 09:17:47','2015-12-10 09:17:47',NULL),(96,2,'Blood film','','','2015-12-10 09:32:24','2015-12-10 09:32:24',NULL),(97,2,'Type of malaria parasite','','','2015-12-10 09:32:24','2015-12-10 09:32:24',NULL),(98,2,'MRDT','','','2015-12-10 09:32:24','2015-12-10 09:32:24',NULL),(99,4,'Blood film','','','2015-12-10 09:33:58','2015-12-10 09:33:58',NULL),(100,2,'Appearance','','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL),(101,4,'Liquifaction time','','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL),(102,1,'volume','ml','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL),(103,1,'Motility','%','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL),(104,1,'pH','','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL),(105,1,'Sperm Count','','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL),(106,4,'Sperm Morphology','','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL),(107,2,'Macroscopy','','','2015-12-10 09:48:54','2015-12-10 09:48:54',NULL),(108,1,'WBC','cmm','','2015-12-10 09:48:54','2015-12-10 09:48:54',NULL),(109,2,'Epithelial cells','','','2015-12-10 09:48:54','2015-12-10 09:48:54',NULL),(110,4,'Parasites/Bacteria','','','2015-12-10 09:48:54','2015-12-10 09:48:54',NULL),(111,2,'Spermatozoa','','','2015-12-10 09:48:54','2015-12-10 09:48:54',NULL);
/*!40000 ALTER TABLE `measures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measure_types`
--

DROP TABLE IF EXISTS `measure_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measure_types` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `measure_types_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure_types`
--

LOCK TABLES `measure_types` WRITE;
/*!40000 ALTER TABLE `measure_types` DISABLE KEYS */;
INSERT INTO `measure_types` VALUES (1,'Numeric Range',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(2,'Alphanumeric Values',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(3,'Autocomplete',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(4,'Free Text',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20');
/*!40000 ALTER TABLE `measure_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measure_ranges`
--

DROP TABLE IF EXISTS `measure_ranges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measure_ranges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `measure_id` int(10) unsigned NOT NULL,
  `age_min` int(10) unsigned DEFAULT NULL,
  `age_max` int(10) unsigned DEFAULT NULL,
  `gender` tinyint(3) unsigned DEFAULT NULL,
  `range_lower` decimal(11,3) DEFAULT NULL,
  `range_upper` decimal(11,3) DEFAULT NULL,
  `alphanumeric` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interpretation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `measure_ranges_alphanumeric_index` (`alphanumeric`),
  KEY `measure_ranges_measure_id_foreign` (`measure_id`),
  CONSTRAINT `measure_ranges_measure_id_foreign` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure_ranges`
--

LOCK TABLES `measure_ranges` WRITE;
/*!40000 ALTER TABLE `measure_ranges` DISABLE KEYS */;
INSERT INTO `measure_ranges` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,'No mps seen','Negative',NULL),(2,1,NULL,NULL,NULL,NULL,NULL,'+','Positive',NULL),(3,1,NULL,NULL,NULL,NULL,NULL,'++','Positive',NULL),(4,1,NULL,NULL,NULL,NULL,NULL,'+++','Positive',NULL),(5,2,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(6,2,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(7,3,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL),(8,3,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL),(9,3,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL),(10,4,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL),(11,4,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL),(12,4,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL),(13,5,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL),(14,5,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL),(15,5,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL),(16,6,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(17,6,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(18,7,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(19,7,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(20,8,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(21,8,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(22,26,NULL,NULL,NULL,NULL,NULL,'O-',NULL,NULL),(23,26,NULL,NULL,NULL,NULL,NULL,'O+',NULL,NULL),(24,26,NULL,NULL,NULL,NULL,NULL,'A-',NULL,NULL),(25,26,NULL,NULL,NULL,NULL,NULL,'A+',NULL,NULL),(26,26,NULL,NULL,NULL,NULL,NULL,'B-',NULL,NULL),(27,26,NULL,NULL,NULL,NULL,NULL,'B+',NULL,NULL),(28,26,NULL,NULL,NULL,NULL,NULL,'AB-',NULL,NULL),(29,26,NULL,NULL,NULL,NULL,NULL,'AB+',NULL,NULL),(30,46,0,100,2,4.000,11.000,NULL,NULL,NULL),(31,47,0,100,2,1.500,4.000,NULL,NULL,NULL),(32,48,0,100,2,0.100,9.000,NULL,NULL,NULL),(33,49,0,100,2,2.500,7.000,NULL,NULL,NULL),(34,50,0,100,2,0.000,6.000,NULL,NULL,NULL),(35,51,0,100,2,0.000,2.000,NULL,NULL,NULL),(36,55,NULL,NULL,NULL,NULL,NULL,'Not performed','',NULL),(37,55,NULL,NULL,NULL,NULL,NULL,'No growth 24 hrs','',NULL),(38,55,NULL,NULL,NULL,NULL,NULL,'No growth 48 hrs','',NULL),(39,55,NULL,NULL,NULL,NULL,NULL,'No growth 72 hrs','NEGATIVE',NULL),(40,55,NULL,NULL,NULL,NULL,NULL,'Growth','POSITIVE',NULL),(41,56,NULL,NULL,NULL,NULL,NULL,'Gram Positve','',NULL),(42,56,NULL,NULL,NULL,NULL,NULL,'Gram Negative','',NULL),(43,56,NULL,NULL,NULL,NULL,NULL,'Gram Variable','',NULL),(44,57,NULL,NULL,NULL,NULL,NULL,'Cocci','',NULL),(45,57,NULL,NULL,NULL,NULL,NULL,'Bacilli','',NULL),(46,57,NULL,NULL,NULL,NULL,NULL,'Cocci-Bacilli','',NULL),(47,57,NULL,NULL,NULL,NULL,NULL,'Diplococci','',NULL),(48,57,NULL,NULL,NULL,NULL,NULL,'Yeast','',NULL),(49,57,NULL,NULL,NULL,NULL,NULL,'Other','',NULL),(50,60,NULL,NULL,NULL,NULL,NULL,'Growth','POSITIVE',NULL),(51,60,NULL,NULL,NULL,NULL,NULL,'No growth','',NULL),(52,60,NULL,NULL,NULL,NULL,NULL,'Mixed growth; no predominant organism','',NULL),(53,60,NULL,NULL,NULL,NULL,NULL,'Growth of normal flora; no pathogens isolated','',NULL),(54,61,0,120,2,0.000,9999.999,NULL,'',NULL),(55,62,0,120,2,0.000,9999.999,NULL,'',NULL),(56,63,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL),(57,63,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL),(58,64,NULL,NULL,NULL,NULL,NULL,'Cocci','',NULL),(59,64,NULL,NULL,NULL,NULL,NULL,'Bacilli','',NULL),(60,64,NULL,NULL,NULL,NULL,NULL,'Cocco-bacilli','',NULL),(61,59,NULL,NULL,NULL,NULL,NULL,'No organism seen','',NULL),(62,59,NULL,NULL,NULL,NULL,NULL,'Gram Positive cocci (clusters)','',NULL),(63,59,NULL,NULL,NULL,NULL,NULL,'Gram positive cocci (chains)','',NULL),(64,65,0,120,2,0.000,100.000,NULL,'',NULL),(65,66,0,120,2,0.000,100.000,NULL,'',NULL),(66,67,NULL,NULL,NULL,NULL,NULL,'Yes','',NULL),(67,67,NULL,NULL,NULL,NULL,NULL,'No','',NULL),(68,59,NULL,NULL,NULL,NULL,NULL,'Gram Positive diplococci','',NULL),(69,59,NULL,NULL,NULL,NULL,NULL,'Gram positive Bacilli','',NULL),(70,59,NULL,NULL,NULL,NULL,NULL,'Gram positive cocco-bacilli','',NULL),(71,59,NULL,NULL,NULL,NULL,NULL,'Gram negative cocci','',NULL),(72,59,NULL,NULL,NULL,NULL,NULL,'Gram negative Bacilli','',NULL),(73,59,NULL,NULL,NULL,NULL,NULL,'Gram negative cocco-bacilli','',NULL),(74,59,NULL,NULL,NULL,NULL,NULL,'Gram negative diplococci','',NULL),(75,59,NULL,NULL,NULL,NULL,NULL,'ram variable cocci','',NULL),(76,59,NULL,NULL,NULL,NULL,NULL,'Gram variable  bacilli','',NULL),(77,59,NULL,NULL,NULL,NULL,NULL,'Gram variable cocco-bacilli','',NULL),(78,59,NULL,NULL,NULL,NULL,NULL,'Yeast cells seen','',NULL),(79,60,NULL,NULL,NULL,NULL,NULL,'Growth of contaminants','',NULL),(80,69,NULL,NULL,NULL,NULL,NULL,'Scanty AAFB Seen','',NULL),(81,69,NULL,NULL,NULL,NULL,NULL,'1+ AAFB Seen','',NULL),(82,69,NULL,NULL,NULL,NULL,NULL,'2+ AAFB Seen','',NULL),(83,69,NULL,NULL,NULL,NULL,NULL,'3+ AAFB Seen','',NULL),(84,69,NULL,NULL,NULL,NULL,NULL,'NO AAFB seen','',NULL),(85,70,NULL,NULL,NULL,NULL,NULL,'Trichomonas vaginalis seen','',NULL),(86,70,NULL,NULL,NULL,NULL,NULL,'Yeast cells seen','',NULL),(87,70,NULL,NULL,NULL,NULL,NULL,'Spermatozoa seen','',NULL),(88,72,NULL,NULL,NULL,NULL,NULL,'Clear/colourless','',NULL),(89,72,NULL,NULL,NULL,NULL,NULL,'Slightly Cloudy','',NULL),(90,72,NULL,NULL,NULL,NULL,NULL,'Purulent','',NULL),(91,72,NULL,NULL,NULL,NULL,NULL,'Clotted','',NULL),(92,72,NULL,NULL,NULL,NULL,NULL,'Turbid','',NULL),(93,72,NULL,NULL,NULL,NULL,NULL,'Blood stained','',NULL),(94,73,NULL,NULL,NULL,NULL,NULL,'Mainly lymphocytes','',NULL),(95,73,NULL,NULL,NULL,NULL,NULL,'Mainly polymorphs','',NULL),(96,73,NULL,NULL,NULL,NULL,NULL,'Not enough cells for differential count','',NULL),(97,73,NULL,NULL,NULL,NULL,NULL,'No cells seen','',NULL),(98,58,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL),(99,58,NULL,NULL,NULL,NULL,NULL,'Negative','Negative',NULL),(100,74,NULL,NULL,NULL,NULL,NULL,'Brown','',NULL),(101,74,NULL,NULL,NULL,NULL,NULL,'Red','',NULL),(102,74,NULL,NULL,NULL,NULL,NULL,'Pale','',NULL),(103,74,NULL,NULL,NULL,NULL,NULL,'Yellow','',NULL),(104,74,NULL,NULL,NULL,NULL,NULL,'Light Yellow','',NULL),(105,74,NULL,NULL,NULL,NULL,NULL,'Amber','',NULL),(106,75,NULL,NULL,NULL,NULL,NULL,'Cloudy','',NULL),(107,75,NULL,NULL,NULL,NULL,NULL,'Blood Stained','',NULL),(108,75,NULL,NULL,NULL,NULL,NULL,'Clear','',NULL),(109,76,0,120,2,0.000,1000000.000,NULL,'',NULL),(110,77,0,120,2,0.000,1000000.000,NULL,'',NULL),(111,78,NULL,NULL,NULL,NULL,NULL,'+','',NULL),(112,78,NULL,NULL,NULL,NULL,NULL,'++','',NULL),(113,78,NULL,NULL,NULL,NULL,NULL,'+++','',NULL),(114,82,NULL,NULL,NULL,NULL,NULL,'Seen','',NULL),(115,82,NULL,NULL,NULL,NULL,NULL,'Not Seen','',NULL),(116,83,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL),(117,83,NULL,NULL,NULL,NULL,NULL,'Heamolysis +10','',NULL),(118,83,NULL,NULL,NULL,NULL,NULL,'Heamolysis ++50','',NULL),(119,83,NULL,NULL,NULL,NULL,NULL,'Heamolysis+++250','',NULL),(120,83,NULL,NULL,NULL,NULL,NULL,'Non- Heamolysis +10','',NULL),(121,83,NULL,NULL,NULL,NULL,NULL,'Non- Heamolysis ++50','',NULL),(122,83,NULL,NULL,NULL,NULL,NULL,'','',NULL),(123,84,0,120,2,0.000,1000000.000,NULL,'',NULL),(124,85,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL),(125,85,NULL,NULL,NULL,NULL,NULL,'+','',NULL),(126,85,NULL,NULL,NULL,NULL,NULL,'++','',NULL),(127,85,NULL,NULL,NULL,NULL,NULL,'+++','',NULL),(128,86,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL),(129,86,NULL,NULL,NULL,NULL,NULL,'Trace','',NULL),(130,87,0,120,2,1.000,1000000.000,NULL,'',NULL),(131,88,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL),(132,88,NULL,NULL,NULL,NULL,NULL,'Trace','',NULL),(133,88,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL),(134,89,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL),(135,89,NULL,NULL,NULL,NULL,NULL,'Trace','',NULL),(136,89,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL),(137,90,0,120,2,0.000,0.000,NULL,'NEGATIVE',NULL),(138,90,0,120,2,1.000,1000000.000,NULL,'POSITIVE',NULL),(139,91,0,120,2,1.000,100000.000,NULL,'',NULL),(140,92,0,120,2,0.000,0.000,NULL,'NEGATIVE',NULL),(141,92,0,120,2,1.000,1000000.000,NULL,'POSITIVE',NULL),(142,94,NULL,NULL,NULL,NULL,NULL,'Formed','',NULL),(143,94,NULL,NULL,NULL,NULL,NULL,'Semi-formed','',NULL),(144,94,NULL,NULL,NULL,NULL,NULL,'Unformed','',NULL),(145,94,NULL,NULL,NULL,NULL,NULL,'Watery','',NULL),(146,94,NULL,NULL,NULL,NULL,NULL,'Rice appearance','',NULL),(147,96,NULL,NULL,NULL,NULL,NULL,'No parasite seen','',NULL),(148,96,NULL,NULL,NULL,NULL,NULL,'+ (1-10 parasites/100 fields)','',NULL),(149,96,NULL,NULL,NULL,NULL,NULL,'++ (11-99 parasites/100 field) ','',NULL),(150,96,NULL,NULL,NULL,NULL,NULL,'+++ (1-10 parasites /field)','',NULL),(151,96,NULL,NULL,NULL,NULL,NULL,'++++ (>10 parasites/field)','',NULL),(152,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium falciparum','',NULL),(153,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium Ovale','',NULL),(154,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium vivax','',NULL),(155,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium malariae','',NULL),(156,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium knowlesi','',NULL),(157,98,NULL,NULL,NULL,NULL,NULL,'Positive','',NULL),(158,98,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL),(159,100,NULL,NULL,NULL,NULL,NULL,'Grey','',NULL),(160,100,NULL,NULL,NULL,NULL,NULL,'Opaque','',NULL),(161,100,NULL,NULL,NULL,NULL,NULL,'Red-brown','',NULL),(162,100,NULL,NULL,NULL,NULL,NULL,'Opalescent','',NULL),(163,102,0,120,0,0.000,1000.000,NULL,'',NULL),(164,103,0,120,0,0.000,100.000,NULL,'',NULL),(165,104,0,120,0,0.000,100.000,NULL,'',NULL),(166,105,0,120,0,0.000,1000000.000,NULL,'',NULL),(167,107,NULL,NULL,NULL,NULL,NULL,'blood stained','',NULL),(168,107,NULL,NULL,NULL,NULL,NULL,'clear','',NULL),(169,108,0,120,2,0.000,1000000.000,NULL,'',NULL),(170,109,NULL,NULL,NULL,NULL,NULL,'+','',NULL),(171,109,NULL,NULL,NULL,NULL,NULL,'++','',NULL),(172,109,NULL,NULL,NULL,NULL,NULL,'+++','',NULL),(173,111,NULL,NULL,NULL,NULL,NULL,'Seen','',NULL),(174,111,NULL,NULL,NULL,NULL,NULL,'Not seen','',NULL);
/*!40000 ALTER TABLE `measure_ranges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drugs`
--

DROP TABLE IF EXISTS `drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `drugs_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drugs`
--

LOCK TABLES `drugs` WRITE;
/*!40000 ALTER TABLE `drugs` DISABLE KEYS */;
INSERT INTO `drugs` VALUES (1,'Amoxicillin/Clavulanate',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(2,'Ampicillin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(3,'Ceftriaxone',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(4,'Chloramphenicol',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(5,'Ciprofloxacin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(6,'Tetracyline',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(7,'Trimethoprim/Sulfamethoxazole',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(8,'Clindamycin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(9,'Erythromycin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(10,'Gentamicin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(11,'Penicillin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(12,'Oxacillin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(13,'Tetracycline',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(14,'Ceftazidime',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(15,'Piperacillin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(16,'Piperacillin/Tazobactam',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(17,'Ceftriaxon',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(18,'Cefotaxim',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(19,'Vancomycin','',NULL,'2015-11-23 13:01:00','2015-11-23 13:01:00'),(20,'Cefoxitin','',NULL,'2015-11-23 13:10:13','2015-11-23 13:10:13'),(21,'Tazobactam','',NULL,'2015-11-23 13:10:38','2015-11-23 13:10:38'),(22,'Naladixic Acid','',NULL,'2015-11-23 13:11:40','2015-11-23 13:11:40'),(23,'Sulbactam','',NULL,'2015-11-23 13:17:10','2015-11-23 13:17:10'),(24,'Amoxicillin','',NULL,'2015-11-23 13:19:35','2015-11-23 13:19:35'),(25,'Cefuroxime','',NULL,'2015-11-23 13:19:47','2015-11-23 13:19:47'),(26,'Ampicillin/Sulbactam','',NULL,'2015-11-23 13:21:15','2015-11-23 13:21:15');
/*!40000 ALTER TABLE `drugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1),(10,10,1),(11,11,1),(12,12,1),(13,13,1),(14,14,1),(15,15,1),(16,16,1),(17,17,1),(18,18,1),(19,19,1),(20,20,1),(21,1,1),(22,1,3),(23,2,1),(24,2,3),(25,3,1),(26,3,3),(27,4,1),(28,4,3),(29,5,1),(30,5,3),(31,6,1),(32,6,2),(33,7,1),(34,7,2),(35,8,1),(36,8,2),(37,9,1),(38,9,2),(39,10,1),(40,10,2),(41,11,1),(42,11,2),(43,12,1),(44,12,2),(45,13,1),(46,13,2),(47,14,1),(48,15,1),(49,16,1),(50,17,1),(51,17,2),(52,18,1),(53,19,1),(54,20,1),(55,1,1),(56,1,2),(57,1,3),(58,2,1),(59,2,2),(60,2,3),(61,3,1),(62,3,2),(63,3,3),(64,4,1),(65,4,3),(66,5,1),(67,5,2),(68,5,3),(69,6,1),(70,6,2),(71,7,1),(72,7,2),(73,8,1),(74,8,2),(75,9,1),(76,9,2),(77,10,1),(78,10,2),(79,11,1),(80,11,2),(81,12,1),(82,12,2),(83,13,1),(84,13,2),(85,14,1),(86,15,1),(87,16,1),(88,17,1),(89,17,2),(90,18,1),(91,19,1),(92,20,1);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `panel_types`
--

DROP TABLE IF EXISTS `panel_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `panel_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `panel_types`
--

LOCK TABLES `panel_types` WRITE;
/*!40000 ALTER TABLE `panel_types` DISABLE KEYS */;
INSERT INTO `panel_types` VALUES (1,'CSF Analysis','2015-11-08 16:58:13','2015-11-08 16:58:13',NULL),(2,'Urinalysis','2015-12-10 09:13:56','2015-12-10 09:13:56',NULL);
/*!40000 ALTER TABLE `panel_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `panels`
--

DROP TABLE IF EXISTS `panels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `panels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `panel_type_id` int(10) unsigned NOT NULL,
  `test_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `panels_panel_type_id_foreign` (`panel_type_id`),
  KEY `panels_test_type_id_foreign` (`test_type_id`),
  CONSTRAINT `panels_panel_type_id_foreign` FOREIGN KEY (`panel_type_id`) REFERENCES `panel_types` (`id`),
  CONSTRAINT `panels_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `panels`
--

LOCK TABLES `panels` WRITE;
/*!40000 ALTER TABLE `panels` DISABLE KEYS */;
INSERT INTO `panels` VALUES (1,1,5),(2,1,4),(3,1,7),(4,1,3),(5,1,6),(9,2,13),(10,2,11),(11,2,12);
/*!40000 ALTER TABLE `panels` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-10 11:48:04
