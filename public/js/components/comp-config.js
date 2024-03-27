let classicEditor = null;

$(document).ready(function () {

    ClassicEditor
        .create(document.querySelector('#enderecoCompleto'))
        .then(editor => {
            classicEditor = editor;

        })
        .catch(error => {
            console.error(error);
        });




    let id_usuario = $('[id_usuario]').attr('id_usuario');
    modalConta(id_usuario);
    $('[dd=cep]').mask('00000-000');

    var $input = document.getElementById('arquivo'),
        $fileName = document.getElementById('file-name');

    $input.addEventListener('change', function () {

        if ($input.value.length > 0) {
            $fileName.textContent = this.value;
        } else {
            $fileName.textContent = 'Nenhum arquivo selecionado';
        }
    });

});



function modalEndereco() {
    $('#btnEndereco').addClass('ativo');
    $('#btnMinhaConta').removeClass('ativo');
    $('.conta').hide();
    $('.menuEndereco').show();
    $('.btn-cancel-cad').show();

    let idEndereco = 1;

    $.ajax({
        url: '/api/OuvidoriaEditInformacao',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            idEndereco: 1
        },
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                $('#nomeMunicipio').val(resposta.endereco.titulo);
                // $('#arquivo').val(resposta.endereco.arquivo);

                classicEditor.setData(resposta.endereco.informacoes);

            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}

function saveInfo() {
    let dadosForm = new FormData($('#endereco-form')[0]);

    dadosForm.append('enderecoCompleto', classicEditor.getData());
    dadosForm.append('nomeMunicipio', $('#nomeMunicipio').val());

    $.ajax({
        url: '/api/OuvidoriaInfoAtualizado',
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

function modalConta(id) {
    $('#btnMinhaConta').addClass('ativo');
    $('#btnEndereco').removeClass('ativo');

    // $('#table').hide();
    // $('#add-new').hide();

    $('.conta').show();
    $('.menuEndereco').hide();

    // $('.novo-menu').hide();
    $('.button-cad-enviar').hide();
    $('.btn-save-cad').show();

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
                dados['emailAlternativo'] = dados.email_alternativo;
                dados['nomeFantasia'] = dados.nome_fantasia;
                dados['razaoSocial'] = dados.razao_social;
                dados['nomeContato'] = dados.contato_principal;
                dados['areaAtuacao'] = dados.area_atuacao;

                preencherForm($frm, dados);


                //location.reload();

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




function cancel() {
    location.reload();
}


$(() => $('form').submit(function (e) {
    saveCadastro();
    saveInfo();
    e.preventDefault();
}));


