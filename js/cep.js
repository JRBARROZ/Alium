function clearForm() {
    //Limpa valores do formulário de cep.
    document.querySelector('#address').value = ("");
    document.querySelector('#neighborhood').value = ("");
    document.querySelector('#address_complement').value = ("");
    document.querySelector('#city').value = ("");
    document.querySelector('#state').value = ("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.querySelector('#address').value = (conteudo.logradouro);
        document.querySelector('#neighborhood').value = (conteudo.bairro);
        document.querySelector('#address_complement').value = (conteudo.complemento);
        document.querySelector('#city').value = (conteudo.localidade);
        document.querySelector('#state').value = (conteudo.uf);

        document.querySelector('#address').setAttribute("readonly", true);
        document.querySelector('#neighborhood').setAttribute("readonly", true);
        document.querySelector('#city').setAttribute("readonly", true);
        document.querySelector('#state').setAttribute("readonly", true);
    } //end if.
    else {
        //CEP não Encontrado.
        clearForm();
        alert("CEP não encontrado.");
    }
}

function searchPostalCode(element) {
    addPostalCodeMask(element);
    //Nova variável "cep" somente com dígitos.
    var cep = element.value.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.querySelector('#address').value = "...";
            document.querySelector('#neighborhood').value = "...";
            document.querySelector('#city').value = "...";
            document.querySelector('#state').value = "...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            clearForm();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        clearForm();
    }
};