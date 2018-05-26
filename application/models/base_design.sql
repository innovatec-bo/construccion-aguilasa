/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : base_design

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-05-25 22:22:39
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
  `deleted_fes` smallint(1) DEFAULT '0',
  `createdon_fes` datetime DEFAULT NULL,
  `createdby_fes` bigint(20) DEFAULT NULL,
  `editedon_fes` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_fes` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_fes`),
  UNIQUE KEY `UQ_sec_features_id_fes` (`id_fes`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sec_features
-- ----------------------------
INSERT INTO `sec_features` VALUES ('1', 'dashboard', 'dashboard', 'iconnnn', 'link', 'description', null, '2', '0', null, null, '2018-05-13 20:12:02', null);
INSERT INTO `sec_features` VALUES ('2', 'charts', 'charts', null, null, null, null, '2', '0', null, null, '2018-05-13 19:19:02', null);
INSERT INTO `sec_features` VALUES ('3', 'tables', 'tables', null, null, null, null, '3', '0', null, null, '2018-05-13 19:17:02', null);
INSERT INTO `sec_features` VALUES ('4', 'forms', 'forms', null, null, null, null, '4', '0', null, null, '2018-05-13 19:17:02', null);
INSERT INTO `sec_features` VALUES ('5', 'ui elements', 'ui_elements', null, null, null, null, '5', '0', null, null, '2018-05-13 19:17:03', null);
INSERT INTO `sec_features` VALUES ('6', 'multi-level dropdown', 'multi_level_dropdown', null, null, null, null, '6', '0', null, null, '2018-05-13 19:17:03', null);
INSERT INTO `sec_features` VALUES ('7', 'sample page', 'sample_page', null, null, null, null, '7', '0', null, null, '2018-05-13 19:17:04', null);
INSERT INTO `sec_features` VALUES ('8', 'flot chars', 'flot_charts', 'icon', 'icon link', '', '2', '8', '0', null, null, '2018-05-13 19:17:04', null);
INSERT INTO `sec_features` VALUES ('9', 'morris charts', 'morris_charts', 'icon', 'link', '', '2', '9', '0', null, null, '2018-05-13 19:17:05', null);
INSERT INTO `sec_features` VALUES ('10', 'panels and wells', 'panels_and_wells', null, null, null, '5', '10', '0', null, null, '2018-05-13 19:17:06', null);
INSERT INTO `sec_features` VALUES ('11', 'buttons', 'buttons', null, null, null, '5', '11', '0', null, null, '2018-05-13 19:17:07', null);
INSERT INTO `sec_features` VALUES ('12', 'notifications', 'notifications', null, null, null, '5', '12', '0', null, null, '2018-05-13 19:17:08', null);
INSERT INTO `sec_features` VALUES ('13', 'typography', 'typography', null, null, null, '5', '13', '0', null, null, '2018-05-13 19:17:08', null);
INSERT INTO `sec_features` VALUES ('14', 'icons', 'icons', null, null, null, '5', '14', '0', null, null, '2018-05-13 19:17:09', null);
INSERT INTO `sec_features` VALUES ('15', 'grid', 'grid', null, null, null, '5', '15', '0', null, null, '2018-05-13 19:17:10', null);
INSERT INTO `sec_features` VALUES ('16', 'second level', 'second_level', null, null, null, '6', '16', '0', null, null, '2018-05-13 19:17:10', null);
INSERT INTO `sec_features` VALUES ('17', 'third level', 'third_level', null, null, null, '16', '17', '0', null, null, '2018-05-13 19:17:19', null);
INSERT INTO `sec_features` VALUES ('18', 'home', 'home', 'fa fa-home', 'panel/Home', null, null, '0', '0', null, null, '2018-05-13 19:36:38', null);
INSERT INTO `sec_features` VALUES ('19', 'permission', 'permission', null, 'panel/Permission', null, null, '1', '0', null, null, '0000-00-00 00:00:00', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
INSERT INTO `sec_permissions` VALUES ('38', '2', '3', '0', '2018-05-12 09:10:39', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('39', '2', '4', '0', '2018-05-12 09:10:39', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('40', '3', '5', '0', '2018-05-12 09:11:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('41', '3', '10', '0', '2018-05-12 09:11:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('42', '3', '11', '0', '2018-05-12 09:11:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('43', '3', '12', '0', '2018-05-12 09:11:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('44', '3', '13', '0', '2018-05-12 09:11:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('45', '3', '14', '0', '2018-05-12 09:11:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('46', '3', '15', '0', '2018-05-12 09:11:01', null, '0000-00-00 00:00:00', null);
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
INSERT INTO `sec_permissions` VALUES ('76', '1', '1', '0', '2018-05-14 01:57:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('77', '1', '2', '0', '2018-05-14 01:57:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('78', '1', '6', '0', '2018-05-14 01:57:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('79', '1', '8', '0', '2018-05-14 01:57:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('80', '1', '9', '0', '2018-05-14 01:57:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('81', '1', '16', '0', '2018-05-14 01:57:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('82', '1', '17', '0', '2018-05-14 01:57:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('83', '1', '18', '0', '2018-05-14 01:57:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('84', '1', '19', '0', '2018-05-14 01:57:45', null, '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for sec_roles
-- ----------------------------
DROP TABLE IF EXISTS `sec_roles`;
CREATE TABLE `sec_roles` (
  `id_rol` bigint(20) NOT NULL AUTO_INCREMENT,
  `rolename_rol` varchar(20) DEFAULT NULL,
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
INSERT INTO `sec_roles` VALUES ('1', 'Super admin', '0', null, null, '2018-04-26 00:37:36', null);
INSERT INTO `sec_roles` VALUES ('2', 'Admin', '0', null, null, '2018-04-26 00:37:39', null);
INSERT INTO `sec_roles` VALUES ('3', 'User', '0', null, null, '0000-00-00 00:00:00', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sec_userroles
-- ----------------------------
INSERT INTO `sec_userroles` VALUES ('1', '1', '1', '0', null, null, '0000-00-00 00:00:00', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sec_users
-- ----------------------------
INSERT INTO `sec_users` VALUES ('1', 'jair', 'cussy', 'jair@twiiti.com', null, null, '$2y$10$biHC1c85bbcHmNmRvKc1ZumAcCYkU2.q.oMzCX2r9aPpYX0HbVd46', null, '', '', '1', '0', '', '0', '2018-04-26 00:32:39', null, '2018-04-26 00:32:39', null);
INSERT INTO `sec_users` VALUES ('2', 'user', 'contest', 'user@mailinator.com', null, null, '$2y$10$0vXlAtP1c2GiAC0adsi1eeGKRbE2YiokjKFfNN4cEZtN0wYiLpkCO', null, '', '', '1', '0', '', '0', '2018-05-13 21:47:16', null, '2018-05-13 21:47:16', null);
