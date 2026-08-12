<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

define('CONTROLLERS_FOLDER', 'controllers');
define('MODELS_FOLDER', 'models');
define('CONFIG_FOLDER', 'config');
define('LIBRARY_FOLDER', 'library');

define('BOOT_STRAP_FILE', 'bootstrap.php');
define('CONFIG_FILE', 'config.php');
define('ROUTER_FILE', 'router.php');

$url = substr($_SERVER[QUERY_STRING], 4);

require_once(ROOT . DS . CONFIG_FOLDER . DS . BOOT_STRAP_FILE);
?>

<html>
<head>
    <title><?php echo $titleName; ?></title>
</head>
</html>