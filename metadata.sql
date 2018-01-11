
-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: iblis
-- ------------------------------------------------------
-- Server version	5.5.38-0ubuntu0.14.04.1

-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: iblis
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1


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

) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;

INSERT INTO `facilities` VALUES (20,'Chikwawa District Hospital','2016-03-01 13:35:17','2016-03-01 13:35:17','','',''),(21,'Chiradzulo District Hospital','2016-03-01 13:35:48','2016-03-01 13:35:48','','',''),(22,'Machinga District Hospital','2016-03-01 13:36:03','2016-03-01 13:36:03','','',''),(23,'Mulanje District Hospital','2016-03-01 13:36:16','2016-03-01 13:36:16','','',''),(24,'Mwanza District Hospital','2016-03-01 13:36:29','2016-03-01 13:36:29','','',''),(26,'QECH','2016-03-01 13:36:49','2016-03-01 13:36:49','','',''),(27,'Thyolo District Hospital','2016-03-01 13:37:31','2016-03-01 13:37:31','','',''),(28,'ZCH','2016-03-01 13:37:46','2016-03-01 13:37:46','','',''),(31,'Mpemba Health centre','2017-04-03 13:35:30','2017-04-03 13:35:30','','',''),(32,'Ndirande Health centre','2017-04-03 13:38:15','2017-04-03 13:38:15','','',''),(33,'Chilomoni Health centre','2017-04-03 13:38:34','2017-04-03 13:38:34','','',''),(34,'Chichiri prison','2017-04-03 13:38:54','2017-04-03 13:38:54','','',''),(35,'Limbe Health centre','2017-04-03 13:39:17','2017-04-03 13:39:17','','',''),(36,'Bangwe health centre','2017-04-03 13:39:40','2017-04-03 13:39:40','','',''),(37,'Chileka Health centre','2017-04-03 13:40:04','2017-04-03 13:40:04','','',''),(38,'Nsanje District hospital','2017-04-03 13:42:58','2017-04-03 13:42:58','','',''),(39,'Gateway','2017-04-03 14:40:21','2017-04-03 14:40:21','','',''),(40,'Blantyre District hospital','2017-04-03 14:40:55','2017-04-03 14:40:55','','','');

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

) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wards`
--

LOCK TABLES `wards` WRITE;
/*!40000 ALTER TABLE `wards` DISABLE KEYS */;

INSERT INTO `wards` VALUES (4,'OPD 2','2015-11-04 10:00:57','2015-11-04 10:00:57'),(5,'Facilities','2015-11-04 10:09:30','2015-11-04 10:09:30'),(6,'OPD 1','2015-11-05 19:58:10','2015-11-05 19:58:10'),(9,'Theatre','2016-03-01 12:50:08','2016-03-01 12:50:08'),(10,'Dialysis Unit','2016-03-01 12:50:19','2016-03-01 12:50:19'),(11,'ICU','2016-03-01 12:50:43','2016-03-01 12:50:43'),(12,'1A','2016-03-01 12:50:53','2016-03-01 12:50:53'),(13,'1B','2016-03-01 12:50:58','2016-03-01 12:50:58'),(14,'2A','2016-03-01 12:51:03','2016-03-01 12:51:03'),(15,'2B','2016-03-01 12:51:07','2016-03-01 12:51:07'),(16,'Oncology','2016-03-01 12:51:16','2016-03-01 12:51:16'),(17,'3A','2016-03-01 12:53:28','2016-03-01 12:53:28'),(18,'3B','2016-03-01 12:53:33','2016-03-01 12:53:33'),(19,'4A','2016-03-01 13:01:02','2016-03-01 13:01:02'),(20,'4B','2016-03-01 13:01:15','2016-03-01 13:01:15'),(23,'Skin','2016-03-01 13:08:19','2016-03-01 13:08:19'),(25,'Dental','2016-03-01 13:08:44','2016-03-01 13:08:44'),(26,'Eye','2016-03-01 13:08:48','2016-03-01 13:08:48'),(27,'Under 5 Clinic','2016-03-01 13:09:21','2016-03-01 13:09:21'),(31,'lab','2016-03-01 13:13:03','2017-04-07 06:40:37'),(32,'ENT Clinic','2016-03-01 13:13:19','2016-03-01 13:17:35'),(33,'Anesthesia','2016-03-01 13:13:51','2016-03-01 13:13:51'),(35,'Gynae OPD','2016-03-01 13:15:18','2017-04-03 08:10:26'),(39,'EM Nursery','2016-03-01 13:19:01','2016-03-01 13:19:01'),(40,'GYNAE','2016-03-01 13:19:20','2016-03-01 13:19:20'),(41,'ANC','2016-03-01 13:19:44','2016-03-01 13:19:44'),(42,'Post Natal Ward','2016-03-01 13:20:17','2017-04-07 06:43:19'),(55,'Other','2016-04-08 12:59:24','2016-04-08 12:59:24'),(63,'AETC','2017-03-31 17:01:11','2017-03-31 17:01:11'),(64,'A and E','2017-03-31 17:01:37','2017-03-31 17:01:37'),(67,'Surgery','2017-03-31 17:02:19','2017-03-31 17:02:19'),(70,'Paeds1','2017-03-31 17:03:02','2017-04-11 08:44:03'),(72,'Ophthalmology','2017-03-31 17:03:37','2017-03-31 17:03:37'),(74,'ART/HTC','2017-03-31 17:04:23','2017-03-31 17:04:23'),(75,'Burns Unit','2017-04-03 05:39:21','2017-04-03 05:39:21'),(76,'5A','2017-04-03 08:00:42','2017-04-03 08:00:42'),(77,'5B','2017-04-03 08:00:58','2017-04-03 08:00:58'),(78,'LW','2017-04-03 08:01:26','2017-04-03 08:01:26'),(79,'6A','2017-04-03 08:01:53','2017-04-03 08:01:53'),(81,'Peads Oncology','2017-04-03 08:05:54','2017-04-03 08:05:54'),(82,'Peads Orthopeadics','2017-04-03 08:06:25','2017-04-03 08:06:25'),(83,'Peads Surgical Ward','2017-04-03 08:06:41','2017-04-07 06:42:18'),(84,'Peads Special Care Ward','2017-04-03 08:06:49','2017-04-07 06:42:57'),(85,'Peads Nursery','2017-04-03 08:07:25','2017-04-03 08:07:25'),(86,'Chatinkha Nursery','2017-04-03 08:07:40','2017-04-03 08:07:40'),(87,'Room 1','2017-04-03 08:12:58','2017-04-03 08:12:58'),(88,'Room 6','2017-04-03 08:13:10','2017-04-03 08:13:10'),(89,'Room 9','2017-04-03 08:13:48','2017-04-03 08:13:48'),(90,'Room 4','2017-04-03 08:14:03','2017-04-03 08:14:03'),(91,'Room 8','2017-04-03 08:15:22','2017-04-03 08:15:22'),(92,'ANW','2017-04-11 08:27:29','2017-04-11 08:27:29'),(94,'Neuro','2017-04-12 14:19:49','2017-04-12 14:19:49'),(95,'STI','2017-04-13 07:58:23','2017-04-13 07:58:23'),(96,'HRANC','2017-04-21 11:31:04','2017-04-21 11:31:04');

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

) ENGINE=InnoDB AUTO_INCREMENT=612 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visittype_wards`
--

LOCK TABLES `visittype_wards` WRITE;
/*!40000 ALTER TABLE `visittype_wards` DISABLE KEYS */;

INSERT INTO `visittype_wards` VALUES (476,15,5),(559,2,12),(560,2,13),(561,2,14),(562,2,15),(563,2,17),(564,2,18),(565,2,19),(566,2,20),(567,2,76),(568,2,77),(569,2,79),(570,2,33),(571,2,92),(572,2,75),(573,2,86),(574,2,10),(575,2,39),(576,2,32),(577,2,26),(578,2,40),(579,2,96),(580,2,11),(581,2,78),(582,2,94),(583,2,55),(584,2,70),(585,2,85),(586,2,81),(587,2,82),(588,2,84),(589,2,83),(590,2,42),(591,2,27),(592,13,64),(593,13,63),(594,13,41),(595,13,74),(596,13,25),(597,13,26),(598,13,35),(599,13,96),(600,13,16),(601,13,6),(602,13,4),(603,13,55),(604,13,87),(605,13,90),(606,13,88),(607,13,91),(608,13,89),(609,13,23),(610,13,95),(611,13,27);

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

) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_types`
--

LOCK TABLES `test_types` WRITE;
/*!40000 ALTER TABLE `test_types` DISABLE KEYS */;

INSERT INTO `test_types` VALUES (1,'TB Microscopic Exam','AFB','',2,'20 min',NULL,'',NULL,'2016-03-01 14:48:47','2015-11-03 13:49:09','2016-03-07 16:43:11',NULL),(2,'GeneXpert','GXp','',2,'6 hrs',NULL,'',NULL,'2016-03-01 15:36:36','2015-11-04 08:59:00','2016-03-07 16:43:11',NULL),(3,'Gram Stain','GS','',2,'1 hr',1,'',NULL,NULL,'2015-11-05 12:29:16','2016-03-07 16:43:11',NULL),(4,'Culture & Sensitivity','C&S','',2,'7 days',1,'',NULL,NULL,'2015-11-06 05:24:20','2016-03-07 16:43:11',NULL),(5,'Cell Count','ClCt','',2,'1 hr',1,'',NULL,NULL,'2015-11-06 07:30:59','2016-03-07 16:43:11',NULL),(6,'India Ink','II','',2,'1 hr',1,'',NULL,NULL,'2015-11-06 07:32:32','2016-03-07 16:43:11',NULL),(7,'Differential','Diff','',2,'1 hr',1,'',NULL,NULL,'2015-11-06 07:43:01','2016-03-07 16:43:11',NULL),(8,'ZN Stain','ZN','',2,'2hrs',1,'',NULL,NULL,'2015-11-12 21:43:18','2017-04-11 12:20:24',NULL),(9,'Wet prep','WP','',2,'30 min',NULL,'',NULL,'2016-03-01 15:23:07','2015-11-12 21:45:55','2016-03-07 16:43:11',NULL),(10,'TB Tests','TB','',2,'5 hrs',1,'',NULL,NULL,'2015-11-12 21:54:38','2016-03-07 16:43:11',NULL),(11,'Urine Macroscopy','UA','',1,'30 min',1,'',NULL,NULL,'2015-12-10 07:59:44','2016-03-07 16:43:11',NULL),(12,'Urine Microscopy','UA','',1,'30 min',1,'',NULL,NULL,'2015-12-10 08:06:20','2016-03-07 16:43:11',NULL),(13,'Urine Chemistries','UA','',1,'30 min',1,'',NULL,NULL,'2015-12-10 08:59:57','2016-03-07 16:43:11',NULL),(14,'Stool Analysis','StoA','',1,'30 min',1,'',NULL,NULL,'2015-12-10 09:17:47','2016-03-07 16:43:11',NULL),(15,'Malaria Screening','MalScr','',1,'3hrs',1,'',NULL,NULL,'2015-12-10 09:32:24','2017-04-18 10:57:53',NULL),(16,'Blood Parasites Screen','BF','',1,'1 hr',1,'',NULL,NULL,'2015-12-10 09:33:58','2016-03-07 16:43:11',NULL),(17,'Semen Analysis','SA','',1,'30 min',1,'',NULL,NULL,'2015-12-10 09:41:45','2016-03-07 16:43:11',NULL),(18,'HVS analysis','HVS','',1,'30 min',1,'',NULL,NULL,'2015-12-10 09:48:54','2016-03-07 16:43:11',NULL),(19,'Syphilis Test','STS','',4,'30 min',1,'',NULL,NULL,'2015-12-22 07:32:17','2016-03-07 16:43:11',NULL),(20,'Hepatitis B Test','HBsAg','',4,'30 min',1,'',NULL,NULL,'2015-12-22 07:35:48','2016-03-07 16:43:11',NULL),(21,'Hepatitis C Test','HCVAB','',4,'30 min',1,'',NULL,NULL,'2015-12-22 07:37:11','2016-03-07 16:43:11',NULL),(22,'Rheumatoid Factor Test','RF','',4,'30 min',NULL,'',NULL,NULL,'2015-12-22 07:39:16','2016-03-07 16:43:11',NULL),(23,'Cryptococcus Antigen Test','CRAG','',4,'30 min',NULL,'',NULL,NULL,'2015-12-22 07:42:07','2016-03-07 16:43:11',NULL),(24,'Anti Streptolysis O','ASO','',4,'30 min',NULL,'',NULL,NULL,'2015-12-22 08:48:24','2016-03-07 16:43:11',NULL),(25,'C-reactive protein','CRP','',4,'30 min',1,'',NULL,NULL,'2015-12-22 08:56:26','2016-03-07 16:43:11',NULL),(26,'Measles','Meas','',4,'1 wk',1,'',NULL,NULL,'2015-12-22 09:00:58','2016-03-07 16:43:11',NULL),(27,'Rubella','Rub','',4,'1 wk',1,'',NULL,NULL,'2015-12-22 09:03:08','2016-03-07 16:43:11',NULL),(28,'CD4','CD4','',8,'30 min',1,'',NULL,NULL,'2015-12-22 09:14:27','2016-03-07 16:43:11',NULL),(29,'ABO Blood Grouping','ABO','',5,'30 min',1,'',NULL,NULL,'2015-12-22 10:20:21','2016-03-07 20:01:58',NULL),(30,'Cross-match','Xmatch','',5,'1 hr',1,'',NULL,NULL,'2015-12-22 10:40:01','2016-03-07 16:43:11',NULL),(31,'Transfusion Outcome',NULL,'',5,'30 min',NULL,'',NULL,'2016-03-01 14:52:32','2015-12-22 10:44:26','2016-03-07 16:43:11',NULL),(32,'Liver Function Tests','LFT','',7,'2 hrs',1,'',NULL,NULL,'2016-02-03 13:17:37','2016-03-07 16:43:11',NULL),(33,'Renal Function Test','RFT','',7,'24 hrs',1,'',NULL,NULL,'2016-02-03 13:45:15','2016-07-15 08:19:43',NULL),(34,'Lipogram','LIPO','',7,'24 hrs',1,'',NULL,NULL,'2016-02-03 13:56:21','2016-07-15 08:11:42',NULL),(35,'FBC','FBC','',3,'2 hrs',1,'',NULL,NULL,'2016-02-26 08:07:18','2016-03-07 16:43:11',NULL),(36,'Electrolytes','E','',7,'2 hrs',1,'',NULL,NULL,'2016-03-01 08:01:00','2016-03-07 16:43:11',NULL),(37,'Enzymes','','',7,'30 min',1,'',NULL,NULL,'2016-03-01 08:08:26','2016-07-15 08:46:17',NULL),(38,'Glucose','Glu','',7,'2 hrs',1,'',NULL,NULL,'2016-03-01 15:05:08','2016-03-07 16:43:11',NULL),(39,'Prothrombin Time','PT','',3,'2 hrs',1,'',NULL,NULL,'2016-03-04 14:35:22','2016-03-07 16:43:11',NULL),(40,'APTT','APTT','',3,'2 hrs',1,'',NULL,NULL,'2016-03-04 14:37:14','2016-03-07 16:43:11',NULL),(41,'INR','INR','',3,'2 hrs',1,'',NULL,NULL,'2016-03-04 14:38:39','2016-03-07 16:43:11',NULL),(42,'ESR','ESR','',3,'2 hrs',1,'',NULL,NULL,'2016-03-04 14:41:30','2016-03-07 16:43:11',NULL),(43,'Sickling Test',NULL,'',3,'24hrs',1,'',NULL,NULL,'2016-03-04 14:42:54','2016-03-07 19:47:38',NULL),(44,'Pregnancy Test','PT(ßHCG)','',2,'30 min',1,'',NULL,NULL,'2016-03-04 14:44:10','2017-04-11 12:24:03',NULL),(45,'Manual Differential & Cell Morphology','PRSM','',3,'48 hrs',1,'',NULL,NULL,'2016-03-04 15:08:01','2016-03-07 16:43:11',NULL),(46,'Pancreatic Function Test','PFT','',7,'',1,'',NULL,NULL,'2016-03-07 19:50:55','2016-03-07 19:51:25',NULL),(47,'Direct Coombs Test','','',5,'4  hours',1,'',NULL,NULL,'2016-04-07 13:52:12','2016-04-07 13:52:12',NULL),(48,'Calcium','Ca','',7,'2 hrs',1,'',NULL,NULL,'2016-07-15 08:26:00','2016-07-15 08:26:22',NULL),(49,'Phosphorus','P','',7,'2 hrs',1,'',NULL,NULL,'2016-07-15 08:32:31','2016-07-15 08:32:31',NULL),(50,'Magnesium','Mg','',7,'2 hrs',1,'',NULL,NULL,'2016-07-15 08:35:53','2016-07-15 08:36:16',NULL),(51,'Creatinine Kinase','CK','',7,'2 hrs',1,'',NULL,NULL,'2016-07-15 08:49:28','2016-07-15 08:49:28',NULL),(52,'Uric Acid','UA','',7,'2 hrs',1,'',NULL,NULL,'2016-07-15 08:53:04','2016-07-15 08:53:04',NULL),(53,'ESBL Test','ESBL','',2,'',1,'',NULL,NULL,'2016-09-15 14:44:02','2016-10-05 08:01:43',NULL),(54,'APTT Ratio','APTT Ratio','',3,'24hrs',1,'',NULL,NULL,'2016-11-10 14:48:54','2016-11-10 14:48:54',NULL),(55,'Fibronogen','PF','',3,'24hrs',1,'',NULL,NULL,'2016-11-10 14:51:34','2016-11-10 14:51:34',NULL),(56,'50:50 Normal Plasma','','',3,'24hrs',1,'',NULL,NULL,'2016-11-10 14:52:49','2016-11-10 14:52:49',NULL),(57,'50:50 Mix FVIII Deficient','','',3,'24hrs',1,'',NULL,NULL,'2016-11-10 14:53:47','2016-11-10 14:53:47',NULL),(58,'50:50 Mix F-IX Deficient','','',3,'24hrs',1,'',NULL,NULL,'2016-11-10 14:54:53','2016-11-10 14:54:53',NULL),(59,'Factor VIII Assay','','',3,'',1,'',NULL,NULL,'2016-11-10 15:01:52','2016-11-10 15:01:52',NULL),(60,'Factor IX Assay','','',3,'24hrs',1,'',NULL,NULL,'2016-11-10 15:02:53','2016-11-10 15:02:53',NULL),(61,'TT','TT','',3,'24hrs',1,'',NULL,NULL,'2016-11-10 15:05:55','2016-11-10 15:05:55',NULL),(62,'Coagulation Assay','','',3,'24hrs',1,'',NULL,NULL,'2016-11-11 09:42:46','2016-11-11 09:42:46',NULL),(63,'Lactate Dehydrogenase','LDH','',7,'8 hours',1,'',NULL,NULL,'2017-04-05 10:26:18','2017-04-05 10:33:36',NULL),(64,'Total Protein','TP','',7,'8 hours',1,'',NULL,NULL,'2017-04-05 10:31:01','2017-04-05 10:35:07',NULL),(65,'ZN','','',2,'2hrs',1,'',NULL,'2017-04-11 12:19:18','2017-04-11 12:11:16','2017-04-11 12:19:18',NULL),(66,'HIV','HIV','',4,'1hr',1,'',NULL,NULL,'2017-04-18 10:40:13','2017-04-18 10:48:55',NULL);

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

) ENGINE=InnoDB AUTO_INCREMENT=679 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_specimentypes`
--

