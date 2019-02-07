<?php
$return = false;

$Contrats = new Contrats;
$return = $Contrats->Delete($_POST['id']);

echo $return ? "ok" : "error";
