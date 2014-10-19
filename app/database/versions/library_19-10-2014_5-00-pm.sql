-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-10-2014 a las 16:59:35
-- Versión del servidor: 5.6.15
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `library`
--
CREATE DATABASE IF NOT EXISTS `library` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `library`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assistances`
--

CREATE TABLE IF NOT EXISTS `assistances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `hour_in` time DEFAULT NULL,
  `hour_out` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staffXassistances_idx` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `branches`
--

CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `state`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Biblioteca Central', 'Av. Universitaria 2037', NULL, '2014-10-02 05:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cubicles`
--

CREATE TABLE IF NOT EXISTS `cubicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) NOT NULL,
  `capacity` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `cubicle_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cubiclesXbranches_idx` (`branch_id`),
  KEY `cubiclesXtypeCubicles_idx` (`cubicle_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cubicles_type`
--

CREATE TABLE IF NOT EXISTS `cubicles_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cubicle_reservations`
--

CREATE TABLE IF NOT EXISTS `cubicle_reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hour_in` time DEFAULT NULL,
  `hour_out` time DEFAULT NULL,
  `num_person` int(11) DEFAULT NULL,
  `cubicle_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cubicleReservationXcubicles_idx` (`user_id`),
  KEY `cubicleReservationXcubicles2_idx` (`cubicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `details_purchase_orders`
--

