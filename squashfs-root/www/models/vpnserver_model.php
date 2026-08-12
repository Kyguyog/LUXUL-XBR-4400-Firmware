<?php

class Vpnserver_Model extends Model {
    function __construct() {
        parent::__construct();
        $this->Load_Config(VPN_SERVER);
    }

    public function setVpnMode($value) {
        $this->set(LUXUL_VPN_MODE, $value);
    }

    public function setIPSECStatus($value) {
        $this->set($this->config->IPSEC_CONFIG_ENABLED, $value);
    }

    public function setIPSecAggressiveMode($value) {
        $this->set($this->config->IPSEC_CONFIG_AGGRESSIVE, $value);
    }

    public function getVpnAggressiveMode() {
        return $this->get($this->config->IPSEC_CONFIG_AGGRESSIVE) ?
            $this->get($this->config->IPSEC_CONFIG_AGGRESSIVE) : VPN_AGGRESSIVE_MODE_DISABLED_KEY;
    }

    public function setIPSecPresharedKey($value) {
        $this->set($this->config->IPSEC_CONFIG_PSK, $value);
    }

    public function getPresharedKey() {
        return $this->get($this->config->IPSEC_CONFIG_PSK);
    }

    public function setDHCPServer($value) {
        $this->set($this->config->IPSEC_CONFIG_LOCAL_IP, $value);
    }

    public function getDhcpServer() {
        return $this->get($this->config->IPSEC_CONFIG_LOCAL_IP);
    }

    public function getIPAddrStart() {
        return substr($this->getPPTPDRemoteIp(), 0, strpos($this->getPPTPDRemoteIp(), HYPHEN));
    }

    public function getIPAddrEnd() {
        $ipAddrEnd4Octet = substr($this->getPPTPDRemoteIp(), strpos($this->getPPTPDRemoteIp(), HYPHEN) + 1);
        $ipAddrEndArray = explode(UCI_FIELD_DOT, $this->getIPAddrStart());
        return $ipAddrEndArray[0] . UCI_FIELD_DOT . $ipAddrEndArray[1] . UCI_FIELD_DOT . $ipAddrEndArray[2] . UCI_FIELD_DOT . $ipAddrEnd4Octet;
    }

    public function setPPTPDEnabled($value) {
        $this->set($this->config->PPTPD_ENABLED, $value);
    }

    public function setXL2TPDEnabled($value) {
        $this->set($this->config->XL2TPD_ENABLED, $value);
    }

    public function getXL2TPDIpRange() {
        return $this->get(XL2PTD_REMOTE_IP);
    }

    public function getPPTPDRemoteIp() {
        return $this->get(PPTPD_REMOTE_IP);
    }

    public function enableVpn($vpnMode) {
        $this->execute(VPN_COMMAND . $vpnMode . $this->config->ENABLE, $output, $ret);
    }

}