<?php
function create_mac($base_mac,$offset) {
	$new_macd = hexdec(str_replace(":","",substr($base_mac,9)));
	$new_macd += $offset;
	$new_mac = str_pad(dechex($new_macd),6,"0",STR_PAD_LEFT);
	$new_mac = substr_replace($new_mac,":",2,0);
	$new_mac = substr_replace($new_mac,":",5,0);
	return $new_mac;
}


exec("nvram get board_id",$board_id);
switch ($board_id[0]) {
        case 'luxul_abr4500_v1':
        case 'luxul_xbr4500_v1':
                $radio = false;
                $dual_band = false;
                $has_usb = true;
                break;
	case 'luxul_xap1240_v1':
		$r0_loc = "sb/1/macaddr";
		$radio = true;
		$dual_band =false;
		$has_usb = false;
		exec("echo timer > /sys/class/leds/bcm47xx\:green\:system/trigger");
		exec("echo timer > /sys/class/leds/bcm47xx\:green\:bridge/trigger");
		exec("echo timer > /sys/class/leds/bcm47xx\:blue\:2ghz/trigger");
		break;
	case 'luxul_xap1410_v1':
		$r0_loc = "0:macaddr";
		$r1_loc = "1:macaddr";
		$r1_offset = 8;
		$radio = true;
		$dual_band = true;
		$has_usb = false;
		break;
	case 'luxul_xap1510_v1':
		$r0_loc = "0:macaddr";
		$r1_loc = "1:macaddr";
		$r1_offset = 8;
		$radio = true;
		$dual_band = true;
		$has_usb = false;
		break;
	case 'luxul_xwr1750_v1':
		$r0_loc = "0:macaddr";
		$r1_loc = "1:macaddr";
		$r1_offset = 5;
		$radio = true;
		$dual_band = true;
		$has_usb = true;
		$usb_port = 3;
		break;
	case 'luxul_xwr1200_v1':
		$r0_loc = "0:macaddr";
		$r1_loc = "1:macaddr";
		$r1_offset = 8;
		$radio = true;
		$dual_band = true;
		$has_usb = true;
		$usb_port = 3;
		break;
	case 'luxul_xwr3100_v1':
		$r0_loc = "1:macaddr";
		$r1_loc = "0:macaddr";
		$r1_offset = 8;
		$radio = true;
		$dual_band = true;
		$has_usb = true;
		$usb_port = 3;
		break;
	case 'luxul_xwr600_v1':
	case 'luxul_xwr600_v2':
		$r0_loc = "0:macaddr";
		$r1_loc = "sb/1/macaddr";
		$r1_offset = 4;
		$radio = true;
		$dual_band = true;
		$has_usb = true;
		$usb_port = 0;
		break;
	case 'luxul_xap1500_v1':
		$r0_loc = "pci/1/1/macaddr";
		$r1_loc = "pci/2/1/macaddr";
		$r1_offset = 8;
		$radio = true;
		$dual_band = true;
		$has_usb = false;
		break;
	case 'luxul_xap1210_v1':
	case 'luxul_xap1230_v1':
	case 'luxul_xap310_v1':
		$r0_loc = "sb/1/macaddr";
		$radio = true;
		$dual_band =false;
		$has_usb = false;
		break;
	case 'luxul_xvwp30_v1':
		$r0_loc = "sb/1/macaddr";
		$radio = true;
		$dual_band = false;
		$has_usb = false;
		exec("echo default-on > /sys/class/leds/bcm47xx:green:link/trigger");
		break;
	case 'luxul_abr4400_v1':
	case 'luxul_xbr4400_v1':
		$radio = false;
		$dual_band = false;
		$has_usb = true;
		break;
	default:
		break;
}

