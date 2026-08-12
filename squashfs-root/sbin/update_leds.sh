#!/bin/sh
#

FAST_BLINK=75

set_gpio_led() {

	echo $2 > $1/trigger
}

set_heartbeat() {
	[ $state_visible -eq 1 ] && system_led_state="heartbeat"
}

local state_visible=$(uci get -q luxul.dynamic.leds_visible)
local state_link=$(uci get -q luxul.dynamic.repeater_link)
local system_led="/sys/class/leds/bcm47xx:green:system"
local system_led_state="none"
local radio_led_state="0"
local factory_reset=0
local reset=0

while getopts "fr" opt; do
	case $opt in
		f)
			factory_reset=1
			;;
		r)
			reset=1
			;;
	esac
done

[ $state_visible -eq 1 ] && {
	system_led_state="default-on"
	radio_led_state="7"
}

board=$(nvram get board_id)
[ -z "$board" ] && exit 1

case "$board" in
	luxul_xap1210_v1)
		;;

	luxul_xap310_v1)
		;;

	luxul_xbr4400_v1)
		set_heartbeat
		;;

	luxul_abr4400_v1)
		set_heartbeat
		;;

	luxul_xwr600_v1)
		set_heartbeat
		;;

	luxul_xwc1000_v1)
		set_heartbeat
		system_led="/sys/class/leds/bcm53xx:green:status"
		;;

	luxul_abr4500_v1)
		set_heartbeat
		system_led="/sys/class/leds/bcm53xx:green:status"
		;;

	luxul_xbr4500_v1)
		set_heartbeat
		system_led="/sys/class/leds/bcm53xx:green:status"
		;;

