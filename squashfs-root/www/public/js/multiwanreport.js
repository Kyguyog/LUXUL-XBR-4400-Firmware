$(document).ready(function(){
    displayLeftNav();

    selectMultiWanReport();
    $("#multiWanReportOptions").on("keyup change",function(){
        selectMultiWanReport();
    });

    function selectMultiWanReport() {
        if ($("#multiWanReportOptions").val() == 'interface') {
            $("#multiWanReportInterfaceDiv").show();

            $("#multiWanReportDefaultDiv").hide();
            $("#multiWanReportFullDiv").hide();
            $("#multiWanReportPolicyDiv").hide();
            $("#multiWanReportRuleDiv").hide();

            multiWanInterfaceReportHelpMessage();
        } else if ($("#multiWanReportOptions").val() == 'policy') {
            $("#multiWanReportPolicyDiv").show();

            $("#multiWanReportDefaultDiv").hide();
            $("#multiWanReportFullDiv").hide();
            $("#multiWanReportInterfaceDiv").hide();
            $("#multiWanReportRuleDiv").hide();

            multiWanPolicyReportHelpMessage();
        } else {
            $("#multiWanReportDefaultDiv").show();

            $("#multiWanReportFullDiv").hide();
            $("#multiWanReportInterfaceDiv").hide();
            $("#multiWanReportPolicyDiv").hide();
            $("#multiWanReportRuleDiv").hide();

            multiWanReportsHelpMessage();
        }
    }
});








