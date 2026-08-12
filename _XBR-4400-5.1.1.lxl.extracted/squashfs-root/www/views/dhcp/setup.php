<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<h2>DHCP</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="dhcpServerOptions">Enable DHCP Server</label>
        <a id="dhcp_server_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="dhcpServerOptions" type="text" id="dhcpServerOptions" help="dhcp_server_options_help">
            <?= $data[DHCP_SERVER_OPTIONS]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="ipv4ClassOptions">IPv4 Class</label>
        <a id="ipv4_class_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="ipv4ClassOptions" type="text" id="ipv4ClassOptions" help="ipv4_class_options_help">
            <?= $data[IPV4_CLASS_OPTIONS]; ?>
        </select>
    </div>
</div>

<hr/>
<div id="classCDiv">
    <div class="form-item clearfix">
        <div class="form-item-label">
            <h4>Local Network / LAN:</h4>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classCLanIPAddr">LAN IP Address</label>
            <a id="class_c_lan_ip_addr_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text" id="classCLanIPAddr">
            <?= $data[LAN_IP_ADDR]; ?>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classCLanSubnetMaskOptions">LAN Subnet Mask</label>
            <a id="class_c_lan_subnet_mask_options_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text">
            <?php echo SUBNET_MASK_255_255_255_0_VAL; ?>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classCLanIPAddrEnd">LAN IP Address End</label>
            <a id="class_c_lan_ip_addr_end_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text" id="classCLanIPAddrEnd">
            <?= $data[LAN_IP_ADDR_END]; ?>
        </div>
    </div>
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
			<?= $data[CLASS_C_BASE]; ?>
                <input name="classCStart" type="text" id="classCStart" help='class_c_start_help' maxlength="3"
                       style='width:30px;' value="<?= $data[CLASS_C_START]; ?>"/>
			</span>
        </div>
    </div>
    <div class="form-item clearfix" style="display: none">
        <div class="form-item-label">
            <label for="classCIPAddrNum">Number of IP Addresses</label>
            <a id="class_c_ip_addr_num_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="classCIPAddrNum" type="text" id="classCIPAddrNum" help='class_c_ip_addr_num_help' maxlength="5"
                   style='width:30px;' value="<?= $data[CLASS_C_IP_ADDR_NUM]; ?>"/>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classCEnd">End</label>
            <a id="class_c_end_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
			<span style='clear:left'>
				<?= $data[CLASS_C_BASE]; ?>
                <input name="classCEnd" type="text" id="classCEnd" help='class_c_end_help' maxlength="3"
                       style='width: 30px;' value="<?= $data[CLASS_C_END]; ?>"/>
			</span>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classCLeaseTime">Lease Time (hours)</label>
            <a id="class_c_lease_time_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="classCLeaseTime" type="text" id="classCLeaseTime" help="class_c_lease_time_help" maxlength="5"
                   style='width: 30px' value="<?= $data[CLASS_C_LEASE_TIME]; ?>"/>
        </div>
    </div>
</div>

<div id="classBDiv">
    <div class="form-item clearfix">
        <div class="form-item-label">
            <h4>Local Network / LAN:</h4>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classBLanIPAddr">LAN IP Address</label>
            <a id="class_b_lan_ip_addr_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text">
            <input name="lanIPAddr" type="text" id="classBLanIPAddr" autocomplete="off" help="class_b_lan_ip_addr_help"
                   value="<?= $data[LAN_IP_ADDR]; ?>"/>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classBLanSubnetMaskOptions">LAN Subnet Mask</label>
            <a id="class_b_lan_subnet_mask_options_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text">
            <select name="classBLanSubnetMaskOptions" type="text" id="classBLanSubnetMaskOptions"
                    help="class_b_lan_subnet_mask_options_help">
                <?= $data[CLASS_B_LAN_SUBNET_MASK_OPTIONS]; ?>
            </select>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classBLanIPAddrStart">LAN IP Address Start</label>
            <a id="class_b_lan_ip_addr_start_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text" id="classBLanIPAddrStart">
            <?= $data[LAN_IP_ADDR_START]; ?>
        </div>
        <input name="classBLanIPAddrStart" type="hidden" id="classBLanIPAddrStartHidden" help='class_b_lan_ip_addr_start_help'
               value="<?= $data[LAN_IP_ADDR_START]; ?>"/>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classBLanIPAddrEnd">LAN IP Address End</label>
            <a id="class_b_lan_ip_addr_end_help" class="help-icon"></a>
        </div>
        <div class="form-item-input-text" id="classBLanIPAddrEnd">
            <?= $data[LAN_IP_ADDR_END]; ?>
        </div>
        <input name="classBLanIPAddrEnd" type="hidden" id="classBLanIPAddrEndHidden" help='class_b_lan_ip_addr_end_help'
               value="<?= $data[LAN_IP_ADDR_END]; ?>"/>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <h4>DHCP Range:</h4>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classBStart">Start</label>
            <a id="class_b_start_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="classBStart" type="text" id="classBStart" help='class_b_start_help' value="<?= $data[CLASS_B_START]; ?>"/>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classBIPAddrNum">Number of IP Addresses</label>
            <a id="class_b_ip_addr_num_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="classBIPAddrNum" type="text" id="classBIPAddrNum" help='class_b_ip_addr_num_help'
                   style='width:40px;' maxlength="5" value="<?= $data[CLASS_B_IP_ADDR_NUM]; ?>"/>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classBEnd">End</label>
            <a id="class_b_end_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="classBEnd" type="text" id="classBEnd" help='class_b_end_help'
                   value="<?= $data[CLASS_B_END]; ?>"/>
        </div>
    </div>
    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="classBLeaseTime">Lease Time (hours)</label>
            <a id="class_b_lease_time_help" class="help-icon"></a>
        </div>
        <div class="form-item-input">
            <input name="classBLeaseTime" type="text" id="classBLeaseTime" help="class_b_lease_time_help" maxlength="5"
                   style='width: 30px' value="<?= $data[CLASS_B_LEASE_TIME]; ?>"/>
        </div>
    </div>
</div>

<input type="hidden" value="<?= $data[VLAN_STATUS]; ?>" id='vlanStatus'>
<input type="hidden" value="<?= $data[IPV4_CLASS]; ?>" id='ipv4Class'>

<hr/>
<div class="wizard-nav">
    <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>
