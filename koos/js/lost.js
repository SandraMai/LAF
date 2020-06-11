$(document).ready(function() {
    
    $('[name="add_new_lost_form"]').validate({
        rules: {
            email: {
                required: true,
            },
            lostDate : {
                required: true
            },
            category : {
                required: true
            },
            description : {
                required: true
            }

        },
        messages: {
            email:  "Palun sisestage meiliaddress",
            lostDate: "Palun valige kaotamise kuupäev",
            category: "Palun valige eseme kategooria",
            description: "Palun sisestage kirjeldus",
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