/*
Navicat MySQL Data Transfer

Source Server         : LOCAL_HOST
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : serebo

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-09-12 13:34:32
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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sec_features
-- ----------------------------
INSERT INTO `sec_features` VALUES ('1', 'Edit user', 'user_edit', 'fa fa-edit', 'panel/User/edit', 'Edit users', '6', '9', '0', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('2', 'Cancelado', 'Approvement_canceled', 'fa fa-table', 'panel/Approvement/canceled', 'Proyecto cancelado', '13', '35', '1', '0', null, null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('3', 'Lista', 'user_index', 'fa fa-table', 'panel/User', '', '6', '7', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('4', 'Add user', 'user_add', 'fa fa-user-plus', 'panel/User/add', 'Add users', '6', '8', '0', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('5', 'Etapa de diseño', 'design', 'glyphicon glyphicon-pencil', '#', '', null, '16', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('6', 'Usuarios', 'users', 'fa fa-users', '#', '', null, '6', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('7', 'My profile', 'user_profile', 'fa fa-user', 'panel/User/myProfile', 'User\'s profile', null, '3', '0', '0', null, null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('8', 'Proyectos', 'project', 'fa fa-folder', '#', '', null, '11', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('9', 'Roles', 'role', 'fa fa-user', '#', '', null, '64', '1', '0', null, null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('10', 'Estaqueado', 'design_stakes', 'fa fa-users', 'panel/Design/stakesTeam', '', '5', '18', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('11', 'Digitalizacion', 'design_digitization', 'fa fa-laptop', 'panel/Design/digitization', '', '5', '19', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('12', 'Dibujo', 'design_drawing', 'fa fa-pencil-square-o', 'panel/Design/drawing', '', '5', '20', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('13', 'Etapa de aprobacion', 'Approvement', 'fa fa-check', '#', '', null, '31', '1', '0', null, null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('14', 'Aprobado', 'Approvement_approved', 'fa fa-check', 'panel/Approvement/approved', 'El proyecto ha sido aprobado', '13', '34', '1', '0', null, null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('15', 'Por enviar a cree', 'Approvement_pending_to_send', 'fa fa-clock-o', 'panel/Approvement/readyToSend', 'Listo para ser enviado a CREE', '13', '32', '1', '0', null, null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('16', 'Cronograma', 'design_schedule', 'fa fa-clock-o', 'panel/Design/schedule', '', '5', '21', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('17', 'Lista', 'design_index', 'glyphicon glyphicon-pencil', 'panel/Design', '', '5', '17', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('18', 'Home', 'home', 'fa fa-home', 'panel/Home', '', null, '1', '1', '0', null, null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('19', 'Permisos', 'permission', 'fa fa-lock', 'panel/Permission', 'Add, edit, and handle user permissions', null, '69', '1', '0', null, null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('20', 'Lista', 'role_index', 'fa fa-table', 'panel/Role', 'Role list', '9', '65', '1', '0', null, null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('21', 'Add role', 'role_add', 'fa fa-plus', '#', 'Add role form', '9', '66', '0', '0', null, null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('22', 'Edit role', 'role_edit', 'fa fa-edit', '#', 'Edit role form', '9', '67', '0', '0', null, null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('23', 'Dashboard', 'dashboard_index', 'fa fa-dashboard', 'panel/Dashboard', 'User dashboard', null, '2', '1', '0', null, null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('24', 'Lista', 'project_index', 'fa fa-table', 'panel/Project', 'Projects', '8', '12', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('25', 'Crear proyecto', 'project_add', 'fa fa-plus', 'panel/Project/add', 'Add new project', '8', '13', '1', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('26', 'Edit project', 'project_edit', 'fa fa-pencil', 'panel/Project/edit', 'Edit project', '8', '14', '0', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('27', 'Delete project', 'delete_project', 'fa fa-times', 'panel/Project/delete', 'Delete project', '8', '15', '0', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('28', 'Delete user', 'delete_user', 'fa fa-times', 'panel/User/delete', 'Delete user', '6', '10', '0', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('29', 'Delete role', 'delete_role', 'fa fa-times', 'panel/Role/delete', 'Delete role', '9', '68', '0', '0', null, null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('30', 'State management', 'project_status_management', 'fa fa-table', 'panel/ProjectStatus/stateManagement', 'Project state management', null, '5', '0', '0', null, null, '2018-09-06 11:41:58', null);
INSERT INTO `sec_features` VALUES ('31', 'Estados', 'project_status_index', 'fa fa-table', 'panel/ProjectStatus', 'Project status', null, '60', '1', '0', null, null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('32', 'Enviado a cree', 'approvement_sent_to_cree', 'fa fa-send', 'panel/Approvement/alreadySent', 'El proyecto ha sido enviado a CREE', '13', '33', '1', '0', null, null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('33', 'Rectificar diseño', 'rectify_design', 'glyphicon glyphicon-refresh', '#', '', '5', '22', '1', '0', null, null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('34', 'Estaqueado(RD)', 'rectify_design_stakes', 'fa fa-users', 'panel/RectifyDesign/stakesTeam', '', '33', '24', '1', '0', '2018-07-20 13:59:00', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('35', 'Digitalizacion(RD)', 'rectify_design_digitization', 'fa fa-laptop', 'panel/RectifyDesign/digitization', '', '33', '25', '1', '0', '2018-07-20 14:01:58', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('36', 'Dibujo(RD)', 'rectify_design_drawing', 'fa fa-pencil', 'panel/RectifyDesign/drawing', '', '33', '26', '1', '0', '2018-07-20 14:02:52', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('37', 'Rectificar ilustracion', 'rectify_illustration', 'glyphicon glyphicon-refresh', '#', '', '5', '27', '1', '0', '2018-07-20 14:14:42', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('38', 'Digitalizacion(RI)', 'rectify_illustration_digitization', 'fa fa-laptop', 'panel/RectifyIllustration/digitization', '', '37', '29', '1', '0', '2018-07-20 14:18:27', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('39', 'Dibujo(RI)', 'rectify_illustration_drawing', 'fa fa-pencil', 'panel/RectifyIllustration/drawing', '', '37', '30', '1', '0', '2018-07-20 14:20:03', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('40', 'Lista', 'rectify_design_index', 'fa fa-table', 'panel/RectifyDesign', '', '33', '23', '1', '0', '2018-07-31 11:00:54', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('41', 'Lista', 'rectify_illustration_index', 'fa fa-table', 'panel/RectifyIllustration', '', '37', '28', '1', '0', '2018-07-31 11:01:58', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('42', 'Actualizar historico', 'project_update_history', '#', '#', 'Permite actualizar la fecha del historico del proyecto', null, '4', '0', '0', '2018-08-07 12:09:44', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('43', 'Almacen', 'warehouse', 'fa fa-table', '#', '', null, '36', '1', '0', '2018-08-09 10:13:29', null, '2018-09-05 12:20:26', '1');
INSERT INTO `sec_features` VALUES ('44', 'Por grabar', 'warehouse_index', 'fa fa-table', 'panel/Warehouse', '', '43', '37', '1', '0', '2018-08-09 10:14:36', null, '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('45', 'Materiales grabados', 'warehouse_record_building_materials', 'fa fa-table', 'panel/Warehouse/recordBuildingMaterials', '', '43', '38', '1', '0', '2018-08-09 11:01:59', null, '2018-09-05 12:20:26', '1');
INSERT INTO `sec_features` VALUES ('46', 'Materiales retirados de CRE', 'warehouse_get_materials', 'fa fa-table', 'panel/Warehouse/getMaterials', '', '43', '39', '1', '0', '2018-08-09 11:05:20', null, '2018-09-05 12:20:26', '1');
INSERT INTO `sec_features` VALUES ('47', 'Materiales puestos en Obra', 'warehouse_deliver_materials', 'fa fa-table', 'panel/Warehouse/deliverMaterials', '', '43', '40', '1', '0', '2018-08-09 11:06:16', null, '2018-09-05 12:20:26', '1');
INSERT INTO `sec_features` VALUES ('48', 'Por asignar', '#', 'fa fa-table', '#', '', null, '61', '1', '0', '2018-08-10 17:22:16', null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('49', 'Lista', 'project_status_ready_to_assign', 'fa fa-table', 'panel/ProjectStatus/readyToAssign', '', '48', '62', '1', '0', '2018-08-13 09:51:25', null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('50', 'Asignar', 'project_status_assign_project', 'fa fa-table', 'panel/ProjectStatus/assignProject', '', '48', '63', '0', '0', '2018-08-13 09:52:31', null, '2018-09-05 12:19:28', null);
INSERT INTO `sec_features` VALUES ('51', 'Construccion', 'building', 'fa fa-table', '#', '', null, '44', '1', '0', '2018-08-20 09:17:56', null, '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('52', 'Listo para iniciar', 'building_ready_to_start', 'fa fa-table', 'panel/Building/readyToStart', '', '51', '45', '1', '0', '2018-08-20 09:19:11', null, '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('53', 'En construccion', 'building_in_progress', 'fa fa-table', 'panel/Building/inProgress', '', '51', '46', '1', '0', '2018-08-20 09:20:02', null, '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('54', 'Detenido', 'building_stopped', 'fa fa-table', 'panel/Building/Stopped', '', '51', '47', '1', '0', '2018-08-20 09:21:55', null, '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('55', 'Pausado', 'building_paused', 'fa fa-table', 'panel/Building/Paused', '', '51', '48', '1', '0', '2018-08-20 09:22:53', null, '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('56', 'Completado', 'building_completed', 'fa fa-table', 'panel/Building/Completed', '', '51', '49', '1', '0', '2018-08-20 09:23:54', null, '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('57', 'Recep. de Materiales', 'warehouse_materials_reception', 'fa fa-table', 'panel/Warehouse/materialsReception', '', '43', '41', '1', '0', '2018-08-31 12:26:37', '1', '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('58', 'Devuelto a CRE', 'warehouse_return_materials', 'fa fa-table', 'panel/Warehouse/returnMaterials', '', '43', '43', '1', '0', '2018-08-31 14:00:52', '1', '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('59', 'Por enviar a cree', 'warehouse_request_materials_return', 'fa fa-table', 'panel/Warehouse/requestMaterialsReturn', '', '43', '42', '1', '0', '2018-08-31 15:07:14', '1', '2018-09-05 12:20:26', null);
INSERT INTO `sec_features` VALUES ('60', 'As built', 'building_as_built', 'fa fa-table', 'panel/Building/asBuilt', '', '51', '50', '1', '0', '2018-08-31 16:11:06', '1', '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('61', 'Recep. de Conciliacion', 'building_conciliation_reception', 'fa fa-table', 'panel/Building/conciliationReception', '', '51', '51', '1', '0', '2018-08-31 16:12:13', '1', '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('62', 'Envio de conciliacion', 'building_conciliation_shipment', 'fa fa-table', 'panel/Building/conciliationShipment', '', '51', '52', '1', '0', '2018-08-31 16:12:58', '1', '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('63', 'Recep. Orden dev.', 'building_cre_return_order', 'fa fa-table', 'panel/Building/creReturnOrder', '', '51', '53', '1', '0', '2018-08-31 16:13:50', '1', '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('64', 'Materi. enviados a CRE', 'building_project_return_materials', 'fa fa-table', 'panel/Building/projectReturnMaterials', '', '51', '54', '1', '0', '2018-08-31 16:15:08', '1', '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('65', 'Gestion de pago', 'payment_management', 'fa fa-table', '#', '', null, '55', '1', '0', '2018-09-05 12:13:46', '1', '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('66', 'Ordenes de pago', 'payment_management_index', 'fa fa-table', 'panel/PaymentManagement', '', '65', '56', '1', '0', '2018-09-05 12:14:42', '1', '2018-09-05 12:24:42', '1');
INSERT INTO `sec_features` VALUES ('67', 'Registrar orden de pago', 'payment_management_add', 'fa fa-table', 'panel/PaymentManagement/createPaymentOrder', '', '65', '57', '1', '0', '2018-09-05 12:16:25', '1', '2018-09-05 12:25:53', '1');
INSERT INTO `sec_features` VALUES ('68', 'Registrar envio de factura', 'payment_management_send_invoice_to_cre', 'fa fa-table', 'panel/PaymentManagement/sendInvoiceToCRE', '', '65', '58', '0', '0', '2018-09-05 12:18:17', '1', '2018-09-05 12:20:39', null);
INSERT INTO `sec_features` VALUES ('69', 'Confirmacion de pago', 'payment_management_confirm_payment_settled', 'fa fa-table', 'panel/PaymentManagement/confirmPaymentSettled', '', '65', '59', '0', '0', '2018-09-05 12:19:20', '1', '2018-09-05 12:20:39', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=1543 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
INSERT INTO `sec_permissions` VALUES ('512', '6', '5', '1', '2018-07-19 18:31:13', null, '2018-08-01 14:31:49', null);
INSERT INTO `sec_permissions` VALUES ('513', '6', '10', '1', '2018-07-19 18:31:13', null, '2018-08-01 14:31:49', null);
INSERT INTO `sec_permissions` VALUES ('514', '6', '11', '1', '2018-07-19 18:31:13', null, '2018-08-01 14:31:49', null);
INSERT INTO `sec_permissions` VALUES ('515', '6', '12', '1', '2018-07-19 18:31:13', null, '2018-08-01 14:31:49', null);
INSERT INTO `sec_permissions` VALUES ('516', '6', '16', '1', '2018-07-19 18:31:13', null, '2018-08-01 14:31:49', null);
INSERT INTO `sec_permissions` VALUES ('517', '6', '17', '1', '2018-07-19 18:31:13', null, '2018-08-01 14:31:49', null);
INSERT INTO `sec_permissions` VALUES ('518', '6', '30', '1', '2018-07-19 18:31:13', null, '2018-08-01 14:31:49', null);
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
INSERT INTO `sec_permissions` VALUES ('694', '1', '1', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('695', '1', '2', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('696', '1', '3', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('697', '1', '4', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('698', '1', '5', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('699', '1', '6', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('700', '1', '7', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('701', '1', '8', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('702', '1', '9', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('703', '1', '10', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('704', '1', '11', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('705', '1', '12', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('706', '1', '13', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('707', '1', '14', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('708', '1', '15', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('709', '1', '16', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('710', '1', '17', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('711', '1', '18', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('712', '1', '19', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('713', '1', '20', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('714', '1', '21', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('715', '1', '22', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('716', '1', '23', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('717', '1', '24', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('718', '1', '25', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('719', '1', '26', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('720', '1', '27', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('721', '1', '28', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('722', '1', '29', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('723', '1', '30', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('724', '1', '31', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('725', '1', '32', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('726', '1', '33', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('727', '1', '34', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('728', '1', '35', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('729', '1', '36', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('730', '1', '37', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('731', '1', '38', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('732', '1', '39', '1', '2018-07-20 20:20:08', null, '2018-07-31 11:47:06', null);
INSERT INTO `sec_permissions` VALUES ('733', '5', '2', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('734', '5', '5', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('735', '5', '8', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('736', '5', '10', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('737', '5', '11', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('738', '5', '12', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('739', '5', '13', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('740', '5', '14', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('741', '5', '15', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('742', '5', '16', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('743', '5', '17', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('744', '5', '24', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('745', '5', '25', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('746', '5', '26', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('747', '5', '27', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('748', '5', '30', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('749', '5', '32', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('750', '5', '33', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('751', '5', '34', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('752', '5', '35', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('753', '5', '36', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('754', '5', '37', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('755', '5', '38', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('756', '5', '39', '1', '2018-07-24 20:24:00', null, '2018-08-01 14:31:25', null);
INSERT INTO `sec_permissions` VALUES ('757', '1', '1', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('758', '1', '2', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('759', '1', '3', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('760', '1', '4', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('761', '1', '6', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('762', '1', '7', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('763', '1', '8', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('764', '1', '9', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('765', '1', '10', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('766', '1', '11', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('767', '1', '12', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('768', '1', '13', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('769', '1', '14', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('770', '1', '15', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('771', '1', '16', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('772', '1', '17', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('773', '1', '18', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('774', '1', '19', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('775', '1', '20', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('776', '1', '21', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('777', '1', '22', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('778', '1', '23', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('779', '1', '24', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('780', '1', '25', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('781', '1', '26', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('782', '1', '27', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('783', '1', '28', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('784', '1', '29', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('785', '1', '30', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('786', '1', '31', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('787', '1', '32', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('788', '1', '40', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('789', '1', '41', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('790', '1', '5', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('791', '1', '33', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('792', '1', '37', '1', '2018-07-31 11:47:06', null, '2018-08-01 12:09:10', null);
INSERT INTO `sec_permissions` VALUES ('793', '1', '1', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('794', '1', '2', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('795', '1', '3', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('796', '1', '4', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('797', '1', '5', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('798', '1', '6', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('799', '1', '7', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('800', '1', '8', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('801', '1', '9', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('802', '1', '10', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('803', '1', '11', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('804', '1', '12', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('805', '1', '13', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('806', '1', '14', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('807', '1', '15', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('808', '1', '16', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('809', '1', '17', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('810', '1', '18', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('811', '1', '19', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('812', '1', '20', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('813', '1', '21', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('814', '1', '22', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('815', '1', '23', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('816', '1', '24', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('817', '1', '25', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('818', '1', '26', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('819', '1', '27', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('820', '1', '28', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('821', '1', '29', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('822', '1', '30', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('823', '1', '31', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('824', '1', '32', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('825', '1', '33', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('826', '1', '34', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('827', '1', '35', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('828', '1', '36', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('829', '1', '37', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('830', '1', '38', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('831', '1', '39', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('832', '1', '40', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('833', '1', '41', '1', '2018-08-01 12:09:10', null, '2018-08-07 12:10:03', null);
INSERT INTO `sec_permissions` VALUES ('834', '5', '2', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('835', '5', '5', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('836', '5', '8', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('837', '5', '10', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('838', '5', '11', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('839', '5', '12', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('840', '5', '13', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('841', '5', '14', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('842', '5', '15', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('843', '5', '16', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('844', '5', '17', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('845', '5', '24', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('846', '5', '25', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('847', '5', '26', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('848', '5', '27', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('849', '5', '30', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('850', '5', '32', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('851', '5', '33', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('852', '5', '34', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('853', '5', '35', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('854', '5', '36', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('855', '5', '37', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('856', '5', '38', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('857', '5', '39', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('858', '5', '40', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('859', '5', '41', '1', '2018-08-01 14:31:25', null, '2018-08-01 14:31:45', null);
INSERT INTO `sec_permissions` VALUES ('860', '5', '2', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('861', '5', '5', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('862', '5', '7', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('863', '5', '8', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('864', '5', '10', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('865', '5', '11', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('866', '5', '12', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('867', '5', '13', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('868', '5', '14', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('869', '5', '15', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('870', '5', '16', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('871', '5', '17', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('872', '5', '24', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('873', '5', '25', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('874', '5', '26', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('875', '5', '27', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('876', '5', '30', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('877', '5', '32', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('878', '5', '33', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('879', '5', '34', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('880', '5', '35', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('881', '5', '36', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('882', '5', '37', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('883', '5', '38', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('884', '5', '39', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('885', '5', '40', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('886', '5', '41', '0', '2018-08-01 14:31:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('887', '6', '7', '0', '2018-08-01 14:31:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('888', '6', '10', '0', '2018-08-01 14:31:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('889', '6', '11', '0', '2018-08-01 14:31:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('890', '6', '12', '0', '2018-08-01 14:31:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('891', '6', '16', '0', '2018-08-01 14:31:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('892', '6', '17', '0', '2018-08-01 14:31:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('893', '6', '30', '0', '2018-08-01 14:31:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('894', '6', '5', '0', '2018-08-01 14:31:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('895', '1', '1', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('896', '1', '2', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('897', '1', '3', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('898', '1', '4', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('899', '1', '5', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('900', '1', '6', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('901', '1', '7', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('902', '1', '8', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('903', '1', '9', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('904', '1', '10', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('905', '1', '11', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('906', '1', '12', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('907', '1', '13', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('908', '1', '14', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('909', '1', '15', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('910', '1', '16', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('911', '1', '17', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('912', '1', '18', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('913', '1', '19', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('914', '1', '20', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('915', '1', '21', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('916', '1', '22', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('917', '1', '23', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('918', '1', '24', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('919', '1', '25', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('920', '1', '26', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('921', '1', '27', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('922', '1', '28', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('923', '1', '29', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('924', '1', '30', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('925', '1', '31', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('926', '1', '32', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('927', '1', '33', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('928', '1', '34', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('929', '1', '35', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('930', '1', '36', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('931', '1', '37', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('932', '1', '38', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('933', '1', '39', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('934', '1', '40', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('935', '1', '41', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('936', '1', '42', '1', '2018-08-07 12:10:03', null, '2018-08-09 10:17:29', null);
INSERT INTO `sec_permissions` VALUES ('937', '1', '1', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('938', '1', '2', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('939', '1', '3', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('940', '1', '4', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('941', '1', '5', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('942', '1', '6', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('943', '1', '7', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('944', '1', '8', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('945', '1', '9', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('946', '1', '10', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('947', '1', '11', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('948', '1', '12', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('949', '1', '13', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('950', '1', '14', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('951', '1', '15', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('952', '1', '16', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('953', '1', '17', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('954', '1', '18', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('955', '1', '19', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('956', '1', '20', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('957', '1', '21', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('958', '1', '22', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('959', '1', '23', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('960', '1', '24', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('961', '1', '25', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('962', '1', '26', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('963', '1', '27', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('964', '1', '28', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('965', '1', '29', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('966', '1', '30', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('967', '1', '31', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('968', '1', '32', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('969', '1', '33', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('970', '1', '34', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('971', '1', '35', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('972', '1', '36', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('973', '1', '37', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('974', '1', '38', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('975', '1', '39', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('976', '1', '40', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('977', '1', '41', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('978', '1', '42', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('979', '1', '43', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('980', '1', '44', '1', '2018-08-09 10:17:29', null, '2018-08-09 11:07:02', null);
INSERT INTO `sec_permissions` VALUES ('981', '1', '1', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('982', '1', '2', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('983', '1', '3', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('984', '1', '4', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('985', '1', '5', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('986', '1', '6', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('987', '1', '7', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('988', '1', '8', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('989', '1', '9', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('990', '1', '10', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('991', '1', '11', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('992', '1', '12', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('993', '1', '13', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('994', '1', '14', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('995', '1', '15', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('996', '1', '16', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('997', '1', '17', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('998', '1', '18', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('999', '1', '19', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1000', '1', '20', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1001', '1', '21', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1002', '1', '22', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1003', '1', '23', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1004', '1', '24', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1005', '1', '25', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1006', '1', '26', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1007', '1', '27', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1008', '1', '28', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1009', '1', '29', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1010', '1', '30', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1011', '1', '31', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1012', '1', '32', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1013', '1', '33', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1014', '1', '34', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1015', '1', '35', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1016', '1', '36', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1017', '1', '37', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1018', '1', '38', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1019', '1', '39', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1020', '1', '40', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1021', '1', '41', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1022', '1', '42', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1023', '1', '43', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1024', '1', '44', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1025', '1', '45', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1026', '1', '46', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1027', '1', '47', '1', '2018-08-09 11:07:02', null, '2018-08-10 17:23:16', null);
INSERT INTO `sec_permissions` VALUES ('1028', '1', '1', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1029', '1', '2', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1030', '1', '3', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1031', '1', '4', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1032', '1', '5', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1033', '1', '6', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1034', '1', '7', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1035', '1', '8', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1036', '1', '9', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1037', '1', '10', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1038', '1', '11', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1039', '1', '12', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1040', '1', '13', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1041', '1', '14', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1042', '1', '15', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1043', '1', '16', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1044', '1', '17', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1045', '1', '18', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1046', '1', '19', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1047', '1', '20', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1048', '1', '21', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1049', '1', '22', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1050', '1', '23', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1051', '1', '24', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1052', '1', '25', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1053', '1', '26', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1054', '1', '27', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1055', '1', '28', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1056', '1', '29', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1057', '1', '30', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1058', '1', '31', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1059', '1', '32', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1060', '1', '33', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1061', '1', '34', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1062', '1', '35', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1063', '1', '36', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1064', '1', '37', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1065', '1', '38', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1066', '1', '39', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1067', '1', '40', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1068', '1', '41', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1069', '1', '42', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1070', '1', '43', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1071', '1', '44', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1072', '1', '45', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1073', '1', '46', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1074', '1', '47', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1075', '1', '48', '1', '2018-08-10 17:23:17', null, '2018-08-13 09:52:37', null);
INSERT INTO `sec_permissions` VALUES ('1076', '1', '1', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1077', '1', '2', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1078', '1', '3', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1079', '1', '4', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1080', '1', '5', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1081', '1', '6', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1082', '1', '7', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1083', '1', '8', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1084', '1', '9', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1085', '1', '10', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1086', '1', '11', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1087', '1', '12', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1088', '1', '13', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1089', '1', '14', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1090', '1', '15', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1091', '1', '16', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1092', '1', '17', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1093', '1', '18', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1094', '1', '19', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1095', '1', '20', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1096', '1', '21', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1097', '1', '22', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1098', '1', '23', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1099', '1', '24', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1100', '1', '25', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1101', '1', '26', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1102', '1', '27', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1103', '1', '28', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1104', '1', '29', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1105', '1', '30', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1106', '1', '31', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1107', '1', '32', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1108', '1', '33', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1109', '1', '34', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1110', '1', '35', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1111', '1', '36', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1112', '1', '37', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1113', '1', '38', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1114', '1', '39', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1115', '1', '40', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1116', '1', '41', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1117', '1', '42', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1118', '1', '43', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1119', '1', '44', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1120', '1', '45', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1121', '1', '46', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1122', '1', '47', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1123', '1', '48', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1124', '1', '49', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1125', '1', '50', '1', '2018-08-13 09:52:37', null, '2018-08-20 09:28:29', null);
INSERT INTO `sec_permissions` VALUES ('1126', '1', '1', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1127', '1', '2', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1128', '1', '3', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1129', '1', '4', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1130', '1', '5', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1131', '1', '6', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1132', '1', '7', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1133', '1', '8', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1134', '1', '9', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1135', '1', '10', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1136', '1', '11', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1137', '1', '12', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1138', '1', '13', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1139', '1', '14', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1140', '1', '15', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1141', '1', '16', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1142', '1', '17', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1143', '1', '18', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1144', '1', '19', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1145', '1', '20', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1146', '1', '21', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1147', '1', '22', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1148', '1', '23', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1149', '1', '24', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1150', '1', '25', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1151', '1', '26', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1152', '1', '27', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1153', '1', '28', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1154', '1', '29', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1155', '1', '30', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1156', '1', '31', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1157', '1', '32', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1158', '1', '33', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1159', '1', '34', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1160', '1', '35', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1161', '1', '36', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1162', '1', '37', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1163', '1', '38', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1164', '1', '39', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1165', '1', '40', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1166', '1', '41', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1167', '1', '42', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1168', '1', '43', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1169', '1', '44', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1170', '1', '45', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1171', '1', '46', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1172', '1', '47', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1173', '1', '48', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1174', '1', '49', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1175', '1', '50', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1176', '1', '51', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1177', '1', '52', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1178', '1', '53', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1179', '1', '54', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1180', '1', '55', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1181', '1', '56', '1', '2018-08-20 09:28:29', null, '2018-08-31 12:27:06', null);
INSERT INTO `sec_permissions` VALUES ('1182', '1', '1', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1183', '1', '2', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1184', '1', '3', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1185', '1', '4', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1186', '1', '5', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1187', '1', '6', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1188', '1', '7', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1189', '1', '8', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1190', '1', '9', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1191', '1', '10', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1192', '1', '11', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1193', '1', '12', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1194', '1', '13', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1195', '1', '14', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1196', '1', '15', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1197', '1', '16', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1198', '1', '17', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1199', '1', '18', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1200', '1', '19', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1201', '1', '20', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1202', '1', '21', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1203', '1', '22', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1204', '1', '23', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1205', '1', '24', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1206', '1', '25', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1207', '1', '26', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1208', '1', '27', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1209', '1', '28', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1210', '1', '29', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1211', '1', '30', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1212', '1', '31', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1213', '1', '32', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1214', '1', '33', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1215', '1', '34', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1216', '1', '35', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1217', '1', '36', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1218', '1', '37', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1219', '1', '38', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1220', '1', '39', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1221', '1', '40', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1222', '1', '41', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1223', '1', '42', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1224', '1', '43', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1225', '1', '44', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1226', '1', '45', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1227', '1', '46', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1228', '1', '47', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1229', '1', '48', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1230', '1', '49', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1231', '1', '50', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1232', '1', '51', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1233', '1', '52', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1234', '1', '53', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1235', '1', '54', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1236', '1', '55', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1237', '1', '56', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1238', '1', '57', '1', '2018-08-31 12:27:06', null, '2018-08-31 14:01:00', null);
INSERT INTO `sec_permissions` VALUES ('1239', '1', '1', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1240', '1', '2', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1241', '1', '3', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1242', '1', '4', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1243', '1', '5', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1244', '1', '6', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1245', '1', '7', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1246', '1', '8', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1247', '1', '9', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1248', '1', '10', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1249', '1', '11', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1250', '1', '12', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1251', '1', '13', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1252', '1', '14', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1253', '1', '15', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1254', '1', '16', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1255', '1', '17', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1256', '1', '18', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1257', '1', '19', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1258', '1', '20', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1259', '1', '21', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1260', '1', '22', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1261', '1', '23', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1262', '1', '24', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1263', '1', '25', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1264', '1', '26', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1265', '1', '27', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1266', '1', '28', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1267', '1', '29', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1268', '1', '30', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1269', '1', '31', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1270', '1', '32', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1271', '1', '33', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1272', '1', '34', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1273', '1', '35', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1274', '1', '36', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1275', '1', '37', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1276', '1', '38', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1277', '1', '39', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1278', '1', '40', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1279', '1', '41', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1280', '1', '42', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1281', '1', '43', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1282', '1', '44', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1283', '1', '45', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1284', '1', '46', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1285', '1', '47', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1286', '1', '48', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1287', '1', '49', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1288', '1', '50', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1289', '1', '51', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1290', '1', '52', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1291', '1', '53', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1292', '1', '54', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1293', '1', '55', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1294', '1', '56', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1295', '1', '57', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1296', '1', '58', '1', '2018-08-31 14:01:00', null, '2018-08-31 15:07:22', null);
INSERT INTO `sec_permissions` VALUES ('1297', '1', '1', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1298', '1', '2', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1299', '1', '3', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1300', '1', '4', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1301', '1', '5', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1302', '1', '6', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1303', '1', '7', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1304', '1', '8', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1305', '1', '9', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1306', '1', '10', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1307', '1', '11', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1308', '1', '12', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1309', '1', '13', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1310', '1', '14', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1311', '1', '15', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1312', '1', '16', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1313', '1', '17', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1314', '1', '18', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1315', '1', '19', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1316', '1', '20', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1317', '1', '21', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1318', '1', '22', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1319', '1', '23', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1320', '1', '24', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1321', '1', '25', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1322', '1', '26', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1323', '1', '27', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1324', '1', '28', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1325', '1', '29', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1326', '1', '30', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1327', '1', '31', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1328', '1', '32', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1329', '1', '33', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1330', '1', '34', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1331', '1', '35', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1332', '1', '36', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1333', '1', '37', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1334', '1', '38', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1335', '1', '39', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1336', '1', '40', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1337', '1', '41', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1338', '1', '42', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1339', '1', '43', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1340', '1', '44', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1341', '1', '45', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1342', '1', '46', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1343', '1', '47', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1344', '1', '48', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1345', '1', '49', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1346', '1', '50', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1347', '1', '51', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1348', '1', '52', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1349', '1', '53', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1350', '1', '54', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1351', '1', '55', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1352', '1', '56', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1353', '1', '57', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1354', '1', '58', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1355', '1', '59', '1', '2018-08-31 15:07:22', null, '2018-08-31 16:15:55', null);
INSERT INTO `sec_permissions` VALUES ('1356', '1', '1', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1357', '1', '2', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1358', '1', '3', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1359', '1', '4', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1360', '1', '5', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1361', '1', '6', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1362', '1', '7', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1363', '1', '8', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1364', '1', '9', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1365', '1', '10', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1366', '1', '11', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1367', '1', '12', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1368', '1', '13', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1369', '1', '14', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1370', '1', '15', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1371', '1', '16', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1372', '1', '17', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1373', '1', '18', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1374', '1', '19', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1375', '1', '20', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1376', '1', '21', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1377', '1', '22', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1378', '1', '23', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1379', '1', '24', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1380', '1', '25', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1381', '1', '26', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1382', '1', '27', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1383', '1', '28', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1384', '1', '29', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1385', '1', '30', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1386', '1', '31', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1387', '1', '32', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1388', '1', '33', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1389', '1', '34', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1390', '1', '35', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1391', '1', '36', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1392', '1', '37', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1393', '1', '38', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1394', '1', '39', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1395', '1', '40', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1396', '1', '41', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1397', '1', '42', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1398', '1', '43', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1399', '1', '44', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1400', '1', '45', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1401', '1', '46', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1402', '1', '47', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1403', '1', '48', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1404', '1', '49', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1405', '1', '50', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1406', '1', '51', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1407', '1', '52', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1408', '1', '53', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1409', '1', '54', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1410', '1', '55', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1411', '1', '56', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1412', '1', '57', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1413', '1', '58', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1414', '1', '59', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1415', '1', '60', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1416', '1', '61', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1417', '1', '62', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1418', '1', '63', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1419', '1', '64', '1', '2018-08-31 16:15:55', null, '2018-09-05 12:19:43', null);
INSERT INTO `sec_permissions` VALUES ('1420', '7', '7', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1421', '7', '18', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1422', '7', '23', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1423', '7', '43', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1424', '7', '44', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1425', '7', '45', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1426', '7', '46', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1427', '7', '47', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1428', '7', '57', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1429', '7', '58', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1430', '7', '59', '0', '2018-08-31 16:48:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1431', '1', '1', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1432', '1', '2', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1433', '1', '3', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1434', '1', '4', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1435', '1', '5', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1436', '1', '6', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1437', '1', '7', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1438', '1', '8', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1439', '1', '9', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1440', '1', '10', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1441', '1', '11', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1442', '1', '12', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1443', '1', '13', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1444', '1', '14', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1445', '1', '15', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1446', '1', '16', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1447', '1', '17', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1448', '1', '18', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1449', '1', '19', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1450', '1', '20', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1451', '1', '21', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1452', '1', '22', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1453', '1', '23', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1454', '1', '24', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1455', '1', '25', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1456', '1', '26', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1457', '1', '27', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1458', '1', '28', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1459', '1', '29', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1460', '1', '30', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1461', '1', '31', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1462', '1', '32', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1463', '1', '33', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1464', '1', '34', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1465', '1', '35', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1466', '1', '36', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1467', '1', '37', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1468', '1', '38', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1469', '1', '39', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1470', '1', '40', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1471', '1', '41', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1472', '1', '42', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1473', '1', '43', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1474', '1', '44', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1475', '1', '45', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1476', '1', '46', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1477', '1', '47', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1478', '1', '48', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1479', '1', '49', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1480', '1', '50', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1481', '1', '51', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1482', '1', '52', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1483', '1', '53', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1484', '1', '54', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1485', '1', '55', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1486', '1', '56', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1487', '1', '57', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1488', '1', '58', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1489', '1', '59', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1490', '1', '60', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1491', '1', '61', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1492', '1', '62', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1493', '1', '63', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1494', '1', '64', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1495', '1', '65', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1496', '1', '66', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1497', '1', '67', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1498', '1', '68', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1499', '1', '69', '0', '2018-09-05 12:19:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1500', '8', '7', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1501', '8', '18', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1502', '8', '23', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1503', '8', '51', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1504', '8', '52', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1505', '8', '53', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1506', '8', '54', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1507', '8', '55', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1508', '8', '56', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1509', '8', '60', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1510', '8', '61', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1511', '8', '62', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1512', '8', '63', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1513', '8', '64', '1', '2018-09-06 11:37:22', null, '2018-09-06 11:38:19', null);
INSERT INTO `sec_permissions` VALUES ('1514', '8', '7', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1515', '8', '18', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1516', '8', '23', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1517', '8', '51', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1518', '8', '52', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1519', '8', '53', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1520', '8', '54', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1521', '8', '55', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1522', '8', '56', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1523', '8', '60', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1524', '8', '61', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1525', '8', '62', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1526', '8', '63', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1527', '8', '64', '1', '2018-09-06 11:38:19', null, '2018-09-06 11:42:06', null);
INSERT INTO `sec_permissions` VALUES ('1528', '8', '7', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1529', '8', '18', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1530', '8', '23', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1531', '8', '30', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1532', '8', '51', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1533', '8', '52', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1534', '8', '53', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1535', '8', '54', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1536', '8', '55', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1537', '8', '56', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1538', '8', '60', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1539', '8', '61', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1540', '8', '62', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1541', '8', '63', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);
INSERT INTO `sec_permissions` VALUES ('1542', '8', '64', '0', '2018-09-06 11:42:06', null, '0000-00-00 00:00:00', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sec_roles
-- ----------------------------
INSERT INTO `sec_roles` VALUES ('1', 'Super admin', 'super_admin', '0', null, null, '2018-05-28 15:38:31', null);
INSERT INTO `sec_roles` VALUES ('2', 'Admin', 'admin', '0', null, null, '2018-05-28 15:38:34', null);
INSERT INTO `sec_roles` VALUES ('3', 'User', 'user', '0', null, null, '2018-06-06 11:49:32', null);
INSERT INTO `sec_roles` VALUES ('4', 'Guestttt', 'guest', '1', '2018-06-01 11:46:04', null, '2018-06-05 12:28:35', null);
INSERT INTO `sec_roles` VALUES ('5', 'Proyectista', 'projector', '0', '2018-07-19 11:08:40', null, '2018-07-20 13:28:00', null);
INSERT INTO `sec_roles` VALUES ('6', 'Diseñador', 'designer', '0', '2018-07-19 11:08:53', null, '2018-07-20 13:28:03', null);
INSERT INTO `sec_roles` VALUES ('7', 'Responsable de Almac', 'warehouse_manag', '0', '2018-08-10 09:52:05', null, '2018-08-10 09:52:05', null);
INSERT INTO `sec_roles` VALUES ('8', 'Fiscal', 'fiscal', '0', '2018-08-13 11:18:58', null, '2018-08-13 11:18:58', null);
INSERT INTO `sec_roles` VALUES ('9', 'Builder', 'builder', '0', '2018-08-13 11:20:11', null, '2018-08-13 11:20:11', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
INSERT INTO `sec_userroles` VALUES ('33', '10', '3', '0', '2018-08-10 09:53:07', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('34', '10', '7', '0', '2018-08-10 09:53:07', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('35', '11', '3', '1', '2018-08-13 11:19:33', '1', '2018-08-16 17:43:42', null);
INSERT INTO `sec_userroles` VALUES ('36', '11', '8', '1', '2018-08-13 11:19:33', '1', '2018-08-16 17:43:42', null);
INSERT INTO `sec_userroles` VALUES ('37', '12', '3', '1', '2018-08-13 11:20:46', '1', '2018-08-16 17:43:12', null);
INSERT INTO `sec_userroles` VALUES ('38', '12', '9', '1', '2018-08-13 11:20:46', '1', '2018-08-16 17:43:12', null);
INSERT INTO `sec_userroles` VALUES ('39', '12', '3', '1', '2018-08-16 17:43:12', '1', '2018-08-16 17:44:16', null);
INSERT INTO `sec_userroles` VALUES ('40', '12', '9', '1', '2018-08-16 17:43:12', '1', '2018-08-16 17:44:16', null);
INSERT INTO `sec_userroles` VALUES ('41', '11', '3', '1', '2018-08-16 17:43:43', '1', '2018-09-06 11:35:52', null);
INSERT INTO `sec_userroles` VALUES ('42', '11', '8', '1', '2018-08-16 17:43:43', '1', '2018-09-06 11:35:52', null);
INSERT INTO `sec_userroles` VALUES ('43', '12', '3', '0', '2018-08-16 17:44:16', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('44', '12', '9', '0', '2018-08-16 17:44:16', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('45', '13', '3', '0', '2018-08-16 17:45:34', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('46', '13', '9', '0', '2018-08-16 17:45:34', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('47', '14', '3', '0', '2018-08-16 17:46:11', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('48', '14', '9', '0', '2018-08-16 17:46:11', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('49', '15', '3', '0', '2018-08-16 17:47:04', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('50', '15', '8', '0', '2018-08-16 17:47:04', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('51', '16', '3', '0', '2018-08-16 17:47:45', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('52', '16', '9', '0', '2018-08-16 17:47:45', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('53', '17', '3', '0', '2018-08-16 17:49:39', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('54', '17', '9', '0', '2018-08-16 17:49:39', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('55', '18', '3', '0', '2018-08-16 17:50:16', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('56', '18', '9', '0', '2018-08-16 17:50:16', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('57', '19', '3', '0', '2018-08-16 17:51:18', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('58', '19', '8', '0', '2018-08-16 17:51:18', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('59', '20', '3', '0', '2018-08-16 17:52:01', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('60', '20', '9', '0', '2018-08-16 17:52:01', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('61', '21', '3', '0', '2018-08-16 17:52:38', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('62', '21', '9', '0', '2018-08-16 17:52:38', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('63', '11', '3', '0', '2018-09-06 11:35:52', '1', '0000-00-00 00:00:00', null);
INSERT INTO `sec_userroles` VALUES ('64', '11', '8', '0', '2018-09-06 11:35:52', '1', '0000-00-00 00:00:00', null);

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
  `supervising_user_usr` bigint(20) DEFAULT NULL,
  `deleted_usr` smallint(6) DEFAULT '0',
  `createdon_usr` datetime DEFAULT NULL,
  `createdby_usr` bigint(20) DEFAULT NULL,
  `editedon_usr` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_usr` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_usr`),
  UNIQUE KEY `UQ_sec_users_id_usr` (`id_usr`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sec_users
-- ----------------------------
INSERT INTO `sec_users` VALUES ('1', 'jair', 'cussy', 'jair@twiiti.com', null, null, '$2y$10$biHC1c85bbcHmNmRvKc1ZumAcCYkU2.q.oMzCX2r9aPpYX0HbVd46', null, '', '', '1', '0', '', null, '0', '2018-04-26 00:32:39', null, '2018-04-26 00:32:39', null);
INSERT INTO `sec_users` VALUES ('2', 'Mario', 'Aguilera', 'marioa@mailinator.com', null, null, '$2y$10$3QicFM3Htj1iAKhIUmHv2ulIOB0k.SXmcZkCRbDOLvYVZoNBInoZe', null, '', '', '1', '0', '', null, '0', '2018-05-13 21:47:16', null, '2018-07-19 11:11:43', null);
INSERT INTO `sec_users` VALUES ('3', 'Dandy', 'Coca', 'nuser@mailinator.com', null, null, '$2y$10$r.eAisul1hyGSXgurkWJjemFA7yxkVcg28lu75DBBgCu6o.W0c0vW', null, '', '', '1', '0', '', null, '0', '2018-05-28 10:32:52', null, '2018-07-19 11:01:45', null);
INSERT INTO `sec_users` VALUES ('4', 'Miguel', 'Flores', 'nuser2@mailinator.com', null, null, '$2y$10$c8Jgx3up2nF9n523UoXHyeRWU5ZbL9L1EWxIiGHrADXIFa9QJXE2S', null, '', '', '1', '0', '', null, '0', '2018-05-28 10:34:28', null, '2018-07-19 11:01:49', null);
INSERT INTO `sec_users` VALUES ('5', 'Rider', 'Cortez', 'tuser@mailinator.com', null, null, '$2y$10$42XsIiB5gRBPcTlxoHm84eyWV9hNtvcPCVcXi1UAB09unAmQIZdIG', null, '', '', '1', '0', '', null, '0', '2018-05-30 09:44:40', null, '2018-07-24 18:03:50', null);
INSERT INTO `sec_users` VALUES ('6', 'Victor Hugo', 'Suarez', 'vsuarez@mailinator.com', null, null, '$2y$10$.2BkIdbwCJp369k1//gJ8.Gr0jq7ZnIkvm1X5QKbd9kUHNimtT8Ge', null, '', '', '1', '0', '', null, '0', '2018-05-30 09:58:30', null, '2018-07-24 16:33:31', null);
INSERT INTO `sec_users` VALUES ('7', 'Pablo', 'Mendoza', 'pablom@mailinator.com', null, null, '$2y$10$W/aBzKpgfucg1MZzh2rtuOKYboPu1dUBr8Ru0H4LiV.QkJSkejsOC', null, '', '', '1', '0', '', null, '0', '2018-06-04 12:15:00', null, '2018-07-19 11:14:44', null);
INSERT INTO `sec_users` VALUES ('8', 'Pepe', 'Vargas', 'digitalizador1@mailiantor.com', null, null, '$2y$10$CjDWq.RhG/LI5l5P77eEmelXD27P0RVc4GEyCojfqR96mXf/nrMfi', null, '', '', '1', '0', '', null, '0', '2018-07-17 17:36:07', null, '2018-07-19 11:05:34', null);
INSERT INTO `sec_users` VALUES ('9', 'Jose', 'Duran', 'dibujante1@mailinator.com', null, null, '$2y$10$iozfBGQg.Ib5nCkC6yKNx.5fs0euDukOBE3.8QyE3YpLdl3rN5C/.', null, '', '', '1', '0', '', null, '0', '2018-07-17 17:37:00', null, '2018-07-19 11:05:40', null);
INSERT INTO `sec_users` VALUES ('10', 'Elio', 'almacen', 'responsablea@mailinator.com', null, null, '$2y$10$9zwjWM2vfhXMI2MqVVz1OepmyOOQu.EuRg2nppXFuxonHOky0j5Ya', null, '', '', '1', '0', '', null, '0', '2018-08-10 09:53:07', null, '2018-08-10 10:11:17', null);
INSERT INTO `sec_users` VALUES ('11', 'Hilton', 'Alvarez', 'hiltona@mailinator.com', null, null, '$2y$10$3sCrOnIwD9WMUtXHsAHneOtnR0oYdtOYy4tmtvoLQGms4dVRdmDPO', null, '', '', '1', '0', '', null, '0', '2018-08-13 11:19:33', null, '2018-09-06 11:35:52', '1');
INSERT INTO `sec_users` VALUES ('12', 'Modesto', 'Salazar', 'modestos@mailinator.com', null, null, '$2y$10$TMmq2ptVA5l9aD3VDRdrT./nnMOgId6X2PxRzQD1BvtyyzUSCb272', null, '', '', '1', '0', '', '11', '0', '2018-08-13 11:20:45', null, '2018-08-17 10:29:20', null);
INSERT INTO `sec_users` VALUES ('13', 'Robert', 'Ortiz', 'roberto@mailinator.com', null, null, '$2y$10$RAQuwcek4FlVNz.AOwl1BuWsgLy5ZkkahtDhw6/OnyJ1zgcsjEEvC', null, '', '', '1', '0', '', '11', '0', '2018-08-16 17:45:34', null, '2018-08-17 10:29:20', null);
INSERT INTO `sec_users` VALUES ('14', 'Julio', 'Alba', 'julioa@mailinator.com', null, null, '$2y$10$c8uH8JmPcZR.dzUSiWZvB.OTU8dAAHJ5FYSJH0g2UmBQaShizdHny', null, '', '', '1', '0', '', '11', '0', '2018-08-16 17:46:11', null, '2018-08-17 10:29:20', null);
INSERT INTO `sec_users` VALUES ('15', 'Ruben', 'Aguirre', 'rubena@mailinator.com', null, null, '$2y$10$thlRFHH70uv7Sgd1zsgx9.CjZJdcD4djasyuETFcC5g2tPkXRJk4y', null, '', '', '1', '0', '', null, '0', '2018-08-16 17:47:04', null, '2018-08-16 17:47:04', null);
INSERT INTO `sec_users` VALUES ('16', 'Alejandro', 'Quispe', 'alejandroq@mailinator.com', null, null, '$2y$10$lfnoPT5C2FGQ3gZZehtMGOkCkfwtPjN.DO9lPch6gbrb3p9uh41b6', null, '', '', '1', '0', '', '15', '0', '2018-08-16 17:47:45', null, '2018-08-17 10:29:39', null);
INSERT INTO `sec_users` VALUES ('17', 'Juan de Dios', 'Montero', 'juanm@mailinator.com', null, null, '$2y$10$FtnbPUf/m7ewdv5x.eJPpuc8R4jHEWIqRtPLa44FnLjcG690Jf79.', null, '', '', '1', '0', '', '15', '0', '2018-08-16 17:49:39', null, '2018-08-17 10:29:39', null);
INSERT INTO `sec_users` VALUES ('18', 'Gumercindo', 'Alba', 'gumercindoa@mailinator.com', null, null, '$2y$10$UNx7OovvX.ZFpKm83CExb.MEqr8e6kUk7wWpf3BR5kIvUr1pdCemq', null, '', '', '1', '0', '', '15', '0', '2018-08-16 17:50:16', null, '2018-08-17 10:29:39', null);
INSERT INTO `sec_users` VALUES ('19', 'Genaro', 'Montenegro', 'genarom@mailinator.com', null, null, '$2y$10$i.yuS0a0fGk4zIE4QfgpBeAUhRjWmkI5T9SGx0H6wginBUO94sdRK', null, '', '', '1', '0', '', null, '0', '2018-08-16 17:51:18', null, '2018-08-16 17:51:18', null);
INSERT INTO `sec_users` VALUES ('20', 'Juanito', 'Yuchina', 'juanitoy@mailinator.com', null, null, '$2y$10$2eE5bVXzmOPdwy9f88u4JeIuSGkD5qRehCuuWIvuWx94MVB4C/dkq', null, '', '', '1', '0', '', '19', '0', '2018-08-16 17:52:01', null, '2018-08-17 10:29:53', null);
INSERT INTO `sec_users` VALUES ('21', 'Robert', 'Quispe', 'robertq@mailinator.com', null, null, '$2y$10$EIY0cK1l.BxpQE5huMeiAed3rxDBSyUkQl0AzDbdYaGaRCQd3erse', null, '', '', '1', '0', '', '19', '0', '2018-08-16 17:52:37', null, '2018-08-17 10:29:53', null);

-- ----------------------------
-- Table structure for wfl_construction_assignments
-- ----------------------------
DROP TABLE IF EXISTS `wfl_construction_assignments`;
CREATE TABLE `wfl_construction_assignments` (
  `id_cas` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_log_id_cas` bigint(20) DEFAULT NULL,
  `start_date_cas` datetime DEFAULT NULL,
  `end_date_cas` datetime DEFAULT NULL,
  `estimated_time_cas` smallint(3) DEFAULT NULL,
  `live_line_cas` smallint(1) DEFAULT NULL,
  `power_down_cas` smallint(1) DEFAULT NULL,
  `maneuver_cas` smallint(1) DEFAULT NULL,
  `deleted_cas` smallint(1) DEFAULT '0',
  `createdon_cas` datetime DEFAULT NULL,
  `createdby_cas` bigint(20) DEFAULT NULL,
  `editedon_cas` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_cas` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_cas`),
  KEY `fk_status_log_id_cas` (`status_log_id_cas`),
  CONSTRAINT `fk_status_log_id_cas` FOREIGN KEY (`status_log_id_cas`) REFERENCES `wfl_project_status_log` (`id_psl`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_construction_assignments
-- ----------------------------
INSERT INTO `wfl_construction_assignments` VALUES ('1', '70', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, '0', '2018-07-31 09:44:33', null, '2018-07-31 09:44:33', null);
INSERT INTO `wfl_construction_assignments` VALUES ('2', '71', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, '0', '2018-07-31 10:08:23', null, '2018-07-31 10:08:23', null);
INSERT INTO `wfl_construction_assignments` VALUES ('3', '72', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, '0', '2018-07-31 10:12:18', null, '2018-07-31 10:12:18', null);
INSERT INTO `wfl_construction_assignments` VALUES ('4', '74', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, '0', '2018-07-31 10:14:45', null, '2018-07-31 10:14:45', null);
INSERT INTO `wfl_construction_assignments` VALUES ('5', '75', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, '0', '2018-07-31 10:23:17', null, '2018-07-31 10:23:17', null);
INSERT INTO `wfl_construction_assignments` VALUES ('6', '76', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, '0', '2018-07-31 10:25:19', null, '2018-07-31 10:25:19', null);
INSERT INTO `wfl_construction_assignments` VALUES ('7', '204', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null, null, null, null, '0', '2018-07-31 11:56:51', null, '2018-07-31 11:56:51', null);
INSERT INTO `wfl_construction_assignments` VALUES ('8', '233', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '300', '400', null, null, '0', '2018-08-03 16:41:46', null, '2018-08-03 16:41:46', null);
INSERT INTO `wfl_construction_assignments` VALUES ('9', '235', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '300', '400', '500', null, '0', '2018-08-07 10:38:59', null, '2018-08-07 10:38:59', null);
INSERT INTO `wfl_construction_assignments` VALUES ('10', '244', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '300', '400', '700', null, '0', '2018-08-09 09:58:54', null, '2018-08-09 09:58:54', null);
INSERT INTO `wfl_construction_assignments` VALUES ('11', '248', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '300', '400', '700', '800', '0', '2018-08-10 11:52:12', null, '2018-08-10 11:52:12', null);
INSERT INTO `wfl_construction_assignments` VALUES ('15', '257', '2018-08-14 11:26:22', '2018-08-28 11:26:22', '5', '1', '1', '1', '0', '2018-08-14 11:26:23', null, '2018-08-14 11:26:23', null);
INSERT INTO `wfl_construction_assignments` VALUES ('16', '258', '2018-08-14 11:32:14', '2018-08-15 11:32:14', '5', '1', '1', '1', '0', '2018-08-14 11:32:14', null, '2018-08-14 11:32:14', null);
INSERT INTO `wfl_construction_assignments` VALUES ('17', '259', '2018-08-14 11:33:23', '2018-08-28 11:33:23', '3', '1', '1', '0', '0', '2018-08-14 11:33:23', null, '2018-08-14 11:33:23', null);
INSERT INTO `wfl_construction_assignments` VALUES ('18', '260', '2018-08-14 11:43:29', '2018-08-16 11:43:29', '2', '1', '1', '1', '0', '2018-08-14 11:43:30', null, '2018-08-14 11:43:30', null);
INSERT INTO `wfl_construction_assignments` VALUES ('19', '261', '2018-08-14 11:52:23', '2018-08-15 11:52:23', '1', '1', '1', '1', '0', '2018-08-14 11:52:23', null, '2018-08-14 11:52:23', null);
INSERT INTO `wfl_construction_assignments` VALUES ('20', '262', '2018-08-15 09:41:26', '2018-08-16 09:41:26', '2', '1', '0', '1', '0', '2018-08-15 09:41:29', null, '2018-08-15 09:41:29', null);
INSERT INTO `wfl_construction_assignments` VALUES ('21', '510', '2018-08-20 15:14:37', '2018-08-30 15:14:37', '10', '1', '1', '1', '0', '2018-08-20 15:14:37', null, '2018-08-20 15:14:37', null);
INSERT INTO `wfl_construction_assignments` VALUES ('22', '512', '2018-08-20 15:45:07', '2018-08-23 15:45:07', '3', '1', '1', '0', '0', '2018-08-20 15:45:07', null, '2018-08-20 15:45:07', null);
INSERT INTO `wfl_construction_assignments` VALUES ('23', '515', '2018-08-21 11:56:07', '2018-08-24 11:56:07', '3', '1', '1', '1', '0', '2018-08-21 11:56:08', null, '2018-08-21 11:56:08', null);
INSERT INTO `wfl_construction_assignments` VALUES ('24', '522', '2018-08-20 12:14:22', '2018-08-23 12:14:22', '3', '0', '0', '1', '0', '2018-08-22 12:14:22', null, '2018-08-22 12:14:22', null);
INSERT INTO `wfl_construction_assignments` VALUES ('25', '525', '2018-08-28 11:33:17', '2018-08-30 11:33:17', '2', '1', '1', '1', '0', '2018-08-28 11:33:18', '1', '2018-08-28 11:33:18', null);
INSERT INTO `wfl_construction_assignments` VALUES ('26', '533', '2018-08-30 12:10:47', '2018-09-01 12:10:47', '2', '0', '1', '0', '0', '2018-08-30 12:10:47', '1', '2018-08-30 12:10:47', null);
INSERT INTO `wfl_construction_assignments` VALUES ('27', '534', '2018-08-30 12:12:45', '2018-09-01 12:12:45', '2', '0', '1', '0', '0', '2018-08-30 12:12:45', '1', '2018-08-30 12:12:45', null);
INSERT INTO `wfl_construction_assignments` VALUES ('28', '539', '2018-08-21 14:50:20', '2018-08-24 14:50:20', '3', '1', '1', '1', '0', '2018-08-30 14:50:20', '1', '2018-08-30 14:50:20', null);
INSERT INTO `wfl_construction_assignments` VALUES ('29', '540', '2018-08-30 14:51:38', '2018-09-01 14:51:38', '2', '0', '1', '0', '0', '2018-08-30 14:51:38', '1', '2018-08-30 14:51:38', null);
INSERT INTO `wfl_construction_assignments` VALUES ('30', '541', '2018-08-31 10:16:09', '2018-09-06 10:16:09', '6', '1', '1', '0', '0', '2018-08-31 10:16:09', '1', '2018-08-31 10:16:09', null);
INSERT INTO `wfl_construction_assignments` VALUES ('31', '542', '2018-08-31 10:19:53', '2018-09-06 10:19:53', '6', '1', '1', '0', '0', '2018-08-31 10:19:53', '1', '2018-08-31 10:19:53', null);
INSERT INTO `wfl_construction_assignments` VALUES ('32', '543', '2018-08-31 10:23:41', '2018-09-06 10:23:41', '6', '1', '1', '0', '0', '2018-08-31 10:23:41', '1', '2018-08-31 10:23:41', null);
INSERT INTO `wfl_construction_assignments` VALUES ('33', '544', '2018-08-31 10:30:41', '2018-09-06 10:30:41', '6', '1', '1', '0', '0', '2018-08-31 10:30:41', '1', '2018-08-31 10:30:41', null);
INSERT INTO `wfl_construction_assignments` VALUES ('34', '547', '2018-08-31 10:36:07', '2018-09-06 10:36:07', '6', '1', '1', '0', '0', '2018-08-31 10:36:07', '1', '2018-08-31 10:36:07', null);
INSERT INTO `wfl_construction_assignments` VALUES ('35', '559', '2018-08-31 16:54:12', '2018-09-07 16:54:12', '7', '1', '0', '1', '0', '2018-08-31 16:54:12', '1', '2018-08-31 16:54:12', null);
INSERT INTO `wfl_construction_assignments` VALUES ('36', '567', '2018-08-31 10:05:54', '2018-09-06 10:05:54', '6', '1', '1', '0', '0', '2018-09-03 10:05:54', '1', '2018-09-03 10:05:54', null);

-- ----------------------------
-- Table structure for wfl_incidents
-- ----------------------------
DROP TABLE IF EXISTS `wfl_incidents`;
CREATE TABLE `wfl_incidents` (
  `id_inc` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_log_id_inc` bigint(20) DEFAULT NULL,
  `percentage_inc` smallint(3) DEFAULT NULL,
  `detail_inc` text,
  `manual_entry_date_inc` datetime DEFAULT NULL,
  `project_id_inc` bigint(20) DEFAULT NULL,
  `paused_inc` smallint(1) DEFAULT '0',
  `stopped_in` smallint(1) DEFAULT NULL,
  `deleted_inc` smallint(6) DEFAULT '0',
  `createdon_inc` datetime DEFAULT NULL,
  `createdby_inc` bigint(20) DEFAULT NULL,
  `editedon_inc` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_inc` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_inc`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_incidents
-- ----------------------------
INSERT INTO `wfl_incidents` VALUES ('1', '32', '20', 'primer incidente', '2018-08-24 10:15:30', '59', '0', null, '0', '2018-08-22 10:54:42', null, '2018-08-22 11:46:30', null);
INSERT INTO `wfl_incidents` VALUES ('2', '32', '25', 'segundo incidente', '2018-08-24 10:56:30', '59', '0', null, '0', '2018-08-22 10:56:30', null, '2018-08-22 11:05:09', null);
INSERT INTO `wfl_incidents` VALUES ('3', '30', '20', 'incidentes cuando se detuvo', '2018-08-22 11:23:03', '59', '0', null, '0', '2018-08-22 11:23:03', null, '2018-08-22 11:23:03', null);
INSERT INTO `wfl_incidents` VALUES ('4', '29', '10', 'problemas con los vecinos', '2018-08-22 11:51:03', '59', '0', null, '0', '2018-08-22 11:51:03', null, '2018-08-22 11:51:03', null);
INSERT INTO `wfl_incidents` VALUES ('5', '29', '10', 'se soluciono el problema con los vecinos', '2018-08-22 11:52:57', '59', '0', null, '0', '2018-08-22 11:52:57', null, '2018-08-22 11:52:57', null);
INSERT INTO `wfl_incidents` VALUES ('6', '31', '30', 'tercer incidente', '2018-08-23 12:10:08', '59', '0', null, '0', '2018-08-23 12:10:08', '1', '2018-08-23 12:10:08', null);
INSERT INTO `wfl_incidents` VALUES ('7', '21', '10', 'Los vencinos reportan demasiado ruido', '2018-08-31 10:36:55', '75', '0', null, '0', '2018-08-31 10:36:55', '1', '2018-08-31 10:36:55', null);
INSERT INTO `wfl_incidents` VALUES ('8', '21', '15', 'Se consiguieron mas permisos para satisfacer a los vecinos', '2018-08-31 10:37:40', '75', '0', null, '0', '2018-08-31 10:37:40', '1', '2018-08-31 10:37:40', null);
INSERT INTO `wfl_incidents` VALUES ('9', '29', '20', 'El tiempo esta causando retrasos en la construccion', '2018-08-31 10:40:53', '75', '0', null, '0', '2018-08-31 10:40:53', '1', '2018-08-31 10:40:53', null);
INSERT INTO `wfl_incidents` VALUES ('10', '29', '25', 'Parece que nos quedaremos sin materiales', '2018-08-31 10:47:41', '75', '0', null, '0', '2018-08-31 10:47:41', '1', '2018-08-31 10:47:41', null);
INSERT INTO `wfl_incidents` VALUES ('11', '31', '25', 'los materiales aun no estan disponibles', '2018-08-31 11:18:12', '75', '0', null, '0', '2018-08-31 11:18:12', '1', '2018-08-31 11:18:12', null);
INSERT INTO `wfl_incidents` VALUES ('12', '29', '0', 'No se puede ingresar a una propiedad', '2018-08-31 16:56:44', '8', '0', null, '0', '2018-08-31 16:56:44', '1', '2018-08-31 16:56:44', null);
INSERT INTO `wfl_incidents` VALUES ('13', '29', '5', 'Se consiguio un acuerdo con los vecinos', '2018-08-31 16:57:10', '8', '0', null, '0', '2018-08-31 16:57:10', '1', '2018-08-31 16:57:10', null);
INSERT INTO `wfl_incidents` VALUES ('14', '29', '25', 'No puedo seguir la construccion hasta que salgan ciertos permisos', '2018-09-05 10:44:07', '75', '0', null, '0', '2018-09-05 10:44:07', '1', '2018-09-05 10:44:07', null);
INSERT INTO `wfl_incidents` VALUES ('15', '31', '25', 'No se posible continuar con el proyecto, elaborare el as built.', '2018-09-05 11:03:53', '75', '0', null, '0', '2018-09-05 11:03:53', '1', '2018-09-05 11:03:53', null);
INSERT INTO `wfl_incidents` VALUES ('16', '29', '25', 'Se esta pausado el proyecto', '2018-09-05 11:14:39', '75', '0', null, '0', '2018-09-05 11:14:39', '1', '2018-09-05 11:14:39', null);
INSERT INTO `wfl_incidents` VALUES ('17', '29', '50', 'Estoy pausando el proyecto', '2018-09-06 11:44:45', '5', '0', null, '0', '2018-09-06 11:44:45', '11', '2018-09-06 11:44:45', null);
INSERT INTO `wfl_incidents` VALUES ('18', '31', '50', 'El proyecto sera descontinuado', '2018-09-06 11:45:13', '5', '0', null, '0', '2018-09-06 11:45:13', '11', '2018-09-06 11:45:13', null);

-- ----------------------------
-- Table structure for wfl_payment_orders
-- ----------------------------
DROP TABLE IF EXISTS `wfl_payment_orders`;
CREATE TABLE `wfl_payment_orders` (
  `id_pao` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_number_pao` varchar(20) DEFAULT NULL,
  `status_pao` smallint(1) DEFAULT NULL,
  `invoice_number_pao` varchar(30) DEFAULT NULL,
  `entry_date_pao` datetime DEFAULT NULL,
  `detail_pao` text,
  `deleted_pao` smallint(6) DEFAULT '0',
  `createdon_pao` datetime DEFAULT NULL,
  `createdby_pao` bigint(20) DEFAULT NULL,
  `editedon_pao` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_pao` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_pao`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_payment_orders
-- ----------------------------
INSERT INTO `wfl_payment_orders` VALUES ('1', '123456', '42', null, '2018-09-11 12:29:18', null, '1', '2018-09-11 12:29:18', '1', '2018-09-12 11:11:58', null);
INSERT INTO `wfl_payment_orders` VALUES ('2', '321645', '42', null, '2018-09-11 14:15:13', null, '1', '2018-09-11 14:15:13', '1', '2018-09-12 11:11:58', null);
INSERT INTO `wfl_payment_orders` VALUES ('3', '789456', '42', null, '2018-09-11 14:17:26', null, '1', '2018-09-11 14:17:26', '1', '2018-09-12 11:11:58', null);
INSERT INTO `wfl_payment_orders` VALUES ('4', '753159', '42', null, '2018-09-11 14:18:27', 'creacion de orden de pago - prueba 4', '1', '2018-09-11 14:18:27', '1', '2018-09-12 11:11:58', null);
INSERT INTO `wfl_payment_orders` VALUES ('5', '123456', '42', null, '2018-09-12 10:47:03', 'derecho de via - prueba 1', '1', '2018-09-12 10:47:03', '1', '2018-09-12 11:43:22', null);
INSERT INTO `wfl_payment_orders` VALUES ('6', '1234156', '1', null, '2018-09-12 12:13:54', '', '0', '2018-09-12 12:13:54', '1', '2018-09-12 12:13:54', null);

-- ----------------------------
-- Table structure for wfl_payment_orders_projects
-- ----------------------------
DROP TABLE IF EXISTS `wfl_payment_orders_projects`;
CREATE TABLE `wfl_payment_orders_projects` (
  `id_pop` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id_pop` bigint(20) DEFAULT NULL,
  `project_id_pop` bigint(20) DEFAULT NULL,
  `design_budget_pop` double(8,2) DEFAULT NULL,
  `transportation_budget_pop` double(8,2) DEFAULT NULL,
  `building_budget_pop` double(8,2) DEFAULT NULL,
  `live_line_budget_pop` double(8,2) DEFAULT NULL,
  `right_of_way_budget_pop` double(8,2) DEFAULT NULL,
  `deleted_pop` smallint(6) DEFAULT '0',
  `createdon_pop` datetime DEFAULT NULL,
  `createdby_pop` bigint(20) DEFAULT NULL,
  `editedon_pop` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_pop` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_pop`),
  KEY `fk_order_id_pop` (`order_id_pop`),
  KEY `fk_project_id_pop` (`project_id_pop`),
  CONSTRAINT `fk_order_id_pop` FOREIGN KEY (`order_id_pop`) REFERENCES `wfl_payment_orders` (`id_pao`),
  CONSTRAINT `fk_project_id_pop` FOREIGN KEY (`project_id_pop`) REFERENCES `wfl_projects` (`id_pro`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_payment_orders_projects
-- ----------------------------
INSERT INTO `wfl_payment_orders_projects` VALUES ('1', '4', '8', '500.00', '300.00', '400.00', '200.00', '0.00', '1', '2018-09-11 14:18:27', '1', '2018-09-12 10:34:15', null);
INSERT INTO `wfl_payment_orders_projects` VALUES ('2', '4', '53', '100.00', '300.00', '200.00', '400.00', '0.00', '1', '2018-09-11 14:18:28', '1', '2018-09-12 10:34:15', null);
INSERT INTO `wfl_payment_orders_projects` VALUES ('3', '5', '8', '500.00', '300.00', '400.00', '200.00', '600.00', '1', '2018-09-12 10:47:03', '1', '2018-09-12 11:43:30', null);
INSERT INTO `wfl_payment_orders_projects` VALUES ('4', '5', '53', '100.00', '300.00', '200.00', '400.00', '600.00', '1', '2018-09-12 10:47:04', '1', '2018-09-12 11:43:30', null);
INSERT INTO `wfl_payment_orders_projects` VALUES ('5', '6', '53', '100.00', '300.00', '200.00', '400.00', '800.00', '0', '2018-09-12 12:13:54', '1', '0000-00-00 00:00:00', null);
INSERT INTO `wfl_payment_orders_projects` VALUES ('6', '6', '8', '500.00', '300.00', '400.00', '200.00', '850.00', '0', '2018-09-12 12:13:55', '1', '0000-00-00 00:00:00', null);

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
  `management_by_pro` bigint(20) DEFAULT NULL,
  `quality_level_pro` smallint(6) DEFAULT NULL,
  `cre_design_completion_date_pro` datetime DEFAULT NULL,
  `cre_building_completion_date_pro` datetime DEFAULT NULL,
  `deleted_pro` smallint(1) DEFAULT '0',
  `createdon_pro` datetime DEFAULT NULL,
  `createdby_pro` bigint(20) DEFAULT NULL,
  `editedon_pro` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_pro` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_pro`),
  UNIQUE KEY `UQ_sec_roles_id_rol` (`id_pro`) USING BTREE,
  KEY `fk_status_pro` (`status_pro`),
  CONSTRAINT `fk_status_pro` FOREIGN KEY (`status_pro`) REFERENCES `wfl_project_status` (`id_pst`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of wfl_projects
-- ----------------------------
INSERT INTO `wfl_projects` VALUES ('1', 'RD.18.0292', '', '3', 'Comunidad El Cerrito', '2018-07-01 00:00:00', 'Herman Velasco Flores', '10', '2018-08-20 16:03:07', '2018-09-10 16:03:07', '80', '3.20', null, null, null, null, '0', '2018-07-24 17:01:05', null, '2018-08-15 09:45:30', null);
INSERT INTO `wfl_projects` VALUES ('2', 'RO.18.0161', '', '1', 'Equipetrol', '2018-07-18 00:00:00', 'GARCIA', '10', '2018-08-09 09:24:32', '2018-08-10 09:24:32', '3', '0.90', null, null, null, null, '0', '2018-07-24 17:03:09', null, '2018-08-04 09:40:42', null);
INSERT INTO `wfl_projects` VALUES ('3', 'RD.18.0211', '', '1', 'No sabemos', '2018-07-02 00:00:00', 'Prueba', '9', '2018-08-01 00:00:00', '2018-08-02 00:00:00', '4', '1.00', null, null, null, null, '1', '2018-07-24 17:26:48', null, '2018-07-25 16:50:20', null);
INSERT INTO `wfl_projects` VALUES ('4', 'RO.18.0166', '', '1', 'El Remanzo', '2018-07-25 00:00:00', 'Suarez', '22', '2018-08-14 09:56:41', '2018-08-15 09:56:41', '1', '0.00', null, null, null, null, '0', '2018-07-25 08:20:36', null, '2018-08-16 17:07:06', null);
INSERT INTO `wfl_projects` VALUES ('5', 'RO.18.0167', '', '1', 'El Remanzo', '2018-07-25 00:00:00', 'Suarez', '33', '2018-08-15 09:55:52', '2018-08-22 09:55:52', '1', '0.00', null, null, null, null, '0', '2018-07-25 08:22:33', null, '2018-09-06 11:45:55', '11');
INSERT INTO `wfl_projects` VALUES ('6', 'RD.18.0858', '', '1', 'Las Cabañas', '2018-04-26 00:00:00', 'Giles', '9', '2018-07-25 00:00:00', '2018-07-25 00:00:00', '64', '3.00', null, null, null, null, '1', '2018-07-25 08:30:43', null, '2018-07-25 16:45:34', null);
INSERT INTO `wfl_projects` VALUES ('7', 'RD.18.0210', '', '5', 'Puerto Suarez', '2018-07-02 00:00:00', 'Jose Luis Rodriguez', '10', '2018-08-10 11:51:44', '2018-08-16 11:51:44', '18', '0.72', null, null, null, null, '0', '2018-07-25 10:21:51', null, '2018-08-04 09:38:25', null);
INSERT INTO `wfl_projects` VALUES ('8', 'RA.18.1717', '', '3', 'Entre San Julian y San Ramon', '2018-07-21 00:00:00', 'Herman Velasco Flores', '40', '2018-08-10 15:14:53', '2018-08-15 15:14:53', '3', '1.00', null, null, null, null, '0', '2018-07-25 11:53:18', null, '2018-09-12 12:13:55', '1');
INSERT INTO `wfl_projects` VALUES ('9', 'RA.18.1218', '', '3', 'San Julian', '2018-06-16 16:53:43', 'Santos Cespedes', '22', '2018-07-25 16:55:12', '2018-07-25 16:55:12', '39', '1.50', null, null, null, null, '0', '2018-07-25 16:53:43', null, '2018-08-16 17:08:30', null);
INSERT INTO `wfl_projects` VALUES ('10', 'RD.19.0045', '', '4', 'Itambemi', '2018-07-26 08:59:52', 'LUJAN', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '16', '0.64', null, null, null, null, '0', '2018-07-26 08:59:52', null, '2018-07-26 08:59:52', null);
INSERT INTO `wfl_projects` VALUES ('11', 'RA.18.1219', '', '3', 'San Julian', '2018-06-16 10:20:24', 'Santos Cespedes', '22', '2018-08-01 10:24:47', '2018-08-20 10:24:47', '37', '1.48', null, null, null, null, '0', '2018-07-26 10:20:24', null, '2018-08-16 17:08:00', null);
INSERT INTO `wfl_projects` VALUES ('12', 'RA.18.1538', '', '3', 'San Juan de Lomerio', '2018-07-16 10:28:05', 'Santos Cespedes', '11', '2018-08-06 10:31:04', '2018-08-09 10:31:04', '6', '0.20', null, null, null, null, '0', '2018-07-26 10:28:05', null, '2018-09-10 11:33:01', '1');
INSERT INTO `wfl_projects` VALUES ('13', 'RA.18.1539', '', '3', 'San Ramon', '2018-07-26 10:38:49', 'Herman Velasco Flores', '11', '2018-08-13 10:53:42', '2018-08-14 10:53:42', '2', '0.10', null, null, null, null, '0', '2018-07-26 10:38:49', null, '2018-08-07 10:57:18', null);
INSERT INTO `wfl_projects` VALUES ('14', 'RA.18.1613', '', '3', 'San Ramon', '2018-07-02 11:08:50', 'Herman Velasco Flores', '9', '2018-08-13 11:15:49', '2018-08-15 11:15:49', '5', '0.16', null, null, null, null, '1', '2018-07-26 11:08:50', null, '2018-08-07 11:01:28', null);
INSERT INTO `wfl_projects` VALUES ('15', 'RA.18.1615', '', '3', 'Los Troncos', '2018-07-01 14:38:37', 'Santos Cespedes', '11', '2018-08-13 15:08:10', '2018-08-16 15:08:10', '7', '0.07', null, null, null, null, '0', '2018-07-26 14:38:37', null, '2018-08-07 11:01:38', null);
INSERT INTO `wfl_projects` VALUES ('16', 'RD.18.0286', '', '3', 'San Julian Urb. Cafeces', '2018-06-16 14:41:22', 'Herman Velasco Flores', '11', '2018-08-01 15:01:13', '2018-07-03 15:01:13', '8', '0.46', null, null, null, null, '0', '2018-07-26 14:41:22', null, '2018-08-07 11:08:12', null);
INSERT INTO `wfl_projects` VALUES ('17', 'RD.18.0282', '', '3', 'San Ramon', '2018-06-16 14:44:48', 'Herman Velasco Flores', '11', '2018-08-06 15:04:31', '2018-08-14 15:04:31', '22', '0.91', null, null, null, null, '0', '2018-07-26 14:44:48', null, '2018-08-07 11:04:07', null);
INSERT INTO `wfl_projects` VALUES ('18', 'RD.18.0283', '', '3', 'San Julian Urb. Cafeces', '2018-06-16 14:49:42', 'Herman Velasco Flores', '11', '2018-08-01 14:55:56', '2018-08-22 14:55:56', '48', '2.50', null, null, null, null, '0', '2018-07-26 14:49:42', null, '2018-08-07 11:11:34', null);
INSERT INTO `wfl_projects` VALUES ('19', 'R.18.0311', '', '5', 'Puerto Quijarro', '2018-07-02 15:24:50', 'Jose Luis Rodriguez', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '23', '0.74', null, null, null, null, '1', '2018-07-26 15:24:50', null, '2018-07-26 15:36:15', null);
INSERT INTO `wfl_projects` VALUES ('20', 'RD.18.0301', '', '5', 'Puerto Suarez', '2018-07-03 15:26:27', 'Jose Luis Rodriguez', '10', '2018-08-07 15:50:34', '2018-08-14 15:50:34', '23', '0.70', null, null, null, null, '0', '2018-07-26 15:26:27', null, '2018-08-04 09:37:55', null);
INSERT INTO `wfl_projects` VALUES ('21', 'RD.18.0300', '', '5', 'Puerto Quijarro', '2018-07-03 15:28:50', 'Jose Luis Rodriguez', '10', '2018-07-07 15:49:12', '2018-07-14 15:49:12', '22', '0.73', null, null, null, null, '0', '2018-07-26 15:28:50', null, '2018-08-04 09:36:12', null);
INSERT INTO `wfl_projects` VALUES ('22', 'RD.18.0309', '', '5', 'Puerto Quijarro', '2018-07-03 15:29:48', 'Jose Luis Rodriguez', '10', '2018-08-10 15:47:03', '2018-08-16 15:47:03', '18', '0.52', null, null, null, null, '0', '2018-07-26 15:29:48', null, '2018-08-04 09:36:35', null);
INSERT INTO `wfl_projects` VALUES ('23', 'RD.18.0312', '', '5', 'Puerto Suarez', '2018-07-02 15:31:03', 'Líder Rodriguez', '10', '2018-08-01 15:45:04', '2018-08-10 15:45:04', '30', '0.95', null, null, null, null, '0', '2018-07-26 15:31:03', null, '2018-08-04 09:36:51', null);
INSERT INTO `wfl_projects` VALUES ('24', 'RD.18.0211', '', '5', 'Puerto Suarez', '2018-07-02 15:32:17', 'Jose Luis Rodriguez', '10', '2018-08-01 15:43:01', '2018-08-13 15:43:01', '38', '1.25', null, null, null, null, '0', '2018-07-26 15:32:17', null, '2018-08-04 09:37:15', null);
INSERT INTO `wfl_projects` VALUES ('25', 'RD.18.0311', '', '5', 'Puerto Quijarro', '2018-07-02 15:37:33', 'Jose Luis Rodriguez', '10', '2018-08-07 15:41:15', '2018-07-14 15:41:15', '22', '0.74', null, null, null, null, '0', '2018-07-26 15:37:33', null, '2018-08-04 09:37:36', null);
INSERT INTO `wfl_projects` VALUES ('26', 'RD.19.0050', '', '4', 'Apaiguati', '2018-07-26 07:55:54', 'Medina', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '20', '2.00', null, null, null, null, '0', '2018-07-27 07:55:54', null, '2018-07-27 07:55:54', null);
INSERT INTO `wfl_projects` VALUES ('27', 'RD.18.0108', '', '3', 'Ivicuati', '2018-07-26 08:04:32', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.00', null, null, null, null, '0', '2018-07-27 08:04:32', null, '2018-08-07 11:16:12', null);
INSERT INTO `wfl_projects` VALUES ('28', 'RD.18.0111', '', '4', 'Gutierrez', '2018-07-26 08:05:32', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.00', null, null, null, null, '0', '2018-07-27 08:05:32', null, '2018-08-07 09:19:34', null);
INSERT INTO `wfl_projects` VALUES ('29', 'RD.18.0110', '', '4', 'Ipaty', '2018-07-26 08:06:33', 'Lujan', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.00', null, null, null, null, '0', '2018-07-27 08:06:33', null, '2018-07-27 08:06:33', null);
INSERT INTO `wfl_projects` VALUES ('30', 'RD.18.0105', '', '4', 'Lagunillas', '2018-07-26 08:13:08', 'Lujan', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', '0.00', null, null, null, null, '0', '2018-07-27 08:13:08', null, '2018-07-27 08:13:08', null);
INSERT INTO `wfl_projects` VALUES ('31', 'RD.18.0193', '', '4', 'Monte Agudo', '2018-07-26 08:14:35', 'Lujan', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '19', '1.86', null, null, null, null, '0', '2018-07-27 08:14:35', null, '2018-07-27 08:14:35', null);
INSERT INTO `wfl_projects` VALUES ('32', 'RD.18.0192', '', '4', 'Los Pozos Gutierrez', '2018-07-26 08:15:50', 'Lujan', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '67', '5.30', null, null, null, null, '0', '2018-07-27 08:15:50', null, '2018-07-27 08:15:50', null);
INSERT INTO `wfl_projects` VALUES ('33', 'RD.18.0189', '', '4', 'Comunidad Pozo Del Monte', '2018-07-26 08:17:33', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '31', '1.95', null, null, null, null, '0', '2018-07-27 08:17:33', null, '2018-08-07 11:18:10', null);
INSERT INTO `wfl_projects` VALUES ('34', 'RD.18.0187', '', '4', 'Pirirenda', '2018-07-26 08:20:47', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '13', '0.50', null, null, null, null, '0', '2018-07-27 08:20:47', null, '2018-08-07 09:18:52', null);
INSERT INTO `wfl_projects` VALUES ('35', 'RD.18.0186', '', '4', 'Comunidad Yuquerity', '2018-07-26 08:22:02', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '24', '1.25', null, null, null, null, '0', '2018-07-27 08:22:02', null, '2018-08-07 11:17:51', null);
INSERT INTO `wfl_projects` VALUES ('36', 'RD.18.0183', '', '4', 'Camiri', '2018-07-26 08:23:47', 'Medina', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '75', '3.33', null, null, null, null, '0', '2018-07-27 08:23:47', null, '2018-07-27 08:23:47', null);
INSERT INTO `wfl_projects` VALUES ('37', 'RD.18.0109', '', '4', 'Voyuibe', '2018-07-26 08:24:56', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.00', null, null, null, null, '0', '2018-07-27 08:24:56', null, '2018-08-07 11:17:29', null);
INSERT INTO `wfl_projects` VALUES ('38', 'RD.18.0178', '', '4', 'Guirayu Parenda', '2018-07-26 08:26:25', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '105', '9.80', null, null, null, null, '0', '2018-07-27 08:26:25', null, '2018-08-07 09:19:54', null);
INSERT INTO `wfl_projects` VALUES ('39', 'RD.18.0179', '', '4', 'Manjarati', '2018-07-26 08:27:45', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '77', '7.20', null, null, null, null, '0', '2018-07-27 08:27:45', null, '2018-08-07 11:23:12', null);
INSERT INTO `wfl_projects` VALUES ('40', 'RD.18.0177', '', '4', 'Coordillera', '2018-07-26 08:28:52', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '115', '11.00', null, null, null, null, '0', '2018-07-27 08:28:52', null, '2018-08-07 09:19:16', null);
INSERT INTO `wfl_projects` VALUES ('41', 'RD.18.0182', '', '4', 'Camiri', '2018-07-26 08:30:19', 'Giles', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '105', '9.50', null, null, null, null, '0', '2018-07-27 08:30:19', null, '2018-07-27 08:30:19', null);
INSERT INTO `wfl_projects` VALUES ('42', 'RD.18.0180', '', '4', 'Tartagalito', '2018-07-26 08:31:48', 'Lujan', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '60', '55.00', null, null, null, null, '0', '2018-07-27 08:31:48', null, '2018-07-27 08:31:48', null);
INSERT INTO `wfl_projects` VALUES ('43', 'RD.18.0181', '', '4', 'Tartagalito', '2018-07-26 08:33:16', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '41', '4.00', null, null, null, null, '0', '2018-07-27 08:33:16', null, '2018-08-07 11:18:28', null);
INSERT INTO `wfl_projects` VALUES ('44', 'RD.18.0107', '', '4', 'Ivicuati', '2018-07-26 08:34:03', 'Lujan', '9', '2018-07-25 15:45:57', '2018-07-26 15:45:57', '1', '0.00', null, null, null, null, '1', '2018-07-27 08:34:03', null, '2018-08-07 11:25:18', null);
INSERT INTO `wfl_projects` VALUES ('45', 'RD.18.0194', '', '4', 'Comunidad kuruguakua', '2018-07-26 08:35:19', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '12', '0.40', null, null, null, null, '0', '2018-07-27 08:35:19', null, '2018-08-07 09:20:11', null);
INSERT INTO `wfl_projects` VALUES ('46', 'RD.19.0031', '', '4', 'Ipaticito Del Monte', '2018-07-26 08:37:27', 'Lujan', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '25', '2.29', null, null, null, null, '0', '2018-07-27 08:37:27', null, '2018-07-27 08:37:27', null);
INSERT INTO `wfl_projects` VALUES ('47', 'RD.16.0858', '', '1', 'Las Cabañas', '2018-04-26 11:13:34', 'Giles', '10', '2018-06-05 11:15:34', '2018-07-10 11:15:34', '60', '2.50', null, null, null, null, '0', '2018-07-27 11:13:34', null, '2018-08-04 09:42:34', null);
INSERT INTO `wfl_projects` VALUES ('48', 'RD.18.0294', '', '3', 'Medio Monte', '2018-07-06 08:28:28', 'Santiago Sardina', '10', '2018-08-20 16:36:54', '2018-09-10 16:36:54', '35', '1.40', null, null, null, null, '0', '2018-07-28 08:28:28', null, '2018-08-08 11:07:23', null);
INSERT INTO `wfl_projects` VALUES ('49', 'RD.18.0293', '', '3', 'Comunidad Villa Primavera', '2018-07-03 10:11:31', 'Santos Cespedes', '5', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '50', '5.00', null, null, null, null, '0', '2018-07-28 10:11:31', null, '2018-08-16 10:11:00', null);
INSERT INTO `wfl_projects` VALUES ('50', 'RA.18.1797', '', '3', 'Entre San Julian y San Ramon', '2018-07-21 10:15:09', 'Herman Velasco Flores', '10', '2018-08-27 17:29:26', '2018-09-05 17:29:26', '1', '0.00', null, null, null, null, '0', '2018-07-28 10:15:09', null, '2018-08-08 11:06:38', null);
INSERT INTO `wfl_projects` VALUES ('51', 'RA.18.1795', '', '3', 'Entre San Julian y San Ramon', '2018-07-21 10:17:08', 'Santos Cespedes', '10', '2018-08-30 10:14:27', '2018-08-31 10:14:27', '6', '0.50', null, null, null, null, '0', '2018-07-28 10:17:08', null, '2018-08-16 10:28:21', null);
INSERT INTO `wfl_projects` VALUES ('52', 'RD.16.0931', '', '1', 'Montero', '2017-11-14 08:49:20', 'Barrientos', '20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '55', '6.00', null, null, null, null, '0', '2018-07-30 08:49:20', null, '2018-08-15 14:04:20', null);
INSERT INTO `wfl_projects` VALUES ('53', 'RD.16.0930', '', '1', 'Montero', '2017-11-14 08:50:04', 'Barrientos', '40', '2018-08-08 10:27:15', '2018-10-31 10:27:15', '1', '0.00', null, null, null, null, '0', '2018-07-30 08:50:04', null, '2018-09-12 12:13:54', '1');
INSERT INTO `wfl_projects` VALUES ('54', 'RA.18.1912', '', '3', 'San Julian', '2018-07-31 15:52:34', 'Santos Cespedes', '10', '2018-09-03 09:24:40', '2018-09-07 09:24:40', '21', '1.00', null, null, null, null, '0', '2018-07-31 15:52:34', null, '2018-08-16 10:26:01', null);
INSERT INTO `wfl_projects` VALUES ('55', 'RA.18.1914', '', '3', 'San Julian, San Ramon', '2018-07-31 15:53:48', 'Santos Cespedes', '10', '2018-08-30 10:15:30', '2018-08-31 10:15:30', '5', '0.20', null, null, null, null, '0', '2018-07-31 15:53:48', null, '2018-08-16 10:31:46', null);
INSERT INTO `wfl_projects` VALUES ('56', 'RD.18.0170', '', '1', 'Av. Internacional', '2018-06-05 14:27:42', 'Giles', '9', '2018-06-11 15:09:03', '2018-07-18 15:09:03', '1', '0.00', null, null, null, null, '1', '2018-08-02 14:27:42', null, '2018-08-02 15:41:08', null);
INSERT INTO `wfl_projects` VALUES ('57', 'RD.18.0169', '', '1', 'Warnes', '2018-08-02 14:31:29', 'Giles', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.00', null, null, null, null, '1', '2018-08-02 14:31:29', null, '2018-08-02 14:34:14', null);
INSERT INTO `wfl_projects` VALUES ('58', 'RD.18.0168', '', '1', 'Puerto Avaroa', '2018-06-05 14:33:03', 'Giles', '21', '2018-07-18 15:36:23', '2018-07-19 15:36:23', '1', '0.00', null, null, null, null, '0', '2018-08-02 14:33:03', null, '2018-08-22 12:14:22', null);
INSERT INTO `wfl_projects` VALUES ('59', 'RD.18.0169', '', '1', 'Warnes', '2018-06-05 14:34:46', 'Giles', '21', '2018-08-20 15:37:46', '2018-08-21 15:37:46', '1', '0.00', null, null, null, null, '0', '2018-08-02 14:34:46', null, '2018-08-30 14:50:20', '1');
INSERT INTO `wfl_projects` VALUES ('60', 'RD.18.0164', '', '1', 'Km9 Carretera al Norte', '2018-06-05 14:36:35', 'Giles', '11', '2018-07-17 15:31:14', '2018-07-25 15:31:14', '2', '0.00', null, null, null, null, '0', '2018-08-02 14:36:35', null, '2018-08-30 14:44:53', '1');
INSERT INTO `wfl_projects` VALUES ('61', 'RD.16.0865', '', '2', 'Santa Rosa de la Roca', '2018-08-11 14:38:36', 'Milton Ruiz', '9', '2018-07-02 15:28:46', '2018-07-03 15:28:46', '1', '0.00', null, null, null, null, '1', '2018-08-02 14:38:36', null, '2018-08-04 08:12:35', null);
INSERT INTO `wfl_projects` VALUES ('62', 'RD.16.0890', '', '1', 'Av. Centenario', '2018-06-11 14:40:38', 'Barrientos', '29', '2018-07-16 11:45:52', '2018-07-31 11:45:52', '1', '0.00', null, null, null, null, '0', '2018-08-02 14:40:38', null, '2018-08-28 12:04:00', '1');
INSERT INTO `wfl_projects` VALUES ('63', 'RD.16.0895', '', '1', 'Av. Pirai', '2018-06-11 14:42:24', 'Barrientos', '10', '2018-07-10 15:26:49', '2018-07-11 15:26:49', '1', '0.00', null, null, null, null, '0', '2018-08-02 14:42:24', null, '2018-08-04 09:48:15', null);
INSERT INTO `wfl_projects` VALUES ('64', 'RD.16.0863', '', '3', 'Guarayos', '2018-06-11 14:43:56', 'Milton Ruiz', '10', '2018-07-09 15:24:03', '2018-07-11 15:24:03', '1', '0.00', null, null, null, null, '0', '2018-08-02 14:43:56', null, '2018-08-16 11:01:04', null);
INSERT INTO `wfl_projects` VALUES ('65', 'RD.18.0271', '', '1', 'Av. Virgen de Lujan', '2018-06-26 14:59:08', 'Barrientos', '10', '2018-07-25 15:21:40', '2018-07-31 15:21:40', '12', '1.00', null, null, null, null, '0', '2018-08-02 14:59:08', null, '2018-08-16 11:00:25', null);
INSERT INTO `wfl_projects` VALUES ('66', 'RD.18.0272', '', '1', 'Av. Virgen de Lujan', '2018-06-26 15:00:30', 'Barrientos', '10', '2018-08-06 15:13:09', '2018-08-10 15:13:09', '20', '1.50', null, null, null, null, '0', '2018-08-02 15:00:30', null, '2018-08-04 09:43:29', null);
INSERT INTO `wfl_projects` VALUES ('67', 'RD.18.0270', '', '1', 'Colinas del Urubo', '2018-06-12 15:02:03', 'Dario Flores', '10', '2018-08-21 15:17:03', '2018-08-02 15:17:03', '37', '4.00', null, null, null, null, '0', '2018-08-02 15:02:03', null, '2018-08-04 09:47:33', null);
INSERT INTO `wfl_projects` VALUES ('68', 'RD.18.0170', '', '1', 'Av. Internacional', '2018-06-05 15:41:54', 'Giles', '9', '2018-07-25 15:43:18', '2018-07-26 15:43:18', '1', '9.00', null, null, null, null, '1', '2018-08-02 15:41:54', null, '2018-08-02 15:44:18', null);
INSERT INTO `wfl_projects` VALUES ('69', 'RD.18.0170', '', '1', 'Av. Internacional', '2018-06-05 15:44:51', 'Giles', '22', '2018-07-25 15:48:39', '2018-07-26 15:48:39', '1', '0.00', null, null, null, null, '0', '2018-08-02 15:44:51', null, '2018-08-17 10:07:48', null);
INSERT INTO `wfl_projects` VALUES ('70', 'RD.18.0303', '', '1', 'Yapacani', '2018-07-12 16:41:46', 'Barrientos', '10', '2018-08-06 16:47:42', '2018-08-22 16:47:42', '49', '4.00', null, null, null, null, '0', '2018-08-02 16:41:46', null, '2018-08-04 09:46:45', null);
INSERT INTO `wfl_projects` VALUES ('71', 'ra.18.0240', '', '1', 'El Carmen Km 9', '2018-07-13 16:42:46', 'Duran', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '4', '0.10', null, null, null, null, '1', '2018-08-02 16:42:46', null, '2018-08-02 16:43:43', null);
INSERT INTO `wfl_projects` VALUES ('72', 'RA.18.0240', '', '1', 'El Carmen Km 9', '2018-07-13 16:44:23', 'Duran', '10', '2018-07-25 16:45:36', '2018-07-31 16:45:36', '4', '0.10', null, null, null, null, '0', '2018-08-02 16:44:23', null, '2018-08-04 09:44:29', null);
INSERT INTO `wfl_projects` VALUES ('73', 'RA.18.1916', '', '3', 'San Julian', '2018-08-03 11:41:46', 'Santos Cespedes', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '18', '0.70', null, null, null, null, '1', '2018-08-03 11:41:46', null, '2018-08-07 11:42:22', null);
INSERT INTO `wfl_projects` VALUES ('74', 'RD.16.0865', '', '2', 'Santa Rosa de la Roca', '2018-06-11 08:14:51', 'Ruiz', '11', '2018-08-07 08:16:35', '2018-08-08 08:16:35', '1', '0.00', null, null, null, null, '0', '2018-08-04 08:14:51', null, '2018-09-04 11:41:13', '1');
INSERT INTO `wfl_projects` VALUES ('75', 'RA.18.1613', '', '3', 'San Ramon', '2018-07-02 10:01:24', 'Herman Velasco Flores', '31', '2018-07-24 10:02:42', '2018-07-26 10:02:42', '5', '0.20', null, null, null, null, '0', '2018-08-07 10:01:24', null, '2018-09-05 11:14:40', '1');
INSERT INTO `wfl_projects` VALUES ('76', 'RD.18.0107', '', '4', 'Ivicuati', '2018-07-25 11:25:53', 'Lujan', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.00', null, null, null, null, '0', '2018-08-07 11:25:53', null, '2018-08-07 11:26:20', null);
INSERT INTO `wfl_projects` VALUES ('77', 'ra.18.1946', '', '3', 'San Julian', '2018-08-03 11:40:48', 'Santos Cespedes', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '30', '2.00', null, null, null, null, '1', '2018-08-07 11:40:48', null, '2018-08-07 11:42:26', null);
INSERT INTO `wfl_projects` VALUES ('78', 'RA.18.1946', '', '3', 'San Julian', '2018-08-03 11:43:07', 'Santos Cespedes', '10', '2018-09-03 10:16:31', '2018-09-08 10:16:31', '18', '0.70', null, null, null, null, '0', '2018-08-07 11:43:07', null, '2018-08-16 10:27:43', null);
INSERT INTO `wfl_projects` VALUES ('79', 'RA.18.0059', '', '3', 'Medio Monte - Panorama', '2018-04-04 14:23:23', 'Barrientos', '9', '2018-06-20 14:26:44', '2018-07-31 14:26:44', '159', '15.00', null, null, null, null, '1', '2018-08-07 14:23:23', null, '2018-08-16 10:59:05', null);
INSERT INTO `wfl_projects` VALUES ('80', 'RD.18.0156', '', '1', 'Guajojo', '2018-08-08 08:50:47', 'Layonel Lujan', '7', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.01', null, null, null, null, '0', '2018-08-08 08:50:47', null, '2018-08-08 08:50:47', null);
INSERT INTO `wfl_projects` VALUES ('81', 'RD.18.0159', '', '1', 'ALI 19-24', '2018-08-08 08:52:10', 'Milton Ruiz', '7', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.01', null, null, null, null, '0', '2018-08-08 08:52:10', null, '2018-08-08 08:52:10', null);
INSERT INTO `wfl_projects` VALUES ('82', 'RD.18.0160', '', '1', 'ALI 19-25', '2018-08-08 08:52:56', 'Milton Ruiz', '7', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0.01', null, null, null, null, '0', '2018-08-08 08:52:56', null, '2018-08-08 08:52:56', null);
INSERT INTO `wfl_projects` VALUES ('83', 'RD.18.0339', '', '3', 'San Julian, Barrio Laguna Azul', '2018-08-13 09:49:16', 'Anibal Guaman', '7', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '43', '1.70', null, null, null, null, '1', '2018-08-15 09:49:16', null, '2018-08-15 10:21:58', null);
INSERT INTO `wfl_projects` VALUES ('84', 'RD.18.0339', '', '3', 'San Julian - Centro', '2018-08-14 10:24:17', 'Santos Cespedes', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '45', '1.70', null, null, null, null, '0', '2018-08-15 10:24:17', null, '2018-08-15 10:25:37', null);
INSERT INTO `wfl_projects` VALUES ('85', 'RD.18.0059', '', '3', 'Concepcion Medio Monte', '2018-04-04 10:58:35', 'Ernesto Barrientos', '5', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '160', '16.00', null, null, null, null, '1', '2018-08-16 10:58:35', null, '2018-08-16 11:06:05', null);
INSERT INTO `wfl_projects` VALUES ('86', 'RD.18.0059', '', '3', 'Medio Monte', '2018-04-04 11:06:52', 'Barrientos', '10', '2018-07-18 11:14:23', '2018-08-31 11:14:23', '160', '16.00', null, null, null, null, '0', '2018-08-16 11:06:52', null, '2018-08-16 11:24:15', null);
INSERT INTO `wfl_projects` VALUES ('87', 'RA.18.0599', '', '2', 'km 25', '2018-09-06 10:42:39', 'Mario Diego galvarro', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '20', '50.00', '1', '1', '2018-09-06 10:42:40', '2018-09-08 10:42:40', '0', '2018-09-06 10:42:40', null, '2018-09-06 10:50:33', null);
INSERT INTO `wfl_projects` VALUES ('88', 'RA.18.0566', '', '3', 'km 25', '2018-09-06 10:52:30', 'Mario Diego galvarro', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '20', '50.00', '1', '2', '2018-09-13 10:52:30', '2018-09-20 10:52:30', '0', '2018-09-06 10:52:30', null, '2018-09-06 10:52:30', null);

-- ----------------------------
-- Table structure for wfl_project_budgets
-- ----------------------------
DROP TABLE IF EXISTS `wfl_project_budgets`;
CREATE TABLE `wfl_project_budgets` (
  `id_prb` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_log_id_prb` bigint(20) DEFAULT NULL,
  `design_prb` double(8,2) DEFAULT NULL,
  `building_prb` double(8,2) DEFAULT NULL,
  `graph_number_prb` varchar(20) DEFAULT NULL,
  `reservation_number_prb` varchar(20) DEFAULT NULL,
  `transportation_prb` double(8,2) DEFAULT NULL,
  `live_line_prb` double(8,2) DEFAULT NULL,
  `right_of_way_prb` double(8,2) DEFAULT NULL,
  `deleted_prb` smallint(6) DEFAULT '0',
  `createdon_prb` datetime DEFAULT NULL,
  `createdby_prb` bigint(20) DEFAULT NULL,
  `editedon_prb` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_prb` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_prb`),
  KEY `fk_status_log_id_prb` (`status_log_id_prb`) USING BTREE,
  CONSTRAINT `fk_status_log_id_prb` FOREIGN KEY (`status_log_id_prb`) REFERENCES `wfl_project_status_log` (`id_psl`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of wfl_project_budgets
-- ----------------------------
INSERT INTO `wfl_project_budgets` VALUES ('1', '366', '4955.81', '43979.35', '6054417', '490356', null, null, null, '0', '2018-08-07 10:01:05', null, '2018-08-07 10:01:05', null);
INSERT INTO `wfl_project_budgets` VALUES ('2', '374', '1508.29', '13523.42', '6054610', '491688', null, null, null, '0', '2018-08-07 10:02:52', null, '2018-08-07 10:02:52', null);
INSERT INTO `wfl_project_budgets` VALUES ('3', '375', '1292.82', '11505.86', '6054503', '491059', null, null, null, '0', '2018-08-07 10:04:25', null, '2018-08-07 10:04:25', null);
INSERT INTO `wfl_project_budgets` VALUES ('4', '376', '430.94', '5578.61', '6054505', '491061', null, null, null, '0', '2018-08-07 10:06:16', null, '2018-08-07 10:06:16', null);
INSERT INTO `wfl_project_budgets` VALUES ('5', '377', '10342.56', '98918.23', '6054424', '490377', null, null, null, '0', '2018-08-07 10:10:14', null, '2018-08-07 10:10:14', null);
INSERT INTO `wfl_project_budgets` VALUES ('6', '378', '1723.76', '19074.37', '6054506', '491066', null, null, null, '0', '2018-08-07 10:12:28', null, '2018-08-07 10:12:28', null);
INSERT INTO `wfl_project_budgets` VALUES ('7', '379', '430.94', '5147.67', '6054505', '491061', null, null, null, '0', '2018-08-07 10:14:42', null, '2018-08-07 10:14:42', null);
INSERT INTO `wfl_project_budgets` VALUES ('8', '380', '1292.82', '10213.04', '6054503', '491059', null, null, null, '0', '2018-08-07 10:16:35', null, '2018-08-07 10:16:35', null);
INSERT INTO `wfl_project_budgets` VALUES ('9', '381', '1508.29', '12015.13', '6054610', '491688', null, null, null, '0', '2018-08-07 10:18:51', null, '2018-08-07 10:18:51', null);
INSERT INTO `wfl_project_budgets` VALUES ('10', '382', '4955.81', '39023.54', '6054417', '490356', null, null, null, '0', '2018-08-07 10:21:08', null, '2018-08-07 10:21:08', null);
INSERT INTO `wfl_project_budgets` VALUES ('11', '386', '8403.33', '49604.15', '6054076', '487924', null, null, null, '0', '2018-08-07 10:42:38', null, '2018-08-07 10:42:38', null);
INSERT INTO `wfl_project_budgets` VALUES ('12', '387', '7972.39', '45128.28', '6054077', '487926', '4275.00', null, null, '0', '2018-08-07 10:45:54', null, '2018-08-07 10:45:54', null);
INSERT INTO `wfl_project_budgets` VALUES ('13', '388', '8403.33', '45481.15', '6054076', '487924', '4123.00', null, null, '0', '2018-08-07 10:50:13', null, '2018-08-07 10:50:13', null);
INSERT INTO `wfl_project_budgets` VALUES ('14', '389', '430.94', '5578.61', '6054505', '491061', '0.00', null, null, '0', '2018-08-07 10:57:18', null, '2018-08-07 10:57:18', null);
INSERT INTO `wfl_project_budgets` VALUES ('15', '390', '1508.29', '11891.63', '6054610', '491688', '741.00', null, null, '0', '2018-08-07 11:01:38', null, '2018-08-07 11:01:38', null);
INSERT INTO `wfl_project_budgets` VALUES ('16', '391', '4955.81', '34892.54', '6054417', '490356', '4131.00', null, null, '0', '2018-08-07 11:04:07', null, '2018-08-07 11:04:07', null);
INSERT INTO `wfl_project_budgets` VALUES ('17', '392', '1723.76', '17972.34', '6054506', '491066', '1102.00', null, null, '0', '2018-08-07 11:08:12', null, '2018-08-07 11:08:12', null);
INSERT INTO `wfl_project_budgets` VALUES ('18', '393', '10342.56', '92220.73', '6054424', '490377', '6697.50', null, null, '0', '2018-08-07 11:11:34', null, '2018-08-07 11:11:34', null);
INSERT INTO `wfl_project_budgets` VALUES ('19', '395', '1077.35', '5491.73', '6054608', '491684', '684.00', null, null, '0', '2018-08-07 11:13:31', null, '2018-08-07 11:13:31', null);
INSERT INTO `wfl_project_budgets` VALUES ('20', '401', '199.84', '1108.11', '6053411', '482976', '0.00', null, null, '0', '2018-08-07 11:21:19', null, '2018-08-07 11:21:19', null);
INSERT INTO `wfl_project_budgets` VALUES ('21', '405', '227.64', '355.55', '6053424', '483086', '0.00', null, null, '0', '2018-08-07 11:30:02', null, '2018-08-07 11:30:02', null);
INSERT INTO `wfl_project_budgets` VALUES ('22', '407', '199.84', '4475.03', '6053426', '483096', '0.00', null, null, '0', '2018-08-07 11:34:28', null, '2018-08-07 11:34:28', null);
INSERT INTO `wfl_project_budgets` VALUES ('23', '408', '227.64', '461.10', '6053425', '483090', '0.00', null, null, '0', '2018-08-07 11:36:43', null, '2018-08-07 11:36:43', null);
INSERT INTO `wfl_project_budgets` VALUES ('24', '464', '399.68', '3037.40', '6054817', '493187', '0.00', '0.00', null, '0', '2018-08-15 10:30:09', null, '2018-08-15 10:30:09', null);
INSERT INTO `wfl_project_budgets` VALUES ('25', '465', '399.68', '5765.74', '6054818', '413189', '0.00', '0.00', null, '0', '2018-08-15 10:31:41', null, '2018-08-15 10:31:41', null);
INSERT INTO `wfl_project_budgets` VALUES ('26', '477', '199.84', '4689.83', '6047418', '489847', '0.00', '0.00', null, '0', '2018-08-16 10:53:27', null, '2018-08-16 10:53:27', null);
INSERT INTO `wfl_project_budgets` VALUES ('27', '524', '2199.84', '4689.83', '6047418', '489847', '3456.55', '15498.00', null, '0', '2018-08-23 09:58:48', null, '2018-08-23 09:58:48', null);
INSERT INTO `wfl_project_budgets` VALUES ('28', '527', '100.00', '200.00', '123', '456', '300.00', '400.00', null, '0', '2018-08-29 11:06:17', '1', '2018-08-29 11:06:17', null);
INSERT INTO `wfl_project_budgets` VALUES ('29', '528', '100.00', '200.00', '123', '456', '300.00', '400.00', null, '0', '2018-08-29 11:26:06', '1', '2018-08-29 11:26:06', null);
INSERT INTO `wfl_project_budgets` VALUES ('30', '529', '100.00', '200.00', '123', '456', '300.00', '400.00', null, '0', '2018-08-29 11:27:02', '1', '2018-08-29 11:27:02', null);
INSERT INTO `wfl_project_budgets` VALUES ('31', '530', '100.00', '200.00', '123', '456', '300.00', '400.00', null, '0', '2018-08-29 11:28:31', '1', '2018-08-29 11:28:31', null);
INSERT INTO `wfl_project_budgets` VALUES ('32', '531', '100.00', '200.00', '123', '456', '300.00', '400.00', null, '0', '2018-08-29 11:28:57', '1', '2018-08-29 11:28:57', null);
INSERT INTO `wfl_project_budgets` VALUES ('33', '532', '100.00', '200.00', '123', '456', '300.00', '400.00', '800.00', '0', '2018-08-29 11:30:18', '1', '2018-09-12 10:36:26', null);
INSERT INTO `wfl_project_budgets` VALUES ('34', '535', '1077.35', '5491.73', '6054608', '491684', '684.00', '700.00', null, '0', '2018-08-30 14:41:06', '1', '2018-08-30 14:41:06', null);
INSERT INTO `wfl_project_budgets` VALUES ('35', '536', '199.84', '1108.11', '6053411', '482976', '0.00', '800.00', null, '0', '2018-08-30 14:44:53', '1', '2018-08-30 14:44:53', null);
INSERT INTO `wfl_project_budgets` VALUES ('36', '558', '500.00', '400.00', '123456', '98745', '300.00', '200.00', '850.00', '0', '2018-08-31 16:50:16', '1', '2018-09-12 10:39:18', null);
INSERT INTO `wfl_project_budgets` VALUES ('37', '569', '500.00', '500.00', '300', '400', '500.00', '500.00', null, '0', '2018-09-04 11:41:14', '1', '2018-09-04 11:41:14', null);
INSERT INTO `wfl_project_budgets` VALUES ('38', '580', '1292.82', '10213.04', '6054503', '491059', '500.00', '600.00', '0.00', '0', '2018-09-10 11:30:15', '1', '2018-09-10 11:30:15', null);
INSERT INTO `wfl_project_budgets` VALUES ('39', '581', '1292.82', '10213.04', '6054503', '491059', '500.00', '600.00', '700.00', '0', '2018-09-10 11:33:01', '1', '2018-09-10 11:33:01', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=latin1;

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
INSERT INTO `wfl_project_points` VALUES ('23', '71', '7', '0.07', '0', '2018-07-26 14:38:37', null, '2018-07-26 14:38:37', null);
INSERT INTO `wfl_project_points` VALUES ('24', '72', '8', '0.46', '0', '2018-07-26 14:41:22', null, '2018-07-26 14:41:22', null);
INSERT INTO `wfl_project_points` VALUES ('25', '73', '22', '0.91', '0', '2018-07-26 14:44:48', null, '2018-07-26 14:44:48', null);
INSERT INTO `wfl_project_points` VALUES ('26', '74', '48', '2.50', '0', '2018-07-26 14:49:42', null, '2018-07-26 14:49:42', null);
INSERT INTO `wfl_project_points` VALUES ('27', '76', '48', '2.50', '0', '2018-07-26 14:54:55', null, '2018-07-26 14:54:55', null);
INSERT INTO `wfl_project_points` VALUES ('28', '82', '8', '0.46', '0', '2018-07-26 15:00:27', null, '2018-07-26 15:00:27', null);
INSERT INTO `wfl_project_points` VALUES ('29', '88', '22', '0.91', '0', '2018-07-26 15:03:53', null, '2018-07-26 15:03:53', null);
INSERT INTO `wfl_project_points` VALUES ('30', '94', '7', '0.07', '0', '2018-07-26 15:06:49', null, '2018-07-26 15:06:49', null);
INSERT INTO `wfl_project_points` VALUES ('31', '99', '23', '0.74', '0', '2018-07-26 15:24:50', null, '2018-07-26 15:24:50', null);
INSERT INTO `wfl_project_points` VALUES ('32', '100', '23', '0.70', '0', '2018-07-26 15:26:27', null, '2018-07-26 15:26:27', null);
INSERT INTO `wfl_project_points` VALUES ('33', '101', '22', '0.73', '0', '2018-07-26 15:28:50', null, '2018-07-26 15:28:50', null);
INSERT INTO `wfl_project_points` VALUES ('34', '102', '18', '0.52', '0', '2018-07-26 15:29:48', null, '2018-07-26 15:29:48', null);
INSERT INTO `wfl_project_points` VALUES ('35', '103', '30', '0.95', '0', '2018-07-26 15:31:03', null, '2018-07-26 15:31:03', null);
INSERT INTO `wfl_project_points` VALUES ('36', '104', '38', '1.25', '0', '2018-07-26 15:32:17', null, '2018-07-26 15:32:17', null);
INSERT INTO `wfl_project_points` VALUES ('37', '105', '22', '0.74', '0', '2018-07-26 15:37:33', null, '2018-07-26 15:37:33', null);
INSERT INTO `wfl_project_points` VALUES ('38', '107', '22', '0.74', '0', '2018-07-26 15:40:25', null, '2018-07-26 15:40:25', null);
INSERT INTO `wfl_project_points` VALUES ('39', '113', '38', '1.25', '0', '2018-07-26 15:42:31', null, '2018-07-26 15:42:31', null);
INSERT INTO `wfl_project_points` VALUES ('40', '119', '30', '0.95', '0', '2018-07-26 15:44:09', null, '2018-07-26 15:44:09', null);
INSERT INTO `wfl_project_points` VALUES ('41', '125', '18', '0.52', '0', '2018-07-26 15:46:20', null, '2018-07-26 15:46:20', null);
INSERT INTO `wfl_project_points` VALUES ('42', '131', '22', '0.73', '0', '2018-07-26 15:48:15', null, '2018-07-26 15:48:15', null);
INSERT INTO `wfl_project_points` VALUES ('43', '137', '23', '0.70', '0', '2018-07-26 15:49:55', null, '2018-07-26 15:49:55', null);
INSERT INTO `wfl_project_points` VALUES ('44', '142', '20', '2.00', '0', '2018-07-27 07:55:54', null, '2018-07-27 07:55:54', null);
INSERT INTO `wfl_project_points` VALUES ('45', '143', '1', '0.00', '0', '2018-07-27 08:04:32', null, '2018-07-27 08:04:32', null);
INSERT INTO `wfl_project_points` VALUES ('46', '144', '1', '0.00', '0', '2018-07-27 08:05:32', null, '2018-07-27 08:05:32', null);
INSERT INTO `wfl_project_points` VALUES ('47', '145', '1', '0.00', '0', '2018-07-27 08:06:33', null, '2018-07-27 08:06:33', null);
INSERT INTO `wfl_project_points` VALUES ('48', '146', '2', '0.00', '0', '2018-07-27 08:13:08', null, '2018-07-27 08:13:08', null);
INSERT INTO `wfl_project_points` VALUES ('49', '147', '19', '1.86', '0', '2018-07-27 08:14:35', null, '2018-07-27 08:14:35', null);
INSERT INTO `wfl_project_points` VALUES ('50', '148', '67', '5.30', '0', '2018-07-27 08:15:50', null, '2018-07-27 08:15:50', null);
INSERT INTO `wfl_project_points` VALUES ('51', '149', '31', '1.95', '0', '2018-07-27 08:17:33', null, '2018-07-27 08:17:33', null);
INSERT INTO `wfl_project_points` VALUES ('52', '150', '13', '0.50', '0', '2018-07-27 08:20:47', null, '2018-07-27 08:20:47', null);
INSERT INTO `wfl_project_points` VALUES ('53', '151', '24', '1.25', '0', '2018-07-27 08:22:02', null, '2018-07-27 08:22:02', null);
INSERT INTO `wfl_project_points` VALUES ('54', '152', '75', '3.33', '0', '2018-07-27 08:23:47', null, '2018-07-27 08:23:47', null);
INSERT INTO `wfl_project_points` VALUES ('55', '153', '1', '0.00', '0', '2018-07-27 08:24:56', null, '2018-07-27 08:24:56', null);
INSERT INTO `wfl_project_points` VALUES ('56', '154', '105', '9.80', '0', '2018-07-27 08:26:25', null, '2018-07-27 08:26:25', null);
INSERT INTO `wfl_project_points` VALUES ('57', '155', '77', '7.20', '0', '2018-07-27 08:27:45', null, '2018-07-27 08:27:45', null);
INSERT INTO `wfl_project_points` VALUES ('58', '156', '115', '11.00', '0', '2018-07-27 08:28:52', null, '2018-07-27 08:28:52', null);
INSERT INTO `wfl_project_points` VALUES ('59', '157', '105', '9.50', '0', '2018-07-27 08:30:19', null, '2018-07-27 08:30:19', null);
INSERT INTO `wfl_project_points` VALUES ('60', '158', '60', '55.00', '0', '2018-07-27 08:31:48', null, '2018-07-27 08:31:48', null);
INSERT INTO `wfl_project_points` VALUES ('61', '159', '41', '4.00', '0', '2018-07-27 08:33:16', null, '2018-07-27 08:33:16', null);
INSERT INTO `wfl_project_points` VALUES ('62', '160', '1', '0.00', '0', '2018-07-27 08:34:03', null, '2018-07-27 08:34:03', null);
INSERT INTO `wfl_project_points` VALUES ('63', '161', '12', '0.40', '0', '2018-07-27 08:35:19', null, '2018-07-27 08:35:19', null);
INSERT INTO `wfl_project_points` VALUES ('64', '162', '25', '2.29', '0', '2018-07-27 08:37:27', null, '2018-07-27 08:37:27', null);
INSERT INTO `wfl_project_points` VALUES ('65', '166', '60', '2.50', '0', '2018-07-27 11:13:34', null, '2018-07-27 11:13:34', null);
INSERT INTO `wfl_project_points` VALUES ('66', '168', '60', '2.50', '0', '2018-07-27 11:14:37', null, '2018-07-27 11:14:37', null);
INSERT INTO `wfl_project_points` VALUES ('67', '173', '35', '1.40', '0', '2018-07-28 08:28:28', null, '2018-07-28 08:28:28', null);
INSERT INTO `wfl_project_points` VALUES ('68', '175', '35', '1.40', '0', '2018-07-28 08:30:30', null, '2018-07-28 08:30:30', null);
INSERT INTO `wfl_project_points` VALUES ('69', '176', '50', '5.00', '0', '2018-07-28 10:11:31', null, '2018-07-28 10:11:31', null);
INSERT INTO `wfl_project_points` VALUES ('70', '177', '1', '0.00', '0', '2018-07-28 10:15:09', null, '2018-07-28 10:15:09', null);
INSERT INTO `wfl_project_points` VALUES ('71', '178', '6', '0.50', '0', '2018-07-28 10:17:08', null, '2018-07-28 10:17:08', null);
INSERT INTO `wfl_project_points` VALUES ('72', '184', '55', '6.00', '0', '2018-07-30 08:49:20', null, '2018-07-30 08:49:20', null);
INSERT INTO `wfl_project_points` VALUES ('73', '185', '1', '0.00', '0', '2018-07-30 08:50:04', null, '2018-07-30 08:50:04', null);
INSERT INTO `wfl_project_points` VALUES ('74', '190', '1', '0.00', '0', '2018-07-30 14:59:03', null, '2018-07-30 14:59:03', null);
INSERT INTO `wfl_project_points` VALUES ('75', '191', '1', '0.00', '0', '2018-07-30 14:59:15', null, '2018-07-30 14:59:15', null);
INSERT INTO `wfl_project_points` VALUES ('76', '201', '21', '1.00', '0', '2018-07-31 15:52:34', null, '2018-07-31 15:52:34', null);
INSERT INTO `wfl_project_points` VALUES ('77', '202', '5', '0.20', '0', '2018-07-31 15:53:48', null, '2018-07-31 15:53:48', null);
INSERT INTO `wfl_project_points` VALUES ('78', '203', '1', '0.00', '0', '2018-08-01 08:13:16', null, '2018-08-01 08:13:16', null);
INSERT INTO `wfl_project_points` VALUES ('79', '204', '3', '1.00', '0', '2018-08-01 08:13:27', null, '2018-08-01 08:13:27', null);
INSERT INTO `wfl_project_points` VALUES ('80', '211', '1', '0.00', '0', '2018-08-01 16:19:38', null, '2018-08-01 16:19:38', null);
INSERT INTO `wfl_project_points` VALUES ('81', '212', '1', '0.00', '0', '2018-08-02 11:05:24', null, '2018-08-02 11:05:24', null);
INSERT INTO `wfl_project_points` VALUES ('82', '213', '139', '5.50', '0', '2018-08-02 11:11:15', null, '2018-08-02 11:11:15', null);
INSERT INTO `wfl_project_points` VALUES ('83', '214', '1', '0.00', '0', '2018-08-02 14:27:42', null, '2018-08-02 14:27:42', null);
INSERT INTO `wfl_project_points` VALUES ('84', '215', '1', '0.00', '0', '2018-08-02 14:31:29', null, '2018-08-02 14:31:29', null);
INSERT INTO `wfl_project_points` VALUES ('85', '216', '1', '0.00', '0', '2018-08-02 14:33:03', null, '2018-08-02 14:33:03', null);
INSERT INTO `wfl_project_points` VALUES ('86', '217', '1', '0.00', '0', '2018-08-02 14:34:46', null, '2018-08-02 14:34:46', null);
INSERT INTO `wfl_project_points` VALUES ('87', '218', '2', '0.00', '0', '2018-08-02 14:36:35', null, '2018-08-02 14:36:35', null);
INSERT INTO `wfl_project_points` VALUES ('88', '219', '1', '0.00', '0', '2018-08-02 14:38:36', null, '2018-08-02 14:38:36', null);
INSERT INTO `wfl_project_points` VALUES ('89', '220', '1', '0.00', '0', '2018-08-02 14:40:38', null, '2018-08-02 14:40:38', null);
INSERT INTO `wfl_project_points` VALUES ('90', '221', '1', '0.00', '0', '2018-08-02 14:42:24', null, '2018-08-02 14:42:24', null);
INSERT INTO `wfl_project_points` VALUES ('91', '222', '1', '0.00', '0', '2018-08-02 14:43:56', null, '2018-08-02 14:43:56', null);
INSERT INTO `wfl_project_points` VALUES ('92', '223', '12', '1.00', '0', '2018-08-02 14:59:08', null, '2018-08-02 14:59:08', null);
INSERT INTO `wfl_project_points` VALUES ('93', '224', '20', '1.50', '0', '2018-08-02 15:00:30', null, '2018-08-02 15:00:30', null);
INSERT INTO `wfl_project_points` VALUES ('94', '225', '37', '4.00', '0', '2018-08-02 15:02:03', null, '2018-08-02 15:02:03', null);
INSERT INTO `wfl_project_points` VALUES ('95', '227', '1', '0.00', '0', '2018-08-02 15:05:09', null, '2018-08-02 15:05:09', null);
INSERT INTO `wfl_project_points` VALUES ('96', '233', '20', '1.50', '0', '2018-08-02 15:11:46', null, '2018-08-02 15:11:46', null);
INSERT INTO `wfl_project_points` VALUES ('97', '239', '37', '4.00', '0', '2018-08-02 15:16:34', null, '2018-08-02 15:16:34', null);
INSERT INTO `wfl_project_points` VALUES ('98', '245', '12', '1.00', '0', '2018-08-02 15:19:18', null, '2018-08-02 15:19:18', null);
INSERT INTO `wfl_project_points` VALUES ('99', '251', '1', '0.00', '0', '2018-08-02 15:23:31', null, '2018-08-02 15:23:31', null);
INSERT INTO `wfl_project_points` VALUES ('100', '257', '1', '0.00', '0', '2018-08-02 15:25:45', null, '2018-08-02 15:25:45', null);
INSERT INTO `wfl_project_points` VALUES ('101', '263', '1', '0.00', '0', '2018-08-02 15:28:14', null, '2018-08-02 15:28:14', null);
INSERT INTO `wfl_project_points` VALUES ('102', '269', '2', '0.00', '0', '2018-08-02 15:30:25', null, '2018-08-02 15:30:25', null);
INSERT INTO `wfl_project_points` VALUES ('103', '275', '1', '0.00', '0', '2018-08-02 15:35:44', null, '2018-08-02 15:35:44', null);
INSERT INTO `wfl_project_points` VALUES ('104', '281', '1', '0.00', '0', '2018-08-02 15:37:11', null, '2018-08-02 15:37:11', null);
INSERT INTO `wfl_project_points` VALUES ('105', '286', '1', '9.00', '0', '2018-08-02 15:41:54', null, '2018-08-02 15:41:54', null);
INSERT INTO `wfl_project_points` VALUES ('106', '288', '1', '9.00', '0', '2018-08-02 15:42:43', null, '2018-08-02 15:42:43', null);
INSERT INTO `wfl_project_points` VALUES ('107', '293', '1', '0.00', '0', '2018-08-02 15:44:51', null, '2018-08-02 15:44:51', null);
INSERT INTO `wfl_project_points` VALUES ('108', '295', '1', '0.00', '0', '2018-08-02 15:45:29', null, '2018-08-02 15:45:29', null);
INSERT INTO `wfl_project_points` VALUES ('109', '301', '1', '0.00', '0', '2018-08-02 15:48:13', null, '2018-08-02 15:48:13', null);
INSERT INTO `wfl_project_points` VALUES ('110', '306', '49', '4.00', '0', '2018-08-02 16:41:46', null, '2018-08-02 16:41:46', null);
INSERT INTO `wfl_project_points` VALUES ('111', '307', '4', '0.10', '0', '2018-08-02 16:42:46', null, '2018-08-02 16:42:46', null);
INSERT INTO `wfl_project_points` VALUES ('112', '308', '4', '0.10', '0', '2018-08-02 16:44:23', null, '2018-08-02 16:44:23', null);
INSERT INTO `wfl_project_points` VALUES ('113', '310', '4', '0.10', '0', '2018-08-02 16:45:10', null, '2018-08-02 16:45:10', null);
INSERT INTO `wfl_project_points` VALUES ('114', '316', '49', '4.00', '0', '2018-08-02 16:47:09', null, '2018-08-02 16:47:09', null);
INSERT INTO `wfl_project_points` VALUES ('115', '322', '18', '0.70', '0', '2018-08-03 11:41:46', null, '2018-08-03 11:41:46', null);
INSERT INTO `wfl_project_points` VALUES ('116', '323', '1', '0.00', '0', '2018-08-04 08:14:51', null, '2018-08-04 08:14:51', null);
INSERT INTO `wfl_project_points` VALUES ('117', '325', '1', '0.00', '0', '2018-08-04 08:15:42', null, '2018-08-04 08:15:42', null);
INSERT INTO `wfl_project_points` VALUES ('118', '360', '80', '3.20', '0', '2018-08-07 08:17:10', null, '2018-08-07 08:17:10', null);
INSERT INTO `wfl_project_points` VALUES ('119', '367', '5', '0.20', '0', '2018-08-07 10:01:24', null, '2018-08-07 10:01:24', null);
INSERT INTO `wfl_project_points` VALUES ('120', '369', '5', '0.20', '0', '2018-08-07 10:02:17', null, '2018-08-07 10:02:17', null);
INSERT INTO `wfl_project_points` VALUES ('121', '403', '1', '0.00', '0', '2018-08-07 11:25:53', null, '2018-08-07 11:25:53', null);
INSERT INTO `wfl_project_points` VALUES ('122', '410', '30', '2.00', '0', '2018-08-07 11:40:48', null, '2018-08-07 11:40:48', null);
INSERT INTO `wfl_project_points` VALUES ('123', '411', '18', '0.70', '0', '2018-08-07 11:43:07', null, '2018-08-07 11:43:07', null);
INSERT INTO `wfl_project_points` VALUES ('124', '414', '1', '0.00', '0', '2018-08-07 11:45:10', null, '2018-08-07 11:45:10', null);
INSERT INTO `wfl_project_points` VALUES ('125', '420', '159', '15.00', '0', '2018-08-07 14:23:23', null, '2018-08-07 14:23:23', null);
INSERT INTO `wfl_project_points` VALUES ('126', '422', '159', '15.00', '0', '2018-08-07 14:25:11', null, '2018-08-07 14:25:11', null);
INSERT INTO `wfl_project_points` VALUES ('127', '433', '1', '0.01', '0', '2018-08-08 08:50:47', null, '2018-08-08 08:50:47', null);
INSERT INTO `wfl_project_points` VALUES ('128', '434', '1', '0.01', '0', '2018-08-08 08:52:10', null, '2018-08-08 08:52:10', null);
INSERT INTO `wfl_project_points` VALUES ('129', '435', '1', '0.01', '0', '2018-08-08 08:52:56', null, '2018-08-08 08:52:56', null);
INSERT INTO `wfl_project_points` VALUES ('130', '438', '18', '0.70', '0', '2018-08-13 15:22:29', null, '2018-08-13 15:22:29', null);
INSERT INTO `wfl_project_points` VALUES ('131', '443', '5', '0.20', '0', '2018-08-13 16:52:23', null, '2018-08-13 16:52:23', null);
INSERT INTO `wfl_project_points` VALUES ('132', '444', '21', '1.00', '0', '2018-08-14 10:43:49', null, '2018-08-14 10:43:49', null);
INSERT INTO `wfl_project_points` VALUES ('133', '445', '6', '0.50', '0', '2018-08-14 11:02:32', null, '2018-08-14 11:02:32', null);
INSERT INTO `wfl_project_points` VALUES ('134', '447', '50', '5.00', '0', '2018-08-15 09:03:46', null, '2018-08-15 09:03:46', null);
INSERT INTO `wfl_project_points` VALUES ('135', '449', '43', '1.70', '0', '2018-08-15 09:49:16', null, '2018-08-15 09:49:16', null);
INSERT INTO `wfl_project_points` VALUES ('136', '461', '45', '1.70', '0', '2018-08-15 10:24:17', null, '2018-08-15 10:24:17', null);
INSERT INTO `wfl_project_points` VALUES ('137', '478', '160', '16.00', '0', '2018-08-16 10:58:35', null, '2018-08-16 10:58:35', null);
INSERT INTO `wfl_project_points` VALUES ('138', '484', '160', '16.00', '0', '2018-08-16 11:05:21', null, '2018-08-16 11:05:21', null);
INSERT INTO `wfl_project_points` VALUES ('139', '486', '160', '16.00', '0', '2018-08-16 11:06:52', null, '2018-08-16 11:06:52', null);
INSERT INTO `wfl_project_points` VALUES ('140', '488', '160', '16.00', '0', '2018-08-16 11:07:41', null, '2018-08-16 11:07:41', null);
INSERT INTO `wfl_project_points` VALUES ('141', '495', '160', '16.00', '0', '2018-08-16 11:22:03', null, '2018-08-16 11:22:03', null);
INSERT INTO `wfl_project_points` VALUES ('142', '573', '20', '50.00', '0', '2018-09-06 10:42:40', null, '2018-09-06 10:42:40', null);
INSERT INTO `wfl_project_points` VALUES ('143', '574', '20', '50.00', '0', '2018-09-06 10:52:30', null, '2018-09-06 10:52:30', null);

-- ----------------------------
-- Table structure for wfl_project_real_budgets
-- ----------------------------
DROP TABLE IF EXISTS `wfl_project_real_budgets`;
CREATE TABLE `wfl_project_real_budgets` (
  `id_reb` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_log_id_reb` bigint(20) DEFAULT NULL,
  `design_reb` double(8,2) DEFAULT NULL,
  `building_reb` double(8,2) DEFAULT NULL,
  `transportation_reb` double(8,2) DEFAULT NULL,
  `live_line_reb` double(8,2) DEFAULT NULL,
  `right_of_way_reb` double(8,2) DEFAULT NULL,
  `deleted_reb` smallint(6) DEFAULT '0',
  `createdon_reb` datetime DEFAULT NULL,
  `createdby_reb` bigint(20) DEFAULT NULL,
  `editedon_reb` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_reb` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_reb`),
  KEY `fk_status_log_id_reb` (`status_log_id_reb`),
  CONSTRAINT `fk_status_log_id_reb` FOREIGN KEY (`status_log_id_reb`) REFERENCES `wfl_project_status_log` (`id_psl`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of wfl_project_real_budgets
-- ----------------------------
INSERT INTO `wfl_project_real_budgets` VALUES ('1', '588', '500.00', '400.00', '300.00', '200.00', '0.00', '1', '2018-09-11 14:18:28', '1', '2018-09-12 10:34:20', null);
INSERT INTO `wfl_project_real_budgets` VALUES ('2', '589', '100.00', '200.00', '300.00', '400.00', '0.00', '1', '2018-09-11 14:18:28', '1', '2018-09-12 10:34:20', null);
INSERT INTO `wfl_project_real_budgets` VALUES ('3', '590', '500.00', '400.00', '300.00', '200.00', '600.00', '1', '2018-09-12 10:47:04', '1', '2018-09-12 11:43:39', null);
INSERT INTO `wfl_project_real_budgets` VALUES ('4', '591', '100.00', '200.00', '300.00', '400.00', '600.00', '1', '2018-09-12 10:47:04', '1', '2018-09-12 11:43:39', null);
INSERT INTO `wfl_project_real_budgets` VALUES ('5', '592', '100.00', '200.00', '300.00', '400.00', '800.00', '0', '2018-09-12 12:13:54', '1', '2018-09-12 12:13:54', null);
INSERT INTO `wfl_project_real_budgets` VALUES ('6', '593', '500.00', '400.00', '300.00', '200.00', '850.00', '0', '2018-09-12 12:13:55', '1', '2018-09-12 12:13:55', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_project_status
-- ----------------------------
INSERT INTO `wfl_project_status` VALUES ('1', 'Diseño', 'glyphicon glyphicon-pencil', '1', null, 'design', '0', null, null, '2018-06-19 15:35:48', null);
INSERT INTO `wfl_project_status` VALUES ('2', 'Estaqueado', 'fa fa-users', '2', '1', 'stakes', '0', null, null, '2018-06-19 15:35:51', null);
INSERT INTO `wfl_project_status` VALUES ('3', 'Digitalizacion', 'fa fa-laptop', '4', '1', 'digitization', '0', null, null, '2018-08-02 14:27:54', null);
INSERT INTO `wfl_project_status` VALUES ('5', 'Dibujo', 'fa fa-pencil-square-o', '5', '1', 'drawing', '0', null, null, '2018-08-02 14:27:55', null);
INSERT INTO `wfl_project_status` VALUES ('6', 'Cronograma/por enviar', 'fa fa-clock-o', '6', '1', 'schedule', '0', null, null, '2018-08-27 10:38:19', null);
INSERT INTO `wfl_project_status` VALUES ('7', 'Sin asignar', 'fa fa-exclamation', '0', null, 'unsigned', '0', null, null, '2018-07-13 17:42:03', null);
INSERT INTO `wfl_project_status` VALUES ('8', 'Aprobacion', 'fa fa-check', '7', null, 'approvement', '0', null, null, '2018-08-02 14:28:07', null);
INSERT INTO `wfl_project_status` VALUES ('9', 'Por enviar', 'glyphicon glyphicon-hourglass', '8', null, 'ready_to_send', '0', null, null, '2018-08-02 14:28:09', null);
INSERT INTO `wfl_project_status` VALUES ('10', 'Enviado', 'fa fa-send', '9', null, 'already_sent', '0', null, null, '2018-09-06 12:19:29', null);
INSERT INTO `wfl_project_status` VALUES ('11', 'Aprobado', 'fa fa-check', '10', null, 'approved', '0', null, null, '2018-09-06 12:19:30', null);
INSERT INTO `wfl_project_status` VALUES ('12', 'Cancelado', 'fa fa-times', '11', null, 'canceled', '0', null, null, '2018-08-02 14:28:12', null);
INSERT INTO `wfl_project_status` VALUES ('13', 'Rect. de diseño', 'fa fa-refresh', '12', null, 'rectify_design', '0', null, null, '2018-08-02 14:28:13', null);
INSERT INTO `wfl_project_status` VALUES ('14', 'Rect. de ilustracion', 'fa fa-refresh', '13', null, 'rectify_illustration', '0', null, null, '2018-08-02 14:28:14', null);
INSERT INTO `wfl_project_status` VALUES ('15', 'Estaqueado(RD)', 'fa fa-users', '14', null, 'rd_stakes', '0', null, null, '2018-08-02 14:28:15', null);
INSERT INTO `wfl_project_status` VALUES ('16', 'Digitalizacion(RD)', 'fa fa-laptop', '15', null, 'rd_digitization', '0', null, null, '2018-08-02 14:28:16', null);
INSERT INTO `wfl_project_status` VALUES ('17', 'Dibujo(RD)', 'fa fa-pencil', '16', null, 'rd_drawing', '0', null, null, '2018-08-02 14:28:17', null);
INSERT INTO `wfl_project_status` VALUES ('18', 'Digitalizacion(RI)', 'fa fa-laptop', '17', null, 'ri_digitization', '0', null, null, '2018-08-02 14:28:18', null);
INSERT INTO `wfl_project_status` VALUES ('19', 'Dibujo(RI)', 'fa fa-pencil', '18', null, 'ri_drawing', '0', null, null, '2018-08-02 14:28:19', null);
INSERT INTO `wfl_project_status` VALUES ('20', 'Devuelto a CRE', 'fa fa-reply', '3', null, 'returned', '0', null, null, '2018-08-02 14:28:44', null);
INSERT INTO `wfl_project_status` VALUES ('21', 'Asignacion', 'fa fa-table', '8', '27', 'assign_to', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('22', 'Por grabar', 'fa fa-inbox', '19', null, 'warehouse', '0', null, null, '2018-08-15 11:56:08', null);
INSERT INTO `wfl_project_status` VALUES ('23', 'Grabado', 'fa fa-copy', '20', null, 'record_building_materials', '0', null, null, '2018-08-16 17:13:07', null);
INSERT INTO `wfl_project_status` VALUES ('24', 'Retirar materiales', 'fa fa-table', '21', null, 'get_materials', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_project_status` VALUES ('25', 'Materiales a Const.', 'fa fa-table', '22', null, 'deliver_materials', '0', null, null, '2018-08-30 09:39:23', null);
INSERT INTO `wfl_project_status` VALUES ('26', 'Materiales a CRE', 'fa fa-table', '25', null, 'return_materials', '0', null, null, '2018-08-31 14:37:34', null);
INSERT INTO `wfl_project_status` VALUES ('27', 'Construccion', 'fa fa-table', '24', '27', 'building', '0', null, null, '2018-09-04 11:20:23', null);
INSERT INTO `wfl_project_status` VALUES ('28', 'Listo para iniciar', 'fa fa-table', '25', null, 'ready_to_start', '0', null, null, '2018-08-20 09:48:21', null);
INSERT INTO `wfl_project_status` VALUES ('29', 'En construccion', 'fa fa-table', '26', '27', 'in_progress', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('30', 'Detenido', 'fa fa-table', '28', '27', 'stopped', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('31', 'Pausado', 'fa fa-table', '27', '27', 'paused', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('32', 'Completado', 'fa fa-table', '29', '27', 'completed', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('33', 'As built', 'fa fa-table', '30', '27', 'as_built', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('34', 'Recep. de Concil.', 'fa fa-table', '31', '27', 'conciliation_reception', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('35', 'Envio de Concil.', 'fa fa-table', '32', '27', 'conciliation_shipment', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('36', 'Recep de materiales', 'fa fa-table', '23', null, 'materials_reception', '0', null, null, '2018-08-30 09:40:31', null);
INSERT INTO `wfl_project_status` VALUES ('37', 'Por devolver a CRE', 'fa fa-table', '24', null, 'request_materials_return', '0', null, null, '2018-08-31 14:40:21', null);
INSERT INTO `wfl_project_status` VALUES ('38', 'Recep. orden dev.', 'fa fa-table', '33', '27', 'cre_return_order', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('39', 'Mate. dev. a CRE', 'fa fa-table', '34', '27', 'project_return_materials', '0', null, null, '2018-09-04 11:29:43', null);
INSERT INTO `wfl_project_status` VALUES ('40', 'Importe Real', 'fa fa-table', '35', null, 'project_real_budget', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_project_status` VALUES ('41', 'Proyecto Cerrado', 'fa fa-table', '36', null, 'project_closed', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_project_status` VALUES ('42', 'Registro Nro. Orden', 'fa fa-table', '37', null, 'payment_order_registered', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_project_status` VALUES ('43', 'Factura enviada', 'fa fa-table', '38', null, 'payment_order_invoice_sent', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_project_status` VALUES ('44', 'Orden de pago liquidado', 'fa fa-table', '39', null, 'payment_order_has_been_settled', '0', null, null, '0000-00-00 00:00:00', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=594 DEFAULT CHARSET=latin1;

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
INSERT INTO `wfl_project_status_log` VALUES ('36', '11', '1', 'Inicio de diseño del proyecto', '2018-06-16 10:20:33', '0', '2018-07-26 10:20:33', null, '2018-08-02 11:52:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('37', '11', '2', '', '2018-06-16 10:21:46', '0', '2018-07-26 10:21:46', null, '2018-08-02 11:52:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('38', '11', '3', '', '2018-07-28 10:22:04', '1', '2018-07-26 10:22:04', null, '2018-08-02 10:55:59', null);
INSERT INTO `wfl_project_status_log` VALUES ('39', '11', '5', '', '2018-06-29 10:22:20', '0', '2018-07-26 10:22:20', null, '2018-07-26 10:22:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('40', '11', '2', '', '2018-06-26 10:22:56', '1', '2018-07-26 10:22:56', null, '2018-08-02 11:52:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('41', '11', '3', '', '2018-06-28 10:23:29', '0', '2018-07-26 10:23:29', null, '2018-07-26 10:23:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('42', '11', '2', '', '2018-06-16 10:24:03', '1', '2018-07-26 10:24:03', null, '2018-08-02 11:52:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('43', '11', '6', '', '2018-07-06 10:24:47', '0', '2018-07-26 10:24:47', null, '2018-07-26 10:24:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('44', '11', '8', 'Iniciando etapa de aprobacion', '2018-07-06 10:24:48', '0', '2018-07-26 10:24:48', null, '2018-08-02 10:51:45', null);
INSERT INTO `wfl_project_status_log` VALUES ('45', '11', '9', 'Proyecto por enviar', '2018-07-06 10:24:49', '0', '2018-07-26 10:24:49', null, '2018-08-02 10:51:48', null);
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
INSERT INTO `wfl_project_status_log` VALUES ('65', '14', '6', '', '2018-07-09 11:15:49', '0', '2018-07-26 11:15:49', null, '2018-07-26 11:15:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('66', '14', '8', 'Iniciando etapa de aprobacion', '2018-07-26 11:15:50', '0', '2018-07-26 11:15:50', null, '2018-07-26 11:15:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('67', '14', '9', 'Proyecto por enviar', '2018-07-26 11:15:51', '0', '2018-07-26 11:15:51', null, '2018-07-26 11:15:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('68', '7', '6', '', '2018-07-19 11:51:44', '0', '2018-07-26 11:51:44', null, '2018-07-26 11:51:44', null);
INSERT INTO `wfl_project_status_log` VALUES ('69', '7', '8', 'Iniciando etapa de aprobacion', '2018-07-26 11:51:45', '0', '2018-07-26 11:51:45', null, '2018-07-26 11:51:45', null);
INSERT INTO `wfl_project_status_log` VALUES ('70', '7', '9', 'Proyecto por enviar', '2018-07-26 11:51:46', '0', '2018-07-26 11:51:46', null, '2018-07-26 11:51:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('71', '15', '1', 'Proyecto enviado a diseño', '2018-07-01 14:38:37', '0', '2018-07-26 14:38:37', null, '2018-07-26 14:38:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('72', '16', '1', 'Proyecto enviado a diseño', '2018-06-16 14:41:22', '0', '2018-07-26 14:41:22', null, '2018-07-26 14:41:22', null);
INSERT INTO `wfl_project_status_log` VALUES ('73', '17', '1', 'Proyecto enviado a diseño', '2018-06-16 14:44:48', '0', '2018-07-26 14:44:48', null, '2018-07-26 14:44:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('74', '18', '1', 'Proyecto enviado a diseño', '2018-06-16 14:49:42', '0', '2018-07-26 14:49:42', null, '2018-07-26 14:49:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('75', '18', '2', '', '2018-06-18 14:54:16', '0', '2018-07-26 14:54:16', null, '2018-07-26 14:54:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('76', '18', '3', '', '2018-06-28 14:54:55', '0', '2018-07-26 14:54:55', null, '2018-07-26 14:54:55', null);
INSERT INTO `wfl_project_status_log` VALUES ('77', '18', '5', '', '2018-06-29 14:55:23', '0', '2018-07-26 14:55:23', null, '2018-07-26 14:55:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('78', '18', '6', '', '2018-07-02 14:55:56', '0', '2018-07-26 14:55:56', null, '2018-07-26 14:55:56', null);
INSERT INTO `wfl_project_status_log` VALUES ('79', '18', '8', 'Iniciando etapa de aprobacion', '2018-07-26 14:55:57', '0', '2018-07-26 14:55:57', null, '2018-07-26 14:55:57', null);
INSERT INTO `wfl_project_status_log` VALUES ('80', '18', '9', 'Proyecto por enviar', '2018-07-26 14:55:58', '0', '2018-07-26 14:55:58', null, '2018-07-26 14:55:58', null);
INSERT INTO `wfl_project_status_log` VALUES ('81', '16', '2', '', '2018-06-18 15:00:09', '0', '2018-07-26 15:00:09', null, '2018-07-26 15:00:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('82', '16', '3', '', '2018-06-29 15:00:27', '0', '2018-07-26 15:00:27', null, '2018-07-26 15:00:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('83', '16', '5', '', '2018-06-30 15:00:37', '0', '2018-07-26 15:00:37', null, '2018-07-26 15:00:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('84', '16', '6', '', '2018-07-06 15:01:13', '0', '2018-07-26 15:01:13', null, '2018-07-26 15:01:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('85', '16', '8', 'Iniciando etapa de aprobacion', '2018-07-26 15:01:14', '0', '2018-07-26 15:01:14', null, '2018-08-02 10:51:19', null);
INSERT INTO `wfl_project_status_log` VALUES ('86', '16', '9', 'Proyecto por enviar', '2018-07-26 15:01:15', '0', '2018-07-26 15:01:15', null, '2018-08-02 10:51:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('87', '17', '2', '', '2018-06-18 15:03:39', '0', '2018-07-26 15:03:39', null, '2018-07-26 15:03:39', null);
INSERT INTO `wfl_project_status_log` VALUES ('88', '17', '3', '', '2018-06-28 15:03:53', '0', '2018-07-26 15:03:53', null, '2018-07-26 15:03:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('89', '17', '5', '', '2018-06-29 15:04:05', '0', '2018-07-26 15:04:05', null, '2018-07-26 15:04:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('90', '17', '6', '', '2018-07-02 15:04:31', '0', '2018-07-26 15:04:31', null, '2018-07-26 15:04:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('91', '17', '8', 'Iniciando etapa de aprobacion', '2018-07-26 15:04:32', '0', '2018-07-26 15:04:32', null, '2018-07-26 15:04:32', null);
INSERT INTO `wfl_project_status_log` VALUES ('92', '17', '9', 'Proyecto por enviar', '2018-07-26 15:04:33', '0', '2018-07-26 15:04:33', null, '2018-07-26 15:04:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('93', '15', '2', '', '2018-07-03 15:06:31', '0', '2018-07-26 15:06:31', null, '2018-07-26 15:06:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('94', '15', '3', '', '2018-07-07 15:06:49', '0', '2018-07-26 15:06:49', null, '2018-07-26 15:06:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('95', '15', '5', '', '2018-07-09 15:06:57', '0', '2018-07-26 15:06:57', null, '2018-07-26 15:06:57', null);
INSERT INTO `wfl_project_status_log` VALUES ('96', '15', '6', '', '2018-07-09 15:08:10', '0', '2018-07-26 15:08:10', null, '2018-07-26 15:08:10', null);
INSERT INTO `wfl_project_status_log` VALUES ('97', '15', '8', 'Iniciando etapa de aprobacion', '2018-07-26 15:08:11', '0', '2018-07-26 15:08:11', null, '2018-07-26 15:08:11', null);
INSERT INTO `wfl_project_status_log` VALUES ('98', '15', '9', 'Proyecto por enviar', '2018-07-26 15:08:12', '0', '2018-07-26 15:08:12', null, '2018-07-26 15:08:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('99', '19', '1', 'Proyecto enviado a diseño', '2018-07-02 15:24:50', '0', '2018-07-26 15:24:50', null, '2018-07-26 15:24:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('100', '20', '1', 'Proyecto enviado a diseño', '2018-07-03 15:26:27', '0', '2018-07-26 15:26:27', null, '2018-07-26 15:26:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('101', '21', '1', 'Proyecto enviado a diseño', '2018-07-03 15:28:50', '0', '2018-07-26 15:28:50', null, '2018-07-26 15:28:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('102', '22', '1', 'Proyecto enviado a diseño', '2018-07-03 15:29:48', '0', '2018-07-26 15:29:48', null, '2018-07-26 15:29:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('103', '23', '1', 'Proyecto enviado a diseño', '2018-07-02 15:31:03', '0', '2018-07-26 15:31:03', null, '2018-07-26 15:31:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('104', '24', '1', 'Proyecto enviado a diseño', '2018-07-02 15:32:17', '0', '2018-07-26 15:32:17', null, '2018-07-26 15:32:17', null);
INSERT INTO `wfl_project_status_log` VALUES ('105', '25', '1', 'Proyecto enviado a diseño', '2018-07-02 15:37:33', '0', '2018-07-26 15:37:33', null, '2018-07-26 15:37:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('106', '25', '2', '', '2018-07-03 15:40:09', '0', '2018-07-26 15:40:09', null, '2018-07-26 15:40:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('107', '25', '3', '', '2018-07-18 15:40:25', '0', '2018-07-26 15:40:25', null, '2018-07-26 15:40:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('108', '25', '5', '', '2018-07-19 15:40:33', '0', '2018-07-26 15:40:33', null, '2018-07-26 15:40:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('109', '25', '6', '', '2018-07-20 15:41:15', '0', '2018-07-26 15:41:15', null, '2018-07-26 15:41:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('110', '25', '8', 'Iniciando etapa de aprobacion', '2018-07-26 15:41:16', '0', '2018-07-26 15:41:16', null, '2018-07-26 15:41:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('111', '25', '9', 'Proyecto por enviar', '2018-07-26 15:41:17', '0', '2018-07-26 15:41:17', null, '2018-07-26 15:41:17', null);
INSERT INTO `wfl_project_status_log` VALUES ('112', '24', '2', '', '2018-07-03 15:42:16', '0', '2018-07-26 15:42:16', null, '2018-07-26 15:42:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('113', '24', '3', '', '2018-07-19 15:42:31', '0', '2018-07-26 15:42:31', null, '2018-07-26 15:42:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('114', '24', '5', '', '2018-07-20 15:42:37', '0', '2018-07-26 15:42:37', null, '2018-07-26 15:42:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('115', '24', '6', '', '2018-07-23 15:43:01', '0', '2018-07-26 15:43:01', null, '2018-07-26 15:43:01', null);
INSERT INTO `wfl_project_status_log` VALUES ('116', '24', '8', 'Iniciando etapa de aprobacion', '2018-07-26 15:43:02', '0', '2018-07-26 15:43:02', null, '2018-07-26 15:43:02', null);
INSERT INTO `wfl_project_status_log` VALUES ('117', '24', '9', 'Proyecto por enviar', '2018-07-26 15:43:03', '0', '2018-07-26 15:43:03', null, '2018-07-26 15:43:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('118', '23', '2', '', '2018-07-03 15:43:51', '0', '2018-07-26 15:43:51', null, '2018-07-26 15:43:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('119', '23', '3', '', '2018-07-13 15:44:09', '0', '2018-07-26 15:44:09', null, '2018-07-26 15:44:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('120', '23', '5', '', '2018-07-14 15:44:39', '0', '2018-07-26 15:44:39', null, '2018-07-26 15:44:39', null);
INSERT INTO `wfl_project_status_log` VALUES ('121', '23', '6', '', '2018-07-19 15:45:04', '0', '2018-07-26 15:45:04', null, '2018-07-26 15:45:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('122', '23', '8', 'Iniciando etapa de aprobacion', '2018-07-26 15:45:05', '0', '2018-07-26 15:45:05', null, '2018-07-26 15:45:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('123', '23', '9', 'Proyecto por enviar', '2018-07-26 15:45:06', '0', '2018-07-26 15:45:06', null, '2018-07-26 15:45:06', null);
INSERT INTO `wfl_project_status_log` VALUES ('124', '22', '2', '', '2018-07-03 15:46:08', '0', '2018-07-26 15:46:08', null, '2018-07-26 15:46:08', null);
INSERT INTO `wfl_project_status_log` VALUES ('125', '22', '3', '', '2018-07-16 15:46:20', '0', '2018-07-26 15:46:20', null, '2018-07-26 15:46:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('126', '22', '5', '', '2018-07-17 15:46:38', '0', '2018-07-26 15:46:38', null, '2018-07-26 15:46:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('127', '22', '6', '', '2018-07-20 15:47:03', '0', '2018-07-26 15:47:03', null, '2018-07-26 15:47:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('128', '22', '8', 'Iniciando etapa de aprobacion', '2018-07-26 15:47:04', '0', '2018-07-26 15:47:04', null, '2018-07-26 15:47:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('129', '22', '9', 'Proyecto por enviar', '2018-07-26 15:47:05', '0', '2018-07-26 15:47:05', null, '2018-07-26 15:47:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('130', '21', '2', '', '2018-07-03 15:48:04', '0', '2018-07-26 15:48:04', null, '2018-07-26 15:48:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('131', '21', '3', '', '2018-07-16 15:48:15', '0', '2018-07-26 15:48:15', null, '2018-07-26 15:48:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('132', '21', '5', '', '2018-07-17 15:48:22', '0', '2018-07-26 15:48:22', null, '2018-07-26 15:48:22', null);
INSERT INTO `wfl_project_status_log` VALUES ('133', '21', '6', '', '2018-07-19 15:49:12', '0', '2018-07-26 15:49:12', null, '2018-07-26 15:49:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('134', '21', '8', 'Iniciando etapa de aprobacion', '2018-07-26 15:49:13', '0', '2018-07-26 15:49:13', null, '2018-07-26 15:49:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('135', '21', '9', 'Proyecto por enviar', '2018-07-26 15:49:14', '0', '2018-07-26 15:49:14', null, '2018-07-26 15:49:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('136', '20', '2', '', '2018-07-03 15:49:42', '0', '2018-07-26 15:49:42', null, '2018-07-26 15:49:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('137', '20', '3', '', '2018-07-18 15:49:55', '0', '2018-07-26 15:49:55', null, '2018-07-26 15:49:55', null);
INSERT INTO `wfl_project_status_log` VALUES ('138', '20', '5', '', '2018-07-19 15:50:04', '0', '2018-07-26 15:50:04', null, '2018-07-26 15:50:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('139', '20', '6', '', '2018-07-19 15:50:34', '0', '2018-07-26 15:50:34', null, '2018-07-26 15:50:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('140', '20', '8', 'Iniciando etapa de aprobacion', '2018-07-26 15:50:35', '0', '2018-07-26 15:50:35', null, '2018-07-26 15:50:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('141', '20', '9', 'Proyecto por enviar', '2018-07-26 15:50:36', '0', '2018-07-26 15:50:36', null, '2018-07-26 15:50:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('142', '26', '1', 'Proyecto enviado a diseño', '2018-07-26 07:55:54', '0', '2018-07-27 07:55:54', null, '2018-07-27 07:55:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('143', '27', '1', 'Proyecto enviado a diseño', '2018-07-26 08:04:32', '0', '2018-07-27 08:04:32', null, '2018-07-27 08:04:32', null);
INSERT INTO `wfl_project_status_log` VALUES ('144', '28', '1', 'Proyecto enviado a diseño', '2018-07-26 08:05:32', '0', '2018-07-27 08:05:32', null, '2018-07-27 08:05:32', null);
INSERT INTO `wfl_project_status_log` VALUES ('145', '29', '1', 'Proyecto enviado a diseño', '2018-07-26 08:06:33', '0', '2018-07-27 08:06:33', null, '2018-07-27 08:06:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('146', '30', '1', 'Proyecto enviado a diseño', '2018-07-26 08:13:08', '0', '2018-07-27 08:13:08', null, '2018-07-27 08:13:08', null);
INSERT INTO `wfl_project_status_log` VALUES ('147', '31', '1', 'Proyecto enviado a diseño', '2018-07-26 08:14:35', '0', '2018-07-27 08:14:35', null, '2018-07-27 08:14:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('148', '32', '1', 'Proyecto enviado a diseño', '2018-07-26 08:15:50', '0', '2018-07-27 08:15:50', null, '2018-07-27 08:15:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('149', '33', '1', 'Proyecto enviado a diseño', '2018-07-26 08:17:33', '0', '2018-07-27 08:17:33', null, '2018-07-27 08:17:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('150', '34', '1', 'Proyecto enviado a diseño', '2018-07-26 08:20:47', '0', '2018-07-27 08:20:47', null, '2018-07-27 08:20:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('151', '35', '1', 'Proyecto enviado a diseño', '2018-07-26 08:22:02', '0', '2018-07-27 08:22:02', null, '2018-07-27 08:22:02', null);
INSERT INTO `wfl_project_status_log` VALUES ('152', '36', '1', 'Proyecto enviado a diseño', '2018-07-26 08:23:47', '0', '2018-07-27 08:23:47', null, '2018-07-27 08:23:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('153', '37', '1', 'Proyecto enviado a diseño', '2018-07-26 08:24:56', '0', '2018-07-27 08:24:56', null, '2018-07-27 08:24:56', null);
INSERT INTO `wfl_project_status_log` VALUES ('154', '38', '1', 'Proyecto enviado a diseño', '2018-07-26 08:26:25', '0', '2018-07-27 08:26:25', null, '2018-07-27 08:26:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('155', '39', '1', 'Proyecto enviado a diseño', '2018-07-26 08:27:45', '0', '2018-07-27 08:27:45', null, '2018-07-27 08:27:45', null);
INSERT INTO `wfl_project_status_log` VALUES ('156', '40', '1', 'Proyecto enviado a diseño', '2018-07-26 08:28:52', '0', '2018-07-27 08:28:52', null, '2018-07-27 08:28:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('157', '41', '1', 'Proyecto enviado a diseño', '2018-07-26 08:30:19', '0', '2018-07-27 08:30:19', null, '2018-07-27 08:30:19', null);
INSERT INTO `wfl_project_status_log` VALUES ('158', '42', '1', 'Proyecto enviado a diseño', '2018-07-26 08:31:48', '0', '2018-07-27 08:31:48', null, '2018-07-27 08:31:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('159', '43', '1', 'Proyecto enviado a diseño', '2018-07-26 08:33:16', '0', '2018-07-27 08:33:16', null, '2018-07-27 08:33:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('160', '44', '1', 'Proyecto enviado a diseño', '2018-07-26 08:34:03', '0', '2018-07-27 08:34:03', null, '2018-07-27 08:34:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('161', '45', '1', 'Proyecto enviado a diseño', '2018-07-26 08:35:19', '0', '2018-07-27 08:35:19', null, '2018-07-27 08:35:19', null);
INSERT INTO `wfl_project_status_log` VALUES ('162', '46', '1', 'Proyecto enviado a diseño', '2018-07-26 08:37:27', '0', '2018-07-27 08:37:27', null, '2018-07-27 08:37:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('163', '2', '6', '', '2018-07-27 09:24:32', '0', '2018-07-27 09:24:32', null, '2018-07-27 09:24:32', null);
INSERT INTO `wfl_project_status_log` VALUES ('164', '2', '8', 'Iniciando etapa de aprobacion', '2018-07-27 09:24:33', '0', '2018-07-27 09:24:33', null, '2018-07-27 09:24:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('165', '2', '9', 'Proyecto por enviar', '2018-07-27 09:24:34', '0', '2018-07-27 09:24:34', null, '2018-07-27 09:24:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('166', '47', '1', 'Proyecto enviado a diseño', '2018-04-26 11:13:34', '0', '2018-07-27 11:13:34', null, '2018-07-27 11:13:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('167', '47', '2', '', '2018-04-27 11:14:21', '0', '2018-07-27 11:14:21', null, '2018-07-27 11:14:21', null);
INSERT INTO `wfl_project_status_log` VALUES ('168', '47', '3', '', '2018-05-15 11:14:37', '0', '2018-07-27 11:14:37', null, '2018-07-27 11:14:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('169', '47', '5', '', '2018-05-15 11:15:03', '0', '2018-07-27 11:15:03', null, '2018-07-27 11:15:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('170', '47', '6', '', '2018-05-18 11:15:34', '0', '2018-07-27 11:15:34', null, '2018-07-27 11:15:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('171', '47', '8', 'Iniciando etapa de aprobacion', '2018-07-27 11:15:35', '0', '2018-07-27 11:15:35', null, '2018-07-27 11:15:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('172', '47', '9', 'Proyecto por enviar', '2018-07-27 11:15:36', '0', '2018-07-27 11:15:36', null, '2018-07-27 11:15:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('173', '48', '1', 'Proyecto enviado a diseño', '2018-07-06 08:28:28', '0', '2018-07-28 08:28:28', null, '2018-07-28 08:28:28', null);
INSERT INTO `wfl_project_status_log` VALUES ('174', '48', '2', '', '2018-07-09 08:29:44', '0', '2018-07-28 08:29:44', null, '2018-07-28 08:29:44', null);
INSERT INTO `wfl_project_status_log` VALUES ('175', '48', '3', '', '2018-07-18 08:30:30', '0', '2018-07-28 08:30:30', null, '2018-07-28 08:30:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('176', '49', '1', 'Proyecto enviado a diseño', '2018-07-03 10:11:31', '0', '2018-07-28 10:11:31', null, '2018-07-28 10:11:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('177', '50', '1', 'Proyecto enviado a diseño', '2018-07-21 10:15:09', '0', '2018-07-28 10:15:09', null, '2018-07-28 10:15:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('178', '51', '1', 'Proyecto enviado a diseño', '2018-07-21 10:17:08', '0', '2018-07-28 10:17:08', null, '2018-07-28 10:17:08', null);
INSERT INTO `wfl_project_status_log` VALUES ('179', '49', '2', '', '2018-07-03 10:19:33', '0', '2018-07-28 10:19:33', null, '2018-07-28 10:19:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('180', '50', '2', '', '2018-07-23 10:20:12', '0', '2018-07-28 10:20:12', null, '2018-07-28 10:20:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('181', '51', '2', '', '2018-07-23 10:20:46', '0', '2018-07-28 10:20:46', null, '2018-07-28 10:20:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('182', '4', '2', '', '2018-07-30 08:09:01', '0', '2018-07-30 08:09:01', null, '2018-07-30 08:09:01', null);
INSERT INTO `wfl_project_status_log` VALUES ('183', '5', '2', '', '2018-07-30 08:09:27', '0', '2018-07-30 08:09:27', null, '2018-07-30 08:09:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('184', '52', '1', 'Proyecto enviado a diseño', '2017-11-14 08:49:20', '0', '2018-07-30 08:49:20', null, '2018-07-30 08:49:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('185', '53', '1', 'Proyecto enviado a diseño', '2017-11-14 08:50:04', '0', '2018-07-30 08:50:04', null, '2018-07-30 08:50:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('186', '53', '2', '', '2018-04-17 08:51:11', '0', '2018-07-30 08:51:11', null, '2018-07-30 08:51:11', null);
INSERT INTO `wfl_project_status_log` VALUES ('187', '52', '2', '', '2018-04-17 08:51:44', '0', '2018-07-30 08:51:44', null, '2018-07-30 08:51:44', null);
INSERT INTO `wfl_project_status_log` VALUES ('188', '52', '2', '', '2018-05-15 08:52:09', '0', '2018-07-30 08:52:09', null, '2018-07-30 08:52:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('189', '53', '2', '', '2018-05-15 08:52:31', '0', '2018-07-30 08:52:31', null, '2018-07-30 08:52:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('190', '4', '3', '', '2018-07-30 14:59:03', '0', '2018-07-30 14:59:03', null, '2018-07-30 14:59:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('191', '5', '3', '', '2018-07-30 14:59:15', '0', '2018-07-30 14:59:15', null, '2018-07-30 14:59:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('192', '52', '2', 'Se hizo la devolución a la C.R.E.', '2018-07-30 17:05:21', '0', '2018-07-30 17:05:21', null, '2018-07-30 17:05:21', null);
INSERT INTO `wfl_project_status_log` VALUES ('193', '5', '5', '', '2018-07-31 09:54:29', '0', '2018-07-31 09:54:29', null, '2018-07-31 09:54:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('194', '5', '6', '', '2018-07-31 09:55:52', '0', '2018-07-31 09:55:52', null, '2018-07-31 09:55:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('195', '5', '8', 'Iniciando etapa de aprobacion', '2018-07-31 09:55:54', '0', '2018-07-31 09:55:54', null, '2018-07-31 09:55:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('196', '5', '9', 'Proyecto por enviar', '2018-07-31 09:55:55', '0', '2018-07-31 09:55:55', null, '2018-07-31 09:55:55', null);
INSERT INTO `wfl_project_status_log` VALUES ('197', '4', '5', '', '2018-07-31 09:56:26', '0', '2018-07-31 09:56:26', null, '2018-07-31 09:56:26', null);
INSERT INTO `wfl_project_status_log` VALUES ('198', '4', '6', '', '2018-07-31 09:56:41', '0', '2018-07-31 09:56:41', null, '2018-07-31 09:56:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('199', '4', '8', 'Iniciando etapa de aprobacion', '2018-07-31 09:56:42', '0', '2018-07-31 09:56:42', null, '2018-07-31 09:56:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('200', '4', '9', 'Proyecto por enviar', '2018-07-31 09:56:43', '0', '2018-07-31 09:56:43', null, '2018-07-31 09:56:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('201', '54', '1', 'Proyecto enviado a diseño', '2018-07-31 15:52:34', '0', '2018-07-31 15:52:34', null, '2018-07-31 15:52:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('202', '55', '1', 'Proyecto enviado a diseño', '2018-07-31 15:53:48', '0', '2018-07-31 15:53:48', null, '2018-07-31 15:53:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('203', '50', '3', '', '2018-08-01 08:13:16', '0', '2018-08-01 08:13:16', null, '2018-08-01 08:13:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('204', '8', '3', '', '2018-08-01 08:13:27', '0', '2018-08-01 08:13:27', null, '2018-08-01 08:13:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('205', '8', '5', '', '2018-08-01 14:22:15', '0', '2018-08-01 14:22:15', null, '2018-08-01 14:22:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('206', '50', '5', '', '2018-08-01 14:22:24', '0', '2018-08-01 14:22:24', null, '2018-08-01 14:22:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('207', '48', '5', '', '2018-08-01 14:22:46', '0', '2018-08-01 14:22:46', null, '2018-08-01 14:22:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('208', '8', '6', '', '2018-08-01 15:14:53', '0', '2018-08-01 15:14:53', null, '2018-08-01 15:14:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('209', '8', '8', 'Iniciando etapa de aprobacion', '2018-08-01 15:14:54', '0', '2018-08-01 15:14:53', null, '2018-08-01 15:14:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('210', '8', '9', 'Proyecto por enviar', '2018-08-01 15:14:56', '0', '2018-08-01 15:14:53', null, '2018-08-01 15:14:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('211', '53', '3', '', '0000-00-00 00:00:00', '0', '2018-08-01 16:19:38', null, '2018-08-01 16:19:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('212', '53', '3', '', '2018-08-01 11:05:24', '0', '2018-08-02 11:05:24', null, '2018-08-02 11:05:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('213', '53', '3', '', '2018-08-01 11:11:15', '0', '2018-08-02 11:11:15', null, '2018-08-02 11:11:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('214', '56', '1', 'Proyecto enviado a diseño', '2018-06-05 14:27:42', '0', '2018-08-02 14:27:42', null, '2018-08-02 14:27:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('215', '57', '1', 'Proyecto enviado a diseño', '2018-08-02 14:31:29', '0', '2018-08-02 14:31:29', null, '2018-08-02 14:31:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('216', '58', '1', 'Proyecto enviado a diseño', '2018-06-05 14:33:03', '0', '2018-08-02 14:33:03', null, '2018-08-02 14:33:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('217', '59', '1', 'Proyecto enviado a diseño', '2018-06-05 14:34:46', '0', '2018-08-02 14:34:46', null, '2018-08-02 14:34:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('218', '60', '1', 'Proyecto enviado a diseño', '2018-06-05 14:36:35', '0', '2018-08-02 14:36:35', null, '2018-08-02 14:36:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('219', '61', '1', 'Proyecto enviado a diseño', '2018-08-11 14:38:36', '0', '2018-08-02 14:38:36', null, '2018-08-02 14:38:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('220', '62', '1', 'Proyecto enviado a diseño', '2018-06-11 14:40:38', '0', '2018-08-02 14:40:38', null, '2018-08-02 14:40:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('221', '63', '1', 'Proyecto enviado a diseño', '2018-06-11 14:42:24', '0', '2018-08-02 14:42:24', null, '2018-08-02 14:42:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('222', '64', '1', 'Proyecto enviado a diseño', '2018-06-11 14:43:56', '0', '2018-08-02 14:43:56', null, '2018-08-02 14:43:56', null);
INSERT INTO `wfl_project_status_log` VALUES ('223', '65', '1', 'Proyecto enviado a diseño', '2018-06-26 14:59:08', '0', '2018-08-02 14:59:08', null, '2018-08-02 14:59:08', null);
INSERT INTO `wfl_project_status_log` VALUES ('224', '66', '1', 'Proyecto enviado a diseño', '2018-06-26 15:00:30', '0', '2018-08-02 15:00:30', null, '2018-08-02 15:00:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('225', '67', '1', 'Proyecto enviado a diseño', '2018-06-12 15:02:03', '0', '2018-08-02 15:02:03', null, '2018-08-02 15:02:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('226', '56', '2', '', '2018-06-27 15:04:52', '0', '2018-08-02 15:04:52', null, '2018-08-02 15:04:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('227', '56', '3', '', '2018-06-29 15:05:09', '0', '2018-08-02 15:05:09', null, '2018-08-02 15:05:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('228', '56', '5', '', '2018-06-29 15:05:16', '0', '2018-08-02 15:05:16', null, '2018-08-02 15:05:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('229', '56', '6', '', '2018-07-02 15:09:03', '0', '2018-08-02 15:09:03', null, '2018-08-02 15:09:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('230', '56', '8', 'Iniciando etapa de aprobacion', '2018-07-02 15:09:04', '0', '2018-08-02 15:09:03', null, '2018-08-02 15:09:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('231', '56', '9', 'Proyecto por enviar', '2018-07-02 15:09:06', '0', '2018-08-02 15:09:03', null, '2018-08-02 15:09:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('232', '66', '2', '', '2018-06-27 15:11:30', '0', '2018-08-02 15:11:30', null, '2018-08-02 15:11:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('233', '66', '3', '', '2018-07-14 15:11:46', '0', '2018-08-02 15:11:46', null, '2018-08-02 15:11:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('234', '66', '5', '', '2018-07-15 15:11:53', '0', '2018-08-02 15:11:53', null, '2018-08-02 15:11:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('235', '66', '6', '', '2018-07-21 15:13:09', '0', '2018-08-02 15:13:09', null, '2018-08-02 15:13:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('236', '66', '8', 'Iniciando etapa de aprobacion', '2018-07-21 15:13:10', '0', '2018-08-02 15:13:09', null, '2018-08-02 15:13:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('237', '66', '9', 'Proyecto por enviar', '2018-07-21 15:13:12', '0', '2018-08-02 15:13:09', null, '2018-08-02 15:13:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('238', '67', '2', '', '2018-06-27 15:16:20', '0', '2018-08-02 15:16:20', null, '2018-08-02 15:16:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('239', '67', '3', '', '2018-06-29 15:16:34', '0', '2018-08-02 15:16:34', null, '2018-08-02 15:16:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('240', '67', '5', '', '2018-06-30 15:16:43', '0', '2018-08-02 15:16:43', null, '2018-08-02 15:16:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('241', '67', '6', '', '2018-07-02 15:17:03', '0', '2018-08-02 15:17:03', null, '2018-08-02 15:17:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('242', '67', '8', 'Iniciando etapa de aprobacion', '2018-07-02 15:17:04', '0', '2018-08-02 15:17:03', null, '2018-08-02 15:17:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('243', '67', '9', 'Proyecto por enviar', '2018-07-02 15:17:06', '0', '2018-08-02 15:17:03', null, '2018-08-02 15:17:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('244', '65', '2', '', '2018-06-27 15:19:05', '0', '2018-08-02 15:19:05', null, '2018-08-02 15:19:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('245', '65', '3', '', '2018-07-13 15:19:18', '0', '2018-08-02 15:19:18', null, '2018-08-02 15:19:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('246', '65', '5', '', '2018-07-14 15:19:25', '0', '2018-08-02 15:19:25', null, '2018-08-02 15:19:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('247', '65', '6', '', '2018-07-19 15:21:40', '0', '2018-08-02 15:21:40', null, '2018-08-02 15:21:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('248', '65', '8', 'Iniciando etapa de aprobacion', '2018-07-19 15:21:41', '0', '2018-08-02 15:21:40', null, '2018-08-02 15:21:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('249', '65', '9', 'Proyecto por enviar', '2018-07-19 15:21:43', '0', '2018-08-02 15:21:40', null, '2018-08-02 15:21:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('250', '64', '2', '', '2018-06-15 15:23:23', '0', '2018-08-02 15:23:23', null, '2018-08-02 15:23:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('251', '64', '3', '', '2018-06-18 15:23:31', '0', '2018-08-02 15:23:31', null, '2018-08-02 15:23:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('252', '64', '5', '', '2018-06-19 15:23:41', '0', '2018-08-02 15:23:41', null, '2018-08-02 15:23:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('253', '64', '6', '', '2018-06-20 15:24:03', '0', '2018-08-02 15:24:03', null, '2018-08-02 15:24:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('254', '64', '8', 'Iniciando etapa de aprobacion', '2018-06-20 15:24:04', '0', '2018-08-02 15:24:03', null, '2018-08-02 15:24:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('255', '64', '9', 'Proyecto por enviar', '2018-06-20 15:24:06', '0', '2018-08-02 15:24:03', null, '2018-08-02 15:24:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('256', '63', '2', '', '2018-06-18 15:25:32', '0', '2018-08-02 15:25:32', null, '2018-08-02 15:25:32', null);
INSERT INTO `wfl_project_status_log` VALUES ('257', '63', '3', '', '2018-06-20 15:25:45', '0', '2018-08-02 15:25:45', null, '2018-08-02 15:25:45', null);
INSERT INTO `wfl_project_status_log` VALUES ('258', '63', '5', '', '2018-06-21 15:25:53', '0', '2018-08-02 15:25:53', null, '2018-08-02 15:25:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('259', '63', '6', '', '2018-06-26 15:26:49', '0', '2018-08-02 15:26:49', null, '2018-08-02 15:26:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('260', '63', '8', 'Iniciando etapa de aprobacion', '2018-06-26 15:26:50', '0', '2018-08-02 15:26:49', null, '2018-08-02 15:26:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('261', '63', '9', 'Proyecto por enviar', '2018-06-26 15:26:52', '0', '2018-08-02 15:26:49', null, '2018-08-02 15:26:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('262', '61', '2', '', '2018-06-12 15:28:05', '0', '2018-08-02 15:28:05', null, '2018-08-02 15:28:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('263', '61', '3', '', '2018-06-19 15:28:14', '0', '2018-08-02 15:28:14', null, '2018-08-02 15:28:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('264', '61', '5', '', '2018-06-20 15:28:25', '0', '2018-08-02 15:28:25', null, '2018-08-02 15:28:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('265', '61', '6', '', '2018-06-20 15:28:46', '0', '2018-08-02 15:28:46', null, '2018-08-02 15:28:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('266', '61', '8', 'Iniciando etapa de aprobacion', '2018-06-20 15:28:47', '0', '2018-08-02 15:28:46', null, '2018-08-02 15:28:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('267', '61', '9', 'Proyecto por enviar', '2018-06-20 15:28:49', '0', '2018-08-02 15:28:46', null, '2018-08-02 15:28:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('268', '60', '2', '', '2018-06-06 15:30:16', '0', '2018-08-02 15:30:16', null, '2018-08-02 15:30:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('269', '60', '3', '', '2018-06-14 15:30:25', '0', '2018-08-02 15:30:25', null, '2018-08-02 15:30:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('270', '60', '5', '', '2018-06-15 15:30:32', '0', '2018-08-02 15:30:32', null, '2018-08-02 15:30:32', null);
INSERT INTO `wfl_project_status_log` VALUES ('271', '60', '6', '', '2018-06-20 15:31:14', '0', '2018-08-02 15:31:14', null, '2018-08-02 15:31:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('272', '60', '8', 'Iniciando etapa de aprobacion', '2018-06-20 15:31:15', '0', '2018-08-02 15:31:14', null, '2018-08-02 15:31:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('273', '60', '9', 'Proyecto por enviar', '2018-06-20 15:31:17', '0', '2018-08-02 15:31:14', null, '2018-08-02 15:31:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('274', '58', '2', '', '2018-06-06 15:35:37', '0', '2018-08-02 15:35:37', null, '2018-08-02 15:35:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('275', '58', '3', '', '2018-06-14 15:35:44', '0', '2018-08-02 15:35:44', null, '2018-08-02 15:35:44', null);
INSERT INTO `wfl_project_status_log` VALUES ('276', '58', '5', '', '2018-06-15 15:35:50', '0', '2018-08-02 15:35:50', null, '2018-08-02 15:35:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('277', '58', '6', '', '2018-06-20 15:36:23', '0', '2018-08-02 15:36:23', null, '2018-08-02 15:36:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('278', '58', '8', 'Iniciando etapa de aprobacion', '2018-06-20 15:36:24', '0', '2018-08-02 15:36:23', null, '2018-08-02 15:36:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('279', '58', '9', 'Proyecto por enviar', '2018-06-20 15:36:26', '0', '2018-08-02 15:36:23', null, '2018-08-02 15:36:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('280', '59', '2', '', '2018-06-06 15:37:03', '0', '2018-08-02 15:37:03', null, '2018-08-02 15:37:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('281', '59', '3', '', '2018-06-08 15:37:11', '0', '2018-08-02 15:37:11', null, '2018-08-02 15:37:11', null);
INSERT INTO `wfl_project_status_log` VALUES ('282', '59', '5', '', '2018-06-09 15:37:18', '0', '2018-08-02 15:37:18', null, '2018-08-02 15:37:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('283', '59', '6', '', '2018-06-20 15:37:46', '0', '2018-08-02 15:37:46', null, '2018-08-02 15:37:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('284', '59', '8', 'Iniciando etapa de aprobacion', '2018-06-20 15:37:47', '0', '2018-08-02 15:37:46', null, '2018-08-02 15:37:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('285', '59', '9', 'Proyecto por enviar', '2018-06-20 15:37:49', '0', '2018-08-02 15:37:46', null, '2018-08-02 15:37:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('286', '68', '1', 'Proyecto enviado a diseño', '2018-06-05 15:41:54', '0', '2018-08-02 15:41:54', null, '2018-08-02 15:41:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('287', '68', '2', '', '2018-08-06 15:42:36', '0', '2018-08-02 15:42:36', null, '2018-08-02 15:42:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('288', '68', '3', '', '2018-06-14 15:42:43', '0', '2018-08-02 15:42:43', null, '2018-08-02 15:42:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('289', '68', '5', '', '2018-06-15 15:42:51', '0', '2018-08-02 15:42:51', null, '2018-08-02 15:42:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('290', '68', '6', '', '2018-06-20 15:43:18', '0', '2018-08-02 15:43:18', null, '2018-08-02 15:43:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('291', '68', '8', 'Iniciando etapa de aprobacion', '2018-06-20 15:43:19', '0', '2018-08-02 15:43:18', null, '2018-08-02 15:43:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('292', '68', '9', 'Proyecto por enviar', '2018-06-20 15:43:21', '0', '2018-08-02 15:43:18', null, '2018-08-02 15:43:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('293', '69', '1', 'Proyecto enviado a diseño', '2018-06-05 15:44:51', '0', '2018-08-02 15:44:51', null, '2018-08-02 15:44:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('294', '44', '2', '', '2018-06-06 15:45:21', '0', '2018-08-02 15:45:21', null, '2018-08-02 15:45:21', null);
INSERT INTO `wfl_project_status_log` VALUES ('295', '44', '3', '', '2018-06-08 15:45:29', '0', '2018-08-02 15:45:29', null, '2018-08-02 15:45:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('296', '44', '5', '', '2018-06-11 15:45:37', '0', '2018-08-02 15:45:37', null, '2018-08-02 15:45:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('297', '44', '6', '', '2018-06-20 15:45:57', '0', '2018-08-02 15:45:57', null, '2018-08-02 15:45:57', null);
INSERT INTO `wfl_project_status_log` VALUES ('298', '44', '8', 'Iniciando etapa de aprobacion', '2018-06-20 15:45:58', '0', '2018-08-02 15:45:57', null, '2018-08-02 15:45:57', null);
INSERT INTO `wfl_project_status_log` VALUES ('299', '44', '9', 'Proyecto por enviar', '2018-06-20 15:46:00', '0', '2018-08-02 15:45:57', null, '2018-08-02 15:45:57', null);
INSERT INTO `wfl_project_status_log` VALUES ('300', '69', '2', '', '2018-06-06 15:48:05', '0', '2018-08-02 15:48:05', null, '2018-08-02 15:48:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('301', '69', '3', '', '2018-06-08 15:48:13', '0', '2018-08-02 15:48:13', null, '2018-08-02 15:48:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('302', '69', '5', '', '2018-06-11 15:48:22', '0', '2018-08-02 15:48:22', null, '2018-08-02 15:48:22', null);
INSERT INTO `wfl_project_status_log` VALUES ('303', '69', '6', '', '2018-06-20 15:48:39', '0', '2018-08-02 15:48:39', null, '2018-08-02 15:48:39', null);
INSERT INTO `wfl_project_status_log` VALUES ('304', '69', '8', 'Iniciando etapa de aprobacion', '2018-06-20 15:48:40', '0', '2018-08-02 15:48:40', null, '2018-08-02 15:48:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('305', '69', '9', 'Proyecto por enviar', '2018-06-20 15:48:42', '0', '2018-08-02 15:48:40', null, '2018-08-02 15:48:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('306', '70', '1', 'Proyecto enviado a diseño', '2018-07-12 16:41:46', '0', '2018-08-02 16:41:46', null, '2018-08-02 16:41:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('307', '71', '1', 'Proyecto enviado a diseño', '2018-07-13 16:42:46', '0', '2018-08-02 16:42:46', null, '2018-08-02 16:42:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('308', '72', '1', 'Proyecto enviado a diseño', '2018-07-13 16:44:23', '0', '2018-08-02 16:44:23', null, '2018-08-02 16:44:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('309', '72', '2', '', '2018-07-16 16:45:00', '0', '2018-08-02 16:45:00', null, '2018-08-02 16:45:00', null);
INSERT INTO `wfl_project_status_log` VALUES ('310', '72', '3', '', '2018-07-18 16:45:10', '0', '2018-08-02 16:45:10', null, '2018-08-02 16:45:10', null);
INSERT INTO `wfl_project_status_log` VALUES ('311', '72', '5', '', '2018-07-19 16:45:21', '0', '2018-08-02 16:45:21', null, '2018-08-02 16:45:21', null);
INSERT INTO `wfl_project_status_log` VALUES ('312', '72', '6', '', '2018-07-19 16:45:36', '0', '2018-08-02 16:45:36', null, '2018-08-02 16:45:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('313', '72', '8', 'Iniciando etapa de aprobacion', '2018-07-19 16:45:37', '0', '2018-08-02 16:45:36', null, '2018-08-02 16:45:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('314', '72', '9', 'Proyecto por enviar', '2018-07-19 16:45:39', '0', '2018-08-02 16:45:36', null, '2018-08-02 16:45:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('315', '70', '2', '', '2018-07-12 16:46:56', '0', '2018-08-02 16:46:56', null, '2018-08-02 16:46:56', null);
INSERT INTO `wfl_project_status_log` VALUES ('316', '70', '3', '', '2018-07-13 16:47:09', '0', '2018-08-02 16:47:09', null, '2018-08-02 16:47:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('317', '70', '5', '', '2018-07-13 16:47:17', '0', '2018-08-02 16:47:17', null, '2018-08-02 16:47:17', null);
INSERT INTO `wfl_project_status_log` VALUES ('318', '70', '6', '', '2018-07-13 16:47:42', '0', '2018-08-02 16:47:42', null, '2018-08-02 16:47:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('319', '70', '8', 'Iniciando etapa de aprobacion', '2018-07-13 16:47:43', '0', '2018-08-02 16:47:42', null, '2018-08-02 16:47:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('320', '70', '9', 'Proyecto por enviar', '2018-07-13 16:47:45', '0', '2018-08-02 16:47:42', null, '2018-08-02 16:47:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('321', '53', '5', '', '2018-08-03 11:00:54', '0', '2018-08-03 11:00:54', null, '2018-08-03 11:00:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('322', '73', '1', 'Proyecto enviado a diseño', '2018-08-03 11:41:46', '0', '2018-08-03 11:41:46', null, '2018-08-03 11:41:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('323', '74', '1', 'Proyecto enviado a diseño', '2018-06-11 08:14:51', '0', '2018-08-04 08:14:51', null, '2018-08-04 08:14:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('324', '74', '2', '', '2018-06-12 08:15:29', '0', '2018-08-04 08:15:29', null, '2018-08-04 08:15:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('325', '74', '3', '', '2018-06-19 08:15:42', '0', '2018-08-04 08:15:42', null, '2018-08-04 08:15:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('326', '74', '5', '', '2018-06-19 08:15:51', '0', '2018-08-04 08:15:51', null, '2018-08-04 08:15:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('327', '74', '6', '', '2018-08-20 08:16:35', '0', '2018-08-04 08:16:35', null, '2018-08-04 08:16:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('328', '74', '8', 'Iniciando etapa de aprobacion', '2018-08-20 08:16:36', '0', '2018-08-04 08:16:35', null, '2018-08-04 08:16:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('329', '74', '9', 'Proyecto por enviar', '2018-08-20 08:16:38', '0', '2018-08-04 08:16:35', null, '2018-08-04 08:16:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('330', '8', '10', '', '2018-08-01 09:35:02', '0', '2018-08-04 09:35:02', null, '2018-08-04 09:35:02', null);
INSERT INTO `wfl_project_status_log` VALUES ('331', '21', '10', '', '2018-07-20 09:36:12', '0', '2018-08-04 09:36:12', null, '2018-08-04 09:36:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('332', '22', '10', '', '2018-07-20 09:36:35', '0', '2018-08-04 09:36:35', null, '2018-08-04 09:36:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('333', '23', '10', '', '2018-07-20 09:36:51', '0', '2018-08-04 09:36:51', null, '2018-08-04 09:36:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('334', '24', '10', '', '2018-07-24 09:37:15', '0', '2018-08-04 09:37:15', null, '2018-08-04 09:37:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('335', '25', '10', '', '2018-07-20 09:37:36', '0', '2018-08-04 09:37:36', null, '2018-08-04 09:37:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('336', '20', '10', '', '2018-07-20 09:37:55', '0', '2018-08-04 09:37:55', null, '2018-08-04 09:37:55', null);
INSERT INTO `wfl_project_status_log` VALUES ('337', '7', '10', '', '2018-07-20 09:38:25', '0', '2018-08-04 09:38:25', null, '2018-08-04 09:38:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('338', '2', '10', '', '2018-07-27 09:40:42', '0', '2018-08-04 09:40:42', null, '2018-08-04 09:40:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('339', '5', '10', '', '2018-07-31 09:41:11', '0', '2018-08-04 09:41:11', null, '2018-08-04 09:41:11', null);
INSERT INTO `wfl_project_status_log` VALUES ('340', '4', '10', '', '2018-07-31 09:41:27', '0', '2018-08-04 09:41:27', null, '2018-08-04 09:41:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('341', '47', '10', '', '2018-04-10 09:42:34', '0', '2018-08-04 09:42:34', null, '2018-08-04 09:42:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('342', '66', '10', '', '2018-07-21 09:43:29', '0', '2018-08-04 09:43:29', null, '2018-08-04 09:43:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('343', '74', '10', '', '2018-08-20 09:44:01', '0', '2018-08-04 09:44:01', null, '2018-08-04 09:44:01', null);
INSERT INTO `wfl_project_status_log` VALUES ('344', '72', '10', '', '2018-07-19 09:44:29', '0', '2018-08-04 09:44:29', null, '2018-08-04 09:44:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('345', '70', '10', '', '2018-07-13 09:46:45', '0', '2018-08-04 09:46:45', null, '2018-08-04 09:46:45', null);
INSERT INTO `wfl_project_status_log` VALUES ('346', '67', '10', '', '2018-07-02 09:47:33', '0', '2018-08-04 09:47:33', null, '2018-08-04 09:47:33', null);
INSERT INTO `wfl_project_status_log` VALUES ('347', '63', '10', '', '2018-06-26 09:48:15', '0', '2018-08-04 09:48:15', null, '2018-08-04 09:48:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('348', '69', '10', '', '2018-05-21 09:50:00', '0', '2018-08-04 09:50:00', null, '2018-08-04 09:50:00', null);
INSERT INTO `wfl_project_status_log` VALUES ('349', '59', '10', '', '2018-06-20 09:50:25', '0', '2018-08-04 09:50:25', null, '2018-08-04 09:50:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('350', '58', '10', '', '2018-06-20 09:50:52', '0', '2018-08-04 09:50:52', null, '2018-08-04 09:50:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('351', '60', '10', '', '2018-06-20 09:51:14', '0', '2018-08-04 09:51:14', null, '2018-08-04 09:51:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('352', '16', '10', '', '2018-07-25 09:52:17', '0', '2018-08-04 09:52:17', null, '2018-08-04 09:52:17', null);
INSERT INTO `wfl_project_status_log` VALUES ('353', '11', '10', '', '2018-07-25 09:52:40', '0', '2018-08-04 09:52:40', null, '2018-08-04 09:52:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('354', '18', '10', '', '2018-07-03 09:53:00', '0', '2018-08-04 09:53:00', null, '2018-08-04 09:53:00', null);
INSERT INTO `wfl_project_status_log` VALUES ('355', '9', '10', '', '2018-07-20 09:53:14', '0', '2018-08-04 09:53:14', null, '2018-08-04 09:53:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('356', '17', '10', '', '2018-07-03 09:54:53', '0', '2018-08-04 09:54:53', null, '2018-08-04 09:54:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('357', '15', '10', '', '2018-07-10 09:55:09', '0', '2018-08-04 09:55:09', null, '2018-08-04 09:55:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('358', '12', '10', '', '2018-07-04 09:55:28', '0', '2018-08-04 09:55:28', null, '2018-08-04 09:55:28', null);
INSERT INTO `wfl_project_status_log` VALUES ('359', '13', '10', '', '2018-07-04 09:55:50', '0', '2018-08-04 09:55:50', null, '2018-08-04 09:55:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('360', '1', '3', '', '2018-08-07 08:17:10', '0', '2018-08-07 08:17:10', null, '2018-08-07 08:17:10', null);
INSERT INTO `wfl_project_status_log` VALUES ('361', '34', '2', '', '2018-08-07 09:18:52', '0', '2018-08-07 09:18:52', null, '2018-08-07 09:18:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('362', '40', '2', '', '2018-08-07 09:19:16', '0', '2018-08-07 09:19:16', null, '2018-08-07 09:19:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('363', '28', '2', '', '2018-08-07 09:19:34', '0', '2018-08-07 09:19:34', null, '2018-08-07 09:19:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('364', '38', '2', '', '2018-08-07 09:19:54', '0', '2018-08-07 09:19:54', null, '2018-08-07 09:19:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('365', '45', '2', '', '2018-08-07 09:20:11', '0', '2018-08-07 09:20:11', null, '2018-08-07 09:20:11', null);
INSERT INTO `wfl_project_status_log` VALUES ('366', '17', '11', '', '2018-07-20 10:01:05', '0', '2018-08-07 10:01:05', null, '2018-08-07 10:01:05', null);
INSERT INTO `wfl_project_status_log` VALUES ('367', '75', '1', 'Proyecto enviado a diseño', '2018-07-02 10:01:24', '0', '2018-08-07 10:01:24', null, '2018-08-07 10:01:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('368', '75', '2', '', '2018-07-03 10:02:01', '0', '2018-08-07 10:02:01', null, '2018-08-07 10:02:01', null);
INSERT INTO `wfl_project_status_log` VALUES ('369', '75', '3', '', '2018-07-07 10:02:17', '0', '2018-08-07 10:02:17', null, '2018-08-07 10:02:17', null);
INSERT INTO `wfl_project_status_log` VALUES ('370', '75', '5', '', '2018-07-07 10:02:25', '0', '2018-08-07 10:02:25', null, '2018-08-07 10:02:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('371', '75', '6', '', '2018-07-09 10:02:42', '0', '2018-08-07 10:02:42', null, '2018-08-07 10:02:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('372', '75', '8', 'Iniciando etapa de aprobacion', '2018-07-09 10:02:43', '0', '2018-08-07 10:02:42', null, '2018-08-07 10:02:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('373', '75', '9', 'Proyecto por enviar', '2018-07-09 10:02:45', '0', '2018-08-07 10:02:43', null, '2018-08-07 10:02:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('374', '15', '11', '', '2018-07-19 10:02:52', '0', '2018-08-07 10:02:52', null, '2018-08-07 10:02:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('375', '12', '11', '', '2018-07-18 10:04:25', '0', '2018-08-07 10:04:25', null, '2018-08-07 10:04:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('376', '13', '11', '', '2018-07-04 10:06:16', '0', '2018-08-07 10:06:16', null, '2018-08-07 10:06:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('377', '18', '11', '', '2018-07-20 10:10:14', '0', '2018-08-07 10:10:14', null, '2018-08-07 10:10:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('378', '16', '11', '', '2018-07-26 10:12:28', '0', '2018-08-07 10:12:28', null, '2018-08-07 10:12:28', null);
INSERT INTO `wfl_project_status_log` VALUES ('379', '13', '11', '', '2018-07-04 10:14:42', '0', '2018-08-07 10:14:42', null, '2018-08-07 10:14:42', null);
INSERT INTO `wfl_project_status_log` VALUES ('380', '12', '11', '', '2018-07-18 10:16:35', '0', '2018-08-07 10:16:35', null, '2018-08-07 10:16:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('381', '15', '11', '', '2018-07-19 10:18:51', '0', '2018-08-07 10:18:51', null, '2018-08-07 10:18:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('382', '17', '11', '', '2018-07-20 10:21:08', '0', '2018-08-07 10:21:08', null, '2018-08-07 10:21:08', null);
INSERT INTO `wfl_project_status_log` VALUES ('383', '53', '6', '', '2018-08-07 10:27:15', '0', '2018-08-07 10:27:15', null, '2018-08-07 10:27:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('384', '53', '8', 'Iniciando etapa de aprobacion', '2018-08-07 10:27:16', '0', '2018-08-07 10:27:15', null, '2018-08-07 10:27:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('385', '53', '9', 'Proyecto por enviar', '2018-08-07 10:27:18', '0', '2018-08-07 10:27:15', null, '2018-08-07 10:27:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('386', '9', '11', '', '2018-08-07 10:42:38', '0', '2018-08-07 10:42:38', null, '2018-08-07 10:42:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('387', '11', '11', '', '2018-08-07 10:45:54', '0', '2018-08-07 10:45:54', null, '2018-08-07 10:45:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('388', '9', '11', '', '2018-07-24 10:50:13', '0', '2018-08-07 10:50:13', null, '2018-08-07 10:50:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('389', '13', '11', '', '2018-07-04 10:57:18', '0', '2018-08-07 10:57:18', null, '2018-08-07 10:57:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('390', '15', '11', '', '2018-07-19 11:01:38', '0', '2018-08-07 11:01:38', null, '2018-08-07 11:01:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('391', '17', '11', '', '2018-07-20 11:04:07', '0', '2018-08-07 11:04:07', null, '2018-08-07 11:04:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('392', '16', '11', '', '2018-07-26 11:08:12', '0', '2018-08-07 11:08:12', null, '2018-08-07 11:08:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('393', '18', '11', '', '2018-07-20 11:11:34', '0', '2018-08-07 11:11:34', null, '2018-08-07 11:11:34', null);
INSERT INTO `wfl_project_status_log` VALUES ('394', '75', '10', '', '2018-07-10 11:12:08', '0', '2018-08-07 11:12:08', null, '2018-08-07 11:12:08', null);
INSERT INTO `wfl_project_status_log` VALUES ('395', '75', '11', '', '2018-07-19 11:13:31', '0', '2018-08-07 11:13:31', null, '2018-08-07 11:13:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('396', '27', '2', '', '2018-08-07 11:16:12', '0', '2018-08-07 11:16:12', null, '2018-08-07 11:16:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('397', '37', '2', '', '2018-08-07 11:17:29', '0', '2018-08-07 11:17:29', null, '2018-08-07 11:17:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('398', '35', '2', '', '2018-08-07 11:17:51', '0', '2018-08-07 11:17:51', null, '2018-08-07 11:17:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('399', '33', '2', '', '2018-08-07 11:18:10', '0', '2018-08-07 11:18:10', null, '2018-08-07 11:18:10', null);
INSERT INTO `wfl_project_status_log` VALUES ('400', '43', '2', '', '2018-08-07 11:18:28', '0', '2018-08-07 11:18:28', null, '2018-08-07 11:18:28', null);
INSERT INTO `wfl_project_status_log` VALUES ('401', '60', '11', '', '2018-07-30 11:21:19', '0', '2018-08-07 11:21:19', null, '2018-08-07 11:21:19', null);
INSERT INTO `wfl_project_status_log` VALUES ('402', '39', '2', '', '2018-08-07 11:23:12', '0', '2018-08-07 11:23:12', null, '2018-08-07 11:23:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('403', '76', '1', 'Proyecto enviado a diseño', '2018-07-25 11:25:53', '0', '2018-08-07 11:25:53', null, '2018-08-07 11:25:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('404', '76', '2', '', '2018-08-07 11:26:20', '0', '2018-08-07 11:26:20', null, '2018-08-07 11:26:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('405', '58', '11', '', '2018-07-30 11:30:02', '0', '2018-08-07 11:30:02', null, '2018-08-07 11:30:02', null);
INSERT INTO `wfl_project_status_log` VALUES ('406', '55', '2', '', '2018-08-07 11:31:04', '0', '2018-08-07 11:31:04', null, '2018-08-07 11:31:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('407', '69', '11', '', '2018-07-30 11:34:28', '0', '2018-08-07 11:34:28', null, '2018-08-07 11:34:28', null);
INSERT INTO `wfl_project_status_log` VALUES ('408', '59', '11', '', '2018-07-30 11:36:43', '0', '2018-08-07 11:36:43', null, '2018-08-07 11:36:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('409', '54', '2', '', '2018-08-07 11:38:24', '0', '2018-08-07 11:38:24', null, '2018-08-07 11:38:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('410', '77', '1', 'Proyecto enviado a diseño', '2018-08-03 11:40:48', '0', '2018-08-07 11:40:48', null, '2018-08-07 11:40:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('411', '78', '1', 'Proyecto enviado a diseño', '2018-08-03 11:43:07', '0', '2018-08-07 11:43:07', null, '2018-08-07 11:43:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('412', '78', '2', '', '2018-08-07 11:43:29', '0', '2018-08-07 11:43:29', null, '2018-08-07 11:43:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('413', '62', '2', '', '2018-06-11 11:44:56', '0', '2018-08-07 11:44:56', null, '2018-08-07 11:44:56', null);
INSERT INTO `wfl_project_status_log` VALUES ('414', '62', '3', '', '2018-06-18 11:45:10', '0', '2018-08-07 11:45:10', null, '2018-08-07 11:45:10', null);
INSERT INTO `wfl_project_status_log` VALUES ('415', '62', '5', '', '2018-06-20 11:45:23', '0', '2018-08-07 11:45:23', null, '2018-08-07 11:45:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('416', '62', '6', '', '2018-06-25 11:45:52', '0', '2018-08-07 11:45:52', null, '2018-08-07 11:45:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('417', '62', '8', 'Iniciando etapa de aprobacion', '2018-06-25 11:45:53', '0', '2018-08-07 11:45:52', null, '2018-08-07 11:45:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('418', '62', '9', 'Proyecto por enviar', '2018-06-25 11:45:55', '0', '2018-08-07 11:45:52', null, '2018-08-07 11:45:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('419', '53', '10', '', '2018-08-07 13:29:19', '0', '2018-08-07 13:29:19', null, '2018-08-07 13:29:19', null);
INSERT INTO `wfl_project_status_log` VALUES ('420', '79', '1', 'Proyecto enviado a diseño', '2018-04-04 14:23:23', '0', '2018-08-07 14:23:23', null, '2018-08-07 14:23:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('421', '79', '2', '', '2018-05-12 14:24:26', '0', '2018-08-07 14:24:26', null, '2018-08-07 14:24:26', null);
INSERT INTO `wfl_project_status_log` VALUES ('422', '79', '3', '', '2018-05-02 14:25:11', '0', '2018-08-07 14:25:11', null, '2018-08-07 14:25:11', null);
INSERT INTO `wfl_project_status_log` VALUES ('423', '79', '5', '', '2018-05-04 14:25:35', '0', '2018-08-07 14:25:35', null, '2018-08-07 14:25:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('424', '79', '6', '', '2018-05-12 14:26:44', '0', '2018-08-07 14:26:44', null, '2018-08-07 14:26:44', null);
INSERT INTO `wfl_project_status_log` VALUES ('425', '79', '8', 'Iniciando etapa de aprobacion', '2018-05-12 14:26:45', '0', '2018-08-07 14:26:44', null, '2018-08-07 14:26:44', null);
INSERT INTO `wfl_project_status_log` VALUES ('426', '79', '9', 'Proyecto por enviar', '2018-05-12 14:26:47', '0', '2018-08-07 14:26:44', null, '2018-08-07 14:26:44', null);
INSERT INTO `wfl_project_status_log` VALUES ('427', '48', '6', '', '2018-08-07 16:36:54', '0', '2018-08-07 16:36:54', null, '2018-08-07 16:36:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('428', '48', '8', 'Iniciando etapa de aprobacion', '2018-08-07 16:36:55', '0', '2018-08-07 16:36:54', null, '2018-08-07 16:36:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('429', '48', '9', 'Proyecto por enviar', '2018-08-07 16:36:57', '0', '2018-08-07 16:36:54', null, '2018-08-07 16:36:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('430', '50', '6', '', '2018-08-07 17:29:26', '0', '2018-08-07 17:29:26', null, '2018-08-07 17:29:26', null);
INSERT INTO `wfl_project_status_log` VALUES ('431', '50', '8', 'Iniciando etapa de aprobacion', '2018-08-07 17:29:27', '0', '2018-08-07 17:29:26', null, '2018-08-07 17:29:26', null);
INSERT INTO `wfl_project_status_log` VALUES ('432', '50', '9', 'Proyecto por enviar', '2018-08-07 17:29:29', '0', '2018-08-07 17:29:26', null, '2018-08-07 17:29:26', null);
INSERT INTO `wfl_project_status_log` VALUES ('433', '80', '7', 'Proyecto creado', '2018-08-08 08:50:47', '0', '2018-08-08 08:50:47', null, '2018-08-08 08:50:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('434', '81', '7', 'Proyecto creado', '2018-08-08 08:52:10', '0', '2018-08-08 08:52:10', null, '2018-08-08 08:52:10', null);
INSERT INTO `wfl_project_status_log` VALUES ('435', '82', '7', 'Proyecto creado', '2018-08-08 08:52:56', '0', '2018-08-08 08:52:56', null, '2018-08-08 08:52:56', null);
INSERT INTO `wfl_project_status_log` VALUES ('436', '50', '10', '', '2018-08-08 11:06:38', '0', '2018-08-08 11:06:38', null, '2018-08-08 11:06:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('437', '48', '10', '', '2018-08-08 11:07:23', '0', '2018-08-08 11:07:23', null, '2018-08-08 11:07:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('438', '78', '3', '', '2018-08-13 15:22:29', '0', '2018-08-13 15:22:29', null, '2018-08-13 15:22:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('439', '1', '5', '', '2018-08-13 16:01:37', '0', '2018-08-13 16:01:37', null, '2018-08-13 16:01:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('440', '1', '6', '', '2018-08-13 16:03:07', '0', '2018-08-13 16:03:07', null, '2018-08-13 16:03:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('441', '1', '8', 'Iniciando etapa de aprobacion', '2018-08-13 16:03:08', '0', '2018-08-13 16:03:07', null, '2018-08-13 16:03:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('442', '1', '9', 'Proyecto por enviar', '2018-08-13 16:03:10', '0', '2018-08-13 16:03:07', null, '2018-08-13 16:03:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('443', '55', '3', '', '2018-08-13 16:52:23', '0', '2018-08-13 16:52:23', null, '2018-08-13 16:52:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('444', '54', '3', '', '2018-08-14 10:43:49', '0', '2018-08-14 10:43:49', null, '2018-08-14 10:43:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('445', '51', '3', '', '2018-08-14 11:02:32', '0', '2018-08-14 11:02:32', null, '2018-08-14 11:02:32', null);
INSERT INTO `wfl_project_status_log` VALUES ('446', '78', '5', '', '2018-08-14 17:17:40', '0', '2018-08-14 17:17:40', null, '2018-08-14 17:17:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('447', '49', '3', '', '2018-08-15 09:03:46', '0', '2018-08-15 09:03:46', null, '2018-08-15 09:03:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('448', '1', '10', '', '2018-08-15 09:45:30', '0', '2018-08-15 09:45:30', null, '2018-08-15 09:45:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('449', '83', '7', 'Proyecto creado', '2018-08-13 09:49:16', '0', '2018-08-15 09:49:16', null, '2018-08-15 09:49:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('450', '51', '5', '', '2018-08-15 10:13:47', '0', '2018-08-15 10:13:47', null, '2018-08-15 10:13:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('451', '51', '6', '', '2018-08-15 10:14:27', '0', '2018-08-15 10:14:27', null, '2018-08-15 10:14:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('452', '51', '8', 'Iniciando etapa de aprobacion', '2018-08-15 10:14:28', '0', '2018-08-15 10:14:27', null, '2018-08-15 10:14:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('453', '51', '9', 'Proyecto por enviar', '2018-08-15 10:14:30', '0', '2018-08-15 10:14:27', null, '2018-08-15 10:14:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('454', '55', '5', '', '2018-08-15 10:14:54', '0', '2018-08-15 10:14:54', null, '2018-08-15 10:14:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('455', '55', '6', '', '2018-08-15 10:15:30', '0', '2018-08-15 10:15:30', null, '2018-08-15 10:15:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('456', '55', '8', 'Iniciando etapa de aprobacion', '2018-08-15 10:15:31', '0', '2018-08-15 10:15:30', null, '2018-08-15 10:15:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('457', '55', '9', 'Proyecto por enviar', '2018-08-15 10:15:33', '0', '2018-08-15 10:15:30', null, '2018-08-15 10:15:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('458', '78', '6', '', '2018-08-15 10:16:31', '0', '2018-08-15 10:16:31', null, '2018-08-15 10:16:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('459', '78', '8', 'Iniciando etapa de aprobacion', '2018-08-15 10:16:32', '0', '2018-08-15 10:16:31', null, '2018-08-15 10:16:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('460', '78', '9', 'Proyecto por enviar', '2018-08-15 10:16:34', '0', '2018-08-15 10:16:31', null, '2018-08-15 10:16:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('461', '84', '1', 'Proyecto enviado a diseño', '2018-08-14 10:24:17', '0', '2018-08-15 10:24:17', null, '2018-08-15 10:24:17', null);
INSERT INTO `wfl_project_status_log` VALUES ('462', '84', '2', '', '2018-08-15 10:25:13', '0', '2018-08-15 10:25:13', null, '2018-08-15 10:25:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('463', '84', '2', '', '2018-08-15 10:25:37', '0', '2018-08-15 10:25:37', null, '2018-08-15 10:25:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('464', '4', '11', '', '2018-08-15 10:30:09', '0', '2018-08-15 10:30:09', null, '2018-08-15 10:30:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('465', '5', '11', '', '2018-08-15 10:31:41', '0', '2018-08-15 10:31:41', null, '2018-08-15 10:31:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('466', '52', '20', '  ', '2018-07-30 14:04:20', '0', '2018-08-15 14:04:20', null, '2018-08-15 14:04:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('467', '54', '5', '', '2018-08-16 09:23:37', '0', '2018-08-16 09:23:37', null, '2018-08-16 09:23:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('468', '54', '6', '', '2018-08-16 09:24:40', '0', '2018-08-16 09:24:40', null, '2018-08-16 09:24:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('469', '54', '8', 'Iniciando etapa de aprobacion', '2018-08-16 09:24:41', '0', '2018-08-16 09:24:40', null, '2018-08-16 09:24:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('470', '54', '9', 'Proyecto por enviar', '2018-08-16 09:24:43', '0', '2018-08-16 09:24:40', null, '2018-08-16 09:24:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('471', '49', '5', '', '2018-08-16 10:11:00', '0', '2018-08-16 10:11:00', null, '2018-08-16 10:11:00', null);
INSERT INTO `wfl_project_status_log` VALUES ('472', '54', '10', '', '2018-08-16 10:26:01', '0', '2018-08-16 10:26:01', null, '2018-08-16 10:26:01', null);
INSERT INTO `wfl_project_status_log` VALUES ('473', '78', '10', '', '2018-08-15 10:27:43', '0', '2018-08-16 10:27:43', null, '2018-08-16 10:27:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('474', '51', '10', '', '2018-08-15 10:28:21', '0', '2018-08-16 10:28:21', null, '2018-08-16 10:28:21', null);
INSERT INTO `wfl_project_status_log` VALUES ('475', '55', '10', '', '2018-08-15 10:31:46', '0', '2018-08-16 10:31:46', null, '2018-08-16 10:31:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('476', '62', '10', '', '2018-06-25 10:51:43', '0', '2018-08-16 10:51:43', null, '2018-08-16 10:51:43', null);
INSERT INTO `wfl_project_status_log` VALUES ('477', '62', '11', '', '2018-07-17 10:53:27', '0', '2018-08-16 10:53:27', null, '2018-08-16 10:53:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('478', '85', '7', 'Proyecto creado', '2018-04-04 10:58:35', '0', '2018-08-16 10:58:35', null, '2018-08-16 10:58:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('479', '65', '10', '', '2018-07-19 11:00:25', '0', '2018-08-16 11:00:25', null, '2018-08-16 11:00:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('480', '64', '10', '', '2018-06-20 11:01:04', '0', '2018-08-16 11:01:04', null, '2018-08-16 11:01:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('481', '85', '1', 'Inicio de diseño del proyecto', '2018-08-16 11:03:20', '0', '2018-08-16 11:03:20', null, '2018-08-16 11:03:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('482', '85', '2', '', '2018-04-12 11:04:47', '0', '2018-08-16 11:04:47', null, '2018-08-16 11:04:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('483', '85', '2', '', '2018-04-12 11:05:04', '0', '2018-08-16 11:05:04', null, '2018-08-16 11:05:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('484', '85', '3', '', '2018-05-02 11:05:21', '0', '2018-08-16 11:05:21', null, '2018-08-16 11:05:21', null);
INSERT INTO `wfl_project_status_log` VALUES ('485', '85', '5', '', '2018-08-16 11:05:24', '0', '2018-08-16 11:05:24', null, '2018-08-16 11:05:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('486', '86', '1', 'Proyecto enviado a diseño', '2018-04-04 11:06:52', '0', '2018-08-16 11:06:52', null, '2018-08-16 11:06:52', null);
INSERT INTO `wfl_project_status_log` VALUES ('487', '86', '2', '', '2018-04-12 11:07:29', '0', '2018-08-16 11:07:29', null, '2018-08-16 11:07:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('488', '86', '3', '', '2018-05-02 11:07:41', '0', '2018-08-16 11:07:41', null, '2018-08-16 11:07:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('489', '86', '5', '', '2018-05-05 11:07:50', '0', '2018-08-16 11:07:50', null, '2018-08-16 11:07:50', null);
INSERT INTO `wfl_project_status_log` VALUES ('490', '86', '6', '', '2018-05-12 11:14:23', '0', '2018-08-16 11:14:23', null, '2018-08-16 11:14:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('491', '86', '8', 'Iniciando etapa de aprobacion', '2018-05-12 11:14:24', '0', '2018-08-16 11:14:23', null, '2018-08-16 11:14:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('492', '86', '9', 'Proyecto por enviar', '2018-05-12 11:14:26', '0', '2018-08-16 11:14:23', null, '2018-08-16 11:14:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('493', '86', '10', '', '2018-05-12 11:15:08', '0', '2018-08-16 11:15:08', null, '2018-08-16 11:15:08', null);
INSERT INTO `wfl_project_status_log` VALUES ('494', '86', '13', 'verificación del diseño en campo con el fiscal Ernesto Barrientos', '2018-07-23 11:18:39', '0', '2018-08-16 11:18:39', null, '2018-08-16 11:18:39', null);
INSERT INTO `wfl_project_status_log` VALUES ('495', '86', '16', '', '2018-07-31 11:22:03', '0', '2018-08-16 11:22:03', null, '2018-08-16 11:22:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('496', '86', '17', '', '2018-08-13 11:22:51', '0', '2018-08-16 11:22:51', null, '2018-08-16 11:22:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('497', '86', '8', 'Iniciando etapa de aprobacion', '2018-08-13 11:22:52', '0', '2018-08-16 11:22:51', null, '2018-08-16 11:22:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('498', '86', '9', 'Proyecto por enviar', '2018-08-13 11:22:54', '0', '2018-08-16 11:22:51', null, '2018-08-16 11:22:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('499', '86', '10', '', '2018-08-13 11:24:15', '0', '2018-08-16 11:24:15', null, '2018-08-16 11:24:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('500', '5', '22', 'enviando proyecto a por grabar', '2018-08-16 17:01:12', '0', '2018-08-16 17:01:12', null, '2018-08-16 17:01:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('501', '4', '22', 'enviando a por grabar', '2018-08-16 17:07:06', '0', '2018-08-16 17:07:06', null, '2018-08-16 17:07:06', null);
INSERT INTO `wfl_project_status_log` VALUES ('502', '11', '22', 'enviando a por grabar', '2018-08-16 17:08:00', '0', '2018-08-16 17:08:00', null, '2018-08-16 17:08:00', null);
INSERT INTO `wfl_project_status_log` VALUES ('503', '9', '22', 'enviando a por grabar', '2018-08-16 17:08:30', '0', '2018-08-16 17:08:30', null, '2018-08-16 17:08:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('504', '59', '22', 'por grabar', '2018-08-16 17:09:18', '0', '2018-08-16 17:09:18', null, '2018-08-16 17:09:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('505', '59', '23', 'grabado de materiales', '2018-08-16 17:12:30', '0', '2018-08-16 17:12:30', null, '2018-08-16 17:12:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('506', '69', '22', 'ninguna observacion', '2018-08-17 10:07:48', '0', '2018-08-17 10:07:48', null, '2018-08-17 10:07:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('507', '58', '22', 'proyecto listo para grabar', '2018-08-17 14:04:23', '0', '2018-08-17 14:04:23', null, '2018-08-17 14:04:23', null);
INSERT INTO `wfl_project_status_log` VALUES ('508', '59', '24', 'Retirando material de CRE', '2018-08-20 10:12:18', '0', '2018-08-20 10:12:18', null, '2018-08-20 10:12:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('509', '59', '25', 'Colocando material en Construccion', '2018-08-20 10:12:41', '0', '2018-08-20 10:12:41', null, '2018-08-20 10:12:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('510', '5', '21', 'a fasd asdd', '2018-08-20 15:14:37', '0', '2018-08-20 15:14:37', null, '2018-08-20 15:14:37', null);
INSERT INTO `wfl_project_status_log` VALUES ('511', '58', '23', 'Grabado de materiales', '2018-08-20 15:44:19', '0', '2018-08-20 15:44:20', null, '2018-08-20 15:44:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('512', '58', '21', 'asignacion posterior al grabado', '2018-08-20 15:45:07', '0', '2018-08-20 15:45:07', null, '2018-08-20 15:45:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('513', '58', '24', 'materiales retirados de CRE', '2018-08-20 15:55:49', '0', '2018-08-20 15:55:49', null, '2018-08-20 15:55:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('514', '58', '25', 'Materiales puestos en Construccion', '2018-08-20 15:56:14', '0', '2018-08-20 15:56:14', null, '2018-08-20 15:56:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('515', '59', '21', '', '2018-08-21 11:56:07', '0', '2018-08-21 11:56:07', null, '2018-08-21 11:56:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('516', '59', '25', 'materiales puestos en construccion', '2018-08-21 11:56:51', '0', '2018-08-21 11:56:51', null, '2018-08-21 11:56:51', null);
INSERT INTO `wfl_project_status_log` VALUES ('517', '59', '29', 'Iniciando construccion', '2018-08-21 12:16:07', '0', '2018-08-21 12:16:07', null, '2018-08-21 12:16:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('518', '59', '31', 'Se pauso el proyecto', '2018-08-21 12:16:26', '0', '2018-08-21 12:16:26', null, '2018-08-21 12:16:26', null);
INSERT INTO `wfl_project_status_log` VALUES ('519', '59', '30', 'se detuvo el proyecto', '2018-08-21 12:16:35', '0', '2018-08-21 12:16:35', null, '2018-08-21 12:16:35', null);
INSERT INTO `wfl_project_status_log` VALUES ('520', '59', '32', 'El proyecto se ha completado', '2018-08-21 12:16:48', '0', '2018-08-21 12:16:48', null, '2018-08-21 12:16:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('521', '59', '29', 'asdfa s', '2018-08-22 11:50:25', '0', '2018-08-22 11:50:25', null, '2018-08-22 11:50:25', null);
INSERT INTO `wfl_project_status_log` VALUES ('522', '58', '21', 'asignacion posterior al grabado', '2018-08-22 12:14:22', '0', '2018-08-22 12:14:22', null, '2018-08-22 12:14:22', null);
INSERT INTO `wfl_project_status_log` VALUES ('523', '59', '31', 'pausado', '2018-08-22 12:33:27', '0', '2018-08-22 12:33:27', null, '2018-08-22 12:33:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('524', '62', '11', '', '2018-08-23 09:58:48', '0', '2018-08-23 09:58:48', null, '2018-08-23 09:58:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('525', '62', '21', 'proyecto asignado', '2018-08-28 11:33:17', '0', '2018-08-28 11:33:18', '1', '2018-08-28 11:33:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('526', '62', '29', 'Iniciando construccion del proyecto', '2018-08-28 12:04:00', '0', '2018-08-28 12:04:00', '1', '2018-08-28 12:04:00', null);
INSERT INTO `wfl_project_status_log` VALUES ('527', '53', '11', 'al especificar los importes el se crea un proceso de almacén para este proyecto', '2018-08-29 11:06:17', '0', '2018-08-29 11:06:17', '1', '2018-08-29 11:06:17', null);
INSERT INTO `wfl_project_status_log` VALUES ('528', '53', '11', 'al especificar los importes el se crea un proceso de almacén para este proyecto', '2018-08-29 11:26:06', '0', '2018-08-29 11:26:06', '1', '2018-08-29 11:26:06', null);
INSERT INTO `wfl_project_status_log` VALUES ('529', '53', '11', 'al especificar los importes el se crea un proceso de almacén para este proyecto', '2018-08-29 11:27:02', '0', '2018-08-29 11:27:02', '1', '2018-08-29 11:27:02', null);
INSERT INTO `wfl_project_status_log` VALUES ('530', '53', '11', 'al especificar los importes el se crea un proceso de almacén para este proyecto', '2018-08-29 11:28:31', '0', '2018-08-29 11:28:31', '1', '2018-08-29 11:28:31', null);
INSERT INTO `wfl_project_status_log` VALUES ('531', '53', '11', 'al especificar los importes el se crea un proceso de almacén para este proyecto', '2018-08-29 11:28:57', '0', '2018-08-29 11:28:57', '1', '2018-08-29 11:28:57', null);
INSERT INTO `wfl_project_status_log` VALUES ('532', '53', '11', 'al especificar los importes el se crea un proceso de almacén para este proyecto', '2018-08-29 11:30:18', '0', '2018-08-29 11:30:18', '1', '2018-08-29 11:30:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('533', '53', '21', 'projecto RD.16.0930 = 53', '2018-08-30 12:10:47', '0', '2018-08-30 12:10:47', '1', '2018-08-30 12:10:47', null);
INSERT INTO `wfl_project_status_log` VALUES ('534', '53', '21', 'projecto RD.16.0930 = 53', '2018-08-30 12:12:45', '0', '2018-08-30 12:12:45', '1', '2018-08-30 12:12:45', null);
INSERT INTO `wfl_project_status_log` VALUES ('535', '75', '11', 'proyecto aprobado y listo para iniciar gestion de materiales', '2018-08-30 14:41:06', '0', '2018-08-30 14:41:06', '1', '2018-08-30 14:41:06', null);
INSERT INTO `wfl_project_status_log` VALUES ('536', '60', '11', 'guardando importes e iniciando gestion de materiales', '2018-08-30 14:44:53', '0', '2018-08-30 14:44:53', '1', '2018-08-30 14:44:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('537', '53', '29', 'El proyecto se encuentra en construccion', '2018-08-30 14:48:58', '0', '2018-08-30 14:48:58', '1', '2018-08-30 14:48:58', null);
INSERT INTO `wfl_project_status_log` VALUES ('538', '53', '31', 'se pausa el proyecto', '2018-08-30 14:49:07', '0', '2018-08-30 14:49:07', '1', '2018-08-30 14:49:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('539', '59', '21', '', '2018-08-30 14:50:20', '0', '2018-08-30 14:50:20', '1', '2018-08-30 14:50:20', null);
INSERT INTO `wfl_project_status_log` VALUES ('540', '53', '21', 'projecto RD.16.0930 = 53', '2018-08-30 14:51:38', '0', '2018-08-30 14:51:38', '1', '2018-08-30 14:51:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('541', '75', '21', 'asignacion del proyecto 75', '2018-08-31 10:16:09', '0', '2018-08-31 10:16:09', '1', '2018-08-31 10:16:09', null);
INSERT INTO `wfl_project_status_log` VALUES ('542', '75', '21', 'asignacion del proyecto 75', '2018-08-31 10:19:53', '0', '2018-08-31 10:19:53', '1', '2018-08-31 10:19:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('543', '75', '21', 'asignacion del proyecto 75', '2018-08-31 10:23:41', '0', '2018-08-31 10:23:41', '1', '2018-08-31 10:23:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('544', '75', '21', 'asignacion del proyecto 75', '2018-08-31 10:30:41', '0', '2018-08-31 10:30:41', '1', '2018-08-31 10:30:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('545', '75', '29', 'coloco el proyecto en contruccion', '2018-08-31 10:35:41', '0', '2018-08-31 10:35:41', '1', '2018-08-31 10:35:41', null);
INSERT INTO `wfl_project_status_log` VALUES ('546', '75', '31', 'El proyecto tuvo que ser pausado', '2018-08-31 10:35:49', '0', '2018-08-31 10:35:49', '1', '2018-08-31 10:35:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('547', '75', '21', 'asignacion del proyecto 75', '2018-08-31 10:36:07', '0', '2018-08-31 10:36:07', '1', '2018-08-31 10:36:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('548', '75', '29', 'Se reanuda la construccion del proyecto', '2018-08-31 10:40:13', '0', '2018-08-31 10:40:13', '1', '2018-08-31 10:40:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('549', '75', '31', 'he decidido pausar el proyecto por falta de materiales', '2018-08-31 11:17:52', '0', '2018-08-31 11:17:53', '1', '2018-08-31 11:17:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('550', '53', '30', 'se detuvo el proyecto', '2018-08-31 15:33:36', '0', '2018-08-31 15:33:36', '1', '2018-08-31 15:33:36', null);
INSERT INTO `wfl_project_status_log` VALUES ('551', '53', '32', 'se completo el proyecto', '2018-08-31 15:33:49', '0', '2018-08-31 15:33:49', '1', '2018-08-31 15:33:49', null);
INSERT INTO `wfl_project_status_log` VALUES ('552', '53', '33', 'Realizando el as bulit del proyecto', '2018-08-31 15:50:16', '0', '2018-08-31 15:50:16', '1', '2018-08-31 15:50:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('553', '53', '34', 'Se recibio la conciliacion de CRE', '2018-08-31 16:02:55', '0', '2018-08-31 16:02:55', '1', '2018-08-31 16:02:55', null);
INSERT INTO `wfl_project_status_log` VALUES ('554', '53', '35', 'Se reviso la conciliacion, ahora se envio a cre', '2018-08-31 16:03:19', '0', '2018-08-31 16:03:19', '1', '2018-08-31 16:03:19', null);
INSERT INTO `wfl_project_status_log` VALUES ('555', '53', '38', 'Se ha recibido la orden de devolucion a CRE, sin ningun inconveniente', '2018-08-31 16:04:24', '0', '2018-08-31 16:04:24', '1', '2018-08-31 16:04:24', null);
INSERT INTO `wfl_project_status_log` VALUES ('556', '53', '38', 'asdfasd', '2018-08-31 16:05:55', '0', '2018-08-31 16:05:55', '1', '2018-08-31 16:05:55', null);
INSERT INTO `wfl_project_status_log` VALUES ('557', '53', '38', 'asdfa sdf as', '2018-08-31 16:07:46', '0', '2018-08-31 16:07:46', '1', '2018-08-31 16:07:46', null);
INSERT INTO `wfl_project_status_log` VALUES ('558', '8', '11', '', '2018-08-31 16:50:16', '0', '2018-08-31 16:50:16', '1', '2018-08-31 16:50:16', null);
INSERT INTO `wfl_project_status_log` VALUES ('559', '8', '21', 'Ninguna', '2018-08-31 16:54:12', '0', '2018-08-31 16:54:12', '1', '2018-08-31 16:54:12', null);
INSERT INTO `wfl_project_status_log` VALUES ('560', '8', '29', 'He iniciado la construccion del proyecto', '2018-08-31 16:56:08', '0', '2018-08-31 16:56:08', '1', '2018-08-31 16:56:08', null);
INSERT INTO `wfl_project_status_log` VALUES ('561', '8', '32', 'Se completo el proyecto al 100%', '2018-08-31 17:07:47', '0', '2018-08-31 17:07:48', '1', '2018-08-31 17:07:48', null);
INSERT INTO `wfl_project_status_log` VALUES ('562', '8', '33', 'He enviado el as built a CRE', '2018-08-31 17:08:29', '0', '2018-08-31 17:08:29', '1', '2018-08-31 17:08:29', null);
INSERT INTO `wfl_project_status_log` VALUES ('563', '8', '34', 'Confirmo que he recibido la conciliacion de CRE', '2018-08-31 17:08:58', '0', '2018-08-31 17:08:58', '1', '2018-08-31 17:08:58', null);
INSERT INTO `wfl_project_status_log` VALUES ('564', '8', '35', 'He enviado la conciliacion a CRE', '2018-08-31 17:12:00', '0', '2018-08-31 17:12:00', '1', '2018-08-31 17:12:00', null);
INSERT INTO `wfl_project_status_log` VALUES ('565', '8', '38', 'He recibido la orden de devolucion de materiales restantes a CRE', '2018-08-31 17:12:22', '0', '2018-08-31 17:12:22', '1', '2018-08-31 17:12:22', null);
INSERT INTO `wfl_project_status_log` VALUES ('566', '8', '39', 'Confirmo la devolucion de los materiales a CRE', '2018-08-31 17:15:54', '0', '2018-08-31 17:15:54', '1', '2018-08-31 17:15:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('567', '75', '21', 'asignacion del proyecto 75', '2018-09-03 10:05:54', '0', '2018-09-03 10:05:54', '1', '2018-09-03 10:05:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('568', '75', '29', 'nuevo inicio de construccion', '2018-09-03 10:06:38', '0', '2018-09-03 10:06:38', '1', '2018-09-03 10:06:38', null);
INSERT INTO `wfl_project_status_log` VALUES ('569', '74', '11', '', '2018-09-04 11:41:13', '0', '2018-09-04 11:41:14', '1', '2018-09-04 11:41:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('570', '75', '31', 'No puedo seguir la construccion hasta que salgan ciertos permisos', '2018-09-05 10:44:07', '0', '2018-09-05 10:44:07', '1', '2018-09-05 10:44:07', null);
INSERT INTO `wfl_project_status_log` VALUES ('571', '75', '30', 'No se posible continuar con el proyecto, elaborare el as built.', '2018-09-05 11:03:53', '0', '2018-09-05 11:03:53', '1', '2018-09-05 11:03:53', null);
INSERT INTO `wfl_project_status_log` VALUES ('572', '75', '31', 'Se esta pausado el proyecto', '2018-09-05 11:14:39', '0', '2018-09-05 11:14:40', '1', '2018-09-05 11:14:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('573', '87', '1', 'Proyecto enviado a diseño', '2018-09-06 10:42:39', '0', '2018-09-06 10:42:40', null, '2018-09-06 10:42:40', null);
INSERT INTO `wfl_project_status_log` VALUES ('574', '88', '1', 'Proyecto enviado a diseño', '2018-09-06 10:52:30', '0', '2018-09-06 10:52:30', null, '2018-09-06 10:52:30', null);
INSERT INTO `wfl_project_status_log` VALUES ('575', '5', '29', 'Estoy iniciando la construccion del proyecto RO.18.0167(5)', '2018-09-06 11:44:02', '0', '2018-09-06 11:44:03', '11', '2018-09-06 11:44:03', null);
INSERT INTO `wfl_project_status_log` VALUES ('576', '5', '31', 'Estoy pausando el proyecto', '2018-09-06 11:44:45', '0', '2018-09-06 11:44:45', '11', '2018-09-06 11:44:45', null);
INSERT INTO `wfl_project_status_log` VALUES ('577', '5', '30', 'El proyecto sera descontinuado', '2018-09-06 11:45:13', '0', '2018-09-06 11:45:13', '11', '2018-09-06 11:45:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('578', '5', '33', 'Se esta ingresando el as built', '2018-09-06 11:45:54', '0', '2018-09-06 11:45:55', '11', '2018-09-06 11:45:55', null);
INSERT INTO `wfl_project_status_log` VALUES ('579', '53', '39', 'confirmacion de devolucion de materiales a CRE', '2018-09-07 11:56:28', '0', '2018-09-07 11:56:28', '1', '2018-09-07 11:56:28', null);
INSERT INTO `wfl_project_status_log` VALUES ('580', '12', '11', 'nuevo importe en aprobacion', '2018-09-10 11:30:14', '0', '2018-09-10 11:30:15', '1', '2018-09-10 11:30:15', null);
INSERT INTO `wfl_project_status_log` VALUES ('581', '12', '11', 'nuevo importe en aprobacion  - segunda prueba', '2018-09-10 11:33:01', '0', '2018-09-10 11:33:01', '1', '2018-09-10 11:33:01', null);
INSERT INTO `wfl_project_status_log` VALUES ('582', '53', '40', 'Se definieron los importes reales', '2018-09-11 12:29:18', '0', '2018-09-11 12:29:18', '1', '2018-09-11 12:29:18', null);
INSERT INTO `wfl_project_status_log` VALUES ('583', '8', '40', 'Se definieron los importes reales', '2018-09-11 12:29:18', '0', '2018-09-11 12:29:19', '1', '2018-09-11 12:29:19', null);
INSERT INTO `wfl_project_status_log` VALUES ('584', '8', '40', 'Se definieron los importes reales', '2018-09-11 14:15:13', '0', '2018-09-11 14:15:13', '1', '2018-09-11 14:15:13', null);
INSERT INTO `wfl_project_status_log` VALUES ('585', '53', '40', 'Se definieron los importes reales', '2018-09-11 14:15:13', '0', '2018-09-11 14:15:14', '1', '2018-09-11 14:15:14', null);
INSERT INTO `wfl_project_status_log` VALUES ('586', '8', '40', 'Se definieron los importes reales', '2018-09-11 14:17:26', '0', '2018-09-11 14:17:27', '1', '2018-09-11 14:17:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('587', '53', '40', 'Se definieron los importes reales', '2018-09-11 14:17:26', '0', '2018-09-11 14:17:27', '1', '2018-09-11 14:17:27', null);
INSERT INTO `wfl_project_status_log` VALUES ('588', '8', '40', 'Se definieron los importes reales', '2018-09-11 14:18:27', '0', '2018-09-11 14:18:28', '1', '2018-09-11 14:18:28', null);
INSERT INTO `wfl_project_status_log` VALUES ('589', '53', '40', 'Se definieron los importes reales', '2018-09-11 14:18:27', '0', '2018-09-11 14:18:28', '1', '2018-09-11 14:18:28', null);
INSERT INTO `wfl_project_status_log` VALUES ('590', '8', '40', 'Se definieron los importes reales', '2018-09-12 10:47:03', '0', '2018-09-12 10:47:04', '1', '2018-09-12 10:47:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('591', '53', '40', 'Se definieron los importes reales', '2018-09-12 10:47:03', '0', '2018-09-12 10:47:04', '1', '2018-09-12 10:47:04', null);
INSERT INTO `wfl_project_status_log` VALUES ('592', '53', '40', 'Se definieron los importes reales', '2018-09-12 12:13:54', '0', '2018-09-12 12:13:54', '1', '2018-09-12 12:13:54', null);
INSERT INTO `wfl_project_status_log` VALUES ('593', '8', '40', 'Se definieron los importes reales', '2018-09-12 12:13:54', '0', '2018-09-12 12:13:55', '1', '2018-09-12 12:13:55', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=654 DEFAULT CHARSET=latin1;

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
INSERT INTO `wfl_status_log_responsibles` VALUES ('62', '65', '8', '0', '2018-07-26 11:15:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('63', '66', '10', '0', '2018-07-26 11:15:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('64', '67', '10', '0', '2018-07-26 11:15:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('65', '68', '8', '0', '2018-07-26 11:51:44', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('66', '69', '10', '0', '2018-07-26 11:51:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('67', '70', '10', '0', '2018-07-26 11:51:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('68', '71', '1', '0', '2018-07-26 14:38:37', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('69', '72', '1', '0', '2018-07-26 14:41:22', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('70', '73', '1', '0', '2018-07-26 14:44:48', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('71', '74', '1', '0', '2018-07-26 14:49:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('72', '75', '3', '0', '2018-07-26 14:54:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('73', '76', '6', '0', '2018-07-26 14:54:55', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('74', '77', '7', '0', '2018-07-26 14:55:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('75', '78', '8', '0', '2018-07-26 14:55:56', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('76', '79', '10', '0', '2018-07-26 14:55:57', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('77', '80', '10', '0', '2018-07-26 14:55:58', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('78', '81', '3', '0', '2018-07-26 15:00:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('79', '82', '6', '0', '2018-07-26 15:00:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('80', '83', '7', '0', '2018-07-26 15:00:37', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('81', '84', '8', '0', '2018-07-26 15:01:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('82', '85', '10', '0', '2018-07-26 15:01:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('83', '86', '10', '0', '2018-07-26 15:01:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('84', '87', '3', '0', '2018-07-26 15:03:39', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('85', '88', '6', '0', '2018-07-26 15:03:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('86', '89', '7', '0', '2018-07-26 15:04:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('87', '90', '8', '0', '2018-07-26 15:04:31', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('88', '91', '10', '0', '2018-07-26 15:04:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('89', '92', '10', '0', '2018-07-26 15:04:33', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('90', '93', '4', '0', '2018-07-26 15:06:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('91', '94', '6', '0', '2018-07-26 15:06:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('92', '95', '7', '0', '2018-07-26 15:06:57', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('93', '96', '8', '0', '2018-07-26 15:08:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('94', '97', '10', '0', '2018-07-26 15:08:11', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('95', '98', '10', '0', '2018-07-26 15:08:12', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('96', '99', '1', '0', '2018-07-26 15:24:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('97', '100', '1', '0', '2018-07-26 15:26:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('98', '101', '1', '0', '2018-07-26 15:28:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('99', '102', '1', '0', '2018-07-26 15:29:48', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('100', '103', '1', '0', '2018-07-26 15:31:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('101', '104', '1', '0', '2018-07-26 15:32:17', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('102', '105', '1', '0', '2018-07-26 15:37:33', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('103', '106', '3', '0', '2018-07-26 15:40:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('104', '107', '6', '0', '2018-07-26 15:40:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('105', '108', '7', '0', '2018-07-26 15:40:33', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('106', '109', '8', '0', '2018-07-26 15:41:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('107', '110', '10', '0', '2018-07-26 15:41:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('108', '111', '10', '0', '2018-07-26 15:41:17', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('109', '112', '3', '0', '2018-07-26 15:42:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('110', '113', '6', '0', '2018-07-26 15:42:31', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('111', '114', '7', '0', '2018-07-26 15:42:37', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('112', '115', '8', '0', '2018-07-26 15:43:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('113', '116', '10', '0', '2018-07-26 15:43:02', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('114', '117', '10', '0', '2018-07-26 15:43:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('115', '118', '3', '0', '2018-07-26 15:43:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('116', '119', '6', '0', '2018-07-26 15:44:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('117', '120', '7', '0', '2018-07-26 15:44:39', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('118', '121', '8', '0', '2018-07-26 15:45:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('119', '122', '10', '0', '2018-07-26 15:45:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('120', '123', '10', '0', '2018-07-26 15:45:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('121', '124', '3', '0', '2018-07-26 15:46:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('122', '125', '6', '0', '2018-07-26 15:46:20', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('123', '126', '7', '0', '2018-07-26 15:46:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('124', '127', '8', '0', '2018-07-26 15:47:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('125', '128', '10', '0', '2018-07-26 15:47:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('126', '129', '10', '0', '2018-07-26 15:47:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('127', '130', '3', '0', '2018-07-26 15:48:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('128', '131', '6', '0', '2018-07-26 15:48:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('129', '132', '7', '0', '2018-07-26 15:48:22', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('130', '133', '8', '0', '2018-07-26 15:49:12', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('131', '134', '10', '0', '2018-07-26 15:49:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('132', '135', '10', '0', '2018-07-26 15:49:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('133', '136', '3', '0', '2018-07-26 15:49:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('134', '137', '6', '0', '2018-07-26 15:49:55', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('135', '138', '7', '0', '2018-07-26 15:50:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('136', '139', '8', '0', '2018-07-26 15:50:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('137', '140', '10', '0', '2018-07-26 15:50:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('138', '141', '10', '0', '2018-07-26 15:50:36', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('139', '142', '1', '0', '2018-07-27 07:55:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('140', '143', '1', '0', '2018-07-27 08:04:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('141', '144', '1', '0', '2018-07-27 08:05:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('142', '145', '1', '0', '2018-07-27 08:06:33', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('143', '146', '1', '0', '2018-07-27 08:13:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('144', '147', '1', '0', '2018-07-27 08:14:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('145', '148', '1', '0', '2018-07-27 08:15:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('146', '149', '1', '0', '2018-07-27 08:17:33', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('147', '150', '1', '0', '2018-07-27 08:20:47', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('148', '151', '1', '0', '2018-07-27 08:22:02', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('149', '152', '1', '0', '2018-07-27 08:23:47', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('150', '153', '1', '0', '2018-07-27 08:24:56', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('151', '154', '1', '0', '2018-07-27 08:26:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('152', '155', '1', '0', '2018-07-27 08:27:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('153', '156', '1', '0', '2018-07-27 08:28:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('154', '157', '1', '0', '2018-07-27 08:30:19', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('155', '158', '1', '0', '2018-07-27 08:31:48', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('156', '159', '1', '0', '2018-07-27 08:33:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('157', '160', '1', '0', '2018-07-27 08:34:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('158', '161', '1', '0', '2018-07-27 08:35:19', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('159', '162', '1', '0', '2018-07-27 08:37:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('160', '163', '8', '0', '2018-07-27 09:24:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('161', '164', '10', '0', '2018-07-27 09:24:33', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('162', '165', '10', '0', '2018-07-27 09:24:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('163', '166', '1', '0', '2018-07-27 11:13:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('164', '167', '3', '0', '2018-07-27 11:14:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('165', '168', '6', '0', '2018-07-27 11:14:37', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('166', '169', '7', '0', '2018-07-27 11:15:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('167', '170', '8', '0', '2018-07-27 11:15:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('168', '171', '10', '0', '2018-07-27 11:15:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('169', '172', '10', '0', '2018-07-27 11:15:36', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('170', '173', '1', '0', '2018-07-28 08:28:28', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('171', '174', '4', '0', '2018-07-28 08:29:44', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('172', '175', '6', '0', '2018-07-28 08:30:30', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('173', '176', '1', '0', '2018-07-28 10:11:31', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('174', '177', '1', '0', '2018-07-28 10:15:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('175', '178', '1', '0', '2018-07-28 10:17:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('176', '179', '4', '0', '2018-07-28 10:19:33', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('177', '180', '4', '0', '2018-07-28 10:20:12', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('178', '181', '4', '0', '2018-07-28 10:20:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('179', '182', '4', '0', '2018-07-30 08:09:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('180', '183', '4', '0', '2018-07-30 08:09:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('181', '184', '1', '0', '2018-07-30 08:49:20', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('182', '185', '1', '0', '2018-07-30 08:50:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('183', '186', '5', '0', '2018-07-30 08:51:11', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('184', '187', '5', '0', '2018-07-30 08:51:44', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('185', '188', '5', '0', '2018-07-30 08:52:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('186', '189', '5', '0', '2018-07-30 08:52:31', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('187', '190', '6', '0', '2018-07-30 14:59:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('188', '191', '6', '0', '2018-07-30 14:59:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('189', '192', '5', '0', '2018-07-30 17:05:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('190', '193', '7', '0', '2018-07-31 09:54:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('191', '194', '8', '0', '2018-07-31 09:55:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('192', '195', '10', '0', '2018-07-31 09:55:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('193', '196', '10', '0', '2018-07-31 09:55:55', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('194', '197', '7', '0', '2018-07-31 09:56:26', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('195', '198', '8', '0', '2018-07-31 09:56:41', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('196', '199', '10', '0', '2018-07-31 09:56:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('197', '200', '10', '0', '2018-07-31 09:56:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('198', '201', '1', '0', '2018-07-31 15:52:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('199', '202', '1', '0', '2018-07-31 15:53:48', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('200', '203', '6', '0', '2018-08-01 08:13:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('201', '204', '6', '0', '2018-08-01 08:13:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('202', '205', '7', '0', '2018-08-01 14:22:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('203', '206', '7', '0', '2018-08-01 14:22:24', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('204', '207', '7', '0', '2018-08-01 14:22:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('205', '208', '8', '0', '2018-08-01 15:14:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('206', '209', '10', '0', '2018-08-01 15:14:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('207', '210', '11', '0', '2018-08-01 15:14:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('208', '211', '6', '0', '2018-08-01 16:19:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('209', '212', '6', '0', '2018-08-02 11:05:24', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('210', '213', '6', '0', '2018-08-02 11:11:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('211', '214', '1', '0', '2018-08-02 14:27:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('212', '215', '1', '0', '2018-08-02 14:31:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('213', '216', '1', '0', '2018-08-02 14:33:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('214', '217', '1', '0', '2018-08-02 14:34:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('215', '218', '1', '0', '2018-08-02 14:36:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('216', '219', '1', '0', '2018-08-02 14:38:36', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('217', '220', '1', '0', '2018-08-02 14:40:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('218', '221', '1', '0', '2018-08-02 14:42:24', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('219', '222', '1', '0', '2018-08-02 14:43:56', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('220', '223', '1', '0', '2018-08-02 14:59:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('221', '224', '1', '0', '2018-08-02 15:00:30', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('222', '225', '1', '0', '2018-08-02 15:02:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('223', '226', '4', '0', '2018-08-02 15:04:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('224', '227', '6', '0', '2018-08-02 15:05:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('225', '228', '7', '0', '2018-08-02 15:05:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('226', '229', '8', '0', '2018-08-02 15:09:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('227', '230', '10', '0', '2018-08-02 15:09:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('228', '231', '11', '0', '2018-08-02 15:09:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('229', '232', '5', '0', '2018-08-02 15:11:30', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('230', '233', '6', '0', '2018-08-02 15:11:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('231', '234', '7', '0', '2018-08-02 15:11:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('232', '235', '8', '0', '2018-08-02 15:13:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('233', '236', '10', '0', '2018-08-02 15:13:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('234', '237', '11', '0', '2018-08-02 15:13:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('235', '238', '4', '0', '2018-08-02 15:16:20', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('236', '239', '6', '0', '2018-08-02 15:16:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('237', '240', '7', '0', '2018-08-02 15:16:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('238', '241', '8', '0', '2018-08-02 15:17:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('239', '242', '10', '0', '2018-08-02 15:17:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('240', '243', '11', '0', '2018-08-02 15:17:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('241', '244', '5', '0', '2018-08-02 15:19:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('242', '245', '6', '0', '2018-08-02 15:19:18', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('243', '246', '7', '0', '2018-08-02 15:19:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('244', '247', '8', '0', '2018-08-02 15:21:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('245', '248', '10', '0', '2018-08-02 15:21:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('246', '249', '11', '0', '2018-08-02 15:21:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('247', '250', '4', '0', '2018-08-02 15:23:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('248', '251', '6', '0', '2018-08-02 15:23:31', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('249', '252', '7', '0', '2018-08-02 15:23:41', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('250', '253', '8', '0', '2018-08-02 15:24:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('251', '254', '10', '0', '2018-08-02 15:24:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('252', '255', '11', '0', '2018-08-02 15:24:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('253', '256', '4', '0', '2018-08-02 15:25:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('254', '257', '6', '0', '2018-08-02 15:25:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('255', '258', '7', '0', '2018-08-02 15:25:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('256', '259', '8', '0', '2018-08-02 15:26:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('257', '260', '10', '0', '2018-08-02 15:26:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('258', '261', '11', '0', '2018-08-02 15:26:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('259', '262', '5', '0', '2018-08-02 15:28:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('260', '263', '6', '0', '2018-08-02 15:28:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('261', '264', '7', '0', '2018-08-02 15:28:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('262', '265', '8', '0', '2018-08-02 15:28:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('263', '266', '10', '0', '2018-08-02 15:28:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('264', '267', '11', '0', '2018-08-02 15:28:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('265', '268', '4', '0', '2018-08-02 15:30:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('266', '269', '6', '0', '2018-08-02 15:30:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('267', '270', '7', '0', '2018-08-02 15:30:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('268', '271', '8', '0', '2018-08-02 15:31:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('269', '272', '10', '0', '2018-08-02 15:31:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('270', '273', '11', '0', '2018-08-02 15:31:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('271', '274', '4', '0', '2018-08-02 15:35:37', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('272', '275', '6', '0', '2018-08-02 15:35:44', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('273', '276', '7', '0', '2018-08-02 15:35:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('274', '277', '8', '0', '2018-08-02 15:36:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('275', '278', '10', '0', '2018-08-02 15:36:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('276', '279', '11', '0', '2018-08-02 15:36:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('277', '280', '4', '0', '2018-08-02 15:37:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('278', '281', '6', '0', '2018-08-02 15:37:11', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('279', '282', '7', '0', '2018-08-02 15:37:18', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('280', '283', '8', '0', '2018-08-02 15:37:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('281', '284', '10', '0', '2018-08-02 15:37:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('282', '285', '11', '0', '2018-08-02 15:37:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('283', '286', '1', '0', '2018-08-02 15:41:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('284', '287', '4', '0', '2018-08-02 15:42:36', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('285', '288', '6', '0', '2018-08-02 15:42:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('286', '289', '7', '0', '2018-08-02 15:42:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('287', '290', '8', '0', '2018-08-02 15:43:18', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('288', '291', '10', '0', '2018-08-02 15:43:18', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('289', '292', '11', '0', '2018-08-02 15:43:18', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('290', '293', '1', '0', '2018-08-02 15:44:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('291', '294', '4', '0', '2018-08-02 15:45:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('292', '295', '6', '0', '2018-08-02 15:45:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('293', '296', '7', '0', '2018-08-02 15:45:37', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('294', '297', '8', '0', '2018-08-02 15:45:57', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('295', '298', '10', '0', '2018-08-02 15:45:57', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('296', '299', '11', '0', '2018-08-02 15:45:57', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('297', '300', '4', '0', '2018-08-02 15:48:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('298', '301', '6', '0', '2018-08-02 15:48:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('299', '302', '7', '0', '2018-08-02 15:48:22', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('300', '303', '8', '0', '2018-08-02 15:48:39', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('301', '304', '10', '0', '2018-08-02 15:48:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('302', '305', '11', '0', '2018-08-02 15:48:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('303', '306', '1', '0', '2018-08-02 16:41:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('304', '307', '1', '0', '2018-08-02 16:42:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('305', '308', '1', '0', '2018-08-02 16:44:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('306', '309', '3', '0', '2018-08-02 16:45:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('307', '310', '6', '0', '2018-08-02 16:45:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('308', '311', '7', '0', '2018-08-02 16:45:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('309', '312', '8', '0', '2018-08-02 16:45:36', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('310', '313', '10', '0', '2018-08-02 16:45:36', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('311', '314', '11', '0', '2018-08-02 16:45:36', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('312', '315', '5', '0', '2018-08-02 16:46:56', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('313', '316', '6', '0', '2018-08-02 16:47:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('314', '317', '7', '0', '2018-08-02 16:47:17', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('315', '318', '8', '0', '2018-08-02 16:47:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('316', '319', '10', '0', '2018-08-02 16:47:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('317', '320', '11', '0', '2018-08-02 16:47:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('318', '321', '7', '0', '2018-08-03 11:00:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('319', '322', '1', '0', '2018-08-03 11:41:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('320', '323', '1', '0', '2018-08-04 08:14:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('321', '324', '5', '0', '2018-08-04 08:15:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('322', '325', '6', '0', '2018-08-04 08:15:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('323', '326', '7', '0', '2018-08-04 08:15:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('324', '327', '8', '0', '2018-08-04 08:16:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('325', '328', '10', '0', '2018-08-04 08:16:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('326', '329', '11', '0', '2018-08-04 08:16:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('327', '330', '12', '0', '2018-08-04 09:35:02', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('328', '331', '12', '0', '2018-08-04 09:36:12', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('329', '332', '12', '0', '2018-08-04 09:36:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('330', '333', '12', '0', '2018-08-04 09:36:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('331', '334', '12', '0', '2018-08-04 09:37:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('332', '335', '12', '0', '2018-08-04 09:37:36', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('333', '336', '12', '0', '2018-08-04 09:37:55', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('334', '337', '12', '0', '2018-08-04 09:38:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('335', '338', '12', '0', '2018-08-04 09:40:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('336', '339', '12', '0', '2018-08-04 09:41:11', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('337', '340', '12', '0', '2018-08-04 09:41:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('338', '341', '12', '0', '2018-08-04 09:42:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('339', '342', '12', '0', '2018-08-04 09:43:30', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('340', '343', '12', '0', '2018-08-04 09:44:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('341', '344', '12', '0', '2018-08-04 09:44:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('342', '345', '12', '0', '2018-08-04 09:46:45', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('343', '346', '12', '0', '2018-08-04 09:47:33', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('344', '347', '12', '0', '2018-08-04 09:48:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('345', '348', '12', '0', '2018-08-04 09:50:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('346', '349', '12', '0', '2018-08-04 09:50:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('347', '350', '12', '0', '2018-08-04 09:50:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('348', '351', '12', '0', '2018-08-04 09:51:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('349', '352', '12', '0', '2018-08-04 09:52:17', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('350', '353', '12', '0', '2018-08-04 09:52:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('351', '354', '12', '0', '2018-08-04 09:53:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('352', '355', '12', '0', '2018-08-04 09:53:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('353', '356', '12', '0', '2018-08-04 09:54:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('354', '357', '12', '0', '2018-08-04 09:55:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('355', '358', '12', '0', '2018-08-04 09:55:28', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('356', '359', '12', '0', '2018-08-04 09:55:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('357', '360', '6', '0', '2018-08-07 08:17:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('358', '361', '3', '0', '2018-08-07 09:18:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('359', '362', '3', '0', '2018-08-07 09:19:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('360', '363', '3', '0', '2018-08-07 09:19:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('361', '364', '3', '0', '2018-08-07 09:19:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('362', '365', '3', '0', '2018-08-07 09:20:11', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('363', '366', '13', '0', '2018-08-07 10:01:05', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('364', '367', '1', '0', '2018-08-07 10:01:24', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('365', '368', '4', '0', '2018-08-07 10:02:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('366', '369', '6', '0', '2018-08-07 10:02:17', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('367', '370', '7', '0', '2018-08-07 10:02:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('368', '371', '8', '0', '2018-08-07 10:02:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('369', '372', '10', '0', '2018-08-07 10:02:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('370', '373', '11', '0', '2018-08-07 10:02:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('371', '374', '13', '0', '2018-08-07 10:02:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('372', '375', '13', '0', '2018-08-07 10:04:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('373', '376', '13', '0', '2018-08-07 10:06:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('374', '377', '13', '0', '2018-08-07 10:10:14', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('375', '378', '13', '0', '2018-08-07 10:12:28', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('376', '379', '13', '0', '2018-08-07 10:14:42', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('377', '380', '13', '0', '2018-08-07 10:16:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('378', '381', '13', '0', '2018-08-07 10:18:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('379', '382', '13', '0', '2018-08-07 10:21:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('380', '383', '8', '0', '2018-08-07 10:27:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('381', '384', '10', '0', '2018-08-07 10:27:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('382', '385', '11', '0', '2018-08-07 10:27:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('383', '386', '13', '0', '2018-08-07 10:42:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('384', '387', '13', '0', '2018-08-07 10:45:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('385', '388', '13', '0', '2018-08-07 10:50:13', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('386', '389', '13', '0', '2018-08-07 10:57:18', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('387', '390', '13', '0', '2018-08-07 11:01:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('388', '391', '13', '0', '2018-08-07 11:04:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('389', '392', '13', '0', '2018-08-07 11:08:12', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('390', '393', '13', '0', '2018-08-07 11:11:34', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('391', '394', '12', '0', '2018-08-07 11:12:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('392', '395', '13', '0', '2018-08-07 11:13:31', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('393', '396', '5', '0', '2018-08-07 11:16:12', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('394', '397', '5', '0', '2018-08-07 11:17:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('395', '398', '5', '0', '2018-08-07 11:17:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('396', '399', '5', '0', '2018-08-07 11:18:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('397', '400', '5', '0', '2018-08-07 11:18:28', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('398', '401', '13', '0', '2018-08-07 11:21:19', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('399', '402', '3', '0', '2018-08-07 11:23:12', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('400', '403', '1', '0', '2018-08-07 11:25:53', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('401', '404', '5', '0', '2018-08-07 11:26:20', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('402', '405', '13', '0', '2018-08-07 11:30:02', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('403', '406', '4', '0', '2018-08-07 11:31:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('404', '407', '13', '0', '2018-08-07 11:34:28', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('405', '408', '13', '0', '2018-08-07 11:36:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('406', '409', '4', '0', '2018-08-07 11:38:24', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('407', '410', '1', '0', '2018-08-07 11:40:48', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('408', '411', '1', '0', '2018-08-07 11:43:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('409', '412', '4', '0', '2018-08-07 11:43:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('410', '413', '4', '0', '2018-08-07 11:44:56', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('411', '414', '6', '0', '2018-08-07 11:45:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('412', '415', '7', '0', '2018-08-07 11:45:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('413', '416', '8', '0', '2018-08-07 11:45:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('414', '417', '10', '0', '2018-08-07 11:45:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('415', '418', '11', '0', '2018-08-07 11:45:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('416', '419', '12', '0', '2018-08-07 13:29:19', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('417', '420', '1', '0', '2018-08-07 14:23:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('418', '421', '3', '0', '2018-08-07 14:24:26', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('419', '422', '6', '0', '2018-08-07 14:25:11', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('420', '423', '7', '0', '2018-08-07 14:25:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('421', '424', '8', '0', '2018-08-07 14:26:44', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('422', '425', '10', '0', '2018-08-07 14:26:44', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('423', '426', '11', '0', '2018-08-07 14:26:44', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('424', '427', '8', '0', '2018-08-07 16:36:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('425', '428', '10', '0', '2018-08-07 16:36:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('426', '429', '11', '0', '2018-08-07 16:36:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('427', '430', '8', '0', '2018-08-07 17:29:26', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('428', '431', '10', '0', '2018-08-07 17:29:26', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('429', '432', '11', '0', '2018-08-07 17:29:26', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('430', '433', '9', '0', '2018-08-08 08:50:47', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('431', '434', '9', '0', '2018-08-08 08:52:10', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('432', '435', '9', '0', '2018-08-08 08:52:56', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('433', '436', '12', '0', '2018-08-08 11:06:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('434', '437', '12', '0', '2018-08-08 11:07:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('435', '438', '6', '0', '2018-08-13 15:22:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('436', '439', '7', '0', '2018-08-13 16:01:37', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('437', '440', '8', '0', '2018-08-13 16:03:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('438', '441', '10', '0', '2018-08-13 16:03:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('439', '442', '11', '0', '2018-08-13 16:03:07', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('440', '443', '6', '0', '2018-08-13 16:52:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('441', '444', '6', '0', '2018-08-14 10:43:49', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('442', '445', '6', '0', '2018-08-14 11:02:32', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('443', '446', '7', '0', '2018-08-14 17:17:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('444', '447', '6', '0', '2018-08-15 09:03:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('445', '448', '12', '0', '2018-08-15 09:45:30', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('446', '449', '9', '0', '2018-08-15 09:49:16', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('447', '450', '7', '0', '2018-08-15 10:13:47', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('448', '451', '8', '0', '2018-08-15 10:14:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('449', '452', '10', '0', '2018-08-15 10:14:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('450', '453', '11', '0', '2018-08-15 10:14:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('451', '454', '7', '0', '2018-08-15 10:14:54', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('452', '455', '8', '0', '2018-08-15 10:15:30', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('453', '456', '10', '0', '2018-08-15 10:15:30', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('454', '457', '11', '0', '2018-08-15 10:15:30', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('455', '458', '8', '0', '2018-08-15 10:16:31', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('456', '459', '10', '0', '2018-08-15 10:16:31', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('457', '460', '11', '0', '2018-08-15 10:16:31', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('458', '461', '1', '0', '2018-08-15 10:24:17', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('459', '463', '4', '0', '2018-08-15 10:25:37', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('460', '464', '13', '0', '2018-08-15 10:30:09', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('461', '465', '13', '0', '2018-08-15 10:31:41', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('462', '466', '25', '0', '2018-08-15 14:04:20', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('463', '467', '7', '0', '2018-08-16 09:23:38', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('464', '468', '8', '0', '2018-08-16 09:24:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('465', '469', '10', '0', '2018-08-16 09:24:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('466', '470', '11', '0', '2018-08-16 09:24:40', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('467', '471', '7', '0', '2018-08-16 10:11:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('468', '472', '12', '0', '2018-08-16 10:26:01', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('469', '473', '12', '0', '2018-08-16 10:27:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('470', '474', '12', '0', '2018-08-16 10:28:22', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('471', '475', '12', '0', '2018-08-16 10:31:46', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('472', '476', '12', '0', '2018-08-16 10:51:43', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('473', '477', '13', '0', '2018-08-16 10:53:27', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('474', '478', '9', '0', '2018-08-16 10:58:35', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('475', '479', '12', '0', '2018-08-16 11:00:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('476', '480', '12', '0', '2018-08-16 11:01:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('477', '481', '1', '0', '2018-08-16 11:03:20', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('478', '483', '3', '0', '2018-08-16 11:05:04', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('479', '484', '6', '0', '2018-08-16 11:05:21', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('480', '485', '7', '0', '2018-08-16 11:05:25', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('481', '486', '1', '0', '2018-08-16 11:06:52', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('482', '487', '3', '0', '2018-08-16 11:07:29', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('483', '488', '6', '0', '2018-08-16 11:07:41', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('484', '489', '7', '0', '2018-08-16 11:07:50', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('485', '490', '8', '0', '2018-08-16 11:14:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('486', '491', '10', '0', '2018-08-16 11:14:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('487', '492', '11', '0', '2018-08-16 11:14:23', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('488', '493', '12', '0', '2018-08-16 11:15:08', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('489', '494', '15', '0', '2018-08-16 11:18:39', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('490', '495', '20', '0', '2018-08-16 11:22:03', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('491', '496', '21', '0', '2018-08-16 11:22:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('492', '497', '10', '0', '2018-08-16 11:22:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('493', '498', '11', '0', '2018-08-16 11:22:51', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('494', '499', '12', '0', '2018-08-16 11:24:15', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('495', '500', '25', '0', '2018-08-16 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('496', '501', '25', '0', '2018-08-16 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('497', '502', '25', '0', '2018-08-16 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('498', '503', '25', '0', '2018-08-16 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('499', '504', '25', '0', '2018-08-16 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('500', '505', '26', '0', '2018-08-16 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('501', '506', '25', '0', '2018-08-17 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('502', '507', '25', '0', '2018-08-17 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('503', '508', '27', '0', '2018-08-20 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('504', '509', '28', '0', '2018-08-20 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('505', '510', '29', '0', '2018-08-20 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('506', '510', '34', '0', '2018-08-20 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('507', '511', '26', '0', '2018-08-20 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('508', '512', '35', '0', '2018-08-20 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('509', '512', '37', '0', '2018-08-20 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('510', '513', '27', '0', '2018-08-20 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('511', '514', '28', '0', '2018-08-20 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('512', '515', '29', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('513', '515', '34', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('514', '516', '28', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('515', '517', '29', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('516', '517', '34', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('517', '518', '29', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('518', '518', '34', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('519', '519', '29', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('520', '519', '34', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('521', '520', '29', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('522', '520', '34', '0', '2018-08-21 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('523', '521', '29', '0', '2018-08-22 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('524', '521', '34', '0', '2018-08-22 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('525', '522', '35', '0', '2018-08-22 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('526', '522', '38', '0', '2018-08-22 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('527', '523', '29', '0', '2018-08-22 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('528', '523', '34', '0', '2018-08-22 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('529', '524', '13', '0', '2018-08-23 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('530', '525', '29', '0', '2018-08-28 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('531', '525', '34', '0', '2018-08-28 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('532', '526', '29', '0', '2018-08-28 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('533', '526', '34', '0', '2018-08-28 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('534', '527', '13', '0', '2018-08-29 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('535', '528', '13', '0', '2018-08-29 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('536', '529', '13', '0', '2018-08-29 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('537', '530', '13', '0', '2018-08-29 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('538', '531', '13', '0', '2018-08-29 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('539', '532', '13', '0', '2018-08-29 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('540', '533', '29', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('541', '533', '34', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('542', '534', '29', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('543', '534', '34', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('544', '535', '13', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('545', '536', '13', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('546', '537', '29', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('547', '537', '34', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('548', '538', '29', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('549', '538', '34', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('550', '539', '35', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('551', '539', '38', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('552', '540', '39', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('553', '540', '41', '0', '2018-08-30 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('554', '541', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('555', '541', '37', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('556', '542', '29', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('557', '542', '30', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('558', '543', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('559', '543', '30', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('560', '544', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('561', '544', '30', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('562', '545', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('563', '545', '30', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('564', '546', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('565', '546', '30', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('566', '547', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('567', '547', '30', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('568', '548', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('569', '548', '30', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('570', '549', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('571', '549', '30', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('572', '550', '39', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('573', '550', '41', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('574', '551', '39', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('575', '551', '41', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('576', '552', '39', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('577', '552', '41', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('578', '553', '39', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('579', '553', '41', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('580', '554', '39', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('581', '554', '41', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('582', '555', '39', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('583', '555', '41', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('584', '556', '39', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('585', '556', '41', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('586', '557', '39', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('587', '557', '41', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('588', '558', '13', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('589', '559', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('590', '559', '38', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('591', '560', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('592', '560', '38', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('593', '561', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('594', '561', '38', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('595', '562', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('596', '562', '38', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('597', '563', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('598', '563', '38', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('599', '564', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('600', '564', '38', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('601', '565', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('602', '565', '38', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('603', '566', '35', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('604', '566', '38', '0', '2018-08-31 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('605', '567', '35', '0', '2018-09-03 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('606', '567', '30', '0', '2018-09-03 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('607', '568', '35', '0', '2018-09-03 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('608', '568', '30', '0', '2018-09-03 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('609', '569', '13', '0', '2018-09-04 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('610', '570', '35', '0', '2018-09-05 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('611', '570', '30', '0', '2018-09-05 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('612', '571', '35', '0', '2018-09-05 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('613', '571', '30', '0', '2018-09-05 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('614', '572', '35', '0', '2018-09-05 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('615', '572', '30', '0', '2018-09-05 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('616', '573', '1', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('617', '574', '1', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('618', '575', '29', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('619', '575', '34', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('620', '576', '29', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('621', '576', '34', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('622', '577', '29', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('623', '577', '34', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('624', '578', '29', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('625', '578', '34', '0', '2018-09-06 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('626', '579', '39', '0', '2018-09-07 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('627', '579', '41', '0', '2018-09-07 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('628', '580', '13', '0', '2018-09-10 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('629', '581', '13', '0', '2018-09-10 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('630', '582', '39', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('631', '582', '41', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('632', '583', '35', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('633', '583', '38', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('634', '584', '35', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('635', '584', '38', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('636', '585', '39', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('637', '585', '41', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('638', '586', '35', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('639', '586', '38', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('640', '587', '39', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('641', '587', '41', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('642', '588', '35', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('643', '588', '38', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('644', '589', '39', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('645', '589', '41', '0', '2018-09-11 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('646', '590', '35', '0', '2018-09-12 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('647', '590', '38', '0', '2018-09-12 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('648', '591', '39', '0', '2018-09-12 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('649', '591', '41', '0', '2018-09-12 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('650', '592', '39', '0', '2018-09-12 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('651', '592', '41', '0', '2018-09-12 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('652', '593', '35', '0', '2018-09-12 00:00:00', null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_log_responsibles` VALUES ('653', '593', '38', '0', '2018-09-12 00:00:00', null, '0000-00-00 00:00:00', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=latin1;

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
INSERT INTO `wfl_status_responsibles` VALUES ('15', '7', '13', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('16', '7', '14', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('17', '3', '15', '0', null, null, '2018-08-01 10:41:08', null);
INSERT INTO `wfl_status_responsibles` VALUES ('18', '4', '15', '0', null, null, '2018-08-01 10:43:06', null);
INSERT INTO `wfl_status_responsibles` VALUES ('19', '5', '15', '0', null, null, '2018-08-01 10:43:06', null);
INSERT INTO `wfl_status_responsibles` VALUES ('20', '8', '16', '0', null, null, '2018-08-01 10:43:51', null);
INSERT INTO `wfl_status_responsibles` VALUES ('21', '9', '17', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('22', '8', '18', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('23', '9', '19', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('24', '7', '20', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('25', '10', '22', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('26', '10', '23', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('27', '10', '24', '0', null, null, '2018-08-10 09:54:42', null);
INSERT INTO `wfl_status_responsibles` VALUES ('28', '10', '25', '0', null, null, '2018-08-10 09:54:56', null);
INSERT INTO `wfl_status_responsibles` VALUES ('29', '11', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('30', '12', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('31', '10', '26', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('33', '13', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('34', '14', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('35', '15', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('36', '16', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('37', '17', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('38', '18', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('39', '19', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('40', '20', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('41', '21', '21', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('42', '11', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('43', '12', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('44', '13', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('45', '14', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('46', '15', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('47', '16', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('48', '17', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('49', '18', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('50', '19', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('51', '20', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('52', '21', '27', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('53', '11', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('54', '12', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('55', '13', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('56', '14', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('57', '15', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('58', '16', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('59', '17', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('60', '18', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('61', '19', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('62', '20', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('63', '21', '28', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('64', '11', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('65', '12', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('66', '13', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('67', '14', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('68', '15', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('69', '16', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('70', '17', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('71', '18', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('72', '19', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('73', '20', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('74', '21', '29', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('75', '11', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('76', '12', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('77', '13', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('78', '14', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('79', '15', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('80', '16', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('81', '17', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('82', '18', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('83', '19', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('84', '20', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('85', '21', '30', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('86', '11', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('87', '12', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('88', '13', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('89', '14', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('90', '15', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('91', '16', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('92', '17', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('93', '18', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('94', '19', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('95', '20', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('96', '21', '31', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('97', '11', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('98', '12', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('99', '13', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('100', '14', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('101', '15', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('102', '16', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('103', '17', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('104', '18', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('105', '19', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('106', '20', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('107', '21', '32', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('108', '11', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('109', '12', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('110', '13', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('111', '14', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('112', '15', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('113', '16', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('114', '17', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('115', '18', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('116', '19', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('117', '20', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('118', '21', '33', '0', null, null, '2018-08-31 15:48:55', null);
INSERT INTO `wfl_status_responsibles` VALUES ('119', '11', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('120', '12', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('121', '13', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('122', '14', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('123', '15', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('124', '16', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('125', '17', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('126', '18', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('127', '19', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('128', '20', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('129', '21', '34', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('130', '11', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('131', '12', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('132', '13', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('133', '14', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('134', '15', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('135', '16', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('136', '17', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('137', '18', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('138', '19', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('139', '20', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('140', '21', '35', '0', null, null, '2018-08-31 15:49:24', null);
INSERT INTO `wfl_status_responsibles` VALUES ('141', '11', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('142', '12', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('143', '13', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('144', '14', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('145', '15', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('146', '16', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('147', '17', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('148', '18', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('149', '19', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('150', '20', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('151', '21', '38', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('152', '11', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('153', '12', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('154', '13', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('155', '14', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('156', '15', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('157', '16', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('158', '17', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('159', '18', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('160', '19', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('161', '20', '39', '0', null, null, '0000-00-00 00:00:00', null);
INSERT INTO `wfl_status_responsibles` VALUES ('162', '21', '39', '0', null, null, '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for wfl_warehouses
-- ----------------------------
DROP TABLE IF EXISTS `wfl_warehouses`;
CREATE TABLE `wfl_warehouses` (
  `id_war` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id_war` varchar(20) DEFAULT NULL,
  `status_id_war` varchar(15) DEFAULT NULL,
  `deleted_war` smallint(6) DEFAULT '0',
  `createdon_war` datetime DEFAULT NULL,
  `createdby_war` bigint(20) DEFAULT NULL,
  `editedon_war` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_war` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_war`),
  UNIQUE KEY `UQ_sec_roles_id_rol` (`id_war`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_warehouses
-- ----------------------------
INSERT INTO `wfl_warehouses` VALUES ('1', '53', '26', '0', '2018-08-29 11:30:18', '1', '2018-08-31 16:08:57', '1');
INSERT INTO `wfl_warehouses` VALUES ('2', '53', '22', '1', '2018-08-30 12:10:48', '1', '2018-08-30 14:40:12', null);
INSERT INTO `wfl_warehouses` VALUES ('3', '53', '36', '1', '2018-08-30 12:12:45', '1', '2018-08-30 14:40:12', null);
INSERT INTO `wfl_warehouses` VALUES ('4', '75', '36', '0', '2018-08-30 14:41:06', '1', '2018-08-31 14:13:15', '1');
INSERT INTO `wfl_warehouses` VALUES ('5', '60', '22', '0', '2018-08-30 14:44:54', '1', '2018-08-30 14:44:54', '1');
INSERT INTO `wfl_warehouses` VALUES ('6', '59', '22', '0', '2018-08-30 14:50:20', '1', '2018-08-30 14:50:20', '1');
INSERT INTO `wfl_warehouses` VALUES ('7', '53', '23', '1', '2018-08-30 14:51:38', '1', '2018-08-31 16:08:32', '1');
INSERT INTO `wfl_warehouses` VALUES ('8', '75', '22', '1', '2018-08-31 10:16:09', '1', '2018-08-31 10:32:59', '1');
INSERT INTO `wfl_warehouses` VALUES ('9', '75', '22', '1', '2018-08-31 10:19:53', '1', '2018-08-31 10:32:59', '1');
INSERT INTO `wfl_warehouses` VALUES ('10', '75', '22', '1', '2018-08-31 10:23:41', '1', '2018-08-31 10:32:59', '1');
INSERT INTO `wfl_warehouses` VALUES ('11', '75', '22', '1', '2018-08-31 10:30:42', '1', '2018-08-31 10:32:59', '1');
INSERT INTO `wfl_warehouses` VALUES ('12', '8', '26', '0', '2018-08-31 16:50:16', '1', '2018-08-31 17:13:50', '10');
INSERT INTO `wfl_warehouses` VALUES ('13', '74', '22', '0', '2018-09-04 11:41:14', '1', '2018-09-04 11:41:15', '1');
INSERT INTO `wfl_warehouses` VALUES ('14', '12', '22', '0', '2018-09-06 14:07:09', '1', '2018-09-06 14:07:10', '1');
INSERT INTO `wfl_warehouses` VALUES ('15', '13', '22', '0', '2018-09-06 14:07:10', '1', '2018-09-06 14:07:10', '1');
INSERT INTO `wfl_warehouses` VALUES ('16', '15', '22', '0', '2018-09-06 14:07:11', '1', '2018-09-06 14:07:11', '1');
INSERT INTO `wfl_warehouses` VALUES ('17', '16', '22', '0', '2018-09-06 14:07:11', '1', '2018-09-06 14:07:12', '1');
INSERT INTO `wfl_warehouses` VALUES ('18', '17', '22', '0', '2018-09-06 14:07:12', '1', '2018-09-06 14:07:12', '1');
INSERT INTO `wfl_warehouses` VALUES ('19', '18', '22', '0', '2018-09-06 14:07:12', '1', '2018-09-06 14:07:12', '1');

-- ----------------------------
-- Table structure for wfl_warehouse_status_log
-- ----------------------------
DROP TABLE IF EXISTS `wfl_warehouse_status_log`;
CREATE TABLE `wfl_warehouse_status_log` (
  `id_wsl` bigint(20) NOT NULL AUTO_INCREMENT,
  `warehouse_id_wsl` bigint(20) DEFAULT NULL,
  `status_id_wsl` bigint(20) DEFAULT NULL,
  `log_detail_wsl` text,
  `manual_entry_date_wsl` datetime DEFAULT NULL,
  `deleted_wsl` smallint(6) DEFAULT '0',
  `createdon_wsl` datetime DEFAULT NULL,
  `createdby_wsl` bigint(20) DEFAULT NULL,
  `editedon_wsl` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `editedby_wsl` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_wsl`),
  KEY `fk_warehouse_id_wsl` (`warehouse_id_wsl`) USING BTREE,
  KEY `fk_status_id_wsl` (`status_id_wsl`) USING BTREE,
  CONSTRAINT `wfl_warehouse_status_log_ibfk_1` FOREIGN KEY (`warehouse_id_wsl`) REFERENCES `wfl_projects` (`id_pro`),
  CONSTRAINT `wfl_warehouse_status_log_ibfk_2` FOREIGN KEY (`status_id_wsl`) REFERENCES `wfl_project_status` (`id_pst`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wfl_warehouse_status_log
-- ----------------------------
INSERT INTO `wfl_warehouse_status_log` VALUES ('1', '1', '22', 'Almacen inicia procesos para el proyecto', '2018-08-30 10:43:26', '0', null, null, '2018-08-30 10:43:30', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('2', '1', '23', 'Listo el grabado de materiales', '2018-08-30 14:24:05', '0', '2018-08-30 14:24:05', '1', '2018-08-30 14:24:05', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('3', '1', '24', 'Los materiales fueron retirados de CRE', '2018-08-30 14:26:10', '0', '2018-08-30 14:26:10', '1', '2018-08-30 14:26:10', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('4', '1', '25', 'Se puso en obra los materiales de construccion', '2018-08-30 14:26:39', '0', '2018-08-30 14:26:39', '1', '2018-08-30 14:26:39', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('5', '1', '36', 'Se recibieron materiales de construccion por una pausa', '2018-08-30 14:27:06', '0', '2018-08-30 14:27:07', '1', '2018-08-30 14:28:28', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('6', '1', '25', 'nuevamente se envian los materiales a construccion', '2018-08-30 14:35:44', '0', '2018-08-30 14:35:44', '1', '2018-08-30 14:35:44', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('7', '1', '24', 'se retiran los materiales de CRE', '2018-08-30 14:36:06', '0', '2018-08-30 14:36:06', '1', '2018-08-30 14:36:06', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('8', '1', '23', 'se graban los materiales', '2018-08-30 14:36:18', '0', '2018-08-30 14:36:18', '1', '2018-08-30 14:36:18', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('9', '1', '24', 'grabado de materiales', '2018-08-30 14:39:13', '0', '2018-08-30 14:39:13', '1', '2018-08-30 14:39:13', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('10', '1', '25', 'envio de materiales a construccion', '2018-08-30 14:39:23', '0', '2018-08-30 14:39:23', '1', '2018-08-30 14:39:23', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('11', '1', '36', 'Recepcion de materiales por proyecto completado', '2018-08-30 14:39:38', '0', '2018-08-30 14:39:38', '1', '2018-08-30 14:39:38', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('12', '1', '26', 'Los materiales sobrantes se envian a CRE', '2018-08-30 14:39:53', '0', '2018-08-30 14:39:53', '1', '2018-08-30 14:39:53', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('13', '5', '22', 'Inicio de gestion de materiales de construccion', '2018-08-30 14:44:53', '0', '2018-08-30 14:44:54', '1', '2018-08-30 14:44:54', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('14', '6', '22', 'Inicio de gestion de materiales de construccion', '2018-08-30 14:50:20', '0', '2018-08-30 14:50:20', '1', '2018-08-30 14:50:20', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('15', '7', '22', 'Inicio de gestion de materiales de construccion', '2018-08-30 14:51:38', '0', '2018-08-30 14:51:38', '1', '2018-08-30 14:51:38', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('16', '4', '22', 'Inicio de proceso de almacen', '2018-08-31 10:02:32', '0', '2018-08-31 10:02:32', '1', '2018-08-31 10:02:32', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('17', '4', '23', 'se hace el grabado de materiales', '2018-08-31 10:02:58', '0', '2018-08-31 10:02:58', '1', '2018-08-31 10:02:58', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('18', '4', '24', 'los materiales ahora estan en construccion', '2018-08-31 10:03:13', '0', '2018-08-31 10:03:13', '1', '2018-08-31 10:03:13', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('19', '4', '25', 'Los materiales estan en construccion', '2018-08-31 10:03:31', '0', '2018-08-31 10:03:31', '1', '2018-08-31 10:03:31', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('20', '4', '36', 'Se recibieron los materiales de construccion', '2018-08-31 10:03:51', '0', '2018-08-31 10:03:51', '1', '2018-08-31 10:03:51', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('21', '4', '26', 'Los materiales sobrantes han sido devueltos a CRE', '2018-08-31 10:04:05', '0', '2018-08-31 10:04:05', '1', '2018-08-31 10:04:05', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('22', '8', '22', 'Inicio de gestion de materiales de construccion', '2018-08-31 10:16:09', '0', '2018-08-31 10:16:09', '1', '2018-08-31 10:16:09', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('23', '9', '22', 'Inicio de gestion de materiales de construccion', '2018-08-31 10:19:53', '0', '2018-08-31 10:19:53', '1', '2018-08-31 10:19:53', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('24', '10', '22', 'Inicio de gestion de materiales de construccion', '2018-08-31 10:23:41', '0', '2018-08-31 10:23:41', '1', '2018-08-31 10:23:41', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('25', '4', '25', 'testing not duplicate warehouse', '2018-08-31 10:30:20', '0', '2018-08-31 10:30:20', '1', '2018-08-31 10:30:20', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('26', '11', '22', 'Inicio de gestion de materiales de construccion', '2018-08-31 10:30:42', '0', '2018-08-31 10:30:42', '1', '2018-08-31 10:30:42', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('27', '7', '23', 'Se hizo la grabacion de materiales en CRE', '2018-08-31 12:06:46', '0', '2018-08-31 12:06:46', '1', '2018-08-31 12:06:46', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('28', '4', '36', 'Al parecer hubo una pausa y los encargados han entregado los materiales', '2018-08-31 14:13:15', '0', '2018-08-31 14:13:15', '1', '2018-08-31 14:13:15', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('29', '1', '37', 'El fiscal ha recibido la orden de devolucion a CRE', '2018-08-31 16:07:46', '0', '2018-08-31 16:07:46', '1', '2018-08-31 16:07:46', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('30', '1', '26', 'los materiales fueron devueltos a CRE', '2018-08-31 16:08:57', '0', '2018-08-31 16:08:57', '1', '2018-08-31 16:08:57', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('31', '12', '22', 'Inicio de gestion de materiales de construccion', '2018-08-31 16:50:16', '0', '2018-08-31 16:50:16', '1', '2018-08-31 16:50:16', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('32', '12', '23', 'Se hizo el grabado de materiales en CRE', '2018-08-31 16:52:14', '0', '2018-08-31 16:52:14', '10', '2018-08-31 16:52:14', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('33', '12', '24', 'Los materiales han sido retirados de CRE', '2018-08-31 16:53:10', '0', '2018-08-31 16:53:10', '10', '2018-08-31 16:53:10', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('34', '12', '25', 'Entrego materiales a responsables de la construccion', '2018-08-31 16:54:42', '0', '2018-08-31 16:54:42', '10', '2018-08-31 16:54:42', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('35', '12', '37', 'El fiscal ha recibido la orden de devolucion a CRE', '2018-08-31 17:12:22', '0', '2018-08-31 17:12:22', '1', '2018-08-31 17:12:22', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('36', '12', '26', 'He devuelto los materiales a CRE', '2018-08-31 17:13:49', '0', '2018-08-31 17:13:50', '10', '2018-08-31 17:13:50', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('37', '13', '22', 'Inicio de gestion de materiales de construccion', '2018-09-04 11:41:13', '0', '2018-09-04 11:41:14', '1', '2018-09-04 11:41:14', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('38', '14', '22', 'Inicio de gestion de materiales de construccion', '0000-00-00 00:00:00', '0', '2018-09-06 14:07:09', '1', '2018-09-06 14:07:09', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('39', '15', '22', 'Inicio de gestion de materiales de construccion', '0000-00-00 00:00:00', '0', '2018-09-06 14:07:10', '1', '2018-09-06 14:07:10', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('40', '16', '22', 'Inicio de gestion de materiales de construccion', '0000-00-00 00:00:00', '0', '2018-09-06 14:07:11', '1', '2018-09-06 14:07:11', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('41', '17', '22', 'Inicio de gestion de materiales de construccion', '0000-00-00 00:00:00', '0', '2018-09-06 14:07:11', '1', '2018-09-06 14:07:11', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('42', '18', '22', 'Inicio de gestion de materiales de construccion', '0000-00-00 00:00:00', '0', '2018-09-06 14:07:12', '1', '2018-09-06 14:07:12', null);
INSERT INTO `wfl_warehouse_status_log` VALUES ('43', '19', '22', 'Inicio de gestion de materiales de construccion', '0000-00-00 00:00:00', '0', '2018-09-06 14:07:12', '1', '2018-09-06 14:07:12', null);

-- ----------------------------
-- Procedure structure for project_count_all
-- ----------------------------
DROP PROCEDURE IF EXISTS `project_count_all`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `project_count_all`(
	statusId VARCHAR(20),
	responsibleId VARCHAR(20)
)
begin
SET @statusIdFilter1 = IF(statusId = '','1=1',CONCAT(" status_id_psl in (",statusId,") "));
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_pro in (",statusId,") "));
SET @statusIdFilter3 = IF(responsibleId = '','1=1',CONCAT(" responsible_ids like '%",responsibleId,"%'"));
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
		status_log_manual_entry_date.responsible_ids,
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
        			where deleted_psl != 1
        			GROUP BY id_psl
        		) statusLogAndResponsible group by project_id_psl
        ) as max_entry
        LEFT JOIN (
        			SELECT
        				id_psl,
        				project_id_psl,
        				log_detail_psl,
        				manual_entry_date_psl,
        				GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
        				GROUP_CONCAT(id_usr) responsible_ids
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
        			LEFT JOIN sec_users on id_usr = user_id_sre
        			where deleted_psl != 1
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	WHERE
	    deleted_pro != 1
		and ",@statusIdFilter2,"
		and ",@statusIdFilter3,"
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
	responsibleId VARCHAR(20),
	limitt int(3),
    offsett int(3),
    orderBy VARCHAR(40),
    orderType VARCHAR(4)
)
begin
SET @statusIdFilter1 = IF(statusId = '','1=1',CONCAT(" status_id_psl in (",statusId,") "));
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_pro in (",statusId,") "));
SET @statusIdFilter3 = IF(responsibleId = '','1=1',CONCAT(" responsible_ids like '%",responsibleId,"%'"));
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
		status_log_manual_entry_date.responsible_ids,
		id_psl,
		id_war
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
        			where deleted_psl != 1
        			GROUP BY id_psl
        		) statusLogAndResponsible group by project_id_psl
        ) as max_entry
        LEFT JOIN (
        			SELECT
        				id_psl,
        				project_id_psl,
        				log_detail_psl,
        				manual_entry_date_psl,
        				GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
        				GROUP_CONCAT(id_usr) responsible_ids
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
        			LEFT JOIN sec_users on id_usr = user_id_sre
        			where deleted_psl != 1
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
	WHERE
	    deleted_pro != 1
		and ",@statusIdFilter2,"
		and ",@statusIdFilter3,"
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
	responsibleId VARCHAR(20),
	limitt int(3),
	offsett int(3),
	orderBy VARCHAR(40),
	orderType VARCHAR(4),
	textToSearh VARCHAR(20)
)
begin
SET @statusIdFilter1 = IF(statusId = '','1=1',CONCAT(" status_id_psl in (",statusId,") "));
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_pro in (",statusId,") "));
SET @statusIdFilter3 = IF(responsibleId = '','1=1',CONCAT(" responsible_ids like '%",responsibleId,"%'"));
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
		status_log_manual_entry_date.responsible_ids,
		id_psl,
		id_war
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
        			where deleted_psl != 1
        			GROUP BY id_psl
        		) statusLogAndResponsible group by project_id_psl
        ) as max_entry
        LEFT JOIN (
        			SELECT
        				id_psl,
        				project_id_psl,
        				log_detail_psl,
        				manual_entry_date_psl,
        				GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
        				GROUP_CONCAT(id_usr) responsible_ids
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
        			LEFT JOIN sec_users on id_usr = user_id_sre
        			where deleted_psl != 1
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
	WHERE
	    deleted_pro != 1
		and ",@statusIdFilter2,"
		and ",@statusIdFilter3,"
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
	responsibleId VARCHAR(20),
	textToSearh VARCHAR(20)
)
begin
SET @statusIdFilter1 = IF(statusId = '','1=1',CONCAT(" status_id_psl in (",statusId,") "));
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_pro in (",statusId,") "));
SET @statusIdFilter3 = IF(responsibleId = '','1=1',CONCAT(" responsible_ids like '%",responsibleId,"%'"));
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
		status_log_manual_entry_date.responsible_ids,
		id_psl,
		id_war
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
        			where deleted_psl != 1
        			GROUP BY id_psl
        		) statusLogAndResponsible group by project_id_psl
        ) as max_entry
        LEFT JOIN (
        			SELECT
        				id_psl,
        				project_id_psl,
        				log_detail_psl,
        				manual_entry_date_psl,
        				GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
        				GROUP_CONCAT(id_usr) responsible_ids
        			FROM
        				wfl_project_status_log
        			LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
        			LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
        			LEFT JOIN sec_users on id_usr = user_id_sre
        			where deleted_psl != 1
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
	WHERE
	    deleted_pro != 1
		and ",@statusIdFilter2,"
		and ",@statusIdFilter3,"
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

-- ----------------------------
-- Procedure structure for warehouse_count_all
-- ----------------------------
DROP PROCEDURE IF EXISTS `warehouse_count_all`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `warehouse_count_all`(
	statusId VARCHAR(15)
)
begin
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_id_war in (",statusId,") "));
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
		id_psl,
		wfl_warehouses.*
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
        			where deleted_psl != 1
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
        			where deleted_psl != 1
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
	WHERE
	    deleted_pro != 1
		and ",@statusIdFilter2,"
) projects;");
PREPARE stmt FROM @queryy;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for warehouse_get_all
-- ----------------------------
DROP PROCEDURE IF EXISTS `warehouse_get_all`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `warehouse_get_all`(
	statusId VARCHAR(15),
	limitt int(3),
    offsett int(3),
    orderBy VARCHAR(40),
    orderType VARCHAR(4)
)
begin
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_id_war in (",statusId,") "));
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
		id_psl,
		wfl_warehouses.*
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
        			where deleted_psl != 1
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
        			where deleted_psl != 1
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
	WHERE
	    deleted_pro != 1
		and ",@statusIdFilter2,"
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
-- Procedure structure for warehouse_search
-- ----------------------------
DROP PROCEDURE IF EXISTS `warehouse_search`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `warehouse_search`(
	statusId VARCHAR(15),
	limitt int(3),
	offsett int(3),
	orderBy VARCHAR(40),
	orderType VARCHAR(4),
	textToSearh VARCHAR(20)
)
begin
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_id_war in (",statusId,") "));
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
		id_psl,
		wfl_warehouses.*
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
        			where deleted_psl != 1
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
        			where deleted_psl != 1
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
	WHERE
	    deleted_pro != 1
		and ",@statusIdFilter2,"
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
-- Procedure structure for warehouse_search_total_count
-- ----------------------------
DROP PROCEDURE IF EXISTS `warehouse_search_total_count`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `warehouse_search_total_count`(
	statusId VARCHAR(15),
	textToSearh VARCHAR(20)
)
begin
SET @statusIdFilter2 = IF(statusId = '','1=1',CONCAT(" status_id_war in (",statusId,") "));
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
		id_psl,
		id_war
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
        			where deleted_psl != 1
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
        			where deleted_psl != 1
        			GROUP BY id_psl
        			) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
	) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
	LEFT JOIN wfl_project_status on status_pro = id_pst
	LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
	WHERE
	    deleted_pro != 1
		and ",@statusIdFilter2,"
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
