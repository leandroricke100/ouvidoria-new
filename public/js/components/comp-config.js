$(document).ready(function () {

    let id_usuario = $('[id_usuario]').attr('id_usuario');
    modalConta(id_usuario);

    // $('#btnMenus').addClass('ativo');
    // $('.menu').show();
    // $('.conta').hide();
});

// function modalMenu() {
//     $('#btnMenus').addClass('ativo');
//     $('#btnMinhaConta').removeClass('ativo');
//     $('.conta').hide();
//     $('#table').show();
//     $('#add-new').show();

// }

function modalEndereco(){
    $('#btnEndereco').addClass('ativo');
    $('#btnMinhaConta').removeClass('ativo');


    $('.conta').hide();
    $('.menuEndereco').show();
}

function modalConta(id) {
    $('#btnMinhaConta').addClass('ativo');
    $('#btnEndereco').removeClass('ativo');

    // $('#table').hide();
    // $('#add-new').hide();

    $('.conta').show();
    $('.menuEndereco').hide();

    // $('.novo-menu').hide();
    // $('.button-cad-enviar').hide();
    // $('.btn-save-cad').show();

    let conta = id;

    $.ajax({
        url: '/api/OuvidoriaEditAccountAdmin',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            conta: conta
        },
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                //location.reload();

                let $frm = $('#cad-atendimento');

                let dados = resposta.menu;
                dados['senha'] = '';
                dados['nomeCompleto'] = dados.nome_completo;
                dados['dataNascimento'] = dados.data_nascimento;
                dados['funcao'] = dados.cargo;
                dados['emailAlternativo'] = dados.email_alternativo;
                dados['nomeFantasia'] = dados.nome_fantasia;
                dados['razaoSocial'] = dados.razao_social;
                dados['nomeContato'] = dados.contato_principal;
                dados['areaAtuacao'] = dados.area_atuacao;

                preencherForm($frm, dados);

                //popNotif({ msg: resposta.msg, time: 2000 });
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}

// function addNewMenu() {
//     $('#table').hide();
//     $('#add-new').hide();
//     $('.add-new').hide();
//     $('.novo-menu').show();
//     $('.saveEdit').hide();
//     $('.save').show();

// }

function saveCadastro() {
    let dadosForm = new FormData($('#cad-atendimento')[0]);

    const idAdmin = $('#id_dmin').val();
    dadosForm.append('idAdmin', idAdmin);

    $.ajax({
        url: '/api/OuvidoriaCadAtualizado',
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

    $('.save').hide();
    $('.saveEdit').show();

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


                //popNotif({ msg: resposta.msg, time: 2000 });

            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });

}

function saveEdit() {
    let dadosForm = new FormData($('#new-title-menu')[0]);


    let menuId = $('#menu_id').val();


    dadosForm.append('menuId', menuId);

    $.ajax({
        url: '/api/OuvidoriaSaveEditMenu',
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



function cancel() {
    location.reload();
}


$(() => $('form').submit(function (e) {
    salvarNovoMenu();
    saveCadastro();
    e.preventDefault();
}));
