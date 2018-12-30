<?php

function ajouter_membre_dans_bdd($nom_utilisateur, $mdp, $adresse_email, $hash_validation)
{

    $pdo = PDO2::getInstance();

    $requete = $pdo->prepare("INSERT INTO users SET
		nom_utilisateur = :nom_utilisateur,
		mot_de_passe = :mot_de_passe,
		adresse_email = :adresse_email,
		hash_validation = :hash_validation,
		date_inscription = NOW()");

    $requete->bindValue(':nom_utilisateur', $nom_utilisateur);
    $requete->bindValue(':mot_de_passe', $mdp);
    $requete->bindValue(':adresse_email', $adresse_email);
    $requete->bindValue(':hash_validation', $hash_validation);

    if ($requete->execute()) {

        return $pdo->lastInsertId();
    }
    return $requete->errorInfo();
}

function combinaison_connexion_valide($nom_utilisateur, $mot_de_passe)
{

    $pdo = PDO2::getInstance();

    $requete = $pdo->prepare("SELECT id FROM users
		WHERE
		nom_utilisateur = :nom_utilisateur AND
		mot_de_passe = :mot_de_passe");

    $requete->bindValue(':nom_utilisateur', $nom_utilisateur);
    $requete->bindValue(':mot_de_passe', $mot_de_passe);
    $requete->execute();
    if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {

        $requete->closeCursor();
        return $result['id'];
    }
    return false;
}

function lire_infos_utilisateur($id_utilisateur)
{

    $pdo = PDO2::getInstance();

    $requete = $pdo->prepare("SELECT nom_utilisateur, mot_de_passe, adresse_email, date_inscription
		FROM users
		WHERE
		id = :id_utilisateur");

    $requete->bindValue(':id_utilisateur', $id_utilisateur);
    $requete->execute();

    if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {

        $requete->closeCursor();
        return $result;
    }
    return false;
}
