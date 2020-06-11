$(function(){
    $('.header-list a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')
    $('.header-list a').click(function(){
        $(this).parent().addClass('active').siblings().removeClass('active')	
    })
})