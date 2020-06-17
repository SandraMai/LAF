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
        offset+=3;
        console.log(offset);
        ajaxLoadMore(offset, type, atype, storage);
    });


    function ajaxLoadMore(offset, type, atype, storage) {
        var name = $('[name="otsingSona"]').data('value');
        var cat = $('[name="category"]').data('value');
        var area = $('[name="area"]').data('value');
        
        var url = '../ajax/infinite_scroll.php';
            $.ajax({
                type: 'POST',
                url: url,
                data: { 'inf': offset, 'type': type, 'name': name, 'cat': cat, 'area': area, 'atype': atype, 'storage': storage }
            }).done(function(data) {
                console.log(data);
                if (data == 100) {
                    $('.js-more-wrapper').empty().append('<h1 >Rohkem esemeid ei ole!</h1>');
                } else {
                    createProductHTML(JSON.parse(data));
                    hermaniTimer();
                }

            });

    }

    function createProductHTML(data) {
        $( data ).appendTo( $( ".products" ) );
    }



    function hermaniTimer() {
        $('.productexplinationsDATE').each(function(){
            var compareDate = new Date();
            console.log($(this).text());

            let that = $(this);
            // kui teed html selliseks
            // <li data-time="1589922000" class="productexplinationsDATE">Oksjoni aegumiskuupäev: 1589922000</li>
            // saad niimoodi ainult value, ja mitte innerhtml
            let value = $(this).data('time');
            value=value*1000+86400*14*1000

            console.log("VALUE "+value)
            var timer;
            
                timer = setInterval(function() {
                    timeBetweenDates(that);
                }, 1000);

                function timeBetweenDates(that) {
                    var now = new Date();
                    var difference = value - now.getTime();

                    if (difference <= 0) {

                        // Timer done
                        clearInterval(timer);
                    
                    } else {
                        
                        var seconds = Math.floor(difference / 1000);
                        var minutes = Math.floor(seconds / 60);
                        var hours = Math.floor(minutes / 60);
                        var days = Math.floor(hours / 24);

                        hours %= 24;
                        minutes %= 60;
                        seconds %= 60;

                        $(that).find('.days').text(days);
                        $(that).find('.hours').text(hours);
                        $(that).find('.minutes').text(minutes);
                        $(that).find('.seconds').text(seconds);
                    }
                }
        });
    }

});