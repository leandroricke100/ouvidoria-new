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

$(document).ready(function () {

    $('[dd=entrarCnpj]').keydown(function(){
        try {
            $('[dd=entrarCnpj]').unmask();
        } catch (e) {}

        var tamanho = $('[dd=entrarCnpj]').val().length;

        if(tamanho < 11){
            $('[dd=entrarCnpj]').mask("999.999.999-99");
        } else {
            $('[dd=entrarCnpj]').mask("99.999.999/9999-99");
        }

        // ajustando foco
        var elem = this;
        setTimeout(function(){
            // mudo a posição do seletor
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);
        // reaplico o valor para mudar o foco
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });
});


function verificarEmail(id) {
    let $comp = $(`[comp-login=${id}]`);
    const email = $('[dd=emailLogin]').val();
    const senha = $('[dd=senhaLogin]').val();
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
                $('.container-password').show();
                $('[dd=entrar]').show();
                $('[dd=prosseguir]').hide();
                senha.focus();
                popNotif({ msg: resposta.msg, time: 2000 });
            } else {
                location.replace('/cadastro');
                popNotif({ msg: 'Estamos redirecionando você, aguarde um instante...', time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}

function senhaMostrar() {

    const senhaInput = $('[dd=senhaLogin]');

    $('[dd=ocultar]').show();
    $('[dd=mostrar]').hide();

    senhaInput.attr('type', 'text');

}

function senhaOcultar() {
    const senhaInput = $('[dd=senhaLogin]');

    $('[dd=ocultar]').hide();
    $('[dd=mostrar]').show();

    senhaInput.attr('type', 'password');
}


function cnpjCpf() {
    $('.text-cnpj-email').show();
    $('.text-cpf-email').hide();


    $('[dd=emailLoginModal]').hide();


    $('[dd=entrarCnpj]').show();
    $('[dd=emailLogin]').hide();

    $('.btn-text-cnpj').show();
    $('.btn-text-email').hide();
}

function entrarEmail() {
    $('.text-cnpj-email').hide();
    $('.text-cpf-email').show();

    $('[dd=emailLoginModal]').show();

    $('[dd=entrarCnpj]').hide();
    $('[dd=emailLogin]').show();

    $('.btn-text-cnpj').hide();
    $('.btn-text-email').show();
}

function mostrarSenha() {
    const senhaInput = $('[dd=senhaLoginModal]');

    $('#ocultar').show();
    $('#mostrar').hide();

    senhaInput.attr('type', 'text');
}

function ocultarSenha() {
    const senhaInput = $('[dd=senhaLoginModal]');

    $('#ocultar').hide();
    $('#mostrar').show();

    senhaInput.attr('type', 'password');
}
