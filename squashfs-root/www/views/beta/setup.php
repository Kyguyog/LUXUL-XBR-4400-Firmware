<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>Beta Features</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="portMonitoringOptions">Port Monitoring</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="portMonitoringOptions" type="text" id="portMonitoringOptions">
            <?= $data[PORT_MONITORING_OPTIONS]; ?>
        </select>
    </div>
</div>

<hr/>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="wanDelay">WAN Delay</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <input name="wanDelay" style="width: 20px;" type="text" id="wanDelay" value="<?= $data[WAN_DELAY]; ?>"
               maxlength="2"/>&nbsp;&nbsp;Seconds
    </div>

    <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
</div>

<hr>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="wanVlanTagOptions">WAN VLAN Tag</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="wanVlanTagOptions" type="text" id="wanVlanTagOptions">
            <?= $data[WAN_VLAN_TAG_OPTIONS]; ?>
        </select>
    </div>

    <input type="submit" name="btnSaveWanVlanTag" id="btnSaveWanVlanTag" value="Save" class="cta-button">

</div>

<div id="vlanIdDiv" class="form-item clearfix">
    <div class="form-item-label">
        <label for="vlanId">VLAN ID </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <input name="vlanID" style="width: 30px" type="text" id="vlanID" value="<?= $data[VLAN_ID]; ?>" maxlength="4"/>
    </div>
</div>

<hr>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="blockSelfAssignedIpOptions">Block Self Assigned IP</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="blockSelfAssignedIpOptions" type="text" id="blockSelfAssignedIpOptions">
            <?= $data[BLOCK_SELF_ASSIGNED_IP_OPTIONS]; ?>
        </select>
    </div>
</div>

<hr>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="wanPortOptions">Port Link Speed</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="wanPortOptions">WAN1 Port</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="wanPortOptions" type="text" id="wanPortOptions">
            <?= $data[WAN_PORT_OPTIONS]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="lanPort4Options">WAN Port 2 / LAN Port 4</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="lanPort4Options" type="text" id="lanPort4Options">
            <?= $data[LAN_PORT_4_OPTIONS]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="lanPort3Options">WAN Port 3 / LAN Port 3</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="lanPort3Options" type="text" id="lanPort3Options">
            <?= $data[LAN_PORT_3_OPTIONS]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="lanPort2Options">WAN Port 4 / LAN Port 2</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="lanPort2Options" type="text" id="lanPort2Options">
            <?= $data[LAN_PORT_2_OPTIONS]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="lanPort1Options">LAN Port 1</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="lanPort1Options" type="text" id="lanPort1Options">
            <?= $data[LAN_PORT_1_OPTIONS]; ?>
        </select>
    </div>
</div>

<input type="submit" name="btnPortSpeedInfo" id="btnPortSpeedInfo" value="Save" class="cta-button" style="margin-left: 220px;">

<div class="wizard-nav" style="margin-top: 20px;">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
</div>