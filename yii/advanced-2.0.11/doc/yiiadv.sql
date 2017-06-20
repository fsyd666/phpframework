/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : yiiadv

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-06-07 17:56:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('superAdmin', '1', '1496813648');
INSERT INTO `auth_assignment` VALUES ('test', '1', '1496735488');

-- ----------------------------
-- Table structure for `auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('/admin/*', '2', null, null, null, '1496816262', '1496816262');
INSERT INTO `auth_item` VALUES ('/admin/assignment/*', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/assignment/assign', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/assignment/index', '2', null, null, null, '1496654500', '1496654500');
INSERT INTO `auth_item` VALUES ('/admin/assignment/revoke', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/assignment/view', '2', null, null, null, '1496740147', '1496740147');
INSERT INTO `auth_item` VALUES ('/admin/default/*', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/default/index', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/menu/*', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/menu/create', '2', null, null, null, '1496654510', '1496654510');
INSERT INTO `auth_item` VALUES ('/admin/menu/delete', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/menu/index', '2', null, null, null, '1496654510', '1496654510');
INSERT INTO `auth_item` VALUES ('/admin/menu/update', '2', null, null, null, '1496654510', '1496654510');
INSERT INTO `auth_item` VALUES ('/admin/menu/view', '2', null, null, null, '1496654510', '1496654510');
INSERT INTO `auth_item` VALUES ('/admin/permission/*', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/permission/assign', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/permission/create', '2', null, null, null, '1496650256', '1496650256');
INSERT INTO `auth_item` VALUES ('/admin/permission/delete', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/permission/index', '2', null, null, null, '1496650258', '1496650258');
INSERT INTO `auth_item` VALUES ('/admin/permission/remove', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/permission/update', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/permission/view', '2', null, null, null, '1496822519', '1496822519');
INSERT INTO `auth_item` VALUES ('/admin/role/*', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/role/assign', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/role/create', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/role/delete', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/role/index', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/role/remove', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/role/update', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/role/view', '2', null, null, null, '1496650255', '1496650255');
INSERT INTO `auth_item` VALUES ('/admin/route/*', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/route/assign', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/route/create', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/route/index', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/route/refresh', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/route/remove', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/rule/*', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/rule/create', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/rule/delete', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/rule/index', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/rule/update', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/rule/view', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/user/*', '2', null, null, null, '1496822521', '1496822521');
INSERT INTO `auth_item` VALUES ('/admin/user/activate', '2', null, null, null, '1496822521', '1496822521');
INSERT INTO `auth_item` VALUES ('/admin/user/change-password', '2', null, null, null, '1496822521', '1496822521');
INSERT INTO `auth_item` VALUES ('/admin/user/delete', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/user/index', '2', null, null, null, '1496816207', '1496816207');
INSERT INTO `auth_item` VALUES ('/admin/user/login', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/user/logout', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/user/request-password-reset', '2', null, null, null, '1496822521', '1496822521');
INSERT INTO `auth_item` VALUES ('/admin/user/reset-password', '2', null, null, null, '1496822521', '1496822521');
INSERT INTO `auth_item` VALUES ('/admin/user/signup', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('/admin/user/view', '2', null, null, null, '1496822520', '1496822520');
INSERT INTO `auth_item` VALUES ('fff', '1', null, null, null, '1496804192', '1496804192');
INSERT INTO `auth_item` VALUES ('gsdf', '2', null, null, null, '1496742055', '1496742055');
INSERT INTO `auth_item` VALUES ('superAdmin', '1', '超级管理员', null, null, '1496813520', '1496813545');
INSERT INTO `auth_item` VALUES ('test', '1', null, null, null, '1496652954', '1496652954');
INSERT INTO `auth_item` VALUES ('测试角色', '1', null, null, null, '1496652966', '1496652966');

-- ----------------------------
-- Table structure for `auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('superAdmin', '/admin/*');
INSERT INTO `auth_item_child` VALUES ('fff', '/admin/assignment/index');
INSERT INTO `auth_item_child` VALUES ('fff', '/admin/assignment/view');
INSERT INTO `auth_item_child` VALUES ('superAdmin', '/admin/role/*');

-- ----------------------------
-- Table structure for `auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '权限控制', null, null, null, '{\"icon\":\"gears\"}');
INSERT INTO `menu` VALUES ('2', '路由', '1', '/admin/route/index', null, null);
INSERT INTO `menu` VALUES ('3', '权限', '1', '/admin/permission/index', null, null);
INSERT INTO `menu` VALUES ('4', '分配', '1', '/admin/assignment/index', null, null);
INSERT INTO `menu` VALUES ('5', '菜单', '1', '/admin/menu', null, null);
INSERT INTO `menu` VALUES ('6', '角色', '1', '/admin/role', null, null);

-- ----------------------------
-- Table structure for `test`
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `value` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `password_reset_token` varchar(256) DEFAULT NULL,
  `email` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '4DN0gl6QkqH5EUvTcfRY5ZC4t1WXITQR', '$2y$13$elPKcdT/cxS3dpzdxtpmKuLwwNK.l074CIWMkaqMP1zjGy63U9o1y', null, 'admin@vip.com', '10', '1496714470', '1496714470');
