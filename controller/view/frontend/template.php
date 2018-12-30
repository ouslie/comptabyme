<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ComptaGy</title>

  <script src="public/js/jquery-1.11.1.min.js"></script>
  <script src="public/js/editablegrid-2.1.0-49.js"></script>
  <!-- EditableGrid test if jQuery UI is present. If present, a datepicker is automatically used for date type -->
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
  <script src="public/js/demo.js"></script>

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="public/css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="public/css/style.css" type="text/css" media="screen">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">ComptaByMe</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="index.php">
      <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand mr-1" href=#>
      Base active = <?= $_SESSION['activebase'] ?></a>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
        </div>
      </form>
      <form action="index.php?action=setbase" method="POST">
        <select id="id_base" name="id_base">
          <option value="">--Base--</option>
          <?php
          $jobManager = new JobManager();
          $base = $jobManager->GetBase($_SESSION['id']);
          $base = $base->fetchAll(PDO::FETCH_ASSOC);
          print_r($base);
          foreach ($base as $row): ?>
          <option value="<?=$row['id'];?>">
            <?=$row['name'];?>
          </option>
        <?php endforeach;?>

      </select>
      <input type="submit" name="submit" value="Valider">
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-circle fa-fw"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#">Settings</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Déconnection</a>
      </div>
    </li>
  </ul>

</nav>

<div id="wrapper">

  <!-- Sidebar -->
  <ul class="sidebar navbar-nav toggled">
    <li class="nav-item">
      <a class="nav-link" href="index.php?action=dashboard">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Tableau de bord</span>
      </a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="index.php?action=listtransaction">
        <i class="fas fa-fw fa-table"></i>
        <span>Transaction</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?action=byjob">
          <i class="fas fa-fw fa-table"></i>
          <span>Par Postes</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="index.php?action=byaccount">
            <i class="fas fa-fw fa-table"></i>
            <span>Par Comptes</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="index.php?action=treso">
              <i class="fas fa-fw fa-table"></i>
              <span>Trésorerie</span></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-fw fa-folder"></i>
              <span>Configuration</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
              <a class="dropdown-item" href="index.php?action=addaccount">Account ADD</a>
              <a class="dropdown-item" href="index.php?action=addbase">BASE ADD</a>

              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header">Other Pages:</h6>

            </div>
          </li>
        </ul>

        <div id="content-wrapper">
          <div class="container-fluid">

            <?=$content?>
        
            </div>
        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Your Website 2018</span>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
</div>



<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
    <div class="modal-footer">
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      <a class="btn btn-primary" href="login.html">Logout</a>
    </div>
  </div>
</div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="public/js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->


</body>

</html>
