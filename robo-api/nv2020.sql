-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Jul-2020 às 22:36
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `nv2020`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `budgets`
--

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL,
  `service_orders_id` int(11) NOT NULL,
  `providers_id` int(11) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `date_suggestion` datetime NOT NULL,
  `status` enum('NOVO','RECUSADO','APROVADO') COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `budgets`
--

INSERT INTO `budgets` (`id`, `service_orders_id`, `providers_id`, `value`, `date_suggestion`, `status`, `created`, `modified`) VALUES
(1, 110, 46, '150.00', '2020-03-21 10:00:00', 'NOVO', '2020-03-20 00:48:38', '2020-03-20 00:48:38'),
(2, 111, 48, '1.00', '2020-03-21 12:00:00', 'APROVADO', '2020-03-20 18:33:16', '2020-03-20 19:31:02'),
(3, 112, 45, '200.00', '2020-10-22 10:00:00', 'APROVADO', '2020-03-20 20:20:50', '2020-03-20 20:21:09'),
(4, 113, 45, '300.00', '2020-03-25 10:00:00', 'APROVADO', '2020-03-20 21:42:08', '2020-03-20 21:42:22'),
(5, 114, 46, '500.00', '2020-03-25 11:00:00', 'APROVADO', '2020-03-20 22:20:01', '2020-03-20 22:30:50'),
(6, 115, 47, '1500.00', '2020-04-20 15:00:00', 'APROVADO', '2020-03-27 01:38:34', '2020-03-27 01:39:18'),
(7, 117, 46, '1000.00', '2020-03-28 11:00:00', 'APROVADO', '2020-03-27 01:59:45', '2020-03-27 02:05:50'),
(8, 118, 47, '75.00', '2020-03-30 14:00:00', 'APROVADO', '2020-03-27 04:13:21', '2020-03-27 04:14:37'),
(9, 119, 46, '500.00', '2020-03-31 08:00:00', 'NOVO', '2020-03-27 04:23:51', '2020-03-27 04:23:51'),
(10, 120, 49, '250.00', '2020-03-28 08:00:00', 'APROVADO', '2020-03-27 21:16:13', '2020-03-27 21:16:33'),
(11, 122, 47, '180.00', '2020-03-30 15:00:00', 'APROVADO', '2020-03-27 21:30:44', '2020-03-27 21:35:13'),
(12, 121, 47, '190.00', '2020-03-29 13:00:00', 'APROVADO', '2020-03-27 22:07:00', '2020-03-27 22:07:20'),
(13, 123, 48, '1.50', '2020-03-31 12:00:00', 'APROVADO', '2020-03-30 23:12:44', '2020-03-30 23:35:43'),
(14, 124, 48, '2.00', '2020-02-02 12:00:00', 'APROVADO', '2020-03-31 00:28:56', '2020-03-31 00:29:09'),
(15, 125, 48, '2.22', '2020-02-02 12:00:00', 'APROVADO', '2020-03-31 00:32:16', '2020-03-31 00:32:25'),
(16, 126, 48, '12.34', '2020-02-02 12:00:00', 'APROVADO', '2020-03-31 00:37:41', '2020-03-31 00:37:57'),
(17, 127, 48, '12.34', '2020-02-02 12:00:00', 'APROVADO', '2020-03-31 21:21:30', '2020-03-31 21:21:43'),
(18, 128, 48, '4.50', '2020-02-02 12:00:00', 'APROVADO', '2020-03-31 21:25:53', '2020-03-31 21:26:03'),
(19, 129, 49, '200.00', '2020-04-01 10:00:00', 'APROVADO', '2020-03-31 21:26:34', '2020-03-31 21:26:47'),
(20, 130, 48, '1.50', '2020-04-06 12:00:00', 'APROVADO', '2020-04-05 16:30:04', '2020-04-05 16:30:27'),
(21, 131, 49, '190.00', '2020-04-15 08:00:00', 'APROVADO', '2020-04-06 09:53:47', '2020-04-07 12:30:48'),
(22, 132, 48, '15.00', '1996-06-21 12:00:00', 'NOVO', '2020-04-07 04:40:19', '2020-04-07 04:40:19'),
(23, 137, 47, '45.00', '2020-04-20 14:00:00', 'APROVADO', '2020-04-14 18:19:39', '2020-04-14 18:21:15'),
(24, 138, 56, '300.00', '2020-04-20 08:00:00', 'APROVADO', '2020-04-14 23:20:52', '2020-04-14 23:27:43'),
(25, 139, 57, '100.00', '2020-04-24 10:00:00', 'APROVADO', '2020-04-23 10:39:24', '2020-04-23 10:39:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'check',
  `description_category` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `company_id`, `name`, `url_icon`, `description_category`, `active`, `created`, `modified`) VALUES
