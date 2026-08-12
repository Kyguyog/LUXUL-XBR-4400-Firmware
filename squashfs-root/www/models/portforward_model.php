<?php

class Portforward_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function getFirewallRedirectProtocol($index) {
        return $this->get(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . $index . UCI_FIELD_DOT . PROTO);
    }

    public function getFirewallRedirectSrcPort($index) {
        return $this->get(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . $index . UCI_FIELD_DOT . SOURCE_DPORT);
    }

    public function getFirewallRedirectDestPort($index)  {
        return $this->get(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . $index . UCI_FIELD_DOT . DESTINATION_PORT_SHORT);
    }

}