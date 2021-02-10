$("#cpf_cnpj").focus(function() {
    $("#phone").inputmask('remove');
    console.log('focus:', $(this).val().length, $(this).val());
});

$("#cpf_cnpj").blur(function() {
    console.log('blur:', $(this).val().length, $(this).val());

    // var size = $("#cpf_cnpj").val().length;
    // console.log($("#cpf_cnpj").val());
    // console.log('size:', size);
    // if (size > 11) {
    //     $("#cpf_cnpj").inputmask("99.999.999/9999-99");
    // } else if (size == 11) {
    //     $("#cpf_cnpj").inputmask("999.999.999-99");
    // }
});

$("#phone").keyup(function() {

    $("#phone").inputmask('remove');

    $("#phone").inputmask("(99) 9999[9]-9999");
});

$("#cep").keyup(function() {

    $("#cep").inputmask('remove');

    $("#cep").inputmask("99.999-999");
});