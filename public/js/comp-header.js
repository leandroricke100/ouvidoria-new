function openSearchBtn() {

    if ($(".search-options").is(":visible")) {

        $(".search-options").hide();
    } else {

        $(".search-options").show();
    }
}

// function openMenuMobile() {
//     alert('teste')
// }

function openModalLogin() {
    $('.modal-login').show();
}

function closeModal() {
    $('.modal-login').hide();
}
