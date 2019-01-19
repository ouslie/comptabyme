<?php ob_start();?>
<div class="row">
  <!-- ============================================================== -->
  <!-- basic table  -->
  <!-- ============================================================== -->
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="card-body">
        <div class="table-content">
          <div class="table-responsive">

            <table class="table table-hover table-bordered first ">
              <th> Mois </th>

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
        $currentmonth = date('m', time());
        foreach ($date as $row) {
          if ($row['id'] == $currentmonth) 
          {
            echo '<tr style="background-color:#fff3cd"><td>' . $row['name'] . '</td>';
          } else 
          {
            echo '<tr><td>' . $row['name'] . '</td>';
          }
          foreach ($tblaccount as $bank => $bank)
          {
            $total = isset($tblTotal[$row['id']][$bank]) ? $tblTotal[$row['id']][$bank] : 0;
            if ($total > 0){
              echo '<td><p class="text-success">' . $total . '&nbsp;€</p></td>';
            } elseif ($total == 0) {echo '<td>' . $total . '&nbsp;€</td>';
            }
          
            else {
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
</div>


<?php
$content = ob_get_clean();
require 'template.php';?>