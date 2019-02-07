<?php
$return = false;

$Clients = new Clients;
$return = $Clients->Delete($_POST['id']);

echo $return ? "ok" : "error";
