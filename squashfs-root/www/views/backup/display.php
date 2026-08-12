<?php if ($data[ERROR_DISPLAY]) {
    ?>
    <div id="noticeContainer">
        <div class="warningNotice" id="restoreError">
            <?= $data['errorMsg']; ?>
        </div>
    </div>
<?php } ?>

<?php if ($data[SUCCESS_DISPLAY]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice" id="restoreStatus">
            <?= $data[SUCCESS_MSG]; ?>
        </div>
    </div>
<?php } ?>

<form method="POST" id="defaultsform">
    <div class="options">
        <br/>

        <h2>Backup Configuration</h2>

        <div class="control">
            <div class="form-item-label">
                <label class="narrow" for="backup">Save to File</label>
            </div>
            <div class="form-item-input">
                <input type="button" id="btnBackup" name="btnBackup" value="Backup" class="cta-button"/>
            </div>
        </div>
</form>
<br/>
<hr/>
<form method="POST" enctype="multipart/form-data" id="restoreForm" action="/backup/display">
    <h2>Restore Configuration</h2>

    <div class="options">
        <div class="control">
            <label for="restoreFile" class="narrow">Select a File</label>
            <label class="fileLabel" id="fileLabel" for="restoreFile">Choose File</label>
            <input type="file" accept="text/file" class="file" name="restoreFile" id="restoreFile"/>

            <div id="invalid_file" style="display: none;">
                <div class="restoreError">
                    This is not a Luxul firmware file. File must have .lxc extension.
                </div>
            </div>
        </div>
        <div class="control">
            <label for="restore" class="narrow">Upload Configuration</label>
            <input name="restore" type="submit" id="restore" value="Restore" class="cta-button"/>
        </div>
    </div>
</form>
<br/>
<hr/>