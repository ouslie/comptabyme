<?php ob_start();?>

<div class="card mb-3">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Mois</th>
                    <th>CA</th>
                </tr>
            </thead>
            <tbody>
                <?php
        $trim1 = 0;
        $trim2 = 0;
        $trim4 = 0;
        $trim3 = 0;
        foreach ($date as $row)
        {
          
          echo '<tr rowspan="2"><td>' . $row['name'] . '</td>';
          
            $total = isset($tblTotal[$row['id']]) ? $tblTotal[$row['id']] : 0;
            if ($row['id'] >= 1 && $row['id'] <= 3 ){
              $trim1 = $total + $trim1;
            }
            if ($row['id'] >= 4 && $row['id'] <= 6 ){
              $trim2 = $total + $trim2;
            }
            if ($row['id'] >= 7 && $row['id'] <= 9 ){
              $trim3 = $total + $trim3;
            }
            if ($row['id'] >= 10 && $row['id'] <= 12 ){
              $trim4 = $total + $trim4;
            }
            echo '<td>' . $total . '&nbsp;€</td>';

          echo '<tr>';
        }

        ?>


            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <!-- metric -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Trimestre 1</h5>
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1 text-primary">
                        <?= $trim1?> €</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /. metric -->
    <!-- metric -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Trimestre 2</h5>
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1 text-primary">
                        <?= $trim2?> € </h1>
                </div>

            </div>
        </div>
    </div>
    <!-- /. metric -->
    <!-- metric -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Trimestre 3</h5>
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1 text-primary">
                        <?= $trim3?> €</h1>
                </div>

            </div>
        </div>
    </div>
    <!-- /. metric -->
    <!-- metric -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Trimestre 4</h5>
                <div class="metric-value d-inline-block">
                    <h1 class="mb-1 text-primary">
                        <?= $trim4?> €</h1>
                </div>

            </div>
        </div>
    </div>
    <!-- /. metric -->
</div>

<?php
$content = ob_get_clean();
require 'template.php';?>