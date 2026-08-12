<?php

class Uci {
    public function add($file, $field){
        exec("uci add ".$file. SPACE. $field);
    }

    public function add_list($file, $field) {
        exec("uci add_list " . $file . EQUAL_SIGN . $field);
    }

    public static function set($key, $value) {
        if (strpos(SINGLE_QUOTE, $key) !== FALSE) {
            throw new Exception(QUOTE_ERROR);
        } else {
            exec("uci set '$key=$value'");
        }
    }

    public static function get($val) {
        exec("uci get $val", $output, $ret);
        return intval($ret) !== 0 ? NULL : $output[0];
    }

    public function delete($section, &$output = null, &$ret = null) {
        exec($p = "uci delete $section", $output, $ret);
        return $ret;
    }

    public function execute($query, &$output, &$ret) {
        exec($query, $output, $ret);
        return $ret;
    }

    public function shell_exec($query) {
        shell_exec($query);
    }

    public function commit(&$output = null, &$ret = null) {
        exec("uci commit", $output, $ret);
    }

}
