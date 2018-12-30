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
            if ($_GET['action'] == 'listtransaction') {
                ListTransaction();
            }
            if ($_GET['action'] == 'dashboard') {
                GetDashboard();
            }
            if ($_GET['action'] == 'setbase') {
                SetBase();
            }
            if ($_GET['action'] == 'byjob') {
                ByJob();
            }
            if ($_GET['action'] == 'addtransaction') {
                AddTransaction();
            }
            if ($_GET['action'] == 'deletetransaction') {
                DeleteTransaction();
            }
            if ($_GET['action'] == 'updatetransaction') {
                UpdateTransaction();
            }
            if ($_GET['action'] == 'byca') {
                ByCa();
            }
            if ($_GET['action'] == 'addaccount') {
                AddAccount();
            }
            if ($_GET['action'] == 'addbase') {
                AddBase();
            }
            if ($_GET['action'] == 'byaccount') {
                ByAccount();
            }
            if ($_GET['action'] == 'treso') {
                Treso();
            }
            if ($_GET['action'] == 'cron') {
                Cron();
            }
            if ($_GET['action'] == 'disconnect') {
                Disconnect();
            }
            
        } else {
            GetDashboard();
        }
    }

} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    //require 'view/frontend/errorView.php';
}
