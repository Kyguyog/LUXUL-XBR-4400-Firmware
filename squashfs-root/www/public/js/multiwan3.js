$(document).ready(function(){
    if ($("#multiWanWizardStatus"). val() == 0) {
        $("#mulitiwanEnabledDiv").hide();
        $(".wizard-complete").hide();
    } else {
        $("#mulitiwanEnabledDiv").hide();
        $(".wizard-complete").show();
    }

    displayHelpMessages();

    selectConnectionType();
    $("#connectionTypeOptions").on("keyup change",function(){
        selectConnectionType();
    });

    $("#staticIp").on("keyup change",function(){
        process_static_ip($(this).attr("id"), "btnNext", "btnAddWan");
        process_static_ip($(this).attr("id"), "btnSave");

    });

    $("#pppoeMaxFailedPing, #pppoePingInterval").on("keyup change",function(){
        process_ping($(this).attr("id"), "btnNext", "btnAddWan");
        process_ping($(this).attr("id"), "btnSave");
    });

    $("#netmask").on("keyup change",function(){
        process_subnet($(this).attr("id"), "btnNext", "btnAddWan");
        process_subnet($(this).attr("id"), "btnSave");
    });

    $("#primaryDNS").focus(function(){
        if ($(this).val() == "DNS Assigned By ISP") {
            $(this).val("");
        }
    });

    $("#primaryDNS").on("keyup change",function(){
        checkPrimaryDns();
    });

    validateWanName();
    validateSecondaryDns();
    validateCustomMacAddr();
    validateCustomMtu();
    validateGateway();

    changeTrackingIp();
    validateTrackingIP(1);
    validateTrackingIP(2);
    validateTrackingIP(3);
    validateTrackingIP(4);
    validateTrackingIP(5);

    $("#trackingReliability").on("keyup change", function () {
        changeTrackingIp();
        validateTrackingIP(1);
        validateTrackingIP(2);
        validateTrackingIP(3);
        validateTrackingIP(4);
        validateTrackingIP(5);
    });

    save();
    cancel();

    function selectConnectionType() {
        if ($("#connectionTypeOptions").val() == 'dhcp') {
            $("#connectionTypePPPOEDiv").hide();
            $("#connectionTypeStaticDiv").hide();

            enable_button("btnNext");
            enable_button("btnAddWan");

        } else if ($("#connectionTypeOptions").val() == 'pppoe') {
            $("#connectionTypePPPOEDiv").show();
            $("#connectionTypeStaticDiv").hide();

            process_user("pppoeUser","btnNext", "btnAddWan");
            process_user("pppoeUser","btnSave");
            $("#pppoeUser").on("keyup change",function(){
                process_user("pppoeUser","btnNext", "btnAddWan");
                process_user("pppoeUser","btnSave");
            });

            $("#pppoeServiceName").on("keyup change",function(){
                if($("#pppoeServiceName").val() != ""){
                    validatePppoeServiceName("pppoeServiceName", "btnNext", "btnAddWan");
                    validatePppoeServiceName("pppoeServiceName", "btnSave");
                }
                else{
                    remove_redflag("pppoeServiceName");
                    enable_button("btnNext");
                    enable_button("btnAddWan");
                    enable_button("btnSave");
                }
            });

        } else {
            $("#connectionTypeStaticDiv").show();
            $("#connectionTypePPPOEDiv").hide();
            process_static_ip("staticIp", "btnNext", "btnAddWan");
            process_subnet("netmask", "btnNext", "btnAddWan");
        }
    }

    function checkPrimaryDns(){
        if($("#primaryDNS").val() != "") {
            process_dns($("#primaryDNS").attr("id"), "btnNext", "btnAddWan");
            process_dns($("#primaryDNS").attr("id"), "btnSave");
        } else{
            remove_redflag("primaryDNS");
            enable_button("btnNext");
            enable_button("btnAddWan");
            enable_button("btnSave");
        }
    }

    function validateWanName() {
        $("#wanName").on("keyup change",function(){
            if($("#wanName").val() != '') {
                process_wan_name("wanName", "btnNext", "btnAddWan");
                process_wan_name("wanName", "btnSave");
            }
            else {
                remove_redflag("secondaryDns");
                enable_button("btnAddWan");
                enable_button("btnNext");
                enable_button("btnSave");
            }
        });
    }

    function validateSecondaryDns() {
        $("#secondaryDns").on("keyup change",function(){
            if($("#secondaryDns").val() != '') {
                process_dns("primaryDNS","btnNext", "btnAddWan");
                process_dns("primaryDNS","btnSave");

                if(process_dns($(this).attr("id"), "btnNext","btnAddWan") || process_dns($(this).attr("id"), "btnSave")){
                    process_dns("primaryDNS","btnNext", "btnAddWan");
                    process_dns("primaryDNS","btnSave");
                }
            }  else{
                remove_redflag("secondaryDns");
                enable_button("btnNext");
                enable_button("btnAddWan");
                enable_button("btnSave");
                checkPrimaryDns();
            }
        });
    }

    function validateCustomMacAddr() {
        $("#customMacAddr").on("keyup change",function(){
            if($("#customMacAddr").val() != ""){
                process_mac($(this).attr("id"), "btnNext", "btnAddWan");
                process_mac($(this).attr("id"), "btnSave");
            }
            else{
                remove_redflag("customMacAddr");
                enable_button("btnNext");
                enable_button("btnAddWan");
                enable_button("btnSave");
            }
        });
    }

    function validateCustomMtu() {
        $("#customMtu").on("keyup change", function(){
            if($("#customMtu").val() != ""){
                process_mtu($(this).attr("id"), "btnNext", "btnAddWan");
                process_mtu($(this).attr("id"), "btnSave");
            }
            else{
                remove_redflag("customMtu");
                enable_button("btnNext");
                enable_button("btnAddWan");
                enable_button("btnSave");
            }
        });
    }

    function validateGateway() {
        $("#gateway").on("keyup change",function(){
            if($("#gateway").val() != "") {
                process_subnet($(this).attr("id"), "btnNext", "btnAddWan");
                process_subnet($(this).attr("id"), "btnSave");
            }
            else{
                remove_redflag("gateway");
                enable_button("btnNext");
                enable_button("btnAddWan");
                enable_button("btnSave");
            }
        });
    }

    function process_user(id,buttonId1, buttonId2){
        if(!valid_user($("#" + id).val())){
            apply_redflag(id);
            disable_button(buttonId1);
            disable_button(buttonId2);

        } else {
            remove_redflag(id);
            enable_button(buttonId1);
            enable_button(buttonId2);
        }
    }

    function validatePppoeServiceName(id,buttonId1, buttonId2) {
        if(!valid_pppoe_service_name($("#" + id).val())){
            apply_redflag(id);
            disable_button(buttonId1);
            disable_button(buttonId2);

        } else {
            remove_redflag(id);
            enable_button(buttonId1);
            enable_button(buttonId2);
        }
    }

    function process_wan_name(id,buttonId1, buttonId2){
        if(valid_wan_name_address($("#" + id).val())){
            remove_redflag(id);
            enable_button(buttonId1);
            enable_button(buttonId2);
        } else {
            apply_redflag(id);
            disable_button(buttonId1);
            disable_button(buttonId2);
        }
    }

    function process_ping(id,buttonId1, buttonId2){
        if(!valid_ping($("#" + id).val())){
            apply_redflag(id);
            disable_button(buttonId1);
            disable_button(buttonId2);

        } else {
            remove_redflag(id);
            enable_button(buttonId1);
            enable_button(buttonId2);

        }
    }

    function process_subnet(id, buttonId1, buttonId2) {
        if(!valid_ip_255($("#" + id).val())){
            apply_redflag(id);
            disable_button(buttonId1);
            disable_button(buttonId2);

        } else {
            remove_redflag(id);
            enable_button(buttonId1);
            enable_button(buttonId2);
        }
    }

    function process_mac(id, buttonId1, buttonId2){
        if(!valid_mac_address($("#" + id).val())){
            apply_redflag(id);
            disable_button(buttonId1);
            disable_button(buttonId2);
        } else {
            remove_redflag(id);
            enable_button(buttonId1);
            enable_button(buttonId2);
        }
    }

    function process_mtu(id,buttonId1, buttonId2){
        if(!valid_mtu($("#" + id).val())){
            apply_redflag(id);
            disable_button(buttonId1);
            disable_button(buttonId2);
        } else {
            remove_redflag(id);
            enable_button(buttonId1);
            enable_button(buttonId2);
        }
    }

    function validateTrackingIP(id) {
        $("#trackingIP_"+id).focus(function(){
            trackingIpHelpMessage();
        });

        $("#trackingIP_"+id).on("keyup change", function () {
            process_dns($(this).attr("id"), "btnNext", "btnAddWan");
            process_dns($(this).attr("id"), "btnSave");
        });
    }

    function changeTrackingIp() {
        var option = $("#trackingReliability").val();
        if (option == "0") {
            $("#tracingIPDiv").hide();
        } else {
            $("#trackingIPInput").empty();
            var trackingIPArray = $("#trackingIP").val().split(" ");

            for (var i = 1; i <= option; i++) {
                $("#tracingIPDiv").show();

                var trackingIPVal = trackingIPArray[i-1];

                if(typeof(trackingIPVal)  === "undefined") {
                    trackingIPVal = '';
                }

                $("#trackingIPInput").append("<input id='trackingIP_" + i + "' name='trackingIP_" + i + "' type='text' value='"+trackingIPVal+"' ><br /><br />");
            }
        }
    }

    function save() {
        $("#btnNext, #btnAddWan, #btnSave").click(function(){
            var dhcpConnectionType = $("#connectionTypeOptions").val();

            var wanNameClass =  $("#wanName").hasClass("yes_redflag");
            var pppoeUserClass = $("#pppoeUser").hasClass("yes_redflag");
            var pppoePwdClass = $("#pppoePwd").hasClass("yes_redflag");
            var pppoeServiceNameClass = $("#pppoeServiceName").hasClass("yes_redflag");
            var pppoeMaxFailedPingClass = $("#pppoeMaxFailedPing").hasClass("yes_redflag");
            var pppoePingIntervalClass = $("#pppoePingInterval").hasClass("yes_redflag");

            var staticIpClass = $("#staticIp").hasClass("yes_redflag");
            var netmaskClass = $("#netmask").hasClass("yes_redflag");
            var gatewayClass = $("#gateway").hasClass("yes_redflag");

            var primaryDNSClass = $("#primaryDNS").hasClass("yes_redflag");
            var secondaryDnsClass = $("#secondaryDns").hasClass("yes_redflag");
            var primaryDNSVal = $("#primaryDNS").val();
            var secondaryDNSVal = $("#secondaryDns").val();

            var customMacAddrClass = $("#customMacAddr").hasClass("yes_redflag");
            var customMtuClass = $("#customMtu").hasClass("yes_redflag");

            if ((dhcpConnectionType == 'pppoe' && (pppoeUserClass || pppoePwdClass || pppoeServiceNameClass || pppoeMaxFailedPingClass || pppoePingIntervalClass)) ||
                (dhcpConnectionType == 'static' && (staticIpClass || netmaskClass || gatewayClass)) ||
                primaryDNSClass || secondaryDnsClass|| customMacAddrClass || customMtuClass || wanNameClass ||
                (primaryDNSVal == "" && secondaryDNSVal != "") || checkTrackingIPClass($("#trackingReliability").val())) {

                if (primaryDNSVal == "" && secondaryDNSVal != "") {
                    apply_redflag("primaryDNS");
                }
                disable_button($(this).attr('id'));
                return false;
            }
        });
    }

    function checkTrackingIPClass(trackingIPNum) {
        if (trackingIPNum != 0) {
            for (var i = 1; i <= trackingIPNum; i++) {
                var trackingIPClass =  $("#trackingIP_"+trackingIPNum).hasClass("yes_redflag");

                if (trackingIPClass) {
                    return true;
                }
            }
        }
        return false;
    }

    function displayHelpMessages() {
        $("#wanName").focus(function(){
            wanNameHelpMessage();
        });

        $("#wan_name_help").click(function(){
            wanNameHelpMessage();
        });

        $("#connectionTypeOptions").focus(function(){
            connectionHelpMessage();
        });

        $("#connection_type_options_help").click(function(){
            connectionHelpMessage();
        });

        $("#primaryDNS").focus(function(){
            priDNSHelpMessage();
        });

        $("#pri_dns_help").click(function(){
            priDNSHelpMessage();
        });

        $("#secondaryDns").focus(function(){
            secondaryDNSHelpMessage();
        });

        $("#secondary_dns_help").click(function(){
            secondaryDNSHelpMessage();
        });

        $("#customMacAddr").focus(function(){
            customMacHelpMessage();
        });

        $("#custom_mac_addr_help").click(function(){
            customMacHelpMessage();
        });

        $("#customMtu").focus(function(){
            customMtuHelpMessage();
        });

        $("#custom_mtu_help").click(function(){
            customMtuHelpMessage();
        });

        $("#pppoe_user_help,#pppoeUser").click(function(){
            userHelpMessage();
        });

        $("#pppoe_pwd_help,#pppoePwd").click(function(){
            passwordHelpMessage();
        });

        $("#pppoe_service_name_help").click(function(){
            serviceNameHelpMessage();
        });

        $("#pppoe_max_failed_ping_help,#pppoeMaxFailedPing").click(function(){
            failedPingsHelpMessage();
        });

        $("#pppoe_ping_interval_help,#pppoePingInterval").click(function(){
            pingIntervalHelpMessage();
        });

        $("#static_id_help,#staticIp").click(function(){
            staticIpHelpMessage();
        });

        $("#netmask_help,#netmask").click(function(){
            netmaskHelpMessage();
        });

        $("#gateway_help,#gateway").click(function(){
            gwHelpMessage();
        });

        $("#pppoeUser").focus(function(){
            userHelpMessage();
        });

        $("#pppoePwd").focus(function(){
            passwordHelpMessage();
        });

        $("#pppoeServiceName").focus(function(){
            serviceNameHelpMessage();
        });

        $("#pppoeMaxFailedPing").focus(function(){
            failedPingsHelpMessage();
        });

        $("#pppoePingInterval").focus(function(){
            pingIntervalHelpMessage();
        });

        $("#staticIp").focus(function(){
            staticIpHelpMessage();
        });

        $("#netmask").focus(function(){
            netmaskHelpMessage();
        });

        $("#gateway").focus(function(){
            gwHelpMessage();
        });

        $("#trackingReliability").focus(function(){
            trackingReliabilityHelpMessage();
        });

        $("#tracking_reliability_help").click(function(){
            trackingReliabilityHelpMessage();
        });

        $("#tracking_ip_input_help").click(function(){
            trackingIpHelpMessage();
        });

        $("#pingCount").focus(function(){
            pingCountHelpMessage();
        });

        $("#ping_count_help").click(function(){
            pingCountHelpMessage();
        });

        $("#pingTimeout").focus(function(){
            pingTimeoutHelpMessage();
        });

        $("#ping_time_out_help").click(function(){
            pingTimeoutHelpMessage();
        });

        $("#pingInterval").focus(function(){
            pingIntervalHelpMessage();
        });

        $("#ping_interval_help").click(function(){
            pingIntervalHelpMessage();
        });

        $("#interfaceDown").focus(function(){
            interfaceDownHelpMessage();
        });

        $("#interface_down_help").click(function(){
            interfaceDownHelpMessage();
        });

        $("#interfaceUp").focus(function(){
            interfaceUpHelpMessage();
        });

        $("#interface_up_help").click(function(){
            interfaceUpHelpMessage();
        });

        $("#ipv6StatusOptions").focus(function(){
            ipv6HelpMessage();
        });

        $("#ipv6_status_options_help").click(function(){
            ipv6HelpMessage();
        });

    }

});








