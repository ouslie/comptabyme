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
<script src="public/js/editablegrid-2.1.0-49.js"></script>
<script src="public/js/category.js"></script>
<script src="public/js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="public/css/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" media="screen">

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
    <div id="toolbar" class="card-header">
      <input type="text" id="filter" name="filter" placeholder="Filter par nom" />
      <a id="showaddformbutton" class="btn btn-outline-primary">Ajouter une categorie</a>
    </div>
    <div class="card-body">


      <!-- Grid contents -->
      <div id="tablecontent"></div>

      <!-- Paginator control -->
      <div id="paginator"></div>

    </div>
  </div>
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
</script>

<?php $jobManager = new JobManager();?>

<div id="addform">

<div class="row">
    <input type="text" id="name" name="name" placeholder="Nom" required />
  </div>
 


  <div class="row tright">
    <a id="addbutton" class="btn btn-rounded btn-success"><i class="fa fa-save"></i> Apply</a>
    <a id="cancelbutton" class="btn btn-rounded btn-danger">Annuler</a>
  </div>
</div>



<?php
$content = ob_get_clean();
require 'controller/view/frontend/template.php';?>