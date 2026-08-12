function helpMessage(title, message) {
    var helpMessage = $("div.help-message").attr('id');
    $('#' + helpMessage).find("h2").replaceWith('<h2>' + title + '</h2>');
    $('#' + helpMessage).find("p").replaceWith('<p>' + message + '</p>');
}

function connectionHelpMessage() {
    var title = 'Connection Type';
    var message = 'Select the type of ISP connection being used for the network.' + '<br/><br/>' +
        'DHCP - The most common method for connecting to an ISP. If the ISP gives the router an IP address from their DHCP server, use this option.' + '<br/><br/>' +
        'PPPoE - Many DSL-based ISPs use PPPoE (Point-to-Point Protocol over Ethernet) to establish Internet connections.' + '<br/><br/>' +
        'Static IP - If the ISP has assigned a static IP address to this account, select this option.';
    helpMessage(title, message);
}

function customMacHelpMessage() {
    var title = 'Custom MAC Address';
    var message = 'Change the WAN MAC address for the router. If your ISP\'s connection is registered to another device, use this to mimic the MAC address of that device.';
    helpMessage(title, message);
}

function customMtuHelpMessage() {
    var title = 'Custom MTU';
    var message = 'Adjusts the Maximum Transmission Unit size according to the values provided by your ISP. For most networks the default value of 1500 is recommended.';
    helpMessage(title, message);
}

function userHelpMessage() {
    var title = 'User Name';
    var message = 'Enter the user name supplied by the ISP';
    helpMessage(title, message);
}

function passwordHelpMessage() {
    var title = 'Password';
    var message = 'Enter the password supplied by the ISP';
    helpMessage(title, message);
}

function serviceNameHelpMessage() {
    var title = 'Service Name';
    var message = 'PPPOE Service Name may be required by some ISPs. Only fill in the field a service name is provided by your ISP.' +
        'If service name is not provided the router will connect to the first one that is discovered.';
    helpMessage(title, message);
}

function failedPingsHelpMessage() {
    var title = 'Max Failed Pings';
    var message = 'The maximum number of times the system will ping the network unsuccessfully before a reconnection attempt is made.';
    helpMessage(title, message);
}

function pingIntervalHelpMessage() {
    var title = 'Ping Interval';
    var message = 'This is how often (time in seconds) they system will ping the ISP.';
    helpMessage(title, message);
}

function staticIpHelpMessage() {
    var title = 'Static IP';
    var message = 'Enter the static IP address for the router supplied by the ISP.';
    helpMessage(title, message);
}

function netmaskHelpMessage() {
    var title = 'Netmask';
    var message = 'Enter the netmask supplied by the ISP.';
    helpMessage(title, message);
}

function ipHelpMessage() {
    var title = 'LAN IP Address';
    var message = 'This is the Router IP address for the local area network. ' +
        'The default IP address is 192.168.0.1 In most cases, the default values will work. Change this only if you plan to use a different address scheme for the LAN.';
    helpMessage(title, message);
}

function subnetHelpMessage() {
    var title = 'LAN Subnet Mask';
    var message = 'This shows the Subnet Mask for the local area network. The default is 255.255.255.0, which is the recommended Subnet Mask.';
    helpMessage(title, message);
}

function gwHelpMessage() {
    var title = 'Gateway';
    var message = 'Enter the gateway supplied by the ISP.';
    helpMessage(title, message);
}

function priDNSHelpMessage() {
    var title = 'Primary DNS';
    var message = 'Your ISP will provide you with at least one IP address as the primary DNS. You may leave this field blank.';
    helpMessage(title, message);
}

function secondaryDNSHelpMessage() {
    var title = 'Secondary DNS';
    var message = 'The Secondary DNS entry is optional. If you have an alternate DNS, enter it here.';
    helpMessage(title, message);
}

function leaseHelpMessage() {
    win = window.open("", "popWin", "width=400, height=600, left=10, screenX=10, top=10, screenY=10,scrollbars=yes");
    if (win.document.getElementById("help-message") == null) {
        win.document.write("<link rel='stylesheet' type='text/css' href='../../public/css/styles.css'>" +
            "<body><div class='HelpPage'>" + "<div class='help-message' id='help-message'>" +
            "<h2>Static Leases</h2>" +
            "<p>Use this screen to reserve an IP address for a specific device. " +
            "Anytime the device is on the network it will be automatically assigned the specified IP address. <br/><br/>" +
            "There are two methods of creating Static Leases. " +
            "In the Discovered Clients page you can put a check mark by each device for which you want to create a Static Lease, then click the Add button. " +
            "Select All adds check marks to every item. Unselect All removes all check marks. <br/><br/>" +
            "The Add Lease Table allows you to create a Static Lease for the device not shown in the Discovered Clients table. " +
            "Enter a Description (32 characters maximum) for the device - this is a common name you use for the device (i.e. Camera1). " +
            "Do not use spaces or special characters in host name. A - (dash) or _ (underscore) is allowed. Next, enter the IP address you want to assign to this device. " +
            "This IP address can be in the DHCP pool or outside the DHCP pool. Enter the MAC address of the device. Press the ADD button to create the Static Lease. " +
            "The Cancel button clears the row without saving the change. <br/><br/>" +
            "The Assigned Leases shows all Static Leases that have been created. Here you can modify or delete Static Leases. " +
            "Highlight the row you want to modify or delete and press the appropriate button. If you are modifying the row, click on the Save button to save your changes. " +
            "Cancel reverts the row to the previous state. The Delete button removes the row. <br/><br/>" +
            "The Apply button updates the saved information. The Refresh button updates the tables. The Reboot button is provided for user convenience. <br/><br/>" +
            "If the device for which you're creating the static lease is already on the network, " +
            "you may have to disconnect and reconnect it for the new lease to become active. <br/><br/>" +
            "NOTE: The hostname may be provided by the client and is shown for informational purposes only. " +
            "</p>" +
            "<div class=spacer></div> </div> </div></body>");
    }
}

