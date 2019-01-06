![Titelbild ELMO FrontEnd](Bilder/ELMO_FrontEnd.png)

# Dokumentation FrontEnd
## Struktur


                   Showcase
                      ├── 
                      │   └── Main
                      │       └── Css
                      │            └── All Css files
                      │       └── Js
                      │            └── All Js files
                      │       └── scss
                      │            └── All scss files
	                  │       └── dark
                      │            └── All dark files
                      │       └── All PHP Pages
                      │
                      │   └── Assets/
                      │       └── Plugins
                      │            └── All Required plugins files
                      │       └── Images
                      │             └── All Theme Images
                      └── 

## Framework
### Logo
#### Logo-Idee
Das Logo ist eine Kombination aus *"Modernem Logodesign*" und dem Projektkürzel/Figur *"Elmo".*

#### Logo-Umsetzung
Das Logo wurde in Adobe Photoshop CS3 umgesetzt. Es besteht aus vier Ebenen.
1. Kreishintergrund des Motivs ELMO
2. Pfad gezeichnete Figur ELMO
3. Typo ELMO (Bold / Font: Bison)
4. Typo Cloud (Light / Font: Bison)

#### Logo Final 
![ELMO Logodesign](Bilder/Elmo-logo.jpg)

Light/Dark Edtion

*Credit: 
Bison
https://www.behance.net/gallery/63195715/Bison-Font-Family-(Free-download)
Schriftart und Figur Elmo wird nur für non kommerzielle Zwecke genutzt*

### CSS
### HTML
### Responsive Design
![ELMO Responsive](Bilder/Elmo_responsive.jpg)

## Benutzerbereich
## Grundriss | Raumpläne
![Map Vorschau](Bilder/Funktionenbilder/map.jpg)

#### HTML
#### PHP
#### Session
Im ersten Schritt wird überprüft, ob die Session gesetzt wurde. Ist dies nicht der Fall, wird auf die Loginseite weitergeleitet.

    <?php  
    session_start();  
    if(!isset($_SESSION['userid'])) {  
     header('Location: pages-lockscreen.php');  
    }  
    ?>  

#### Datenbankverbindung
War die Session gesetzt, werden nun die Daten per PHP aus der SQL-Datenbank gelesen und in Arrays gespeichert.
      
    <?php  
      
    require("config.php");  

> Die Datei "config.php" enthält die Logins zum MySQL Server. Damit diese nicht auf jeder Seite neu eingegeben werden müssen, wurde dieser Login in einer eigenen Datei realisiert.

Nun wird eine neue Verbindung zum MySQL Server hergestellt.

    $connect = new mysqli($Host, $User, $Pass, $DB, $Port);
 ##### Verfügbarkeit der Maschinen
Im Anschluss werden alle Maschinen ausgelesen, welche in den letzten 10 Minuten mindestens einen Messpunkt mit mehr als 5 Watt hatten. Diese werden in das Array "result_array" gespeichert.

      //Map-Funktion  
      $query1 = "SELECT DISTINCT NAME AS Name FROM Data WHERE Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)";  
      $result1 = mysqli_query($connect, $query1);  
      $result_array = Array();  
      while($array1 = mysqli_fetch_assoc($result1)) {  
      $result_array1[] = $array1["Name"];  
      }  
Um die gespeicherten Maschinen in JavaScript verarbeiten zu können, werden diese mit json_encode formatiert.

      $json_array = json_encode($result_array1);  
##### Tagesdurchschnitsstemperatur
![Temperatur Vorschau](Bilder/Funktionenbilder/temperatur.jpg)

Die Tagesdurchschnittstemperatur wird ausgelesen und in die Variable "tempD" geschrieben. 

     //Temperatur-Funktion$temp_query = "SELECT AVG(Temperatur)/10 As Temperatur, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag FROM Data GROUP BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC LIMIT 1";  
    $temp_result = mysqli_query($connect, $temp_query);  
    while($temp_row = mysqli_fetch_array($temp_result)) {  
      $tempL .= "\"".$temp_row["Jahr"]."-".$temp_row["Monat"]."-".$temp_row["Tag"]."\", ";  
      $tempD .= $temp_row["Temperatur"].", ";  
    }  
    $tempL = substr($tempL, 0, -2);  
    $tempD = substr($tempD, 0, -11);  
    ?>

#### SQL
##### Verfügbarkeit der Maschinen
Es werden per SQL alle einzelnen Maschinen ausgewählt, die im Intervall (Jetzt - 10 Minuten) bis Jetzt mindestens einen Messpunkt hatten der mehr als 5000 Milliwatt (5 Watt) an den SQL Server gesendet haben. 

    SELECT DISTINCT NAME AS Name FROM Data WHERE Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)
 
 ##### Tagesdurchschnitsstemperatur
 Die SQL-Daten werden in Tagen gruppiert. Nach dieser Gruppierung werden die Daten sortiert, und nur ein Eintrag zurück gegeben. Durch die SQL-Funktion "AVG" (Durchschnitt) enthält man so die Durchschnitsstemperatur des zuletzt aufgezeichneten Tages.
 

    AVG(Temperatur)/10 As Temperatur, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag FROM Data GROUP BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC LIMIT 1

