-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Ago-2024 às 19:01
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `simarco_bd`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consulta_id` bigint(20) UNSIGNED DEFAULT NULL,
  `forma_pagamento` enum('Cash','Via Seguro de Saude','Via Empresa') NOT NULL,
  `dia` date NOT NULL,
  `horario` time NOT NULL,
  `paciente_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `consulta_id`, `forma_pagamento`, `dia`, `horario`, `paciente_id`, `created_at`, `updated_at`) VALUES
(16, 61, 'Via Seguro de Saude', '2024-08-19', '08:00:00', 29, '2024-08-14 14:10:03', '2024-08-14 14:11:30'),
(17, 62, 'Via Seguro de Saude', '2024-08-19', '08:31:00', 31, '2024-08-14 15:19:23', '2024-08-14 15:19:57'),
(18, 63, 'Via Seguro de Saude', '2024-08-19', '09:02:00', 33, '2024-08-14 18:11:13', '2024-08-14 18:11:56'),
(20, 65, 'Via Seguro de Saude', '2024-09-02', '11:37:00', 36, '2024-08-15 05:53:13', '2024-08-15 05:53:56'),
(21, 66, 'Via Seguro de Saude', '2024-09-09', '11:37:00', 37, '2024-08-15 09:51:04', '2024-08-15 09:52:36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento_disponibilidade`
--

CREATE TABLE `agendamento_disponibilidade` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agendamento_id` bigint(20) UNSIGNED NOT NULL,
  `disponibilidade_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `agendamento_disponibilidade`
--

INSERT INTO `agendamento_disponibilidade` (`id`, `agendamento_id`, `disponibilidade_id`, `created_at`, `updated_at`) VALUES
(16, 16, 30, '2024-08-14 14:10:03', '2024-08-14 14:10:03'),
(17, 17, 30, '2024-08-14 15:19:23', '2024-08-14 15:19:23'),
(18, 18, 30, '2024-08-14 18:11:13', '2024-08-14 18:11:13'),
(20, 20, 30, '2024-08-15 05:53:13', '2024-08-15 05:53:13'),
(21, 21, 31, '2024-08-15 09:51:04', '2024-08-15 09:51:04');

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agendamento_id` bigint(20) UNSIGNED DEFAULT NULL,
  `data_consulta` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `medico_id` bigint(20) UNSIGNED NOT NULL,
  `paciente_id` bigint(20) UNSIGNED NOT NULL,
  `foto_1` varchar(255) DEFAULT NULL,
  `foto_2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `consultas`
--

INSERT INTO `consultas` (`id`, `agendamento_id`, `data_consulta`, `created_at`, `updated_at`, `hora_inicio`, `hora_fim`, `medico_id`, `paciente_id`, `foto_1`, `foto_2`) VALUES
(61, 16, '2024-08-19', '2024-08-14 14:11:30', '2024-08-14 14:11:30', '08:00:00', '08:30:00', 4, 29, 'public/fotos_consultas/Eleuterio_Zacarias_2024-08-19_08-00/Eleuterio_Zacarias_foto1.jpeg', 'public/fotos_consultas/Eleuterio_Zacarias_2024-08-19_08-00/Eleuterio_Zacarias_foto2.jpeg'),
(62, 17, '2024-08-19', '2024-08-14 15:19:57', '2024-08-14 15:19:57', '08:31:00', '09:01:00', 4, 31, 'public/fotos_consultas/Vanio_Anibal_Macamo_2024-08-19_08-31/Vanio_Anibal_Macamo_foto1.jpeg', 'public/fotos_consultas/Vanio_Anibal_Macamo_2024-08-19_08-31/Vanio_Anibal_Macamo_foto2.jpeg'),
(63, 18, '2024-08-19', '2024-08-14 18:11:56', '2024-08-14 18:11:56', '09:02:00', '09:32:00', 4, 33, 'public/fotos_consultas/Edilson_Bila_2024-08-19_09-02/Edilson_Bila_foto1.jpeg', 'public/fotos_consultas/Edilson_Bila_2024-08-19_09-02/Edilson_Bila_foto2.jpeg'),
(65, 20, '2024-09-02', '2024-08-15 05:53:56', '2024-08-15 05:53:56', '11:37:00', '12:07:00', 4, 36, 'public/fotos_consultas/Eleuterio_Zacarias_Mabecuane_2024-09-02_11-37/Eleuterio_Zacarias_Mabecuane_foto1.jpeg', 'public/fotos_consultas/Eleuterio_Zacarias_Mabecuane_2024-09-02_11-37/Eleuterio_Zacarias_Mabecuane_foto2.jpeg'),
(66, 21, '2024-09-09', '2024-08-15 09:52:36', '2024-08-15 09:52:36', '11:37:00', '12:07:00', 4, 37, 'public/fotos_consultas/Miguel_Armando_2024-09-09_11-37/Miguel_Armando_foto1.jpeg', 'public/fotos_consultas/Miguel_Armando_2024-09-09_11-37/Miguel_Armando_foto2.jpeg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `diagnosticos`
--

CREATE TABLE `diagnosticos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_diagnostico` date NOT NULL,
  `descricao` text NOT NULL,
  `observacoes` text DEFAULT NULL,
  `consulta_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `diagnosticos`
--

INSERT INTO `diagnosticos` (`id`, `data_diagnostico`, `descricao`, `observacoes`, `consulta_id`, `created_at`, `updated_at`) VALUES
(23, '2024-08-14', 'sdasd', 'asds', 61, '2024-08-14 14:11:42', '2024-08-14 14:11:42'),
(24, '2024-08-14', 'ddcc', 'ssss', 62, '2024-08-14 15:20:13', '2024-08-14 15:20:13'),
(25, '2024-08-14', 'cvxvx', 'cxvxvcx', 63, '2024-08-14 18:12:06', '2024-08-14 18:12:06'),
(27, '2024-08-15', 'fdfdsfds', 'sfsfdfds', 65, '2024-08-15 05:54:13', '2024-08-15 05:54:13'),
(28, '2024-08-15', 'sds', 'sdsd', 66, '2024-08-15 09:52:47', '2024-08-15 09:52:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disponibilidades`
--

CREATE TABLE `disponibilidades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dia_semana` enum('Segunda','Terça','Quarta','Quinta','Sexta') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `medico_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `disponibilidades`
--

INSERT INTO `disponibilidades` (`id`, `dia_semana`, `created_at`, `updated_at`, `medico_id`) VALUES
(30, 'Segunda', '2024-08-06 11:48:50', '2024-08-06 12:21:21', 4),
(31, 'Segunda', '2024-08-06 12:43:44', '2024-08-06 12:43:44', 4),
(32, 'Segunda', '2024-08-06 12:51:26', '2024-08-06 12:51:26', 2),
(33, 'Segunda', '2024-08-08 10:33:37', '2024-08-08 10:33:37', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sigla` varchar(255) DEFAULT NULL,
  `nuit` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contacto1` varchar(255) NOT NULL,
  `contacto2` varchar(255) DEFAULT NULL,
  `localizacao` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `empresas`
--

INSERT INTO `empresas` (`id`, `nome`, `sigla`, `nuit`, `email`, `contacto1`, `contacto2`, `localizacao`, `created_at`, `updated_at`) VALUES
(1, 'Vodacom Moçambique', 'VM', '600000000', 'info@vodacom.co.mz', '822000000', '842000000', 'Maputo, Moçambique', NULL, NULL),
(2, 'Emose (Empresa Moçambicana de Seguros)', 'EMOSE', '600000001', 'info@emose.co.mz', '825000000', '843000000', 'Maputo, Moçambique', NULL, NULL),
(3, 'Caminhos de Ferro de Moçambique', 'CFM', '600000002', 'info@cfm.co.mz', '824000000', '844000000', 'Beira, Moçambique', NULL, NULL),
(4, 'Aeroportos de Moçambique', 'AdM', '600000003', 'info@aeroportos.co.mz', '823000000', '845000000', 'Maputo, Moçambique', NULL, NULL),
(5, 'HCB (Hidráulica de Cahora Bassa)', 'HCB', '600000004', 'info@hcb.co.mz', '821500000', '842500000', 'Tete, Moçambique', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `especialidades`
--

CREATE TABLE `especialidades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `descricao` varchar(255) NOT NULL,
  `preco` decimal(8,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `especialidades`
--

INSERT INTO `especialidades` (`id`, `created_at`, `updated_at`, `descricao`, `preco`, `imagem`) VALUES
(1, NULL, NULL, 'Cirurgião', 600.00, '4.png'),
(2, NULL, NULL, 'Genecologista', 5000.00, 'genicologia.jpg'),
(3, NULL, NULL, 'Geral', 8000.00, 'geral.jpg'),
(4, NULL, NULL, 'Psicologo', 2500.00, 'psicologos.jpg'),
(12, NULL, NULL, 'Teste 1', 750.00, 'kanban.png'),
(13, NULL, NULL, 'wiwi', 1000.00, 'STP.png'),
(14, NULL, NULL, 'Oftalmogista', 200.00, '181339984_padded_logo.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fabricantes`
--

CREATE TABLE `fabricantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `contacto` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `fabricantes`
--

INSERT INTO `fabricantes` (`id`, `nome`, `endereco`, `contacto`, `created_at`, `updated_at`) VALUES
(1, 'Meditox Fab', 'khongolote', '8787878', '2024-01-12 17:34:58', '2024-04-29 15:43:11'),
(2, 'Vanio Medd', 'khongolote6', 'hgfhgfgfh', '2024-01-12 21:35:09', '2024-04-29 15:43:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_farmaceuticas`
--

CREATE TABLE `formas_farmaceuticas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `formas_farmaceuticas`
--

INSERT INTO `formas_farmaceuticas` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'Vacina', '2024-01-12 17:34:35', '2024-01-12 17:34:35'),
(2, 'bbbbbbbb', '2024-01-12 21:36:06', '2024-01-12 21:36:06'),
(3, 'Comprimido', '2024-04-29 15:35:19', '2024-04-29 15:35:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_pagamento`
--

CREATE TABLE `formas_pagamento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gravidades`
--

CREATE TABLE `gravidades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gravidades`
--

INSERT INTO `gravidades` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'Baixa', NULL, NULL),
(2, 'Alta', NULL, NULL),
(3, 'Media', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome_medicamento` varchar(255) NOT NULL,
  `substancias_quimicas` text NOT NULL,
  `forma_farmaceutica_id` bigint(20) UNSIGNED NOT NULL,
  `dosagem` varchar(255) NOT NULL,
  `via_administracao_id` bigint(20) UNSIGNED NOT NULL,
  `fabricante_id` bigint(20) UNSIGNED NOT NULL,
  `numero_registo` varchar(255) NOT NULL,
  `data_fabricacao` date NOT NULL,
  `data_validade` date NOT NULL,
  `indicacoes` text NOT NULL,
  `contraindicacoes` text NOT NULL,
  `efeitos_colaterais` text NOT NULL,
  `instrucoes_uso` text NOT NULL,
  `armazenamento` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `disponibilidade` enum('disponivel','indisponivel') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `medicamentos`
--

INSERT INTO `medicamentos` (`id`, `nome_medicamento`, `substancias_quimicas`, `forma_farmaceutica_id`, `dosagem`, `via_administracao_id`, `fabricante_id`, `numero_registo`, `data_fabricacao`, `data_validade`, `indicacoes`, `contraindicacoes`, `efeitos_colaterais`, `instrucoes_uso`, `armazenamento`, `preco`, `disponibilidade`, `created_at`, `updated_at`) VALUES
(1, 'Paracetamol', 'assa', 1, '12', 1, 1, '121212', '2024-01-13', '2024-01-25', 'junior', 'sdfsgsdgdsfs', 'sdfsfdff', 'hjgjhjgkghhjjhgjgj', 'jhgjgjhgjhg', 12.00, 'disponivel', '2024-01-12 18:07:34', '2024-01-12 20:25:22'),
(3, 'Fenox', '1', 3, '1', 3, 2, '322', '2024-04-01', '2024-05-11', '122112', '211221', '122112', '122112', '1212', 1200.00, 'disponivel', '2024-04-29 16:02:21', '2024-04-29 16:02:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicos`
--

CREATE TABLE `medicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `disponibilidade` varchar(255) NOT NULL,
  `especialidade_id` bigint(20) UNSIGNED NOT NULL,
  `numero_identificacao` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `genero` varchar(255) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `medicos`
--

INSERT INTO `medicos` (`id`, `nome`, `disponibilidade`, `especialidade_id`, `numero_identificacao`, `created_at`, `updated_at`, `genero`, `imagem`) VALUES
(1, 'Felisberto Magaiva', 'disponivel', 4, '125541656555I', '2024-04-29 15:41:51', '2024-08-01 14:58:04', 'masculino', 'Looker_Studio-removebg-preview.png'),
(2, 'Adolf Hitler', 'disponivel', 13, '125541656555I', '2024-04-29 15:42:19', '2024-08-06 12:51:54', 'masculino', '181339984_padded_logo.png'),
(3, 'Ana Maria das Dores Macucule', 'disponivel', 4, '125541656555I', '2024-04-29 15:42:43', '2024-04-29 15:42:43', 'feminino', NULL),
(4, 'Vanio Anibal Macamo Junior', 'disponivel', 1, '125541656555I', '2024-06-18 15:16:41', '2024-08-14 10:14:49', 'masculino', 'Captura de ecrã_9-8-2024_222613_www.designevo.com.jpeg'),
(6, 'VAasdasdsad', 'disponivel', 1, 'a', '2024-07-04 06:07:53', '2024-07-04 06:07:53', 'masculino', 'Resultado a obter no server.png'),
(7, 'Edilson Bila', 'disponivel', 14, '989439834', '2024-08-08 10:32:53', '2024-08-08 10:32:53', 'feminino', 'STP.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_12_19_065309_create_pacientes_table', 1),
(7, '2024_01_05_185932_create_especialidades_table', 1),
(8, '2024_01_05_190417_add_descricao_to_especialidades_table', 1),
(9, '2024_01_05_194622_add_descricao_to_medicos_table', 1),
(10, '2024_01_06_093338_create_medicos_table', 1),
(11, '2024_01_06_142552_add_genero_to_medicos_table', 1),
(12, '2024_01_06_160000_create_status_consultas_table', 1),
(13, '2024_01_06_171451_create_consultas_table', 1),
(14, '2024_01_08_110404_add_campo_novo_to_medicos_table', 1),
(15, '2024_01_08_114341_add_horarios_to_consultas_table', 1),
(16, '2024_01_08_114542_remove_numero_identificacao_from_consultas_table', 1),
(17, '2024_01_08_115032_remove_duracao_from_consultas_table', 1),
(18, '2024_01_08_140938_add_medico_paciente_to_consultas_table', 1),
(19, '2024_01_10_105050_add_medico_to_consultas_table', 1),
(20, '2024_01_10_114820_add_paciente_to_consultas_table', 1),
(21, '2024_01_12_150000_create_via_administracaos_table', 1),
(22, '2024_01_12_154500_create_forma_farmaceuticas_table', 1),
(23, '2024_01_12_160000_create_fabricantes_table', 1),
(24, '2024_01_12_162449_create_medicamentos_table', 1),
(25, '2024_01_17_145443_create_diagnosticos_table', 2),
(26, '2024_01_17_145529_create_prescricoes_table', 2),
(27, '2024_01_18_073536_create_prescricao_medicamento_table', 2),
(28, '2024_01_18_074053_remove_dosagem_from_prescricoes_table', 2),
(29, '2024_01_18_074812_remove_medicamentos_from_prescricoes_table', 2),
(30, '2024_01_24_130131_adicionar_fk_status_antecessor_em_status_consultas', 2),
(31, '2024_01_28_134350_create_gravidades_table', 2),
(32, '2024_01_29_134350_create_sintomas_table', 2),
(33, '2024_05_21_083203_add_forma_pagamento_to_consultas_table', 3),
(34, '2024_06_18_081021_add_preco_to_especialidades_table', 4),
(35, '2024_06_18_152729_add_imagem_to_especialidades_table', 5),
(36, '2024_06_18_171058_adicionar_imagem_a_medicos_table', 6),
(37, '2024_07_03_075542_create_disponibilidades_table', 7),
(38, '2024_07_03_075941_add_columns_to_disponibilidades_table', 8),
(68, '2024_08_07_124200_update_forma_pagamento_enum_in_consultas_table', 10),
(77, '2024_08_07_120049_remove_id_status_from_consultas_table', 11),
(78, '2024_08_07_135608_create_formas_pagamento_table', 12),
(216, '2024_07_03_135959_create_agendamentos_table', 13),
(217, '2024_08_02_125642_update_disponibilidades_table', 13),
(218, '2024_08_02_155458_add_horario_to_agendamentos_table', 13),
(219, '2024_08_02_160506_update_dia_column_in_agendamentos', 13),
(220, '2024_08_05_141311_clean_invalid_horario_values', 13),
(221, '2024_08_05_141409_update_agendamentos_table', 13),
(222, '2024_08_05_162636_create_agendamento_disponibilidade_table', 13),
(223, '2024_08_07_081455_drop_foreign_keys_and_columns_from_consultas', 13),
(224, '2024_08_07_081839_add_agendamento_id_to_consultas_and_consulta_id_to_agendamentos', 13),
(225, '2024_08_07_135636_add_empresa_and_codigo_funcionario_to_consultas_table', 13),
(226, '2024_08_07_144859_add_cartao_seguro_saude_to_consultas_table', 13),
(227, '2024_08_07_180112_create_empresas_table', 13),
(228, '2024_08_07_193413_remove_empresa_codigo_funcionario_cartao_seguro_saude_from_consultas_table', 13),
(229, '2024_08_07_193444_add_empresa_codigo_funcionario_cartao_seguro_saude_to_pacientes_table', 13),
(230, '2024_08_07_215938_remove_empresa_column_from_pacientes_table', 13),
(231, '2024_08_07_220040_add_empresa_id_to_pacientes_table', 13),
(237, '2024_08_07_115739_remove_id_status_from_consultas_table', 14),
(238, '2024_08_07_220426_add_foreign_key_to_empresa_id_in_pacientes_table', 14),
(239, '2024_08_08_080615_add_instrucoes_to_prescricao_medicamento_table', 14),
(240, '2024_08_09_224956_add_forma_pagamento_to_agendamentos_table', 14),
(241, '2024_08_09_225029_remove_forma_pagamento_from_consultas_table', 14),
(242, '2024_08_10_115559_add_fotos_zip_to_consultas_table', 15),
(243, '2024_08_10_150947_update_consultas_table_add_columns_remove_fotos_zip', 16),
(244, '2024_08_10_163942_remove_observacoes_from_prescricoes_table', 16),
(245, '2024_08_10_164118_remove_observacoes_from_consultas_table', 16),
(246, '2024_08_13_170721_create_permission_tables', 17),
(247, '2024_08_13_171100_create_permission_tables', 18),
(248, '2024_08_14_102035_add_medico_paciente_to_users_table', 19),
(249, '2024_08_15_064507_remove_empresa_from_pacientes_table', 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `genero` varchar(255) NOT NULL,
  `numero_identificacao` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `empresa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `codigo_funcionario` varchar(255) DEFAULT NULL,
  `cartao_seguro_saude` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `nome`, `data_nascimento`, `genero`, `numero_identificacao`, `endereco`, `telefone`, `email`, `empresa_id`, `created_at`, `updated_at`, `codigo_funcionario`, `cartao_seguro_saude`) VALUES
(27, 'Ana Alcinda Chalala Chaúque', '2024-08-05', 'feminino', '21312341', 'Hulene A, Rua 15, Q. 48', '840000000', 'alcinda.chauque00@gmail.com', NULL, '2024-08-13 06:16:48', '2024-08-13 06:16:48', '1234', NULL),
(29, 'Eleuterio Zacarias', '2024-08-22', 'masculino', '101010166373', 'eee', '874867111', 'juniormabecuane7@gmail.com', 2, '2024-08-14 14:08:57', '2024-08-14 14:08:57', '1100', 'Eleuterio Zacarias____SIMARCO_DEA.pdf'),
(31, 'Vanio Anibal Macamo', '2024-08-23', 'masculino', '7757771', 'eee', '872275032', 'macamovanioanibal@gmail.com', 3, '2024-08-14 15:18:59', '2024-08-14 15:18:59', '11031280', 'Vanio Anibal Macamo____SIMARCO_DEA.pdf'),
(33, 'Edilson Bila', '2024-08-22', 'masculino', '009554544', 'alto-mae', '824201213', 'edilsonbila21@gmail', 3, '2024-08-14 18:10:40', '2024-08-14 18:10:40', '69696967669', 'Edilson Bila____SIMARCO_DEA.pdf'),
(35, 'Lourenco Vasco', '2024-08-17', 'masculino', '0008622197', 'eee', '872275032', 'lourencovasco696@gmail.com', 1, '2024-08-15 03:55:56', '2024-08-15 03:55:56', '100427823100', 'Lourenco Vasco____SIMARCO_DEA.pdf'),
(36, 'Eleuterio Zacarias Mabecuane', '2024-08-23', 'masculino', '111111111111112333', 'eee', '874867111', 'eleuteriomabecuane5@gmail.com', 4, '2024-08-15 05:52:43', '2024-08-15 05:52:43', '1525252100', 'Eleuterio Zacarias Mabecuane____SIMARCO_DEA.pdf'),
(37, 'Miguel Armando', '2024-08-16', 'masculino', '21532173153', 'alto-mae', '824201213', 'miguelarmando237@gmail.com', 3, '2024-08-15 09:50:19', '2024-08-15 09:50:20', '69611196969', 'Miguel Armando____Aula 1.1.pdf');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('eleuteriomabecuane5@gmail.com', '$2y$12$C2i34CDd5VbPDEUuzDXD3.PXdEGzwWwK8HCBDgQNAEIMQuljDdSwW', '2024-08-14 10:24:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view users', 'web', '2024-08-13 15:19:51', '2024-08-13 15:19:51'),
(2, 'edit users', 'web', '2024-08-13 15:19:51', '2024-08-13 15:19:51'),
(3, 'delete users', 'web', '2024-08-13 15:19:51', '2024-08-13 15:19:51'),
(4, 'create users', 'web', '2024-08-13 15:19:51', '2024-08-13 15:19:51'),
(5, 'view roles', 'web', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(6, 'create roles', 'web', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(7, 'edit roles', 'web', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(8, 'delete roles', 'web', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(9, 'view permissions', 'web', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(10, 'create permissions', 'web', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(11, 'edit permissions', 'web', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(12, 'delete permissions', 'web', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(13, 'view consultas', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(14, 'create consultas', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(15, 'edit consultas', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(16, 'delete consultas', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(17, 'view pacientes', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(18, 'create pacientes', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(19, 'edit pacientes', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(20, 'delete pacientes', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(21, 'view medicos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(22, 'create medicos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(23, 'edit medicos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(24, 'delete medicos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(25, 'view diagnosticos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(26, 'create diagnosticos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(27, 'edit diagnosticos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(28, 'delete diagnosticos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(29, 'view prescricoes', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(30, 'create prescricoes', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(31, 'edit prescricoes', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(32, 'delete prescricoes', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(33, 'view medicamentos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(34, 'create medicamentos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(35, 'edit medicamentos', 'web', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(36, 'delete medicamentos', 'web', '2024-08-13 17:14:50', '2024-08-13 17:14:50'),
(37, 'View gestao', 'web', '2024-08-13 17:38:25', '2024-08-13 17:38:25'),
(38, 'view Parametrizacao', 'web', '2024-08-13 17:38:25', '2024-08-13 17:38:25'),
(39, 'view dashboard', 'web', '2024-08-13 17:56:49', '2024-08-13 17:56:49'),
(40, 'start consultas', 'web', '2024-08-14 11:44:49', '2024-08-14 11:44:49');

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prescricao_medicamento`
--

CREATE TABLE `prescricao_medicamento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescricao_id` bigint(20) UNSIGNED NOT NULL,
  `medicamento_id` bigint(20) UNSIGNED NOT NULL,
  `dosagem` varchar(255) NOT NULL,
  `instrucoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `prescricao_medicamento`
--

INSERT INTO `prescricao_medicamento` (`id`, `prescricao_id`, `medicamento_id`, `dosagem`, `instrucoes`, `created_at`, `updated_at`) VALUES
(68, 35, 1, '6', '2 por dia', NULL, NULL),
(69, 35, 3, '3', '2 por dia', NULL, NULL),
(70, 36, 1, '6', '2 por dia', NULL, NULL),
(71, 36, 3, '3', '2 por dia', NULL, NULL),
(84, 43, 1, '6', '2 por dia', NULL, NULL),
(85, 43, 3, '3', '2 por dia', NULL, NULL),
(110, 56, 1, '6', '2 por dia', NULL, NULL),
(111, 56, 3, '3', '2 por dia', NULL, NULL),
(112, 57, 1, '6', '2 por dia', NULL, NULL),
(113, 57, 3, '3', '2 por dia', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prescricoes`
--

CREATE TABLE `prescricoes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_prescricao` date NOT NULL,
  `consulta_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `prescricoes`
--

INSERT INTO `prescricoes` (`id`, `data_prescricao`, `consulta_id`, `created_at`, `updated_at`) VALUES
(35, '2024-08-14', 62, '2024-08-14 17:59:21', '2024-08-14 17:59:21'),
(36, '2024-08-14', 63, '2024-08-14 18:12:42', '2024-08-14 18:12:42'),
(43, '2024-08-15', 61, '2024-08-15 05:49:57', '2024-08-15 05:49:57'),
(56, '2024-08-15', 66, '2024-08-15 10:54:06', '2024-08-15 10:54:06'),
(57, '2024-08-15', 65, '2024-08-15 11:02:25', '2024-08-15 11:02:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2024-08-13 15:19:51', '2024-08-13 15:19:51'),
(2, 'user', 'web', '2024-08-13 15:19:51', '2024-08-13 15:19:51'),
(3, 'aaaa', 'web', '2024-08-13 15:58:51', '2024-08-13 15:58:51'),
(4, 'Teste', 'web', '2024-08-13 16:07:49', '2024-08-13 16:07:49'),
(6, 'manager', 'web', '2024-08-13 17:02:53', '2024-08-13 17:02:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 6),
(2, 1),
(2, 6),
(3, 1),
(3, 3),
(4, 1),
(4, 3),
(5, 1),
(5, 6),
(6, 1),
(7, 1),
(7, 6),
(8, 1),
(9, 1),
(9, 6),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(13, 2),
(13, 6),
(14, 1),
(15, 1),
(15, 6),
(16, 1),
(17, 1),
(17, 2),
(17, 6),
(18, 1),
(19, 1),
(19, 6),
(20, 1),
(21, 1),
(21, 2),
(21, 6),
(22, 1),
(23, 1),
(23, 6),
(24, 1),
(25, 1),
(25, 2),
(25, 6),
(26, 1),
(27, 1),
(27, 6),
(28, 1),
(29, 1),
(29, 2),
(29, 6),
(30, 1),
(31, 1),
(31, 6),
(32, 1),
(33, 1),
(33, 2),
(33, 6),
(34, 1),
(35, 1),
(35, 6),
(36, 1),
(37, 1),
(37, 6),
(38, 1),
(38, 6),
(39, 1),
(39, 6),
(40, 1),
(40, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sintomas`
--

CREATE TABLE `sintomas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `duracao` varchar(255) NOT NULL,
  `consulta_id` bigint(20) UNSIGNED NOT NULL,
  `gravidade_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_consultas`
--

CREATE TABLE `status_consultas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_antecessor_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `status_consultas`
--

INSERT INTO `status_consultas` (`id`, `descricao`, `created_at`, `updated_at`, `status_antecessor_id`) VALUES
(1, 'Agendada', '2024-04-29 15:37:13', '2024-04-29 15:37:13', NULL),
(2, 'Confirmada', '2024-04-29 15:37:32', '2024-04-29 15:37:50', NULL),
(3, 'Realizada', '2024-04-29 15:37:42', '2024-04-29 15:37:42', NULL),
(4, 'Concluida', '2024-04-29 15:38:04', '2024-04-29 15:38:04', NULL),
(5, 'Em andamento', '2024-04-29 15:38:14', '2024-04-29 15:38:14', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `medico_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paciente_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `medico_id`, `paciente_id`) VALUES
(1, 'Vanio Macamo', 'macamovanioanibal@gmail.com', NULL, '$2y$12$GI7kHRlZHNgZy917rKjHEeG4iQvF/O7OaEjfaJWVe9.Yc6oyV4uxm', NULL, '2024-04-26 08:12:17', '2024-08-14 08:35:17', 4, NULL),
(2, 'Eleuterio Zacarias', 'juniormabecuane7@gmail.com', NULL, '$2y$12$/cTfTIWUOjfksg.4KFh9N.dIN/efLf9p4KNbVrW6cwaWFtNK3EuDq', NULL, '2024-08-09 19:06:29', '2024-08-09 19:06:29', NULL, NULL),
(4, 'Teste', 'testeSave@teste.co.mz', NULL, '$2y$12$xn7MfeyA3rySauVA6WH5Del2ZHH4BV7F9SAa8dLjuYyQq0ROUj45O', NULL, '2024-08-13 17:30:49', '2024-08-13 17:30:49', NULL, NULL),
(8, 'Eleuterio', 'eleuteriomabecuane5@gmail.com', NULL, '$2y$12$BFz6F9HGVlcY.GagkcB5WucgHnFXtmMbT4Cm2HSYaTMshaJRyXnHm', NULL, '2024-08-14 10:23:11', '2024-08-14 10:23:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `via_administracaos`
--

CREATE TABLE `via_administracaos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `via_administracaos`
--

INSERT INTO `via_administracaos` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'aaa', '2024-01-12 17:36:08', '2024-01-12 17:36:08'),
(2, 'bbbbbbb', '2024-01-12 21:35:41', '2024-01-12 21:35:41'),
(3, 'Oral', '2024-04-26 08:11:25', '2024-04-26 08:11:25'),
(4, 'Injectavel', '2024-04-26 08:11:25', '2024-04-26 08:11:25'),
(5, 'Topica', '2024-04-26 08:11:25', '2024-04-26 08:11:25'),
(6, 'Oral', '2024-08-13 17:02:27', '2024-08-13 17:02:27'),
(7, 'Injectavel', '2024-08-13 17:02:27', '2024-08-13 17:02:27'),
(8, 'Topica', '2024-08-13 17:02:27', '2024-08-13 17:02:27'),
(9, 'Oral', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(10, 'Injectavel', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(11, 'Topica', '2024-08-13 17:02:53', '2024-08-13 17:02:53'),
(12, 'Oral', '2024-08-13 17:13:21', '2024-08-13 17:13:21'),
(13, 'Injectavel', '2024-08-13 17:13:21', '2024-08-13 17:13:21'),
(14, 'Topica', '2024-08-13 17:13:21', '2024-08-13 17:13:21'),
(15, 'Oral', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(16, 'Injectavel', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(17, 'Topica', '2024-08-13 17:14:49', '2024-08-13 17:14:49'),
(18, 'Oral', '2024-08-13 17:38:25', '2024-08-13 17:38:25'),
(19, 'Injectavel', '2024-08-13 17:38:25', '2024-08-13 17:38:25'),
(20, 'Topica', '2024-08-13 17:38:25', '2024-08-13 17:38:25'),
(21, 'Oral', '2024-08-13 17:56:49', '2024-08-13 17:56:49'),
(22, 'Injectavel', '2024-08-13 17:56:49', '2024-08-13 17:56:49'),
(23, 'Topica', '2024-08-13 17:56:49', '2024-08-13 17:56:49'),
(24, 'Oral', '2024-08-14 11:44:49', '2024-08-14 11:44:49'),
(25, 'Injectavel', '2024-08-14 11:44:49', '2024-08-14 11:44:49'),
(26, 'Topica', '2024-08-14 11:44:49', '2024-08-14 11:44:49');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agendamentos_paciente_id_foreign` (`paciente_id`),
  ADD KEY `agendamentos_consulta_id_foreign` (`consulta_id`);

--
-- Índices para tabela `agendamento_disponibilidade`
--
ALTER TABLE `agendamento_disponibilidade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agendamento_disponibilidade_agendamento_id_foreign` (`agendamento_id`),
  ADD KEY `agendamento_disponibilidade_disponibilidade_id_foreign` (`disponibilidade_id`);

--
-- Índices para tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultas_medico_id_foreign` (`medico_id`),
  ADD KEY `consultas_paciente_id_foreign` (`paciente_id`),
  ADD KEY `consultas_agendamento_id_foreign` (`agendamento_id`);

--
-- Índices para tabela `diagnosticos`
--
ALTER TABLE `diagnosticos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diagnosticos_consulta_id_foreign` (`consulta_id`);

--
-- Índices para tabela `disponibilidades`
--
ALTER TABLE `disponibilidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disponibilidades_medico_id_foreign` (`medico_id`);

--
-- Índices para tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empresas_nuit_unique` (`nuit`),
  ADD UNIQUE KEY `empresas_email_unique` (`email`);

--
-- Índices para tabela `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `fabricantes`
--
ALTER TABLE `fabricantes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices para tabela `formas_farmaceuticas`
--
ALTER TABLE `formas_farmaceuticas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `gravidades`
--
ALTER TABLE `gravidades`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicamentos_forma_farmaceutica_id_foreign` (`forma_farmaceutica_id`),
  ADD KEY `medicamentos_via_administracao_id_foreign` (`via_administracao_id`),
  ADD KEY `medicamentos_fabricante_id_foreign` (`fabricante_id`);

--
-- Índices para tabela `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicos_especialidade_id_foreign` (`especialidade_id`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Índices para tabela `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Índices para tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pacientes_numero_identificacao_unique` (`numero_identificacao`),
  ADD UNIQUE KEY `pacientes_email_unique` (`email`),
  ADD KEY `pacientes_empresa_id_foreign` (`empresa_id`);

--
-- Índices para tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Índices para tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices para tabela `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Índices para tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices para tabela `prescricao_medicamento`
--
ALTER TABLE `prescricao_medicamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescricao_medicamento_prescricao_id_foreign` (`prescricao_id`),
  ADD KEY `prescricao_medicamento_medicamento_id_foreign` (`medicamento_id`);

--
-- Índices para tabela `prescricoes`
--
ALTER TABLE `prescricoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescricoes_consulta_id_foreign` (`consulta_id`);

--
-- Índices para tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Índices para tabela `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Índices para tabela `sintomas`
--
ALTER TABLE `sintomas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sintomas_consulta_id_foreign` (`consulta_id`),
  ADD KEY `sintomas_gravidade_id_foreign` (`gravidade_id`);

--
-- Índices para tabela `status_consultas`
--
ALTER TABLE `status_consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_consultas_status_antecessor_id_foreign` (`status_antecessor_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_medico_id_foreign` (`medico_id`),
  ADD KEY `users_paciente_id_foreign` (`paciente_id`);

--
-- Índices para tabela `via_administracaos`
--
ALTER TABLE `via_administracaos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `agendamento_disponibilidade`
--
ALTER TABLE `agendamento_disponibilidade`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `diagnosticos`
--
ALTER TABLE `diagnosticos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `disponibilidades`
--
ALTER TABLE `disponibilidades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `fabricantes`
--
ALTER TABLE `fabricantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `formas_farmaceuticas`
--
ALTER TABLE `formas_farmaceuticas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `gravidades`
--
ALTER TABLE `gravidades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `prescricao_medicamento`
--
ALTER TABLE `prescricao_medicamento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de tabela `prescricoes`
--
ALTER TABLE `prescricoes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `sintomas`
--
ALTER TABLE `sintomas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `status_consultas`
--
ALTER TABLE `status_consultas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `via_administracaos`
--
ALTER TABLE `via_administracaos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_consulta_id_foreign` FOREIGN KEY (`consulta_id`) REFERENCES `consultas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agendamentos_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `agendamento_disponibilidade`
--
ALTER TABLE `agendamento_disponibilidade`
  ADD CONSTRAINT `agendamento_disponibilidade_agendamento_id_foreign` FOREIGN KEY (`agendamento_id`) REFERENCES `agendamentos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agendamento_disponibilidade_disponibilidade_id_foreign` FOREIGN KEY (`disponibilidade_id`) REFERENCES `disponibilidades` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_agendamento_id_foreign` FOREIGN KEY (`agendamento_id`) REFERENCES `agendamentos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultas_medico_id_foreign` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`),
  ADD CONSTRAINT `consultas_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`);

--
-- Limitadores para a tabela `diagnosticos`
--
ALTER TABLE `diagnosticos`
  ADD CONSTRAINT `diagnosticos_consulta_id_foreign` FOREIGN KEY (`consulta_id`) REFERENCES `consultas` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `disponibilidades`
--
ALTER TABLE `disponibilidades`
  ADD CONSTRAINT `disponibilidades_medico_id_foreign` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD CONSTRAINT `medicamentos_fabricante_id_foreign` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricantes` (`id`),
  ADD CONSTRAINT `medicamentos_forma_farmaceutica_id_foreign` FOREIGN KEY (`forma_farmaceutica_id`) REFERENCES `formas_farmaceuticas` (`id`),
  ADD CONSTRAINT `medicamentos_via_administracao_id_foreign` FOREIGN KEY (`via_administracao_id`) REFERENCES `via_administracaos` (`id`);

--
-- Limitadores para a tabela `medicos`
--
ALTER TABLE `medicos`
  ADD CONSTRAINT `medicos_especialidade_id_foreign` FOREIGN KEY (`especialidade_id`) REFERENCES `especialidades` (`id`);

--
-- Limitadores para a tabela `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `prescricao_medicamento`
--
ALTER TABLE `prescricao_medicamento`
  ADD CONSTRAINT `prescricao_medicamento_medicamento_id_foreign` FOREIGN KEY (`medicamento_id`) REFERENCES `medicamentos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prescricao_medicamento_prescricao_id_foreign` FOREIGN KEY (`prescricao_id`) REFERENCES `prescricoes` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `prescricoes`
--
ALTER TABLE `prescricoes`
  ADD CONSTRAINT `prescricoes_consulta_id_foreign` FOREIGN KEY (`consulta_id`) REFERENCES `consultas` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `sintomas`
--
ALTER TABLE `sintomas`
  ADD CONSTRAINT `sintomas_consulta_id_foreign` FOREIGN KEY (`consulta_id`) REFERENCES `consultas` (`id`),
  ADD CONSTRAINT `sintomas_gravidade_id_foreign` FOREIGN KEY (`gravidade_id`) REFERENCES `gravidades` (`id`);

--
-- Limitadores para a tabela `status_consultas`
--
ALTER TABLE `status_consultas`
  ADD CONSTRAINT `status_consultas_status_antecessor_id_foreign` FOREIGN KEY (`status_antecessor_id`) REFERENCES `status_consultas` (`id`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_medico_id_foreign` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