function routesHelpMessage() {
    win = window.open("", "popWin", "width=400, height=600, left=10, screenX=10, top=10, screenY=10,scrollbars=yes");
    if (win.document.getElementById("help-message") == null) {
        win.document.write("<link rel='stylesheet' type='text/css' href='../../public/css/styles.css'>" +
            "<body><div class='HelpPage'>" + "<div class='help-message' id='help-message'>" +
            "<h2>Routing</h2>" +
            "<p>Static Routing provides additional options for choosing the paths network traffic can route through.<br/><br/>" +
            "The Active Routes table shows the existing routes. Many of these routes are automatically created when the router is setup.<br/><br/>" +
            "The Add Static Routes section is where routes can be manually created. The Description is optional and can be up to 32 characters in length. " +
            "Do not use spaces or special characters in host name. A - (dash) or _ (underscore) is allowed. " +
            "The Interface drop-down menu specifies the logical interface name of the parent interface this route belongs to. It is required and defaults to LAN. " +
            "The Destination IP is the network address of the device to be routed to. Netmask is the route netmask. " +
            "If omitted, 255.255.255.255 is assumed which makes the destination device a host. Gateway is the network gateway. " +
            "If omitted, the gateway from the parent interface is used. If set to 0.0.0.0 no gateway will be specified for the route. " +
            "Metric specifies the route metric to use. Values can be from 0 to 254. Add saves the information and adds it to the User Added Routes table. Cancel clears the fields.<br/><br/>" +
            "The Static Routes table shows routes that have been manually created. You can edit or delete items in this table. Edit allows editing of a single row. " +
            "Choosing Edit enables the Save and Cancel buttons. Save updates the row with the changes made. Cancel reverts the changes to their previous values. Delete removes the row.<br/><br/>" +
            "The Apply button writes the changes and updates the Routing table. The Refresh button updates the Discovered Routes table and the Static Routes table. " +
            "The Reboot button restarts the router and is included for convenience.</p>" +
            "<div class=spacer></div> </div> </div></body>");
    }
}

function portForwardHelpMessage() {
    win = window.open("", "popWin", "width=400, height=600, left=10, screenX=10, top=10, screenY=10,scrollbars=yes");
    if (win.document.getElementById("help-message") == null) {
        win.document.write("<link rel='stylesheet' type='text/css' href='../../public/css/styles.css'>" +
            "<body><div class='HelpPage'>" + "<div class='help-message' id='help-message'>" +
            "<h2>Port Forwarding</h2>" +
            "<p>Allows access to a device on the local network from the Internet. Opens the specified firewall ports and forwards any incoming traffic on only those ports to the specified device.<br/><br/>" +
            "Note: WAN Redirect Port Forwarding is incompatible with WAN Acceleration.  If you wish to use WAN Redirect Port Forwarding you must disable WAN Acceleration in the Advanced section under Administration..<br/><br/>" +
            "The Port Forwarding table is where specific port forwarding rules can be manually created. " +
            "The Application field can be up to 32 characters in length and is optional. " +
            "Do not use spaces or special characters in the application name. A - (dash) or _ (underscore) is allowed. " +
            "The WAN port is a number from 1 to 65535 and accepts acscending ranges, ie, 3000-4000. The LAN IP is the IP address of a machine local to the router. " +
            "The LAN port is a number from 1 to 65535 and accepts ascending ranges, ie, 3000-4000. The LAN Port defaults to the same value as the WAN Port. " +
            "The WAN Port, LAN IP Address and LAN Port are required. Clicking on the Add button creates that rule in the Forwarded Ports table.<br/><br/>" +
            "The Forwarded Ports table shows Port Forward rules that have been manually created. " +
            "You can edit or delete items in this table. Edit allows editing of a single row. Choosing Edit enables the Save and Cancel buttons. " +
            "Save updates the row with the changes made. Cancel reverts the changes to their previous values. Delete removes the row.<br/><br/>" +
            "The Apply button writes the changes and updates the Port Forwarding table. " +
            "The Refresh button updates the Port Forwarding table. The Reboot button restarts the router and is included for convenience.</p>" +
            "<div class=spacer></div> </div> </div></body>");
    }
}

function wanAcceleratedHelpMessage() {
    var title = 'WAN Acceleration Status';
    var message = 'Disable WAN Acceleration if you are experiencing WAN connectivity or throughput issues. ' +
        'Modem or ISP incompatibilities with WAN acceleration may be causing the degraded WAN performance.<br/><br/>' +
        'Note: This feature is incompatible with QoS, Multi-WAN, Router Limits and WAN Redirect. ' +
        'WAN Acceleration must be disabled for those features to function.';
    helpMessage(title, message);
}

