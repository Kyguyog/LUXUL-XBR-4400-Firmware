$(document).ready(function(){
    displayLeftNav();

    $("#routes_help").click(function(){
        routesHelpMessage();
    });

    $("#add").click(function(){
        var descriptionClass = $("#addDescription").hasClass("yes_redflag");
        var destinationIpClass = $("#addDestinationIP").hasClass("yes_redflag");
        var netmaskClass = $("#addNetmask").hasClass("yes_redflag");
        var gatewayClass = $("#addGateway").hasClass("yes_redflag");
        var metricClass = $("#addMetric").hasClass("yes_redflag");

        if (descriptionClass || destinationIpClass || netmaskClass || gatewayClass || metricClass) {
            disable_button("add");
            return false;
        } else {
            addStaticRoutes();

            $("#addDescription").val("");
            $("#addInterfaceOptions").val("lan");
            $("#addDestinationIP").val("");
            $("#addNetmask").val("");
            $("#addGateway").val("");
            $("#addMetric").val("");

            process_ip("addDestinationIP", "add");
        }
    });

    validateDescriptionCell();
    validateInterfaceOptions();

    $("#addInterfaceOptions").trigger('change');

    $("#addDestinationIP").on("keyup change",function(){
        process_subnet($(this).attr("id"), "add");
    });

    $("#addDestinationIP").trigger('change');

    validateNetmask();
    validateGateway();
    validateMetric();

    modifyRow();
    deleteRow();

    applayChanges();
    cancel();
    refresh();

    function modifyRow() {
        $('td[id^=btnModify]').each(function(){
            var par = $(this).parent();
            var input = par.find("td");
            var description = input[0].textContent;
            var interfaceName = input[1].textContent;
            var destinationIP = input[2].textContent;
            var netmask = input[3].textContent;
            var gateway = input[4].textContent;
            var metric = input[5].textContent;
            var buttons = getEditDelete(description, interfaceName, destinationIP, netmask, gateway, metric);

            $(this).append(buttons[0]);
            $(this).append(buttons[1]);
        });
    }

    function deleteRow() {
        $('input[id^=btnDelete]').each(function(){
            $(this).click(function(){
                var index = $(this).parent().attr('id').substr(9);
                window.location = "/routing/delete/"+index;
            });
        });
    }

    function applayChanges() {
        $("#btnApply").click(function(){
            var tableData = [];
            $("#addTo tr.dataInput").each(function () {
                var row = [];
                $(this).find("td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5)").each(function () {
                    row.push(this.innerHTML);
                });
                tableData.push("&");
                tableData.push(row);
            });

            window.location = "/routing/save/"+tableData;

        });
    }

    function cancel() {
        $("#cancel").click(function(){
            $("#addDescription").val("");
            $("#addDestinationIP").val("");
            $("#addInterfaceOptions").val("lan");
            $("#addNetmask").val("");
            $("#addGateway").val("");
            $("#addMetric").val("");

            process_ip("addDestinationIP", "add");
        });
    }

    function validateInterfaceOptions() {
        $("#addInterfaceOptions").on("keyup change",function(){
            var inter = $("#addInterfaceOptions option:selected").val();
            if(inter == 'wan'||inter == 'wan2' || inter == 'wan3' || inter == 'wan4'){
                $("#addNetmask")[0].value = "";
                remove_redflag("addNetmask");
                $("#addDestinationIP").trigger('change');
                disable_button('addNetmask');
            }
            else{
                enable_button('addNetmask');
            }
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

    function validateNetmask() {
        $("#addNetmask").on("keyup change",function(){
            if($(this).val() != ""){
                process_netmask($(this).attr("id"), "add");
            }
            else{
                remove_redflag($(this).attr("id"));
                enable_button("add");
            }
        });
    }

    function validateGateway() {
        $("#addGateway").on("keyup change",function(){
            if($(this).val() != ""){
                process_subnet($(this).attr("id"), "add");
            }
            else{
                remove_redflag($(this).attr("id"));
                enable_button("add");
            }
        });
    }

    function validateMetric() {
        $("#addMetric").on("keyup change",function(){
            if($(this).val() != ""){
                process_metric($(this).attr("id"), "add");
            }
            else{
                remove_redflag($(this).attr("id"));
                enable_button("add");
            }
        });
    }

    function addStaticRoutes() {
        var inputTxt = $("#addSSID tr td");
        var input = inputTxt.find("input[type=text]");
        var description = input[0].value;
        var interfaceName = $("#addInterfaceOptions option:selected").val();
        var destinationIP = input[1].value;
        var netmask = input[2].value;
        var gateway = input[3].value;
        var metric = input[4].value;

        addRow(description, interfaceName, destinationIP, netmask, gateway, metric);
    }

    function addRow(description, interfaceName, destinationIP, netmask, gateway, metric) {
        $("#addTo").append("<tr class='dataInput' style='text-align:center;'>" +
            "<td>" + description + "</td>" +
            "<td>" + interfaceName + "</td>>" +
            "<td>" + destinationIP + "</td>" +
            "<td>" + netmask + "</td>" +
            "<td>" + gateway + "</td>" +
            "<td>" + metric + "</td>" +
            "<td></td>" +
            "</tr>");
        var table = $("#addTo tr:last td:last");
        var buttons = getEditDelete(description, interfaceName, destinationIP, netmask, gateway, metric);

        table.append(buttons[0]);
        table.append(buttons[1]);
    }

    function getEditDelete(description, interfaceName, destinationIP, netmask, gateway, metric){
        var add = $('<input/>',
            {
                value: 'Edit',
                type: 'button',
                class: 'cta-button',
                click: function () {
                    var par = $($(this).parent()).parent();
                    var input = par.find("td");
                    var select = $("#addInterfaceOptions")[0];

                    input[0].innerHTML = "<input id='editDescription' style='width:95%' type='text' maxlength='32' autocomplete='off' value='" + description + "'>";
                    input[1].innerHTML = "<select id='editInterface' style='width:95%'>" + select.innerHTML + "</select>";
                    input[2].innerHTML = "<input id='editDestinationIP' style='width:95%' type='text' autocomplete='off' value='" + destinationIP + "'>";
                    input[3].innerHTML = "<input id='editNetmask' style='width:95%' type='text' autocomplete='off' value='" + netmask + "'>";
                    input[4].innerHTML = "<input id='editGateway' style='width:95%' type='text' autocomplete='off' value='" + gateway + "'>";
                    input[5].innerHTML = "<input id='editMetric' style='width:85%' type='text' autocomplete='off' value='" + metric + "'>";
                    input[6].innerHTML = "";

                    $("#editInterface").val(interfaceName);

                    $("#editInterface").on("keyup change",function(){
                        var inter = $("#editInterface option:selected").val();
                        if(inter == 'wan'||inter == 'wan2' || inter == 'wan3' || inter == 'wan4'){
                            $("#editNetmask")[0].value = "";
                            remove_redflag("editNetmask");
                            $("#editDestinationIP").trigger('change');
                            disable_button('editNetmask');
                        }
                        else{
                            enable_button('editNetmask');
                        }
                    });

                    $("#editInterface").trigger("change");

                    $("#editDescription").on("keyup change",function(){
                        if($("#editDescription").val() != ""){
                            checkDescriptionCell("editDescription", "btnSave");
                        }
                        else{
                            remove_redflag("editDescription");
                            enable_button("btnSave");
                        }
                    });

                    $("#editDestinationIP").on("keyup change",function(){
                        process_subnet($(this).attr("id"), "btnSave");
                    });

                    $("#editNetmask").on("keyup change",function(){
                        if($(this).val() != ""){
                            process_netmask($(this).attr("id"), "btnSave");
                        }
                        else{
                            remove_redflag($(this).attr("id"));
                            enable_button("btnSave");
                        }
                    });

                    $("#editGateway").on("keyup change",function(){
                        if($(this).val() != ""){
                            process_subnet($(this).attr("id"), "btnSave");
                        }
                        else{
                            remove_redflag($(this).attr("id"));
                            enable_button("btnSave");
                        }
                    });

                    $("#editMetric").on("keyup change",function(){
                        if($(this).val() != ""){
                            process_metric($(this).attr("id"), "btnSave");
                        }
                        else{
                            remove_redflag($(this).attr("id"));
                            enable_button("btnSave");
                        }
                    });

                    disable_button("btnApply");
                    disable_button("Refresh");
                    disable_button("btnReboot");

                    var save = $('<input/>',
                        {
                            value: 'Save',
                            type: 'button',
                            id: 'btnSave',
                            class: 'cta-button',
                            click: function () {
                                var descriptionClass = $("#editDescription").hasClass("yes_redflag");
                                var destinationIpClass = $("#editDestinationIP").hasClass("yes_redflag");
                                var netmaskClass = $("#editNetmask").hasClass("yes_redflag");
                                var gatewayClass = $("#editGateway").hasClass("yes_redflag");
                                var metricClass = $("#editMetric").hasClass("yes_redflag");

                                if (descriptionClass || destinationIpClass || netmaskClass || gatewayClass || metricClass) {
                                    disable_button("btnSave");
                                    return false;
                                } else {
                                    var par = $($(this).parent()).parent();
                                    var row = par.find("input[type=text]");
                                    description = row[0].value;
                                    interfaceName = $("#editInterface option:selected").val();
                                    destinationIP = row[1].value;
                                    netmask = row[2].value;
                                    gateway = row[3].value;
                                    metric = row[4].value;
                                    var html = "";
                                    html += "<td>" + description + "</td>";
                                    html += "<td>" + interfaceName + "</td>";
                                    html += "<td>" + destinationIP + "</td>";
                                    html += "<td>" + netmask + "</td>";
                                    html += "<td>" + gateway + "</td>";
                                    html += "<td>" + metric + "</td>";
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
                                html += "<td>" + interfaceName + "</td>";
                                html += "<td>" + destinationIP + "</td>";
                                html += "<td>" + netmask + "</td>";
                                html += "<td>" + gateway + "</td>";
                                html += "<td>" + metric + "</td>";
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