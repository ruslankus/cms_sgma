/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : cms_sigma

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2015-04-24 11:39:41
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
-- Table structure for `complex_page`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page`;
CREATE TABLE `complex_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `template_name` varchar(512) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `complex_page_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page
-- ----------------------------
INSERT INTO `complex_page` VALUES ('5', 'Testing', 'page.php', '1', '1429782601', '1429864248', '1', '1');

-- ----------------------------
-- Table structure for `complex_page_fields`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_fields`;
CREATE TABLE `complex_page_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(256) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `complex_page_fields_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `complex_page_field_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `complex_page_fields_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `complex_page_field_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_fields
-- ----------------------------
INSERT INTO `complex_page_fields` VALUES ('1', 'Name', '3', '1', '1', '1429785664', '1429785865', '1');
INSERT INTO `complex_page_fields` VALUES ('2', 'About', '4', '1', '2', '1429785716', '1429785865', '1');
INSERT INTO `complex_page_fields` VALUES ('4', 'Some numeric val', '1', '3', '1', '1429786323', '1429786323', '1');
INSERT INTO `complex_page_fields` VALUES ('5', 'Selector', '6', '3', '2', '1429792204', '1429801348', '1');
INSERT INTO `complex_page_fields` VALUES ('6', 'Image', '5', '3', '3', '1429792249', '1429792249', '1');

-- ----------------------------
-- Table structure for `complex_page_fields_trl`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_fields_trl`;
CREATE TABLE `complex_page_fields_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_field_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `field_description` text,
  `field_title` text,
  PRIMARY KEY (`id`),
  KEY `page_field_id` (`page_field_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `complex_page_fields_trl_ibfk_1` FOREIGN KEY (`page_field_id`) REFERENCES `complex_page_fields` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `complex_page_fields_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_fields_trl
-- ----------------------------
INSERT INTO `complex_page_fields_trl` VALUES ('1', '1', '1', 'Some description', 'Name');
INSERT INTO `complex_page_fields_trl` VALUES ('2', '1', '2', 'Какое-то описание', 'Имя');
INSERT INTO `complex_page_fields_trl` VALUES ('3', '2', '1', '', 'About');
INSERT INTO `complex_page_fields_trl` VALUES ('4', '2', '2', '', 'О нас');
INSERT INTO `complex_page_fields_trl` VALUES ('7', '4', '1', '', 'Some numeric val');
INSERT INTO `complex_page_fields_trl` VALUES ('8', '4', '2', '', '');
INSERT INTO `complex_page_fields_trl` VALUES ('9', '5', '1', '', 'Selector');
INSERT INTO `complex_page_fields_trl` VALUES ('10', '5', '2', '', '');
INSERT INTO `complex_page_fields_trl` VALUES ('11', '6', '1', '', 'Image');
INSERT INTO `complex_page_fields_trl` VALUES ('12', '6', '2', '', '');

-- ----------------------------
-- Table structure for `complex_page_field_groups`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_field_groups`;
CREATE TABLE `complex_page_field_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_field_groups
-- ----------------------------
INSERT INTO `complex_page_field_groups` VALUES ('1', 'Group one', '2', '1429795825', '1429783985', '1');
INSERT INTO `complex_page_field_groups` VALUES ('3', 'Group two', '1', '1429795825', '1429786305', '1');

-- ----------------------------
-- Table structure for `complex_page_field_groups_active`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_field_groups_active`;
CREATE TABLE `complex_page_field_groups_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `complex_page_field_groups_active_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `complex_page_field_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `complex_page_field_groups_active_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `complex_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_field_groups_active
-- ----------------------------
INSERT INTO `complex_page_field_groups_active` VALUES ('5', '3', '5', '1');
INSERT INTO `complex_page_field_groups_active` VALUES ('6', '1', '5', '2');

-- ----------------------------
-- Table structure for `complex_page_field_groups_trl`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_field_groups_trl`;
CREATE TABLE `complex_page_field_groups_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(512) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `lng_id` (`lng_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `complex_page_field_groups_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `complex_page_field_groups_trl_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `complex_page_field_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_field_groups_trl
-- ----------------------------
INSERT INTO `complex_page_field_groups_trl` VALUES ('1', '1', '1', 'Group one', 'Group description');
INSERT INTO `complex_page_field_groups_trl` VALUES ('2', '2', '1', 'Группа один', 'Описание');
INSERT INTO `complex_page_field_groups_trl` VALUES ('5', '1', '3', 'Group two', '');
INSERT INTO `complex_page_field_groups_trl` VALUES ('6', '2', '3', '', '');

-- ----------------------------
-- Table structure for `complex_page_field_select_options`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_field_select_options`;
CREATE TABLE `complex_page_field_select_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) DEFAULT NULL,
  `option_name` varchar(128) DEFAULT NULL,
  `option_value` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`),
  CONSTRAINT `complex_page_field_select_options_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `complex_page_fields` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_field_select_options
-- ----------------------------
INSERT INTO `complex_page_field_select_options` VALUES ('8', '5', 'Sel1', 'hh');
INSERT INTO `complex_page_field_select_options` VALUES ('9', '5', 'Sel2', 'gg');
INSERT INTO `complex_page_field_select_options` VALUES ('10', '5', 'Sel3', 'tt');

-- ----------------------------
-- Table structure for `complex_page_field_types`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_field_types`;
CREATE TABLE `complex_page_field_types` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_field_types
-- ----------------------------
INSERT INTO `complex_page_field_types` VALUES ('1', 'Numeric');
INSERT INTO `complex_page_field_types` VALUES ('2', 'Date');
INSERT INTO `complex_page_field_types` VALUES ('3', 'Text');
INSERT INTO `complex_page_field_types` VALUES ('4', 'Translatable text');
INSERT INTO `complex_page_field_types` VALUES ('5', 'Images');
INSERT INTO `complex_page_field_types` VALUES ('6', 'Selectable value');

