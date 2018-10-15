/* Tabla Países */
USE bd_nutibara_des;

CREATE TABLE tbl_countries(
id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
name varchar(255) NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NULL,
deleted_at DATETIME NULL,
id_user_created_at int NOT NULL,
id_user_updated_at int NULL,
id_user_deleted_at int NULL,
state int NOT NULL
);


/* Tabla Departamentos */
CREATE TABLE tbl_provinces(
id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
name varchar(255) NOT NULL,
id_country int NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NULL,
deleted_at DATETIME NULL,
id_user_created_at int NOT NULL,
id_user_updated_at int NULL,
id_user_deleted_at int NULL,
state int NOT NULL
);
ALTER TABLE tbl_provinces ADD CONSTRAINT PK_province_country FOREIGN KEY (id_country) REFERENCES tbl_countries(id);


/* Tabla Ciudades */
CREATE TABLE tbl_cities(
id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
name varchar(255) NOT NULL,
id_province int NOT NULL,
id_country int NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NULL,
deleted_at DATETIME NULL,
id_user_created_at int NOT NULL,
id_user_updated_at int NULL,
id_user_deleted_at int NULL,
state int NOT NULL
);
ALTER TABLE tbl_cities ADD CONSTRAINT PK_city_country FOREIGN KEY (id_province) REFERENCES tbl_provinces(id);
ALTER TABLE tbl_cities ADD CONSTRAINT PK_city_country_2 FOREIGN KEY (id_country) REFERENCES tbl_countries(id);


/* Tabla Franquicias */
CREATE TABLE tbl_franchises(
id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
name varchar(255) NOT NULL,
description longtext NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NULL,
deleted_at DATETIME NULL,
id_user_created_at int NOT NULL,
id_user_updated_at int NULL,
id_user_deleted_at int NULL,
state int NOT NULL
);


/* Tabla Sociedades */
CREATE TABLE tbl_society(
id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nit varchar(255) NOT NULL,
name varchar(255) NOT NULL,
regime varchar(255) NOT NULL,
id_franchise int NOT NULL,
id_country int NOT NULL,
id_province int NOT NULL,
id_city int NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME NULL,
deleted_at DATETIME NULL,
id_user_created_at int NOT NULL,
id_user_updated_at int NULL,
id_user_deleted_at int NULL,
state int NOT NULL
);


/* Tabla Franquicias */
CREATE TABLE tbl_zona(
id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nombre varchar(500) NOT NULL,
descripcion longtext NULL,
state int NOT NULL
);


/* Tabla Tiendas */
CREATE TABLE tbl_tienda(
id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nombre varchar(500) NOT NULL,
ip_fija varchar(20) NOT NULL,
descripcion longtext NULL,
direccion varchar(255) NOT NULL,
telefono int NOT NULL,
id_sociedad int NOT NULL,
id_zona int NOT NULL,
id_franquicia int NOT NULL,
tienda_padre int NULL,
estado bit(1) NOT NULL
);
ALTER TABLE tbl_tienda ADD CONSTRAINT PK_TIEN_SOCI FOREIGN KEY (id_sociedad) REFERENCES tbl_sociedad(id);
ALTER TABLE tbl_tienda ADD CONSTRAINT PK_TIEN_ZONA FOREIGN KEY (id_zona) REFERENCES tbl_zona(id);
ALTER TABLE tbl_tienda ADD CONSTRAINT PK_TIEN_FRAN FOREIGN KEY (id_franquicia) REFERENCES tbl_franquicia(id);


