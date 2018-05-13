-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2018 a las 04:52:44
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `regio`
--
CREATE DATABASE IF NOT EXISTS `regio` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `regio`;

DELIMITER $$
--
-- Funciones
--
DROP FUNCTION IF EXISTS `change_status_user`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `change_status_user` (`id` INT) RETURNS INT(11) begin
	declare int_status int;
	select status into int_status from users where user_id = id;
	if int_status = 0 then
		update users set status = 1 where user_id = id;
		return 1;
	else
		update users set status = 0 where user_id = id;
		return 0;
	end if;
END$$

DROP FUNCTION IF EXISTS `delete_user`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `delete_user` (`id` INT) RETURNS INT(11) begin
	if (select user_id from users where user_id = id) is not null then
		delete from users where user_id = id;
		return 1;
	else
		return 0;
	end if;
END$$

DROP FUNCTION IF EXISTS `insertactividad`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `insertactividad` (`Fdescripcion` VARCHAR(255) COLLATE utf8_spanish_ci, `Ffecha` DATETIME, `Flugar` VARCHAR(255) COLLATE utf8_spanish_ci, `Fstatus` INT, `Fid_user_user` INT) RETURNS INT(11) begin
	INSERT INTO regio.actividad
		(
			Vdescripcion_actividad, 
			Dhorayfecha_actividad, 
			VLugar_Direccion, 
			IStatus_actividad, 
			fk_rd_rs
		)
	VALUES(
			Fdescripcion,
			Ffecha,
			Flugar,
			Fstatus,
			Fid_user_user
	);
	return last_insert_id();
END$$

DROP FUNCTION IF EXISTS `insert_rd_rs`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `insert_rd_rs` (`id_rd` INT, `id_rs` INT) RETURNS INT(11) BEGIN
	insert into user_user values(0,id_rd, id_rs);
	return last_insert_id();
END$$

DROP FUNCTION IF EXISTS `insert_user`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `insert_user` (`Ffirst_name` VARCHAR(45) COLLATE utf8_spanish_ci, `Flast_name` VARCHAR(45) COLLATE utf8_spanish_ci, `Fuser_name` VARCHAR(45) COLLATE utf8_spanish_ci, `Fuser_password_hash` VARCHAR(255) COLLATE utf8_spanish_ci, `Fuser_email` VARCHAR(45) COLLATE utf8_spanish_ci, `Fuser_type` INT) RETURNS INT(11) begin
	IF(
		select user_id from users where user_email collate utf8_spanish_ci = Fuser_email or user_name collate utf8_spanish_ci = Fuser_name
	  )
	  	then
			return -2; -- Nombre de usuario o correo ya estan registrados en el sistema
	else
			INSERT INTO regio.users(
				firstname, 
				lastname, 
				user_name, 
				user_password_hash, 
				user_email, 
				date_added, 
				user_type, 
				status)
			VALUES(
				Ffirst_name			, 
				Flast_name			, 
				Fuser_name			, 
				Fuser_password_hash	,
				Fuser_email			,
				NOW()				,
				Fuser_type			,
				1
			);
				-- Se supone que esto retorna el id de la operacion en curso, lo inserte en un
				-- procedimiento/funcion para que todo se ejecute en conjunto y pueda extraer corectamente
				-- el dato, postgresql tiene una forma mas facil y eficaz de realizar la operacion
				-- recomiendo revisar la nueva documetacion de mariadb si es necesario
			return last_insert_id();
	end if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

DROP TABLE IF EXISTS `actividad`;
CREATE TABLE IF NOT EXISTS `actividad` (
  `id_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `Vdescripcion_actividad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `BFoto1_actividad` longblob,
  `BFoto2_actividad` longblob COMMENT 'Corrige esto.... esta mal, xD jajaja',
  `Dhorayfecha_actividad` datetime NOT NULL,
  `VLugar_Direccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `IStatus_actividad` int(11) NOT NULL DEFAULT '1' COMMENT '1.- Archivado, 2.- En espera, 3.- Aceptado, 4.- Rechazado',
  `fk_rd_rs` int(11) DEFAULT NULL,
  `tipo_foto1` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_foto2` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_actividad`),
  KEY `actividad_user_user_fk` (`fk_rd_rs`),
  KEY `actividad_estados_actividad_fk` (`IStatus_actividad`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id_actividad`, `Vdescripcion_actividad`, `BFoto1_actividad`, `BFoto2_actividad`, `Dhorayfecha_actividad`, `VLugar_Direccion`, `IStatus_actividad`, `fk_rd_rs`, `tipo_foto1`, `tipo_foto2`) VALUES
