-- MySQL dump 10.13  Distrib 5.6.24, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: photo_op
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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Nature',1),(2,'Animals',1),(3,'Cultural Events',1),(4,'Sports',1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comments` varchar(45) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_event1_idx` (`event_id`),
  CONSTRAINT `fk_comments_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'test comment','1',1,6),(2,'comment test','1',1,6),(3,'good','1',1,2),(4,'dsfdsf','1',1,3),(5,'sadad','1',1,3),(6,'sdfdsf','1',1,3),(7,'test comment','1',1,3),(8,'ttttttttt','1',1,3),(9,'sdfsdf','1',1,7),(10,'sdsfsdsdfsd','1',1,7),(11,'test2','1',1,5),(12,'test3','1',1,5),(13,'test4','1',1,5),(14,'test5','1',1,5),(15,'scc','1',1,5),(16,'fcff','1',1,1),(17,'this is for test','1',1,1),(18,'cdsfds','1',1,1),(19,'sssssssss','1',1,1);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `address` varchar(125) DEFAULT NULL,
  `comments` text,
  `description` varchar(45) DEFAULT NULL,
  `subject` text,
  `month_id` int(11) NOT NULL,
  `seasons_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_event_category_idx` (`category_id`),
  KEY `fk_event_month1_idx` (`month_id`),
  KEY `fk_event_seasons1_idx` (`seasons_id`),
  KEY `fk_event_state1_idx` (`state_id`),
  KEY `fk_event_region1_idx` (`region_id`),
  CONSTRAINT `fk_event_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_month1` FOREIGN KEY (`month_id`) REFERENCES `month` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_region1` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_seasons1` FOREIGN KEY (`seasons_id`) REFERENCES `seasons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_state1` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,2,'0000-00-00','0000-00-00','asdasd','sadsad','sadad','1',2,1,1,2,1,'2016-02-22 17:56:15',NULL,NULL),(2,1,'0000-00-00','0000-00-00','sdsad','asdasdsa','sadasd','2',1,1,1,1,1,'2016-02-22 19:47:29',NULL,NULL),(3,2,'2016-03-02','2016-02-24','sdsada','sadsadsad','for test','sdad',1,1,1,2,1,'2016-02-23 12:18:08',NULL,NULL),(4,2,'2016-03-02','2016-02-24','sdsada','sadsadsad','for test','sdad',1,1,1,2,1,'2016-02-23 12:20:13',NULL,NULL),(5,2,'2016-02-24','2016-03-13','sdfsdfsd','sdfsdffsd','wqeqwe','sdsad',1,1,1,2,1,'2016-02-23 12:22:00',NULL,NULL),(6,1,'2016-02-24','2016-02-21','sdfsdfs','fsdfsdffsfsd','dsfsf','6',5,2,1,2,1,'2016-02-23 12:23:44',NULL,NULL),(7,1,'2016-02-03','2016-02-02','sfdsf','dsfds','sad','fdsgf',7,3,1,3,1,'2016-02-23 14:43:12',NULL,NULL);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_upload`
--

