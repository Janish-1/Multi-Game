-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table ludo.tournament_tables
CREATE TABLE IF NOT EXISTS `tournament_tables` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tournament_id` varchar(255) NOT NULL,
  `table_id` varchar(255) NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `player_id1` varchar(255) DEFAULT NULL,
  `player_id2` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `winner` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1;

-- Dumping data for table ludo.tournament_tables: ~22 rows (approximately)
REPLACE INTO `tournament_tables` (`id`, `tournament_id`, `table_id`, `game_name`, `player_id1`, `player_id2`, `status`, `winner`, `updated_at`, `created_at`) VALUES
	(297, 'T1J', '1', 'newform 1', 'LUDO999032', 'LUDO999064', '2/2', 'LUDO999064', '2023-12-27 12:53:53', '2023-12-27 12:53:53'),
	(298, 'T1J', '2', 'newform 2', 'LUDO999096', 'LUDO999128', '2/2', 'LUDO999128', '2023-12-27 12:53:53', '2023-12-27 12:53:53');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
