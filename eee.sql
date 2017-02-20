/*
SQLyog v10.2 
MySQL - 5.6.17 : Database - 333
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`333` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `333`;

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `body` text,
  `image` varchar(100) DEFAULT NULL,
  `user_id` int(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `articles` */

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `content` text,
  `page_id` int(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `comments` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2017_02_12_084147_entrust_setup_tables',1);

/*Table structure for table `organization_user` */

DROP TABLE IF EXISTS `organization_user`;

CREATE TABLE `organization_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `organization_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `organization_user` */

insert  into `organization_user`(`id`,`organization_id`,`user_id`,`created_at`,`updated_at`) values (1,1,1,NULL,NULL),(2,1,37,NULL,NULL),(3,1,38,NULL,NULL),(4,1,40,NULL,NULL);

/*Table structure for table `organizations` */

DROP TABLE IF EXISTS `organizations`;

CREATE TABLE `organizations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `organizations` */

insert  into `organizations`(`id`,`pid`,`name`,`created_at`,`updated_at`) values (1,0,'新东方南二环',NULL,'2017-02-19 06:13:48'),(2,1,'高一',NULL,'2017-02-19 06:13:32'),(3,1,'高二',NULL,'2017-02-19 06:13:55'),(4,1,'高三',NULL,'2017-02-19 06:14:51'),(5,1,'市场部',NULL,'2017-02-19 06:15:12'),(6,1,'人事部',NULL,'2017-02-19 06:15:07'),(7,1,'行政部',NULL,NULL),(8,1,'财政部',NULL,NULL),(9,2,'一班',NULL,'2017-02-19 06:13:43'),(10,2,'二班',NULL,'2017-02-19 06:14:01'),(12,3,'一班',NULL,'2017-02-19 06:14:28'),(13,4,'一班',NULL,'2017-02-19 06:14:54'),(14,4,'二班',NULL,'2017-02-19 06:14:56'),(17,3,'二班','2017-02-19 06:14:28','2017-02-19 06:14:33'),(18,1,'111','2017-02-19 09:27:22','2017-02-19 09:27:29');

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) DEFAULT NULL,
  `body` text,
  `slug` varchar(100) DEFAULT NULL,
  `user_id` int(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

insert  into `pages`(`id`,`title`,`body`,`slug`,`user_id`,`created_at`,`updated_at`) values (-1,'',NULL,NULL,1,NULL,NULL),(30,'酸辣土豆丝','家常小炒',NULL,1,'2017-02-05 17:58:38','2017-02-10 08:19:15');

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

/*Table structure for table `permission_role` */

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permission_role` */

insert  into `permission_role`(`permission_id`,`role_id`) values (33,9);

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`pid`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values (0,-1,'','ROOT',NULL,NULL,NULL),(1,0,'TradingCenter','交易中心',NULL,NULL,NULL),(2,1,'TotalAssets','总资产概况',NULL,NULL,NULL),(3,1,'TradingDetails','交易明细',NULL,NULL,NULL),(13,0,NULL,'社区管理',NULL,'2017-02-19 05:49:58','2017-02-19 05:50:18'),(14,13,NULL,'内容维护',NULL,'2017-02-19 05:50:26','2017-02-19 05:50:31'),(15,13,NULL,'用户管理',NULL,'2017-02-19 05:50:32','2017-02-19 05:50:38'),(16,13,NULL,'注册维护',NULL,'2017-02-19 05:50:39','2017-02-19 05:50:47'),(17,13,NULL,'事件设置',NULL,'2017-02-19 05:50:49','2017-02-19 05:50:56'),(18,13,NULL,'运营考核',NULL,'2017-02-19 05:50:59','2017-02-19 05:51:05'),(19,0,NULL,'用户分析',NULL,'2017-02-19 05:51:06','2017-02-19 05:51:15'),(20,19,NULL,'新增用户',NULL,'2017-02-19 05:51:16','2017-02-19 05:51:28'),(21,19,NULL,'活跃度',NULL,'2017-02-19 05:51:17','2017-02-19 05:51:33'),(22,19,NULL,'留存率',NULL,'2017-02-19 05:51:35','2017-02-19 05:51:39'),(23,19,NULL,'用户画像',NULL,'2017-02-19 05:51:42','2017-02-19 05:51:47'),(24,0,NULL,'内容分析',NULL,'2017-02-19 05:51:51','2017-02-19 05:51:55'),(25,24,NULL,'总内容',NULL,'2017-02-19 05:52:00','2017-02-19 05:52:04'),(26,24,NULL,'精华内容',NULL,'2017-02-19 05:52:06','2017-02-19 05:52:11'),(27,24,NULL,'页面分析',NULL,'2017-02-19 05:52:12','2017-02-19 05:52:17'),(28,0,NULL,'事件与转化',NULL,'2017-02-19 05:54:10','2017-02-19 05:54:19'),(29,28,NULL,'基础事件',NULL,'2017-02-19 05:54:20','2017-02-19 05:54:32'),(30,28,NULL,'我的转发',NULL,'2017-02-19 05:54:21','2017-02-19 05:54:38'),(31,28,NULL,'搜索分析',NULL,'2017-02-19 05:54:22','2017-02-19 05:54:45'),(32,28,NULL,'事件与漏斗',NULL,'2017-02-19 05:54:48','2017-02-19 05:54:56'),(33,0,NULL,'做作业',NULL,'2017-02-19 06:56:25','2017-02-19 06:56:46'),(34,0,NULL,'改作业',NULL,'2017-02-19 06:56:33','2017-02-19 06:56:42'),(35,0,NULL,'投票',NULL,'2017-02-20 02:43:48','2017-02-20 02:43:55');

/*Table structure for table `role_user` */

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `role_user` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`pid`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values (0,-1,'ROOT',NULL,NULL,NULL,NULL),(4,0,'校长',NULL,NULL,'2017-02-19 06:37:57','2017-02-19 06:39:41'),(5,0,'财务主管',NULL,NULL,'2017-02-19 06:40:53','2017-02-19 06:40:58'),(6,0,'人力主管',NULL,NULL,'2017-02-19 06:41:00','2017-02-19 06:41:05'),(7,0,'运营主管',NULL,NULL,'2017-02-19 06:41:12','2017-02-19 06:41:18'),(8,0,'老师',NULL,NULL,'2017-02-19 06:55:55','2017-02-19 06:55:59'),(9,0,'学生',NULL,NULL,'2017-02-19 06:56:02','2017-02-19 06:56:06');

/*Table structure for table `uploadfiles` */

DROP TABLE IF EXISTS `uploadfiles`;

CREATE TABLE `uploadfiles` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `size` varchar(30) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(4) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `page_id` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `uploadfiles` */

insert  into `uploadfiles`(`id`,`name`,`type`,`size`,`path`,`created_at`,`updated_at`,`user_id`,`username`,`page_id`) values (33,'east-ep-a60-13316559.jpg','image/jpeg','11623','/uploads/leizixing/b0aedd57208d9e80caed010ea8da7c8e.jpg','2017-02-10 09:06:38','2017-02-10 09:29:48',0,'leizixing',31),(35,'east-ep-a60-13316559.jpg','image/jpeg','11623','/uploads/leizixing/b0aedd57208d9e80caed010ea8da7c8e.jpg','2017-02-10 09:37:28','2017-02-10 09:37:52',0,'leizixing',32),(37,'libsasl.dll','application/x-msdownload','102400','/uploads/leizixing/3f9c9ee45b17622c6b0fb9ca0c12627d.dll','2017-02-12 04:05:25','2017-02-12 04:05:25',0,'leizixing',30);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`,`role_id`) values (1,'lzx45','110@qq.com','$2y$10$cjvO7rKgP0dtje4JPwXfqOaFjUK8LhqQIoYCTNARuxf9xHVeJ7znq','r9fKM1cNK4RF0ZYpU3mEnKFsNgBY3a5cRhIEEp6dVOmgPGCooR0GpSuCY4CO','2017-02-12 08:43:27','2017-02-19 09:35:28',0),(18,'lzx','1435606838@qq.com','$2y$10$3hMl3UGFIwyT0qvaObBdsOSD0yueyZ7hrGKUL8xORYl8Ul50YiYvO','jNgRCFKXklgpvO7PqYl63ZSLGeguQ0CrQ4lt3OSwNdOXD7Tj7EW6d53q1stQ','2017-02-19 02:36:59','2017-02-20 07:13:22',9),(27,'1','1@qq.com','$2y$10$JiAah1yZZ6oX.sbLc4Hvbu/7lpWQCTZemB8slEJGBjRxFT4BoP2ty',NULL,'2017-02-19 03:28:48','2017-02-19 03:28:48',0),(29,'333','33333@qq.com','$2y$10$FOXR2eWvcJBince8rKJG7uiI8YU.DNmQbS.m3eyvZdi4MdbGpFjSq',NULL,'2017-02-19 03:31:24','2017-02-19 03:31:24',0),(30,'333','333@qq.com','$2y$10$UOVdpjMhmvXK.m2jJgy81uIVyjmGcXh2xRDDJ2DDspYlrbsmlP9VS',NULL,'2017-02-19 03:32:23','2017-02-19 03:32:23',0),(31,'111','111@qq.com','$2y$10$pBuJbizGe8nm0gh/vmQVl.7KDqK/vYp7fEK48yvjXfQkUPaq45MZO',NULL,'2017-02-19 03:33:54','2017-02-19 03:33:54',0),(32,'123','123@qq.com','$2y$10$H7PUhPilbN1tz35LNLYbgO9wbA2Gsl3Jz8yfH1ntcvvvyeMSGFW/O',NULL,'2017-02-19 03:35:12','2017-02-19 03:35:12',0),(33,'123','321@qq.com','$2y$10$jZVt9WHMbhw573TrHS6qA.tEOQb8Q33SvtxAHwiXsi/AT27.PM6hq',NULL,'2017-02-19 03:36:39','2017-02-19 03:36:39',0),(34,'4444','4321@qq.com','$2y$10$mTPeQ8pfzvDRe4Ejny.81.FkNEn5LwJ7YrVSXwkCx.qKLa.7agnIS',NULL,'2017-02-19 03:37:17','2017-02-19 03:37:17',0),(36,'1','133@qq.com','$2y$10$pQrbR.5F9qQ1rl7HhLLg/e8atGdSit1EnF8iQWRdCY6.OxEbghXm.',NULL,'2017-02-19 09:45:10','2017-02-19 09:45:10',0),(37,'123','555@qq','$2y$10$/0Jx6AejCxyMbBUlNY336O.39BzIW/0wMXaofZr1XkgYAJ5zIu5We',NULL,'2017-02-20 08:45:08','2017-02-20 08:45:08',0),(38,'444','444444@qq','$2y$10$L6mySoGIRYngCJ32K7twIOtsaYCf4ZGDWznsxttGWal35GvOXTX0e',NULL,'2017-02-20 08:49:19','2017-02-20 08:49:19',0),(39,'123','111111@qq','$2y$10$VW5Zp3Kq5MViBEH/U6nqG.9NjoaWR2mehIRkzz.4Te3VsscuySQYm',NULL,'2017-02-20 09:06:58','2017-02-20 09:06:58',0),(40,'11','11@qq','$2y$10$onpeIngME3UyvhSJx3jxsuKiXFwZtsl5/wIgM0.4WaqAIr8lSbDva',NULL,'2017-02-20 09:21:41','2017-02-20 09:21:41',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
