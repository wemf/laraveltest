/*
Navicat MySQL Data Transfer

Source Server         : nutibara homologacion
Source Server Version : 100031
Source Host           : 131.0.136.68:3306
Source Database       : c1bd_nutibara_dev

Target Server Type    : MYSQL
Target Server Version : 100031
File Encoding         : 65001

Date: 2017-08-29 15:50:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_latvian_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_calificacion
-- ----------------------------
DROP TABLE IF EXISTS `tbl_calificacion`;
CREATE TABLE `tbl_calificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `valor_min` float DEFAULT NULL,
  `valor_max` float DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_calificacion
-- ----------------------------
INSERT INTO `tbl_calificacion` VALUES ('1', 'Diamante', '80000', '200000', '');
INSERT INTO `tbl_calificacion` VALUES ('2', 'Plata', '30000', '59999', '');
INSERT INTO `tbl_calificacion` VALUES ('3', 'Platinos', '150', '555', '\0');
INSERT INTO `tbl_calificacion` VALUES ('4', 'Oro Golfi', '200000', '300000', '\0');
INSERT INTO `tbl_calificacion` VALUES ('5', 'Oros', '10000', '40000', '\0');
INSERT INTO `tbl_calificacion` VALUES ('6', 'plastico', '100', '2000', '');
INSERT INTO `tbl_calificacion` VALUES ('7', 'Papel', '10', '1200', '\0');
INSERT INTO `tbl_calificacion` VALUES ('8', '2', '211', '211', '');
INSERT INTO `tbl_calificacion` VALUES ('13', 'Cobre', '5000', '10000', '');

-- ----------------------------
-- Table structure for tbl_ciudad
-- ----------------------------
DROP TABLE IF EXISTS `tbl_ciudad`;
CREATE TABLE `tbl_ciudad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext,
  `id_departamento` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`,`id_departamento`) USING BTREE,
  KEY `PK_CIU_DEP` (`id_departamento`) USING BTREE,
  CONSTRAINT `tbl_ciudad_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `tbl_departamento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_ciudad
-- ----------------------------
INSERT INTO `tbl_ciudad` VALUES ('1', 'Medellín', '', '5', '1');
INSERT INTO `tbl_ciudad` VALUES ('2', 'Santa Marta', null, '6', '1');
INSERT INTO `tbl_ciudad` VALUES ('3', 'Prueba', null, '4', '0');
INSERT INTO `tbl_ciudad` VALUES ('4', 'Ankara', 'as', '4', '0');
INSERT INTO `tbl_ciudad` VALUES ('5', 'Sabaneta', 'as', '5', '1');
INSERT INTO `tbl_ciudad` VALUES ('6', 'Rionegro', 'a', '5', '1');
INSERT INTO `tbl_ciudad` VALUES ('9', 'Prueba', 'Prueba', '5', '1');

-- ----------------------------
-- Table structure for tbl_clie_area_laboral
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_area_laboral`;
CREATE TABLE `tbl_clie_area_laboral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_area_laboral
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_clie_area_trabajo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_area_trabajo`;
CREATE TABLE `tbl_clie_area_trabajo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  `descripcion` mediumtext,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_area_trabajo
-- ----------------------------
INSERT INTO `tbl_clie_area_trabajo` VALUES ('1', 'Joyeria', 'Se vende joyas', '');
INSERT INTO `tbl_clie_area_trabajo` VALUES ('2', 'Platerias', 'Se vende  Platass', '');
INSERT INTO `tbl_clie_area_trabajo` VALUES ('3', 'Fábrica34r', 'Innovacióndfdf32', '');
INSERT INTO `tbl_clie_area_trabajo` VALUES ('6', 'Soporte', 'área de soporte tecnico', '');
INSERT INTO `tbl_clie_area_trabajo` VALUES ('7', 'Fabrica Innovacion', 'Area de desarrollo de software', '');
INSERT INTO `tbl_clie_area_trabajo` VALUES ('9', 'Porcelana', 'Material delicado', '\0');
INSERT INTO `tbl_clie_area_trabajo` VALUES ('10', 'Atencion al cliente', 'Atencions', '');

-- ----------------------------
-- Table structure for tbl_clie_caja_compensacion
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_caja_compensacion`;
CREATE TABLE `tbl_clie_caja_compensacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_caja_compensacion
-- ----------------------------
INSERT INTO `tbl_clie_caja_compensacion` VALUES ('1', 'Comfama', '');
INSERT INTO `tbl_clie_caja_compensacion` VALUES ('2', 'Confenalco', '');

-- ----------------------------
-- Table structure for tbl_clie_confiabilidad
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_confiabilidad`;
CREATE TABLE `tbl_clie_confiabilidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_confiabilidad
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_clie_dias_estudio
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_dias_estudio`;
CREATE TABLE `tbl_clie_dias_estudio` (
  `codigo_cliente` bigint(20) NOT NULL,
  `id_tienda` int(11) NOT NULL,
  `lunes` int(11) DEFAULT NULL,
  `martes` int(11) DEFAULT NULL,
  `miercoles` int(11) DEFAULT NULL,
  `jueves` int(11) DEFAULT NULL,
  `viernes` int(11) DEFAULT NULL,
  `sabado` int(11) DEFAULT NULL,
  `domingo` int(11) DEFAULT NULL,
  UNIQUE KEY `codigo_cliente_UNIQUE` (`codigo_cliente`,`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_dias_estudio
-- ----------------------------
INSERT INTO `tbl_clie_dias_estudio` VALUES ('1', '1', '1', '1', '1', '1', null, null, null);
INSERT INTO `tbl_clie_dias_estudio` VALUES ('6', '1', '1', null, null, '1', null, null, '1');

-- ----------------------------
-- Table structure for tbl_clie_empleado
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_empleado`;
CREATE TABLE `tbl_clie_empleado` (
  `id_tienda` int(11) NOT NULL,
  `codigo_cliente` bigint(20) NOT NULL,
  `id_cargo_empleado` int(11) DEFAULT NULL,
  `ha_laborado_nutibara` bit(1) DEFAULT NULL,
  `id_ciudad_trabajo` int(11) DEFAULT NULL,
  `id_tipo_contrato` int(11) DEFAULT NULL,
  `id_motivo_retiro` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_retiro` date DEFAULT NULL,
  `salario` float DEFAULT NULL,
  `id_cargo_ejercido_anterior` int(11) DEFAULT NULL,
  `valor_auxilio_vivenda` float DEFAULT NULL,
  `valor_auxilio_transporte` float DEFAULT NULL,
  `otros_aportes` varchar(200) DEFAULT NULL,
  `familiares_en_nutibara` int(1) DEFAULT NULL,
  `numero_hermanos` int(11) DEFAULT NULL,
  `total_personas_a_cargo` int(11) DEFAULT NULL,
  `numero_hijos` int(11) DEFAULT NULL,
  UNIQUE KEY `id_tienda_UNIQUE` (`id_tienda`,`codigo_cliente`),
  KEY `FK_EMP_CLI_CLI_idx` (`codigo_cliente`),
  KEY `FK_EMP_CARGO_idx` (`id_cargo_empleado`),
  KEY `FK_EMP_MOTV_RET` (`id_motivo_retiro`),
  CONSTRAINT `FK_EMP_CARGO` FOREIGN KEY (`id_cargo_empleado`) REFERENCES `tbl_empl_cargo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_EMP_CLI_CLI` FOREIGN KEY (`codigo_cliente`) REFERENCES `tbl_cliente` (`codigo_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_EMP_CLI_TIE` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_cliente` (`id_tienda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_EMP_MOTV_RET` FOREIGN KEY (`id_motivo_retiro`) REFERENCES `tbl_empl_motivo_retiro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_empleado
-- ----------------------------
INSERT INTO `tbl_clie_empleado` VALUES ('1', '6', '4', '', '1', '2', '4', '2017-08-29', '2017-08-30', '2001300', '1', null, null, null, '0', null, null, null);

-- ----------------------------
-- Table structure for tbl_clie_eps
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_eps`;
CREATE TABLE `tbl_clie_eps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_eps
-- ----------------------------
INSERT INTO `tbl_clie_eps` VALUES ('1', 'Sura', '');
INSERT INTO `tbl_clie_eps` VALUES ('2', 'Nueva EPS', '');
INSERT INTO `tbl_clie_eps` VALUES ('3', 'No es beneficiario(a)', '');

-- ----------------------------
-- Table structure for tbl_clie_estado_civil
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_estado_civil`;
CREATE TABLE `tbl_clie_estado_civil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_estado_civil
-- ----------------------------
INSERT INTO `tbl_clie_estado_civil` VALUES ('1', 'Soltero(a)', '');
INSERT INTO `tbl_clie_estado_civil` VALUES ('2', 'Casado(a)', '');
INSERT INTO `tbl_clie_estado_civil` VALUES ('3', 'Divorciado(a)', '');
INSERT INTO `tbl_clie_estado_civil` VALUES ('4', 'Viudo(a)', '');
INSERT INTO `tbl_clie_estado_civil` VALUES ('5', 'Unión Libre', '');
INSERT INTO `tbl_clie_estado_civil` VALUES ('6', 'Esposo(a)', '');

-- ----------------------------
-- Table structure for tbl_clie_estudios
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_estudios`;
CREATE TABLE `tbl_clie_estudios` (
  `codigo_cliente` bigint(20) NOT NULL,
  `id_tienda` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `anos_cursados` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_terminacion` date DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL,
  `titulo_obtenido` varchar(200) DEFAULT NULL,
  `finalizado` int(11) DEFAULT NULL,
  PRIMARY KEY (`codigo_cliente`,`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_estudios
-- ----------------------------
INSERT INTO `tbl_clie_estudios` VALUES ('1', '1', 'Ingeniería Industrial', '5', '2004-08-05', '2010-04-05', 'EAFIT', 'Ingeniero Industrial', '1');
INSERT INTO `tbl_clie_estudios` VALUES ('1', '9', 'Tecno', '5', '2017-08-01', '2017-08-02', 'EAFIT', 'Tecnoólogo', '1');
INSERT INTO `tbl_clie_estudios` VALUES ('6', '1', 'Universitaria', '4', '2013-01-01', '2018-06-14', 'TdeA', 'Ing. Ambiental', '2');

-- ----------------------------
-- Table structure for tbl_clie_fondo_cesantias
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_fondo_cesantias`;
CREATE TABLE `tbl_clie_fondo_cesantias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_fondo_cesantias
-- ----------------------------
INSERT INTO `tbl_clie_fondo_cesantias` VALUES ('1', 'Porvenir', null, '');
INSERT INTO `tbl_clie_fondo_cesantias` VALUES ('2', 'Protección', null, '');

-- ----------------------------
-- Table structure for tbl_clie_fondo_pensiones
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_fondo_pensiones`;
CREATE TABLE `tbl_clie_fondo_pensiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_fondo_pensiones
-- ----------------------------
INSERT INTO `tbl_clie_fondo_pensiones` VALUES ('1', 'Porvenir', '');
INSERT INTO `tbl_clie_fondo_pensiones` VALUES ('2', 'Protección', '');

-- ----------------------------
-- Table structure for tbl_clie_hist_laboral
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_hist_laboral`;
CREATE TABLE `tbl_clie_hist_laboral` (
  `codigo_cliente` bigint(20) NOT NULL,
  `id_tienda` int(11) NOT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `cargo` varchar(150) DEFAULT NULL,
  `nombre_jefe_inmediato` varchar(100) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_retiro` date DEFAULT NULL,
  `cantidad_personas_a_cargo` int(11) DEFAULT NULL,
  `ultimo_salario` float DEFAULT NULL,
  `horario_trabajo` varchar(200) DEFAULT NULL,
  `id_tipo_contrato` int(11) DEFAULT NULL,
  UNIQUE KEY `codigo_cliente_UNIQUE` (`codigo_cliente`,`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_hist_laboral
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_clie_nivel_estudio
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_nivel_estudio`;
CREATE TABLE `tbl_clie_nivel_estudio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(500) DEFAULT NULL,
  `descripcion` mediumtext,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_nivel_estudio
-- ----------------------------
INSERT INTO `tbl_clie_nivel_estudio` VALUES ('0', 'Ninguno', null, '');
INSERT INTO `tbl_clie_nivel_estudio` VALUES ('1', 'Primaria', null, '');
INSERT INTO `tbl_clie_nivel_estudio` VALUES ('2', 'Bachillarato', null, '');
INSERT INTO `tbl_clie_nivel_estudio` VALUES ('3', 'Tecnológico', null, '');
INSERT INTO `tbl_clie_nivel_estudio` VALUES ('4', 'Profesional', null, '');
INSERT INTO `tbl_clie_nivel_estudio` VALUES ('5', 'Magister', null, '');
INSERT INTO `tbl_clie_nivel_estudio` VALUES ('6', 'Doctor PhD', null, '');

-- ----------------------------
-- Table structure for tbl_clie_pariente
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_pariente`;
CREATE TABLE `tbl_clie_pariente` (
  `id_tienda` int(11) NOT NULL,
  `codigo_cliente` bigint(20) NOT NULL,
  `codigo_cliente_pariente` bigint(20) NOT NULL,
  `id_tipo_parentesco` int(11) NOT NULL,
  `id_tienda_pariente` int(11) NOT NULL,
  `trabaja_nutibara` int(11) NOT NULL DEFAULT '0',
  `id_cargo` int(11) DEFAULT NULL,
  `contacto_emergencia` int(11) DEFAULT '0',
  `vive_con_persona_familiares` int(11) NOT NULL DEFAULT '0',
  `a_cargo_persona_familiares` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tienda`,`codigo_cliente`,`codigo_cliente_pariente`,`id_tienda_pariente`),
  KEY `FK_PAREN_CLI_idx` (`codigo_cliente`) USING BTREE,
  KEY `FK_PAREN_TIP_PAREN_idx` (`id_tipo_parentesco`) USING BTREE,
  KEY `FK_PAREN_TIEN_PARIEN_idx` (`id_tienda`) USING BTREE,
  CONSTRAINT `tbl_clie_pariente_ibfk_1` FOREIGN KEY (`codigo_cliente`) REFERENCES `tbl_cliente` (`codigo_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_clie_pariente_ibfk_2` FOREIGN KEY (`codigo_cliente`) REFERENCES `tbl_cliente` (`codigo_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_clie_pariente_ibfk_3` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_cliente` (`id_tienda`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_clie_pariente_ibfk_4` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_cliente` (`id_tienda`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbl_clie_pariente_ibfk_5` FOREIGN KEY (`id_tipo_parentesco`) REFERENCES `tbl_clie_tipo_parentesco` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_pariente
-- ----------------------------
INSERT INTO `tbl_clie_pariente` VALUES ('1', '1', '2', '3', '1', '0', null, '0', '0', '0');
INSERT INTO `tbl_clie_pariente` VALUES ('1', '1', '4', '4', '1', '0', null, '1', '0', '0');
INSERT INTO `tbl_clie_pariente` VALUES ('1', '6', '7', '3', '1', '0', null, '0', '0', '0');
INSERT INTO `tbl_clie_pariente` VALUES ('1', '6', '8', '1', '1', '0', null, '0', '0', '0');
INSERT INTO `tbl_clie_pariente` VALUES ('1', '6', '10', '1', '1', '0', null, '1', '0', '0');
INSERT INTO `tbl_clie_pariente` VALUES ('9', '1', '1', '5', '1', '1', null, '0', '0', '0');
INSERT INTO `tbl_clie_pariente` VALUES ('9', '1', '2', '2', '9', '0', null, '0', '0', '0');
INSERT INTO `tbl_clie_pariente` VALUES ('9', '1', '4', '6', '9', '0', null, '1', '0', '0');

-- ----------------------------
-- Table structure for tbl_clie_pasatiempo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_pasatiempo`;
CREATE TABLE `tbl_clie_pasatiempo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  `descripcion` mediumtext,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_pasatiempo
-- ----------------------------
INSERT INTO `tbl_clie_pasatiempo` VALUES ('1', 'Basquet', 'Me gusta el Basquet', '');
INSERT INTO `tbl_clie_pasatiempo` VALUES ('2', 'Futbol', 'Me gusta el futbol', '');
INSERT INTO `tbl_clie_pasatiempo` VALUES ('3', 'natacion', 'Nado', '');
INSERT INTO `tbl_clie_pasatiempo` VALUES ('4', 'Capoeira', 'me gusta la capoeiras', '');
INSERT INTO `tbl_clie_pasatiempo` VALUES ('5', '2', '22', '\0');
INSERT INTO `tbl_clie_pasatiempo` VALUES ('6', '3', '331', '');
INSERT INTO `tbl_clie_pasatiempo` VALUES ('8', 'Artes Mixtas', 'N/A', '');

-- ----------------------------
-- Table structure for tbl_clie_profesion
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_profesion`;
CREATE TABLE `tbl_clie_profesion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  `descripcion` mediumtext,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_profesion
-- ----------------------------
INSERT INTO `tbl_clie_profesion` VALUES ('1', 'Ingeniero Software', 'Desarrollador', '');
INSERT INTO `tbl_clie_profesion` VALUES ('2', 'Ingeniero de redes', 'Se encarga del mantenimiento de Hardware', '');
INSERT INTO `tbl_clie_profesion` VALUES ('3', '2', '444', '\0');
INSERT INTO `tbl_clie_profesion` VALUES ('4', 'Ingeniero ambientales', 'Analiza las joyas', '');
INSERT INTO `tbl_clie_profesion` VALUES ('5', '11', '11', '\0');
INSERT INTO `tbl_clie_profesion` VALUES ('8', 'Contador', 'Contabilidad', '');

-- ----------------------------
-- Table structure for tbl_clie_sociedad
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_sociedad`;
CREATE TABLE `tbl_clie_sociedad` (
  `id_sociedad` int(11) NOT NULL,
  `codigo_cliente` bigint(20) NOT NULL,
  `id_tienda` int(11) NOT NULL,
  UNIQUE KEY `id_sociedad_UNIQUE` (`id_sociedad`) USING BTREE,
  UNIQUE KEY `codigo_cliente_UNIQUE` (`codigo_cliente`) USING BTREE,
  UNIQUE KEY `id_tienda_UNIQUE` (`id_tienda`) USING BTREE,
  KEY `FK_PLA_SOC_idx` (`id_sociedad`) USING BTREE,
  KEY `FK_SAC_CLI_idx` (`codigo_cliente`) USING BTREE,
  KEY `FK_SOC_CLI_TIEN_idx` (`id_tienda`) USING BTREE,
  CONSTRAINT `tbl_clie_sociedad_ibfk_1` FOREIGN KEY (`codigo_cliente`) REFERENCES `tbl_cliente` (`codigo_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_clie_sociedad_ibfk_2` FOREIGN KEY (`id_sociedad`) REFERENCES `tbl_sociedad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_clie_sociedad_ibfk_3` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_cliente` (`id_tienda`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_sociedad
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_clie_tenencia_vivienda
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_tenencia_vivienda`;
CREATE TABLE `tbl_clie_tenencia_vivienda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_tenencia_vivienda
-- ----------------------------
INSERT INTO `tbl_clie_tenencia_vivienda` VALUES ('1', 'Propia', '');
INSERT INTO `tbl_clie_tenencia_vivienda` VALUES ('2', 'Alquilada', '');
INSERT INTO `tbl_clie_tenencia_vivienda` VALUES ('3', 'Familiar', '');
INSERT INTO `tbl_clie_tenencia_vivienda` VALUES ('4', 'Invasión', '');
INSERT INTO `tbl_clie_tenencia_vivienda` VALUES ('5', 'Amortización', '');

-- ----------------------------
-- Table structure for tbl_clie_tienda
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_tienda`;
CREATE TABLE `tbl_clie_tienda` (
  `id_tienda` int(11) NOT NULL,
  `codigo_cliente` int(11) NOT NULL,
  `id_tienda_cliente` int(11) NOT NULL,
  KEY `FK_TAC_CLI_idx` (`id_tienda`) USING BTREE,
  KEY `FK_TAC_CLI_idx1` (`codigo_cliente`) USING BTREE,
  CONSTRAINT `tbl_clie_tienda_ibfk_1` FOREIGN KEY (`codigo_cliente`) REFERENCES `tbl_cliente` (`id_tienda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_clie_tienda_ibfk_2` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_cliente` (`id_tienda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_clie_tienda_ibfk_3` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_tienda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_tienda
-- ----------------------------
INSERT INTO `tbl_clie_tienda` VALUES ('1', '1', '1');

-- ----------------------------
-- Table structure for tbl_clie_tipo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_tipo`;
CREATE TABLE `tbl_clie_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL COMMENT 'Tipo:\nEmpleado-Tienda\nEmpleado-Sociedad\nCliente-Persona-Jurídica\nProveedor-Persona-Jurídica\nCliente-Persona-Natural\nProveedor-Persona-Natural',
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_tipo
-- ----------------------------
INSERT INTO `tbl_clie_tipo` VALUES ('1', 'Empleado Tienda', '1');
INSERT INTO `tbl_clie_tipo` VALUES ('2', 'Empleado Sociedad', '1');
INSERT INTO `tbl_clie_tipo` VALUES ('3', 'Cliente Persona Jurídica', '1');
INSERT INTO `tbl_clie_tipo` VALUES ('4', 'Cliente Persona Natural', '1');
INSERT INTO `tbl_clie_tipo` VALUES ('5', 'Proveedor Persona Jurídica', '1');
INSERT INTO `tbl_clie_tipo` VALUES ('6', 'Proveedor Persona Natural', '1');

-- ----------------------------
-- Table structure for tbl_clie_tipo_documento
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_tipo_documento`;
CREATE TABLE `tbl_clie_tipo_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_abreviado` varchar(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` mediumtext,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_abreviado_UNIQUE` (`nombre_abreviado`,`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_tipo_documento
-- ----------------------------
INSERT INTO `tbl_clie_tipo_documento` VALUES ('1', 'CC', 'Cédula de Ciudadanía', 'Este documento es para las personas de nacionalidad Colombiana', '');
INSERT INTO `tbl_clie_tipo_documento` VALUES ('2', 'CE', 'Cédula de Extranjería', 'Este tipo de documento es para las personas que no son de Colombias', '');
INSERT INTO `tbl_clie_tipo_documento` VALUES ('3', 'TI', 'Tarjeta de Identidad', 'Este tipo de documento es para las personas menores de edad Colombianas', '');
INSERT INTO `tbl_clie_tipo_documento` VALUES ('7', 'VS', 'Visa', 'Para gente del exterior', '');
INSERT INTO `tbl_clie_tipo_documento` VALUES ('8', 'DK', 'ALGO', 'ASdasd', '');
INSERT INTO `tbl_clie_tipo_documento` VALUES ('12', 'PS', 'Pasaporte', 'Pasaporte', '');
INSERT INTO `tbl_clie_tipo_documento` VALUES ('19', 'CAS', 'ASDqw', 'Aredaw', '\0');
INSERT INTO `tbl_clie_tipo_documento` VALUES ('21', 'PSD', 'aksd', 'asd', '');
INSERT INTO `tbl_clie_tipo_documento` VALUES ('23', 'NIT', 'NIT', 'NA', '');

-- ----------------------------
-- Table structure for tbl_clie_tipo_documento_dian
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_tipo_documento_dian`;
CREATE TABLE `tbl_clie_tipo_documento_dian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` mediumtext,
  `digito_verificacion` varchar(50) NOT NULL,
  `id_tipo_documento` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_tipo_documento_UNIQUE` (`id_tipo_documento`) USING BTREE,
  KEY `FK_TDOCDIAN_TDOC_idx` (`id_tipo_documento`) USING BTREE,
  CONSTRAINT `tbl_clie_tipo_documento_dian_ibfk_1` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tbl_clie_tipo_documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_tipo_documento_dian
-- ----------------------------
INSERT INTO `tbl_clie_tipo_documento_dian` VALUES ('1', 'Dian', 'Cedula Ciudadanias', 'Si', '2', '1');
INSERT INTO `tbl_clie_tipo_documento_dian` VALUES ('2', 'asdas', 'dasda', 'No', '1', '1');
INSERT INTO `tbl_clie_tipo_documento_dian` VALUES ('3', 'Dian', 'Esta tipo de documento es para las personas menores de edad Colombianas', '1-152471', '3', '1');
INSERT INTO `tbl_clie_tipo_documento_dian` VALUES ('44', 'Dian Visa', 'Para personas del exterior', '13w4788934a', '7', '1');
INSERT INTO `tbl_clie_tipo_documento_dian` VALUES ('46', 'Dian DK', 'askld', '1231-124123', '8', '0');
INSERT INTO `tbl_clie_tipo_documento_dian` VALUES ('48', 'Dian', 'Documento Dian para Pasaporte', '1-21312', '12', '1');
INSERT INTO `tbl_clie_tipo_documento_dian` VALUES ('55', 'Dian', 'asdaosd', 'No', '23', '1');

-- ----------------------------
-- Table structure for tbl_clie_tipo_parentesco
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_tipo_parentesco`;
CREATE TABLE `tbl_clie_tipo_parentesco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_tipo_parentesco
-- ----------------------------
INSERT INTO `tbl_clie_tipo_parentesco` VALUES ('1', 'Padre', '');
INSERT INTO `tbl_clie_tipo_parentesco` VALUES ('2', 'Hijo(a)', '');
INSERT INTO `tbl_clie_tipo_parentesco` VALUES ('3', 'Hermano(a)', '');
INSERT INTO `tbl_clie_tipo_parentesco` VALUES ('4', 'Primo(a)', '');

-- ----------------------------
-- Table structure for tbl_clie_tipo_trabajo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_tipo_trabajo`;
CREATE TABLE `tbl_clie_tipo_trabajo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_tipo_trabajo
-- ----------------------------
INSERT INTO `tbl_clie_tipo_trabajo` VALUES ('4', 'Vendedor23s', 'Vende productos', '');
INSERT INTO `tbl_clie_tipo_trabajo` VALUES ('5', 'Por Temporada', 'NAs', '');
INSERT INTO `tbl_clie_tipo_trabajo` VALUES ('6', 'Por Servicio', 'NA', '');
INSERT INTO `tbl_clie_tipo_trabajo` VALUES ('7', 'Termino Indefinido', 'NAa', '');
INSERT INTO `tbl_clie_tipo_trabajo` VALUES ('8', 'Independiente', 'NA', '');
INSERT INTO `tbl_clie_tipo_trabajo` VALUES ('9', '1', '11', '');

-- ----------------------------
-- Table structure for tbl_clie_tipo_vivienda
-- ----------------------------
DROP TABLE IF EXISTS `tbl_clie_tipo_vivienda`;
CREATE TABLE `tbl_clie_tipo_vivienda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_clie_tipo_vivienda
-- ----------------------------
INSERT INTO `tbl_clie_tipo_vivienda` VALUES ('1', 'Casa', null, '');
INSERT INTO `tbl_clie_tipo_vivienda` VALUES ('2', 'Apartamento', null, '');
INSERT INTO `tbl_clie_tipo_vivienda` VALUES ('3', 'Habitación(Pieza)', null, '');
INSERT INTO `tbl_clie_tipo_vivienda` VALUES ('4', 'Garaje', null, '');

-- ----------------------------
-- Table structure for tbl_cliente
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cliente`;
CREATE TABLE `tbl_cliente` (
  `codigo_cliente` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_tienda` int(11) NOT NULL,
  `id_tipo_documento` int(11) DEFAULT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `id_confiabilidad` int(11) DEFAULT NULL,
  `numero_documento` varchar(100) DEFAULT NULL,
  `id_ciudad_expedicion` int(11) DEFAULT NULL,
  `genero` int(11) DEFAULT NULL,
  `nombres` varchar(100) NOT NULL,
  `primer_apellido` varchar(100) DEFAULT NULL,
  `segundo_apellido` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `id_ciudad_nacimiento` int(11) DEFAULT NULL,
  `id_ciudad_residencia` int(11) DEFAULT NULL,
  `barrio_residencia` varchar(200) DEFAULT NULL,
  `direccion_residencia` varchar(200) DEFAULT NULL,
  `telefono_residencia` int(11) DEFAULT NULL,
  `id_estado_civil` int(11) DEFAULT NULL,
  `telefono_celular` varchar(50) DEFAULT NULL,
  `id_ciudad_trabajo` int(11) DEFAULT NULL,
  `direccion_trabajo` varchar(200) DEFAULT NULL,
  `barrio_trabajo` varchar(200) DEFAULT NULL,
  `telefono_trabajo` int(11) DEFAULT NULL,
  `telefono_otros` int(11) DEFAULT NULL,
  `id_nivel_estudio` int(11) DEFAULT NULL,
  `id_nivel_estudio_actual` int(11) DEFAULT NULL,
  `id_profesion` int(11) DEFAULT NULL,
  `id_tipo_trabajo` int(11) DEFAULT NULL,
  `id_sector_area_laboral` int(11) DEFAULT NULL,
  `personas_a_cargo` int(11) DEFAULT NULL,
  `nombre_contacto` varchar(100) DEFAULT NULL,
  `apellidos_contacto` varchar(100) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `libreta_militar` varchar(20) DEFAULT NULL,
  `distrito_militar` varchar(10) DEFAULT NULL,
  `id_tipo_vivienda` int(11) DEFAULT NULL,
  `tenencia_vivienda` varchar(100) DEFAULT NULL,
  `id_fondo_cesantias` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `talla_zapatos` varchar(10) DEFAULT NULL,
  `talla_pantalon` varchar(10) DEFAULT NULL,
  `talla_camisa` varchar(10) DEFAULT NULL,
  `id_caja_compensacion` int(11) DEFAULT NULL,
  `id_eps` int(11) DEFAULT NULL,
  `id_tenencia_vivienda` int(11) DEFAULT NULL,
  `id_fondo_pensiones` int(11) DEFAULT NULL,
  `rh` varchar(10) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `ocupacion` varchar(45) DEFAULT NULL,
  `beneficiario` varchar(45) DEFAULT NULL,
  `ano_o_semestre` int(11) DEFAULT NULL,
  `grado_escolaridad` varchar(45) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`codigo_cliente`,`id_tienda`),
  KEY `FK_CLI_CON_idx` (`id_confiabilidad`) USING BTREE,
  KEY `FK_CLI_TIP_CLI_idx` (`id_tipo_cliente`) USING BTREE,
  KEY `FK_CLI_TIP_DOC_idx` (`id_tipo_documento`) USING BTREE,
  KEY `FK_CLI_CIU_EXP_idx` (`id_ciudad_expedicion`) USING BTREE,
  KEY `FK_CLI_CIU_NACI_idx` (`id_ciudad_nacimiento`) USING BTREE,
  KEY `FK_CLI_CIU_RESID_idx` (`id_ciudad_residencia`) USING BTREE,
  KEY `FK_CLI_NIV_ESTU_idx` (`id_nivel_estudio`) USING BTREE,
  KEY `FK_CLI_PROF_idx` (`id_profesion`) USING BTREE,
  KEY `FK_CLI_TIP_TRAB_idx` (`id_tipo_trabajo`) USING BTREE,
  KEY `FK_CLI_AREA_LAB_idx` (`id_sector_area_laboral`) USING BTREE,
  KEY `FK_CLI_TIP_VIVI_idx` (`id_tipo_vivienda`) USING BTREE,
  KEY `FK_CLI_FOND_CESA_idx` (`id_fondo_cesantias`) USING BTREE,
  KEY `FK_CLI_CIU_TRAB_idx` (`id_ciudad_trabajo`) USING BTREE,
  KEY `FK_CLI_TIEN_idx` (`id_tienda`) USING BTREE,
  KEY `FK_CLI_CIU_RES_idx` (`id_ciudad_residencia`) USING BTREE,
  KEY `FK_CLI_EST_CIVIL_idx` (`id_estado_civil`) USING BTREE,
  KEY `FK_CLI_NIV_ESTU_ACTU_idx` (`id_nivel_estudio_actual`) USING BTREE,
  CONSTRAINT `tbl_cliente_ibfk_1` FOREIGN KEY (`id_ciudad_expedicion`) REFERENCES `tbl_ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_10` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_tienda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_11` FOREIGN KEY (`id_tipo_cliente`) REFERENCES `tbl_clie_tipo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_12` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tbl_clie_tipo_documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_13` FOREIGN KEY (`id_tipo_trabajo`) REFERENCES `tbl_clie_tipo_trabajo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_2` FOREIGN KEY (`id_ciudad_nacimiento`) REFERENCES `tbl_ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_3` FOREIGN KEY (`id_ciudad_residencia`) REFERENCES `tbl_ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_4` FOREIGN KEY (`id_ciudad_residencia`) REFERENCES `tbl_ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_5` FOREIGN KEY (`id_ciudad_trabajo`) REFERENCES `tbl_ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_6` FOREIGN KEY (`id_confiabilidad`) REFERENCES `tbl_clie_confiabilidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_7` FOREIGN KEY (`id_nivel_estudio`) REFERENCES `tbl_clie_nivel_estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_8` FOREIGN KEY (`id_nivel_estudio_actual`) REFERENCES `tbl_clie_nivel_estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_cliente_ibfk_9` FOREIGN KEY (`id_profesion`) REFERENCES `tbl_clie_profesion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_cliente
-- ----------------------------
INSERT INTO `tbl_cliente` VALUES ('1', '1', '1', '1', null, '101010', '1', '1', 'José Arcadio', 'Buendía', 'Vergara', '1982-11-20', '1', '1', 'Loreto Alto', 'Cra 58-14', '2456366', '1', '3025556699', null, null, null, null, null, '5', '5', null, null, null, null, null, null, 'PruebaPrueba6@ddd.com', '1025635584', '48', '4', null, '1', null, '41', 's', 'L', '1', '2', '2', '1', 'O-', null, 'Maestra', '2', '1', '4', '1');
INSERT INTO `tbl_cliente` VALUES ('2', '1', null, null, null, '1010101010', null, null, 'Natalia García Pérez', null, null, '1982-08-31', null, null, null, null, null, null, null, null, null, null, null, null, '5', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Maestra', '2', '1', '4', '1');
INSERT INTO `tbl_cliente` VALUES ('4', '1', null, null, null, null, null, null, 'Camilo Vargas', null, null, null, null, '1', null, 'Calle 88-99b', '2458855', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `tbl_cliente` VALUES ('6', '1', '1', '1', null, '13213123', '1', '1', 'Andrea', 'Penelope', 'Giraldo', '1980-10-01', '1', '1', 'Belén', 'Calle 30', '2396969', '1', '3056987474', null, null, null, null, null, '2', '4', null, null, null, null, null, null, 'anpegi@gmail.com', 'No aplica', 'Ninguno', '2', null, '1', null, '37', 'l', 'm', '1', '1', '1', '1', '0+', null, null, null, null, null, '1');
INSERT INTO `tbl_cliente` VALUES ('7', '1', null, null, null, '123456', null, null, 'Adrian', null, null, '2017-08-24', null, null, null, null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Administradora', '2', '0', '6', '1');
INSERT INTO `tbl_cliente` VALUES ('8', '1', null, null, null, '258', null, null, 'Ana', null, null, '2061-08-24', null, null, null, null, null, null, null, null, null, null, null, null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', '0', '0', '1');
INSERT INTO `tbl_cliente` VALUES ('10', '1', null, null, null, null, null, null, 'Ángela Patricia', null, null, null, null, '1', null, 'Calle 40', '1231323', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');

-- ----------------------------
-- Table structure for tbl_contr_aplicacion_retroventa
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contr_aplicacion_retroventa`;
CREATE TABLE `tbl_contr_aplicacion_retroventa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_zona` int(11) NOT NULL,
  `id_tienda` int(11) DEFAULT NULL,
  `meses_transcurridos` float NOT NULL,
  `dias_transcurridos` float NOT NULL,
  `menos_meses` float NOT NULL,
  `menos_porcentaje_retroventas` float NOT NULL,
  `monto_desde` float NOT NULL,
  `monto_hasta` float NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CTR_APLI_ZONA_idx` (`id_zona`) USING BTREE,
  KEY `FK_CTR_APLI_TIEN_idx` (`id_tienda`) USING BTREE,
  CONSTRAINT `tbl_contr_aplicacion_retroventa_ibfk_1` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_tienda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_contr_aplicacion_retroventa_ibfk_2` FOREIGN KEY (`id_zona`) REFERENCES `tbl_zona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_contr_aplicacion_retroventa
-- ----------------------------
INSERT INTO `tbl_contr_aplicacion_retroventa` VALUES ('1', '23', '10', '1', '1', '1', '1', '1', '1', '\0');
INSERT INTO `tbl_contr_aplicacion_retroventa` VALUES ('3', '18', '1', '140', '0', '8', '0', '0', '0', '');

-- ----------------------------
-- Table structure for tbl_contr_configuracion
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contr_configuracion`;
CREATE TABLE `tbl_contr_configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_zona` int(11) NOT NULL,
  `id_tienda` int(11) DEFAULT NULL,
  `id_categoria_general` int(11) DEFAULT NULL,
  `id_calificacion_cliente` int(11) DEFAULT NULL,
  `monto_desde` float NOT NULL,
  `monto_hasta` float NOT NULL,
  `fecha_hora_vigencia_desde` datetime DEFAULT NULL,
  `fecha_hora_vigencia_hasta` datetime DEFAULT NULL,
  `termino_contrato` int(11) DEFAULT NULL,
  `porcentaje_retroventa` float DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CTR_APLI_ZONA_idx` (`id_zona`) USING BTREE,
  KEY `FK_CTR_APLI_TIEN_idx` (`id_tienda`) USING BTREE,
  KEY `FK_CTR_CONF_CAT_GRAL_idx` (`id_categoria_general`) USING BTREE,
  KEY `FK_CTR_CONF_CALI_CLI_idx` (`id_calificacion_cliente`) USING BTREE,
  CONSTRAINT `tbl_contr_configuracion_ibfk_1` FOREIGN KEY (`id_categoria_general`) REFERENCES `tbl_prod_categoria_general` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_contr_configuracion_ibfk_2` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_tienda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_contr_configuracion_ibfk_3` FOREIGN KEY (`id_zona`) REFERENCES `tbl_zona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_contr_configuracion
-- ----------------------------
INSERT INTO `tbl_contr_configuracion` VALUES ('1', '23', '10', '9', '-1', '-1', '-1', '2017-12-31 12:59:00', '2017-12-31 12:59:00', '-1', '-1', '');
INSERT INTO `tbl_contr_configuracion` VALUES ('2', '23', '10', '9', '1', '1', '1', '2017-12-31 12:59:00', '2018-01-01 01:00:00', '1', '1', '');
INSERT INTO `tbl_contr_configuracion` VALUES ('3', '18', '1', '9', '1', '20000', '40000', '2017-08-01 01:00:00', '2017-08-31 01:00:00', '-1', '5', '');

-- ----------------------------
-- Table structure for tbl_contr_dato_general
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contr_dato_general`;
CREATE TABLE `tbl_contr_dato_general` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pais` int(11) NOT NULL,
  `id_categoria_general` int(11) NOT NULL,
  `termino_contrato` int(11) NOT NULL,
  `porcentaje_retroventa` double NOT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_DATO_GEN_PAIS_idx` (`id_pais`) USING BTREE,
  KEY `FK_DATO_GEN_CAT_idx` (`id_categoria_general`) USING BTREE,
  CONSTRAINT `tbl_contr_dato_general_ibfk_1` FOREIGN KEY (`id_categoria_general`) REFERENCES `tbl_prod_categoria_general` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_contr_dato_general_ibfk_2` FOREIGN KEY (`id_pais`) REFERENCES `tbl_pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_contr_dato_general
-- ----------------------------
INSERT INTO `tbl_contr_dato_general` VALUES ('1', '7', '9', '6', '1', '\0');
INSERT INTO `tbl_contr_dato_general` VALUES ('3', '7', '10', '1', '1', '\0');
INSERT INTO `tbl_contr_dato_general` VALUES ('5', '4', '9', '4', '10', '');

-- ----------------------------
-- Table structure for tbl_contr_dia_retroventa
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contr_dia_retroventa`;
CREATE TABLE `tbl_contr_dia_retroventa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_zona` int(11) NOT NULL,
  `id_tienda` int(11) DEFAULT NULL,
  `dias_gracia` int(11) NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CTR_DIA_TIEN_idx` (`id_tienda`) USING BTREE,
  KEY `FK_CTR_DIA_ZONA_idx` (`id_zona`) USING BTREE,
  CONSTRAINT `tbl_contr_dia_retroventa_ibfk_1` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_tienda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_contr_dia_retroventa_ibfk_2` FOREIGN KEY (`id_zona`) REFERENCES `tbl_zona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_contr_dia_retroventa
-- ----------------------------
INSERT INTO `tbl_contr_dia_retroventa` VALUES ('2', '23', '10', '3', '\0');
INSERT INTO `tbl_contr_dia_retroventa` VALUES ('3', '18', '1', '5', '');

-- ----------------------------
-- Table structure for tbl_contr_item
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contr_item`;
CREATE TABLE `tbl_contr_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria_general` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CONTR_ITEM_CAT_idx` (`id_categoria_general`) USING BTREE,
  CONSTRAINT `tbl_contr_item_ibfk_1` FOREIGN KEY (`id_categoria_general`) REFERENCES `tbl_prod_categoria_general` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_contr_item
-- ----------------------------
INSERT INTO `tbl_contr_item` VALUES ('27', '9', '1', '\0');
INSERT INTO `tbl_contr_item` VALUES ('30', '9', 'COD5426', '');

-- ----------------------------
-- Table structure for tbl_contr_item_config
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contr_item_config`;
CREATE TABLE `tbl_contr_item_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `id_atributo` int(11) NOT NULL,
  `orden_posicion` int(11) NOT NULL,
  `obligatorio` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ITEM_CONF_ITEM_idx` (`id_item`) USING BTREE,
  KEY `FK_ITEM_CONF_ATRIB_idx` (`id_atributo`) USING BTREE,
  CONSTRAINT `tbl_contr_item_config_ibfk_1` FOREIGN KEY (`id_atributo`) REFERENCES `tbl_prod_atributo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_contr_item_config_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `tbl_contr_item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_contr_item_config
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_contr_medida_peso
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contr_medida_peso`;
CREATE TABLE `tbl_contr_medida_peso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_medida` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_contr_medida_peso
-- ----------------------------
INSERT INTO `tbl_contr_medida_peso` VALUES ('2', 'kg');
INSERT INTO `tbl_contr_medida_peso` VALUES ('3', 'gr');

-- ----------------------------
-- Table structure for tbl_contr_val_peso_sug
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contr_val_peso_sug`;
CREATE TABLE `tbl_contr_val_peso_sug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medida_peso` int(11) DEFAULT NULL,
  `id_categoria_general` int(11) NOT NULL,
  `id_item` int(11) DEFAULT NULL,
  `valor_minimo_x_1` double NOT NULL,
  `valor_maximo_x_1` double NOT NULL,
  `valor_x_1` double NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_VAL_SUG_MED_PESO_idx` (`id_medida_peso`) USING BTREE,
  KEY `FK_VAL_SUG_CAT_GEN_idx` (`id_categoria_general`) USING BTREE,
  KEY `FK_VAL_SUG_ITEM_idx` (`id_item`) USING BTREE,
  CONSTRAINT `tbl_contr_val_peso_sug_ibfk_1` FOREIGN KEY (`id_categoria_general`) REFERENCES `tbl_prod_categoria_general` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_contr_val_peso_sug_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `tbl_contr_item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_contr_val_peso_sug_ibfk_3` FOREIGN KEY (`id_medida_peso`) REFERENCES `tbl_contr_medida_peso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_contr_val_peso_sug
-- ----------------------------
INSERT INTO `tbl_contr_val_peso_sug` VALUES ('1', null, '9', '30', '1', '1', '1', '');
INSERT INTO `tbl_contr_val_peso_sug` VALUES ('2', null, '9', '30', '65000', '80000', '70000', '');

-- ----------------------------
-- Table structure for tbl_departamento
-- ----------------------------
DROP TABLE IF EXISTS `tbl_departamento`;
CREATE TABLE `tbl_departamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext,
  `id_pais` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`,`id_pais`) USING BTREE,
  KEY `FK_DEPART_PAIS` (`id_pais`) USING BTREE,
  CONSTRAINT `tbl_departamento_ibfk_1` FOREIGN KEY (`id_pais`) REFERENCES `tbl_pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_departamento
-- ----------------------------
INSERT INTO `tbl_departamento` VALUES ('1', 'Izmir', 'Hola', '1', '1');
INSERT INTO `tbl_departamento` VALUES ('2', 'Hola', null, '1', '0');
INSERT INTO `tbl_departamento` VALUES ('4', 'Istambul', null, '1', '1');
INSERT INTO `tbl_departamento` VALUES ('5', 'Antioquia', 'N/A', '4', '1');
INSERT INTO `tbl_departamento` VALUES ('6', 'Caldas', 'manizales', '4', '1');
INSERT INTO `tbl_departamento` VALUES ('7', 'Caquetá', null, '4', '1');
INSERT INTO `tbl_departamento` VALUES ('8', 'Rionegro', null, '4', '1');
INSERT INTO `tbl_departamento` VALUES ('12', 'Boyacá', 'N/A', '4', '1');
INSERT INTO `tbl_departamento` VALUES ('15', 'Prueba2', 'Prueba2', '5', '1');

-- ----------------------------
-- Table structure for tbl_empl_cargo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_empl_cargo`;
CREATE TABLE `tbl_empl_cargo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_empl_cargo
-- ----------------------------
INSERT INTO `tbl_empl_cargo` VALUES ('1', 'Gerente', 'Administrador el patron', '1');
INSERT INTO `tbl_empl_cargo` VALUES ('2', 'Administrador', 'Administra la platica', '0');
INSERT INTO `tbl_empl_cargo` VALUES ('3', 'Contador', 'cuenta la platica papu', '1');
INSERT INTO `tbl_empl_cargo` VALUES ('4', 'Administradores', 'Administra la platica', '1');

-- ----------------------------
-- Table structure for tbl_empl_motivo_retiro
-- ----------------------------
DROP TABLE IF EXISTS `tbl_empl_motivo_retiro`;
CREATE TABLE `tbl_empl_motivo_retiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_empl_motivo_retiro
-- ----------------------------
INSERT INTO `tbl_empl_motivo_retiro` VALUES ('1', 'Renuncia Voluntaria', '', '');
INSERT INTO `tbl_empl_motivo_retiro` VALUES ('2', 'Sin justa causa', '', '');
INSERT INTO `tbl_empl_motivo_retiro` VALUES ('3', 'Con justa causa', '', '');
INSERT INTO `tbl_empl_motivo_retiro` VALUES ('4', 'Mutuo acuerdo', '', '');

-- ----------------------------
-- Table structure for tbl_empl_tipo_contrato
-- ----------------------------
DROP TABLE IF EXISTS `tbl_empl_tipo_contrato`;
CREATE TABLE `tbl_empl_tipo_contrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_empl_tipo_contrato
-- ----------------------------
INSERT INTO `tbl_empl_tipo_contrato` VALUES ('1', 'Fijo', '1');
INSERT INTO `tbl_empl_tipo_contrato` VALUES ('2', 'Indefinido', '1');

-- ----------------------------
-- Table structure for tbl_franquicia
-- ----------------------------
DROP TABLE IF EXISTS `tbl_franquicia`;
CREATE TABLE `tbl_franquicia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_franquicia
-- ----------------------------
INSERT INTO `tbl_franquicia` VALUES ('1', 'Subway', 'Franquicia gringa de los años 60\'s.', '1');
INSERT INTO `tbl_franquicia` VALUES ('2', 'Basquetball', 'Me gusta el bas', '0');
INSERT INTO `tbl_franquicia` VALUES ('3', 'efwr', 'ewr', '0');
INSERT INTO `tbl_franquicia` VALUES ('4', 'Cosechas', 'Refrescantes', '1');
INSERT INTO `tbl_franquicia` VALUES ('5', 'Hoal', 'df', '0');
INSERT INTO `tbl_franquicia` VALUES ('6', 'Espera', 'sdfdsfdf', '0');
INSERT INTO `tbl_franquicia` VALUES ('7', 'IMPUINVERSIONES', null, '1');

-- ----------------------------
-- Table structure for tbl_historia_auditoria
-- ----------------------------
DROP TABLE IF EXISTS `tbl_historia_auditoria`;
CREATE TABLE `tbl_historia_auditoria` (
  `fecha_transaccion` datetime NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `numero_1` int(11) DEFAULT NULL,
  `dato_1` varchar(255) DEFAULT NULL,
  `fecha_1` datetime DEFAULT NULL,
  `numero_2` int(11) DEFAULT NULL,
  `dato_2` varchar(255) DEFAULT NULL,
  `fecha_2` datetime DEFAULT NULL,
  `numero_3` int(11) DEFAULT NULL,
  `dato_3` varchar(255) DEFAULT NULL,
  `fecha_3` datetime DEFAULT NULL,
  `transaccion` varchar(255) DEFAULT NULL,
  `operacion` varchar(255) DEFAULT NULL,
  `log` text,
  PRIMARY KEY (`fecha_transaccion`,`id_modulo`,`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_historia_auditoria
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_pais
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pais`;
CREATE TABLE `tbl_pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_pais
-- ----------------------------
INSERT INTO `tbl_pais` VALUES ('1', 'Turkey', 'En el mar Mediterráneo', '1');
INSERT INTO `tbl_pais` VALUES ('2', 'Argentina', 'NAs', '1');
INSERT INTO `tbl_pais` VALUES ('4', 'Colombia', 'Atlantica', '1');
INSERT INTO `tbl_pais` VALUES ('5', 'Rusia', 'Urales', '1');
INSERT INTO `tbl_pais` VALUES ('6', 'Perú', 'Mejor comida.', '1');
INSERT INTO `tbl_pais` VALUES ('7', 'Estados Unidos 1', 'Norte América', '1');

-- ----------------------------
-- Table structure for tbl_parametro_general
-- ----------------------------
DROP TABLE IF EXISTS `tbl_parametro_general`;
CREATE TABLE `tbl_parametro_general` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medida_peso` int(11) NOT NULL COMMENT 'Hacer tabla para la llave foránea',
  `id_pais` int(11) NOT NULL,
  `id_lenguaje` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL COMMENT 'Hacer tabla para la llave foránea',
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_medida_peso_UNIQUE` (`id_medida_peso`,`id_pais`,`id_lenguaje`,`id_moneda`) USING BTREE,
  KEY `FK_PARAM_GEN_MED_PESO_idx` (`id_medida_peso`) USING BTREE,
  KEY `FK_PARAM_MON_idx` (`id_moneda`) USING BTREE,
  KEY `FK_PARAM_MONTIP_idx` (`id_moneda`) USING BTREE,
  KEY `FK_PARAM_LENG_idx` (`id_lenguaje`) USING BTREE,
  CONSTRAINT `tbl_parametro_general_ibfk_1` FOREIGN KEY (`id_medida_peso`) REFERENCES `tbl_contr_medida_peso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_parametro_general_ibfk_2` FOREIGN KEY (`id_lenguaje`) REFERENCES `tbl_sys_lenguaje` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_parametro_general_ibfk_3` FOREIGN KEY (`id_moneda`) REFERENCES `tbl_sys_tipo_moneda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_parametro_general
-- ----------------------------
INSERT INTO `tbl_parametro_general` VALUES ('5', '1', '4', '1', '1', '');
INSERT INTO `tbl_parametro_general` VALUES ('6', '1', '5', '3', '3', '\0');
INSERT INTO `tbl_parametro_general` VALUES ('7', '1', '6', '1', '2', '');
INSERT INTO `tbl_parametro_general` VALUES ('9', '1', '3', '1', '1', '');
INSERT INTO `tbl_parametro_general` VALUES ('15', '2', '4', '2', '5', '');
INSERT INTO `tbl_parametro_general` VALUES ('16', '3', '6', '2', '6', '\0');
INSERT INTO `tbl_parametro_general` VALUES ('17', '2', '2', '2', '4', '\0');
INSERT INTO `tbl_parametro_general` VALUES ('18', '3', '1', '2', '5', '');

-- ----------------------------
-- Table structure for tbl_plan_unico_cuenta
-- ----------------------------
DROP TABLE IF EXISTS `tbl_plan_unico_cuenta`;
CREATE TABLE `tbl_plan_unico_cuenta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  `descripcion` mediumtext,
  `numero_cuenta` varchar(100) NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_plan_unico_cuenta
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_prod_atributo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_prod_atributo`;
CREATE TABLE `tbl_prod_atributo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat_general` int(11) NOT NULL,
  `id_atributo_padre` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_PROD_ATR_CAT_idx` (`id_cat_general`) USING BTREE,
  CONSTRAINT `tbl_prod_atributo_ibfk_1` FOREIGN KEY (`id_cat_general`) REFERENCES `tbl_prod_categoria_general` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_prod_atributo
-- ----------------------------
INSERT INTO `tbl_prod_atributo` VALUES ('14', '9', '15', 'Color del Oro', '', '');
INSERT INTO `tbl_prod_atributo` VALUES ('15', '9', '0', 'Calidad del Oro', '', '');
INSERT INTO `tbl_prod_atributo` VALUES ('17', '10', '0', 'Calidad de la Plata', '', '');
INSERT INTO `tbl_prod_atributo` VALUES ('18', '9', '0', 'Diseño del Oro', 'NA', '\0');
INSERT INTO `tbl_prod_atributo` VALUES ('19', '10', '0', 'Color del Oro', '1', '\0');

-- ----------------------------
-- Table structure for tbl_prod_atributo_valores
-- ----------------------------
DROP TABLE IF EXISTS `tbl_prod_atributo_valores`;
CREATE TABLE `tbl_prod_atributo_valores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_atributo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_atributo_padre` int(11) NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ATR_VAL_ATR_idx` (`id_atributo`) USING BTREE,
  CONSTRAINT `tbl_prod_atributo_valores_ibfk_1` FOREIGN KEY (`id_atributo`) REFERENCES `tbl_prod_atributo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_prod_atributo_valores
-- ----------------------------
INSERT INTO `tbl_prod_atributo_valores` VALUES ('13', '14', 'Amarillo', '0', '');
INSERT INTO `tbl_prod_atributo_valores` VALUES ('14', '14', 'Blanco', '0', '');
INSERT INTO `tbl_prod_atributo_valores` VALUES ('15', '14', 'Tres Oros', '0', '');
INSERT INTO `tbl_prod_atributo_valores` VALUES ('16', '15', '18 KI1q', '0', '');
INSERT INTO `tbl_prod_atributo_valores` VALUES ('17', '14', '18 KI1', '0', '');
INSERT INTO `tbl_prod_atributo_valores` VALUES ('18', '15', '18 KI1', '0', '');
INSERT INTO `tbl_prod_atributo_valores` VALUES ('25', '14', '', '0', '\0');

-- ----------------------------
-- Table structure for tbl_prod_catalogo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_prod_catalogo`;
CREATE TABLE `tbl_prod_catalogo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `vigencia_desde` datetime NOT NULL,
  `vigencia_hasta` datetime NOT NULL,
  `nombre` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`) USING BTREE,
  KEY `FK_CAT_CAT_idx` (`id_categoria`) USING BTREE,
  CONSTRAINT `tbl_prod_catalogo_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_prod_categoria_general` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_prod_catalogo
-- ----------------------------
INSERT INTO `tbl_prod_catalogo` VALUES ('42', '91316', 'ORO Amarillo 18 KI', '', '9', '2017-01-01 13:00:00', '2017-01-01 13:02:00', 'Prueba');
INSERT INTO `tbl_prod_catalogo` VALUES ('44', '91516', 'ORO Tres Oros 18 KI', '', '9', '2017-01-01 13:00:00', '2017-01-01 13:02:00', 'Prueba');
INSERT INTO `tbl_prod_catalogo` VALUES ('47', '91416', 'ORO Blanco 18 KI', '', '9', '2017-01-01 13:00:00', '2017-01-01 13:02:00', 'Prueba');
INSERT INTO `tbl_prod_catalogo` VALUES ('48', '913161718', 'ORO Amarillo 18 KI1q 18 KI1 18 KI1', '', '9', '2017-08-25 14:40:00', '2017-08-31 23:50:00', 'Prueba');
INSERT INTO `tbl_prod_catalogo` VALUES ('50', '9131617', 'ORO Amarillo 18 KI1q 18 KI11', '', '9', '2017-08-25 14:40:00', '2017-08-31 23:50:00', 'prueba');

-- ----------------------------
-- Table structure for tbl_prod_categoria_general
-- ----------------------------
DROP TABLE IF EXISTS `tbl_prod_categoria_general`;
CREATE TABLE `tbl_prod_categoria_general` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `vigencia_desde` datetime NOT NULL,
  `vigencia_hasta` datetime NOT NULL,
  `aplica_refaccion` bit(1) DEFAULT NULL,
  `aplica_vitrina` bit(1) DEFAULT NULL,
  `aplica_fundicion` bit(1) DEFAULT NULL,
  `aplica_joya_preciosa` bit(1) DEFAULT NULL,
  `aplica_maquila` bit(1) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_prod_categoria_general
-- ----------------------------
INSERT INTO `tbl_prod_categoria_general` VALUES ('9', 'ORO', '2017-01-01 00:00:00', '2017-12-31 00:00:00', '\0', '\0', '\0', '\0', '\0', '');
INSERT INTO `tbl_prod_categoria_general` VALUES ('10', 'PLATA', '2017-08-23 00:00:00', '2017-12-01 00:00:00', null, null, null, null, null, '');
INSERT INTO `tbl_prod_categoria_general` VALUES ('11', 'ARTÍCULO', '2017-01-01 01:00:00', '2017-12-31 01:00:00', null, null, null, null, null, '');
INSERT INTO `tbl_prod_categoria_general` VALUES ('21', 'ACERO', '2017-08-28 09:40:00', '2017-10-28 23:15:00', '\0', '\0', '\0', '\0', '\0', '');

-- ----------------------------
-- Table structure for tbl_prod_referencia
-- ----------------------------
DROP TABLE IF EXISTS `tbl_prod_referencia`;
CREATE TABLE `tbl_prod_referencia` (
  `id_referencia` int(11) NOT NULL,
  `id_valor_atributo` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `FK_REF_ATR_REF_idx` (`id_referencia`) USING BTREE,
  KEY `FK_REF_VAL_idx` (`id_valor_atributo`) USING BTREE,
  CONSTRAINT `tbl_prod_referencia_ibfk_1` FOREIGN KEY (`id_referencia`) REFERENCES `tbl_prod_catalogo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_prod_referencia_ibfk_2` FOREIGN KEY (`id_valor_atributo`) REFERENCES `tbl_prod_atributo_valores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_prod_referencia
-- ----------------------------
INSERT INTO `tbl_prod_referencia` VALUES ('42', '13', '1');
INSERT INTO `tbl_prod_referencia` VALUES ('42', '16', '2');
INSERT INTO `tbl_prod_referencia` VALUES ('44', '15', '3');
INSERT INTO `tbl_prod_referencia` VALUES ('44', '16', '4');
INSERT INTO `tbl_prod_referencia` VALUES ('47', '14', '5');
INSERT INTO `tbl_prod_referencia` VALUES ('47', '16', '6');
INSERT INTO `tbl_prod_referencia` VALUES ('48', '13', '7');
INSERT INTO `tbl_prod_referencia` VALUES ('48', '16', '8');
INSERT INTO `tbl_prod_referencia` VALUES ('48', '17', '9');
INSERT INTO `tbl_prod_referencia` VALUES ('48', '18', '10');
INSERT INTO `tbl_prod_referencia` VALUES ('50', '13', '11');
INSERT INTO `tbl_prod_referencia` VALUES ('50', '16', '12');
INSERT INTO `tbl_prod_referencia` VALUES ('50', '17', '13');

-- ----------------------------
-- Table structure for tbl_secuencia_tienda
-- ----------------------------
DROP TABLE IF EXISTS `tbl_secuencia_tienda`;
CREATE TABLE `tbl_secuencia_tienda` (
  `id_tienda` int(11) NOT NULL,
  `codigo_cliente` bigint(20) DEFAULT NULL,
  `codigo_contrato` bigint(20) DEFAULT NULL COMMENT 'Secuencia autoincremento de contrato',
  `codigo_bolsa_seguridad` bigint(20) DEFAULT NULL,
  `codigo_inventario` bigint(20) DEFAULT NULL,
  `codigo_plan_separe` bigint(20) DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `sede_principal` bit(1) DEFAULT b'0',
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id_tienda`),
  CONSTRAINT `tbl_secuencia_tienda_ibfk_1` FOREIGN KEY (`id_tienda`) REFERENCES `tbl_tienda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_secuencia_tienda
-- ----------------------------
INSERT INTO `tbl_secuencia_tienda` VALUES ('1', '12', '1', '1', '1', '1', null, '\0', '');

-- ----------------------------
-- Table structure for tbl_sociedad
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sociedad`;
CREATE TABLE `tbl_sociedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nit` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `regimen` varchar(255) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nit_UNIQUE` (`nit`,`nombre`,`id_ciudad`,`regimen`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sociedad
-- ----------------------------
INSERT INTO `tbl_sociedad` VALUES ('1', '3242', 'Complicada', 'Subs', '1', '');
INSERT INTO `tbl_sociedad` VALUES ('2', '756', 'Prueba', 'Null', '1', '\0');
INSERT INTO `tbl_sociedad` VALUES ('3', '324', 'DENARIOS LTDA', 'Subs', '6', '');
INSERT INTO `tbl_sociedad` VALUES ('4', '75645432123', 'IMPUINVERSIONES', 'N/A', '5', '');
INSERT INTO `tbl_sociedad` VALUES ('6', '6283662-2', 'SOCIEDAD ALPHA', 'NA', '1', '');

-- ----------------------------
-- Table structure for tbl_sys_estado_tema
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sys_estado_tema`;
CREATE TABLE `tbl_sys_estado_tema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tema` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ESTAD_TEMA_idx` (`id_tema`) USING BTREE,
  CONSTRAINT `tbl_sys_estado_tema_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `tbl_sys_tema` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sys_estado_tema
-- ----------------------------
INSERT INTO `tbl_sys_estado_tema` VALUES ('35', '4', 'Cerrado', 'NA', '');
INSERT INTO `tbl_sys_estado_tema` VALUES ('37', '4', 'En estudio', 'Objeto Sospechoso', '');
INSERT INTO `tbl_sys_estado_tema` VALUES ('38', '4', 'Colombia', 'Pasaporte', '');

-- ----------------------------
-- Table structure for tbl_sys_lenguaje
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sys_lenguaje`;
CREATE TABLE `tbl_sys_lenguaje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `abreviatura` varchar(10) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sys_lenguaje
-- ----------------------------
INSERT INTO `tbl_sys_lenguaje` VALUES ('1', 'Inglés', 'En', '');
INSERT INTO `tbl_sys_lenguaje` VALUES ('2', 'Español', 'Es', '');

-- ----------------------------
-- Table structure for tbl_sys_motivo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sys_motivo`;
CREATE TABLE `tbl_sys_motivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sys_motivo
-- ----------------------------
INSERT INTO `tbl_sys_motivo` VALUES ('1', 'Retiro', 'Cuando se retiras', '');
INSERT INTO `tbl_sys_motivo` VALUES ('2', 'Cartera', 'Esta en carterass', '');
INSERT INTO `tbl_sys_motivo` VALUES ('3', 'Pagando', 'Se esta pagando', '');
INSERT INTO `tbl_sys_motivo` VALUES ('5', 'Pendientes', 'Pendiente por aprobars', '');
INSERT INTO `tbl_sys_motivo` VALUES ('10', 'Otro', 'algo mas esta pasando', '\0');
INSERT INTO `tbl_sys_motivo` VALUES ('11', 'Abierto', 'El tema aun esta abierto', '');
INSERT INTO `tbl_sys_motivo` VALUES ('12', 'Hurto', 'Cerrado por hurto', '');
INSERT INTO `tbl_sys_motivo` VALUES ('13', 'Problema Legal', 'Problemas legales', '');

-- ----------------------------
-- Table structure for tbl_sys_motivo_estado
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sys_motivo_estado`;
CREATE TABLE `tbl_sys_motivo_estado` (
  `id_motivo` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  UNIQUE KEY `id_motivo_UNIQUE` (`id_motivo`,`id_estado`) USING BTREE,
  UNIQUE KEY `id_estado_Motivo_UNIQUE` (`id_motivo`,`id_estado`) USING BTREE,
  KEY `FK_MOTIV_ESTAD_MOTIV_idx` (`id_motivo`) USING BTREE,
  KEY `FK_MOTIV_ESTAD_ESTAD_idx` (`id_estado`) USING BTREE,
  CONSTRAINT `tbl_sys_motivo_estado_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `tbl_sys_estado_tema` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_sys_motivo_estado_ibfk_2` FOREIGN KEY (`id_motivo`) REFERENCES `tbl_sys_motivo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sys_motivo_estado
-- ----------------------------
INSERT INTO `tbl_sys_motivo_estado` VALUES ('12', '35');
INSERT INTO `tbl_sys_motivo_estado` VALUES ('13', '35');
INSERT INTO `tbl_sys_motivo_estado` VALUES ('14', '38');
INSERT INTO `tbl_sys_motivo_estado` VALUES ('16', '37');
INSERT INTO `tbl_sys_motivo_estado` VALUES ('17', '37');

-- ----------------------------
-- Table structure for tbl_sys_tema
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sys_tema`;
CREATE TABLE `tbl_sys_tema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sys_tema
-- ----------------------------
INSERT INTO `tbl_sys_tema` VALUES ('4', 'Contrato', '');

-- ----------------------------
-- Table structure for tbl_sys_tipo_moneda
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sys_tipo_moneda`;
CREATE TABLE `tbl_sys_tipo_moneda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `abreviatura` varchar(10) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sys_tipo_moneda
-- ----------------------------
INSERT INTO `tbl_sys_tipo_moneda` VALUES ('4', 'Peso Colombiano', 'COP', '');
INSERT INTO `tbl_sys_tipo_moneda` VALUES ('5', 'Peso Mexicano', 'MEX', '');
INSERT INTO `tbl_sys_tipo_moneda` VALUES ('6', 'Dolar', 'US', '');

-- ----------------------------
-- Table structure for tbl_tienda
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tienda`;
CREATE TABLE `tbl_tienda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  `ip_fija` varchar(20) NOT NULL,
  `descripcion` longtext,
  `direccion` varchar(255) NOT NULL,
  `telefono` int(11) NOT NULL,
  `id_sociedad` int(11) NOT NULL,
  `id_zona` int(11) NOT NULL,
  `id_franquicia` int(11) NOT NULL,
  `tienda_padre` int(11) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`) USING BTREE,
  KEY `PK_TIEN_SOCI` (`id_sociedad`) USING BTREE,
  KEY `PK_TIEN_ZONA` (`id_zona`) USING BTREE,
  KEY `PK_TIEN_FRAN` (`id_franquicia`) USING BTREE,
  CONSTRAINT `tbl_tienda_ibfk_1` FOREIGN KEY (`id_franquicia`) REFERENCES `tbl_franquicia` (`id`),
  CONSTRAINT `tbl_tienda_ibfk_2` FOREIGN KEY (`id_sociedad`) REFERENCES `tbl_sociedad` (`id`),
  CONSTRAINT `tbl_tienda_ibfk_3` FOREIGN KEY (`id_zona`) REFERENCES `tbl_zona` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_tienda
-- ----------------------------
INSERT INTO `tbl_tienda` VALUES ('1', 'La Dorada', '10.220.0.1', 'Prueba', 'Calle 34 A 200-7', '4562255', '4', '15', '7', null, '');

-- ----------------------------
-- Table structure for tbl_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tbl_usuario`;
CREATE TABLE `tbl_usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verify_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_role` int(10) unsigned DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_role` (`id_role`) USING BTREE,
  CONSTRAINT `tbl_usuario_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `tbl_usuario_role` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_usuario
-- ----------------------------
INSERT INTO `tbl_usuario` VALUES ('1', 'Administrador', 'admin@admin.co', '$2y$10$IAtT3DvoHhwrMkaoP838bePDmYqvfhbAo6.ub8HrJRXKVbG1hiDGe', null, 'JsmVbBWfx28W7iE1pZDBqhKipD29EzJOc7dpcw4CdSzEsxu6aajEZlLt008R', '41', '1', '2017-08-23 11:57:08', '2017-08-24 13:59:00');

-- ----------------------------
-- Table structure for tbl_usuario_funcionalidad
-- ----------------------------
DROP TABLE IF EXISTS `tbl_usuario_funcionalidad`;
CREATE TABLE `tbl_usuario_funcionalidad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_modulo` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`) USING BTREE,
  KEY `id_modulo` (`id_modulo`) USING BTREE,
  CONSTRAINT `tbl_usuario_funcionalidad_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `tbl_usuario_modulo` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_usuario_funcionalidad
-- ----------------------------
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('4', 'gestionUser.usuario', 'Administrar Usuario', '4', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('8', 'gestionUser.rol', 'Administrar Roles', '4', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('9', 'gestionUser.funcion', 'Administrar Funcionalidades', '4', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('10', 'admonGeneral.general', 'Parámetros Generales', '5', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('11', 'admonGeneral.locacion', 'Maestro Locaciones', '5', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('13', 'admonGeneral.sociedad', 'Maestro Sociedades', '5', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('14', 'admonGeneral.estado', 'Maestro Estados y Motivos', '5', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('15', 'gestionCliente.parametro', 'Parametrización Clientes', '6', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('16', 'gestionHumana.empleado', 'Gestión Empleados', '7', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('17', 'gestionHumana.reporte', 'Reportes de Empleados', '7', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('18', 'gestionHumana.asociar.tienda', 'Asociar Tiendas', '7', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('19', 'gestionHumana.asociar.sociedad', 'Asociar Sociedades', '7', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('20', 'gestionProducto.asociar.general', 'Categoría General', '8', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('21', 'gestionProducto.atributo.producto', 'Atributos de Productos', '8', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('22', 'gestionProducto.valor.atributo', 'Valores de Atributos', '8', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('23', 'gestionProducto.catalogo.producto', 'Catálogo de Productos', '8', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('24', 'gestionContrato.config.general', 'Configuración General', '9', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('25', 'gestionContrato.config.especifica', 'Configuración Especifica', '9', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('26', 'gestionContrato.config.dia.gracia', 'Configuración Días de Gracia', '9', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('27', 'gestionContrato.config.retroventa', 'Configuración Básica Retroventa', '9', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('28', 'gestionContrato.config.contrato', 'Configuración Item para Contrato', '9', null, null);
INSERT INTO `tbl_usuario_funcionalidad` VALUES ('29', 'gestionContrato.config.peso', 'Confirugación Peso Sugerido', '9', null, null);

-- ----------------------------
-- Table structure for tbl_usuario_modulo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_usuario_modulo`;
CREATE TABLE `tbl_usuario_modulo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

-- ----------------------------
-- Records of tbl_usuario_modulo
-- ----------------------------
INSERT INTO `tbl_usuario_modulo` VALUES ('4', 'Gestión de Usuarios');
INSERT INTO `tbl_usuario_modulo` VALUES ('5', 'Administración General');
INSERT INTO `tbl_usuario_modulo` VALUES ('6', 'Gestión de Clientes');
INSERT INTO `tbl_usuario_modulo` VALUES ('7', 'Gestión Humana');
INSERT INTO `tbl_usuario_modulo` VALUES ('8', 'Gestión de Productos ');
INSERT INTO `tbl_usuario_modulo` VALUES ('9', 'Gestión de Contratos ');

-- ----------------------------
-- Table structure for tbl_usuario_role
-- ----------------------------
DROP TABLE IF EXISTS `tbl_usuario_role`;
CREATE TABLE `tbl_usuario_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_usuario_role
-- ----------------------------
INSERT INTO `tbl_usuario_role` VALUES ('41', 'Administrador General', 'Administrador General', '2017-08-23 11:55:37', '2017-08-23 11:55:39');
INSERT INTO `tbl_usuario_role` VALUES ('42', 'Auxiliar de Tienda', 'NA', '2017-08-23 15:42:25', '2017-08-23 15:42:37');
INSERT INTO `tbl_usuario_role` VALUES ('43', 'jefe de Zona', 'NA', '2017-08-24 15:26:29', null);

-- ----------------------------
-- Table structure for tbl_usuario_role_funcionalidad
-- ----------------------------
DROP TABLE IF EXISTS `tbl_usuario_role_funcionalidad`;
CREATE TABLE `tbl_usuario_role_funcionalidad` (
  `id_role` int(10) unsigned NOT NULL,
  `id_funcionalidad` int(10) unsigned NOT NULL,
  KEY `id_role` (`id_role`) USING BTREE,
  KEY `id_funcionalidad` (`id_funcionalidad`) USING BTREE,
  CONSTRAINT `tbl_usuario_role_funcionalidad_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `tbl_usuario_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_usuario_role_funcionalidad_ibfk_2` FOREIGN KEY (`id_funcionalidad`) REFERENCES `tbl_usuario_funcionalidad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_usuario_role_funcionalidad
-- ----------------------------
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('42', '15');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '4');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '8');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '9');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '11');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '13');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '14');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '15');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '20');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '21');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '22');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '23');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '24');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '25');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '26');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '27');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '28');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '29');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '16');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '17');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '18');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '19');
INSERT INTO `tbl_usuario_role_funcionalidad` VALUES ('41', '10');

-- ----------------------------
-- Table structure for tbl_zona
-- ----------------------------
DROP TABLE IF EXISTS `tbl_zona`;
CREATE TABLE `tbl_zona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext,
  `id_ciudad` int(11) NOT NULL,
  `id_jefe_zona` bigint(20) DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`,`id_ciudad`) USING BTREE,
  UNIQUE KEY `id_ciudad_UNIQUE` (`id_ciudad`,`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_zona
-- ----------------------------
INSERT INTO `tbl_zona` VALUES ('1', 'San javier', null, '1', null, '\0');
INSERT INTO `tbl_zona` VALUES ('2', 'Santa Lucia', null, '1', null, '\0');
INSERT INTO `tbl_zona` VALUES ('3', 'Laureles', 'NA', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('4', 'Poblado', 'NA', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('5', 'La America', null, '1', null, '\0');
INSERT INTO `tbl_zona` VALUES ('6', 'ankarita', null, '4', null, '');
INSERT INTO `tbl_zona` VALUES ('7', 'Titiriankary', null, '4', null, '');
INSERT INTO `tbl_zona` VALUES ('8', 'viankary', 'asdasdasd', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('9', 'cuarkary', 'asd', '4', null, '');
INSERT INTO `tbl_zona` VALUES ('10', 'quinkary', null, '4', null, '');
INSERT INTO `tbl_zona` VALUES ('11', '* -@#.com/ \\', null, '4', null, '\0');
INSERT INTO `tbl_zona` VALUES ('12', 'sexkury', null, '4', null, '\0');
INSERT INTO `tbl_zona` VALUES ('13', 'Zamora', 'autopista Medellin', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('14', 'bello', 'Afueras de Medellin s', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('15', 'El Picacho', 'Por bello', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('16', 'quitasol', 'bello', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('17', 'Loreto', 'Azare', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('18', 'Parque Berrio', 'AS', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('19', 'El retiro', 'Por medellin', '1', null, '');
INSERT INTO `tbl_zona` VALUES ('21', 'Prueba22', 'Prueba22', '2', null, '');

-- ----------------------------
-- Procedure structure for crear_auditoria
-- ----------------------------
DROP PROCEDURE IF EXISTS `crear_auditoria`;
DELIMITER ;;
CREATE DEFINER=`c1siteoro`@`%` PROCEDURE `crear_auditoria`(
INOUT estado TINYINT(1),
INOUT msm TEXT,
IN `fecha_transaccion` datetime,
IN `id_modulo` int(11),
IN `id_usuario` int(11),
IN `numero_1` int(11),
IN `dato_1` varchar(255),
IN `fecha_1` datetime,
IN `numero_2` int(11),
IN `dato_2` varchar(255),
IN `fecha_2` datetime,
IN `numero_3` int(11),
IN `dato_3` varchar(255),
IN `fecha_3` datetime,
IN `transaccion` varchar(255),
IN `operacion` varchar(255),
IN log TEXT
)
BEGIN	  
	DECLARE code CHAR(5) DEFAULT '00000';
  DECLARE msg TEXT;	
	DECLARE EXIT HANDLER FOR SQLEXCEPTION 
	BEGIN
		GET DIAGNOSTICS CONDITION 1
		code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;
		SET @estado=0;
		SET @msm = CONCAT('code_error = ',code,', message = ',msg);
		RESIGNAL;
		ROLLBACK;
	END; 
	DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		GET DIAGNOSTICS CONDITION 1
		code = RETURNED_SQLSTATE, msg = MESSAGE_TEXT;		
		SET @msm = CONCAT('code_warning = ',code,', message = ',msg);
		RESIGNAL;
		ROLLBACK;
	END;
	START TRANSACTION;		
		INSERT INTO `bd_nutibara_des`.`tbl_historia_auditoria` 
		VALUES (
						fecha_transaccion,
						id_modulo ,
						id_usuario ,
						numero_1 , 
						dato_1 , 
						fecha_1 , 
						numero_2 , 
						dato_2 , 
						fecha_2 , 
						numero_3 , 
						dato_3 , 
						fecha_3 , 
						transaccion , 
						operacion,
						log
					);	
		SET estado=(SELECT 1);
		SET msm = (SELECT 'Auditoria creada correctamente.');	
	COMMIT;			
END
;;
DELIMITER ;
SET FOREIGN_KEY_CHECKS=1;
