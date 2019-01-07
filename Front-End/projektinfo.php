<!-- ############################################################## -->
<!-- ############################################################## -->
<!--
Template Name: ELMO Cloud - Projektinfo
Author: Prof. Dr. Christian Decker, Patrick Ardelean
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
    <title>ELMO CLOUD | Die Geschichte</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Bootstrap CSS -->
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
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Projektinformationen</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Projekt ELMO</a></li>
                            <li class="breadcrumb-item active">Projektinformationen</li>
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

                    <!-- Geschichte Box -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <p><span class="font-weight-bold">E</span>lectricity profi<span class="font-weight-bold">L</span>e <span class="font-weight-bold">MO</span>nitoring (ELMO) ist Energiemonitoring mit Commercially-Off-The-Shelf (COTS) Hardware. Erfassungssysteme werden in einem f&uuml;r die Lehre genutzten N&auml;hmaschinen-Maschinenpark &uuml;ber mehrere R&auml;ume an der Fakult&auml;t Textil &amp; Design (TD) der Hochschule Reutlingen (<a href="https://www.reutlingen-university.de/" data-saferedirecturl="https://www.google.com/url?q=https://www.reutlingen-university.de&amp;source=gmail&amp;ust=1546713973649000&amp;usg=AFQjCNE6qYYAHbfcm-SSshpX6B5ZFWUxjg">https://www.reutlingen-university.de</a>) ausgebracht. Es folgt ein l&auml;ngerer unbeaufsichtigter Betrieb der Datenerfassung. Eine Datenauswertung macht verschiedene Betriebsbedingungen sichtbar.</p>
                                <h3>Ziele</h3>
                                <p>Reale Energieverbrauchsdaten f&uuml;r Forschung und Lehre an der Hochschule zur Verf&uuml;gung stellen. Bisher manuell erfasste Betriebsbedingungen, u.a f&uuml;r Wartung und Auslastung, im Anwendungskontext automatisiert erfassen k&ouml;nnen.</p>
                                <h3>Nutzen</h3>
                                <p>Mit ELMO steht ein 24/7 Energieerfassungssystem in einer realen Umgebung an der Hochschule zu Verf&uuml;gung. Es verbessert die Koordination von Lehraktivit&auml;ten an den Maschinen und f&uuml;hrt zu einer besseren Lernerfahrung f&uuml;r Studierende. Es unterst&uuml;tzt&nbsp; die Planung und den Einsatz von finanziellen Investitionen bei Wartung und Anschaffung. Dar&uuml;ber hinaus dient ELMO als kontinuierliche Datenquelle f&uuml;r aktuelle Forschungen im Bereich der Digitalisierung von Energiem&auml;rkten.</p>
                                <p>Ein besonderes Merkmal ist, dass Systembau, Anwendung und Forschung durch verschiedene Vertreter aus drei Fakult&auml;ten der Hochschule abgedeckt werden. ELMO ist ein interfakultatives Projekt mit den folgenden Kooperationspartnern</p>
                                <ul>
                                    <li>Fakult&auml;t Informatik (INF); <a href="https://www.inf.reutlingen-university.de/ueber-uns/alle-ansprechpartner/#christian-decker">Prof. Dr. Christian Decker</a> (Principal Investigator)</li>
                                    <li>Fakult&auml;t Textil &amp; Design (TD); <a href="https://www.td.reutlingen-university.de/fakultaet/ansprechpartner/lehre/#Katerina-Rose">Prof. Dr. Katerina Rose</a></li>
                                    <li>Fakult&auml;t Technik (TEC); <a href="https://www.tec.reutlingen-university.de/de/fakultaet/personen/professoren/#debora-coll-mayor">Prof. Dr. Debora Coll-Mayor</a>, <a href="https://www.tec.reutlingen-university.de/de/fakultaet/personen/professoren/#antonio-notholt">Prof. Dr. Antonio Notholt</a></li>
                                </ul>
                                <p>&nbsp;</p>
                                <h3>Herausragende Merkmale: Lehre, Forschung und Anwendung sind eng verzahnt</h3>
                                <ul>
                                    <li>Lehre: Studierende der Fakult&auml;t INF wenden ihr Wissen aus verschiedenen Modulen der Wirtschaftsinformatik in einem konkreten Anwendungsprojekt an. Sie arbeiten im Team mit modernen agilen Projektmethoden. Komplette Projektdokumentation und Code stehen &ouml;ffentlich als Open-Source zur Verf&uuml;gung.</li>
                                    <li>Anwendung: Prof. Rose (Fakult&auml;t TD) m&ouml;chte die Ressourcenauslastung verbessern. Studierende sollen bessere Lernbedingungen nutzen k&ouml;nnen. Die Wartung des Maschinenparks soll zielgerichtet unterst&uuml;tzt werden. Eine Nutzungsanalyse soll Investitionen in Maschinen besser quantifizieren.</li>
                                    <li>Forschung: Prof. Coll-Mayor und Prof. Noholt (Fakulkt&auml;t TEC) untersuchen wie Energienutzung und -verteilung durch neue datenbasierte Methoden gesteuert werden k&ouml;nnen. ELMO als Datenquelle eines realen Anwendungsumfeldes erweitert bisherige Energieverbrauchssimulationen und erlaubt neuartige wiss. Untersuchungen und Beitr&auml;ge zu leisten.</li>
                                </ul>
                                <p>&nbsp;</p>
                                <h3>Bezug zur Hochschule Reutlingen (HSRT)</h3>
                                <ul>
                                    <li>Der HSRT Campus bietet ein einzigartiges Umfeld, ein solches Projekt innhalb eines Semesters umzusetzen. Der Campus kombiniert die Schl&uuml;sselpartner der Kooperation.</li>
                                    <li>Au&szlig;enwirkung ist durch &ouml;ffentliche Dokumentation wie auch die vielf&auml;ltige Nutzung von ELMO in Forschung, Lehre und Ressourcenverwaltung sichtbar.</li>
                                    <li>Finanzierung: Mittel des Lehrpreises 2017 der HSRT von Prof. Dr. Decker werden eingesetzt, um Vorhaben mit extrem geringer Vorlaufzeit und hoch flexibel zu finanzieren.</li>
                                </ul>
                                <p>&nbsp;</p>
                                <h3>Links</h3>
                                <a href="https://github.com/cdeck3r/ELMO"> <img src="../assets/images/GitHub-Logo.png" alt="github" /></a>


                            </div>
                        </div>
                        <!-- Column -->
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