<?php

// Ne pas oublier d'inclure la librarie Form
include LIB.'form.php';

// "formulaire_inscription" est l'ID unique du formulaire
$form_inscription = new Form('formulaire_inscription');

$form_inscription->method('POST');

$form_inscription->add('Text', 'nom_utilisateur')
				 ->label("Votre nom d'utilisateur")
				 ->add_class("form-control");

$form_inscription->add('Password', 'mdp')
				 ->label("Votre mot de passe")
				 ->add_class("form-control");

$form_inscription->add('Password', 'mdp_verif')
				 ->label("Votre mot de passe (vérification)")
				 ->add_class("form-control");

$form_inscription->add('Email', 'adresse_email')
				 ->label("Votre adresse email")
				 ->add_class("form-control");


$form_inscription->add('Submit', 'submit')
				 ->value("Je veux m'inscrire !")
				 ->add_class("btn btn-primary btn-block");

				 include VIEW.'register.php';
				 $form_inscription->bound($_POST);
// Création d'un tableau des erreurs
$erreurs_inscription = array();
// Validation des champs suivant les règles en utilisant les données du tableau $_POST
if ($form_inscription->is_valid($_POST)) {
	if ($form_inscription->get_cleaned_data('mdp') != $form_inscription->get_cleaned_data('mdp_verif')) {
		$erreurs_inscription[] = "Les deux mots de passes entrés sont différents !";
	}

	// Si d'autres erreurs ne sont pas survenues
	if (empty($erreurs_inscription)) {

echo "ok";
// Tire de la documentation PHP sur <http://fr.php.net/uniqid>
$hash_validation = md5(uniqid(rand(), true));

// Tentative d'ajout du membre dans la base de donnees
list($nom_utilisateur, $mot_de_passe, $adresse_email) =
	$form_inscription->get_cleaned_data('nom_utilisateur', 'mdp', 'adresse_email');

// On veut utiliser le modele de l'inscription (~/modeles/inscription.php)
include MODEL.'Register.php';

// ajouter_membre_dans_bdd() est défini dans ~/modeles/inscription.php
$id_utilisateur = ajouter_membre_dans_bdd($nom_utilisateur, sha1($mot_de_passe), $adresse_email, $hash_validation);
echo $id_utilisateur;
// Si la base de données a bien voulu ajouter l'utliisateur (pas de doublons)
if (ctype_digit($id_utilisateur)) {

	// On transforme la chaine en entier
	$id_utilisateur = (int) $id_utilisateur;

	// Affichage de la confirmation de l'inscription
	header("Location: index.php?action=register_ok"); /* Redirection du navigateur */


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
	include CHEMIN_VUE.'formulaire_inscription.php';
}

	} else {

		// On affiche à nouveau le formulaire d'inscription
echo "errer";	}

} else {

	// On affiche à nouveau le formulaire d'inscription
echo "errerr";}
