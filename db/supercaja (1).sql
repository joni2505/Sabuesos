-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-07-2023 a las 01:23:01
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sabuesos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supercaja`
--

CREATE TABLE `supercaja` (
  `idsuperCaja` int(11) NOT NULL,
  `nombreCaja` varchar(100) NOT NULL,
  `fechaApertura` date NOT NULL,
  `efectivoApertura` decimal(10,0) NOT NULL,
  `fechaCierre` date NOT NULL,
  `efectivoCierre` decimal(10,0) NOT NULL,
  `creditoCierre` decimal(10,0) NOT NULL,
  `debitoCierre` decimal(10,0) NOT NULL,
  `transferenciaCierre` decimal(10,0) NOT NULL,
  `compras` decimal(10,0) NOT NULL,
  `gastos` decimal(10,0) NOT NULL,
  `totalN` decimal(10,0) NOT NULL,
  `totalB` decimal(10,0) NOT NULL,
  `totalA` decimal(10,0) NOT NULL,
  `cantVentas` decimal(10,0) NOT NULL,
  `cantArticulos` decimal(10,0) NOT NULL,
  `totalDescuentos` decimal(10,0) NOT NULL,
  `totalRecargos` decimal(10,0) NOT NULL,
  `retiroEfectivo` decimal(10,0) NOT NULL,
  `estado` int(11) NOT NULL,
  `idlocal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `supercaja`
--
ALTER TABLE `supercaja`
  ADD PRIMARY KEY (`idsuperCaja`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `supercaja`
--
ALTER TABLE `supercaja`
  MODIFY `idsuperCaja` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
