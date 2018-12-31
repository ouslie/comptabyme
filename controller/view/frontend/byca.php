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
        echo 'Trimestre 1 :&nbsp;'.$trim1.'&nbsp;€</br>';
        echo 'Trimestre 2 :&nbsp;'.$trim2.'&nbsp;€</br>';
        echo 'Trimestre 3 :&nbsp;'.$trim3.'&nbsp;€</br>';
        echo 'Trimestre 4 :&nbsp;'.$trim4.'&nbsp;€</br>';


        ?>
      </tbody>
    </table>
  </div>
</div>
<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>

<?php
$content = ob_get_clean();
require 'template.php';?>
