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

-- Dumping data for table ludo.tournament_tables: ~36 rows (approximately)
REPLACE INTO `tournament_tables` (`id`, `tournament_id`, `table_id`, `game_name`, `player_id1`, `player_id2`, `status`, `winner`, `updated_at`, `created_at`) VALUES
	(269, 'T1J', '1', 'newform 1', 'LUDO999004', 'LUDO999008', '2/2', 'LUDO999008', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(270, 'T1J', '2', 'newform 2', 'LUDO999012', 'LUDO999016', '2/2', 'LUDO999016', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(271, 'T1J', '3', 'newform 3', 'LUDO999020', 'LUDO999024', '2/2', 'LUDO999024', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(272, 'T1J', '4', 'newform 4', 'LUDO999028', 'LUDO999032', '2/2', 'LUDO999032', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(273, 'T1J', '5', 'newform 5', 'LUDO999036', 'LUDO999040', '2/2', 'LUDO999040', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(274, 'T1J', '6', 'newform 6', 'LUDO999044', 'LUDO999048', '2/2', 'LUDO999048', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(275, 'T1J', '7', 'newform 7', 'LUDO999052', 'LUDO999056', '2/2', 'LUDO999056', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(276, 'T1J', '8', 'newform 8', 'LUDO999060', 'LUDO999064', '2/2', 'LUDO999064', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(277, 'T1J', '9', 'newform 9', 'LUDO999068', 'LUDO999072', '2/2', 'LUDO999072', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(278, 'T1J', '10', 'newform 10', 'LUDO999076', 'LUDO999080', '2/2', 'LUDO999080', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(279, 'T1J', '11', 'newform 11', 'LUDO999084', 'LUDO999088', '2/2', 'LUDO999088', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(280, 'T1J', '12', 'newform 12', 'LUDO999092', 'LUDO999096', '2/2', 'LUDO999096', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(281, 'T1J', '13', 'newform 13', 'LUDO999100', 'LUDO999104', '2/2', 'LUDO999104', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(282, 'T1J', '14', 'newform 14', 'LUDO999108', 'LUDO999112', '2/2', 'LUDO999112', '2023-12-27 12:46:38', '2023-12-27 12:46:38'),
	(283, 'T1J', '15', 'newform 15', 'LUDO999116', 'LUDO999120', '2/2', 'LUDO999120', '2023-12-27 12:46:39', '2023-12-27 12:46:39'),
	(284, 'T1J', '16', 'newform 16', 'LUDO999124', 'LUDO999128', '2/2', 'LUDO999128', '2023-12-27 12:46:39', '2023-12-27 12:46:39');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
