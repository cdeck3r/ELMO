#!/bin/bash
# In der MySQL Konfiguration muss die Binding-Adresse auf 0.0.0.0 abgeändert werden
sudo apt install ufw
sudo ufw allow 3306
mysql -u root -p
CREATE DATABASE Elmo;
USE Elmo;
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
GRANT ALL PRIVILEGES ON Elmo.* TO 'userid'@'%' IDENTIFIED BY 'userpw';
FLUSH PRIVILEGES;
exit;
sudo /etc/init.d/mysql restart