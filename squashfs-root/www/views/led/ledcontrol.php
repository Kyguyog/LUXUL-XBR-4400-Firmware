<div id="noticeContainer">
<?php if($data['ledMessage']) {?>
    <div class="infoNotice" id="ledMsg">LEDs are now turned On</div>
<?php } else {?>
    <div class="infoNotice" id="ledMsg">LEDs are now turned Off</div>
<?php }?>
</div>

<h2>LED Control</h2>
<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="ledControl">Power and Radio LEDs</label>
    </div>
    <div class="form-item-input-text">
        <select name="ledControl" type="text" id="ledControl" help="led_control_help">
            <?= $data['ledStatusOptions']; ?>
        </select>
    </div>
</div>