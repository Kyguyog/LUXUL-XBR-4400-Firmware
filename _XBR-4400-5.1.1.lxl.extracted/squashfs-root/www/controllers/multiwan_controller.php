<?php

class Multiwan_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(MULTI_WAN. DS . MULTI_WAN);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(MULTI_WAN);

        if (isset($_POST[ADD_WAN_BUTTON])) {
            $this->saveMultiWanInfo(EMPTY_STRING, $_POST[WAN_NAME], $_POST[CONNECTION_TYPE_OPTIONS], $_POST[PRIMARY_DNS], $_POST[SECONDARY_DNS], $_POST[CUSTOM_MAC_ADDR], $_POST[CUSTOM_MTU],
                                    $_POST[PPPOE_USER], $_POST[PPPOE_PASSWORD], $_POST[PPPOE_SERVICE_NAME],$_POST[PPPOE_MAX_FAILED_PING], $_POST[PPPOE_PING_INTERVAL],$_POST[STATIC_IP],$_POST[NET_MASK], $_POST[GATE_WAY]);

            $this->saveMultiWanSettingsInfo(EMPTY_STRING, $_POST[TRACKING_RELIABILITY], $_POST[PING_COUNT], $_POST[PING_TIME_OUT], $_POST[PING_INTERVAL], $_POST[INTERFACE_DOWN],
                                            $_POST[INTERFACE_UP], $_POST[IPV6_STATUS_OPTIONS]);

            $this->commit();

            header(LOCATION.MULITI_WAN2_PAGE);
        } else if (isset($_POST[SAVE_BUTTON])) {
            $this->saveMultiWanInfo(EMPTY_STRING, $_POST[WAN_NAME], $_POST[CONNECTION_TYPE_OPTIONS], $_POST[PRIMARY_DNS], $_POST[SECONDARY_DNS], $_POST[CUSTOM_MAC_ADDR], $_POST[CUSTOM_MTU],
                $_POST[PPPOE_USER], $_POST[PPPOE_PASSWORD], $_POST[PPPOE_SERVICE_NAME], $_POST[PPPOE_MAX_FAILED_PING], $_POST[PPPOE_PING_INTERVAL],$_POST[STATIC_IP],$_POST[NET_MASK], $_POST[GATE_WAY]);

            $this->saveMultiWanSettingsInfo(EMPTY_STRING, $_POST[TRACKING_RELIABILITY], $_POST[PING_COUNT], $_POST[PING_TIME_OUT], $_POST[PING_INTERVAL], $_POST[INTERFACE_DOWN],
                $_POST[INTERFACE_UP], $_POST[IPV6_STATUS_OPTIONS]);

            $this->saveRebootRequired();
            $this->commit();

            header(LOCATION.MULTI_WAN_SETTING_PAGE);
        } else if (isset($_POST[CANCEL_BUTTON])) {
            header(LOCATION.MULTI_WAN_SETTING_PAGE);
        }
    }

    public function addContent() {
        $multiwan = EMPTY_STRING;
        $multiwan_view = new View();

        $multiwan_view->Assign(MULTI_WAN_WIZARD_STATUS, $this->getMultiWanWizardStatus());
        $this->assignWANInfo($multiwan_view, EMPTY_STRING);
        $this->assignMultiWanSettingsInfo($multiwan_view, EMPTY_STRING);

        $multiwan .= $multiwan_view->Render(MULTI_WAN.DS.SETUP, FALSE);
        $this->Assign(MULTI_WAN, $multiwan);

    }

}