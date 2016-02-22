-- MySQL dump 10.13  Distrib 5.6.19, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: currents_store
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
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permissions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `controller_name` varchar(100) NOT NULL,
  `page_name` varchar(100) NOT NULL,
  `permission_type` int(1) DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT INTO `user_permissions` VALUES (1,'products','index',1,1),(2,'products','getAllProducts',1,1),(3,'empdashboard','index',1,1),(4,'customers','index',1,1),(5,'customers','getAllCustomerLeads',1,1),(6,'customers','getStoreByRegionId',1,1),(7,'customers','getEmployeesByStoreId',1,1),(11,'customers','index',1,2),(12,'customers','getAllCustomerLeads',1,2),(13,'customers','getStoreByRegionId',1,2),(14,'customers','getEmployeesByStoreId',1,2),(16,'customers','getAllCustomerLeads',1,3),(17,'customers','index',1,3),(19,'dashboard','storeWiseLead',1,1),(20,'dashboard','getAllCustomerLeads',1,1),(21,'dashboard','employeeWiseLead',1,1),(22,'dashboard','getAllEmployees',1,1),(23,'dashboard','storeWiseDemoView',1,1),(24,'dashboard','getAllStoreDemo',1,1),(25,'dashboard','employeeWiseDemoView',1,1),(26,'dashboard','getAllEmployeeDemo',1,1),(27,'dashboard','storeWiseSourceView',1,1),(28,'dashboard','getAllStoreSource',1,1),(29,'customers','add',1,1),(30,'customers','getSubCategories',1,1),(31,'customers','getCategoryProducts',1,1),(32,'customers','history',1,1),(33,'categories','index',1,1),(34,'categories','getAllCategories',1,1),(35,'dashboard','index',1,1),(36,'customers','add',1,2),(37,'customers','getSubCategories',1,2),(38,'customers','getCategoryProducts',1,2),(39,'customers','history',1,2),(41,'customers','getSubCategories',1,3),(42,'customers','getCategoryProducts',1,3),(43,'customers','history',1,3),(45,'dashboard','index',1,2),(46,'customers','add',1,3),(47,'customers','index',1,4),(48,'customers','getAllCustomerLeads',1,4),(49,'customers','add',1,4),(50,'customers','history',1,4),(51,'customers','getSubCategories',1,4),(52,'customers','getCategoryProducts',1,4),(53,'customers','index',1,5),(54,'customers','getAllCustomerLeads',1,5),(55,'customers','add',1,5),(56,'customers','history',1,5),(57,'customers','getSubCategories',1,5),(58,'customers','getCategoryProducts',1,5),(59,'employee','index',1,1),(60,'employee','getAllEmployees',1,1),(61,'employee','getStoreByRegionId',1,1),(62,'employee','add',1,1),(63,'employee','getStoreByRegionId',1,1),(64,'employee','update',1,1),(65,'employee','getEmployeeDetails',1,1),(66,'employee','history',1,1),(67,'employee','getStatusChange',1,1),(68,'employee','passwordChange',1,1),(69,'dashboard','getDetails',1,1),(70,'products','index',1,4),(71,'products','getAllProducts',1,4),(72,'empdashboard','index',1,4),(73,'customers','index',1,4),(74,'customers','getAllCustomerLeads',1,4),(75,'customers','getStoreByRegionId',1,4),(76,'customers','getEmployeesByStoreId',1,4),(77,'dashboard','storeWiseLead',1,4),(78,'dashboard','getAllCustomerLeads',1,4),(79,'dashboard','employeeWiseLead',1,4),(80,'dashboard','getAllEmployees',1,4),(81,'dashboard','storeWiseDemoView',1,4),(82,'dashboard','getAllStoreDemo',1,4),(83,'dashboard','employeeWiseDemoView',1,4),(84,'dashboard','getAllEmployeeDemo',1,4),(85,'dashboard','storeWiseSourceView',1,4),(86,'dashboard','getAllStoreSource',1,4),(87,'customers','add',1,4),(88,'customers','getSubCategories',1,4),(89,'customers','getCategoryProducts',1,4),(90,'customers','history',1,4),(91,'categories','index',1,4),(92,'categories','getAllCategories',1,4),(93,'dashboard','index',1,4),(94,'dashboard','getDetails',1,4),(95,'employee','getEmployee',1,1),(96,'builtin','index',1,1),(97,'builtin','FileUpload',1,1),(98,'builtin','deleteFile',1,1),(99,'builtin','dailyUpdates',1,1),(100,'builtin','dailyUpdates',1,4),(101,'builtin','dailyUpdates',1,3),(102,'builtin','dailyUpdates',1,2),(103,'dashboard','storeDashboard',1,2),(104,'dashboard','regionWise',1,2),(105,'products','add',1,1),(106,'products','edit',1,1),(107,'categories','add',1,1),(108,'categories','edit',1,1),(109,'dashboard','storeWiseDemoView',1,2),(110,'dashboard','getAllStoreDemo',1,2),(111,'dashboard','employeeWiseDemoView',1,2),(112,'dashboard','getAllEmployeeDemo',1,2),(113,'dashboard','storeWiseSourceView',1,2),(114,'dashboard','getAllStoreSource',1,2),(115,'dashboard','storeWiseLead',1,2),(116,'dashboard','getAllCustomerLeads',1,2),(117,'dashboard','employeeWiseLead',1,2),(118,'dashboard','getAllEmployees',1,2),(119,'dashboard','employeeWiseLead',1,2),(120,'customers','updateCustomerDetailsByAdmin',1,1);
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-15 17:34:30
