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
$id_transaction= $_POST['id_transaction'];




// Here, this is a little tips to manage date format before update the table
if ($coltype == 'date') {
    //echo $value;
    if ($value === "") {
        $value = null;
    } else {
        $date_info = date_parse_from_format('d/m/Y', $value);
        $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
        echo $value;
    }
}

if($colname == "date_payment") {
      $colname = "date";
      $requete = $pdo->prepare("UPDATE demo SET
      tally = 1, date = :date
       WHERE id = :idvalue
		");
$requete->bindValue(':date', $value);
$requete->bindValue(':idvalue', $id_transaction);
$requete->execute();
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
