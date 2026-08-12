<?php

class Webfilter_Config {
    private static $instance;
    private $constants = array(
        'WEB_FILTERING_STATUS' => 'luxul.dynamic.pc',
        'DHCP_LAN_OPTION' => 'dhcp.lan.dhcp_option',
        'NETWORK_RELOAD_COMMAND' => '/etc/init.d/network reload > /dev/null 2>&1 &',
        'DNS_MASK_RELOAD_COMMAND' => '/etc/init.d/dnsmasq reload > /dev/null 2>&1 &'
    );

    /**
     * @return Webfilter_Config
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