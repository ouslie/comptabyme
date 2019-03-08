<?php
require_once "model/Manager.php";
class Items extends Manager
{

    public function Set($designation, $quantity, $amount, $id_facture)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO items SET designation = :designation, quantity = :quantity, amount = :amount ,id_facture = :id_facture');
        $req->execute(array('designation' => $designation, 'quantity' => $quantity, 'amount' => $amount, 'id_facture' => $id_facture));
        $data = $db->lastInsertId();

        return $data;
    }

    public function Get($id_category)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM items WHERE id = :id');
        $req->execute(array('id' => $id_category));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetAll($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM items WHERE id_base = :id_base');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function Delete($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM items WHERE id = :id');
        $data = $req->execute(array('id' => $idr));

        return $data;
    }

    public function Update($colname, $colvalue, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE items SET " . $colname . " = :colvalue WHERE id = :id");
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