-- ----------------------------
-- Table structure for `complex_page_field_values`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_field_values`;
CREATE TABLE `complex_page_field_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `numeric_value` int(11) DEFAULT NULL,
  `selected_option_id` int(11) DEFAULT NULL,
  `text_value` text,
  `time_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `field_id` (`field_id`),
  CONSTRAINT `complex_page_field_values_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `complex_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `complex_page_field_values_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `complex_page_fields` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_field_values
-- ----------------------------
INSERT INTO `complex_page_field_values` VALUES ('1', '5', '2', null, null, null, null);
INSERT INTO `complex_page_field_values` VALUES ('2', '5', '1', null, null, 'My name is', null);
INSERT INTO `complex_page_field_values` VALUES ('3', '5', '4', '5998', null, null, null);
INSERT INTO `complex_page_field_values` VALUES ('4', '5', '5', null, '9', null, null);
INSERT INTO `complex_page_field_values` VALUES ('5', '5', '6', null, null, null, null);

-- ----------------------------
-- Table structure for `complex_page_field_values_trl`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_field_values_trl`;
CREATE TABLE `complex_page_field_values_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `field_value_id` int(11) DEFAULT NULL,
  `translatable_text` text,
  PRIMARY KEY (`id`),
  KEY `lng_id` (`lng_id`),
  KEY `field_value_id` (`field_value_id`),
  CONSTRAINT `complex_page_field_values_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `complex_page_field_values_trl_ibfk_2` FOREIGN KEY (`field_value_id`) REFERENCES `complex_page_field_values` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_field_values_trl
-- ----------------------------
INSERT INTO `complex_page_field_values_trl` VALUES ('1', '1', '1', 'Test');
INSERT INTO `complex_page_field_values_trl` VALUES ('2', '2', '1', 'Тест');

-- ----------------------------
-- Table structure for `complex_page_trl`
-- ----------------------------
DROP TABLE IF EXISTS `complex_page_trl`;
CREATE TABLE `complex_page_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `title` varchar(1024) DEFAULT NULL,
  `text` text,
  `meta_keywords` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `complex_page_trl_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `complex_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `complex_page_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of complex_page_trl
-- ----------------------------
INSERT INTO `complex_page_trl` VALUES ('9', '5', '1', 'Testing', 'Text text text, lots of text, text text text text Text text text, lots of text, text text text textText text text, lots of text, text text text textText text text, lots of text, text text text textText text text, lots of text, text text text textText text text, lots of text, text text text textText text text, lots of text, text text text text', 'Keyword1, keyword2, keyword3');
INSERT INTO `complex_page_trl` VALUES ('10', '5', '2', 'Тестинг', '', '');

-- ----------------------------
-- Table structure for `contacts_block`
-- ----------------------------
DROP TABLE IF EXISTS `contacts_block`;
CREATE TABLE `contacts_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `template_name` varchar(256) DEFAULT NULL,
  `map_url` varchar(1024) DEFAULT NULL,
  `map_code` text,
  `priority` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `contacts_block_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `contacts_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts_block
-- ----------------------------
INSERT INTO `contacts_block` VALUES ('1', '1', 'block1', 'default.php', null, null, '1', '1429171862', '0', '1');
INSERT INTO `contacts_block` VALUES ('2', '1', 'block2', 'default.php', null, null, '2', '1429171862', '0', '1');
INSERT INTO `contacts_block` VALUES ('3', '2', 'other block', 'default.php', null, null, '1', '0', '0', '1');

-- ----------------------------
-- Table structure for `contacts_block_trl`
-- ----------------------------
DROP TABLE IF EXISTS `contacts_block_trl`;
CREATE TABLE `contacts_block_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `text` text,
  `title` text,
  `meta_description` text,
  PRIMARY KEY (`id`),
  KEY `lng_id` (`lng_id`),
  KEY `block_id` (`block_id`),
  CONSTRAINT `contacts_block_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `contacts_block_trl_ibfk_3` FOREIGN KEY (`block_id`) REFERENCES `contacts_block` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts_block_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `contacts_fields`
