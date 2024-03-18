document.addEventListener('DOMContentLoaded', function() {

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
    
});