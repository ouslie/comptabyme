<?php
// Chargement des classes
require_once 'model/JobManager.php';
require_once 'model/Factures.php';
require_once 'model/Bases.php';
require_once 'model/Clients.php';
require_once 'model/Categories.php';
require_once 'model/Sscategories.php';
require_once 'model/Frais.php';
require_once 'model/Treso.php';
require_once 'model/Bank.php';
require_once 'model/Items.php';
require_once 'model/Transactions.php';
require_once 'model/EditableGrid.php';
require_once 'lib/pdf/fpdf.php';
require_once 'lib/pdo2.php';

function utilisateur_est_connecte()
{
    return !empty($_SESSION['id']);
}

function Disconnect()
{
    session_destroy();
    header('Location: index.php');
}

function ModuleList($module)
{
    require 'module/' . $module . '/list.php';
}

function ModuleAdd($module)
{
    require 'module/' . $module . '/add.php';
}

function ModuleEdit($module)
{
    require 'module/' . $module . '/edit.php';
}

function ModuleUpdate($module)
{
    require 'module/' . $module . '/update.php';
}

function ModuleDelete($module)
{
    require 'module/' . $module . '/delete.php';
}
function ModuleLoaddata($module)
{
    require 'module/' . $module . '/loaddata.php';
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

function GetDashboard()
{
    $jobManager = new JobManager();
    $Categories = new Categories();

    //base par défaut
    $defaultbase = $jobManager->GetBaseDefault($_SESSION['id']);

    $base = $jobManager->GetBaseName($defaultbase['id']);

    if (!isset($_SESSION['activebase'])) {
        $_SESSION['activebase'] = $defaultbase['id'];
        $_SESSION['activebasename'] = $base['name'];
        $_SESSION['activecontrats'] = $base['activecontrats'];
        $_SESSION['activeca'] = $base['activeca'];
        $_SESSION['is_internal'] = $base['is_internal'];
    }

    $internal_cat = $Categories->GetInternal($_SESSION['activebase']);

    if (isset($internal_cat['id'])) {
        $internal_cat = $internal_cat['id'];
    } else {
        $internal_cat = 0;

    }
    //Widget init
    $month = date('m');
    $RecetteMonth = $jobManager->GetRecetteMonth($month, $_SESSION['activebase'], $internal_cat); // Appel d'une fonction de cet objet
    $DepenseMonth = $jobManager->GetDepenseMonth($month, $_SESSION['activebase'], $internal_cat); // Appel d'une fonction de cet objet
    $RecetteAVenir = $jobManager->GetRecetteAVenir($_SESSION['activebase']);
    $DepenseAVenir = $jobManager->GetDepenseAVenir($_SESSION['activebase']);

    ///Line chart Depense/Recette
    $totalbank = $jobManager->GetTotalAccount($_SESSION['activebase']);
    $GraphTypeMonth = $jobManager->GraphTypeMonth($totalbank['id']);
    $phpobj = json_encode($GraphTypeMonth);

    //Total treso base

  
    $Treso = new Treso;
    $treso = $Treso->GetLastMonthAmount($_SESSION['id']);

    require 'view/frontend/dashboard.php';

}

function ByJob()
{

    $jobManager = new JobManager();
    $Categories = new Categories();
    $categories = $Categories->GetAll($_SESSION['activebase']);
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
    $bank = $jobManager->GetAccountWitoutTotal($_SESSION['activebase']);
    $idTotalBank = $jobManager->GetTotalAccount($_SESSION['activebase']);
//Cron account
    foreach ($date as $tdate) {
        $tdepense = 0;
        $trecette = 0;
        $ttotal = 0;
        foreach ($bank as $tbank) {
            $recette = $jobManager->HotAccountCronSelect($_SESSION['activebase'], $tdate['id'], '1', $tbank['id']);
            $depense = $jobManager->HotAccountCronSelect($_SESSION['activebase'], $tdate['id'], '2', $tbank['id']);
            $total = $recette['amount'] + $depense['amount'];
            $tdepense = $tdepense + $depense['amount'];
            $trecette = $trecette + $recette['amount'];
            $ttotal = $ttotal + $total;
            $jobManager->Hotaccountcron($_SESSION['activebase'], $tdate['id'], $depense['amount'], $recette['amount'], $total, $tbank['id']);
        }
        $jobManager->Hotaccountcron($_SESSION['activebase'], $tdate['id'], $tdepense, $trecette, $ttotal, $idTotalBank['id']);
    }
//Cron treso
    foreach ($bank as $tbank) {
        $init = $jobManager->GetSoldeAccount($tbank['id']);
        $ttotal = $init['solde'];
        foreach ($date as $tdate) {

            $recette = $jobManager->HotAccountCronSelect($_SESSION['activebase'], $tdate['id'], '1', $tbank['id']);
            $depense = $jobManager->HotAccountCronSelect($_SESSION['activebase'], $tdate['id'], '2', $tbank['id']);
            $total = $recette['amount'] + $depense['amount'];
            $ttotal = $ttotal + $total;
            $jobManager->Hottresocron($_SESSION['activebase'], $tdate['id'], $ttotal, $tbank['id']);
        }
    }
    foreach ($date as $tdate) {
        $totalmois = 0;
        foreach ($bank as $tbank) {
            $totaltreso = $jobManager->HotAccountCronSelect2($_SESSION['activebase'], $tdate['id'], $tbank['id'], $idTotalBank['id']);
            $totalmois = $totalmois + $totaltreso['total'];
            $jobManager->Hottresocron($_SESSION['activebase'], $tdate['id'], $totalmois, $idTotalBank['id']);
        }
    }

    header('Location: index.php');
}

function AddAccount($id_bank)
{
    $jobManager = new JobManager();
    for ($i = 1; $i < 13; $i++) {
        $jobManager->CreateHotTreso($id_bank, $i, $_SESSION["activebase"]);
        $jobManager->CreateHotAccount($id_bank, $i, $_SESSION["activebase"]);
    }
    $idTotalBank = $jobManager->GetTotalAccount($_SESSION['activebase']);
    $jobManager->CreateHotTreso($idTotalBank['id'], $i, $_SESSION["activebase"]);
    $jobManager->CreateHotAccount($idTotalBank['id'], $i, $_SESSION["activebase"]);

}

function AddBase($id_newbase)
{
    $jobManager = new JobManager();
    $id_TotalBank = $jobManager->AddBaseAccountTotal($id_newbase);
    for ($i = 1; $i < 13; $i++) {
        $jobManager->CreateHotTreso($id_TotalBank, $i, $id_newbase);
        $jobManager->CreateHotAccount($id_TotalBank, $i, $id_newbase);
    }
}
function SetBase()
{
    if (!empty($_POST)) {
        $activepage = $_POST['activepage'];
        $jobManager = new JobManager();
        $namebase = $jobManager->GetBaseName($_POST['id_base']);
        $_SESSION['activebase'] = $_POST['id_base'];
        $_SESSION['activebasename'] = $namebase['name'];
        $_SESSION['activecontrats'] = $namebase['activecontrats'];
        $_SESSION['activeca'] = $namebase['activeca'];
        header('Location: index.php?action=' . $activepage . '');
    }
    require CHEMIN_VUE . 'dashboard.php';
}
