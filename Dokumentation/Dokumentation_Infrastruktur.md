# Dokumentation Infrastruktur
## Visualisierung

### Ziel: Darstellung der Infrastruktur

### Infrastuktur mit RaspBerry Pi

Um die Daten auch im realen Umfeld exportieren zu können, benötigen wir ein Gerät, dass in der Umgebung direkt per LAN mit der Fritzbox verbunden ist. Dafür wird ein RaspBerry Pi genutzt. Dieser soll die Daten der FritzBox auslesen und auf eine externe Datenbank schreiben.

![Demoinfrastruktur mit RaspBerry Pi](Dokumentation/Bilder/netzwerk_rasp%20(1).png)


## Evaluierung geeignete Datenerfassung

#### Ziel: Eine ausgewählte Methodik zum weiteren Vorgehen

#### Möglichkeiten Daten auszulesen

1. **Möglichkeit CSV-Export:** Hierbei werden die Daten direkt vom FritzBox Dashboard als CSV-Datei exportiert. Allerdings funktioniert dies nur für die Wattstunden. Dieser Export ist also für die aktuellen Verbrauchszahlen und abgeleitete Analysen nicht hilfreich.
2. **Möglichkeit Modifizierte FritzBox Firmware:** Hierfür wird auf die Fritzbox eine modizierte Firmware aufgespielt, die die Daten automatisch an einen Server verschickt. Diese Methode ist allerdings kaum erprobt. Durch Updates der Firmware oder einen Absturz der FritzBox können Fehler auftreten.
3. **Möglichkeit AVM AHA-Interface:** AVM stellt mit dem AHA-HTTP-Interface eine Schnittstelle bereit, mit der mithilfe einer Scriptsprache per URL Daten der Fritzbox abgespeichert werden. Diese Schnittstelle ist vorallem für Smart Home Integrationen gedacht, es lassen sich aber auch alle für das Projekt notwendige Daten auslesen.

#### Auswahl einer Variante

Für dieses Projekt eignet sich die AHA-Schnittstelle am meisten. Das Interface ist resistent gegen Firmwareupdates, ermöglicht automatisches auslesen der Daten und stellt die Daten in einer flexiblen Form dar. Dadurch ist es uns möglich unterschiedliche Cloud-Lösungen in Betracht zu ziehen.

## Verbindung FritzBox und FritzDect

### Ziel: Funktionierende Infrastruktur & Datenverbindung zwischen der Fritzbox 7490 und den Fritzdect 200 Energiesteckdosen

### Verkabelung

Im Demo-System wurde die Fritzbox per Lankabel mit dem heimischen Router verbunden. Die Steckdosen werden dann per DECT mit der Fritzbox verbunden. Dazu musste die Fritzbox allerdings erst auf die neueste Firmwareversion aktualisiert werden, da die Kopplung ansonsten nicht funktioniert.

### Konfiguration Fritzbox

Damit die Fritzbox Zugriff auf das Internet hat, muss diese als Repeater konfiguriert werden. In diesem Modus fungiert die Fritzbox nichtmehr als DSL-Router sondern als einfacher WLAN-Router.

Um die FritzBox als Repeater einzurichten, navigiert man über **"Internet"** zu **"Internetanbieter"** und wählt dort als Anbieter **"Vorhandener Zugang über LAN"**. Diese Funktion schleift das Internet über den Internetrouter einfach an die FritzBox weiter.

## Verbindung zu externem Server

### Ziel: Fertig konfigurierter externer Server, der die Möglichkeit bietet, die Daten der FritzBox persistent und sicher zu speichern.

### Erstellen der MySQL Datenbank

Im Debian-System war bereits ein MySQL Server installiert. Mit dem Befehl

```text
mysql -u root -p
```

erhält man Zugriff auf die Datenbank. Hierbei wird ein Passwort abgefragt. Im nächsten Schritt wird ein neuer SQL-User erstellt.

```text
CREATE USER 'username'@'localhost' IDENTIFIED BY 'userpw';
```

Sobald dieser User erstellt wurde, wird die nötige Datenbank angelegt.

```text
CREATE DATABASE elmo;
```

