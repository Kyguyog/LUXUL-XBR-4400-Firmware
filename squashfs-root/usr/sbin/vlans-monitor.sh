#!/bin/ash

if [ ! -e /sbin/swconfig ]; then
	echo "No swconfig"
	exit -1
fi

rm /var/run/vlans-monitor.*.state 2> /dev/null

local cpuport=$(swconfig dev switch0 help 2> /dev/null | sed -ne "s|.*cpu @ \([0-9]*\).*|\1|p")

check_states()
{
local vlan=""
swconfig dev switch0 show | grep -A 1 VLAN | while read line; do
	if [ -z "$vlan" ]; then
		# Parse line like: VLAN 1:
		vlan=$(echo "$line" | sed -ne "s|.*VLAN \([0-9]*\):|\1|p")
	else
		# Parse line like: ports: 1 2 3 4 8t
		local ports_all=$(echo "$line" | sed -ne "s|.*ports: \(.*\)|\1|p")
		local ports_notags=$(echo "$ports_all" | sed "s|t||g")
		local ports_nocpu=$(echo "$ports_notags" | sed "s| $cpuport ||" | sed "s|^$cpuport ||" | sed "s| $cpuport$||")
		local ports_count=$(echo "$ports_nocpu" | grep -o " " | wc -l)
		ports_count=$(($ports_count+1))
		local file="/var/run/vlans-monitor.$vlan.state"

		if [ $ports_count -eq 1 ]; then
			local port="$ports_nocpu"
			local state=$(swconfig dev switch0 port $port get link | sed -ne "s|.*link:\([a-z]*\).*|\1|p")
			
			if [ ! -f $file ]; then
				echo "$state" > $file
				logger "$0: Started observing VLAN $vlan (state: $state)"
			elif [ "$state" != "$(cat $file)" ]; then
				if [ "$state" = "down" ]; then
					ubus call network.device set_state "{ \"name\": \"eth0.$vlan\", \"defer\": true }"
				elif [ "$state" = "up" ]; then
					ubus call network.device set_state "{ \"name\": \"eth0.$vlan\", \"defer\": false }"
				fi
				echo "$state" > $file
				logger "$0: State of VLAN $vlan has changed to $state!"
			fi
		else
			# If we were observing this VLAN, stop
			if [ -f $file ]; then
				rm $file
				logger "$0: Stopped observing VLAN $vlan"
			fi
		fi
		vlan=""
	fi
done
}

while [ 1 ]
do
		check_states
		sleep 2
done


