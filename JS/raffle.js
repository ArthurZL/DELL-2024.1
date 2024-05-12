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

        const containerWinners = document.getElementById('container-winners');
        containerWinners.innerHTML = '';
        if (data.winners.length > 0) {
            // Boa prática de remoção de classe para evitar possíveis erros
            containerWinners.classList.remove('text-center');
            containerWinners.classList.add('text-left');
            // Para cada vencedor no array de winner será criado dinamicamente suas informações, ao adicionando o nó no container-winners
            data.winners.forEach((winner) => {
                const winnerInfo = document.createElement('p');
                winnerInfo.classList.add('winner-entry');
                winnerInfo.innerHTML = 
                    `
                    <span class="label">Registro:</span><span class="value">${winner.registration}</span><br>
                    <span class="label">Nome:</span><span class="value">${winner.name}</span><br>
                    <span class="label">CPF:</span><span class="value">${winner.cpf}</span><br>
                    `;
                containerWinners.appendChild(winnerInfo);
            });
        } else {
            // Boa prática de remoção de classe para evitar possíveis erros
            containerWinners.classList.remove('text-left');
            containerWinners.classList.add('text-center');
            // Cria parágrafo e texto, então associa um ao outro
            const zeroWinners = document.createElement('p');
            zeroWinners.textContent = 'Sem Vencedores';
            containerWinners.appendChild(zeroWinners);
        }

        const tbody = document.querySelector('.table-body');
        const quantityNumbers = data.quantityNumbers;
        // Para cada array dentro do array, cria uma linha e as duas células, associas os valores de números e quantidade, cria a classe, associa as tds com tr e por fim a tr com tbody
        quantityNumbers.forEach(line => { 
            const tr = document.createElement('tr');
            const tdNumber = document.createElement('td');
            const tdQuantity = document.createElement('td');
            tdNumber.textContent = line.number;
            tdQuantity.textContent = line.quantity;
            tdNumber.classList.add('column');
            tdQuantity.classList.add('column');
            tr.appendChild(tdNumber);
            tr.appendChild(tdQuantity);
            tbody.appendChild(tr);
        });
    })
    .catch(error => {
        console.error('Erro:', error);
    });
});