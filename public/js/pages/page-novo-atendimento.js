function efetuarCadastro() {
    let dadosForm = new FormData($('#new-atendimento-user')[0]);


    dadosForm.append('sigilo', $('input[name="sigiloso"]:checked').val());

    console.log(dadosForm);

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
                popNotif({ msg: resposta.msg, time: 2000 });
                location.replace("/atendimentos");
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
            location.replace("/atendimentos");
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

$(document).ready(function() {
    $('.outroAssuntoDesejado').hide();
    $('#assunto').change(function() {
        if ($(this).val() === 'Outros') {
            outroAssunto();
        }else{
            $('.outroAssuntoDesejado').hide();
        }
    });

    $('input[name="sigiloso"]').change(function(){
        $('#sigilo').val($(this).val());
    })

});

function outroAssunto() {
    $('.outroAssuntoDesejado').show();
    $('#assuntoDesejado').focus();
}


$(() => $('form').submit(function (e) {
    efetuarCadastro();
    e.preventDefault();
}));
