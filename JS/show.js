import { createTableShow } from './util.js';

document.addEventListener('DOMContentLoaded', function() {
    fetch('../PHP/show.php')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const tableBody = document.querySelector('.table-body');
        tableBody.innerHTML = createTableShow(data);

    })
    .catch(error => {
        console.error('Erro:', error);
    });
});
