<?php

class Factory_Model extends Model {

    function __construct() {
        parent::__construct();
        $this->Load_Config(FACTORY);
    }

    public function getModel() {
        return $this->get($this->config->LUXUL_MODEL);
    }

    public function getVersion() {
        return $this->get($this->config->LUXUL_VERSION);
    }

    public function getFirmwareVersion() {
        return $this->get($this->config->LUXUL_FIRMWARE_VERSION);
    }

    public function restoreFactoryDefault() {
        $this->shell_exec(FIRSTBOOT_COMMAND);
        $this->execute(REBOOT, $output, $ret);
    }

}