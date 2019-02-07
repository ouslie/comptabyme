<?php
$return = false;

$Categories = new Categories;
$return = $Categories->Delete($_POST['id']);

echo $return ? "ok" : "error";
