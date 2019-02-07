<?php
$name = $_POST['name'];
$solde = $_POST['solde'];
$solde = floatval(str_replace(',', '.', str_replace('.', '',$solde)));

$return = false;
$Bank = new Bank;

$id_bank = $Bank->Set($name,$solde,0,$_SESSION['activebase']);

AddAccount($id_bank);

echo $id_bank ? "ok" : "error";
