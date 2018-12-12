-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 12. Dez 2018 um 21:22
-- Server-Version: 5.7.24-0ubuntu0.18.04.1
-- PHP-Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `Elmo`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Data`
--

CREATE TABLE `Data` (
  `Messdatum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AIN` varchar(255) NOT NULL DEFAULT '0',
  `Name` varchar(255) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `Temperatur` int(11) DEFAULT NULL,
  `Watt` int(11) DEFAULT NULL,
  `Wattstunden` int(11) DEFAULT NULL,
  `Volt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Maschinen`
--

CREATE TABLE `Maschinen` (
  `Maschinenname` varchar(100) NOT NULL,
  `divID` varchar(3) NOT NULL,
  `raum` varchar(80) NOT NULL,
  `maschinentyp` varchar(80) NOT NULL,
  `LastClean` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Reinigungen`
--

CREATE TABLE `Reinigungen` (
  `MaschinenID` int(255) NOT NULL,
  `ReinigungDatum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AnzahlBetriebsstunden` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `User`
--

CREATE TABLE `User` (
  `id` int(10) UNSIGNED NOT NULL,
  `passwort` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `Maschinen`
--
ALTER TABLE `Maschinen`
  ADD PRIMARY KEY (`divID`);

--
-- Indizes für die Tabelle `Reinigungen`
--
ALTER TABLE `Reinigungen`
  ADD PRIMARY KEY (`MaschinenID`,`ReinigungDatum`);

--
-- Indizes für die Tabelle `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `User`
--
ALTER TABLE `User`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
