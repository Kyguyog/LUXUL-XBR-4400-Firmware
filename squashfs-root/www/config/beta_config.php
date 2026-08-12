<?php

class Beta_Config {
    private static $instance;
    private $constants = array(
        'LUXUL_BETA_WAN_DELAY' => 'luxul.beta.wan_delay',
        'NETWORK_WAN_INTERFACE_NAME' => 'network.wan.ifname',
        'ETH0' => 'eth0.',
        'GET_BLOCK_SELF_ASSIGNED_IP_RULE_COMMAND' => 'uci show firewall |grep \'rule\' |grep \'Self\'',
        'GET_NETWORK_SWITCH_PORT_INDEX_COMMAND' => 'uci show network | grep port='
    );

    /**
     * @return Beta_Config
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