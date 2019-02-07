<?php
$Contrats = new Contrats;
$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];

$return = false;

$return = $Contrats->Update($colname,$value,$id);
echo $return;
echo $return ? "ok" : "error";
