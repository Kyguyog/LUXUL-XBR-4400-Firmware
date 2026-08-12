<?php

class Routerlimits_Config {
    private static $instance;
    private $constants = array(
        'ROUTER_LIMITS_STATUS' => 'TRL.TRL.status',
        'ROUTER_LIMITS_DEVICE_ID' => 'TRL.TRL.pairingCode',
        'START_TRLC_COMMAND' => '/etc/init.d/trlc start',
        'STOP_TRLC_COMMAND' => '/etc/init.d/trlc stop'
    );

    /**
     * @return Routerlimits_Config
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