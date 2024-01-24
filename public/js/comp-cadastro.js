$(function () {
    $('[name="tipoCadastro"]').change(function () {
        let tipo = $('[name="tipoCadastro"]:checked').val();

        if (tipo === "pessoaFisica") {
            $(".pf").show();
            $(".pj").hide();
            $("#razaoSocial, #cnpj, #nomeResponsavel").removeAttr("required");
        } else {
            $(".pf").hide();
            $(".pj").show();
            $("#nomeCompleto, #cpf").removeAttr("required");
        }
    });

    $('[name="tipoCadastro"]').change();


    $('#confirmarSenha').change(function () {
        let conf_senha = $(this).val();
        let senha = $('#senha').val();

        if (senha != conf_senha) {
            $('.msg-senha').show();
        } else {
            $('.msg-senha').hide();
        }
    });

    $('#confirmar-nova-senha').change(function () {
        let conf_senha = $(this).val();
        let senha = $('#senha-nova').val();

        if (senha != conf_senha) {
            $('.confirmar-senha').show();
        } else {
            $('.confirmar-senha').hide();
        }
    });

});
