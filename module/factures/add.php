<?php
$return = false;
$Factures = new Factures;

$id_category = $_POST['id_category'];
$id_client = $_POST['id_client'];
$date = $_POST['date'];
$base = $_SESSION['activebase'];
$id_facture = $Factures->Set($date,$id_client,$id_category,NULL,$base);
echo $id_facture;

$num = date_create($date); 
$year = date_format($num, 'Y');
$month = date_format($num, 'm');
$num_fact = $year .'-' . $month . str_pad($id_facture, 2, '0', STR_PAD_LEFT);

$id_facture = $Factures->SetNumFacture($id_facture,$num_fact);