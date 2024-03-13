$(document).ready(function () {
    modalAberto();


});

function modalAberto() {
    $('#btnAberto').addClass('ativo');
    $('#btnArquivado').removeClass('ativo');
    $('.emArquivado').hide();
    $('.emAberto').show();
    $('.bloco-arquivado').hide();
    $('.bloco-aberto').show();
}

function modalArquivado() {
    $('#btnArquivado').addClass('ativo');
    $('#btnAberto').removeClass('ativo');
    $('.emAberto').hide();
    $('.emArquivado').show();
    $('.bloco-arquivado').show();
    $('.bloco-aberto').hide();
}
