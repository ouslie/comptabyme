<?php ob_start(); ?>
<!-- ============================================================== -->
<!-- basic table  -->
<!-- ============================================================== -->
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
    <div class="card-body">
      <div class="table-content">
        <div class="table-responsive">

          <table class="table table-hover table-bordered first ">
            <th> Catégories </th>
            <?php
          foreach ($date as $row) {
            $tblDate[$row['id']] = $row['name'];
            echo '<th>' . $row['name'] . '</th>';
          }
          ?>
            </tr>
            </thead>
            <tbody>
              <?php
            foreach ($categories as $row) {
              echo '<tr><td>' . $row['name'] . '</td>';
              foreach ($tblDate as $month => $month) {
                $achat = isset($tblAchat[$row['name']][$month][1]) ? $tblAchat[$row['name']][$month][1] : 0;
                $depense = isset($tblAchat[$row['name']][$month][2]) ? $tblAchat[$row['name']][$month][2] : 0;
                $total = $achat + $depense;
                if ($total > 0) {
                  echo '<td><p class="text-success">' . $total . '&nbsp;€</p></td>';
                } elseif ($total == 0) {
                  echo '<td>' . $total . '&nbsp;€</td>';
                } else {
                  echo '<td><p class="text-danger">' . $total . '&nbsp;€</p></td>';

                }
              }
              echo '<tr>';
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require 'template.php'; ?>