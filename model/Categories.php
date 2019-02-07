<?php
require_once "model/Manager.php";
class Categories extends Manager
{

    public function Set($name, $is_recette, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO category SET name = :name, is_recette = :is_recette, id_base = :id_base');
        $req->execute(array('name' => $name, 'is_recette' => $is_recette, 'id_base' => $id_base));
        $data = $db->lastInsertId();

        return $data;
    }

    public function Get($id_category)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM category WHERE id = :id');
        $req->execute(array('id' => $id_category));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetAll($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM category WHERE id_base = :id_base');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }


    public function Delete($id_category)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM category WHERE id = :id');
        $data = $req->execute(array('id' => $id_category));

        return $data;
    }

    public function Update($colname,$colvalue,$id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE category SET ".$colname." = :colvalue WHERE id = :id");
        $data = $req->execute(array('colvalue' => $colvalue,'id' => $id));
        return $data;
    }

   public function ListAllMy($base)
{
    $db = $this->dbConnect();

    if (!($res = $db->query('SELECT id, name FROM category WHERE id_base = '.$base.''))) {
        return false;
    }

    $rows = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $first = true;
        $key = $value = null;
        foreach ($row as $val) {
            if ($first) {$key = $val;
                $first = false;} else { $value = $val;
                break;}
        }
        $rows[$key] = $value;
    }
    return $rows;
}
}