<h2>Multi-WAN Status</h2>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="multiWanReportOptions">Multi-WAN Status</label>
    </div>
    <div class="form-item-input">
        <select name="multiWanReportOptions" type="text" id="multiWanReportOptions">
            <?= $data[MULTI_WAN_REPORT_OPTIONS]; ?>
        </select>
    </div>
</div>

<div id='multiWanReportDefaultDiv' style="display: none">
    <h3>Full Report</h3>

<!--    --><?php //foreach ($data[MULTI_WAN_INTERFACE_STATUS] as $key => $multiwanInterface) { ?>
<!--        <h5 style="line-height: 18px;">--><?php //echo $multiwanInterface ?><!--</h5>-->
<!--    --><?php //} ?>

    <?php foreach ($data[MULTI_WAN_INTERFACE] as $interfaceStatus => $multiwanInterface) { ?>
        <?php if (explode(UNDERSCORE, $interfaceStatus)[1] == OFFLINE) { ?>
            <h4 style="color: red;line-height: 20px"><?php echo $multiwanInterface . SPACE . ucfirst(OFFLINE); ?></h4>
        <?php } else { ?>
            <h4 style="line-height: 20px"><?php echo $multiwanInterface . SPACE . ucfirst(ONLINE); ?></h4>
        <?php }
    } ?>

    <hr/>
<!--    --><?php //if(count($data[MULTI_WAN_POLICY_STATUS]) > 0) {
//        foreach ($data[MULTI_WAN_POLICY_STATUS] as $key => $multiwanPolicy) { ?>
<!--            <h5 style="line-height: 18px;">--><?php //echo $multiwanPolicy ?><!--</h5>-->
<!--        --><?php //}} else { ?>
<!--        <h5>No Active Policies</h5>-->
<!--    --><?php //} ?>

    <h3>Policy Report</h3>
    <?php if(count($data[MULTI_WAN_POLICY_STATUS]) > 0) {
        foreach ($data[MULTI_WAN_POLICY_STATUS] as $key => $multiwanPolicy) { ?>
            <h5 style="line-height: 18px;"><?php echo $multiwanPolicy ?></h5>
        <?php }} else { ?>
        <h5>No Active Policies</h5>
    <?php } ?>

<!--    <hr/>-->
<!--    --><?php //if(count($data[MULTI_WAN_RULES_STATUS]) > 0) {
//        foreach ($data[MULTI_WAN_RULES_STATUS] as $key => $multiwanRule) { ?>
<!--            <h5 style="line-height: 18px;">--><?php //echo $multiwanRule ?><!--</h5>-->
<!--        --><?php //}} else { ?>
<!--        <h5>No Active Rules</h5>-->
<!--    --><?php //} ?>
</div>

<div id='multiWanReportDefaultDiv' style="display: none">
    <?php foreach ($data[MULTI_WAN_INTERFACE] as $interfaceStatus => $multiwanInterface) { ?>
        <?php if (explode(UNDERSCORE, $interfaceStatus)[1] == OFFLINE) { ?>
            <h4 style="color: red;line-height: 20px"><?php echo $multiwanInterface . SPACE . ucfirst(OFFLINE); ?></h4>
        <?php } else { ?>
            <h4 style="line-height: 20px"><?php echo $multiwanInterface . SPACE . ucfirst(ONLINE); ?></h4>
        <?php }
    } ?>
</div>

<div id='multiWanReportInterfaceDiv' style="display: none">
    <h3>Interface Report</h3>
    <?php foreach ($data[MULTI_WAN_INTERFACE_STATUS] as $key => $multiwanInterface) { ?>
        <h5 style="line-height: 18px;"><?php echo $multiwanInterface ?></h5>
    <?php } ?>

    <br />
    <h3>WAN</h3>
    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="connectionType">Connection Type</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[CONNECTION_TYPE]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanIPAddr">IP Address</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_IP_ADDR]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanSubnetMask">Subnet Mask</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_SUBNET_MASK]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanGateway">Gateway</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_GATE_WAY]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanDNSServer">DNS Server</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_DNS_SERVER]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanAlternateDNS">Alternate DNS</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_ALTERNATE_DNS]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMacAddr">MAC Address</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_MAC_ADDR]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMtu">MTU</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_MTU]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMetric">Metric</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_METRIC]; ?>
        </div>
    </div>

    <hr />
    <h3>WAN2</h3>
    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="connectionType">Connection Type</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[CONNECTION_TYPE.WAN2]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanIPAddr">IP Address</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_IP_ADDR.WAN2]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanSubnetMask">Subnet Mask</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_SUBNET_MASK.WAN2]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanGateway">Gateway</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_GATE_WAY.WAN2]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanDNSServer">DNS Server</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_DNS_SERVER.WAN2]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanAlternateDNS">Alternate DNS</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_ALTERNATE_DNS.WAN2]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMacAddr">MAC Address</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_MAC_ADDR.WAN2]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMtu">MTU</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_MTU.WAN2]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMetric">Metric</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_METRIC.WAN2]; ?>
        </div>
    </div>

    <hr />
    <h3>WAN3</h3>
    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="connectionType">Connection Type</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[CONNECTION_TYPE.WAN3]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanIPAddr">IP Address</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_IP_ADDR.WAN3]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanSubnetMask">Subnet Mask</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_SUBNET_MASK.WAN3]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanGateway">Gateway</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_GATE_WAY.WAN3]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanDNSServer">DNS Server</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_DNS_SERVER.WAN3]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanAlternateDNS">Alternate DNS</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_ALTERNATE_DNS.WAN3]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMacAddr">MAC Address</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_MAC_ADDR.WAN3]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMtu">MTU</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_MTU.WAN3]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMetric">Metric</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_METRIC.WAN3]; ?>
        </div>
    </div>

    <hr />
    <h3>WAN4</h3>
    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="connectionType">Connection Type</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[CONNECTION_TYPE.WAN4]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanIPAddr">IP Address</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_IP_ADDR.WAN4]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanSubnetMask">Subnet Mask</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_SUBNET_MASK.WAN4]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanGateway">Gateway</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_GATE_WAY.WAN4]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanDNSServer">DNS Server</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_DNS_SERVER.WAN4]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanAlternateDNS">Alternate DNS</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_ALTERNATE_DNS.WAN4]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMacAddr">MAC Address</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_MAC_ADDR.WAN4]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMtu">MTU</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_MTU.WAN4]; ?>
        </div>
    </div>

    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="wanMetric">Metric</label>
        </div>
        <div class="form-item-input-text">
            <?= $data[WAN_METRIC.WAN4]; ?>
        </div>
    </div>

</div>

<div id='multiWanReportPolicyDiv' style="display: none">
    <h3>Policy Report</h3>
    <?php if(count($data[MULTI_WAN_POLICY_STATUS]) > 0) {
        foreach ($data[MULTI_WAN_POLICY_STATUS] as $key => $multiwanPolicy) { ?>
        <h5 style="line-height: 18px;"><?php echo $multiwanPolicy ?></h5>
    <?php }} else { ?>
        <h5>No Active Policies</h5>
    <?php } ?>
</div>

