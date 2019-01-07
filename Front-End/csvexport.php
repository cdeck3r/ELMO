<!DOCTYPE html>
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
$csv  = "csv/Data_Von_".$von."_Bis_".$bis."_Generiert_" .date('d-m-Y-his') . '.csv';
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
    <title>ELMO CLOUD | CSV Export</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Dark CSS -->
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
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">Adminbereich</li>
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Übersicht</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="admindashboard.php">Admin Dashboard</a></li>
                            <li><a href="cleantable.php">Clean Tabelle</a></li>
                            <li><a href="csvexport.php">CSV Export</a></li>
                            <li><a href="maschinen.php">Alle Maschinen</a></li>
                        </ul>
                    </li>

                </ul>
            </nav>
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
                    <h3 class="text-themecolor">CSV Export</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Adminpanel</a></li>
                        <li class="breadcrumb-item active">CSV Export</li>
                    </ol>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
			            <form action="csvexport.php" method="post">
                          <!-- VON -->
                            <div class="form-group">
                    <label for="vonn">Von</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="ti-calendar"></i>
                                                </span>
                        </div>
                        <input type="date" class="form-control" name="von" id="vonn">
                    </div>
                </div>
                            <!-- BIS -->
                            <div class="form-group">
                    <label for="biss">bis</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="ti-calendar"></i>
                                                </span>
                        </div>
                        <input type="date" class="form-control" name="bis" id="biss">
                    </div>
                </div>

                <button type="submit" class="btn waves-effect waves-light btn btn-primary m-t-10 m-r-10">Generieren</button>
                <button type="reset" class="btn waves-effect waves-light btn btn-inverse m-t-10">Reset</button>
			</form>
			<br>
		<?php 
			if(isset($_POST['von'])) {
             echo "<button class=\"btn waves-effect waves-light btn-lg btn-danger\" type=\"submit\" onclick=\"window.location.href='" .$csv."'\">Download CSV</button>";
			}
		?>
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
