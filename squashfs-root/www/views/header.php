<div class="header-back">
	<div class="header-back-left"></div>
	<div class="header-back-right">
        <p class="version-info">
            <span class="model-info">Model: <span id="version-model"><?=$data['model'];?><?=$data['version'];?></span></span><br>
            <span class="firm-info">Firmware Version: <span id="version-firmware"><?=$data['firmwareVersion'];?></span><?php $commit = trim((string)@file_get_contents('/etc/luxul_commit')); if ($commit !== '') { ?> <span id="version-commit">(<?=htmlspecialchars($commit);?>)</span><?php } ?></span>
        </p>
    </div>
</div>
<div id="wrapper">
	<header id="site-header">
		<img src="../../../public/img/logo.png" class="logo">
	</header>
