<?php
class Portspeed_Model extends Model{
    function __construct() {
        parent::__construct();
    }

    public function getPortSpeed($networkSwithcPortIndex) {
        return $this->get(NETWORK_SWITCH_PORT.$networkSwithcPortIndex.UCI_FIELD_DOT.LINK);
    }

    public function getNetworkSwithcPortIndex($portNum) {
        $this->execute(GET_NETWORK_SWITCH_PORT_INDEX_COMMAND.$portNum, $output, $ret);
        return count($output) > 0  ? substr($output[0], strpos($output[0], INDEX_BRACKET_LEFT)+1, 1) : EMPTY_STRING;
    }

    public function deleteNetworkSwithPort($networkSwithcPortIndex) {
        $this->delete(NETWORK_SWITCH_PORT.$networkSwithcPortIndex);
    }

    public function setNetworkSwitchDevice() {
        $this->set(NETWORK_SWITCH_PORT.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.DEVICE, SWITCH0);
    }

    public function setNetworkSwitchPortLink($speed) {
        $this->set(NETWORK_SWITCH_PORT.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.LINK, $speed);
    }

}
