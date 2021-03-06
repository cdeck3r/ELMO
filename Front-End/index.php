<!-- ############################################################## -->
<!-- ############################################################## -->
<!--
Template Name: ELMO Cloud - MAP - Raum 01-031N
Author: Patrick Ardelean, Timo Hegenberg, Justus Mattedi, Jan Schick
Email: elmo.project18@gmail.com
File: php
-->
<!-- ############################################################## -->
<!-- ############################################################## -->

<?php
if(isset($_GET['logout'])) {
session_start();
session_destroy();
}
    
 require("config.php");
 $connect = new mysqli($Host, $User, $Pass, $DB, $Port);

 //Map-Funktion
 $query1 = "SELECT DISTINCT NAME AS Name FROM Data WHERE Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)";
 $result1 = mysqli_query($connect, $query1);
 
 $result_array = Array();
 while($array1 = mysqli_fetch_assoc($result1)) {
    
    $result_array1[] = $array1["Name"];
 }

 $json_array = json_encode($result_array1);


 //Temperatur-Funktion
$temp_query = "SELECT AVG(Temperatur)/10 As Temperatur, YEAR(Messdatum) As Jahr, MONTH(Messdatum) As Monat, DAY(Messdatum) As Tag FROM Data GROUP BY YEAR(Messdatum) DESC, MONTH(Messdatum) DESC, DAY(Messdatum) DESC LIMIT 1";
$temp_result = mysqli_query($connect, $temp_query);
while($temp_row = mysqli_fetch_array($temp_result)) {
    $tempL .= "\"".$temp_row["Jahr"]."-".$temp_row["Monat"]."-".$temp_row["Tag"]."\", ";
    $tempD .= $temp_row["Temperatur"].", ";
}
$tempL = substr($tempL, 0, -2);
$tempD = substr($tempD, 0, -11);
?>

<!DOCTYPE html>
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
    <title>ELMO CLOUD | Raum 01-031N</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Bootstrap CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Custom ELMO CSS -->
    <link href="css/costumpi.css" rel="stylesheet">
    <!-- You can change the theme colorsfrom here -->
    <link href="css/colors/red-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Map Funktion -->
<script type="text/javascript">

function parseFunction() {
	var arrayObjects1 = <?php echo $json_array; ?>;

	if (arrayObjects1 != null) {
    for(i = 0; i < arrayObjects1.length; ++i) {

        colorFunction(arrayObjects1[i]);
        
    }

}

// Map Colorfunktion (Belegt!)
function colorFunction(value) {

    var id = "c" + value;
    document.getElementById(id).style.backgroundColor = "#ffa6a6";
    document.getElementById(id).style.borderColor = "#ff4d4f";
    document.getElementById(id).getElementsByClassName("map-body")[0].innerHTML += '<h5>Belegt!</h5>';
}}
</script>


</head>

