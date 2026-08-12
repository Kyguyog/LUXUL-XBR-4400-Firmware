<?php if ($data[REBOOT_REQUIRED]) {
    ?>
    <div id="noticeContainer">
        <div class="infoNotice">Changes Saved</div>
        <div class="warningNotice">You must reboot before your changes will take effect</div>
    </div>
<?php } ?>


<h2>Multi-WAN Settings</h2>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="multiWanStatus">Multi-WAN</label>
        <a id="multi_wan_status_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="multiWanStatus" type="text" id="multiWanStatus" help="multi_wan_status_help">
            <?= $data[MULTI_WAN_STATUS_OPTIONS]; ?>
        </select>
    </div>
</div>

<hr/>
<?php if ($data[MULTI_WAN_WIZARD_STATUS] == MULTI_WAN_WIZARD_STATUS_1) { ?>
    <div id="multiWanEnabledDiv">
        <h2>Multi-WAN List</h2>

        <div class="form-item clearfix">
            <div class="form-item-label">
                <label for="multiWan">WAN</label>
                <a id="multi_wan_help" class="help-icon"></a>
            </div>
            <input type="button" id="btnMultiWan" value="Edit WAN" class="cta-button edit">
        </div>

        <div class="form-item clearfix">
            <div class="form-item-label">
                <label for="multiWan2">WAN2</label>
                <a id="multi_wan2_help" class="help-icon"></a>
            </div>
            <input type="button" id="btnMultiWan2" value="Edit WAN2" class="cta-button edit">
        </div>

        <div class="form-item clearfix">
            <div class="form-item-label">
                <label for="multiWan3">WAN3</label>
                <a id="multi_wan3_help" class="help-icon"></a>
            </div>
            <?php if ($data[WAN . WAN3]) { ?>
                <input type="button" id="btnMultiWan3" value="Edit WAN3" class="cta-button edit">

                <?php if (!$data[WAN . WAN4]) { ?>
                    <input type="button" id="btnMultiWan3" value="Delete WAN3" class="cta-button delete">
                <?php } ?>

            <?php } else { ?>
                <input type="button" id="btnMultiWan3" value="ADD WAN3" class="cta-button add">
            <?php } ?>
        </div>

        <?php if ($data[WAN . WAN3]) { ?>
            <div class="form-item clearfix">
                <div class="form-item-label">
                    <label for="multiWan4">WAN4</label>
                    <a id="multi_wan4_help" class="help-icon"></a>
                </div>

                <?php if ($data[WAN . WAN4]) { ?>
                    <input type="button" id="btnMultiWan4" value="Edit WAN4" class="cta-button edit">
                    <input type="button" id="btnMultiWan4" value="Delete WAN4" class="cta-button delete">
                <?php } else { ?>
                    <input type="button" id="btnMultiWan4" value="ADD WAN4" class="cta-button add">
                <?php } ?>
            </div>
        <?php } ?>


        <hr/>
        <h2>Multi-WAN Default Policy</h2>

        <div class="form-item clearfix">
            <div class="form-item-label">
                <label for="multiWanPolicyOptions">Policy</label>
                <a id="multi_wan_policy_options_help" class="help-icon"></a>
            </div>
            <div class="form-item-input">
                <select name="multiWanPolicyOptions" type="text" id="multiWanPolicyOptions"
                        help="multi_wan_policy_options_help">
                    <?= $data[MULTI_WAN_POLICY_OPTIONS]; ?>
                </select>
            </div>
        </div>

    </div>

<?php } ?>

<input type="hidden" id="multiWanWizardStatus" value="<?= $data[MULTI_WAN_WIZARD_STATUS]; ?>">
<input type="hidden" id="multiWan3Status" value="<?= $data[WAN . WAN3]; ?>">
<input type="hidden" id="multiWan4Status" value="<?= $data[WAN . WAN4]; ?>">

<div class="wizard-nav">
    <input type="submit" name="btnSave" id="btnSave" value="Save" class="cta-button">
    <?php if ($data[MULTI_WAN_WIZARD_STATUS] == MULTI_WAN_WIZARD_STATUS_1 || $data[MULTI_WAN_WIZARD_STATUS] == MULTI_WAN_WIZARD_STATUS_0) { ?>
        <input type="submit" name="btnReboot" id="btnReboot" value="Reboot" class="cta-button">
    <?php } ?>
    <input type="submit" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>

