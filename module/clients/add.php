<?php
$return = false;
$Clients = new Clients;

$name = $_POST['name'];
$address = $_POST['address'];
$cp = $_POST['cp'];
$city = $_POST['city'];
$base = $_SESSION['activebase'];
$return = $Clients->Set($name,$address,$cp,$city,$base);

echo $return ? "ok" : "error";
