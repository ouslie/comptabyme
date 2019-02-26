<?php
$return = false;
$Frais = new Frais;

$name = $_POST['name'];
$comment = $_POST['comment'];
$debcontrat = $_POST['debcontrat'];
$endcontrat = $_POST['endcontrat'];


$Categories = new Categories;
$id_cat_frais = $Categories->GetFrais($_SESSION['activebase']);


$return = $Frais->Set($name,$debcontrat,$endcontrat,$id_cat_frais['id'], $comment,$_SESSION['activebase']);
echo $return ? "ok" : "error";
