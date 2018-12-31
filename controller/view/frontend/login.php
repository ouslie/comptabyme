<!doctype html>
<html lang="fr">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="public/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="public/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/libs/css/style.css">
    <link rel="stylesheet" href="public/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-body">
       <?php     echo $form_connexion;
if (!empty($erreurs_connexion)) {

    echo '<ul>' . "\n";

    foreach ($erreurs_connexion as $e) {

        echo '	<li>' . $e . '</li>' . "\n";
    }

    echo '</ul>';
}
?>
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="index.php?module=membres&action=inscription" class="footer-link">Créer un compte</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Rien</a>
                </div>
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="public/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="public/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>

