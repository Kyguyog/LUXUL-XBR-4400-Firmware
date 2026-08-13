$(document).ready(function(){
    displayLeftNav();

    $("#sysLogSizeOptions").change(function(){
        var sysLogSize = $(this).val();
        window.location = "/log/saveLogSize/"+sysLogSize;
    });

});