function wanPingHelpMessage() {
    var title = 'WAN Ping Status';
    var message = 'WAN Ping determines whether the WAN interface(s) response to pings. ' +
        'Enabled causes the WAN interface(s) to respond to pings. Disabled causes the WAN interface(s) to drop pings.';
    helpMessage(title, message);
}

function ipv6HelpMessage() {
    var title = 'IPv6 Status';
    var message = 'Sets the WAN interface(s) response to IPv6 packets. ' +
        'Disable IPv6 if you are experiencing WAN connectivity or throughput issues or your ISP requests it. ' +
        'Modem or ISP incompatibilities with IPv6 may cause degraded WAN performance.';
    helpMessage(title, message);
}

function pptpPassthruHelpMessage() {
    var title = 'PPTP Passthru Status';
    var message = 'PPTP Passthru when Enabled allows PPTP authentication and traffic requests to be forwarded to a PPTP server located on the local area network. ' +
        'When PPTP Passthru is Disabled, PPTP traffic is handled directly by the ABR/XBR-4400.';
    helpMessage(title, message);
}

function pptpServerAddrHelpMessage() {
    var title = 'PPTP Server Address';
    var message = '';
    helpMessage(title, message);
}

function portMonitoringHelpMessage() {
    var title = 'Port Monitoring';
    var message = 'This feature enables monitoring for disconnection events. Enabling this feature adds additional capabilities to detect and correct a disconnect/connect event.';
    helpMessage(title, message);
}

function wanDelayHelpMessage() {
    var title = 'Wan Delay';
    var message = 'This feature reinitializes the WAN port after the number of seconds entered. This may be necessary if the modem is slow to boot or to provide a valid IP address. ' +
        'With a value of 0 (zero) there is no delay for the WAN port. The maximum allowed value is 99 seconds. ' +
        'A value of 60 is a suitable place to start. Any changes to this value will take affect on the next boot. ' +
        'This feature has no effect on the operation of the LAN.';
    helpMessage(title, message);
}

function blockSelfAssignedIpHelpMessage() {
    var title = 'Block Self Assigned IP';
    var message = ' Enabled: Blocks Self Assigned IP addresses (169.254.0.0/16) from the router. Disabled: Allows Self Assigned IP addresses (169.254.0.0/16) to be processed by the router.' +
        'Self Assigned addresses (169.254.0.0/16) are not routeable and will be dropped at the router if enabled. The default and recommended selection is to Block Self-assigned addresses.';
    helpMessage(title, message);
}

function qosServiceHelpMessage() {
    var title = 'QoS';
    var message = 'Use this to enable or disable the QoS Service.' + '<br/><br/>'+
        'The QoS - Quality of Service feature allow you to prioritize one type of network traffic over another. ' +
        'This is typically used to ensure applications (i.e. voice over IP) get priority on the network.';
    helpMessage(title, message);
}

function overheadHelpMessage() {
    var title = 'Calculate Overhead';
    var message = 'If enabled, the QoS service will attempt to calculate and reserve some overhead bandwidth to account for fluctuating Internet speeds. This helps ensure the QoS service doesn\'t overrun the actual bandwidth available.';
    helpMessage(title, message);
}

function downloadSpeedHelpMessage() {
    var title = 'Download Speed';
    var message = 'Set the Internet download speed in Mbps (Megabits per Second) as specified by your ISP.';
    helpMessage(title, message);
}

function uploadSpeedHelpMessage() {
    var title = 'Upload Speed';
    var message = 'Set the Internet uploead speed in Mbps (Megabits per Second) as specified by your ISP.';
    helpMessage(title, message);
}

function qosRulesHelpMessage() {
    var title = 'QOS Rules';
    var message = '<span style="font-size: 15px;font-weight: bold">Service Level</span>' + '<br/><br />' +
        'Select the priority level of service you want to assign to the rule. Priority levels from lowest to highest priority are Bulk, Normal, Express, and Priority. ' +
        'Assign low priority traffic like guest networks to Bulk. Normal is for most standard traffic. Express is best for low latency traffic with larger packet sizes like VoIP and streaming media. ' +
        'Priority is best for traffic with small packet sizes that require immediate service like DNS and SSH.' + '<br/><br />' +
        '<span style="font-size: 15px;font-weight: bold">Source Host</span>' + '<br/><br />' +
        'Specify the source host IP address (i.e. 192.168.0.10) of the traffic you want to target. You can also use CIDR notation to specify a subnet or VLAN. ' +
        'For Example, if VLAN2 was using the 192.168.2.0 network with a subnet mask of 255.255.255.0 you would enter 192.168.2.0/24.' + '<br/><br />' +
        '<span style="font-size: 15px;font-weight: bold">Protocol</span>' + '<br/><br />' +
        'To specify a protocol select one from the drop-down menu.' + '<br/><br />' +
        '<span style="font-size: 15px;font-weight: bold">Ports</span>' + '<br/><br />' +
        'To specify a port enter the port number in the field. You can select multiple ports with the same rule by simply entering each port separated by a comma (i.e. 21,80,110).';
    helpMessage(title, message);
}

