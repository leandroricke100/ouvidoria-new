$(document).ready(function () {

    minhaContaUser(id);
    console.log(id);

    let conta = id;

    $.ajax({
        url: '/api/OuvidoriaEditAccountUser',
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



                //popNotif({ msg: resposta.msg, time: 2000 });
            } else {
                popNotif({ tipo: 'error', msg: resposta.msg, time: 2000 });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);

        }
    });
});

