$(document).ready(function () {
    displayLeftNav();

    selectConnectedClients();
    $("#connectedClientsOptions").on("keyup change", function () {
        selectConnectedClients();
    });

    function selectConnectedClients() {
        if ($("#connectedClientsOptions").val() == 'dhcp') {
            $("#dhcpClientsDiv").show();
            $("#allClientsDiv").hide();

            $('#dhcpClients').dataTable( {
                columnDefs: [
                    { type: 'ip-address', targets: 1 }
                ],
                "bDestroy": true
            } );

            $("select[name=dhcpClients_length]").val('100').trigger('change');

            $("#dhcpClients_filter").hide();
            $("#dhcpClients_length").hide();
            $("#dhcpClients_info").hide();
            $("#dhcpClients_paginate").hide();

            $('#dhcpIPAddress').trigger('click');

        } else {
            $("#allClientsDiv").show();
            $("#dhcpClientsDiv").hide();

            $('#allClients').dataTable( {
                columnDefs: [
                    { type: 'ip-address', targets: 1 }
                ],
                "bDestroy": true
            } );

            $("select[name=allClients_length]").val('100').trigger('change');

            $("#allClients_filter").hide();
            $("#allClients_length").hide();
            $("#allClients_info").hide();
            $("#allClients_paginate").hide();

            $('#allIPAddress').trigger('click');
        }
    }



});