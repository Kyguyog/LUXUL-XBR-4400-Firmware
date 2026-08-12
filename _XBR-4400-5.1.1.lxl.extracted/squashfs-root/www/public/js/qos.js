$(document).ready(function(){
    displayLeftNav();
    displayHelpMessages();

    $("#qosServiceStatusOptions").on("keyup change",function(){
        if ($("#qosServiceStatusOptions").val() == '1') {
            if (confirm("QoS is incompatible with WAN Acceleration.  Enabling QoS will disable WAN Acceleration, do you wish to continue?") == true) {
                $("#qosServiceStatusOptions").val('1');
            } else {
                $("#qosServiceStatusOptions").val('0');
            }
        }
    });

    addRules();

    $("#qosDownloadSpeed, #qosUploadSpeed").on("keyup change",function(){
        process_speed($(this).attr("id"), "btnSave");
    });

    $("#sourceHost").on("keyup change",function(){
        process_source_host($(this).attr("id"), "add");
    });

    $("#ports").on("keyup change",function(){
        if($("#ports").val().indexOf(",") >= 0) {
            process_port_comma($(this).attr("id"), "add");
        } else if ($("#ports").val() == 'All') {
            remove_redflag("ports");
            enable_button("add");
        } else if ($("#ports").val() == '') {
            apply_redflag("ports");
            disable_button("add");
        } else {
            validatePort($(this).attr("id"), "add");
        }
    });

    modifyRow();
    sortTable();
    deleteRow();

    save();
    cancel();

    function addRules() {
        $("#add").click(function(){
            var sourceHostClass = $("#sourceHost").hasClass("yes_redflag");
            var portClass = $("#ports").hasClass("yes_redflag");

            if (sourceHostClass || portClass) {
                disable_button("add");
                return false;
            } else {
                addQos();

                $("#serviceLevelOptions").val("Normal");
                $("#sourceHost").val("");
                $("#protocalOptions").val("all");
                $("#ports").val("");

                process_source_host("sourceHost", "add");
                process_port_comma("ports", "add");
            }
        });
    }

    function modifyRow() {
        $('td[id^=btnModify]').each(function(){
            var buttons = getDelete();
            $(this).append(buttons);
        });
    }

    function deleteRow() {
        $('input[id^=btnDelete]').each(function(){
            $(this).click(function(){
                var index = $(this).parent().attr('id').substr(9);
                window.location = "/qos/deleteQosRules/"+index;
            });
        });
    }

    function save() {
        $("#btnSave").click(function(){
            var qosServiceStatus =  $("#qosServiceStatusOptions").val();
            var calcualteOverheadStatus =  $("#calculateOverheadOptions").val();
            var downloadSpeed = $("#qosDownloadSpeed").val();
            var uploadSpeed = $("#qosUploadSpeed").val();

            var downloadSpeedClass = $("#qosDownloadSpeed").hasClass("yes_redflag");
            var uploadSpeedClass = $("#qosUploadSpeed").hasClass("yes_redflag");

            if (downloadSpeedClass || uploadSpeedClass) {
                disable_button("btnSave");
                return false;
            } else {
                var data = [];

                data.push(qosServiceStatus);
                data.push(calcualteOverheadStatus);
                data.push(downloadSpeed);
                data.push(uploadSpeed);

                $("#addTo tr.dataInput").each(function () {
                    var row = [];
                    $(this).find("td:eq(0), td:eq(1), td:eq(2), td:eq(3)").each(function () {
                        if (this.innerHTML.indexOf('/') >= 0) {
                            var srcHostVal= this.innerHTML.replace('/', '=');
                            this.innerHTML = srcHostVal;
                        }

                        if (this.innerHTML.indexOf(',') >= 0) {
                            var portVal= this.innerHTML.replace(/,/g, '=');
                            this.innerHTML = portVal;
                        }

                        row.push(this.innerHTML);
                    });
                    data.push("&");
                    data.push(row);
                });
                window.location = "/qos/save/"+encodeURI(data);
            }
        });
    }

    function sortTable(){
        var rows = $('#addTo tbody  tr').get();
        rows.sort(function(a, b) {
            var A = $(a).children('td').eq(0).attr('id');
            var B = $(b).children('td').eq(0).attr('id');

            if(A < B) {
                return -1;
            }

            if(A > B) {
                return 1;
            }

            return 0;

        });
        $.each(rows, function(index, row) {
            $('#addTo').children('tbody').append(row);
        });
    }

    function addQos() {
        var inputTxt = $("#addSSID tr td");
        var input = inputTxt.find("input[type=text]");
        var sel = inputTxt.find("select");
        var serviceLevel = sel[0].value;
        var protocol = sel[1].value;

        if (protocol == 'all') {
            protocol = 'All';
        } else if (protocol == 'tcp'){
            protocol = 'TCP';
        } else {
            protocol = 'UDP';
        }

        var sourceHost = input[0].value;
        var ports = input[1].value;

        addRow(serviceLevel, sourceHost, protocol, ports);
        sortTable();
    }

    function addRow(serviceLevel, sourceHost, protocol, ports) {
        var idName = '3';
        if (serviceLevel == "Priority") {
            idName = "0";
        } else if (serviceLevel == "Express") {
            idName = "1";
        } else if (serviceLevel == "Normal") {
            idName = "2";
        }

        $("#addTo").append("<tr class='dataInput' style='text-align:center;'>" +
            "<td style='width: 50px; text-align: center' id='"+idName+"'>" + serviceLevel + "</td>" +
            "<td>" + sourceHost + "</td>>" +
            "<td>" + protocol + "</td>" +
            "<td>" + ports + "</td>" +
            "<td></td>" +
            "</tr>");
        var table = $("#addTo tr:last td:last");
        var del = getDelete();

        table.append(del);
    }

    function getDelete(){
        return $('<input/>',
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
    }

    function displayHelpMessages() {
        $("#qosServiceStatusOptions").focus(function(){
            qosServiceHelpMessage();
        });

        $("#calculateOverheadOptions").focus(function(){
            overheadHelpMessage();
        });

        $("#qosDownloadSpeed").focus(function(){
            downloadSpeedHelpMessage();
        });

        $("#qosUploadSpeed").focus(function(){
            uploadSpeedHelpMessage();
        });

        $("#qos_service_status_options_help, #qosServiceStatusOptions").click(function(){
            qosServiceHelpMessage();
        });

        $("#calculate_overhead_options_help, #calculateOverheadOptions").click(function(){
            overheadHelpMessage();
        });

        $("#qos_download_speed_help, #qosDownloadSpeed").click(function(){
            downloadSpeedHelpMessage();
        });

        $("#qos_upload_speed_help, #qosUploadSpeed").click(function(){
            uploadSpeedHelpMessage();
        });

        $("#qos_rules_help").click(function(){
            qosRulesHelpMessage();
        });
    }

});