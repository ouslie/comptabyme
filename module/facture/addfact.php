<?php ob_start();?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
  COUCOU

  </div>
</div>
  <?php
$content = ob_get_clean();
require 'controller/view/frontend/template.php';?>