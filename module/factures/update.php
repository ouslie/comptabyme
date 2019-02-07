<?php

$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];
$id_transaction= $_POST['id_transaction'];

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

if($colname == "date_payment") {
      $requete = $pdo->prepare("UPDATE demo SET
      tally = 1, date = :date
       WHERE id = :idvalue
		");
$requete->bindValue(':date', $value);
$requete->bindValue(':idvalue', $id_transaction);
$requete->execute();
}

// This very generic. So this script can be used to update several tables.
$return = false;

$requete = $pdo->prepare("UPDATE factures SET
      " . $colname . " = :colnamevalue
       WHERE id = :idvalue
		");

$requete->bindValue(':colnamevalue', $value);
$requete->bindValue(':idvalue', $id);

$return = $requete->execute();
$requete = null;
echo $return ? "ok" : "error";
