<?php if ($data[IPERF_MSG] != EMPTY_STRING) { ?>
    <div id="noticeContainer">
        <div class="infoNotice" id="iperfMsg"><?= $data[IPERF_MSG]; ?></div>
    </div>
<?php } ?>


<h2>Iperf2 Server</h2>
<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="iperfStatus">Status</label>
    </div>
    <div class="form-item-input-text">
        <?= $data[IPERF_STATUS_VAL]; ?>
    </div>
</div>

<?php if (!$data[IPERF_STATUS]) { ?>
    <div class="form-item clearfix">
        <div class="form-item-label-text">
            <label for="runFor">Run for</label>
        </div>
        <div class="form-item-input-text">
            <select name="runFor" type="text" id="runFor" help="run_for_help">
                <?= $data[IPERF_HOURS_OPTIONS]; ?>
            </select>
        </div>
    </div>
<?php } ?>

<div class="form-item clearfix">
    <div class="form-item-label-text">
        <label for="runFor">Action </label>
    </div>
    <div class="form-item-input-text">
        <input type="submit" value="<?php echo !$data[IPERF_STATUS] ? "Start" : "Stop" ?> Iperf Server"
               name="<?php echo !$data[IPERF_STATUS] ? "btnStart" : "btnStop" ?>"
               id="<?php echo !$data[IPERF_STATUS] ? "btnStart" : "btnStop" ?>"/>
    </div>
</div>