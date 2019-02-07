<?php
require_once "model/Manager.php";
class Bank extends Manager
{

    public function Set($name, $solde, $system, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO bank SET name = :name, solde = :solde,system = :system, id_base = :id_base');
        $req->execute(array('name' => $name, 'solde' => $solde, 'system' => $system, 'id_base' => $id_base));
        $data = $db->lastInsertId();

        return $data;
    }

    public function Get($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM bank WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetAll($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM bank WHERE id_base = :id_base');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function Delete($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM bank WHERE id = :id');
        $data = $req->execute(array('id' => $id));

        return $data;
    }

    public function Update($colname, $colvalue, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE bank SET " . $colname . " = :colvalue WHERE id = :id");
        $data = $req->execute(array('colvalue' => $colvalue, 'id' => $id));
        return $data;
    }

    public function ListMyWithoutSys($base)
    {
        $db = $this->dbConnect();

        if (!($res = $db->query('SELECT id, name FROM bank WHERE id_base = ' . $base . ' AND system = 0'))) {
            return false;
        }

        $rows = array();
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $first = true;
            $key = $value = null;
            foreach ($row as $val) {
                if ($first) {
                    $key = $val;
                    $first = false;
                } else {
                    $value = $val;
                    break;
                }
            }
            $rows[$key] = $value;
        }
        return $rows;
    }
}