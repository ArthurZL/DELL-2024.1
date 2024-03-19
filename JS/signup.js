document.getElementById('form-credentials').addEventListener('submit', function(event) {

    event.preventDefault();

    var name = document.getElementById('name').value;
    var cpf = document.getElementById('cpf').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm-password').value;

    // Validações e exibição dos erros
    var errors = [];

    if (name.trim() === '') {
        errors.push("Campo Usuário é requerido.");
    }

    if (cpf.trim() === '') {
        errors.push("Campo CPF é requerido.");
    }

    if (password !== confirmPassword) {
        errors.push("Senhas devem ser correspondentes.");
    }

    if (errors.length > 0) {
        alert("Erros encontrados:\n\n" + errors.join("\n"));
        return false;
    }

    this.submit();
});

document.getElementById('cpf').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '').slice(0, 11);
});

document.getElementById('cpf').addEventListener('keydown', function(event) {
    if (event.code === 'Space') {
        event.preventDefault();
    }
});
