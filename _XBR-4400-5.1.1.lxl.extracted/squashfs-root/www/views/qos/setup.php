<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>QOS Setup</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="qosServiceStatusOptions">QOS Service</label>
        <a id="qos_service_status_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="qosServiceStatusOptions" type="text" id="qosServiceStatusOptions"
                help="qos_service_status_options_help">
            <?= $data[QOS_SERVICE_STATUS_OPTIONS]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="calculateOverheadOptions">Calculate Overhead</label>
        <a id="calculate_overhead_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="calculateOverheadOptions" type="text" id="calculateOverheadOptions"
                help="calculate_overhead_options_help">
            <?= $data[CALCULATE_OVERHEAD_OPTIONS]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="qosDownloadSpeed">Download Speed (Mbps)</label>
        <a id="qos_download_speed_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input name="qosDownloadSpeed" maxlength="7" type="text" help="qos_download_speed_help" id="qosDownloadSpeed"
               value="<?= $data[QOS_DOWNLOAD_SPEED]; ?>"/>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="qosUploadSpeed">Upload Speed (Mbps)</label>
        <a id="qos_upload_speed_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <input name="qosUploadSpeed" maxlength="7" type="text" help="qos_upload_speed_help" id="qosUploadSpeed"
               value="<?= $data[QOS_UPLOAD_SPEED]; ?>"/>
    </div>
</div>

<hr>
<h2>QOS Rules
    <a id="qos_rules_help" class="help-icon"></a>
</h2>
<table class="data-grid" id="addSSID" style="text-align: center">
    <thead>
    <tr>
        <th>Service Level</th>
        <th>Source Host</th>
        <th>Protocol</th>
        <th>Ports</th>
        <th>Modify</th>
    </tr>
    </thead>

    <tr class="alt">
        <td style="text-align: center">
            <select type="text" id="serviceLevelOptions">
                <?= $data[SERVICE_LEVEL_OPTIONS]; ?>
            </select>
        </td>
        <td><input type="text" id="sourceHost" name="sourceHost" style="width:110px;" value="All"></td>
        <td>
            <select type="text" id="protocalOptions">
                <?= $data[PROTOCAL_OPTIONS]; ?>
            </select>
        </td>
        <td><input type="text" id="ports" name="ports" style="width:60px;" value="All"></td>
        <td><input id="add" type="button" class="cta-button" value="Add"></td>
    </tr>
</table>

<table class="data-grid" id="addTo" style="text-align: center">
    <thead>
    <tr>
        <th style="width: 117px;">Service Level</th>
        <th style="width: 173px;">Source Host</th>
        <th style="width: 88px;">Protocol</th>
        <th style="width: 101px;">Ports</th>
        <th>Modify</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data[QOS_RULES_INFO] as $key => $qosRuleInfo) {
        $idName = '3';
        if ($qosRuleInfo[SERVICE_LEVEL] == "Priority") {
            $idName = "0";
        } else if ($qosRuleInfo[SERVICE_LEVEL] == "Express") {
            $idName = "1";
        } else if ($qosRuleInfo[SERVICE_LEVEL] == "Normal") {
            $idName = "2";
        }
        ?>
        <tr class="dataInput" style='text-align:center'>
            <td style="text-align: center" id="<?php echo $idName; ?>"><?php echo $qosRuleInfo[SERVICE_LEVEL] ?></td>
            <td><?php echo $qosRuleInfo[SOURCE_HOST] ?></td>
            <td><?php echo $qosRuleInfo[PROTOCAL] ?></td>
            <td><?php echo $qosRuleInfo[PORTS] ?></td>
            <td id="btnModify<?php echo $key ?>"></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<div class="wizard-nav">
    <input type="button" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>