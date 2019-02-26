<?php
$Frais = new Frais;
$Sscategories = new Sscategories;
$grid = new EditableGrid();
$id_notefrais = $_GET['id_notefrais'];
$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('date', 'Date', 'date', null, true);
$grid->addColumn('id_category', 'Catégorie', 'string', $Sscategories->ListAllMyChildFrais($id_notefrais), true);
$grid->addColumn('third', 'Tiers', 'string', null, true);
$grid->addColumn('amount', 'Montant', 'string', null, true);
$grid->addColumn('id_transaction', 'Transaction', 'string', null, false);
$grid->addColumn('action', 'Action', 'html', null, false, 'id');

//error_log(print_r($_GET, true));
$query = "SELECT date_format(date, '%d/%m/%Y') as date, id, id_category, third, amount, id_transaction FROM frais_items WHERE id_notefrais = $id_notefrais";
$queryCount = "SELECT count(id) as nb FROM frais_items WHERE id_notefrais = $id_notefrais";
$totalUnfiltered = $Frais->Loaddata($queryCount)->fetch()[0];
$total = $totalUnfiltered;

$page = 0;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int) $_GET['page'];
}

$rowByPage = 10;

$from = ($page - 1) * $rowByPage;

if (isset($_GET['filter']) && $_GET['filter'] != "") {
    $filter = $_GET['filter'];
    $query .= '  AND name like "%' . $filter . '%"';
    $queryCount .= '  AND name like "%' . $filter . '%"';
    $total = $Frais->Loaddata($queryCount)->fetch()[0];
}
if ($_GET['sort'] == "date2") {$_GET['sort'] = "date";}
if (isset($_GET['sort']) && $_GET['sort'] != "") {
    $query .= " ORDER BY " . $_GET['sort'] . ($_GET['asc'] == "0" ? " DESC " : "");
}

$query .= " LIMIT " . $from . ", " . $rowByPage;

error_log("pageCount = " . ceil($total / $rowByPage));
error_log("total = " . $total);
error_log("totalUnfiltered = " . $totalUnfiltered);

$grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);


error_log($query);
$result = $Frais->Loaddata($query);
// close PDO
$pdo = null;

// send data to the browser
$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
