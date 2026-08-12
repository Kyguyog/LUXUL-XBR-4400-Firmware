<?php
class Connections_Model extends Model{
    function __construct() {
        parent::__construct();
    }

    public function getDHCPStatus() {
        return $this->get(DHCP_IGNORE);
    }

    public function getDHCPClientsArray() {
        $this->execute(GET_DHCP_CLIENTS_COMMAND, $output, $ret);
        return $output;
    }
}