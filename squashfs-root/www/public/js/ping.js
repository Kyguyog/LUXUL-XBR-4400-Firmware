$(document).ready(function(){
    displayLeftNav();
    var ipAddr = '';

    $("#ipAddr").on("keyup change",function(){
        process_ip($(this).attr("id"), "btnStart");
        ipAddr = $("#ipAddr").val();
    });

    $("#btnStart").click(function(){
        $("#waitMsg").show();
        $("#results").html("");

        setTimeout(function(){
            window.location = "/ping/progress/"+ipAddr;
        }, 1000);

    });
});