Der erstellte User benötigt dann noch entsprechende Rechte auf die Datenbank. Er erhält also Rechte auf alle Tabellen \(\*\) der Datenbank \(elmo\). Damit der User auch von außerhalb Zugriff auf die Datenbank hat, wird er mit dem Hostname "%" \(Alle Hosts\) identifiziert.

```text
GRANT ALL PRIVILEGES ON elmo.* TO 'elmo'@'%' IDENTIFIED BY 'userpw';
```

Im letzten Schritt werden die geänderten Berechtigungen angewendet.

```text
FLUSH PRIVILEGES;
```

### Erstellen der SQL-Tabelle

Auf der erstellten Datenbank musste eine Tabelle angelegt werden, in der die Messdaten gespeichert werden. Der AVM AHA-Dokumentation war dabei zu entnehmen, welche Werte ausgelesen werden können. Für dieses Projekt sind natürlich die Watt, Wattstunden und die Temperatur besonders wichtig.

Um die Messwerte eindeutig zuordnen zu können wurde ein Messdatum eingefügt. Dieses wird per default mit dem derzeitigen Datum befüllt.

```text
CREATE TABLE Data (
    Messdatum TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    AIN varchar(255),
    Name varchar(255),
    Status int,
    Temperatur int,
    Watt int,
    Wattstunden int,
    Volt int,
    PRIMARY KEY (Messdatum, AIN)
);
```

### Konfiguration SQL Server

Der SQL-Server ist standardmäßig so konfiguriert, dass kein Zugriff von außerhalb möglich ist. Um dies zu erlauben muss eine Konfigurationsdatei bearbeitet werden. Mit dem Befehl

```text
vim /etc/mysql/my.cnf
```

gelangt man in die Konfigurationsdatei. In dieser Datei muss die "Bindingadress" von "localhost" auf "0.0.0.0" abgeändert werden. Damit hört der Server nichtmehr nur auf Befehle vom localhost, sondern auf alle IP-Adressen die ihm zur Verfügung stehen.

```text
/etc/init.d/mysql restart
```

### Konfiguration Firewall

Die Firewall des Servers ist nach der "Whitelist-Strategie" konfiguriert. Das bedeutet, dass grundstätzlich jeder Datenverkehr blockiert wird und nur benötigter Datenverkehr erlaubt wird. Deshalb muss mit

```text
ufw allow 3306
```

der MySQL-Port in der Firewall freigegeben werden.

### Letsencrypt
```text
sudo apt-get install -y software-properties-common

sudo add-apt-repository ppa:certbot/certbot

sudo apt install python-certbot-apache

sudo apache2ctl configtest

sudo systemctl reload apache2

sudo certbot --apache -d example.com -d www.example.com
```

## Export der FritzDect Daten in externe MySQL Datenbank

### Ziel: Funktionierender Script der die Daten der FritzBox ausliest und in die externe Datenbank schreibt.

### Erstellung Script

Grundsätzlich kann für das Auslesen und den Export jede Scriptsprache genutzt werden. Da wir aber im Studium bereits Kontakt zu der Scriptsprache PHP hatten, haben wir diese verwendet.

