<?php if ($data[FACTORY_DEFAULT_REQUIRED]) { ?>
    <div id="noticeContainer">
        <div class="infoNotice">You have successfully updated to the <?php echo $data[MODEL]; ?> 5.x version. The update process is about
            done.
            The final step is a factory default of the unit.
            This will ensure that all of the new functions and features in this firmware version operate correctly.
            This will reset the <?php echo $data[MODEL]; ?> IP address to 192.168.0.1 which may require a change to your connecting
            device's IP address. You may want to back up your config for reference as you setup the Updated <?php echo $data[MODEL]; ?>.  If you have questions about the update please contact Luxul Support @ 801-822-5450, Option 3
        </div>
    </div>
<?php } ?>

<form method="POST" id="backupform">
    <div class="backupOptions">
        <br/>

        <h2>Backup Configuration</h2>

        <div class="backupControl">
            <div class="form-item-label">
                <label class="narrow" for="backup">Save to File</label>
            </div>
            <div class="form-item-input">
                <input type="button" id="btnBackup" name="btnBackup" value="Backup" class="cta-button"/>
            </div>
        </div>
</form>
<br/>

<form method="POST" id="defaultsform">
    <div class="options">
        <br/>

        <h2>Factory Defaults</h2>

        <div id="noticeContainer">
            <div class="factoryNotice">Warning: Selecting the Reset button deletes all user configuration settings from this device.
                There is no confirmation dialog and the factory reset process will begin immediately. This process can not be
                undone, so please backup your configuration before you proceed.
            </div>
        </div>

        <br/>

        <div class="control">
            <div class="form-item-label">
                <label class="narrow" for="PASSWORD">Restore Factory Defaults</label>
            </div>
            <div class="form-item-input">
                <input type="submit" name="Default" value="Reset" class="cta-button"/>
            </div>
        </div>
</form>
