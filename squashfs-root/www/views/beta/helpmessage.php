<aside class="aside-right" id="help-section">
    <div class="HelpPage">
        <div class="help-message" id="help-message">
            <h1><img src="../../public/img/icon-help-header.png"> Help</h1>

            <h2>Beta Features Help</h2>

            <p><span style="font-weight: bold">This page is for testing only. Use these features at your own risk. </span>These features are to be used after
                Luxul Support has provided guidance for their use.</p>

            <p><span style="font-weight: bold">Port Monitoring: </span>This feature enables monitoring for disconnection
                events. Enabling this feature adds addition
                capabilities to detect and correct a disconnect/connect event.
            </p>

            <p><span style="font-weight: bold">WAN Delay: </span>This feature reinitializes the WAN port after the
                number of seconds entered. This may be
                necessary if the modem is slow to boot or to provide a valid IP address. With a value of 0 (zero) there
                is no delay for the WAN port. The maximum allowed value is 99 seconds. A value of 60 is a suitable place
                to start. Any changes to this value will take affect on the next boot. This feature has no effect on the
                operation of the LAN.
            </p>

            <p><span style="font-weight: bold">WAN VLAN ID: </span> This feature allows you to setup a VLAN ID on the
                Routers WAN Port if your ISP requires it.
            </p>

            <p><span style="font-weight: bold"> Block Self Assigned IP:</span> Enabled: Blocks Self Assigned
                IP addresses (169.254.0.0/16) from the router. Disabled: Allows Self Assigned IP addresses
                (169.254.0.0/16)
                to be processed by the router.
                Self Assigned addresses (169.254.0.0/16) are not routeable and will be dropped at the router if enabled.
                The default and
                recommended selection is to Block Self-assigned addresses.
            </p>

            <p><span style="font-weight: bold"> Port Link Speed:</span> Manually set the Port Link Speed if you suspect
                that the port speed is auto negotiating incorrectly. You will need to verify which Ethernet links speeds
                are allowed by the device connected to the other end of the selected Port.
            </p>

            <div class=spacer></div>
        </div>
    </div>
</aside>