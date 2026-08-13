<?php

class Controller {
    protected $view;
    protected $model;
    protected $view_name;
    protected $helper;

    public function __construct() {
        $this->view_name = EMPTY_STRING;
        $this->view = new View();
        $this->Load_Model(MODEL);
    }

    public function Assign($variable, $value) {
        $this->view->Assign($variable, $value);
    }

    public function Load_Model($name) {
        $modelName = ($name == MODEL) ? $name : $name . MODEL_CLASS;
        $this->model = new $modelName();
    }

    public function Load_View($name) {
        if (file_exists(ROOT . DS . VIEWS . DS . strtolower($name) . PHP_EXTENSION)) {
            $this->view_name = $name;
        }
    }

    public function Load_Helper($name) {
        $this->helper = new $name;
    }

    public function getModel() {
        return $this->model->getModel();
    }

    public function getVersion() {
        return $this->model->getVersion();
    }

    public function getFirmwareVersion() {
        return $this->model->getFirmwareVersion();
    }

    public function addHeader() {
        $header = EMPTY_STRING;
        $header_view = new View();

        $header_view->Assign(MODEL, $this->getModel());
        $header_view->Assign(VERSION, $this->getVersion());
        $header_view->Assign(FIRMWARE_VERSION, $this->getFirmwareVersion());

        $header .= $header_view->Render(HEADER, FALSE);
        $this->Assign(HEADER, $header);
    }

    public function addLeftNav() {
        $leftNav = EMPTY_STRING;
        $leftNav_view = new View();

        $leftNav_view->Assign(MULTI_WAN_STATUS, $this->getMultiWanStatus());
        $leftNav_view->Assign(MULTI_WAN_WIZARD_STATUS, $this->getMultiWanWizardStatus());

        $leftNav .= $leftNav_view->Render(LEFT_NAV, FALSE);

        $this->Assign(LEFT_NAV, $leftNav);
    }

    public function addHelpMessage($directory) {
        $helpMessage = EMPTY_STRING;
        $helpMessage_view = new View();

        $helpMessage .= $helpMessage_view->Render($directory . DS . HELP_MESSAGE, FALSE);
        $this->Assign(HELP_MESSAGE, $helpMessage);
    }

    public function assignWANSettingsInfo($view, $wanNum) {
        $wanIPAddr = $wanSubnetMask = $wanGateway = $wanDNSServer = $wanAlternateDNS = $wanMacAddr = UNSPECIFIED;
        $connectionType = $this->getWanProto($wanNum);

        if ($connectionType == CONNECTION_TYPE_STATIC_KEY) {
            $wanIPAddr = $this->getWANIPAddr($wanNum);
            $wanSubnetMask = $this->getWANSubnetMask($wanNum);
            $wanGateway = $this->getWANGateway($wanNum);
            $wanDNSServer = $this->getWANPriDNS($wanNum);
            $wanAlternateDNS = $this->getWANSecondaryDNS($wanNum);
        } else {
            $wanStatus = $this->getWANStatus($wanNum);
            $wanIPAddr = $this->getIfStatusWANIPAddr($wanStatus);
            $wanSubnetMask = $this->getIfStatusWANSubnetMask($wanStatus);
            $wanGateway = $this->getIfStatusWANGateway($wanStatus);
            $wanDNSServer = $this->getIfStatusWANDNSServer($wanStatus);
            $wanAlternateDNS = $this->getIfStatusWANAlternateDNS($wanStatus);
        }

        $wanMacAddr = $this->getWANMacAddr($wanNum);
        if (is_null($wanMacAddr) || empty($wanMacAddr)) {
            $wanMacAddrArray = $this->getWANMacAddrArray();
            $wanMacAddr = $this->getMacAddrMatch($wanMacAddrArray);
        }

        $view->Assign(CONNECTION_TYPE.$wanNum, $this->getConnectionTypeDisplayVal($connectionType));
        $view->Assign(WAN_IP_ADDR.$wanNum, $wanIPAddr);
        $view->Assign(WAN_SUBNET_MASK.$wanNum, $wanSubnetMask);
        $view->Assign(WAN_GATE_WAY.$wanNum, $wanGateway);
        $view->Assign(WAN_DNS_SERVER.$wanNum, $wanDNSServer);
        $view->Assign(WAN_ALTERNATE_DNS.$wanNum, $wanAlternateDNS);
        $view->Assign(WAN_MAC_ADDR.$wanNum, $wanMacAddr);
        $view->Assign(LAN_IP_ADDR.$wanNum, $this->getLanIPAddr());
        $view->Assign(LAN_SUBNET_MASK.$wanNum, $this->getLanSubnetMask());
        $view->Assign(LAN_MAC_ADDR.$wanNum, $this->getMacAddrMatch($this->getLANMacAddrArray()));
    }

    public function assignWanMTU($view, $wanNum) {
        $view->Assign(WAN_MTU.$wanNum, $this->getCustomMtu($wanNum));
    }

    public function assignWanMetric($view, $wanNum) {
        $view->Assign(WAN_METRIC.$wanNum, $this->getMetric($wanNum));
    }

    public function getConnectionTypeDisplayVal($connectionType) {
        return $connectionType == CONNECTION_TYPE_STATIC_KEY ? ucfirst($connectionType) : strtoupper($connectionType);
    }

    public function getWANMacAddrArray() {
        return $this->model->getWANMacAddrArray();
    }

    public function getMacAddrMatch($macAddrArray) {
        $patternMac = MAC_ADDR_REGEX;

        if (preg_match($patternMac, $macAddrArray, $match)) {
            return $match[0];
        }
    }

    public function getLANMacAddrArray() {
        return $this->model->getLANMacAddrArray();
    }

    public function getWANStatus($wanNum) {
        return $this->model->getWANStatus($wanNum);
    }

    public function getIfStatusWANIPAddr($wanStatus) {
        $wanIPAddrKey = $this->retrieveKey($wanStatus, IPV4_ADDRESS);
        $wanIPAddr = EMPTY_STRING;

        if (isset($wanIPAddrKey)) {
            $wanIPAddr = str_replace(DOUBLE_QUOTE, EMPTY_STRING, $wanStatus[$wanIPAddrKey + 2]);
            $wanIPAddr = str_replace(COMMA, EMPTY_STRING, $wanIPAddr);
            $wanIPAddr = str_replace(ADDRESS, EMPTY_STRING, $wanIPAddr);
        }

        return $wanIPAddr;
    }

    public function getIfStatusWANSubnetMask($wanStatus) {
        $wanSubnetMaskKey = $this->retrieveKey($wanStatus, IPV4_ADDRESS);
        $wanSubnetMask = EMPTY_STRING;

        if (isset($wanSubnetMaskKey)) {
            $wanSubnetMaskCode = str_replace(DOUBLE_QUOTE, EMPTY_STRING, $wanStatus[$wanSubnetMaskKey + 3]);
            $wanSubnetMaskCode = str_replace(MASK, EMPTY_STRING, $wanSubnetMaskCode);
            $wanSubnetMask = $this->transSubnetMaskCode($wanSubnetMaskCode);
        }

        return $wanSubnetMask;
    }

    public function getIfStatusWANGateway($wanStatus) {
        $wanGatewayKey = $this->retrieveKey($wanStatus, NEXT_HOP);
        $wanGateway = EMPTY_STRING;

        if (isset($wanGatewayKey)) {
            $wanGateway = str_replace(NEXT_HOP, EMPTY_STRING, $wanStatus[$wanGatewayKey]);
            $wanGateway = str_replace(COMMA, EMPTY_STRING, $wanGateway);
            $wanGateway = str_replace(DOUBLE_QUOTE, EMPTY_STRING, $wanGateway);
        }

        return $wanGateway;
    }

    public function getIfStatusWANDNSServer($wanStatus) {
        $wanDNSServerKey = $this->retrieveKey($wanStatus, DNS_SERVER);
        $wanDNSServer = EMPTY_STRING;

        if (isset($wanDNSServerKey)) {
            $wanDNSServer = str_replace(DOUBLE_QUOTE, EMPTY_STRING, $wanStatus[$wanDNSServerKey + 1]);
            $wanDNSServer = str_replace(COMMA, EMPTY_STRING, $wanDNSServer);
        }
        return $wanDNSServer;
    }

    public function getIfStatusWANAlternateDNS($wanStatus) {
        $wanAlternateDNS = EMPTY_STRING;
        $wanAlternateDNSKey = $this->retrieveKey($wanStatus, DNS_SERVER);

        if (isset($wanAlternateDNSKey)) {
            $wanAlternateDNS = str_replace(DOUBLE_QUOTE, EMPTY_STRING, $wanStatus[$wanAlternateDNSKey + 2]);
            $wanAlternateDNS = str_replace(COMMA, EMPTY_STRING, $wanAlternateDNS);
        }

        return trim($wanAlternateDNS) == INDEX_BRACKET_RIGHT ? EMPTY_STRING : trim($wanAlternateDNS);
    }

