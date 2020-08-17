-- MySQL dump 10.13  Distrib 5.7.31, for Linux (x86_64)
--
-- Host: localhost    Database: iblis
-- ------------------------------------------------------
-- Server version	5.7.31-0ubuntu0.18.04.1

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
  `hl7_identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_coding_system` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wards`
--

LOCK TABLES `wards` WRITE;
/*!40000 ALTER TABLE `wards` DISABLE KEYS */;
INSERT INTO `wards` VALUES (1,'Facilities','2020-08-08 12:24:12','2020-08-08 12:24:12');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit_types`
--

LOCK TABLES `visit_types` WRITE;
/*!40000 ALTER TABLE `visit_types` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visittype_wards`
--

LOCK TABLES `visittype_wards` WRITE;
/*!40000 ALTER TABLE `visittype_wards` DISABLE KEYS */;
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
  `short_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `test_category_id` int(10) unsigned NOT NULL,
  `targetTAT` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orderable_test` int(11) DEFAULT NULL,
  `prevalence_threshold` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accredited` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hl7_identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_coding_system` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `print_device` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_types_test_category_id_foreign` (`test_category_id`),
  CONSTRAINT `test_types_test_category_id_foreign` FOREIGN KEY (`test_category_id`) REFERENCES `test_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_types`
--

LOCK TABLES `test_types` WRITE;
/*!40000 ALTER TABLE `test_types` DISABLE KEYS */;
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
INSERT INTO `test_statuses` VALUES (1,'not-received',1),(2,'pending',1),(3,'started',2),(4,'completed',3),(5,'verified',3),(6,'voided',2),(7,'not-done',2),(8,'test-rejected',1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_specimentypes`
--

LOCK TABLES `testtype_specimentypes` WRITE;
/*!40000 ALTER TABLE `testtype_specimentypes` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_measures`
--

LOCK TABLES `testtype_measures` WRITE;
/*!40000 ALTER TABLE `testtype_measures` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_categories`
--

LOCK TABLES `test_categories` WRITE;
/*!40000 ALTER TABLE `test_categories` DISABLE KEYS */;
INSERT INTO `test_categories` VALUES (1,'Parasitology','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12'),(2,'Microbiology','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12'),(3,'Haematology','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12'),(4,'Serology','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12'),(5,'Blood Transfusion','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12'),(6,'Lab Reception','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12');
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
  `hl7_identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_coding_system` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_types`
--

LOCK TABLES `specimen_types` WRITE;
/*!40000 ALTER TABLE `specimen_types` DISABLE KEYS */;
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
INSERT INTO `roles` VALUES (1,'Superadmin',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13'),(2,'Technologist',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13'),(3,'Receptionist',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13');
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
  `hl7_identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_coding_system` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organisms_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisms`
--

