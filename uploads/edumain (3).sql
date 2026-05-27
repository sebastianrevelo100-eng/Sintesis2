-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2026 a las 19:27:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `edumain`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_clases`
--

CREATE TABLE `alumnos_clases` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `clase_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos_clases`
--

INSERT INTO `alumnos_clases` (`id`, `alumno_id`, `clase_id`) VALUES
(1, 13, 7),
(19, 24, 87),
(20, 26, 87),
(21, 25, 87),
(23, 12, 89),
(24, 12, 91),
(25, 12, 90);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `id` int(11) NOT NULL,
  `clase_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`id`, `clase_id`, `titulo`, `descripcion`, `fecha`) VALUES
(1, 95, 'hola', 'dkfjdkjfkdjdfidsjfishj', '2026-05-20 14:08:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `nombre`, `descripcion`, `profesor_id`, `codigo`) VALUES
(7, '123', '', 13, 'P1GU6D'),
(11, 'holiii:3', 'holaaa', 13, 'FQI0ZH'),
(19, 'Clase del 67', 'bon dia a la meva clase de 67', 20, '7FEG5D'),
(87, 'networking', 'a class about networking', 27, '6RV85J'),
(89, 'M7', '', 13, 'FYDTGB'),
(90, 'M6', '', 13, 'S2MIPR'),
(91, 'M4', '', 13, '4WUJ7Y'),
(92, 'M6', '', 23, '0F7L6Z'),
(93, 'M7', '', 23, 'QX2U3D'),
(94, 'M4', '', 23, 'PJVSCF'),
(95, 'holi', '', 13, '5MONAV'),
(96, 'bots', '', 13, '6HCN5X'),
(98, 'clase 2', '', 13, '0JEOPX'),
(99, 'classe en catala', '', 13, 'RLIVCN'),
(100, 'classe en catala', '', 13, 'BQYUC6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deberes`
--

CREATE TABLE `deberes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_limite` date DEFAULT NULL,
  `creada_por` int(11) DEFAULT NULL,
  `clase_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `deberes`
--

INSERT INTO `deberes` (`id`, `titulo`, `descripcion`, `fecha_limite`, `creada_por`, `clase_id`) VALUES
(2, 'test', 'test', '1111-11-11', 13, 10),
(3, 'hola', 'test', '1111-11-11', 13, 12),
(4, 'Homework 1', 'Homework about networking', '2026-05-15', 27, 87),
(5, 'hola', 'hola', '1111-11-11', 13, 88),
(6, 'test test', 'test', '1111-11-11', 13, 88),
(7, 'titulo de la actividad', 'actividad', '2027-04-11', 13, 96),
(8, 'hola', 'hola', '1111-11-11', 13, 89);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `id_deberes` int(11) DEFAULT NULL,
  `id_alumno` int(11) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `archivo_nombre` varchar(255) DEFAULT NULL,
  `archivo_contenido` longblob DEFAULT NULL,
  `archivo_tipo` varchar(100) DEFAULT NULL,
  `nota` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO `entregas` (`id`, `id_deberes`, `id_alumno`, `archivo`, `fecha_entrega`, `archivo_nombre`, `archivo_contenido`, `archivo_tipo`, `nota`) VALUES
(5, 3, 13, NULL, '2026-05-13 19:00:19', 'image-Photoroom (4) (3).png', 0x2e2e2f75706c6f6164732f696d6167652d50686f746f726f6f6d20283429202833292e706e67, 'image/png', NULL),
(6, 5, 12, NULL, '2026-05-13 21:13:20', 'edumain (1).sql', 0x2e2e2f75706c6f6164732f6564756d61696e202831292e73716c, 'application/octet-stream', 6.70),
(8, 8, 12, NULL, '2026-05-20 13:58:51', 'e44e6974158b903489f36d90d157caab.png', 0x2e2e2f75706c6f6164732f65343465363937343135386239303334383966333664393064313537636161622e706e67, 'image/png', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('alumno','profesor') NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `cookies` varchar(30) DEFAULT NULL,
  `horaCookies` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contraseña`, `rol`, `foto_perfil`, `cookies`, `horaCookies`) VALUES
(12, 'alumne', 'alum@gmail.com', 'hola', 'alumno', NULL, 'aceptar', '2026-05-27 13:28:48'),
(13, 'Profe', 'Profe@gmail.com', '123', 'profesor', NULL, 'aceptar', '2026-05-18 16:18:56'),
(20, 'ismael', 'ismael6o7@insestatut.cat', 'ismael10', 'profesor', NULL, 'Aceptar', NULL),
(21, 'prova', 'prova@gmail.com', '123', 'alumno', NULL, 'Aceptar', '2026-05-08 17:22:15'),
(22, 'oriol', 'oriol67@gmail.com', 'nigga', 'profesor', NULL, NULL, NULL),
(23, 'oriol', 'oriol2@gmail.com', '123', 'profesor', NULL, NULL, NULL),
(24, 'Dani Lleonart', 'danilleonart@gmail.com', '123', 'alumno', NULL, NULL, NULL),
(25, 'Josep Carrera', 'pepcarrera@gmail.com', '123', 'alumno', NULL, NULL, NULL),
(26, 'David Cornella', 'davidcornella@gmail.com', '123', 'alumno', NULL, NULL, NULL),
(27, 'professor', 'professor@gmail.com', '123', 'profesor', NULL, NULL, NULL),
(28, 'dani', 'dani@gmail.com', '123', 'profesor', NULL, NULL, NULL),
(29, 'family', 'family@gmail.com', '123', 'alumno', NULL, 'rechazar', '2026-05-19 22:13:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos_clases`
--
ALTER TABLE `alumnos_clases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumno_id` (`alumno_id`),
  ADD KEY `curso_id` (`clase_id`);

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clase_id` (`clase_id`);

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `profesor_id` (`profesor_id`);

--
-- Indices de la tabla `deberes`
--
ALTER TABLE `deberes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_deberes` (`id_deberes`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos_clases`
--
ALTER TABLE `alumnos_clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `deberes`
--
ALTER TABLE `deberes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos_clases`
--
ALTER TABLE `alumnos_clases`
  ADD CONSTRAINT `alumnos_clases_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `alumnos_clases_ibfk_2` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`);

--
-- Filtros para la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`);

--
-- Filtros para la tabla `clases`
--
ALTER TABLE `clases`
  ADD CONSTRAINT `clases_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `entregas_ibfk_1` FOREIGN KEY (`id_deberes`) REFERENCES `deberes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
