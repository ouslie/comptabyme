<?php
$Frais = new Frais;
$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];
if ($coltype == 'date') {
    if ($value === "") {
        $value = null;
    } else {
        $date_info = date_parse_from_format('d/m/Y', $value);
        $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
    }
}
$return = false;

$return = $Frais->Update($colname,$value,$id);
echo $return;
echo $return ? "ok" : "error";