Die Verwendung des [AHA-Interfaces](https://avm.de/fileadmin/user_upload/Global/Service/Schnittstellen/AHA-HTTP-Interface.pdf) wurde von AVM ausführlich dokumentiert. Außerdem zeigen viele Projekte [Beispiele](https://www.heise.de/ct/ausgabe/2016-7-Schalten-mit-Fritzbox-Co-3134490.html) zur Nutzung der Schnittstelle.

#### getSID.php

Für die erfolgreiche Kommunikation mit der FritzBox und dem Client wird eine SessionID benötigt. In der getSID.php werden die Logins festgelegt und dann eine Verbindung zum AHA-Interface aufgebaut.

#### getValues.php

Durch den erfolgreichen Login in der getSID.php können nun die Werte ausgelesen werden. 

**SQL**

Zuerst wird eine Verbindung zum SQL Server hergestellt. 

```text
$mysqli = new mysqli("IP-Server", "UsernameSQL", "PasswordSQL", "Database", "SQL-Port");
if ($mysqli->connect_errno) {
    die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
}
```

Um die Daten in die Datenbank zu schreiben, wird der Befehl auf dem externen Datenbankserver ausgeführt.

```text
  if ($stmt1 = $mysqli->prepare("insert into Data(AIN, Name, Status, Temperatur, Watt, Wattstunden, Volt) values ('".$ain."', '".$name."', '".$status."', '".$temperatur."', '".$power."', '".$energy."', '".$voltage."')")) {
      $stmt1->execute();
  }
```

**XML**

Um die Daten der FritzBox zu erhalten, muss über die FritzBox URL ein Befehl aufgerufen werden.

```text
$xmlstring=chop(@file_get_contents($query_url."&switchcmd=getdevicelistinfos"));
```

Um diesen XML-String in PHP verwenden zu können, muss dieser in ein Objekt umgewandelt werden.

```text
$xml = @simplexml_load_string($xmlstring);
```

Anschließend können die Daten aus dem XML-String jeweils einer PHP-Variable zugewiesen werden.

```text
  $ain=(string)$attributes['identifier']; //Lese Geräte AIN
  $name=(string)$device->name; //Lese Gerätename

  $power=(integer)$device->powermeter->power; //Lese aktuelle Wattzahl
  $energy=(integer)$device->powermeter->energy; //Lese kommulierte Wattstunden
  $voltage=(integer)$device->powermeter->voltage;; //Lese aktuelle Voltzahl

  $temperatur=(integer)$device->temperature->celsius; //Lese Temperatur
  $offset=(integer)$device->temperature->offset; //Lese Temperatur Offset
  $temperatur=$temperatur+$offset; //Berechne Temperatur

  $status=(string)$device->switch->state; //Lese Status der Steckdose
```

## Installation und Konfiguration RaspBerry Pi

### Ziel: Fertig konfigurierter RaspBerry Pi mit Datenverbindung zum externen Server

### Installation von Rasbian

Die Installation von Rasbian gestaltet sich dank des bereits auf der SD-Karte installierten Installationsassistenten "Noobs" als sehr einfach. Beim ersten Start muss nur das gewünschte Betriebssystem ausgewählt werden und die Installation beginnt von allein. Wir haben hierbei Rasbian gewählt, da dieses Betriebssystem sich auf dem RaspBerry Pi erprobt hat und nicht mit unerwarteten Komplikationen zu rechnen ist. Rasbian basiert auf Debian und bietet eine Robuste Umgebung.

### Konfiguration von Rasbian

#### Grundeinstellungen Rasbian

* Kryptisches Rasbian-Passwort setzen \(Bild\)
* Hostname ändern \(Elmo Pi \#1, Elmo Pi \#2, Elmo Pi \#X, ...\)

```text
sudo raspi-config
```

* Boot-Options -&gt; Desktop/CLI - &gt; Dektop GUI

#### Rasbian Update/Upgrade

```text
sudo apt-get update
sudu apt-get upgrade
```

#### **Installation EXFAT \(Nutzung USB-Stick\)**

```text
sudo apt-get install exfat-fuse
```

\*\*\*\*

**PHP 7/MySQL**

```text
sudo apt-get install php7.0
```

```text
sudo apt-get install php7.0-mysqli
sudo apt-get install php7.0-xml
```

```text
sudo apt-get update 
sudo apt-get upgrade
```

**Firewall**

```text
sudo apt-get install ufw
sudo ufw status verbose (Status: Inative)
sudo ufw enable
```

```text
sudo ufw allow 3306
sudo ufw allow 443
sudo ufw allow 80
sudo ufw allow 22
```

#### Cronjob

```text
sudo -s
```

```text
cd /etc
mkdir fritzbox
```

```text
cp /home/pi/Desktop/ELMO/getValues.php /etc/fritzbox/getValues.php
cp /home/pi/Desktop/ELMO/getSID.php /etc/fritzbox/getSID.php
```

```text
sudo crontab -e
```

Editorauswahl: 2 \(Nano Editor\)

```text
*/1 * * * * php -f /etc/fritzbox/getValues.php
```

#### SSH

```text
sudo raspi-config
```

Rasberry Pi Software Configuration Tool

5 Interfacing Options

SSH Enable

<!--stackedit_data:
eyJoaXN0b3J5IjpbMjExODU5NTkyMyw2ODU2MTQ2NjksLTE2MD
g2MTE2OTUsMjA1Nzc5MjYxM119
-->