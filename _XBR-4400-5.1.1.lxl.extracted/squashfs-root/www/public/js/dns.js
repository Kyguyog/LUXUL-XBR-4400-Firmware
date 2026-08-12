$(document).ready(function () {
    displayLeftNav();
    displayHelpMessages();
    selectDNSStatus();

    $("#dnsStatus").on("keyup change", function () {
        selectDNSStatus();
    });

    cancel();

    function selectDNSStatus() {
        if ($("#dnsStatus").val() == '1') {
            $("#dnsEnabledDiv").show();

            checkDnsInterval();
            checkDnsUpdateInterval();
        } else {
            $("#dnsEnabledDiv").hide();
        }
    }

    function checkDnsInterval() {
        $("#dnsInterval").on("keyup change", function () {
            validate_num_9999($(this).attr("id"),"btnSave");
        });
    }

    function checkDnsUpdateInterval() {
        $("#dnsUpdateInterval").on("keyup change", function () {
            validate_num_9999($(this).attr("id"),"btnSave");
        });
    }

    function displayHelpMessages() {
        $("#dsn_status_help").click(function(){
            dnsStatusHelpMessage();
        });

        $("#dnsStatus").focus(function(){
            dnsStatusHelpMessage();
        });

        $("#service_provider_help").click(function(){
            serviceProviderHelpMessage();
        });

        $("#serviceProvider").focus(function(){
            serviceProviderHelpMessage();
        });

        $("#dns_hostname_help").click(function(){
            dnsHostNameHelpMessage();
        });

        $("#dnsHostname").focus(function(){
            dnsHostNameHelpMessage();
        });

        $("#dns_username_help").click(function(){
            dnsUserNameHelpMessage();
        });

        $("#dnsUsername").focus(function(){
            dnsUserNameHelpMessage();
        });

        $("#dns_password_help").click(function(){
            dnsPasswordHelpMessage();
        });

        $("#dnsPassword").focus(function(){
            dnsPasswordHelpMessage();
        });

        $("#dns_interval_help").click(function(){
            dnsIntervalHelpMessage();
        });

        $("#dnsInterval").focus(function(){
            dnsIntervalHelpMessage();
        });

        $("#dns_update_interval_help").click(function(){
            dnsUpdateIntervalHelpMessage();
        });

        $("#dnsUpdateInterval").focus(function(){
            dnsUpdateIntervalHelpMessage();
        });
    }

});