
document.addEventListener('DOMContentLoaded', function() {

    validateNumber();
    validateAllFields();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            document.querySelector('.name').textContent = response.name;
        }
    };
    xhttp.open("GET", "../PHP/bet-name.php", true);
    xhttp.send();


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

        const form = document.querySelector('#form-numbers'); 
        const formData = new FormData(form);

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

function validateAllFields() {
    document.getElementById('submit-button').addEventListener('click', function(event) {
        event.preventDefault();

        const formData = new FormData();
        const inputs = document.querySelectorAll('.number');
        let allFields = true;

        inputs.forEach(function(input) {
            if ( ! input.value) {
                allFields = false;
            } else {
                formData.append(input.name, input.value);
            }
        });

        if ( ! allFields) {
            alert('Por favor, preencha todos os campos');
        } else {

            fetch('../PHP/bet-process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                console.log(result);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
}