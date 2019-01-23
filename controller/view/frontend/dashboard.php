<?php ob_start();?>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Recette du mois</h5>
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">
                        <?=$RecetteMonth['amount']?>€</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Dépense du mois</h5>
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">
                        <?=$DepenseMonth['amount']?>€</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Balance</h5>
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1">
                        <?=$RecetteMonth['amount'] + $DepenseMonth['amount']?>€</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <h5 class="card-header text-muted"> A venir</h5>
            <div class="card-body p-0">
                <ul class="traffic-sales list-group list-group-flush">
                    <li class="traffic-sales-content list-group-item "><span class="traffic-sales-name">Recettes</span><span
                            class="traffic-sales-amount">
                            <?=$RecetteAVenir['amount']?>€
                        </span>
                    </li>
                    <li class="traffic-sales-content list-group-item"><span class="traffic-sales-name">Dépenses<span
                                class="traffic-sales-amount">
                                <?=$DepenseAVenir['amount']?>€
                            </span>
                        </span>
                    </li>
            </div>
        </div>
    </div>


        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Graph ta mére</h5>
                <div class="card-body">
                    <div id="morris_line">
                    </div>
                </div>
            </div>
        </div>

        <script src="public/js/jquery.js"></script>
        <script language="JavaScript" type="text/javascript">
            $(function () {
                var jsobj = <?php echo $phpobj;?>;
                Morris.Line({
                    element: 'morris_line',
                    behaveLikeLine: true,
                    data: jsobj,
                    xkey: 'namedate',
                    parseTime: false,
                    ykeys: ['depense', 'recette', 'total'],
                    labels: ['Dépense', 'Recette', 'Balance'],
                    lineColors: ['#5969ff', '#ff407b', '#64b764'],
                    resize: true,
                    gridTextSize: '14px',
                    xLabelAngle: 45,
                });
            });
        </script>
        </body>
        <?php
$content = ob_get_clean();
require 'template.php';?>