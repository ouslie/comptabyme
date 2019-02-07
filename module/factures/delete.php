<?php
$return = false;

$Factures = new Factures;
$return = $Factures->Delete($_POST['id']);

echo $return ? "ok" : "error";