<h2>Web Filtering</h2>
<p>
    Web Filtering can be setup by using
    <a href="http://www.opendns.com/home-internet-security/parental-controls/opendns-home/">OpenDNS</a>
    or similar service. You can use an alternative service manually entering the IP Address in the alternate DNS fields.
</p>

<div class="form-item clearfix" style="margin-left: 150px;">
    <div class="form-item-label" style="margin-right:5px;">
        <label>Web Filtering</label>
    </div>
    <div class="form-item-input">
        <select name="webFilteringOptions" type="text" id="webFilteringOptions">
            <?= $data[WEB_FILTERING_OPTIONS]; ?>
        </select>
    </div>
</div>

<div id="webFilteringEnabledDiv" style="display: none">
    <div class="form-item clearfix">
        <div class="form-item-label" style="width:400px;">OpenDNS Home or OpenDNS Home VIP
            <a id="open_dns_home_help" class="help-icon"></a>

            <div style="margin-right:32px;">208.67.222.222 and 208.67.220.220</div>
        </div>
        <div class="form-item-input" style="width:130px;">
            <input type="checkbox" id="check1" class="unique" name="check1" <?= $data[CHECK_BOX_1];?> >
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label" style="width:400px;">OpenDNS Family Shield
            <a id="open_dns_family_help" class="help-icon"></a>

            <div style="margin-right:32px;">208.67.222.123 and 208.67.220.123</div>
        </div>
        <div class="form-item-input" style="width:130px;">
            <input type="checkbox" id="check2" class="unique" name="check2" <?= $data[CHECK_BOX_2];?> >
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label" style="width:400px;">Alternate DNS
            <a id="alternate_dns_help" class="help-icon"></a>
        </div>
        <div class="form-item-input" style="width:130px;">
            <input type="checkbox" id="check3" class="unique" name="check3" <?= $data[CHECK_BOX_3];?> >
        </div>
    </div>

    <div id="alternateDNSDiv" style="display: none">
        <div class="form-item clearfix">
            <div class="form-item-label">
                <label for="primaryDns">Primary DNS</label>
                <a id="primary_dns_help" class="help-icon"></a>
            </div>
            <div class="form-item-input">
                <input type="text" maxlength="15" value="<?= $data[CHECK_BOX_3_PRIMARY_DNS]; ?>" help="primary_dns_help" id="primaryDns" name="check3PriDNS">
            </div>
        </div>
        <div class="form-item clearfix">
            <div class="form-item-label">
                <label for="secondaryDns">Secondary DNS</label>
                <a id="secondary_dns_help" class="help-icon"></a>
            </div>
            <div class="form-item-input">
                <input type="text" maxlength="15" value="<?= $data[CHECK_BOX_3_SECONDARY_DNS]; ?>" help="secondary_dns_help" id="secondaryDns"
                       name="check3SecondaryDNS">
            </div>
        </div>
    </div>

</div>

<div class="wizard-nav">
    <input type="submit" name="btnApply" id="btnApply" value="Apply" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>