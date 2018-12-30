<select id="base name" >
      <option value="" >--Base--</option>
      <?php
$base = $jobManager->GetBank();
$base = $bank->fetchAll(PDO::FETCH_ASSOC);

foreach ($bank as $row): ?>
 <option value="<?=$row['id'];?>"><?=$row['name'];?></option>
<?php endforeach;?>
</select>
