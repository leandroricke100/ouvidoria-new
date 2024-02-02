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
        url: '/api/OuvidoriaNovoMenu',
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

function deleteMenu(id) {

    $.ajax({
        url: '/api/OuvidoriaDeleteMenu',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            id: id
        },
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

function editMenu(id) {

    let menu = id;

    $.ajax({
        url: '/api/OuvidoriaEditMenu',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            menu: menu
        },
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                //location.reload();

                $('#table').hide();
                $('#add-new').hide();
                $('.add-new').hide();
                $('.novo-menu').show();

                $('#titulo').val(resposta.menu.titulo);
                $('#conteudo-pagina').val(resposta.menu.conteudo);
                $('#link').val(resposta.menu.slog);
                if (resposta.menu.status == 0) {
                    $('#status').val('Desativado');
                } else {
                    $('#status').val('Ativado');
                }


                popNotif({ msg: resposta.msg, time: 2000 });

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
