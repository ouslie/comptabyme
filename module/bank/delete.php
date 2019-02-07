<?php
$return = false;

$Bank = new Bank;
$return = $Bank->Delete($_POST['id']);

echo $return ? "ok" : "error";