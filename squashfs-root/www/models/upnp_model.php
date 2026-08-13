<?php

class Upnp_Model extends Model {
    function __construct() {
        parent::__construct();
        $this->Load_Config(UPNP);
    }

    public function getStatus() {
        return $this->get($this->config->UPNP_ENABLE_NATPMP);
    }

    public function setStatus($value) {
        $this->set($this->config->UPNP_ENABLE_NATPMP, $value);
        $this->set($this->config->UPNP_ENABLE_UPNP, $value);
    }

    public function getLans() {
        return $this->get($this->config->INTERNAL_IFACE);
    }

    public function setLans($value) {
        $this->set($this->config->INTERNAL_IFACE, $value);
    }

    public function getUpnpLeases() {
        $output = array();
        $this->execute($this->config->UPNP_LEASES, $output, $ret);
        return $output;
    }

    public function getNetworkInfo() {
        $this->execute($this->config->NETWORK_INFO, $output, $ret);
        return $output;
    }

    public function getVlanName($vlanid) {
        return $this->get(NETWORK_ETH0 . $vlanid . $this->config->VNAME);
    }

    public function enableUpnp() {
        $this->execute($this->config->ENABLE_UPNP, $output, $ret);
    }

    public function disableUpnp() {
        $this->execute($this->config->DISABLE_UPNP, $output, $ret);
    }

    public function restartUpnp() {
        $this->execute($this->config->RESTART_UPNP, $output, $ret);
    }

}