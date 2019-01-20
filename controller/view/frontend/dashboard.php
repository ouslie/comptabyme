<?php ob_start(); ?>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Recette du mois</h5>
            <div class="card-body">
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">
                        <?= $RecetteMonth['amount'] ?>€</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Dépenses du mois</h5>
            <div class="card-body">
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">
                        <?= $DepenseMonth['amount'] ?>€</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Balance du mois</h5>
            <div class="card-body">
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">
                        <?= $RecetteMonth['amount'] - $DepenseMonth['amount'] ?>€</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">A venir </h5>
            <div class="card-body">
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">
                        Recette :
                        <?= $RecetteAVenir['amount'] ?>€</h1>
                    <h1 class="mb-1">
                        Dépense :
                        <?= $DepenseAVenir['amount'] ?>€</h1>
                </div>
            </div>
        </div>
    </div>
  

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Donut Chart </h5>
            <div class="card-body">
            <div id="morris_line">
            </div>
        </div>
        </div>



    <script src="public/js/jquery.js"></script>
    <script language="JavaScript" type="text/javascript">
        $(function() {
        var jsobj = <?php echo $phpobj; ?>;
            Morris.Line({
                element: 'morris_line',
                behaveLikeLine: true,
                data: jsobj,
                xkey: 'month',
                ykeys: ['depense', 'recette'],
                labels: ['Dépense', 'Recette'],
                   lineColors: ['#5969ff', '#ff407b'],
                     resize: true,
                        gridTextSize: '14px'
            });

        


        });
        </script>


    </body>

    <?php
    $content = ob_get_clean();
    require 'template.php'; ?>