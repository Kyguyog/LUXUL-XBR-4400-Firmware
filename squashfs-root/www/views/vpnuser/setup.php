<h2><?= $data[VPN_MODE]; ?> User Configuration</h2>

<h2>Add User</h2>
<table class="data-grid" id="addSSID">
    <tr>
        <th style="width: 20%">Username</th>
        <th style="width: 50%">Password</th>
        <th style="width: 30%">Modify</th>
    </tr>
    <tr style='text-align:center'>
        <td><input type="text" style="width: 110px" id="addUsername"></td>
        <td><input type="text" style="width: 300px" id="addPassword"></td>
        <td><input id="add" type="button" class="cta-button" value="Add">&nbsp
            <input id="btnCancel" type="button" class="cta-button" value="Cancel">
        </td>
    </tr>
</table>

<br/><br/>
<hr/>

<h2>User List</h2>
<table class="data-grid" id="addTo">
    <thead>
    <tr>
        <th style="width: 20%">Username</th>
        <th style="width: 50%">Password</th>
        <th style="width: 30%">Modify</th>
    </tr>
    </thead>

    <?php if (count($data[VPN_USER_INFO]) > 0) {
        foreach ($data[VPN_USER_INFO] as $key => $userInfo) { ?>
            <tr class="dataInput" style='text-align:center'>
                <td><?php echo $userInfo[USER_NAME] ?></td>
                <td>
                    <?php
                    $length = strlen($userInfo[PASSWORD]);
                    echo str_repeat("*", $length);
                    ?>
                    <input type="hidden" id="password" value="<?= $userInfo[PASSWORD]; ?>"/>
                </td>
                <td id="btnModify<?php echo $key ?>"></td>
            </tr>
        <?php }
    } ?>
</table>

<div class="wizard-nav">
    <input type="button" name="btnApply" value="Apply" class="cta-button" id="btnApply">
    <input type="button" name="btnRefresh" value="Refresh" class="cta-button" id="Refresh">
</div>