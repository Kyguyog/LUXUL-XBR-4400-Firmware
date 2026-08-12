<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css">
    <script src="../../public/js/jquery.js"></script>
    <script src="../../public/js/leftnav.js"></script>
    <script src="../../public/js/spin.js"></script>
    <script src="../../public/js/displayspin.js"></script>
    <script src="../../public/js/factoryprogress.js"></script>
</head>

<body>

<div id="wrapper" style="overflow: hidden; height: 6800px;">
    <h2>Restoring Factory Default is in Progress. Please Wait.</h2>

    <div id="defautingIndicator"></div>
</div>

<input type="hidden" id="rebootRequired" value="<?= $data[REBOOT_REQUIRED]; ?>">

</body>
</html>