<?php ob_start();?>

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
    
<?php
$content = ob_get_clean();
require_once('controller/view/frontend/template.php');?>