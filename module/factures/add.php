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

$id_category = $_POST['id_category'];
$id_bank = $_POST['id_bank'];
$id_client = $_POST['id_client'];
$solde = $_POST['solde'];
$date = $_POST['date'];

$solde = floatval(str_replace(',', '.', str_replace('.', '',$solde)));

$return = false;

$requete = $pdo->prepare("INSERT INTO factures SET
		id_category = :id_category,
		id_client = :id_client,
		id_bank = :id_bank,
		solde = :solde,
		date = :date,
		id_base= :id_base
		");

$requete->bindValue(':id_category', $id_category);
$requete->bindValue(':id_client', $id_client);
$requete->bindValue(':id_bank', $id_bank);
$requete->bindValue(':solde', $solde);
$requete->bindValue(':date', $date);
$requete->bindValue(':id_base', $_SESSION['activebase']);
$return = $requete->execute();
$data = $pdo->lastInsertId();
$requete = null;
echo $return ? "ok" : "error";

header('Location: index.php?module=item&action=list&id='.$data.'');
header('Location: https://google.fr');