function openDNSHomeHelpMessage() {
    var title = 'OpenDNS Home';
    var message = ' Customizeable filtering and security using the OpenDNS Home or Home VIP service <br/> Click on the link for more information: www.opendns.com';
    helpMessage(title, message);
}

function openDNSFamilyHelpMessage() {
    var title = 'OpenDNS Family';
    var message = 'Customizeable filtering and security using the OpenDNS Family service <br/> Click on the link for more information: www.opendns.com';
    helpMessage(title, message);
}

function alternateDNSHelpMessage() {
    var title = 'Alternate DNS';
    var message = 'Use this option if you would like to use an alternative DNS filtering service. Enter the DNS addresses provided by the preferred service.';
    helpMessage(title, message);
}

function vpnModeHelpMessage() {
    var title = 'VPN Server';
    var message = '<span style="font-weight: bolder; font-size: 16px">Only one type of VPN service can be active at a time.</span>' + '<br/><br />' +
        'Select whether to Disable the Virtual Private Network (VPN) Server or to Enable one of the listed three modes:' + '<br/><br />' +
        'To enable a Point-to-Point Tunnel (PPTP), select PPTP. Most major operating systems support this type of connection. ' +
        'It\'s less secure than the other options, but is very fast.' + '<br/><br />' +
        'To enable Internal Protocol Security (IPsec), select IPsec. Apple, Android and Linux operating systems support this type of connection. ' +
        'It is more secure, but not supported by a native Windows client.' + '<br/><br />' +
        'To enable Layer 2 Tunnel Protocol (L2TP), select L2TP/IPsec. Most major operating systems support this type of connection. ' +
        'It has the same security as IPsec, but has a native Windows client.';
    helpMessage(title, message);
}

function pptpModeHelpMessage() {
    var title = 'VPN Server';
    var message = 'Point-to-Point Tunnel (PPTP) is supported by most major operating systems. It\'s less secure than the other options, but is very fast.' + '<br/><br />' +
        'Click on Save to start the PPTP Server.' + '<br/><br />' +
        'At least one user needs to be created before being able to connect to the PPTP Server.';
    helpMessage(title, message);
}

function startIPAddrHelpMessage() {
    var title = 'Starting IP Address';
    var message = 'The starting VPN IP address should be outside the normal DHCP range.';
    helpMessage(title, message);
}

function endIPAddrHelpMessage() {
    var title = 'Ending IP Address';
    var message = 'You limit the maximum number of PPTP connections by setting the IP address range. The VPN IP address range should be outside the normal DHCP range.';
    helpMessage(title, message);
}

function ipsecModeHelpMessage() {
    var title = 'VPN Server';
    var message = 'Click on Save to start IPsec.' + '<br/><br />' +
        'Please make sure to have an enabled DHCP server on the network.' + '<br/><br />' +
        'At least one user along with a Preshared Key needs to be created before being able to connect to the IPsec Server.';
    helpMessage(title, message);
}

function l2tpModeHelpMessage() {
    var title = 'VPN Server';
    var message = 'Click on Save to start L2TP/IPsec.' + '<br/><br />' +
        'Please make sure to have an enabled DHCP server on the network.' + '<br/><br />' +
        'At least one user along with a Preshared Key needs to be created before being able to connect to the IPsec Server.';
    helpMessage(title, message);
}

function aggressiveModeHelpMessage() {
    var title = 'Aggressive Mode';
    var message = 'Aggressive Mode accelerates security association by exchanging endpoint IDs unencrypted and reducing the number of exchanges between client and server. ' +
        'Aggressive mode is faster, but also less secure. For the most secure IPSec VPN, disable IKE Aggressive Mode.';
    helpMessage(title, message);
}

function presharedKeyHelpMessage() {
    var title = 'Preshared Key';
    var message = 'It is recommended that you make the Preshared Key a random combination of upper and lower case letters, numbers, and punctuation - ' +
        'that way it will be much more difficult to crack.' + '<br/><br />' +
        'So, for example, the preshared key \'1m&Hf0eQ!4s7M/,\' would be more difficult to crack than the Preshared Key \'password\'.' + '<br/><br />' +
        'The Password requires a minimum of 8 characters and a maximum of 64 characters. ' +
        'Passwords can contain alphanumerics and the these special characters !~@$%^*-_=[{]}: only.' + '<br/><br />' +
        'VPN clients may not support all special characters. Please check your VPN Client provider for compatiblitiy.';
    helpMessage(title, message);
}

function dhcpServerHelpMessage() {
    var title = 'DHCP Server';
    var message = 'This is the IP address that will be transmitted to VPN-connected clients so they may reach a DHCP router. ' +
        'Unless a separate external DHCP server is used, this address should match the LAN IP address of this router.';
    helpMessage(title, message);
}

function enableDHCPServerHelpMessage() {
    var title = 'Enable DHCP Server';
    var message = 'When enabled, the DHCP Server automatically assigns IP addresses to devices on the LAN that request them. If the DHCP server is disabled, each device must have its IP address configured manually.';
    helpMessage(title, message);
}

function ipv4ClassHelpMessage() {
    var title = 'IPV4 Class';
    var message = 'The IPV4 Class can be configured to support different network sizes and configurations. Class B and C are supported.';
    helpMessage(title, message);
}

