<?php

class Led_Config {
    private static $instance;
    private $constants = array(
        'LED_STATUS' => 'luxul.dynamic.leds_visible',
        'UPDATE_LED_COMMAND' => '/sbin/update_leds.sh'
    );

    /**
     * @return Led_Config
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