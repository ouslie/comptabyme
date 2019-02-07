<?php
$Bank = new Bank;
$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];

if ($colname == "solde") { $value = floatval(str_replace(',', '.', str_replace('.', '',$value)));
}
$return = false;

$return = $Bank->Update($colname,$value,$id);
echo $return ? "ok" : "error";
