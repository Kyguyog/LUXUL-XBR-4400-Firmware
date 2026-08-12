<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css">
    <script src="../../public/js/jquery.js"></script>
    <script src="../../public/js/helpmessage.js"></script>
    <script src="../../public/js/leftnav.js"></script>
    <script src="../../public/js/validation.js"></script>
    <script src="../../public/js/routing.js"></script>
</head>
<body>

<?= $data[HEADER]; ?>

<div id="wrapper" style="max-width: 1300px;">

    <div id="content" class="clearfix" style="width: 1300px">
        <?= $data[LEFT_NAV]; ?>

        <section id="main" style="width: auto;float: none;">
            <form method="post" id='frmSettings'>
                <?= $data[ROUTING]; ?>
            </form>
        </section>

    </div>

</div>

</body>
</html>