<!-- ############################################################## -->
<!-- ############################################################## -->
<!--
Template Name: ELMO Cloud - Adminbereich
Author: Patrick Ardelean, Timo Hegenberg
Email: elmo.project18@gmail.com
File: php
-->
<!-- ############################################################## -->
<!-- ############################################################## -->


<!DOCTYPE html>

<!-- ============================================================== -->
<!-- Charts PHP-->
<!-- ============================================================== -->

<?php
//Login-Session
session_start();
if(!isset($_SESSION['userid'])) {
    header('Location: pages-lockscreen.php');
}

//MYSQL-Verbindung
require("config.php");
$connect = new mysqli($Host, $User, $Pass, $DB, $Port);

//Box1 (Total Stromverbrauch)
$Box1_query = "SELECT SUM(temp.Wattstunden) As Wattstunden FROM (SELECT MAX(Wattstunden) As Wattstunden FROM Data GROUP BY AIN) As temp";
$Box1_result = mysqli_query($connect, $Box1_query);
$Box1_row = mysqli_fetch_array($Box1_result);

//Box2 (Belegte Maschinen)
$Box2_query = "SELECT COUNT(DISTINCT AIN) As Anzahl FROM Data WHERE Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)";
$Box2_result = mysqli_query($connect, $Box2_query);
$Box2_row = mysqli_fetch_array($Box2_result);

//Box3 (Top Stromverbrauch)
$Box3_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden DESC Limit 1";
$Box3_result = mysqli_query($connect, $Box3_query);
$Box3_row = mysqli_fetch_array($Box3_result);

//Box4 (Low Stromverbrauch)
$Box4_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden ASC Limit 1";
$Box4_result = mysqli_query($connect, $Box4_query);
$Box4_row = mysqli_fetch_array($Box4_result);


//DonutChart (Verbrauch pro Raum)
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


//Säulendiagramm (Verbrauch pro Maschine
$Säulendiagramm_query = "SELECT MAX(Wattstunden) As Wattstunden, MAX(Name) As Name FROM Data GROUP BY AIN ORDER BY Wattstunden ASC";
$Säulendiagramm_result = mysqli_query($connect, $Säulendiagramm_query);
while($Säulendiagramm_row = mysqli_fetch_array($Säulendiagramm_result)) {
    $sDataL .= "\"".utf8_encode($Säulendiagramm_row["Name"])."\", ";
    $sDataD .= $Säulendiagramm_row["Wattstunden"].", ";
}
$sDataL = substr($sDataL, 0, -2);
$sDataD = substr($sDataD, 0, -2);

//Parameter AVG. Temperatur pro Tag
$temp_query = "SELECT AVG(Temperatur)/10 As Temperatur, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag FROM Data GROUP BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC LIMIT 20";
$temp_result = mysqli_query($connect, $temp_query);
while($temp_row = mysqli_fetch_array($temp_result)) {
    $tempL .= "\"".$temp_row["Jahr"]."-".$temp_row["Monat"]."-".$temp_row["Tag"]."\", ";
    $tempD .= $temp_row["Temperatur"].", ";
}
$tempL = substr($tempL, 0, -2);
$tempD = substr($tempD, 0, -2);


//AreaChart Monate
$AreaChart_query = "
SELECT temp.Jahr As Jahr, temp.Monat As Monat, SUM(temp.maxi) As Wattstunden
FROM (
SELECT YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, MAX(Wattstunden) As maxi FROM Data GROUP BY YEAR(Messdatum), 	MONTH(Messdatum), AIN
) As temp
GROUP BY temp.Jahr, temp.Monat
ORDER BY temp.Jahr DESC, temp.Monat DESC
LIMIT 13;";
$AreaChart_result = mysqli_query($connect, $AreaChart_query);
$AreaChart_data = '';
$test_array1 = array();
while($AreaChart_row = mysqli_fetch_array($AreaChart_result)) {
    $Datum = $AreaChart_row["Jahr"]."-".$AreaChart_row["Monat"];
	array_push($test_array1, array("datum" => $Datum, "wattstunden" => $AreaChart_row["Wattstunden"]));

}

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

//else {
//$countArrayLength = count($test_array1);
//$AreaChart_data .= "{period: '".$test_array1[0]['datum']."', value: ".$test_array1[0]['wattstunden']."}, ";
//}


//AreaChart
$AreaChart_query2 = "
SELECT temp.Jahr As Jahr, temp.Monat As Monat, temp.Tag As Tag, SUM(temp.maxi) As Wattstunden
FROM (
SELECT YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag, MAX(Wattstunden) As maxi FROM Data GROUP BY YEAR(Messdatum), MONTH(Messdatum), DAY(Messdatum), AIN
) As temp
GROUP BY temp.Jahr, temp.Monat, temp.Tag
ORDER BY temp.Jahr DESC, temp.Monat DESC, temp.Tag DESC
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

