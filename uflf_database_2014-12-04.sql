# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.34)
# Database: uflf_database
# Generation Time: 2014-12-04 21:49:56 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table brigademt_crisis_centers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `brigademt_crisis_centers`;

CREATE TABLE `brigademt_crisis_centers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table brigademt_Product_Request
# ------------------------------------------------------------

DROP TABLE IF EXISTS `brigademt_Product_Request`;

CREATE TABLE `brigademt_Product_Request` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL,
  `request_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `request_id` (`request_id`),
  CONSTRAINT `brigademt_product_request_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `brigademt_requests` (`id`),
  CONSTRAINT `brigademt_product_request_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `brigademt_products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table brigademt_products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `brigademt_products`;

CREATE TABLE `brigademt_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `thumbs_up` int(10) unsigned NOT NULL DEFAULT '0',
  `thumbs_down` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table brigademt_requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `brigademt_requests`;

CREATE TABLE `brigademt_requests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `reception_date` datetime DEFAULT NULL,
  `priority` int(10) unsigned NOT NULL DEFAULT '0',
  `crisis_center_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `crisis_center_id` (`crisis_center_id`),
  CONSTRAINT `brigademt_requests_ibfk_1` FOREIGN KEY (`crisis_center_id`) REFERENCES `brigademt_crisis_centers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
