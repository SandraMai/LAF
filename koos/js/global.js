$(document).ready(function() {

    $(document).on('click', '.js-open-header', function() {
       $('.side-nav').show("slide", { direction: "left" }, 500);
    });


    $(document).on('click', '.js-hide-header', function() {
       $('.side-nav').hide("slide", { direction: "left" }, 500);
    });


});

function checkDomain() {
    var userEmail = $('[name="email"]').val();
    console.log(userEmail.substring(userEmail.indexOf('@')));
    return (userEmail.substring(userEmail.indexOf('@')) === "@tlu.ee");
}