<?php

class System_Config {
    private static $instance;

    private $constants = array(
        'SYSTEM_HOSTNAME' => 'system.@system[0].hostname',
        'GET_CPU_USAGE_COMMAND' => 'uptime',
        'LOAD_AVERAGE' => 'load average: ',
        'GET_MEMEORY_USAGE_COMMAND' => 'cat /proc/meminfo',
        'GET_UP_TIME_COMMAND' => 'cat /proc/uptime'
    );

    /**
     * @return System_Config
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