<?php

session_start();

$mysqli = require __DIR__ . "/database.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $sql = "SELECT * FROM userr 
            WHERE cpf = ?";

    $stmt = $mysqli->stmt_init();
    if ( ! $stmt->prepare($sql)) {
        error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
        echo "Erro de envio 2.1";
        exit(); 
    }
    
    $password = $_POST["password"];
    $cpf = strip_tags($_POST["cpf"]);

    $stmt->bind_param("s", $cpf);
    
    if( ! $stmt->execute()){
        error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
        echo "Erro de envio 2.2";
        exit(); 
    }

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Se o usuário que foi verificado através do CPF único existir, verifica-se se a senha é compatível
    if($user){
        if(password_verify($password, $user["password_hash"])){

            // Cria as variáveis goblais e redireciona o usuário dependendo de seu level de acesso
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["lvl_access"] = $user["lvl_access"];
            $lvl_access =  $_SESSION["lvl_access"];

            if($lvl_access == 2){
                header("Location: ../HTML/bet.html");
            }
            else if($lvl_access == 1){
                header("Location: ../HTML/home.html");
            }
            else{
                header("Location: ../index.php");
                die("Erro: Nível de Acesso Inválido");
            }

            exit();

        } else {
            header("Location: ../index.php");
            die("Erro: Senha Inválida");
        }
    } else {
        header("Location: ../index.php");
        die("Erro: CPF Não Encontrado");
    }
    
    $result->free();
    $stmt->close();
}

$mysqli->close();

?>