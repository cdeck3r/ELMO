<?php
//Anmeldedaten und SessionID Funktion einbinden
include_once('SIDauslesen.php');

//Verbindung zu externem Hetzner-Server
$mysqli = new mysqli("88.99.80.161", "elmouser", "elmoprojektws18", "elmo", "3306");
if ($mysqli->connect_errno) {
    die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
}

//Login in Fritzbox und SID ermitteln
$sid=get_sid($loginurl,$username,$password);
if (!$sid ) {
  die ("Anmeldefehler, keine Session-ID erhalten!\n");
}
//SmarthomeURL mit SID Parameter ergänzen
$query_url=$ahaurl.'?sid='.$sid;
//Abfrage aller eingetragenen Geräte mit getdevicelistinfo Kommando
$xmlstring=chop(@file_get_contents($query_url."&switchcmd=getdevicelistinfos"));
$xml = @simplexml_load_string($xmlstring);
//Antwort prüfen, ob ein xml-Object mit einem Device-Tag existiert
if (!$xml || !$xml->device ) {
  die ("Error: Unerwartete Antwort oder Komunikationsfehler bei cmd=getdevicelistinfos");
}
//Schleife über alle gelisteten Geräte
foreach ($xml->device as $device) {
  $attributes=$device->attributes();
  $ain=(string)$attributes['identifier']; //Lese Geräte AIN
  $name=(string)$device->name; //Lese Gerätename

  $power=(integer)$device->powermeter->power; //Lese aktuelle Wattzahl
  $energy=(integer)$device->powermeter->energy; //Lese kommulierte Wattstunden
  $voltage=(integer)$device->powermeter->voltage;; //Lese aktuelle Voltzahl

  $temperatur=(integer)$device->temperature->celsius; //Lese Temperatur
  $offset=(integer)$device->temperature->offset; //Lese Temperatur Offset
  $temperatur=$temperatur+$offset; //Berechne Temperatur

  $status=(string)$device->switch->state; //Lese Status der Steckdose
  $status=($status=="1");
  
  //Schreibe die Daten in die externe Datenbank
  if ($stmt1 = $mysqli->prepare("insert into Data(AIN, Name, Status, Temperatur, Watt, Wattstunden, Volt) values ('".$ain."', '".$name."', '".$status."', '".$temperatur."', '".$power."', '".$energy."', '".$voltage."')")) {
      $stmt1->execute();
  }
}
?>
