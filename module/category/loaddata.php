<?php

$Categories = new Categories;
$grid = new EditableGrid();

$base = $_SESSION['activebase'];

$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('name', 'Nom', 'string', null, true);
$grid->addColumn('is_recette', 'Est une recette ?', 'boolean');
$grid->addColumn('is_internal', 'Est une catégorie interne ?', 'boolean');
$grid->addColumn('action', 'Action', 'html', null, false, 'id');
$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'category';

error_log(print_r($_GET, true));
$base = $_SESSION['activebase'];
$query = "SELECT * FROM $mydb_tablename WHERE id_base = $base";
$queryCount = "SELECT count(id) as nb FROM $mydb_tablename WHERE id_base = $base";

$totalUnfiltered = $Categories->Loaddata($queryCount)->fetch()[0];
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
    $query .= '  AND name like "%' . $filter . '%"';
    $queryCount .= '  AND name like "%' . $filter . '%"';
    $total = $Categories->Loaddata($queryCount)->fetch()[0];
}
$query .= " LIMIT " . $from . ", " . $rowByPage;

error_log("pageCount = " . ceil($total / $rowByPage));
error_log("total = " . $total);
error_log("totalUnfiltered = " . $totalUnfiltered);

$grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);

/* END SERVER SIDE */

error_log($query);
//echo $query
$result = $Categories->Loaddata($query);

// close PDO
$pdo = null;

// send data to the browser

$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