-- ----------------------------
DROP TABLE IF EXISTS `contacts_fields`;
CREATE TABLE `contacts_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) DEFAULT NULL,
  `label` text,
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`),
  CONSTRAINT `contacts_fields_ibfk_1` FOREIGN KEY (`block_id`) REFERENCES `contacts_block` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
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
  CONSTRAINT `contacts_fields_trl_ibfk_1` FOREIGN KEY (`contacts_field_id`) REFERENCES `contacts_fields` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `contacts_fields_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts_fields_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `contacts_page`
-- ----------------------------
DROP TABLE IF EXISTS `contacts_page`;
CREATE TABLE `contacts_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `template_name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts_page
-- ----------------------------
INSERT INTO `contacts_page` VALUES ('1', 'Contacts', '1', '1', '0', '1429171769', '1', 'default.php');
INSERT INTO `contacts_page` VALUES ('2', 'Additional contacts', '1', '1', '0', '1429171769', '1', 'default.php');

-- ----------------------------
-- Table structure for `contacts_page_trl`
-- ----------------------------
DROP TABLE IF EXISTS `contacts_page_trl`;
CREATE TABLE `contacts_page_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `title` varchar(512) DEFAULT NULL,
  `description` text,
  `meta_keywords` varchar(256) DEFAULT NULL,
  `meta_description` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lng_id` (`lng_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `contacts_page_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `contacts_page_trl_ibfk_3` FOREIGN KEY (`page_id`) REFERENCES `contacts_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts_page_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `filename` varchar(1024) DEFAULT NULL,
  `original_filename` varchar(1024) DEFAULT NULL,
  `mime_type` varchar(64) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `images_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES ('19', 'Image of \"Some title\"', '553753bd1de4a.jpg', 'Koala.jpg', 'image/jpeg', '780831', '1');
INSERT INTO `images` VALUES ('20', 'Image of \"Some title\"', '553755397403d.jpg', 'Jellyfish.jpg', 'image/jpeg', '775702', '1');
INSERT INTO `images` VALUES ('21', 'Image of \"One more product\"', '55379ffb0d22c.jpg', 'Chrysanthemum.jpg', 'image/jpeg', '879394', '1');
INSERT INTO `images` VALUES ('22', 'Image of \"Testing\"', '5538d1df8c8eb.jpg', 'Tulips.jpg', 'image/jpeg', '620888', '1');
INSERT INTO `images` VALUES ('23', 'Image of \"Testing\"', '5538d2712751a.jpg', 'Koala.jpg', 'image/jpeg', '780831', '1');
INSERT INTO `images` VALUES ('24', 'Image of \"Testing\"', '5538d2763fcde.jpg', 'Jellyfish.jpg', 'image/jpeg', '775702', '1');
INSERT INTO `images` VALUES ('25', 'Image of \"Testing\"', '5539f49f8ec73.jpg', 'Koala.jpg', 'image/jpeg', '780831', '1');
INSERT INTO `images` VALUES ('26', 'Image of \"Testing\"', '5539fe66372aa.jpg', 'Lighthouse.jpg', 'image/jpeg', '561276', '1');
INSERT INTO `images` VALUES ('27', 'Image of \"Testing\"', '5539ff387cff6.jpg', 'Tulips.jpg', 'image/jpeg', '620888', '1');

-- ----------------------------
-- Table structure for `images_of_complex_page`
-- ----------------------------
DROP TABLE IF EXISTS `images_of_complex_page`;
CREATE TABLE `images_of_complex_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `image_id` (`image_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `images_of_complex_page_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `images_of_complex_page_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `complex_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_of_complex_page
-- ----------------------------
INSERT INTO `images_of_complex_page` VALUES ('1', '25', '5');

-- ----------------------------
-- Table structure for `images_of_complex_page_field_values`
-- ----------------------------
DROP TABLE IF EXISTS `images_of_complex_page_field_values`;
CREATE TABLE `images_of_complex_page_field_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `field_value_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `image_id` (`image_id`),
  KEY `field_value_id` (`field_value_id`),
  CONSTRAINT `images_of_complex_page_field_values_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `images_of_complex_page_field_values_ibfk_2` FOREIGN KEY (`field_value_id`) REFERENCES `complex_page_field_values` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_of_complex_page_field_values
-- ----------------------------
INSERT INTO `images_of_complex_page_field_values` VALUES ('3', '19', '5');

-- ----------------------------
-- Table structure for `images_of_contacts`
-- ----------------------------
DROP TABLE IF EXISTS `images_of_contacts`;
CREATE TABLE `images_of_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `contact_page_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `image_id` (`image_id`),
  KEY `contact_page_id` (`contact_page_id`),
  CONSTRAINT `images_of_contacts_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `images_of_contacts_ibfk_2` FOREIGN KEY (`contact_page_id`) REFERENCES `contacts_page` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_of_contacts
-- ----------------------------

-- ----------------------------
-- Table structure for `images_of_news`
-- ----------------------------
DROP TABLE IF EXISTS `images_of_news`;
CREATE TABLE `images_of_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `image_id` (`image_id`),
  CONSTRAINT `images_of_news_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `images_of_news_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_of_news
-- ----------------------------

-- ----------------------------
-- Table structure for `images_of_page`
-- ----------------------------
DROP TABLE IF EXISTS `images_of_page`;
CREATE TABLE `images_of_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `image_id` (`image_id`),
  CONSTRAINT `images_of_page_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE,
  CONSTRAINT `images_of_page_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_of_page
-- ----------------------------

-- ----------------------------
-- Table structure for `images_of_product`
-- ----------------------------
DROP TABLE IF EXISTS `images_of_product`;
CREATE TABLE `images_of_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `image_id` (`image_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `images_of_product_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `images_of_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_of_product
-- ----------------------------
INSERT INTO `images_of_product` VALUES ('3', '19', '14');
INSERT INTO `images_of_product` VALUES ('4', '20', '14');
INSERT INTO `images_of_product` VALUES ('5', '21', '15');

-- ----------------------------
-- Table structure for `images_of_product_fields_values`
-- ----------------------------
DROP TABLE IF EXISTS `images_of_product_fields_values`;
CREATE TABLE `images_of_product_fields_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `field_value_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `image_id` (`image_id`),
  KEY `field_value_id` (`field_value_id`),
  CONSTRAINT `images_of_product_fields_values_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `images_of_product_fields_values_ibfk_2` FOREIGN KEY (`field_value_id`) REFERENCES `product_field_values` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_of_product_fields_values
-- ----------------------------

-- ----------------------------
-- Table structure for `images_of_widget`
-- ----------------------------
DROP TABLE IF EXISTS `images_of_widget`;
CREATE TABLE `images_of_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `image_id` (`image_id`),
  KEY `widget_id` (`widget_id`),
  CONSTRAINT `images_of_widget_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `images_of_widget_ibfk_2` FOREIGN KEY (`widget_id`) REFERENCES `system_widget` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_of_widget
-- ----------------------------

-- ----------------------------
-- Table structure for `images_trl`
-- ----------------------------
DROP TABLE IF EXISTS `images_trl`;
CREATE TABLE `images_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `caption` varchar(1024) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `image_id` (`image_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `images_trl_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `images_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images_trl
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of labels_trl
-- ----------------------------

-- ----------------------------
-- Table structure for `languages`
-- ----------------------------
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `prefix` varchar(16) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '0',
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of languages
-- ----------------------------
INSERT INTO `languages` VALUES ('1', 'english', 'en', null, '1', null);
INSERT INTO `languages` VALUES ('2', 'русский', 'ru', null, '1', null);

-- ----------------------------
-- Table structure for `marks`
-- ----------------------------
DROP TABLE IF EXISTS `marks`;
CREATE TABLE `marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark_value` int(11) DEFAULT NULL,
  `mark_name` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of marks
-- ----------------------------
INSERT INTO `marks` VALUES ('1', '1', 'a');
INSERT INTO `marks` VALUES ('2', '2', 'b');
INSERT INTO `marks` VALUES ('3', '3', 'c');
INSERT INTO `marks` VALUES ('4', '4', 'd');
INSERT INTO `marks` VALUES ('5', '5', 'e');

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
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('5', 'Main menu', '1', '1427987138', '1427987138', '1', 'main_menu.php');
INSERT INTO `menu` VALUES ('6', 'Bottom menu', '1', '1427987161', '1429694972', '1', 'default.php');
INSERT INTO `menu` VALUES ('7', 'еуыеыу', '1', '1428671996', '1428671996', '1', 'main_menu.php');

-- ----------------------------
-- Table structure for `menu_item`
-- ----------------------------
DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE `menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
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
  KEY `status_id` (`status_id`),
  CONSTRAINT `menu_item_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `menu_item_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `menu_item_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `menu_item_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu_item
-- ----------------------------
INSERT INTO `menu_item` VALUES ('31', '5', 'Home page', '0', '3', '1', '8', '1', '1427987229', '1429795369', '1');
INSERT INTO `menu_item` VALUES ('32', '5', 'News', '0', '5', '2', '7', '1', '1427987311', '1429795369', '1');
INSERT INTO `menu_item` VALUES ('33', '5', 'Products', '0', '4', '3', '1', '1', '1427987366', '1429795369', '1');
INSERT INTO `menu_item` VALUES ('34', '5', 'Contacts', '0', '1', '1', '8', '1', '1427987474', '1429795369', '1');
INSERT INTO `menu_item` VALUES ('35', '5', 'Complex page', '0', '2', '5', '5', '1', '1429795364', '1429795369', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu_item_trl
-- ----------------------------
INSERT INTO `menu_item_trl` VALUES ('91', 'Home page', '31', '1');
INSERT INTO `menu_item_trl` VALUES ('92', 'Главная', '31', '2');
INSERT INTO `menu_item_trl` VALUES ('93', 'News', '32', '1');
INSERT INTO `menu_item_trl` VALUES ('94', 'Новости', '32', '2');
INSERT INTO `menu_item_trl` VALUES ('95', 'Products', '33', '1');
INSERT INTO `menu_item_trl` VALUES ('96', 'Продукты', '33', '2');
INSERT INTO `menu_item_trl` VALUES ('97', 'Contacts', '34', '1');
INSERT INTO `menu_item_trl` VALUES ('98', 'Контакты', '34', '2');
INSERT INTO `menu_item_trl` VALUES ('99', 'Complex page', '35', '1');
INSERT INTO `menu_item_trl` VALUES ('100', 'Составная страница', '35', '2');

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
  `branch` varchar(1024) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `template_name` varchar(512) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `news_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `news_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('24', '7', '0:7', 'Item 2', null, '1', '2', '1428062683', '1428408085', '1');
INSERT INTO `news` VALUES ('25', '7', '0:7', 'Item 1', null, '1', '3', '1428062690', '1428415213', '1');

-- ----------------------------
-- Table structure for `news_category`
-- ----------------------------
DROP TABLE IF EXISTS `news_category`;
CREATE TABLE `news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `template_name` varchar(512) DEFAULT NULL,
  `branch` varchar(256) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `news_category_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_category
-- ----------------------------
INSERT INTO `news_category` VALUES ('6', '0', 'main_category.php', '0:6', 'Politics', '1', '4', '1428394939', '1428407607', '1');
INSERT INTO `news_category` VALUES ('7', '0', 'main_category.php', '0:7', 'Science', '1', '5', '1428394965', '1428407606', '1');
INSERT INTO `news_category` VALUES ('8', '7', 'main_category.php', '0:7:8', 'Space', '1', '5', '1428394944', '1428394944', '1');
INSERT INTO `news_category` VALUES ('9', '7', 'main_category.php', '0:7:9', 'Technologies', '1', '4', '1428394932', '1428394932', '1');
INSERT INTO `news_category` VALUES ('10', '6', 'main_category.php', '0:6:10', 'Geopolitics', '1', '2', '1428394909', '1428394909', '1');

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
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `news_category_trl_ibfk_1` FOREIGN KEY (`news_category_id`) REFERENCES `news_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `news_category_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_category_trl
-- ----------------------------
INSERT INTO `news_category_trl` VALUES ('11', 'Politics', 'Politics, Putin, Obama', 'Last news about politics', '6', '1');
INSERT INTO `news_category_trl` VALUES ('12', 'Политика', 'Политика, Путин, Обама', 'Последние новости из мира политики', '6', '2');
INSERT INTO `news_category_trl` VALUES ('13', 'Science', 'Science, physics, discovery', 'Last news about science', '7', '1');
INSERT INTO `news_category_trl` VALUES ('14', 'Наука', 'Наука, физика, открытия', 'Последние новости из мира науки', '7', '2');
INSERT INTO `news_category_trl` VALUES ('15', 'Space', 'Sapce, astronauts', 'All about space', '8', '1');
INSERT INTO `news_category_trl` VALUES ('16', 'Космос', 'Космос, астронавты', 'Все о космосе', '8', '2');
INSERT INTO `news_category_trl` VALUES ('17', 'Technologies', 'Technologies, IT', 'All about technologies', '9', '1');
INSERT INTO `news_category_trl` VALUES ('18', 'Технологии', 'Технологии, ИТ', 'Все  новости о технологиях', '9', '2');
INSERT INTO `news_category_trl` VALUES ('19', 'Geopolitics', 'geo, world, politics', 'All about geopolitics', '10', '1');
INSERT INTO `news_category_trl` VALUES ('20', 'Геополитика', 'мир, политика', 'Все новости мира геополитики', '10', '2');

-- ----------------------------
-- Table structure for `news_trl`
-- ----------------------------
DROP TABLE IF EXISTS `news_trl`;
CREATE TABLE `news_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) DEFAULT NULL,
  `meta_description` varchar(256) DEFAULT NULL,
  `meta_keywords` varchar(256) DEFAULT NULL,
  `text` text,
  `summary` text,
  `news_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `news_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `news_trl_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news_trl
-- ----------------------------
INSERT INTO `news_trl` VALUES ('29', 'sdf', null, null, null, null, '24', '1');
INSERT INTO `news_trl` VALUES ('30', 'sdfsfd', null, null, null, null, '24', '2');
INSERT INTO `news_trl` VALUES ('31', 'Some title', null, null, 'Some text', 'Some summary', '25', '1');
INSERT INTO `news_trl` VALUES ('32', 'Название', null, null, 'Текст', 'Общее', '25', '2');

-- ----------------------------
-- Table structure for `page`
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_update` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `template_name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `page_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page
-- ----------------------------
INSERT INTO `page` VALUES ('8', 'Page 1', null, null, null, null, null, null);
INSERT INTO `page` VALUES ('9', 'Page 2', null, null, null, null, null, null);

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
INSERT INTO `page_trl` VALUES ('3', 'Some page 1', null, 'fhfghfgh\r\n', '8', '1');
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
  `branch` varchar(1024) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `template_name` varchar(512) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `discount_price` int(11) DEFAULT NULL,
  `is_new` int(11) DEFAULT NULL,
  `stock_qnt` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  `product_code` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('14', '1', '0:1', 'Some title', 'default.php', '1', '1', '15000', '0', null, '5', '1428672850', '1429689657', '1', 'PR20366592PR');
INSERT INTO `product` VALUES ('15', '2', '0:1:2', 'One more product', 'simple_item.php', '1', '1', '12800', '0', null, null, '1429708758', '1429708801', '1', 'PR46727164PR');

-- ----------------------------
-- Table structure for `product_category`
-- ----------------------------
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `template_name` varchar(512) DEFAULT NULL,
  `branch` varchar(256) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_category
-- ----------------------------
INSERT INTO `product_category` VALUES ('1', '0', 'simple_list.php', '0:1', 'Hotels', '1', '5', '1429703458', '1429703458', '1');
INSERT INTO `product_category` VALUES ('2', '1', 'simple_list.php', '0:1:2', 'Sub-cat', '1', '1', '1429703506', '1429703506', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_category_trl
-- ----------------------------
INSERT INTO `product_category_trl` VALUES ('1', 'Hotels', 'Products, keywords', 'Description', '1', '1');
INSERT INTO `product_category_trl` VALUES ('2', 'Гостиницы', 'Продукты, ключ-слова', 'Описание', '1', '2');
INSERT INTO `product_category_trl` VALUES ('3', 'Sub-cat', '', '', '2', '1');
INSERT INTO `product_category_trl` VALUES ('4', 'Суб-категория', '', '', '2', '2');

-- ----------------------------
-- Table structure for `product_fields`
-- ----------------------------
DROP TABLE IF EXISTS `product_fields`;
CREATE TABLE `product_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(256) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `product_fields_ibfk_2` (`type_id`),
  CONSTRAINT `product_fields_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `product_field_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_fields_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `product_field_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_fields
-- ----------------------------
INSERT INTO `product_fields` VALUES ('19', 'Country', '3', '15', '3', '1428927022', '1429863911', '1');
INSERT INTO `product_fields` VALUES ('20', 'City', '3', '15', '2', '1428927056', '1429863911', '1');
INSERT INTO `product_fields` VALUES ('21', 'Placement', '3', '15', '4', '1428927092', '1429863911', '1');
INSERT INTO `product_fields` VALUES ('22', 'Children', '6', '15', '1', '1428927432', '1429863911', '1');
INSERT INTO `product_fields` VALUES ('23', 'Header', '4', '18', '4', '1428927481', '1429004591', '1');
INSERT INTO `product_fields` VALUES ('24', 'Description', '4', '18', '3', '1428927512', '1429004591', '1');
INSERT INTO `product_fields` VALUES ('25', 'Image 1', '5', '18', '2', '1428927611', '1429004591', '1');
INSERT INTO `product_fields` VALUES ('26', 'Image 2', '5', '18', '1', '1428927637', '1429004591', '1');
INSERT INTO `product_fields` VALUES ('27', 'Header', '4', '20', '5', '1428938670', '1429004612', '1');
INSERT INTO `product_fields` VALUES ('28', 'Text', '3', '20', '4', '1428938688', '1429004612', '1');
INSERT INTO `product_fields` VALUES ('29', 'Image', '5', '20', '3', '1428938704', '1429004612', '1');
INSERT INTO `product_fields` VALUES ('30', 'Selector', '6', '20', '2', '1428938743', '1429004612', '1');
INSERT INTO `product_fields` VALUES ('31', 'Date', '2', '16', '1', '1429540090', '1429540090', '1');
INSERT INTO `product_fields` VALUES ('32', 'Price for sale', '1', '16', '2', '1429542410', '1429542410', '1');

-- ----------------------------
-- Table structure for `product_fields_trl`
-- ----------------------------
DROP TABLE IF EXISTS `product_fields_trl`;
CREATE TABLE `product_fields_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_field_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `field_description` text,
  `field_title` text,
  PRIMARY KEY (`id`),
  KEY `product_field_id` (`product_field_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `product_fields_trl_ibfk_1` FOREIGN KEY (`product_field_id`) REFERENCES `product_fields` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_fields_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_fields_trl
-- ----------------------------
INSERT INTO `product_fields_trl` VALUES ('25', '19', '1', '', 'Country');
INSERT INTO `product_fields_trl` VALUES ('26', '19', '2', '', 'Страна');
INSERT INTO `product_fields_trl` VALUES ('27', '20', '1', '', 'City');
INSERT INTO `product_fields_trl` VALUES ('28', '20', '2', '', 'Город');
INSERT INTO `product_fields_trl` VALUES ('29', '21', '1', '', 'Placement');
INSERT INTO `product_fields_trl` VALUES ('30', '21', '2', '', 'Местонахождение');
INSERT INTO `product_fields_trl` VALUES ('31', '22', '1', '', 'Children');
INSERT INTO `product_fields_trl` VALUES ('32', '22', '2', '', 'Дети');
INSERT INTO `product_fields_trl` VALUES ('33', '23', '1', '', 'Header');
INSERT INTO `product_fields_trl` VALUES ('34', '23', '2', '', 'Заголовок');
INSERT INTO `product_fields_trl` VALUES ('35', '24', '1', '', 'Description');
INSERT INTO `product_fields_trl` VALUES ('36', '24', '2', '', 'Описание');
INSERT INTO `product_fields_trl` VALUES ('37', '25', '1', '', 'Image 1');
INSERT INTO `product_fields_trl` VALUES ('38', '25', '2', '', 'Картинка 1');
INSERT INTO `product_fields_trl` VALUES ('39', '26', '1', '', 'Image 2');
INSERT INTO `product_fields_trl` VALUES ('40', '26', '2', '', 'Картинка 2');
INSERT INTO `product_fields_trl` VALUES ('41', '27', '1', '', 'Header');
INSERT INTO `product_fields_trl` VALUES ('42', '27', '2', '', 'Заголовок');
INSERT INTO `product_fields_trl` VALUES ('43', '28', '1', '', 'Text');
INSERT INTO `product_fields_trl` VALUES ('44', '28', '2', '', '');
INSERT INTO `product_fields_trl` VALUES ('45', '29', '1', '', 'Image');
INSERT INTO `product_fields_trl` VALUES ('46', '29', '2', '', '');
INSERT INTO `product_fields_trl` VALUES ('47', '30', '1', '', 'Selector');
INSERT INTO `product_fields_trl` VALUES ('48', '30', '2', '', '');
INSERT INTO `product_fields_trl` VALUES ('49', '31', '1', '', 'Date');
INSERT INTO `product_fields_trl` VALUES ('50', '31', '2', '', 'Дата');
INSERT INTO `product_fields_trl` VALUES ('51', '32', '1', '', 'Price for sale');
INSERT INTO `product_fields_trl` VALUES ('52', '32', '2', '', '');

-- ----------------------------
-- Table structure for `product_field_groups`
-- ----------------------------
DROP TABLE IF EXISTS `product_field_groups`;
CREATE TABLE `product_field_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(256) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `last_change_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_field_groups
-- ----------------------------
INSERT INTO `product_field_groups` VALUES ('15', 'Description', '7', '1429863881', '1428500592', '1');
INSERT INTO `product_field_groups` VALUES ('16', 'Prices', '4', '1429863881', '1428500636', '1');
INSERT INTO `product_field_groups` VALUES ('17', 'Medicine', '3', '1429863881', '1428500677', '1');
INSERT INTO `product_field_groups` VALUES ('18', 'Food', '6', '1429863881', '1428500761', '1');
INSERT INTO `product_field_groups` VALUES ('19', 'The room fund', '2', '1429863881', '1428500806', '1');
INSERT INTO `product_field_groups` VALUES ('20', 'Services', '5', '1429863881', '1428500828', '1');
INSERT INTO `product_field_groups` VALUES ('21', 'How to get', '1', '1429863881', '1428500858', '1');

-- ----------------------------
-- Table structure for `product_field_groups_active`
-- ----------------------------
DROP TABLE IF EXISTS `product_field_groups_active`;
CREATE TABLE `product_field_groups_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_field_groups_active_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `product_field_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_field_groups_active_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_field_groups_active
-- ----------------------------
INSERT INTO `product_field_groups_active` VALUES ('50', '15', '14', '7');
INSERT INTO `product_field_groups_active` VALUES ('51', '18', '14', '6');
INSERT INTO `product_field_groups_active` VALUES ('52', '20', '14', '5');
INSERT INTO `product_field_groups_active` VALUES ('53', '16', '14', '4');
INSERT INTO `product_field_groups_active` VALUES ('56', '15', '15', '7');
INSERT INTO `product_field_groups_active` VALUES ('57', '18', '15', '6');

-- ----------------------------
-- Table structure for `product_field_groups_trl`
-- ----------------------------
DROP TABLE IF EXISTS `product_field_groups_trl`;
CREATE TABLE `product_field_groups_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(512) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `product_field_groups_trl_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `product_field_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_field_groups_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_field_groups_trl
-- ----------------------------
INSERT INTO `product_field_groups_trl` VALUES ('19', '1', '15', 'Description', '');
INSERT INTO `product_field_groups_trl` VALUES ('20', '2', '15', 'Описание', '');
INSERT INTO `product_field_groups_trl` VALUES ('21', '1', '16', 'Prices', '');
INSERT INTO `product_field_groups_trl` VALUES ('22', '2', '16', 'Цены', '');
INSERT INTO `product_field_groups_trl` VALUES ('23', '1', '17', 'Medicine', '');
INSERT INTO `product_field_groups_trl` VALUES ('24', '2', '17', 'Лечение', '');
INSERT INTO `product_field_groups_trl` VALUES ('25', '1', '18', 'Food', '');
INSERT INTO `product_field_groups_trl` VALUES ('26', '2', '18', 'Питание', '');
INSERT INTO `product_field_groups_trl` VALUES ('27', '1', '19', 'The room fund', '');
INSERT INTO `product_field_groups_trl` VALUES ('28', '2', '19', 'Номерной фонд', '');
INSERT INTO `product_field_groups_trl` VALUES ('29', '1', '20', 'Services', '');
INSERT INTO `product_field_groups_trl` VALUES ('30', '2', '20', 'Услуги', '');
INSERT INTO `product_field_groups_trl` VALUES ('31', '1', '21', 'How to get', '');
INSERT INTO `product_field_groups_trl` VALUES ('32', '2', '21', 'Как добраться', '');

-- ----------------------------
-- Table structure for `product_field_select_options`
-- ----------------------------
DROP TABLE IF EXISTS `product_field_select_options`;
CREATE TABLE `product_field_select_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) DEFAULT NULL,
  `option_name` varchar(128) DEFAULT NULL,
  `option_value` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`),
  CONSTRAINT `product_field_select_options_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `product_fields` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_field_select_options
-- ----------------------------
INSERT INTO `product_field_select_options` VALUES ('28', '22', 'С любого возраста', '1');
INSERT INTO `product_field_select_options` VALUES ('29', '22', 'С 3-ех лет', '2');
INSERT INTO `product_field_select_options` VALUES ('30', '22', 'С 5 лет', '3');
INSERT INTO `product_field_select_options` VALUES ('31', '22', 'Не принимаются', '4');
INSERT INTO `product_field_select_options` VALUES ('32', '30', 'Первый', '1');
INSERT INTO `product_field_select_options` VALUES ('33', '30', 'Второй', '2');
INSERT INTO `product_field_select_options` VALUES ('34', '30', 'конец', '8');

-- ----------------------------
-- Table structure for `product_field_types`
-- ----------------------------
DROP TABLE IF EXISTS `product_field_types`;
CREATE TABLE `product_field_types` (
  `id` int(11) NOT NULL,
  `label` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_field_types
-- ----------------------------
INSERT INTO `product_field_types` VALUES ('1', 'Numeric');
INSERT INTO `product_field_types` VALUES ('2', 'Date');
INSERT INTO `product_field_types` VALUES ('3', 'Text');
INSERT INTO `product_field_types` VALUES ('4', 'Translatable text');
INSERT INTO `product_field_types` VALUES ('5', 'Images');
INSERT INTO `product_field_types` VALUES ('6', 'Selectable value');

-- ----------------------------
-- Table structure for `product_field_values`
-- ----------------------------
DROP TABLE IF EXISTS `product_field_values`;
CREATE TABLE `product_field_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `numeric_value` int(11) DEFAULT NULL,
  `selected_option_id` int(11) DEFAULT NULL,
  `text_value` text,
  `time_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `field_id` (`field_id`),
  CONSTRAINT `product_field_values_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_field_values_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `product_fields` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_field_values
-- ----------------------------
INSERT INTO `product_field_values` VALUES ('3', '14', '19', null, null, 'Пиндостан', null);
INSERT INTO `product_field_values` VALUES ('4', '14', '20', null, null, 'Мухосраньск Сити', null);
INSERT INTO `product_field_values` VALUES ('5', '14', '21', null, null, 'Земля', null);
INSERT INTO `product_field_values` VALUES ('6', '14', '22', null, '3', null, null);
INSERT INTO `product_field_values` VALUES ('7', '14', '23', null, null, null, null);
INSERT INTO `product_field_values` VALUES ('8', '14', '24', null, null, null, null);
INSERT INTO `product_field_values` VALUES ('9', '14', '27', null, null, null, null);
INSERT INTO `product_field_values` VALUES ('10', '14', '28', null, null, 'Текст', null);
INSERT INTO `product_field_values` VALUES ('11', '14', '30', null, '2', null, null);
INSERT INTO `product_field_values` VALUES ('12', '14', '25', null, null, null, null);
INSERT INTO `product_field_values` VALUES ('13', '14', '26', null, null, null, null);
INSERT INTO `product_field_values` VALUES ('14', '14', '29', null, null, null, null);
INSERT INTO `product_field_values` VALUES ('15', '14', '31', null, null, null, '1444118329');
INSERT INTO `product_field_values` VALUES ('16', '14', '32', '10', null, null, null);
INSERT INTO `product_field_values` VALUES ('17', '15', '21', null, null, '', null);
INSERT INTO `product_field_values` VALUES ('18', '15', '19', null, null, '', null);
INSERT INTO `product_field_values` VALUES ('19', '15', '20', null, null, '', null);
INSERT INTO `product_field_values` VALUES ('20', '15', '22', null, '3', null, null);
INSERT INTO `product_field_values` VALUES ('21', '15', '23', null, null, null, null);
INSERT INTO `product_field_values` VALUES ('22', '15', '24', null, null, null, null);
INSERT INTO `product_field_values` VALUES ('23', '15', '25', null, null, null, null);

-- ----------------------------
-- Table structure for `product_field_values_trl`
-- ----------------------------
DROP TABLE IF EXISTS `product_field_values_trl`;
CREATE TABLE `product_field_values_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `field_value_id` int(11) DEFAULT NULL,
  `translatable_text` text,
  PRIMARY KEY (`id`),
  KEY `lng_id` (`lng_id`),
  KEY `field_value_id` (`field_value_id`),
  CONSTRAINT `product_field_values_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_field_values_trl_ibfk_2` FOREIGN KEY (`field_value_id`) REFERENCES `product_field_values` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_field_values_trl
-- ----------------------------
INSERT INTO `product_field_values_trl` VALUES ('1', '1', '7', 'Header');
INSERT INTO `product_field_values_trl` VALUES ('2', '2', '7', 'Заголовок');
INSERT INTO `product_field_values_trl` VALUES ('3', '1', '8', 'Description');
INSERT INTO `product_field_values_trl` VALUES ('4', '2', '8', 'Описание');
INSERT INTO `product_field_values_trl` VALUES ('5', '1', '9', 'Header');
INSERT INTO `product_field_values_trl` VALUES ('6', '2', '9', 'Заголовок');
INSERT INTO `product_field_values_trl` VALUES ('7', '1', '21', '');
INSERT INTO `product_field_values_trl` VALUES ('8', '2', '21', '');
INSERT INTO `product_field_values_trl` VALUES ('9', '1', '22', '');
INSERT INTO `product_field_values_trl` VALUES ('10', '2', '22', '');

-- ----------------------------
-- Table structure for `product_trl`
-- ----------------------------
DROP TABLE IF EXISTS `product_trl`;
CREATE TABLE `product_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) DEFAULT NULL,
  `meta_description` varchar(256) DEFAULT NULL,
  `meta_keywords` varchar(256) DEFAULT NULL,
  `text` text,
  `summary` text,
  `product_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `product_trl_ibfk_1` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_trl_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_trl
-- ----------------------------
INSERT INTO `product_trl` VALUES ('15', 'Some title', null, null, '', '', '14', '1');
INSERT INTO `product_trl` VALUES ('16', 'Какое-то название', null, null, '', '', '14', '2');
INSERT INTO `product_trl` VALUES ('17', 'One more product', null, null, null, null, '15', '1');
INSERT INTO `product_trl` VALUES ('18', 'Еще продукт', null, null, null, null, '15', '2');

-- ----------------------------
-- Table structure for `rating`
-- ----------------------------
DROP TABLE IF EXISTS `rating`;
CREATE TABLE `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qnt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mark_id` (`mark_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`mark_id`) REFERENCES `marks` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rating
-- ----------------------------

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value_name` varchar(255) DEFAULT NULL,
  `setting` varchar(255) DEFAULT NULL,
  `editable` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'active_desktop_theme', 'dark', '0');
INSERT INTO `settings` VALUES ('2', 'active_mobile_theme', 'light', '0');
INSERT INTO `settings` VALUES ('3', 'email', null, '1');
INSERT INTO `settings` VALUES ('4', 'home_page_item_id', null, '0');
INSERT INTO `settings` VALUES ('5', 'smtp_host', 'mail.yourdomain.com', '1');
INSERT INTO `settings` VALUES ('6', 'smtp_port', '26', '1');
INSERT INTO `settings` VALUES ('7', 'smtp_username', 'yourname@yourdomain\"', '1');
INSERT INTO `settings` VALUES ('8', 'smtp_password', 'yourpassword', '1');
INSERT INTO `settings` VALUES ('9', 'smtp_enable', '1', '0');

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
  CONSTRAINT `system_widget_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `system_widget_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_widget
-- ----------------------------
INSERT INTO `system_widget` VALUES ('2', 'Login widget', '2', '');
INSERT INTO `system_widget` VALUES ('3', 'Search widget', '1', '');
INSERT INTO `system_widget` VALUES ('5', 'Language switcher', '4', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_widget_trl
-- ----------------------------
INSERT INTO `system_widget_trl` VALUES ('3', '', '', '2', '1');
INSERT INTO `system_widget_trl` VALUES ('4', '', '', '2', '2');

-- ----------------------------
-- Table structure for `system_widget_type`
-- ----------------------------
DROP TABLE IF EXISTS `system_widget_type`;
CREATE TABLE `system_widget_type` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `widget_class` varchar(255) DEFAULT NULL,
  `default_template` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_widget_type
-- ----------------------------
INSERT INTO `system_widget_type` VALUES ('1', 'Search Form', 'SysSearch', 'default.php', 'search');
INSERT INTO `system_widget_type` VALUES ('2', 'Login form', 'SysLogin', 'default.php', 'login');
INSERT INTO `system_widget_type` VALUES ('3', 'Calendar', 'SysCalendar', 'default.php', 'calendar');
INSERT INTO `system_widget_type` VALUES ('4', 'Language Bar', 'SysLanguages', 'default.php', 'language');
INSERT INTO `system_widget_type` VALUES ('5', 'Product cart', 'SysCart', 'default.php', 'cart');
INSERT INTO `system_widget_type` VALUES ('6', 'Custom HTML', 'SysCustom', 'default.php', 'html');
INSERT INTO `system_widget_type` VALUES ('7', 'Banner', 'SysBanner', 'default.php', 'banner');
INSERT INTO `system_widget_type` VALUES ('8', 'Contact form', 'SysContactForm', 'default.php', 'contacts');

-- ----------------------------
-- Table structure for `tag`
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tag
-- ----------------------------

-- ----------------------------
-- Table structure for `tags_of_product`
-- ----------------------------
DROP TABLE IF EXISTS `tags_of_product`;
CREATE TABLE `tags_of_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tags_of_product_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tags_of_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tags_of_product
-- ----------------------------

-- ----------------------------
-- Table structure for `tag_trl`
-- ----------------------------
DROP TABLE IF EXISTS `tag_trl`;
CREATE TABLE `tag_trl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `lng_id` (`lng_id`),
  CONSTRAINT `tag_trl_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tag_trl_ibfk_2` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tag_trl
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wid_registration
-- ----------------------------
INSERT INTO `wid_registration` VALUES ('53', '5', null, '1', '2', '1', '1');
INSERT INTO `wid_registration` VALUES ('54', null, '5', '2', '1', '1', '1');
INSERT INTO `wid_registration` VALUES ('56', null, '6', '2', '1', '2', '1');

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
