-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-02-2025 a las 00:52:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `sagasetaconecta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--
-- Creación: 18-02-2025 a las 17:49:50
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
-- Última actualización: 20-02-2025 a las 20:42:46
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
(2, 'Tech Solutions', 'B23456789', 'contacto@techsolutions.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 1),
(3, 'Construcciones Martínez', 'C34567890', 'info@construccionesmartinez.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 0),
(4, 'Moda Elegante', 'D45678901', 'ventas@modaelegante.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 1),
(5, 'Green Energy S.A.', 'E56789012', 'info@greenenergy.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 1),
(6, 'Logística Rápida', 'F67890123', 'soporte@logisticarapida.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 0),
(7, 'Consultores Financieros Global', 'G78901234', 'contacto@cfg.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 1),
(8, 'Innovate AI', 'H89012345', 'hello@innovateai.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 1),
(9, 'Delicias Gourmet', 'I90123456', 'ventas@deliciasgourmet.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 0),
(10, 'Academia de Idiomas Babel', 'J01234567', 'admin@babelidiomas.com', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia_profesional`
--
-- Creación: 18-02-2025 a las 17:49:50
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
-- Última actualización: 20-02-2025 a las 20:42:40
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
-- Última actualización: 20-02-2025 a las 20:55:54
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
(23, 2, 2, 'Desarrollador Backend Java', 'Se busca desarrollador backend con experiencia en Java y Spring Boot para unirse a equipo en expansión.', '2025-02-21 08:00:00', 1, 'Madrid, España', 'Hibrido', 'Jornada completa', 'Indefinido', 'Activo', 'desarrollador-backend-java-madrid'),
(24, 4, 1, 'Asesor de Estilo', 'Empresa de moda busca asesor de estilo con experiencia en personal shopper y asesoramiento de imagen.', '2025-02-22 09:30:00', 1, 'Barcelona, España', 'Presencial', 'Jornada parcial', 'Temporal', 'Activo', 'asesor-estilo-barcelona'),
(25, 5, 3, 'Técnico de Energía Solar', 'Se requiere técnico con experiencia en instalación de paneles solares y mantenimiento de sistemas solares.', '2025-02-23 14:45:00', 1, 'Valencia, España', 'Presencial', 'Jornada completa', 'Indefinido', 'Activo', 'tecnico-energia-solar-valencia'),
(26, 7, 2, 'Consultor Financiero', 'Buscamos consultor financiero con experiencia en planificación financiera para empresas.', '2025-02-24 16:30:00', 1, 'Madrid, España', 'Remoto', 'Jornada completa', 'Indefinido', 'Activo', 'consultor-financiero-madrid'),
(27, 8, 2, 'Ingeniero de IA', 'Innovate AI busca ingeniero de inteligencia artificial con experiencia en Deep Learning y redes neuronales.', '2025-02-25 11:00:00', 1, 'Barcelona, España', 'Remoto', 'Jornada completa', 'Indefinido', 'Activo', 'ingeniero-ia-barcelona'),
(28, 10, 1, 'Profesor de Inglés', 'Academia de idiomas busca profesor de inglés con experiencia en clases online y presencial.', '2025-02-26 13:00:00', 1, 'Online', 'Remoto', 'Jornada parcial', 'Temporal', 'Activo', 'profesor-ingles-online'),
(29, 2, 3, 'Project Manager IT', 'Empresa tecnológica busca Project Manager con experiencia en la gestión de proyectos de desarrollo software.', '2025-02-25 20:53:21', 1, 'Madrid, España', 'Hibrido', 'Jornada completa', 'Indefinido', 'Activo', 'project-manager-it-madrid'),
(30, 4, 1, 'Community Manager', 'Empresa de moda busca Community Manager con experiencia en gestión de redes sociales y estrategias digitales.', '2025-02-25 20:53:21', 1, 'Barcelona, España', 'Presencial', 'Jornada completa', 'Indefinido', 'Activo', 'community-manager-barcelona'),
(31, 5, 3, 'Ingeniero de Energía Eólica', 'Green Energy S.A. busca ingeniero con experiencia en proyectos de energía eólica y gestión de parques eólicos.', '2025-02-25 20:53:21', 1, 'Alicante, España', 'Presencial', 'Jornada completa', 'Indefinido', 'Activo', 'ingeniero-energia-eolica-alicante'),
(32, 7, 2, 'Asesor Financiero Corporativo', 'Consultores Financieros Global busca asesor financiero para trabajar con empresas de gran envergadura en estrategias de inversión.', '2025-02-25 20:53:21', 1, 'Madrid, España', 'Remoto', 'Jornada completa', 'Indefinido', 'Activo', 'asesor-financiero-corporativo-madrid'),
(33, 8, 2, 'Data Scientist', 'Innovate AI busca Data Scientist con experiencia en modelos predictivos y análisis de grandes volúmenes de datos.', '2025-02-25 20:53:21', 1, 'Barcelona, España', 'Remoto', 'Jornada completa', 'Indefinido', 'Activo', 'data-scientist-barcelona'),
(34, 10, 1, 'Profesor de Francés', 'Academia de Idiomas Babel busca profesor de francés con experiencia en clases online y presenciales.', '2025-02-25 20:53:21', 1, 'Online', 'Remoto', 'Jornada parcial', 'Temporal', 'Activo', 'profesor-frances-online');

--
-- Disparadores `oferta_empleo`
--
DELIMITER $$
CREATE TRIGGER `before_insert_oferta` BEFORE INSERT ON `oferta_empleo` FOR EACH ROW BEGIN
    DECLARE empresa_verificada INT;
    
    SELECT `verificado` INTO empresa_verificada
    FROM `empresa`
    WHERE `id` = NEW.`empresa_id`;

    IF empresa_verificada <> 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Solo empresas verificadas pueden publicar ofertas';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--
-- Creación: 18-02-2025 a las 17:49:50
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
(1, 'usuario', '11111111A', 'B00000000', 'usuario@usuario.es', '$2a$12$gaw9NLtfd2Izhih54Jkp0uIlZj8fTFn5Y/LNCSsRXhIIDsw68cujC', 1, 2),
(2, 'aileen', '49405692J', 'B0999323J', 'aileenpadrontorres511@gmail.com', '$2y$10$/HdfwYw3y08QBDOzERIqRumVTeLzzMZsR6jddlCB36/wrnga5MSqy', 0, 2);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `familia_profesional`
--
ALTER TABLE `familia_profesional`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `oferta_empleo`
--
ALTER TABLE `oferta_empleo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
