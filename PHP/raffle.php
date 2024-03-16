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
    echo json_encode(["error" => "Erro de envio 5."]);
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

if ($foundWinner) {
    echo "Número de iterações: $iterations\n";
    echo "Quantidade de vencedores: " . count($winners) . "\n";
    foreach ($winners as $winner) {
        $winnerData = $registrations[$winner];
        echo "Sucesso: Registro $winnerData[registration_nr], Nome: $winnerData[name], CPF: $winnerData[cpf]\n";
    }
} else {
    echo "Nenhum ganhador após as 25 rodadas de sorteio.\n";
}

echo "Números sorteados:\n";
print_r($drawnNumbers);





$sql = "SELECT number, COUNT(*) AS quantidade
        FROM bet
        WHERE edition_id = (
            SELECT MAX(edition_id)
            FROM edition
        )
        GROUP BY number
        ORDER BY quantidade DESC";

$stmt = $mysqli->prepare($sql);

if ( ! $stmt->execute()) {
    error_log("Erro no SQL: " . $mysqli->error . " " . $mysqli->errno);
    echo json_encode(["error" => "Erro de envio 5."]);
    exit();
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = [];
    
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'number' => $row['number'],
            'quantidade' => $row['quantidade']
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);
}
exit();


?>