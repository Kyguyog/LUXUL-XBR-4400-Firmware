$(document).ready(function () {
    displayLeftNav();

    $('#upgrade').attr('disabled', true);
    $('#apFirmware').bind('change', function () {
        $("#upgrade_status").slideUp("slow");
        var filename = $('#apFirmware').val();
        if (filename && filename.split('.').pop() == "lxl") {
            $('#upgrade').removeAttr('disabled');
            $('#invalid_file').slideUp();
        } else {
            $('#upgrade').attr('disabled', true);
            $('#invalid_file').slideDown();
        }
    });

    $('#upgradeForm').bind('submit', function () {
        $('#apFirmware').readonly = true;
        $('#upgrade').disabled = true;
        $('#upgrading').slideDown();
    });

    var is_mac = navigator.userAgent.toLowerCase().indexOf('mac') > -1;
    var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
    var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;

    if (is_mac) {
        if(is_firefox) {
            document.getElementById("fileLabel").setAttribute("id", "fileLabel1");
        } else if (is_chrome) {
            document.getElementById("fileLabel").setAttribute("id", "fileLabel2");
        }

    } else {
        if (is_chrome) {
            document.getElementById("fileLabel").setAttribute("id", "fileLabel3");
            $("#restore").css("margin-top", "4px");
        } else if (is_firefox) {
            document.getElementById("fileLabel").setAttribute("id", "fileLabel4");
            $("#restore").css("margin-top", "6px");
        }
    }
});