<?php ob_start();?>

<script src="public/js/base.js"></script>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
    <div id="toolbar" class="card-header">
      <input type="text" id="filter" name="filter" placeholder="Filter par nom" />
      <!-- Button trigger modal -->
      <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Ajouter une base
      </a>
    </div>
    <div class="card-body">


      <!-- Grid contents -->
      <div id="tablecontent"></div>

      <!-- Paginator control -->
      <div id="paginator"></div>

    </div>
  </div>
</div>
<div class="row">
  <!-- ============================================================== -->
  <!-- modal  -->
  <!-- ============================================================== -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajout d'une base</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div id="addform">
          <div class="modal-body">
        
            <div class="input-group input-group-lg mb-3">
              <div class="input-group-prepend"><span class="input-group-text">@</span></div>
              <input type="text" placeholder="Nom de la base" class="form-control" id="name" name="name">
            </div>       
          <div class="modal-footer">
            <a href="#" class="btn btn-secondary" data-dismiss="modal">Annuler</a>
            <a href="#" id="addbutton" data-dismiss="modal" class="btn btn-primary">Valider</a>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- modal  -->
  <!-- ============================================================== -->
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
    $("#addbutton").click(function () {
      datagrid.addRow();
    });

  }
</script>

<?php
$content = ob_get_clean();
require 'controller/view/frontend/template.php';?>