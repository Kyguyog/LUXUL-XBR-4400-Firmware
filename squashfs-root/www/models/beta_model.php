<?php
class Beta_Model extends Model{
    function __construct() {
        parent::__construct();
        $this->Load_Config(BETA);
    }

    public function getPortMonitor() {
        return $this->get(LUXUL_BETA_VLAN_MONITOR);
    }

    public function setWanDelay($value) {
        $this->set($this->config->LUXUL_BETA_WAN_DELAY, $value);
    }

    public function getWanDelay() {
        return $this->get($this->config->LUXUL_BETA_WAN_DELAY);
    }

    public function setWanInterfaceName($vlanId) {
        $this->set($this->config->NETWORK_WAN_INTERFACE_NAME, $this->config->ETH0.$vlanId);
    }

    public function getWanInterfaceName() {
        return str_replace($this->config->ETH0, EMPTY_STRING, $this->get($this->config->NETWORK_WAN_INTERFACE_NAME));
    }

    public function getBlockSelfAssignedIp() {
        $this->execute($this->config->GET_BLOCK_SELF_ASSIGNED_IP_RULE_COMMAND, $output, $ret);
        return count($output) > 0 ? $output[0] : BLOCK_SELF_ASSIGNED_IP_DISABLED_KEY;
    }

    public function getPortSpeed($networkSwithcPortIndex) {
        return $this->get(NETWORK_SWITCH_PORT.$networkSwithcPortIndex.UCI_FIELD_DOT.LINK);
    }

    public function deleteNetworkSwithPort($networkSwithcPortIndex) {
        $this->delete(NETWORK_SWITCH_PORT.$networkSwithcPortIndex);
    }

    public function setNetworkSwitchDevice() {
        $this->set(NETWORK_SWITCH_PORT.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.DEVICE, SWITCH0);
    }

    public function setNetworkSwitchPortLink($speed) {
        $this->set(NETWORK_SWITCH_PORT.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.LINK, $speed);
    }

}