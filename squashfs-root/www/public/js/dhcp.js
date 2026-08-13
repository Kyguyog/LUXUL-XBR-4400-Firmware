$(document).ready(function(){
    displayLeftNav();

    $("#dhcpServerOptions").focus(function () {
        enableDHCPServerHelpMessage();
    });

    $("#dhcp_server_options_help").click(function () {
        enableDHCPServerHelpMessage();
    });

    $("#ipv4ClassOptions").focus(function () {
        ipv4ClassHelpMessage();
    });

    $("#ipv4_class_options_help").click(function () {
        ipv4ClassHelpMessage();
    });

    selectIPV4Class();
    $("#ipv4ClassOptions").on("keyup change",function(){
        selectIPV4Class();

        if ($("#ipv4ClassOptions").val() == 'c') {
            $("#classCStart").val("100");
            $("#classCIPAddrNum").val("100");
            $("#classCEnd").val("200");
        }
    });

    $("#classBLanIPAddrStart").on("keyup change",function(){
        var classBLanIPAddrEnd = $("#classBLanIPAddrStart").val();
        $("#classBLanIPAddrEnd").val(classBLanIPAddrEnd);
    });

    save();
    cancel();

    function selectIPV4Class() {
        enable_button('btnSave');

        if ($("#ipv4ClassOptions").val() == 'c') {
            $("#classBDiv").hide();
            $("#classCDiv").show();

            displayIpv4ClassCHelpMessages();

            var lanIPAddr = $("#classCLanIPAddr").html().split('.');
            $("#classCLanIPAddrEnd").html(lanIPAddr[0]+"."+lanIPAddr[1]+"."+lanIPAddr[2]+".254");

            $("#classCStart").on("keyup change",function(){
                validateClassCDHCPStart("classCStart", "btnSave");
                var classCStart = convertNum("classCStart");
                var classCEnd =  convertNum("classCEnd");

                if (classCStart > classCEnd) {
                    apply_redflag("classCEnd");
                    disable_button("btnSave");
                } else {
                    remove_redflag("classCEnd");
                    enable_button("btnSave");
                }
            });

            $("#classCEnd").on("keyup change",function(){
                validateClassCEnd("classCEnd", "btnSave");
            });

            $("#classCLeaseTime").on("keyup change",function(){
                validateLeaseTime("classCLeaseTime", "btnSave");
            });

        } else {
            $("#classCDiv").hide();
            $("#classBDiv").show();

            displayIpv4ClassBHelpMessages();

            $("#classBLanIPAddr").on("keyup change",function(){
                if (process_ip("classBLanIPAddr", "btnSave")) {
                    calculateClassBLanIPAddrStart($("#classBLanSubnetMaskOptions").val());
                    calculateClassBLanIPAddrEnd($("#classBLanSubnetMaskOptions").val());

                    calculateDhcpStart();
                    calculateIPAddrNum();
                    calculateDhcpEnd();
                }
            });

            $("#classBLanSubnetMaskOptions").on("keyup change",function(){
                calculateClassBLanIPAddrStart($(this).val());
                calculateClassBLanIPAddrEnd($(this).val());

                calculateDhcpStart();
                calculateIPAddrNum();
                calculateDhcpEnd();
            });

            changeDhcpStart();
            changeDhcpIPAddrNum();
            changeDhcpEnd();
        }
    }

    function  calculateDhcpStart() {
        var classBLanIPAddrStart = $("#classBLanIPAddrStart").text().trim().split('.');
        $("#classBStart").val(classBLanIPAddrStart[0] + "." + classBLanIPAddrStart[1] + "." + classBLanIPAddrStart[2] + "." +"100");
    }

    function calculateIPAddrNum() {
        $("#classBIPAddrNum").val("100");
    }

    function calculateDhcpEnd() {
        var classBLanIPAddrStart = $("#classBLanIPAddrStart").text().trim().split('.');
        $("#classBEnd").val(classBLanIPAddrStart[0] + "." + classBLanIPAddrStart[1] + "." + classBLanIPAddrStart[2] + ".199");
    }

    function changeDhcpStart() {
        $("#classBStart").on("keyup change",function(){
            var classBDhcpStartArray = $("#classBStart").val().split('.');
            var classBDhcpEndArray = $("#classBEnd").val().split('.');

            if(valid_class_b_dhcp($("#classBStart").val())){
                remove_redflag("classBStart");
                enable_button("btnSave");

                calculateClassBIPAddrNum(classBDhcpStartArray, classBDhcpEndArray);
                checkClassBEnd(classBDhcpStartArray, classBDhcpEndArray);
                checkDhcpEnd4Octet(classBDhcpStartArray, classBDhcpEndArray);

            } else {
                apply_redflag("classBStart");
                disable_button("btnSave");
            }

        });
    }

    function changeDhcpIPAddrNum() {
        $("#classBIPAddrNum").on("keyup change",function(){

            var classBIPAddrNumMaxArray = $("#classBLanIPAddrEnd").text().split('.');
            var classBDhcpStartArray = $("#classBStart").val().split('.');
            var classBIPAddrNumMax = 255 * (parseInt(classBIPAddrNumMaxArray[2]) - parseInt(classBDhcpStartArray[2])) + (parseInt(classBIPAddrNumMaxArray[3] - parseInt(classBDhcpStartArray[3])));

            if(valid_class_b_ip_addr_num($(this).val())){
                if ($(this).val() > classBIPAddrNumMax) {
                    apply_redflag("classBIPAddrNum");
                    disable_button("btnSave");
                } else {
                    remove_redflag("classBIPAddrNum");
                    enable_button("btnSave");

                    validateClassBDhcp("classBEnd", "btnSave");
                    calculateClassBDhcpEnd($(this).val() -1);
                }

            } else {
                apply_redflag("classBIPAddrNum");
                disable_button("btnSave");
            }

        });
    }

    function changeDhcpEnd() {
        $("#classBEnd").on("keyup change",function(){
            var classBDhcpStartArray = $("#classBStart").val().split('.');
            var classBDhcpEndArray = $("#classBEnd").val().split('.');

            if(valid_class_b_dhcp($(this).val())){
                remove_redflag("classBEnd");
                enable_button("btnSave");

                checkClassBEnd(classBDhcpStartArray, classBDhcpEndArray);
                checkDhcpEnd4Octet(classBDhcpStartArray, classBDhcpEndArray);
                calculateClassBIPAddrNum(classBDhcpStartArray, classBDhcpEndArray);

            } else {
                apply_redflag("classBEnd");
                disable_button("btnSave");
            }
        });
    }

    function checkDhcpEnd4Octet(classBDhcpStartArray, classBDhcpEndArray) {
        if (classBDhcpStartArray[2] == classBDhcpEndArray[2] && parseInt(classBDhcpEndArray[3]) < parseInt(classBDhcpStartArray[3])){
            apply_redflag("classBEnd");
            disable_button("btnSave");
        }
    }

    function calculateClassBDhcpEnd(classBIPAddrNumMax) {
        var classBDhcpStartArray = $("#classBStart").val().split('.');
        var classBDhcp3Octet = Math.floor(parseInt(classBIPAddrNumMax) / 255);
        var classBDhcp4Octet = 0;

        if (classBDhcp3Octet == 0) {
            classBDhcp4Octet = parseInt(classBDhcpStartArray[3]) + parseInt(classBIPAddrNumMax) ;
        } else {
            classBDhcp4Octet = parseInt(classBIPAddrNumMax) - 255 * classBDhcp3Octet ;
        }

        $("#classBEnd").val(classBDhcpStartArray[0]+"."+classBDhcpStartArray[1]+"."+classBDhcp3Octet+"."+classBDhcp4Octet);
    }

    function calculateClassBIPAddrNum(classBDhcpStartArray, classBDhcpEndArray) {
        var classBIPAddrNum = "";

        if (classBDhcpStartArray[2] == classBDhcpEndArray[2]) {
            if (classBDhcpStartArray[3] == classBDhcpEndArray[3]) {
                classBIPAddrNum = 1;
            } else {
                classBIPAddrNum = parseInt(classBDhcpEndArray[3]) - parseInt(classBDhcpStartArray[3]) + 1;
            }
        } else {
            classBIPAddrNum = 255 * (parseInt(classBDhcpEndArray[2]) - parseInt(classBDhcpStartArray[2]));

            if (classBDhcpStartArray[3] == classBDhcpEndArray[3]) {
                classBIPAddrNum += 1;
            } else {
                classBIPAddrNum += parseInt(classBDhcpEndArray[3]) - parseInt(classBDhcpStartArray[3]);
                classBIPAddrNum += 1;
            }
        }

        if (classBIPAddrNum <= 0) {
            $("#classBIPAddrNum").val("");
        } else {
            $("#classBIPAddrNum").val(classBIPAddrNum);
        }

        validateclassBIPAddrNum("classBIPAddrNum", "btnSave");

    }

    function checkClassBEnd(classBDhcpStartArray, classBDhcpEndArray) {
        if (classBDhcpStartArray[0] != classBDhcpEndArray[0] ||
            classBDhcpStartArray[1] != classBDhcpEndArray[1] ||
            parseInt(classBDhcpStartArray[2]) > parseInt(classBDhcpEndArray[2])) {

            apply_redflag("classBEnd");
            disable_button("btnSave");
        } else {
            remove_redflag("classBEnd");
            enable_button("btnSave");
        }
    }

    function calculateClassBLanIPAddrStart(lanSubnetMask) {
        var lanIPAddr = $("#classBLanIPAddr").val().split('.');

        var lanIPAddrStart3OctetBin = calculateStartBin(toBinary(lanIPAddr[2]), toBinary(lanSubnetMask.split('.')[2]));
        var lanIPAddrStart3Octet = toDecimal(lanIPAddrStart3OctetBin);
        var lanIPAddrStart4OctetBin = calculateStartBin(toBinary(lanIPAddr[3]), toBinary(lanSubnetMask.split('.')[3]));
        var lanIPAddrStart4Octet = toDecimal(lanIPAddrStart4OctetBin) + 1;

        var lanIPAddrStart = lanIPAddr[0] + "." + lanIPAddr[1] + "." + lanIPAddrStart3Octet + "." + lanIPAddrStart4Octet;
        $("#classBLanIPAddrStart").html(lanIPAddrStart);
        $("#classBLanIPAddrStartHidden").val(lanIPAddrStart);
    }

    function toBinary(num) {
        var result = 999;
        var args = num;

        while (args > 1) {
            var arg1 = parseInt(args / 2);
            var arg2 = args % 2;
            args = arg1;

            if (result == 999) {
                result = arg2.toString();
            } else {
                result = arg2.toString() + result.toString();
            }
        }
        if (args == 1 && result != 999) {
            result = args.toString() + result.toString();
        }  else if (args == 0 && result == 999) {
            result = 0;
        }  else if (result == 999) {
            result = 1;
        }

        var length = result.length;

        while (length % 4 != 0) {
            result = "0" + result;
            length = result.length;
        }

        if (length == 4) {
            result = "0000" + result;
        }

        return result;
    }

    function  calculateStartBin(bin1, bin2) {
        var bin1Array = bin1.split("");
        var bin2Array = bin2.split("");
        var result;
        var binArray = [];

        for (var i = 0; i < 8; i++) {
            if (bin1Array[i] == 1 && bin2Array[i] == 1) {
                result = 1;

            } else if (bin1Array[i] == 0 && bin2Array[i] == 0) {
                result = 0;
            } else  {
                result = 0;
            }


            binArray[i] = result;
        }

        return binArray.join("");
    }

    function  toDecimal(bin) {
        return  parseInt(bin, 2);
    }

    function calculateClassBLanIPAddrEnd(lanSubnetMask) {
        var lanIPAddr = $("#classBLanIPAddr").val().split('.');

        var lanSubnetMask3OctetInvertBin = getInvertBin(toBinary(lanSubnetMask.split('.')[2]));
        var lanSubnetMask4OctetInvertBin = getInvertBin(toBinary(lanSubnetMask.split('.')[3]));

        var lanIPAddrEnd3OctetBin = calculateEndBin(toBinary(lanIPAddr[2]) , lanSubnetMask3OctetInvertBin);
        var lanIPAddrEnd3Octet = toDecimal(lanIPAddrEnd3OctetBin);
        var lanIPAddrEnd4OctetBin = calculateEndBin(toBinary(lanIPAddr[3]),lanSubnetMask4OctetInvertBin);
        var lanIPAddrEnd4Octet = toDecimal(lanIPAddrEnd4OctetBin) -1;

        var lanIPAddrEnd = lanIPAddr[0] + "." + lanIPAddr[1] + "." + lanIPAddrEnd3Octet + "." + lanIPAddrEnd4Octet;

        $("#classBLanIPAddrEnd").html(lanIPAddrEnd);
        $("#classBLanIPAddrEndHidden").val(lanIPAddrEnd);
    }

    function calculateEndBin(bin1, bin2) {
        var bin1Array = bin1.split("");
        var bin2Array = bin2.split("");
        var result;
        var binArray = [];

        for (var i = 0; i < 8; i++) {
            if (bin1Array[i] == 1 || bin2Array[i] == 1) {
                result = 1;

            } else if (bin1Array[i] == 0 || bin2Array[i] == 0) {
                result = 0;
            } else  {
                result = 0;
            }

            binArray[i] = result;
        }

        return binArray.join("");
    }

    function convertNum(id) {
        var num =  $("#" + id).val();
        return num == '' ? 0 : parseInt(num);
    }

    function getInvertBin(lanSubnetOctet) {
        var lanSubnetOctetArray = lanSubnetOctet.split("");
        var lanSubnetInvertOctetArray = [];
        var result;
        for (var i = 0; i < 8; i++ ) {
            if (lanSubnetOctetArray[i] == 0) {
                result = 1;
            } else {
                result = 0;
            }

            lanSubnetInvertOctetArray[i] = result;
        }

        return lanSubnetInvertOctetArray.join("");
    }

    function calculateClassCIPAddrNum() {
        var classCStart = convertNum("classCStart");
        var classCEnd = convertNum("classCEnd");

        $("#classCIPAddrNum").val(classCEnd - classCStart < 0 ? "" : classCEnd - classCStart);
    }

    function save() {
        $( "#btnSave" ).click(function(){
            if ($("#ipv4ClassOptions").val() == 'c') {
                var lanIPAddr4Octet = parseInt($("#classCLanIPAddr").html().split('.')[3]);

                if (lanIPAddr4Octet >= parseInt($("#classCStart").val()) && lanIPAddr4Octet <= parseInt($("#classCEnd").val())) {
                    alert("Please change DHCP start or end as LAN IP address can not be within the DHCP range.");
                    disable_button("btnSave");
                }

                calculateClassCIPAddrNum();

            } else {
                var lanIPAddr3Octet = parseInt($("#classBLanIPAddrEnd").html().split('.')[2]);
                var dhcpStart3Octet = parseInt($("#classBStart").val().split('.')[2]);
                var dhcpEnd3Octet = parseInt($("#classBEnd").val().split('.')[2]);

                if (dhcpStart3Octet > lanIPAddr3Octet || dhcpEnd3Octet > lanIPAddr3Octet) {
                    alert("DHCP Range Start has to be within LAN Subnet Mask range.");
                    disable_button("btnSave");
                }

                if ($("#classBStart").hasClass("yes_redflag") ||
                    $("#classBIPAddrNum").hasClass("yes_redflag") ||
                    $("#classBEnd").hasClass("yes_redflag") ||
                    $("#classBLeaseTime").hasClass("yes_redflag") || checkClassBDhcpStartEnd()) {

                    disable_button("btnSave");
                }
            }
        });
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

    function displayIpv4ClassCHelpMessages() {
        $("#class_c_lan_ip_addr_help").click(function () {
            classCLanIPAddrHelpMessage();
        });

        $("#class_c_lan_subnet_mask_options_help").click(function () {
            classCLanSubnetMaskHelpMessage();
        });

        $("#class_c_lan_ip_addr_end_help").click(function () {
            classCLanIPAddrEndtHelpMessage();
        });

        $("#class_c_start_help").click(function () {
            classCStartHelpMessage();
        });

        $("#classCStart").focus(function () {
            classCStartHelpMessage();
        });

        $("#class_c_end_help").click(function () {
            classCEndHelpMessage();
        });

        $("#classCEnd").focus(function () {
            classCEndHelpMessage();
        });

        $("#class_c_lease_time_help").click(function () {
            classCLeaseTimeHelpMessage();
        });

        $("#classCLeaseTime").focus(function () {
            classCLeaseTimeHelpMessage();
        });
    }

    function displayIpv4ClassBHelpMessages() {
        $("#class_b_lan_ip_addr_help").click(function () {
            classBLanIPAddrHelpMessage();
        });

        $("#classBLanIPAddr").focus(function () {
            classBLanIPAddrStartHelpMessage();
        });

        $("#class_b_lan_subnet_mask_options_help").click(function () {
            classBLanSubnetMaskHelpMessage();
        });

        $("#classBLanSubnetMaskOptions").focus(function () {
            classBLanSubnetMaskHelpMessage();
        });

        $("#class_b_lan_ip_addr_start_help").click(function () {
            classBLanIPAddrStartHelpMessage();
        });

        $("#class_b_lan_ip_addr_end_help").click(function () {
            classBLanIPAddrEndtHelpMessage();
        });

        $("#classBStart").focus(function () {
            classBStartHelpMessage();
        });

        $("#class_b_start_help").click(function () {
            classBStartHelpMessage();
        });

        $("#class_b_ip_addr_num_help").click(function () {
            classBIPAddrNumHelpMessage();
        });

        $("#classBIPAddrNum").focus(function () {
            classBIPAddrNumHelpMessage();
        });

        $("#class_b_end_help").click(function () {
            classBEndHelpMessage();
        });

        $("#classBEnd").focus(function () {
            classBEndHelpMessage();
        });

        $("#class_b_lease_time_help").click(function () {
            classBLeaseTimeHelpMessage();
        });

        $("#classBLeaseTime").focus(function () {
            classBLeaseTimeHelpMessage();
        });
    }

});