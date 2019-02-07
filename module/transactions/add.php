<?php
$Transactions = new Transactions;

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
$return = $Transactions->Set($third, $comment, $id_category, $id_bank, $id_type, $id_contrat, $amount, $date,$tally, $_SESSION['activebase']);
echo $return ? "ok" : "error";