#### JavaScript
Das in PHP erstellte Array "json_array" wird dem JavaScript Array "arrayObjects1" zugewiesen. Anschließend wird das JS-Array durchlaufen und für jeden Eintrag die Funktion "colorFunction(value)" aufgerufen.

    function parseFunction() {  
       var arrayObjects1 = <?php echo $json_array; ?>;  
      for(i = 0; i < arrayObjects1.length; ++i) {  
      
            colorFunction(arrayObjects1[i]);  
      }  
      
    }  
      
Durch den Aufruf der Funktion wird eine Verbindung zu den statisch eingetragenen DIV-IDs hergestellt. Da das aufgerufene Element einer besetzten Maschine entspricht, wird der Hintergrund und der Rahmen auf eine rote Farbkombination gesetzt. Standardmäßig sind die DIVs Grün (Verfügbar)
      
    function colorFunction(value) {  
      
        var id = "c" + value;  
      document.getElementById(id).style.backgroundColor = "#ffa6a6";  
      document.getElementById(id).style.borderColor = "#ff4d4f";  
      document.getElementById(id).getElementsByClassName("map-body")[0].innerHTML += '<h5>Belegt!</h5>';  
    }  
    </script>

## Ansprechpartner
![Ansprechpartner Vorschau](Bilder/Funktionenbilder/ansprechpartner.jpg)
### HTML
### PHP
Gleich wie in den anderen Files wird zuerst eine Datenbankverbindung aufgebaut. Anschließen wird abgefragt, ob die Lampe der Ansprechperson in den letzten 10 Minuten Aktiv war. Das Ergebnis wird in die Variable "row1" geschrieben.

    <?php  
    require("config.php");  
    $connect = new mysqli($Host, $User, $Pass, $DB, $Port);  
    $query1 = "SELECT DISTINCT NAME AS Name FROM Data WHERE NAME = '60' AND Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)";  
    $result1 = mysqli_query($connect, $query1);  
    $row1 = mysqli_fetch_array($result1);  
    ?>
Bei der Darstellung gibt es zwei Optionen. "Nicht Verfügbar" oder "Verfügbar". Entschieden wird dies mit einer IF-Abfrage auf "is_null($row1)".

    <?php  
    if (!is_null($row1)){  
    echo "<div class=\"row text-center justify-content-md-center m-t-10\"><div><h5 class=\"btn btn-success\"><span class=\"btn-label\"><i class=\"fa fa-check\"></i></span>Verfügbar</h5></div>";  
    }  
    else {  
    echo "<div class=\"btn btn-outline-secondary waves-effect waves-light m-t-10\"><span class=\"btn-label\"><i class=\"fa fa-times\"></i></span>Nicht Verfügbar</div>";  
    }  
    ?>

### Verantwortliche Personen
## Adminbereich
## Charts
### Grundfunktionen

> Die SQL Befehle werden in diesem Abschnitt nicht näher erläutert. Eine ausführliche Erklärung folgt im nächsten Abschnitt "SQL"

#### Session
Im ersten Schritt wird überprüft, ob die Session gesetzt wurde. Ist dies nicht der Fall, wird auf die Loginseite weitergeleitet.

    <?php  
    session_start();  
    if(!isset($_SESSION['userid'])) {  
     header('Location: pages-lockscreen.php');  
    }  
    ?>  

#### Datenbankverbindung
War die Session gesetzt, werden nun die Daten per PHP aus der SQL-Datenbank gelesen und in Arrays gespeichert.
      
    <?php  
      
    require("config.php");  

> Die Datei "config.php" enthält die Logins zum MySQL Server. Damit diese nicht auf jeder Seite neu eingegeben werden müssen, wurde dieser Login in einer eigenen Datei realisiert.

Nun wird eine neue Verbindung zum MySQL Server hergestellt.

    $connect = new mysqli($Host, $User, $Pass, $DB, $Port);  
### Chart-Boxes
![Boxes Vorschau](Bilder/Funktionenbilder/boxes.jpg)

#### Box1 - Summe Wattstunden
##### PHP
Im ersten Befehl wird die Summe der Wattstunden ausgelesen und in die PHP-Variable "Box1_row" geschrieben.

    //Box1  
    $Box1_query = "SELECT SUM(temp.Wattstunden) As Wattstunden FROM (SELECT MAX(Wattstunden) As Wattstunden FROM Data GROUP BY AIN) As temp";  
    $Box1_result = mysqli_query($connect, $Box1_query);  
    $Box1_row = mysqli_fetch_array($Box1_result);  
 
##### SQL
Der SQL-Befehl für die Summe der Wattstunden ist relativ einfach aufgebaut. In einer Unterabfrage wird von jeder Maschine die maximale Wattstundenzahl ausgelesen. Diese max-Werte werden dann Summiert und zurückgegeben.

    SELECT SUM(temp.Wattstunden) As Wattstunden 
	FROM (SELECT MAX(Wattstunden) As Wattstunden 
	     FROM Data GROUP BY AIN) As temp

##### Einbindung
Zur Einbindung wird die Variable an der entsprechenden Stelle im HTML-Code per echo ausgegeben.

    <span class="text-white font-weight-bold"><?php echo $Box1_row["Wattstunden"]; ?></span><span class="text-white font-weight-light"> Wattstunden</span>
---
#### Box2 - Anzahl aktive Maschinen
##### PHP
Die zweite Box soll die Anzahl der aktiven Maschinen darstellen. Dies wird in die Variable "Box2_row" geschrieben.

    //Box2  
    $Box2_query = "SELECT COUNT(DISTINCT AIN) As Anzahl FROM Data WHERE Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)";  
    $Box2_result = mysqli_query($connect, $Box2_query);  
    $Box2_row = mysqli_fetch_array($Box2_result);  
      
