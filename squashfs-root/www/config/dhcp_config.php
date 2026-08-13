<?php

class Dhcp_Config {
    private static $instance;
    private $constants = array(
        'DHCP_IGNORE' => 'dhcp.lan.ignore',
        'LUXUL_LAN_IPEND' => 'luxul.dynamic.lanipend',
        'DHCP_LAN_START' => 'dhcp.lan.start',
    );

    /**
     * @return Dhcp_Config
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