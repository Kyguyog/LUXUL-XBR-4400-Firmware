<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>Port Link Speed</h2>
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

<div class="wizard-nav">
    <input type="submit" name="btnPortSpeedInfo" id="btnPortSpeedInfo" value="Save" class="cta-button">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <input type="submit" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>