<?php

class Dhcp_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function setDHCPServerStatus($value) {
        $this->set(DHCP_IGNORE, $value);
    }

    public function setIPV4Class($value) {
        $this->set(LUXUL_DHCP_CLASS, $value);
    }

    public function setLanSubnetMask($value) {
        $this->set(NETWORK_LAN_NETMASK, $value);
    }

    public function setLanIPAddrStart($value) {
        $this->set(LUXUL_LAN_IP_START, trim($value));
    }

    public function setLanIPAddrEnd($value) {
        $this->set(LUXUL_LAN_IP_END, trim($value));
    }

    public function setDHCPStart($value) {
        $this->set(DHCP_LAN_START, $value);
    }

    public function setClassBStart($value) {
        $this->set(LUXUL_DHCP_START, $value);
    }

    public function setClassBEnd($value) {
        $this->set(LUXUL_DHCP_END, $value);
    }

}