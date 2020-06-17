$(document).ready(function() {

    // Only letters, numbers, or dashes allowed
    $.validator.addMethod("aznumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-ZäöüõÄÖÜÕ0-9,.!? -]*$/i.test(value);
    });

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
                aznumeric: true
            },
            found_location : {
                required: true,
                aznumeric: true
            }

        },
        messages: {
            storage:  "Palun valige hoiupaik.",
            date: {
                required: "Palun valige leidmise kuupäev."
            },
            image: "Palun valige eseme pilt.",
            category: "Palun valige eseme kategooria.",
            description: {
                required: "Palun sisestage kirjeldus.",
                aznumeric: "Lubatud on ainult numbrid, tähed ja kirjavahemärgid."
            },
            found_location: {
                required: "Palun sisestage leidmise koht.",
                aznumeric: "Lubatud on ainult numbrid, tähed ja kirjavahemärgid."
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


    $('.datepicker').Zebra_DatePicker({
        days: ['P', 'E', 'T', 'K', 'N', 'F', 'S'],
        show_select_today: "Täna",
        months: ['Jaanuar', 'Veebruar', 'Märts', 'Aprill', 'Mai', 'Juuni', 'Juuli', 'August', 'September', 'Oktoober', 'November', 'Detsember'],
        direction: [false, 14]
        //,format: 'd.m.Y'
    });

});