-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 07/09/2019 às 17:56
-- Versão do servidor: 5.7.24
-- Versão do PHP: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `nv2019`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `number_users` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `resale_plans_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `companies`
--

INSERT INTO `companies` (`id`, `name`, `number_users`, `created`, `modified`, `active`, `image`, `resale_plans_id`) VALUES
(1, 'Empresa ZX', 100, '2018-03-30 13:02:35', '2019-09-07 17:46:07', 1, 'upload/companies/1/5d73ecdf728b4.jpg', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `error_logs`
--

CREATE TABLE `error_logs` (
  `id` int(11) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `branches_id` bigint(20) DEFAULT NULL,
  `users_id` bigint(20) DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `action_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `exception` text COLLATE utf8_bin,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `icon` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `modules`
--

INSERT INTO `modules` (`id`, `name`, `created`, `modified`, `icon`, `active`) VALUES
(1, 'Opções', '2018-10-12 11:22:58', '2018-10-12 11:22:58', 'fa fa-cogs', 1),
(2, 'Ti', '2018-03-30 13:04:17', '2018-03-30 03:00:00', 'fa fa-bug', 1),
(3, 'Empresa', '2018-03-30 13:15:29', '2018-03-30 13:15:29', 'fa fa-building', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `modules_has_companies`
--

CREATE TABLE `modules_has_companies` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `modules_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `modules_has_companies`
--

INSERT INTO `modules_has_companies` (`id`, `company_id`, `modules_id`, `created`, `modified`) VALUES
(8, 1, 2, '2018-09-25 00:27:36', '2018-09-23 20:12:10'),
(16, 1, 1, '2018-09-29 18:05:00', '2018-09-29 18:05:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `cpf` varchar(24) COLLATE utf8_bin NOT NULL,
  `rg` varchar(24) COLLATE utf8_bin NOT NULL,
  `institution_rg` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(72) COLLATE utf8_bin NOT NULL,
  `number_contact` varchar(28) COLLATE utf8_bin NOT NULL,
  `address` varchar(255) COLLATE utf8_bin NOT NULL,
  `number` varchar(28) COLLATE utf8_bin NOT NULL,
  `district` varchar(128) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `cep` varchar(56) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `people`
--

INSERT INTO `people` (`id`, `company_id`, `name`, `cpf`, `rg`, `institution_rg`, `date_of_birth`, `email`, `number_contact`, `address`, `number`, `district`, `active`, `cep`, `created`, `modified`) VALUES
(22, 1, 'Fabiano  Adm', '1256315277', '718218', 'SSPRN', '2019-01-31', 'teste@teste.com.br', '8499889892', 'Rua Do Mar', '21892', 'Teste', 1, '59008382', '2019-01-31 16:50:20', '2019-01-31 16:50:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `modules_id` int(11) NOT NULL,
  `order_view` int(11) NOT NULL DEFAULT '1',
  `controller` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `permissions`
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
(16, 'Provas', 6, 2, 'Exams', 1, '2018-11-07 23:30:34', '2018-11-07 23:30:34'),
(17, 'Unidades', 7, 1, 'Units', 1, '2018-11-19 16:42:55', '2018-11-19 16:42:55'),
(18, 'Sub-Comissões', 7, 2, 'Subcommittees', 1, '2018-11-19 16:34:42', '2018-11-19 16:34:42'),
(19, 'Avaliados', 8, 1, 'Evaluations', 1, '2019-01-10 10:11:15', '2019-01-10 10:11:15'),
(20, 'Survey', 8, 1, 'Survey', 0, '2019-01-10 10:11:45', '2019-01-10 10:11:29'),
(21, 'Avaliações de desempenho', 9, 1, 'EvaluationsExamine', 1, '2019-01-14 22:39:55', '2019-01-14 22:39:55'),
(22, 'Avaliado', 10, 1, 'ReportsEvaluations', 1, '2019-01-19 14:31:33', '2019-01-19 14:31:33'),
(23, 'Processos', 10, 1, 'ReportsProcess', 1, '2019-01-18 22:10:34', '2019-01-18 22:10:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20181119165347, 'Initial', '2018-11-19 19:53:47', '2018-11-19 19:53:47', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pre_users`
--

CREATE TABLE `pre_users` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `users_type_id` int(11) NOT NULL,
  `people_id` int(11) DEFAULT NULL,
  `email` varchar(72) COLLATE utf8_bin NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `type_action` enum('new','reset') COLLATE utf8_bin NOT NULL,
  `hash` varchar(64) COLLATE utf8_bin NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `resale_plans`
--

CREATE TABLE `resale_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `slug` varchar(255) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `users` int(11) NOT NULL DEFAULT '0',
  `value` decimal(19,2) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `resale_plans`
--

INSERT INTO `resale_plans` (`id`, `name`, `slug`, `active`, `users`, `value`, `created`, `modified`) VALUES
(1, 'Ruby', 'ruby', 1, 0, '100.00', '2018-03-30 13:01:11', '2018-03-30 13:01:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `users_types_id` int(11) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `image_dir` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `company_id`, `users_types_id`, `person_id`, `active`, `image`, `image_dir`, `photo`, `name`, `email`, `password`, `created`, `modified`) VALUES
(1, 1, 3, 22, 1, 'upload/users/1/5d73c7dbbd105.jpg', '', NULL, 'Fabiano', 'adm@adm.com.br', '$2y$10$eiae6x6QhD9R3w0Xsuf7LOhuDhmUuBU6dUC8hN0aWSI0V5r5dM8j.', '2018-03-30 14:19:03', '2019-09-07 15:08:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users_types`
--

CREATE TABLE `users_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `users_types`
--

INSERT INTO `users_types` (`id`, `type`, `active`, `public`, `created`, `modified`) VALUES
(1, 'Administrador', 1, 1, '2019-09-07 17:31:06', '2019-09-07 17:31:06'),
(3, 'TI', 1, 0, '2019-01-18 22:15:10', '2019-01-18 22:15:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users_types_has_modules`
--

CREATE TABLE `users_types_has_modules` (
  `id` int(11) NOT NULL,
  `users_types_id` int(11) DEFAULT NULL,
  `modules_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Despejando dados para a tabela `users_types_has_modules`
--

INSERT INTO `users_types_has_modules` (`id`, `users_types_id`, `modules_id`, `created`, `modified`) VALUES
(1, 1, 1, '2018-09-23 21:38:51', '2018-03-30 14:17:10'),
(3, 3, 1, '2018-09-23 21:38:56', '2018-03-30 14:17:56'),
(4, 3, 2, '2018-09-23 21:39:48', '2018-03-30 14:17:56'),
(12, 3, 3, '2018-09-23 21:39:50', '2018-09-23 20:14:00');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resale_plans_id` (`resale_plans_id`);

--
-- Índices de tabela `error_logs`
--
ALTER TABLE `error_logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `modules_has_companies`
--
ALTER TABLE `modules_has_companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id` (`company_id`),
  ADD KEY `modules_id` (`modules_id`);

--
-- Índices de tabela `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Índices de tabela `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modules_id` (`modules_id`),
  ADD KEY `id` (`id`);

--
-- Índices de tabela `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Índices de tabela `pre_users`
--
ALTER TABLE `pre_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `users_type_id` (`users_type_id`),
  ADD KEY `people_id` (`people_id`);

--
-- Índices de tabela `resale_plans`
--
ALTER TABLE `resale_plans`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id` (`company_id`),
  ADD KEY `users_types_id` (`users_types_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Índices de tabela `users_types`
--
ALTER TABLE `users_types`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users_types_has_modules`
--
ALTER TABLE `users_types_has_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_types_id` (`users_types_id`),
  ADD KEY `modules_id` (`modules_id`),
  ADD KEY `modules_id_2` (`modules_id`),
  ADD KEY `users_types_id_2` (`users_types_id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `error_logs`
--
ALTER TABLE `error_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `modules_has_companies`
--
ALTER TABLE `modules_has_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `pre_users`
--
ALTER TABLE `pre_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `resale_plans`
--
ALTER TABLE `resale_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `users_types`
--
ALTER TABLE `users_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users_types_has_modules`
--
ALTER TABLE `users_types_has_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`resale_plans_id`) REFERENCES `resale_plans` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Restrições para tabelas `modules_has_companies`
--
ALTER TABLE `modules_has_companies`
  ADD CONSTRAINT `modules_has_companies_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `modules_has_companies_ibfk_2` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `people_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`modules_id`) REFERENCES `snad`.`modules` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`users_types_id`) REFERENCES `users_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `users_types_has_modules`
--
ALTER TABLE `users_types_has_modules`
  ADD CONSTRAINT `users_types_has_modules_ibfk_1` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_types_has_modules_ibfk_2` FOREIGN KEY (`users_types_id`) REFERENCES `users_types` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
