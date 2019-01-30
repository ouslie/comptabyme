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

// This very generic. So this script can be used to update several tables.
$return = false;
$requete = $pdo->prepare("DELETE FROM clients WHERE id = :idvalue");
$requete->bindValue(':idvalue', $_POST['id']);

$return = $requete->execute();
$requete = null;
echo $return ? "ok" : "error";
