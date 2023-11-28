
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
DROP TABLE IF EXISTS `card_phrases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `card_phrases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `card_id` bigint unsigned NOT NULL,
  `phrase` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `card_phrases_card_id_foreign` (`card_id`),
  CONSTRAINT `card_phrases_card_id_foreign` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `card_phrases` WRITE;
/*!40000 ALTER TABLE `card_phrases` DISABLE KEYS */;
INSERT INTO `card_phrases` VALUES (1,1,'1','2023-11-07 00:36:15','2023-11-07 00:36:15'),(2,1,'2','2023-11-07 00:36:15','2023-11-07 00:36:15'),(3,41,'3','2023-11-07 00:38:18','2023-11-07 00:38:18'),(4,41,'4','2023-11-07 00:38:18','2023-11-07 00:38:18');
/*!40000 ALTER TABLE `card_phrases` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `deck_id` bigint unsigned NOT NULL,
  `front` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `back` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_level` int NOT NULL DEFAULT '1',
  `last_reviewed_date` date DEFAULT NULL,
  `next_review_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cards_deck_id_foreign` (`deck_id`),
  CONSTRAINT `cards_deck_id_foreign` FOREIGN KEY (`deck_id`) REFERENCES `decks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` VALUES (1,1,'Flyers','Folhetos',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:51:04'),(2,1,'fence','cerca',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:51:16'),(3,1,'weren\'t','nao estavam',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:51:19'),(4,1,'held','Feito/mantido',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:51:21'),(5,1,'of the','pela',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:51:23'),(6,1,'box office','renda de bilheteira',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:51:44'),(7,1,'advertisement','anúncio',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:51:53'),(8,1,'striped','listrado',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:51:58'),(9,1,'extension cords','cabos de extensão',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:05'),(10,1,'drawer','gaveta',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:17'),(11,1,'up ahead.','à Frente.',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:23'),(12,1,'Skimming','Leitura rápida',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:32'),(13,1,'unfortunately','Infelizmente',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:35'),(14,1,'venue','local',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:39'),(15,1,'trouser','calça',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:41'),(16,1,'to sweep','varrer',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:45'),(17,1,'to lean','inclinar',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:48'),(18,1,'lid','tampa',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:52:52'),(19,1,'stool','banco',1,'2023-10-16','2023-10-17','2023-10-16 00:49:56','2023-10-16 00:53:34'),(20,1,'brick','tijolo',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:53:36'),(21,1,'to sew','costurar',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:53:39'),(22,1,'to scatter','espalhar',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:53:44'),(23,1,'to stack','empilhar',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:53:47'),(24,1,'railing','corrimão',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:53:55'),(25,1,'to mow','cortar',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:53:58'),(26,1,'lawn','grama',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:54:00'),(27,1,'grocery','mercearia',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:54:08'),(28,1,'rafting','andar de barco',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:54:12'),(29,1,'fabric','tecido',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:54:22'),(30,1,'enhance','melhorar',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:54:33'),(31,1,'freight','frete',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:54:35'),(32,1,'publicize','divulgar',2,'2023-10-16','2023-10-19','2023-10-16 00:49:56','2023-10-16 00:54:38'),(33,1,'tuition','conta',1,'2023-10-16','2023-10-17','2023-10-16 00:49:56','2023-10-16 00:54:45'),(34,1,'compliance','conformidade',1,'2023-10-16','2023-10-17','2023-10-16 00:49:56','2023-10-16 00:54:48'),(35,1,'preply','prépli',1,'2023-10-16','2023-10-17','2023-10-16 00:49:56','2023-10-16 00:54:51'),(36,1,'half','metade',1,'2023-10-16','2023-10-17','2023-10-16 00:49:56','2023-10-16 00:54:51'),(37,1,'real estate agent','corretor de imoveis',1,'2023-10-16','2023-10-17','2023-10-16 00:49:56','2023-10-16 00:54:57'),(38,1,'real estate','imobiliaria',1,'2023-10-16','2023-10-17','2023-10-16 00:49:56','2023-10-16 00:55:00'),(39,1,'accountant','Contador',1,'2023-10-16','2023-10-17','2023-10-16 00:49:56','2023-10-16 00:55:03'),(40,1,'1','1',1,NULL,NULL,'2023-11-07 00:36:15','2023-11-07 00:36:15'),(41,1,'1','2',1,NULL,NULL,'2023-11-07 00:38:18','2023-11-07 00:38:18');
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `decks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `decks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `decks_user_id_foreign` (`user_id`),
  CONSTRAINT `decks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `decks` WRITE;
/*!40000 ALTER TABLE `decks` DISABLE KEYS */;
INSERT INTO `decks` VALUES (1,1,'Deck 1','English to Portuguese Translation','2023-10-16 00:49:56','2023-10-16 00:49:56');
/*!40000 ALTER TABLE `decks` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_10_12_134330_create_decks_table',1),(6,'2023_10_12_134334_create_cards_table',1),(7,'2023_10_12_134339_create_progress_table',1),(8,'2023_11_07_000932_create_card_phrases_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'auth_token','94df5e2aad1ebe6396ecf58136ddc7437150b5cf5ef64ac61390ea265fe84239','[\"*\"]','2023-10-16 01:08:45',NULL,'2023-10-16 00:50:08','2023-10-16 01:08:45'),(2,'App\\Models\\User',1,'auth_token','584633a76bfd3f50ba589337df0c9f007fb62d8f1c12357eb9521bf9ab34ef65','[\"*\"]','2023-11-07 01:07:51',NULL,'2023-11-07 00:35:15','2023-11-07 01:07:51');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `progress` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `card_id` bigint unsigned NOT NULL,
  `times_studied` int NOT NULL DEFAULT '0',
  `times_correct` int NOT NULL DEFAULT '0',
  `last_studied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `progress_user_id_foreign` (`user_id`),
  KEY `progress_card_id_foreign` (`card_id`),
  CONSTRAINT `progress_card_id_foreign` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE,
  CONSTRAINT `progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `progress` WRITE;
/*!40000 ALTER TABLE `progress` DISABLE KEYS */;
/*!40000 ALTER TABLE `progress` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test','test','test@mail.com',NULL,'$2y$10$voD.E386iKe5..gqFzp2c.KWi7GzhSqxGibTeRz3UuRJtUp5kzKfm',NULL,'2023-10-16 00:49:56','2023-10-16 00:49:56');
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

