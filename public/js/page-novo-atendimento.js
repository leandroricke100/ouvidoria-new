function efetuarCadastro() {
    let dadosForm = new FormData($('#new-atendimento-user')[0]);


    console.log(dadosForm)

    $.ajax({
        url: '/api/OuvidoriaNovoAtendimento',
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
                // Handle success, e.g., redirect to another page
            } else {
                // Handle failure
            }
        },
        error: function (XMLHttpRequest, xhr, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
            console.log(xhr.status);
            console.log(xhr.responseText);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}

$(() => $('form').submit(function (e) {
    efetuarCadastro();
    e.preventDefault();
}));
