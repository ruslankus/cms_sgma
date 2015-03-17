/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : ruslan's CMS

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2015-03-17 13:35:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `content_types`
-- ----------------------------
DROP TABLE IF EXISTS `content_types`;
CREATE TABLE `content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of content_types
-- ----------------------------

-- ----------------------------
-- Table structure for `faq`
-- ----------------------------
DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of faq
-- ----------------------------

-- ----------------------------
-- Table structure for `faq_lng`
-- ----------------------------
DROP TABLE IF EXISTS `faq_lng`;
CREATE TABLE `faq_lng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `faq_id` int(11) DEFAULT NULL,
  `question` int(11) DEFAULT NULL,
  `answer` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lng_id` (`lng_id`),
  KEY `faq_id` (`faq_id`),
  CONSTRAINT `faq_lng_ibfk_2` FOREIGN KEY (`faq_id`) REFERENCES `faq` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `faq_lng_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of faq_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `faq_to_product`
-- ----------------------------
DROP TABLE IF EXISTS `faq_to_product`;
CREATE TABLE `faq_to_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `faq_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `faq_id` (`faq_id`),
  CONSTRAINT `faq_to_product_ibfk_2` FOREIGN KEY (`faq_id`) REFERENCES `faq` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `faq_to_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of faq_to_product
-- ----------------------------

-- ----------------------------
-- Table structure for `features`
-- ----------------------------
DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of features
-- ----------------------------

-- ----------------------------
-- Table structure for `features_lng`
-- ----------------------------
DROP TABLE IF EXISTS `features_lng`;
CREATE TABLE `features_lng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `feature_id` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `lng_id` (`lng_id`),
  KEY `feature_id` (`feature_id`),
  CONSTRAINT `features_lng_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `features_lng_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of features_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `features_to_product`
-- ----------------------------
DROP TABLE IF EXISTS `features_to_product`;
CREATE TABLE `features_to_product` (
  `int` int(11) NOT NULL AUTO_INCREMENT,
  `feature_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`int`),
  KEY `feature_id` (`feature_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `features_to_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `features_to_product_ibfk_1` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of features_to_product
-- ----------------------------

-- ----------------------------
-- Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `filename` varchar(256) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `item_type_id` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images
-- ----------------------------

-- ----------------------------
-- Table structure for `images_lng`
-- ----------------------------
DROP TABLE IF EXISTS `images_lng`;
CREATE TABLE `images_lng` (
  `id` int(11) NOT NULL DEFAULT '0',
  `lng_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `description` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lng_id` (`lng_id`),
  KEY `images_lng_ibfk_2` (`image_id`),
  CONSTRAINT `images_lng_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `images_lng_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `labels`
-- ----------------------------
DROP TABLE IF EXISTS `labels`;
CREATE TABLE `labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(256) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of labels
-- ----------------------------

-- ----------------------------
-- Table structure for `labels_lng`
-- ----------------------------
DROP TABLE IF EXISTS `labels_lng`;
CREATE TABLE `labels_lng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `translation_id` int(11) DEFAULT NULL,
  `value` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `labels_lng_ibfk_1` (`translation_id`),
  KEY `labels_lng_ibfk_2` (`lng_id`),
  CONSTRAINT `labels_lng_ibfk_1` FOREIGN KEY (`translation_id`) REFERENCES `labels` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `labels_lng_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of labels_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `languages`
-- ----------------------------
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `prefix` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of languages
-- ----------------------------

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(64) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menus
-- ----------------------------

-- ----------------------------
-- Table structure for `menus_lng`
-- ----------------------------
DROP TABLE IF EXISTS `menus_lng`;
CREATE TABLE `menus_lng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `menus_lng_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menus_lng_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menus_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `menu_to_page`
-- ----------------------------
DROP TABLE IF EXISTS `menu_to_page`;
CREATE TABLE `menu_to_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_to_page_ibfk_1` (`menu_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `menu_to_page_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menu_to_page_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu_to_page
-- ----------------------------

-- ----------------------------
-- Table structure for `messages`
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(256) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of messages
-- ----------------------------

-- ----------------------------
-- Table structure for `messages_lng`
-- ----------------------------
DROP TABLE IF EXISTS `messages_lng`;
CREATE TABLE `messages_lng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `translation_id` int(11) DEFAULT NULL,
  `value` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `labels_lng_ibfk_1` (`translation_id`),
  KEY `labels_lng_ibfk_2` (`lng_id`),
  CONSTRAINT `messages_lng_ibfk_1` FOREIGN KEY (`translation_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `messages_lng_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of messages_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `branch` varchar(128) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------

-- ----------------------------
-- Table structure for `news_lng`
-- ----------------------------
DROP TABLE IF EXISTS `news_lng`;
CREATE TABLE `news_lng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(2048) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `news_lng_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`),
  CONSTRAINT `news_lng_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `news` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `pages`
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `branch` varchar(512) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_ibfk_1` (`type_id`),
  CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `content_types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pages
-- ----------------------------

-- ----------------------------
-- Table structure for `pages_lng`
-- ----------------------------
DROP TABLE IF EXISTS `pages_lng`;
CREATE TABLE `pages_lng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `pages_lng_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `pages_lng_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pages_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `branch` varchar(128) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `discount_price` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of products
-- ----------------------------

-- ----------------------------
-- Table structure for `products_lng`
-- ----------------------------
DROP TABLE IF EXISTS `products_lng`;
CREATE TABLE `products_lng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(2048) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `products_lng_ibfk_2` (`lng_id`),
  KEY `products_lng_ibfk_1` (`item_id`),
  CONSTRAINT `products_lng_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `products_lng_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of products_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `statuses`
-- ----------------------------
DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of statuses
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `password_salt` varchar(128) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `surname` varchar(64) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for `user_roles`
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
