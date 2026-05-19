-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: therock
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `configuracion_usuario`
--

DROP TABLE IF EXISTS `configuracion_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuracion_usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `notificaciones` tinyint(1) DEFAULT '1',
  `color_interfaz` varchar(30) DEFAULT 'cafe',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `configuracion_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion_usuario`
--

LOCK TABLES `configuracion_usuario` WRITE;
/*!40000 ALTER TABLE `configuracion_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `configuracion_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventario` (
  `id_insumo` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `cantidad_actual` decimal(10,2) NOT NULL,
  `unidad_medida` varchar(30) NOT NULL,
  `stock_minimo` decimal(10,2) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_caducidad` date DEFAULT NULL,
  `estado` enum('Disponible','Por caducar','Agotado','Inactivo') DEFAULT 'Disponible',
  PRIMARY KEY (`id_insumo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario`
--

LOCK TABLES `inventario` WRITE;
/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
INSERT INTO `inventario` VALUES (1,'Harina de trigo',50.00,'kg',10.00,'2026-05-18','2026-11-10','Disponible'),(2,'Azúcar refinada',30.00,'kg',8.00,'2026-05-18','2027-01-15','Disponible'),(3,'Mantequilla sin sal',15.00,'kg',5.00,'2026-05-18','2026-06-20','Disponible'),(4,'Leche entera',40.00,'litros',10.00,'2026-05-18','2026-05-28','Disponible'),(5,'Huevos',300.00,'piezas',50.00,'2026-05-18','2026-06-01','Disponible'),(6,'Chocolate amargo',20.00,'kg',5.00,'2026-05-18','2026-12-10','Disponible'),(7,'Esencia de vainilla',5.00,'litros',1.00,'2026-05-18','2027-02-01','Disponible'),(8,'Polvo para hornear',8.00,'kg',2.00,'2026-05-18','2027-03-01','Disponible'),(9,'Fresas',6.00,'kg',3.00,'2026-05-18','2026-05-22','Por caducar'),(10,'Queso crema',0.00,'kg',4.00,'2026-05-18','2026-06-15','Agotado');
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `leida` tinyint(1) DEFAULT '0',
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,1,'Stock bajo: Harina','stock',0,'2026-05-11 23:13:59');
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(150) NOT NULL,
  `descripcion` text,
  `precio_venta` decimal(10,2) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `fecha_elaboracion` datetime DEFAULT NULL,
  `dias_vida_util` int DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `estado_producto` enum('Activo','Inactivo','Temporada') DEFAULT 'Activo',
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Pastel de Chocolate Premium','Bizcocho de chocolate relleno con ganache y decorado con fresas.',450.00,'Pasteles','2026-05-18 08:00:00',5,'public/assets/img/productos/pastel_chocolate.jpg','Activo'),(2,'Pay de Limón','Base crujiente con crema de limón y merengue tostado.',280.00,'Postres','2026-05-18 09:30:00',4,'public/assets/img/productos/pay_limon.jpg','Activo'),(3,'Galletas Red Velvet','Galletas suaves con chispas de chocolate blanco.',120.00,'Galletas','2026-05-18 10:00:00',7,'public/assets/img/productos/galletas_redvelvet.jpg','Activo'),(4,'Panqué de Nuez','Panqué casero con nuez caramelizada.',180.00,'Panadería','2026-05-18 07:00:00',6,'public/assets/img/productos/panque_nuez.jpg','Activo'),(5,'Cheesecake de Fresa','Cheesecake cremoso con cobertura de fresa natural.',390.00,'Postres','2026-05-18 11:00:00',5,'public/assets/img/productos/cheesecake.jpg','Activo'),(6,'Caja de Galletas Premium','Surtido de galletas gourmet decoradas.',250.00,'Galletas','2026-05-18 12:00:00',10,'public/assets/img/productos/caja_galletas.jpg','Temporada'),(7,'Pastel Tres Leches','Pastel húmedo decorado con crema batida y frutas.',420.00,'Pasteles','2026-05-18 06:30:00',4,'public/assets/img/productos/tres_leches.jpg','Activo'),(8,'Croissant de Almendra','Croissant artesanal relleno de crema de almendra.',90.00,'Panadería','2026-05-18 05:00:00',2,'public/assets/img/productos/croissant.jpg','Activo');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes`
--

DROP TABLE IF EXISTS `solicitudes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitudes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `estado` enum('pendiente','aprobada','rechazada') DEFAULT 'pendiente',
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudes`
--

LOCK TABLES `solicitudes` WRITE;
/*!40000 ALTER TABLE `solicitudes` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitudes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'Activo',
  `rol` varchar(20) NOT NULL DEFAULT 'usuario',
  `foto_perfil` varchar(255) DEFAULT NULL,
  `color_perfil` varchar(20) DEFAULT 'blanco',
  `ultimo_acceso` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Jose Luis Cruz','JoseLuis@gmail.com','1234','Activo','admin',NULL,'blanco','2026-05-11 23:10:43'),(7,'Alberto','Alberto@gmail.com','2345','Activo','usuario',NULL,'blanco','2026-05-11 23:10:43');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'therock'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-19  1:21:23
