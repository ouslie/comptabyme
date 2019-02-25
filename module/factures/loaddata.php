<?php
$Factures = new Factures;
$Clients = new Clients;
$Categories = new Categories;

$grid = new EditableGrid();

$base = $_SESSION['activebase'];

$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('num', 'Numéro', 'string', null, false);
$grid->addColumn('date', 'Date', 'date','null','true');
$grid->addColumn('id_client', 'Clients', 'string', $Clients->ListMy($base), true);
$grid->addColumn('id_category', 'Catégorie', 'string',$Categories->ListRecetteMy($base), true);
$grid->addColumn('solde', 'Solde', 'string', null, false);
$grid->addColumn('date_payment', 'Date paiement', 'date');
$moyen = [ "Virement" => "Virement", "Paypal" => "Paypal" ];
$grid->addColumn('moyen_payment', 'Moyen', 'string', $moyen, true);
$grid->addColumn('id_transaction', 'Transaction', 'string', null, false);
$grid->addColumn('edit', 'Action', 'html', null, false, 'id');

error_log(print_r($_GET, true));
$base = $_SESSION['activebase'];
$query = "SELECT id,num, date_format(date, '%d/%m/%Y') as date, id_client, id_category, solde, date_format(date_payment, '%d/%m/%Y') as date_payment, id_transaction, moyen_payment FROM factures WHERE id_base = $base";
$queryCount = "SELECT count(id) as nb FROM factures WHERE id_base = $base";

$totalUnfiltered = $Factures->Loaddata($queryCount)->fetch()[0];
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
    $query .= '  AND id_client like "%' . $filter . '%"';
    $queryCount .= '  AND id_client like "%' . $filter . '%"';
    $total = $Factures->Loaddata($queryCount)->fetch()[0];
}

if (isset($_GET['sort']) && $_GET['sort'] != "") {
    $query .= " ORDER BY " . $_GET['sort'] . ($_GET['asc'] == "0" ? " DESC " : "");
} else {
    $query .= " ORDER BY date DESC";

}

$query .= " LIMIT " . $from . ", " . $rowByPage;

error_log("pageCount = " . ceil($total / $rowByPage));
error_log("total = " . $total);
error_log("totalUnfiltered = " . $totalUnfiltered);

$grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);

/* END SERVER SIDE */

error_log($query);
//echo $query
$result = $Factures->Loaddata($query);

// send data to the browser

$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