    public function transSubnetMaskCode($wanSubnetMaskCode) {
        $subnetMaskArray = array(

            SUBNET_MASK_255_255_255_255_CODE => SUBNET_MASK_255_255_255_255_VAL,
            SUBNET_MASK_255_255_255_248_CODE => SUBNET_MASK_255_255_255_248_VAL,
            SUBNET_MASK_255_255_255_240_CODE => SUBNET_MASK_255_255_255_240_VAL,
            SUBNET_MASK_255_255_255_224_CODE => SUBNET_MASK_255_255_255_224_VAL,
            SUBNET_MASK_255_255_255_192_CODE => SUBNET_MASK_255_255_255_192_VAL,
            SUBNET_MASK_255_255_255_128_CODE => SUBNET_MASK_255_255_255_128_VAL,
            SUBNET_MASK_255_255_255_0_CODE => SUBNET_MASK_255_255_255_0_VAL,
            SUBNET_MASK_255_255_254_0_CODE => SUBNET_MASK_255_255_254_0_VAL,
            SUBNET_MASK_255_255_252_0_CODE => SUBNET_MASK_255_255_252_0_VAL,
            SUBNET_MASK_255_255_248_0_CODE => SUBNET_MASK_255_255_248_0_VAL,
            SUBNET_MASK_255_255_240_0_CODE => SUBNET_MASK_255_255_240_0_VAL,
            SUBNET_MASK_255_255_224_0_CODE => SUBNET_MASK_255_255_224_0_VAL,
            SUBNET_MASK_255_255_192_0_CODE => SUBNET_MASK_255_255_192_0_VAL,
            SUBNET_MASK_255_255_128_0_CODE => SUBNET_MASK_255_255_128_0_VAL,
            SUBNET_MASK_255_255_0_0_CODE => SUBNET_MASK_255_255_0_0_VAL
        );

        $subnetMask = $subnetMaskArray[trim($wanSubnetMaskCode)];

        return $subnetMask;
    }

    public function retrieveKey($wanStatus, $search) {
        foreach ($wanStatus as $key => $value) {
            if (strstr($value, $search)) {
                return $key;
                break;
            }
        }
    }

    public function assignRebootRequireView($view) {
        $view->Assign(REBOOT_REQUIRED, $this->checkRebootRequired() ? TRUE : FALSE);
    }

    public function assignClassCRangeInfo($view) {
        $view->Assign(CLASS_C_BASE, $this->getClassCBase(VLAN_ID_1));
        $view->Assign(CLASS_C_START, $this->getClassCStart());
        $view->Assign(CLASS_C_END, $this->getClassCEnd());
        $view->Assign(CLASS_C_LEASE_TIME, $this->getLeaseTime());
    }

    public function assignWANInfo($view, $wanNum) {
        $view->Assign(WAN_NAME, $this->getWanName(WAN.$wanNum));
        $view->Assign(CONNECTION_TYPE_OPTIONS, $this->getWanConnectionTypeOptions($wanNum));
        $view->Assign(PPPOE_USER, $this->getPPPOEUser($wanNum));
        $view->Assign(PPPOE_PASSWORD, $this->getPPPOEPwd($wanNum));
        $view->Assign(PPPOE_SERVICE_NAME, $this->getPPPOEServiceName($wanNum));
        $view->Assign(PPPOE_MAX_FAILED_PING, $this->getPPPOEMaxFailedPing($wanNum));
        $view->Assign(PPPOE_PING_INTERVAL, $this->getPPPOEPingInterval($wanNum));
        $view->Assign(STATIC_IP, $this->getWANIPAddr($wanNum));
        $view->Assign(NET_MASK, $this->getWANSubnetMask($wanNum));
        $view->Assign(GATE_WAY, $this->getWANGateway($wanNum));
        $view->Assign(PRIMARY_DNS, $this->getWANPriDNS($wanNum));
        $view->Assign(SECONDARY_DNS, $this->getWANSecondaryDNS($wanNum) == INDEX_BRACKET_RIGHT ? EMPTY_STRING : $this->getWANSecondaryDNS($wanNum));
        $view->Assign(CUSTOM_MAC_ADDR, $this->getWANMacAddr($wanNum));
        $view->Assign(CUSTOM_MTU, $this->getCustomMtu($wanNum));
    }

    public function assignMultiWanSettingsInfo($view, $wanNum) {
        $view->Assign(TRACKING_RELIABILITY, $this->getWanTrackingReliabilityOptions($wanNum));
        $view->Assign(TRACKING_IP, trim($this->getWanTrackingIP($wanNum)));
        $view->Assign(PING_COUNT, $this->getWanPingCountOptions($wanNum));
        $view->Assign(PING_TIME_OUT, $this->getWanPingTimeoutOptions($wanNum));
        $view->Assign(PING_INTERVAL, $this->getWanPingIntervalOptions($wanNum));
        $view->Assign(INTERFACE_DOWN, $this->getWanInterfaceDownOptions($wanNum));
        $view->Assign(INTERFACE_UP, $this->getWanInterfaceUpOptions($wanNum));
        $this->assignIPV6StatusInfo($view,$wanNum);
    }

    public function getMultiWanMemberInfoByPolicy($policyName) {
        $multiWanMemberInfo = array();

        $wanInterfaceArray = array(WAN);
        for ($i=2; $i<=4; $i++) {
            if ($this->getWanInterface($i)) {
                $wanInterface = WAN . $i;
                array_push($wanInterfaceArray, $wanInterface);
            }
        }

        for ($m=0; $m<count($wanInterfaceArray); $m++) {
            $wanMemberName = $this->getWanName($wanInterfaceArray[$m]);
            $wanMemberPriority = $this->getWanMemberMetric($wanInterfaceArray[$m], $policyName);
            $wanMemberWeight = $this->getWanMemberWeight($wanInterfaceArray[$m], $policyName);

            $multiWanMemberInfo[$wanInterfaceArray[$m]] = array(
                WAN_NAME => $wanMemberName,
                MEMBER_PRIORITY => $wanMemberPriority,
                MEMBER_WEIGHT => $wanMemberWeight,
            );
        }

        return $multiWanMemberInfo;
    }

    public function getMultiWanRuleInfoByPolicy($policyName) {
        $ruleNameArray = $this->getMultiWanRuleName($policyName);
        $multiWanRuleInfo = array();

        if ($ruleNameArray != EMPTY_STRING) {
            foreach ($ruleNameArray as $key=>$ruleNameInfo){
                $ruleName = explode(UCI_FIELD_DOT, $ruleNameInfo)[1];

                $sourceAddr = $this->getMultiWanRuleSrcAddr($ruleName);
                $sourcePort = $this->getMultiWanRuleSrcPort($ruleName);
                $destinationAddr = $this->getMultiWanRuleDestAddr($ruleName);
                $destinationPort = $this->getMultiWanRuleDestPort($ruleName);
                $proto = $this->getMultiWanRuleProto($ruleName);

                $multiWanRuleInfo[$key] = array(
                    RULE_NAME => $ruleName,
                    SOURCE_ADDRESS => $sourceAddr,
                    SOURCE_PORT => $sourcePort,
                    DESTINATION_ADDRESS => $destinationAddr,
                    DESTINATION_PORT => $destinationPort,
                    PROTOCAL => $proto == PROTOCAL_ALL_KEY ? PROTOCAL_ALL_VAL : strtoupper($proto)
                );
            }
        }

        return $multiWanRuleInfo;
    }

    public function getMultiWanRuleName($policyName) {
        return $this->model->getMultiWanRuleName($policyName);
    }

    public function getMultiWanRuleSrcAddr($ruleName) {
        return $this->model->getMultiWanRuleSrcAddr($ruleName);
    }

    public function getMultiWanRuleSrcPort($ruleName) {
        return $this->model->getMultiWanRuleSrcPort($ruleName);
    }

    public function getMultiWanRuleDestAddr($ruleName) {
        return $this->model->getMultiWanRuleDestAddr($ruleName);
    }

    public function getMultiWanRuleDestPort($ruleName) {
        return $this->model->getMultiWanRuleDestPort($ruleName);
    }

    public function getMultiWanRuleProto($ruleName) {
        return $this->model->getMultiWanRuleProto($ruleName);
    }

    public function getWanInterfaceArray() {
        $wanInterfaceArray = array(WAN);

        for ($i=2; $i<=4; $i++) {
            if ($this->getWanInterface($i)){
                $wanInterface = WAN.$i;
                array_push($wanInterfaceArray, $wanInterface);
            }
        }

        return $wanInterfaceArray;
    }

    public function getWanInterface($wanNum) {
        return $this->model->getWanInterface($wanNum);
    }

    public function getWanMemberMetric($wanInterfaceName, $policyName) {
        return $this->model->getWanMemberMetric($wanInterfaceName, $policyName);
    }

    public function getWanMemberWeight($wanInterfaceName, $policyName) {
        return $this->model->getWanMemberWeight($wanInterfaceName, $policyName);
    }

    public function assignIPV6StatusInfo($view, $wanNum) {
        $view->Assign(IPV6_STATUS_OPTIONS, $this->getIPV6StatusOptions($wanNum));
    }

    public function getIPV6StatusOptions($wanNum) {
        $options = array(
            IPV6_WAN_ENABLED_KEY => IPV6_WAN_ENABLED_VAL,
            IPV6_WAN_DISABLED_KEY => IPV6_WAN_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getIPV6Status($wanNum));
    }

    public function getIPV6Status($wanNum) {
        return $this->model->getIPV6Status($wanNum);
    }

    public function getWanName($wanNum) {
        return $this->model->getWanName($wanNum);
    }

    public function getWanConnectionTypeOptions($wanNum) {
        $options=array(
            CONNECTION_TYPE_DCHP_KEY => CONNECTION_TYPE_DCHP_VAL,
            CONNECTION_TYPE_PPPOE_KEY => CONNECTION_TYPE_PPPOE_VAL,
            CONNECTION_TYPE_STATIC_KEY => CONNECTION_TYPE_STATIC_VAL
        );

        return $this->helper->selectOption($options, $this->getWanProto($wanNum));
    }

    public function getWanProto($wanNum) {
        return $this->model->getWanProto($wanNum);
    }

    public function getWanTrackingReliabilityOptions($wanNum) {
        $options=array(
            WAN_TRACKING_RELIABILITY_0 => WAN_TRACKING_RELIABILITY_0,
            WAN_TRACKING_RELIABILITY_1 => WAN_TRACKING_RELIABILITY_1,
            WAN_TRACKING_RELIABILITY_2 => WAN_TRACKING_RELIABILITY_2,
            WAN_TRACKING_RELIABILITY_3 => WAN_TRACKING_RELIABILITY_3,
            WAN_TRACKING_RELIABILITY_4 => WAN_TRACKING_RELIABILITY_4,
            WAN_TRACKING_RELIABILITY_5 => WAN_TRACKING_RELIABILITY_5
        );

        return $this->helper->selectOption($options, $this->getWanTrackingReliability($wanNum));
    }

