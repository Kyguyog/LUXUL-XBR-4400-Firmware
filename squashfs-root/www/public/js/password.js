$(document).ready(function () {
    displayLeftNav();

    checkNewPassword();
    confirmNewPassword();
    savePassword();
    cancel();

    function checkNewPassword() {
        $("#new-password").on("keyup change", function () {
            var id = $(this).attr("id");
            var buttonId = "btnSave";

            if (!valid_admin_password($("#" + id).val())) {
                apply_redflag(id);
                disable_button(buttonId);
            } else {
                remove_redflag(id);
                enable_button(buttonId);
            }
        });
    }

    function confirmNewPassword() {
        $("#confirmation").on("keyup change", function () {
            var password = $("#new-password").val();

            if ($("#btnSave").prop("disabled") == true) {
                apply_redflag($(this).attr("id"));
                disable_button("btnSave");
            } else {
                $("#confirmation").on("keyup change", function () {
                    var confirmPwd = $("#confirmation").val();
                    if (confirmPwd != password) {
                        apply_redflag($(this).attr("id"));
                        disable_button("btnSave");
                    } else {
                        remove_redflag($(this).attr("id"));
                        enable_button("btnSave");

                    }
                });
            }
        });
    }

    function savePassword() {
        $('#btnSave').click(function () {
            if ($("#confirmation").val() != $("#new-password").val()) {
                alert("Password don't match!");
                apply_redflag($(this).attr("id"));
                disable_button("btnSave");
            }
        });
    }

});