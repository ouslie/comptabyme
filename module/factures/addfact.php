<?php ob_start();?>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
<select id="id_client" name="id_client">
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
<?php
$content = ob_get_clean();
require_once('controller/view/frontend/template.php');?>