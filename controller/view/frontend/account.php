<?php ob_start();?>
<link rel="stylesheet" href="public/css/style.css" type="text/css" media="screen">
<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Tables</li>
</ol>
<div class="card mb-3">
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Mois</th>
          <?php
          foreach ($account as $toto)
          {
            $tblaccount[$toto['id']] = $toto['name'];
            echo '<th colspan="3" style="text-align:center">' . $toto['name'] . '</th>';
          }
          ?>
        </tr>
        <tr>
          <th></th>
          <?php
          foreach ($account as $toto)
          {
            echo '<th>Recettes </th>';
            echo '<th>Dépenses </th>';
            echo '<th>Total </th>';
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($date as $row) {
          echo '<tr><td>' . $row['name'] . '</td>';
          foreach ($tblaccount as $bank => $bank)
          {
            $total = isset($tblAchat[$row['id']][$bank]) ? $tblAchat[$row['id']][$bank] : 0;
            $recette = isset($tblRecette[$row['id']][$bank]) ? $tblRecette[$row['id']][$bank] : 0;
            $depense = isset($tblDepense[$row['id']][$bank]) ? $tblDepense[$row['id']][$bank] : 0;
            echo '<td>' . $recette . '&nbsp;€</td>';
            echo '<td>' . $depense . '&nbsp;€</td>';
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

<?php

$content = ob_get_clean();
require 'template.php';?>
