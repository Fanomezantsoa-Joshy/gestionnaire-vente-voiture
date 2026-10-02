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

    $numero = isset($_GET['numero']) ? $_GET['numero'] : '';

    $query = mysqli_prepare($conn, "delete from achat where numachat = ?");

    mysqli_stmt_bind_param($query, "s", $numero);

    if (!mysqli_stmt_execute($query)) {
    http_response_code(201);
    }

    mysqli_stmt_close($query);
    mysqli_close($conn);

?>