$(document).ready(function () {
    displayLeftNav();
    selectVpnMode();

    $("#vpn_mode_options_help").click(function () {
        vpnModeHelpMessage();
    });

    $("#vpnModeOptions").on("keyup change", function () {
        if (confirm("Warning: Only one VPN service is supported at a time.  Selecting other VPN services will delete or modify the configuration data.") == true) {
            selectVpnMode();
        } else {
            location.reload();
        }
    });

    cancel();
    save();

    function selectVpnMode() {
        if ($("#vpnModeOptions").val() == 'ipsec_enabled') {
            $("#presharedKeyDiv").show();
            $("#ikeAggressiveModeDiv").show();

            $("#presharedKeySetup").html("IPSec Setup").show();
            $("#dhcpServerDiv").show();

            $("#l2tpIpRangeDiv").hide();
            $("#pptpIpRangeDiv").hide();

            ipsecModeHelpMessage();
            $("#vpn_mode_options_help").click(function () {
                ipsecModeHelpMessage();
            });

            $("#ike_aggressive_mode_options_help").click(function () {
                aggressiveModeHelpMessage();
            });

            $("#ikeAggressiveModeOptions").focus(function () {
                aggressiveModeHelpMessage();
            });

            $("#preshared_key_help").click(function () {
                presharedKeyHelpMessage();
            });

            $("#presharedKey").focus(function () {
                presharedKeyHelpMessage();
            });

            $("#dhcp_server_help").click(function () {
                dhcpServerHelpMessage();
            });

            $("#dhcpServer").focus(function () {
                dhcpServerHelpMessage();
            });

            validatePresharedKey("presharedKey", "btnApply");
            $("#presharedKey").on("keyup change", function () {
                validatePresharedKey($(this).attr("id"), "btnApply");
            });

            process_ip("dhcpServer", "btnApply");
            $("#dhcpServer").on("keyup change", function () {
                process_ip($(this).attr("id"), "btnApply");
            });

        } else if ($("#vpnModeOptions").val() == 'l2tp_enabled') {
            $("#presharedKeyDiv").show();
            $("#ikeAggressiveModeDiv").show();
            $("#presharedKeySetup").html("L2TP/IPSec Setup").show();
            $("#l2tpIpRangeDiv").show();

            $("#dhcpServerDiv").hide();
            $("#pptpIpRangeDiv").hide();

            l2tpModeHelpMessage();
            $("#vpn_mode_options_help").click(function () {
                l2tpModeHelpMessage();
            });

            $("#ike_aggressive_mode_options_help").click(function () {
                aggressiveModeHelpMessage();
            });

            $("#ikeAggressiveModeOptions").focus(function () {
                aggressiveModeHelpMessage();
            });

            $("#preshared_key_help").click(function () {
                presharedKeyHelpMessage();
            });

            $("#presharedKey").focus(function () {
                presharedKeyHelpMessage();
            });

            $("#l2tp_starting_ip_address_help").click(function () {
                startIPAddrHelpMessage();
            });

            $("#l2tpIpAddrEnd4Octet").focus(function () {
                startIPAddrHelpMessage();
            });

            $("#l2tp_end_ip_address_help").click(function () {
                endIPAddrHelpMessage();
            });

            $("#l2tpIpAddrEnd4Octet").focus(function () {
                endIPAddrHelpMessage();
            });

            validatePresharedKey("presharedKey", "btnApply");
            $("#presharedKey").on("keyup change", function () {
                validatePresharedKey($(this).attr("id"), "btnApply");
            });

            $("#l2tpIpAddrStart4Octet").on("keyup change", function () {
                validateIPAddrStart($(this).attr("id"), "btnApply");
            });

            $("#l2tpIpAddrEnd4Octet").on("keyup change", function () {
                validateIPAddrEnd($(this).attr("id"), "btnApply");
            });

        } else if ($("#vpnModeOptions").val() == 'pptp_enabled') {
            $("#pptpIpRangeDiv").show();

            $("#presharedKeyDiv").hide();
            $("#ikeAggressiveModeDiv").hide();

            $("#l2tpIpRangeDiv").hide();
            $("#dhcpServerDiv").hide();

            pptpModeHelpMessage();
            $("#vpn_mode_options_help").click(function () {
                pptpModeHelpMessage();
            });

            $("#pptp_starting_ip_address_help").click(function () {
                startIPAddrHelpMessage();
            });

            $("#pptpIpAddrStart4Octet").focus(function () {
                startIPAddrHelpMessage();
            });

            $("#pptp_end_ip_address_help").click(function () {
                endIPAddrHelpMessage();
            });

            $("#pptpIpAddrEnd4Octet").focus(function () {
                endIPAddrHelpMessage();
            });

            $("#pptpIpAddrStart4Octet").on("keyup change", function () {
                validateIPAddrStart($(this).attr("id"), "btnApply");
            });

            $("#pptpIpAddrEnd4Octet").on("keyup change", function () {
                validateIPAddrEnd($(this).attr("id"), "btnApply");
            });

        } else {
            $("#presharedKeyDiv").hide();
            $("#ikeAggressiveModeDiv").hide();
            $("#dhcpServerDiv").hide();
            $("#pptpIpRangeDiv").hide();
            $("#l2tpIpRangeDiv").hide();

        }
    }

    function save() {
        $("#btnApply").click(function () {
            var lanIPAddr4Octet = parseInt($("#lanIPAddr").html().split('.')[3]);
            var presharedKeyClass = '';

            if ($("#vpnModeOptions").val() == 'pptp_enabled') {
                if (lanIPAddr4Octet > parseInt($("#pptpIpAddrStart4Octet").val()) && lanIPAddr4Octet < parseInt($("#pptpIpAddrEnd4Octet").val())) {
                    alert("Please change IP start or end as Lan IP address can not be within the IP range.");
                    disable_button("btnApply");
                }

                if (parseInt($("#pptpIpAddrEnd4Octet").val()) <= parseInt($("#pptpIpAddrStart4Octet").val())) {
                    alert("IP range end has to be bigger than start.");
                    disable_button("btnApply");
                }

                var pptpIpAddrStart4OctetClass = $("#pptpIpAddrStart4Octet").hasClass("yes_redflag");
                var pptpIpAddrEnd4OctetClass = $("#pptpIpAddrEnd4Octet").hasClass("yes_redflag");

                if (pptpIpAddrStart4OctetClass || pptpIpAddrEnd4OctetClass ) {
                    disable_button("btnApply");
                    return false;
                }

            } else if ($("#vpnModeOptions").val() == 'l2tp_enabled') {
                if (lanIPAddr4Octet > parseInt($("#l2tpIpAddrStart4Octet").val()) && lanIPAddr4Octet < parseInt($("#l2tpIpAddrEnd4Octet").val())) {
                    alert("Please change IP start or end as Lan IP address can not be within the IP range.");
                    disable_button("btnApply");
                }

                if (parseInt($("#l2tpIpAddrEnd4Octet").val()) <= parseInt($("#l2tpIpAddrStart4Octet").val())) {
                    alert("IP range end has to be bigger than start.");
                    disable_button("btnApply");
                }

                presharedKeyClass = $("#presharedKey").hasClass("yes_redflag");
                var l2tpIpAddrStart4OctetClass = $("#l2tpIpAddrStart4Octet").hasClass("yes_redflag");
                var l2tpIpAddrEnd4Octet4OctetClass = $("#l2tpIpAddrEnd4Octet").hasClass("yes_redflag");

                if (presharedKeyClass || l2tpIpAddrStart4OctetClass || l2tpIpAddrEnd4Octet4OctetClass) {
                    disable_button("btnApply");
                    return false;
                }

            } else {
                presharedKeyClass = $("#presharedKey").hasClass("yes_redflag");
                var dhcpServerClass = $("#dhcpServer").hasClass("yes_redflag");

                if (presharedKeyClass || dhcpServerClass) {
                    disable_button("btnApply");
                    return false;
                }
            }

        });
    }

});