(15, 'Cosa T de Cosa E', 0x5265736f7572636520696420233133, 0x5265736f7572636520696420233134, '2017-02-20 12:12:00', 'Un Lugar', 2, 4, 'jpg', 'jpg');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `alldatausersc`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `alldatausersc`;
CREATE TABLE IF NOT EXISTS `alldatausersc` (
`user_id` int(11)
,`firstname` varchar(20)
,`lastname` varchar(20)
,`user_name` varchar(64)
,`user_password_hash` varchar(255)
,`user_email` varchar(120)
,`date_added` datetime
,`user_type` int(2)
,`status` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_actividad`
--

DROP TABLE IF EXISTS `estados_actividad`;
CREATE TABLE IF NOT EXISTS `estados_actividad` (
  `id_actividad_ss` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_actividad` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_actividad_ss`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `estados_actividad`
--

INSERT INTO `estados_actividad` (`id_actividad_ss`, `nombre_actividad`) VALUES
(1, 'Registrado y en Espera'),
(2, 'Revision'),
(3, 'Aceptado'),
(4, 'Rechazado');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `getmyrd`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `getmyrd`;
CREATE TABLE IF NOT EXISTS `getmyrd` (
`user_id` int(11)
,`firstname` varchar(20)
,`lastname` varchar(20)
,`user_name` varchar(64)
,`user_password_hash` varchar(255)
,`user_email` varchar(120)
,`date_added` datetime
,`user_type` int(2)
,`status` int(11)
,`id_user_user` int(11)
,`fk_rd` int(11)
,`fk_rs` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `getmyrsall`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `getmyrsall`;
CREATE TABLE IF NOT EXISTS `getmyrsall` (
`id_user_user` int(11)
,`fk_rd` int(11)
,`user_id` int(11)
,`firstname` varchar(20)
,`lastname` varchar(20)
,`user_name` varchar(64)
,`user_password_hash` varchar(255)
,`user_email` varchar(120)
,`date_added` datetime
,`user_type` int(2)
,`status` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `firstname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `date_added` datetime NOT NULL COMMENT 'user''s date and time of creation',
  `user_type` int(2) NOT NULL COMMENT 'user''s type, multiple; 0.- Access, 1.-Administrator, 2.- SR 3.- RD, 4.- RS',
  `status` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `user_name`, `user_password_hash`, `user_email`, `date_added`, `user_type`, `status`) VALUES
