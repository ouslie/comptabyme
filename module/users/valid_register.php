<?php
// Création d'un tableau des erreurs
$erreurs_inscription = array();

// Validation des champs suivant les règles en utilisant les données du tableau $_POST
if ($form_inscription->is_valid($_POST)) {
	// On vérifie si les 2 mots de passe correspondent
	if ($form_inscription->get_cleaned_data('mdp') != $form_inscription->get_cleaned_data('mdp_verif')) {
		?>
		<SCRIPT LANGUAGE="JavaScript"> 
		alert('marquer sont message'); 
		</SCRIPT><?php
		$erreurs_inscription[] = "Les deux mots de passes entrés sont différents !";
	}

	// Si d'autres erreurs ne sont pas survenues
	if (empty($erreurs_inscription)) {
		// Tire de la documentation PHP sur <http://fr.php.net/uniqid>
		$hash_validation = md5(uniqid(rand(), true));
		// Tentative d'ajout du membre dans la base de donnees
		list($nom_utilisateur, $mot_de_passe, $adresse_email) =
			$form_inscription->get_cleaned_data('nom_utilisateur', 'mdp', 'adresse_email');
			echo $mot_de_passe;

		// On veut utiliser le modele de l'inscription (~/modeles/inscription.php)
		include MODEL.'Register.php';
		
		// ajouter_membre_dans_bdd() est défini dans ~/modeles/inscription.php
		$id_utilisateur = ajouter_membre_dans_bdd($nom_utilisateur, sha1($mot_de_passe), $adresse_email, $hash_validation);
		
		// Si la base de données a bien voulu ajouter l'utliisateur (pas de doublons)
		if (ctype_digit($id_utilisateur)) {
		
			// On transforme la chaine en entier
			$id_utilisateur = (int) $id_utilisateur;
			
			// Preparation du mail
			$message_mail = '<html><head></head><body>
			<p>Merci de vous être inscrit sur "mon site" !</p>
			<p>Veuillez cliquer sur <a href="'.$_SERVER['PHP_SELF'].'?module=membres&amp;action=valider_compte&amp;hash='.$hash_validation.'">ce lien</a> pour activer votre compte !</p>
			</body></html>';
			
			$headers_mail  = 'MIME-Version: 1.0'                           ."\r\n";
			$headers_mail .= 'Content-type: text/html; charset=utf-8'      ."\r\n";
			$headers_mail .= 'From: "Mon site" <contact@monsite.com>'      ."\r\n";
			
			// Envoi du mail
			mail($form_inscription->get_cleaned_data('adresse_email'), 'Inscription sur <monsite.com>', $message_mail, $headers_mail);
			
			
			// Affichage de la confirmation de l'inscription
			include VIEW.'register_ok.php';
		
		// Gestion des doublons
		} else {
		
			// Changement de nom de variable (plus lisible)
			$erreur =& $id_utilisateur;
			
			// On vérifie que l'erreur concerne bien un doublon
			if (23000 == $erreur[0]) { // Le code d'erreur 23000 siginife "doublon" dans le standard ANSI SQL
			
				preg_match("`Duplicate entry '(.+)' for key \d+`is", $erreur[2], $valeur_probleme);
				$valeur_probleme = $valeur_probleme[1];
				
				if ($nom_utilisateur == $valeur_probleme) {
				
					$erreurs_inscription[] = "Ce nom d'utilisateur est déjà utilisé.";
				
				} else if ($adresse_email == $valeur_probleme) {
				
					$erreurs_inscription[] = "Cette adresse e-mail est déjà utilisée.";
				
				} else {
				
					$erreurs_inscription[] = "Erreur ajout SQL : doublon non identifié présent dans la base de données.";
				}
			
			} else {
			
				$erreurs_inscription[] = sprintf("Erreur ajout SQL : cas non traité (SQLSTATE = %d).", $erreur[0]);
			}
			
			// On reaffiche le formulaire d'inscription
			include VIEW.'register.php';
		}
		
	} else {

		// On affiche à nouveau le formulaire d'inscription
		include VIEW.'register.php';
	}

} else {

	// On affiche à nouveau le formulaire d'inscription
	include VIEW.'register.php';
}