##### SQL
In diesem Befehl werden per Where Abfrage alle Maschinen ausgelesen, die im Interval Jetzt - 10 Minuten bis Jetzt mindestens einen Messpunkt mit mehr als 5000 Milliwatt hatten. Per Count(Distinct AIN) wird jede Maschine nur einfach gezählt.

    SELECT COUNT(DISTINCT AIN) As Anzahl FROM Data
    WHERE Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)
   
##### Einbindung
Zur Einbindung wird die Variable an der entsprechenden Stelle im HTML-Code per echo ausgegeben.

    <span class="text-white font-weight-bold"><?php echo $Box2_row["Anzahl"]; ?></span><span class="text-white font-weight-light"> von 50</span>
---
#### Box3 - Maschine mit höchstem Stromverbrauch
##### PHP
Die dritte Box enthält die Maschine, die bisher am meisten Wattstunden benötigt hat. Das Ergebnis wird in die Variable "Box3_row" geschrieben.

    //Box3  
    $Box3_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden DESC Limit 1";  
    $Box3_result = mysqli_query($connect, $Box3_query);  
    $Box3_row = mysqli_fetch_array($Box3_result);  
    
##### SQL
Die Daten der "Data" Tabelle werden nach AIN gruppiert und DESC sortiert. Dadurch erhält man durch den Zusatz "Limit 1" die Maschine, mit den meisten Wattstunden.

    SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name
    FROM Data GROUP BY AIN ORDER BY Wattstunden DESC Limit 1
##### Einbindung
Zur Einbindung wird die Variable an der entsprechenden Stelle im HTML-Code per echo ausgegeben.

    <span class="text-white font-weight-light">Maschine </span><span class="text-white font-weight-bold"><?php echo utf8_encode($Box3_row["Name"]); ?></span>
---
#### Box4 - Maschine mit niedrigstem Stromverbrauch
##### PHP
Die vierte Box enthält die Maschine, die bisher am wenigsten Wattstunden verbraucht hat. Das Ergebnis wird in die Variable "Box4_row" geschrieben.

    //Box4  
    $Box4_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden ASC Limit 1";  
    $Box4_result = mysqli_query($connect, $Box4_query);  
    $Box4_row = mysqli_fetch_array($Box4_result);  
##### SQL
Gleich wie Box3 nur mit Sortierung ASC

    SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name
    FROM Data GROUP BY AIN ORDER BY Wattstunden ASC Limit 1
##### Einbindung
Zur Einbindung wird die Variable an der entsprechenden Stelle im HTML-Code per echo ausgegeben.

    <span class="text-white font-weight-light">Maschine </span><span class="text-white font-weight-bold"><?php echo utf8_encode($Box4_row["Name"]); ?></span>

---      
#### Donuechart - Summe Wattstunden gruppiert nach Raum
 ![Donut Charts Vorschau](Bilder/Funktionenbilder/donut.jpg)
 
##### PHP
Nun folgt die Abfrage der Daten für die Charts. Das erste Chart ist dabei ein Donutechart, welches den gruppierten Stromverbrauch in Wattstunden der drei Räume enthält. Gleich wie bei den Boxen gibt es eine Query, welches per "mysql_query" in eine Result-Variable geschrieben wird.

    //DonuteChart  
    $DonuteChart_query = "  
    SELECT SUM(Wattstunden) as Wattstunden, MAX(Raum.Name) As Name  
    FROM (  
    SELECT MAX(Wattstunden) As Wattstunden, MAX(Raum) As Raum FROM Data d INNER JOIN Maschinen m ON d.Name = m.divID GROUP BY AIN  
    ) As Raume  
    INNER JOIN Raum on Raume.Raum = Raum.ID  
    GROUP BY Raum  
    Order By Wattstunden DESC  
    ";  
    $DonuteChart_result = mysqli_query($connect, $DonuteChart_query);  
  
Da die Daten aber nicht nur einen Wert enthalten und genau den Vorgaben des entsprechenden JavaScript Chartframeworks entsprechen müssen, werden diese per While-Schleife formatiert in die Variable "DonuteChart_data" geschrieben. Diese Formatierung wird mit der PHP-Funktion "substr" vollendet, in dem beim letzten Eintrag die letzte zwei Zeichen entfernt werden.

    $DonuteChart_data = '';  
    while($DonuteChart_row = mysqli_fetch_array($DonuteChart_result)) {  
      $DonuteChart_data .= "{ label: \"".utf8_encode($DonuteChart_row["Name"])."\", value: ".$DonuteChart_row["Wattstunden"]."}, ";  
    }  
    $DonuteChart_data = substr($DonuteChart_data, 0, -2);  

##### SQL
In der Unterabfrage werden die letzten Werte der Maschinen mit der Max-Funktion abgefragt. Die Hauptabfrage gruppiert die letzten Werte dann nach dem Raum und gibt die Summe zurück.

    SELECT SUM(Wattstunden) as Wattstunden, MAX(Raum.Name) As Name  
    FROM (  
    SELECT MAX(Wattstunden) As Wattstunden, MAX(Raum) As Raum
     FROM Data d INNER JOIN Maschinen m 
     ON d.Name = m.divID GROUP BY AIN  
    ) As Raume  
    INNER JOIN Raum on Raume.Raum = Raum.ID  
    GROUP BY Raum  
    Order By Wattstunden DESC
