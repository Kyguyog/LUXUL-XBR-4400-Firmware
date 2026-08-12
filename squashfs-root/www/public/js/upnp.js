$(document).ready(function(){
    displayLeftNav();

    save();
    cancel();

    function save() {
        $("#btnSave").click(function(){
            var upnpServiceStatus =  $("#upnpStatusOptions").val();
            var data = [];
            data.push(upnpServiceStatus);
            var vlans = [];
            $("input.check").each(function () {
                if(this.checked)
                    vlans.push($(this).attr("id"));
            });
            data.push(vlans.join(";"));

            window.location = "/upnp/save/"+data;
        });
    }
});