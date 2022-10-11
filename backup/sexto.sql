-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2022 a las 03:09:09
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sexto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animales`
--

CREATE TABLE `animales` (
  `id` int(11) NOT NULL,
  `id_propietario` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `raza` varchar(20) NOT NULL,
  `casta` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(11) NOT NULL,
  `numero_doc` varchar(10) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `primer_apellido` varchar(15) NOT NULL,
  `segundo_apellido` varchar(15) NOT NULL,
  `estado` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `numero_doc`, `nombres`, `primer_apellido`, `segundo_apellido`, `estado`) VALUES
(1, '2222222', 'administrador', 'admin', 'admin', 'AC'),
(2, '1234569', 'DIEGO', 'ALCARAZ', 'DAZA', 'AC'),
(3, '1234569', 'BEATRIZ', 'AMARU', 'AMARU', 'AC'),
(4, '445465', 'ALVARO DIEGO', 'DAZA', 'SUAREZ', 'AC'),
(5, '445465', 'ALVARO DIEGO', 'DAZA', 'SUAREZ', 'AC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietarios`
--

CREATE TABLE `propietarios` (
  `id` int(11) NOT NULL,
  `documento` varchar(10) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `telefono` varchar(8) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `propietarios`
--

INSERT INTO `propietarios` (`id`, `documento`, `nombres`, `telefono`, `direccion`, `estado`) VALUES
(1, '011456', 'CAROLA CAMEO', '7245561', 'LA PAZ', 'AC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `estado` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `id_persona`, `tipo_usuario`, `username`, `clave`, `estado`) VALUES
(1, 1, 1, 'admin.admin', 'e10adc3949ba59abbe56e057f20f883e', 'AC'),
(2, 2, 2, 'alvaro.llusco', 'e10adc3949ba59abbe56e057f20f883e', 'EX'),
(3, 3, 2, 'BEATRIZ.AMARU', 'e10adc3949ba59abbe56e057f20f883e', 'AC'),
(4, 4, 1, 'ALVARODIEGO.DAZA', 'e10adc3949ba59abbe56e057f20f883e', 'AC'),
(5, 5, 1, 'ALVARODIEGO.DAZA', 'e10adc3949ba59abbe56e057f20f883e', 'AC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `animales`
--
ALTER TABLE `animales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `propietarios`
--
ALTER TABLE `propietarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `animales`
--
ALTER TABLE `animales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `propietarios`
--
ALTER TABLE `propietarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