function classCLanIPAddrHelpMessage() {
    var title = 'Class C LAN IP Address';
    var message = 'This is the Router IP address for the local area network and is configured in the Quick Setup page.';
    helpMessage(title, message);
}

function classBLanIPAddrHelpMessage() {
    var title = 'Class B LAN IP Address';
    var message = 'This is the Router IP address for the local area network and is configured in the Quick Setup page.';
    helpMessage(title, message);
}

function classCLanSubnetMaskHelpMessage() {
    var title = 'Class C LAN Subnet Mask';
    var message = 'This is the Subnet Mask for the local area network and is configured in the Quick Setup page.';
    helpMessage(title, message);
}

function classCLanIPAddrEndtHelpMessage() {
    var title = 'Class C LAN IP Address End';
    var message = 'This is the end of your Class C IP range and is defined by the class.';
    helpMessage(title, message);
}

function classCStartHelpMessage() {
    var title = 'Class C DHCP Start';
    var message = 'Enter a starting IP address for the DHCP server to use when assigning IP addresses to devices on the network.'+'<br /><br />'+'The default Starting IP Address is x.x.x.100.';
    helpMessage(title, message);
}

function classCEndHelpMessage() {
    var title = 'Class C DHCP End';
    var message = 'Enter an ending IP Address for the DHCP server to use when assigning IP addresses to devices on the network.'+'<br /><br />'+'The default Ending IP Address is x.x.x.200.'+'<br /><br />'+'Make sure you allocate enough addresses to support the devices on the network.';
    helpMessage(title, message);
}

function classCLeaseTimeHelpMessage() {
    var title = 'Class C Lease Time';
    var message = 'Enter the number of hours the DHCP Server holds the lease on a specific IP address. The lease time starts from the time the IP address is assigned. If the device is still using the IP address at the end of the lease time, the DHCP Server will automatically renew the lease.'+'<br /><br />'+'If the DHCP Server is used in a high turnover environment (i.e. a coffee shop), you may wish to set the lease time to a shorter interval.';
    helpMessage(title, message);
}

function classBLanIPAddrStartHelpMessage() {
    var title = 'Class B LAN IP Address Start';
    var message = 'This is the beginning IP address of your Class B IP range and is defined by the LAN IP configuration in Quick Setup.';
    helpMessage(title, message);
}

function classBLanSubnetMaskHelpMessage() {
    var title = 'Class B LAN Subnet Mask';
    var message = 'Select the desired Subnet Mask from the drop-down menu. The number in parentheses is the maximum number of available IP addresses for each subnet mask selection.';
    helpMessage(title, message);
}

function classBLanIPAddrEndtHelpMessage() {
    var title = 'Class B LAN IP Address End';
    var message = 'This is the ending IP address of your Class B IP range and is defined by the LAN IP configuration in Quick Setup and your chosen subnet mask.';
    helpMessage(title, message);
}

function classBStartHelpMessage() {
    var title = 'Class B DHCP Start';
    var message = 'Enter a starting IP address for the DHCP server to use when assigning IP addresses to devices on the network.';
    helpMessage(title, message);
}

function classBIPAddrNumHelpMessage() {
    var title = 'Class B Number of IP Addresses';
    var message = 'Total number of IP addresses to issue clients.';
    helpMessage(title, message);
}

function classBEndHelpMessage() {
    var title = 'Class B DHCP End';
    var message = 'Enter an ending IP address for the DHCP server to use when assigning IP addresses to devices on the network.'+'<br /><br />'+'The End IP Address must be in the same subnet as the router. The DHCP End IP Address must be higher than the LAN IP Address Start and cannot exceed the LAN IP Address End.';
    helpMessage(title, message);
}

function classBLeaseTimeHelpMessage() {
    var title = 'Class B Lease Time';
    var message = 'Enter the number of hours the DHCP Server holds the lease on a specific IP address. The lease time starts from the time the IP address is assigned. If the device is still using the IP address at the end of the lease time, the DHCP Server will automatically renew the lease.'+'<br /><br />'+'If the DHCP Server is used in a high turnover environment (i.e. a coffee shop), you may wish to set the lease time to a shorter interval.';
    helpMessage(title, message);
}

function dmzStatusHelpMessage() {
    var title = 'DMZ Status';
    var message = 'Enable DMZ to allow the router to forward all incoming WAN network traffic to a single IP address.'+'<br /><br />'+'If you want to open up all outside access to the network, place this router in the DMZ. To do this, enable the DMZ and enter the IP address of this device. For security reasons the DMZ IP address needs to be static lease or static IP address.';
    helpMessage(title, message);
}

function dmzIPAddrHelpMessage() {
    var title = 'DMZ IP Address';
    var message = 'This is the IP address to which you want all incoming WAN network traffic to be sent.';
    helpMessage(title, message);
}

function dnsStatusHelpMessage() {
    var title = 'Dynamic DNS';
    var message = 'Use the Dynamic Domain Name Service (DDNS) to automatically update the Domain Name System. '+'<br /><br />'+
        'If you set up a VPN on the router and it is assigned a DHCP IP address and the IP address changes, you won\'t be able to connect. ' +
        'DDNS allows the VPN service to find the router even if the IP address changes.';
    helpMessage(title, message);
}