(1, 'Obed', 'Alvarado', 'admin', '$2y$10$UGS5RE6UdsrYSNSGvgsA.uKhRg1Y/1r3RRLRpjAV3unn3MdNbNVHi', 'admin@admin.com', '2016-12-19 15:06:00', 0, 1),
(2, 'ADMINISTRATOR', 'Mora', 'user123', '$2y$10$UGS5RE6UdsrYSNSGvgsA.uKhRg1Y/1r3RRLRpjAV3unn3MdNbNVHi', 'mario@mario.com', '2017-11-12 00:00:00', 1, 1),
(8, 'TEACHER 1', 'TEACHER 1_APT', 'user123Teacher', '$2y$10$UGS5RE6UdsrYSNSGvgsA.uKhRg1Y/1r3RRLRpjAV3unn3MdNbNVHi', 'is@gmail.es', '2018-01-01 00:00:00', 4, 1),
(9, 'Obed', 'Alvarado', 'admin2', '$2y$10$UGS5RE6UdsrYSNSGvgsA.uKhRg1Y/1r3RRLRpjAV3unn3MdNbNVHi', 'admin2@admin.com', '2016-12-19 15:06:00', 1, 1),
(10, 'TEACHER 2', 'TEACHER 2_APT', 'user1232Teacher', '$2y$10$UGS5RE6UdsrYSNSGvgsA.uKhRg1Y/1r3RRLRpjAV3unn3MdNbNVHi', 'isc@gmail.es', '2018-01-01 00:00:00', 4, 1),
(11, 'SBDC', 'Jefe', 'DeCarrera1', '$2y$10$UGS5RE6UdsrYSNSGvgsA.uKhRg1Y/1r3RRLRpjAV3unn3MdNbNVHi', 'isc@gmai.es.es', '2018-01-01 00:00:00', 3, 1),
(25, 'Molino', 'Medina Tapia', 'MOLE-2018', '$2y$10$UGS5RE6UdsrYSNSGvgsA.uKhRg1Y/1r3RRLRpjAV3unn3MdNbNVHi', 'corazon@gmail.es', '2018-04-26 15:08:48', 4, 1),
(30, 'Ricardo', 'Montes de Orka', 'RIMO-2018', '$2y$10$7w9pI8cIgrZs/.EBqQfHzeyqBBSmRuRsCVmprMLZw6SDEr0kHU6i6', 'richa@tescha.com', '2018-04-26 15:15:51', 2, 1),
(31, 'Israel', 'Diaz', 'MedinaTapiaDiaz', '$2y$10$UGS5RE6UdsrYSNSGvgsA.uKhRg1Y/1r3RRLRpjAV3unn3MdNbNVHi', 'diasdias@gmail.es', '2018-04-26 16:20:00', 3, 1),
(32, 'Membretado', '123Mebretado', 'Jamon', '$2y$10$UGS5RE6UdsrYSNSGvgsA.uKhRg1Y/1r3RRLRpjAV3unn3MdNbNVHi', 'jamon@gmail.com', '2018-04-26 16:21:38', 3, 1),
(33, 'adan', 'lopez', 'adan', '$2y$10$T20EsEP80Elq0JmfuUoP7uEM6g9fGH2Oz2rUEGlPggROWetHhkybq', 'adan@hotmail.com', '2018-05-02 17:11:08', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_user`
--

DROP TABLE IF EXISTS `user_user`;
CREATE TABLE IF NOT EXISTS `user_user` (
  `id_user_user` int(11) NOT NULL AUTO_INCREMENT,
  `fk_rd` int(11) DEFAULT NULL,
  `fk_rs` int(11) NOT NULL,
  PRIMARY KEY (`id_user_user`),
  KEY `user_user_users_fk` (`fk_rd`),
  KEY `user_user_users_fk2` (`fk_rs`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user_user`
--

INSERT INTO `user_user` (`id_user_user`, `fk_rd`, `fk_rs`) VALUES
(1, 31, 25),
(2, 32, 8),
(3, 32, 10),
(4, 32, 25);

-- --------------------------------------------------------

--
-- Estructura para la vista `alldatausersc`
--
DROP TABLE IF EXISTS `alldatausersc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `alldatausersc`  AS  select `users`.`user_id` AS `user_id`,`users`.`firstname` AS `firstname`,`users`.`lastname` AS `lastname`,`users`.`user_name` AS `user_name`,`users`.`user_password_hash` AS `user_password_hash`,`users`.`user_email` AS `user_email`,`users`.`date_added` AS `date_added`,`users`.`user_type` AS `user_type`,`users`.`status` AS `status` from `users` where (`users`.`user_type` = 2) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `getmyrd`
--
DROP TABLE IF EXISTS `getmyrd`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getmyrd`  AS  select `u`.`user_id` AS `user_id`,`u`.`firstname` AS `firstname`,`u`.`lastname` AS `lastname`,`u`.`user_name` AS `user_name`,`u`.`user_password_hash` AS `user_password_hash`,`u`.`user_email` AS `user_email`,`u`.`date_added` AS `date_added`,`u`.`user_type` AS `user_type`,`u`.`status` AS `status`,`uu`.`id_user_user` AS `id_user_user`,`uu`.`fk_rd` AS `fk_rd`,`uu`.`fk_rs` AS `fk_rs` from (`users` `u` join `user_user` `uu` on((`u`.`user_id` = `uu`.`fk_rd`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `getmyrsall`
--
DROP TABLE IF EXISTS `getmyrsall`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getmyrsall`  AS  select `uu`.`id_user_user` AS `id_user_user`,`uu`.`fk_rd` AS `fk_rd`,`us`.`user_id` AS `user_id`,`us`.`firstname` AS `firstname`,`us`.`lastname` AS `lastname`,`us`.`user_name` AS `user_name`,`us`.`user_password_hash` AS `user_password_hash`,`us`.`user_email` AS `user_email`,`us`.`date_added` AS `date_added`,`us`.`user_type` AS `user_type`,`us`.`status` AS `status` from ((`user_user` `uu` left join `users` `u` on((`u`.`user_id` = `uu`.`fk_rd`))) join `users` `us` on((`us`.`user_id` = `uu`.`fk_rs`))) ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_estados_actividad_fk` FOREIGN KEY (`IStatus_actividad`) REFERENCES `estados_actividad` (`id_actividad_ss`),
  ADD CONSTRAINT `actividad_user_user_fk` FOREIGN KEY (`fk_rd_rs`) REFERENCES `user_user` (`id_user_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_user`
--
ALTER TABLE `user_user`
  ADD CONSTRAINT `user_user_users_fk` FOREIGN KEY (`fk_rd`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_user_users_fk2` FOREIGN KEY (`fk_rs`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
