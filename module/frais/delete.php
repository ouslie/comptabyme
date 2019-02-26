<?php
$return = false;

$Frais = new Frais;
$return = $Frais->Delete($_POST['id']);

echo $return ? "ok" : "error";
