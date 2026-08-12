<?php

class Upnp_Config {
    private static $instance;
    private $constants = array(
        'UPNP_ENABLE_NATPMP' => 'upnpd.config.enable_natpmp',
        'UPNP_ENABLE_UPNP' => 'upnpd.config.enable_upnp',
        'INTERNAL_IFACE' => 'upnpd.config.internal_iface',
        'UPNP_LEASES' => 'cat /tmp/upnp.leases',
        'RESTART_UPNP' => '/etc/init.d/miniupnpd restart',
        'ENABLE_UPNP' => '/etc/init.d/miniupnpd start',
        'DISABLE_UPNP' => '/etc/init.d/miniupnpd stop',
        'NETWORK_INFO' => 'uci show network',
        'VNAME' => '.vname'
    );

    /**
     * @return Upnp_Config
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