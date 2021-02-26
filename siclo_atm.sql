-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2021 a las 00:53:15
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `siclo_atm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_credito`
--

CREATE TABLE `cuentas_credito` (
  `id` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `limiteCredito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `cuentas_credito`
--

INSERT INTO `cuentas_credito` (`id`, `idCliente`, `saldo`, `limiteCredito`) VALUES
(1, 1, 5630, 30000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_debito`
--

CREATE TABLE `cuentas_debito` (
  `id` tinyint(2) NOT NULL,
  `idCliente` int(3) DEFAULT NULL,
  `saldo` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `cuentas_debito`
--

INSERT INTO `cuentas_debito` (`id`, `idCliente`, `saldo`) VALUES
(1, 1, 24000),
(2, 1, 1123);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuentas_credito`
--
ALTER TABLE `cuentas_credito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuentas_debito`
--
ALTER TABLE `cuentas_debito`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuentas_credito`
--
ALTER TABLE `cuentas_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cuentas_debito`
--
ALTER TABLE `cuentas_debito`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
