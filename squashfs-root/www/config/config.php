<?php
// when Set to false, no error will be throw out, but saved in temp/log.txt file.
define ('DEVELOPMENT_ENVIRONMENT_TRUE',true);
define('DISPLAY_ERRORS', 'display_errors');
define('LOG_ERRORS', 'log_errors');
define('ERROR_LOG', 'error_log');
define('ERRORS_ON', 'On');
define('ERRORS_OFF', 'Off');
define('TEMP_FOLDER', 'tmp');
define('LOGS_FOLDER', 'logs');
define('ERROR_LOG_FILE', 'error.log');
define('ERROR_MESSAGE', 'Error: ');
define('CLASS_NOT_FOUND_ERROR', ' Class not found.');
define('FILE_MISSING_ERROR', 'might be missing');
define('REGISTER_GLOBALS', 'register_globals');
define('SESSION_ARRAY', '_SESSION');
define('POST_ARRAY', '_POST');
define('GET_ARRAY', '_GET');
define('COOKIE_ARRAY', '_COOKIE');
define('REQUEST_ARRAY', '_REQUEST');
define('SERVER_ARRAY', '_SERVER');
define('ENV_ARRAY', '_ENV');
define('FILES_ARRAY', '_FILES');
define('PHP_EXTENSION', '.php');
define('CONTROLLER_CLASS', '_Controller');
define('MODEL_CLASS', '_Model');
define('CONFIG_CLASS', '_Config');
define('BACKUP_FILE', 'config_');
define('STRIP_SLASHES_DEEP', 'stripSlashesDeep');
define('RIGHT_TRIM_WHITE_SPACE', 's');
define('QUOTE_ERROR', 'Quote ERROR -- Key/Value pairs cannot have single quotes!');

define('BACKUP_FILE_LXC_EXTENTION', '.lxc');
define('REBOOT_REQUIRED_FILE', '/tmp/.reboot');
define('TEMP_FILE_UPLOAD', '/tmp/.firmware_upload');
define('FIRMWARE_NAME_FILE', '/tmp/fwname.txt');
define('TMP_BACKUP_FILE', '/tmp/.backup');
define('TMP_SYS_LOG_FILE', '/tmp/.syslog');
define('IPSEC_SECRECTS_FILE', '/etc/ipsec.secrets');
define('XL2TPD_FILE', '/etc/xl2tpd/xl2tpd.conf');
define('VPN_USER_FILE', '/etc/vpn.user');
define('STRONG_SWAN_CONFIG_FILE', '/etc/strongswan.conf');
define('FIREWALL_USER_FILE', '/etc/firewall.user');
define('FIREWALL_USER_FILE_TEMP', '/tmp/firewallTMP ');
define('LUXUL_SYS_LOG', 'Luxul-Syslog-');
define('LOG_EXTENSION', '.log');
define('LUXUL', 'luxul');
define('VERSION_SHORT', ' v');
define('LOG_FILE', ' Log File');
define('FILE_WRITE_FLAG', 'w');

define('GET_WAN_STATUS_COMMAND','ifstatus wan');
define('GET_WAN_MAC_ADDR_COMMAND', 'ifconfig eth0.1');
define('FIRSTBOOT_COMMAND','echo "y" | firstboot 2>&1');
define('GET_LOG_MSG_COMMAND', 'logread');
define('IF_CONFIG_BR_LAN', 'ifconfig br-lan');
define('GET_ALL_PORT_STATE_COMMAND', 'swconfig dev switch0 show | grep link');
define('GET_PORT_INFO_COMMAND_PART1', 'swconfig dev switch0 port ');
define('GET_PORT_INFO_COMMAND_PART2', ' show');
define('DISCOVER_ALL_CLIENTS_SCRIPT', '/sbin/discover.sh');
define('GET_ALL_CLIENTS_COMMAND', 'cat /tmp/discovered.clients');
define('GET_DHCP_HOST_INDEX_COMMAND', 'uci show dhcp | grep mac=');
define('GET_MULTIWAN_RULE_NAME_COMMAND', 'uci show mwan3 | grep use_policy=');
define('RESTART_DNSMASQ_COMMAND', '/etc/init.d/dnsmasq restart');

define('GET_DHCP_CLIENTS_COMMAND', 'cat /tmp/dhcp.leases');
define('GET_ALL_ACTIVE_ROUTES_COMMAND', 'ip r');
define('GET_CURRENT_TIME_COMMAND', 'date');
define('GET_INTERFACE_NAME_COMMAND','uci show network |grep ifname | grep -v lo | cut -d "." -f2,3,4');
define('GET_MULTI_WAN_INTERFACE_STATUS_COMMAND', 'mwan3 interfaces');
define('GET_MULTI_WAN_POLICY_STATUS_COMMAND', 'mwan3 policies');
define('GET_MULTI_WAN_RULE_STATUS_COMMAND', 'mwan3 rules');
define('PING_COMMAND', 'ping -c 5 ');
define('TRACE_ROUTE_COMMAND', 'traceroute ');
define('RESTART_SYSTEM_COMMAND', '/etc/init.d/system restart');
define('SYS_LOG_SIZE', 'system.@system[0].log_size');
define('PPTPD_LOCAL_IP','pptpd.pptpd.localip');
define('PPTPD_REMOTE_IP','pptpd.pptpd.remoteip');
define('XL2PTD_LOCAL_IP', 'xl2tpd.xl2tpd.localip');
define('XL2PTD_REMOTE_IP','xl2tpd.xl2tpd.remoteip');
define('GET_NETWORK_SWITCH_PORT_INDEX_COMMAND','uci show network | grep port=');
define('BACK_UP_FILE_COMMAND','/sbin/lxconfig.sh -b .backup');

define ('DEFAULT_CONTROLLER', "quicksetup");
define ('DEFAULT_ACTION', "display");
define('OLD_FIRMWARE_URL', '?m=admin&sub=upgrade&upgrade_status=1');

define('MODEL', 'model');
define('VIEWS', 'views');
define('VERSION', 'version');
define('FIRMWARE_VERSION', 'firmwareVersion');
define('HEADER', 'header');
define('TITLE', 'title');
define('LEFT_NAV', 'leftNav');
define('HELP_MESSAGE', 'helpMessage');

define('REBOOT', 'reboot');
define('LOCATION', 'Location: ');
define('HELPER', 'helper');
define('REBOOT_REQUIRED', 'rebootRequired');
define('FACTORY_DEFAULT_REQUIRED', 'factoryDefaultRequired');
define('SAVE_BUTTON', 'btnSave');
define('SAVE_WAN_VLAN_TAG', 'btnSaveWanVlanTag');
define('SAVE_PORT_SPEED_INFO', 'btnPortSpeedInfo');
define('CANCEL_BUTTON', 'btnCancel');
define('REBOOT_BUTTON', 'btnReboot');
define('APPLY_BUTTON', 'btnApply');
define('NEXT_BUTTON', 'btnNext');
define('ADD_WAN_BUTTON', 'btnAddWan');
define('UNKNOWN_CONSTANTS', 'Unknown constants ');
define('PREVIOUS_PAGE', 'prePage');
define('TIMEZONE_FLAG','timezoneFlag');
define('TIMEZONE_FLAG_YES','yes');

define('LUXUL_MODEL', 'luxul.static.hw_model');
define('LUXUL_VERSION', 'luxul.static.hw_version');
define('LUXUL_FIRMWARE_VERSION', 'luxul.static.fw_version');
define('NETWORK_WAN_NETMASK', 'network.wan.netmask');
define('NETWORK_WAN_GATEWAY', 'network.wan.gateway');
define('NETWORK_WAN_DNS', 'network.wan.dns');
define('NETWORK_WAN_MAC', 'network.wan.macaddr');
define('NETWORK_LAN_IPADDR', 'network.lan.ipaddr');
define('NETWORK_LAN_DNS', 'network.lan.dns');
define('NETWORK_LAN_NETMASK', 'network.lan.netmask');
define('DHCP_LAN_LIMIT', 'dhcp.lan.limit');
define('DHCP_LAN_LEASE_TIME', 'dhcp.lan.leasetime');
define('DHCP_IGNORE', "dhcp.lan.ignore");
define('DHCP_LAN_START', 'dhcp.lan.start');
define('LUXUL_LAN_IP_START', 'luxul.dynamic.lanipstart');
define('LUXUL_DYNAMIC', 'luxul.dynamic');
define('MULTI_WAN_DEFAULT_RULE_POLICY', 'mwan3.default_rule.use_policy');
define('LUXUL_DMZ_STATUS', 'luxul.dynamic.dmz');
define('LUXUL_DHCP_CLASS','luxul.dynamic.dhcpclass');
define('LUXUL_DHCP_START', 'luxul.dynamic.dhcpstart');
define('LUXUL_DHCP_END', 'luxul.dynamic.dhcpend');
define('LUXUL_LAN_IP_END', 'luxul.dynamic.lanipend');
define('NETWORK_LAN', 'network.lan');
define('NETWORK_VLAN', 'network.vlan');
define('DHCP_VLAN', 'dhcp.vlan');
define('LXUL_DYNAMIC_VLAN', 'luxul.dynamic.vlan');
define('LUXUL_VPN_MODE', 'luxul.dynamic.vpn');
define('ADMIN_NEWPASSWORD', 'luxul.dynamic.ui_password');
define('SYSTEM_TIMEZONE', 'system.@system[0].timezone');
define('LUXUL_TIMEZONE_FLAG','luxul.dynamic.timezone');
define('LUXUL_VLAN_VCFG', 'luxul.vlan.vcfg');
define('LUXUL_DYNAMIC_MULTI_WAN', 'luxul.dynamic.multiwan');
define('LUXUL_DYNAMIC_MULTI_WIZARD', 'luxul.dynamic.mwan_wizard');
define('LUXUL_DYNAMIC_MULTI_WAN_PORTS', 'luxul.dynamic.multiwan_ports');
define('FW_VERSION', 'fw_version.static.fw_version');
define('NETWORK_ETH0_1_PORTS', 'network.eth0_1.ports');
define('LUXUL_BETA_VLAN_MONITOR','luxul.beta.vlans_monitor');
define('LUXUL_CTF_BASIC_ENABLED','luxulctf.basic.enabled');
define('NETWORK_WAN_PEERDNS_0','0');
define('TRL_ROUTER_LIMITS', 'TRL.TRL.enabled');
define('RESTART_LUXUL_CTF_COMMAND', '/etc/init.d/luxulctf restart > /dev/null 2>&1 &');
define('GET_PVID_PORT_INDEX', 'uci show network | grep port=');
define('NETWORK_SWITCH_PORT', 'network.@switch_port');
define('GET_NVRAM_MAC_ADDRESS_COMMAND', 'nvram get wan');


