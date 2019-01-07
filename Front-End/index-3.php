<!-- ############################################################## -->
<!-- ############################################################## -->
<!--
Template Name: ELMO Cloud - MAP - Raum 01-031L
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

    $result_array[] = $array1["Name"];
}

$json_array = json_encode($result_array);


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
    <title>ELMO CLOUD | Raum 01-031L</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/costumpi.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/red-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <script type="text/javascript">
        <!-- Map Funktion -->
        function parseFunction() {
            var arrayObjects = <?php echo $json_array; ?>;
            for(i = 0; i < arrayObjects.length; ++i) {

                colorFunction(arrayObjects[i]);

            }
        }

        // Map Colorfunktion (Belegt!)
        function colorFunction(value) {

            var id = "c" + value;
            document.getElementById(id).style.backgroundColor = "#ffa6a6";
            document.getElementById(id).style.borderColor = "#ff4d4f";
            document.getElementById(id).getElementsByClassName("map-body")[0].innerHTML += '<h5>Belegt!</h5>';
        }
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
                    <div class="col-md-4 col-6 align-self-center">
                        <h3 class="text-themecolor">Raum 01-31L</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Raumübersicht</a></li>
                            <li class="breadcrumb-item active">Raum 01-31L</li>
                        </ol>
                    </div>
                    <div class="col-md-8 col-6 align-self-center">
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
                    <!-- Ultraschall Reihe -->
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
                            <div class="map-card">
                                <div class="map-body">
                                    <h5>Ultraschall-Schweiss-Maschine</h5>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <!-- Maschinen Abstand -->
                    <div class="map-row mx-auto">
                        <div class="map-abstand"></div>
                    </div>
                    <!-- Maschinen Reihe 1 -->
                <div class="map-row mx-auto">
                    <div class="map-col">
                        <div class="map-card" id=c50>
                            <div class="map-body">
                                <h6>Mauser Spezial</h6>
                                <h5>2-Nadel-4-Faden-Überwendlich-Maschine</h5>
                                <a href="../mpdf/031L/28.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c51>
                            <div class="map-body">
                                <h6>Dürkopf</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/27.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c52>
                            <div class="map-body">
                                <h6>Dürkopf</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/26.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c53>
                            <div class="map-body">
                                <h6>Mauser</h6>
                                <h5>3-Nadel-4Faden-Überdeck-Kettenstich-Nähmaschine mit Gummizufuhr</h5>
                                <a href="../mpdf/031L/25.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                    <!-- Maschinen Reihe 2 -->
                <div class="map-row mx-auto">
                    <div class="map-col">
                        <div class="map-card" id=c54>
                            <div class="map-body">
                                <h6>Singer</h6>
                                <h5>2-Nadel-4Faden-Überwendlich-Maschine</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c55>
                            <div class="map-body">
                                <h6>Dürkopf</h6>
                                <h5>Doppelsteppstich-Maschine mit Rüscheneinrichtung</h5>
                                <a href="../mpdf/031L/23.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c56>
                            <div class="map-body">
                                <h6>Dürkopf</h6>
                                <h5>Doppelsteppstich-Maschine 6-Stich-Zick-Zack</h5>
                                <a href="../mpdf/031L/22.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c57>
                            <div class="map-body">
                                <h6>Pfaff</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/21.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                    <!-- Maschinen Abstand -->
                    <div class="map-row mx-auto">
                    <div class="map-abstand"></div>
                    </div>
                    <!-- Maschinen Reihe 3 -->
                <div class="map-row mx-auto">
                    <div class="map-col">
                        <div class="map-card" id=c58>
                            <div class="map-body">
                                <h6>Pfaff</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/17.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c59>
                            <div class="map-body">
                                <h6>Pfaff</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/18.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c60>
                            <div class="map-body">
                                <h6>Pfaff</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/19.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c61>
                            <div class="map-body">
                                <h6>Pfaff/Mauser</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/20.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                    <!-- Maschinen Reihe 4 -->
                <div class="map-row mx-auto">
                    <div class="map-col">
                        <div class="map-card" id=c62>
                            <div class="map-body">
                                <h6>Pfaff</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/16.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c63>
                            <div class="map-body">
                                <h6>Pfaff</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c64>
                            <div class="map-body">
                                <h6>Pfaff/Mauser</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/14.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c65>
                            <div class="map-body">
                                <h6>Pfaff/Mauser</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
                                <a href="../mpdf/031L/13.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                    <!-- Maschinen Abstand -->
                    <div class="map-row mx-auto">
                        <div class="map-abstand"></div>
                    </div>
                    <!-- Maschinen Reihe 5 -->
                <div class="map-row mx-auto">
                    <div class="map-col">
                        <div class="map-card" id=c66>
                            <div class="map-body">
                                <h6>Rimoldi</h6>
                                <h5>2-Nadel-4Faden-Überwendlich-Maschine</h5>
                                <a href="../mpdf/031L/09.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c67>
                            <div class="map-body">
                                <h6>Rimoldi</h6>
                                <h5>1-Nadel-3Faden-Überwendlich-Maschine</h5>
                                <a href="../mpdf/031L/10.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c68>
                            <div class="map-body">
                                <h6>Juki</h6>
                                <h5>1-Nadel3-Raden-Überwendlich-Maschine</h5>
                                <h6 class="m-b-2">mit Gummibandliefereinrichtung</h6>
                                <a href="../mpdf/031L/11.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c69>
                            <div class="map-body">
                                <h6>Juki</h6>
                                <h5>1-Nadel3-Raden-Überwendlich-Maschine</h5>
                                <h6>mit Gummibandliefereinrichtung</h6>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                    <!-- Maschinen Reihe 6 -->
                <div class="map-row mx-auto">
                    <div class="map-col">
                        <div class="map-card" id=c70>
                            <div class="map-body">
                                <h6>Rimoldi</h6>
                                <h5>1-Nadel-3Faden-Überwendlich-Maschine</h5>
                                <a href="../mpdf/031L/08.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c71>
                            <div class="map-body">
                                <h6>Pfaff/Mauser</h6>
                                <h5>2-Nadel-Überdeck-Kettenstich-Maschine mit Legefaden für elastische Spitze</h5>
                                <a href="../mpdf/031L/07.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c72>
                            <div class="map-body">
                                <h6>Rimoldi</h6>
                                <h5>3-Nadel-Überdeck-Kettenstich-Maschine</h5>
                                <a href="../mpdf/031L/06.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c73>
                            <div class="map-body">
                                <h6>???</h6>
                                <h5>3-Nadel-5Faden-Überwendlich-Maschine mit Legefaden</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                    <!-- Maschinen Abstand -->
                    <div class="map-row mx-auto">
                        <div class="map-abstand"></div>
                    </div>
                    <!-- Maschinen Reihe 7 -->
                <div class="map-row mx-auto">
                    <div class="map-col">
                        <div class="map-card" id=c74>
                            <div class="map-body">
                                <h6>Pegasus</h6>
                                <h5>2-Nadel-Überdeck-Kettenstich-Maschine mit Einfassvorrichtung</h5>
                                <a href="../mpdf/031L/04.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c75>
                            <div class="map-body">
                                <h6>Pegasus</h6>
                                <h5>2-Nadel-Überdeck-Kettenstich-Maschine</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">kiene Details verfügbar</a>-->
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c76>
                            <div class="map-body">
                                <h6>Union</h6>
                                <h5>2-Nadel-Überdeck-Kettenstich-Maschine</h5>
                                <a href="../mpdf/031L/02.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="map-col">
                        <div class="map-card" id=c77>
                            <div class="map-body">
                                <h6>Rimoldi</h6>
                                <h5>1-Nadel-Doppelkettenstrich-Maschine mit Einfassband</h5>
                                <a href="../mpdf/031L/01.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                    <!-- Eingangdarstellung -->
                    <div class="map-row mx-auto">
                        <div class="map-col">
                            <div class="map-empty">
                                <div class="map-body">
                                    <img src="../assets/images/eingang.png" alt="eingang">
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
            <footer class="footer"> © 2019 Elmo Cloud | <a href="impressum.php">Impressum</a></footer>
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