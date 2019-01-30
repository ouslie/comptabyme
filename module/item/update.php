<?php

/*
 *
 * This file is part of EditableGrid.
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */

$pdo = PDO2::getInstance();
$pdo->exec("set names utf8");

// Get all parameters provided by the javascript

$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];

if ($colname == "solde") { $value = floatval(str_replace(',', '.', str_replace('.', '',$value)));
}

// This very generic. So this script can be used to update several tables.
$return = false;

$requete = $pdo->prepare("UPDATE factures SET
      " . $colname . " = :colnamevalue
       WHERE id = :idvalue
		");

$requete->bindValue(':colnamevalue', $value);
$requete->bindValue(':idvalue', $id);

$return = $requete->execute();
$requete = null;
echo $return ? "ok" : "error";
