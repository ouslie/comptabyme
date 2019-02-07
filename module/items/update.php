<?php
$Items = new Items;
$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];
$id_fact = $_GET['id_fact'];

$return = false;

$return = $Items->Update($colname,$value,$id);


$Factures = new Factures;
$soldefacture = $Factures->SumItems($id_fact);
$Factures->SetSoldeFacture($soldefacture['total'],$id_fact);
echo $return ? "ok" : "error";
