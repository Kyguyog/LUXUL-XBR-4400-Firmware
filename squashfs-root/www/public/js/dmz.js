$(document).ready(function(){
    displayLeftNav();

    $("#dmz_status_help").click(function(){
        dmzStatusHelpMessage();
    });

    $("#dmzStatus").focus(function(){
        dmzStatusHelpMessage();
    })

    selectDMZStatus();
    $("#dmzStatus").on("keyup change",function(){
        selectDMZStatus();
    });

    $("#dmzIpAddr").on("keyup change",function(){
        process_ip($(this).attr("id"), "btnSave");
    });

    cancel();

    function selectDMZStatus() {
        if ($("#dmzStatus").val() == 'dmz_enabled') {
            $("#dmzEnabledDiv").show();

            $("#dmz_ip_addr_help").click(function(){
                dmzIPAddrHelpMessage();
            });

            $("#dmzIpAddr").focus(function(){
                dmzIPAddrHelpMessage();
            })

            process_ip($("#dmzIpAddr").attr("id"), "btnSave");
        } else {
            $("#dmzEnabledDiv").hide();
            enable_button("btnSave");
        }
    }

});