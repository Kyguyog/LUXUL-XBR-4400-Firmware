<?php
class Routerlimits_Model extends Model{
    function __construct() {
        parent::__construct();
        $this->Load_Config(ROUTER_LIMITS);
    }

    public function setRouterLimits($val) {
        $this->set(TRL_ROUTER_LIMITS, $val);
    }

    public function getRouterLimitsStatus() {
        return $this->get($this->config->ROUTER_LIMITS_STATUS);
    }

    public function getRouterLimitsDeviceId() {
        return $this->get($this->config->ROUTER_LIMITS_DEVICE_ID);
    }

    public function startTrlc() {
        $this->execute($this->config->START_TRLC_COMMAND, $output, $ret);
    }

    public function stopTrlc() {
        $this->execute($this->config->STOP_TRLC_COMMAND, $output, $ret);

    }
}