<body class="fix-header fix-sidebar card-no-border" onload="parseFunction()">
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
                    <a class="navbar-brand" href="index.php">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
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
                            <a href="pages-lockscreen.php" class="btn waves-effect waves-light btn-primary"><i class="fa fa-lock m-r-10"></i>Adminbereich</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->

                <?php include ("nav.php"); ?>

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
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <div class="row page-titles">
                    <!-- Bread Crumb Funktion -->
                    <div class="col-lg-6 col-6 align-self-center">
                        <h3 class="text-themecolor">Raum 01-031N</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Raumübersicht</a></li>
                            <li class="breadcrumb-item active">Raum 01-031N</li>
                        </ol>
                    </div>
                    <!-- Temperatur Box -->
                    <div class="col-lg-6 col-6 align-self-center">
                        <div>
                            <div class="row  justify-content-end">
                                <div class="btn btn-rounded btn-danger"><?php echo $tempD;?> °C
                                </div>

                                <div class="m-l-10 m-r-2 align-self-center">
                                    <h5 class="m-b-0">Temperatur</h5>
                                    <h6 class="text-muted text-sm-left m-b-0">Aktuell</h6></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="card">
                  <div class="card-body map-responsive">
                    <!-- Maschinen Reihe 1 -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-card" id=c01>
                                <div class="map-body">
                                    <h6>Mauser Spezial</h6>
                                    <h5>2N-Doppelkettenstich Biesenmaschine</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-empty">
                                <div class="map-body">
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c02>
                                <div class="map-body">
                                    <h6> </h6>
                                    <h5>Bändchenschneider</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c03>
                                <div class="map-body">
                                    <h6>Pfaff</h6>
                                    <h5>2-Nadel-DSTM mit ausschaltbaren Nadelstangen</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <!-- Maschinen Abstand -->
                    <div class="map-row mx-auto">
                        <div class="map-abstand"></div>
                    </div>
                    <!-- Maschinen Reihe 2 -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-card" id=c04>
                                <div class="map-body">
                                    <h6>Pfaff</h6>
                                    <h5>Zick-Zack-Doppelsteppstich-Maschine</h5>
                                    <a href="../mpdf/031N/32.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c05>
                                <div class="map-body">
                                    <h6>Pfaff</h6>
                                    <h5>Doppelsteppstich-Maschine</h5>
                                    <a href="../mpdf/031N/31.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c06>
                                <div class="map-body">
                                    <h6>Pfaff</h6>
                                    <h5>Zick-Zack-Steppstich mit OBT - Maschine</h5>
                                    <a href="../mpdf/031N/30.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c07>
                                <div class="map-body">
                                    <h6>Pfaff</h6>
                                    <h5>Doppelsteppstich-Maschine mit Einfassbandvorrichtung</h5>
                                    <a href="../mpdf/031N/29.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <!-- Maschinen Reihe 3 -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-card" id=c08>
                                <div class="map-body">
                                    <h6>Juki</h6>
                                    <h5>Doppelsteppstich-Maschine</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c09>
                                <div class="map-body">
                                    <h6>Juki</h6>
                                    <h5>Doppelsteppstich-Maschine</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c10>
                                <div class="map-body">
                                    <h6>Juki</h6>
                                    <h5>Doppelsteppstich-Maschine</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c11>
                                <div class="map-body">
                                    <h6>Juki</h6>
                                    <h5>Doppelsteppstich-Maschine</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <!-- Maschinen Abstand -->
                    <div class="map-row mx-auto">
                        <div class="map-abstand"></div>
                    </div>
                    <!-- Maschinen Reihe 4 -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-card" id=c12>
                                <div class="map-body">
                                    <h6>Juki</h6>
                                    <h5>Doppelsteppstich-Maschine</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c13>
                                <div class="map-body">
                                    <h6>Dürkopf</h6>
                                    <h5>Doppelsteppstich-Maschine</h5>
                                    <a href="../mpdf/031N/23.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c14>
                                <div class="map-body">
                                    <h6>Dürkopf</h6>
                                    <h5>Doppelsteppstich-Maschine</h5>
                                    <a href="../mpdf/031N/22.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c15>
                                <div class="map-body">
                                    <h6>Dürkopf</h6>
                                    <h5>Doppelsteppstich-Maschine</h5>
                                    <a href="../mpdf/031N/21.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <!-- Maschinen Reihe 5 -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-card" id=c16>
                                <div class="map-body">
                                    <h6>Mauser</h6>
                                    <h5>2-Nadel-4Faden-Überwendlich-Maschine</h5>
                                    <a href="../mpdf/031N/17.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c17>
                                <div class="map-body">
                                    <h6>Rimoldi</h6>
                                    <h5>2-Nadel-4Faden-Überwendlich-Kettenstich-Maschine</h5>
                                    <a href="../mpdf/031N/18.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c18>
                                <div class="map-body">
                                    <h6>Union</h6>
                                    <h5>2-Nadel-4-Faden-Überwendlich-Maschine Nur Webware</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c19>
                                <div class="map-body">
                                    <h6>Mauser</h6>
                                    <h5>2-Nadel-4-Faden-Überwendlich-Nähmaschine</h5>
                                    <a href="../mpdf/031N/20.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <!-- Maschinen Abstand -->
                    <div class="map-row mx-auto">
                        <div class="map-abstand"></div>
                    </div>
                    <!-- Maschinen Reihe 6 -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-card" id=c20>
                                <div class="map-body">
                                    <h6>Union-Spezial</h6>
                                    <h5>Doppelkettenstich-Maschine zum Einfassen</h5>
                                    <a href="../mpdf/031N/16.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c21>
                                <div class="map-body">
                                    <h6>Union-Spezial</h6>
                                    <h5>Crochetta-Maschine</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c22>
                                <div class="map-body">
                                    <h6>Union-Spezial</h6>
                                    <h5>2-Nadel-Überdeck-Saum-Maschine</h5>
                                    <a href="../mpdf/031N/14.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c23>
                                <div class="map-body">
                                    <h6>Union-Spezial</h6>
                                    <h5>3-Nadel-Überdeck-Maschine mit E.z. Säumen, Überlappen, Nähte überdecken</h5>
                                    <a href="../mpdf/031N/14.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                     <!-- Maschinen Reihe 7 -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-card" id=c24>
                                <div class="map-body">
                                    <h6>Pfaff-Pegasus</h6>
                                    <h5>Safty-Maschine</h5>