if( isset($_POST['modify']) ){
	//Re-build the torn apart MAC address...
	$rebuiltMAC = "";
	$values = $_POST['new_mac'];
	for($i=0; $i < 6; $i++){
		$rebuiltMAC .= $values[$i];
		if( ($i + 1) == 6 ){
			break;
		}else{
			$rebuiltMAC .= ":";
		}
	}

	if( isset($_POST['fdefault']) ){
		//Factory Default Unit
		exec("echo 'y' | firstboot");
	}

	$rebuiltMAC = str_replace(' ','',$rebuiltMAC);
	// validate mac address
	if( preg_match('/^[0-9a-fA-F]{2}(?=([:]?))(?:\\1[0-9a-fA-F]{2}){5}$/',$rebuiltMAC) ){
		// set the LAN MAC
		exec("envram set et0macaddr=".$rebuiltMAC,$o,$ret0);

		$OUI = substr($rebuiltMAC,0,9);

		// set the wl0 MAC
		if ($radio) {
			$wl0_mac = $OUI.create_mac($rebuiltMAC,1);
			exec("envram set ".$r0_loc."=".$wl0_mac,$o,$ret1);

			$ret2 = 0;
		}
		if ($dual_band) {
			// set the wl1 MAC
			$wl1_mac = $OUI.create_mac($rebuiltMAC,$r1_offset);
			exec("envram set ".$r1_loc."=".$wl1_mac,$o,$ret2);
		}

		if( $ret0 || $ret1 || $ret2 ){
			$msg = "Failed to update";
		}else{
			$msg = "MAC addresses have been updated";
			exec("envram commit > /dev/null 2>&1");
			exec("/sbin/nvram_clr.sh force");
		}
	}else{
		$msg = "Your MAC address is not formatted correctly";
	}

}

// get current MAC
exec("envram get et0macaddr",$mac);
exec("uci get luxul.static.hw_model",$hw_model);
exec("uci get luxul.static.hw_version",$hw_version);
exec("uci get luxul.static.fw_version",$fw_version);
if ($board_id = 'luxul_xap1510_v1' || 'luxul_xap1410_v1'){
		exec("envram get 1:macaddr",$fiveg_mac);
		exec("envram get 0:macaddr",$twofourg_mac);
	}else{
		exec("envram get 0:macaddr",$fiveg_mac);
		exec("envram get 1:macaddr",$twofourg_mac);
	}
exec("nvram get 0:ccode",$reg_domain);

