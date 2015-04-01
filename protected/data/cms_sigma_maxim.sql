/*
Navicat MySQL Data Transfer

Source Server         : my_sql_local
Source Server Version : 50541
Source Host           : localhost:3306
Source Database       : cms_sigma

Target Server Type    : MYSQL
Target Server Version : 50541
File Encoding         : 65001

Date: 2015-04-01 16:57:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_actions`
-- ----------------------------
DROP TABLE IF EXISTS `admin_actions`;
CREATE TABLE `admin_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `controller_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `controller_id` (`controller_id`),
  CONSTRAINT `admin_actions_ibfk_1` FOREIGN KEY (`controller_id`) REFERENCES `admin_controllers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_actions
-- ----------------------------
INSERT INTO `admin_actions` VALUES ('1', 'index', '1');
INSERT INTO `admin_actions` VALUES ('2', 'index', '2');
INSERT INTO `admin_actions` VALUES ('3', 'index', '3');
INSERT INTO `admin_actions` VALUES ('4', 'index', '4');
INSERT INTO `admin_actions` VALUES ('5', 'index', '5');
INSERT INTO `admin_actions` VALUES ('6', 'categories', '4');

-- ----------------------------
-- Table structure for `admin_controllers`
-- ----------------------------
DROP TABLE IF EXISTS `admin_controllers`;
CREATE TABLE `admin_controllers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_controllers
-- ----------------------------
INSERT INTO `admin_controllers` VALUES ('1', 'main');
INSERT INTO `admin_controllers` VALUES ('2', 'menu');
INSERT INTO `admin_controllers` VALUES ('3', 'pages');
INSERT INTO `admin_controllers` VALUES ('4', 'products');
INSERT INTO `admin_controllers` VALUES ('5', 'settings');

-- ----------------------------
-- Table structure for `available`
-- ----------------------------
DROP TABLE IF EXISTS `available`;
CREATE TABLE `available` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_id` (`action_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `available_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `available_ibfk_2` FOREIGN KEY (`action_id`) REFERENCES `admin_actions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of available
-- ----------------------------
INSERT INTO `available` VALUES ('1', '1', '1');
INSERT INTO `available` VALUES ('2', '2', '1');
INSERT INTO `available` VALUES ('3', '3', '1');
INSERT INTO `available` VALUES ('4', '4', '1');
INSERT INTO `available` VALUES ('5', '5', '1');
INSERT INTO `available` VALUES ('6', '6', '1');
INSERT INTO `available` VALUES ('7', '1', '2');
INSERT INTO `available` VALUES ('8', '2', '2');
INSERT INTO `available` VALUES ('9', '3', '2');
INSERT INTO `available` VALUES ('10', '4', '2');
INSERT INTO `available` VALUES ('11', '5', '2');
INSERT INTO `available` VALUES ('12', '6', '2');

-- ----------------------------
-- Table structure for `contacts`
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `template` varchar(256) DEFAULT NULL,
  `map_url` varchar(1024) DEFAULT NULL,
  `map_code` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts
-- ----------------------------

-- ----------------------------
-- Table structure for `contacts_fields`
-- ----------------------------
DROP TABLE IF EXISTS `contacts_fields`;
CREATE TABLE `contacts_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contacts_id` int(11) DEFAULT NULL,
  `label` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts_fields
-- ----------------------------

-- ----------------------------
-- Table structure for `contacts_fields_trl`
-- ----------------------------
DROP TABLE IF EXISTS `contacts_fields_trl`;
CREATE TABLE `contacts_fields_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) DEFAULT NULL,
  `value` text,
  `contacts_field_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_field_id` (`contacts_field_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `contacts_fields_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `contacts_fields_trl_ibfk_1` FOREIGN KEY (`contacts_field_id`) REFERENCES `contacts_fields` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts_fields_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `contacts_trl`
-- ----------------------------
DROP TABLE IF EXISTS `contacts_trl`;
CREATE TABLE `contacts_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `contacts_id` int(11) DEFAULT NULL,
  `text` text,
  `title` text,
  `meta_description` text,
  PRIMARY KEY (`id`),
  KEY `contacts_id` (`contacts_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `contacts_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `contacts_trl_ibfk_1` FOREIGN KEY (`contacts_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of labels
-- ----------------------------
INSERT INTO `labels` VALUES ('1', 'label', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `labels_trl`
-- ----------------------------
DROP TABLE IF EXISTS `labels_trl`;
CREATE TABLE `labels_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translation_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `value` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `labels_lng_ibfk_1` (`translation_id`),
  KEY `labels_lng_ibfk_2` (`lng_id`),
  CONSTRAINT `labels_trl_ibfk_1` FOREIGN KEY (`translation_id`) REFERENCES `labels` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `labels_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of labels_trl
-- ----------------------------
INSERT INTO `labels_trl` VALUES ('1', '1', '1', 'label');
INSERT INTO `labels_trl` VALUES ('2', '1', '2', 'метка');

-- ----------------------------
-- Table structure for `languages`
-- ----------------------------
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `prefix` varchar(16) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of languages
-- ----------------------------
INSERT INTO `languages` VALUES ('1', 'english', 'en', null);
INSERT INTO `languages` VALUES ('2', 'русский', 'ru', null);

-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `template_name` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'Main menu', '1', '0', '1427279702', '1', 'main_menu.php');
INSERT INTO `menu` VALUES ('2', 'Additional Menu', '1', '0', '1427279715', '1', 'main_menu.php');
INSERT INTO `menu` VALUES ('4', 'RIght menu', '1', '1427278569', '1427279732', '1', 'main_menu.php');

-- ----------------------------
-- Table structure for `menu_item`
-- ----------------------------
DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE `menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `branch` varchar(128) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `content_item_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `type_id` (`type_id`),
  KEY `content_item_id` (`content_item_id`),
  CONSTRAINT `menu_item_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `menu_item_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `menu_item_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu_item
-- ----------------------------
INSERT INTO `menu_item` VALUES ('1', '1', '0:1', 'News', '0', '4', '2', null, '1', '0', '1427712447', '1');
INSERT INTO `menu_item` VALUES ('10', '1', '0:10', 'Products', '0', '5', '1', '5', '1', '0', '1427712447', '1');
INSERT INTO `menu_item` VALUES ('11', '1', '0:11', 'Tests', '0', '6', '1', null, '1', '0', '1427712447', '1');
INSERT INTO `menu_item` VALUES ('12', '1', '0:12', 'Other', '0', '3', '1', null, '1', '0', '1427712447', '1');
INSERT INTO `menu_item` VALUES ('31', '1', '0:10:31', 'Page 3', '10', '1', '1', '6', '1', '1427472506', '1427705893', '1');
INSERT INTO `menu_item` VALUES ('32', '1', '0:10:32', 'Some label', '10', '2', '1', '5', '1', '1427706388', '1427706430', '1');

-- ----------------------------
-- Table structure for `menu_item_trl`
-- ----------------------------
DROP TABLE IF EXISTS `menu_item_trl`;
CREATE TABLE `menu_item_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(256) DEFAULT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_item_id` (`menu_item_id`),
  KEY `menu_item_trl_ibfk_2` (`lng_id`),
  CONSTRAINT `menu_item_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `menu_item_trl_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu_item_trl
-- ----------------------------
INSERT INTO `menu_item_trl` VALUES ('1', 'News', '1', '1');
INSERT INTO `menu_item_trl` VALUES ('2', 'Новости', '1', '2');
INSERT INTO `menu_item_trl` VALUES ('51', 'bbbbbb', '10', '1');
INSERT INTO `menu_item_trl` VALUES ('52', 'GGG', '10', '2');
INSERT INTO `menu_item_trl` VALUES ('53', 'Some title', '32', '1');
INSERT INTO `menu_item_trl` VALUES ('54', 'Какое-то название', '32', '2');

-- ----------------------------
-- Table structure for `menu_item_type`
-- ----------------------------
DROP TABLE IF EXISTS `menu_item_type`;
CREATE TABLE `menu_item_type` (
  `id` int(11) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu_item_type
-- ----------------------------
INSERT INTO `menu_item_type` VALUES ('1', 'Single page');
INSERT INTO `menu_item_type` VALUES ('2', 'News catalog');
INSERT INTO `menu_item_type` VALUES ('3', 'Product catalog');
INSERT INTO `menu_item_type` VALUES ('4', 'Contact form');
INSERT INTO `menu_item_type` VALUES ('5', 'Complex page');

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
-- Table structure for `messages_trl`
-- ----------------------------
DROP TABLE IF EXISTS `messages_trl`;
CREATE TABLE `messages_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translation_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `value` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `labels_lng_ibfk_1` (`translation_id`),
  KEY `labels_lng_ibfk_2` (`lng_id`),
  CONSTRAINT `messages_trl_ibfk_1` FOREIGN KEY (`translation_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `messages_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of messages_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `label` char(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_update` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `news_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------

-- ----------------------------
-- Table structure for `news_category`
-- ----------------------------
DROP TABLE IF EXISTS `news_category`;
CREATE TABLE `news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `label` char(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_update` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_category
-- ----------------------------

-- ----------------------------
-- Table structure for `news_category_trl`
-- ----------------------------
DROP TABLE IF EXISTS `news_category_trl`;
CREATE TABLE `news_category_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(512) DEFAULT NULL,
  `meta_description` varchar(256) DEFAULT NULL,
  `description` text,
  `news_category_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_category_id` (`news_category_id`),
  CONSTRAINT `news_category_trl_ibfk_1` FOREIGN KEY (`news_category_id`) REFERENCES `news_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_category_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `news_trl`
-- ----------------------------
DROP TABLE IF EXISTS `news_trl`;
CREATE TABLE `news_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(512) DEFAULT NULL,
  `meta_description` varchar(256) DEFAULT NULL,
  `content` text,
  `small_content` text,
  `news_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `news_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `news_trl_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `page`
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` char(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_update` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page
-- ----------------------------
INSERT INTO `page` VALUES ('8', 'Page 1', null, null, null, null, null);
INSERT INTO `page` VALUES ('9', 'Page 2', null, null, null, null, null);

-- ----------------------------
-- Table structure for `page_trl`
-- ----------------------------
DROP TABLE IF EXISTS `page_trl`;
CREATE TABLE `page_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) DEFAULT NULL,
  `meta_description` varchar(256) DEFAULT NULL,
  `content` text,
  `page_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`page_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `page_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `page_trl_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_trl
-- ----------------------------
INSERT INTO `page_trl` VALUES ('3', 'Some page 1', null, null, '8', '1');
INSERT INTO `page_trl` VALUES ('4', 'Какая-то страница 1', null, null, '8', '2');
INSERT INTO `page_trl` VALUES ('5', 'Some page 2', null, null, '9', '1');
INSERT INTO `page_trl` VALUES ('6', 'Какая-то страница 2', null, null, '9', '2');

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `label` char(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `discount_price` int(11) DEFAULT NULL,
  `is_new` int(11) DEFAULT NULL,
  `stock_qnt` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_update` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------

-- ----------------------------
-- Table structure for `product_category`
-- ----------------------------
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `label` char(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_update` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_category
-- ----------------------------

-- ----------------------------
-- Table structure for `product_category_trl`
-- ----------------------------
DROP TABLE IF EXISTS `product_category_trl`;
CREATE TABLE `product_category_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(512) DEFAULT NULL,
  `meta_description` varchar(256) DEFAULT NULL,
  `description` text,
  `product_category_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_id` (`product_category_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `product_category_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_category_trl_ibfk_2` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_category_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `product_trl`
-- ----------------------------
DROP TABLE IF EXISTS `product_trl`;
CREATE TABLE `product_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(512) DEFAULT NULL,
  `meta_description` varchar(256) DEFAULT NULL,
  `content` text,
  `small_content` text,
  `product_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `product_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_trl_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value_name` varchar(255) DEFAULT NULL,
  `setting` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of settings
-- ----------------------------

-- ----------------------------
-- Table structure for `status`
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(11) NOT NULL DEFAULT '0',
  `label` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of status
-- ----------------------------
INSERT INTO `status` VALUES ('1', 'Visible');
INSERT INTO `status` VALUES ('2', 'Hidden');
INSERT INTO `status` VALUES ('3', 'Deleted');
INSERT INTO `status` VALUES ('4', 'Suspended');
INSERT INTO `status` VALUES ('5', 'Wait for activation');

-- ----------------------------
-- Table structure for `system_widget`
-- ----------------------------
DROP TABLE IF EXISTS `system_widget`;
CREATE TABLE `system_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` char(128) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `template_name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_widget_ibfk_1` (`type_id`),
  CONSTRAINT `system_widget_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `system_widget_type` (`int`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_widget
-- ----------------------------
INSERT INTO `system_widget` VALUES ('1', 'Search field', '1', 'template');
INSERT INTO `system_widget` VALUES ('2', 'Login widget', '2', 'template');
INSERT INTO `system_widget` VALUES ('3', 'Small login widget', '2', 'template_small');
INSERT INTO `system_widget` VALUES ('4', 'Languages in top', '4', 'template_top');
INSERT INTO `system_widget` VALUES ('5', 'Languages', '4', 'template');
INSERT INTO `system_widget` VALUES ('6', 'My custom widget', '6', 'template');

-- ----------------------------
-- Table structure for `system_widget_trl`
-- ----------------------------
DROP TABLE IF EXISTS `system_widget_trl`;
CREATE TABLE `system_widget_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_name` varchar(256) DEFAULT NULL,
  `custom_html` text,
  `widget_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lng_id` (`lng_id`),
  KEY `widget_id` (`widget_id`),
  CONSTRAINT `system_widget_trl_ibfk_1` FOREIGN KEY (`widget_id`) REFERENCES `system_widget` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `system_widget_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_widget_trl
-- ----------------------------
INSERT INTO `system_widget_trl` VALUES ('1', 'My custom widget', '<p>some html</p>', '6', '1');
INSERT INTO `system_widget_trl` VALUES ('2', 'Мой кастомный виджет', '<p>какой-то HTML</p>', '6', '1');

-- ----------------------------
-- Table structure for `system_widget_type`
-- ----------------------------
DROP TABLE IF EXISTS `system_widget_type`;
CREATE TABLE `system_widget_type` (
  `int` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`int`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_widget_type
-- ----------------------------
INSERT INTO `system_widget_type` VALUES ('1', 'Search Form');
INSERT INTO `system_widget_type` VALUES ('2', 'Login form');
INSERT INTO `system_widget_type` VALUES ('3', 'Calendar');
INSERT INTO `system_widget_type` VALUES ('4', 'Language Bar');
INSERT INTO `system_widget_type` VALUES ('5', 'Product cart');
INSERT INTO `system_widget_type` VALUES ('6', 'Custom HTML');

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
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'admin@email.com', '71c0106e3d8f4a870cb11a718af1d978', '54f96960d6093', 'Joe', 'Bloe', '1');

-- ----------------------------
-- Table structure for `user_role`
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(256) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES ('1', 'root', 'root');
INSERT INTO `user_role` VALUES ('2', 'admin', 'admin');

-- ----------------------------
-- Table structure for `wid_registration`
-- ----------------------------
DROP TABLE IF EXISTS `wid_registration`;
CREATE TABLE `wid_registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `position_nr` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `obj_id` (`widget_id`),
  KEY `wid_registration_ibfk_1` (`type_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `wid_registration_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `wid_registration_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `wid_registration_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `wid_registration_ibfk_3` FOREIGN KEY (`widget_id`) REFERENCES `system_widget` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wid_registration
-- ----------------------------
INSERT INTO `wid_registration` VALUES ('3', '1', null, '1', '1', '1', '1');
INSERT INTO `wid_registration` VALUES ('4', '2', null, '1', '1', '2', '1');
INSERT INTO `wid_registration` VALUES ('5', '3', null, '1', '2', '1', '1');
INSERT INTO `wid_registration` VALUES ('6', '4', null, '1', '3', '1', '1');
INSERT INTO `wid_registration` VALUES ('7', '5', null, '1', '4', '1', '1');
INSERT INTO `wid_registration` VALUES ('8', null, '1', '2', '5', '1', '1');

-- ----------------------------
-- Table structure for `wid_registration_type`
-- ----------------------------
DROP TABLE IF EXISTS `wid_registration_type`;
CREATE TABLE `wid_registration_type` (
  `id` int(11) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wid_registration_type
-- ----------------------------
INSERT INTO `wid_registration_type` VALUES ('1', 'Widget');
INSERT INTO `wid_registration_type` VALUES ('2', 'Menu');