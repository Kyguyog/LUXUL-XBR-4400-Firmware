<?php

class Multiwanreport_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(MULTI_WAN_REPORT . DS . MULTI_WAN_REPORT);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(MULTI_WAN_REPORT);
    }

    public function addContent() {
        $multiwan_report = EMPTY_STRING;
        $multiwan_report_view = new View();

        $multiwan_report_view->Assign(MULTI_WAN_REPORT_OPTIONS, $this->getMultiWanReportOptions());
        $multiwan_report_view->Assign(MULTI_WAN_INTERFACE, $this->getMultiWanInterface());
        $multiwan_report_view->Assign(MULTI_WAN_INTERFACE_STATUS, $this->checkMultiWanInterfaceStatus());

        for ($i=1; $i<=4; $i++) {
            $this->assignWanSettingsInfo($multiwan_report_view, $i==VLAN_ID_1 ? EMPTY_STRING : $i);
            $this->assignWanMTU($multiwan_report_view, $i==VLAN_ID_1 ? EMPTY_STRING : $i);
            $this->assignWanMetric($multiwan_report_view, $i==VLAN_ID_1 ? EMPTY_STRING : $i);
        }

        $multiwan_report_view->Assign(MULTI_WAN_POLICY_STATUS, $this->getMultiWanPolicyStatus());

        $multiwan_report .= $multiwan_report_view->Render(MULTI_WAN_REPORT . DS . INFO, FALSE);
        $this->Assign(MULTI_WAN_REPORT, $multiwan_report);
    }

    public function getMultiWanReportOptions() {
        $options=array(
            MULTI_WAN_REPORT_SELECT_REPORT_KEY => MULTI_WAN_REPORT_SELECT_REPORT_VAL,
            MULTI_WAN_REPORT_FULL_REPORT_KEY => MULTI_WAN_REPORT_FULL_REPORT_VAL,
            MULTI_WAN_REPORT_INTERFACE_REPORT_KEY => MULTI_WAN_REPORT_INTERFACE_REPORT_VAL,
            MULTI_WAN_REPORT_POLICY_REPORT_KEY => MULTI_WAN_REPORT_POLICY_REPORT_VAL
        );

        return $this->helper->selectOption($options, MULTI_WAN_REPORT_SELECT_REPORT_KEY);
    }

    public function getMultiWanInterface() {
        $multiWanInterface = array();
        $key = EMPTY_STRING;
        $multiWanInterfaceStatus = EMPTY_STRING;

        $multiWanInterfaceArray = $this->getMultiWanInterfaceStatus();

        for ($i=1; $i<=4; $i++) {
            if ($this->getMwan3WanStatus($i==VLAN_ID_1 ? EMPTY_STRING : $i)) {
                $wanInterfaceName = $this->getWanName(WAN.($i==VLAN_ID_1 ? EMPTY_STRING : $i));
                $multiWanInterfaceStatusInfo = $multiWanInterfaceArray[$i];

                if (strpos($multiWanInterfaceStatusInfo, OFFLINE) !== FALSE) {
                    $key = OFFLINE;
                    $multiWanInterfaceStatus = strtoupper(WAN). ($i==VLAN_ID_1 ? EMPTY_STRING : $i).SPACE. ucwords($wanInterfaceName);
                } else if (strpos($multiWanInterfaceStatusInfo, ONLINE) !== FALSE) {
                    $key = ONLINE;
                    $multiWanInterfaceStatus = strtoupper(WAN). ($i==VLAN_ID_1 ? EMPTY_STRING : $i).SPACE. ucwords($wanInterfaceName);
                }

                $multiWanInterface[$i.UNDERSCORE.$key] = $multiWanInterfaceStatus;
            }
        }

        return $multiWanInterface;
    }

    public function checkMultiWanInterfaceStatus() {
        $wanPortStateInfo = $this->getAllPortsState();
        $multiWanIntferfacesStatusArray = $this->getMultiWanInterfaceStatus();

        for ($i=0; $i<=3; $i++) {
            if (strpos($wanPortStateInfo[$i], LINK_DOWN) == TRUE) {
                unset($multiWanIntferfacesStatusArray[$i+1]);
            }
        }

        return $multiWanIntferfacesStatusArray;
    }

}