<?php

class Quicksetup_Controller extends Controller{

    public function __construct() {
        parent::__construct();

        $this->Load_View(QUICK_SETUP.DS.QUICK_SETUP);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        if ($this->getMultiWanWizardStatus() == MULTI_WAN_WIZARD_STATUS_0 || $this->getMultiWanWizardStatus() == MULTI_WAN_WIZARD_STATUS_1) {
            $this->addHeader();
            $this->addLeftNav();
            $this->addContent();
            $this->addHelpMessage(QUICK_SETUP);

            if(isset($_POST[SAVE_BUTTON]) ){
                $this->save();
            } else if (isset($_POST[REBOOT_BUTTON])) {
                $this->reboot();
                header(LOCATION.REBOOT_PAGE.DS.QUICK_SETUP);
            }
        } else {

            header("Expires: 0");
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            header(LOCATION.FACTORY_DISPLAY_PAGE);
        }
    }

    public function addContent() {
        $this->addQuicksetupView();
    }

    public function addQuicksetupView() {
        $quick_setup = EMPTY_STRING;
        $quick_setup_view = new View();

        $this->assignRebootRequireView($quick_setup_view);
        $this->assignWANInfo($quick_setup_view, EMPTY_STRING);
        $this->assignLANIPAddr($quick_setup_view);
        $this->assignLANSubnetMask($quick_setup_view);

        $quick_setup_view->Assign(IPV4, $this->getIPV4Class());
        $quick_setup_view->Assign(CLASS_C_START, $this->getClassCStart());
        $quick_setup_view->Assign(CLASS_C_END, $this->getClassCEnd());

        $quick_setup .= $quick_setup_view->Render(QUICK_SETUP.DS.SETUP, FALSE);
        $this->Assign(QUICK_SETUP, $quick_setup);
    }

    public function assignLANSubnetMask($view) {
        $view->Assign(LAN_SUBNET_MASK, $this->getLanSubnetMask());
    }

    public function save() {
        $this->saveMultiWanInfo(EMPTY_STRING, EMPTY_STRING, $_POST[CONNECTION_TYPE_OPTIONS], $_POST[PRIMARY_DNS], $_POST[SECONDARY_DNS], $_POST[CUSTOM_MAC_ADDR], $_POST[CUSTOM_MTU],
                                $_POST[PPPOE_USER], $_POST[PPPOE_PASSWORD], $_POST[PPPOE_SERVICE_NAME], $_POST[PPPOE_MAX_FAILED_PING], $_POST[PPPOE_PING_INTERVAL],$_POST[STATIC_IP],$_POST[NET_MASK], $_POST[GATE_WAY]);

        $this->saveLanIPAddr();
        $this->savePPTPDLocalIp();
        $this->savePPTPDRemoteIP(PPTP_L2TP_IP_ADDR_START_OCTET_4_DEFAULT, PPTP_L2TP_IP_ADDR_END_OCTET_4_DEFAULT);
        $this->saveXL2TPDLocalIp();
        $this->saveXL2TPDRemoteIP(PPTP_L2TP_IP_ADDR_START_OCTET_4_DEFAULT, PPTP_L2TP_IP_ADDR_END_OCTET_4_DEFAULT);

        $this->saveRebootRequired();
        $this->commit();
        header(LOCATION.QUICKSETUP_PAGE);
    }

}