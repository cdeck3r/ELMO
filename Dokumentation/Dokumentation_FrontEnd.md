# 1. Dokumentation FrontEnd
## 1.1 Framework
### 1.1.1. Logo
### 1.1.2. CSS
### 1.1.3. HTML
## 1.2. Benutzerbereich
## Grundriss | Raumpläne
#### 1.2.1.  HTML
#### 1.2.2. PHP

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

#### 1.2.3. JavaScript
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

## 1.3. Ansprechpartner
### Verantwortliche Personen
## Adminbereich
## Charts
### PHP

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

#### Box1 - Summe Wattstunden
Im ersten Befehl wird die Summe der Wattstunden ausgelesen und in die PHP-Variable "Box1_row" geschrieben.

    //Box1  
    $Box1_query = "SELECT SUM(temp.Wattstunden) As Wattstunden FROM (SELECT MAX(Wattstunden) As Wattstunden FROM Data GROUP BY AIN) As temp";  
    $Box1_result = mysqli_query($connect, $Box1_query);  
    $Box1_row = mysqli_fetch_array($Box1_result);  
      


#### Box2 - Anzahl aktive Maschinen
Die zweite Box soll die Anzahl der aktiven Maschinen darstellen. Dies wird in die Variable "Box2_row" geschrieben.

    //Box2  
    $Box2_query = "SELECT COUNT(DISTINCT AIN) As Anzahl FROM Data WHERE Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)";  
    $Box2_result = mysqli_query($connect, $Box2_query);  
    $Box2_row = mysqli_fetch_array($Box2_result);  
      


#### Box3 - Maschine mit höchstem Stromverbrauch
Die dritte Box enthält die Maschine, die bisher am meisten Wattstunden benötigt hat. Das Ergebnis wird in die Variable "Box3_row" geschrieben.

    //Box3  
    $Box3_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden DESC Limit 1";  
    $Box3_result = mysqli_query($connect, $Box3_query);  
    $Box3_row = mysqli_fetch_array($Box3_result);  
      


#### Box4 - Maschine mit niedrigstem Stromverbrauch
Die vierte Box enthält die Maschine, die bisher am wenigsten Wattstunden verbraucht hat. Das Ergebnis wird in die Variable "Box4_row" geschrieben.

    //Box4  
    $Box4_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden ASC Limit 1";  
    $Box4_result = mysqli_query($connect, $Box4_query);  
    $Box4_row = mysqli_fetch_array($Box4_result);  
      
 #### Donuechart - Summe Wattstunden gruppiert nach Raum
 
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

#### Säulendiagramm - Summe Wattstunden nach Maschinen
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

#### Liniendiagramm - Temperaturverlauf der letzten 20 Tage
Das Liniendiagramm soll den Temperatur
    //Temperatur  
    $temp_query = "SELECT AVG(Temperatur)/10 As Temperatur, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag FROM Data GROUP BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC LIMIT 20";  
    $temp_result = mysqli_query($connect, $temp_query);  
    while($temp_row = mysqli_fetch_array($temp_result)) {  
      $tempL .= "\"".$temp_row["Jahr"]."-".$temp_row["Monat"]."-".$temp_row["Tag"]."\", ";  
      $tempD .= $temp_row["Temperatur"].", ";  
    }  
    $tempL = substr($tempL, 0, -2);  
    $tempD = substr($tempD, 0, -2);  
      
#### Liniendiagramm (Area) - Stromverbrauch der letzten 12 Monate  
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
    while($AreaChart_row = mysqli_fetch_array($AreaChart_result)) {  
      $Datum = $AreaChart_row["Jahr"]."-".$AreaChart_row["Monat"];  
      array_push($test_array1, array("datum" => $Datum, "wattstunden" => $AreaChart_row["Wattstunden"]));  
      
    }  
      
    if(count($test_array1)>1) {  
    $countArrayLength = count($test_array1)-1;  
      
    for($i=0;$i<$countArrayLength;$i++){  
      $wert = $test_array1[$i]['wattstunden'] - $test_array1[$i+1]['wattstunden'];  
      $AreaChart_data .= "{period: '".$test_array1[$i]['datum']."', value: ".$wert."}, ";  
    }  
    }  
      
    else {  
    $countArrayLength = count($test_array1);  
    $AreaChart_data .= "{period: '".$test_array1[0]['datum']."', value: ".$test_array1[0]['wattstunden']."}, ";  
    }  
      
