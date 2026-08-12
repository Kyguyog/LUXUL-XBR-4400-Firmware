<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>VLAN Configuration</h2>
<table class="data-grid" style='text-align:center'>
    <thead>
    <tr style="text-align: center">
        <th>VLAN ID</th>
        <th>Description <a id="vlan_description_help" class="help-icon-table"></a></th>
        <th>Inter VLAN Routing <a id="vlan_routing_help" class="help-icon-table"></a></th>
    </tr>
    </thead>
    <tbody>
    <tr class="alt">
        <td width="20%" style='text-align:center'><?= $data[VLAN_ID]; ?>
            <input type="hidden" id="vlanID" name="vlanID" value=" <?= $data[VLAN_ID]; ?>">
        </td>
        <td width="40%">
            <input type="text" maxlength="16" id="vlanDescription" name="vlanDescription" help="vlan_description_help"
                   value="<?= $data['vlanDescription']; ?>">
        </td>
        <td width="40%">
            <?php if ($data[VLAN_ID] == VLAN_ID_1) { ?>
                Enabled
            <?php } else { ?>
                <select name="vlanRouting" type="text" id="vlanRouting" help="vlan_routing_help">
                    <?= $data[VLAN_ROUTING]; ?>
                </select>
            <?php } ?>
        </td>
    </tr>
    </tbody>
</table>

