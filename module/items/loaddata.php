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
$id_facture = $_GET['id_fact'];
$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('designation', 'Désignation', 'integer', null, false);
$grid->addColumn('quantity', 'Quantité', 'string', null, true);
$grid->addColumn('amount', 'Montant', 'string', null, true);
$grid->addColumn('action', 'Action', 'html', null, false, 'id');
$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'items';

error_log(print_r($_GET, true));
$base = $_SESSION['activebase'];
$query = "SELECT * FROM $mydb_tablename WHERE id_facture = $id_facture ";
$queryCount = "SELECT count(id) as nb FROM $mydb_tablename WHERE id_facture = $id_facture";

$totalUnfiltered = $pdo->query($queryCount)->fetch()[0];
$total = $totalUnfiltered;

/* SERVER SIDE */
/* If you have set serverSide : true in your Javascript code, $_GET contains 3 additionnal parameters : page, filter, sort
 * this parameters allow you to adapt your query
 *
 */
$page = 0;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int) $_GET['page'];
}

$rowByPage = 50;

$from = ($page - 1) * $rowByPage;

if (isset($_GET['filter']) && $_GET['filter'] != "") {
    $filter = $_GET['filter'];
    $query .= '  WHERE third like "%' . $filter . '%"';
    $queryCount .= '  WHERE third like "%' . $filter . '%"';
    $total = $pdo->query($queryCount)->fetch()[0];
}

if (isset($_GET['sort']) && $_GET['sort'] != "") {
    $query .= " ORDER BY " . $_GET['sort'] . ($_GET['asc'] == "0" ? " DESC " : "");
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