    public function getWanTrackingReliability($wanNum) {
        return $this->model->getWanTrackingReliability($wanNum);
    }

    public function getWanTrackingIP($wanNum) {
        return $this->model->getWanTrackingIP($wanNum);
    }

    public function getWanPingCountOptions($wanNum) {
        $options=array(
            WAN_PING_COUNT_1 => WAN_PING_COUNT_1,
            WAN_PING_COUNT_2 => WAN_PING_COUNT_2,
            WAN_PING_COUNT_3 => WAN_PING_COUNT_3,
            WAN_PING_COUNT_4 => WAN_PING_COUNT_4,
            WAN_PING_COUNT_5 => WAN_PING_COUNT_5,
            WAN_PING_COUNT_6 => WAN_PING_COUNT_6,
            WAN_PING_COUNT_7 => WAN_PING_COUNT_7,
            WAN_PING_COUNT_8 => WAN_PING_COUNT_8,
            WAN_PING_COUNT_9 => WAN_PING_COUNT_9,
            WAN_PING_COUNT_10 => WAN_PING_COUNT_10,

        );

        return $this->helper->selectOption($options, $this->getWanPingCount($wanNum));
    }

    public function getWanPingCount($wanNum) {
        return $this->model->getWanPingCount($wanNum);
    }

    public function getWanPingTimeoutOptions($wanNum) {
        $options=array(
            WAN_PING_TIMEOUT_1_KEY => WAN_PING_TIMEOUT_1_VAL,
            WAN_PING_TIMEOUT_2_KEY => WAN_PING_TIMEOUT_2_VAL,
            WAN_PING_TIMEOUT_3_KEY => WAN_PING_TIMEOUT_3_VAL,
            WAN_PING_TIMEOUT_4_KEY => WAN_PING_TIMEOUT_4_VAL,
            WAN_PING_TIMEOUT_5_KEY => WAN_PING_TIMEOUT_5_VAL,
            WAN_PING_TIMEOUT_6_KEY => WAN_PING_TIMEOUT_6_VAL,
            WAN_PING_TIMEOUT_7_KEY => WAN_PING_TIMEOUT_7_VAL,
            WAN_PING_TIMEOUT_8_KEY => WAN_PING_TIMEOUT_8_VAL,
            WAN_PING_TIMEOUT_9_KEY => WAN_PING_TIMEOUT_9_VAL,
            WAN_PING_TIMEOUT_10_KEY => WAN_PING_TIMEOUT_10_VAL,

        );

        return $this->helper->selectOption($options, $this->getWanPingTimeout($wanNum));
    }

    public function getWanPingTimeout($wanNum) {
        return $this->model->getWanPingTimeout($wanNum);
    }

    public function getWanPingIntervalOptions($wanNum) {
        $options=array(
            WAN_PING_INTERVAL_1_SECOND_KEY => WAN_PING_INTERVAL_1_SECOND_VAL,
            WAN_PING_INTERVAL_3_SECONDS_KEY => WAN_PING_INTERVAL_3_SECONDS_VAL,
            WAN_PING_INTERVAL_5_SECONDS_KEY => WAN_PING_INTERVAL_5_SECONDS_VAL,
            WAN_PING_INTERVAL_10_SECONDS_KEY => WAN_PING_INTERVAL_10_SECONDS_VAL,
            WAN_PING_INTERVAL_20_SECONDS_KEY => WAN_PING_INTERVAL_20_SECONDS_VAL,
            WAN_PING_INTERVAL_30_SECONDS_KEY => WAN_PING_INTERVAL_30_SECONDS_VAL,
            WAN_PING_INTERVAL_1_MINUTE_KEY => WAN_PING_INTERVAL_1_MINUTE_VAL,
            WAN_PING_INTERVAL_10_MINUTES_KEY => WAN_PING_INTERVAL_10_MINUTES_VAL,
            WAN_PING_INTERVAL_30_MINUTES_KEY => WAN_PING_INTERVAL_30_MINUTES_VAL,
            WAN_PING_INTERVAL_1_HOUR_KEY => WAN_PING_INTERVAL_1_HOUR_VAL,

        );

        return $this->helper->selectOption($options, $this->getWanPingInterval($wanNum));
    }

    public function getWanPingInterval($wanNum) {
        return $this->model->getWanPingInterval($wanNum);
    }

    public function getWanInterfaceDownOptions($wanNum) {
        $options=array(
            WAN_INTERFACE_UP_DOWN_1 => WAN_INTERFACE_UP_DOWN_1,
            WAN_INTERFACE_UP_DOWN_2 => WAN_INTERFACE_UP_DOWN_2,
            WAN_INTERFACE_UP_DOWN_3 => WAN_INTERFACE_UP_DOWN_3,
            WAN_INTERFACE_UP_DOWN_4 => WAN_INTERFACE_UP_DOWN_4,
            WAN_INTERFACE_UP_DOWN_5 => WAN_INTERFACE_UP_DOWN_5,
            WAN_INTERFACE_UP_DOWN_6 => WAN_INTERFACE_UP_DOWN_6,
            WAN_INTERFACE_UP_DOWN_7 => WAN_INTERFACE_UP_DOWN_7,
            WAN_INTERFACE_UP_DOWN_8 => WAN_INTERFACE_UP_DOWN_8,
            WAN_INTERFACE_UP_DOWN_9 => WAN_INTERFACE_UP_DOWN_9,
            WAN_INTERFACE_UP_DOWN_10 => WAN_INTERFACE_UP_DOWN_10,

        );

        return $this->helper->selectOption($options, $this->getWanInterfaceDown($wanNum));
    }

    public function getWanInterfaceDown($wanNum) {
        return $this->model->getWanInterfaceDown($wanNum);
    }

    public function getWanInterfaceUpOptions($wanNum) {
        $options=array(
            WAN_INTERFACE_UP_DOWN_1 => WAN_INTERFACE_UP_DOWN_1,
            WAN_INTERFACE_UP_DOWN_2 => WAN_INTERFACE_UP_DOWN_2,
            WAN_INTERFACE_UP_DOWN_3 => WAN_INTERFACE_UP_DOWN_3,
            WAN_INTERFACE_UP_DOWN_4 => WAN_INTERFACE_UP_DOWN_4,
            WAN_INTERFACE_UP_DOWN_5 => WAN_INTERFACE_UP_DOWN_5,
            WAN_INTERFACE_UP_DOWN_6 => WAN_INTERFACE_UP_DOWN_6,
            WAN_INTERFACE_UP_DOWN_7 => WAN_INTERFACE_UP_DOWN_7,
            WAN_INTERFACE_UP_DOWN_8 => WAN_INTERFACE_UP_DOWN_8,
            WAN_INTERFACE_UP_DOWN_9 => WAN_INTERFACE_UP_DOWN_9,
            WAN_INTERFACE_UP_DOWN_10 => WAN_INTERFACE_UP_DOWN_10,

        );

        return $this->helper->selectOption($options, $this->getWanInterfaceUp($wanNum));
    }

    public function getWanInterfaceUp($wanNum) {
        return $this->model->getWanInterfaceUp($wanNum);
    }

    public function getPPPOEUser($wanNum) {
        return $this->model->getPPPOEUser($wanNum);
    }

    public function getPPPOEPwd($wanNum) {
        return $this->model->getPPPOEPwd($wanNum);
    }

    public function getPPPOEServiceName($wanNum) {
        return $this->model->getPPPOEServiceName($wanNum);
    }

    public function getPPPOEMaxFailedPing($wanNum) {
        return $this->model->getPPPOEMaxFailedPing($wanNum);
    }

    public function getPPPOEPingInterval($wanNum) {
        return $this->model->getPPPOEPingInterval($wanNum);
    }

    public function saveMultiWanInfo($wanNum, $wanName, $connectionType, $priDNS, $secondaryDNS, $customMacAddr, $customMtu, $pppoeUser, $pppoePwd,
                                     $pppoeServiceName, $ppoeMaxFailedPing, $pppoePingInterval, $staticIP,$netMask, $gateWay) {

        if ($wanNum != EMPTY_STRING) {
            $this->createWanInfo($wanNum);
        } else {
            $this->saveMwan3WanStatus(EMPTY_STRING, MWAN3_STATUS_ENABLED_KEY);
        }

        $this->saveWanProto($wanNum, $connectionType);

        $this->deletePPPOEInfo($wanNum);
        $this->deleteStaticInfo($wanNum);

        if ($connectionType == CONNECTION_TYPE_PPPOE_KEY) {
            $this->savePPPOEInfo($wanNum, $pppoeUser, $pppoePwd, $pppoeServiceName, $ppoeMaxFailedPing, $pppoePingInterval);
        } else if ($connectionType == CONNECTION_TYPE_STATIC_KEY) {
            $this->saveStaticInfo($wanNum, $staticIP, $netMask, $gateWay);
        }

        $this->saveWanName(WAN.$wanNum, $wanName);
        $this->saveDNSInfo($priDNS, $secondaryDNS, $wanNum);
        $this->saveCustomMacAddr($wanNum,$customMacAddr);
        $this->saveCustomMtu($wanNum, $customMtu);
        $this->saveMetric($wanNum);

        $this->commit();
    }

