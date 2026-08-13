$(document).ready(function () {
    var ipAddr = $("#lanIPAddr").val();
    var prePage = $("#prePage").val();

    displaySpin("rebootingIndicator", 50, "http://" + ipAddr + "/" + prePage + "/display");
});