-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-05-2026 a las 20:12:20
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
-- Base de datos: `gestio_empleats`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleats`
--

CREATE TABLE `empleats` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `cognoms` varchar(150) NOT NULL,
  `departament` varchar(100) NOT NULL,
  `salari` decimal(8,2) NOT NULL,
  `data_alta` date NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleats`
--

INSERT INTO `empleats` (`id`, `nom`, `cognoms`, `departament`, `salari`, `data_alta`, `email`) VALUES
(1, 'Maria', 'García López', 'Recursos Humans', 2800.00, '2022-03-15', 'maria.garcia@empresa.com'),
(2, 'Pere', 'Martínez Soler', 'Informàtica', 3200.00, '2021-07-01', 'pere.martinez@empresa.com'),
(3, 'Anna', 'Fernández Gil', 'Comptabilitat', 2600.00, '2023-01-10', 'anna.fernandez@empresa.com'),
(4, 'Jordi', 'López Puig', 'Vendes', 2400.00, '2022-11-20', 'jordi.lopez@empresa.com'),
(5, 'Laura', 'Sánchez Vidal', 'Informàtica', 3100.00, '2020-05-05', 'laura.sanchez@empresa.com'),
(6, 'Radi', 'Radoslavov Atanasov', 'Informàtica', 5000.00, '2026-04-27', 'radoslavradoslavovatanasov@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuaris`
--

CREATE TABLE `usuaris` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuaris`
--

INSERT INTO `usuaris` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$P6ss6y9YUQ3WxsSzrGn4VOyHNaezKB/NofIj7OGnEh6zoRVynHHWK');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleats`
--
ALTER TABLE `empleats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleats`
--
ALTER TABLE `empleats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
