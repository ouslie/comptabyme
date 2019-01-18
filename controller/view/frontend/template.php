<!doctype html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="public/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="public/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/libs/css/style.css">
    <link rel="stylesheet" href="public/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="public/assets/vendor/vector-map/jqvmap.css">
    <link href="public/assets/vendor/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="public/assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="public/assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" type="text/css" href="public/assets/vendor/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="public/css/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="public/css/responsive.css" type="text/css" media="screen">
    <title>ComptaByMe - Arnaud GUY</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.php">ComptaByMe</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">

                                <form action="index.php?action=setbase" method="POST">
                                    <input type="hidden" id="activepage" name="activepage" value="<?= $_GET['action'] ?>">
                                    <select class="form-control" id="id_base" name="id_base" onchange="this.form.submit()">
                                        <option value="<?= $_SESSION['activebase'] ?>">
                                            <?= $_SESSION['activebasename'] ?>
                                        </option>
                                        <option> </option>
                                        <?php
                                        $jobManager = new JobManager();
                                        $base = $jobManager->GetBase($_SESSION['id']);
                                        $base = $base->fetchAll(PDO::FETCH_ASSOC);
                                        print_r($base);
                                        foreach ($base as $row) : ?>
                                        <option value="<?= $row['id']; ?>">
                                            <?= $row['name']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="index.php?action=cron" id="navbarDropdownMenuLink1"
                                aria-haspopup="true" aria-expanded="false"><i class=" fas fa-sync"></i> </a>
                        </li>
                        <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="public/assets/images/github.png"
                                                    alt=""> <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="public/assets/images/dribbble.png"
                                                    alt=""> <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="public/assets/images/dropbox.png"
                                                    alt=""> <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="public/assets/images/bitbucket.png"
                                                    alt=""> <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="public/assets/images/mail_chimp.png"
                                                    alt=""><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="public/assets/images/slack.png"
                                                    alt=""> <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><img src="public/assets/images/avatar-1.jpg"
                                    alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">John Abraham </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="index.php?action=disconnect"><i class="fas fa-power-off mr-2"></i>Deconnection</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link <?php if ($_GET['action'] == 'dashboard') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?action=dashboard" aria-expanded="false" aria-controls="submenu-1"><i
                                        class="fa fa-fw fa-user-circle"></i>Dashboard
                                    <span class="badge badge-success">6</span></a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'transaction' && $_GET['action'] == 'list' ) {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?module=transaction&action=list"><i
                                        class="fa fa-fw fa-rocket"></i>Transaction</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['action'] == 'byjob') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?action=byjob" ><i
                                        class="fas fa-fw fa-chart-pie"></i>Par catégories</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['action'] == 'byaccount') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?action=byaccount"><i
                                        class="fas fa-fw fa-chart-pie"></i>Par comptes</a>

                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['action'] == 'treso') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?action=treso" aria-expanded="false" aria-controls="submenu-5"><i
                                        class="fas fa-fw fa-chart-pie"></i>Trésorerie</a>

                            </li>
                            <?php if($_SESSION['activeca'] == 1) {?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['action'] == 'byca') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?action=byca" aria-expanded="false" aria-controls="submenu-5"><i
                                        class="fas fa-fw fa-chart-pie"></i>CA</a>

                            </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'contrats' && $_GET['action'] == 'list' ) {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?module=contrats&action=list"><i class="fas fa-fw fa-table"></i>Contrats</a>

                                                </li>

                            <li class="nav-divider">
                            Configuration
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'base' && $_GET['action'] == 'list' ) {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?module=base&action=list"><i class="fas fa-cog"></i>Base</a>

                                                </li>


                                        <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'category' && $_GET['action'] == 'list' ) {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?module=category&action=list"><i class="fas fa-cog"></i>Catégories</a>

                                                </li>



                                                <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'bank' && $_GET['action'] == 'list' ) {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?module=bank&action=list"><i class="fas fa-cog"></i>Compte</a>

                                                </li>




                        

                                    </ul>
                                </div>
                            </li>




                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-finance">
                <div class="container-fluid dashboard-content">


                    <?= $content ?>


                </div>
            </div>
            <div id="message"></div>

            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            Copyright © 2018 Arnaud GUY. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Colorlib</a>.
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->

    <script>
        $('[name="id_base"]').change(function () {
            $(this).closest('form').submit();
        });
    </script>


    <!-- jquery 3.3.1  -->
    <script src="public/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="public/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="public/assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <!-- dashboard finance js -->
    <script src="public/assets/libs/js/dashboard-finance.js"></script>
    <!-- main js -->
    <script src="public/assets/libs/js/main-js.js"></script>
    <!-- daterangepicker js -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' +
                    end.format('YYYY-MM-DD'));
            });
        });
    </script>
</body>

</html>