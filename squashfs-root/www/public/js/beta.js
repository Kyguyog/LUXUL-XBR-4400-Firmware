$(document).ready(function () {
    displayLeftNav();

    $("#portMonitoringOptions").change(function () {
        var portMonitoringVal = $(this).val();
        window.location = "/beta/save/" + encodeURIComponent(portMonitoringVal);
    });

    $("#wanDelay").on("keyup change",function(){
        validateWanDelay("wanDelay", "btnSave");
    });

    selectWanVlanTagOptions();
    $("#wanVlanTagOptions").on("keyup change", function () {
        selectWanVlanTagOptions();
    });

    $("#blockSelfAssignedIpOptions").change(function () {
        var blockSelfAssignedIpVal = $(this).val();
        window.location = "/beta/saveBlockIp/" + encodeURIComponent(blockSelfAssignedIpVal);
    });

    function selectWanVlanTagOptions() {
        if ($("#wanVlanTagOptions").val() == 'enabled') {
            $("#vlanIdDiv").show();

            validateVlanId("vlanID","btnSaveWanVlanTag");
            $("#vlanID").on("keyup change",function(){
                validateVlanId($(this).attr("id"),"btnSaveWanVlanTag");
            });

        } else  {
            $("#vlanIdDiv").hide();
        }
    }
});