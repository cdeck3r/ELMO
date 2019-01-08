<!-- ############################################################## -->
<!-- ############################################################## -->
<!--
Template Name: ELMO Cloud - Ansprechpartner
Author: Patrick Ardelean, Timo Hegenberg, Justus Mattedi
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

//availableCheck-Funktion
$query1 = "SELECT DISTINCT NAME AS Name FROM Data WHERE NAME LIKE 60 AND Watt>5000 AND Messdatum > DATE_SUB(NOW(), INTERVAL 10 MINUTE)";
$result1 = mysqli_query($connect, $query1);
$row1 = mysqli_fetch_array($result1);
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
    <title>ELMO CLOUD | Ansprechpartner</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/red-dark.css" id="theme" rel="stylesheet">
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
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Ansprechpartner</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Ansprechpartner</a></li>
                            <li class="breadcrumb-item active">Übersicht</li>
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                    <!-- Person 1 -->
                    <div class="col-lg-3">
                        <div class="card">
                        <div class="card-body">
                            <div class="text-center m-t-30"> <img src="../main/ansprechpartnerbilder/Frau Rose.jpg" alt="img" class="img-rounded" width="120">
                                <h4 class="card-title m-t-10">PROF. DR.-ING. KATERINA ROSE</h4>
                                <h6 class="card-subtitle">Leiterin Nähwerkstatt</h6>
                                <div class="row text-center justify-content-center">
                                    <div><a href="tel:+4971212718082" class="btn btn-outline-danger waves-effect waves-light"><span class="btn-label"><i class="fa fa-phone"></i></span>+49 7121 271 8082</a></div>
                                </div>
                                <div class="row text-center justify-content-center m-t-10">
                                    <div><a href="mailto:Katerina.Rose@reutlingen-university.de" class="btn btn-outline-warning waves-effect waves-light"><span class="btn-label"><i class="fa fa-envelope"></i></span>Mail</a></div>
                                </div>
                                <div class="row text-center justify-content-center m-t-10">

                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                            <!-- Person 2 -->
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center m-t-30"> <img src="../main/ansprechpartnerbilder/Frau Schwille.jpg" alt="img" class="img-rounded" width="120">
                                            <h4 class="card-title m-t-10">INGRID SCHWILLE</h4>
                                            <h6 class="card-subtitle">Wiss.Arbeiterin</h6>
                                            <div class="row text-center justify-content-center">
                                                <div><a href="tel:+4971212718051" class="btn btn-outline-danger waves-effect waves-light"><span class="btn-label"><i class="fa fa-phone"></i></span>+49 7121 271 8051</a></div>
                                            </div>
                                            <div class="row text-center justify-content-center m-t-10">
                                                <div><a href="mailto:Ingrid.Schwille@reutlingen-university.de" class="btn btn-outline-warning waves-effect waves-light"><span class="btn-label"><i class="fa fa-envelope"></i></span>Mail</a></div>
                                            </div>
                                            <div class="row text-center justify-content-center m-t-10">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Person 3 -->
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center m-t-30"> <img src="../assets/images/users/5.jpg" alt="img" class="img-rounded" width="120">
                                            <h4 class="card-title m-t-10">Vorname Nachname 1</h4>
                                            <h6 class="card-subtitle">Hausmeister</h6>
                                            <div class="row text-center justify-content-center">
                                                <div><a href="tel:#" class="btn btn-outline-danger waves-effect waves-light"><span class="btn-label"><i class="fa fa-phone"></i></span>Tel.</a></div>
                                            </div>
                                            <div class="row text-center justify-content-center m-t-10">
                                                <div><a href="mailto:m.mustermann@domain.de" class="btn btn-outline-warning waves-effect waves-light"><span class="btn-label"><i class="fa fa-envelope"></i></span>Mail</a></div>
                                            </div>
                                            <div class="row text-center justify-content-center m-t-10">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Person 4 -->
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center m-t-30" id="c99"> <img src="../main/ansprechpartnerbilder/Tutorin.jpg" alt="img" class="img-rounded" width="120">
                                            <h4 class="card-title m-t-10">JELENA KIEFER</h4>
                                            <h6 class="card-subtitle">Tutorin</h6>
                                            <div class="row text-center justify-content-center">
                                                <div><a href="tel:+4971212718051" class="btn btn-outline-danger waves-effect waves-light"><span class="btn-label"><i class="fa fa-phone" ></i></span>+49 7121 271 8051</a></div>
                                            </div>
                                            <div class="row text-center justify-content-center m-t-10">
                                                <div><a href="mailto:Jelena.Kiefer@reutlingen-university.de" class="btn btn-outline-warning waves-effect waves-light"><span class="btn-label"><i class="fa fa-envelope"></i></span>Mail</a></div>
                                            </div>
                                            <?php
                                            if (!is_null($row1)){
                                            echo "<div class=\"row text-center justify-content-md-center m-t-10\"><div><h5 class=\"btn btn-success\"><span class=\"btn-label\"><i class=\"fa fa-check\"></i></span>Verfügbar</h5></div>";
                                            }
                                            else {
                                            echo "<div class=\"btn btn-outline-secondary waves-effect waves-light m-t-10\"><span class=\"btn-label\"><i class=\"fa fa-times\"></i></span>Nicht Verfügbar</div>";
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
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



</body>

</html>
