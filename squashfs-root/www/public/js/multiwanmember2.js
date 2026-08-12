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

    $('.checkboxWanMember').click(function () {
        var par = $($(this).parent()).parent();
        var input = par.find("td");

        if ($(this).is(':checked')) {
            par = $($(this).parent()).parent();
            input = par.find("td");
            var wanNum = $(this).attr('id').substr(5);

            input[1].innerHTML = "<input name='groupPriority"+wanNum+"' id='groupPriority"+wanNum+"' type='text' autocomplete='off' value=''>";
            input[2].innerHTML = "<input name='groupWeight"+wanNum+"' id='groupWeight"+wanNum+"' type='text' autocomplete='off' value=''>";
        } else {
            input[1].innerHTML = "";
            input[2].innerHTML = "";
        }

    });

    checkSelectMemberBox()
    $(".checkboxWanMember").change(function () {
        checkSelectMemberBox();
    });

    function checkSelectMemberBox() {
        if ($(".checkboxWanMember").filter(':checked').length == 0) {
            $("#btnNext").attr("disabled", 'disabled');
            $("#btnAddGroup").attr("disabled", 'disabled');

        } else {
            $("#btnNext").removeAttr("disabled");
            $("#btnAddGroup").removeAttr("disabled");

        }
    }


});








