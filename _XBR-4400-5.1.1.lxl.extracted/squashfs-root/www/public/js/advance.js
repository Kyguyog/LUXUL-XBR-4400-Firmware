$(document).ready(function(){
    displayLeftNav();
    displayHelpMessages();

    selectPPTPPassthruStatus();
    $("#pptpPassthruOptions").on("keyup change",function(){
        selectPPTPPassthruStatus();
    });

    $("#serverAddr").on("keyup change",function(){
        process_ip($(this).attr("id"), "savePptpPassthru");
    });

    $("#wanDelay").on("keyup change",function(){
        validateWanDelay("wanDelay", "btnSaveWanDelay");
    });

    cancel();

    function selectPPTPPassthruStatus() {
        if ($("#pptpPassthruOptions").val() == '1') {
            $("#pptpPaththruEnabledDiv").show();
            process_ip($("#serverAddr").attr("id"), "savePptpPassthru");
        } else {
            $("#pptpPaththruEnabledDiv").hide();
            enable_button("savePptpPassthru");
        }
    }

    function displayHelpMessages() {
        $("#wanAccelerationOptions").focus(function(){
            wanAcceleratedHelpMessage();
        });

        $("#wanPingOptions").focus(function(){
            wanPingHelpMessage();
        });

        $("#pptpPassthruOptions").focus(function(){
            pptpPassthruHelpMessage();
        });

        $("#server_addr_help").click(function(){
            pptpServerAddrHelpMessage();
        });

        $("#serverAddr").focus(function(){
            pptpServerAddrHelpMessage();
        });

        $("#ipv6_status_options_help").click(function(){
            ipv6HelpMessage();
        });

        $("#ipv6StatusOptions").focus(function(){
            ipv6HelpMessage();
        });

        $("#wan_acceleration_options_help, #wanAccelerationOptions").click(function(){
            wanAcceleratedHelpMessage();
        });

        $("#wan_ping_options_help, #wanPingOptions").click(function(){
            wanPingHelpMessage();
        });

        $("#pptp_passthru_options_help, #pptpPassthruOptions").click(function(){
            pptpPassthruHelpMessage();
        });

        $("#portMonitoringOptions").focus(function(){
            portMonitoringHelpMessage();
        });

        $("#port_monitoring_options_help, #portMonitoringOptions").click(function(){
            portMonitoringHelpMessage();
        });

        $("#wanDelay").focus(function(){
            wanDelayHelpMessage();
        });

        $("#wan_delay_help, #wanDelay").click(function(){
            wanDelayHelpMessage();
        });

        $("#blockSelfAssignedIpOptions").focus(function(){
            blockSelfAssignedIpHelpMessage();
        });

        $("#block_self_assigned_ip_options_help, #blockSelfAssignedIpOptions").click(function(){
            blockSelfAssignedIpHelpMessage();
        });
    }

});