-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2014 at 09:19 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `assistances`
--

CREATE TABLE IF NOT EXISTS `assistances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `hour_in` time DEFAULT NULL,
  `hour_out` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staffXassistances_idx` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hour_ini` time NOT NULL,
  `hour_end` time NOT NULL,
  `day_ini` int(11) NOT NULL,
  `day_end` int(11) NOT NULL,
  `state` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `hour_ini`, `hour_end`, `day_ini`, `day_end`, `state`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Biblioteca Central', 'Av. Universitaria 2037', '08:00:00', '23:00:00', 1, 5, NULL, '2014-10-02 05:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cubicles`
--

CREATE TABLE IF NOT EXISTS `cubicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `capacity` int(2) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `cubicle_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cubiclesXbranches_idx` (`branch_id`),
  KEY `cubiclesXtypeCubicles_idx` (`cubicle_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cubicle_reservations`
--

CREATE TABLE IF NOT EXISTS `cubicle_reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hour_in` time DEFAULT NULL,
  `hour_out` time DEFAULT NULL,
  `num_person` int(11) DEFAULT NULL,
  `cubicle_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reserved_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cubicleReservationXcubicles_idx` (`user_id`),
  KEY `cubicleReservationXcubicles2_idx` (`cubicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cubicle_types`
--

CREATE TABLE IF NOT EXISTS `cubicle_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cubicle_types`
--

INSERT INTO `cubicle_types` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Cubículo de lectura', 'Para solo una persona', '2014-10-20 05:00:00', NULL, NULL),
(2, 'Cubículo grupal', 'Para grupos de personas', '2014-10-20 05:00:00', NULL, NULL),
(3, 'Cubículo audiovisual', 'Para proyección de material audiovisual', '2014-10-20 05:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `details_purchase_orders`
--

CREATE TABLE IF NOT EXISTS `details_purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `purchase_order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `details_purchase_ordersXpurchaseOrder1_idx` (`purchase_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `devolution_periods`
--

CREATE TABLE IF NOT EXISTS `devolution_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `date_ini` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `max_days_devolution` int(11) DEFAULT NULL,
  `description` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE IF NOT EXISTS `document_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `name`, `description`) VALUES
(1, 'DNI', 'Documento Nacional de Identificación'),
(2, 'Carné de Extranjería', 'Documento de extranjeros');

-- --------------------------------------------------------

--
-- Table structure for table `general_configurations`
--

CREATE TABLE IF NOT EXISTS `general_configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ruc` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_path` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_hours_loan_cubicle` int(11) DEFAULT NULL,
  `time_suspencion` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `general_configurations`
--

