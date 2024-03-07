let classicEditor = null;

$(document).ready(function () {

    ClassicEditor
        .create(document.querySelector('#atendimentoUsuario'))
        .then(editor => {
            classicEditor = editor;

        })
        .catch(error => {
            console.error(error);
        });

    const inpuAvaliacao = document.querySelectorAll('.rating__input');

    inpuAvaliacao.forEach(avaliacao => {
        avaliacao.addEventListener('change', enviarClassificacao);
    });



});

function enviarClassificacao() {

    let idAtendimento = document.getElementById('id_atendimento').value;
    let permitido = document.getElementById('permitido').value;

    const inpuAvaliacao = document.querySelectorAll('.rating__input');
    let classificacao = null;

    inpuAvaliacao.forEach(avaliacao => {
        if (avaliacao.checked) {

            classificacao = avaliacao.value;
            return;
        }
    });

    let dados = {
        classificacao: classificacao,
        id_atendimento: idAtendimento,
        permitido: permitido,
    };

    $.ajax({
        url: '/api/OuvidoriaClassificacao',
        type: "POST",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: dados, // Correção aqui
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                popNotif({ msg: resposta.msg, time: 2000 });

            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
                location.reload();
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });

}



function printPage() {
    window.print();
}

function deleteMsg(id) {


    $.ajax({
        url: '/api/OuvidoriaDeleteMensagem',
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

function respostaUsuario() {
    let dadosForm = new FormData($('#cad-resposta-user')[0]);

    let resposta = classicEditor.getData();
    dadosForm.append('atendimentoUsuario', resposta);


    $.ajax({
        url: '/api/OuvidoriaAtendimento',
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: dadosForm, // DADOS QUE TO ENVIANDO PRA FUNCTION BACKEND
        success: function (resposta) {
            console.log(resposta);
            if (resposta.status) {
                popNotif({ msg: resposta.msg, time: 2000 });
                location.reload();
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
            location.reload();
        },

        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
}

function submitResposta() {
    respostaUsuario();
}

$(() => $('form').submit(function (e) {
    respostaUsuario();
    e.preventDefault();
}));

$(() => {
    $('#situacao').change(function () {
        updateInput();
    });

})

function updateInput() {
    let inputSitucao = $('#situacao').val();
    let id = $('#atendimento_id').val();

    let dadosForm = {
        situacao: inputSitucao,
        id: id,
    };


    $.ajax({
        url: '/api/OuvidoriaInputAdmin',
        type: "POST",
        dataType: "json",
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






