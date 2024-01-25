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

$(document).ready(function () {


    $('#protocolo').mask('0000.000.000');
    $('#cpf').mask('000.000.000-00', { reverse: true });
    $('#cnpj').mask('00.000.000/0000-00', { reverse: true });
    $('#celular').mask('(00) 0 0000-0000');
    $('#cep').mask('00000-000');
});

function validarSenha() {
    const senha = $("#senha").val();
    const confirmarSenha = $("#confirmarSenha").val();


    const senhaMaiscula = /[A-Z]/;
    const senhaCaracterEspecial = /[!@#$%^&*(),.?":{}|<>]/;

    if (!senhaMaiscula.test(senha) || !senhaCaracterEspecial.test(senha)) {
        alert('A senha deve conter letra maiúscula e caractere especial.')
        return false;
    }

    if (senha !== confirmarSenha) {
        alert('As senhas não coincidem.');
        return false;
    }

    if (senha.length < 8) {
        alert('A senha deve conter pelo menos 8 caracteres');
        return false;
    }
}

