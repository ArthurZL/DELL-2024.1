document.addEventListener('DOMContentLoaded', function() {

    fetch('../PHP/raffle.php')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        document.getElementById('extra-draws').textContent = data.iteration;
        document.getElementById('number-winners').textContent = data.countWinners;
        
        const drawnNumbersFormatted = data.drawnNumbers.reduce((accumulator, number, index) => {
            // Calcula em que linha os número devem ser colocados (index 0 até 9 é linha 1, index 10 até 19 é linha 2 e index 20 até 29 é linha 3)
            const currentLine = Math.floor(index / 10);
            // Ao chegar no memomento de ter uma nova linha, isso garante que haverá um array disponível
            if ( ! accumulator[currentLine]) { 
                accumulator[currentLine] = []; 
            }
            // Adição do zero na frente dos numerais com um digito para melhor alinhamento na exibição
            const numberFormatted = String(number).padStart(2, '0');
            accumulator[currentLine].push(numberFormatted);
            return accumulator;
        }, []).map(line => line.join(', ')).join('\n'); // O array de arrays é mapeado, separando os elementos por vírgulo e ao final adicionando uma quebra de linha
        document.getElementById('drawn-numbers').innerHTML = drawnNumbersFormatted.replace(/\n/g, '<br>'); // Substitui "\n" por "<br>" em virtude do HTML

        const winnersContainer = document.getElementById('container-winners');
        winnersContainer.innerHTML = '';
        if (data.winners.length > 0) {
            data.winners.forEach((winner) => {
                const winnerInfo = document.createElement('p');
                winnerInfo.innerHTML = `Registro: ${winner.registration}<br>Nome: ${winner.name}<br>CPF: ${winner.cpf}<br>`;
                winnersContainer.appendChild(winnerInfo);
            });
        } else {
            // Caso não existam vencedores, exibe "Sem Vencedores"
            const noWinnersMsg = document.createElement('p');
            noWinnersMsg.textContent = 'Sem Vencedores';
            winnersContainer.appendChild(noWinnersMsg);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
    });
});