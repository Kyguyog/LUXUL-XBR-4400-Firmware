<?php

class Portspeed_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(PORT_SPEED . DS . PORT_SPEED);
        $this->Load_Model(PORT_SPEED);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(PORT_SPEED);

        if (isset($_POST[SAVE_PORT_SPEED_INFO])) {
            $this->savePortSpeedInfo();
            $this->saveRebootRequired();

            $this->commit();
            header(LOCATION . PORT_SPEED_PAGE);

        } else if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . PORT_SPEED);
        }
    }

    public function addContent() {
        $port_speed = EMPTY_STRING;
        $port_speed_view = new View();

        $this->assignRebootRequireView($port_speed_view);
        $port_speed_view->Assign(WAN_PORT_OPTIONS, $this->getPortSpeedOptions(PORT_0));
        $port_speed_view->Assign(LAN_PORT_1_OPTIONS, $this->getPortSpeedOptions(PORT_4));
        $port_speed_view->Assign(LAN_PORT_2_OPTIONS, $this->getPortSpeedOptions(PORT_3));
        $port_speed_view->Assign(LAN_PORT_3_OPTIONS, $this->getPortSpeedOptions(PORT_2));
        $port_speed_view->Assign(LAN_PORT_4_OPTIONS, $this->getPortSpeedOptions(PORT_1));

        $port_speed .= $port_speed_view->Render(PORT_SPEED . DS . SETUP, FALSE);
        $this->Assign(PORT_SPEED, $port_speed);
    }

    public function getPortSpeedOptions($portNum) {
        $options = array(
            PORT_SPEED_AUTO_KEY => PORT_SPEED_AUTO_VAL,
            PORT_SPEED_1000_BASE_KEY => PORT_SPEED_1000_BASE_VAL,
            PORT_SPEED_100_BASE_KEY => PORT_SPEED_100_BASE_VAL,
            PORT_SPEED_10_BASE_KEY => PORT_SPEED_10_BASE_VAL
        );

        return $this->helper->selectOption($options, $this->getPortSpeed($portNum));
    }

    public function getPortSpeed($portNum) {
        $portSpeed = PORT_SPEED_AUTO_KEY;

        if ($this->getPVIDPortIndex($portNum) != EMPTY_STRING) {
            foreach ($this->getPVIDPortIndex($portNum) as $key => $switchPortIndexInfo) {
                $switchPortIndex = substr($switchPortIndexInfo, strpos($switchPortIndexInfo, INDEX_BRACKET_LEFT), 3);

                if ($this->model->getPVIDPort($switchPortIndex)) {
                    continue;
                }

                if ($this->model->getPortSpeed($switchPortIndex)) {
                    $portSpeed = $this->model->getPortSpeed($switchPortIndex);
                } else {
                    $portSpeed = PORT_SPEED_AUTO_KEY;
                }

            }
        } else {
            $portSpeed = PORT_SPEED_AUTO_KEY;
        }

        return $portSpeed;
    }

    public function savePortSpeedInfo() {
        $this->deletePortSpeedInfo();

        for ($i=0; $i <= 4; $i++) {

            if ($i == 0) {
                $portName = WAN_PORT_OPTIONS;
            } else {
                $portName = LAN_PORT.$i.OPTIONS;
            }

            if ($_POST[$portName] != PORT_SPEED_AUTO_KEY) {
                $this->addNetworkSwithPort();
                $this->saveNetworkSwitchDevice();
                $this->saveNetworkSwitchPortNum(UCI_FIELD_INDEX_LAST, $i == 0 ? VLAN_PORT_0 : $this->reverseVlanPort($i));
                $this->saveNetworkSwitchPortLink($_POST[$portName]);
            }
        }

        $this->saveRebootRequired();
        $this->commit();

        header(LOCATION . PORT_SPEED_PAGE);
    }

    public function deletePortSpeedInfo() {
        for ($i=8; $i >=0; $i--) {
            if ($this->getNetworkSwitchDevice(INDEX_BRACKET_LEFT.$i.INDEX_BRACKET_RIGHT)) {
                $this->deleteNetworkSwithPort(INDEX_BRACKET_LEFT.$i.INDEX_BRACKET_RIGHT);
            }
        }
    }

    public function deleteNetworkSwithPort($networkSwithcPortIndex) {
        $this->model->deleteNetworkSwithPort($networkSwithcPortIndex);
    }

    public function saveNetworkSwitchDevice() {
        $this->model->setNetworkSwitchDevice();
    }

    public function saveNetworkSwitchPortLink($speed) {
        $this->model->setNetworkSwitchPortLink($speed);
    }

}