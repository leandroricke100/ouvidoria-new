$(document).ready(function () {

    $('#btnMenus').addClass('ativo');
    $('.menu').show();
    $('.conta').hide();
});

function modalMenu() {
    $('#btnMenus').addClass('ativo');
    $('#btnMinhaConta').removeClass('ativo');
    $('.conta').hide();
    $('#table').show();
    $('#add-new').show();

}

function modalConta() {
    $('#btnMinhaConta').addClass('ativo');
    $('#btnMenus').removeClass('ativo');
    $('#table').hide();
    $('#add-new').hide();
    $('.conta').show();
    $('.novo-menu').hide();
}

function addNewMenu() {
    $('#table').hide();
    $('#add-new').hide();
    $('.add-new').hide();
    $('.novo-menu').show();
}

function salvarNovoMenu() {
    let dadosForm = new FormData($('#new-title-menu')[0]);

    $.ajax({
        url: '/api/OuvidoriNovoMenu',
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
                //location.reload();
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}


$(() => $('form').submit(function (e) {
    salvarNovoMenu();
    e.preventDefault();
}));
