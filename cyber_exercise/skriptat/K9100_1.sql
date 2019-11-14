-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (i386)
--
-- Host: mysql.labranet.jamk.fi    Database: K9100_1
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `manufacturers`
--

DROP TABLE IF EXISTS `manufacturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manufacturers` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`manufacturer_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `manufacturers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manufacturers`
--

LOCK TABLES `manufacturers` WRITE;
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;
INSERT INTO `manufacturers` VALUES (1,'Valve',20),(2,'Activision',21),(3,'Jagex',22),(4,'Blizzard',23),(5,'Riot Games',25),(6,'ThinMatrix',30);
/*!40000 ALTER TABLE `manufacturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `rating` float DEFAULT NULL,
  `date` char(10) DEFAULT NULL,
  `ratings_amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (3,'Rick and Morty T-paita','Vaate','Guess',199.98,1.33333,'2018-03-02',3),(6,'Rick and Morty kahvikuppi','Oheistuote','Iittala',18.9,4.33333,'2018-03-03',3),(9,'Rick and Morty kastelukannu','Oheistuote','Ruohola',11.1,2,'2018-10-10',3),(11,'Star Wars kahvikuppi','Oheistuote','Iittala',18.9,3,'2018-04-03',4),(13,'Homer paita','Vaate','Jack & Jones',13.99,2.66667,'2019-03-13',3),(28,'Game of Thrones alushousut','Vaate','Guess',289,4.28571,'2019-03-30',7),(39,'Astianpesukone','Kodinkone','Bosch',325,2.33333,'2018-03-06',3),(40,'Rahanpesukone','Kodinkone','Bosch',1337,4.5,'2013-08-02',2),(41,'IlmalÃ¤mpÃ¶pumppu','Pumppu','L-Tuotanto',420.99,5,'2019-10-31',2),(48,'Tiskikone','Kodinkone','Husqvarna',552.99,1,'2019-04-18',1),(49,'Yleiskone','Kodinkone','Husqvarna',2623.99,0,'2019-03-22',0),(50,'Pesukone','Kodinkone','Husqvarna',1814.99,2,'2019-06-19',1),(51,'Tietokone','Kodinkone','Husqvarna',1825.99,5,'2019-05-14',1),(52,'Tuuletuskone','Kodinkone','Husqvarna',2717.99,0,'2019-03-23',0),(53,'Istutuslaite','Kodinkone','UPO',2430.99,1,'2017-09-26',1),(54,'Tuuletuslaite','Kodinkone','UPO',2621.99,0,'2017-06-14',0),(55,'Ihmelaite','Kodinkone','UPO',688.99,4.33333,'2017-07-14',3),(56,'Kissan hiekkalaatikko','Hiekkalaatikko','Kissaloodat.fi',490,5,'2016-06-22',1),(57,'SÃ¤hkÃ¶vatkain','Kodinkone','GL',2342,0,'2019-03-15',0),(58,'Koiranulkoiluttaja','Lapsi','Electrolax',1286,0,'2019-09-10',0),(59,'Kuivausrumpu','Kodinkone','AEG',1085,0,'2019-06-18',0),(61,'RoiskelÃ¤ppÃ¤','Kodinkone','Electrolax',741,0,'2019-04-11',0),(62,'Munankeitin','Kodinkone','AEG',2515,0,'2019-05-20',0),(64,'HÃ¶yrykaappi','Kodinkone','Sumsang',2493,1,'2019-01-25',1),(76,'SÃ¤hkÃ¶vempain','Vempain','Pertti',9001,5,'1896-03-08',2);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userLibrary`
--

