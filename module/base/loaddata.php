<?php

/*
 * examples/mysql/loaddata.php
 *
 * This file is part of EditableGrid.
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */

/**
 * This script loads data from the database and returns it to the js
 *
 */
include '../../global/config.php';
include '../../model/EditableGrid.php';
require_once '../../lib/pdo2.php';

$pdo = PDO2::getInstance();
$pdo->exec("set names utf8");

/**
 * fetch_pairs is a simple method that transforms a mysqli_result object in an array.
 * It will be used to generate possible values for some columns.
 */
function fetch_pairs($pdo, $query)
{
    if (!($res = $pdo->query($query))) {
        return false;
    }

    $rows = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $first = true;
        $key = $value = null;
        foreach ($row as $val) {
            if ($first) {$key = $val;
                $first = false;} else { $value = $val;
                break;}
        }
        $rows[$key] = $value;
    }
    return $rows;
}

$grid = new EditableGrid();

/*
 *  Add columns. The first argument of addColumn is the name of the field in the databse.
 *  The second argument is the label that will be displayed in the header
 */
$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('name', 'Nom', 'string');
$grid->addColumn('defaultbase', 'Base par défaut', 'boolean');
$grid->addColumn('activeca', 'Module CA', 'boolean');
$grid->addColumn('activecontrats', 'Module contrats', 'boolean');
$grid->addColumn('compagnyname', 'Société', 'string');
$grid->addColumn('compagnyadress', 'Adresse', 'string');
$grid->addColumn('compagnymail', 'Mail', 'string');
$grid->addColumn('compagnyphone', 'Téléphone', 'string');
$grid->addColumn('compagnyweb', 'Web', 'string');
$grid->addColumn('iban', 'iban', 'string');
$grid->addColumn('bic', 'bic', 'string');
$grid->addColumn('paypal', 'paypal', 'string');
$grid->addColumn('logo', 'logo', 'string');

//$grid->addColumn('action', 'Action', 'html', null, false, 'id');

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'base';

error_log(print_r($_GET, true));
$id_user = $_SESSION['id'];
$query = "SELECT * FROM $mydb_tablename WHERE id_user = $id_user";
$queryCount = "SELECT count(id) as nb FROM $mydb_tablename WHERE id_user = $id_user";

$totalUnfiltered = $pdo->query($queryCount)->fetch()[0];
$total = $totalUnfiltered;

$page = 0;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int) $_GET['page'];
}
if (isset($_GET['sort']) && $_GET['sort'] != "") 
{
    $query .= " ORDER BY " . $_GET['sort'] . ($_GET['asc'] == "0" ? " DESC " : "");
}

$rowByPage = 50;

$from = ($page - 1) * $rowByPage;

if (isset($_GET['filter']) && $_GET['filter'] != "") {
    $filter = $_GET['filter'];
    $query .= '  AND name  like "%' . $filter . '%"';
    $queryCount .= '  AND name  like "%' . $filter . '%"';
    $total = $pdo->query($queryCount)->fetch()[0];
}


$query .= " LIMIT " . $from . ", " . $rowByPage;

error_log("pageCount = " . ceil($total / $rowByPage));
error_log("total = " . $total);
error_log("totalUnfiltered = " . $totalUnfiltered);

$grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);

/* END SERVER SIDE */

error_log($query);
//echo $query
$result = $pdo->query($query);

// close PDO
$pdo = null;

// send data to the browser

$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
