-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2026 a las 18:52:18
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
(2, 12, 7),
(3, 12, 7),
(4, 12, 7),
(5, 12, 7),
(6, 12, 7),
(7, 12, 7),
(8, 12, 7),
(9, 12, 7),
(10, 12, 7),
(11, 12, 7),
(12, 12, 7),
(13, 12, 7),
(14, 12, 18),
(15, 25, 18),
(16, 24, 18),
(17, 26, 18),
(19, 24, 87),
(20, 26, 87),
(21, 25, 87);

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
(8, '1234', 'holiii', 13, 'S80VC4'),
(10, '12345', 'holii', 13, 'WM0B63'),
(11, 'holiii:3', 'holaaa', 13, 'FQI0ZH'),
(12, 'test', 'holii', 13, '6AL8Q7'),
(18, 'Clase Nueva', 'una nueva clase', 13, 'R4DL9O'),
(19, 'Clase del 67', 'bon dia a la meva clase de 67', 20, '7FEG5D'),
(87, 'networking', 'a class about networking', 27, '6RV85J');

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
(1, 'test_1', 'hola', '2067-04-11', 13, 18),
(2, 'test', 'test', '1111-11-11', 13, 10),
(3, 'hola', 'test', '1111-11-11', 13, 12),
(4, 'Homework 1', 'Homework about networking', '2026-05-15', 27, 87);

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
  `archivo_tipo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO `entregas` (`id`, `id_deberes`, `id_alumno`, `archivo`, `fecha_entrega`, `archivo_nombre`, `archivo_contenido`, `archivo_tipo`) VALUES
(1, 1, 12, NULL, '2026-05-08 15:44:15', 'fat-bee-playing-violin-fat-bee.gif', NULL, 'image/gif'),
(2, 1, 12, NULL, '2026-05-08 17:53:19', 'fat-bee-playing-violin-fat-bee.gif', NULL, 'image/gif'),
(3, 1, 12, NULL, '2026-05-13 12:14:38', 'pngtree-cat-peeking-from-frame-png-image_14067902.png', NULL, 'image/png'),
(4, 1, 12, NULL, '2026-05-13 12:17:06', 'logo.png', 0x2e2e2f75706c6f6164732f6c6f676f2e706e67, 'image/png');

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
(12, 'alum', 'alum@gmail.com', '123', 'alumno', NULL, 'Aceptar esenciales', '2026-05-08 17:16:07'),
(13, 'Profe', 'Profe@gmail.com', '123', 'profesor', NULL, 'Aceptar', '2026-05-13 15:28:01'),
(20, 'ismael', 'ismael6o7@insestatut.cat', 'ismael10', 'profesor', NULL, 'Aceptar', NULL),
(21, 'prova', 'prova@gmail.com', '123', 'alumno', NULL, 'Aceptar', '2026-05-08 17:22:15'),
(22, 'oriol', 'oriol67@gmail.com', 'nigga', 'profesor', NULL, NULL, NULL),
(23, 'oriol', 'oriol2@gmail.com', '123', 'profesor', NULL, NULL, NULL),
(24, 'Dani Lleonart', 'danilleonart@gmail.com', '123', 'alumno', NULL, NULL, NULL),
(25, 'Josep Carrera', 'pepcarrera@gmail.com', '123', 'alumno', NULL, NULL, NULL),
(26, 'David Cornella', 'davidcornella@gmail.com', '123', 'alumno', NULL, NULL, NULL),
(27, 'professor', 'professor@gmail.com', '123', 'profesor', NULL, NULL, NULL),
(28, 'dani', 'dani@gmail.com', '123', 'profesor', NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `deberes`
--
ALTER TABLE `deberes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
