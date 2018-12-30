<?php ob_start();?>

<!--
/*
* examples/mysql/index.html
*
* This file is part of EditableGrid.
* http://editablegrid.net
*
* Copyright (c) 2011 Webismymind SPRL
* Dual licensed under the MIT or GPL Version 2 licenses.
* http://editablegrid.net/license
*/
-->

<link rel="stylesheet" href="public/css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="public/css/responsive.css" type="text/css" media="screen">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="public/css/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" media="screen">

<body>
  <div id="message"></div>

  <div id="wrap">
    <!-- Feedback message zone -->
    <div id="toolbar">
      <input type="text" id="filter" name="filter" placeholder="Filter par tiers" />
      <a id="showaddformbutton" class="button green"><i class="fa fa-plus"></i>Ajouter une transaction</a>
    </div>

    <!-- Grid contents -->
    <div id="tablecontent"></div>

    <!-- Paginator control -->
    <div id="paginator"></div>

  </div>



  <script type="text/javascript">
  var datagrid;

  window.onload = function () {
    datagrid = new DatabaseGrid();
    // key typed in the filter field
    $("#filter").keyup(function () {
      datagrid.editableGrid.filter($(this).val());
      // To filter on some columns, you can set an array of column index
      //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
    });
    $("#showaddformbutton").click(function () {
      showAddForm();
    });
    $("#cancelbutton").click(function () {
      showAddForm();
    });

    $("#addbutton").click(function () {
      datagrid.addRow();
    });

  }
  $(function () {
  });
  </script>

  <?php $jobManager = new JobManager();?>

  <div id="addform">
    <div class="row">
      <input type="date" id="date" name="date" />
    </div>

    <div class="row">
      <select id="id_type" name="id_type">
        <option value="">--Type--</option>
        <?php
        $type = $jobManager->GetType();
        $type = $type->fetchAll(PDO::FETCH_ASSOC);
        foreach ($type as $row): ?>
        <option value="<?=$row['id'];?>">
          <?=$row['name'];?>
        </option>
      <?php endforeach;?>
    </select>
  </div>

  <div class="row">
    <select id="id_category" name="id_category">
      <option value="">--Catégorie--</option>
      <?php
      $categories = $jobManager->GetCategory($_SESSION['activebase']);
      $categories = $categories->fetchAll(PDO::FETCH_ASSOC);

      foreach ($categories as $row): ?>
      <option value="<?=$row['id'];?>">
        <?=$row['name'];?>
      </option>
    <?php endforeach;?>

  </select>
</div>
<div class="row">
  <input type="text" id="third" name="third" placeholder="Tiers" required/>
</div>
<div class="row">
  <input type="text" id="comment" name="comment" placeholder="Commentaire" />
</div>
<div class="row">
  <input type="text" id="amount" name="amount" placeholder="Montant" />
</div>

<div class="row">
  <select id="id_bank" name="id_bank">
    <option value="">--Banque--</option>
    <?php
    $bank = $jobManager->GetBankSys($_SESSION['activebase']);
    $bank = $bank->fetchAll(PDO::FETCH_ASSOC);

    foreach ($bank as $row): ?>
    <option value="<?=$row['id'];?>">
      <?=$row['name'];?>
    </option>
  <?php endforeach;?>

</select>
</div>

<div class="row tright">
  <a id="addbutton" class="button green"><i class="fa fa-save"></i> Apply</a>
  <a id="cancelbutton" class="button delete">Cancel</a>
</div>
</div>

</body>


<?php
$content = ob_get_clean();
require 'template.php';?>
