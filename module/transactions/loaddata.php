<?php
$Transactions = new Transactions;
$Categories = new Categories;
$Bank = new Bank;
$Frais = new Frais;

$grid = new EditableGrid();
$base = $_SESSION['activebase'];

$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('date2', 'Date', 'date');
$grid->addColumn('id_type', 'Type', 'string',["2" => "Dépense","1" => "Recette"], true);
$grid->addColumn('id_category', 'Catégorie', 'string', $Categories->ListAllMy($base), true);
$grid->addColumn('third', 'Tiers', 'string');
$grid->addColumn('comment', 'Commentaire', 'string');
$grid->addColumn('amount', 'Montant', 'float');
$grid->addColumn('tally', 'Pointage', 'boolean');
$grid->addColumn('id_bank', 'Banque', 'string', $Bank->ListMyWithoutSys($base), true);
if ($_SESSION['activecontrats'] == 1) 
{
    $grid->addColumn('id_contrat', 'Note de frais', 'string', $Frais->ListMy($base), true);
}
$grid->addColumn('action', 'Action', 'html', null, false, 'id');

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'transactions';

error_log(print_r($_GET, true));
$base = $_SESSION['activebase'];
$query = "SELECT id, third, comment, id_type, amount, tally, id_bank, id_category, id_base, date_format(date, '%d/%m/%Y') as date2, date, id_contrat FROM $mydb_tablename WHERE id_base = $base";
$queryCount = "SELECT count(id) as nb FROM $mydb_tablename WHERE id_base = $base";

$totalUnfiltered = $Transactions->Loaddata($queryCount)->fetch()[0];
$total = $totalUnfiltered;

$page = 0;
if (isset($_GET['page']) && is_numeric($_GET['page'])) 
{
    $page = (int) $_GET['page'];
}

$rowByPage = 20;
$from = ($page - 1) * $rowByPage;

if (isset($_GET['filter']) && $_GET['filter'] != "") 
{
    $filter = $_GET['filter'];
    $query .= ' AND third like "%'.$filter.'%"';
    $queryCount .= ' AND third like "%'.$filter.'%"';
    $total = $Transactions->Loaddata($queryCount)->fetch()[0];
}

if ($_GET['sort'] == "date2") {$_GET['sort'] = "date";}
if (isset($_GET['sort']) && $_GET['sort'] != "") 
{
    $query .= " ORDER BY " . $_GET['sort'] . ($_GET['asc'] == "0" ? " DESC " : "");
} else {
    $query .= " ORDER BY date DESC";

}

$query .= " LIMIT " . $from . ", " . $rowByPage;

error_log("pageCount = " . ceil($total / $rowByPage));
error_log("total = " . $total);
error_log("totalUnfiltered = " . $totalUnfiltered);

$grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);
error_log($query);
$result = $Transactions->Loaddata($query);

// envoie data
$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
