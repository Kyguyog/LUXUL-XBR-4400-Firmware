<?php

class Vlanconfig_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function getLanDHCPServerStatus() {
        return $this->get(DHCP_IGNORE);
    }

    public function getVlanDHCPServerStatus($vlanID) {
        if (!$this->get(DHCP_VLAN . $vlanID) && $this->get(NETWORK.UCI_FIELD_DOT.VLAN.$vlanID)) {
            $dhcpServerStatus = EMPTY_STRING;
        } else {
            $dhcpServerStatus = CONNECTED_CLIENTS_DHCP_KEY;
        }

        return $dhcpServerStatus;
    }

    public function getDhcpVlanStart($vlanID) {
        return $this->get(DHCP_VLAN.$vlanID.UCI_FIELD_DOT.trim(START));
    }

    public function getDhcpLanStart() {
        return $this->get(DHCP_LAN_START);
    }

    public function getDhcpVlanLimit($vlanID) {
        $dhcpVlanLimit = $this->getDHCPLanLimit();

        if ($this->get(DHCP_VLAN.$vlanID.UCI_FIELD_DOT.LIMIT) || $this->get(DHCP_VLAN.$vlanID.UCI_FIELD_DOT.LIMIT)  == '0') {
            $dhcpVlanLimit = $this->get(DHCP_VLAN.$vlanID.UCI_FIELD_DOT.LIMIT);
        }

        return $dhcpVlanLimit;
    }

    public function getDhcpVlanLeaseTime($vlanID) {
        $dhcpVlanLeaseTime = $this->getLeaseTime();

        if ($this->get(DHCP_VLAN.$vlanID.UCI_FIELD_DOT.LEASE_TIME)) {
            $dhcpVlanLeaseTime = str_replace(DHCP_LEASE_TIME_HOUR_UNIT, EMPTY_STRING, $this->get(DHCP_VLAN.$vlanID.UCI_FIELD_DOT.LEASE_TIME));
        }

        return $dhcpVlanLeaseTime;
    }

}