define('QUICKSETUP_PAGE', "/quicksetup/display");
define('DHCP_PAGE', '/dhcp/display');
define('LEASE_PAGE', '/lease/display');
define('MULITI_WAN_PAGE', '/multiwan/display');
define('MULITI_WAN2_PAGE', '/multiwan2/display');
define('MULITI_WAN3_PAGE', '/multiwan3/display');
define('MULITI_WAN4_PAGE', '/multiwan4/display');
define('MULTIWAN_MEMBER_PAGE', '/multiwanmember/display');
define('MULTIWAN_MEMBER2_PAGE', '/multiwanmember2/display');
define('MULTIWAN_MEMBER3_PAGE', '/multiwanmember3/display');
define('MULTIWAN_MEMBER4_PAGE', '/multiwanmember4/display');
define('MULTIWAN_POLICY_PAGE', '/multiwanpolicy/display');
define('LOG_PAGE', '/log/display');
define('BETA_PAGE', '/beta/display');

define('DNS_PAGE', '/dns/display');
define('ROUTING_PAGE', '/routing/display');
define('PORT_FORWARD_PAGE', '/portforward/display');
define('DMZ_PAGE', '/dmz/display');
define('VLAN_PAGE', "/vlan/display");
define('PASSWORD_PAGE', '/password/display');
define('REBOOT_PAGE', "/reboot/display");
define('UPGRADE_PROGRESS_PAGE', "/upgrade/progress");
define('FACTORY_PROGRESS_PAGE', "/factory/progress");
define('FACTORY_DISPLAY_PAGE', "/factory/display");
define('RESTORE_PROGRESS_PAGE', "/backup/progress");
define('TIMEZONE_PAGE', '/timezone/display');
define('ADVANCE_PAGE', '/advance/display');
define('QOS_PAGE', '/qos/display');
define('WEB_FILTER_PAGE', '/webfilter/display');
define('UPNP_PAGE','/upnp/display');
define('VPN_SERVER_PAGE', '/vpnserver/display');
define('VPN_USER_PAGE', '/vpnuser/display');
define('PORT_SPEED_PAGE', '/portspeed/display');
define('PARENTAL_CONTROL_PAGE','/routerlimits/display');

define('MULTI_WAN_PAGE', '/multiwan/display');
define('MULTI_WAN_SETTING_PAGE', '/multiwansetting/display');
define('VPN_USERS_FILE', '/etc/config/vpnusers');

define('QUICK_SETUP', 'quicksetup');
define('DHCP', 'dhcp');
define('CONNECTIONS', 'connections');
define('LEASE', 'lease');
define('DNS', 'dns');
define('PEER_DNS', 'peerdns');
define('MTU', 'mtu');
define('UPNP', 'upnp');
define('VLAN', 'vlan');
define('VLAN_CONFIG', 'vlanconfig');
define('ROUTING', 'routing');
define('PORT_FORWARD', 'portforward');
define('DMZ', 'dmz');
define('WEB_FILTER', 'webfilter');
define('ROUTER_LIMITS', 'routerlimits');
define('ROUTER_LIMITS_OPTIONS', 'routerLimitsOptions');
define('ROUTER_LIMITS_STATUS', 'routerLimitsStatus');
define('ROUTER_LIMITS_STATUS_CONNECTING_KEY', 'connecting');
define('ROUTER_LIMITS_STATUS_CONNECTING_VAL', 'Connecting');

define('ROUTER_LIMITS_STATUS_READY_KEY', 'ready');
define('ROUTER_LIMITS_STATUS_READY_VAL', 'Ready to Activate');
define('ROUTER_LIMITS_STATUS_ONLINE_KEY', 'online');
define('ROUTER_LIMITS_STATUS_ONLINE_VAL', 'Online');
define('ROUTER_LIMITS_DEVICE_ID', 'routerLimitsDeviceId');
define('QOS', 'qos');
define('PASSWORD', 'password');
define('SERVICE', 'service');
define('KEEP_ALIVE', 'keepalive');
define('UPGRADE', 'upgrade');
define('FACTORY', 'factory');
define('BACKUP', 'backup');
define('LOG', 'log');
define('COMPLIANCE', 'compliance');
define('IPERF', 'iperf');
define('SYSTEM', 'system');
define('BETA', 'beta');
define('APPLY_CHANGES', 'applyChanges');
define('VPN_USER', 'vpnuser');
define('VPN_USERS', 'vpnusers');

define('TIMEZONE', 'timezone');
define('ADVANCE', 'advance');
define('SETTING', 'setting');
define('SETUP', 'setup');
define('PROFILE', 'profile');
define('LAN', 'lan');
define('FORM', 'form');
define('PROGRESS', 'progress');
define('DISPLAY', 'display');
define('MESSAGE', 'message');
define('LED_CONTROL', 'ledcontrol');
define('INFO', 'info');
define('VPN_SERVER', 'vpnserver');
define('REDIRECT', 'redirect');
define('WIRELESS_SETTING', 'wirelesssetting');
define('OPTIONS', 'Options');
define('SSID_OPTIONS', 'ssidOptions');
define('PROFILE_24', 'profile24');
define('PROFILE_5', 'profile5');
define('RADIO', 'radio');
define('GUEST', 'guest');
define('HOST', 'host');
define('IP', 'ip');
define('MAC', 'mac');
define('PORT', 'port');
define('LINK', 'link');
define('PORT_SPEED', 'portspeed');

define('IP_ADDRESS', 'ipaddr');
define('SUBNET_MASK', 'subnetMask');
define('DHCP_SERVER_STATUS', 'dhcpServerStatus');
define('MULTIWAN_POLICY_USE_MEMBER', 'use_member');
define('MULTIWAN_POLICY_USE_POLICY', 'use_policy');
define('MULTI_WAN_SETTING', 'multiwansetting');
define('MULTI_WAN', 'multiwan');
define('MULTI_WAN2', 'multiwan2');
define('MULTI_WAN3', 'multiwan3');
define('MULTI_WAN4', 'multiwan4');
define('MULTI_WANS', 'multiwans');
define('MULTI_WAN_REPORT', 'multiwanreport');
define('MWAN3', 'mwan3');

define('SYSTEM_LOG_OPTIONS', 'sysLogSizeOptions');
define('LOG_MESSAGE', 'logMessage');
define('PORT_MONITORING_OPTIONS', 'portMonitoringOptions');
define('WAN_DELAY', 'wanDelay');
define('WAN_VLAN_TAG_OPTIONS', 'wanVlanTagOptions');
define('BLOCK_SELF_ASSIGNED_IP_OPTIONS', 'blockSelfAssignedIpOptions');

define('WAN_PORT_OPTIONS', 'wanPortOptions');
define('LAN_PORT_1_OPTIONS', 'lanPort1Options');
define('LAN_PORT_2_OPTIONS', 'lanPort2Options');
define('LAN_PORT_3_OPTIONS', 'lanPort3Options');
define('LAN_PORT_4_OPTIONS', 'lanPort4Options');

define('WAN_ACCELERATION_OPTIONS', 'wanAccelerationOptions');
define('WAN_PING_OPTIONS', 'wanPingOptions');
define('IPV6_WAN_OPTIONS', 'ipv6WanOptions');

define('PORT_SPEED_AUTO_KEY', 'disabled');
define('PORT_SPEED_AUTO_VAL', 'Auto');
define('PORT_SPEED_1000_BASE_KEY', 'duplex full speed 1000 autoneg on');
define('PORT_SPEED_1000_BASE_VAL', '1000Base-T');
define('PORT_SPEED_100_BASE_KEY', 'duplex half speed 100 autoneg off');
define('PORT_SPEED_100_BASE_VAL', '100Base-T');
define('PORT_SPEED_10_BASE_KEY', 'duplex half speed 10 autoneg off');
define('PORT_SPEED_10_BASE_VAL', '10Base-T');

define('ROUTER_LIMITS_DISABLED_KEY', '0');
define('ROUTER_LIMITS_DISABLED_VAL', 'Disabled');
define('ROUTER_LIMITS_ENABLED_KEY', '1');
define('ROUTER_LIMITS_ENABLED_VAL', 'Enabled');

define('MTU_DEFAULT_VALUE', '1500');

define('PORT_0', '0');
define('PORT_1', '1');
define('PORT_2', '2');
define('PORT_3', '3');
define('PORT_4', '4');

define('VPN_COMMAND','/etc/init.d/');

define('PORT_MONITOR_ENABLED_KEY', '1');
define('PORT_MONITOR_ENABLED_VAL', 'Enabled');
define('PORT_MONITOR_DISABLED_KEY', '0');
define('PORT_MONITOR_DISABLED_VAL', 'Disabled');

define('WAN_VLAN_TAG_ENABLED_PORT', '0t');
define('WAN_VLAN_TAG_ENABLED_KEY', 'enabled');
define('WAN_VLAN_TAG_ENABLED_VAL', 'Enabled');
define('WAN_VLAN_TAG_DISABLED_PORT', '0');
define('WAN_VLAN_TAG_DISABLED_KEY', 'disabled');
define('WAN_VLAN_TAG_DISABLED_VAL', 'Disabled');

define('SWITCH_VLAN_PORTS_ENABLED_VAL', '0t 8t');
define('SWITCH_VLAN_PORTS_DISABLED_VAL', '0 8t');
define('WAN_VLAN_ID_DEFAULT', '201');