<table class="data-grid" style='text-align:center' id="portsTable">
    <thead>
    <tr>
        <th width="20%" align="center">Ports</th>
        <th width="40%" align="center">Enable <a id="port_enable_help" class="help-icon-table"></a></th>
        <th width="40%" align="center">Egress Rule</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data[VLAN_PORTS_INFO] as $vlanPort => $vlanPortInfo) { ?>
        <tr>
            <td width="20%" style='text-align:center'><?php echo $vlanPort; ?></td>
            <td width="40%">
                <input type="checkbox" class="checkEnabled" name="<?php echo $vlanPort ?>"
                       id="<?php echo $vlanPort ?>" <?php echo $vlanPortInfo[VLAN_PORT_ENABLED] == VLAN_PORT_STATUS_ENABLED ? CHECKBOX_CHECKED : EMPTY_STRING; ?> >
            </td>
            <td width="40%">
                <select name="egressRuleOptions<?php echo $vlanPort ?>" id="egressRuleOptions<?php echo $vlanPort ?>"
                        disabled>
                    <?php print_r($vlanPortInfo[VLAN_PORT_TAGGING_OPTIONS]) ?>
                </select>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<div style="padding-bottom:10px;"></div>

<?php if ($data['vlanID'] == VLAN_ID_1) { ?>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="ipaddr">IP Address</label>
            <a id="ip_addr_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text">
            <?= $data[IP_ADDRESS]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="subnetMask">Subnet Mask</label>
            <a id="subnet_mask_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text">
            <?= $data[SUBNET_MASK]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <a id="enable_dhcp_sever_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text">
            <?php echo $data[DHCP_SERVER_STATUS] == DHCP_SERVER_ENABLED_KEY ? DHCP_SERVER_ENABLED_VAL : DHCP_SERVER_DISABLED_VAL; ?>
        </div>
    </div>

    <?php if($data[DHCP_SERVER_STATUS] == DHCP_SERVER_ENABLED_KEY) {?>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <h4>DHCP Range:</h4>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classCStart">Start</label>
            <a id="class_c_start_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <span style='clear:left'>
            <?php if ($data[IPV4_CLASS_C]) {
                ?>
                <?= $data[CLASS_C_BASE]; ?><?= $data[CLASS_C_START]; ?>
            <?php } else { ?>
                <?= $data[CLASS_B_START]; ?>
            <?php } ?>
    		</span>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classCEnd">End</label>
            <a id="class_c_end_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <span style='clear:left'>
            <?php if ($data[IPV4_CLASS_C]) {
                ?>
                <?= $data[CLASS_C_BASE]; ?><?= $data[CLASS_C_END]; ?>
            <?php } else { ?>
                <?= $data[CLASS_B_END]; ?>
            <?php } ?>
    		</span>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classCLeaseTime">Lease Time (hours)</label>
            <a id="class_c_lease_time_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <?= $data[LEASE_TIME]; ?>
        </div>
    </div>

<?php }} else { ?>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="ipaddr">IP Address</label>
            <a id="ip_addr_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="ipaddr" type="text" id="ipaddr" help='ip_addr_help' value="<?= $data[IP_ADDRESS]; ?>"/>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="subnetMask">Subnet Mask</label>
            <a id="subnet_mask_help" class="help-icon"></a>
        </div>

        <?php if ($data[IPV4_CLASS_C]) { ?>
        <div class="form-item-input">
            <input name="subnetMask" type="text" id="subnetMask" help='subnet_mask_help'
                   value="<?= $data[SUBNET_MASK]; ?>"/>
        </div>
        <?php } else { ?>
            <div class="form-item-input">
                <select name="classBLanSubnetMaskOptions" type="text" id="classBLanSubnetMaskOptions"
                        help="class_b_lan_subnet_mask_options_help">
                    <?= $data[SUBNET_MASK]; ?>
                </select>
            </div>
        <?php } ?>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <a id="enable_dhcp_sever_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="dhcpServerStatus" type="checkbox" id="dhcpServerStatus"
                <?php echo $data[DHCP_SERVER_STATUS] == CONNECTED_CLIENTS_DHCP_KEY ? CHECKBOX_CHECKED: EMPTY_STRING; ?>
                />
            <div style="margin-top: 3px;">Enable DHCP Server</div>
        </div>
    </div>

    <div id="dhcpRangeDiv" style="display: none">
        <div class="form-item clearfix">
            <div class="form-item-label">
                <h4>DHCP Range:</h4>
            </div>
        </div>
        <div class="form-item clearfix">
            <div class="form-item-label">
                <label for="classCStart">Start</label>
                <a id="class_c_start_help" class="help-icon"></a>
            </div>
            <div class="form-item-input">
                <?php if ($data[IPV4_CLASS_C]) {
                    ?>
                    <span style='clear:left'>
			    <?= $data[CLASS_C_BASE]; ?>
                        <input name="classCStart" type="text" id="classCStart" help='class_c_start_help' maxlength="3"
                               style='width:30px;' value="<?= $data[CLASS_C_START]; ?>"/>
			    </span>
                <?php } else { ?>
                    <input name="classBStart" type="text" id="classBStart" help='class_b_start_help'
                           value="<?= $data[CLASS_B_START]; ?>"/>
                <?php } ?>
            </div>
        </div>
        <div class="form-item clearfix">
            <div class="form-item-label">
                <label for="classCEnd">End</label>
                <a id="class_c_end_help" class="help-icon"></a>
            </div>
            <div class="form-item-input">
                <?php if ($data[IPV4_CLASS_C]) {
                    ?>
                    <span style='clear:left'>
				<?= $data[CLASS_C_BASE]; ?>
                        <input name="classCEnd" type="text" id="classCEnd" help='class_c_end_help' maxlength="3"
                               style='width: 30px;' value="<?= $data[CLASS_C_END]; ?>"/>
			</span>
                <?php } else { ?>
                    <input name="classBEnd" type="text" id="classBEnd" help='class_b_end_help'
                           value="<?= $data[CLASS_B_END]; ?>"/>
                <?php } ?>

            </div>
        </div>
        <div class="form-item clearfix">
            <div class="form-item-label">
                <label for="classCLeaseTime">Lease Time (hours)</label>
                <a id="class_c_lease_time_help" class="help-icon"></a>
            </div>
            <div class="form-item-input">
                <input name="leasetime" type="text" id="leasetime" help="class_c_lease_time_help" maxlength="5"
                       style='width: 30px' value="<?= $data[LEASE_TIME]; ?>"/>
            </div>
        </div>
    </div>
<?php } ?>

<input type="hidden" id="ipv4Class" value="<?= $data[IPV4_CLASS]; ?>">

<div class="wizard-nav">
    <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>