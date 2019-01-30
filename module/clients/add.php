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
$address = $_POST['address'];
$cp = $_POST['cp'];
$city = $_POST['city'];

$return = false;

$requete = $pdo->prepare("INSERT INTO clients SET
		name = :name,
		address = :address,
		cp = :cp,
		city = :city,
		id_base= :id_base
		");

$requete->bindValue(':name', $name);
$requete->bindValue(':address', $address);
$requete->bindValue(':cp', $cp);
$requete->bindValue(':city', $city);
$requete->bindValue(':id_base', $_SESSION['activebase']);

$return = $requete->execute();

$requete = null;




echo $return ? "ok" : "error";