define('BLOCK_SELF_ASSIGNED_IP_ENABLED_KEY', 'enabled');
define('BLOCK_SELF_ASSIGNED_IP_ENABLED_VAL', 'Enabled');
define('BLOCK_SELF_ASSIGNED_IP_DISABLED_KEY', 'disabled');
define('BLOCK_SELF_ASSIGNED_IP_DISABLED_VAL', 'Disabled');

define('SELF_ASSIGNED_IP', 'Self Assigned IP');
define('SELF_ASSIGNED_IP_DEFAULT', '169.254.0.0/16');

define('SYSTEM_LOG_SIZE_16_KEY', '16');
define('SYSTEM_LOG_SIZE_16_VAL', '16KB');
define('SYSTEM_LOG_SIZE_32_KEY', '32');
define('SYSTEM_LOG_SIZE_32_VAL', '32KB');
define('SYSTEM_LOG_SIZE_64_KEY', '64');
define('SYSTEM_LOG_SIZE_64_VAL', '64KB');

define('MULTI_WAN_POLICY', 'multiwanpolicy');
define('MULTI_WAN_RULE_INFO', 'ruleInfo');

define('MULTI_WAN_POLICY_BALANCED_MEMBER_INFO', 'multiWanPolicyBalancedMemberInfo');
define('MULTI_WAN_POLICY_BALANCED_2_MEMBER_INFO', 'multiWanPolicyBalanced2MemberInfo');
define('MULTI_WAN_POLICY_BALANCED_RULE_INFO', 'multiWanPolicyBalancedRuleInfo');
define('MULTI_WAN_POLICY_BALANCED_2_RULE_INFO', 'multiWanPolicyBalanced2RuleInfo');

define('MULTI_WAN_POLICY_FAILOVER_MEMBER_INFO', 'multiWanPolicyFailoverMemberInfo');
define('MULTI_WAN_POLICY_FAILOVER_2_MEMBER_INFO', 'multiWanPolicyFailover2MemberInfo');
define('MULTI_WAN_POLICY_FAILOVER_RULE_INFO', 'multiWanPolicyFailoverRuleInfo');
define('MULTI_WAN_POLICY_FAILOVER_2_RULE_INFO', 'multiWanPolicyFailover2RuleInfo');

define('MULTI_WAN_POLICY_SINGLE_WAN_MEMBER_INFO', 'multiWanPolicySingleWanMemberInfo');
define('MULTI_WAN_POLICY_SINGLWAN_RULE_INFO', 'multiWanPolicySingleWanRuleInfo');
define('MULTI_WAN_POLICY_SINGLE_WAN_2_MEMBER_INFO', 'multiWanPolicySingleWan2MemberInfo');
define('MULTI_WAN_POLICY_SINGLWAN_2_RULE_INFO', 'multiWanPolicySingleWan2RuleInfo');
define('MULTI_WAN_POLICY_SINGLE_WAN_3_MEMBER_INFO', 'multiWanPolicySingleWan3MemberInfo');
define('MULTI_WAN_POLICY_SINGLWAN_3_RULE_INFO', 'multiWanPolicySingleWan3RuleInfo');
define('MULTI_WAN_POLICY_SINGLE_WAN_4_MEMBER_INFO', 'multiWanPolicySingleWan4MemberInfo');
define('MULTI_WAN_POLICY_SINGLWAN_4_RULE_INFO', 'multiWanPolicySingleWan4RuleInfo');
define('MULTI_WAN_MEMBER_INFO', 'multiwanMemberInfo');

define('CHECK', 'check');
define('MEMBER_PRIORITY', 'memberPriority');
define('MEMBER_WEIGHT', 'memberWeight');
define('RULE_NAME', 'ruleName');

//define('LUXUL_DYNAMIC_4X_UPDATE_REQUIRED','0');

define('MULTI_WAN_WIZARD_STATUS', 'multiWanWizardStatus');
define('MULTI_WAN_STATUS', 'multiWanStatus');
define('MULTI_WAN_STATUS_OPTIONS', 'multiWanStatusOptions');
define('WAN_OPTIONS', 'wanOptions');
define('MULTI_WAN_POLICY_OPTIONS', 'multiWanPolicyOptions');

define('PING', 'ping');
define('TRACE', 'trace');
define('CMDLINE', 'cmdline');
define('LEASE_TIME', 'leasetime');
define('NETWORK', 'network');
define('RESULTS', 'results');
define('COMMAND', 'command');
define('SERVICE_LEVEL', 'serviceLevel');
define('SOURCE_HOST', 'sourceHost');
define('DEVICE_NAME', 'deviceName');
define('CPU_USAGE', 'cpuUsage');
define('MEMORY_USAGE', 'memoryUsage');
define('ADMIN_PASSWORD', 'adminPassword');
define('NEW_PASSWORD', 'new-password');
define('CONFIRMATION_PASSWORD', 'confirmation');
define('AP_FIRMWARE', 'apFirmware');
define('ERROR', 'error');
define('TMP_NAME', 'tmp_name');
define('ERROR_DISPLAY', 'errorDisplay');
define('ERROR_MSG', 'errorMsg');
define('SUCCESS_DISPLAY', 'successDisplay');
define('SUCCESS_MSG', 'successMsg');
define('RESTORE', 'restore');
define('RESTORE_FILE', 'restoreFile');
define('LOG_MSG', 'logMessage');
define('START_BUTTON', 'btnStart');
define('STOP_BUTTON', 'btnStop');
define('RUN_FOR', 'runFor');
define('WORD_DEFAULT', 'Default');

define('UPNP_STATUS_OPTIONS', 'upnpStatusOptions');
define('PROFILE_INFO', 'profileInfo');
define('FAMILY', 'family');
define('IPV4', 'ipv4');
define('FORWARDING', 'forwarding');
define('LEASE_CLIENTS_INFO', 'leaseClientsInfo');
define('DESCRIPTION', 'description');
define('ETH0', 'eth0');
define('PROTO_STATIC', 'static');
define('PORTS','ports');
define('PVID', 'pvid');
define('NAME', 'name');
define('PROTO','proto');
define('TARGET','target');
define('WIRELESS', 'wireless');
define('WIRELESS_5', 'radio0');
define('WIRELESS_24', 'radio1');
define('WIRELESS_5_IFCONFIG', 'wlan0');
define('WIRELESS_24_IFCONFIG', 'wlan1');
define('DISABLED', 'disabled');
define('CHANNEL', 'channel');
define('HTMODE', 'htmode');
define('HWMODE', 'hwmode');
define('MODE', 'mode');
define('SSID', 'ssid');
define('HIDDEN', 'hidden');
define('ISOLATE', 'isolate');
define('ENCRYPTION', 'encryption');
define('KEY', 'key');
define('MAC_ADDRESS', 'macAddr');
define('WIRELESS_MODE', 'wirelessMode');
define('CHANNEL_WIDTH', 'channelWidth');
define('CLIENT_MAC_ADDRESS', 'clientMacAddr');
define('CLIENT_RATE', 'clientRate');
define('DATA_RECEIVED', 'dataReceived');
define('DATA_TRANSMITTED', 'dataTransmitted');
define('CLIENT_NUM', 'clientNum');
define('CLIENT_LIST', 'clientList');
define('CLIENTS', 'clients');
define('PRIMARY', 'Primary');
define('SECONDARY', 'Secondary');
define('PPTP_PASSTHRU', 'PPTP Passthru');
define('RULE', 'rule');
define('LOGIN', 'login');
define('USER_NAME', 'username');
define('ZONE', 'zone');
define('ACCEPT', 'ACCEPT');
define('DROP', 'DROP');
define('REJECT', 'REJECT');
define('VPN', 'vpn');
define('IPSEC', 'ipsec');
define('PPP_PLUS', 'ppp+');
define('DEVICE', 'device');
define('INPUT', 'input');
define('OUTPUT', 'output');
define('FORWARD', 'forward');
define('FIREWALL', 'firewall');
define('WAN', 'wan');
define('SWITCH_VLAN', 'switch_vlan');
define('SWITCH_PORT', 'switch_port');
define('SWITCH0','switch0');

define('SOURCE', 'src');
define('SOURCE_ADDRESS', 'srcAddr');
define('SOURCE_PORT', 'srcPort');
define('SOURCE_IP_SHORT', 'src_ip');
define('SOURCE_PORT_SHORT', 'src_port');
define('SOURCE_DPORT', 'src_dport');
define('DESTINATION_ADDRESS', 'destAddr');
define('DESTINATION_IP_SHORT', 'dest_ip');
define('DESTINATION_PORT', 'destPort');
define('DESTINATION_PORT_SHORT', 'dest_port');

define('RULE_NAME_ALLOW_DNS_QUERIES', 'Allow DNS Queries');
define('RULE_NAME_ALLOW_DHCP_REQUESTS', 'Allow DHCP Requests');

define('TARGET_DEFAULT_VALUE','DNAT');
define('DESTINATION', 'dest');
define('STATUS_SUCCESS', 'success');
define('UNSPECIFIED', 'Unspecified');
define('MEMORY_TOTAL', 'MemTotal: ');
define('MEMORY_FREE', 'MemFree: ');
define('UPTIME', 'uptime');
define('CURRENT_TIME', 'currentTime');
define('TIMEZONE_OPTIONS', 'timeZoneOptions');
define('FORWARDED_PORTS_INFO', 'forwardedPortsInfo');
define('APPLICATION_NAME', 'applicationName');
define('PROTOCAL', 'protocol');
define('WAN_PORT', 'wanPort');
define('VIA', 'via');
define('METRIC', 'metric');
define('WEIGHT', 'weight');
define('METRIC_10', '10');
define('RELIABILITY', 'reliability');
define('COUNT', 'count');
define('TIME_OUT', 'timeout');
define('INTERVAL', 'interval');
define('DOWN', 'down');
define('UP', 'up');

define('ROUTE', 'route');
define('DEV', 'dev');
define('INTERFACE_LAN_VAL', 'LAN');
define('INTERFACE_LAN_KEY', 'lan');
define('INTERFACE_BR_LAN', 'br-lan');
define('NAME_INTERFACE', 'interface');
define('INTERFACE_NAME', 'ifname');
define('LIMIT', 'limit');
define('LEASES', 'leases');
define('MASK', 'mask: ');
define('VLANS', 'vlans');

