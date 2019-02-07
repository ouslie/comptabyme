<?php
class Contrats extends Manager
{

    public function Set($name, $debcontrat, $endcontrat, $id_cat, $salaire, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO contrats SET name = :name, debcontrat = :debcontrat,endcontrat = :endcontrat,id_cat = :id_cat,salaire = :salaire, id_base = :id_base');
        $req->execute(array('name' => $name, 'debcontrat' => $debcontrat, 'endcontrat' => $endcontrat, 'id_cat' => $id_cat,'salaire' => $salaire,  'id_base' => $id_base));
        $data = $db->lastInsertId();

        return $data;
    }

    public function Get($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM contrats WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetAll($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM contrats WHERE id_base = :id_base');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }


    public function Delete($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM contrats WHERE id = :id');
        $data = $req->execute(array('id' => $id));

        return $data;
    }

    public function Update($colname, $colvalue, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE contrats SET " . $colname . " = :colvalue WHERE id = :id");
        $data = $req->execute(array('colvalue' => $colvalue, 'id' => $id));
        return $data;
    }

    public function Loaddata($query)
    {
        $db = $this->dbConnect();
        $req = $db->query($query);
        return $req;
    }
    

}