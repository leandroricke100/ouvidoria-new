$(document).ready(function () {



    $(document).ready(function () {
        $('#semSigi').mouseover(function () {
            $('#modal-sigilo').css('display', 'block');
            $('#text-identificacao').css('margin-bottom', '0px');
        });

        $('#semSigi').mouseout(function () {
            $('#modal-sigilo').css('display', 'none');
            $('#text-identificacao').css('margin-bottom', '59px');
        });

        $('#sigi').mouseover(function () {
            $('#modal-semsigilo').css('display', 'block');
            $('#text-identificacao').css('margin-bottom', '0px');
        });

        $('#sigi').mouseout(function () {
            $('#modal-semsigilo').css('display', 'none');
            $('#text-identificacao').css('margin-bottom', '59px');
        });
    });


});