define('START',' start');
define('STOP',' stop');

define('WAN_NAME', 'wanName');
define('CONNECTION_TYPE_OPTIONS', 'connectionTypeOptions');
define('MULTI_WAN_REPORT_OPTIONS', 'multiWanReportOptions');
define('MULTI_WAN_INTERFACE', 'multiWanInterface');
define('MULTI_WAN_INTERFACE_STATUS', 'multiWanInterfaceStatus');
define('MULTI_WAN_POLICY_STATUS', 'multiWanPolicyStatus');
define('MULTI_WAN_RULES_STATUS', 'multiWanRuleStatus');
define('PPPOE_USER', 'pppoeUser');
define('PPPOE_PASSWORD', 'pppoePwd');
define('PPPOE_SERVICE_NAME', 'pppoeServiceName');
define('PPPOE_MAX_FAILED_PING', 'pppoeMaxFailedPing');
define('PPPOE_PING_INTERVAL', 'pppoePingInterval');
define('STATIC_IP', 'staticIp');
define('NET_MASK', 'netmask');
define('GATE_WAY', 'gateway');
define('PRIMARY_DNS', 'primaryDNS');
define('SECONDARY_DNS', 'secondaryDns');
define('CUSTOM_MAC_ADDR', 'customMacAddr');
define('CUSTOM_MTU', 'customMtu');
define('LAN_SUBNET_MASK', 'lanSubnetMask');
define('LAN_IP_ADDR_START', 'lanIPAddrStart');
define('LAN_IP_ADDR', 'lanIPAddr');
define('LAN_MAC_ADDR', 'lanMacAddr');
define('LAN_PORT', 'lanPort');
define('CONNECTION_TYPE', 'connectionType');
define('WAN_IP_ADDR', 'wanIPAddr');
define('WAN_SUBNET_MASK', 'wanSubnetMask');
define('WAN_GATE_WAY', 'wanGateway');
define('WAN_DNS_SERVER', 'wanDNSServer');
define('WAN_ALTERNATE_DNS', 'wanAlternateDNS');
define('WAN_MAC_ADDR', 'wanMacAddr');
define('WAN_MTU', 'wanMtu');
define('WAN_METRIC', 'wanMetric');
define('TRACKING_RELIABILITY', 'trackingReliability');
define('TRACKING_IP', 'trackingIP');
define('TRACK_IP', 'track_ip');
define('PING_COUNT', 'pingCount');
define('PING_TIME_OUT', 'pingTimeout');
define('PING_INTERVAL', 'pingInterval');
define('INTERFACE_DOWN', 'interfaceDown');
define('INTERFACE_UP', 'interfaceUp');

define('CONNECTED_CLIENTS_OPTIONS', 'connectedClientsOptions');
define('ALL_CLIENTS_INFO', 'allClientsInfo');
define('DHCP_CLIENTS_INFO', 'dhcpClientsInfo');

define('HOST_NAME', 'hostName');
define('HOST_NAME_STAR', '*');

define('WAN_TRACKING_RELIABILITY_0', '0');
define('WAN_TRACKING_RELIABILITY_1', '1');
define('WAN_TRACKING_RELIABILITY_2', '2');
define('WAN_TRACKING_RELIABILITY_3', '3');
define('WAN_TRACKING_RELIABILITY_4', '4');
define('WAN_TRACKING_RELIABILITY_5', '5');

define('WAN_PING_COUNT_1', '1');
define('WAN_PING_COUNT_2', '2');
define('WAN_PING_COUNT_3', '3');
define('WAN_PING_COUNT_4', '4');
define('WAN_PING_COUNT_5', '5');
define('WAN_PING_COUNT_6', '6');
define('WAN_PING_COUNT_7', '7');
define('WAN_PING_COUNT_8', '8');
define('WAN_PING_COUNT_9', '9');
define('WAN_PING_COUNT_10', '10');

define('WAN_PING_TIMEOUT_1_KEY', '1');
define('WAN_PING_TIMEOUT_1_VAL', '1 second');
define('WAN_PING_TIMEOUT_2_KEY', '2');
define('WAN_PING_TIMEOUT_2_VAL', '2 seconds');
define('WAN_PING_TIMEOUT_3_KEY', '3');
define('WAN_PING_TIMEOUT_3_VAL', '3 seconds');
define('WAN_PING_TIMEOUT_4_KEY', '4');
define('WAN_PING_TIMEOUT_4_VAL', '4 seconds');
define('WAN_PING_TIMEOUT_5_KEY', '5');
define('WAN_PING_TIMEOUT_5_VAL', '5 seconds');
define('WAN_PING_TIMEOUT_6_KEY', '6');
define('WAN_PING_TIMEOUT_6_VAL', '6 seconds');
define('WAN_PING_TIMEOUT_7_KEY', '7');
define('WAN_PING_TIMEOUT_7_VAL', '7 seconds');
define('WAN_PING_TIMEOUT_8_KEY', '8');
define('WAN_PING_TIMEOUT_8_VAL', '8 seconds');
define('WAN_PING_TIMEOUT_9_KEY', '9');
define('WAN_PING_TIMEOUT_9_VAL', '9 seconds');
define('WAN_PING_TIMEOUT_10_KEY', '10');
define('WAN_PING_TIMEOUT_10_VAL', '10 seconds');

define('WAN_PING_INTERVAL_1_SECOND_KEY', '1');
define('WAN_PING_INTERVAL_1_SECOND_VAL', '1 second');
define('WAN_PING_INTERVAL_3_SECONDS_KEY', '3');
define('WAN_PING_INTERVAL_3_SECONDS_VAL', '3 seconds');
define('WAN_PING_INTERVAL_5_SECONDS_KEY', '5');
define('WAN_PING_INTERVAL_5_SECONDS_VAL', '5 seconds');
define('WAN_PING_INTERVAL_10_SECONDS_KEY', '10');
define('WAN_PING_INTERVAL_10_SECONDS_VAL', '10 seconds');
define('WAN_PING_INTERVAL_20_SECONDS_KEY', '20');
define('WAN_PING_INTERVAL_20_SECONDS_VAL', '20 seconds');
define('WAN_PING_INTERVAL_30_SECONDS_KEY', '30');
define('WAN_PING_INTERVAL_30_SECONDS_VAL', '30 seconds');
define('WAN_PING_INTERVAL_1_MINUTE_KEY', '60');
define('WAN_PING_INTERVAL_1_MINUTE_VAL', '1 minute');
define('WAN_PING_INTERVAL_5_MINUTES_KEY', '300');
define('WAN_PING_INTERVAL_5_MINUTES_VAL', '5 minutes');
define('WAN_PING_INTERVAL_10_MINUTES_KEY', '600');
define('WAN_PING_INTERVAL_10_MINUTES_VAL', '10 minutes');
define('WAN_PING_INTERVAL_30_MINUTES_KEY', '1800');
define('WAN_PING_INTERVAL_30_MINUTES_VAL', '30 minutes');
define('WAN_PING_INTERVAL_1_HOUR_KEY', '3600');
define('WAN_PING_INTERVAL_1_HOUR_VAL', '1 hour');

define('WAN_INTERFACE_UP_DOWN_1', '1');
define('WAN_INTERFACE_UP_DOWN_2', '2');
define('WAN_INTERFACE_UP_DOWN_3', '3');
define('WAN_INTERFACE_UP_DOWN_4', '4');
define('WAN_INTERFACE_UP_DOWN_5', '5');
define('WAN_INTERFACE_UP_DOWN_6', '6');
define('WAN_INTERFACE_UP_DOWN_7', '7');
define('WAN_INTERFACE_UP_DOWN_8', '8');
define('WAN_INTERFACE_UP_DOWN_9', '9');
define('WAN_INTERFACE_UP_DOWN_10', '10');

define('CONNECTION_TYPE_DCHP_KEY', 'dhcp');
define('CONNECTION_TYPE_DCHP_VAL', 'DHCP');
define('CONNECTION_TYPE_PPPOE_KEY', 'pppoe');
define('CONNECTION_TYPE_PPPOE_VAL', 'PPPoE');
define('CONNECTION_TYPE_STATIC_KEY', 'static');
define('CONNECTION_TYPE_STATIC_VAL', 'Static IP');

define('UPNP_STATUS_DISABLED_KEY','0');
define('UPNP_STATUS_DISABLED_VAL','Disabled');
define('UPNP_STATUS_ENABLED_KEY','1');
define('UPNP_STATUS_ENABLED_VAL','Enabled');

define('MULTI_WAN_STATUS_DISABLED_KEY','0');
define('MULTI_WAN_STATUS_DISABLED_VAL','Disabled');
define('MULTI_WAN_STATUS_ENABLED_KEY','1');
define('MULTI_WAN_STATUS_ENABLED_VAL','Enabled');

define('MULTI_WAN_POLICY_BALANCED_KEY', 'balanced');
define('MULTI_WAN_POLICY_BALANCED_VAL', 'Balanced');
define('MULTI_WAN_POLICY_BALANCED_2_KEY', '2balanced');
define('MULTI_WAN_POLICY_BALANCED_2_VAL', 'BALANCED B');

define('MULTI_WAN_POLICY_FAILOVER_KEY', 'failover');
define('MULTI_WAN_POLICY_FAILOVER_VAL', 'Failover');
define('MULTI_WAN_POLICY_FAILOVER_2_KEY', '2failover');
define('MULTI_WAN_POLICY_FAILOVER_2_VAL', 'Failover B');

define('MULTI_WAN_POLICY_SINGLE_WAN_KEY', 'singlewan');
define('MULTI_WAN_POLICY_SINGLE_WAN_VAL', 'Single Wan');
define('MULTI_WAN_POLICY_SINGLE_WAN_2_KEY', '2singlewan');
define('MULTI_WAN_POLICY_SINGLE_WAN_2_VAL', 'Single Wan B');
define('MULTI_WAN_POLICY_SINGLE_WAN_3_KEY', '3singlewan');
define('MULTI_WAN_POLICY_SINGLE_WAN_3_VAL', 'Single Wan C');
define('MULTI_WAN_POLICY_SINGLE_WAN_4_KEY', '4singlewan');
define('MULTI_WAN_POLICY_SINGLE_WAN_4_VAL', 'Single Wan D');

