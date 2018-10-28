-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 21. Okt 2018 um 21:07
-- Server Version: 5.5.60-0+deb8u1
-- PHP-Version: 7.1.22-1+0~20181001133629.6+jessie~1.gbp113f3b

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `elmo`
--
CREATE DATABASE IF NOT EXISTS `elmo` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `elmo`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Data`
--

CREATE TABLE IF NOT EXISTS `Data` (
  `Messdatum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AIN` varchar(255) NOT NULL DEFAULT '0',
  `Name` varchar(255) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `Temperatur` int(11) DEFAULT NULL,
  `Watt` int(11) DEFAULT NULL,
  `Wattstunden` int(11) DEFAULT NULL,
  `Volt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `Data`
--
ALTER TABLE `Data`
 ADD PRIMARY KEY (`Messdatum`,`AIN`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
