<?php ob_start();
$jobManager = new JobManager();
$Categories = new Categories();
$Bank = new Bank();
$Frais = new Frais();

?>

<script src="public/js/transations.js"></script>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
    <div id="toolbar" class="card-header">
      <input type="text" id="filter" name="filter" placeholder="Filter par nom" />
      <!-- Button trigger modal -->
      <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Ajouter une transaction
      </a>
      <a href="#" class="btn btn-brand" data-toggle="modal" data-target="#modalInterne">
        Ajouter une transaction interne
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
<!-- ============================================================== -->
<!-- modal  -->
<!-- ============================================================== -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajout d'une transaction</h5>
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
            <label class="col-3 col-lg-2 col-form-label text-right">Type</label>
            <div class="col-9 col-lg-10">

              <select id="id_type" name="id_type" class="form-control">
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
          </div>

          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Catégorie</label>
            <div class="col-9 col-lg-10">


              <select id="id_category" name="id_category" class="form-control">
                <option value="">--Catégorie--</option>
                <?php

$Categories = $Categories->ListAllMy($_SESSION['activebase']);

foreach ($Categories as $row => $cat_name): ?>
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
              <input placeholder="Tiers" class="form-control" id="third" name="third">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Com'</label>
            <div class="col-9 col-lg-10">
              <input placeholder="Commentaire" class="form-control" id="comment" name="comment">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Montant</label>
            <div class="col-9 col-lg-10">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupPrepend">€</span>
                </div>
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

          <?php if ($_SESSION['activecontrats'] == 1) {?>
          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Contrat</label>
            <div class="col-9 col-lg-10">
              <select id="id_contrat" name="id_contrat" class="form-control">


                <option value="">--Note de frais--</option>
                <?php
$frais = $Frais->ListMy($_SESSION['activebase']);

    foreach ($frais as $row => $contrat_name): ?>
                <option value="<?=$row;?>">
                  <?=$contrat_name;?>
                </option>
                <?php endforeach;?>

              </select>


            </div>
          </div>
          <?php }?>
          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Pointage</label>
            <div class="col-9 col-lg-10">
              <input type="checkbox" class="form-control" id="tally" name="tally">
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
</div>
<!-- ============================================================== -->
<!-- modal  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- modal interne -->
<!-- ============================================================== -->
<div class="modal fade" id="modalInterne" tabindex="-1" role="dialog" aria-labelledby="modalInterneLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalInterneLabel">Ajout d'une transaction interne</h5>
        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <div id="addform">
        <div class="modal-body">
          
          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Date</label>
            <div class="col-9 col-lg-10">
              <input type="date" class="form-control" id="dateinternal" name="dateinternal">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Dépense</label>
            <div class="col-9 col-lg-10">
              <select id="id_bank_depense" name="id_bank_depense" class="form-control">
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

          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Recette</label>
            <div class="col-9 col-lg-10">
              <select id="id_bank_recette" name="id_bank_recette" class="form-control">
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

          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Montant</label>
            <div class="col-9 col-lg-10">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupPrepend">€</span>
                </div>
                <input type="text" id="amountinternal" name="amountinternal" class="form-control" placeholder="Montant"
                  aria-describedby="inputGroupPrepend">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Pointage</label>
            <div class="col-9 col-lg-10">
              <input type="checkbox" class="form-control" id="tallyinternal" name="tallyinternal">
            </div>
          </div>

          <div class="modal-footer">
            <a href="#" class="btn btn-secondary" data-dismiss="modal">Annuler</a>
            <a href="#" id="addbuttoninternal" data-dismiss="modal" class="btn btn-primary">Valider</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- modal  -->
<!-- ============================================================== -->


<script type="text/javascript">
  var datagrid;

  window.onload = function () {
    datagrid = new DatabaseGrid();
    // key typed in the filter field
    $("#filter").keyup(function () {
      datagrid.editableGrid.filter($(this).val());
      // To filter on some columns, you can set an array of column index
      datagrid.editableGrid.filter($(this).val(), [0, 3, 5]);
    });
    $("#addbutton").click(function () {
      datagrid.addRow();
    });
    $("#addbuttoninternal").click(function () {
      datagrid.addRowInternal();
    });

  }
</script>

<?php
$content = ob_get_clean();
require 'controller/view/frontend/template.php';?>