define('MWAN3_STATUS_ENABLED_KEY', '1');
define('MWAN3_STATUS_DISABLED_KEY', '0');

define('LUXUL_DYNAMIC_MULTI_WAN_PORTS_0', '0');
define('NETWORK_ETH0_1_PORTS_DEFAULT', '1 2 3 4 8t');
define('NETWORK_ETH0_PORTS_WAN2_ENABLED', '2 3 4 8t');
define('NETWORK_ETH0_PORTS_WAN3_ENABLED', '3 4 8t');
define('NETWORK_ETH0_PORTS_WAN4_ENABLED', '4 8t');

define('DEFAULT_PPPOE_MAX_FAILED_PING','3');
define('DEFAULT_PPPOE_PING_INTERVAL', '5');

define('DHCP_SERVER_STATUS_ENABLED_KEY', '0');
define('DHCP_SERVER_STATUS_ENABLED_VAL', 'Enabled');
define('DHCP_SERVER_STATUS_DISBLED_KEY', '1');
define('DHCP_SERVER_STATUS_DISBLED_VAL', 'Disabled');

define('DNS_STATUS_DISABLED_KEY', '0');
define('DNS_STATUS_DISABLED_VAL', 'Disabled');
define('DNS_STATUS_ENABLED_KEY', '1');
define('DNS_STATUS_ENABLED_VAL', 'Enabled');

define('MULTI_WAN_WIZARD_STATUS_0', '0');
define('MULTI_WAN_WIZARD_STATUS_1', '1');

define('DMZ_STATUS', 'dmzStatus');
define('DMZ_IP_ADDR', 'dmzIpAddr');

define('DMZ_STATUS_DISABLED_KEY', '0');
define('DMZ_STATUS_DISABLED_VAL', 'Disabled');
define('DMZ_STATUS_ENABLED_KEY', 'dmz_enabled');
define('DMZ_STATUS_ENABLED_VAL', 'Enabled');

define('QOS_SERVICE_STATUS_DISABLED_KEY', '0');
define('QOS_SERVICE_STATUS_DISABLED_VAL', 'Disabled');
define('QOS_SERVICE_STATUS_ENABLED_KEY', '1');
define('QOS_SERVICE_STATUS_ENABLED_VAL', 'Enabled');

define('CALCULATE_OVERHEAD_STATUS_DISABLED_KEY', '0');
define('CALCULATE_OVERHEAD_STATUS_DISABLED_VAL', 'Disabled');
define('CALCULATE_OVERHEAD_STATUS_ENABLED_KEY', '1');
define('CALCULATE_OVERHEAD_STATUS_ENABLED_VAL', 'Enabled');

define('WEB_FILTERING_STATUS_DISABLED_KEY', '');
define('WEB_FILTERING_STATUS_DISABLED_VAL', 'Disabled');
define('WEB_FILTERING_STATUS_ENABLED_KEY', 'enabled');
define('WEB_FILTERING_STATUS_ENABLED_VAL', 'Enabled');

define('WEB_FILTERING_OPTIONS', 'webFilteringOptions');
define('CHECK_BOX_1', 'check1');
define('CHECK_BOX_2', 'check2');
define('CHECK_BOX_3', 'check3');
define('CHECK_BOX_3_PRIMARY_DNS', 'check3PriDNS');
define('CHECK_BOX_3_SECONDARY_DNS', 'check3SecondaryDNS');

define('SERVICE_LEVEL_NORMAL_KEY', 'Normal');
define('SERVICE_LEVEL_NORMAL_VAL', 'Normal');
define('SERVICE_LEVEL_PRIORITY_KEY', 'Priority');
define('SERVICE_LEVEL_PRIORITY_VAL', 'Priority');
define('SERVICE_LEVEL_EXPRESS_KEY', 'Express');
define('SERVICE_LEVEL_EXPRESS_VAL', 'Express');
define('SERVICE_LEVEL_BULK_KEY', 'Bulk');
define('SERVICE_LEVEL_BULK_VAL', 'Bulk');

define('PROTOCAL_BOTH_KEY', 'tcpudp');
define('PROTOCAL_BOTH_VAL', 'Both');
define('PROTOCAL_ALL_KEY', 'all');
define('PROTOCAL_ALL_VAL', 'All');
define('PROTOCAL_TCP_KEY', 'tcp');
define('PROTOCAL_TCP_VAL', 'TCP');
define('PROTOCAL_UDP_KEY', 'udp');
define('PROTOCAL_UDP_VAL', 'UDP');

define('DNS_SERVICE_PROVIDER_NO_IP', 'no-ip.com');
define('DNS_SERVICE_PROVIDER_DYNDS', 'dyndns.org');
define('DNS_SERVICE_PROVIDER_FREEDNS', 'freedns.afraid.org');

define('IPV4_CLASS', 'ipv4Class');
define('IPV4_CLASS_C_KEY', 'c');
define('IPV4_CLASS_C_VAL', 'Class C');
define('IPV4_CLASS_B_KEY', 'b');
define('IPV4_CLASS_C', 'ipv4ClassC');
define('IPV4_CLASS_B_VAL', 'Class B');
define('IPV4_CLASS_OPTIONS', 'ipv4ClassOptions');

define('VLAN_PORT_ENABLED', 'vlanPortEnabled');
define('VLAN_PORT_STATUS_DISABLED', 'disabled');
define('VLAN_PORT_STATUS_ENABLED', 'enabled');
define('VLAN_PORT_TAGGING_OPTIONS', 'vlanPortTaggingOptions');
define('EGRESS_RULE_OPTIONS', 'egressRuleOptions');

define('CONNECTED_CLIENTS_ALL_KEY', 'all');
define('CONNECTED_CLIENTS_ALL_VAL', 'All');
define('CONNECTED_CLIENTS_DHCP_KEY', 'dhcp');
define('CONNECTED_CLIENTS_DHCP_VAL', 'DHCP');

define('DHCP_SERVER_ENABLED_KEY', '0');
define('DHCP_SERVER_ENABLED_VAL', 'DHCP Server Enabled');
define('DHCP_SERVER_DISABLED_KEY', '1');
define('DHCP_SERVER_DISABLED_VAL', 'DHCP Server Disabled');

define('DNS_STATUS', 'dnsStatus');
define('SERVICE_PROVIDER', 'serviceProvider');
define('DNS_HOST_NAME', 'dnsHostname');
define('DNS_USER_NAME', 'dnsUsername');
define('DNS_PASSWORD', 'dnsPassword');
define('DNS_INTERVAL', 'dnsInterval');
define('DNS_UPDATE_INTERVAL', 'dnsUpdateInterval');

define('ALL_ACTIVE_ROUTES_INFO' ,'allActiveRoutesInfo');
define('STATIC_ROUTES_INFO', 'staticRountsInfo');
define('ADD_INTERFACE_OPTIONS', 'addInterfaceOptions');
define('DESTINATION_IP', 'destinationIP');

define('QOS_SERVICE_STATUS_OPTIONS', 'qosServiceStatusOptions');
define('CALCULATE_OVERHEAD_OPTIONS', 'calculateOverheadOptions');
define('QOS_DOWNLOAD_SPEED', 'qosDownloadSpeed');
define('QOS_UPLOAD_SPEED', 'qosUploadSpeed');
define('SERVICE_LEVEL_OPTIONS', 'serviceLevelOptions');
define('PROTOCAL_OPTIONS', 'protocalOptions');
define('QOS_RULES_INFO', 'qosRulesInfo');

define('DHCP_SERVER_OPTIONS', 'dhcpServerOptions');
define('LAN_SUBNET_MASK_OPTIONS', 'lanSubnetMaskOptions');
define('LAN_IP_ADDR_END', 'lanIPAddrEnd');

define('CLASS_B_LAN_IP_ADDR_START', 'classBLanIPAddrStart');
define('CLASS_B_LAN_IP_ADDR_END', 'classBLanIPAddrEnd');
define('CLASS_B_LAN_SUBNET_MASK_OPTIONS', 'classBLanSubnetMaskOptions');

define('CLASS_C_BASE', 'classCBase');
define('CLASS_C_START', 'classCStart');
define('CLASS_C_IP_ADDR_NUM', 'classCIPAddrNum');
define('CLASS_C_LEASE_TIME', 'classCLeaseTime');
define('CLASS_C_END', 'classCEnd');
define('CLASS_B_START', 'classBStart');
define('CLASS_B_IP_ADDR_NUM', 'classBIPAddrNum');
define('CLASS_B_END', 'classBEnd');
define('CLASS_B_LEASE_TIME', 'classBLeaseTime');

define('DESTINATION_IP_DEFAULT', 'default');
define('SUBNET_MASK_DEFAULT', '0.0.0.0');
define('GATEWAY_DEFAULT', '0.0.0.0');
define('METRIC_DEFAULT', '0');

define('VLAN_STATUS_OPTIONS', 'vlanStatusOptions');
define('VLAN_STATUS', 'vlanStatus');

define('ALL_VLAN_INFO', 'allVlanInfo');
define('PVID_INFO', 'pvIdInfo');
define('VLAN_ID', 'vlanID');
define('VLAN_DESCRIPTION', 'vlanDescription');
define('MEMBERS', 'members');
define('MEMBER', 'member');
define('VLAN_ROUTING', 'vlanRouting');
define('VLAN_PORTS_INFO', 'vlanPortsInfo');

define('PRIMARY_DNS_208_67_222_222', '208.67.222.222');
define('PRIMARY_DNS_208_67_222_123', '208.67.222.123');
define('SECONDARY_DNS_208_67_220_220', '208.67.220.220');
define('SECONDARY_DNS_208_67_220_123', '208.67.220.123');

define('WEB_FILTERING_DHCP_OPTION_PREFIX_6', '6');

