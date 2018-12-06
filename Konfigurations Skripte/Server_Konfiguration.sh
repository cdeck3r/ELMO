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

#Letsencrypt
sudo apt-get install -y software-properties-common
sudo add-apt-repository ppa:certbot/certbot
sudo apt install python-certbot-apache
sudo apache2ctl configtest
sudo systemctl reload apache2
sudo certbot --apache -d example.com -d www.example.com
