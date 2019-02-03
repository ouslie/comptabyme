<?php
require 'global/config.php';
require 'model/FactureManager.php';
if (isset($_POST['token'])) {
    $token = $_POST['token'];
    $FactureManager = new FactureManager;
    $id_base = $FactureManager->GetTokenInfo($token);
    if ($id_base > 0) {
        if (isset($_POST['useridfacture'])){
        $useridfacture = $_POST['useridfacture'];
        //creation facture
        $id_facture = $FactureManager->WebserviceAddFacture($id_base,$useridfacture);
        echo $id_facture;
        //creation items
        $designation = $_POST['designation'];
        $tarif = $_POST['tarif'];
        $quantity = $_POST['quantity'];
        $FactureManager->WebserviceInsertItem($id_facture,$tarif,$designation,$quantity);

        //génération numéro de facture
        $year = date('Y');
        $month = date('m');
        $num_facture = $year .'-' . $month . str_pad($id_facture, 2, '0', STR_PAD_LEFT);    
        $FactureManager->WebserviceUpdateNum($id_facture,$num_facture);

        } else { echo "pas de useridfacture";}
    } else {
        echo "token invalide";
    }
} else {
    echo 'pas de token';
}
