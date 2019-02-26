<?php
require_once "model/Manager.php";
class Sscategories extends Manager
{

    public function Set($name, $id_parent, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO sscategories SET name = :name, id_parent = :id_parent, id_base = :id_base');
        $req->execute(array('name' => $name, 'id_parent' => $id_parent, 'id_base' => $id_base));
        $data = $db->lastInsertId();

        return $data;
    }

    public function GetAll($id_parent)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM sscategories WHERE id_parent = :id_parent ORDER BY name ASC');
        $req->execute(array('id_parent' => $id_parent));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
    
    public function Delete($id_sscategory)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM sscategories WHERE id = :id');
        $data = $req->execute(array('id' => $id_sscategory));

        return $data;
    }

    public function Update($colname, $colvalue, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE sscategories SET " . $colname . " = :colvalue WHERE id = :id");
        $data = $req->execute(array('colvalue' => $colvalue, 'id' => $id));
        return $data;
    }

    public function ListAllMy($id_parent)
    {
        $db = $this->dbConnect();

        if (!($res = $db->query('SELECT id, name FROM sscategories WHERE id_parent = ' . $id_parent . ' ORDER BY name ASC'))) {
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
    public function ListRecetteMy($base)
    {
        $db = $this->dbConnect();

        if (!($res = $db->query('SELECT id, name FROM category WHERE id_base = ' . $base . ' AND is_recette = 1 ORDER BY name ASC'))) {
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
    public function Loaddata($query)
    {
        $db = $this->dbConnect();
        $req = $db->query($query);
        return $req;
    }

    public function ListAllMyChildFrais($id_notefrais)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id_cat FROM frais WHERE id = :id_notefrais');
        $req->execute(array('id_notefrais' => $id_notefrais));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if (!($res = $db->query('SELECT id, name FROM sscategories WHERE id_parent = ' . $data['id_cat'] . ' ORDER BY name ASC'))) {
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