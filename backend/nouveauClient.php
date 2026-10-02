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

    $id = $valeur['identifiant'];
    $nom = $valeur['nom'];
    $contact = $valeur['contact'];
    
    $query = mysqli_prepare($conn, "insert into client (idcli, nom, contact) values (?, ?, ?)");

    mysqli_stmt_bind_param($query, "sss", $id, $nom, $contact);

    if (mysqli_stmt_execute($query)) {
    echo json_encode(["status" => "success", "message" => "Ajout reussi"]);
      echo("Insértion réussi !");
    }
    else {
    http_response_code(201);
    echo json_encode(["status" => "error", "message" => "Erreur"]);
      echo("Impossible d'effectuer l'insertion !");
    }

    mysqli_stmt_close($query);
    mysqli_close($conn);

?>