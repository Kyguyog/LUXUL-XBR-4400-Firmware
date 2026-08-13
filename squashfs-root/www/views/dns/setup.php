<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>Dynamic DNS</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="dnsStatus">DNS: </label>
    </div>
    <div class="form-item-input">
        <select name="dnsStatus" type="text" id="dnsStatus">
            <?= $data[DNS_STATUS]; ?>
        </select>
    </div>
</div>

<div id="dnsEnabledDiv">
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="serviceProvider">Service Provider</label>
            <a id="service_provider_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <select name="serviceProvider" type="text" id="serviceProvider" help="service_provider_help">
                <?= $data[SERVICE_PROVIDER]; ?>
            </select>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="dnsHostname">Hostname</label>
            <a id="dns_hostname_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input maxlength="32" type="text" value="<?= $data[DNS_HOST_NAME]; ?>" id="dnsHostname" name="dnsHostname"
                   help="dns_hostname_help">
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="dnsUsername">Username</label>
            <a id="dns_username_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input help="dns_username_help" maxlength="32" type="text" value="<?= $data[DNS_USER_NAME]; ?>"
                   id="dnsUsername" name="dnsUsername">
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="dnsPassword">Password</label>
            <a id="dns_password_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input help="dns_password_help" type="password" maxlength="32" value="<?= $data[DNS_PASSWORD]; ?>"
                   id="dnsPassword" name="dnsPassword">
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="dnsInterval">Check Interval</label>
            <a id="dns_interval_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input size="10" help="dns_interval_help" type="text" value="<?= $data[DNS_INTERVAL]; ?>" id="dnsInterval"
                   name="dnsInterval"> Minutes
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="dnsUpdateInterval">Force Update Interval</label>
            <a id="dns_update_interval_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input help="dns_update_interval_help" size="10" type="text" value="<?= $data[DNS_UPDATE_INTERVAL]; ?>"
                   id="dnsUpdateInterval" name="dnsUpdateInterval"> Days
        </div>
    </div>
</div>

<div class="wizard-nav">
    <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>