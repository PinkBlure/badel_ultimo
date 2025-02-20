-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-02-2025 a las 02:09:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `sagasetaconecta`
--
CREATE DATABASE IF NOT EXISTS `sagasetaconecta` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sagasetaconecta`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--
-- Creación: 18-02-2025 a las 17:49:50
-- Última actualización: 19-02-2025 a las 00:43:15
--

CREATE TABLE `centro` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `centro`:
--

--
-- Volcado de datos para la tabla `centro`
--

INSERT INTO `centro` (`id`, `nombre`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--
-- Creación: 18-02-2025 a las 17:49:50
-- Última actualización: 19-02-2025 a las 01:02:07
--

CREATE TABLE `empresa` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `CIF` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verificado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `empresa`:
--

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `nombre`, `CIF`, `email`, `password`, `verificado`) VALUES
(1, 'Empresa A', 'A12345678', 'contacto@empresaa.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia_profesional`
--
-- Creación: 18-02-2025 a las 17:49:50
-- Última actualización: 18-02-2025 a las 17:49:50
--

CREATE TABLE `familia_profesional` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `familia_profesional`:
--

--
-- Volcado de datos para la tabla `familia_profesional`
--

INSERT INTO `familia_profesional` (`id`, `nombre`) VALUES
(1, 'Imagen personal'),
(2, 'Informática y comunicaciones'),
(3, 'Madera, mueble y corcho');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--
-- Creación: 18-02-2025 a las 17:49:50
--

CREATE TABLE `inscripcion` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `oferta_id` bigint(20) NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `inscripcion`:
--   `usuario_id`
--       `usuario` -> `id`
--   `oferta_id`
--       `oferta_empleo` -> `id`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_empleo`
--
-- Creación: 18-02-2025 a las 20:16:43
-- Última actualización: 18-02-2025 a las 20:26:19
--

CREATE TABLE `oferta_empleo` (
  `id` bigint(20) NOT NULL,
  `empresa_id` bigint(20) NOT NULL,
  `familia_id` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `ubicacion` varchar(255) NOT NULL,
  `presencialidad` enum('Presencial','Hibrido','Remoto') NOT NULL,
  `jornada` enum('Por horas','Jornada completa','Jornada parcial') NOT NULL,
  `tipo_contrato` enum('Indefinido','Temporal','Por obra') NOT NULL,
  `estado` enum('Activo','Pendiente de verificar','Oculto') NOT NULL DEFAULT 'Pendiente de verificar',
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `oferta_empleo`:
--   `empresa_id`
--       `empresa` -> `id`
--   `familia_id`
--       `familia_profesional` -> `id`
--

--
-- Volcado de datos para la tabla `oferta_empleo`
--

INSERT INTO `oferta_empleo` (`id`, `empresa_id`, `familia_id`, `titulo`, `descripcion`, `fecha_publicacion`, `verificado`, `ubicacion`, `presencialidad`, `jornada`, `tipo_contrato`, `estado`, `slug`) VALUES
(4, 1, 2, 'Desarrollador Backend Senior', 'Buscamos un desarrollador backend con experiencia en Node.js y bases de datos SQL. Se valora conocimiento en AWS.', '2025-02-18 20:23:32', 1, 'Madrid, España', 'Hibrido', 'Jornada completa', 'Indefinido', 'Activo', 'desarrollador-backend-senior-madrid'),
(5, 1, 2, 'Diseñador UX/UI', 'Oportunidad para un diseñador UX/UI con experiencia en Figma y diseño centrado en el usuario. Trabaja con equipos multidisciplinares.', '2025-02-18 20:23:56', 1, 'Barcelona, España', 'Remoto', 'Jornada completa', 'Indefinido', 'Activo', 'disenador-ux-ui-barcelona');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--
-- Creación: 18-02-2025 a las 17:49:50
-- Última actualización: 19-02-2025 a las 01:06:11
--

CREATE TABLE `usuario` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `cial` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `familia_profesional_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `usuario`:
--   `familia_profesional_id`
--       `familia_profesional` -> `id`
--

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `dni`, `cial`, `email`, `password`, `verificado`, `familia_profesional_id`) VALUES
(1, 'usuario', '11111111A', 'B00000000', 'usuario@usuario.es', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `centro`
--
ALTER TABLE `centro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `familia_profesional`
--
ALTER TABLE `familia_profesional`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `oferta_id` (`oferta_id`);

--
-- Indices de la tabla `oferta_empleo`
--
ALTER TABLE `oferta_empleo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `empresa_id` (`empresa_id`),
  ADD KEY `familia_id` (`familia_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `familia_profesional_id` (`familia_profesional_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `familia_profesional`
--
ALTER TABLE `familia_profesional`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `oferta_empleo`
--
ALTER TABLE `oferta_empleo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`oferta_id`) REFERENCES `oferta_empleo` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `oferta_empleo`
--
ALTER TABLE `oferta_empleo`
  ADD CONSTRAINT `oferta_empleo_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oferta_empleo_ibfk_2` FOREIGN KEY (`familia_id`) REFERENCES `familia_profesional` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`familia_profesional_id`) REFERENCES `familia_profesional` (`id`);
COMMIT;
