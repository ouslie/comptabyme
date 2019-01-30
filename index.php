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

        if (isset($_GET['module'])) {
            switch ($_GET['action']) {
                case 'add':
                    ModuleAdd($_GET['module']);
                    break;
                case 'update':
                    ModuleUpdate($_GET['module']);
                    break;
                case 'delete':
                    ModuleDelete($_GET['module']);
                    break;
                case 'list':
                    ModuleList($_GET['module']);
                    break;

                case 'addfact':
                    require("module/facture/addfact.php");
                    break;
            }
        } else {
            if (isset($_GET['action'])) {

                switch ($_GET['action']) {

                    case 'dashboard':
                        GetDashboard();
                        break;
                    case 'setbase':
                        SetBase();
                        break;
                    case 'byjob':
                        ByJob();
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

    }

} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    //require 'view/frontend/errorView.php';
}
