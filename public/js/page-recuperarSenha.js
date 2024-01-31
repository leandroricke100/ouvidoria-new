function recuperarSenha() {
    let email = $("#recuperarSenha").val();

    if (email == "") return alert("Preencha um email");

    emailCadastrado = {
        email: email,
    }

    $.ajax({
        url: '/api/OuvidoriaRecuperarSenha',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: emailCadastrado,
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                $('.container').hide();
                $('.container-nova-password').show();
            } else {

            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });

}

$(document).ready(function () {

    const mostrarSenhaCheckbox = $('#mostarSenha');
    const senhaInput = $('#senha-nova');
    const confirmarSenhaInput = $('#confirmar-nova-senha');

    mostrarSenhaCheckbox.change(function () {
        if (mostrarSenhaCheckbox.prop('checked')) {
            senhaInput.prop('type', 'text');
            confirmarSenhaInput.prop('type', 'text');
        } else {
            senhaInput.prop('type', 'password');
            confirmarSenhaInput.prop('type', 'password');
        }
    });
});

function salvarNovaSenha() {
    let senha = $("#senha-nova").val();
    let confirmarSenha = $("#confirmar-nova-senha").val();
    let token = $('#token').val();
    let email = $("#recuperarSenha").val();


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

    if (!token) {
        alert('Infome o token')
        return false;
    }

    if (senha.length < 8) {
        alert('A senha deve conter pelo menos 8 caracteres');
        return false;
    }

    let dadosSenha = {
        email: email,
        token: token,
        senha: senha,
        confirmarSenha: confirmarSenha,
    }

    $.ajax({
        url: '/api/OuvidoriaNovaSenha',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: dadosSenha,
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {

                location.replace("/login");
            } else {

            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}
