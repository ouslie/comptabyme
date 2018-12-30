<?php

// Identifiants pour la base de données. Nécessaires à PDO2.
define('SQL_DSN', 'mysql:host=localhost;dbname=demosql');
define('SQL_USERNAME', 'titi');
define('SQL_PASSWORD', 'gQ8$2jh0');
define('CHEMIN_VUE', 'controller/view/frontend/');
define('VIEW', 'controller/view/frontend/');
define('LIB', 'lib/');
define('MODEL', 'model/');
define('MODULE', 'module/');
define('CHEMIN_MODEL', 'model/');

$config = array(
	"db_name" => "demosql",
	"db_user" => "titi",
	"db_password" => "gQ8$2jh0",
	"db_host" => "localhost"
);

session_start();
