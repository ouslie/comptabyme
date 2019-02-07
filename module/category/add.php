<?php
$return = false;
$Categories = new Categories;
$is_recette = $_POST['is_recette'];

$return = $Categories->Set($_POST['name'],$is_recette,$_SESSION['activebase']);
echo $return ? "ok" : "error";