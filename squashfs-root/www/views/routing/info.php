<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>Routes<a id="routes_help" class="help-icon"></a></h2>

<h2>Active Routes</h2>
<?php if (count($data[ALL_ACTIVE_ROUTES_INFO]) > 0) { ?>
    <table class="data-grid" style="text-align: center">
        <thead>
        <tr>
            <th style="width: 20%">Destination IP</th>
            <th style="width: 20%">Subnet Mask</th>
            <th style="width: 20%">Gateway</th>
            <th style="width: 20%">Metric</th>
            <th style="width: 20%">Interface</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data[ALL_ACTIVE_ROUTES_INFO] as $key => $activeRouteInfo) { ?>
            <tr>
                <td style="text-align: center"><?php echo $activeRouteInfo[DESTINATION_IP] ?></td>
                <td><?php echo $activeRouteInfo[NET_MASK] ?></td>
                <td><?php echo $activeRouteInfo[GATE_WAY] ?></td>
                <td><?php echo $activeRouteInfo[METRIC] ?></td>
                <td><?php echo $activeRouteInfo[NAME_INTERFACE] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>Connected Clients are not available since the DHCP server is disabled</p>
<?php } ?>

<hr/>
<h2>Add Static Route</h2>
<table class="data-grid" id="addSSID">
    <tr>
        <th style="width: 25%">Description</th>
        <th style="width: 7%">Interface</th>
        <th style="width: 15%">Destination IP</th>
        <th style="width: 15%">Netmask</th>
        <th style="width: 15%">Gateway</th>
        <th style="width: 4%">Metric</th>
        <th>Modify</th>
    </tr>
    <tr style='text-align:center'>
        <td style="text-align: center"><input type="text" style="width: 95%;" id="addDescription" maxlength="32" autocomplete="off"></td>
        <td>
            <select type="text" id="addInterfaceOptions" style="width: 95%;">
                <?= $data[ADD_INTERFACE_OPTIONS]; ?>
            </select>
        </td>
        <td><input type="text" style="width: 95%;;" id="addDestinationIP" autocomplete="off"></td>
        <td><input type="text" style="width: 95%;" id="addNetmask" autocomplete="off"></td>
        <td><input type="text" style="width: 95%;" id="addGateway" autocomplete="off"></td>
        <td><input type="text" style="width: 85%;" id="addMetric" autocomplete="off"></td>
        <td><input id="add" type="button" class="cta-button" value="Add">
            <input id="cancel" type="button" class="cta-button" value="Cancel">
        </td>
    </tr>
</table>

<br/><br/>
<hr/>

<h2>Static Routes</h2>
<table class="data-grid" id="addTo">
    <thead>
    <tr>
        <th style="width: 25%">Description</th>
        <th style="width: 7%">Interface</th>
        <th style="width: 15%">Destination IP</th>
        <th style="width: 15%">Netmask</th>
        <th style="width: 15%">Gateway</th>
        <th style="width: 3%">Metric</th>
        <th>Modify</th>
    </tr>
    </thead>

    <?php foreach ($data[STATIC_ROUTES_INFO] as $key => $staticRountInfo) { ?>
        <tr class="dataInput" style='text-align:center'>
            <td><?php echo $staticRountInfo[DESCRIPTION] ?></td>
            <td><?php echo $staticRountInfo[NAME_INTERFACE] ?></td>
            <td><?php echo $staticRountInfo[DESTINATION_IP] ?></td>
            <td><?php echo $staticRountInfo[NET_MASK] ?></td>
            <td><?php echo $staticRountInfo[GATE_WAY] ?></td>
            <td><?php echo $staticRountInfo[METRIC] ?></td>
            <td id="btnModify<?php echo $key ?>"></td>
        </tr>
    <?php } ?>
</table>

<div class="wizard-nav">
    <input type="button" name="btnApply" value="Apply" class="cta-button" id="btnApply">
    <input type="button" name="btnRefresh" value="Refresh" class="cta-button" id="Refresh">
    <input type="submit" name="btnReboot" value="Reboot" class="cta-button" id="btnReboot">
</div>





