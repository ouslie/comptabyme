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


$return = false;

$requete = $pdo->prepare("INSERT INTO category SET
		name = :name,
		id_base= :id_base
		");

$requete->bindValue(':name', $name);
$requete->bindValue(':id_base', $_SESSION['activebase']);

$return = $requete->execute();
$requete = null;

echo $return ? "ok" : "error";
