<?php
require_once "model/Manager.php";
class Manager
{
    protected function dbConnect()
    {
        try {
            $dbh = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
            $dbh->exec("SET CHARACTER SET utf8");

        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }

        return $dbh;
    }
}
