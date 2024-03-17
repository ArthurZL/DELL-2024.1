<?php

session_start();
header('Content-Type: application/json');

if( ! isset($_SESSION["user_id"])){
    header("Location: ../index.php");
    die("Error: ID de Sessão Inválido");
}

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT wins 
        FROM userr 
        WHERE user_id = ?";

$stmt = $mysqli->stmt_init();
if ( ! $stmt->prepare($sql)) {
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo "Erro de envio 8.1";
    exit(); 
}

$user_id = $_SESSION["user_id"];
$stmt->bind_param("i", $user_id);

if( ! $stmt->execute()){
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo "Erro de envio 8.2";
    exit(); 
}

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $wins = (int) $row['wins'];
}

echo json_encode(['wins' => $wins]);
$result->free();
$stmt->close();
$mysqli->close();

?>