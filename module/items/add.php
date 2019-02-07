<?php
$return = false;
$Items = new Items;

$designation = $_POST['designation'];
$amount = $_POST['amount'];
$quantity = $_POST['quantity'];
$id_fact = $_GET['id_fact'];
$base = $_SESSION['activebase'];
$amount = floatval(str_replace(',', '.', str_replace('.', '',$amount)));

$return = $Items->Set($designation,$quantity,$amount,$id_fact);

$Factures = new Factures;
$soldefacture = $Factures->SumItems($id_fact);
$Factures->SetSoldeFacture($soldefacture['total'],$id_fact);


echo $return ? "ok" : "error";