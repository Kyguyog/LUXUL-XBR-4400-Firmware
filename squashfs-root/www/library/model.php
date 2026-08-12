<?php

class Model extends Uci {
    protected $_model;
    protected $config;

    public function __construct() {
		$this->_model = get_class($this);
    }

    public function Load_Config($name){
        $configName = $name . CONFIG_CLASS;
        $this->config = new $configName();
    }

    public function getModel() {
        return $this->get(LUXUL_MODEL);
    }

    public function getVersion() {
        return $this->get(LUXUL_VERSION);
    }

    public function getFirmwareVersion() {
        return $this->get(LUXUL_FIRMWARE_VERSION);
    }

    public function getWANStatus($wanNum) {
        $this->execute(GET_WAN_STATUS_COMMAND.$wanNum, $output, $ret);
        return $output;
    }

    public function getWANMacAddrArray() {
        $this->execute(GET_WAN_MAC_ADDR_COMMAND, $output, $ret);
        return $output[0];
    }

    public function getLANMacAddrArray() {
        $this->execute(IF_CONFIG_BR_LAN, $output, $ret);
        return $output[0];
    }

    public function getWanProto($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.PROTO);
    }

    public function setWanProto($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.PROTO, $value);
    }

    public function getWANIPAddr($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.IP_ADDRESS);
    }

    public function setWANIPAddr($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.IP_ADDRESS, $value);
    }

    public function deleteWANIPAddr($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.IP_ADDRESS);
    }

    public function getWANSubnetMask($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.NET_MASK);
    }

    public function getWANGateway($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.GATE_WAY);
    }

    public function getWANDNS($wanNum) {
        $dns = $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.DNS);
        $dnsArray = array();
        if (isset($dns) && $dns != EMPTY_STRING) {
            $dnsArray = explode(SPACE, $dns);
        }
        return $dnsArray;
    }

    public function setLANDNS($value) {
        $this->set(NETWORK_LAN_DNS, $value);
    }

    public function setWANDNS($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.DNS, $value);
    }

    public function setWANPeerDNS($wanNum) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.PEER_DNS, NETWORK_WAN_PEERDNS_0);
    }

    public function deleteLANDNS() {
        $this->delete(NETWORK_LAN_DNS);
    }

    public function deleteWANDNS($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.DNS);
    }

    public function deleteWANPeerDNS($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.PEER_DNS);
    }

    public function getWANPriDNS($wanNum) {
        return isset($this->getWANDNS($wanNum)[0]) && $this->getWANDNS($wanNum)[0] != EMPTY_STRING ? $this->getWANDNS($wanNum)[0] : DEFAULT_PRIMARY_DNS;
    }

    public function getWANSecondaryDNS($wanNum) {
        return isset($this->getWANDNS($wanNum)[1]) && $this->getWANDNS($wanNum)[1] != EMPTY_STRING ? $this->getWANDNS($wanNum)[1] : EMPTY_STRING;
    }

    public function getWANMacAddr($wanNum) {
        $wanMacAddr = $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.strtolower(MAC_ADDRESS));

        if ($wanMacAddr == EMPTY_STRING) {
            $this->execute(GET_NVRAM_MAC_ADDRESS_COMMAND.$wanNum.strtolower(MAC_ADDRESS), $output, $ret);
            $wanMacAddr = count($output) >0 ? $output[0] : EMPTY_STRING;
        }

        return $wanMacAddr;
    }

    public function setWANMacAddr($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.strtolower(MAC_ADDRESS), $value);
    }

    public function deleteWANMacAddr($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.strtolower(MAC_ADDRESS));
    }

    public function getCustomMtu($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.MTU);
    }

    public function setCustomMtu($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.MTU, $value);
    }

    public function deleteCustomMtu($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.MTU);
    }

    public function setMetric($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.METRIC, $value);
    }

    public function getMetric($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.METRIC);
    }

    public function setPPPOEUser($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.USER_NAME, $value);
    }

    public function getPPPOEUser($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.USER_NAME);
    }

    public function deletePPPOEUser($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.USER_NAME);
    }

    public function setPPPOEPwd($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.PASSWORD, $value);
    }

    public function getPPPOEPwd($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.PASSWORD);
    }

    public function deletePPPOEPwd($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.PASSWORD);
    }

    public function setPPPOEServiceName($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.SERVICE, $value);
    }

    public function getPPPOEServiceName($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.SERVICE);
    }

    public function deletePPPOEServiceName($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.SERVICE);
    }

    public function setPPPOEKeepAlive($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.KEEP_ALIVE, $value);
    }

    public function getPPPOEKeepAlive($wanNum) {
        $keepAlive = $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.KEEP_ALIVE);
        $keepAliveArray = array();
        if (isset($keepAlive) && $keepAlive != EMPTY_STRING) {
            $keepAliveArray = explode(SPACE, $keepAlive);
        }
        return $keepAliveArray;
    }

    public function deletePPPOEKeepAlive($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.KEEP_ALIVE);
    }

    public function getPPPOEMaxFailedPing($wanNum) {
        return isset($this->getPPPOEKeepAlive($wanNum)[0]) && $this->getPPPOEKeepAlive($wanNum)[0] != EMPTY_STRING ? $this->getPPPOEKeepAlive($wanNum)[0] : DEFAULT_PPPOE_MAX_FAILED_PING;
    }

    public function getPPPOEPingInterval($wanNum) {
        return isset($this->getPPPOEKeepAlive($wanNum)[1]) && $this->getPPPOEKeepAlive($wanNum)[1] != EMPTY_STRING ? $this->getPPPOEKeepAlive($wanNum)[1] : DEFAULT_PPPOE_PING_INTERVAL;
    }

    public function setWANSubnetMask($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.NET_MASK, $value);
    }

    public function deleteWANSubnetMask($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.NET_MASK);
    }

    public function setWANGateway($wanNum, $value) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.GATE_WAY, $value);
    }

    public function deleteWanGateway($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.GATE_WAY);
    }

    public function deleteWan($wanNum) {
        $this->delete(NETWORK.UCI_FIELD_DOT.WAN.$wanNum);
    }

    public function setMwan3WanStatus($wanNum, $value) {
        $this->set(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.MULTI_WAN_STATUS_ENABLED, $value);
    }

    public function getMwan3WanStatus($wanNum) {
        return $this->get(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.MULTI_WAN_STATUS_ENABLED) == MWAN3_STATUS_ENABLED_KEY ? TRUE : FALSE;
    }

    public function setMultiWanDefaultPolicy($policyName) {
        $this->set(MULTI_WAN_DEFAULT_RULE_POLICY, $policyName);
    }

    public function getMultiWanDefaultPolicy() {
        return $this->get(MULTI_WAN_DEFAULT_RULE_POLICY);
    }

    public function setLanIPAddr($value) {
        $this->set(NETWORK_LAN_IPADDR, $value);
    }

    public function setLanSubnetMask($value) {
        $this->set(NETWORK_LAN_NETMASK, $value);
    }

    public function getLanIPAddr() {
        return $this->get(NETWORK_LAN_IPADDR);
    }

    public function getLanSubnetMask() {
        return $this->get(NETWORK_LAN_NETMASK);
    }

    public function getLanIPAddrStart() {
        return $this->get(LUXUL_LAN_IP_START) ? $this->get(LUXUL_LAN_IP_START) : $this->calculateLanIPAddrStart();
    }

    public function getVlanSubnetMask($vlanID) {
        return $this->get(NETWORK_VLAN . $vlanID . UCI_FIELD_DOT . NET_MASK);
    }

    public function getIPV4Class() {
        return $this->get(LUXUL_DHCP_CLASS);
    }

    public function getLanIPAddrEnd() {
        return $this->get(LUXUL_LAN_IP_END) ? $this->get(LUXUL_LAN_IP_END): $this->calculateLanIPAddrEnd();
    }

    public function getVlanIPAddr($vlanID) {
        return $this->get(NETWORK_VLAN . $vlanID . UCI_FIELD_DOT . IP_ADDRESS);
    }

    public function getClassCStart() {
        return $this->get(DHCP_LAN_START);
    }

    public function getClassCEnd() {
        return $this->getDHCPLanLimit() + $this->getClassCStart();
    }

    public function getClassBStart() {
        return $this->get(LUXUL_DHCP_START) ? $this->get(LUXUL_DHCP_START) :$this->calculateClassBStart();
    }

    public function getClassBEnd() {
        return $this->get(LUXUL_DHCP_END) ? $this->get(LUXUL_DHCP_END) : $this->calculateDhcpIPAddrEnd();
    }

    public function calculateLanIPAddrStart() {
        return $this->get(LUXUL_LAN_IP_START) ? $this->get(LUXUL_LAN_IP_START) : $this->getLanIPAddr();
    }

    public function calculateClassBStart() {
        return long2ip(ip2long($this->get(LUXUL_LAN_IP_START) ? $this->get(LUXUL_LAN_IP_START) : $this->getLanIPAddr()) + $this->get(DHCP_LAN_START) -1);
    }

    public function calculateLanIPAddrEnd() {
        $lanIPAddrArray = explode(UCI_FIELD_DOT, $this->getLanIPAddr());
        $lanSubnetMask = $this->getLanSubnetMask();

        if ($lanSubnetMask == SUBNET_MASK_255_255_255_0_VAL) {
            $lanIPEnd3Octet = $lanIPAddrArray[2];

        } else if ($lanSubnetMask == SUBNET_MASK_255_255_0_0_VAL) {
            $lanIPEnd3Octet = SUBNET_MASK_CLASS_C_OCTET_3_255;

        } else {
            $lanIPEnd3Octet = $this->getSubnetB3Octet($lanSubnetMask, $lanIPAddrArray[2]);
        }

        return $lanIPAddrArray[0].UCI_FIELD_DOT.$lanIPAddrArray[1].UCI_FIELD_DOT.$lanIPEnd3Octet.UCI_FIELD_DOT.SUBNET_MASK_CLASS_C_OCTET_4_254;
    }

    public function calculateDhcpIPAddrEnd() {
        return long2ip(ip2long($this->getClassBStart()) + $this->getDHCPLanLimit() - 1);
    }

    public function getSubnetB3Octet($lanSubnetMask, $lanIPAddr3Octet) {
        switch ($lanSubnetMask) {
            case SUBNET_MASK_255_255_128_0_VAL:
                $lanIPEnd3Octet = $lanIPAddr3Octet + 127;
                break;
            case SUBNET_MASK_255_255_192_0_VAL:
                $lanIPEnd3Octet = $lanIPAddr3Octet + 63;
                break;
            case SUBNET_MASK_255_255_224_0_VAL:
                $lanIPEnd3Octet = $lanIPAddr3Octet + 31;
                break;
            case SUBNET_MASK_255_255_240_0_VAL:
                $lanIPEnd3Octet = $lanIPAddr3Octet + 15;
                break;
            case SUBNET_MASK_255_255_248_0_VAL:
                $lanIPEnd3Octet = $lanIPAddr3Octet + 7;
                break;
            case SUBNET_MASK_255_255_252_0_VAL:
                $lanIPEnd3Octet = $lanIPAddr3Octet + 3;
                break;
            case SUBNET_MASK_255_255_254_0_VAL:
                $lanIPEnd3Octet = $lanIPAddr3Octet + 1;
                break;
            default:
                $lanIPEnd3Octet = EMPTY_STRING;
        }

        return $lanIPEnd3Octet;

    }

    public function getLuxlDHCPEnd() {
        return $this->get(LUXUL_DHCP_END) ;
    }

    public function setDHCPLanLimit($value) {
        $this->set(DHCP_LAN_LIMIT, $value);
    }

    public function getDHCPLanLimit() {
        return $this->get(DHCP_LAN_LIMIT);
    }

    public function getDHCPServerStatus() {
        return $this->get(DHCP_IGNORE);
    }

    public function setLeaseTime($value) {
        $this->set(DHCP_LAN_LEASE_TIME, $value);
    }

    public function getLeaseTime() {
        return str_replace(DHCP_LEASE_TIME_HOUR_UNIT, EMPTY_STRING, $this->get(DHCP_LAN_LEASE_TIME));
    }

    public function getAllClientsArray() {
        $this->shell_exec(DISCOVER_ALL_CLIENTS_SCRIPT);
        $this->execute(GET_ALL_CLIENTS_COMMAND, $output, $ret);
        return $output;
    }

    public function getDHCPName($index) {
        return $this->get(DHCP . UCI_FIELD_DOT . UCI_FIELD_AT . HOST . $index . UCI_FIELD_DOT . NAME);
    }

    public function setVlanDescription($vlanID, $value) {
        $this->set(LUXUL_VLAN_VCFG.$vlanID.UNDERSCORE.NAME, $value);
    }

    public function getVlanDescription($vlanNum) {
        return $this->get(LUXUL_VLAN_VCFG.$vlanNum.UNDERSCORE.NAME);
    }

    public function setVlanStatus($value) {
        $this->set(LXUL_DYNAMIC_VLAN, $value);
    }

    public function getVlanStatus() {
        return $this->get(LXUL_DYNAMIC_VLAN);
    }

    public function getVlanRouting($vlanNum) {
        return $this->get(LUXUL_VLAN_VCFG.$vlanNum.UNDERSCORE.ROUTING);
    }

    public function getNetworkEth0Ports($vlanID) {
        return $this->get(NETWORK_ETH0.$vlanID.UCI_FIELD_DOT.PORTS);
    }

    public function setMultiWanStatus($value) {
        $this->set(LUXUL_DYNAMIC_MULTI_WAN, $value);
    }

    public function getMultiWanStatus() {
        return $this->get(LUXUL_DYNAMIC_MULTI_WAN);
    }

    public function getLuxulMultiWanPorts() {
        return $this->get(LUXUL_DYNAMIC_MULTI_WAN_PORTS);
    }

    public function setLuxulMultiWanPorts($value) {
        $this->set(LUXUL_DYNAMIC_MULTI_WAN_PORTS, $value);
    }

    public function getPVIDPortIndex($vlanPortReverse) {
        $this->execute(GET_PVID_PORT_INDEX.$vlanPortReverse, $output, $ret);
        return count($output) > 0 ? $output : EMPTY_STRING;
    }

    public function getNetworkSwitchDevice($index) {
        return $this->get(NETWORK_SWITCH_PORT.$index.UCI_FIELD_DOT.DEVICE);
    }

    public function getPVIDPort($index) {
        return $this->get(NETWORK_SWITCH_PORT.$index.UCI_FIELD_DOT.PVID);
    }

    public function addNetworkSwithPort() {
        $this->add(NETWORK, SWITCH_PORT);
    }

    public function deleteNetworkSwithPort($networkSwithcPortIndex) {
        $this->delete(NETWORK_SWITCH_PORT.$networkSwithcPortIndex);
    }

    public function setNetworkSwitchPortVlanId($networkSwithcPortIndex, $vlanId){
        $this->set(NETWORK_SWITCH_PORT.$networkSwithcPortIndex.UCI_FIELD_DOT.VLAN.UNDERSCORE.ID, $vlanId);
    }

    public function setNetworkSwitchPortNum($networkSwithcPortIndex, $portNum){
        $this->set(NETWORK_SWITCH_PORT.$networkSwithcPortIndex.UCI_FIELD_DOT.PORT, $portNum);
    }

    public function setNetworkSwitchPorPvid($networkSwithcPortIndex, $pvid) {
        $this->set(NETWORK_SWITCH_PORT.$networkSwithcPortIndex.UCI_FIELD_DOT.PVID, $pvid);
    }

    public function setNetworkEthPort($vlanId, $vlanPort) {
        $this->set(NETWORK_ETH0.$vlanId.UCI_FIELD_DOT.PORTS, trim($vlanPort));
    }

    public function deleteNetworkEthSwitchVlan($vlanId) {
        $this->delete(NETWORK_ETH0.$vlanId);
    }

    public function setVlanVcfgEnabled($vlanId, $value) {
        $this->set(LUXUL_VLAN_VCFG.$vlanId, $value);
    }

    public function getVLanVcfgEnabled($vlanNum){
        return $this->get(LUXUL_VLAN_VCFG.$vlanNum);
    }

    public function setVlanVcfgVlanId($vlanNumAvaiable, $vlanId) {
        $this->set(LUXUL_VLAN_VCFG.$vlanNumAvaiable.UNDERSCORE.ID, $vlanId);
    }

    public function getVlanVcfgVlanId($vlanNum) {
        return $this->get(LUXUL_VLAN_VCFG.$vlanNum.UNDERSCORE.ID);
    }

    public function setVlanVcfgRoutingEnabled($vlanId, $value) {
        $this->set(LUXUL_VLAN_VCFG.$vlanId.UNDERSCORE.ROUTING, $value);
    }

    public function setNetworkEthSwitchVlan($vlanId) {
        $this->set(NETWORK_ETH0.$vlanId, SWITCH_VLAN);
    }

    public function setNetworkEthDevice($vlanId) {
        $this->set(NETWORK_ETH0.$vlanId.UCI_FIELD_DOT.DEVICE, ETH0);
    }

    public function setWanName($wanNum, $wanName) {
        $this->set(LUXUL_DYNAMIC.UCI_FIELD_DOT.$wanNum, $wanName);
    }

    public function getWanName($wanNum) {
        return $this->get(LUXUL_DYNAMIC.UCI_FIELD_DOT.$wanNum) ? $this->get(LUXUL_DYNAMIC.UCI_FIELD_DOT.$wanNum) : EMPTY_STRING;
    }

    public function setWanInterface($wanNum) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum, NAME_INTERFACE);
    }

    public function getWanInterface($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum);
    }

    public function setWanIfname($wanNum) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.INTERFACE_NAME, ETH0.UCI_FIELD_DOT.ETH0_408.$wanNum);
    }

    public function setWanIpv6($wanNum, $ipv6Status) {
        $this->set(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.IPV6, $ipv6Status);
    }

    public function setWanTrackingReliability($wanNum, $wanTrackingReliability) {
        $this->set(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.RELIABILITY, $wanTrackingReliability);
    }

    public function addWanTrackingIPList($wanNum, $wanTrackingIP) {
        $this->add_list(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.TRACK_IP, $wanTrackingIP);
    }

    public function getWanTrackingReliability($wanNum) {
        return $this->get(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.RELIABILITY);
    }

    public function deleteWanTrackingIP($wanNum) {
        $this->delete(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.TRACK_IP);
    }

    public function getWanTrackingIP($wanNum) {
        return $this->get(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.TRACK_IP);
    }

    public function setWanPingCount($wanNum, $wanPingCount) {
        $this->set(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.COUNT, $wanPingCount);
    }

    public function getWanPingCount($wanNum) {
        return $this->get(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.COUNT);
    }

    public function setWanPingTimeout($wanNum, $wanPingTimeout) {
        $this->set(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.TIME_OUT, $wanPingTimeout);
    }

    public function getWanPingTimeout($wanNum) {
        return $this->get(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.TIME_OUT);
    }

    public function setWanPingInterval($wanNum, $wanPingInterval) {
        $this->set(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.INTERVAL, $wanPingInterval);
    }

    public function getWanPingInterval($wanNum) {
        return $this->get(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.INTERVAL);
    }

    public function setWanInterfaceDown($wanNum, $wanInterfaceDown) {
        $this->set(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.DOWN, $wanInterfaceDown);
    }

    public function getWanInterfaceDown($wanNum) {
        return $this->get(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.DOWN);
    }

    public function setWanInterfaceUp($wanNum, $wanInterfaceUp) {
        $this->set(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.UP, $wanInterfaceUp);
    }

    public function getWanInterfaceUp($wanNum) {
        return $this->get(MWAN3.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.UP);
    }

    public function getIPV6Status($wanNum) {
        return $this->get(NETWORK.UCI_FIELD_DOT.WAN.$wanNum.UCI_FIELD_DOT.IPV6);
    }

    public function setMultiWanMemberNameByPolicy($policyName, $wanInterfaceName) {
        $this->add_list(MWAN3.UCI_FIELD_DOT.$policyName.UCI_FIELD_DOT.MULTIWAN_POLICY_USE_MEMBER, $wanInterfaceName);
    }

    public function getMultiWanMemberNameByPolicy($policyName) {
        return $this->get(MWAN3.UCI_FIELD_DOT.$policyName.UCI_FIELD_DOT.MULTIWAN_POLICY_USE_MEMBER);
    }

    public function deleteMultiWanMemberNameByPolicy($policyName) {
        $this->delete(MWAN3.UCI_FIELD_DOT.$policyName.UCI_FIELD_DOT.MULTIWAN_POLICY_USE_MEMBER);
    }

    public function deleteMultiWanMemberInfo($wanInferfaceName) {
        $this->delete(MWAN3.UCI_FIELD_DOT.$wanInferfaceName);
    }

    public function setWanMember($policyName, $wanInterfaceName) {
        $this->set(MWAN3.UCI_FIELD_DOT.$wanInterfaceName.UNDERSCORE.$policyName, MEMBER);
    }

    public function deleteWanGroup($policyName, $wanInterfaceName) {
        $this->delete(MWAN3.UCI_FIELD_DOT.$wanInterfaceName.UNDERSCORE.$policyName);
    }

    public function setWanMemberInterface($policyName, $wanInterfaceName) {
        $this->set(MWAN3.UCI_FIELD_DOT.$wanInterfaceName.UNDERSCORE.$policyName.UCI_FIELD_DOT.NAME_INTERFACE, $wanInterfaceName);
    }

    public function setWanMemberMetric($policyName, $wanInterfaceName, $metric) {
        $this->set(MWAN3.UCI_FIELD_DOT.$wanInterfaceName.UNDERSCORE.$policyName.UCI_FIELD_DOT.METRIC, $metric);
    }

    public function getWanMemberMetric($wanInterfaceName, $policyName) {
        return $this->get(MWAN3.UCI_FIELD_DOT.$wanInterfaceName.UNDERSCORE.$policyName.UCI_FIELD_DOT.METRIC);
    }

    public function saveWanMemberWeight($policyName, $wanInterfaceName, $weight) {
        $this->set(MWAN3.UCI_FIELD_DOT.$wanInterfaceName.UNDERSCORE.$policyName.UCI_FIELD_DOT.WEIGHT, $weight);
    }

    public function getWanMemberWeight($wanInterfaceName, $policyName) {
        return $this->get(MWAN3.UCI_FIELD_DOT.$wanInterfaceName.UNDERSCORE.$policyName.UCI_FIELD_DOT.WEIGHT);
    }

    public function deleteMultiWanRule($ruleName) {
        $this->delete(MWAN3.UCI_FIELD_DOT.$ruleName);
    }

    public function setMultiWanRuleName($value) {
        $this->set(MWAN3.UCI_FIELD_DOT.$value, RULE);
    }

    public function getMultiWanRuleName($policyName) {
        $this->execute(GET_MULTIWAN_RULE_NAME_COMMAND.$policyName, $output, $ret);
        return count($output) ? $output : EMPTY_STRING;
    }

    public function setMultiWanRuleSrcAddr($ruleName, $value) {
        $this->set(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.SOURCE_IP_SHORT, $value);
    }

    public function getMultiWanRuleSrcAddr($ruleName) {
        return $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.SOURCE_IP_SHORT) ? $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.SOURCE_IP_SHORT) : EMPTY_STRING;
    }

    public function setMultiWanRuleSrcPort($ruleName, $value) {
        $this->set(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.SOURCE_PORT_SHORT, $value);
    }

    public function getMultiWanRuleSrcPort($ruleName) {
        return $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.SOURCE_PORT_SHORT) ? $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.SOURCE_PORT_SHORT) : EMPTY_STRING;
    }

    public function setMultiWanRuleDestAddr($ruleName, $value) {
        $this->set(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.DESTINATION_IP_SHORT,$value);
    }

    public function getMultiWanRuleDestAddr($ruleName) {
        return $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.DESTINATION_IP_SHORT) ? $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.DESTINATION_IP_SHORT) : EMPTY_STRING;
    }

    public function setMultiWanRuleDestPort($ruleName, $value) {
        $this->set(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.DESTINATION_PORT_SHORT, $value);
    }

    public function getMultiWanRuleDestPort($ruleName) {
        return $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.DESTINATION_PORT_SHORT) ? $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.DESTINATION_PORT_SHORT) : EMPTY_STRING;
    }

    public function setMultiWanRuleProto($ruleName, $value) {
        $this->set(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.PROTO, $value);
    }

    public function getMultiWanRuleProto($ruleName) {
        return $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.PROTO) ? $this->get(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.PROTO) : EMPTY_STRING;
    }

    public function setMultiWanRulePolicy($ruleName, $value) {
        $this->set(MWAN3.UCI_FIELD_DOT.$ruleName.UCI_FIELD_DOT.MULTIWAN_POLICY_USE_POLICY,$value);
    }

    public function setNetworkEthVlan($vlanId) {
        $this->set(NETWORK_ETH0.$vlanId.UCI_FIELD_DOT.VLAN, $vlanId);
    }

    public function getNetworkVlanInterface($vlanId) {
        return $this->get(NETWORK_VLAN.$vlanId);
    }

    public function setNetworkVlanInterface($vlanId) {
        $this->set(NETWORK_VLAN.$vlanId, NAME_INTERFACE);
    }

    public function setNetworkVlanIfname($vlanId) {
        $this->set(NETWORK_VLAN.$vlanId.UCI_FIELD_DOT.INTERFACE_NAME, ETH0.UCI_FIELD_DOT.$vlanId);
    }

    public function setNetworkVlanProto($vlanId) {
        $this->set(NETWORK_VLAN.$vlanId.UCI_FIELD_DOT.PROTO, PROTO_STATIC);
    }

    public function setNetworkVlanIpAddr($vlanId, $ipAddr) {
        $this->set(NETWORK_VLAN.$vlanId.UCI_FIELD_DOT.IP_ADDRESS, $ipAddr);
    }

    public function setNetworkVlanNetmask($vlanId, $subnetMask) {
        $this->set(NETWORK_VLAN.$vlanId.UCI_FIELD_DOT.NET_MASK, $subnetMask);
    }

    public function setDhcpVlan($vlanId) {
        $this->set(DHCP.UCI_FIELD_DOT.VLAN.$vlanId, DHCP);
    }

    public function getDhcpVlan($vlanId) {
        return $this->get(DHCP.UCI_FIELD_DOT.VLAN.$vlanId);
    }

    public function deleteDhcpVlanInfo($vlanId) {
        $this->delete(DHCP.UCI_FIELD_DOT.VLAN.$vlanId);
    }

    public function deleteNetworkVlanInfo($vlanId) {
        $this->delete(NETWORK_VLAN.$vlanId);
    }

    public function setDhcpVlanInterface($vlanId) {
        $this->set(DHCP.UCI_FIELD_DOT.VLAN.$vlanId.UCI_FIELD_DOT.NAME_INTERFACE, VLAN.$vlanId);
    }

    public function setDhcpVlanStart($vlanId, $start) {
        $this->set(DHCP.UCI_FIELD_DOT.VLAN.$vlanId.UCI_FIELD_DOT.trim(START), $start);
    }
    public function setDhcpVlanLimit($vlanId, $limit) {
        $this->set(DHCP.UCI_FIELD_DOT.VLAN.$vlanId.UCI_FIELD_DOT.LIMIT, $limit);
    }

    public function setDhcpVlanLeaseTime($vlanId, $leaseTime) {
        $this->set(DHCP.UCI_FIELD_DOT.VLAN.$vlanId.UCI_FIELD_DOT.LEASE_TIME, $leaseTime.DHCP_LEASE_TIME_HOUR_UNIT);
    }

    public function addFirewallForwarding() {
        $this->add(FIREWALL, FORWARDING);
    }

    public function deleteFirewallForwarding($index) {
        $this->delete(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.FORWARDING.$index);
    }

    public function getFirewallForwardingSrc($index) {
        return $this->get(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.FORWARDING.$index.UCI_FIELD_DOT.SOURCE);
    }

    public function setFirewallForwardingSrc($source) {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . FORWARDING . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . SOURCE, $source == LAN ? LAN : VLAN . $source);
    }

    public function setFirewallForwardingDest($destination) {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . FORWARDING . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . DESTINATION, ($destination === LAN || $destination === WAN) ? $destination :  VLAN . $destination);
    }

    public function getFirewallForwardingDest($index) {
        return $this->get(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . FORWARDING . $index . UCI_FIELD_DOT . DESTINATION);
    }

    public function addFirewallZone() {
        $this->add(FIREWALL, ZONE);
    }

    public function deleteFirewallZone($index) {
        $this->delete(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.ZONE.$index);
    }

    public function setFirewallZoneName($zoneName) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.ZONE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.NAME, VLAN.$zoneName);
    }

    public function getFirewallZoneName($index) {
        return $this->get(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.ZONE.$index.UCI_FIELD_DOT.NAME);
    }

    public function setFirewallZoneDevice() {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.ZONE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.DEVICE, PPP_PLUS);
    }

    public function setFirewallZoneNetwork($index, $networkName) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.ZONE.$index.UCI_FIELD_DOT.NETWORK, $networkName);
    }

    public function setFirewallZoneInput($inputVal) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.ZONE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.INPUT, $inputVal);
    }

    public function setFirewallZoneOutput($outputVal) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.ZONE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.OUTPUT, $outputVal);
    }

    public function setFirewallZoneForward($forwardVal) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.ZONE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.FORWARD, $forwardVal);
    }

    public function addFirewallRule() {
        $this->add(FIREWALL, RULE);
    }

    public function deleteFirewallRule($index) {
        $this->delete(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.$index);
    }

    public function setFirewallRuleTarget($target) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.TARGET, $target);
    }

    public function setFirewallRuleName($ruleName) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.NAME, $ruleName);
    }

    public function getFirewallRuleName($index) {
        return $this->get(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.$index.UCI_FIELD_DOT.NAME);
    }

    public function setFirewallRuleSrcPort($sourcePort) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.SOURCE_PORT_SHORT, $sourcePort);
    }

    public function setFirewallRuleFamily() {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.FAMILY, IPV4);
    }

    public function setFirewallRuleDestPort($destinationPort) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.DESTINATION_PORT_SHORT, $destinationPort);
    }

    public function setFirewallRuleSrcIp($sourceIp) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.SOURCE_IP_SHORT, $sourceIp);
    }

    public function setFirewallRuleProto($proto) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.PROTO, $proto);
    }

    public function setFirewallRuleSrc($source) {
        $this->set(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.UCI_FIELD_INDEX_LAST.UCI_FIELD_DOT.SOURCE,
                   $source == LAN ? LAN : VLAN.$source);
    }

    public function getFirewallRuleSrc($index) {
        return $this->get(FIREWALL.UCI_FIELD_DOT.UCI_FIELD_AT.RULE.$index.UCI_FIELD_DOT.SOURCE);
    }

    public function addFirewallRedirect() {
        $this->add(FIREWALL, REDIRECT);
    }

    public function getFirewallRedirect($index) {
        return $this->get(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . $index) ? TRUE : FALSE;
    }

    public function setFirewallRedirectSrc() {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . SOURCE, WAN);
    }

    public function setFirewallRedirectProto($value) {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . PROTO, $value);
    }

    public function setFirewallRedirectSrcPort($value) {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . SOURCE_DPORT, $value);
    }

    public function setFirewallRedirectDestPort($value) {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . DESTINATION_PORT_SHORT, $value);
    }

    public function setFirewallRedirectTarget() {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . TARGET, TARGET_DEFAULT_VALUE);
    }

    public function setFirewallRedirectDest() {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . DESTINATION, LAN);
    }

    public function setFirewallRedirectDestIp($value) {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . DESTINATION_IP_SHORT, $value);
    }

    public function getFirewallRedirectDestIp($index) {
        return $this->get(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . $index . UCI_FIELD_DOT . DESTINATION_IP_SHORT);
    }

    public function setFirewallRedirectName($value) {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . NAME, $value);
    }

    public function getFirewallRedirectName($index) {
        return $this->get(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . $index . UCI_FIELD_DOT . NAME)
             ? $this->get(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . $index . UCI_FIELD_DOT . NAME) : EMPTY_STRING;
    }

    public function setFirewallRedirectPortForward($value) {
        $this->set(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . PORT_FORWARD, $value);
    }

    public function getFirewallRedirectPortForward($index) {
        return $this->get(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . $index . UCI_FIELD_DOT . PORT_FORWARD);
    }

    public function deleteFirewallRedirect($index) {
        $this->delete(FIREWALL . UCI_FIELD_DOT . UCI_FIELD_AT . REDIRECT . $index);
    }

    public function getVpnMode() {
        return $this->get(LUXUL_VPN_MODE);
    }

    public function addPPTPDLogin() {
        $this->add(PPTPD, LOGIN);
    }

    public function addXL2TPDLogin() {
        $this->add(XL2TPD, LOGIN);
    }

    public function deletePPTPDUser($index) {
        $this->delete(PPTPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . $index);
    }

    public function deleteXL2TPDUser($index) {
        $this->delete(XL2TPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . $index);
    }

    public function setPPTPUsername($userName) {
        $this->set(PPTPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . USER_NAME, $userName);
    }

    public function getPPTPDUsername($index) {
        return $this->get(PPTPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . $index . UCI_FIELD_DOT . USER_NAME);
    }

    public function setXL2TPDUsername($userName) {
        $this->set(XL2TPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . USER_NAME, $userName);
    }

    public function getXL2TPDUsername($index) {
        return $this->get(XL2TPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . $index . UCI_FIELD_DOT . USER_NAME);
    }

    public function setPPTPPassword($password) {
        $this->set(PPTPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . PASSWORD, $password);
    }

    public function getPPTPDPassword($index) {
        return $this->get(PPTPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . $index . UCI_FIELD_DOT . PASSWORD);
    }

    public function setXL2TPDPassword($password) {
        $this->set(XL2TPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . PASSWORD, $password);
    }

    public function getXL2TPDPassword($index) {
        return $this->get(XL2TPD . UCI_FIELD_DOT . UCI_FIELD_AT . LOGIN . $index . UCI_FIELD_DOT . PASSWORD);
    }

    public function setPPTPDLocalIp() {
        $this->set(PPTPD_LOCAL_IP, $this->getLanIPAddr());
    }

    public function setPPTPDRemoteIP($value) {
        $this->set(PPTPD_REMOTE_IP, $value);
    }

    public function setXL2TPDLocalIp() {
        $this->set(XL2PTD_LOCAL_IP, $this->getLanIPAddr());
    }

    public function setXL2TPDRemoteIP($value) {
        $this->set(XL2PTD_REMOTE_IP, $value);
    }

    public function saveIPSecUserInfo($userName, $password) {
        $userInfo = $userName . SPACE . COLON . SPACE . IPSEC_SECRECTS_XAUTH_FIELD . DOUBLE_QUOTE . $password . DOUBLE_QUOTE . PHP_EOL;
        file_put_contents(IPSEC_SECRECTS_FILE, $userInfo, FILE_APPEND);
    }

    public function deleteVpnUserInfo() {
        if (file_exists(VPN_USER_FILE)) {
            unlink(VPN_USER_FILE);
        }
    }

    public function getDhcpHostIndex($macAddr) {
        $this->execute(GET_DHCP_HOST_INDEX_COMMAND.$macAddr, $output, $ret);

        if (count($output) > 0) {
            $indexInfo = substr($output[0], strpos($output[0], INDEX_BRACKET_LEFT));
            $index = substr($indexInfo, 1, strpos($indexInfo, INDEX_BRACKET_RIGHT)-1);
            return $index;
        }
    }

    public function createVpnUserFile() {
        fopen(VPN_USERS_FILE, FILE_WRITE_FLAG);
    }

    public function addVpnUserLogin() {
        $this->add(VPN_USERS, LOGIN);
    }

    public function deleteVpnUserLogin($index) {
        $this->delete(VPN_USERS.UCI_FIELD_DOT.UCI_FIELD_AT.LOGIN.$index);
    }

    public function setVpnUserName($value, $index) {
        $this->set(VPN_USERS.UCI_FIELD_DOT.UCI_FIELD_AT.LOGIN.$index.UCI_FIELD_DOT.USER_NAME, $value);
    }

    public function getVpnUserName($index) {
        return $this->get(VPN_USERS.UCI_FIELD_DOT.UCI_FIELD_AT.LOGIN.$index.UCI_FIELD_DOT.USER_NAME);
    }

    public function setVpnUserPassword($value, $index) {
        $this->set(VPN_USERS.UCI_FIELD_DOT.UCI_FIELD_AT.LOGIN.$index.UCI_FIELD_DOT.PASSWORD, $value);
    }

    public function getVpnUserPassword($index) {
        return $this->get(VPN_USERS.UCI_FIELD_DOT.UCI_FIELD_AT.LOGIN.$index.UCI_FIELD_DOT.PASSWORD);
    }

    public function setMultiWanWizardStatus($value) {
        $this->set(LUXUL_DYNAMIC_MULTI_WIZARD, $value);
    }

    public function getMultiWanWizardStatus() {
        return $this->get(LUXUL_DYNAMIC_MULTI_WIZARD);
    }

    public function getMultiWanInterfaceStatus() {
        $this->execute(GET_MULTI_WAN_INTERFACE_STATUS_COMMAND, $output, $ret);
        return $output;
    }

    public function getMultiWanPolicyStatus() {
        $this->execute(GET_MULTI_WAN_POLICY_STATUS_COMMAND, $output, $ret);
        return $output;
    }

    public function getMultiWanRuleStatus() {
        $this->execute(GET_MULTI_WAN_RULE_STATUS_COMMAND, $output, $ret);
        return $output;
    }

    public function setPortMonitor($value) {
        $this->set(LUXUL_BETA_VLAN_MONITOR, $value);
    }

    public function setWanAccelerationStatus($value) {
        $this->set(LUXUL_CTF_BASIC_ENABLED, $value);
    }

    public function getAllPortsState() {
        $this->execute(GET_ALL_PORT_STATE_COMMAND, $output, $ret);
        return $output;
    }

    public function restartLuxulCtf() {
        $this->execute(RESTART_LUXUL_CTF_COMMAND, $output, $ret);
    }

    public function getRouterLimits() {
        return $this->get(TRL_ROUTER_LIMITS);
    }

    public function restartSystem() {
        $this->execute(RESTART_SYSTEM_COMMAND, $output, $ret);
    }

    public function getCurrentTime() {
        $this->execute(GET_CURRENT_TIME_COMMAND, $output, $ret);
        return $output[0];
    }

    public function getBackupFile() {
        $this->execute(BACK_UP_FILE_COMMAND, $output,$ret);
        return $ret;
    }

    public function startVpn($vpnMode) {
        $this->execute(VPN_COMMAND . $vpnMode . START, $output, $ret);
    }


    public function stopVpn($vpnMode) {
        $this->execute(VPN_COMMAND . $vpnMode . STOP, $output, $ret);
    }

    public function saveRebootRequired() {
        fopen(REBOOT_REQUIRED_FILE, FILE_WRITE_FLAG);
    }

    public function checkRebootRequired() {
        return file_exists(REBOOT_REQUIRED_FILE) ? TRUE : FALSE;
    }

    public function reboot() {
        $this->execute(REBOOT, $output, $ret);
    }

    public function __destruct() {

    }

}