let form = document.querySelector('.form');

form.onsubmit = function(event) {
    let list = document.querySelector('#error-form');
    list.innerHTML = '';

    let errors = 0;
    let name = document.querySelector('#name').value;
    let cpf_cnpj = document.querySelector('#cpf_cnpj').value;
    let email = document.querySelector('#email').value;
    let phone = document.querySelector('#phone').value;
    let cep = document.querySelector('#cep').value;
    let address = document.querySelector('#address').value;
    let address_complement = document.querySelector('#address_complement').value;
    let neighborhood = document.querySelector('#neighborhood').value;
    let city = document.querySelector('#city').value;
    let state = document.querySelector('#state').value;
    let password = document.querySelector('#password').value;
    let confirm_password = document.querySelector('#confirm_password').value;

    const regexName = /[^A-Za-z\s]/g;
    const regexOnlyNumbers = /[A-Za-z]/g;
    const regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (regexName.test(name)) {
        let li = document.createElement('li');
        li.innerHTML = "<strong>●</strong> O nome não pode conter números ou caracteres especiais.";
        list.appendChild(li);
        errors++;
    }
    if (regexOnlyNumbers.test(cpf_cnpj)) {
        let li = document.createElement('li');
        li.innerHTML = "<strong>●</strong> O campo CPF/CNPJ só aceita números.";
        list.appendChild(li);
        errors++;
    }
    if (cpf_cnpj.length > 14) {
        if (!validarCNPJ(cpf_cnpj)) {
            let li = document.createElement('li');
            li.innerHTML = "<strong>●</strong> O CNPJ informado é inválido.";
            list.appendChild(li);
            errors++;
        }
    } else {
        if (!validarCPF(cpf_cnpj)) {
            let li = document.createElement('li');
            li.innerHTML = "<strong>●</strong> O CPF informado é inválido.";
            list.appendChild(li);
            errors++;
        }
    }
    if (!regexEmail.test(email)) {
        let li = document.createElement('li');
        li.innerHTML = "<strong>●</strong> E-mail inválido.";
        list.appendChild(li);
        errors++;
    }
    if (regexOnlyNumbers.test(phone)) {
        let li = document.createElement('li');
        li.innerHTML = "<strong>●</strong> O campo Telefone só aceita números.";
        list.appendChild(li);
        errors++;
    }
    if (name.trim() == '' ||
        cpf_cnpj.trim() == '' ||
        email.trim() == '' ||
        phone.trim() == '' ||
        cep.trim() == '' ||
        address.trim() == '' ||
        neighborhood.trim() == '' ||
        city.trim() == '' ||
        state.trim() == '' ||
        password.trim() == '' ||
        confirm_password.trim() == ''
    ) {
        let li = document.createElement('li');
        li.innerHTML = "<strong>●</strong> Existem campos obrigatórios não preenchidos.";
        list.appendChild(li);
        errors++;
    }
    if (password !== confirm_password) {
        let li = document.createElement('li');
        li.innerHTML = "<strong>●</strong> As senhas estão diferentes.";
        list.appendChild(li);
        errors++;
    }
    if (errors != 0) {
        document.querySelector('.error-message-form').style.display = "block";
        event.preventDefault();
    }
}

function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '') return false;
    // Elimina CPFs invalidos conhecidos    
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito    
    add = 0;
    for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito    
    add = 0;
    for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}

function validarCNPJ(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '') return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;

}