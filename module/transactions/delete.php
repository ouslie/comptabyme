<?php
$return = false;

$Transactions = new Transactions;
$return = $Transactions->Delete($_POST['id']);

echo $return ? "ok" : "error";
