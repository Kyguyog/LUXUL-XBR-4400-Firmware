$(document).ready(function(){
    displayLeftNav();

    $("#static_lease_help").click(function(){
        leaseHelpMessage();
    });

    selectAll();
    unselectAll();

    $("#btnAddSSID").click(function(){
        addDiscoveredClients();
    });

    $("#add").click(function(){
        var descriptionClass = $("#addDescription").hasClass("yes_redflag");
        var ipAddrClass = $("#addIPAddr").hasClass("yes_redflag");
        var macAddrClass = $("#addMacAddr").hasClass("yes_redflag");

        if (descriptionClass || ipAddrClass || macAddrClass) {
            disable_button("add");
            return false;
        } else {
            addLease();

            $("#addDescription").val("");
            $("#addIPAddr").val("");
            $("#addMacAddr").val("");

            validateIpAddr();
            validateMacAddr();
        }
    });

    validateDescriptionCell();
    validateIpAddr();
    validateMacAddr();

    modifyRow();
    deleteRow();

    applyChanges();

    refresh();
    cancel();

    function selectAll() {
        $("#btnAll").click(function(){
            $("#clients tr").each(function(){
                var row = $(this).find("input");
                row.prop('checked',true);
            });
        });
    }

    function unselectAll() {
        $("#btnNone").click(function(){
            $("#clients tr").each(function(){
                var row = $(this).find("input");
                row.prop('checked',false);
            });
        });
    }

    function  validateDescriptionCell() {
        $("#addDescription").on("keyup change",function(){
            if($("#addDescription").val() != ""){
                checkDescriptionCell($(this).attr("id"), "add");
            }
            else{
                remove_redflag("addDescription");
                enable_button("add");
            }
        });
    }

    function validateIpAddr() {
        process_ip("addIPAddr", "add");
        $("#addIPAddr").on("keyup change",function(){
            process_ip($(this).attr("id"), "add");
        });
    }

    function validateMacAddr() {
        process_mac("addMacAddr", "add");
        $("#addMacAddr").on("keyup change",function(){
            process_mac($(this).attr("id"), "add");
        });
    }

    function modifyRow() {
        $('td[id^=btnModify]').each(function(){
            var par = $(this).parent();
            var input = par.find("td");
            var description = input[0].textContent;
            var hostname = input[1].textContent;
            var ipAddr = input[2].textContent;
            var macAddr = input[3].textContent;
            var buttons = getEditDelete(description, hostname, ipAddr, macAddr);
            $(this).append(buttons[0]);
            $(this).append(buttons[1]);
        });
    }

    function deleteRow() {
        $('input[id^=btnDelete]').each(function(){
            $(this).click(function(){
                var index = $(this).parent().attr('id').substr(9);
                window.location = "/lease/delete/"+index;
            });
        });
    }

    function applyChanges() {
        $("#btnApply").click(function(){
            var tableData = [];
            $("#addTo tr.dataInput").each(function () {
                var row = [];
                $(this).find("td:eq(0), td:eq(2), td:eq(3)").each(function () {
                    row.push(this.innerHTML);
                });
                tableData.push("&");
                tableData.push(row);
            });

            window.location = "/lease/save/"+tableData;

        });
    }

    function cancel() {
        $("#cancel").click(function(){
            $("#addDescription").val("");
            $("#addIPAddr").val("");
            $("#addMacAddr").val("");

            validateIpAddr();
            validateMacAddr();
        });
    }

    function addDiscoveredClients() {
        $("#clients tr").each(function(){
            var row = $(this).find("input");

            if(row.is(':checked')){
                var input = $(this).find("td");
                var hostname = input.eq(0).text();
                var ipAddr = input.eq(1).text();
                var macAddr = input.eq(2).text();

                addRow("", hostname, ipAddr, macAddr);
            }
        });
    }

    function addLease() {
        if ($("#addIPAddr").hasClass("yes_redflag") || $("#addMacAddr").hasClass("yes_redflag") ) {
            disable_button("add");
        } else {
            var inputTxt = $("#addSSID tr td");
            var input = inputTxt.find("input[type=text]");
            var description = input[0].value;
            var ipAddr = input[1].value;
            var macAddr = input[2].value;

            addRow(description, "", ipAddr, macAddr);
        }
    }

    function addRow(description, hostname, ipAddr, macAddr) {
        $("#addTo").append("<tr class='dataInput' style='text-align:center;'>" +
            "<td>" + description + "</td>" +
            "<td>" + hostname + "</td>>" +
            "<td>" + ipAddr + "</td>" +
            "<td>" + macAddr + "</td>" +
            "<td></td>" +
            "</tr>");
        var table = $("#addTo tr:last td:last");
        var buttons = getEditDelete(description, hostname, ipAddr, macAddr);

        table.append(buttons[0]);
        table.append(buttons[1]);
    }

    function getEditDelete(description, hostname, ipAddr, macAddr){
        var add = $('<input/>',
            {
                value: 'Edit',
                type: 'button',
                class: 'cta-button',
                click: function () {
                    var par = $($(this).parent()).parent();
                    var input = par.find("td");

                    input[0].innerHTML = "<input id='editDescription' type='text' style='width: 95%;' maxlength = '32' autocomplete='off' value='" + description + "'>";
                    input[2].innerHTML = "<input id='editIPAddr' type='text' style='width: 95%;' autocomplete='off' value='" + ipAddr + "'>";
                    input[3].innerHTML = "<input id='editMacAddr' type='text' style='width: 95%;' autocomplete='off' value='" + macAddr + "'>";
                    input[4].innerHTML = "";

                    $("#editDescription").on("keyup change",function(){
                        if($("#editDescription").val() != ""){
                            checkDescriptionCell($(this).attr("id"), "btnSave");
                        }
                        else{
                            remove_redflag("editDescription");
                            enable_button("btnSave");
                        }
                    });

                    $("#editIPAddr").on("keyup change",function(){
                        process_ip($(this).attr("id"), "btnSave");
                    });

                    $("#editMacAddr").on("keyup change",function(){
                        process_mac($(this).attr("id"), "btnSave");
                    });

                    disable_button("btnApply");
                    disable_button("Refresh");
                    disable_button("btnReboot");

                    var save = $('<input/>', {
                        value: 'Save',
                        type: 'button',
                        id: 'btnSave',
                        class: 'cta-button',
                        click: function () {
                            var descriptionClass = $("#editDescription").hasClass("yes_redflag");
                            var ipAddrClass = $("#editIPAddr").hasClass("yes_redflag");
                            var macAddrClass = $("#editMacAddr").hasClass("yes_redflag");

                            if (descriptionClass || ipAddrClass || macAddrClass) {
                                disable_button("btnSave");
                                return false;
                            } else {
                                var par = $($(this).parent()).parent();
                                var row = par.find("input[type=text]");
                                description = row[0].value;
                                ipAddr = row[1].value;
                                macAddr = row[2].value;
                                var html = "";
                                html += "<td>" + description + "</td>";
                                html += "<td>" + hostname + "</td>";
                                html += "<td>" + ipAddr + "</td>";
                                html += "<td>" + macAddr + "</td>";
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
                                var par = $($(this).parent()).parent();
                                var html = "";
                                html += "<td>" + description + "</td>";
                                html += "<td>" + hostname + "</td>";
                                html += "<td>" + ipAddr + "</td>";
                                html += "<td>" + macAddr + "</td>";
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