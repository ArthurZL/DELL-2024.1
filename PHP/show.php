<?php

session_start();
header('Content-Type: application/json');

if( ! isset($_SESSION["user_id"])){
    header("Location: ../index.php");
    die("Error: ID de Sessão Inválido");
}

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT bet.*
            , userr.name
            , userr.cpf
            , registration.registration_nr
        FROM bet
        LEFT JOIN userr
            ON userr.user_id = bet.user_id
        LEFT JOIN registration
            ON registration.registration_id = bet.registration_id
        WHERE bet.edition_id = (
            SELECT MAX(edition_id)
            FROM edition
        )
        ORDER BY userr.name";

$stmt = $mysqli->prepare($sql);

if ( ! $stmt->execute()) {
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo json_encode(["error" => "Erro de envio 5.1"]);
    exit();
}

$result = $stmt->get_result();

$registrations = [];
while ($row = $result->fetch_assoc()) {
    // Verifica se o registration_id observado já existe no array $registraion
    if ( ! isset($registrations[$row['registration_id']])) {
        // Esta é a etapa que garante que para cada registraion_id, haverá um array com as informações pessoais do apostar, assim como um subarray de números apostados
        $registrations[$row['registration_id']] = [
            'numbers' => [],
            'registration_nr' => $row['registration_nr'],
            'name' => $row['name'],
            'cpf' => $row['cpf']
        ];
    }
    // Para o registro_id sendo observado, será adicionado todos os números escolhidos pelo apostador
    $registrations[$row['registration_id']]['numbers'][] = $row['number'];
}

echo json_encode($registrations);

$result->free();
$stmt->close();

?>