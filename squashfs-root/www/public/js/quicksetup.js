$(document).ready(function(){
    detectBrowser();
    displayLeftNav();
    displayHelpMessages();

    selectConnectionType();
    $("#connectionTypeOptions").on("keyup change",function(){
        selectConnectionType();
    });

    $("#lanIPAddr").on("keyup change",function(){
        process_ip($(this).attr("id"), "btnSave");
    });

    $("#staticIp").on("keyup change",function(){
        process_static_ip($(this).attr("id"), "btnSave");
    });

    $("#pppoeMaxFailedPing, #pppoePingInterval").on("keyup change",function(){
        process_ping($(this).attr("id"), "btnSave");
    });

    $("#netmask, #lanSubnet").on("keyup change",function(){
        process_subnet($(this).attr("id"), "btnSave");
    });

    validateCustomMacAddr();
    validateCustomMtu();
    validateGateway();

    save();
    cancel();

    function displayHelpMessages() {
        $("#lanIPAddr").focus(function(){
            ipHelpMessage();
        });

        $("#lanSubnet").focus(function(){
            subnetHelpMessage();
        });

        $("#connectionTypeOptions").focus(function(){
            connectionHelpMessage();
        });

        $("#primaryDNS").focus(function(){
            priDNSHelpMessage();
        });

        $("#secondaryDns").focus(function(){
            secondaryDNSHelpMessage();
        });

        $("#customMacAddr").focus(function(){
            customMacHelpMessage();
        });

        $("#customMtu").focus(function(){
            customMtuHelpMessage();
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

        $("#lan_ip_addr_help, #lanIPAddr").click(function(){
            ipHelpMessage();
        });

        $("#lan_subnet_mask_help, #lanSubnet").click(function(){
            subnetHelpMessage();
        });

        $("#connection_type_options_help,#connectionTypeOptions").click(function(){
            connectionHelpMessage();
        });

        $("#pri_dns_help,#primaryDNS").click(function(){
            priDNSHelpMessage();
        });

        $("#secondary_dns_help,#secondaryDns").click(function(){
            secondaryDNSHelpMessage();
        });

        $("#custom_mac_addr_help,#customMacAddr").click(function(){
            customMacHelpMessage();
        });

        $("#custom_mtu_help,#customMtu").click(function(){
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
    }

    function selectConnectionType() {
        if ($("#connectionTypeOptions").val() == 'dhcp') {
            $("#connectionTypePPPOEDiv").hide();
            $("#connectionTypeStaticDiv").hide();

            enable_button("btnSave");
            if($("#primaryDNS" ).val() == '' || $("#primaryDNS" ).val() == 'DNS Assigned By ISP'){
                remove_redflag("primaryDNS");
                enable_button("btnSave");
            }

            $("#primaryDNS").click(function(){
                $("#primaryDNS").val("");

                $("#primaryDNS").on("keyup change",function(){
                    process_dns("primaryDNS","btnSave");

                    if($("#primaryDNS" ).val() == '' || $("#primaryDNS" ).val() == 'DNS Assigned By ISP'){
                        remove_redflag("primaryDNS");
                        enable_button("btnSave");
                    }
                });
            });

            validateSecondaryDns();

        } else if ($("#connectionTypeOptions").val() == 'pppoe') {
            $("#connectionTypePPPOEDiv").show();
            $("#connectionTypeStaticDiv").hide();

            if($("#primaryDNS" ).val() == '' || $("#primaryDNS" ).val() == 'DNS Assigned By ISP'){
                remove_redflag("primaryDNS");
                enable_button("btnSave");
            }

            process_user("pppoeUser","btnSave");
            $("#pppoeUser").on("keyup change",function(){
                process_user("pppoeUser","btnSave");
            });

            $("#pppoeServiceName").on("keyup change",function(){
                if($("#pppoeServiceName").val() != ""){
                    validatePppoeServiceName("pppoeServiceName", "btnSave");
                }
                else{
                    remove_redflag("pppoeServiceName");
                    enable_button("btnSave");
                }
            });

            $("#primaryDNS").click(function(){
                $("#primaryDNS").val("");

                $("#primaryDNS").on("keyup change",function(){
                    process_dns("primaryDNS","btnSave");

                    if($("#primaryDNS" ).val() == ''){
                        remove_redflag("primaryDNS");
                        enable_button("btnSave");
                    }
                });
            });

            validateSecondaryDns();

        } else {

            $("#connectionTypeStaticDiv").show();
            $("#connectionTypePPPOEDiv").hide();
            process_static_ip("staticIp", "btnSave");
            process_subnet("netmask", "btnSave");

            process_dns("primaryDNS","btnSave");
            $("#primaryDNS").click(function(){
                $("#primaryDNS").val("");

                $("#primaryDNS").on("keyup change",function(){
                    process_dns("primaryDNS","btnSave");
                });
            });

            $("#secondaryDns").on("keyup change",function(){
                if($("#secondaryDns").val() != '') {
                    process_dns($(this).attr("id"),"btnSave");

                    if(process_dns($(this).attr("id"), "btnSave")){
                        process_dns("primaryDNS","btnSave");

                        $("#primaryDNS").on("keyup change",function(){
                            process_dns("primaryDNS","btnSave");
                        });
                    }
                } else{
                    remove_redflag("secondaryDns");
                    enable_button("btnSave");
                }
            });

            process_dns("primaryDNS","btnSave");
        }
    }

    function checkPrimaryDns(){
        if($("#primaryDNS").val() != "") {
            process_dns($("#primaryDNS").attr("id"), "btnSave");
        }
        else{
            remove_redflag("primaryDNS");
            enable_button("btnSave");
        }
    }

    function validateSecondaryDns() {
        $("#secondaryDns").on("keyup change",function(){
            if($("#secondaryDns").val() != '') {
                process_dns($(this).attr("id"),"btnSave");
                if(process_dns($(this).attr("id"), "btnSave")){
                    process_dns("primaryDNS","btnSave");

                    $("#primaryDNS").on("keyup change",function(){
                        process_dns("primaryDNS","btnSave");
                    });
                }
            } else{
                remove_redflag("secondaryDns");
                enable_button("btnSave");
                checkPrimaryDns();
            }
        });
    }

    function validateCustomMacAddr() {
        $("#customMacAddr").on("keyup change",function(){
            if($("#customMacAddr").val() != ""){
                process_mac($(this).attr("id"), "btnSave");
            }
            else{
                remove_redflag("customMacAddr");
                enable_button("btnSave");
            }
        });
    }

    function validateCustomMtu() {
        $("#customMtu").on("keyup change", function(){
            if($("#customMtu").val() != ""){
                process_mtu($(this).attr("id"), "btnSave");
            }
            else{
                remove_redflag("customMtu");
                enable_button("btnSave");
            }
        });
    }

    function validateGateway() {
        $("#gateway").on("keyup change",function(){
            if($("#gateway").val() != "") {
                process_subnet($(this).attr("id"), "btnSave");
            }
            else{
                remove_redflag("gateway");
                enable_button("btnSave");
            }
        });
    }

    function save() {
        $("#btnSave").click(function(){
            var dhcpConnectionType = $("#connectionTypeOptions").val();

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

            var lanIPClass = $("#lanIPAddr").hasClass("yes_redflag");
            var ssid24Class = $("#ssid24").hasClass("yes_redflag");
            var ssid5Class = $("#ssid5").hasClass("yes_redflag");
            var key24Class = $("#key24").hasClass("yes_redflag");
            var key5Class = $("#key5").hasClass("yes_redflag");

            if ((dhcpConnectionType == 'pppoe' && (pppoeUserClass || pppoePwdClass || pppoeServiceNameClass || pppoeMaxFailedPingClass || pppoePingIntervalClass)) ||
                (dhcpConnectionType == 'static' && (staticIpClass || netmaskClass || gatewayClass  || $("#primaryDNS").val() == "")) ||
                primaryDNSClass || secondaryDnsClass|| customMacAddrClass || customMtuClass ||
                lanIPClass || ssid24Class || ssid5Class || key24Class || key5Class || (primaryDNSVal == "" && secondaryDNSVal != "")) {

                if ((primaryDNSVal == "" && secondaryDNSVal != "") || (dhcpConnectionType == 'static' && $("#primaryDNS").val() == "")) {
                    apply_redflag("primaryDNS");
                }
                disable_button("btnSave");
                return false;
            } else {
                var ipv4 = $("#ipv4").val();
                if (ipv4 == 'c') {

                    var lanIPAddr4Octet = parseInt($("#lanIPAddr").val().split('.')[3]);
                    if (lanIPAddr4Octet >= parseInt($("#classCStart").val()) && lanIPAddr4Octet <= parseInt($("#classCEnd").val())) {
                        alert("Please change Lan IP address as Lan IP address can not be within the DHCP range.");

                        apply_redflag("lanIPAddr");
                        disable_button("btnSave");

                        return false;
                    } else  {
                        return true;

                    }
                }
            }
        });
    }


});