## Land 'o' the special cases
	luxul_xvwp30_v1)
		system_led="/sys/class/leds/bcm47xx:blue:system"
		system_led_state="none"
		link_led="/sys/class/leds/bcm47xx:green:link"
		link_led_state="default_on"
		sleep 5
		[ $state_link -eq 0 ] && {
			system_led_state="none"
			link_led_state="default_on"
		}
		set_gpio_led $link_led $link_led_state
		;;

	luxul_xwr1750_v1)
		set_heartbeat
		if [ $state_visible -eq 1 ]; then
			echo netdev > /sys/class/leds/bcm47xx:green:5ghz/trigger
			echo wlan0 > /sys/class/leds/bcm47xx:green:5ghz/device_name
			echo link tx rx > /sys/class/leds/bcm47xx:green:5ghz/mode
			echo netdev > /sys/class/leds/bcm47xx:green:2ghz/trigger
			echo wlan1 > /sys/class/leds/bcm47xx:green:2ghz/device_name
			echo link tx rx > /sys/class/leds/bcm47xx:green:2ghz/mode
		else
			echo none > /sys/class/leds/bcm47xx:green:5ghz/trigger
			echo none > /sys/class/leds/bcm47xx:green:2ghz/trigger
		fi
		;;

	luxul_xwr1200_v1)
		system_led="/sys/class/leds/bcm53xx:green:status"
		set_heartbeat
		if [ $state_visible -eq 1 ]; then
			echo netdev > /sys/class/leds/bcm53xx:green:5ghz/trigger
			echo wlan0 > /sys/class/leds/bcm53xx:green:5ghz/device_name
			echo link tx rx > /sys/class/leds/bcm53xx:green:5ghz/mode
			echo netdev > /sys/class/leds/bcm53xx:green:2ghz/trigger
			echo wlan1 > /sys/class/leds/bcm53xx:green:2ghz/device_name
			echo link tx rx > /sys/class/leds/bcm53xx:green:2ghz/mode
		else
			echo none > /sys/class/leds/bcm53xx:green:5ghz/trigger
			echo none > /sys/class/leds/bcm53xx:green:2ghz/trigger
		fi
		;;

	luxul_xwr3100_v1)
		system_led="/sys/class/leds/bcm53xx:green:status"
		set_heartbeat
		if [ $state_visible -eq 1 ]; then
			echo netdev > /sys/class/leds/bcm53xx:green:5ghz/trigger
			echo wlan1 > /sys/class/leds/bcm53xx:green:5ghz/device_name
			echo link tx rx > /sys/class/leds/bcm53xx:green:5ghz/mode
			echo netdev > /sys/class/leds/bcm53xx:green:2ghz/trigger
			echo wlan0 > /sys/class/leds/bcm53xx:green:2ghz/device_name
			echo link tx rx > /sys/class/leds/bcm53xx:green:2ghz/mode
		else
			echo none > /sys/class/leds/bcm53xx:green:5ghz/trigger
			echo none > /sys/class/leds/bcm53xx:green:2ghz/trigger
		fi
		;;

	luxul_xap1230_v1)
		if [ $state_visible -eq 1 ]; then
			echo netdev > /sys/class/leds/bcm47xx:blue:2ghz/trigger
			echo wlan0 > /sys/class/leds/bcm47xx:blue:2ghz/device_name
			echo link tx rx > /sys/class/leds/bcm47xx:blue:2ghz/mode
			/sbin/mii-phy eth0 0x19 0x1c 0xa418
			/sbin/mii-phy eth0 0x19 0x1c 0xb8e3
		else
			echo none > /sys/class/leds/bcm47xx:blue:2ghz/trigger
			/sbin/mii-phy eth0 0x19 0x1c 0xb8ee
		fi
		;;

	luxul_xap1240_v1)
		if [ $state_visible -eq 1 ]; then
			echo netdev > /sys/class/leds/bcm47xx:blue:2ghz/trigger
			echo wlan0 > /sys/class/leds/bcm47xx:blue:2ghz/device_name
			echo link tx rx > /sys/class/leds/bcm47xx:blue:2ghz/mode
			/sbin/mii-phy eth0 0x19 0x1c 0xa418
			/sbin/mii-phy eth0 0x19 0x1c 0xb8e3
		else
			echo none > /sys/class/leds/bcm47xx:blue:2ghz/trigger
			/sbin/mii-phy eth0 0x19 0x1c 0xb8ee
		fi
		;;

	luxul_xap1410_v1)
		system_led="/sys/class/leds/bcm53xx:green:status"
		if [ $state_visible -eq 1 ]; then
			echo netdev > /sys/class/leds/bcm53xx:blue:5ghz/trigger
			echo wlan0 > /sys/class/leds/bcm53xx:blue:5ghz/device_name
			echo link tx rx > /sys/class/leds/bcm53xx:blue:5ghz/mode
			echo netdev > /sys/class/leds/bcm53xx:blue:2ghz/trigger
			echo wlan1 > /sys/class/leds/bcm53xx:blue:2ghz/device_name
			echo link tx rx > /sys/class/leds/bcm53xx:blue:2ghz/mode
		else
			echo none > /sys/class/leds/bcm53xx:blue:5ghz/trigger
			echo none > /sys/class/leds/bcm53xx:blue:2ghz/trigger
		fi
		;;

	luxul_xap1500_v1)
		system_led="/sys/class/leds/bcm47xx:green:system"
		if [ $state_visible -eq 1 ]; then
			echo netdev > /sys/class/leds/bcm47xx:green:5ghz/trigger
			echo wlan0 > /sys/class/leds/bcm47xx:green:5ghz/device_name
			echo link tx rx > /sys/class/leds/bcm47xx:green:5ghz/mode
			echo netdev > /sys/class/leds/bcm47xx:green:2ghz/trigger
			echo wlan1 > /sys/class/leds/bcm47xx:green:2ghz/device_name
			echo link tx rx > /sys/class/leds/bcm47xx:green:2ghz/mode
		else
			echo none > /sys/class/leds/bcm47xx:green:5ghz/trigger
			echo none > /sys/class/leds/bcm47xx:green:2ghz/trigger
		fi
		;;

	luxul_xap1510_v1)
		system_led="/sys/class/leds/bcm53xx:green:status"
		if [ $state_visible -eq 1 ]; then
			echo netdev > /sys/class/leds/bcm53xx:blue:5ghz/trigger
			echo wlan0 > /sys/class/leds/bcm53xx:blue:5ghz/device_name
			echo link tx rx > /sys/class/leds/bcm53xx:blue:5ghz/mode
			echo netdev > /sys/class/leds/bcm53xx:blue:2ghz/trigger
			echo wlan1 > /sys/class/leds/bcm53xx:blue:2ghz/device_name
			echo link tx rx > /sys/class/leds/bcm53xx:blue:2ghz/mode
		else
			echo none > /sys/class/leds/bcm53xx:blue:5ghz/trigger
			echo none > /sys/class/leds/bcm53xx:blue:2ghz/trigger
		fi
		;;

esac

set_gpio_led $system_led $system_led_state

if [ $factory_reset -eq 1 ]; then
	echo timer > $system_led/trigger
	echo $FAST_BLINK > $system_led/delay_on
	echo $FAST_BLINK > $system_led/delay_off
elif [ $reset -eq 1 ]; then
	system_led_state="none"
	set_gpio_led $system_led $system_led_state
fi

exit 0

