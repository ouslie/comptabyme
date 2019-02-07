<?php
$return = false;

$Items = new Items;
$return = $Items->Delete($_POST['id']);

echo $return ? "ok" : "error";