DROP TABLE IF EXISTS `userLibrary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userLibrary` (
  `owner_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_name` varchar(255) DEFAULT NULL,
  `fk_user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT '0',
  `add_date` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`owner_id`),
  KEY `fk_user_id` (`fk_user_id`),
  CONSTRAINT `userLibrary_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userLibrary`
--

LOCK TABLES `userLibrary` WRITE;
/*!40000 ALTER TABLE `userLibrary` DISABLE KEYS */;
INSERT INTO `userLibrary` VALUES (196,'Star Wars kahvikuppi',1,4,'2019-10-29'),(197,'Star Wars kahvikuppi',1,4,'2019-10-29'),(198,'Rahanpesukone',1,5,'2019-10-29'),(199,'Homer paita',16,0,'2019-10-31'),(200,'Astianpesukone',16,0,'2019-10-31'),(201,'Rick and Morty T-paita',16,0,'2019-10-28'),(202,'Rick and Morty kastelukannu',16,0,'2019-10-28'),(203,'Rick and Morty kastelukannu',16,0,'2019-10-28'),(204,'Rick and Morty kastelukannu',16,0,'2019-10-28'),(205,'Astianpesukone',1,2,'2019-10-31'),(206,'Astianpesukone',1,2,'2019-10-31'),(207,'Rick and Morty T-paita',1,1,'2019-10-28'),(208,'Rick and Morty kastelukannu',1,3,'2019-10-28'),(209,'Astianpesukone',1,2,'2019-10-31'),(210,'Game of Thrones alushousut',1,3,'2019-10-31'),(211,'Homer paita',1,1,'2019-10-31'),(212,'Rahanpesukone',1,5,'2019-10-31'),(213,'Rick and Morty kahvikuppi',1,4,'2019-10-28'),(214,'Rick and Morty kastelukannu',1,3,'2019-10-28'),(215,'Rick and Morty T-paita',1,1,'2019-10-28'),(216,'Star Wars kahvikuppi',1,4,'2019-10-31'),(217,'Star Wars kahvikuppi',1,4,'2019-10-31'),(218,'Star Wars kahvikuppi',1,4,'2019-10-31'),(219,'Rick and Morty T-paita',1,1,'2019-10-28'),(220,'Rick and Morty kastelukannu',1,3,'2019-10-28'),(221,'Rick and Morty kahvikuppi',1,4,'2019-10-28'),(222,'Rahanpesukone',1,5,'2019-10-31'),(223,'Homer paita',1,1,'2019-10-31'),(224,'Game of Thrones alushousut',1,3,'2019-10-31'),(225,'Ihmelaite',18,5,'2019-11-02'),(226,'Ihmelaite',18,5,'2019-11-02'),(227,'IlmalÃ¤mpÃ¶pumppu',18,5,'2019-11-02'),(228,'IlmalÃ¤mpÃ¶pumppu',18,5,'2019-11-02'),(229,'Istutuslaite',18,1,'2019-11-02'),(230,'Pesukone',18,2,'2019-11-02'),(231,'Tietokone',18,5,'2019-11-02'),(232,'Star Wars kahvikuppi',18,3,'2019-11-02'),(233,'Star Wars kahvikuppi',18,3,'2019-11-02'),(234,'Tiskikone',18,1,'2019-11-02'),(235,'Tiskikone',18,1,'2019-11-02'),(236,'SÃ¤hkÃ¶vempain',1,5,'2019-11-03'),(237,'Kissan hiekkalaatikko',11,5,'2019-11-03'),(238,'Ihmelaite',11,4,'2019-11-03'),(239,'Game of Thrones alushousut',11,4,'2019-11-03'),(240,'Astianpesukone',11,3,'2019-11-03'),(241,'HÃ¶yrykaappi',11,1,'2019-11-03'),(242,'SÃ¤hkÃ¶vempain',11,5,'2019-11-03'),(243,'Astianpesukone',3,2,'2019-11-03'),(244,'IlmalÃ¤mpÃ¶pumppu',3,5,'2019-11-03'),(245,'Ihmelaite',3,4,'2019-11-03'),(246,'Rahanpesukone',3,4,'2019-11-03'),(247,'Game of Thrones alushousut',4,5,'2019-11-03'),(248,'Game of Thrones alushousut',24,5,'2019-11-03'),(249,'Game of Thrones alushousut',8,4,'2019-11-03');
/*!40000 ALTER TABLE `userLibrary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `bday` char(10) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `post` char(5) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `balance` float NOT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `passwd` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Pveli','Teemu','PÃ¤tsi','1996-03-08','','40520','FI',573679,1,'h\nÔ–.üá\Z|ÕR¿˜8zd'),(2,'Aasiakas','Aasi','Aasinpoika','2000-03-08','Aasikuja 2','40520','FI',1232.21,0,'ZXr¼\'¦Äì‡£bà'),(3,'Agimbo','Aki','Rahikkala','1997-10-04','','','FI',3,0,'–Õ¤úy63Ü¸j†\r?J\n.'),(4,'Spyrde','Pyry','Koskela','1996-06-15','','','',9293.02,0,'ƒÙuùOP·ªÍïgC¯?Ã'),(6,'Iins','Iina','Thomsson','1998-02-16','','','',300.01,0,'úv»|=È÷í;w9-4\r'),(7,'Lasikuula','Johanna','Kaasalainen','1995-09-09','','','',5055.11,0,'ŸõwÁò+Œ6¢ùoÌdzH'),(8,'Proffa','Teemu','MÃ¤kinen','1996-05-24','','','',0,0,'ÂwÐ‰7²÷Éžm¸Á†“'),(9,'IskÃ¤','Risto','PÃ¤tsi','1966-01-07','','','',56.45,0,'ŸõwÁò+Œ6¢ùoÌdzH'),(10,'Sari','Sari','PÃ¤tsi','8.1.1969','PenttilÃ¤nraitti 21','40950','FI',1,0,'ç€\'Ûfü?¦éÏ†é!¤€'),(11,'Ragu','Riku','Kaunisto','1988-12-25','','','',119.56,0,'kebab'),(13,'Aasiakas2','Aasi','AasintyttÃ¶','2008-08-08','','','',170.11,0,'ZXr¼\'¦Äì‡£bà'),(14,'Aasiakas1','Aasi','Aasingrilli','2009-09-09','','','',2531.65,0,'ZXr¼\'¦Äì‡£bà'),(16,'test','Testaaja','Testaaja','1997-10-04','','','',130.4,0,'š4‘àPÆÛ–Üi)à–Ô'),(17,'PekkaTÃ¶pis','Pekka','TÃ¶pÃ¶hÃ¤ntÃ¤','2011-01-01','Kissakuja 123','','SE',956,0,'Ñ7GßOåxôPØó+'),(18,'Kaneli','Pulla','Poski','2019-03-11','','','',64.29,0,'•¥\0T¿Ô¤CãU3Æ§á'),(19,'Kylis','Ville','KylÃ¤mies','1995-08-27','','','',435.69,0,'†°Ñ çjÏ¸Ùx—J'),(20,'Valve','Gabe','Newell','1962-11-03','','','US',9999,0,'@äÊr§¥„‹¶6\nØ\nï'),(21,'Activision','Robert','Kotick','1963-12-23','','','US',0,0,'ÙÒõÛâ¦8[É$q›'),(22,'Jagex','God Ash','Mod','1982-09-30','','','GB',0,0,'ôAª†wÔ_®{{îO	'),(23,'Blizzard','Michael','Morhaime','1972-10-29','','','US',0,0,'‘Fy–xÓ~¡¦ ³PÁæp'),(24,'Ilvesmuki','Lassi','IlvesmÃ¤ki','2000-12-08','','','',89043.1,0,'\0C®êù¸í­–ð)Ð¾Ä'),(25,'Riot Games','Riot','Lol','2000-09-14','','','US',0,0,'Är7­: §ZáJÁ\0'),(30,'ThinMatrix','Karl','Dev','1993-01-31','','','US',0,0,'ª«éø0œ[SC‚â¥8µ/'),(31,'St3fa','Leevi','Tuikka','1995-08-08','','','',5.31332e+07,0,'…K,<N5Sû9ŒÛÊÑ¿™Ë'),(33,'kalle','Kalle','Kallenpoika','1994-11-23','','','',0,0,'yù›€Ó.Â€¦x&h†_');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-08 12:59:33
