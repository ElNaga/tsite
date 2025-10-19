-- MySQL dump
-- Database: teatar_zatebe
-- Generated: 2025-10-18 22:04:33
-- Server version: MySQL 8.4

SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `teatar_zatebe`;
USE `teatar_zatebe`;

-- Table structure for table `blog_posts`
DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language` varchar(2) NOT NULL,
  `main_title` varchar(255) NOT NULL,
  `main_text` text NOT NULL,
  `main_image` varchar(255) NOT NULL,
  `secondary_title` varchar(255) NOT NULL,
  `secondary_text` text NOT NULL,
  `secondary_image` varchar(255) NOT NULL,
  `gallery_images` text,
  `visible` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_language` (`language`),
  KEY `idx_visible` (`visible`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Data for table `blog_posts`
LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1, 'en', 'Welcome to Our New Blog!', 'We are excited to launch our new blog where we will share stories, updates, and insights about our theater productions and events. This is a place where we can connect with our community and share the magic of theater with everyone.', '/assets/background-image.png', 'What to Expect', 'In the coming weeks, you can expect to see behind-the-scenes content, actor interviews, production updates, and much more. We will be posting regularly to keep you informed about all the exciting things happening at Teatar za tebe.', '/assets/topright_strip.png', '[\"\\/assets\\/background-image.png\",\"\\/assets\\/topright_strip.png\"]', 1, '2025-09-23 22:25:14', '2025-09-23 22:25:14');
INSERT INTO `blog_posts` VALUES (2, 'mk', 'Добредојдовте во нашиот нов блог!', 'Возбудени сме што го лансираме нашиот нов блог каде ќе споделуваме приказни, ажурирања и увид за нашите театарски продукции и настани. Ова е место каде можеме да се поврземе со нашата заедница и да ја споделиме магијата на театарот со сите.', '/assets/background-image.png', 'Што да очекувате', 'Во наредните недели, можете да очекувате да видите содржина зад сцената, интервјуа со глумци, ажурирања за продукциите и многу повеќе. Ќе објавуваме редовно за да ве информираме за сите возбудливи работи што се случуваат во Театар за тебе.', '/assets/topright_strip.png', '[\"\\/assets\\/background-image.png\",\"\\/assets\\/topright_strip.png\"]', 1, '2025-09-23 22:25:14', '2025-09-23 23:33:34');
INSERT INTO `blog_posts` VALUES (3, 'fr', 'Bienvenue sur notre nouveau blog !', 'Nous sommes ravis de lancer notre nouveau blog où nous partagerons des histoires, des mises à jour et des aperçus de nos productions théâtrales et événements. C\'est un endroit où nous pouvons nous connecter avec notre communauté et partager la magie du théâtre avec tout le monde.', '/assets/background-image.png', 'À quoi s\'attendre', 'Dans les semaines à venir, vous pouvez vous attendre à voir du contenu en coulisses, des interviews d\'acteurs, des mises à jour de production et bien plus encore. Nous publierons régulièrement pour vous tenir informés de toutes les choses passionnantes qui se passent au Théâtre pour toi.', '/assets/topright_strip.png', '[\"\\/assets\\/background-image.png\",\"\\/assets\\/topright_strip.png\"]', 1, '2025-09-23 22:25:14', '2025-09-23 22:25:14');
INSERT INTO `blog_posts` VALUES (4, 'en', 'Behind the Scenes: Our Latest Production', 'Take a look behind the curtain as we prepare for our upcoming children\'s theater production. From costume design to set construction, there\'s so much that goes into creating the magic that our young audiences experience.', '/assets/background-image.png', 'The Creative Process', 'Our team of talented artists and craftspeople work tirelessly to bring stories to life. Every detail, from the smallest prop to the grandest set piece, is carefully considered to create an immersive experience for our audience.', '/assets/topright_strip.png', '[\"\\/assets\\/background-image.png\"]', 1, '2025-09-23 22:25:14', '2025-09-23 22:25:14');
INSERT INTO `blog_posts` VALUES (5, 'en', 'Interactive Theater: Engaging Young Minds', 'Interactive theater is more than just entertainment - it\'s a powerful educational tool that helps children develop creativity, empathy, and critical thinking skills. In this post, we explore how our interactive productions make learning fun and engaging.', '/assets/background-image.png', 'The Benefits of Interactive Theater', 'Research shows that children who participate in interactive theater experiences show improved social skills, increased confidence, and better problem-solving abilities. Our productions are designed to be both entertaining and educational.', '/assets/topright_strip.png', '[\"\\/assets\\/background-image.png\",\"\\/assets\\/topright_strip.png\"]', 1, '2025-09-23 22:25:14', '2025-09-23 23:27:42');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `event_translations`
DROP TABLE IF EXISTS `event_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `language_code` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `book_label` varchar(100) NOT NULL,
  `image_alt` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_event_lang` (`event_id`,`language_code`),
  KEY `idx_language` (`language_code`),
  CONSTRAINT `event_translations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_translations_ibfk_2` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Data for table `event_translations`
