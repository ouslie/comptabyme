<?php
$return = false;

$Sscategories = new Sscategories;
$return = $Sscategories->Delete($_POST['id']);

echo $return ? "ok" : "error";
