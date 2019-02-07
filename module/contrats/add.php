<?php
$return = false;
$Contrats = new Contrats;

$name = $_POST['name'];
$debcontrat = $_POST['debcontrat'];
$endcontrat = $_POST['endcontrat'];
$id_cat = $_POST['id_cat'];
$salaire = $_POST['salaire'];
$salaire = floatval(str_replace(',', '.', str_replace('.', '',$salaire)));

$return = $Contrats->Set($name,$debcontrat,$endcontrat,$id_cat,$salaire,$_SESSION['activebase']);
echo $return ? "ok" : "error";
