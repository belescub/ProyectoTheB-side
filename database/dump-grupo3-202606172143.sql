/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: grupo3
-- ------------------------------------------------------
-- Server version	12.2.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES
(1,'CDS',NULL,1,'2026-06-16 20:31:11','2026-06-16 20:31:11'),
(2,'EP',NULL,1,'2026-06-17 01:41:50','2026-06-17 01:41:50'),
(3,'VINILOS',NULL,1,'2026-06-17 01:45:54','2026-06-17 01:45:54'),
(4,'REPRODUCTORES',NULL,1,'2026-06-17 01:51:57','2026-06-17 01:51:57'),
(5,'ACCESORIOS',NULL,1,'2026-06-17 01:59:38','2026-06-17 01:59:38');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultas`
--

DROP TABLE IF EXISTS `consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `respuesta` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
INSERT INTO `consultas` VALUES
(1,'micaela','3794112233','micaela@gmail.com','prueba 1',0,NULL,'2026-06-17 02:06:41','2026-06-17 02:06:41',NULL),
(2,'Ingrid','3794112233','ingrid@gmail.com','prueba 2',1,'confirmado','2026-06-17 22:06:26','2026-06-17 22:09:25',NULL);
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_05_20_180005_create_rols_table',1),
(5,'2026_05_20_180044_create_usuarios_table',1),
(6,'2026_05_31_140000_create_categorias_table',1),
(7,'2026_05_31_143025_create_productos_table',1),
(8,'2026_06_02_130000_create_venta_cabeceras_table',1),
(9,'2026_06_02_135529_create_venta_detalles_table',1),
(10,'2026_06_14_205110_create_consultas_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(8,2) NOT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `url_imagen` varchar(255) DEFAULT NULL,
  `categoria_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productos_categoria_id_foreign` (`categoria_id`),
  CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES
(1,'1989 - Taylor Swift','Cd Taylor Swift 1989',20000.00,3,1,'productos/dNiTFH9zZo4TnCtxteVvKBZXFF3fMs997cvJla9a.jpg',1,'2026-06-16 20:31:12','2026-06-18 02:50:30',NULL),
(2,'After Hours - The Weeknd','CD After Hours - The Weeknd',20000.00,4,1,'productos/6ZWzSTRgicmQEE48DpgJ1jd3yZbr4ectxQB9N0Ql.jpg',1,'2026-06-17 01:34:59','2026-06-17 22:04:25',NULL),
(3,'Positions - Ariana Grande','CD Positions - Ariana Grande',20000.00,6,1,'productos/jaxdubr4vVylLPQKsNrrFDl9CQ51NeaN7VIblP3s.jpg',1,'2026-06-17 01:36:12','2026-06-17 01:36:12',NULL),
(4,'Purpose - Justin Bieber','CD Purpose - Justin Bieber',20000.00,9,1,'productos/ddnInJCSh9XhKKdUOSd4lUlouAhFKchNSQmRnXnw.jpg',1,'2026-06-17 01:37:22','2026-06-17 01:37:22',NULL),
(5,'Arirang - BTS','CD Arirang - BTS',31000.00,4,1,'productos/aXq3Y5DcZBZeTDYCFYTQzQB6eRVuOBB7YTXqNBJw.jpg',1,'2026-06-17 01:38:29','2026-06-17 01:38:29',NULL),
(6,'Born Pink - Blackpink','CD \"Born Pink\" - BLACKPINK',30000.00,3,1,'productos/ctwibJIJNgDVQHtk0cz9BUbMWX8xfluQbkpNPK1N.jpg',1,'2026-06-17 01:39:36','2026-06-17 01:39:36',NULL),
(7,'The World - Ateez','EP - The World - Ateez',15000.00,10,1,'productos/yBO82jZ1cUhyAAm4OlnT3Bvtir6hk0dltBAUgqt9.jpg',2,'2026-06-17 01:41:50','2026-06-17 01:41:50',NULL),
(8,'Maxident - SKZ','CD - Maxident - Stray Kids',25000.00,5,1,'productos/1xA0c62V5TsRbSXZjWY5xCiV5S8lSsZjdcRv2FKr.jpg',1,'2026-06-17 01:43:01','2026-06-17 01:43:01',NULL),
(9,'Sheet Heart Attack - QUEEN','VINILO - Sheet Heart Attack - QUEEN',50000.00,5,1,'productos/LDxN035vPtvbyIjlhddGrErXG8neWUrrYgLvj9J8.jpg',3,'2026-06-17 01:45:54','2026-06-17 01:45:54',NULL),
(10,'Short n\' Sweet - Sabrina Carpenter','VINILO - Short n\' Sweet - Sabrina Carpenter',45000.00,6,1,'productos/96gppkE6N4ZNw34wvaQdRvFBBtglIMszzXlNzy33.jpg',3,'2026-06-17 01:46:48','2026-06-17 01:46:48',NULL),
(11,'Songs About Jane - Maroon 5','VINILO - Songs About Jane - Maroon 5',40000.00,0,1,'productos/DLjUnPckZ0Yv7MZaEIXIQJ4WersTWRIL3Qo1kgdR.jpg',3,'2026-06-17 01:47:32','2026-06-18 00:39:36',NULL),
(12,'Abbey Road - The Beatles','VINILO - Abbey Road - The Beatles',55000.00,4,1,'productos/N0gnqhODSq4XdMsePjTHQ3t69xMcnvjyNZ0utuQx.jpg',3,'2026-06-17 01:48:27','2026-06-17 01:48:27',NULL),
(13,'Hit me hard and soft -  Billie Eilish','VINILO - Hit me hard and soft -  Billie Eilish',40000.00,10,1,'productos/AdmRTO2JRh0qUTq7bbOnPwQJslCcEDHhyPwdQWKz.jpg',3,'2026-06-17 01:49:11','2026-06-17 01:49:11',NULL),
(14,'Mp4','REPRODUCTOR - mp4 negro',19500.00,20,1,'productos/ryXg0Pwxdh2mt3zG2JeWjpAhlUTO9qAbLAq9tPcs.jpg',4,'2026-06-17 01:51:57','2026-06-17 01:51:57',NULL),
(15,'Tocadiscos','REPRODUCTOR - Tocadiscos - Celeste',317000.00,25,1,'productos/Zm2mNlflV4AlLl4qkHICmEu7ahjaIL6QmMh9xWVb.jpg',4,'2026-06-17 01:53:33','2026-06-17 01:53:33',NULL),
(16,'Kickback Retradisc','REPRODUCTOR - Kickback Retradisc + Auriculares',100000.00,5,1,'productos/PSG5OJNCUVRWDVEAnOmWMIK9LJiqKjQRDO5gFnAI.jpg',4,'2026-06-17 01:55:35','2026-06-17 01:55:35',NULL),
(17,'Reproductor de Cds Portatil','REPRODUCTOR - Cds Portatil negro',72000.00,15,1,'productos/GCCDihreILM8CVeGFcYp21fhEDMPl6MSn2zIJznY.jpg',4,'2026-06-17 01:58:03','2026-06-17 01:58:03',NULL),
(18,'Kit de Limpieza de Vinilos 4 en 1','ACCESORIO - Kit de Limpieza de Vinilos 4 en 1',29800.00,20,1,'productos/KaSBQ0NugLr33fAEUTgS2htan81dl1QPpUnw8Api.jpg',5,'2026-06-17 01:59:38','2026-06-17 01:59:38',NULL),
(19,'Parlante JBL chico','ACCESORIO - Parlante JBL chico - morado',55000.00,20,1,'productos/ZUtqg1BArfbs8spAT8zqZ9YNXzY5d97pwxWOG070.jpg',5,'2026-06-17 02:01:56','2026-06-17 02:01:56',NULL),
(20,'Auricular','ACCESORIO - Auricular Negro Bluetooth',17000.00,15,1,'productos/PLMqDLJtoMcfCZ4wPdPG43u209QdDJooP7dCxyME.jpg',5,'2026-06-17 02:03:29','2026-06-17 02:03:29',NULL);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES
(1,'admin','Administrador del sistema','2026-06-16 19:26:13','2026-06-16 19:26:13',NULL),
(2,'cliente','Cliente del ecommerce','2026-06-16 19:26:13','2026-06-16 19:26:13',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('sAz2wIMmqjG7p4Xjpbp65RU6O95PkDLZ2jFFuB4F',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI5QkltbDQ4NmMzQ2tCN0Z4eDJDSmhRWG1GTGZoeWJ1QkdNR1ZWV2hQIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvdGhlX2JzaWRlLnRlc3QiLCJyb3V0ZSI6bnVsbH19',1781742892);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` bigint(20) unsigned NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_email_unique` (`email`),
  KEY `usuarios_rol_id_foreign` (`rol_id`),
  CONSTRAINT `usuarios_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES
(1,'belen','bel@gmail.com','$2y$12$hEyPepJyJaQ8p/JKWN3Qd.L5UnvQGbfQSFif9KX2jMygG9sBr2xfq',1,NULL,'2026-06-16 19:26:14','2026-06-16 19:26:14',NULL),
(2,'micaela','micaela@gmail.com','$2y$12$L.mPLGVAmuxRovVKu65QoOfiO2qrwaG4LPwK9ltGutgZE476txKwa',2,NULL,'2026-06-16 19:26:14','2026-06-16 19:26:14',NULL),
(3,'Juan','juan@gmail.com','$2y$12$/n7PljS6qUG31dpij4Gds.BVMRwi2RFYLjf4JooMLUKfQYyS694SG',1,NULL,'2026-06-17 21:49:38','2026-06-17 21:52:37',NULL),
(4,'Ingrid','ingrid@gmail.com','$2y$12$iDvbw8VybDb/PkGEeU5pmuiWa7wZ/OZsR4Tp7rEl/8X9gz1k18PaO',2,NULL,'2026-06-17 21:57:24','2026-06-17 21:57:24',NULL),
(5,'Valentina','valen@gmail.com','$2y$12$5EnHCh451M7eUcNNx07Ubu6vHggQ8UJowevRRRYxjgP0O5WDqgOzW',2,NULL,'2026-06-18 00:38:22','2026-06-18 00:38:22',NULL),
(6,'Sofia','sofia@gmail.com','$2y$12$y4jFKBvTpng71PKDfAHq5.u2l61BeITd058VJ44fl/Ra/YjU5sIs.',2,NULL,'2026-06-18 00:42:11','2026-06-18 02:36:58','2026-06-18 02:36:58'),
(7,'Lucas','lucas@gmail.com','$2y$12$YqWdraoZT8QsEhMoWn3r2eDTyhdL.1JzCdfydcGwAr6RWX2Porv62',2,NULL,'2026-06-18 00:43:34','2026-06-18 00:43:34',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_cabeceras`
--

DROP TABLE IF EXISTS `venta_cabeceras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta_cabeceras` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_venta` datetime DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'pendiente',
  `telefono` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(255) DEFAULT NULL,
  `metodo_pago` varchar(255) DEFAULT NULL,
  `metodo_entrega` varchar(255) DEFAULT NULL,
  `costo_envio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `venta_cabeceras_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `venta_cabeceras_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_cabeceras`
--

LOCK TABLES `venta_cabeceras` WRITE;
/*!40000 ALTER TABLE `venta_cabeceras` DISABLE KEYS */;
INSERT INTO `venta_cabeceras` VALUES
(1,69000.00,'2026-06-16 18:08:42','confirmado','3794112233','jujuy 1879','Chaco','Resistencia','3500','rapipago','envio',9000.00,2,'2026-06-16 20:27:29','2026-06-16 21:08:42',NULL),
(2,0.00,'2026-06-16 18:20:30','carrito',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,2,'2026-06-16 21:20:30','2026-06-17 21:30:43',NULL),
(3,29000.00,'2026-06-17 19:04:25','confirmado','3794112233','jujuy 1879','Chaco','Resistencia','3500','mercadopago','envio',9000.00,4,'2026-06-17 22:02:59','2026-06-17 22:04:25',NULL),
(4,120000.00,'2026-06-17 21:39:36','confirmado','3794521363','jujuy 1877','Corrientes','Corrientes','3400','tarjeta','retiro',0.00,5,'2026-06-18 00:38:55','2026-06-18 00:39:36',NULL),
(5,0.00,'2026-06-17 23:38:06','carrito',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,5,'2026-06-18 02:38:06','2026-06-18 02:38:06',NULL);
/*!40000 ALTER TABLE `venta_cabeceras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_detalles`
--

DROP TABLE IF EXISTS `venta_detalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta_detalles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `producto_id` bigint(20) unsigned NOT NULL,
  `venta_cabecera_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `venta_detalles_producto_id_foreign` (`producto_id`),
  KEY `venta_detalles_venta_cabecera_id_foreign` (`venta_cabecera_id`),
  CONSTRAINT `venta_detalles_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `venta_detalles_venta_cabecera_id_foreign` FOREIGN KEY (`venta_cabecera_id`) REFERENCES `venta_cabeceras` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_detalles`
--

LOCK TABLES `venta_detalles` WRITE;
/*!40000 ALTER TABLE `venta_detalles` DISABLE KEYS */;
INSERT INTO `venta_detalles` VALUES
(2,3,20000.00,60000.00,1,1,'2026-06-16 20:52:12','2026-06-16 21:07:46'),
(7,1,20000.00,20000.00,2,3,'2026-06-17 22:03:10','2026-06-17 22:03:10'),
(8,3,40000.00,120000.00,11,4,'2026-06-18 00:38:55','2026-06-18 00:38:55');
/*!40000 ALTER TABLE `venta_detalles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'grupo3'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-17 21:43:21
