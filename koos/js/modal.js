$(document).ready(function() {
    
    $(document).on('click', '.js-close-modal', function() {
        $('.js-modal').hide();
    });

    var caseNumber = parseInt($('.modalCase').data('case'));
    if (caseNumber > 0) {
        detectModalText(caseNumber);
        $('.js-modal').css('display', 'flex');
    }

});

function detectModalText(caseNumber) {
    var modalText = null;
    switch(caseNumber) {
        case 1:
            modalText = 'Kuulutus lisatud';
            break;
        case 2:
            modalText = 'Kuulutus on kustutatud';
            break;
        case 3:
            modalText = 'Pakkumine lisatud';
            break;
        case 4:
            modalText = 'KKK küsimus on sisestatud';
            break;
        case 5:
            modalText = 'KKK küsimus on kustutatud';
            break;
        case 6:
            modalText = 'Parool on muudetud';
            break;
        case 7:
            modalText = 'Muudatused on salvestatud';
            break;
        case 8:
            modalText = 'Hoiupaik on muudetud';
            break;
        case 9:
            modalText = 'Uus hoiupaik on lisatud';
            break;
        case 10:
            modalText = 'Tekkis probleem. Vabandame!';
            break;
        default:
            modalText = false;
            break;
    }

    if (!modalText) {
        modalText = 'Midagi läks valesti.';
    }

    changeModalText(modalText);
}


function changeModalText(modalText) {
    $('.js-modal-text').text(modalText);
}