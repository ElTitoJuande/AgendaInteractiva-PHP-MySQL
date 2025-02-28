-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2025 a las 09:35:18
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
(32, 'Pablo', 'Duran', '2012-12-12', 1),
(33, 'Antonio', 'Roldan', '1999-01-14', 4),
(34, 'Senior', 'Saenz', '2002-11-16', 1),
(35, 'Pacho', 'Rodriguez', '2003-01-10', 4),
(36, 'Ana', 'Maite', '2004-12-21', 4),
(37, 'Maria', 'Gonzalez', '2001-05-15', 1),
(38, 'Carlos', 'Jimenez', '1998-08-23', 1),
(39, 'Laura', 'Martinez', '2000-03-30', 4),
(40, 'Diego', 'Sanchez', '2002-07-19', 4),
(41, 'Carmen', 'Lopez', '1999-04-25', 4),
(42, 'Manuel', 'Garcia', '2001-09-14', 3),
(43, 'Isabel', 'Fernandez', '2000-06-18', 3),
(44, 'Jorge', 'Torres', '2002-03-22', 3),
(45, 'Lucia', 'Morales', '1998-11-30', 5),
(46, 'Roberto', 'Herrera', '2003-08-05', 5),
(47, 'Elena', 'Castro', '2001-12-11', 1),
(48, 'Miguel', 'Ruiz', '1999-07-28', 1),
(49, 'Sofia', 'Ortiz', '2002-05-15', 3),
(50, 'Daniel', 'Flores', '2000-02-19', 3),
(51, 'Paula', 'Vega', '2003-10-07', 4),
(52, 'Fernando', 'Reyes', '1998-01-16', 4),
(53, 'Andrea', 'Medina', '2001-06-29', 5),
(54, 'Javier', 'Silva', '2002-04-12', 5),
(55, 'Natalia', 'Romero', '2000-09-23', 1),
(56, 'Alejandro', 'Vargas', '1999-12-08', 3),
(57, 'asd', 'asd', '2025-02-28', 1);

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
(6, 'Red Dead Redemption 2', 'PlayStation 4', '2018', 'RedDeadRedemptionII.jpg', 4),
(17, 'Fortnite', 'PC', '2017', 'fortnite.jpg', 1),
(18, 'Minecraft', 'PC', '2009', 'minecraft.jpg', 1),
(19, 'EAFC25', 'PlayStation 4', '2024', 'eafc25.jpg', 1),
(20, 'The Legend of Zelda: Tears of the Kingdom', 'Nintendo Switch', '2023', 'zelda.jpg', 1),
(21, 'God of War', 'PlayStation 4', '2018', 'godOfWar.jpg', 1),
(22, 'Red Dead Redemption 2', 'PlayStation 4', '2018', 'RedDeadRedemptionII.jpg', 1),
(23, 'Fortnite', 'PC', '2017', 'fortnite.jpg', 3),
(24, 'Minecraft', 'PC', '2009', 'minecraft.jpg', 3),
(25, 'EAFC25', 'PlayStation 4', '2024', 'eafc25.jpg', 3),
(26, 'The Legend of Zelda: Tears of the Kingdom', 'Nintendo Switch', '2023', 'zelda.jpg', 3),
(27, 'God of War', 'PlayStation 4', '2018', 'godOfWar.jpg', 3),
(28, 'Red Dead Redemption 2', 'PlayStation 4', '2018', 'RedDeadRedemptionII.jpg', 3),
(29, 'Fortnite', 'PC', '2017', 'fortnite.jpg', 5),
(30, 'Minecraft', 'PC', '2009', 'minecraft.jpg', 5),
(31, 'EAFC25', 'PlayStation 4', '2024', 'eafc25.jpg', 5),
(32, 'The Legend of Zelda: Tears of the Kingdom', 'Nintendo Switch', '2023', 'zelda.jpg', 5),
(33, 'God of War', 'PlayStation 4', '2018', 'godOfWar.jpg', 5),
(34, 'Red Dead Redemption 2', 'PlayStation 4', '2018', 'RedDeadRedemptionII.jpg', 5);

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
(13, 1, 37, 4, '2025-01-20', 0),
(14, 1, 38, 5, '2025-02-01', 1),
(15, 3, 43, 2, '2025-01-10', 0),
(16, 3, 44, 6, '2025-01-25', 1),
(17, 4, 33, 3, '2025-01-15', 1),
(18, 4, 36, 1, '2025-02-05', 1),
(19, 5, 45, 4, '2025-01-30', 0),
(20, 5, 46, 5, '2025-02-10', 1);

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
(3, 'Redouan', '123456', 'usuario'),
(4, 'Fran', '123456', 'usuario'),
(5, 'alexillo', '123456', 'usuario');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
