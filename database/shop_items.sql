-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: shop
-- ------------------------------------------------------
-- Server version	5.7.14-log

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
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `ItemID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` text,
  `Price` varchar(255) DEFAULT NULL,
  `Add_Date` date DEFAULT NULL,
  `Country_Name` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Cat_ID` int(11) DEFAULT NULL,
  `Member_ID` int(11) DEFAULT NULL,
  `Approve` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`ItemID`),
  KEY `Cat_ID` (`Cat_ID`),
  KEY `Member_ID` (`Member_ID`),
  CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `items_ibfk_2` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (40,'iPhone 6','This is a new device and a well known device','1000','2017-06-28','USA',NULL,'2',NULL,15,39,0),(41,'Hp','This is an old laptop','76','2017-06-28','Poland',NULL,'3',NULL,16,37,0),(42,'LG','This is a small device ','99','2017-06-28','France',NULL,'2',NULL,16,40,0),(43,'Samsung A5','New device, you should try it','400','2017-06-28','Germany',NULL,'1',NULL,15,41,0),(44,'iPhone 7','This will be soon avaliable','1204','2017-06-28','China',NULL,'1',NULL,15,38,1),(45,'Hot Dog','Try it, it is cheap','3','2017-06-28','EU',NULL,'4',NULL,13,1,1),(46,'Flafel','this is Syrian food','2','2017-06-28','Syria',NULL,'3',NULL,13,37,1),(47,'shawarma','This is amazing food','5','2017-06-28','Syria',NULL,'2',NULL,13,37,1),(48,'Coola','Try it','2','2017-06-28','USA',NULL,'4',NULL,14,38,0),(49,'Beer','Alcohol','2.5','2017-06-28','Poland',NULL,'3',NULL,14,40,0);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-28 18:49:25
