<?php

class Beta_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(BETA . DS . BETA);
        $this->Load_Model(BETA);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(BETA);

        if (isset($_POST[SAVE_BUTTON])) {
            $this->saveWanDelay();
            $this->saveRebootRequired();

            $this->commit();
            header(LOCATION . BETA_PAGE);

        } else if (isset($_POST[SAVE_WAN_VLAN_TAG])) {
            $this->saveWanVlanTag();
            $this->saveRebootRequired();

            $this->commit();
            header(LOCATION . BETA_PAGE);

        } else if (isset($_POST[SAVE_PORT_SPEED_INFO])) {
            $this->savePortSpeedInfo();
            $this->saveRebootRequired();

            $this->commit();
            header(LOCATION . BETA_PAGE);

        } else if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . QUICK_SETUP);
        }
    }

    public function addContent() {
        $beta = EMPTY_STRING;
        $beta_view = new View();

        $this->assignRebootRequireView($beta_view);
        $beta_view->Assign(PORT_MONITORING_OPTIONS, $this->getPortMonitorOptions());
        $beta_view->Assign(WAN_DELAY, $this->getWanDelay());
        $beta_view->Assign(WAN_VLAN_TAG_OPTIONS, $this->getWanVlanTagOptions());
        $beta_view->Assign(VLAN_ID, $this->getWanInterfaceName());
        $beta_view->Assign(BLOCK_SELF_ASSIGNED_IP_OPTIONS, $this->getBlockSelfAssignedIpOptions());
        $beta_view->Assign(WAN_PORT_OPTIONS, $this->getPortSpeedOptions(PORT_0));
        $beta_view->Assign(LAN_PORT_1_OPTIONS, $this->getPortSpeedOptions(PORT_4));
        $beta_view->Assign(LAN_PORT_2_OPTIONS, $this->getPortSpeedOptions(PORT_3));
        $beta_view->Assign(LAN_PORT_3_OPTIONS, $this->getPortSpeedOptions(PORT_2));
        $beta_view->Assign(LAN_PORT_4_OPTIONS, $this->getPortSpeedOptions(PORT_1));

        $beta .= $beta_view->Render(BETA . DS . SETUP, FALSE);
        $this->Assign(BETA, $beta);

    }

    public function getPortMonitorOptions() {
        $options = array(
            PORT_MONITOR_ENABLED_KEY => PORT_MONITOR_ENABLED_VAL,
            PORT_MONITOR_DISABLED_KEY => PORT_MONITOR_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getPortMonitor());
    }

    public function getPortMonitor() {
        return $this->model->getPortMonitor();
    }

    public function getWanDelay() {
        return $this->model->getWanDelay();
    }

    public function getWanVlanTagOptions() {
        $options = array(
            WAN_VLAN_TAG_ENABLED_KEY => WAN_VLAN_TAG_ENABLED_VAL,
            WAN_VLAN_TAG_DISABLED_KEY => WAN_VLAN_TAG_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getWanVlanTag());
    }

    public function getWanVlanTag() {
        $interfaceName = $this->getWanInterfaceName();
        $vlanPort = $this->getNetworkEth0Ports($interfaceName);

        return explode(SPACE, $vlanPort)[0] == WAN_VLAN_TAG_ENABLED_PORT ? WAN_VLAN_TAG_ENABLED_KEY : WAN_VLAN_TAG_DISABLED_KEY;
    }

    public function getWanInterfaceName() {
        return $this->model->getWanInterfaceName() != ETH0_408.VLAN_ID_1 ? $this->model->getWanInterfaceName() : WAN_VLAN_ID_DEFAULT;
    }

    public function getBlockSelfAssignedIpOptions() {
        $options = array(
            BLOCK_SELF_ASSIGNED_IP_ENABLED_KEY => BLOCK_SELF_ASSIGNED_IP_ENABLED_VAL,
            BLOCK_SELF_ASSIGNED_IP_DISABLED_KEY => BLOCK_SELF_ASSIGNED_IP_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getBlockSelfAssignedIp());
    }

    public function getBlockSelfAssignedIp() {
        return $this->model->getBlockSelfAssignedIp();
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

    public function save($portMonitorVal) {
        $this->savePortMonitor(urldecode($portMonitorVal));
        $this->saveRebootRequired();

        $this->commit();

        header(LOCATION . BETA_PAGE);
    }

    public function saveWanDelay() {
        $this->model->setWanDelay($_POST[WAN_DELAY]);
    }

    public function saveWanVlanTag() {
        if ($_POST[WAN_VLAN_TAG_OPTIONS] == WAN_VLAN_TAG_DISABLED_KEY) {
            $interfaceName = $this->getWanInterfaceName();
            $this->deleteNetworkEthSwitchVlan($interfaceName);
            $this->saveNetworkEthInfo(ETH0_408.VLAN_ID_1, SWITCH_VLAN_PORTS_DISABLED_VAL);
            $this->saveWanInterfaceName(ETH0_408.VLAN_ID_1);

        } else {
            $interfaceName = $this->getWanInterfaceName();
            $this->deleteNetworkEthSwitchVlan($interfaceName);
            $this->deleteNetworkEthSwitchVlan(ETH0_408.VLAN_ID_1);
            $this->saveNetworkEthInfo($_POST[VLAN_ID], SWITCH_VLAN_PORTS_ENABLED_VAL);
            $this->saveWanInterfaceName($_POST[VLAN_ID]);
        }
    }

    public function saveWanInterfaceName($vlanId) {
        $this->model->setWanInterfaceName($vlanId);
    }

    public function saveBlockIp($blockSelfAssignedIp) {
        if (urldecode($blockSelfAssignedIp) == BLOCK_SELF_ASSIGNED_IP_ENABLED_KEY) {
            $this->addFirewallRule();
            $this->saveFirewallRuleName(SELF_ASSIGNED_IP);
            $this->saveFirewallRuleSrc(LAN);
            $this->saveFirewallRuleSrcIp(SELF_ASSIGNED_IP_DEFAULT);
            $this->saveFirewallRuleProto(PROTOCAL_ALL_KEY);
            $this->saveFirewallRuleTarget(DROP);

        } else {
            $this->deleteFirewallRuleByName(SELF_ASSIGNED_IP);
        }

        $this->saveRebootRequired();

        $this->commit();

        header(LOCATION . BETA_PAGE);
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

        header(LOCATION . BETA_PAGE);
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