LOCK TABLES `testtype_specimentypes` WRITE;
/*!40000 ALTER TABLE `testtype_specimentypes` DISABLE KEYS */;

INSERT INTO `testtype_specimentypes` VALUES (310,1,1),(441,2,1),(464,3,1),(457,3,2),(455,3,3),(462,3,4),(454,3,5),(460,3,6),(461,3,7),(458,3,8),(456,3,9),(463,3,10),(465,3,11),(466,3,12),(459,3,13),(496,4,1),(489,4,2),(487,4,3),(494,4,4),(486,4,5),(492,4,6),(493,4,7),(490,4,8),(488,4,9),(495,4,10),(497,4,11),(498,4,12),(491,4,13),(468,5,2),(472,5,4),(467,5,5),(470,5,6),(471,5,7),(469,5,13),(413,6,2),(394,7,1),(390,7,2),(393,7,4),(389,7,5),(391,7,6),(392,7,7),(665,8,2),(670,8,4),(664,8,5),(668,8,6),(669,8,7),(667,8,13),(666,8,17),(433,9,8),(432,9,9),(654,10,1),(649,10,2),(652,10,4),(648,10,5),(650,10,6),(651,10,7),(653,10,10),(264,11,12),(558,12,12),(577,13,12),(422,14,11),(675,15,3),(367,16,3),(560,17,15),(509,18,8),(423,19,3),(293,20,3),(295,21,3),(419,22,3),(375,23,3),(366,24,3),(368,25,3),(504,26,3),(420,27,3),(507,28,3),(485,29,3),(374,30,3),(288,31,3),(534,32,3),(538,33,3),(533,34,3),(678,35,3),(544,36,3),(527,37,3),(644,38,2),(643,38,3),(647,38,4),(642,38,5),(645,38,6),(646,38,7),(589,39,3),(475,40,3),(476,41,3),(477,42,3),(481,43,3),(671,44,12),(480,45,3),(542,46,3),(500,47,3),(543,48,3),(540,49,3),(536,50,3),(545,51,3),(537,52,3),(580,53,2),(579,53,3),(584,53,4),(578,53,5),(582,53,6),(583,53,7),(581,53,8),(586,53,9),(585,53,10),(587,53,12),(588,54,3),(590,55,3),(591,56,3),(592,57,3),(593,58,3),(594,59,3),(595,60,3),(596,61,3),(597,62,3),(632,63,2),(631,63,3),(635,63,4),(630,63,5),(633,63,6),(634,63,7),(638,64,2),(637,64,3),(641,64,4),(636,64,5),(639,64,6),(640,64,7),(656,65,17),(673,66,3);

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

) ENGINE=InnoDB AUTO_INCREMENT=1156 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testtype_measures`
--

LOCK TABLES `testtype_measures` WRITE;
/*!40000 ALTER TABLE `testtype_measures` DISABLE KEYS */;

INSERT INTO `testtype_measures` VALUES (233,11,74,NULL,NULL),(234,11,75,NULL,NULL),(299,31,132,NULL,NULL),(309,20,115,NULL,NULL),(311,21,116,NULL,NULL),(349,1,52,NULL,NULL),(522,24,119,NULL,NULL),(523,16,99,NULL,NULL),(524,25,120,NULL,NULL),(527,30,126,NULL,NULL),(528,30,127,NULL,NULL),(529,30,128,NULL,NULL),(530,30,129,NULL,NULL),(531,30,130,NULL,NULL),(532,30,131,NULL,NULL),(533,23,118,NULL,NULL),(535,7,65,NULL,NULL),(536,7,66,NULL,NULL),(537,7,73,NULL,NULL),(594,6,63,NULL,NULL),(611,22,117,NULL,NULL),(612,27,122,NULL,NULL),(620,14,93,NULL,NULL),(621,14,94,NULL,NULL),(622,14,95,NULL,NULL),(623,19,112,NULL,NULL),(624,19,113,NULL,NULL),(625,19,114,NULL,NULL),(655,9,70,NULL,NULL),(656,9,71,NULL,NULL),(663,2,58,NULL,NULL),(664,2,184,NULL,NULL),(668,3,59,NULL,NULL),(669,3,67,NULL,NULL),(670,3,68,NULL,NULL),(671,5,61,NULL,NULL),(672,5,62,NULL,NULL),(704,40,206,NULL,NULL),(705,41,207,NULL,NULL),(706,42,208,NULL,NULL),(709,45,211,NULL,NULL),(710,45,212,NULL,NULL),(711,45,213,NULL,NULL),(712,45,214,NULL,NULL),(713,45,215,NULL,NULL),(714,45,216,NULL,NULL),(715,45,217,NULL,NULL),(716,45,218,NULL,NULL),(717,45,219,NULL,NULL),(718,45,220,NULL,NULL),(719,45,221,NULL,NULL),(720,45,222,NULL,NULL),(721,45,223,NULL,NULL),(722,45,224,NULL,NULL),(723,45,225,NULL,NULL),(724,45,226,NULL,NULL),(725,45,227,NULL,NULL),(726,45,228,NULL,NULL),(727,43,209,NULL,NULL),(733,29,125,NULL,NULL),(734,4,60,NULL,NULL),(736,47,231,NULL,NULL),(752,26,121,NULL,NULL),(763,28,124,NULL,NULL),(764,28,177,NULL,NULL),(765,28,178,NULL,NULL),(766,28,179,NULL,NULL),(767,28,180,NULL,NULL),(775,18,107,NULL,NULL),(776,18,108,NULL,NULL),(777,18,109,NULL,NULL),(778,18,110,NULL,NULL),(779,18,111,NULL,NULL),(860,37,188,NULL,NULL),(861,37,189,NULL,NULL),(862,37,190,NULL,NULL),(863,37,191,NULL,NULL),(864,37,192,NULL,NULL),(865,37,193,NULL,NULL),(866,37,194,NULL,NULL),(867,37,195,NULL,NULL),(868,37,196,NULL,NULL),(869,37,197,NULL,NULL),(870,37,198,NULL,NULL),(871,37,199,NULL,NULL),(872,37,200,NULL,NULL),(894,34,145,NULL,NULL),(895,34,146,NULL,NULL),(896,34,237,NULL,NULL),(897,34,238,NULL,NULL),(898,32,133,NULL,NULL),(899,32,134,NULL,NULL),(900,32,135,NULL,NULL),(901,32,136,NULL,NULL),(902,32,137,NULL,NULL),(903,32,138,NULL,NULL),(904,32,140,NULL,NULL),(905,32,141,NULL,NULL),(906,32,236,NULL,NULL),(907,32,246,NULL,NULL),(908,32,247,NULL,NULL),(913,50,243,NULL,NULL),(914,52,245,NULL,NULL),(915,33,142,NULL,NULL),(916,33,143,NULL,NULL),(917,33,239,NULL,NULL),(918,33,240,NULL,NULL),(920,49,242,NULL,NULL),(922,46,229,NULL,NULL),(923,46,230,NULL,NULL),(924,48,241,NULL,NULL),(925,36,185,NULL,NULL),(926,36,186,NULL,NULL),(927,36,187,NULL,NULL),(928,51,244,NULL,NULL),(943,12,76,NULL,NULL),(944,12,77,NULL,NULL),(945,12,78,NULL,NULL),(946,12,79,NULL,NULL),(947,12,80,NULL,NULL),(948,12,81,NULL,NULL),(949,12,82,NULL,NULL),(959,17,248,NULL,NULL),(960,17,249,NULL,NULL),(961,17,250,NULL,NULL),(962,17,100,NULL,NULL),(963,17,101,NULL,NULL),(964,17,102,NULL,NULL),(965,17,104,NULL,NULL),(966,17,105,NULL,NULL),(967,17,106,NULL,NULL),(982,13,258,NULL,NULL),(983,13,83,NULL,NULL),(984,13,84,NULL,NULL),(985,13,85,NULL,NULL),(986,13,87,NULL,NULL),(987,13,88,NULL,NULL),(988,13,89,NULL,NULL),(989,13,90,NULL,NULL),(990,13,91,NULL,NULL),(991,13,92,NULL,NULL),(992,53,251,NULL,NULL),(993,53,252,NULL,NULL),(994,53,253,NULL,NULL),(995,53,254,NULL,NULL),(996,53,255,NULL,NULL),(997,53,256,NULL,NULL),(998,53,257,NULL,NULL),(999,54,259,NULL,NULL),(1000,39,205,NULL,NULL),(1001,55,260,NULL,NULL),(1002,56,261,NULL,NULL),(1003,57,262,NULL,NULL),(1004,58,263,NULL,NULL),(1005,59,264,NULL,NULL),(1006,60,265,NULL,NULL),(1007,61,266,NULL,NULL),(1008,62,267,NULL,NULL),(1009,62,268,NULL,NULL),(1010,62,269,NULL,NULL),(1011,62,270,NULL,NULL),(1012,62,271,NULL,NULL),(1013,62,272,NULL,NULL),(1014,62,273,NULL,NULL),(1015,62,274,NULL,NULL),(1016,62,275,NULL,NULL),(1017,62,276,NULL,NULL),(1018,62,277,NULL,NULL),(1036,63,278,NULL,NULL),(1037,64,279,NULL,NULL),(1038,38,204,NULL,NULL),(1039,10,280,NULL,NULL),(1040,10,72,NULL,NULL),(1041,10,201,NULL,NULL),(1042,10,202,NULL,NULL),(1043,10,203,NULL,NULL),(1044,10,232,NULL,NULL),(1045,10,233,NULL,NULL),(1046,10,234,NULL,NULL),(1048,65,281,NULL,NULL),(1050,8,69,NULL,NULL),(1051,44,210,NULL,NULL),(1053,66,283,NULL,NULL),(1058,15,96,NULL,NULL),(1059,15,97,NULL,NULL),(1060,15,98,NULL,NULL),(1061,15,284,NULL,NULL),(1124,35,169,NULL,NULL),(1125,35,147,NULL,NULL),(1126,35,148,NULL,NULL),(1127,35,149,NULL,NULL),(1128,35,150,NULL,NULL),(1129,35,151,NULL,NULL),(1130,35,152,NULL,NULL),(1131,35,153,NULL,NULL),(1132,35,154,NULL,NULL),(1133,35,155,NULL,NULL),(1134,35,156,NULL,NULL),(1135,35,157,NULL,NULL),(1136,35,158,NULL,NULL),(1137,35,159,NULL,NULL),(1138,35,160,NULL,NULL),(1139,35,161,NULL,NULL),(1140,35,162,NULL,NULL),(1141,35,163,NULL,NULL),(1142,35,164,NULL,NULL),(1143,35,165,NULL,NULL),(1144,35,166,NULL,NULL),(1145,35,167,NULL,NULL),(1146,35,168,NULL,NULL),(1147,35,170,NULL,NULL),(1148,35,171,NULL,NULL),(1149,35,172,NULL,NULL),(1150,35,173,NULL,NULL),(1151,35,174,NULL,NULL),(1152,35,175,NULL,NULL),(1153,35,176,NULL,NULL),(1154,35,285,NULL,NULL),(1155,35,286,NULL,NULL);

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

) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_categories`
--

LOCK TABLES `test_categories` WRITE;
/*!40000 ALTER TABLE `test_categories` DISABLE KEYS */;