<!--                                    <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c25>
                                <div class="map-body">
                                    <h6>Pfaff-Pegasus</h6>
                                    <h5>3-Nadel-Überdeck (Ballkasten) mit Bandvorrichtung</h5>
                                    <a href="../mpdf/031N/10.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c26>
                                <div class="map-body">
                                    <h6>Rimoldi</h6>
                                    <h5>2-Nadel-4Faden-Überwendlich-Maschine mit Hubmagnet</h5>
                                    <a href="../mpdf/031N/11.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-card" id=c27>
                                <div class="map-body">
                                    <h6>Pfaff</h6>
                                    <h5>Doppelkettenstich-Maschine</h5>
                                    <a href="../mpdf/031N/12.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>

                        <!-- Maschinen Abstand -->
                        <div class="map-row mx-auto">
                            <div class="map-abstand"></div>
                        </div>    <!-- Maschinen Reihe 8 -->
                        <div class="map-row mx-auto">
                            <div class="map-col">
                                <div class="map-card" id=c28>
                                    <div class="map-body">
                                        <h6>Union-Special</h6>
                                        <h5>1-Nadel-3-Faden-Überwendlich-Maschine</h5>
                                        <a href="../mpdf/031N/08.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                            <div class="map-col">
                                <div class="map-card" id=c29>
                                    <div class="map-body">
                                        <h6>Mauser</h6>
                                        <h5>Doppelsteppstich-Maschine</h5>
                                        <a href="../mpdf/031N/07.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                            <div class="map-col">
                                <div class="map-card" id=c30>
                                    <div class="map-body">
                                        <h6>Mauser</h6>
                                        <h5>Doppelsteppstich-Maschine</h5>
                                        <a href="../mpdf/031N/06.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                            <div class="map-col">
                                <div class="map-card" id=c31>
                                    <div class="map-body">
                                        <h6>Mauser</h6>
                                        <h5>Doppelkettenstich-Maschine</h5>
                                        <a href="../mpdf/031N/05.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                    </div>
                    </div>
                    <!-- Maschinen Reihe 8 -->
                    <div class="map-row mx-auto">
                            <div class="map-col">
                                <div class="map-card" id=c32>
                                    <div class="map-body">
                                        <h6>Meier</h6>
                                        <h5>Unitas-Hohlsaum Blindstich</h5>
<!--                                        <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                            <div class="map-col">
                                <div class="map-card" id=c33>
                                    <div class="map-body">
                                        <h6>Union-Spezial</h6>
                                        <h5>1-Nadel-3-Faden-Überwendlich-Maschine für Rollsaum</h5>
<!--                                        <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                            <div class="map-col">
                                <div class="map-card" id=c34>
                                    <div class="map-body">
                                        <h6>Meier</h6>
                                        <h5>1-Faden-Blindstich-Maschine mit Fadenabschneider</h5>
<!--                                        <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                            <div class="map-col">
                                <div class="map-card" id=c35>
                                    <div class="map-body">
                                        <h6>Strobel</h6>
                                        <h5>Einfachkettenstich-Rollsaum-Maschine</h5>
<!--                                        <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                            <!-- Maschinen Abstand -->
                            <div class="map-row mx-auto">
                                <div class="map-abstand"></div>
                            </div>
                    <!-- Unterdämpftisch Reihe -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-card">
                                <div class="map-body">
                                    <h5>Unterdämpftisch für Maschenware</h5>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-empty">
                                <div class="map-body">
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-empty">
                                <div class="map-body">
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-empty">
                                <div class="map-body">
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                        </div>
                    <!-- Eingangdarstellung -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-empty">
                                <div class="map-body">
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-empty">
                                <div class="map-body">
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-empty">
                                <div class="map-body">
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="map-col">
                            <div class="map-empty">
                                <div class="map-body">
                                    <img src="../assets/images/eingang.png">
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
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
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
</body>

</html>