/* Tabla Secuencia Tiendas */
CREATE  TABLE IF NOT EXISTS `bd_nutibara_des`.`tbl_secuencia_tienda` (
  `id_tienda` INT NOT NULL ,
  `codigo_cliente` BIGINT NULL ,
  `codigo_contrato` BIGINT NULL COMMENT 'Secuencia autoincremento de contrato' ,
  `codigo_bolsa_seguridad` BIGINT NULL ,
  `codigo_inventario` BIGINT NULL ,
  `codigo_plan_separe` BIGINT NULL ,
  `fecha_actualizacion` DATETIME NULL ,
  `estado` BIT(1) NULL ,
  PRIMARY KEY (`id_tienda`) ,
  CONSTRAINT `FK_SEC_TIE_TIE`
    FOREIGN KEY (`id_tienda` )
    REFERENCES `bd_nutibara_des`.`tbl_tienda` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


/* Tabla Secuencia Tiendas */
CREATE TABLE IF NOT EXISTS `bd_nutibara_des`.`tbl_paramentro_general` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_medida_peso` INT NULL  COMMENT 'Hacer tabla para la llave foránea',
  `id_pais` INT NOT NULL ,
  `id_lenguaje` VARCHAR(20) NOT NULL ,
  `id_moneda` INT NOT NULL COMMENT 'Hacer tabla para la llave foránea' ,
  `estado_activo` BIT(1) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


/* Tabla Dia Gracia Retroventa */
CREATE  TABLE IF NOT EXISTS `bd_nutibara_des`.`tbl_contr_dia_retroventa` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_zona` INT NOT NULL ,
  `id_tienda` INT NULL ,
  `dias_gracia` INT NOT NULL ,
  `estado` BIT(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `FK_CTR_DIA_TIEN_idx` (`id_tienda` ASC) ,
  INDEX `FK_CTR_DIA_ZONA_idx` (`id_zona` ASC) ,
  CONSTRAINT `FK_CTR_DIA_TIEN`
    FOREIGN KEY (`id_tienda` )
    REFERENCES `bd_nutibara_des`.`tbl_tienda` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CTR_DIA_ZONA`
    FOREIGN KEY (`id_zona` )
    REFERENCES `bd_nutibara_des`.`tbl_zona` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


/* Tabla Contratos Aplicación Retroventa */
CREATE  TABLE IF NOT EXISTS `bd_nutibara_des`.`tbl_contr_aplicacion_retroventa` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_zona` INT NOT NULL ,
  `id_tienda` INT NULL ,
  `meses_transcurridos` FLOAT NOT NULL ,
  `dias_transcurridos` FLOAT NOT NULL ,
  `menos_meses` FLOAT NOT NULL ,
  `menos_porcentaje_retroventas` FLOAT NOT NULL ,
  `monto_desde` FLOAT NOT NULL ,
  `monto_hasta` FLOAT NOT NULL ,
  `estado` BIT(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `FK_CTR_APLI_ZONA_idx` (`id_zona` ASC) ,
  INDEX `FK_CTR_APLI_TIEN_idx` (`id_tienda` ASC) ,
  CONSTRAINT `FK_CTR_APLI_ZONA`
    FOREIGN KEY (`id_zona` )
    REFERENCES `bd_nutibara_des`.`tbl_zona` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CTR_APLI_TIEN`
    FOREIGN KEY (`id_tienda` )
    REFERENCES `bd_nutibara_des`.`tbl_tienda` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


/* Tabla Contratos Configuración */
CREATE  TABLE IF NOT EXISTS `bd_nutibara_des`.`tbl_contr_configuracion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_zona` INT NOT NULL ,
  `id_tienda` INT NULL ,
  `id_categoria_general` INT NULL ,
  `id_calificacion_cliente` INT NULL ,
  `monto_desde` FLOAT NOT NULL ,
  `monto_hasta` FLOAT NOT NULL ,
  `fecha_hora_vigencia_desde` DATETIME NULL ,
  `fecha_hora_vigencia_hasta` DATETIME NULL ,
  `termino_contrato` INT NULL ,
  `porcentaje_retroventa` FLOAT NULL ,
  `estado` BIT(1) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `FK_CTR_APLI_ZONA_idx` (`id_zona` ASC) ,
  INDEX `FK_CTR_APLI_TIEN_idx` (`id_tienda` ASC) ,
  INDEX `FK_CTR_CONF_CAT_GRAL_idx` (`id_categoria_general` ASC) ,
  CONSTRAINT `FK_CTR_CONF_ZONA`
    FOREIGN KEY (`id_zona` )
    REFERENCES `bd_nutibara_des`.`tbl_zona` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CTR_CONF_TIEN`
    FOREIGN KEY (`id_tienda` )
    REFERENCES `bd_nutibara_des`.`tbl_tienda` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CTR_CONF_CAT_GRAL`
    FOREIGN KEY (`id_categoria_general` )
    REFERENCES `bd_nutibara_des`.`tbl_prod_categoria_general` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


/* Tabla Cliente Áreas de trabajo*/
CREATE  TABLE IF NOT EXISTS `bd_nutibara_des`.`tbl_clie_area_trabajo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(500) NOT NULL ,
  `descripcion` MEDIUMTEXT NULL ,
  `estado` BIT(1) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


/* Tabla Cliente Profesiones*/
CREATE  TABLE IF NOT EXISTS `bd_nutibara_des`.`tbl_clie_profesion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(500) NOT NULL ,
  `descripcion` MEDIUMTEXT NULL ,
  `estado` BIT(1) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


/* Tabla Cliente Nivel de Estudio*/
CREATE  TABLE IF NOT EXISTS `bd_nutibara_des`.`tbl_clie_nivel_estudio` (
  `id` INT NOT NULL ,
  `nombre` VARCHAR(500) NULL ,
  `descripcion` MEDIUMTEXT NULL ,
  `estado` BIT(1) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


/* Tabla Cliente Pasatiempos*/
CREATE  TABLE IF NOT EXISTS `bd_nutibara_des`.`tbl_clie_pasatiempos` (
  `id` INT NOT NULL ,
  `nombre` VARCHAR(500) NULL ,
  `descripcion` MEDIUMTEXT NULL ,
  `estado` BIT(1) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


/* Tabla Cliente Tipo Documento*/
CREATE  TABLE IF NOT EXISTS `mydb`.`tbl_tipo_documento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(255) NOT NULL ,
  `descripcion` LONGTEXT NULL ,
  `state` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB

/*drop table provinces;
drop table cities;
drop table countries;
drop table tbl_franchises;*/