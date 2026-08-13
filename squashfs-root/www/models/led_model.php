<?php
class Led_Model extends Model{
    function __construct() {
        parent::__construct();
        $this->Load_Config(LED);
    }

    public function getLEDStatus() {
        return $this->get($this->config->LED_STATUS);
    }

    public function setLEDStatus($value) {
        $this->set($this->config->LED_STATUS, $value);
    }

    public function updateLEDStatus() {
        $this->execute($this->config->UPDATE_LED_COMMAND, $output, $ret);
    }
}