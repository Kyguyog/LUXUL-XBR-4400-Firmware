<?php

class Vpnuser_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(VPN_USER . DS . VPN_USER);
        $this->Load_Helper(HELPER);
    }

    public function display($applyCheck) {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent($applyCheck);
        $this->addHelpMessage(VPN_USER);
    }

    public function addContent($applyCheck) {
        $this->addVpnUserView($applyCheck);
    }

    public function addVpnUserView($applyCheck) {
        $vpn_user = EMPTY_STRING;
        $vpn_user_view = new View();

        $vpn_user_view->Assign(APPLY_CHANGES, $applyCheck);

        $this->assignVpnModeView($vpn_user_view);
        $this->assignVpnUserInfoView($vpn_user_view);

        $vpn_user .= $vpn_user_view->Render(VPN_USER . DS . SETUP, FALSE);
        $this->Assign(VPN_USER, $vpn_user);
    }

    public function assignVpnModeView($view) {
        $view->Assign(VPN_MODE, $this->getVpnModeVal());
    }

    public function assignVpnUserInfoView($view) {
        $view->Assign(VPN_USER_INFO, $this->geVpnUserInfo());
    }

    public function getVpnModeVal() {
        $vpnMode = $this->getVpnMode();
        $vpnModeVal = EMPTY_STRING;

        if ($vpnMode == VPN_MODE_PPTP_KEY) {
            $vpnModeVal = VPN_MODE_PPTP_VAL;
        } else if ($vpnMode == VPN_MODE_L2TP_KEY) {
            $vpnModeVal = VPN_MODE_L2TP_VAL;
        } else if ($vpnMode == VPN_MODE_IPSEC_KEY) {
            $vpnModeVal = VPN_MODE_IPSEC_VAL;
        }

        return $vpnModeVal;
    }

    public function save($tableData) {
        $this->createVpnUserFile();

        $vpnUserInfoArray = explode(COMMA, $tableData);

        $this->addVpnUserLogin();
        $this->saveVpnUserName(trim($vpnUserInfoArray[0]), UCI_FIELD_INDEX_LAST);
        $this->saveVpnUserPassword(trim($vpnUserInfoArray[1]), UCI_FIELD_INDEX_LAST);
        $this->commit();

        header(LOCATION . VPN_USER_PAGE. DS. TRUE);
    }

    public function edit($tableData) {
        $vpnUserInfoArray = explode(COMMA, $tableData);

        $this->saveVpnUserName(trim($vpnUserInfoArray[0]), INDEX_BRACKET_LEFT.$vpnUserInfoArray[2].INDEX_BRACKET_RIGHT);
        $this->saveVpnUserPassword(trim($vpnUserInfoArray[1]), INDEX_BRACKET_LEFT.$vpnUserInfoArray[2].INDEX_BRACKET_RIGHT);
        $this->commit();

        header(LOCATION . VPN_USER_PAGE. DS. TRUE);
    }

    public function delete($index) {
        $this->deleteVpnUserLogin($index);
        $this->saveVpnUserInfoByMode();

        $this->commit();
        header(LOCATION . VPN_USER_PAGE. DS. TRUE);
    }

    public function saveVpnUserInfoByMode() {
        $this->stopVpn(PPTPD);
        $this->stopVpn(IPSEC);
        $this->stopVpn(XL2TPD);

        $vpnMode = $this->getVpnMode();

        if ($vpnMode == VPN_MODE_PPTP_KEY) {
            $this->startVpn(PPTPD);

        } else if ($vpnMode == VPN_MODE_IPSEC_KEY) {
            $this->startVpn(IPSEC);

        } else if ($vpnMode == VPN_MODE_L2TP_KEY) {
            $this->startVpn(IPSEC);
            $this->startVpn(XL2TPD);
        }

        header(LOCATION . VPN_USER_PAGE);
    }

}