-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: iblis
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
-- Table structure for table `assigned_roles`
--

DROP TABLE IF EXISTS `assigned_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assigned_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assigned_roles_user_id_foreign` (`user_id`),
  KEY `assigned_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `assigned_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assigned_roles`
--

LOCK TABLES `assigned_roles` WRITE;
/*!40000 ALTER TABLE `assigned_roles` DISABLE KEYS */;
INSERT INTO `assigned_roles` VALUES (1,1,1);
/*!40000 ALTER TABLE `assigned_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commodities`
--

DROP TABLE IF EXISTS `commodities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commodities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `metric_id` int(10) unsigned NOT NULL,
  `unit_price` decimal(8,2) NOT NULL,
  `item_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `storage_req` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `min_level` int(11) NOT NULL,
  `max_level` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `commodities_metric_id_foreign` (`metric_id`),
  CONSTRAINT `commodities_metric_id_foreign` FOREIGN KEY (`metric_id`) REFERENCES `metrics` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commodities`
--

LOCK TABLES `commodities` WRITE;
/*!40000 ALTER TABLE `commodities` DISABLE KEYS */;
INSERT INTO `commodities` VALUES (1,'Ampicillin','Capsule 250mg',1,500.00,'no clue','no clue',100000,400000,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `commodities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `control_measure_ranges`
--

DROP TABLE IF EXISTS `control_measure_ranges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `control_measure_ranges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `upper_range` decimal(6,2) DEFAULT NULL,
  `lower_range` decimal(6,2) DEFAULT NULL,
  `alphanumeric` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `control_measure_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `control_measure_ranges_control_measure_id_foreign` (`control_measure_id`),
  CONSTRAINT `control_measure_ranges_control_measure_id_foreign` FOREIGN KEY (`control_measure_id`) REFERENCES `control_measures` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `control_measure_ranges`
--

LOCK TABLES `control_measure_ranges` WRITE;
/*!40000 ALTER TABLE `control_measure_ranges` DISABLE KEYS */;
INSERT INTO `control_measure_ranges` VALUES (1,2.63,7.19,NULL,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(2,11.65,15.43,NULL,2,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(3,12.13,19.11,NULL,3,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(4,15.73,25.01,NULL,4,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(5,17.63,20.12,NULL,5,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(6,6.50,7.50,NULL,6,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(7,4.36,5.78,NULL,7,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(8,13.80,17.30,NULL,8,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(9,81.00,95.00,NULL,9,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(10,1.99,2.63,NULL,10,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(11,27.60,33.00,NULL,11,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(12,32.80,36.40,NULL,12,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(13,141.00,320.00,NULL,13,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `control_measure_ranges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `control_measures`
--

DROP TABLE IF EXISTS `control_measures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `control_measures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `control_id` int(10) unsigned NOT NULL,
  `control_measure_type_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `control_measures_control_measure_type_id_foreign` (`control_measure_type_id`),
  KEY `control_measures_control_id_foreign` (`control_id`),
  CONSTRAINT `control_measures_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `controls` (`id`),
  CONSTRAINT `control_measures_control_measure_type_id_foreign` FOREIGN KEY (`control_measure_type_id`) REFERENCES `measure_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `control_measures`
--

LOCK TABLES `control_measures` WRITE;
/*!40000 ALTER TABLE `control_measures` DISABLE KEYS */;
INSERT INTO `control_measures` VALUES (1,'ca','mmol',1,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(2,'pi','mmol',1,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(3,'mg','mmol',1,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(4,'na','mmol',1,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(5,'K','mmol',1,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(6,'WBC','x 103/uL',2,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(7,'RBC','x 106/uL',2,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(8,'HGB','g/dl',2,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(9,'HCT','%',2,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(10,'MCV','fl',2,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(11,'MCH','pg',2,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(12,'MCHC','g/dl',2,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(13,'PLT','x 103/uL',2,1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `control_measures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `control_results`
--

DROP TABLE IF EXISTS `control_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `control_results` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `results` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `control_measure_id` int(10) unsigned NOT NULL,
  `control_test_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `control_results_control_test_id_foreign` (`control_test_id`),
  KEY `control_results_control_measure_id_foreign` (`control_measure_id`),
  CONSTRAINT `control_results_control_measure_id_foreign` FOREIGN KEY (`control_measure_id`) REFERENCES `control_measures` (`id`),
  CONSTRAINT `control_results_control_test_id_foreign` FOREIGN KEY (`control_test_id`) REFERENCES `control_tests` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `control_results`
--

LOCK TABLES `control_results` WRITE;
/*!40000 ALTER TABLE `control_results` DISABLE KEYS */;
INSERT INTO `control_results` VALUES (1,'2.78',1,1,'2015-10-16 22:00:00','2015-10-27 08:36:05'),(2,'13.56',2,1,'2015-10-16 22:00:00','2015-10-27 08:36:05'),(3,'14.77',3,1,'2015-10-16 22:00:00','2015-10-27 08:36:05'),(4,'25.92',4,1,'2015-10-16 22:00:00','2015-10-27 08:36:05'),(5,'18.87',5,1,'2015-10-16 22:00:00','2015-10-27 08:36:05'),(6,'6.78',1,2,'2015-10-17 22:00:00','2015-10-27 08:36:05'),(7,'15.56',2,2,'2015-10-17 22:00:00','2015-10-27 08:36:05'),(8,'18.77',3,2,'2015-10-17 22:00:00','2015-10-27 08:36:05'),(9,'30.92',4,2,'2015-10-17 22:00:00','2015-10-27 08:36:05'),(10,'17.87',5,2,'2015-10-17 22:00:00','2015-10-27 08:36:05'),(11,'8.78',1,3,'2015-10-18 22:00:00','2015-10-27 08:36:05'),(12,'17.56',2,3,'2015-10-18 22:00:00','2015-10-27 08:36:05'),(13,'21.77',3,3,'2015-10-18 22:00:00','2015-10-27 08:36:05'),(14,'27.92',4,3,'2015-10-18 22:00:00','2015-10-27 08:36:05'),(15,'22.87',5,3,'2015-10-18 22:00:00','2015-10-27 08:36:05'),(16,'6.78',1,4,'2015-10-19 22:00:00','2015-10-27 08:36:05'),(17,'18.56',2,4,'2015-10-19 22:00:00','2015-10-27 08:36:05'),(18,'19.77',3,4,'2015-10-19 22:00:00','2015-10-27 08:36:05'),(19,'12.92',4,4,'2015-10-19 22:00:00','2015-10-27 08:36:05'),(20,'22.87',5,4,'2015-10-19 22:00:00','2015-10-27 08:36:05'),(21,'3.78',1,5,'2015-10-20 22:00:00','2015-10-27 08:36:05'),(22,'16.56',2,5,'2015-10-20 22:00:00','2015-10-27 08:36:05'),(23,'17.77',3,5,'2015-10-20 22:00:00','2015-10-27 08:36:05'),(24,'28.92',4,5,'2015-10-20 22:00:00','2015-10-27 08:36:05'),(25,'19.87',5,5,'2015-10-20 22:00:00','2015-10-27 08:36:05'),(26,'5.78',1,6,'2015-10-21 22:00:00','2015-10-27 08:36:05'),(27,'15.56',2,6,'2015-10-21 22:00:00','2015-10-27 08:36:05'),(28,'11.77',3,6,'2015-10-21 22:00:00','2015-10-27 08:36:05'),(29,'29.92',4,6,'2015-10-21 22:00:00','2015-10-27 08:36:05'),(30,'14.87',5,6,'2015-10-21 22:00:00','2015-10-27 08:36:05'),(31,'9.78',1,7,'2015-10-22 22:00:00','2015-10-27 08:36:05'),(32,'11.56',2,7,'2015-10-22 22:00:00','2015-10-27 08:36:05'),(33,'19.77',3,7,'2015-10-22 22:00:00','2015-10-27 08:36:05'),(34,'32.92',4,7,'2015-10-22 22:00:00','2015-10-27 08:36:05'),(35,'29.87',5,7,'2015-10-22 22:00:00','2015-10-27 08:36:05'),(36,'5.45',6,8,'2015-10-23 22:00:00','2015-10-27 08:36:05'),(37,'5.01',7,8,'2015-10-23 22:00:00','2015-10-27 08:36:05'),(38,'12.3',8,8,'2015-10-23 22:00:00','2015-10-27 08:36:05'),(39,'89.7',9,8,'2015-10-23 22:00:00','2015-10-27 08:36:05'),(40,'2.15',10,8,'2015-10-23 22:00:00','2015-10-27 08:36:05'),(41,'34.0',11,8,'2015-10-23 22:00:00','2015-10-27 08:36:05'),(42,'37.2',12,8,'2015-10-23 22:00:00','2015-10-27 08:36:05'),(43,'141.5',13,8,'2015-10-23 22:00:00','2015-10-27 08:36:05'),(44,'7.45',6,9,'2015-10-24 22:00:00','2015-10-27 08:36:05'),(45,'9.01',7,9,'2015-10-24 22:00:00','2015-10-27 08:36:05'),(46,'9.3',8,9,'2015-10-24 22:00:00','2015-10-27 08:36:05'),(47,'94.7',9,9,'2015-10-24 22:00:00','2015-10-27 08:36:05'),(48,'12.15',10,9,'2015-10-24 22:00:00','2015-10-27 08:36:05'),(49,'37.0',11,9,'2015-10-24 22:00:00','2015-10-27 08:36:05'),(50,'30.2',12,9,'2015-10-24 22:00:00','2015-10-27 08:36:05'),(51,'121.5',13,9,'2015-10-24 22:00:00','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `control_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `control_tests`
--

DROP TABLE IF EXISTS `control_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `control_tests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entered_by` int(10) unsigned NOT NULL,
  `control_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `control_tests_control_id_foreign` (`control_id`),
  KEY `control_tests_entered_by_foreign` (`entered_by`),
  CONSTRAINT `control_tests_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `controls` (`id`),
  CONSTRAINT `control_tests_entered_by_foreign` FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `control_tests`
--

LOCK TABLES `control_tests` WRITE;
/*!40000 ALTER TABLE `control_tests` DISABLE KEYS */;
INSERT INTO `control_tests` VALUES (1,3,1,'2015-10-16 22:00:00','2015-10-27 08:36:05'),(2,3,1,'2015-10-17 22:00:00','2015-10-27 08:36:05'),(3,3,1,'2015-10-18 22:00:00','2015-10-27 08:36:05'),(4,3,1,'2015-10-19 22:00:00','2015-10-27 08:36:05'),(5,3,1,'2015-10-20 22:00:00','2015-10-27 08:36:05'),(6,3,1,'2015-10-21 22:00:00','2015-10-27 08:36:05'),(7,3,1,'2015-10-22 22:00:00','2015-10-27 08:36:05'),(8,1,2,'2015-10-23 22:00:00','2015-10-27 08:36:05'),(9,1,2,'2015-10-24 22:00:00','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `control_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controls`
--

DROP TABLE IF EXISTS `controls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `controls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lot_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controls_name_unique` (`name`),
  KEY `controls_lot_id_foreign` (`lot_id`),
  CONSTRAINT `controls_lot_id_foreign` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controls`
--

LOCK TABLES `controls` WRITE;
/*!40000 ALTER TABLE `controls` DISABLE KEYS */;
INSERT INTO `controls` VALUES (1,'Humatrol P','HUMATROL P control serum has been designed to provide a suitable basis for the quality control (imprecision, inaccuracy) in the clinical chemical laboratory.',1,'2015-10-27 08:36:05','2015-10-27 08:36:05',NULL),(2,'Full Blood Count','Né pas touchér',1,'2015-10-27 08:36:05','2015-10-27 08:36:05',NULL);
/*!40000 ALTER TABLE `controls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `culture_worksheet`
--

DROP TABLE IF EXISTS `culture_worksheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `culture_worksheet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `test_id` int(10) unsigned NOT NULL,
  `observation` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `culture_worksheet_user_id_foreign` (`user_id`),
  KEY `culture_worksheet_test_id_foreign` (`test_id`),
  CONSTRAINT `culture_worksheet_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`),
  CONSTRAINT `culture_worksheet_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `culture_worksheet`
--

LOCK TABLES `culture_worksheet` WRITE;
/*!40000 ALTER TABLE `culture_worksheet` DISABLE KEYS */;
/*!40000 ALTER TABLE `culture_worksheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diseases`
--

DROP TABLE IF EXISTS `diseases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diseases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diseases`
--

LOCK TABLES `diseases` WRITE;
/*!40000 ALTER TABLE `diseases` DISABLE KEYS */;
INSERT INTO `diseases` VALUES (1,'Malaria'),(2,'Typhoid'),(3,'Shigella Dysentry');
/*!40000 ALTER TABLE `diseases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drug_susceptibility`
--

DROP TABLE IF EXISTS `drug_susceptibility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drug_susceptibility` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `test_id` int(10) unsigned NOT NULL,
  `organism_id` int(10) unsigned NOT NULL,
  `drug_id` int(10) unsigned NOT NULL,
  `zone` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `interpretation` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `drug_susceptibility_user_id_foreign` (`user_id`),
  KEY `drug_susceptibility_test_id_foreign` (`test_id`),
  KEY `drug_susceptibility_organism_id_foreign` (`organism_id`),
  KEY `drug_susceptibility_drug_id_foreign` (`drug_id`),
  CONSTRAINT `drug_susceptibility_drug_id_foreign` FOREIGN KEY (`drug_id`) REFERENCES `drugs` (`id`),
  CONSTRAINT `drug_susceptibility_organism_id_foreign` FOREIGN KEY (`organism_id`) REFERENCES `organisms` (`id`),
  CONSTRAINT `drug_susceptibility_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`),
  CONSTRAINT `drug_susceptibility_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drug_susceptibility`
--

LOCK TABLES `drug_susceptibility` WRITE;
/*!40000 ALTER TABLE `drug_susceptibility` DISABLE KEYS */;
/*!40000 ALTER TABLE `drug_susceptibility` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drugs`
--

LOCK TABLES `drugs` WRITE;
/*!40000 ALTER TABLE `drugs` DISABLE KEYS */;
INSERT INTO `drugs` VALUES (1,'Amoxicillin/Clavulanate','',NULL,'2015-10-29 08:42:02','2015-10-29 08:42:02'),(2,'Ampicillin','',NULL,'2015-10-29 08:42:14','2015-10-29 08:42:14'),(3,'Ceftriaxone','',NULL,'2015-10-29 08:42:23','2015-10-29 08:42:23'),(4,'Chloramphenicol','',NULL,'2015-10-29 08:42:36','2015-10-29 08:42:36'),(5,'Ciprofloxacin','',NULL,'2015-10-29 08:42:46','2015-10-29 08:42:46'),(6,'Tetracyline','',NULL,'2015-10-29 08:42:55','2015-10-29 08:42:55'),(7,'Trimethoprim/Sulfamethoxazole','',NULL,'2015-10-29 08:43:09','2015-10-29 08:43:09'),(8,'Clindamycin','',NULL,'2015-10-29 08:45:52','2015-10-29 08:45:52'),(9,'Erythromycin','',NULL,'2015-10-29 08:46:10','2015-10-29 08:46:10'),(10,'Gentamicin','',NULL,'2015-10-29 08:46:19','2015-10-29 08:46:19'),(11,'Penicillin','',NULL,'2015-10-29 08:46:38','2015-10-29 08:46:38'),(12,'Oxacillin','',NULL,'2015-10-29 08:49:05','2015-10-29 08:49:10'),(13,'Tetracycline','',NULL,'2015-10-29 08:49:35','2015-10-29 08:49:35'),(14,'Ceftazidime','',NULL,'2015-10-29 08:50:43','2015-10-29 08:50:43'),(15,'Piperacillin','',NULL,'2015-10-29 08:50:57','2015-10-29 08:50:57'),(16,'Piperacillin/Tazobactam','',NULL,'2015-10-29 08:51:16','2015-10-29 08:51:47'),(17,'Ceftriaxon','',NULL,'2015-10-29 08:52:13','2015-10-29 08:52:13'),(18,'Cefotaxim','',NULL,'2015-10-29 08:52:22','2015-10-29 08:52:22');
/*!40000 ALTER TABLE `drugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_dump`
--

DROP TABLE IF EXISTS `external_dump`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `external_dump` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lab_no` int(11) NOT NULL,
  `parent_lab_no` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `requesting_clinician` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `investigation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provisional_diagnosis` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request_date` timestamp NULL DEFAULT NULL,
  `order_stage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `result` text COLLATE utf8_unicode_ci,
  `result_returned` int(11) DEFAULT NULL,
  `patient_visit_number` int(11) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cost` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receipt_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receipt_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `waiver_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `system_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `external_dump_lab_no_unique` (`lab_no`),
  KEY `external_dump_parent_lab_no_index` (`parent_lab_no`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_dump`
--

LOCK TABLES `external_dump` WRITE;
/*!40000 ALTER TABLE `external_dump` DISABLE KEYS */;
INSERT INTO `external_dump` VALUES (1,596699,0,16,'frankenstein Dr','Urinalysis','','2014-10-14 08:20:35','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(2,596700,596699,NULL,'frankenstein Dr','Urine microscopy','','2014-10-14 08:20:35','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(3,596701,596700,NULL,'frankenstein Dr','Pus cells','','2014-10-14 08:20:35','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(4,596702,596700,NULL,'frankenstein Dr','S. haematobium','','2014-10-14 08:20:35','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(5,596703,596700,NULL,'frankenstein Dr','T. vaginalis','','2014-10-14 08:20:35','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(6,596704,596700,NULL,'frankenstein Dr','Yeast cells','','2014-10-14 08:20:35','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(7,596705,596700,NULL,'frankenstein Dr','Red blood cells','','2014-10-14 08:20:35','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(8,596706,596700,NULL,'frankenstein Dr','Bacteria','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(9,596707,596700,NULL,'frankenstein Dr','Spermatozoa','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(10,596708,596700,NULL,'frankenstein Dr','Epithelial cells','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(11,596709,596700,NULL,'frankenstein Dr','ph','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(12,596710,596699,NULL,'frankenstein Dr','Urine chemistry','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(13,596711,596710,NULL,'frankenstein Dr','Glucose','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(14,596712,596710,NULL,'frankenstein Dr','Ketones','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(15,596713,596710,NULL,'frankenstein Dr','Proteins','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(16,596714,596710,NULL,'frankenstein Dr','Blood','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(17,596715,596710,NULL,'frankenstein Dr','Bilirubin','','2014-10-14 08:20:36','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(18,596716,596710,NULL,'frankenstein Dr','Urobilinogen Phenlpyruvic acid','','2014-10-14 08:20:37','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04'),(19,596717,596710,NULL,'frankenstein Dr','pH','','2014-10-14 08:20:37','ip',NULL,NULL,643660,326983,'Macau Macau','1996-10-09 00:00:00','Female',NULL,'','',NULL,NULL,NULL,NULL,'','sanitas','2015-10-27 08:36:04','2015-10-27 08:36:04');
/*!40000 ALTER TABLE `external_dump` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_users`
--

DROP TABLE IF EXISTS `external_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `external_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `internal_user_id` int(10) unsigned NOT NULL,
  `external_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `external_users_internal_user_id_unique` (`internal_user_id`),
  CONSTRAINT `external_users_internal_user_id_foreign` FOREIGN KEY (`internal_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_users`
--

LOCK TABLES `external_users` WRITE;
/*!40000 ALTER TABLE `external_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `external_users` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
INSERT INTO `facilities` VALUES (1,'WALTER REED','2015-10-27 08:36:05','2015-10-27 08:36:05'),(2,'AGA KHAN UNIVERSITY HOSPITAL','2015-10-27 08:36:05','2015-10-27 08:36:05'),(3,'TEL AVIV GENERAL HOSPITAL','2015-10-27 08:36:05','2015-10-27 08:36:05'),(4,'GK PRISON DISPENSARY','2015-10-27 08:36:05','2015-10-27 08:36:05'),(5,'KEMRI ALUPE','2015-10-27 08:36:05','2015-10-27 08:36:05'),(6,'AMPATH','2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instrument_testtypes`
--

DROP TABLE IF EXISTS `instrument_testtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instrument_testtypes` (
  `instrument_id` int(10) unsigned NOT NULL,
  `test_type_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `instrument_testtypes_instrument_id_test_type_id_unique` (`instrument_id`,`test_type_id`),
  KEY `instrument_testtypes_test_type_id_foreign` (`test_type_id`),
  CONSTRAINT `instrument_testtypes_instrument_id_foreign` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`),
  CONSTRAINT `instrument_testtypes_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instrument_testtypes`
--

LOCK TABLES `instrument_testtypes` WRITE;
/*!40000 ALTER TABLE `instrument_testtypes` DISABLE KEYS */;
INSERT INTO `instrument_testtypes` VALUES (1,6);
/*!40000 ALTER TABLE `instrument_testtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instruments`
--

DROP TABLE IF EXISTS `instruments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instruments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hostname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruments`
--

LOCK TABLES `instruments` WRITE;
/*!40000 ALTER TABLE `instruments` DISABLE KEYS */;
INSERT INTO `instruments` VALUES (1,'Celltac F Mek 8222','192.168.1.12','HEMASERVER','Automatic analyzer with 22 parameters and WBC 5 part diff Hematology Analyzer','KBLIS\\Plugins\\CelltacFMachine','2015-10-27 08:36:04','2015-10-27 08:36:04');
/*!40000 ALTER TABLE `instruments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issues`
--

DROP TABLE IF EXISTS `issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `receipt_id` int(10) unsigned NOT NULL,
  `topup_request_id` int(10) unsigned NOT NULL,
  `quantity_issued` int(11) NOT NULL,
  `issued_to` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `remarks` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `issues_topup_request_id_foreign` (`topup_request_id`),
  KEY `issues_receipt_id_foreign` (`receipt_id`),
  KEY `issues_issued_to_foreign` (`issued_to`),
  KEY `issues_user_id_foreign` (`user_id`),
  CONSTRAINT `issues_issued_to_foreign` FOREIGN KEY (`issued_to`) REFERENCES `users` (`id`),
  CONSTRAINT `issues_receipt_id_foreign` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`),
  CONSTRAINT `issues_topup_request_id_foreign` FOREIGN KEY (`topup_request_id`) REFERENCES `topup_requests` (`id`),
  CONSTRAINT `issues_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issues`
--

LOCK TABLES `issues` WRITE;
/*!40000 ALTER TABLE `issues` DISABLE KEYS */;
INSERT INTO `issues` VALUES (1,1,1,1700,1,1,'-',NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lots`
--

DROP TABLE IF EXISTS `lots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiry` date NOT NULL,
  `instrument_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lots_number_unique` (`number`),
  KEY `lots_instrument_id_foreign` (`instrument_id`),
  CONSTRAINT `lots_instrument_id_foreign` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lots`
--

LOCK TABLES `lots` WRITE;
/*!40000 ALTER TABLE `lots` DISABLE KEYS */;
INSERT INTO `lots` VALUES (1,'0001','First lot','2016-04-27',1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05'),(2,'0002','Second lot','2016-05-27',1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `lots` ENABLE KEYS */;
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
  `range_lower` decimal(7,3) DEFAULT NULL,
  `range_upper` decimal(7,3) DEFAULT NULL,
  `alphanumeric` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interpretation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `measure_ranges_alphanumeric_index` (`alphanumeric`),
  KEY `measure_ranges_measure_id_foreign` (`measure_id`),
  CONSTRAINT `measure_ranges_measure_id_foreign` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure_ranges`
--

LOCK TABLES `measure_ranges` WRITE;
/*!40000 ALTER TABLE `measure_ranges` DISABLE KEYS */;
INSERT INTO `measure_ranges` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,'No mps seen','Negative',NULL),(2,1,NULL,NULL,NULL,NULL,NULL,'+','Positive',NULL),(3,1,NULL,NULL,NULL,NULL,NULL,'++','Positive',NULL),(4,1,NULL,NULL,NULL,NULL,NULL,'+++','Positive',NULL),(5,2,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(6,2,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(7,3,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL),(8,3,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL),(9,3,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL),(10,4,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL),(11,4,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL),(12,4,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL),(13,5,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL),(14,5,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL),(15,5,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL),(16,6,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(17,6,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(18,7,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(19,7,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(20,8,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(21,8,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(22,26,NULL,NULL,NULL,NULL,NULL,'O-',NULL,NULL),(23,26,NULL,NULL,NULL,NULL,NULL,'O+',NULL,NULL),(24,26,NULL,NULL,NULL,NULL,NULL,'A-',NULL,NULL),(25,26,NULL,NULL,NULL,NULL,NULL,'A+',NULL,NULL),(26,26,NULL,NULL,NULL,NULL,NULL,'B-',NULL,NULL),(27,26,NULL,NULL,NULL,NULL,NULL,'B+',NULL,NULL),(28,26,NULL,NULL,NULL,NULL,NULL,'AB-',NULL,NULL),(29,26,NULL,NULL,NULL,NULL,NULL,'AB+',NULL,NULL),(30,46,0,100,2,4.000,11.000,NULL,NULL,NULL),(31,47,0,100,2,1.500,4.000,NULL,NULL,NULL),(32,48,0,100,2,0.100,9.000,NULL,NULL,NULL),(33,49,0,100,2,2.500,7.000,NULL,NULL,NULL),(34,50,0,100,2,0.000,6.000,NULL,NULL,NULL),(35,51,0,100,2,0.000,2.000,NULL,NULL,NULL),(36,52,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(37,52,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(38,53,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(39,53,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(40,54,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(41,54,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(42,55,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(43,55,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(44,56,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(45,56,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(46,57,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(47,57,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(48,58,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(49,58,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(50,59,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(51,59,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(52,60,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(53,60,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(54,63,NULL,NULL,NULL,NULL,NULL,'Not performed','',NULL),(55,63,NULL,NULL,NULL,NULL,NULL,'No growth 24hrs','',NULL),(56,63,NULL,NULL,NULL,NULL,NULL,'No growth 48hrs','',NULL),(57,63,NULL,NULL,NULL,NULL,NULL,'No growth 72hrs','NEGATIVE',NULL),(58,63,NULL,NULL,NULL,NULL,NULL,'Growth','POSITIVE',NULL),(59,64,NULL,NULL,NULL,NULL,NULL,'Gram positive','',NULL),(60,64,NULL,NULL,NULL,NULL,NULL,'Gram negative','',NULL),(61,64,NULL,NULL,NULL,NULL,NULL,'Gram variable','',NULL),(62,65,NULL,NULL,NULL,NULL,NULL,'Cocci','',NULL),(63,65,NULL,NULL,NULL,NULL,NULL,'Bacilli','',NULL),(64,65,NULL,NULL,NULL,NULL,NULL,'Cocci-bacilli','',NULL),(65,65,NULL,NULL,NULL,NULL,NULL,'Diplococci','',NULL),(66,65,NULL,NULL,NULL,NULL,NULL,'Yeast','',NULL),(67,65,NULL,NULL,NULL,NULL,NULL,'Other','',NULL),(68,68,0,120,2,50.000,80.000,NULL,'NORMAL',NULL),(69,69,0,120,2,15.000,45.000,NULL,'NORMAL',NULL),(70,70,0,120,2,0.000,3.000,NULL,'NORMAL',NULL),(71,71,0,120,2,0.000,0.000,NULL,'NORMAL',NULL),(72,72,0,120,2,0.000,0.000,NULL,'',NULL),(73,73,0,120,2,0.000,0.000,NULL,'',NULL),(74,74,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL),(75,74,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL),(76,76,0,120,2,0.000,0.000,NULL,'',NULL),(77,77,0,120,2,0.000,0.000,NULL,'',NULL),(78,78,0,120,2,0.000,0.000,NULL,'',NULL),(79,79,0,120,2,0.000,0.000,NULL,'',NULL),(80,80,0,120,2,0.000,0.000,NULL,'',NULL),(81,81,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL),(82,81,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL),(83,82,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL),(84,82,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL),(85,83,NULL,NULL,NULL,NULL,NULL,'Parasites seen','POSITIVE',NULL),(86,83,NULL,NULL,NULL,NULL,NULL,'Parasite free','NEGATIVE',NULL);
/*!40000 ALTER TABLE `measure_ranges` ENABLE KEYS */;
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
INSERT INTO `measure_types` VALUES (1,'Numeric Range',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(2,'Alphanumeric Values',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(3,'Autocomplete',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(4,'Free Text',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03');
/*!40000 ALTER TABLE `measure_types` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measures`
--

LOCK TABLES `measures` WRITE;
/*!40000 ALTER TABLE `measures` DISABLE KEYS */;
INSERT INTO `measures` VALUES (1,2,'BS for mps','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(2,2,'Grams stain','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(3,2,'SERUM AMYLASE','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(4,2,'calcium','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(5,2,'SGOT','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(6,2,'Indirect COOMBS test','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(7,2,'Direct COOMBS test','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(8,2,'Du test','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(9,1,'URIC ACID','mg/dl',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(10,4,'CSF for biochemistry','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(11,4,'PSA','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(12,1,'Total','mg/dl',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(13,1,'Alkaline Phosphate','u/l',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(14,1,'Direct','mg/dl',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(15,1,'Total Proteins','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(16,4,'LFTS','NULL',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(17,1,'Chloride','mmol/l',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(18,1,'Potassium','mmol/l',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(19,1,'Sodium','mmol/l',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(20,4,'Electrolytes','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(21,1,'Creatinine','mg/dl',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(22,1,'Urea','mg/dl',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(23,4,'RFTS','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(24,4,'TFT','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(25,4,'GXM','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(26,2,'Blood Grouping','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(27,1,'HB','g/dL',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(28,4,'Urine microscopy','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(29,4,'Pus cells','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(30,4,'S. haematobium','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(31,4,'T. vaginalis','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(32,4,'Yeast cells','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(33,4,'Red blood cells','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(34,4,'Bacteria','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(35,4,'Spermatozoa','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(36,4,'Epithelial cells','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(37,4,'ph','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(38,4,'Urine chemistry','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(39,4,'Glucose','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(40,4,'Ketones','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(41,4,'Proteins','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(42,4,'Blood','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(43,4,'Bilirubin','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(44,4,'Urobilinogen Phenlpyruvic acid','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(45,4,'pH','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(46,1,'WBC','x10³/µL',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(47,1,'Lym','L',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(48,1,'Mon','*',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(49,1,'Neu','*',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(50,1,'Eos','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(51,1,'Baso','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03',NULL),(52,2,'Salmonella Antigen Test','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04',NULL),(53,2,'Direct COOMBS Test','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04',NULL),(54,2,'Du Test','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04',NULL),(55,2,'Sickling Test','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04',NULL),(56,2,'Borrelia','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04',NULL),(57,2,'VDRL','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04',NULL),(58,2,'Pregnancy Test','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04',NULL),(59,2,'Brucella','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04',NULL),(60,2,'H. Pylori','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04',NULL),(61,4,'Sample Location (Swab)','','','2015-10-29 09:49:50','2015-10-29 09:49:50',NULL),(62,4,'Sample Appearance (Fluids)','','','2015-10-29 09:49:50','2015-10-29 09:49:50',NULL),(63,2,'Culture','','','2015-10-29 09:57:43','2015-10-29 09:57:43',NULL),(64,2,'Gram Stain','','','2015-10-29 09:57:43','2015-10-29 09:57:43',NULL),(65,2,'Gram Stain Morphology','','','2015-10-29 09:57:43','2015-10-29 09:57:43',NULL),(66,4,'Gram Stain Remarks','','','2015-10-29 09:57:43','2015-10-29 09:57:43',NULL),(67,4,'Appearance','','','2015-10-29 10:21:02','2015-10-29 10:21:02',NULL),(68,1,'Protein','mg/dL','','2015-10-29 10:21:02','2015-10-29 10:21:02',NULL),(69,1,'Glucose','mg/dL','','2015-10-29 10:21:02','2015-10-29 10:21:02',NULL),(70,1,'RBC','cells/mm3','','2015-10-29 10:21:02','2015-10-29 10:21:02',NULL),(71,1,'WBC','cells/mm3','','2015-10-29 10:21:02','2015-10-29 10:21:02',NULL),(72,1,'Polymorphs','%','','2015-10-29 10:21:02','2015-10-29 10:21:02',NULL),(73,1,'Lymphocytes','%','','2015-10-29 10:21:02','2015-10-29 10:21:02',NULL),(74,2,'India Ink','','','2015-10-29 10:21:02','2015-10-29 10:21:02',NULL),(75,4,'Appearance','','','2015-10-29 10:34:21','2015-10-29 10:34:21',NULL),(76,1,'RBC','cells/mm3','','2015-10-29 10:34:21','2015-10-29 10:34:21',NULL),(77,1,'WBC','cells/mm3','','2015-10-29 10:34:21','2015-10-29 10:34:21',NULL),(78,1,'Polymorphs','%','','2015-10-29 10:34:21','2015-10-29 10:34:21',NULL),(79,1,'Lymphocytes','%','','2015-10-29 10:34:21','2015-10-29 10:34:21',NULL),(80,1,'Protein','mg/dL','','2015-10-29 10:34:21','2015-10-29 10:34:21',NULL),(81,2,'AAFB','','','2015-10-29 10:34:21','2015-10-29 10:34:21',NULL),(82,2,'Clue Cells','','','2015-10-29 10:38:25','2015-10-29 10:38:25',NULL),(83,2,'Parasites','','','2015-10-29 10:38:25','2015-10-29 10:38:25',NULL),(84,4,'Parasites Remarks','','','2015-10-29 10:38:25','2015-10-29 10:38:25',NULL);
/*!40000 ALTER TABLE `measures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metrics`
--

DROP TABLE IF EXISTS `metrics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metrics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metrics`
--

LOCK TABLES `metrics` WRITE;
/*!40000 ALTER TABLE `metrics` DISABLE KEYS */;
INSERT INTO `metrics` VALUES (1,'mg','milligram',NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `metrics` ENABLE KEYS */;
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
INSERT INTO `migrations` VALUES ('2014_07_24_082711_CreatekBLIStables',1),('2014_09_02_114206_entrust_setup_tables',1),('2014_10_09_162222_externaldumptable',1),('2015_02_04_004704_add_index_to_parentlabno',1),('2015_02_11_112608_remove_unique_constraint_on_patient_number',1),('2015_02_17_104134_qc_tables',1),('2015_02_23_112018_create_microbiology_tables',1),('2015_02_27_084341_createInventoryTables',1),('2015_03_16_155558_create_surveillance',1),('2015_06_24_145526_update_test_types_table',1),('2015_06_24_154426_FreeTestsColumn',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organism_drugs`
--

LOCK TABLES `organism_drugs` WRITE;
/*!40000 ALTER TABLE `organism_drugs` DISABLE KEYS */;
INSERT INTO `organism_drugs` VALUES (1,1,1,NULL,'2015-10-29 08:54:13','2015-10-29 08:54:13'),(2,1,2,NULL,'2015-10-29 08:54:13','2015-10-29 08:54:13'),(3,1,17,NULL,'2015-10-29 08:54:13','2015-10-29 08:54:13'),(4,1,4,NULL,'2015-10-29 08:54:13','2015-10-29 08:54:13'),(5,1,5,NULL,'2015-10-29 08:54:13','2015-10-29 08:54:13'),(6,1,13,NULL,'2015-10-29 08:54:13','2015-10-29 08:54:13'),(7,1,7,NULL,'2015-10-29 08:54:13','2015-10-29 08:54:13'),(8,5,18,NULL,'2015-10-29 08:55:03','2015-10-29 08:55:03'),(9,5,17,NULL,'2015-10-29 08:55:03','2015-10-29 08:55:03'),(10,5,4,NULL,'2015-10-29 08:55:03','2015-10-29 08:55:03'),(11,5,5,NULL,'2015-10-29 08:55:03','2015-10-29 08:55:03'),(12,5,7,NULL,'2015-10-29 08:55:03','2015-10-29 08:55:03'),(13,4,14,NULL,'2015-10-29 08:56:09','2015-10-29 08:56:09'),(14,4,5,NULL,'2015-10-29 08:56:09','2015-10-29 08:56:09'),(15,4,10,NULL,'2015-10-29 08:56:09','2015-10-29 08:56:09'),(16,4,15,NULL,'2015-10-29 08:56:09','2015-10-29 08:56:09'),(17,4,16,NULL,'2015-10-29 08:56:09','2015-10-29 08:56:09'),(18,2,2,NULL,'2015-10-29 08:58:11','2015-10-29 08:58:11'),(19,2,4,NULL,'2015-10-29 08:58:11','2015-10-29 08:58:11'),(20,2,5,NULL,'2015-10-29 08:58:11','2015-10-29 08:58:11'),(21,2,8,NULL,'2015-10-29 08:58:11','2015-10-29 08:58:11'),(22,2,9,NULL,'2015-10-29 08:58:11','2015-10-29 08:58:11'),(23,2,10,NULL,'2015-10-29 08:58:11','2015-10-29 08:58:11'),(24,2,12,NULL,'2015-10-29 08:58:11','2015-10-29 08:58:11'),(25,2,11,NULL,'2015-10-29 08:58:11','2015-10-29 08:58:11'),(26,2,7,NULL,'2015-10-29 08:58:11','2015-10-29 08:58:11'),(27,3,4,NULL,'2015-10-29 08:58:47','2015-10-29 08:58:47'),(28,3,8,NULL,'2015-10-29 08:58:47','2015-10-29 08:58:47'),(29,3,9,NULL,'2015-10-29 08:58:47','2015-10-29 08:58:47'),(30,3,12,NULL,'2015-10-29 08:58:47','2015-10-29 08:58:47'),(31,3,13,NULL,'2015-10-29 08:58:47','2015-10-29 08:58:47'),(32,3,7,NULL,'2015-10-29 08:58:47','2015-10-29 08:58:47');
/*!40000 ALTER TABLE `organism_drugs` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisms`
--

LOCK TABLES `organisms` WRITE;
/*!40000 ALTER TABLE `organisms` DISABLE KEYS */;
INSERT INTO `organisms` VALUES (1,'Haemophilus influenza','',NULL,'2015-10-29 08:40:33','2015-10-29 08:40:33'),(2,'Staphylococci','',NULL,'2015-10-29 08:40:44','2015-10-29 08:40:44'),(3,'Streptococcus pneumoniae','',NULL,'2015-10-29 08:40:52','2015-10-29 08:40:52'),(4,'Pseudomonas aeruginosa','',NULL,'2015-10-29 08:40:59','2015-10-29 08:40:59'),(5,'Neisseria meningitides','',NULL,'2015-10-29 08:41:07','2015-10-29 08:41:07');
/*!40000 ALTER TABLE `organisms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_patient_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `patients_external_patient_number_index` (`external_patient_number`),
  KEY `patients_created_by_index` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,'1002','Jam Felicia','2000-01-01',1,'fj@x.com',NULL,NULL,NULL,2,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(2,'1003','Emma Wallace','1990-03-01',1,'emma@snd.com',NULL,NULL,NULL,2,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(3,'1004','Jack Tee','1999-12-18',0,'info@jt.co.ke',NULL,NULL,NULL,1,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(4,'1005','Hu Jintao','1956-10-28',0,'hu@.un.org',NULL,NULL,NULL,2,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(5,'2150','Lance Opiyo','2012-01-01',0,'lance@x.com',NULL,NULL,NULL,1,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1),(10,10,1),(11,11,1),(12,12,1),(13,13,1),(14,14,1),(15,15,1),(16,16,1),(17,17,1),(18,18,1),(19,19,1),(20,20,1);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view_names','Can view patient names','2015-10-27 08:36:04','2015-10-27 08:36:04'),(2,'manage_patients','Can add patients','2015-10-27 08:36:04','2015-10-27 08:36:04'),(3,'receive_external_test','Can receive test requests','2015-10-27 08:36:04','2015-10-27 08:36:04'),(4,'request_test','Can request new test','2015-10-27 08:36:04','2015-10-27 08:36:04'),(5,'accept_test_specimen','Can accept test specimen','2015-10-27 08:36:04','2015-10-27 08:36:04'),(6,'reject_test_specimen','Can reject test specimen','2015-10-27 08:36:04','2015-10-27 08:36:04'),(7,'change_test_specimen','Can change test specimen','2015-10-27 08:36:04','2015-10-27 08:36:04'),(8,'start_test','Can start tests','2015-10-27 08:36:04','2015-10-27 08:36:04'),(9,'enter_test_results','Can enter tests results','2015-10-27 08:36:04','2015-10-27 08:36:04'),(10,'edit_test_results','Can edit test results','2015-10-27 08:36:04','2015-10-27 08:36:04'),(11,'verify_test_results','Can verify test results','2015-10-27 08:36:04','2015-10-27 08:36:04'),(12,'send_results_to_external_system','Can send test results to external systems','2015-10-27 08:36:04','2015-10-27 08:36:04'),(13,'refer_specimens','Can refer specimens','2015-10-27 08:36:04','2015-10-27 08:36:04'),(14,'manage_users','Can manage users','2015-10-27 08:36:04','2015-10-27 08:36:04'),(15,'manage_test_catalog','Can manage test catalog','2015-10-27 08:36:04','2015-10-27 08:36:04'),(16,'manage_lab_configurations','Can manage lab configurations','2015-10-27 08:36:04','2015-10-27 08:36:04'),(17,'view_reports','Can view reports','2015-10-27 08:36:04','2015-10-27 08:36:04'),(18,'manage_inventory','Can manage inventory','2015-10-27 08:36:04','2015-10-27 08:36:04'),(19,'request_topup','Can request top-up','2015-10-27 08:36:04','2015-10-27 08:36:04'),(20,'manage_qc','Can manage Quality Control','2015-10-27 08:36:04','2015-10-27 08:36:04');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receipts`
--

DROP TABLE IF EXISTS `receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commodity_id` int(10) unsigned NOT NULL,
  `supplier_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `batch_no` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `expiry_date` date NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `receipts_commodity_id_foreign` (`commodity_id`),
  KEY `receipts_supplier_id_foreign` (`supplier_id`),
  KEY `receipts_user_id_foreign` (`user_id`),
  CONSTRAINT `receipts_commodity_id_foreign` FOREIGN KEY (`commodity_id`) REFERENCES `commodities` (`id`),
  CONSTRAINT `receipts_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `receipts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receipts`
--

LOCK TABLES `receipts` WRITE;
/*!40000 ALTER TABLE `receipts` DISABLE KEYS */;
INSERT INTO `receipts` VALUES (1,1,1,130000,'002720','2018-10-14',1,NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `receipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referrals`
--

DROP TABLE IF EXISTS `referrals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `referrals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(10) unsigned NOT NULL,
  `facility_id` int(10) unsigned NOT NULL,
  `person` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `contacts` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `referrals_user_id_foreign` (`user_id`),
  KEY `referrals_facility_id_foreign` (`facility_id`),
  CONSTRAINT `referrals_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`),
  CONSTRAINT `referrals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referrals`
--

LOCK TABLES `referrals` WRITE;
/*!40000 ALTER TABLE `referrals` DISABLE KEYS */;
/*!40000 ALTER TABLE `referrals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rejection_reasons`
--

DROP TABLE IF EXISTS `rejection_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rejection_reasons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reason` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rejection_reasons`
--

LOCK TABLES `rejection_reasons` WRITE;
/*!40000 ALTER TABLE `rejection_reasons` DISABLE KEYS */;
INSERT INTO `rejection_reasons` VALUES (1,'Poorly labelled'),(2,'Over saturation'),(3,'Insufficient Sample'),(4,'Scattered'),(5,'Clotted Blood'),(6,'Two layered spots'),(7,'Serum rings'),(8,'Scratched'),(9,'Haemolysis'),(10,'Spots that cannot elute'),(11,'Leaking'),(12,'Broken Sample Container'),(13,'Mismatched sample and form labelling'),(14,'Missing Labels on container and tracking form'),(15,'Empty Container'),(16,'Samples without tracking forms'),(17,'Poor transport'),(18,'Lipaemic'),(19,'Wrong container/Anticoagulant'),(20,'Request form without samples'),(21,'Missing collection date on specimen / request form.'),(22,'Name and signature of requester missing'),(23,'Mismatched information on request form and specimen container.'),(24,'Request form contaminated with specimen'),(25,'Duplicate specimen received'),(26,'Delay between specimen collection and arrival in the laboratory'),(27,'Inappropriate specimen packing'),(28,'Inappropriate specimen for the test'),(29,'Inappropriate test for the clinical condition'),(30,'No Label'),(31,'Leaking'),(32,'No Sample in the Container'),(33,'No Request Form'),(34,'Missing Information Required');
/*!40000 ALTER TABLE `rejection_reasons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_diseases`
--

DROP TABLE IF EXISTS `report_diseases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_diseases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_type_id` int(10) unsigned NOT NULL,
  `disease_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_diseases_test_type_id_disease_id_unique` (`test_type_id`,`disease_id`),
  KEY `report_diseases_disease_id_foreign` (`disease_id`),
  CONSTRAINT `report_diseases_disease_id_foreign` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`id`),
  CONSTRAINT `report_diseases_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_diseases`
--

LOCK TABLES `report_diseases` WRITE;
/*!40000 ALTER TABLE `report_diseases` DISABLE KEYS */;
INSERT INTO `report_diseases` VALUES (1,1,1),(3,2,3),(2,7,2);
/*!40000 ALTER TABLE `report_diseases` ENABLE KEYS */;
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
INSERT INTO `roles` VALUES (1,'Superadmin',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(2,'Technologist',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(3,'Receptionist',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_types`
--

LOCK TABLES `specimen_types` WRITE;
/*!40000 ALTER TABLE `specimen_types` DISABLE KEYS */;
INSERT INTO `specimen_types` VALUES (1,'Ascitic Tap',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(2,'Aspirate',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(3,'CSF',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(4,'Dried Blood Spot',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(5,'High Vaginal Swab',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(6,'Nasal Swab',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(7,'Plasma',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(8,'Plasma EDTA',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(9,'Pleural Tap',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(10,'Pus Swab',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(11,'Rectal Swab',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(12,'Semen',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(13,'Serum',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(14,'Skin',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(15,'Sputum',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(16,'Stool',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(17,'Synovial Fluid',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(18,'Throat Swab',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(19,'Urethral Smear',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(20,'Urine',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(21,'Vaginal Smear',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(22,'Water',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(23,'Whole Blood',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03');
/*!40000 ALTER TABLE `specimen_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimens`
--

DROP TABLE IF EXISTS `specimens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specimens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `specimen_type_id` int(10) unsigned NOT NULL,
  `specimen_status_id` int(10) unsigned NOT NULL DEFAULT '1',
  `accepted_by` int(10) unsigned NOT NULL DEFAULT '0',
  `rejected_by` int(10) unsigned NOT NULL DEFAULT '0',
  `rejection_reason_id` int(10) unsigned DEFAULT NULL,
  `reject_explained_to` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_id` int(10) unsigned DEFAULT NULL,
  `time_accepted` timestamp NULL DEFAULT NULL,
  `time_rejected` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `specimens_accepted_by_index` (`accepted_by`),
  KEY `specimens_rejected_by_index` (`rejected_by`),
  KEY `specimens_specimen_type_id_foreign` (`specimen_type_id`),
  KEY `specimens_specimen_status_id_foreign` (`specimen_status_id`),
  KEY `specimens_rejection_reason_id_foreign` (`rejection_reason_id`),
  KEY `specimens_referral_id_foreign` (`referral_id`),
  CONSTRAINT `specimens_referral_id_foreign` FOREIGN KEY (`referral_id`) REFERENCES `referrals` (`id`),
  CONSTRAINT `specimens_rejection_reason_id_foreign` FOREIGN KEY (`rejection_reason_id`) REFERENCES `rejection_reasons` (`id`),
  CONSTRAINT `specimens_specimen_status_id_foreign` FOREIGN KEY (`specimen_status_id`) REFERENCES `specimen_statuses` (`id`),
  CONSTRAINT `specimens_specimen_type_id_foreign` FOREIGN KEY (`specimen_type_id`) REFERENCES `specimen_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimens`
--

LOCK TABLES `specimens` WRITE;
/*!40000 ALTER TABLE `specimens` DISABLE KEYS */;
INSERT INTO `specimens` VALUES (1,23,1,0,0,NULL,NULL,NULL,NULL,NULL),(2,23,1,0,0,NULL,NULL,NULL,NULL,NULL),(3,23,1,0,0,NULL,NULL,NULL,NULL,NULL),(4,23,2,4,0,NULL,NULL,NULL,'2015-10-27 08:36:03',NULL),(5,23,2,2,0,NULL,NULL,NULL,'2015-10-27 08:36:04',NULL),(6,23,2,4,0,NULL,NULL,NULL,'2015-10-27 08:36:04',NULL),(7,23,2,2,0,NULL,NULL,NULL,'2015-10-27 08:36:04',NULL),(8,23,2,2,0,NULL,NULL,NULL,'2015-10-27 08:36:04',NULL),(9,23,2,2,0,NULL,NULL,NULL,'2015-10-27 08:36:04',NULL),(10,23,3,0,4,13,NULL,NULL,NULL,'2015-10-27 08:36:04'),(11,23,2,4,0,NULL,NULL,NULL,'2015-10-27 08:36:04',NULL),(12,23,3,0,1,13,NULL,NULL,NULL,'2015-10-27 08:36:04'),(13,23,3,0,2,3,NULL,NULL,NULL,'2015-10-27 08:36:04'),(14,23,1,0,0,NULL,NULL,NULL,NULL,NULL),(15,23,1,0,0,NULL,NULL,NULL,NULL,NULL),(16,23,2,1,0,NULL,NULL,NULL,'2015-10-27 08:36:04',NULL);
/*!40000 ALTER TABLE `specimens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `physical_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'UNICEF','0775112233','uni@unice.org','un-hqtr',NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_categories`
--

LOCK TABLES `test_categories` WRITE;
/*!40000 ALTER TABLE `test_categories` DISABLE KEYS */;
INSERT INTO `test_categories` VALUES (1,'PARASITOLOGY','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(2,'MICROBIOLOGY','',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(3,'HEMATOLOGY','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(4,'SEROLOGY','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(5,'BLOOD TRANSFUSION','',NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04');
/*!40000 ALTER TABLE `test_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_phases`
--

DROP TABLE IF EXISTS `test_phases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_phases` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_phases`
--

LOCK TABLES `test_phases` WRITE;
/*!40000 ALTER TABLE `test_phases` DISABLE KEYS */;
INSERT INTO `test_phases` VALUES (1,'Pre-Analytical'),(2,'Analytical'),(3,'Post-Analytical');
/*!40000 ALTER TABLE `test_phases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_results`
--

DROP TABLE IF EXISTS `test_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(10) unsigned NOT NULL,
  `measure_id` int(10) unsigned NOT NULL,
  `result` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `test_results_test_id_measure_id_unique` (`test_id`,`measure_id`),
  KEY `test_results_measure_id_foreign` (`measure_id`),
  CONSTRAINT `test_results_measure_id_foreign` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`),
  CONSTRAINT `test_results_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_results`
--

LOCK TABLES `test_results` WRITE;
/*!40000 ALTER TABLE `test_results` DISABLE KEYS */;
INSERT INTO `test_results` VALUES (1,9,1,'+++','2015-10-27 07:36:04'),(2,8,1,'++','2015-10-27 07:36:04'),(3,5,25,'COMPATIBLE WITH 061832914 B/G A POS.EXPIRY19/8/14','2015-10-27 07:36:04'),(4,5,26,'A+','2015-10-27 07:36:04'),(5,6,27,'13.7','2015-10-27 07:36:04'),(6,13,1,'No mps seen','2015-10-27 07:36:04'),(7,16,28,'050','2015-10-27 07:36:04'),(8,16,29,'150','2015-10-27 07:36:04'),(9,16,30,'250','2015-10-27 07:36:04'),(10,16,31,'350','2015-10-27 07:36:04'),(11,16,32,'450','2015-10-27 07:36:04'),(12,16,33,'550','2015-10-27 07:36:04'),(13,16,34,'650','2015-10-27 07:36:04'),(14,16,35,'750','2015-10-27 07:36:04'),(15,16,36,'850','2015-10-27 07:36:04'),(16,16,37,'950','2015-10-27 07:36:04'),(17,16,38,'1050','2015-10-27 07:36:04'),(18,16,39,'1150','2015-10-27 07:36:04'),(19,16,40,'1250','2015-10-27 07:36:04'),(20,16,41,'1350','2015-10-27 07:36:04'),(21,16,42,'1450','2015-10-27 07:36:04'),(22,16,43,'1550','2015-10-27 07:36:04'),(23,16,44,'1650','2015-10-27 07:36:04'),(24,16,45,'1750','2015-10-27 07:36:04'),(25,17,52,'Positive','2015-10-27 07:36:04'),(26,18,53,'Positive','2015-10-27 07:36:04'),(27,19,54,'Positive','2015-10-27 07:36:04'),(28,20,55,'Positive','2015-10-27 07:36:04'),(29,21,56,'Positive','2015-10-27 07:36:04'),(30,22,57,'Positive','2015-10-27 07:36:04'),(31,23,58,'Positive','2015-10-27 07:36:04'),(32,24,59,'Positive','2015-10-27 07:36:04'),(33,25,60,'Positive','2015-10-27 07:36:04'),(34,26,52,'Positive','2015-10-27 07:36:04'),(35,27,53,'Negative','2015-10-27 07:36:04'),(36,28,54,'Positive','2015-10-27 07:36:04'),(37,29,55,'Positive','2015-10-27 07:36:04'),(38,30,56,'Negative','2015-10-27 07:36:04'),(39,31,57,'Negative','2015-10-27 07:36:04'),(40,32,58,'Negative','2015-10-27 07:36:05'),(41,33,59,'Positive','2015-10-27 07:36:05'),(42,34,60,'Positive','2015-10-27 07:36:05'),(43,35,58,'Negative','2015-10-27 07:36:05'),(44,36,58,'Positive','2015-10-27 07:36:05');
/*!40000 ALTER TABLE `test_results` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_types`
--

LOCK TABLES `test_types` WRITE;
/*!40000 ALTER TABLE `test_types` DISABLE KEYS */;
INSERT INTO `test_types` VALUES (1,'BS for mps',NULL,1,NULL,1,NULL,NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(2,'Stool for C/S',NULL,2,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(3,'GXM',NULL,1,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(4,'HB',NULL,1,NULL,1,NULL,NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(5,'Urinalysis',NULL,1,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(6,'WBC',NULL,1,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(7,'Salmonella Antigen Test',NULL,1,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(8,'Direct COOMBS Test',NULL,5,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(9,'DU Test',NULL,5,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(10,'Sickling Test',NULL,3,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(11,'Borrelia',NULL,1,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(12,'VDRL',NULL,4,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(13,'Pregnancy Test',NULL,4,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(14,'Brucella',NULL,4,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(15,'H. Pylori',NULL,4,NULL,NULL,NULL,NULL,NULL,'2015-10-27 08:36:04','2015-10-27 08:36:04'),(16,'Culture and Screen','',2,'',NULL,'',NULL,NULL,'2015-10-29 09:49:50','2015-10-29 09:49:50'),(17,'CSF Exam','',2,'',NULL,'',NULL,NULL,'2015-10-29 10:21:02','2015-10-29 10:21:02'),(18,'Sterile Fluid Exam','',2,'',NULL,'',NULL,NULL,'2015-10-29 10:34:21','2015-10-29 10:34:21'),(19,'High Vaginal Swab','',2,'',NULL,'',NULL,NULL,'2015-10-29 10:38:25','2015-10-29 10:38:25');
/*!40000 ALTER TABLE `test_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `visit_id` bigint(20) unsigned NOT NULL,
  `test_type_id` int(10) unsigned NOT NULL,
  `specimen_id` int(10) unsigned NOT NULL DEFAULT '0',
  `interpretation` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `test_status_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by` int(10) unsigned NOT NULL,
  `tested_by` int(10) unsigned NOT NULL DEFAULT '0',
  `verified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `requested_by` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_started` timestamp NULL DEFAULT NULL,
  `time_completed` timestamp NULL DEFAULT NULL,
  `time_verified` timestamp NULL DEFAULT NULL,
  `time_sent` timestamp NULL DEFAULT NULL,
  `external_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tests_created_by_index` (`created_by`),
  KEY `tests_tested_by_index` (`tested_by`),
  KEY `tests_verified_by_index` (`verified_by`),
  KEY `tests_visit_id_foreign` (`visit_id`),
  KEY `tests_test_type_id_foreign` (`test_type_id`),
  KEY `tests_specimen_id_foreign` (`specimen_id`),
  KEY `tests_test_status_id_foreign` (`test_status_id`),
  CONSTRAINT `tests_specimen_id_foreign` FOREIGN KEY (`specimen_id`) REFERENCES `specimens` (`id`),
  CONSTRAINT `tests_test_status_id_foreign` FOREIGN KEY (`test_status_id`) REFERENCES `test_statuses` (`id`),
  CONSTRAINT `tests_test_type_id_foreign` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`),
  CONSTRAINT `tests_visit_id_foreign` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
INSERT INTO `tests` VALUES (1,5,1,1,'',1,1,0,0,'Dr. Abou Meyang','2015-10-27 07:36:03',NULL,NULL,NULL,NULL,NULL),(2,6,4,2,'',2,4,0,0,'Dr. Abou Meyang','2015-10-27 07:36:03',NULL,NULL,NULL,NULL,NULL),(3,5,3,3,'',2,3,0,0,'Dr. Abou Meyang','2015-10-27 07:36:03',NULL,NULL,NULL,NULL,NULL),(4,4,1,4,'',2,4,0,0,'Dr. Abou Meyang','2015-10-27 07:36:03',NULL,NULL,NULL,NULL,NULL),(5,3,3,5,'Perfect match.',4,1,3,0,'Dr. Abou Meyang','2015-10-27 07:36:04','2015-10-27 08:36:03','2015-10-27 08:48:11',NULL,NULL,NULL),(6,2,4,6,'Do nothing!',4,3,1,0,'Genghiz Khan','2015-10-27 07:36:04','2015-10-27 08:48:11','2015-10-27 08:53:34',NULL,NULL,NULL),(7,3,3,7,'',3,4,0,0,'Dr. Abou Meyang','2015-10-27 07:36:04','2015-10-27 08:53:34',NULL,NULL,NULL,NULL),(8,3,1,8,'Positive',4,4,2,0,'Ariel Smith','2015-10-27 07:36:04','2015-10-27 08:53:34','2015-10-27 09:01:08',NULL,NULL,NULL),(9,1,1,9,'Very high concentration of parasites.',5,4,3,1,'Genghiz Khan','2015-10-27 07:36:04','2015-10-27 10:58:58','2015-10-27 09:06:25','2015-10-27 10:58:58',NULL,NULL),(10,5,1,10,'',2,4,0,0,'Dr. Abou Meyang','2015-10-27 07:36:04','2015-10-27 10:58:58',NULL,NULL,NULL,NULL),(11,4,6,11,'',2,2,0,0,'Fred Astaire','2015-10-27 07:36:04',NULL,NULL,NULL,NULL,NULL),(12,1,1,12,'',3,2,0,0,'Bony Em','2015-10-27 07:36:04','2015-10-27 10:58:58',NULL,NULL,NULL,NULL),(13,2,1,13,'Budda Boss',4,2,3,0,'Ed Buttler','2015-10-27 07:36:04','2015-10-27 10:58:58','2015-10-27 11:29:02',NULL,NULL,NULL),(14,3,5,14,'',2,2,0,0,'Dr. Abou Meyang','2015-10-27 07:36:04',NULL,NULL,NULL,NULL,NULL),(15,5,6,15,'',2,2,0,0,'Dr. Abou Meyang','2015-10-27 07:36:04',NULL,NULL,NULL,NULL,NULL),(16,2,5,16,'Whats this !!!! ###%%% ^ *() /',4,4,1,0,'Dr. Abou Meyang','2015-10-27 07:36:04','2015-10-27 11:29:02','2015-10-27 11:41:10',NULL,NULL,596699),(17,1,7,4,'Budda Boss',4,2,3,0,'Ariel Smith','2014-07-23 13:16:15','2014-07-23 14:07:15','2014-07-23 14:17:19',NULL,NULL,NULL),(18,2,8,3,'Budda Boss',4,2,3,0,'Ariel Smith','2014-07-26 08:16:15','2014-07-26 11:27:15','2014-07-26 11:57:01',NULL,NULL,NULL),(19,3,9,2,'Budda Boss',4,2,3,0,'Ariel Smith','2014-08-13 07:16:15','2014-08-13 08:07:15','2014-08-13 08:18:11',NULL,NULL,NULL),(20,4,10,1,'Budda Boss',4,2,3,0,'Ariel Smith','2014-08-16 07:06:53','2014-08-16 07:09:15','2014-08-16 07:23:37',NULL,NULL,NULL),(21,5,11,1,'Budda Boss',4,2,3,0,'Ariel Smith','2014-08-23 08:16:15','2014-08-23 09:54:39','2014-08-23 10:07:18',NULL,NULL,NULL),(22,6,12,2,'Budda Boss',4,2,3,0,'Ariel Smith','2014-09-07 05:23:15','2014-09-07 06:07:20','2014-09-07 06:41:13',NULL,NULL,NULL),(23,7,13,3,'Budda Boss',4,2,3,0,'Ariel Smith','2014-10-03 09:52:15','2014-10-03 10:31:04','2014-10-03 10:45:18',NULL,NULL,NULL),(24,1,14,4,'Budda Boss',4,2,3,0,'Ariel Smith','2014-10-15 15:01:15','2014-10-15 15:05:24','2014-10-15 16:07:15',NULL,NULL,NULL),(25,2,15,4,'Budda Boss',4,2,3,0,'Ariel Smith','2014-10-23 14:06:15','2014-10-23 14:07:15','2014-10-23 14:39:02',NULL,NULL,NULL),(26,4,7,3,'Budda Boss',4,2,3,0,'Ariel Smith','2014-10-21 17:16:15','2014-10-21 17:17:15','2014-10-21 17:52:40',NULL,NULL,NULL),(27,3,8,2,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-07-21 17:16:15','2014-07-21 17:17:15','2014-07-21 17:52:40','2014-07-21 17:53:48',NULL,NULL),(28,2,9,1,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-08-21 17:16:15','2014-08-21 17:17:15','2014-08-21 17:52:40','2014-08-21 17:53:48',NULL,NULL),(29,3,10,4,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-08-26 17:16:15','2014-08-26 17:17:15','2014-08-26 17:52:40','2014-08-26 17:53:48',NULL,NULL),(30,4,11,2,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-09-21 17:16:15','2014-09-21 17:17:15','2014-09-21 17:52:40','2014-09-21 17:53:48',NULL,NULL),(31,1,12,3,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-09-22 17:16:15','2014-09-22 17:17:15','2014-09-22 17:52:40','2014-09-22 17:53:48',NULL,NULL),(32,1,13,4,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-09-23 17:16:15','2014-09-23 17:17:15','2014-09-23 17:52:40','2014-09-23 17:53:48',NULL,NULL),(33,1,14,2,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-09-27 17:16:15','2014-09-27 17:17:15','2014-09-27 17:52:40','2014-09-27 17:53:48',NULL,NULL),(34,3,15,4,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-10-22 17:16:15','2014-10-22 17:17:15','2014-10-22 17:52:40','2014-10-22 17:53:48',NULL,NULL),(35,4,13,3,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-10-17 17:16:15','2014-10-17 17:17:15','2014-10-17 17:52:40','2014-10-17 17:53:48',NULL,NULL),(36,2,13,1,'Budda Boss',5,3,2,3,'Genghiz Khan','2014-10-02 17:16:15','2014-10-02 17:17:15','2014-10-02 17:52:40','2014-10-02 17:53:48',NULL,NULL);
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_measures`
--

LOCK TABLES `testtype_measures` WRITE;
/*!40000 ALTER TABLE `testtype_measures` DISABLE KEYS */;
INSERT INTO `testtype_measures` VALUES (1,1,1,NULL,NULL),(2,3,25,NULL,NULL),(3,3,26,NULL,NULL),(4,4,27,NULL,NULL),(5,5,28,NULL,NULL),(6,5,29,NULL,NULL),(7,5,30,NULL,NULL),(8,5,31,NULL,NULL),(9,5,32,NULL,NULL),(10,5,33,NULL,NULL),(11,5,34,NULL,NULL),(12,5,35,NULL,NULL),(13,5,36,NULL,NULL),(14,5,37,NULL,NULL),(15,5,38,NULL,NULL),(16,5,39,NULL,NULL),(17,5,40,NULL,NULL),(18,5,41,NULL,NULL),(19,5,42,NULL,NULL),(20,5,43,NULL,NULL),(21,5,44,NULL,NULL),(22,5,45,NULL,NULL),(23,6,46,NULL,NULL),(24,6,47,NULL,NULL),(25,6,48,NULL,NULL),(26,6,49,NULL,NULL),(27,6,50,NULL,NULL),(28,6,51,NULL,NULL),(29,7,52,NULL,NULL),(30,8,53,NULL,NULL),(31,9,54,NULL,NULL),(32,10,55,NULL,NULL),(33,11,56,NULL,NULL),(34,12,57,NULL,NULL),(35,13,58,NULL,NULL),(36,14,59,NULL,NULL),(37,15,60,NULL,NULL),(46,16,61,NULL,NULL),(47,16,62,NULL,NULL),(48,16,63,NULL,NULL),(49,16,64,NULL,NULL),(50,16,65,NULL,NULL),(51,16,66,NULL,NULL),(60,18,75,NULL,NULL),(61,18,76,NULL,NULL),(62,18,77,NULL,NULL),(63,18,78,NULL,NULL),(64,18,79,NULL,NULL),(65,18,80,NULL,NULL),(66,18,81,NULL,NULL),(67,19,82,NULL,NULL),(68,19,83,NULL,NULL),(69,19,84,NULL,NULL),(70,17,67,NULL,NULL),(71,17,68,NULL,NULL),(72,17,69,NULL,NULL),(73,17,70,NULL,NULL),(74,17,71,NULL,NULL),(75,17,72,NULL,NULL),(76,17,73,NULL,NULL),(77,17,74,NULL,NULL);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_organisms`
--

LOCK TABLES `testtype_organisms` WRITE;
/*!40000 ALTER TABLE `testtype_organisms` DISABLE KEYS */;
/*!40000 ALTER TABLE `testtype_organisms` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_specimentypes`
--

LOCK TABLES `testtype_specimentypes` WRITE;
/*!40000 ALTER TABLE `testtype_specimentypes` DISABLE KEYS */;
INSERT INTO `testtype_specimentypes` VALUES (1,1,23),(19,2,16),(2,3,23),(4,4,7),(5,4,8),(6,4,13),(3,4,23),(7,5,20),(8,5,21),(9,6,23),(10,7,13),(11,8,23),(12,9,23),(13,10,23),(14,11,23),(15,12,13),(16,13,20),(17,14,13),(18,15,13),(56,16,1),(57,16,2),(58,16,3),(59,16,5),(60,16,6),(61,16,8),(62,16,9),(63,16,10),(64,16,11),(65,16,12),(66,16,15),(67,16,16),(68,16,17),(69,16,18),(70,16,19),(71,16,20),(72,16,21),(73,16,23),(83,17,3),(75,18,1),(76,18,2),(77,18,9),(78,18,12),(79,18,15),(80,18,17),(81,18,20),(82,19,5);
/*!40000 ALTER TABLE `testtype_specimentypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tokens` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `tokens_email_index` (`email`),
  KEY `tokens_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topup_requests`
--

DROP TABLE IF EXISTS `topup_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topup_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commodity_id` int(10) unsigned NOT NULL,
  `test_category_id` int(10) unsigned NOT NULL,
  `order_quantity` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `remarks` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `topup_requests_test_category_id_foreign` (`test_category_id`),
  KEY `topup_requests_commodity_id_foreign` (`commodity_id`),
  KEY `topup_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `topup_requests_commodity_id_foreign` FOREIGN KEY (`commodity_id`) REFERENCES `commodities` (`id`),
  CONSTRAINT `topup_requests_test_category_id_foreign` FOREIGN KEY (`test_category_id`) REFERENCES `test_categories` (`id`),
  CONSTRAINT `topup_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topup_requests`
--

LOCK TABLES `topup_requests` WRITE;
/*!40000 ALTER TABLE `topup_requests` DISABLE KEYS */;
INSERT INTO `topup_requests` VALUES (1,1,1,1500,1,'-',NULL,'2015-10-27 08:36:05','2015-10-27 08:36:05');
/*!40000 ALTER TABLE `topup_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `designation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'administrator','$2y$10$FDz/uvo3zAqKtvLaTVVW5eQrayC5hu4CKtxcSSjYGRjF2FhmKt8ru','admin@kblis.org','kBLIS Administrator',0,'Programmer',NULL,'9lBdrfCODnhQ7UNZZaaaJoK5sn6pUj63CqvdrktuLIDVOYgpWZonFdiUKibP',NULL,'2015-10-27 08:36:03','2015-10-27 10:04:35'),(2,'external','$2y$10$VzE7WneLDCRnfqjfUFlm0OZMotD6GBIrGYLPBvb.W1UIufYP0cP2q','admin@kblis.org','External System User',0,'Administrator','/i/users/user-2.jpg',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(3,'lmorena','$2y$10$EGb3zbqHSSnliqb1ygelXuvK0XTYdXtZ4LaUClN0fBxvj4uZeEKMG','lmorena@kblis.org','L. Morena',0,'Lab Technologist','/i/users/user-3.png',NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(4,'abumeyang','$2y$10$y090qNeeoYeFWION3VNRdu9tVNGfBkhzIbmE9YJpnv.NYZNNCRyGS','abumeyang@kblis.org','A. Abumeyang',0,'Doctor',NULL,NULL,NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) unsigned NOT NULL,
  `visit_type` varchar(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Out-patient',
  `visit_number` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `visits_visit_number_index` (`visit_number`),
  KEY `visits_patient_id_foreign` (`patient_id`),
  CONSTRAINT `visits_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
INSERT INTO `visits` VALUES (1,5,'Out-patient',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(2,1,'Out-patient',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(3,1,'Out-patient',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(4,5,'Out-patient',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(5,3,'Out-patient',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(6,3,'Out-patient',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03'),(7,4,'Out-patient',NULL,'2015-10-27 08:36:03','2015-10-27 08:36:03');
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-29 16:15:55
