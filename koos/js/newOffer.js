
$(document).ready(function() {


    var theStep = parseFloat($('[name="offer"]').attr('data-step'));
    var theMax = parseFloat($('[name="offer"]').attr('max'));
    var theMin = parseFloat($('[name="offer"]').attr('min'));

    // Only letters, numbers, or dashes allowed
    $.validator.addMethod("aznumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-ZäöüõÄÖÜÕ0-9,.!? -]*$/i.test(value);
    });

    $.validator.addMethod("actualStep", function(value, element) {

        if (checkCurrentPrice()) {
            return true;
        }
        return false;
    });

    
    // Email by domain
    $.validator.addMethod("tlumail", function(value, element) {
        return checkDomain();
  
    });

    $('[name="add_new_offer"]').validate({
        rules: {
            email: {
                required: true,
                email: true,
                tlumail: true
            },
            offer : {
                required: true,
                actualStep: true
            }
        },
        messages: {
            email:  {
                required: "Palun sisestage meiliaadress.",
                email: "Palun sisestage korrektne meiliaadress.",
                tlumail: "Palun sisestage meiliaadress lõpuga tlu.ee"
            },
            offer: {
                required: "Palun valige hind.",
                min: "Pakkumine ei saa olla väiksem kui " + theMin,
                max: "Pakkumine ei saa olla suurem kui " + theMax,
                actualStep: "Palun sisesta arv, mis on " + theStep + " sammuga alghinnast " + theMin
            }
            
        },
        errorPlacement: function(error, element) {
            // If input name is "storage", then error is appended to a class called "error-storage"
            // This system applies to all input elements stated in rules above
            error.appendTo( $('.error-' + element.attr("name")));

        },
        
    });




    $(document).on('click', '.js-up', function() {
        var currentVal = checkCurrentPrice();
        if(currentVal) {
            currentVal+=theStep;
            if (currentVal <= theMax) {
                $('[name="offer"]').val(currentVal);
            }
        } else {
            $('[name="offer"]').val(theMin);
        }
    });

    $(document).on('click', '.js-down', function() {
        var currentVal = checkCurrentPrice();
        if(currentVal) {
            currentVal-=theStep;
            if (currentVal >= theMin) {
                $('[name="offer"]').val(currentVal);
            }
        } else {
            $('[name="offer"]').val(theMin);
        }
    });

    function checkCurrentPrice() {
        var currentVal = parseFloat($('[name="offer"]').val());
        var valAdded = currentVal - theMin;

        if (currentVal && currentVal >= theMin && currentVal <= theMax && tenner(valAdded) ) {
            return currentVal;
        }

        return false;
    }
    

    function tenner(currentVal) {
        if ( Math.abs(currentVal) < 0.001) {
            return true;
        }
        

        if ( currentVal < 0) {
            return false;
        }

        return tenner(currentVal - theStep);
    }

});