<?php
    // Quando a página é aberta pela primeira vez chama-se o código responsável pela criação da primeira edição e do usuário administrador
    $mysqli = require __DIR__ . "/PHP/database.php";
    $resultUserr = $mysqli->query("SELECT 1 FROM userr LIMIT 1");
    $resultEdition = $mysqli->query("SELECT 1 FROM edition LIMIT 1");
    if ($resultUserr->num_rows == 0 && $resultEdition->num_rows == 0) {
        require __DIR__ . "/PHP/beggin.php";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="./CSS/login.css?v=1.0">
    <script type="module" src="./JS/login.js"></script>
</head>
<body>
    <div class="flex-container">
        <div class="container">
            <div class="login-section">
                <img class="logo" src="./IMG/logo.png" alt="Logo" width="100px" height="100px">
                <form id="form-credentials" class="credentials" action="./PHP/login.php" method="post">
                    
                    <label for="cpf">CPF: </label>
                    <input id="cpf" class="input" type="text" name="cpf">

                    <label for="password">Senha: </label>
                    <input id="password" class="input" type="password" name="password">

                </form>
            </div>
            
            <div class="button-container">
                <button class="button" type="button" ><a class="link" href="./HTML/signup.html">Registrar</a></button>
                <button class="button" type="submit" form="form-credentials">Entrar</button>
            </div>

        </div>
    </div>
</body>
</html>
