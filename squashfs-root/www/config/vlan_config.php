<?php

class Vlan_Config {
    private static $instance;
    private $constants = array(
//        'GET_ALL_VLAN_INFO_COMMAND' => 'uci show network | grep eth0_ | grep switch_vlan  | cut -d \'=\' -f1',
    );

    /**
     * @return Vlan_Config
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