<?php

class Vlan_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(VLAN . DS . VLAN);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(VLAN);

        if (isset($_POST[SAVE_BUTTON])) {
            $this->save();
        } else if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . VLAN);
        }
    }

    public function addContent() {
        $this->addVlanView();
    }

    public function addVlanView() {
        $vlan = EMPTY_STRING;
        $vlan_view = new View();

        $this->assignRebootRequireView($vlan_view);
        $vlan_view->Assign(VLAN_STATUS_OPTIONS, $this->getVlanStatusOptions());
        $vlan_view->Assign(ALL_VLAN_INFO, $this->getAllVlanInfo());
        $vlan_view->Assign(PVID_INFO, $this->getPVIDInfo());

        $vlan .= $vlan_view->Render(VLAN . DS . SETUP, FALSE);
        $this->Assign(VLAN, $vlan);
    }

    public function getVlanStatusOptions() {
        $options = array(
            VLAN_DISABLED_KEY => VLAN_DISABLED_VAL,
            VLAN_ENABLED_KEY => VLAN_ENABLED_VAL
        );

        return $this->helper->selectOption($options, $this->getVlanStatus());
    }

    public function getAllVlanInfo() {
        $allVlanInfo = array();

        $allVlanArray = $this->getAllVlanArray();

        foreach ($allVlanArray as $vlanNum => $vlanID) {

            if ($vlanID != EMPTY_STRING) {

                $allVlanInfo[$vlanID] = array(
                    VLAN_ID => $vlanID,
                    VLAN_DESCRIPTION => $this->getVlanDescription($vlanNum),
                    MEMBERS => $this->getVlanMembers($vlanID),
                    VLAN_ROUTING => $this->getVlanRouting($vlanNum)
                );
            }
        }

        return $allVlanInfo;
    }

    public function getAllVlanArray() {
        $allVlanArray = array(
            VLAN_ID_1 => VLAN_ID_1
        );

        for ($i = 2; $i <= 16; $i++) {
            if ($this->getVLanVcfgEnabled($i) != VLAN_VCFG_DISABLE_KEY) {
                $allVlanArray[$i] = $this->getVlanVcfgVlanId($i);
            }
        }

        return $allVlanArray;
    }

    public function getPVIDInfo() {
        $pvIDInfo = array();

        $vlanPortsEnabled = str_replace(VLAN_PORT_0, EMPTY_STRING, $this->getLuxulMultiWanPorts());
        $vlanPortsEnabledArray = array_reverse(explode(SPACE, $vlanPortsEnabled));
        $vlanPortDefault = str_replace(VLAN_PORT_8T, EMPTY_STRING, VLAN_1_DEFAULT_PORT_VLAUE);
        $vlanPortDefaultArray = array_reverse(explode(SPACE, $vlanPortDefault));

        $vlanPortsAvailableArray = array_diff($vlanPortDefaultArray, $vlanPortsEnabledArray);

        if (count($vlanPortsAvailableArray) > 0) {
            foreach ($vlanPortsAvailableArray as $key => $vlanPort) {
                if ($vlanPort != EMPTY_STRING) {
                    $vlanPortReverse = $this->reverseVlanPort($vlanPort);

                    $pvIDPort = $this->getPVIDPort($vlanPort);
                    $pvIDInfo[$vlanPortReverse] = $pvIDPort;
                }
            }
        }

        return $pvIDInfo;
    }

    public function getPVIDPort($vlanPortReverse) {
        $pvidPort = VLAN_PORT_1;

        if ($this->getPVIDPortIndex($vlanPortReverse) != EMPTY_STRING) {
            foreach ($this->getPVIDPortIndex($vlanPortReverse) as $key => $switchPortIndexInfo) {
                $switchPortIndex = substr($switchPortIndexInfo, strpos($switchPortIndexInfo, INDEX_BRACKET_LEFT), 3);

                if ($this->getNetworkSwitchDevice($switchPortIndex)) {
                   continue;
                }

                if ($this->model->getPVIDPort($switchPortIndex)) {
                    $pvidPort = $this->model->getPVIDPort($switchPortIndex);
                } else {
                    $pvidPort = VLAN_PORT_1;
                }
            }
        } else {
            $pvidPort = VLAN_PORT_1;
        }

        return $pvidPort;
    }

    public function save() {
        $this->saveVlanStatus($_POST[VLAN_STATUS_OPTIONS]);
        $this->deletePvidPortInfo();

        if ($_POST[VLAN_STATUS_OPTIONS] == VLAN_DISABLED_KEY) {
            $this->saveNetworkEthPort(VLAN_ID_1, VLAN_1_DEFAULT_PORT_VLAUE);
            $this->deleteVlanInfo();
        } else {
            $this->saveVlanVcfgEnabled(VLAN_ID_1, VLAN_VCFG_ENABLED_KEY);
            $this->savePvidPortInfo();
        }

        $this->saveRebootRequired();
        $this->commit();
        header(LOCATION . VLAN_PAGE);
    }

    public function deleteVlanInfo() {
        $this->deleteVlan1();
        $this->deleteOtherVlans();
    }

    public function deleteVlan1() {
        $this->saveVlanVcfgEnabled(VLAN_ID_1, VLAN_VCFG_DISABLE_KEY);
        $this->saveVlanDescription(VLAN_ID_1, VLAN_1_DEFAULT_NAME);
    }

    public function deleteOtherVlans() {
        for ($i = 2; $i <= 16; $i++) {

            if ($this->getVlanVcfgEnabled($i) == VLAN_VCFG_ENABLED_KEY) {
                $vlanId = $this->getVlanVcfgVlanId($i);

                $this->saveVlanVcfgEnabled($i, VLAN_DISABLED_KEY);
                $this->saveVlanVcfgVlanId($i, VLAN_DISABLED_KEY);
                $this->saveVlanDescription($i, VLAN_DISABLED_KEY);
                $this->saveVlanVcfgRoutingEnabled($i, VLAN_DISABLED_KEY);

                $this->deleteNetworkEthSwitchVlan($vlanId);
                $this->deleteNetworkVlanInfo($vlanId);

                $this->deleteFirewallForwarding($vlanId);
                $this->deleteFirewallForwarding($vlanId);
                $this->deleteFirewallZone($vlanId);
                $this->deleteFirewallRuleBySrc($vlanId);
                $this->deleteFirewallRuleBySrc($vlanId);
                $this->deleteDhcpVlanInfo($vlanId);
            }
        }
    }

    public function deletePvidPortInfo() {
        for ($i=8; $i >=0; $i--) {
            $networkSwithcPortIndex = INDEX_BRACKET_LEFT.$i.INDEX_BRACKET_RIGHT;

            if ($this->model->getPVIDPort($networkSwithcPortIndex)) {
                $this->deleteNetworkSwithPort($networkSwithcPortIndex);
            }
        }
    }

    public function  savePvidPortInfo() {
        for ($i=1; $i <= 4; $i++) {
            if (isset($_POST[PVID.UNDERSCORE.$i])) {
                $this->addNetworkSwithPort();
                $this->saveNetworkSwitchPortVlanId(UCI_FIELD_INDEX_LAST, $_POST[PVID.UNDERSCORE.$i]);
                $this->saveNetworkSwitchPortNum(UCI_FIELD_INDEX_LAST, $this->reverseVlanPort($i));
                $this->saveNetworkSwitchPorPvid(UCI_FIELD_INDEX_LAST, $_POST[PVID.UNDERSCORE.$i]);
            }
        }
    }

    public function delete($vlanId) {
        $vlanNum = EMPTY_STRING;

        for ($i = 2; $i <= 16; $i++) {
            if ($this->getVlanVcfgVlanId($i) == $vlanId) {
                $vlanNum = $i;
                break;
            }
        }

        $this->saveVlanVcfgEnabled($vlanNum, VLAN_DISABLED_KEY);
        $this->saveVlanVcfgVlanId($vlanNum, VLAN_DISABLED_KEY);
        $this->saveVlanDescription($vlanNum, VLAN_DISABLED_KEY);
        $this->saveVlanVcfgRoutingEnabled($vlanNum, VLAN_DISABLED_KEY);

        $this->deleteNetworkEthSwitchVlan($vlanId);
        $this->deleteNetworkVlanInfo($vlanId);

        $this->deleteFirewallForwarding($vlanId);
        $this->deleteFirewallForwarding($vlanId);
        $this->deleteFirewallZone($vlanId);
        $this->deleteFirewallRuleBySrc($vlanId);
        $this->deleteFirewallRuleBySrc($vlanId);
        $this->deleteDhcpVlanInfo($vlanId);

        $this->saveRebootRequired();
        $this->commit();
        header(LOCATION . VLAN_PAGE);
    }

}