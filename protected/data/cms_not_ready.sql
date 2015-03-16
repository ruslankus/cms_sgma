/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : ruslan's CMS

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2015-03-16 18:10:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `languages`
-- ----------------------------
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `prefix` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
  CONSTRAINT `menus_lng_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menus_lng_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menus_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `translations`
-- ----------------------------
DROP TABLE IF EXISTS `translations`;
CREATE TABLE `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of translations
-- ----------------------------

-- ----------------------------
-- Table structure for `translations_lng`
-- ----------------------------
DROP TABLE IF EXISTS `translations_lng`;
CREATE TABLE `translations_lng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `translation_id` int(11) DEFAULT NULL,
  `value` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `translations_lng_ibfk_2` (`lng_id`),
  KEY `translations_lng_ibfk_1` (`translation_id`),
  CONSTRAINT `translations_lng_ibfk_1` FOREIGN KEY (`translation_id`) REFERENCES `translations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `translations_lng_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of translations_lng
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `surname` varchar(64) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
