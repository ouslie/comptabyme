<?php
require 'global/config.php';
require 'model/Factures.php';
if (isset($_POST['token'])) {
    $token = $_POST['token'];
    $Factures = new Factures;
    $id_base = $Factures->GetTokenInfo($token);
    if ($id_base > 0) {
        if (isset($_POST['useridfacture'])){
        $useridfacture = $_POST['useridfacture'];
        $id_category = $_POST['id_category'];
        //creation facture
        $id_facture = $Factures->WebserviceAddFacture($id_base,$useridfacture,$id_category);
        //creation items
        $designation = $_POST['designation'];
        $tarif = $_POST['tarif'];
        $quantity = $_POST['quantity'];
        $solde = $tarif * $quantity;
        $Factures->WebserviceInsertItem($id_facture,$tarif,$designation,$quantity);
        //génération numéro de facture
        $year = date('Y');
        $month = date('m');
        $num_facture = $year .'-' . $month . str_pad($id_facture, 2, '0', STR_PAD_LEFT);    
        $hash =  $Factures->WebserviceUpdateNum($id_facture,$num_facture);
        echo $hash;
        // update Solde
        $Factures->SetSoldeFacture($solde,$id_facture);
        } else { echo "pas de useridfacture";}
    } else {
        echo "token invalide";
    }
} else {
    echo 'pas de token';
}