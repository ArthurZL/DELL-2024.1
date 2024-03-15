
document.addEventListener('DOMContentLoaded', function() {

    validateNumber();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.status == 200) {
            var response = JSON.parse(this.responseText);
            document.querySelector('.name').textContent = response.name;
        }
    };
    xhttp.open("GET", "../PHP/bet.php", true);
    xhttp.send();
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