DROP TABLE IF EXISTS `file_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(128) DEFAULT NULL,
  `path` varchar(128) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_file_upload_event1_idx` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_upload`
--

LOCK TABLES `file_upload` WRITE;
/*!40000 ALTER TABLE `file_upload` DISABLE KEYS */;
INSERT INTO `file_upload` VALUES (1,'enquiryfreightvas.png','/var/www/html/photoop/public/uploads/','259',1,1,NULL,NULL),(2,'enquiry_freightvascreate.png','/var/www/html/photoop/public/uploads/','150479',1,NULL,NULL,NULL),(3,'warehouselclcreate.png','/var/www/html/photoop/public/uploads/','73088',1,NULL,NULL,NULL),(4,'glyphicons-halflings.png','/var/www/html/photoop/public/uploads/','4352',1,10,'',1),(5,'Trivalent-Brand-Identity-01.png','/var/www/html/photoop/public/uploads/','240811',1,10,'',1),(6,'Paper-Hot-Cup-Mock-Up-vol-2-400x400.jpg','/var/www/html/photoop/public/uploads/','16205',1,10,'',1),(7,'warehouselclcreate.png','/var/www/html/photoop/public/uploads/','73088',1,3,'',1),(8,'purchaseresult.png','/var/www/html/photoop/public/uploads/','63096',1,3,'',1),(9,'purchase2.png','/var/www/html/photoop/public/uploads/','151444',1,3,'',1),(10,'sales1.png','/var/www/html/photoop/public/uploads/','147735',1,5,'',1),(11,'sales.png','/var/www/html/photoop/public/uploads/','50307',1,5,'',1),(12,'purchaseresult.png','/var/www/html/photoop/public/uploads/','63096',1,5,'',1),(13,'fvaseditresult1.png','/var/www/html/photoop/public/uploads/','167810',1,6,'',1),(14,'fvaseditresult.png','/var/www/html/photoop/public/uploads/','118943',1,6,'',1),(15,'fvaseditresult.png','/var/www/html/photoop/public/uploads/','118943',1,7,'',1),(16,'fvasedit.png','/var/www/html/photoop/public/uploads/','162513',1,7,'',1),(17,'fvaseditresult.png','/var/www/html/photoop/public/uploads/','118943',1,7,'',1);
/*!40000 ALTER TABLE `file_upload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(125) DEFAULT NULL,
  `salt` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone_number` varchar(45) DEFAULT NULL,
  `last_login` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'admin','3471e24769392e4f1fb35a4d4f4c44aa6acad82f8ee98818d88e9c948c6e9306','824','priyanka@rootsbridge.com','7639637109','jhu',1),(2,'priyanka','096f1d6a9b2c4015e5c3bfc666c259e91bbca8f4a4a92008231aa65e6b735c84','988','priyanka@gmail.com',NULL,'2016-02-23 09:38:39',1),(3,'priyanka','d8edbbbc1e7a7aebfe09f4bde9bd13df36e5959940f3dafc89b18289e44b81bb','a89','priyanka@gmail.com',NULL,'2016-02-23 09:38:46',1),(4,'priyam','e577cc99d04fad83d4c298c2bfa76d3474257507550cb45de931ca42812ab660','f17','priyanka@gmail.com',NULL,'2016-02-23 09:40:12',1),(5,'testuser','ffa52ef4765df4a3260afdb641aba5bf92103eddd2a959a9827eae3c6b78f3ab','b51','testuser@gmail.com',NULL,'2016-02-23 09:42:28',1),(6,'sadasd','4f179b005c6ad0ce2fabb3a8e541c81753ddbe42825f90141b1588f09ba46974','261','qweqwe',NULL,'2016-02-23 09:43:15',1);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `month`
--

DROP TABLE IF EXISTS `month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `seasons_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_month_seasons1_idx` (`seasons_id`),
  CONSTRAINT `fk_month_seasons1` FOREIGN KEY (`seasons_id`) REFERENCES `seasons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `month`
--

LOCK TABLES `month` WRITE;
/*!40000 ALTER TABLE `month` DISABLE KEYS */;
INSERT INTO `month` VALUES (1,'September',1,1),(2,'October',1,1),(3,'November',1,1),(4,'December',1,2),(5,'January',1,2),(6,'February',1,2),(7,'March',1,3),(8,'April',1,3),(9,'may',1,3),(10,'June',1,4),(11,'July',1,4),(12,'August',1,4);
/*!40000 ALTER TABLE `month` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_region_state1_idx` (`state_id`),
  CONSTRAINT `fk_region_state1` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES (1,'Canberra','1',1),(2,'Williamsdale','1',1),(3,'Naas','1',1),(4,'Uriarra','1',1),(5,'Tharwa','1',1);
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seasons`
--

DROP TABLE IF EXISTS `seasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seasons` (
  `id` int(11) NOT NULL,
  `season_name` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seasons`
--

LOCK TABLES `seasons` WRITE;
/*!40000 ALTER TABLE `seasons` DISABLE KEYS */;
INSERT INTO `seasons` VALUES (1,'Spring',1),(2,'Summer',1),(3,'Autumn',1),(4,'Winter',1);
/*!40000 ALTER TABLE `seasons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state`
--

LOCK TABLES `state` WRITE;
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
INSERT INTO `state` VALUES (1,'Australian Capital Territory','1'),(2,'New South Wales','1'),(3,'Victoria','1'),(4,'Queensland','1'),(5,'South Australia','1'),(6,'Western Australia','1'),(7,'Tasmania','1'),(8,'Northern Territory','1');
/*!40000 ALTER TABLE `state` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-23 14:54:15