define('PPTPD_ENABLED_KEY', '1');
define('PPTPD_DISBLED_KEY', '0');
define('L2TP_ENABLED_KEY', '1');
define('L2TP_DISBLED_KEY', '0');
define('IPSEC_ENABLED_KEY', '1');
define('IPSEC_DISABLED_KEY', '0');

define('VPN_MODE_L2TP_KEY', 'l2tp_enabled');
define('VPN_MODE_L2TP_VAL', 'L2TP/IPSec');

define('VPN_AGGRESSIVE_MODE_FIELD', 'i_dont_care_about_security_and_use_aggressive_mode_psk = ');
define('VPN_MODE', 'vpnMode');
define('VPN_USER_INFO', 'vpnUserInfo');

define('PPTPD', 'pptpd');
define('IPSEC_IKE', 'IPsec IKE');
define('IPSEC_NAT_T', 'IPsec NAT-T');
define('XL2TPD', 'xl2tpd');
define('UDP', 'udp');

define('PPTP_L2TP_IP_ADDR_START_OCTET_4_DEFAULT', '20');
define('PPTP_L2TP_IP_ADDR_END_OCTET_4_DEFAULT', '30');
define('IPSEC_DEFAULT_LOCAL_IP', '192.168.0.1');
define('LOCAL_NETWORK_LAN', 'Local Network/LAN');

define('WAN_PORT_STATE', 'wanPortState');
define('WAN_PORT_INFO', 'wanPortInfo');
define('LAN_PORT1_STATE', 'lanPort1State');
define('LAN_PORT1_INFO', 'lanPort1Info');
define('LAN_PORT2_STATE', 'lanPort2State');
define('LAN_PORT2_INFO', 'lanPort2Info');
define('LAN_PORT3_STATE', 'lanPort3State');
define('LAN_PORT3_INFO', 'lanPort3Info');
define('LAN_PORT4_STATE', 'lanPort4State');
define('LAN_PORT4_INFO', 'lanPort4Info');

define('COLOR_BLACK', 'black');
define('COLOR_GREEN', 'green');
define('COLOR_YELLOW', 'yellow');
define('COLOR_BLUE', 'blue');

define('LINK_DOWN', 'link:down');
define('UP_SPEED', 'up speed:');
define('SPEED_1GBPS', '1000baseT');
define('SPEED_100MBPS', '100baseT');
define('SPEED_10MBPS', '10baseT');

define('IPV6_STATUS_OPTIONS', 'ipv6StatusOptions');
define('PPTP_PASSTHRU_OPTIONS', 'pptpPassthruOptions');
define('SERVER_ADDR', 'serverAddr');

define('PPTP_PASSTHRU_ENABLED_KEY' ,'1');
define('PPTP_PASSTHRU_ENABLED_VAL' ,'Enabled');
define('PPTP_PASSTHRU_DISABLED_KEY' ,'0');
define('PPTP_PASSTHRU_DISABLED_VAL' ,'Disabled');

define('PORT_FORWARD_YES', 'yes');
define('PORT_FORWARD_NO', 'no');

define('IPERF_STATUS_VAL', 'iperfStatusVal');
define('IPERF_STATUS', 'iperfStatus');
define('IPERF_HOURS_OPTIONS', 'iperfHoursOptions');
define('IPERF_MSG', 'iperfMessage');

define('PORT_1723', '1723');
define('DESTINATION_PORT_500','500');
define('DESTINATION_PORT_4500','4500');
define('DESTINATION_PORT_53','53');
define('PORT_67_68','67-68');

define('SELECT_SSID_KEY', 'select_ssid');
define('SELECT_SSID_VAL', 'Select SSID...');
define('CREATE_NEW_SSID_VAL', 'Create New SSID');

define('WAN_ACCELERATION_ENABLED_KEY' ,'1');
define('WAN_ACCELERATION_ENABLED_VAL' ,'Enabled');
define('WAN_ACCELERATION_DISABLED_KEY' ,'0');
define('WAN_ACCELERATION_DISABLED_VAL' ,'Disabled');

define('WAN_PING_ENABLED_KEY' ,'ACCEPT');
define('WAN_PING_ENABLED_VAL' ,'Enabled');
define('WAN_PING_DISABLED_KEY' ,'DROP');
define('WAN_PING_DISABLED_VAL' ,'Disabled');

define('SAVE_WAN_ACCELERATION', 'saveWanAccleration');
define('SAVE_WAN_PING', 'saveWanPing');
define('SAVE_IPV6_WAN', 'saveIpv6Wan');
define('SAVE_PPTP_PASSTHRU', 'savePptpPassthru');
define('SAVE_PORT_MONITORING', 'savePortMonitoring');
define('SAVE_WAN_DELAY', 'saveWanDelay');
define('SAVE_BLOCK_SELF_ASSIGNED_IP', 'saveBlockSelfAssignedIp');

define('IPV6' ,'ipv6');
define('IPV6_WAN_ENABLED_KEY' ,'1');
define('IPV6_WAN_ENABLED_VAL' ,'Enabled');
define('IPV6_WAN_DISABLED_KEY' ,'0');
define('IPV6_WAN_DISABLED_VAL' ,'Disabled');

define('VPN_MODE_OPTIONS', 'vpnModeOptions');
define('VPN_MODE_DISABLED_KEY', '0');
define('VPN_MODE_DISABLED_VAL', 'Disabled');
define('VPN_MODE_PPTP_KEY', 'pptp_enabled');
define('VPN_MODE_PPTP_VAL', 'PPTP');
define('VPN_MODE_IPSEC_KEY', 'ipsec_enabled');
define('VPN_MODE_IPSEC_VAL', 'IPSec');

define('VPN_AGGRESSIVE_MODE_DISABLED_KEY', '0');
define('VPN_AGGRESSIVE_MODE_DISABLED_VAL', 'Disabled');
define('VPN_AGGRESSIVE_MODE_ENABLED_KEY', '1');
define('VPN_AGGRESSIVE_MODE_ENABLED_VAL', 'Enabled');

define('WAN2' ,'2');
define('WAN3' ,'3');
define('WAN4' ,'4');
define('ETH0_408', '408');

define('VLAN_DESCRIPTION_0', '0');
define('DHCP_STATUS_0', '0');

define('MULTI_WAN_STATUS_0', '0');
define('MULTI_WAN_STATUS_ENABLED', 'enabled');

define('VLAN_NUM_1', '1');
define('ID', 'id');
define('VLAN_ID_1', '1');

define('VLAN_PORT_0', '0');
define('VLAN_PORT_1', '1');
define('VLAN_PORT_2', '2');
define('VLAN_PORT_3', '3');
define('VLAN_PORT_4', '4');

define('VLAN_PORT_TAGGING_KEY', 't');
define('VLAN_PORT_TAGGING_VAL', 'Tagged');
define('VLAN_PORT_NOT_TAGGING_KEY', 'no');
define('VLAN_PORT_NOT_TAGGING_VAL', 'Untagged');

define('VLAN_PORT_1T', '1t');
define('VLAN_PORT_2T', '2t');
define('VLAN_PORT_3T', '3t');
define('VLAN_PORT_4T', '4t');
define('VLAN_PORT_8T', '8t');

define('VLAN_1_DEFAULT_PORT_VLAUE', '1 2 3 4 8t');
define('VLAN_1_DEFAULT_NAME', 'Management');

define('PRESHARED_KEY', 'presharedKey');
define('IP_ADDR_START_BASE', 'ipAddrStartBase');
define('IP_ADDR_END_BASE', 'ipAddrEndBase');
define('PPTP_IP_ADDR_START_OCTET_4', 'pptpIpAddrStart4Octet');
define('PPTP_IP_ADDR_END_OCTET_4', 'pptpIpAddrEnd4Octet');
define('L2TP_IP_ADDR_START_OCTET_4', 'l2tpIpAddrStart4Octet');
define('L2TP_IP_ADDR_END_OCTET_4', 'l2tpIpAddrEnd4Octet');
define('IKE_AGGRESSIVE_MODE_OPTIONS', 'ikeAggressiveModeOptions');

define('DHCP_SERVER', 'dhcpServer');
define('DHCP_CLIENT_DISABLED_KEY','static');
define('DHCP_CLIENT_ENABLED_KEY','dhcp');
define('DHCP_CLIENT_DISABLED_VAL','Disabled');
define('DHCP_CLIENT_ENABLED_VAL','Enabled');

define('VLAN_DISABLED_KEY','0');
define('VLAN_DISABLED_VAL','Disabled');
define('VLAN_ENABLED_KEY','vlan_enabled');
define('VLAN_ENABLED_VAL','Enabled');

define('VLAN_VCFG_ENABLED_KEY', 'enabled');
define('VLAN_VCFG_DISABLE_KEY', '0');

define('VLAN_ROUTING_DISABLED_KEY','0');
define('VLAN_ROUTING_DISABLED_CODE','disabled');
define('VLAN_ROUTING_DISABLED_VAL','Disabled');
define('VLAN_ROUTING_ENABLED_KEY','enabled');
define('VLAN_ROUTING_ENABLED_VAL','Enabled');

define('MULTI_WAN_REPORT_SELECT_REPORT_KEY','select_report');
define('MULTI_WAN_REPORT_SELECT_REPORT_VAL','Select Report...');
define('MULTI_WAN_REPORT_FULL_REPORT_KEY','full');
define('MULTI_WAN_REPORT_FULL_REPORT_VAL','Full');
define('MULTI_WAN_REPORT_INTERFACE_REPORT_KEY','interface');
define('MULTI_WAN_REPORT_INTERFACE_REPORT_VAL','Interface');
define('MULTI_WAN_REPORT_POLICY_REPORT_KEY','policy');
define('MULTI_WAN_REPORT_POLICY_REPORT_VAL','Policies');
define('MULTI_WAN_REPORT_RULE_REPORT_KEY','rule');
define('MULTI_WAN_REPORT_RULE_REPORT_VAL','Rules');

