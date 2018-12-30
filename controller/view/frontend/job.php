<?php ob_start();?>
<!-- DataTables Example -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="card mb-3">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Catégories</th>
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
                $total = $achat - $depense;
                echo '<td>' . $total . '&nbsp;€</td>';
              }
              echo '<tr>';
            }
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
