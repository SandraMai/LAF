$(document).ready(function() {

    $(document).on('click', '.js-open-header', function() {
       $('.side-nav').show("slide", { direction: "left" }, 500);
    });


    $(document).on('click', '.js-hide-header', function() {
       $('.side-nav').hide("slide", { direction: "left" }, 500);
    });


});