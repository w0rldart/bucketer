$(document).ready(function() {

    $('section[id^="home"]').height($(window).height()).css({
        position: 'relative',
        //'border': '1px solid red'
    });

    $('section[id^="home"] > div').each(function(i,v){ 
        $(this).css({
            position:'absolute',
            top: Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px",
        });
    });
}); 