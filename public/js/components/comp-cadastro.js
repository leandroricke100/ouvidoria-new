$(function () {
    $('[name="tipoCadastro"]').change(function () {
        let tipo = $('[name="tipoCadastro"]:checked').val();


        if (tipo === "pessoaFisica") {
            $(".pf").show();
            $(".pj").hide();
            $("#nomeFantasia").removeAttr("required");
        } else {
            $(".pf").hide();
            $(".pj").show();
            $("#nomeCompleto").removeAttr("required");
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

    const mostrarSenhaCheckbox = $('#mostarSenha');
    const senhaInput = $('#senha');
    const confirmarSenhaInput = $('#confirmarSenha');

    mostrarSenhaCheckbox.change(function () {
        if (mostrarSenhaCheckbox.prop('checked')) {
            senhaInput.prop('type', 'text');
            confirmarSenhaInput.prop('type', 'text');
        } else {
            senhaInput.prop('type', 'password');
            confirmarSenhaInput.prop('type', 'password');
        }
    });

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
        popNotif({ tipo: 'error', msg: 'A senha deve conter letra maiúscula e caractere especial.', time: 2000 });
        // alert('A senha deve conter letra maiúscula e caractere especial.')
        return false;
    }

    if (senha !== confirmarSenha) {
        popNotif({ tipo: 'error', msg: 'As senhas não coincidem.', time: 2000 });
        // alert('As senhas não coincidem.');
        return false;
    }

    if (senha.length < 8) {
        popNotif({ tipo: 'error', msg: 'A senha deve conter pelo menos 8 caracteres.', time: 2000 });
        // alert('A senha deve conter pelo menos 8 caracteres.');
        return false;
    }

    return true;
}

function efetuarCadastro() {
    const dadosForm = new FormData($('#cad-atendimento')[0]);

    const profissao = $('#profissao').val();
    dadosForm.append('profissao', profissao);

    const sexo = $('#sexo').val();
    dadosForm.append('sexo', sexo);

    const areaAtuacao = $('#areaAtuacao').val();
    dadosForm.append('areaAtuacao', areaAtuacao);

    $.ajax({
        url: '/api/OuvidoriaCadastro',
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: dadosForm,
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                popNotif({ msg: resposta.msg, time: 2000 });
                location.replace('/novo/atendimento');
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
            location.replace('/novo/atendimento');
        },
        error: function (XMLHttpRequest, xhr, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
            console.log(xhr.status);
            console.log(xhr.responseText);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}

$(() => $('#cad-atendimento').submit(function (e) {
    let validar_senha = validarSenha();

    if (validar_senha) efetuarCadastro();

    e.preventDefault();
}));