// get USB info
if ($has_usb) {
	exec("nvram get board_id",$board_id);
	$usbinfo;
	exec("lsusb > /tmp/lsusb.tmp");
	$usb_file = file_get_contents('/tmp/lsusb.tmp');
	$usb_file = trim($usb_file);
	$devs = explode("\n", $usb_file);
	foreach($devs as $dev => $data)
	{
		if (!$data) continue;
		$dev_data = explode(' ', $data);
		switch ($board_id[0]) {
                        case 'luxul_abr4500_v1':
			case 'luxul_xbr4500_v1':
                                if ($dev_data[5] != '1d6b:0003' && $dev_data[5] != '1d6b:0002' && $dev_data[5] != '1d6b:0001')
                                {
                                        $usbinfo = $dev_data[6].' '.$dev_data[5];
                                }
                                break;
			case 'luxul_xwr3100_v1':
				if ($dev_data[5] != '1d6b:0003' && $dev_data[5] != '1d6b:0002' && $dev_data[5] != '1d6b:0001')
				{
					$usbinfo = $dev_data[6].' '.$dev_data[5];
				}
				break;
			case 'luxul_xwr1200_v1':
				if ($dev_data[5] != '1d6b:0002' && $dev_data[5] != '1d6b:0001')
				{
					$usbinfo = $dev_data[6].' '.$dev_data[5];
				}
				break;
			case 'luxul_xwr1750_v1':
			case 'luxul_xbr4400_v1':
			case 'luxul_abr4400_v1':
				if ($dev_data[5] != '05e3:0608' && $dev_data[5] != '1d6b:0001')
				{
					$usbinfo = $dev_data[6].' '.$dev_data[5];
				}
				break;
			case 'luxul_xwr600_v1':
			case 'luxul_xwr600_v2':
				if ($dev_data[5] != '0a5c:bd17' && $dev_data[5] != '1d6b:0002')
				{
					$usbinfo = $dev_data[6].' '.$dev_data[5]; 
				}
				break;
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD html 1.0 Transitional//EN" "http://www.w3.org/TR/html/DTD/html-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Luxul - Simply Connected</title>
	<!--	<link type="text/css" rel="stylesheet" href="public/css/reset.css" />-->
	<!--	<link type="text/css" rel="stylesheet" href="public/css/styles.css" />-->
	<style>
		div.usb {
			clear: left;
			width: 380px;
			margin: 0px;
			padding: 10px;
		}
		.success{
			border: 6px solid green;
			background-color: white;
			color: black;
			padding: 10px;
			text-align: center;
			padding-left: 0px;
			padding-bottom: 10px;
			font-weight: 900;
			font-size: 20px;
			font-family: courier new;
		}
		.error {
			margin-left: -3px;
		}
		.error p {
			background-color: red;
			color: white;
			padding: 10px;
			text-align: center;
			padding-left: 0px;
			font-weight: 900;
			font-size: 20px;
			font-family: courier new;
		}

		html,body {
			height:100%;
			padding:0;
			position: relative;
			min-width: 1140px;
		}

		/* --------GENERAL STYLING-------- */
		body {
			color: #000;
			font-family: Helvetica, Arial, sans-serif;
			font-size: 13px;
		}
		/* --------HEADER-------- */
		#site-header  {
			height: 98px;
			padding: 0 20px;
		}

		#site-header .logo {
			margin-top: 28px;
			margin-left: 28%;
		}

		.header-back .header-back-right .version-info {
			position: relative;
			color: #fff;
			margin-right: 90%;
			margin-top: 52px;
			text-align: right;
			line-height: 16px;
			width: 275px;
		}

		#site-header .version-info {
			color: #fff;
			float: right;
			margin: 0px;
			margin-top: 52px;
			text-align: right;
			line-height: 16px
		}

		#site-header .version-info .model-info {
			font-size: 15px;
		}
		#site-header .version-info .firm-info {
			font-size: 12px;
		}
		#site-header .version-info span.firmInfo{
			font-size:13px;
		}

		.header-back {
			height: 98px;
			overflow: hidden;
			position: absolute;
			top: 0px;
			width: 100%;
			z-index: -1;
		}

		.header-back .header-back-left {
			background: #000;
			-moz-border-radius-bottomright: 6px;
			-webkit-border-bottom-right-radius: 6px;
			border-bottom-right-radius: 6px;
			height: 100%;
			margin-right: -260px;
			position: absolute;
			right: 50%;
			width: 100%;
		}

		.header-back .header-back-right {
			background: #81c341;
			-moz-border-radius-bottomleft: 6px;
			-webkit-border-bottom-left-radius: 6px;
			border-bottom-left-radius: 6px;
			height: 100%;
			margin-left: 270px;
			position: absolute;
			left: 50%;
			width: 100%;
		}

		/* --------CONTENT-------- */
		#wrapper {
			margin: auto;
			padding-bottom: 42px;
			position: relative;
			max-width: 1140px;
		}
		#content {
			background: #fff;
			padding: 0 10px;
			padding-bottom: 28px;
		}

		#main {
			float: left;
			margin-left:  340px;
			width: 740px;
			overflow:auto;
			margin-top: 25px;
		}

		.button-container{
			width:135%;
			margin:10px 0;
			padding:10px 0;
		}

		.button-container-usb {
			float: left;
			margin-left: 170px;
			margin-top: 0px;
		}

		.form-item {
			clear: both;
			margin-bottom: 8px;
			padding-left: 15%;
			float: left;
			margin-left: -130px;
		}

		.form-item-label {
			float: left;
			line-height: 22px;
			text-align: right;
			width: 188px;
		}

		.form-item-input {
			float: left;
			width: 184px;
		}


	</style>
	<script type='text/javascript' src='public/js/jquery.js' /></script>
	<script language="Javascript">
		$(document).ready(function(){
			$("#refresh").click(function(){
				location.reload();
			});

		});
	</script>
</head>

<body>
<div class="header-back">
	<div class="header-back-left"></div>
	<div class="header-back-right"></div>
