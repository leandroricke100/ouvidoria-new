function login() {
    const email = $('#emailLogin').val();
    const senha = $('#senhaLogin').val();

    let dadosLogin = {
        email: email,
        senha: senha,
        metodo: 'login',
    }

    console.log(dadosLogin);

    $.ajax({
        url: '/api/OuvidoriaLogin',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: dadosLogin,
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                // SE LOGIN E SENHA FOR OK
                location.replace("/atendimentos");
            } else {

            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}

function loginModal() {
    const email = $('#emailLoginModal').val();
    const senha = $('#senhaLoginModal').val();

    let dadosLogin = {
        email: email,
        senha: senha,
        metodo: 'login',
    }

    console.log(dadosLogin);

    $.ajax({
        url: '/api/OuvidoriaLogin',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: dadosLogin,
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                // SE LOGIN E SENHA FOR OK
                location.replace("/atendimentos");
            } else {

            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}

function verificarEmail() {
    const email = $('#emailLogin').val();
    const senha = $('#senhaLogin');

    let dadosVerificarEmail = {
        email: email,
        metodo: 'verificarEmail',
    }

    $.ajax({
        url: '/api/OuvidoriaVerificarEmail',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { dados: dadosVerificarEmail },
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                $('#senhaLogin').show();
                $('#entrar').show();
                $('#prosseguir').hide();
                senha.focus()
            } else {
                location.replace('/cadastro')
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}

function cnpjCpf() {
    $('.text-cnpj-email').show();
    $('.text-cpf-email').hide();


    $('.btn-text-cnpj').show();
    $('.btn-text-email').hide();
}

function entrarEmail() {
    $('.text-cnpj-email').hide();
    $('.text-cpf-email').show();
    $('.btn-text-cnpj').hide();
    $('.btn-text-email').show();
}