CREATE TABLE IF NOT EXISTS `details_purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `author` varchar(45) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `purchase_order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `details_purchase_ordersXpurchaseOrder1_idx` (`purchase_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolution_periods`
--

CREATE TABLE IF NOT EXISTS `devolution_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_ini` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `max_days_devolution` int(11) DEFAULT NULL,
  `devolution_periodscol` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document_types`
--

CREATE TABLE IF NOT EXISTS `document_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `document_types`
--

INSERT INTO `document_types` (`id`, `name`, `description`) VALUES
(1, 'DNI', 'Documento Nacional de Identificación'),
(2, 'Carné de Extranjería', 'Documento de extranjeros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `general_configurations`
--

CREATE TABLE IF NOT EXISTS `general_configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `ruc` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `logo_path` varchar(45) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `max_hours_loan_cubicle` int(11) DEFAULT NULL,
  `time_suspencion` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `general_configurations`
--

INSERT INTO `general_configurations` (`id`, `name`, `ruc`, `address`, `logo_path`, `description`, `max_hours_loan_cubicle`, `time_suspencion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Biblioteca PUCP', '9768263317', 'Av. Universitaria 123 San Miguel', 'logo-pucp.jpg', 'Biblioteca financiada con dinero del estado', 1, 10, '2014-10-05 05:00:00', '2014-10-11 06:11:22', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loans`
--

CREATE TABLE IF NOT EXISTS `loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expire_at` date DEFAULT NULL,
  `returned_at` date DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materialXloans_idXid_material_idx` (`material_id`),
  KEY `loansXusers_id_userXid_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `loans`
--

INSERT INTO `loans` (`id`, `expire_at`, `returned_at`, `state`, `material_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2014-10-17', NULL, NULL, 24, 1, '2014-10-08 05:00:00', '2014-10-09 23:21:17', NULL),
(2, '2014-10-23', NULL, NULL, 29, 1, '2014-10-08 05:00:00', '2014-10-11 06:00:02', '2014-10-11 06:00:02'),
(3, '2014-10-31', NULL, NULL, 22, 1, '2014-10-08 05:00:00', '2014-10-11 06:00:02', '2014-10-11 06:00:02'),
(4, '2014-10-23', NULL, NULL, 30, 1, '2014-10-08 05:00:00', '2014-10-09 23:30:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `auto_cod` varchar(45) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `author` varchar(45) DEFAULT NULL,
  `editorial` varchar(45) DEFAULT NULL,
  `additional_materials` varchar(256) NOT NULL,
  `num_pages` varchar(45) DEFAULT NULL,
  `edition` varchar(45) DEFAULT NULL,
  `publication_year` year(4) DEFAULT NULL,
  `isbn` varchar(14) NOT NULL,
  `subscription` int(1) DEFAULT NULL,
  `material_type` int(11) NOT NULL,
  `thematic_area` int(11) DEFAULT NULL,
  `shelve_id` int(11) DEFAULT NULL,
  `purchase_order_id` int(11) DEFAULT NULL,
  `available` int(1) DEFAULT '1' COMMENT '1 = esta disponible, Null = no lo esta',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`mid`),
  KEY `material_typeXmaterial_idXid_idx` (`material_type`),
  KEY `materialXshleves_idXid_shelves_idx` (`shelve_id`),
  KEY `materialXdetails_idx` (`purchase_order_id`),
  KEY `materialXthematic_area` (`thematic_area`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118 ;

--
-- Volcado de datos para la tabla `materials`
--

INSERT INTO `materials` (`mid`, `auto_cod`, `title`, `author`, `editorial`, `additional_materials`, `num_pages`, `edition`, `publication_year`, `isbn`, `subscription`, `material_type`, `thematic_area`, `shelve_id`, `purchase_order_id`, `available`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21, 'CASO1412755386', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, 1, '2014-10-08 13:03:06', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(22, 'CASO1412755387', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, NULL, '2014-10-08 13:03:06', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(23, 'CASO1412755388', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, 1, '2014-10-08 13:03:07', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(24, 'CASO1412755389', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, NULL, '2014-10-08 13:03:07', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(25, 'CASO1412755390', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, 1, '2014-10-08 13:03:07', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(26, 'CASO1412755391', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, 1, '2014-10-08 13:03:07', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(27, 'CASO1412755392', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, 1, '2014-10-08 13:03:07', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(28, 'CASO1412755393', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, 1, '2014-10-08 13:03:07', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(29, 'CASO1412755394', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, NULL, '2014-10-08 13:03:07', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(30, 'CASO1412755395', 'Cien años de soledad', 'Gabriel García Márquez', 'tavo', 'CD', '200', '10', 1990, '123456789012', NULL, 1, 1, 1, 1, NULL, '2014-10-08 13:03:08', '2014-10-09 23:19:22', '2014-10-09 23:19:22'),
(32, 'ELHO1412877721', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:01', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(33, 'ELHO1412877722', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:01', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(34, 'ELHO1412877723', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:01', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(35, 'ELHO1412877724', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:01', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(36, 'ELHO1412877725', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:02', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(37, 'ELHO1412877726', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:02', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(38, 'ELHO1412877727', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:02', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(39, 'ELHO1412877728', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:02', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(40, 'ELHO1412877729', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:02', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(41, 'ELHO1412877730', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:02', '2014-10-09 23:33:53', '2014-10-09 23:33:53'),
(42, 'ELHO1412877731', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:02', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(43, 'ELHO1412877732', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:02', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(44, 'ELHO1412877733', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:02', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(45, 'ELHO1412877734', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(46, 'ELHO1412877735', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(47, 'ELHO1412877736', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(48, 'ELHO1412877737', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(49, 'ELHO1412877738', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(50, 'ELHO1412877739', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(51, 'ELHO1412877740', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:33:59', '2014-10-09 23:33:59'),
(52, 'ELHO1412877741', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(53, 'ELHO1412877742', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(54, 'ELHO1412877743', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(55, 'ELHO1412877744', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(56, 'ELHO1412877745', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(57, 'ELHO1412877746', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(58, 'ELHO1412877747', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(59, 'ELHO1412877748', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(60, 'ELHO1412877749', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(61, 'ELHO1412877750', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(62, 'ELHO1412877751', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(63, 'ELHO1412877752', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(64, 'ELHO1412877753', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(65, 'ELHO1412877754', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(66, 'ELHO1412877755', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(67, 'ELHO1412877756', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:03', '2014-10-09 23:02:03', NULL),
(68, 'ELHO1412877757', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:04', '2014-10-09 23:02:04', NULL),
(69, 'ELHO1412877758', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:04', '2014-10-09 23:02:04', NULL),
(70, 'ELHO1412877759', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:04', '2014-10-09 23:02:04', NULL),
(71, 'ELHO1412877760', 'El Hobbit', 'JRR Tolkien', 'Panini', '', '300', '1', 1990, '1234567890', NULL, 1, 3, 2, 1, 1, '2014-10-09 23:02:04', '2014-10-09 23:02:04', NULL),
(73, 'REVI1412989489', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:49', '2014-10-11 06:04:49', NULL),
(74, 'REVI1412989490', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:49', '2014-10-11 06:04:49', NULL),
(75, 'REVI1412989491', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:49', '2014-10-11 06:04:49', NULL),
(76, 'REVI1412989492', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:49', '2014-10-11 06:04:49', NULL),
(77, 'REVI1412989493', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:49', '2014-10-11 06:04:49', NULL),
(78, 'REVI1412989494', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:49', '2014-10-11 06:04:49', NULL),
(79, 'REVI1412989495', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:49', '2014-10-11 06:04:49', NULL),
(80, 'REVI1412989496', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:49', '2014-10-11 06:04:49', NULL),
(81, 'REVI1412989497', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(82, 'REVI1412989498', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(83, 'REVI1412989499', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(84, 'REVI1412989500', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(85, 'REVI1412989501', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(86, 'REVI1412989502', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(87, 'REVI1412989503', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(88, 'REVI1412989504', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(89, 'REVI1412989505', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:08:01', '2014-10-11 06:08:01'),
(90, 'REVI1412989506', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(91, 'REVI1412989507', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(92, 'REVI1412989508', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(93, 'REVI1412989509', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(94, 'REVI1412989510', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(95, 'REVI1412989511', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(96, 'REVI1412989512', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(97, 'REVI1412989513', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(98, 'REVI1412989514', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:50', '2014-10-11 06:04:50', NULL),
(99, 'REVI1412989515', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(100, 'REVI1412989516', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(101, 'REVI1412989517', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(102, 'REVI1412989518', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(103, 'REVI1412989519', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(104, 'REVI1412989520', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(105, 'REVI1412989521', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(106, 'REVI1412989522', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(107, 'REVI1412989523', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(108, 'REVI1412989524', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(109, 'REVI1412989525', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(110, 'REVI1412989526', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(111, 'REVI1412989527', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(112, 'REVI1412989528', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 2, 12, 2, 1, 1, '2014-10-11 06:04:51', '2014-10-11 06:04:51', NULL),
(113, 'REVI1412989615', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 1, 1, 2, 1, 1, '2014-10-11 06:06:55', '2014-10-11 06:06:55', NULL),
(114, 'REVI1412989616', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 1, 1, 2, 1, 1, '2014-10-11 06:06:55', '2014-10-11 06:06:55', NULL),
(115, 'REVI1412989617', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 1, 1, 2, 1, 1, '2014-10-11 06:06:55', '2014-10-11 06:06:55', NULL),
(116, 'REVI1412989618', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 1, 1, 2, 1, 1, '2014-10-11 06:06:55', '2014-10-11 06:06:55', NULL),
(117, 'REVI1412989619', 'Somos', 'incio', 'Panini', '', '300', '10', 1990, '012345678912', NULL, 1, 1, 2, 1, 1, '2014-10-11 06:06:55', '2014-10-11 06:06:55', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_requests`
--

CREATE TABLE IF NOT EXISTS `material_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `author` varchar(45) DEFAULT NULL,
  `editorial` varchar(45) DEFAULT NULL,
  `edition` varchar(45) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `material_request_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userXmaterial_request_idx` (`user_id`),
  KEY `userXmaterial_request2_idx` (`material_request_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_request_types`
--

CREATE TABLE IF NOT EXISTS `material_request_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_reservations`
--

CREATE TABLE IF NOT EXISTS `material_reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_date` date DEFAULT NULL,
  `indent_date` date DEFAULT NULL,
  `expire_at` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materialReservationXmaterial_idx` (`material_id`),
  KEY `materialReservationXuser_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_types`
--

CREATE TABLE IF NOT EXISTS `material_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `flag_phys_dig` int(1) NOT NULL DEFAULT '1' COMMENT 'physic material = 1, digital material = 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `material_types`
--

INSERT INTO `material_types` (`id`, `name`, `description`, `state`, `flag_phys_dig`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Libro', NULL, NULL, 1, '2014-10-04 05:00:00', '2014-10-09 23:36:45', NULL),
(2, 'Revista', NULL, NULL, 1, '2014-10-04 05:00:00', '2014-10-09 23:36:45', NULL),
(3, 'Periódico', NULL, NULL, 1, '2014-10-04 05:00:00', '2014-10-09 23:51:21', NULL),
(4, 'Publicación científica', 'kdufhvskdfvsdf', NULL, 2, '2014-10-04 05:00:00', '2014-10-11 03:38:52', NULL),
(5, 'Enciclopedia', '', NULL, 1, '2014-10-07 07:08:43', '2014-10-09 23:36:45', NULL),
(6, 'Ebook', 'Libro electrónico', NULL, 2, '2014-10-07 07:17:02', '2014-10-09 23:51:21', NULL),
(7, 'Ejemplo', 'kjhadckjhfcaf', NULL, 2, '2014-10-11 06:19:13', '2014-10-11 06:19:22', '2014-10-11 06:19:22'),
(8, 'Super Enciclopedia', '', NULL, 2, '2014-10-11 08:13:49', '2014-10-11 08:13:49', NULL),
(9, 'Goku', '', NULL, 2, '2014-10-11 03:31:09', '2014-10-11 03:31:09', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_typexprofiles`
--

CREATE TABLE IF NOT EXISTS `material_typexprofiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_type_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_typeXprofile1_idx` (`profile_id`),
  KEY `material_typeXprofile2_idx` (`material_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `material_typexprofiles`
--

INSERT INTO `material_typexprofiles` (`id`, `material_type_id`, `profile_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, '2014-10-08 20:43:16', '2014-10-08 20:43:40', '2014-10-08 20:43:40'),
(2, 3, 1, '2014-10-08 20:43:16', '2014-10-08 20:43:40', '2014-10-08 20:43:40'),
(3, 1, 3, '2014-10-11 05:47:18', '2014-10-11 05:47:50', '2014-10-11 05:47:50'),
(4, 2, 3, '2014-10-11 05:47:18', '2014-10-11 05:47:51', '2014-10-11 05:47:51'),
(5, 3, 3, '2014-10-11 05:47:18', '2014-10-11 05:47:51', '2014-10-11 05:47:51'),
(6, 4, 3, '2014-10-11 05:47:19', '2014-10-11 05:47:51', '2014-10-11 05:47:51'),
(7, 1, 3, '2014-10-11 05:47:51', '2014-10-11 05:47:51', NULL),
(8, 2, 3, '2014-10-11 05:47:51', '2014-10-11 05:47:51', NULL),
(9, 3, 3, '2014-10-11 05:47:51', '2014-10-11 05:47:51', NULL),
(10, 4, 3, '2014-10-11 05:47:51', '2014-10-11 05:47:51', NULL),
(11, 6, 3, '2014-10-11 05:47:51', '2014-10-11 05:47:51', NULL),
(12, 5, 4, '2014-10-11 05:51:44', '2014-10-11 05:51:44', NULL),
(13, 6, 4, '2014-10-11 05:51:44', '2014-10-11 05:51:44', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_number` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `lastname` varchar(256) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `document_type` int(11) DEFAULT NULL,
  `nacionality` varchar(45) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_typeXperson_idx` (`document_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `persons`
--

INSERT INTO `persons` (`id`, `doc_number`, `password`, `name`, `lastname`, `birth_date`, `mail`, `address`, `gender`, `phone`, `document_type`, `nacionality`, `remember_token`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '00000000', '$2y$10$rFEINS6g8oJ0TVhT9pXS3eDJL4WmgyRH6Qo3xbEtxd6Uh2v2pFVy6', 'super', 'admin', '2011-05-17', 'superadmin@host.com', NULL, 'M', NULL, 1, NULL, 'J1p9eMkdHiayWK9kwUYj5rr1VCxqN9yXFNFrl4NwJcFTMYuSm85cApDxhKPk', NULL, '2014-10-01 05:00:00', '2014-10-11 08:25:42', NULL),
(2, '47029368', '$2y$10$wQQL2H//6FmBDXxI6fgOTe5gVjcWBb46oolhJQulY7dXoZGHL/WbO', 'Eduardo Antonio', 'Merino Tejada', '2014-04-09', 'eduardo.merino@gmail.com', 'Av. Siempre Viva 742', 'M', '98765543', NULL, 'Peruano', '52VLQp6wUZekrB60Dc84or2oyvmLH40oQSSI3QqX8nhA2MoA4bOGzjGcEXr2', NULL, '2014-10-02 05:00:00', '2014-10-19 20:38:30', NULL),
(3, '72397807', '$2y$10$6bL0jA0/8e7yOaeq39DbQe0ojmtQMCuxURDVLIVoUMlBh/ClHuuTy', 'Diego', 'Maguiño Valencia', '2010-10-13', 'diego.maguino@gmail.com', 'Av. Larcomar 123', 'M', '1234567', 1, 'Peruano', '4XuVfiWxQrKcLtyR8ry8l3Tu2f7ut5dWCAlKNZZzCf7RcQyUmMBgJ26iY8D4', NULL, '2014-10-02 05:00:00', '2014-10-10 21:41:56', NULL),
(4, '44872634', '$2y$10$6bL0jA0/8e7yOaeq39DbQe0ojmtQMCuxURDVLIVoUMlBh/ClHuuTy', 'Gustavo', 'Coronado', '2013-04-17', 'gustavo.coronado@gmail.com', 'Av. La Marina 123', 'F', '1234567', 1, 'Peruano', 'y6HxaJ3WiX3AIPVXLgj3Pnc4nPFAzsTIw2vf3WDfu9vczbLpLg5URho7GsUn', NULL, '2014-10-02 05:00:00', '2014-10-11 05:44:19', NULL),
(5, '45946510', '$2y$10$6bL0jA0/8e7yOaeq39DbQe0ojmtQMCuxURDVLIVoUMlBh/ClHuuTy', 'Luigi', 'Limaylla', '2013-01-21', 'luigi.limaylla@gmail.com', 'Av. Faucett 1567', 'M', '1234567', 1, 'Peruano', 'a0dcD1PwLk7C8x58K6NFeAt151PM04dQpLDHf2R515jtwx5CRy0F6RqsU1Kp', NULL, '2014-10-10 05:00:00', '2014-10-11 05:45:33', NULL),
(6, '72673019', '$2y$10$hvi/oAq2rh5R4xvvk5ZG6e61DCjkAJuCKizwnWjs40mpVT0Nxxjd6', 'Luis Paolo', 'Incio Braganini', '2014-10-29', 'luis.incio@gmail.com', 'Calle Los Conquistadores 475 La Molina', 'F', '4122137', 1, 'Peruano', NULL, NULL, '2014-10-19 17:29:08', '2014-10-19 17:29:08', NULL),
(7, '45458080', '$2y$10$2cxnSLm/0bi8.QWAxmk6duTVchlBMxNwWA8JBCz6fc3tvT14IaAzK', 'Diana', 'Bracamonte Valdivia', '1998-06-02', 'diana_bm@gmail.com', 'Av Los Pinos 234 San Isidro', 'F', '2788575', NULL, 'Peruano', NULL, NULL, '2014-10-19 21:35:41', '2014-10-19 21:46:12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `physical_elements`
--

CREATE TABLE IF NOT EXISTS `physical_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `physical_elementXbranch` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `max_material` int(11) DEFAULT NULL,
  `max_days_loan` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `description`, `max_material`, `max_days_loan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Alumno', 'Perfil de un alumno regular', 2, '3', '2014-10-02 05:00:00', '2014-10-11 05:52:33', NULL),
(2, 'Profesor', 'Perfil de un profesor o catedrático', 4, '6', '2014-10-02 05:00:00', '2014-10-09 23:37:03', NULL),
(3, 'Practicante', '', 2, '3', '2014-10-11 05:47:18', '2014-10-11 05:47:18', NULL),
(4, 'Independiente', '', 5, '10', '2014-10-11 05:51:43', '2014-10-11 05:55:17', '2014-10-11 05:55:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_orders`
--

CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_issue` datetime DEFAULT NULL,
  `expire_at` datetime DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `state` int(11) DEFAULT NULL COMMENT '0 = no revision\\n1 = accepted\\n',
  `supplier_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_orderXsupplier` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `date_issue`, `expire_at`, `description`, `total_amount`, `state`, `supplier_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2014-10-08 00:00:00', '2014-10-29 00:00:00', 'Mi primera orden de compra', 100, NULL, 6, '2014-10-08 05:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Administrador de sistema', 'Personal encargado de la administración del sistema'),
(2, 'Administrador de sede', 'Personal encargado de la administración de una sede'),
(3, 'Bibliotecario', 'Personal encargado de las principales transacciones de préstamos y devoluciones'),
(4, 'Marcador de asistencia', 'Este rol solo tiene acceso al marcado de asistencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shelves`
--

CREATE TABLE IF NOT EXISTS `shelves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shelvesXbranches_idx` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `shelves`
--

INSERT INTO `shelves` (`id`, `code`, `description`, `branch_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ABC123', 'Estante1', 1, '2014-10-08 05:00:00', NULL, NULL),
(2, 'ABC124', 'Estante2', 1, '2014-10-08 05:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` int(11) DEFAULT NULL COMMENT '1 register\\n2 ',
  `person_id` int(11) NOT NULL,
  `turn_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staffXturns_idx` (`turn_id`),
  KEY `staffXrole_idx` (`role_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `staff`
--

INSERT INTO `staff` (`id`, `state`, `person_id`, `turn_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 1, '2014-10-02 05:00:00', NULL, NULL),
(2, 1, 2, 2, 3, '2014-10-02 05:00:00', NULL, NULL),
(3, 1, 3, 1, 2, '2014-10-02 05:00:00', NULL, NULL),
(4, 1, 4, 1, 3, '2014-10-02 05:00:00', '2014-10-10 05:00:00', '2014-10-10 05:00:00'),
(5, 1, 5, 2, 3, '2014-10-10 05:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `ruc` varchar(20) DEFAULT NULL,
  `sales_representative` varchar(256) NOT NULL,
  `address` varchar(256) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cell` varchar(20) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `flag_doner` int(1) DEFAULT NULL COMMENT 'Null = not doner\\n1 is doner',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `ruc`, `sales_representative`, `address`, `phone`, `cell`, `email`, `flag_doner`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Luis Incio', '0123456789', 'Gustavo Coronado', 'Calle Los Álamos 143 San Isidro', '38512732', '994527184', 'luis.incio@gmail.com', 1, '2014-10-06 05:25:26', '2014-10-09 23:36:54', NULL),
(4, 'Lalita Tamayo', '7634102938', 'Karina Chacón', 'Av. Siempre Viva 123', '4826117', '998162770', 'lali.kari@gmail.com', 1, '2014-10-06 05:26:15', '2014-10-09 23:36:54', NULL),
(5, 'Paolo Muñoz', '0987654321', 'Alejo Rodriguez', 'Calle Los Fresnos 789', '6437213', '998162374', 'paolo.alejo@gmail.com', 1, '2014-10-06 05:27:10', '2014-10-11 06:17:32', '2014-10-11 06:17:32'),
(6, 'Lau Chun', '0983154321', 'Luigi Limaylla', 'Calle Las Begonias 098', '4122137', '998362733', 'luigi.limaylla@lauchun.com', NULL, '2014-10-06 05:28:10', '2014-10-09 23:36:54', NULL),
(7, 'Tay Loy', '9121452787', 'Diego Maguiño', 'Calle Los Conquistadores 475 La Molina', '7836567', '994527365', 'diego.maguino@tayloy.com', NULL, '2014-10-06 05:29:37', '2014-10-09 23:36:54', NULL),
(8, 'Panini', '9562817306', 'Eduardo Merino', 'Av. La Mar 123', '4187921', '99756432', 'eduardo.merino@panini.com', NULL, '2014-10-06 08:17:46', '2014-10-09 23:36:54', NULL),
(9, 'Zenia', '123456789', 'Zenia', 'Pueblo libre 123', '7654321', '123456789', 'zenizol@gmail.com', NULL, '2014-10-11 06:13:34', '2014-10-11 06:17:16', NULL),
(10, 'Proveedores S A', '978654312', 'Eduardo', 'Av. Universitaria 123 San Miguel', '38512732', '998362733', 'admin@gmail.com', 1, '2014-10-11 08:18:33', '2014-10-11 08:18:33', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `thematic_areas`
--

CREATE TABLE IF NOT EXISTS `thematic_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `thematic_areas`
--

INSERT INTO `thematic_areas` (`id`, `name`, `description`) VALUES
(1, 'Terror', NULL),
(2, 'Suspenso', NULL),
(3, 'Ciencia ficción', NULL),
(4, 'Romance', NULL),
(5, 'Esoterismo', NULL),
(6, 'Tecnología', NULL),
(7, 'Acción', NULL),
(8, 'Política', NULL),
(9, 'Pedagogía', NULL),
(10, 'Arte', NULL),
(11, 'Medicina', NULL),
(12, 'Economía', NULL),
(13, 'Religión', NULL),
(14, 'Infantil', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turns`
--

CREATE TABLE IF NOT EXISTS `turns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hour_ini` time DEFAULT NULL,
  `hour_end` time DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `turnsXbranches` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `turns`
--

INSERT INTO `turns` (`id`, `hour_ini`, `hour_end`, `name`, `branch_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '08:00:00', '16:00:00', 'Mañana', 1, '2014-10-02 05:00:00', NULL, NULL),
(2, '16:00:00', '23:00:00', 'Tarde', 1, '2014-10-02 05:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `restricted_until` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personXUser_idXid_idx` (`id`),
  KEY `profileXuser_idprofileXuser_idx` (`profile_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `profile_id`, `person_id`, `restricted_until`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 2, NULL, '2014-10-02 05:00:00', '2014-10-19 21:56:09', NULL),
(2, 1, 4, NULL, '2014-10-10 05:00:00', '2014-10-19 21:56:07', NULL),
(3, 2, 6, NULL, '2014-10-19 17:37:55', '2014-10-19 19:34:49', '2014-10-19 19:34:49'),
(4, 1, 7, NULL, '2014-10-19 21:44:03', '2014-10-19 21:49:34', NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `assistances`
--
ALTER TABLE `assistances`
  ADD CONSTRAINT `assistancesXstaff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Filtros para la tabla `cubicles`
--
ALTER TABLE `cubicles`
  ADD CONSTRAINT `cubiclesXbranches` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `cubiclesXcubicle_type` FOREIGN KEY (`cubicle_type_id`) REFERENCES `cubicles_type` (`id`);

--
-- Filtros para la tabla `cubicle_reservations`
--
ALTER TABLE `cubicle_reservations`
  ADD CONSTRAINT `cubicle_reservationXcubicle` FOREIGN KEY (`cubicle_id`) REFERENCES `cubicles` (`id`),
  ADD CONSTRAINT `cubicle_reservationXuser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `details_purchase_orders`
--
ALTER TABLE `details_purchase_orders`
  ADD CONSTRAINT `detailXpurchase_order` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`);

--
-- Filtros para la tabla `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loansXmaterial` FOREIGN KEY (`material_id`) REFERENCES `materials` (`mid`),
  ADD CONSTRAINT `loansXuser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materialXmaterial_type` FOREIGN KEY (`material_type`) REFERENCES `material_types` (`id`),
  ADD CONSTRAINT `materialXpurchase_order` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `materialXshelves` FOREIGN KEY (`shelve_id`) REFERENCES `shelves` (`id`),
  ADD CONSTRAINT `materialXthematic_area` FOREIGN KEY (`thematic_area`) REFERENCES `thematic_areas` (`id`);

--
-- Filtros para la tabla `material_requests`
--
ALTER TABLE `material_requests`
  ADD CONSTRAINT `material_requestXtype` FOREIGN KEY (`material_request_type_id`) REFERENCES `material_request_types` (`id`),
  ADD CONSTRAINT `material_requestXuser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `material_reservations`
--
ALTER TABLE `material_reservations`
  ADD CONSTRAINT `material_reservationXmaterial` FOREIGN KEY (`material_id`) REFERENCES `materials` (`mid`),
  ADD CONSTRAINT `material_reservationXuser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `material_typexprofiles`
--
ALTER TABLE `material_typexprofiles`
  ADD CONSTRAINT `material_typeXprofile1` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`),
  ADD CONSTRAINT `material_typeXprofile2` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`);

--
-- Filtros para la tabla `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `personsXdocument_type` FOREIGN KEY (`document_type`) REFERENCES `document_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `physical_elements`
--
ALTER TABLE `physical_elements`
  ADD CONSTRAINT `physical_elementXbranch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Filtros para la tabla `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orderXsupplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Filtros para la tabla `shelves`
--
ALTER TABLE `shelves`
  ADD CONSTRAINT `shelvesXbranches` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Filtros para la tabla `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staffXperson` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`),
  ADD CONSTRAINT `staffXroles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `staffXturn` FOREIGN KEY (`turn_id`) REFERENCES `turns` (`id`);

--
-- Filtros para la tabla `turns`
--
ALTER TABLE `turns`
  ADD CONSTRAINT `turnsXbranches` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `usersXpersons` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`),
  ADD CONSTRAINT `usersXprofiles` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
