/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : yii

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-06-21 15:46:01
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
  `email` varchar(60) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `last_ip` varchar(20) DEFAULT NULL,
  `created_at` int(10) unsigned DEFAULT '0',
  `updated_at` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', 'ced173d3d159ac9cd9af8df7cc690ccd', 'Cfy9WKwej3', null, '超级管理员', 'admin@vip.com', '1', '127.0.0.1', '4294967295', '4294967295');

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
INSERT INTO `auth_item` VALUES ('/admin/menu/*', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/menu/create', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/menu/delete', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/menu/index', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/menu/update', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/menu/view', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/route/*', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/route/assign', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/route/create', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/route/index', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/route/refresh', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/route/remove', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/route/view', '2', null, null, null, '1496754956', '1496754956');
INSERT INTO `auth_item` VALUES ('/admin/rule/create', '2', '权限管理添加', null, null, '1496767704', '1496767704');
INSERT INTO `auth_item` VALUES ('/admin/rule/delete', '2', '权限管理删除', null, null, '1496767704', '1496767704');
INSERT INTO `auth_item` VALUES ('/admin/rule/index', '2', '权限管理管理', null, null, '1496767704', '1496767704');
INSERT INTO `auth_item` VALUES ('/admin/rule/update', '2', '权限管理修改', null, null, '1496767704', '1496767704');
INSERT INTO `auth_item` VALUES ('/admin/rule/view', '2', '权限管理查看', null, null, '1496767704', '1496767704');
INSERT INTO `auth_item` VALUES ('gadw', '1', null, null, null, null, null);
INSERT INTO `auth_item` VALUES ('gasdg', '1', 'www', null, null, null, null);

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
  `order` tinyint(4) DEFAULT NULL,
  `parent` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '菜单管理', '/admin/menu/index', null, '4');
INSERT INTO `menu` VALUES ('2', '路由列表', '/admin/route/index', null, '4');
INSERT INTO `menu` VALUES ('3', '角色列表', '/admin/rule/index', null, '4');
