/*
$(document).ready(function() {

    // Only letters, numbers, or dashes allowed
    $.validator.addMethod("aznumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-ZäöüõÄÖÜÕ0-9,.!? -]*$/i.test(value);
    });


    $.validator.addMethod("actualStep", function(value, element) {
        console.log(( $('[name="offer"]').val() - $('[name="offer"]').attr('min') ) / 3 == 0);
        if ( ( $('[name="offer"]').val() - $('[name="offer"]').attr('min') ) / 3 == 0 ){
            return true;
        } 
        return false;
        
    });

    

    $('[name="add_new_offer"]').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            offer : {
                required: true,
                actualStep: true
            }
        },
        messages: {
            email:  {
                required: "Palun sisestage meiliaddress.",
                email: "Palun sisestage korrektne meiliaddress."
            },
            offer: {
                required: "Palun valige hind.",
                min: "Pakkumine ei saa olla alghinnast madalam.",
                max: "Pakkumine on liiga suur.",
                actualStep: "Palun sisesta arv, mis on " + $('[name="offer"]').attr('data-step') + " sammuga alghinnast."
            }
            
        },
        errorPlacement: function(error, element) {
            // If input name is "storage", then error is appended to a class called "error-storage"
            // This system applies to all input elements stated in rules above
            error.appendTo( $('.error-' + element.attr("name")));

        },
        
    });

    

});

*/