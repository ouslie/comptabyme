<?php ob_start();
      $jobManager = new JobManager();
      ?>

<script src="public/js/factures.js"></script>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
    <div id="toolbar" class="card-header">
      <input type="text" id="filter" name="filter" placeholder="Filter par nom" />
      <!-- Button trigger modal -->
      <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Ajouter une facture
      </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">


        <!-- Grid contents -->
        <div id="tablecontent"></div>

        <!-- Paginator control -->
        <div id="paginator"></div>
      </div>

    </div>
  </div>
</div>
<div class="row">
  <!-- ============================================================== -->
  <!-- modal  -->
  <!-- ============================================================== -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width : 900px!important" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajout d'une facture</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>

        <div id="addform">
          <div class="modal-body">
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Date</label>
              <div class="col-9 col-lg-10">
                <input type="date" class="form-control" id="date" name="date">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Clients</label>
              <div class="col-9 col-lg-10">

                <select id="id_client" name="id_client" class="form-control">
                  <option value="">--Clients--</option>
                  <?php
        $clients = $jobManager->GetClients($_SESSION['activebase']);
        $clients = $clients->fetchAll(PDO::FETCH_ASSOC);
        foreach ($clients as $row): ?>
                  <option value="<?=$row['id'];?>">
                    <?=$row['name'];?>
                  </option>
                  <?php endforeach;?>

                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Catégorie</label>
              <div class="col-9 col-lg-10">


                <select id="id_category" name="id_category" class="form-control">
                  <option value="">--Catégorie--</option>
                  <?php
      $categories = $jobManager->GetCategoryIsRecette($_SESSION['activebase']);
      $categories = $categories->fetchAll(PDO::FETCH_ASSOC);

      foreach ($categories as $row): ?>
                  <option value="<?=$row['id'];?>">
                    <?=$row['name'];?>
                  </option>
                  <?php endforeach;?>

                </select>
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
        datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
      });
      $("#addbutton").click(function () {
        datagrid.addRow();
      });

    }
  </script>

  <?php
$content = ob_get_clean();
require 'controller/view/frontend/template.php';?>