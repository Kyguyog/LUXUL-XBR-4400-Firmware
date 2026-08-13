<?php

class Vpnserver_Config {
    private static $instance;
    private $constants = array(
        'PPTPD_ENABLED' => 'pptpd.pptpd.enabled',
        'IPSEC_CONFIG_ENABLED' => 'ipsec.ipsec.enabled',
        'IPSEC_CONFIG_AGGRESSIVE' => 'ipsec.ipsec.aggressive',
        'IPSEC_CONFIG_PSK' => 'ipsec.ipsec.psk',
        'IPSEC_CONFIG_LOCAL_IP' => 'ipsec.ipsec.localip',
        'XL2TPD_ENABLED' => 'xl2tpd.xl2tpd.enabled',
        'ENABLE' => ' enable',
    );

    /**
     * @return Vpnserver_Config
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