INSERT INTO `test_categories` VALUES (1,'Parasitology','',NULL,'2015-11-03 11:05:20','2015-11-17 17:29:56'),(2,'Microbiology','',NULL,'2015-11-03 11:05:20','2015-11-17 17:29:41'),(3,'Haematology','',NULL,'2015-11-03 11:05:20','2015-11-17 17:30:35'),(4,'Serology','',NULL,'2015-11-03 11:05:20','2015-11-17 17:30:56'),(5,'Blood Bank','',NULL,'2015-11-03 11:05:20','2015-11-17 17:30:08'),(6,'Lab Reception','',NULL,'2015-11-04 09:34:28','2015-11-17 17:30:45'),(7,'Biochemistry','',NULL,'2015-11-04 09:37:13','2015-11-17 17:29:22'),(8,'Flow Cytometry','',NULL,'2015-11-04 09:37:25','2015-11-17 17:30:25'),(9,'Histopathology','',NULL,'2017-04-04 07:49:33','2017-04-04 07:49:33');

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

) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_types`
--

LOCK TABLES `specimen_types` WRITE;
/*!40000 ALTER TABLE `specimen_types` DISABLE KEYS */;

INSERT INTO `specimen_types` VALUES (1,'Sputum','',NULL,'2015-11-03 13:48:09','2015-11-03 13:48:09','','',''),(2,'CSF','',NULL,'2015-11-04 08:34:37','2015-11-04 08:34:37','','',''),(3,'Blood','',NULL,'2015-11-04 08:34:49','2015-11-04 08:34:49','','',''),(4,'Pleural Fluid','',NULL,'2015-11-04 09:42:58','2015-11-04 09:42:58','','',''),(5,'Ascitic Fluid','',NULL,'2015-11-04 09:43:07','2015-11-04 09:43:07','','',''),(6,'Pericardial Fluid','',NULL,'2015-11-04 09:43:16','2015-11-04 09:43:16','','',''),(7,'Peritoneal Fluid','',NULL,'2015-11-04 09:43:32','2015-11-04 09:43:32','','',''),(8,'HVS','',NULL,'2015-11-04 09:43:53','2015-11-04 09:43:53','','',''),(9,'Swabs','',NULL,'2015-11-04 09:44:01','2016-05-10 12:46:58','','',''),(10,'Pus','',NULL,'2015-11-04 09:44:08','2015-11-04 09:44:08','','',''),(11,'Stool','',NULL,'2015-11-04 09:44:21','2015-11-04 09:44:21','','',''),(12,'Urine','',NULL,'2015-11-04 09:44:32','2015-11-04 09:44:32','','',''),(13,'Other','',NULL,'2015-11-04 09:44:46','2015-11-04 09:44:46','','',''),(15,'Semen','',NULL,'2016-03-01 07:09:38','2016-03-01 15:20:12','','',''),(16,'Swab','','2016-05-06 15:35:41','2016-05-06 15:35:26','2016-05-06 15:35:41','','',''),(17,'FNA','',NULL,'2017-04-11 12:07:52','2017-04-11 12:07:52','','','');

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

) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` VALUES (1,'Superadmin',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21'),(2,'Technologist',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21'),(3,'Receptionist',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21'),(4,'Supervisor','','2016-05-23 06:37:37','2016-05-23 06:45:56'),(5,'Technician','','2016-05-23 06:45:45','2016-05-23 06:45:45'),(6,'Lab Assistant','','2016-05-23 06:47:59','2016-05-23 06:49:13'),(7,'Lab Manager ','','2016-05-23 07:18:40','2016-05-23 07:18:40'),(8,'Superuser','','2016-05-23 07:46:59','2016-05-23 07:46:59'),(9,'LIMS Secreteriat','','2016-05-23 08:16:36','2016-05-23 08:16:36'),(10,'Microscopist','','2017-04-04 07:57:22','2017-04-04 07:57:22');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisms`
--

LOCK TABLES `organisms` WRITE;
/*!40000 ALTER TABLE `organisms` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organism_drugs`
--

LOCK TABLES `organism_drugs` WRITE;
/*!40000 ALTER TABLE `organism_drugs` DISABLE KEYS */;
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

) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measures`
--

LOCK TABLES `measures` WRITE;
/*!40000 ALTER TABLE `measures` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `measures` VALUES (1,2,'BS for mps','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(2,2,'Grams stain','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(3,2,'SERUM AMYLASE','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(4,2,'calcium','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(5,2,'SGOT','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(6,2,'Indirect COOMBS test','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(7,2,'Direct COOMBS test','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(8,2,'Du test','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(9,1,'URIC ACID','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(10,4,'CSF for biochemistry','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(11,4,'PSA','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(12,1,'Total','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(13,1,'Alkaline Phosphate','u/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(14,1,'Direct','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(15,1,'Total Proteins','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(16,4,'LFTS','NULL',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(17,1,'Chloride','mmol/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(18,1,'Potassium','mmol/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(19,1,'Sodium','mmol/l',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(20,4,'Electrolytes','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(21,1,'Creatinine','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(22,1,'Urea','mg/dl',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(23,4,'RFTS','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(24,4,'TFT','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(25,4,'GXM','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(26,2,'Blood Grouping','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(27,1,'HB','g/dL',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(28,4,'Urine microscopy','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(29,4,'Pus cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(30,4,'S. haematobium','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(31,4,'T. vaginalis','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(32,4,'Yeast cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(33,4,'Red blood cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(34,4,'Bacteria','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(35,4,'Spermatozoa','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(36,4,'Epithelial cells','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(37,4,'ph','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(38,4,'Urine chemistry','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(39,4,'Glucose','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(40,4,'Ketones','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(41,4,'Proteins','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(42,4,'Blood','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(43,4,'Bilirubin','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(44,4,'Urobilinogen Phenlpyruvic acid','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(45,4,'pH','',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(46,1,'WBC','x10³/µL',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(47,1,'Lym','L',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(48,1,'Mon','*',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(49,1,'Neu','*',NULL,'2015-11-03 11:05:20','2015-11-03 11:05:20',NULL,'','',''),(50,1,'Eos','',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21',NULL,'','',''),(51,1,'Baso','',NULL,'2015-11-03 11:05:21','2015-11-03 11:05:21',NULL,'','',''),(52,4,'tb','','','2015-11-03 13:49:09','2015-11-03 13:49:09',NULL,'','',''),(53,4,'Sample Location (Swab)','','','2015-11-04 08:59:00','2015-11-04 08:59:00',NULL,'','',''),(54,4,'Sample Appearance (Fluids)','','','2015-11-04 08:59:00','2015-11-04 08:59:00',NULL,'','',''),(55,2,'Culture','','','2015-11-04 08:59:00','2015-11-04 08:59:00',NULL,'','',''),(56,2,'Gram Stain','','','2015-11-04 08:59:01','2015-11-04 08:59:01',NULL,'','',''),(57,2,'Gram Stain Morphology','','','2015-11-04 08:59:01','2015-11-04 08:59:01',NULL,'','',''),(58,4,'MTB','','','2015-11-04 08:59:01','2016-03-01 07:49:09',NULL,'','',''),(59,2,'Gram','','','2015-11-05 12:29:16','2015-12-10 10:50:43',NULL,'','',''),(60,2,'Culture','','','2015-11-06 05:24:20','2015-12-10 10:51:14',NULL,'','',''),(61,1,'WBC','cells/cu.mm','','2015-11-06 07:30:59','2015-12-10 10:51:02',NULL,'','',''),(62,1,'RBC','cells/cu.mm','','2015-11-06 07:30:59','2015-12-10 10:51:02',NULL,'','',''),(63,2,'India ink','','','2015-11-06 07:32:32','2015-12-10 10:52:32',NULL,'','',''),(64,2,'gram morphology','','','2015-11-06 07:37:36','2015-11-06 07:37:36',NULL,'','',''),(65,1,'Polymorphs','%','','2015-11-06 07:43:01','2015-12-10 10:51:57',NULL,'','',''),(66,1,'Lymphocytes','%','','2015-11-06 07:43:01','2015-12-10 10:51:57',NULL,'','',''),(67,2,'Clue cells','','','2015-11-12 17:50:25','2015-11-12 17:50:25',NULL,'','',''),(68,4,'Other organism seen','','','2015-11-12 17:50:25','2015-12-10 10:50:43',NULL,'','',''),(69,2,'ZN','','','2015-11-12 21:43:18','2015-12-10 10:56:59',NULL,'','',''),(70,2,'wet prep','','','2015-11-12 21:45:55','2015-11-12 21:45:55',NULL,'','',''),(71,4,'Other organism seen','','','2015-11-12 21:45:55','2015-12-10 10:56:29',NULL,'','',''),(72,2,'Macro exam','','','2015-11-12 21:54:38','2015-12-10 10:52:46',NULL,'','',''),(73,2,'Diff remarks','','','2015-11-12 22:01:00','2015-12-10 10:51:57',NULL,'','',''),(74,2,'Colour','','','2015-12-10 07:59:44','2015-12-10 07:59:44',NULL,'','',''),(75,2,'Appearance','','','2015-12-10 07:59:44','2015-12-10 07:59:44',NULL,'','',''),(76,1,'WBC','/hpf','','2015-12-10 08:06:20','2016-09-15 13:35:59',NULL,'','',''),(77,1,'RBC','/hpf','','2015-12-10 08:06:20','2016-09-15 13:35:59',NULL,'','',''),(78,2,'Epithelial cells','','','2015-12-10 08:06:20','2015-12-10 10:56:12',NULL,'','',''),(79,4,'Casts','','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL,'','',''),(80,4,'Crystals','','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL,'','',''),(81,4,'Parasites','','','2015-12-10 08:06:20','2015-12-10 08:06:20',NULL,'','',''),(82,2,'Yeast cells','','','2015-12-10 08:06:20','2015-12-10 10:56:12',NULL,'','',''),(83,2,'Blood','RBC/ul','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL,'','',''),(84,1,'Urobilinogen','mg/dl','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL,'','',''),(85,2,'Bilirubin','','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL,'','',''),(86,2,'Protein','','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL,'','',''),(87,2,'Protein','mg/dl','','2015-12-10 08:59:57','2016-09-15 14:12:23',NULL,'','',''),(88,2,'Nitrate','','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL,'','',''),(89,2,'Ketones','','','2015-12-10 08:59:57','2015-12-10 08:59:57',NULL,'','',''),(90,2,'Glucose','mg/dl','','2015-12-10 08:59:57','2016-09-15 14:12:23',NULL,'','',''),(91,2,'Specific gravity','','','2015-12-10 08:59:57','2016-09-15 14:12:23',NULL,'','',''),(92,2,'Leucocytes','WBC/ul','','2015-12-10 08:59:57','2016-09-15 14:12:23',NULL,'','',''),(93,4,'Macroscopy','','','2015-12-10 09:17:47','2015-12-10 09:17:47',NULL,'','',''),(94,2,'Consistency','','','2015-12-10 09:17:47','2015-12-10 09:17:47',NULL,'','',''),(95,4,'Microscopy','','','2015-12-10 09:17:47','2015-12-10 09:17:47',NULL,'','',''),(96,2,'Blood film','','','2015-12-10 09:32:24','2015-12-10 09:32:24',NULL,'','',''),(97,2,'Malaria Species','','','2015-12-10 09:32:24','2016-04-12 10:24:33',NULL,'','',''),(98,2,'MRDT','','','2015-12-10 09:32:24','2015-12-10 09:32:24',NULL,'','',''),(99,4,'Blood film','','','2015-12-10 09:33:58','2015-12-10 09:33:58',NULL,'','',''),(100,2,'Appearance','','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL,'','',''),(101,4,'Liquifaction time','','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL,'','',''),(102,1,'volume','ml','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL,'','',''),(103,1,'Motility','%','','2015-12-10 09:41:45','2015-12-10 09:41:45',NULL,'','',''),(104,2,'pH','','','2015-12-10 09:41:45','2016-09-15 14:34:38',NULL,'','',''),(105,1,'Sperm count','','','2015-12-10 09:41:45','2015-12-10 10:58:27',NULL,'','',''),(106,4,'Sperm morphology','','','2015-12-10 09:41:45','2015-12-10 10:55:04',NULL,'','',''),(107,2,'Macroscopy','','','2015-12-10 09:48:54','2015-12-10 09:48:54',NULL,'','',''),(108,1,'WBC','hpf','','2015-12-10 09:48:54','2016-06-02 09:11:58',NULL,'','',''),(109,2,'Epithelial cells','','','2015-12-10 09:48:54','2015-12-10 09:48:54',NULL,'','',''),(110,4,'Parasites/Bacteria','','','2015-12-10 09:48:54','2015-12-10 09:48:54',NULL,'','',''),(111,2,'Spermatozoa','','','2015-12-10 09:48:54','2015-12-10 09:48:54',NULL,'','',''),(112,2,'RPR','','','2015-12-22 07:32:17','2015-12-22 07:32:17',NULL,'','',''),(113,2,'VDRL','','','2015-12-22 07:32:17','2015-12-22 07:32:17',NULL,'','',''),(114,2,'TPHA','','','2015-12-22 07:32:17','2015-12-22 07:32:17',NULL,'','',''),(115,2,'Hepatitis B','','','2015-12-22 07:35:48','2015-12-22 07:35:48',NULL,'','',''),(116,2,'Hepatitis C','','','2015-12-22 07:37:11','2015-12-22 07:37:11',NULL,'','',''),(117,2,'Rheumatoid Factor','','','2015-12-22 07:39:16','2015-12-22 07:39:16',NULL,'','',''),(118,2,'CrAg','','','2015-12-22 07:42:07','2015-12-22 07:42:07',NULL,'','',''),(119,2,'ASO','','','2015-12-22 08:48:24','2015-12-22 08:48:24',NULL,'','',''),(120,2,'CRP','','','2015-12-22 08:56:26','2015-12-22 08:56:26',NULL,'','',''),(121,2,'Measles IgM ELISA-Behring enzygnost','','','2015-12-22 09:00:58','2016-04-21 13:08:51',NULL,'','',''),(122,2,'Rubella IgM ELISA-Behring enzynost','','','2015-12-22 09:03:08','2016-01-21 12:58:35',NULL,'','',''),(123,1,'Serum','','','2015-12-22 09:14:27','2016-03-01 07:01:24',NULL,'','',''),(124,1,'CD4 Count','cell/μl','','2015-12-22 09:14:27','2016-04-21 13:47:16',NULL,'','',''),(125,2,'Grouping','','','2015-12-22 10:20:21','2015-12-22 10:20:46',NULL,'','',''),(126,4,'Pack No.','','','2015-12-22 10:40:01','2015-12-22 10:40:01',NULL,'','',''),(127,2,'Pack ABO Group','','','2015-12-22 10:40:01','2015-12-22 10:49:26',NULL,'','',''),(128,2,'Product Type','','','2015-12-22 10:40:01','2016-03-01 14:06:27',NULL,'','',''),(129,4,'Expiry Date','','','2015-12-22 10:40:01','2015-12-22 10:40:01',NULL,'','',''),(130,4,'Volume','mL','','2015-12-22 10:40:01','2016-01-29 08:50:44',NULL,'','',''),(131,2,'Cross-match Method','','','2015-12-22 10:40:01','2015-12-22 10:40:01',NULL,'','',''),(132,2,'Outcome','','','2015-12-22 10:44:26','2015-12-22 10:44:26',NULL,'','',''),(133,1,'GPT/ALT','U/L','','2016-02-03 13:17:37','2016-07-15 07:47:42',NULL,'','',''),(134,1,'GOT/AST','U/L','','2016-02-03 13:17:37','2016-07-15 07:47:42',NULL,'','',''),(135,1,'Alkaline Phosphate(ALP)','U/L','','2016-02-03 13:17:37','2016-07-15 07:47:42',NULL,'','',''),(136,1,'GGT/r-GT','U/L','','2016-02-03 13:17:37','2016-07-15 07:49:31',NULL,'','',''),(137,1,'Bilirubin Direct(DBIL-DSA)','mg/dl','','2016-02-03 13:17:37','2016-07-15 07:51:39',NULL,'','',''),(138,1,'Bilirubin Total(TBIL-DSA))','mg/dl','','2016-02-03 13:17:37','2016-07-15 07:51:39',NULL,'','',''),(139,1,'Calcium','mg/dl','','2016-02-03 13:24:55','2016-02-03 13:24:55',NULL,'','',''),(140,1,'Albumin(ALB)','mg/dl','','2016-02-03 13:24:55','2016-07-15 07:48:30',NULL,'','',''),(141,1,'Protein(TP)','mg/dl','','2016-02-03 13:24:55','2016-07-15 07:53:18',NULL,'','',''),(142,1,'Urea','mg/dl','','2016-02-03 13:45:15','2016-02-03 13:45:15',NULL,'','',''),(143,1,'Creatinine','mg/dl','','2016-02-03 13:45:15','2016-02-03 13:45:15',NULL,'','',''),(144,1,'Glucose','mg/dl','','2016-02-03 13:45:15','2016-02-03 13:45:15',NULL,'','',''),(145,1,'Triglycerides(TG)','mg/dl','','2016-02-03 13:56:21','2016-07-15 08:11:42',NULL,'','',''),(146,1,'Cholesterol(CHOL)','mg/dl','','2016-02-03 13:56:21','2016-07-15 08:11:42',NULL,'','',''),(147,1,'RBC','10^6/uL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(148,1,'HGB','g/dL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(149,1,'HCT','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(150,1,'MCV','fL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(151,1,'MCH','pg','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(152,1,'MCHC','g/dL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(153,1,'PLT','10^3/uL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(154,1,'RDW-SD','fL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(155,1,'RDW-CV','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(156,1,'PDW','fL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(157,1,'MPV','fL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(158,1,'PCT','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(159,1,'NEUT%','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(160,1,'LYMPH%','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(161,1,'MONO%','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(162,1,'EO%','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(163,1,'BASO%','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(164,1,'NEUT#','10^3/uL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(165,1,'LYMPH#','10^3/uL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(166,1,'MONO#','10^3/uL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(167,1,'EO#','10^3/uL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(168,1,'BASO#','10^3/uL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(169,1,'WBC','10^3/uL','','2016-02-26 08:07:17','2016-02-26 08:07:18',NULL,'','',''),(170,1,'Mid#','10^3/uL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(171,1,'Gran#','10^3/uL','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(172,1,'Mid%','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(173,1,'Gran%','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(174,1,'EOS%','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(175,1,'P-LCC','10^9/L','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(176,1,'P-LCR','%','','2016-02-26 08:07:18','2016-02-26 08:07:18',NULL,'','',''),(177,1,'CD4 %','%','','2016-03-01 07:01:24','2016-04-12 10:28:16',NULL,'','',''),(178,1,'Lymphocyte Count','cell/μl','','2016-03-01 07:01:24','2016-04-21 13:47:16',NULL,'','',''),(179,1,'CD8 Count','cell/μl','','2016-03-01 07:01:24','2016-04-21 13:47:16',NULL,'','',''),(180,1,'CD3 Count','cell/μl','','2016-03-01 07:01:24','2016-04-21 13:47:16',NULL,'','',''),(181,1,'K','','','2016-03-01 07:41:30','2016-03-01 07:41:30',NULL,'','',''),(182,1,'Na','','','2016-03-01 07:41:30','2016-03-01 07:41:30',NULL,'','',''),(183,1,'Cl','','','2016-03-01 07:41:30','2016-03-01 07:41:30',NULL,'','',''),(184,4,'RIF Resistance','','','2016-03-01 07:49:09','2016-03-01 07:49:09',NULL,'','',''),(185,1,'K','mmol/L','','2016-03-01 08:01:00','2016-03-01 14:18:26',NULL,'','',''),(186,1,'Na','mmol/L','','2016-03-01 08:01:00','2016-03-01 14:18:26',NULL,'','',''),(187,1,'Cl','mmol/L','','2016-03-01 08:01:00','2016-03-01 14:18:26',NULL,'','',''),(188,1,'a-AMYLASE-H','U/L','','2016-03-01 08:08:26','2016-07-15 08:46:17',NULL,'','',''),(189,1,'ALT-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(190,1,'AST-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(191,1,'ALP-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(192,1,'TP-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(193,1,'TC-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(194,1,'UREA-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(195,1,'GLU-O-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(196,1,'TBIL-DSA-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(197,1,'DBIL-DSA-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(198,1,'UA-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(199,1,'TG-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(200,1,'ALB-H','','','2016-03-01 08:08:26','2016-03-01 08:08:26',NULL,'','',''),(201,2,'Smear microscopy result','','','2016-03-01 14:48:32','2016-04-21 13:28:31',NULL,'','',''),(202,4,'Gene Xpert MTB','','','2016-03-01 14:48:32','2016-09-15 09:47:45',NULL,'','',''),(203,4,'Gene Xpert RIF Resistance','','','2016-03-01 14:48:32','2016-09-15 09:47:45',NULL,'','',''),(204,1,'Glucose','mg/dl','','2016-03-01 15:05:08','2016-03-01 15:05:08',NULL,'','',''),(205,1,'PT','sec','','2016-03-04 14:35:22','2016-03-04 14:35:22',NULL,'','',''),(206,1,'APTT','sec','','2016-03-04 14:37:14','2016-03-04 14:37:14',NULL,'','',''),(207,1,'INR','','','2016-03-04 14:38:39','2016-03-04 14:38:39',NULL,'','',''),(208,1,'ESR','mm/hr','','2016-03-04 14:41:30','2016-03-04 14:41:30',NULL,'','',''),(209,2,'Sickling Screen','','','2016-03-04 14:42:54','2016-03-04 14:42:54',NULL,'','',''),(210,2,'Pregnancy Test','','','2016-03-04 14:44:10','2016-03-04 14:44:10',NULL,'','',''),(211,4,'Nucleated Red Cells','/100 WBC','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(212,4,'Neutrophils','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(213,4,'Lymphocytes','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(214,4,'Monocytes','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(215,4,'Eosinophils','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(216,4,'Basophils','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(217,4,'Promyelocytes','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(218,4,'Myelocytes','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(219,4,'Metamyelocytes','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(220,4,'Band/Staff Forms','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(221,4,'Blasts','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(222,4,'Other','%','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(223,4,'RBC Comments','','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(224,4,'WBC Comments','','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(225,4,'Platelet Comments','','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(226,4,'Interpretative Comments','','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(227,4,'Attempted/ Differential Diagnosis','','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(228,4,'Further Tests','','','2016-03-04 15:08:01','2016-03-04 15:08:01',NULL,'','',''),(229,1,'Amylase','IU/L','','2016-03-07 19:50:55','2016-07-26 14:26:17',NULL,'','',''),(230,1,'Lipase','IU/L','','2016-03-07 19:50:55','2016-07-26 14:26:17',NULL,'','',''),(231,2,'Direct Coombs Test','','','2016-04-07 13:52:12','2016-04-07 13:52:12',NULL,'','',''),(232,2,'HIV Status','','','2016-04-12 14:07:24','2016-04-12 14:07:24',NULL,'','',''),(233,2,'Reason For Testing','','','2016-04-12 14:07:24','2016-05-10 12:49:43',NULL,'','',''),(234,2,'Indication for GeneXpert Test','','','2016-04-12 14:07:24','2016-04-12 14:07:24',NULL,'','',''),(235,1,'Calcium','mg/dl','','2016-06-21 14:13:32','2016-06-21 14:13:32',NULL,'','',''),(236,1,'LDH','U/L','','2016-07-15 07:47:42','2016-07-15 07:55:39',NULL,'','',''),(237,1,'HDL-C','mg/dl','','2016-07-15 08:11:42','2016-07-15 08:11:42',NULL,'','',''),(238,1,'LDL-C','mg/dl','','2016-07-15 08:11:42','2016-07-15 08:11:42',NULL,'','',''),(239,1,'CREA-J','mg/dl','','2016-07-15 08:19:43','2016-07-15 08:19:43',NULL,'','',''),(240,1,'CREA-S','mg/dl','','2016-07-15 08:19:43','2016-07-15 08:19:43',NULL,'','',''),(241,1,'Ca','mg/dl','','2016-07-15 08:26:00','2016-07-15 08:26:00',NULL,'','',''),(242,1,'P','mg/dl','','2016-07-15 08:32:31','2016-07-15 08:32:31',NULL,'','',''),(243,1,'Mg','mg/dl','','2016-07-15 08:35:53','2016-07-15 08:35:53',NULL,'','',''),(244,1,'CK','IU/L','','2016-07-15 08:49:28','2016-07-15 08:49:28',NULL,'','',''),(245,1,'UA','mg/dl','','2016-07-15 08:53:04','2016-07-15 08:53:04',NULL,'','',''),(246,1,'Bilirubin Direct(DBIL-VOX)','mg/dl','','2016-07-15 08:56:45','2016-07-15 08:56:45',NULL,'','',''),(247,1,'Bilirubin Total(TBIL-VOX)','mg/dl','','2016-07-15 08:56:45','2016-07-15 08:56:45',NULL,'','',''),(248,1,'Progressive motility','%','','2016-09-15 14:34:38','2016-09-15 14:34:38',NULL,'','',''),(249,1,'Non-progressive motility','%','','2016-09-15 14:34:38','2016-09-15 14:34:38',NULL,'','',''),(250,1,'Immotility','%','','2016-09-15 14:34:38','2016-09-15 14:34:38',NULL,'','',''),(251,2,'ESBL','','','2016-09-15 14:44:02','2016-09-15 14:44:02',NULL,'','',''),(252,1,'Cefotaxime','mm','','2016-09-15 14:44:02','2016-09-15 14:44:02',NULL,'','',''),(253,1,'Cefotaxime + Clavulanate','mm','','2016-09-15 14:44:02','2016-09-15 14:44:02',NULL,'','',''),(254,1,'Ceftazidime','mm','','2016-09-15 14:44:02','2016-09-15 14:44:02',NULL,'','',''),(255,1,'Ceftazidime + Clavulanate','mm','','2016-09-15 14:44:02','2016-09-15 14:44:02',NULL,'','',''),(256,1,'Cefepime','mm','','2016-09-15 14:44:02','2016-09-15 14:44:02',NULL,'','',''),(257,1,'Cefepime + clavulanate','mm','','2016-09-15 14:44:02','2016-09-15 14:44:02',NULL,'','',''),(258,2,'pH','','','2016-09-16 09:02:49','2016-09-16 09:02:49',NULL,'','',''),(259,1,'APTT Ratio','','','2016-11-10 14:48:54','2016-11-10 14:48:54',NULL,'','',''),(260,1,'Fibronogen','g/L','','2016-11-10 14:51:34','2016-11-10 14:51:34',NULL,'','',''),(261,1,'50:50 Normal Plasma','sec','','2016-11-10 14:52:49','2016-11-10 14:52:49',NULL,'','',''),(262,1,'50:50 Mix FVIII Deficient','sec','','2016-11-10 14:53:47','2016-11-10 14:53:47',NULL,'','',''),(263,1,'50:50 Mix F-IX Deficient','sec','','2016-11-10 14:54:53','2016-11-10 14:54:53',NULL,'','',''),(264,1,'Factor VIII Assay','IU/dL','','2016-11-10 15:01:52','2016-11-10 15:01:52',NULL,'','',''),(265,1,'Factor IX Assay','IU/dL','','2016-11-10 15:02:53','2016-11-10 15:02:53',NULL,'','',''),(266,1,'TT','sec','','2016-11-10 15:05:55','2016-11-10 15:05:55',NULL,'','',''),(267,1,'PT','secs','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(268,1,'INR','','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(269,1,'APTT','sec','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(270,1,'APTT Ratio','','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(271,1,'TT','sec','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(272,1,'Fibronogen','g/L','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(273,1,'50:50 Mix Normal Plasma','sec','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(274,1,'50:50 Mix FVIII Deficient','sec','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(275,1,'50:50 Mix F-IX Deficient','sec','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(276,1,'Factor IX Assay','IU/dL','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(277,1,'Factor VIII Assay','IU/dL','','2016-11-11 09:42:46','2016-11-11 09:42:46',NULL,'','',''),(278,1,'LDH','U/L','','2017-04-05 10:26:18','2017-04-05 10:26:18',NULL,'','',''),(279,1,'TP','g/dL','','2017-04-05 10:31:01','2017-04-05 10:31:01',NULL,'','',''),(280,1,'Sample results 2','','','2017-04-11 09:14:28','2017-04-11 09:14:28',NULL,'','',''),(281,2,'Results','','','2017-04-11 12:11:16','2017-04-11 12:18:22',NULL,'','',''),(282,2,'HIV','','','2017-04-18 10:40:13','2017-04-18 10:40:13',NULL,'','',''),(283,2,'HIV','','','2017-04-18 10:47:13','2017-04-18 10:48:55',NULL,'','',''),(284,4,'Malaria density','','','2017-04-18 10:57:53','2017-04-18 10:58:49',NULL,'','',''),(285,1,'MXD%','10^6/uL','','2017-04-25 10:26:20','2017-04-25 10:28:11',NULL,'','',''),(286,1,'MXD#','10^6/uL','','2017-04-25 10:26:20','2017-04-25 10:28:11',NULL,'','','');

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

) ENGINE=InnoDB AUTO_INCREMENT=508 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure_ranges`
--

