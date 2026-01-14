-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 01:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prevenirsalud`
--

-- --------------------------------------------------------

--
-- Table structure for table `aaaa`
--

CREATE TABLE `aaaa` (
  `id` int(11) NOT NULL,
  `examen_id` int(11) DEFAULT NULL,
  `pregunta` text NOT NULL,
  `tipo` enum('texto','opcion_multiple','verdadero_falso') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examenes`
--

CREATE TABLE `examenes` (
  `id` int(11) NOT NULL,
  `nombre_examen` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'inactivo',
  `creado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examenes`
--

INSERT INTO `examenes` (`id`, `nombre_examen`, `descripcion`, `estado`, `creado_por`) VALUES
(1, 'EPQ', 'Cuestionario de Personalidad', 'activo', NULL),
(2, 'Epworth', 'aaa', 'inactivo', NULL),
(3, 'Barrat', 'aaaa', 'inactivo', NULL),
(4, 'PRP', '', 'inactivo', NULL),
(5, 'Pittsburgh', 'Calidad de sueño', 'activo', 23),
(6, 'Hamilton', 'Severidad de ansiedad', 'activo', 23),
(7, 'Barsit', 'Test de Inteligencia', 'activo', 23);

-- --------------------------------------------------------

--
-- Table structure for table `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `respuesta` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `respuestas`
--

INSERT INTO `respuestas` (`id`, `usuario_id`, `examen_id`, `respuesta`, `fecha`) VALUES
(1, 54, 2, 11, '2025-04-03 19:28:03'),
(2, 55, 6, 0, '2025-04-03 20:03:44'),
(3, 56, 6, 9, '2025-04-03 20:38:53'),
(4, 56, 2, 1, '2025-04-03 20:51:07'),
(6, 55, 2, 0, '2025-04-03 20:59:20'),
(7, 57, 2, 2, '2025-04-04 10:11:37'),
(8, 57, 6, 0, '2025-04-04 10:12:56');

-- --------------------------------------------------------

--
-- Table structure for table `respuestas_clave`
--

CREATE TABLE `respuestas_clave` (
  `id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `respuesta_esperada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `respuestas_clave`
--

INSERT INTO `respuestas_clave` (`id`, `examen_id`, `pregunta_id`, `respuesta_esperada`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 0),
(3, 1, 3, 0),
(4, 1, 4, 0),
(5, 1, 5, 0),
(6, 1, 6, 0),
(7, 1, 7, 0),
(8, 1, 8, 0),
(9, 3, 9, 0),
(10, 3, 10, 0),
(11, 3, 11, 0),
(12, 3, 12, 0),
(13, 3, 13, 0),
(14, 3, 14, 0),
(15, 3, 15, 0),
(16, 3, 16, 0),
(17, 3, 17, 0),
(18, 3, 18, 0),
(19, 3, 19, 0),
(20, 3, 20, 0),
(21, 3, 21, 0),
(22, 3, 22, 0),
(23, 3, 23, 0),
(24, 3, 24, 0),
(25, 3, 25, 0),
(26, 3, 26, 0),
(27, 3, 27, 0),
(28, 3, 28, 0),
(29, 3, 29, 0),
(30, 3, 30, 0),
(31, 3, 31, 0),
(32, 3, 32, 0),
(33, 3, 33, 0),
(34, 3, 34, 0),
(35, 3, 35, 0),
(36, 3, 36, 0),
(37, 3, 37, 0),
(38, 3, 38, 0);

-- --------------------------------------------------------

--
-- Table structure for table `respuestas_paciente`
--

CREATE TABLE `respuestas_paciente` (
  `id` int(11) NOT NULL,
  `resultado_id` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `respuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `respuestas_paciente`
--

INSERT INTO `respuestas_paciente` (`id`, `resultado_id`, `pregunta_id`, `respuesta`) VALUES
(27, 6, 1, 2),
(28, 6, 2, 1),
(29, 6, 3, 1),
(30, 6, 4, 2),
(31, 6, 5, 0),
(32, 6, 6, 3),
(33, 6, 7, 1),
(34, 6, 8, 1),
(35, 7, 1, 1),
(36, 7, 2, 0),
(37, 7, 3, 0),
(38, 7, 4, 0),
(39, 7, 5, 0),
(40, 7, 6, 0),
(41, 7, 7, 0),
(42, 7, 8, 0),
(43, 8, 1, 2),
(44, 8, 2, 0),
(45, 8, 3, 3),
(46, 8, 4, 0),
(47, 8, 5, 0),
(48, 8, 6, 0),
(49, 8, 7, 0),
(50, 8, 8, 3),
(51, 9, 1, 0),
(52, 9, 2, 0),
(53, 9, 3, 0),
(54, 9, 4, 0),
(55, 9, 5, 0),
(56, 9, 6, 0),
(57, 9, 7, 0),
(58, 9, 8, 0),
(59, 10, 1, 0),
(60, 10, 2, 0),
(61, 10, 3, 0),
(62, 10, 4, 0),
(63, 10, 5, 0),
(64, 10, 6, 0),
(65, 10, 7, 0),
(66, 10, 8, 3),
(67, 11, 1, 2),
(68, 11, 2, 1),
(69, 11, 3, 0),
(70, 11, 4, 0),
(71, 11, 5, 0),
(72, 11, 6, 0),
(73, 11, 7, 0),
(74, 11, 8, 0),
(75, 12, 1, 0),
(76, 12, 2, 0),
(77, 12, 3, 0),
(78, 12, 4, 0),
(79, 12, 5, 0),
(80, 12, 6, 0),
(81, 12, 7, 0),
(82, 12, 8, 0),
(83, 13, 1, 2),
(84, 13, 2, 1),
(85, 13, 3, 3),
(86, 13, 4, 2),
(87, 13, 5, 0),
(88, 13, 6, 0),
(89, 13, 7, 0),
(90, 13, 8, 0),
(122, 21, 1, 2),
(123, 21, 2, 1),
(124, 21, 3, 3),
(125, 21, 4, 1),
(126, 21, 5, 0),
(127, 21, 6, 0),
(128, 21, 7, 0),
(129, 21, 8, 0),
(130, 22, 1, 2),
(131, 22, 2, 1),
(132, 22, 3, 0),
(133, 22, 4, 0),
(134, 22, 5, 0),
(135, 22, 6, 0),
(136, 22, 7, 0),
(137, 22, 8, 0),
(138, 23, 1, 0),
(139, 23, 2, 0),
(140, 23, 3, 0),
(141, 23, 4, 0),
(142, 23, 5, 0),
(143, 23, 6, 0),
(144, 23, 7, 0),
(145, 23, 8, 0),
(146, 25, 1, 3),
(147, 25, 2, 1),
(148, 25, 3, 1),
(149, 25, 4, 3),
(150, 25, 5, 3),
(151, 25, 6, 1),
(152, 25, 7, 0),
(153, 25, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `resultados`
--

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `nombre_paciente` varchar(255) NOT NULL,
  `edad` int(11) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resultados`
--

INSERT INTO `resultados` (`id`, `examen_id`, `nombre_paciente`, `edad`, `genero`, `fecha`, `usuario_id`) VALUES
(4, 1, 'Sebastian Grez', 24, 'Masculino', '2025-03-17 20:03:53', NULL),
(5, 1, 'Sebastian Grez', 24, 'Masculino', '2025-03-17 20:05:51', NULL),
(6, 1, 'Sebastian Grez', 24, 'Masculino', '2025-03-17 20:11:44', NULL),
(7, 1, 'Carlito Vera', 21, 'Masculino', '2025-03-17 20:51:37', NULL),
(8, 1, 'Juan Chapa', 34, 'Masculino', '2025-03-18 12:45:48', NULL),
(9, 1, 'Carlito Vera', 21, 'Masculino', '2025-03-19 22:58:32', NULL),
(10, 1, 'Carlito Vera', 21, 'Masculino', '2025-03-19 23:03:06', NULL),
(11, 1, 'jugar', 24, 'Masculino', '2025-03-19 23:05:35', NULL),
(12, 1, 'Coso', 24, 'Masculino', '2025-03-19 23:18:13', NULL),
(13, 3, 'Neyen', 23, 'Femenino', '2025-03-26 20:13:33', NULL),
(14, 3, 'Neyen', 23, 'Femenino', '2025-03-26 20:24:36', NULL),
(15, 3, 'Neyen', 23, 'Masculino', '2025-03-26 20:31:57', NULL),
(16, 3, 'Neyen', 23, 'Femenino', '2025-03-26 20:32:11', NULL),
(21, 1, 'Sebastian Grez', 24, 'Masculino', '2025-03-28 15:57:15', NULL),
(22, 1, 'Sebastian Grez', 24, 'Masculino', '2025-03-28 16:36:29', NULL),
(23, 2, 'Sebastian Grez', 24, 'Masculino', '2025-03-28 16:39:15', NULL),
(24, 1, 'Sebastian Grez', 24, 'Masculino', '2025-03-28 17:03:38', NULL),
(25, 2, 'Sebastian Grez', 24, 'Masculino', '2025-03-28 17:09:26', NULL),
(27, 2, 'hola', 24, 'Masculino', '2025-04-03 22:28:03', 54),
(29, 6, '204053014', 24, 'Masculino', '2025-04-03 23:03:44', 55),
(30, 6, '204053014', 24, 'Masculino', '2025-04-03 23:38:53', 56),
(31, 2, 'hola', 24, 'Masculino', '2025-04-03 23:51:07', 56),
(35, 6, '204053014', 24, 'Masculino', '2025-04-04 13:12:56', 57);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `ot` varchar(15) NOT NULL,
  `password` varchar(61) DEFAULT NULL,
  `rol` enum('usuario','psicologo') NOT NULL,
  `examen_asignado` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `ot`, `password`, `rol`, `examen_asignado`, `fecha_registro`) VALUES
(23, 'Sebastian Grez', '000000', '$2y$10$oAc5lg.3OK.fIjNlVVscleP3KE09I0kO24I.bKY.dCaZS4RoV9vBK', 'psicologo', 1, '2025-03-03 17:30:16'),
(27, 'alo', '1', '$2y$10$cPkOTgfL71RxNErCz6ErA.Y2P.XlSv9qvUISlyyVS3Tccv7Pwstpe', 'usuario', NULL, '2025-03-03 17:35:54'),
(37, 'Sebastian', '111111', '$2y$10$eRFLhcbz2107Q4SFacTGOeJotmMsuZOyqaN1vufBowKwOHKyYD5Ty', 'psicologo', NULL, '2025-03-12 22:46:54'),
(41, 'Prueba', '3', '$2y$10$GhaavkEqHVm88BQHPw62kevkgg49IVXcFsnb/AkKkZC4YfstC4Bce', 'usuario', NULL, '2025-03-12 22:55:34'),
(42, 'Prueba', '1', '$2y$10$JH4CqdS8KgVKSY/9ZlDi5ef7pgDahmyOU1ZjM3C1fj2GszelvgA3a', 'usuario', NULL, '2025-03-15 19:40:34'),
(43, 'Prueba', '2', '$2y$10$t8uv9QoaaGTo/aaSBSXEFOr/QX2GyTBTq7xu7VzJy41lbR8dI8JsS', 'usuario', NULL, '2025-03-15 19:43:06'),
(44, 'hola', '666666', '$2y$10$jqFsm0u6hbm4mX1g4MdD9.sKWbDzHRZ73qYDfNHpLP7C2hZ2UDhA.', 'usuario', NULL, '2025-03-15 20:00:41'),
(45, 'Sebastian Grez', '333333', '$2y$10$g/Ut4ncHxW2vP.vmKbVCBer6y7GjRGA6QOn0vm71qmqImv5ungPyG', 'usuario', NULL, '2025-03-17 00:01:44'),
(46, 'Carlito Vera', '23', '$2y$10$FbuGFVkG/WvSIg1K5nhHSOXWYzSsqmMnLV9hTQQ7rQy6rfSkOAmzu', 'usuario', NULL, '2025-03-17 17:50:15'),
(47, 'Juan Chapa', '123321', '$2y$10$tDS3hEOIJV8nK3QHvyox4e4YBaozN2jCuRefwa/G2O8hdhexXdGd.', 'usuario', NULL, '2025-03-18 09:44:39'),
(48, 'Sebastian Grez', '1', '$2y$10$p1Ie3Q/DYwygya9FAgzkvucrsQtHIIDUe2.soMaFJuCx.gQR9/guy', 'usuario', NULL, '2025-03-19 19:37:48'),
(49, 'jugar', '223', '$2y$10$MN9PnVncwpjeaPMCz3NisukfsyO.5BVa83JrwFhFjGNgTyaSOYYRG', 'usuario', NULL, '2025-03-19 20:05:19'),
(50, 'Neyen', '123941', '$2y$10$oIGxwd5QKt5l41lx.UP7Ou9KUn6cK0DyedkAPYQoQQKtLktApGfuC', 'usuario', NULL, '2025-03-26 16:58:56'),
(51, 'Sebastian', '1233333', '$2y$10$a8pshL5VLqcC4MZ8LSmpsuvvrQ/81Uc/exF3my5cxuGY4ExT25IwC', 'usuario', NULL, '2025-03-28 12:42:43'),
(52, 'Sebastian', '1233334', '$2y$10$VLX/biK53CslalFHCpa/1eKSo7zhMEB19h6QrM7es.bhnc8dUVESu', 'usuario', NULL, '2025-03-28 12:55:27'),
(53, 'Matías Ruiz', '333334', NULL, 'psicologo', NULL, '2025-04-02 18:24:22'),
(54, 'hola', '4', '$2y$10$69wNGs4av/yBoOdUflIGLOFMfDCz5ka7E8oyWqjd0W9bob6jSkUFK', 'usuario', NULL, '2025-04-02 18:40:00'),
(55, 'hola', '5', '$2y$10$z7GL1XQWWh3g3UA/ZjUxru5nl5jbv5b0yEHYe3KkVwdtydc6L./.O', 'usuario', NULL, '2025-04-03 19:50:52'),
(56, 'hola', '6', '$2y$10$J.9tuyC.E38zUVO8ZMR5UuIVf7M5FjHeuHs.lB7crvfVTw1y4Zz96', 'usuario', NULL, '2025-04-03 20:15:21'),
(57, 'hola', '7', '$2y$10$qKjLXTxSMBGX7AajW8XeoehCm/joRffw1d2DxMk1ix.rXTgyQOKs6', 'usuario', NULL, '2025-04-04 10:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `usuario_examen`
--

CREATE TABLE `usuario_examen` (
  `usuario_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `completado` tinyint(1) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario_examen`
--

INSERT INTO `usuario_examen` (`usuario_id`, `examen_id`, `completado`, `activo`) VALUES
(41, 1, 0, 1),
(41, 2, 0, 1),
(41, 3, 0, 1),
(41, 4, 0, 1),
(41, 5, 0, 1),
(42, 1, 0, 1),
(42, 2, 0, 1),
(42, 3, 0, 1),
(42, 4, 0, 1),
(43, 1, 0, 1),
(43, 2, 0, 1),
(43, 3, 0, 1),
(44, 1, 0, 1),
(44, 2, 0, 1),
(44, 3, 0, 1),
(45, 1, 0, 1),
(45, 2, 0, 1),
(45, 3, 0, 1),
(45, 4, 0, 1),
(45, 5, 0, 1),
(46, 2, 0, 1),
(46, 3, 0, 1),
(47, 1, 0, 1),
(47, 2, 0, 1),
(47, 3, 0, 1),
(47, 5, 0, 1),
(48, 1, 0, 1),
(48, 3, 0, 1),
(49, 1, 1, 1),
(49, 2, 0, 1),
(50, 1, 0, 1),
(50, 2, 0, 1),
(50, 3, 0, 1),
(50, 4, 0, 1),
(50, 5, 0, 1),
(51, 1, 1, 1),
(51, 2, 1, 1),
(51, 3, 0, 1),
(51, 4, 0, 1),
(51, 5, 0, 1),
(51, 6, 0, 1),
(52, 1, 1, 1),
(52, 2, 1, 1),
(54, 2, 1, 1),
(55, 2, 0, 1),
(55, 6, 1, 1),
(56, 2, 1, 1),
(56, 6, 1, 1),
(57, 2, 0, 1),
(57, 6, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aaaa`
--
ALTER TABLE `aaaa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indexes for table `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creado_por` (`creado_por`);

--
-- Indexes for table `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indexes for table `respuestas_clave`
--
ALTER TABLE `respuestas_clave`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pregunta_id` (`pregunta_id`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indexes for table `respuestas_paciente`
--
ALTER TABLE `respuestas_paciente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resultado_id` (`resultado_id`),
  ADD KEY `pregunta_id` (`pregunta_id`);

--
-- Indexes for table `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario_examen`
--
ALTER TABLE `usuario_examen`
  ADD PRIMARY KEY (`usuario_id`,`examen_id`),
  ADD KEY `examen_id` (`examen_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aaaa`
--
ALTER TABLE `aaaa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examenes`
--
ALTER TABLE `examenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `respuestas_clave`
--
ALTER TABLE `respuestas_clave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `respuestas_paciente`
--
ALTER TABLE `respuestas_paciente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `resultados`
--
ALTER TABLE `resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aaaa`
--
ALTER TABLE `aaaa`
  ADD CONSTRAINT `aaaa_ibfk_1` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `examenes`
--
ALTER TABLE `examenes`
  ADD CONSTRAINT `examenes_ibfk_1` FOREIGN KEY (`creado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`);

--
-- Constraints for table `respuestas_clave`
--
ALTER TABLE `respuestas_clave`
  ADD CONSTRAINT `respuestas_clave_ibfk_1` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`);

--
-- Constraints for table `respuestas_paciente`
--
ALTER TABLE `respuestas_paciente`
  ADD CONSTRAINT `respuestas_paciente_ibfk_1` FOREIGN KEY (`resultado_id`) REFERENCES `resultados` (`id`),
  ADD CONSTRAINT `respuestas_paciente_ibfk_2` FOREIGN KEY (`pregunta_id`) REFERENCES `respuestas_clave` (`pregunta_id`);

--
-- Constraints for table `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`);

--
-- Constraints for table `usuario_examen`
--
ALTER TABLE `usuario_examen`
  ADD CONSTRAINT `usuario_examen_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `usuario_examen_ibfk_2` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
