<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorizations");
header("Access-Control-Allow-Methods: GET ,POST, OPTIONS");
header("Content-Type: application/json: charset=UTF-8");

    $server = "localhost";
    $utilisateur = "root";
    $mdpBase = "";
    $base = "Vente_Voiture";

    $conn = mysqli_connect($server, $utilisateur, $mdpBase, $base);

    $valeur = json_decode(file_get_contents("php://input"), true);

    $min = isset($valeur['min']) ? $valeur['min'] : '';
    $max = isset($valeur['max']) ? $valeur['max'] : '';

    $query = mysqli_prepare($conn, "SELECT numachat ,idcli ,idvoit, 
    DATE_FORMAT(date, '%d/%m/%Y') as date, qte from achat where date between ? and ?");
    
    mysqli_stmt_bind_param($query, "ss", $min, $max);

    if(mysqli_stmt_execute($query)) {
    $resultat = mysqli_stmt_get_result($query);
    $valeur = mysqli_fetch_all($resultat, MYSQLI_ASSOC);
    echo json_encode($valeur);
    }

    mysqli_stmt_close($query);
    mysqli_close($conn);

?>
