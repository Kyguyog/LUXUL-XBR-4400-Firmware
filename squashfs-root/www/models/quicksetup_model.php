<?php
class Quicksetup_Model extends Model{
    function __construct() {
        parent::__construct();
        $this->Load_Config(QUICK_SETUP);
    }

    public function setConnectionType($value) {
        $this->set(NETWORK_WAN_PROTO, $value);
    }

    public function setPPPOEUser($value) {
        $this->set($this->config->NETWORK_WAN_PPPOE_USER, $value);
    }

    public function getPPPOEUser() {
        return $this->get($this->config->NETWORK_WAN_PPPOE_USER);
    }

    public function deletePPPOEUser() {
        $this->delete($this->config->NETWORK_WAN_PPPOE_USER);
    }

    public function setPPPOEPwd($value) {
        $this->set($this->config->NETWORK_WAN_PPPOE_PWD, $value);
    }

    public function getPPPOEPwd() {
        return $this->get($this->config->NETWORK_WAN_PPPOE_PWD);
    }

    public function deletePPPOEPwd() {
        $this->delete($this->config->NETWORK_WAN_PPPOE_PWD);
    }

    public function setPPPOEKeepAlive($value) {
        $this->set($this->config->NETWORK_WAN_PPPOE_KEEPALIVE, $value);
    }

    public function getPPPOEKeepAlive() {
        $keepAlive = $this->get($this->config->NETWORK_WAN_PPPOE_KEEPALIVE);
        $keepAliveArray = array();
        if (isset($keepAlive) && $keepAlive != EMPTY_STRING) {
            $keepAliveArray = explode(SPACE, $keepAlive);
        }
        return $keepAliveArray;
    }

    public function deletePPPOEKeepAlive() {
        $this->delete($this->config->NETWORK_WAN_PPPOE_KEEPALIVE);
    }

    public function getPPPOEMaxFailedPing() {
        return isset($this->getPPPOEKeepAlive()[0]) && $this->getPPPOEKeepAlive()[0] != EMPTY_STRING ? $this->getPPPOEKeepAlive()[0] : $this->config->DEFAULT_PPPOE_MAX_FAILED_PING;
    }

    public function getPPPOEPingInterval() {
        return isset($this->getPPPOEKeepAlive()[1]) && $this->getPPPOEKeepAlive()[1] != EMPTY_STRING ? $this->getPPPOEKeepAlive()[1] : $this->config->DEFAULT_PPPOE_PING_INTERVAL;
    }

    public function setWANIPAddr($value) {
        $this->set(NETWORK_WAN_IPADDR, $value);
    }

    public function setWANSubnetMask($value) {
        $this->set(NETWORK_WAN_NETMASK, $value);
    }

    public function setWANGateway($value) {
        $this->set(NETWORK_WAN_GATEWAY, $value);
    }

    public function deleteGateway() {
        $this->delete(NETWORK_WAN_GATEWAY);
    }

    public function setDNS($value) {
        $this->setLANDNS($value);
        $this->setWANDNS($value);
        $this->setWANPeerDNS();
    }

    public function setLANDNS($value) {
        $this->set($this->config->NETWORK_LAN_DNS, $value);
    }

    public function setWANDNS($value) {
        $this->set(NETWORK_WAN_DNS, $value);
    }

    public function setWANPeerDNS() {
        $this->set($this->config->NETWORK_WAN_PEERDNS, $this->config->NETWORK_WAN_PEERDNS_0);
    }

    public function deleteDNS() {
        $this->deleteLANDNS();
        $this->deleteWANDNS();
        $this->deleteWANPeerDNS();
    }

    public function deleteLANDNS() {
        $this->delete($this->config->NETWORK_LAN_DNS);
    }

    public function deleteWANDNS() {
        $this->delete(NETWORK_WAN_DNS);
    }

    public function deleteWANPeerDNS() {
        $this->delete($this->config->NETWORK_WAN_PEERDNS);
    }

    public function setWANMacAddr($value) {
        $this->set(NETWORK_WAN_MAC, $value);
    }

    public function deleteWANMacAddr() {
        $this->delete(NETWORK_WAN_MAC);
    }

    public function setCustomMtu($value) {
        $this->set($this->config->NETWORK_WAN_MTU, $value);
    }

    public function getCustomMtu() {
        return $this->get($this->config->NETWORK_WAN_MTU);
    }

    public function deleteCustomMtu() {
        $this->delete($this->config->NETWORK_WAN_MTU);
    }

    public function setLanIPAddr($value) {
        $this->set(NETWORK_LAN_IPADDR, $value);
    }

    public function setLanSubnetMask($value) {
        $this->set(NETWORK_LAN_NETMASK, $value);
    }

}