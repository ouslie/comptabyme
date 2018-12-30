<?php ob_start();?>
<div class="card mb-3">
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Mois</th>
          <?php
          foreach ($account as $taccount)
          {
            $tblaccount[$taccount['id']] = $taccount['name'];
            echo '<th>' . $taccount['name'] .  '</th>';
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($date as $row)
        {
          echo '<tr><td>' . $row['name'] . '</td>';
          foreach ($tblaccount as $bank => $bank)
          {
            $total = isset($tblTotal[$row['id']][$bank]) ? $tblTotal[$row['id']][$bank] : 0;
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
