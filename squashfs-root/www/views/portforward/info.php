<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>Port Forward<a id="port_forward_help" class="help-icon"></a></h2>

<p>Forward Individual Ports From WAN to LAN</p>
<table class="data-grid" id="addSSID">
    <tr>
        <th style="width: 25%">Application Name</th>
        <th style="width: 5%">Protocol</th>
        <th style="width: 15%">WAN Port</th>
        <th style="width: 15%">LAN IP</th>
        <th style="width: 15%">LAN port</th>
        <th>Modify</th>
    </tr>
    <tr style='text-align:center'>
        <td style="text-align: center"><input type="text" style="width: 95%" id="addApplicationName" maxlength="32" autocomplete="off"></td>
        <td>
            <select type="text" id="protocalOptions">
                <?= $data[PROTOCAL_OPTIONS]; ?>
            </select>
        </td>
        <td><input type="text" style="width: 95%" id="addWanPort"></td>
        <td><input type="text" style="width: 95%" id="addLanIp"></td>
        <td><input type="text" style="width: 95%" id="addLanPort"></td>
        <td><input id="add" type="button" class="cta-button" value="Add">&nbsp
            <input id="cancel" type="button" class="cta-button" value="Cancel">
        </td>
    </tr>
</table>

<br/><br/>

<h2>Forwarded Ports</h2>
<table class="data-grid" id="addTo">
    <thead>
    <tr>
        <th style="width: 25%">Application Name</th>
        <th style="width: 6%">Protocol</th>
        <th style="width: 15%">WAN Port</th>
        <th style="width: 15%">LAN IP</th>
        <th style="width: 15%">LAN port</th>
        <th>Modify</th>
    </tr>
    </thead>

    <?php foreach ($data[FORWARDED_PORTS_INFO] as $key => $forwardedPortInfo) { ?>
        <tr class="dataInput" style='text-align:center'>
            <td><?php echo $forwardedPortInfo[APPLICATION_NAME] ?></td>
            <td><?php echo $forwardedPortInfo[PROTOCAL] ?></td>
            <td><?php echo $forwardedPortInfo[WAN_PORT] ?></td>
            <td><?php echo $forwardedPortInfo[LAN_IP_ADDR] ?></td>
            <td><?php echo $forwardedPortInfo[LAN_PORT] ?></td>
            <td id="btnModify<?php echo $key ?>"></td>
        </tr>
    <?php } ?>
</table>

<div class="wizard-nav">
    <input type="button" name="btnApply" value="Apply" class="cta-button" id="btnApply">
    <input type="button" name="btnRefresh" value="Refresh" class="cta-button" id="Refresh">
    <input type="submit" name="btnReboot" value="Reboot" class="cta-button" id="btnReboot">
</div>





