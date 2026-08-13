$(document).ready(function(){
    var rebootRequired = $("#rebootRequired").val();
    if (rebootRequired == "1") {
        $(".aside-left").hide();
    } else {
        $(".aside-left").show();
        displayLeftNav();
    }

    displaySpin('defautingIndicator', 100, 'http://192.168.0.1/quicksetup/display');
});