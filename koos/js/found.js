$(document).ready(function() {
    
    $('[name="add_new_found_form"]').validate({
        rules: {
            storage: {
                required: true
            },
            date : {
                required: true
            },
            image: {
                required: true
            },
            category : {
                required: true
            },
            description : {
                required: true,
                alphanumeric: true
            },
            found_location : {
                required: true,
                alphanumeric: true
            }

        },
        messages: {
            storage:  "Palun valige hoiupaik",
            date: "Palun valige leidmise kuupäev",
            image: "Palun valige eseme pilt",
            category: "Palun valige eseme kategooria",
            description: {
                required: "Palun sisestage kirjeldus",
                alphanumeric: "Lubatud on ainult numbrid ja tähed."
            },
            found_location: {
                required: "Palun sisestage leidmise koht",
                alphanumeric: "Lubatud on ainult numbrid ja tähed."
            }
            
            

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