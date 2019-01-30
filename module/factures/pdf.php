<?php

    $pdf = new FPDF( 'P', 'mm', 'A4' );

    $var_id_facture = $_GET['id_fact'];

    // on sup les 2 cm en bas
    $pdf->SetAutoPagebreak(False);
    $pdf->SetMargins(0,0,0);

    $FactureManager = new FactureManager();
    $row_client = $FactureManager->CountItems($var_id_facture);
    $nb_page = $row_client['itemsnum'];
    
    $row_client = $FactureManager->CountPage($nb_page);
    $nb_page = $row_client['pages'];
    

    $num_page = 1; $limit_inf = 0; $limit_sup = 18;
    While ($num_page <= $nb_page)
    {
        $pdf->AddPage();
        
        // logo : 80 de largeur et 55 de hauteur
        $pdf->Image('./logo.png', 10, 10, 80, 55);
        
        // n° facture, date echeance et reglement et obs
        $row = $FactureManager->GetFacture($var_id_facture);
        
        $champ_date = date_create($row[0]); $annee = date_format($champ_date, 'Y');
        $num_fact = utf8_decode("FACTURE N° "). $annee .'-' . str_pad($row["id"], 4, '0', STR_PAD_LEFT);
        $pdf->SetLineWidth(0.1); $pdf->SetFillColor(192); $pdf->Rect(120, 15, 85, 8, "DF");
        $pdf->SetXY( 120, 15 ); $pdf->SetFont( "Arial", "B", 12 ); $pdf->Cell( 85, 8, $num_fact, 0, 0, 'C');
        
        // nom du fichier final
        $nom_file = "fact_" . $annee .'-' . str_pad($row["date"], 4, '0', STR_PAD_LEFT) . ".pdf";
        
        // date facture
        $date_fact = date("d-m-Y", strtotime($row["date"]));

        $pdf->SetFont('Arial','',11); $pdf->SetXY( 122, 30 );
        $pdf->Cell( 60, 8, utf8_decode("Besançon, le ") . $date_fact, 0, 0, '');
        
      
        // **************************
        // pied de page
        // **************************
        $pdf->SetLineWidth(0.1); $pdf->Rect(5, 260, 200, 6, "D");
        $pdf->SetXY( 1, 260 ); $pdf->SetFont('Arial','',7);
        $pdf->Cell( $pdf->GetPageWidth(), 7, utf8_decode("Conformément au décret n° 2012-1115 du 2 octobre 2012, et dans le cas d’une facture émise vers un professionnel, le montant de l’indemnité forfaitaire pour frais de recouvrement due au créancier en cas de retard de paiement est fixé à 40 euros."), 0, 0, 'C');
        
        $y1 = 270;
        //Positionnement en bas et tout centrer
        $pdf->SetXY( 1, $y1 ); $pdf->SetFont('Arial','B',10);
        $pdf->Cell( $pdf->GetPageWidth(), 5, utf8_decode("IBAN : FR76 1254 8029 9846 9953 3150 529 BIC : AXABFRPP PAYPAL : contact@arnaudguy.fr"), 0, 0, 'C');
        
        $pdf->SetFont('Arial','',10);
        
        $pdf->SetXY( 1, $y1 + 4 ); 
        $pdf->Cell( $pdf->GetPageWidth(), 5, "Arnaud GUY Webmaster", 0, 0, 'C');
        
        $pdf->SetXY( 1, $y1 + 8 );
        $pdf->Cell( $pdf->GetPageWidth(), 5,utf8_decode('5 rue de la rotonde 25000 Besançon'), 0, 0, 'C');

        $pdf->SetXY( 1, $y1 + 12 );
        $pdf->Cell( $pdf->GetPageWidth(), 5, "07 86 25 09 40 contat@arnaudguy.fr ", 0, 0, 'C');

        $pdf->SetXY( 1, $y1 + 16 );
        $pdf->Cell( $pdf->GetPageWidth(), 5, "https://www.arnaudguy.fr"
        , 0, 0, 'C');
        
        // par page de 18 lignes
        $num_page++; $limit_inf += 18; $limit_sup += 18; 
    }
    
   $pdf->Output("I", $nom_file);
?>