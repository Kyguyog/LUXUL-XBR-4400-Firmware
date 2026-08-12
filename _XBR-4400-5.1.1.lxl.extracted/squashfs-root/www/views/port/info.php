<h2>Port State Overview</h2>

<img src="../../public/img/ports.png" id="portImg">

<input type="button" name="btnRefresh" value="Refresh" class="cta-button" id="Refresh" style="margin-left: 68%">

<?php if ($data[WAN_PORT_STATE] == 'green') {
    ?>
    <input type="button" name="wanBtn" id="wanBtn" value="" class="greenPort">
<?php } else if ($data[WAN_PORT_STATE] == 'yellow') { ?>
    <input type="button" name="wanBtn" id="wanBtn" value="" class="yellowPort">
<?php } else if ($data[WAN_PORT_STATE] == 'blue') { ?>
    <input type="button" name="wanBtn" id="wanBtn" value="" class="bluePort">
<?php } ?>

<?php if ($data[LAN_PORT1_STATE] == 'green') {
    ?>
    <input type="button" name="lanPort1Btn" id="lanPort1Btn" value="" class="greenPort">
<?php } else if ($data[LAN_PORT1_STATE] == 'yellow') { ?>
    <input type="button" name="lanPort1Btn" id="lanPort1Btn" value="" class="yellowPort">
<?php } else if ($data[LAN_PORT1_STATE] == 'blue') { ?>
    <input type="button" name="lanPort1Btn" id="lanPort1Btn" value="" class="bluePort">
<?php } ?>

<?php if ($data[LAN_PORT2_STATE] == 'green') {
    ?>
    <input type="button" name="lanPort2Btn" id="lanPort2Btn" value="" class="greenPort">
<?php } else if ($data[LAN_PORT2_STATE] == 'yellow') { ?>
    <input type="button" name="lanPort2Btn" id="lanPort2Btn" value="" class="yellowPort">
<?php } else if ($data[LAN_PORT2_STATE] == 'blue') { ?>
    <input type="button" name="lanPort2Btn" id="lanPort2Btn" value="" class="bluePort">
<?php } ?>

<?php if ($data[LAN_PORT3_STATE] == 'green') {
    ?>
    <input type="button" name="lanPort3Btn" id="lanPort3Btn" value="" class="greenPort">
<?php } else if ($data[LAN_PORT3_STATE] == 'yellow') { ?>
    <input type="button" name="lanPort3Btn" id="lanPort3Btn" value="" class="yellowPort">
<?php } else if ($data[LAN_PORT3_STATE] == 'blue') { ?>
    <input type="button" name="lanPort3Btn" id="lanPort3Btn" value="" class="bluePort">
<?php } ?>

<?php if ($data[LAN_PORT4_STATE] == 'green') {
    ?>
    <input type="button" name="lanPort4Btn" id="lanPort4Btn" value="" class="greenPort">
<?php } else if ($data[LAN_PORT4_STATE] == 'yellow') { ?>
    <input type="button" name="lanPort4Btn" id="lanPort4Btn" value="" class="yellowPort">
<?php } else if ($data[LAN_PORT4_STATE] == 'blue') { ?>
    <input type="button" name="lanPort4Btn" id="lanPort4Btn" value="" class="bluePort">
<?php } ?>

<br/><br/>
<div id="wanPortInfoDiv" class="portInfo" style="display: none">
    <?php echo array_pop($data[WAN_PORT_INFO]); ?>
    <br/><br/>
    <?php
    foreach (array_slice($data[WAN_PORT_INFO], 1, -1) as $key => $value)
        echo $value . "<br />";
    ?>
</div>

<div id="lanPort1InfoDiv" class="portInfo" style="display: none">
    <?php echo array_pop($data[LAN_PORT1_INFO]); ?>
    <br/>
    <?php echo array_pop($data[LAN_PORT1_INFO]); ?>
    <br/><br/>
    <?php
    foreach (array_slice($data[WAN_PORT_INFO], 1, -1) as $key => $value)
        echo $value . "<br />";
    ?>
</div>

<div id="lanPort2InfoDiv" class="portInfo" style="display: none">
    <?php echo array_pop($data[LAN_PORT2_INFO]); ?>
    <br/>
    <?php echo array_pop($data[LAN_PORT2_INFO]); ?>
    <br/><br/>
    <?php
    foreach (array_slice($data[LAN_PORT2_INFO], 1, -1) as $key => $value)
        echo $value . "<br />";
    ?>
</div>

<div id="lanPort3InfoDiv" class="portInfo" style="display: none">
    <?php echo array_pop($data[LAN_PORT3_INFO]); ?>
    <br/>
    <?php echo array_pop($data[LAN_PORT3_INFO]); ?>
    <br/><br/>
    <?php
    foreach (array_slice($data[LAN_PORT3_INFO], 1, -1) as $key => $value)
        echo $value . "<br />";
    ?>
</div>

<div id="lanPort4InfoDiv" class="portInfo" style="display: none">
    <?php echo array_pop($data[LAN_PORT4_INFO]); ?>
    <br/>
    <?php echo array_pop($data[LAN_PORT4_INFO]); ?>
    <br/><br/>
    <?php
    foreach (array_slice($data[LAN_PORT4_INFO], 1, -1) as $key => $value)
        echo $value . "<br />";
    ?>
</div>
