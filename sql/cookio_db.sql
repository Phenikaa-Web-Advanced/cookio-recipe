/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.28-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cookio_db
-- ------------------------------------------------------
-- Server version	10.6.28-MariaDB-ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `rating` tinyint(3) unsigned DEFAULT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_comments_recipe` (`recipe_id`),
  KEY `idx_comments_user` (`user_id`),
  KEY `idx_comments_parent` (`parent_id`),
  CONSTRAINT `fk_comments_parent` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comments_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,1,NULL,5,'Món này làm rất nhanh mà thịt bò mềm ngọt tuyệt vời!',NULL,'2026-09-09 18:11:04'),(2,2,2,NULL,5,'Công thức rất chuẩn, gia đình mình ai cũng khen ngon.',NULL,'2026-09-09 18:11:04'),(4,1,1,NULL,5,'Món bò xào này siêu ngon, mình đã làm thử và cả nhà đều khen!','uploads/recipes/bo_xao.jpg','2026-09-10 00:23:13'),(9,7,5,NULL,5,'Nước dùng ninh xương bò trong veo và thơm ngát mùi hồi quế đúng điệu phố cổ luôn cô Hoa ơi! Cả nhà cháu ăn ai cũng tấm tắc khen ngon hơn cả đi ăn tiệm ngoài phố.',NULL,'2026-09-11 13:46:57'),(10,7,6,9,5,'Cảm ơn Mẹ Bống nhiều nhé! Nhớ hớt bọt thật kỹ lúc nước bắt đầu sôi liu riu là nước dùng sẽ giữ được độ trong vắt như gương luôn nha con.',NULL,'2026-09-11 13:46:57'),(11,7,7,NULL,5,'Công thức nấu nước dùng chuẩn chỉ lắm. Mình cho thêm 1 thìa nước mắm ngon lúc chuẩn bị múc ra bát, mùi thơm bốc lên nức nở khắp cả gian bếp.',NULL,'2026-09-11 13:46:57'),(12,7,6,11,5,'Dạ đúng rồi chú Năm ạ, nước mắm cho vào sau cùng vừa giữ được hương vị tinh túy mà không bị chua nước phở ạ!',NULL,'2026-09-11 13:46:57'),(13,8,9,NULL,5,'Tỷ lệ nước sốt 2 mắm : 2 đường : 2 chua : 1 cay đúng là chuẩn chỉnh! Sườn mềm róc xương, sốt óng ả bám dính lấy từng miếng thịt. Hôm nay nhà mình cạn sạch cả nồi cơm điện.',NULL,'2026-09-11 13:46:57'),(14,8,5,13,5,'Hihi cảm ơn Lan Anh nhé! Bữa nào thử thêm một xíu dứa băm nhuyễn xào cùng sườn nữa xem, sốt sẽ thơm nức nở hơn nữa đấy ❤️',NULL,'2026-09-11 13:46:57'),(15,8,8,NULL,5,'Món này làm nhanh mà ngon mê ly! Mình rán sơ sườn trước nên miếng sườn xém cạnh ăn giòn thơm bên ngoài mà bên trong vẫn mọng nước ngọt lịm.',NULL,'2026-09-11 13:46:57'),(16,9,6,NULL,5,'Kho bằng nước dừa xiêm đúng là chân ái chú Năm ơi. Miếng mỡ trong veo béo ngậy mà không hề ngấy, cắn miếng thịt cảm giác như tan chảy trên đầu lưỡi vậy.',NULL,'2026-09-11 13:46:57'),(17,9,7,16,5,'Cảm ơn cô Hoa ghé thăm gian bếp! Nước dừa xiêm ngọt thanh tự nhiên nên chú không cần nêm nhiều đường, ăn vừa ngon vừa tốt cho sức khỏe.',NULL,'2026-09-11 13:46:57'),(18,10,2,NULL,5,'Hôm nay nắng nóng 38 độ nấu ngay tô canh chua này của chú Năm giải nhiệt kịp thời luôn. Cá lóc ngọt thịt, vị chua thanh dịu của me chín hòa quyện ngò om thơm lừng.',NULL,'2026-09-11 13:46:57'),(19,10,7,18,5,'Cảm ơn đầu bếp Lan nhé! Canh chua cá lóc ăn kèm đĩa cá kho tộ nồi đất nữa là thành bộ đôi huyền thoại của miền Tây sông nước đó con.',NULL,'2026-09-11 13:46:57'),(20,11,5,NULL,5,'Trước giờ mình ngại ăn ức gà vì sợ khô bã, nhưng học mẹo để thịt nghỉ 3 phút của bạn Lan Anh xong thì thịt mọng nước và mềm ngọt bất ngờ luôn!',NULL,'2026-09-11 13:46:57'),(21,11,9,20,5,'Tuyệt vời quá chị Bống ơi! Mẹo này áp dụng cho bít tết hay bất kỳ loại thịt áp chảo nào cũng giữ được độ ngọt mọng nước 100% đó ạ!',NULL,'2026-09-11 13:46:57'),(22,12,9,NULL,5,'Sốt cà chua sền sệt chấm bánh mì giòn tan ngon đỉnh chóp! Sáng cuối tuần làm một chảo này đãi cả nhà ai cũng mê tít thò lò.',NULL,'2026-09-11 13:46:57'),(23,12,8,22,5,'Cảm ơn bạn nhé! Thêm chút tương ớt cay cay và lòng đỏ trứng còn sánh dẻo chấm vào là chuẩn không cần chỉnh luôn.',NULL,'2026-09-11 13:46:57'),(24,13,5,NULL,5,'Nhìn con cá bống kho săn đanh lại, màu cánh gián đẹp mắt là thấy ấm lòng rồi. Mùa đông hay ngày mưa se lạnh ăn món này đưa cơm dã man!',NULL,'2026-09-11 13:46:57'),(25,13,6,24,5,'Chuẩn bài chị Bống ạ! Cá bống phải kho thật kỹ lửa nhỏ trên nồi đất thì xương cũng mềm rục mà thịt vẫn săn chắc thơm ngon.',NULL,'2026-09-11 13:46:57'),(26,2,4,NULL,5,'tuyệtttt',NULL,'2026-09-11 14:06:28'),(27,15,2,NULL,5,'Công thức làm chuẩn chỉ và chi tiết lắm tác giả ơi! Chiều nay mình trổ tài cho cả nhà ai cũng khen nức nở.',NULL,'2026-09-11 14:31:25'),(28,15,5,27,5,'Cảm ơn bạn nhiều nha! Chúc bạn và gia đình luôn có những bữa cơm ngon miệng cùng Cookio ❤️',NULL,'2026-09-11 14:31:25'),(29,16,2,NULL,5,'Công thức làm chuẩn chỉ và chi tiết lắm tác giả ơi! Chiều nay mình trổ tài cho cả nhà ai cũng khen nức nở.',NULL,'2026-09-11 14:31:25'),(30,16,7,29,5,'Cảm ơn bạn nhiều nha! Chúc bạn và gia đình luôn có những bữa cơm ngon miệng cùng Cookio ❤️',NULL,'2026-09-11 14:31:25'),(31,17,2,NULL,5,'Công thức làm chuẩn chỉ và chi tiết lắm tác giả ơi! Chiều nay mình trổ tài cho cả nhà ai cũng khen nức nở.',NULL,'2026-09-11 14:31:25'),(32,17,6,31,5,'Cảm ơn bạn nhiều nha! Chúc bạn và gia đình luôn có những bữa cơm ngon miệng cùng Cookio ❤️',NULL,'2026-09-11 14:31:25'),(33,18,2,NULL,5,'Công thức làm chuẩn chỉ và chi tiết lắm tác giả ơi! Chiều nay mình trổ tài cho cả nhà ai cũng khen nức nở.',NULL,'2026-09-11 14:31:25'),(34,18,8,33,5,'Cảm ơn bạn nhiều nha! Chúc bạn và gia đình luôn có những bữa cơm ngon miệng cùng Cookio ❤️',NULL,'2026-09-11 14:31:25'),(35,19,2,NULL,5,'Thịt cháy cạnh rất thơm, nước sốt bóng đẹp ăn hao cơm vô cùng mẹ Bống ơi!',NULL,'2026-09-21 10:56:58'),(36,19,7,NULL,5,'Bí quyết dùng đường thốt nốt rim lên màu rất đẹp mắt, tôm giòn thịt săn chắc.',NULL,'2026-09-21 10:56:58'),(37,19,9,NULL,5,'Cả nhà mình vừa làm bữa trưa nay, các bé thích mê món này!',NULL,'2026-09-21 10:56:58'),(38,20,5,NULL,5,'Mẹo lọc qua rây 2 lần làm trứng mịn mượt không bị rỗ tí nào, bé nhà mình ăn hết veo cả bát!',NULL,'2026-09-21 10:56:58'),(39,20,8,NULL,5,'Sốt mỡ hành dầu mè thơm lừng, rất nhẹ bụng cho bữa tối nhanh gọn.',NULL,'2026-09-21 10:56:58'),(40,21,6,NULL,5,'Ức gà mềm ngọt mọng nước, không hề bị khô cứng, công thức sốt teriyaki mật ong đỉnh chóp!',NULL,'2026-09-21 10:56:58'),(41,21,9,NULL,5,'Món này mình ăn hàng ngày trong đợt giảm cân, vừa ngon vừa no lâu.',NULL,'2026-09-21 10:56:58'),(42,22,5,NULL,5,'Món quen thuộc nhưng công thức này sốt đậm đà sánh mịn ăn với cơm trắng ngon tuyệt!',NULL,'2026-09-21 10:56:58'),(43,22,2,NULL,5,'Bữa cơm bận rộn chỉ cần làm đĩa đậu sốt cà thịt băm là cả nhà tấm tắc khen.',NULL,'2026-09-21 10:56:58'),(44,23,9,NULL,5,'Cốt bánh xốp mịn mềm mượt như bông, phô mai ngậy thơm cực kỳ thành công!',NULL,'2026-09-21 10:56:58'),(45,23,2,NULL,5,'Công thức tỉ lệ bột và trứng rất chuẩn, không bị xẹp hay tanh mùi trứng chút nào.',NULL,'2026-09-21 10:56:58'),(46,24,7,NULL,5,'Bò mềm ngọt thấm vị, hoa thiên lý xanh giòn thanh mát kết hợp tỏi phi quá đã!',NULL,'2026-09-21 10:56:58'),(47,24,5,NULL,5,'Món này đãi khách hay ăn cơm tối gia đình đều hết ý, làm nhanh chưa tới 15 phút.',NULL,'2026-09-21 10:56:58'),(48,4,4,NULL,5,'Đã làm thử cho các bé ăn bữa tối, cả nhà ai cũng khen nức nở và ăn hết veo!',NULL,'2026-09-21 10:59:07'),(49,18,7,NULL,5,'Thêm chút tiêu xay và ớt băm nữa là tròn vị luôn, cảm ơn bạn đã chia sẻ công thức tuyệt vời này!',NULL,'2026-11-05 17:15:28'),(68,25,2,NULL,5,'Cơm chiên hạt tơi săn vàng óng, da gà giòn rụm bên trong mọng nước. Tỷ lệ gia vị ướp gà rất vừa vặn!',NULL,'2026-11-04 10:30:00'),(69,25,5,NULL,5,'Bí quyết xối mỡ của tác giả quá hay, da gà phồng rộp giòn tan. Hai bé nhà mình thích mê món này!',NULL,'2026-11-04 14:20:00'),(70,25,7,NULL,5,'Ăn kèm đồ chua với dưa leo cà chua xắt mỏng là chuẩn bài cơm gà xối mỡ Sài Gòn!',NULL,'2026-11-04 19:00:00'),(71,26,9,NULL,5,'Thịt bò xào lửa lớn mềm mọng, không bị ra nước. Tỏi phi thơm nức mũi!',NULL,'2026-11-04 14:15:00'),(72,26,7,NULL,5,'Mẹo ướp thêm thìa dầu hào giúp bò mềm bóng, làm món nhậu hay ăn cơm đều hết ý.',NULL,'2026-11-04 19:40:00'),(73,27,8,NULL,5,'Nước sốt chua ngọt cay tê tê cực kỳ kích thích vị giác, chống ngấy bữa cơm tối rất tốt.',NULL,'2026-11-05 10:15:00'),(74,27,2,NULL,5,'Thịt bò thái mỏng chần nhanh vừa chín tới, giữ được độ ngọt tự nhiên.',NULL,'2026-11-05 15:45:00'),(75,28,5,NULL,5,'Nước súp gà ngọt tự nhiên từ bắp ngọt và nấm hương, nhóc nhà mình húp sạch cả bát tô.',NULL,'2026-11-04 14:50:00'),(76,28,4,NULL,5,'Công thức đơn giản dễ làm, nấu bữa sáng hay bữa phụ cho bé đều nhanh và bổ dưỡng.',NULL,'2026-11-04 18:25:00'),(77,29,6,NULL,5,'Nước kho sánh sệt màu cánh gián tự nhiên, sườn róc xương ngấm đẫm vị, rất tốn cơm!',NULL,'2026-11-04 19:10:00'),(78,29,5,NULL,5,'Thêm chút ớt hiểm kho riu riu lửa nhỏ là ấm bụng ngày mưa.',NULL,'2026-11-05 07:50:00'),(79,30,7,NULL,5,'Gà hấp hành chín tới giữ trọn vị ngọt thơm, chấm cùng muối tiêu chanh ớt thì không chê vào đâu được.',NULL,'2026-11-05 09:40:00'),(80,30,2,NULL,5,'Bí quyết quét chút mỡ nghệ lên da gà giúp da vàng bóng đẹp mắt như ngoài nhà hàng!',NULL,'2026-11-05 16:10:00'),(81,31,4,NULL,5,'Sợi miến dai trong không bị nát hay vón cục, lòng gà giòn sần sật thơm mùi tiêu bắc.',NULL,'2026-11-04 16:50:00'),(82,32,2,NULL,5,'Lòng giòn sần sật không hề hôi đắng, cải chua xào vừa chín tới giữ độ giòn chua thanh.',NULL,'2026-11-04 14:30:00'),(83,32,6,NULL,5,'Bí quyết bóp lòng với giấm muối và gừng đập dập rất hiệu quả, sạch bong.',NULL,'2026-11-04 21:10:00'),(84,34,5,NULL,5,'Lớp bột xù giòn tan rôm rốp, thịt bên trong mềm ngọt không khô tí nào. Chấm tương cà sốt mayo tuyệt cú mèo!',NULL,'2026-11-04 17:10:00'),(85,35,9,NULL,5,'Thịt gà ngấm sốt mặn ngọt quyện hạt điều bùi béo, ớt chuông giòn ngọt giàu vitamin.',NULL,'2026-11-05 17:30:00');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cookbook_recipes`
