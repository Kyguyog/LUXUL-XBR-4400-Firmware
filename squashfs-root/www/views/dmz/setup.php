<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>DMZ</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="dmzStatus">DMZ(De-Militarized Zone)</label>
        <a id="dmz_status_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="dmzStatus" type="text" id="dmzStatus" help="dmz_status_help">
            <?= $data[DMZ_STATUS]; ?>
        </select>
    </div>
</div>

<div id="dmzEnabledDiv">
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="dmzIpAddr">IP Address </label>
            <a id="dmz_ip_addr_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="dmzIpAddr" type="text" id="dmzIpAddr" help='dmz_ip_addr_help'
                   value="<?= $data[DMZ_IP_ADDR]; ?>"/>
        </div>
    </div>
</div>

<div class="wizard-nav">
    <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>