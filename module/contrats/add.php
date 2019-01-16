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
$name = $_POST['name'];
$debcontrat = $_POST['debcontrat'];
$endcontrat = $_POST['endcontrat'];
$paymentdate = $_POST['paymentdate'];
$id_cat = $_POST['id_cat'];
$salaire = $_POST['salaire'];

$salaire = floatval(str_replace(',', '.', str_replace('.', '',$salaire)));

$return = false;

$requete = $pdo->prepare("INSERT INTO contrats SET
		name = :name,
		debcontrat = :debcontrat,
		endcontrat= :endcontrat,
		paymentdate = :paymentdate,
		id_cat = :id_cat,
		salaire = :salaire,
		id_base= :id_base
		");

$requete->bindValue(':name', $name);
$requete->bindValue(':debcontrat', $debcontrat);
$requete->bindValue(':endcontrat', $endcontrat);
$requete->bindValue(':paymentdate', $paymentdate);
$requete->bindValue(':id_cat', $id_cat);
$requete->bindValue(':salaire', $salaire);
$requete->bindValue(':id_base', $_SESSION['activebase']);

$return = $requete->execute();
$requete = null;

echo $return ? "ok" : "error";
