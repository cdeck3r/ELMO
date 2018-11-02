<?php
//Anmelde- und Hostdaten
$username="username"; //Username FritzBox
$password="password"; //Passwort Fritzbox
$loginurl="http://fritz.box/login_sid.lua"; //Hostname zum AHA-Interface
$ahaurl="http://fritz.box/webservices/homeautoswitch.lua"; //Hostname zum AHA-Interface

//Login-Funktion
function get_sid ($loginurl,$username,$password) {
  //Sende initialen Request an Fritzbox
  $http_response = @file_get_contents($loginurl);
  //Parse Antwort XML
  $xml = @simplexml_load_string($http_response);
  //Antwort prüfen, ob ein xml-Object mit einem Challenge-Tag existiert
  if (!$xml || !$xml->Challenge ) {
    die ("Error: Unerwartete Antwort oder Kommunikationsfehler!\n");
  }
  //extrahiere Challange und SID Tags aus XML
  $challenge=(string)$xml->Challenge;
  $sid=(string)$xml->SID;
  if (preg_match("/^[0]+$/",$sid) && $challenge ) {
    $sid="";
    //erstelle Klartext Password String
    $pass=$challenge."-".$password;
    //UTF-16LE encoding des Passwords ist erforderlich
    $pass=mb_convert_encoding($pass, "UTF-16LE");
    //abschliessend ein md5hash über alles
    $md5 = md5($pass);
    //Erstelle Response String
    $challenge_response = $challenge."-".$md5;
    //Sende Response zur Fritzbox
    $url=$loginurl."?username=".$username."&response=".$challenge_response;
    $http_response = file_get_contents($url);
    //parse Antwort XML
    $xml = simplexml_load_string($http_response);
    $sid=(string)$xml->SID;
    if ((strlen($sid)>0) && !preg_match("/^[0]+$/",$sid)) {
      //is not null, bingo!
      return $sid;
    }
  }else {
    //nutze existierende SID wenn $sid ein hex string ist
    if ((strlen($sid)>0) && (preg_match("/^[0-9a-f]+$/",$sid))) return $sid;
  }
return null;
}
?>
