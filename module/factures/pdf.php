<?php

$pdf = new FPDF('P', 'mm', 'A4');

$var_id_facture = $_GET['id_fact'];

    // on sup les 2 cm en bas
$pdf->SetAutoPagebreak(false);
$pdf->SetMargins(0, 0, 0);

$FactureManager = new FactureManager();

    $pdf->AddPage();
        
        // logo : 80 de largeur et 55 de hauteur
    $pdf->Image('logo.png', 10, 10, 50, 30);
        
        // n° facture, date echeance et reglement et obs
    $row = $FactureManager->GetFacture($var_id_facture);

    $champ_date = date_create($row["date"]);
    $annee = date_format($champ_date, 'Y');
    $num_fact = utf8_decode("FACTURE N° ") . $row["num"];
    $pdf->SetLineWidth(0.1);
    $pdf->SetFillColor(192);
    $pdf->Rect(120, 15, 85, 8, "DF");
    $pdf->SetXY(120, 15);
    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(85, 8, $num_fact, 0, 0, 'C');
        
        // ***********************
        // le cadre des articles
        // ***********************
        // cadre avec 18 lignes max ! et 118 de hauteur --> 95 + 118 = 213 pour les traits verticaux
    $pdf->SetLineWidth(0.1);
    $pdf->Rect(5, 95, 200, 118, "D");
        // cadre titre des colonnes
    $pdf->Line(5, 105, 205, 105);
        // les traits verticaux colonnes
    $pdf->Line(145, 95, 145, 213);
    $pdf->Line(158, 95, 158, 213);
    $pdf->Line(187, 95, 187, 213);
        // titre colonne
    $pdf->SetXY(1, 96);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 8, utf8_decode("Désignation"), 0, 0, 'C');
    $pdf->SetXY(145, 96);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(13, 8, utf8_decode("Quantité"), 0, 0, 'C');
    $pdf->SetXY(156, 96);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(22, 8, utf8_decode("PU"), 0, 0, 'C');
    $pdf->SetXY(185, 96);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(22, 8, utf8_decode("TOTAL HT"), 0, 0, 'C');
        
  // les articles
    $pdf->SetFont('Arial', '', 8);
    $y = 97;
    $row_items = $FactureManager->GetItems($var_id_facture);        
        // nom du fichier final
    $nom_file = "fact_" . $row["num"] . ".pdf";
        
        // date facture
    $date_fact = date("d-m-Y", strtotime($row["date"]));

    $pdf->SetFont('Arial', '', 11);
    $pdf->SetXY(122, 30);
    $pdf->Cell(60, 8, utf8_decode("Besançon, le ") . $date_fact, 0, 0, '');
        

        	// adr fact du client

    $row_client = $FactureManager->GetClient($var_id_facture);
    $pdf->SetFont('Arial', 'B', 11);
    $x = 110;
    $y = 50;
    $pdf->SetXY($x, $y);
    $pdf->Cell(100, 8, $row_client["name"], 0, 0, '');
    $y += 4;
    $pdf->SetXY($x, $y);
    $pdf->Cell(100, 8, $row_client["address"], 0, 0, '');
    $y += 4;
    $pdf->SetXY($x, $y);
    $pdf->Cell(100, 8, $row_client["cp"] . ' ' . $row_client["city"], 0, 0, '');
    $y += 4;
        

      
        // **************************
        // pied de page
        // **************************
    $pdf->SetLineWidth(0.1);
    $pdf->Rect(5, 260, 200, 6, "D");
    $pdf->SetXY(1, 260);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell($pdf->GetPageWidth(), 7, utf8_decode("Conformément au décret n° 2012-1115 du 2 octobre 2012, et dans le cas d’une facture émise vers un professionnel, le montant de l’indemnité forfaitaire pour frais de recouvrement due au créancier en cas de retard de paiement est fixé à 40 euros."), 0, 0, 'C');

    $y1 = 270;
        //Positionnement en bas et tout centrer
    $pdf->SetXY(1, $y1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($pdf->GetPageWidth(), 5, utf8_decode("IBAN : FR76 1254 8029 9846 9953 3150 529          BIC : AXABFRPP      PAYPAL : contact@arnaudguy.fr"), 0, 0, 'C');

    $pdf->SetFont('Arial', '', 10);

    $pdf->SetXY(1, $y1 + 4);
    $pdf->Cell($pdf->GetPageWidth(), 5, "Arnaud GUY | Webmaster", 0, 0, 'C');

    $pdf->SetXY(1, $y1 + 8);
    $pdf->Cell($pdf->GetPageWidth(), 5, utf8_decode('5 rue de la rotonde 25000 Besançon'), 0, 0, 'C');

    $pdf->SetXY(1, $y1 + 12);
    $pdf->Cell($pdf->GetPageWidth(), 5, "07 86 25 09 40 -- contact@arnaudguy.fr ", 0, 0, 'C');

    $pdf->SetXY(1, $y1 + 16);
    $pdf->Cell(
        $pdf->GetPageWidth(),
        5,
        "https://www.arnaudguy.fr",
        0,
        0,
        'C'
    );
$pdf->Output("I", $nom_file);
?>