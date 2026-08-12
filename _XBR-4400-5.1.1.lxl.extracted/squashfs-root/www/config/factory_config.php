<?php

class Factory_Config {
    private static $instance;
    private $constants = array(
        'LUXUL_MODEL' => '/etc/config/luxul.static.hw_model',
        'LUXUL_VERSION' => '/etc/config/luxul.static.hw_version',
        'LUXUL_FIRMWARE_VERSION' => '/etc/config/luxul.static.fw_version'
    );

    /**
     * @return Factory_Config
     */
    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __get($name) {
        if (!isset($this->constants[$name]))
            throw new Exception(UNKNOWN_CONSTANTS . SPACE . $name);
        return $this->constants[$name];
    }

    public function __set($name, $value) {
        $this->constants[$name] = $value;
    }

}