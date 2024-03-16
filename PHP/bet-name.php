<?php

session_start();
header('Content-Type: application/json');

if( ! isset($_SESSION["user_id"])){
    header("Location: ../index.php");
    die("Error: ID de Sessão Inválido");
}

$userID = $_SESSION["user_id"];
$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT name 
        FROM userr 
        WHERE user_id = ?";

$stmt = $mysqli->stmt_init();
if ( ! $stmt->prepare($sql)) {
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo "Erro de envio 3.1";
    exit(); 
}

$stmt->bind_param("i", $userID);

if( ! $stmt->execute()){
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo "Erro de envio 3.2";
    exit(); 
}

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $name = $row["name"];
}

$result->free();
$stmt->close();
$mysqli->close();

echo json_encode([
    'name' => $name ? $name : 'Nome não Encontrado',
]);

?>
