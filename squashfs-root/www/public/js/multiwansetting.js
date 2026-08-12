$(document).ready(function(){
    displayLeftNav();
    displayHelpMessages();

    cancel();
    $("#multiWanStatus").on("keyup change",function(){
        if ($(this).val() == 0) {
            $("#multiWanEnabledDiv").hide();
        } else {
            if (confirm("Multi-WAN is incompatible with WAN Acceleration.  Enabling Multi-WAN will disable WAN Acceleration. " +
                    "Once Enabled you must finish the Set-Up Wizard or Factory Reset the Router. Do you wish to continue?") == true) {
                $("#multiWanStatus").val('1');
            } else {
                $("#multiWanStatus").val('0');
            }

            $("#multiWanEnabledDiv").show();
        }
    });

    $('.cta-button.edit, .cta-button.add').click(function () {
        var wanNum = $(this).attr("id").substr(3).toLowerCase();
        window.location = "/"+wanNum+"/display";
    });

    $('.cta-button.delete').click(function () {
        var wanNum = $(this).attr("id").substr(11).toLowerCase();
        window.location = "/multiwansetting/deleteWanInterface/"+wanNum;
    });

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

    function displayHelpMessages() {
        $("#multiWanStatus").focus(function(){
            multiWanStatusHelpMessage();
        });

        $("#multi_wan_status_help").click(function(){
            multiWanStatusHelpMessage();
        });

        $("#multi_wan_help").click(function(){
            multiWanHelpMessage();
        });

        $("#multi_wan2_help").click(function(){
            multiWan2HelpMessage();
        });

        $("#multi_wan3_help").click(function(){
            multiWan3HelpMessage();
        });

        $("#multi_wan4_help").click(function(){
            multiWan4HelpMessage();
        });

        $("#multiWanPolicyOptions").focus(function(){
            multiWanDefaultPolicyHelpMessage();
        });

        $("#multi_wan_policy_options_help").click(function(){
            multiWanDefaultPolicyHelpMessage();
        });
    }

});








