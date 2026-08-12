<h2>Static Leases<a id="static_lease_help" class="help-icon"></a></h2>

<h2>Discovered Clients</h2>
<?php if (count($data[ALL_CLIENTS_INFO]) > 0) { ?>
    <table class="data-grid" id="clients">
        <thead>
        <tr>
            <th style="width: 55%">Hostname</th>
            <th style="width: 20%">IP Address</th>
            <th style="width: 20%">MAC Address</th>
            <th style="width: 5%">Select</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data[ALL_CLIENTS_INFO] as $key => $clientInfo) { ?>
            <tr>
                <td><?php echo $clientInfo[HOST_NAME] ?></td>
                <td style="text-align: center"><?php echo $clientInfo[IP_ADDRESS] ?></td>
                <td style="text-align: center"><?php echo $clientInfo[MAC_ADDRESS] ?></td>
                <td style="text-align: center"><input type="checkbox" style="margin-bottom: 0"></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>No Current Static Leases.</p>
<?php } ?>

<div class="wizard-nav" style="margin-top: 50px">
    <input type="button" id="btnAll" class="cta-button" value="Select All"/>
    <input type="button" id="btnNone" class="cta-button" value="Unselect All"/>
    <input type="button" id="btnAddSSID" class="cta-button" value="Add"/>
</div>

<hr/>
<h2>Add Lease</h2>
<table class="data-grid" id="addSSID">
    <tr>
        <th style="width: 25%">Description</th>
        <th style="width: 20%">IP Address</th>
        <th style="width: 20%">Mac Address</th>
        <th>Modify</th>
    </tr>
    <tr style="text-align: center">
        <td><input type="text" style="width:95%" id="addDescription" maxlength="32" autocomplete="off"></td>
        <td><input type="text" id="addIPAddr" style="width: 95%" autocomplete="off"></td>
        <td><input type="text" id="addMacAddr" style="width: 95%" autocomplete="off"></td>
        <td><input id="add" type="button" class="cta-button" value="Add">&nbsp
            <input id="cancel" type="button" class="cta-button" value="Cancel">
        </td>
    </tr>
</table>

<br/><br/>
<hr/>

<h2>Static Assignments</h2>
<table class="data-grid" id="addTo">
    <thead>
    <tr>
        <th style="width: 25%">Description</th>
        <th style="width: 25%">Hostname</th>
        <th style="width: 15%">IP Address</th>
        <th style="width: 15%">Mac Address</th>
        <th>Modify</th>
    </tr>
    </thead>

    <?php foreach ($data[LEASE_CLIENTS_INFO] as $key => $clientInfo) { ?>
        <tr class="dataInput" style='text-align:center'>
            <td><?php echo $clientInfo[DESCRIPTION] ?></td>
            <td><?php echo $clientInfo[HOST_NAME] ?></td>
            <td><?php echo $clientInfo[IP_ADDRESS] ?></td>
            <td><?php echo $clientInfo[MAC_ADDRESS] ?></td>
            <td id="btnModify<?php echo $key ?>"></td>
        </tr>
    <?php } ?>
</table>

<div class="wizard-nav">
    <input type="button" name="btnApply" value="Apply" class="cta-button" id="btnApply">
    <input type="button" name="btnRefresh" value="Refresh" class="cta-button" id="Refresh">
</div>