LOCK TABLES `organisms` WRITE;
/*!40000 ALTER TABLE `organisms` DISABLE KEYS */;
INSERT INTO `organisms` VALUES (1,'Haemophilus influenza',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(2,'Staphylococci',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(3,'Streptococcus pneumoniae',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(4,'Pseudomonas aeruginosa',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(5,'Neisseria meningitides',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(6,'Acinetobacter baumannii / haemolytlcus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(7,'Escherichia coli coli 0157',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(8,'Acinetobacter lwoffii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(9,'Escherichia',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(10,'Acinetobacter species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(11,'Flavimonas species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(12,'Fusobacterium nucleatum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(13,'Aeromonas hydrophila',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(14,'Fusibacterium species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(15,'Aeromonas species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(16,'Gamella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(17,'Aggregatibacter aphrophilus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(18,'Gemella morbillorum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(19,'Alcaligenes faecalis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(20,'Gram-negative bacillus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(21,'Alcaligenes species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(22,'Gram negative bacillus, aerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(23,'Bacillus cereus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(24,'Gram negative bacillus, anaerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(25,'Bacillus coagulans',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(26,'Gram-negative coccobacillus, aerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(27,'Bacillus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(28,'Gram-negative coccus, anerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(29,'Bacillus subtilis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(30,'Gram-negative diplococcus, aerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(31,'Bacteroides fragilis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(32,'Gram-negative diplococcus. anerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(33,'Bacteroides ovatus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(34,'Gram-positive bacillus, aerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(35,'Bacteroided species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(36,'Gram-positive bacillus, anaerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(37,'Bacteroides vulgates',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(38,'Gram-positive bacillus, endospore forming, aerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(39,'Bordetella bronchiseptica',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(40,'Bordetella parapertussis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(41,'Gram-positive bacillus, endospore forming, anaerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(42,'Bordetella penussis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(43,'Bordetella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(44,'Gram-positive bacillus, non-spore forming, aerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(45,'Burkholderia cepacia',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(46,'Gram-positive bacillus, non-spore forming, anaerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(47,'Burkholderia species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(48,'Campylobacterjejuni',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(49,'Gram-positive coccus, aerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(50,'Campylobacter species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(51,'Gram-positive coccus, anaerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(52,'Candida albicans',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(53,'Gram positive diplococcus, anaerobic',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(54,'Candida species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(55,'Haemophilus ducreyi',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(56,'Capnocytophaga species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(57,'Haemophilus influenzae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(58,'Capnocytophaga sputigena',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(59,'Haemophilus influenzae b',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(60,'Cardiobacterium hominis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(61,'Harnophilus parahaemolyticus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(62,'Cardiobacterium species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(63,'Haemophilus parainfluenzae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(64,'Chryseobacterium meningosepticum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(65,'Haemophilus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(66,'Chryseobacterium species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(67,'Hafnia alvei',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(68,'Citrobacter freundii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(69,'Hafnia species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(70,'Citrobacter koseri',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(71,'Kingella kingae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(72,'Citrobacter species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(73,'Kingella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(74,'Clostridium difficile',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(75,'Klebsiella oxytoca',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(76,'Clostridium perfringens',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(77,'Klebsiella ozaenae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(78,'Klebsiella pneumoniae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(79,'Clostridium ramosum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(80,'Klebsiella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(81,'Clostridium septicum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(82,'Lactobacillus fermentum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(83,'Clostridium sordellii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(84,'Lactobacillus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(85,'Clostridium species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(86,'Legionella pneumophila',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(87,'Corynebacterium diptheriae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(88,'Legionella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(89,'Corynebacterium species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(90,'Leuconostoc mesenteroides',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(91,'Corynebacterium striatum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(92,'Leuconostoc paramesenteroides',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(93,'Corynebacterium uealyticum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(94,'Leuconostoc species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(95,'Cronobacter sakazakii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(96,'Listeria monocytogenes',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(97,'Cryptococcus neoformans',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(98,'Listeria species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(99,'Cryptococcus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(100,'Micrococcus luteus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(101,'Eikenella corrodens',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(102,'Micrococcus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(103,'Eikenella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(104,'Moraxella catarrhalis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(105,'Enterobacter aerogenes',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(106,'Moraxella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(107,'Enterobacter cloacae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(108,'Morganella morganii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(109,'Enterobacter species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(110,'Morganella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(111,'Enterococcus casseliflavus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(112,'Neisseria gonorrhoeae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(113,'Enterococcus durans',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(114,'Neisseria lactamica',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(115,'Enterococcus faecalis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(116,'Neisseria meningitidis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(117,'Enterococcus faecium',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(118,'Enterococcus gallinarum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(119,'Neisseria species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(120,'Enterococcus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(121,'Nocardia species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(122,'Erysipelothrixs species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(123,'Pantoea agglomerans',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(124,'Shigella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(125,'Staphylcoccus aureus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(126,'Staphylococcus cohnii subsp, cohnii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(127,'Staphylococcus epidermidis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(128,'Staphylococcus haemolyticus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(129,'Pantoea species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(130,'Pasturella multocida',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(131,'Streptococcus agalactiae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(132,'Pasturella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(133,'Streptococcus anginosus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(134,'Pediococcus pentosaceus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(135,'Streptococcus bovis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(136,'Pedicoccus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(137,'Streptococcus equi',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(138,'Petoniphilus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(139,'Streptococcus milleri',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(140,'Peptostreptococcus anaerobius',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(141,'Streptococcus oralis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(142,'Plesiomonas shigelloides',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(143,'Plesiomonas species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(144,'Streptococcus pyogenes',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(145,'Prevotella bivia',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(146,'Streptococcus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(147,'Prevotella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(148,'Streptococcus thermophilus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(149,'Proprionibacterium acne',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(150,'Streptococcus viridians',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(151,'Propionibacterium species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(152,'Streptococcus viridians (gordonii)',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(153,'Proteus mirabilis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(154,'Streptococcus viridians (mitor)',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(155,'Proteus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(156,'Streptococcus viridians (mutans)',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(157,'Proteus vulgaris',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(158,'Streptococcus viridians (sanguis)',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(159,'Providencia retgerii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(160,'Veillonella parvula',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(161,'Providencia species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(162,'Veillonella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(163,'Provedencia stuartii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(164,'Vibrio alginolyticus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(165,'Vibrio cholerae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(166,'Pseudomonas psudomallei',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(167,'Vibrio cholerae Non 01',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(168,'Pseudomonas species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(169,'Vibrio cholerae 01 (Ogawa)',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(170,'Ralstonia picketii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(171,'Vibrio cholerae 01 (Inaba)',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(172,'Rhodococcus equi',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(173,'Vibrio parahaemolyticus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(174,'Rhodococcus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(175,'Vibrio species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(176,'Roseomonas gilardii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(177,'Yersinia enterocolitica',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(178,'Roseomonas species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(179,'Salmonella Arizonae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(180,'Yersinia pseudotuberculosis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(181,'Salmonella Enteritidis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(182,'Yersinia species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(183,'Salmonella Gallinarum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(184,'Presumptive Yersinia pestis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(185,'Salmonalla Isangi',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(186,'Not presumptive Yersinia pestis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(187,'Salmonella paratyphi A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(188,'Contaminated specimen',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(189,'Final identification not stated',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(190,'Salmonella paratyphi B',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(191,'No anaerobes isolated',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(192,'Salmonella paratyphi C',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(193,'No growth',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(194,'Salmonella pullorum',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(195,'Testing not performed on given specimen',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(196,'Salmonella species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(197,'Salmonella Typhi',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(198,'Salmonella Typhimurium',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(199,'Serratia liquifaciens',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(200,'Serratia marcescens',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(201,'Serratia species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(202,'Shewanella putrefaciens',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(203,'Shigella boydii',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(204,'Shigella dysenteriae',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(205,'Shigella flexneri',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(206,'Shigella sonnei',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(207,'Usual flora for site',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(208,'Staphylococcus lugdenesis',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(209,'Staphylococcus saprophyticus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(210,'Staphylococcus sciuri',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(211,'Staphylococcus species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(212,'Staphylococcus xylosus',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(213,'Strenotrophomonas maltophilia',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','',''),(214,'Stenotrophomonas species',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','');
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
  `hl7_identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_coding_system` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `measures_measure_type_id_foreign` (`measure_type_id`),
  CONSTRAINT `measures_measure_type_id_foreign` FOREIGN KEY (`measure_type_id`) REFERENCES `measure_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measures`
--

LOCK TABLES `measures` WRITE;
/*!40000 ALTER TABLE `measures` DISABLE KEYS */;
INSERT INTO `measures` VALUES (1,2,'BS for mps','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12',NULL,'','',''),(2,2,'Grams stain','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12',NULL,'','',''),(3,2,'SERUM AMYLASE','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12',NULL,'','',''),(4,2,'calcium','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12',NULL,'','',''),(5,2,'SGOT','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12',NULL,'','',''),(6,2,'Indirect COOMBS test','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12',NULL,'','',''),(7,2,'Direct COOMBS test','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12',NULL,'','',''),(8,2,'Du test','',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12',NULL,'','',''),(9,1,'URIC ACID','mg/dl',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(10,4,'CSF for biochemistry','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(11,4,'PSA','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(12,1,'Total','mg/dl',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(13,1,'Alkaline Phosphate','u/l',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(14,1,'Direct','mg/dl',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(15,1,'Total Proteins','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(16,4,'LFTS','NULL',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(17,1,'Chloride','mmol/l',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(18,1,'Potassium','mmol/l',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(19,1,'Sodium','mmol/l',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(20,4,'Electrolytes','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(21,1,'Creatinine','mg/dl',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(22,1,'Urea','mg/dl',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(23,4,'RFTS','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(24,4,'TFT','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(25,4,'GXM','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(26,2,'Blood Grouping','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(27,1,'HB','g/dL',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(28,4,'Urine microscopy','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(29,4,'Pus cells','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(30,4,'S. haematobium','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(31,4,'T. vaginalis','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(32,4,'Yeast cells','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(33,4,'Red blood cells','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(34,4,'Bacteria','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(35,4,'Spermatozoa','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(36,4,'Epithelial cells','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(37,4,'ph','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(38,4,'Urine chemistry','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(39,4,'Glucose','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(40,4,'Ketones','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(41,4,'Proteins','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(42,4,'Blood','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(43,4,'Bilirubin','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(44,4,'Urobilinogen Phenlpyruvic acid','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(45,4,'pH','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(46,1,'WBC','x10³/µL',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(47,1,'Lym','L',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(48,1,'Mon','*',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(49,1,'Neu','*',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(50,1,'Eos','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','',''),(51,1,'Baso','',NULL,'2020-08-08 12:24:13','2020-08-08 12:24:13',NULL,'','','');
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
INSERT INTO `measure_types` VALUES (1,'Numeric Range',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12'),(2,'Alphanumeric Values',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12'),(3,'Autocomplete',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12'),(4,'Free Text',NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12');
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
  `hl7_identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_coding_system` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_measure_type_override` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `measure_ranges_alphanumeric_index` (`alphanumeric`),
  KEY `measure_ranges_measure_id_foreign` (`measure_id`),
  CONSTRAINT `measure_ranges_measure_id_foreign` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure_ranges`
--

LOCK TABLES `measure_ranges` WRITE;
/*!40000 ALTER TABLE `measure_ranges` DISABLE KEYS */;
INSERT INTO `measure_ranges` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,'No mps seen','Negative',NULL,'','','',''),(2,1,NULL,NULL,NULL,NULL,NULL,'+','Positive',NULL,'','','',''),(3,1,NULL,NULL,NULL,NULL,NULL,'++','Positive',NULL,'','','',''),(4,1,NULL,NULL,NULL,NULL,NULL,'+++','Positive',NULL,'','','',''),(5,2,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL,'','','',''),(6,2,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL,'','','',''),(7,3,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL,'','','',''),(8,3,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL,'','','',''),(9,3,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL,'','','',''),(10,4,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL,'','','',''),(11,4,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL,'','','',''),(12,4,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL,'','','',''),(13,5,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL,'','','',''),(14,5,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL,'','','',''),(15,5,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL,'','','',''),(16,6,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL,'','','',''),(17,6,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL,'','','',''),(18,7,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL,'','','',''),(19,7,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL,'','','',''),(20,8,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL,'','','',''),(21,8,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL,'','','',''),(22,26,NULL,NULL,NULL,NULL,NULL,'O-',NULL,NULL,'','','',''),(23,26,NULL,NULL,NULL,NULL,NULL,'O+',NULL,NULL,'','','',''),(24,26,NULL,NULL,NULL,NULL,NULL,'A-',NULL,NULL,'','','',''),(25,26,NULL,NULL,NULL,NULL,NULL,'A+',NULL,NULL,'','','',''),(26,26,NULL,NULL,NULL,NULL,NULL,'B-',NULL,NULL,'','','',''),(27,26,NULL,NULL,NULL,NULL,NULL,'B+',NULL,NULL,'','','',''),(28,26,NULL,NULL,NULL,NULL,NULL,'AB-',NULL,NULL,'','','',''),(29,26,NULL,NULL,NULL,NULL,NULL,'AB+',NULL,NULL,'','','',''),(30,46,0,100,2,4.000,11.000,NULL,NULL,NULL,'','','',''),(31,47,0,100,2,1.500,4.000,NULL,NULL,NULL,'','','',''),(32,48,0,100,2,0.100,9.000,NULL,NULL,NULL,'','','',''),(33,49,0,100,2,2.500,7.000,NULL,NULL,NULL,'','','',''),(34,50,0,100,2,0.000,6.000,NULL,NULL,NULL,'','','',''),(35,51,0,100,2,0.000,2.000,NULL,NULL,NULL,'','','','');
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
  `hl7_identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hl7_coding_system` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `drugs_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drugs`
--

LOCK TABLES `drugs` WRITE;
/*!40000 ALTER TABLE `drugs` DISABLE KEYS */;
INSERT INTO `drugs` VALUES (1,'Amoxicillin/Clavulanate',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(2,'Ampicillin',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(3,'Ceftriaxone',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(4,'Chloramphenicol',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(5,'Ciprofloxacin',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(6,'Tetracyline',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(7,'Trimethoprim/Sulfamethoxazole',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(8,'Clindamycin',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(9,'Erythromycin',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(10,'Gentamicin',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(11,'Penicillin',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(12,'Oxacillin',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(13,'Tetracycline',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(14,'Ceftazidime',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(15,'Piperacillin',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(16,'Piperacillin/Tazobactam',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(17,'Ceftriaxon',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','',''),(18,'Cefotaxim',NULL,NULL,'2020-08-08 12:24:12','2020-08-08 12:24:12','','','');
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1),(10,10,1),(11,11,1),(12,12,1),(13,13,1),(14,14,1),(15,15,1),(16,16,1),(17,17,1),(18,18,1),(19,19,1),(20,20,1),(21,21,1),(22,22,1);
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
  `short_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `panel_types`
--

LOCK TABLES `panel_types` WRITE;
/*!40000 ALTER TABLE `panel_types` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `panels`
--

LOCK TABLES `panels` WRITE;
/*!40000 ALTER TABLE `panels` DISABLE KEYS */;
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

-- Dump completed on 2020-08-08 13:28:18
