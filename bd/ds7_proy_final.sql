-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2022 a las 03:15:27
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ds7_proy_final`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crear_orden` (IN `_numero` INT(5), IN `_id_cliente` INT(5), IN `_texto` TEXT, IN `_id_estado` INT(5), IN `_fecha` DATE)   INSERT INTO ordenes(numero, id_cliente, texto, id_estado, fecha_entrega )
VALUES(cast(_numero as int), _id_cliente, _texto, _id_estado, _fecha)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertar_cliente` (IN `_codigo` INT(5), IN `_nombre` VARCHAR(50))   INSERT INTO clientes(codigo, nombre) VALUES(_codigo, _nombre)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_leer_una_orden` (IN `_id` INT)   SELECT o.id, o.numero, o.id_cliente, c.nombre 'cliente', o.texto, o.id_estado, e.descripcion 'estado', o.fecha_creada, o.fecha_entrega
FROM ordenes o
JOIN clientes c ON o.id_cliente = c.id
JOIN estados_ordenes e ON o.id_estado = e.id
WHERE o.id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_clientes` ()   SELECT * FROM clientes$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_estados` ()   SELECT * FROM estados_ordenes$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_ordenes` ()   SELECT o.id, o.numero, c.nombre, o.texto, e.descripcion, o.fecha_creada, o.fecha_entrega
FROM ordenes o JOIN clientes c ON o.id_cliente = c.id JOIN estados_ordenes e ON o.id_estado = e.id
WHERE o.borrada = 0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modificar_orden` (IN `_numero` INT(5), IN `_texto` TEXT, IN `_id_estado` INT(5), IN `_fecha` DATE)   UPDATE ordenes SET texto=_texto, id_estado=_id_estado, fecha_entrega=_fecha WHERE numero = _numero$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_validar_usuario` (IN `param_user` VARCHAR(255), IN `param_pass` VARCHAR(255))   BEGIN
SET @s = CONCAT( "SELECT COUNT(*) 'coincidencia' FROM usuarios WHERE usuario = '", param_user, "' AND clave = '", param_pass, "'");
PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `codigo` int(5) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `codigo`, `nombre`) VALUES
(1, 1, 'Luxury Windows'),
(2, 2, 'Inversiones Arquitectónicas'),
(3, 3, 'Aluminios Panamá'),
(4, 4, 'Windows & Doors'),
(5, 5, 'French View Windows'),
(6, 6, 'Fast Builders'),
(7, 7, 'Fachadas Comerciales'),
(8, 8, 'Ventanas Modernas'),
(9, 9, 'Multiservicios Glass'),
(10, 10, 'Security Windows');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_ordenes`
--

CREATE TABLE `estados_ordenes` (
  `id` int(11) NOT NULL,
  `codigo` int(5) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estados_ordenes`
--

INSERT INTO `estados_ordenes` (`id`, `codigo`, `descripcion`) VALUES
(1, 1, 'sin iniciar'),
(2, 2, 'en corte'),
(3, 3, 'en maquinado'),
(4, 4, 'en armado'),
(5, 5, 'terminada'),
(6, 6, 'entregada'),
(7, 7, 'pausada'),
(8, 8, 'cancelada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(11) NOT NULL,
  `numero` int(5) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `texto` text DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `fecha_creada` date NOT NULL DEFAULT current_timestamp(),
  `fecha_entrega` date NOT NULL,
  `borrada` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id`, `numero`, `id_cliente`, `texto`, `id_estado`, `fecha_creada`, `fecha_entrega`, `borrada`) VALUES
(1, 19000, 2, 'Fabricación de 5 puertas de bisagras. Aluminio color blanco, vidrio claro de 6mm.', 1, '2022-11-20', '2022-11-29', 0),
(2, 19023, 4, 'Fabricación de 10 ventanas corredizas con mosquitero y cerraduras multipuntos. Aluminio color bronce, vidrio laminado bronce de 6mm.', 3, '2022-11-20', '2022-11-23', 0),
(3, 19253, 5, 'Corte y troquelado de 25 puertas de louvers (rejillas) en aluminio natural. Accesorios en color negro.', 4, '2022-11-20', '2022-11-30', 0),
(4, 19222, 7, 'Prueba desde sp_crear_orden', 5, '2022-11-22', '2022-11-24', 0),
(9, 543210, 4, 'Orden modificada desde sp', 3, '2022-11-22', '2022-12-31', 0),
(11, 12345, 6, 'Creando una orden desde frontend', 4, '2022-11-22', '2022-11-29', 0),
(12, 19521, 4, 'Creando una orden desde frontend', 1, '2022-11-22', '2022-11-24', 0),
(13, 32555, 5, 'Creando una orden de producción.', 3, '2022-11-22', '2022-12-10', 0),
(14, 21346, 7, 'Creando una orden de producción.', 6, '2022-11-22', '2022-12-09', 0),
(15, 34155, 10, 'Creando una orden de producción.', 3, '2022-11-22', '2022-11-30', 0),
(16, 12245, 5, 'Creando una orden de producción.', 4, '2022-11-22', '2022-12-07', 0),
(17, 202212121, 5, 'Prueba 12 de diciembre', 5, '2022-12-12', '2022-12-23', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `usuario` varchar(20) NOT NULL DEFAULT '',
  `clave` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`) VALUES
(1, 'testuser', 'teXB5LK3JWG6g');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados_ordenes`
--
ALTER TABLE `estados_ordenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
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
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `estados_ordenes`
--
ALTER TABLE `estados_ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
