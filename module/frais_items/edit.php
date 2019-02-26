<?php ob_start();
      $Frais = new Frais();
      $id_note_frais = $_GET['id_notefrais'];
      $row = $Frais->Get($id_note_frais);
      $Sscategories = new Sscategories();
      $Bank = new Bank();
      ?>

<script src="public/js/frais.js"></script>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="page-header">
<h2 class="pageheader-title">Note de frais REF° <?php echo  $row['id']; ?></h2>
<div class="page-breadcrumb">
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php?module=frais&action=list" class="breadcrumb-link">Note de frais</a></li>
<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Items</a></li>
</ol>
</nav>
</div>
</div>
</div>
</div>
  <div class="card">
    <div id="toolbar" class="card-header">
      <h3 style="display:inline;margin:0% 50% 0% 0%"> Destinataire :  <?php echo  $row['name']; ?> </h3>
      <h3 style="display:inline;margin:0% 50% 0% 0%"> Commentaire :  <?php echo  $row['comment']; ?> </h3>
      <h3 style="display:inline">   Date de début :  <?php echo  $row['debcontrat']; ?></h3>
<h3>   Date de fin :  <?php echo  $row['endcontrat']; ?></h3>

      <br/>
      <br/>

        <!-- Button trigger modal -->
        <a href="#" style="margin:0% 61% 0% 0% " class="btn btn-brand" data-toggle="modal" data-target="#exampleModal">
        Ajouter un item
      </a>
     <h3 style="text-align:right;display:inline"> Solde :  <?php echo $row['amount']; ?> €</h3>
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
          <h5 class="modal-title" id="exampleModalLabel">Ajout d'un item</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>

        <div id="addform">
          <div class="modal-body">   
          <div class="modal-body">
          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Date</label>
            <div class="col-9 col-lg-10">
              <input type="date" class="form-control" id="date" name="date">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Catégorie</label>
            <div class="col-9 col-lg-10">


              <select id="id_category_child_frais" name="id_category_child_frais" class="form-control">
                <option value="">--Catégorie--</option>
                <?php

$Sscategories = $Sscategories->ListAllMy($row['id_cat']);

foreach ($Sscategories as $row => $cat_name): ?>
                <option value="<?=$row;?>">
                  <?=$cat_name;?>
                </option>
                <?php endforeach;?>

              </select>
            </div>
          </div>
            <div class="form-group row">
              <label class="col-3 col-lg-2 col-form-label text-right">Tiers</label>
              <div class="col-9 col-lg-10">
                <div class="input-group">           
                  <input type="text" id="third" name="third" class="form-control" placeholder="Tiers"
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
            <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Banque</label>
            <div class="col-9 col-lg-10">
              <select id="id_bank" name="id_bank" class="form-control">
                <option value="">--Banque--</option>
                <?php
$bank = $Bank->ListMyWithoutSys($_SESSION['activebase']);
foreach ($bank as $row => $bank_name): ?>
                <option value="<?=$row;?>">
                  <?=$bank_name;?>
                </option>
                <?php endforeach;?>

              </select>
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
    function Copypubliclink() {
  /* Get the text field */
  var copyText = document.getElementById("hash");

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the text: " + copyText.value);
}
  </script>

  <?php
$content = ob_get_clean();
require 'controller/view/frontend/template.php';?>