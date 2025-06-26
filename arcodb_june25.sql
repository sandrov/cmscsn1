-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: dbod-csn1cmsdb.cern.ch    Database: cmsph2
-- ------------------------------------------------------
-- Server version	8.4.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Anagrafica`
--

DROP TABLE IF EXISTS `Anagrafica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Anagrafica` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Cognome` varchar(255) DEFAULT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Percentuale_CMS` int DEFAULT NULL,
  `SiglaSiner1` varchar(64) DEFAULT NULL,
  `Percentuale_Sin1` int DEFAULT NULL,
  `SiglaSiner2` varchar(64) DEFAULT NULL,
  `Percentuale_Sin2` int DEFAULT NULL,
  `SiglaSiner3` varchar(64) DEFAULT NULL,
  `Percentuale_Sin3` int DEFAULT NULL,
  `sigla` varchar(64) DEFAULT NULL,
  `anno` int DEFAULT NULL,
  `id_person` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_person` (`id_person`),
  CONSTRAINT `Anagrafica_ibfk_1` FOREIGN KEY (`id_person`) REFERENCES `Persone` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1883 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Assegnazioni`
--

DROP TABLE IF EXISTS `Assegnazioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Assegnazioni` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_richiesta` int NOT NULL,
  `anno` int NOT NULL,
  `riunione` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `keur` decimal(11,1) NOT NULL,
  `commenti` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `copertura` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_richiesta` (`id_richiesta`),
  CONSTRAINT `Assegnazioni_ibfk_1` FOREIGN KEY (`id_richiesta`) REFERENCES `Richieste` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Persone`
--

DROP TABLE IF EXISTS `Persone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Persone` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Cognome` varchar(255) DEFAULT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `sez` varchar(32) DEFAULT NULL,
  `Profilo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UC_Person` (`Cognome`,`Nome`)
) ENGINE=InnoDB AUTO_INCREMENT=607 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Responsabilities`
--

DROP TABLE IF EXISTS `Responsabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Responsabilities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_person` int NOT NULL,
  `anno` int DEFAULT NULL,
  `lvl` varchar(32) DEFAULT NULL,
  `progetto` varchar(64) DEFAULT NULL,
  `ruolo` varchar(255) DEFAULT NULL,
  `coconv` tinyint(1) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `note` varchar(1024) DEFAULT NULL,
  `id_richiesta` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_person` (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Richieste`
--

DROP TABLE IF EXISTS `Richieste`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Richieste` (
  `id` int NOT NULL AUTO_INCREMENT,
  `anno` int NOT NULL,
  `sez` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `capitolo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `WBS` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `richiesta` text COLLATE utf8mb4_general_ci NOT NULL,
  `note` text COLLATE utf8mb4_general_ci,
  `keur` decimal(11,1) DEFAULT NULL,
  `keurSJ` decimal(11,1) DEFAULT NULL,
  `inserimento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sigla` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rn` tinyint(1) DEFAULT NULL,
  `todb` tinyint(1) DEFAULT NULL,
  `rl` tinyint(1) DEFAULT NULL,
  `ra` tinyint(1) DEFAULT NULL,
  `aggio` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1039 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `an2rich`
--

DROP TABLE IF EXISTS `an2rich`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `an2rich` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sez` varchar(64) NOT NULL,
  `tag` varchar(64) NOT NULL,
  `anno` int NOT NULL,
  `id_rich` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `docs`
--

DROP TABLE IF EXISTS `docs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_richiesta` int DEFAULT NULL,
  `documentazione` mediumtext COLLATE utf8mb4_general_ci,
  `folder` varchar(1024) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=727 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `siglesin`
--

DROP TABLE IF EXISTS `siglesin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `siglesin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sigla` varchar(64) DEFAULT NULL,
  `csn` int DEFAULT NULL,
  `note` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-27  0:14:05
