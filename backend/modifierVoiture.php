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

    $identifiant = $valeur['identifiant'];
    $designation = $valeur['designation'];
    $prix = $valeur['prix'];
    $nombre = $valeur['nombre'];
    
    $query = mysqli_prepare($conn, "update voiture set design = ?, prix = ?, nombre = ? where idvoit = ?");

    mysqli_stmt_bind_param($query, "siis", $designation, $prix, $nombre, $identifiant);

    if (mysqli_stmt_execute($query)) {

    echo json_encode(["status" => "success", "message" => "Modification reussi"]);

    }
    else {
    http_response_code(201);
    echo json_encode(["status" => "error", "message" => "Impossible d'effectuer la modification"]);

    }

    mysqli_stmt_close($query);
    mysqli_close($conn);

?>