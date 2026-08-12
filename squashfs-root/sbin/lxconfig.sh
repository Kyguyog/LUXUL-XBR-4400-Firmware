#!/bin/sh

CONFIG_DIR="/etc/config"
WORKING_DIR="/tmp"
TMP_DIR="/tmp/lxc"
CONFIG_LST="/tmp/config.lst"
LUXUL_HDR="### Luxul Configuration Backup"

backup_to_file() {
    local config_file=$WORKING_DIR/$1
    [ -d "$TMP_DIR" ] && rm -rf $TMP_DIR
    mkdir -p $TMP_DIR
    cp $CONFIG_DIR/* $TMP_DIR

    # add blacklisting of keys here

    #get list of configs
    [ -f "$CONFIG_LST" ] && rm -f $CONFIG_LST
    ls $TMP_DIR > $CONFIG_LST

    [ -f $config_file ] && rm $config_file
    touch $config_file
    cat <<- EOF > $config_file
	### Luxul Configuration Backup
	### $(date +"%D %T")
	### Model: $hw_model
	### FW Version: $fw_version
	!!! editing this file may result in non-functional restore !!!

	$hw_model
	$fw_version
	EOF

    while read package; do
        uci export -c $TMP_DIR $package >> $config_file
    done < $CONFIG_LST

    rm -rf $TMP_DIR
    rm -f $CONFIG_LST
    echo "Backup Complete"
}

restore_from_file() {
    cp $WORKING_DIR/$1 $WORKING_DIR/$1.tmp
    local config_file=$WORKING_DIR/$1.tmp
    local force=$2
    [ "$(head -n1 $config_file)" != "$LUXUL_HDR" ] && exit 1
    sed -i '1,6d' $config_file
    [ "$(head -n1 $config_file)" != "$hw_model" ] && exit 2
    sed -i 1d $config_file
    [ "$(head -n1 $config_file)" != "$fw_version" ] && [ $force -eq 0 ] && exit 3
    sed -i 1d $config_file
    uci import -f $config_file
    rm -f $config_file
    echo "Restore Complete"

}


hw_model=$(uci get -q luxul.static.hw_model)
fw_version=$(uci get -q luxul.static.fw_version)

while getopts ":b:r:f:" opt; do
    case $opt in
    b)
        backup_to_file $OPTARG
        ;;
    r)
        restore_from_file $OPTARG 0
        ;;
    f)
        restore_from_file $OPTARG 1
        ;;
    esac
done
exit 0

