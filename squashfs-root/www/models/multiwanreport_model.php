<?php
class Multiwanreport_Model extends Model{
    function __construct() {
        parent::__construct();
    }

    public function getPortState() {
        $this->execute(GET_PORT_STATE_COMMAND, $output, $ret);
        return $output;
    }

    public function getPortInfo($portNum) {
        $this->execute(GET_PORT_INFO_COMMAND_PART1.$portNum.GET_PORT_INFO_COMMAND_PART2, $output, $ret);
        return $output;
    }
}