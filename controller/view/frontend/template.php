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
    <link rel="stylesheet" href="public/css/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="public/css/responsive.css" type="text/css" media="screen">
    <link rel="stylesheet" href="public/assets/vendor/charts/morris-bundle/morris.css">
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
                                <a class="nav-link <?php if ($_GET['module'] == 'transaction' && $_GET['action'] == 'list') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?module=transaction&action=list"><i class="fa fa-fw fa-rocket"></i>Transaction</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['action'] == 'byjob') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?action=byjob"><i class="fas fa-fw fa-chart-pie"></i>Par catégories</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['action'] == 'byaccount') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?action=byaccount"><i class="fas fa-fw fa-chart-pie"></i>Par comptes</a>

                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['action'] == 'treso') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?action=treso" aria-expanded="false" aria-controls="submenu-5"><i
                                        class="fas fa-fw fa-chart-pie"></i>Trésorerie</a>

                            </li>

                            <?php if ($_SESSION['activeca'] == 1) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['action'] == 'byca') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?action=byca" aria-expanded="false" aria-controls="submenu-5"><i
                                        class="fas fa-fw fa-chart-pie"></i>CA</a>

                            </li>
                            <?php 
                        } ?>
                            <?php if ($_SESSION['activecontrats'] == 1) { ?>

                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'contrats' && $_GET['action'] == 'list') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?module=contrats&action=list"><i class="fas fa-fw fa-table"></i>Contrats</a>

                            </li>
                            <?php 
                        } ?>

                            <?php if ($_SESSION['activefact'] == 1) { ?>

                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'facture' && $_GET['action'] == 'list') {
                            echo 'active';
                        } ?>"
                                    href="index.php?module=facture&action=list"><i class="fas fa-fw fa-table"></i>Facture</a>

                            </li>
                            <?php 
                            } ?>


                            <li class="nav-divider">
                                Configuration
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'base' && $_GET['action'] == 'list') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?module=base&action=list"><i class="fas fa-cog"></i>Base</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'category' && $_GET['action'] == 'list') {
                                                        echo 'active';
                                                    } ?>"
                                    href="index.php?module=category&action=list"><i class="fas fa-cog"></i>Catégories</a>

                            </li>



                            <li class="nav-item">
                                <a class="nav-link <?php if ($_GET['module'] == 'bank' && $_GET['action'] == 'list') {
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
                            Copyright © 2018 Arnaud GUY</a>.
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->


        </div>


        <!-- jquery 3.3.1  -->
        <script src="public/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
        <!-- bootstap bundle js -->
        <script src="public/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
        <!-- slimscroll js -->
        <script src="public/assets/vendor/slimscroll/jquery.slimscroll.js"></script>

        <script src="public/js/commun.js"></script>
        <script src="public/js/editablegrid-2.1.0-49.js"></script>
        <script src="public/assets/vendor/charts/morris-bundle/raphael.min.js"></script>
        <script src="public/assets/vendor/charts/morris-bundle/morris.js"></script>
        <script src="public/assets/vendor/charts/morris-bundle/Morrisjs.js"></script>

</body>

</html>