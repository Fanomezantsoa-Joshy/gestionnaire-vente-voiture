<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorizations");
header("Access-Control-Allow-Methods: GET ,POST, OPTIONS");
header("Content-Type: application/json: charset=UTF-8");

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'Vente_Voiture';

$conn = mysqli_connect($host, $user, $pass, $dbname);

mysqli_query($conn, "SET lc_time_names = 'fr_FR'");

$sql = "WITH RECURSIVE
    nb_mois AS (
        SELECT 0 AS n
        UNION ALL
        SELECT n + 1
        FROM nb_mois
        WHERE
            n < 5
    ),
    calendrier AS (
        SELECT
            DATE_FORMAT(
                DATE_SUB(
                    CURRENT_DATE,
                    INTERVAL n MONTH
                ),
                '%Y-%m'
            ) AS mois_tri,
            DATE_FORMAT(
                DATE_SUB(
                    CURRENT_DATE,
                    INTERVAL n MONTH
                ),
                '%Y-%m-01'
            ) AS debut_mois,
            DATE_FORMAT(
                DATE_ADD(
                    DATE_SUB(
                        CURRENT_DATE,
                        INTERVAL n MONTH
                    ),
                    INTERVAL 1 MONTH
                ),
                '%Y-%m-01'
            ) AS fin_mois
        FROM nb_mois
    )
SELECT CONCAT(
        UPPER(
            SUBSTRING(
                DATE_FORMAT(c.debut_mois, '%M'), 1, 1
            )
        ),
        SUBSTRING(
            DATE_FORMAT(c.debut_mois, '%M'), 2
        ),
        ' ', DATE_FORMAT(c.debut_mois, '%Y')
    ) AS mois, COALESCE(SUM(a.qte * v.prix), 0) AS recette
FROM
    calendrier c
    LEFT JOIN achat a ON a.date >= c.debut_mois
    AND a.date < c.fin_mois
    LEFT JOIN voiture v ON a.idvoit = v.idvoit
GROUP BY
    c.mois_tri,
    c.debut_mois
ORDER BY c.mois_tri ASC";

$result = mysqli_query($conn, $sql);

$stats = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $stats[] = [
        "mois" => $row["mois"],
        "recette" => (int)$row["recette"]
        ];
    }
    
    mysqli_free_result($result);

    echo json_encode($stats);

}

mysqli_close($conn);
?>