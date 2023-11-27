-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.28-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para imdb
CREATE DATABASE IF NOT EXISTS `imdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `imdb`;

-- Volcando estructura para tabla imdb.actor
CREATE TABLE IF NOT EXISTS `actor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `died` date DEFAULT NULL,
  `born` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=426636 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla imdb.director
CREATE TABLE IF NOT EXISTS `director` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34911 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla imdb.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla imdb.film
CREATE TABLE IF NOT EXISTS `film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imdb_title_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date_published` date DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `production_company` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_idx` (`title`,`genre`,`production_company`),
  KEY `find_one_idx` (`imdb_title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla imdb.film_actor
CREATE TABLE IF NOT EXISTS `film_actor` (
  `film_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  PRIMARY KEY (`film_id`,`actor_id`),
  KEY `IDX_DD19A8A9567F5183` (`film_id`),
  KEY `IDX_DD19A8A910DAF24A` (`actor_id`),
  CONSTRAINT `FK_DD19A8A910DAF24A` FOREIGN KEY (`actor_id`) REFERENCES `actor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_DD19A8A9567F5183` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla imdb.film_ant
CREATE TABLE IF NOT EXISTS `film_ant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imdb_title_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date_published` bigint(20) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `production_company` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_idx` (`title`,`genre`,`production_company`),
  KEY `find_one_idx` (`imdb_title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=85856 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla imdb.film_director
CREATE TABLE IF NOT EXISTS `film_director` (
  `film_id` int(11) NOT NULL,
  `director_id` int(11) NOT NULL,
  PRIMARY KEY (`film_id`,`director_id`),
  KEY `IDX_BC171C99567F5183` (`film_id`),
  KEY `IDX_BC171C99899FB366` (`director_id`),
  CONSTRAINT `FK_BC171C99567F5183` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_BC171C99899FB366` FOREIGN KEY (`director_id`) REFERENCES `director` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
