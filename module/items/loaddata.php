<?php
$Items = new Items;
$grid = new EditableGrid();
$id_facture = $_GET['id_fact'];
$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('designation', 'Désignation', 'string', null, true);
$grid->addColumn('quantity', 'Quantité', 'string', null, true);
$grid->addColumn('amount', 'Montant', 'string', null, true);
$grid->addColumn('action', 'Action', 'html', null, false, 'id');

error_log(print_r($_GET, true));
$base = $_SESSION['activebase'];
$query = "SELECT * FROM items WHERE id_facture = $id_facture ";
$queryCount = "SELECT count(id) as nb FROM items WHERE id_facture = $id_facture";

$totalUnfiltered = $Items->Loaddata($queryCount)->fetch()[0];
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
    $total = $Items->Loaddata($queryCount)->fetch()[0];
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
$result = $Items->Loaddata($query);

// close PDO
$pdo = null;

// send data to the browser

$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