LOCK TABLES `event_translations` WRITE;
/*!40000 ALTER TABLE `event_translations` DISABLE KEYS */;
INSERT INTO `event_translations` VALUES (1, 1, 'en', 'Magic Birthday Party', 'An unforgettable magical birthday party with interactive performances, games, and surprises for your child and their friends.', 'Book Magic Party', 'Magic birthday party with interactive theatre', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (2, 1, 'mk', 'Магичен роденден', 'Незаборавен магичен роденден со интерактивни претстави, игри и изненадувања за вашето дете и неговите пријатели.', 'Резервирај магичен роденден', 'Магичен роденден со интерактивен театар', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (3, 1, 'fr', 'Fête d\'anniversaire magique', 'Une fête d\'anniversaire magique inoubliable avec des spectacles interactifs, des jeux et des surprises pour votre enfant et ses amis.', 'Réserver fête magique', 'Fête d\'anniversaire magique avec théâtre interactif', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (4, 2, 'en', 'Drama Workshop for Kids', 'Creative drama workshop where children learn acting, storytelling, and self-expression through fun activities.', 'Join Workshop', 'Drama workshop for children', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (5, 2, 'mk', 'Драмска работилница за деца', 'Креативна драмска работилница каде децата учат глума, раскажување приказни и самоизразување преку забавни активности.', 'Приклучи се', 'Драмска работилница за деца', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (6, 2, 'fr', 'Atelier de théâtre pour enfants', 'Atelier de théâtre créatif où les enfants apprennent le jeu, la narration et l\'expression de soi à travers des activités amusantes.', 'Rejoindre l\'atelier', 'Atelier de théâtre pour enfants', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (7, 3, 'en', 'Interactive Fairy Tale Show', 'Join our interactive fairy tale performance where children become part of the story and help the characters solve problems.', 'Book Show', 'Interactive fairy tale performance', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (8, 3, 'mk', 'Интерактивна приказна за бајки', 'Приклучете се на нашата интерактивна претстава за бајки каде децата стануваат дел од приказната и им помагаат на ликовите да решат проблеми.', 'Резервирај претстава', 'Интерактивна претстава за бајки', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (9, 3, 'fr', 'Spectacle de conte de fées interactif', 'Rejoignez notre spectacle de conte de fées interactif où les enfants deviennent partie de l\'histoire et aident les personnages à résoudre des problèmes.', 'Réserver spectacle', 'Spectacle de conte de fées interactif', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (10, 4, 'en', 'Summer Drama Camp', 'A week-long drama camp during summer holidays with daily activities, performances, and creative workshops.', 'Coming Soon', 'Summer drama camp for children', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (11, 4, 'mk', 'Летен драмски камп', 'Еднонеделен драмски камп за време на летните празници со дневни активности, претстави и креативни работилници.', 'Наскоро', 'Летен драмски камп за деца', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (12, 4, 'fr', 'Camp de théâtre d\'été', 'Un camp de théâtre d\'une semaine pendant les vacances d\'été avec des activités quotidiennes, des spectacles et des ateliers créatifs.', 'Bientôt', 'Camp de théâtre d\'été pour enfants', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (13, 5, 'en', 'Princess & Superhero Party', 'A themed party where children can dress up as their favorite princesses and superheroes with special activities and games.', 'Book Party', 'Princess and superhero themed party', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (14, 5, 'mk', 'Забава за принцези и суперхерои', 'Тематска забава каде децата можат да се облечат како нивните омилени принцези и суперхерои со посебни активности и игри.', 'Резервирај забава', 'Забава за принцези и суперхерои', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (15, 5, 'fr', 'Fête Princesse et Super-héros', 'Une fête à thème où les enfants peuvent se déguiser en leurs princesses et super-héros préférés avec des activités et jeux spéciaux.', 'Réserver fête', 'Fête à thème princesse et super-héros', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (16, 6, 'en', 'Halloween Spooky Theatre', 'A spooky Halloween theatre experience with costumes, scary stories, and fun activities for brave children.', 'Event Ended', 'Halloween spooky theatre experience', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (17, 6, 'mk', 'Страшен театар за Ноќта на вештерките', 'Страшно театарско искуство за Ноќта на вештерките со костуми, страшни приказни и забавни активности за храбри деца.', 'Настанот заврши', 'Страшно театарско искуство за Ноќта на вештерките', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (18, 6, 'fr', 'Théâtre effrayant d\'Halloween', 'Une expérience théâtrale effrayante d\'Halloween avec des costumes, des histoires effrayantes et des activités amusantes pour les enfants courageux.', 'Événement terminé', 'Expérience théâtrale effrayante d\'Halloween', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `event_translations` VALUES (20, 7, 'en', 'Creative Art Workshop', 'Explore painting, drawing, and sculpture in our creative art workshop designed to inspire young artists.', 'Join Art Class', 'Creative art workshop for children', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `event_translations` VALUES (21, 7, 'mk', 'Креативна уметничка работилница', 'Истражете сликање, цртање и вајарство во нашата креативна уметничка работилница дизајнирана да ги инспирира младите уметници.', 'Приклучи се на уметнички час', 'Креативна уметничка работилница за деца', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `event_translations` VALUES (22, 7, 'fr', 'Atelier d\'art créatif', 'Explorez la peinture, le dessin et la sculpture dans notre atelier d\'art créatif conçu pour inspirer les jeunes artistes.', 'Rejoindre la classe d\'art', 'Atelier d\'art créatif pour enfants', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `event_translations` VALUES (23, 8, 'en', 'Music and Movement Class', 'Combine music, dance, and movement in this energetic class that helps children develop rhythm and coordination.', 'Book Music Class', 'Music and movement class for kids', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `event_translations` VALUES (24, 8, 'mk', 'Час за музика и движење', 'Комбинирајте музика, танц и движење во овој енергичен час што им помага на децата да развијат ритам и координација.', 'Резервирај музички час', 'Час за музика и движење за деца', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `event_translations` VALUES (25, 8, 'fr', 'Cours de musique et mouvement', 'Combinez musique, danse et mouvement dans cette classe énergique qui aide les enfants à développer le rythme et la coordination.', 'Réserver cours de musique', 'Cours de musique et mouvement pour enfants', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `event_translations` VALUES (26, 9, 'en', 'Science Adventure Workshop', 'Discover the wonders of science through hands-on experiments and interactive demonstrations.', 'Join Science Class', 'Science adventure workshop for children', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `event_translations` VALUES (27, 9, 'mk', 'Научна авантуристичка работилница', 'Откријте ги чудата на науката преку практични експерименти и интерактивни демонстрации.', 'Приклучи се на научен час', 'Научна авантуристичка работилница за деца', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `event_translations` VALUES (28, 9, 'fr', 'Atelier d\'aventure scientifique', 'Découvrez les merveilles de la science à travers des expériences pratiques et des démonstrations interactives.', 'Rejoindre la classe de sciences', 'Atelier d\'aventure scientifique pour enfants', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
/*!40000 ALTER TABLE `event_translations` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `events`
DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `book_url` varchar(255) NOT NULL,
  `status` enum('draft','published','archived') DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Data for table `events`
LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1, '/assets/background-image.png', 'https://example.com/book/1', 'published', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `events` VALUES (2, '/assets/background-image.png', 'https://example.com/book/2', 'published', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `events` VALUES (3, '/assets/background-image.png', 'https://example.com/book/3', 'published', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `events` VALUES (4, '/assets/background-image.png', 'https://example.com/book/4', 'draft', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `events` VALUES (5, '/assets/background-image.png', 'https://example.com/book/5', 'published', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `events` VALUES (6, '/assets/background-image.png', 'https://example.com/book/6', 'archived', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `events` VALUES (7, '/assets/background-image.png', 'https://example.com/book/1', 'published', '2025-09-21 17:37:45', '2025-09-21 17:37:45');
INSERT INTO `events` VALUES (8, '/assets/background-image.png', 'https://example.com/book/2', 'published', '2025-09-21 17:37:45', '2025-09-21 17:37:45');
INSERT INTO `events` VALUES (9, '/assets/background-image.png', 'https://example.com/book/3', 'published', '2025-09-21 17:37:45', '2025-09-21 17:37:45');
INSERT INTO `events` VALUES (10, '/assets/background-image.png', 'https://example.com/book/4', 'draft', '2025-09-21 17:37:45', '2025-09-21 17:37:45');
INSERT INTO `events` VALUES (11, '/assets/background-image.png', 'https://example.com/book/5', 'published', '2025-09-21 17:37:45', '2025-09-21 17:37:45');
INSERT INTO `events` VALUES (12, '/assets/background-image.png', 'https://example.com/book/6', 'archived', '2025-09-21 17:37:45', '2025-09-21 17:37:45');
INSERT INTO `events` VALUES (13, '/assets/background-image.png', 'https://example.com/book/7', 'published', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `events` VALUES (14, '/assets/background-image.png', 'https://example.com/book/8', 'published', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `events` VALUES (15, '/assets/background-image.png', 'https://example.com/book/9', 'published', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `languages`
DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `code` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Data for table `languages`
LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES ('de', 'Deutsch', 0, '2025-09-21 17:30:46', '2025-09-21 17:30:46');
INSERT INTO `languages` VALUES ('en', 'English', 1, '2025-09-21 17:30:46', '2025-09-21 17:30:46');
INSERT INTO `languages` VALUES ('es', 'Español', 0, '2025-09-21 17:30:46', '2025-09-21 17:30:46');
INSERT INTO `languages` VALUES ('fr', 'Français', 1, '2025-09-21 17:30:46', '2025-09-21 17:30:46');
INSERT INTO `languages` VALUES ('mk', 'Македонски', 1, '2025-09-21 17:30:46', '2025-09-21 17:30:46');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `people`
DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `people` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `language_code` varchar(2) NOT NULL,
  `display_order` int DEFAULT '0',
  `is_visible` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_language` (`language_code`),
  KEY `idx_visible` (`is_visible`),
  KEY `idx_order` (`display_order`),
  CONSTRAINT `people_ibfk_1` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Data for table `people`
LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (31, 'Test Person 1', 'Test Title 1', 'Test Description 1', '/uploads/people/person_68d0465ac0b61_474624699_1031612102333545_73764287427141293_n.jpg', 'en', 4, 1, '2025-09-21 20:32:40', '2025-09-23 21:45:27');
INSERT INTO `people` VALUES (32, 'Тест Лице 1', 'Тест Наслов 1', 'Тест Опис 1', NULL, 'mk', 4, 1, '2025-09-21 20:32:40', '2025-09-23 21:45:27');
INSERT INTO `people` VALUES (33, 'Personne Test 1', 'Titre Test 1', 'Description Test 1', NULL, 'fr', 4, 1, '2025-09-21 20:32:40', '2025-09-23 21:45:27');
INSERT INTO `people` VALUES (34, 'Test Person 2', 'Test Title 2', 'Test Description 2', '/uploads/people/person_68d0490fa55d0_515438229_736860782634394_4965085689571479981_n.jpg', 'en', 1, 1, '2025-09-21 20:32:40', '2025-09-23 21:45:28');
INSERT INTO `people` VALUES (35, 'Тест Лице 2', 'Тест Наслов 2', 'Тест Опис 2', '/uploads/people/person_68d0490fa55d0_515438229_736860782634394_4965085689571479981_n.jpg', 'mk', 1, 1, '2025-09-21 20:32:40', '2025-09-23 21:45:28');
INSERT INTO `people` VALUES (36, 'Personne Test 2', 'Titre Test 2', 'Description Test 2', '/uploads/people/person_68d0490fa55d0_515438229_736860782634394_4965085689571479981_n.jpg', 'fr', 1, 1, '2025-09-21 20:32:40', '2025-09-23 21:45:28');
INSERT INTO `people` VALUES (37, 'aaaa', 'ddd', '3', '/uploads/people/person_37_1758480004.jpg', 'en', 3, 1, '2025-09-21 20:40:04', '2025-09-23 21:45:27');
INSERT INTO `people` VALUES (38, 'teet', 'eee', '3', '/uploads/people/person_37_1758480004.jpg', 'mk', 3, 1, '2025-09-21 20:40:04', '2025-09-23 21:45:27');
INSERT INTO `people` VALUES (39, 'tete', 'ffff', '3', '/uploads/people/person_37_1758480004.jpg', 'fr', 3, 1, '2025-09-21 20:40:04', '2025-09-23 21:45:27');
INSERT INTO `people` VALUES (40, 'Angela Lefkova', 'Najodbara Akterka i Profesorka I zhena i majka i kralica', 'Najodbara Akterka i Profesorka I zhena i majka i kralica', '/uploads/people/person_40_1758488185.webp', 'en', 2, 1, '2025-09-21 22:56:25', '2025-09-23 21:45:28');
INSERT INTO `people` VALUES (41, 'Ангела Лефкова', 'Актер и педагог', 'Актер и педагогАктер и педагогАктер и педагогАктер и педагогАктер и педагог', '/uploads/people/person_40_1758488185.webp', 'mk', 2, 1, '2025-09-21 22:56:25', '2025-09-23 21:45:28');
INSERT INTO `people` VALUES (42, 'Angela Lefkova', 'Najodbara Akterka i Profesorka I zhena i majka i kralica', 'Najodbara Akterka i Profesorka I zhena i majka i kralica', '/uploads/people/person_40_1758488185.webp', 'fr', 2, 1, '2025-09-21 22:56:25', '2025-09-23 21:45:28');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `transactions`
DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `user_data` json NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_event_id` (`event_id`),
  KEY `idx_status` (`status`),
  KEY `idx_timestamp` (`timestamp`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Data for table `transactions`
LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1, 1, '{\"name\": \"John Smith\", \"email\": \"john@example.com\", \"phone\": \"+38970123456\", \"guests\": 12, \"child_age\": 7, \"child_name\": \"Emma\"}', 'confirmed', '150.00', 'bank_transfer', '2025-09-21 17:30:47', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `transactions` VALUES (2, 1, '{\"name\": \"Maria Garcia\", \"email\": \"maria@example.com\", \"phone\": \"+38970234567\", \"guests\": 8, \"child_age\": 5, \"child_name\": \"Luka\"}', 'pending', '120.00', 'cash', '2025-09-21 17:30:47', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `transactions` VALUES (3, 2, '{\"name\": \"David Johnson\", \"email\": \"david@example.com\", \"phone\": \"+38970345678\", \"guests\": 15, \"child_age\": 9, \"child_name\": \"Sofia\"}', 'completed', '180.00', 'credit_card', '2025-09-21 17:30:47', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `transactions` VALUES (4, 3, '{\"name\": \"Anna Petrov\", \"email\": \"anna@example.com\", \"phone\": \"+38970456789\", \"guests\": 10, \"child_age\": 6, \"child_name\": \"Marko\"}', 'confirmed', '140.00', 'bank_transfer', '2025-09-21 17:30:47', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `transactions` VALUES (5, 5, '{\"name\": \"Sarah Wilson\", \"email\": \"sarah@example.com\", \"phone\": \"+38970567890\", \"guests\": 20, \"child_age\": 8, \"child_name\": \"Nikola\"}', 'pending', '200.00', 'credit_card', '2025-09-21 17:30:47', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `transactions` VALUES (6, 1, '{\"name\": \"Michael Brown\", \"email\": \"michael@example.com\", \"phone\": \"+38970678901\", \"guests\": 6, \"child_age\": 4, \"child_name\": \"Elena\"}', 'cancelled', '100.00', 'bank_transfer', '2025-09-21 17:30:47', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `transactions` VALUES (7, 1, '{\"name\": \"John Smith\", \"email\": \"john@example.com\", \"phone\": \"+38970123456\", \"guests\": 12, \"child_age\": 7, \"child_name\": \"Emma\", \"special_requests\": \"Emma loves princesses\"}', 'confirmed', '150.00', 'bank_transfer', '2025-09-21 17:37:56', '2025-09-21 17:37:56', '2025-09-21 17:37:56');
INSERT INTO `transactions` VALUES (8, 1, '{\"name\": \"Maria Garcia\", \"email\": \"maria@example.com\", \"phone\": \"+38970234567\", \"guests\": 8, \"allergies\": \"No nuts please\", \"child_age\": 5, \"child_name\": \"Luka\"}', 'pending', '120.00', 'cash', '2025-09-21 17:37:56', '2025-09-21 17:37:56', '2025-09-21 17:37:56');
INSERT INTO `transactions` VALUES (9, 2, '{\"name\": \"David Johnson\", \"email\": \"david@example.com\", \"phone\": \"+38970345678\", \"guests\": 15, \"child_age\": 9, \"child_name\": \"Sofia\", \"experience\": \"First time at drama workshop\"}', 'completed', '180.00', 'credit_card', '2025-09-21 17:37:56', '2025-09-21 17:37:56', '2025-09-21 17:37:56');
INSERT INTO `transactions` VALUES (10, 3, '{\"name\": \"Anna Petrov\", \"email\": \"anna@example.com\", \"phone\": \"+38970456789\", \"guests\": 10, \"child_age\": 6, \"child_name\": \"Marko\", \"favorite_story\": \"Little Red Riding Hood\"}', 'confirmed', '140.00', 'bank_transfer', '2025-09-21 17:37:56', '2025-09-21 17:37:56', '2025-09-21 17:37:56');
INSERT INTO `transactions` VALUES (11, 5, '{\"name\": \"Sarah Wilson\", \"email\": \"sarah@example.com\", \"phone\": \"+38970567890\", \"guests\": 20, \"child_age\": 8, \"child_name\": \"Nikola\", \"theme_preference\": \"Superhero theme\"}', 'pending', '200.00', 'credit_card', '2025-09-21 17:37:56', '2025-09-21 17:37:56', '2025-09-21 17:37:56');
INSERT INTO `transactions` VALUES (12, 1, '{\"name\": \"Michael Brown\", \"email\": \"michael@example.com\", \"phone\": \"+38970678901\", \"guests\": 6, \"child_age\": 4, \"child_name\": \"Elena\", \"cancellation_reason\": \"Family emergency\"}', 'cancelled', '100.00', 'bank_transfer', '2025-09-21 17:37:56', '2025-09-21 17:37:56', '2025-09-21 17:37:56');
INSERT INTO `transactions` VALUES (13, 2, '{\"name\": \"Lisa Anderson\", \"email\": \"lisa@example.com\", \"phone\": \"+38970789012\", \"guests\": 12, \"child_age\": 10, \"child_name\": \"Alex\", \"previous_experience\": \"Has done drama before\"}', 'confirmed', '160.00', 'credit_card', '2025-09-21 17:37:56', '2025-09-21 17:37:56', '2025-09-21 17:37:56');
INSERT INTO `transactions` VALUES (14, 3, '{\"name\": \"Peter Novak\", \"email\": \"peter@example.com\", \"phone\": \"+38970890123\", \"guests\": 8, \"child_age\": 7, \"child_name\": \"Mila\", \"language_preference\": \"Macedonian\"}', 'pending', '130.00', 'cash', '2025-09-21 17:37:57', '2025-09-21 17:37:57', '2025-09-21 17:37:57');
INSERT INTO `transactions` VALUES (15, 4, '{\"name\": \"Elena Dimitrov\", \"email\": \"elena@example.com\", \"phone\": \"+38970901234\", \"guests\": 14, \"waitlist\": true, \"child_age\": 9, \"child_name\": \"Stefan\"}', 'pending', '170.00', 'bank_transfer', '2025-09-21 17:37:57', '2025-09-21 17:37:57', '2025-09-21 17:37:57');
INSERT INTO `transactions` VALUES (16, 5, '{\"name\": \"Mark Thompson\", \"email\": \"mark@example.com\", \"phone\": \"+38970012345\", \"guests\": 10, \"child_age\": 6, \"child_name\": \"Zoe\", \"costume_request\": \"Princess costume\"}', 'completed', '145.00', 'credit_card', '2025-09-21 17:37:57', '2025-09-21 17:37:57', '2025-09-21 17:37:57');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `translations`
DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language_code` varchar(2) NOT NULL,
  `translation_key` varchar(100) NOT NULL,
  `translation_value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_lang_key` (`language_code`,`translation_key`),
  KEY `idx_language` (`language_code`),
  KEY `idx_key` (`translation_key`),
  CONSTRAINT `translations_ibfk_1` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=364 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Data for table `translations`
LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
INSERT INTO `translations` VALUES (1, 'en', 'site_title', 'Teatar za tebe - Interactive Theatre & Events for Kids', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (2, 'en', 'site_description', 'Unforgettable children\'s parties, interactive performances, drama studio, and creative workshops. Book your next event with Teatar za tebe!', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (3, 'en', 'home', 'Home', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (4, 'en', 'about', 'About', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (5, 'en', 'offer', 'Offer', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (6, 'en', 'blog', 'Blog', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (7, 'en', 'contact', 'Contact', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (8, 'en', 'language', 'Language', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (9, 'en', 'book_now', 'Book now', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (10, 'en', 'not_found_title', 'Page Not Found', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (11, 'en', 'not_found_message', 'Sorry, the page you are looking for does not exist or has been moved. Try going back to the homepage.', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (12, 'en', 'welcome_message', 'Welcome to Teatar za tebe!', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (13, 'en', 'services_title', 'Our Services', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (14, 'en', 'events_title', 'Upcoming Events', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (15, 'en', 'testimonials_title', 'What Parents Say', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (16, 'mk', 'site_title', 'Театар за тебе - Интерактивен театар и настани за деца', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (17, 'mk', 'site_description', 'Незаборавни детски родендени, интерактивни претстави, драмско студио и креативни работилници. Закажете го вашиот следен настан со Театар за тебе!', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (18, 'mk', 'home', 'Дома', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (19, 'mk', 'about', 'За нас', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (20, 'mk', 'offer', 'Понуда', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (21, 'mk', 'blog', 'Блог', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (22, 'mk', 'contact', 'Контакт', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (23, 'mk', 'language', 'Јазик', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (24, 'mk', 'book_now', 'Резервирај', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (25, 'mk', 'not_found_title', 'Страницата не е пронајдена', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (26, 'mk', 'not_found_message', 'Жалиме, страницата што ја барате не постои или е преместена. Обидете се да се вратите на почетната страница.', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (27, 'mk', 'welcome_message', 'Добредојдовте во Театар за тебе!', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (28, 'mk', 'services_title', 'Наши услуги', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (29, 'mk', 'events_title', 'Претстојни настани', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (30, 'mk', 'testimonials_title', 'Што велат родителите', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (31, 'fr', 'site_title', 'Théâtre pour toi - Théâtre interactif et événements pour enfants', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (32, 'fr', 'site_description', 'Fêtes d\'enfants inoubliables, spectacles interactifs, studio de théâtre et ateliers créatifs. Réservez votre prochain événement avec Théâtre pour toi!', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (33, 'fr', 'home', 'Accueil', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (34, 'fr', 'about', 'À propos', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (35, 'fr', 'offer', 'Offre', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (36, 'fr', 'blog', 'Blog', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (37, 'fr', 'contact', 'Contact', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (38, 'fr', 'language', 'Langue', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (39, 'fr', 'book_now', 'Réserver', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (40, 'fr', 'not_found_title', 'Page non trouvée', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (41, 'fr', 'not_found_message', 'Désolé, la page que vous recherchez n\'existe pas ou a été déplacée. Essayez de revenir à la page d\'accueil.', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (42, 'fr', 'welcome_message', 'Bienvenue au Théâtre pour toi!', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (43, 'fr', 'services_title', 'Nos services', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (44, 'fr', 'events_title', 'Événements à venir', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (45, 'fr', 'testimonials_title', 'Ce que disent les parents', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `translations` VALUES (61, 'en', 'hero_title', 'Magical Experiences for Your Child', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (62, 'en', 'hero_subtitle', 'Interactive theatre, creative workshops, and unforgettable birthday parties', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (63, 'en', 'about_title', 'About Teatar za tebe', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (64, 'en', 'about_description', 'We create magical experiences that inspire creativity and joy in children through interactive theatre and creative activities.', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (65, 'en', 'contact_title', 'Get in Touch', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (66, 'en', 'contact_description', 'Ready to create magical memories? Contact us to book your next event!', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (67, 'en', 'phone', 'Phone', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (68, 'en', 'email', 'Email', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (69, 'en', 'address', 'Address', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (70, 'en', 'hours', 'Working Hours', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (71, 'en', 'monday_friday', 'Monday - Friday', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (72, 'en', 'saturday', 'Saturday', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (73, 'en', 'sunday', 'Sunday', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (74, 'en', 'closed', 'Closed', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (75, 'en', 'follow_us', 'Follow Us', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (76, 'en', 'all_rights_reserved', 'All rights reserved', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (77, 'en', 'privacy_policy', 'Privacy Policy', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (78, 'en', 'terms_of_service', 'Terms of Service', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (94, 'mk', 'hero_title', 'Магични искуства за вашето дете', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (95, 'mk', 'hero_subtitle', 'Интерактивен театар, креативни работилници и незаборавни родендени', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (96, 'mk', 'about_title', 'За Театар за тебе', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (97, 'mk', 'about_description', 'Создаваме магични искуства кои ги инспирираат креативноста и радоста кај децата преку интерактивен театар и креативни активности.', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (98, 'mk', 'contact_title', 'Контактирајте не', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (99, 'mk', 'contact_description', 'Подготвени да создадете магични спомени? Контактирајте не за да го закажете вашиот следен настан!', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (100, 'mk', 'phone', 'Телефон', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (101, 'mk', 'email', 'Е-пошта', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (102, 'mk', 'address', 'Адреса', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (103, 'mk', 'hours', 'Работно време', '2025-09-21 17:37:27', '2025-09-21 17:37:27');
INSERT INTO `translations` VALUES (104, 'mk', 'monday_friday', 'Понеделник - Петок', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (105, 'mk', 'saturday', 'Сабота', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (106, 'mk', 'sunday', 'Недела', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (107, 'mk', 'closed', 'Затворено', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (108, 'mk', 'follow_us', 'Следете не', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (109, 'mk', 'all_rights_reserved', 'Сите права се задржани', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (110, 'mk', 'privacy_policy', 'Политика за приватност', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (111, 'mk', 'terms_of_service', 'Услови за користење', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (127, 'fr', 'hero_title', 'Expériences magiques pour votre enfant', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (128, 'fr', 'hero_subtitle', 'Théâtre interactif, ateliers créatifs et fêtes d\'anniversaire inoubliables', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (129, 'fr', 'about_title', 'À propos du Théâtre pour toi', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (130, 'fr', 'about_description', 'Nous créons des expériences magiques qui inspirent la créativité et la joie chez les enfants grâce au théâtre interactif et aux activités créatives.', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (131, 'fr', 'contact_title', 'Contactez-nous', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (132, 'fr', 'contact_description', 'Prêt à créer des souvenirs magiques? Contactez-nous pour réserver votre prochain événement!', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (133, 'fr', 'phone', 'Téléphone', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (134, 'fr', 'email', 'E-mail', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (135, 'fr', 'address', 'Adresse', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (136, 'fr', 'hours', 'Heures d\'ouverture', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (137, 'fr', 'monday_friday', 'Lundi - Vendredi', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (138, 'fr', 'saturday', 'Samedi', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (139, 'fr', 'sunday', 'Dimanche', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (140, 'fr', 'closed', 'Fermé', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (141, 'fr', 'follow_us', 'Suivez-nous', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (142, 'fr', 'all_rights_reserved', 'Tous droits réservés', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (143, 'fr', 'privacy_policy', 'Politique de confidentialité', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (144, 'fr', 'terms_of_service', 'Conditions d\'utilisation', '2025-09-21 17:37:28', '2025-09-21 17:37:28');
INSERT INTO `translations` VALUES (145, 'en', 'service1_title', 'Interactive Theatre Performances', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (146, 'en', 'service1_desc', 'Engaging theatrical shows where children become part of the story and help characters solve problems through interactive participation.', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (147, 'en', 'service2_title', 'Drama Workshops', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (148, 'en', 'service2_desc', 'Creative drama classes where children learn acting, storytelling, and self-expression through fun activities and games.', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (149, 'en', 'service3_title', 'Creative Writing Classes', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (150, 'en', 'service3_desc', 'Inspire your child\'s imagination with our creative writing workshops that combine storytelling with drama and performance.', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (151, 'en', 'service4_title', 'Party Planning Services', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (152, 'en', 'service4_desc', 'Complete party planning for unforgettable birthday celebrations with themed decorations, activities, and entertainment.', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (153, 'en', 'service5_title', 'Professional Development', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (154, 'en', 'service5_desc', 'Training programs for educators and parents on using drama techniques to enhance children\'s learning and development.', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (155, 'en', 'about_mission_title', 'Our Mission', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (156, 'en', 'about_mission_desc', 'To inspire creativity and confidence in children through interactive theatre and creative arts, fostering imagination and self-expression.', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (157, 'en', 'about_values_title', 'Our Values', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (158, 'en', 'about_values_desc', 'We believe in the power of play, creativity, and storytelling to help children develop essential life skills and emotional intelligence.', '2025-09-21 17:41:26', '2025-09-21 17:41:26');
INSERT INTO `translations` VALUES (159, 'en', 'about_approach_title', 'Our Approach', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (160, 'en', 'about_approach_list', 'Interactive learning, Creative expression, Safe environment, Individual attention, Fun and engaging activities', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (161, 'en', 'party_animation_title', 'Magical Party Experiences', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (162, 'en', 'party_animation_body', 'Transform your child\'s special day into an unforgettable adventure with our themed party packages, interactive entertainment, and personalized activities designed to create lasting memories.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (163, 'en', 'party_ideas_title', 'Creative Party Ideas', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (164, 'en', 'party_ideas_body', 'From princess tea parties to superhero adventures, we offer a wide range of themed party packages that bring your child\'s dreams to life with professional entertainment and creative activities.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (165, 'en', 'footer_brand_title', 'Teatar za tebe', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (166, 'en', 'footer_page_desc', 'Creating magical experiences for children through interactive theatre, creative workshops, and unforgettable parties.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (167, 'en', 'footer_chann', 'Join our community', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (168, 'en', 'footer_channel_members', 'Connect with other parents and stay updated on our latest events and workshops.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (169, 'en', 'footer_rights', 'All rights reserved.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (170, 'mk', 'service1_title', 'Интерактивни театарски претстави', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (171, 'mk', 'service1_desc', 'Ангажирачки театарски претстави каде децата стануваат дел од приказната и им помагаат на ликовите да решат проблеми преку интерактивно учество.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (172, 'mk', 'service2_title', 'Драмски работилници', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (173, 'mk', 'service2_desc', 'Креативни драмски часови каде децата учат глума, раскажување приказни и самоизразување преку забавни активности и игри.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (174, 'mk', 'service3_title', 'Креативни часови за пишување', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (175, 'mk', 'service3_desc', 'Инспирирајте ја имагинацијата на вашето дете со нашите креативни работилници за пишување кои комбинираат раскажување приказни со драма и настапување.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (176, 'mk', 'service4_title', 'Услуги за планирање забави', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (177, 'mk', 'service4_desc', 'Комплетно планирање на забави за незаборавни прослави на родендени со тематски украси, активности и забава.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (178, 'mk', 'service5_title', 'Професионален развој', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (179, 'mk', 'service5_desc', 'Програми за обука на едукатори и родители за користење на драмски техники за подобрување на учењето и развојот на децата.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (180, 'mk', 'about_mission_title', 'Нашата мисија', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (181, 'mk', 'about_mission_desc', 'Да ја инспирираме креативноста и самодовербата кај децата преку интерактивен театар и креативни уметности, поттикнувајќи имагинација и самоизразување.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (182, 'mk', 'about_values_title', 'Нашите вредности', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (183, 'mk', 'about_values_desc', 'Веруваме во моќта на играта, креативноста и раскажувањето приказни за да им помогнеме на децата да развијат основни животни вештини и емоционална интелигенција.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (184, 'mk', 'about_approach_title', 'Нашиот пристап', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (185, 'mk', 'about_approach_list', 'Интерактивно учење, Креативно изразување, Безбедна средина, Индивидуално внимание, Забавни и ангажирачки активности', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (186, 'mk', 'party_animation_title', 'Магични искуства од забави', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (187, 'mk', 'party_animation_body', 'Трансформирајте го посебниот ден на вашето дете во незаборавна авантура со нашите тематски пакети за забави, интерактивна забава и персонализирани активности дизајнирани да создадат трајни спомени.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (188, 'mk', 'party_ideas_title', 'Креативни идеи за забави', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (189, 'mk', 'party_ideas_body', 'Од чајни забави за принцези до авантури на суперхерои, нудиме широк спектар на тематски пакети за забави кои ги оживуваат соништата на вашето дете со професионална забава и креативни активности.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (190, 'mk', 'footer_brand_title', 'Театар за тебе', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (191, 'mk', 'footer_page_desc', 'Создаваме магични искуства за деца преку интерактивен театар, креативни работилници и незаборавни забави.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (192, 'mk', 'footer_chann', 'Приклучете се на нашата заедница', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (193, 'mk', 'footer_channel_members', 'Поврзете се со други родители и бидете во тек со нашите најнови настани и работилници.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (194, 'mk', 'footer_rights', 'Сите права се задржани.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (195, 'fr', 'service1_title', 'Spectacles de théâtre interactif', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (196, 'fr', 'service1_desc', 'Des spectacles théâtraux engageants où les enfants deviennent partie de l\'histoire et aident les personnages à résoudre des problèmes grâce à la participation interactive.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (197, 'fr', 'service2_title', 'Ateliers de théâtre', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (198, 'fr', 'service2_desc', 'Des cours de théâtre créatifs où les enfants apprennent le jeu, la narration et l\'expression de soi à travers des activités et jeux amusants.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (199, 'fr', 'service3_title', 'Cours d\'écriture créative', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (200, 'fr', 'service3_desc', 'Inspirez l\'imagination de votre enfant avec nos ateliers d\'écriture créative qui combinent la narration avec le théâtre et la performance.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (201, 'fr', 'service4_title', 'Services de planification de fêtes', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (202, 'fr', 'service4_desc', 'Planification complète de fêtes pour des célébrations d\'anniversaire inoubliables avec des décorations thématiques, des activités et des divertissements.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (203, 'fr', 'service5_title', 'Développement professionnel', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (204, 'fr', 'service5_desc', 'Programmes de formation pour éducateurs et parents sur l\'utilisation des techniques théâtrales pour améliorer l\'apprentissage et le développement des enfants.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (205, 'fr', 'about_mission_title', 'Notre mission', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (206, 'fr', 'about_mission_desc', 'Inspirer la créativité et la confiance chez les enfants grâce au théâtre interactif et aux arts créatifs, favorisant l\'imagination et l\'expression de soi.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (207, 'fr', 'about_values_title', 'Nos valeurs', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (208, 'fr', 'about_values_desc', 'Nous croyons au pouvoir du jeu, de la créativité et de la narration pour aider les enfants à développer des compétences de vie essentielles et l\'intelligence émotionnelle.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (209, 'fr', 'about_approach_title', 'Notre approche', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (210, 'fr', 'about_approach_list', 'Apprentissage interactif, Expression créative, Environnement sécurisé, Attention individuelle, Activités amusantes et engageantes', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (211, 'fr', 'party_animation_title', 'Expériences de fête magiques', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (212, 'fr', 'party_animation_body', 'Transformez le jour spécial de votre enfant en une aventure inoubliable avec nos forfaits de fête thématiques, divertissement interactif et activités personnalisées conçues pour créer des souvenirs durables.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (213, 'fr', 'party_ideas_title', 'Idées de fête créatives', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (214, 'fr', 'party_ideas_body', 'Des goûters de princesses aux aventures de super-héros, nous offrons une large gamme de forfaits de fête thématiques qui donnent vie aux rêves de votre enfant avec divertissement professionnel et activités créatives.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (215, 'fr', 'footer_brand_title', 'Théâtre pour toi', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (216, 'fr', 'footer_page_desc', 'Créer des expériences magiques pour les enfants grâce au théâtre interactif, aux ateliers créatifs et aux fêtes inoubliables.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (217, 'fr', 'footer_chann', 'Rejoignez notre communauté', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (218, 'fr', 'footer_channel_members', 'Connectez-vous avec d\'autres parents et restez informé de nos derniers événements et ateliers.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (219, 'fr', 'footer_rights', 'Tous droits réservés.', '2025-09-21 17:41:27', '2025-09-21 17:41:27');
INSERT INTO `translations` VALUES (220, 'en', 'about_hero_title', 'About Teatar za tebe', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (221, 'en', 'about_hero_subtitle', 'Creating magical experiences for children through interactive theatre, creative workshops, and unforgettable parties.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (222, 'en', 'about_story_title', 'Our Story', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (223, 'en', 'about_story_desc', 'Founded with a passion for children\'s development and creativity, Teatar za tebe began as a small initiative to bring interactive theatre to local communities. Our journey started when we realized the transformative power of drama and storytelling in children\'s lives.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (224, 'en', 'about_story_desc2', 'Today, we continue to grow and evolve, reaching hundreds of children and families across the region. Our commitment remains the same: to create safe, engaging, and educational experiences that spark imagination and build confidence in every child we work with.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (225, 'en', 'about_story_image_alt', 'Teatar za tebe team working with children', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (226, 'en', 'value_creativity_title', 'Creativity', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (227, 'en', 'value_creativity_desc', 'We believe in the power of creative expression to unlock children\'s potential and inspire their imagination through drama, art, and storytelling.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (228, 'en', 'value_community_title', 'Community', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (229, 'en', 'value_community_desc', 'Building strong connections between children, families, and our team to create a supportive environment where everyone can thrive and grow together.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (230, 'en', 'value_excellence_title', 'Excellence', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (231, 'en', 'value_excellence_desc', 'Committed to delivering the highest quality experiences with professional performers, safe environments, and carefully crafted programs that exceed expectations.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (232, 'en', 'about_team_title', 'Meet Our Team', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (233, 'en', 'about_team_intro', 'Our passionate team of educators, performers, and creative professionals are dedicated to making every child\'s experience magical and memorable.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (234, 'en', 'about_team_placeholder', 'Our team information is being updated. Please check back soon!', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (235, 'en', 'about_join_us', 'Join Our Team', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (236, 'en', 'about_cta_title', 'Ready to Create Magic?', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (237, 'en', 'about_cta_desc', 'Whether you\'re planning a birthday party, looking for creative workshops, or want to collaborate with us, we\'d love to hear from you.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (238, 'mk', 'about_hero_title', 'За Театар за тебе', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (239, 'mk', 'about_hero_subtitle', 'Создаваме магични искуства за деца преку интерактивен театар, креативни работилници и незаборавни забави.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (240, 'mk', 'about_story_title', 'Нашата приказна', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (241, 'mk', 'about_story_desc', 'Основан со страст за развојот и креативноста на децата, Театар за тебе започна како мала иницијатива за донесување на интерактивен театар во локалните заедници. Нашата авантура започна кога ја сфативме трансформативната моќ на драмата и раскажувањето приказни во животите на децата.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (242, 'mk', 'about_story_desc2', 'Денес, продолжуваме да растеме и еволуираме, допирајќи стотици деца и семејства низ регионот. Нашата посветеност останува иста: да создаваме безбедни, ангажирачки и едукативни искуства кои ја палјат имагинацијата и градат самодоверба кај секое дете со кое работиме.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (243, 'mk', 'about_story_image_alt', 'Тимот на Театар за тебе работи со деца', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (244, 'mk', 'value_creativity_title', 'Креативност', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (245, 'mk', 'value_creativity_desc', 'Веруваме во моќта на креативното изразување за отклучување на потенцијалот на децата и инспирирање на нивната имагинација преку драма, уметност и раскажување приказни.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (246, 'mk', 'value_community_title', 'Заедница', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (247, 'mk', 'value_community_desc', 'Градење силни врски помеѓу деца, семејства и нашиот тим за создавање на поддржувачка средина каде сите можат да процветаат и растат заедно.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (248, 'mk', 'value_excellence_title', 'Извонредност', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (249, 'mk', 'value_excellence_desc', 'Посветени на доставување на највисок квалитет искуства со професионални изведувачи, безбедни средини и внимателно изработени програми кои ги надминуваат очекувањата.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (250, 'mk', 'about_team_title', 'Запознајте го нашиот тим', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (251, 'mk', 'about_team_intro', 'Нашиот страстен тим од едукатори, изведувачи и креативни професионалци е посветен на правење на секое детско искуство магично и незаборавно.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (252, 'mk', 'about_team_placeholder', 'Информациите за нашиот тим се ажурираат. Ве молиме проверете повторно наскоро!', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (253, 'mk', 'about_join_us', 'Приклучете се на нашиот тим', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (254, 'mk', 'about_cta_title', 'Подготвени да создадете магија?', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (255, 'mk', 'about_cta_desc', 'Дали планирате роденденска забава, барате креативни работилници или сакате да соработувате со нас, би сакале да чуеме од вас.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (256, 'fr', 'about_hero_title', 'À propos du Théâtre pour toi', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (257, 'fr', 'about_hero_subtitle', 'Créer des expériences magiques pour les enfants grâce au théâtre interactif, aux ateliers créatifs et aux fêtes inoubliables.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (258, 'fr', 'about_story_title', 'Notre histoire', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (259, 'fr', 'about_story_desc', 'Fondé avec une passion pour le développement et la créativité des enfants, le Théâtre pour toi a commencé comme une petite initiative pour apporter le théâtre interactif aux communautés locales. Notre voyage a commencé lorsque nous avons réalisé le pouvoir transformateur du drame et de la narration dans la vie des enfants.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (260, 'fr', 'about_story_desc2', 'Aujourd\'hui, nous continuons à grandir et à évoluer, touchant des centaines d\'enfants et de familles dans toute la région. Notre engagement reste le même: créer des expériences sûres, engageantes et éducatives qui éveillent l\'imagination et renforcent la confiance de chaque enfant avec lequel nous travaillons.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (261, 'fr', 'about_story_image_alt', 'L\'équipe du Théâtre pour toi travaille avec les enfants', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (262, 'fr', 'value_creativity_title', 'Créativité', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (263, 'fr', 'value_creativity_desc', 'Nous croyons au pouvoir de l\'expression créative pour libérer le potentiel des enfants et inspirer leur imagination à travers le théâtre, l\'art et la narration.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (264, 'fr', 'value_community_title', 'Communauté', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (265, 'fr', 'value_community_desc', 'Construire des liens solides entre les enfants, les familles et notre équipe pour créer un environnement de soutien où chacun peut s\'épanouir et grandir ensemble.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (266, 'fr', 'value_excellence_title', 'Excellence', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (267, 'fr', 'value_excellence_desc', 'Engagés à offrir des expériences de la plus haute qualité avec des artistes professionnels, des environnements sûrs et des programmes soigneusement conçus qui dépassent les attentes.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (268, 'fr', 'about_team_title', 'Rencontrez notre équipe', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (269, 'fr', 'about_team_intro', 'Notre équipe passionnée d\'éducateurs, d\'artistes et de professionnels créatifs se consacre à rendre l\'expérience de chaque enfant magique et mémorable.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (270, 'fr', 'about_team_placeholder', 'Les informations sur notre équipe sont en cours de mise à jour. Veuillez revenir bientôt!', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (271, 'fr', 'about_join_us', 'Rejoignez notre équipe', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (272, 'fr', 'about_cta_title', 'Prêt à créer de la magie?', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (273, 'fr', 'about_cta_desc', 'Que vous planifiiez une fête d\'anniversaire, que vous cherchiez des ateliers créatifs ou que vous souhaitiez collaborer avec nous, nous aimerions avoir de vos nouvelles.', '2025-09-21 18:09:27', '2025-09-21 18:09:27');
INSERT INTO `translations` VALUES (274, 'en', 'contact_page_title', 'Contact Us', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (275, 'en', 'contact_page_subtitle', 'Let\'s Create Magic Together!', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (276, 'en', 'contact_page_description', 'Ready to bring joy and laughter to your next event? Whether you\'re planning an unforgettable birthday party, an interactive theatre performance, or a creative workshop, we\'re here to make it special! Fill out the form below and we\'ll get back to you within 24 hours.', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (277, 'en', 'contact_info_hours', 'Working Hours', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (278, 'en', 'contact_info_hours_text', 'Monday - Sunday: 9:00 AM - 8:00 PM', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (279, 'en', 'contact_form_name', 'Full Name', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (280, 'en', 'contact_form_name_placeholder', 'Enter your full name', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (281, 'en', 'contact_form_email', 'Email Address', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (282, 'en', 'contact_form_email_placeholder', 'your.email@example.com', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (283, 'en', 'contact_form_phone', 'Phone Number', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (284, 'en', 'contact_form_phone_placeholder', 'Optional', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (285, 'en', 'contact_form_subject', 'Subject', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (286, 'en', 'contact_form_subject_placeholder', 'What is this about?', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (287, 'en', 'contact_form_message', 'Message', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (288, 'en', 'contact_form_message_placeholder', 'Tell us more about your inquiry...', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (289, 'en', 'contact_form_submit', 'Send Message', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (290, 'en', 'contact_form_sending', 'Sending...', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (291, 'en', 'contact_form_success', 'Thank you for your message! We will get back to you soon.', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (292, 'en', 'contact_form_error', 'Something went wrong. Please try again later.', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (293, 'en', 'contact_info_title', 'Contact Information', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (294, 'en', 'contact_info_phone', 'Phone', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (295, 'en', 'contact_info_email', 'Email', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (296, 'en', 'contact_info_social', 'Social Media', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (297, 'en', 'contact_info_address', 'Address', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (298, 'en', 'contact_error_name_required', 'Full name is required', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (299, 'en', 'contact_error_name_min', 'Full name must be at least 2 characters', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (300, 'en', 'contact_error_email_required', 'Email address is required', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (301, 'en', 'contact_error_email_invalid', 'Please enter a valid email address', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (302, 'en', 'contact_error_message_required', 'Message is required', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (303, 'en', 'contact_error_message_min', 'Message must be at least 10 characters', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (304, 'mk', 'contact_page_title', 'Контактирајте не', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (305, 'mk', 'contact_page_subtitle', 'Да создадеме магија заедно!', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (306, 'mk', 'contact_page_description', 'Подготвени сте да донесете радост и смеа на вашиот следен настан? Без разлика дали планирате незаборавна прослава за роденден, интерактивна театарска претстава или креативна работилница, ние сме тука за да го направиме тоа посебно! Пополнете го формуларот подолу и ќе ви одговориме во рок од 24 часа.', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (307, 'mk', 'contact_info_hours', 'Работно време', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (308, 'mk', 'contact_info_hours_text', 'Понеделник - Недела: 9:00 - 20:00', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (309, 'mk', 'contact_form_name', 'Полно име', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (310, 'mk', 'contact_form_name_placeholder', 'Внесете го вашето име', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (311, 'mk', 'contact_form_email', 'Е-пошта', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (312, 'mk', 'contact_form_email_placeholder', 'vasha.eposta@primer.mk', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (313, 'mk', 'contact_form_phone', 'Телефонски број', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (314, 'mk', 'contact_form_phone_placeholder', 'Опционално', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (315, 'mk', 'contact_form_subject', 'Наслов', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (316, 'mk', 'contact_form_subject_placeholder', 'За што се работи?', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (317, 'mk', 'contact_form_message', 'Порака', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (318, 'mk', 'contact_form_message_placeholder', 'Кажете ни повеќе за вашето прашање...', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (319, 'mk', 'contact_form_submit', 'Испрати порака', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (320, 'mk', 'contact_form_sending', 'Се испраќа...', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (321, 'mk', 'contact_form_success', 'Ви благодариме за пораката! Наскоро ќе ви одговориме.', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (322, 'mk', 'contact_form_error', 'Нешто тргна наопаку. Ве молиме обидете се повторно подоцна.', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (323, 'mk', 'contact_info_title', 'Контакт информации', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (324, 'mk', 'contact_info_phone', 'Телефон', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (325, 'mk', 'contact_info_email', 'Е-пошта', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (326, 'mk', 'contact_info_social', 'Социјални мрежи', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (327, 'mk', 'contact_info_address', 'Адреса', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (328, 'mk', 'contact_error_name_required', 'Полното име е задолжително', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (329, 'mk', 'contact_error_name_min', 'Полното име мора да биде најмалку 2 карактери', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (330, 'mk', 'contact_error_email_required', 'Е-поштата е задолжителна', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (331, 'mk', 'contact_error_email_invalid', 'Ве молиме внесете валидна е-пошта', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (332, 'mk', 'contact_error_message_required', 'Пораката е задолжителна', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (333, 'mk', 'contact_error_message_min', 'Пораката мора да биде најмалку 10 карактери', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (334, 'fr', 'contact_page_title', 'Contactez-nous', '2025-10-13 21:27:52', '2025-10-13 21:27:52');
INSERT INTO `translations` VALUES (335, 'fr', 'contact_page_subtitle', 'Créons la magie ensemble!', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (336, 'fr', 'contact_page_description', 'Prêt à apporter joie et rire à votre prochain événement? Que vous planifiez une fête d\'anniversaire inoubliable, une représentation théâtrale interactive ou un atelier créatif, nous sommes là pour le rendre spécial! Remplissez le formulaire ci-dessous et nous vous répondrons dans les 24 heures.', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (337, 'fr', 'contact_info_hours', 'Heures d\'ouverture', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (338, 'fr', 'contact_info_hours_text', 'Lundi - Dimanche: 9h00 - 20h00', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (339, 'fr', 'contact_form_name', 'Nom complet', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (340, 'fr', 'contact_form_name_placeholder', 'Entrez votre nom complet', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (341, 'fr', 'contact_form_email', 'Adresse e-mail', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (342, 'fr', 'contact_form_email_placeholder', 'votre.email@exemple.fr', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (343, 'fr', 'contact_form_phone', 'Numéro de téléphone', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (344, 'fr', 'contact_form_phone_placeholder', 'Optionnel', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (345, 'fr', 'contact_form_subject', 'Sujet', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (346, 'fr', 'contact_form_subject_placeholder', 'De quoi s\'agit-il?', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (347, 'fr', 'contact_form_message', 'Message', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (348, 'fr', 'contact_form_message_placeholder', 'Parlez-nous de votre demande...', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (349, 'fr', 'contact_form_submit', 'Envoyer le message', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (350, 'fr', 'contact_form_sending', 'Envoi en cours...', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (351, 'fr', 'contact_form_success', 'Merci pour votre message! Nous vous répondrons bientôt.', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (352, 'fr', 'contact_form_error', 'Une erreur s\'est produite. Veuillez réessayer plus tard.', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (353, 'fr', 'contact_info_title', 'Informations de contact', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (354, 'fr', 'contact_info_phone', 'Téléphone', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (355, 'fr', 'contact_info_email', 'E-mail', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (356, 'fr', 'contact_info_social', 'Réseaux sociaux', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (357, 'fr', 'contact_info_address', 'Adresse', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (358, 'fr', 'contact_error_name_required', 'Le nom complet est requis', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (359, 'fr', 'contact_error_name_min', 'Le nom complet doit comporter au moins 2 caractères', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (360, 'fr', 'contact_error_email_required', 'L\'adresse e-mail est requise', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (361, 'fr', 'contact_error_email_invalid', 'Veuillez entrer une adresse e-mail valide', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (362, 'fr', 'contact_error_message_required', 'Le message est requis', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
INSERT INTO `translations` VALUES (363, 'fr', 'contact_error_message_min', 'Le message doit comporter au moins 10 caractères', '2025-10-13 21:27:53', '2025-10-13 21:27:53');
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `user_sessions`
DROP TABLE IF EXISTS `user_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `user_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expires_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_session_id` (`session_id`),
  KEY `idx_expires_at` (`expires_at`),
  CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Data for table `user_sessions`
LOCK TABLES `user_sessions` WRITE;
/*!40000 ALTER TABLE `user_sessions` DISABLE KEYS */;
INSERT INTO `user_sessions` VALUES (1, 'sess_68d01a27f1db1', 1, '{\"ip\": \"192.168.1.100\", \"login_time\": \"2025-09-21 15:30:47\", \"user_agent\": \"Mozilla/5.0...\"}', '2025-09-21 17:30:47', '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `user_sessions` VALUES (2, 'sess_68d01a27f2167', 2, '{\"ip\": \"192.168.1.101\", \"login_time\": \"2025-09-21 15:30:47\", \"user_agent\": \"Mozilla/5.0...\"}', '2025-09-21 17:30:48', '2025-09-21 17:30:48', '2025-09-21 16:30:47');
INSERT INTO `user_sessions` VALUES (3, 'sess_68d01a27f216e', NULL, '{\"ip\": \"192.168.1.102\", \"guest\": true, \"visit_time\": \"2025-09-21 15:30:47\"}', '2025-09-21 17:30:48', '2025-09-21 17:30:48', '2025-09-21 16:00:47');
INSERT INTO `user_sessions` VALUES (4, 'sess_68d01bbe66098', 1, '{\"ip\": \"192.168.1.100\", \"login_time\": \"2025-09-21 15:37:34\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\", \"last_activity\": \"2025-09-21 15:37:34\"}', '2025-09-21 17:37:34', '2025-09-21 17:37:34', '2025-09-21 17:37:34');
INSERT INTO `user_sessions` VALUES (5, 'sess_68d01bbe660e5', 2, '{\"ip\": \"192.168.1.101\", \"login_time\": \"2025-09-21 15:37:34\", \"user_agent\": \"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36\", \"last_activity\": \"2025-09-21 15:37:34\"}', '2025-09-21 17:37:34', '2025-09-21 17:37:34', '2025-09-21 16:37:34');
INSERT INTO `user_sessions` VALUES (6, 'sess_68d01bbe660e9', 3, '{\"ip\": \"192.168.1.102\", \"login_time\": \"2025-09-21 15:37:34\", \"user_agent\": \"Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15\", \"last_activity\": \"2025-09-21 15:37:34\"}', '2025-09-21 17:37:34', '2025-09-21 17:37:34', '2025-09-21 16:07:34');
INSERT INTO `user_sessions` VALUES (7, 'sess_68d01bbe660ed', NULL, '{\"ip\": \"192.168.1.103\", \"guest\": true, \"user_agent\": \"Mozilla/5.0 (Android 11; Mobile; rv:68.0) Gecko/68.0 Firefox/88.0\", \"visit_time\": \"2025-09-21 15:37:34\", \"pages_visited\": [\"/\", \"/about\", \"/events\"]}', '2025-09-21 17:37:34', '2025-09-21 17:37:34', '2025-09-21 15:52:34');
INSERT INTO `user_sessions` VALUES (8, 'sess_68d01bbe660f0', 4, '{\"ip\": \"192.168.1.104\", \"login_time\": \"2025-09-21 14:37:34\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0\", \"last_activity\": \"2025-09-21 15:07:34\"}', '2025-09-21 17:37:34', '2025-09-21 17:37:34', '2025-09-21 16:37:34');
/*!40000 ALTER TABLE `user_sessions` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `users`
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` enum('admin','editor','user') DEFAULT 'user',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Data for table `users`
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1, 'admin@teatarzatebe.mk', '$2y$10$o7/RXrxz9NcbRuUgxakP4e/kTlrTCOQn3A4S7GcalW5h3lVqJ3ar6', 'Admin User', 'admin', 1, '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `users` VALUES (2, 'editor@teatarzatebe.mk', '$2y$10$ta2SWa.N3E8Xk4om4MWtkO.RIBbm6Qf9okAp6XqaZmL25XgyA8Zn6', 'Content Editor', 'editor', 1, '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `users` VALUES (3, 'john.doe@example.com', '$2y$10$klRxJuotWDnQcaACE2k1JuD3hrkxqTxuSl.8HWkv0M19dKW5EWKXa', 'John Doe', 'user', 1, '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `users` VALUES (4, 'jane.smith@example.com', '$2y$10$HzCyD.tn0/nIR.R1caLaHO1OK8Ilsn.WCsifYNzYW8KVq/czih.L2', 'Jane Smith', 'user', 1, '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `users` VALUES (5, 'maria.garcia@example.com', '$2y$10$tofRyJi0EAHYUiiVrlImk.Bc1L3D0QrDC3.xbnRBb0UtP.MsCSadW', 'Maria Garcia', 'user', 0, '2025-09-21 17:30:47', '2025-09-21 17:30:47');
INSERT INTO `users` VALUES (11, 'david.wilson@example.com', '$2y$10$H1Ffx4.h2PJetfd8T4WHDOUPj44F05fJW3CJKsoiSYtN/4V2AwjFC', 'David Wilson', 'user', 1, '2025-09-21 17:37:34', '2025-09-21 17:37:34');
INSERT INTO `users` VALUES (12, 'sarah.johnson@example.com', '$2y$10$oerzo/R8fzJUVHxlRbZ6uuwNUqg2I5A9JjYHGzMbvSElKOoKunK7W', 'Sarah Johnson', 'user', 1, '2025-09-21 17:37:34', '2025-09-21 17:37:34');
INSERT INTO `users` VALUES (13, 'mike.brown@example.com', '$2y$10$jRiRrbDodrfC0LcMx.CyAuY2goclu4MTdeynL5qw3Mnxsrh.e1KxK', 'Mike Brown', 'user', 1, '2025-09-21 17:37:34', '2025-09-21 17:37:34');
INSERT INTO `users` VALUES (14, 'lisa.davis@example.com', '$2y$10$fAiyY18NVgZG3v/1KLdEDeoB.YGG08geKAUAmEo7yI1oljFmsTXPy', 'Lisa Davis', 'user', 1, '2025-09-21 17:37:34', '2025-09-21 17:37:34');
INSERT INTO `users` VALUES (15, 'peter.miller@example.com', '$2y$10$XBqQd4BUxZmf1otQ9vRMO.345vMg/GPvL4kszCin8OODAGgtD5PdS', 'Peter Miller', 'user', 0, '2025-09-21 17:37:34', '2025-09-21 17:37:34');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

SET foreign_key_checks = 1;
COMMIT;
