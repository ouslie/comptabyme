<?php
$Factures = new Factures;
$Facture = $Factures->GetFacture($_GET['id_fact']);

$Client = $Factures->GetClient($_GET['id_fact']);

$Transactions = new Transactions;
$id_transaction = $Transactions->Set($Client['name'],$Facture['num'],$Facture['id_category'],$Facture['id_bank'],1,null,$Facture['solde'],$Facture['date'],0,$_SESSION['activebase']);

echo $id_transaction;

$Factures->SetTransactionFacture($id_transaction,$_GET['id_fact']);
