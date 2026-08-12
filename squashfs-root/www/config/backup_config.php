<?php

class Backup_Config {
    private static $instance;
    private $constants = array(
//        'BACK_UP_FILE_COMMAND' => '/sbin/lxconfig.sh -b .backup',
        'RESTORE_FILE_COMMAND' => '/sbin/lxconfig.sh -r .firmware_upload',
        'FORCE_RESTORE_FILE_COMMAND'=> '/sbin/lxconfig.sh -f .firmware_upload'
    );

    /**
     * @return Backup_Config
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