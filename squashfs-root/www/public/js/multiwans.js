$(document).ready(function () {
    $("ul.nav-links").find("a[href='" + window.location.pathname + "']").each(function () {
        $(this).addClass("current-page");
        $(this).parents('li').find('a').removeClass("closed").addClass("open");
        $("#multiWanLink").css("background-color", " #659520");

        $(this).parents('li').find('a').click(function () {
            $(this).toggleClass('open');
            $(this).toggleClass('closed');
        });
    });

    $('.cat-link.closed').click(function () {
        $(this).toggleClass('open');
        $(this).toggleClass('closed');
    });

    if ($("#multiWanWizardStatus").val() == '0') {
        $("#multiWanLink").removeClass("open")
        $("#multiWanUL").html('');

    } else {
        $("#multiWanLink").css("background-color", "");
        $(".multiWanWizardInfo").remove();
    }

    $('.cta-button').click(function () {
       var wanNum = $(this).attr("id").substr(3).toLowerCase();;
        window.location = "/"+wanNum+"/display";
    });


});








