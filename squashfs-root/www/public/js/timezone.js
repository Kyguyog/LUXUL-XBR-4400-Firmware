$(document).ready(function(){
    displayLeftNav();

    selectTimeZone();
    $("#timeZoneOptions").on("keyup change",function(){
        selectTimeZone();
    });

    function selectTimeZone() {
        if ($("#timeZoneOptions").val() != '') {
            enable_button("btnApply");
        } else {
            disable_button("btnApply");
        }
    }

});