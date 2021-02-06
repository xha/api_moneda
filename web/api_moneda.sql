-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-02-2021 a las 02:49:17
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api_moneda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `idMoneda` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `simbolo` varchar(10) NOT NULL DEFAULT '',
  `alias` varchar(10) NOT NULL,
  `principal` bit(1) NOT NULL DEFAULT b'0',
  `fechaCreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUsuario` int(11) NOT NULL,
  `activo` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`idMoneda`, `descripcion`, `simbolo`, `alias`, `principal`, `fechaCreacion`, `idUsuario`, `activo`) VALUES
(1, 'DOLAR', '$', 'USD', b'1', '2021-02-05 16:09:28', 1, b'1'),
(2, 'EURO', '€', 'EUR', b'0', '2021-02-05 16:09:28', 1, b'1'),
(3, 'ETHEREUM', 'E', 'ETH', b'0', '2021-02-05 16:45:24', 1, b'1'),
(4, 'BOLIVARES', 'Bs.', 'VES', b'0', '2021-02-05 16:48:48', 1, b'1'),
(5, 'PETRO', 'p', 'PTR', b'0', '2021-02-05 16:50:53', 1, b'1'),
(6, 'BITCOIN', 'b', 'BTC', b'0', '2021-02-05 19:01:56', 1, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasa`
--

CREATE TABLE `tasa` (
  `idTasa` int(11) NOT NULL,
  `idMoneda` int(11) NOT NULL,
  `tasaActual` decimal(34,14) NOT NULL DEFAULT '0.00000000000000',
  `idUsuario` int(11) NOT NULL,
  `fechaOperacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tasa`
--

INSERT INTO `tasa` (`idTasa`, `idMoneda`, `tasaActual`, `idUsuario`, `fechaOperacion`, `activo`) VALUES
(1, 4, '1790271.69000000000000', 1, '2021-02-05 00:00:00', b'1'),
(2, 4, '111111.00000000000000', 1, '2021-02-05 18:38:53', b'0'),
(3, 6, '0.00002600000000', 1, '2021-02-05 19:02:07', b'1'),
(4, 3, '0.00058000000000', 1, '2021-02-05 19:44:37', b'1'),
(5, 2, '0.83000000000000', 1, '2021-02-05 19:45:08', b'1'),
(6, 5, '0.01780309773901', 1, '2021-02-05 20:53:26', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fechaCreacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `activo` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `password`, `fechaCreacion`, `activo`) VALUES
(1, 'admin', '9df3bb42df815f39041a621f7282a475', '2021-02-05 01:52:40', b'1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`idMoneda`),
  ADD UNIQUE KEY `uq_monedas_alias` (`alias`),
  ADD KEY `fk_monedas_usuarios` (`idUsuario`);

--
-- Indices de la tabla `tasa`
--
ALTER TABLE `tasa`
  ADD PRIMARY KEY (`idTasa`),
  ADD KEY `fk_tasa_usuarios` (`idUsuario`),
  ADD KEY `fk_tasa_monedas` (`idMoneda`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `idMoneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tasa`
--
ALTER TABLE `tasa`
  MODIFY `idTasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD CONSTRAINT `fk_monedas_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `tasa`
--
ALTER TABLE `tasa`
  ADD CONSTRAINT `fk_tasa_monedas` FOREIGN KEY (`idMoneda`) REFERENCES `monedas` (`idMoneda`),
  ADD CONSTRAINT `fk_tasa_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
