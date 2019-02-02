<?php
$FactureManager = new FactureManager;

$Facture = $FactureManager->GetFacture($_GET['id_fact']);
$Client = $FactureManager->GetClient($_GET['id_fact']);

$JobManager = new JobManager;



$id_transaction = $JobManager->AddTransaction($Facture['date'],1,$Facture['id_category'],$Client['name'],$Facture['num'],$Facture['solde'],0,$Facture['id_bank'],0,$_SESSION['activebase']);

echo $id_transaction;

$FactureManager->SetTransactionFacture($id_transaction,$_GET['id_fact']);
