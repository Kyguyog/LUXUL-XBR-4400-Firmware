<?php

class Lease_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function deleteDHCPHost($index) {
        $this->delete(DHCP . UCI_FIELD_DOT . UCI_FIELD_AT . HOST . $index);
    }

    public function addDHCPHost() {
        $this->add(DHCP, HOST);
    }

    public function getDHCPHost($index) {
        return $this->get(DHCP . UCI_FIELD_DOT . UCI_FIELD_AT . HOST . $index);
    }

    public function setDHCPName($value) {
        $this->set(DHCP . UCI_FIELD_DOT . UCI_FIELD_AT . HOST . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . NAME, $value);
    }

    public function setDHCPIP($value) {
        $this->set(DHCP . UCI_FIELD_DOT . UCI_FIELD_AT . HOST . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . IP, $value);
    }

    public function getDHCPIP($index) {
        return $this->get(DHCP . UCI_FIELD_DOT . UCI_FIELD_AT . HOST . $index . UCI_FIELD_DOT . IP);
    }

    public function setDHCPMac($value) {
        $this->set(DHCP . UCI_FIELD_DOT . UCI_FIELD_AT . HOST . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . MAC, $value);
    }

    public function getDHCPMac($index) {
        return $this->get(DHCP . UCI_FIELD_DOT . UCI_FIELD_AT . HOST . $index . UCI_FIELD_DOT . MAC);
    }

    public function restartDnsmasq() {
        $this->execute(RESTART_DNSMASQ_COMMAND, $output, $ret);
    }

}