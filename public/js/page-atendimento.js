function printPage() {
    window.print();
}

function deleteMsg(id) {

    console.log(id)
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

                location.reload();
            } else {

            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });


}

function respostaUsuario() {
    let dadosForm = new FormData($('#cad-resposta-user')[0]);

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

                //location.reload();
            } else {

            }
            location.reload();
        },

        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
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

                location.reload();
            } else {

            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });

}






