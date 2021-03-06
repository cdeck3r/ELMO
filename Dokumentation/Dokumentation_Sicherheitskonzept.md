![Titelbild ELMO Sicherheitskonzept](Bilder/ELMO_Sicherheitskonzept_Docu.png)

# Sicherheitskonzept

## Allgemein

### Passwortvergabe

Alle Passwörter wurden mit einem kryptisch Generiert und in einem Passwordsafe \(KeePass\) abgespeichert.

## FritzBox 7490

### WLAN

Das WLAN der FritzBoxen wurde für die produktive Umgebung deaktiviert. Dies verhindert Störungen im bestehenden WLAN Netz und löst eine Sicherheitslücke. Die Verbindung zwischen RaspBerry Pi und FritzBox erfolgt über LAN.

## RaspBerry Pi

### Firewall

Als Firewall wird auf dem RaspBerry Pi \(Rasbian\) UFW genutzt. Da die RaspBerrys nur Daten versenden, enthält die Firewall lediglich eine Freigabe für den gewählten SSH-Port.


## Verbindung RaspBerry Pi zur FritzBox

### Login

Der Login auf die FritzBox und das AHA-Interface funktioniert nur mit im Script hinterlegten Logins. 

### Verschlüsselung

Da der Datentransfer über ein LAN-Kabel stattfindet und das WLAN deaktiviert ist, wird eine Verschlüsselung nicht benötigt.

## Externer vServer

### Firewall

Als Firewall wird auf dem vServer \(Ubuntu\) UFW genutzt. Diese enthält Freigaben für Apache \(443, 80\), SSH und MySQL.

### Dienste
#### Letsencrypt
Auf die Domain soll nur ein HTTPS-Zugriff erlaubt sein. Daher wurde die Seite per Letsencrypt verschlüsselt.



<!--stackedit_data:
eyJoaXN0b3J5IjpbLTEwNTkxODY1NzEsLTYzMTU4NjQ5OSwtMT
E1MDQ0MTUxMywxMDIzODI4MDY3XX0=
-->