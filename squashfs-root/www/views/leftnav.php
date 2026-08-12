<aside class="aside-left">
    <?php if ($data[MULTI_WAN_WIZARD_STATUS] == MULTI_WAN_WIZARD_STATUS_1 && $data[MULTI_WAN_STATUS] == MULTI_WAN_STATUS_ENABLED_KEY) { ?>
        <div id="mulitiwanEnabledDiv">
            <ul class="nav-links">
                <li><a title="setup" href="/quicksetup/display">Quick Setup</a></li>
                <li>
                    <a title="Status" class="cat-link closed">Status</a>
                    <ul>
                        <li><a href="/system/display" title="System">Overview</a></li>
                        <li><a href="/connections/display" title="Connections">Connected Clients</a></li>
                        <li><a href="/port/display" title="Ports">Port State Overview</a></li>
                    </ul>
                </li>
                <li>
                    <a title="Wireless" class="cat-link closed">Network</a>
                    <ul>
                        <li><a href="/dhcp/display" title="DHCP">DHCP Server</a></li>
                        <li><a href="/lease/display" title="Settings">Static Leases</a></li>
                        <li><a href="/dns/display" title="Settings">Dynamic DNS</a></li>
                        <li><a title="VLAN" href="/vlan/display">VLAN</a></li>
                        <li><a title="Routing" href="/routing/display">Routing</a></li>

                        <li>
                            <a title="Profiles" class="cat-link closed">Multi-WAN</a>
                            <ul>
                                <li><a href="/multiwansetting/display" title="multiwan settings">WAN Settings</a></li>

                                <li><a href="/multiwanpolicy/display" title="policy">Policies</a></li>
                                <li><a href="/multiwanreport/display" title="report">Status</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>

                <li>
                    <a title="Status" class="cat-link closed">Firewall/Security</a>
                    <ul>
                        <li><a href="/portforward/display" title="Port Forwarding">Port Forwarding</a></li>
                        <li><a href="/dmz/display" title="DMZ">DMZ</a></li>
                        <li><a href="/upnp/display" title="UPnP">UPnP</a></li>
                        <li><a href="/webfilter/display" title="Web Filtering">Web Filtering</a></li>
                        <li><a href="/routerlimits/display" title="Parental Controls">Parental Controls</a></li>
                    </ul>
                </li>
                <li>
                    <a title="QoS" href="/qos/display">QoS</a>
                </li>

                <li>
                    <a title="Status" class="cat-link closed">VPN</a>
                    <ul>
                        <li><a href="/vpnserver/display" title="VPN Server">VPN Server</a></li>
                        <li><a href="/vpnuser/display" title="VPN User">VPN User</a></li>
                    </ul>
                </li>

                <li>
                    <a title="Status" class="cat-link closed">Administration</a>
                    <ul>
                        <li><a id='admin_pwd' href="/password/display" title="Password">Admin Password</a></li>
                        <li><a id='admin_upgrade_manual' href="/upgrade/display" title="Upgrade Manually">Firmware Update</a></li>
                        <li><a id='admin_factory' href="/factory/display" title="Factory">Factory Defaults</a></li>
                        <li><a id='admin_backup' href="/backup/display" title="Backup">Backup/Restore</a></li>
                        <li><a id='admin_log' href="/log/display" title="Log">System Log</a></li>
                        <li><a id='admin_time' href="/timezone/display" title="Set Time">Set Time</a></li>
                        <li><a title="advanced" href="/advance/display">Advanced</a></li>
                        <li><a id='admin_pwd' href="/compliance/display" title="Software Notice">Software Notice</a></li>
                    </ul>
                </li>

                <li>
                    <a title="Status" class="cat-link closed">Tools</a>
                    <ul>
                        <li><a id='admin_iperf' href="/iperf/display" title="Iperf">Iperf</a></li>
                        <li><a id='admin_ping' href="/ping/display" title="Ping">Ping</a></li>
                        <li><a id='admin_traceroute' href="/trace/display" title="Trace Route">Trace Route</a></li>
                        <li><a id='admin_cmdline' href="/cmdline/display" title="Command Line">Command Line</a></li>
                    </ul>
                </li>

                <p class="legal">Copyright &copy2016 Luxul</p>
            </ul>
        </div>

    <?php } else if ($data[MULTI_WAN_STATUS] == MULTI_WAN_STATUS_DISABLED_KEY){ ?>
        <ul class="nav-links">
            <li><a title="setup" href="/quicksetup/display">Quick Setup</a></li>
            <li>
                <a title="Status" class="cat-link closed">Status</a>
                <ul>
                    <li><a href="/system/display" title="System">Overview</a></li>
                    <li><a href="/connections/display" title="Connections">Connected Clients</a></li>
                    <li><a href="/port/display" title="Ports">Port State Overview</a></li>
                </ul>
            </li>
            <li>
                <a title="Wireless" class="cat-link closed">Network</a>
                <ul>
                    <li><a href="/dhcp/display" title="DHCP">DHCP Server</a></li>
                    <li><a href="/lease/display" title="Settings">Static Leases</a></li>
                    <li><a href="/dns/display" title="Settings">Dynamic DNS</a></li>
                    <li><a title="VLAN" href="/vlan/display">VLAN</a></li>
                    <li><a title="Routing" href="/routing/display">Routing</a></li>

                    <li>
                        <a title="Profiles" class="cat-link closed">Multi-WAN</a>
                        <ul>
                            <li><a href="/multiwansetting/display" title="multiwan settings">WAN Settings</a></li>
                        </ul>
                    </li>

                </ul>
            </li>

            <li>
                <a title="Status" class="cat-link closed">Firewall/Security</a>
                <ul>
                    <li><a href="/portforward/display" title="Port Forwarding">Port Forwarding</a></li>
                    <li><a href="/dmz/display" title="DMZ">DMZ</a></li>
                    <li><a href="/upnp/display" title="UPnP">UPnP</a></li>
                    <li><a href="/webfilter/display" title="Web Filtering">Web Filtering</a></li>
                    <li><a href="/routerlimits/display" title="Parental Controls">Parental Controls</a></li>
                </ul>
            </li>
            <li>
                <a title="QoS" href="/qos/display">QoS</a>
            </li>

            <li>
                <a title="Status" class="cat-link closed">VPN</a>
                <ul>
                    <li><a href="/vpnserver/display" title="VPN Server">VPN Server</a></li>
                    <li><a href="/vpnuser/display" title="VPN User">VPN User</a></li>
                </ul>
            </li>

            <li>
                <a title="Status" class="cat-link closed">Administration</a>
                <ul>
                    <li><a id='admin_pwd' href="/password/display" title="Password">Admin Password</a></li>
                    <li><a id='admin_upgrade_manual' href="/upgrade/display" title="Upgrade Manually">Firmware Update</a></li>
                    <li><a id='admin_factory' href="/factory/display" title="Factory">Factory Defaults</a></li>
                    <li><a id='admin_backup' href="/backup/display" title="Backup">Backup/Restore</a></li>
                    <li><a id='admin_log' href="/log/display" title="Log">System Log</a></li>
                    <li><a id='admin_time' href="/timezone/display" title="Set Time">Set Time</a></li>
                    <li><a title="advanced" href="/advance/display">Advanced</a></li>
                    <li><a id='admin_pwd' href="/compliance/display" title="Software Notice">Software Notice</a></li>
                </ul>
            </li>

            <li>
                <a title="Status" class="cat-link closed">Tools</a>
                <ul>
                    <li><a id='admin_iperf' href="/iperf/display" title="Iperf">Iperf</a></li>
                    <li><a id='admin_ping' href="/ping/display" title="Ping">Ping</a></li>
                    <li><a id='admin_traceroute' href="/trace/display" title="Trace Route">Trace Route</a></li>
                    <li><a id='admin_cmdline' href="/cmdline/display" title="Command Line">Command Line</a></li>
                </ul>
            </li>

            <p class="legal">Copyright &copy2016 Luxul</p>
        </ul>
    <?php } else { ?>
        <div class="wizard-progress">
            <h3 style="line-height: 20px">Multi-WAN Setup Wizard</h3>
        </div>
    <?php } ?>

    <div class="wizard-complete" style="display: none">
        <h3 style="line-height: 20px">Multi-WAN Setup</h3>
    </div>

</aside>
