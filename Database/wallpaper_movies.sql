/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 10.1.13-MariaDB : Database - wallpaper_movies
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`wallpaper_movies` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `wallpaper_movies`;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `pid` int(5) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`id`,`name`,`desc`,`pid`,`created_at`) values (1,'Comidy','',0,'2016-05-31 18:35:30'),(2,'Action','',0,'2016-05-31 18:35:48'),(3,'Romantic','',0,'2016-05-31 18:36:05'),(4,'Series','',0,'2016-05-31 18:36:16');

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `pid` int(5) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `country` */

insert  into `country`(`id`,`name`,`desc`,`pid`,`created_at`) values (1,'English','',0,'2016-05-31 18:38:05'),(2,'Arabic','',0,'2016-05-31 18:36:46'),(3,'Kurdish','',0,'2016-05-31 18:37:04'),(4,'Persian','',0,'2016-05-31 18:37:12'),(5,'German','',0,'2016-05-31 18:37:42'),(6,'Franch','',0,'2016-05-31 18:37:54');

/*Table structure for table `devices` */

DROP TABLE IF EXISTS `devices`;

CREATE TABLE `devices` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `macaddress` varchar(255) NOT NULL,
  `serialno` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `devices` */

insert  into `devices`(`id`,`macaddress`,`serialno`,`created_at`) values (5,'56:as:as:as:as:as:as','123456789','2016-06-01 11:08:06'),(21,'9C:02:98:A0:97:E7','4641199a866b28ce','2016-06-01 19:21:38'),(22,'as:we:we:df:df:sd','23231121','2016-06-01 12:06:02'),(23,'qw:er:23:34','wwwwww','2016-06-01 12:06:02');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1);

/*Table structure for table `movies` */

DROP TABLE IF EXISTS `movies`;

CREATE TABLE `movies` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `path` text NOT NULL,
  `thumb` text NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `movies` */

insert  into `movies`(`id`,`catid`,`cid`,`name`,`desc`,`path`,`thumb`,`status`,`created_at`) values (17,2,2,'android developer','android','http://www.quirksmode.org/html5/videos/big_buck_bunny.mp4','/uploads/1464859770.png',1,'2016-06-02 19:47:00'),(18,2,2,'test movie 1','test','http://clips.vorwaerts-gmbh.de/VfE_html5.mp4','/uploads/1464859762.png',1,'2016-06-02 19:46:27'),(19,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859756.png',1,'2016-06-02 17:29:16'),(20,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859749.png',1,'2016-06-02 17:29:09'),(21,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859733.png',1,'2016-06-02 17:28:54'),(22,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859725.png',1,'2016-06-02 17:28:45'),(23,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859718.png',1,'2016-06-02 17:28:38'),(24,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859711.png',1,'2016-06-02 17:28:31'),(25,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859705.png',1,'2016-06-02 17:28:25'),(26,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859697.png',1,'2016-06-02 17:28:17'),(27,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859690.png',1,'2016-06-02 17:28:10'),(28,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859685.png',1,'2016-06-02 17:28:05'),(29,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859680.png',1,'2016-06-02 17:28:00'),(30,2,2,'android developer','android','http://techslides.com/demos/sample-videos/small.mp4','/uploads/1464859672.png',1,'2016-06-02 17:27:52'),(31,2,2,'android developer','android','http://clips.vorwaerts-gmbh.de/VfE_html5.mp4','/uploads/1464859776.png',1,'2016-06-02 19:51:37');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values (1,'admin','admin@gmail.com','$2y$10$ND48K0Q0OJytcb1/dFFWz.od3Dqkqi1YpPat7xt1ek7aX7uWX3QaC','KKinn7gepn2TOTlMjVonmCkJ01jnmc5GhhTrJ57QnA4qcrhRV09pWntNMeET',NULL,'2016-05-31 13:21:29');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
