<?php ob_start();?>

COUCOU
  <?php
$content = ob_get_clean();
require 'controller/view/frontend/template.php';?>