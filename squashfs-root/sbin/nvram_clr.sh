#!/bin/sh
nvram show  > /tmp/nvram.dump
envram show  > /tmp/envram.dump

echo "$0: Erasing existing nvram entries"
while IFS='=' read var val
do
	if [ "$var" != "opo" ]	&& \
	   [ "$var" != "sdram_init" ] && \
	   [ "$var" != "sdram_ncdl" ] && \
	   [ "$var" != "sdram_refresh" ] && \
	   [ "$var" != "pmon_ver" ]
	then
		nvram unset "$var"
	fi
done < /tmp/nvram.dump

echo "$0: Copying nvram default values"
while IFS='=' read var val
do
	nvram set "$var=$val"
done < /tmp/envram.dump

nvram set boot_wait=off

nvram commit
rm -f /tmp/nvram.dump /tmp/envram.dump