##### JavaScript
Die Grundstruktur des JavaScript-Codes kann von den Beispielen übernommen werden. Per php-echo wird der vor-formatierte String an JavaScript übergeben. Außerdem werden Optionen zum Aussehen des Charts getroffen.

    <script>  
      Morris.Donut({  
      element: 'morris-donut-chart',  
      data:[<?php echo $DonuteChart_data; ?>],  
      resize: false,  
      colors:['#7160ee', '#2f3d4a', '#fc4b6c', '#009efb', '#1e88e5'],  
      labelColor: '#dcf8ff',  
      gridLineColor: '#263238',  
      lineColors: '#263238'  
      });  
    </script>
---
#### Säulendiagramm - Summe Wattstunden nach Maschinen
![Bar Vorschau](Bilder/Funktionenbilder/bar_maschinen.jpg)
##### PHP
Das gleiche vorgehen wird nun bei allen Charts durchgeführt. Die Formatierung ändert sich aber je nach Anforderungen des JS-Frameworks.
      
    //Säulendiagramm  
    $Säulendiagramm_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden ASC";  
    $Säulendiagramm_result = mysqli_query($connect, $Säulendiagramm_query);  
    while($Säulendiagramm_row = mysqli_fetch_array($Säulendiagramm_result)) {  
      $sDataL .= "\"".utf8_encode($Säulendiagramm_row["Name"])."\", ";  
      $sDataD .= $Säulendiagramm_row["Wattstunden"].", ";  
    }  
    $sDataL = substr($sDataL, 0, -2);  
    $sDataD = substr($sDataD, 0, -2);  
##### SQL
Die SQL-Abfrage hierfür ist sehr einfach, die Messdaten werden auf die AIN gruppiert und davon die Maximalen Werte zurückgegeben.

    SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name
    FROM Data GROUP BY AIN ORDER BY Wattstunden ASC
##### JavaScript
    <script>  
    new Chart(document.getElementById("bar2"), {  
      type: 'bar',  
      data: {  
      labels: [<?php echo $sDataL;?>],  
      datasets: [  
	      {  
		      label: "Watt",  
		      backgroundColor: 'rgba(62, 149, 205, 0.5)',  
		      borderColor: 'rgba(76, 185, 255, 1)',  
		      borderWidth: 1,  
		      data: [<?php echo $sDataD;?>]  
           }  
         ]  
       },  
      options: {  
         legend: { display: false }  
      }  
    });  
    </script> 
   ---

#### Liniendiagramm - Temperaturverlauf der letzten 20 Tage
![Temperatur Chart Vorschau](Bilder/Funktionenbilder/temperatur_chart.jpg)
##### PHP
Das Liniendiagramm soll den Temperaturverlauf der letzten 20 Tage darstellen. Wie bei den anderen Diagrammen wird das Query ausgeführt und die entsprechenden Daten entsprechend der benötigten Formatierung in die Variablen "tempL" (Label) und "tempD" (Data) geschrieben.

    //Temperatur  
    $temp_query = "SELECT AVG(Temperatur)/10 As Temperatur, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag FROM Data GROUP BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC LIMIT 20";  
    $temp_result = mysqli_query($connect, $temp_query);  
    while($temp_row = mysqli_fetch_array($temp_result)) {  
      $tempL .= "\"".$temp_row["Jahr"]."-".$temp_row["Monat"]."-".$temp_row["Tag"]."\", ";  
      $tempD .= $temp_row["Temperatur"].", ";  
    }  
    $tempL = substr($tempL, 0, -2);  
    $tempD = substr($tempD, 0, -2);  
      
##### SQL
    SELECT AVG(Temperatur)/10 As Temperatur, YEAR(Messdatum) As Jahr,
    MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag
    FROM Data GROUP BY YEAR(Messdatum) DESC,
    MONTH(Messdatum) DESC, DAY(Messdatum) DESC LIMIT 20
##### JavaScript

     <script>  
          new Chart(document.getElementById("temperatur"), {  
          type: 'line',  
          data: {  
    	      labels: [<?php echo $tempL;?>],  
    	      datasets: [  
                {  
    	            label: "Temperatur",  
    			    backgroundColor: 'rgba(252, 75, 108, 0.4)',  
    		        borderColor: 'rgba(255, 113, 139, 1)',  
    		        borderWidth: 1,  
    		        data: [<?php echo $tempD;?>]  
          
                 }  
              ]  
            },  
          options: {  
             legend: { display: false }  
           }  
        });  
        </script>

---
#### Liniendiagramm (Area) - Stromverbrauch der letzten 12 Monate  
##### PHP
Das Diagramm soll den Stromverbrauch der letzten 12 Monate darstellen.

    //AreaChart  
    $AreaChart_query = "  
    SELECT temp.Jahr As Jahr, temp.Monat As Monat, SUM(temp.maxi) As Wattstunden  
    FROM (  
    SELECT YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, MAX(Wattstunden) As maxi FROM Data GROUP BY YEAR(Messdatum),    MONTH(Messdatum), AIN  
    ) As temp  
    GROUP BY temp.Jahr, temp.Monat  
    ORDER BY temp.Jahr, temp.Monat DESC  
    LIMIT 13;";  
    $AreaChart_result = mysqli_query($connect, $AreaChart_query);  
    $AreaChart_data = '';  
    $test_array1 = array();  
