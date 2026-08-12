$(document).ready(function () {
    displayLeftNav();
    displayHelpMessages();

    process_vlan_description("vlanDescription","btnSave",false);
    $("#vlanDescription").on("keyup change",function(){
        process_vlan_description("vlanDescription","btnSave",false);
    });

    enableEgressRule();
    $(".checkEnabled").on("click", function() {
        enableEgressRule();
    });

    displayDHCPDiv();
    $("#dhcpServerStatus").on("click", function () {
        displayDHCPDiv();
    });

    process_ip("ipaddr", "btnSave");
    $("#ipaddr").on("keyup change",function(){
        process_ip($(this).attr("id"), "btnSave");
    });

    $("#subnetMask").on("keyup change",function(){
        process_subnet($(this).attr("id"), "btnSave");
    });

    $( "#btnCancel").click(function(){
        location.reload();
    });

    var url = (window.location.pathname).split("/");
    if (url[3] == '1') {
        $("#btnSave").removeAttr("disabled");
    }

    $( "#btnSave").click(function(){
        var ipv4Class = $("#ipv4Class").val();
        var vlanDescriptionClass = $("#vlanDescription").hasClass("yes_redflag");
        var ipAddrClass = $("#ipaddr").hasClass("yes_redflag");
        var subnetMaskClass = $("#subnetMask").hasClass("yes_redflag");
        var dhcpServerStatus = $("#dhcpServerStatus").is(":checked");
        var classCStartClass = $("#classCStart").hasClass("yes_redflag");
        var classCEndClass = $("#classCEnd").hasClass("yes_redflag");
        var classBStartClass = $("#classBStart").hasClass("yes_redflag");
        var classBEndClass = $("#classBEnd").hasClass("yes_redflag");
        var leaseTimeClass = $("#leaseTime").hasClass("yes_redflag");

        if (vlanDescriptionClass || ipAddrClass || subnetMaskClass || leaseTimeClass || checkPortEnabled() ||
            (ipv4Class=='b' && dhcpServerStatus && (classBStartClass||classBEndClass || checkClassBDhcpStart() || checkClassBDhcpStartEnd())) ||
            (ipv4Class=='c' && dhcpServerStatus && (classCStartClass||classCEndClass || checkClassCDhcpStart() || checkClassCDhcpEnd()))) {

            disable_button("btnSave");
            return false;
        }
    });

    function checkClassCDhcpStart() {
        var lanIPAddr4Octet = parseInt($("#ipaddr").html().split('.')[3]);
        var dhcpStart4Octet = parseInt($("#classCStart").val());

        if (lanIPAddr4Octet > dhcpStart4Octet) {
            alert("DHCP Range Start has to be bigger than LAN IP Address!")
            return true
        } else {
            return false;
        }
    }

    function checkClassCDhcpEnd() {
        var dhcpStart3Octet = parseInt($("#classCStart").val());
        var dhcpEnd3Octet = parseInt($("#classCEnd").val());

        if (dhcpStart3Octet > dhcpEnd3Octet) {
            alert("DHCP Range End has to be bigger than Start!")
            return true
        } else {
            return false;
        }
    }

    function checkClassBDhcpStart() {
        var lanIPAddr3Octet = parseInt($("#ipaddr").html().split('.')[2]);
        var lanIPAddr4Octet = parseInt($("#ipaddr").html().split('.')[3]);
        var dhcpStart3Octet = parseInt($("#classBStart").val().split('.')[2]);
        var dhcpStart4Octet = parseInt($("#classBStart").val().split('.')[3]);

        if ((lanIPAddr3Octet==dhcpStart3Octet && lanIPAddr4Octet >= dhcpStart4Octet) || lanIPAddr3Octet > dhcpStart3Octet) {
            alert("DHCP Range Start has to be bigger than LAN IP Address!")
            return true
        } else {
            return false;
        }
    }

    function checkClassBDhcpStartEnd() {
        var dhcpStart3Octet = parseInt($("#classBStart").val().split('.')[2]);
        var dhcpEnd3Octet = parseInt($("#classBEnd").val().split('.')[2]);

        if (dhcpStart3Octet > dhcpEnd3Octet) {
            alert("DHCP Range End has to be bigger than Start!")
            return true
        } else {
            return false;
        }
    }

    function displayDHCPDiv() {
        var ipv4Class = $("#ipv4Class").val();

        if ($("#dhcpServerStatus").is(':checked')) {
            $("#dhcpRangeDiv").slideDown("slow");

            if (ipv4Class=='c' && parseInt($("#classCStart").val()) > 253) {
                $("#classCStart").val('');
                $("#classCEnd").val('');
                validateClassCDHCPStart("classCStart", "btnSave");
                validateClassCEnd("classCEnd", "btnSave");
            }

            $("#classCStart").on("keyup change",function(){
                validateClassCDHCPStart("classCStart", "btnSave");
            });

            if (ipv4Class !='c') {
                process_ip("classBStart", "btnSave");
                process_ip("classBEnd", "btnSave");
            }

            $("#classBStart, #classBEnd").on("keyup change",function(){
                process_ip($(this).attr("id"), "btnSave");
            });

            $("#classCEnd").on("keyup change",function(){
                validateClassCEnd("classCEnd", "btnSave");
            });

            $("#leasetime").on("keyup change",function(){
                validateLeaseTime("leasetime", "btnSave");
            });

        } else {
            $("#dhcpRangeDiv").slideUp("slow");
            if (ipv4Class !='c') {
                enable_button("btnSave");
            }
        }
    }

    function enableEgressRule() {
        $('.checkEnabled').each(function() {
            id = $(this).attr('id');
            if ($(this).is(":checked")) {
                $("#egressRuleOptions"+id).removeAttr("disabled");
            } else {
                $("#egressRuleOptions"+id).attr("disabled","disabled");
            }
        });

        var checked = $("#portsTable input:checked").length;
        if (checked=='0'){
            $("#btnSave").prop("disabled",1);
        } else {
            $("#btnSave").removeAttr("disabled");
        }

    }

    function checkPortEnabled() {
        var checked = $("#portsTable input:checked").length;
        if (checked==0){
            alert("Please enable at least one port.");
            return true;
        } else {
            return false;
        }
    }

    function displayHelpMessages() {
        $("#vlan_description_help").click(function(){
            vlanDescriptionHelpMessage();
        });

        $("#vlan_routing_help").click(function(){
            vlanRoutingHelpMessage();
        });

        $("#port_enable_help").click(function(){
            vlanPortEnableHelpMessage();
        });

        $("#ip_addr_help").click(function(){
            vlanIPAddrHelpMessage();
        });

        $("#ipaddr").focus(function(){
            vlanIPAddrHelpMessage();
        });

        $("#subnet_mask_help").click(function(){
            vlanSubnetMaskHelpMessage();
        });

        $("#classBLanSubnetMaskOptions, #subnetMask").focus(function(){
            vlanSubnetMaskHelpMessage();
        });

        $("#enable_dhcp_sever_help").click(function(){
            vlanDHCPServerHelpMessage();
        });

        $("#dhcpServerStatus").focus(function(){
            vlanDHCPServerHelpMessage();
        });

        $("#class_c_start_help").click(function(){
            vlanDHCPStartHelpMessage();
        });

        $("#classBStart, #classCStart").focus(function(){
            vlanDHCPStartHelpMessage();
        });

        $("#class_c_end_help").click(function(){
            vlanDHCPEndHelpMessage();
        });

        $("#classBEnd, #classCEnd").focus(function(){
            vlanDHCPEndHelpMessage();
        });

        $("#class_c_lease_time_help").click(function(){
            vlanDHCPLeaseTimeHelpMessage();
        });

        $("#leasetime").focus(function(){
            vlanDHCPLeaseTimeHelpMessage();
        });
    }


});