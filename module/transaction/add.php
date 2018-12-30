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

// Get all parameter provided by the javascript
$third = $_POST['third'];
$comment = $_POST['comment'];
$id_category = $_POST['id_category'];
$id_bank = $_POST['id_bank'];
$id_type = $_POST['id_type'];
$amount = $_POST['amount'];
$date = $_POST['date'];

$return=false;

$requete = $pdo->prepare("INSERT INTO demo SET
		third = :third,
		comment = :comment,
		id_category = :id_category,
		id_bank = :id_bank,
		id_type = :id_type,
		amount = :amount,
		date = :date,
		id_base= :id_base
		");

	$requete->bindValue(':third', $third);
	$requete->bindValue(':comment', $comment);
    $requete->bindValue(':id_category', $id_category);
    $requete->bindValue(':id_bank', $id_bank);
	$requete->bindValue(':id_type', $id_type);
	$requete->bindValue(':amount', $amount);
	$requete->bindValue(':date', $date);
	$requete->bindValue(':id_base', $_SESSION['activebase']);


	$return = $requete->execute();
	$requete = null;


	echo $return ? "ok" : "error";
