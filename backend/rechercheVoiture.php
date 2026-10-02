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

    mysqli_set_charset($conn, "utf8mb4");

    $recherche = isset($_GET["rechercher"]) ? trim($_GET["rechercher"]) : '';

    $data = [];

    if($recherche !== '') {

    $query = mysqli_prepare($conn, "SELECT idvoit, design, prix, nombre from voiture where idvoit like ? or design like ?");
    
    $valeurRechercher = "%" . $recherche . "%";
    
    mysqli_stmt_bind_param($query, "ss", $valeurRechercher, $valeurRechercher);

    mysqli_stmt_execute($query);
    
    $resultat = mysqli_stmt_get_result($query);

    while($row = mysqli_fetch_assoc($resultat)) {

    $data[] = $row;

    }

    mysqli_stmt_close($query);
    } else {

    $resultat = mysqli_query($conn, "select * from voiture");

    if($resultat) {

    while($row = mysqli_fetch_assoc($resultat)) {

    $data[] = $row; 

    }

    }

    }


    echo json_encode($data);
    mysqli_close($conn);


?>