Anders als bei den bisherigen Abfragen werden die Stromverbrauchsdaten aber nicht in eine Variable, sondern in ein Array geschrieben. Dadurch ist es danach einfach möglich, die Daten zu verändern.

    while($AreaChart_row = mysqli_fetch_array($AreaChart_result)) {  
      $Datum = $AreaChart_row["Jahr"]."-".$AreaChart_row["Monat"];  
      array_push($test_array1, array("datum" => $Datum, "wattstunden" => $AreaChart_row["Wattstunden"]));  
      
    }  
Dieses vorgehen war hierbei nötig, da die Daten mit dem SQL-Befehl nur in kumulierter Form vorliegen.

> Kumuliert: Die Steckdosen liefern für den Monat x die kumulierten Wattstunden des Monats x-1

 Um diese Kumulation zu entfernen, wird für jedes Element des Arrays der Vorherige Monat dem jetzigen Monat abgezogen.
 

    $countArrayLength = count($test_array1);  
      
    for($i=0;$i<$countArrayLength;$i++){  
      if($test_array1[$i+1]['wattstunden'] != null) {  
      $wert = $test_array1[$i]['wattstunden'] - $test_array1[$i+1]['wattstunden'];  
      }  
      else {  
      $wert = $test_array1[$i]['wattstunden'];  
      }  
      $AreaChart_data .= "{period: '".$test_array1[$i]['datum']."', value: ".$wert."}, ";  
    }
    }  

##### SQL
    SELECT temp.Jahr As Jahr, temp.Monat As Monat, SUM(temp.maxi) As Wattstunden  
    FROM (  
    SELECT YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat,
    MAX(Wattstunden) As maxi FROM Data GROUP BY
    YEAR(Messdatum),MONTH(Messdatum), AIN  
    ) As temp  
    GROUP BY temp.Jahr, temp.Monat  
    ORDER BY temp.Jahr, temp.Monat DESC  
    LIMIT 13
##### JavaScript

    <script>  
          Morris.Area({  
          element: 'extra-area-chart',  
          data: [<?php echo $AreaChart_data; ?>],  
          lineColors: ['#009efb'],  
          xkey: 'period',  
          ykeys: ['value'],  
          labels: ['Wattstunden'],  
          pointSize: 0,  
          lineWidth: 1,  
          resize:true,  
          fillOpacity: 0.8,  
          behaveLikeLine: true,  
          gridLineColor: '#e0e0e0',  
          hideHover: 'auto'  
          
          });  
        </script>

---      
#### Liniendiagramm - Stromverbrauch der letzten 7 Tage
![Linien Chart 7 Tage](Bilder/Funktionenbilder/linie7.jpg)
##### PHP
Das Liniendiagramm soll den Stromverbrauch der letzten 7 Tage dargestellt werden. Diese Funktionalität läuft gleich wie der Monatsverbrauch der letzten 12 Monate, nur Gruppiert für Tage und mit einem Limit von 8 Tagen.

    //AreaChart  
    $AreaChart_query2 = "  
    SELECT temp.Jahr As Jahr, temp.Monat As Monat, temp.Tag As Tag, SUM(temp.maxi) As Wattstunden  
    FROM (  
    SELECT YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag, MAX(Wattstunden) As maxi FROM Data GROUP BY YEAR(Messdatum), MONTH(Messdatum), DAY(Messdatum), AIN  
    ) As temp  
    GROUP BY temp.Jahr, temp.Monat, temp.Tag  
    ORDER BY temp.Jahr, temp.Monat, temp.Tag DESC  
    LIMIT 8;";  
    $AreaChart_result2 = mysqli_query($connect, $AreaChart_query2);  
    $AreaChart_data2 = '';  
    $test_array = array();  
    while($AreaChart_row2 = mysqli_fetch_array($AreaChart_result2)) {  
      $Datum2 = $AreaChart_row2["Jahr"]."-".$AreaChart_row2["Monat"]."-".$AreaChart_row2["Tag"];  
      array_push($test_array, array("datum" => $Datum2, "wattstunden" => $AreaChart_row2["Wattstunden"]));  
      
    }  
       
    $countArrayLength2 = count($test_array)-1;  
    for($i=0;$i<$countArrayLength2;$i++){  
      $wert = $test_array[$i]['wattstunden'] - $test_array[$i+1]['wattstunden'];  
      $AreaChart_data2 .= "{period: '".$test_array[$i]['datum']."', value: ".$wert."}, ";  
    }  
##### SQL
    SELECT temp.Jahr As Jahr, temp.Monat As Monat, temp.Tag As Tag, SUM(temp.maxi) As Wattstunden  
    FROM (  
    SELECT YEAR(Messdatum) As Jahr, MONTH(Messdatum) As
    Monat, DAY(Messdatum) As Tag, MAX(Wattstunden) As maxi
    FROM Data GROUP BY YEAR(Messdatum), MONTH(Messdatum),
    DAY(Messdatum), AIN  
    ) As temp  
    GROUP BY temp.Jahr, temp.Monat, temp.Tag  
    ORDER BY temp.Jahr, temp.Monat, temp.Tag DESC  
    LIMIT 8
##### JavaScript
    <script>  
      Morris.Area({  
      element: 'extra-area-chart2',  
      data: [<?php echo $AreaChart_data2; ?>],  
      lineColors: ['#009efb'],  
      xkey: 'period',  
      ykeys: ['value'],  
      labels: ['Wattstunden'],  
      pointSize: 0,  
      lineWidth: 1,  
      resize:true,  
      fillOpacity: 0.8,  
      behaveLikeLine: true,  
      gridLineColor: '#e0e0e0',  
      hideHover: 'auto'  
      
      });  
    </script> 
