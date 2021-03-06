<?php
require_once "model/Manager.php";
class JobManager extends Manager
{
    public function GetRecetteAVenir($base_active)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(amount) AS amount FROM transactions WHERE id_type = 1 AND id_base = :active_base AND tally = 0');
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
        $req = $db->prepare('SELECT sum(amount) AS amount FROM transactions WHERE id_type = 2 AND id_base = :active_base AND tally = 0');
        $req->execute(array('active_base' => $base_active));
        $data = $req->fetch();
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }

    public function GetRecetteMonth($date, $base_active, $excludecat)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(amount) AS amount FROM transactions WHERE  MONTH(date) = :date AND id_type = 1 AND id_category <> :excludecat AND id_base = :active_base');
        $req->execute(array('date' => $date, 'active_base' => $base_active, 'excludecat' => $excludecat));
        $data = $req->fetch();
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }

    public function GetDepenseMonth($date, $base_active, $excludecat)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT sum(amount) AS amount FROM transactions WHERE  MONTH(date) = :date AND id_type = 2 AND id_category <> :excludecat AND id_base = :active_base');
        $req->execute(array('date' => $date, 'active_base' => $base_active, 'excludecat' => $excludecat));
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

    public function GetCategoryIsRecette($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name FROM category WHERE id_base = :id_base AND is_recette = 1 ORDER BY name');
        $req->execute(array('id_base' => $id_base));
        return $req;
    }

    public function GetType()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, name FROM type ORDER BY id');
        return $req;
    }

    public function GetClients($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name FROM clients WHERE id_base = :id_base ORDER BY id');
        $req->execute(array('id_base' => $id_base));
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
        $req = $db->prepare('SELECT id FROM base WHERE id_user = :id_user AND defaultbase = 1');
        $req->execute(array('id_user' => $user_id));
        $data = $req->fetch(PDO::FETCH_ASSOC);

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
        FROM transactions
        INNER JOIN category ON transactions.id_category = category.id
        WHERE transactions.id_base = :id_base
        GROUP BY month, category.name,id_type');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
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

    public function AddTransaction($date, $type, $id_category, $third, $comment, $amount, $tally, $id_bank, $id_contrat, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO transactions SET date = :date, id_type = :type, id_category = :id_category, third = :third, comment = :comment, amount = :amount, tally = :tally, id_bank = :id_bank, id_contrat = :id_contrat, id_base = :id_base');
        $req->execute(array('date' => $date, 'type' => $type, 'id_category' => $id_category, 'third' => $third, 'comment' => $comment, 'amount' => $amount, 'tally' => $tally, 'id_bank' => $id_bank, 'id_contrat' => $id_contrat, 'id_base' => $id_base));
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

    public function AddAccount($name, $solde, $id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO bank SET name = :name,solde = :solde, id_base = :id_base');
        $req->execute(array('name' => $name, 'solde' => $solde, 'id_base' => $id_base));
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

    public function GetAccountWitoutTotal($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name FROM bank WHERE id_base = :id_base AND system = 0 ORDER BY system');
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

    public function HotContratsCron($id_base, $amount, $id_contrat)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE contrats
                  SET amount = :amount
                  WHERE id_base = :id_base
                  AND id = :id_contrat
                  ');
        $req->execute(array('amount' => $amount, 'id_base' => $id_base, 'id_contrat' => $id_contrat));

        return $req;
    }

    public function HotAccountCronSelect($id_base, $month, $id_type, $id_bank)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT SUM(amount) AS amount
                  FROM transactions
                  WHERE id_base = :id_base
                  AND MONTH(date) = :month
                  AND id_type = :id_type
                  AND id_bank = :id_bank
                  AND tally = 1
                  ');
        $req->execute(array('id_base' => $id_base, 'month' => $month, 'id_type' => $id_type, 'id_bank' => $id_bank));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }
    public function HotContratsCronSelect($id_base, $id_type, $id_contrat, $id_catcontrats)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT SUM(amount) AS amount
                  FROM transactions
                  WHERE id_base = :id_base
                  AND id_type = :id_type
                  AND id_contrat = :id_contrat
                  AND id_category = :id_catcontrats

                  ');
        $req->execute(array('id_base' => $id_base, 'id_type' => $id_type, 'id_contrat' => $id_contrat, 'id_catcontrats' => $id_catcontrats));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }

    public function HotAccountCronSelect2($id_base, $month, $id_bank)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT total
                  FROM hot_treso
                  WHERE id_base = :id_base
                  AND month = :month
                  AND id_bank = :id_bank
                  ');
        $req->execute(array('id_base' => $id_base, 'month' => $month, 'id_bank' => $id_bank));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if (!isset($data['total'])) {
            $data['total'] = 0;
        }
        return $data;
    }

    public function Getca($id_base)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT MONTH(date) AS month, SUM(amount) AS amount
                  FROM transactions
                  INNER JOIN category ON transactions.id_category = category.id
                  WHERE transactions.id_base = :id_base
                  AND transactions.id_type = 1
                  AND category.is_recette = 1
                  AND transactions.tally = "1"
                  GROUP BY  month
                  ');
        $req->execute(array('id_base' => $id_base));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        if (!isset($data['amount'])) {
            $data['amount'] = 0;
        }
        return $data;
    }

    public function GraphTypeMonth($id_banktotal)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT month, date.name AS namedate, recette , depense, recette + depense AS total FROM hot_account  INNER JOIN date ON hot_account.month  = date.id  WHERE id_bank  = :id_bank ORDER BY month ASC');
        $req->execute(array('id_bank' => $id_banktotal));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
