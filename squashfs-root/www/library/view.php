<?php

class View {
    private $data = array();
    private $render = FALSE;

    public function __construct() {
    }

    public function Assign($variable = EMPTY_STRING, $value) {
        if ($variable == EMPTY_STRING)
            $this->data = $value;
        else
            $this->data[$variable] = $value;
    }

    public function Render($view, $direct_output = TRUE) {
        if (substr($view, -4) == PHP_EXTENSION) {
            $file = $view;
        } else {
            $file = ROOT . DS . VIEWS . DS . strtolower($view) . PHP_EXTENSION;
        }

        if (file_exists($file)) {
            $this->render = $file;
        } else {
            die(VIEW_FILE_NOT_EXIST_MESSAGE);
        }

        if ($direct_output !== TRUE) {
            ob_start();
        }

        $data = $this->data;
        include($this->render);

        if ($direct_output !== TRUE) {
            return ob_get_clean();
        }
    }

    public function __destruct() {

    }
}