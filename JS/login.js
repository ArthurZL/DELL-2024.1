
document.getElementById('cpf').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '').slice(0, 11);
});

document.getElementById('cpf').addEventListener('keydown', function(event) {
    if (event.code === 'Space') {
        event.preventDefault();
    }
});
