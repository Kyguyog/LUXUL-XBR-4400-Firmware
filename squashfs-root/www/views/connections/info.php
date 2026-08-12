<h2>Connected Clients </h2>
<div class="connected-clients-div">
    <select name="connectedClientsOptions" type="text" id="connectedClientsOptions">
        <?= $data[CONNECTED_CLIENTS_OPTIONS]; ?>
    </select>
</div>

<div id="allClientsDiv" style="display: none">
    <h2>Discovered Clients</h2>
    <?php if (count($data[ALL_CLIENTS_INFO]) > 0) { ?>
        <table class="data-grid" id="allClients">
            <thead>
            <tr>
                <th style="width:50%">Device Name</th>
                <th style="width:25%" id="allIPAddress">IP Address</th>
                <th style="width:25%">MAC Address</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data[ALL_CLIENTS_INFO] as $key => $clientInfo) { ?>
                <tr>
                    <td><?php echo $clientInfo[HOST_NAME] ?></td>
                    <td style="text-align: center"><?php echo $clientInfo[IP_ADDRESS] ?></td>
                    <td style="text-align: center"><?php echo $clientInfo[MAC_ADDRESS] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No other devices detected on the network or DHCP addresses requested.</p>
    <?php } ?>
</div>

<div id="dhcpClientsDiv" style="display: none">
    <h2>DHCP Clients</h2>
    <?php if (count($data[DHCP_CLIENTS_INFO]) > 0) { ?>
        <h3>Active Leases: <?php echo count($data[DHCP_CLIENTS_INFO]) ?></h3>

        <table class="data-grid" id="dhcpClients">
            <thead>
            <tr>
                <th style="width:50%">Device Name</th>
                <th style="width:25%" id="dhcpIPAddress">IP Address</th>
                <th style="width:25%">MAC Address</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data[DHCP_CLIENTS_INFO] as $key => $dhcpClientInfo) { ?>
                <tr>
                    <td><?php echo $dhcpClientInfo[DEVICE_NAME] ?></td>
                    <td style="text-align: center"><?php echo $dhcpClientInfo[IP_ADDRESS] ?></td>
                    <td style="text-align: center"><?php echo $dhcpClientInfo[MAC_ADDRESS] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>A list of Connected Clients is not available due to the DHCP server being disabled or there are no connected
            clients.</p>
    <?php } ?>
</div>

<div class="wizard-nav">
    <input type="submit" name="btnRefresh" value="Refresh" class="cta-button">
</div>
