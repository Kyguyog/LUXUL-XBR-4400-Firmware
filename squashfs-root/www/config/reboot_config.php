<?php

class Reboot_Config {
    private static $instance;
    private $constants = array(
        'NETWORK_LAN_IPADDR' => 'network.lan.ipaddr'
    );

    /**
     * @return Quicksetup_Config
     */
    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __get($name) {
        if (!isset($this->constants[$name]))
            throw new Exception('Unknown constants '.$name);
        return $this->constants[$name];
    }

    public function __set($name, $value) {
        $this->constants[$name] = $value;
    }

}