$(function () {
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.login-modal-mobile').length && !$(e.target).closest('.btn-menu-mobile').length) {
            closeMenuMobile();
        }
    });
});

$(document).ready(function () {
    $('#codigo').mask('0000.000.000');



});


function openSearchBtn() {

    if ($(".search-options").is(":visible")) {

        $(".search-options").hide();
    } else {

        $(".search-options").show();
    }
}

function openMenuMobile() {
    $('.login-modal-mobile').fadeIn(200);
    $('.open-mm').hide();
    $('.close-mm').show();
}

function closeMenuMobile() {
    $('.login-modal-mobile').fadeOut(200);
    $('.open-mm').show();
    $('.close-mm').hide();
    // $('#fundo-blur').hide();
}

function cad() {
    location.replace('/cadastro');
}

function modalLoginUser() {

    $('#fundo-blur').show();
    $('.modal-login').fadeIn(300);
    $('.input-login').hide();
    $('.input-login-modal').show();

    //location.replace('/login');
}

function cadastro() {
    let email = $('#emailLogin').val();

    $.ajax({
        url: '/api/OuvidoriaLogin',
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: email,
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                popNotif({ msg: resposta.msg, time: 2000 });
                location.reload();
            } else {

                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}

function closeModal() {
    $('.modal-login').hide();
    $('.input-login').show();
    $('.input-login-modal').hide();
    $('#fundo-blur').hide();
}


function modalSair() {
    if ($(".modal-sair").is(":visible")) {
        $(".modal-sair").hide();
    } else {
        $(".modal-sair").show();
    }
}

function sair() {

    $.ajax({
        url: '/api/OuvidoriaLogin',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            metodo: 'sair',
        },
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                popNotif({ msg: resposta.msg, time: 2000 });
                location.replace('/');
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });

}

function buscarCodigo() {
    let numberProtocolo = $('#codigo').val();


    $.ajax({
        url: '/api/OuvidoriaBuscarProtocolo',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { protocolo: numberProtocolo },
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                popNotif({ msg: resposta.msg, time: 2000 });
                //console.log(resposta.link);
                location.replace(resposta.link);
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}

function configuracao() {
    location.replace('/configuracao')
}


