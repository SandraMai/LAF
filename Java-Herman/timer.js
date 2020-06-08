$(document).ready(function() {


    // let dateOfExp=document.getElementsByClassName('productexplinationsDATE');
    // console.log(dateOfExp.value);
    // console.log(dateOfExp);


    $('.productexplinationsDATE').each(function(){
        var compareDate = new Date();
        console.log($(this).text());

        let that = $(this);
        // kui teed html selliseks
        // <li data-time="1589922000" class="productexplinationsDATE">Oksjoni aegumiskuupäev: 1589922000</li>
        // saad niimoodi ainult value, ja mitte innerhtml
        let value = $(this).data('time');
        value=value*1000+86400*6*1000

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

});