    public function saveMultiWanSettingsInfo($wanNum, $wanTrackingReliability, $wanPingCount, $wanPingTimeout, $wanPingInterval, $wanInterfaceDown, $wanInterfaceUp, $ipv6Status) {
        $this->saveWanTrackingReliability($wanNum, $wanTrackingReliability);
        $this->deleteWanTrackingIP($wanNum);
        $this->saveWanTrackingIP($wanNum, $wanTrackingReliability);
        $this->saveWanPingCount($wanNum, $wanPingCount);
        $this->saveWanPingTimeout($wanNum, $wanPingTimeout);
        $this->saveWanPingInterval($wanNum, $wanPingInterval);
        $this->saveWanInterfaceDown($wanNum, $wanInterfaceDown);
        $this->saveWanInterfaceUp($wanNum, $wanInterfaceUp);
        $this->saveWanIpv6($wanNum, $ipv6Status);

        $this->commit();
    }

    public function deleteMultiwanGroupInfo($groupNum) {
        $this->deleteWanGroup($groupNum, WAN);
        $this->deleteWanGroup($groupNum, WAN);
        $this->deleteWanGroup($groupNum, WAN);
        $this->deleteWanGroup($groupNum, WAN);

        for ($i=2; $i<=4; $i++) {
            $this->deleteWanGroup($groupNum, WAN.$i);
            $this->deleteWanGroup($groupNum, WAN.$i);
            $this->deleteWanGroup($groupNum, WAN.$i);
            $this->deleteWanGroup($groupNum, WAN.$i);
        }

        $this->commit();
    }

    public function saveMultiWanMemberInfoByPolicy($policyName) {
        $this->deleteMultiWanMemberInfoByPolicy($policyName);

        for ($i=1; $i<=4; $i++) {
            $policyNameVal = $policyName;

            if ($policyName == MULTI_WAN_POLICY_SINGLE_WAN_2_KEY) {
                $policyNameVal = MULTI_WAN_POLICY_SINGLE_WAN_KEY.WAN2;
            } else if ($policyName == MULTI_WAN_POLICY_SINGLE_WAN_3_KEY) {
                $policyNameVal = MULTI_WAN_POLICY_SINGLE_WAN_KEY.WAN3;
            } else if ($policyName == MULTI_WAN_POLICY_SINGLE_WAN_4_KEY) {
                $policyNameVal = MULTI_WAN_POLICY_SINGLE_WAN_KEY.WAN4;
            } else if ($policyName == MULTI_WAN_POLICY_BALANCED_2_KEY) {
                $policyNameVal = MULTI_WAN_POLICY_BALANCED_KEY.WAN2;
            } else if ($policyName == MULTI_WAN_POLICY_FAILOVER_2_KEY) {
                $policyNameVal = MULTI_WAN_POLICY_FAILOVER_KEY.WAN2;
            }

            if (isset($_POST[CHECK.strtoupper(WAN).($i==1 ? EMPTY_STRING : $i).UNDERSCORE.ucfirst($policyNameVal)])) {
                $wanInterfaceName = trim(WAN.($i==1 ? EMPTY_STRING : $i) .UNDERSCORE.$policyName);

                $this->saveWanMember($policyName, WAN.($i==1 ? EMPTY_STRING : $i));
                $this->saveWanMemberInterface($policyName, WAN.($i==1 ? EMPTY_STRING : $i));

                if ($policyName != MULTI_WAN_POLICY_BALANCED_KEY && $policyName != MULTI_WAN_POLICY_BALANCED_2_KEY) {

                    if ($i==1 && $policyName != MULTI_WAN_POLICY_FAILOVER_2_KEY) {
                        $priority = $_POST[MEMBER_PRIORITY.strtoupper(WAN).UNDERSCORE.ucfirst($policyName)];
                    } else {
                        $priority = $_POST[MEMBER_PRIORITY.strtoupper(WAN).($i==1 ? EMPTY_STRING : $i).UNDERSCORE.ucfirst($policyNameVal)];;
                    }

                    $this->saveWanMemberMetric($policyName, WAN.($i==1 ? EMPTY_STRING : $i),$priority);

                }

                if ($policyName == MULTI_WAN_POLICY_BALANCED_KEY || $policyName == MULTI_WAN_POLICY_BALANCED_2_KEY) {

                    if ($i==1) {
                        $weight = $_POST[MEMBER_WEIGHT.strtoupper(WAN).UNDERSCORE.ucfirst($policyNameVal)];
                    } else {
                        $weight = $_POST[MEMBER_WEIGHT.strtoupper(WAN).$i.UNDERSCORE.ucfirst($policyNameVal)];;
                    }

                    $this->saveWanMemberWeight($policyName, WAN.($i==1 ? EMPTY_STRING : $i),$weight);

                }

                $this->saveMultiWanMemberNameByPolicy($policyName, $wanInterfaceName);
            }
        }

        $this->commit();
    }

    public function saveMultiWanRuleInfoByPolicy($policyName, $ruleTableInfo) {
        $this->deleteMultiWanRuleInfo($policyName);
        $this->saveMultiWanRuleInfo($policyName, $ruleTableInfo);
    }

    public function saveMultiWanRuleInfo($policyName, $ruleTableInfo) {
        if ($ruleTableInfo != EMPTY_STRING) {
            $ruleTableInfoArray = explode(URL_POST_SEPERATOR, $ruleTableInfo);

            for ($i=1; $i<count($ruleTableInfoArray); $i++) {
                $ruleInfoArray = explode(COMMA, trim($ruleTableInfoArray[$i]));

                $ruleName = trim($ruleInfoArray[1]);
                $this->saveMultiWanRuleName($ruleName);

                $this->saveMultiWanRuleSrcAdd($ruleName, trim($ruleInfoArray[2]));
                $this->saveMultiWanRuleSrcPort($ruleName, trim(str_replace(EQUAL_SIGN, COMMA, $ruleInfoArray[3])));
                $this->saveMultiWanRuleDestAddr($ruleName, trim($ruleInfoArray[4]));
                $this->saveMultiWanRuleDestPort($ruleName, trim(str_replace(EQUAL_SIGN, COMMA, $ruleInfoArray[5])));
                $this->saveMultiWanRuleProto($ruleName, strtolower(trim($ruleInfoArray[6])));
                $this->saveMultiWanRulePolicy($ruleName, trim($policyName));
            }
        }

        $this->commit();

    }

    public function saveMultiWanRuleName($value) {
        $this->model->setMultiWanRuleName($value);
    }

    public function saveMultiWanRuleSrcAdd($ruleName, $value) {
        $this->model->setMultiWanRuleSrcAddr($ruleName, $value);
    }

    public function saveMultiWanRuleSrcPort($ruleName, $value){
        $this->model->setMultiWanRuleSrcPort($ruleName, $value);
    }

    public function saveMultiWanRuleDestAddr($ruleName, $value) {
        $this->model->setMultiWanRuleDestAddr($ruleName, $value);
    }

    public function saveMultiWanRuleDestPort($ruleName, $value) {
        $this->model->setMultiWanRuleDestPort($ruleName, $value);
    }

    public function saveMultiWanRuleProto($ruleName, $value) {
        $this->model->setMultiWanRuleProto($ruleName, $value) ;
    }

    public function saveMultiWanRulePolicy($ruleName, $value) {
        $this->model->setMultiWanRulePolicy($ruleName, $value);
    }

    public function deleteMultiWanMemberInfoByPolicy($policyName) {
        $memberNameInfoArray = explode(SPACE, $this->getMultiWanMemberNameByPolicy($policyName));

        foreach ($memberNameInfoArray as $key=>$wanInferfaceName) {
            $this->deleteMultiWanMemberInfo($wanInferfaceName);
        }

        $this->model->deleteMultiWanMemberNameByPolicy($policyName);
        $this->commit();
    }

    public function deleteMultiWanRuleInfo($policyName) {
        $ruleNameArray = $this->getMultiWanRuleName($policyName);

        if ($ruleNameArray != EMPTY_STRING) {
            foreach ($ruleNameArray as $key=>$ruleNameInfo){
                $ruleName = explode(UCI_FIELD_DOT, $ruleNameInfo)[1];
                $this->deleteMultiWanRule($ruleName);
            }
        }
        $this->commit();
    }

    public function deleteMultiWanRule($ruleName) {
        $this->model->deleteMultiWanRule($ruleName);
    }

    public function getMultiWanMemberNameByPolicy($policyName) {
        return $this->model->getMultiWanMemberNameByPolicy($policyName);
    }


    public function deleteMultiWanMemberInfo($wanInferfaceName) {
        $this->model->deleteMultiWanMemberInfo($wanInferfaceName);
    }

    public function saveMultiWanMemberNameByPolicy($policyName, $wanInterfaceName) {
        $this->model->setMultiWanMemberNameByPolicy($policyName, $wanInterfaceName);
    }

    public function saveWanMember($policyName, $wanInterfaceName) {
        $this->model->setWanMember($policyName, $wanInterfaceName);
    }

    public function deleteWanGroup($groupNum, $wanInterfaceName) {
        $this->model->deleteWanGroup($groupNum, $wanInterfaceName);
    }

    public function saveWanMemberInterface($policyName, $wanInterfaceName) {
        $this->model->setWanMemberInterface($policyName, $wanInterfaceName);
    }

    public function saveWanMemberMetric($policyName, $wanInterfaceName, $metric) {
        $this->model->setWanMemberMetric($policyName, $wanInterfaceName, $metric);
    }

    public function saveWanMemberWeight($policyName, $wanInterfaceName, $weight) {
        $this->model->saveWanMemberWeight($policyName, $wanInterfaceName, $weight);

    }

    public function saveWanTrackingReliability($wanNum, $wanTrackingReliability) {
        $this->model->setWanTrackingReliability($wanNum, $wanTrackingReliability);
    }

    public function deleteWanTrackingIP($wanNum) {
        $this->model->deleteWanTrackingIP($wanNum);
    }

