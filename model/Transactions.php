<?php
require_once "model/Manager.php";
class Transactions extends Manager
{

    public function Set($third, $comment, $id_category, $id_bank, $id_type, $id_contrat, $amount, $date, $tally, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO transactions SET third = :third, comment = :comment, id_category = :id_category,id_bank = :id_bank,id_type = :id_type,id_contrat = :id_contrat,amount = :amount,date = :date,tally = :tally,id_base= :id_base');
        $req->execute(array('third' => $third, 'comment' => $comment, 'id_category' => $id_category, 'id_bank' => $id_bank, 'id_type' => $id_type, 'id_contrat' => $id_contrat, 'amount' => $amount, 'date' => $date, 'tally' => $tally, 'id_base' => $id_base));
        $data = $db->lastInsertId();

        return $data;
    }

    public function Get($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM transactions WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetAll($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM transactions WHERE id_base = :id_base');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function Delete($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM transactions WHERE id = :id');
        $data = $req->execute(array('id' => $id));

        return $data;
    }

    public function Update($colname, $colvalue, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE transactions SET " . $colname . " = :colvalue WHERE id = :id");
        $data = $req->execute(array('colvalue' => $colvalue, 'id' => $id));
        return $data;
    }

    public function GetType($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id_type FROM transactions WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function Loaddata($query)
    {
        $db = $this->dbConnect();
        $req = $db->query($query);
        return $req;
    }

    public function UpdateDateFacture($id, $tally, $date)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE transactions SET tally = :tally, date=:date WHERE id = :id");
        $data = $req->execute(array('tally' => $tally, 'date' => $date, 'id' => $id));
        return $data;
    }

}
