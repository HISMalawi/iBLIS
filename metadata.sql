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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wards`
--

LOCK TABLES `wards` WRITE;
/*!40000 ALTER TABLE `wards` DISABLE KEYS */;
INSERT INTO `wards` VALUES (1,'Ward 7A','2015-11-03 11:36:20','2015-11-03 11:36:20'),(2,'Ward 7B','2015-11-03 12:32:37','2015-11-03 12:32:37'),(3,'Ward 4A','2015-11-03 12:32:47','2015-11-03 12:32:47'),(4,'OPD 2','2015-11-04 10:00:57','2015-11-04 10:00:57'),(5,'Facilities','2015-11-04 10:09:30','2015-11-04 10:09:30');
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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visittype_wards`
--

LOCK TABLES `visittype_wards` WRITE;
/*!40000 ALTER TABLE `visittype_wards` DISABLE KEYS */;
INSERT INTO `visittype_wards` VALUES (23,2,3),(24,2,1),(25,2,2),(40,15,5),(41,15,4),(43,15,2),(44,13,5),(45,13,4),(46,13,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_types`
--

LOCK TABLES `test_types` WRITE;
/*!40000 ALTER TABLE `test_types` DISABLE KEYS */;
INSERT INTO `test_types` VALUES (1,'Microscopy','',2,'2',1,'',NULL,'2015-11-04 10:14:00','2015-11-03 13:49:09','2015-11-04 10:14:00'),(2,'Culture and Sensitivity','',2,'',1,'',1,NULL,'2015-11-04 08:59:00','2015-11-04 08:59:00'),(3,'Gram Stain','',2,'',1,'',NULL,NULL,'2015-11-05 12:29:16','2015-11-05 12:29:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_specimentypes`
--

LOCK TABLES `testtype_specimentypes` WRITE;
/*!40000 ALTER TABLE `testtype_specimentypes` DISABLE KEYS */;
INSERT INTO `testtype_specimentypes` VALUES (2,1,1),(5,2,1),(4,2,2),(3,2,3),(8,3,1),(7,3,2),(6,3,5);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_measures`
--

LOCK TABLES `testtype_measures` WRITE;
/*!40000 ALTER TABLE `testtype_measures` DISABLE KEYS */;
INSERT INTO `testtype_measures` VALUES (2,1,52,NULL,NULL),(3,2,53,NULL,NULL),(4,2,54,NULL,NULL),(5,2,55,NULL,NULL),(6,2,56,NULL,NULL),(7,2,57,NULL,NULL),(8,2,58,NULL,NULL),(9,3,59,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_organisms`
--

LOCK TABLES `testtype_organisms` WRITE;
/*!40000 ALTER TABLE `testtype_organisms` DISABLE KEYS */;
INSERT INTO `testtype_organisms` VALUES (1,2,1,NULL,'2015-11-04 08:59:01','2015-11-04 08:59:01'),(2,2,5,NULL,'2015-11-04 08:59:01','2015-11-04 08:59:01'),(3,2,4,NULL,'2015-11-04 08:59:01','2015-11-04 08:59:01'),(4,2,2,NULL,'2015-11-04 08:59:01','2015-11-04 08:59:01'),(5,2,3,NULL,'2015-11-04 08:59:01','2015-11-04 08:59:01');
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
INSERT INTO `test_categories` VALUES (1,'PARASITOLOGY','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(2,'MICROBIOLOGY','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(3,'HAEMATOLOGY','',NULL,'2015-11-03 11:05:20','2015-11-04 12:33:49'),(4,'SEROLOGY','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(5,'BLOOD BANK','',NULL,'2015-11-03 11:05:20','2015-11-04 09:36:50'),(6,'LAB RECEPTION','',NULL,'2015-11-04 09:34:28','2015-11-04 09:34:28'),(7,'BIOCHEMISTRY','',NULL,'2015-11-04 09:37:13','2015-11-04 09:37:13'),(8,'FLOWCYTOMETRY','',NULL,'2015-11-04 09:37:25','2015-11-04 09:37:25');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisms`
--

LOCK TABLES `organisms` WRITE;
/*!40000 ALTER TABLE `organisms` DISABLE KEYS */;
INSERT INTO `organisms` VALUES (1,'Haemophilus influenza',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(2,'Staphylococci',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(3,'Streptococcus pneumoniae',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(4,'Pseudomonas aeruginosa',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(5,'Neisseria meningitides',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20');
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organism_drugs`
--

LOCK TABLES `organism_drugs` WRITE;
/*!40000 ALTER TABLE `organism_drugs` DISABLE KEYS */;
INSERT INTO `organism_drugs` VALUES (1,1,1,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,2,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,1,17,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,1,4,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,1,5,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,1,7,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,1,13,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,2,2,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,2,4,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(10,2,5,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,2,7,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,2,8,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,2,9,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,2,10,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,2,11,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(16,2,12,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(17,3,4,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(18,3,7,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(19,3,8,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(20,3,9,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(21,3,12,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(22,3,13,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(23,4,15,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(24,4,5,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(25,4,10,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(26,4,14,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(27,4,16,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(28,5,3,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(29,5,4,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(30,5,5,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(31,5,7,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(32,5,17,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(33,5,18,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measures`
--

LOCK TABLES `measures` WRITE;
/*!40000 ALTER TABLE `measures` DISABLE KEYS */;
INSERT INTO `measures` VALUES (1,2,'BS for mps','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(2,2,'Grams stain','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(3,2,'SERUM AMYLASE','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(4,2,'calcium','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(5,2,'SGOT','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(6,2,'Indirect COOMBS test','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(7,2,'Direct COOMBS test','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(8,2,'Du test','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(9,1,'URIC ACID','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(10,4,'CSF for biochemistry','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(11,4,'PSA','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(12,1,'Total','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(13,1,'Alkaline Phosphate','u/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(14,1,'Direct','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(15,1,'Total Proteins','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(16,4,'LFTS','NULL',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(17,1,'Chloride','mmol/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(18,1,'Potassium','mmol/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(19,1,'Sodium','mmol/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(20,4,'Electrolytes','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(21,1,'Creatinine','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(22,1,'Urea','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(23,4,'RFTS','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(24,4,'TFT','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(25,4,'GXM','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(26,2,'Blood Grouping','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(27,1,'HB','g/dL',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(28,4,'Urine microscopy','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(29,4,'Pus cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(30,4,'S. haematobium','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(31,4,'T. vaginalis','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(32,4,'Yeast cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(33,4,'Red blood cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(34,4,'Bacteria','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(35,4,'Spermatozoa','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(36,4,'Epithelial cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(37,4,'ph','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(38,4,'Urine chemistry','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(39,4,'Glucose','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(40,4,'Ketones','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(41,4,'Proteins','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(42,4,'Blood','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(43,4,'Bilirubin','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(44,4,'Urobilinogen Phenlpyruvic acid','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(45,4,'pH','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(46,1,'WBC','x10³/µL',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(47,1,'Lym','L',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(48,1,'Mon','*',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(49,1,'Neu','*',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL),(50,1,'Eos','',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21',NULL),(51,1,'Baso','',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21',NULL),(52,4,'tb','','','2015-11-03 13:49:09','2015-11-03 13:49:09',NULL),(53,4,'Sample Location (Swab)','','','2015-11-04 08:59:00','2015-11-04 08:59:00',NULL),(54,4,'Sample Appearance (Fluids)','','','2015-11-04 08:59:00','2015-11-04 08:59:00',NULL),(55,2,'Culture','','','2015-11-04 08:59:00','2015-11-04 08:59:00',NULL),(56,2,'Gram Stain','','','2015-11-04 08:59:01','2015-11-04 08:59:01',NULL),(57,2,'Gram Stain Morphology','','','2015-11-04 08:59:01','2015-11-04 08:59:01',NULL),(58,4,'Gram Stain Remarks','','','2015-11-04 08:59:01','2015-11-04 08:59:01',NULL),(59,4,'gram','','','2015-11-05 12:29:16','2015-11-05 12:29:16',NULL);
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
  `range_lower` decimal(7,3) DEFAULT NULL,
  `range_upper` decimal(7,3) DEFAULT NULL,
  `alphanumeric` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interpretation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `measure_ranges_alphanumeric_index` (`alphanumeric`),
  KEY `measure_ranges_measure_id_foreign` (`measure_id`),
  CONSTRAINT `measure_ranges_measure_id_foreign` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure_ranges`
--

LOCK TABLES `measure_ranges` WRITE;
/*!40000 ALTER TABLE `measure_ranges` DISABLE KEYS */;
INSERT INTO `measure_ranges` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,'No mps seen','Negative',NULL),(2,1,NULL,NULL,NULL,NULL,NULL,'+','Positive',NULL),(3,1,NULL,NULL,NULL,NULL,NULL,'++','Positive',NULL),(4,1,NULL,NULL,NULL,NULL,NULL,'+++','Positive',NULL),(5,2,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(6,2,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(7,3,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL),(8,3,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL),(9,3,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL),(10,4,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL),(11,4,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL),(12,4,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL),(13,5,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL),(14,5,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL),(15,5,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL),(16,6,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(17,6,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(18,7,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(19,7,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(20,8,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL),(21,8,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL),(22,26,NULL,NULL,NULL,NULL,NULL,'O-',NULL,NULL),(23,26,NULL,NULL,NULL,NULL,NULL,'O+',NULL,NULL),(24,26,NULL,NULL,NULL,NULL,NULL,'A-',NULL,NULL),(25,26,NULL,NULL,NULL,NULL,NULL,'A+',NULL,NULL),(26,26,NULL,NULL,NULL,NULL,NULL,'B-',NULL,NULL),(27,26,NULL,NULL,NULL,NULL,NULL,'B+',NULL,NULL),(28,26,NULL,NULL,NULL,NULL,NULL,'AB-',NULL,NULL),(29,26,NULL,NULL,NULL,NULL,NULL,'AB+',NULL,NULL),(30,46,0,100,2,4.000,11.000,NULL,NULL,NULL),(31,47,0,100,2,1.500,4.000,NULL,NULL,NULL),(32,48,0,100,2,0.100,9.000,NULL,NULL,NULL),(33,49,0,100,2,2.500,7.000,NULL,NULL,NULL),(34,50,0,100,2,0.000,6.000,NULL,NULL,NULL),(35,51,0,100,2,0.000,2.000,NULL,NULL,NULL),(36,55,NULL,NULL,NULL,NULL,NULL,'Not performed','',NULL),(37,55,NULL,NULL,NULL,NULL,NULL,'No growth 24 hrs','',NULL),(38,55,NULL,NULL,NULL,NULL,NULL,'No growth 48 hrs','',NULL),(39,55,NULL,NULL,NULL,NULL,NULL,'No growth 72 hrs','NEGATIVE',NULL),(40,55,NULL,NULL,NULL,NULL,NULL,'Growth','POSITIVE',NULL),(41,56,NULL,NULL,NULL,NULL,NULL,'Gram Positve','',NULL),(42,56,NULL,NULL,NULL,NULL,NULL,'Gram Negative','',NULL),(43,56,NULL,NULL,NULL,NULL,NULL,'Gram Variable','',NULL),(44,57,NULL,NULL,NULL,NULL,NULL,'Cocci','',NULL),(45,57,NULL,NULL,NULL,NULL,NULL,'Bacilli','',NULL),(46,57,NULL,NULL,NULL,NULL,NULL,'Cocci-Bacilli','',NULL),(47,57,NULL,NULL,NULL,NULL,NULL,'Diplococci','',NULL),(48,57,NULL,NULL,NULL,NULL,NULL,'Yeast','',NULL),(49,57,NULL,NULL,NULL,NULL,NULL,'Other','',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drugs`
--

LOCK TABLES `drugs` WRITE;
/*!40000 ALTER TABLE `drugs` DISABLE KEYS */;
INSERT INTO `drugs` VALUES (1,'Amoxicillin/Clavulanate',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(2,'Ampicillin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(3,'Ceftriaxone',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(4,'Chloramphenicol',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(5,'Ciprofloxacin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(6,'Tetracyline',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(7,'Trimethoprim/Sulfamethoxazole',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(8,'Clindamycin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(9,'Erythromycin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(10,'Gentamicin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(11,'Penicillin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(12,'Oxacillin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(13,'Tetracycline',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(14,'Ceftazidime',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(15,'Piperacillin',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(16,'Piperacillin/Tazobactam',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(17,'Ceftriaxon',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20'),(18,'Cefotaxim',NULL,NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20');
/*!40000 ALTER TABLE `drugs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-05 14:55:43