define('SUBNET_MASK_128_0_0_0_VAL', '128.0.0.0');
define('SUBNET_MASK_128_0_0_0_CODE', '1');
define('SUBNET_MASK_192_0_0_0_VAL', '192.0.0.0');
define('SUBNET_MASK_192_0_0_0_CODE', '2');
define('SUBNET_MASK_224_0_0_0_VAL', '224.0.0.0');
define('SUBNET_MASK_224_0_0_0_CODE', '3');
define('SUBNET_MASK_240_0_0_0_VAL', '240.0.0.0');
define('SUBNET_MASK_240_0_0_0_CODE', '4');
define('SUBNET_MASK_248_0_0_0_VAL', '248.0.0.0');
define('SUBNET_MASK_248_0_0_0_CODE', '5');
define('SUBNET_MASK_252_0_0_0_VAL', '252.0.0.0');
define('SUBNET_MASK_252_0_0_0_CODE', '6');
define('SUBNET_MASK_254_0_0_0_VAL', '254.0.0.0');
define('SUBNET_MASK_254_0_0_0_CODE', '7');
define('SUBNET_MASK_255_0_0_0_VAL', '255.0.0.0');
define('SUBNET_MASK_255_0_0_0_CODE', '8');
define('SUBNET_MASK_255_128_0_0_VAL', '255.128.0.0');
define('SUBNET_MASK_255_128_0_0_CODE', '9');
define('SUBNET_MASK_255_192_0_0_VAL', '255.192.0.0');
define('SUBNET_MASK_255_192_0_0_CODE', '10');
define('SUBNET_MASK_255_224_0_0_VAL', '255.224.0.0');
define('SUBNET_MASK_255_224_0_0_CODE', '11');
define('SUBNET_MASK_255_240_0_0_VAL', '255.240.0.0');
define('SUBNET_MASK_255_240_0_0_CODE', '12');
define('SUBNET_MASK_255_248_0_0_VAL', '255.248.0.0');
define('SUBNET_MASK_255_248_0_0_CODE', '13');
define('SUBNET_MASK_255_252_0_0_VAL', '255.252.0.0');
define('SUBNET_MASK_255_252_0_0_CODE', '14');
define('SUBNET_MASK_255_254_0_0_VAL', '255.254.0.0');
define('SUBNET_MASK_255_254_0_0_CODE', '15');
define('SUBNET_MASK_255_255_0_0_VAL', '255.255.0.0');
define('SUBNET_MASK_255_255_0_0_CODE', '16');
define('SUBNET_MASK_255_255_128_0_VAL', '255.255.128.0');
define('SUBNET_MASK_255_255_128_0_CODE', '17');
define('SUBNET_MASK_255_255_192_0_VAL', '255.255.192.0');
define('SUBNET_MASK_255_255_192_0_CODE', '18');
define('SUBNET_MASK_255_255_224_0_VAL', '255.255.224.0');
define('SUBNET_MASK_255_255_224_0_CODE', '19');
define('SUBNET_MASK_255_255_240_0_VAL', '255.255.240.0');
define('SUBNET_MASK_255_255_240_0_CODE', '20');
define('SUBNET_MASK_255_255_248_0_VAL', '255.255.248.0');
define('SUBNET_MASK_255_255_248_0_CODE', '21');
define('SUBNET_MASK_255_255_252_0_VAL', '255.255.252.0');
define('SUBNET_MASK_255_255_252_0_CODE', '22');
define('SUBNET_MASK_255_255_254_0_VAL', '255.255.254.0');
define('SUBNET_MASK_255_255_254_0_CODE', '23');
define('SUBNET_MASK_255_255_255_0_VAL', '255.255.255.0');
define('SUBNET_MASK_255_255_255_0_CODE', '24');
define('SUBNET_MASK_255_255_255_128_VAL', '255.255.255.128');
define('SUBNET_MASK_255_255_255_128_CODE', '25');
define('SUBNET_MASK_255_255_255_192_VAL', '255.255.255.192');
define('SUBNET_MASK_255_255_255_192_CODE', '26');
define('SUBNET_MASK_255_255_255_224_VAL', '255.255.255.224');
define('SUBNET_MASK_255_255_255_224_CODE', '27');
define('SUBNET_MASK_255_255_255_240_VAL', '255.255.255.240');
define('SUBNET_MASK_255_255_255_240_CODE', '28');
define('SUBNET_MASK_255_255_255_248_VAL', '255.255.255.248');
define('SUBNET_MASK_255_255_255_248_CODE', '29');
define('SUBNET_MASK_255_255_255_252_VAL', '255.255.255.252');
define('SUBNET_MASK_255_255_255_252_CODE', '30');
define('SUBNET_MASK_255_255_255_254_VAL', '255.255.255.254');
define('SUBNET_MASK_255_255_255_254_CODE', '31');
define('SUBNET_MASK_255_255_255_255_VAL', '255.255.255.255');
define('SUBNET_MASK_255_255_255_255_CODE', '32');

define('SUBNET_MASK_255_255_0_0_VAL_FULL', '255.255.0.0        (65534)');
define('SUBNET_MASK_255_255_128_0_VAL_FULL', '255.255.128.0    (32766)');
define('SUBNET_MASK_255_255_192_0_VAL_FULL', '255.255.192.0    (16382)');
define('SUBNET_MASK_255_255_224_0_VAL_FULL', '255.255.224.0    (8190)');
define('SUBNET_MASK_255_255_240_0_VAL_FULL', '255.255.240.0    (4094)');
define('SUBNET_MASK_255_255_248_0_VAL_FULL', '255.255.248.0    (2046)');
define('SUBNET_MASK_255_255_252_0_VAL_FULL', '255.255.252.0    (1022)');
define('SUBNET_MASK_255_255_254_0_VAL_FULL', '255.255.254.0    (510)');
define('SUBNET_MASK_255_255_255_0_VAL_FULL', '255.255.255.0    (254)');

define('SUBNET_MASK_CLASS_C_OCTET_3_0', '0');
define('SUBNET_MASK_CLASS_C_OCTET_4_254', '254');
define('SUBNET_MASK_CLASS_C_OCTET_3_255', '255');
define('SUBNET_MASK_CLASS_B_OCTET_4_100', '100');
define('SUBNET_MASK_CLASS_B_OCTET_4_200', '200');

define('PRAGMA_PUBLIC', 'Pragma: public');
define('EXPIRES_0', 'Expires: 0');
define('CACHE_CONTROL_CHECK', 'Cache-Control: must-revalidate, post-check=0, pre-check=0');
define('CACHE_CONTROL_PRIVATE', 'Cache-Control: private');
define('CONTENT_TYPE_FORCE_DOWNLOAD', 'Content-Type: application/force-download');
define('CONTENT_TYPE_OCTET_STREAM', 'Content-Type: application/octet-stream');
define('CONTENT_TYPE_DOWNLOAD', 'Content-Type: application/download');
define('CONTENT_TYPE_TEXT_PLAIN', 'Content-Type: text/plain');
define('CONTENT_DESCRIPTION_FILE_TRANSFER', 'Content-Description: File Transfer');
define('CONTENT_DISPOSITION_ATTACHMENT', 'Content-Disposition: attachment; filename="');
define('CONTENT_TRANSFER_ENCODING', 'Content-Transfer-Encoding: binary');
define('CONTENT_LENGTH', 'Content-Length: ');

define('RESTORE_FILE_CODE_0', '0');
define('RESTORE_FILE_CODE_1', '1');
define('RESTORE_FILE_CODE_2', '2');
define('RESTORE_FILE_CODE_3', '3');
define('RESTORE_FILE_CODE_1_MSG', 'Configuration file does not appear to be a luxul config file.');
define('RESTORE_FILE_CODE_2_MSG', 'Configuration file is for a different model.');
define('RESTORE_FILE_CODE_3_MSG', 'Configuration file is for a different FW version.');

