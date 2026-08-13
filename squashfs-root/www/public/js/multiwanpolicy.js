$(document).ready(function () {
    displayLeftNav();

    var cookieValue=readCookie('test');
    if(cookieValue==null){
        createCookie("test","5",1);
        alert('Policies define how traffic is routed through the different WAN interfaces. ' +
            'Use Rules to define what traffic to match and what policy to assign for that traffic.');
    }

    $("#multi_wan_policy_help").click(function(){
        multiWanPolicyHelpMessage();
    });

    checkMultiWanPolicyOptions();

    selectMultiWanPolicy();
    $("#multiWanPolicyOptions").on("keyup change", function () {
        selectMultiWanPolicy();
    });

    function  checkMultiWanPolicyOptions() {
        var wan3Status = $("#multiWan3Status").val();
        var wan4Status = $("#multiWan4Status").val();

        if (wan3Status == 0) {
            $("#multiWanPolicyOptions option[value='3singlewan']").attr('disabled', true);
        }

        if (wan4Status == 0) {
            $("#multiWanPolicyOptions option[value='4singlewan']").attr('disabled', true);
        }

        if (wan3Status == 0 && wan4Status == 0) {
            $("#multiWanPolicyOptions option[value='2balanced']").attr('disabled', true);
            $("#multiWanPolicyOptions option[value='2failover']").attr('disabled', true);
        }
    }

    function validateMemberWeight(policyName) {
        $(".memberWeight_" + policyName).on("keyup change", function () {
            process_member_weight($(this).attr('id'), "btnApply")
        });
    }

    function validateMemberPriority(policyName) {
        $(".memberPriority_" + policyName).on("keyup change", function () {
            process_member_weight($(this).attr('id'), "btnApply")
        });
    }

    function validateRuleName(ruleName) {
        process_rule_name("add" + ruleName + "RuleName", "add" + ruleName + "Rule");
        $("#add" + ruleName + "RuleName").keyup(function () {
            process_rule_name("add" + ruleName + "RuleName", "add" + ruleName + "Rule");
        });
    }

    function validateAddr(addrName, ruleName) {
        if (addrName == 'Src') {
            if ($("#add" + ruleName + addrName + "Addr").val() == '') {
                remove_redflag("add" + ruleName + addrName + "Addr");
                enable_button("add" + ruleName + "Rule");
            }

        } else {
            process_source_host("add" + ruleName + addrName + "Addr", "add" + ruleName + "Rule");
        }

        $("#add" + ruleName + addrName + "Addr").keyup(function () {
            process_source_host("add" + ruleName + addrName + "Addr", "add" + ruleName + "Rule");

            if (addrName == 'Src') {
                if ($("#add" + ruleName + addrName + "Addr").val() == '') {
                    remove_redflag("add" + ruleName + addrName + "Addr");
                    enable_button("add" + ruleName + "Rule");
                }
            }
        });
    }

    function validatePort(addrName, ruleName) {
        $("#add" + ruleName + addrName + "Port").keyup(function () {
            if ($("#add" + ruleName + addrName + "Port").val() == '') {
                remove_redflag("add" + ruleName + addrName + "Port");
                enable_button("add" + ruleName + "Rule");
            } else {
                if ($("#add" + ruleName + addrName + "Port").val().indexOf(",") >= 0) {
                    process_port_comma($(this).attr("id"), "add" + ruleName + "Rule");
                } else if ($("#add" + ruleName + addrName + "Port").val().indexOf(":") >= 0) {
                    process_port_colon($(this).attr("id"), "add" + ruleName + "Rule");
                }else {
                    process_wan_lan_port($(this).attr("id"), "add" + ruleName + "Rule");
                }
            }
        });
    }

    addRuleByPolicy("Balanced");
    addRuleByPolicy("Failover");
    addRuleByPolicy("Singlewan");

    modifyRow();
    deleteRow();

    cancel();

    $('input[id^=cancel]').each(function () {
        $(this).click(function () {
            location.reload();
        });
    });

    save("Balanced");
    save("Balanced2");
    save("Failover");
    save("Failover2");
    save("Singlewan");
    save("Singlewan2");
    save("Singlewan3");
    save("Singlewan4");

    function selectMultiWanPolicy() {
        if ($("#multiWanPolicyOptions").val() == 'balanced') {
            $("#balancedDiv").show();

            $("#balanced2Div").hide();
            $("#failoverDiv").hide();
            $("#failover2Div").hide();
            $("#singleWanDiv").hide();
            $("#singleWan2Div").hide();
            $("#singleWan3Div").hide();
            $("#singleWan4Div").hide();

            $('.memberWeight_Balanced').each(function(){
                var id = $(this).attr('id');

                $("#" + id).on("keyup change", function () {
                    process_member_weight(id, "btnApply");
                });

            });

            $('.checkboxWanMember_Balanced').click(function () {
                var par = $($(this).parent()).parent();
                var input = par.find("td");

                if ($(this).is(':checked')) {
                    var wanNum = $(this).attr('id').substr(5);
                    input[2].innerHTML = "<input name='memberWeight" + wanNum + "' id='memberWeight" + wanNum + "' type='text' autocomplete='off' checked>";

                    process_member_weight("memberWeight" + wanNum, "btnApply");
                    $("#memberWeight" + wanNum).on("keyup change", function () {
                        process_member_weight("memberWeight" + wanNum, "btnApply");
                    });

                } else {
                    input[2].innerHTML = "";
                    enable_button("btnApply");

                }
            });

            validateRuleName("Balanced");
            validateAddr("Src", "Balanced");
            validatePort("Src", "Balanced");
            validateAddr("Dest", "Balanced");
            validatePort("Dest", "Balanced");

        } else if ($("#multiWanPolicyOptions").val() == 'failover') {
            $("#failoverDiv").show();

            $("#balancedDiv").hide();
            $("#balanced2Div").hide();
            $("#failover2Div").hide();
            $("#singleWanDiv").hide();
            $("#singleWan2Div").hide();
            $("#singleWan3Div").hide();
            $("#singleWan4Div").hide();

            validateMemberPriority("Failover");
            validateMemberWeight("Failover");

            $('.checkboxWanMember_Failover').click(function () {
                var par = $($(this).parent()).parent();
                var input = par.find("td");

                if ($(this).is(':checked')) {
                    var wanNum = $(this).attr('id').substr(5);

                    input[2].innerHTML = "<input name='memberPriority" + wanNum + "' id='memberPriority" + wanNum + "' type='text' autocomplete='off' checked>";

                    process_member_priority("memberPriority" + wanNum, "btnApply");
                    $("#memberPriority" + wanNum).on("keyup change", function () {
                        process_member_weight("memberPriority" + wanNum, "btnApply");
                    });

                } else {
                    input[2].innerHTML = "";
                    enable_button("btnApply");

                }
            });

            validateRuleName("Failover");
            validateAddr("Src", "Failover");
            validatePort("Src", "Failover");
            validateAddr("Dest", "Failover");
            validatePort("Dest", "Failover");

        } else if ($("#multiWanPolicyOptions").val() == 'singlewan') {
            $("#singleWanDiv").show();

            $("#balancedDiv").hide();
            $("#balanced2Div").hide();
            $("#failoverDiv").hide();
            $("#failover2Div").hide();
            $("#singleWan2Div").hide();
            $("#singleWan3Div").hide();
            $("#singleWan4Div").hide();

            validateMemberPriority("Singlewan");

            $('.checkboxWanMember_Singlewan').click(function () {
                var par = $($(this).parent()).parent();
                var input = par.find("td");

                if ($(this).is(':checked')) {
                    var wanNum = $(this).attr('id').substr(5);
                    input[2].innerHTML = "<input name='memberPriority" + wanNum + "' id='memberPriority" + wanNum + "' type='text' autocomplete='off' checked>";

                    process_member_priority("memberPriority" + wanNum, "btnApply");
                    $("#memberPriority" + wanNum).on("keyup change", function () {
                        process_member_priority("memberPriority" + wanNum, "btnApply");
                    });

                } else {
                    input[2].innerHTML = "";
                    enable_button("btnApply");

                }
            });

            validateRuleName("Singlewan");
            validateAddr("Src", "Singlewan");
            validatePort("Src", "Singlewan");
            validateAddr("Dest", "Singlewan");
            validatePort("Dest", "Singlewan");

        } else if ($("#multiWanPolicyOptions").val() == '2balanced') {
            $("#balanced2Div").show();

            $("#balancedDiv").hide();
            $("#failoverDiv").hide();
            $("#failover2Div").hide();
            $("#singleWanDiv").hide();
            $("#singleWan2Div").hide();
            $("#singleWan3Div").hide();
            $("#singleWan4Div").hide();

            $('.memberWeight_Balanced2').each(function(){
                var id = $(this).attr('id');

                $("#" + id).on("keyup change", function () {
                    process_member_weight(id, "btnApply");
                });

            });

            $('.checkboxWanMember_Balanced2').click(function () {
                var par = $($(this).parent()).parent();
                var input = par.find("td");

                if ($(this).is(':checked')) {
                    var wanNum = $(this).attr('id').substr(5);
                    input[2].innerHTML = "<input name='memberWeight" + wanNum + "' id='memberWeight" + wanNum + "' type='text' autocomplete='off' checked>";

                    process_member_weight("memberWeight" + wanNum, "btnApply");
                    $("#memberWeight" + wanNum).on("keyup change", function () {
                        process_member_weight("memberWeight" + wanNum, "btnApply");
                    });

                } else {
                    input[2].innerHTML = "";
                    enable_button("btnApply");

                }
            });

            validateRuleName("Balanced2");
            validateAddr("Src", "Balanced2");
            validatePort("Src", "Balanced2");
            validateAddr("Dest", "Balanced2");
            validatePort("Dest", "Balanced2");

        } else if ($("#multiWanPolicyOptions").val() == '2failover') {
            $("#failover2Div").show();

            $("#balancedDiv").hide();
            $("#balanced2Div").hide();
            $("#failoverDiv").hide();
            $("#singleWanDiv").hide();
            $("#singleWan2Div").hide();
            $("#singleWan3Div").hide();
            $("#singleWan4Div").hide();

            validateMemberPriority("Failover2");
            validateMemberWeight("Failover2");

            $('.checkboxWanMember_Failover2').click(function () {
                var par = $($(this).parent()).parent();
                var input = par.find("td");

                if ($(this).is(':checked')) {
                    var wanNum = $(this).attr('id').substr(5);

                    input[2].innerHTML = "<input name='memberPriority" + wanNum + "' id='memberPriority" + wanNum + "' type='text' autocomplete='off' checked>";

                    process_member_priority("memberPriority" + wanNum, "btnApply");
                    $("#memberPriority" + wanNum).on("keyup change", function () {
                        process_member_weight("memberPriority" + wanNum, "btnApply");
                    });

                } else {
                    input[2].innerHTML = "";
                    enable_button("btnApply");

                }
            });

            validateRuleName("Failover2");
            validateAddr("Src", "Failover2");
            validatePort("Src", "Failover2");
            validateAddr("Dest", "Failover2");
            validatePort("Dest", "Failover2");

        } else if ($("#multiWanPolicyOptions").val() == '2singlewan') {
            $("#singleWan2Div").show();

            $("#balancedDiv").hide();
            $("#balanced2Div").hide();
            $("#failoverDiv").hide();
            $("#failover2Div").hide();
            $("#singleWanDiv").hide();
            $("#singleWan3Div").hide();
            $("#singleWan4Div").hide();

            validateMemberPriority("Singlewan2");

            $('.checkboxWanMember_Singlewan2').click(function () {
                var par = $($(this).parent()).parent();
                var input = par.find("td");

                if ($(this).is(':checked')) {
                    var wanNum = $(this).attr('id').substr(5);
                    input[2].innerHTML = "<input name='memberPriority" + wanNum + "' id='memberPriority" + wanNum + "' type='text' autocomplete='off' checked>";

                    process_member_priority("memberWeight" + wanNum, "btnApply");
                    $("#memberPriority" + wanNum).on("keyup change", function () {
                        process_member_priority("memberPriority" + wanNum, "btnApply");
                    });

                } else {
                    input[2].innerHTML = "";
                    enable_button("btnApply");

                }
            });

            validateRuleName("Singlewan2");
            validateAddr("Src", "Singlewan2");
            validatePort("Src", "Singlewan2");
            validateAddr("Dest", "Singlewan2");
            validatePort("Dest", "Singlewan2");

        } else if ($("#multiWanPolicyOptions").val() == '3singlewan') {
            $("#singleWan3Div").show();

            $("#balancedDiv").hide();
            $("#balanced2Div").hide();
            $("#failoverDiv").hide();
            $("#failover2Div").hide();
            $("#singleWanDiv").hide();
            $("#singleWan2Div").hide();
            $("#singleWan4Div").hide();

            validateMemberPriority("Singlewan3");

            $('.checkboxWanMember_Singlewan3').click(function () {
                var par = $($(this).parent()).parent();
                var input = par.find("td");

                if ($(this).is(':checked')) {
                    var wanNum = $(this).attr('id').substr(5);
                    input[2].innerHTML = "<input name='memberPriority" + wanNum + "' id='memberPriority" + wanNum + "' type='text' autocomplete='off' checked>";

                    process_member_priority("memberWeight" + wanNum, "btnApply");
                    $("#memberPriority" + wanNum).on("keyup change", function () {
                        process_member_priority("memberPriority" + wanNum, "btnApply");
                    });

                } else {
                    input[2].innerHTML = "";
                    enable_button("btnApply");

                }
            });

            validateRuleName("Singlewan3");
            validateAddr("Src", "Singlewan3");
            validatePort("Src", "Singlewan3");
            validateAddr("Dest", "Singlewan3");
            validatePort("Dest", "Singlewan3");

        } else if ($("#multiWanPolicyOptions").val() == '4singlewan') {
            $("#singleWan4Div").show();

            $("#balancedDiv").hide();
            $("#balanced2Div").hide();
            $("#failoverDiv").hide();
            $("#failover2Div").hide();
            $("#singleWanDiv").hide();
            $("#singleWan2Div").hide();
            $("#singleWan3Div").hide();

            validateRuleName("Singlewan4");
            validateAddr("Src", "Singlewan4");
            validatePort("Src", "Singlewan4");
            validateAddr("Dest", "Singlewan4");
            validatePort("Dest", "Singlewan4");

            validateMemberPriority("Singlewan4");

            $('.checkboxWanMember_Singlewan4').click(function () {
                var par = $($(this).parent()).parent();
                var input = par.find("td");

                if ($(this).is(':checked')) {
                    var wanNum = $(this).attr('id').substr(5);
                    input[2].innerHTML = "<input name='memberPriority" + wanNum + "' id='memberPriority" + wanNum + "' type='text' autocomplete='off' checked>";

                    process_member_priority("memberWeight" + wanNum, "btnApply");
                    $("#memberPriority" + wanNum).on("keyup change", function () {
                        process_member_priority("memberPriority" + wanNum, "btnApply");
                    });

                } else {
                    input[2].innerHTML = "";
                    enable_button("btnApply");

                }
            });

        }
    }

    function addRuleByPolicy(policyName) {
        $("#add" + policyName + "Rule").click(function () {
            addRule(policyName);
        });
    }

    function checkSrcPort(policyName, portName) {
        var lowerVal = $("#add"+policyName + portName).val().split(":")[0];
        var upperVal = $("#add"+policyName + portName).val().split(":")[1];

        if (parseInt(lowerVal) > parseInt(upperVal)) {
            apply_redflag("add"+policyName+portName);
        }
    }

    function addRule(policyName) {
        if ($("#add" + policyName + "RuleName").hasClass("yes_redflag") || $("#add" + policyName + "SrcAddr").hasClass("yes_redflag")
            ||$("#add"+ policyName + "SrcPort").hasClass("yes_redflag") || $("#add" + policyName + "DestAddr").hasClass("yes_redflag")
            ||$("#add"+ policyName + "DestPort").hasClass("yes_redflag") ) {

            disable_button("add" + policyName + "Rule");

            checkSrcPort(policyName, "SrcPort");
            checkSrcPort(policyName, "DestPort");

        } else {
            var inputTxt = $("#addRule" + policyName + " tr td");
            var input = inputTxt.find("input[type=text]");
            var ruleName = input[0].value;
            var srcAddr = input[1].value;
            var srcPort = input[2].value;
            var destAddr = input[3].value;
            var destPort = input[4].value;
            var proto = $("#add" + policyName + "ProtoOptions option:selected").val();

            addRow(policyName, ruleName, srcAddr, srcPort, destAddr, destPort, proto);

            $("#add" + policyName + "RuleName").val("");
            $("#add" + policyName + "SrcAddr").val("");
            $("#add"+ policyName + "SrcPort").val("");
            $("#add" + policyName + "DestAddr").val("");
            $("#add"+ policyName + "DestPort").val("");

            validateRuleName(policyName);
            validateAddr("Dest", policyName);
        }
    }

    function addRow(policyName, ruleName, srcAddr, srcPort, destAddr, destPort, proto) {
        var protoVal = "";

        if (proto == "all") {
            protoVal = "All";
        } else  {
            protoVal = proto.toUpperCase();
        }

        $("#addToRules" + policyName).append("<tr class='dataInput' style='text-align:center;'>" +
            "<td>" + ruleName + "</td>" +
            "<td>" + srcAddr + "</td>>" +
            "<td>" + srcPort + "</td>" +
            "<td>" + destAddr + "</td>" +
            "<td>" + destPort + "</td>" +
            "<td>" + protoVal + "</td>" +
            "<td></td>" +
            "</tr>");
        var table = $("#addToRules" + policyName + " tr:last td:last");
        var buttons = getEditDelete(ruleName, srcAddr, srcPort, destAddr, destPort, proto);

        table.append(buttons[0]);
        table.append(buttons[1]);
    }

    function getEditDelete(ruleName, srcAddr, srcPort, destAddr, destPort, proto) {
        var add = $('<input/>',
            {
                value: 'Edit',
                type: 'button',
                class: 'cta-button',
                click: function () {
                    var par = $($(this).parent()).parent();
                    var input = par.find("td");
                    if (proto == 'All') {
                        proto = 'all';
                    } else if (proto == 'TCP'){
                        proto = 'tcp';
                    } else if(proto == 'UDP') {
                        proto = 'udp';
                    }

                    input[0].innerHTML = "<input id='editRuleName' type='text' style='width: 140px;' autocomplete='off' value='" + ruleName + "'>";
                    input[1].innerHTML = "<input id='editSrcAddr' type='text' style='width: 140px;' autocomplete='off' value='" + srcAddr + "'>";
                    input[2].innerHTML = "<input id='editSrcPort' type='text' style='width: 140px;' autocomplete='off' value='" + srcPort + "'>";
                    input[3].innerHTML = "<input id='editDestAddr' type='text' style='width: 140px;' autocomplete='off' value='" + destAddr + "'>";
                    input[4].innerHTML = "<input id='editDestPort' type='text' style='width: 140px;' autocomplete='off' value='" + destPort + "'>";
                    input[5].innerHTML = "<select id='editProto' style='width: 100px;'>" +
                                         "<option value='all'>All</option><option value='tcp'>TCP</option><option value='udp'>UDP</option>" +
                                         "</select>";

                    input[6].innerHTML = "";

                    $("#editProto").val(proto);

                    $("#editRuleName").on("keyup change", function () {
                        process_rule_name("editRuleName", "btnSave");
                    });

                    $("#editSrcAddr").on("keyup change", function () {
                        process_source_host($(this).attr("id"), "btnSave");

                        if ($(this).val() == '') {
                            remove_redflag($(this).attr("id"));
                            enable_button("btnSave");
                        }
                    });

                    $("#editSrcPort").on("keyup change", function () {
                        if ($(this).val() == '') {
                            remove_redflag($(this).attr("id"));
                            enable_button("btnSave");
                        } else {
                            if ($(this).val().indexOf(",") >= 0) {
                                process_port_comma($(this).attr("id"), "btnSave");
                            } else if ($(this).val().indexOf(":") >= 0) {
                                process_port_colon($(this).attr("id"), "btnSave");
                            } else {
                                process_wan_lan_port($(this).attr("id"), "btnSave");
                            }
                        }
                    });

                    $("#editDestAddr").on("keyup change", function () {
                        process_source_host($(this).attr("id"), "btnSave");
                    });

                    $("#editDestPort").on("keyup change", function () {
                        if ($(this).val() == '') {
                            remove_redflag($(this).attr("id"));
                            enable_button("btnSave");
                        } else {
                            if ($(this).val().indexOf(",") >= 0) {
                                process_port_comma($(this).attr("id"), "btnSave");
                            } else if ($(this).val().indexOf(":") >= 0) {
                                process_port_colon($(this).attr("id"), "btnSave");
                            } else {
                                process_wan_lan_port($(this).attr("id"), "btnSave");
                            }
                        }
                    });

                    var save = $('<input/>', {
                        value: 'Save',
                        type: 'button',
                        id: 'btnSave',
                        class: 'cta-button',
                        click: function () {
                            var ruleNameClass = $("#editRuleName").hasClass("yes_redflag");
                            var srcAddrClass = $("#editSrcAddr").hasClass("yes_redflag");
                            var srcPortClass = $("#editSrcPort").hasClass("yes_redflag");
                            var destAddrClass = $("#editDestAddr").hasClass("yes_redflag");
                            var destPortClass = $("#editDestPort").hasClass("yes_redflag");

                            if (ruleNameClass || srcAddrClass || srcPortClass || destAddrClass || destPortClass) {
                                disable_button("btnSave");
                                return false;
                            } else {
                                var par = $($(this).parent()).parent();
                                var row = par.find("input[type=text]");

                                var ruleName = row[0].value;
                                var srcAddr = row[1].value;
                                var srcPort = row[2].value;
                                var destAddr = row[3].value;
                                var destPort = row[4].value;
                                var proto = $("#editProto option:selected").val();
                                var protoVal = "";
                                if (proto == "all") {
                                    protoVal = "All";
                                } else  {
                                    protoVal = proto.toUpperCase();
                                }

                                var html = "";
                                html += "<td>" + ruleName + "</td>";
                                html += "<td>" + srcAddr + "</td>";
                                html += "<td>" + srcPort + "</td>";
                                html += "<td>" + destAddr + "</td>";
                                html += "<td>" + destPort + "</td>";
                                html += "<td>" + protoVal + "</td>";
                                html += "<td></td>";
                                par.html(html);
                                var lst = par.find("td:last");
                                lst.append(add);
                                lst.append(remove);
                            }
                        }
                    });

                    var cancel = $('<input/>',
                        {
                            value: 'Cancel',
                            type: 'button',
                            class: 'cta-button',
                            click: function () {
                                var par = $($(this).parent()).parent();
                                var html = "";

                                if (proto == 'all') {
                                    proto = 'All';
                                } else if (proto == 'tcp'){
                                    proto = 'TCP';
                                } else {
                                    proto = 'UDP';
                                }

                                html += "<td>" + ruleName + "</td>";
                                html += "<td>" + srcAddr + "</td>";
                                html += "<td>" + srcPort + "</td>";
                                html += "<td>" + destAddr + "</td>";
                                html += "<td>" + destPort + "</td>";
                                html += "<td>" + proto + "</td>";
                                html += "<td></td>";
                                par.html(html);
                                var lst = par.find("td:last");
                                lst.append(add);
                                lst.append(remove);
                            }
                        });

                    var last = par.find("td:last");
                    last.append(save[0]);
                    last.append(cancel[0]);
                }
            });

        var remove = $('<input/>',
            {
                value: 'Delete',
                type: 'button',
                class: 'cta-button',
                id: 'btnDelete',
                click: function () {
                    var par = $($(this).parent()).parent();
                    par.remove();
                }
            });

        return [add, remove];
    }

    function modifyRow() {
        $('td[id^=btnModify]').each(function () {
            var par = $(this).parent();
            var input = par.find("td");
            var ruleName = input[0].textContent.trim();
            var srcAddr = input[1].textContent;
            var srcPort = input[2].textContent;
            var destAddr = input[3].textContent;
            var destPort = input[4].textContent;
            var proto = input[5].textContent;
            var buttons = getEditDelete(ruleName, srcAddr, srcPort, destAddr, destPort, proto);
            $(this).append(buttons[0]);
            $(this).append(buttons[1]);
        });
    }

    function deleteRow() {
        $('input[id^=btnDelete]').each(function () {
            $(this).click(function () {
                var ruleName = $(this).parent().attr('id').substr(10);
                window.location = "/multiwanpolicy/delete/" + ruleName;
            });
        });
    }

    function save(policyName) {
        $('#btnApply').click(function () {

            var tableData = [];
            $("#addToRules" + policyName + " tr.dataInput").each(function () {
                var row = [];
                $(this).find("td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5)").each(function () {
                    if (this.innerHTML.indexOf(',') >= 0) {
                        var portVal= this.innerHTML.replace(/,/g, '=');
                        this.innerHTML = portVal;
                    }

                    row.push(this.innerHTML);
                });
                tableData.push("&");
                tableData.push(row);
            });

            if (policyName == 'Singlewan2') {
                policyName = '2singlewan';
            } else if (policyName == 'Singlewan3') {
                policyName = '3singlewan';
            } else if (policyName == 'Singlewan4') {
                policyName = '4singlewan';
            } else if (policyName == 'Balanced2') {
                policyName = '2balanced';
            } else if (policyName == 'Failover2') {
                policyName = '2failover';
            }

            $("#ruleInfo" + policyName).val(tableData);
        });
    }

});





