<?php
include "config/library.php";
include "config/koneksi.php";
opendb();
$usernama = antiinjec(@$_SESSION['sesNamaPengguna']);
$usertipe = antiinjec(@$_SESSION['sesTipePengguna']);
if ($usernama == "") {
    header("location:login.php");
}
$h = antiinjec(@$_GET['h']);

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Sistem Pengambilan Keputusan Drop Point Terbaik</title>
        <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
          <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Gradient Able Bootstrap admin template made using Bootstrap 4. The starter version of Gradient Able is completely free for personal project." />
        <meta name="keywords" content="free dashboard template, free admin, free bootstrap template, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
        <meta name="author" content="codedthemes">
        <!-- Favicon icon -->
        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
        <!-- themify-icons line icon -->
        <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
        <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
        <!-- ico font -->
        <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">
    </head>
    <body>
        <!--        <div class="fixed-button">
                    <a href="https://codedthemes.com/item/gradient-able-admin-template" target="_blank" class="btn btn-md btn-primary">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Upgrade To Pro
                    </a>
                </div>-->
        <!-- Pre-loader start -->
        <!--        <div class="theme-loader">
                    <div class="loader-track">
                        <div class="loader-bar"></div>
                    </div>
                </div>-->
        <!-- Pre-loader end -->
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">

                <nav class="navbar header-navbar pcoded-header">
                    <div class="navbar-wrapper">
                        <div class="navbar-logo">
                            <a class="mobile-menu" id="mobile-collapse" href="#!">
                                <i class="ti-menu"></i>
                            </a>
                            <!--                            <div class="mobile-search">
                                                            <div class="header-search">
                                                                <div class="main-search morphsearch-search">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                                                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>-->
                            <!--                            <a href="index.html">
                                                            <img class="img-fluid" src="assets/images/logo.png" alt="Theme-Logo" />
                                                        </a>-->
                            <a class="mobile-options">
                                <i class="ti-more"></i>
                            </a>
                        </div>

                        <div class="navbar-container container-fluid">
                            <ul class="nav-left">
                                <li>
                                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                                </li>
                                <!--                                <li class="header-search">
                                                                    <div class="main-search morphsearch-search">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                                                            <input type="text" class="form-control">
                                                                            <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </li>-->
                                <li>
                                    <a href="#!" onclick="javascript:toggleFullScreen()">
                                        <i class="ti-fullscreen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav-right">

                                <li class="user-profile header-notification">
                                    <a href="#!">
                                        <!-- <img src="assets/images/avatar-4.jpg" class="img-radius" alt="User-Profile-Image"> -->
                                        <span><?php echo $_SESSION['sesNamaPengguna'] ?></span>
                                        <i class="ti-angle-down"></i>
                                    </a>
                                    <ul class="show-notification profile-notification">
                                        <li>
                                            <a href="?h=password">
                                                <i class="ti-user"></i><span>Ubah Password</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="logout.php">
                                                <i class="ti-layout-sidebar-left"></i> <span>Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">
                        <nav class="pcoded-navbar">
                            <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                            <div class="pcoded-inner-navbar main-menu">
                                <hr>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="<?php echo empty($h) ? "active" : null ?>">
                                        <a href='?'>
                                            <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Data Master</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class='<?php
                                    if ($h == "seleksi" || $h == "seleksi-input") {
                                        echo "active";
                                    }

                                    ?>'>
                                        <a href='?h=seleksi'>
                                            <span class="pcoded-micon"><i class="ti-clipboard"></i></span>
                                            <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Daftar Seleksi</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    if ($h == "kriteria" || $h == "kriteria-input") {
                                        echo "active";
                                    }

                                    ?>">
                                        <a href='?h=kriteria'">
                                            <span class="pcoded-micon"><i class="ti-clipboard"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Daftar Kriteria</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    if ($h == "kriteria-seleksi" || $h == "kriteria-seleksi-input") {
                                        echo "active";
                                    }

                                    ?>">
                                        <a href='?h=kriteria-seleksi' style="padding-bottom: 20px">
                                            <span class="pcoded-micon"><i class="ti-clipboard"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Daftar Kriteria Setiap Seleksi</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class='<?php
                                    if ($h == "alternatif" || $h == "alternatif-input") {
                                        echo "active";
                                    }

                                    ?>'>
                                        <a href='?h=alternatif'>
                                            <span class="pcoded-micon"><i class="ti-clipboard"></i></span>
                                            <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">
                                                Daftar <?php echo $kasus_objek; ?> Kandidat
                                            </span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">Seleksi AHP</div>
                                <ul class="pcoded-item pcoded-left-item">   
                                    <li class='<?php
                                    if ($h == "nilai-kriteria") {
                                        echo "active";
                                    }

                                    ?>'>
                                        <a href='?h=nilai-kriteria'>
                                            <span class="pcoded-micon"><i class="ti-vector"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">1. Nilai Kriteria</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class='<?php
                                    if ($h == "nilai-alternatif") {
                                        echo "active";
                                    }

                                    ?>'>
                                        <a href='?h=nilai-alternatif'>
                                            <span class="pcoded-micon"><i class="ti-vector"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">2. Nilai <?php echo $kasus_objek; ?></span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class='<?php
                                    if ($h == "hasil") {
                                        echo "active";
                                    }

                                    ?>'>
                                        <a href='?h=hasil'>
                                            <span class="pcoded-micon"><i class="ti-vector"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">3. Hasil Seleksi</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">Pengaturan</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class='<?php
                                    if ($h == "password" || $h == "pengguna" || $h == "pengguna-input") {
                                        echo "active";
                                    }

                                    ?>'>
                                        <a href='?h=pengguna'>
                                            <span class="pcoded-micon"><i class="ti-user"></i></span>
                                            <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Daftar Pengguna</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        <div class="pcoded-content">
                            <div class="pcoded-inner-content">
                                <div class="main-body">
                                    <div class="page-wrapper">

                                        <div class="page-body">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <?php
                                                    switch ($h) {
                                                        case "alternatif":
                                                            include "list_alternatif.php";
                                                            break;
                                                        case "alternatif-input":
                                                            include "input_alternatif.php";
                                                            break;
                                                        case "kriteria":
                                                            include "list_kriteria.php";
                                                            break;
                                                        case "kriteria-input":
                                                            include "input_kriteria.php";
                                                            break;
                                                        case "kriteria-seleksi":
                                                            include "list_kriteria_seleksi.php";
                                                            break;
                                                        case "kriteria-seleksi-input":
                                                            include "input_kriteria_seleksi.php";
                                                            break;
                                                        case "seleksi":
                                                            include "list_seleksi.php";
                                                            break;
                                                        case "seleksi-input":
                                                            include "input_seleksi.php";
                                                            break;
                                                        case "pengguna":
                                                            if ($usertipe == 2) {
                                                                include "list_pengguna.php";
                                                            } else {
                                                                include "home.php";
                                                            }
                                                            break;
                                                        case "pengguna-input":
                                                            if ($usertipe == 2) {
                                                                include "input_pengguna.php";
                                                            } else {
                                                                include "home.php";
                                                            }
                                                            break;
                                                        case "password":
                                                            include "input_password.php";
                                                            break;
                                                        case "nilai-kriteria":
                                                            include "ahp_perbandingan_kriteria.php";
                                                            break;
                                                        case "nilai-alternatif":
                                                            include "ahp_perbandingan_alternatif.php";
                                                            break;
                                                        case "hasil":
                                                            include "ahp_hasil.php";
                                                            break;
                                                        default:
                                                            include "home.php";
                                                    }

                                                    ?>
                                                </div>

                                            </div>
                                        </div>

                                        <div id="styleSelector">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning Section Starts -->
            <!-- Older IE warning message -->
            <!--[if lt IE 9]>
        <div class="ie-warning">
            <h1>Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="assets/images/browser/chrome.png" alt="Chrome">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="assets/images/browser/firefox.png" alt="Firefox">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img src="assets/images/browser/opera.png" alt="Opera">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img src="assets/images/browser/safari.png" alt="Safari">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="assets/images/browser/ie.png" alt="">
                            <div>IE (9 & above)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>
        <![endif]-->
            <!-- Warning Section Ends -->
            <!-- Required Jquery -->
            <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js"></script>
            <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
            <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js"></script>
            <!-- jquery slimscroll js -->
            <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
            <!-- modernizr js -->
            <script type="text/javascript" src="assets/js/modernizr/modernizr.js"></script>
            <!-- am chart -->
            <!--<script src="assets/pages/widget/amchart/amcharts.min.js"></script>-->
            <!--<script src="assets/pages/widget/amchart/serial.min.js"></script>-->
            <!-- Chart js -->
            <!--<script type="text/javascript" src="assets/js/chart.js/Chart.js"></script>-->
            <!-- Todo js -->
            <!--<script type="text/javascript " src="assets/pages/todo/todo.js "></script>-->
            <!-- Custom js -->
            <!--<script type="text/javascript" src="assets/pages/dashboard/custom-dashboard.min.js"></script>-->
            <script type="text/javascript" src="assets/js/script.js"></script>
            <script type="text/javascript " src="assets/js/SmoothScroll.js"></script>
            <script src="assets/js/pcoded.min.js"></script>
            <script src="assets/js/vartical-demo.js"></script>
            <script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
            <script src="js/multifield.js"></script>
            <script src="js/validator.js"></script>
            <script>
                                        // initialize the validator function
                                        validator.message['date'] = 'not a real date';

                                        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
                                        $('form')
                                                .on('blur', 'input[required], input.optional, select.required', validator.checkField)
                                                .on('change', 'select.required', validator.checkField)
                                                .on('keypress', 'input[required][pattern]', validator.keypress);

                                        $('.multi.required')
                                                .on('keyup blur', 'input', function () {
                                                    validator.checkField.apply($(this).siblings().last()[0]);
                                                });

                                        // bind the validation to the form submit event
                                        //$('#send').click('submit');//.prop('disabled', true);

                                        $('form').submit(function (e) {
                                            e.preventDefault();
                                            var submit = true;
                                            // evaluate the form using generic validaing
                                            if (!validator.checkAll($(this))) {
                                                submit = false;
                                            }

                                            if (submit)
                                                this.submit();
                                            return false;
                                        });

                                        /* FOR DEMO ONLY
                                         $('#vfields').change(function(){
                                         $('form').toggleClass('mode2');
                                         }).prop('checked',false);
                                         
                                         $('#alerts').change(function(){
                                         validator.defaults.alerts = (this.checked) ? false : true;
                                         if( this.checked )
                                         $('form .alert').remove();
                                         }).prop('checked',false);
                                         */
            </script>
    </body>

</html>
