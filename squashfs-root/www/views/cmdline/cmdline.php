<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css">
    <script src="../../public/js/jquery.js"></script>
    <script src="../../public/js/helpmessage.js"></script>
    <script src="../../public/js/leftnav.js"></script>
    <script src="../../public/js/cmdline.js"></script>
</head>

<body>

<?= $data[HEADER]; ?>

<div id="wrapper">

    <div id="content" class="clearfix">
        <?= $data[LEFT_NAV]; ?>

        <section id="main">
            <form method="post" action="/cmdline/display">
                <?= $data[CMDLINE]; ?>
            </form>
        </section>

        <?= $data[HELP_MESSAGE]; ?>
    </div>

</div>

</body>
</html>

