<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>Internet / WAN</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="connectionTypeOptions">Connection Type</label>
        <a id="connection_type_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="connectionTypeOptions" type="text" id="connectionTypeOptions" help="connection_type_options_help">
            <?= $data[CONNECTION_TYPE_OPTIONS]; ?>
        </select>
    </div>
</div>

<div id='connectionTypePPPOEDiv'>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="pppoeUser">User Name</label>
            <a id="pppoe_user_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="pppoeUser" type="text" id="pppoeUser" help="pppoe_user_help" value="<?= $data[PPPOE_USER]; ?>"
                   maxlength="32"/>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="pppoePwd">Password</label>
            <a id="pppoe_pwd_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="pppoePwd" type="text" id="pppoePwd" help="pppoe_pwd_help" value="<?= $data[PPPOE_PASSWORD]; ?>"
                   maxlength="32"/>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="pppoeServiceName">Service Name</label>
            <a id="pppoe_service_name_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="pppoeServiceName" type="text" id="pppoeServiceName" help="pppoe_service_name_help" value="<?= $data[PPPOE_SERVICE_NAME]; ?>"/>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="pppoeMaxFailedPing">Max Failed Pings</label>
            <a id="pppoe_max_failed_ping_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="pppoeMaxFailedPing" type="text" id="pppoeMaxFailedPing" help="pppoe_max_failed_ping_help"
                   value="<?= $data[PPPOE_MAX_FAILED_PING]; ?>" maxlength="15"/>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="pppoePingInterval">Ping Interval</label>
            <a id="pppoe_ping_interval_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="pppoePingInterval" type="text" id="pppoePingInterval" help="pppoe_ping_interval_help"
                   value="<?= $data[PPPOE_PING_INTERVAL]; ?>" maxlength="15"/>
        </div>
    </div>
</div>

<div id='connectionTypeStaticDiv'>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="staticIp">Static IP</label>
            <a id="static_id_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input type=text name='staticIp' id='staticIp' help="static_id_help" value="<?= $data[STATIC_IP]; ?>"/>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="netmask">Netmask</label>
            <a id="netmask_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input type=text name='netmask' id='netmask' help="netmask_help" value="<?= $data[NET_MASK]; ?>"/>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="gateway">Gateway</label>
            <a id="gateway_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input type=text name='gateway' id='gateway' help="gateway_help" value="<?= $data[GATE_WAY]; ?>"/>
        </div>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="primaryDNS">Primary DNS</label>
        <a id="pri_dns_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input type=text name='primaryDNS' id='primaryDNS' help="pri_dns_help" value="<?= $data[PRIMARY_DNS]; ?>"/>
    </div>
</div>

<div class="form-item clearfix" id="secondaryDnsDiv">
    <div class="form-item-label">
        <label for="secondaryDns">Secondary DNS</label>
        <a id="secondary_dns_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input type=text name='secondaryDns' id='secondaryDns' help="secondary_dns_help"
               value="<?= $data[SECONDARY_DNS]; ?>"/>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="customMacAddr">MAC Address</label>
        <a id="custom_mac_addr_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input type=text name='customMacAddr' id='customMacAddr' help="custom_mac_addr_help"
               value="<?= $data[CUSTOM_MAC_ADDR]; ?>"/>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="customMtu">Custom MTU</label>
        <a id="custom_mtu_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input type=text name='customMtu' id='customMtu' help="custom_mtu_help" value="<?= $data[CUSTOM_MTU]; ?>"/>
    </div>
</div>

<hr>
<h2>Local Network / LAN</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="lanIPAddr">LAN IP Address</label>
        <a id="lan_ip_addr_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input name="lanIPAddr" type="text" id="lanIPAddr" autocomplete="off" help="lan_ip_addr_help"
               value="<?= $data[LAN_IP_ADDR]; ?>"/>
    </div>
</div>

<div class="form-item clearfix">
    <div class='form-item-label'>
        <label for="lanSubnet">LAN Subnet Mask</label>
        <a id="lan_subnet_mask_help" class="help-icon"></a>
    </div>
    <div class="form-item-input-text">
        <?= $data[LAN_SUBNET_MASK]; ?>
    </div>
</div>

<input type="hidden" id="ipv4" value="<?= $data[IPV4]; ?>"/>
<input type="hidden" id="classCStart" value="<?= $data[CLASS_C_START]; ?>"/>
<input type="hidden" id="classCEnd" value="<?= $data[CLASS_C_END]; ?>"/>

<div class="wizard-nav">
    <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <input type="submit" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>

