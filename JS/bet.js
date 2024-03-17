import { searchTrophy } from './util.js';

document.addEventListener('DOMContentLoaded', function() {

    validateNumber();
    generateIcon();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            document.querySelector('.name').textContent = response.name;
        }
    };
    xhttp.open("GET", "../PHP/bet-name.php", true);
    xhttp.send();

    document.getElementById('random-surprise').addEventListener('click', function() {
        let drawnNumbers = generateRandomNumbers(1, 50, 5);
        
        for (let i = 0; i < drawnNumbers.length; i++) {
            // Busca o elemento com ID que começa com "n" e termina com valores de 1 até 5
            document.getElementById(`n${i + 1}`).value = drawnNumbers[i];
        }
    });

    const betButton = document.querySelector('#submit-button');
    betButton.addEventListener('click', function(event) {
        event.preventDefault();

        var formCheck = document.getElementById('form-numbers');
        var formDataCheck = new FormData(formCheck);

        if ( ! formDataCheck.get('n1') || 
            ! formDataCheck.get('n2') ||
            ! formDataCheck.get('n3') ||
            ! formDataCheck.get('n4') ||
            ! formDataCheck.get('n5')) {
                
            alert("É necessário preencher os cinco campos");
            return;
        }

        const nums = [
            formDataCheck.get('n1'), 
            formDataCheck.get('n2'), 
            formDataCheck.get('n3'), 
            formDataCheck.get('n4'), 
            formDataCheck.get('n5')
        ].map(num => String(Number(num))); 
        /* LOGICA:
        Cria um novo array através do map com cada elemento do array original, 
        esse valores são convertidos para String para melhor manipulação do forms, 
        o Number é uma manobrar para remover quaisquers sequências de zeros na frente dos numerais
        */
       
        // Set armazena valores distintos, se o tamanho dele for maior que o tamanho original, significa que há valores repetidos
        const uniqueNums = new Set(nums);
        if (uniqueNums.size !== nums.length) {
            alert("Não podem haver números repetidos");
            return;
        }

        const formData = new FormData();
        nums.forEach((num, index) => {
            formData.append(`n${index + 1}`, num);
        });

        fetch('../PHP/bet-process.php', { 
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    });
});


function validateNumber() {

    var inputsNumber = document.querySelectorAll('.number');

    inputsNumber.forEach(function(input) {
        input.addEventListener('change', function() {
            // Especifica que value será um número decimal (base 10)
            var value = parseInt(this.value, 10);

            if (value < 1) {
                this.value = 1;
            } else if (value > 50) {
                this.value = 50;
            }
        });
    });

}


function generateRandomNumbers(min, max, count) {
    let numbers = new Set();
    
    while(numbers.size < count) {
        /*LÓGICA:
        Math.floor gera um número inteiro arredondando um flutuante para baixo, por isso de haver um "+ min" no final, garantido que possa haver os valores 1 e 50
        Math.random gera números de no intervalo de 0 e 1
        (max - min + 1) é a lógica de ajuste, o intervalo de 50 - 1 gera 49 números possíveis, assim adicionamos +1 para fechar os 50 valores possíveis desejados
        */
        let number = Math.floor(Math.random() * (max - min + 1)) + min;
        numbers.add(number);
    }
    
    return Array.from(numbers);
}

function generateIcon(){
    fetch('../PHP/bet-trophy.php')
    .then(response => response.json())
    .then(data => {
        const wins = data.wins;
        let icons = '';
        const maxIcons = wins > 10 ? 10 : wins;
        for (let i = 0; i < maxIcons; i++) {
            icons += searchTrophy();
        }
        document.querySelector('.img-container').innerHTML = icons;
    })
    .catch(error => console.error('Erro:', error));
}