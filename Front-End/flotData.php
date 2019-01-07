<?php
//Login-Session
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: pages-lockscreen.php');
}
require("config.php");
$connect = new mysqli($Host, $User, $Pass, $DB, $Port);

	$RealTime_Query = "SELECT SUM(Watt)/1000 As Watt, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag, HOUR(Messdatum) As Stunde, MINUTE(Messdatum) As Minute FROM Data GROUP BY YEAR(Messdatum), MONTH(Messdatum), DAY(Messdatum), HOUR(Messdatum), MINUTE(Messdatum) ORDER BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC, HOUR(Messdatum) DESC, MINUTE(Messdatum) DESC LIMIT 20";
	$RealTime_result = mysqli_query($connect, $RealTime_Query);
	$data = array();
	while($row = $RealTime_result->fetch_assoc()) {
		//$data[] = $row;
		$date = '';
		$date = $row['Jahr']."-".$row['Monat']."-".$row['Tag']."-".$row['Stunde']."-".$row['Minute'];
		$data [] = array('Watt' => $row['Watt'], 'Minute' => $date);
	}
	echo json_encode($data);
?>
	