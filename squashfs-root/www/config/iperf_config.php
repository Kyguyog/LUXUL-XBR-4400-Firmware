<?php

class Iperf_Config {
    private static $instance;
    private $constants = array(
        'GET_IPERF_STATUS_COMMAND' => 'ps | grep iperf | grep -v grep | grep "/usr/bin/iperf" | wc -l',
        'IPERF_START_COMMAND' => '/etc/init.d/iperf start ',
        'IGNORE_OUTPUT_COMMAND' => ' >/dev/null 2>/dev/null &',
        'KILL_IPERF' => 'killall iperf',
        'KILL_SLEEP' => 'killall sleep'
    );

    /**
     * @return Iperf_Config
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