<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css">
    <script src="../../public/js/jquery.js"></script>
    <script src="../../public/js/leftnav.js"></script>
    <script src="../../public/js/compliance.js"></script>
</head>

<body>
<?= $data[HEADER]; ?>

<div id="wrapper">
    <div id="content" class="clearfix">
        <?= $data[LEFT_NAV]; ?>

        <section id="main">
            <?= $data[COMPLIANCE]; ?>
        </section>
    </div>
</div>

</body>
</html>
