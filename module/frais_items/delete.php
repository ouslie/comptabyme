<?php
$return = false;

$Frais = new Frais;
$id_transaction = $Frais->GetItemsIdTransaction($_POST['id']);

$return = $Frais->DeleteItems($_POST['id']);
$id_notefrais = $_GET['id_notefrais'];

$soldenotefrais = $Frais->SumItems($id_notefrais);
$Frais->SetSoldeFrais($soldenotefrais['total'],$id_notefrais);

$Transactions = new Transactions;
$Transactions->Delete($id_transaction['id_transaction']);

echo $return ? "ok" : "error";
