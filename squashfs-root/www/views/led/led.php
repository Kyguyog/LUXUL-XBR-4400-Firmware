<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="../public/css/styles.css">
    <script src="../public/js/jquery.js"></script>
    <script src="../public/js/led.js"></script>
</head>
<body>


<?=$data['header'];?>

<div id="wrapper">

    <div id="content" class="clearfix">
        <?=$data['leftnav'];?>

        <section id="main">
            <form method="post" id='frmSettings'>
                <?= $data['led']; ?>
            </form>
        </section>
        <?=$data['helpMessage'];?>
    </div>

</div>

</body>
</html>