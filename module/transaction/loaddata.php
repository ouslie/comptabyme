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
function fetch_pairs($pdo,$query){
	if (!($res = $pdo->query($query)))return FALSE;
	$rows = array();
	while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
		$first = true;
		$key = $value = null;
		foreach ($row as $val) {
			if ($first) { $key = $val; $first = false; }
			else { $value = $val; break; }
		}
		$rows[$key] = $value;
	}
	return $rows;
}


// Database connection

// create a new EditableGrid object
$grid = new EditableGrid();

/*
*  Add columns. The first argument of addColumn is the name of the field in the databse.
*  The second argument is the label that will be displayed in the header
*/
$grid->addColumn('id', 'ID', 'integer', NULL, false);
$grid->addColumn('date', 'Date', 'date');
$grid->addColumn('id_type', 'Type', 'string', fetch_pairs($pdo,'SELECT id, name FROM type'),true );
$grid->addColumn('id_category', 'Categorie', 'string', fetch_pairs($pdo,'SELECT id, name FROM category'),true );
$grid->addColumn('id_sscategory', 'Sous Categorie', 'string', fetch_pairs($pdo,'SELECT id, name FROM sscategory'),true );
$grid->addColumn('third', 'Tiers', 'string');
$grid->addColumn('comment', 'Commentaire', 'string');
$grid->addColumn('amount', 'Montant', 'float');
$grid->addColumn('tally', 'Pointage', 'boolean');
$grid->addColumn('id_bank', 'Banque', 'string' , fetch_pairs($pdo,'SELECT id, name FROM bank'),true);
$grid->addColumn('action', 'Action', 'html', NULL, false, 'id');

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'demo';


error_log(print_r($_GET,true));
$base = $_SESSION['activebase'];
$query = "SELECT *, date_format(date, '%d/%m/%Y') as date FROM $mydb_tablename WHERE id_base = $base";
$queryCount = "SELECT count(id) as nb FROM $mydb_tablename WHERE id_base = $base";

$totalUnfiltered =$pdo->query($queryCount)->fetch()[0];
$total = $totalUnfiltered;
//print_r($total);
/* SERVER SIDE */
/* If you have set serverSide : true in your Javascript code, $_GET contains 3 additionnal parameters : page, filter, sort
 * this parameters allow you to adapt your query
 *
 */
$page=0;
if ( isset($_GET['page']) && is_numeric($_GET['page'])  )
  $page =  (int) $_GET['page'];


$rowByPage=5;

$from= ($page-1) * $rowByPage;

if ( isset($_GET['filter']) && $_GET['filter'] != "" ) {
  $filter =  $_GET['filter'];
  $query .= '  WHERE third like "%'.$filter.'%"';
  $queryCount .= '  WHERE third like "%'.$filter.'%"';
  $total = $pdo->query($queryCount)->fetch()[0];
}

if ( isset($_GET['sort']) && $_GET['sort'] != "" )
  $query .= " ORDER BY " . $_GET['sort'] . (  $_GET['asc'] == "0" ? " DESC " : "" );


$query .= " LIMIT ". $from. ", ". $rowByPage;

error_log("pageCount = " . ceil($total/$rowByPage));
error_log("total = " .$total);
error_log("totalUnfiltered = " .$totalUnfiltered);

$grid->setPaginator(ceil($total/$rowByPage), (int) $total, (int) $totalUnfiltered, null);

/* END SERVER SIDE */

error_log($query);
$result = $pdo->query($query);

// close PDO
$pdo = null;

// send data to the browser

$grid->renderJSON($result,false, false, !isset($_GET['data_only']));
