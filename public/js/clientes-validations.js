/**
 * Funções de validação e formatação para o sistema de locadora
 */

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
        input.value = '';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Validações carregadas');
    
    var cpfInput = document.getElementById('cpf');
    var cepInput = document.getElementById('cep');
    var nomeInput = document.getElementById('nome');
    var idadeInput = document.getElementById('idade');
    var ruaInput = document.getElementById('rua');
    var numeroInput = document.getElementById('numero');
    var cidadeInput = document.getElementById('cidade');
    var bairroInput = document.getElementById('bairro');
    
    if (cpfInput) cpfInput.addEventListener('input', function() { this.value = formatCPF(this.value); });
    if (cepInput) cepInput.addEventListener('input', function() { this.value = formatCEP(this.value); });
    if (nomeInput) nomeInput.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    if (idadeInput) idadeInput.addEventListener('input', function() { this.value = limitarIdade(this.value); });
    if (ruaInput) ruaInput.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    if (numeroInput) numeroInput.addEventListener('input', function() { this.value = apenasNumeros(this.value); });
    if (cidadeInput) cidadeInput.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    if (bairroInput) bairroInput.addEventListener('input', function() { this.value = apenasLetras(this.value); });
    
    var cpfInputs = document.querySelectorAll('input[id^="cpf"]');
    var cepInputs = document.querySelectorAll('input[id^="cep"]');
    var nomeInputs = document.querySelectorAll('input[id^="nome"]');
    var idadeInputs = document.querySelectorAll('input[id^="idade"]');
    var ruaInputs = document.querySelectorAll('input[id^="rua"]');
    var numeroInputs = document.querySelectorAll('input[id^="numero"]');
    var cidadeInputs = document.querySelectorAll('input[id^="cidade"]');
    var bairroInputs = document.querySelectorAll('input[id^="bairro"]');
    
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
    
    var modais = document.querySelectorAll('.modal');
    modais.forEach(function(modal) {
        modal.addEventListener('shown.bs.modal', function() {
            console.log('Modal aberto, reaplicando validações');
        });
        
        var cancelarBtn = modal.querySelector('button[data-bs-dismiss="modal"]');
        if (cancelarBtn) {
            cancelarBtn.addEventListener('click', function() {
                console.log('Botão cancelar clicado, limpando formulário');
                var form = modal.querySelector('form');
                if (form) {
                    limparFormulario(form);
                }
            });
        }
    });
    
    modais.forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            console.log('Modal fechado, limpando formulário');
            var form = modal.querySelector('form');
            if (form) {
                limparFormulario(form);
            }
        });
    });
});