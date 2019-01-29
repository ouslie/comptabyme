<?php
include '../../global/config.php';
include '../../model/EditableGrid.php';
require_once '../../lib/pdo2.php';

$pdo = PDO2::getInstance();
$pdo->exec("set names utf8");

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

//$grid->addColumn('id', 'ID', 'integer', null, false);
$grid->addColumn('date2', 'Date', 'date');
$grid->addColumn('id_type', 'Type', 'string', fetch_pairs($pdo, 'SELECT id, name FROM type'), true);
$grid->addColumn('id_category', 'Catégorie', 'string', fetch_pairs($pdo, 'SELECT id, name FROM category WHERE id_base = ' . $_SESSION['activebase'] . ''), true);
$grid->addColumn('third', 'Tiers', 'string');
$grid->addColumn('comment', 'Commentaire', 'string');
$grid->addColumn('amount', 'Montant', 'float');
$grid->addColumn('tally', 'Pointage', 'boolean');
$base = $_SESSION['activebase'];
$sql = "SELECT id, name FROM bank WHERE id_base = $base AND system = 0";
$grid->addColumn('id_bank', 'Banque', 'string', fetch_pairs($pdo, $sql), true);
if ($_SESSION['activecontrats'] == 1) 
{
    $grid->addColumn('id_contrat', 'Contrats', 'string', fetch_pairs($pdo, 'SELECT id, name FROM contrats WHERE id_base = ' . $_SESSION['activebase'] . ''), true);
}
$grid->addColumn('action', 'Action', 'html', null, false, 'id');

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'demo';

error_log(print_r($_GET, true));
$base = $_SESSION['activebase'];
$query = "SELECT id, third, comment, id_type, amount, tally, id_bank, id_category, id_base, date_format(date, '%d/%m/%Y') as date2, date, id_contrat FROM $mydb_tablename WHERE id_base = $base";
$queryCount = "SELECT count(id) as nb FROM $mydb_tablename WHERE id_base = $base";

$totalUnfiltered = $pdo->query($queryCount)->fetch()[0];
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
    $total = $pdo->query($queryCount)->fetch()[0];
}

if ($_GET['sort'] == "date2") {$_GET['sort'] = "date";}
if (isset($_GET['sort']) && $_GET['sort'] != "") 
{
    $query .= " ORDER BY " . $_GET['sort'] . ($_GET['asc'] == "0" ? " DESC " : "");
}

$query .= " LIMIT " . $from . ", " . $rowByPage;

error_log("pageCount = " . ceil($total / $rowByPage));
error_log("total = " . $total);
error_log("totalUnfiltered = " . $totalUnfiltered);

$grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);
error_log($query);
$result = $pdo->query($query);

// close PDO
$pdo = null;

// envoie data
$grid->renderJSON($result, false, false, !isset($_GET['data_only']));
