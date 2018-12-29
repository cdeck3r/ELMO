# 1. Dokumentation FrontEnd
## 1.1 Framework
### 1.1.1. Logo
### 1.1.2. CSS
### 1.1.3. HTML
## 1.2. Benutzerbereich
## Grundriss | Raumpläne
#### 1.2.1.  HTML
#### 1.2.2. PHP
#### 1.2.3. JavaScript
## 1.3. Ansprechpartner
### Verantwortliche Personen
## Adminbereich
## Charts
### PHP
<?php  
session_start();  
if(!isset($_SESSION['userid'])) {  
 header('Location: pages-lockscreen.php');  
}  
?>  
  
<?php  
  
require("config.php");  
$connect = new mysqli($Host, $User, $Pass, $DB, $Port);  
  
//Box1  
$Box1_query = "SELECT SUM(temp.Wattstunden) As Wattstunden FROM (SELECT MAX(Wattstunden) As Wattstunden FROM Data GROUP BY AIN) As temp";  
$Box1_result = mysqli_query($connect, $Box1_query);  
$Box1_row = mysqli_fetch_array($Box1_result);  
  
//Box2  
$Box2_query = "SELECT COUNT(DISTINCT AIN) As Anzahl FROM Data WHERE Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)";  
$Box2_result = mysqli_query($connect, $Box2_query);  
$Box2_row = mysqli_fetch_array($Box2_result);  
  
//Box3  
$Box3_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden DESC Limit 1";  
$Box3_result = mysqli_query($connect, $Box3_query);  
$Box3_row = mysqli_fetch_array($Box3_result);  
  
//Box4  
$Box4_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden ASC Limit 1";  
$Box4_result = mysqli_query($connect, $Box4_query);  
$Box4_row = mysqli_fetch_array($Box4_result);  
  
  
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
$DonuteChart_data = '';  
while($DonuteChart_row = mysqli_fetch_array($DonuteChart_result)) {  
  $DonuteChart_data .= "{ label: \"".utf8_encode($DonuteChart_row["Name"])."\", value: ".$DonuteChart_row["Wattstunden"]."}, ";  
}  
$DonuteChart_data = substr($DonuteChart_data, 0, -2);  
  
  
//Säulendiagramm  
$Säulendiagramm_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden ASC";  
$Säulendiagramm_result = mysqli_query($connect, $Säulendiagramm_query);  
while($Säulendiagramm_row = mysqli_fetch_array($Säulendiagramm_result)) {  
  $sDataL .= "\"".utf8_encode($Säulendiagramm_row["Name"])."\", ";  
  $sDataD .= $Säulendiagramm_row["Wattstunden"].", ";  
}  
$sDataL = substr($sDataL, 0, -2);  
$sDataD = substr($sDataD, 0, -2);  
  
//Temperatur  
$temp_query = "SELECT AVG(Temperatur)/10 As Temperatur, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag FROM Data GROUP BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC LIMIT 20";  
$temp_result = mysqli_query($connect, $temp_query);  
while($temp_row = mysqli_fetch_array($temp_result)) {  
  $tempL .= "\"".$temp_row["Jahr"]."-".$temp_row["Monat"]."-".$temp_row["Tag"]."\", ";  
  $tempD .= $temp_row["Temperatur"].", ";  
}  
$tempL = substr($tempL, 0, -2);  
$tempD = substr($tempD, 0, -2);  
  
  
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
  
//$test_array = array_reverse($test_array);  
$countArrayLength2 = count($test_array)-1;  
for($i=0;$i<$countArrayLength2;$i++){  
  $wert = $test_array[$i]['wattstunden'] - $test_array[$i+1]['wattstunden'];  
  $AreaChart_data2 .= "{period: '".$test_array[$i]['datum']."', value: ".$wert."}, ";  
}  
  
function getSymbolByQuantity($bytes) {  
  $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');  
  $exp = floor(log($bytes)/log(1024));  
  
  return sprintf('%.2f '.$symbol[$exp], ($bytes/pow(1024, floor($exp))));  
}  
 $hdGnu = disk_free_space("/"); $hdUnu = disk_total_space("/");

### SQL
### JavaScript
## Wartungsintervalle
### HTML
### PHP
### SQL
### JavaScript
## Login
### Sessions
### PHP
<!--stackedit_data:
eyJoaXN0b3J5IjpbMjM3MTczMDczLC0xNzcwNDQyNDk3LC0xNj
k5NTA5Njg0LDE4ODE4NzAwNjFdfQ==
-->