<?php

$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];
$id_transaction= $_POST['id_transaction'];
$Transactions = new Transactions;
$Factures = new Factures;
$return = false;

if ($coltype == 'date') {
    if ($value === "") {
        $value = null;
    } else {
        $date_info = date_parse_from_format('d/m/Y', $value);
        $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
    }
}

if($colname == "date_payment") {
    if ($id_transaction == 0){
       $return = 0;
    } else {
        echo $id_transaction;
       $return = $Transactions->UpdateDateFacture($id_transaction,1,$value);
       $return = $Factures->Update($colname,$value,$id);

    }
}

if($colname == "id_client" ||$colname == "id_category" || $colname == "date" 
    ) {
        $return = $Factures->Update($colname,$value,$id);

    }


echo $return ? "ok" : "error";
