<h2>WAN3</h2>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="wanName">WAN Name</label>
        <a id="wan_name_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input name="wanName" type="text" id="wanName" help="wan_name_help" value="<?= $data[WAN_NAME]; ?>" maxlength="32"/>
    </div>
</div>

<h3>Create Multi-WAN</h3>
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
<h3>Multi-WAN Settings</h3>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="trackingReliability">Tracking Reliability</label>
        <a id="tracking_reliability_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="trackingReliability" type="text" id="trackingReliability" help="tracking_reliability_help">
            <?= $data[TRACKING_RELIABILITY]; ?>
        </select>

    </div>
</div>

<div id="tracingIPDiv" style="display:none">
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="trackingIPInput">Tracking IP</label>
            <a id="tracking_ip_input_help" class="help-icon"></a>
        </div>
        <div class="form-item-input" id="trackingIPInput" style="line-height: 9px;" help="tracking_ip_input_help">
        </div>
    </div>
</div>
<input type="hidden" id="trackingIP" value="<?= $data[TRACKING_IP]; ?>">

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="pingCount">Ping Count</label>
        <a id="ping_count_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="pingCount" id="pingCount" help="ping_count_help">
            <?= $data[PING_COUNT]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="pingTimeout">Ping Timeout</label>
        <a id="ping_time_out_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="pingTimeout" id="pingTimeout" help="ping_time_out_help">
            <?= $data[PING_TIME_OUT]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="pingInterval">Ping Interval</label>
        <a id="ping_interval_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="pingInterval" id="pingInterval" help="ping_interval_help">
            <?= $data[PING_INTERVAL]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="interfaceDown">Interface Down</label>
        <a id="interface_down_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="interfaceDown" id="interfaceDown" help="interface_down_help">
            <?= $data[INTERFACE_DOWN]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="interfaceUp">Interface Up</label>
        <a id="interface_up_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="interfaceUp" id="interfaceUp" help="interface_up_help">
            <?= $data[INTERFACE_UP]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="ipv6StatusOptions">IPV6 Status</label>
        <a id="ipv6_status_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="ipv6StatusOptions" id="ipv6StatusOptions" help="ipv6_status_options_help">
            <?= $data[IPV6_STATUS_OPTIONS]; ?>
        </select>
    </div>
</div>

<input type="hidden" id="multiWanWizardStatus" value="<?= $data[MULTI_WAN_WIZARD_STATUS]; ?>">

<div class="wizard-nav">
    <?php if ($data[MULTI_WAN_WIZARD_STATUS] == MULTI_WAN_WIZARD_STATUS_0) { ?>
        <input type="submit" name="btnNext" id="btnNext" value="Next" class="cta-button">
        <input type="submit" name="btnAddWan" id="btnAddWan" value="Add WAN" class="cta-button">
        <input type="button" id="btnCancel" value="Cancel" class="cta-button">
    <?php } else { ?>
        <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
        <input type="submit" name="btnCancel" value="Cancel" class="cta-button">
    <?php } ?>
</div>