function displayLeftNav(){
    var url = (window.location.pathname).split("/");

    if (url[2] == 'progress') {
        url[2] = 'display';
    }

    if (url[1] == 'vlanconfig') {
        url[1] = 'vlan';
    }
    var path = "/"+ url[1]+"/"+url[2];

    $("ul.nav-links").find("a[href='"+path+"']").each(function() {
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
}