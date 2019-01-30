<?php ob_start();
 $jobManager = new JobManager();
 ?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
    <div class="card-body">
      <form>
        <div class="form-group">
          <select id="input-select" name="id_client" class="form-control">
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
      </form>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require_once('controller/view/frontend/template.php');?>