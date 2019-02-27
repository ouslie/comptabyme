<?php
require_once "model/Manager.php";
class Treso extends Manager{

    public function GetLastMonthAmount($id_user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(total) as total FROM hot_treso WHERE month = 12 AND id_bank IN (SELECT id FROM bank WHERE system = 0 AND id_base IN (SELECT id FROM base WHERE id_user = :id_user))');
        $req->execute(array('id_user' => $id_user));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

}