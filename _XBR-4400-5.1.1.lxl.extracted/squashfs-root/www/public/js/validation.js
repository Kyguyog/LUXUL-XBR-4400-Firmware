function process_ip(id, buttonId){
    if(!valid_ip_address($("#" + id).val())){
        apply_redflag(id);
        disable_button(buttonId);
        return false;
    } else {
        remove_redflag(id);
        enable_button(buttonId);
        return true;
    }
}

function process_static_ip(id, buttonId) {
    if(!valid_ip_255($("#" + id).val())){
        apply_redflag(id);
        disable_button(buttonId);
        return false;
    } else {
        remove_redflag(id);
        enable_button(buttonId);
        return true;
    }
}

function process_dns(id, buttonId){
    if(valid_ip_255($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
        return true;
    } else {
        apply_redflag(id);
        disable_button(buttonId);
        return false;
    }
}

function process_subnet(id, buttonId) {
    if(!valid_ip_255($("#" + id).val())){
        apply_redflag(id);
        disable_button(buttonId);
    } else {
        remove_redflag(id);
        enable_button(buttonId);
    }
}

function process_mac(id,buttonId){
    if(!valid_mac_address($("#" + id).val())){
        apply_redflag(id);
        disable_button(buttonId);
    } else {
        remove_redflag(id);
        enable_button(buttonId);
    }
}

function process_mtu(id,buttonId){
    if(!valid_mtu($("#" + id).val())){
        apply_redflag(id);
        disable_button(buttonId);
    } else {
        remove_redflag(id);
        enable_button(buttonId);
    }
}

function process_user(id,buttonId){
    if(!valid_user($("#" + id).val())){
        apply_redflag(id);
        disable_button(buttonId);
    } else {
        remove_redflag(id);
        enable_button(buttonId);
    }
}

function validatePppoeServiceName(id,buttonId) {
    if(valid_pppoe_service_name($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_ping(id,buttonId){
    if(!valid_ping($("#" + id).val())){
        apply_redflag(id);
        disable_button(buttonId);
    } else {
        remove_redflag(id);
        enable_button(buttonId);
    }
}

function process_vlan(id,buttonId, check1Included){
    if(valid_vlan($("#" + id).val()) || (check1Included && $("#" + id).val() == "1") || $("#" + id).val() == ""){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validateVlanId(id,buttonId) {
    if(valid_vlan($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_metric(id,buttonId){
    if(valid_metric($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_netmask(id,buttonId){
    if(valid_netmask($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function checkDescriptionCell(id,buttonId) {
    if(valid_description_cell($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_source_host(id,buttonId){
    if(valid_source_host($("#" + id).val()) || $("#" + id).val() == 'All'){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_port_comma(id, buttonId){
    $.each($("#" + id).val().split(','), function(index, value) {
        if(valid_wan_lan_port(value)){
            remove_redflag(id);
            enable_button(buttonId);
        } else {
            apply_redflag(id);
            disable_button(buttonId);
        }
    });
}

function validateIPAddrStart(id,buttonId) {
    if(valid_ip_addr_start($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function valid_ip_addr_start(value) {
    var ip_addr_start_regex = new RegExp(/^([1-9][0-9]?|1[0-9]{2}|2[0-4][0-9]|25[0-4])$/);
    return ip_addr_start_regex.test(value);
}

function validateIPAddrEnd(id,buttonId) {
    if(valid_ip_addr_end($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validateClassCDHCPStart(id,buttonId) {
    if(valid_class_c_dhcp_start($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validateClassCEnd(id,buttonId) {
    if(valid_class_c_dhcp_end($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validateClassBDhcp(id,buttonId) {
    if(valid_class_b_dhcp($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validateclassBIPAddrNum(id,buttonId) {
    if(valid_class_b_ip_addr_num($("#" + id).val())){
        if ($("#" + id).val() > 0 && $("#" + id).val() <= 65534) {
            remove_redflag(id);
            enable_button(buttonId);
        } else {
            apply_redflag(id);
            disable_button(buttonId);
        }

    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validateLeaseTime(id,buttonId) {
    if(valid_lease_time($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validatePresharedKey(id,buttonId) {
    if(valid_preshared_key($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validateVpnUserName(id,buttonId) {
    if(valid_vpn_user_name($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validateVpnPassword(id,buttonId) {
    if(valid_vpn_password($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_vlan_description(id,buttonId) {
    if(valid_vlan_description($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validatePort(id, buttonId) {
    var portVal = $("#" + id).val();

    if (portVal.length != 0) {
        if (portVal.split("-").length > 2) {
            apply_redflag(id);
            disable_button(buttonId);

        } else if (portVal.split("-").length == 2) {
            $.each($("#" + id).val().split('-'), function(index, value) {
                if(valid_wan_lan_port(value)){
                    remove_redflag(id);
                    enable_button(buttonId);
                } else {
                    apply_redflag(id);
                    disable_button(buttonId);
                }
            });

        } else {
            process_wan_lan_port(id, buttonId);
        }
    }
}

function process_wan_lan_port(id,buttonId) {
    if(valid_wan_lan_port($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function  process_port_colon(id,buttonId) {
    if ($("#" + id).val().split(':').length > 2) {
        apply_redflag(id);
        disable_button(buttonId);
    } else {
        $.each($("#" + id).val().split(':'), function(index, value) {
            if(valid_wan_lan_port(value)){
                remove_redflag(id);
                enable_button(buttonId);
            } else {
                apply_redflag(id);
                disable_button(buttonId);
            }
        });
    }
}

function process_wan_name(id,buttonId){
    if(valid_wan_name_address($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_member_weight(id, buttonId) {
    if (valid_member_weight(($("#" + id).val()))) {
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_member_priority(id, buttonId) {
    if (valid_member_priority(($("#" + id).val()))) {
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_rule_name(id, buttonId) {
    if (valid_rule_name(($("#" + id).val()))) {
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function validateWanDelay(id,buttonId) {
    if(valid_wan_delay($("#" + id).val())){
        remove_redflag(id);
        enable_button(buttonId);
    } else {
        apply_redflag(id);
        disable_button(buttonId);
    }
}

function process_speed(id,buttonId) {
    if(!valid_speed($("#" + id).val())){
        apply_redflag(id);
        disable_button(buttonId);
    } else {
        remove_redflag(id);
        enable_button(buttonId);
    }
}

function validate_num_9999(id, buttonId) {
    if(!valid_num_9999($("#" + id).val())){
        apply_redflag(id);
        disable_button(buttonId);
        return false;
    } else {
        remove_redflag(id);
        enable_button(buttonId);
        return true;
    }
}

function valid_num_9999(value) {
    var dns_ip_regex = new RegExp(/^([1-9]|[1-9][0-9]|[1-9][0-9][0-9]|[1-9][0-9][0-9][0-9])$/);
    return dns_ip_regex.test(value);
}

function valid_speed(value) {
    var speed_regex = new RegExp(/^[1-9]\d*$/);
    return speed_regex.test(value);
}

function valid_pvid_port(value) {
    var pvid_port_regex = new RegExp(/^([1-9]|[0-9]{2,3}|[0-3][0-9]{3}|40[0-7][0-9]|4080)$/);
    return pvid_port_regex.test(value);
}

function valid_rule_name(value) {
    var rule_name_regex = new RegExp(/^[a-zA-Z0-9_]{1,15}$/);
    return rule_name_regex.test(value);
}

function valid_member_weight(value) {
    var member_weight_regex = new RegExp(/^[1-9]$/);
    return member_weight_regex.test(value);
}

function valid_member_priority(value) {
    var member_priority_regex = new RegExp(/^[1-9]$/);
    return member_priority_regex.test(value);
}

function valid_wan_name_address(value) {
    var name_regex = new RegExp(/^[a-zA-Z0-9]{0,15}$/);
    return name_regex.test(value);
}

function valid_source_host(value){
    var host_regex = new RegExp(/^((([0-9][0-9]?|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[0-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(\/([0-9]|[0-2][0-9]|3[0-2]))?|(([0-9][0-9]?|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){2}([0-9]|[0-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(\/([0-9]|[0-2][0-9]|3[0-2])))$/);
    return host_regex.test(value);
}

function valid_netmask(value){
    var netmask_regex = new RegExp(/^255.(([0-9]{1,2}|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){2}([0-9]{1,2}|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/);
    return netmask_regex.test(value);
}

function valid_metric(value){
    var metric_regex = new RegExp(/^([0-9]{1,2}|1[0-9]{2}|2[0-4][0-9]|25[0-4])$/);
    return metric_regex.test(value);
}

function valid_vlan(value){
    var vlan_regex = new RegExp(/^([2-9]|[0-9]{2,3}|[0-3][0-9]{3}|40[0-7][0-9]|4080)$/);
    return vlan_regex.test(value);
}

function valid_ping(value){
    var ip_regex = new RegExp(/^([0-9]{1,2})$/);
    return ip_regex.test(value);
}

function valid_description_cell(value) {
    var description_regex = new RegExp(/^[a-zA-Z0-9-_ ]{1,32}$/);
    return  description_regex.test(value);
}

function valid_user(value){
    var ip_regex = new RegExp(/^\S+/);
    return ip_regex.test(value);
}

function valid_pppoe_service_name(value) {
    var pppoe_service_name_regex = new RegExp(/^[a-zA-Z0-9-_ ]{1,32}$/);
    return  pppoe_service_name_regex.test(value);
}

function valid_mtu(value){
    var ip_regex = new RegExp(/^([0-9]{1,3}|1([0-4][0-9]{2})|1500)$/);
    return ip_regex.test(value);
}

function valid_mac_address(value){
    var ip_regex = new RegExp(/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/);
    return ip_regex.test(value);
}

function valid_ip_address(value) {
    var ip_regex = new RegExp(/^(([0-9]|[0-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-4])\.){3}([0-9]|[0-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-4])$/);
    return ip_regex.test(value);
}

function valid_ip_255(value) {
    var ip_255_regex = new RegExp(/^(([0-9]|[0-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[0-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/);
    return ip_255_regex.test(value);
}

function valid_admin_password(value) {
    var admin_password_regex = new RegExp(/^[^"'#&\/|\\ /]{4,40}$/);
    return admin_password_regex.test(value);
}

function valid_class_c_dhcp_start(value) {
    var class_c_dhcp_start_regex = new RegExp(/^([1-9]|[1-9][0-9]|[1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-3])$/);
    return class_c_dhcp_start_regex.test(value);
}

function valid_class_c_dhcp_end(value) {
    var class_c_dhcp_end_regex = new RegExp(/^([2-9]|[1-9][0-9]|[1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-4])$/);
    return class_c_dhcp_end_regex.test(value);
}

function valid_class_b_dhcp(value) {
    var class_b_dhcp_regex = new RegExp(/^(([0-9]|[0-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[0-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-4])$/);
    return class_b_dhcp_regex.test(value);
}

function valid_lease_time(value) {
    var lease_time_regex = new RegExp(/^([1-9]|[1-9][0-9])$/);
    return lease_time_regex.test(value);
}

function valid_ip_addr_end(value) {
    var ip_addr_end_regex = new RegExp(/^([2-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-4])$/);
    return ip_addr_end_regex.test(value);
}

function valid_class_b_ip_addr_num(value) {
    var class_b_ip_addr_num_regex = new RegExp(/^(\d+)$/);
    return class_b_ip_addr_num_regex.test(value);
}

function valid_preshared_key(value) {
    var preshared_key_regex = new RegExp(/^([^"\n]){8,64}$/);
    return preshared_key_regex.test(value);
}

function valid_vpn_user_name(value) {
    var vpn_user_name_regex = new RegExp(/^[a-zA-Z0-9_.-]{1,32}$/);
    return vpn_user_name_regex.test(value);
}

function valid_vpn_password(value) {
    var vpn_password_regex = new RegExp(/^([^"\n]){8,64}$/);
    return vpn_password_regex.test(value);
}

function valid_vlan_description(value) {
    var vlan_description_regex = new RegExp(/^[a-zA-Z0-9]{1,16}$/);
    return vlan_description_regex.test(value);
}

function valid_wan_lan_port(value) {
    var wan_lan_port_regex = new RegExp(/^(6553[0-5]|655[0-2]\d{1}|65[0-4]\d{2}|6[0-4](\d){3}|[1-5](\d){4}|[1-9](\d){0,3}$)$/);
    return wan_lan_port_regex.test(value);
}

function valid_wan_delay(value) {
    var wan_delay_regex = new RegExp(/^([0-9]|[1-9][0-9])$/);
    return  wan_delay_regex.test(value);
}

function remove_redflag(id){
    remove_class(id, "yes_redflag");
    add_class(id, "no_redflag");
}

function apply_redflag(id){
    remove_class(id, "no_redflag");
    add_class(id, "yes_redflag");
}

function remove_class(id, className) {
    $("#" + id).removeClass(className);
}

function add_class(id, className) {
    $("#" + id).addClass(className);
}

function enable_button(id) {
    $("#" + id).removeAttr("disabled");
}

function disable_button(id) {
    $("#" + id).prop("disabled",1);
}

function cancel() {
    $("#btnCancel").click(function(){
        location.reload();
    });
}

function refresh() {
    $("#Refresh").click(function(){
        location.reload();
    });
}

function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
