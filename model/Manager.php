<?php
require_once "model/Manager.php";
class Manager
{
    protected function dbConnect()
    {
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=demosql', 'titi', 'gQ8$2jh0');
            $dbh->exec("SET CHARACTER SET utf8");

        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }

        return $dbh;
    }
}


