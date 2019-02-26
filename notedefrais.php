<?php
/*
 * INVOICR : THE PHP INVOICE GENERATOR (HTML, DOCX, PDF)
 * Visit https://code-boxx.com/invoicr-php-invoice-generator for more
 *
 * ! YOU CAN DELETE THE ENTIRE EXAMPLE FOLDER IF YOU DON'T NEED IT... !
 */

/* [STEP 1 - CREATE NEW INVOICR OBJECT] */
require 'lib/invoicr/invoicr.php';
require 'global/config.php';
require 'model/Bases.php';
require 'model/Frais.php';

if (isset($_GET['id_notefrais'])) {
    if (isset($_SESSION['id'])) {
        $var_id_notefrais = $_GET['id_notefrais'];
        $Frais = new Frais;
        $frais_info= $Frais->Get($var_id_notefrais);
    } else {
        die("session not set");
    }
} else {echo "Pas d'id note de frais ! ";}

$invoice = new Invoicr();

/* [STEP 2 - FEED ALL THE INFORMATION] */
// 2A - COMPANY INFORMATION
// OR YOU CAN PERMANENTLY CODE THIS INTO THE LIBRARY ITSELF
$Bases = New Bases;
$compagny = $Bases->GetCompagny($frais_info['id_base']);
$invoice->set("company", [
    "public/logo/logoair.png",
    $compagny['compagnyname'],
    $compagny['compagnyadress'],
    $compagny['compagnyphone'],
    $compagny['compagnymail'],
    $compagny['compagnyweb'],
]);

// 2B - INVOICE INFO
$datedeb = date("d-m-Y", strtotime($frais_info["debcontrat"]));
$dateend = date("d-m-Y", strtotime($frais_info["endcontrat"]));

$invoice->set("invoice", [
    ["Structure", $frais_info["name"]],
    ["Commentaires", $frais_info['comment']],
    ["Date de debut", $datedeb],
    ["Date de fin", $dateend],
]);


// 2E - ITEMS
// YOU CAN JUST DUMP THE ENTIRE ARRAY IN USING SET, BUT HERE IS HOW TO ADD ONE AT A TIME...
$row_items = $Frais->GetItems($var_id_notefrais);

foreach ($row_items as $i) {$invoice->add("items", $i);}

// 2F - TOTALS

$total = 0;
foreach($row_items AS $items) {
    $total += $items['total'];
}

$invoice->set("totals", [
    ["Total HT", $total],
]);

$invoice->template("air");

/*****************************************************************************/
// 3B - OUTPUT IN HTML
// DEFAULT DISPLAY IN BROWSER | 1 DISPLAY IN BROWSER | 2 FORCE DOWNLOAD | 3 SAVE ON SERVER
$invoice->outputHTML();
// $invoice->outputHTML(1);
// $invoice->outputHTML(2, "invoice.html");
// $invoice->outputHTML(3, __DIR__ . DIRECTORY_SEPARATOR . "invoice.html");
/*****************************************************************************/
// 3C - PDF OUTPUT
// DEFAULT DISPLAY IN BROWSER | 1 DISPLAY IN BROWSER | 2 FORCE DOWNLOAD | 3 SAVE ON SERVER
//$invoice->outputPDF();
// $invoice->outputPDF(1);
$invoice->outputPDF(2, "notefrais".$frais_info['name'].".pdf");
//$invoice->outputPDF(3, __DIR__ . DIRECTORY_SEPARATOR . "invoice.pdf");
/*****************************************************************************/
// 3D - DOCX OUTPUT
// DEFAULT FORCE DOWNLOAD| 1 FORCE DOWNLOAD | 2 SAVE ON SERVER
// $invoice->outputDOCX();
// $invoice->outputDOCX(1, "invoice.docx");
// $invoice->outputDOCX(2, __DIR__ . DIRECTORY_SEPARATOR . "invoice.docx");
/*****************************************************************************/