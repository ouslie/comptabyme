<?php

$Clients = new Clients;
$grid = new EditableGrid();

$base = $_SESSION['activebase'];

$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('name', 'Nom', 'string', null, true);
$grid->addColumn('address', 'Adresse', 'string', null, true);
$grid->addColumn('cp', 'Code P', 'string', null, true);
$grid->addColumn('city', 'Ville', 'string', null, true);

$grid->addColumn('action', 'Action', 'html', null, false, 'id');

error_log(print_r($_GET, true));
$base = $_SESSION['activebase'];
$query = "SELECT * FROM clients WHERE id_base = $base";
$queryCount = "SELECT count(id) as nb FROM clients WHERE id_base = $base";

$totalUnfiltered = $Clients->Loaddata($queryCount)->fetch()[0];
$total = $totalUnfiltered;

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
    $total = $Clients->Loaddata()($queryCount)->fetch()[0];
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
$result = $Clients->Loaddata($query);

// close PDO
$pdo = null;

// send data to the browser

$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
