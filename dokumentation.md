# Dokumentation

## Demo-System

Ziel: Funktionierende Infrastruktur mit der Fritzbox 7490 und den Fritzdect 200 Energiesteckdosen sowie einem externen Server

### Evaluierung

> //Auswahl eines geeigneten Verfahrens

### Umsetzung

### 1 Schritt: Anschließen der Fritzbox 7490 und den Fritzdect 200 Steckdosen

#### Verkabelung

Im Demo-System wurde die Fritzbox per Lankabel mit dem heimischen Router verbunden. Die Steckdosen werden dann per DECT mit der Fritzbox verbunden. Dazu musste die Fritzbox allerdings erst auf die neueste Firmwareversion aktualisiert werden, da die Kopplung ansonsten nicht funktioniert.

#### Konfiguration Fritzbox

Damit die Fritzbox Zugriff auf das Internet hat, muss diese als Repeater konfiguriert werden. In diesem Modus fungiert die Fritzbox nichtmehr als DSL-Router sondern als einfacher WLAN-Router.

> //Anleitung Repeater Konfig

### 2 Schritt: Konfiguration des externen Hetzner Servers

#### Erstellen der MySQL Datenbank

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

#### Erstellen der Tabelle

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

#### Konfiguration SQL Server

Der SQL-Server ist standardmäßig so konfiguriert, dass kein Zugriff von außerhalb möglich ist. Um dies zu erlauben muss eine Konfigurationsdatei bearbeitet werden. Mit dem Befehl

```text
vim /etc/mysql/my.cnf
```

gelangt man in die Konfigurationsdatei. In dieser Datei muss die "Bindingadress" von "localhost" auf "0.0.0.0" abgeändert werden. Damit hört der Server nichtmehr nur auf Befehle vom localhost, sondern auf alle IP-Adressen die ihm zur Verfügung stehen.

```text
/etc/init.d/mysql restart
```

#### Konfiguration Firewall

Die Firewall des Servers ist nach der "Whitelist-Strategie" konfiguriert. Das bedeutet, dass grundstätzlich jeder Datenverkehr blockiert wird und nur benötigter Datenverkehr erlaubt wird. Deshalb muss mit 

```text
ufw allow 3306
```

der MySQL-Port in der Firewall freigegeben werden.

### 3 Schritt: Auslesen und Export der Messdaten

#### Erstellung Script

Grundsätzlich kann für das Auslesen und den Export jede Scriptsprache genutzt werden. Da wir aber im Studium bereits Kontakt zu der Scriptsprache PHP hatten, haben wir diese verwendet. 

```text
//MYSQL
```

```text
//ZUWEISUNG
```

```text
//SQL
```

### Visualisierung

![](.gitbook/assets/demo_imac.png)

![](.gitbook/assets/demo%20%282%29.png)

