$(document).ready(function(){
    displayLeftNav();
    displayHelpMessage();

    selectRouterLimitsSystem();
    $("#routerLimitsOptions").on("keyup change", function () {
        if ($("#routerLimitsOptions").val() == '1') {
            swal({
                    title: "",
                    text: "You have elected to enable and use a third-party software feature (\"Third Party Software\") " +
                    "for which Luxul offers no warranty, expressed or implied. " +
                    "While this Third Party Software has been tested for compatibility with your Luxul router, " +
                    "it is being offered on an \"as is\" basis and all operational scenarios cannot be guaranteed.",
                    type: "",
                    showCancelButton: true,
                    confirmButtonColor: "#659520",
                    confirmButtonText: "Accept",
                    cancelButtonText: "Deny",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },

                function(isConfirm){
                    if (isConfirm) {
                        swal("", "", "");
                        $("#routerLimitsOptions").val("1");
                    } else {
                        swal("", "", "");
                        $("#routerLimitsOptions").val("0");
                    }
                });


        } else {
            $("#routerLimitsEnabledDiv").hide();
        }
    });

    function selectRouterLimitsSystem() {
        if ($("#routerLimitsOptions").val() == '1') {
            $("#routerLimitsEnabledDiv").show();

            $("#activateRouterLimits").click(function (){
                var deviceId = $.trim($("#deviceId").html());
                window.open("https://rlgo.co/launchluxul?pc="+deviceId+"", '_blank');
                //window.open("https://beta.routerlimits.com/launch?pc="+deviceId+"", '_blank');

            })

            $("#manageRouterLimits").click(function (){
                window.open("https://rlgo.co/manageluxul", '_blank');
                //window.open("https://beta.routerlimits.com/login", '_blank');

            })

        } else {
            $("#routerLimitsEnabledDiv").hide();
        }
    }

    function displayHelpMessage() {
        $("#routerLimitsOptions").focus(function(){
            routerLimitsSystemHelpMessage();
        });

        $("#router_limits_options_help").click(function(){
            routerLimitsSystemHelpMessage();
        });

        $("#router_limits_status_help").click(function(){
            routerLimitsStatusHelpMessage();
        });

        $("#router_limits_device_id_help").click(function(){
            routerLimitsDeviceIdHelpMessage();
        });
    }
});