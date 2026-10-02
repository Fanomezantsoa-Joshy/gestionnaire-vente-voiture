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

    $voiture = isset($valeur['voiture']) ? $valeur['voiture'] : [];
    $modVoiture = isset($valeur['modVoiture']) ? $valeur['modVoiture'] : [];
    $client = isset($valeur['client']) ? $valeur['client'] : null;
    $achat = isset($valeur['achat']) ? $valeur['achat'] : null;

    $query4 = mysqli_prepare($conn, "delete from achat where numachat = ?");

    mysqli_stmt_bind_param($query4, "s", $achat);

    if(!mysqli_stmt_execute($query4)) {

    http_response_code(203);

    };

    mysqli_begin_transaction($conn);

    try {
    $query3 = mysqli_prepare($conn, "update voiture set nombre = (nombre + ?) where idvoit = ?");

    foreach ($modVoiture as $ligne) {

    $idvoit = isset($ligne['idvoit']) ? $ligne['idvoit'] : '';
    $quantite = isset($ligne['qte']) ? $ligne['qte'] : '';

    mysqli_stmt_bind_param($query3, "is", $quantite, $idvoit);

    if(!mysqli_stmt_execute($query3)) {
    throw new Exception("Erreur lors de la modification");
    }
    }

    mysqli_commit($conn);
    mysqli_stmt_close($query3);
    echo json_encode(["status" => "succes", "message" => "Succes"]);

    } catch (Exception $erreur) {
    mysqli_rollback($conn);
    echo json_encode(["status" => "error", "message" => "Erreur"]);
    }

    mysqli_begin_transaction($conn);

    try {
    $query = mysqli_prepare($conn, "insert into achat (numachat, idcli, idvoit, date, qte) values (?, ?, ?, curdate(), ?)");
    $query2 = mysqli_prepare($conn, "update voiture set nombre = (nombre - ?) where idvoit = ?");

    foreach ($voiture as $ligne) {

    $idvoit = isset($ligne['idvoit']) ? $ligne['idvoit'] : '';
    $quantite = isset($ligne['qte']) ? $ligne['qte'] : '';

    mysqli_stmt_bind_param($query, "sssi", $achat, $client, $idvoit, $quantite);
    mysqli_stmt_bind_param($query2, "is", $quantite, $idvoit);

    if(!mysqli_stmt_execute($query) || !mysqli_stmt_execute($query2)) {
    throw new Exception("Erreur lors de la modification");
    }
    }

    mysqli_commit($conn);
    mysqli_stmt_close($query);
    mysqli_stmt_close($query2);
    echo json_encode(["status" => "succes", "message" => "Succes"]);

    } catch (Exception $erreur) {
    mysqli_rollback($conn);
    echo json_encode(["status" => "error", "message" => "Erreur"]);
    }

?>




