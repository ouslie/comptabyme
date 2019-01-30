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
$amout = $_POST['amout'];
$quantity = $_POST['quantity'];
$id = $_GET['id_fact'];

echo $id;
$amout = floatval(str_replace(',', '.', str_replace('.', '',$amout)));

$return = false;

$requete = $pdo->prepare("INSERT INTO items SET
		designation = :designation,
		amount = :amount,
		quantity = :quantity
		");
$requete->bindValue(':designation', $designation);
$requete->bindValue(':amount', $amout);
$requete->bindValue(':quantity', $quantity);
$return = $requete->execute();
$requete = null;
echo $return ? "ok" : "error";