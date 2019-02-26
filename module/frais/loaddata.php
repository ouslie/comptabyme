<?php
$Frais = new Frais;
$Categories = new Categories;
$grid = new EditableGrid();
$base = $_SESSION['activebase'];

$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('name', 'Nom', 'string', null, true);
$grid->addColumn('comment', 'Commentaires', 'string', null, true);
$grid->addColumn('debcontrat', 'Date de début', 'date', null, true);
$grid->addColumn('endcontrat', 'Date de fin', 'date', null, true);
$grid->addColumn('paymentdate', 'Date de paiement', 'date', null, true);
$grid->addColumn('amount', 'Montant', 'float', null, false);
$grid->addColumn('id_cat', 'Cat', 'string', null, false);
$grid->addColumn('editfrais', 'Action', 'html', null, false, 'id');

//error_log(print_r($_GET, true));
$base = $_SESSION['activebase'];
$query = "SELECT date_format(debcontrat, '%d/%m/%Y') as debcontrat,date_format(endcontrat, '%d/%m/%Y') as endcontrat,date_format(paymentdate, '%d/%m/%Y') as paymentdate ,id, id_cat, id_base, name,comment, amount FROM frais WHERE id_base = $base";
$queryCount = "SELECT count(id) as nb FROM frais WHERE id_base = $base";

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

//error_log("pageCount = " . ceil($total / $rowByPage));
//error_log("total = " . $total);
//error_log("totalUnfiltered = " . $totalUnfiltered);

$grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);


//error_log($query);
$result = $Frais->Loaddata($query);

// close PDO
$pdo = null;

// send data to the browser
$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
