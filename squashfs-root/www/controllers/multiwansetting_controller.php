<?php

class Multiwansetting_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(MULTI_WAN_SETTING. DS . MULTI_WAN_SETTING);
        $this->Load_Model(MULTI_WAN_SETTING);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(MULTI_WAN_SETTING);

        if (isset($_POST[SAVE_BUTTON])) {
            $this->save();

            if ($this->getMultiWanWizardStatus() == MULTI_WAN_WIZARD_STATUS_0 && $this->getMultiWanStatus() == MULTI_WAN_STATUS_ENABLED_KEY) {
                header(LOCATION.MULTI_WAN_PAGE);
            } else {
                header(LOCATION.MULTI_WAN_SETTING_PAGE);
            }

        } else if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION.REBOOT_PAGE.DS.MULTI_WAN_SETTING);
        }
    }

    public function addContent() {
        $multiwansetting = EMPTY_STRING;
        $multiwansetting_view = new View();

        $this->assignRebootRequireView($multiwansetting_view);

        $multiwansetting_view->Assign(ROUTER_LIMITS_STATUS, $this->getRouterLimits());
        $multiwansetting_view->Assign(MULTI_WAN_WIZARD_STATUS, $this->getMultiWanWizardStatus());
        $multiwansetting_view->Assign(MULTI_WAN_STATUS_OPTIONS, $this->getMultiWanStatusOptions());

        $multiwansetting_view->Assign(WAN.WAN3, $this->getMwan3WanStatus(WAN3));
        $multiwansetting_view->Assign(WAN.WAN4, $this->getMwan3WanStatus(WAN4));

        $multiwansetting_view->Assign(MULTI_WAN_POLICY_OPTIONS, $this->helper->getMultiWanPolicyOptions($this->getMultiWanDefaultPolicy()));

        $multiwansetting .= $multiwansetting_view->Render(MULTI_WAN_SETTING.DS.SETUP, FALSE);
        $this->Assign(MULTI_WAN_SETTING, $multiwansetting);
    }

    public function getMultiWanStatusOptions() {
        $options=array(
            MULTI_WAN_STATUS_ENABLED_KEY => MULTI_WAN_STATUS_ENABLED_VAL,
            MULTI_WAN_STATUS_DISABLED_KEY => MULTI_WAN_STATUS_DISABLED_VAL
        );

        return $this->helper->selectOption($options, $this->getMultiWanStatus());
    }

    public function save() {
        if ($this->getMultiWanStatus() == MULTI_WAN_STATUS_ENABLED_KEY && $_POST[MULTI_WAN_STATUS] == MULTI_WAN_STATUS_DISABLED_KEY) {
            $this->saveMultiWanPortsInfo();

            $this->saveMwan3WanStatus(EMPTY_STRING, MWAN3_STATUS_DISABLED_KEY);
            $this->saveMwan3WanStatus(WAN2, MWAN3_STATUS_DISABLED_KEY);
            $this->saveMwan3WanStatus(WAN3, MWAN3_STATUS_DISABLED_KEY);
            $this->saveMwan3WanStatus(WAN4, MWAN3_STATUS_DISABLED_KEY);

            $this->saveFirewallZoneNetwork(INDEX_BRACKET_LEFT.INDEX_1.INDEX_BRACKET_RIGHT, WAN);

            $this->saveWanName(WAN.EMPTY_STRING, EMPTY_STRING);
            $this->saveWanName(WAN.WAN2, EMPTY_STRING);
            $this->saveWanName(WAN.WAN3, EMPTY_STRING);
            $this->saveWanName(WAN.WAN4, EMPTY_STRING);

            $this->deleteWan(WAN2);
            $this->deleteWan(WAN3);
            $this->deleteWan(WAN4);

            $this->deleteNetworkEthSwitchVlan(ETH0_408.WAN2);
            $this->deleteNetworkEthSwitchVlan(ETH0_408.WAN3);
            $this->deleteNetworkEthSwitchVlan(ETH0_408.WAN4);

            $this->saveMultiWanDefaultPolicy(MULTI_WAN_POLICY_BALANCED_KEY);
            $this->saveRebootRequired();
        }

        if ($_POST[MULTI_WAN_STATUS] == MULTI_WAN_STATUS_DISABLED_KEY) {
            $this->saveMultiWanWizardStatus(MULTI_WAN_WIZARD_STATUS_0);
            $this->savePortMonitor(MULTI_WAN_STATUS_DISABLED_KEY);
        } else {
            $this->savePortMonitor(MULTI_WAN_STATUS_ENABLED_KEY);
            $this->saveWanAccelerationStatus(WAN_ACCELERATION_DISABLED_KEY);
        }

        if ($this->getMultiWanWizardStatus() == MULTI_WAN_STATUS_ENABLED_KEY) {
            $this->saveMultiWanDefaultPolicy($_POST[MULTI_WAN_POLICY_OPTIONS]);
        }

        $this->saveMultiWanStatus($_POST[MULTI_WAN_STATUS]);
        $this->saveRebootRequired();

        $this->commit();
    }

    public function saveMultiWanPortsInfo() {
        $this->saveLuxulMultiWanPorts(LUXUL_DYNAMIC_MULTI_WAN_PORTS_0);
        $this->saveNetworkEthPort(VLAN_ID_1, NETWORK_ETH0_1_PORTS_DEFAULT);
    }

    public function deleteWanInterface($wanNum) {
        $this->saveWanName(WAN.$wanNum, EMPTY_STRING);
        $this->deleteWan($wanNum);
        $this->deleteNetworkEthSwitchVlan(ETH0_408.$wanNum);
        $this->saveMwan3WanStatus($wanNum, MWAN3_STATUS_DISABLED_KEY);

        $this->saveNetworkEthPort(VLAN_ID_1, $this->reverseEth0PortVal($wanNum));
        $this->saveLuxulMultiWanPorts($this->reverseLuxulMultiWanPorts($wanNum));

        $firezoneNetwork = WAN;
        for ($i=2; $i<$wanNum; $i++) {
            $firezoneNetwork .= SPACE.WAN.$i;
        }

        $this->saveFirewallZoneNetwork(INDEX_BRACKET_LEFT.INDEX_1.INDEX_BRACKET_RIGHT, $firezoneNetwork);

        $this->commit();
        $this->saveRebootRequired();
        header(LOCATION.MULTI_WAN_SETTING_PAGE);
    }

}