function serviceProviderHelpMessage() {
    var title = 'Service Provider';
    var message = 'Choose the company you have selected to provide the Dynamic DNS Services. ' +
        'There are several no cost options for this service, including DynDNS, no-ip.com and freedns.afraid.org.';
    helpMessage(title, message);
}

function dnsHostNameHelpMessage() {
    var title = 'Hostname';
    var message = 'This is the Hostname created for this site in the specified Service Provider\'s account.';
    helpMessage(title, message);
}

function dnsUserNameHelpMessage() {
    var title = 'User Name';
    var message = 'This is the user name for logging into your Service Provider\'s account.';
    helpMessage(title, message);
}

function dnsPasswordHelpMessage() {
    var title = 'Password';
    var message = 'This is the password used for logging into your Service Provider\'s account.';
    helpMessage(title, message);
}

function dnsIntervalHelpMessage() {
    var title = 'Check Interval (Minutes)';
    var message = 'Allows you to choose how often to check for any changes to the WAN IP address. The Check Interval default value is 10 minutes.';
    helpMessage(title, message);
}

function dnsUpdateIntervalHelpMessage() {
    var title = 'Force Update (Days)';
    var message = 'Allows you to configure a forced update to the Dynamic DNS Provider. ' +
        'Many free accounts deactivate after 30 days, so this function is useful for resetting and updating the account. ' +
        'The Force Update default value is 3 days. ' +
        'It is not recommended to force an update more frequently than the default 3 days as some service providers may ban your router for excessive updates.';
    helpMessage(title, message);
}

function vlanStatusHelpMessage() {
    var title = 'VLAN';
    var message = 'A VLAN is a group of devices that are associated by function or other shared characteristics. ' +
        'Unlike LANs, which are usually geographically based, VLANs can group devices without regard to the physical location of the equipment or users. ' +
        'You can create up to 15 new VLANS.'+'<br/><br/>'+
        'NOTE: Improperly setting up VLANs can prevent you from accessing the network. A factory default may be required to clear the improperly setup VLAN.'+'<br/><br/>'+
        'Configuration Steps:'+'<br/><br/>'+
        '1. Configure VLANs'+'<br/><br/>'+
        '2. Assign PVIDs to VLANs'+'<br/><br/>'+
        'Visit www.luxul.com/support for the Luxul Webinar regarding VLANs.';
    helpMessage(title, message);
}

function addVlanHelpMessage() {
    var title = 'Add a VLAN';
    var message = 'Enter a VLAN number between 2 and 4080. If the VLAN already exists in the table use the edit VLAN function.';
    helpMessage(title, message);
}

function editVlanHelpMessage() {
    var title = 'Edit a VLAN';
    var message = 'Enter the VLAN number from the table of VLAN that needs to edited. Valid VLAN range is 1 to 4080.';
    helpMessage(title, message);
}

function removeVlanHelpMessage() {
    var title = 'Remove a VLAN';
    var message = 'Enter the VLAN from the table that needs to be removed. This is a permanent action and the deleted VLAN can\'t be recovered.'+'<br/><br/>'+
        'NOTE: VLAN 1 cannot be deleted. Please edit VLAN 1 or do a factory default to return the unit to a known state.';
    helpMessage(title, message);
}

function portVlanIdHelpMessage() {
    var title = 'Port VLAN ID';
    var message = 'Port VLAN ID or PVID assigns outgoing untagged traffic to a specified VLAN. The PVID has to be assigned to an existing VLAN.'+ '<br/><br />'+
        '<span style="font-size: 15px;font-weight: bold">VLANs must be created prior to assigning PVIDs.</span>'+ '<br/><br />'+
        'All ports exist in VLAN 1 (management VLAN) by default. As VLANs are added the PVID maybe changed to the added VLAN depending on how the VLAN is configured.';
    helpMessage(title, message);
}

function multiWanStatusHelpMessage() {
    var title = 'Multi-WAN Status';
    var message = 'Enable or Disable the Multi-WAN functionality.';
    helpMessage(title, message);
}

function multiWanHelpMessage() {
    var title = 'Multi Wan';
    var message = 'Edit the WAN settings for this specific WAN.';
    helpMessage(title, message);
}

function multiWan2HelpMessage() {
    var title = 'Multi Wan 2';
    var message = 'Edit the WAN settings for this specific WAN.';
    helpMessage(title, message);
}

function multiWan3HelpMessage() {
    var title = 'Multi Wan 3';
    var message = 'Add WAN - Add this WAN and make it active.<br/><br/>' +
        'Edit or Delete WAN - Edit the WAN settings or Delete this specific WAN.';
    helpMessage(title, message);
}

function multiWan4HelpMessage() {
    var title = 'Multi Wan 4';
    var message = 'Add WAN - Add this WAN and make it active..<br/><br/>' +
        'Edit or Delete WAN - Edit the WAN settings or Delete this specific WAN.';;
    helpMessage(title, message);
}

function multiWanDefaultPolicyHelpMessage() {
    var title = 'Multi Wan Default Policy';
    var message = 'Select which Policy you wish to make active.  The Balanced Policy is active by default.';
    helpMessage(title, message);
}

