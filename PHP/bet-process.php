<?php

session_start();
header('Content-Type: application/json');

if( ! isset($_SESSION["user_id"])){
    header("Location: ../index.php");
    die("Error: ID de Sessão Inválido");
}

$mysqli = require __DIR__ . "/database.php";

$mysqli->begin_transaction();

// Matém as inserções atômicas, usado por conta das inserções com foreach
$mysqli->autocommit(FALSE);

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $sql = "SELECT edt.edition_id
            FROM edition edt
            INNER JOIN (
                SELECT MAX(year) AS last_year
                FROM edition
                ORDER BY last_year DESC
                LIMIT 1
            ) AS LastYearTable ON edt.year = LastYearTable.last_year";

    $stmt = $mysqli->prepare($sql);

    if(!$stmt->execute()) {
        error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
        echo json_encode(["error" => "Erro de envio 4.1"]);
        exit(); 
    } else {
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $edition_id = $row['edition_id'];
        }
    }

    $result->free();
    $stmt->close();


    $sql = "SELECT MAX(registration_nr) AS last_registration 
            FROM registration
            ORDER BY last_registration DESC
            LIMIT 1";

    $stmt = $mysqli->prepare($sql);

    if(!$stmt->execute()){
        error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
        echo json_encode(["error" => "Erro de envio 4.2"]);
        exit(); 
    } else {

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row["last_registration"] === null) {
            $registration_nr = 1000;
        } else {
            $registration_nr = (int)$row["last_registration"] + 1;
        }
        $stmt->close();


        $sql = "INSERT INTO registration (registration_nr, edition_id) 
                VALUES (?, ?)";

        $stmt = $mysqli->prepare($sql);
        
        $stmt->bind_param("ii", $registration_nr, $edition_id);

        if(!$stmt->execute()){
            $mysqli->rollback();
            error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
            echo json_encode(["error" => "Erro de envio 4.3"]);
            exit(); 
        } else {
            $registration_id = $mysqli->insert_id;
        }

    }

    $stmt->close();


    $sql = "INSERT INTO bet (user_id, registration_id, edition_id, number)
            VALUES (?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();
    if ( ! $stmt->prepare($sql)) {
        error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
        echo json_encode(["error" => "Erro de envio 4.4"]);
    exit(); 
    }

    $user_id = $_SESSION["user_id"];

    $n1 = (int)$_POST['n1'];
    $n2 = (int)$_POST['n2'];
    $n3 = (int)$_POST['n3'];
    $n4 = (int)$_POST['n4'];
    $n5 = (int)$_POST['n5'];


    $numbers = [$n1, $n2, $n3, $n4, $n5];

    foreach ($numbers as $number) {
        $stmt->bind_param("iiii", $user_id, $registration_id, $edition_id, $number);
        
        if ( ! $stmt->execute()) {
            $mysqli->rollback();
            error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
            echo json_encode(["error" => "Erro de envio 4.5"]);
            exit(); 
        }
    }

    echo json_encode(["success" => true]);
    $result->free();
    $mysqli->commit();
    $stmt->close();

}

$mysqli->close();

?>