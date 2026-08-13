$(document).ready(function(){
    displayLeftNav();

    $("#port_forward_help").click(function(){
        portForwardHelpMessage();
    });

    $("#addApplicationName").on("keyup change",function(){
        if($("#addApplicationName").val() != ""){
            checkDescriptionCell($(this).attr("id"), "add");
        }
        else{
            remove_redflag("addApplicationName");
            enable_button("add");
        }
    });

    process_ip("addLanIp", "add");

    validatePort("addWanPort", "add");
    validatePort("addLanPort", "add");

    $("#addWanPort, #addLanPort").on("keyup change",function(){
        validatePort($(this).attr("id"), "add");
    });

    $("#addLanIp").on("keyup change",function(){
        process_ip($(this).attr("id"), "add");
    });

    $("#add").click(function(){
        var applicationNameClass = $("#addApplicationName").hasClass("yes_redflag");
        var wanPortClass = $("#addWanPort").hasClass("yes_redflag");
        var lanIpClass = $("#addLanIp").hasClass("yes_redflag");
        var lanPortClass = $("#addLanPort").hasClass("yes_redflag");

        if (applicationNameClass || wanPortClass || lanIpClass || lanPortClass) {
            disable_button("add");
            return false;
        } else {
            addForwardedPorts();

            $("#addApplicationName").val("");
            $("#protocalOptions").val("tcpudp");
            $("#addWanPort").val("");
            $("#addLanIp").val("");
            $("#addLanPort").val("");

            process_ip("addLanIp", "add");
        }
    });

    modifyRow();
    deleteRow();

    applyChanges();
    cancel();
    refresh();

    function modifyRow() {
        $('td[id^=btnModify]').each(function(){
            var par = $(this).parent();
            var input = par.find("td");
            var applicationName = input[0].textContent;
            var protocol = input[1].textContent;
            var wanPort = input[2].textContent;
            var lanIP = input[3].textContent;
            var lanPort = input[4].textContent;
            var buttons = getEditDelete(applicationName, protocol, wanPort, lanIP, lanPort);
            $(this).append(buttons[0]);
            $(this).append(buttons[1]);
        });
    }

    function deleteRow() {
        $('input[id^=btnDelete]').each(function(){
            $(this).click(function(){
                var index = $(this).parent().attr('id').substr(9);;
                window.location = "/portforward/deleteForwardedPort/"+index;
            });
        });
    }

    function applyChanges() {
        $("#btnApply").click(function(){
            var tableData = [];
            $("#addTo tr.dataInput").each(function () {
                var row = [];
                $(this).find("td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4)").each(function () {
                    row.push(this.innerHTML);
                });
                tableData.push("&");
                tableData.push(row);
            });

            window.location = "/portforward/save/"+tableData;
        });
    }

    function cancel() {
        $("#cancel").click(function(){
            $("#addApplicationName").val("");
            $("#protocalOptions").val("tcpudp");
            $("#addWanPort").val("");
            $("#addLanIp").val("");
            $("#addLanPort").val("");

            process_ip("addLanIp", "add");
        });
    }

    function addForwardedPorts() {
        var inputTxt = $("#addSSID tr td");
        var input = inputTxt.find("input[type=text]");
        var applicationName = input[0].value;
        var protocol = $("#protocalOptions").val();

        if (protocol == 'tcpudp') {
            protocol = 'Both';
        } else if (protocol == 'tcp'){
            protocol = 'TCP';
        } else {
            protocol = 'UDP';
        }

        var wanPort = input[1].value;
        var lanIP = input[2].value;
        var lanPort = input[3].value;

        addRow(applicationName, protocol, wanPort, lanIP, lanPort);
    }

    function addRow(applicationName, protocol, wanPort, lanIP, lanPort) {
        $("#addTo").append("<tr class='dataInput' style='text-align:center;'>" +
            "<td>" + applicationName + "</td>" +
            "<td>" + protocol + "</td>>" +
            "<td>" + wanPort + "</td>" +
            "<td>" + lanIP + "</td>" +
            "<td>" + lanPort + "</td>" +
            "<td></td>" +
            "</tr>");
        var table = $("#addTo tr:last td:last");
        var buttons = getEditDelete(applicationName, protocol, wanPort, lanIP, lanPort);

        table.append(buttons[0]);
        table.append(buttons[1]);
    }

    function getEditDelete(applicationName, protocol, wanPort, lanIP, lanPort){
        var add = $('<input/>',
            {
                value: 'Edit',
                type: 'button',
                class: 'cta-button',
                click: function () {
                    var par = $($(this).parent()).parent();
                    var input = par.find("td");

                    if (protocol == 'Both') {
                        protocol = 'tcpudp';
                    } else if (protocol == 'TCP'){
                        protocol = 'tcp';
                    } else if(protocol == 'UDP') {
                        protocol = 'udp';
                    }
                    input[0].innerHTML = "<input type='text' style='width: 95%;' id='editApplicationName' maxlength='32' value='" + applicationName + "'>";
                    input[1].innerHTML = "<select id='editProtocol' style='width: 95%;'><option value='tcpudp'>Both</option><option value='tcp'>TCP</option><option value='udp'>UDP</option></select>";
                    input[2].innerHTML = "<input id='editWanPort' style='width:95%' type='text' value='" + wanPort + "'>";
                    input[3].innerHTML = "<input id='editIPAddr' style='width:95%' type='text' value='" + lanIP + "'>";
                    input[4].innerHTML = "<input id='editLanPort'style='width:95%' type='text' value='" + lanPort + "'>";
                    input[5].innerHTML = "";

                    $("#editProtocol").val(protocol);

                    $("#editApplicationName").on("keyup change",function(){
                        if($("#editApplicationName").val() != ""){
                            checkDescriptionCell($(this).attr("id"), "btnSave");
                        }
                        else{
                            remove_redflag("editApplicationName");
                            enable_button("btnSave");
                        }
                    });

                    $("#editWanPort, #editLanPort").on("keyup change",function(){
                        validatePort($(this).attr("id"), "btnSave");
                    });

                    $("#editIPAddr").on("keyup change",function(){
                        process_ip($(this).attr("id"), "btnSave");
                    });

                    disable_button("btnApply");
                    disable_button("Refresh");
                    disable_button("btnReboot");

                    var save = $('<input/>',  {
                        value: 'Save',
                        type: 'button',
                        id: 'btnSave',
                        class: 'cta-button',
                        click: function () {
                            var applicationNameClass = $("#editApplicationName").hasClass("yes_redflag");
                            var wanPortClass = $("#editWanPort").hasClass("yes_redflag");
                            var lanIpClass = $("#editIPAddr").hasClass("yes_redflag");
                            var lanPortClass = $("#editLanPort").hasClass("yes_redflag");

                            if (applicationNameClass || wanPortClass || lanIpClass || lanPortClass) {
                                disable_button("btnSave");
                                return false;
                            } else {
                                var par = $($(this).parent()).parent();
                                var row = par.find("input[type=text]");
                                var pro = par.find("select");
                                protocol = pro[0].value;
                                if (protocol == 'tcpudp') {
                                    protocol = 'Both';
                                } else if (protocol == 'tcp'){
                                    protocol = 'TCP';
                                } else {
                                    protocol = 'UDP';
                                }
                                applicationName = row[0].value;
                                wanPort = row[1].value;
                                lanIP = row[2].value;
                                lanPort = row[3].value;
                                var html = "";
                                html += "<td>" + applicationName + "</td>";
                                html += "<td>" + protocol + "</td>";
                                html += "<td>" + wanPort + "</td>";
                                html += "<td>" + lanIP + "</td>";
                                html += "<td>" + lanPort + "</td>";
                                html += "<td></td>";
                                par.html(html);
                                var lst = par.find("td:last");
                                lst.append(add);
                                lst.append(remove);

                                enable_button("btnApply");
                                enable_button("Refresh");
                                enable_button("btnReboot");
                            }
                        }
                    });

                    var cancel = $('<input/>',
                        {
                            value: 'Cancel',
                            type: 'button',
                            class: 'cta-button',
                            click: function () {
                                if (protocol == 'tcpudp') {
                                    protocol = 'Both';
                                } else if (protocol == 'tcp'){
                                    protocol = 'TCP';
                                } else {
                                    protocol = 'UDP';
                                }

                                var par = $($(this).parent()).parent();
                                var html = "";
                                html += "<td>" + applicationName + "</td>";
                                html += "<td>" + protocol + "</td>";
                                html += "<td>" + wanPort + "</td>";
                                html += "<td>" + lanIP + "</td>";
                                html += "<td>" + lanPort + "</td>";
                                html += "<td></td>";
                                par.html(html);
                                var lst = par.find("td:last");
                                lst.append(add);
                                lst.append(remove);

                                enable_button("btnApply");
                                enable_button("Refresh");
                                enable_button("btnReboot");
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
                id : 'btnDelete',
                click: function () {
                    var par = $($(this).parent()).parent();
                    par.remove();
                }
            });
        return [add,remove];
    }

});