function getSymbolByQuantity($bytes) {
    $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
    $exp = floor(log($bytes)/log(1024));

    return sprintf('%.2f '.$symbol[$exp], ($bytes/pow(1024, floor($exp))));
}

//Anwendung (Speicherbelegung):
$hdGnu = disk_free_space("/"); 
$hdUnu = disk_total_space("/");
$hdFree = $hdUnu - $hdGnu;



?>

<!-- ============================================================== -->
<!-- Charts PHP ENDE-->
<!-- ============================================================== -->


<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>ELMO CLOUD | Admin Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Bootstrap CSS -->
    <link href="./dark/css/style.css" rel="stylesheet">
    <!-- Custom ELMO CSS -->
    <link href="./dark/css/costumpi.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="./dark/css/colors/purple-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header">
                <a class="navbar-brand" href="admindashboard.php">
                    <!-- Logo icon --><b>
                        <!-- Dark Logo icon -->
                        <img src="../assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                        <!-- Light Logo icon -->
                        <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                        <!-- Light Logo text -->
                         <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto mt-md-0">
                    <!-- This is  -->
                    <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                </ul>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <ul class="navbar-nav my-lg-0">
                    <!-- ============================================================== -->
                    <!-- Adminbereich -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a href="index.php?logout=1" class="btn waves-effect waves-light btn-danger">Hauptbereich</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->

            <?php include ("nav_admin.php"); ?>

            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and Storage -->
            <!-- ============================================================== -->
            <div class="row page-titles">

                <!-- Bread crumb Funktion -->
                <div class="col-lg-6 col-6 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Adminpanel</a></li>
                        <li class="breadcrumb-item active">Übersicht</li>
                    </ol>
                </div>

                <!-- Speicherbelegung Box -->
                <div class="col-lg-6 col-6 align-self-center">
                    <div class="row  justify-content-end">
                        <div class="m-l-10 m-r-5 m-t-10 align-self-center">
                            <h5 class="m-b-1">Speicherbelegung</h5>
                            <div class="progress">
                                <div class="progress-bar bg-info wow animated progress-animated" role="progressbar" aria-valuenow="<?php echo $hdFree;?>" aria-valuemin="0" aria-valuemax="<?php echo $hdUnu;?>" style="width:<?php echo round(($hdFree/$hdUnu*100), 1)."%";?>; height:12px;"><span class="sr-only">Complete</span></div>
                            </div>
                            <span class="stextb m-t-0"><?php echo getSymbolByQuantity($hdFree);?> GB</span>
                            <span class="stext"> von <?php echo getSymbolByQuantity($hdUnu);?>GB belegt</span>
                        </div>

                    </div>
               </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and Storage -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <!-- Row Datenboxen Small (4 Boxes)-->
            <div class="row">
                <!-- Total Stromverbrauch BOX -->
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-body card-darkbb">

                            <div class="d-flex">
                                <div class="m-r-20 align-self-center">
                                    <h2 class="text-white"><i class="fas fa-bolt"></i></h2>
                                </div>
                                <div>
                                    <h4 class="card-title">Total Stromverbrauch</h4>
                                </div>
                            </div>


                            <div class="text-center">
                                <span class="text-white font-weight-bold"><?php echo $Box1_row["Wattstunden"]; ?></span><span class="text-white font-weight-light"> Wattstunden</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Low Stromverbrauch BOX -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex">
                                <div class="m-r-20 align-self-center">
                                    <h2 class="text-white"><i class="fas fa-arrow-circle-down"></i></h2>
                                </div>
                                <div>
                                    <h4 class="card-title text-info">Low Stromverbrauch</h4>
                                </div>
                            </div>


                            <div class="text-center">
                                <span class="text-white font-weight-light">Maschine </span><span class="text-white font-weight-bold"><?php echo utf8_encode($Box4_row["Name"]); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Stromverbrauch BOX -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex">
                                <div class="m-r-20 align-self-center">
                                    <h2 class="text-white"><i class="fas fa-arrow-circle-up"></i></h2>
                                </div>
                                <div>
                                    <h4 class="card-title text-danger">Top Stromverbrauch</h4>
                                </div>
                            </div>


                            <div class="text-center">
                                <span class="text-white font-weight-light">Maschine </span><span class="text-white font-weight-bold"><?php echo utf8_encode($Box3_row["Name"]); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Belegte Maschinen BOX -->
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-body card-redd">

                            <div class="d-flex">
                                <div class="m-r-20 align-self-center">
                                    <h2 class="text-white"><i class="far fa-check-circle"></i></h2>
                                </div>
                                <div>
                                    <h4 class="card-title">Besetzte Maschinen</h4>
                                </div>
                            </div>


                            <div class="text-center">
                                <span class="text-white font-weight-bold"><?php echo $Box2_row["Anzahl"]; ?></span><span class="text-white font-weight-light"> von 77</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row (2 Boxes)-->
            <div class="row">

                <!-- Donutcharts Stromverbrauch pro Raum -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions">
                                <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                            </div>
                            <h4 class="card-title m-b-0">Stromverbrauch pro Raum in Wattstunden</h4>
                        </div>
                        <div class="card-body collapse show">
                            <div id="morris-donut-chart"></div>

                        </div>
                    </div>
                </div>

                <!-- Stromverbrauch der letzten 7 Tage -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions">
                                <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                            </div>
                            <h4 class="card-title m-b-0">Stromverbrauch der letzten 7 Tage</h4>
                        </div>
                        <div class="card-body collapse show">

                                <div id="extra-area-chart2"></div>

                        </div>
                    </div>
                </div>

                <!------- Single Chart Boxes-------->

                <!-- Stromverbrauch pro Maschine in Wattstunde -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions">
                                <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                            </div>
                            <h4 class="card-title m-b-0">Stromverbrauch pro Maschine in Wattstunde</h4>
                        </div>
                        <div class="card-body collapse show">
                            <canvas id="bar2" height="150"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Durchschnitsstemperatur -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions">
                                <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                            </div>
                            <h4 class="card-title m-b-0">Durchschnitsstemperatur</h4>
                        </div>
                        <div class="card-body collapse show">
                            <canvas id="temperatur" height="150"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Monatsverbrauch in Wattstunden -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions">
                                <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                            </div>
                            <h4 class="card-title m-b-0">Monatsverbrauch in Wattstunden</h4>
                        </div>
                        <div class="card-body collapse show">
                            <div id="extra-area-chart"></div>
                        </div>
                    </div>
                </div>

                <!-- Liveticker -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions">
                                <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                            </div>
                            <h4 class="card-title m-b-0">Liveticker</h4>
                        </div>
                        <div class="card-body collapse show">
                            <canvas id="real-time-chart" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <!-- column -->
            </div>

            <!-- ============================================================== -->
            <!-- End Page Content -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <?php include ("footer.php"); ?>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- slimscrollbar scrollbar JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<!--Menu sidebar -->
