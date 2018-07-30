/*
Navicat MySQL Data Transfer

Source Server         : LOCAL_HOST
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : serebo

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-07-30 17:11:31
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sec_features
-- ----------------------------
INSERT INTO `sec_features` VALUES ('1', 'Edit user', 'user_edit', 'fa fa-edit', 'panel/User/edit', 'Edit users', '6', '7', '0', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('2', 'Cancelado', 'Approvement_canceled', 'fa fa-table', 'panel/Approvement/canceled', 'Proyecto cancelado', '13', '30', '1', '0', null, null, '2018-07-23 11:37:51', null);
INSERT INTO `sec_features` VALUES ('3', 'Lista', 'user_index', 'fa fa-table', 'panel/User', '', '6', '5', '1', '0', null, null, '2018-07-19 16:20:52', null);
INSERT INTO `sec_features` VALUES ('4', 'Add user', 'user_add', 'fa fa-user-plus', 'panel/User/add', 'Add users', '6', '6', '0', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('5', 'Etapa de diseño', 'design', 'glyphicon glyphicon-pencil', '#', '', null, '14', '1', '0', null, null, '2018-07-19 16:57:04', null);
INSERT INTO `sec_features` VALUES ('6', 'Usuarios', 'users', 'fa fa-users', '#', '', null, '4', '1', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('7', 'My profile', 'user_profile', 'fa fa-user', 'panel/User/myProfile', 'User\'s profile', null, '3', '0', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('8', 'Proyectos', 'project', 'fa fa-folder', '#', '', null, '9', '1', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('9', 'Roles', 'role', 'fa fa-user', '#', '', null, '32', '1', '0', null, null, '2018-07-20 14:17:12', null);
INSERT INTO `sec_features` VALUES ('10', 'Estaqueado', 'design_stakes', 'fa fa-users', 'panel/Design/stakesTeam', '', '5', '16', '1', '0', null, null, '2018-07-20 13:57:20', null);
INSERT INTO `sec_features` VALUES ('11', 'Digitalizacion', 'design_digitization', 'fa fa-laptop', 'panel/Design/digitization', '', '5', '17', '1', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('12', 'Dibujo', 'design_drawing', 'fa fa-pencil-square-o', 'panel/Design/drawing', '', '5', '18', '1', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('13', 'Etapa de aprobacion', 'Approvement', 'fa fa-check', '#', '', null, '26', '1', '0', null, null, '2018-07-20 14:17:12', null);
INSERT INTO `sec_features` VALUES ('14', 'Aprobado', 'Approvement_approved', 'fa fa-check', 'panel/Approvement/approved', 'El proyecto ha sido aprobado', '13', '29', '1', '0', null, null, '2018-07-24 16:54:04', null);
INSERT INTO `sec_features` VALUES ('15', 'Por enviar a cree', 'Approvement_pending_to_send', 'fa fa-clock-o', 'panel/Approvement/readyToSend', 'Listo para ser enviado a CREE', '13', '27', '1', '0', null, null, '2018-07-23 11:45:17', null);
INSERT INTO `sec_features` VALUES ('16', 'Cronograma', 'design_schedule', 'fa fa-clock-o', 'panel/Design/schedule', '', '5', '19', '1', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('17', 'Lista', 'design_index', 'glyphicon glyphicon-pencil', 'panel/Design', '', '5', '15', '1', '0', null, null, '2018-07-20 10:56:46', null);
INSERT INTO `sec_features` VALUES ('18', 'Home', 'home', 'fa fa-home', 'panel/Home', '', null, '1', '1', '0', null, null, '2018-07-19 16:04:56', null);
INSERT INTO `sec_features` VALUES ('19', 'Permisos', 'permission', 'fa fa-lock', 'panel/Permission', 'Add, edit, and handle user permissions', null, '37', '1', '0', null, null, '2018-07-20 14:17:12', null);
INSERT INTO `sec_features` VALUES ('20', 'Lista', 'role_index', 'fa fa-table', 'panel/Role', 'Role list', '9', '33', '1', '0', null, null, '2018-07-20 14:17:12', null);
INSERT INTO `sec_features` VALUES ('21', 'Add role', 'role_add', 'fa fa-plus', '#', 'Add role form', '9', '34', '0', '0', null, null, '2018-07-20 14:17:12', null);
INSERT INTO `sec_features` VALUES ('22', 'Edit role', 'role_edit', 'fa fa-edit', '#', 'Edit role form', '9', '35', '0', '0', null, null, '2018-07-20 14:17:12', null);
INSERT INTO `sec_features` VALUES ('23', 'Dashboard', 'dashboard_index', 'fa fa-dashboard', 'panel/Dashboard', 'User dashboard', null, '2', '1', '0', null, null, '2018-07-19 16:13:09', null);
INSERT INTO `sec_features` VALUES ('24', 'Lista', 'project_index', 'fa fa-table', 'panel/Project', 'Projects', '8', '10', '1', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('25', 'Crear proyecto', 'project_add', 'fa fa-plus', 'panel/Project/add', 'Add new project', '8', '11', '1', '0', null, null, '2018-07-24 16:49:43', null);
INSERT INTO `sec_features` VALUES ('26', 'Edit project', 'project_edit', 'fa fa-pencil', 'panel/Project/edit', 'Edit project', '8', '12', '0', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('27', 'Delete project', 'delete_project', 'fa fa-times', 'panel/Project/delete', 'Delete project', '8', '13', '0', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('28', 'Delete user', 'delete_user', 'fa fa-times', 'panel/User/delete', 'Delete user', '6', '8', '0', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('29', 'Delete role', 'delete_role', 'fa fa-times', 'panel/Role/delete', 'Delete role', '9', '36', '0', '0', null, null, '2018-07-20 14:17:12', null);
INSERT INTO `sec_features` VALUES ('30', 'State management', 'project_status_management', 'fa fa-table', 'panel/ProjectStatus/stateManagement', 'Project state management', '5', '20', '0', '0', null, null, '2018-07-19 16:15:46', null);
INSERT INTO `sec_features` VALUES ('31', 'Estados', 'project_status_index', 'fa fa-table', 'panel/ProjectStatus', 'Project status', null, '31', '1', '0', null, null, '2018-07-20 14:17:12', null);
INSERT INTO `sec_features` VALUES ('32', 'Enviado a cree', 'approvement_sent_to_cree', 'fa fa-send', 'panel/Approvement/alreadySent', 'El proyecto ha sido enviado a CREE', '13', '28', '1', '0', null, null, '2018-07-23 11:36:33', null);
INSERT INTO `sec_features` VALUES ('33', 'Rectificar diseño', 'rectify_design', 'glyphicon glyphicon-refresh', '#', '', '5', '21', '1', '0', null, null, '2018-07-20 16:40:18', null);
INSERT INTO `sec_features` VALUES ('34', 'Estaqueado', 're_stake_stake', 'fa fa-users', 'panel/ReStake/stakesTeam', '', '33', '22', '1', '0', '2018-07-20 13:59:00', null, '2018-07-20 14:27:03', null);
INSERT INTO `sec_features` VALUES ('35', 'Digitalizacion', 're_stake_digitization', 'fa fa-laptop', 'panel/ReStake/digitization', '', '33', '23', '1', '0', '2018-07-20 14:01:58', null, '2018-07-20 14:27:07', null);
INSERT INTO `sec_features` VALUES ('36', 'Dibujo', 're_stake_drawing', 'fa fa-pencil', 'panel/ReStake/drawing', '', '33', '24', '1', '0', '2018-07-20 14:02:52', null, '2018-07-20 14:27:11', null);
INSERT INTO `sec_features` VALUES ('37', 'Rectificar ilustracion', 're_illustrate', 'glyphicon glyphicon-refresh', '#', '', '5', '25', '1', '0', '2018-07-20 14:14:42', null, '2018-07-20 16:40:25', null);
INSERT INTO `sec_features` VALUES ('38', 'Digitalizacion', 're_illustrate_digitization', 'fa fa-laptop', 'panel/ReIllustrate/digitization', '', '37', '1', '1', '0', '2018-07-20 14:18:27', null, '2018-07-20 14:26:21', null);
INSERT INTO `sec_features` VALUES ('39', 'Dibujo', 're_illustrate_drawing', 'fa fa-pencil', 'panel/ReIllustrate/drawing', '', '37', '1', '1', '0', '2018-07-20 14:20:03', null, '2018-07-20 14:26:24', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=757 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
INSERT INTO `sec_permissions` VALUES ('233', '3', '3', '1', '2018-06-01 17:51:53', null, '2018-07-19 11:17:04', null);
INSERT INTO `sec_permissions` VALUES ('234', '3', '7', '1', '2018-06-01 17:51:53', null, '2018-07-19 11:17:04', null);
INSERT INTO `sec_permissions` VALUES ('235', '3', '18', '1', '2018-06-01 17:51:53', null, '2018-07-19 11:17:04', null);
INSERT INTO `sec_permissions` VALUES ('236', '3', '23', '1', '2018-06-01 17:51:53', null, '2018-07-19 11:17:04', null);
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
INSERT INTO `sec_permissions` VALUES ('426', '1', '1', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('427', '1', '2', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('428', '1', '3', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('429', '1', '4', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('430', '1', '5', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('431', '1', '6', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('432', '1', '7', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('433', '1', '8', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('434', '1', '9', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('435', '1', '10', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('436', '1', '11', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('437', '1', '12', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('438', '1', '13', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('439', '1', '14', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('440', '1', '15', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('441', '1', '16', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('442', '1', '17', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('443', '1', '18', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('444', '1', '19', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('445', '1', '20', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('446', '1', '21', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('447', '1', '22', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('448', '1', '23', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('449', '1', '24', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('450', '1', '25', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('451', '1', '26', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('452', '1', '27', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('453', '1', '28', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('454', '1', '29', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('455', '1', '30', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('456', '1', '31', '1', '2018-06-06 17:57:07', null, '2018-07-19 12:30:56', null);
INSERT INTO `sec_permissions` VALUES ('457', '5', '5', '1', '2018-07-19 17:09:05', null, '2018-07-19 12:31:09', null);
INSERT INTO `sec_permissions` VALUES ('458', '5', '10', '1', '2018-07-19 17:09:05', null, '2018-07-19 12:31:09', null);
INSERT INTO `sec_permissions` VALUES ('459', '5', '11', '1', '2018-07-19 17:09:05', null, '2018-07-19 12:31:09', null);
INSERT INTO `sec_permissions` VALUES ('460', '5', '12', '1', '2018-07-19 17:09:05', null, '2018-07-19 12:31:09', null);
INSERT INTO `sec_permissions` VALUES ('461', '5', '16', '1', '2018-07-19 17:09:05', null, '2018-07-19 12:31:09', null);
INSERT INTO `sec_permissions` VALUES ('462', '5', '17', '1', '2018-07-19 17:09:05', null, '2018-07-19 12:31:09', null);
INSERT INTO `sec_permissions` VALUES ('463', '5', '24', '1', '2018-07-19 17:09:05', null, '2018-07-19 12:31:09', null);
INSERT INTO `sec_permissions` VALUES ('464', '6', '5', '1', '2018-07-19 17:09:13', null, '2018-07-19 12:31:13', null);
INSERT INTO `sec_permissions` VALUES ('465', '6', '10', '1', '2018-07-19 17:09:13', null, '2018-07-19 12:31:13', null);
INSERT INTO `sec_permissions` VALUES ('466', '6', '11', '1', '2018-07-19 17:09:13', null, '2018-07-19 12:31:13', null);
INSERT INTO `sec_permissions` VALUES ('467', '6', '12', '1', '2018-07-19 17:09:13', null, '2018-07-19 12:31:13', null);
INSERT INTO `sec_permissions` VALUES ('468', '6', '16', '1', '2018-07-19 17:09:13', null, '2018-07-19 12:31:13', null);
INSERT INTO `sec_permissions` VALUES ('469', '6', '17', '1', '2018-07-19 17:09:13', null, '2018-07-19 12:31:13', null);
INSERT INTO `sec_permissions` VALUES ('470', '3', '7', '0', '2018-07-19 17:17:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('471', '3', '18', '0', '2018-07-19 17:17:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('472', '3', '23', '0', '2018-07-19 17:17:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('473', '1', '1', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('474', '1', '2', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('475', '1', '3', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('476', '1', '4', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('477', '1', '5', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('478', '1', '6', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('479', '1', '7', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('480', '1', '8', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('481', '1', '9', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('482', '1', '10', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('483', '1', '11', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('484', '1', '12', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('485', '1', '13', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('486', '1', '14', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('487', '1', '15', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('488', '1', '16', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('489', '1', '17', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('490', '1', '18', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('491', '1', '19', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('492', '1', '20', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('493', '1', '21', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('494', '1', '22', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('495', '1', '23', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('496', '1', '24', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('497', '1', '25', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('498', '1', '26', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('499', '1', '27', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('500', '1', '28', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('501', '1', '29', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('502', '1', '30', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('503', '1', '31', '1', '2018-07-19 18:30:56', null, '2018-07-19 15:12:05', null);
INSERT INTO `sec_permissions` VALUES ('504', '5', '5', '1', '2018-07-19 18:31:09', null, '2018-07-19 16:52:34', null);
INSERT INTO `sec_permissions` VALUES ('505', '5', '10', '1', '2018-07-19 18:31:09', null, '2018-07-19 16:52:34', null);
INSERT INTO `sec_permissions` VALUES ('506', '5', '11', '1', '2018-07-19 18:31:09', null, '2018-07-19 16:52:34', null);
INSERT INTO `sec_permissions` VALUES ('507', '5', '12', '1', '2018-07-19 18:31:09', null, '2018-07-19 16:52:34', null);
INSERT INTO `sec_permissions` VALUES ('508', '5', '16', '1', '2018-07-19 18:31:09', null, '2018-07-19 16:52:34', null);
INSERT INTO `sec_permissions` VALUES ('509', '5', '17', '1', '2018-07-19 18:31:09', null, '2018-07-19 16:52:34', null);
INSERT INTO `sec_permissions` VALUES ('510', '5', '24', '1', '2018-07-19 18:31:09', null, '2018-07-19 16:52:34', null);
INSERT INTO `sec_permissions` VALUES ('511', '5', '30', '1', '2018-07-19 18:31:09', null, '2018-07-19 16:52:34', null);
INSERT INTO `sec_permissions` VALUES ('512', '6', '5', '0', '2018-07-19 18:31:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('513', '6', '10', '0', '2018-07-19 18:31:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('514', '6', '11', '0', '2018-07-19 18:31:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('515', '6', '12', '0', '2018-07-19 18:31:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('516', '6', '16', '0', '2018-07-19 18:31:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('517', '6', '17', '0', '2018-07-19 18:31:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('518', '6', '30', '0', '2018-07-19 18:31:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('519', '1', '1', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('520', '1', '2', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('521', '1', '3', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('522', '1', '4', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('523', '1', '5', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('524', '1', '6', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('525', '1', '7', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('526', '1', '8', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('527', '1', '9', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('528', '1', '10', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('529', '1', '11', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('530', '1', '12', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('531', '1', '13', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('532', '1', '14', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('533', '1', '15', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('534', '1', '16', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('535', '1', '17', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('536', '1', '18', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('537', '1', '19', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('538', '1', '20', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('539', '1', '21', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('540', '1', '22', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('541', '1', '23', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('542', '1', '24', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('543', '1', '25', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('544', '1', '26', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('545', '1', '27', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('546', '1', '28', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('547', '1', '29', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('548', '1', '30', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('549', '1', '31', '1', '2018-07-19 21:12:05', null, '2018-07-19 15:42:36', null);
INSERT INTO `sec_permissions` VALUES ('550', '1', '1', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('551', '1', '2', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('552', '1', '3', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('553', '1', '4', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('554', '1', '5', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('555', '1', '6', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('556', '1', '7', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('557', '1', '8', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('558', '1', '9', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('559', '1', '10', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('560', '1', '11', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('561', '1', '12', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('562', '1', '13', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('563', '1', '14', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('564', '1', '15', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('565', '1', '16', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('566', '1', '17', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('567', '1', '18', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('568', '1', '19', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('569', '1', '20', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('570', '1', '21', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('571', '1', '22', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('572', '1', '23', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('573', '1', '24', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('574', '1', '25', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('575', '1', '26', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('576', '1', '27', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('577', '1', '28', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('578', '1', '29', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('579', '1', '30', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('580', '1', '31', '1', '2018-07-19 21:42:36', null, '2018-07-20 10:59:09', null);
INSERT INTO `sec_permissions` VALUES ('581', '5', '5', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('582', '5', '8', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('583', '5', '10', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('584', '5', '11', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('585', '5', '12', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('586', '5', '16', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('587', '5', '17', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('588', '5', '24', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('589', '5', '25', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('590', '5', '26', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('591', '5', '27', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('592', '5', '30', '1', '2018-07-19 22:52:34', null, '2018-07-24 16:24:00', null);
INSERT INTO `sec_permissions` VALUES ('593', '1', '1', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('594', '1', '2', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('595', '1', '3', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('596', '1', '4', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('597', '1', '5', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('598', '1', '6', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('599', '1', '7', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('600', '1', '8', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('601', '1', '9', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('602', '1', '10', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('603', '1', '11', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('604', '1', '12', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('605', '1', '13', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('606', '1', '14', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('607', '1', '15', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('608', '1', '16', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('609', '1', '17', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('610', '1', '18', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('611', '1', '19', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('612', '1', '20', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('613', '1', '21', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('614', '1', '22', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('615', '1', '23', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('616', '1', '24', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('617', '1', '25', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('618', '1', '26', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('619', '1', '27', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('620', '1', '28', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('621', '1', '29', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('622', '1', '30', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('623', '1', '31', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('624', '1', '32', '1', '2018-07-20 16:59:09', null, '2018-07-20 13:43:24', null);
INSERT INTO `sec_permissions` VALUES ('625', '1', '1', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('626', '1', '2', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('627', '1', '3', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('628', '1', '4', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('629', '1', '5', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('630', '1', '6', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('631', '1', '7', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('632', '1', '8', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('633', '1', '9', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('634', '1', '10', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('635', '1', '11', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('636', '1', '12', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('637', '1', '13', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('638', '1', '14', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('639', '1', '15', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('640', '1', '16', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('641', '1', '17', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('642', '1', '18', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('643', '1', '19', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('644', '1', '20', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('645', '1', '21', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('646', '1', '22', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('647', '1', '23', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('648', '1', '24', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('649', '1', '25', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('650', '1', '26', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('651', '1', '27', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('652', '1', '28', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('653', '1', '29', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('654', '1', '30', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('655', '1', '31', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('656', '1', '32', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('657', '1', '33', '1', '2018-07-20 19:43:24', null, '2018-07-20 14:02:57', null);
INSERT INTO `sec_permissions` VALUES ('658', '1', '1', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('659', '1', '2', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('660', '1', '3', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('661', '1', '4', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('662', '1', '5', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('663', '1', '6', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('664', '1', '7', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('665', '1', '8', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('666', '1', '9', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('667', '1', '10', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('668', '1', '11', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('669', '1', '12', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('670', '1', '13', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('671', '1', '14', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('672', '1', '15', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('673', '1', '16', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('674', '1', '17', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('675', '1', '18', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('676', '1', '19', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('677', '1', '20', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('678', '1', '21', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('679', '1', '22', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('680', '1', '23', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('681', '1', '24', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('682', '1', '25', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('683', '1', '26', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('684', '1', '27', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('685', '1', '28', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('686', '1', '29', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('687', '1', '30', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('688', '1', '31', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('689', '1', '32', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('690', '1', '33', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('691', '1', '34', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('692', '1', '35', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('693', '1', '36', '1', '2018-07-20 20:02:57', null, '2018-07-20 14:20:07', null);
INSERT INTO `sec_permissions` VALUES ('694', '1', '1', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('695', '1', '2', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('696', '1', '3', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('697', '1', '4', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('698', '1', '5', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('699', '1', '6', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('700', '1', '7', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('701', '1', '8', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('702', '1', '9', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('703', '1', '10', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('704', '1', '11', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('705', '1', '12', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('706', '1', '13', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('707', '1', '14', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('708', '1', '15', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('709', '1', '16', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('710', '1', '17', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('711', '1', '18', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('712', '1', '19', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('713', '1', '20', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('714', '1', '21', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('715', '1', '22', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('716', '1', '23', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('717', '1', '24', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('718', '1', '25', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('719', '1', '26', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('720', '1', '27', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('721', '1', '28', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('722', '1', '29', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('723', '1', '30', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('724', '1', '31', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('725', '1', '32', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('726', '1', '33', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('727', '1', '34', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('728', '1', '35', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('729', '1', '36', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('730', '1', '37', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('731', '1', '38', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('732', '1', '39', '0', '2018-07-20 20:20:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('733', '5', '2', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('734', '5', '5', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('735', '5', '8', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('736', '5', '10', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('737', '5', '11', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('738', '5', '12', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('739', '5', '13', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('740', '5', '14', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('741', '5', '15', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('742', '5', '16', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('743', '5', '17', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('744', '5', '24', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('745', '5', '25', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('746', '5', '26', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('747', '5', '27', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('748', '5', '30', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('749', '5', '32', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('750', '5', '33', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('751', '5', '34', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('752', '5', '35', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('753', '5', '36', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('754', '5', '37', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('755', '5', '38', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('756', '5', '39', '0', '2018-07-24 20:24:00', null, '0000-00-00 00:00:00', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sec_roles
-- ----------------------------
INSERT INTO `sec_roles` VALUES ('1', 'Super admin', 'super_admin', '0', null, null, '2018-05-28 15:38:31', null);
INSERT INTO `sec_roles` VALUES ('2', 'Admin', 'admin', '0', null, null, '2018-05-28 15:38:34', null);
INSERT INTO `sec_roles` VALUES ('3', 'User', 'user', '0', null, null, '2018-06-06 11:49:32', null);
INSERT INTO `sec_roles` VALUES ('4', 'Guestttt', 'guest', '1', '2018-06-01 11:46:04', null, '2018-06-05 12:28:35', null);
INSERT INTO `sec_roles` VALUES ('5', 'Proyectista', 'projector', '0', '2018-07-19 11:08:40', null, '2018-07-20 13:28:00', null);
INSERT INTO `sec_roles` VALUES ('6', 'Diseñador', 'designer', '0', '2018-07-19 11:08:53', null, '2018-07-20 13:28:03', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
INSERT INTO `sec_userroles` VALUES ('16', '2', '3', '1', '2018-06-01 11:48:58', '1', '2018-07-19 11:10:00', null);
INSERT INTO `sec_userroles` VALUES ('17', '7', '3', '1', '2018-06-05 12:26:51', '1', '2018-07-19 11:10:12', null);
INSERT INTO `sec_userroles` VALUES ('18', '7', '4', '1', '2018-06-05 12:26:51', '1', '2018-06-05 12:28:35', null);
INSERT INTO `sec_userroles` VALUES ('19', '8', '3', '0', '2018-07-17 17:36:07', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('20', '9', '3', '0', '2018-07-17 17:37:00', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('21', '2', '3', '1', '2018-07-19 11:10:00', '1', '2018-07-19 11:11:43', null);
INSERT INTO `sec_userroles` VALUES ('22', '2', '5', '1', '2018-07-19 11:10:00', '1', '2018-07-19 11:11:43', null);
INSERT INTO `sec_userroles` VALUES ('23', '2', '6', '1', '2018-07-19 11:10:00', '1', '2018-07-19 11:11:43', null);
INSERT INTO `sec_userroles` VALUES ('24', '7', '3', '1', '2018-07-19 11:10:12', '1', '2018-07-19 11:11:11', null);
INSERT INTO `sec_userroles` VALUES ('25', '7', '6', '1', '2018-07-19 11:10:12', '1', '2018-07-19 11:11:11', null);
INSERT INTO `sec_userroles` VALUES ('26', '7', '3', '0', '2018-07-19 11:11:11', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('27', '7', '6', '0', '2018-07-19 11:11:11', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('28', '2', '3', '0', '2018-07-19 11:11:43', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('29', '2', '5', '0', '2018-07-19 11:11:43', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('30', '2', '6', '0', '2018-07-19 11:11:43', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('31', '6', '1', '1', '2018-07-19 17:27:02', '1', '2018-07-24 16:33:31', null);
INSERT INTO `sec_userroles` VALUES ('32', '6', '1', '0', '2018-07-24 16:33:31', '1', '0000-00-00 00:00:00', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sec_users
-- ----------------------------
INSERT INTO `sec_users` VALUES ('1', 'jair', 'cussy', 'jair@twiiti.com', null, null, '$2y$10$biHC1c85bbcHmNmRvKc1ZumAcCYkU2.q.oMzCX2r9aPpYX0HbVd46', null, '', '', '1', '0', '', '0', '2018-04-26 00:32:39', null, '2018-04-26 00:32:39', null);
INSERT INTO `sec_users` VALUES ('2', 'Mario', 'Aguilera', 'marioa@mailinator.com', null, null, '$2y$10$3QicFM3Htj1iAKhIUmHv2ulIOB0k.SXmcZkCRbDOLvYVZoNBInoZe', null, '', '', '1', '0', '', '0', '2018-05-13 21:47:16', null, '2018-07-19 11:11:43', null);
INSERT INTO `sec_users` VALUES ('3', 'Dandy', 'Coca', 'nuser@mailinator.com', null, null, '$2y$10$r.eAisul1hyGSXgurkWJjemFA7yxkVcg28lu75DBBgCu6o.W0c0vW', null, '', '', '1', '0', '', '0', '2018-05-28 10:32:52', null, '2018-07-19 11:01:45', null);
INSERT INTO `sec_users` VALUES ('4', 'Miguel', 'Flores', 'nuser2@mailinator.com', null, null, '$2y$10$c8Jgx3up2nF9n523UoXHyeRWU5ZbL9L1EWxIiGHrADXIFa9QJXE2S', null, '', '', '1', '0', '', '0', '2018-05-28 10:34:28', null, '2018-07-19 11:01:49', null);
INSERT INTO `sec_users` VALUES ('5', 'Rider', 'Cortez', 'tuser@mailinator.com', null, null, '$2y$10$42XsIiB5gRBPcTlxoHm84eyWV9hNtvcPCVcXi1UAB09unAmQIZdIG', null, '', '', '1', '0', '', '0', '2018-05-30 09:44:40', null, '2018-07-24 18:03:50', null);
INSERT INTO `sec_users` VALUES ('6', 'Victor Hugo', 'Suarez', 'vsuarez@mailinator.com', null, null, '$2y$10$.2BkIdbwCJp369k1//gJ8.Gr0jq7ZnIkvm1X5QKbd9kUHNimtT8Ge', null, '', '', '1', '0', '', '0', '2018-05-30 09:58:30', null, '2018-07-24 16:33:31', null);
INSERT INTO `sec_users` VALUES ('7', 'Pablo', 'Mendoza', 'pablom@mailinator.com', null, null, '$2y$10$W/aBzKpgfucg1MZzh2rtuOKYboPu1dUBr8Ru0H4LiV.QkJSkejsOC', null, '', '', '1', '0', '', '0', '2018-06-04 12:15:00', null, '2018-07-19 11:14:44', null);
INSERT INTO `sec_users` VALUES ('8', 'Pepe', 'Vargas', 'digitalizador1@mailiantor.com', null, null, '$2y$10$CjDWq.RhG/LI5l5P77eEmelXD27P0RVc4GEyCojfqR96mXf/nrMfi', null, '', '', '1', '0', '', '0', '2018-07-17 17:36:07', null, '2018-07-19 11:05:34', null);
INSERT INTO `sec_users` VALUES ('9', 'Jose', 'Duran', 'dibujante1@mailinator.com', null, null, '$2y$10$iozfBGQg.Ib5nCkC6yKNx.5fs0euDukOBE3.8QyE3YpLdl3rN5C/.', null, '', '', '1', '0', '', '0', '2018-07-17 17:37:00', null, '2018-07-19 11:05:40', null);

-- ----------------------------
-- Table structure for wfl_projects
-- ----------------------------
DROP TABLE IF EXISTS `wfl_projects`;
CREATE TABLE `wfl_projects` (
  `id_pro` bigint(20) NOT NULL AUTO_INCREMENT,
  `code_pro` varchar(15) DEFAULT NULL,
  `project_name_pro` varchar(100) DEFAULT NULL,
  `system_pro` bigint(20) DEFAULT NULL,
  `address_pro` varchar(50) DEFAULT NULL,
  `entry_date_pro` datetime DEFAULT NULL,
  `cre_fiscal_pro` varchar(50) DEFAULT NULL,
  `status_pro` bigint(20) DEFAULT NULL,
  `project_start_pro` datetime DEFAULT NULL,
  `project_end_pro` datetime DEFAULT NULL,
  `points_pro` smallint(2) DEFAULT NULL,
  `distance_pro` double(5,2) DEFAULT NULL,
  `deleted_pro` smallint(1) DEFAULT '0',
  `createdon_pro` datetime DEFAULT NULL,
  `createdby_pro` bigint(20) DEFAULT NULL,
  `editedon_pro` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_pro` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_pro`),
  UNIQUE KEY `UQ_sec_roles_id_rol` (`id_pro`) USING BTREE,
  KEY `fk_status_pro` (`status_pro`),
  CONSTRAINT `fk_status_pro` FOREIGN KEY (`status_pro`) REFERENCES `wfl_project_status` (`id_pst`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of wfl_projects
-- ----------------------------
INSERT INTO `wfl_projects` VALUES ('1', 'RD.18.0292', '', '3', 'Comunidad Medio Monte', '2018-07-01 00:00:00', 'Garcia', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '80', '3.20', '0', '2018-07-24 17:01:05', null, '2018-07-25 15:06:11', null);
INSERT INTO `wfl_projects` VALUES ('2', 'RO.18.0161', '', '1', 'Equipetrol', '2018-07-18 00:00:00', 'GARCIA', '5', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '3', '0.90', '0', '2018-07-24 17:03:09', null, '2018-07-25 17:26:05', null);
INSERT INTO `wfl_projects` VALUES ('3', 'RD.18.0211', '', '1', 'No sabemos', '2018-07-02 00:00:00', 'Prueba', '9', '2018-08-01 00:00:00', '2018-08-02 00:00:00', '4', '1.00', '1', '2018-07-24 17:26:48', null, '2018-07-25 16:50:20', null);
INSERT INTO `wfl_projects` VALUES ('4', 'RO.18.0166', '', '1', 'El Remanzo', '2018-07-25 00:00:00', 'Suarez', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.00', '0', '2018-07-25 08:20:36', null, '2018-07-25 15:07:46', null);
INSERT INTO `wfl_projects` VALUES ('5', 'RO.18.0167', '', '1', 'El Remanzo', '2018-07-25 00:00:00', 'Suarez', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.00', '0', '2018-07-25 08:22:33', null, '2018-07-25 15:08:07', null);
INSERT INTO `wfl_projects` VALUES ('6', 'RD.18.0858', '', '1', 'Las Cabañas', '2018-04-26 00:00:00', 'Giles', '9', '2018-07-25 00:00:00', '2018-07-25 00:00:00', '64', '3.00', '1', '2018-07-25 08:30:43', null, '2018-07-25 16:45:34', null);
INSERT INTO `wfl_projects` VALUES ('7', 'RD.18.0210', '', '5', 'Puerto Suarez', '2018-07-02 00:00:00', 'Jose Luis Rodriguez', '5', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '18', '0.72', '0', '2018-07-25 10:21:51', null, '2018-07-26 09:22:52', null);
INSERT INTO `wfl_projects` VALUES ('8', 'RA.18.1717', '', '3', 'Entre San Julian y San Ramon', '2018-07-21 00:00:00', 'Herman Velasco Flores', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '3', '1.00', '0', '2018-07-25 11:53:18', null, '2018-07-25 15:08:53', null);
INSERT INTO `wfl_projects` VALUES ('9', 'RA.18.1218', '', '3', 'San Julian', '2018-06-16 16:53:43', 'Santos Cespedes', '14', '2018-07-25 16:55:12', '2018-07-25 16:55:12', '39', '1.50', '0', '2018-07-25 16:53:43', null, '2018-07-30 15:50:21', null);
INSERT INTO `wfl_projects` VALUES ('10', 'RD.19.0045', '', '4', 'Itambemi', '2018-07-26 08:59:52', 'LUJAN', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '16', '0.64', '0', '2018-07-26 08:59:52', null, '2018-07-26 08:59:52', null);
INSERT INTO `wfl_projects` VALUES ('11', 'RA.18.1219', '', '3', 'San Julian', '2018-06-16 10:20:24', 'Santos Cespedes', '14', '2018-08-01 10:24:47', '2018-08-20 10:24:47', '37', '1.48', '0', '2018-07-26 10:20:24', null, '2018-07-30 16:20:01', null);
INSERT INTO `wfl_projects` VALUES ('12', 'RA.18.1538', '', '3', 'San Juan de Lomerio', '2018-07-16 10:28:05', 'Santos Cespedes', '9', '2018-08-06 10:31:04', '2018-08-09 10:31:04', '6', '0.20', '0', '2018-07-26 10:28:05', null, '2018-07-26 10:31:06', null);
INSERT INTO `wfl_projects` VALUES ('13', 'RA.18.1539', '', '3', 'San Ramon', '2018-07-26 10:38:49', 'Herman Velasco Flores', '10', '2018-08-13 10:53:42', '2018-08-14 10:53:42', '2', '0.10', '0', '2018-07-26 10:38:49', null, '2018-07-30 16:23:46', null);
INSERT INTO `wfl_projects` VALUES ('14', 'RD.18.1613', '', '3', 'San Ramon', '2018-07-02 11:08:50', 'Herman Velasco Flores', '5', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '5', '0.16', '0', '2018-07-26 11:08:50', null, '2018-07-26 11:11:34', null);

-- ----------------------------
-- Table structure for wfl_project_budgets
-- ----------------------------
DROP TABLE IF EXISTS `wfl_project_budgets`;
CREATE TABLE `wfl_project_budgets` (
  `id_prb` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_log_id_prb` bigint(20) DEFAULT NULL,
  `design_prb` double(8,2) DEFAULT NULL,
  `building_prb` double(8,2) DEFAULT NULL,
  `deleted_prb` smallint(6) DEFAULT '0',
  `createdon_prb` datetime DEFAULT NULL,
  `createdby_prb` bigint(20) DEFAULT NULL,
  `editedon_prb` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_prb` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_prb`),
  KEY `fk_status_log_id_prb` (`status_log_id_prb`),
  CONSTRAINT `fk_status_log_id_prb` FOREIGN KEY (`status_log_id_prb`) REFERENCES `wfl_project_status_log` (`id_psl`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_budgets
-- ----------------------------
INSERT INTO `wfl_project_budgets` VALUES ('1', '1', '80.00', '3.20', '0', '2018-07-24 17:01:05', null, '2018-07-24 17:01:05', null);
INSERT INTO `wfl_project_budgets` VALUES ('2', '2', '3.00', '0.90', '0', '2018-07-24 17:03:09', null, '2018-07-24 17:03:09', null);
INSERT INTO `wfl_project_budgets` VALUES ('3', '5', '4.00', '1.00', '0', '2018-07-24 17:26:48', null, '2018-07-24 17:26:48', null);
INSERT INTO `wfl_project_budgets` VALUES ('4', '7', '4.00', '1.00', '0', '2018-07-24 17:29:49', null, '2018-07-24 17:29:49', null);
INSERT INTO `wfl_project_budgets` VALUES ('5', '12', '1.00', '0.00', '0', '2018-07-25 08:20:36', null, '2018-07-25 08:20:36', null);
INSERT INTO `wfl_project_budgets` VALUES ('6', '13', '1.00', '0.00', '0', '2018-07-25 08:22:33', null, '2018-07-25 08:22:33', null);
INSERT INTO `wfl_project_budgets` VALUES ('7', '14', '64.00', '3.00', '0', '2018-07-25 08:30:43', null, '2018-07-25 08:30:43', null);
INSERT INTO `wfl_project_budgets` VALUES ('8', '15', '18.00', '0.72', '0', '2018-07-25 10:21:51', null, '2018-07-25 10:21:51', null);
INSERT INTO `wfl_project_budgets` VALUES ('9', '18', '3.00', '1.00', '0', '2018-07-25 11:53:18', null, '2018-07-25 11:53:18', null);
INSERT INTO `wfl_project_budgets` VALUES ('10', '23', '9.00', '0.15', '0', '2018-07-25 16:35:23', null, '2018-07-25 16:35:23', null);
INSERT INTO `wfl_project_budgets` VALUES ('11', '24', '39.00', '1.50', '0', '2018-07-25 16:53:43', null, '2018-07-25 16:53:43', null);
INSERT INTO `wfl_project_budgets` VALUES ('12', '30', '16.00', '0.64', '0', '2018-07-26 08:59:52', null, '2018-07-26 08:59:52', null);
INSERT INTO `wfl_project_budgets` VALUES ('13', '33', '18.00', '0.72', '0', '2018-07-26 09:22:41', null, '2018-07-26 09:22:41', null);
INSERT INTO `wfl_project_budgets` VALUES ('14', '35', '37.00', '1.48', '0', '2018-07-26 10:20:24', null, '2018-07-26 10:20:24', null);
INSERT INTO `wfl_project_budgets` VALUES ('15', '38', '37.00', '1.48', '0', '2018-07-26 10:22:04', null, '2018-07-26 10:22:04', null);
INSERT INTO `wfl_project_budgets` VALUES ('16', '41', '37.00', '1.48', '0', '2018-07-26 10:23:29', null, '2018-07-26 10:23:29', null);
INSERT INTO `wfl_project_budgets` VALUES ('17', '46', '6.00', '0.20', '0', '2018-07-26 10:28:05', null, '2018-07-26 10:28:05', null);
INSERT INTO `wfl_project_budgets` VALUES ('18', '48', '6.00', '0.20', '0', '2018-07-26 10:29:41', null, '2018-07-26 10:29:41', null);
INSERT INTO `wfl_project_budgets` VALUES ('19', '53', '2.00', '0.10', '0', '2018-07-26 10:38:49', null, '2018-07-26 10:38:49', null);
INSERT INTO `wfl_project_budgets` VALUES ('20', '55', '2.00', '0.10', '0', '2018-07-26 10:48:54', null, '2018-07-26 10:48:54', null);
INSERT INTO `wfl_project_budgets` VALUES ('21', '61', '5.00', '0.16', '0', '2018-07-26 11:08:50', null, '2018-07-26 11:08:50', null);
INSERT INTO `wfl_project_budgets` VALUES ('22', '63', '5.00', '0.16', '0', '2018-07-26 11:10:58', null, '2018-07-26 11:10:58', null);

-- ----------------------------
-- Table structure for wfl_project_points
-- ----------------------------
DROP TABLE IF EXISTS `wfl_project_points`;
CREATE TABLE `wfl_project_points` (
  `id_prp` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_log_id_prp` bigint(20) DEFAULT NULL,
  `points_quantity_prp` smallint(2) DEFAULT NULL,
  `distance_prp` double(5,2) DEFAULT NULL,
  `deleted_prp` smallint(6) DEFAULT '0',
  `createdon_prp` datetime DEFAULT NULL,
  `createdby_prp` bigint(20) DEFAULT NULL,
  `editedon_prp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_prp` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_prp`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_points
-- ----------------------------
INSERT INTO `wfl_project_points` VALUES ('1', '1', '80', '3.20', '0', '2018-07-24 17:01:05', null, '2018-07-24 17:01:05', null);
INSERT INTO `wfl_project_points` VALUES ('2', '2', '3', '0.90', '0', '2018-07-24 17:03:09', null, '2018-07-24 17:03:09', null);
INSERT INTO `wfl_project_points` VALUES ('3', '5', '4', '1.00', '0', '2018-07-24 17:26:48', null, '2018-07-24 17:26:48', null);
INSERT INTO `wfl_project_points` VALUES ('4', '7', '4', '1.00', '0', '2018-07-24 17:29:49', null, '2018-07-24 17:29:49', null);
INSERT INTO `wfl_project_points` VALUES ('5', '12', '1', '0.00', '0', '2018-07-25 08:20:36', null, '2018-07-25 08:20:36', null);
INSERT INTO `wfl_project_points` VALUES ('6', '13', '1', '0.00', '0', '2018-07-25 08:22:33', null, '2018-07-25 08:22:33', null);
INSERT INTO `wfl_project_points` VALUES ('7', '14', '64', '3.00', '0', '2018-07-25 08:30:43', null, '2018-07-25 08:30:43', null);
INSERT INTO `wfl_project_points` VALUES ('8', '15', '18', '0.72', '0', '2018-07-25 10:21:51', null, '2018-07-25 10:21:51', null);
INSERT INTO `wfl_project_points` VALUES ('9', '18', '3', '1.00', '0', '2018-07-25 11:53:18', null, '2018-07-25 11:53:18', null);
INSERT INTO `wfl_project_points` VALUES ('10', '23', '9', '0.15', '0', '2018-07-25 16:35:23', null, '2018-07-25 16:35:23', null);
INSERT INTO `wfl_project_points` VALUES ('11', '24', '39', '1.50', '0', '2018-07-25 16:53:43', null, '2018-07-25 16:53:43', null);
INSERT INTO `wfl_project_points` VALUES ('12', '30', '16', '0.64', '0', '2018-07-26 08:59:52', null, '2018-07-26 08:59:52', null);
INSERT INTO `wfl_project_points` VALUES ('13', '33', '18', '0.72', '0', '2018-07-26 09:22:41', null, '2018-07-26 09:22:41', null);
INSERT INTO `wfl_project_points` VALUES ('14', '35', '37', '1.48', '0', '2018-07-26 10:20:24', null, '2018-07-26 10:20:24', null);
INSERT INTO `wfl_project_points` VALUES ('15', '38', '37', '1.48', '0', '2018-07-26 10:22:04', null, '2018-07-26 10:22:04', null);
INSERT INTO `wfl_project_points` VALUES ('16', '41', '37', '1.48', '0', '2018-07-26 10:23:29', null, '2018-07-26 10:23:29', null);
INSERT INTO `wfl_project_points` VALUES ('17', '46', '6', '0.20', '0', '2018-07-26 10:28:05', null, '2018-07-26 10:28:05', null);
INSERT INTO `wfl_project_points` VALUES ('18', '48', '6', '0.20', '0', '2018-07-26 10:29:41', null, '2018-07-26 10:29:41', null);
INSERT INTO `wfl_project_points` VALUES ('19', '53', '2', '0.10', '0', '2018-07-26 10:38:49', null, '2018-07-26 10:38:49', null);
INSERT INTO `wfl_project_points` VALUES ('20', '55', '2', '0.10', '0', '2018-07-26 10:48:54', null, '2018-07-26 10:48:54', null);
INSERT INTO `wfl_project_points` VALUES ('21', '61', '5', '0.16', '0', '2018-07-26 11:08:50', null, '2018-07-26 11:08:50', null);
INSERT INTO `wfl_project_points` VALUES ('22', '63', '5', '0.16', '0', '2018-07-26 11:10:58', null, '2018-07-26 11:10:58', null);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_stakes
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_status
-- ----------------------------
INSERT INTO `wfl_project_status` VALUES ('1', 'Diseño', 'glyphicon glyphicon-pencil', '1', null, 'design', '0', null, null, '2018-06-19 15:35:48', null);
INSERT INTO `wfl_project_status` VALUES ('2', 'Estaqueado', 'fa fa-users', '2', '1', 'stakes', '0', null, null, '2018-06-19 15:35:51', null);
INSERT INTO `wfl_project_status` VALUES ('3', 'Digitalizacion', 'fa fa-laptop', '3', '1', 'digitization', '0', null, null, '2018-06-19 15:36:17', null);
INSERT INTO `wfl_project_status` VALUES ('5', 'Dibujo', 'fa fa-pencil-square-o', '4', '1', 'drawing', '0', null, null, '2018-06-22 12:04:00', null);
INSERT INTO `wfl_project_status` VALUES ('6', 'Cronograma', 'fa fa-clock-o', '5', '1', 'schedule', '0', null, null, '2018-06-22 11:12:23', null);
INSERT INTO `wfl_project_status` VALUES ('7', 'Sin asignar', 'fa fa-exclamation', '0', null, 'unsigned', '0', null, null, '2018-07-13 17:42:03', null);
INSERT INTO `wfl_project_status` VALUES ('8', 'Aprobacion', 'fa fa-check', '6', null, 'approvement', '0', null, null, '2018-07-20 14:37:12', null);
INSERT INTO `wfl_project_status` VALUES ('9', 'Por enviar', 'glyphicon glyphicon-hourglass', '7', null, 'ready_to_send', '0', null, null, '2018-07-20 14:37:29', null);
INSERT INTO `wfl_project_status` VALUES ('10', 'Enviado', 'fa fa-send', '8', null, 'already_sent', '0', null, null, '2018-07-20 14:37:34', null);
INSERT INTO `wfl_project_status` VALUES ('11', 'Aprobado', 'fa fa-check', '9', null, 'approved', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_project_status` VALUES ('12', 'Cancelado', 'fa fa-times', '10', null, 'canceled', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_project_status` VALUES ('13', 'Rect. de diseño', 'fa fa-refresh', '1', null, 'rectify_design', '0', null, null, '2018-07-30 16:21:00', null);
INSERT INTO `wfl_project_status` VALUES ('14', 'Rect. de ilustracion', 'fa fa-refresh', '1', null, 'rectify_illustration', '0', null, null, '2018-07-30 16:20:56', null);

-- ----------------------------
-- Table structure for wfl_project_status_log
-- ----------------------------
DROP TABLE IF EXISTS `wfl_project_status_log`;
CREATE TABLE `wfl_project_status_log` (
  `id_psl` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id_psl` bigint(20) DEFAULT NULL,
  `status_id_psl` bigint(20) DEFAULT NULL,
  `log_detail_psl` text,
  `manual_entry_date_psl` datetime DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_status_log
-- ----------------------------
INSERT INTO `wfl_project_status_log` VALUES ('1', '1', '1', 'Proyecto enviado a diseño', '2018-07-01 00:00:00', '0', '2018-07-24 17:01:05', null, '2018-07-24 17:01:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('2', '2', '1', 'Proyecto enviado a diseño', '2018-07-18 00:00:00', '0', '2018-07-24 17:03:09', null, '2018-07-24 17:03:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('3', '2', '2', '', '2018-07-19 00:00:00', '0', '2018-07-24 17:05:52', null, '2018-07-24 17:05:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('4', '1', '2', '', '2018-07-03 00:00:00', '0', '2018-07-24 17:10:32', null, '2018-07-24 17:10:32', null);
INSERT INTO `wfl_project_status_log` VALUES ('5', '3', '1', 'Proyecto enviado a diseño', '2018-07-02 00:00:00', '0', '2018-07-24 17:26:48', null, '2018-07-24 17:26:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('6', '3', '2', '', '2018-07-03 00:00:00', '0', '2018-07-24 17:27:39', null, '2018-07-24 17:27:39', null);
INSERT INTO `wfl_project_status_log` VALUES ('7', '3', '3', '', '2018-07-19 00:00:00', '0', '2018-07-24 17:29:49', null, '2018-07-24 17:29:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('8', '3', '5', '', '2018-07-20 00:00:00', '0', '2018-07-24 17:31:09', null, '2018-07-24 17:31:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('9', '3', '6', '', '2018-07-23 00:00:00', '0', '2018-07-24 17:33:38', null, '2018-07-24 17:33:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('10', '3', '8', 'Iniciando etapa de aprobacion', '2018-07-24 17:33:38', '0', '2018-07-24 17:33:38', null, '2018-07-24 17:33:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('11', '3', '9', 'Proyecto por enviar', '2018-07-24 17:33:38', '0', '2018-07-24 17:33:38', null, '2018-07-24 17:33:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('12', '4', '1', 'Proyecto enviado a diseño', '2018-07-25 00:00:00', '0', '2018-07-25 08:20:36', null, '2018-07-25 08:20:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('13', '5', '1', 'Proyecto enviado a diseño', '2018-07-25 00:00:00', '0', '2018-07-25 08:22:33', null, '2018-07-25 08:22:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('14', '6', '1', 'Proyecto enviado a diseño', '2018-04-26 00:00:00', '0', '2018-07-25 08:30:43', null, '2018-07-25 08:30:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('15', '7', '7', 'Proyecto creado', '2018-07-02 00:00:00', '0', '2018-07-25 10:21:51', null, '2018-07-25 10:21:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('16', '6', '2', '', '2018-04-24 00:00:00', '0', '2018-07-25 11:42:47', null, '2018-07-25 11:42:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('17', '6', '5', '', '2018-05-15 00:00:00', '0', '2018-07-25 11:44:06', null, '2018-07-25 11:44:06', null);
INSERT INTO `wfl_project_status_log` VALUES ('18', '8', '1', 'Proyecto enviado a diseño', '2018-07-21 00:00:00', '0', '2018-07-25 11:53:18', null, '2018-07-25 11:53:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('19', '8', '2', '', '2018-07-23 00:00:00', '0', '2018-07-25 11:53:53', null, '2018-07-25 11:53:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('20', '6', '6', '', '2018-05-18 00:00:00', '0', '2018-07-25 11:57:38', null, '2018-07-25 11:57:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('21', '6', '8', 'Iniciando etapa de aprobacion', '2018-07-25 11:57:38', '0', '2018-07-25 11:57:38', null, '2018-07-25 11:57:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('22', '6', '9', 'Proyecto por enviar', '2018-07-25 11:57:38', '0', '2018-07-25 11:57:38', null, '2018-07-25 11:57:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('23', '2', '3', '', '2018-07-25 16:35:22', '0', '2018-07-25 16:35:23', null, '2018-07-25 16:35:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('24', '9', '1', 'Proyecto enviado a diseño', '2018-06-16 16:53:43', '0', '2018-07-25 16:53:43', null, '2018-07-25 16:53:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('25', '9', '2', '', '2018-06-18 16:54:34', '0', '2018-07-25 16:54:34', null, '2018-07-25 16:54:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('26', '9', '6', '', '2018-07-29 16:55:12', '0', '2018-07-25 16:55:12', null, '2018-07-25 16:55:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('27', '9', '8', 'Iniciando etapa de aprobacion', '2018-07-25 16:55:13', '0', '2018-07-25 16:55:13', null, '2018-07-25 16:55:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('28', '9', '9', 'Proyecto por enviar', '2018-07-25 16:55:14', '0', '2018-07-25 16:55:14', null, '2018-07-25 16:55:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('29', '2', '5', '', '2018-07-25 17:26:05', '0', '2018-07-25 17:26:05', null, '2018-07-25 17:26:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('30', '10', '1', 'Proyecto enviado a diseño', '2018-07-26 08:59:52', '0', '2018-07-26 08:59:52', null, '2018-07-26 08:59:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('31', '7', '1', 'Inicio de diseño del proyecto', '2018-07-26 09:07:50', '0', '2018-07-26 09:07:50', null, '2018-07-26 09:07:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('32', '7', '2', '', '2018-07-03 09:22:27', '0', '2018-07-26 09:22:27', null, '2018-07-26 09:22:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('33', '7', '3', '', '2018-07-17 09:22:41', '0', '2018-07-26 09:22:41', null, '2018-07-26 09:22:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('34', '7', '5', '', '2018-07-17 09:22:52', '0', '2018-07-26 09:22:52', null, '2018-07-26 09:22:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('35', '11', '7', 'Proyecto creado', '2018-06-16 10:20:24', '0', '2018-07-26 10:20:24', null, '2018-07-26 10:20:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('36', '11', '1', 'Inicio de diseño del proyecto', '2018-07-26 10:20:33', '0', '2018-07-26 10:20:33', null, '2018-07-26 10:20:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('37', '11', '2', '', '2018-07-18 10:21:46', '0', '2018-07-26 10:21:46', null, '2018-07-26 10:21:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('38', '11', '3', '', '2018-07-28 10:22:04', '0', '2018-07-26 10:22:04', null, '2018-07-26 10:22:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('39', '11', '5', '', '2018-06-29 10:22:20', '0', '2018-07-26 10:22:20', null, '2018-07-26 10:22:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('40', '11', '2', '', '2018-06-26 10:22:56', '0', '2018-07-26 10:22:56', null, '2018-07-26 10:22:56', null);
INSERT INTO `wfl_project_status_log` VALUES ('41', '11', '3', '', '2018-06-28 10:23:29', '0', '2018-07-26 10:23:29', null, '2018-07-26 10:23:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('42', '11', '2', '', '2018-06-16 10:24:03', '0', '2018-07-26 10:24:03', null, '2018-07-26 10:24:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('43', '11', '6', '', '2018-07-06 10:24:47', '0', '2018-07-26 10:24:47', null, '2018-07-26 10:24:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('44', '11', '8', 'Iniciando etapa de aprobacion', '2018-07-26 10:24:48', '0', '2018-07-26 10:24:48', null, '2018-07-26 10:24:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('45', '11', '9', 'Proyecto por enviar', '2018-07-26 10:24:49', '0', '2018-07-26 10:24:49', null, '2018-07-26 10:24:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('46', '12', '1', 'Proyecto enviado a diseño', '2018-07-16 10:28:05', '0', '2018-07-26 10:28:05', null, '2018-07-26 10:28:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('47', '12', '2', '', '2018-06-18 10:29:24', '0', '2018-07-26 10:29:24', null, '2018-07-26 10:29:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('48', '12', '3', '', '2018-07-02 10:29:41', '0', '2018-07-26 10:29:41', null, '2018-07-26 10:29:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('49', '12', '5', '', '2018-07-03 10:29:50', '0', '2018-07-26 10:29:50', null, '2018-07-26 10:29:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('50', '12', '6', '', '2018-07-04 10:31:04', '0', '2018-07-26 10:31:04', null, '2018-07-26 10:31:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('51', '12', '8', 'Iniciando etapa de aprobacion', '2018-07-26 10:31:05', '0', '2018-07-26 10:31:05', null, '2018-07-26 10:31:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('52', '12', '9', 'Proyecto por enviar', '2018-07-26 10:31:06', '0', '2018-07-26 10:31:06', null, '2018-07-26 10:31:06', null);
INSERT INTO `wfl_project_status_log` VALUES ('53', '13', '1', 'Proyecto enviado a diseño', '2018-07-26 10:38:49', '0', '2018-07-26 10:38:49', null, '2018-07-26 10:38:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('54', '13', '2', '', '2018-06-16 10:48:08', '0', '2018-07-26 10:48:08', null, '2018-07-26 10:48:08', null);
INSERT INTO `wfl_project_status_log` VALUES ('55', '13', '3', '', '2018-06-29 10:48:54', '0', '2018-07-26 10:48:54', null, '2018-07-26 10:48:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('56', '13', '2', '', '2018-06-18 10:49:09', '0', '2018-07-26 10:49:09', null, '2018-07-26 10:49:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('57', '13', '5', '', '2018-06-30 10:50:32', '0', '2018-07-26 10:50:32', null, '2018-07-26 10:50:32', null);
INSERT INTO `wfl_project_status_log` VALUES ('58', '13', '6', '', '2018-07-02 10:53:42', '0', '2018-07-26 10:53:42', null, '2018-07-26 10:53:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('59', '13', '8', 'Iniciando etapa de aprobacion', '2018-07-26 10:53:43', '0', '2018-07-26 10:53:43', null, '2018-07-26 10:53:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('60', '13', '9', 'Proyecto por enviar', '2018-07-26 10:53:44', '0', '2018-07-26 10:53:44', null, '2018-07-26 10:53:44', null);
INSERT INTO `wfl_project_status_log` VALUES ('61', '14', '1', 'Proyecto enviado a diseño', '2018-07-02 11:08:50', '0', '2018-07-26 11:08:50', null, '2018-07-26 11:08:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('62', '14', '2', '', '2018-07-03 11:10:19', '0', '2018-07-26 11:10:19', null, '2018-07-26 11:10:19', null);
INSERT INTO `wfl_project_status_log` VALUES ('63', '14', '3', '', '2018-07-07 11:10:58', '0', '2018-07-26 11:10:58', null, '2018-07-26 11:10:58', null);
INSERT INTO `wfl_project_status_log` VALUES ('64', '14', '5', '', '2018-07-07 11:11:34', '0', '2018-07-26 11:11:34', null, '2018-07-26 11:11:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('65', '9', '10', 'enviando a CRE', '2018-07-30 15:37:37', '0', '2018-07-30 15:37:37', null, '2018-07-30 15:37:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('66', '9', '14', 'El proyecto necesita ser reilustrado', '2018-07-30 15:50:21', '0', '2018-07-30 15:50:21', null, '2018-07-30 15:50:21', null);
INSERT INTO `wfl_project_status_log` VALUES ('67', '11', '10', 'proyecto enviado a CRE', '2018-07-30 15:52:57', '0', '2018-07-30 15:52:57', null, '2018-07-30 15:52:57', null);
INSERT INTO `wfl_project_status_log` VALUES ('68', '11', '14', 'rectificando ilustracion', '2018-07-30 16:20:01', '0', '2018-07-30 16:20:01', null, '2018-07-30 16:20:01', null);
INSERT INTO `wfl_project_status_log` VALUES ('69', '13', '10', 'proyecto enviado a CRE', '2018-07-30 16:23:45', '0', '2018-07-30 16:23:46', null, '2018-07-30 16:23:46', null);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_stakes_team_leader
-- ----------------------------

-- ----------------------------
-- Table structure for wfl_status_log_responsibles
-- ----------------------------
DROP TABLE IF EXISTS `wfl_status_log_responsibles`;
CREATE TABLE `wfl_status_log_responsibles` (
  `id_slr` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_log_id_slr` bigint(20) DEFAULT NULL,
  `responsible_id_slr` bigint(20) DEFAULT NULL,
  `deleted_slr` smallint(6) DEFAULT '0',
  `createdon_slr` datetime DEFAULT NULL,
  `createdby_slr` bigint(20) DEFAULT NULL,
  `editedon_slr` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_slr` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_slr`),
  KEY `fk_status_log_id_slr` (`status_log_id_slr`),
  KEY `fk_responsible_id_slr` (`responsible_id_slr`),
  CONSTRAINT `fk_responsible_id_slr` FOREIGN KEY (`responsible_id_slr`) REFERENCES `wfl_status_responsibles` (`id_sre`),
  CONSTRAINT `fk_status_log_id_slr` FOREIGN KEY (`status_log_id_slr`) REFERENCES `wfl_project_status_log` (`id_psl`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_status_log_responsibles
-- ----------------------------
INSERT INTO `wfl_status_log_responsibles` VALUES ('1', '1', '8', '0', '2018-07-24 17:01:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('2', '2', '8', '0', '2018-07-24 17:03:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('3', '3', '5', '0', '2018-07-24 17:05:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('4', '4', '4', '0', '2018-07-24 17:10:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('5', '5', '8', '0', '2018-07-24 17:26:48', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('6', '6', '3', '0', '2018-07-24 17:27:39', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('7', '7', '6', '0', '2018-07-24 17:29:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('8', '8', '7', '0', '2018-07-24 17:31:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('9', '9', '8', '0', '2018-07-24 17:33:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('10', '10', '10', '0', '2018-07-24 17:33:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('11', '11', '10', '0', '2018-07-24 17:33:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('12', '12', '1', '0', '2018-07-25 08:20:36', null, '2018-07-26 10:20:04', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('13', '13', '1', '0', '2018-07-25 08:22:33', null, '2018-07-26 10:49:04', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('14', '14', '8', '0', '2018-07-25 08:30:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('15', '15', '9', '0', '2018-07-25 10:21:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('16', '16', '3', '0', '2018-07-25 11:42:47', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('17', '17', '7', '0', '2018-07-25 11:44:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('18', '18', '8', '0', '2018-07-25 11:53:18', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('19', '19', '4', '0', '2018-07-25 11:53:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('20', '20', '8', '0', '2018-07-25 11:57:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('21', '21', '10', '0', '2018-07-25 11:57:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('22', '22', '10', '0', '2018-07-25 11:57:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('23', '23', '6', '0', '2018-07-25 16:35:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('24', '24', '1', '0', '2018-07-25 16:53:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('25', '25', '3', '0', '2018-07-25 16:54:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('26', '26', '8', '0', '2018-07-25 16:55:12', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('27', '27', '10', '0', '2018-07-25 16:55:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('28', '28', '10', '0', '2018-07-25 16:55:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('29', '29', '7', '0', '2018-07-25 17:26:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('30', '30', '1', '0', '2018-07-26 08:59:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('31', '31', '1', '0', '2018-07-26 09:07:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('32', '32', '3', '0', '2018-07-26 09:22:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('33', '33', '6', '0', '2018-07-26 09:22:41', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('34', '34', '7', '0', '2018-07-26 09:22:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('35', '35', '9', '0', '2018-07-26 10:20:24', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('36', '36', '1', '0', '2018-07-26 10:20:33', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('37', '37', '3', '0', '2018-07-26 10:21:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('38', '38', '6', '0', '2018-07-26 10:22:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('39', '39', '7', '0', '2018-07-26 10:22:20', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('40', '41', '6', '0', '2018-07-26 10:23:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('41', '43', '8', '0', '2018-07-26 10:24:47', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('42', '44', '10', '0', '2018-07-26 10:24:48', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('43', '45', '10', '0', '2018-07-26 10:24:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('44', '46', '1', '0', '2018-07-26 10:28:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('45', '47', '3', '0', '2018-07-26 10:29:24', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('46', '48', '6', '0', '2018-07-26 10:29:41', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('47', '49', '7', '0', '2018-07-26 10:29:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('48', '50', '8', '0', '2018-07-26 10:31:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('49', '51', '10', '0', '2018-07-26 10:31:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('50', '52', '10', '0', '2018-07-26 10:31:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('51', '53', '1', '0', '2018-07-26 10:38:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('52', '54', '3', '0', '2018-07-26 10:48:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('53', '55', '6', '0', '2018-07-26 10:48:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('54', '57', '7', '0', '2018-07-26 10:50:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('55', '58', '8', '0', '2018-07-26 10:53:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('56', '59', '10', '0', '2018-07-26 10:53:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('57', '60', '10', '0', '2018-07-26 10:53:44', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('58', '61', '1', '0', '2018-07-26 11:08:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('59', '62', '4', '0', '2018-07-26 11:10:19', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('60', '63', '6', '0', '2018-07-26 11:10:58', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('61', '64', '7', '0', '2018-07-26 11:11:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('62', '65', '12', '0', '2018-07-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('63', '67', '12', '0', '2018-07-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('64', '68', '10', '0', '2018-07-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('65', '69', '12', '0', '2018-07-30 00:00:00', null, '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for wfl_status_responsibles
-- ----------------------------
DROP TABLE IF EXISTS `wfl_status_responsibles`;
CREATE TABLE `wfl_status_responsibles` (
  `id_sre` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id_sre` bigint(20) DEFAULT NULL,
  `status_id_sre` bigint(20) DEFAULT NULL,
  `deleted_sre` smallint(6) DEFAULT '0',
  `createdon_sre` datetime DEFAULT NULL,
  `createdby_sre` bigint(20) DEFAULT NULL,
  `editedon_sre` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_sre` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_sre`),
  KEY `fk_user_id_sre` (`user_id_sre`),
  KEY `fk_status_id_sre` (`status_id_sre`),
  CONSTRAINT `fk_status_id_sre` FOREIGN KEY (`status_id_sre`) REFERENCES `wfl_project_status` (`id_pst`),
  CONSTRAINT `fk_user_id_sre` FOREIGN KEY (`user_id_sre`) REFERENCES `sec_users` (`id_usr`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_status_responsibles
-- ----------------------------
INSERT INTO `wfl_status_responsibles` VALUES ('1', '7', '1', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('2', '6', '1', '1', null, null, '2018-07-25 14:53:52', null);
INSERT INTO `wfl_status_responsibles` VALUES ('3', '5', '2', '0', null, null, '2018-07-19 11:02:42', null);
INSERT INTO `wfl_status_responsibles` VALUES ('4', '3', '2', '0', null, null, '2018-07-19 11:01:08', null);
INSERT INTO `wfl_status_responsibles` VALUES ('5', '4', '2', '0', null, null, '2018-07-19 11:01:08', null);
INSERT INTO `wfl_status_responsibles` VALUES ('6', '8', '3', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('7', '9', '5', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('8', '2', '6', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('9', '2', '7', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('10', '2', '8', '0', null, null, '2018-07-23 10:26:12', null);
INSERT INTO `wfl_status_responsibles` VALUES ('11', '2', '9', '0', null, null, '2018-07-23 10:26:12', null);
INSERT INTO `wfl_status_responsibles` VALUES ('12', '2', '10', '0', null, null, '2018-07-23 10:26:13', null);
INSERT INTO `wfl_status_responsibles` VALUES ('13', '2', '11', '0', null, null, '2018-07-23 10:26:13', null);
INSERT INTO `wfl_status_responsibles` VALUES ('14', '2', '12', '0', null, null, '2018-07-23 10:26:13', null);

-- ----------------------------
-- Procedure structure for project_count_all
-- ----------------------------
DROP PROCEDURE IF EXISTS `project_count_all`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `project_count_all`(
	statusId VARCHAR(15)
)
begin
SET @statusIdFilter1 = IF(statusId = '','1=1',CONCAT(" status_id_psl in (",statusId,") "));
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_pro in (",statusId,") "));
SET @queryy = CONCAT(
"
select count(id_pro) as total from
(
	SELECT
		wfl_projects.*,
		status_name_pst,
		order_pst,
		status_log_manual_entry_date.manual_entry_date_psl,
		status_log_manual_entry_date.responsible,
		id_psl
	FROM
		wfl_projects
	LEFT JOIN (
		select * from (
        	select
        		project_id_psl project_id, max(manual_entry_date_psl) max_date
        		from (
        			SELECT
        				project_id_psl,
        				manual_entry_date_psl
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			GROUP BY id_psl
        		) statusLogAndResponsible group by project_id_psl
        ) as max_entry
        LEFT JOIN (
        			SELECT
        				id_psl,
        				project_id_psl,
        				log_detail_psl,
        				manual_entry_date_psl,
        				GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
        			LEFT JOIN sec_users on id_usr = user_id_sre
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	WHERE
		",@statusIdFilter2,"
) projects;");
PREPARE stmt FROM @queryy;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for project_get_all
-- ----------------------------
DROP PROCEDURE IF EXISTS `project_get_all`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `project_get_all`(
	statusId VARCHAR(15),
	limitt int(3),
    offsett int(3),
    orderBy VARCHAR(40),
    orderType VARCHAR(4)
)
begin
SET @statusIdFilter1 = IF(statusId = '','1=1',CONCAT(" status_id_psl in (",statusId,") "));
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_pro in (",statusId,") "));
SET @queryy = CONCAT(
"
select * from
(
	SELECT
		wfl_projects.*,
		status_name_pst,
		order_pst,
		status_log_manual_entry_date.manual_entry_date_psl,
		status_log_manual_entry_date.responsible,
		id_psl
	FROM
		wfl_projects
	LEFT JOIN (
		select * from (
        	select
        		project_id_psl project_id, max(manual_entry_date_psl) max_date
        		from (
        			SELECT
        				project_id_psl,
        				manual_entry_date_psl
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			GROUP BY id_psl
        		) statusLogAndResponsible group by project_id_psl
        ) as max_entry
        LEFT JOIN (
        			SELECT
        				id_psl,
        				project_id_psl,
        				log_detail_psl,
        				manual_entry_date_psl,
        				GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
        			LEFT JOIN sec_users on id_usr = user_id_sre
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	WHERE
		",@statusIdFilter2,"
) projects
ORDER BY order_pst ASC, ",orderBy," ",orderType," LIMIT ",limitt," offset ",offsett,";
;");
PREPARE stmt FROM @queryy;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for project_search
-- ----------------------------
DROP PROCEDURE IF EXISTS `project_search`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `project_search`(
	statusId VARCHAR(15),
	limitt int(3),
	offsett int(3),
	orderBy VARCHAR(40),
	orderType VARCHAR(4),
	textToSearh VARCHAR(20)
)
begin
SET @statusIdFilter1 = IF(statusId = '','1=1',CONCAT(" status_id_psl in (",statusId,") "));
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_pro in (",statusId,") "));
SET @queryy = CONCAT(
"
select * from
(
	SELECT
		wfl_projects.*,
		status_name_pst,
		order_pst,
		status_log_manual_entry_date.manual_entry_date_psl,
		status_log_manual_entry_date.responsible,
		id_psl
	FROM
		wfl_projects
	LEFT JOIN (
		select * from (
        	select
        		project_id_psl project_id, max(manual_entry_date_psl) max_date
        		from (
        			SELECT
        				project_id_psl,
        				manual_entry_date_psl
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			GROUP BY id_psl
        		) statusLogAndResponsible group by project_id_psl
        ) as max_entry
        LEFT JOIN (
        			SELECT
        				id_psl,
        				project_id_psl,
        				log_detail_psl,
        				manual_entry_date_psl,
        				GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
        			LEFT JOIN sec_users on id_usr = user_id_sre
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	WHERE
		",@statusIdFilter2,"
) projects
where
	code_pro LIKE '%",textToSearh,"%'
	or address_pro LIKE '%",textToSearh,"%'
ORDER BY order_pst ASC, ",orderBy," ",orderType," LIMIT ",limitt," offset ",offsett,";
;");
PREPARE stmt FROM @queryy;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for project_search_total_count
-- ----------------------------
DROP PROCEDURE IF EXISTS `project_search_total_count`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `project_search_total_count`(
	statusId VARCHAR(15),
	textToSearh VARCHAR(20)
)
begin
SET @statusIdFilter1 = IF(statusId = '','1=1',CONCAT(" status_id_psl in (",statusId,") "));
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_pro in (",statusId,") "));
SET @queryy = CONCAT(
"
select count(id_pro) as total from
(
	SELECT
		wfl_projects.*,
		status_name_pst,
		order_pst,
		status_log_manual_entry_date.manual_entry_date_psl,
		status_log_manual_entry_date.responsible,
		id_psl
	FROM
		wfl_projects
	LEFT JOIN (
		select * from (
        	select
        		project_id_psl project_id, max(manual_entry_date_psl) max_date
        		from (
        			SELECT
        				project_id_psl,
        				manual_entry_date_psl
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			GROUP BY id_psl
        		) statusLogAndResponsible group by project_id_psl
        ) as max_entry
        LEFT JOIN (
        			SELECT
        				id_psl,
        				project_id_psl,
        				log_detail_psl,
        				manual_entry_date_psl,
        				GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
        			LEFT JOIN sec_users on id_usr = user_id_sre
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	WHERE
		",@statusIdFilter2,"
) projects
where
	code_pro LIKE '%",textToSearh,"%'
	or address_pro LIKE '%",textToSearh,"%'
;");
PREPARE stmt FROM @queryy;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
end
;;
DELIMITER ;
