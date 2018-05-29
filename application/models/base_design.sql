/*
Navicat MySQL Data Transfer

Source Server         : LOCAL_HOST
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : base_design

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-05-29 13:53:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sec_features
-- ----------------------------
DROP TABLE IF EXISTS `sec_features`;
CREATE TABLE `sec_features` (
  `id_fes` bigint(20) NOT NULL AUTO_INCREMENT,
  `featurename_fes` varchar(40) DEFAULT NULL,
  `securitystring_fes` varchar(20) DEFAULT NULL,
  `featureicon_fes` varchar(30) DEFAULT NULL,
  `link_fes` varchar(70) DEFAULT NULL,
  `description_fes` text,
  `parent_feature_id_fes` bigint(20) DEFAULT NULL,
  `order_fes` smallint(3) DEFAULT NULL,
  `is_menu_fes` smallint(1) DEFAULT '1',
  `deleted_fes` smallint(1) DEFAULT '0',
  `createdon_fes` datetime DEFAULT NULL,
  `createdby_fes` bigint(20) DEFAULT NULL,
  `editedon_fes` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_fes` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_fes`),
  UNIQUE KEY `UQ_sec_features_id_fes` (`id_fes`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sec_features
-- ----------------------------
INSERT INTO `sec_features` VALUES ('1', 'Edit user', 'user_edit', 'fa fa-edit', 'panel/User/edit', 'Edit users', null, '7', '0', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('2', 'charts', 'charts', 'fa fa-table', '#', '', null, '16', '0', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('3', 'Users', 'user_index', 'fa fa-users', 'panel/User', '', null, '5', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('4', 'Add user', 'user_add', 'fa fa-user-plus', 'panel/User/add', 'Add users', null, '6', '0', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('5', 'ui elements', 'ui_elements', 'fa fa-table', '#', '', null, '9', '0', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('6', 'multi-level dropdown', 'multi_level_dropdown', 'fa fa-table', '#', '', null, '19', '0', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('7', 'My profile', 'user_profile', 'fa fa-user', 'panel/User/myProfile', 'User\'s profile', null, '8', '0', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('8', 'flot chars', 'flot_charts', 'fa fa-table', 'icon link', '', '2', '18', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('9', 'morris charts', 'morris_charts', 'fa fa-table', 'link', '', '2', '17', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('10', 'panels and wells', 'panels_and_wells', 'fa fa-user-plus', null, null, '5', '10', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('11', 'buttons', 'buttons', null, null, null, '5', '11', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('12', 'notifications', 'notifications', null, null, null, '5', '12', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('13', 'typography', 'typography', null, null, null, '5', '13', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('14', 'icons', 'icons', null, null, null, '5', '14', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('15', 'grid', 'grid', null, null, null, '5', '15', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('16', 'second level', 'second_level', 'fa fa-table', null, null, '6', '20', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('17', 'third level', 'third_level', 'fa fa-table', null, null, '16', '21', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('18', 'Home', 'home', 'fa fa-home', 'panel/Home', '', null, '1', '1', '0', null, null, '2018-05-29 09:56:38', null);
INSERT INTO `sec_features` VALUES ('19', 'Permission', 'permission', 'fa fa-lock', 'panel/Permission', 'Add, edit, and handle user permissions', null, '4', '1', '0', null, null, '2018-05-29 11:58:23', null);
INSERT INTO `sec_features` VALUES ('20', 'Roles', 'role_index', 'fa fa-user', 'panel/Role', 'Role list', null, '2', '1', '0', null, null, '2018-05-29 11:11:19', null);
INSERT INTO `sec_features` VALUES ('21', 'Add role', 'ajax_role_add', 'fa fa-plus', '#', 'Add role form', null, '3', '0', '0', null, null, '2018-05-29 11:58:23', null);

-- ----------------------------
-- Table structure for sec_permissions
-- ----------------------------
DROP TABLE IF EXISTS `sec_permissions`;
CREATE TABLE `sec_permissions` (
  `id_per` bigint(20) NOT NULL AUTO_INCREMENT,
  `roleid_per` bigint(20) DEFAULT NULL,
  `featureid_per` bigint(20) DEFAULT NULL,
  `deleted_per` smallint(6) DEFAULT '0',
  `createdon_per` datetime DEFAULT NULL,
  `createdby_per` bigint(20) DEFAULT NULL,
  `editedon_per` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_per` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_per`),
  UNIQUE KEY `UQ_sec_permissions_id_per` (`id_per`) USING BTREE,
  KEY `featureid_per` (`featureid_per`) USING BTREE,
  KEY `roleid_per` (`roleid_per`) USING BTREE,
  CONSTRAINT `sec_permissions_ibfk_1` FOREIGN KEY (`featureid_per`) REFERENCES `sec_features` (`id_fes`),
  CONSTRAINT `sec_permissions_ibfk_2` FOREIGN KEY (`roleid_per`) REFERENCES `sec_roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sec_permissions
-- ----------------------------
INSERT INTO `sec_permissions` VALUES ('1', '1', '1', '1', null, null, '2018-05-04 21:01:27', null);
INSERT INTO `sec_permissions` VALUES ('2', '1', '3', '1', null, null, '2018-05-04 21:01:27', null);
INSERT INTO `sec_permissions` VALUES ('3', '1', '4', '1', null, null, '2018-05-04 21:01:27', null);
INSERT INTO `sec_permissions` VALUES ('4', '2', '12', '1', null, null, '2018-05-05 14:48:52', null);
INSERT INTO `sec_permissions` VALUES ('5', '2', '13', '1', null, null, '2018-05-05 14:48:52', null);
INSERT INTO `sec_permissions` VALUES ('6', '2', '5', '1', null, null, '2018-05-05 14:48:52', null);
INSERT INTO `sec_permissions` VALUES ('7', '3', '12', '1', '2018-05-05 02:54:17', null, '2018-05-04 20:55:00', null);
INSERT INTO `sec_permissions` VALUES ('8', '3', '13', '1', '2018-05-05 02:54:17', null, '2018-05-04 20:55:00', null);
INSERT INTO `sec_permissions` VALUES ('9', '3', '5', '1', '2018-05-05 02:54:17', null, '2018-05-04 20:55:00', null);
INSERT INTO `sec_permissions` VALUES ('10', '3', '10', '1', '2018-05-05 02:55:00', null, '2018-05-05 17:01:45', null);
INSERT INTO `sec_permissions` VALUES ('11', '3', '11', '1', '2018-05-05 02:55:00', null, '2018-05-05 17:01:45', null);
INSERT INTO `sec_permissions` VALUES ('12', '3', '5', '1', '2018-05-05 02:55:00', null, '2018-05-05 17:01:45', null);
INSERT INTO `sec_permissions` VALUES ('13', '1', '1', '1', '2018-05-05 03:01:27', null, '2018-05-05 14:48:29', null);
INSERT INTO `sec_permissions` VALUES ('14', '1', '3', '1', '2018-05-05 03:01:27', null, '2018-05-05 14:48:29', null);
INSERT INTO `sec_permissions` VALUES ('15', '1', '4', '1', '2018-05-05 03:01:27', null, '2018-05-05 14:48:29', null);
INSERT INTO `sec_permissions` VALUES ('16', '1', '10', '1', '2018-05-05 03:01:27', null, '2018-05-05 14:48:29', null);
INSERT INTO `sec_permissions` VALUES ('17', '1', '11', '1', '2018-05-05 03:01:27', null, '2018-05-05 14:48:29', null);
INSERT INTO `sec_permissions` VALUES ('18', '1', '12', '1', '2018-05-05 03:01:27', null, '2018-05-05 14:48:29', null);
INSERT INTO `sec_permissions` VALUES ('19', '1', '13', '1', '2018-05-05 03:01:27', null, '2018-05-05 14:48:29', null);
INSERT INTO `sec_permissions` VALUES ('20', '1', '5', '1', '2018-05-05 03:01:27', null, '2018-05-05 14:48:29', null);
INSERT INTO `sec_permissions` VALUES ('21', '1', '1', '1', '2018-05-05 20:48:32', null, '2018-05-12 03:10:23', null);
INSERT INTO `sec_permissions` VALUES ('22', '1', '3', '1', '2018-05-05 20:48:33', null, '2018-05-12 03:10:23', null);
INSERT INTO `sec_permissions` VALUES ('23', '1', '10', '1', '2018-05-05 20:48:33', null, '2018-05-12 03:10:23', null);
INSERT INTO `sec_permissions` VALUES ('24', '1', '11', '1', '2018-05-05 20:48:33', null, '2018-05-12 03:10:23', null);
INSERT INTO `sec_permissions` VALUES ('25', '1', '13', '1', '2018-05-05 20:48:33', null, '2018-05-12 03:10:23', null);
INSERT INTO `sec_permissions` VALUES ('26', '1', '5', '1', '2018-05-05 20:48:33', null, '2018-05-12 03:10:23', null);
INSERT INTO `sec_permissions` VALUES ('27', '2', '12', '1', '2018-05-05 20:48:53', null, '2018-05-12 03:10:39', null);
INSERT INTO `sec_permissions` VALUES ('28', '2', '13', '1', '2018-05-05 20:48:53', null, '2018-05-12 03:10:39', null);
INSERT INTO `sec_permissions` VALUES ('29', '2', '15', '1', '2018-05-05 20:48:53', null, '2018-05-12 03:10:39', null);
INSERT INTO `sec_permissions` VALUES ('30', '2', '5', '1', '2018-05-05 20:48:53', null, '2018-05-12 03:10:39', null);
INSERT INTO `sec_permissions` VALUES ('31', '3', '1', '1', '2018-05-05 23:01:45', null, '2018-05-12 03:11:01', null);
INSERT INTO `sec_permissions` VALUES ('32', '3', '3', '1', '2018-05-05 23:01:45', null, '2018-05-12 03:11:01', null);
INSERT INTO `sec_permissions` VALUES ('33', '3', '4', '1', '2018-05-05 23:01:45', null, '2018-05-12 03:11:01', null);
INSERT INTO `sec_permissions` VALUES ('34', '1', '1', '1', '2018-05-12 09:10:23', null, '2018-05-12 03:12:23', null);
INSERT INTO `sec_permissions` VALUES ('35', '1', '2', '1', '2018-05-12 09:10:23', null, '2018-05-12 03:12:23', null);
INSERT INTO `sec_permissions` VALUES ('36', '1', '8', '1', '2018-05-12 09:10:23', null, '2018-05-12 03:12:23', null);
INSERT INTO `sec_permissions` VALUES ('37', '1', '9', '1', '2018-05-12 09:10:23', null, '2018-05-12 03:12:23', null);
INSERT INTO `sec_permissions` VALUES ('38', '2', '3', '1', '2018-05-12 09:10:39', null, '2018-05-28 17:11:13', null);
INSERT INTO `sec_permissions` VALUES ('39', '2', '4', '1', '2018-05-12 09:10:39', null, '2018-05-28 17:11:13', null);
INSERT INTO `sec_permissions` VALUES ('40', '3', '5', '1', '2018-05-12 09:11:01', null, '2018-05-28 17:10:00', null);
INSERT INTO `sec_permissions` VALUES ('41', '3', '10', '1', '2018-05-12 09:11:01', null, '2018-05-28 17:10:00', null);
INSERT INTO `sec_permissions` VALUES ('42', '3', '11', '1', '2018-05-12 09:11:01', null, '2018-05-28 17:10:00', null);
INSERT INTO `sec_permissions` VALUES ('43', '3', '12', '1', '2018-05-12 09:11:01', null, '2018-05-28 17:10:00', null);
INSERT INTO `sec_permissions` VALUES ('44', '3', '13', '1', '2018-05-12 09:11:01', null, '2018-05-28 17:10:00', null);
INSERT INTO `sec_permissions` VALUES ('45', '3', '14', '1', '2018-05-12 09:11:01', null, '2018-05-28 17:10:00', null);
INSERT INTO `sec_permissions` VALUES ('46', '3', '15', '1', '2018-05-12 09:11:01', null, '2018-05-28 17:10:00', null);
INSERT INTO `sec_permissions` VALUES ('47', '1', '1', '1', '2018-05-12 09:12:24', null, '2018-05-13 16:50:59', null);
INSERT INTO `sec_permissions` VALUES ('48', '1', '2', '1', '2018-05-12 09:12:24', null, '2018-05-13 16:50:59', null);
INSERT INTO `sec_permissions` VALUES ('49', '1', '3', '1', '2018-05-12 09:12:24', null, '2018-05-13 16:50:59', null);
INSERT INTO `sec_permissions` VALUES ('50', '1', '8', '1', '2018-05-12 09:12:24', null, '2018-05-13 16:50:59', null);
INSERT INTO `sec_permissions` VALUES ('51', '1', '9', '1', '2018-05-12 09:12:24', null, '2018-05-13 16:50:59', null);
INSERT INTO `sec_permissions` VALUES ('52', '1', '1', '1', '2018-05-13 22:50:59', null, '2018-05-13 19:31:32', null);
INSERT INTO `sec_permissions` VALUES ('53', '1', '2', '1', '2018-05-13 22:50:59', null, '2018-05-13 19:31:32', null);
INSERT INTO `sec_permissions` VALUES ('54', '1', '6', '1', '2018-05-13 22:50:59', null, '2018-05-13 19:31:32', null);
INSERT INTO `sec_permissions` VALUES ('55', '1', '8', '1', '2018-05-13 22:50:59', null, '2018-05-13 19:31:32', null);
INSERT INTO `sec_permissions` VALUES ('56', '1', '9', '1', '2018-05-13 22:50:59', null, '2018-05-13 19:31:32', null);
INSERT INTO `sec_permissions` VALUES ('57', '1', '16', '1', '2018-05-13 22:50:59', null, '2018-05-13 19:31:32', null);
INSERT INTO `sec_permissions` VALUES ('58', '1', '17', '1', '2018-05-13 22:50:59', null, '2018-05-13 19:31:32', null);
INSERT INTO `sec_permissions` VALUES ('59', '1', '1', '1', '2018-05-14 01:31:32', null, '2018-05-13 19:57:42', null);
INSERT INTO `sec_permissions` VALUES ('60', '1', '2', '1', '2018-05-14 01:31:32', null, '2018-05-13 19:57:42', null);
INSERT INTO `sec_permissions` VALUES ('61', '1', '6', '1', '2018-05-14 01:31:32', null, '2018-05-13 19:57:42', null);
INSERT INTO `sec_permissions` VALUES ('62', '1', '8', '1', '2018-05-14 01:31:32', null, '2018-05-13 19:57:42', null);
INSERT INTO `sec_permissions` VALUES ('63', '1', '9', '1', '2018-05-14 01:31:32', null, '2018-05-13 19:57:42', null);
INSERT INTO `sec_permissions` VALUES ('64', '1', '16', '1', '2018-05-14 01:31:32', null, '2018-05-13 19:57:42', null);
INSERT INTO `sec_permissions` VALUES ('65', '1', '17', '1', '2018-05-14 01:31:32', null, '2018-05-13 19:57:42', null);
INSERT INTO `sec_permissions` VALUES ('66', '1', '18', '1', '2018-05-14 01:31:32', null, '2018-05-13 19:57:42', null);
INSERT INTO `sec_permissions` VALUES ('67', '1', '1', '1', '2018-05-14 01:57:42', null, '2018-05-13 19:57:45', null);
INSERT INTO `sec_permissions` VALUES ('68', '1', '2', '1', '2018-05-14 01:57:42', null, '2018-05-13 19:57:45', null);
INSERT INTO `sec_permissions` VALUES ('69', '1', '6', '1', '2018-05-14 01:57:42', null, '2018-05-13 19:57:45', null);
INSERT INTO `sec_permissions` VALUES ('70', '1', '8', '1', '2018-05-14 01:57:42', null, '2018-05-13 19:57:45', null);
INSERT INTO `sec_permissions` VALUES ('71', '1', '9', '1', '2018-05-14 01:57:42', null, '2018-05-13 19:57:45', null);
INSERT INTO `sec_permissions` VALUES ('72', '1', '16', '1', '2018-05-14 01:57:42', null, '2018-05-13 19:57:45', null);
INSERT INTO `sec_permissions` VALUES ('73', '1', '17', '1', '2018-05-14 01:57:42', null, '2018-05-13 19:57:45', null);
INSERT INTO `sec_permissions` VALUES ('74', '1', '18', '1', '2018-05-14 01:57:42', null, '2018-05-13 19:57:45', null);
INSERT INTO `sec_permissions` VALUES ('75', '1', '19', '1', '2018-05-14 01:57:42', null, '2018-05-13 19:57:45', null);
INSERT INTO `sec_permissions` VALUES ('76', '1', '1', '1', '2018-05-14 01:57:45', null, '2018-05-28 09:54:17', null);
INSERT INTO `sec_permissions` VALUES ('77', '1', '2', '1', '2018-05-14 01:57:45', null, '2018-05-28 09:54:17', null);
INSERT INTO `sec_permissions` VALUES ('78', '1', '6', '1', '2018-05-14 01:57:45', null, '2018-05-28 09:54:17', null);
INSERT INTO `sec_permissions` VALUES ('79', '1', '8', '1', '2018-05-14 01:57:45', null, '2018-05-28 09:54:17', null);
INSERT INTO `sec_permissions` VALUES ('80', '1', '9', '1', '2018-05-14 01:57:45', null, '2018-05-28 09:54:17', null);
INSERT INTO `sec_permissions` VALUES ('81', '1', '16', '1', '2018-05-14 01:57:45', null, '2018-05-28 09:54:17', null);
INSERT INTO `sec_permissions` VALUES ('82', '1', '17', '1', '2018-05-14 01:57:45', null, '2018-05-28 09:54:17', null);
INSERT INTO `sec_permissions` VALUES ('83', '1', '18', '1', '2018-05-14 01:57:45', null, '2018-05-28 09:54:17', null);
INSERT INTO `sec_permissions` VALUES ('84', '1', '19', '1', '2018-05-14 01:57:45', null, '2018-05-28 09:54:17', null);
INSERT INTO `sec_permissions` VALUES ('85', '1', '1', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('86', '1', '2', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('87', '1', '3', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('88', '1', '6', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('89', '1', '8', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('90', '1', '9', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('91', '1', '16', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('92', '1', '17', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('93', '1', '18', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('94', '1', '19', '1', '2018-05-28 15:54:18', null, '2018-05-28 17:00:54', null);
INSERT INTO `sec_permissions` VALUES ('95', '1', '1', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('96', '1', '2', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('97', '1', '3', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('98', '1', '4', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('99', '1', '5', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('100', '1', '6', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('101', '1', '7', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('102', '1', '8', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('103', '1', '9', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('104', '1', '10', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('105', '1', '11', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('106', '1', '12', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('107', '1', '13', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('108', '1', '14', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('109', '1', '15', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('110', '1', '16', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('111', '1', '17', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('112', '1', '18', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('113', '1', '19', '1', '2018-05-28 23:00:54', null, '2018-05-28 17:32:36', null);
INSERT INTO `sec_permissions` VALUES ('114', '3', '7', '1', '2018-05-28 23:10:00', null, '2018-05-29 10:05:00', null);
INSERT INTO `sec_permissions` VALUES ('115', '2', '3', '1', '2018-05-28 23:11:13', null, '2018-05-28 17:12:04', null);
INSERT INTO `sec_permissions` VALUES ('116', '2', '4', '1', '2018-05-28 23:11:13', null, '2018-05-28 17:12:04', null);
INSERT INTO `sec_permissions` VALUES ('117', '2', '7', '1', '2018-05-28 23:11:13', null, '2018-05-28 17:12:04', null);
INSERT INTO `sec_permissions` VALUES ('118', '2', '1', '1', '2018-05-28 23:12:04', null, '2018-05-29 10:03:21', null);
INSERT INTO `sec_permissions` VALUES ('119', '2', '3', '1', '2018-05-28 23:12:04', null, '2018-05-29 10:03:21', null);
INSERT INTO `sec_permissions` VALUES ('120', '2', '4', '1', '2018-05-28 23:12:04', null, '2018-05-29 10:03:21', null);
INSERT INTO `sec_permissions` VALUES ('121', '2', '7', '1', '2018-05-28 23:12:04', null, '2018-05-29 10:03:21', null);
INSERT INTO `sec_permissions` VALUES ('122', '1', '1', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('123', '1', '2', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('124', '1', '3', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('125', '1', '4', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('126', '1', '5', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('127', '1', '6', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('128', '1', '7', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('129', '1', '8', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('130', '1', '9', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('131', '1', '10', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('132', '1', '11', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('133', '1', '12', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('134', '1', '13', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('135', '1', '14', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('136', '1', '15', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('137', '1', '16', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('138', '1', '17', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('139', '1', '18', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('140', '1', '19', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('141', '1', '20', '1', '2018-05-28 23:32:36', null, '2018-05-29 11:58:10', null);
INSERT INTO `sec_permissions` VALUES ('142', '2', '1', '0', '2018-05-29 16:03:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('143', '2', '3', '0', '2018-05-29 16:03:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('144', '2', '4', '0', '2018-05-29 16:03:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('145', '2', '7', '0', '2018-05-29 16:03:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('146', '2', '18', '0', '2018-05-29 16:03:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('147', '3', '7', '1', '2018-05-29 16:05:00', null, '2018-05-29 10:58:40', null);
INSERT INTO `sec_permissions` VALUES ('148', '3', '18', '1', '2018-05-29 16:05:00', null, '2018-05-29 10:58:40', null);
INSERT INTO `sec_permissions` VALUES ('149', '3', '7', '1', '2018-05-29 16:58:40', null, '2018-05-29 10:59:39', null);
INSERT INTO `sec_permissions` VALUES ('150', '3', '18', '1', '2018-05-29 16:58:40', null, '2018-05-29 10:59:39', null);
INSERT INTO `sec_permissions` VALUES ('151', '3', '20', '1', '2018-05-29 16:58:40', null, '2018-05-29 10:59:39', null);
INSERT INTO `sec_permissions` VALUES ('152', '3', '7', '0', '2018-05-29 16:59:39', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('153', '3', '18', '0', '2018-05-29 16:59:39', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('154', '1', '1', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('155', '1', '2', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('156', '1', '3', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('157', '1', '4', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('158', '1', '5', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('159', '1', '6', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('160', '1', '7', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('161', '1', '8', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('162', '1', '9', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('163', '1', '10', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('164', '1', '11', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('165', '1', '12', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('166', '1', '13', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('167', '1', '14', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('168', '1', '15', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('169', '1', '16', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('170', '1', '17', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('171', '1', '18', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('172', '1', '19', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('173', '1', '20', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('174', '1', '21', '0', '2018-05-29 17:58:10', null, '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for sec_roles
-- ----------------------------
DROP TABLE IF EXISTS `sec_roles`;
CREATE TABLE `sec_roles` (
  `id_rol` bigint(20) NOT NULL AUTO_INCREMENT,
  `rolename_rol` varchar(20) DEFAULT NULL,
  `keyword_rol` varchar(15) DEFAULT NULL,
  `deleted_rol` smallint(6) DEFAULT '0',
  `createdon_rol` datetime DEFAULT NULL,
  `createdby_rol` bigint(20) DEFAULT NULL,
  `editedon_rol` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_rol` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `UQ_sec_roles_id_rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sec_roles
-- ----------------------------
INSERT INTO `sec_roles` VALUES ('1', 'Super admin', 'super_admin', '0', null, null, '2018-05-28 15:38:31', null);
INSERT INTO `sec_roles` VALUES ('2', 'Admin', 'admin', '0', null, null, '2018-05-28 15:38:34', null);
INSERT INTO `sec_roles` VALUES ('3', 'User', 'user', '0', null, null, '2018-05-28 15:38:37', null);

-- ----------------------------
-- Table structure for sec_userroles
-- ----------------------------
DROP TABLE IF EXISTS `sec_userroles`;
CREATE TABLE `sec_userroles` (
  `id_uro` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid_uro` bigint(20) DEFAULT NULL,
  `roleid_uro` bigint(20) DEFAULT NULL,
  `deleted_uro` smallint(6) DEFAULT '0',
  `createdon_uro` datetime DEFAULT NULL,
  `createdby_uro` bigint(20) DEFAULT NULL,
  `editedon_uro` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_uro` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_uro`),
  UNIQUE KEY `UQ_sec_userroles_id_uro` (`id_uro`) USING BTREE,
  KEY `userid_uro` (`userid_uro`) USING BTREE,
  KEY `roleid_uro` (`roleid_uro`) USING BTREE,
  CONSTRAINT `sec_userroles_ibfk_1` FOREIGN KEY (`roleid_uro`) REFERENCES `sec_roles` (`id_rol`),
  CONSTRAINT `sec_userroles_ibfk_2` FOREIGN KEY (`userid_uro`) REFERENCES `sec_users` (`id_usr`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sec_userroles
-- ----------------------------
INSERT INTO `sec_userroles` VALUES ('1', '1', '1', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('2', '4', '2', '1', '2018-05-28 10:34:28', '1', '2018-05-28 15:02:17', null);
INSERT INTO `sec_userroles` VALUES ('3', '4', '3', '1', '2018-05-28 10:34:28', '1', '2018-05-28 15:02:17', null);
INSERT INTO `sec_userroles` VALUES ('4', '4', '3', '1', '2018-05-28 15:02:17', '1', '2018-05-28 15:02:37', null);
INSERT INTO `sec_userroles` VALUES ('5', '4', '3', '1', '2018-05-28 15:02:37', '1', '2018-05-28 15:08:14', null);
INSERT INTO `sec_userroles` VALUES ('6', '4', '2', '1', '2018-05-28 15:08:14', '1', '2018-05-28 15:10:29', null);
INSERT INTO `sec_userroles` VALUES ('7', '4', '2', '1', '2018-05-28 15:10:29', '1', '2018-05-28 15:11:03', null);
INSERT INTO `sec_userroles` VALUES ('8', '4', '3', '1', '2018-05-28 15:11:03', '1', '2018-05-28 15:12:33', null);
INSERT INTO `sec_userroles` VALUES ('9', '4', '3', '1', '2018-05-28 15:12:33', '1', '2018-05-28 15:13:02', null);
INSERT INTO `sec_userroles` VALUES ('10', '4', '3', '0', '2018-05-28 15:13:02', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('11', '3', '3', '0', '2018-05-28 15:13:58', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('12', '2', '3', '1', '2018-05-28 15:15:25', '1', '2018-05-29 10:33:44', null);
INSERT INTO `sec_userroles` VALUES ('13', '2', '2', '0', '2018-05-29 10:33:44', '1', '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for sec_users
-- ----------------------------
DROP TABLE IF EXISTS `sec_users`;
CREATE TABLE `sec_users` (
  `id_usr` bigint(20) NOT NULL AUTO_INCREMENT,
  `firstname_usr` varchar(40) DEFAULT NULL,
  `lastname_usr` varchar(40) DEFAULT NULL,
  `email_usr` varchar(40) DEFAULT NULL,
  `facebookid_usr` varchar(40) DEFAULT NULL,
  `phone_usr` varchar(20) DEFAULT NULL,
  `password_usr` text,
  `avatar_usr` bigint(20) DEFAULT NULL,
  `passwordhash_usr` text,
  `activationhash_usr` text,
  `status_usr` smallint(6) DEFAULT NULL,
  `tax_deductible_usr` smallint(6) DEFAULT NULL,
  `googleid_usr` varchar(40) DEFAULT NULL,
  `deleted_usr` smallint(6) DEFAULT '0',
  `createdon_usr` datetime DEFAULT NULL,
  `createdby_usr` bigint(20) DEFAULT NULL,
  `editedon_usr` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_usr` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_usr`),
  UNIQUE KEY `UQ_sec_users_id_usr` (`id_usr`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sec_users
-- ----------------------------
INSERT INTO `sec_users` VALUES ('1', 'jair', 'cussy', 'jair@twiiti.com', null, null, '$2y$10$biHC1c85bbcHmNmRvKc1ZumAcCYkU2.q.oMzCX2r9aPpYX0HbVd46', null, '', '', '1', '0', '', '0', '2018-04-26 00:32:39', null, '2018-04-26 00:32:39', null);
INSERT INTO `sec_users` VALUES ('2', 'user', 'contest', 'user@mailinator.com', null, null, '$2y$10$nqFeiygdaXL5x/vhsd94MOwFZhwIZEUgE39ItOqH.XxJgS6aKY4TS', null, '', '', '1', '0', '', '0', '2018-05-13 21:47:16', null, '2018-05-29 10:33:44', null);
INSERT INTO `sec_users` VALUES ('3', 'new', 'user', 'nuser@mailinator.com', null, null, '$2y$10$r.eAisul1hyGSXgurkWJjemFA7yxkVcg28lu75DBBgCu6o.W0c0vW', null, '', '', '1', '0', '', '0', '2018-05-28 10:32:52', null, '2018-05-28 15:13:57', null);
INSERT INTO `sec_users` VALUES ('4', 'new', 'user', 'nuser2@mailinator.com', null, null, '$2y$10$c8Jgx3up2nF9n523UoXHyeRWU5ZbL9L1EWxIiGHrADXIFa9QJXE2S', null, '', '', '1', '0', '', '0', '2018-05-28 10:34:28', null, '2018-05-28 15:13:02', null);
