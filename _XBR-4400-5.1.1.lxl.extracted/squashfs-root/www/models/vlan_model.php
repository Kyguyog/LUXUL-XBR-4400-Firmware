<?php

class Vlan_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function getVlanStatus() {
        return $this->get(VLAN_STATUS);
    }

//    public function deleteNetworkEthInfo($vlanId) {
//        $this->delete(NETWORK_ETH0 . $vlanId);
//    }

}