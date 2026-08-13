#!/bin/sh

. /lib/functions.sh

# Errors:
# x1 - unable to download fw_list from server
# x2 - unable to download current controller firmware from server
# x3 - luxul config missing fw_repo or fw_list variables
# yx - unable to download AP firmware (y tries)

# $(1) message to be logged
fwmanlog() {
	logger $script: $(date) $1
}

compare_firmware_rev() {
	local cur_rev=$(uci get -q luxulacs.$1.software_version)
	local modelup=$(uci get -q luxulacs.$1.model | cut -d' ' -f1)
	local model=$(echo "$modelup" | sed 's/-//' | awk '{print tolower($0)}')
	local srv_rev=$(uci get -q /var/srv_rev.$model.rev)
	local srv_md5=$(uci get -q /var/srv_rev.$model.md5)
	if [ $? -ne 0 ]; then
		fwmanlog "error unrecognized AP $model"
		return 1
	fi
	# Does this AP exist in the model config?
	cfg_model=$(uci -q get models.$model.rev)
	if [ $? -ne 0 ]; then
		uci set models.$model=model
		uci set models.$model.rev=$srv_rev
		fwmanlog "added new model $model"
		commit_req=1
	fi

	if [ "$cur_rev" != "$(basename "$srv_rev" .lxl)" ]; then
		uci set fwman.basic.apupdate=1
		commit_req=1
		# Do I need to get this firmware?
		if [ ! -f "$FWDIR/$srv_rev" ]; then
			# Delete any existing old rev for this model
			rm -f $FWDIR/$modelup*
			# get the new fw
			wget -q $fw_url$srv_rev -O $FWDIR/$srv_rev > /dev/null
			if [ $? -ne 0 ] || [ "$srv_md5" != "$(md5sum $FWDIR/$srv_rev | cut -d' ' -f1)" ]; then
				fwmanlog "Failed to download $srv_rev"
				[ -e "$FWDIR/$srv_rev" ] && rm -f $FWDIR/$srv_rev
				fwmanlog "failed to retrieve $srv_rev"
				err_cnt=$(( $err_cnt + 10))
			else
				fwmanlog "retrieved $srv_rev"
			fi
		fi
	fi
}

download_current_fw_list() {
	wget -q $fw_url$fw_list -O /var/srv_rev > /dev/null
	if [ $? -ne 0 ]; then
		fwmanlog "Failed to retrieve current firmware list"
		exit_fwman 1
	fi
}

exit_fwman() {
	uci set fwman.basic.error=$1
	uci set fwman.basic.busy=0
	exit $1
}

script=$0
commit_req=0
err_cnt=0
WWWDIR="/www"
FWDIR="/fwcache"
MODELS_CONFIG="/etc/config/models"
CONTROLLER_CONFIG="/etc/config/luxulacs"

fw_url=$(uci -q  get fwman.basic.repo_url)
fw_list=$(uci -q get fwman.basic.repo_file)
uci set fwman.basic.error=0
uci set fwman.basic.busy=1
if [ -z "$fw_url" -o -z "$fw_list" ]; then
	fwmanlog "missing fw repo url or list, exiting"
	exit_fwman 3
fi

while getopts "cug" opt; do
	case $opt in
	c) # check to see if you can touch the server
		wget -q --spider --timeout=2 $fw_url$fw_list > /dev/null
		if [ $? -ne 0 ]; then
			fwmanlog "Unable to communicate with Luxul server"
			exit_fwman 1
		fi
	;;
	u) # check for and retrieve any controller FW update
		download_current_fw_list
		uci set fwman.basic.update=0

		model=$(uci get -q luxul.static.hw_model)
		model=$(echo $model | tr -d '-' | awk '{print tolower($0)}')
		srv_rev=$(uci get -q /var/srv_rev.$model.rev)
		srv_md5=$(uci get -q /var/srv_rev.$model.md5)
		cur_rev=$(uci get -q luxul.static.hw_model)"-"$(uci get -q luxul.static.fw_version).lxl
		if [ -n "$srv_rev" -a "$srv_rev" != "$cur_rev" ]; then
			# do I need to get this firmware?
			if [ ! -f "/tmp/$srv_rev" ]; then
				wget -q $fw_url$srv_rev -O /tmp/$srv_rev > /dev/null
				if [ $? -ne 0 ] || [ "$srv_md5" != "$(md5sum /tmp/$srv_rev | cut -d' ' -f1)" ]; then
					echo "$srv_md5 $(md5sum /tmp/$srv_rev | cut -d' ' -f1)"
					fwmanlog "Failed to download $srv_rev"
					[ -e "/tmp/$srv_rev" ] && rm -f /tmp/$srv_rev
					exit_fwman 2
				else
					fwmanlog "retrieved $srv_rev"
				fi
			fi
			uci set fwman.basic.update=$srv_rev
		fi
	;;
	g) # check for AP updates
		download_current_fw_list
		[ $? -ne 0 ] && exit_fwman 1
		[ ! -d "$FWDIR" ] && mkdir $FWDIR
		[ ! -e "$WWWDIR$FWDIR" ] && ln -s $FWDIR $WWWDIR$FWDIR
		[ ! -f "$MODELS_CONFIG" ] && touch "$MODELS_CONFIG"
		# CHeck to see if this is a controller
		[ ! -f "$CONTROLLER_CONFIG" ] && exit_fwman 0
		config_load luxulacs
		config_foreach compare_firmware_rev cpe
	;;
	*)
		echo "Invalid option: -$opt"
	;;
	esac
done
[ "$commit_req" -ne 0 ] && uci commit models
exit_fwman $err_cnt

