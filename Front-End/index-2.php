<!-- ############################################################## -->
<!-- ############################################################## -->
<!--
Template Name: ELMO Cloud - MAP - Raum 01-031M
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
    <title>ELMO CLOUD | Raum 01-031M</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Bootstrap CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Custom ELMO CSS -->
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
                    <!-- Maschine 1.1-->
                    <div class="map-col">
                        <div class="map-empty">
                            <div class="map-body">
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 1.2-->
                    <div class="map-col">
                        <div class="map-card" id="c36">
                            <div class="map-body">
                                <h6>Juki</h6>
                                <h5>2-Nadel-Überwendlich-Maschine für grobe Maschenware</h5>
                                <a href="../mpdf/031M/07.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 1.3-->
                    <div class="map-col">
                        <div class="map-card" id="c37">
                            <div class="map-body">
                                <h6>Arbeitsplatz Maria</h6>
                                <h5>Doppelsteppstich-Maschine</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 1.4-->
                    <div class="map-col">
                        <div class="map-card-desk">
                            <div class="map-body">
                                <h5>Arbeitsplatz Maria</h5>
                            </div>
                        </div>
                    </div>
                    
                </div>
                    <!-- Maschinen Reihe 2 -->
                <div class="map-row mx-auto">
                    <!-- Maschine 2.1-->
                    <div class="map-col">
                        <div class="map-card" id="38">
                            <div class="map-body">
                                <h6>KMF</h6>
                                <h5>Doppel-Kettenstich<h5>
<!--                                        <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 2.2-->
                    <div class="map-col">
                        <div class="map-empty">
                            <div class="map-body">
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 2.3-->
                    <div class="map-col">
                        <div class="map-card-desk">
                            <div class="map-body">
                                <h5>Ablagetisch</h5>
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 2.4-->
                    <div class="map-col">
                        <div class="map-card" id="c39">
                            <div class="map-body">
                                <h6>Augenknopfloch</h6>
                                <h5>Knopflochautomat</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
            
                </div>
                    <!-- Maschinen Reihe 3 -->
                <div class="map-row mx-auto">
                    <!-- Maschine 3.1-->
                    <div class="map-col">
                        <div class="map-card" id="c40">
                            <div class="map-body">
                                <h6>KMF</h6>
                                <h5>Regulär-Rundkettel-Maschine; Feinheit 7</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 3.2-->
                    <div class="map-col">
                        <div class="map-empty">
                            <div class="map-body">
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 3.3-->
                    <div class="map-col">
                        <div class="map-card-desk">
                            <div class="map-body">
                                <h5>Ablagetisch</h5>
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 3.4-->
                    <div class="map-col">
                        <div class="map-card" id="c41">
                            <div class="map-body">
                                <h6>Wäscheknopfloch</h6>
                                <h5>Knopflochautomat</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- Maschinen Reihe 4 -->
                <div class="map-row mx-auto">
                    <!-- Maschine 4.1-->
                    <div class="map-col">
                        <div class="map-card" id="c42">
                            <div class="map-body">
                                <h6>KMF</h6>
                                <h5>Kettelmaschine; Feinheit 7</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 4.2-->
                    <div class="map-col">
                        <div class="map-empty">
                            <div class="map-body">
                            </div>
                        </div>

                    </div>
                    <!-- Maschine 4.3-->
                    <div class="map-col">
                        <div class="map-card-desk">
                            <div class="map-body">
                                <h5>Ablagetisch</h5>
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 4.4-->
                    <div class="map-col">
                        <div class="map-card" id="c43">
                            <div class="map-body">
                                <h6>Paff</h6>
                                <h5>Doppelsteppstich-Maschine Freiarm für Jeans und Leder</h5>
                                <a href="../mpdf/031M/02.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- Maschinen Reihe 5 -->
                <div class="map-row mx-auto">
                    <!-- Maschine 5.1-->
                    <div class="map-col">
                        <div class="map-card" id="c44">
                            <div class="map-body">
                                <h6>Rimoldi</h6>
                                <h5>Nähkettelmaschine 4-Nadel-Maschine; Feinheit 12</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 5.2-->
                    <div class="map-col">
                        <div class="map-empty">
                            <div class="map-body">
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 5.3-->
                    <div class="map-col">
                        <div class="map-card-desk">
                            <div class="map-body">
                                <h5>Ablagetisch</h5>
                            </div>
                        </div>
                    </div>
                    <!-- Maschine 5.4-->
                    <div class="map-col">
                        <div class="map-card" id="c45">
                            <div class="map-body">
                                <h6>Paff</h6>
                                <h5>Doppelsteppstich-Maschine mit Rollfuß für Jeans und Leder</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                    <!-- Maschinen Reihe 6 -->
                <div class="map-row mx-auto">
                    <!-- Maschine 6.1-->
                    <div class="map-col">
                        <div class="map-empty">
                            <div class="map-body">
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <!-- Maschine 6.2-->
                    <div class="map-col">
                        <div class="map-empty">
                            <div class="map-body">
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <!-- Maschine 6.3-->
                    <div class="map-col">
                        <div class="map-card" id="c46">
                            <div class="map-body">
                                <h5>Doppelsteppstich-Maschine für Jeans und Leder</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <!-- Maschine 6.4-->
                    <div class="map-col">
                        <div class="map-card" id="c47">
                            <div class="map-body">
                                <h6>Dürkopf</h6>
                                <h5>Doppelsteppstich-Maschine mit höhenverstellbarem OBT für Jeans und Leder</h5>
                                <a href="../mpdf/031M/01.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                    <!-- Maschinen Reihe 7 -->
                <div class="map-row mx-auto">
                    <!-- Maschine 7.1-->
                    <div class="map-col">
                        <div class="map-empty">
                            <div class="map-body">
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <!-- Maschine 7.2-->
                    <div class="map-col">
                        <div class="map-empty">
                            <div class="map-body">
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <!-- Maschine 7.3-->
                    <div class="map-col">
                        <div class="map-card" id="c48">
                            <div class="map-body">
                                <h6>Pfaff-Mauselock</h6>
                                <h5>4-Nadel-Überdeck</h5>
<!--                                <a href="#" class="btn waves-effect waves-light btn-xs btn-secondary">keine Details verfügbar</a>-->
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <!-- Maschine 7.4-->
                    <div class="map-col">
                        <div class="map-card" id="c49">
                            <div class="map-body">
                                <h6>Dürkopf</h6>
                                <h5>Doppelsteppstich-Maschine mit höhenverstellbarem OBT für Jeans und Leder</h5>
                                <a href="../mpdf/031M/01.pdf" target="_blank" class="btn waves-effect waves-light btn-xs btn-secondary">Details</a>
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
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
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