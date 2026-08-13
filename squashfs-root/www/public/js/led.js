$(document).ready(function(){
    $("ul.nav-links").find("a[href='"+window.location.pathname+"']").each(function() {
        $(this).addClass("current-page");
        $(this).parents('li').find('a').removeClass("closed").addClass("open");

        $(this).parents('li').find('a').click(function() {
            $(this).toggleClass('open');
            $(this).toggleClass('closed');
        });
    });

    $('.cat-link.closed').click(function() {
        $(this).toggleClass('open');
        $(this).toggleClass('closed');
    });

    $("#ledControl").change(function(){
        var ledStatus = $(this).val();
        window.location = "/led/save/"+ledStatus;

    });



});