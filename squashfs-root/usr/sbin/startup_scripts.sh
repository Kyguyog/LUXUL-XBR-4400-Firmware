#!/bin/sh

# Run helper scripts
/usr/sbin/vlans-monitor.sh &

wan_delay=$(uci get -q luxul.dynamic.wan_delay)
if [ "$wan_delay" -eq "$wan_delay" ] 2>/dev/null; then
	ubus call network.device set_state "{ \"name\": \"eth0.4081\", \"defer\": true }"
	sleep $wan_delay
	ubus call network.device set_state "{ \"name\": \"eth0.4081\", \"defer\": false }"
fi
exit 0