</div>
<div id="wrapper">
	<header id="site-header">
		<img src="public/img/logo.png" class="logo">
		<p class='version-info'>
			<span id='version-model'><?php print("Model: ".$hw_model[0]." ".$hw_version[0]); ?></span>
			<br>
			<span class='firmInfo'>
			<span id='version-firmware'><?php print("Firmware version: ".$fw_version[0]); ?></span>
			</span>
		</p>
	</header>
	<div id="content" class="clearfix">
		<section id="main">
			<form method="POST">

				<?php if($board_id[0] == 'luxul_xap1510_v1' ||	'luxul_xap1410_v1') { ?>
					<span class='RegInfo'>
						<h3 font-size: 14px; <span id='version-regulatory'><?php print("WLAN Domain: ".$reg_domain[0]); ?></span></h3>
					</span>
				<?php } ?>


				<h2 style='padding-top: 10px;font-size: 16px;'>MAC Addresses</h2>

				<?php if($board_id[0] == 'luxul_xap1510_v1' ||	'luxul_xap1410_v1') { ?>
					<div class="form-item clearfix">
						<div class="form-item-label">
							<label style='padding-right:7px'>5GHz MAC Address</label>
						</div>
						<div class="form-item-input">
							<?php
							$arr = explode(':',$fiveg_mac[0]);
							for($i=0;$i < 6;$i++){
								print("
								<input type='text' name='new_mac[]' disabled='disabled' value='" . $arr[$i] . "' " .
									"style='width:20px;text-align:center' maxlength=2 />"
								);
							}
							?>
						</div>
					</div>

					<div class="form-item clearfix">
						<div class="form-item-label">
							<label style='padding-right:7px'>2.4GHz MAC Address</label>
						</div>
						<div class="form-item-input">
							<?php
							$arr = explode(':',$twofourg_mac[0]);
							for($i=0;$i < 6;$i++){
								print("
								<input type='text' name='new_mac[]' disabled='disabled' value='" . $arr[$i] . "' " .
									"style='width:20px;text-align:center' maxlength=2 />"
								);
							}
							?>
						</div>
					</div>
				<?php } ?>

				<div class="form-item clearfix">
					<div class="form-item-label">
						<label style='padding-right:7px'>Current LAN MAC Address</label>
					</div>
					<div class="form-item-input">
						<?php
						$arr = explode(':',$mac[0]);
						for($i=0;$i < 6;$i++){
							print("
							<input type='text' name='new_mac[]' disabled='disabled' value='" . $arr[$i] . "' " .
								"style='width:20px;text-align:center' maxlength=2 />"
							);
						}
						?>
					</div>
				</div>

				<div class="form-item clearfix">
					<div class="form-item-label">
						<label style='padding-right:7px'>New LAN MAC Address</label>
					</div>
					<?php
					$arr = explode(':',$mac[0]);
					for($i=0;$i < 6;$i++){
						print("
							<input type='text' name='new_mac[]' value='" . $arr[$i] . "' " .
							"style='width:20px;text-align:center' maxlength=2 />"
						);
					}
					?>
					<div class="button-container" align="center">
						<input type="submit" name="modify" value="Modify">
						<input type="submit" name="cancel" value="Cancel">
					</div>
					<p align='center'>
						<?php if(isset($msg)){
							echo $msg;
						}
						?>
					</p>
				</div>

				<!-- USB SETTINGS -->
				<div class="usb" <?php if ($has_usb == true) print("style='clear:both;'>");
				else print("style='display:none;'>");
				?>
				<hr>
				<h2 style='padding-top: 10px;font-size: 16px;'>USB Port Testing</h2>
				<?php
				if( strlen($usbinfo) == 0 ||  $usbinfo === null ){
					?>
					<div class="error">
						<p>No USB device found</p>
					</div>
					<?php
				}else{
					?>
					<div class="success">
						<?php
						print($usbinfo);
						?>
					</div>
					<p> </p>
					<?php
				}
				?>
				<div class="button-container-usb" <?php if ($has_usb == false) print("style='display:none;'"); ?> >
					<input type="submit" name="refresh" value="Refresh">
				</div>
				</div>

				<div class="usb">
				<?php
				?>
				<hr>
				<h2 style='padding-top: 10px;font-size: 16px;'>Factory Default</h2>
				<div class="button-container-usb" align="center">
					<input type="submit" name="fdefault" value="Factory Default">
				</div>
				</div>
			</div>
			</form>
		<?php
		if(isset($_POST['fdefault'])){
			shell_exec('echo "y" | firstboot');
		}
		?>
	</section>
	</div>
</div>
</body>
</html>
