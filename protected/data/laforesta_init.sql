-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `laforesta`;
CREATE DATABASE `laforesta` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `laforesta`;

DROP TABLE IF EXISTS `calculo`;
CREATE TABLE `calculo` (
  `id_calculo` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_insumo` int(11) NOT NULL,
  `costo_x_unidad` double NOT NULL DEFAULT '0',
  `cantidad_uso` double NOT NULL DEFAULT '0',
  `id_unidad` int(11) DEFAULT NULL,
  `costo_calculado` double NOT NULL DEFAULT '0',
  `observaciones` varchar(80) DEFAULT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_calculo`),
  KEY `id_producto` (`id_producto`),
  KEY `id_insumo` (`id_insumo`),
  KEY `id_unidad` (`id_unidad`),
  CONSTRAINT `calculo_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  CONSTRAINT `calculo_ibfk_2` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`id_insumo`),
  CONSTRAINT `calculo_ibfk_3` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id_unidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `insumo`;
CREATE TABLE `insumo` (
  `id_insumo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `costo_base` double NOT NULL DEFAULT '0',
  `habilitado` tinyint(4) NOT NULL DEFAULT '1',
  `largo` double DEFAULT NULL,
  `ancho` double DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL,
  `cantidad_total` double DEFAULT NULL,
  `costo_x_unidad` double DEFAULT NULL,
  PRIMARY KEY (`id_insumo`),
  KEY `id_tipo` (`id_tipo`),
  KEY `id_unidad` (`id_unidad`),
  CONSTRAINT `insumo_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`),
  CONSTRAINT `insumo_ibfk_2` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id_unidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `costo` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tipo`;
CREATE TABLE `tipo` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `calculo` varchar(60) NOT NULL,
  `descripcion` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tipo` (`id_tipo`, `nombre`, `calculo`, `descripcion`) VALUES
(1,	'Directo',	'simple',	'Insumos de cálculo directo, cantidad usada x costo base. Como por ejemplo bisagras, guías, tornillos...etc'),
(2,	'Superficie',	'bidimensional',	'Insumos cuyo uso se calcula en dos dimensiones, largo y ancho y se debe optimizar su aprovechamiento. Ejemplo de estos son las planchas de melamina o alguna otra madera.'),
(3,	'Lineal',	'unidimensional',	'Son insumos los cuales su cálculo depende de la medida en que se use, por ejemplo cintas de cantos, dónde se usan determinados cm y la misma tiene un costo x cm.');

DROP TABLE IF EXISTS `unidad`;
CREATE TABLE `unidad` (
  `id_unidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `habilitado` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_unidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `unidad` (`id_unidad`, `nombre`, `habilitado`) VALUES
(1,	'M',	1),
(2,	'CM',	1),
(3,	'MM',	1),
(4,	'Lts',	1);

-- 2015-03-27 23:25:06
