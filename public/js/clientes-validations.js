function formatCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    if (cpf.length > 11) cpf = cpf.substring(0, 11);
    if (cpf.length > 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    } else if (cpf.length > 6) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})/, '$1.$2.$3');
    } else if (cpf.length > 3) {
        cpf = cpf.replace(/(\d{3})(\d{3})/, '$1.$2');
    }
    
    return cpf;
}

function formatTelefone(telefone) {
    telefone = telefone.replace(/\D/g, '');
    if (telefone.length > 11) telefone = telefone.substring(0, 11);
    
    if (telefone.length > 10) {
        telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    } else if (telefone.length > 6) {
        telefone = telefone.replace(/(\d{2})(\d{4})(\d+)/, '($1) $2-$3');
    } else if (telefone.length > 2) {
        telefone = telefone.replace(/(\d{2})(\d+)/, '($1) $2');
    }
    
    return telefone;
}

function formatCEP(cep) {
    cep = cep.replace(/\D/g, '');
    if (cep.length > 8) cep = cep.substring(0, 8);
    
    if (cep.length > 5) {
        cep = cep.replace(/(\d{5})(\d{3})/, '$1-$2');
    }
    
    return cep;
}

function apenasLetras(texto) {
    return texto.replace(/[^a-záàâãéèêíïóôõöúçñ ]/gi, '');
}

function apenasNumeros(texto) {
    texto = texto.replace(/\D/g, '');
    if (texto.length > 5) texto = texto.substring(0, 5);
    return texto;
}

function limitarIdade(idade) {
    idade = idade.replace(/\D/g, '');
    if (idade.length > 2) idade = idade.substring(0, 2);
    return idade;
}

function limparFormulario(form) {
    var inputs = form.querySelectorAll('input');
    inputs.forEach(function(input) {
        if (input.type === 'checkbox') {
            input.checked = false;
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
    var cpfInput = document.getElementById('cpf');
    var cepInput = document.getElementById('cep');
    var nomeInput = document.getElementById('nome');
    var idadeInput = document.getElementById('idade');
    var ruaInput = document.getElementById('rua');
    var numeroInput = document.getElementById('numero');
    var cidadeInput = document.getElementById('cidade');
    var bairroInput = document.getElementById('bairro');
    var telefoneInput = document.getElementById('telefone');
    
    if (cpfInput) cpfInput.addEventListener('input', function() { this.value = formatCPF(this.value); });
    if (cepInput) cepInput.addEventListener('input', function() { this.value = formatCEP(this.value); });
    if (nomeInput) nomeInput.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    if (idadeInput) idadeInput.addEventListener('input', function() { this.value = limitarIdade(this.value); });
    if (ruaInput) ruaInput.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    if (numeroInput) numeroInput.addEventListener('input', function() { this.value = apenasNumeros(this.value); });
    if (cidadeInput) cidadeInput.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    if (bairroInput) bairroInput.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    if (telefoneInput) telefoneInput.addEventListener('input', function() { this.value = formatTelefone(this.value); });
    
    var cpfInputs = document.querySelectorAll('input[id^="cpf"]');
    var cepInputs = document.querySelectorAll('input[id^="cep"]');
    var nomeInputs = document.querySelectorAll('input[id^="nome"]');
    var idadeInputs = document.querySelectorAll('input[id^="idade"]');
    var ruaInputs = document.querySelectorAll('input[id^="rua"]');
    var numeroInputs = document.querySelectorAll('input[id^="numero"]');
    var cidadeInputs = document.querySelectorAll('input[id^="cidade"]');
    var bairroInputs = document.querySelectorAll('input[id^="bairro"]');
    var telefoneInputs = document.querySelectorAll('input[id^="telefone"]');
    
    cpfInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = formatCPF(this.value); });
    });
    
    cepInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = formatCEP(this.value); });
    });
    
    nomeInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    });
    
    idadeInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = limitarIdade(this.value); });
    });
    
    ruaInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    });
    
    numeroInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = apenasNumeros(this.value); });
    });
    
    cidadeInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    });
    
    bairroInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    });
    
    telefoneInputs.forEach(function(input) {
        input.addEventListener('input', function() { this.value = formatTelefone(this.value); });
    });
    
    var modais = document.querySelectorAll('.modal');
    modais.forEach(function(modal) {
        var cancelarBtn = modal.querySelector('button[data-bs-dismiss="modal"]');
        if (cancelarBtn) {
            cancelarBtn.addEventListener('click', function() {
                var form = modal.querySelector('form');
                // Só limpa se for o modal de adicionar
                if (form && modal.id === 'addClienteModal') {
                    limparFormulario(form);
                }
            });
        }
    });
    
    modais.forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            var form = modal.querySelector('form');
            // Só limpa se for o modal de adicionar
            if (form && modal.id === 'addClienteModal') {
                limparFormulario(form);
            }
        });
    });
});