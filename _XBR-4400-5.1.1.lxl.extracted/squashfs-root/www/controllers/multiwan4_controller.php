<?php

class Multiwan4_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(MULTI_WAN4. DS . MULTI_WAN4);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(MULTI_WAN4);

        if (isset($_POST[NEXT_BUTTON])) {
            $this->saveMultiWanInfo(WAN4, $_POST[WAN_NAME], $_POST[CONNECTION_TYPE_OPTIONS], $_POST[PRIMARY_DNS], $_POST[SECONDARY_DNS], $_POST[CUSTOM_MAC_ADDR], $_POST[CUSTOM_MTU],
                                    $_POST[PPPOE_USER], $_POST[PPPOE_PASSWORD], $_POST[PPPOE_SERVICE_NAME], $_POST[PPPOE_MAX_FAILED_PING], $_POST[PPPOE_PING_INTERVAL],$_POST[STATIC_IP],$_POST[NET_MASK], $_POST[GATE_WAY]);

            $this->saveMultiWanSettingsInfo(WAN4, $_POST[TRACKING_RELIABILITY], $_POST[PING_COUNT], $_POST[PING_TIME_OUT], $_POST[PING_INTERVAL], $_POST[INTERFACE_DOWN],
                                            $_POST[INTERFACE_UP], $_POST[IPV6_STATUS_OPTIONS]);

            $this->saveMultiWanWizardStatus(MULTI_WAN_WIZARD_STATUS_1);

            $this->saveNetworkEthPort(VLAN_ID_1, $this->getEth0PortVal(WAN4));
            $this->saveLuxulMultiWanPorts($this->getLuxulMultiWanPorts().SPACE. (WAN4 - 1));
            $this->saveFirewallZoneNetwork(INDEX_BRACKET_LEFT.INDEX_1.INDEX_BRACKET_RIGHT, WAN.SPACE.WAN.WAN2.SPACE.WAN.WAN3.SPACE.WAN.WAN4);

            $this->commit();
            header(LOCATION.MULTIWAN_POLICY_PAGE);
        } else if (isset($_POST[SAVE_BUTTON])) {
            if (!$this->getMwan3WanStatus(WAN4)) {
                $this->saveNetworkEthPort(VLAN_ID_1, $this->getEth0PortVal(WAN4));
                $this->saveLuxulMultiWanPorts($this->getLuxulMultiWanPorts().SPACE. (WAN4 - 1));
            }

            $this->saveMultiWanInfo(WAN4, $_POST[WAN_NAME], $_POST[CONNECTION_TYPE_OPTIONS], $_POST[PRIMARY_DNS], $_POST[SECONDARY_DNS], $_POST[CUSTOM_MAC_ADDR], $_POST[CUSTOM_MTU],
                $_POST[PPPOE_USER], $_POST[PPPOE_PASSWORD], $_POST[PPPOE_SERVICE_NAME], $_POST[PPPOE_MAX_FAILED_PING], $_POST[PPPOE_PING_INTERVAL],$_POST[STATIC_IP],$_POST[NET_MASK], $_POST[GATE_WAY]);

            $this->saveMultiWanSettingsInfo(WAN4, $_POST[TRACKING_RELIABILITY], $_POST[PING_COUNT], $_POST[PING_TIME_OUT], $_POST[PING_INTERVAL], $_POST[INTERFACE_DOWN],
                $_POST[INTERFACE_UP], $_POST[IPV6_STATUS_OPTIONS]);

            $this->saveFirewallZoneNetwork(INDEX_BRACKET_LEFT.INDEX_1.INDEX_BRACKET_RIGHT, WAN.SPACE.WAN.WAN2.SPACE.WAN.WAN3.SPACE.WAN.WAN4);

            $this->saveRebootRequired();
            $this->commit();
            header(LOCATION.MULTI_WAN_SETTING_PAGE);
        } else if (isset($_POST[CANCEL_BUTTON])) {
            header(LOCATION.MULTI_WAN_SETTING_PAGE);
        }
    }

    public function addContent() {
        $multiwan4 = EMPTY_STRING;
        $multiwan4_view = new View();

        $multiwan4_view->Assign(MULTI_WAN_WIZARD_STATUS, $this->getMultiWanWizardStatus());
        $this->assignWANInfo($multiwan4_view, WAN4);
        $this->assignMultiWanSettingsInfo($multiwan4_view, WAN4);

        $multiwan4 .= $multiwan4_view->Render(MULTI_WAN4.DS.SETUP, FALSE);
        $this->Assign(MULTI_WAN4, $multiwan4);

    }

}