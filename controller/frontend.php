<?php

// Chargement des classes
require_once 'model/JobManager.php';
require_once 'lib/pdo2.php';

function utilisateur_est_connecte()
{
    return !empty($_SESSION['id']);
}

function AddTransaction()
{
    require 'module/transaction/add.php';
}
function DeleteTransaction()
{
    require 'module/transaction/delete.php';
}
function UpdateTransaction()
{
    require 'module/transaction/update.php';
}
function Login()
{
    require 'module/users/login.php';
}
function LoginOk()
{
    require 'module/users/login.php';
}
function Register()
{
    require 'module/users/register.php';
}
function RegisterOk()
{
    require 'controller/view/frontend/register_ok.php';
}

function ValidRegister()
{
    require 'module/users/valid_register.php';
}

function ListTransaction()
{
    require 'view/frontend/listTransactionView.php';
}

function GetDashboard()
{
    $jobManager = new JobManager();
    //base par défaut
    $defaultbase = $jobManager->GetBaseDefault($_SESSION['id']);
    if (!isset($_SESSION['activebase'])) {
        $_SESSION['activebase'] = $defaultbase['id'];
        $_SESSION['activebasename'] = $defaultbase['name'];

    }
    $month = date('m');
    $RecetteMonth = $jobManager->GetRecetteMonth($month, $_SESSION['activebase']); // Appel d'une fonction de cet objet
    $DepenseMonth = $jobManager->GetDepenseMonth($month, $_SESSION['activebase']); // Appel d'une fonction de cet objet

    $RecetteAVenir = $jobManager->GetRecetteAVenir($_SESSION['activebase']);
    $DepenseAVenir = $jobManager->GetDepenseAVenir($_SESSION['activebase']);

    require 'view/frontend/dashboard.php';
}

function ByJob()
{

    $jobManager = new JobManager();

    $categories = $jobManager->GetCategory($_SESSION['activebase']);
    $categories = $categories->fetchAll(PDO::FETCH_ASSOC);
    $recettes = $jobManager->SumTransactionByCategories($_SESSION['activebase']);
    $date = $jobManager->GetDate();

    foreach ($recettes as $row) {
        $tblAchat[$row['name']][$row['month']][$row['id_type']] = $row['amountbycategory'];
    }

    require 'view/frontend/job.php';

}

function ByAccount()
{
    $jobManager = new JobManager(); // Création d'un objet
    $date = $jobManager->GetDate();
    $account = $jobManager->GetAccount($_SESSION['activebase']);
    $sql = $jobManager->Gethotaccount($_SESSION['activebase']);

    foreach ($sql as $row) {
        $tblAchat[$row['month']][$row['id_bank']] = $row['total'];
        $tblRecette[$row['month']][$row['id_bank']] = $row['recette'];
        $tblDepense[$row['month']][$row['id_bank']] = $row['depense'];
    }
    require 'view/frontend/account.php';
}

function Treso()
{
    $jobManager = new JobManager(); // Création d'un objet
    $date = $jobManager->GetDate();
    $account = $jobManager->GetAccount($_SESSION['activebase']);
    $sql = $jobManager->Gethottreso($_SESSION['activebase']);
    foreach ($sql as $row) {
        $tblTotal[$row['month']][$row['id_bank']] = $row['total'];
    }

    require 'view/frontend/treso.php';

}

