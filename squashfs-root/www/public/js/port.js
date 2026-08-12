$(document).ready(function () {
    displayLeftNav();

    $("#wanBtn").click(function () {
        $("#wanPortInfoDiv").show();

        $("#lanPort1InfoDiv").hide();
        $("#lanPort2InfoDiv").hide();
        $("#lanPort3InfoDiv").hide();
        $("#lanPort4InfoDiv").hide();
    });

    $("#lanPort1Btn").click(function () {
        $("#lanPort1InfoDiv").show();

        $("#wanPortInfoDiv").hide();
        $("#lanPort2InfoDiv").hide();
        $("#lanPort3InfoDiv").hide();
        $("#lanPort4InfoDiv").hide();
    });

    $("#lanPort2Btn").click(function () {
        $("#lanPort2InfoDiv").show();

        $("#wanPortInfoDiv").hide();
        $("#lanPort1InfoDiv").hide();
        $("#lanPort3InfoDiv").hide();
        $("#lanPort4InfoDiv").hide();
    });

    $("#lanPort3Btn").click(function () {
        $("#lanPort3InfoDiv").show();

        $("#wanPortInfoDiv").hide();
        $("#lanPort1InfoDiv").hide();
        $("#lanPort2InfoDiv").hide();
        $("#lanPort4InfoDiv").hide();
    });

    $("#lanPort4Btn").click(function () {
        $("#lanPort4InfoDiv").show();

        $("#wanPortInfoDiv").hide();
        $("#lanPort1InfoDiv").hide();
        $("#lanPort2InfoDiv").hide();
        $("#lanPort3InfoDiv").hide();
    });

    refresh();

});