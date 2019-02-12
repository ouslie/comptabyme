<?php
/*
 * INVOICR : THE PHP INVOICE GENERATOR (HTML, DOCX, PDF)
 * Visit https://code-boxx.com/invoicr-php-invoice-generator for more
 * 
 * ! YOU CAN DELETE THE ENTIRE EXAMPLE FOLDER IF YOU DON'T NEED IT... !
 */

/* [STEP 1 - CREATE NEW INVOICR OBJECT] */
require ('lib/invoicr/invoicr.php');
require ('global/config.php');
require ('model/Factures.php');

$var_id_facture = $_GET['id_fact'];
$Factures = new Factures;
$facture_infos = $Factures->GetFacture($var_id_facture);

$invoice = new Invoicr();

/* [STEP 2 - FEED ALL THE INFORMATION] */
// 2A - COMPANY INFORMATION
// OR YOU CAN PERMANENTLY CODE THIS INTO THE LIBRARY ITSELF
$invoice->set("company", [
	"logo.png", 
	"Anaud GUY | Webmaster", 
	"5 rue de la rotonde 25000 Besançon France",
	"Téléphone: 07 86 25 09 40",
	"https://www.arnaudguy.fr",
	"contact@arnaudguy.fr"
]);

if ($facture_infos["date_payment"]=="0000-00-00"){ $facture_infos["date_payment"] = NULL;}
// 2B - INVOICE INFO
$date_fact = date("d-m-Y", strtotime($facture_infos["date"]));


if(isset($facture_infos["date_payment"])){
$payment_date =  date("d-m-Y", strtotime($facture_infos["date_payment"]));
}

$invoice->set("invoice", [
	["Facture #", $facture_infos["num"]],
	["Date", $date_fact],
	["Moyen de paiement", $facture_infos['moyen_payment']],
	["Date de paiement", $payment_date],
]);
$row_client = $Factures->GetClient($var_id_facture);
// 2C - BILL TO
if($row_client["company"]==NULL){
	$invoice->set("billto", [
		$row_client['company'],
		$row_client['name'],
		$row_client['address'], 
		$row_client['cp'] . "&nbsp;	" . $row_client['city'],
		"France"
	
	]);

} else {
	$invoice->set("billto", [
		$row_client['name'],
		$row_client['address'], 
		$row_client['cp'] . "&nbsp;	" . $row_client['city'],
		"France"
	
	]);
}


// 2E - ITEMS
// YOU CAN JUST DUMP THE ENTIRE ARRAY IN USING SET, BUT HERE IS HOW TO ADD ONE AT A TIME... 

$row_items = $Factures->GetItems($var_id_facture);
foreach ($row_items as $i) { $invoice->add("items", $i); }

// 2F - TOTALS
$sum_items = $Factures->SumItems($var_id_facture);

$invoice->set("totals", [
	["Total HT", $sum_items['total']],
]);

// 2G - NOTES, IF ANY
$invoice->set("notes", [
	"<b>Condition de réglement</b> : 30 jours",
	"<b>Intérêt de retard</b> : 1% par mois",
	"<b>IBAN </b> : FR76 1254 8029 9846 9953 3150 529",
	"<b>BIC</b> : AXABFRPP ",
	"<b>Paypal</b> : contact@arnaudguy.fr ",
	"<b>Notes</b> :<br/> Conformément au décret n° 2012-1115 du 2 octobre 2012, et dans le cas d’une facture émise vers un professionnel, le montant de l’indemnité
	forfaitaire pour frais de recouvrement due au créancier en cas de retard de paiement est fixé à 40 euros.",
	

]);


/* [STEP 3 - OUTPUT] */
// 3A - CHOOSE TEMPLATE, DEFAULTS TO SIMPLE IF NOT SPECIFIED
$invoice->template("blueberry");

/*****************************************************************************/
// 3B - OUTPUT IN HTML
// DEFAULT DISPLAY IN BROWSER | 1 DISPLAY IN BROWSER | 2 FORCE DOWNLOAD | 3 SAVE ON SERVER
 //$invoice->outputHTML();
// $invoice->outputHTML(1);
// $invoice->outputHTML(2, "invoice.html");
// $invoice->outputHTML(3, __DIR__ . DIRECTORY_SEPARATOR . "invoice.html");
/*****************************************************************************/
// 3C - PDF OUTPUT
// DEFAULT DISPLAY IN BROWSER | 1 DISPLAY IN BROWSER | 2 FORCE DOWNLOAD | 3 SAVE ON SERVER
//$invoice->outputPDF();
// $invoice->outputPDF(1);
$invoice->outputPDF(2, "facture_".$facture_infos['num'].".pdf");
//$invoice->outputPDF(3, __DIR__ . DIRECTORY_SEPARATOR . "invoice.pdf");
/*****************************************************************************/
// 3D - DOCX OUTPUT
// DEFAULT FORCE DOWNLOAD| 1 FORCE DOWNLOAD | 2 SAVE ON SERVER
// $invoice->outputDOCX();
// $invoice->outputDOCX(1, "invoice.docx");
// $invoice->outputDOCX(2, __DIR__ . DIRECTORY_SEPARATOR . "invoice.docx");
/*****************************************************************************/
?>