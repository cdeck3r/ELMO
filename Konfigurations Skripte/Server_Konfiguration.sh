#!/bin/bash
# In der MySQL Konfiguration muss die Binding-Adresse auf 0.0.0.0 abgeändert werden
# Ein LAMP-Stack war auf diesem Server schon installiert, der Script enthält daher keine Installation für PHP, Apache

#Firewall
sudo apt install ufw
sudo ufw allow 3306

#MySQL-Konfig
mysql -u root -p
CREATE DATABASE Elmo;
USE Elmo;
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
  `divID` int(3) NOT NULL,
  `raum` varchar(80) NOT NULL,
  `maschinentyp` varchar(80) NOT NULL,
  `LastClean` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Raum`
--

CREATE TABLE `Raum` (
  `Name` varchar(255) NOT NULL,
  `ID` int(255) NOT NULL
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
-- Indizes für die Tabelle `Raum`
--
ALTER TABLE `Raum`
  ADD PRIMARY KEY (`ID`);

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
GRANT ALL PRIVILEGES ON Elmo.* TO 'userid'@'%' IDENTIFIED BY 'userpw';
FLUSH PRIVILEGES;
exit;
sudo /etc/init.d/mysql restart

#Letsencrypt
sudo apt-get install -y software-properties-common
sudo add-apt-repository ppa:certbot/certbot
sudo apt install python-certbot-apache
sudo apache2ctl configtest
sudo systemctl reload apache2
sudo certbot --apache -d example.com -d www.example.com
