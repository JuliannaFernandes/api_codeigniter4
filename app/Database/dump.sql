-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: api_ci4
-- ------------------------------------------------------
-- Server version	8.4.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome_razao_social` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cpf_cnpj` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (30,'joao da silva','123456788','2025-03-02 22:09:59','2025-03-02 22:09:59'),(31,'maria souza','22209856488','2025-03-02 22:10:07','2025-03-02 22:11:35'),(32,'jorge meireles','45678934577','2025-03-02 22:25:23','2025-03-02 22:25:23'),(33,'Mariana Souza','12345678901','2025-03-02 22:27:15','2025-03-02 22:27:15'),(34,'Carlos Almeida','98765432100','2025-03-02 22:27:23','2025-03-02 22:27:23'),(35,'Fernanda Castro','11223344556','2025-03-02 22:27:31','2025-03-02 22:27:31'),(36,'Roberto Lima','99887766554','2025-03-02 22:27:41','2025-03-02 22:27:41'),(37,'Tatiane Pereira','55667788990','2025-03-02 22:27:53','2025-03-02 22:27:53'),(38,'Eduardo Martins','33445566778','2025-03-02 22:28:03','2025-03-02 22:28:03'),(39,'Ana Beatriz','22334455667','2025-03-02 22:28:11','2025-03-02 22:28:11'),(40,'Gustavo Nogueira','77889900112','2025-03-02 22:28:19','2025-03-02 22:28:19');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025-02-24-212437','App\\Database\\Migrations\\Cliente','default','App',1740441855,1),(2,'2025-02-25-001340','App\\Database\\Migrations\\Produto','default','App',1740442592,2),(4,'2025-02-25-001817','App\\Database\\Migrations\\Pedido','default','App',1740454377,3),(5,'2025-03-01-191100','App\\Database\\Migrations\\Usuario','default','App',1740856681,4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` int unsigned NOT NULL,
  `produto_id` int unsigned NOT NULL,
  `quantidade` int unsigned NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `status` enum('em aberto','pago','cancelado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'em aberto',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_cliente_id_foreign` (`cliente_id`),
  KEY `pedido_produto_id_foreign` (`produto_id`),
  CONSTRAINT `pedido_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedido_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES (17,30,13,2,1000.00,'em aberto','2025-03-02 22:38:48','2025-03-02 22:38:48'),(18,31,14,1,2500.00,'em aberto','2025-03-02 22:38:58','2025-03-02 22:38:58'),(19,32,15,1,450.00,'em aberto','2025-03-02 22:39:13','2025-03-02 22:39:13'),(20,33,16,1,350.00,'em aberto','2025-03-02 22:39:23','2025-03-02 22:39:23'),(21,34,17,2,1360.00,'em aberto','2025-03-02 22:39:32','2025-03-02 22:39:32'),(22,35,18,1,1500.00,'em aberto','2025-03-02 22:39:40','2025-03-02 22:39:40'),(23,36,19,2,2400.00,'em aberto','2025-03-02 22:39:49','2025-03-02 22:39:49'),(24,37,20,1,720.00,'em aberto','2025-03-02 22:40:02','2025-03-02 22:40:02'),(25,38,21,4,1120.00,'em aberto','2025-03-02 22:40:13','2025-03-02 22:40:13'),(26,39,22,1,2800.00,'em aberto','2025-03-02 22:40:22','2025-03-02 22:40:22');
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produto` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (13,'Headset HyperX','Headset HyperX Cloud II, Surround 7.1',500.00,2,'2025-03-02 22:34:23','2025-03-03 00:46:31'),(14,'Placa de Vídeo RTX 3060','Placa de Vídeo RTX 3060 12GB, GDDR6',2500.00,0,'2025-03-02 22:34:46','2025-03-02 22:38:58'),(15,'Webcam Full HD','Webcam Logitech C920, Full HD, Autofocus',450.00,1,'2025-03-02 22:35:05','2025-03-02 22:39:13'),(16,'Teclado Mecânico','Teclado Mecânico RGB Redragon Switch Azul',350.00,4,'2025-03-02 22:35:20','2025-03-02 22:39:23'),(17,'Fonte 750W','Fonte Corsair 750W 80 Plus Gold Modular',680.00,0,'2025-03-02 22:35:39','2025-03-02 22:39:32'),(18,'Cadeira Gamer','Cadeira Gamer Reclinável, Couro Sintético',1500.00,0,'2025-03-02 22:35:51','2025-03-02 22:39:40'),(19,'Monitor LG','Monitor LG UltraWide, 29&#039;, Full HD',1200.00,1,'2025-03-02 22:36:03','2025-03-02 22:39:49'),(20,'SSD NVMe 1TB','SSD NVMe Kingston 1TB, 3500MB/s',720.00,2,'2025-03-02 22:36:18','2025-03-02 22:40:02'),(21,'Mouse Gamer','Mouse Gamer Logitech G502, 25.600 DPI',280.00,0,'2025-03-02 22:36:34','2025-03-02 22:40:13'),(22,'Smartphone Samsung','Samsung Galaxy S21, 128GB, Tela AMOLED',2800.00,0,'2025-03-02 22:36:44','2025-03-02 22:40:22'),(24,'Headseat preto','Som alto',340.00,15,'2025-03-03 00:42:21','2025-03-03 00:48:00');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (6,'felipe@email.com','$2y$10$b80DVBSybGpoDJotRCTx/uzJxiicSDxcvyFm3eVeAvhYR6o5O3Qgi','2025-03-03 01:10:43','2025-03-03 01:10:43'),(7,'julianna@email.com','$2y$10$ObvnPhhjXOzudUbVNkGYROx//7P7LByy8z7rhG844fMIfyQbwxAcG','2025-03-03 01:46:29','2025-03-03 01:46:29'),(8,'joaozinho@email.com','$2y$10$pQNiV4.fv2COZwlidk3ZpOr4Y1b9vW8OTh4OsipokFH.YTV3lWwAm','2025-03-03 03:31:17','2025-03-03 03:31:17'),(10,'juliannafernandes@email.com','$2y$10$jNNFzIIhoRlQzdZdANVQyeIbEfrsLn3KQR4vfliHA9AiKF.rBt7nK','2025-03-03 03:34:31','2025-03-03 03:34:31'),(12,'testeemail@email.com','$2y$10$l9JfHtdBt6K7ph0CHJ2WzugQs9FO5g3DXiQcXDafe8kkOqbg/eCwm','2025-03-03 04:04:37','2025-03-03 04:04:37');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-02 22:48:15