----
#### Verbleibender Speicherplatz
![Speicheranzeige](Bilder/Funktionenbilder/speicher.jpg)

##### PHP-Datenabfrage
Um den Speicherplatz des Servers auslesen zu können wird die PHP-Funktion "disk_free_space" und "disk_total_space" verwendet. 

    function getSymbolByQuantity($bytes) {  
      $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');  
      $exp = floor(log($bytes)/log(1024));  
      
      return sprintf('%.2f '.$symbol[$exp], ($bytes/pow(1024, floor($exp))));  
    }  
     $hdGnu = disk_free_space("/"); $hdUnu = disk_total_space("/");

##### Verwendung in HTML
Um die Daten der zwei Funktionen (Rückgabe in Byte) sinnvoll darstellen zu können wird im HTML-Code dann die Funktion "getSymbolByQuantity($bytes)" aufgerufen. Die Funktion gibt dann einen GigaByte Wert zurück.

    <div class="btn btn-rounded btn-danger"><?php echo getSymbolByQuantity($hdGnu). " von " .getSymbolByQuantity($hdUnu). " belegt";?>

#### Liniendiagramm (Area) - Aktueller Stromverbrauch AJAX
![Liveticker](Bilder/Funktionenbilder/liveticker.jpg)

##### PHP
> Um die aktuellen Stromverbrauch Daten ohne ein neuladen der Seite zur Verfügung stellen zu können, wurde der nötige PHP-Code in eine eigene Datei geschrieben, die dann in einem definierten Intervall in JavaScript aufgerufen werden kann.

Gleich wie in der Hauptdatei des Dashboards wird zuerst eine Verbindung zur Datenbank aufgebaut.

    <?php  
      
    require("config.php");  
    $connect = new mysqli($Host, $User, $Pass, $DB, $Port);  
      
      $RealTime_Query = "SELECT SUM(Watt)/1000 As Watt, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag, HOUR(Messdatum) As Stunde, MINUTE(Messdatum) As Minute FROM Data GROUP BY YEAR(Messdatum), MONTH(Messdatum), DAY(Messdatum), HOUR(Messdatum), MINUTE(Messdatum) ORDER BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC, HOUR(Messdatum) DESC, MINUTE(Messdatum) DESC LIMIT 20";  
      $RealTime_result = mysqli_query($connect, $RealTime_Query);  
      $data = array();  
Anschließend wird das Datum formatiert und die Daten in die Variable "data" geschrieben.

      while($row = $RealTime_result->fetch_assoc()) {   
      $date = '';  
      $date = $row['Jahr']."-".$row['Monat']."-".$row['Tag']."-".$row['Stunde']."-".$row['Minute'];  
      $data [] = array('Watt' => $row['Watt'], 'Minute' => $date);  
      }  
Zum Schluss werden die Daten per echo im json_encode Format ausgegeben. Diese Ausgabe wird dann später in Javascript verarbeitet.

      echo json_encode($data);  
    ?>

##### SQL
    SELECT SUM(Watt)/1000 As Watt, YEAR(Messdatum) As Jahr,
    MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag,
    HOUR(Messdatum) As Stunde, MINUTE(Messdatum) As Minute
    FROM Data GROUP BY YEAR(Messdatum), MONTH(Messdatum),
    DAY(Messdatum), HOUR(Messdatum), MINUTE(Messdatum)
    ORDER BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC,
    DAY(Messdatum) DESC, HOUR(Messdatum) DESC,
    MINUTE(Messdatum) DESC LIMIT 20
##### JavaScript 
    <script>  
      var getLatestData = function(){  
      var ctx = document.getElementById('real-time-chart');  
      $.ajax({  
      type: 'GET',  
      dataType: 'json',  
      url: 'https://elmo.cloud/main/flotData.php',  
      success: function(response){  
	      if(response) {  
	          var labels = [];  
		      var data = [];  
      
		      $.each(response, function(index, value){  
	              labels.push(value.Minute);  
			      data.push(value.Watt);  
		      });  
		      var chart = new Chart(ctx, {  
	              type: 'line',  
			      data: {  
	                  labels: labels,  
				      datasets: [{  
	                      label: 'Watt',  
					      backgroundColor: 'rgba(116, 96, 268, 0.4)',  
					      borderColor: 'rgba(148, 131, 255, 1)',  
					      borderWidth: 1,  
					      data: data  
                      }]  
                   }  
               });  
		   }  
      },  
      error: function(xhr, ajaxOptions, thrownError){  
	      vtx.style.display = 'none'  
      },  
	  });  
	  }  
      
      $(window).on('load',function () {  
	      getLatestData();  
      });  
      setInterval( function() {  
	      getLatestData();  
      }, 30000);  
      
    </script>

## CSV-Export
![Csv Export](Bilder/Funktionenbilder/csv.jpg)

