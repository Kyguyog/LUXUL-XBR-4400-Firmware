<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>VLAN</h2>
<div id="vlanStatus">
    <select name="vlanStatusOptions" type="text" id="vlanStatusOptions">
        <?= $data[VLAN_STATUS_OPTIONS]; ?>
    </select>
    <a id="vlan_status_options_help" class="help-icon"></a>
</div>

<div id="vlanEnabledDiv" style="display: none">
    <hr>
    <h2>Create VLAN</h2>
    <table class="data-grid" style='text-align:center' id="create-vlan-table">
        <thead>
        <tr>
            <th>VLAN ID</th>
            <th>Description</th>
            <th>Members</th>
            <th>Inter VLAN Routing</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data[ALL_VLAN_INFO] as $vlanPort => $pvIDPort) { ?>
            <tr>
                <td style='text-align:center' id="vlanId"><?php echo $pvIDPort[VLAN_ID] ?></td>
                <td><?php echo $pvIDPort[VLAN_DESCRIPTION] ?></td>
                <td><?php echo $pvIDPort[MEMBERS] ?></td>
                <td><?php echo $pvIDPort[VLAN_ROUTING] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div style="padding-bottom:10px;"></div>
    <div>
        <input type="button" value="Add" disabled="disabled" id="btnAddVlan" name="btnAddVlan"
               style="padding:0 14px 0 13px">
        <a id="add_vlan_help" class="help-icon"></a>
        <input type="text" help="add_vlan_help" id="addVlan" maxlength="4" size="5">(2-4080)
    </div>
    <div>
        <input type="button" value="Edit" disabled="disabled" name="btnEditVlan" id='btnEditVlan'
               style="padding:0 14px 0 15px;">
        <a id="edit_vlan_help" class="help-icon"></a>
        <input type="text" help="edit_vlan_help" name="editVlan" id="editVlan" maxlength="4" size="5">(1-4080)
    </div>
    <div>
        <input type="button" value="Remove" disabled="disabled" name="btnRemoveVlan" id="btnRemoveVlan"
               style="padding:0 0px 0 0px">
        <a id="remove_vlan_help" class="help-icon"></a>
        <input type="text" help="remove_vlan_help" name="RemoveVlan" id="RemoveVlan" maxlength="4" size="5">(2-4080)
    </div>
    <div style="padding-bottom:10px;"></div>

    <hr>
    <h2>Port VLAN ID <a id="port_vlan_id_help" class="help-icon"></a></h2>
    <table class="data-grid" style='text-align:center'>
        <thead>
        <tr>
            <th width="20" align="center">&nbsp;</th>
            <?php foreach ($data[PVID_INFO] as $vlanPort => $pvIDPort) { ?>
                <th width="20" align="center">Port <?php echo $vlanPort ?></th>
            <?php } ?>

        </tr>
        <tr>
            <th width="20" align="center">PVID</th>
            <?php foreach ($data[PVID_INFO] as $vlanPort => $pvIDPort) { ?>
                <td width="20" align="center" style="background-color:#ffffff">
                    <input type="text" name="pvid_<?php echo $vlanPort; ?>" class="pvidPort" id="pvid_<?php echo $vlanPort; ?>" size="4"
                           value="<?php echo $pvIDPort; ?>" maxlength="4" style="text-align:center;"
                           help="pv_id_port_help">
                </td>
            <?php } ?>
        </tr>
        </thead>
    </table>
    <div style='font-weight: bold; border-top: 1px solid; margin: 0px;'>Note: Configure VLANs before assigning PVIDs
    </div>
</div>

<div class="wizard-nav">
    <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <input type="submit" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>

