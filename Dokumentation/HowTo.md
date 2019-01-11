# HowTo 1: Defekten FritzDect 200 Stecker austauschen
## Schritt 1
Zuerst muss der alte Stecker entfernt werden und der neue Stecker in die Steckdose gesteckt werden.
## Schritt 2
Anschließend muss man relativ Schnell an der entsprechenden FritzBox die DECT-Taste drücken. Der Stecker sollte sich dann mit der FritzBox verbinden. Die Lichter blinken dann dauerhaft.
### Troubleshooting
#### Nur ein Licht blinkt
Es muss der "On-Schalter" auf dem Stecker betätigt werden.
#### Beide lichter blinken schnell
Das ist normal, einfach abwarten. Der Stecker installiert ein Update.
#### Lichter blinken unregelmäßig
Erneut ein und ausstecken und die DECT-Taste an der FritzBox betätigen, die Koppelung hat nicht funktioniert.

Sollten weitere Probleme auftreten, beachten Sie diesen Artikel von AVM:
[AVM-Wissensdatenbank: FritzDect Koppeln](https://avm.de/service/fritzbox/fritzbox-7272/wissensdatenbank/publication/show/1231_FRITZ-DECT-Steckdose-an-FRITZ-Box-anmelden/)
## Schritt 3
Im Interface der FritzBox muss der Name des Steckers auf die ID seiner Maschine abgeändert werden. Die IDs können hier eingesehen werden:
[elmo.cloud](https://elmo.cloud/main/maschinen.php)

Das Passwort für die FritzBox ist im KeePass Tresor abgespeichert. Sollte die ID nicht auftauchen, wurde die falsche FritzBox gewählt.

# HowTo 2: Neuen FritzDect 200 Stecker hinzufügen
## Schritt 1
Es muss überprüft werden, ob eine FritzBox in Reichweite ist, welche noch Kapazität für einen neuen Stecker hat. Jede FritzBox kann 10 Stecker zuverlässig verwalten.
Ist dies nicht gegeben, muss eine neue FritzBox eingebaut werden.

> Siehe **HowTo 5**

## Schritt 2

> **HowTo 1** durchführen.

# HowTo 3: Defekte FritzBox austauschen
## Schritt 1
Die alte Fritzbox muss entfernt werden. Dazu einfach die 2 Netzwerkkabel abziehen und das Stromkabel abziehen.
## Schritt 2
Es muss überprüft werden, welche FritzDect-Stecker die FritzBox verwaltet hat. Ist dies nicht bekannt, ist die einfachte Lösung ein SQL-Befehl auf das [Phpmyadmin-Interface](https://elmo.cloud/phpmyadmin/) (Passwort in KeePass).

    SELECT Name
    FROM Data
    WHERE Name NOT IN (SELECT Name FROM DATA WHERE Messdatum > DATE_SUB(NOW(), INTERVAL 30 MINUTE)

Dieser Befehl liest alle Stecker aus, die in den letzten 30 Minuten nichts in die Datenbank geschrieben habe.

## Schritt 3
Die neue Fritzbox konfigurieren.

> Siehe Dokumentation_Infrastruktur, Passwort aus KeePass verwenden

Anschließend müssen alle Stecker neu mit der FritzBox verbunden werden. 

> Siehe HowTo 1

Danach müssen die gespeicherten Stecker im FritzBox Interface mit dem Ergebnis des SQL-Befehls verglichen werden.

# HowTo 4: Defekten RaspBerry Pi austauschen
## Schritt 1
Zuerst muss der defekte RaspBerry entfernt werden. Dazu einfach das Netzwerkkabel und das Stromkabel entfernen
## Schritt 2
Der neue RaspBerry muss eingerichtet werden. Dies funktioniert nicht allein mit dem Einrichtungsskript. Viele Aktionen müssen manull durchgeführt werden.

> Siehe Dokumentation_Infrastruktur
> Wichtigste: 
> - UFW einrichten, 
> - PHP installieren
> - Scripte ablegen (von funktionierendem RaspBerry kopieren oder aus dem Github laden und die Passwörter anpassen)
> - Cronjob einrichten 

### Troubleshooting
Bei der Konfiguration des RaspBerrys können viele Fehler auftreten.
#### WLAN-Verbindung
#### PHP-Funktionen nicht vorhanden
#### Cronjob

# HowTo 5: System erweitern / Skalierbarkeit
## Schritt 1
Zuerst muss abgeklärt werden, wie viele neue Stecker installiert werden sollen.
Danach müssen die 2 Möglichkeiten überprüft werden:
1. Die vorhandenen FritzBoxen haben noch Ressourcen 
	--> Siehe HowTo 1
2. Es sind keine oder nicht genügend Resourcen ve

<!--stackedit_data:
eyJoaXN0b3J5IjpbLTQ2NzQ4NDg4MCwtMzMxNDc0ODIzXX0=
-->