#!/bin/sh

DHCP_LEASE_TABLE="/tmp/dhcp.leases"
ARP_TABLE="/proc/net/arp"

DISCOVERED_CLIENTS="/tmp/discovered.clients"

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

# Start with a clean (empty) list of discovered clients
echo "Hostname IP Address MAC Address" > "${DISCOVERED_CLIENTS}"

# Look at the ARP Table entries showing br-lan (all except the first entry)
while read arp_line; do
	set -o noglob
	set -- $arp_line
	set +o noglob
	ipaddr="$1"
	macaddr="$4"
	# Does it have a name?
	clientName="*"

# Look at the DHCP Lease Table
	while read dhcp_line; do
		set -o noglob
		set -- $dhcp_line
		set +o noglob
		if [ "$2" = "$macaddr" ]
		then
		clientName="$4"
		fi
	done <<-EOD2
		$(cat "${DHCP_LEASE_TABLE}")
	EOD2

	echo "$clientName $ipaddr $macaddr" >> $DISCOVERED_CLIENTS

done <<-EOD1
	$(cat "${ARP_TABLE}" | grep -v eth0.40[81-91] | tail -n+2)
EOD1