define('FILE_EXCEED_PHP_SIZE_MSG', 'The uploaded file exceeds the upload_max_filesize directive in php.ini');
define('FILE_EXCEED_HTML_SIZE_MSG', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form');
define('FILE_PARTIALLY_LOAD_MSG', 'The uploaded file was only partially uploaded');
define('NO_FILE_UPLOAD_MSG', 'No file was uploaded');
define('FILE_MISS_TMP_FOLDER_MSG', 'Missing a temporary folder');
define('FAIL_TO_WRITE_FILE_MSG', 'Failed to write file to disk');
define('FILE_UPLOAD_STOP_MSG', 'File upload stopped by extension');
define('UNKNOWN_UPLOAD_ERROR_MSG', 'Unknown upload error');
define('FIRMWARE_UPDATE_WRONG_MODEL_MSG', 'Firmware update failed: The firmware file is for a different model. Please download the firmware for the ');
define('FIRMWARE_UPDATE_TRY_AGAIN_MSG', ' and try again.');
define('FIRMWARE_FILE_CANNOT_PROCESS_MSG', 'Could not process this file');
define('FIRMWARE_FILE_CORRUPTED_MSG', 'Firmware update failed: The firmware file is corrupted. Please download the firmware and try again.');
define('FIRMWARE_UPDATE_SUCCESS_MSG', 'Firmware has been upgraded successfully');
define('RESTORE_CONFIGURATION_SUCCESS_MSG', 'Configuration has been updated successfully');
define('VIEW_FILE_NOT_EXIST_MESSAGE', 'View file does not exist.');
define('UNABLE_TO_OPEN_FILE_MSG', 'Unable to open file!');

define('IPERF_RUN_FOR_MSG', 'Iperf server will now run for ');
define('IPERF_STOPPED_MSG', 'Iperf server has been stopped');
define('IPERF_NOT_RUNNING', 'Not Runnning');
define('IPERF_RUNNING', 'Running');

define('MAC_ADDR_REGEX', '/([a-fA-F0-9]{2}[:|\-]?){6}/');
define('DATA_RECEIVED_REGEX', '/.*RX bytes:[0-9]* (\([^\)]*).*/');
define('DATA_TRANSMITTED_REGEX', '/.*TX bytes:[0-9]* (\([^\)]*).*/');
define('REMOVE_NEW_LINE_REGEX', '/\r|\n/');
define('MD5_REGEX', '/\s+/');

define('IPV4_ADDRESS', '"ipv4-address":');
define('ADDRESS', 'address: ');
define('NEXT_HOP', '"nexthop":');
define('DNS_SERVER', '"dns-server":');
define('DEFAULT_PRIMARY_DNS','DNS Assigned By ISP');
define('EQUAL_INTERFACE', '=interface');
define('SELECT_OPTIONS_SELECTED', "selected='selected' ");
define('CHECKBOX_CHECKED', 'checked');
define('CLIENT_RATE_MSG', 'rate of last tx pkt: ');
define('IFCONFIG', 'ifconfig ');
define('AUTHE_STA_LIST', 'authe_sta_list ');
define('NETWORK_ETH0', 'network.eth0_');
define('IPSEC_SECRECTS_PRESHARED_KEY_FIELD', '%any : PSK ');
define('IPSEC_SECRECTS_XAUTH_FIELD', 'XAUTH ');
define('LOCAL_IP', 'local ip = ');
define('IP_RANGE', 'ip range = ');

define('FALSE',false);
define('TRUE',true);
define('PROGRESS_TRUE', true);
define('PROGRESS_FALSE', false);
define('EMPTY_STRING',"");
define('SPACE', " ");
define('COLON', ':');
define('QUESTION_MARK', '?');
define('SEMI_COLON', ';');
define('DOUBLE_QUOTE', '"');
define('SINGLE_QUOTE', "'");
define('URL_POST_SEPERATOR', "&");
define('UNDERSCORE',"_");
define('HYPHEN', '-');
define('COMMA', ',');
define('BACKTICK', '`');
define('PIPE', '|');
define('EQUAL_SIGN', '=');
define('PERCENTAGE', '%');
define('ONLINE', 'online');
define('OFFLINE', 'offline');
define('CPU_USAGE_100', '100%');
define('INDEX_BRACKET_LEFT', '[');
define('INDEX_BRACKET_RIGHT', ']');
define('PARENTHESES_LEFT', '(');
define('PARENTHESES_RIGHT', ')');
define('UCI_FIELD_DOT', '.');
define('UCI_FIELD_AT', '@');
define('UCI_FIELD_INDEX_LAST', '[-1]');
define('INDEX_0', '0');
define('INDEX_1', '1');
define('INDEX_2', '2');
define('INDEX_3', '3');
define('INDEX_4', '4');

define('KIB', 'KiB');
define('KB_UPPER_CASE', 'KB');
define('KB_LOWER_CASE', ' kB');
define('MIB', 'MiB');
define('MB', 'MB');
define('GIB', 'GiB');
define('GB', 'GB');
define('KBPS', ' kbps');

define('HOUR_1_KEY', '1');
define('HOUR_1_VAL', '1 hour');
define('HOUR_2_KEY', '2');
define('HOUR_2_VAL', '2 hours');
define('HOUR_3_KEY', '3');
define('HOUR_3_VAL', '3 hours');
define('DAY_SHORT_NAME', 'd');
define('DAYS', 'days');
define('MINUTE_SHORT_NAME', 'm');
define('MINUTES', 'min');
define('HOURS', 'hours');
define('HOUR', ' hour');
define('HOUR_SHORT_NAME', 'h');
define('DATE_FORMAT', '%2d');
define('DATE_FORMAT_FULL', 'Y-m-d H:i:s');
define('DHCP_LEASE_TIME_HOUR_UNIT', 'h');

define('SELECT_TIME_ZONE', '--Select--');
define('TIMEZONE_KWAJALEIN_KEY', 'MHT-12');
define('TIMEZONE_KWAJALEIN_VAL', 'UTC-12:00 Kwajalein');
define('TIMEZONE_MIDWAY_ISLAND_KEY', 'SST11');
define('TIMEZONE_MIDWAY_ISLAND_VAL', 'UTC-11:00 Midway Island');
define('TIMEZONE_HAWAII_KEY', 'HST10');
define('TIMEZONE_HAWAII_VAL', 'UTC-10:00 Hawaii');
define('TIMEZONE_ALASKA_KEY', 'AKST9AKDT,M3.2.0,M11.1.0');
define('TIMEZONE_ALASKA_VAL', 'UTC-9:00 Alaska');
define('TIMEZONE_PACIFIC_KEY', 'PST8');
define('TIMEZONE_PACIFIC_VAL', 'UTC-8:00 Pacific');
define('TIMEZONE_ARIZONA_KEY', 'MST7');
define('TIMEZONE_ARIZONA_VAL', 'UTC-7:00 Arizona');
define('TIMEZONE_MOUNTAIN_KEY', 'MST7MDT,M3.2.0,M11.1.0');
define('TIMEZONE_MOUNTAIN_VAL', 'UTC-7:00 Mountain');
define('TIMEZONE_MEXICO_KEY', 'CST6CDT,M4.1.0,M10.5.0');
define('TIMEZONE_MEXICO_VAL', 'UTC-6:00 Mexico');
define('TIMEZONE_CENTRAL_KEY', 'CST6CDT,M3.2.0,M11.1.0');
define('TIMEZONE_CENTRAL_VAL', 'UTC-6:00 Central');
define('TIMEZONE_PANAMA_KEY', 'EST5');
define('TIMEZONE_PANAMA_VAL', 'UTC-5:00 Panama, Jamaica');
define('TIMEZONE_EASTERN_KEY', 'EST5EDT,M3.2.0,M11.1.0');
define('TIMEZONE_EASTERN_VAL', 'UTC-5:00 Eastern');
define('TIMEZONE_PUERTO_RICO_KEY', 'AST4');
define('TIMEZONE_PUERTO_RICO_VAL', 'UTC-4:00 Puerto Rico');
define('TIMEZONE_HALIFAX_KEY', 'AST4ADT,M3.2.0,M11.1.0');
define('TIMEZONE_HALIFAX_VAL', 'UTC-4:00 Halifax');
define('TIMEZONE_NEWFOUNDLAND_KEY', 'NST3:30NDT,M3.2.0/0:01,M11.1.0/0:01');
define('TIMEZONE_NEWFOUNDLAND_VAL', 'UTC-3:30 Newfoundland');
define('TIMEZONE_BRAZIL_EAST_KEY', 'BRT3BRST,M10.3.0/0,M2.3.0/0');
define('TIMEZONE_BRAZIL_EAST_VAL', 'UTC-3:00 Brazil East');
define('TIMEZONE_ARGENTINA_KEY', 'ART3');
define('TIMEZONE_ARGENTINA_VAL', 'UTC-3:00 Argentina');
define('TIMEZONE_SOUTH_GEORGIA_KEY', 'GST2');
define('TIMEZONE_SOUTH_GEORGIA_VAL', 'UTC-2:00 South Georgia');
define('TIMEZONE_AZORES_KEY', 'AZOT1AZOST,M3.5.0/0,M10.5.0/1');
define('TIMEZONE_AZORES_VAL', 'UTC-1:00 Azores');
define('TIMEZONE_UK_KEY', 'GMT0BST,M3.5.0/1,M10.5.0');
define('TIMEZONE_UK_VAL', 'UTC+0:00 UK');
define('TIMEZONE_FRANCE_GERMANY_POLAND_KEY', 'CET-1CEST,M3.5.0,M10.5.0/3');
define('TIMEZONE_FRANCE_GERMANY_POLAND_VAL', 'UTC+1:00 France, Germany, Poland');
define('TIMEZONE_GREECE_FINLAND_UKRAINE_KEY', 'EET-2EEST,M3.5.0/3,M10.5.0/4');
define('TIMEZONE_GREECE_FINLAND_UKRAINE_VAL', 'UTC+2:00 Greece, Finland, Ukraine');
define('TIMEZONE_SOUTH_AFRICA_KEY', 'SAST-2');
define('TIMEZONE_SOUTH_AFRICA_VAL', 'UTC+2:00 South Africa');
define('TIMEZONE_IRAQ_JORDAN_KUWAIT_KEY', 'AST-3');
define('TIMEZONE_IRAQ_JORDAN_KUWAIT_VAL', 'UTC+3:00 Iraq, Jordan, Kuwait');
define('TIMEZONE_MOSCOW_KEY', 'MSK-3');
define('TIMEZONE_MOSCOW_VAL', 'UTC+3:00 Moscow');
define('TIMEZONE_DUBAI_KEY', 'GST-4');
define('TIMEZONE_DUBAI_VAL', 'UTC+4:00 Dubai');
define('TIMEZONE_PAKISTAN_KEY', 'PKT-5');
define('TIMEZONE_PAKISTAN_VAL', 'UTC+5:00 Pakistan');
define('TIMEZONE_INDIA_KEY', 'IST-5:30');
define('TIMEZONE_INDIA_VAL', 'UTC+5:30 India');
define('TIMEZONE_BANGLADESH_KEY', 'BDT-6');
define('TIMEZONE_BANGLADESH_VAL', 'UTC+6:00 Russia, Bangladesh');
define('TIMEZONE_RUSSIA_THAILAND_KEY', 'ICT-7');
define('TIMEZONE_RUSSIA_THAILAND_VAL', 'UTC+7:00 Russia, Thailand');
define('TIMEZONE_CHINA_HK_TAIWAN_KEY', 'HKT-8');
define('TIMEZONE_CHINA_HK_TAIWAN_VAL', 'UTC+8:00 China, Hong Kong, Taiwan');
define('TIMEZONE_JAPAN_KOREA_KEY', 'JST-9');
define('TIMEZONE_JAPAN_KOREA_VAL', 'UTC+9:00 Japan, Korea');
define('TIMEZONE_AUSTRALIA_KEY', 'CST-9:30');
define('TIMEZONE_AUSTRALIA_VAL', 'UTC+9:30 Australia');
define('TIMEZONE_AUSTRALIA_SYDNEY_KEY', 'EST-10EST,M10.1.0,M4.1.0/3');
define('TIMEZONE_AUSTRALIA_SYDNEY_VAL', 'UTC+10:00 Australia, Sydney');
define('TIMEZONE_NEW_ZEALAND_KEY', 'NZST-12NZDT,M9.5.0,M4.1.0/3');
define('TIMEZONE_NEW_ZEALAND_VAL', 'UTC+12:00 New Zealand');
