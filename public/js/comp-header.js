function openSearchBtn() {

    if ($(".search-options").is(":visible")) {

        $(".search-options").hide();
    } else {

        $(".search-options").show();
    }
}

// function openMenuMobile() {
//     alert('teste')
// }

function openModalLogin() {
    $('.modal-login').show();
    $('.input-login').hide();
    $('.input-login-modal').show();
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

                location.reload();
            } else {

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
                location.reload();
            } else {

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
                //popNotif({ msg: resposta.msg, time: 2000 });
                location.replace(resposta.link);
            } else {
                //popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}

$(document).ready(function () {
    $('#codigo').mask('0000.000.000');
});