<script src="js/sidebarmenu.js"></script>

<!--Custom JavaScript -->
<script src="js/custom.min.js"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->

<!--Morris JavaScript -->
<script src="../assets/plugins/raphael/raphael-min.js"></script>
<script src="../assets/plugins/morrisjs/morris.js"></script>
<!-- Flot Charts JavaScript -->
<script src="../assets/plugins/flot/excanvas.js"></script>
<script src="../assets/plugins/flot/jquery.flot.js"></script>
<script src="../assets/plugins/flot/jquery.flot.pie.js"></script>
<script src="../assets/plugins/flot/jquery.flot.time.js"></script>
<script src="../assets/plugins/flot/jquery.flot.stack.js"></script>
<script src="../assets/plugins/flot/jquery.flot.crosshair.js"></script>
<script src="../assets/plugins/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>

<!--stickey kit -->
<script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!-- ============================================================== -->
<!-- ELMO Costum Script -->
<!-- ============================================================== -->

<!-- Donut Chart Costumizing (Verbrauch pro Raum) -->
<script>
    Morris.Donut({
        element: 'morris-donut-chart',
        data:[<?php echo $DonuteChart_data; ?>],
        resize: true,
        colors:['#7160ee','#1e88e5', '#fc4b6c', '#009efb', '#2f3d4a'],
        labelColor: '#dcf8ff',
        gridLineColor: '#263238',
        lineColors: '#263238'
    });
</script>

<!-- Area Chart Costumizing (Monatsverbrauch in Wattstunden) -->
<script>
    Morris.Area({
        element: 'extra-area-chart',
        data: [<?php echo $AreaChart_data; ?>],
        lineColors: ['#009efb'],
        xkey: 'period',
        ykeys: ['value'],
        labels: ['Wattstunden'],
        pointSize: 2,
        lineWidth: 1,
        resize: true,
        fillOpacity: 0.4,
        behaveLikeLine: true,
        gridLineColor: '#161d20',
        hideHover: 'auto'

    });
</script>

<!-- Area Chart Costumizing (Stromverbrauch der letzten 7 Tage) -->
<script>
    Morris.Line({
        element: 'extra-area-chart2',
        data: [<?php echo $AreaChart_data2; ?>],
        xkey: 'period',
        ykeys: ['value'],
        labels: ['Wattstunden'],
        pointSize: 2,
        fillOpacity: 0.4,
        pointStrokeColors:['#373636'],
        behaveLikeLine: true,
        gridLineColor: '#161d20',
        lineWidth: 1.5,
        smooth: true,
        hideHover: 'auto',
        lineColors: ['#d3c9d5'],
        resize: true

    });
</script>

<!-- Bar Chart Costumizing (Stromverbrauch pro Maschine in Wattstunde) -->
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

<!-- Area Chart Costumizing (Durchschnitsstemperatur) -->
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

<!-- Area Chart Costumizing (Liveticker) -->
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

<!-- ============================================================== -->
<!-- ELMO Costum Script ENDE -->
<!-- ============================================================== -->
</body>

</html>
