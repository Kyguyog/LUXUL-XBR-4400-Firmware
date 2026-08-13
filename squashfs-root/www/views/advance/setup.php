<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>Advanced Administration</h2>
<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="wanAccelerationOptions">WAN Acceleration</label>
        <a id="wan_acceleration_options_help" class="help-icon"></a>
    </div>

    <?php if ($data[ROUTER_LIMITS_STATUS] || $data[MULTI_WAN_STATUS]) { ?>
        <div class="form-item-input-text">
            <?php echo WAN_ACCELERATION_DISABLED_VAL; ?>
        </div>

    <?php } else { ?>
        <div class="form-item-input-text">
            <select name="wanAccelerationOptions" type="text" id="wanAccelerationOptions"
                    help="wan_acceleration_options_help">
                <?= $data[WAN_ACCELERATION_OPTIONS]; ?>
            </select>
        </div>

        <input type="submit" name="saveWanAccleration" id="btnSave" value="Save" class="cta-button">

    <?php } ?>
</div>

<hr/>
<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="wanPingOptions">WAN Ping</label>
        <a id="wan_ping_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input-text">
        <select name="wanPingOptions" type="text" id="wanPingOptions" help="wan_ping_options_help">
            <?= $data[WAN_PING_OPTIONS]; ?>
        </select>
    </div>

    <input type="submit" name="saveWanPing" id="btnSave" value="Save" class="cta-button">
</div>

<hr/>
<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="ipv6StatusOptions">IPV6 WAN</label>
        <a id="ipv6_status_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input-text">
        <select name="ipv6StatusOptions" type="text" id="ipv6StatusOptions" help="ipv6_wan6_status_options_help">
            <?= $data[IPV6_STATUS_OPTIONS]; ?>
        </select>
    </div>

    <input type="submit" name="saveIpv6Wan" id="btnSave" value="Save" class="cta-button">
</div>

<hr/>
<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="pptpPassthruOptions">PPTP Passthru</label>
        <a id="pptp_passthru_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input-text">
        <select name="pptpPassthruOptions" type="text" id="pptpPassthruOptions" help="pptp_passthru_options_help">
            <?= $data[PPTP_PASSTHRU_OPTIONS]; ?>
        </select>
    </div>

    <input type="submit" name="savePptpPassthru" id="savePptpPassthru" value="Save" class="cta-button">

</div>

<div id="pptpPaththruEnabledDiv">
    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="serverAddr">Server Address</label>
            <a id="server_addr_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="serverAddr" type="text" id="serverAddr" help="server_addr_help"
                   value="<?= $data[SERVER_ADDR]; ?>"/>
        </div>
    </div>
</div>

<hr/>

<div class="wizard-nav">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>