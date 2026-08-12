$(document).ready(function(){
    displayLeftNav();

    add();
    cancel();

    validateVpnUserName("addUsername", "add");
    $("#addUsername").on("keyup change",function(){
        validateVpnUserName($(this).attr("id"), "add");
    });

    validateVpnPassword("addPassword", "add");
    $("#addPassword").on("keyup change",function(){
        validateVpnPassword($(this).attr("id"), "add");
    });

    modify();
    deleteRow();

    applayChanges();
    refresh();

    function add() {
        $("#add").click(function(){

            var addUsernameClass = $("#addUsername").hasClass("yes_redflag");
            var addPasswordClass = $("#addPassword").hasClass("yes_redflag");

            if (addUsernameClass || addPasswordClass ) {
                disable_button("add");
                return false;
            } else {


                addVpnUser();
            }

            $("#addUsername").val('');
            $("#addPassword").val('');

            apply_redflag("addUsername");
            apply_redflag("addPassword");

            disable_button("add");
        });
    }

    function addVpnUser() {
        var row = [];

        row.push($("#addUsername").val());
        row.push($("#addPassword").val());

        window.location = "/vpnuser/save/"+row;
    }

    function modify() {
        $('td[id^=btnModify]').each(function(){
            var par = $(this).parent();
            var input = par.find("td");
            var username = input[0].textContent;
            var password = par.find("td input").val();

            var buttons = getEditDelete(username, password);
            $(this).append(buttons[0]);
            $(this).append(buttons[1]);
        });
    }

    function deleteRow() {
        $('input[id^=btnDelete]').each(function(){
            $(this).click(function(){
                var index = $(this).parent().attr('id').substr(9);
                window.location = "/vpnuser/delete/"+index;
            });
        });
    }

    function applayChanges() {
        $("#btnApply").click(function(){
            window.location = "/vpnuser/saveVpnUserInfoByMode/";
        });
    }

    function getEditDelete(username, password){
        var add = $('<input/>',
            {
                value: 'Edit',
                type: 'button',
                class: 'cta-button',
                click: function () {
                    var par = $($(this).parent()).parent();
                    var input = par.find("td");
                    //var select = $("#addInterfaceOptions")[0];

                    input[0].innerHTML = "<input id='editUsername' type='text' style='width: 110px;' value='" + username + "'>";
                    input[1].innerHTML = "<input id='editPassword' type='text' style='width: 300px;' value='" + password + "'>";
                    input[2].innerHTML = "";

                    $("#editUsername").on("keyup change",function(){
                        validateVpnUserName($(this).attr("id"), "btnSave");
                    });

                    $("#editPassword").on("keyup change",function(){
                        validateVpnPassword($(this).attr("id"), "btnSave");
                    });

                    disable_button("btnApply");
                    disable_button("Refresh");
                    disable_button("btnReboot");

                    var save = $('<input/>',
                        {
                            value: 'Save',
                            type: 'button',
                            id: 'btnSave',
                            class: 'cta-button',
                            click: function () {

                                var editUsernameClass = $("#editUsername").hasClass("yes_redflag");
                                var editPasswordClass = $("#editPassword").hasClass("yes_redflag");

                                if (editUsernameClass || editPasswordClass ) {
                                    disable_button("btnSave");
                                    return false;
                                } else {
                                    var row = [];
                                    var index = $(this).parent().attr('id').substr(9);

                                    row.push($("#editUsername").val());
                                    row.push($("#editPassword").val());
                                    row.push(index);

                                    window.location = "/vpnuser/edit/"+row;
                                }
                            }
                        });

                    var cancel = $('<input/>',
                        {
                            value: 'Cancel',
                            type: 'button',
                            class: 'cta-button',
                            click: function () {
                                var par = $($(this).parent()).parent();
                                var bthId = $(this).parent().attr('id');
                                var html = "";

                                html += "<td>" + username + "</td>";
                                html += "<td><input type='hidden' value='"+password+"'>" + "*".repeat(password.length) + "</td>";
                                html += "<td id="+bthId+"></td>";
                                par.html(html);
                                var lst = par.find("td:last");
                                lst.append(add);
                                lst.append(remove);

                                enable_button("btnApply");
                                enable_button("Refresh");
                                enable_button("btnReboot");
                            }
                        });

                    var last = par.find("td:last");
                    last.append(save[0]);
                    last.append(cancel[0]);
                }
            });

        var remove = $('<input/>',
            {
                value: 'Delete',
                type: 'button',
                class: 'cta-button',
                id : 'btnDelete',
                click: function () {
                    var par = $($(this).parent()).parent();
                    par.remove();
                }
            });
        return [add,remove];
    }

});