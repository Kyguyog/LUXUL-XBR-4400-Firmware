<?php

class Webfilter_Model extends Model {
    function __construct() {
        parent::__construct();
        $this->Load_Config(WEB_FILTER);
    }

    public function setWebFilteringStatus($value) {
        $this->set($this->config->WEB_FILTERING_STATUS, $value);
    }

    public function getWebFilteringStatus() {
        return $this->get($this->config->WEB_FILTERING_STATUS) ? $this->get($this->config->WEB_FILTERING_STATUS) : EMPTY_STRING;
    }

    public function deleteWebFilteringStatus() {
        $this->delete($this->config->WEB_FILTERING_STATUS);
    }

    public function setDhcpLanOption($value) {
        $this->set($this->config->DHCP_LAN_OPTION, $value);
    }

    public function deleteDhcpLanOption() {
        $this->delete($this->config->DHCP_LAN_OPTION);
    }

    public function reloadNetwork() {
        $this->execute($this->config->NETWORK_RELOAD_COMMAND, $output, $ret);
    }

    public function reloadDnsMask() {
        $this->execute($this->config->DNS_MASK_RELOAD_COMMAND, $output, $ret);
    }

}