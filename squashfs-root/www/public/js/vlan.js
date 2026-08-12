$(document).ready(function(){
    var table = document.getElementById('create-vlan-table');
    var rowCount = table.rows.length;

    if (rowCount > 16) {
        disable_button('btnAdd');
    }

    displayLeftNav();
    displayHelpMessages();

    selectVlanStatus();
    $("#vlanStatusOptions").on("keyup change",function(){
        if ($("#vlanStatusOptions").val() == '0') {
            if (confirm("Disabling VLANs may make your network inaccessible. Are you sure you want to disable VLANs?") == true) {
                $("#vlanEnabledDiv").hide();
                enable_button("btnSave");
            }
        } else {
            alert("Configure DHCP Server and Multi-WAN before Enabling VLANs.")
            selectVlanStatus();
        }
    });

    $("#addVlan").on("keyup change",function(){
        process_vlan($(this).attr("id"),"btnAddVlan",false);
    });

    $("#editVlan").on("keyup change",function(){
        process_vlan($(this).attr("id"),"btnEditVlan",true);
    });

    $("#RemoveVlan").on("keyup change",function(){
        process_vlan($(this).attr("id"),"btnRemoveVlan",false);
    });

    $('input[class^=pvidPort]').on("keyup change",function(){
        if (valid_pvid_port($(this).val())) {
            remove_redflag($(this).attr("id"));
            enable_button("btnSave");
        } else {
            apply_redflag($(this).attr("id"));
            disable_button("btnSave");
        }
    });

    $("#btnAddVlan").click(function(){
        if (rowCount > 16) {
            alert("You cannot add more VLAN.");
            location.reload();
        } else{
            window.location = "/vlanconfig/display/"+$("#addVlan").val();
        }
    });

    $("#btnEditVlan").click(function(){
        var editVlanId = $("#editVlan").val();
        var vlanIdArray = [];

        $("#create-vlan-table tr #vlanId").each(function() {
            vlanIdArray.push($(this).text());
        });

        if(jQuery.inArray(editVlanId, vlanIdArray) !== -1) {
            window.location = "/vlanconfig/display/"+editVlanId;
        } else {
            alert("VLAN ID " + editVlanId + " not found!");
            location.reload();
        }
    });

    $("#btnRemoveVlan").click(function(){
        var removeVlanId = $("#RemoveVlan").val();
        var vlanIdArray = [];

        $("#create-vlan-table tr #vlanId").each(function() {
            vlanIdArray.push($(this).text());
        });

        if(jQuery.inArray(removeVlanId, vlanIdArray) !== -1) {
            if (confirm("Are you sure you want to delete this VLAN ID?") == true) {
                window.location = "/vlan/delete/"+removeVlanId;
            } else {
                location.reload();
            }

        } else {
            alert("VLAN ID " + removeVlanId + " not found!");
            location.reload();
        }
    });

    $("#btnSave").click(function(){
        var vlanIdArray = [];

        $("#create-vlan-table tr #vlanId").each(function() {
            vlanIdArray.push($(this).text());
        });

        $(".pvidPort").each(function() {
            if(jQuery.inArray($(this).val(), vlanIdArray) !== -1) {
                remove_redflag($(this).attr("id"));
                enable_button("btnSave");
                return true;
            } else {
                alert("Please enter a PVID/VLAN number that is assigned to this port!");
                apply_redflag($(this).attr("id"));
                disable_button("btnSave");
                return false;
            }
        });
    });

    var cookieValue=readCookie('test');
    if(cookieValue==null){
        createCookie("test","5",1);
        alert('WARNING: You must have a VLAN switch setup for this to work! Otherwise, you will be denied all access to this device');
    }

    function selectVlanStatus() {
        if ($("#vlanStatusOptions").val() != '0') {
            $("#vlanEnabledDiv").show();
        } else {
            $("#vlanEnabledDiv").hide();
            enable_button("btnSave");
        }
    }

    function displayHelpMessages() {
        $("#vlan_status_options_help").click(function(){
            vlanStatusHelpMessage();
        });

        $("#add_vlan_help").click(function(){
            addVlanHelpMessage();
        });

        $("#edit_vlan_help").click(function(){
            editVlanHelpMessage();
        });

        $("#remove_vlan_help").click(function(){
            removeVlanHelpMessage();
        });

        $("#port_vlan_id_help").click(function(){
            portVlanIdHelpMessage();
        });
    }

});