<?php ob_start();?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
      <label class="col-3 col-lg-2 col-form-label text-right">Clients</label>
      <div class="col-9 col-lg-10">

        <select id="id_client" name="id_client" class="form-control">
          <option value="">--Clients--</option>
          <?php
        $clients = $jobManager->GetClients($_SESSION['activebase']);
        $clients = $type->fetchAll(PDO::FETCH_ASSOC);
        foreach ($clients as $row): ?>
          <option value="<?=$row['id'];?>">
            <?=$row['name'];?>
          </option>
          <?php endforeach;?>

        </select>
      </div>
    </div>

</div>
<?php
$content = ob_get_clean();
require 'controller/view/frontend/template.php';?>