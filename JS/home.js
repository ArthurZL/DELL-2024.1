
document.addEventListener('DOMContentLoaded', function() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            document.querySelector('.name').textContent = response.name;
        }
    };
    xhttp.open("GET", "../PHP/home.php", true);
    xhttp.send();

    document.getElementById('raffle-button').addEventListener('click', function() {
        fetch('../PHP/raffle.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    });

    document.getElementById('show-button').addEventListener('click', function() {
        fetch('../PHP/show.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    });
});