function wanNameHelpMessage() {
    var title = 'WAN Name';
    var message = 'Assign a name to your WAN. It may contain up to 15 alpha-numeric characters.';
    helpMessage(title, message);
}

function trackingReliabilityHelpMessage() {
    var title = 'Tracking Reliability';
    var message = 'Tracking Reliability indicates how many Tracking IP addresses must be reachable for the interface to be deemed up. ' +
                  'If the default of zero is used the interface is deemed to always be online.';
    helpMessage(title, message);
}

function trackingIpHelpMessage() {
    var title = 'Tracking IP';
    var message = 'Tracking IP addresses are pinged to determine if an interface is up or down. ' +
                  'If all boxes are empty, the interface is deemed to always be online.';
    helpMessage(title, message);
}

function pingCountHelpMessage() {
    var title = 'Ping Count';
    var message = 'The Ping Count value is the number of pings sent to each Tracking IP address. The default is 1.';
    helpMessage(title, message);
}

function pingTimeoutHelpMessage() {
    var title = 'Ping Timeout';
    var message = 'The Ping Timeout value is the number of seconds to wait for a ping reply. ' +
                  'Increase this number for slower links. The default is 2 seconds.';
    helpMessage(title, message);
}

function wanPingIntervalHelpMessage() {
    var title = 'Ping Interval';
    var message = 'The Ping Interval value is the time in seconds between pings sent to each Tracking IP address. ' +
                  'Increase this value for slower links. The default is 5 seconds.';
    helpMessage(title, message);
}

function interfaceDownHelpMessage() {
    var title = 'Interface Down';
    var message = 'The Interface Down value is the number of failed pings before an interface is deemed to be down. The default is 3.';
    helpMessage(title, message);
}

function interfaceUpHelpMessage() {
    var title = 'Interface Up';
    var message = 'The Interface Up value is the number of required successful pings before an interface is deemed to be up. The default is 5.';
    helpMessage(title, message);
}

function vlanDescriptionHelpMessage() {
    var title = 'VLAN Description';
    var message = 'Please enter a description of the function of the VLAN. This is only used for user information. Limit: 16 characters (spaces aren\'t allowed).';
    helpMessage(title, message);
}

function vlanRoutingHelpMessage() {
    var title = 'Inter VLAN Routing';
    var message = 'When enabled Inter VLAN Routing allows this VLAN to have access to other VLANs on the network. Enabled by default.' +
    'Disable if creating a Guest Network for example.';
    helpMessage(title, message);
}

function vlanPortEnableHelpMessage() {
    var title = 'VLAN Port Enable';
    var message = 'Select which port you want assigned to this VLAN and then select whether you want the port tagged (default) or untagged.<br/><br/>'+
                  'NOTE: Port numbers correspond to the physical LAN ports on the unit.<br/><br/>'+
                  'NOTE: If an expected port is missing it may have been assigned to a MultiWAN port.';
    helpMessage(title, message);
}

function vlanIPAddrHelpMessage() {
    var title = 'VLAN IP Address';
    var message = 'This is the IP address used by the router to support the VLAN.' +
                  'NOTE: Make sure the VLAN IP address doesn\'t conflict with other IP address ranges on the router.';
    helpMessage(title, message);
}

function vlanSubnetMaskHelpMessage() {
    var title = 'VLAN Subnet Mask';
    var message = 'This is the Subnet Mask used by the router to support the VLAN.';
    helpMessage(title, message);
}

function vlanDHCPServerHelpMessage() {
    var title = 'VLAN DHCP Server';
    var message = 'The DHCP Server feature is used to automatically assign IP Addresses to devices on the VLAN. If disabled, the IP Address for each device must be set manually.';
    helpMessage(title, message);
}

function vlanDHCPStartHelpMessage() {
    var title = 'VLAN DHCP Start';
    var message = 'Enter a starting IP Address for the DHCP server to use when assigning IP addresses to devices on the VLAN.'+
                  'The Start and End IP Address must be in the same subnet as the router VLAN IP Address.';
    helpMessage(title, message);
}

function vlanDHCPEndHelpMessage() {
    var title = 'VLAN DHCP End';
    var message = 'Enter an Ending IP Address for the VLAN DHCP server to use when assigning IP addresses to devices on the VLAN.'+
                  'The Start and End IP Address must be in the same subnet as the router VLAN IP Address.'+
                  'In this example, the VLAN DHCP pool would have 100 addresses available. Make sure you allocate enough addresses to support the devices on the network.';
    helpMessage(title, message);
}

function vlanDHCPLeaseTimeHelpMessage() {
    var title = 'VLAN DHCP Lease Time';
    var message = 'Enter the number of hours the VLAN DHCP Server holds the lease on a specific IP address. ' +
                  'The lease time starts from the time the IP address is assigned. ' +
                  'If the device is still using the IP address at the end of the lease time, the VLAN DHCP Server will automatically renew the lease.'+
                  'If the VLAN DHCP Server is used in a high turnover environment (like a coffee shop), you may wish to set the lease time to a shorter interval.';
    helpMessage(title, message);
}