(2, 1, 'Papel', 'upload/categories/icones/papel.png', 'Serviços de refrigeração ', 1, '2019-09-07 19:27:32', '2020-03-02 22:38:30'),
(3, 1, 'Latinha', 'upload/categories/icones/latinha.png', NULL, 1, '2019-09-20 19:46:23', '2020-03-02 22:39:25'),
(4, 1, 'Plástico', 'upload/categories/icones/plastico.png', 'Pequenos reparos ', 1, '2019-09-23 21:46:13', '2020-03-02 22:39:35'),
(5, 1, 'PET', 'upload/categories/icones/pet.png', 'Gesso em placas e blocos', 1, '2019-11-21 23:59:13', '2020-03-02 22:39:47'),
(6, 1, 'Vidro', 'upload/categories/icones/vidro.png', 'Troca de tomadas, lampadas, chuveiro eletrico', 1, '2020-01-31 03:01:49', '2020-03-02 22:40:01'),
(7, 1, 'Óleo de Cozinha', 'upload/categories/icones/oleo.png', 'Serviços de alvenaria, Instalação de pisos em cerâmica e porcelanato', 1, '2020-01-31 03:18:35', '2020-03-02 22:41:17'),
(8, 1, 'Misturado', 'upload/categories/icones/misturado.png', 'Cópias de chaves e abertura de portas', 1, '2020-01-31 03:21:54', '2020-03-02 22:42:00'),
(9, 1, 'Metal', 'upload/categories/icones/metal.png', 'Aparelhos eletrônicos', 1, '2020-01-31 03:24:37', '2020-03-02 22:42:25'),
(10, 1, 'Eletrônicos', 'upload/categories/icones/eletronicos.png', 'Pinturas em geral', 1, '2020-01-31 03:53:17', '2020-03-02 22:42:37'),
(11, 1, 'Baterias', 'upload/categories/icones/baterias.png', 'Marcenaria em geral', 1, '2020-01-31 03:57:56', '2020-03-02 22:42:48'),
(12, 1, 'Móveis', 'upload/categories/icones/moveis.png', 'CORTAR GRAMA E PLANTAS', 1, '2020-03-19 03:01:34', '2020-03-19 03:01:34'),
(13, 1, 'Entulho', 'upload/categories/icones/entulho.png', 'TESTE', 1, '2020-06-05 16:27:57', '2020-06-05 16:27:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `acting_region` enum('RN') COLLATE utf8_unicode_ci NOT NULL,
  `companies_id` int(11) NOT NULL,
  `balance` decimal(10,3) NOT NULL DEFAULT 0.000,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `clients`
--

INSERT INTO `clients` (`id`, `person_id`, `acting_region`, `companies_id`, `balance`, `image`, `active`, `created`, `modified`) VALUES
(25, 92, 'RN', 1, '0.000', 'clients/25/perfil.jpg', 1, '2020-03-20 00:35:29', '2020-04-27 23:45:11'),
(26, 91, 'RN', 1, '0.000', NULL, 1, '2020-03-20 01:03:20', '2020-03-20 01:03:20'),
(27, 93, 'RN', 1, '0.000', 'clients/27/perfil.jpg', 1, '2020-03-20 16:46:54', '2020-04-03 15:08:25'),
(28, 94, 'RN', 1, '0.000', NULL, 1, '2020-03-20 20:00:17', '2020-03-20 20:00:17'),
(29, 95, 'RN', 1, '0.000', 'clients/29/perfil.jpg', 1, '2020-03-27 20:45:14', '2020-04-07 10:19:36'),
(30, 97, 'RN', 1, '0.000', NULL, 1, '2020-03-27 21:04:23', '2020-03-27 21:04:23'),
(31, 103, 'RN', 1, '0.000', NULL, 1, '2020-04-07 17:07:15', '2020-04-07 17:07:15'),
(32, 104, 'RN', 1, '0.000', 'clients/32/perfil.jpg', 1, '2020-04-14 22:14:38', '2020-04-14 22:17:24'),
(33, 107, 'RN', 1, '0.000', 'clients/33/perfil.jpg', 1, '2020-04-23 10:31:28', '2020-04-23 10:38:50'),
(34, 108, 'RN', 1, '0.000', NULL, 1, '2020-05-13 14:50:00', '2020-05-13 14:50:00'),
(35, 109, 'RN', 1, '0.000', NULL, 1, '2020-05-25 11:01:42', '2020-05-25 11:01:42'),
(36, 110, 'RN', 1, '0.000', NULL, 1, '2020-05-25 11:16:04', '2020-05-25 11:16:04'),
(37, 111, 'RN', 1, '0.000', NULL, 1, '2020-05-26 11:40:36', '2020-05-26 11:40:36'),
(38, 112, 'RN', 1, '0.000', NULL, 1, '2020-05-26 11:46:26', '2020-05-26 11:46:26'),
(39, 113, 'RN', 1, '0.000', NULL, 1, '2020-05-29 13:37:49', '2020-05-29 13:37:49'),
(40, 114, 'RN', 1, '0.000', NULL, 1, '2020-05-29 14:09:55', '2020-05-29 14:09:55'),
(41, 115, 'RN', 1, '0.000', NULL, 1, '2020-05-29 14:30:11', '2020-05-29 14:30:11'),
(42, 116, 'RN', 1, '0.000', NULL, 1, '2020-05-29 14:59:41', '2020-05-29 14:59:41'),
(43, 117, 'RN', 1, '0.000', NULL, 1, '2020-05-29 15:33:19', '2020-05-29 15:33:19'),
(44, 118, 'RN', 1, '0.000', NULL, 1, '2020-05-29 15:44:42', '2020-05-29 15:44:42'),
(45, 119, 'RN', 1, '0.000', NULL, 1, '2020-05-29 16:37:33', '2020-05-29 16:37:33'),
(46, 120, 'RN', 1, '0.000', NULL, 1, '2020-05-29 16:42:31', '2020-05-29 16:42:31'),
(47, 121, 'RN', 1, '0.000', NULL, 1, '2020-05-29 16:53:00', '2020-05-29 16:53:00'),
(48, 122, 'RN', 1, '0.000', NULL, 1, '2020-06-01 14:06:36', '2020-06-01 14:06:36'),
(49, 123, 'RN', 1, '0.000', NULL, 1, '2020-06-01 14:16:09', '2020-06-01 14:16:09'),
(50, 124, 'RN', 1, '0.000', NULL, 1, '2020-06-01 16:27:41', '2020-06-01 16:27:41'),
(51, 125, 'RN', 1, '0.000', NULL, 1, '2020-06-02 12:46:36', '2020-06-02 12:46:36'),
(52, 126, 'RN', 1, '0.000', NULL, 1, '2020-06-03 16:43:33', '2020-06-03 16:43:33'),
(53, 127, 'RN', 1, '0.000', NULL, 1, '2020-06-03 14:06:28', '2020-06-03 14:06:28'),
(54, 128, 'RN', 1, '0.000', NULL, 1, '2020-06-03 14:14:49', '2020-06-03 14:14:49'),
(55, 129, 'RN', 1, '0.000', NULL, 1, '2020-06-03 14:20:27', '2020-06-03 14:20:27'),
(56, 130, 'RN', 1, '0.000', NULL, 1, '2020-06-03 14:35:36', '2020-06-03 14:35:36'),
(57, 131, 'RN', 1, '0.000', NULL, 1, '2020-06-03 14:37:31', '2020-06-03 14:37:31'),
(58, 132, 'RN', 1, '0.000', NULL, 1, '2020-06-03 15:13:07', '2020-06-03 15:13:07'),
(59, 133, 'RN', 1, '0.000', NULL, 1, '2020-06-03 15:20:01', '2020-06-03 15:20:01'),
(60, 134, 'RN', 1, '0.000', NULL, 1, '2020-06-03 15:28:48', '2020-06-03 15:28:48'),
(61, 135, 'RN', 1, '0.000', NULL, 1, '2020-06-04 14:31:41', '2020-06-04 14:31:41'),
(62, 136, 'RN', 1, '0.000', NULL, 1, '2020-06-04 14:48:27', '2020-06-04 14:48:27'),
(63, 137, 'RN', 1, '0.000', NULL, 1, '2020-06-05 15:43:57', '2020-06-05 15:43:57'),
(64, 138, 'RN', 1, '0.000', NULL, 1, '2020-06-05 17:24:36', '2020-06-05 17:24:36'),
(65, 139, 'RN', 1, '0.000', NULL, 1, '2020-06-08 14:35:27', '2020-06-08 14:35:27'),
(66, 129, 'RN', 1, '0.000', NULL, 1, '2020-06-08 14:55:10', '2020-06-08 14:55:10'),
(67, 129, 'RN', 1, '0.000', NULL, 1, '2020-06-08 14:59:20', '2020-06-08 14:59:20'),
(68, 140, 'RN', 1, '0.000', NULL, 1, '2020-06-10 17:23:55', '2020-06-10 17:23:55'),
(69, 141, 'RN', 1, '0.000', NULL, 1, '2020-06-10 17:34:18', '2020-06-10 17:34:18'),
(70, 142, 'RN', 1, '0.000', NULL, 1, '2020-06-10 19:14:01', '2020-06-10 19:14:01'),
(83, 155, 'RN', 1, '0.000', NULL, 1, '2020-07-02 16:15:50', '2020-07-02 16:15:50'),
(84, 156, 'RN', 1, '0.000', NULL, 1, '2020-07-03 18:10:17', '2020-07-03 18:10:17'),
(85, 157, 'RN', 1, '0.000', NULL, 1, '2020-07-06 16:56:07', '2020-07-06 16:56:07'),
(86, 158, 'RN', 1, '0.000', NULL, 1, '2020-07-06 17:40:17', '2020-07-06 17:40:17'),
(87, 159, 'RN', 1, '0.000', NULL, 1, '2020-07-07 10:02:38', '2020-07-07 10:02:38'),
(88, 160, 'RN', 1, '0.000', NULL, 1, '2020-07-14 09:48:32', '2020-07-14 09:48:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clients_images`
--

CREATE TABLE `clients_images` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clients_id` int(11) NOT NULL,
  `type` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `collection_orders`
--

CREATE TABLE `collection_orders` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `quantity_garbage_bags` decimal(10,1) NOT NULL,
  `date_service_ordes` datetime NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(28) COLLATE utf8_unicode_ci NOT NULL,
  `complement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pendente','agendada','finalizada','cancelada') COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `district` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `period` enum('manhã','tarde','noite') COLLATE utf8_unicode_ci NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `collection_orders`
--

INSERT INTO `collection_orders` (`id`, `users_id`, `quantity_garbage_bags`, `date_service_ordes`, `address`, `number`, `complement`, `comments`, `status`, `created`, `modified`, `district`, `city`, `state`, `period`, `latitude`, `longitude`) VALUES
(41, 77, '5.0', '2020-07-31 00:00:00', 'Av. Sen. Salgado Filho', '2234', 'Teste', 'Varias garrafas pet.', 'pendente', '2020-07-01 14:59:35', '2020-07-01 14:59:35', NULL, 'Natal', 'RN', 'noite', -5.8420138, -35.2115825),
(45, 77, '11.0', '2020-08-31 00:00:00', 'Av. Bernardo Vieira', '3775', 'Teste', 'Restos de metal.', 'pendente', '2020-07-01 16:24:23', '2020-07-01 16:24:23', NULL, 'Natal', 'RN', 'manhã', -5.8112867, -35.2062242),
(46, 77, '10.0', '2020-07-31 00:00:00', 'Av. Sen. Salgado Filho', '1610', NULL, 'Materiais variados.', 'pendente', '2020-07-03 13:43:17', '2020-07-03 13:43:17', 'Lagoa Nova', 'Natal', 'RN', 'manhã', -5.8136254560017, -35.205958830996),
(47, 77, '10.0', '2020-07-04 00:00:00', 'Rua Cesimar Borges', '1457', '', 'Latinhas\n', 'pendente', '2020-07-03 18:15:26', '2020-07-03 18:15:26', NULL, 'Natal', 'RN', 'tarde', -5.829772, -35.2258145),
(48, 104, '2.0', '2020-07-13 00:00:00', '', '', '', 'O material é pesado.', 'pendente', '2020-07-09 20:48:22', '2020-07-09 20:48:22', NULL, '', '', 'noite', 0, 0),
(49, 104, '2.0', '2020-07-14 00:00:00', 'R. João Pessoa', '31', 'C', 'Latinhas de cerveja.', 'pendente', '2020-07-13 17:03:35', '2020-07-13 17:03:35', NULL, 'Macaíba', 'RN', 'manhã', -5.8568875, -35.3517602);

-- --------------------------------------------------------

--
-- Estrutura da tabela `collection_orders_categories`
--

CREATE TABLE `collection_orders_categories` (
  `id` int(11) NOT NULL,
  `collection_orders_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `collection_orders_categories`
--

INSERT INTO `collection_orders_categories` (`id`, `collection_orders_id`, `categorie_id`, `created`, `modified`) VALUES
(85, 41, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 45, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 46, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, 46, 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 46, 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 46, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, 47, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(95, 48, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(96, 49, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `collection_orders_images`
--

CREATE TABLE `collection_orders_images` (
  `id` int(11) NOT NULL,
  `path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `collection_orders_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `collection_orders_images`
--

INSERT INTO `collection_orders_images` (`id`, `path`, `collection_orders_id`, `created`, `modified`) VALUES
(44, 'coleta/41/d2e3c10f52ce7637b33b.jpg', 41, '2020-07-01 14:59:39', '2020-07-01 14:59:39'),
(48, 'coleta/45/329c15aaddfb5ec2918a.jpg', 45, '2020-07-01 16:24:25', '2020-07-01 16:24:25'),
(49, 'coleta/46/41602ba1e19d660f0b59.jpg', 46, '2020-07-03 13:43:19', '2020-07-03 13:43:19'),
(50, 'coleta/46/269dbeb46a1db020c9b1.jpg', 46, '2020-07-03 13:43:21', '2020-07-03 13:43:21'),
(51, 'coleta/46/26c4b5202d2f0919692e.jpg', 46, '2020-07-03 13:43:23', '2020-07-03 13:43:23'),
(52, 'coleta/47/ee7d32a0ff08587d7dea.jpg', 47, '2020-07-03 18:15:28', '2020-07-03 18:15:28'),
(53, 'coleta/47/7a0c4012c4397f35dd80.jpg', 47, '2020-07-03 18:15:30', '2020-07-03 18:15:30'),
(54, 'coleta/48/1e71c86f49bbc2bfee67.jpg', 48, '2020-07-09 20:48:24', '2020-07-09 20:48:24'),
(55, 'coleta/49/8d337970ae2eb0a413a3.jpg', 49, '2020-07-13 17:03:38', '2020-07-13 17:03:38');

-- --------------------------------------------------------

--
-- Estrutura da tabela `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number_users` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resale_plans_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `companies`
--

INSERT INTO `companies` (`id`, `name`, `number_users`, `created`, `modified`, `active`, `image`, `resale_plans_id`) VALUES
(1, 'No Vizinho', 100, '2018-03-30 13:02:35', '2019-11-01 21:32:50', 1, 'upload/companies/1/5d73ecdf728b4.jpg', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails_log`
--

CREATE TABLE `emails_log` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `send` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `received` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `emails_log`
--

INSERT INTO `emails_log` (`id`, `email`, `send`, `received`, `created`, `modified`) VALUES
(3, 'ftajr@hotmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Raoni Medeiros Araujo\\\",\\\"email\\\":\\\"ftajr@hotmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Raoni Medeiros Araujo\\\",\\\"senha\\\":\\\"X8shb7a4\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Tue, 12 Nov 2019 09:54:18 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: 9VxTDbkBQXy9t_q1vGVZZg\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-12 09:54:19', '2019-11-12 09:54:19'),
(4, 'paulo.officecom@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Paulo Teste Prestador\\\",\\\"email\\\":\\\"paulo.officecom@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Paulo Teste Prestador\\\",\\\"senha\\\":\\\"VMPO7wSX\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Mon, 18 Nov 2019 22:18:42 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: z8OJEPx3Rm-p2-vzQbI03A\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-18 22:18:42', '2019-11-18 22:18:42'),
(5, 'kellybezerra.officecom@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Kelly teste\\\",\\\"email\\\":\\\"kellybezerra.officecom@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Kelly teste\\\",\\\"senha\\\":\\\"RnhMtuCg\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Mon, 18 Nov 2019 22:19:11 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: 3cgaL9WOSpKHUaSlhveXzQ\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-18 22:19:11', '2019-11-18 22:19:11'),
(6, 'raon3i2s229g337@teste.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Raoni Medeiros Araujo\\\",\\\"email\\\":\\\"raon3i2s229g337@teste.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Raoni Medeiros Araujo\\\",\\\"senha\\\":\\\"0YcDImpE\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Fri, 22 Nov 2019 18:21:48 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: ZH1SOnwGQNG0JnNpBTjVbw\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-22 18:21:48', '2019-11-22 18:21:48'),
(7, 'rolivegab@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Gabriel\\\",\\\"email\\\":\\\"rolivegab@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Gabriel\\\",\\\"senha\\\":\\\"89omAQqS\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Fri, 22 Nov 2019 18:27:25 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: adFAeveUTDufHMbczzdDUA\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-22 18:27:25', '2019-11-22 18:27:25'),
(8, 'luciamedeiross@hotmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Fabiano Teste Login\\\",\\\"email\\\":\\\"luciamedeiross@hotmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Fabiano Teste Login\\\",\\\"senha\\\":\\\"3d1zZPvX\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Fri, 22 Nov 2019 22:59:01 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: N7jzVpeTTba_zFsC2iB76g\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-22 22:59:01', '2019-11-22 22:59:01'),
(9, 'ftajrr@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Fabiano T D Junior\\\",\\\"email\\\":\\\"ftajrr@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Fabiano T D Junior\\\",\\\"senha\\\":\\\"9HDQR7Mn\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Sat, 23 Nov 2019 00:26:16 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: z8cEkP3YToKRIGXLLP58ZQ\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-23 00:26:16', '2019-11-23 00:26:16'),
(10, 'Contato.officecom@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Paulo Bezerra \\\",\\\"email\\\":\\\"Contato.officecom@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Paulo Bezerra \\\",\\\"senha\\\":\\\"YzAnjrX2\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Mon, 25 Nov 2019 17:31:19 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: 9J6XDzVkSBizMMPiai3WkQ\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-25 17:31:19', '2019-11-25 17:31:19'),
(11, 'pokisa8232@4xmail.net', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Rod Adolf\\\",\\\"email\\\":\\\"pokisa8232@4xmail.net\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Rod Adolf\\\",\\\"senha\\\":\\\"6mLxIBlG\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Tue, 26 Nov 2019 10:05:26 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: Be5O6O2-TACv5CjwkiKNaA\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-26 10:05:26', '2019-11-26 10:05:26'),
(12, 'capevek447@mytmail.net', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Maria Novaz\\\",\\\"email\\\":\\\"capevek447@mytmail.net\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Maria Novaz\\\",\\\"senha\\\":\\\"G9mQywH0\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Tue, 26 Nov 2019 15:14:04 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: d7HbNDftRV2bo-OrbW7gVw\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-11-26 15:14:04', '2019-11-26 15:14:04'),
(13, 'tejajot285@topmail2.net', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Alberty melo \\\",\\\"email\\\":\\\"tejajot285@topmail2.net\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Alberty melo \\\",\\\"senha\\\":\\\"Ylq7nOCk\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Mon, 02 Dec 2019 18:59:01 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: WOi8r89kRnmctX2IeVl6mQ\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-12-02 18:59:01', '2019-12-02 18:59:01'),
(14, 'kivine3120@topmail2.net', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Jo\\\\u00e3o do teste \\\",\\\"email\\\":\\\"kivine3120@topmail2.net\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Jo\\\\u00e3o do teste \\\",\\\"senha\\\":\\\"7vAF5RPo\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Mon, 02 Dec 2019 22:19:15 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: _XAY7AQzSg25AMKYNydfMg\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2019-12-02 22:19:15', '2019-12-02 22:19:15'),
(15, 'kellybezerra79@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Rosilda da Silva Costa\\\",\\\"email\\\":\\\"kellybezerra79@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Rosilda da Silva Costa\\\",\\\"senha\\\":\\\"lMkCn8EK\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Thu, 16 Jan 2020 21:19:06 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: jtvnw6pmTfCVUAitkkS8zw\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-01-16 21:19:07', '2020-01-16 21:19:07'),
(16, 'ademar@cnetmail.net', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Ademar Lima\\\",\\\"email\\\":\\\"ademar@cnetmail.net\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Ademar Lima\\\",\\\"senha\\\":\\\"EdnlzOTI\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Sat, 25 Jan 2020 21:44:11 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: uS5QhK8DQv-covjkL0uu0g\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-01-25 21:44:11', '2020-01-25 21:44:11'),
(17, 'okay8@hiwave.org', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Hiwave Melo\\\",\\\"email\\\":\\\"okay8@hiwave.org\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Hiwave Melo\\\",\\\"senha\\\":\\\"isOBS8to\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Mon, 27 Jan 2020 22:18:11 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: asg5ynpiTKGo8cA-695D4w\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-01-27 22:18:11', '2020-01-27 22:18:11'),
(18, 'vinicius@cnetmail.net', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Vin\\\\u00edcius potiguara\\\",\\\"email\\\":\\\"vinicius@cnetmail.net\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Vin\\\\u00edcius potiguara\\\",\\\"senha\\\":\\\"kdvE9JTh\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Tue, 28 Jan 2020 21:56:58 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: 0xJdFasjReS8GjMFaVJH0g\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-01-28 21:56:59', '2020-01-28 21:56:59'),
(19, 'helder@cnetmail.net', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"H\\\\u00e9lder bezerra\\\",\\\"email\\\":\\\"helder@cnetmail.net\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"H\\\\u00e9lder bezerra\\\",\\\"senha\\\":\\\"iEh9FVtC\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Tue, 28 Jan 2020 22:07:35 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: 5rU908gpRMyAhZTA-rf_-g\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-01-28 22:07:35', '2020-01-28 22:07:35'),
(20, 'aky@link3mail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Aquiles Silva\\\",\\\"email\\\":\\\"aky@link3mail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Aquiles Silva\\\",\\\"senha\\\":\\\"L4F3ZlI5\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Tue, 25 Feb 2020 23:33:00 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: ZKShFa70S6attzMmlfEcIA\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-02-25 23:33:00', '2020-02-25 23:33:00'),
(21, 'okay@p5mail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Rose Guerra\\\",\\\"email\\\":\\\"okay@p5mail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Rose Guerra\\\",\\\"senha\\\":\\\"mz6nHUNY\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Thu, 05 Mar 2020 13:42:56 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: VhtNwCJhS0uAR4-gScRs7A\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-03-05 13:42:56', '2020-03-05 13:42:56'),
(22, 'ftajrr@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Kelly teste\\\",\\\"email\\\":\\\"ftajrr@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Kelly teste\\\",\\\"senha\\\":\\\"kSyLQNU2\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Thu, 19 Mar 2020 23:02:06 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: cBtZG6HdTcKgosmMNl07hw\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(23, 'ftajrr@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Fabiano Prestador\\\",\\\"email\\\":\\\"ftajrr@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Fabiano Prestador\\\",\\\"senha\\\":\\\"naEgAd18\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Thu, 19 Mar 2020 23:31:46 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: ZnYrPJx6SmaMQ2MSAPMNwQ\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(24, 'ftajrr@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Laynara Medeiros \\\",\\\"email\\\":\\\"ftajrr@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Laynara Medeiros \\\",\\\"senha\\\":\\\"nWaLUDtY\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Fri, 20 Mar 2020 20:00:48 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: h-YgD_2JRwmzYiNuU9IMRw\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(25, 'ftajr@hotmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Laynara Medeiros \\\",\\\"email\\\":\\\"ftajr@hotmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Laynara Medeiros \\\",\\\"senha\\\":\\\"Ajw2MZlB\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Fri, 20 Mar 2020 20:12:37 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: C7NiBmpuR8awFGOZxhGu9g\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(26, 'paulo.officecom@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Paulo S\\\\u00e9rgio Bezerra \\\",\\\"email\\\":\\\"paulo.officecom@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Paulo S\\\\u00e9rgio Bezerra \\\",\\\"senha\\\":\\\"n7AoHmFs\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Fri, 20 Mar 2020 22:51:42 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: NdkkhQ5rTpqea0h0SHsTPw\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(27, 'ftajrr@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Fabiano Prestador\\\",\\\"email\\\":\\\"ftajrr@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Fabiano Prestador\\\",\\\"senha\\\":\\\"hw0GNrlv\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Tue, 24 Mar 2020 23:01:05 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: vVDWFlB_SvGW99mD9m_3_Q\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(28, 'tinab54773@smlmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Fabiano Teixeira\\\",\\\"email\\\":\\\"tinab54773@smlmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Fabiano Teixeira\\\",\\\"senha\\\":\\\"32vzeygL\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Fri, 27 Mar 2020 21:04:36 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: 8fP97znKSI6s0jL7pkJxXQ\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-03-27 21:04:36', '2020-03-27 21:04:36'),
(29, 'cb.novizinho@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Ana Beatriz Costa Bezerra\\\",\\\"email\\\":\\\"cb.novizinho@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Ana Beatriz Costa Bezerra\\\",\\\"senha\\\":\\\"nPNtXjmO\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Fri, 27 Mar 2020 22:28:23 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: pPTn5xzVQ_6Fa0mV8HkMuw\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(30, 'Criacao@agenciacodedigital.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Thiago Soares dos santos\\\",\\\"email\\\":\\\"Criacao@agenciacodedigital.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Thiago Soares dos santos\\\",\\\"senha\\\":\\\"wqp4ilz5\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Tue, 07 Apr 2020 20:19:07 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: 8hA9hEsXSKq1GnFh0rNv_w\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-04-07 20:19:07', '2020-04-07 20:19:07'),
(31, 'Criacao@agenciacodedigital.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Thiago Soares dos santos\\\",\\\"email\\\":\\\"Criacao@agenciacodedigital.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Thiago Soares dos santos\\\",\\\"senha\\\":\\\"Sj946fIp\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Mon, 13 Apr 2020 12:58:26 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: Cpx-f14PTCamR2kl8_AN3A\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(32, 'drailton@emailhost99.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Drailton Melo \\\",\\\"email\\\":\\\"drailton@emailhost99.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Drailton Melo \\\",\\\"senha\\\":\\\"c0BlxEdY\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Wed, 15 Apr 2020 01:30:41 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: RZnBkXlWQZGy34MOCFQ3Xw\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(33, 'drailton@emailhost99.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Drailton Melo \\\",\\\"email\\\":\\\"drailton@emailhost99.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Drailton Melo \\\",\\\"senha\\\":\\\"sawb3FWl\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Wed, 15 Apr 2020 01:33:05 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: sS_nRm-mT2aWnHBX2tp4ug\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(34, 'drailton@emailhost99.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Drailton Melo \\\",\\\"email\\\":\\\"drailton@emailhost99.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Drailton Melo \\\",\\\"senha\\\":\\\"PqJhA1wv\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Wed, 15 Apr 2020 01:33:27 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: OVsGySmqQ52fYjNNBkFdkQ\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(35, 'drailton@emailhost99.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Drailton Melo \\\",\\\"email\\\":\\\"drailton@emailhost99.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Drailton Melo \\\",\\\"senha\\\":\\\"rRb0ygKv\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Wed, 15 Apr 2020 01:34:26 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: L7FdOhX3RkS_MbfCrOgNog\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(36, 'drailton@emailhost99.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Drailton Melo \\\",\\\"email\\\":\\\"drailton@emailhost99.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Drailton Melo \\\",\\\"senha\\\":\\\"igLR2uHq\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Wed, 15 Apr 2020 01:35:03 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: FdCzK4MMRUiue4mRtwZu_A\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(37, 'drailton@emailhost99.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Drailton Melo \\\",\\\"email\\\":\\\"drailton@emailhost99.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Drailton Melo \\\",\\\"senha\\\":\\\"Zik3MDXz\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Wed, 15 Apr 2020 01:38:05 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: 6wiCINqeTiKbqe6KD_f4kg\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(38, 'pereira@emailhost99.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Pereira Gomes\\\",\\\"email\\\":\\\"pereira@emailhost99.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Pereira Gomes\\\",\\\"senha\\\":\\\"NB64KW8z\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Wed, 15 Apr 2020 02:01:42 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: 0CVDBKmWSyqrix6udTKLBA\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-04-15 02:01:42', '2020-04-15 02:01:42'),
(39, 'rolivegab@gmail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Gabriel Rocha de Oliveira\\\",\\\"email\\\":\\\"rolivegab@gmail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Gabriel Rocha de Oliveira\\\",\\\"senha\\\":\\\"5xN1IsjF\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Thu, 16 Apr 2020 18:32:17 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: LfO7bWQFTG-GyX7c8MxxBw\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(40, 'carvalho@hubopss.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Thiago Carvalho\\\",\\\"email\\\":\\\"carvalho@hubopss.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Bem vindo\\\",\\\"nome\\\":\\\"Thiago Carvalho\\\",\\\"senha\\\":\\\"7FexrtVX\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Usu\\\\u00e1rio\\\",\\\"template_id\\\":\\\"d-5e5c32490a8146b5910ce26a692e727b\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Thu, 23 Apr 2020 12:20:21 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: vAcJBqEoTj69MpPF-S1JOg\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', '2020-04-23 12:20:21', '2020-04-23 12:20:21'),
(41, 'menezes@2go-mail.com', '\"{\\\"personalizations\\\":[{\\\"to\\\":[{\\\"name\\\":\\\"Sandro Menezes\\\",\\\"email\\\":\\\"menezes@2go-mail.com\\\"}],\\\"dynamic_template_data\\\":{\\\"subject\\\":\\\"Nova senha\\\",\\\"nome\\\":\\\"Sandro Menezes\\\",\\\"senha\\\":\\\"5qaLD3sR\\\"}}],\\\"from\\\":{\\\"name\\\":\\\"NoVizinho\\\",\\\"email\\\":\\\"contato@novizinho.com.br\\\"},\\\"subject\\\":\\\"Novo Senha\\\",\\\"template_id\\\":\\\"d-e49772ecbc4146ebb6913461aecd0be6\\\"}\"', '\"[\\\"HTTP\\\\/1.1 202 Accepted\\\",\\\"Server: nginx\\\",\\\"Date: Thu, 23 Apr 2020 13:32:54 GMT\\\",\\\"Content-Length: 0\\\",\\\"Connection: keep-alive\\\",\\\"X-Message-Id: MMqGvcToTXiE22LCBjMJBQ\\\",\\\"Access-Control-Allow-Origin: https:\\\\/\\\\/sendgrid.api-docs.io\\\",\\\"Access-Control-Allow-Methods: POST\\\",\\\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\\\",\\\"Access-Control-Max-Age: 600\\\",\\\"X-No-CORS-Reason: https:\\\\/\\\\/sendgrid.com\\\\/docs\\\\/Classroom\\\\/Basics\\\\/API\\\\/cors.html\\\",\\\"\\\",\\\"\\\"]\"', NULL, NULL),
(42, 'will_nunnes@hotmail.com', '{\"personalizations\":[{\"to\":[{\"name\":\"Empresa Recicladora Ltda\",\"email\":\"will_nunnes@hotmail.com\"}],\"dynamic_template_data\":{\"subject\":\"Nova senha\",\"nome\":\"Empresa Recicladora Ltda\",\"senha\":\"sUP0TFEC\"}}],\"from\":{\"name\":\"Uzeh\",\"email\":\"uzeh@corpstek.com.br\"},\"subject\":\"Novo Senha\",\"template_id\":\"d-e49772ecbc4146ebb6913461aecd0be6\"}', '[\"HTTP\\/1.1 403 Forbidden\",\"Server: nginx\",\"Date: Thu, 09 Jul 2020 18:18:30 GMT\",\"Content-Type: application\\/json\",\"Content-Length: 281\",\"Connection: keep-alive\",\"Access-Control-Allow-Origin: https:\\/\\/sendgrid.api-docs.io\",\"Access-Control-Allow-Methods: POST\",\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\",\"Access-Control-Max-Age: 600\",\"X-No-CORS-Reason: https:\\/\\/sendgrid.com\\/docs\\/Classroom\\/Basics\\/API\\/cors.html\",\"\",\"\"]', NULL, NULL),
(43, 'will_nunnes@hotmail.com', '{\"personalizations\":[{\"to\":[{\"name\":\"Empresa Recicladora Ltda\",\"email\":\"will_nunnes@hotmail.com\"}]}],\"from\":{\"name\":\"Uzeh\",\"email\":\"uzeh@corpstek.com.br\"},\"subject\":\"Novo Senha\",\"content\":[{\"type\":\"text\\/plain\"}]}', '[\"HTTP\\/1.1 400 Bad Request\",\"Server: nginx\",\"Date: Thu, 09 Jul 2020 18:22:10 GMT\",\"Content-Type: application\\/json\",\"Content-Length: 219\",\"Connection: keep-alive\",\"Access-Control-Allow-Origin: https:\\/\\/sendgrid.api-docs.io\",\"Access-Control-Allow-Methods: POST\",\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\",\"Access-Control-Max-Age: 600\",\"X-No-CORS-Reason: https:\\/\\/sendgrid.com\\/docs\\/Classroom\\/Basics\\/API\\/cors.html\",\"\",\"\"]', NULL, NULL),
(44, 'will_nunnes@hotmail.com', '{\"personalizations\":[{\"to\":[{\"name\":\"Empresa Recicladora Ltda\",\"email\":\"will_nunnes@hotmail.com\"}],\"dynamic_template_data\":{\"subject\":\"Nova senha\",\"nome\":\"Empresa Recicladora Ltda\",\"senha\":\"60ZrOy9T\"}}],\"from\":{\"name\":\"NoVizinho\",\"email\":\"contato@novizinho.com.br\"},\"subject\":\"Novo Senha\",\"template_id\":\"d-e49772ecbc4146ebb6913461aecd0be6\"}', '[\"HTTP\\/1.1 202 Accepted\",\"Server: nginx\",\"Date: Thu, 09 Jul 2020 19:59:13 GMT\",\"Content-Length: 0\",\"Connection: keep-alive\",\"X-Message-Id: Fr8vJ9kTSbWuTh_xBFJXbA\",\"Access-Control-Allow-Origin: https:\\/\\/sendgrid.api-docs.io\",\"Access-Control-Allow-Methods: POST\",\"Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl\",\"Access-Control-Max-Age: 600\",\"X-No-CORS-Reason: https:\\/\\/sendgrid.com\\/docs\\/Classroom\\/Basics\\/API\\/cors.html\",\"\",\"\"]', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `error_logs`
--

CREATE TABLE `error_logs` (
  `id` int(11) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `branches_id` bigint(20) DEFAULT NULL,
  `users_id` bigint(20) DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exception` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gatways`
--

CREATE TABLE `gatways` (
  `id` int(11) NOT NULL,
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `gatways`
--

INSERT INTO `gatways` (`id`, `name`, `url`, `login`, `password`, `json`, `active`, `created`, `modified`) VALUES
(2, 'Teste', 'teste', 'teste', 'teste', '\"teste\"', 1, '2019-10-11 11:26:54', '2019-10-11 11:32:14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `companies_id` int(11) NOT NULL,
  `origin` enum('site') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `others_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `leads`
--

INSERT INTO `leads` (`id`, `companies_id`, `origin`, `name`, `email`, `phone`, `others_data`, `archived`, `created`, `modified`) VALUES
(1, 1, 'site', 'teste', 'teste@teste.com.br', '8928928989', '\"{type:cliente}\"', 1, '2019-10-19 21:44:55', '2019-10-19 22:59:53'),
(2, 1, 'site', 'FABIANO TEIXEIRA DE ARAUJO JUNIOR', 'ftajrr@gmail.com', '84987320906', '\"{type:prestador}\"', 1, '2019-10-19 21:56:27', '2020-04-10 00:49:46'),
(3, 1, 'site', 'Rafael Cordeiro', 'rafaelcordeiro@apsinformatica.com.br', '84998185093', '\"{type:cliente2}\"', 0, '2019-11-07 14:16:31', '2019-11-07 14:16:31'),
(4, 1, 'site', 'Alvaro Crisanto', 'alvarocrisantof@gmail.com', '84996392895', '\"{type:cliente}\"', 0, '2019-11-19 13:54:23', '2019-11-19 13:54:23'),
(5, 1, 'site', 'Alvaro Crisanto', 'alvarocrisantof@gmail.com', '84996392895', '\"{type:prestador}\"', 1, '2019-11-19 13:56:00', '2019-12-13 02:33:44'),
(6, 1, 'site', 'Rafael Cordeiro', 'rafael_timbu@hotmail.com', '84998185093', '\"{type:cliente}\"', 0, '2019-12-05 03:22:33', '2019-12-05 03:22:33'),
(7, 1, 'site', 'Paulo Ronaldo Pinheiro de Souza', 'paulo.pinheirorn@creci.org.br', '84999399198', '\"{type:prestador}\"', 1, '2019-12-07 23:18:30', '2019-12-13 01:55:04'),
(8, 1, 'site', 'Paulo Ronaldo Pinheiro de Souza', 'Paulo.pinheirorn@creci.org.br', '84999399198', '\"{type:cliente}\"', 0, '2019-12-09 10:57:16', '2019-12-09 10:57:16'),
(9, 1, 'site', 'wagner oliveira de macedo', 'wagneromcarvalho@gmail.com', '(84) 98890-9411', '\"{type:prestador}\"', 0, '2019-12-16 15:24:28', '2019-12-16 15:24:28'),
(10, 1, 'site', 'pedro rapso', 'pedrorposo@gmail.com', '84 987386799', '\"{type:cliente}\"', 0, '2020-01-13 11:27:49', '2020-01-13 11:27:49'),
(11, 1, 'site', 'Yuri Vale G. dos Santos', 'yurivalegs@gmail.com', '84 99145-3333', '\"{type:cliente}\"', 0, '2020-01-17 14:19:28', '2020-01-17 14:19:28'),
(12, 1, 'site', 'Inácio David Oliveira de Sousa ', 'ddavidcunha@gmail.com', '83 996404711 ', '\"{type:prestador}\"', 0, '2020-01-19 16:09:09', '2020-01-19 16:09:09'),
(13, 1, 'site', 'Inácio David Oliveira de Sousa ', 'ddavidcunha@gmail.com', '83 996404711 ', '\"{type:cliente}\"', 0, '2020-01-19 16:10:02', '2020-01-19 16:10:02'),
(14, 1, 'site', 'Ivete Bezerra', 'iivetebbezerra@gmail.com', '84996472880', '\"{type:cliente}\"', 0, '2020-01-19 17:25:33', '2020-01-19 17:25:33'),
(15, 1, 'site', 'Ivete Bezerra', 'iivetebbezerra@gmail.com', '84996472880', '\"{type:prestador}\"', 0, '2020-01-21 12:30:48', '2020-01-21 12:30:48'),
(16, 1, 'site', 'Ivete Bezerra', 'iivetebbezerra@gmail.com', '84996472880', '\"{type:prestador}\"', 0, '2020-01-21 12:31:11', '2020-01-21 12:31:11'),
(17, 1, 'site', 'José Augusto Nobre de Medeiros', 'aquaservice@uol.com.br', '84994160862', '\"{type:prestador}\"', 0, '2020-01-28 10:17:48', '2020-01-28 10:17:48'),
(18, 1, 'site', 'José Augusto Nobre de Medeiros', 'aquaservice@uol.com.br', '84994160862', '\"{type:cliente}\"', 0, '2020-01-28 10:18:07', '2020-01-28 10:18:07'),
(19, 1, 'site', 'César Melo', 'csmelo@hotmail.com', '84999834455', '\"{type:cliente}\"', 0, '2020-02-26 12:39:07', '2020-02-26 12:39:07'),
(20, 1, 'site', 'Ivete Bezerra', 'iivetebbezerra@gmail.com', '84996472880', '\"{type:cliente}\"', 0, '2020-03-11 17:44:36', '2020-03-11 17:44:36'),
(21, 1, 'site', 'Thomaz Lucas Guilherme de Araújo Santos', 'tomazlgas@gmail.com', '84996391875', '\"{type:prestador}\"', 0, '2020-03-16 10:48:19', '2020-03-16 10:48:19'),
(22, 1, 'site', 'Antônio Elias França Sobrinho', 'aeliasfs@gmail.com', '998475740', '\"{type:cliente}\"', 0, '2020-03-16 11:48:05', '2020-03-16 11:48:05'),
(23, 1, 'site', 'Raimundo ribeiro da hora neto', 'Raimundohora@gmail.com', '84999869687', '\"{type:prestador}\"', 0, '2020-03-28 18:45:04', '2020-03-28 18:45:04'),
(24, 1, 'site', 'Josefa   Zenaide Bezerra de Araújo ', 'Zenaidebezerra@hotmail.com', '(84). 981491628', '\"{type:cliente}\"', 0, '2020-03-31 19:20:01', '2020-03-31 19:20:01'),
(25, 1, 'site', 'Tereza Zenilda Bezerra ', 'zenicruz@hotmail.com', '84 994063778', '\"{type:[Selecione]}\"', 0, '2020-03-31 19:33:50', '2020-03-31 19:33:50'),
(34, 1, 'site', 'Jorge Moreno ', 'Jmorenomacedo@gmail.com ', '84 996086987', '\"{type:cliente}\"', 0, '2020-04-17 20:08:34', '2020-04-17 20:08:34'),
(35, 1, 'site', 'Andrei Felipe', 'andrei.v.felipe@gmail. Com', '84991240101', '\"{type:prestador}\"', 0, '2020-04-23 01:16:42', '2020-04-23 01:16:42'),
(36, 1, 'site', 'Andrei Vaz Araújo Felipe ', 'andrei.v.felipe@gmail.com', '84981240101', '\"{type:prestador}\"', 0, '2020-04-23 01:18:00', '2020-04-23 01:18:00'),
(57, 1, 'site', 'Fabiano Tste', 'marido@aluguel.com.br', '3998989', '\"{\\n                                    cep:9898989,\\n                                    msg:MARIDO DE ALUGUEL,\\n                                    type_form: client\\n                                   }\"', 1, '2020-05-02 20:20:03', '2020-05-02 23:20:28'),
(58, 1, 'site', 'Famsajk', 'klklo@uo.com', '989898989', '\"{\\n                                    cep:89989898,\\n                                    msg:oiok,\\n                                    type_form: client\\n                                   }\"', 1, '2020-05-02 20:59:06', '2020-05-02 23:59:26'),
(59, 1, 'site', 'Kelly teste', 'sac@novizinho.com.br', '84996210097', '\"{\\n                                    cep:59067400,\\n                                    msg:Marceneiro,\\n                                    type_form: prestador\\n                                   }\"', 0, '2020-05-06 16:42:47', '2020-05-06 16:42:47'),
(60, 1, 'site', 'paulo teste', 'cb.novizinho@gmail.com', '84996210014', '\"{\\n                                    cep:59067400,\\n                                    msg:JARDINEIRO,\\n                                    type_form: prestador\\n                                   }\"', 0, '2020-05-06 18:06:02', '2020-05-06 18:06:02'),
(61, 1, 'site', 'paulo teste2', 'paulo.officecom@gmail.com', '84999555210', '\"{\\n                                    cep:59067400,\\n                                    msg:REFRIGERAÇÃO,\\n                                    type_form: prestador\\n                                   }\"', 0, '2020-05-06 18:07:03', '2020-05-06 18:07:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log_account_balance`
--

CREATE TABLE `log_account_balance` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `value` double NOT NULL,
  `type` enum('up','donw') COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `margin`
--

CREATE TABLE `margin` (
  `id` int(11) NOT NULL,
  `value` double NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `margin`
--

INSERT INTO `margin` (`id`, `value`, `created`, `modified`) VALUES
(1, 20, '2019-10-10 00:00:00', '2019-12-13 02:01:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `modules`
--

INSERT INTO `modules` (`id`, `name`, `created`, `modified`, `icon`, `active`) VALUES
(1, 'Opções', '2018-10-12 11:22:58', '2018-10-12 11:22:58', 'fa fa-cogs', 1),
(2, 'Ti', '2018-03-30 13:04:17', '2018-03-30 03:00:00', 'fa fa-bug', 1),
(3, 'Empresa', '2018-03-30 13:15:29', '2018-03-30 13:15:29', 'fa fa-building', 1),
(6, 'Parâmetros', '2019-09-07 18:52:12', '2019-09-07 18:52:12', 'fab fa-buromobelexperte', 1),
(7, 'Pessoas', '2019-09-22 00:39:07', '2019-09-22 00:39:07', 'fa fa-users', 1),
(8, 'Financeiro', '2019-10-07 11:33:50', '2019-10-07 11:33:50', 'fas fa-dollar-sign', 1),
(9, 'Relatórios', '2019-10-19 22:23:22', '2019-10-19 22:23:22', 'fas fa-file-signature', 1),
(10, 'OS', '2019-11-01 21:32:17', '2019-11-01 21:32:17', 'fas fa-hands-helping', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `modules_has_companies`
--

CREATE TABLE `modules_has_companies` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `modules_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `modules_has_companies`
--

INSERT INTO `modules_has_companies` (`id`, `company_id`, `modules_id`, `created`, `modified`) VALUES
(8, 1, 2, '2018-09-25 00:27:36', '2018-09-23 20:12:10'),
(16, 1, 1, '2018-09-29 18:05:00', '2018-09-29 18:05:00'),
(30, 1, 6, '2019-09-07 18:52:30', '2019-09-07 18:52:30'),
(31, 1, 7, '2019-09-22 00:40:03', '2019-09-22 00:40:03'),
(32, 1, 8, '2019-10-07 11:35:21', '2019-10-07 11:35:21'),
(33, 1, 9, '2019-10-19 22:24:02', '2019-10-19 22:24:02'),
(34, 1, 10, '2019-11-01 21:32:50', '2019-11-01 21:32:50');

-- --------------------------------------------------------

--
-- Estrutura da tabela `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `service_orders_id` int(11) NOT NULL,
  `value` double NOT NULL,
  `transaction_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_pay` datetime NOT NULL,
  `type_payment` enum('cartao','boleto','dinheiro') COLLATE utf8_unicode_ci NOT NULL,
  `providers_value` float NOT NULL,
  `providers_transfer` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT 1,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `rg` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution_rg` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(72) COLLATE utf8_unicode_ci NOT NULL,
  `number_contact` varchar(28) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(28) COLLATE utf8_unicode_ci NOT NULL,
  `district` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `complement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `cep` varchar(56) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_agency` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_account` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billabong` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `people`
--

INSERT INTO `people` (`id`, `company_id`, `image`, `name`, `cpf`, `rg`, `institution_rg`, `date_of_birth`, `email`, `number_contact`, `address`, `number`, `district`, `complement`, `city`, `state`, `active`, `cep`, `bank_code`, `bank_agency`, `bank_account`, `billabong`, `created`, `modified`, `latitude`, `longitude`) VALUES
(90, 1, NULL, 'Fabiano Prestador', '12345678909', '183728', 'SSP RN', '1985-07-28', 'ftajrr@gmail.com', '84987320906', 'Rua José Farache', '1938', 'Lagoa Seca', 'null', 'Natal', 'RN', 1, '59022380', NULL, NULL, NULL, NULL, '2020-03-19 23:20:58', '2020-03-20 20:19:13', NULL, NULL),
(91, 1, NULL, 'Kelly Da Silva Costa Bezerra', '02825361402', '1266528', 'SSP RN', '1979-02-01', 'kellybezerra.officecom@gmail.com', '84996210097', 'Avenida dos Caiapós', '2885', 'Pitimbu', 'Casa 57', 'Natal', 'RN', 1, '59067400', NULL, NULL, NULL, NULL, '2020-03-20 00:33:18', '2020-03-27 04:08:50', NULL, NULL),
(92, 1, NULL, 'Paulo Sérgio Bezerra ', '79215165487', '1151191', 'Ssprn', '1971-09-01', 'paulo.officecom@gmail.com', '84996210014', 'Avenida dos Caiapós', '2885', 'Pitimbu', NULL, 'Natal', 'RN', 1, '59067400', NULL, NULL, NULL, '26e4c196c7d142afb4d7619a4b2e9538', '2020-03-20 00:35:29', '2020-03-21 01:05:54', NULL, NULL),
(93, 1, NULL, 'Gabriel Rocha de Oliveira', '70171532007', '002334986', 'SSP', '1996-06-21', 'rolivegab@gmail.com', '84996096253', 'Rua Presbítero Francisco Oliveira', '125', 'Ponta Negra', 'Apto 202', 'Natal', 'RN', 1, '59090455', NULL, NULL, NULL, '30f976641c1d41ec8b5cbb66606dfc92', '2020-03-20 16:46:54', '2020-04-16 15:04:22', NULL, NULL),
(94, 1, NULL, 'Laynara Medeiros ', '49355013086', '83728', 'SSPRN', '1985-07-28', 'ftajr@hotmail.com', '84987320906', 'Rua da Torre', '1937', 'Tirol', NULL, 'Natal', 'RN', 1, '59015-380', NULL, NULL, NULL, '1195eb1883924600bb20173fb7ace8ee', '2020-03-20 20:00:17', '2020-03-20 20:00:17', NULL, NULL),
(95, 1, NULL, 'Fabiano Junior', '36360784025', '294829', '39388', '1985-07-28', 'cibivif488@mailboxt.com', '84999999999', 'Rua José Farache', '2938', 'Lagoa Seca', 'XX', 'Natal', 'RN', 1, '59022-380', NULL, NULL, NULL, 'f7e678a049b64921aa6613541525c536', '2020-03-27 20:45:14', '2020-03-27 20:45:14', NULL, NULL),
(96, 1, NULL, 'Fabiano Teixeira', '83654300022', '39282', 'SSPRN', '1985-07-28', 'tinab54773@smlmail.com', '84999996666', 'Rua José Farache', '2827', 'Lagoa Seca', NULL, 'Natal', 'RN', 1, '59022380', NULL, NULL, NULL, NULL, '2020-03-27 21:03:59', '2020-03-27 21:03:59', NULL, NULL),
(97, 1, NULL, 'Ana Beatriz Costa Bezerra', '12281320464', '2400000', 'SSP RN ', '2001-09-18', 'cb.novizinho@gmail.com', '84996210480', 'Av dos caiapos', '2885', 'Pitimbu', 'Casa 57', 'Natal', 'RN ', 1, '59067400', NULL, NULL, NULL, 'ceefa50d1f834cafab6b6681458c2eb9', '2020-03-27 21:04:23', '2020-03-30 22:25:42', NULL, NULL),
(98, 1, NULL, 'Tatu Bola', '78382926037', '0010001', 'SSP RN', '1985-07-28', 'okay@itiomail.com', '84987320906', 'Apto', '1994', 'Lagoa Seca', NULL, 'Natal', 'RN', 1, '59022380', NULL, NULL, NULL, NULL, '2020-03-30 21:19:05', '2020-03-30 21:21:22', NULL, NULL),
(99, 1, NULL, ' Raoni Medeiros Seis', '12309877767', '309281', ' SSPRN', '1995-10-20', ' macas@teste.com', '84988887722', ' Rua Mar Morno', ' 28929', ' Ponta Negra', NULL, ' Natal', ' Rio Grande do Norte', 1, '59888333', ' 1290', ' 2121', ' 32121', NULL, '2020-04-05 19:42:45', '2020-04-05 19:42:45', NULL, NULL),
(102, 1, NULL, 'asd', '07170176483', '123', 'asd', '1996-06-21', 'gabriel.rocha@hirix.com.br', '84998136450', 'Rua Poeta Jorge Fernandes', '125', 'Ponta Negra', NULL, 'Natal', 'RN', 1, '59090450', '123', '123', '123', NULL, '2020-04-05 21:41:25', '2020-04-05 21:41:25', NULL, NULL),
(103, 1, NULL, 'Thiago Soares dos santos', '04826559410', '001985454', 'Ssp', '1985-04-22', 'Criacao@agenciacodedigital.com', '84996184465', 'Rua Parque das Rosas', '246', 'Parque das Árvores', NULL, 'Parnamirim', 'RN', 1, '59154-330', NULL, NULL, NULL, '250ae296d1a744c3880fafb28d4c116b', '2020-04-07 17:07:15', '2020-04-07 17:07:15', NULL, NULL),
(104, 1, NULL, 'Drailton Melo ', '35466271055', '282628', 'SSPRN', '1985-10-10', 'drailton@emailhost99.com', '84987320906', 'Rua José Farache', '2827', 'Lagoa Seca', NULL, 'Natal', 'RN', 1, '59022380', NULL, NULL, NULL, '21e555ef7a784ef6ad77219257226fe4', '2020-04-14 22:14:38', '2020-04-14 22:26:29', NULL, NULL),
(105, 1, NULL, 'Pereira Gomes', '35595658045', '937282', 'SspRN', '1985-07-28', 'pereira@emailhost99.com', '(84) 99999-9996', 'Rua Iguatu', '1974', 'Potengi', 'Jfjfjfjvk', 'Natal', 'RN', 1, '59112110', '20382', '9383', '93838', NULL, '2020-04-14 22:45:22', '2020-04-14 23:22:34', NULL, NULL),
(106, 1, NULL, 'Thiago Carvalho', '93544863049', '29393828', 'SSP RN', '1985-07-28', 'carvalho@hubopss.com', '84999999999', 'Rua José Farache', '38272', 'Lagoa Seca', NULL, 'Natal', 'RN', 1, '59022380', '001', '3455', '20272910', NULL, '2020-04-23 09:17:21', '2020-04-23 09:17:21', NULL, NULL),
(107, 1, NULL, 'Sandro Menezes', '41647709024', '531421', 'Ssprn', '1985-07-28', 'menezes@2go-mail.com', '84987320906', 'Rua José Farache', '511', 'Lagoa Seca', NULL, 'Natal', 'RN', 1, '59022380', NULL, NULL, NULL, '469860f4a05f48bcbfeeae3a1e310855', '2020-04-23 10:31:28', '2020-04-23 10:37:56', NULL, NULL),
(108, 1, NULL, 'Wil Nunnes', '51774787423', '315063567', 'SSP/RN', '1989-12-01', 'corpstek_temp@hotmail.com', '58698290011', 'R. Cesimar Borges', '1457', 'Candelária', NULL, 'Natal', 'RN', 1, '59090-050', NULL, NULL, NULL, 'b596790178f7448b9e8ac3aaa4257b65', '2020-05-13 14:50:00', '2020-05-13 14:50:00', NULL, NULL),
(109, 1, NULL, 'Wilton Nunes', '76155322058', NULL, NULL, '1989-12-01', 'wil@teste.com', '99999999999', 'Rua da', '44', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-25 11:01:42', '2020-05-25 11:01:42', NULL, NULL),
(110, 1, NULL, 'Wilton Silva', '47930331059', NULL, NULL, '1989-12-01', 'silva@teste.com', '99999999999', 'Rua da Cruz', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-25 11:16:04', '2020-05-25 11:16:04', NULL, NULL),
(111, 1, NULL, 'Wil Nunes Gomes', '81949130045', NULL, NULL, '1989-12-01', 'ggg@teste.com', '99999999999', 'Rua da Cemiterio', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-26 11:40:36', '2020-05-26 11:40:36', NULL, NULL),
(112, 1, NULL, 'Teste Teste', '47311117062', NULL, NULL, '2000-01-01', 'testando@teste.com', '99999999999', 'Teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-26 11:46:26', '2020-05-26 11:46:26', NULL, NULL),
(113, 1, NULL, 'Goku', '89634883060', NULL, NULL, '1989-12-01', 'wil@goku.com', '99999999999', 'teste', '665', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-29 13:37:49', '2020-05-29 13:37:49', NULL, NULL),
(114, 1, NULL, 'Goku 2', '47848666042', NULL, NULL, '1989-12-01', 'wil@gg.com', '99999999999', 'teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-29 14:09:55', '2020-05-29 14:09:55', NULL, NULL),
(115, 1, NULL, 'Goku 2', '92935752058', NULL, NULL, '1989-12-01', 'wil@ggggg.com', '99999999999', 'teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-29 14:30:11', '2020-05-29 14:30:11', NULL, NULL),
(116, 1, NULL, 'Emp 1', '52328442000165', NULL, NULL, '0000-00-00', 'wil@emp1.com', '99999999999', 'teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-29 14:59:41', '2020-05-29 14:59:41', NULL, NULL),
(117, 1, NULL, 'Emp 6', '85276112000122', NULL, NULL, '0000-00-00', 'wil@eeeee.com', '99999999999', 'teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-29 15:33:19', '2020-05-29 15:33:19', NULL, NULL),
(118, 1, NULL, 'Emp 64', '29407751000109', NULL, NULL, '0000-00-00', 'wil@fff.com', '99999999999', 'teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-29 15:44:42', '2020-05-29 15:44:42', NULL, NULL),
(119, 1, NULL, 'N', '65845296000197', NULL, NULL, '0000-00-00', 'goku@goku.com', '99999999999', 'teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-29 16:37:33', '2020-05-29 16:37:33', NULL, NULL),
(120, 1, NULL, 'N2', '52331503000143', NULL, NULL, '0000-00-00', 'n2@n2.com', '99999999999', 'teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-29 16:42:30', '2020-05-29 16:42:30', NULL, NULL),
(121, 1, NULL, 'Testando', '54105475000171', NULL, NULL, '0000-00-00', 'dd@dd.com', '99999999999', 'teste', '44', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-05-29 16:53:00', '2020-05-29 16:53:00', NULL, NULL),
(122, 1, NULL, 'Dead', '61480110000', NULL, NULL, '1989-12-01', 'dead@hotmail.com', '99999999999', 'Rua do Dead', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-01 14:06:36', '2020-06-01 14:06:36', NULL, NULL),
(123, 1, NULL, 'Dead Corps', '82571174000179', NULL, NULL, '0000-00-00', 'dead_corps@hotmail.com', '99999999999', 'Rua do Dead', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-01 14:16:09', '2020-06-01 14:16:09', NULL, NULL),
(124, 1, NULL, 'Dead Corps 2', '70863523000147', NULL, NULL, '0000-00-00', 'dead_corps2@hotmail.com', '99999999999', 'Rua da Cruz', '665', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-01 16:27:41', '2020-06-01 16:27:41', NULL, NULL),
(125, 1, NULL, 'MNE', '15517829000133', NULL, NULL, '0000-00-00', 'mne@mne.com', '99999999999', 'Teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-02 12:46:36', '2020-06-02 12:46:36', NULL, NULL),
(126, 1, NULL, 'WNGS Corp', '34566248000136', NULL, NULL, '0000-00-00', 'wngs@gmail.com', '99999999999', 'Teste', '666', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-03 16:43:33', '2020-06-03 16:43:33', NULL, NULL),
(127, 1, NULL, 'Corps', '00998194800014', NULL, NULL, '0000-00-00', 'corps@teste.com', '84999999999', 'sdfsdf2', '2', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-03 14:06:28', '2020-06-03 14:06:28', NULL, NULL),
(128, 1, NULL, 'Corps', '09981948000140', NULL, NULL, '0000-00-00', 'corps@teste.com', '84999999999', 'fsdfasdf', '2', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-03 14:14:49', '2020-06-03 14:14:49', NULL, NULL),
(129, 1, NULL, 'Bruno', '06683236470', NULL, NULL, '1988-03-08', 'bruno@teste.com', '84999999999', 'Av. Sen. Salgado Filho', '1610', 'Lagoa Nova', NULL, 'Natal', 'RN', 1, NULL, NULL, NULL, NULL, NULL, '2020-06-03 14:20:27', '2020-06-03 14:20:27', -5.813625456001725, -35.20595883099557),
(130, 1, NULL, 'Corps', '97338587000185', NULL, NULL, '0000-00-00', 'corps@teste.com', '84999999999', 'fsdfsd', 'fsdf', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-03 14:35:36', '2020-06-03 14:35:36', NULL, NULL),
(131, 1, NULL, 'Corps', '39994408000161', NULL, NULL, '0000-00-00', 'corps2@teste.com.br', '84999999999', 'fsdfsd', 'fsdf', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-03 14:37:31', '2020-06-03 14:37:31', NULL, NULL),
(132, 1, NULL, 'teste', '08888788425', NULL, NULL, '2000-01-01', 'testebb@teste.com', '84888888888', 'Rua teste', '2', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-03 15:13:07', '2020-06-03 15:13:07', NULL, NULL),
(133, 1, NULL, 'Bruno', '63279312000', NULL, NULL, '2000-01-01', 'brunoteste@testea.com', '88888888888', 'fsdfsad', 'dfd', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-03 15:20:01', '2020-06-03 15:20:01', NULL, NULL),
(134, 1, NULL, 'testeeee', '29973155068', NULL, NULL, '2000-01-01', 'testeaa@teste.com.br', '84999999999', 'fsdfs', '2s', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-03 15:28:48', '2020-06-03 15:28:48', NULL, NULL),
(135, 1, NULL, 'Bruno Coletor', '48669546043', NULL, NULL, '1988-03-08', 'brunocoletor@teste.com', '84991000737', 'teste', '1', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-04 14:31:41', '2020-06-04 14:31:41', NULL, NULL),
(136, 1, NULL, 'Anne Heloise', '64175402000100', NULL, NULL, '0000-00-00', 'reciclador@teste.com', '84999999999', 'rua teste', 'a2', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-04 14:48:27', '2020-06-04 14:48:27', NULL, NULL),
(137, 1, NULL, 'Alice', '74483141066', NULL, NULL, '2000-01-01', 'coletor@teste.com', '88888888888', 'ru', '3', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-05 15:43:57', '2020-06-05 15:43:57', NULL, NULL),
(138, 1, NULL, 'sdf', '63337267000199', NULL, NULL, '0000-00-00', 'ttesterr@rsd.com', '77777777777', 'fsdf', 's', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-05 17:24:36', '2020-06-05 17:24:36', NULL, NULL),
(139, 1, NULL, 'Corps', '38004735000166', NULL, NULL, '0000-00-00', 'corpszz@teste.comfs', '88888888888', 'fsdfsdfs', '2', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-08 14:35:27', '2020-06-08 14:35:27', NULL, NULL),
(140, 1, NULL, 'testee', '67202531000138', NULL, NULL, '0000-00-00', 'teste123@teste.com', '99999999999', 'fdsf', '2', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-10 17:23:55', '2020-06-10 17:23:55', NULL, NULL),
(141, 1, NULL, 'dfsfsdffsd', '33482681090', NULL, NULL, '2000-01-01', 'testevvb@teste.com', '22222222222', 'fsdfsd', 'asdas', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-10 17:34:18', '2020-06-10 17:34:18', NULL, NULL),
(142, 1, NULL, 'Corps', '70485219000103', NULL, NULL, '0000-00-00', 'corpsaa@teste.com', '84999999999', 'teste', '2', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2020-06-10 19:14:01', '2020-06-10 19:14:01', NULL, NULL),
(155, 1, NULL, 'Wil Emp', '61284179000140', NULL, NULL, '0000-00-00', 'wil_reciclador@teste.com', '99999999999', 'R. Cel. Auris Coelho', '2525', NULL, 'Teste', 'Natal', 'RN', 1, NULL, NULL, NULL, NULL, NULL, '2020-07-02 16:15:50', '2020-07-02 16:15:50', -5.8287942, -35.1940335),
(156, 1, NULL, 'Corps Teste', '43188354000114', NULL, NULL, '0000-00-00', 'corpsteste2@teste.com', '84999999999', 'rua Cesimar Borges', '1457', NULL, '', 'Natal', 'RN', 1, NULL, NULL, NULL, NULL, NULL, '2020-07-03 18:10:17', '2020-07-03 18:10:17', -5.829772, -35.2236258),
(157, 1, NULL, 'José Nunes da Silva', '82769470000', NULL, NULL, '1960-04-01', 'jose_coletor@teste.com', '99999999999', 'Av. Rio Branco', '669', NULL, '', 'Natal', 'RN', 1, NULL, NULL, NULL, NULL, NULL, '2020-07-06 16:56:07', '2020-07-06 16:56:07', -5.7869152, -35.206986),
(158, 1, NULL, 'Sonia Maria Gomes da Silva', '11218074027', NULL, NULL, '1960-04-01', 'sonia_gerador@teste.com', '99999999999', 'R. João Pessoa', '254', NULL, '', 'Natal', 'RN', 1, NULL, NULL, NULL, NULL, NULL, '2020-07-06 17:40:17', '2020-07-06 17:40:17', -5.7876168, -35.2052084),
(159, 1, NULL, 'Empresa Recicladora Ltda', '30009436000102', NULL, NULL, '0000-00-00', 'will_nunnes@hotmail.com', '99999999999', 'Av. Sen. Salgado Filho', '1559', NULL, '', 'Natal', 'RN', 1, NULL, NULL, NULL, NULL, NULL, '2020-07-07 10:02:38', '2020-07-07 10:02:38', -5.8116192, -35.2032812),
(160, 1, NULL, 'Jeremias José', '04241091075', NULL, NULL, '1980-12-01', 'jeremias_coletor@teste.com', '99999999999', 'R. Princesa Isabel', '641', NULL, 'Teste', 'Natal', 'RN', 1, NULL, NULL, NULL, NULL, NULL, '2020-07-14 09:48:32', '2020-07-14 09:48:32', -5.7867357, -35.2059335);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `modules_id` int(11) NOT NULL,
  `order_view` int(11) NOT NULL DEFAULT 1,
  `controller` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `modules_id`, `order_view`, `controller`, `public`, `created`, `modified`) VALUES
(1, 'Empresas', 2, 1, 'Companies', 1, '2018-03-30 14:35:02', '2018-03-30 13:19:21'),
(2, 'Módulos', 2, 1, 'Modules', 1, '2018-03-30 14:35:06', '2018-03-30 13:19:21'),
(3, 'Páginas', 2, 1, 'Permissions', 1, '2018-03-30 14:35:10', '2018-03-30 13:19:45'),
(4, 'Usuários', 1, 1, 'Users', 1, '2018-03-30 14:36:06', '2018-03-30 13:19:45'),
(5, 'All Users', 2, 1, 'Developers', 1, '2018-03-30 14:35:14', '2018-03-30 13:20:01'),
(6, 'Filiais', 3, 1, 'Branches', 1, '2018-03-30 14:32:03', '2018-03-30 13:20:01'),
(7, 'Tipos de Usuário', 2, 1, 'UsersTypes', 1, '2018-03-30 14:35:20', '2018-03-30 13:20:13'),
(9, 'Comissões Especiais', 4, 2, 'CommissionsCentral', 1, '2018-10-13 20:59:18', '2018-10-13 20:59:18'),
(10, 'Processos de Avaliação', 4, 1, 'EvaluationProcess', 1, '2018-10-13 20:44:10', '2018-10-12 10:48:18'),
(11, 'Pessoas', 5, 1, 'People', 1, '2018-10-19 00:15:15', '2018-10-19 00:15:15'),
(12, 'Cargos', 5, 1, 'Roles', 1, '2018-10-27 13:27:31', '2018-10-27 13:27:31'),
(13, 'Funções', 5, 1, 'Offices', 1, '2019-01-10 10:37:27', '2019-01-10 10:37:27'),
(14, 'Instituições', 4, 3, 'Institutions', 1, '2018-11-02 16:00:11', '2018-11-02 16:00:11'),
(15, 'Categorias', 6, 1, 'Categories', 1, '2018-11-07 22:23:29', '2018-11-07 22:23:29'),
(20, 'Survey', 8, 1, 'Survey', 0, '2019-01-10 10:11:45', '2019-01-10 10:11:29'),
(24, 'Prestadores', 7, 1, 'Providers', 1, '2019-09-22 00:40:59', '2019-09-22 00:40:59'),
(25, 'Clientes', 7, 2, 'Clients', 1, '2019-10-07 10:06:20', '2019-10-07 10:06:20'),
(26, 'Pagamentos', 8, 1, 'Payments', 1, '2019-10-10 01:45:46', '2019-10-10 01:45:46'),
(27, 'Margem Padrão', 6, 2, 'Margin', 1, '2019-10-10 13:04:02', '2019-10-10 13:04:02'),
(28, 'Gatway de Pagamento', 6, 3, 'Gatways', 1, '2019-10-10 13:04:17', '2019-10-10 13:04:17'),
(29, 'Leads', 9, 1, 'Leads', 1, '2019-10-19 22:23:40', '2019-10-19 22:23:40'),
(30, 'Ordens de Serviços', 10, 1, 'ServiceOrders', 1, '2019-11-01 21:32:39', '2019-11-01 21:32:39'),
(31, 'Avaliações', 9, 2, 'Ratings', 1, '2019-11-02 09:02:09', '2019-11-02 09:02:09'),
(32, 'Ranking Categorias', 9, 3, 'CategoryRanking', 1, '2020-01-13 10:05:41', '2020-01-13 10:05:41'),
(33, 'Ranking de prestadores', 9, 4, 'ReportTopProviders', 1, '2020-01-28 21:15:45', '2020-01-28 21:15:45');

-- --------------------------------------------------------

--
-- Estrutura da tabela `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20181119165347, 'Initial', '2018-11-19 19:53:47', '2018-11-19 19:53:47', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(5,2) DEFAULT 0.00,
  `radius` double NOT NULL,
  `users_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `plans`
--

INSERT INTO `plans` (`id`, `description`, `value`, `radius`, `users_type_id`) VALUES
(1, 'O coletor pode visualizar doações localizadas dentro de um circulo com centro no seu endereço e raio de 0.0922.', '0.00', 0.0922, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pre_users`
--

CREATE TABLE `pre_users` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `users_type_id` int(11) NOT NULL,
  `people_id` int(11) DEFAULT NULL,
  `email` varchar(72) COLLATE utf8_unicode_ci NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `type_action` enum('new','reset') COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `providers`
--

CREATE TABLE `providers` (
  `id` int(11) NOT NULL,
  `companies_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `acting_region` enum('RN') COLLATE utf8_unicode_ci NOT NULL,
  `nick` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seller_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `providers`
--

INSERT INTO `providers` (`id`, `companies_id`, `person_id`, `category_id`, `subcategory_id`, `acting_region`, `nick`, `seller_id`, `image`, `active`, `created`, `modified`) VALUES
(45, 1, 90, 8, 25, 'RN', 'null', 'dd5018f05b6548e0aec0c1b92347514e', NULL, 1, '2020-03-19 23:20:58', '2020-03-20 20:19:13'),
(46, 1, 91, 8, 26, 'RN', NULL, 'c09795feb8514c3da5e1545c9f27a51e', 'providers/46/perfil.jpg', 1, '2020-03-20 00:33:18', '2020-03-27 22:24:55'),
(47, 1, 92, 6, 19, 'RN', NULL, 'c9508eaf8f9e438e9a85aaa71eee3e93', 'providers/47/perfil.jpg', 1, '2020-03-20 01:13:43', '2020-03-25 05:58:48'),
(48, 1, 93, 8, 26, 'RN', 'rolivegab', '06fb15f385a6423d93872a95b0f63b6f', 'providers/48/perfil.jpg', 1, '2020-03-20 16:52:41', '2020-04-16 09:01:48'),
(49, 1, 96, 4, 16, 'RN', NULL, 'e3ebe9716ed242c18509f061ca9e642f', 'providers/49/perfil.jpg', 1, '2020-03-27 21:03:59', '2020-03-27 22:18:34'),
(50, 1, 97, 3, 7, 'RN', NULL, '5df083f843954f2ab3f62bfbd6791670', NULL, 1, '2020-03-27 21:12:51', '2020-03-30 22:25:42'),
(51, 1, 98, 8, 25, 'RN', NULL, NULL, NULL, 1, '2020-03-30 21:19:05', '2020-03-30 21:21:22'),
(54, 1, 102, 8, 26, 'RN', NULL, NULL, NULL, 0, '2020-04-05 21:41:25', '2020-04-05 21:41:25'),
(55, 1, 103, 9, 27, 'RN', NULL, 'ca6c0969cf7142f3bea03043336190fa', NULL, 1, '2020-04-07 17:16:11', '2020-04-07 20:19:07'),
(56, 1, 105, 7, 23, 'RN', 'Teste A', '5447e7a9a6fd403c9904b1442b044ec4', 'providers/56/perfil.jpg', 1, '2020-04-14 22:45:22', '2020-04-14 23:22:34'),
(57, 1, 106, 6, 19, 'RN', NULL, 'fe66ea3ddc8b43d08ffd62068f8b0570', 'providers/57/perfil.jpg', 1, '2020-04-23 09:17:21', '2020-04-23 09:22:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `providers_images`
--

CREATE TABLE `providers_images` (
  `id` int(11) NOT NULL,
  `providers_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `providers_images`
--

INSERT INTO `providers_images` (`id`, `providers_id`, `image`, `type`) VALUES
(1, 45, 'providers/45/rg.jpg', 'rg'),
(2, 45, 'providers/45/cpf.jpg', 'cpf'),
(3, 45, 'providers/45/certificado.jpg', 'certificado'),
(4, 45, 'providers/45/self.jpg', 'self'),
(5, 46, 'providers/46/rg.jpg', 'rg'),
(6, 46, 'providers/46/cpf.jpg', 'cpf'),
(7, 46, 'providers/46/certificado.jpg', 'certificado'),
(8, 46, 'providers/46/self.jpg', 'self'),
(9, 47, 'providers/47/rg.jpg', 'rg'),
(10, 47, 'providers/47/cpf.jpg', 'cpf'),
(11, 47, 'providers/47/certificado.jpg', 'certificado'),
(12, 47, 'providers/47/self.jpg', 'self'),
(13, 48, 'providers/48/rg.jpg', 'rg'),
(14, 48, 'providers/48/cpf.jpg', 'cpf'),
(15, 48, 'providers/48/certificado.jpg', 'certificado'),
(16, 48, 'providers/48/self.jpg', 'self'),
(17, 49, 'providers/49/rg.jpg', 'rg'),
(18, 49, 'providers/49/cpf.jpg', 'cpf'),
(19, 49, 'providers/49/certificado.jpg', 'certificado'),
(20, 49, 'providers/49/self.jpg', 'self'),
(21, 50, 'providers/50/rg.jpg', 'rg'),
(22, 50, 'providers/50/cpf.jpg', 'cpf'),
(23, 50, 'providers/50/certificado.jpg', 'certificado'),
(24, 50, 'providers/50/self.jpg', 'self'),
(25, 51, 'providers/51/rg.jpg', 'rg'),
(26, 51, 'providers/51/cpf.jpg', 'cpf'),
(27, 51, 'providers/51/certificado.jpg', 'certificado'),
(28, 51, 'providers/51/self.jpg', 'self'),
(29, 54, 'providers/54/rg.jpg', 'rg'),
(30, 54, 'providers/54/rg_verso.jpg', 'rg_verso'),
(31, 54, 'providers/54/cpf.jpg', 'cpf'),
(32, 54, 'providers/54/certificado.jpg', 'certificado'),
(33, 54, 'providers/54/self.jpg', 'self'),
(34, 55, 'providers/55/rg.jpg', 'rg'),
(35, 55, 'providers/55/rg_verso.jpg', 'rg_verso'),
(36, 55, 'providers/55/cpf.jpg', 'cpf'),
(37, 55, 'providers/55/certificado.jpg', 'certificado'),
(38, 55, 'providers/55/self.jpg', 'self'),
(39, 56, 'providers/56/rg.jpg', 'rg'),
(40, 56, 'providers/56/rg_verso.jpg', 'rg_verso'),
(41, 56, 'providers/56/cpf.jpg', 'cpf'),
(42, 56, 'providers/56/certificado.jpg', 'certificado'),
(43, 56, 'providers/56/self.jpg', 'self'),
(44, 57, 'providers/57/rg.jpg', 'rg'),
(45, 57, 'providers/57/rg_verso.jpg', 'rg_verso'),
(46, 57, 'providers/57/cpf.jpg', 'cpf'),
(47, 57, 'providers/57/certificado.jpg', 'certificado'),
(48, 57, 'providers/57/self.jpg', 'self');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `companies_id` int(11) NOT NULL,
  `service_orders_id` int(11) NOT NULL,
  `clients_id` int(11) DEFAULT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `stars` double NOT NULL,
  `type` enum('client','provider') COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `ratings`
--

INSERT INTO `ratings` (`id`, `companies_id`, `service_orders_id`, `clients_id`, `providers_id`, `stars`, `type`, `created`, `modified`) VALUES
(1, 1, 112, 28, 45, 5, 'client', '2020-03-20 20:52:08', '2020-03-20 20:52:08'),
(2, 1, 112, 28, 45, 5, 'provider', '2020-03-20 20:53:25', '2020-03-20 20:53:25'),
(3, 1, 113, 28, 45, 3.5, 'client', '2020-03-20 21:43:50', '2020-03-20 21:43:50'),
(4, 1, 113, 28, 45, 4, 'provider', '2020-03-20 21:44:03', '2020-03-20 21:44:03'),
(5, 1, 114, 26, 46, 4.5, 'client', '2020-03-20 22:31:32', '2020-03-20 22:31:32'),
(6, 1, 114, 26, 46, 4.5, 'provider', '2020-03-20 22:32:39', '2020-03-20 22:32:39'),
(7, 1, 115, 25, 47, 5, 'client', '2020-03-27 01:42:06', '2020-03-27 01:42:06'),
(8, 1, 118, 26, 47, 4, 'client', '2020-03-27 04:17:59', '2020-03-27 04:17:59'),
(9, 1, 122, 30, 47, 5, 'client', '2020-03-27 21:58:24', '2020-03-27 21:58:24'),
(10, 1, 120, 29, 49, 5, 'client', '2020-03-27 22:01:31', '2020-03-27 22:01:31'),
(11, 1, 120, 29, 49, 4, 'provider', '2020-03-27 22:02:06', '2020-03-27 22:02:06'),
(12, 1, 122, 30, 47, 5, 'provider', '2020-03-27 22:04:51', '2020-03-27 22:04:51'),
(13, 1, 122, 30, 47, 5, 'provider', '2020-03-27 22:05:17', '2020-03-27 22:05:17'),
(14, 1, 121, 30, 47, 4.5, 'client', '2020-03-27 22:09:07', '2020-03-27 22:09:07'),
(15, 1, 121, 30, 47, 4.5, 'provider', '2020-03-27 22:27:09', '2020-03-27 22:27:09'),
(16, 1, 123, 27, 48, 3.5, 'client', '2020-03-31 00:00:40', '2020-03-31 00:00:40'),
(17, 1, 123, 27, 48, 3.5, 'provider', '2020-03-31 00:10:12', '2020-03-31 00:10:12'),
(18, 1, 123, 27, 48, 3.5, 'client', '2020-03-31 00:14:53', '2020-03-31 00:14:53'),
(19, 1, 111, 27, 48, 4, 'client', '2020-03-31 00:15:32', '2020-03-31 00:15:32'),
(20, 1, 111, 27, 48, 3.5, 'provider', '2020-03-31 00:21:58', '2020-03-31 00:21:58'),
(21, 1, 123, 27, 48, 3.5, 'client', '2020-03-31 00:26:31', '2020-03-31 00:26:31'),
(22, 1, 124, 27, 48, 3.5, 'client', '2020-03-31 00:29:47', '2020-03-31 00:29:47'),
(23, 1, 124, 27, 48, 3.5, 'provider', '2020-03-31 00:30:05', '2020-03-31 00:30:05'),
(24, 1, 125, 27, 48, 4.5, 'client', '2020-03-31 00:32:50', '2020-03-31 00:32:50'),
(25, 1, 125, 27, 48, 0.5, 'provider', '2020-03-31 00:36:24', '2020-03-31 00:36:24'),
(26, 1, 126, 27, 48, 3.5, 'client', '2020-03-31 00:38:17', '2020-03-31 00:38:17'),
(27, 1, 126, 27, 48, 4.5, 'provider', '2020-03-31 00:38:30', '2020-03-31 00:38:30'),
(28, 1, 127, 27, 48, 3.5, 'client', '2020-03-31 21:22:12', '2020-03-31 21:22:12'),
(29, 1, 127, 27, 48, 3.5, 'provider', '2020-03-31 21:22:29', '2020-03-31 21:22:29'),
(30, 1, 129, 29, 49, 4.5, 'client', '2020-03-31 21:28:21', '2020-03-31 21:28:21'),
(31, 1, 129, 29, 49, 5, 'provider', '2020-03-31 21:29:11', '2020-03-31 21:29:11'),
(32, 1, 130, 27, 48, 3.5, 'client', '2020-04-23 16:22:33', '2020-04-23 16:22:33'),
(33, 1, 139, 33, 57, 3.5, 'client', '2020-04-23 16:33:11', '2020-04-23 16:33:11'),
(34, 1, 139, 33, 57, 5, 'provider', '2020-04-23 16:33:25', '2020-04-23 16:33:25'),
(35, 1, 115, 25, 47, 4, 'provider', '2020-05-03 21:30:03', '2020-05-03 21:30:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `resale_plans`
--

CREATE TABLE `resale_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `users` int(11) NOT NULL DEFAULT 0,
  `value` decimal(19,2) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `resale_plans`
--

INSERT INTO `resale_plans` (`id`, `name`, `slug`, `active`, `users`, `value`, `created`, `modified`) VALUES
(1, 'Ruby', 'ruby', 1, 0, '100.00', '2018-03-30 13:01:11', '2018-03-30 13:01:11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `service_orders`
--

CREATE TABLE `service_orders` (
  `id` int(11) NOT NULL,
  `companies_id` int(11) NOT NULL,
  `clients_id` int(11) NOT NULL,
  `providers_id` int(11) DEFAULT NULL,
  `categories_id` int(11) NOT NULL,
  `subcategories_id` int(11) NOT NULL,
  `date_service_ordes` datetime NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `value_initial` decimal(10,3) DEFAULT NULL,
  `value_final` decimal(10,3) DEFAULT NULL,
  `status` enum('solicitando_orcamento','aprovacao_orcamento','agendamento_prestador','agendada','em_execucao','reagendada','finalizada','em_negociacao','cancelada') COLLATE utf8_unicode_ci NOT NULL,
  `time_start` timestamp NULL DEFAULT NULL,
  `time_end` timestamp NULL DEFAULT NULL,
  `margin` double DEFAULT NULL,
  `value_provider` decimal(10,3) DEFAULT NULL,
  `value_admin` decimal(10,3) DEFAULT NULL,
  `pay` tinyint(1) NOT NULL DEFAULT 0,
  `paid_by_customer` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `service_orders`
--

INSERT INTO `service_orders` (`id`, `companies_id`, `clients_id`, `providers_id`, `categories_id`, `subcategories_id`, `date_service_ordes`, `description`, `value_initial`, `value_final`, `status`, `time_start`, `time_end`, `margin`, `value_provider`, `value_admin`, `pay`, `paid_by_customer`, `created`, `modified`) VALUES
(110, 1, 25, NULL, 8, 26, '2020-03-20 00:47:10', 'Olá precisando  de serviço em porta de vidro ', NULL, NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-03-20 00:47:10', '2020-03-20 00:47:10'),
(111, 1, 27, 48, 8, 26, '2020-03-21 12:00:00', 'descricao', '1.000', '1.500', 'finalizada', '2020-03-31 15:15:29', '2020-03-31 15:15:32', 20, '0.800', '0.200', 0, 1, '2020-03-20 17:37:14', '2020-03-31 00:21:58'),
(112, 1, 28, 45, 8, 25, '2020-10-22 10:00:00', 'Minha porta não abre.', '200.000', '20000.000', 'finalizada', '2020-03-20 11:51:23', '2020-03-20 11:52:09', 20, '160.000', '40.000', 0, 1, '2020-03-20 20:16:43', '2020-03-20 20:53:25'),
(113, 1, 28, 45, 8, 25, '2020-03-25 10:00:00', 'Porta Dois com problema', '300.000', '350.000', 'finalizada', '2020-03-20 12:43:46', '2020-03-20 12:43:50', 20, '240.000', '60.000', 0, 1, '2020-03-20 21:41:06', '2020-03-20 21:44:03'),
(114, 1, 26, 46, 8, 26, '2020-03-25 11:00:00', 'Copia Corolla', '500.000', '500.000', 'finalizada', '2020-03-20 13:31:20', '2020-03-20 13:31:32', 20, '400.000', '100.000', 0, 1, '2020-03-20 22:19:14', '2020-03-20 22:32:39'),
(115, 1, 25, 47, 6, 19, '2020-04-20 15:00:00', 'Olá Boa noite teste de produto', '1500.000', '2000.000', 'finalizada', '2020-03-27 04:41:57', '2020-03-27 04:42:06', 20, '1200.000', '300.000', 0, 1, '2020-03-27 01:37:24', '2020-05-03 21:30:04'),
(116, 1, 26, NULL, 8, 25, '2020-03-27 01:56:12', '2 copias de chaves tetra', NULL, NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-03-27 01:56:12', '2020-03-27 01:56:12'),
(117, 1, 26, 46, 8, 26, '2020-03-28 11:00:00', 'Copia chave Troller', '1000.000', '1000.000', 'agendada', NULL, NULL, 20, '800.000', '200.000', 0, 0, '2020-03-27 01:58:46', '2020-03-27 02:08:06'),
(118, 1, 26, 47, 6, 19, '2020-03-30 14:00:00', 'Instalação 2 luminárias', '75.000', '75.000', 'finalizada', '2020-03-27 07:17:46', '2020-03-27 07:17:59', 20, '60.000', '15.000', 0, 0, '2020-03-27 04:10:15', '2020-03-27 04:17:59'),
(119, 1, 25, NULL, 8, 26, '2020-03-27 04:20:22', 'Abertura de Corolla ', NULL, NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-03-27 04:20:22', '2020-03-27 04:20:22'),
(120, 1, 29, 49, 4, 16, '2020-03-28 08:00:00', 'Fazer parede ABC\n', '250.000', '400.000', 'finalizada', '2020-03-27 12:57:51', '2020-03-27 13:01:31', 20, '200.000', '50.000', 0, 1, '2020-03-27 21:15:14', '2020-03-27 22:02:06'),
(121, 1, 30, 47, 6, 19, '2020-03-29 13:00:00', 'Troca de lâmpadas', '190.000', '190.000', 'finalizada', '2020-03-27 13:08:54', '2020-03-27 13:09:07', 20, '152.000', '38.000', 0, 1, '2020-03-27 21:25:47', '2020-03-27 22:27:09'),
(122, 1, 30, 47, 6, 19, '2020-03-30 15:00:00', 'Tomada energia', '180.000', '350.000', 'finalizada', '2020-03-27 12:57:57', '2020-03-27 12:58:24', 20, '144.000', '36.000', 0, 1, '2020-03-27 21:27:41', '2020-03-27 22:04:52'),
(123, 1, 27, 48, 8, 26, '2020-03-31 00:00:00', 'eba', '1.520', '1.500', 'finalizada', '2020-03-31 15:00:26', '2020-03-31 15:26:31', 20, '1.200', '0.300', 0, 1, '2020-03-30 23:09:22', '2020-03-31 00:26:31'),
(124, 1, 27, 48, 8, 26, '2020-02-02 12:00:00', '', '2.000', '2.000', 'finalizada', '2020-03-31 15:29:45', '2020-03-31 15:29:47', 20, '1.600', '0.400', 0, 1, '2020-03-31 00:28:25', '2020-03-31 00:30:05'),
(125, 1, 27, 48, 8, 26, '2020-02-02 12:00:00', '', '2.220', '2.220', 'finalizada', '2020-03-31 15:32:45', '2020-03-31 15:32:50', 20, '1.776', '0.444', 0, 1, '2020-03-31 00:31:57', '2020-03-31 00:36:24'),
(126, 1, 27, 48, 8, 26, '2020-02-02 12:00:00', '', '12.340', '12.340', 'finalizada', '2020-03-31 15:38:15', '2020-03-31 15:38:17', 20, '9.872', '2.468', 0, 1, '2020-03-31 00:37:15', '2020-03-31 00:38:30'),
(127, 1, 27, 48, 8, 26, '2020-02-02 12:00:00', '', '12.340', '12.340', 'finalizada', '2020-03-31 09:22:03', '2020-03-31 09:22:12', 20, '9.872', '2.468', 0, 1, '2020-03-31 21:21:07', '2020-03-31 21:22:29'),
(128, 1, 27, 48, 8, 26, '2020-02-02 12:00:00', '123!', '4.500', '4.500', 'agendada', NULL, NULL, 20, '3.600', '0.900', 0, 0, '2020-03-31 21:25:28', '2020-03-31 21:26:12'),
(129, 1, 29, 49, 4, 16, '2020-04-01 10:00:00', 'Ok teste de horário dia 01 as 10', '200.000', '300.000', 'finalizada', '2020-03-31 09:28:14', '2020-03-31 09:28:21', 20, '160.000', '40.000', 0, 1, '2020-03-31 21:25:52', '2020-03-31 21:29:11'),
(130, 1, 27, 48, 8, 26, '2020-04-06 12:00:00', 'Descrição longa, com muitos detalhes e coisas específicas que devem ser consideradas no momento do serviço. Ajhdja dbw f sbfba zn dan dsjajdhajjda sjajhdjajs ajbsja dand nabdhajshajshqj zgdja djahsba sjsvsjabs sbsbs shsbsb s e é isso aí', '1.500', '2.000', 'finalizada', '2020-04-23 04:22:28', '2020-04-23 04:22:34', 20, '1.200', '0.300', 0, 0, '2020-04-05 16:28:42', '2020-04-23 16:22:34'),
(131, 1, 29, 49, 4, 16, '2020-04-15 08:00:00', 'Okay', '190.000', '190.000', 'agendada', NULL, NULL, 20, '152.000', '38.000', 0, 0, '2020-04-06 09:53:03', '2020-04-07 12:31:25'),
(132, 1, 27, NULL, 8, 26, '2020-04-07 04:38:07', '', NULL, NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-04-07 04:38:07', '2020-04-07 04:38:07'),
(133, 1, 31, NULL, 8, 25, '2020-04-13 13:39:52', '', NULL, NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-04-13 13:39:52', '2020-04-13 13:39:52'),
(134, 1, 31, NULL, 8, 25, '2020-04-13 13:52:49', '', NULL, NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-04-13 13:52:49', '2020-04-13 13:52:49'),
(135, 1, 31, NULL, 9, 29, '2020-04-13 15:10:10', '', NULL, NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-04-13 15:10:10', '2020-04-13 15:10:10'),
(136, 1, 31, NULL, 9, 27, '2020-04-13 15:10:53', '', NULL, NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-04-13 15:10:53', '2020-04-13 15:10:53'),
(137, 1, 25, 47, 6, 19, '2020-04-20 14:00:00', 'Gostaria de trocar a resistência do chuveiro ', '45.000', '45.000', 'agendada', NULL, NULL, 20, '36.000', '9.000', 0, 0, '2020-04-14 18:14:42', '2020-04-14 18:23:27'),
(138, 1, 32, 56, 7, 23, '2020-04-20 08:00:00', 'Fazer uma casinha de cachorro. Medindo 100x200 para botarmos um Pitbull. \n\nCom portão de ferro, porém eu já tenho o portão. \n\nObrigaod', '300.000', '300.000', 'agendada', NULL, NULL, 20, '240.000', '60.000', 0, 0, '2020-04-14 22:40:49', '2020-04-14 23:32:59'),
(139, 1, 33, 57, 6, 19, '2020-04-24 10:00:00', 'Trocar uma tomada', '100.000', '200.000', 'finalizada', '2020-04-23 04:32:32', '2020-04-23 04:33:11', 20, '80.000', '20.000', 0, 1, '2020-04-23 10:35:05', '2020-04-23 16:33:25'),
(140, 1, 34, NULL, 6, 19, '2020-05-13 17:02:51', 'Consertar chuveiro elétrico', NULL, NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-05-13 17:02:51', '2020-05-13 17:02:51'),
(141, 1, 55, 45, 8, 25, '2020-06-03 00:00:00', 'testeee Bruno', '100.000', NULL, 'solicitando_orcamento', NULL, NULL, NULL, NULL, NULL, 0, 0, '2020-06-03 14:22:58', '2020-06-03 18:38:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `service_orders_images`
--

CREATE TABLE `service_orders_images` (
  `id` int(11) NOT NULL,
  `path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `service_orders_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `service_orders_images`
--

INSERT INTO `service_orders_images` (`id`, `path`, `service_orders_id`, `created`, `modified`) VALUES
(1, 'os/110/8e8395f218bfdd95475a.jpg', 110, '2020-03-20 00:47:10', '2020-03-20 00:47:10'),
(2, 'os/111/f3f8dd42f9bd663b4cb0.jpg', 111, '2020-03-20 17:37:14', '2020-03-20 17:37:14'),
(3, 'os/112/4677cf5f2cb836f0dd2b.jpg', 112, '2020-03-20 20:16:43', '2020-03-20 20:16:43'),
(4, 'os/113/a3afc324139fb92c0399.jpg', 113, '2020-03-20 21:41:06', '2020-03-20 21:41:06'),
(5, 'os/115/773ef56e9c31f514d2e5.jpg', 115, '2020-03-27 01:37:24', '2020-03-27 01:37:24'),
(6, 'os/116/c959bc72c62da102e8c4.jpg', 116, '2020-03-27 01:56:12', '2020-03-27 01:56:12'),
(7, 'os/118/9d3d4cc62bc677768061.jpg', 118, '2020-03-27 04:10:15', '2020-03-27 04:10:15'),
(8, 'os/119/81ddf711728913aba160.jpg', 119, '2020-03-27 04:20:22', '2020-03-27 04:20:22'),
(9, 'os/120/15d1ad2ba4cfae2cb1e5.jpg', 120, '2020-03-27 21:15:14', '2020-03-27 21:15:14'),
(10, 'os/120/5037eed7ee946257563d.jpg', 120, '2020-03-27 21:15:15', '2020-03-27 21:15:15'),
(11, 'os/121/9b9b2610a299372dcdba.jpg', 121, '2020-03-27 21:25:48', '2020-03-27 21:25:48'),
(12, 'os/122/0cdfa3a674eec6dfe819.jpg', 122, '2020-03-27 21:27:41', '2020-03-27 21:27:41'),
(13, 'os/123/be89225efa13b6c5e4f4.jpg', 123, '2020-03-30 23:09:22', '2020-03-30 23:09:22'),
(14, 'os/129/8e7da9b76140d7f1eef3.jpg', 129, '2020-03-31 21:25:52', '2020-03-31 21:25:52'),
(15, 'os/130/0ea632e90c09825c6357.jpg', 130, '2020-04-05 16:28:43', '2020-04-05 16:28:43'),
(16, 'os/130/3822142e8bedce7ca346.jpg', 130, '2020-04-05 16:28:43', '2020-04-05 16:28:43'),
(17, 'os/132/95281a1b5952b93fabab.jpg', 132, '2020-04-07 04:38:07', '2020-04-07 04:38:07'),
(18, 'os/132/20fe1ef6c7c2d62ac08f.jpg', 132, '2020-04-07 04:38:07', '2020-04-07 04:38:07'),
(19, 'os/137/420b89313db7f779021e.jpg', 137, '2020-04-14 18:14:42', '2020-04-14 18:14:42'),
(20, 'os/138/2cbe85800e2e002c2345.jpg', 138, '2020-04-14 22:40:49', '2020-04-14 22:40:49'),
(21, 'os/139/08b1240215fa452d3ff8.jpg', 139, '2020-04-23 10:35:05', '2020-04-23 10:35:05'),
(22, 'os/141/a810cd77c78df5dfccab.jpg', 141, '2020-06-03 14:22:59', '2020-06-03 14:22:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  `margin` double DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `subcategories`
--

INSERT INTO `subcategories` (`id`, `company_id`, `category_id`, `name`, `active`, `margin`, `created`, `modified`) VALUES
(7, 1, 3, 'ENCANADOR RESIDENCIAL ', 1, NULL, '2019-09-20 23:39:09', '2019-11-21 03:55:13'),
(8, 1, 4, 'GESSEIRO', 1, NULL, '2019-09-23 21:47:00', '2019-09-23 21:47:00'),
(9, 1, 4, 'ELETRICISTA', 1, NULL, '2019-09-23 21:47:09', '2019-09-23 21:47:09'),
(11, 1, 2, 'FREEZER', 1, 10, '2019-10-10 09:46:47', '2020-01-31 03:11:55'),
(12, 1, 2, 'CÂMERA FRIA', 1, 2.5, '2019-10-10 09:52:23', '2020-01-31 03:12:22'),
(13, 1, 2, 'Geladeira ', 1, 20, '2019-11-21 03:39:00', '2019-11-21 03:41:49'),
(14, 1, 2, 'Ar condicionado ', 1, 20, '2019-11-21 03:41:09', '2019-11-21 03:41:09'),
(15, 1, 4, 'PINTOR', 1, NULL, '2019-11-21 03:43:53', '2019-11-21 03:43:53'),
(16, 1, 4, 'PEDREIRO', 1, NULL, '2019-11-21 03:44:34', '2019-11-21 03:44:34'),
(17, 1, 3, 'ENCANADOR INDUSTRIAL', 1, NULL, '2019-11-21 03:53:56', '2019-11-21 03:53:56'),
(18, 1, 6, 'INDUSTRIAL', 1, NULL, '2020-01-31 03:10:02', '2020-01-31 03:10:02'),
(19, 1, 6, 'RESIDENCIAL', 1, NULL, '2020-01-31 03:10:13', '2020-01-31 03:10:13'),
(20, 1, 5, 'PLACAS E BLOCOS', 1, NULL, '2020-01-31 03:16:22', '2020-01-31 03:16:22'),
(21, 1, 5, 'CARTONADO', 1, NULL, '2020-01-31 03:16:33', '2020-01-31 03:16:33'),
(22, 1, 5, '3D', 1, NULL, '2020-01-31 03:16:50', '2020-01-31 03:16:50'),
(23, 1, 7, 'ALVENARIA E REBOCO', 1, NULL, '2020-01-31 03:19:06', '2020-01-31 03:19:06'),
(24, 1, 7, 'INSTALAÇÃO PISO - PORCELANATO E CERÂMICA', 1, NULL, '2020-01-31 03:20:29', '2020-01-31 03:20:29'),
(25, 1, 8, 'RESIDENCIAL E COMERCIAL', 1, NULL, '2020-01-31 03:22:13', '2020-01-31 03:23:19'),
(26, 1, 8, 'AUTOMOTIVO', 1, NULL, '2020-01-31 03:22:27', '2020-01-31 03:22:27'),
(27, 1, 9, 'SOM E VÍDEO', 1, NULL, '2020-01-31 03:25:05', '2020-01-31 03:25:05'),
(28, 1, 9, 'MAQUINA DE LAVAR ROUPAS E LOUÇAS', 1, NULL, '2020-01-31 03:25:59', '2020-01-31 03:25:59'),
(29, 1, 9, 'APARELHOS DOMÉSTICOS', 1, NULL, '2020-01-31 03:27:06', '2020-01-31 03:27:06'),
(30, 1, 10, 'PINTURAS DE PAREDES', 1, NULL, '2020-01-31 03:54:06', '2020-01-31 03:54:06'),
(31, 1, 10, 'PINTURA DE ESQUADRIAS', 1, NULL, '2020-01-31 03:54:26', '2020-01-31 03:54:26'),
(32, 1, 11, 'PORTAS E JANELAS', 1, NULL, '2020-01-31 03:58:18', '2020-01-31 03:58:18'),
(33, 1, 11, 'MÓVEIS', 1, NULL, '2020-01-31 03:58:27', '2020-01-31 03:58:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unregistered_users`
--

CREATE TABLE `unregistered_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_contact` varchar(28) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(28) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpf` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `users_types_id` int(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(28) COLLATE utf8_unicode_ci DEFAULT NULL,
  `complement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `district` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `unregistered_users`
--

INSERT INTO `unregistered_users` (`id`, `name`, `nickname`, `number_contact`, `gender`, `date_of_birth`, `email`, `cpf`, `password`, `created`, `modified`, `users_types_id`, `address`, `number`, `complement`, `district`, `city`, `state`) VALUES
(175, 'Jeremias Reciclagem Ltda', 'Jeremias Reciclagem', '(99) 99999-9999', NULL, NULL, NULL, '03.753.895/0001-23', NULL, '2020-07-14 14:34:42', '2020-07-14 14:34:43', 6, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `users_types_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_dir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `company_id`, `users_types_id`, `person_id`, `active`, `image`, `image_dir`, `photo`, `name`, `email`, `password`, `created`, `modified`, `nickname`, `plan_id`) VALUES
(1, 1, 3, 22, 1, 'upload/users/1/5d73c7dbbd105.jpg', '', NULL, 'Adm', 'adm@adm.com.br', '$2y$10$de/a.KoAehnAQXx4wMGf1uvWD10Il.zvAAKpyolwOElHF3z1oendW', '2018-03-30 14:19:03', '2019-11-28 15:39:24', NULL, NULL),
(38, 1, 4, 90, 1, NULL, NULL, NULL, 'Fabiano Prestador', 'ftajrr@gmail.com', '$2y$10$TPdzRYTcOvkw1zXAw8vWIuEoFgSJKygIX9jwhxCJaFHFML7ARVejK', '2020-03-19 23:30:52', '2020-03-25 02:01:04', NULL, NULL),
(39, 1, 5, 92, 1, NULL, NULL, NULL, 'Paulo Sérgio Bezerra ', 'paulo.officecom@gmail.com', '$2y$10$iSI9NiqeNtNDJV1Rtvavm.otksz3gECnU3wnQ7KmUNP3jz0BHUbL.', '2020-03-20 03:35:29', '2020-03-20 00:43:43', NULL, NULL),
(40, 1, 4, 91, 1, NULL, NULL, NULL, 'Kelly Da Silva Costa Bezerra', 'kellybezerra.officecom@gmail.com', '$2y$10$yhMDh.3tcvOjBEALqydIjOqNArnukj3339NrJM58c8ZRM7C48TOb2', '2020-03-20 00:44:48', '2020-03-28 01:26:17', NULL, NULL),
(41, 1, 5, 91, 1, NULL, NULL, NULL, 'Kelly Da Silva Costa Bezerra', 'kellybezerra.officecom@gmail.com', '$2y$10$iSI9NiqeNtNDJV1Rtvavm.otksz3gECnU3wnQ7KmUNP3jz0BHUbL.', '2020-03-20 04:03:20', '2020-03-20 04:03:20', NULL, NULL),
(42, 1, 5, 93, 1, NULL, NULL, NULL, 'Gabriel Rocha de Oliveira', 'rolivegab@gmail.com', '$2y$10$nmrPNFZN2wQSOATyB/O6keLpsyu4wi.IzdenJOS6cTrXIFBnDoomC', '2020-03-20 19:46:54', '2020-04-16 15:33:08', NULL, NULL),
(43, 1, 4, 93, 1, NULL, NULL, NULL, 'Gabriel Rocha de Oliveira', 'rolivegab@gmail.com', '$2y$10$j5SjxxoDWcytV3RpVo6YfeLePpN0edwPW0m0Ye9Cvw/Ai7bw6WcQq', '2020-03-20 17:22:49', '2020-04-04 22:39:39', NULL, NULL),
(44, 1, 5, 94, 1, NULL, NULL, NULL, 'Laynara Medeiros ', 'ftajr@hotmail.com', '$2y$10$J2eiW5FW/E0RuSorefoRL.P82OCr.nhCVEtjiBaPR0CR3Uh3uMAtG', '2020-03-20 23:00:17', '2020-03-20 23:12:36', NULL, NULL),
(45, 1, 4, 92, 1, NULL, NULL, NULL, 'Paulo Sérgio Bezerra ', 'paulo.officecom@gmail.com', '$2y$10$acOoYZJZcbYgcxGKSvlSKu./D3qYMyCmcylDskhKLI4hFOI.gw3RO', '2020-03-20 22:47:34', '2020-03-28 01:23:17', NULL, NULL),
(46, 1, 5, 95, 1, NULL, NULL, NULL, 'Fabiano Junior', 'cibivif488@mailboxt.com', '$2y$10$eiae6x6QhD9R3w0Xsuf7LOhuDhmUuBU6dUC8hN0aWSI0V5r5dM8j.', '2020-03-27 23:45:14', '2020-03-27 23:45:14', NULL, NULL),
(47, 1, 5, 97, 1, NULL, NULL, NULL, 'Ana Beatriz Costa Bezerra', 'cb.novizinho@gmail.com', '$2y$10$DbivowaBq8.iESMU/JVfke/990WAwb8FEGCFNoMmvu3e28sPORDXS', '2020-03-28 00:04:23', '2020-03-28 01:28:23', NULL, NULL),
(48, 1, 4, 96, 1, NULL, NULL, NULL, 'Fabiano Teixeira', 'tinab54773@smlmail.com', '$2y$10$eiae6x6QhD9R3w0Xsuf7LOhuDhmUuBU6dUC8hN0aWSI0V5r5dM8j.', '2020-03-27 21:04:35', '2020-03-27 21:04:35', NULL, NULL),
(49, 1, 4, 97, 1, NULL, NULL, NULL, 'Ana Beatriz Costa Bezerra', 'cb.novizinho@gmail.com', '$2y$10$QvrJkcIU8MjnF/agqYb2tOvVv/0MdLGEptLMn3JB.KgZg0TwwHz2q', '2020-03-30 22:24:59', '2020-03-30 22:24:59', NULL, NULL),
(50, 1, 5, 103, 1, NULL, NULL, NULL, 'Thiago Soares dos santos', 'Criacao@agenciacodedigital.com', '$2y$10$e0MtR3NXNItiycSMWvbTP.uOWBQEzT8k3E0CpvGsLSubyz9e5N/PK', '2020-04-07 17:07:15', '2020-04-13 14:54:52', NULL, NULL),
(51, 1, 4, 103, 1, NULL, NULL, NULL, 'Thiago Soares dos santos', 'Criacao@agenciacodedigital.com', '$2y$10$AJL1U2H74NvLTNVeLW5uWuAHgXMv1TQhSecSbSmaOXv2GnZIM8F1O', '2020-04-07 20:19:06', '2020-04-13 14:54:10', NULL, NULL),
(52, 1, 5, 104, 1, NULL, NULL, NULL, 'Drailton Melo ', 'drailton@emailhost99.com', '$2y$10$cqJxj9cpkX3cU8WtP3SfXex8dUKodxIXidsyFaSvl9JCeIeUzyNI6', '2020-04-14 22:14:38', '2020-04-14 22:38:04', NULL, NULL),
(53, 1, 4, 105, 1, NULL, NULL, NULL, 'Pereira Gomes', 'pereira@emailhost99.com', '$2y$10$xWF0XzwduhFpWurM19MCuuGOooIo1q8SmG3n8bMUrxZ7mhFee7GOW', '2020-04-15 02:01:41', '2020-04-14 23:18:28', NULL, NULL),
(54, 1, 4, 106, 1, NULL, NULL, NULL, 'Thiago Carvalho', 'carvalho@hubopss.com', '$2y$10$XHA9U0VcNRZpnnbRiqmIc.sa.u5oGP2Ihz782oPtyyX.b91ZzyUQe', '2020-04-23 12:20:20', '2020-04-23 09:22:51', NULL, NULL),
(55, 1, 5, 107, 1, NULL, NULL, NULL, 'Sandro Menezes', 'menezes@2go-mail.com', '$2y$10$xIzhONnThh6PfnskLcw.aOFO.G/F0nZej64pSMG.xSmubnLInPcUu', '2020-04-23 10:31:28', '2020-04-23 10:38:07', NULL, NULL),
(56, 1, 5, 108, 1, NULL, NULL, NULL, 'Wil Nunnes', 'corpstek_temp@hotmail.com', '$2y$10$4mzIZtReEsRzbwTSOoaO7ulOHsISHtxSAzcbtblh7jwuv3nntnOIu', '2020-05-13 17:50:00', '2020-05-13 17:50:00', NULL, NULL),
(57, 1, 4, 109, 1, NULL, NULL, NULL, 'Wilton Nunes', 'wil@teste.com', '$2y$10$zR5ak9ELiYyA2D3rcMEzzuZ64w8bPeAfYOKxdkHoXO..CpiezLhTa', '2020-05-25 14:01:42', '2020-05-25 14:01:42', NULL, NULL),
(58, 1, 4, 110, 1, NULL, NULL, NULL, 'Wilton Silva', 'silva@teste.com', '$2y$10$2kT0dDY3t61oQZfkIvd1FuUJDzcpa/iuKaJJMDhZeGosARYDCwdVm', '2020-05-25 14:16:04', '2020-05-25 14:16:04', NULL, NULL),
(59, 1, 4, 111, 1, NULL, NULL, NULL, 'Wil Nunes Gomes', 'ggg@teste.com', '$2y$10$uFTQOVR1VUtSz5ae/Tu/PO7GFac3bl0zzbEj5Fienfq07igqnEEx.', '2020-05-26 14:40:36', '2020-05-26 14:40:36', NULL, NULL),
(60, 1, 4, 112, 1, NULL, NULL, NULL, 'Teste Teste', 'testando@teste.com', '$2y$10$IbfAhbJsKp.PgxAR/MPWtuH9GcobsttMdqfMwL3V8X.IIqe1WXw3O', '2020-05-26 14:46:27', '2020-05-26 14:46:27', NULL, NULL),
(61, 1, 4, 113, 1, NULL, NULL, NULL, 'Goku', 'wil@goku.com', '$2y$10$UlyAdZuy.DNKxK7FeNWHTurWpEjsURnTKVHWYIu0sCNW2tutF.VMK', '2020-05-29 16:37:49', '2020-05-29 16:37:49', NULL, NULL),
(62, 1, 4, 114, 1, NULL, NULL, NULL, 'Goku 2', 'wil@gg.com', '$2y$10$y/ZlE/hf5iVpo6OL2VXB4e9i3h.wPw9R9w9raM0w/uXGcuHYUHsLS', '2020-05-29 17:09:55', '2020-05-29 17:09:55', NULL, NULL),
(63, 1, 4, 115, 1, NULL, NULL, NULL, 'Goku 2', 'wil@ggggg.com', '$2y$10$xVqpXwJ8bYOFbRKfyty/b.Jx1PTqKITI8.JMGpkKJvjlG740kIAIi', '2020-05-29 17:30:11', '2020-05-29 17:30:11', 'GG', NULL),
(64, 1, 6, 116, 1, NULL, NULL, NULL, 'Emp 1', 'wil@emp1.com', '$2y$10$SGm.m0q7QBIkwaWroGttWOPmTh77caZ4SiruL5BbZ25J4fxwEsoDm', '2020-05-29 17:59:42', '2020-05-29 17:59:42', 'Empresa 1', NULL),
(65, 1, 6, 117, 1, NULL, NULL, NULL, 'Emp 6', 'wil@eeeee.com', '$2y$10$RPAr9EMqz4D3mtSEa2YVpu6IzqP9H3NTBSaLeO.snFutbSHVrMIqu', '2020-05-29 18:33:19', '2020-05-29 18:33:19', 'Empresa 6', NULL),
(66, 1, 6, 118, 1, NULL, NULL, NULL, 'Emp 64', 'wil@fff.com', '$2y$10$B56bPbNzP4uM1LFYL7RnoekqMwnyRXFSMbn/svkLoV0HejemsruT6', '2020-05-29 18:44:42', '2020-05-29 18:44:42', 'Empresa 16', NULL),
(67, 1, 6, 119, 1, NULL, NULL, NULL, 'N', 'goku@goku.com', '$2y$10$DGbRxD0okr532xC93VTQ7uybcETdKjDir6eUytmYeyolBtXLn5ApW', '2020-05-29 19:37:33', '2020-05-29 19:37:33', 'Nasa', NULL),
(68, 1, 6, 120, 1, NULL, NULL, NULL, 'N2', 'n2@n2.com', '$2y$10$sC6C7srl6x1KE4AgzvAA9.OA0I/9pu9ZCrmhejWHnLWkx.yJ0SJXy', '2020-05-29 19:42:31', '2020-05-29 19:42:31', 'Nasa 2', NULL),
(69, 1, 6, 121, 1, NULL, NULL, NULL, 'Testando', 'dd@dd.com', '$2y$10$mqnF0hZw4aAHtSsFXZmGeek3a6TbBciU6OCXU7Kt4QNoLGFsWC5KG', '2020-05-29 19:53:01', '2020-05-29 19:53:01', 'Testando', NULL),
(70, 1, 4, 122, 1, NULL, NULL, NULL, 'Dead', 'dead@hotmail.com', '$2y$10$sC3BEapYhUKmG7aVSxfOoubAkUV7evPSX6Tlrtxv5pdTpurRsxN6C', '2020-06-01 17:06:37', '2020-06-01 17:06:37', 'Dead', NULL),
(71, 1, 6, 123, 1, NULL, NULL, NULL, 'Dead Corps', 'dead_corps@hotmail.com', '$2y$10$UyX2pKq5.dz89fHqbQItE.mfxfStSFrJfWR26rricza/nMXy3tCG2', '2020-06-01 17:16:09', '2020-06-01 17:16:09', 'Empresa do Dead', NULL),
(72, 1, 6, 124, 1, NULL, NULL, NULL, 'Dead Corps 2', 'dead_corps2@hotmail.com', '$2y$10$rRyrHSrh0Qqqr5hPxs3kH.s9eVmdseIUgExLb4dl3Z/GsWxm.lwHi', '2020-06-01 19:27:42', '2020-06-01 19:27:42', 'Segunda Empresa do Dead', NULL),
(73, 1, 6, 125, 1, NULL, NULL, NULL, 'MNE', 'mne@mne.com', '$2y$10$x6X373VCRGvyGQ.Czl.EvuZfABIQ2mWEEq/gZFJHB6qiHv8z0u5jG', '2020-06-02 15:46:37', '2020-06-02 15:46:37', 'Minha Nova Empresa', NULL),
(74, 1, 6, 126, 1, NULL, NULL, NULL, 'WNGS Corp', '', '', '2020-06-03 19:43:33', '2020-06-03 19:43:33', 'WNGS', NULL),
(76, 1, 6, 128, 1, NULL, NULL, NULL, 'Corps', 'corps@teste.com', '$2y$10$vJLEqALZwZ6.PhZxr9SbDeMJ95H8in1LYHpn3WwBI5IX9KIh9ZuKi', '2020-06-03 17:14:49', '2020-06-03 17:14:49', 'Corpstek', NULL),
(77, 1, 5, 129, 1, NULL, NULL, NULL, 'Bruno', 'bruno@teste.com', '$2y$10$Z6zx4i8./2LyC4iIlLvHXeFtLxmmocSNKoe1rxNHVqccPpQy8NTMO', '2020-06-03 17:20:27', '2020-06-08 17:59:20', 'teste', NULL),
(78, 1, 6, 131, 1, NULL, NULL, NULL, 'Corps', 'corps2@teste.com.br', '$2y$10$5FKgMltGfX5Qs9XlHXHbae3qVa3fXn7/hwLca/Th6aKd9GIo9I/mC', '2020-06-03 17:37:31', '2020-06-03 17:37:31', 'Corpstek', NULL),
(80, 1, 4, 133, 1, NULL, NULL, NULL, 'Bruno', 'brunoteste@testea.com', '$2y$10$de/a.KoAehnAQXx4wMGf1uvWD10Il.zvAAKpyolwOElHF3z1oendW', '2020-06-03 18:20:01', '2020-06-03 18:20:01', 'teste', NULL),
(81, 1, 4, 134, 1, NULL, NULL, NULL, 'testeeee', 'testeaa@teste.com.br', '$2y$10$AUU37f9eZ68l5OUgLNBE8O.qrFl3Jv4bLMqWRkFil3kbIxvUxs8eK', '2020-06-03 18:28:48', '2020-06-03 18:28:48', 'testee', NULL),
(82, 1, 4, 135, 1, NULL, NULL, NULL, 'Bruno Coletor', 'brunocoletor@teste.com', '$2y$10$zQWexlUiHqtGL7wxmG3mbuLdzc9XcqRMBsFzIsL3lT5oDuoP84DBK', '2020-06-04 17:31:41', '2020-06-04 17:31:41', 'Bruno', NULL),
(83, 1, 6, 136, 1, NULL, NULL, NULL, 'Anne Heloise', 'reciclador@teste.com', '$2y$10$AU9Y2FNGnGLx7/zYoEBCkOYQZeM1fuAvXPOszV0wXAGtvAYhaYMG2', '2020-06-04 17:48:27', '2020-06-04 17:48:27', 'Anne', NULL),
(84, 1, 4, 137, 1, NULL, NULL, NULL, 'Alice', 'coletor@teste.com', '$2y$10$me26Cr2JKPw1gnfPhvvCH.6dln1GtvVAnrOTumknM4CY1WnpSDEKK', '2020-06-05 18:43:57', '2020-06-05 18:43:57', 'Alice', NULL),
(85, 1, 6, 138, 1, NULL, NULL, NULL, 'sdf', 'ttesterr@rsd.com', '$2y$10$OCVhwJF//l0tXoHoAmFL8.4FcqGk51f4gr4DKJP7CfQSAlXzJAvg.', '2020-06-05 20:24:36', '2020-06-05 20:24:36', 'fsdfsadff', NULL),
(86, 1, 6, 139, 1, NULL, NULL, NULL, 'Corps', 'corpszz@teste.comfs', '$2y$10$.VOi9lqWa0Cglj.jUuEIZu.1MEfSiQeOvmdl1t3VsyCQBcCYJ9iY6', '2020-06-08 17:35:27', '2020-06-08 17:35:27', 'Corps teste', NULL),
(87, 1, 6, 140, 1, NULL, NULL, NULL, 'testee', 'teste123@teste.com', '$2y$10$xjfFB5LrVZzIM99g4zAFe.DHzAgGobfG3YyH9Yv8PgDRch2cGLHIi', '2020-06-10 20:23:55', '2020-06-10 20:23:55', 'testeee', NULL),
(88, 1, 4, 141, 1, NULL, NULL, NULL, 'dfsfsdffsd', 'testevvb@teste.com', '$2y$10$OZyogoqTKwmXZPo0WPE6zuq1ioFu24.1Wm.gsv9T/jzj7vE6nTUsu', '2020-06-10 20:34:18', '2020-06-10 20:34:18', 'fsdfsd', NULL),
(89, 1, 6, 142, 1, NULL, NULL, NULL, 'Corps', 'corpsaa@teste.com', '$2y$10$zy4uvbCRL3IKJiHgsYZETu9RId2eH2fJsTy5acpU8TwiYC2YJjHXK', '2020-06-10 22:14:01', '2020-06-10 22:14:01', 'Corps', NULL),
(100, 1, 5, 153, 1, NULL, NULL, NULL, 'Wilton Nunes Gomes da Silva', 'gerador@teste.com', '$2y$10$AU9Y2FNGnGLx7/zYoEBCkOYQZeM1fuAvXPOszV0wXAGtvAYhaYMG2', '2020-07-01 17:13:52', '2020-07-01 17:13:52', 'Wil', NULL),
(101, 1, 6, 155, 1, NULL, NULL, NULL, 'Wil Emp', 'wil_reciclador@teste.com', '$2y$10$fFhsWdd.BaiNefCxEFR5YOnjQG27bpfW/yoW0q/n37ST2do9ITyOi', '2020-07-02 19:15:50', '2020-07-02 19:15:50', 'Wilton Empresa', NULL),
(102, 1, 6, 156, 1, NULL, NULL, NULL, 'Corps Teste', 'corpsteste2@teste.com', '$2y$10$GBpAntiXy3G3WnyJoE17ee0MY0CXBshFV6l3lR7YtAenAcnCt9QWq', '2020-07-03 21:10:17', '2020-07-03 21:10:17', 'Corps Teste', NULL),
(103, 1, 4, 157, 1, NULL, NULL, NULL, 'José Nunes da Silva', 'jose_coletor@teste.com', '$2y$10$Jiifp/bHFXzcfxWdzuybZewYT.mWDBLLzh9HCOTVVjFxidunt3B5O', '2020-07-06 19:56:07', '2020-07-06 19:56:07', 'Zé', 1),
(104, 1, 5, 158, 1, NULL, NULL, NULL, 'Sonia Maria Gomes da Silva', 'sonia_gerador@teste.com', '$2y$10$Z.xE6YHAA5xJS4GVo4Hfre.8MlZIS/YwB8of.GiI2QIUZTAojAPaG', '2020-07-06 20:40:17', '2020-07-06 20:40:17', 'Sonia', NULL),
(105, 1, 6, 159, 1, NULL, NULL, NULL, 'Empresa Recicladora Ltda', 'will_nunnes@hotmail.com', '$2y$10$0JepLWEgLTZYPK/lyqS5NuKRjBdb1ftVCzzK2XLK9sPLoNrbcYtX6', '2020-07-07 13:02:38', '2020-07-10 17:11:29', 'Empresa Recicladora', NULL),
(106, 1, 4, 160, 1, NULL, NULL, NULL, 'Jeremias José', 'jeremias_coletor@teste.com', '$2y$10$bWdAHqRpdJuFq/44foXpQO/fXxcbOb5HhjwFQcnEcaAbU1yt0Dw5S', '2020-07-14 12:48:32', '2020-07-14 12:48:32', 'Jeremias', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_categories`
--

CREATE TABLE `users_categories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `users_categories`
--

INSERT INTO `users_categories` (`id`, `user_id`, `categorie_id`) VALUES
(1, 66, 1),
(6, 68, 0),
(7, 69, 0),
(8, 72, 2),
(9, 72, 10),
(10, 72, 9),
(11, 73, 9),
(12, 73, 11),
(13, 73, 4),
(14, 73, 7),
(15, 74, 10),
(16, 74, 9),
(17, 76, 8),
(18, 76, 6),
(19, 78, 8),
(20, 83, 8),
(21, 83, 6),
(22, 85, 11),
(23, 85, 13),
(24, 85, 4),
(25, 86, 11),
(26, 86, 13),
(27, 87, 11),
(28, 87, 10),
(29, 87, 13),
(30, 89, 11),
(31, 89, 10),
(32, 101, 5),
(33, 101, 4),
(34, 101, 3),
(35, 102, 3),
(36, 102, 6),
(37, 105, 3),
(38, 105, 5),
(39, 105, 9),
(40, 105, 6),
(41, 105, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_types`
--

CREATE TABLE `users_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `public` tinyint(1) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `users_types`
--

INSERT INTO `users_types` (`id`, `type`, `active`, `public`, `created`, `modified`) VALUES
(1, 'Administrador', 1, 1, '2019-11-01 21:32:57', '2019-11-01 21:32:57'),
(3, 'TI', 1, 0, '2019-11-01 21:33:01', '2019-11-01 21:33:01'),
(4, 'Prestador', 1, 1, '2019-11-12 09:17:15', '2019-11-12 09:17:15'),
(5, 'Cliente', 1, 1, '2019-12-11 10:26:39', '2019-12-11 10:26:39'),
(6, 'Reciclador', 1, 1, '2020-05-21 15:26:47', '2020-05-21 15:26:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_types_has_modules`
--

CREATE TABLE `users_types_has_modules` (
  `id` int(11) NOT NULL,
  `users_types_id` int(11) DEFAULT NULL,
  `modules_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `users_types_has_modules`
--

INSERT INTO `users_types_has_modules` (`id`, `users_types_id`, `modules_id`, `created`, `modified`) VALUES
(1, 1, 1, '2018-09-23 21:38:51', '2018-03-30 14:17:10'),
(3, 3, 1, '2018-09-23 21:38:56', '2018-03-30 14:17:56'),
(4, 3, 2, '2018-09-23 21:39:48', '2018-03-30 14:17:56'),
(12, 3, 3, '2018-09-23 21:39:50', '2018-09-23 20:14:00'),
(32, 3, 6, '2019-09-07 18:52:46', '2019-09-07 18:52:46'),
(33, 3, 7, '2019-09-22 00:40:14', '2019-09-22 00:40:14'),
(34, 3, 8, '2019-10-07 11:34:54', '2019-10-07 11:34:54'),
(35, 1, 6, '2019-10-07 11:35:09', '2019-10-07 11:35:09'),
(36, 1, 7, '2019-10-07 11:35:09', '2019-10-07 11:35:09'),
(37, 1, 8, '2019-10-07 11:35:09', '2019-10-07 11:35:09'),
(38, 1, 9, '2019-10-19 22:23:48', '2019-10-19 22:23:48'),
(39, 3, 9, '2019-10-19 22:23:52', '2019-10-19 22:23:52'),
(40, 1, 10, '2019-11-01 21:32:57', '2019-11-01 21:32:57'),
(41, 3, 10, '2019-11-01 21:33:01', '2019-11-01 21:33:01');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_orders_id_2` (`service_orders_id`,`providers_id`),
  ADD KEY `service_orders_id` (`service_orders_id`),
  ADD KEY `providers_id` (`providers_id`);

--
-- Índices para tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id` (`company_id`);

--
-- Índices para tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`);

--
-- Índices para tabela `clients_images`
--
ALTER TABLE `clients_images`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `collection_orders`
--
ALTER TABLE `collection_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Índices para tabela `collection_orders_categories`
--
ALTER TABLE `collection_orders_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_orders_id` (`collection_orders_id`),
  ADD KEY `categories_id` (`categorie_id`);

--
-- Índices para tabela `collection_orders_images`
--
ALTER TABLE `collection_orders_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path` (`path`),
  ADD KEY `collection_orders_id` (`collection_orders_id`);

--
-- Índices para tabela `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resale_plans_id` (`resale_plans_id`);

--
-- Índices para tabela `emails_log`
--
ALTER TABLE `emails_log`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `error_logs`
--
ALTER TABLE `error_logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `gatways`
--
ALTER TABLE `gatways`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id` (`companies_id`);

--
-- Índices para tabela `log_account_balance`
--
ALTER TABLE `log_account_balance`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `margin`
--
ALTER TABLE `margin`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `modules_has_companies`
--
ALTER TABLE `modules_has_companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id` (`company_id`),
  ADD KEY `modules_id` (`modules_id`);

--
-- Índices para tabela `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `company_id` (`company_id`);

--
-- Índices para tabela `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modules_id` (`modules_id`),
  ADD KEY `id` (`id`);

--
-- Índices para tabela `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Índices para tabela `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pre_users`
--
ALTER TABLE `pre_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `users_type_id` (`users_type_id`),
  ADD KEY `people_id` (`people_id`);

--
-- Índices para tabela `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id` (`companies_id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Índices para tabela `providers_images`
--
ALTER TABLE `providers_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `providers_id` (`providers_id`);

--
-- Índices para tabela `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id` (`companies_id`),
  ADD KEY `service_orders_id` (`service_orders_id`),
  ADD KEY `clients_id` (`clients_id`),
  ADD KEY `providers_id` (`providers_id`);

--
-- Índices para tabela `resale_plans`
--
ALTER TABLE `resale_plans`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `service_orders`
--
ALTER TABLE `service_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id` (`companies_id`),
  ADD KEY `clients_id` (`clients_id`),
  ADD KEY `providers_id` (`providers_id`),
  ADD KEY `categories_id` (`categories_id`),
  ADD KEY `subcategories_id` (`subcategories_id`);

--
-- Índices para tabela `service_orders_images`
--
ALTER TABLE `service_orders_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path` (`path`),
  ADD KEY `service_orders_id` (`service_orders_id`);

--
-- Índices para tabela `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Índices para tabela `unregistered_users`
--
ALTER TABLE `unregistered_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id` (`company_id`),
  ADD KEY `users_types_id` (`users_types_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Índices para tabela `users_categories`
--
ALTER TABLE `users_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`user_id`),
  ADD KEY `categories_id` (`categorie_id`);

--
-- Índices para tabela `users_types`
--
ALTER TABLE `users_types`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users_types_has_modules`
--
ALTER TABLE `users_types_has_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_types_id` (`users_types_id`),
  ADD KEY `modules_id` (`modules_id`),
  ADD KEY `modules_id_2` (`modules_id`),
  ADD KEY `users_types_id_2` (`users_types_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de tabela `clients_images`
--
ALTER TABLE `clients_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `collection_orders`
--
ALTER TABLE `collection_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `collection_orders_categories`
--
ALTER TABLE `collection_orders_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de tabela `collection_orders_images`
--
ALTER TABLE `collection_orders_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `emails_log`
--
ALTER TABLE `emails_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `error_logs`
--
ALTER TABLE `error_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `gatways`
--
ALTER TABLE `gatways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de tabela `log_account_balance`
--
ALTER TABLE `log_account_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `margin`
--
ALTER TABLE `margin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `modules_has_companies`
--
ALTER TABLE `modules_has_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de tabela `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pre_users`
--
ALTER TABLE `pre_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `providers_images`
--
ALTER TABLE `providers_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `resale_plans`
--
ALTER TABLE `resale_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `service_orders`
--
ALTER TABLE `service_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT de tabela `service_orders_images`
--
ALTER TABLE `service_orders_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `unregistered_users`
--
ALTER TABLE `unregistered_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de tabela `users_categories`
--
ALTER TABLE `users_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `users_types`
--
ALTER TABLE `users_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `users_types_has_modules`
--
ALTER TABLE `users_types_has_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`service_orders_id`) REFERENCES `service_orders` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `budgets_ibfk_2` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `collection_orders_images`
--
ALTER TABLE `collection_orders_images`
  ADD CONSTRAINT `collection_orders_images_ibfk_1` FOREIGN KEY (`collection_orders_id`) REFERENCES `collection_orders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`resale_plans_id`) REFERENCES `resale_plans` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`companies_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `modules_has_companies`
--
ALTER TABLE `modules_has_companies`
  ADD CONSTRAINT `modules_has_companies_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `modules_has_companies_ibfk_2` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `people_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `providers_ibfk_1` FOREIGN KEY (`companies_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `providers_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `providers_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `providers_ibfk_4` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `service_orders_images`
--
ALTER TABLE `service_orders_images`
  ADD CONSTRAINT `service_orders_images_ibfk_1` FOREIGN KEY (`service_orders_id`) REFERENCES `service_orders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;