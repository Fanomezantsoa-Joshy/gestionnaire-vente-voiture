<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Authorizations");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Content-Type: application/json: charset=UTF-8");

    $server = "localhost";
    $utilisateur = "root";
    $mdpBase = "";
    $base = "Vente_Voiture";

    $conn = mysqli_connect($server, $utilisateur, $mdpBase, $base);

    $valeur = json_decode(file_get_contents("php://input"), true);

    $nom = trim($valeur['nom'] ?? '');
    $prenoms = trim($valeur['prenoms'] ?? '');
    $nomUtilisateur = trim($valeur['nomUtilisateur'] ?? '');
    $naissance = trim($valeur['naissance'] ?? '');
    $email = trim($valeur['email'] ?? '');
    $mdp = trim($valeur['mdp'] ?? '');

    $query = mysqli_prepare($conn, "insert into utilisateur (nom, prenoms, nom_utilisateur, date_naissance, email, mdp) values (?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($query, "ssssss", $nom, $prenoms, $nomUtilisateur, $naissance, $email, $mdp);

    if (mysqli_stmt_execute($query)) {
      echo("Insértion réussi !");
    }
    else {
    http_response_code(201);
      echo("Impossible d'effectuer l'insertion !");
    }

    mysqli_stmt_close($query);
    mysqli_close($conn);

?>