--

DROP TABLE IF EXISTS `cookbook_recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cookbook_recipes` (
  `cookbook_id` int(10) unsigned NOT NULL,
  `recipe_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `uq_cookbook_recipe` (`cookbook_id`,`recipe_id`),
  KEY `idx_cr_cookbook` (`cookbook_id`),
  KEY `idx_cr_recipe` (`recipe_id`),
  CONSTRAINT `fk_cr_cookbook` FOREIGN KEY (`cookbook_id`) REFERENCES `cookbooks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cr_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cookbook_recipes`
--

LOCK TABLES `cookbook_recipes` WRITE;
/*!40000 ALTER TABLE `cookbook_recipes` DISABLE KEYS */;
/*!40000 ALTER TABLE `cookbook_recipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cookbooks`
--

DROP TABLE IF EXISTS `cookbooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cookbooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_cookbooks_user` (`user_id`),
  KEY `idx_cookbooks_public` (`is_public`),
  CONSTRAINT `fk_cookbooks_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cookbooks`
--

LOCK TABLES `cookbooks` WRITE;
/*!40000 ALTER TABLE `cookbooks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cookbooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `follows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `following_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_follows_following` (`following_id`),
  KEY `fk_follows_follower` (`follower_id`),
  KEY `fk_follows_author` (`author_id`),
  CONSTRAINT `fk_follows_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_follows_follower` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
INSERT INTO `follows` VALUES (25,2,1,1,'2026-11-02 10:00:00'),(26,4,1,1,'2026-11-02 11:30:00'),(27,5,1,1,'2026-11-02 14:15:00'),(28,6,1,1,'2026-11-02 16:45:00'),(29,7,1,1,'2026-11-03 08:20:00'),(30,8,1,1,'2026-11-03 10:50:00'),(31,9,1,1,'2026-11-03 15:10:00'),(32,1,2,2,'2026-11-03 16:00:00'),(33,1,5,5,'2026-11-03 16:10:00'),(34,1,6,6,'2026-11-03 16:20:00'),(35,1,7,7,'2026-11-03 16:30:00'),(36,1,8,8,'2026-11-03 16:40:00'),(37,1,9,9,'2026-11-03 16:50:00'),(38,5,6,6,'2026-11-02 09:00:00'),(39,5,7,7,'2026-11-02 09:30:00'),(40,6,5,5,'2026-11-02 10:00:00'),(41,6,2,2,'2026-11-02 10:30:00'),(42,7,2,2,'2026-11-02 11:00:00'),(43,7,5,5,'2026-11-02 11:30:00'),(44,9,2,2,'2026-11-02 13:00:00'),(45,9,8,8,'2026-11-02 13:30:00'),(46,4,2,2,'2026-11-02 15:00:00'),(47,4,5,5,'2026-11-02 15:30:00'),(48,4,6,6,'2026-11-02 16:00:00');
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `actor_id` int(10) unsigned NOT NULL,
  `type` enum('like','comment','cooksnap','follow') NOT NULL,
  `target_id` int(10) unsigned DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_notif_user` (`user_id`),
  KEY `idx_notif_actor` (`actor_id`),
  KEY `idx_notif_read` (`is_read`),
  CONSTRAINT `fk_notif_actor` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (27,1,2,'like',25,'vừa thả tim cho món Cơm chiên gà xối mỡ ngon đậm đà của bạn!',0,'2026-11-05 18:30:00'),(28,1,5,'comment',25,'vừa bình luận về món Cơm chiên gà xối mỡ: \"Bí quyết xối mỡ của tác giả quá hay...\"',0,'2026-11-05 18:45:00'),(29,1,7,'like',26,'vừa thả tim cho món Cách chế biến món thịt bò xào tỏi của bạn!',0,'2026-11-05 19:00:00'),(30,1,9,'comment',26,'vừa để lại đánh giá 5 sao cho món Thịt bò xào tỏi!',0,'2026-11-05 19:15:00'),(31,1,8,'like',27,'vừa thả tim cho món Nộm thịt bò hành tây kiểu Thái của bạn!',0,'2026-11-05 19:30:00'),(32,1,5,'comment',28,'vừa bình luận về món Cách nấu súp gà cho bé: \"Nhóc nhà mình húp sạch cả bát tô...\"',0,'2026-11-05 20:00:00'),(33,1,6,'like',29,'vừa thả tim cho món Sườn non kho trứng cút của bạn!',0,'2026-11-05 20:20:00'),(34,1,2,'follow',1,'đã bắt đầu theo dõi gian bếp của bạn!',0,'2026-11-05 20:40:00'),(35,1,5,'follow',1,'đã bắt đầu theo dõi gian bếp của bạn!',0,'2026-11-05 20:45:00'),(36,1,7,'follow',1,'đã bắt đầu theo dõi gian bếp của bạn!',0,'2026-11-05 20:50:00'),(37,1,6,'follow',1,'đã bắt đầu theo dõi gian bếp của bạn!',0,'2026-11-05 20:55:00'),(38,1,9,'follow',1,'đã bắt đầu theo dõi gian bếp của bạn!',0,'2026-11-05 21:00:00'),(39,1,8,'follow',1,'đã bắt đầu theo dõi gian bếp của bạn!',0,'2026-11-05 21:05:00'),(40,1,4,'follow',1,'đã bắt đầu theo dõi gian bếp của bạn!',0,'2026-11-05 21:10:00'),(41,1,7,'like',30,'vừa thả tim cho món Gà hấp hành thơm ngon của bạn!',0,'2026-11-05 21:30:00'),(42,1,2,'comment',32,'vừa bình luận về món Lòng heo xào cải chua: \"Lòng giòn sần sật không hề hôi đắng...\"',1,'2026-11-05 14:30:00'),(43,1,5,'like',34,'vừa thả tim cho món Thịt lợn chiên xù giòn tan của bạn!',1,'2026-11-05 17:00:00'),(44,2,1,'like',1,'vừa thả tim cho món Bò xào hành tây cần tây của bạn!',0,'2026-11-05 16:00:00'),(45,5,1,'like',8,'vừa thả tim cho món Sườn xào chua ngọt của bạn!',0,'2026-11-05 16:15:00'),(46,6,1,'like',7,'vừa thả tim cho món Phở bò Hà Nội gia truyền của bạn!',0,'2026-11-05 16:30:00'),(47,7,1,'like',9,'vừa thả tim cho món Thịt kho tàu nước dừa của bạn!',0,'2026-11-05 16:45:00'),(48,9,1,'like',11,'vừa thả tim cho món Salad ức gà sốt mè rang của bạn!',0,'2026-11-05 17:00:00');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_likes`
--

DROP TABLE IF EXISTS `recipe_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `recipe_likes` (
  `recipe_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`recipe_id`,`user_id`),
  KEY `idx_rl_user` (`user_id`),
  CONSTRAINT `fk_rl_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rl_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_likes`
--

LOCK TABLES `recipe_likes` WRITE;
/*!40000 ALTER TABLE `recipe_likes` DISABLE KEYS */;
INSERT INTO `recipe_likes` VALUES (1,1,'2026-11-03 14:00:00'),(1,4,'2026-11-03 15:30:00'),(1,5,'2026-11-03 18:20:00'),(1,7,'2026-11-04 09:10:00'),(2,1,'2026-11-03 14:30:00'),(2,4,'2026-11-03 16:00:00'),(2,5,'2026-11-03 19:00:00'),(3,1,'2026-11-03 15:00:00'),(3,5,'2026-11-03 20:00:00'),(3,6,'2026-11-04 08:30:00'),(4,1,'2026-11-03 15:45:00'),(4,4,'2026-11-03 17:15:00'),(4,7,'2026-11-04 10:00:00'),(7,1,'2026-11-03 16:20:00'),(7,2,'2026-11-03 18:00:00'),(7,4,'2026-11-03 19:30:00'),(7,5,'2026-11-03 21:00:00'),(7,7,'2026-11-04 11:15:00'),(8,1,'2026-11-03 17:00:00'),(8,2,'2026-11-03 18:45:00'),(8,6,'2026-11-03 20:15:00'),(8,8,'2026-11-04 09:40:00'),(8,9,'2026-11-04 14:20:00'),(9,1,'2026-11-03 17:30:00'),(9,2,'2026-11-03 19:10:00'),(9,5,'2026-11-03 21:40:00'),(9,6,'2026-11-04 10:30:00'),(10,1,'2026-11-03 18:15:00'),(10,2,'2026-11-03 20:00:00'),(10,5,'2026-11-04 08:15:00'),(10,6,'2026-11-04 12:40:00'),(11,1,'2026-11-03 19:00:00'),(11,2,'2026-11-03 20:45:00'),(11,5,'2026-11-04 09:00:00'),(11,8,'2026-11-04 15:10:00'),(12,1,'2026-11-03 19:30:00'),(12,4,'2026-11-03 21:15:00'),(12,9,'2026-11-04 11:00:00'),(13,1,'2026-11-03 20:00:00'),(13,5,'2026-11-04 07:30:00'),(13,7,'2026-11-04 13:15:00'),(14,1,'2026-11-03 20:30:00'),(14,6,'2026-11-04 08:45:00'),(14,7,'2026-11-04 14:00:00'),(15,1,'2026-11-03 21:00:00'),(15,2,'2026-11-04 09:20:00'),(15,4,'2026-11-04 12:00:00'),(15,6,'2026-11-04 15:30:00'),(16,1,'2026-11-03 21:30:00'),(16,2,'2026-11-04 10:10:00'),(16,4,'2026-11-04 13:40:00'),(17,1,'2026-11-03 22:00:00'),(17,2,'2026-11-04 11:00:00'),(17,5,'2026-11-04 16:15:00'),(18,1,'2026-11-04 07:30:00'),(18,7,'2026-11-04 12:20:00'),(21,1,'2026-11-04 08:15:00'),(21,6,'2026-11-04 14:30:00'),(21,9,'2026-11-04 17:00:00'),(24,1,'2026-11-04 09:00:00'),(24,5,'2026-11-04 13:50:00'),(24,7,'2026-11-04 18:10:00'),(25,2,'2026-11-04 10:15:00'),(25,4,'2026-11-04 11:20:00'),(25,5,'2026-11-04 14:05:00'),(25,6,'2026-11-04 16:30:00'),(25,7,'2026-11-04 18:45:00'),(25,8,'2026-11-05 08:10:00'),(25,9,'2026-11-05 12:25:00'),(26,2,'2026-11-04 11:00:00'),(26,5,'2026-11-04 13:40:00'),(26,6,'2026-11-04 17:15:00'),(26,7,'2026-11-04 19:30:00'),(26,8,'2026-11-05 09:00:00'),(26,9,'2026-11-05 14:10:00'),(27,2,'2026-11-04 12:30:00'),(27,4,'2026-11-04 15:20:00'),(27,5,'2026-11-04 18:00:00'),(27,7,'2026-11-04 20:15:00'),(27,8,'2026-11-05 10:05:00'),(27,9,'2026-11-05 15:40:00'),(28,4,'2026-11-04 09:30:00'),(28,5,'2026-11-04 14:45:00'),(28,6,'2026-11-04 18:20:00'),(28,8,'2026-11-05 08:50:00'),(28,9,'2026-11-05 11:15:00'),(29,2,'2026-11-04 10:45:00'),(29,5,'2026-11-04 16:10:00'),(29,6,'2026-11-04 19:00:00'),(29,7,'2026-11-05 07:45:00'),(29,8,'2026-11-05 13:20:00'),(30,2,'2026-11-04 11:30:00'),(30,4,'2026-11-04 14:15:00'),(30,5,'2026-11-04 17:40:00'),(30,6,'2026-11-04 20:05:00'),(30,7,'2026-11-05 09:30:00'),(30,9,'2026-11-05 16:00:00'),(31,2,'2026-11-04 13:00:00'),(31,4,'2026-11-04 16:40:00'),(31,5,'2026-11-04 19:20:00'),(31,7,'2026-11-05 10:15:00'),(32,2,'2026-11-04 14:20:00'),(32,5,'2026-11-04 18:35:00'),(32,6,'2026-11-04 21:00:00'),(32,7,'2026-11-05 08:30:00'),(32,8,'2026-11-05 14:45:00'),(33,4,'2026-11-04 15:10:00'),(33,5,'2026-11-04 19:40:00'),(33,7,'2026-11-05 09:15:00'),(33,8,'2026-11-05 15:30:00'),(34,2,'2026-11-04 10:00:00'),(34,4,'2026-11-04 13:20:00'),(34,5,'2026-11-04 17:00:00'),(34,6,'2026-11-04 20:30:00'),(34,8,'2026-11-05 11:40:00'),(34,9,'2026-11-05 16:50:00'),(35,2,'2026-11-04 12:00:00'),(35,5,'2026-11-04 15:50:00'),(35,6,'2026-11-04 19:15:00'),(35,7,'2026-11-05 10:30:00'),(35,9,'2026-11-05 17:20:00');
/*!40000 ALTER TABLE `recipe_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `recipes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'Món chính',
  `cooking_time` varchar(50) NOT NULL DEFAULT '30 phút',
  `servings` varchar(50) NOT NULL DEFAULT '2 - 4 người',
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `tips` text DEFAULT NULL,
  `calories` int(10) unsigned DEFAULT NULL,
  `protein` int(10) unsigned DEFAULT NULL,
  `carbs` int(10) unsigned DEFAULT NULL,
  `fat` int(10) unsigned DEFAULT NULL,
  `dietary_tags` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `views_count` int(10) unsigned NOT NULL DEFAULT 0,
  `likes_count` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_recipes_status` (`status`),
  KEY `idx_recipes_author` (`author_id`),
  KEY `idx_recipes_category` (`category`),
  CONSTRAINT `fk_recipes_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipes`
--

LOCK TABLES `recipes` WRITE;
/*!40000 ALTER TABLE `recipes` DISABLE KEYS */;
INSERT INTO `recipes` VALUES (1,'Bò xào hành tây cần tây','Món xào thơm lừng, thịt bò mềm ngọt kết hợp cùng hành tây giòn ngọt.','Món xào','20 phút','3 - 4 người','Thịt bò\nHành tây\nTỏi\nDầu ăn\nTiêu','1. Ướp thịt bò với tỏi băm, tiêu, hạt nêm trong 15 phút.\n2. Phi thơm tỏi với dầu ăn trên lửa lớn.\n3. Cho thịt bò vào xào nhanh chín tới rồi trút ra đĩa.\n4. Xào hành tây vừa chín, trút thịt bò vào đảo đều rồi tắt bếp.','Nên chọn thịt bò phi-lê mềm, thái ngang thớ mỏng. Khi xào bật lửa lớn đảo nhanh tay trong 2-3 phút thịt sẽ mềm ngọt không bị dai.',340,32,8,18,'Giàu Protein, Ít Calo, Nhanh < 30p, Đậm Đà','assets/images/real_dishes/bo-xao-hanh-tay.jpg',2,'approved',264,4,'2026-09-09 18:06:10','2026-11-05 18:24:14'),(2,'Trứng chiên cà chua hành hoa','Món ăn gia đình nhanh gọn, vị chua ngọt thanh nhẹ.','Món chiên','15 phút','2 người','Trứng\nCà chua\nHành tây\nTỏi\nRau xanh','1. Đập trứng vào bát, nêm một chút nước mắm và hạt nêm rồi đánh tan.\n2. Phi thơm tỏi, xào cà chua cho mềm nát tạo sốt.\n3. Đổ trứng vào chảo, đảo nhẹ để trứng quyện đều cùng cà chua.\n4. Rắc hành hoa và tiêu lên trên rồi thưởng thức nóng.','Cho một thìa cà phê nước lọc hoặc chút mayonnaise vào đánh cùng trứng để khi chiên trứng bông xốp và mềm thơm hơn.',450,28,56,12,'Giàu Protein, Truyền Thống, Nóng Hổi','assets/images/real_dishes/trung-chien-ca-chua.jpg',2,'approved',205,3,'2026-09-09 18:06:10','2026-11-05 18:13:12'),(3,'Thịt gà hấp lá chanh','Gà giữ trọn độ ngọt tự nhiên, thơm thoang thoảng mùi lá chanh tươi.','Món hấp','35 phút','4 người','Thịt gà\nTỏi\nMuối\nTiêu','1. Gà làm sạch, xát muối và tiêu đều khắp mình gà.\n2. Xếp lá chanh xuống đáy xửng hấp và phủ một lớp lên trên gà.\n3. Hấp gà trong khoảng 25-30 phút cho đến khi chín tới.\n4. Để nguội bớt, chặt miếng vừa ăn và chấm muối tiêu chanh.','Ướp gà với chút gừng đập dập và rượu trắng trước khi hấp giúp thịt gà thơm nức, da giòn sần sật vàng óng.',270,22,14,11,'Cay Nồng, Ấm Bụng, Dưới 30p','assets/images/real_dishes/ga-hap-la-chanh.jpg',2,'approved',341,3,'2026-09-09 18:06:10','2026-11-05 18:24:14'),(4,'Canh thịt bò nấu rau xanh thanh mát','Canh giải nhiệt bổ dưỡng cho bữa cơm trưa gia đình.','Món canh','25 phút','3 - 4 người','Thịt bò\nRau xanh\nTỏi\nGia vị','1. Thịt bò băm hoặc thái mỏng, ướp sơ gia vị.\n2. Rau xanh rửa sạch, cắt khúc vừa ăn.\n3. Phi tỏi băm, xào sơ thịt bò rồi cho nước sôi vào nấu.\n4. Thả rau xanh vào đun sôi bùng, nêm nếm lại rồi tắt bếp.','Cà chua nên xào chín nhừ để tạo màu đỏ tự nhiên đẹp mắt cho nước dùng canh, nêm thêm chút rau ngổ và ngò gai khi tắt bếp.',290,18,28,9,'Eat Clean, Bổ Dưỡng, Dễ Nấu, Cho Bé','assets/images/real_dishes/canh-bo-rau-xanh.jpg',2,'approved',154,3,'2026-09-09 18:06:10','2026-11-05 18:24:14'),(7,'Phở bò Hà Nội gia truyền','Món phở bò mang đậm hương vị phố cổ Hà Nội. Nước dùng ninh từ xương bò ngọt thanh tự nhiên, thoang thoảng mùi hoa hồi, thảo quả, quế và gừng nướng thơm nức mũi.','Món canh','45 phút','4 - 5 người','500g Bánh phở tươi\n400g Bắp bò hoặc nạm bò tươi\n1kg Xương ống bò (ninh lấy nước dùng)\n1 củ Gừng tươi, 3 củ Hành khô nướng thơm\n2 hoa Hồi, 1 thanh Quế, 1 quả Thảo quả\nHành hoa, rau mùi, húng láng, chanh ớt\nGia vị: Mắm cốt ngon, hạt nêm, đường phèn','1. Xương bò rửa sạch, luộc sơ nước đầu rồi rửa lại nước lạnh cho thật sạch để nước dùng trong.\n2. Cho xương vào nồi ninh với 3 lít nước, thả gừng nướng, hành khô nướng và gói thảo mộc hồi quế đã rang thơm vào.\n3. Ninh nhỏ lửa 1.5 - 2 tiếng, hớt bọt thường xuyên, nêm nước mắm ngon và chút đường phèn cho ngọt thanh.\n4. Thịt bắp bò thái thật mỏng ngang thớ. Chần bánh phở qua nước sôi xếp vào tô.\n5. Xếp thịt bò, hành hoa, mùi tàu lên trên rồi chan nước dùng thật sôi. Ăn kèm quẩy nóng và giấm tỏi ớt.','Bí quyết nước dùng trong: không đậy vung khi sôi lớn và luôn hớt sạch bọt. Hành khô và gừng phải nướng xém vỏ cạo sạch mới dậy mùi thơm đặc trưng.',460,32,58,12,'Truyền Thống, Giàu Protein, Món Tủ Gia Đình, Ấm Bụng','assets/images/real_dishes/pho-bo.jpg',6,'approved',3560,5,'2026-09-11 13:46:57','2026-11-05 18:24:14'),(8,'Sườn xào chua ngọt chuẩn vị cơm mẹ nấu','Món sườn xào chua ngọt óng ả màu cánh gián, thịt sườn mềm róc xương, sốt chua thanh cay ngọt quyện đều từng miếng khiến cả nhà ăn hết bay nồi cơm.','Món xào','25 phút','3 - 4 người','600g Sườn non heo (chọn dẻ sườn nhỏ, nạc mềm)\n2 thìa Nước mắm cốt truyền thống\n2 thìa Giấm gạo hoặc nước cốt chanh\n2 thìa Đường vàng\n1 thìa Tương ớt Chin-su\n3 tép Tỏi băm, 2 củ Hành tím băm\nHành lá cắt khúc, tiêu xay, ớt tươi','1. Sườn non chặt khúc vừa ăn, chần qua nước sôi có chút muối và gừng đập dập rồi rửa sạch để ráo.\n2. Ướp sườn với 1 thìa hạt nêm, chút tiêu trong 15 phút. Rán sơ cho vàng đều 2 mặt.\n3. Pha nước sốt thần thánh: 2 thìa mắm, 2 thìa đường, 2 thìa giấm, 1 thìa tương ớt, 4 thìa nước lọc khuấy tan.\n4. Phi thơm hành tỏi băm, trút sườn vào rồi đổ bát nước sốt vào đảo đều trên lửa vừa.\n5. Đun liu riu cho đến khi nước sốt sệt lại, áo đều một lớp màu hổ phách óng ánh quanh miếng sườn thì rắc hành lá và tắt bếp.','Pha tỷ lệ nước sốt 2 mắm : 2 đường : 2 chua : 1 cay là công thức bất bại. Dùng đường vàng hoặc chút dầu màu điều giúp màu sắc bắt mắt tự nhiên không cần phẩm màu.',520,28,22,36,'Đậm Đà, Bắt Cơm, Món Tủ Gia Đình, Dễ Nấu','assets/images/real_dishes/suon-xao-chua-ngot.jpg',5,'approved',3022,5,'2026-09-11 13:46:57','2026-11-05 18:24:14'),(9,'Thịt kho tàu nước dừa trứng cút','Món thịt kho tàu truyền thống mềm tan trong miệng, mỡ trong veo, nạc ngọt đậm đà hòa quyện cùng trứng cút thấm vị và nước dừa xiêm ngọt lịm.','Món kho','40 phút','4 - 5 người','600g Thịt ba chỉ hoặc thịt mông heo\n15 - 20 quả Trứng cút luộc bóc vỏ\n1 quả Dừa xiêm lấy nước tươi (khoảng 350ml)\n3 củ Hành tím, 4 tép Tỏi đập dập\nGia vị: Nước mắm nhĩ, đường thắng nước màu, tiêu, ớt hiểm','1. Thịt heo rửa sạch với nước muối, thái miếng vuông con cờ khoảng 3 - 4cm.\n2. Ướp thịt với tỏi ớt băm, 3 thìa nước mắm ngon, 1 thìa đường, tiêu và nước hàng trong 30 phút.\n3. Cho thịt lên bếp xào săn để miếng mỡ trong lại, sau đó đổ toàn bộ nước dừa xiêm ngập mặt thịt.\n4. Đun sôi rồi hạ lửa nhỏ liu riu, hớt bọt. Khi thịt chín mềm thì thả trứng cút vào kho cùng.\n5. Kho thêm 15 - 20 phút cho nước cạn bớt, sánh sệt và có màu cánh gián tuyệt đẹp là hoàn thành.','Không nên đậy nắp vung kín khi kho bằng nước dừa để nước kho được trong và mỡ heo có độ trong veo bóng bẩy.',580,30,18,44,'Truyền Thống, Đậm Đà, Bắt Cơm, Món Tết','assets/images/real_dishes/thit-kho-tau.jpg',7,'approved',3223,4,'2026-09-11 13:46:57','2026-11-05 18:24:14'),(10,'Canh chua cá lóc rau nhút bông điên điển','Tô canh chua miền Tây đúng điệu giải nhiệt ngày oi bức. Thịt cá lóc đồng ngọt thơm, vị chua thanh từ me chín, giòn sần sật của dọc mùng, giá đỗ và mùi thơm ngát của ngò om ngò gai.','Món canh','20 phút','4 người','1 con Cá lóc đồng (khoảng 600g) cắt khúc\n2 quả Cà chua, 1/4 quả Dứa chín\n1 nắm Rau nhút, 100g Giá đỗ, 2 cây Dọc mùng (bạc hà)\n1 vắt Me chín chua\nRau nêm: Ngò om, ngò gai, tỏi phi vàng, ớt lát\nGia vị: Nước mắm ngon, muối, đường cát','1. Cá lóc làm sạch nhớt bằng muối và chanh, rửa sạch cắt khúc.\n2. Me dầm với nước sôi lấy nước cốt chua.\n3. Đun sôi nồi nước (khoảng 1.2 lít), cho nước cốt me và dứa vào nấu sôi, nêm mắm đường hơi đậm một chút.\n4. Thả từng khúc cá vào nấu chín tới, vớt bọt liên tục để nước canh trong.\n5. Cho cà chua, dọc mùng, rau nhút và giá đỗ vào đun sôi bùng lên rồi tắt bếp ngay.\n6. Múc ra tô, rắc ngò om, ngò gai thái nhỏ và một thìa tỏi phi thơm lừng lên trên.','Phải cho cá vào khi nước thật sôi và không đảo mạnh tay để thịt cá không bị tanh và nát. Tỏi phi vàng rắc lên trên là linh hồn của món canh chua miền Tây.',280,34,24,6,'Thanh Mát, Ít Calo, Giàu Protein, Giải Nhiệt','assets/images/real_dishes/canh-chua-ca-loc.jpg',7,'approved',2272,4,'2026-09-11 13:46:57','2026-11-05 18:24:14'),(11,'Salad ức gà sốt mè rang Eat Clean','Món ăn chân ái cho người giảm cân, Eat Clean hoặc tập gym. Ức gà áp chảo mềm mọng nước không hề bị khô xác, kết hợp rau xà lách thủy canh tươi giòn và sốt mè rang bùi béo.','Món chay','12 phút','2 người','250g Ức gà tươi phi lê\n1 cây Xà lách Romaine hoặc xà lách mỡ\n1 củ Dưa leo baby, 8 quả Cà chua bi\n1/2 bắp Ngô ngọt luộc tách hạt\n1 quả Trứng gà luộc lòng đào\nSốt mè rang Kewpie (hoặc tự làm từ mè trắng rang, sữa chua Hy Lạp, dầu oliu)\nGia vị ướp gà: Muối hồng, tiêu đen, tỏi ớt bột Paprika','1. Ức gà khía nhẹ mặt, ướp với chút muối hồng, tiêu xay và bột tỏi trong 10 phút.\n2. Làm nóng chảo chống dính với 1 thìa cà phê dầu oliu, áp chảo ức gà mỗi mặt 4 - 5 phút ở lửa vừa cho chín vàng thơm.\n3. Để ức gà nghỉ 3 phút rồi thái lát dày khoảng 1cm (thịt sẽ giữ trọn nước ngọt mềm).\n4. Rau xà lách rửa sạch vẩy ráo nước cắt khúc vừa ăn, dưa leo thái lát, cà chua bi bổ đôi.\n5. Xếp rau củ ra đĩa sâu lòng, xếp ức gà và trứng lòng đào lên trên, rưới sốt mè rang thơm phức và thưởng thức.','Sau khi áp chảo, nhất định phải để thịt nghỉ 3 phút trước khi thái. Nếu thái ngay khi vừa nhấc khỏi chảo, nước ngọt trong thịt sẽ chảy hết ra ngoài khiến ức gà bị khô xác.',295,38,16,9,'Eat Clean, Giàu Protein, Ít Calo, Nhanh < 15p, Low-Carb','assets/images/real_dishes/salad-uc-ga.jpg',9,'approved',2902,4,'2026-09-11 13:46:57','2026-11-05 18:24:14'),(12,'Bánh mì chảo xíu mại trứng ốp la','Bữa sáng cấp tốc, giàu năng lượng cho ngày mới tràn đầy sức sống. Viên xíu mại thịt heo mềm thơm đượm sốt cà chua sền sệt, trứng ốp lòng đào béo ngậy chấm cùng bánh mì nóng giòn rụm.','Món chiên','15 phút','2 người','2 ổ Bánh mì giòn\n2 quả Trứng gà tươi\n150g Thịt heo băm nhỏ viên xíu mại\n1 cây Xúc xích heo hoặc phô mai con bò cười\n2 quả Cà chua băm nhuyễn tạo sốt\nBơ Tường An, pate gan, dưa leo, hành ngò, tiêu xay','1. Thịt băm trộn hành tây thái hạt lựu, nêm chút hạt nêm, tiêu rồi viên tròn đem hấp sơ 5 phút.\n2. Làm sốt cà chua: Phi tỏi băm thơm, cho cà chua băm vào xào mềm nhuyễn, nêm xíu dầu hào và đường cho sốt sánh đỏ.\n3. Dùng chảo gang hoặc chảo nhỏ, đun chảy 1 thìa bơ, đập 2 quả trứng gà vào làm trứng ốp la lòng đào.\n4. Thả xúc xích khía nhẹ, xíu mại, 1 thìa pate gan vào chảo, rưới sốt cà chua nóng hổi lên.\n5. Rắc tiêu xay, ớt tỉa hoa và vài nhánh ngò rí. Dọn chảo lên bàn cùng bánh mì nóng giòn chấm ăn liền.','Ăn ngay khi chảo còn xèo xèo nóng hổi là ngon nhất. Dùng bánh mì vừa nướng lại trong nồi chiên không dầu 3 phút để bánh siêu giòn.',510,24,45,26,'Nhanh < 15p, Bữa Sáng, Béo Ngậy, Giàu Năng Lượng','assets/images/real_dishes/banh-mi-chao.jpg',8,'approved',2090,3,'2026-09-11 13:46:57','2026-11-05 18:24:14'),(13,'Cá bống kho tiêu gừng nồi đất','Hương vị đồng quê gợi nhớ bữa cơm chiều ngày mưa của mẹ. Từng con cá bống săn chắc, ngấm vị cay ấm nồng nàn của hạt tiêu sọ và gừng tươi thái sợi, ăn cùng cơm trắng nóng hổi thì không gì sánh bằng.','Món kho','30 phút','3 - 4 người','400g Cá bống tươi sống\n1 nhánh Gừng tươi thái sợi mỏng\n2 thìa Hạt tiêu sọ đập dập\n3 củ Hành tím, 2 tép Tỏi\n3 thìa Nước mắm truyền thống thơm ngon\n1 thìa Nước màu dừa, 1 thìa Mỡ heo (hoặc dầu ăn)\n2 quả Ớt hiểm đỏ, hành lá','1. Cá bống làm sạch vảy, xát muối cho hết nhớt rồi rửa sạch để thật ráo nước.\n2. Ướp cá với gừng thái sợi, tiêu đập dập, nước mắm, đường, nước màu dừa trong nồi đất khoảng 20 phút.\n3. Đặt nồi đất lên bếp đun lửa lớn cho cá sôi bùng lên và thịt cá bắt đầu săn chắc lại.\n4. Hạ lửa nhỏ nhất, đậy hé vung kho liu riu cho cá thấm đều gia vị và ngả màu nâu cánh gián óng ả.\n5. Khi nước kho sánh cạn lại, rưới 1 thìa mỡ heo lên mặt cá, rắc thêm thật nhiều tiêu xay và ớt hiểm rồi tắt bếp.','Kho bằng nồi đất và dùng mỡ heo thay dầu ăn sẽ làm cá bống thơm ngậy đặc biệt, thịt cá săn chắc không bị vỡ nát.',320,32,12,16,'Truyền Thống, Cay Nồng, Ấm Bụng, Bắt Cơm','assets/images/real_dishes/ca-bong-kho-tieu.jpg',6,'approved',1744,3,'2026-09-11 13:46:57','2026-11-05 18:24:14'),(14,'Nộm hoa chuối tai heo giòn sần sật','Món nộm dân dã chống ngấy tuyệt vời trong mâm cơm hoặc bữa tiệc gia đình. Hoa chuối trắng nõn giòn sần sật quyện tai heo luộc giòn, vị chua cay mặn ngọt hài hòa rắc thêm đậu phộng rang thơm bùi.','Món xào','20 phút','4 người','1 cái Tai heo làm sạch\n1 cái Bắp hoa chuối tây bào mỏng\n1 củ Cà rốt bào sợi\n100g Đậu phộng (lạc) rang giã dập\nRau thơm: Kinh giới, rau húng bạc hà, mùi tàu\nNước mắm pha nộm: 3 thìa mắm, 2 thìa chanh, 2 thìa đường, tỏi ớt băm nhuyễn','1. Hoa chuối bào mỏng ngâm ngay vào chậu nước có pha nước cốt chanh và chút muối để hoa chuối không bị thâm đen, sau đó vớt ra vẩy ráo.\n2. Tai heo luộc chín cùng chút giấm và gừng, vớt ra ngâm ngay vào tô nước đá lạnh 10 phút để tai heo giòn trắng rồi thái lát mỏng dài.\n3. Pha nước trộn nộm: Khuấy tan nước cốt chanh, đường, nước mắm ngon, tỏi ớt băm nhuyễn sao cho có vị chua ngọt đậm đà.\n4. Cho hoa chuối, cà rốt bào, tai heo vào thau lớn, rưới 2/3 lượng nước sốt vào bóp nhẹ tay cho ngấm gia vị trong 5 phút.\n5. Chắt bớt nước tiết ra, cho rau thơm thái nhỏ và phần nước sốt còn lại vào trộn đều.\n6. Bày ra đĩa, rắc đậu phộng rang vàng giã dập lên trên cùng.','Ngâm tai heo vừa luộc vào nước đá lạnh là bí quyết giúp tai heo giữ trọn độ giòn sần sật, không bị nhớt hay mềm nhũn.',260,22,18,11,'Thanh Mát, Khai Vị, Giòn Rụm, Dễ Nấu','assets/images/real_dishes/nom-hoa-chuoi.jpg',5,'approved',2382,3,'2026-09-11 13:46:57','2026-11-05 18:24:14'),(15,'Bún chả Hà Nội nướng than hoa','Món ăn làm say lòng bất kỳ ai từng ghé thăm Hà Nội. Chả băm và chả miếng nướng xém than hoa thơm nức mũi, thả vào bát nước mắm chua ngọt ấm nóng ăn cùng bún tươi và rau sống thanh mát.','Món chính','35 phút','4 người','500g Thịt ba chỉ thái lát mỏng (làm chả miếng)\n400g Thịt nạc vai băm nhỏ (làm chả viên)\n1kg Bún tươi sợi nhỏ\n1 củ Su hào hoặc đu đủ xanh, 1 củ Cà rốt làm dưa góp\nRau sống: Xà lách, kinh giới, tía tô, húng láng\nGia vị ướp thịt: Nước hàng, hành khô băm, nước mắm ngon, dầu hào, tiêu, đường\nNước mắm chấm: 1 mắm : 1 đường : 1 giấm : 5 nước ấm, tỏi ớt băm','1. Ướp chả miếng và chả viên riêng trong 30 phút với hành tỏi băm, nước mắm, nước hàng, dầu hào và chút tiêu.\n2. Viên chả băm thành từng viên tròn dẹt vừa ăn. Kẹp chả vào vỉ nướng trên than hoa đỏ rực (hoặc nướng nồi chiên không dầu 180°C trong 15 phút) cho đến khi vàng xém thơm lừng.\n3. Su hào cà rốt thái mỏng bóp muối, rửa sạch rồi ngâm chua ngọt làm dưa góp giòn sần sật.\n4. Pha nước mắm chấm chua ngọt đun ấm nhẹ, thả dưa góp vào cùng vài lát ớt tươi.\n5. Xếp bún tươi, rau sống ra mẹt, múc chả nóng vào tô nước chấm và thưởng thức.','Để chả viên mềm mọng nước không bị khô, nên chọn thịt nạc vai có chút mỡ giắt và trộn thêm 1 thìa dầu ăn vào thịt băm trước khi viên.',540,32,65,18,'Đặc Sản Hà Nội, Bắt Vị, Món Tủ Gia Đình, Truyền Thống','assets/images/real_dishes/bun-cha-ha-noi.jpg',5,'approved',4005,4,'2026-09-11 14:31:25','2026-11-05 18:24:14'),(16,'Bánh xèo miền Tây vàng giòn tôm thịt','Bánh xèo miền Tây chuẩn vị vỏ mỏng vàng ươm giòn rụm, thơm béo nước cốt dừa và thoang thoảng mùi bột nghệ. Nhân ngập tràn tôm sông tươi ngọt, thịt ba chỉ xào và giá đỗ cuốn bánh tráng rau rừng chấm mắm chua ngọt cay xè.','Món chiên','30 phút','4 - 5 người','400g Bột bánh xèo Hương Xưa pha sẵn (hoặc bột gạo)\n1 lon Nước cốt dừa (khoảng 200ml)\n1 thìa Bột nghệ tạo màu vàng ươm\n300g Tôm sông tươi rửa sạch cắt râu\n300g Thịt ba rọi thái lát mỏng\n200g Giá đỗ, 1 củ Hành tây thái mỏng, hành lá cắt nhỏ\nRau ăn kèm: Cải bẹ xanh, xà lách, rau diếp cá, đọt cóc, lá xoài non\nNước mắm tỏi ớt chua ngọt cà rốt bào sợi','1. Khuấy tan bột bánh xèo với nước cốt dừa, 600ml nước lọc, bột nghệ, hành lá cắt nhỏ và chút bia (bí quyết giúp vỏ giòn lâu).\n2. Xào sơ tôm thịt trên chảo với chút hạt nêm và tiêu cho vừa chín tới.\n3. Dùng chảo chống dính sâu lòng, đun nóng thật nóng với 1 thìa dầu ăn. Múc 1 muôi bột tráng thật mỏng đều khắp lòng chảo (nghe tiếng xèo thật to).\n4. Xếp tôm, thịt, hành tây và giá đỗ lên một nửa mặt bánh. Đậy vung 2 phút ở lửa vừa cho bánh chín giòn.\n5. Mở vung, đun thêm 1 phút cho viền bánh róc và giòn tan, gập đôi bánh lại trút ra đĩa thưởng thức nóng.','Thêm 1 chén bia nhỏ vào thau bột pha là bí quyết gia truyền giúp vỏ bánh xèo giòn rụm từ lúc mới đổ cho đến khi ăn xong mà không bị ỉu.',480,26,54,20,'Đặc Sản Nam Bộ, Giòn Rụm, Món Ăn Chơi, Cuối Tuần','assets/images/real_dishes/banh-xeo-mien-tay.jpg',7,'approved',3054,3,'2026-09-11 14:31:25','2026-11-05 18:24:14'),(17,'Nem rán truyền thống giòn rụm','Món nem rán (chả giò) không thể thiếu trong mâm cỗ Tết và bữa cơm sum họp gia đình Việt. Vỏ bánh đa nem giòn tan rụm rụm, nhân thịt mộc nhĩ nấm hương miến dong ngọt bùi đượm vị.','Món chiên','30 phút','4 - 6 người','400g Thịt nạc vai xay nhuyễn\n1 tập Bánh đa nem loại ngon hoặc vỏ ram Hà Tĩnh\n50g Miến dong ngâm mềm cắt khúc ngắn\n3 tai Mộc nhĩ, 5 tai Nấm hương ngâm nở băm nhỏ\n1 củ Cà rốt, 1/2 củ Su hào bào sợi vắt bớt nước\n2 quả Trứng gà tươi\nHành hoa, rau mùi ta, tiêu bắc xay, hạt nêm, nước mắm','1. Trộn đều thịt xay, miến, mộc nhĩ, nấm hương, cà rốt, hành mùi với 2 lòng đỏ trứng và gia vị. Không trộn quá nhiều trứng để nhân không bị ướt làm rách vỏ.\n2. Trải vỏ bánh đa nem ra đĩa, múc 1 thìa nhân vào giữa rồi cuộn chặt vừa tay.\n3. Đun sôi dầu ăn ngập nửa chiếc nem trên lửa vừa. Thả từng chiếc nem vào rán ngập dầu.\n4. Rán 2 lần lửa: Lần 1 rán chín tới vớt ra để ráo dầu; Lần 2 khi chuẩn bị ăn bật lửa lớn rán nhanh cho vỏ nem vàng giòn rụm.\n5. Cắt đôi bày ra đĩa ăn kèm bún tươi, rau sống và nước chấm dưa góp chua ngọt.','Rán 2 lần lửa và vắt kiệt nước các loại củ (cà rốt, su hào) là bí kíp giúp vỏ nem giòn rụm đến 4 - 5 tiếng đồng hồ không lo bị ỉu mềm.',420,24,38,22,'Truyền Thống, Món Cỗ Ngày Lễ, Giòn Tan, Sum Họp','assets/images/real_dishes/nem-ran-truyen-thong.jpg',6,'approved',3429,3,'2026-09-11 14:31:25','2026-11-05 18:24:14'),(18,'Mực xào sa tế cay nồng giòn ngọt','Món xào nóng hổi cay nồng cực bén cơm và phù hợp cho những bữa tiệc lai rai cuối tuần. Mực tươi xào lửa lớn giữ trọn độ giòn sần sật ngọt lịm, quyện sốt sa tế thơm lừng tỏi ớt và rau củ tươi.','Món xào','15 phút','3 - 4 người','500g Mực ống tươi sống làm sạch khía vảy rồng\n2 thìa Sa tế tôm cay thơm\n1 quả Ớt chuông đỏ, 1 quả Ớt chuông xanh thái miếng\n1 củ Hành tây thái múi cau, 2 nhánh Cần tây cắt khúc\n3 tép Tỏi băm, 1 củ Gừng tươi thái chỉ\nGia vị: Dầu hào Maggi, nước mắm, tiêu sọ, hạt nêm','1. Mực làm sạch khía vảy rồng, chần nhanh qua nước sôi có gừng đập dập 30 giây rồi vớt ra ngâm nước đá cho mực giòn trắng.\n2. Phi thơm tỏi băm với dầu ăn trên lửa lớn, cho 2 thìa sa tế tôm vào đảo đều dậy mùi thơm đỏ óng.\n3. Trút mực vào xào thật nhanh tay ở lửa lớn trong 1 - 2 phút rồi trút ra đĩa riêng.\n4. Cho ớt chuông, hành tây, cần tây vào xào vừa chín tới, nêm dầu hào và nước mắm vừa ăn.\n5. Trút mực trở lại đảo đều 30 giây cho ngấm sốt rồi rắc tiêu sọ tắt bếp ngay.','Mực chỉ xào trên lửa thật lớn và không xào quá lâu (dưới 3 phút) để mực giữ được độ giòn ngọt mọng nước mà không bị teo dai và ra nước.',310,36,14,12,'Nhanh < 15p, Cay Nồng, Giàu Protein, Món Nhậu','assets/images/real_dishes/muc-xao-sa-te.jpg',8,'approved',2541,2,'2026-09-11 14:31:25','2026-11-05 18:24:14'),(19,'Tôm rim thịt ba chỉ cháy cạnh','Món tôm rim thịt ba chỉ cháy cạnh chuẩn vị quê nhà, thịt ba chỉ béo ngậy được rang xém cạnh giòn thơm, hòa quyện cùng tôm đồng giòn ngọt đậm đà nước mắm kẹo bóng mượt.','Món kho','25 phút','4','- 300g tôm tươi (cắt râu, rửa sạch ráo nước)\n- 350g thịt ba chỉ lợn (thái con chì vừa ăn)\n- 3 củ hành khô băm nhỏ\n- 3 tép tỏi băm nhuyễn\n- 2 quả ớt hiểm thái lát\n- 2 nhánh hành lá cắt khúc\n- Gia vị: 2 thìa nước mắm ngon, 1.5 thìa đường thốt nốt, 1 thìa dầu hào, 1/2 thìa tiêu xay, 1/2 thìa hạt nêm','Bước 1: Sơ chế tôm rửa sạch với nước muối loãng, cắt bớt râu và đầu nhọn. Thịt ba chỉ rửa sạch, thái miếng mỏng vừa ăn.\nBước 2: Cho thịt ba chỉ vào chảo nóng, đảo đều với lửa vừa cho thịt tiết bớt mỡ và xém cạnh vàng giòn hai mặt. Gạn bớt mỡ thừa ra chén.\nBước 3: Phi thơm hành tỏi băm trong chảo thịt, sau đó cho tôm vào đảo đều tay trên lửa lớn đến khi vỏ tôm chuyển màu đỏ au cong tròn.\nBước 4: Hạ lửa vừa, rưới hỗn hợp nước mắm, đường thốt nốt, dầu hào và hạt nêm vào rim. Đảo đều cho nước sốt ngấm sâu, sánh đặc và óng màu cánh gián.\nBước 5: Thêm ớt hiểm, hành lá và rắc hạt tiêu xay thơm nức mũi. Tắt bếp và múc ra đĩa ăn kèm cơm nóng dẻo.',NULL,460,NULL,NULL,NULL,'Món mặn, Tốn cơm, Gia đình, Giàu Protein','assets/images/real_dishes/tom-rim-ba-chi.jpg',5,'approved',2989,0,'2026-09-21 10:56:58','2026-11-05 17:15:28'),(20,'Trứng hấp vân hoa sốt hành','Món trứng hấp mềm tan mịn như bánh flan, kết hợp cùng sốt nước tương dầu hào và mỡ hành phi thơm nức, cực kỳ dinh dưỡng và dễ làm cho cả người lớn lẫn trẻ nhỏ.','Món hấp','15 phút','3','- 4 quả trứng gà tươi\n- 200ml nước dùng ấm (hoặc nước lọc ấm)\n- 1 thìa cà phê nước tương ngon\n- 1 thìa cà phê dầu mè thơm\n- 2 nhánh hành lá thái nhỏ\n- 1 thìa dầu ăn\n- 1/3 thìa cà phê hạt nêm, tiêu trắng','Bước 1: Đập trứng vào bát, thêm hạt nêm, đánh tan nhẹ tay để không tạo quá nhiều bọt khí.\nBước 2: Rót nước ấm vào từ từ, vừa rót vừa khuấy đều. Lọc hỗn hợp trứng qua rây 2 lần cho mặt trứng thật mịn màng.\nBước 3: Dùng màng bọc thực phẩm hoặc đĩa đậy kín miệng bát. Đặt vào xửng hấp với lửa nhỏ liu riu trong 10-12 phút.\nBước 4: Làm sốt: đun nóng dầu ăn rồi dội vào bát hành lá cắt nhỏ làm mỡ hành. Thêm nước tương và dầu mè vào khuấy đều.\nBước 5: Mở nắp nồi hấp, rưới đều phần sốt mỡ hành lên mặt trứng hấp núng nính, rắc thêm chút tiêu trắng rồi thưởng thức nóng.',NULL,195,NULL,NULL,NULL,'Nhanh gọn, Dễ tiêu, Trẻ em, Ít Calo, Nấu ăn hàng ngày','assets/images/real_dishes/trung-hap-van-hoa.jpg',9,'approved',2032,0,'2026-09-21 10:56:58','2026-11-05 17:15:28'),(21,'Ức gà áp chảo sốt mật ong teriyaki','Ức gà mềm mọng không bị khô bã, ngấm đượm lớp sốt mật ong teriyaki mặn ngọt óng ả, món ăn số 1 cho thực đơn Eat Clean giàu đạm và giữ dáng hiệu quả.','Món xào','20 phút','2','- 400g ức gà tươi không da\n- 2 thìa mật ong rừng nguyên chất\n- 2 thìa nước tương Nhật (hoặc nước tương Maggi)\n- 1 thìa tỏi băm nhuyễn\n- 1 thìa gừng tươi băm nhỏ\n- 1 thìa dầu olive\n- 1/2 thìa tiêu đen xay, mè rang vàng rắc mặt','Bước 1: Ức gà rửa sạch, thấm khô bằng khăn giấy, khía nhẹ vài đường trên mặt thịt để thấm gia vị nhanh.\nBước 2: Pha nước sốt: hòa tan mật ong, nước tương, tỏi gừng băm, 1 thìa nước lọc và tiêu đen.\nBước 3: Làm nóng chảo với dầu olive, cho ức gà vào áp chảo lửa vừa trong 4-5 phút mỗi mặt đến khi vàng xém hấp dẫn.\nBước 4: Đổ hỗn hợp sốt vào chảo, hạ lửa nhỏ cho sốt sôi sủi tăm và áo đều quanh miếng thịt gà óng ả caramen.\nBước 5: Cho gà ra thớt nghỉ 3 phút, thái lát xéo vừa ăn, rắc mè rang vàng thơm lên trên, ăn kèm bông cải xanh hoặc cơm gạo lứt.',NULL,290,NULL,NULL,NULL,'Eat Clean, Giàu Protein, Low-Carb, Giảm cân','assets/images/real_dishes/uc-ga-teriyaki.jpg',2,'approved',3243,3,'2026-09-21 10:56:58','2026-11-05 18:24:14'),(22,'Đậu phụ sốt cà chua thịt băm','Món ăn quốc dân trên mâm cơm gia đình Việt. Từng miếng đậu phụ mềm mượt chiên sơ vàng bọc trong lớp sốt cà chua thịt băm đậm đà, thơm thảo mộc hành hoa.','Món xào','20 phút','4','- 4 bìa đậu phụ trắng\n- 200g thịt nạc heo băm nhỏ\n- 3 quả cà chua chín mọng (thái hạt lựu)\n- 2 củ hành khô băm nhỏ\n- 3 nhánh hành lá và mùi tàu thái nhỏ\n- 1.5 thìa nước mắm ngon, 1 thìa dầu hào, hạt nêm, tiêu xay, dầu ăn','Bước 1: Đậu phụ cắt miếng vuông vừa ăn, chiên vàng nhẹ các mặt rồi vớt ra để ráo dầu.\nBước 2: Phi thơm hành khô băm nhỏ, cho thịt băm vào xào săn với chút hạt nêm và nước mắm.\nBước 3: Trút cà chua vào xào nhuyễn, thêm 1/2 bát con nước nóng, đun nhỏ lửa đến khi cà chua mềm tạo thành sốt sánh mịn.\nBước 4: Cho đậu phụ đã rán vào chảo sốt, đảo nhẹ tay để không vỡ đậu. Đun lửa liu riu 5-7 phút cho đậu ngấm đượm vị sốt cà.\nBước 5: Nêm nếm lại cho vừa miệng, rắc hành hoa, mùi tàu và tiêu xay thơm nức rồi tắt bếp.',NULL,310,NULL,NULL,NULL,'Nấu ăn hàng ngày, Cơm gia đình, Tiết kiệm, Dễ làm','assets/images/real_dishes/dau-phu-sot-ca-chua.jpg',7,'approved',2582,0,'2026-09-21 10:56:58','2026-11-05 17:15:28'),(23,'Bánh bông lan nướng phô mai chà bông','Bánh bông lan nướng vàng ươm, cốt bánh mềm bông xốp như mây, phủ lớp phô mai béo ngậy tan chảy cùng sốt dầu trứng và chà bông mằn mặn siêu cuốn hút.','Món chiên','35 phút','6','- 4 quả trứng gà tươi (tách riêng lòng đỏ và trắng)\n- 40g bột mì số 8, 40g bột bắp\n- 45ml sữa tươi không đường\n- 40ml dầu ăn\n- 60g đường cát trắng, 1/4 thìa nước cốt chanh\n- 3 miếng phô mai lát bò cười, 50g chà bông gà cay, sốt dầu trứng thơm béo','Bước 1: Khuấy đều sữa tươi, dầu ăn, cho bột mì và bột bắp rây mịn vào trộn đều. Cho từng lòng đỏ trứng vào khuấy đến khi hỗn hợp mịn màng.\nBước 2: Đánh bông lòng trắng trứng với nước cốt chanh và đường (chia làm 3 lần cho vào) đến khi chóp mềm dẻo mịn.\nBước 3: Trộn 1/3 lòng trắng vào hỗn hợp bột, sau đó đổ ngược lại và dùng kỹ thuật fold nhẹ tay từ dưới lên.\nBước 4: Đổ bột vào khuôn có lót giấy nến, xếp phô mai lên giữa. Nướng ở 150°C trong 35-40 phút đến khi bánh chín vàng đều.\nBước 5: Lấy bánh ra để nguội bớt, quết sốt dầu trứng béo ngậy và phủ chà bông lên bề mặt. Cắt miếng thưởng thức ngay.',NULL,275,NULL,NULL,NULL,'Bánh ngọt đơn giản, Ăn vặt, Trẻ em, Cuối tuần','assets/images/real_dishes/banh-bong-lan-pho-mai.jpg',6,'approved',2864,0,'2026-09-21 10:56:58','2026-11-05 17:15:28'),(24,'Bò né hoa thiên lý tỏi phi giòn','Thịt bò bắp mềm ngọt xào lửa lớn cùng hoa thiên lý thanh mát giòn sần sật, phủ lớp tỏi phi vàng rụm nức mũi, món ngon giải nhiệt cực kỳ bổ dưỡng.','Món xào','15 phút','4','- 350g thịt bò thăn mềm (thái mỏng ngang thớ)\n- 300g hoa thiên lý tươi non (nhặt bỏ cọng già, rửa sạch để ráo)\n- 1 củ tỏi ta băm nhỏ, 1 củ tỏi thái lát mỏng phi vàng\n- 1.5 thìa dầu hào, 1 thìa nước tương ngon, 1/2 thìa đường, 1/2 thìa tiêu xay, dầu ăn','Bước 1: Ướp thịt bò với 1 thìa dầu hào, 1 thìa tỏi băm, 1/2 thìa tiêu xay và 1 thìa dầu ăn trong 15 phút để thịt ngấm mềm không bị khô.\nBước 2: Phi vàng tỏi thái lát trong chảo dầu để làm tỏi phi giòn, vớt ra đĩa riêng.\nBước 3: Dùng chảo đó đun thật nóng, cho tỏi băm vào phi thơm rồi trút thịt bò vào đảo nhanh tay trên lửa lớn trong 2 phút vừa chín tới, trút ra đĩa.\nBước 4: Tiếp tục cho hoa thiên lý vào chảo, thêm 1/2 thìa dầu hào và 2 thìa nước lọc đảo nhanh tay trong 1-2 phút cho hoa vừa chín xanh mướt.\nBước 5: Trút thịt bò trở lại chảo đảo đều 30 giây cho hòa quyện. Múc ra đĩa, rắc tỏi phi giòn rụm và tiêu xay lên trên mặt.',NULL,370,NULL,NULL,NULL,'Món xào, Giàu Protein, Tốn cơm, Món nhậu ngon','assets/images/real_dishes/bo-ne-thien-ly.jpg',2,'approved',3086,3,'2026-09-21 10:56:58','2026-11-05 18:24:14'),(25,'Cách làm cơm chiên gà xối mỡ ngon đậm đà thách thức vị giác','Cơm chiên gà xối mỡ với lớp da gà giòn rụm bên ngoài, thịt mềm ngọt mọng nước bên trong quyện cùng cơm chiên hạt tơi vàng óng ả.','Món chiên','60 phút','3 - 4 người','- 2 đùi gà góc phần tư tươi\n- 3 bát cơm nguội hạt tơi\n- 2 quả trứng gà\n- Tỏi băm, hành tím, gừng\n- Nước tương, dầu hào, mạch nha, hạt nêm\n- Rau răm, dưa leo, cà chua ăn kèm','Bước 1: Sơ chế đùi gà, luộc sơ với gừng hành rồi để ráo xối dầu sôi cho da giòn rụm.\nBước 2: Trộn cơm nguội với lòng đỏ trứng và gia vị đảo đều trên chảo gang lửa lớn.\nBước 3: Bày cơm chiên ra đĩa, xếp đùi gà xối mỡ vàng giòn lên trên, dùng kèm dưa góp và nước tương tỏi ớt.','Xăm nhẹ da gà và quét giấm mạch nha trước khi chiên giúp da nổ giòn tan.',580,NULL,NULL,NULL,NULL,'assets/images/real_dishes/com-chien-ga.jpg',1,'approved',1130,7,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(26,'Cách chế biến món thịt bò xào tỏi ngon ngất ngây','Thịt bò thăn mềm mọng xào cùng tỏi cô đơn phi thơm nức mũi, đậm đà chuẩn vị cơm nhà.','Món xào','15 phút','3 - 4 người','- 350g thịt bò thăn mềm thái mỏng\n- 2 củ tỏi băm nhuyễn và thái lát\n- Hành hoa, tiêu đen xay\n- Dầu hào, nước tương, dầu ăn, bột bắp','Bước 1: Ướp thịt bò với tỏi băm, dầu hào, tiêu và 1 thìa bột bắp trong 15 phút.\nBước 2: Phi thơm tỏi lát với dầu nóng đến khi vàng giòn thì trút thịt bò vào đảo lửa lớn trong 3 phút.\nBước 3: Rắc hành hoa, tiêu xay rồi tắt bếp, dùng nóng với cơm trắng.','Xào trên lửa thật lớn và đảo nhanh tay để thịt bò giữ nguyên độ mềm ngọt không bị dai.',380,NULL,NULL,NULL,NULL,'assets/images/real_dishes/bo-xao-toi.jpg',1,'approved',1893,6,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(27,'Đổi khẩu vị với món nộm thịt bò hành tây thơm ngon kiểu Thái','Món nộm bò chua cay mặn ngọt bùng nổ vị giác với hành tây giòn ngọt không hăng, rau thơm và nước sốt Thái chua thanh.','Món xào','25 phút','4 người','- 300g bắp bò hoa thái mỏng\n- 1 củ hành tây tím và 1 củ hành tây trắng\n- Cà chua bi, dưa chuột, ngò rí, húng lủi\n- Nước cốt chanh tươi, nước mắm ngon, ớt xiêm, đường thốt nốt','Bước 1: Hành tây thái mỏng ngâm ngay vào tô nước đá lạnh pha giấm đường để giòn ngọt.\nBước 2: Chần bắp bò vừa chín tới với gừng thơm.\nBước 3: Pha sốt Thái chua cay ngọt rồi trộn đều bò, hành tây, rau thơm và rắc đậu phộng rang.','Ngâm hành tây trong nước đá lạnh ít nhất 15 phút để khử sạch vị hăng cay.',290,NULL,NULL,NULL,NULL,'assets/images/real_dishes/nom-bo-thai.jpg',1,'approved',1836,6,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(28,'Cách nấu súp gà cho bé đơn giản thơm ngon tại nhà','Món súp gà bắp ngọt thơm lừng, sánh mịn, bổ dưỡng kích thích vị giác của bé và cả gia đình.','Món canh','30 phút','2 - 3 người','- 250g ức gà tươi luộc xé sợi nhỏ\n- 1 bắp ngô ngọt tách hạt\n- 50g nấm hương tươi thái hạt lựu\n- 1 quả trứng gà đánh tan\n- 2 thìa bột năng, rau mùi, dầu mè','Bước 1: Nấu nước dùng gà với ngô ngọt và nấm hương cho ngọt nước.\nBước 2: Cho thịt gà xé vào nấu sôi, hòa bột năng tạo độ sánh sệt vừa phải.\nBước 3: Rót từ từ trứng gà tạo vân hoa đẹp mắt, rắc ngò rí và chút dầu mè thơm.','Dùng thìa khuấy tròn một chiều khi rót trứng để tạo vân hoa sợi mỏng bồng bềnh.',240,NULL,NULL,NULL,NULL,'assets/images/real_dishes/sup-ga-be.jpg',1,'approved',1319,5,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(29,'Sườn non kho trứng cút thơm ngon đậm vị lại cực kỳ đưa cơm','Sườn non mềm rục ngấm nước hàng dừa xiêm béo ngậy, kết hợp trứng cút bùi bùi ăn bao nhiêu cơm cũng hết.','Món kho','40 phút','4 người','- 500g sườn non heo chặt khúc vừa ăn\n- 15 quả trứng cút luộc bóc vỏ\n- Nước dừa xiêm tươi 1 quả\n- Hành tỏi băm, ớt sừng, nước mắm ngon, tiêu','Bước 1: Chần sườn qua nước sôi, ướp gia vị 20 phút.\nBước 2: Thắng nước màu cánh gián, cho sườn vào xào săn rồi đổ nước dừa om lửa nhỏ 25 phút.\nBước 3: Cho trứng cút vào kho cùng đến khi nước sốt sệt sánh óng ả.','Kho bằng nước dừa tươi trên lửa liu riu giúp sườn lên màu cánh gián tự nhiên mà không cần phẩm màu.',450,NULL,NULL,NULL,NULL,'assets/images/real_dishes/suon-kho-trung-cut.jpg',1,'approved',1422,5,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(30,'Cách làm gà hấp hành thơm ngon vừa thổi vừa ăn','Gà ta hấp cùng lượng lớn hành hoa tươi, giữ trọn vị ngọt tự nhiên của thịt gà cùng hương thơm nồng nàn của hành.','Món hấp','50 phút','4 người','- 1 con gà ta khoảng 1.3kg\n- 200g hành lá rửa sạch cắt khúc\n- 1 củ gừng tươi thái sợi, ớt sừng\n- Muối tiêu chanh, dầu mè, hạt nêm','Bước 1: Xoa đều muối tiêu và chút rượu gừng quanh thân gà để khử mùi.\nBước 2: Rải lớp dày hành lá xuống đáy nồi hấp, đặt gà lên trên rắc thêm gừng sợi.\nBước 3: Hấp cách thủy 35 phút đến khi gà chín tới da vàng mọng nước, chấm muối tiêu chanh.','Quét một lớp dầu mè mỏng lên da gà ngay sau khi hấp xong để da gà vàng bóng thơm ngậy.',410,NULL,NULL,NULL,NULL,'assets/images/real_dishes/ga-hap-hanh.jpg',1,'approved',809,6,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(31,'Cách làm miến xào lòng gà - Món ăn truyền thống Việt Nam','Sợi miến dong dai mướt tơi xốp, lòng mề gà giòn sần sật quyện cùng mộc nhĩ nấm hương thơm lừng.','Món xào','25 phút','3 - 4 người','- 200g miến dong sạch\n- 2 bộ lòng mề gà tươi thái mỏng\n- Mộc nhĩ, nấm hương ngâm nở thái sợi\n- Cà rốt, giá đỗ, hành ngò, tiêu xay, dầu hào','Bước 1: Ngâm miến nở mềm rồi cắt khúc, xóc chút dầu ăn và lòng trắng trứng giúp sợi miến tơi giòn.\nBước 2: Xào chín tới lòng mề gà cùng nấm mộc nhĩ rồi trút ra đĩa riêng.\nBước 3: Xào miến lửa vừa, cho lòng gà và rau củ vào đảo đều tay, rắc tiêu thơm.','Xóc miến với 1 lòng trắng trứng gà trước khi xào đảm bảo miến tơi từng sợi, không bị vón cục hay nát.',360,NULL,NULL,NULL,NULL,'assets/images/real_dishes/mien-xao-long-ga.jpg',1,'approved',1611,4,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(32,'Tuyệt chiêu làm lòng heo xào cải chua thơm ngon hấp dẫn','Lòng heo giòn sần sật không chút mùi hôi xào cùng dưa cải chua lên men tự nhiên, chua thanh mặn ngọt tốn cơm vô cùng.','Món xào','20 phút','3 - 4 người','- 400g lòng non heo tươi ngon\n- 250g dưa cải chua muối giòn\n- 2 quả cà chua bổ múi cau\n- Hành tím, tỏi, ớt hiểm, nước mắm ngon, hạt tiêu','Bước 1: Làm sạch lòng non với muối hạt và nước cốt chanh, chần sơ 1 phút rồi ngâm nước đá cho giòn.\nBước 2: Xào cà chua và dưa cải chua cho ngấm gia vị.\nBước 3: Phi thơm tỏi, cho lòng heo vào đảo to lửa 2 phút rồi trút dưa cải vào xào hòa quyện.','Chần lòng trong nước sôi rồi vớt ngay vào bát nước đá lạnh có vắt chanh để lòng trắng giòn tan.',340,NULL,NULL,NULL,NULL,'assets/images/real_dishes/long-xao-cai-chua.jpg',1,'approved',1780,5,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(33,'Cách làm món lòng heo xào chua ngọt đậm đà hương vị','Lòng heo xào chua ngọt với dứa thơm, ớt chuông, hành tây tạo nên hương vị chua cay ngọt ngào quyến rũ — công thức Cookio.','Món xào','30 phút','4 người','- 350g lòng heo luộc giòn thái khúc\n- 1/4 quả dứa chín thái lát\n- Ớt chuông đỏ, hành tây, cần tây\n- Nước sốt me chua ngọt, tương ớt, dầu hào','Bước 1: Sơ chế lòng heo sạch và ngâm đá giòn.\nBước 2: Phi thơm tỏi, xào rau củ dứa và ớt chuông chín tới.\nBước 3: Cho lòng heo và sốt chua ngọt vào đảo lửa lớn trong 3 phút cho sốt áo đều.','Nên chọn lòng non đầu tròn, màu trắng hồng sữa để lòng bùi ngậy không bị đắng.',370,NULL,NULL,NULL,NULL,'assets/images/real_dishes/long-heo-xao-chua-ngot.jpg',1,'approved',1806,4,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(34,'Cách làm thịt lợn chiên xù giòn tan lại khó cưỡng ngon ơi là ngon','Thịt heo cốt lết dần mềm ướp tiêu thơm, lăn qua lớp bột chiên xù xốp giòn tan — công thức Cookio.','Món chiên','30 phút','3 người','- 400g thịt thăn hoặc cốt lết heo\n- 1 gói bột chiên giòn và 1 gói bột chiên xù Panko\n- 2 quả trứng gà đánh tan\n- Muối, tiêu đen, tỏi băm, sốt tương cà / mayonnaise','Bước 1: Dần mỏng miếng thịt bằng búa chuyên dụng, ướp chút muối tiêu 15 phút.\nBước 2: Lăn thịt lần lượt qua bột mì &rarr; trứng gà &rarr; bột chiên xù ấn chặt.\nBước 3: Chiên ngập dầu ở 170°C đến khi vàng ruộm giòn tan thì vớt ra thấm ráo dầu.','Dần kĩ thớ thịt trước khi tẩm bột giúp thịt sau khi chiên mềm mọng không bị khô cứng.',490,NULL,NULL,NULL,NULL,'assets/images/real_dishes/thit-chien-xu.jpg',1,'approved',1413,6,'2026-09-21 16:35:38','2026-11-05 18:24:14'),(35,'Vào bếp trổ tài với món gà xào hạt điều hấp dẫn','Thịt gà xào hạt điều thơm bùi béo ngậy, sốt đậm đà bóng bẩy chuẩn phong cách nhà hàng ẩm thực — công thức Cookio.','Món xào','30 phút','3 - 4 người','- 350g ức gà hoặc đùi gà rút xương thái vuông\n- 80g hạt điều rang chín giòn\n- Ớt chuông đỏ vàng, hành tây, hành lá\n- Sốt dầu hào, xì dầu, mật ong, dầu mè','Bước 1: Ướp thịt gà với xì dầu, dầu hào và chút tiêu 15 phút.\nBước 2: Xào gà săn chín tới, trút rau củ ớt chuông vào đảo cùng sốt sệt.\nBước 3: Cuối cùng rắc hạt điều rang giòn và hành lá vào đảo nhanh tay rồi bắc xuống.','Chỉ cho hạt điều vào cuối cùng ngay trước khi tắt bếp để hạt điều giữ trọn độ giòn thơm.',430,NULL,NULL,NULL,NULL,'assets/images/real_dishes/ga-xao-hat-dieu.jpg',1,'approved',598,5,'2026-09-21 16:35:38','2026-11-05 18:24:14');
/*!40000 ALTER TABLE `recipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saved_recipes`
--

DROP TABLE IF EXISTS `saved_recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `saved_recipes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `recipe_id` int(10) unsigned NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_recipe_save` (`user_id`,`recipe_id`),
  KEY `idx_sr_user` (`user_id`),
  KEY `idx_sr_recipe` (`recipe_id`),
  CONSTRAINT `fk_sr_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sr_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saved_recipes`
--

LOCK TABLES `saved_recipes` WRITE;
/*!40000 ALTER TABLE `saved_recipes` DISABLE KEYS */;
INSERT INTO `saved_recipes` VALUES (33,1,1,'Món tủ để đãi bạn bè cuối tuần, mua thịt thăn bò mềm ngon nhất.','2026-11-03 14:10:00'),(34,1,7,'Công thức phở bò gia truyền chuẩn vị Hà Nội, nước dùng ngọt thanh.','2026-11-03 16:30:00'),(35,1,8,'Sườn xào chua ngọt các bé nhà mình rất mê.','2026-11-03 17:15:00'),(36,1,9,'Thịt kho tàu nước dừa cho mâm cơm ngày Tết.','2026-11-03 17:45:00'),(37,1,10,'Canh chua cá lóc giải nhiệt ngày hè cực đỉnh.','2026-11-03 18:25:00'),(38,1,11,'Thực đơn Eat Clean giảm mỡ tăng cơ.','2026-11-03 19:10:00'),(39,1,15,'Bún chả nướng than hoa đãi tiệc gia đình.','2026-11-03 21:10:00'),(40,1,17,'Nem rán truyền thống gói giòn rụm không bị rách bánh đa.','2026-11-03 22:10:00'),(41,5,25,'Cơm chiên gà xối mỡ cho các bé bữa tối cuối tuần.','2026-11-04 14:30:00'),(42,5,28,'Súp gà bổ dưỡng khi các bé cảm sốt.','2026-11-04 15:00:00'),(43,5,29,'Sườn non kho trứng cút đổi món bữa cơm.','2026-11-04 16:20:00'),(44,2,25,'Bí quyết canh nhiệt độ dầu khi xối mỡ rất chuẩn.','2026-11-04 10:40:00'),(45,2,30,'Gà hấp hành ngọt đậm đà, giữ ẩm tốt.','2026-11-04 11:45:00'),(46,7,26,'Thịt bò xào tỏi nhanh gọn đưa cơm.','2026-11-04 19:50:00'),(47,7,32,'Món nhậu khoái khẩu với lòng heo cải chua.','2026-11-05 08:40:00'),(48,9,27,'Nộm bò kiểu Thái thanh mát ít dầu mỡ.','2026-11-05 15:50:00'),(49,4,25,'Món cơm gà ngon nhất từng làm theo!','2026-11-04 11:30:00'),(50,4,34,'Thịt heo chiên xù siêu giòn.','2026-11-04 13:30:00');
/*!40000 ALTER TABLE `saved_recipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_settings` (
  `setting_key` varchar(64) NOT NULL,
  `setting_value` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES ('last_daily_simulation','2026-11-05','2026-11-05 17:15:28');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `bio` varchar(500) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin1111','$2y$10$AmxvQ1h.0xCy6oir4ymTeepHjZXoQQ7UOnMfZIvUNqnek7YqPrpY6',NULL,'Đam mê nấu các món ngon truyền thống Việt Nam và sáng tạo ẩm thực gia đình ấm cúng.','admin','2026-09-09 18:06:10','2026-09-10 00:15:46'),(2,'chef_lan','$2y$10$EkTk5/uBhryBEWJxBgHkGuSw9akhB0FgPSFpZaU2p/Q9UOalj.x2S','0987112233',NULL,'user','2026-09-09 18:06:10','2026-09-09 21:46:16'),(4,'user1111','$2y$10$zwW.k0yYRD81ufsIfSRKMeM0Ha55XZpUl.zCYzmJEjtvsQEuUCmDq','012345678',NULL,'user','2026-09-10 00:06:55','2026-09-10 00:06:55'),(5,'me_bong','$2y$10$4ad6aTsu9mqYSG85dBxRquWqBoDVXZXkrCaiJbOZRN0agY0A9wzGa',NULL,'Yêu thích những bữa cơm gia đình giản dị, đượm vị quê hương Bắc Bộ.','user','2026-09-11 13:46:57','2026-09-11 13:46:57'),(6,'bep_hoa','$2y$10$4ad6aTsu9mqYSG85dBxRquWqBoDVXZXkrCaiJbOZRN0agY0A9wzGa',NULL,'Nấu ăn bằng cả trái tim, đam mê các món kho, món canh thanh mát chuẩn vị mẹ nấu.','user','2026-09-11 13:46:57','2026-09-11 13:46:57'),(7,'chu_nam_cook','$2y$10$4ad6aTsu9mqYSG85dBxRquWqBoDVXZXkrCaiJbOZRN0agY0A9wzGa',NULL,'Chuyên các món kho quẹt, cá linh bông điên điển, canh chua đậm chất sông nước Nam Bộ.','user','2026-09-11 13:46:57','2026-09-11 13:46:57'),(8,'an_ngon_moingay','$2y$10$4ad6aTsu9mqYSG85dBxRquWqBoDVXZXkrCaiJbOZRN0agY0A9wzGa',NULL,'Chia sẻ công thức nấu nhanh dưới 20 phút cho người bận rộn và dân văn phòng.','user','2026-09-11 13:46:57','2026-09-11 13:46:57'),(9,'lan_anh_kitchen','$2y$10$4ad6aTsu9mqYSG85dBxRquWqBoDVXZXkrCaiJbOZRN0agY0A9wzGa',NULL,'Theo đuổi lối sống lành mạnh, tính toán dinh dưỡng, ít dầu mỡ mà vẫn ngon miệng.','user','2026-09-11 13:46:57','2026-09-11 13:46:57');
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

-- Dump completed on 2026-11-05 18:27:29
