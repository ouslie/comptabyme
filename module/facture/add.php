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

$pdo->exec("set names utf8");

// Get all parameter provided by the javascript
$solde = $_POST['solde'];

$solde = floatval(str_replace(',', '.', str_replace('.', '',$solde)));

$return = false;

$requete = $pdo->prepare("INSERT INTO facture SET
		solde = :solde,
		id_base= :id_base,
		system = 0
		");

$requete->bindValue(':solde', $solde);

$requete->bindValue(':id_base', $_SESSION['activebase']);

$return = $requete->execute();

$data = $pdo->lastInsertId();

AddAccount($data);


$requete = null;




echo $return ? "ok" : "error";
