
let modifiedFields = {};


function isValidEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regex.test(email);
}

function isValidTelefone(telefone) {
    const numeros = telefone.replace(/\D/g, '');
    return numeros.length >= 10 && numeros.length <= 11;
}

function isValidCEP(cep) {
    const numeros = cep.replace(/\D/g, '');
    return numeros.length === 8;
}

function formatTelefone(value) {
    const numeros = value.replace(/\D/g, '');
    
    if (numeros.length <= 10) {
        return numeros.replace(/(\d{2})?(\d{4})?(\d{4})/, function(match, ddd, parte1, parte2) {
            let resultado = '';
            if (ddd) resultado += `(${ddd}) `;
            if (parte1) resultado += `${parte1}`;
            if (parte2) resultado += `-${parte2}`;
            return resultado;
        });
    } else {
        return numeros.replace(/(\d{2})?(\d{5})?(\d{4})/, function(match, ddd, parte1, parte2) {
            let resultado = '';
            if (ddd) resultado += `(${ddd}) `;
            if (parte1) resultado += `${parte1}`;
            if (parte2) resultado += `-${parte2}`;
            return resultado;
        });
    }
}

function formatCEP(value) {
    const numeros = value.replace(/\D/g, '');
    return numeros.replace(/^(\d{5})(\d{3}).*/, '$1-$2');
}


function mostrarErro(campo, mensagem) {

    const erroAnterior = campo.parentElement.querySelector('.erro-mensagem');
    if (erroAnterior) {
        erroAnterior.remove();
    }
    
    const erro = document.createElement('div');
    erro.className = 'erro-mensagem';
    erro.textContent = mensagem;
    campo.parentElement.appendChild(erro);
    
    campo.classList.add('campo-invalido');
}

function removerErro(campo) {
    const erro = campo.parentElement.querySelector('.erro-mensagem');
    if (erro) {
        erro.remove();
    }
    campo.classList.remove('campo-invalido');
}


document.addEventListener('DOMContentLoaded', function() {
    
    const editableCells = document.querySelectorAll('.editable');
    editableCells.forEach(cell => {
        const rowId = cell.closest('tr').getAttribute('id').replace('row-', '');
        const field = cell.getAttribute('data-field');
        const originalValue = cell.textContent.trim();
        
        
        if (!modifiedFields[rowId]) {
            modifiedFields[rowId] = {};
        }
        modifiedFields[rowId][field] = {
            original: originalValue,
            current: originalValue
        };
        
        
        setupEditableCell(cell);
    });

    const createForm = document.querySelector('form[action*="store"]');
    if (createForm) {
        setupCreateFormValidation(createForm);
    }
});


function setupEditableCell(cell) {
    const rowId = cell.closest('tr').getAttribute('id').replace('row-', '');
    const field = cell.getAttribute('data-field');
    const type = cell.getAttribute('data-type') || 'text';
    

        if (type === 'select') {
            const options = JSON.parse(cell.getAttribute('data-options'));
            let selectHtml = `<select class="form-select form-select-sm edit-field" data-field="${field}">`;
            
            for (const [value, text] of Object.entries(options)) {
            const selected = value === cell.textContent.trim() ? 'selected' : '';
                selectHtml += `<option value="${value}" ${selected}>${text}</option>`;
            }
            
            selectHtml += '</select>';
            cell.innerHTML = selectHtml;
        

        const select = cell.querySelector('select');
        select.addEventListener('change', function() {
            handleFieldChange(rowId, field, this.value);
        });
        } else {

        cell.addEventListener('input', function() {
            let value = this.textContent.trim();
            let isValid = true;
            

            switch(field) {
                case 'email':
                    isValid = isValidEmail(value);
                    if (!isValid) {
                        this.classList.add('invalid');
                        this.title = 'Email inválido';
                    }
                    break;
                    
                case 'telefone':
                    value = formatTelefone(value);
                    this.textContent = value;
                    isValid = isValidTelefone(value);
                    if (!isValid) {
                        this.classList.add('invalid');
                        this.title = 'Formato: (99) 99999-9999';
                    }
                    break;
                    
                case 'cep':
                    value = formatCEP(value);
                    this.textContent = value;
                    isValid = isValidCEP(value);
                    if (!isValid) {
                        this.classList.add('invalid');
                        this.title = 'Formato: 99999-999';
                    }
                    break;
            }
            
            if (isValid) {
                this.classList.remove('invalid');
                this.removeAttribute('title');
                handleFieldChange(rowId, field, value);
            }
        });
        
        cell.addEventListener('blur', function() {
            this.classList.remove('editing');
        });
        
        cell.addEventListener('focus', function() {
            this.classList.add('editing');
        });
    }
}

