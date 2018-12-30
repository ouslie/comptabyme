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



// Chemins à utiliser pour accéder aux vues/modèles/librairies
// [...]

// Configurations relatives à l'avatar
define('AVATAR_LARGEUR_MAXI', 100);
define('AVATAR_HAUTEUR_MAXI', 100);

$config = array(
	"db_name" => "demosql",
	"db_user" => "titi",
	"db_password" => "gQ8$2jh0",
	"db_host" => "localhost"
);

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
