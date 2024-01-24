$(function () {

    const semSigilo = document.querySelectorAll('.semSigi');
    const modalSemSigilo = document.querySelector('.modal-semSigi');

    const sigilo = document.querySelectorAll('.sigi');
    const modalSigilo = document.querySelector('.modal-Sigi');


    semSigilo.forEach(item => {
        item.addEventListener('mouseover', () => {
            modalSemSigilo.style.display = 'block';
        });

        item.addEventListener('mouseout', () => {
            modalSemSigilo.style.display = 'none';
        })
    })

    sigilo.forEach(item => {
        item.addEventListener('mouseover', () => {
            modalSigilo.style.display = 'block';
        });

        item.addEventListener('mouseout', () => {
            modalSigilo.style.display = 'none';
        })
    })


})