    public function saveWanTrackingIP($wanNum, $wanTrackingReliability) {
        if ($wanTrackingReliability != WAN_TRACKING_RELIABILITY_0) {
            for ($i=1; $i<=$wanTrackingReliability; $i++) {
                $this->model->addWanTrackingIPList($wanNum, $_POST[TRACKING_IP.UNDERSCORE.$i]);
            }
        }
    }

    public function saveWanPingCount($wanNum, $wanPingCount) {
        $this->model->setWanPingCount($wanNum, $wanPingCount);
    }

    public function saveWanPingTimeout($wanNum, $wanPingTimeout) {
        $this->model->setWanPingTimeout($wanNum, $wanPingTimeout);
    }

    public function saveWanPingInterval($wanNum, $wanPingInterval) {
        $this->model->setWanPingInterval($wanNum, $wanPingInterval);
    }

    public function saveWanInterfaceDown($wanNum, $wanInterfaceDown) {
        $this->model->setWanInterfaceDown($wanNum, $wanInterfaceDown);
    }

    public function saveWanInterfaceUp($wanNum, $wanInterfaceUp) {
        $this->model->setWanInterfaceUp($wanNum, $wanInterfaceUp);
    }

    public function createWanInfo($wanNum) {
        $this->saveMwan3WanStatus($wanNum, MWAN3_STATUS_ENABLED_KEY);
        $this->saveNetworkEthInfo(ETH0_408.$wanNum, ($wanNum - 1). SPACE.VLAN_PORT_8T);
        $this->saveWanInfo($wanNum);
    }

    public function saveNetworkEthInfo($wanNum, $vlanPorts) {
        $this->saveNetworkEthSwitchVlan($wanNum);
        $this->saveNetworkEthDevice($wanNum);
        $this->saveNetworkEthVlan($wanNum);
        $this->saveNetworkEthPort($wanNum, $vlanPorts);
    }

    public function saveWanInfo($wanNum) {
        $this->saveWanInterface($wanNum);
        $this->saveWanIfname($wanNum);
        $this->saveWanIpv6($wanNum, IPV6_WAN_DISABLED_KEY);
    }

    public function saveMultiWanDefaultPolicy($policyName) {
        $this->model->setMultiWanDefaultPolicy($policyName);
    }

    public function getMultiWanDefaultPolicy() {
        return $this->model->getMultiWanDefaultPolicy();
    }

    public function saveWanInterface($wanNum) {
        $this->model->setWanInterface($wanNum);
    }

    public function saveWanIfname($wanNum) {
        $this->model->setWanIfname($wanNum);
    }

    public function saveWanIpv6($wanNum, $ipv6Status) {
        $this->model->setWanIpv6($wanNum, $ipv6Status);
    }

    public function getEth0PortVal($wanNum) {
        $eth0Port = $this->getNetworkEth0Ports(VLAN_ID_1);
        $eth0PortVal = EMPTY_STRING;
        $wanPort = ($wanNum-1).SPACE;

        if (strpos($eth0Port, $wanPort) !== false) {
            $eth0PortVal = substr($eth0Port, strpos($eth0Port, $wanPort)+2);
        }

        return $eth0PortVal;
    }

    public function reverseEth0PortVal($wanNum) {
        $eth0PortArray = explode(SPACE,$this->getNetworkEth0Ports(VLAN_ID_1));
        array_unshift($eth0PortArray, ($wanNum-1));

        return implode(SPACE, $eth0PortArray);
    }

    public function reverseLuxulMultiWanPorts($wanNum) {
        $multiWanPortsArray = explode(SPACE, $this->getLuxulMultiWanPorts());
        unset($multiWanPortsArray[$wanNum-1]);

        return implode(SPACE, $multiWanPortsArray);
    }

    public function getNetworkEth0Ports($vlanID) {
        return $this->model->getNetworkEth0Ports($vlanID);
    }

    public function saveMwan3WanStatus($wanNum, $value) {
        $this->model->setMwan3WanStatus($wanNum, $value);
    }

    public function getMwan3WanStatus($wanNum) {
        return $this->model->getMwan3WanStatus($wanNum);
    }

    public function saveWanProto($wanNum, $value) {
        $this->model->setWanProto($wanNum, $value);
    }

    public function saveWanName($wanNum, $wanName) {
        $this->model->setWanName($wanNum, $wanName);
    }

    public function saveDNSInfo($priDNS, $secondaryDNS, $wanNum) {
        if (isset($priDNS) && $priDNS != EMPTY_STRING && $priDNS != DEFAULT_PRIMARY_DNS) {
            isset($secondaryDNS) ? $this->saveDNS($wanNum, $priDNS . SPACE . $secondaryDNS) : $this->saveDNS($wanNum, $priDNS);
        } else {
            $this->deleteDNS($wanNum);
        }
    }

    public function saveDNS($wanNum, $value) {
        if ($wanNum == EMPTY_STRING) {
            $this->saveLANDNS($value);
        }

        $this->saveWANDNS($wanNum, $value);
        $this->saveWANPeerDNS($wanNum);
    }

    public function saveLANDNS($value) {
        $this->model->setLANDNS($value);
    }

    public function saveWANDNS($wanNum, $value) {
        $this->model->setWANDNS($wanNum, $value);
    }

    public function saveWANPeerDNS($wanNum) {
        $this->model->setWANPeerDNS($wanNum);
    }

    public function deleteDNS($wanNum) {
        if ($wanNum == EMPTY_STRING) {
            $this->deleteLANDNS();
        }

        $this->deleteWANDNS($wanNum);
        $this->deleteWANPeerDNS($wanNum);
    }

    public function deleteLANDNS() {
        $this->model->deleteLANDNS();
    }

    public function deleteWANDNS($wanNum) {
        $this->model->deleteWANDNS($wanNum);
    }

    public function deleteWANPeerDNS($wanNum) {
        $this->model->deleteWANPeerDNS($wanNum);
    }

    public function getWANIPAddr($wanNum) {
        return $this->model->getWANIPAddr($wanNum);
    }

    public function saveWANIPAddr($wanNum, $value) {
        $this->model->setWANIPAddr($wanNum, $value);
    }

    public function deleteWANIPAddr($wanNum) {
        $this->model->deleteWANIPAddr($wanNum);
    }

    public function getWANSubnetMask($wanNum) {
        return $this->model->getWANSubnetMask($wanNum);
    }

    public function getWANGateway($wanNum) {
        return $this->model->getWANGateway($wanNum);
    }

    public function getWANPriDNS($wanNum) {
        return $this->model->getWANPriDNS($wanNum);
    }

    public function getWANSecondaryDNS($wanNum) {
        return $this->model->getWANSecondaryDNS($wanNum);
    }

    public function getWANMacAddr($wanNum) {
        return $this->model->getWANMacAddr($wanNum);
    }

    public function getCustomMtu($wanNum) {
        return $this->model->getCustomMtu($wanNum) ? $this->model->getCustomMtu($wanNum): MTU_DEFAULT_VALUE;
    }

    public function getMetric($wanNum) {
        return $this->model->getMetric($wanNum);
    }

    public function saveCustomMacAddr($wanNum, $customMacAddr) {
        isset($customMacAddr) ? $this->model->setWANMacAddr($wanNum, $customMacAddr) : $this->model->deleteWANMacAddr($wanNum);
    }

    public function saveCustomMtu($wanNum, $customMtu) {
        isset($customMtu) ? $this->model->setCustomMtu($wanNum, $customMtu) : $this->model->deleteCustomMtu($wanNum);
    }

    public function saveMetric($wanNum) {
        $this->model->setMetric($wanNum, $wanNum == EMPTY_STRING ? METRIC_10 : $wanNum * 10);
    }

    public function deletePPPOEInfo($wanNum) {
        $this->deletePPPOEUser($wanNum);
        $this->deletePPPOEPwd($wanNum);
        $this->deletePPPOEServiceName($wanNum);
        $this->deletePPPOEKeepAlive($wanNum);
    }

    public function deletePPPOEUser($wanNum) {
        $this->model->deletePPPOEUser($wanNum);
    }

    public function deletePPPOEPwd($wanNum) {
        $this->model->deletePPPOEPwd($wanNum);
    }

    public function deletePPPOEServiceName($wanNum) {
        $this->model->deletePPPOEServiceName($wanNum);
    }

    public function deletePPPOEKeepAlive($wanNum) {
        $this->model->deletePPPOEKeepAlive($wanNum);
    }

    public function deleteStaticInfo($wanNum) {
        $this->deleteWANIPAddr($wanNum);
        $this->deleteWANSubnetMask($wanNum);
        $this->deleteWanGateway($wanNum);
    }

    public function savePPPOEInfo($wanNum, $pppoeUser, $pppoePwd, $pppoeServiceName, $ppoeMaxFailedPing, $pppoePingInterval) {
        $this->savePPPOEUser($wanNum, $pppoeUser);
        $this->savePPPOEPwd($wanNum, $pppoePwd);
        $this->savePPPOEServiceName($wanNum, $pppoeServiceName);
        $this->savePPPOEKeepAlive($wanNum, $ppoeMaxFailedPing, $pppoePingInterval);
    }

    public function savePPPOEUser($wanNum, $pppoeUser) {
        $this->model->setPPPOEUser($wanNum, $pppoeUser);
    }

    public function savePPPOEPwd($wanNum, $pppoePwd) {
        $this->model->setPPPOEPwd($wanNum, $pppoePwd);
    }

    public function savePPPOEServiceName($wanNum, $pppoeServiceName) {
        $this->model->setPPPOEServiceName($wanNum, $pppoeServiceName);
    }

    public function savePPPOEKeepAlive($wanNum, $ppoeMaxFailedPing, $pppoePingInterval) {
        $this->model->setPPPOEKeepAlive($wanNum,$ppoeMaxFailedPing.SPACE.$pppoePingInterval);
    }

