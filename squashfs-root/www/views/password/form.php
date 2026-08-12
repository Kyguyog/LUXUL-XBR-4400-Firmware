<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>

<div class="options">
    <h2>Administrator Login</h2>

    <div class="control">
        <div class="form-item-label">
            <label class="narrow" for="PASSWORD">Password</label>
        </div>
        <div class="form-item-input">
            <input class="password" type="password" maxlength="64" id="new-password" name="new-password"
                   value="<?= $data[ADMIN_PASSWORD]; ?>">
        </div>
    </div>

    <div class="control">
        <div class="form-item-label">
            <label class="narrow" for="confirmation">Confirm Password</label>
        </div>
        <div class="form-item-input">
            <input class="password" type="password" id="confirmation" name="confirmation"
                   value="<?= $data[ADMIN_PASSWORD]; ?>">
        </div>
    </div>
</div>

<div class="wizard-nav">
    <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>