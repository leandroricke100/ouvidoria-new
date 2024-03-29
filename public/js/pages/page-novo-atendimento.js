let classicEditor = null;

$(document).ready(function () {

    ClassicEditor
        .create(document.querySelector('#atendimentoUsuarioText'))
        .then(editor => {
            classicEditor = editor;

        })
        .catch(error => {
            console.error(error);
        });


    $('[name="assunto"]').change(function () {
        let tipo = $('[name="assunto"]').val();

        if (tipo === "Outros") {

            // $("#assuntoDesejado").attr("required", "required");
            $("#assuntoDesejado").prop("required", true)
        } else {
            $("#assuntoDesejado").removeAttr("required", true);
        }
    });

    $('.outroAssuntoDesejado').hide();
    $('#assunto').change(function () {
        if ($(this).val() === 'Outros') {
            outroAssunto();
        } else {
            $('.outroAssuntoDesejado').hide();
        }
    });

    $('input[name="sigiloso"]').change(function () {
        $('#sigilo').val($(this).val());
    });


    $('#codAnterior').mask('0000.000.000');


    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('arquivo');
        const fileName = document.getElementById('file-name');

        input.addEventListener('change', function () {
            if (input.value.length > 0) {
                fileName.textContent = input.value.split('\\').pop(); // Extraindo apenas o nome do arquivo
            } else {
                fileName.textContent = 'Nenhum arquivo selecionado';
            }
        });
    });
});




function efetuarCadastro() {
    let dadosForm = new FormData($('#newAtendimentoUser')[0]);

    dadosForm.append('sigilo', $('input[name="sigiloso"]:checked').val());

    let resposta = classicEditor.getData();
    dadosForm.append('atendimentoUsuario', resposta);
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
                location.replace('/atendimentos');
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });

}


function outroAssunto() {
    $('.outroAssuntoDesejado').show();
    $('#assuntoDesejado').focus();
}

$(() => $('form').submit(function (e) {
    efetuarCadastro();
    e.preventDefault();
}));
