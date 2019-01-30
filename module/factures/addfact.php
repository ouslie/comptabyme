<?php ob_start();?>

    
<?php
$content = ob_get_clean();
require_once('controller/view/frontend/template.php');?>