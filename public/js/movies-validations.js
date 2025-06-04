function apenasLetras(texto) {
    return texto.replace(/[^a-záàâãéèêíïóôõöúçñ0-9 ]/gi, '');
}

function apenasNumeros(texto, limite) {
    texto = texto.replace(/\D/g, '');
    if (texto.length > limite) texto = texto.substring(0, limite);
    return texto;
}

function limparFormulario(form) {
    var inputs = form.querySelectorAll('input');
    inputs.forEach(function(input) {
        if (input.type === 'checkbox') {
            input.checked = true;
        } else {
            input.value = '';
        }
    });
    
    var selects = form.querySelectorAll('select');
    selects.forEach(function(select) {
        select.selectedIndex = 0;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var nomeInput = document.getElementById('nome');
    var anoInput = document.getElementById('ano');
    var codigoInput = document.getElementById('codigo');
    
    if (nomeInput) nomeInput.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    if (anoInput) anoInput.addEventListener('input', function() { this.value = apenasNumeros(this.value, 4); });
    if (codigoInput) codigoInput.addEventListener('input', function() { this.value = apenasNumeros(this.value, 5); });
    
    var nomeInputs = document.querySelectorAll('input[id^="nome"]');
    var anoInputs = document.querySelectorAll('input[id^="ano"]');
    var codigoInputs = document.querySelectorAll('input[id^="codigo"]');
    
    nomeInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    });
    
    anoInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = apenasNumeros(this.value, 4); });
    });
    
    codigoInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = apenasNumeros(this.value, 5); });
    });
    
    var modais = document.querySelectorAll('.modal');
    modais.forEach(function(modal) {
        var cancelarBtn = modal.querySelector('button[data-bs-dismiss="modal"]');
        if (cancelarBtn) {
            cancelarBtn.addEventListener('click', function() {
                var form = modal.querySelector('form');
                // Só limpa se for o modal de adicionar
                if (form && modal.id === 'addMovieModal') {
                    limparFormulario(form);
                }
            });
        }
    });
    
    modais.forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            var form = modal.querySelector('form');
            // Só limpa se for o modal de adicionar
            if (form && modal.id === 'addMovieModal') {
                limparFormulario(form);
            }
        });
    });
});