LOCK TABLES `measure_ranges` WRITE;
/*!40000 ALTER TABLE `measure_ranges` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `measure_ranges` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,'No mps seen','Negative',NULL,'','','',''),(2,1,NULL,NULL,NULL,NULL,NULL,'+','Positive',NULL,'','','',''),(3,1,NULL,NULL,NULL,NULL,NULL,'++','Positive',NULL,'','','',''),(4,1,NULL,NULL,NULL,NULL,NULL,'+++','Positive',NULL,'','','',''),(5,2,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL,'','','',''),(6,2,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL,'','','',''),(7,3,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL,'','','',''),(8,3,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL,'','','',''),(9,3,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL,'','','',''),(10,4,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL,'','','',''),(11,4,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL,'','','',''),(12,4,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL,'','','',''),(13,5,NULL,NULL,NULL,NULL,NULL,'High',NULL,NULL,'','','',''),(14,5,NULL,NULL,NULL,NULL,NULL,'Low',NULL,NULL,'','','',''),(15,5,NULL,NULL,NULL,NULL,NULL,'Normal',NULL,NULL,'','','',''),(16,6,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL,'','','',''),(17,6,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL,'','','',''),(18,7,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL,'','','',''),(19,7,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL,'','','',''),(20,8,NULL,NULL,NULL,NULL,NULL,'Positive',NULL,NULL,'','','',''),(21,8,NULL,NULL,NULL,NULL,NULL,'Negative',NULL,NULL,'','','',''),(22,26,NULL,NULL,NULL,NULL,NULL,'O-',NULL,NULL,'','','',''),(23,26,NULL,NULL,NULL,NULL,NULL,'O+',NULL,NULL,'','','',''),(24,26,NULL,NULL,NULL,NULL,NULL,'A-',NULL,NULL,'','','',''),(25,26,NULL,NULL,NULL,NULL,NULL,'A+',NULL,NULL,'','','',''),(26,26,NULL,NULL,NULL,NULL,NULL,'B-',NULL,NULL,'','','',''),(27,26,NULL,NULL,NULL,NULL,NULL,'B+',NULL,NULL,'','','',''),(28,26,NULL,NULL,NULL,NULL,NULL,'AB-',NULL,NULL,'','','',''),(29,26,NULL,NULL,NULL,NULL,NULL,'AB+',NULL,NULL,'','','',''),(30,46,0,100,2,4.000,11.000,NULL,NULL,NULL,'','','',''),(31,47,0,100,2,1.500,4.000,NULL,NULL,NULL,'','','',''),(32,48,0,100,2,0.100,9.000,NULL,NULL,NULL,'','','',''),(33,49,0,100,2,2.500,7.000,NULL,NULL,NULL,'','','',''),(34,50,0,100,2,0.000,6.000,NULL,NULL,NULL,'','','',''),(35,51,0,100,2,0.000,2.000,NULL,NULL,NULL,'','','',''),(36,55,NULL,NULL,NULL,NULL,NULL,'Not performed','',NULL,'','','',''),(37,55,NULL,NULL,NULL,NULL,NULL,'No growth 24 hrs','',NULL,'','','',''),(38,55,NULL,NULL,NULL,NULL,NULL,'No growth 48 hrs','',NULL,'','','',''),(39,55,NULL,NULL,NULL,NULL,NULL,'No growth 72 hrs','NEGATIVE',NULL,'','','',''),(40,55,NULL,NULL,NULL,NULL,NULL,'Growth','POSITIVE',NULL,'','','',''),(41,56,NULL,NULL,NULL,NULL,NULL,'Gram Positve','',NULL,'','','',''),(42,56,NULL,NULL,NULL,NULL,NULL,'Gram Negative','',NULL,'','','',''),(43,56,NULL,NULL,NULL,NULL,NULL,'Gram Variable','',NULL,'','','',''),(44,57,NULL,NULL,NULL,NULL,NULL,'Cocci','',NULL,'','','',''),(45,57,NULL,NULL,NULL,NULL,NULL,'Bacilli','',NULL,'','','',''),(46,57,NULL,NULL,NULL,NULL,NULL,'Cocci-Bacilli','',NULL,'','','',''),(47,57,NULL,NULL,NULL,NULL,NULL,'Diplococci','',NULL,'','','',''),(48,57,NULL,NULL,NULL,NULL,NULL,'Yeast','',NULL,'','','',''),(49,57,NULL,NULL,NULL,NULL,NULL,'Other','',NULL,'','','',''),(50,60,NULL,NULL,NULL,NULL,NULL,'Growth','POSITIVE',NULL,'','','',''),(51,60,NULL,NULL,NULL,NULL,NULL,'No growth','',NULL,'','','',''),(52,60,NULL,NULL,NULL,NULL,NULL,'Mixed growth; no predominant organism','',NULL,'','','',''),(53,60,NULL,NULL,NULL,NULL,NULL,'Growth of normal flora; no pathogens isolated','',NULL,'','','',''),(54,61,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(55,62,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(56,63,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL,'','','',''),(57,63,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL,'','','',''),(58,64,NULL,NULL,NULL,NULL,NULL,'Cocci','',NULL,'','','',''),(59,64,NULL,NULL,NULL,NULL,NULL,'Bacilli','',NULL,'','','',''),(60,64,NULL,NULL,NULL,NULL,NULL,'Cocco-bacilli','',NULL,'','','',''),(61,59,NULL,NULL,NULL,NULL,NULL,'No organism seen','',NULL,'','','',''),(62,59,NULL,NULL,NULL,NULL,NULL,'Gram positive cocci (clusters)','',NULL,'','','',''),(63,59,NULL,NULL,NULL,NULL,NULL,'Gram positive cocci (chains)','',NULL,'','','',''),(64,65,0,120,2,0.000,100.000,NULL,'',NULL,'','','',''),(65,66,0,120,2,0.000,100.000,NULL,'',NULL,'','','',''),(66,67,NULL,NULL,NULL,NULL,NULL,'Yes','',NULL,'','','',''),(67,67,NULL,NULL,NULL,NULL,NULL,'No','',NULL,'','','',''),(68,59,NULL,NULL,NULL,NULL,NULL,'Gram positive diplococci','',NULL,'','','',''),(69,59,NULL,NULL,NULL,NULL,NULL,'Gram positive bacilli','',NULL,'','','',''),(70,59,NULL,NULL,NULL,NULL,NULL,'Gram positive cocco-bacilli','',NULL,'','','',''),(71,59,NULL,NULL,NULL,NULL,NULL,'Gram negative cocci','',NULL,'','','',''),(72,59,NULL,NULL,NULL,NULL,NULL,'Gram negative bacilli','',NULL,'','','',''),(73,59,NULL,NULL,NULL,NULL,NULL,'Gram negative cocco-bacilli','',NULL,'','','',''),(74,59,NULL,NULL,NULL,NULL,NULL,'Gram negative diplococci','',NULL,'','','',''),(75,59,NULL,NULL,NULL,NULL,NULL,'Gram variable cocci','',NULL,'','','',''),(76,59,NULL,NULL,NULL,NULL,NULL,'Gram variable  bacilli','',NULL,'','','',''),(77,59,NULL,NULL,NULL,NULL,NULL,'Gram variable cocco-bacilli','',NULL,'','','',''),(78,59,NULL,NULL,NULL,NULL,NULL,'Yeast cells seen','',NULL,'','','',''),(79,60,NULL,NULL,NULL,NULL,NULL,'Growth of contaminants','',NULL,'','','',''),(80,69,NULL,NULL,NULL,NULL,NULL,'Scanty AAFB seen','',NULL,'','','',''),(81,69,NULL,NULL,NULL,NULL,NULL,'1+ AAFB seen','',NULL,'','','',''),(82,69,NULL,NULL,NULL,NULL,NULL,'2+ AAFB seen','',NULL,'','','',''),(83,69,NULL,NULL,NULL,NULL,NULL,'3+ AAFB seen','',NULL,'','','',''),(84,69,NULL,NULL,NULL,NULL,NULL,'No AAFB seen','',NULL,'','','',''),(85,70,NULL,NULL,NULL,NULL,NULL,'Trichomonas vaginalis seen','',NULL,'','','',''),(86,70,NULL,NULL,NULL,NULL,NULL,'Yeast cells seen','',NULL,'','','',''),(87,70,NULL,NULL,NULL,NULL,NULL,'Spermatozoa seen','',NULL,'','','',''),(88,72,NULL,NULL,NULL,NULL,NULL,'Clear/colourless','',NULL,'','','',''),(89,72,NULL,NULL,NULL,NULL,NULL,'Slightly Cloudy','',NULL,'','','',''),(90,72,NULL,NULL,NULL,NULL,NULL,'Purulent','',NULL,'','','',''),(91,72,NULL,NULL,NULL,NULL,NULL,'Clotted','',NULL,'','','',''),(92,72,NULL,NULL,NULL,NULL,NULL,'Turbid','',NULL,'','','',''),(93,72,NULL,NULL,NULL,NULL,NULL,'Blood stained','',NULL,'','','',''),(94,73,NULL,NULL,NULL,NULL,NULL,'Mainly lymphocytes','',NULL,'','','',''),(95,73,NULL,NULL,NULL,NULL,NULL,'Mainly polymorphs','',NULL,'','','',''),(96,73,NULL,NULL,NULL,NULL,NULL,'Not enough cells for differential count','',NULL,'','','',''),(97,73,NULL,NULL,NULL,NULL,NULL,'No cells seen','',NULL,'','','',''),(98,58,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE','2016-03-01 07:49:09','','','',''),(99,58,NULL,NULL,NULL,NULL,NULL,'Negative','Negative','2016-03-01 07:49:09','','','',''),(100,74,NULL,NULL,NULL,NULL,NULL,'Brown','',NULL,'','','',''),(101,74,NULL,NULL,NULL,NULL,NULL,'Red','',NULL,'','','',''),(102,74,NULL,NULL,NULL,NULL,NULL,'Pale','',NULL,'','','',''),(103,74,NULL,NULL,NULL,NULL,NULL,'Yellow','',NULL,'','','',''),(104,74,NULL,NULL,NULL,NULL,NULL,'Light yellow','',NULL,'','','',''),(105,74,NULL,NULL,NULL,NULL,NULL,'Amber','',NULL,'','','',''),(106,75,NULL,NULL,NULL,NULL,NULL,'Cloudy','',NULL,'','','',''),(107,75,NULL,NULL,NULL,NULL,NULL,'Blood Stained','',NULL,'','','',''),(108,75,NULL,NULL,NULL,NULL,NULL,'Clear','',NULL,'','','',''),(109,76,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(110,77,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(111,78,NULL,NULL,NULL,NULL,NULL,'+','',NULL,'','','',''),(112,78,NULL,NULL,NULL,NULL,NULL,'++','',NULL,'','','',''),(113,78,NULL,NULL,NULL,NULL,NULL,'+++','',NULL,'','','',''),(114,82,NULL,NULL,NULL,NULL,NULL,'Yeast cells +','',NULL,'','','',''),(115,82,NULL,NULL,NULL,NULL,NULL,'Not seen','','2016-09-15 13:35:59','','','',''),(116,83,NULL,NULL,NULL,NULL,NULL,'Negative','','2016-09-15 14:12:23','','','',''),(117,83,NULL,NULL,NULL,NULL,NULL,'Heamolysis + (10) RBC/ul','',NULL,'','','',''),(118,83,NULL,NULL,NULL,NULL,NULL,'Heamolysis ++ (50) RBC/ul','',NULL,'','','',''),(119,83,NULL,NULL,NULL,NULL,NULL,'Heamolysis+++ (250) RBC/ul','',NULL,'','','',''),(120,83,NULL,NULL,NULL,NULL,NULL,'Non- Heamolysis +10 RBC/ul','','2016-09-15 14:12:23','','','',''),(121,83,NULL,NULL,NULL,NULL,NULL,'Non- Heamolysis ++50 RBC/ul','','2016-09-15 14:12:23','','','',''),(122,83,NULL,NULL,NULL,NULL,NULL,'','','2016-03-01 15:18:53','','','',''),(123,84,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(124,85,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(125,85,NULL,NULL,NULL,NULL,NULL,'+','',NULL,'','','',''),(126,85,NULL,NULL,NULL,NULL,NULL,'++','',NULL,'','','',''),(127,85,NULL,NULL,NULL,NULL,NULL,'+++','',NULL,'','','',''),(128,86,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(129,86,NULL,NULL,NULL,NULL,NULL,'Trace','',NULL,'','','',''),(130,87,0,120,2,1.000,1000000.000,NULL,'','2015-12-14 08:11:59','','','',''),(131,88,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL,'','','',''),(132,88,NULL,NULL,NULL,NULL,NULL,'Trace','',NULL,'','','',''),(133,88,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL,'','','',''),(134,89,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL,'','','',''),(135,89,NULL,NULL,NULL,NULL,NULL,'+/-','',NULL,'','','',''),(136,89,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE','2016-09-15 14:12:23','','','',''),(137,90,0,120,2,0.000,0.000,NULL,'NEGATIVE','2016-09-15 14:12:23','','','',''),(138,90,0,120,2,1.000,1000000.000,NULL,'POSITIVE','2016-09-15 14:12:23','','','',''),(139,91,0,120,2,1.000,100000.000,NULL,'','2016-09-15 14:12:23','','','',''),(140,92,0,120,2,0.000,0.000,NULL,'NEGATIVE','2016-09-15 14:12:23','','','',''),(141,92,0,120,2,1.000,1000000.000,NULL,'POSITIVE','2016-09-15 14:12:23','','','',''),(142,94,NULL,NULL,NULL,NULL,NULL,'Formed','',NULL,'','','',''),(143,94,NULL,NULL,NULL,NULL,NULL,'Semi-formed','',NULL,'','','',''),(144,94,NULL,NULL,NULL,NULL,NULL,'Unformed','',NULL,'','','',''),(145,94,NULL,NULL,NULL,NULL,NULL,'Watery','',NULL,'','','',''),(146,94,NULL,NULL,NULL,NULL,NULL,'Rice appearance','',NULL,'','','',''),(147,96,NULL,NULL,NULL,NULL,NULL,'No parasite seen','',NULL,'','','',''),(148,96,NULL,NULL,NULL,NULL,NULL,'+ (1-10 parasites/100 fields)','',NULL,'','','',''),(149,96,NULL,NULL,NULL,NULL,NULL,'++ (11-99 parasites/100 field) ','',NULL,'','','',''),(150,96,NULL,NULL,NULL,NULL,NULL,'+++ (1-10 parasites /field)','',NULL,'','','',''),(151,96,NULL,NULL,NULL,NULL,NULL,'++++ (>10 parasites/field)','',NULL,'','','',''),(152,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium falciparum','',NULL,'','','',''),(153,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium ovale','',NULL,'','','',''),(154,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium vivax','',NULL,'','','',''),(155,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium malariae','',NULL,'','','',''),(156,97,NULL,NULL,NULL,NULL,NULL,'Plasmodium knowlesi','',NULL,'','','',''),(157,98,NULL,NULL,NULL,NULL,NULL,'Positive','',NULL,'','','',''),(158,98,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(159,100,NULL,NULL,NULL,NULL,NULL,'Grey','',NULL,'','','',''),(160,100,NULL,NULL,NULL,NULL,NULL,'Opaque','',NULL,'','','',''),(161,100,NULL,NULL,NULL,NULL,NULL,'Red-brown','',NULL,'','','',''),(162,100,NULL,NULL,NULL,NULL,NULL,'Opalescent','',NULL,'','','',''),(163,102,0,120,0,0.000,1000.000,NULL,'',NULL,'','','',''),(164,103,0,120,0,0.000,100.000,NULL,'',NULL,'','','',''),(165,104,0,120,0,0.000,100.000,NULL,'','2016-09-15 14:34:38','','','',''),(166,105,0,120,0,0.000,1000000.000,NULL,'',NULL,'','','',''),(167,107,NULL,NULL,NULL,NULL,NULL,'blood stained','',NULL,'','','',''),(168,107,NULL,NULL,NULL,NULL,NULL,'clear','',NULL,'','','',''),(169,108,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(170,109,NULL,NULL,NULL,NULL,NULL,'+','',NULL,'','','',''),(171,109,NULL,NULL,NULL,NULL,NULL,'++','',NULL,'','','',''),(172,109,NULL,NULL,NULL,NULL,NULL,'+++','',NULL,'','','',''),(173,111,NULL,NULL,NULL,NULL,NULL,'Seen','',NULL,'','','',''),(174,111,NULL,NULL,NULL,NULL,NULL,'Not seen','',NULL,'','','',''),(175,112,NULL,NULL,NULL,NULL,NULL,'Reactive','POSITIVE',NULL,'','','',''),(176,112,NULL,NULL,NULL,NULL,NULL,'Non-reactive','NEGATIVE',NULL,'','','',''),(177,113,NULL,NULL,NULL,NULL,NULL,'Reactive','POSITIVE',NULL,'','','',''),(178,113,NULL,NULL,NULL,NULL,NULL,'Non-reactive','NEGATIVE',NULL,'','','',''),(179,114,NULL,NULL,NULL,NULL,NULL,'Reactive','POSITIVE',NULL,'','','',''),(180,114,NULL,NULL,NULL,NULL,NULL,'Non-reactive','NEGATIVE',NULL,'','','',''),(181,115,NULL,NULL,NULL,NULL,NULL,'Positive','',NULL,'','','',''),(182,115,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(183,115,NULL,NULL,NULL,NULL,NULL,'Invalid','',NULL,'','','',''),(184,116,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL,'','','',''),(185,116,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL,'','','',''),(186,116,NULL,NULL,NULL,NULL,NULL,'Invalid','',NULL,'','','',''),(187,117,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL,'','','',''),(188,117,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL,'','','',''),(189,118,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL,'','','',''),(190,118,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL,'','','',''),(191,119,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL,'','','',''),(192,119,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL,'','','',''),(193,120,NULL,NULL,NULL,NULL,NULL,'Positive','POSITIVE',NULL,'','','',''),(194,120,NULL,NULL,NULL,NULL,NULL,'Negative','NEGATIVE',NULL,'','','',''),(195,121,NULL,NULL,NULL,NULL,NULL,'Positive (OD>0.2)','POSITIVE',NULL,'','','',''),(196,121,NULL,NULL,NULL,NULL,NULL,'Negative(OD<0.1)','NEGATIVE',NULL,'','','',''),(197,121,NULL,NULL,NULL,NULL,NULL,'Equivocal','',NULL,'','','',''),(198,122,NULL,NULL,NULL,NULL,NULL,'Positive (OD>0.2)','POSITIVE',NULL,'','','',''),(199,122,NULL,NULL,NULL,NULL,NULL,'Negative (OD<0.1)','NEGATIVE',NULL,'','','',''),(200,122,NULL,NULL,NULL,NULL,NULL,'Equivocal','',NULL,'','','',''),(201,123,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(202,124,0,120,2,0.000,100.000,NULL,'',NULL,'','','',''),(203,125,NULL,NULL,NULL,NULL,NULL,'A RhD Positive','',NULL,'','','',''),(204,125,NULL,NULL,NULL,NULL,NULL,'B RhD Positive ','',NULL,'','','',''),(205,125,NULL,NULL,NULL,NULL,NULL,'AB RhD Positive','',NULL,'','','',''),(206,125,NULL,NULL,NULL,NULL,NULL,'O RhD Positive','',NULL,'','','',''),(207,125,NULL,NULL,NULL,NULL,NULL,'A RhD Negative','',NULL,'','','',''),(208,125,NULL,NULL,NULL,NULL,NULL,'B RhD Negative','',NULL,'','','',''),(209,125,NULL,NULL,NULL,NULL,NULL,'AB RhD Negative','',NULL,'','','',''),(210,125,NULL,NULL,NULL,NULL,NULL,'O RhD Negative','',NULL,'','','',''),(211,131,NULL,NULL,NULL,NULL,NULL,'Saline','',NULL,'','','',''),(212,131,NULL,NULL,NULL,NULL,NULL,'Coombs','',NULL,'','','',''),(213,132,NULL,NULL,NULL,NULL,NULL,'No Reaction','',NULL,'','','',''),(214,132,NULL,NULL,NULL,NULL,NULL,'Suspected Reaction','',NULL,'','','',''),(215,132,NULL,NULL,NULL,NULL,NULL,'Confirmed Reaction','',NULL,'','','',''),(216,127,NULL,NULL,NULL,NULL,NULL,'A RhD Positive','',NULL,'','','',''),(217,127,NULL,NULL,NULL,NULL,NULL,'B RhD Positive','',NULL,'','','',''),(218,127,NULL,NULL,NULL,NULL,NULL,'AB RhD Positive ','',NULL,'','','',''),(219,127,NULL,NULL,NULL,NULL,NULL,'O RhD Positive ','',NULL,'','','',''),(220,127,NULL,NULL,NULL,NULL,NULL,'A RhD Negative','',NULL,'','','',''),(221,127,NULL,NULL,NULL,NULL,NULL,'B RhD Negative','',NULL,'','','',''),(222,127,NULL,NULL,NULL,NULL,NULL,'AB RhD Negative','',NULL,'','','',''),(223,127,NULL,NULL,NULL,NULL,NULL,'O RhD Negative','',NULL,'','','',''),(224,133,5,120,0,0.000,42.000,NULL,'',NULL,'','','',''),(225,134,5,120,0,0.000,35.000,NULL,'',NULL,'','','',''),(226,135,5,120,0,38.000,94.000,NULL,'',NULL,'','','',''),(227,136,5,120,0,0.000,55.000,NULL,'',NULL,'','','',''),(228,137,5,120,2,0.000,0.200,NULL,'',NULL,'','','',''),(229,138,5,120,2,0.300,1.200,NULL,'',NULL,'','','',''),(230,139,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(231,140,5,120,2,3.200,5.000,NULL,'',NULL,'','','',''),(232,141,5,120,2,6.000,8.300,NULL,'',NULL,'','','',''),(233,142,5,120,2,13.000,43.000,NULL,'',NULL,'','','',''),(234,143,5,120,0,0.700,1.300,NULL,'',NULL,'','','',''),(235,144,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(236,145,5,120,0,40.000,160.000,NULL,'',NULL,'','','',''),(237,146,5,120,0,120.000,250.000,NULL,'',NULL,'','','',''),(238,147,0,120,2,4.000,6.000,NULL,'Normal',NULL,'','','',''),(239,147,0,120,2,3.500,5.500,NULL,'Normal','2016-03-03 15:25:21','','','',''),(240,148,0,120,2,10.900,17.300,NULL,'Normal',NULL,'','','',''),(241,148,0,120,2,11.000,16.000,NULL,'Normal','2016-03-03 15:25:21','','','',''),(242,149,0,120,2,32.000,50.000,NULL,'Normal',NULL,'','','',''),(243,149,0,120,2,37.000,54.000,NULL,'Normal','2016-03-03 15:25:21','','','',''),(244,150,0,120,2,71.000,95.000,NULL,'Normal',NULL,'','','',''),(245,150,0,120,0,80.000,100.000,NULL,'Normal','2016-03-03 15:25:21','','','',''),(246,151,0,120,2,23.000,34.000,NULL,'Normal',NULL,'','','',''),(247,152,0,120,2,33.000,36.000,NULL,'Normal',NULL,'','','',''),(248,153,0,120,2,122.000,330.000,NULL,'Normal',NULL,'','','',''),(249,154,0,120,2,37.000,54.000,NULL,'Normal',NULL,'','','',''),(250,155,0,120,2,10.000,16.000,NULL,'Normal',NULL,'','','',''),(251,156,0,120,2,9.000,17.000,NULL,'Normal',NULL,'','','',''),(252,157,0,120,2,6.000,10.000,NULL,'Normal',NULL,'','','',''),(253,158,0,120,2,0.170,0.350,NULL,'Normal',NULL,'','','',''),(254,159,0,120,2,27.000,60.000,NULL,'Normal',NULL,'','','',''),(255,160,0,120,2,29.000,59.000,NULL,'Normal',NULL,'','','',''),(256,160,0,120,2,20.000,40.000,NULL,'Normal','2016-03-03 15:25:21','','','',''),(257,161,0,120,2,2.000,10.000,NULL,'Normal',NULL,'','','',''),(258,162,0,120,2,0.000,12.000,NULL,'Normal',NULL,'','','',''),(259,163,0,120,2,0.000,1.000,NULL,'Normal',NULL,'','','',''),(260,164,0,120,2,0.820,4.100,NULL,'Normal',NULL,'','','',''),(261,165,0,120,2,1.260,3.620,NULL,'Normal',NULL,'','','',''),(262,166,0,120,2,0.120,0.560,NULL,'Normal',NULL,'','','',''),(263,167,0,120,2,0.000,0.780,NULL,'Normal',NULL,'','','',''),(264,168,0,120,2,0.000,0.070,NULL,'Normal',NULL,'','','',''),(265,169,0,120,2,4.000,10.000,NULL,'Normal',NULL,'','','',''),(266,170,0,120,2,0.100,1.500,NULL,'Normal',NULL,'','','',''),(267,171,0,120,2,2.000,7.000,NULL,'Normal',NULL,'','','',''),(268,172,0,120,2,3.000,15.000,NULL,'Normal',NULL,'','','',''),(269,173,0,120,2,50.000,70.000,NULL,'Normal',NULL,'','','',''),(270,174,0,120,2,0.500,5.000,NULL,'Normal',NULL,'','','',''),(271,175,0,120,2,30.000,90.000,NULL,'Normal',NULL,'','','',''),(272,176,0,120,2,11.000,45.000,NULL,'Normal',NULL,'','','',''),(273,177,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(274,178,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(275,179,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(276,180,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(277,181,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(278,182,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(279,183,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(280,185,5,120,2,3.500,5.500,NULL,'',NULL,'','','',''),(281,186,5,120,2,135.000,145.000,NULL,'',NULL,'','','',''),(282,187,5,120,2,98.000,108.000,NULL,'',NULL,'','','',''),(283,188,0,120,0,0.000,1000000.000,NULL,'',NULL,'','','',''),(284,189,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(285,190,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(286,191,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(287,192,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(288,193,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(289,194,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(290,195,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(291,196,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(292,197,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(293,198,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(294,199,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(295,200,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(296,128,NULL,NULL,NULL,NULL,NULL,'Whole Blood','',NULL,'','','',''),(297,128,NULL,NULL,NULL,NULL,NULL,'Packed Red Cells','',NULL,'','','',''),(298,128,NULL,NULL,NULL,NULL,NULL,'Platelets','',NULL,'','','',''),(299,128,NULL,NULL,NULL,NULL,NULL,'FFPs','',NULL,'','','',''),(300,128,NULL,NULL,NULL,NULL,NULL,'Cryoprecipitate','',NULL,'','','',''),(301,201,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(302,201,NULL,NULL,NULL,NULL,NULL,'+++','',NULL,'','','',''),(303,201,NULL,NULL,NULL,NULL,NULL,'++','',NULL,'','','',''),(304,201,NULL,NULL,NULL,NULL,NULL,'+','',NULL,'','','',''),(305,201,NULL,NULL,NULL,NULL,NULL,'Scanty (1-3) per 100','',NULL,'','','',''),(306,201,NULL,NULL,NULL,NULL,NULL,'Scanty (4-6) per 100','',NULL,'','','',''),(307,201,NULL,NULL,NULL,NULL,NULL,'Scanty (7-9) per 100','',NULL,'','','',''),(308,201,NULL,NULL,NULL,NULL,NULL,'Scanty (1-5) per 40','',NULL,'','','',''),(309,201,NULL,NULL,NULL,NULL,NULL,'Scanty (6-9) per 40','',NULL,'','','',''),(310,201,NULL,NULL,NULL,NULL,NULL,'Scanty (10-14) per 40','',NULL,'','','',''),(311,201,NULL,NULL,NULL,NULL,NULL,'Scanty (15-19) per 40','',NULL,'','','',''),(312,204,5,120,0,74.000,100.000,NULL,'',NULL,'','','',''),(313,204,5,120,1,70.000,110.000,NULL,'',NULL,'','','',''),(314,205,18,120,2,12.900,16.900,NULL,'Normal',NULL,'','','',''),(315,206,18,120,2,25.000,41.000,NULL,'Normal',NULL,'','','',''),(316,207,18,120,2,0.900,1.400,NULL,'Normal',NULL,'','','',''),(317,208,18,120,0,0.000,10.000,NULL,'Normal',NULL,'','','',''),(318,208,18,20,1,0.000,15.000,NULL,'Normal',NULL,'','','',''),(319,209,NULL,NULL,NULL,NULL,NULL,'Positive','',NULL,'','','',''),(320,209,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(321,210,NULL,NULL,NULL,NULL,NULL,'Positive','',NULL,'','','',''),(322,210,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(323,231,NULL,NULL,NULL,NULL,NULL,'Positive','',NULL,'','','',''),(324,231,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(325,98,NULL,NULL,NULL,NULL,NULL,'Invalid','',NULL,'','','',''),(326,232,NULL,NULL,NULL,NULL,NULL,'Reactive','',NULL,'','','',''),(327,232,NULL,NULL,NULL,NULL,NULL,'Non-Reactive','',NULL,'','','',''),(328,233,NULL,NULL,NULL,NULL,NULL,'Diagnosis','',NULL,'','','',''),(329,233,NULL,NULL,NULL,NULL,NULL,'Follow-up','',NULL,'','','',''),(330,234,NULL,NULL,NULL,NULL,NULL,'New presumptive TB-smear Neg.HIV Pos','',NULL,'','','',''),(331,234,NULL,NULL,NULL,NULL,NULL,'Presumptive MDR TB','',NULL,'','','',''),(332,202,NULL,NULL,NULL,NULL,NULL,'MTB Detected High','','2016-07-22 09:27:14','','','',''),(333,202,NULL,NULL,NULL,NULL,NULL,'MTB Detected Medium','','2016-07-22 09:27:14','','','',''),(334,202,NULL,NULL,NULL,NULL,NULL,'MTB Detected Low','','2016-07-22 09:27:14','','','',''),(335,202,NULL,NULL,NULL,NULL,NULL,'MTB Not Detected','','2016-07-22 09:27:14','','','',''),(336,203,NULL,NULL,NULL,NULL,NULL,'RIF Resistant detected','','2016-07-22 09:27:14','','','',''),(337,203,NULL,NULL,NULL,NULL,NULL,'RIF Resistant not detected','','2016-07-22 09:27:14','','','',''),(338,203,NULL,NULL,NULL,NULL,NULL,'RIF Resistant indeterminate','','2016-07-22 09:27:14','','','',''),(339,234,NULL,NULL,NULL,NULL,NULL,'Hospitalised','',NULL,'','','',''),(340,234,NULL,NULL,NULL,NULL,NULL,'Others','',NULL,'','','',''),(341,235,0,120,2,0.000,1000000.000,NULL,'',NULL,'','','',''),(342,236,5,120,2,226.000,450.000,NULL,'',NULL,'','','',''),(343,237,5,120,0,35.300,79.500,NULL,'',NULL,'','','',''),(344,238,5,120,2,0.000,130.000,NULL,'',NULL,'','','',''),(345,239,5,120,0,0.700,1.300,NULL,'',NULL,'','','',''),(346,240,5,120,0,0.700,1.300,NULL,'',NULL,'','','',''),(347,241,5,120,0,8.600,10.200,NULL,'',NULL,'','','',''),(348,242,5,120,2,2.500,4.500,NULL,'',NULL,'','','',''),(349,243,5,120,2,1.600,2.600,NULL,'',NULL,'','','',''),(350,244,5,120,2,0.000,170.000,NULL,'',NULL,'','','',''),(351,245,5,120,0,3.400,7.000,NULL,'',NULL,'','','',''),(352,246,5,120,2,0.000,0.200,NULL,'',NULL,'','','',''),(353,247,5,120,2,0.300,1.200,NULL,'',NULL,'','','',''),(354,243,0,5,2,1.600,2.600,NULL,'',NULL,'','','',''),(355,145,5,120,1,35.000,135.000,NULL,'',NULL,'','','',''),(356,145,0,4,2,35.000,135.000,NULL,'',NULL,'','','',''),(357,146,5,120,1,110.000,230.000,NULL,'',NULL,'','','',''),(358,146,0,4,0,110.000,230.000,NULL,'',NULL,'','','',''),(359,237,5,120,1,42.000,88.000,NULL,'',NULL,'','','',''),(360,237,0,4,2,42.000,88.000,NULL,'',NULL,'','','',''),(361,238,0,4,2,0.000,130.000,NULL,'',NULL,'','','',''),(362,133,5,120,1,0.000,32.000,NULL,'',NULL,'','','',''),(363,133,0,4,2,0.000,32.000,NULL,'',NULL,'','','',''),(364,134,5,120,1,0.000,31.000,NULL,'',NULL,'','','',''),(365,134,0,4,2,0.000,37.000,NULL,'',NULL,'','','',''),(366,135,5,120,1,53.000,128.000,NULL,'',NULL,'','','',''),(367,135,0,4,2,42.000,98.000,NULL,'',NULL,'','','',''),(368,136,5,120,1,0.000,38.000,NULL,'',NULL,'','','',''),(369,136,0,4,2,0.000,32.000,NULL,'',NULL,'','','',''),(370,137,0,4,2,0.000,0.200,NULL,'',NULL,'','','',''),(371,138,0,4,2,0.300,1.200,NULL,'',NULL,'','','',''),(372,140,0,4,2,3.200,5.000,NULL,'',NULL,'','','',''),(373,141,0,4,2,6.000,8.300,NULL,'',NULL,'','','',''),(374,236,0,4,0,226.000,450.000,NULL,'',NULL,'','','',''),(375,246,0,4,2,0.000,0.200,NULL,'',NULL,'','','',''),(376,247,0,4,2,0.300,1.200,NULL,'',NULL,'','','',''),(377,142,0,4,2,13.000,43.000,NULL,'',NULL,'','','',''),(378,143,5,120,1,0.600,1.100,NULL,'',NULL,'','','',''),(379,143,0,4,2,0.600,1.100,NULL,'',NULL,'','','',''),(380,239,0,4,2,0.600,1.100,NULL,'',NULL,'','','',''),(381,240,0,4,2,0.600,1.100,NULL,'',NULL,'','','',''),(382,245,5,120,1,2.400,5.700,NULL,'',NULL,'','','',''),(383,245,0,4,2,3.400,7.000,NULL,'',NULL,'','','',''),(384,239,5,120,1,0.600,1.100,NULL,'',NULL,'','','',''),(385,240,5,120,1,0.600,1.100,NULL,'',NULL,'','','',''),(386,204,0,4,2,65.000,110.000,NULL,'',NULL,'','','',''),(387,242,0,4,2,2.500,4.500,NULL,'',NULL,'','','',''),(388,229,5,120,2,0.000,80.000,NULL,'',NULL,'','','',''),(389,229,0,4,2,0.000,80.000,NULL,'',NULL,'','','',''),(390,230,5,120,2,0.000,60.000,NULL,'',NULL,'','','',''),(391,230,0,4,2,0.000,60.000,NULL,'',NULL,'','','',''),(392,241,5,120,1,8.400,10.400,NULL,'',NULL,'','','',''),(393,241,0,4,2,8.400,10.400,NULL,'',NULL,'','','',''),(394,185,0,4,2,3.500,5.500,NULL,'',NULL,'','','',''),(395,186,0,4,2,135.000,145.000,NULL,'',NULL,'','','',''),(396,187,0,4,2,98.000,108.000,NULL,'',NULL,'','','',''),(397,78,NULL,NULL,NULL,NULL,NULL,'no cells seen','',NULL,'','','',''),(398,82,NULL,NULL,NULL,NULL,NULL,'Yeast cells ++','',NULL,'','','',''),(399,82,NULL,NULL,NULL,NULL,NULL,'Yeast cells +++','',NULL,'','','',''),(400,82,NULL,NULL,NULL,NULL,NULL,'Not seen','',NULL,'','','',''),(401,83,NULL,NULL,NULL,NULL,NULL,'Haemolysis +/-','',NULL,'','','',''),(402,83,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(403,83,NULL,NULL,NULL,NULL,NULL,'+/- (trace)','',NULL,'','','',''),(404,83,NULL,NULL,NULL,NULL,NULL,'+ (25)','',NULL,'','','',''),(405,83,NULL,NULL,NULL,NULL,NULL,'++ (75)','',NULL,'','','',''),(406,83,NULL,NULL,NULL,NULL,NULL,'+++ (500)','',NULL,'','','',''),(407,87,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(408,87,NULL,NULL,NULL,NULL,NULL,'+/-','',NULL,'','','',''),(409,87,NULL,NULL,NULL,NULL,NULL,'+','',NULL,'','','',''),(410,87,NULL,NULL,NULL,NULL,NULL,'++','',NULL,'','','',''),(411,87,NULL,NULL,NULL,NULL,NULL,'+++','',NULL,'','','',''),(412,87,NULL,NULL,NULL,NULL,NULL,'++++','',NULL,'','','',''),(413,89,NULL,NULL,NULL,NULL,NULL,'+','',NULL,'','','',''),(414,89,NULL,NULL,NULL,NULL,NULL,'++','',NULL,'','','',''),(415,89,NULL,NULL,NULL,NULL,NULL,'+++','',NULL,'','','',''),(416,89,NULL,NULL,NULL,NULL,NULL,'++++','',NULL,'','','',''),(417,90,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(418,90,NULL,NULL,NULL,NULL,NULL,'+/- (100)','',NULL,'','','',''),(419,90,NULL,NULL,NULL,NULL,NULL,'+ (250)','',NULL,'','','',''),(420,90,NULL,NULL,NULL,NULL,NULL,'++ (500)','',NULL,'','','',''),(421,90,NULL,NULL,NULL,NULL,NULL,'+++ (1000)','',NULL,'','','',''),(422,90,NULL,NULL,NULL,NULL,NULL,'++++ (2000)','',NULL,'','','',''),(423,91,NULL,NULL,NULL,NULL,NULL,'1.000','',NULL,'','','',''),(424,91,NULL,NULL,NULL,NULL,NULL,'1.005','',NULL,'','','',''),(425,91,NULL,NULL,NULL,NULL,NULL,'1.010','',NULL,'','','',''),(426,91,NULL,NULL,NULL,NULL,NULL,'1.015','',NULL,'','','',''),(427,91,NULL,NULL,NULL,NULL,NULL,'1.020','',NULL,'','','',''),(428,91,NULL,NULL,NULL,NULL,NULL,'1.025','',NULL,'','','',''),(429,91,NULL,NULL,NULL,NULL,NULL,'1.030','',NULL,'','','',''),(430,92,NULL,NULL,NULL,NULL,NULL,'+ (25)','',NULL,'','','',''),(431,92,NULL,NULL,NULL,NULL,NULL,'++ (75)','',NULL,'','','',''),(432,92,NULL,NULL,NULL,NULL,NULL,'+++ (500)','',NULL,'','','',''),(433,92,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(434,248,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(435,249,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(436,250,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(437,104,NULL,NULL,NULL,NULL,NULL,'1','',NULL,'','','',''),(438,104,NULL,NULL,NULL,NULL,NULL,'2','',NULL,'','','',''),(439,104,NULL,NULL,NULL,NULL,NULL,'3','',NULL,'','','',''),(440,104,NULL,NULL,NULL,NULL,NULL,'4','',NULL,'','','',''),(441,104,NULL,NULL,NULL,NULL,NULL,'5','',NULL,'','','',''),(442,104,NULL,NULL,NULL,NULL,NULL,'6','',NULL,'','','',''),(443,104,NULL,NULL,NULL,NULL,NULL,'7','',NULL,'','','',''),(444,104,NULL,NULL,NULL,NULL,NULL,'8','',NULL,'','','',''),(445,104,NULL,NULL,NULL,NULL,NULL,'9','',NULL,'','','',''),(446,104,NULL,NULL,NULL,NULL,NULL,'10','',NULL,'','','',''),(447,104,NULL,NULL,NULL,NULL,NULL,'11','',NULL,'','','',''),(448,104,NULL,NULL,NULL,NULL,NULL,'12','',NULL,'','','',''),(449,104,NULL,NULL,NULL,NULL,NULL,'13','',NULL,'','','',''),(450,104,NULL,NULL,NULL,NULL,NULL,'14','',NULL,'','','',''),(451,232,NULL,NULL,NULL,NULL,NULL,'Not known','',NULL,'','','',''),(452,251,NULL,NULL,NULL,NULL,NULL,'Positive','',NULL,'','','',''),(453,251,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(454,252,0,0,2,0.000,0.000,NULL,'',NULL,'','','',''),(455,253,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(456,254,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(457,255,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(458,256,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(459,257,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(460,258,NULL,NULL,NULL,NULL,NULL,'1','',NULL,'','','',''),(461,258,NULL,NULL,NULL,NULL,NULL,'2','',NULL,'','','',''),(462,258,NULL,NULL,NULL,NULL,NULL,'3','',NULL,'','','',''),(463,258,NULL,NULL,NULL,NULL,NULL,'4','',NULL,'','','',''),(464,258,NULL,NULL,NULL,NULL,NULL,'5','',NULL,'','','',''),(465,258,NULL,NULL,NULL,NULL,NULL,'6','',NULL,'','','',''),(466,258,NULL,NULL,NULL,NULL,NULL,'7','',NULL,'','','',''),(467,258,NULL,NULL,NULL,NULL,NULL,'8','',NULL,'','','',''),(468,258,NULL,NULL,NULL,NULL,NULL,'9','',NULL,'','','',''),(469,258,NULL,NULL,NULL,NULL,NULL,'10','',NULL,'','','',''),(470,258,NULL,NULL,NULL,NULL,NULL,'11','',NULL,'','','',''),(471,258,NULL,NULL,NULL,NULL,NULL,'12','',NULL,'','','',''),(472,258,NULL,NULL,NULL,NULL,NULL,'13','',NULL,'','','',''),(473,258,NULL,NULL,NULL,NULL,NULL,'14','',NULL,'','','',''),(474,259,0,120,2,0.820,1.090,NULL,'',NULL,'','','',''),(475,260,0,120,2,2.610,3.810,NULL,'',NULL,'','','',''),(476,261,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(477,262,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(478,263,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(479,264,0,120,2,77.000,117.000,NULL,'',NULL,'','','',''),(480,265,0,120,2,95.000,135.000,NULL,'',NULL,'','','',''),(481,266,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(482,267,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(483,268,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(484,269,0,120,2,25.000,41.000,NULL,'',NULL,'','','',''),(485,270,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(486,271,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(487,272,0,120,2,2.610,3.810,NULL,'',NULL,'','','',''),(488,273,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(489,274,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(490,275,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(491,276,0,120,2,95.000,135.000,NULL,'normal',NULL,'','','',''),(492,277,0,120,2,77.000,117.000,NULL,'normal',NULL,'','','',''),(493,234,NULL,NULL,NULL,NULL,NULL,'not indicated','',NULL,'','','',''),(494,278,0,100,2,0.000,240.000,NULL,'normal',NULL,'','','',''),(495,279,0,100,2,6.000,8.000,NULL,'normal',NULL,'','','',''),(496,280,1,4,2,1.000,4.000,NULL,'',NULL,'','','',''),(497,280,0,0,0,0.000,0.000,NULL,'',NULL,'','','',''),(498,281,1,5,0,1.000,5.000,NULL,'','2017-04-11 12:18:22','','','',''),(499,281,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(500,281,NULL,NULL,NULL,NULL,NULL,'Positive','',NULL,'','','',''),(501,283,0,120,0,1.000,5.000,NULL,'','2017-04-18 10:48:55','','','',''),(502,283,NULL,NULL,NULL,NULL,NULL,'Positive','',NULL,'','','',''),(503,283,NULL,NULL,NULL,NULL,NULL,'Negative','',NULL,'','','',''),(504,283,NULL,NULL,NULL,NULL,NULL,'Discordant','',NULL,'','','',''),(505,284,1,5,0,1.000,5.000,NULL,'','2017-04-18 10:58:49','','','',''),(506,285,0,120,2,0.000,10.000,NULL,'',NULL,'','','',''),(507,286,0,120,2,0.000,10.000,NULL,'',NULL,'','','','');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drugs`
--

LOCK TABLES `drugs` WRITE;
/*!40000 ALTER TABLE `drugs` DISABLE KEYS */;
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

) ENGINE=InnoDB AUTO_INCREMENT=1361 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `permission_role` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1),(10,10,1),(11,11,1),(12,12,1),(13,13,1),(14,14,1),(15,15,1),(16,16,1),(17,17,1),(18,18,1),(19,19,1),(20,20,1),(21,1,1),(22,1,3),(23,2,1),(24,2,3),(25,3,1),(26,3,3),(27,4,1),(28,4,3),(29,5,1),(30,5,3),(31,6,1),(32,6,2),(33,7,1),(34,7,2),(35,8,1),(36,8,2),(37,9,1),(38,9,2),(39,10,1),(40,10,2),(41,11,1),(42,11,2),(43,12,1),(44,12,2),(45,13,1),(46,13,2),(47,14,1),(48,15,1),(49,16,1),(50,17,1),(51,17,2),(52,18,1),(53,19,1),(54,20,1),(55,1,1),(56,1,2),(57,1,3),(58,2,1),(59,2,2),(60,2,3),(61,3,1),(62,3,2),(63,3,3),(64,4,1),(65,4,3),(66,5,1),(67,5,2),(68,5,3),(69,6,1),(70,6,2),(71,7,1),(72,7,2),(73,8,1),(74,8,2),(75,9,1),(76,9,2),(77,10,1),(78,10,2),(79,11,1),(80,11,2),(81,12,1),(82,12,2),(83,13,1),(84,13,2),(85,14,1),(86,15,1),(87,16,1),(88,17,1),(89,17,2),(90,18,1),(91,19,1),(92,20,1),(93,21,1),(94,22,1),(95,1,1),(96,1,2),(97,1,3),(98,2,1),(99,2,2),(100,2,3),(101,3,1),(102,3,2),(103,3,3),(104,4,1),(105,4,2),(106,4,3),(107,5,1),(108,5,2),(109,5,3),(110,6,1),(111,6,2),(112,7,1),(113,7,2),(114,8,1),(115,8,2),(116,9,1),(117,9,2),(118,10,1),(119,10,2),(120,11,1),(121,11,2),(122,12,1),(123,12,2),(124,13,1),(125,13,2),(126,14,1),(127,15,1),(128,16,1),(129,17,1),(130,17,2),(131,18,1),(132,19,1),(133,20,1),(134,21,1),(135,21,2),(136,22,1),(137,22,2),(138,1,1),(139,1,2),(140,1,3),(141,2,1),(142,2,2),(143,2,3),(144,3,1),(145,3,2),(146,3,3),(147,4,1),(148,4,2),(149,4,3),(150,5,1),(151,5,2),(152,5,3),(153,6,1),(154,6,2),(155,6,3),(156,7,1),(157,7,2),(158,8,1),(159,8,2),(160,9,1),(161,9,2),(162,10,1),(163,10,2),(164,11,1),(165,11,2),(166,12,1),(167,12,2),(168,13,1),(169,13,2),(170,14,1),(171,15,1),(172,16,1),(173,17,1),(174,17,2),(175,18,1),(176,19,1),(177,20,1),(178,21,1),(179,21,2),(180,22,1),(181,22,2),(182,1,1),(183,1,2),(184,1,3),(185,1,4),(186,1,5),(187,2,1),(188,2,2),(189,2,3),(190,2,4),(191,2,5),(192,3,1),(193,3,2),(194,3,3),(195,3,4),(196,3,5),(197,4,1),(198,4,2),(199,4,3),(200,4,4),(201,4,5),(202,5,1),(203,5,2),(204,5,3),(205,5,4),(206,5,5),(207,6,1),(208,6,2),(209,6,3),(210,6,4),(211,6,5),(212,7,1),(213,7,2),(214,7,4),(215,7,5),(216,8,1),(217,8,2),(218,8,4),(219,8,5),(220,9,1),(221,9,2),(222,9,4),(223,9,5),(224,10,1),(225,10,2),(226,10,4),(227,10,5),(228,11,1),(229,11,2),(230,11,4),(231,11,5),(232,12,1),(233,12,2),(234,12,4),(235,12,5),(236,13,1),(237,13,2),(238,13,4),(239,13,5),(240,14,1),(241,15,1),(242,16,1),(243,17,1),(244,17,2),(245,17,4),(246,17,5),(247,18,1),(248,19,1),(249,20,1),(250,21,1),(251,21,2),(252,21,4),(253,21,5),(254,22,1),(255,22,2),(256,22,4),(257,22,5),(258,1,1),(259,1,2),(260,1,3),(261,1,4),(262,1,5),(263,1,6),(264,2,1),(265,2,2),(266,2,3),(267,2,4),(268,2,5),(269,2,6),(270,3,1),(271,3,2),(272,3,3),(273,3,4),(274,3,5),(275,3,6),(276,4,1),(277,4,2),(278,4,3),(279,4,4),(280,4,5),(281,4,6),(282,5,1),(283,5,2),(284,5,3),(285,5,4),(286,5,5),(287,5,6),(288,6,1),(289,6,2),(290,6,3),(291,6,4),(292,6,5),(293,6,6),(294,7,1),(295,7,2),(296,7,4),(297,7,5),(298,7,6),(299,8,1),(300,8,2),(301,8,4),(302,8,5),(303,8,6),(304,9,1),(305,9,2),(306,9,4),(307,9,5),(308,9,6),(309,10,1),(310,10,2),(311,10,4),(312,10,5),(313,10,6),(314,11,1),(315,11,2),(316,11,4),(317,11,5),(318,11,6),(319,12,1),(320,12,2),(321,12,4),(322,12,5),(323,13,1),(324,13,2),(325,13,4),(326,13,5),(327,14,1),(328,15,1),(329,16,1),(330,17,1),(331,17,2),(332,17,4),(333,17,5),(334,17,6),(335,18,1),(336,19,1),(337,20,1),(338,21,1),(339,21,2),(340,21,4),(341,21,5),(342,22,1),(343,22,2),(344,22,4),(345,22,5),(346,22,6),(347,1,1),(348,1,2),(349,1,3),(350,1,4),(351,1,5),(352,1,6),(353,2,1),(354,2,2),(355,2,3),(356,2,4),(357,2,5),(358,2,6),(359,3,1),(360,3,2),(361,3,3),(362,3,4),(363,3,5),(364,3,6),(365,4,1),(366,4,2),(367,4,3),(368,4,4),(369,4,5),(370,4,6),(371,5,1),(372,5,2),(373,5,3),(374,5,4),(375,5,5),(376,5,6),(377,6,1),(378,6,2),(379,6,3),(380,6,4),(381,6,5),(382,6,6),(383,7,1),(384,7,2),(385,7,4),(386,7,5),(387,7,6),(388,8,1),(389,8,2),(390,8,4),(391,8,5),(392,8,6),(393,9,1),(394,9,2),(395,9,4),(396,9,5),(397,9,6),(398,10,1),(399,10,2),(400,10,4),(401,10,5),(402,10,6),(403,11,1),(404,11,2),(405,11,4),(406,11,5),(407,11,6),(408,12,1),(409,12,2),(410,12,4),(411,12,5),(412,13,1),(413,13,2),(414,13,4),(415,13,5),(416,14,1),(418,15,1),(420,16,1),(422,17,1),(423,17,2),(424,17,4),(425,17,5),(426,17,6),(427,18,1),(429,19,1),(431,20,1),(433,21,1),(434,21,2),(435,21,4),(436,21,5),(437,22,1),(438,22,2),(439,22,4),(440,22,5),(441,22,6),(442,1,1),(443,1,2),(444,1,3),(445,1,4),(446,1,5),(447,1,6),(448,2,1),(449,2,2),(450,2,3),(451,2,4),(452,2,5),(453,2,6),(454,3,1),(455,3,2),(456,3,3),(457,3,4),(458,3,5),(459,3,6),(460,4,1),(461,4,2),(462,4,3),(463,4,4),(464,4,5),(465,4,6),(466,5,1),(467,5,2),(468,5,3),(469,5,4),(470,5,5),(471,5,6),(472,6,1),(473,6,2),(474,6,3),(475,6,4),(476,6,5),(477,6,6),(478,7,1),(479,7,2),(480,7,4),(481,7,5),(482,7,6),(483,8,1),(484,8,2),(485,8,4),(486,8,5),(487,8,6),(488,9,1),(489,9,2),(490,9,4),(491,9,5),(492,9,6),(493,10,1),(494,10,2),(495,10,4),(496,10,5),(497,10,6),(498,11,1),(499,11,2),(500,11,4),(501,11,5),(502,11,6),(503,12,1),(504,12,2),(505,12,4),(506,12,5),(507,13,1),(508,13,2),(509,13,4),(510,13,5),(511,14,1),(512,15,1),(513,16,1),(514,17,1),(515,17,2),(516,17,4),(517,17,5),(518,17,6),(519,18,1),(520,19,1),(521,20,1),(522,21,1),(523,21,2),(524,21,4),(525,21,5),(526,22,1),(527,22,2),(528,22,4),(529,22,5),(530,22,6),(531,1,1),(532,1,2),(533,1,3),(534,1,4),(535,1,5),(536,1,6),(537,1,7),(538,2,1),(539,2,2),(540,2,3),(541,2,4),(542,2,5),(543,2,6),(544,2,7),(545,3,1),(546,3,2),(547,3,3),(548,3,4),(549,3,5),(550,3,6),(551,3,7),(552,4,1),(553,4,2),(554,4,3),(555,4,4),(556,4,5),(557,4,6),(558,4,7),(559,5,1),(560,5,2),(561,5,3),(562,5,4),(563,5,5),(564,5,6),(565,5,7),(566,6,1),(567,6,2),(568,6,3),(569,6,4),(570,6,5),(571,6,6),(572,6,7),(573,7,1),(574,7,2),(575,7,4),(576,7,5),(577,7,6),(578,7,7),(579,8,1),(580,8,2),(581,8,4),(582,8,5),(583,8,6),(584,8,7),(585,9,1),(586,9,2),(587,9,4),(588,9,5),(589,9,6),(590,9,7),(591,10,1),(592,10,2),(593,10,4),(594,10,5),(595,10,6),(596,10,7),(597,11,1),(598,11,2),(599,11,4),(600,11,5),(601,11,6),(602,11,7),(603,12,1),(604,12,2),(605,12,4),(606,12,5),(607,12,7),(608,13,1),(609,13,2),(610,13,4),(611,13,5),(612,13,7),(613,14,1),(614,14,7),(615,15,1),(616,15,7),(617,16,1),(618,16,7),(619,17,1),(620,17,2),(621,17,4),(622,17,5),(623,17,6),(624,17,7),(625,18,1),(626,18,7),(627,19,1),(628,19,7),(629,20,1),(630,20,7),(631,21,1),(632,21,2),(633,21,4),(634,21,5),(635,21,7),(636,22,1),(637,22,2),(638,22,4),(639,22,5),(640,22,6),(641,22,7),(642,1,1),(643,1,2),(644,1,3),(645,1,4),(646,1,5),(647,1,6),(648,1,7),(649,2,1),(650,2,2),(651,2,3),(652,2,4),(653,2,5),(654,2,6),(655,2,7),(656,3,1),(657,3,2),(658,3,3),(659,3,4),(660,3,5),(661,3,6),(662,3,7),(663,4,1),(664,4,2),(665,4,3),(666,4,4),(667,4,5),(668,4,6),(669,4,7),(670,5,1),(671,5,2),(672,5,3),(673,5,4),(674,5,5),(675,5,6),(676,5,7),(677,6,1),(678,6,2),(679,6,3),(680,6,4),(681,6,5),(682,6,6),(683,6,7),(684,7,1),(685,7,2),(686,7,4),(687,7,5),(688,7,6),(689,7,7),(690,8,1),(691,8,2),(692,8,4),(693,8,5),(694,8,6),(695,8,7),(696,9,1),(697,9,2),(698,9,4),(699,9,5),(700,9,6),(701,9,7),(702,10,1),(703,10,2),(704,10,4),(705,10,5),(706,10,6),(707,10,7),(708,11,1),(709,11,2),(710,11,4),(711,11,5),(712,11,6),(713,11,7),(714,12,1),(715,12,2),(716,12,4),(717,12,5),(718,12,7),(719,13,1),(720,13,2),(721,13,4),(722,13,5),(723,13,7),(724,14,1),(725,14,7),(726,15,1),(727,15,7),(728,16,1),(729,16,7),(730,17,1),(731,17,2),(732,17,4),(733,17,5),(734,17,6),(735,17,7),(736,18,1),(737,18,7),(738,19,1),(739,19,7),(740,20,1),(741,20,7),(742,21,1),(743,21,2),(744,21,4),(745,21,5),(746,21,7),(747,22,1),(748,22,2),(749,22,4),(750,22,5),(751,22,6),(752,22,7),(753,1,1),(754,1,2),(755,1,3),(756,1,4),(757,1,5),(758,1,6),(759,1,7),(760,1,8),(761,2,1),(762,2,2),(763,2,3),(764,2,4),(765,2,5),(766,2,6),(767,2,7),(768,2,8),(769,3,1),(770,3,2),(771,3,3),(772,3,4),(773,3,5),(774,3,6),(775,3,7),(776,3,8),(777,4,1),(778,4,2),(779,4,3),(780,4,4),(781,4,5),(782,4,6),(783,4,7),(784,4,8),(785,5,1),(786,5,2),(787,5,3),(788,5,4),(789,5,5),(790,5,6),(791,5,7),(792,5,8),(793,6,1),(794,6,2),(795,6,3),(796,6,4),(797,6,5),(798,6,6),(799,6,7),(800,6,8),(801,7,1),(802,7,2),(803,7,4),(804,7,5),(805,7,6),(806,7,7),(807,7,8),(808,8,1),(809,8,2),(810,8,4),(811,8,5),(812,8,6),(813,8,7),(814,8,8),(815,9,1),(816,9,2),(817,9,4),(818,9,5),(819,9,6),(820,9,7),(821,9,8),(822,10,1),(823,10,2),(824,10,4),(825,10,5),(826,10,6),(827,10,7),(828,10,8),(829,11,1),(830,11,2),(831,11,4),(832,11,5),(833,11,6),(834,11,7),(835,11,8),(836,12,1),(837,12,2),(838,12,4),(839,12,5),(840,12,7),(841,12,8),(842,13,1),(843,13,2),(844,13,4),(845,13,5),(846,13,7),(847,13,8),(848,14,1),(849,14,7),(850,14,8),(851,15,1),(852,15,7),(853,15,8),(854,16,1),(855,16,7),(856,16,8),(857,17,1),(858,17,2),(859,17,4),(860,17,5),(861,17,6),(862,17,7),(863,17,8),(864,18,1),(865,18,7),(866,18,8),(867,19,1),(868,19,7),(869,19,8),(870,20,1),(871,20,7),(872,20,8),(873,21,1),(874,21,2),(875,21,4),(876,21,5),(877,21,7),(878,21,8),(879,22,1),(880,22,2),(881,22,4),(882,22,5),(883,22,6),(884,22,7),(885,22,8),(886,1,1),(887,1,2),(888,1,3),(889,1,4),(890,1,5),(891,1,6),(892,1,7),(893,1,8),(894,1,9),(895,2,1),(896,2,2),(897,2,3),(898,2,4),(899,2,5),(900,2,6),(901,2,7),(902,2,8),(903,2,9),(904,3,1),(905,3,2),(906,3,3),(907,3,4),(908,3,5),(909,3,6),(910,3,7),(911,3,8),(912,3,9),(913,4,1),(914,4,2),(915,4,3),(916,4,4),(917,4,5),(918,4,6),(919,4,7),(920,4,8),(921,4,9),(922,5,1),(923,5,2),(924,5,3),(925,5,4),(926,5,5),(927,5,6),(928,5,7),(929,5,8),(930,5,9),(931,6,1),(932,6,2),(933,6,3),(934,6,4),(935,6,5),(936,6,6),(937,6,7),(938,6,8),(939,6,9),(940,7,1),(941,7,2),(942,7,4),(943,7,5),(944,7,6),(945,7,7),(946,7,8),(947,7,9),(948,8,1),(949,8,2),(950,8,4),(951,8,5),(952,8,6),(953,8,7),(954,8,8),(955,8,9),(956,9,1),(957,9,2),(958,9,4),(959,9,5),(960,9,6),(961,9,7),(962,9,8),(963,9,9),(964,10,1),(965,10,2),(966,10,4),(967,10,5),(968,10,6),(969,10,7),(970,10,8),(971,10,9),(972,11,1),(973,11,2),(974,11,4),(975,11,5),(976,11,6),(977,11,7),(978,11,8),(979,11,9),(980,12,1),(981,12,2),(982,12,4),(983,12,5),(984,12,7),(985,12,8),(986,12,9),(987,13,1),(988,13,2),(989,13,4),(990,13,5),(991,13,7),(992,13,8),(993,13,9),(994,14,1),(995,14,7),(996,14,8),(997,14,9),(998,15,1),(999,15,7),(1000,15,8),(1001,15,9),(1002,16,1),(1003,16,7),(1004,16,8),(1005,16,9),(1006,17,1),(1007,17,2),(1008,17,4),(1009,17,5),(1010,17,6),(1011,17,7),(1012,17,8),(1013,17,9),(1014,18,1),(1015,18,7),(1016,18,8),(1017,18,9),(1018,19,1),(1019,19,7),(1020,19,8),(1021,19,9),(1022,20,1),(1023,20,7),(1024,20,8),(1025,20,9),(1026,21,1),(1027,21,2),(1028,21,4),(1029,21,5),(1030,21,7),(1031,21,8),(1032,21,9),(1033,22,1),(1034,22,2),(1035,22,4),(1036,22,5),(1037,22,6),(1038,22,7),(1039,22,8),(1040,22,9),(1041,1,1),(1042,1,2),(1043,1,3),(1044,1,4),(1045,1,5),(1046,1,6),(1047,1,7),(1048,1,8),(1049,1,9),(1050,2,1),(1051,2,2),(1052,2,3),(1053,2,4),(1054,2,5),(1055,2,6),(1056,2,7),(1057,2,8),(1058,2,9),(1059,3,1),(1060,3,2),(1061,3,3),(1062,3,4),(1063,3,5),(1064,3,6),(1065,3,7),(1066,3,8),(1067,3,9),(1068,4,1),(1069,4,2),(1070,4,3),(1071,4,4),(1072,4,5),(1073,4,6),(1074,4,7),(1075,4,8),(1076,4,9),(1077,5,1),(1078,5,2),(1079,5,3),(1080,5,4),(1081,5,5),(1082,5,6),(1083,5,7),(1084,5,8),(1085,5,9),(1086,6,1),(1087,6,2),(1088,6,3),(1089,6,4),(1090,6,5),(1091,6,6),(1092,6,7),(1093,6,8),(1094,6,9),(1095,7,1),(1096,7,2),(1097,7,4),(1098,7,5),(1099,7,6),(1100,7,7),(1101,7,8),(1102,7,9),(1103,8,1),(1104,8,2),(1105,8,4),(1106,8,5),(1107,8,6),(1108,8,7),(1109,8,8),(1110,8,9),(1111,9,1),(1112,9,2),(1113,9,4),(1114,9,5),(1115,9,6),(1116,9,7),(1117,9,8),(1118,9,9),(1119,10,1),(1120,10,2),(1121,10,4),(1122,10,5),(1123,10,6),(1124,10,7),(1125,10,8),(1126,10,9),(1127,11,1),(1128,11,2),(1129,11,4),(1130,11,5),(1131,11,6),(1132,11,7),(1133,11,8),(1134,11,9),(1135,12,1),(1136,12,2),(1137,12,4),(1138,12,5),(1139,12,7),(1140,12,8),(1141,12,9),(1142,13,1),(1143,13,2),(1144,13,4),(1145,13,5),(1146,13,7),(1147,13,8),(1148,13,9),(1149,14,1),(1150,14,7),(1151,14,8),(1152,14,9),(1153,15,1),(1154,15,7),(1155,15,8),(1156,15,9),(1157,16,1),(1158,16,7),(1159,16,8),(1160,16,9),(1161,17,1),(1162,17,2),(1163,17,4),(1164,17,5),(1165,17,6),(1166,17,7),(1167,17,8),(1168,17,9),(1169,18,1),(1170,18,7),(1171,18,8),(1172,18,9),(1173,19,1),(1174,19,7),(1175,19,8),(1176,19,9),(1177,20,1),(1178,20,7),(1179,20,8),(1180,20,9),(1181,21,1),(1182,21,2),(1183,21,4),(1184,21,5),(1185,21,7),(1186,21,8),(1187,21,9),(1188,22,1),(1189,22,2),(1190,22,4),(1191,22,5),(1192,22,6),(1193,22,7),(1194,22,8),(1195,22,9),(1196,1,1),(1197,1,2),(1198,1,3),(1199,1,4),(1200,1,5),(1201,1,6),(1202,1,7),(1203,1,8),(1204,1,9),(1205,1,10),(1206,2,1),(1207,2,2),(1208,2,3),(1209,2,4),(1210,2,5),(1211,2,6),(1212,2,7),(1213,2,8),(1214,2,9),(1215,2,10),(1216,3,1),(1217,3,2),(1218,3,3),(1219,3,4),(1220,3,5),(1221,3,6),(1222,3,7),(1223,3,8),(1224,3,9),(1225,3,10),(1226,4,1),(1227,4,2),(1228,4,3),(1229,4,4),(1230,4,5),(1231,4,6),(1232,4,7),(1233,4,8),(1234,4,9),(1235,4,10),(1236,5,1),(1237,5,2),(1238,5,3),(1239,5,4),(1240,5,5),(1241,5,6),(1242,5,7),(1243,5,8),(1244,5,9),(1245,5,10),(1246,6,1),(1247,6,2),(1248,6,3),(1249,6,4),(1250,6,5),(1251,6,6),(1252,6,7),(1253,6,8),(1254,6,9),(1255,6,10),(1256,7,1),(1257,7,2),(1258,7,4),(1259,7,5),(1260,7,6),(1261,7,7),(1262,7,8),(1263,7,9),(1264,8,1),(1265,8,2),(1266,8,4),(1267,8,5),(1268,8,6),(1269,8,7),(1270,8,8),(1271,8,9),(1272,8,10),(1273,9,1),(1274,9,2),(1275,9,4),(1276,9,5),(1277,9,6),(1278,9,7),(1279,9,8),(1280,9,9),(1281,9,10),(1282,10,1),(1283,10,2),(1284,10,4),(1285,10,5),(1286,10,6),(1287,10,7),(1288,10,8),(1289,10,9),(1290,11,1),(1291,11,2),(1292,11,4),(1293,11,5),(1294,11,6),(1295,11,7),(1296,11,8),(1297,11,9),(1298,12,1),(1299,12,2),(1300,12,4),(1301,12,5),(1302,12,7),(1303,12,8),(1304,12,9),(1305,12,10),(1306,13,1),(1307,13,2),(1308,13,4),(1309,13,5),(1310,13,7),(1311,13,8),(1312,13,9),(1313,13,10),(1314,14,1),(1315,14,7),(1316,14,8),(1317,14,9),(1318,15,1),(1319,15,7),(1320,15,8),(1321,15,9),(1322,16,1),(1323,16,7),(1324,16,8),(1325,16,9),(1326,17,1),(1327,17,2),(1328,17,4),(1329,17,5),(1330,17,6),(1331,17,7),(1332,17,8),(1333,17,9),(1334,18,1),(1335,18,7),(1336,18,8),(1337,18,9),(1338,19,1),(1339,19,7),(1340,19,8),(1341,19,9),(1342,20,1),(1343,20,7),(1344,20,8),(1345,20,9),(1346,21,1),(1347,21,2),(1348,21,4),(1349,21,5),(1350,21,7),(1351,21,8),(1352,21,9),(1353,22,1),(1354,22,2),(1355,22,4),(1356,22,5),(1357,22,6),(1358,22,7),(1359,22,8),(1360,22,9);

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


-- Dump completed on 2017-04-25 12:30:15

