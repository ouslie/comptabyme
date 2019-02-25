<?php
require_once "model/Manager.php";
class Bases extends Manager
{

    public function GetCompagny($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT logo,compagnyname, compagnyadress, compagnyphone, compagnymail, compagnyweb,iban,bic,paypal FROM base WHERE id = :id_base ');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return $data;
    }

   

}