-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2026 a las 17:13:57
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
-- Base de datos: `php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id` int(11) NOT NULL,
  `actividad` text NOT NULL,
  `id_usuario` text NOT NULL COMMENT 'Almacena JSON de IDs de usuario',
  `id_servicios` text NOT NULL COMMENT 'Almacena JSON de IDs de servicios',
  `id_ente` text NOT NULL COMMENT 'Almacena JSON de IDs de entes',
  `id_coordinacion` int(11) NOT NULL COMMENT 'ID de coordinación del creador (de sesión)',
  `id_usuario_creador` int(11) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1=Activo, 0=Inactivo',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id`, `actividad`, `id_usuario`, `id_servicios`, `id_ente`, `id_coordinacion`, `id_usuario_creador`, `descripcion`, `estado`, `fecha`) VALUES
(1, 'prueba', '[\"203\"]', '[\"55\"]', '[\"1\",\"2\",\"3\"]', 1, 203, 'prueba', 1, '2026-05-11 03:07:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinacion`
--

CREATE TABLE `coordinacion` (
  `id` int(11) NOT NULL,
  `coordinacion` text NOT NULL,
  `estado` int(11) NOT NULL,
  `modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `coordinacion`
--

INSERT INTO `coordinacion` (`id`, `coordinacion`, `estado`, `modificacion`, `fecha`) VALUES
(1, 'Despacho', 1, '2026-04-20 11:46:51', '2026-03-26 11:31:18'),
(2, 'Administracion', 1, '2026-04-20 11:46:52', '2026-03-26 12:01:12'),
(4, 'Soporte', 1, '2026-04-06 12:58:48', '2026-04-06 12:58:48'),
(5, 'Redes', 1, '2026-04-06 12:58:55', '2026-04-06 12:58:55'),
(6, 'Telecomunicación', 1, '2026-04-06 12:59:12', '2026-04-06 12:59:12'),
(7, 'Planificación', 1, '2026-04-20 11:46:54', '2026-04-06 12:59:26'),
(8, 'Bienes', 1, '2026-04-20 11:46:55', '2026-04-06 12:59:49'),
(9, 'Centro de Atención', 1, '2026-04-14 14:43:46', '2026-04-06 13:00:04'),
(10, 'Aplicaciones', 1, '2026-04-07 22:38:24', '2026-04-07 22:38:24'),
(11, 'Ciberseguridad', 1, '2026-04-07 22:38:38', '2026-04-07 22:38:38'),
(12, 'Archivo', 1, '2026-04-21 11:07:06', '2026-04-21 11:07:06'),
(13, 'General', 1, '2026-04-22 13:26:23', '2026-04-22 13:26:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `id` int(11) NOT NULL,
  `documento` varchar(255) NOT NULL,
  `id_tipodocs` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `emision` date NOT NULL,
  `remitente` varchar(255) NOT NULL,
  `destinatario` varchar(255) NOT NULL,
  `asunto` text NOT NULL,
  `adjunto` varchar(500) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`id`, `documento`, `id_tipodocs`, `id_ticket`, `fecha`, `emision`, `remitente`, `destinatario`, `asunto`, `adjunto`, `estado`, `modificacion`, `fecha_registro`) VALUES
(1, ' ANZ-SV-PS-036', 4, 7, '2026-04-30', '2026-04-22', 'SEVIGEA', 'AIT', 'SOLICITUD EVALUACION,DIAGNOSTICO Y POSIBLE REPARACION SWITCH', 'vistas/img/documentos/eec0458b9f137c8bf9d0c8df541ec2be.pdf', 1, '2026-05-05 17:14:18', '2026-05-05 17:14:18'),
(2, 'ANZ-SV-PS-037', 4, 6, '2026-04-30', '2026-04-22', 'SEVIGEA', 'AIT', 'SOLICITUD DE INSPECCION, DIAGNOSTICO Y POSIBLE REPARACION DE ROUTER INALAMBRICO', 'vistas/img/documentos/b230836d33ce108d9b1e96f4812cd2b8.pdf', 1, '2026-05-05 17:21:04', '2026-05-05 17:21:04'),
(3, 'ANZ-SV-PS-035', 4, 5, '2026-04-30', '2026-04-22', 'SEVIGEA', 'AIT', 'SOLICITUD INTERVENCION DE PERSONAL TECNICO', 'vistas/img/documentos/f0bd8eb261fe37b721dc5c0d462a1d53.pdf', 1, '2026-05-05 18:15:04', '2026-05-05 17:27:55'),
(4, 'S/N', 4, 10, '2026-04-30', '2026-04-30', 'ADMINISTRACION/TRAMITACION', 'AIT', 'SOLICITUD REVISION DEL SWITCH 8', 'vistas/img/documentos/59959465d833f9f994be3c6cf98c93ed.pdf', 1, '2026-05-07 18:33:25', '2026-05-05 18:18:38'),
(5, 'DP-055-05-26', 7, 13, '2026-05-05', '2026-05-05', 'PROTOCOLO', 'AIT', 'SOLICITUD REVISION TECLADOS', 'vistas/img/documentos/d130c53198ffcc9f496dd52d8e26194e.pdf', 1, '2026-05-05 18:28:14', '2026-05-05 18:24:32'),
(6, 'SGR-P-0033-2026', 4, 17, '2026-05-04', '2026-05-04', 'SGRP', 'AIT', 'RESPUESTA A OFICIO AIT-30-20-138 DE FECHA 30 DE ABRIL DE 2026 REFERENTE A TRAFICO INUSUAL DE LA RED', 'vistas/img/documentos/37315ac7a193906c12f7597a1cadaa66.pdf', 1, '2026-05-05 18:56:02', '2026-05-05 18:56:02'),
(7, 'DTH 1132', 8, 0, '2026-05-06', '2026-04-30', 'TALENTO HUMANO', 'AIT', 'BOLETA DE VACACIONES', 'vistas/img/documentos/19f8d725a77555b0787a5f6619fa6f3d.pdf', 1, '2026-05-06 13:58:01', '2026-05-06 13:58:01'),
(8, 'AIT-05-26-153', 4, 0, '2026-05-06', '2026-05-05', 'AIT', 'ADMINISTRACION', 'SOLICITUD\r\n', 'vistas/img/documentos/3439e10da2fdf2f793977f6441a7c9b6.pdf', 1, '2026-05-06 14:37:35', '2026-05-06 14:27:08'),
(9, 'AIT-05-26-154', 4, 0, '2026-05-06', '2026-05-05', 'AIT', 'PROTOCOLO', 'INFORME TECNICO REFERENTE A REVISION TECLADOS', 'vistas/img/documentos/caa5282c8822c5f36f5fe34cf69a7971.pdf', 1, '2026-05-06 14:39:16', '2026-05-06 14:39:16'),
(10, 'AIT-06-26-155', 4, 0, '2026-05-06', '2026-05-06', 'AIT', 'SECRETARIA', 'SOLICITUD REQUERIMIENTO FORMAL DE ACTUALIZACION INFRAESTRUCTURA TECNOLOGICA', 'vistas/img/documentos/d3f6fd2d53cd48a971c28a271f5a557d.pdf', 1, '2026-05-06 19:07:10', '2026-05-06 19:07:10'),
(11, 'AIT-07-26-158', 4, 0, '2026-05-07', '2026-05-07', 'AIT', 'ADMINISTRACION/COMPRAS', 'SOLICITUD MATERIAL DE LIMPIEZA', 'vistas/img/documentos/f80b0855bdd7fbe4d86e32698dcf16ab.pdf', 1, '2026-05-07 17:21:30', '2026-05-07 17:21:30'),
(12, 'AIT-07-26-157', 4, 0, '2026-05-07', '2026-05-07', 'AIT', 'ADMINISTRACION/COMPRAS', 'SOLICITUD MATERIAL DE OFICINA', 'vistas/img/documentos/9d68363b31d4360dce80d33960fadb5b.pdf', 1, '2026-05-07 17:22:19', '2026-05-07 17:22:19'),
(13, 'TESORERIA 0156/2026', 4, 30, '2026-05-07', '2026-05-05', 'ADMINISTRACION TESORERIA', 'AIT', 'SOLICITUD REVISION TECNICA PARA VPN', 'vistas/img/documentos/0458290d48668de2b71b1133e446c768.pdf', 1, '2026-05-07 17:37:08', '2026-05-07 17:37:08'),
(14, 'TESORERIA 0163/2026', 4, 31, '2026-05-07', '2026-05-07', 'ADMINISTRACION TESORERIA', 'AIT', 'SOLICITUD REVISION Y MANTENIMIENTO CPU', 'vistas/img/documentos/4d042acece9e0d7bf0f074623fb313c4.pdf', 1, '2026-05-07 17:39:17', '2026-05-07 17:39:17'),
(15, 'IEMA N° 067/2026', 4, 1, '2026-04-24', '2026-04-24', 'IEMA', 'AIT', 'SOLICITUD REVISION Y REPARACION MOUSE', 'vistas/img/documentos/2e1d4112c24f52b6257eec6cf557cc70.pdf', 1, '2026-05-07 18:16:01', '2026-05-07 18:16:01'),
(16, 'AIT-07-26-160', 4, 0, '2026-05-08', '2026-05-07', 'AIT', 'SEVIGEA', 'RESPUESTA A OFICIO ANZ-SV-PS-037 DE FECHA 22-4-2026. INFORME TECNICO', 'vistas/img/documentos/c356a036b7d617fbcb2cc74d63607cd8.pdf', 1, '2026-05-08 14:56:25', '2026-05-08 14:56:25'),
(17, 'AIT-07-26-161', 4, 0, '2026-05-08', '2026-05-07', 'AIT', 'IEMA', 'INFORME TECNICO OFICIO IEMA N° 067/2026 DE FECHA 24-4-2026', 'vistas/img/documentos/3f8060d64cce45d7238b3b795c51383f.pdf', 1, '2026-05-08 14:59:15', '2026-05-08 14:59:15'),
(18, 'AIT-07-26-159', 4, 0, '2026-05-08', '2026-05-07', 'AIT', 'SEVIGEA', 'INFORME TECNICO OFICIO ANZ-SV-PS-036', 'vistas/img/documentos/018d8a39bae0c4f7286701e03d44741f.pdf', 1, '2026-05-08 15:10:55', '2026-05-08 15:10:55'),
(19, 'AIT-07-26-162', 4, 0, '2026-05-08', '2026-05-07', 'AIT', 'ADMINISTRACION/TRAMITACION', 'INFORME TECNICO REVISION SWITCH 8 PUERTOS', 'vistas/img/documentos/f8e60fe84804cfa817d5ffffd299e2e8.pdf', 1, '2026-05-08 15:12:34', '2026-05-08 15:12:34'),
(20, 'DTH N° 1150', 4, 42, '2026-05-08', '2026-05-08', 'TALENTO HUMANO', 'AIT', 'SOLICITUD INSTALACION PUNTO DE INTERNET CONMEMORACION DIA DE LAS MADRES', 'vistas/img/documentos/487b02ac9369e94c60445ca6cb1b9b78.pdf', 1, '2026-05-11 13:31:53', '2026-05-11 13:31:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entes`
--

CREATE TABLE `entes` (
  `id` int(11) NOT NULL,
  `entes` text NOT NULL,
  `estado` int(11) NOT NULL,
  `modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `entes`
--

INSERT INTO `entes` (`id`, `entes`, `estado`, `modificacion`, `fecha`) VALUES
(1, 'Dirección de Automatización, Informatica y Telecomunicacion - AIT', 1, '2026-05-07 10:09:53', '2026-03-26 12:11:47'),
(2, ' Secretaria de Gobierno', 1, '2026-05-07 10:10:13', '2026-03-30 18:49:13'),
(3, ' Comunicación e Información ', 1, '2026-05-07 10:10:51', '2026-04-07 21:46:40'),
(4, 'Direccion de Planificacion y Desarrollo', 1, '2026-05-07 10:11:12', '2026-04-07 21:46:52'),
(5, 'Protocolo', 1, '2026-04-07 21:47:03', '2026-04-07 21:47:03'),
(6, 'Auditoria interna', 1, '2026-05-07 10:11:32', '2026-04-07 21:47:12'),
(7, 'Direccion de Talento Humano', 1, '2026-05-06 14:09:09', '2026-04-07 21:47:21'),
(8, 'Despacho del gobernador', 1, '2026-05-05 10:15:20', '2026-05-05 10:15:20'),
(9, 'Direccion de Atencion al ciudadano', 1, '2026-05-06 14:09:24', '2026-05-05 10:15:34'),
(10, 'Direccion de Presupuesto', 1, '2026-05-06 14:09:32', '2026-05-05 10:15:49'),
(11, 'Direccion de Bienes Públicos  Estadales', 1, '2026-05-07 10:12:31', '2026-05-05 10:16:05'),
(12, 'Agea', 1, '2026-05-05 10:16:18', '2026-05-05 10:16:18'),
(13, 'Sat Anzoátegui', 1, '2026-05-07 10:13:24', '2026-05-05 10:16:32'),
(14, 'Direccion  de Administración y finanza', 1, '2026-05-06 14:13:07', '2026-05-05 10:17:00'),
(15, 'Procuraduría General del Estado ', 1, '2026-05-07 10:14:25', '2026-05-05 10:17:29'),
(16, 'Consultoría Jurídica', 1, '2026-05-07 10:14:45', '2026-05-05 10:17:51'),
(17, 'Direccion de Comunas y poder popular', 1, '2026-05-06 14:12:49', '2026-05-05 10:18:18'),
(18, 'ICANZ', 1, '2026-05-07 10:15:12', '2026-05-05 10:18:34'),
(19, 'CORANZTUR', 1, '2026-05-07 10:15:39', '2026-05-05 10:18:47'),
(20, 'Dirección de Educación', 1, '2026-05-07 10:17:39', '2026-05-05 10:20:38'),
(21, 'Red de biblioteca', 1, '2026-05-05 10:20:50', '2026-05-05 10:20:50'),
(22, 'IJANZ', 1, '2026-05-07 10:17:59', '2026-05-05 10:20:59'),
(23, 'IDEANZ', 1, '2026-05-07 10:18:20', '2026-05-05 10:21:04'),
(24, 'POLIBANZ', 1, '2026-05-07 10:18:39', '2026-05-05 10:21:25'),
(25, 'SIGRAED', 1, '2026-05-07 10:18:53', '2026-05-05 10:21:32'),
(26, 'DPISC', 1, '2026-05-07 10:19:17', '2026-05-05 10:21:42'),
(27, 'COVINEA', 1, '2026-05-07 10:19:35', '2026-05-05 10:25:18'),
(28, 'SEVIGEA', 1, '2026-05-07 10:19:54', '2026-05-05 10:25:25'),
(29, 'EGIDSA', 1, '2026-05-07 10:20:09', '2026-05-05 10:26:24'),
(30, 'INSOTRANZ', 1, '2026-05-07 10:20:30', '2026-05-05 10:26:32'),
(31, 'Terminal CLETO QUIJADA', 1, '2026-05-05 10:26:50', '2026-05-05 10:26:50'),
(32, 'CAUPOCA', 1, '2026-05-07 10:20:54', '2026-05-05 10:26:58'),
(33, 'Eps MI PATRIA QUERIDA', 1, '2026-05-05 10:27:13', '2026-05-05 10:27:13'),
(34, 'VIANZ', 1, '2026-05-07 10:21:20', '2026-05-05 10:27:20'),
(35, 'CORPOMINAS', 1, '2026-05-07 10:21:44', '2026-05-05 10:27:47'),
(36, 'SGRANZ - Sociedad de garantía', 1, '2026-05-07 10:22:19', '2026-05-05 10:28:04'),
(37, 'CREANZ', 1, '2026-05-07 10:22:51', '2026-05-05 10:28:11'),
(38, 'CORPAVANZ', 1, '2026-05-07 10:23:05', '2026-05-05 10:28:37'),
(39, 'COPESCA', 1, '2026-05-07 10:23:28', '2026-05-05 10:28:43'),
(40, 'CORDAGRO ', 1, '2026-05-07 10:23:51', '2026-05-05 10:28:50'),
(41, 'Criptoactivos ', 1, '2026-05-05 10:29:31', '2026-05-05 10:29:31'),
(42, 'CAH', 1, '2026-05-07 10:24:30', '2026-05-05 10:29:41'),
(43, 'IEMA', 1, '2026-05-07 10:24:41', '2026-05-05 10:29:53'),
(44, 'Ecoanzoategui', 1, '2026-05-05 10:31:12', '2026-05-05 10:31:12'),
(45, 'Proanzoategui', 1, '2026-05-05 10:31:21', '2026-05-05 10:31:21'),
(46, 'DAPS', 1, '2026-05-07 10:25:03', '2026-05-05 10:31:49'),
(47, 'SALUDANZ', 1, '2026-05-07 10:25:17', '2026-05-05 10:31:58'),
(48, 'IDANZ', 1, '2026-05-07 10:25:30', '2026-05-05 10:32:05'),
(49, 'IASPI', 1, '2026-05-07 10:25:43', '2026-05-05 10:32:13'),
(50, 'FUNCAZ', 1, '2026-05-07 10:25:59', '2026-05-05 10:32:32'),
(51, 'FUNDAR', 1, '2026-05-07 10:26:11', '2026-05-05 10:32:52'),
(52, 'FASGANZ', 1, '2026-05-07 10:26:23', '2026-05-05 10:33:01'),
(53, 'Sala Situacional Gobernación ', 1, '2026-05-07 10:27:04', '2026-05-05 10:33:41'),
(54, 'Instituto de beneficencia publica y asistencia social del estado Anzoátegui', 1, '2026-05-05 10:55:43', '2026-05-05 10:55:43'),
(55, 'Dirección Administración y Finanzas - Tesorería', 1, '2026-05-07 10:28:01', '2026-05-05 11:32:04'),
(56, 'Dirección Administración y Finanzas - Compras', 1, '2026-05-07 10:28:26', '2026-05-05 11:32:25'),
(57, 'Dirección Administración y Finanzas - Contabilidad', 1, '2026-05-07 10:29:14', '2026-05-05 11:32:44'),
(58, 'Dirección Administración y Finanzas - Tramitación', 1, '2026-05-07 10:29:32', '2026-05-05 11:33:02'),
(59, 'Adminitracion - Tesoreria', 0, '2026-05-07 10:44:34', '2026-05-05 11:36:19'),
(60, 'Dirección Administración y Finanzas - Servicios generales', 1, '2026-05-07 10:29:50', '2026-05-05 11:37:33'),
(61, 'Seguridad interna', 1, '2026-05-05 13:22:57', '2026-05-05 13:22:57'),
(62, 'Seguridad policial', 1, '2026-05-06 11:33:11', '2026-05-06 11:33:11'),
(63, 'Otros', 1, '2026-05-06 14:05:51', '2026-05-06 14:05:51'),
(64, 'Instituto Nacional de la Juventud', 1, '2026-05-11 08:20:00', '2026-05-11 08:20:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `item` text NOT NULL,
  `estado` int(11) NOT NULL,
  `modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `item`
--

INSERT INTO `item` (`id`, `item`, `estado`, `modificacion`, `fecha`) VALUES
(1, 'Desktop', 1, '2026-03-26 14:00:33', '2026-03-26 12:46:58'),
(2, 'Laptop', 1, '2026-03-26 12:47:08', '2026-03-26 12:47:08'),
(4, 'Teléfono', 1, '2026-04-07 22:39:25', '2026-04-07 22:39:25'),
(5, 'Impresora', 1, '2026-04-07 22:39:39', '2026-04-07 22:39:39'),
(6, 'Cableado ', 1, '2026-05-05 13:27:54', '2026-05-05 13:27:54'),
(7, 'Teclado', 1, '2026-05-05 14:16:59', '2026-05-05 14:16:59'),
(8, 'Celular', 1, '2026-05-06 11:46:48', '2026-05-06 11:46:48'),
(9, 'Switch', 1, '2026-05-06 14:28:21', '2026-05-06 14:28:21'),
(10, 'Router', 1, '2026-05-06 14:44:52', '2026-05-06 14:44:52'),
(11, 'Mouse', 1, '2026-05-07 08:30:56', '2026-05-07 08:30:56'),
(12, 'Camaras', 1, '2026-05-07 10:46:55', '2026-05-07 10:46:55'),
(13, 'Fuente de Poder ', 1, '2026-05-07 10:47:07', '2026-05-07 10:47:07'),
(14, 'Video Beam', 1, '2026-05-07 11:31:02', '2026-05-07 11:31:02'),
(15, 'NVR', 1, '2026-05-07 11:35:09', '2026-05-07 11:35:09'),
(16, 'DVR', 1, '2026-05-07 11:35:15', '2026-05-07 11:35:15'),
(17, 'Monitor', 1, '2026-05-07 15:02:03', '2026-05-07 15:02:03'),
(18, 'RJ45', 1, '2026-05-08 08:09:12', '2026-05-08 08:09:12'),
(19, 'JACK', 1, '2026-05-08 08:10:41', '2026-05-08 08:10:41'),
(20, 'Antena', 1, '2026-05-08 09:44:43', '2026-05-08 09:44:43'),
(21, 'Revisión ', 1, '2026-05-08 10:38:27', '2026-05-08 10:38:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medio`
--

CREATE TABLE `medio` (
  `id` int(11) NOT NULL,
  `medio` text NOT NULL,
  `color` text NOT NULL,
  `estado` int(11) NOT NULL,
  `modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `medio`
--

INSERT INTO `medio` (`id`, `medio`, `color`, `estado`, `modificacion`, `fecha`) VALUES
(1, 'Teléfono', '#1221f3', 1, '2026-04-23 10:50:38', '2026-03-25 12:08:49'),
(2, 'Oficios', '#088216', 1, '2026-03-25 14:47:23', '2026-03-25 12:19:13'),
(3, 'Presencial', '#f5cc00', 1, '2026-03-25 14:47:14', '2026-03-25 13:00:07'),
(4, 'Otros', '#09f1ed', 1, '2026-03-25 14:18:17', '2026-03-25 13:41:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridad`
--

CREATE TABLE `prioridad` (
  `id` int(11) NOT NULL,
  `prioridad` text NOT NULL,
  `color` text NOT NULL,
  `estado` int(11) NOT NULL,
  `modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prioridad`
--

INSERT INTO `prioridad` (`id`, `prioridad`, `color`, `estado`, `modificacion`, `fecha`) VALUES
(1, 'Baja', '#00a65a', 1, '2026-03-30 18:36:33', '2026-03-26 11:09:47'),
(2, 'Media', '#f39c12', 1, '2026-03-30 18:36:56', '2026-03-29 18:55:18'),
(3, 'Alta', '#dd4b39', 1, '2026-03-30 18:37:18', '2026-03-29 18:55:25'),
(4, 'Critica', '#cc0014', 1, '2026-03-29 18:57:59', '2026-03-29 18:55:37'),
(5, 'Relevante', '#00afdb', 1, '2026-03-30 18:37:50', '2026-03-29 18:55:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id` int(11) NOT NULL,
  `prueba` text NOT NULL,
  `estado` int(11) NOT NULL,
  `item_i` text NOT NULL,
  `item_s` text NOT NULL,
  `modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`id`, `prueba`, `estado`, `item_i`, `item_s`, `modificacion`, `fecha`) VALUES
(2, 'aaa', 1, 'aaabb', 'Opción 1', '2026-03-23 19:41:44', '2026-03-23 19:41:44'),
(6, 'eee', 1, 'eeefff', 'Opción 2', '2026-03-25 10:36:49', '2026-03-23 20:13:41'),
(8, 'fggg', 1, 'dddeee', 'Opción 2', '2026-03-25 00:19:45', '2026-03-24 23:53:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `servicios` text NOT NULL,
  `id_coordinacion` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `servicios`, `id_coordinacion`, `estado`, `modificacion`, `fecha`) VALUES
(2, 'Instalación de sistema Operativo', 4, 1, '2026-04-22 13:02:07', '2026-03-26 12:48:31'),
(5, 'POA', 7, 1, '2026-05-05 10:38:52', '2026-05-05 10:38:52'),
(6, 'Control y seguimiento ', 7, 1, '2026-05-05 10:39:28', '2026-05-05 10:39:28'),
(7, 'Planificación  Semanal', 7, 1, '2026-05-05 10:39:58', '2026-05-05 10:39:58'),
(8, 'ACAE', 7, 1, '2026-05-05 10:40:41', '2026-05-05 10:40:41'),
(9, 'Sistema de Indicadores', 7, 1, '2026-05-05 10:45:05', '2026-05-05 10:41:09'),
(10, 'Verificacion ', 5, 0, '2026-05-08 08:08:14', '2026-05-05 13:27:11'),
(11, 'Configuración de impresora ', 4, 1, '2026-05-05 13:53:22', '2026-05-05 13:53:22'),
(12, 'Cambio de jack', 5, 1, '2026-05-05 14:07:54', '2026-05-05 14:07:54'),
(13, 'Revision ', 4, 1, '2026-05-05 14:16:14', '2026-05-05 14:16:14'),
(14, 'Mantenimiento ', 4, 1, '2026-05-05 14:16:24', '2026-05-05 14:16:24'),
(15, 'Verificacion de Vpn y Proxys ', 11, 1, '2026-05-06 11:51:36', '2026-05-05 14:28:52'),
(16, 'Activación de office ', 4, 1, '2026-05-05 14:38:36', '2026-05-05 14:38:36'),
(17, 'Activación de windows', 4, 1, '2026-05-05 14:39:31', '2026-05-05 14:39:31'),
(18, 'Instalacion de office', 4, 1, '2026-05-05 14:45:46', '2026-05-05 14:45:46'),
(19, 'Instalacion de Impresora', 4, 1, '2026-05-06 10:05:44', '2026-05-06 10:05:44'),
(20, 'Instalacion de Driver de impresora', 4, 1, '2026-05-06 10:06:32', '2026-05-06 10:06:32'),
(21, 'Configuración de Impresora en LAN', 4, 1, '2026-05-06 10:07:29', '2026-05-06 10:07:29'),
(22, 'Configuración de Impresora en WLAN', 4, 1, '2026-05-06 10:08:03', '2026-05-06 10:08:03'),
(23, 'Reconexión de internet en Desktop', 4, 1, '2026-05-06 10:09:47', '2026-05-06 10:09:47'),
(24, 'Configuración de credenciales', 4, 1, '2026-05-06 10:13:45', '2026-05-06 10:13:45'),
(25, 'Revision de Hardware', 4, 1, '2026-05-06 10:17:03', '2026-05-06 10:17:03'),
(26, 'Revision de Monitor ', 4, 1, '2026-05-06 10:18:27', '2026-05-06 10:18:27'),
(27, 'Revision de Teclado', 4, 1, '2026-05-06 10:18:46', '2026-05-06 10:18:46'),
(28, 'Revision de Mouse', 4, 1, '2026-05-06 10:19:25', '2026-05-06 10:19:25'),
(29, 'Conexión de Wifi a Computadora', 6, 1, '2026-05-06 12:05:07', '2026-05-06 10:19:33'),
(30, 'Agregar Mac al Sistema Pfsense', 11, 1, '2026-05-06 11:06:07', '2026-05-06 11:03:53'),
(31, 'Modificar Mac en el Pfsense', 11, 1, '2026-05-06 11:04:50', '2026-05-06 11:04:50'),
(32, 'Entrega de Base de Datos de Sistema Administrativo', 11, 1, '2026-05-06 11:07:44', '2026-05-06 11:07:44'),
(33, 'Instalacion de WiFi para Eventos Institucionales', 6, 1, '2026-05-06 11:15:56', '2026-05-06 11:15:43'),
(34, 'Revisión de Conexion Inalámbrica', 6, 1, '2026-05-06 12:06:47', '2026-05-06 11:17:19'),
(35, 'Configuración de Impresora compartida', 4, 1, '2026-05-06 11:32:57', '2026-05-06 11:32:57'),
(36, 'Configuración de Scanner', 4, 1, '2026-05-06 11:44:10', '2026-05-06 11:41:11'),
(37, 'Conexión de Wifi a Dispositivo Movil', 6, 1, '2026-05-06 12:05:23', '2026-05-06 12:05:23'),
(38, 'Matenimiento de Switch de acceso', 4, 1, '2026-05-07 10:35:05', '2026-05-06 14:26:35'),
(39, 'Mantenimiento de Router', 4, 1, '2026-05-06 14:45:31', '2026-05-06 14:45:31'),
(40, 'Medición de Velocidad de Red Inalámbrica', 6, 1, '2026-05-06 15:03:17', '2026-05-06 15:03:00'),
(41, 'Crear Limites de Banda de Navegación', 11, 1, '2026-05-07 09:16:02', '2026-05-07 09:16:02'),
(42, 'Configurar Reglas de Firewall', 11, 1, '2026-05-07 09:17:03', '2026-05-07 09:17:03'),
(43, 'Crear Alias', 11, 1, '2026-05-07 09:17:23', '2026-05-07 09:17:23'),
(44, 'Asignar DNS', 11, 1, '2026-05-07 09:18:12', '2026-05-07 09:18:12'),
(45, 'Configurar y Monitorear Snort', 11, 1, '2026-05-07 09:19:30', '2026-05-07 09:19:30'),
(46, 'Instalación de Paquetes Pfsense', 11, 1, '2026-05-07 09:20:56', '2026-05-07 09:20:56'),
(47, 'Instalación de Periféricos o Componentes para Servidores', 11, 1, '2026-05-07 09:26:30', '2026-05-07 09:26:30'),
(48, 'Creación de Maquinas Virtuales', 11, 1, '2026-05-07 09:27:39', '2026-05-07 09:27:39'),
(49, 'Instalación de Sistemas Especiales', 11, 1, '2026-05-07 09:29:37', '2026-05-07 09:29:37'),
(50, 'Creación de Scripts Automatizados', 11, 1, '2026-05-07 09:30:30', '2026-05-07 09:30:30'),
(51, 'Revision de Camaras ', 4, 1, '2026-05-07 10:46:36', '2026-05-07 10:46:36'),
(52, 'Préstamo de Video beam', 1, 1, '2026-05-07 11:30:23', '2026-05-07 11:29:31'),
(53, 'Revisión de sistema de vigilancia', 4, 1, '2026-05-07 11:34:42', '2026-05-07 11:34:42'),
(54, 'Modificación de paquete office ', 4, 1, '2026-05-08 09:51:41', '2026-05-08 09:51:41'),
(55, 'Diagnostico', 5, 1, '2026-05-08 10:37:02', '2026-05-08 10:37:02'),
(56, 'Levantamiento de información', 5, 1, '2026-05-08 10:37:16', '2026-05-08 10:37:16'),
(57, 'colocar conector RJ45', 5, 1, '2026-05-08 11:10:59', '2026-05-08 11:09:08'),
(58, 'Configurar Mac Cel Conexión Wifi ', 11, 1, '2026-05-08 12:01:32', '2026-05-08 12:01:32'),
(59, 'Configuración de SSID a Antena', 6, 1, '2026-05-08 12:07:55', '2026-05-08 12:07:55'),
(60, 'Cambio de Patch Cord', 5, 1, '2026-05-11 10:42:28', '2026-05-11 10:42:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` text NOT NULL,
  `color` text NOT NULL,
  `estado` int(11) NOT NULL,
  `modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `status`, `color`, `estado`, `modificacion`, `fecha`) VALUES
(1, 'Nuevo', '#3c8dbc', 1, '2026-04-15 11:43:42', '2026-03-26 10:58:00'),
(2, 'Pendiente', '#ffc800', 1, '2026-03-29 19:00:55', '2026-03-29 18:59:26'),
(3, 'En proceso', '#fa8000', 1, '2026-03-29 19:01:16', '2026-03-29 18:59:41'),
(4, 'Resuelto', '#63c700', 1, '2026-03-29 19:01:42', '2026-03-29 18:59:54'),
(5, 'En Pausa', '#d40202', 1, '2026-03-29 19:02:13', '2026-03-29 19:00:24'),
(6, 'Programado', '#c107da', 1, '2026-05-11 10:55:46', '2026-05-11 10:09:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_ente` int(11) NOT NULL,
  `solicitante` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_medio` int(11) NOT NULL,
  `id_prioridad` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `modificacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `finalizado` enum('si','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ticket`
--

INSERT INTO `ticket` (`id`, `ticket`, `id_usuario`, `id_ente`, `solicitante`, `descripcion`, `id_medio`, `id_prioridad`, `estado`, `modificacion`, `fecha`, `finalizado`) VALUES
(1, 0, 195, 43, 'Maria Jose Castro', 'solicitud para la reparación de mouse ', 2, 2, 1, '2026-05-07 11:22:07', '2026-05-05 10:33:17', 'si'),
(2, 0, 195, 6, 'Ali Tillero', 'Solicitud para tendido de cableado', 2, 2, 1, '2026-05-05 10:45:44', '2026-05-05 10:45:44', 'no'),
(3, 0, 195, 35, 'Pedro Mata', 'Solicitud para la revisión de laptop con problemas al encender', 2, 2, 1, '2026-05-05 11:01:32', '2026-05-05 10:53:56', 'si'),
(4, 0, 195, 51, 'Carmen Figueroa', 'Solicitud para instalación de sistema operativo .', 3, 2, 1, '2026-05-05 13:33:23', '2026-05-05 10:58:12', 'si'),
(5, 0, 195, 28, 'jocsann andres  naranjo', ' Revisión de puntos de  red y switches  en cada piso', 2, 2, 1, '2026-05-08 10:40:31', '2026-05-05 11:06:04', 'si'),
(6, 0, 195, 28, 'Jocsann Andres  Naranjo', 'Router con falla  de funcionamiento', 2, 2, 1, '2026-05-07 11:56:25', '2026-05-05 11:15:26', 'si'),
(7, 0, 195, 28, 'Jocsann Andres  Naranjo', 'Evaluación   diagnóstico y posible reparación de switche de acceso ', 2, 2, 1, '2026-05-07 13:28:34', '2026-05-05 11:22:03', 'si'),
(8, 0, 195, 58, 'kelly russian', 'problemas con switcher', 1, 2, 1, '2026-05-06 09:46:43', '2026-05-05 11:38:28', 'si'),
(9, 0, 195, 61, 'Aquiles Suniaga ', 'Solicitud para verificación por fallas en el internet cableado  ', 1, 2, 1, '2026-05-05 13:30:27', '2026-05-05 13:24:47', 'si'),
(10, 0, 195, 58, 'Arly Guarapana', 'Revisión de switch de acceso ', 2, 2, 1, '2026-05-07 10:33:00', '2026-05-05 13:33:49', 'si'),
(11, 0, 195, 11, 'Vicente Itriago ', 'Solicitud de soporte para una impresora que no imprime', 1, 2, 1, '2026-05-05 13:54:00', '2026-05-05 13:41:10', 'si'),
(12, 0, 195, 7, 'Elizabeth Castillo', 'Problemas de red ', 1, 2, 1, '2026-05-06 09:44:14', '2026-05-05 13:56:00', 'si'),
(13, 0, 195, 5, 'Marianella Cartaya ', 'Revision  de teclados', 2, 2, 1, '2026-05-05 14:24:27', '2026-05-05 14:09:27', 'si'),
(14, 0, 195, 7, 'Carlos Andueza', 'Verificación de VPN', 4, 2, 1, '2026-05-05 14:30:44', '2026-05-05 14:27:06', 'si'),
(15, 0, 195, 35, 'Lenny Velasquez', 'Activación de Office', 1, 2, 1, '2026-05-05 14:39:20', '2026-05-05 14:35:39', 'si'),
(16, 0, 195, 16, 'Duryenis Brito ', 'Instalación de Office', 1, 2, 1, '2026-05-05 14:46:20', '2026-05-05 14:44:20', 'si'),
(17, 0, 195, 36, 'Milagros Gomez Hernandez ', 'Verificación de VPN en todas las computadoras de la dirección ', 2, 3, 1, '2026-05-11 09:45:39', '2026-05-05 14:48:03', 'no'),
(18, 0, 195, 23, 'Carla Vasquez', 'Problemas con impresora ', 1, 2, 1, '2026-05-06 12:00:22', '2026-05-05 14:57:13', 'si'),
(19, 0, 195, 7, 'Arcelys Golindano', 'Problemas con Word ', 1, 2, 1, '2026-05-05 15:01:17', '2026-05-05 14:59:35', 'si'),
(20, 0, 195, 55, 'Andres Arreaza', 'Computadora con problemas al encender', 1, 2, 1, '2026-05-05 15:03:35', '2026-05-05 15:02:48', 'si'),
(21, 0, 179, 11, 'Jesus Macabi', 'Se desconectaron los equipos de la impresora ', 1, 2, 1, '2026-05-06 11:43:02', '2026-05-06 09:07:24', 'si'),
(22, 0, 179, 61, 'Emil Velasquez', 'Cambio de wifi ', 3, 2, 1, '2026-05-06 10:21:09', '2026-05-06 10:03:02', 'si'),
(23, 0, 179, 36, 'Delvalle Lugo', 'Verificación de Wifi ', 3, 2, 1, '2026-05-06 11:50:45', '2026-05-06 10:34:28', 'si'),
(24, 0, 179, 36, 'Rossymar Vasquez ', 'Instalación de escáner ', 4, 2, 1, '2026-05-06 14:57:40', '2026-05-06 11:34:34', 'si'),
(25, 0, 178, 62, 'Erain Morales ', 'Agregar Mac al pfsense y vincular clave del instituto de cultura y de seguridad policial', 1, 2, 1, '2026-05-06 12:28:12', '2026-05-06 11:34:52', 'si'),
(26, 0, 179, 19, 'Gabriela Simoza', 'Solicitud para préstamo de videobeam', 1, 2, 1, '2026-05-07 11:34:32', '2026-05-06 14:23:28', 'si'),
(27, 0, 179, 63, 'Luis Camorz', 'Solicitud para conexión wifi', 3, 2, 1, '2026-05-06 14:53:12', '2026-05-06 14:24:28', 'si'),
(28, 0, 179, 53, 'Carlos Andueza', 'Revisión de wifi ', 4, 3, 1, '2026-05-06 14:57:06', '2026-05-06 14:41:23', 'si'),
(29, 0, 179, 44, 'Carlos Andueza', 'Revision de Camaras y CPU con problemas para encender ', 4, 3, 1, '2026-05-07 10:57:32', '2026-05-07 09:26:02', 'si'),
(30, 0, 178, 55, 'ARLY GUARAPANA', 'Solicitar revisión técnica para verificar el uso debido de vpn ', 2, 2, 1, '2026-05-07 13:24:23', '2026-05-07 11:14:46', 'si'),
(31, 0, 178, 55, 'ARLY GUARAPANA', 'Revision y mantenimiento del Cpu con fallas tecnicas ', 2, 2, 1, '2026-05-08 00:50:40', '2026-05-07 11:20:40', 'no'),
(32, 0, 179, 18, 'Jose Rodriguez', 'Solicitud para cambio de mac por cambio de dispositivo ', 3, 2, 1, '2026-05-07 14:40:06', '2026-05-07 13:21:36', 'si'),
(33, 0, 179, 46, 'Carmen Figueroa', 'Solicitud para configuracion de Wifi', 3, 2, 1, '2026-05-07 14:39:55', '2026-05-07 14:06:57', 'si'),
(34, 0, 179, 34, 'Ana Martinez', 'Solicitud para una consulta por fallas del wifi', 3, 2, 1, '2026-05-07 14:39:28', '2026-05-07 14:10:04', 'si'),
(35, 0, 179, 34, 'Ana Martinez', 'Solicitud para la revisión de un Monitor', 1, 2, 1, '2026-05-07 15:07:43', '2026-05-07 14:11:32', 'si'),
(36, 0, 179, 7, 'Arcelys Golindano', 'Problema con el paquete de Office que se queda pegado.', 1, 2, 1, '2026-05-08 10:02:16', '2026-05-08 09:34:41', 'si'),
(37, 0, 178, 7, 'Carlos Andueza', 'La solicitud es para colocar una antena de omada  para darle conectividad a la actividad del dia de las madres ', 4, 2, 1, '2026-05-11 10:14:35', '2026-05-08 09:41:09', 'si'),
(38, 0, 178, 10, 'Carlos Andueza', 'Solicitud de revisión de computadora, por si hay algún programa que sea lo que generó el tráfico VPN', 4, 2, 1, '2026-05-08 10:24:29', '2026-05-08 10:16:26', 'si'),
(39, 0, 178, 7, 'Arcelys Golindano', 'Verificación de conexión de computadora a impresora ', 1, 2, 1, '2026-05-08 11:58:25', '2026-05-08 11:40:09', 'si'),
(40, 0, 178, 36, 'Carlos Boadas', 'Problemas para la conexión wifi ', 3, 2, 1, '2026-05-08 12:06:23', '2026-05-08 11:56:10', 'si'),
(41, 0, 179, 56, 'Nelcy Morey', 'Solicitud para resolver problemas con una computadora que tiene modo oscuro y no se quiere cambiar ', 1, 2, 1, '2026-05-08 13:45:18', '2026-05-08 13:33:47', 'si'),
(42, 0, 179, 7, 'Abg Paulimer Brito ', 'Solicitud para la colaboracion en cuanto a la instalacion de un punto de red  para el dia Viernes  15 de Mayo del 2026 en la realizacion del Karaoke Madre e hijo  para la conmemoracion del mes de la madre a realizarse en el patio central de la Gobernacion a las 9 00 am', 2, 2, 1, '2026-05-08 14:39:53', '2026-05-08 14:37:11', 'no'),
(44, 0, 195, 64, 'Carlos Andueza', 'instalación de impresora', 4, 2, 1, '2026-05-11 08:21:12', '2026-05-11 08:21:12', 'no'),
(45, 0, 195, 7, 'Oriana  garcia', 'solicitud de wifi para  para jornada  Médico asistencial en el patio central de la Gobernación', 3, 2, 1, '2026-05-11 09:04:56', '2026-05-11 09:04:56', 'no'),
(46, 0, 195, 36, 'Jesus Rivas', 'cambio de mac', 3, 2, 1, '2026-05-11 09:33:57', '2026-05-11 09:23:14', 'si'),
(47, 0, 195, 57, 'Gian Franck  Di salvatore ', 'computadora con fallas', 1, 2, 1, '2026-05-11 10:07:14', '2026-05-11 09:27:52', 'si'),
(48, 0, 195, 56, 'Darimar Guachique ', '2 computadoras sin acceso a internet ', 1, 2, 1, '2026-05-11 10:17:32', '2026-05-11 10:17:32', 'no'),
(49, 0, 195, 3, 'Barbara Segura ', 'Cambio de MAC en Dispositivo ', 3, 2, 1, '2026-05-11 11:01:31', '2026-05-11 10:25:59', 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketcoordinacion`
--

CREATE TABLE `ticketcoordinacion` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_coordinacion` int(11) NOT NULL,
  `ticketcoordinacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ticketcoordinacion`
--

INSERT INTO `ticketcoordinacion` (`id`, `id_ticket`, `id_coordinacion`, `ticketcoordinacion`, `fecha`) VALUES
(1, 1, 4, 0, '2026-05-05 10:34:00'),
(3, 3, 4, 0, '2026-05-05 10:54:07'),
(4, 4, 4, 0, '2026-05-05 10:58:28'),
(5, 4, 5, 0, '2026-05-05 11:06:29'),
(8, 6, 4, 0, '2026-05-05 11:15:47'),
(9, 7, 4, 0, '2026-05-05 11:23:07'),
(10, 8, 4, 0, '2026-05-05 11:38:57'),
(11, 9, 5, 0, '2026-05-05 13:25:08'),
(12, 10, 4, 0, '2026-05-05 13:34:12'),
(13, 11, 4, 0, '2026-05-05 13:41:31'),
(14, 12, 4, 0, '2026-05-05 13:57:14'),
(15, 12, 5, 0, '2026-05-05 13:57:22'),
(16, 12, 11, 0, '2026-05-05 13:58:15'),
(17, 13, 4, 0, '2026-05-05 14:12:03'),
(18, 14, 11, 0, '2026-05-05 14:27:23'),
(19, 14, 4, 0, '2026-05-05 14:27:47'),
(20, 15, 4, 0, '2026-05-05 14:35:55'),
(21, 16, 4, 0, '2026-05-05 14:44:35'),
(22, 17, 4, 0, '2026-05-05 14:50:28'),
(26, 19, 4, 0, '2026-05-05 14:59:47'),
(27, 20, 4, 0, '2026-05-05 15:03:05'),
(28, 21, 4, 0, '2026-05-06 09:08:16'),
(29, 22, 6, 0, '2026-05-06 10:11:38'),
(30, 23, 6, 0, '2026-05-06 10:35:01'),
(31, 23, 11, 0, '2026-05-06 10:35:08'),
(32, 25, 11, 0, '2026-05-06 11:35:05'),
(33, 24, 4, 0, '2026-05-06 11:35:06'),
(34, 18, 4, 0, '2026-05-06 11:59:54'),
(35, 26, 1, 0, '2026-05-06 14:26:25'),
(36, 27, 11, 0, '2026-05-06 14:35:22'),
(37, 28, 6, 0, '2026-05-06 14:41:38'),
(38, 5, 5, 0, '2026-05-06 16:34:58'),
(39, 2, 5, 0, '2026-05-06 16:35:14'),
(40, 29, 4, 0, '2026-05-07 09:26:25'),
(41, 29, 6, 0, '2026-05-07 09:26:33'),
(42, 30, 11, 0, '2026-05-07 11:18:14'),
(43, 31, 4, 0, '2026-05-07 11:20:54'),
(44, 32, 11, 0, '2026-05-07 13:21:56'),
(45, 33, 11, 0, '2026-05-07 14:07:26'),
(46, 34, 11, 0, '2026-05-07 14:10:18'),
(47, 35, 4, 0, '2026-05-07 14:11:45'),
(48, 36, 4, 0, '2026-05-08 09:35:58'),
(49, 37, 6, 0, '2026-05-08 09:41:31'),
(50, 38, 11, 0, '2026-05-08 10:16:40'),
(51, 39, 4, 0, '2026-05-08 11:40:36'),
(52, 40, 11, 0, '2026-05-08 11:56:31'),
(53, 41, 4, 0, '2026-05-08 13:34:04'),
(54, 42, 6, 0, '2026-05-08 14:40:23'),
(55, 44, 4, 0, '2026-05-11 08:22:18'),
(56, 45, 6, 0, '2026-05-11 09:05:25'),
(57, 46, 11, 0, '2026-05-11 09:23:43'),
(58, 47, 4, 0, '2026-05-11 09:28:09'),
(59, 17, 11, 0, '2026-05-11 09:46:14'),
(60, 48, 4, 0, '2026-05-11 10:17:53'),
(61, 49, 11, 0, '2026-05-11 10:26:10'),
(62, 49, 6, 0, '2026-05-11 10:26:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketevidencia`
--

CREATE TABLE `ticketevidencia` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `ticketevidencia` varchar(255) NOT NULL,
  `fecha_subida` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ticketevidencia`
--

INSERT INTO `ticketevidencia` (`id`, `id_ticket`, `ticketevidencia`, `fecha_subida`) VALUES
(3, 36, 'vistas/img/evidencias/69fdebfdcdfb2_36_20260508_095821.jpg', '2026-05-08 09:58:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketservicios`
--

CREATE TABLE `ticketservicios` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_servicios` int(11) NOT NULL,
  `ticketservicios` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `id_item` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ticketservicios`
--

INSERT INTO `ticketservicios` (`id`, `id_ticket`, `id_servicios`, `ticketservicios`, `fecha`, `id_item`, `descripcion`, `cantidad`) VALUES
(1, 3, 2, 0, '2026-05-05 10:55:31', 2, '', 1),
(2, 9, 10, 0, '2026-05-05 13:30:17', 6, '', 1),
(3, 11, 11, 0, '2026-05-05 13:53:50', 5, '', 1),
(4, 12, 12, 0, '2026-05-05 14:08:14', 6, '', 1),
(5, 13, 13, 0, '2026-05-05 14:24:15', 7, '', 2),
(6, 14, 15, 0, '2026-05-05 14:30:36', 1, '', 1),
(7, 15, 16, 0, '2026-05-05 14:39:02', 2, '', 1),
(8, 16, 18, 0, '2026-05-05 14:46:12', 2, '', 1),
(9, 17, 15, 0, '2026-05-05 14:53:43', 1, '', 9),
(10, 18, 13, 0, '2026-05-05 14:58:12', 5, '', 1),
(11, 19, 10, 0, '2026-05-05 15:01:11', 1, '', 1),
(12, 22, 29, 0, '2026-05-06 10:20:57', 4, '', 1),
(13, 21, 35, 0, '2026-05-06 11:35:54', 5, '', 1),
(14, 21, 23, 0, '2026-05-06 11:39:35', 1, '', 1),
(15, 23, 15, 0, '2026-05-06 11:43:12', 4, '', 2),
(16, 23, 15, 0, '2026-05-06 11:43:43', 2, '', 1),
(17, 24, 36, 0, '2026-05-06 11:47:35', 5, 'Se examinó el equipo y se comprobó la existencia de los drivers previamente descargados, se configuro desde cero y se comprobó que funcionara con normalidad.', 1),
(23, 25, 30, 0, '2026-05-06 12:27:49', 8, 'Se le agrego a la red de Pfsense y se le dio acceso a la red de wifi 1x10, instituto de cultura y seguridad policial.', 1),
(26, 10, 38, 0, '2026-05-06 14:36:20', 9, 'Se le realizo un evaluacion física en la misma observan marcas de humedad, presenta quemadura del IC del regulador de voltaje, esto se debe a que sufrió una sobretensión.\r\n\r\nse recomienda la sustitución del mismo.', 1),
(27, 27, 30, 0, '2026-05-06 14:40:02', 8, 'Se le dio Acceso a la red del Pfsense temporal hasta las 3pm con la red Wifi de 1x10, el usuario es Fiscal del Seguro Social.', 1),
(28, 7, 38, 0, '2026-05-06 14:41:56', 9, 'Presenta quemadura del IC debido a una falla de energia.\r\nse recomienda la sustitucion del mismo.', 1),
(29, 1, 39, 0, '2026-05-06 14:48:29', 10, 'Tras realizar la inspección técnica del mouse, se identificó un desgaste físico significativo en sus componentes. Posteriormente, se efectuó el trasplante de la placa lógica (PCB) hacia una unidad de prueba con el fin de descartar posibles fallas de hardware en el equipo de destino; no obstante, el resultado de las pruebas cruzadas fue negativo, confirmando la persistencia del fallo técnico.\r\n\r\nSe recomienda su inmediato reemplazo. ', 1),
(30, 28, 34, 0, '2026-05-06 14:51:05', 10, 'El router de la Sala Situacional ubicada en to piso presentaba fallos en la velocidad de conexión con velocidades de 3 Mbps en bajada y 4 Mbps en subida, luego de revisarse el dispositivo y el sitio dónde estaba ubicado se determinó que el lugar donde reposaba el router al ser hecho de metal y presentar estática casaba interferencia en la señal. Se procedió a cambiar el router de ubicación a un punto diferente, mejorando considerablemente el rendimiento.', 1),
(31, 6, 39, 0, '2026-05-06 15:04:51', 10, 'Se realizo limpieza del router y mantenimiento del software del mismo, configurandolo de fabrica, para su correcto funcionamiento.\r\nSe recomienda conectarlo a un regulador de voltaje.', 1),
(32, 29, 51, 0, '2026-05-07 10:53:36', 12, 'se reviso el sistema de camara  del equipo drv y la camara la cual es una sola y sufrio daños por apagon electrico y no enciende led rojo de energia. lo demas del equipo drv hace su funcion y reguladores electricos.', 1),
(33, 29, 25, 0, '2026-05-07 10:55:23', 1, 'se realizo mantenimiento al cpu ya que no tenia energia despues del mantenimiento este arranco y realizando su funcion operando con normalidad', 1),
(34, 26, 52, 0, '2026-05-07 11:34:22', 14, 'Se dio el apoyo con el préstamo de un Video Beam el cual fue retirado el día 06/05/2026 y entregado el dia 07/05/2026', 1),
(35, 30, 15, 0, '2026-05-07 12:11:08', 1, 'Se realizó una auditoría preventiva en las estaciones de trabajo, identificando 5 equipos con servicios VPN activos por configuración predeterminada. Se procedió con la desactivación y normalización de las interfaces de red para garantizar el cumplimiento de las políticas de seguridad de la organización', 10),
(36, 32, 31, 0, '2026-05-07 14:12:35', 8, 'Se cambio la  Mac, por adquisición de nuevo equipo, se configuro la ip, la mascara de sud-red, la puerta de enlace todo de manera manual y así pudo tener acceso a la red.', 1),
(37, 33, 44, 0, '2026-05-07 14:17:13', 2, 'Se le configuro la IP y el Dns de forma Manual, y asi volvio a tener conectividad', 1),
(38, 34, 15, 0, '2026-05-07 14:23:02', 8, 'La persona estaba baneado desde el día 4/05/2026, se Procedió el día de hoy y se saco de la lista de baneado, se le dio instrucciones de que no estén utilizando mas el vpn', 1),
(39, 35, 26, 0, '2026-05-07 15:06:59', 17, 'Se realizo el servicio solicitado y se encontró que el monitor estaba apagado por lo cual se procedió a encender y al encenderlo se encontró que el cable de vídeo estaba fallando y se sustituyo', 1),
(40, 37, 33, 0, '2026-05-08 09:46:16', 20, 'Se colocó  la antena Omada Nro 6 para dar conexión inalámbrica a la actividad del día de hoy 08/05/2026 del día de las madres.', 1),
(41, 36, 54, 0, '2026-05-08 09:55:56', 1, 'Equipo no dejaba modificar letras, celdas, ni ningun elemento del paquete office, específicamente en la aplicación de Excel, se observo que el documento estaba en *VISTA PROTEGIDA* , a lo cual se modificó y realizo su tarea con normalidad. ', 1),
(42, 38, 15, 0, '2026-05-08 10:21:57', 1, 'Se revisaron 2 equipos atendiendo la solicitud de revisión para verificar la posible existencia de un VPN instalado o configurado. En conclusión se determinó que el sistema operativo Win7 de cada equipo funciona sin restricciones ni bloqueos.', 2),
(43, 5, 55, 0, '2026-05-08 10:38:53', 21, 'se cancela el servicio debido a que la misma será atendida por el personal de informática de SEVIGEA. \r\nnota: queda en cuenta que cualquier ayuda que requieran de la Dirección de AIT queda presto para ayudarlo o asistirlo cuando lo requieran.', 1),
(44, 2, 57, 0, '2026-05-08 11:10:25', 18, 'Esperando por conector RJ45', 1),
(45, 39, 11, 0, '2026-05-08 11:57:39', 5, 'Reconexión de impresora en Red a equipo de cómputo (No había seleccionado la que era ) por lo tanto se modificó, y se dejó como predeterminada, para evitar en un futuro incidentes, se conectó con normalidad y realizó sus funciones. ', 1),
(46, 40, 58, 0, '2026-05-08 12:05:18', 4, 'Se revisó la configuración de la conexión wifi en el celular del usuario y se procedió a cambiar el estado Aleatorio de la MAC a estado Fijo del dispositivo. Se comprobó conexión y navegación. ', 1),
(47, 37, 59, 0, '2026-05-08 12:08:49', 20, 'Se colocó un nuevo SSID  a la antena Omada Nro 6 luego de ser reiniciada para dar conexión al evento.', 1),
(48, 41, 26, 0, '2026-05-08 13:44:24', 17, 'El usuario comentó que se le cayó una carpeta encima del teclado y este presionó varias teclas, formando un comando (Alt+ Shift+Impr pant) haciendo que la pantalla se oscureciera (en alto consumo), se solucionó el problema ingresado el comando y funcionó con normalidad. ', 1),
(49, 45, 33, 0, '2026-05-11 09:18:34', 20, 'Se instaló una antena omada outdoor 650 tplink, para proporcionar servicio de inetrnet a la actividad Jornada Médico Asistencial. Todo en orden a la espera de la desintalación', 1),
(50, 46, 31, 0, '2026-05-11 09:30:55', 8, 'Se hizo un cambio de Mac en el Pfsense.', 1),
(51, 46, 37, 0, '2026-05-11 09:32:35', 8, 'Se le agrego la SSID a Celular de Sociedad de Garantía', 1),
(52, 47, 14, 0, '2026-05-11 10:04:22', 1, 'falla en el registro del sistema operativo  arrojaba error se soluciono con un programa antivirus..360 antivirus.', 1),
(53, 49, 31, 0, '2026-05-11 11:00:35', 8, 'Se Procedió hacer cambio de Mac, se Sustituyo la Mac Nueva por la vieja', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketstatus`
--

CREATE TABLE `ticketstatus` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `ticketstatus` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ticketstatus`
--

INSERT INTO `ticketstatus` (`id`, `id_ticket`, `id_status`, `ticketstatus`, `fecha`) VALUES
(1, 1, 3, 0, '2026-05-05 10:34:16'),
(2, 2, 5, 0, '2026-05-05 10:46:19'),
(3, 3, 4, 0, '2026-05-05 10:54:23'),
(4, 4, 3, 0, '2026-05-05 10:59:00'),
(5, 5, 4, 0, '2026-05-05 11:08:54'),
(6, 5, 2, 0, '2026-05-05 11:10:03'),
(7, 6, 2, 0, '2026-05-05 11:17:04'),
(8, 7, 2, 0, '2026-05-05 11:23:32'),
(9, 8, 4, 0, '2026-05-05 11:40:25'),
(10, 9, 4, 0, '2026-05-05 13:26:13'),
(11, 4, 4, 0, '2026-05-05 13:33:15'),
(12, 10, 2, 0, '2026-05-05 13:34:37'),
(13, 11, 4, 0, '2026-05-05 13:42:18'),
(14, 12, 4, 0, '2026-05-05 13:59:45'),
(15, 13, 4, 0, '2026-05-05 14:12:43'),
(16, 14, 4, 0, '2026-05-05 14:28:18'),
(17, 15, 4, 0, '2026-05-05 14:36:18'),
(18, 16, 4, 0, '2026-05-05 14:44:51'),
(19, 17, 4, 0, '2026-05-05 14:52:46'),
(20, 18, 4, 0, '2026-05-05 14:58:01'),
(21, 19, 4, 0, '2026-05-05 15:00:08'),
(22, 20, 4, 0, '2026-05-05 15:03:28'),
(23, 21, 3, 0, '2026-05-06 09:08:35'),
(24, 22, 4, 0, '2026-05-06 10:18:48'),
(25, 5, 5, 0, '2026-05-06 10:25:32'),
(26, 23, 3, 0, '2026-05-06 10:37:14'),
(27, 23, 4, 0, '2026-05-06 11:10:16'),
(28, 21, 4, 0, '2026-05-06 11:29:25'),
(29, 24, 4, 0, '2026-05-06 11:40:27'),
(30, 25, 3, 0, '2026-05-06 11:44:49'),
(31, 10, 4, 0, '2026-05-06 11:49:28'),
(32, 25, 4, 0, '2026-05-06 11:50:05'),
(33, 26, 3, 0, '2026-05-06 14:26:44'),
(34, 27, 3, 0, '2026-05-06 14:36:00'),
(35, 7, 4, 0, '2026-05-06 14:39:44'),
(36, 27, 4, 0, '2026-05-06 14:40:12'),
(37, 6, 4, 0, '2026-05-06 14:44:19'),
(38, 1, 4, 0, '2026-05-06 14:45:48'),
(39, 28, 4, 0, '2026-05-06 14:51:17'),
(40, 29, 3, 0, '2026-05-07 09:27:20'),
(41, 29, 4, 0, '2026-05-07 10:44:25'),
(42, 26, 4, 0, '2026-05-07 11:28:43'),
(43, 30, 3, 0, '2026-05-07 11:58:10'),
(44, 30, 4, 0, '2026-05-07 12:11:17'),
(45, 32, 3, 0, '2026-05-07 13:42:59'),
(46, 32, 4, 0, '2026-05-07 14:12:43'),
(47, 33, 3, 0, '2026-05-07 14:13:00'),
(48, 33, 4, 0, '2026-05-07 14:17:21'),
(49, 34, 3, 0, '2026-05-07 14:17:36'),
(50, 34, 4, 0, '2026-05-07 14:23:17'),
(51, 35, 4, 0, '2026-05-07 14:56:27'),
(52, 37, 3, 0, '2026-05-08 09:43:35'),
(53, 36, 4, 0, '2026-05-08 09:50:37'),
(54, 38, 4, 0, '2026-05-08 10:18:18'),
(55, 5, 4, 0, '2026-05-08 10:39:18'),
(56, 39, 4, 0, '2026-05-08 11:55:35'),
(57, 40, 4, 0, '2026-05-08 11:58:26'),
(58, 41, 3, 0, '2026-05-08 13:34:24'),
(59, 41, 4, 0, '2026-05-08 13:41:28'),
(60, 45, 4, 0, '2026-05-11 09:16:56'),
(61, 46, 3, 0, '2026-05-11 09:27:17'),
(62, 44, 3, 0, '2026-05-11 09:31:43'),
(63, 46, 4, 0, '2026-05-11 09:32:47'),
(64, 45, 3, 0, '2026-05-11 10:00:25'),
(65, 47, 4, 0, '2026-05-11 10:02:21'),
(66, 31, 3, 0, '2026-05-11 10:07:41'),
(67, 42, 6, 0, '2026-05-11 10:12:24'),
(68, 37, 4, 0, '2026-05-11 10:14:22'),
(69, 49, 3, 0, '2026-05-11 10:54:36'),
(70, 49, 4, 0, '2026-05-11 11:01:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketusuario`
--

CREATE TABLE `ticketusuario` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `ticketusuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ticketusuario`
--

INSERT INTO `ticketusuario` (`id`, `id_ticket`, `id_usuario`, `ticketusuario`, `fecha`) VALUES
(1, 1, 191, 0, '2026-05-05 10:35:47'),
(2, 2, 187, 0, '2026-05-05 10:46:10'),
(3, 3, 179, 0, '2026-05-05 10:54:15'),
(4, 4, 193, 0, '2026-05-05 10:58:48'),
(5, 5, 183, 0, '2026-05-05 11:08:35'),
(6, 6, 191, 0, '2026-05-05 11:16:32'),
(7, 7, 191, 0, '2026-05-05 11:23:18'),
(8, 8, 183, 0, '2026-05-05 11:39:42'),
(9, 9, 188, 0, '2026-05-05 13:25:35'),
(10, 10, 192, 0, '2026-05-05 13:34:29'),
(11, 11, 191, 0, '2026-05-05 13:42:04'),
(12, 12, 192, 0, '2026-05-05 13:58:31'),
(13, 12, 183, 0, '2026-05-05 13:58:37'),
(14, 12, 194, 0, '2026-05-05 13:59:28'),
(15, 13, 193, 0, '2026-05-05 14:12:30'),
(16, 14, 185, 0, '2026-05-05 14:27:57'),
(17, 14, 192, 0, '2026-05-05 14:28:06'),
(18, 15, 192, 0, '2026-05-05 14:36:09'),
(19, 16, 191, 0, '2026-05-05 14:44:44'),
(20, 17, 192, 0, '2026-05-05 14:51:04'),
(22, 18, 190, 0, '2026-05-05 14:57:43'),
(23, 19, 179, 0, '2026-05-05 15:00:01'),
(24, 20, 191, 0, '2026-05-05 15:03:18'),
(25, 21, 192, 0, '2026-05-06 09:08:28'),
(27, 21, 190, 0, '2026-05-06 10:03:37'),
(28, 22, 189, 0, '2026-05-06 10:18:41'),
(29, 23, 185, 0, '2026-05-06 10:36:38'),
(31, 23, 192, 0, '2026-05-06 11:09:19'),
(32, 25, 185, 0, '2026-05-06 11:35:13'),
(33, 24, 192, 0, '2026-05-06 11:40:15'),
(34, 25, 189, 0, '2026-05-06 11:44:41'),
(35, 10, 191, 0, '2026-05-06 11:49:44'),
(36, 26, 204, 0, '2026-05-06 14:26:34'),
(37, 27, 185, 0, '2026-05-06 14:35:38'),
(39, 7, 192, 0, '2026-05-06 14:39:35'),
(40, 28, 189, 0, '2026-05-06 14:41:44'),
(41, 28, 190, 0, '2026-05-06 14:44:23'),
(42, 29, 191, 0, '2026-05-07 09:26:46'),
(43, 29, 190, 0, '2026-05-07 09:27:14'),
(44, 30, 185, 0, '2026-05-07 11:58:37'),
(45, 30, 190, 0, '2026-05-07 11:58:47'),
(46, 32, 185, 0, '2026-05-07 13:22:03'),
(47, 31, 191, 0, '2026-05-07 13:32:21'),
(48, 33, 185, 0, '2026-05-07 14:07:35'),
(49, 34, 185, 0, '2026-05-07 14:10:24'),
(50, 35, 193, 0, '2026-05-07 14:55:41'),
(51, 5, 194, 0, '2026-05-08 08:51:47'),
(52, 37, 190, 0, '2026-05-08 09:42:18'),
(53, 37, 189, 0, '2026-05-08 09:42:31'),
(54, 36, 192, 0, '2026-05-08 09:50:29'),
(55, 38, 184, 0, '2026-05-08 10:17:54'),
(56, 39, 192, 0, '2026-05-08 11:55:12'),
(57, 40, 184, 0, '2026-05-08 11:58:13'),
(58, 41, 192, 0, '2026-05-08 13:34:16'),
(59, 45, 190, 0, '2026-05-11 09:16:39'),
(60, 45, 189, 0, '2026-05-11 09:16:46'),
(61, 46, 185, 0, '2026-05-11 09:26:07'),
(62, 46, 189, 0, '2026-05-11 09:26:53'),
(63, 44, 192, 0, '2026-05-11 09:31:25'),
(64, 17, 185, 0, '2026-05-11 09:46:22'),
(65, 47, 191, 0, '2026-05-11 10:02:08'),
(66, 49, 185, 0, '2026-05-11 10:26:43'),
(68, 49, 190, 0, '2026-05-11 10:27:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocs`
--

CREATE TABLE `tipodocs` (
  `id` int(11) NOT NULL,
  `tipodocs` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipodocs`
--

INSERT INTO `tipodocs` (`id`, `tipodocs`, `estado`, `modificacion`, `fecha`) VALUES
(1, 'HORAS EXTRAS', 1, '2026-05-05 12:11:18', '2026-05-05 12:11:18'),
(2, 'ACTA DE JUGUETES', 1, '2026-05-05 14:28:30', '2026-05-05 14:28:30'),
(3, 'ACTA PLAN VACACIONAL', 1, '2026-05-05 14:28:46', '2026-05-05 14:28:46'),
(4, 'OFICIO', 1, '2026-05-05 14:52:41', '2026-05-05 14:52:41'),
(5, 'CERTIFICACION DE PERSONAL', 1, '2026-05-05 14:52:48', '2026-05-05 14:52:48'),
(6, 'CIRCULAR', 1, '2026-05-05 14:52:55', '2026-05-05 14:52:55'),
(7, 'MEMORANDO', 1, '2026-05-05 17:54:49', '2026-05-05 17:54:49'),
(8, 'BOLETA DE VACACIONES', 1, '2026-05-06 13:48:50', '2026-05-06 13:48:50'),
(9, 'SOLICITUD MATERIAL DE OFICINA', 1, '2026-05-06 14:15:42', '2026-05-06 14:15:42'),
(10, 'SOLICITUD MATERIAL DE LIMPIEZA', 1, '2026-05-06 14:15:51', '2026-05-06 14:15:51'),
(11, 'SOLICITUD MATERIAL ELECTRICO', 1, '2026-05-06 14:16:06', '2026-05-06 14:16:06'),
(12, 'SOLICITUD EQUIPOS ELECTRONICOS', 1, '2026-05-06 14:16:18', '2026-05-06 14:16:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` text NOT NULL,
  `id_coordinacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_apoyo` int(11) DEFAULT NULL,
  `perfil` text NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido`, `foto`, `id_coordinacion`, `id_apoyo`, `perfil`, `estado`, `ultimo_login`, `fecha`) VALUES
(1, 'admin', '$2y$10$Qr4jZdFClz/oX88XVx.P2eGoHf.f7KeplVcCxGM4o2NMDtulbCtqG', 'admin', 'admin', 'vistas/img/usuarios/admin260415-201347admin.jpeg', '1', NULL, 'Administrador', 0, '2026-04-27 12:06:36', '2026-05-07 04:24:03'),
(178, 'dcacharuco', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'BR. Dairy', 'Cacharuco', 'vistas/img/usuarios/dcacharuco260421-172456dcacharuco.jpeg', '9', NULL, 'Tecnico', 1, '2026-05-08 08:37:20', '2026-05-08 13:37:20'),
(179, 'stapisquen', '$2y$10$43O692g82Fm9vWHaw/mCEusHTsxq6eWPlB0aQL2xGj2HY6mheZTN6', 'T.S.U Scarleth', 'Tapisquen', 'vistas/img/usuarios/stapisquen260421-172605stapisquen.jpeg', '9', NULL, 'Tecnico', 1, '2026-05-11 07:05:51', '2026-05-11 12:05:51'),
(183, 'ltapisquen', '$2y$10$giu/7wDSZmlptZ3Vdls8De/thhteTNl8ianJ8W7GQZHGSZeLun2i2', 'ING. Luis', 'Tapisquen', 'vistas/img/usuarios/ltapisquen260421-172536ltapisquen.jpeg', '5', NULL, 'Coordinacion', 1, '2026-05-11 08:27:22', '2026-05-11 13:27:22'),
(184, 'jvillafranca', '$2y$10$prgvzxYnsT7SSIQ0j1rYp.BAavDlmmeplhSNHfsyr7BgGyIFIPZPq', 'ING. Jesús', 'Villafranca', 'vistas/img/usuarios/jvillafranca260421-172554jvillafranca.jpeg', '11', NULL, 'Coordinacion', 1, '2026-05-08 11:08:10', '2026-05-08 17:14:30'),
(185, 'smontilla', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'T.S.U Sachy', 'Montilla', 'vistas/img/usuarios/smontilla/260505-004800smontilla.jpeg', '11', NULL, 'Coordinacion', 1, '2026-05-11 08:24:18', '2026-05-11 13:24:18'),
(186, 'jtocuyo', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'ING. Jesús', 'Tocuyo', 'vistas/img/usuarios/jtocuyo260421-172651jtocuyo.jpeg', '6', NULL, 'Coordinacion', 1, '2026-05-11 09:00:09', '2026-05-11 14:00:10'),
(187, 'agamardo', '$2y$10$clz9o61ZZKHEskqvaazMX.pf6qF/Py6iE1lPFGb7rfghQbqM1PFFW', 'ING. Anyali', 'Gamardo', 'vistas/img/usuarios/agamardo/260505-004818agamardo.jpeg', '12', 5, 'Coordinacion', 1, '2026-05-11 08:22:36', '2026-05-11 13:22:36'),
(188, 'eportillo', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'ING. Erwin', 'Portillo', 'vistas/img/usuarios/eportillo260421-172708eportillo.jpeg', '5', NULL, 'Tecnico', 1, '0000-00-00 00:00:00', '2026-05-06 17:56:44'),
(189, 'rmatiguan', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'ING. Rosalba', 'Matiguan', 'vistas/img/usuarios/rmatiguan260421-172731rmatiguan.jpeg', '6', NULL, 'Tecnico', 1, '2026-05-11 08:29:00', '2026-05-11 13:29:00'),
(190, 'dabad', '$2y$10$L1KWbewUXfU8ESVgBm3cIOAqyrelAYSBnwrwgNbcm9wLi2lvNpEdu', 'TM. Dioberth', 'Abad', 'vistas/img/usuarios/dabad260421-172930dabad.jpeg', '6', NULL, 'Tecnico', 1, '2026-05-06 23:11:38', '2026-05-07 04:11:38'),
(191, 'bvelasquez', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'ING. Boris', 'Velásquez', 'vistas/img/usuarios/bvelasquez/260505-004843bvelasquez.jpeg', '4', NULL, 'Coordinacion', 1, '2026-05-11 09:01:15', '2026-05-11 14:01:15'),
(192, 'rvasquez', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'T.S.U Rossymar', 'Vasquez', 'vistas/img/usuarios/rvasquez260421-172914rvasquez.jpeg', '4', NULL, 'Coordinacion', 1, '2026-05-08 12:40:42', '2026-05-08 17:40:42'),
(193, 'eguaramata', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'TM. Edward', 'Guaramata', 'vistas/img/usuarios/eguaramata260421-172903eguaramata.jpeg', '4', NULL, 'Coordinacion', 1, '2026-05-07 13:55:14', '2026-05-07 18:55:14'),
(194, 'jmartinez', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'ING. José', 'Martinez', 'vistas/img/usuarios/jmartinez260421-172850jmartinez.jpeg', '11', NULL, 'Tecnico', 1, '0000-00-00 00:00:00', '2026-05-06 17:55:58'),
(195, 'mmaestre', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'BR. Mariana', 'Maestre', 'vistas/img/usuarios/mmaestre/260505-004904mmaestre.jpeg', '9', NULL, 'Tecnico', 1, '2026-05-11 07:49:57', '2026-05-11 12:49:57'),
(196, 'ajimenez', '$2y$10$jz0NOOW6M2.oGpYpV.GEjOuDj/4CZKsFb6x9IH6hFm9/TDyGLSt6O', 'T.S.U Anthony', 'Jimenez', 'vistas/img/usuarios/ajimenez260421-173218ajimenez.jpeg', '10', 4, 'Coordinacion', 1, '2026-05-06 23:19:31', '2026-05-07 04:19:31'),
(197, 'mromero', '$2y$10$utjQg.jAIL0gIu0/sd0nzeYKcE5zimCr25DL8Ktm2iu0mU46gb4kq', 'TM. Moisés', 'Romero', 'vistas/img/usuarios/mromero260421-173321mromero.jpeg', '1', NULL, 'Administrador', 1, '2026-05-08 14:06:48', '2026-05-08 19:07:41'),
(198, 'yfernandez', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'LCDA. Yubiri', 'Fernandez', 'vistas/img/usuarios/yfernandez/260505-004931yfernandez.jpeg', '2', NULL, 'Coordinacion', 1, '0000-00-00 00:00:00', '2026-05-06 17:57:42'),
(199, 'amaia', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 'T.S.U Alejandra', 'Maia', 'vistas/img/usuarios/amaia260421-173634amaia.jpeg', '7', NULL, 'Coordinacion', 1, '0000-00-00 00:00:00', '2026-05-06 17:53:13'),
(200, 'ftineo', '$2y$10$R8iffDNXILrrsBfhG/xlJOxK0BrOeGFZ23FUX3RUoKTP39X./Ic2q', 'BR. Fanny', 'Tineo', 'vistas/img/usuarios/ftineo260421-173720ftineo.jpeg', '10', 6, 'Coordinacion', 1, '2026-05-06 23:22:00', '2026-05-07 04:22:18'),
(201, 'jramos', '$2y$10$uXJolDCXexboltwwnxTgU.f1xPKoeHvQFUgZdTDFML0xtmh9mSuKq', 'T.S.U Joaquin', 'Ramos', 'vistas/img/usuarios/jramos260421-173808jramos.jpeg', '7', 4, 'Coordinacion', 1, '2026-05-05 09:37:33', '2026-05-07 04:20:40'),
(202, 'jcarrasquel', '$2y$10$6XPJau7PQgYMmgC2uKUGBOpyGG/y73.PmhZ8V2h/xEKzMHeqrp1uu', 'ING. José', 'Carrasquel', 'vistas/img/usuarios/jcarrasquel/260505-004948jcarrasquel.jpeg', '10', 5, 'Administrador', 1, '2026-04-28 08:46:42', '2026-05-07 04:20:50'),
(203, 'mgarcia', '$2y$10$wVa6VtHnUHiCRF96jkQwtOrpJRNJuiEEmL.FdJS71AwcXXd/KIeT.', 'T.S.U Miguel', 'Garcia', 'vistas/img/usuarios/mgarcia/260505-005017mgarcia.jpeg', '1', NULL, 'Administrador', 1, '2026-05-11 08:57:28', '2026-05-11 13:57:28'),
(204, 'candueza', '$2y$10$NpEGHe8yN8a1aPiikgi3VO6doS.rEyvNTz5ZkIX2TpI7r966/UiN6', 'ING. Carlos', 'Andueza', 'vistas/img/usuarios/candueza/260427-211652candueza.jpeg', '1', NULL, 'Administrador', 1, '2026-04-27 12:10:01', '2026-05-06 17:55:41'),
(205, 'rescate', '$2y$10$s0FCoveeQBrsLD0oMenEm.sApAg0tlcRGG5ta0Uhw0s9dQEKuBQ4S', 'Rescate', 'Ait', '', '1', NULL, 'Administrador', 0, '2026-05-06 23:45:27', '2026-05-07 04:47:22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_coordinacion` (`id_coordinacion`);

--
-- Indices de la tabla `coordinacion`
--
ALTER TABLE `coordinacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entes`
--
ALTER TABLE `entes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medio`
--
ALTER TABLE `medio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_coordinacion` (`id_coordinacion`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticketcoordinacion`
--
ALTER TABLE `ticketcoordinacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticketevidencia`
--
ALTER TABLE `ticketevidencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Indices de la tabla `ticketservicios`
--
ALTER TABLE `ticketservicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticketstatus`
--
ALTER TABLE `ticketstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticketusuario`
--
ALTER TABLE `ticketusuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipodocs`
--
ALTER TABLE `tipodocs`
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
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `coordinacion`
--
ALTER TABLE `coordinacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `entes`
--
ALTER TABLE `entes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `medio`
--
ALTER TABLE `medio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `ticketcoordinacion`
--
ALTER TABLE `ticketcoordinacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `ticketevidencia`
--
ALTER TABLE `ticketevidencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ticketservicios`
--
ALTER TABLE `ticketservicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `ticketstatus`
--
ALTER TABLE `ticketstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `ticketusuario`
--
ALTER TABLE `ticketusuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `tipodocs`
--
ALTER TABLE `tipodocs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`id_coordinacion`) REFERENCES `coordinacion` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ticketevidencia`
--
ALTER TABLE `ticketevidencia`
  ADD CONSTRAINT `ticketevidencia_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