    public function saveStaticInfo($wanNum, $staticIP, $netMask, $gateWay) {
        $this->saveWANIPAddr($wanNum, $staticIP);
        $this->saveWANSubnetMask($wanNum, $netMask);
        $this->saveWANGateway($wanNum, $gateWay);
    }

    public function saveWANSubnetMask($wanNum, $netMask) {
        $this->model->setWANSubnetMask($wanNum, $netMask);
    }

    public function deleteWANSubnetMask($wanNum) {
        $this->model->deleteWANSubnetMask($wanNum);
    }

    public function saveWANGateway($wanNum, $gateWay) {
        $this->model->setWANGateway($wanNum, $gateWay);
    }

    public function deleteWanGateway($wanNum) {
        $this->model->deleteWanGateway($wanNum);
    }

    public function deleteWan($wanNum) {
        $this->model->deleteWan($wanNum);
    }

    public function saveLanIPAddr() {
        if (isset($_POST[LAN_IP_ADDR])) {
            $this->model->setLanIPAddr($_POST[LAN_IP_ADDR]);
        }
    }

    public function getIPAddr($vlanID) {
        return $vlanID == VLAN_ID_1 ? $this->getLanIPAddr() : $this->getVlanIPAddr($vlanID);
    }

    public function getVlanIPAddr($vlanID) {
        if ($this->model->getVlanIPAddr($vlanID)) {
            $vlanIPAddr = $this->model->getVlanIPAddr($vlanID);
        } else {
            $vlanIPAddr = $this->getIPV4Class() == IPV4_CLASS_C_KEY ? $this->getDefaultVlanIPAddr(): EMPTY_STRING;
        }
        return $vlanIPAddr;
    }

    public function getDefaultVlanIPAddr() {
        $lanIpAddrArray = explode(UCI_FIELD_DOT, $this->getLanIPAddr());
        return $lanIpAddrArray[0] . UCI_FIELD_DOT . $lanIpAddrArray[1] . UCI_FIELD_DOT . ($lanIpAddrArray[2] + $this->getDefaultVlanIPAddr3Octet()) . UCI_FIELD_DOT . $lanIpAddrArray[3];
    }

    public function getDefaultVlanIPAddr3Octet() {
        for ($i = 2; $i <= 16; $i++) {
            if ($this->getVLanVcfgEnabled($i) == VLAN_VCFG_DISABLE_KEY) {
                return $i - 1;
            }
        }
    }

    public function getVlanStatus() {
        return $this->model->getVlanStatus();
    }

    public function getIPV4Class() {
        return $this->model->getIPV4Class() ? $this->model->getIPV4Class() : IPV4_CLASS_C_KEY;
    }

    public function getIPAddrNum() {
        return $this->model->getDHCPLanLimit();
    }

    public function getClassCBase($vlanId) {
        return substr($this->getIPAddr($vlanId), 0, strripos($this->getIPAddr($vlanId), UCI_FIELD_DOT) +1);
    }

    public function getClassCStart() {
        return $this->model->getClassCStart();
    }

    public function getClassCEnd() {
        return $this->model->getClassCEnd();
    }

    public function getClassBStart() {
        return $this->model->getClassBStart();
    }

    public function getClassBEnd() {
        return $this->model->getClassBEnd();
    }

    public function getLeaseTime() {
        return $this->model->getLeaseTime();
    }

    public function assignLANIPAddr($view) {
        $view->Assign(LAN_IP_ADDR, $this->getLanIPAddr());
    }

    public function getLanIPAddr() {
        return $this->model->getLanIPAddr();
    }

    public function getLanSubnetMask() {
        return $this->model->getLanSubnetMask();
    }

    public function getLanIPAddrStart() {
        return $this->model->getLanIPAddrStart();
    }

    public function getLanIPAddrEnd() {
        return $this->model->getLanIPAddrEnd();
    }

    public function getLuxulMultiWanPorts() {
        return $this->model->getLuxulMultiWanPorts();
    }

    public function saveLuxulMultiWanPorts($value) {
        $this->model->setLuxulMultiWanPorts($value);
    }

    public function getAllClientsInfo() {
        $allClientsArray = $this->getAllClientsArray();
        $allClientsInfo = array();

        if (count($allClientsArray) > 0) {
            foreach ($allClientsArray as $key => $allClientsString) {
                if ($key != 0) {
                    $allClients = explode(SPACE, $allClientsString);
                    $hostName = $allClients[0];

                    if ($hostName == HOST_NAME_STAR) {
                        $hostName = $this->checkDhcpHostName($allClients[2]);;
                    }

                    $allClientsInfo[$key] = array(
                        HOST_NAME => $hostName,
                        IP_ADDRESS => $allClients[1],
                        MAC_ADDRESS => $allClients[2],
                    );
                }

            }
        }

        return $allClientsInfo;
    }

    public function  getAllClientsArray() {
        return $this->model->getAllClientsArray();
    }

    public function checkDhcpHostName($macAddr) {
        $dhcpHostIndex = $this->getDhcpHostIndex($macAddr);
        $dhcpHostName = HOST_NAME_STAR;

        if (isset($dhcpHostIndex)) {
            $dhcpHostName = $this->getDHCPName($dhcpHostIndex) ? $this->getDHCPName($dhcpHostIndex) : HOST_NAME_STAR;
        }

        return $dhcpHostName;
    }

    public function getDhcpHostIndex($macAddr) {
        return $this->model->getDhcpHostIndex($macAddr);
    }

