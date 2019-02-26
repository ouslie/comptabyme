<?php
$return = false;
$Sscategories = new Sscategories;
$return = $Sscategories->Set($_POST['name'],$_POST['id_category_parent'],$_SESSION['activebase']);
echo $return ? "ok" : "error";