### HTML
### PHP

    <?php  
    session_start();  
    if(!isset($_SESSION['userid'])) {  
     header('Location: pages-lockscreen.php');  
    }  
      
    if(isset($_POST['von'])) {  
    $von = $_POST['von'];  
    $bis = $_POST['bis'];  
      
    require("config.php");  
    $connect = new mysqli($Host, $User, $Pass, $DB, $Port);  
    $connect->set_charset("utf8");  
    if (!$connect)  
      die("ERROR: Could not connect. " . mysqli_connect_error());  
    // Create and open new csv file  
    $csv = "csv/Data_Von_".$von."_Bis_".$bis."_Generiert_" .date('d-m-Y-his') . '.csv';  
    $file = fopen($csv, 'w');  
    // Get the table  
    if (!$mysqli_result = mysqli_query($connect, "SELECT * FROM Data d INNER JOIN Maschinen m ON d.Name = m.divID WHERE Messdatum BETWEEN (STR_TO_DATE('$von','%Y-%m-%d')) AND (STR_TO_DATE('$bis','%Y-%m-%d'))"))  
     printf("Error: %s\n", $connect->error);  
      // Get column names   
     while ($column = mysqli_fetch_field($mysqli_result)) {  
      $column_names[] = $column->name;  
      }  
      // Write column names in csv file  
      if (!fputcsv($file, $column_names))  
      die('Can\'t write column names in csv file');  
      // Get table rows  
      while ($row = mysqli_fetch_row($mysqli_result)) {  
      // Write table rows in csv files  
      if (!fputcsv($file, $row))  
      die('Can\'t write rows in csv file');  
      }  
    fclose($file);  
    }  
    ?>

### SQL

    SELECT * FROM Data d INNER JOIN Maschinen m ON d.Name = m.divID WHERE Messdatum BETWEEN (STR_TO_DATE('$von','%Y-%m-%d')) AND (STR_TO_DATE('$bis','%Y-%m-%d'))"))  

## Reinigungsintervalle
![Cleantabelle](Bilder/Funktionenbilder/clean.jpg)

### HTML
### PHP
#### Datenabfrage 
      
    //Last-Clean & Reinigung  
    if(isset($_GET['ID'])) {  
      $ID = $_GET['ID'];  
      $Stunden = $_GET['stunden'];  
      if ($stmt1 = $connect->prepare("UPDATE Maschinen SET LastClean = now() WHERE divID = ".$ID."")) {  
      $stmt1->execute();  
      }  
      if ($stmt2 = $connect->prepare("insert into Reinigungen(MaschinenID, AnzahlBetriebsstunden) values ('".$ID."', '".$Stunden."')")) {  
      $stmt2->execute();  
      }  
    }  
      
    $table_query1 = "  
    SELECT MAX(Maschinenname) As Name, COUNT(AIN)/60 As AnzahlStunden, MAX(ID) As ID, MAX(LastClean) As LastClean  
    FROM (  
     SELECT MAX(Maschinen.Maschinenname) As Maschinenname, AIN, MAX(Maschinen.divID) As ID, MAX(LastClean) As LastClean  
     FROM Data   INNER JOIN Maschinen ON Maschinen.divID = Data.Name  
     GROUP BY AIN, YEAR(Messdatum), MONTH(Messdatum), DAY(Messdatum), HOUR(Messdatum),            MINUTE(Messdatum)  
     HAVING MIN(Watt) > 5000 AND MIN(Messdatum) > LastClean) As Daten  
    GROUP BY AIN  
    ORDER BY AnzahlStunden DESC  
    ";  
    $table_result1 = mysqli_query($connect, $table_query1);  
      
      
    //Reinigungstabelle  
    $table_query2 = "  
    SELECT Maschinenname, ReinigungDatum, AnzahlBetriebsstunden, m.divID  
    FROM Reinigungen r INNER JOIN Maschinen m ON r.MaschinenID = m.divID  
    ORDER BY MaschinenID  
    ";  
    $table_result2 = mysqli_query($connect, $table_query2);  
      
    ?>

#### Darstellung genutzte Maschinen

    <?php  
    while($table_row1 = mysqli_fetch_array($table_result1)) {  
      echo "<tr>";  
      echo "<td>".$table_row1["ID"]."</td>";  
      echo "<td>".utf8_encode($table_row1["Name"])."</td>";  
      echo "<td>".$table_row1["AnzahlStunden"]." Stunden</td>";  
      echo "<td>10 Stunden</td>";  
      echo "<td>".$table_row1["LastClean"]."</td>";  
      if($table_row1["AnzahlStunden"]<10) {  
      echo "<td id=\"m1\" action=\"#\" method=\"post\">  
     <button class=\"btn waves-effect waves-light btn-sm btn-secondary\" type=\"submit\">Nicht verfügbar</button>  
     </td>";  
      }  
      else {  
      echo "<td id=\"m2\" action=\"#\" method=\"post\">  
     <button class=\"btn waves-effect waves-light btn-sm btn-danger\" type=\"submit\" onclick=\"window.location.href='cleantable.php?ID=".$table_row1["ID"]."&stunden=".$table_row1["AnzahlStunden"]."'\">Reinigung bestätigen</button>  
     </td>";  
      }  
      echo "</tr>";  
    }  
    ?>

#### Darstellung vergangene Reinigungen

    <?php  
    while($table_row2 = mysqli_fetch_array($table_result2)) {  
      echo "<tr>";  
      echo "<td>".$table_row2["divID"]."</td>";  
      echo "<td>".utf8_encode($table_row2["Maschinenname"])."</td>";  
      echo "<td>".$table_row2["AnzahlBetriebsstunden"]." Stunden</td>";  
      echo "<td>10 Stunden</td>";  
      echo "<td>".$table_row2["ReinigungDatum"]."</td>";  
      echo "</tr>";  
    }  
    ?>

