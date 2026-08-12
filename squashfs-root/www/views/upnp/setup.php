<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
    </div>
<?php } ?>

<h2>UPnP Configuration</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="upnpStatusOptions">UPnP</label>
    </div>
    <div class="form-item-input">
        <select name="upnpStatusOptions" type="text" id="upnpStatusOptions" help="qos_service_status_options_help">
            <?= $data[UPNP_STATUS_OPTIONS]; ?>
        </select>
    </div>
</div>

<hr/>
<h2>Available Networks</h2>
<?php foreach ($data[VLANS] as $key => $value) { ?>
    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="<?php echo $key ?>"><?php echo $value ?></label>
        </div>
        <div class="form-item-input-text">
            <input class="check" name="lanCheckbox" id="<?php echo $key ?>"
                   type="checkbox" <?php echo in_array($key, $data[LAN]) == true ? "checked='checked'" : "" ?>
                   style="bottom: 4px"/>
        </div>
    </div>
<?php } ?>

<hr/>
<h2>Current UPnP Leases</h2>
<table class="data-grid" style="text-align: center">
    <thead>
    <tr>
        <th>WAN Port</th>
        <th>LAN IP</th>
        <th>LAN Port</th>
        <th>Protocol</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data[LEASES] as $lease) { ?>
        <tr>
            <td style="text-align: center"><?php echo $lease[WAN_PORT] ?></td>
            <td><?php echo $lease[LAN_IP_ADDR] ?></td>
            <td><?php echo $lease[LAN_PORT] ?></td>
            <td><?php echo $lease[PROTOCAL] ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<div class="wizard-nav">
    <input type="button" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>
