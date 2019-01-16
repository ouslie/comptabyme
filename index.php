<?php
require 'controller/frontend.php';
require 'global/config.php';

try {
    if (!utilisateur_est_connecte()) {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'inscription':
                    Register();
                    break;
                case 'register_ok':
                    RegisterOk();
                    break;
                default;
                    header('Location: index.php');
                    break;
            }
        } else {
            Login();
        }

    } else {

        if (isset($_GET['action'])) {

            switch ($_GET['action']) {
                case 'listtransaction':
                    ListTransaction();
                    break;
                case 'dashboard':
                    GetDashboard();
                    break;
                case 'setbase':
                    SetBase();
                    break;
                case 'byjob':
                    ByJob();
                    break;
                case 'addtransaction':
                    AddTransaction();
                    break;
                case 'deletetransaction':
                    DeleteTransaction();
                    break;
                case 'updatetransaction':
                    UpdateTransaction();
                    break;
                case 'addaccount':
                    AddAccount();
                    break;
                case 'addbase':
                    AddBase();
                    break;
                case 'byaccount':
                    ByAccount();
                    break;
                case 'treso':
                    Treso();
                    break;
                case 'cron':
                    Cron();
                    break;
                case 'byca':
                    ByCa();
                    break;
                    case 'bycontrats':
                    ByContrats();
                    break;
                case 'disconnect':
                    Disconnect();
                    break;
                    
                default;
                    header('Location: index.php');
                    break;
            }

        } else {
            GetDashboard();
        }
    }

} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    //require 'view/frontend/errorView.php';
}