function multiWanPolicyHelpMessage() {
    win = window.open("", "popWin", "width=400, height=600, left=10, screenX=10, top=10, screenY=10,scrollbars=yes");
    if (win.document.getElementById("help-message") == null) {
        win.document.write("<link rel='stylesheet' type='text/css' href='../../public/css/styles.css'>" +
            "<body><div class='HelpPage'>" + "<div class='help-message' id='help-message'>" +
            "<h2>Policies</h2>" +
            "<p>Policies define how traffic is routed through the different WAN interfaces.  There are 3 Policies:<br/><br/>" +
            "Balanced - Balance traffic across active WANs.  Use the Weight column to assign load distribution." +
            "If all the values for the WANs are the same, then the router will equally distribute traffic between the WANs." +
            "By default all WANs are assigned a value of 1 and thus traffic across them is balanced." +
            "To distribute traffic using a specific ratio, assign a value from 1 to 9 to each selected WAN, with a total of 10." +
            "Each point equals 10% of the traffic assigned to the WAN." +
            "For example, 7 and 3 would represent a 70%/30% traffic distribution on two WANs.<br/><br/>" +
            "Failover - Configure WANs in a failover scenario." +
            "The lowest value in the Priority column handles all of the traffic and will failover to the WAN with the next highest Priority." +
            "By default, the interface labeled 'wan' has a Priority value of 1 and will carry all traffic. " +
            "In the event 'wan' goes down, it will failover to 'wan2' with a Priority of 2, and so on.<br/><br/>" +
            "Single WAN - Force the router to use the 'wan' interface only." +
            "</p>" +
            "<h2>Multi-WAN Rules</h2>" +
            "<p>A rule describes what traffic to match and what policy to assign for that traffic. " +
            "Rules are evaluated from top to bottom. The Default Rule always exists. Default Rule Name can not be edited."+
            "</p>" +
            "<h2>Rule Name</h2>" +
            "<p>The Username field is 1 to 15 characters in length. " +
            "The Rule Name can only contain ASCII characters a-z, A-Z, numbers 0-9, and \"_\" (underscore)."+
            "</p>" +
            "<h2>Source Address</h2>" +
            "<p>Set the incoming IPv4 IP address with subnet in CIDR notation. 0-32 are allowed CIDR values. (for example: 8.8.12.15/32)."+
            "</p>" +
            "<h2>Source Port(s)</h2>" +
            "<p>Enter specific ports if desired to designate traffic. " +
            "The use of commas to separate ports, use colons for port ranges. Example: 80, 25, 120 or 1000:2000. " +
            "Allowed port range is 1 to 65535."+
            "</p>" +
            "<h2>Destination Address</h2>" +
            "<p>Set the destination IPv4 IP address with subnet in CIDR notation. " +
            "0-32 are allowed CIDR values. (for example: 8.8.12.15/32)."+
            "</p>" +
            "<h2>Destination Port(s)</h2>" +
            "<p>Enter specific ports if desired to designate traffic. The use of commas to separate ports, use colons for port ranges. " +
            "Example: 80, 25, 120 or 1000:2000. Allowed port range is 0 to 65535."+
            "</p>" +
            "<h2>Protocols</h2>" +
            "<p>Use this to set the TCP or UDP protocol for this rule. All is default and will use both."+
            "</p>" +
            "<div class=spacer></div> </div> </div></body>");
    }
}

function multiWanReportsHelpMessage() {
    var title = 'Multi-WAN Status';
    var message = 'Multi-WAN Status displays current status of your WANs. ' +
        'If no Tracking IPs are set in the WAN\'s configuration, the WAN will always show green and online ' +
        'regardless of actual WAN status. From the Multi-WAN Status Menu select a Report to view. ' +
        'The Interface report displays network settings for all active WANs. ' +
        'The Policy report displays which Policy is active and its traffic balance.';
    helpMessage(title, message);
}

function multiWanInterfaceReportHelpMessage() {
    var title = 'Interface Report';
    var message = 'Interface Report displays network settings for all active WANs, and whether tracking is active on a WAN.';
    helpMessage(title, message);
}

function multiWanPolicyReportHelpMessage() {
    var title = 'Policy Report';
    var message = 'The Policy Report displays all Policies\' current traffic load balance.';
    helpMessage(title, message);
}

function routerLimitsSystemHelpMessage() {
    var title = 'Router Limits System';
    var message = 'Enabling the Router Limits software on this device will allow it to communicate with the Router Limits web management service.'+'<br/><br/>' +
        'Note: This feature is incompatible with QoS, Multi-WAN, Router Limits and WAN Redirect. WAN Acceleration must be disabled for those features to function.';
    helpMessage(title, message);
}

function routerLimitsStatusHelpMessage() {
    var title = 'Current Status';
    var message = 'Displays the current status of the Router Limits software on this router:'+'<br/><br/>' +
        'CONNECTING = the router has not yet contacted Router Limits.'+'<br/><br/>' +
        'READY TO ACTIVATE = the router has contacted Router Limits and is ready to be associated with an account.'+'<br/><br/>' +
        'ONLINE = the router is associated with a Router Limits account and is protecting.';
    helpMessage(title, message);
}

function routerLimitsDeviceIdHelpMessage() {
    var title = 'Pairing Code';
    var message = 'Router Limits uses this unique code to identify this device during activation.';
    helpMessage(title, message);
}