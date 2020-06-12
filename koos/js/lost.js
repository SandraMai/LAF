$(document).ready(function() {

    // Only letters, numbers, or dashes allowed
    $.validator.addMethod("aznumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-ZäöüõÄÖÜÕ0-9,.!? -]*$/i.test(value);
    });

    $('[name="add_new_lost_form"]').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            lostDate : {
                required: true
            },
            category : {
                required: true
            },
            description : {
                required: true,
                aznumeric: true
            },
            placeLost : {
                aznumeric: true
            }


        },
        messages: {
            email:  {
                required: "Palun sisestage meiliaddress.",
                email: "Palun sisestage korrektne meiliaddress."
            },
            lostDate: {
                required: "Palun valige kaotamise kuupäev.",
                max: "Valitud kuupäev ei tohi olla tulevikus."
            },
            category: "Palun valige eseme kategooria.",
            description: {
                required: "Palun sisestage kirjeldus.",
                aznumeric: "Lubatud on ainult numbrid, tähed ja kirjavahemärgid."
            },
            placeLost: "Lubatud on ainult numbrid, tähed ja kirjavahemärgid."
            
        },
        errorPlacement: function(error, element) {
            // If input name is "storage", then error is appended to a class called "error-storage"
            // This system applies to all input elements stated in rules above
            error.appendTo( $('.error-' + element.attr("name")));
        }
    });


	$('textarea').autoheight();


    // Filename for custom input
    $(document).on('change', '.js-file-input', function() {
        var fileName = $(this)[0].files[0].name;
        $('.js-file-input-name').text(fileName);
    });

});