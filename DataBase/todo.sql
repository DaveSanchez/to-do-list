-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2014 a las 00:22:18
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `todo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flags`
--

CREATE TABLE IF NOT EXISTS `flags` (
  `Id_flag` int(11) NOT NULL AUTO_INCREMENT,
  `flag_name` varchar(10) NOT NULL,
  PRIMARY KEY (`Id_flag`),
  UNIQUE KEY `Id_flag_UNIQUE` (`Id_flag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `flags`
--

INSERT INTO `flags` (`Id_flag`, `flag_name`) VALUES
(1, 'En espera'),
(2, 'En marcha'),
(3, 'Terminado'),
(4, 'Fallido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `todo`
--

CREATE TABLE IF NOT EXISTS `todo` (
  `Id_todo` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `todo_name` varchar(30) DEFAULT NULL,
  `todo_description` varchar(250) DEFAULT NULL,
  `todo_dateCreated` date DEFAULT NULL,
  `todo_dateStart` date DEFAULT NULL,
  `todo_dateEnd` date DEFAULT NULL,
  `Id_user` int(11) DEFAULT NULL,
  `Id_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_todo`),
  KEY `Id_user_todo_idx` (`Id_user`),
  KEY `Id_flag_todo_idx` (`Id_flag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Id_user` int(11) NOT NULL AUTO_INCREMENT,
  `user_nick` varchar(15) NOT NULL,
  `user_password` text NOT NULL,
  `user_salt` text NOT NULL,
  PRIMARY KEY (`Id_user`),
  UNIQUE KEY `Id_user_UNIQUE` (`Id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `Id_flag_todo` FOREIGN KEY (`Id_flag`) REFERENCES `flags` (`Id_flag`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Id_user_todo` FOREIGN KEY (`Id_user`) REFERENCES `users` (`Id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
