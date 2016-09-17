/*
Navicat MySQL Data Transfer

Source Server         : myself
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : erp

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-09-17 22:57:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `auth_group`;
CREATE TABLE `auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) DEFAULT '',
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_group
-- ----------------------------
INSERT INTO `auth_group` VALUES ('18', '超级管理员', '1', '31,32,33,34,35,36,37,38,39,40,41,42,44,45,46,47,48,49,67,70,51,62,63,64,65,66,53,54,55,56,58,59,60,61', '超级管理员');
INSERT INTO `auth_group` VALUES ('25', '销售员', '1', '67,51,62,63,64,65,66', '负责销售');
INSERT INTO `auth_group` VALUES ('24', '仓库管理员', '1', '67,53,54,55,56,58,59,60,61,74,75', '只有库存管理权限');

-- ----------------------------
-- Table structure for `auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `auth_group_access`;
CREATE TABLE `auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_group_access
-- ----------------------------
INSERT INTO `auth_group_access` VALUES ('20', '18');
INSERT INTO `auth_group_access` VALUES ('42', '24');
INSERT INTO `auth_group_access` VALUES ('43', '25');
INSERT INTO `auth_group_access` VALUES ('44', '25');

-- ----------------------------
-- Table structure for `auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------
INSERT INTO `auth_rule` VALUES ('31', 'Home', '后台管理权限', '1', '', '0', '1');
INSERT INTO `auth_rule` VALUES ('32', 'Home/User', '用户管理权限', '1', '', '31', '2');
INSERT INTO `auth_rule` VALUES ('33', 'Home/User/Index', '用户界面', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('34', 'Home/User/role', '角色界面', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('35', 'Home/User/getUserList', '查看用户数据', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('36', 'Home/User/adduser', '新增用户', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('37', 'Home/User/delUser', '删除用户', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('38', 'Home/User/editUser', '编辑用户', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('39', 'Home/User/getRoleList', '查看角色数据', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('40', 'Home/User/addRole', '新增角色', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('41', 'Home/User/delRole', '删除角色', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('42', 'Home/User/editRole', '编辑角色', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('44', 'Home/Rbac', '系统权限管理', '1', '', '31', '2');
INSERT INTO `auth_rule` VALUES ('45', 'Home/Rbac/node', '权限节点管理', '1', '', '44', '3');
INSERT INTO `auth_rule` VALUES ('46', 'Home/Rbac/add', '新增权限节点', '1', '', '44', '3');
INSERT INTO `auth_rule` VALUES ('47', 'Home/Rbac/del', '删除权限节点', '1', '', '44', '3');
INSERT INTO `auth_rule` VALUES ('48', 'Home/Rbac/access', '查看拥有权限', '1', '', '44', '3');
INSERT INTO `auth_rule` VALUES ('49', 'Home/Rbac/setAccess', '设置权限', '1', '', '44', '3');
INSERT INTO `auth_rule` VALUES ('51', 'Home/Sale', '销售权限管理', '1', '', '31', '2');
INSERT INTO `auth_rule` VALUES ('53', 'Home/Stock', '仓库管理', '1', '', '31', '2');
INSERT INTO `auth_rule` VALUES ('54', 'Home/Stock/index', '一级仓库界面', '1', '', '53', '3');
INSERT INTO `auth_rule` VALUES ('55', 'Home/Stock/clothes', '二级仓库界面', '1', '', '53', '3');
INSERT INTO `auth_rule` VALUES ('56', 'Home/Stock/detail', '三级仓库界面', '1', '', '53', '3');
INSERT INTO `auth_rule` VALUES ('58', 'Home/Stock/getData', '查看仓库数据', '1', '', '53', '3');
INSERT INTO `auth_rule` VALUES ('59', 'Home/Stock/del', '删除仓库数据', '1', '', '53', '3');
INSERT INTO `auth_rule` VALUES ('60', 'Home/Stock/edit', '编辑仓库数据', '1', '', '53', '3');
INSERT INTO `auth_rule` VALUES ('61', 'Home/Stock/add', '新增仓库', '1', '', '53', '3');
INSERT INTO `auth_rule` VALUES ('62', 'Home/Sale/index', '销售界面', '1', '', '51', '3');
INSERT INTO `auth_rule` VALUES ('63', 'Home/Sale/record', '销售记录查询界面', '1', '', '51', '3');
INSERT INTO `auth_rule` VALUES ('64', 'Home/Sale/getData', '查看仓库数据', '1', '', '51', '3');
INSERT INTO `auth_rule` VALUES ('65', 'Home/Sale/getRecord', '查看销售商品数据', '1', '', '51', '3');
INSERT INTO `auth_rule` VALUES ('66', 'Home/Sale/Sale', '商品出售', '1', '', '51', '3');
INSERT INTO `auth_rule` VALUES ('67', 'Home/Rbac/userAccess', '角色查看自身拥有权限', '1', '', '44', '3');
INSERT INTO `auth_rule` VALUES ('70', 'Home/Rbac/getData', '查看权限节点', '1', '', '44', '3');
INSERT INTO `auth_rule` VALUES ('71', 'Home/User/setRole', '用户角色角色', '1', '', '32', '3');
INSERT INTO `auth_rule` VALUES ('74', 'Home/Stock/record', '仓库操作记录', '1', '', '53', '3');
INSERT INTO `auth_rule` VALUES ('75', 'Home/Stock/getRecord', '获取仓库操作记录', '1', '', '53', '3');

-- ----------------------------
-- Table structure for `clothes`
-- ----------------------------
DROP TABLE IF EXISTS `clothes`;
CREATE TABLE `clothes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `total` int(11) unsigned DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of clothes
-- ----------------------------

-- ----------------------------
-- Table structure for `clothesdetail`
-- ----------------------------
DROP TABLE IF EXISTS `clothesdetail`;
CREATE TABLE `clothesdetail` (
  `size` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `price` decimal(11,2) NOT NULL,
  `total` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of clothesdetail
-- ----------------------------

-- ----------------------------
-- Table structure for `clothes_detail`
-- ----------------------------
DROP TABLE IF EXISTS `clothes_detail`;
CREATE TABLE `clothes_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_id` int(11) NOT NULL,
  `clothes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of clothes_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `detail_img`
-- ----------------------------
DROP TABLE IF EXISTS `detail_img`;
CREATE TABLE `detail_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL,
  `detail_id` int(11) NOT NULL,
  `table` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of detail_img
-- ----------------------------

-- ----------------------------
-- Table structure for `img`
-- ----------------------------
DROP TABLE IF EXISTS `img`;
CREATE TABLE `img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `root_path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `save_path` varchar(255) NOT NULL,
  `uploader` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of img
-- ----------------------------

-- ----------------------------
-- Table structure for `salerecord`
-- ----------------------------
DROP TABLE IF EXISTS `salerecord`;
CREATE TABLE `salerecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_size` int(11) NOT NULL,
  `shop_code` varchar(255) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `shop_price` decimal(11,2) NOT NULL,
  `shop_total` int(11) NOT NULL,
  `shop_remark` varchar(255) DEFAULT NULL,
  `shop_picture` varchar(255) NOT NULL,
  `saleDate` timestamp NOT NULL,
  `saleMan` varchar(255) NOT NULL,
  `orderNum` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`orderNum`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salerecord
-- ----------------------------

-- ----------------------------
-- Table structure for `stock`
-- ----------------------------
DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `total` int(11) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of stock
-- ----------------------------

-- ----------------------------
-- Table structure for `stock_clothes`
-- ----------------------------
DROP TABLE IF EXISTS `stock_clothes`;
CREATE TABLE `stock_clothes` (
  `clothes_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of stock_clothes
-- ----------------------------

-- ----------------------------
-- Table structure for `stock_record`
-- ----------------------------
DROP TABLE IF EXISTS `stock_record`;
CREATE TABLE `stock_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `record` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of stock_record
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `logindate` varchar(255) DEFAULT NULL,
  `createtime` varchar(255) NOT NULL,
  `createname` varchar(255) NOT NULL,
  `loginip` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('20', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2016-09-17 22:50:29', '2016-03-13 14:29:49', 'admin', '127.0.0.1', '1');
INSERT INTO `user` VALUES ('43', 'qyx', 'qyx', '827ccb0eea8a706c4c34a16891f84e7b', null, '2016-05-24 15:42:23', 'admin', null, '1');
INSERT INTO `user` VALUES ('44', '测试', 'ceshi001', '827ccb0eea8a706c4c34a16891f84e7b', null, '2016-05-24 16:47:37', 'admin', null, '1');
INSERT INTO `user` VALUES ('42', '仓库管理', 'ck001', '827ccb0eea8a706c4c34a16891f84e7b', '2016-05-24 12:21:45', '2016-05-24 12:19:54', 'admin', '127.0.0.1', '1');
