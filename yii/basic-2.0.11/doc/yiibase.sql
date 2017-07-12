/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : yiibase

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-07-12 18:53:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `auth_key` varchar(60) NOT NULL,
  `access_token` varchar(60) DEFAULT NULL,
  `nickname` varchar(30) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `last_ip` varchar(20) DEFAULT NULL,
  `last_time` int(10) unsigned DEFAULT '0',
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '58500f9d3705f584f3ea702359dcf963', null, '超级管理员', '1', '127.0.0.1', '1499836359', '2017-05-20 00:00:00');
INSERT INTO `admin` VALUES ('3', 'test1', '21232f297a57a5a743894a0e4a801fc3', '26d8b6ad3da981819ff72331f423ba99', null, '测试88', '0', null, '0', '2017-07-12 14:47:25');
INSERT INTO `admin` VALUES ('4', 'dfjkdjf', '78784', 'ca19a1ac4cb4aad629bce5fdf92a6b17', 'b7dd3f112de1703e79b23864acb47e68', 'klajsdfklsk', '1', null, '0', '2017-07-12 14:53:52');
INSERT INTO `admin` VALUES ('5', 'dfdsf', 'de872154ffbf91a5dcc0e539dd2d5106', '66217718be8de880ce464cd8c475ad69', '4b0dc4166845808972cffa183088224a', '大幅度', '1', null, '0', '2017-07-12 17:24:36');
INSERT INTO `admin` VALUES ('6', 'dfdsfdfd', '78787', '272c0255a860df502da03e406e6b473a', '13b5baf2a75c4f6ba25e698d204e80d9', '大幅度', '1', null, '0', '2017-07-12 17:24:59');

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
INSERT INTO `auth_assignment` VALUES ('asdf', '3', '1499852880');
INSERT INTO `auth_assignment` VALUES ('dfd', '6', '1499851538');

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
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('admin/create', '2', '添加管理员', null, null, '1499850134', '1499850134');
INSERT INTO `auth_item` VALUES ('admin/delete', '2', '删除管理员', null, null, '1499850138', '1499850138');
INSERT INTO `auth_item` VALUES ('admin/index', '2', '管理员列表', null, null, '1499850131', '1499850131');
INSERT INTO `auth_item` VALUES ('admin/update', '2', '更新管理员', null, null, '1499850136', '1499850136');
INSERT INTO `auth_item` VALUES ('admin/view', '2', '管理员详情', null, null, '1499850132', '1499850132');
INSERT INTO `auth_item` VALUES ('asdf', '1', '阿斯蒂芬', null, null, '1499850322', '1499850322');
INSERT INTO `auth_item` VALUES ('asdfsd', '1', '嘎嘎嘎', null, null, '1499850335', '1499850335');
INSERT INTO `auth_item` VALUES ('dfd', '1', '似懂非懂是否', null, null, '1499850524', '1499850524');
INSERT INTO `auth_item` VALUES ('fdd', '1', '大幅度', null, null, '1499850311', '1499850311');
INSERT INTO `auth_item` VALUES ('menu/create', '2', '创建菜单', null, null, '1499850143', '1499850143');
INSERT INTO `auth_item` VALUES ('menu/delete', '2', '删除菜单', null, null, '1499850146', '1499850146');
INSERT INTO `auth_item` VALUES ('menu/index', '2', '菜单列表', null, null, '1499850139', '1499850139');
INSERT INTO `auth_item` VALUES ('menu/update', '2', '更新菜单', null, null, '1499850145', '1499850145');
INSERT INTO `auth_item` VALUES ('menu/view', '2', '菜单详情', null, null, '1499850141', '1499850141');
INSERT INTO `auth_item` VALUES ('role/create', '2', '角色创建', null, null, '1499850151', '1499850151');
INSERT INTO `auth_item` VALUES ('role/delete', '2', '角色删除', null, null, '1499850155', '1499850155');
INSERT INTO `auth_item` VALUES ('role/index', '2', '角色列表', null, null, '1499850148', '1499850148');
INSERT INTO `auth_item` VALUES ('role/update', '2', '角色更新', null, null, '1499850153', '1499850153');
INSERT INTO `auth_item` VALUES ('role/view', '2', '角色详情', null, null, '1499850149', '1499850149');
INSERT INTO `auth_item` VALUES ('route/create', '2', '路由创建', null, null, '1499850160', '1499850160');
INSERT INTO `auth_item` VALUES ('route/delete', '2', '路由删除', null, null, '1499850164', '1499850164');
INSERT INTO `auth_item` VALUES ('route/index', '2', '路由列表', null, null, '1499850157', '1499850157');
INSERT INTO `auth_item` VALUES ('route/update', '2', '路由更新', null, null, '1499850162', '1499850162');
INSERT INTO `auth_item` VALUES ('route/view', '2', '路由详情', null, null, '1499850158', '1499850158');

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
INSERT INTO `auth_item_child` VALUES ('fdd', 'admin/create');
INSERT INTO `auth_item_child` VALUES ('fdd', 'admin/delete');
INSERT INTO `auth_item_child` VALUES ('fdd', 'admin/index');
INSERT INTO `auth_item_child` VALUES ('fdd', 'admin/update');
INSERT INTO `auth_item_child` VALUES ('fdd', 'admin/view');
INSERT INTO `auth_item_child` VALUES ('asdf', 'menu/create');
INSERT INTO `auth_item_child` VALUES ('asdf', 'menu/delete');
INSERT INTO `auth_item_child` VALUES ('asdf', 'menu/index');
INSERT INTO `auth_item_child` VALUES ('asdf', 'menu/update');
INSERT INTO `auth_item_child` VALUES ('asdf', 'menu/view');
INSERT INTO `auth_item_child` VALUES ('asdfsd', 'role/create');
INSERT INTO `auth_item_child` VALUES ('asdfsd', 'role/delete');
INSERT INTO `auth_item_child` VALUES ('asdfsd', 'role/index');
INSERT INTO `auth_item_child` VALUES ('asdfsd', 'role/update');
INSERT INTO `auth_item_child` VALUES ('asdfsd', 'role/view');

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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `route` varchar(60) DEFAULT NULL,
  `order` tinyint(4) DEFAULT '50',
  `parent` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '菜单管理', 'menu/index', '50', '5');
INSERT INTO `menu` VALUES ('2', '路由列表', 'route/index', '50', '5');
INSERT INTO `menu` VALUES ('3', '角色列表', 'role/index', '50', '5');
INSERT INTO `menu` VALUES ('4', '规则管理', 'rule/index', '50', '5');
INSERT INTO `menu` VALUES ('5', '后台管理员', 'admin/index', '50', '3');
