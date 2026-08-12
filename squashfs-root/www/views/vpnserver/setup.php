<h2>VPN Server</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="vpnModeOptions">VPN Mode</label>
        <a id="vpn_mode_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="vpnModeOptions" type="text" id="vpnModeOptions" help="vpn_mode_options_help">
            <?= $data[VPN_MODE_OPTIONS]; ?>
        </select>
    </div>
</div>

<div id="lanIPAddr" style="display: none"> <?= $data[LAN_IP_ADDR]; ?></div>

<div id="ikeAggressiveModeDiv" style="display: none">
    <h2>IKE Aggressive Mode</h2>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="ikeAggressiveMode">Aggressive Mode</label>
            <a id="ike_aggressive_mode_options_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <select name="ikeAggressiveModeOptions" type="text" id="ikeAggressiveModeOptions"
                    help="ike_aggressive_mode_options_help">
                <?= $data[IKE_AGGRESSIVE_MODE_OPTIONS]; ?>
            </select>
        </div>
    </div>
</div>

<div id="presharedKeyDiv" style="display: none">
    <h2 id="presharedKeySetup">Preshared Key Setup</h2>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="presharedKey">Preshared Key</label>
            <a id="preshared_key_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="presharedKey" type="text" id="presharedKey" help="preshared_key_help"
                   value="<?= $data[PRESHARED_KEY]; ?>"/>
        </div>
    </div>
</div>

<div id="dhcpServerDiv" style="display: none">
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="dhcpServer">DHCP Server</label>
            <a id="dhcp_server_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="dhcpServer" type="text" id="dhcpServer" help="dhcp_server_help"
                   value="<?= $data[DHCP_SERVER]; ?>"/>
        </div>
    </div>
</div>

<div id="pptpIpRangeDiv" style="display: none">
    <h2>IP Range</h2>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="pptpStartingIpAddress">Starting IP Address </label>
            <a id="pptp_starting_ip_address_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <span style='clear:left'>
			    <?= $data[IP_ADDR_START_BASE]; ?>
                <input name="pptpIpAddrStart4Octet" type="text" id="pptpIpAddrStart4Octet" maxlength="3"
                       style='width:30px;' value="<?= $data[PPTP_IP_ADDR_START_OCTET_4]; ?>"/>
			    </span>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="endingIpAddress">Ending IP Address </label>
            <a id="pptp_end_ip_address_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
                <span style='clear:left'>
				<?= $data[IP_ADDR_END_BASE]; ?>
                    <input name="pptpIpAddrEnd4Octet" type="text" id="pptpIpAddrEnd4Octet" maxlength="3"
                           style='width: 30px;' value="<?= $data[PPTP_IP_ADDR_END_OCTET_4]; ?>"/>
			    </span>
        </div>
    </div>
</div>

<div id="l2tpIpRangeDiv" style="display: none">
    <h2>L2TP/IPSec IP Range</h2>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="startingIpAddress">Starting IP Address </label>
            <a id="l2tp_starting_ip_address_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <span style='clear:left'>
			    <?= $data[IP_ADDR_START_BASE]; ?>
                <input name="l2tpIpAddrStart4Octet" type="text" id="l2tpIpAddrStart4Octet" maxlength="3"
                       style='width:30px;' value="<?= $data[L2TP_IP_ADDR_START_OCTET_4]; ?>"/>
			    </span>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="endingIpAddress">Ending IP Address </label>
            <a id="l2tp_end_ip_address_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
                <span style='clear:left'>
				<?= $data[IP_ADDR_END_BASE]; ?>
                    <input name="l2tpIpAddrEnd4Octet" type="text" id="l2tpIpAddrEnd4Octet" maxlength="3"
                           style='width: 30px;' value="<?= $data[L2TP_IP_ADDR_END_OCTET_4]; ?>"/>
			    </span>
        </div>
    </div>
</div>

<div class="wizard-nav">
    <input type="submit" name="btnApply" id="btnApply" value="Apply" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>