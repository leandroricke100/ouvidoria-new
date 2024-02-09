function login(id) {
    let $comp = $(`[comp-login=${id}]`);
    const email = $comp.find('[dd=emailLogin]').val();
    const senha = $comp.find('[dd=senhaLogin]').val();
    const cpfCnpj = $comp.find('[dd=entrarCnpj]').val();

    let dadosLogin = {
        email: email,
        senha: senha,
        cpfCnpj: cpfCnpj,
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
                popNotif({ msg: resposta.msg, time: 2000 });
                location.replace("/atendimentos");
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}

function loginModal(id) {
    let $comp = $(`[comp-login=${id}]`);
    const email = $comp.find('[dd=emailLoginModal]').val();
    const senha = $comp.find('[dd=senhaLoginModal]').val();
    const cpfCnpj = $comp.find('[dd=entrarCnpj]').val();

    let dadosLogin = {
        email: email,
        senha: senha,
        cpfCnpj: cpfCnpj,
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
                popNotif({ msg: resposta.msg, time: 2000 });
                location.replace("/atendimentos");
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}

function verificarEmail(id) {
    let $comp = $(`[comp-login=${id}]`);
    const email = $('[dd=emailLogin]').val();
    const senha = $('[dd=senhaLogin]');
    const cpfCnpj = $('[dd=entrarCnpj]').val();

    let dadosVerificarEmail = {
        email: email,
        cpfCnpj: cpfCnpj,
        metodo: 'verificarEmail',
    }

    $.ajax({
        url: '/api/OuvidoriaVerificarEmail',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: dadosVerificarEmail,
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                $('[dd=senhaLogin]').show();
                $('[dd=entrar]').show();
                $('[dd=prosseguir]').hide();
                senha.focus();
                popNotif({ msg: resposta.msg, time: 2000 });
            } else {
                location.replace('/cadastro');
                popNotif({ msg: 'Estamos redirecionando você, aguarde um instante...', time: 2000 });

                // popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
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

    $('[dd=entrarCnpj]').show();
    $('[dd=emailLogin]').hide();

    $('.btn-text-cnpj').show();
    $('.btn-text-email').hide();
}

function entrarEmail() {
    $('.text-cnpj-email').hide();
    $('.text-cpf-email').show();

    $('[dd=entrarCnpj]').hide();
    $('[dd=emailLogin]').show();

    $('.btn-text-cnpj').hide();
    $('.btn-text-email').show();
}
