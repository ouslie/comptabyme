<?php
$Frais = new Frais;
$Transactions = new Transactions;
$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];
$id_notefrais = $_GET['id_notefrais'];


if ($coltype == 'date') {
    if ($value === "") {
        $value = null;
    } else {
        $date_info = date_parse_from_format('d/m/Y', $value);
        $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
    }
}


if ($colname == "amount") {
    $value = floatval(str_replace(',', '.', str_replace('.', ',', $value)));
    if ($value > 0) {
        $value = -$value;
    }

}

$return = false;

$return = $Frais->UpdateItems($colname,$value,$id);

$soldenotefrais = $Frais->SumItems($id_notefrais);

$Frais->SetSoldeFrais($soldenotefrais['total'],$id_notefrais);
$id_transaction = $Frais->GetItemsIdTransaction($id);



if($colname == "date" ||$colname == "third" || $colname == "date" || $colname == "amount" ) {
        $return = $Transactions->Update($colname,$value,$id_transaction['id_transaction']);
    }

echo $return ? "ok" : "error";