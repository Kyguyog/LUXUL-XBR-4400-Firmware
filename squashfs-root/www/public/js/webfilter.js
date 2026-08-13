$(document).ready(function(){
    displayLeftNav();
    displayHelpMessages();

    if($("#check3").is(':checked')){
        $("#alternateDNSDiv").show();
    }

    $("#primaryDns").on("keyup change",function(){
        validatePrimary();
    });

    $("#secondaryDns").on("keyup change",function(){
        validateSecondary();
    });

    selectWebFilteringStatus();
    displayAlternateDNSDiv();

    $("#webFilteringOptions").on("keyup change",function(){
        selectWebFilteringStatus();
    });

    cancel();

    function displayHelpMessages() {
        $("#check1, #open_dns_home_help").click(function(){
            openDNSHomeHelpMessage();
        });

        $("#check2, #open_dns_family_help").click(function(){
            openDNSFamilyHelpMessage();
        });

        $("#check3, #alternate_dns_help").click(function(){
            alternateDNSHelpMessage();
        });

        $("#primary_dns_help").click(function(){
            priDNSHelpMessage();
        });

        $("#secondary_dns_help").click(function(){
            secondaryDNSHelpMessage();
        });
    }

    function selectWebFilteringStatus() {
        if ($("#webFilteringOptions").val() == 'enabled') {
            $("#webFilteringEnabledDiv").show();
            checkOneOnly();
            oneChecked();
            displayAlternateDNSDiv();
        } else {
            $("#webFilteringEnabledDiv").hide();
            enable_button("btnApply");
        }
    }

    function checkOneOnly() {
        $('input.unique').each(function() {
            $(this).on('touchstart click', function() {
                $('input.unique').not(this).removeAttr('checked');
            });
        });
    }

    function displayAlternateDNSDiv() {
        $('#check3').click(function () {
            $("#alternateDNSDiv").toggle(this.checked);
            oneChecked();
            validatePrimary();
        });

        $('#check1, #check2').click(function () {
            $("#alternateDNSDiv").hide();
            oneChecked();
        });
    }

    function oneChecked(){
        var checked = false;
        $('input.unique').each(function(){
            if(this.checked){
                checked = true;
            }
        });
        checked ? enable_button("btnApply") : disable_button("btnApply");
    }

    function validatePrimary(){
        process_dns($("#primaryDns").attr("id"), "btnApply");
    }

    function validateSecondary(){
        if($("#secondaryDns").val() != "")
            process_dns($("#secondaryDns").attr("id"), "btnApply");
        else{
            remove_redflag("secondaryDns");
            enable_button("btnApply");
        }
    }

});