    public function getDHCPName($index) {
        return $this->model->getDHCPName(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function getVlanMembers($vlanID) {
        $vlanMemberInfo = array();

        $vlanMember = str_replace(VLAN_PORT_8T, EMPTY_STRING, $vlanID == VLAN_ID_1 ? $this->getNetworkEth0Ports($vlanID) : $this->getNetworkEth0Ports($vlanID));
        $vlanMemberArray =  array_reverse(explode(SPACE, $vlanMember));

        if (count($vlanMemberArray) > 0) {
            foreach ($vlanMemberArray as $key => $vlanPort) {
                if ($vlanPort != EMPTY_STRING) {
                    $vlanPortReverse = $this->reverseVlanPort($vlanPort);

                    $vlanMemberInfo[] = $vlanPortReverse;
                }
            }
        }

        return implode(SPACE, $vlanMemberInfo);
    }

    public function saveVlanDescription($vlanNum, $value) {
        $this->model->setVlanDescription($vlanNum, $value);
    }

    public function getVlanDescription($vlanNum) {
        return $this->model->getVlanDescription($vlanNum);
    }

    public function getVlanRouting($vlanNum) {
        return $this->model->getVlanRouting($vlanNum) == VLAN_ROUTING_ENABLED_KEY ? VLAN_ROUTING_ENABLED_VAL : VLAN_ROUTING_DISABLED_VAL;
    }

    public function getVlanPorts($vlanID) {
        $vlanPortsAvailable =array();
        $vlanPortsArray = array_reverse(explode(SPACE,str_replace(VLAN_PORT_8T, EMPTY_STRING, $this->getNetworkEth0Ports($vlanID))));

        if (count($vlanPortsArray) > 0) {
            foreach($vlanPortsArray as $key=>$vlanPort) {
                if ($vlanPort != EMPTY_STRING) {
                    $vlanPortReverse = $this->reverseVlanPort($vlanPort);

                    $vlanPortsAvailable[$key] = $vlanPortReverse;
                }
            }
        }

        return $vlanPortsAvailable;
    }

    public function getPVIDPortIndex($vlanPortReverse) {
        return $this->model->getPVIDPortIndex($vlanPortReverse);
    }

    public function reverseVlanPort($vlanPort) {
        $vlanPortReverse = EMPTY_STRING;

        if ($vlanPort == VLAN_PORT_1) {
            $vlanPortReverse = VLAN_PORT_4;
        } else if ($vlanPort == VLAN_PORT_2) {
            $vlanPortReverse = VLAN_PORT_3;
        } else if ($vlanPort == VLAN_PORT_3) {
            $vlanPortReverse = VLAN_PORT_2;
        } else if ($vlanPort == VLAN_PORT_4) {
            $vlanPortReverse = VLAN_PORT_1;
        } else if ($vlanPort == VLAN_PORT_1T) {
            $vlanPortReverse = VLAN_PORT_4T;
        } else if ($vlanPort == VLAN_PORT_2T) {
            $vlanPortReverse = VLAN_PORT_3T;
        } else if ($vlanPort == VLAN_PORT_3T) {
            $vlanPortReverse = VLAN_PORT_2T;
        } else if ($vlanPort == VLAN_PORT_4T) {
            $vlanPortReverse = VLAN_PORT_1T;
        }

        return $vlanPortReverse;
    }

    public function getNetworkSwitchDevice($index) {
        return $this->model->getNetworkSwitchDevice($index);
    }

    public function saveVlanStatus($value) {
        $this->model->setVlanStatus($value);
    }

    function  saveNetworkEthPort($vlanId, $vlanPort) {
        $this->model->setNetworkEthPort($vlanId, $vlanPort);
    }

    function saveVlanVcfgEnabled($vlanNum, $value) {
        $this->model->setVlanVcfgEnabled($vlanNum, $value);
    }

    public function saveNetworkEthSwitchVlan($vlanId) {
        $this->model->setNetworkEthSwitchVlan($vlanId);
    }

    public function deleteNetworkEthSwitchVlan($vlanId) {
        $this->model->deleteNetworkEthSwitchVlan($vlanId);
    }

    public function saveNetworkEthDevice($vlanId) {
        $this->model->setNetworkEthDevice($vlanId);
    }

    public function saveNetworkEthVlan($vlanId) {
        $this->model->setNetworkEthVlan($vlanId);
    }

    public function saveNetworkVlanInterface($vlanId) {
        $this->model->setNetworkVlanInterface($vlanId);
    }

    public function saveNetworkVlanIfname($vlanId) {
        $this->model->setNetworkVlanIfname($vlanId);
    }

    public function saveNetworkVlanProto($vlanId) {
        $this->model->setNetworkVlanProto($vlanId);
    }

    public function saveNetworkVlanIpAddr($vlanId, $ipAddr) {
        $this->model->setNetworkVlanIpAddr($vlanId, $ipAddr);
    }

    public function saveNetworkVlanNetmask($vlanNum, $subnetMask) {
        $this->model->setNetworkVlanNetmask($vlanNum, $subnetMask);
    }

    public function getLanSubnetMaskOptions($vlanID) {
        $options=array(
            SUBNET_MASK_255_255_0_0_VAL => SUBNET_MASK_255_255_0_0_VAL_FULL,
            SUBNET_MASK_255_255_128_0_VAL => SUBNET_MASK_255_255_128_0_VAL_FULL,
            SUBNET_MASK_255_255_192_0_VAL => SUBNET_MASK_255_255_192_0_VAL_FULL,
            SUBNET_MASK_255_255_224_0_VAL => SUBNET_MASK_255_255_224_0_VAL_FULL,
            SUBNET_MASK_255_255_240_0_VAL => SUBNET_MASK_255_255_240_0_VAL_FULL,
            SUBNET_MASK_255_255_248_0_VAL => SUBNET_MASK_255_255_248_0_VAL_FULL,
            SUBNET_MASK_255_255_252_0_VAL => SUBNET_MASK_255_255_252_0_VAL_FULL,
            SUBNET_MASK_255_255_254_0_VAL => SUBNET_MASK_255_255_254_0_VAL_FULL,
            SUBNET_MASK_255_255_255_0_VAL => SUBNET_MASK_255_255_255_0_VAL_FULL
        );

        return $this->helper->selectOption($options, $vlanID == VLAN_ID_1 ? $this->getLanSubnetMask(): $this->getVlanSubnetMask($vlanID));
    }

    public function getVlanSubnetMask($vlanID) {
        return $this->model->getVlanSubnetMask($vlanID) ? $this->model->getVlanSubnetMask($vlanID) : SUBNET_MASK_255_255_255_0_VAL;
    }

    public function saveVlanVcfgRoutingEnabled($vlanId, $value) {
        $this->model->setVlanVcfgRoutingEnabled($vlanId, $value);
    }

    public function getVLanVcfgEnabled($vlanNum) {
        return $this->model->getVLanVcfgEnabled($vlanNum);
    }

    public function saveVlanVcfgVlanId($vlanNum, $vlanId) {
        $this->model->setVlanVcfgVlanId($vlanNum, $vlanId);
    }

    public function getVlanVcfgVlanId($vlanNum) {
        return $this->model->getVlanVcfgVlanId($vlanNum);
    }

    public function addNetworkSwithPort() {
        $this->model->addNetworkSwithPort();
    }

    public function deleteNetworkSwithPort($networkSwithcPortIndex) {
        $this->model->deleteNetworkSwithPort($networkSwithcPortIndex);
    }

    public function saveNetworkSwitchPortVlanId($networkSwithcPortIndex, $vlanId) {
        $this->model->setNetworkSwitchPortVlanId($networkSwithcPortIndex, $vlanId);
    }

    public function saveNetworkSwitchPortNum($networkSwithcPortIndex, $portNum) {
        $this->model->setNetworkSwitchPortNum($networkSwithcPortIndex, $portNum);
    }

    public function saveNetworkSwitchPorPvid($networkSwithcPortIndex, $pvid) {
        $this->model->setNetworkSwitchPorPvid($networkSwithcPortIndex, $pvid);
    }

    public function saveIPAddrNum($value) {
        $this->model->setDHCPLanLimit($value);
    }

    public function saveLeaseTime($value) {
        $this->model->setLeaseTime($value);
    }

    public function saveDhcpVlan($vlanId) {
        $this->model->setDhcpVlan($vlanId);
    }

    public function saveDhcpVlanInterface($vlanId) {
        $this->model->setDhcpVlanInterface($vlanId);
    }

    public function saveDhcpVlanStart($vlanId, $start) {
        $this->model->setDhcpVlanStart($vlanId, $start);
    }

    public function saveDhcpVlanLimit($vlanId, $limit) {
        $this->model->setDhcpVlanLimit($vlanId, $limit);
    }

    public function saveDhcpVlanLeaseTime($vlanId, $leaseTime) {
        $this->model->setDhcpVlanLeaseTime($vlanId, $leaseTime);
    }

    public function deleteFirewallForwarding($value) {
        $index = 0;

        while ($this->getFirewallForwardingSrc($index)) {
            if ($this->getFirewallForwardingSrc($index) === trim(VLAN . $value)) {
                $this->model->deleteFirewallForwarding(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
                break;

            } else if ($this->getFirewallForwardingDest($index) === trim(VLAN . $value)){
                $this->model->deleteFirewallForwarding(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
                break;

            } else {
                $index++;
            }
        }
    }

    public function deleteFirewallZone($value) {
        $index = 0;

        while ($this->getFirewallZoneName($index)) {
            if ($this->getFirewallZoneName($index) == VLAN.$value) {
                $this->model->deleteFirewallZone(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
                break;
            } else {
                $index++;
            }
        }
    }

    public function getFirewallZoneName($index) {
        return $this->model->getFirewallZoneName(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function deleteFirewallRuleByName($ruleName) {
        $index = 0;

        while ($this->getFirewallRuleSrc($index)) {
            if ($this->getFirewallRuleName($index) == $ruleName) {
                $this->model->deleteFirewallRule(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
                break;
            } else {
                $index++;
            }
        }
    }

    public function deleteFirewallRuleBySrc($source) {
        $index = 0;

        while ($this->getFirewallRuleSrc($index)) {
            if ($this->getFirewallRuleSrc($index) == VLAN . $source) {
                $this->model->deleteFirewallRule(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
                break;
            } else {
                $index++;
            }
        }
    }

    public function deleteFirewallRedirectByName($name, $portForward) {
        $index = 0;

        while ($this->getFirewallRedirect($index)) {
            if ($this->getFirewallRedirectName($index) == $name && $this->getFirewallRedirectPortForward($index) == $portForward) {
                $this->deleteFirewallRedirect($index);
                break;
            } else {
                $index++;
            }
        }
    }

    public function getFirewallRedirect($index) {
        return $this->model->getFirewallRedirect(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function deleteFirewallRedirect($index) {
        $this->model->deleteFirewallRedirect(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function deleteNetworkVlanInfo($vlanId) {
        $this->model->deleteNetworkVlanInfo($vlanId);
    }

    public function getNetworkVlanInterface($vlanId) {
        return $this->model->getNetworkVlanInterface($vlanId);
    }

    public function deleteDhcpVlanInfo($vlanId) {
        if ($this->getDhcpVlan($vlanId)) {
            $this->model->deleteDhcpVlanInfo($vlanId);
        }
    }

    public function getDhcpVlan($vlanId) {
        return $this->model->getDhcpVlan($vlanId);
    }

    public function getFirewallRuleName($index) {
        return $this->model->getFirewallRuleName(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function getFirewallForwardingSrc($index) {
        return $this->model->getFirewallForwardingSrc(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function checkPVIDPort($index) {
        return $this->model->checkPVIDPort($index);
    }

    public function saveFirewallForwarding($source, $destination) {
        $this->addFirewallForwarding();
        $this->saveFirewallForwardingSrc($source);
        $this->saveFirewallForwardingDest($destination);
    }

    public function saveFirewallZone($deviceCheck, $zoneName, $networkName, $inputVal, $outputVal, $forwardVal) {
        $this->addFirewallZone();
        $this->saveFirewallZoneName($zoneName);
        $deviceCheck ?  $this->saveFirewallZoneDevice():  $this->saveFirewallZoneNetwork(UCI_FIELD_INDEX_LAST, VLAN.$networkName);
        $this->saveFirewallZoneInput($inputVal);
        $this->saveFirewallZoneOutput($outputVal);
        $this->saveFirewallZoneForward($forwardVal);
    }

    public function saveFirewallRule($ruleFamilyCheck, $ruleName, $protoName, $srcPort, $destPort, $source, $target) {
        $this->addFirewallRule();
        $this->saveFirewallRuleTarget($target);

        if ($ruleName != EMPTY_STRING) {
            $this->saveFirewallRuleName($ruleName);
        }

        $this->saveFirewallRuleProto($protoName);

        if ($srcPort != EMPTY_STRING) {
            $this->saveFirewallRuleSrcPort($srcPort);
        }

        $this->saveFirewallRuleDestPort($destPort);

        if ($ruleFamilyCheck) {
            $this->saveFirewallRuleFamily();
        }

        $this->saveFirewallRuleSrc($source);
    }

    public function addFirewallRule() {
        $this->model->addFirewallRule();
    }

    public function saveFirewallRuleTarget($target) {
        $this->model->setFirewallRuleTarget($target);
    }

    public function saveFirewallRuleName($ruleName) {
        $this->model->setFirewallRuleName($ruleName);
    }

    public function saveFirewallRuleProto($protoName) {
        $this->model->setFirewallRuleProto($protoName);
    }

    public function saveFirewallRuleSrcPort($srcPort) {
        $this->model->setFirewallRuleSrcPort($srcPort);
    }

    public function saveFirewallRuleDestPort($destPort) {
        $this->model->setFirewallRuleDestPort($destPort);
    }

    public function saveFirewallRuleFamily() {
        $this->model->setFirewallRuleFamily();
    }

    public function getFirewallRuleSrc($index) {
        return $this->model->getFirewallRuleSrc(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function saveFirewallRuleSrc($source) {
        $this->model->setFirewallRuleSrc($source);
    }

    public function saveFirewallRuleSrcIp($sourceIp) {
        $this->model->setFirewallRuleSrcIp($sourceIp);
    }

    public function addFirewallZone() {
        $this->model->addFirewallZone();
    }

    public function saveFirewallZoneName($zoneName) {
        $this->model->setFirewallZoneName($zoneName);
    }

    public function saveFirewallZoneDevice() {
        $this->model->setFirewallZoneDevice();
    }

    public function saveFirewallZoneNetwork($index, $networkName) {
        $this->model->setFirewallZoneNetwork($index, $networkName);
    }

    public function saveFirewallZoneInput($inputVal) {
        $this->model->setFirewallZoneInput($inputVal);
    }

    public function saveFirewallZoneOutput($outputVal) {
        $this->model->setFirewallZoneOutput($outputVal);
    }

    public function saveFirewallZoneForward($forwardVal) {
        $this->model->setFirewallZoneForward($forwardVal);
    }

    public function addFirewallForwarding() {
        $this->model->addFirewallForwarding();
    }

    public function saveFirewallForwardingSrc($source) {
        $this->model->setFirewallForwardingSrc($source);
    }

    public function saveFirewallForwardingDest($destination) {
        $this->model->setFirewallForwardingDest($destination);
    }

    public function getFirewallForwardingDest($index) {
        return $this->model->getFirewallForwardingDest(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function addFirewallRedirect() {
        $this->model->addFirewallRedirect();
    }

    public function saveFirewallRedirectSrc() {
        $this->model->setFirewallRedirectSrc();
    }

    public function saveFirewallRedirectProto($value) {
        $this->model->setFirewallRedirectProto($value);
    }

    public function saveFirewallRedirectSrcPort($value) {
        $this->model->setFirewallRedirectSrcPort($value);
    }

    public function saveFirewallRedirectDestPort($value) {
        $this->model->setFirewallRedirectDestPort($value);
    }

    public function saveFirewallRedirectTarget() {
        $this->model->setFirewallRedirectTarget();
    }

    public function saveFirewallRedirectDest() {
        $this->model->setFirewallRedirectDest();
    }

    public function saveFirewallRedirectDestIp($value) {
        $this->model->setFirewallRedirectDestIp($value);
    }

    public function getFirewallRedirectDestIp($index) {
        return $this->model->getFirewallRedirectDestIp(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function saveFirewallRedirectName($value) {
        $this->model->setFirewallRedirectName($value);
    }

    public function getFirewallRedirectName($index) {
        return $this->model->getFirewallRedirectName(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function saveFirewallRedirectPortForward($value) {
        $this->model->setFirewallRedirectPortForward($value);
    }

    public function getFirewallRedirectPortForward($index) {
        return $this->model->getFirewallRedirectPortForward(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getVpnMode() {
        return $this->model->getVpnMode();
    }

    public function addPPTPDLogin() {
        $this->model->addPPTPDLogin();
    }

    public function addXL2TPDLogin() {
        $this->model->addXL2TPDLogin();
    }

    public function geVpnUserInfo() {
        $vpnUserArray = array();

        if (file_exists(VPN_USERS_FILE) && filesize(VPN_USERS_FILE) > 1) {
            $index = 0;

            while ($this->getVpnUserName($index)) {
                $vpnUserArray[] = array(
                    USER_NAME => $this->getVpnUserName($index),
                    PASSWORD => $this->getVpnUserPassword($index)
                );

                $index++;
            }
        }

        return $vpnUserArray;
    }

    public function deletePPTPDUser($index) {
        $this->model->deletePPTPDUser(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function deleteXL2TPDUser($index) {
        $this->model->deleteXL2TPDUser(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);

    }

    public function saveXL2TPDUsername($userName) {
        $this->model->setXL2TPDUsername($userName);
    }

    public function getXL2TPDUsername($index) {
        return $this->model->getXL2TPDUsername(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function savePPTPUsername($userName) {
        $this->model->setPPTPUsername($userName);
    }

    public function getPPTPDUsername($index) {
        return $this->model->getPPTPDUsername(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function savePPTPPassword($password) {
        $this->model->setPPTPPassword($password);
    }

    public function getPPTPDPassword($index) {
        return $this->model->getPPTPDPassword(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function saveXL2TPDPassword($password) {
        $this->model->setXL2TPDPassword($password);
    }

    public function getXL2TPDPassword($index) {
        return $this->model->getXL2TPDPassword(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function saveIPSecUserInfo($userName, $password) {
        $this->model->saveIPSecUserInfo($userName, $password);
    }

    public function saveL2TPUserInfo() {
        $this->model->saveL2TPUserInfo();
    }

    public function deleteVpnUserInfo() {
        $this->model->deleteVpnUserInfo();
    }

    public function getCurrentTime() {
        return $this->model->getCurrentTime();
    }

    public function saveMultiWanStatus($value) {
        $this->model->setMultiWanStatus($value);
    }

    public function getMultiWanStatus() {
        return $this->model->getMultiWanStatus();
    }

    public function getMultiWanWizardStatus() {
        return $this->model->getMultiWanWizardStatus();
    }

    public function saveMultiWanWizardStatus($value) {
        $this->model->setMultiWanWizardStatus($value);
    }

    public function getMultiWanInterfaceStatus() {
        return $this->model->getMultiWanInterfaceStatus();
    }

    public function getMultiWanPolicyStatus() {
        return $this->model->getMultiWanPolicyStatus();
    }

    public function getMultiWanRuleStatus() {
        return $this->model->getMultiWanRuleStatus();
    }

    public function savePortMonitor($value)  {
        $this->model->setPortMonitor($value);
    }

    public function saveWanAccelerationStatus($value) {
        $this->model->setWanAccelerationStatus($value);
    }

    public function getAllPortsState() {
        return $this->model->getAllPortsState();
    }

    public function createVpnUserFile() {
        if (!file_exists(VPN_USERS_FILE)) {
            $this->model->createVpnUserFile();
        }
    }

    public function addVpnUserLogin() {
        $this->model->addVpnUserLogin();
    }

    public function deleteVpnUserLogin($index) {
        $this->model->deleteVpnUserLogin(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function saveVpnUserName($value, $index) {
        $this->model->setVpnUserName($value, $index);
    }

    public function getVpnUserName($index) {
        return $this->model->getVpnUserName(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function saveVpnUserPassword($value, $index) {
        $this->model->setVpnUserPassword($value, $index);
    }

    public function getVpnUserPassword($index) {
        return $this->model->getVpnUserPassword(INDEX_BRACKET_LEFT.$index.INDEX_BRACKET_RIGHT);
    }

    public function savePPTPDLocalIp() {
        $this->model->setPPTPDLocalIp();
    }

    public function savePPTPDRemoteIP($start, $end) {
        $this->model->setPPTPDRemoteIP($this->getClassCBase(VLAN_ID_1) . $start . HYPHEN . $end);
    }

    public function saveXL2TPDLocalIp() {
        $this->model->setXL2TPDLocalIp();
    }

    public function saveXL2TPDRemoteIP($start, $end) {
        $this->model->setXL2TPDRemoteIP($this->getClassCBase(VLAN_ID_1) . $start . HYPHEN . $end);
    }

    public function startVpn($vpnMode) {
        $this->model->startVpn($vpnMode);
    }

    public function stopVpn($vpnMode) {
        $this->model->stopVpn($vpnMode);
    }

    public function restartLuxulCtf() {
        $this->model->restartLuxulCtf();
    }

    public function getRouterLimits() {
        return $this->model->getRouterLimits();
    }

    public function getErrorMsg($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                $errorMsg = FILE_EXCEED_PHP_SIZE_MSG;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $errorMsg = FILE_EXCEED_HTML_SIZE_MSG;
                break;
            case UPLOAD_ERR_PARTIAL:
                $errorMsg = FILE_PARTIALLY_LOAD_MSG;
                break;
            case UPLOAD_ERR_NO_FILE:
                $errorMsg = NO_FILE_UPLOAD_MSG;
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $errorMsg = FILE_MISS_TMP_FOLDER_MSG;
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $errorMsg = FAIL_TO_WRITE_FILE_MSG;
                break;
            case UPLOAD_ERR_EXTENSION:
                $errorMsg = FILE_UPLOAD_STOP_MSG;
                break;
            default:
                $errorMsg = UNKNOWN_UPLOAD_ERROR_MSG;
                break;
        }

        return $errorMsg;
    }

    public function getBackupFile() {
        $this->model->getBackupFile();
    }

    public function downloadFile($fileName) {
        header(PRAGMA_PUBLIC);
        header(EXPIRES_0);
        header(CACHE_CONTROL_CHECK);
        header(CACHE_CONTROL_PRIVATE, FALSE);
        header(CONTENT_TYPE_FORCE_DOWNLOAD);
        header(CONTENT_TYPE_OCTET_STREAM);
        header(CONTENT_TYPE_DOWNLOAD);
        header(CONTENT_DESCRIPTION_FILE_TRANSFER);
        header(CONTENT_DISPOSITION_ATTACHMENT . basename(BACKUP_FILE . $this->getModel() . BACKUP_FILE_LXC_EXTENTION) . DOUBLE_QUOTE);
        header(CONTENT_TRANSFER_ENCODING);
        header(CONTENT_LENGTH . filesize($fileName));
        readfile($fileName);
    }

    public function restartSystem() {
        $this->model->restartSystem();
    }

    public function saveRebootRequired() {
        $this->model->saveRebootRequired();
    }

    public function checkRebootRequired() {
        return $this->model->checkRebootRequired();
    }

    public function commit() {
        $this->model->commit();
    }

    public function reboot() {
        $this->model->reboot();
    }

    public function __destruct() {
		if(!empty($this->view_name)){
			$this->view->Render($this->view_name);
		}
	}
	
}

