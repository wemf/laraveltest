/*
Navicat MySQL Data Transfer

Source Server         : local pc
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : bd_motor3

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-06-21 12:50:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for activations
-- ----------------------------
DROP TABLE IF EXISTS `activations`;
CREATE TABLE `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` datetime NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of activations
-- ----------------------------
INSERT INTO `activations` VALUES ('2', '2', 'reFPc6Ak7oj4ngpkk4WuqYTsNxjsKeO0', '1', '2017-03-28 08:50:30', '2017-03-28 08:50:30', '2017-03-28 08:50:30');
INSERT INTO `activations` VALUES ('3', '3', 'rH8mWojGV7BbJqLkP7wMTqJz0jddyPKq', '1', '2017-06-09 09:01:32', '2017-06-09 09:01:32', '2017-06-09 09:23:21');

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_latvian_ci NOT NULL,
  `state` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', 'Ideas asertivas', '1');
INSERT INTO `company` VALUES ('2', 'Algar tech', '1');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------

-- ----------------------------
-- Table structure for motor_container
-- ----------------------------
DROP TABLE IF EXISTS `motor_container`;
CREATE TABLE `motor_container` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(45) COLLATE utf8_latvian_ci DEFAULT NULL,
  `container` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `class` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index1` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_container
-- ----------------------------
INSERT INTO `motor_container` VALUES ('1', '0', 'error', null, 'Cuando ocurre un error', '0');
INSERT INTO `motor_container` VALUES ('2', '1', 'div', 'container-root', 'Contenedor de la raiz', '1');
INSERT INTO `motor_container` VALUES ('3', '2', '0', null, 'No tiene contendor', '1');
INSERT INTO `motor_container` VALUES ('4', '3', 'div', 'container-check', 'Contenedor del checkbox, para ocultar elementos dentro el contendor', '1');

-- ----------------------------
-- Table structure for motor_field_type
-- ----------------------------
DROP TABLE IF EXISTS `motor_field_type`;
CREATE TABLE `motor_field_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_db` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `name_html` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index2` (`name_html`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_field_type
-- ----------------------------
INSERT INTO `motor_field_type` VALUES ('1', 'varchar(255)', 'InputText', '1');
INSERT INTO `motor_field_type` VALUES ('2', 'varchar(255)', 'InputLabel', '1');
INSERT INTO `motor_field_type` VALUES ('3', 'varchar(255)', 'InputSelect', '1');
INSERT INTO `motor_field_type` VALUES ('4', 'varchar(255)', 'InputTextArea', '1');
INSERT INTO `motor_field_type` VALUES ('5', 'varchar(255)', 'InputRadio', '1');
INSERT INTO `motor_field_type` VALUES ('6', 'varchar(255)', 'InputCheckbox', '1');
INSERT INTO `motor_field_type` VALUES ('7', 'varchar(255)', 'InputEmail', '1');
INSERT INTO `motor_field_type` VALUES ('8', 'varchar(255)', 'InputNumber', '1');
INSERT INTO `motor_field_type` VALUES ('9', 'varchar(255)', 'InputDate', '1');

-- ----------------------------
-- Table structure for motor_form_definer
-- ----------------------------
DROP TABLE IF EXISTS `motor_form_definer`;
CREATE TABLE `motor_form_definer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `id_style` int(11) unsigned DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_user_created_at` int(11) DEFAULT NULL,
  `id_user_updated_at` int(11) DEFAULT NULL,
  `id_user_deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_master_styles` (`id_style`) USING BTREE,
  CONSTRAINT `motor_form_definers_ibfk_1` FOREIGN KEY (`id_style`) REFERENCES `motor_style` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_form_definer
-- ----------------------------

-- ----------------------------
-- Table structure for motor_form_html
-- ----------------------------
DROP TABLE IF EXISTS `motor_form_html`;
CREATE TABLE `motor_form_html` (
  `id_form` int(10) unsigned NOT NULL,
  `id_html` int(10) unsigned DEFAULT NULL,
  KEY `FK_form_definers_idx` (`id_form`),
  KEY `fk_int_form_html_idx` (`id_html`),
  CONSTRAINT `FK_form_definers` FOREIGN KEY (`id_form`) REFERENCES `motor_form_definer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_int_form_html` FOREIGN KEY (`id_html`) REFERENCES `motor_html` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_form_html
-- ----------------------------

-- ----------------------------
-- Table structure for motor_form_user
-- ----------------------------
DROP TABLE IF EXISTS `motor_form_user`;
CREATE TABLE `motor_form_user` (
  `id_form_definer` int(10) unsigned NOT NULL,
  `id_company` int(10) unsigned NOT NULL,
  `action` longtext COLLATE utf8_latvian_ci COMMENT 'campo ACTION = id_form_definer/id_user/id_persistence_table/operation/id?\n\nOPERATION = INSERT, UPDATE, DELETE',
  `url_css` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  KEY `fk_form_user_user_idx` (`id_company`),
  KEY `fk_form_user_form_definer_idx` (`id_form_definer`),
  CONSTRAINT `fk_form_user_company` FOREIGN KEY (`id_company`) REFERENCES `company` (`id`),
  CONSTRAINT `fk_form_user_form_definer` FOREIGN KEY (`id_form_definer`) REFERENCES `motor_form_definer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_form_user
-- ----------------------------

-- ----------------------------
-- Table structure for motor_html
-- ----------------------------
DROP TABLE IF EXISTS `motor_html`;
CREATE TABLE `motor_html` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `text` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  `placeholder` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `min` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `max` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `step` int(11) DEFAULT NULL,
  `rows` int(11) DEFAULT NULL,
  `cols` int(11) DEFAULT NULL,
  `src` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `width` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `height` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `min_date` date DEFAULT NULL,
  `max_date` date DEFAULT NULL,
  `option` longtext CHARACTER SET utf8 COLLATE utf8_latvian_ci,
  `accept` longtext CHARACTER SET utf8 COLLATE utf8_latvian_ci,
  `id_field_type` int(10) unsigned DEFAULT NULL,
  `id_procedure` int(10) unsigned DEFAULT NULL,
  `id_pattern` int(10) unsigned DEFAULT NULL,
  `parent_level` int(11) DEFAULT NULL,
  `position_in_form` int(11) DEFAULT NULL,
  `id_container` int(10) unsigned DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_attributes_field_db_idx` (`id_field_type`),
  KEY `fk_html_cotainer_idx` (`id_container`),
  KEY `fk_html_procedure_idx` (`id_procedure`),
  KEY `fk_html_pattern_idx` (`id_pattern`),
  CONSTRAINT `FK_attributes_field_db` FOREIGN KEY (`id_field_type`) REFERENCES `motor_field_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_html_cotainer` FOREIGN KEY (`id_container`) REFERENCES `motor_container` (`id`),
  CONSTRAINT `fk_html_pattern` FOREIGN KEY (`id_pattern`) REFERENCES `motor_pattern` (`id`),
  CONSTRAINT `fk_html_procedure` FOREIGN KEY (`id_procedure`) REFERENCES `motor_procedure` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_html
-- ----------------------------

-- ----------------------------
-- Table structure for motor_html_style
-- ----------------------------
DROP TABLE IF EXISTS `motor_html_style`;
CREATE TABLE `motor_html_style` (
  `id_html` int(10) unsigned DEFAULT NULL,
  `id_style` int(10) unsigned DEFAULT NULL,
  KEY `fk_html_style_idhtml_idx` (`id_html`),
  KEY `fk_html_style_idstyle_idx` (`id_style`),
  CONSTRAINT `fk_html_style_idhtml` FOREIGN KEY (`id_html`) REFERENCES `motor_html` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_html_style_idstyle` FOREIGN KEY (`id_style`) REFERENCES `motor_style` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_html_style
-- ----------------------------

-- ----------------------------
-- Table structure for motor_pattern
-- ----------------------------
DROP TABLE IF EXISTS `motor_pattern`;
CREATE TABLE `motor_pattern` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(45) COLLATE utf8_latvian_ci DEFAULT NULL,
  `pattern` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_UNIQUE` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_pattern
-- ----------------------------
INSERT INTO `motor_pattern` VALUES ('1', '0', '', 'sin pattern', '0');
INSERT INTO `motor_pattern` VALUES ('2', '1', '[0-9]{3}[-][0-9]{3}[-][0-9]{4}', 'telefono', '1');
INSERT INTO `motor_pattern` VALUES ('3', '2', '^[1-9]?[0-9]+([.][0-9]{3})*', 'moneda', '1');
INSERT INTO `motor_pattern` VALUES ('4', '3', '[a-zA-Z0-9]+', 'direccion : Alfa-numerico', '1');
INSERT INTO `motor_pattern` VALUES ('5', '4', '([0-9]{5}([-][0-9]{4})?)', 'postal', '1');

-- ----------------------------
-- Table structure for motor_persistence_field
-- ----------------------------
DROP TABLE IF EXISTS `motor_persistence_field`;
CREATE TABLE `motor_persistence_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_persistence_table` int(10) unsigned DEFAULT NULL,
  `id_attribute` int(10) unsigned DEFAULT NULL,
  `name_table_field` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL COMMENT 'Crear procedimiento almacenado para comprobar que no existan tablas con el mismo nombre del formulario.',
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_PERSIS_TABLE_idx` (`id_persistence_table`),
  CONSTRAINT `FK_PERSIS_TABLE` FOREIGN KEY (`id_persistence_table`) REFERENCES `motor_persistence_table` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_persistence_field
-- ----------------------------

-- ----------------------------
-- Table structure for motor_persistence_table
-- ----------------------------
DROP TABLE IF EXISTS `motor_persistence_table`;
CREATE TABLE `motor_persistence_table` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_form_definer` int(10) unsigned DEFAULT NULL,
  `id_company` int(10) unsigned DEFAULT NULL,
  `table_name` varchar(40) COLLATE utf8_latvian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `INDEX_TABLE_NAME` (`table_name`) USING HASH,
  KEY `FK_PERSIS_FORM_idx` (`id_form_definer`),
  KEY `FK_PERSIS_USER_idx` (`id_company`),
  CONSTRAINT `FK_PERSISTANCE_TABLE_COMPANY` FOREIGN KEY (`id_company`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_PERSIS_FORM` FOREIGN KEY (`id_form_definer`) REFERENCES `motor_form_definer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_persistence_table
-- ----------------------------

-- ----------------------------
-- Table structure for motor_procedure
-- ----------------------------
DROP TABLE IF EXISTS `motor_procedure`;
CREATE TABLE `motor_procedure` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(45) COLLATE utf8_latvian_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `id_type_procedure` int(10) unsigned DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_procedure_pro_type_idx` (`id_type_procedure`),
  CONSTRAINT `fk_procedure_pro_type` FOREIGN KEY (`id_type_procedure`) REFERENCES `motor_procedure_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_procedure
-- ----------------------------

-- ----------------------------
-- Table structure for motor_procedure_type
-- ----------------------------
DROP TABLE IF EXISTS `motor_procedure_type`;
CREATE TABLE `motor_procedure_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_procedure_type
-- ----------------------------

-- ----------------------------
-- Table structure for motor_style
-- ----------------------------
DROP TABLE IF EXISTS `motor_style`;
CREATE TABLE `motor_style` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_style_type` int(11) unsigned NOT NULL,
  `class` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_style_types` (`id_style_type`) USING BTREE,
  CONSTRAINT `motor_master_styles_ibfk_1` FOREIGN KEY (`id_style_type`) REFERENCES `motor_style_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_style
-- ----------------------------
INSERT INTO `motor_style` VALUES ('1', '2', 'check', 'Clase para ocultar los check', '1');
INSERT INTO `motor_style` VALUES ('2', '2', 'itm-field', 'Clase para el uso del definidor del formulario, para recorrer los elementos.', '1');
INSERT INTO `motor_style` VALUES ('3', '2', 'ui-state-disabled', 'Clase para el uso del definidor del formulario, bloquea la funcion sorteable.', '1');
INSERT INTO `motor_style` VALUES ('4', '2', 'form_date', 'Clase Datepicker de Jquery, input calendario.', '1');

-- ----------------------------
-- Table structure for motor_style_type
-- ----------------------------
DROP TABLE IF EXISTS `motor_style_type`;
CREATE TABLE `motor_style_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_style_type
-- ----------------------------
INSERT INTO `motor_style_type` VALUES ('1', 'Se applica al formulario', '1');
INSERT INTO `motor_style_type` VALUES ('2', 'Se applica al campo del formulario', '1');

-- ----------------------------
-- Table structure for motor_version_control
-- ----------------------------
DROP TABLE IF EXISTS `motor_version_control`;
CREATE TABLE `motor_version_control` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_form_definer` int(10) unsigned DEFAULT NULL,
  `id_form_child` int(11) DEFAULT NULL,
  `id_form_father` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ver_control_form_definer_idx` (`id_form_definer`),
  CONSTRAINT `fk_ver_control_form_definer` FOREIGN KEY (`id_form_definer`) REFERENCES `motor_form_definer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of motor_version_control
-- ----------------------------

-- ----------------------------
-- Table structure for persistences
-- ----------------------------
DROP TABLE IF EXISTS `persistences`;
CREATE TABLE `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of persistences
-- ----------------------------
INSERT INTO `persistences` VALUES ('2', '2', 'lOdLANR7044bugZEKEUUVM4X4sYuOoiD', '2017-06-08 11:37:04', '2017-06-08 11:37:04');
INSERT INTO `persistences` VALUES ('3', '2', 'l1JqHArVt3gRXjcnyzc7JeL9yammIANG', '2017-06-08 15:34:07', '2017-06-08 15:34:07');
INSERT INTO `persistences` VALUES ('6', '2', 'gisoVnwthHT39PA8U76Wxjp9SYQzekvs', '2017-06-09 12:19:05', '2017-06-09 12:19:05');
INSERT INTO `persistences` VALUES ('7', '2', 'fvJPwnHDKwgLRV7V7qrv5tTKzKKLI2ww', '2017-06-12 08:24:34', '2017-06-12 08:24:34');
INSERT INTO `persistences` VALUES ('8', '2', 'oSYyCRtOz56yUKOk09481fAR7iOooLuK', '2017-06-13 08:07:52', '2017-06-13 08:07:52');
INSERT INTO `persistences` VALUES ('9', '2', 'GQTJh5PlZuK5CyoZWurbmcdXjLVkdGUC', '2017-06-13 15:39:49', '2017-06-13 15:39:49');
INSERT INTO `persistences` VALUES ('10', '2', 's3uMGnDg221H6HSPrmMlGO6upX0bhiEw', '2017-06-14 08:25:46', '2017-06-14 08:25:46');
INSERT INTO `persistences` VALUES ('11', '2', 'aJPoDQIqoJAzO1XUgbJ4kVK1C1shL7o5', '2017-06-14 11:29:36', '2017-06-14 11:29:36');
INSERT INTO `persistences` VALUES ('12', '2', '7RaCqNaOx0lERigeRcWLjBNtvwJk4uDT', '2017-06-16 09:38:04', '2017-06-16 09:38:04');
INSERT INTO `persistences` VALUES ('13', '2', 'nhBxePtbG3Tn4II1DUIO6vuhvryESo1e', '2017-06-20 08:41:25', '2017-06-20 08:41:25');
INSERT INTO `persistences` VALUES ('14', '2', 'zrWTGx42rXRXuBhh64qHO26sLTPYOX1X', '2017-06-20 13:14:39', '2017-06-20 13:14:39');
INSERT INTO `persistences` VALUES ('15', '2', 'RzGiAsrdttsbp8E5bdg8OvQdIywZqDeZ', '2017-06-20 15:26:45', '2017-06-20 15:26:45');
INSERT INTO `persistences` VALUES ('16', '2', 'UhYyyRNglZVCBDm7H9aVz3OuXKd16fT6', '2017-06-21 08:27:46', '2017-06-21 08:27:46');

-- ----------------------------
-- Table structure for reminders
-- ----------------------------
DROP TABLE IF EXISTS `reminders`;
CREATE TABLE `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` datetime NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of reminders
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `permissions` text CHARACTER SET utf8 COLLATE utf8_latvian_ci,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'admin', 'Administrador', 'gestionar usuarios y asignar permisos', '2017-03-28 13:37:52', null);
INSERT INTO `roles` VALUES ('2', 'manager', 'Registrado', 'usuario registrado y visualizar formularios', '2017-03-28 13:37:52', null);
INSERT INTO `roles` VALUES ('3', 'formDuplicated', 'Duplicar Formulario', 'duplicar formularios', '2017-04-11 13:40:49', null);
INSERT INTO `roles` VALUES ('4', 'formUpdate', 'Actualizar Formulario', 'actualizar formularios', '2017-04-11 13:40:49', null);
INSERT INTO `roles` VALUES ('5', 'formDelete', 'Borrar Formulario', 'borrar formularios', '2017-04-12 13:01:30', null);
INSERT INTO `roles` VALUES ('6', 'formCreate', 'Crear Formulario', 'crear formularios', '2017-04-12 13:01:33', null);

-- ----------------------------
-- Table structure for role_users
-- ----------------------------
DROP TABLE IF EXISTS `role_users`;
CREATE TABLE `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of role_users
-- ----------------------------
INSERT INTO `role_users` VALUES ('2', '1', '2017-04-20 10:44:02', null);
INSERT INTO `role_users` VALUES ('2', '2', '2017-03-28 08:50:31', '2017-03-28 08:50:31');
INSERT INTO `role_users` VALUES ('2', '3', '2017-04-20 10:44:02', null);
INSERT INTO `role_users` VALUES ('2', '4', '2017-04-20 10:44:02', null);
INSERT INTO `role_users` VALUES ('2', '5', '2017-04-20 10:44:02', null);
INSERT INTO `role_users` VALUES ('2', '6', '2017-04-20 10:44:02', null);
INSERT INTO `role_users` VALUES ('3', '2', '2017-06-09 09:01:33', '2017-06-09 09:01:33');

-- ----------------------------
-- Table structure for sys_configs
-- ----------------------------
DROP TABLE IF EXISTS `sys_configs`;
CREATE TABLE `sys_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `state` tinyint(1) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of sys_configs
-- ----------------------------
INSERT INTO `sys_configs` VALUES ('1', '1', 'tbl', 'Prefijo tablas persistencia', '1');
INSERT INTO `sys_configs` VALUES ('2', '2', 'Insert', 'Insert', '1');
INSERT INTO `sys_configs` VALUES ('3', '3', 'Update', 'Update', '1');
INSERT INTO `sys_configs` VALUES ('4', '4', 'Delete', 'Delete', '1');
INSERT INTO `sys_configs` VALUES ('5', '5', 'Select', 'Select', '1');

-- ----------------------------
-- Table structure for sys_connection_db
-- ----------------------------
DROP TABLE IF EXISTS `sys_connection_db`;
CREATE TABLE `sys_connection_db` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_latvian_ci DEFAULT NULL,
  `host` varchar(45) COLLATE utf8_latvian_ci DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `database` varchar(45) COLLATE utf8_latvian_ci DEFAULT NULL,
  `user` varchar(45) COLLATE utf8_latvian_ci DEFAULT NULL,
  `password` varchar(45) COLLATE utf8_latvian_ci DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_user_created_at` int(11) DEFAULT NULL,
  `id_user_updated_at` int(11) DEFAULT NULL,
  `id_user_deleted_at` int(11) DEFAULT NULL,
  `id_user` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_connection_db` (`id_user`),
  CONSTRAINT `fk_user_connection_db` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of sys_connection_db
-- ----------------------------

-- ----------------------------
-- Table structure for sys_file_managers
-- ----------------------------
DROP TABLE IF EXISTS `sys_file_managers`;
CREATE TABLE `sys_file_managers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key_lote` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `size` double DEFAULT NULL,
  `extension` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `path` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `date` datetime DEFAULT NULL ,
  `userID` int(255) DEFAULT NULL,
  `hash` longtext CHARACTER SET latin1,
  `state` tinyint(1) DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL,
  `id_user_delete_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `name_2` (`name`,`date`,`key_lote`,`extension`) USING BTREE,
  KEY `key_lote` (`key_lote`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of sys_file_managers
-- ----------------------------

-- ----------------------------
-- Table structure for task_implementation_plan
-- ----------------------------
DROP TABLE IF EXISTS `task_implementation_plan`;
CREATE TABLE `task_implementation_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_implementation` int(11) DEFAULT NULL,
  `query` longtext COLLATE utf8_latvian_ci,
  `id_form_definer` int(10) unsigned DEFAULT NULL,
  `id_persistence_table` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of task_implementation_plan
-- ----------------------------

-- ----------------------------
-- Table structure for task_plan
-- ----------------------------
DROP TABLE IF EXISTS `task_plan`;
CREATE TABLE `task_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of task_plan
-- ----------------------------

-- ----------------------------
-- Table structure for throttle
-- ----------------------------
DROP TABLE IF EXISTS `throttle`;
CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of throttle
-- ----------------------------
INSERT INTO `throttle` VALUES ('1', null, 'global', null, '2017-06-14 08:25:24', '2017-06-14 08:25:24');
INSERT INTO `throttle` VALUES ('2', null, 'ip', '127.0.0.1', '2017-06-14 08:25:24', '2017-06-14 08:25:24');
INSERT INTO `throttle` VALUES ('3', '2', 'user', null, '2017-06-14 08:25:24', '2017-06-14 08:25:24');
INSERT INTO `throttle` VALUES ('4', null, 'global', null, '2017-06-14 14:06:08', '2017-06-14 14:06:08');
INSERT INTO `throttle` VALUES ('5', null, 'ip', '127.0.0.1', '2017-06-14 14:06:08', '2017-06-14 14:06:08');
INSERT INTO `throttle` VALUES ('6', '2', 'user', null, '2017-06-14 14:06:08', '2017-06-14 14:06:08');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `permissions` text CHARACTER SET utf8 COLLATE utf8_latvian_ci,
  `last_login` datetime NULL DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `id_user_type` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE,
  KEY `fk_user_user_type_idx` (`id_user_type`),
  CONSTRAINT `fk_user_user_type` FOREIGN KEY (`id_user_type`) REFERENCES `user_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('2', 'admin@admin.co', '$2y$10$nPR6WrpNKWcErwuTl/kQp.AUsOoYxTncWjahbaprnbs6rWg48nWD.', null, '2017-06-21 08:27:46', 'Gonzalo de Jesus', 'Perez Edit', '1', '2017-03-28 08:50:30', '2017-06-21 08:27:46', null, '1');
INSERT INTO `users` VALUES ('3', 'prueba@prueba.co', '$2y$10$ljctYokpKqemTV2wKiuB4eq5wkCRR/BF19lPL5rYJhP877HzuCuoK', null, null, 'Holaeee', 'Pruebarrr', null, '2017-06-09 09:01:32', '2017-06-09 09:23:21', '2017-06-09 09:22:27', '1');

-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of user_type
-- ----------------------------
INSERT INTO `user_type` VALUES ('1', 'noraml', null, '1');

-- ----------------------------
-- Procedure structure for createTables
-- ----------------------------
DROP PROCEDURE IF EXISTS `createTables`;
DELIMITER ;;
CREATE PROCEDURE `createTables`(IN `dato` INT)
BEGIN
	DECLARE tabla long;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION 
		BEGIN 
		SELECT 1 AS error; 
		ROLLBACK; 
	END; 
	DECLARE EXIT HANDLER FOR SQLWARNING 
		BEGIN 
		SELECT 1 AS error; 
		ROLLBACK; 
	END;
	START TRANSACTION;
		SET @tabla = (
						select task_implementation_plan.query from task_plan 
						inner join task_implementation_plan on task_plan.id = task_implementation_plan.id_implementation
						where task_plan.id = dato
					);
		PREPARE myquery FROM @tabla;
		EXECUTE myquery;
		UPDATE task_plan SET task_plan.status = 1 WHERE id = dato;
		UPDATE task_implementation_plan SET task_implementation_plan.status = 1 WHERE id_implementation = dato;

	COMMIT;
	SELECT 0 AS error;
	
END
;;
DELIMITER ;
SET FOREIGN_KEY_CHECKS=1;
