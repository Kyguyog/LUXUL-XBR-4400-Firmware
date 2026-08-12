<?php

class Port_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(PORT . DS . PORT);
        $this->Load_Model(PORT);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(PORT);
    }

    public function addContent() {
        $port = EMPTY_STRING;
        $port_view = new View();

        $port_view->Assign(WAN_PORT_STATE, $this->getPortState(INDEX_0));
        $port_view->Assign(WAN_PORT_INFO, $this->getPortInfo(INDEX_0));

        $port_view->Assign(LAN_PORT4_STATE, $this->getPortState(INDEX_1));
        $port_view->Assign(LAN_PORT4_INFO, $this->getPortInfo(INDEX_1));

        $port_view->Assign(LAN_PORT3_STATE, $this->getPortState(INDEX_2));
        $port_view->Assign(LAN_PORT3_INFO, $this->getPortInfo(INDEX_2));

        $port_view->Assign(LAN_PORT2_STATE, $this->getPortState(INDEX_3));
        $port_view->Assign(LAN_PORT2_INFO, $this->getPortInfo(INDEX_3));

        $port_view->Assign(LAN_PORT1_STATE, $this->getPortState(INDEX_4));
        $port_view->Assign(LAN_PORT1_INFO, $this->getPortInfo(INDEX_4));

        $port .= $port_view->Render(PORT . DS . INFO, FALSE);
        $this->Assign(PORT, $port);
    }

    public function getPortState($portNum) {
        $wanPortState = COLOR_BLACK;
        $wanPortStateInfo = $this->getAllPortsState()[$portNum];

        if (strpos($wanPortStateInfo, LINK_DOWN) == FALSE) {
            $wanPortSpeed = substr($wanPortStateInfo, strpos($wanPortStateInfo, UP_SPEED)+9);

            if (strpos($wanPortSpeed, SPEED_1GBPS) !== FALSE) {
                $wanPortState = COLOR_GREEN;
            } else if (strpos($wanPortSpeed, SPEED_100MBPS) !== FALSE) {
                $wanPortState = COLOR_YELLOW;
            } else if (strpos($wanPortSpeed, SPEED_10MBPS) !== FALSE) {
                $wanPortState = COLOR_BLUE;
            }
        }

        return $wanPortState;
    }

    public function getPortInfo($portNum) {
        return $this->model->getPortInfo($portNum);
    }

}