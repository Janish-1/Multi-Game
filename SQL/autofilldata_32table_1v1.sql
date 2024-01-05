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

-- Dumping data for table ludo.tournament_tables: ~52 rows (approximately)
REPLACE INTO `tournament_tables` (`id`, `tournament_id`, `table_id`, `game_name`, `player_id1`, `player_id2`, `status`, `winner`, `updated_at`, `created_at`) VALUES
	(237, 'T1J', '1', 'newform 1', 'LUDO999002', 'LUDO999004', '2/2', 'LUDO999004', '2023-12-27 12:42:34', '2023-12-27 12:40:58'),
	(238, 'T1J', '2', 'newform 2', 'LUDO999006', 'LUDO999008', '2/2', 'LUDO999008', '2023-12-27 12:42:38', '2023-12-27 12:40:59'),
	(239, 'T1J', '3', 'newform 3', 'LUDO999010', 'LUDO999012', '2/2', 'LUDO999012', '2023-12-27 12:42:46', '2023-12-27 12:40:59'),
	(240, 'T1J', '4', 'newform 4', 'LUDO999014', 'LUDO999016', '2/2', 'LUDO999016', '2023-12-27 12:43:00', '2023-12-27 12:40:59'),
	(241, 'T1J', '5', 'newform 5', 'LUDO999018', 'LUDO999020', '2/2', 'LUDO999020', '2023-12-27 12:42:54', '2023-12-27 12:40:59'),
	(242, 'T1J', '6', 'newform 6', 'LUDO999022', 'LUDO999024', '2/2', 'LUDO999024', '2023-12-27 12:43:03', '2023-12-27 12:40:59'),
	(243, 'T1J', '7', 'newform 7', 'LUDO999026', 'LUDO999028', '2/2', 'LUDO999028', '2023-12-27 12:43:07', '2023-12-27 12:40:59'),
	(244, 'T1J', '8', 'newform 8', 'LUDO999030', 'LUDO999032', '2/2', 'LUDO999032', '2023-12-27 12:43:10', '2023-12-27 12:40:59'),
	(245, 'T1J', '9', 'newform 9', 'LUDO999034', 'LUDO999036', '2/2', 'LUDO999036', '2023-12-27 12:43:13', '2023-12-27 12:40:59'),
	(246, 'T1J', '10', 'newform 10', 'LUDO999038', 'LUDO999040', '2/2', 'LUDO999040', '2023-12-27 12:43:19', '2023-12-27 12:40:59'),
	(247, 'T1J', '11', 'newform 11', 'LUDO999042', 'LUDO999044', '2/2', 'LUDO999044', '2023-12-27 12:43:22', '2023-12-27 12:40:59'),
	(248, 'T1J', '12', 'newform 12', 'LUDO999046', 'LUDO999048', '2/2', 'LUDO999048', '2023-12-27 12:43:26', '2023-12-27 12:40:59'),
	(249, 'T1J', '13', 'newform 13', 'LUDO999050', 'LUDO999052', '2/2', 'LUDO999052', '2023-12-27 12:43:30', '2023-12-27 12:40:59'),
	(250, 'T1J', '14', 'newform 14', 'LUDO999054', 'LUDO999056', '2/2', 'LUDO999056', '2023-12-27 12:43:33', '2023-12-27 12:40:59'),
	(251, 'T1J', '15', 'newform 15', 'LUDO999058', 'LUDO999060', '2/2', 'LUDO999060', '2023-12-27 12:43:37', '2023-12-27 12:40:59'),
	(252, 'T1J', '16', 'newform 16', 'LUDO999062', 'LUDO999064', '2/2', 'LUDO999064', '2023-12-27 12:43:42', '2023-12-27 12:40:59'),
	(253, 'T1J', '17', 'newform 17', 'LUDO999066', 'LUDO999068', '2/2', 'LUDO999068', '2023-12-27 12:43:45', '2023-12-27 12:40:59'),
	(254, 'T1J', '18', 'newform 18', 'LUDO999070', 'LUDO999072', '2/2', 'LUDO999072', '2023-12-27 12:43:49', '2023-12-27 12:40:59'),
	(255, 'T1J', '19', 'newform 19', 'LUDO999074', 'LUDO999076', '2/2', 'LUDO999076', '2023-12-27 12:43:52', '2023-12-27 12:40:59'),
	(256, 'T1J', '20', 'newform 20', 'LUDO999078', 'LUDO999080', '2/2', 'LUDO999080', '2023-12-27 12:43:55', '2023-12-27 12:40:59'),
	(257, 'T1J', '21', 'newform 21', 'LUDO999082', 'LUDO999084', '2/2', 'LUDO999084', '2023-12-27 12:43:58', '2023-12-27 12:40:59'),
	(258, 'T1J', '22', 'newform 22', 'LUDO999086', 'LUDO999088', '2/2', 'LUDO999088', '2023-12-27 12:44:02', '2023-12-27 12:40:59'),
	(259, 'T1J', '23', 'newform 23', 'LUDO999090', 'LUDO999092', '2/2', 'LUDO999092', '2023-12-27 12:44:05', '2023-12-27 12:41:00'),
	(260, 'T1J', '24', 'newform 24', 'LUDO999094', 'LUDO999096', '2/2', 'LUDO999096', '2023-12-27 12:44:10', '2023-12-27 12:41:00'),
	(261, 'T1J', '25', 'newform 25', 'LUDO999098', 'LUDO999100', '2/2', 'LUDO999100', '2023-12-27 12:44:15', '2023-12-27 12:41:00'),
	(262, 'T1J', '26', 'newform 26', 'LUDO999102', 'LUDO999104', '2/2', 'LUDO999104', '2023-12-27 12:44:18', '2023-12-27 12:41:00'),
	(263, 'T1J', '27', 'newform 27', 'LUDO999106', 'LUDO999108', '2/2', 'LUDO999108', '2023-12-27 12:44:22', '2023-12-27 12:41:00'),
	(264, 'T1J', '28', 'newform 28', 'LUDO999110', 'LUDO999112', '2/2', 'LUDO999112', '2023-12-27 12:44:28', '2023-12-27 12:41:00'),
	(265, 'T1J', '29', 'newform 29', 'LUDO999114', 'LUDO999116', '2/2', 'LUDO999116', '2023-12-27 12:44:31', '2023-12-27 12:41:00'),
	(266, 'T1J', '30', 'newform 30', 'LUDO999118', 'LUDO999120', '2/2', 'LUDO999120', '2023-12-27 12:44:34', '2023-12-27 12:41:00'),
	(267, 'T1J', '31', 'newform 31', 'LUDO999122', 'LUDO999124', '2/2', 'LUDO999124', '2023-12-27 12:44:37', '2023-12-27 12:41:00'),
	(268, 'T1J', '32', 'newform 32', 'LUDO999126', 'LUDO999128', '2/2', 'LUDO999128', '2023-12-27 12:44:41', '2023-12-27 12:41:00');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
