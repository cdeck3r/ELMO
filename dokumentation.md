# Dokumentation

## Demo-System

### Demo-Infrastruktur

#### Ziel: Funktionierende Infrastruktur mit der Fritzbox 7490 und den Fritzdect 200 Energiesteckdosen sowie einem externen Server

#### 1 Schritt: Anschließen der Fritzbox 7490 und den Fritzdect 200 Steckdosen

#### Verkabelung

Im Demo-System wurde die Fritzbox per Lankabel mit dem heimischen Router verbunden. Die Steckdosen werden dann per DECT mit der Fritzbox verbunden. Dazu musste die Fritzbox allerdings erst auf die neueste Firmwareversion aktualisiert werden, da die Kopplung ansonsten nicht funktioniert.

#### Konfiguration Fritzbox

Damit die Fritzbox Zugriff auf das Internet hat, muss diese als Repeater konfiguriert werden. In diesem Modus fungiert die Fritzbox nichtmehr als DSL-Router sondern als einfacher WLAN-Router.

> //Anleitung Repeater Konfig

#### 2 Schritt: Konfiguration des externen Hetzner Servers

#### Erstellen der MySQL Datenbank

```text
mysql -u root -p
```

```text
CREATE USER 'username'@'localhost' IDENTIFIED BY 'userpw';
```

```text
CREATE DATABASE elmo;
```

```text
GRANT ALL PRIVILEGES ON elmo.* TO 'elmo'@'%' IDENTIFIED BY 'userpw'; 
```

```text
FLUSH PRIVILEGES;
```

#### Erstellen der Tabelle

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

```text
vim /etc/mysql/my.cnf
```

```text
/etc/init.d/mysql restart
```

#### Konfiguration Firewall

```text
ufw allow 3306
```

#### 3 Schritt: Auslesen und Export der Messdaten

```text

```

```text

```

```text

```

