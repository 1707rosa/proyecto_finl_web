-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema SIR
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema SIR
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `SIR` DEFAULT CHARACTER SET utf8 ;
USE `SIR` ;

-- -----------------------------------------------------
-- Table `SIR`.`Provincias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Provincias` ;

CREATE TABLE IF NOT EXISTS `SIR`.`Provincias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Municipios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Municipios` ;

CREATE TABLE IF NOT EXISTS `SIR`.`Municipios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `provincia_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Municipios_Provincias_idx` (`provincia_id` ASC) VISIBLE,
  CONSTRAINT `fk_Municipios_Provincias`
    FOREIGN KEY (`provincia_id`)
    REFERENCES `SIR`.`Provincias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Barrios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Barrios` ;

CREATE TABLE IF NOT EXISTS `SIR`.`Barrios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NULL,
  `municipio_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Barrio_Municipios1_idx` (`municipio_id` ASC) VISIBLE,
  CONSTRAINT `fk_Barrio_Municipios1`
    FOREIGN KEY (`municipio_id`)
    REFERENCES `SIR`.`Municipios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Usuarios` ;

CREATE TABLE IF NOT EXISTS `SIR`.`Usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `apellido` VARCHAR(45) NULL,
  `contraseña` VARCHAR(100) NULL,
  `rol` ENUM('admin', 'reportero', 'validador') NOT NULL,
  `fecha_registro` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `proveedor_oauth` VARCHAR(50) NULL,
  `oauth_id` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Tipos_incidencias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Tipos_incidencias` ;

CREATE TABLE IF NOT EXISTS `SIR`.`Tipos_incidencias` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Incidencias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Incidencias` ;

CREATE TABLE IF NOT EXISTS `SIR`.`Incidencias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `descripcion` VARCHAR(255) NOT NULL,
  `fecha` DATE NOT NULL,
  `muertos` INT NULL,
  `heridos` INT NULL,
  `perdida_estimada_de_RD` DECIMAL(18,2) NULL,
  `redes_link` VARCHAR(45) NULL,
  `foto` VARCHAR(255) NULL,
  `latitud` DECIMAL(18,8) NOT NULL,
  `longitud` DECIMAL(18,8) NOT NULL,
  `provincia_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `tipo_id` INT NOT NULL,
  `municipio_id` INT NOT NULL,
  `barrio_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Incidencias_Provincias1_idx` (`provincia_id` ASC) VISIBLE,
  INDEX `fk_Incidencias_Usuarios1_idx` (`usuario_id` ASC) VISIBLE,
  INDEX `fk_Incidencias_Tipos_incidencias1_idx` (`tipo_id` ASC) VISIBLE,
  INDEX `fk_Incidencias_Municipios1_idx` (`municipio_id` ASC) VISIBLE,
  INDEX `fk_Incidencias_Barrio1_idx` (`barrio_id` ASC) VISIBLE,
  CONSTRAINT `fk_Incidencias_Provincias1`
    FOREIGN KEY (`provincia_id`)
    REFERENCES `SIR`.`Provincias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Incidencias_Usuarios1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `SIR`.`Usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Incidencias_Tipos_incidencias1`
    FOREIGN KEY (`tipo_id`)
    REFERENCES `SIR`.`Tipos_incidencias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Incidencias_Municipios1`
    FOREIGN KEY (`municipio_id`)
    REFERENCES `SIR`.`Municipios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Incidencias_Barrio1`
    FOREIGN KEY (`barrio_id`)
    REFERENCES `SIR`.`Barrios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Comentarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Comentarios` ;

CREATE TABLE IF NOT EXISTS `SIR`.`Comentarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Contenido` TEXT NULL,
  `fecha` DATETIME NULL DEFAULT Current_timestamp,
  `usuarios_id` INT NOT NULL,
  `incidencias_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Comentarios_Usuarios1_idx` (`usuarios_id` ASC) VISIBLE,
  INDEX `fk_Comentarios_Incidencias1_idx` (`incidencias_id` ASC) VISIBLE,
  CONSTRAINT `fk_Comentarios_Usuarios1`
    FOREIGN KEY (`usuarios_id`)
    REFERENCES `SIR`.`Usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comentarios_Incidencias1`
    FOREIGN KEY (`incidencias_id`)
    REFERENCES `SIR`.`Incidencias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Correcciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Correcciones` ;

