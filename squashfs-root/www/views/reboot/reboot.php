<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css">
    <script src="../../public/js/jquery.js"></script>
    <script src="../../public/js/spin.js"></script>
    <script src="../../public/js/displayspin.js"></script>
    <script src="../../public/js/reboot.js"></script>
</head>

<body>

<?= $data[HEADER]; ?>
<div id="wrapper"  >

    <div id="content" class="clearfix">
        <section id="main" style="overflow: hidden; height: 6800px">
            <?= $data[REBOOT]; ?>
            <div id="rebootingIndicator"></div>
        </section>
    </div>
</div>

</body>
</html>