function handleFieldChange(rowId, field, newValue) {
    if (!modifiedFields[rowId]) {
        modifiedFields[rowId] = {};
    }
    
    modifiedFields[rowId][field].current = newValue;
    
    const cell = document.querySelector(`tr#row-${rowId} td[data-field="${field}"]`);
    if (newValue !== modifiedFields[rowId][field].original) {
        cell.classList.add('modified');
    } else {
        cell.classList.remove('modified');
    }
}


function saveAllChanges() {
    const submissionPromises = [];
    let hasChanges = false;

    for (const rowId in modifiedFields) {
        const form = document.getElementById(`update-form-${rowId}`);
        let rowHasChanges = false;
        
        for (const field in modifiedFields[rowId]) {
            const fieldData = modifiedFields[rowId][field];
            
            if (fieldData.current !== fieldData.original) {
                rowHasChanges = true;
                hasChanges = true;
                const hiddenInput = document.getElementById(`${field}-${rowId}`);
                hiddenInput.value = fieldData.current;
            }
        }
        
        if (rowHasChanges) {
            const formData = new FormData(form);
            
            const promise = fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => {
                if (!response.ok) {
                    throw new Error(`Erro ao salvar linha ${rowId}`);
                }
                return response;
            });
            
            submissionPromises.push(promise);
        }
    }
    
    if (!hasChanges) {
        alert('Nenhuma alteração para salvar.');
        return;
    }

    Promise.all(submissionPromises)
        .then(() => {
            window.location.reload();
        })
        .catch(error => {
            console.error('Erro ao salvar alterações:', error);
            alert('Ocorreu um erro ao salvar algumas alterações. A página será recarregada.');
            window.location.reload();
        });
}

function setupCreateFormValidation(form) {
    const emailInput = form.querySelector('#email');
    const telefoneInput = form.querySelector('#telefone');
    const cepInput = form.querySelector('#cep');
    
    emailInput.addEventListener('input', function() {
        const email = this.value.trim();
        if (email && !isValidEmail(email)) {
            mostrarErro(this, 'Por favor, insira um email válido');
        } else {
            removerErro(this);
        }
    });
    
    telefoneInput.addEventListener('input', function() {
        this.value = formatTelefone(this.value);
        if (this.value && !isValidTelefone(this.value)) {
            mostrarErro(this, 'Formato: (99) 99999-9999');
        } else {
            removerErro(this);
        }
    });
    
    cepInput.addEventListener('input', function() {
        this.value = formatCEP(this.value);
        if (this.value && !isValidCEP(this.value)) {
            mostrarErro(this, 'Formato: 99999-999');
        } else {
            removerErro(this);
            if (this.value.length === 9) {
                buscarEnderecoPorCEP(this.value);
            }
        }
    });
    
    form.addEventListener('submit', function(event) {
        let temErro = false;

        if (!isValidEmail(emailInput.value)) {
            mostrarErro(emailInput, 'Por favor, insira um email válido');
            temErro = true;
        }

        if (!isValidTelefone(telefoneInput.value)) {
            mostrarErro(telefoneInput, 'Por favor, insira um telefone válido');
            temErro = true;
        }

        if (!isValidCEP(cepInput.value)) {
            mostrarErro(cepInput, 'Por favor, insira um CEP válido');
            temErro = true;
        }

        if (temErro) {
            event.preventDefault();
            alert('Por favor, corrija os erros antes de enviar o formulário.');
        }
    });
} 