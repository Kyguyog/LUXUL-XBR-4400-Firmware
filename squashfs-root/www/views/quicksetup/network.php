<?php if($data['firstSetup']) {?>
<h1>Welcome to the Setup Wizard</h1>
<p>Setting up your wireless network is easy with the Luxul XWC-1000 Wireless Controller. The wizard will walk your through the steps:</p>
<br><br>
<?php }?>

<h2>Controller Network Settings</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="lanIp">IP Address</label>
        <a id="lan_ip_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input name="lanIp" type="text" id="lanIp" autocomplete="off" help="lan_ip_help" value="<?= $data['lanIPAddr']; ?>" />
    </div>
</div>
<div class="form-item clearfix">
    <div class='form-item-label'>
        <label for="lanSubnet">Subnet Mask</label>
        <a id="lan_subnet_mask_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="lanSubnet" type="text" id="lanSubnet" width="150" style="width: 150px" help="lan_subnet_mask_help">
            <?= $data['lanSubnetMaskOptions']; ?>
        </select>
    </div>
</div>
<div class="form-item clearfix">
    <div class='form-item-label'>
        <label for="lanSubnet">Default Gateway</label>
        <a id="lan_default_gw_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input name="lanDefaultGW" type="text" id="lanDefaultGW" autocomplete="off" help="lan_default_gw_help" value="<?= $data['lanDefaultGW']; ?>" />
    </div>
</div>
<div class="form-item clearfix">
    <div class='form-item-label'>
        <label for="priDNS">Primary DNS</label>
        <a id="pri_dns_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input name="priDNS" type="text" id="priDNS" autocomplete="off" help="pri_dns_help" value="<?= $data['priDNS']; ?>" />
    </div>
</div>
<div class="form-item clearfix">
    <div class='form-item-label'>
        <label for="secondaryDNS">Secondary DNS</label>
        <a id="secondary_dns_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input name="secondaryDNS" type="text" id="secondaryDNS" autocomplete="off" help="secondary_dns_help" value="<?= $data['secondaryDNS']; ?>" />
    </div>
</div>

<div class="wizard-nav">
    <?php if($data['firstSetup']) {?>
        <input type="submit" name="btnNext" id="btnNext" value="Next" class="cta-button large next">
    <?php } else {?>
        <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
        <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <?php }?>
</div>

