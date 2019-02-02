<?php
/*
 *
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */

$pdo = PDO2::getInstance();
$pdo->exec("SET GLOBAL sql_mode = NO_ENGINE_SUBSTITUTION");

$pdo->exec("set names utf8");

// Get all parameter provided by the javascript

$designation = $_POST['designation'];
$amount = $_POST['amount'];
$quantity = $_POST['quantity'];
$id_fact = $_GET['id_fact'];

$amount = floatval(str_replace(',', '.', str_replace('.', '',$amount)));

$return = false;
$requete = $pdo->prepare("INSERT INTO items SET
		designation = :designation,
		amount = :amount,
		quantity = :quantity,
		id_facture = :id_fact
		");
$requete->bindValue(':designation', $designation);
$requete->bindValue(':amount', $amount);
$requete->bindValue(':quantity', $quantity);
$requete->bindValue(':id_fact', $id_fact);
$return = $requete->execute();
$requete = null;

$FactureManager = new FactureManager;
$soldefacture = $FactureManager->SumItems($id_fact);
$FactureManager->SetSoldeFacture($soldefacture['total'],$id_fact);


echo $return ? "ok" : "error";