<?php ob_start();
      $Factures = new Factures();
      $id_fact = $_GET['id_fact'];
      $row = $Factures->GetFacture($id_fact);
      $client = $Factures->GetClient($id_fact);
      ?>

<script src="public/js/items.js"></script>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="page-header">
<h2 class="pageheader-title">Facture N° <?php echo  $row['num']; ?></h2>
<div class="page-breadcrumb">
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php?module=factures&action=list" class="breadcrumb-link">Factures</a></li>
<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Items</a></li>
</ol>
</nav>
</div>
</div>
</div>
</div>
  <div class="card">
    <div id="toolbar" class="card-header">
      <h3 style="display:inline;margin:0% 60% 0% 0%"> Clients :  <?php echo  $client['name']; ?> </h3>
      <h3 style="display:inline">   Date :  <?php echo  $row['date']; ?></h3>
      <br/>
      <br/>

        <!-- Button trigger modal -->
        <a href="#" style="margin:0% 61% 0% 0% "class="btn btn-brand" data-toggle="modal" data-target="#exampleModal">
        Ajouter un item
      </a>
     <h3 style="text-align:right;display:inline"> Solde :  <?php echo $row['solde']; ?> €</h3>
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
              <label class="col-3 col-lg-2 col-form-label text-right">Désignation</label>
              <div class="col-9 col-lg-10">
                <div class="input-group">           
                  <input type="text" id="designation" name="designation" class="form-control" placeholder="Désignation"
                    aria-describedby="inputGroupPrepend">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Quantité</label>
              <div class="col-9 col-lg-10">
                <div class="input-group">           
                  <input type="text" id="quantity" name="quantity" class="form-control" placeholder="Quantité"
                    aria-describedby="inputGroupPrepend">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Montant</label>
              <div class="col-9 col-lg-10">
                <div class="input-group">           
                  <input type="text" id="amount" name="amount" class="form-control" placeholder="Montant"
                    aria-describedby="inputGroupPrepend">
                </div>
              </div>
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