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

    $query = mysqli_prepare($conn, "select * from utilisateur where nom = ? and prenoms = ? and nom_utilisateur = ? and date_naissance = ? and email = ?");

    mysqli_stmt_bind_param($query, "sssss", $nom, $prenoms, $nomUtilisateur, $naissance, $email);

    if (mysqli_stmt_execute($query)) {

      $resultat = mysqli_stmt_get_result($query);

      if (mysqli_num_rows($resultat) > 0) {

        $query2 = mysqli_prepare($conn, "update utilisateur set mdp = ? where nom_utilisateur = ?");

        mysqli_stmt_bind_param($query2, "ss", $mdp, $nomUtilisateur);

        if (mysqli_stmt_execute($query2)) {

          http_response_code(200);

        }
        else {
          http_response_code(203);
        };

      }
      else {
        http_response_code(202);
      };

    } else {
      http_response_code(201);
    };

    mysqli_stmt_close($query);
    mysqli_close($conn);

?>