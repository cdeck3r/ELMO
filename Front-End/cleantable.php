<!-- ############################################################## -->
<!-- ############################################################## -->
<!--
Template Name: ELMO Cloud - Clean Table
Author: Patrick Ardelean, Timo Hegenberg
Email: elmo.project18@gmail.com
File: php
-->
<!-- ############################################################## -->
<!-- ############################################################## -->


<!DOCTYPE html>
<?php
//Login-Session
session_start();
if(!isset($_SESSION['userid'])) {
    header('Location: pages-lockscreen.php');
}

//Verbindung
require("config.php");
$connect = new mysqli($Host, $User, $Pass, $DB, $Port);

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
	FROM Data 
	INNER JOIN Maschinen ON Maschinen.divID = Data.Name
	GROUP BY AIN, YEAR(Messdatum), MONTH(Messdatum), DAY(Messdatum), HOUR(Messdatum), 
         	 MINUTE(Messdatum)
    HAVING MIN(Watt) > 5000 AND MIN(Messdatum) > LastClean
) As Daten
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
    <title>ELMO CLOUD | Clean Tabelle</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Bootstrap CSS -->
    <link href="./dark/css/style.css" rel="stylesheet">
    <!-- Custom Elmo CSS -->
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
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 col-8 align-self-center">
                    <h3 class="text-themecolor">Clean Tabelle</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Adminpanel</a></li>
                        <li class="breadcrumb-item active">Clean Tabelle</li>
                    </ol>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- Row -->
            <div class="row">
                <!-- Clean Tabelle -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Clean Tabelle</h4>
                            <div class="table-responsive table-striped">
                                <table class="table color-table inverse-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Maschinenname</th>
                                        <th>Anzahl Betriebsstunden seit Wartung</th>
										<th>Intervall</th>
										<th>Letzte Wartung</th>
                                        <th>Aktion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			
			<!-- Row -->
            <div class="row">
                <!-- Reinigungen Tabelle -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Reinigungen Log</h4>
                            <div class="table-responsive table-striped">
                                <table class="table color-table inverse-table">
                                    <thead>
                                    <tr>
										<th>#</th>
                                        <th>Maschinenname</th>
                                        <th>Anzahl Betriebsstunden vor Reinigung</th>
										<th>Intervall</th>
										<th>Reinigungsdatum</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
                                    </tbody>
                                </table>
                            </div>
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


<!-- ============================================================== -->
<!-- ELMO Costum Script -->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!-- ELMO Costum Script  ENDE-->
<!-- ============================================================== -->
</body>

</html>
