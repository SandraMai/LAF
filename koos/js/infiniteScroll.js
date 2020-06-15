$(document).ready(function() {

    // Load more
    $(document).on('click', '.js-load-more', function() {
        let offset = $(this).data('inf');
        let type = $(this).data('type');;
        offset+=3;
        $(this).data('inf', offset);

        console.log(offset);
        ajaxLoadMore(offset, type);
    });


    function ajaxLoadMore(offset, type) {
        let url = '../ajax/infinite_scroll.php';
            $.ajax({
                type: 'POST',
                url: url,
                data: { 'inf': offset, 'type': type }
            }).done(function(data) {
                console.log(data);
                if (data == 100) {
                    $('.js-more-wrapper').empty().append('<h1 >Rohkem esemeid ei ole!</h1>');
                } else {
                    createProductHTML(JSON.parse(data));
                }

            });

    }

    function createProductHTML(data) {
        $( data ).appendTo( $( ".products" ) );
    }


});