<label>Ping</label>
<input type="text" name="ipAddr" value="<?= $data[IP_ADDRESS]; ?>" id="ipAddr">

<input type="button" name="btnStart" id="btnStart" value="Start" class="cta-button">

<br /><br />
<div id="waitMsg" style="display: none">Please wait for the ping results:</div>

<div id="results">
    <?php if (count($data[RESULTS]) > 0) { ?>
        <?php foreach ($data[RESULTS] as $key => $result) {
            echo $result . "<br />";
            ?>
        <?php }
    } ?>

</div>