#### Liniendiagramm - Stromverbrauch der letzten 7 Tage
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
   
#### Verbleibender Speicherplatz
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

### SQL
#### Box1

    SELECT SUM(temp.Wattstunden) As Wattstunden FROM (SELECT MAX(Wattstunden) As Wattstunden FROM Data GROUP BY AIN) As temp

#### Box2

    SELECT COUNT(DISTINCT AIN) As Anzahl FROM Data WHERE Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)

#### Box3

    SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden DESC Limit 1

#### Box4

    SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden ASC Limit 1

#### Donutechart

    SELECT SUM(Wattstunden) as Wattstunden, MAX(Raum.Name) As Name  
    FROM (  
    SELECT MAX(Wattstunden) As Wattstunden, MAX(Raum) As Raum FROM Data d INNER JOIN Maschinen m ON d.Name = m.divID GROUP BY AIN  
    ) As Raume  
    INNER JOIN Raum on Raume.Raum = Raum.ID  
    GROUP BY Raum  
    Order By Wattstunden DESC

#### Säulendiagramm

    SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden ASC

#### Liniediagramm - Temperatur

    SELECT AVG(Temperatur)/10 As Temperatur, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag FROM Data GROUP BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC LIMIT 20

#### Liniediagramm - Monatsverbrauch

    SELECT temp.Jahr As Jahr, temp.Monat As Monat, SUM(temp.maxi) As Wattstunden  
    FROM (  
    SELECT YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, MAX(Wattstunden) As maxi FROM Data GROUP BY YEAR(Messdatum),    MONTH(Messdatum), AIN  
    ) As temp  
    GROUP BY temp.Jahr, temp.Monat  
    ORDER BY temp.Jahr, temp.Monat DESC  
    LIMIT 13

#### Liniediagramm - Tagesverbrauch

    SELECT temp.Jahr As Jahr, temp.Monat As Monat, temp.Tag As Tag, SUM(temp.maxi) As Wattstunden  
    FROM (  
    SELECT YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag, MAX(Wattstunden) As maxi FROM Data GROUP BY YEAR(Messdatum), MONTH(Messdatum), DAY(Messdatum), AIN  
    ) As temp  
    GROUP BY temp.Jahr, temp.Monat, temp.Tag  
    ORDER BY temp.Jahr, temp.Monat, temp.Tag DESC  
    LIMIT 8

#### Liniendiagramm - Momentaner Verbrauch

    SELECT SUM(Watt)/1000 As Watt, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag, HOUR(Messdatum) As Stunde, MINUTE(Messdatum) As Minute FROM Data GROUP BY YEAR(Messdatum), MONTH(Messdatum), DAY(Messdatum), HOUR(Messdatum), MINUTE(Messdatum) ORDER BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC, HOUR(Messdatum) DESC, MINUTE(Messdatum) DESC LIMIT 20

### JavaScript

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
    <script>  
      var getLatestData = function(){  
            window.chartColors = {  
                red: 'rgb(255, 99, 132)',  
      orange: 'rgb(255, 159, 64)',  
      yellow: 'rgb(255, 205, 86)',  
      green: 'rgb(75, 192, 192)',  
      blue: 'rgb(54, 162, 235)',  
      purple: 'rgb(153, 102, 255)',  
      grey: 'rgb(201, 203, 207)'  
      };  
      var ctx = document.getElementById('real-time-chart');  
      $.ajax({  
                type: 'GET',  
      dataType: 'json',  
      url: 'https://elmo.cloud/main/flotData.php',  
      success: function(response){  
                    if(response){  
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

## Wartungsintervalle
### HTML
### PHP
### SQL
### JavaScript
## Login
### Sessions
### PHP




<!--stackedit_data:
eyJoaXN0b3J5IjpbLTE4MDE4MDY5MTIsMTY1MjgxMTM5NiwxNj
ExNjIwNTY0LDEyODQwOTA5MTQsMTQ5MjQ0MzE0NCwzMDMyOTM5
ODcsLTE3NzA0NDI0OTcsLTE2OTk1MDk2ODQsMTg4MTg3MDA2MV
19
-->