#!/bin/bash
#Kryptisches Rasbian-Passwort setzen \(Bild\)
#Hostname ändern \(Elmo Pi \#1, Elmo Pi \#2, Elmo Pi \#X, ...\)

sudo raspi-config
#Boot-Options -&gt; Desktop/CLI - &gt; Dektop GUI

#Rasbian Update/Upgrade

sudo apt-get update
sudu apt-get upgrade


#Installation EXFAT \(Nutzung USB-Stick\)

sudo apt-get install exfat-fuse

#PHP 7/MySQL

sudo apt-get install php7.0

sudo apt-get install php7.0-mysqli
sudo apt-get install php7.0-xml

sudo apt-get update 
sudo apt-get upgrade

#Firewall
sudo apt-get install ufw
sudo ufw status verbose (Status: Inative)
sudo ufw enable

#Cronjob
sudo -s

cd /etc
mkdir fritzbox

cp /home/pi/Desktop/ELMO/getValues.php /etc/fritzbox/getValues.php
cp /home/pi/Desktop/ELMO/getSID.php /etc/fritzbox/getSID.php

sudo crontab -e

#Editorauswahl: 2 \(Nano Editor\)

#*/1 * * * * php -f /etc/fritzbox/getValues.php

#SSH
sudo raspi-config
#Rasberry Pi Software Configuration Tool
#5 Interfacing Options
#SSH Enable
