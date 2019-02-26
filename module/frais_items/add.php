<?php
$return = false;
$Frais = new Frais;
$id_notefrais = $_GET['id_notefrais'];

$date = $_POST['date'];
$id_category_child_frais = $_POST['id_category_child_frais'];
$third = $_POST['third'];
$amount = $_POST['amount'];
$id_bank = $_POST['id_bank'];
$amount = floatval(str_replace(',', '.', str_replace('.', '', -$amount)));


$Categories = new Categories;
$id_cat_frais = $Categories->GetFrais($_SESSION['activebase']);

$id_items = $Frais->SetItems($id_notefrais,$date,$id_category_child_frais,$third,$amount);

$Transactions = new Transactions;
$id_transaction = $Transactions->Set($third,NULL,$id_cat_frais['id'],$id_bank,2,$id_notefrais,$amount,$date,0,$_SESSION['activebase']);

$return = $Frais->SetTransactionItems($id_transaction,$id_items);

$soldefrais= $Frais->SumItems($id_notefrais);
$Frais->SetSoldeFrais($soldefrais['total'],$id_notefrais);

echo $return ? "ok" : "error";
