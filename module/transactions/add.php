<?php
$Transactions = new Transactions;

if (isset($_GET['category'])) {
    if ($_GET['category'] == 'internal') {

		$amount = $_POST['amountinternal'];
        $dateinternal = $_POST['dateinternal'];
        $tallyinternal = $_POST['tallyinternal'];
        $id_bank_recette = $_POST['id_bank_recette'];
        $id_bank_depense = $_POST['id_bank_depense'];
        $amount = floatval(str_replace(',', '.', str_replace('.', '', $amount)));

		$return = false;
		$Categories = new Categories;
		$id_categoryinternal = $Categories->GetInternal($_SESSION['activebase']);
		$id_categoryinternal = $id_categoryinternal['id'];
        $return = $Transactions->Set('Interne', NULL, $id_categoryinternal, $id_bank_recette, 1, NULL, $amount, $dateinternal, $tallyinternal, $_SESSION['activebase']);
		$return = $Transactions->Set('Interne', NULL, $id_categoryinternal, $id_bank_depense, 2, NULL, -$amount, $dateinternal, $tallyinternal, $_SESSION['activebase']);

		echo $return ? "ok" : "error";

    }
} else {
    $third = $_POST['third'];
    $comment = $_POST['comment'];
    $id_category = $_POST['id_category'];
    $id_bank = $_POST['id_bank'];
    $id_type = $_POST['id_type'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $tally = $_POST['tally'];

    if (!isset($_POST['id_contrat'])) {
        $id_contrat = null;
    } else {
        $id_contrat = $_POST['id_contrat'];
    }

    $amount = floatval(str_replace(',', '.', str_replace('.', '', $amount)));

    if ($id_type == 2) {
        $amount = -$amount;
    }

    $return = false;
    $return = $Transactions->Set($third, $comment, $id_category, $id_bank, $id_type, $id_contrat, $amount, $date, $tally, $_SESSION['activebase']);
    echo $return ? "ok" : "error";
}
