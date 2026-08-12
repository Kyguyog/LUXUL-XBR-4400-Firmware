<?php

class Qos_Config {
    private static $instance;
    private $constants = array(
        'QOS_WAN_ENABLED' => 'qos.wan.enabled',
        'QOS_WAN_OVERHEAD' => 'qos.wan.overhead',
        'QOS_WAN_DOWNLOAD' => 'qos.wan.download',
        'QOS_WAN_SPEED_0' => '0',
        'QOS_WAN_UPLOAD' => 'qos.wan.upload',
        'CLASSIFY' => 'classify',
        'SOURCE_HOST' => 'srchost',
        'RESTART_QOS_COMMAND' => '/etc/init.d/qos restart'
    );

    /**
     * @return Qos_Config
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