function Cron()
{
    $jobManager = new JobManager();
    $date = $jobManager->GetDate();
    $bank = $jobManager->GetAccount($_SESSION['activebase']);

    //Cron account
    foreach ($date as $tdate) {
        $tdepense = 0;
        $trecette = 0;
        $ttotal = 0;
        $idTotalBank = $jobManager->GetTotalAccount($_SESSION['activebase']);
        foreach ($bank as $tbank) {
            if ($tbank['id'] != $idTotalBank['id']) {
                $recette = $jobManager->HotAccountCronSelect($_SESSION['activebase'], $tdate['id'], '1', $tbank['id']);
                $depense = $jobManager->HotAccountCronSelect($_SESSION['activebase'], $tdate['id'], '2', $tbank['id']);
                $total = $recette['amount'] - $depense['amount'];
                $tdepense = $tdepense + $depense['amount'];
                $trecette = $trecette + $recette['amount'];
                $ttotal = $ttotal + $total;
                $jobManager->Hotaccountcron($_SESSION['activebase'], $tdate['id'], $depense['amount'], $recette['amount'], $total, $tbank['id']);
            } else {
                $jobManager->Hotaccountcron($_SESSION['activebase'], $tdate['id'], $tdepense, $trecette, $ttotal, $idTotalBank['id']);
            }
        }
    }
    //Cron treso
    foreach ($bank as $tbank) {
        $init = $jobManager->GetSoldeAccount($tbank['id']);
        $ttotal = $init['solde'];

        $idTotalBank = $jobManager->GetTotalAccount($_SESSION['activebase']);
        foreach ($date as $tdate) {
            if ($tbank['id'] != $idTotalBank['id']) {

                $recette = $jobManager->HotAccountCronSelect($_SESSION['activebase'], $tdate['id'], '1', $tbank['id']);
                $depense = $jobManager->HotAccountCronSelect($_SESSION['activebase'], $tdate['id'], '2', $tbank['id']);
                $total = $recette['amount'] - $depense['amount'];
                $ttotal = $ttotal + $total;
                $jobManager->Hottresocron($_SESSION['activebase'], $tdate['id'], $ttotal, $tbank['id']);
            } else {
                $jobManager->Hottresocron($_SESSION['activebase'], $tdate['id'], $ttotal, $idTotalBank['id']);
            }
        }
    }
    header('Location: index.php');

}
function AddAccount()
{
    if (!empty($_POST)) {
        echo $_POST["name"];
        $jobManager = new JobManager();
        $solde= floatval(str_replace(',', '.', str_replace('.', '', $_POST["solde"])));

        $id_bank = $jobManager->AddAccount($_POST["name"],$solde, $_SESSION["activebase"]);
        for ($i = 1; $i < 13; $i++) {
            $jobManager->CreateHotTreso($id_bank, $i, $_SESSION["activebase"]);
            $jobManager->CreateHotAccount($id_bank, $i, $_SESSION["activebase"]);
        }
        $idTotalBank = $jobManager->GetTotalAccount($_SESSION['activebase']);

        $jobManager->CreateHotTreso($idTotalBank['id'], $i, $_SESSION["activebase"]);
        $jobManager->CreateHotAccount($idTotalBank['id'], $i, $_SESSION["activebase"]);

    }
    require CHEMIN_VUE . 'addaccount.php';
}

function AddBase()
{
    if (!empty($_POST)) {
        $jobManager = new JobManager();
        $id_newbase = $jobManager->AddBase($_POST["name"], $_SESSION['id']);
        $id_TotalBank = $jobManager->AddBaseAccountTotal($id_newbase);

        echo $id_TotalBank;
        echo $id_newbase;
        for ($i = 1; $i < 13; $i++) {
            $jobManager->CreateHotTreso($id_TotalBank, $i, $id_newbase);
            $jobManager->CreateHotAccount($id_TotalBank, $i, $id_newbase);
        }

        echo '<label class="text-success">Data Inserted</label>';

    }

    require CHEMIN_VUE . 'addbase.php';
}
function SetBase()
{
    if (!empty($_POST)) {        
        $activepage = $_POST['activepage'];
        $jobManager = new JobManager();
        $namebase = $jobManager->GetBaseName($_POST['id_base']);
        $_SESSION['activebase'] = $_POST['id_base'];
        $_SESSION['activebasename'] = $namebase['name'];

        header('Location: index.php?action='.$activepage.'');

    }

    require CHEMIN_VUE . 'dashboard.php';
}

function Disconnect()
{
    session_destroy();
    header('Location: index.php');
}
function ByCa()
{

    $jobManager = new JobManager(); // Création d'un objet
    $date = $jobManager->GetDate();
    $ca = $jobManager->GetCa($_SESSION['activebase']);
    foreach ($ca as $row) {
        $tblTotal[$row['month']] = $row['amount'];
    }
    require 'view/frontend/byca.php';
}
