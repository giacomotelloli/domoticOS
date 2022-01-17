-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 07, 2020 alle 15:58
-- Versione del server: 10.1.36-MariaDB
-- Versione PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `domotic_os`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `luoghi`
--

CREATE TABLE `luoghi` (
  `id` int(11) NOT NULL,
  `nome_luogo` varchar(30) DEFAULT NULL,
  `id_piano` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `luoghi`
--

INSERT INTO `luoghi` (`id`, `nome_luogo`, `id_piano`) VALUES
(1, 'giardino', 1),
(2, 'cucina', 1),
(3, 'cameretta', 2),
(4, 'garage', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `oggetti`
--

CREATE TABLE `oggetti` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `id_luogo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `oggetti`
--

INSERT INTO `oggetti` (`id`, `nome`, `id_luogo`) VALUES
(2, 'serra', 1),
(3, 'macchina', 4),
(17, 'frigorifero', 2),
(18, 'macchinetta_caffe', 2),
(26, 'computer', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `piani`
--

CREATE TABLE `piani` (
  `id` int(11) NOT NULL,
  `nome_piano` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `piani`
--

INSERT INTO `piani` (`id`, `nome_piano`) VALUES
(1, 'piano_terra'),
(2, 'primo_piano');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti_casa`
--

CREATE TABLE `utenti_casa` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `livello_permesso` int(11) NOT NULL,
  `logged` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti_casa`
--

INSERT INTO `utenti_casa` (`id`, `nome`, `cognome`, `email`, `password`, `livello_permesso`, `logged`) VALUES
(1, 'Giacomo', 'Telloli', 'tell.giacomo@gmail.com', 'giacomo', 4, 1),
(2, 'lucia', 'pelle', 'lucia.pelle@gmail.com', 'lucia', 3, 0),
(3, 'Gigi', 'Latrottola', 'gigi@gmail.com', 'gigi', 1, 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `luoghi`
--
ALTER TABLE `luoghi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_luogo` (`nome_luogo`);

--
-- Indici per le tabelle `oggetti`
--
ALTER TABLE `oggetti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `piani`
--
ALTER TABLE `piani`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_piano` (`nome_piano`);

--
-- Indici per le tabelle `utenti_casa`
--
ALTER TABLE `utenti_casa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `luoghi`
--
ALTER TABLE `luoghi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `oggetti`
--
ALTER TABLE `oggetti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `piani`
--
ALTER TABLE `piani`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `utenti_casa`
--
ALTER TABLE `utenti_casa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
