<?php

class Upgrade_Config {
    private static $instance;
    private $constants = array(
        'LUXUL_MODEL' => 'luxul.static.hw_model',
        'GET_UPGRADE_FILE_HEADER_ECHO_COMMAND' => 'echo $(dd if=',
        'GET_UPGRADE_MODEL_COMMAND' => ' bs=2 skip=24 count=6 2>/dev/null)',
        'GET_UPGRADE_HEADER_SUM_COMMAND' => ' bs=16 count=2 2>/dev/null)',
        'GET_UPGRADE_FILE_SUM_COMMAND' => ' bs=16 skip=4 2>/dev/null | md5sum)',
        'GET_UPGRADE_FILE_HEADER_COMMAND' => 'dd if=',
        'REMOVE_UPGRADE_FILE_HEADER_COMMAND1' => ' bs=16 skip=4 of=',
        'REMOVE_UPGRADE_FILE_HEADER_COMMAND2' => ' conv=notrunc 2>/dev/null',
        'FIRMWARE_UPGRADE_DIRECTORY' => '/sbin/sysupgrade ',
        'FIRMWARE_UPGRADE_COMMAND' => ' >/dev/null &'

    );

    /**
     * @return Upgrade_Config
     */
    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __get($name) {
        if (!isset($this->constants[$name]))
            throw new Exception(UNKNOWN_CONSTANTS . $name);
        return $this->constants[$name];
    }

    public function __set($name, $value) {
        $this->constants[$name] = $value;
    }

}