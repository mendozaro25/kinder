-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-06-2023 a las 16:50:27
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbkinder`
--
CREATE DATABASE IF NOT EXISTS `dbkinder` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `dbkinder`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ac_settings`
--

CREATE TABLE `ac_settings` (
  `id` int NOT NULL,
  `s_name` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dt_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ac_settings`
--

INSERT INTO `ac_settings` (`id`, `s_name`, `s_value`, `dt_updated`) VALUES
(1, 'admin_user_id', '61', '2019-10-19 05:57:53'),
(2, 'pagination_limit', '5', '2019-10-19 05:57:53'),
(3, 'include_url', NULL, '2019-10-19 05:57:53'),
(4, 'exclude_url', NULL, '2019-10-19 05:57:53'),
(5, 'img_upload_path', 'assets/upload', '2019-03-06 00:00:00'),
(6, 'assets_path', 'assets', '2019-10-19 05:57:53'),
(8, 'is_groups', '0', '2019-10-19 05:57:53'),
(9, 'groups_table', NULL, '2019-10-19 05:57:53'),
(10, 'groups_col_id', NULL, '2019-10-19 05:57:53'),
(11, 'groups_col_name', NULL, '2019-10-19 05:57:53'),
(12, 'users_table', 'rh_personal', '2019-10-19 05:57:53'),
(13, 'users_col_id', 'id', '2019-10-19 05:57:53'),
(14, 'users_col_email', 'email', '2019-10-19 05:57:53'),
(15, 'ug_table', NULL, '2019-10-19 05:57:53'),
(16, 'ug_col_user_id', NULL, '2019-10-19 05:57:53'),
(17, 'ug_col_group_id', NULL, '2019-10-19 05:57:53'),
(18, 'include_or_exclude', '0', '2019-10-19 05:57:53'),
(19, 'guest_mode', '0', '2019-10-19 05:57:53'),
(20, 'guest_group_id', NULL, '2019-10-19 05:57:53'),
(21, 'site_name', 'MPMC | Chat', '2019-10-19 05:57:53'),
(22, 'theme_colour', NULL, '2019-10-19 05:57:53'),
(23, 'site_logo', NULL, '2019-09-06 08:25:52'),
(24, 'chat_icon', NULL, '2019-09-06 08:24:20'),
(25, 'notification_type', '0', '2019-10-19 05:57:53'),
(26, 'pusher_app_id', NULL, '2019-10-19 05:57:53'),
(27, 'pusher_key', NULL, '2019-10-19 05:57:53'),
(28, 'pusher_secret', NULL, '2019-10-19 05:57:53'),
(29, 'pusher_cluster', NULL, '2019-10-19 05:57:53'),
(30, 'footer_text', 'MPMC | Chat', '2019-10-19 05:57:53'),
(31, 'footer_url', 'javascript:;', '2019-10-19 05:57:53'),
(32, 'hide_email', '0', '2019-11-13 10:44:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int NOT NULL,
  `nombres` varchar(60) DEFAULT NULL,
  `apellidos` varchar(60) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `apoderado_1` int NOT NULL,
  `apoderado_2` varchar(10) DEFAULT NULL,
  `perfil_archivo` varchar(100) DEFAULT NULL,
  `observacion` varchar(80) DEFAULT NULL,
  `created_user_id` int DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL,
  `updated_user_id` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `deleted_datetime` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apoderado`
--

CREATE TABLE `apoderado` (
  `id` int NOT NULL,
  `nombres` varchar(60) DEFAULT NULL,
  `apellidos` varchar(60) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `fecha_nac` date NOT NULL,
  `telefono_1` varchar(9) NOT NULL,
  `telefono_2` varchar(9) DEFAULT NULL,
  `fono_casa` varchar(6) DEFAULT NULL,
  `direccion` varchar(80) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `created_user_id` int DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL,
  `updated_user_id` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `deleted_datetime` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auxiliar`
--

CREATE TABLE `auxiliar` (
  `id` int NOT NULL,
  `nombres` varchar(60) DEFAULT NULL,
  `apellidos` varchar(60) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `fecha_nac` date NOT NULL,
  `nivel_educativo` varchar(10) NOT NULL,
  `experiencia` int DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `created_user_id` int DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL,
  `updated_user_id` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `deleted_datetime` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constante`
--

CREATE TABLE `constante` (
  `idconstante` int NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `valor` varchar(300) DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `orden` int DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `constante`
--

INSERT INTO `constante` (`idconstante`, `codigo`, `valor`, `descripcion`, `orden`, `estado`) VALUES
(4, NULL, NULL, 'Tipo Documento Persona', 0, b'1'),
(4, 'RUC', 'RUC', NULL, 1, b'1'),
(4, 'DNI', 'DNI', NULL, 2, b'1'),
(4, 'S/D', 'SIN DOCUMENTO', NULL, 3, b'1'),
(5, NULL, NULL, 'Tipo Transporte', 0, b'1'),
(5, 'PUB', 'Público', NULL, 1, b'1'),
(5, 'PRI', 'Privado', NULL, 2, b'1'),
(7, NULL, NULL, 'Tipo de Producto', 0, b'1'),
(7, '1', 'Producto', 'Prod', 1, b'1'),
(7, '2', 'Servicio', 'Serv', 1, b'1'),
(11, NULL, NULL, 'Estado de Registros', NULL, b'1'),
(11, '1', 'Activo', NULL, 1, b'1'),
(11, '0', 'Inactivo', NULL, 2, b'1'),
(23, '', '-', 'Condicion Filtro', 0, b'1'),
(23, '=', '=', NULL, 1, b'1'),
(23, '>', '>', NULL, 2, b'1'),
(23, '<', '<', NULL, 3, b'1'),
(23, '>=', '>=', NULL, 4, b'1'),
(23, '<=', '<=', NULL, 5, b'1'),
(24, NULL, NULL, 'Order By Tipo', NULL, b'1'),
(24, 'ASC', 'ASC', NULL, 1, b'1'),
(24, 'DESC', 'DESC', NULL, 2, b'1'),
(27, NULL, NULL, 'Meses', NULL, b'1'),
(27, '01', 'Enero', NULL, 0, b'1'),
(27, '02', 'Febrero', NULL, 1, b'1'),
(27, '03', 'Marzo', NULL, 2, b'1'),
(27, '04', 'Abril', NULL, 3, b'1'),
(27, '05', 'Mayo', NULL, 4, b'1'),
(27, '06', 'Junio', NULL, 5, b'1'),
(27, '07', 'Julio', NULL, 6, b'1'),
(27, '08', 'Agosto', NULL, 7, b'1'),
(27, '09', 'Setiembre', NULL, 8, b'1'),
(27, '10', 'Octubre', NULL, 9, b'1'),
(27, '11', 'Noviembre', NULL, 10, b'1'),
(27, '12', 'Diciembre', NULL, 11, b'1'),
(28, NULL, NULL, 'Tipo de periodo de pago', 0, b'1'),
(28, 'M', 'MENSUAL', '30', 1, b'1'),
(28, 'A', 'ANUAL', '365', 2, b'1'),
(30, NULL, NULL, 'Tipo de forma de pago', 0, b'1'),
(30, 'E', 'EFECTIVO', NULL, 1, b'1'),
(30, 'T', 'TRANSFERENCIA', NULL, 2, b'1'),
(30, 'Y', 'YAPE', NULL, 3, b'1'),
(30, 'P', 'PLIN', NULL, 4, b'1'),
(31, NULL, NULL, 'Tipo de Monedas', 0, b'1'),
(31, 'PEN', 'Soles', 'S/.', 1, b'1'),
(31, 'USD', 'Dólar Americano', '$/.', 2, b'1'),
(32, NULL, NULL, 'Tipo de Bancos', 0, b'1'),
(32, 'BCP', 'BANCO DE CRÉDITO DEL PERÚ', NULL, 1, b'1'),
(32, 'INT', 'INTERBANK', NULL, 2, b'1'),
(33, NULL, NULL, 'Tipo de Proveedores', 0, b'1'),
(33, 'C', 'CLIENTE', NULL, 1, b'1'),
(33, 'P', 'PROVEEDOR', NULL, 2, b'1'),
(33, 'C/P', 'CLIENTE/PROVEEDOR', NULL, 3, b'1'),
(34, NULL, NULL, 'Tipo de Rubro Compras', 0, b'1'),
(34, 'MAT', 'MATERIALES', NULL, 1, b'1'),
(34, 'HER', 'HERRAMIENTAS', NULL, 2, b'1'),
(34, 'EQP', 'EQUIPOS', NULL, 3, b'1'),
(35, NULL, NULL, 'Tipo de Comprobantes', 0, b'1'),
(35, 'FAC', 'FACTURA', NULL, 1, b'1'),
(35, 'BOL', 'BOLETA', NULL, 2, b'1'),
(35, 'S/N', 'SIN COMPROBANTE', NULL, 3, b'1'),
(36, NULL, NULL, 'Tipo de Concepto Prog Pago', 0, b'1'),
(36, 'SRVG', 'SERVICIO DE GUARDERÍA', NULL, 1, b'1'),
(37, NULL, NULL, 'Tipo de Fecha Prog', 0, b'1'),
(37, '30D', '30 DÍAS', '30', 1, b'1'),
(37, '15D', '15 DÍAS', '15', 2, b'1'),
(38, NULL, NULL, 'Tipo de Estado Prog Pago', 0, b'1'),
(38, 'PNT', 'PENDIENTE', NULL, 1, b'1'),
(38, 'PAG', 'PAGADO', NULL, 2, b'1'),
(39, NULL, NULL, 'Dias de Vigencias de Clases', 0, b'1'),
(39, '30D', '30 DÍAS', '30', 1, b'1'),
(40, NULL, NULL, 'Tipo de Menus', 0, b'1'),
(40, '1', 'VISIBLE', NULL, 1, b'1'),
(40, '0', 'NO VISIBLE', NULL, 2, b'1'),
(41, NULL, NULL, 'Tipo de Nivel Educativo', 0, b'1'),
(41, 'EDINI', 'EDUCACIÓN INICIAL', NULL, 1, b'1'),
(41, 'EDPRI', 'EDUCACIÓN PRIMARIA', NULL, 2, b'1'),
(41, 'EDSEC', 'EDUCACIÓN SECUNDARIA', NULL, 3, b'1'),
(41, 'EDTEC', 'EDUCACIÓN TÉCNICO', NULL, 4, b'1'),
(41, 'EDSUP', 'EDUCACIÓN SUPERIOR', NULL, 5, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id` int NOT NULL,
  `nombres` varchar(60) DEFAULT NULL,
  `apellidos` varchar(60) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `fecha_nac` date NOT NULL,
  `nivel_educativo` varchar(10) DEFAULT NULL,
  `experiencia` int DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `created_user_id` int DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL,
  `updated_user_id` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `deleted_datetime` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `parent_id` int DEFAULT NULL,
  `controller` varchar(100) DEFAULT NULL,
  `main_method` varchar(100) DEFAULT NULL,
  `other_method` varchar(300) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `public` bit(1) NOT NULL DEFAULT b'0',
  `external` bit(1) NOT NULL DEFAULT b'0',
  `order` tinyint DEFAULT NULL,
  `tv_visible` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `name`, `display_name`, `description`, `parent_id`, `controller`, `main_method`, `other_method`, `icon`, `status`, `public`, `external`, `order`, `tv_visible`) VALUES
(2, 'users', 'Usuarios', NULL, NULL, 'usuarios', 'usuario', NULL, 'fa fa-users', 1, b'0', b'0', 1, 1),
(62, 'report_403', 'Reporte 403', NULL, NULL, 'errores', 'error403', NULL, NULL, 1, b'0', b'0', 99, 0),
(63, 'dashboard', 'Dashboard', NULL, NULL, 'dashboard', 'index', NULL, NULL, 1, b'0', b'0', 99, 0),
(64, 'perfil', 'Mi Perfil', NULL, NULL, 'me', 'me_view', NULL, NULL, 1, b'0', b'0', 99, 0),
(67, 'config', 'Configuraciones', NULL, NULL, '', '', NULL, 'fa fa-gears', 1, b'0', b'0', 88, 1),
(68, 'menu', 'Menú', NULL, 67, 'menus', 'menu', NULL, '', 1, b'0', b'0', 88, 1),
(69, NULL, 'Alumnos', NULL, NULL, 'alumnos', 'alumno', NULL, 'fa fa-child', 1, b'0', b'0', 6, 1),
(70, NULL, 'Apoderados', NULL, NULL, 'apoderados', 'apoderado', NULL, 'fa fa-male', 1, b'0', b'0', 5, 1),
(71, NULL, 'Auxiliares', NULL, NULL, 'auxiliares', 'auxiliar', NULL, 'fa fa-address-book-o', 1, b'0', b'0', 4, 1),
(72, NULL, 'Docentes', NULL, NULL, 'docentes', 'docente', NULL, 'fa fa-address-book', 1, b'0', b'0', 3, 1),
(73, NULL, 'Sesiones', NULL, NULL, 'sesiones', 'sesion', NULL, 'fa fa-folder-open', 1, b'0', b'0', 6, 1),
(74, NULL, 'Silabos', NULL, NULL, 'silabos', 'silabo', NULL, 'fa fa-file', 1, b'0', b'0', 7, 1),
(75, NULL, 'Prog. Pago', NULL, NULL, 'pagos', 'pago', NULL, 'fa fa-credit-card-alt', 1, b'0', b'0', 8, 1),
(76, NULL, 'Reportes', NULL, NULL, '', '', NULL, 'fa fa-clipboard', 1, b'0', b'0', 77, 1),
(77, NULL, 'Pagos', NULL, 76, 'reports', 'report_pago', NULL, '', 1, b'0', b'0', 77, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_users`
--

CREATE TABLE `menu_users` (
  `user_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `created_datetime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_roles`
--

CREATE TABLE `permission_roles` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progr_pago`
--

CREATE TABLE `progr_pago` (
  `id` int NOT NULL,
  `fecha_reg` date DEFAULT NULL,
  `dias_prog` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `concepto_id` varchar(10) DEFAULT NULL,
  `monto` double DEFAULT NULL,
  `created_user_id` int DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL,
  `updated_user_id` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `deleted_datetime` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_pago_det`
--

CREATE TABLE `prog_pago_det` (
  `id` int NOT NULL,
  `progr_pago_id` int DEFAULT NULL,
  `sesion_id` int DEFAULT NULL,
  `apoderado_id` int DEFAULT NULL,
  `estado_id` varchar(10) DEFAULT NULL,
  `fecha_reg` date DEFAULT NULL,
  `fecha_prog` date DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `monto` double DEFAULT NULL,
  `forma_pago_id` varchar(10) DEFAULT NULL,
  `created_user_id` int DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL,
  `updated_user_id` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `deleted_datetime` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` smallint UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `display_name` varchar(30) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'admin', 'admin', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_users`
--

CREATE TABLE `roles_users` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

CREATE TABLE `sesion` (
  `id` int NOT NULL,
  `docente_id` int DEFAULT NULL,
  `auxiliar_id` varchar(10) DEFAULT NULL,
  `nombre_grupo` varchar(100) DEFAULT NULL,
  `created_user_id` int DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL,
  `updated_user_id` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `deleted_datetime` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion_det`
--

CREATE TABLE `sesion_det` (
  `id` int NOT NULL,
  `sesion_id` int DEFAULT NULL,
  `alumno_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `silabo`
--

CREATE TABLE `silabo` (
  `id` int NOT NULL,
  `sesion_id` int NOT NULL,
  `fecha_reg` date DEFAULT NULL,
  `material_archivo` varchar(100) DEFAULT NULL,
  `fecha_vigencia` date DEFAULT NULL,
  `created_user_id` int DEFAULT NULL,
  `created_datetime` datetime DEFAULT NULL,
  `updated_user_id` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `deleted_datetime` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `phone` varchar(9) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `dni`, `phone`, `photo`, `username`, `password`, `status`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(1, 'JUAN', 'MENDOZA ROMERO', 'jmendozaro73@gmail.com', '71229717', '939971883', '1.jpg', 'admin', '$2y$10$HxAHCedd3uLq5Tysyw7swOMuIBaWaaZFNX2lHdFbnWFe9BvTlnj2e', 1, '2023-03-31 16:22:25', '2023-06-15 22:53:03', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ac_settings`
--
ALTER TABLE `ac_settings`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni_UNIQUE` (`dni`);

--
-- Indices de la tabla `apoderado`
--
ALTER TABLE `apoderado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni_UNIQUE` (`dni`);

--
-- Indices de la tabla `auxiliar`
--
ALTER TABLE `auxiliar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni_UNIQUE` (`dni`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni_UNIQUE` (`dni`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu_users`
--
ALTER TABLE `menu_users`
  ADD PRIMARY KEY (`user_id`,`menu_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD PRIMARY KEY (`role_id`,`permission_id`);

--
-- Indices de la tabla `progr_pago`
--
ALTER TABLE `progr_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prog_pago_det`
--
ALTER TABLE `prog_pago_det`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prog_pago_det_progr_pago1_idx` (`progr_pago_id`),
  ADD KEY `fk_prog_pago_det_apoderado1_idx` (`apoderado_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_user_roles_role_Name` (`name`);

--
-- Indices de la tabla `roles_users`
--
ALTER TABLE `roles_users`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Indices de la tabla `sesion`
--
ALTER TABLE `sesion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sesion_docente1_idx` (`docente_id`),
  ADD KEY `fk_sesion_auxiliar1_idx` (`auxiliar_id`);

--
-- Indices de la tabla `sesion_det`
--
ALTER TABLE `sesion_det`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `silabo`
--
ALTER TABLE `silabo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_silabo_sesion1_idx` (`sesion_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ac_settings`
--
ALTER TABLE `ac_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `apoderado`
--
ALTER TABLE `apoderado`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `auxiliar`
--
ALTER TABLE `auxiliar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `menu_users`
--
ALTER TABLE `menu_users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `progr_pago`
--
ALTER TABLE `progr_pago`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prog_pago_det`
--
ALTER TABLE `prog_pago_det`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sesion`
--
ALTER TABLE `sesion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sesion_det`
--
ALTER TABLE `sesion_det`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `silabo`
--
ALTER TABLE `silabo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
