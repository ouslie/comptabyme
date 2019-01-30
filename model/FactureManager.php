<?php
class FactureManager extends Manager
{
    public function CountItems($id_facture)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT count(*) FROM items WHERE id_facture  :id_facture');
        $req->execute(array('id_facture' => $id_facture));
        $data = $req->fetch();
       
        return $data;
    }
  
}

