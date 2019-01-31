<?php
require_once "model/Manager.php";
class FactureManager extends Manager
{
    public function CountItems($id_facture)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT count(*) AS itemsnum FROM items WHERE id_facture = :id_facture');
        $req->execute(array('id_facture' => $id_facture));
        $data = $req->fetch(PDO::FETCH_ASSOC);
       
        return $data;
    }

    public function CountPage($row_client)
    {
        $db = $this->dbConnect();
         $req = $db->prepare('SELECT abs(FLOOR(-:row/18)) AS pages ');
        $req->execute(array('row' => $row_client));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return $data;
    }

    public function GetFacture($id_facture)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM factures WHERE id = :id_facture ');
        $req->execute(array('id_facture' => $id_facture));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return $data;
    }

    public function GetClient($id_facture)
    {
        $db = $this->dbConnect();
         $req = $db->prepare('SELECT * FROM factures INNER JOIN clients ON factures.id_client = clients.id WHERE factures.id = :id_facture ');
        $req->execute(array('id_facture' => $id_facture));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return $data;
    }
  
    public function GetItems($id_facture)
    {
        $db = $this->dbConnect();
         $req = $db->prepare('SELECT * FROM items WHERE id_facture = :id_facture ');
        $req->execute(array('id_facture' => $id_facture));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $data;
    }
}

