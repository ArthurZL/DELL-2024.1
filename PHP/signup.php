<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validações extras de segurança além das existentes no JS
    if(empty($_POST["name"])){
        die("Campo Nome é requerido");
    }

    if(empty($_POST["cpf"])){
        die("Campo CPF é requerido");
    }

    if($_POST["confirm-password"] !== $_POST["password"]){
        die("Senhas devem ser correspondentes");
    }

    require_once 'utils.php';
    
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $mysqli = require __DIR__ . "/database.php";

    $mysqli->begin_transaction();

    $cpf = strip_tags($_POST["cpf"]);
    $name = strip_tags($_POST["name"]);
    $lvl_access = 2;

    if (checksDuplicity($mysqli, "userr", "cpf", $cpf)) {
        die("O CPF já está em uso.");
    }

    $sql = "INSERT INTO userr (cpf, name, password_hash, lvl_access)
            VALUES (?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();
    if ( ! $stmt->prepare($sql)) {
        error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
        echo "Erro de envio 1.1";
        exit(); 
    }

    $stmt->bind_param("sssi", $cpf, $name, $password_hash, $lvl_access);

    if( ! $stmt->execute()){
        $mysqli->rollback();
        error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
        echo "Erro de envio 1.2";
        exit(); 
    } else {
        header("Location: ../HTML/signup-success.html");
    }

    $stmt->close();
}

$mysqli->commit();
$mysqli->close();

?>