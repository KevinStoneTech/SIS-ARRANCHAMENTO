-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 12-Mar-2021 às 08:40
-- Versão do servidor: 8.0.23-0ubuntu0.20.04.1
-- versão do PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `arranchamento`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `arranchado`
--

CREATE TABLE `arranchado` (
  `id` int NOT NULL,
  `data` varchar(10) NOT NULL,
  `iduser` int NOT NULL,
  `idpgrad` int NOT NULL,
  `idsu` int NOT NULL,
  `nomeguerra` varchar(40) NOT NULL,
  `cafe` varchar(3) NOT NULL,
  `almoco` varchar(3) NOT NULL,
  `jantar` varchar(3) NOT NULL,
  `datagrava` varchar(10) NOT NULL,
  `horagrava` varchar(10) NOT NULL,
  `quemgrava` varchar(30) NOT NULL,
  `modo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `arranchado`
--

INSERT INTO `arranchado` (`id`, `data`, `iduser`, `idpgrad`, `idsu`, `nomeguerra`, `cafe`, `almoco`, `jantar`, `datagrava`, `horagrava`, `quemgrava`, `modo`) VALUES
(1, '15/03/2021', 1, 12, 0, 'Adm', 'SIM', 'SIM', 'SIM', '11/03/2021', '11:31:21', '3º SGT Adm', 'Atualizado'),
(2, '16/03/2021', 1, 12, 0, 'Adm', 'SIM', 'SIM', '', '11/03/2021', '10:46:01', '3º SGT Adm', 'Criado'),
(3, '17/03/2021', 1, 12, 0, 'Adm', '', 'SIM', '', '11/03/2021', '11:44:42', '3º SGT Adm', 'Atualizado'),
(4, '18/03/2021', 1, 12, 0, 'Adm', 'SIM', 'SIM', '', '11/03/2021', '10:46:01', '3º SGT Adm', 'Criado'),
(5, '19/03/2021', 1, 12, 0, 'Adm', 'SIM', 'SIM', '', '11/03/2021', '10:46:01', '3º SGT Adm', 'Criado'),
(6, '20/03/2021', 1, 12, 0, 'Adm', 'SIM', '', '', '11/03/2021', '10:46:02', '3º SGT Adm', 'Criado'),
(7, '21/03/2021', 1, 12, 0, 'Adm', 'SIM', '', '', '11/03/2021', '10:46:02', '3º SGT Adm', 'Criado'),
(8, '22/03/2021', 1, 12, 0, 'Adm', 'SIM', 'SIM', '', '11/03/2021', '10:46:02', '3º SGT Adm', 'Criado'),
(9, '23/03/2021', 1, 12, 0, 'Adm', 'SIM', 'SIM', '', '11/03/2021', '10:46:02', '3º SGT Adm', 'Criado'),
(10, '24/03/2021', 1, 12, 0, 'Adm', 'SIM', 'SIM', '', '11/03/2021', '10:46:02', '3º SGT Adm', 'Criado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cardapio`
--

CREATE TABLE `cardapio` (
  `id` int NOT NULL,
  `data` varchar(10) NOT NULL,
  `cafe` mediumtext NOT NULL,
  `almoco` mediumtext NOT NULL,
  `jantar` mediumtext NOT NULL,
  `responsavel` varchar(50) NOT NULL,
  `datacadastro` varchar(10) NOT NULL,
  `horacadastro` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cardapio`
--

INSERT INTO `cardapio` (`id`, `data`, `cafe`, `almoco`, `jantar`, `responsavel`, `datacadastro`, `horacadastro`) VALUES
(1, '17/03/2021', 'Café, Pão com queijo e Bolo.', 'Feijão com arroz', 'Arroz doce.', '3º SGT Adm', '11/03/2021', '11:39:57');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `arranchado`
--
ALTER TABLE `arranchado`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cardapio`
--
ALTER TABLE `cardapio`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `arranchado`
--
ALTER TABLE `arranchado`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `cardapio`
--
ALTER TABLE `cardapio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
