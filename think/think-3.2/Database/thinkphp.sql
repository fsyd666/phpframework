/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : thinkphp

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-07-15 17:53:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `zh_ad`
-- ----------------------------
DROP TABLE IF EXISTS `zh_ad`;
CREATE TABLE `zh_ad` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `aid` smallint(6) DEFAULT NULL COMMENT '广告位ＩＤ',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `photo` varchar(80) DEFAULT NULL COMMENT '广告图',
  `desc` varchar(200) DEFAULT NULL COMMENT '描述',
  `url` varchar(80) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1正常 0禁用',
  `sort` smallint(6) DEFAULT '50' COMMENT '排序',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告';

-- ----------------------------
-- Records of zh_ad
-- ----------------------------

-- ----------------------------
-- Table structure for `zh_admin`
-- ----------------------------
DROP TABLE IF EXISTS `zh_admin`;
CREATE TABLE `zh_admin` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `pwd` char(32) DEFAULT NULL,
  `nickname` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `last_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`user`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of zh_admin
-- ----------------------------
INSERT INTO `zh_admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '超级管理员', '1', '2016-05-11 17:44:05', '127.0.0.1');

-- ----------------------------
-- Table structure for `zh_ad_addr`
-- ----------------------------
DROP TABLE IF EXISTS `zh_ad_addr`;
CREATE TABLE `zh_ad_addr` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `photo` varchar(100) DEFAULT '' COMMENT '广告位示意图',
  `width` smallint(6) DEFAULT NULL,
  `height` smallint(6) DEFAULT NULL,
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告位';

-- ----------------------------
-- Records of zh_ad_addr
-- ----------------------------

-- ----------------------------
-- Table structure for `zh_article`
-- ----------------------------
DROP TABLE IF EXISTS `zh_article`;
CREATE TABLE `zh_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT NULL,
  `cid` smallint(6) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `photo` varchar(100) DEFAULT '',
  `desc` varchar(200) DEFAULT NULL,
  `tname` varchar(20) DEFAULT '',
  `author` varchar(20) DEFAULT '',
  `auth` tinyint(4) DEFAULT '0',
  `zan_num` int(11) DEFAULT '0' COMMENT '点赞数',
  `hits` int(11) DEFAULT '0' COMMENT '点击数',
  `com_num` int(11) DEFAULT '0' COMMENT '评论数',
  `col_num` int(11) DEFAULT '0' COMMENT '收藏次数',
  `recommend` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章';

-- ----------------------------
-- Records of zh_article
-- ----------------------------

-- ----------------------------
-- Table structure for `zh_art_content`
-- ----------------------------
DROP TABLE IF EXISTS `zh_art_content`;
CREATE TABLE `zh_art_content` (
  `artid` int(11) NOT NULL,
  `content` text,
  PRIMARY KEY (`artid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章详情表';

-- ----------------------------
-- Records of zh_art_content
-- ----------------------------

-- ----------------------------
-- Table structure for `zh_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `zh_auth_group`;
CREATE TABLE `zh_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) DEFAULT '',
  `status` tinyint(1) DEFAULT '1',
  `rules` varchar(500) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of zh_auth_group
-- ----------------------------

-- ----------------------------
-- Table structure for `zh_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `zh_auth_group_access`;
CREATE TABLE `zh_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细';

-- ----------------------------
-- Records of zh_auth_group_access
-- ----------------------------

-- ----------------------------
-- Table structure for `zh_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `zh_auth_rule`;
CREATE TABLE `zh_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `fid` smallint(6) unsigned DEFAULT '1',
  `title` char(20) DEFAULT '',
  `type` tinyint(1) DEFAULT '1',
  `status` tinyint(1) DEFAULT '1',
  `condition` char(100) DEFAULT '',
  `sort` smallint(6) DEFAULT '0' COMMENT '排序',
  `is_left_menu` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of zh_auth_rule
