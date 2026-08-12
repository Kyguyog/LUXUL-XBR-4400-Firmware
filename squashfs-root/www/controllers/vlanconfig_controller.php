<?php

class Vlanconfig_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(VLAN_CONFIG . DS . VLAN_CONFIG);
        $this->Load_Model(VLAN_CONFIG);
        $this->Load_Helper(HELPER);
    }

    public function display($vlanID) {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent($vlanID);
        $this->addHelpMessage(VLAN_CONFIG);

        if (isset($_POST[SAVE_BUTTON])) {
            $this->save();
        }
    }

    public function addContent($vlanId) {
        $this->addVlanConfigView($vlanId);
    }

    public function addVlanConfigView($vlanId) {
        $vlan_config = EMPTY_STRING;
        $vlan_config_view = new View();

        $vlanNum = $vlanId != VLAN_ID_1 ? $this->checkVlanEdit($vlanId) : VLAN_ID_1;

        $this->assignRebootRequireView($vlan_config_view);
        $vlan_config_view->Assign(VLAN_ID, $vlanId);
        $vlan_config_view->Assign(VLAN_DESCRIPTION, $this->getVlanDescription($vlanNum) == VLAN_DESCRIPTION_0 ? EMPTY_STRING : $this->getVlanDescription($vlanNum));
        $vlan_config_view->Assign(VLAN_ROUTING, $this->getVlanRoutingOptions($vlanNum));
        $vlan_config_view->Assign(VLAN_PORTS_INFO, $this->getVlanPortsInfo($vlanId));
        $vlan_config_view->Assign(IP_ADDRESS, $this->getIPAddr($vlanId));
        $vlan_config_view->Assign(SUBNET_MASK, $this->getSubnetMask($vlanId));
        $vlan_config_view->Assign(DHCP_SERVER_STATUS, $this->getDHCPServerStatus($vlanId));

        $vlan_config_view->Assign(IPV4_CLASS_C, $this->getIPV4Class() == IPV4_CLASS_C_KEY ? TRUE : FALSE);
        $vlan_config_view->Assign(IPV4_CLASS, $this->getIPV4Class());

        $vlan_config_view->Assign(CLASS_C_BASE, $this->getClassCBase($vlanId));
        $vlan_config_view->Assign(CLASS_C_START, $this->getDhcpVlanStart($vlanId));
        $vlan_config_view->Assign(CLASS_C_END, $this->getDhcpVlanEnd($vlanId));
        $vlan_config_view->Assign(CLASS_B_START, $this->getDhcpVlanStart($vlanId));
        $vlan_config_view->Assign(CLASS_B_END, $this->getDhcpVlanEnd($vlanId));
        $vlan_config_view->Assign(LEASE_TIME, $this->getDhcpVlanLeaseTime($vlanId));

        $vlan_config .= $vlan_config_view->Render(VLAN_CONFIG . DS . SETUP, FALSE);
        $this->Assign(VLAN_CONFIG, $vlan_config);
    }

    public function getDhcpVlanStart($vlanID) {
        if ($this->getIPV4Class() == IPV4_CLASS_C_KEY) {
            $dhcpVlanStart = $this->getDhcpLanStart();

            if ($this->model->getDhcpVlanStart($vlanID)) {
                $dhcpVlanStart = $this->model->getDhcpVlanStart($vlanID);
            }

        } else {
            if ($vlanID == VLAN_ID_1) {
                $dhcpVlanStart = long2ip(ip2long($this->getLanIPAddr()) + $this->getDhcpLanStart() - 1);
            } else {
                if ($this->model->getDhcpVlanStart($vlanID)) {
                    $dhcpVlanStart = long2ip(ip2long($this->getIPAddr($vlanID)) + $this->model->getDhcpVlanStart($vlanID));
                } else {
                    $dhcpVlanStart = EMPTY_STRING;
                }
            }
        }
        return $dhcpVlanStart;
    }

    public function getDhcpLanStart() {
        return $this->model->getDhcpLanStart();
    }

    public function getDhcpVlanEnd($vlanID) {
        if ($this->getIPV4Class() == IPV4_CLASS_C_KEY) {
            $dhcpVlanEnd = $this->getDhcpVlanStart($vlanID) + $this->getDhcpVlanLimit($vlanID);
        } else {
            if ($this->getDhcpVlanStart($vlanID)) {
                $dhcpVlanEnd = long2ip(ip2long($this->getDhcpVlanStart($vlanID)) + $this->getDhcpVlanLimit($vlanID) -1);
            } else {
                $dhcpVlanEnd = EMPTY_STRING;
            }
        }
        return $dhcpVlanEnd;
    }

    public function getDhcpVlanLimit($vlanID) {
        return $this->model->getDhcpVlanLimit($vlanID);
    }

    public function getDhcpVlanLeaseTime($vlanID) {
        return $this->model->getDhcpVlanLeaseTime($vlanID);
    }

    public function getVlanRoutingOptions($vlanID) {
        $options = array(
            VLAN_ROUTING_ENABLED_KEY => VLAN_ROUTING_ENABLED_VAL,
            VLAN_ROUTING_DISABLED_CODE => VLAN_ROUTING_DISABLED_VAL
        );

        return $this->helper->selectOption($options, $this->getVlanRouting($vlanID));
    }

    public function getSubnetMask($vlanID) {
        if ($vlanID == VLAN_ID_1) {
            $subnetMask = $this->getLanSubnetMask();
        } else {
            if ($this->getIPV4Class() == IPV4_CLASS_C_KEY) {
                $subnetMask = $this->getVlanSubnetMask($vlanID);
            } else {
                $subnetMask = $this->getLanSubnetMaskOptions($vlanID);
            }
        }

        return $subnetMask;
    }

    public function getDHCPServerStatus($vlanID) {
        return $vlanID == VLAN_ID_1 ? $this->model->getDHCPServerStatus() : $this->getVlanDHCPServerStatus($vlanID);
    }

    public function getVlanDHCPServerStatus($vlanID) {
        return $this->model->getVlanDHCPServerStatus($vlanID);
    }

    public function getVlanRouting($vlanID) {
        return $this->model->getVlanRouting($vlanID);
    }

    public function getVlanPortsInfo($vlanId) {
        $vlanPortsInfo = array();

        $vlanPortsEnabled = str_replace(VLAN_PORT_0, EMPTY_STRING, $this->getLuxulMultiWanPorts());
        $vlanPortsEnabledArray = array_reverse(explode(SPACE, $vlanPortsEnabled));
        $vlanPortDefault = str_replace(VLAN_PORT_8T, EMPTY_STRING, VLAN_1_DEFAULT_PORT_VLAUE);
        $vlanPortDefaultArray = array_reverse(explode(SPACE, $vlanPortDefault));

        $vlanPortsAvailableArray = array_diff($vlanPortDefaultArray, $vlanPortsEnabledArray);

        if (count($vlanPortsAvailableArray) > 0) {
            foreach ($vlanPortsAvailableArray as $key => $vlanPort) {
                if ($vlanPort != EMPTY_STRING) {

                    $vlanPortReverse = $this->reverseVlanPort($vlanPort);
                    $vlanMemebers = $this->getVlanMembers($vlanId);

                    $vlanTagging = strpos($vlanMemebers, $vlanPortReverse.VLAN_PORT_TAGGING_KEY) !== FALSE ? VLAN_PORT_TAGGING_KEY : VLAN_PORT_NOT_TAGGING_KEY;
                    $vlanPortsInfo[str_replace(VLAN_PORT_TAGGING_KEY, EMPTY_STRING, $vlanPortReverse)] = array(
                        VLAN_PORT_ENABLED => strpos($vlanMemebers, $vlanPortReverse) !== FALSE ? TRUE : FALSE,
                        VLAN_PORT_TAGGING_OPTIONS => $this->getVlanPortTaggingOptions($vlanTagging)
                    );
                }
            }
        }

        return $vlanPortsInfo;
    }

    public function getVlanPortTaggingOptions($vlanPortTagging) {
        $options = array(
            VLAN_PORT_TAGGING_KEY => VLAN_PORT_TAGGING_VAL,
            VLAN_PORT_NOT_TAGGING_KEY => VLAN_PORT_NOT_TAGGING_VAL
        );

        return $this->helper->selectOption($options, $vlanPortTagging);
    }

    public function save() {
        $vlanId = trim($_POST[VLAN_ID]);

        $this->deleteFirewallForwarding($vlanId);
        $this->deleteFirewallForwarding($vlanId);
        $this->deleteFirewallForwarding($vlanId);
        $this->deleteFirewallZone($vlanId);
        $this->deleteFirewallRuleBySrc($vlanId);
        $this->deleteFirewallRuleBySrc($vlanId);
        $this->deleteDhcpVlanInfo($vlanId);

        $vlanPortRerverse = EMPTY_STRING;

        for ($i = 4; $i >= 1; $i--) {
            if ($this->translateVlanPort($i) != EMPTY_STRING) {
                $vlanPortRerverse .= $this->translateVlanPort($i) . SPACE;
            }
        }

        $vlanPorts = trim($vlanPortRerverse) . SPACE . VLAN_PORT_8T;

        if ($vlanId == VLAN_ID_1) {
            $this->saveVlanVcfgEnabled(VLAN_ID_1, VLAN_VCFG_ENABLED_KEY);
            $this->saveVlanDescription(VLAN_ID_1, $_POST[VLAN_DESCRIPTION]);
            $this->saveNetworkEthPort(VLAN_ID_1, $vlanPorts);

        } else {
            $vlanNum = $this->checkVlanEdit($vlanId);

            if ($vlanNum == EMPTY_STRING) {
                $vlanNum = $this->findVlanNumAvailable();
            }

            $this->saveVlanVcfgEnabled($vlanNum, VLAN_VCFG_ENABLED_KEY);
            $this->saveVlanVcfgVlanId($vlanNum, $vlanId);
            $this->saveVlanDescription($vlanNum, $_POST[VLAN_DESCRIPTION]);
            $this->saveVlanVcfgRoutingEnabled($vlanNum, $_POST[VLAN_ROUTING]);

            if ($_POST[VLAN_ROUTING] == VLAN_ROUTING_ENABLED_KEY) {
                $this->saveFirewallForwarding($vlanId, LAN);
                $this->saveFirewallForwarding(LAN, $vlanId);
                $this->saveFirewallForwarding($vlanId, WAN);
                $this->saveFirewallZone(FALSE, $vlanId, $vlanId, ACCEPT, ACCEPT, ACCEPT);

            } else {
                $this->saveFirewallForwarding($vlanId, WAN);
                $this->saveFirewallZone(FALSE, $vlanId, $vlanId, REJECT, ACCEPT, REJECT);
                $this->saveFirewallRule(FALSE, RULE_NAME_ALLOW_DNS_QUERIES, PROTOCAL_BOTH_KEY, EMPTY_STRING, DESTINATION_PORT_53, $vlanId, ACCEPT);
                $this->saveFirewallRule(FALSE, RULE_NAME_ALLOW_DHCP_REQUESTS, PROTOCAL_UDP_KEY, PORT_67_68, PORT_67_68, $vlanId, ACCEPT);
            }

            $this->saveNetworkEthInfo($vlanId, $vlanPorts);
            $this->saveNetworkVlanInfo($vlanId, $_POST[IP_ADDRESS],
                                                $this->getIPV4Class() == IPV4_CLASS_C_KEY ? $_POST[SUBNET_MASK] : $_POST[CLASS_B_LAN_SUBNET_MASK_OPTIONS]);

            if (isset($_POST[DHCP_SERVER_STATUS])) {
                if ($this->getIPV4Class() == IPV4_CLASS_C_KEY) {
                    $limit = $_POST[CLASS_C_END] - $_POST[CLASS_C_START];
                    $this->saveDhcpVlanInfo($vlanId, $_POST[CLASS_C_START], $limit, $_POST[LEASE_TIME]);
                } else {
                    $start = $this->calcualteClassBStart($_POST[CLASS_B_START], $_POST[IP_ADDRESS]);
                    $limit = $this->calcualteClassBLimit($_POST[CLASS_B_START], $_POST[CLASS_B_END]);

                    $this->saveDhcpVlanInfo($vlanId, $start, $limit, $_POST[LEASE_TIME]);
                }
            }
        }

        $this->saveVlanStatus(VLAN_ENABLED_KEY);
        $this->saveRebootRequired();
        $this->commit();
        header(LOCATION . VLAN_PAGE);
    }

    function  calcualteClassBStart($start, $ipAddr) {
        return  ip2long($start) - ip2long($ipAddr);
    }

    function calcualteClassBLimit($start, $end) {
        return ip2long($end) - ip2long($start) + 1;
    }

    public function checkVlanEdit($vlanId) {
        $index = EMPTY_STRING;

        for ($i = 2; $i <= 16; $i++) {
            if ($this->getVlanVcfgVlanId($i) == $vlanId) {
                $index = $i;
                break;
            }
        }
        return $index;
    }

    public function findVlanNumAvailable() {
        $indexAvailable = EMPTY_STRING;

        for ($i = 2; $i <= 16; $i++) {
            if ($this->getVLanVcfgEnabled($i) == VLAN_VCFG_DISABLE_KEY) {
                $indexAvailable = $i;
                break;
            }
        }
        return $indexAvailable;
    }

    public function  translateVlanPort($vlanId) {
        $vlanPortReverse = EMPTY_STRING;

        if (isset($_POST[$vlanId])) {
            $vlanPort = $_POST[EGRESS_RULE_OPTIONS . $vlanId] == VLAN_PORT_TAGGING_KEY ? $vlanId . VLAN_PORT_TAGGING_KEY : $vlanId;
            $vlanPortReverse = $this->reverseVlanPort($vlanPort);
        }

        return $vlanPortReverse;
    }

    public function saveNetworkVlanInfo($vlanId, $ipAddr, $subnetMask) {
        $this->saveNetworkVlanInterface($vlanId);
        $this->saveNetworkVlanIfname($vlanId);
        $this->saveNetworkVlanProto($vlanId);
        $this->saveNetworkVlanIpAddr($vlanId, $ipAddr);
        $this->saveNetworkVlanNetmask($vlanId, $subnetMask);
    }

    public function saveDhcpVlanInfo($vlanId, $start, $limit, $leaseTime) {
        $this->saveDhcpVlan($vlanId);
        $this->saveDhcpVlanInterface($vlanId);
        $this->saveDhcpVlanStart($vlanId, $start);
        $this->saveDhcpVlanLimit($vlanId, $limit);
        $this->saveDhcpVlanLeaseTime($vlanId, $leaseTime);
    }

}