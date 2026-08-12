<?php if ($data[TIMEZONE_FLAG] == TIMEZONE_FLAG_YES) { ?>
    <div id="noticeContainer">
        <div class="infoNotice" id="iperfMsg">Time Zone has changed.</div>
    </div>
<?php } ?>

<h2>AP Time Setup</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="currentTime">Current Date/Time</label> :
    </div>
    <div class="form-item-input-text" style="width: inherit">
        <?= $data[CURRENT_TIME]; ?>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="timeZoneOptions">Time Zone</label> :
    </div>
    <div class="form-item-input">
        <select name="timeZoneOptions" type="text" id="timeZoneOptions">
            <?= $data[TIMEZONE_OPTIONS]; ?>
        </select>
    </div>
</div>

<div class="wizard-nav">
    <input type="submit" name="btnApply" id="btnApply" value="Apply" class="cta-button">
    <input type="submit" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>
