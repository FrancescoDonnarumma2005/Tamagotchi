-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 06:51 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tamagotchi`
--

-- --------------------------------------------------------

--
-- Table structure for table `animaletti`
--

CREATE TABLE `animaletti` (
  `idAnimaletto` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `nome` varchar(16) NOT NULL,
  `tipo` int(11) NOT NULL,
  `fame` float NOT NULL,
  `divertimento` float NOT NULL,
  `energia` float NOT NULL,
  `vita` float NOT NULL,
  `lastUpdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tipoanimaletto`
--

CREATE TABLE `tipoanimaletto` (
  `id` int(11) NOT NULL,
  `tipo` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `username` varchar(18) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animaletti`
--
ALTER TABLE `animaletti`
  ADD PRIMARY KEY (`idAnimaletto`,`idUtente`),
  ADD KEY `fk_utenti` (`idUtente`),
  ADD KEY `fk_tipoAnimaletto` (`tipo`);

--
-- Indexes for table `tipoanimaletto`
--
ALTER TABLE `tipoanimaletto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tipoanimaletto`
--
ALTER TABLE `tipoanimaletto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animaletti`
--
ALTER TABLE `animaletti`
  ADD CONSTRAINT `fk_tipoAnimaletto` FOREIGN KEY (`tipo`) REFERENCES `tipoanimaletto` (`id`),
  ADD CONSTRAINT `fk_utenti` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
