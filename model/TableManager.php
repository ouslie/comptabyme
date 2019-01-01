<?php
class TableManager extends Manager
{
  
    public function GetTransaction($base_active)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id, third, comment, id_type, amount, tally, id_bank, id_category, id_base, date_format(date, '%d/%m/%Y') as date2, date FROM demo WHERE id_base = :active_base");       
        return $req;
    }




}
