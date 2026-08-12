<?php

/** Check if environment is development and system errors **/
function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT_TRUE == TRUE) {
        error_reporting(E_ALL);
        ini_set(DISPLAY_ERRORS, ERRORS_ON);
    } else {
        error_reporting(E_ALL);
        ini_set(DISPLAY_ERRORS, ERRORS_OFF);
        ini_set(LOG_ERRORS, ERRORS_ON);
        ini_set(ERROR_LOG, ROOT . DS . TEMP_FOLDER . DS . LOGS_FOLDER . DS . ERROR_LOG_FILE);
    }
}

/** Check for Magic Quotes and remove them **/
function stripSlashesDeep($value) {
    $value = is_array($value) ? array_map(STRIP_SLASHES_DEEP, $value) : stripslashes($value);
    return $value;
}


function removeMagicQuotes() {
    if (get_magic_quotes_gpc()) {
        $_GET = stripSlashesDeep($_GET);
        $_POST = stripSlashesDeep($_POST);
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

/** Check register globals and remove them **/
function unregisterGlobals() {
    if (ini_get(REGISTER_GLOBALS)) {
        $array = array(SESSION_ARRAY, POST_ARRAY, GET_ARRAY, COOKIE_ARRAY, REQUEST_ARRAY, SERVER_ARRAY, ENV_ARRAY, FILES_ARRAY);
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Automatically includes files containing classes that are called **/
function __autoload($className) {
    if (file_exists(ROOT . DS . CONTROLLERS_FOLDER . DS . strtolower($className) . PHP_EXTENSION)) {
        require_once(ROOT . DS . CONTROLLERS_FOLDER . DS . strtolower($className) . PHP_EXTENSION);
    } else if (file_exists(ROOT . DS . MODELS_FOLDER . DS . strtolower($className) . PHP_EXTENSION)) {
        require_once(ROOT . DS . MODELS_FOLDER . DS . strtolower($className) . PHP_EXTENSION);
    } else if (file_exists(ROOT . DS . LIBRARY_FOLDER . DS . strtolower($className) . PHP_EXTENSION)) {
        require_once(ROOT . DS . LIBRARY_FOLDER . DS . strtolower($className) . PHP_EXTENSION);
    } else if (file_exists(ROOT . DS . CONFIG_FOLDER . DS . strtolower($className) . PHP_EXTENSION)) {
        require_once(ROOT . DS . CONFIG_FOLDER . DS . strtolower($className) . PHP_EXTENSION);
    } else {
        print_r(ERROR_MESSAGE . $className . CLASS_NOT_FOUND_ERROR);
    }
}

/** Main Call Function **/
function callHook() {
    global $url;

    if (!isset($url) || $url == EMPTY_STRING) {
        $controllerName = DEFAULT_CONTROLLER;
        $action = DEFAULT_ACTION;
        header(LOCATION . DS . $controllerName . DS . $action);

    } else {
        if (strpos($url, OLD_FIRMWARE_URL)) {
            $controllerName = FACTORY;
            $action = DISPLAY;

            header(LOCATION . DS . $controllerName . DS . $action);
        } else {
            $urlArray = explode(DS, $url);

            $controllerName = $urlArray[0];
            $action = (isset($urlArray[1]) && $urlArray[1] != EMPTY_STRING) ? $urlArray[1] : DEFAULT_ACTION;
        }
    }

    $query1 = (isset($urlArray[2]) && $urlArray[2] != EMPTY_STRING) ? $urlArray[2] : NULL;
    $query2 = (isset($urlArray[3]) && $urlArray[3] != EMPTY_STRING) ? $urlArray[3] : NULL;
    $queryString = array($query1, $query2);

    //modify controller name to fit naming convention
    $controller = ucfirst($controllerName) . CONTROLLER_CLASS;

    $dispatch = new $controller(rtrim(ucfirst($controllerName), RIGHT_TRIM_WHITE_SPACE), $controllerName, $action);

    //instantiate the appropriate class
    if (class_exists($controller) && (int)method_exists($controller, $action)) {
        call_user_func_array(array($dispatch, $action), $queryString);
    } else {
        print_r(ERROR_MESSAGE . $controller . DS . $action . FILE_MISSING_ERROR);
    }
}

$titleName = Uci::get(LUXUL_MODEL);

setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();