-- ----------------------------
INSERT INTO `zh_auth_rule` VALUES ('16', 'Ad/index', '1', '广告管理', '1', '1', '', '100', '1');
INSERT INTO `zh_auth_rule` VALUES ('17', 'Ad/add', '2', '广告添加', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('18', 'Ad/edit', '2', '广告修改', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('19', 'Ad/remove', '2', '广告删除', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('20', 'Ad/view', '2', '广告查看', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('21', 'AdAddr/index', '1', '广告位管理', '1', '1', '', '100', '1');
INSERT INTO `zh_auth_rule` VALUES ('22', 'AdAddr/add', '2', '广告位添加', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('23', 'AdAddr/edit', '2', '广告位修改', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('24', 'AdAddr/remove', '2', '广告位删除', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('25', 'AdAddr/view', '2', '广告位查看', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('26', 'Admin/index', '2', '后台用户管理', '1', '1', '', '100', '1');
INSERT INTO `zh_auth_rule` VALUES ('27', 'Admin/add', '2', '后台用户添加', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('28', 'Admin/edit', '2', '后台用户修改', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('29', 'Admin/remove', '2', '后台用户删除', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('30', 'Admin/view', '2', '后台用户查看', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('36', 'AuthRule/index', '6', '菜单管理', '1', '1', '', '101', '1');
INSERT INTO `zh_auth_rule` VALUES ('37', 'AuthRule/add', '3', '菜单添加', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('38', 'AuthRule/edit', '3', '菜单修改', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('39', 'AuthRule/remove', '3', '菜单删除', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('40', 'AuthRule/view', '3', '菜单查看', '1', '1', '', '100', '0');
INSERT INTO `zh_auth_rule` VALUES ('41', 'AuthGroup/index', '2', '管理组管理', '1', '1', '', '100', '1');
INSERT INTO `zh_auth_rule` VALUES ('42', 'AuthGroup/add', '2', '管理组添加', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('43', 'AuthGroup/edit', '2', '管理组修改', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('44', 'AuthGroup/remove', '2', '管理组删除', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('114', 'Article/index', '7', '文章管理', '1', '1', '', '50', '1');
INSERT INTO `zh_auth_rule` VALUES ('118', 'Article/view', '7', '文章查看', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('117', 'Article/remove', '7', '文章删除', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('116', 'Article/edit', '7', '文章修改', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('115', 'Article/add', '7', '文章添加', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('66', 'Config/index', '6', '配置管理', '1', '1', '', '50', '1');
INSERT INTO `zh_auth_rule` VALUES ('67', 'Config/add', '6', '配置添加', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('68', 'Config/edit', '6', '配置修改', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('71', 'Setting/showbackup', '6', '数据备份', '1', '1', '', '50', '1');
INSERT INTO `zh_auth_rule` VALUES ('72', 'Setting/restore', '6', '数据还原', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('73', 'Setting/delete', '6', '数据备份文件删除', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('74', 'Link/index', '1', '友情链接', '1', '1', '', '50', '1');
INSERT INTO `zh_auth_rule` VALUES ('75', 'Link/add', '1', '友情链接添加', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('76', 'Link/edit', '1', '友情链接修改', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('77', 'Link/remove', '1', '友情链接删除', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('78', 'Link/view', '1', '友情链接查看', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('79', 'LinkCate/index', '1', '链接分类', '1', '1', '', '50', '1');
INSERT INTO `zh_auth_rule` VALUES ('80', 'LinkCate/add', '1', '链接分类添加', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('81', 'LinkCate/edit', '1', '链接分类修改', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('82', 'LinkCate/remove', '1', '链接分类删除', '1', '1', '', '50', '0');
INSERT INTO `zh_auth_rule` VALUES ('83', 'LinkCate/view', '1', '链接分类查看', '1', '1', '', '50', '0');

-- ----------------------------
-- Table structure for `zh_config`
-- ----------------------------
DROP TABLE IF EXISTS `zh_config`;
CREATE TABLE `zh_config` (
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '变量名称',
  `val` varchar(300) DEFAULT NULL COMMENT '变量值',
  `type` tinyint(4) DEFAULT '1' COMMENT '1 input  2 textarea',
  `desc` varchar(50) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of zh_config
-- ----------------------------
INSERT INTO `zh_config` VALUES ('webname', '卓汇研究院', '1', '网站名称');
INSERT INTO `zh_config` VALUES ('desc', '卓汇研究院', '2', '全局SEO描述');
INSERT INTO `zh_config` VALUES ('keywords', '卓汇研究院', '2', '全局关键字');

-- ----------------------------
-- Table structure for `zh_link`
-- ----------------------------
DROP TABLE IF EXISTS `zh_link`;
CREATE TABLE `zh_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cid` smallint(5) unsigned DEFAULT NULL COMMENT '分组ID',
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `logo` varchar(100) DEFAULT NULL COMMENT 'logo地址',
  `status` tinyint(4) DEFAULT '1',
  `url` varchar(200) DEFAULT NULL COMMENT 'URL地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表 ';

-- ----------------------------
-- Records of zh_link
-- ----------------------------

-- ----------------------------
-- Table structure for `zh_link_cate`
-- ----------------------------
DROP TABLE IF EXISTS `zh_link_cate`;
CREATE TABLE `zh_link_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(80) DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='链接分组表';

-- ----------------------------
-- Records of zh_link_cate
-- ----------------------------

-- ----------------------------
-- Table structure for `zh_sms_record`
-- ----------------------------
DROP TABLE IF EXISTS `zh_sms_record`;
CREATE TABLE `zh_sms_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) DEFAULT NULL,
  `content` varchar(200) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `send_time` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='短信 发送记录表';

-- ----------------------------
-- Records of zh_sms_record
-- ----------------------------