### SQL
#### Genutzte Maschinen
    SELECT MAX(Maschinenname) As Name, COUNT(AIN)/60 As AnzahlStunden, MAX(ID) As ID, MAX(LastClean) As LastClean  
    FROM (  
     SELECT MAX(Maschinen.Maschinenname) As Maschinenname, AIN, MAX(Maschinen.divID) As ID, MAX(LastClean) As LastClean  
     FROM Data   INNER JOIN Maschinen ON Maschinen.divID = Data.Name  
     GROUP BY AIN, YEAR(Messdatum), MONTH(Messdatum), DAY(Messdatum), HOUR(Messdatum),            MINUTE(Messdatum)  
     HAVING MIN(Watt) > 5000 AND MIN(Messdatum) > LastClean) As Daten  
    GROUP BY AIN  
    ORDER BY AnzahlStunden DESC 
    
#### Vergangene Reinigungen
    SELECT Maschinenname, ReinigungDatum, AnzahlBetriebsstunden, m.divID  
    FROM Reinigungen r INNER JOIN Maschinen m ON r.MaschinenID = m.divID  
    ORDER BY MaschinenID 
    
### JavaScript
## Alle Maschinen
![Alle Maschinen](Bilder/Funktionenbilder/alle.jpg)

### HTML
### PHP

    <?php  
    session_start();  
    if(!isset($_SESSION['userid'])) {  
     header('Location: pages-lockscreen.php');  
    }  
      
    require("config.php");  
    $connect = new mysqli($Host, $User, $Pass, $DB, $Port);  
      
    $table_query1 = "  
    SELECT m.Maschinenname, m.divID, m.raum, m.LastClean, r.Name As Raumname FROM Maschinen m INNER JOIN Raum r on m.raum = r.ID;  
    ";  
    $table_result1 = mysqli_query($connect, $table_query1);  
      
    ?>
Darstellung

    <?php  
    while($table_row1 = mysqli_fetch_array($table_result1)) {  
      echo "<tr>";  
      echo "<td>".$table_row1["divID"]."</td>";  
      echo "<td>".utf8_encode($table_row1["Maschinenname"])."</td>";  
      echo "<td>".$table_row1["Raumname"]."</td>";  
      echo "<td>".$table_row1["LastClean"]."</td>";  
      echo "</tr>";  
    }  
    ?>

### SQL

    SELECT m.Maschinenname, m.divID, m.raum, m.LastClean, r.Name As Raumname FROM Maschinen m INNER JOIN Raum r on m.raum = r.ID

## Login
![Login](Bilder/Funktionenbilder/login.jpg)

### HTML
### PHP

    <?php  
    session_start();  
    require("config.php");  
    $connect = new mysqli($Host, $User, $Pass, $DB, $Port);  
      
      
    if(isset($_GET['login'])) {  
      $passwort = $_POST['password'];  
      $login_query= "SELECT id, passwort FROM User";  
      $login_result = mysqli_query($connect, $login_query);  
      $login_row = mysqli_fetch_array($login_result);  
      
      //Überprüfung des Passworts  
      if (password_verify($passwort, $login_row['passwort'])) {  
      $_SESSION['userid'] = $login_row['id'];  
      header('Location: admindashboard.php');  
      } else {  
      $errorMessage = "<script type='text/javascript'>  
      alert('Anmeldung fehlgeschlagen!');  
     </script>";  
      }  
      }  
    ?>

### SQL

    SELECT id, passwort FROM User

## Credits

-   [Bootstrap](http://getbootstrap.com/)
-   [Jquery](https://jquery.com/)
-   [Font-Awesome](http://fortawesome.github.io/Font-Awesome/)
-   [Sweet-Alert](https://sweetalert.js.org/)
-   [Multi-select](http://loudev.com/)
-   [Datatables](https://www.datatables.net)
-   [Morris](http://morrisjs.github.io/morris.js/)
-   [Chartjs](http://chartjs.org/)
-   [Themify-icons](https://themify.me/themify-icons)
-   [Bootstrap tables](https://github.com/wenzhixin/bootstrap-table-examples)
-   [Material Pro](https://wrappixel.com/demos/admin-templates/material-pro/landingpage/index.html)
- [CSV-Export](https://github.com/luka-balantic/Export-CSV-from-database-with-PHP-mysqli/blob/master/exportCSV.php)
- [SlimScroll](https://github.com/rochal/jQuery-slimScroll)
- [Waves](http://fian.my.id/Waves/)
- [Sidebar Menu](https://github.com/huang-x-h/sidebar-menu)
- [Sticky Kit](http://leafo.net/sticky-kit/)

 

<!--stackedit_data:
eyJoaXN0b3J5IjpbLTE5Mjg1MjM1NjMsMTA2OTIxMDM1MiwtMT
YyODc3MzI4NywtMTQzOTcxMjM1OSwtNjU5MDY2ODI4LC0xNzEz
OTU1ODcsMTU4NDcwNjUxNywxODA0ODM5NDkwLDE2MzUwNjU1ND
YsMzI5NzE5MjgsMTUxODQ1NTM4NSwxNjgwODQ3MjA1LDE0NjIy
MjgyNDIsMzAyNjY4MjEwLC05NzYwNDkzMTQsMTEwNDg3Mzk4MC
wxMTIzMDQ5Mjg5LC0xNDMwODEzMDAxLC0xMjUwMTM2MTE0LC04
ODk1MDMyNjddfQ==
-->