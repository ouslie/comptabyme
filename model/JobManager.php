<?php
require_once "model/Manager.php";
class JobManager extends Manager
{
    public function GetTransactionByCategory($category, $type, $date)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(amount) AS amount FROM demo WHERE  MONTH(date) = $date AND id_category = :id_category AND id_type = :id_type');
        $req->execute(array('id_category' => $category, 'id_type' => $type));
        $data = $req->fetch();
        return $data;
    }

    public function GetRecetteMonth($date, $base_active)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(amount) AS amount FROM demo WHERE  MONTH(date) = :date AND id_type = 1 AND id_base = :active_base');
        $req->execute(array('date' => $date, 'active_base' => $base_active));
        $data = $req->fetch();
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }
    public function GetRecetteAVenir($base_active)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(amount) AS amount FROM demo WHERE id_type = 1 AND id_base = :active_base AND tally = 0');
        $req->execute(array('active_base' => $base_active));
        $data = $req->fetch();
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }

    public function GetDepenseAVenir($base_active)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(amount) AS amount FROM demo WHERE id_type = 2 AND id_base = :active_base AND tally = 0');
        $req->execute(array('active_base' => $base_active));
        $data = $req->fetch();
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }

    public function GetDepenseMonth($date, $base_active)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(amount) AS amount FROM demo WHERE  MONTH(date) = :date AND id_type = 2 AND id_base = :active_base');
        $req->execute(array('date' => $date, 'active_base' => $base_active));
        $data = $req->fetch();
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }

    public function GetCategory($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name FROM category WHERE id_base = :id_base ORDER BY name');
        $req->execute(array('id_base' => $id_base));
        return $req;
    }
    public function GetType()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, name FROM type ORDER BY id');
        return $req;
    }

    public function GetBank($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name FROM bank WHERE id_base = :id_base');
        $req->execute(array('id_base' => $id_base));

        return $req;
    }

    public function GetBankSys($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name FROM bank WHERE id_base = :id_base AND system = 0');
        $req->execute(array('id_base' => $id_base));

        return $req;
    }

    public function GetBase($user_id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM base WHERE id_user = :id_user');
        $req->execute(array('id_user' => $user_id));
        return $req;
    }

    public function GetBaseName($baseid)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM base WHERE id = :baseid');
        $req->execute(array('baseid' => $baseid));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetBaseDefault($user_id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM base WHERE id_user = :id_user AND defaultbase = 1');
        $req->execute(array('id_user' => $user_id));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;
    }


    public function GetTransaction($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM demo WHERE id_base = :id_base');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function GetDate()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM date ');
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function SumTransactionByCategories($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT MONTH(date) AS month, category.name,id_type, SUM(amount) AS amountbycategory
    FROM demo
    INNER JOIN category ON demo.id_category = category.id
    WHERE demo.id_base = :id_base
    GROUP BY date, category.name,id_type');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;

    }

    public function CountTransaction($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM demo WHERE id_base = :id_base');
        $req->execute(array('id_base' => $id_base));
        $data = $req->rowCount();

        return $data;
    }

    public function AddCategory($name, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO category SET name = :name, id_base = :id_base');
        $req->execute(array('name' => $name, 'id_base' => $id_base));
        return $data;
    }
    public function AddBase($name, $id_user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO base SET name = :name, id_user = :id_user');
        $req->execute(array('name' => $name, 'id_user' => $id_user));
        $data = $db->lastInsertId();

        return $data;
    }
    public function AddBaseAccountTotal($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO bank SET name = "Total", id_base = :id_base, system = "1"');
        $req->execute(array('id_base' => $id_base));
        $data = $db->lastInsertId();
        return $data;
    }

    public function AddAccount($name, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO bank SET name = :name, id_base = :id_base');
        $req->execute(array('name' => $name, 'id_base' => $id_base));
        $data = $db->lastInsertId();
        return $data;
    }

    public function CreateHotTreso($id_bank, $month, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO hot_treso SET id_bank = :id_bank, id_base = :id_base, month = :month');
        $req->execute(array('id_bank' => $id_bank, 'id_base' => $id_base, 'month' => $month));
    }

    public function CreateHotAccount($id_bank, $month, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO hot_account SET id_bank = :id_bank, id_base = :id_base, month = :month');
        $req->execute(array('id_bank' => $id_bank, 'id_base' => $id_base, 'month' => $month));
    }

    public function GetAccount($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name FROM bank WHERE id_base = :id_base OR (system = :system AND  id_base = :id_base) ORDER BY system');
        $req->execute(array('id_base' => $id_base, 'system' => '1'));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function CountAccount($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name FROM bank WHERE id_base = :id_base ORDER BY id');
        $req->execute(array('id_base' => $id_base));
        $data = $req->rowCount();

        return $data;
    }

    public function GetTransactionByAccount($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT MONTH(date) AS month, bank.id AS namebank ,id_type,SUM(amount) AS amountbyaccount
    FROM demo
    INNER JOIN bank ON demo.id_bank = bank.id
    WHERE demo.id_base = :id_base
    GROUP BY date, name ,id_type');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function Gethotaccount($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id_bank,month,total, recette, depense
      FROM hot_account

      WHERE id_base = :id_base
      GROUP BY  id_bank,  month
      ');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetTotalAccount($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id
        FROM bank
        WHERE id_base = :id_base AND system = :system
        ');
        $req->execute(array('id_base' => $id_base, 'system' => '1'));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function GetSoldeAccount($id_bank)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT solde
          FROM bank
          WHERE id= :id
          ');
        $req->execute(array('id' => $id_bank));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function Gethottreso($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id_bank,month,total
          FROM hot_treso
          WHERE id_base = :id_base
          GROUP BY  id_bank,  month
          ');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function Hotaccountcron($id_base, $month, $depense, $recette, $total, $id_bank)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE hot_account
            SET depense = :depense, recette = :recette,total = :total
            WHERE id_base = :id_base AND month = :month AND id_bank = :id_bank
            ');
        $req->execute(array('depense' => $depense, 'recette' => $recette, 'total' => $total, 'id_base' => $id_base, 'month' => $month, 'id_bank' => $id_bank));
        $data = $req->fetch();
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }
    public function Hottresocron($id_base, $month, $total, $id_bank)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE hot_treso
              SET total = :total
              WHERE id_base = :id_base AND month = :month AND id_bank = :id_bank
              ');
        $req->execute(array('total' => $total, 'id_base' => $id_base, 'month' => $month, 'id_bank' => $id_bank));

        return $req;
    }

    public function HotAccountCronSelect($id_base, $month, $id_type, $id_bank)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT SUM(amount) AS amount
              FROM demo
              WHERE id_base = :id_base
              AND MONTH(date) = :month
              AND id_type = :id_type
              AND id_bank = :id_bank
              ');
        $req->execute(array('id_base' => $id_base, 'month' => $month, 'id_type' => $id_type, 'id_bank' => $id_bank));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }

    public function HotTresoCronSelect($id_base, $month, $id_type, $id_bank)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT SUM(amount) AS amount
              FROM demo
              WHERE id_base = :id_base
              AND MONTH(date) = :month
              AND id_type = :id_type
              AND id_bank = :id_bank
              AND tally = "1"
              ');
        $req->execute(array('id_base' => $id_base, 'month' => $month, 'id_type' => $id_type, 'id_bank' => $id_bank));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }

    public function Getca($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT MONTH(date) AS month, SUM(amount) AS amount
              FROM demo
              INNER JOIN category ON demo.id_category = category.id
              WHERE demo.id_base = :id_base
              AND demo.id_type = 1
              AND category.is_recette = 1
              AND demo.tally = "1"
              GROUP BY  month
              ');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }
}
