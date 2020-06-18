$(document).ready(function() {

    var offset = 0;;

    // Load more
    $(document).on('click', '.js-load-more', function() {
        var atype = $(this).data('atype');
        if(atype != 1) {
            atype = 0;
        }

        var storage = $('[name="storagePlace"]').data('value');
        if(!storage) {
            storage = 0;
        }
        var type = $(this).data('type');
        offset+=5;
        console.log(offset);
        ajaxLoadMore(offset, type, atype, storage);
    });

});


function ajaxLoadMore(offset, type, atype, storage) {
    var name = $('[name="otsingSona"]').data('value');
    var cat = $('[name="category"]').data('value');
    var area = $('[name="area"]').data('value');
    var datestart= $('[name="Date-Start"]').data('value');
    var dateend = $('[name="Date-End"]').data('value');
    
    var url = '../ajax/infinite_scroll.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: { 'inf': offset, 'type': type, 'name': name, 'cat': cat, 'area': area, 'atype': atype, 'storage': storage,
                    'datestart': datestart, 'dateend': dateend}
        }).done(function(data) {
            console.log(data);
            if (data == 100) {
                $('.js-more-wrapper').empty().append('<h1 >Rohkem esemeid ei ole!</h1>');
            } else {
                createProductHTML(JSON.parse(data));
                liveTimeUpdate();
            }

        });

}

function createProductHTML(data) {
    $( data ).appendTo( $( ".products" ) );
}
