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

$result->free();
$stmt->close();

// Primeiramente cria um array ordenado de 1 até 50
$orderedNumbers = range(1, 50);
// Bagunça a ordem dos elementos no array
shuffle($orderedNumbers);
// Com as posições randomizadas, seleciona os cinco primeiros, começando do index zero
$drawnNumbers = array_slice($orderedNumbers, 0, 5);

/* TESTAR SORTEIO
$drawnNumbers = [1, 2, 3, 4, 5];
*/

$iterations = 0;
$foundWinner = false;
$winners = [];

// Executa pelo menos uma vez...
do {
    // A cada iteração a chave observada será atribuida a $registration_id, assim como o valor relacionado a essa chave é atribuida a $numbers pelo operador =>
    foreach ($registrations as $registration_id => $registration) {
        $numbers = $registration['numbers'];
        // Obtêm todos os valores existentes em ambos os arrays
        $matches = count(array_intersect($numbers, $drawnNumbers));
        
        if ($matches >= 5) {
            $winners[] = $registration_id;
            $foundWinner = true;
        }
    }

    // Se ainda não encontrou cinco números que deram match, então...
    if ( ! $foundWinner) {

        do {
            $newNumber = rand(1, 50);
        // Gera um novo número até que este não esteja contido no array de números sorteados
        } while (in_array($newNumber, $drawnNumbers));

        $drawnNumbers[] = $newNumber;
    }
    if( ! $foundWinner){
        $iterations++;
    }

// Repete o DO até encontrar um vencedor aou até adicionar vinte e cinco novos números
} while ( ! $foundWinner && $iterations < 25);

$sql = "SELECT number, COUNT(*) AS quantity
        FROM bet
        WHERE edition_id = (
            SELECT MAX(edition_id)
            FROM edition
        )
        GROUP BY number
        ORDER BY quantity DESC";

$stmt = $mysqli->prepare($sql);

if ( ! $stmt->execute()) {
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo json_encode(["error" => "Erro de envio 5.2"]);
    exit();
}

$result = $stmt->get_result();
$quantityNumbers = [];

// Só será falso ao tentar realizar o sorteio sem que tenha sido feito apostas
if ($result->num_rows > 0) {    
    while ($row = $result->fetch_assoc()) {
        $quantityNumbers[] = [
            'number' => $row['number'],
            'quantity' => $row['quantity']
        ];
    }
}


$output = [
    'iteration' => $iterations,
    'countWinners' => count($winners),
    'drawnNumbers' => $drawnNumbers,
    'winners' => [],
    'quantityNumbers' => $quantityNumbers
];


if ($foundWinner) {
    foreach ($winners as $winner) {
        $winnerData = $registrations[$winner];
        array_push($output['winners'], [
            'registration' => $winnerData['registration_nr'],
            'name' => $winnerData['name'],
            'cpf' => $winnerData['cpf']
        ]);

        $sqlSelect =    "SELECT wins 
                        FROM userr 
                        WHERE cpf = ?";
        $stmtSelect = $mysqli->prepare($sqlSelect);
        if ( ! $stmtSelect) {
            error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
            echo "Erro de envio 5.";
            exit();
        }

        $cpf = $winnerData['cpf'];
        $stmtSelect->bind_param("s", $cpf);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();
        $row = $result->fetch_assoc();
        $currentWins = $row['wins'] ?? 0;
        $stmtSelect->close();

        $newWins = $currentWins + 1;

        $sqlUpdate =    "UPDATE userr 
                        SET wins = ? 
                        WHERE cpf = ?";
        $stmtUpdate = $mysqli->prepare($sqlUpdate);
        if ( ! $stmtUpdate) {
            error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
            echo "Erro de envio 5.";
            exit();
        }

        $stmtUpdate->bind_param("is", $newWins, $cpf);
        if (!$stmtUpdate->execute()) {
            $mysqli->rollback();
            error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
            echo "Erro de envio 5.";
            exit();
        }
        $stmtUpdate->close();
    }
}

$result->free();
$stmt->close();

$sql = "SELECT MAX(year) AS last_year 
        FROM edition";

$stmt = $mysqli->prepare($sql);

if ( ! $stmt->execute()) {
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo json_encode(["error" => "Erro de envio 5."]);
    exit();
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();
$lastYear = $row['last_year'];
$newYear = (int)$lastYear + 1;


$stmt->close();

$sql = "INSERT INTO edition (year)
        VALUES (?)";

$stmt = $mysqli->stmt_init();
if ( ! $stmt->prepare($sql)) {
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo json_encode(["error" => "Erro de envio 5."]);
    exit(); 
}

$stmt->bind_param("i", $newYear);

if( ! $stmt->execute()){
    $mysqli->rollback();
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo json_encode(["error" => "Erro de envio 5."]);
    exit(); 
}

$mysqli->commit();
$stmt->close();

echo json_encode($output);
exit();

?>