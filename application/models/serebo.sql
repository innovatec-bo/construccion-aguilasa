/*
Navicat MySQL Data Transfer

Source Server         : LOCAL_HOST
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : serebo

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-06-22 14:27:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sec_features
-- ----------------------------
DROP TABLE IF EXISTS `sec_features`;
CREATE TABLE `sec_features` (
  `id_fes` bigint(20) NOT NULL AUTO_INCREMENT,
  `featurename_fes` varchar(40) DEFAULT NULL,
  `securitystring_fes` varchar(50) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sec_features
-- ----------------------------
INSERT INTO `sec_features` VALUES ('1', 'Edit user', 'user_edit', 'fa fa-edit', 'panel/User/edit', 'Edit users', null, '22', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('2', 'charts', 'charts', 'fa fa-table', '#', '', null, '25', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('3', 'Users', 'user_index', 'fa fa-users', 'panel/User', '', null, '20', '1', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('4', 'Add user', 'user_add', 'fa fa-user-plus', 'panel/User/add', 'Add users', null, '21', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('5', 'Diseño', 'design', 'glyphicon glyphicon-pencil', '#', '', null, '4', '1', '0', null, null, '2018-06-18 11:47:52', null);
INSERT INTO `sec_features` VALUES ('6', 'multi-level dropdown', 'multi_level_dropdown', 'fa fa-table', '#', '', null, '31', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('7', 'My profile', 'user_profile', 'fa fa-user', 'panel/User/myProfile', 'User\'s profile', null, '24', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('8', 'flot chars', 'flot_charts', 'fa fa-table', 'icon link', '', '2', '30', '1', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('9', 'morris charts', 'morris_charts', 'fa fa-table', 'link', '', '2', '29', '1', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('10', 'Estaqueadores', 'design_stakes', 'fa fa-users', 'panel/Design/stakesTeam', '', '5', '6', '1', '0', null, null, '2018-06-22 11:44:32', null);
INSERT INTO `sec_features` VALUES ('11', 'Digitalizacion', 'design_digitization', 'fa fa-laptop', 'panel/Design/digitization', '', '5', '7', '1', '0', null, null, '2018-06-22 11:44:32', null);
INSERT INTO `sec_features` VALUES ('12', 'Dibujo', 'design_drawing', 'fa fa-pencil-square-o', 'panel/Design/drawing', '', '5', '8', '1', '0', null, null, '2018-06-22 11:44:32', null);
INSERT INTO `sec_features` VALUES ('13', 'typography', 'typography', null, null, null, '2', '28', '1', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('14', 'icons', 'icons', null, null, null, '2', '26', '1', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('15', 'grid', 'grid', null, null, null, '2', '27', '1', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('16', 'Cronograma', 'design_schedule', 'fa fa-clock-o', 'panel/Design/schedule', '', '5', '9', '1', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('17', 'Diseño', 'design_index', 'glyphicon glyphicon-pencil', 'panel/Design', '', '5', '5', '1', '0', null, null, '2018-06-22 11:44:32', null);
INSERT INTO `sec_features` VALUES ('18', 'Home', 'home', 'fa fa-home', 'panel/Home', '', null, '1', '1', '0', null, null, '2018-06-18 11:47:52', null);
INSERT INTO `sec_features` VALUES ('19', 'Permission', 'permission', 'fa fa-lock', 'panel/Permission', 'Add, edit, and handle user permissions', null, '19', '1', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('20', 'Roles', 'role_index', 'fa fa-user', 'panel/Role', 'Role list', null, '15', '1', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('21', 'Add role', 'role_add', 'fa fa-plus', '#', 'Add role form', null, '16', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('22', 'Edit role', 'role_edit', 'fa fa-edit', '#', 'Edit role form', null, '17', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('23', 'Dashboard', 'dashboard_index', 'fa fa-dashboard', 'panel/Dashboard', 'User dashboard', null, '2', '1', '0', null, null, '2018-06-18 11:47:52', null);
INSERT INTO `sec_features` VALUES ('24', 'Proyectos', 'project_index', 'fa fa-folder', 'panel/Project', 'Projects', null, '3', '1', '0', null, null, '2018-06-18 11:47:52', null);
INSERT INTO `sec_features` VALUES ('25', 'Add project', 'project_add', 'fa fa-plus', 'panel/Project/add', 'Add new project', null, '11', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('26', 'Edit project', 'project_edit', 'fa fa-pencil', 'panel/Project/edit', 'Edit project', null, '12', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('27', 'Delete project', 'delete_project', 'fa fa-times', 'panel/Project/delete', 'Delete project', null, '13', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('28', 'Delete user', 'delete_user', 'fa fa-times', 'panel/User/delete', 'Delete user', null, '23', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('29', 'Delete role', 'delete_role', 'fa fa-times', 'panel/Role/delete', 'Delete role', null, '18', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('30', 'State management', 'project_status_management', 'fa fa-table', 'panel/ProjectStatus/stateManagement', 'Project state management', null, '10', '0', '0', null, null, '2018-06-22 13:26:08', null);
INSERT INTO `sec_features` VALUES ('31', 'Project status', 'project_status_index', 'fa fa-table', 'panel/ProjectStatus', 'Project status', null, '14', '1', '0', null, null, '2018-06-22 13:26:08', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=457 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
INSERT INTO `sec_permissions` VALUES ('142', '2', '1', '1', '2018-05-29 16:03:21', null, '2018-05-30 11:33:15', null);
INSERT INTO `sec_permissions` VALUES ('143', '2', '3', '1', '2018-05-29 16:03:21', null, '2018-05-30 11:33:15', null);
INSERT INTO `sec_permissions` VALUES ('144', '2', '4', '1', '2018-05-29 16:03:21', null, '2018-05-30 11:33:15', null);
INSERT INTO `sec_permissions` VALUES ('145', '2', '7', '1', '2018-05-29 16:03:21', null, '2018-05-30 11:33:15', null);
INSERT INTO `sec_permissions` VALUES ('146', '2', '18', '1', '2018-05-29 16:03:21', null, '2018-05-30 11:33:15', null);
INSERT INTO `sec_permissions` VALUES ('147', '3', '7', '1', '2018-05-29 16:05:00', null, '2018-05-29 10:58:40', null);
INSERT INTO `sec_permissions` VALUES ('148', '3', '18', '1', '2018-05-29 16:05:00', null, '2018-05-29 10:58:40', null);
INSERT INTO `sec_permissions` VALUES ('149', '3', '7', '1', '2018-05-29 16:58:40', null, '2018-05-29 10:59:39', null);
INSERT INTO `sec_permissions` VALUES ('150', '3', '18', '1', '2018-05-29 16:58:40', null, '2018-05-29 10:59:39', null);
INSERT INTO `sec_permissions` VALUES ('151', '3', '20', '1', '2018-05-29 16:58:40', null, '2018-05-29 10:59:39', null);
INSERT INTO `sec_permissions` VALUES ('152', '3', '7', '1', '2018-05-29 16:59:39', null, '2018-05-30 11:33:20', null);
INSERT INTO `sec_permissions` VALUES ('153', '3', '18', '1', '2018-05-29 16:59:39', null, '2018-05-30 11:33:20', null);
INSERT INTO `sec_permissions` VALUES ('154', '1', '1', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('155', '1', '2', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('156', '1', '3', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('157', '1', '4', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('158', '1', '5', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('159', '1', '6', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('160', '1', '7', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('161', '1', '8', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('162', '1', '9', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('163', '1', '10', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('164', '1', '11', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('165', '1', '12', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('166', '1', '13', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('167', '1', '14', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('168', '1', '15', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('169', '1', '16', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('170', '1', '17', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('171', '1', '18', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('172', '1', '19', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('173', '1', '20', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('174', '1', '21', '1', '2018-05-29 17:58:10', null, '2018-05-30 11:01:15', null);
INSERT INTO `sec_permissions` VALUES ('175', '1', '1', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('176', '1', '2', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('177', '1', '3', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('178', '1', '4', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('179', '1', '5', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('180', '1', '6', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('181', '1', '7', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('182', '1', '8', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('183', '1', '9', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('184', '1', '10', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('185', '1', '11', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('186', '1', '12', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('187', '1', '13', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('188', '1', '14', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('189', '1', '15', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('190', '1', '16', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('191', '1', '17', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('192', '1', '18', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('193', '1', '19', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('194', '1', '20', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('195', '1', '21', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('196', '1', '22', '1', '2018-05-30 17:01:15', null, '2018-05-30 11:33:01', null);
INSERT INTO `sec_permissions` VALUES ('197', '1', '1', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('198', '1', '2', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('199', '1', '3', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('200', '1', '4', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('201', '1', '5', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('202', '1', '6', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('203', '1', '7', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('204', '1', '8', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('205', '1', '9', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('206', '1', '10', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('207', '1', '11', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('208', '1', '12', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('209', '1', '13', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('210', '1', '14', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('211', '1', '15', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('212', '1', '16', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('213', '1', '17', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('214', '1', '18', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('215', '1', '19', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('216', '1', '20', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('217', '1', '21', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('218', '1', '22', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('219', '1', '23', '1', '2018-05-30 17:33:01', null, '2018-06-04 11:41:54', null);
INSERT INTO `sec_permissions` VALUES ('220', '2', '1', '0', '2018-05-30 17:33:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('221', '2', '3', '0', '2018-05-30 17:33:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('222', '2', '4', '0', '2018-05-30 17:33:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('223', '2', '7', '0', '2018-05-30 17:33:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('224', '2', '18', '0', '2018-05-30 17:33:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('225', '2', '23', '0', '2018-05-30 17:33:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('226', '3', '7', '1', '2018-05-30 17:33:20', null, '2018-06-01 11:50:44', null);
INSERT INTO `sec_permissions` VALUES ('227', '3', '18', '1', '2018-05-30 17:33:20', null, '2018-06-01 11:50:44', null);
INSERT INTO `sec_permissions` VALUES ('228', '3', '23', '1', '2018-05-30 17:33:20', null, '2018-06-01 11:50:44', null);
INSERT INTO `sec_permissions` VALUES ('229', '3', '4', '1', '2018-06-01 17:50:44', null, '2018-06-01 11:51:53', null);
INSERT INTO `sec_permissions` VALUES ('230', '3', '7', '1', '2018-06-01 17:50:44', null, '2018-06-01 11:51:53', null);
INSERT INTO `sec_permissions` VALUES ('231', '3', '18', '1', '2018-06-01 17:50:44', null, '2018-06-01 11:51:53', null);
INSERT INTO `sec_permissions` VALUES ('232', '3', '23', '1', '2018-06-01 17:50:44', null, '2018-06-01 11:51:53', null);
INSERT INTO `sec_permissions` VALUES ('233', '3', '3', '0', '2018-06-01 17:51:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('234', '3', '7', '0', '2018-06-01 17:51:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('235', '3', '18', '0', '2018-06-01 17:51:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('236', '3', '23', '0', '2018-06-01 17:51:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('237', '1', '1', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('238', '1', '2', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('239', '1', '3', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('240', '1', '4', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('241', '1', '5', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('242', '1', '6', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('243', '1', '7', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('244', '1', '8', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('245', '1', '9', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('246', '1', '10', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('247', '1', '11', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('248', '1', '12', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('249', '1', '13', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('250', '1', '14', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('251', '1', '15', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('252', '1', '16', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('253', '1', '17', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('254', '1', '18', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('255', '1', '19', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('256', '1', '20', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('257', '1', '21', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('258', '1', '22', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('259', '1', '23', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('260', '1', '24', '1', '2018-06-04 17:41:54', null, '2018-06-04 12:08:25', null);
INSERT INTO `sec_permissions` VALUES ('261', '1', '1', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('262', '1', '2', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('263', '1', '3', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('264', '1', '4', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('265', '1', '5', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('266', '1', '6', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('267', '1', '7', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('268', '1', '8', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('269', '1', '9', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('270', '1', '10', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('271', '1', '11', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('272', '1', '12', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('273', '1', '13', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('274', '1', '14', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('275', '1', '15', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('276', '1', '16', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('277', '1', '17', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('278', '1', '18', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('279', '1', '19', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('280', '1', '20', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('281', '1', '21', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('282', '1', '22', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('283', '1', '23', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('284', '1', '24', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('285', '1', '25', '1', '2018-06-04 18:08:25', null, '2018-06-04 12:24:14', null);
INSERT INTO `sec_permissions` VALUES ('286', '1', '1', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('287', '1', '2', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('288', '1', '3', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('289', '1', '4', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('290', '1', '5', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('291', '1', '6', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('292', '1', '7', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('293', '1', '8', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('294', '1', '9', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('295', '1', '10', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('296', '1', '11', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('297', '1', '12', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('298', '1', '13', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('299', '1', '14', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('300', '1', '15', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('301', '1', '16', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('302', '1', '17', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('303', '1', '18', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('304', '1', '19', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('305', '1', '20', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('306', '1', '21', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('307', '1', '22', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('308', '1', '23', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('309', '1', '24', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('310', '1', '25', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('311', '1', '26', '1', '2018-06-04 18:24:14', null, '2018-06-05 10:09:07', null);
INSERT INTO `sec_permissions` VALUES ('312', '1', '1', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('313', '1', '2', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('314', '1', '3', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('315', '1', '4', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('316', '1', '5', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('317', '1', '6', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('318', '1', '7', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('319', '1', '8', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('320', '1', '9', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('321', '1', '10', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('322', '1', '11', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('323', '1', '12', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('324', '1', '13', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('325', '1', '14', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('326', '1', '15', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('327', '1', '16', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('328', '1', '17', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('329', '1', '18', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('330', '1', '19', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('331', '1', '20', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('332', '1', '21', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('333', '1', '22', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('334', '1', '23', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('335', '1', '24', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('336', '1', '25', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('337', '1', '26', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('338', '1', '27', '1', '2018-06-05 16:09:08', null, '2018-06-05 12:15:15', null);
INSERT INTO `sec_permissions` VALUES ('339', '1', '1', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('340', '1', '2', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('341', '1', '3', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('342', '1', '4', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('343', '1', '5', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('344', '1', '6', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('345', '1', '7', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('346', '1', '8', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('347', '1', '9', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('348', '1', '10', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('349', '1', '11', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('350', '1', '12', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('351', '1', '13', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('352', '1', '14', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('353', '1', '15', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('354', '1', '16', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('355', '1', '17', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('356', '1', '18', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('357', '1', '19', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('358', '1', '20', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('359', '1', '21', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('360', '1', '22', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('361', '1', '23', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('362', '1', '24', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('363', '1', '25', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('364', '1', '26', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('365', '1', '27', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('366', '1', '28', '1', '2018-06-05 18:15:15', null, '2018-06-05 12:23:15', null);
INSERT INTO `sec_permissions` VALUES ('367', '1', '1', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('368', '1', '2', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('369', '1', '3', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('370', '1', '4', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('371', '1', '5', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('372', '1', '6', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('373', '1', '7', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('374', '1', '8', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('375', '1', '9', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('376', '1', '10', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('377', '1', '11', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('378', '1', '12', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('379', '1', '13', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('380', '1', '14', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('381', '1', '15', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('382', '1', '16', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('383', '1', '17', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('384', '1', '18', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('385', '1', '19', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('386', '1', '20', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('387', '1', '21', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('388', '1', '22', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('389', '1', '23', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('390', '1', '24', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('391', '1', '25', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('392', '1', '26', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('393', '1', '27', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('394', '1', '28', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('395', '1', '29', '1', '2018-06-05 18:23:16', null, '2018-06-06 10:32:57', null);
INSERT INTO `sec_permissions` VALUES ('396', '1', '1', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('397', '1', '2', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('398', '1', '3', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('399', '1', '4', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('400', '1', '5', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('401', '1', '6', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('402', '1', '7', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('403', '1', '8', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('404', '1', '9', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('405', '1', '10', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('406', '1', '11', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('407', '1', '12', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('408', '1', '13', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('409', '1', '14', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('410', '1', '15', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('411', '1', '16', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('412', '1', '17', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('413', '1', '18', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('414', '1', '19', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('415', '1', '20', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('416', '1', '21', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('417', '1', '22', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('418', '1', '23', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('419', '1', '24', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('420', '1', '25', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('421', '1', '26', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('422', '1', '27', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('423', '1', '28', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('424', '1', '29', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('425', '1', '30', '1', '2018-06-06 16:32:57', null, '2018-06-06 11:57:07', null);
INSERT INTO `sec_permissions` VALUES ('426', '1', '1', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('427', '1', '2', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('428', '1', '3', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('429', '1', '4', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('430', '1', '5', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('431', '1', '6', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('432', '1', '7', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('433', '1', '8', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('434', '1', '9', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('435', '1', '10', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('436', '1', '11', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('437', '1', '12', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('438', '1', '13', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('439', '1', '14', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('440', '1', '15', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('441', '1', '16', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('442', '1', '17', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('443', '1', '18', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('444', '1', '19', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('445', '1', '20', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('446', '1', '21', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('447', '1', '22', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('448', '1', '23', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('449', '1', '24', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('450', '1', '25', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('451', '1', '26', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('452', '1', '27', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('453', '1', '28', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('454', '1', '29', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('455', '1', '30', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('456', '1', '31', '0', '2018-06-06 17:57:07', null, '0000-00-00 00:00:00', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sec_roles
-- ----------------------------
INSERT INTO `sec_roles` VALUES ('1', 'Super admin', 'super_admin', '0', null, null, '2018-05-28 15:38:31', null);
INSERT INTO `sec_roles` VALUES ('2', 'Admin', 'admin', '0', null, null, '2018-05-28 15:38:34', null);
INSERT INTO `sec_roles` VALUES ('3', 'User', 'user', '0', null, null, '2018-06-06 11:49:32', null);
INSERT INTO `sec_roles` VALUES ('4', 'Guestttt', 'guest', '1', '2018-06-01 11:46:04', null, '2018-06-05 12:28:35', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
INSERT INTO `sec_userroles` VALUES ('13', '2', '2', '1', '2018-05-29 10:33:44', '1', '2018-06-01 11:48:58', null);
INSERT INTO `sec_userroles` VALUES ('14', '5', '3', '0', '2018-05-30 09:44:40', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('15', '6', '3', '1', '2018-05-30 09:58:30', '1', '2018-06-05 12:15:38', null);
INSERT INTO `sec_userroles` VALUES ('16', '2', '3', '0', '2018-06-01 11:48:58', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('17', '7', '3', '0', '2018-06-05 12:26:51', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('18', '7', '4', '1', '2018-06-05 12:26:51', '1', '2018-06-05 12:28:35', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sec_users
-- ----------------------------
INSERT INTO `sec_users` VALUES ('1', 'jair', 'cussy', 'jair@twiiti.com', null, null, '$2y$10$biHC1c85bbcHmNmRvKc1ZumAcCYkU2.q.oMzCX2r9aPpYX0HbVd46', null, '', '', '1', '0', '', '0', '2018-04-26 00:32:39', null, '2018-04-26 00:32:39', null);
INSERT INTO `sec_users` VALUES ('2', 'user', 'contest', 'user@mailinator.com', null, null, '$2y$10$8CN4RnGgW92AnvJnNHWWaOiv4bYq/MUhgYnJikGeobrbyB8uWMsvi', null, '', '', '1', '0', '', '0', '2018-05-13 21:47:16', null, '2018-06-01 11:48:58', null);
INSERT INTO `sec_users` VALUES ('3', 'new', 'user', 'nuser@mailinator.com', null, null, '$2y$10$r.eAisul1hyGSXgurkWJjemFA7yxkVcg28lu75DBBgCu6o.W0c0vW', null, '', '', '1', '0', '', '0', '2018-05-28 10:32:52', null, '2018-05-28 15:13:57', null);
INSERT INTO `sec_users` VALUES ('4', 'new', 'user', 'nuser2@mailinator.com', null, null, '$2y$10$c8Jgx3up2nF9n523UoXHyeRWU5ZbL9L1EWxIiGHrADXIFa9QJXE2S', null, '', '', '1', '0', '', '0', '2018-05-28 10:34:28', null, '2018-05-28 15:13:02', null);
INSERT INTO `sec_users` VALUES ('5', 'test', 'user', 'tuser@mailinator.com', null, null, '$2y$10$42XsIiB5gRBPcTlxoHm84eyWV9hNtvcPCVcXi1UAB09unAmQIZdIG', null, '', '', '1', '0', '', '0', '2018-05-30 09:44:40', null, '2018-05-30 09:44:40', null);
INSERT INTO `sec_users` VALUES ('6', 'another', 'user', 'auser@mailinator.com', null, null, '$2y$10$3k0HQgfQ.x59LB/V0995detQoizrIRPM5jmPg1MOco/g5wd7ERRBe', null, '', '', '1', '0', '', '1', '2018-05-30 09:58:30', null, '2018-06-05 12:15:38', null);
INSERT INTO `sec_users` VALUES ('7', 'test7', 'test7', 'test7@mailiantor.com', null, null, '$2y$10$kDCu0dJWW1GQJSnDAX.hwu8sLMYTGxCKFlbad4A2jlwx/Yx73j3UC', null, '', '', '1', '0', '', '0', '2018-06-04 12:15:00', null, '2018-06-05 12:26:51', null);

-- ----------------------------
-- Table structure for wfl_projects
-- ----------------------------
DROP TABLE IF EXISTS `wfl_projects`;
CREATE TABLE `wfl_projects` (
  `id_pro` bigint(20) NOT NULL AUTO_INCREMENT,
  `code_pro` varchar(15) DEFAULT NULL,
  `project_name_pro` varchar(100) DEFAULT NULL,
  `address_pro` varchar(50) DEFAULT NULL,
  `entry_date_pro` datetime DEFAULT NULL,
  `cre_fiscal_pro` varchar(50) DEFAULT NULL,
  `status_pro` bigint(20) DEFAULT NULL,
  `project_start_pro` datetime DEFAULT NULL,
  `project_end_pro` datetime DEFAULT NULL,
  `deleted_pro` smallint(6) DEFAULT '0',
  `createdon_pro` datetime DEFAULT NULL,
  `createdby_pro` bigint(20) DEFAULT NULL,
  `editedon_pro` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_pro` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_pro`),
  UNIQUE KEY `UQ_sec_roles_id_rol` (`id_pro`) USING BTREE,
  KEY `fk_status_pro` (`status_pro`),
  CONSTRAINT `fk_status_pro` FOREIGN KEY (`status_pro`) REFERENCES `wfl_project_status` (`id_pst`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of wfl_projects
-- ----------------------------
INSERT INTO `wfl_projects` VALUES ('1', null, 'project5', null, null, null, null, null, null, '1', '2018-06-04 12:16:06', null, '2018-06-05 11:13:37', null);
INSERT INTO `wfl_projects` VALUES ('5', null, 'project1', null, null, null, null, null, null, '0', null, null, '2018-06-04 12:27:47', null);
INSERT INTO `wfl_projects` VALUES ('6', null, 'project2', null, null, null, null, null, null, '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_projects` VALUES ('7', null, 'project3', null, null, null, null, null, null, '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_projects` VALUES ('8', null, 'project4', null, null, null, null, null, null, '1', '2018-06-04 12:15:33', null, '2018-06-05 12:05:34', null);
INSERT INTO `wfl_projects` VALUES ('11', '456', 'First project with p', 'lejos', '0000-00-00 00:00:00', 'Fulano de tal', null, null, null, '0', '2018-06-11 11:41:55', null, '2018-06-11 11:41:55', null);
INSERT INTO `wfl_projects` VALUES ('12', '123', 'second project with points', 'lejitos', '2018-06-01 00:00:00', 'Fulano de tal', null, null, null, '0', '2018-06-11 11:48:48', null, '2018-06-11 13:40:43', null);
INSERT INTO `wfl_projects` VALUES ('13', '789', 'project with status', 'far far away', '2018-06-11 00:00:00', 'Fulano de tal', '1', null, null, '0', '2018-06-11 13:53:06', null, '2018-06-11 13:53:06', null);
INSERT INTO `wfl_projects` VALUES ('14', '159', 'project with status - test2', 'lejos', '2018-06-11 00:00:00', 'Fulano de tal', null, null, null, '0', '2018-06-11 13:53:53', null, '2018-06-11 13:53:53', null);
INSERT INTO `wfl_projects` VALUES ('15', '357', 'project with status log', 'lejos', '2018-06-11 00:00:00', 'Fulano de tal', '1', null, null, '0', '2018-06-11 14:05:13', null, '2018-06-11 14:05:13', null);
INSERT INTO `wfl_projects` VALUES ('16', '486', 'adfasdf a', 'asdfasdfasdfdfdf', '2018-06-11 00:00:00', 'asdfasdasd', '1', null, null, '0', '2018-06-11 14:06:43', null, '2018-06-11 14:06:43', null);
INSERT INTO `wfl_projects` VALUES ('17', '486', 'adfasdf a', 'asdfasdfasdfdfdf', '2018-06-11 00:00:00', 'asdfasdasd', '1', null, null, '0', '2018-06-11 14:13:28', null, '2018-06-12 11:08:44', null);
INSERT INTO `wfl_projects` VALUES ('18', '486', 'adfasdf a', 'asdfasdfasdfdfdf', '2018-06-11 00:00:00', 'asdfasdasd', '2', null, null, '0', '2018-06-11 14:15:46', null, '2018-06-11 14:30:50', null);
INSERT INTO `wfl_projects` VALUES ('19', '351', 'adas', 'asdfasdf', '2018-06-11 00:00:00', 'asdfasf', '5', null, null, '0', '2018-06-11 14:32:03', null, '2018-06-12 10:54:04', null);
INSERT INTO `wfl_projects` VALUES ('20', '963', 'nuevo proyecto', 'lejosss', '2018-06-13 00:00:00', 'un fical', '2', null, null, '0', '2018-06-13 11:38:00', null, '2018-06-13 11:40:24', null);
INSERT INTO `wfl_projects` VALUES ('21', 're2', 'nuevo', 'lejos', '2018-06-15 00:00:00', 'Fulano de tal', '1', null, null, '0', '2018-06-15 11:42:49', null, '2018-06-15 11:42:49', null);
INSERT INTO `wfl_projects` VALUES ('22', '456', 'asbc', 'asdfasd a', '2018-06-22 00:00:00', 'Fulano de tal', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '2018-06-22 10:42:16', null, '2018-06-22 10:42:34', null);
INSERT INTO `wfl_projects` VALUES ('23', '121', 'asdfasdf', '1asdfa', '2018-06-22 00:00:00', 'asdfddd', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '2018-06-22 11:39:59', null, '2018-06-22 11:39:59', null);
INSERT INTO `wfl_projects` VALUES ('24', '123', '849646', 'dfadf', '2018-06-22 00:00:00', 'asdfasdf', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '2018-06-22 11:41:34', null, '2018-06-22 11:41:34', null);

-- ----------------------------
-- Table structure for wfl_project_points
-- ----------------------------
DROP TABLE IF EXISTS `wfl_project_points`;
CREATE TABLE `wfl_project_points` (
  `id_prp` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id_prp` bigint(20) DEFAULT NULL,
  `points_quantity_prp` smallint(2) DEFAULT NULL,
  `meters_distance_prp` double(5,2) DEFAULT NULL,
  `deleted_prp` smallint(6) DEFAULT '0',
  `createdon_prp` datetime DEFAULT NULL,
  `createdby_prp` bigint(20) DEFAULT NULL,
  `editedon_prp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_prp` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_prp`),
  KEY `fk_project_id_prp` (`project_id_prp`),
  CONSTRAINT `fk_project_id_prp` FOREIGN KEY (`project_id_prp`) REFERENCES `wfl_projects` (`id_pro`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_points
-- ----------------------------
INSERT INTO `wfl_project_points` VALUES ('1', '11', '8', '40.00', '0', '2018-06-11 11:41:55', null, '2018-06-11 11:41:55', null);
INSERT INTO `wfl_project_points` VALUES ('2', '12', '10', '50.00', '0', '2018-06-11 11:48:48', null, '2018-06-11 11:48:48', null);
INSERT INTO `wfl_project_points` VALUES ('3', '12', '15', '25.00', '0', '2018-06-11 12:27:50', null, '2018-06-11 12:27:50', null);
INSERT INTO `wfl_project_points` VALUES ('4', '12', '15', '30.00', '0', '2018-06-11 13:40:45', null, '2018-06-11 13:40:45', null);
INSERT INTO `wfl_project_points` VALUES ('5', '13', '9', '10.00', '0', '2018-06-11 13:53:06', null, '2018-06-11 13:53:06', null);
INSERT INTO `wfl_project_points` VALUES ('6', '14', '15', '13.00', '0', '2018-06-11 13:53:53', null, '2018-06-11 13:53:53', null);
INSERT INTO `wfl_project_points` VALUES ('7', '15', '52', '25.00', '0', '2018-06-11 14:05:13', null, '2018-06-11 14:05:13', null);
INSERT INTO `wfl_project_points` VALUES ('8', '16', '89', '52.00', '0', '2018-06-11 14:06:43', null, '2018-06-11 14:06:43', null);
INSERT INTO `wfl_project_points` VALUES ('9', '17', '89', '52.00', '0', '2018-06-11 14:13:28', null, '2018-06-11 14:13:28', null);
INSERT INTO `wfl_project_points` VALUES ('10', '18', '89', '52.00', '0', '2018-06-11 14:15:47', null, '2018-06-11 14:15:47', null);
INSERT INTO `wfl_project_points` VALUES ('11', '19', '65', '65.00', '0', '2018-06-11 14:32:03', null, '2018-06-11 14:32:03', null);
INSERT INTO `wfl_project_points` VALUES ('12', '19', '20', '25.00', '0', '2018-06-12 10:54:04', null, '2018-06-12 10:54:04', null);
INSERT INTO `wfl_project_points` VALUES ('13', '17', '10', '10.00', '0', '2018-06-12 11:08:44', null, '2018-06-12 11:08:44', null);
INSERT INTO `wfl_project_points` VALUES ('14', '20', '20', '50.00', '0', '2018-06-13 11:38:00', null, '2018-06-13 11:38:00', null);
INSERT INTO `wfl_project_points` VALUES ('15', '20', '10', '25.00', '0', '2018-06-13 11:40:24', null, '2018-06-13 11:40:24', null);
INSERT INTO `wfl_project_points` VALUES ('16', '21', '8', '50.00', '0', '2018-06-15 11:42:49', null, '2018-06-15 11:42:49', null);
INSERT INTO `wfl_project_points` VALUES ('17', '22', '52', '69.00', '0', '2018-06-22 10:42:16', null, '2018-06-22 10:42:16', null);
INSERT INTO `wfl_project_points` VALUES ('18', '23', '50', '850.00', '0', '2018-06-22 11:39:59', null, '2018-06-22 11:40:00', null);
INSERT INTO `wfl_project_points` VALUES ('19', '24', '60', '951.00', '0', '2018-06-22 11:41:34', null, '2018-06-22 11:41:34', null);
INSERT INTO `wfl_project_points` VALUES ('20', '18', '55', '650.00', '0', null, null, '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for wfl_project_stakes
-- ----------------------------
DROP TABLE IF EXISTS `wfl_project_stakes`;
CREATE TABLE `wfl_project_stakes` (
  `id_prs` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id_prs` bigint(20) DEFAULT NULL,
  `stakes_leader_id_prs` bigint(20) DEFAULT NULL,
  `deleted_prs` smallint(6) DEFAULT '0',
  `createdon_prs` datetime DEFAULT NULL,
  `createdby_prs` bigint(20) DEFAULT NULL,
  `editedon_prs` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_prs` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_prs`),
  KEY `fk_project_id_prs` (`project_id_prs`),
  KEY `fk_stakes_leader_id_prs` (`stakes_leader_id_prs`),
  CONSTRAINT `fk_project_id_prs` FOREIGN KEY (`project_id_prs`) REFERENCES `wfl_projects` (`id_pro`),
  CONSTRAINT `fk_stakes_leader_id_prs` FOREIGN KEY (`stakes_leader_id_prs`) REFERENCES `wfl_stakes_team_leader` (`id_stl`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_stakes
-- ----------------------------
INSERT INTO `wfl_project_stakes` VALUES ('1', '18', '1', '0', null, null, '2018-06-19 17:40:37', null);
INSERT INTO `wfl_project_stakes` VALUES ('2', '19', '2', '0', null, null, '2018-06-19 17:40:23', null);
INSERT INTO `wfl_project_stakes` VALUES ('3', '17', '1', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_project_stakes` VALUES ('4', '16', '1', '0', null, null, '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for wfl_project_status
-- ----------------------------
DROP TABLE IF EXISTS `wfl_project_status`;
CREATE TABLE `wfl_project_status` (
  `id_pst` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_name_pst` varchar(50) DEFAULT NULL,
  `status_icon_pst` varchar(50) DEFAULT NULL,
  `order_pst` smallint(2) DEFAULT NULL,
  `parent_status_pst` bigint(20) DEFAULT NULL,
  `keyword_pst` varchar(50) DEFAULT NULL,
  `deleted_pst` smallint(6) DEFAULT '0',
  `createdon_pst` datetime DEFAULT NULL,
  `createdby_pst` bigint(20) DEFAULT NULL,
  `editedon_pst` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_pst` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_pst`),
  UNIQUE KEY `UQ_sec_roles_id_rol` (`id_pst`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_status
-- ----------------------------
INSERT INTO `wfl_project_status` VALUES ('1', 'Diseño', 'glyphicon glyphicon-pencil', '1', null, 'design', '0', null, null, '2018-06-19 15:35:48', null);
INSERT INTO `wfl_project_status` VALUES ('2', 'Estaqueado', 'fa fa-users', '2', '1', 'stakes', '0', null, null, '2018-06-19 15:35:51', null);
INSERT INTO `wfl_project_status` VALUES ('3', 'Digitalizacion', 'fa fa-laptop', '3', '1', 'digitization', '0', null, null, '2018-06-19 15:36:17', null);
INSERT INTO `wfl_project_status` VALUES ('5', 'Dibujo', 'fa fa-pencil-square-o', '4', '1', 'drawing', '0', null, null, '2018-06-22 12:04:00', null);
INSERT INTO `wfl_project_status` VALUES ('6', 'Cronograma', 'fa fa-clock-o', '5', '1', 'schedule', '0', null, null, '2018-06-22 11:12:23', null);

-- ----------------------------
-- Table structure for wfl_project_status_log
-- ----------------------------
DROP TABLE IF EXISTS `wfl_project_status_log`;
CREATE TABLE `wfl_project_status_log` (
  `id_psl` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id_psl` bigint(20) DEFAULT NULL,
  `status_id_psl` bigint(20) DEFAULT NULL,
  `log_detail_psl` text,
  `deleted_psl` smallint(6) DEFAULT '0',
  `createdon_psl` datetime DEFAULT NULL,
  `createdby_psl` bigint(20) DEFAULT NULL,
  `editedon_psl` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_psl` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_psl`),
  KEY `fk_project_id_psl` (`project_id_psl`),
  KEY `fk_status_id_psl` (`status_id_psl`),
  CONSTRAINT `fk_project_id_psl` FOREIGN KEY (`project_id_psl`) REFERENCES `wfl_projects` (`id_pro`),
  CONSTRAINT `fk_status_id_psl` FOREIGN KEY (`status_id_psl`) REFERENCES `wfl_project_status` (`id_pst`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_status_log
-- ----------------------------
INSERT INTO `wfl_project_status_log` VALUES ('1', '18', '1', null, '0', '2018-06-11 14:15:47', null, '2018-06-11 14:15:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('2', '18', '2', null, '0', '2018-06-11 14:30:50', null, '2018-06-11 14:30:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('3', '19', null, null, '0', '2018-06-11 14:32:03', null, '2018-06-11 14:32:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('4', '19', '5', null, '0', '2018-06-11 14:32:42', null, '2018-06-11 14:32:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('5', '17', '1', null, '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_project_status_log` VALUES ('6', '20', '1', null, '0', '2018-06-13 11:38:01', null, '2018-06-13 11:38:01', null);
INSERT INTO `wfl_project_status_log` VALUES ('7', '20', '2', null, '0', '2018-06-13 11:38:54', null, '2018-06-13 11:38:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('8', '21', '1', null, '0', '2018-06-15 11:42:49', null, '2018-06-15 11:42:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('9', '22', null, null, '0', '2018-06-22 10:42:16', null, '2018-06-22 10:42:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('10', '22', '1', null, '0', '2018-06-22 10:42:34', null, '2018-06-22 10:42:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('11', '23', null, null, '0', '2018-06-22 11:40:00', null, '2018-06-22 11:40:00', null);
INSERT INTO `wfl_project_status_log` VALUES ('12', '24', '1', null, '0', '2018-06-22 11:41:34', null, '2018-06-22 11:41:34', null);

-- ----------------------------
-- Table structure for wfl_stakes_team_leader
-- ----------------------------
DROP TABLE IF EXISTS `wfl_stakes_team_leader`;
CREATE TABLE `wfl_stakes_team_leader` (
  `id_stl` bigint(20) NOT NULL AUTO_INCREMENT,
  `leader_stl` varchar(20) DEFAULT NULL,
  `deleted_stl` smallint(6) DEFAULT '0',
  `createdon_stl` datetime DEFAULT NULL,
  `createdby_stl` bigint(20) DEFAULT NULL,
  `editedon_stl` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_stl` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_stl`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_stakes_team_leader
-- ----------------------------
INSERT INTO `wfl_stakes_team_leader` VALUES ('1', 'Dandy coca', '0', null, null, '2018-06-22 10:58:31', null);
INSERT INTO `wfl_stakes_team_leader` VALUES ('2', 'migue flores', '0', null, null, '2018-06-22 10:58:36', null);
INSERT INTO `wfl_stakes_team_leader` VALUES ('3', 'river cortez', '0', null, null, '0000-00-00 00:00:00', null);
