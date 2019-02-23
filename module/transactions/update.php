<?php
$Transactions = new Transactions;
$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];

$return = false;

if ($colname == "amount") {
    $value = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    $result = $Transactions->GetType($id);
    if ($result['0']['id_type'] == 2) {
        if ((substr($value, 0, 1))=="-"){
        } else {
            $value = -$value;
        }
    }
}

if ($colname == "date2") {
    $colname = "date";
}

// Here, this is a little tips to manage date format before update the table
if ($coltype == 'date') {
    //echo $value;
    if ($value === "") {
        $value = null;
    } else {
        $date_info = date_parse_from_format('d/m/Y', $value);
        $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
        echo $value;
    }
}

$return = $Transactions->Update($colname, $value, $id);
echo $return ? "ok" : "error";
