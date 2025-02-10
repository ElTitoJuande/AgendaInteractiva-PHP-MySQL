-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-02-2025 a las 13:01:21
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agenda_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

CREATE TABLE `amigos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `fecha_nac` date NOT NULL,
  `usuario` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`id`, `nombre`, `apellidos`, `fecha_nac`, `usuario`) VALUES
(1, 'bbb', 'bbb', '2012-12-12', 1),
(2, 'Antonio', 'Roldan', '1999-01-14', 4),
(3, 'Senior', 'Saenz', '2002-11-16', 1),
(4, 'Pacho', 'Rodriguez', '2003-01-10', 4),
(5, 'Ana', 'Maite', '2004-12-21', 4),
(6, 'Alejandro', 'Aguayo', '2002-10-14', 6),
(7, 'Fernando', 'Benitez', '2001-03-20', 4),
(8, 'Aaaaaaaaaa', 'asdfasdf', '2025-02-03', 4),
(9, 'Angel', 'Arevalo', '2011-11-11', 3),
(10, 'Angel', 'ElOreon', '2011-11-11', 4),
(15, 'Alexiillo', 'tutupa', '2011-11-11', 1),
(16, 'asdfasdfasdf', 'fdasfada', '2012-12-12', 3),
(17, 'gggggggggggg', 'gg', '2012-12-12', 3),
(18, 'Papote', 'Gaspar', '1939-09-10', 3),
(19, 'Papote', 'Gaspar', '1939-09-10', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `plataforma` varchar(100) NOT NULL,
  `lanzamiento` year(4) NOT NULL,
  `img` varchar(250) NOT NULL,
  `usuario` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `titulo`, `plataforma`, `lanzamiento`, `img`, `usuario`) VALUES
(1, 'Fortnite', 'PC', '2017', 'fortnite.jpg', 4),
(2, 'Minecraft', 'PC', '2009', 'minecraft.jpg', 4),
(3, 'EAFC25', 'PlayStation 4', '2024', 'eafc25.jpg', 4),
(4, 'The Legend of Zelda: Tears of the Kingdom', 'Nintendo Switch', '2023', 'zelda.jpg', 4),
(5, 'God of War', 'PlayStation 4', '2018', 'godOfWar.jpg', 4),
(6, 'Red Dead Redemption 2', 'PlayStation 4', '2018', 'rdr2.jpg', 4),
(12, 'asdf', 'pc', '2025', 'AnotaciÃ³n 2025-02-10 111601.png', 4),
(13, 'asdf', 'pc', '2024', 'AnotaciÃ³n 2025-02-10 111601.png', 4),
(14, 'asdf', 'pc', '2000', 'AnotaciÃ³n 2025-02-10 111601.png', 4),
(15, 'fdas', 'PLayStation4', '2001', 'logo1.png', 4),
(16, 'asdfaasdf', 'pc', '2011', 'logo1.png', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario` bigint(20) UNSIGNED NOT NULL,
  `amigo` bigint(20) UNSIGNED NOT NULL,
  `juego` bigint(20) UNSIGNED NOT NULL,
  `fecha_prestamo` date NOT NULL,
  `devuelto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `usuario`, `amigo`, `juego`, `fecha_prestamo`, `devuelto`) VALUES
(1, 1, 1, 1, '2025-01-02', 0),
(2, 1, 3, 3, '2025-01-15', 1),
(3, 4, 4, 2, '2001-11-11', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contrasena` varchar(20) NOT NULL,
  `tipo` set('admin','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasena`, `tipo`) VALUES
(1, 'Erica', '123456', 'usuario'),
(2, 'Juande', '123456', 'admin'),
(3, 'Redouan', '123465', 'usuario'),
(4, 'Fran', '123456', 'usuario'),
(5, 'alexillo', 'tutu', 'usuario'),
(6, 'Papote Gaspote', '123456', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_amigo_usuario` (`usuario`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_juego_usuario` (`usuario`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_prestamo_usuario` (`usuario`),
  ADD KEY `fk_prestamo_amigo` (`amigo`),
  ADD KEY `fk_prestamo_juego` (`juego`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amigos`
--
ALTER TABLE `amigos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD CONSTRAINT `fk_amigo_usuarios` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `fk_juego_usuarios` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_prestamo_amigos` FOREIGN KEY (`amigo`) REFERENCES `amigos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prestamo_juegos` FOREIGN KEY (`juego`) REFERENCES `juegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prestamo_usuarios` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
