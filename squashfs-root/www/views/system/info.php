<h2>System</h2>
<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="deviceName">Device Name</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[DEVICE_NAME]; ?>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="firmwareVersion">Firmware Version</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[FIRMWARE_VERSION]; ?><?php $commit = trim((string)@file_get_contents('/etc/luxul_commit')); if ($commit !== '') { ?> (<?=htmlspecialchars($commit);?>)<?php } ?>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="hardwareVersion">Hardware Version</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[VERSION]; ?>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="cpuUsage">CPU Usage</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[CPU_USAGE]; ?>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="memoryUsage">Memory Usage</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[MEMORY_USAGE]; ?>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="upTime">Up Time</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[UPTIME]; ?>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="currentTime">Current Date/Time</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[CURRENT_TIME]; ?>
    </div>
</div>

<h2>Internet / WAN Settings</h2>
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

<h2>Local Network / LAN Settings</h2>
<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="lanIPAddr">IP Address</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[LAN_IP_ADDR]; ?>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="lanSubnetMask">Subnet Mask</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[LAN_SUBNET_MASK]; ?>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="lanMacAddr">MAC Address</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[LAN_MAC_ADDR]; ?>
    </div>
</div>