<?php if ($data[ERROR_DISPLAY]) {
    ?>
    <div id="noticeContainer">
        <div class="errorNotice" id="upgradeError">
            <?= $data[ERROR_MSG]; ?>
        </div>
    </div>
<?php } ?>

<?php if ($data[SUCCESS_DISPLAY]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice" id="upgrade_status">
            <?= $data[SUCCESS_MSG]; ?>
        </div>
    </div>
<?php } ?>

<form method="POST" enctype="multipart/form-data" id="upgradeForm" action="/upgrade/display">
    <h2>Firmware Update </h2>

    <div class="options">
        <div class="control">
            <label for="apFirmware" class="narrow">Select File</label>
            <label class="fileLabel" id="fileLabel" for="apFirmware">Choose File</label>
            <input type="file" accept="text/file" class="file" name="apFirmware" id="apFirmware"/>

            <div id="invalid_file" style="display: none;">
                <div class="upgradeError">
                    This is not a Luxul firmware file. File must have .lxl extension.
                </div>
            </div>
        </div>
        <div class="control">
            <label for="upgrade" class="narrow">Start Update</label>
            <input name="upgrade" type="submit" id="upgrade" value="Update" class="cta-button"/>
        </div>
        <br/><br/><br/><br/>
    </div>
</form>