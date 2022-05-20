-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2022 a las 22:48:28
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agroinventory`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calidad`
--

CREATE TABLE `calidad` (
  `id_calidad` int(2) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calidad`
--

INSERT INTO `calidad` (`id_calidad`, `descripcion`) VALUES
(1, '1 - Primera extra'),
(2, '2 - Segunda'),
(3, '3 - Grado de muestra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias_primas`
--

CREATE TABLE `materias_primas` (
  `id_mp` int(4) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `materias_primas`
--

INSERT INTO `materias_primas` (`id_mp`, `nombre`) VALUES
(1, 'PLATANO HARTON'),
(2, 'PLATANO COMINO'),
(3, 'PLATANO FHIA21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(4) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nit` varchar(20) NOT NULL,
  `telefonos` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `nit`, `telefonos`, `email`) VALUES
(1, 'ASOPLATANO', '1088285936', '3117884098 - 3111111111', 'asoplatano@gmail.com'),
(2, 'ASOPLAPIA', '105522987', '3052266741', 'asoplapia@gmail.com'),
(3, 'EL PLATANO FELIZ', '3332221111', '312222222 - 312345345', 'felizplantain@gmail.com'),
(4, 'ASOCIACION PLATANEROS RISARALDA', '1112223331', '3122225544-301226644', 'asosantuario@gmail.com'),
(5, 'UPLATUR', '3002226661', '3118877854-3225554444', 'uplatur@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id_registro` int(11) NOT NULL,
  `realizo` int(11) NOT NULL,
  `materia_prima` int(4) NOT NULL,
  `cantidad` decimal(10,0) NOT NULL,
  `calidad` int(1) NOT NULL,
  `brix` decimal(3,1) NOT NULL,
  `proveedor` int(4) NOT NULL,
  `stock` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_ingreso` timestamp NOT NULL DEFAULT current_timestamp(),
  `registro_activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id_registro`, `realizo`, `materia_prima`, `cantidad`, `calidad`, `brix`, `proveedor`, `stock`, `fecha_ingreso`, `registro_activo`) VALUES
(1, 1, 1, '0', 1, '12.0', 1, 0, '2022-05-19 01:44:18', 1),
(2, 1, 1, '0', 2, '11.0', 2, 0, '2022-05-19 01:45:49', 1),
(3, 1, 2, '0', 1, '11.0', 3, 0, '2022-05-19 01:47:42', 1),
(4, 1, 3, '10000', 1, '11.5', 1, 1, '2022-05-19 01:49:34', 0),
(5, 1, 2, '5000', 2, '8.5', 5, 1, '2022-05-19 02:31:27', 0),
(6, 1, 2, '2000', 1, '7.0', 3, 1, '2022-05-19 02:34:45', 0),
(7, 1, 1, '2000', 2, '13.0', 2, 1, '2022-05-20 19:49:20', 0),
(8, 1, 1, '5000', 2, '12.0', 1, 1, '2022-05-20 20:36:34', 1);

--
-- Disparadores `registros`
--
DELIMITER $$
CREATE TRIGGER `registrar_salidas` BEFORE UPDATE ON `registros` FOR EACH ROW BEGIN
    IF(new.registro_activo=1) THEN
    	INSERT INTO salidas (id_registro, realizo, materia_prima, cantidad_salida, calidad, brix, proveedor, fecha_ingreso) 
        VALUES (old.id_registro, old.realizo, old.materia_prima, (old.cantidad - new.cantidad), old.calidad, old.brix, old.proveedor, old.fecha_ingreso);
		IF(new.cantidad=0)THEN
        	SET new.stock = 0;
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id_salida` int(11) NOT NULL,
  `id_registro` int(11) NOT NULL,
  `realizo` int(11) NOT NULL,
  `materia_prima` int(4) NOT NULL,
  `cantidad_salida` int(11) NOT NULL,
  `calidad` int(1) NOT NULL,
  `brix` decimal(3,1) NOT NULL,
  `proveedor` int(4) NOT NULL,
  `fecha_ingreso` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `fecha_salida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `salidas`
--

INSERT INTO `salidas` (`id_salida`, `id_registro`, `realizo`, `materia_prima`, `cantidad_salida`, `calidad`, `brix`, `proveedor`, `fecha_ingreso`, `fecha_salida`) VALUES
(1, 2, 1, 1, 5000, 2, '11.0', 2, '2022-05-19 01:45:49', '2022-05-19 01:46:47'),
(2, 1, 1, 1, 2000, 1, '12.0', 1, '2022-05-19 01:44:18', '2022-05-19 01:46:53'),
(3, 1, 1, 1, 3000, 1, '12.0', 1, '2022-05-19 01:44:18', '2022-05-19 01:46:59'),
(4, 3, 1, 2, 1000, 1, '11.0', 3, '2022-05-19 01:47:42', '2022-05-19 01:47:48'),
(5, 3, 1, 2, 1000, 1, '11.0', 3, '2022-05-19 01:47:42', '2022-05-19 01:47:56'),
(6, 3, 1, 2, 1000, 1, '11.0', 3, '2022-05-19 01:47:42', '2022-05-19 01:48:00'),
(7, 6, 1, 2, 1000, 1, '7.0', 3, '2022-05-19 02:34:45', '2022-05-20 19:22:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `cedula` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `cedula`) VALUES
(1, 'Pepe Perez', '1085666333');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calidad`
--
ALTER TABLE `calidad`
  ADD PRIMARY KEY (`id_calidad`);

--
-- Indices de la tabla `materias_primas`
--
ALTER TABLE `materias_primas`
  ADD PRIMARY KEY (`id_mp`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `proveedor` (`proveedor`),
  ADD KEY `materia_prima` (`materia_prima`),
  ADD KEY `calidad` (`calidad`),
  ADD KEY `realizo` (`realizo`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id_salida`),
  ADD KEY `id_registro` (`id_registro`),
  ADD KEY `realizo` (`realizo`,`materia_prima`,`proveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calidad`
--
ALTER TABLE `calidad`
  MODIFY `id_calidad` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `materias_primas`
--
ALTER TABLE `materias_primas`
  MODIFY `id_mp` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id_salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`materia_prima`) REFERENCES `materias_primas` (`id_mp`),
  ADD CONSTRAINT `registros_ibfk_2` FOREIGN KEY (`proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `registros_ibfk_3` FOREIGN KEY (`calidad`) REFERENCES `calidad` (`id_calidad`),
  ADD CONSTRAINT `registros_ibfk_4` FOREIGN KEY (`realizo`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
