<?php

class Dhcp_Controller extends Controller{

    public function __construct() {
        parent::__construct();

        $this->Load_View(DHCP.DS.DHCP);
        $this->Load_Model(DHCP);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(DHCP);

        if(isset($_POST[SAVE_BUTTON]) ){
            $this->save();
        } else if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION.REBOOT_PAGE.DS.DHCP);
        }
    }

    public function addContent() {
        $this->addDHCPView();
    }

    public function addDHCPView() {
        $dhcp = EMPTY_STRING;
        $dhcp_view = new View();

        $this->assignRebootRequireView($dhcp_view);
        $this->assignDHCPServerInfo($dhcp_view);
        $this->assignLanInfo($dhcp_view) ;
        $this->assignDHCPRangeInfo($dhcp_view);
        $dhcp_view->Assign(VLAN_STATUS, $this->getVlanStatus());
        $dhcp_view->Assign(IPV4_CLASS, $this->getIPV4Class());

        $dhcp .= $dhcp_view->Render(DHCP.DS.SETUP, FALSE);
        $this->Assign(DHCP, $dhcp);
    }

    public function assignDHCPServerInfo($view) {
        $view->Assign(DHCP_SERVER_OPTIONS, $this->getDHCPServerOptions());
        $view->Assign(IPV4_CLASS_OPTIONS, $this->getIPV4ClassOptions());
    }

    public function assignDHCPRangeInfo($view) {
        $this->assignClassCRangeInfo($view);
        $this->assignClassBRangeInfo($view);
    }

    public function assignClassBRangeInfo($view) {
        $view->Assign(CLASS_B_START, $this->getClassBStart());
        $view->Assign(CLASS_B_IP_ADDR_NUM, $this->getIPAddrNum());
        $view->Assign(CLASS_B_END, $this->getClassBEnd());
        $view->Assign(CLASS_B_LEASE_TIME, $this->getLeaseTime());
    }

    public function assignLanInfo($view) {
        $this->assignLANIPAddr($view);
        $this->assignLANSubnetMask($view);
        $this->assignLANIPAddrStart($view);
        $this->assignLANIPAddrEnd($view);
    }

    public function assignLANSubnetMask($view) {
        $view->Assign(CLASS_B_LAN_SUBNET_MASK_OPTIONS, $this->getLanSubnetMaskOptions(VLAN_ID_1));
    }

    public function assignLANIPAddrStart($view) {
        $view->Assign(LAN_IP_ADDR_START, $this->getLanIPAddrStart());
    }

    public function assignLANIPAddrEnd($view) {
        $view->Assign(LAN_IP_ADDR_END, $this->getLanIPAddrEnd());
    }

    public function getDHCPServerOptions() {
        $options=array(
            DHCP_SERVER_STATUS_ENABLED_KEY => DHCP_SERVER_STATUS_ENABLED_VAL,
            DHCP_SERVER_STATUS_DISBLED_KEY => DHCP_SERVER_STATUS_DISBLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getDHCPServerStatus());
    }

    public function getDHCPServerStatus() {
        return $this->model->getDHCPServerStatus();
    }

    public function getIPV4ClassOptions() {
        $options=array(
            IPV4_CLASS_C_KEY => IPV4_CLASS_C_VAL,
            IPV4_CLASS_B_KEY => IPV4_CLASS_B_VAL,
        );

        return $this->helper->selectOption($options, $this->getIPV4Class());
    }

    public function save() {
        $this->saveDHCPServerStatus();
        $this->saveIPV4Class();

        if ($_POST[IPV4_CLASS_OPTIONS] == IPV4_CLASS_B_KEY) {
            $this->saveLanIPAddr();
            $this->savePPTPDLocalIp();
            $this->savePPTPDRemoteIP(PPTP_L2TP_IP_ADDR_START_OCTET_4_DEFAULT, PPTP_L2TP_IP_ADDR_END_OCTET_4_DEFAULT);
            $this->saveXL2TPDLocalIp();
            $this->saveXL2TPDRemoteIP(PPTP_L2TP_IP_ADDR_START_OCTET_4_DEFAULT, PPTP_L2TP_IP_ADDR_END_OCTET_4_DEFAULT);
            $this->saveLanSubnetMask(TRUE);
            $this->saveLanIPAddrStart($_POST[CLASS_B_LAN_IP_ADDR_START]);
            $this->saveLanIPAddrEnd($_POST[CLASS_B_LAN_IP_ADDR_END]);
            $this->saveClassBStart($_POST[CLASS_B_START]);
            $this->saveDHCPStart($this->calDhcpStart($_POST[CLASS_B_START], trim($_POST[CLASS_B_LAN_IP_ADDR_START])));
            $this->saveDHCPStart($this->calDhcpStart($_POST[CLASS_B_START], trim($_POST[CLASS_B_LAN_IP_ADDR_START])));
            $this->saveIPAddrNum($_POST[CLASS_B_IP_ADDR_NUM]);
            $this->saveClassBEnd($_POST[CLASS_B_END]);
            $this->saveLeaseTime($_POST[CLASS_B_LEASE_TIME].DHCP_LEASE_TIME_HOUR_UNIT);

        } else {
            $this->saveLanIPAddrStart(EMPTY_STRING);
            $this->saveLanIPAddrEnd(EMPTY_STRING);
            $this->saveClassBStart(EMPTY_STRING);
            $this->saveClassBEnd(EMPTY_STRING);

            $this->saveLanSubnetMask(FALSE);
            $this->saveDHCPStart($_POST[CLASS_C_START]);
            $this->saveIPAddrNum($_POST[CLASS_C_IP_ADDR_NUM]);
            $this->saveLeaseTime($_POST[CLASS_C_LEASE_TIME].DHCP_LEASE_TIME_HOUR_UNIT);
        }

        $this->saveRebootRequired();
        $this->commit();
        header(LOCATION.DHCP_PAGE);
    }

    public function saveDHCPServerStatus() {
        $this->model->setDHCPServerStatus($_POST[DHCP_SERVER_OPTIONS]);
    }

    public function saveIPV4Class() {
        $this->model->setIPV4Class($_POST[IPV4_CLASS_OPTIONS]);
    }

    public function saveLanSubnetMask($classBCheck) {
        $this->model->setLanSubnetMask($classBCheck? $_POST[CLASS_B_LAN_SUBNET_MASK_OPTIONS] : SUBNET_MASK_255_255_255_0_VAL);
    }

    public function saveLanIPAddrStart($value) {
        $this->model->setLanIPAddrStart($value);
    }

    public function saveLanIPAddrEnd($value) {
        $this->model->setLanIPAddrEnd($value);
    }

    public function saveDHCPStart($value) {
        $this->model->setDHCPStart($value);
    }

    public function saveClassBStart($value) {
        $this->model->setClassBStart($value);
    }

    public function calDhcpStart($classBDhcpStart, $classBLanIPAddrStart) {
        return ip2long($classBDhcpStart) - ip2long($classBLanIPAddrStart) + 1;
    }

    public function saveClassBEnd($value) {
        $this->model->setClassBEnd($value);
    }


}