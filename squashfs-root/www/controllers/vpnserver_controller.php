<?php

class Vpnserver_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(VPN_SERVER . DS . VPN_SERVER);
        $this->Load_Model(VPN_SERVER);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(VPN_SERVER);

        if (isset($_POST[APPLY_BUTTON])) {
            $this->save();
        }
    }

    public function addContent() {
        $this->addVpnServerView();
    }

    public function addVpnServerView() {
        $vpn_server = EMPTY_STRING;
        $vpn_server_view = new View();

        $this->assignVpnModeOptions($vpn_server_view);
        $this->assignVpnAggressiveModeOptions($vpn_server_view);
        $this->assignLANIPAddr($vpn_server_view);
        $this->assignPresharedKey($vpn_server_view);
        $this->assignDhcpServer($vpn_server_view);
        $this->assignIPRangeInfo($vpn_server_view);

        $vpn_server .= $vpn_server_view->Render(VPN_SERVER . DS . SETUP, FALSE);
        $this->Assign(VPN_SERVER, $vpn_server);
    }

    public function assignVpnModeOptions($view) {
        $view->Assign(VPN_MODE_OPTIONS, $this->getVpnModeOptions());
    }

    public function assignVpnAggressiveModeOptions($view) {
        $view->Assign(IKE_AGGRESSIVE_MODE_OPTIONS, $this->getVpnAggressiveModeOptions());
    }

    public function assignPresharedKey($view) {
        $view->Assign(PRESHARED_KEY, $this->getPresharedKey());
    }

    public function assignDhcpServer($view) {
        $view->Assign(DHCP_SERVER, $this->getDhcpServer());
    }

    public function assignIPRangeInfo($view) {
        $view->Assign(IP_ADDR_START_BASE, $this->getIPAddrStartBase());
        $view->Assign(PPTP_IP_ADDR_START_OCTET_4, $this->getPPTPIPAddrStart4Octet());
        $view->Assign(L2TP_IP_ADDR_START_OCTET_4, $this->getL2TPIPAddrStart4Octet());
        $view->Assign(IP_ADDR_END_BASE, $this->getIPAddrEndBase());
        $view->Assign(PPTP_IP_ADDR_END_OCTET_4, $this->getPPTPIPAddrEnd4Octet());
        $view->Assign(L2TP_IP_ADDR_END_OCTET_4, $this->getL2TPIPAddrEnd4Octet());
    }

    public function getVpnModeOptions() {
        $options = array(
            VPN_MODE_DISABLED_KEY => VPN_MODE_DISABLED_VAL,
            VPN_MODE_PPTP_KEY => VPN_MODE_PPTP_VAL,
            VPN_MODE_IPSEC_KEY => VPN_MODE_IPSEC_VAL,
            VPN_MODE_L2TP_KEY => VPN_MODE_L2TP_VAL
        );

        return $this->helper->selectOption($options, $this->getVpnMode());
    }

    public function getVpnAggressiveModeOptions() {
        $options = array(
            VPN_AGGRESSIVE_MODE_DISABLED_KEY => VPN_AGGRESSIVE_MODE_DISABLED_VAL,
            VPN_AGGRESSIVE_MODE_ENABLED_KEY => VPN_AGGRESSIVE_MODE_ENABLED_VAL
        );

        return $this->helper->selectOption($options, $this->getVpnAggressiveMode());
    }

    public function getPresharedKey() {
        return $this->model->getPresharedKey();
    }

    public function getVpnAggressiveMode() {
        return $this->model->getVpnAggressiveMode();
    }

    public function getDhcpServer() {
        return $this->model->getDhcpServer();
    }

    public function getIPAddrStart() {
        return $this->model->getIPAddrStart();
    }

    public function getIPAddrStartBase() {
        $ipAddrStartBaseArray = explode(UCI_FIELD_DOT, $this->getIPAddrStart());
        return $ipAddrStartBaseArray[0] . UCI_FIELD_DOT . $ipAddrStartBaseArray[1] . UCI_FIELD_DOT . $ipAddrStartBaseArray[2] . UCI_FIELD_DOT;
    }

    public function getPPTPIPAddrStart4Octet() {
        $ipAddrStartBaseArray = explode(UCI_FIELD_DOT, $this->getIPAddrStart());
        return $ipAddrStartBaseArray[3];
    }

    public function getL2TPIPAddrStart4Octet() {
        $ipRangeArray = explode(HYPHEN, $this->getXL2TPDIpRange());
        $ipAddrStartBaseArray = explode(UCI_FIELD_DOT, $ipRangeArray[0]);
        return $ipAddrStartBaseArray[3];
    }

    public function getIPAddrEnd() {
        return $this->model->getIPAddrEnd();
    }

    public function getIPAddrEndBase() {
        $ipAddrEndBaseArray = explode(UCI_FIELD_DOT, $this->getIPAddrEnd());
        return $ipAddrEndBaseArray[0] . UCI_FIELD_DOT . $ipAddrEndBaseArray[1] . UCI_FIELD_DOT . $ipAddrEndBaseArray[2] . UCI_FIELD_DOT;
    }

    public function getPPTPIPAddrEnd4Octet() {
        $ipAddrEndBaseArray = explode(UCI_FIELD_DOT, $this->getIPAddrEnd());
        return $ipAddrEndBaseArray[3];
    }

    public function getL2TPIPAddrEnd4Octet() {
        $ipRangeArray = explode(HYPHEN, $this->getXL2TPDIpRange());
        return $ipRangeArray[1];
    }

    public function getXL2TPDIpRange() {
        return $this->model->getXL2TPDIpRange();
    }

    public function save()  {
        $this->saveVpnMode();

        $this->deletePPTPInfo();
        $this->deleteIPSECInfo();
        $this->deleteL2TPInfo();

        if ($_POST[VPN_MODE_OPTIONS] == VPN_MODE_PPTP_KEY) {
            $this->savePPTPInfo();
            $this->commit();

            $this->enableVpn(PPTPD);
            $this->startVpn(PPTPD);

        } else if ($_POST[VPN_MODE_OPTIONS] == VPN_MODE_IPSEC_KEY) {
            $this->saveIPSECInfo();
            $this->commit();

            $this->enableVpn(IPSEC);
            $this->startVpn(IPSEC);

        } else if ($_POST[VPN_MODE_OPTIONS] == VPN_MODE_L2TP_KEY) {
            $this->saveL2TPInfo();
            $this->commit();

            $this->enableVpn(IPSEC);
            $this->startVpn(IPSEC);

            $this->enableVpn(XL2TPD);
            $this->startVpn(XL2TPD);
        }

        header(LOCATION . VPN_SERVER_PAGE);
    }

    public function saveVpnMode() {
        $this->model->setVpnMode($_POST[VPN_MODE_OPTIONS]);
    }

    public function deletePPTPInfo() {
        $this->savePPTPDEnabled(PPTPD_DISBLED_KEY);
        $this->savePPTPDLocalIp();
        $this->savePPTPDRemoteIP(PPTP_L2TP_IP_ADDR_START_OCTET_4_DEFAULT, PPTP_L2TP_IP_ADDR_END_OCTET_4_DEFAULT);
        $this->stopVpn(PPTPD);
    }

    public function deleteIPSECInfo() {
        $this->saveIPSECStatus(IPSEC_DISABLED_KEY);
        $this->saveIpsecAggressiveMode(VPN_AGGRESSIVE_MODE_DISABLED_KEY);
        $this->saveIPSecPresharedKey(EMPTY_STRING);
        $this->saveDHCPServer(IPSEC_DEFAULT_LOCAL_IP);
        $this->stopVpn(IPSEC);
    }

    public function deleteL2TPInfo() {
        $this->saveXL2TPDEnabled(L2TP_DISBLED_KEY);
        $this->saveXL2TPDLocalIp();
        $this->saveXL2TPDRemoteIP(PPTP_L2TP_IP_ADDR_START_OCTET_4_DEFAULT, PPTP_L2TP_IP_ADDR_END_OCTET_4_DEFAULT);
        $this->stopVpn(XL2TPD);
    }

    public function savePPTPInfo() {
        $this->savePPTPDEnabled(PPTPD_ENABLED_KEY);
        $this->savePPTPDLocalIp();
        $this->savePPTPDRemoteIP($_POST[PPTP_IP_ADDR_START_OCTET_4], $_POST[PPTP_IP_ADDR_END_OCTET_4]);
    }

    public function saveIPSECInfo() {
        $this->saveIPSECStatus(IPSEC_ENABLED_KEY);
        $this->saveIpsecAggressiveMode($_POST[IKE_AGGRESSIVE_MODE_OPTIONS]);
        $this->saveIPSecPresharedKey($_POST[PRESHARED_KEY]);
        $this->saveDHCPServer($_POST[DHCP_SERVER]);
    }

    public function saveIPSECStatus($value) {
        $this->model->setIPSECStatus($value);
    }

    public function saveL2TPInfo() {
        $this->saveIPSECStatus(IPSEC_ENABLED_KEY);
        $this->saveXL2TPDEnabled(L2TP_ENABLED_KEY);
        $this->saveIPSecAggressiveMode(trim($_POST[IKE_AGGRESSIVE_MODE_OPTIONS]));
        $this->saveIPSecPresharedKey(trim($_POST[PRESHARED_KEY]));
        $this->saveXL2TPDLocalIp();
        $this->saveXL2TPDRemoteIP($_POST[L2TP_IP_ADDR_START_OCTET_4], $_POST[L2TP_IP_ADDR_END_OCTET_4]);
    }

    public function savePPTPDEnabled($value) {
        $this->model->setPPTPDEnabled($value);
    }

    public function saveIPSecAggressiveMode($value) {
        $this->model->setIPSecAggressiveMode($value);
    }

    public function saveIPSecPresharedKey($value) {
        $this->model->setIPSecPresharedKey($value);
    }

    public function saveDHCPServer($value) {
        $this->model->setDHCPServer(preg_replace(REMOVE_NEW_LINE_REGEX, EMPTY_STRING, $value));
    }

    public function saveXL2TPDEnabled($value) {
        $this->model->setXL2TPDEnabled($value);
    }

    public function enableVpn($vpnMode) {
        $this->model->enableVpn($vpnMode);
    }

}