INSERT INTO `general_configurations` (`id`, `name`, `ruc`, `address`, `logo_path`, `description`, `max_hours_loan_cubicle`, `time_suspencion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Biblioteca PUCP', '9768263317', 'Av. Universitaria 123 San Miguel', 'logo-pucp.jpg', 'Biblioteca financiada con dinero del estado', 4, 10, '2014-10-05 05:00:00', '2014-10-11 06:11:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE IF NOT EXISTS `holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `base_cod` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `auto_cod` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `editorial` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `additional_materials` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `num_pages` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `edition` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publication_year` year(4) DEFAULT NULL,
  `isbn` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `subscription` int(1) DEFAULT NULL,
  `material_type` int(11) NOT NULL,
  `thematic_area` int(11) DEFAULT NULL,
  `shelve_id` int(11) DEFAULT NULL,
  `purchase_order_id` int(11) DEFAULT NULL,
  `available` int(1) NOT NULL DEFAULT '1' COMMENT '1 = esta disponible, 2 = esta reservado, 3 = esta prestado',
  `to_home` int(1) NOT NULL,
  `date_ini` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `periodicity` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doner` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`mid`),
  KEY `material_typeXmaterial_idXid_idx` (`material_type`),
  KEY `materialXshleves_idXid_shelves_idx` (`shelve_id`),
  KEY `materialXdetails_idx` (`purchase_order_id`),
  KEY `materialXthematic_area` (`thematic_area`),
  KEY `doner` (`doner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=146 ;

-- --------------------------------------------------------

--
-- Table structure for table `material_requests`
--

CREATE TABLE IF NOT EXISTS `material_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `editorial` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `edition` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `material_request_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userXmaterial_request_idx` (`user_id`),
  KEY `userXmaterial_request2_idx` (`material_request_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `material_request_types`
--

CREATE TABLE IF NOT EXISTS `material_request_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `material_request_types`
--

INSERT INTO `material_request_types` (`id`, `name`) VALUES
(1, 'Compra de materiales'),
(2, 'Suscripción');

-- --------------------------------------------------------

--
-- Table structure for table `material_reservations`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `material_types`
--

CREATE TABLE IF NOT EXISTS `material_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `day_penalty` int(3) NOT NULL DEFAULT '0',
  `state` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flag_phys_dig` int(1) NOT NULL DEFAULT '1' COMMENT 'physic material = 1, digital material = 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `material_types`
--

INSERT INTO `material_types` (`id`, `name`, `description`, `day_penalty`, `state`, `flag_phys_dig`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Libro', '', 4, NULL, 1, '2014-10-04 05:00:00', '2014-11-03 19:55:17', NULL),
(2, 'Revista', '', 4, NULL, 1, '2014-10-04 05:00:00', '2014-10-09 23:36:45', NULL),
(3, 'Periódico', '', 4, NULL, 2, '2014-10-04 05:00:00', '2014-10-25 01:13:28', NULL),
(4, 'Publicación científica', '', 4, NULL, 2, '2014-10-04 05:00:00', '2014-10-11 03:38:52', NULL),
(5, 'Enciclopedia', '', 4, NULL, 1, '2014-10-07 07:08:43', '2014-10-09 23:36:45', NULL),
(6, 'Ebook', '', 4, NULL, 2, '2014-10-07 07:17:02', '2014-10-09 23:51:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_typexprofiles`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_11_19_150615_create_password_reminders_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reminders`
--

CREATE TABLE IF NOT EXISTS `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reminders_email_index` (`email`),
  KEY `password_reminders_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_reminders`
--

INSERT INTO `password_reminders` (`email`, `token`, `created_at`) VALUES
('proteus236@gmail.com', '17f77264b68cc728f655c4897f4fc69c999a61f0', '2014-11-19 20:24:27'),
('proteus236@gmail.com', '6889344ebc3c49097a25a2e53b786f29da8820f0', '2014-11-19 21:34:18'),
('proteus236@gmail.com', '2beb1180e17673313e3d0b18cf7359a9aa73f8d2', '2014-11-19 22:01:30'),
('proteus236@gmail.com', '1466fa41c24ae01a2ad5ac0e040c15a9ce82ca0f', '2014-11-19 22:11:47'),
('proteus236@gmail.com', '555787da710ea46bf834cbaeb44790713bb7badd', '2014-11-19 22:12:28');

-- --------------------------------------------------------

--
-- Table structure for table `penalty_periods`
--

CREATE TABLE IF NOT EXISTS `penalty_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `date_ini` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `penalty_days` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `document_type` int(11) DEFAULT NULL,
  `nacionality` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_typeXperson_idx` (`document_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`id`, `doc_number`, `password`, `name`, `lastname`, `birth_date`, `email`, `address`, `gender`, `phone`, `document_type`, `nacionality`, `remember_token`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '00000000', '$2y$10$aHahX1q88aFYb1RcmMfweOpjMwQYNz2WSFX7C7nGwcFwRweVdMGuu', 'Super Admin', 'Webmaster', '2011-05-17', 'superadmin@host.com', '', 'M', '000000', 1, 'Anonimus', 'BjmG5nZzhEoUhC1mbHstSA6F8jKu5DAwbK6Kd0ETgXEZ6ECI3eR9IThuC1Vv', NULL, '2014-10-01 05:00:00', '2014-11-27 17:58:01', NULL),
(15, '47029368', '$2y$10$zUVZG0khtgY/vcsOeMwQN.smntcQ.GYia3muu6nfyGhft9mWNF2A6', 'Eduardo Antonio', 'Merino Tejada', '1991-04-09', 'proteus236@gmail.com', 'Av. Siempre Viva 743', 'M', '98765841', NULL, 'Peruano', NULL, NULL, '2014-11-27 17:57:29', '2014-11-27 21:01:01', NULL),
(16, '47029369', '$2y$10$pRzdpnP1qI/YbeXz.6pm.epEiWVKwRUsfCD5J08yCL32nNhEKeXQS', 'Eduardo Antonio', 'Merino Tejada', '2014-11-13', 'proteus237@gmail.com', 'Av. Siempre Viva 742', 'M', '98765544', 1, 'Peruano', NULL, NULL, '2014-11-27 19:48:52', '2014-11-27 19:48:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `physical_elements`
--

CREATE TABLE IF NOT EXISTS `physical_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `physical_elementXbranch` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_material` int(11) DEFAULT NULL,
  `max_days_loan` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `description`, `max_material`, `max_days_loan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Alumno', 'Perfil de un alumno regular', 2, '3', '2014-10-02 05:00:00', '2014-10-11 05:52:33', NULL),
(2, 'Profesor', 'Perfil de un profesor o catedrático', 4, '6', '2014-10-02 05:00:00', '2014-10-09 23:37:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_issue` datetime DEFAULT NULL,
  `expire_at` datetime DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `state` int(11) DEFAULT NULL COMMENT '0 = no revision\\n1 = accepted\\n',
  `supplier_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_orderXsupplier` (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Administrador de sistema', 'Personal encargado de la administración del sistema'),
(2, 'Administrador de sede', 'Personal encargado de la administración de una sede'),
(3, 'Bibliotecario', 'Personal encargado de las principales transacciones de préstamos y devoluciones'),
(4, 'Marcador de asistencia', 'Este rol solo tiene acceso al marcado de asistencia');

-- --------------------------------------------------------

--
-- Table structure for table `shelves`
--

CREATE TABLE IF NOT EXISTS `shelves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shelvesXbranches_idx` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `shelves`
--

INSERT INTO `shelves` (`id`, `code`, `description`, `branch_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'ESTA001', 'Estante1', 1, '2014-11-27 18:46:56', '2014-11-27 18:46:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `state`, `person_id`, `turn_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 1, '2014-10-02 05:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ruc` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sales_representative` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cell` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `flag_doner` int(1) DEFAULT NULL COMMENT 'Null = not doner\\n1 is doner',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `thematic_areas`
--

CREATE TABLE IF NOT EXISTS `thematic_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `thematic_areas`
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
-- Table structure for table `turns`
--

CREATE TABLE IF NOT EXISTS `turns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hour_ini` time DEFAULT NULL,
  `hour_end` time DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `turnsXbranches` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `turns`
--

INSERT INTO `turns` (`id`, `hour_ini`, `hour_end`, `name`, `branch_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '08:00:00', '23:00:00', 'Horario completo', 1, '2014-10-02 05:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `current_reservations` int(11) NOT NULL DEFAULT '0',
  `restricted_until` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personXUser_idXid_idx` (`id`),
  KEY `profileXuser_idprofileXuser_idx` (`profile_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assistances`
--
ALTER TABLE `assistances`
  ADD CONSTRAINT `assistancesXstaff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `cubicles`
--
ALTER TABLE `cubicles`
  ADD CONSTRAINT `cubiclesXbranches` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `cubiclesXcubicle_type` FOREIGN KEY (`cubicle_type_id`) REFERENCES `cubicle_types` (`id`);

--
-- Constraints for table `cubicle_reservations`
--
ALTER TABLE `cubicle_reservations`
  ADD CONSTRAINT `cubicle_reservationXcubicle` FOREIGN KEY (`cubicle_id`) REFERENCES `cubicles` (`id`),
  ADD CONSTRAINT `cubicle_reservationXuser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `details_purchase_orders`
--
ALTER TABLE `details_purchase_orders`
  ADD CONSTRAINT `detailXpurchase_order` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`);

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loansXmaterial` FOREIGN KEY (`material_id`) REFERENCES `materials` (`mid`),
  ADD CONSTRAINT `loansXuser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materialXdoner` FOREIGN KEY (`doner`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `materialXmaterial_type` FOREIGN KEY (`material_type`) REFERENCES `material_types` (`id`),
  ADD CONSTRAINT `materialXpurchase_order` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `materialXshelves` FOREIGN KEY (`shelve_id`) REFERENCES `shelves` (`id`),
  ADD CONSTRAINT `materialXthematic_area` FOREIGN KEY (`thematic_area`) REFERENCES `thematic_areas` (`id`);

--
-- Constraints for table `material_requests`
--
ALTER TABLE `material_requests`
  ADD CONSTRAINT `material_requestXtype` FOREIGN KEY (`material_request_type_id`) REFERENCES `material_request_types` (`id`),
  ADD CONSTRAINT `material_requestXuser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `material_reservations`
--
ALTER TABLE `material_reservations`
  ADD CONSTRAINT `material_reservationXmaterial` FOREIGN KEY (`material_id`) REFERENCES `materials` (`mid`),
  ADD CONSTRAINT `material_reservationXuser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `material_typexprofiles`
--
ALTER TABLE `material_typexprofiles`
  ADD CONSTRAINT `material_typeXprofile1` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`),
  ADD CONSTRAINT `material_typeXprofile2` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`);

--
-- Constraints for table `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `personsXdocument_type` FOREIGN KEY (`document_type`) REFERENCES `document_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `physical_elements`
--
ALTER TABLE `physical_elements`
  ADD CONSTRAINT `physical_elementXbranch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orderXsupplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `shelves`
--
ALTER TABLE `shelves`
  ADD CONSTRAINT `shelvesXbranches` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staffXperson` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`),
  ADD CONSTRAINT `staffXroles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `staffXturn` FOREIGN KEY (`turn_id`) REFERENCES `turns` (`id`);

--
-- Constraints for table `turns`
--
ALTER TABLE `turns`
  ADD CONSTRAINT `turnsXbranches` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `usersXpersons` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`),
  ADD CONSTRAINT `usersXprofiles` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
