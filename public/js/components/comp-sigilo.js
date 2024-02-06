$(document).ready(function () {

    $('#itens').addClass('ativo');
});

function identificacao() {
    $('#itens').addClass('ativo');
    $('#itens2').removeClass('ativo');
}

function informacao() {
    $('#itens2').addClass('ativo');
    $('#itens').removeClass('ativo');
}

