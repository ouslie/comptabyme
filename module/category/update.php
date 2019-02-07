<?php
$Categories = new Categories;
$colname = $_POST['colname'];
$id = $_POST['id'];
$coltype = $_POST['coltype'];
$value = $_POST['newvalue'];
$tablename = $_POST['tablename'];

$return = false;

$return = $Categories->Update($colname,$value,$id);
echo $return ? "ok" : "error";
