<?php

class System_Model extends Model {

    function __construct() {
        parent::__construct();
        $this->Load_Config(SYSTEM);
    }

    function getHostName() {
        return $this->get($this->config->SYSTEM_HOSTNAME);
    }

    public function getCPUUsage() {
        $this->execute($this->config->GET_CPU_USAGE_COMMAND, $output, $ret);
        return explode(COMMA, str_replace($this->config->LOAD_AVERAGE, EMPTY_STRING, strstr($output[0], $this->config->LOAD_AVERAGE)))[1];
    }

    public function getMemoryUsage() {
        $this->execute($this->config->GET_MEMEORY_USAGE_COMMAND, $output, $ret);
        return $output;
    }

    public function getUpTime() {
        $this->execute($this->config->GET_UP_TIME_COMMAND, $output, $ret);
        return strtok($output[0], UCI_FIELD_DOT);
    }

//    public function getWANStatus() {
//        $this->execute($this->config->GET_WAN_STATUS_COMMAND, $output, $ret);
//        return $output;
//    }

//    public function getWANMacAddrArray() {
//        $this->execute($this->config->GET_WAN_MAC_ADDR_COMMAND, $output, $ret);
//        return $output[0];
//    }
//
//    public function getLANMacAddrArray() {
//        $this->execute(IF_CONFIG_BR_LAN, $output, $ret);
//        return $output[0];
//    }

}