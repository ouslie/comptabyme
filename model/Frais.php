<?php
class Frais extends Manager
{

    public function Set($name, $debcontrat, $endcontrat, $id_cat, $comment, $id_base)
    {
        $db = $this->dbConnect();

        $req = $db->prepare('INSERT INTO frais SET name = :name, debcontrat = :debcontrat,endcontrat = :endcontrat,id_cat = :id_cat,comment = :comment, id_base = :id_base');
        $req->execute(array('name' => $name, 'debcontrat' => $debcontrat, 'endcontrat' => $endcontrat, 'id_cat' => $id_cat, 'comment' => $comment, 'id_base' => $id_base));
        $data = $db->lastInsertId();

        return $data;
    }

    public function SetItems($id_notefrais, $date, $id_category_child_frais, $third, $amount)
    {
        $db = $this->dbConnect();

        $req = $db->prepare('INSERT INTO frais_items SET id_notefrais = :id_notefrais, date = :date, id_category = :id_category_child_frais,third = :third,amount = :amount');
        $req->execute(array('id_notefrais' => $id_notefrais, 'date' => $date, 'id_category_child_frais' => $id_category_child_frais, 'third' => $third, 'amount' => $amount));
        $data = $db->lastInsertId();
        return $data;
    }

    public function Get($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM frais WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetItemsIdTransaction($id_items)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id_transaction FROM frais_items WHERE id = :id');
        $req->execute(array('id' => $id_items));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetItems($id_notefrais)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(amount) as total, sscategories.name FROM frais_items INNER JOIN sscategories ON sscategories.id = frais_items.id_category WHERE id_notefrais = :id_notefrais GROUP BY sscategories.name');
        $req->execute(array('id_notefrais' => $id_notefrais));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetAll($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM frais WHERE id_base = :id_base');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function Delete($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM frais WHERE id = :id');
        $data = $req->execute(array('id' => $id));

        return $data;
    }
    public function DeleteItems($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM frais_items WHERE id = :id');
        $data = $req->execute(array('id' => $id));

        return $data;
    }

    public function Update($colname, $colvalue, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE frais SET " . $colname . " = :colvalue WHERE id = :id");
        $data = $req->execute(array('colvalue' => $colvalue, 'id' => $id));
        return $data;
    }

    public function UpdateItems($colname, $colvalue, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE frais_items SET " . $colname . " = :colvalue WHERE id = :id");
        $data = $req->execute(array('colvalue' => $colvalue, 'id' => $id));
        return $data;
    }

    public function Loaddata($query)
    {
        $db = $this->dbConnect();
        $req = $db->query($query);
        return $req;
    }

    public function ListMy($base)
    {
        $db = $this->dbConnect();

        if (!($res = $db->query('SELECT id, name FROM frais WHERE id_base = ' . $base . ''))) {
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
    public function SetTransactionItems($id_transaction, $id_items)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE frais_items SET id_transaction = :id_transaction WHERE id = :id_items ');
        $data = $req->execute(array('id_transaction' => $id_transaction, 'id_items' => $id_items));
        $req->closeCursor();
        return $data;
    }

    public function SumItems($id_notefrais)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT round(sum(amount),2) AS total FROM frais_items WHERE id_notefrais = :id_notefrais ');
        $req->execute(array('id_notefrais' => $id_notefrais));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $data;
    }

    public function SetSoldeFrais($solde, $id_notefrais)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE frais SET amount = :solde WHERE id = :id_notefrais ');
        $req->execute(array('solde' => $solde, 'id_notefrais' => $id_notefrais));
        $req->closeCursor();
    }

}
