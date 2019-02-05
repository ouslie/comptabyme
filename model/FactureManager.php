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
        $data = $req->fetchAll();
        $req->closeCursor();
        return $data;
    }

    public function GetTokenInfo($token)
    {
        $db = $this->dbConnect();
         $req = $db->prepare('SELECT id_base FROM token WHERE token = :token ');
        $req->execute(array('token' => $token));
        $data = $req->fetch(PDO::FETCH_COLUMN);
        $req->closeCursor();
        return $data;
    }

    public function SumItems($id_facture)
    {
        $db = $this->dbConnect();
         $req = $db->prepare('SELECT round(sum(quantity * amount),2) AS total FROM items WHERE id_facture = :id_facture ');
        $req->execute(array('id_facture' => $id_facture));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $data;
    }

    public function SetSoldeFacture($solde,$id_facture)
    {
        $db = $this->dbConnect();
         $req = $db->prepare('UPDATE factures SET solde = :solde WHERE id = :id_facture ');
        $req->execute(array('solde' => $solde,'id_facture'=>$id_facture));
        $req->closeCursor();
    }

    public function SetTransactionFacture($id_transaction,$id_facture)
    {
        $db = $this->dbConnect();
         $req = $db->prepare('UPDATE factures SET id_transaction = :id_transaction WHERE id = :id_facture ');
        $req->execute(array('id_transaction' => $id_transaction,'id_facture'=>$id_facture));
        $req->closeCursor();
    }


    public function WebserviceAddFacture($id_base,$useridfacture,$id_category)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO factures SET id_base = :id_base, id_client = :useridfacture, date = NOW(), id_category = :id_category');
        $req->execute(array('id_base' => $id_base,'useridfacture' => $useridfacture, 'id_category' => $id_category));
        $data = $db->lastInsertId();
        $req->closeCursor();
        return $data;
    }

    public function WebserviceUpdateNum($id_facture,$num_facture)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE factures SET num = :num_facture WHERE id = :id_facture');
        $req->execute(array('num_facture' => $num_facture,'id_facture' => $id_facture));
        $req->closeCursor();
    }

    public function WebserviceInsertItem($id_facture,$amount,$designation,$quantity)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO items SET id_facture = :id_facture, quantity = :quantity, amount = :amount, designation =:designation');
        $req->execute(array('id_facture' => $id_facture,'amount' => $amount,'designation' => $designation,'quantity' => $quantity));
        $req->closeCursor();
    }

}

