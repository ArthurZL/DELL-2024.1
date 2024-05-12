<?php

session_start();
require_once 'utils.php';

$mysqli = require __DIR__ . "/database.php";

$mysqli->begin_transaction();

$sql = "INSERT INTO edition (year)
        VALUES (?)";

$stmt = $mysqli->stmt_init();
if ( ! $stmt->prepare($sql)) {
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo "Erro de envio 7.1";
    exit(); 
}

$initialYear = 2024;
$stmt->bind_param("i", $initialYear);

if( ! $stmt->execute()){
    $mysqli->rollback();
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo "Erro de envio 7.2";
    exit(); 
}

$stmt->close();


$sql = "INSERT INTO userr (cpf, name, password_hash, lvl_access)
        VALUES (?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();
if ( ! $stmt->prepare($sql)) {
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo "Erro de envio 7.3";
    exit(); 
}

// Credenciais padrão para o usuário administrador
$cpf = "00000000000";
$name = "Administrador";
$password_hash = password_hash("senhaforteadmin", PASSWORD_DEFAULT);
$lvl_access = 1;
$stmt->bind_param("sssi", $cpf, $name, $password_hash, $lvl_access);

if( ! $stmt->execute()){
    $mysqli->rollback();
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo  "Erro de envio 7.4";
    exit(); 
}

$mysqli->commit();
$stmt->close();
$mysqli->close();

?>