CREATE TABLE IF NOT EXISTS `SIR`.`Correcciones` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `campo` VARCHAR(50) NULL,
  `sugerencia` TEXT NULL,
  `estado` ENUM('pendiente', 'aceptada', 'rechazada') NOT NULL,
  `incidencias_id` INT NOT NULL,
  `usuarios_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Correcciones_Incidencias1_idx` (`incidencias_id` ASC) VISIBLE,
  INDEX `fk_Correcciones_Usuarios1_idx` (`usuarios_id` ASC) VISIBLE,
  CONSTRAINT `fk_Correcciones_Incidencias1`
    FOREIGN KEY (`incidencias_id`)
    REFERENCES `SIR`.`Incidencias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Correcciones_Usuarios1`
    FOREIGN KEY (`usuarios_id`)
    REFERENCES `SIR`.`Usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



------- Inserciones -------------------------------------------
INSERT INTO usuarios (nombre, email, contraseña, rol)
VALUES (
    'Berlyng',
    'berlyng@example.com',
    '$2y$12$2JrC6cUfpTkVWjyu5f3qPeq.tE/XCb5NX7h9aGrnql0FgNA77RvZe',
    'admin'
);

INSERT INTO Tipos_incidencias (id, nombre) VALUES
(1, 'Accidente'),
(2, 'Desastre Natural'),
(3, 'Robo'),
(4, 'Pelea'),
(5, 'Incendio');



INSERT INTO Incidencias 
(titulo, descripcion, fecha, muertos, heridos, perdida_estimada_de_RD, redes_link, foto, latitud, longitud, provincia_id, municipio_id, barrio_id, usuario_id, tipo_id)
VALUES
('Accidente en Autopista Duarte', 'Choque múltiple durante las horas pico entre 3 vehículos', '2024-12-15', 0, 3, 500000.00, NULL, NULL, 18.48000000, -69.94000000, 1, 1, 1, 1, 1),
('Inundación en Los Alcarrizos', 'Desbordamiento del río Ozama tras lluvias intensas', '2024-12-14', 0, 0, 1000000.00, NULL, NULL, 18.53000000, -70.03000000, 1, 2, 2, 1, 2),
('Robo en supermercado', 'Asalto a mano armada en horario nocturno', '2024-12-13', 0, 1, 20000.00, NULL, NULL, 19.45000000, -70.69000000, 2, 3, 3, 1, 3),
('Pelea en centro comercial', 'Altercado entre grupos de jóvenes', '2024-12-12', 0, 2, 0.00, NULL, NULL, 18.50000000, -69.90000000, 1, 1, 1, 1, 4),
('Incendio en fábrica', 'Incendio controlado sin heridos', '2024-12-11', 0, 0, 250000.00, NULL, NULL, 19.23000000, -70.53000000, 3, 4, 4, 1, 5),
('Deslizamiento de tierra', 'Deslizamiento en carretera de montaña', '2024-12-10', 2, 5, 750000.00, NULL, NULL, 18.94000000, -70.41000000, 4, 5, 5, 1, 2);


INSERT INTO Provincias (nombre) VALUES
('Santo Domingo'),
('Santiago'),
('La Vega'),
('Monseñor Nouel');

INSERT INTO Municipios (nombre, provincia_id) VALUES
('Distrito Nacional', 1),
('Los Alcarrizos', 1),
('Santiago', 2),
('La Vega', 3),
('Bonao', 4);

INSERT INTO Barrios (nombre, municipio_id) VALUES
('Centro', 1),
('Villa Linda', 2),
('Centro Histórico', 3),
('Zona Industrial', 4),
('Carretera Montaña', 5);
