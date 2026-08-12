<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <link rel="stylesheet" type="text/css" href="../../public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css">
    <script src="../../public/js/jquery.js"></script>
    <script src="../../public/js/helpmessage.js"></script>
    <script src="../../public/js/validation.js"></script>
    <script src="../../public/js/leftnav.js"></script>
    <script src="../../public/js/browser.js"></script>
    <script src="../../public/js/quicksetup.js"></script>
</head>

<body>

<?= $data[HEADER]; ?>

<div id="wrapper">

    <div id="content" class="clearfix">
        <?= $data[LEFT_NAV]; ?>

        <section id="main">
            <form method="post">
                <?= $data[QUICK_SETUP]; ?>
            </form>
        </section>

        <?= $data[HELP_MESSAGE]; ?>
    </div>

</div>

</body>
</html>

