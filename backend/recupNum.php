<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Authorizations");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Content-Type: application/json: charset=UTF-8");

    $server = "localhost";
    $utilisateur = "root";
    $mdpBase = "";
    $base = "Location_Voiture";

    $conn = mysqli_connect($server, $utilisateur, $mdpBase, $base);

    $valeur = json_decode(file_get_contents("php://input"), true);

    $query = mysqli_prepare($conn, "select num_loc from location order by num_loc desc limit 1");


    if (mysqli_stmt_execute($query)) {

      $resultat = mysqli_stmt_get_result($query);
      $valeur = mysqli_fetch_assoc($resultat);

      if ($valeur) {
      echo json_encode($valeur);
      }
      else {
        http_response_code(202);
      };

    } else {
      http_response_code(201);
    }

    mysqli_stmt_close($query);
    mysqli_close($conn);

?>